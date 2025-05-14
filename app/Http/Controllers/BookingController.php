<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Redirect;

class BookingController extends Controller
{
    // Display the user's bookings
    public function index()
    {
        // Mock bookings data (in a real app, you would fetch this from a database)
        $bookings = [
            [
                'id' => 1,
                'property_id' => 3,
                'property_name' => 'Limosnero\'s Private House',
                'status' => 'upcoming',
                'image' => 'assets/images/HOUSE (3).png',
                'schedule' => [
                    'start_date' => 'April 24',
                    'end_date' => '30, 2025',
                ],
                'cost' => 1900,
                'notes' => '2 rooms, 10 guests, additional 3 beds',
            ],
            [
                'id' => 2,
                'property_id' => 2,
                'property_name' => 'Limosnero\'s Private House',
                'status' => 'upcoming',
                'image' => 'assets/images/HOUSE (2).png',
                'schedule' => [
                    'start_date' => 'April 24',
                    'end_date' => '30, 2025',
                ],
                'cost' => 1900,
                'notes' => '2 rooms, 10 guests',
            ],
        ];

        return view('pages.bookings', compact('bookings'));
    }

    // Create a new booking request from a property
    public function book($property_id)
    {
        $property = $this->getPropertyById($property_id);
        return view('pages.request-booking', compact('property'));
    }

    // Process the final booking request
    public function processBooking(Request $request, $property_id)
    {
        // In a real app, you would save the booking details to the database
        // For now, simply redirect to the bookings page
        return redirect()->route('bookings.index');
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
        // In a real app, you would fetch a specific booking
        return redirect()->route('bookings.index');
    }

    // Cancel a booking
    public function cancel($id)
    {
        // In a real app, you would cancel the booking in the database
        return redirect()->route('bookings.index');
    }

    // Helper method to get property data
    private function getPropertyById($id)
    {
        // In a real app, this would be from the database
        return [
            'id' => $id,
            'name' => 'Limosnero\'s Private House',
            'location' => 'Minglanilla, Cebu',
            'cost_per_night' => 1900,
            'rating' => 4.9,
            'images' => [
                'main' => 'assets/images/HOUSE (1).png',
                'gallery' => [
                    'assets/images/HOUSE (2).png',
                    'assets/images/HOUSE (3).png',
                    'assets/images/HOUSE (4).png',
                    'assets/images/HOUSE (5).png',
                ]
            ],
        ];
    }
}
