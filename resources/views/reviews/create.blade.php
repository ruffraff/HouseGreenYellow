@extends('layouts.app')

@section('content')
<h1>Scrivi una recensione</h1>

<form action="{{ route('reviews.store') }}" method="POST">
    @csrf
    <textarea name="content" required></textarea>
    <button type="submit">Invia</button>
</form>
@endsection
