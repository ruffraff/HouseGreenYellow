@extends('layouts.app')

@section('content')
<h1>{{ __('messages.bookinglist') }}</h1>

<a href="{{ route('bookings.create') }}" class="btn btn-primary mb-3">{{ __('messages.bookingnew') }}</a>

<table class="table">
    <thead>
        <tr>
            <th>{{ __('messages.user') }}</th>
            <th>{{ __('messages.startdate') }}</th>
            <th>{{ __('messages.enddate') }}</th>
            <th>{{ __('messages.actions') }}</th>
        </tr>
    </thead>
    <tbody>
        @foreach($bookings as $booking)
        <tr>
            <td>{{ $booking->user->name }}</td>
            <td>{{ $booking->start_date }}</td>
            <td>{{ $booking->end_date }}</td>
            <td>
                <a href="{{ route('bookings.show', $booking) }}" class="btn btn-info">{{ __('messages.details') }}</a>
                <a href="{{ route('bookings.edit', $booking) }}" class="btn btn-warning">{{ __('messages.edit') }}</a>
                <form action="{{ route('bookings.destroy', $booking) }}" method="POST" style="display:inline;">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger">{{ __('messages.delete') }}</button>
                </form>
            </td>
        </tr>
        @endforeach
    </tbody>
</table>
@endsection
