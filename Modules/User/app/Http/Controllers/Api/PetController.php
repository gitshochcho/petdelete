<?php

namespace Modules\User\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Modules\Admin\Http\Requests\StorePetRequest;
use Modules\Admin\Http\Requests\UpdatePetRequest;
use Modules\Admin\Models\Pet;
use Modules\Admin\Models\PetCategory;
use Modules\Admin\Models\PetSubcategory;
use Modules\Admin\Models\PetBreed;

class PetController extends Controller
{
    /**
     * Display a listing of the resource.
     */

    public function index()
    {
        $user = Auth::guard('web')->user();
        $pets = Pet::with(['user', 'petCategory', 'petSubcategory', 'petBreed'])->where('user_id', $user->id)->latest()->paginate(10);

        return view('user::pets.index', compact('pets'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $user = Auth::guard('web')->user();
        $users = User::where('status', 1)->where('id', $user->id)->get();
        $petCategories = PetCategory::where('status', true)->get();
        $petSubcategories = PetSubcategory::where('status', true)->get();
        $petBreeds = PetBreed::where('status', true)->get();

        return view('user::pets.create', compact('users', 'petCategories', 'petSubcategories', 'petBreeds'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StorePetRequest $request)
    {
        Pet::create($request->validated());

        return redirect()->route('user.pets.index')
            ->with('success', 'Pet created successfully.');
    }

    /**
     * Show the specified resource.
     */
    public function show(Pet $pet)
    {
        $pet->load(['user', 'petCategory', 'petSubcategory', 'petBreed']);
        return view('user::pets.show', compact('pet'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Pet $pet)
    {
        $user = Auth::guard('web')->user();
        $users = User::where('status', 1)->where('id', $pet->user_id)->get();
        $petCategories = PetCategory::where('status', true)->get();
        $petSubcategories = PetSubcategory::where('status', true)->get();
        $petBreeds = PetBreed::where('status', true)->get();

        return view('user::pets.edit', compact('pet', 'users', 'petCategories', 'petSubcategories', 'petBreeds'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdatePetRequest $request, Pet $pet)
    {
        $pet->update($request->validated());

        return redirect()->route('user.pets.index')
            ->with('success', 'Pet updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Pet $pet)
    {
        $pet->delete();

        return redirect()->route('user.pets.index')
            ->with('success', 'Pet deleted successfully.');
    }
}
