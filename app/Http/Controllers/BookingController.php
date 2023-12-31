<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use App\Models\House;
use Illuminate\Http\Request;
use App\Services\BookingService;
use App\Mail\BookingConfirmation;
use App\Mail\NewBookingNotification;
use Illuminate\Support\Facades\Mail;

class BookingController extends Controller
{

    protected $bookingService;

    public function __construct(BookingService $bookingService)
    {
        $this->bookingService = $bookingService;
    }

    public function index()
    {
        $user = auth()->user();

        if ($user instanceof \App\Models\User && $user->hasRole('owner')) {
            // Logica per l'admin
            $bookings = Booking::with(['user', 'house'])->get();
            return view('bookings.index', compact('bookings'));
        }
        
        $userId = auth()->id(); // Ottiene l'ID dell'utente autenticato
        $bookings = Booking::with(['user', 'house'])
                            ->where('user_id', $userId)
                            ->get();  
          
       
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

        $booking = Booking::create($validatedData);
        $this->sendEmails($booking);
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

    public function sendEmails(Booking $booking)
    {
        Mail::to($booking->user->email)->send(new BookingConfirmation($booking));
        Mail::to($booking->house->owner->email)->send(new BookingConfirmation($booking));
    }
}

