<?php

namespace App\Http\Controllers;

use App\Models\Amenity;
use App\Models\Property;
use App\Models\Type;
use Illuminate\Http\Request;

class PropertyController extends Controller
{
    /**
     * Display a listing of properties.
     *
     * @return \Illuminate\Contracts\View\View|\Illuminate\Foundation\Application|\Illuminate\Contracts\View\Factory
     */
    public function index()
    {
        // Fetch properties with their images, hosts, and amenities
        $properties = Property::with(['images', 'host', 'amenities'])->get();

        return view('pages.home', compact('properties'));
    }

    /**
     * Show the details of a specific property.
     *
     * @param int $id
     * @return \Illuminate\Contracts\View\View|\Illuminate\Foundation\Application|\Illuminate\Contracts\View\Factory
     */
    public function show($id)
    {
        // Fetch the property with its images, host, and amenities
        $property = Property::with(['images', 'host', 'amenities'])
            ->findOrFail($id);

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
                'name' => $property->host->name,
                'role' => 'Property Handler', // Adjust based on your logic
                'image' => $property->host->profile_image_url ?? 'assets/images/default-host.jpg',
            ],
            'images' => [
                'main' => $property->images->first()?->img_url ?? 'assets/images/placeholder.jpg',
                'gallery' => $property->images->pluck('img_url')->toArray(),
            ],
            'amenities' => $property->amenities->map(function ($amenity) {
                return [
                    'icon' => $amenity->icon ?? 'default-icon', // Ensure you have an icon column in the amenities table
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

        return view('pages.property-details', compact('data'));
    }
}
