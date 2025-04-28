<?php

namespace App\Http\Controllers;

use App\Models\Amenity;
use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;

class AmenityController extends Controller
{
    public function getAllAmenities(){
        $amenities = Amenity::all();
        return response()->json(["message" => "Successfully fetched data","data" => $amenities], 200);
    }
    public function getAmenityById($id)
    {
        $amenity = Amenity::find($id);
        if($amenity){
            return response()->json(["message" => "Successfully fetched data","data" => $amenity], 200);
        }
        return response()->json(["message" => "ID doesnt exist"], 404);
    }
}
