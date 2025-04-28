<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Redirect;

class BookingController extends Controller
{
    
     
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
    
    //Create a new booking from a property
     
    public function book($property_id)
    {
        return redirect()->route('bookings.index')->with('success', 'Booking created successfully!');
    }
    
    // Show booking details
    
    public function show($id)
    {
        // In a real app, you would fetch a specific booking
        return redirect()->route('bookings.index');
    }
    
    public function cancel($id)
    {
        // In a real app, you would cancel the booking in the database
        return redirect()->route('bookings.index')->with('success', 'Booking cancelled successfully!');
    }

    public function getBookingById($id){
        $booking = Booking::find($id);
        if($booking){
            return response()->json(["message" => "Successfully fetched data","data" => $booking], 200);
        }
        return response()->json(["message" => "ID doesnt exist"], 404);
    }
    public function updateBooking($id, Request $request){
        $booking = Booking::find($id);
        $booking->update($request->all());
    }
}