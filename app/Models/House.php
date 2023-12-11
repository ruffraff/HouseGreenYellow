<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
/**
 * @OA\Schema(
 *     schema="House",
 *     type="object",
 *     title="House",
 *     description="House model for handling vacation houses in the system",
 *     @OA\Property(
 *         property="id",
 *         type="integer",
 *         description="Unique identifier of the house"
 *     ),
 *     @OA\Property(
 *         property="name",
 *         type="string",
 *         description="Name of the house"
 *     ),
 *     @OA\Property(
 *         property="description",
 *         type="string",
 *         description="Description of the house"
 *     ),
 *     @OA\Property(
 *         property="address",
 *         type="string",
 *         description="Address of the house"
 *     ),
 *     @OA\Property(
 *         property="price_per_night",
 *         type="number",
 *         format="float",
 *         description="Price per night for renting the house"
 *     ),
 *     @OA\Property(
 *         property="bedrooms",
 *         type="integer",
 *         description="Number of bedrooms in the house"
 *     ),
 *     @OA\Property(
 *         property="bathrooms",
 *         type="integer",
 *         description="Number of bathrooms in the house"
 *     ),
 *     @OA\Property(
 *         property="photos",
 *         type="array",
 *         @OA\Items(ref="#/components/schemas/HousePhoto"),
 *         description="Photos of the house"
 *     ),
 *     @OA\Property(
 *         property="bookings",
 *         type="array",
 *         @OA\Items(ref="#/components/schemas/Booking"),
 *         description="Bookings of the house"
 *     ),
 *     @OA\Property(
 *         property="owner",
 *         ref="#/components/schemas/User",
 *         description="Owner of the house"
 *     )
 * )
 */
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
