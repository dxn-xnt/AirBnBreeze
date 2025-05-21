<?php

namespace App\Http\Controllers;

use App\Models\Amenity;
use App\Models\PropertyRules;
use App\Models\Type;
use App\Models\User;
use Illuminate\Http\Request;
use App\Models\Property;
use App\Models\PropertyImage;
use App\Models\PropertyAmenity;
use Illuminate\Support\Facades\DB;
use function Laravel\Prompts\warning;
use Illuminate\Support\Facades\Log;

class PropertyCreationController extends Controller
{
    public function createProperty_starter()
    {
        return view('pages.add-property-starter');
    }

    // Step 1: Show property type selection
    public function createProperty_step1()
    {
        $types = Type::all();
        return view('pages.add-identify-property', compact('types'));
    }

    public function storePropertyType(Request $request)
    {
        // Validate the input
        $validated = $request->validate([
            'prop_type' => 'required|string',
        ]);

        // Store the selected property type in the session
        session()->put('property_data.prop_type', $validated['prop_type']);

        // Redirect to the next step
        return redirect()->route('property.step2');
    }

    // Step 2: Show location form
    public function createProperty_step2()
    {
        return view('pages.add-location-property');
    }

// Step 2: Store location
    public function storeLocation(Request $request)
    {
        // Validate the input
        $validated = $request->validate([
            'street_address' => 'required|string',
            'city' => 'required|string',
            'province' => 'required|string',
        ]);

        // Concatenate the address fields into a single string
        $fullAddress = trim(
            $validated['street_address'] . ', ' .
            $validated['city'] . ', ' .
            $validated['province']
        );

        // Store the concatenated address in the session
        session()->put('property_data.prop_address', $fullAddress);

        // Redirect to the next step
        return redirect()->route('property.step3');
    }

    // Step 3: Show capacity form
    public function createProperty_step3()
    {
        return view('pages.add-capacity-property');
    }

// Step 3: Store capacity
    public function storeCapacity(Request $request)
    {
        // Validate the input
        $validated = $request->validate([
            'prop_max_guest' => 'required|integer|min:1', // Minimum value is 1
            'prop_room_count' => 'required|integer|min:1', // Minimum value is 1
            'prop_bathroom_count' => 'required|integer|min:1', // Minimum value is 1
        ]);

        // Store the validated data in the session
        session()->put('property_data.prop_max_guest', $validated['prop_max_guest']);
        session()->put('property_data.prop_room_count', $validated['prop_room_count']);
        session()->put('property_data.prop_bathroom_count', $validated['prop_bathroom_count']);

        // Redirect to the next step
        return redirect()->route('property.step4');
    }
// Step 4: Show description form
    public function createProperty_step4()
    {
        return view('pages.add-description-highlights');
    }

// Step 4: Store description
    public function storeDescription(Request $request)
    {
        // Validate the input
        $validated = $request->validate([
            'prop_title' => 'required|string|max:255',
            'prop_description' => 'required|string',
        ]);

        // Store the validated data in the session
        session()->put('property_data.prop_title', $validated['prop_title']);
        session()->put('property_data.prop_description', $validated['prop_description']);

        // Redirect to the next step
        return redirect()->route('property.step5');
    }

    public function createProperty_step5()
    {
        $amenities = Amenity::all()->groupBy('amn_type');
        return view('pages.add-amenities-highlights', compact('amenities'));
    }

    // Step 5: Store amenities
    public function storeAmenities(Request $request)
    {
        $validated = $request->validate([
            'amenities' => 'required|array',
            'amenities.*' => 'integer|exists:amenities,amn_id',
        ]);

        // Store only amenities with IDs
        $amenitiesData = [];
        foreach ($validated['amenities'] as $amenityId) {
            $amenitiesData[] = ['id' => $amenityId];
        }

        session()->put('property_amenities', $amenitiesData);
        return redirect()->route('property.step6');
    }

    // Step 6: Show pictures form
    public function createProperty_step6()
    {
        return view('pages.add-pictures-highlights');
    }

    public function storePictures(Request $request)
    {
        try {
            // Validate the input
            $validated = $request->validate([
                'images.*' => 'required|image|mimes:jpeg,png,gif|max:10240', // 10MB limit
            ]);

            // Ensure at least 5 images are uploaded
            $uploadedImages = $request->file('images'); // Get the uploaded files as an array
            if (count($uploadedImages) < 5) {
                return redirect()->back()->withErrors(['images' => 'At least 5 images are required.']);
            }

            // Retrieve existing images from session or initialize an empty array
            $existingImages = session()->get('property_images', []);

            // Handle file uploads
            foreach ($uploadedImages as $image) {
                $path = $image->store('property-images', 'public'); // Store image
                $existingImages[] = $path; // ✅ Only store the relative file path
            }

            // Store updated image paths in session
            session()->put('property_images', $existingImages);

            // Redirect to the next step
            return redirect()->route('property.step7');
        } catch (\Exception $e) {
            \Log::error('Error storing images: ' . $e->getMessage());
            return redirect()->back()->withErrors(['images' => 'An error occurred while storing images.']);
        }
    }

// Endpoint to remove an image from the session
    public function removeImage(Request $request, $index)
    {
        $existingImages = session()->get('property_images', []);

        // Remove the image at the specified index
        if (isset($existingImages[$index])) {
            unset($existingImages[$index]);
            $existingImages = array_values($existingImages); // Re-index the array
            session()->put('property_images', $existingImages);
            return response()->json(['success' => true]);
        }

        return response()->json(['success' => false]);
    }

