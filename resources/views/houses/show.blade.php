@extends('layouts.app')

@section('content')

<div class="card">
    <div class="card-header">
        Dettagli Casa
    </div>
    <div class="card-body">
        <h5 class="card-title">{{ $house->name }}</h5>
        <p class="card-text"><strong>{{ __('messages.description') }}:</strong> {{ $house->description }}</p>
        <p class="card-text"><strong>{{ __('messages.address') }}:</strong> {{ $house->address }}</p>
        <p class="card-text"><strong>{{ __('messages.pricefornight') }}:</strong> {{ $house->price_per_night }} €</p>
        <p class="card-text"><strong>{{ __('messages.bedrooms') }}:</strong> {{ $house->bedrooms }}</p>
        <p class="card-text"><strong>{{ __('messages.bathrooms') }}:</strong> {{ $house->bathrooms }}</p>
        <p class="card-text"><strong> @foreach($house->photos as $photo)

        <a href="{{ route('houses.photos', $house) }}">
    <img src="{{ asset('storage/' . $photo->filename) }}" alt="{{ $photo->description }}">
</a>
         <img src="{{ asset('storage/' . $photo->filename) }}" alt="Foto di {{ $house->name }}" width="100">
        @endforeach
        </p>
        <a href="{{ route('houses.index') }}" class="btn btn-secondary">Torna alla lista</a>
        <a href="{{ route('houses.edit', $house->id) }}" class="btn btn-warning">Modifica</a>
        
        <form action="{{ route('houses.destroy', $house->id) }}" method="POST" style="display:inline;">
            @csrf
            @method('DELETE')
            <button type="submit" class="btn btn-danger">Elimina</button>
        </form>
    </div>
</div>

@endsection
