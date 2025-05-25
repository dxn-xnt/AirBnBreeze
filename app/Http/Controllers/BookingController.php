<?php

namespace App\Http\Controllers;

use App\Models\Notification;
use App\Models\Property;
use App\Models\Booking;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Redirect;

class BookingController extends Controller
{
    // Display the user's bookings
    public function index(Request $request, $category = null)
    {
        BookingController::updateBookingStatuses();
        // Get current user ID
        $userId = Auth::id();

        // Default to 'upcoming' if no category is provided
        if (!$category) {
            $category = 'upcoming';
        }

        // Validate that the category is valid
        if (!in_array($category, ['upcoming', 'pending', 'recent', 'cancelled', 'ongoing'])) {
            $category = 'upcoming';
        }

        // Fetch bookings based on the category
        $bookings = Booking::where('user_guest_id', $userId)
            ->when($category === 'upcoming', function ($query) {
                $query->where('book_status', 'upcoming');
            })
            ->when($category === 'pending', function ($query) {
                $query->where('book_status', 'pending');
            })
            ->when($category === 'recent', function ($query) {
                $query->orderByDesc('book_date_created')->take(5);
            })
            ->when($category === 'cancelled', function ($query) {
                $query->where('book_status', 'cancelled');
            })
            ->when($category === 'ongoing', function ($query) {
                $query->where('book_status', 'ongoing');
            })
            ->with(['property' => function ($query) {
                $query->with('images'); // Eager load images relationship
            }])
            ->get();

        return view('pages.bookings', compact('bookings', 'category'));
    }

    // Create a new booking request from a property
    public function book($property_id)
    {
        $property = Property::with(['host', 'images', 'amenities'])->findOrFail($property_id);

        return view('pages.request-booking', compact('property'));
    }

    // Process the final booking request
    public function processBooking(Request $request, $property_id)
    {
        // Validate request
        $request->validate([
            'start_date' => 'required|date',
            'end_date' => 'required|date|after:start_date',
            'total_cost' => 'required|numeric',
            'notes' => 'nullable|string',
            'book_adult_count' => 'required|integer|min:1',
            'book_child_count' => 'required|integer|min:0',
        ]);

        // Save to database
        $booking = Booking::create([
            'book_check_in' => $request->input('start_date'),
            'book_check_out' => $request->input('end_date'),
            'book_total_price' => $request->input('total_cost'),
            'book_notes' => $request->input('notes'),
            'book_adult_count' => $request->input('book_adult_count'),
            'book_child_count' => $request->input('book_child_count'),
            'prop_id' => $property_id,
            'user_guest_id' => Auth::id(),
            'book_status' => 'pending',
        ]);

        // Optional: Notification for guest
        Notification::create([
            'notif_type' => 'booking_confirmation',
            'notif_message' => 'Your booking request has been submitted',
            'notif_is_read' => false,
            'notif_sender_id' => $booking->property->user_id, // property owner
            'notif_receiver_id' => Auth::id(),
            'book_id' => $booking->book_id,
            'prop_id' => $property_id,
        ]);

        return redirect()->route('bookings.category', ['category' => 'pending'])
            ->with('success', 'Booking request submitted successfully.');
    }

    // Cancel a booking request (go back to property page)
    public function cancelRequest($property_id)
    {
        // Simply redirect back to property details
        return redirect()->route('property.show', $property_id);
    }

    // Show booking details
    public function show($id)
    {
        $booking = Booking::with(['property' => function ($query) {
            $query->with('images');
        }])->findOrFail($id);

        // Ensure the user can only view their own bookings
        if ($booking->user_guest_id !== Auth::id()) {
            abort(403, 'Unauthorized action.');
        }

        return view('pages.booking-details', compact('booking'));
    }

    // Cancel a booking
    public function cancel($id)
    {
        $booking = Booking::findOrFail($id);

        // Ensure the user can only cancel their own bookings
        if ($booking->user_guest_id !== Auth::id()) {
            abort(403, 'Unauthorized action.');
        }

        // Only allow cancellation for upcoming or pending bookings
        if (!in_array($booking->book_status, ['upcoming', 'pending'])) {
            return back()->with('error', 'This booking cannot be cancelled.');
        }

        // Update booking status to cancelled
        $booking->book_status = 'cancelled';
        $booking->save();

        return redirect()->route('bookings.category', ['category' => 'cancelled'])
            ->with('success', 'Booking has been cancelled successfully.');
    }

    public static function updateBookingStatuses(): void
    {
        $now = now()->format('Y-m-d H:i:s');

        // Get all bookings that need status updates
        $bookings = Booking::whereIn('book_status', ['accepted', 'ongoing'])
            ->orWhereNull('book_status')
            ->get();

        foreach ($bookings as $booking) {
            // Get property rules for this booking
            $rules = DB::table('property_rules')
                ->where('prop_id', $booking->prop_id)
                ->first();

            if (!$rules) continue;

            // Combine dates with times
            $checkIn = $booking->book_check_in . ' ' . $rules->rule_check_in;
            $checkOut = $booking->book_check_out . ' ' . $rules->rule_check_out;

            // Compare with current time
            if ($now >= $checkIn && $now <= $checkOut) {
                if ($booking->book_status != 'ongoing') {
                    $booking->update(['book_status' => 'ongoing']);
                }
            }
            elseif ($now > $checkOut) {
                if ($booking->book_status != 'completed') {
                    $booking->update(['book_status' => 'completed']);
                }
            }
        }
    }
}
