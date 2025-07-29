<?php

namespace Modules\Admin\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
// use Modules\Admin\Database\Factories\ServiceFactory;

class Service extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = [
        'name',
        'description',
        'base_price',
        'estimated_duration'
    ];

    /**
     * The attributes that should be cast.
     */
    protected $casts = [
        'base_price' => 'decimal:2',
    ];

    // protected static function newFactory(): ServiceFactory
    // {
    //     // return ServiceFactory::new();
    // }
}
