<?php

namespace App\Http\Controllers;

use App\Models\Amenity;
use App\Models\Property;
use Illuminate\Support\Facades\Auth;
use App\Models\PropertyAmenity;
use App\Models\PropertyImage;
use App\Models\PropertyRules;
use App\Models\Booking;
use App\Models\Type;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PropertyController extends Controller
{
    public function index()
    {
        session()->forget('search_results');
        BookingController::updateBookingStatuses();
        // Fetch properties with their images, hosts, and amenities
        $properties = Property::with(['images', 'host', 'amenities'])->get();
        return view('pages.home', compact('properties'));
    }



    public function show($id)
    {
        // Fetch the property with its images, host, and amenities
        $property = Property::with(['images', 'host', 'amenities'])->findOrFail($id);

        // Check if the authenticated user has already requested this property
        $userId = Auth::id();
        $hasRequested = false;

        if ($userId) {
            $hasRequested = Booking::where('user_guest_id', $userId)
                ->where('prop_id', $id)
                ->whereIn('book_status', ['pending', 'accepted'])
                ->exists();
        }

        // Prepare the data for the view
        $data = [
            'id' => $property->prop_id,
            'title' => $property->prop_title,
            'location' => $property->prop_address,
            'guests' => $property->prop_max_guest,
            'rooms' => $property->prop_room_count,
            'bathrooms' => $property->prop_bathroom_count,
            'rating' => $property->rating ?? 'N/A',
            'reviews' => $property->reviews_count ?? 0,
            'description' => $property->prop_description,
            'host' => [
                'name' => $property->host->user_fname . ' ' . $property->host->user_lname,
                'role' => 'Property Handler',
                'image' => $property->host->profile_image_url ?? 'assets/images/default-host.jpg',
                'phone' => $property->host->user_contact_number,
                'email' => $property->host->user_email,
            ],
            'images' => [
                'main' => $property->images->first()->img_url ?? 'assets/images/placeholder.jpg',
                'gallery' => $property->images->pluck('img_url')->toArray(),
            ],
            'amenities' => $property->amenities->map(function ($amenity) {
                return [
                    'icon' => $amenity->icon,
                    'name' => $amenity->name,
                ];
            })->toArray(),
            'rules' => [
                'Check-in: After 2:00 PM',
                'Checkout: 11:00 AM',
                'No smoking',
                'No pets allowed',
                'No parties or events',
            ],
            'safety' => [
                'Security camera/recording device',
                'Carbon monoxide alarm',
                'Smoke alarm',
                'Must climb stairs',
            ],
            'cancellation' => [
                'Free cancellation before May 15',
                'Review the full policy',
            ],
        ];

        return view('pages.property-details', compact('data', 'hasRequested'));
    }

    public function search(Request $request)
    {
        // Validate input fields
        $validated = $request->validate([
            'location' => 'required|string',
            'check_in' => 'required|date|after_or_equal:today',
            'check_out' => 'required|date|after:check_in',
            'rooms' => 'required|integer|min:1',
            'guests' => 'required|integer|min:1'
        ]);

        $checkIn = $validated['check_in'];
        $checkOut = $validated['check_out'];

        // Base query with filters
        $query = Property::with(['images', 'host', 'amenities'])
            ->where('prop_address', 'like', '%' . $validated['location'] . '%')
            ->where('prop_room_count', '>=', $validated['rooms'])
            ->where('prop_max_guest', '>=', $validated['guests']);

        // Filter out properties that have overlapping bookings using correct column names
        $query->whereNotIn('prop_id', function ($q) use ($checkIn, $checkOut) {
            $q->from('booking')
                ->select('prop_id')
                ->whereIn('book_status', ['accepted', 'ongoing', 'upcoming'])
                ->where(function ($query) use ($checkIn, $checkOut) {
                    $query->whereBetween('book_check_in', [$checkIn, $checkOut])
                        ->orWhereBetween('book_check_out', [$checkIn, $checkOut])
                        ->orWhere(function ($inner) use ($checkIn, $checkOut) {
                            $inner->where('book_check_in', '<=', $checkIn)
                                ->where('book_check_out', '>=', $checkOut);
                        });
                });
        });

        $properties = $query->get();

        // Debugging: See what's being returned
        // dd($properties); // Uncomment this line to check if data exists

        // Store results in session
        session([
            'search_results' => [
                'properties' => $properties,
                'params' => $validated,
                'timestamp' => now()
            ]
        ]);

        return view('pages.home', [
            'properties' => $properties,
            'searchParams' => $validated
        ]);
    }

    public function destroy(Property $property)
    {
        // Authorization check (only owner can delete)
        if ($property->user_id !== auth()->id()) {
            abort(403);
        }

        DB::transaction(function () use ($property) {
            // Delete related records first
            PropertyImage::where('prop_id', $property->prop_id)->delete();
            PropertyAmenity::where('prop_id', $property->prop_id)->delete();
            PropertyRules::where('prop_id', $property->prop_id)->delete();

            // Then delete the property
            $property->delete();
        });

        return response()->json(['success' => true]);
    }

}
