<?php

namespace App\Http\Controllers;

use App\Models\PropertyAmenity;
use Illuminate\Http\Request;

class PropertyAmenityController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $propertyAmenities  = PropertyAmenity::all();

        // Wala pay views
        // return view()
    }

    /**
     * Display the specified resource.
     */
    public function show(PropertyAmenity $propertyAmenity)
    {
        // Wala pay views
        return view('PropertyAmenity.show', compact('propertyAmenity'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        // Wala pay views
        // return view(compact('id'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'amn_id' => 'required|integer',
        ]);

        PropertyAmenity::create($validated);

        return redirect()->route('property-amenities.index', $validated['prop_id'])
            ->with('success', 'Amenity added successfully!');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(PropertyAmenity $propertyAmenity)
    {
        // Wala pay views
        // return view('PropertyAmenity.edit', compact('propertyAmenity'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, PropertyAmenity $propertyAmenity)
    {
        $validated = $request->validate([
            'amn_id' => 'required|integer',
        ]);

        $propertyAmenity->update($validated);

        return redirect()->route('property-amenities.index', $propertyAmenity->prop_id)
            ->with('success', 'Amenity updated successfully!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(PropertyAmenity $propertyAmenity)
    {
        $propId = $propertyAmenity->prop_id;
        $propertyAmenity->delete();

        return redirect()->route('property-amenities.index', $propId)
            ->with('success', 'Amenity deleted successfully!');
    }
}

//
//namespace App\Http\Controllers;
//
//use Illuminate\Http\Request;
//
//class PropertyController extends Controller
//{
//    public function index()
//    {
//        $properties = [
//            [
//                'id' => 1,
//                'name' => 'Limosnero\'s Private House',
//                'location' => 'Minglanilla, Cebu',
//                'price' => 1900,
//                'rating' => 4.9,
//                'image' => 'assets/images/HOUSE (1).png',
//                'is_favorite' => true
//            ],
//            [
//                'id' => 2,
//                'name' => 'Limosnero\'s Private House',
//                'location' => 'Mactan, Cebu',
//                'price' => 2500,
//                'rating' => 4.7,
//                'image' => 'assets/images/HOUSE (2).png',
//                'is_favorite' => false
//            ],
//            [
//                'id' => 3,
//                'name' => 'Limosnero\'s Private House',
//                'location' => 'Busay, Cebu',
//                'price' => 1750,
//                'rating' => 4.8,
//                'image' => 'assets/images/HOUSE (3).png',
//                'is_favorite' => false
//            ],
//            [
//                'id' => 4,
//                'name' => 'Downtown Apartment',
//                'location' => 'Cebu City, Cebu',
//                'price' => 1550,
//                'rating' => 4.6,
//                'image' => 'assets/images/HOUSE (4).png',
//                'is_favorite' => true
//            ],
//            [
//                'id' => 5,
//                'name' => 'Garden Cottage',
//                'location' => 'Liloan, Cebu',
//                'price' => 1800,
//                'rating' => 4.9,
//                'image' => 'assets/images/HOUSE (6).png',
//                'is_favorite' => false
//            ],
//            [
//                'id' => 6,
//                'name' => 'Modern Condo',
//                'location' => 'IT Park, Cebu',
//                'price' => 2200,
//                'rating' => 4.8,
//                'image' => 'assets/images/HOUSE (7).png',
//                'is_favorite' => false
//            ],
//        ];
//
//        return view('pages.home', compact('properties'));
//    }
//
//    // Display the property details page
//
//    public function show($id)
//    {
//        $property = [
//            'id' => $id,
//            'name' => 'Limosnero\'s Private House',
//            'location' => 'Minglanilla, Cebu, Philippines',
//            'guests' => 5,
//            'rooms' => 2,
//            'bathrooms' => 1,
//            'rating' => 4.9,
//            'reviews' => 33,
//            'price' => 1900,
//            'description' => 'Fully functional One bedroom with up to 100 mbps Internet connection. Located in Amala Steps Mandale is A modern, clean and bright space which is close to the Mactan International Airport, Masyo Hotel and Medical Clinic and Public transportation to and from the city and northern province.',
//            'host' => [
//                'name' => 'Donesia Pacquio',
//                'role' => 'Property Handler',
//                'image' => 'assets/images/MD.png'
//            ],
//            'images' => [
//                'main' => 'assets/images/HOUSE (7).png',
//                'gallery' => [
//                    'assets/images/HOUSE (6).png',
//                    'assets/images/HOUSE (1).png',
//                    'assets/images/HOUSE (3).png',
//                    'assets/images/HOUSE (7).png'
//                ]
//            ],
//            'amenities' => [
//                ['name' => 'Wifi', 'icon' => 'wifi'],
//                ['name' => 'Workspace', 'icon' => 'monitor'],
//                ['name' => 'Kitchen', 'icon' => 'utensils'],
//                ['name' => 'Pool', 'icon' => 'droplets'],
//                ['name' => 'Television', 'icon' => 'tv'],
//                ['name' => 'Beach Area', 'icon' => 'waves'],
//                ['name' => 'Air Conditioning', 'icon' => 'snowflake'],
//                ['name' => 'First Aid Kit', 'icon' => 'briefcase-medical'],
//                ['name' => 'Gym', 'icon' => 'dumbbell'],
//                ['name' => 'Shower', 'icon' => 'shower-head'],
//                ['name' => 'Fire Extinguisher', 'icon' => 'flame']
//            ],
//            'rules' => [
//                'Check-in: After 2:00 PM',
//                'Checkout: 11:00 AM',
//                'No smoking',
//                'No pets allowed',
//                'No parties or events'
//            ],
//            'safety' => [
//                'Security camera/recording device',
//                'Carbon monoxide alarm',
//                'Smoke alarm',
//                'Must climb stairs'
//            ],
//            'cancellation' => [
//                'Free cancellation before May 15',
//                'Review the full policy'
//            ]
//        ];
//
//        return view('pages.property-details', compact('property'));
//    }
//}
