<?php

namespace Modules\Admin\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Modules\Admin\Models\PetBreed;
use Modules\Admin\Models\PetSubcategory;
use Modules\Admin\Http\Requests\StorePetBreedRequest;
use Modules\Admin\Http\Requests\UpdatePetBreedRequest;

class PetBreedController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $petBreeds = PetBreed::with('petSubcategory.petCategory')->latest()->paginate(10);
        return view('admin::pet-breeds.index', compact('petBreeds'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $petSubcategories = PetSubcategory::with('petCategory')->where('status', true)->get();
        return view('admin::pet-breeds.create', compact('petSubcategories'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StorePetBreedRequest $request)
    {
        PetBreed::create($request->validated());

        return redirect()->route('admin.pet-breeds.index')
            ->with('success', 'Pet Breed created successfully.');
    }

    /**
     * Show the specified resource.
     */
    public function show(PetBreed $petBreed)
    {
        $petBreed->load('petSubcategory.petCategory');
        return view('admin::pet-breeds.show', compact('petBreed'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(PetBreed $petBreed)
    {
        $petSubcategories = PetSubcategory::with('petCategory')->where('status', true)->get();
        return view('admin::pet-breeds.edit', compact('petBreed', 'petSubcategories'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdatePetBreedRequest $request, PetBreed $petBreed)
    {
        $petBreed->update($request->validated());

        return redirect()->route('admin.pet-breeds.index')
            ->with('success', 'Pet Breed updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(PetBreed $petBreed)
    {
        $petBreed->delete();

        return redirect()->route('admin.pet-breeds.index')
            ->with('success', 'Pet Breed deleted successfully.');
    }
}
