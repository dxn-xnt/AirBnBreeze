<?php

namespace App\Http\Controllers;

use App\Models\Amenity;
use App\Models\PropertyType;
use App\Models\Type;
use App\Models\User;
use Illuminate\Http\Request;
use App\Models\Property;
use App\Models\PropertyImage;
use App\Models\PropertyAmenity;
use Illuminate\Support\Facades\DB;
use function Laravel\Prompts\warning;
use Illuminate\Support\Facades\Log;

class PropertyEditController extends Controller
{

    public function viewEditType(Property $property) {

        $types = Type::all();
        return view('pages.host.edit-property-type', compact('types', 'property'));
    }

    public function viewEditLocation(Property $property)
    {
        return view('pages.host.edit-property-location', compact('property'));
    }
    public function viewEditCapacity(Property $property)
    {
        return view('pages.host.edit-property-capacity', compact('property'));
    }
    public function viewEditDescription(Property $property)
    {
        return view('pages.host.edit-property-description', compact('property'));
    }
    public function viewEditAmenities(Property $property)
    {
        $amenities = Amenity::all()->groupBy('amn_type');
        return view('pages.host.edit-property-amenities', compact('property', 'amenities'));
    }
    public function viewEditPictures(Property $property)
    {
        return view('pages.host.edit-property-pictures', compact('property'));
    }
    public function viewEditPrice(Property $property)
    {
        return view('pages.host.edit-property-price', compact('property'));
    }
    public function viewEditRules(Property $property)
    {
        return view('pages.host.edit-property-rules', compact('property'));
    }


}
