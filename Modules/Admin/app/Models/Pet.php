<?php

namespace Modules\Admin\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Models\User;
use App\Models\PetCurrentLocation;
// use Modules\Admin\Database\Factories\PetFactory;

class Pet extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = [
        'user_id',
        'name',
        'category_id',
        'subcategory_id',
        'breed_id',
        'birthday',
        'weight',
        'sex',
        'current_medications',
        'medication_allergies',
        'health_conditions',
        'special_notes',
        'status',
        'device_key',
        'device_token'
    ];

    /**
     * The attributes that should be cast.
     */
    protected $casts = [
        'birthday' => 'date',
        'weight' => 'decimal:2',
        'status' => 'boolean',
    ];

    /**
     * Get the user that owns the pet.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the pet category.
     */
    public function petCategory()
    {
        return $this->belongsTo(PetCategory::class, 'category_id');
    }

    /**
     * Get the pet subcategory.
     */
    public function petSubcategory()
    {
        return $this->belongsTo(PetSubcategory::class, 'subcategory_id');
    }

    /**
     * Get the pet breed.
     */
    public function petBreed()
    {
        return $this->belongsTo(PetBreed::class, 'breed_id');
    }

    /**
     * Get all location records for this pet.
     */
    public function locationHistory()
    {
        return $this->hasMany(PetCurrentLocation::class)->orderBy('get_time', 'desc');
    }

    /**
     * Get the current (latest) location for this pet.
     */
    public function currentLocation()
    {
        return $this->hasOne(PetCurrentLocation::class)->latestOfMany('get_time');
    }

    /**
     * Get recent location records for this pet.
     */
    public function recentLocations($hours = 24)
    {
        return $this->hasMany(PetCurrentLocation::class)
                    ->where('get_time', '>=', now()->subHours($hours))
                    ->orderBy('get_time', 'desc');
    }

    /**
     * Check if pet has device tracking enabled.
     */
    public function hasDeviceTracking()
    {
        return !empty($this->device_key) && !empty($this->device_token);
    }

    /**
     * Get formatted device status.
     */
    public function getDeviceStatusAttribute()
    {
        return $this->hasDeviceTracking() ? 'Connected' : 'Not Connected';
    }

    // protected static function newFactory(): PetFactory
    // {
    //     // return PetFactory::new();
    // }
}
