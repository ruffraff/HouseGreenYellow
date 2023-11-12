@extends('layouts.app')

@section('content')

<div class="container">
    <h1 class="mb-4">{{ __('messages.welcome') }}</h1>
    
    <section class="houses">
        <h2>{{ __('messages.featured_houses') }}</h2>
        @foreach($houses as $house)
            <div class="house">
                <!-- Show house details like name, description, etc. -->
                <h3>{{ $house->name }}</h3>
                <p>{{ $house->description }}</p>
                <!-- You can also display house images here, if you have them -->
            </div>
        @endforeach
    </section>

    <section class="reviews mt-5">
        <h2>{{ __('messages.latest_reviews') }}</h2>
        @foreach($reviews as $review)
            <div class="review">
                <!-- Show review details -->
                <p>{{ $review->content }}</p>
                <small>{{ __('messages.by') }} {{ $review->user->name }}</small> <!-- Assuming each review has an associated user -->
            </div>
        @endforeach
    </section>
    <section class="links">
        <a href="{{ route('contacts.index') }}">{{ __('messages.contact_us') }}</a>
        <a href="{{ route('reviews.index') }}">{{ __('messages.read_reviews') }}</a>
    </section>
    <!-- You might also want to add a contact form here, if desired -->

</div>

@endsection