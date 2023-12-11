<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


/**
 * @OA\Schema(
 *   schema="Contact",
 *   type="object",
 *   title="Contact",
 *   description="Schema for a Contact object",
 *   @OA\Property(
 *     property="id",
 *     type="integer",
 *     description="Unique identifier of the contact"
 *   ),
 *   @OA\Property(
 *     property="name",
 *     type="string",
 *     description="Name of the contact"
 *   ),
 *   @OA\Property(
 *     property="email",
 *     type="string",
 *     format="email",
 *     description="Email address of the contact"
 *   ),
 *   @OA\Property(
 *     property="phone",
 *     type="string",
 *     description="Phone number of the contact"
 *   ),
 *   @OA\Property(
 *     property="address",
 *     type="string",
 *     description="Physical address of the contact"
 *   ),
 *   @OA\Property(
 *     property="message",
 *     type="string",
 *     description="Contact message"
 *   ),
 *   @OA\Property(
 *     property="latitude",
 *     type="number",
 *     format="float",
 *     description="Latitude for the contact's location"
 *   ),
 *   @OA\Property(
 *     property="longitude",
 *     type="number",
 *     format="float",
 *     description="Longitude for the contact's location"
 *   )
 * )
 */
class Contact extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'email',
        'phone',
        'address',
        'message',
        'latitude',
        'longitude'
    ];
}
