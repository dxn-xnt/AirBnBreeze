<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function index()
    {
        //
    }
    public function showLogin()
    {
        return view('pages.login');
    }
    public function showSignUp()
    {
        return view('pages.signup');
    }
    public function getAllUser(){
        $users = User::all();
        return validateData($users, "fetched all");
    }
    public function getUserById($id){
        $user = User::find($id);
        return validateData($user, "fetched");
    }
    public function createUser(Request $request){
        if (User::where('user_email', $request->user_email)->exists()) {
            return response()->json(["message" => "User email already exists"], 409);
        }
        if (User::where('user_contact_number', $request->user_contact_number)->exists()) {
            return response()->json(["message" => "Number already exists"], 409);
        }

        // Validate the input data
        $validated = $request->validate([
            'user_name' => 'required|string|max:50',
            'user_contact_number' => 'required|string|max:11',
            'user_email' => 'required|email|max:50',
            'user_password' => 'required|string|max:100',
            'user_date_created' => 'required|date',
            'user_profile' => 'nullable|string|max:250',
            'user_is_guest'=> 'required|boolean',
            'user_is_host'=> 'required|boolean'
        ]);

        // Hash the password
        $validated['user_password'] = Hash::make($request->user_password);

        // Create the user
        $result = User::create($validated);

        // Return the success response
        return validateData($result, "created");
    }
    public function updateUser(Request $request, $id){
        $user = User::find($id);
        validateData($user, "fetched");

        $validated = $request->validate([
            'user_name' => 'required|string|max:50',
            'user_contact_number' => 'required|string|max:11',
            'user_email' => 'required|email|max:50',
            'user_password' => 'required|string|max:100',
            'user_date_created' => 'required|date',
            'user_profile' => 'nullable|string|max:250',
            'user_is_guest'=> 'required|boolean',
            'user_is_host'=> 'required|boolean'
        ]);

        if($user->user_email !== $request->user_email){
            if(User::where('user_email',$request->user_email)->exists()){
                return response()->json(["message" => "User email already exists"],404);
            }
        }
        $user->update($validated);
        return response()->json(["message" => "User updated successfully"],200);
    }
    public function deleteUser($id){
        $user = User::find($id);
        if(!$user){
            return response()->json(["message" => "User not found"],404);
        }
        $user->delete();
        return response()->json(["message" => "User deleted successfully"],200);
    }

}

function validateData($data, $method)
{
    $message = "Succesfully {$method} user";
    if ($data) {
        return response()->json(["message" => $message ?: "Successfully fetched data", "data" => $data], 200);
    }
    return response()->json(["message" => "Resource not found"], 404);
}
