<?php

namespace App\Http\Controllers;

use App\Models\House;
use Illuminate\Http\Request;

class HouseController extends Controller
{
    public function index()
    {
        $houses = House::all();
       // return compact('houses');
        return view('houses.index', compact('houses'));
    }

    public function create()
    {
        return view('houses.create');
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

        return redirect()->route('houses.index');
    }

    public function show(House $house)
    {
        $house->load('photos'); // Carica le foto relative alla casa
        return view('houses.show', compact('house'));
    }

    public function edit(House $house)
    {
        return view('houses.edit', compact('house'));
    }

    public function update(Request $request, House $house)
    {
        if ($request->hasFile('photo')) {
            $filename = $request->photo->store('photos', 'public');
            $validatedData['photo'] = $filename;
        }
        

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
        
        $house->update($validatedData);
        return redirect()->route('houses.index');
    }

    public function destroy(House $house)
    {
        $house->delete();
        return redirect()->route('houses.index');
    }

    public function photos(House $house)
    {
        $photos = $house->photos;
        return view('houses.photos', compact('photos'));
    }

}

