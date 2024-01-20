<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserProfileController extends Controller
{
    /**
     * Redirects to the edit profile form when Edit Profile dropdown option is clicked.
     */
    public function showUpdateForm()
    {
        $user = Auth::user();
        return view('update-profile', compact('user'));
    }

    /**
     * Redirects to the profile page when View Profile dropdown option is clicked.
     */
    public function showUserProfile()
    {
        $user = Auth::user();
        return view('view-profile', compact('user'));
    }

    /**
     * Validates and stores the changes made to the profile.
     */
    public function update(Request $request)
    {
        $user = Auth::user();

        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,' . $user->id,
            'deptName'=>'string|max:255',
            'profile_picture' => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048', 
        ]);

        $user->update($request->all());

        if ($request->hasFile('profile_picture')) {
            // Store the profile picture on the server
            $profilePicturePath = $request->file('profile_picture')->store('profile_pictures', 'public');
            
            // Update the user's profile_picture column in the database
            $user->update(['profile_picture' => $profilePicturePath]);
        }
        

        return redirect()->route('view.profile')->with('status', 'Profile updated successfully');
    }
}