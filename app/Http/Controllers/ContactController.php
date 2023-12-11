<?php


namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Contact; 


class ContactController extends Controller
{
    
    public function index()
    {
        $contacts = Contact::all();
        return view('contacts.index', compact('contacts'));
    }

   
    public function show($id)
    {
        $contact = Contact::findOrFail($id);
        return view('contacts.show', compact('contact'));
    }

    
    public function create()
    {
        return view('contacts.create');
    }

    
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'name' => 'required|max:255',
            'email' => 'required',
            'phone' => 'required',
            'address' => 'required',
            'message' => 'sometimes|max:500',
            'latitude' => 'sometimes|numeric',
            'longitude' => 'sometimes|numeric'
        ]);

        $contact = Contact::create($validatedData);
        return redirect()->route('contacts.index');
    }
}

