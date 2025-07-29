<?php

namespace Modules\Admin\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Models\User;
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
        'status'
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

    // protected static function newFactory(): PetFactory
    // {
    //     // return PetFactory::new();
    // }
}
