<?php

namespace App\Services;

use App\Repositories\BookingRepository;

class BookingService
{
    protected $repository;

    public function __construct(BookingRepository $repository)
    {
        $this->repository = $repository;
    }

    public function checkBookingOverlap($houseId, $startDate, $endDate)
    {
        return $this->repository->hasOverlap($houseId, $startDate, $endDate);
    }

    // Aggiungi altri metodi del servizio come "createBooking", "cancelBooking", ecc.
}
