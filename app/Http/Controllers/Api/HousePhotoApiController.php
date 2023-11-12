<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\HousePhoto;
use App\Models\House;
use Illuminate\Http\Request;


class HousePhotoApiController extends Controller
{
    public function index()
    {
        $housePhotos = HousePhoto::all();
        return response()->json($housePhotos, 200);
    }

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

    public function show(HousePhoto $housePhoto)
    {
        return response()->json($housePhoto, 200);
    }

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

    public function destroy(HousePhoto $housePhoto)
    {
        $housePhoto->delete();
        return response()->json(null, 204);
    }

    public function photosByHouse(House $house)
    {
        $photos = $house->photos;
        return response()->json($photos, 200);
    }
}
