<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Booking;
use App\Services\BookingService;

/**
 * Class BookingApiController
 * 
 * @package App\Http\Controllers\Api
 * 
 * @OA\Tag(
 *     name="Bookings",
 *     description="API Endpoints of Bookings"
 * )
 */
class BookingApiController extends Controller
{
    protected $bookingService;

    /**
     * Initialize BookingApiController with BookingService.
     * 
     * @param BookingService $bookingService Service for booking-related operations.
     */
    public function __construct(BookingService $bookingService)
    {
        $this->bookingService = $bookingService;

        $this->middleware('auth:api');
        $this->middleware('can:view,booking')->only(['show']);
        $this->middleware('can:update,booking')->only(['update']);
        $this->middleware('can:delete,booking')->only(['destroy']);
    }

    /**
     * Display a listing of bookings.
     * 
     * @OA\Get(
     *     path="/api/bookings",
     *     tags={"Bookings"},
     *     summary="Get all bookings",
     *     description="Retrieve a list of all bookings including related user and house information",
     *     @OA\Response(
     *         response=200,
     *         description="Successful operation",
     *         @OA\JsonContent(type="array", @OA\Items(ref="#/components/schemas/Booking"))
     *     )
     * )
     * 
     * @return \Illuminate\Http\JsonResponse
     */
    public function index()
    {
        $bookings = Booking::with(['user', 'house'])->get();
        return response()->json($bookings, 200);
    }

    /**
     * Store a newly created booking.
     * 
     * @OA\Post(
     *     path="/api/bookings",
     *     tags={"Bookings"},
     *     summary="Create a new booking",
     *     description="Create a new booking with provided data",
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(ref="#/components/schemas/Booking")
     *     ),
     *     @OA\Response(
     *         response=201,
     *         description="Booking created successfully",
     *         @OA\JsonContent(ref="#/components/schemas/Booking")
     *     ),
     *     @OA\Response(
     *         response=400,
     *         description="Invalid input data"
     *     )
     * )
     * 
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
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
        return response()->json($booking, 201);
    }

    /**
     * Display the specified booking.
     * 
     * @OA\Get(
     *     path="/api/bookings/{id}",
     *     tags={"Bookings"},
     *     summary="Get a specific booking",
     *     description="Retrieve details of a specific booking by ID",
     *     @OA\Parameter(
     *         name="id",
     *         description="Booking ID",
     *         required=true,
     *         in="path",
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Successful operation",
     *         @OA\JsonContent(ref="#/components/schemas/Booking")
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Booking not found"
     *     )
     * )
     * 
     * @param Booking $booking
     * @return \Illuminate\Http\JsonResponse
     */
    public function show(Booking $booking)
    {
        return response()->json($booking, 200);
    }

    /**
     * Update the specified booking.
     * 
     * @OA\Put(
     *     path="/api/bookings/{id}",
     *     tags={"Bookings"},
     *     summary="Update a booking",
     *     description="Update the details of an existing booking",
     *     @OA\Parameter(
     *         name="id",
     *         description="Booking ID",
     *         required=true,
     *         in="path",
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(ref="#/components/schemas/Booking")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Booking updated successfully",
     *         @OA\JsonContent(ref="#/components/schemas/Booking")
     *     ),
     *     @OA\Response(
     *         response=400,
     *         description="Invalid input data"
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Booking not found"
     *     )
     * )
     * 
     * @param Request $request
     * @param Booking $booking
     * @return \Illuminate\Http\JsonResponse
     */
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

    /**
     * Remove the specified booking.
     * 
     * @OA\Delete(
     *     path="/api/bookings/{id}",
     *     tags={"Bookings"},
     *     summary="Delete a booking",
     *     description="Delete a specific booking by ID",
     *     @OA\Parameter(
     *         name="id",
     *         description="Booking ID",
     *         required=true,
     *         in="path",
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *         response=204,
     *         description="Booking deleted successfully"
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Booking not found"
     *     )
     * )
     * 
     * @param Booking $booking
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy(Booking $booking)
    {
        $booking->delete();
        return response()->json(null, 204);
    }
}
