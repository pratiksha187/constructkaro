<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Geoapify Map Integration</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- jQuery -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <!-- Leaflet (Map Renderer) -->
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />
    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
    <style>
        body { font-family: Arial, sans-serif; margin: 20px; }
        #map { width: 100%; height: 400px; margin-top: 20px; border-radius: 8px; }
        input, button { padding: 8px; margin-right: 5px; }
        button { background: #1c2c3e; color: #fff; border: none; border-radius: 5px; cursor: pointer; }
        button:hover { background: #f25c05; }
    </style>
</head>
<body>
    <h2>Geoapify Location</h2>

    <div>
        <input type="text" id="location" placeholder="Enter Land Location">
        <input type="text" id="survey_no" placeholder="Enter Survey No">
        <button id="getMap">Get Location</button>
    </div>

    <div id="map"></div>

    <script>
        let map, marker;

        $('#getMap').on('click', function() {
            let location = $('#location').val();
            let survey_no = $('#survey_no').val();

            if (!location) return alert('Please enter a location');

            $.ajax({
                url: '/get-geoapify-location',
                method: 'POST',
                data: {
                    location: location,
                    survey_no: survey_no,
                    _token: '{{ csrf_token() }}'
                },
                success: function(response) {
                    let lat = response.lat;
                    let lng = response.lng;

                    if (!map) {
                        map = L.map('map').setView([lat, lng], 15);
                        L.tileLayer(`https://maps.geoapify.com/v1/tile/osm-bright/{z}/{x}/{y}.png?apiKey={{ env('GEOAPIFY_API_KEY') }}`, {
                            attribution: '© OpenStreetMap contributors © Geoapify',
                        }).addTo(map);
                    } else {
                        map.setView([lat, lng], 15);
                    }

                    if (marker) marker.remove();

                    marker = L.marker([lat, lng]).addTo(map)
                        .bindPopup(response.formatted_address)
                        .openPopup();
                },
                error: function() {
                    alert('Location not found or API error.');
                }
            });
        });
    </script>
</body>
</html>
