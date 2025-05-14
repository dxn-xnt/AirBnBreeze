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
    public function createUser(Request $request)
    {
        // Check if user with the same email already exists
        if (User::where('user_email', $request->user_email)->exists()) {
            if ($request->wantsJson() || $request->ajax()) {
                return response()->json(["message" => "Email Address already exists"], 409);
            }
            return back()->with('error', 'Email Address already exists');
        }

        // Validate the input data
        $validated = $request->validate([
            'user_fname' => 'required|string|max:50',
            'user_lname' => 'required|string|max:50',
            'user_contact_number' => 'required|string|max:11|unique:users,user_contact_number',
            'user_email' => 'required|string|email|max:50|unique:users,user_email',
            'user_password' => 'required|string|min:6|max:100',
        ]);

        // Hash the password
        $validated['user_password'] = Hash::make($validated['user_password']);

        // Create the user
        $result = User::create([
            'user_fname' => $validated['user_fname'],
            'user_lname' => $validated['user_lname'],
            'user_contact_number' => $validated['user_contact_number'],
            'user_email' => $validated['user_email'],
            'user_password' => $validated['user_password'],
            'user_date_created' => now(),
        ]);

        // Return the success response
        if ($request->wantsJson() || $request->ajax()) {
            return response()->json([
                "success" => true,
                "message" => "Registration successful! Redirecting to login...",
                "redirect" => route('login')
            ]);
        }
        return redirect()->route('login')->with('success', 'User created successfully!');
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
