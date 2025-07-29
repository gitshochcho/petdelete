<?php

namespace Modules\Admin\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;
use App\Models\User;
use App\Models\UserDetail;

class ProfileController extends Controller
{
    /**
     * Show the form for editing the user's profile.
     */
    public function edit()
    {
        /** @var User $user */

        $admin = Auth::guard('admin')->user();
        return view('admin::profile.edit', compact('admin'));
    }

    /**
     * Update the user's profile information.
     */
    public function update(Request $request)
    {
        $admin = Auth::guard('admin')->user();

        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', Rule::unique('admins')->ignore($admin->id)],
            'phone' => ['required', 'string', 'max:20'],
            'full_address' => ['nullable', 'string', 'max:500'],
            'profile_image' => ['nullable', 'image', 'mimes:jpeg,png,jpg,gif', 'max:2048'],
            'degree' => ['nullable', 'string', 'max:255'],
            'bvc_reg_number' => ['nullable', 'string', 'max:100'],
            'home_visit' => ['nullable'],
            'chamber_visit' => ['nullable'],
        ]);

        // Update user basic information
        $admin->update([
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
            'full_address' => $request->full_address,

        ]);

        // Handle profile image upload
        if ($request->hasFile('profile_image')) {
            // Remove old profile image
            $admin->clearMediaCollection('profile');

            // Add new profile image
            $admin->addMediaFromRequest('profile_image')
                ->toMediaCollection('profile');
        }

        // Update or create user details
        $userDetailData = [
            'full_address' => $request->full_address,
        ];

        // Add doctor-specific fields if user is a doctor
        if (method_exists($admin, 'hasRole') && $admin->hasRole('doctor')) {
            $admin->update([
                'degree' => $request->degree,
                'bvc_reg_number' => $request->bvc_reg_number,
                'home_visit' => $request->home_visit,
                'chamber_visit' => $request->chamber_visit,
            ]);


        }



        return redirect()->route('admin.profile.edit')
            ->with('success', 'Profile updated successfully.');
    }

    /**
     * Show the form for changing password.
     */
    public function changePasswordForm()
    {
        return view('admin::profile.change-password');
    }

    /**
     * Update the user's password.
     */
    public function updatePassword(Request $request)
    {
        $request->validate([
            'current_password' => ['required'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ]);

        /** @var User $user */
        $user = Auth::user();

        // Check if current password is correct
        if (!Hash::check($request->current_password, $user->password)) {
            return back()->withErrors(['current_password' => 'The current password is incorrect.']);
        }

        // Update password
        $user->update([
            'password' => Hash::make($request->password),
        ]);

        return redirect()->route('admin.profile.edit')
            ->with('success', 'Password updated successfully.');
    }
}
