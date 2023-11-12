<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use App\Models\House;
use Illuminate\Http\Request;
use App\Services\BookingService;

class BookingController extends Controller
{

    protected $bookingService;

    public function __construct(BookingService $bookingService)
    {
        $this->bookingService = $bookingService;
    }

    public function index()
    {
        $bookings = Booking::with(['user', 'house'])->get();
        return view('bookings.index', compact('bookings'));
    }

    public function create()
    {
        $houses = House::all();
        return view('bookings.create', compact('houses'));
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

        Booking::create($validatedData);
        return redirect()->route('bookings.index');
    }

    public function show(Booking $booking)
    {
        $houses = House::all();
        return view('bookings.show', compact('booking', 'houses'));
    }

    public function edit(Booking $booking)
    {
        $houses = House::all();
        return view('bookings.edit', compact('booking', 'houses'));
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
        return redirect()->route('bookings.index');
    }

    public function destroy(Booking $booking)
    {
        $booking->delete();
        return redirect()->route('bookings.index');
    }
}

