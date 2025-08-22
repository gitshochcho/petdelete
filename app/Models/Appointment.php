<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Modules\Admin\Models\Pet;

class Appointment extends Model
{
    // protected $fillable = [
    //     'user_id',
    //     'admin_id',
    //     'pet_id',
    //     'datetime',
    //     'type', // 1=Chamber, 2=Home
    //     'amount',
    //     'status', // 0=Pending, 1=Approved
    //     'notes',
    // ];

    protected $guarded = [];


    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function admin()
    {
        return $this->belongsTo(Admin::class);
    }

    public function pet()
    {
        return $this->belongsTo(Pet::class);
    }

}
