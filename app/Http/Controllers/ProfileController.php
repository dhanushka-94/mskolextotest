<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rules\File;

class ProfileController extends Controller
{
    /**
     * Show the profile settings page.
     */
    public function show()
    {
        return view('profile.show', [
            'user' => Auth::user()
        ]);
    }

    /**
     * Update the user's profile information.
     */
    public function update(Request $request)
    {
        $user = Auth::user();

        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,' . $user->id,
            'phone' => 'nullable|string|max:20',
            'date_of_birth' => 'nullable|date',
            'gender' => 'nullable|in:male,female,other',
        ]);

        $user->update($request->only([
            'name',
            'email', 
            'phone',
            'date_of_birth',
            'gender'
        ]));

        return back()->with('success', 'Profile updated successfully!');
    }

    /**
     * Update the user's profile photo.
     */
    public function updatePhoto(Request $request)
    {
        $request->validate([
            'profile_photo' => [
                'required',
                'image',
                'max:2048', // 2MB max file size
                'mimes:jpeg,jpg,png,gif,webp'
            ]
        ]);

        $user = Auth::user();

        // Delete old profile photo if it exists
        if ($user->profile_photo_path) {
            Storage::disk('public')->delete($user->profile_photo_path);
        }

        // Store new profile photo
        $path = $request->file('profile_photo')->store('profile-photos', 'public');

        // Update user's profile photo path
        $user->update([
            'profile_photo_path' => $path
        ]);

        return back()->with('success', 'Profile photo updated successfully!');
    }

    /**
     * Delete the user's profile photo.
     */
    public function deletePhoto()
    {
        $user = Auth::user();

        if ($user->profile_photo_path) {
            // Delete the file from storage
            Storage::disk('public')->delete($user->profile_photo_path);

            // Remove the path from the database
            $user->update([
                'profile_photo_path' => null
            ]);

            return back()->with('success', 'Profile photo removed successfully!');
        }

        return back()->with('error', 'No profile photo to remove.');
    }

    /**
     * Update the user's password.
     */
    public function updatePassword(Request $request)
    {
        $request->validate([
            'current_password' => 'required|current_password',
            'password' => 'required|string|min:8|confirmed',
        ]);

        Auth::user()->update([
            'password' => bcrypt($request->password)
        ]);

        return back()->with('success', 'Password updated successfully!');
    }
}