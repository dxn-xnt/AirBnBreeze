<?php

namespace App\Http\Controllers;

use App\Models\Amenity;
use App\Models\PropertyRules;
use App\Models\Type;
use Illuminate\Http\Request;
use App\Models\Property;
use App\Models\PropertyImage;
use App\Models\PropertyAmenity;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Session;
use Illuminate\Validation\ValidationException;

class PropertyEditController extends Controller
{
    // Type View and Update
    public function viewEditType(Property $property)
    {
        $types = Type::all();
        return view('pages.host.edit-property-type', compact('types', 'property'));
    }

    public function updateType(Request $request, Property $property)
    {
        $validated = $request->validate([
            'prop_type' => 'required|string|exists:type,type_name',
        ]);

        try {
            // Update session draft
            $draftData = session()->get('property_draft', []);
            $draftData['prop_type'] = $validated['prop_type'];
            session()->put('property_draft', $draftData);

            // Directly update prop_type
            $property->prop_type = $validated['prop_type'];
            $property->save();

            return response()->json(['success' => true]);
        } catch (\Exception $e) {
            Log::error('Error updating property type: ' . $e->getMessage());
            return response()->json(['success' => false, 'message' => 'Failed to update property type'], 500);
        }
    }

    // Location View and Update
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

        $fullAddress = "{$validated['street_address']}, {$validated['city']}, {$validated['province']}";

