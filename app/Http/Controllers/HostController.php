<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use App\Models\Notification;
use App\Models\Property;
use Illuminate\Support\Facades\Auth;
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
        BookingController::updateBookingStatuses();
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
        // Verify authorization and booking status in one check
        if ($booking->property->user_id !== auth()->id()) {
            Log::warning('Unauthorized booking acceptance attempt', [
                'booking_id' => $booking->id,
                'user_id' => auth()->id()
            ]);
            return response()->json(['message' => 'Unauthorized action'], 403);
        }

        if ($booking->book_status !== 'pending') {
            $message = $booking->book_status === 'accepted'
                ? 'Booking is already accepted'
                : 'Only pending bookings can be accepted';

            Log::info('Invalid booking status change attempt', [
                'booking_id' => $booking->id,
                'current_status' => $booking->book_status
            ]);

            return response()->json(['message' => $message], 400);
        }

        try {
            DB::transaction(function () use ($booking) {
                $booking->update([
                    'book_status' => 'accepted',
                    'approved_at' => now()
                ]);

                Notification::create([
                    'notif_type' => 'accept_booking',
                    'notif_message' => 'Accepted Booking For ' . $booking->property->title,
                    'notif_is_read' => false,
                    'notif_sender_id' => auth()->id(),
                    'notif_receiver_id' => $booking->user_id, // Changed from user->user_id
                    'prop_id' => $booking->property_id,      // Changed from property->property_id
                ]);

                Log::info('Booking accepted successfully', [
                    'booking_id' => $booking->id,
                    'approved_by' => auth()->id()
                ]);
            });

            return response()->json(['message' => 'Booking approved successfully']);

        } catch (\Exception $e) {
            Log::error('Booking acceptance failed', [
                'booking_id' => $booking->id,
                'error' => $e->getMessage()
            ]);
            return response()->json(['message' => 'Failed to approve booking'], 500);
        }
    }

    public function cancelBooking(Booking $booking)
    {
        // Verify the booking belongs to the authenticated host
        if ($booking->property->user_id !== auth()->id()) {
            return response()->json([
                'success' => false,
                'message' => 'Unauthorized action'
            ], 403);
        }

        // Check if booking is pending
        if ($booking->book_status !== 'pending') {
            return response()->json([
                'success' => false,
                'message' => 'Only pending bookings can be declined'
            ], 400);
        }

        try {
            // Update booking status
            $booking->update([
                'book_status' => 'declined',
                'declined_at' => now()
            ]);

            //Add notification
            Notification::create([
                'notif_type' => 'decline_booking',
                'notif_message' => 'Declined Booking For ' . $booking->property->title,
                'notif_is_read' => false,
                'notif_sender_id' => auth()->id(),
                'notif_receiver_id' => $booking->user->user_id,
                'prop_id' => $booking->property->property_id,
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Booking has been declined successfully'
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to decline booking: ' . $e->getMessage()
            ], 500);
        }
    }
    public function viewAcceptedBookings(){
        $bookings = Booking::with(['property', 'user'])
            ->whereHas('property', function($query) {
                $query->where('user_id', auth()->id());
            })
            ->where('book_status', 'accepted')
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
    public function viewCancelledBookings(){
        $bookings = Booking::with(['property', 'user'])
            ->whereHas('property', function($query) {
                $query->where('user_id', auth()->id());
            })
            ->where('book_status', 'cancelled')
            ->orderBy('book_date_created', 'desc')
            ->get();
        return view('pages.host.cancelled-bookings', compact('bookings'));
    }
}
