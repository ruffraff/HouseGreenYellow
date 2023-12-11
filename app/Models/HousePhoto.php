<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
/**
 * @OA\Schema(
 *     schema="HousePhoto",
 *     type="object",
 *     title="HousePhoto",
 *     description="HousePhoto model for handling photos of houses in the system",
 *     @OA\Property(
 *         property="id",
 *         type="integer",
 *         description="Unique identifier of the house photo"
 *     ),
 *     @OA\Property(
 *         property="filename",
 *         type="string",
 *         description="Filename of the photo"
 *     ),
 *     @OA\Property(
 *         property="house",
 *         ref="#/components/schemas/House",
 *         description="The house to which this photo belongs"
 *     )
 * 
 * )
 */
class HousePhoto extends Model
{
    use HasFactory;

    protected $fillable = [
        'filename',
    ];

    public function house()
    {
        return $this->belongsTo('App\Models\House');
    }
}
