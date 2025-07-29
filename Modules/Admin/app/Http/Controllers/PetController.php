<?php

namespace Modules\Admin\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Modules\Admin\Models\Pet;
use Modules\Admin\Models\PetCategory;
use Modules\Admin\Models\PetSubcategory;
use Modules\Admin\Models\PetBreed;
use Modules\Admin\Http\Requests\StorePetRequest;
use Modules\Admin\Http\Requests\UpdatePetRequest;

class PetController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $pets = Pet::with(['user', 'petCategory', 'petSubcategory', 'petBreed'])->latest()->paginate(10);
        return view('admin::pets.index', compact('pets'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $users = User::where('status', 1)->get();
        $petCategories = PetCategory::where('status', true)->get();
        $petSubcategories = PetSubcategory::where('status', true)->get();
        $petBreeds = PetBreed::where('status', true)->get();

        return view('admin::pets.create', compact('users', 'petCategories', 'petSubcategories', 'petBreeds'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StorePetRequest $request)
    {
        Pet::create($request->validated());

        return redirect()->route('admin.pets.index')
            ->with('success', 'Pet created successfully.');
    }

    /**
     * Show the specified resource.
     */
    public function show(Pet $pet)
    {
        $pet->load(['user', 'petCategory', 'petSubcategory', 'petBreed']);
        return view('admin::pets.show', compact('pet'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Pet $pet)
    {
        $users = User::where('status', 1)->get();
        $petCategories = PetCategory::where('status', true)->get();
        $petSubcategories = PetSubcategory::where('status', true)->get();
        $petBreeds = PetBreed::where('status', true)->get();

        return view('admin::pets.edit', compact('pet', 'users', 'petCategories', 'petSubcategories', 'petBreeds'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdatePetRequest $request, Pet $pet)
    {
        $pet->update($request->validated());

        return redirect()->route('admin.pets.index')
            ->with('success', 'Pet updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Pet $pet)
    {
        $pet->delete();

        return redirect()->route('admin.pets.index')
            ->with('success', 'Pet deleted successfully.');
    }
}
