<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\House;
use App\Models\Review;
use App\Models\Contact;

class HomeController extends Controller
{
    public function index()
    {
        $houses = House::take(5)->get(); // Prende le ultime 5 case inserite
        $reviews = Review::take(5)->get(); // Prende le ultime 5 recensioni (presumendo che tu abbia un modello Review)
        
        return view('home', compact('houses', 'reviews'));
    }
}