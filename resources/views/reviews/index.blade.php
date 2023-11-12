@extends('layouts.app')

@section('content')
<h1>Recensioni</h1>

@foreach($reviews as $review)
    <div class="review">
        <p>{{ $review->content }}</p>
        <small>Scritto da {{ $review->user->name }}</small> <!-- Presumendo che tu abbia una relazione tra Review e User -->
    </div>
@endforeach
@endsection