<?php

namespace Modules\Admin\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
// use Modules\Admin\Database\Factories\PetBreedFactory;

class PetBreed extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = [
        'pet_subcategory_id',
        'name',
        'description',
        'typical_weight_min',
        'typical_weight_max',
        'status'
    ];

    /**
     * The attributes that should be cast.
     */
    protected $casts = [
        'typical_weight_min' => 'decimal:2',
        'typical_weight_max' => 'decimal:2',
        'status' => 'boolean',
    ];

    /**
     * Get the pet subcategory that owns the breed.
     */
    public function petSubcategory()
    {
        return $this->belongsTo(PetSubcategory::class);
    }

    // protected static function newFactory(): PetBreedFactory
    // {
    //     // return PetBreedFactory::new();
    // }
}
