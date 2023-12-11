<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\House;
use Illuminate\Support\Facades\Validator;
/**
 * Class HouseApiController
 * 
 * @package App\Http\Controllers\Api
 * 
 * @OA\Tag(
 *     name="Houses",
 *     description="API Endpoints for Houses"
 * )
 */
class HouseApiController extends Controller
{
    /**
     * Display a listing of houses.
     * 
     * @OA\Get(
     *     path="/houses",
     *     tags={"Houses"},
     *     summary="List all houses",
     *     description="Returns a list of all houses along with their photos",
     *     @OA\Response(
     *         response=200,
     *         description="Successful operation",
     *         @OA\JsonContent(type="array", @OA\Items(ref="#/components/schemas/House"))
     *     )
     * )
     */
    public function index()
    {
        //$houses = House::all();
        $houses = House::with('photos')->get();
        return response()->json($houses, 200);
    }
 /**
     * Store a newly created house.
     * 
     * @OA\Post(
     *     path="/houses",
     *     tags={"Houses"},
     *     summary="Create a new house",
     *     description="Creates a new house with the given details",
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(ref="#/components/schemas/House")
     *     ),
     *     @OA\Response(
     *         response=201,
     *         description="House created successfully",
     *         @OA\JsonContent(ref="#/components/schemas/House")
     *     )
     * )
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'name' => 'required|max:255',
            'description' => 'required',
            'address' => 'required',
            'price_per_night' => 'required|numeric',
            'bedrooms' => 'required|integer',
            'bathrooms' => 'required|integer',
        ]);

        $house = House::create($validatedData);

        if ($request->hasFile('photos')) {
            foreach ($request->photos as $photo) {
                $filename = $photo->store('house_photos', 'public');
                $house->photos()->create(['filename' => $filename]);
            }
        }

        return response()->json($house, 201);
    }
 /**
     * Display the specified house.
     * 
     * @OA\Get(
     *     path="/houses/{id}",
     *     tags={"Houses"},
     *     summary="Get a specific house",
     *     description="Retrieve details of a specific house by ID",
     *     @OA\Parameter(
     *         name="id",
     *         description="ID of the house",
     *         required=true,
     *         in="path",
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Successful operation",
     *         @OA\JsonContent(ref="#/components/schemas/House")
     *     )
     * )
     */
    public function show(House $house)
    {
        $house->load('photos');
        return response()->json($house, 200);
    }
 /**
     * Update the specified house.
     * 
     * @OA\Put(
     *     path="/houses/{id}",
     *     tags={"Houses"},
     *     summary="Update a house",
     *     description="Updates the details of an existing house",
     *     @OA\Parameter(
     *         name="id",
     *         description="ID of the house to update",
     *         required=true,
     *         in="path",
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(ref="#/components/schemas/House")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="House updated successfully",
     *         @OA\JsonContent(ref="#/components/schemas/House")
     *     )
     * )
     */
    public function update(Request $request, House $house)
    {
        $validatedData = $request->validate([
            'name' => 'required|max:255',
            'description' => 'required',
            'address' => 'required',
            'price_per_night' => 'required|numeric',
            'bedrooms' => 'required|integer',
            'bathrooms' => 'required|integer',
        ]);

        if ($request->hasFile('photos')) {
            foreach ($request->photos as $photo) {
                $filename = $photo->store('house_photos', 'public');
                $house->photos()->create(['filename' => $filename]);
            }
        }

        $house->update($validatedData);
        return response()->json($house, 200);
    }
 /**
     * Delete the specified house.
     * 
     * @OA\Delete(
     *     path="/houses/{id}",
     *     tags={"Houses"},
     *     summary="Delete a house",
     *     description="Deletes a specific house by ID",
     *     @OA\Parameter(
     *         name="id",
     *         description="ID of the house to delete",
     *         required=true,
     *         in="path",
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *         response=204,
     *         description="House deleted successfully"
     *     )
     * )
     */
    public function destroy(House $house)
    {
        $house->delete();
        return response()->json(null, 204);
    }
 /**
     * Display the photos of a specific house.
     * 
     * @OA\Get(
     *     path="/houses/{id}/photos",
     *     tags={"Houses"},
     *     summary="Get photos of a house",
     *     description="Retrieve all photos of a specific house by ID",
     *     @OA\Parameter(
     *         name="id",
     *         description="ID of the house",
     *         required=true,
     *         in="path",
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Successful operation",
     *         @OA\JsonContent(type="array", @OA\Items(ref="#/components/schemas/HousePhoto"))
     *     )
     * )
     */
    public function photos(House $house)
    {
        $photos = $house->photos;
        return response()->json($photos, 200);
    }
}
