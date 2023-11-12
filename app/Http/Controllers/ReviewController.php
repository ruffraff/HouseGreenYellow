<?php
namespace App\Http\Controllers;

use App\Models\Review;
use Illuminate\Http\Request;

class ReviewController extends Controller
{
    public function index()
    {
        $reviews = Review::all();
        return view('reviews.index', compact('reviews'));
    }

    public function create()
    {
        return view('reviews.create');
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'content' => 'required|max:1000',
            // Aggiungi ulteriori campi di validazione se necessario
        ]);

        Review::create($validatedData);
        return redirect()->route('reviews.index');
    }

    public function show(Review $review)
    {
        return view('reviews.show', compact('review'));
    }

    // Aggiungi ulteriori metodi come edit, update, destroy se necessario
}
