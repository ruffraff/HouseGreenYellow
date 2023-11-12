<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Contact; 

class ContactController extends Controller
{
    public function index()
    {
        $contacts = Contact::all();  // Supponendo che tu stia usando Eloquent per recuperare tutti i contatti
        return view('contacts.index', compact('contacts'));
    }

    public function show($id)
    {
        // Dettagli del contatto
        $contact = Contact::findOrFail($id);
        return view('contacts.show', compact('contact'));
        //return view('contacts.show');
    }

    public function create()
    {
        // Pagina per creare un nuovo contatto
       
        return view('contacts.create');
    }

    public function store(Request $request)
    {
        // Validazione  del contatto nel database
        $validatedData = $request->validate([
            'name' => 'required|max:255',
            'email' => 'required',
            'phone' => 'required',
            'address' => 'required',
        ]);
        // Salvataggio  del contatto nel database
        $contact = Contact::create($validatedData);
        
        // ...


        return redirect()->route('contacts.index');
    }
}