<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HousePhoto extends Model
{
    use HasFactory;

    protected $fillable = [
        'filename',
    ];

    public function house()
    {
        return $this->belongsTo('App\Models\House');
    }
}
