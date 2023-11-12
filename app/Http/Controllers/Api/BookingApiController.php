<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Booking;
use App\Models\House;
use App\Services\BookingService;

class BookingApiController extends Controller
{
    protected $bookingService;
    public function __construct(BookingService $bookingService)
    {
        $this->bookingService = $bookingService;
  
        $this->middleware('auth:api'); // Assicurati che l'utente sia autenticato
        $this->middleware('can:view,booking')->only(['show']);
        $this->middleware('can:update,booking')->only(['update']);
        $this->middleware('can:delete,booking')->only(['destroy']);
    }

    public function index()
    {
        $bookings = Booking::with(['user', 'house'])->get();
        
        return response()->json($bookings, 200);
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'house_id' => 'required|exists:houses,id',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after:start_date',
        ]);

        $validatedData['user_id'] = auth()->id();


        if ($this->bookingService->checkBookingOverlap($validatedData['house_id'], $validatedData['start_date'], $validatedData['end_date'])) {
            return back()->withErrors(['date' => 'Le date di prenotazione si sovrappongono con una prenotazione esistente.']);
        }

        $booking=Booking::create($validatedData);
        return response()->json($booking, 201);
    }

    public function show(Booking $booking)
    {
        return $booking;
    }

    public function update(Request $request, Booking $booking)
    {
        $validatedData = $request->validate([
            'house_id' => 'required|exists:houses,id',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after:start_date',
        ]);
        if ($this->bookingService->checkBookingOverlap($validatedData['house_id'], $validatedData['start_date'], $validatedData['end_date'])) {
            return back()->withErrors(['date' => 'Le date di prenotazione si sovrappongono con una prenotazione esistente.']);
        }
        $booking->update($validatedData);
        return response()->json($booking, 200);
    }

    public function destroy(Booking $booking)
    {
        $booking->delete();
        return response()->json(null, 204);
    }
}
