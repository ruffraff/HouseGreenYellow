<?php
namespace App\Repositories;

use App\Models\Booking;

class BookingRepository
{
    protected $model;

    public function __construct(Booking $booking)
    {
        $this->model = $booking;
    }

    public function hasOverlap($houseId, $startDate, $endDate)
    {
        return $this->model->where('house_id', $houseId)
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

    // Aggiungi altri metodi del repository come "create", "update", ecc.
}