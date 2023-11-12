@extends('layouts.app')

@section('content')
<h1>{{ isset($contact) ?  __('messages.editcontact')  : __('messages.newcontact') }}</h1>

<form action="{{ isset($contact) ? route('contacts.update', $contact) : route('contacts.store') }}" method="POST">
    @csrf
    @if(isset($contact))
        @method('PUT')
    @endif

    <div class="form-group">
        <label for="name">{{ __('messages.name') }}</label>
        <input type="text" name="name" id="name" class="form-control" value="{{ isset($contact) ? $contact->name : '' }}">
    </div>

    <div class="form-group">
        <label for="email">{{ __('messages.email') }}</label>
        <input type="email" name="email" id="email" class="form-control" value="{{ isset($contact) ? $contact->email : '' }}">
    </div>

    <div class="form-group">
        <label for="phone">{{ __('messages.phone') }}</label>
        <input type="text" name="phone" id="phone" class="form-control" value="{{ isset($contact) ? $contact->phone : '' }}">
    </div>

    <div class="form-group">
        <label for="address">{{ __('messages.address') }}</label>
        <textarea name="address" id="address" class="form-control">{{ isset($contact) ? $contact->address : '' }}</textarea>
    </div>

    <div class="form-group">
        <label for="message">{{ __('messages.message') }}</label>
        <textarea name="message" id="message" class="form-control">{{ isset($contact) ? $contact->message : '' }}</textarea>
    </div>

    <!-- Campi nascosti per la latitudine e la longitudine -->
    <input type="hidden" name="latitude" id="latitude" value="{{ isset($contact) ? $contact->latitude : '' }}">
    <input type="hidden" name="longitude" id="longitude" value="{{ isset($contact) ? $contact->longitude : '' }}">

    <button type="submit" class="btn btn-primary">{{ __('messages.save') }}</button>
</form>
@endsection
