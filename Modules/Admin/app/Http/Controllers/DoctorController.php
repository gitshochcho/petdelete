<?php

namespace Modules\Admin\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Admin;
use Illuminate\Http\Request;
use Modules\Admin\Models\Service;
use Modules\Admin\Http\Requests\StoreServiceRequest;
use Modules\Admin\Http\Requests\UpdateServiceRequest;

class DoctorController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $doctors = Admin::whereHas('roles', function ($query) {
            $query->where('name', 'doctor');
        })->latest()->paginate(10);
        return view('admin::doctor.index', compact('doctors'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        // return view('admin::services.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreServiceRequest $request)
    {
        //
    }

    /**
     * Show the specified resource.
     */
    public function show(Service $service)
    {
        // return view('admin::services.show', compact('service'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Service $service)
    {
        // return view('admin::services.edit', compact('service'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateServiceRequest $request, Service $service)
    {
        // $service->update($request->validated());

        // return redirect()->route('admin.services.index')
        //     ->with('success', 'Service updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Service $service)
    {
        // $service->delete();

        // return redirect()->route('admin.services.index')
        //     ->with('success', 'Service deleted successfully.');
    }
}
