@extends('layouts.app')

@section('content')
<h1>{{ __('messages.contactlist') }}</h1>
<a href="{{ route('contacts.create') }}" class="btn btn-primary mb-3">{{ __('messages.contactnew') }}</a>
<table class="table">
    <thead>
        <tr>
            <th>{{ __('messages.name') }}</th>
            <th>{{ __('messages.email') }}</th>
            <th>{{ __('messages.phone') }}</th>
            <th>{{ __('messages.actions') }}</th>
        </tr>
    </thead>
    <tbody>
  
        @foreach($contacts as $contact)
        <tr>
            <td>{{ $contact->name }}</td>
            <td>{{ $contact->email }}</td>
            <td>{{ $contact->phone }}</td>
            <td>
                <a href="{{ route('contacts.show', $contact) }}" class="btn btn-info">Dettagli</a>
            </td>
        </tr>
        @endforeach

    </tbody>
</table>
@endsection
