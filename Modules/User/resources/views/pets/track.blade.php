@extends('layouts.app')

@push('custome-css')
    <style>
        /* Set map height */
        #map {
            width: 100%;
            height: 900px;
            border-radius: 8px;
        }
    </style>
@endpush

@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="d-flex justify-content-between align-items-center mb-4">
                    <h1>Pet Details</h1>
                    <div>
                        <a href="{{ route('admin.pets.edit', $pet) }}" class="btn btn-warning">Edit</a>
                        <a href="{{ route('admin.pets.index') }}" class="btn btn-secondary">Back to List</a>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-12">
                        <div class="card">
                            <div class="card-header">
                                <h5>Pet Information</h5>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <!-- Google Map -->
                                    <div id="map"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
@endsection


{{-- Load Google Maps API (replace YOUR_API_KEY with your actual key) --}}
<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyCf5XmyfYbP5UTzTpzcRobWu4nSCyGg8uE&callback=initMap" async
    defer></script>
@php
    $trackPoints = $trackData->map(function ($item) {
        return [
            'lat' => (float) $item->latitude,
            'lng' => (float) $item->longitude,
            'time' => $item->created_at ? $item->created_at->toDateTimeString() : null,
        ];
    });
@endphp
<script>
    function initMap() {
        // Convert PHP collection to JS array
        var trackData = @json($trackPoints);

        if (!trackData || trackData.length === 0) {
            alert("No tracking data available.");
            return;
        }

        // Initialize map centered on the first point
        var map = new google.maps.Map(document.getElementById('map'), {
            zoom: 18,
            center: {
                lat: trackData[0].lat,
                lng: trackData[0].lng
            }
        });

        // Loop through points and drop markers
        trackData.forEach(function(point, index) {
            var marker = new google.maps.Marker({
                position: {
                    lat: point.lat,
                    lng: point.lng
                },
                map: map,
                icon: {
                    url: 'data:image/svg+xml;charset=UTF-8,' + encodeURIComponent(`
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512">
                        <path fill="red" d="M290.59 192c-20.18 0-106.82 1.98-162.59 85.95V192c0-52.94-43.06-96-96-96-17.67 0-32 14.33-32 32s14.33 32 32 32c17.64 0 32 14.36 32 32v256c0 35.3 28.7 64 64 64h176c8.84 0 16-7.16 16-16v-16c0-17.67-14.33-32-32-32h-32l128-96v144c0 8.84 7.16 16 16 16h32c8.84 0 16-7.16 16-16V289.86c-10.29 2.67-20.89 4.54-32 4.54-61.81 0-113.52-44.05-125.41-102.4zM448 96h-64l-64-64v134.4c0 53.02 42.98 96 96 96s96-42.98 96-96V32l-64 64zm-72 80c-8.84 0-16-7.16-16-16s7.16-16 16-16 16 7.16 16 16-7.16 16-16 16zm80 0c-8.84 0-16-7.16-16-16s7.16-16 16-16 16 7.16 16 16-7.16 16-16 16z"/>
                    </svg>
                        `),
                    scaledSize: new google.maps.Size(40, 40)
                },

                label: (index + 1).toString(),
                title: "Tracked at: " + point.time
            });

            var infoWindow = new google.maps.InfoWindow({
                content: "<b>Track Point " + (index + 1) + "</b><br>Lat: " + point.lat + ", Lng: " +
                    point.lng + "<br>Time: " + point.time
            });

            marker.addListener('click', function() {
                infoWindow.open(map, marker);
            });
        });

        // Draw polyline connecting all points
        var path = trackData.map(function(p) {
            return {
                lat: p.lat,
                lng: p.lng
            };
        });

        new google.maps.Polyline({
            path: path,
            geodesic: true,
            strokeColor: "#FF0000",
            strokeOpacity: 1.0,
            strokeWeight: 2,
            map: map
        });
    }
</script>
