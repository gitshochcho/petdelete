<?php

namespace Modules\Admin\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Track;
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


     public function device(Pet $pet)
    {
        $lastTrack = Track::where('device_key', $pet->device_key)->latest()->first();

        // Check if we need to generate new tracking data
        if ($lastTrack) {
           $timeDiff = $lastTrack->created_at->diffInSeconds(now());

            if ($timeDiff > 45) {
                // Generate realistic movement based on last known position
                $this->generateRealisticMovement($pet->device_key, $lastTrack, $timeDiff);
            }
        }

        else {
            // No previous track, create an initial random position
            if ($pet->device_key == "track-office") {
                $initialLat = 23.81521126701603; // Around San Francisco
                $initialLng = 90.41471815033081;
            }
            if ($pet->device_key == "track-university") {
                $initialLat = 23.772124987095808; // Around San Francisco
                $initialLng = 90.37831916520963;
            }


            Track::create([
                'device_key' => $pet->device_key,
                'latitude' => number_format($initialLat, 8),
                'longitude' => number_format($initialLng, 8),
            ]);
        }

        $pet->load(['user', 'petCategory', 'petSubcategory', 'petBreed']);
        $trackData = Track::where('device_key', $pet->device_key)->get();
        return view('admin::pets.track', compact('pet', 'trackData'));
    }

    /**
     * Generate realistic cat movement data - single record
     */
    private function generateRealisticMovement($deviceKey, $lastTrack, $timeDiffSeconds)
    {
        $lastLat = (float) $lastTrack->latitude;
        $lastLng = (float) $lastTrack->longitude;

        // Calculate realistic movement based on time difference
        $minutesPassed = $timeDiffSeconds / 60;

        // Cats typically move 5-50 meters per minute when active
        // Convert to coordinate degrees (roughly 0.00001 degree = 1 meter)
        $baseMovement = 0.00005; // About 5 meters
        $maxMovement = 0.0005;   // About 50 meters

        // Random activity level (cats are active 30% of the time)
        $activityLevel = rand(1, 10) <= 3 ? rand(70, 100) / 100 : rand(10, 30) / 100;

        // Calculate movement distance based on time and activity
        $movementDistance = min($maxMovement, $baseMovement * $minutesPassed * $activityLevel);

        // Generate random direction (0-360 degrees)
        $direction = rand(0, 360);
        $radians = deg2rad($direction);

        // Add some natural wandering behavior
        $wanderFactor = (rand(-30, 30) / 100); // ±30% variation
        $movementDistance *= (1 + $wanderFactor);

        // Calculate new coordinates
        $latDelta = $movementDistance * cos($radians);
        $lngDelta = $movementDistance * sin($radians);

        // Add micro-movements for natural behavior (small random adjustments)
        $microLat = (rand(-10, 10) / 1000000); // Very small random movement
        $microLng = (rand(-10, 10) / 1000000);

        $newLat = $lastLat + $latDelta + $microLat;
        $newLng = $lastLng + $lngDelta + $microLng;

        // Ensure realistic bounds (cats don't teleport far)
        $maxDistance = 0.002; // Maximum 200 meters from last position
        $newLat = max($lastLat - $maxDistance, min($lastLat + $maxDistance, $newLat));
        $newLng = max($lastLng - $maxDistance, min($lastLng + $maxDistance, $newLng));

        // Create a single realistic track record with current timestamp
        Track::create([
            'device_key' => $deviceKey,
            'latitude' => number_format($newLat, 8),
            'longitude' => number_format($newLng, 8),
        ]);
    }
}
