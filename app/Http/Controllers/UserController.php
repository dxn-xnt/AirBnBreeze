<?php

namespace App\Http\Controllers;
use App\Models\Notification;
use App\Models\Property;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class UserController extends Controller
{
    public function showLogin()
    {
        return view('pages.login');
    }

    public function showSignUp()
    {
        return view('pages.signup');
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

    public function viewProfile()
    {
        $user = auth()->user();
        $properties = Property::where('user_id', $user->user_id)->get();

        return view('pages.profile-view', [
            'user' => $user,
            'properties' => $properties
        ]);
    }

    /**
     * Show the edit form for the user profile.
     */
    public function editProfile($id)
    {
        $user = User::findOrFail($id);
        $properties = Property::where('user_id', $id)->get();

        return view('pages.profile-edit', compact('user', 'properties'));
    }

    /**
     * Update the user profile in storage.
     */
    public function updateProfile(Request $request, $id)
    {
        try {
            $user = User::findOrFail($id);

            $validated = $request->validate([
                'user_fname' => 'required|string|max:50',
                'user_lname' => 'required|string|max:50',
                'user_email' => 'required|email|max:50|unique:users,user_email,' . $id . ',user_id',
                'user_contact_number' => 'required|numeric|digits_between:1,11', // Ensure exactly 1–11 digits
                'user_about' => 'nullable|string',
                'user_profile' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            ]);

            // Handle profile picture upload
            if ($request->hasFile('user_profile')) {
                if ($user->user_profile && Storage::exists('public/' . $user->user_profile)) {
                    Storage::delete('public/' . $user->user_profile);
                }
                $path = $request->file('user_profile')->store('profile-pictures', 'public');
                $validated['user_profile'] = $path;
            }

            $user->update($validated);

            return response()->json([
                'success' => true,
                'message' => 'Profile updated successfully',
                'user_fname' => $user->user_fname,
                'user_lname' => $user->user_lname,
                'user_email' => $user->user_email,
                'user_contact_number' => $user->user_contact_number,
                'user_about' => $user->user_about ?? '',
                'user_profile' => $user->user_profile ? asset('storage/' . $user->user_profile) : asset('images/default-profile.jpg'),
            ]);

        } catch (\Illuminate\Validation\ValidationException $e) {
            return response()->json([
                'success' => false,
                'message' => 'Validation failed',
                'errors' => $e->validator->errors(),
            ], 422);
        } catch (\Exception $e) {
            \Log::error("Profile Update Error: " . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Server error: ' . $e->getMessage(),
            ], 500);
        }
    }
}