    // Step 7: Price
    public function createProperty_step7()
    {
        return view('pages.add-price-highlights');
    }


    public function storePriceAndSave(Request $request)
    {
        // Validate price input
        $validated = $request->validate([
            'prop_price_per_night' => 'required|numeric|min:1|max:999999.99',
        ]);

        // Store price in session
        session()->put('property_data.prop_price_per_night', $validated['prop_price_per_night']);

        // Get all session data
        $propertyData = session('property_data', []);
        $amenitiesData = session('property_amenities', []);
        $imagesData = session('property_images', []);

        // 🔍 Debug: Print property data
        \Log::info('Property Data:', $propertyData);
        foreach ($propertyData as $property) {
            echo ($property) . ' ';
        }

        // Verify we have all required property data
        $requiredFields = [
            'prop_type' => 'string',
            'prop_address' => 'string',
            'prop_max_guest' => 'integer',
            'prop_room_count' => 'integer',
            'prop_bathroom_count' => 'integer',
            'prop_title' => 'string',
            'prop_description' => 'string',
            'prop_price_per_night' => 'numeric',
        ];

        foreach ($requiredFields as $field => $type) {
            if (!isset($propertyData[$field])) {
                return redirect()->route('property.step7')
                    ->with('error', "Missing required information. Please complete all steps.");
            }
        }

        // 🔍 Debug: Print Amenities Data
        \Log::info('Amenities Data:', ['amenities' => $amenitiesData]);

        // Verify we have amenities with IDs (not just custom amenities)
        $amenityIds = [];
        foreach ($amenitiesData as $amenity) {
            if (isset($amenity['id'])) {
                $amenityIds[] = $amenity['id'];
            }
        }

        if (empty($amenityIds)) {
            return redirect()->route('property.step5')
                ->with('error', 'Please select at least one standard amenity (custom amenities not supported in this version).');
        }

        // 🔍 Debug: Print Images Data
        \Log::info('Images Data:', ['images' => $imagesData]);

        // Verify images
        if (count($imagesData) < 5) {
            return redirect()->route('property.step6')
                ->with('error', 'Please upload at least 5 images.');
        }

        try {
            \DB::beginTransaction();

            // Create property
            $property = Property::create([
                'user_id' => auth()->id(),
                'prop_type' => $propertyData['prop_type'],
                'prop_address' => $propertyData['prop_address'],
                'prop_max_guest' => $propertyData['prop_max_guest'],
                'prop_room_count' => $propertyData['prop_room_count'],
                'prop_bathroom_count' => $propertyData['prop_bathroom_count'],
                'prop_title' => $propertyData['prop_title'],
                'prop_description' => $propertyData['prop_description'],
                'prop_price_per_night' => $propertyData['prop_price_per_night'],
                'prop_status' => 'Available',
                'prop_date_created' => now(),
            ]);

            // Save ONLY amenities with IDs
            foreach ($amenityIds as $amenityId) {
                PropertyAmenity::create([
                    'prop_id' => $property->prop_id,
                    'amn_id' => $amenityId
                ]);
            }

            // Save images
            foreach ($imagesData as $imagePath) {
                PropertyImage::create([
                    'prop_id' => $property->prop_id,
                    'img_url' => $imagePath,
                ]);
            }

            // Save default property rules
            PropertyRules::create([
                'prop_id' => $property->prop_id,
                'rule_check_in' => '13:00:00',
                'rule_check_out' => '12:00:00',
                'rule_no_smoking' => false,
                'rule_no_pet' => false,
                'rule_no_events' => false,
                'rule_security_cam' => false,
                'rule_alarm' => false,
                'rule_stairs' => false,
                'rule_cancellation' => false,
                'rule_cancellation_rate' => null,
            ]);

            $user = User::find(auth()->id());
            $user->user_is_host = true;
            $user->save();

            \DB::commit();

            // Clear session data
            session()->forget([
                'property_data',
                'property_amenities',
                'property_images'
            ]);

            return redirect()->route('home')
                ->with('success', 'Property created successfully!');

        } catch (\Exception $e) {
            \DB::rollBack();
            // 🔍 Log error
            \Log::error('Property Creation Failed:', ['error' => $e->getMessage()]);
            return redirect()->route('property.create')
                ->withInput()
                ->with('error', 'Failed to create property: ' . $e->getMessage());
        }
    }
}
