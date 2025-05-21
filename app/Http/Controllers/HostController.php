<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use App\Models\Property;

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
        // Verify the booking belongs to the authenticated host
        if ($booking->property->user_id !== auth()->id()) {
            return response()->json([
                'success' => false,
                'message' => 'Unauthorized action'
            ], 403);
        }

        // Check if booking is already accepted
        if ($booking->book_status === 'accepted') {
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
            // Update booking status
            $booking->update([
                'book_status' => 'accepted',
                'approved_at' => now()
            ]);

            // Send notification to guest
            $booking->user->notify(new BookingAccepted($booking));

            return response()->json([
                'success' => true,
                'message' => 'Booking has been approved successfully'
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to approve booking: ' . $e->getMessage()
            ], 500);
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
