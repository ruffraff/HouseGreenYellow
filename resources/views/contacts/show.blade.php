@extends('layouts.app')

@section('content')
<h1>Dettagli Contatto</h1>

<p><strong>Nome:</strong> {{ $contact->name }}</p>
<p><strong>Email:</strong> {{ $contact->email }}</p>
<p><strong>Telefono:</strong> {{ $contact->phone }}</p>
<p><strong>Indirizzo:</strong> {{ $contact->address }}</p>
<p><strong>Messaggio:</strong> {{ $contact->message }}</p>

<!-- Mappa Google Maps -->
<!--<div id="map" style="height:400px; width:100%;"></div>-->

<script>
    function initMap() {
       // var location = {lat: {{ $contact->latitude }}, lng: {{ $contact->longitude }}};
        // var map = new google.maps.Map(document.getElementById('map'), {
        //     zoom: 15,
        //     center: location
        // });
        // var marker = new google.maps.Marker({
        //     position: location,
        //     map: map
        // });
    }
</script>
<script async defer
    src="https://maps.googleapis.com/maps/api/js?key=TUA_CHIAVE_API&callback=initMap">
</script>
@endsection
