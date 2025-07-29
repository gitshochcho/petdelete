<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Spatie\MediaLibrary\HasMedia;
use Spatie\Permission\Traits\HasRoles;
use Spatie\MediaLibrary\InteractsWithMedia;


class Admin extends Authenticatable implements HasMedia
{
    use HasFactory, Notifiable, HasRoles, InteractsWithMedia;
    protected $fillable = [
        'name',
        'email',
        'password',
        'phone',
        'otp',
        'status',
        'home_visit',
        'chamber_visit',
        'bvc_reg_number',
        'degree',
        'full_address',
    ];
}
