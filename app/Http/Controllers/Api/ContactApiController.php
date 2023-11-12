<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Models\Contact; 
use App\Http\Controllers\Controller;

class ContactApiController extends Controller
{
    public function index()
    {
        $contacts = Contact::all();  // Supponendo che tu stia usando Eloquent per recuperare tutti i contatti
        return response()->json($contacts, 200);
    }

    public function show($id)
    {
        // Dettagli del contatto
        $contact = Contact::findOrFail($id);
        return response()->json($contact, 200);
        //return view('contacts.show');
    }

    public function create(Request $request)
    {
        // Pagina per creare un nuovo contatto
       // Validazione  del contatto nel database
       $validatedData = $request->validate([
        'name' => 'required|max:255',
        'email' => 'required',
        'phone' => 'required',
        'address' => 'required',
    ]);
    // Salvataggio  del contatto nel database
    $contact = Contact::create($validatedData);
        return response()->json($contact, 201);
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


        return response()->json($contact, 200);
    }
}