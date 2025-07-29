<?php

namespace Modules\User\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\UserDetail;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('user::index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('user::create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request): RedirectResponse
    {
        //
    }

    /**
     * Show the specified resource.
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        return view('user::edit');
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id): RedirectResponse
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        //
    }

    /**
     * Show the user profile.
     */
    public function profile()
    {
        $user = Auth::user();
        if (!$user) {
            return redirect()->route('login');
        }
        // Fetch user details
        $userDetail = UserDetail::where('user_id', $user->id)->first();

        return view('user::profile', compact('user', 'userDetail'));
    }

    public function profileUpdate(Request $request)
    {

        // dd($request->all());
        $user = Auth::user();
        if (!$user) {
            return redirect()->route('login');
        }

        // Validate and update user profile information
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255',
            'password' => 'nullable|string|min:8|confirmed',
        ]);
        $user->update([
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
        ]);

        $userDetailData = UserDetail::where('user_id', $user->id)->first();
        // Update or create user details
        $userDetailData->update([
            'full_address' => $request->full_address,
            'birth_certificate' => $request->birth_certificate,
            'nid' => $request->nid,
            'passport' => $request->passport,
        ]);

        if ($request->hasFile('profile_image')) {
            $user->clearMediaCollection('profile');
            $user->addMediaFromRequest('profile_image')
                ->toMediaCollection('profile');
        }



        return redirect()->route('user.profile', $user->id)->with('success', 'Profile updated successfully.');
    }
    public function userAppointments()
    {
        // dd('User appointments');
        $user = Auth::user();
        if (!$user) {
            return redirect()->route('login');
        }

        // Fetch user appointments
        $appointments = $user->appointments()->with('pet')->get();
        dd($appointments);
        return view('user::appointments.index', compact('appointments'));
    }
}
