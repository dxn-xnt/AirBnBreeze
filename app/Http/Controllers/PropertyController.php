<?php

namespace App\Http\Controllers;

use App\Models\Amenity;
use App\Models\Property;
use App\Models\Type;
use Illuminate\Http\Request;
use App\Http\Controllers\AmenityController;

class PropertyController extends Controller
{
    public function index()
    {
        $properties = Property::All();
        return view('pages.home', compact('properties'));
    }

    // Display the property details page

    public function show($id)
    {
        $property = [
            'id' => $id,
            'title' => 'Limosnero\'s Private House',
            'location' => 'Minglanilla, Cebu, Philippines',
            'guests' => 5,
            'rooms' => 2,
            'bathrooms' => 1,
            'rating' => 4.9,
            'reviews' => 33,
            'price' => 1900,
            'description' => 'Fully functional One bedroom with up to 100 mbps Internet connection. Located in Amala Steps Mandale is A modern, clean and bright space which is close to the Mactan International Airport, Masyo Hotel and Medical Clinic and Public transportation to and from the city and northern province.',
            'host' => [
                'name' => 'Donesia Pacquio',
                'role' => 'Property Handler',
                'image' => 'assets/images/MD.png'
            ],
            'images' => [
                'main' => 'assets/images/HOUSE (7).png',
                'gallery' => [
                    'assets/images/HOUSE (6).png',
                    'assets/images/HOUSE (1).png',
                    'assets/images/HOUSE (3).png',
                    'assets/images/HOUSE (7).png'
                ]
            ],
            'amenities' => [
                ['name' => 'Wifi', 'icon' => 'wifi'],
                ['name' => 'Workspace', 'icon' => 'monitor'],
                ['name' => 'Kitchen', 'icon' => 'utensils'],
                ['name' => 'Pool', 'icon' => 'droplets'],
                ['name' => 'Television', 'icon' => 'tv'],
                ['name' => 'Beach Area', 'icon' => 'waves'],
                ['name' => 'Air Conditioning', 'icon' => 'snowflake'],
                ['name' => 'First Aid Kit', 'icon' => 'briefcase-medical'],
                ['name' => 'Gym', 'icon' => 'dumbbell'],
                ['name' => 'Shower', 'icon' => 'shower-head'],
                ['name' => 'Fire Extinguisher', 'icon' => 'flame']
            ],
            'rules' => [
                'Check-in: After 2:00 PM',
                'Checkout: 11:00 AM',
                'No smoking',
                'No pets allowed',
                'No parties or events'
            ],
            'safety' => [
                'Security camera/recording device',
                'Carbon monoxide alarm',
                'Smoke alarm',
                'Must climb stairs'
            ],
            'cancellation' => [
                'Free cancellation before May 15',
                'Review the full policy'
            ]
        ];

        return view('pages.property-details', compact('property'));
    }


}
