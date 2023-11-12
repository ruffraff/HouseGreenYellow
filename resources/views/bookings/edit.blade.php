@extends('layouts.app')

@section('content')
<h1>{{ isset($booking) ?  __('messages.editbooking')  :  __('messages.newbooking')  }}</h1>

<form action="{{ isset($booking) ? route('bookings.update', $booking) : route('bookings.store') }}" method="POST">
    @csrf
    @if(isset($booking))
        @method('PUT')
    @endif
    @if ($errors->has('date'))
    <div class="alert alert-danger">
        {{ $errors->first('date') }}
    </div>
    @endif
    <div class="form-group">
        <label for="house_id">{{ __('messages.home') }}</label>
        <select name="house_id" id="house_id" class="form-control">
            @foreach($houses as $house)
                <option value="{{ $house->id }}" {{ isset($booking) && $booking->house_id == $house->id ? 'selected' : '' }}>{{ $house->name }}</option>
            @endforeach
        </select>
    </div>

    <div class="form-group">
        <label for="start_date">{{ __('messages.startdate') }}</label>
        <input type="date" name="start_date" id="start_date" class="form-control" value="{{ isset($booking) ? $booking->start_date : '' }}">
    </div>

    <div class="form-group">
        <label for="end_date">{{ __('messages.enddate') }}</label>
        <input type="date" name="end_date" id="end_date" class="form-control" value="{{ isset($booking) ? $booking->end_date : '' }}">
    </div>

    <button type="submit" class="btn btn-primary">{{ __('messages.save') }}</button>
</form>
@endsection
