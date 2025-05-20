<?php

namespace App\Http\Controllers;

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

    public function viewPendingBookings(){
        $properties = Property::with(['images', 'amenities'])
            ->where('user_id', auth()->id())
            ->get();
        return view('pages.host.pending-bookings');
    }
    public function viewAcceptedBookings(){
        $properties = Property::with(['images', 'amenities'])
            ->where('user_id', auth()->id())
            ->get();
        return view('pages.host.accepted-bookings');
    }
    public function viewCompletedBookings(){
        $properties = Property::with(['images', 'amenities'])
            ->where('user_id', auth()->id())
            ->get();
        return view('pages.host.completed-bookings');
    }
    public function viewCancelledBookings(){
        $properties = Property::with(['images', 'amenities'])
            ->where('user_id', auth()->id())
            ->get();
        return view('pages.host.cancelled-bookings');
    }
}
