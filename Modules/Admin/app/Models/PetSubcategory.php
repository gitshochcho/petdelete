<?php

namespace Modules\Admin\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
// use Modules\Admin\Database\Factories\PetSubcategoryFactory;

class PetSubcategory extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = [
        'pet_category_id',
        'name',
        'description',
        'status'
    ];

    /**
     * The attributes that should be cast.
     */
    protected $casts = [
        'status' => 'boolean',
    ];

    /**
     * Get the pet category that owns the subcategory.
     */
    public function petCategory()
    {
        return $this->belongsTo(PetCategory::class);
    }

    /**
     * Get the breeds for the pet subcategory.
     */
    public function petBreeds()
    {
        return $this->hasMany(PetBreed::class);
    }

    // protected static function newFactory(): PetSubcategoryFactory
    // {
    //     // return PetSubcategoryFactory::new();
    // }
}
