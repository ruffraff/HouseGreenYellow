<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class House extends Model
{
    protected $fillable = [
        'name',
        'description',
        'address',
        'price_per_night',
        'bedrooms',
        'bathrooms',
    ];

    public function photos()
    {
        return $this->hasMany('App\Models\HousePhoto');
    }

   
    public function bookings()
    {
        return $this->hasMany('App\Models\Booking');
    }

     /**
     * Ottiene il proprietario della casa vacanze.
     */
    public function owner()
    {
        return $this->belongsTo(User::class, 'owner_id');
    }

    
    use HasFactory;
}
