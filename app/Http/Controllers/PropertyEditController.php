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
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;

class PropertyEditController extends Controller
{
    public function viewEditType(Property $property)
    {

        $types = Type::all();
        return view('pages.host.edit-property-type', compact('types', 'property'));
    }
    public function updateType(Request $request, Property $property)
    {
        $validated = $request->validate([
            'prop_type' => 'required|string|exists:type,type_name', // Changed to validate type_name
        ]);

        try {
            // Get current draft or create new
            $draftData = session()->get('property_draft', []);

            // Update just the property type name
            $draftData['prop_type'] = $validated['prop_type'];

            // Save back to session
            session()->put('property_draft', $draftData);

            return response()->json(['success' => true]);
        } catch (\Exception $e) {
            Log::error('Error updating property type: ' . $e->getMessage());
            return response()->json(['success' => false, 'message' => 'Failed to update property type'], 500);
        }
    }
    public function viewEditLocation(Property $property)
    {
        return view('pages.host.edit-property-location', compact('property'));
    }
    public function updateLocation(Request $request, Property $property)
    {
        $validated = $request->validate([
            'street_address' => 'required|string',
            'city' => 'required|string',
            'province' => 'required|string',
        ]);

        $fullAddress = $validated['street_address'] . ', ' . $validated['city'] . ', ' . $validated['province'];

        try {
            $draftData = session()->get('property_draft', []);
            $draftData['location'] = [
                'street_address' => $validated['street_address'],
                'city' => $validated['city'],
                'province' => $validated['province'],
                'full_address' => $fullAddress
            ];
            session()->put('property_draft', $draftData);
            return response()->json(['success' => true]);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => 'Failed to update location'], 500);
        }
    }

    public function viewEditCapacity(Property $property)
    {
        return view('pages.host.edit-property-capacity', compact('property'));
    }
    public function updateCapacity(Request $request, Property $property)
    {
        $validated = $request->validate([
            'prop_room_count' => 'required|integer|min:1',
            'prop_max_guest' => 'required|integer|min:1',
            'prop_bathroom_count' => 'required|integer|min:1',
        ]);

        try {
            $draftData = session()->get('property_draft', []);
            $draftData['capacity'] = $validated;
            session()->put('property_draft', $draftData);

            return response()->json(['success' => true]);
        } catch (\Exception $e) {
            Log::error('Error updating capacity: ' . $e->getMessage());
            return response()->json(['success' => false, 'message' => 'Failed to update capacity'], 500);
        }
    }

// Your existing saveAllUpdates method will handle the final save
    public function viewEditDescription(Property $property)
    {
        return view('pages.host.edit-property-description', compact('property'));
    }
    public function updateDescription(Request $request, Property $property)
    {
        $validated = $request->validate([
            'prop_title' => 'required|string|max:255',
            'prop_description' => 'required|string',
        ]);

        try {
            $draftData = session()->get('property_draft', []);
            $draftData['description'] = $validated;
            session()->put('property_draft', $draftData);

            return response()->json(['success' => true]);
        } catch (\Exception $e) {
            Log::error('Error updating description: ' . $e->getMessage());
            return response()->json(['success' => false, 'message' => 'Failed to update description'], 500);
        }
    }

// Your existing saveAllUpdates method will handle the final save
    public function viewEditAmenities(Property $property)
    {
        $amenities = Amenity::all()->groupBy('amn_type');
        $propertyAmenities = PropertyAmenity::where('prop_id', $property->prop_id)->get();
        return view('pages.host.edit-property-amenities', compact('property', 'amenities', 'propertyAmenities'));
    }
    public function updateAmenities(Request $request, Property $property)
    {
        $validated = $request->validate([
            'amenities' => 'sometimes|array',
            'amenities.*' => 'exists:amenities,amn_id',
        ]);

        try {
            $draftData = session()->get('property_draft', []);
            $draftData['amenities'] = $validated['amenities'] ?? [];
            session()->put('property_draft', $draftData);

            return response()->json(['success' => true]);
        } catch (\Exception $e) {
            Log::error('Error updating amenities: ' . $e->getMessage());
            return response()->json(['success' => false, 'message' => 'Failed to update amenities'], 500);
        }
    }