        try {
            $draftData = Session::get('property_draft', []);
            $draftData['location'] = [
                'street_address' => $validated['street_address'],
                'city' => $validated['city'],
                'province' => $validated['province'],
                'full_address' => $fullAddress
            ];
            Session::put('property_draft', $draftData);
            Session::save();

            return response()->json(['success' => true]);
        } catch (\Exception $e) {
            Log::error("Error updating location: " . $e->getMessage());
            return response()->json(['success' => false, 'message' => 'Failed to update location'], 500);
        }
    }

    // Capacity View and Update
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
            $draftData = Session::get('property_draft', []);
            $draftData['capacity'] = $validated;
            Session::put('property_draft', $draftData);
            Session::save();

            return response()->json(['success' => true]);
        } catch (\Exception $e) {
            Log::error("Error updating capacity: " . $e->getMessage());
            return response()->json(['success' => false, 'message' => 'Failed to update capacity'], 500);
        }
    }

    // Description View and Update
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
            $draftData = Session::get('property_draft', []);
            $draftData['description'] = $validated;
            Session::put('property_draft', $draftData);
            Session::save();

            return response()->json(['success' => true]);
        } catch (\Exception $e) {
            Log::error("Error updating description: " . $e->getMessage());
            return response()->json(['success' => false, 'message' => 'Failed to update description'], 500);
        }
    }

    // Amenities View and Update
    public function viewEditAmenities(Property $property)
    {
        $amenities = Amenity::all()->groupBy('amn_type');
        $propertyAmenities = PropertyAmenity::where('prop_id', $property->prop_id)->pluck('amn_id')->toArray();
        return view('pages.host.edit-property-amenities', compact('property', 'amenities', 'propertyAmenities'));
    }

    public function updateAmenities(Request $request, Property $property)
    {
        $validated = $request->validate([
            'amenities' => 'sometimes|array',
            'amenities.*' => 'exists:amenities,amn_id'
        ]);

        try {
            $draftData = Session::get('property_draft', []);
            $draftData['amenities'] = $validated['amenities'] ?? [];
            Session::put('property_draft', $draftData);
            Session::save();

            return response()->json(['success' => true]);
        } catch (\Exception $e) {
            Log::error("Error updating amenities: " . $e->getMessage());
            return response()->json(['success' => false, 'message' => 'Failed to update amenities'], 500);
        }
    }

    // Images View and Update
    public function viewEditPictures(Property $property)
    {
        $propertyImages = PropertyImage::where('prop_id', $property->prop_id)->get();
        return view('pages.host.edit-property-pictures', compact('property', 'propertyImages'));
    }

    public function updatePictures(Request $request, Property $property)
    {
        try {
            $validated = $request->validate([
                'images' => 'sometimes|array',
                'images.*' => 'image|mimes:jpeg,png,jpg,gif|max:10240',
            ]);

            $draftData = Session::get('property_draft', []);

            $uploadedImages = [];
            if ($request->hasFile('images')) {
                foreach ($request->file('images') as $image) {
                    $path = $image->store('property_images', 'public');
                    $uploadedImages[] = $path;
                }
            }

            $currentImages = $draftData['images'] ?? $property->images->pluck('img_url')->toArray();
            $removedImages = $draftData['removed_images'] ?? [];

            $draftData['images'] = array_values(array_merge(
                array_diff($currentImages, $removedImages),
                $uploadedImages
            ));

            Session::put('property_draft', $draftData);
            Session::save();

            return response()->json(['success' => true]);
        } catch (\Exception $e) {
            Log::error("Error updating pictures: " . $e->getMessage());
            return response()->json(['success' => false, 'message' => 'Failed to update pictures'], 500);
        }
    }

    public function markImageForRemoval(Request $request, Property $property)
    {
        $validated = $request->validate(['image_path' => 'required|string']);

        try {
            $draftData = Session::get('property_draft', []);
            $removedImages = $draftData['removed_images'] ?? [];

            if (!in_array($validated['image_path'], $removedImages)) {
                $removedImages[] = $validated['image_path'];
                $draftData['removed_images'] = $removedImages;
                Session::put('property_draft', $draftData);
                Session::save();
            }

            return response()->json(['success' => true]);
        } catch (\Exception $e) {
            Log::error("Error marking image for removal: " . $e->getMessage());
            return response()->json(['success' => false], 500);
        }
    }

    // Price View and Update
    public function viewEditPrice(Property $property)
    {
        return view('pages.host.edit-property-price', compact('property'));
    }

    public function updatePrice(Request $request, Property $property)
    {
        $validated = $request->validate(['prop_price_per_night' => 'required|numeric|min:1']);

        try {
            $draftData = Session::get('property_draft', []);
            $draftData['price'] = ['prop_price_per_night' => $validated['prop_price_per_night']];
            Session::put('property_draft', $draftData);
            Session::save();

            // ✅ Return success + updated price
            return response()->json([
                'success' => true,
                'price' => $validated['prop_price_per_night']
            ]);
        } catch (\Exception $e) {
            Log::error("Error updating price: " . $e->getMessage());
            return response()->json(['success' => false, 'message' => 'Failed to update price'], 500);
        }
    }

    // Rules View and Update
    public function viewEditRules(Property $property)
    {
        return view('pages.host.edit-property-rules', compact('property'));
    }

    public function createRules(Request $request, Property $property)
    {
        $validated = $request->validate([
            'no_smoking' => 'required|boolean',
            'no_pets' => 'required|boolean',
            'no_parties' => 'required|boolean',
            'check_in_time' => 'required|integer|between:0,23',
            'check_out_time' => 'required|integer|between:0,23',
            'has_security_camera' => 'required|boolean',
            'has_carbon_monoxide_alarm' => 'required|boolean',
            'must_climb_stairs' => 'required|boolean',
            'has_cancellation_fee' => 'required|in:yes,no',
            'cancellation_rate' => 'required_if:has_cancellation_fee,yes|numeric|min:0|max:100'
        ]);

        try {
            $draftData = Session::get('property_draft', []);

            $rulesData = [
                'no_smoking' => (bool)$validated['no_smoking'],
                'no_pets' => (bool)$validated['no_pets'],
                'no_parties' => (bool)$validated['no_parties'],
                'check_in_time' => sprintf('%02d:00:00', $validated['check_in_time']),
                'check_out_time' => sprintf('%02d:00:00', $validated['check_out_time']),
                'has_security_camera' => (bool)$validated['has_security_camera'],
                'has_carbon_monoxide_alarm' => (bool)$validated['has_carbon_monoxide_alarm'],
                'must_climb_stairs' => (bool)$validated['must_climb_stairs'],
                'has_cancellation_fee' => $validated['has_cancellation_fee'],
                'cancellation_rate' => $validated['has_cancellation_fee'] === 'yes' ? $validated['cancellation_rate'] : null
            ];

            $draftData['rules'] = $rulesData;
            Session::put('property_draft', $draftData);
            Session::save();

            return response()->json(['success' => true]);
        } catch (\Exception $e) {
            Log::error("Error updating rules: " . $e->getMessage());
            return response()->json(['success' => false, 'message' => 'Failed to update rules'], 500);
        }
    }

    // Final Save All Updates

    public function saveAllUpdates(Request $request, Property $property)
    {
        DB::beginTransaction();
        try {
            // Get existing draft from session
            $draftData = Session::get('property_draft', []);

            // Parse incoming JSON data
            $requestData = json_decode($request->getContent(), true) ?? [];

            // Merge rules section only if rule-related fields exist
            if (!empty($requestData)) {
                $draftData['rules'] = $requestData;
                Session::put('property_draft', $draftData);
                Session::save(); // Force session write
            }

            // 1. Update Property Type
            if (isset($draftData['prop_type']) && !empty($draftData['prop_type'])) {
                $property->prop_type = $draftData['prop_type'];
            }

            // 2. Update Location
            if (!empty($draftData['location'] ?? null) && is_array($draftData['location'])) {
                $property->prop_address = $draftData['location']['full_address'] ?? $property->prop_address;
            }

            // 3. Update Capacity
            if (!empty($draftData['capacity'] ?? null) && is_array($draftData['capacity'])) {
                $property->prop_room_count = $draftData['capacity']['prop_room_count'] ?? $property->prop_room_count;
                $property->prop_max_guest = $draftData['capacity']['prop_max_guest'] ?? $property->prop_max_guest;
                $property->prop_bathroom_count = $draftData['capacity']['prop_bathroom_count'] ?? $property->prop_bathroom_count;
            }

            // 4. Update Description
            if (!empty($draftData['description'] ?? null) && is_array($draftData['description'])) {
                $property->prop_title = $draftData['description']['prop_title'] ?? $property->prop_title;
                $property->prop_description = $draftData['description']['prop_description'] ?? $property->prop_description;
            }

            // 5. Update Price
            if (!empty($draftData['price'] ?? null) && is_array($draftData['price'])) {
                $property->prop_price_per_night = $draftData['price']['prop_price_per_night'] ?? $property->prop_price_per_night;
            }

            // Log property data before saving
            \Log::info("Property Data Before Save:", ['property' => $property->toArray(), 'draft' => $draftData]);

            // Save base property first
            if (!$property->save()) {
                throw new \Exception("Failed to save property. Data: " . json_encode($property->getAttributes()));
            }

            // 🔑 Ensure we have a valid prop_id after saving
            $propId = $property->prop_id;

            if (!$propId) {
                throw new \Exception("Property ID is missing after save.");
            }

            // 6. Update Amenities
            if (!empty($draftData['amenities'] ?? [])) {
                PropertyAmenity::where('prop_id', $propId)->delete();

                foreach ($draftData['amenities'] as $amenityId) {
                    $amenity = PropertyAmenity::make([
                        'prop_id' => $propId,
                        'amn_id' => $amenityId
                    ]);

                    if (!$amenity->save()) {
                        throw new \Exception("Failed to save amenity ID: $amenityId");
                    }
                }
            }

            // 7. Update Rules
            if (!empty($draftData['rules'] ?? [])) {
                // Helper function to convert raw hour (e.g., "14") to "14:00:00"
                function formatHourToTime($hour) {
                    if (is_numeric($hour) && $hour >= 0 && $hour <= 23) {
                        return sprintf('%02d:00:00', $hour);
                    }
                    return null;
                }

                // Get raw values
                $checkInRaw = $draftData['rules']['check_in_time'] ?? null;
                $checkOutRaw = $draftData['rules']['check_out_time'] ?? null;

                // Format safely
                $checkInFormatted = formatHourToTime($checkInRaw) ?? '13:00:00';
                $checkOutFormatted = formatHourToTime($checkOutRaw) ?? '12:00:00';

                // Build full rule data including prop_id
                $rulesData = [
                    'prop_id' => $propId,
                    'rule_check_in' => $checkInFormatted,
                    'rule_check_out' => $checkOutFormatted,
                    'rule_no_smoking' => filter_var($draftData['rules']['no_smoking'] ?? false, FILTER_VALIDATE_BOOLEAN),
                    'rule_no_pet' => filter_var($draftData['rules']['no_pets'] ?? false, FILTER_VALIDATE_BOOLEAN),
                    'rule_no_events' => filter_var($draftData['rules']['no_parties'] ?? false, FILTER_VALIDATE_BOOLEAN),
                    'rule_security_cam' => filter_var($draftData['rules']['has_security_camera'] ?? false, FILTER_VALIDATE_BOOLEAN),
                    'rule_alarm' => filter_var($draftData['rules']['has_carbon_monoxide_alarm'] ?? false, FILTER_VALIDATE_BOOLEAN),
                    'rule_stairs' => filter_var($draftData['rules']['must_climb_stairs'] ?? false, FILTER_VALIDATE_BOOLEAN),
                    'rule_cancellation' => $draftData['rules']['has_cancellation_fee'] ?? 'no',
                    'rule_cancellation_rate' => $draftData['rules']['has_cancellation_fee'] === 'yes'
                        ? ($draftData['rules']['cancellation_rate'] ?? null)
                        : null,
                ];

                \Log::info("Rule data being saved:", ['rulesData' => $rulesData]);

                // ⚠️ Replace updateOrCreate with safe logic
                $rules = PropertyRules::where('prop_id', $propId)->first();

                if ($rules) {
                    // Update existing
                    $rules->fill($rulesData);
                } else {
                    // Create new
                    $rules = new PropertyRules($rulesData);
                }

                if (!$rules->save()) {
                    throw new \Exception("Failed to save property rules.");
                }
            }

            // 8. Handle Images
            if (!empty($draftData['images'] ?? [])) {
                $removedImages = $draftData['removed_images'] ?? [];
                PropertyImage::where('prop_id', $propId)
                    ->whereIn('img_url', $removedImages)
                    ->delete();

                foreach ($removedImages as $imagePath) {
                    Storage::disk('public')->delete($imagePath);
                }

                $existingImages = $property->images->pluck('img_url')->toArray();
                $newImages = array_diff($draftData['images'], $existingImages);

                foreach ($newImages as $imagePath) {
                    $image = PropertyImage::make([
                        'prop_id' => $propId,
                        'img_url' => $imagePath
                    ]);

                    if (!$image->save()) {
                        throw new \Exception("Failed to save image: $imagePath");
                    }
                }
            }

            // Commit transaction
            DB::commit();

            // Clear draft after successful save
            Session::forget('property_draft');

            return response()->json([
                'success' => true,
                'redirect' => route('host.listing')
            ]);

        } catch (\Exception $e) {
            DB::rollBack();

            \Log::error('Error saving all updates: ' . $e->getMessage(), [
                'exception' => $e,
                'request_body' => $request->getContent(),
                'draft_data' => $draftData,
                'trace' => $e->getTraceAsString()
            ]);

            return response()->json([
                'success' => false,
                'message' => 'Failed to save all updates',
                'error' => config('app.debug') ? $e->getMessage() : 'An unknown error occurred.',
                'line' => $e->getLine(),
                'file' => $e->getFile()
            ], 500);
        }
    }
}
