<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Review extends Model
{
    protected $fillable = [
        'content', 
        // Aggiungi ulteriori attributi che desideri assegnare in massa
        'user_id' // Se stai collegando la recensione a un utente specifico
    ];

    // Se stai collegando una recensione a un utente:
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Puoi anche avere relazioni con altre tabelle, ad esempio con la tabella delle case se le recensioni sono per le case specifiche
}
