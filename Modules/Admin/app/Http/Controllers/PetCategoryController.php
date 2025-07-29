<?php

namespace Modules\Admin\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Modules\Admin\Models\PetCategory;
use Modules\Admin\Http\Requests\StorePetCategoryRequest;
use Modules\Admin\Http\Requests\UpdatePetCategoryRequest;

class PetCategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {

        $petCategories = PetCategory::latest()->paginate(10);
        return view('admin::pet-categories.index', compact('petCategories'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin::pet-categories.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StorePetCategoryRequest $request)
    {
        PetCategory::create($request->validated());

        return redirect()->route('admin.pet-categories.index')
            ->with('success', 'Pet Category created successfully.');
    }

    /**
     * Show the specified resource.
     */
    public function show(PetCategory $petCategory)
    {
        return view('admin::pet-categories.show', compact('petCategory'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(PetCategory $petCategory)
    {
        return view('admin::pet-categories.edit', compact('petCategory'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdatePetCategoryRequest $request, PetCategory $petCategory)
    {
        $petCategory->update($request->validated());

        return redirect()->route('admin.pet-categories.index')
            ->with('success', 'Pet Category updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(PetCategory $petCategory)
    {
        $petCategory->delete();

        return redirect()->route('admin.pet-categories.index')
            ->with('success', 'Pet Category deleted successfully.');
    }
}
