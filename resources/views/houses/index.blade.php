@extends('layouts.app')

@section('content')

<h1>{{ __('messages.houselist') }}</h1>

<a href="{{ route('houses.create') }}" class="btn btn-primary mb-3">{{ __('messages.newhouse') }}</a>

<table>
    <thead>
        <tr>
            <th>{{ __('messages.name') }}</th>
            <th>{{ __('messages.description') }}</th>
            <th>{{ __('messages.address') }}</th>
            <th>{{ __('messages.pricefornight') }}</th>
            <th>{{ __('messages.photo') }}</th>
            <th>{{ __('messages.actions') }}</th>
            
        </tr>
    </thead>
    <tbody>
        @foreach($houses as $house)
            <tr>
                <td>{{ $house->name }}</td>
                <td>{{ \Illuminate\Support\Str::limit($house->description, 50, '...') }}</td>
                <td>{{ $house->address }}</td>
                <td>{{ $house->price_per_night }} €</td>
                <td>@if($house->photos->count() > 0)
                        <img src="{{ asset('storage/' . $house->photos[0]->filename) }}" alt="Foto di {{ $house->name }}" width="100">
                        @else
    <!-- Mostra un messaggio se non ci sono foto -->

                @endif</td>
                <td>
                    <a href="{{ route('houses.show', $house->id) }}" class="btn btn-info btn-sm">{{ __('messages.details') }}</a>
                    <a href="{{ route('houses.edit', $house->id) }}" class="btn btn-warning btn-sm">{{ __('messages.edit') }}</a>
                    
                    
                    <form action="{{ route('houses.destroy', $house->id) }}" method="POST" style="display:inline;">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger btn-sm">{{ __('messages.delete') }}</button>
                    </form>
                </td>
            </tr>
        @endforeach
    </tbody>
</table>

@endsection
