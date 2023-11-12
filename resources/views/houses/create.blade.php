@extends('layouts.app')

@section('content')

<h2>Aggiungi Nuova Casa Vacanze</h2>

<form action="{{ route('houses.store') }}" method="POST"  enctype="multipart/form-data">
    @csrf

    <div class="form-group">
        <label for="name">Nome</label>
        <input type="text" class="form-control" id="name" name="name" required>
    </div>

    <div class="form-group">
        <label for="description">Descrizione</label>
        <textarea class="form-control" id="description" name="description" rows="3" required></textarea>
    </div>

    <div class="form-group">
        <label for="address">Indirizzo</label>
        <input type="text" class="form-control" id="address" name="address" required>
    </div>

    <div class="form-group">
        <label for="price_per_night">Prezzo per Notte (€)</label>
        <input type="number" step="0.01" class="form-control" id="price_per_night" name="price_per_night" required>
    </div>

    <div class="form-group">
        <label for="bedrooms">Camere da Letto</label>
        <input type="number" class="form-control" id="bedrooms" name="bedrooms" required>
    </div>

    <div class="form-group">
        <label for="bathrooms">Bagni</label>
        <input type="number" class="form-control" id="bathrooms" name="bathrooms" required>
    </div>
    <div class="form-group">
        <label for="photos">Foto</label>
        <input type="file" class="form-control" id="photos" name="photos[]" multiple>
    </div>
    <button type="submit" class="btn btn-primary">Salva</button>
    <a href="{{ route('houses.index') }}" class="btn btn-secondary">Annulla</a>
</form>

@endsection
