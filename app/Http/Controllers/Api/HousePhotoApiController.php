<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\HousePhoto;
use App\Models\House;
use Illuminate\Http\Request;
use OpenApi\Annotations as OA;
/**
 * Class HousePhotoApiController
 * 
 * @package App\Http\Controllers\Api
 * 
 * @OA\Tag(
 *     name="HousePhotos",
 *     description="API Endpoints for House Photos"
 * )
 */
class HousePhotoApiController extends Controller
{
    /**
     * Display a listing of house photos.
     * 
     * @OA\Get(
     *     path="/housePhotos",
     *     tags={"HousePhotos"},
     *     summary="List all house photos",
     *     description="Returns a list of all house photos",
     *     @OA\Response(
     *         response=200,
     *         description="Successful operation",
     *         @OA\JsonContent(type="array", @OA\Items(ref="#/components/schemas/HousePhoto"))
     *     )
     * )
     */
    public function index()
    {
        $housePhotos = HousePhoto::all();
        return response()->json($housePhotos, 200);
    }

    /**
     * Store a newly created house photo.
     * 
     * @OA\Post(
     *     path="/housePhotos",
     *     tags={"HousePhotos"},
     *     summary="Create a new house photo",
     *     description="Creates a new house photo and returns it",
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\MediaType(
     *             mediaType="multipart/form-data",
     *             @OA\Schema(ref="#/components/schemas/HousePhoto")
     *         )
     *     ),
     *     @OA\Response(
     *         response=201,
     *         description="House photo created successfully",
     *         @OA\JsonContent(ref="#/components/schemas/HousePhoto")
     *     ),
     *     @OA\Response(
     *         response=400,
     *         description="Invalid input"
     *     )
     * )
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'filename' => 'required|image',
            'house_id' => 'required|exists:houses,id'
        ]);

        if ($request->hasFile('filename')) {
            $filename = $request->filename->store('house_photos', 'public');
            $housePhoto = HousePhoto::create(['filename' => $filename, 'house_id' => $request->house_id]);
            return response()->json($housePhoto, 201);
        }

        return response()->json(['error' => 'File not uploaded'], 400);
    }
/**
     * Display the specified house photo.
     * 
     * @OA\Get(
     *     path="/housePhotos/{id}",
     *     tags={"HousePhotos"},
     *     summary="Get a specific house photo",
     *     description="Retrieve details of a specific house photo by ID",
     *     @OA\Parameter(
     *         name="id",
     *         description="ID of the house photo",
     *         required=true,
     *         in="path",
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Successful operation",
     *         @OA\JsonContent(ref="#/components/schemas/HousePhoto")
     *     )
     * )
     */
    public function show(HousePhoto $housePhoto)
    {
        return response()->json($housePhoto, 200);
    }
 /**
     * Update the specified house photo.
     * 
     * @OA\Put(
     *     path="/housePhotos/{id}",
     *     tags={"HousePhotos"},
     *     summary="Update a house photo",
     *     description="Updates and returns the specified house photo",
     *     @OA\Parameter(
     *         name="id",
     *         description="ID of the house photo to update",
     *         required=true,
     *         in="path",
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\MediaType(
     *             mediaType="multipart/form-data",
     *             @OA\Schema(ref="#/components/schemas/HousePhoto")
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="House photo updated successfully",
     *         @OA\JsonContent(ref="#/components/schemas/HousePhoto")
     *     )
     * )
     */
    public function update(Request $request, HousePhoto $housePhoto)
    {
        $validatedData = $request->validate([
            'filename' => 'image',
            'house_id' => 'exists:houses,id'
        ]);

        if ($request->hasFile('filename')) {
            $filename = $request->filename->store('house_photos', 'public');
            $validatedData['filename'] = $filename;
        }

        $housePhoto->update($validatedData);
        return response()->json($housePhoto, 200);
    }
/**
     * Delete the specified house photo.
     * 
     * @OA\Delete(
     *     path="/housePhotos/{id}",
     *     tags={"HousePhotos"},
     *     summary="Delete a house photo",
     *     description="Deletes a specific house photo by ID",
     *     @OA\Parameter(
     *         name="id",
     *         description="ID of the house photo to delete",
     *         required=true,
     *         in="path",
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *         response=204,
     *         description="House photo deleted successfully"
     *     )
     * )
     */
    public function destroy(HousePhoto $housePhoto)
    {
        $housePhoto->delete();
        return response()->json(null, 204);
    }
  /**
     * Display photos by a specific house.
     * 
     * @OA\Get(
     *     path="/houses/{houseId}/photos",
     *     tags={"HousePhotos"},
     *     summary="Get photos of a specific house",
     *     description="Retrieve all photos of a specific house by house ID",
     *     @OA\Parameter(
     *         name="houseId",
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
    public function photosByHouse(House $house)
    {
        $photos = $house->photos;
        return response()->json($photos, 200);
    }
}
