@extends('layouts.app')

@section('content')
<h1>{{ __('messages.detailsbooking') }}</h1>

<p><strong>Utente:</strong> {{ $booking->user->name }}</p>
<p><strong>Casa:</strong> {{ $booking->house->name }}</p>
<p><strong>Data Inizio:</strong> {{ $booking->start_date }}</p>
<p><strong>Data Fine:</strong> {{ $booking->end_date }}</p>

<a href="{{ route('bookings.edit', $booking) }}" class="btn btn-warning">{{ __('messages.edit') }}</a>
<a href="{{ route('bookings.index') }}" class="btn btn-secondary">{{ __('messages.backtolist') }}</a>
@endsection
