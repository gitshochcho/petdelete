<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Modules\Admin\Models\Pet;

class PetCurrentLocation extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = [
        'pet_id',
        'lat',
        'long',
        'location',
        'get_time'
    ];

    /**
     * The attributes that should be cast.
     */
    protected $casts = [
        'lat' => 'decimal:8',
        'long' => 'decimal:8',
        'get_time' => 'datetime',
    ];

    /**
     * Get the pet that owns this location record.
     */
    public function pet()
    {
        return $this->belongsTo(Pet::class);
    }

    /**
     * Scope to get the latest location for each pet
     */
    public function scopeLatestForPet($query, $petId)
    {
        return $query->where('pet_id', $petId)->latest('get_time');
    }

    /**
     * Scope to get locations within a time range
     */
    public function scopeWithinTimeRange($query, $startTime, $endTime)
    {
        return $query->whereBetween('get_time', [$startTime, $endTime]);
    }

    /**
     * Scope to get locations within a geographic area
     */
    public function scopeWithinArea($query, $minLat, $maxLat, $minLong, $maxLong)
    {
        return $query->whereBetween('lat', [$minLat, $maxLat])
                    ->whereBetween('long', [$minLong, $maxLong]);
    }

    /**
     * Get formatted coordinates
     */
    public function getCoordinatesAttribute()
    {
        return $this->lat . ', ' . $this->long;
    }

    /**
     * Get Google Maps URL
     */
    public function getGoogleMapsUrlAttribute()
    {
        return "https://www.google.com/maps?q={$this->lat},{$this->long}";
    }

    /**
     * Calculate distance from another point (in kilometers)
     */
    public function distanceFrom($lat, $long)
    {
        $earthRadius = 6371; // Earth's radius in kilometers

        $dLat = deg2rad($lat - $this->lat);
        $dLong = deg2rad($long - $this->long);

        $a = sin($dLat/2) * sin($dLat/2) + cos(deg2rad($this->lat)) * cos(deg2rad($lat)) * sin($dLong/2) * sin($dLong/2);
        $c = 2 * atan2(sqrt($a), sqrt(1-$a));

        return $earthRadius * $c;
    }
}