// Your existing saveAllUpdates method will handle the final save
    public function viewEditPictures(Property $property)
    {
        $propertyImages = PropertyImage::where('prop_id', $property->prop_id)->get();
        return view('pages.host.edit-property-pictures', compact('property', 'propertyImages'));
    }
    public function updatePictures(Request $request, Property $property)
    {
        try {
            Log::info('Starting updatePictures method', ['property_id' => $property->id]);

            $validated = $request->validate([
                'images' => 'sometimes|array',
                'images.*' => 'image|mimes:jpeg,png,jpg,gif|max:10240',
            ]);
            Log::debug('Validation passed', ['validated' => $validated]);

            $draftData = session()->get('property_draft', []);
            Log::debug('Initial draft data', ['draftData' => $draftData]);

            // Handle new file uploads
            $uploadedImages = [];
            if ($request->hasFile('images')) {
                Log::info('Found uploaded files', ['file_count' => count($request->file('images'))]);

                foreach ($request->file('images') as $index => $image) {
                    try {
                        $path = $image->store('property_images', 'public');
                        $uploadedImages[] = $path;
                        Log::debug("Stored image $index", ['path' => $path]);
                    } catch (\Exception $e) {
                        Log::error("Failed to store image $index", [
                            'error' => $e->getMessage(),
                            'file_name' => $image->getClientOriginalName()
                        ]);
                    }
                }
            } else {
                Log::debug('No new files uploaded');
            }

            // Get current images (from session or database)
            $currentImages = $draftData['images'] ?? $property->images->pluck('img_url')->toArray();
            Log::debug('Current images before processing', [
                'currentImages' => $currentImages,
                'source' => isset($draftData['images']) ? 'session' : 'database'
            ]);

            $removedImages = $draftData['removed_images'] ?? [];
            Log::debug('Removed images', ['removedImages' => $removedImages]);

            // Merge images (excluding removed ones)
            $draftData['images'] = array_merge(
                array_diff($currentImages, $removedImages),
                $uploadedImages
            );
            Log::debug('Merged image data', ['mergedImages' => $draftData['images']]);

            session()->put('property_draft', $draftData);
            Log::info('Draft data updated successfully', ['image_count' => count($draftData['images'])]);

            return response()->json(['success' => true]);
        } catch (\Exception $e) {
            Log::error('Error updating pictures', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
                'request_data' => $request->all()
            ]);
            return response()->json(['success' => false, 'message' => 'Failed to update pictures'], 500);
        }
    }

    public function markImageForRemoval(Request $request, Property $property)
    {
        try {
            $validated = $request->validate([
                'image_path' => 'required|string'
            ]);

            $draftData = session()->get('property_draft', []);

            // Add to removed images list
            $removedImages = $draftData['removed_images'] ?? [];
            if (!in_array($validated['image_path'], $removedImages)) {
                $removedImages[] = $validated['image_path'];
                $draftData['removed_images'] = $removedImages;
                session()->put('property_draft', $draftData);
            }

            return response()->json(['success' => true]);
        } catch (\Exception $e) {
            Log::error('Error marking image for removal: ' . $e->getMessage());
            return response()->json(['success' => false], 500);
        }
    }

    public function viewEditPrice(Property $property)
    {
        return view('pages.host.edit-property-price', compact('property'));
    }
    public function updatePrice(Request $request, Property $property)
    {
        $validated = $request->validate([
            'prop_price_per_night' => 'required|numeric|min:1'
        ]);

        try {
            $draftData = session()->get('property_draft', []);
            $draftData['price'] = [
                'prop_price_per_night' => $validated['prop_price_per_night']
            ];
            session()->put('property_draft', $draftData);

            return response()->json(['success' => true]);
        } catch (\Exception $e) {
            Log::error('Error updating price: ' . $e->getMessage());
            return response()->json(['success' => false, 'message' => 'Failed to update price'], 500);
        }
    }
    public function viewEditRules(Property $property)
    {
        return view('pages.host.edit-property-rules', compact('property'));
    }
    public function updateRules(Request $request, Property $property)
    {
        // Enhanced validation with custom error messages
        $validated = $request->validate([
            // House Rules
            'no_smoking' => 'required|boolean',
            'no_pets' => 'required|boolean',
            'no_parties' => 'required|boolean',
            'check_in_time' => [
                'required',
                'integer',
                'between:0,23',
                function ($attribute, $value, $fail) {
                    if ($value < 0 || $value > 23) {
                        $fail('The check-in time must be between 0 and 23.');
                    }
                }
            ],
            'check_out_time' => [
                'required',
                'integer',
                'between:0,23',
                function ($attribute, $value, $fail) use ($request) {
                    if ($value < 0 || $value > 23) {
                        $fail('The check-out time must be between 0 and 23.');
                    }
                    // Ensure check-out is after check-in
                    if ($value <= $request->check_in_time) {
                        $fail('Check-out time must be after check-in time.');
                    }
                }
            ],

            // Guest Safety
            'has_security_camera' => 'required|boolean',
            'has_carbon_monoxide_alarm' => 'required|boolean',
            'must_climb_stairs' => 'required|boolean',

            // Cancellation Policy
            'has_cancellation_fee' => 'required|in:yes,no',
            'cancellation_rate' => [
                'required_if:has_cancellation_fee,yes',
                'numeric',
                'min:0',
                'max:100',
                function ($attribute, $value, $fail) use ($request) {
                    if ($request->has_cancellation_fee === 'yes' && ($value < 0 || $value > 100)) {
                        $fail('Cancellation rate must be between 0% and 100%.');
                    }
                }
            ]
        ], [
            'check_in_time.between' => 'Check-in time must be between 0 (12 AM) and 23 (11 PM)',
            'check_out_time.between' => 'Check-out time must be between 0 (12 AM) and 23 (11 PM)',
            'cancellation_rate.required_if' => 'Cancellation rate is required when cancellation fee is enabled'
        ]);

        try {
            $draftData = session()->get('property_draft', []);

            // Enhanced data mapping with additional business logic
            $rulesData = [
                'prop_id' => $property->prop_id,
                'rule_check_in' => (int)$validated['check_in_time'],
                'rule_check_out' => (int)$validated['check_out_time'],
                'rule_no_smoking' => (bool)$validated['no_smoking'],
                'rule_no_pet' => (bool)$validated['no_pets'],
                'rule_no_events' => (bool)$validated['no_parties'],
                'rule_security_cam' => (bool)$validated['has_security_camera'],
                'rule_alarm' => (bool)$validated['has_carbon_monoxide_alarm'],
                'rule_stairs' => (bool)$validated['must_climb_stairs'],
                'rule_cancellation' => $validated['has_cancellation_fee'],
                'rule_cancellation_rate' => $validated['has_cancellation_fee'] === 'yes'
                    ? (float)$validated['cancellation_rate']
                    : null,
                'updated_at' => now() // Track when these rules were last updated
            ];

            // Merge with existing draft data
            $draftData['rules'] = array_merge($draftData['rules'] ?? [], $rulesData);

            // Calculate and store any derived fields
            $draftData['rules']['rule_strictness'] = $this->calculateRulesStrictness($rulesData);

            session()->put('property_draft', $draftData);

            return response()->json([
                'success' => true,
                'data' => $rulesData,
                'message' => 'Rules updated successfully',
                'strictness_level' => $draftData['rules']['rule_strictness'] ?? null
            ]);

        } catch (\Exception $e) {
            Log::error('Error updating rules for property ' . $property->prop_id, [
                'error' => $e->getMessage(),
                'request' => $request->all(),
                'trace' => $e->getTraceAsString()
            ]);

            return response()->json([
                'success' => false,
                'message' => 'Failed to update rules. Please try again.',
                'error_details' => config('app.debug') ? $e->getMessage() : null
            ], 500);
        }
    }

    /**
     * Calculate a "strictness" score based on rules configuration
     */
    private function calculateRulesStrictness(array $rulesData): int
    {
        $score = 0;

        // Add points for strict rules
        if ($rulesData['rule_no_smoking']) $score += 20;
        if ($rulesData['rule_no_pet']) $score += 20;
        if ($rulesData['rule_no_events']) $score += 30;
        if ($rulesData['rule_security_cam']) $score += 15;

        // Add points for cancellation policy
        if ($rulesData['rule_cancellation'] === 'yes') {
            $score += min(15, $rulesData['rule_cancellation_rate']);
        }

        return min(100, $score); // Cap at 100
    }
    public function saveAllUpdates(Request $request, Property $property)
    {
        DB::beginTransaction();
        try {
            $draftData = session()->get('property_draft', []);

            // 1. Update Property Type
            if (!empty($draftData['prop_type'])) {
                $type = Type::where('type_name', $draftData['prop_type'])->first();
                if ($type) {
                    $property->type_id = $type->type_id;
                }
            }

            // 2. Update Location
            if (!empty($draftData['location'])) {
                $property->prop_address = $draftData['location']['full_address'];
            }

            // 3. Update Capacity
            if (!empty($draftData['capacity'])) {
                $property->prop_room_count = $draftData['capacity']['prop_room_count'];
                $property->prop_max_guest = $draftData['capacity']['prop_max_guest'];
                $property->prop_bathroom_count = $draftData['capacity']['prop_bathroom_count'];
            }

            // 4. Update Description
            if (!empty($draftData['description'])) {
                $property->prop_title = $draftData['description']['prop_title'];
                $property->prop_description = $draftData['description']['prop_description'];
            }

            // 5. Update Price
            if (!empty($draftData['price'])) {
                $property->prop_price_per_night = $draftData['price']['prop_price_per_night'];
            }

            // Save the property updates
            $property->save();

            // 6. Update Amenities
            if (!empty($draftData['amenities'])) {
                // Delete existing amenities
                PropertyAmenity::where('prop_id', $property->prop_id)->delete();

                // Add new amenities
                foreach ($draftData['amenities'] as $amenityId) {
                    PropertyAmenity::create([
                        'prop_id' => $property->prop_id,
                        'amn_id' => $amenityId
                    ]);
                }
            }

            // 7. Update Rules
            if (!empty($draftData['rules'])) {
                PropertyRules::updateOrCreate(
                    ['prop_id' => $property->prop_id],
                    $draftData['rules']
                );
            }

            // 8. Handle Images
            if (!empty($draftData['images'])) {
                // Delete images marked for removal
                $removedImages = $draftData['removed_images'] ?? [];
                PropertyImage::where('prop_id', $property->prop_id)
                    ->whereIn('img_url', $removedImages)
                    ->delete();

                // Delete the actual files for removed images
                foreach ($removedImages as $imagePath) {
                    Storage::disk('public')->delete($imagePath);
                }

                // Add new images
                $existingImages = $property->images->pluck('img_url')->toArray();
                $newImages = array_diff($draftData['images'], $existingImages);

                foreach ($newImages as $imagePath) {
                    PropertyImage::create([
                        'prop_id' => $property->prop_id,
                        'img_url' => $imagePath
                    ]);
                }
            }

            DB::commit();

            // Clear the session draft
            session()->forget('property_draft');

            return response()->json([
                'success' => true,
                'redirect' => route('host.listing')
            ]);

        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Error saving all updates: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Failed to save all updates',
                'error' => $e->getMessage() // Remove in production if sensitive
            ], 500);
        }
    }
}
