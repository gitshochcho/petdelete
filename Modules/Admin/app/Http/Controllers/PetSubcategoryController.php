<?php

namespace Modules\Admin\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Modules\Admin\Models\PetSubcategory;
use Modules\Admin\Models\PetCategory;
use Modules\Admin\Http\Requests\StorePetSubcategoryRequest;
use Modules\Admin\Http\Requests\UpdatePetSubcategoryRequest;

class PetSubcategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $petSubcategories = PetSubcategory::with('petCategory')->latest()->paginate(10);
        return view('admin::pet-subcategories.index', compact('petSubcategories'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $petCategories = PetCategory::where('status', true)->get();
        return view('admin::pet-subcategories.create', compact('petCategories'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StorePetSubcategoryRequest $request)
    {
        PetSubcategory::create($request->validated());

        return redirect()->route('admin.pet-subcategories.index')
            ->with('success', 'Pet Subcategory created successfully.');
    }

    /**
     * Show the specified resource.
     */
    public function show(PetSubcategory $petSubcategory)
    {
        $petSubcategory->load(['petCategory', 'petBreeds']);
        return view('admin::pet-subcategories.show', compact('petSubcategory'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(PetSubcategory $petSubcategory)
    {
        $petCategories = PetCategory::where('status', true)->get();
        return view('admin::pet-subcategories.edit', compact('petSubcategory', 'petCategories'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdatePetSubcategoryRequest $request, PetSubcategory $petSubcategory)
    {
        $petSubcategory->update($request->validated());

        return redirect()->route('admin.pet-subcategories.index')
            ->with('success', 'Pet Subcategory updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(PetSubcategory $petSubcategory)
    {
        $petSubcategory->delete();

        return redirect()->route('admin.pet-subcategories.index')
            ->with('success', 'Pet Subcategory deleted successfully.');
    }
}
