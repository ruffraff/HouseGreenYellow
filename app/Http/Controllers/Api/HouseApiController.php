<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\House;
use Illuminate\Support\Facades\Validator;

class HouseApiController extends Controller
{
    public function index()
    {
        //$houses = House::all();
        $houses = House::with('photos')->get();
        return response()->json($houses, 200);
    }

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

    public function show(House $house)
    {
        $house->load('photos');
        return response()->json($house, 200);
    }

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

    public function destroy(House $house)
    {
        $house->delete();
        return response()->json(null, 204);
    }

    public function photos(House $house)
    {
        $photos = $house->photos;
        return response()->json($photos, 200);
    }
}
