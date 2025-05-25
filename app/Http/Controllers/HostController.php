<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use App\Models\Notification;
use App\Models\Property;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class HostController extends Controller
{
    public function viewListing()
    {
        // Clear session
        session()->forget([
            'property_updates',
            'property_amenities',
            'property_rules',
            'property_images'
        ]);

        $properties = Property::with(['images', 'amenities'])
            ->where('user_id', auth()->id())
            ->get();

        return view('pages.host-properties', compact('properties'));
    }

    public function viewPendingBookings()
    {
        // Remove this line to stop automatic status updates
        // BookingController::updateBookingStatuses();

        $bookings = Booking::with(['property', 'user'])
            ->whereHas('property', function($query) {
                $query->where('user_id', auth()->id());
            })
            ->where('book_status', 'pending')
            ->orderBy('book_date_created', 'desc')
            ->get();

        return view('pages.host.pending-bookings', compact('bookings'));
    }
    public function acceptBooking(Booking $booking)
    {
        // Verify the booking belongs to the authenticated host
        if ($booking->property->user_id !== auth()->id()) {
            return response()->json([
                'success' => false,
                'message' => 'Unauthorized action'
            ], 403);
        }

        // Check if booking is already accepted
        if ($booking->book_status === 'accepted' || $booking->book_status === 'upcoming' || $booking->book_status === 'ongoing') {
            return response()->json([
                'success' => false,
                'message' => 'Booking is already accepted'
            ], 400);
        }

        // Check if booking is pending
        if ($booking->book_status !== 'pending') {
            return response()->json([
                'success' => false,
                'message' => 'Only pending bookings can be accepted'
            ], 400);
        }

        try {
            // Determine the appropriate status based on check-in date
            $checkInDate = \Carbon\Carbon::parse($booking->book_check_in);
            $today = \Carbon\Carbon::now();

            $newStatus = $checkInDate->isAfter($today) ? 'upcoming' : 'ongoing';

            try {
                // Create notification and store the created instance
                $notification = Notification::create([
                    'notif_type' => 'approve',
                    'notif_message' => 'Accepted Booking For ' . $booking->property->title, // Added property title
                    'notif_is_read' => false,
                    'notif_sender_id' => auth()->id(),
                    'notif_receiver_id' => $booking->user->user_id,
                    'book_id' => $booking->book_id,
                    'prop_id' => $booking->property->prop_id,
                ]);

            } catch (\Exception $e) {
                Log::channel('bookings')->error('Failed to create approval notification', [
                    'error' => $e->getMessage(),
                    'booking_id' => $booking->book_id,
                    'attempted_by' => auth()->id(),
                    'timestamp' => now()->toDateTimeString()
                ]);
                throw $e; // Re-throw if you want the error to bubble up
            }

            // Update booking status
            $booking->update([
                'book_status' => $newStatus
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Booking has been approved successfully',
                'new_status' => $newStatus
            ]);

        } catch (\Exception $e) {
            Log::error('Error approving booking: ' . $e->getMessage());

            return response()->json([
                'success' => false,
                'message' => 'Failed to approve booking'
            ], 500);
        }
    }

    public function cancelBooking(Booking $booking)
    {
        // Authorization check
        if ($booking->property->user_id !== auth()->id()) {
            return response()->json([
                'success' => false,
                'message' => 'Unauthorized action'
            ], 403);
        }

        // Validate booking status
        if (!in_array($booking->book_status, ['pending', 'upcoming', 'ongoing'])) {
            return response()->json([
                'success' => false,
                'message' => 'This booking cannot be cancelled.'
            ], 400);
        }

        try {
            DB::transaction(function () use ($booking) {
                // Update booking status
                $booking->update(['book_status' => 'cancelled']);

                // Create notification
                $notification = Notification::create([
                    'notif_type' => 'cancelled',  // Changed from 'decline' to 'cancelled'
                    'notif_message' => 'Booking Cancelled For ' . $booking->property->title,
                    'notif_is_read' => false,
                    'notif_sender_id' => auth()->id(),
                    'notif_receiver_id' => $booking->user->user_id,
                    'book_id' => $booking->book_id,
                    'prop_id' => $booking->property->prop_id,
                ]);
            });

            return response()->json([
                'success' => true,
                'message' => 'Booking has been cancelled successfully'
            ]);

        } catch (\Exception $e) {
            Log::channel('bookings')->error('Booking cancellation failed', [
                'booking_id' => $booking->book_id,
                'error' => $e->getMessage(),
                'timestamp' => now()->toDateTimeString()
            ]);

            return response()->json([
                'success' => false,
                'message' => 'Failed to cancel booking: ' . $e->getMessage()
            ], 500);
        }
    }

    public function declineBooking(Booking $booking)
    {
        if ($booking->property->user_id !== auth()->id()) {
            return response()->json([
                'success' => false,
                'message' => 'Unauthorized action'
            ], 403);
        }

        if ($booking->book_status === 'declined') {
            return response()->json([
                'success' => false,
                'message' => 'Booking is already cancelled'
            ], 400);
        }

        try {
            $booking->update(['book_status' => 'declined']);
            return response()->json([
                'success' => true,
                'message' => 'Booking has been declined.',
                'bookingId' => $booking->book_id
            ]);
        } catch (\Exception $e) {
            \Log::error('Error cancelling booking: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Failed to decline booking'
            ], 500);
        }
    }

    public function viewAcceptedBookings()
    {
        $userId = auth()->id();

        // Fetch all accepted bookings
        $bookings = Booking::with(['property', 'user'])
            ->whereHas('property', function ($query) use ($userId) {
                $query->where('user_id', $userId);
            })
            ->whereIn('book_status', ['upcoming', 'ongoing'])
            ->orderBy('book_date_created', 'desc')
            ->get();

        return view('pages.host.accepted-bookings', compact('bookings'));
    }
    public function viewOngoingBookings(){
        $bookings = Booking::with(['property', 'user'])
            ->whereHas('property', function($query) {
                $query->where('user_id', auth()->id());
            })
            ->where('book_status', 'ongoing')
            ->orderBy('book_date_created', 'desc')
            ->get();
        return view('pages.host.ongoing-bookings', compact('bookings'));
    }
    public function viewCompletedBookings(){
        $bookings = Booking::with(['property', 'user'])
            ->whereHas('property', function($query) {
                $query->where('user_id', auth()->id());
            })
            ->where('book_status', 'completed')
            ->orderBy('book_date_created', 'desc')
            ->get();
        return view('pages.host.completed-bookings', compact('bookings'));
    }
    public function viewCancelledBookings()
    {
        $userId = auth()->id();

        $bookings = Booking::with(['property', 'user'])
            ->whereHas('property', function ($query) use ($userId) {
                $query->where('user_id', $userId);
            })
            ->where('book_status', 'cancelled')
            ->orderBy('book_date_created', 'desc')
            ->get();

        return view('pages.host.cancelled-bookings', compact('bookings'));
    }
}
