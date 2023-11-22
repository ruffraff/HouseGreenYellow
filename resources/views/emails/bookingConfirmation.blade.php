<!DOCTYPE html>
<html>
<head>
    <title>{{ __('messages.confirmation_title') }}</title>
    <!-- Stili... -->
</head>
<body>
    <div class="container">
        <div class="header">
            <h2>{{ __('messages.confirmation_title') }}</h2>
        </div>

        <!-- Contenuto Email... -->
        <p>{{ __('messages.greeting') }} : {{ $bookingDetails->user->name }}</p>
        <p>{{ __('messages.details_intro') }}</p>

        <!-- Dettagli Prenotazione... -->
        <p><strong> {{ __('messages.property_name') }}:</strong> {{ $bookingDetails->house->name }}</p>
        <!-- Altri dettagli... -->

        <!-- Saluti Finali... -->
        <p>{{ __('messages.thank_you') }}</p>
         
    </div>
</body>
</html>
