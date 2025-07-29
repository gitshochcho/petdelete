<?php

namespace Modules\Admin\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
// use Modules\Admin\Database\Factories\PetCategoryFactory;

class PetCategory extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = [
        'name',
        'status'
    ];

    /**
     * The attributes that should be cast.
     */
    protected $casts = [
        'status' => 'boolean',
    ];

    /**
     * Get the subcategories for the pet category.
     */
    public function petSubcategories()
    {
        return $this->hasMany(PetSubcategory::class);
    }

    // protected static function newFactory(): PetCategoryFactory
    // {
    //     // return PetCategoryFactory::new();
    // }
}
