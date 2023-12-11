<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Booking
 *
 * @package App\Models
 *
 * @OA\Schema(
 *     schema="Booking",
 *     type="object",
 *     title="Booking",
 *     required={"house_id", "user_id", "start_date", "end_date"},
 *     @OA\Property(
 *          property="house_id",
 *          type="integer",
 *          description="Unique identifier of the house"
 *     ),
 *     @OA\Property(
 *          property="user_id",
 *          type="integer",
 *          description="Unique identifier of the user"
 *     ),
 *     @OA\Property(
 *          property="start_date",
 *          type="string",
 *          format="date",
 *          description="Start date of the booking"
 *     ),
 *     @OA\Property(
 *          property="end_date",
 *          type="string",
 *          format="date",
 *          description="End date of the booking"
 *     )
 * )
 * 
 * Represents a booking record, linking a user to a house for a specific time period.
 */
class Booking extends Model
{
    use HasFactory;

    protected $fillable = [
        'house_id',
        'user_id',
        'start_date',
        'end_date',
    ];

    /**
     * User relationship.
     * 
     * @OA\Property(
     *     property="user",
     *     ref="#/components/schemas/User"
     * )
     * 
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * House relationship.
     * 
     * @OA\Property(
     *     property="house",
     *     ref="#/components/schemas/House"
     * )
     * 
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function house()
    {
        return $this->belongsTo(House::class);
    }

   
     /**
     * Check for booking overlaps.
     *
     * This method checks if the given booking dates overlap with any existing bookings.
     *  
     * @param integer $houseId
     * @param string $startDate
     * @param string $endDate
     * @return bool
     */
    public static function hasOverlap($houseId, $startDate, $endDate)
    {
        return static::where('house_id', $houseId)
            ->where(function ($query) use ($startDate, $endDate) {
                $query->whereBetween('start_date', [$startDate, $endDate])
                    ->orWhereBetween('end_date', [$startDate, $endDate])
                    ->orWhere(function ($query) use ($startDate, $endDate) {
                        $query->where('start_date', '<', $startDate)
                            ->where('end_date', '>', $endDate);
                    });
            })
            ->exists();
    }
}
