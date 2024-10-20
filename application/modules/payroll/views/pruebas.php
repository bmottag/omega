<script src="https://maps.googleapis.com/maps/api/js?v=3.exp&libraries=places&key=AIzaSyCfIWTef-ODOCqOG74vuCNdoUZWh2BAfMU"></script>


<div id="page-wrapper">
	<br>
	
	<!-- /.row -->
	<div class="row">
		<div class="col-lg-12">
			<div class="panel panel-primary">
				<div class="panel-heading">
					<i class="fa fa-book"></i> <strong>RECORD TASK(S) - PAYROLL</strong>
					<br><small>Time Stamp - Start</small>
				</div>
				<div class="panel-body">
					<form  name="form" id="form" class="form-horizontal" method="post" >
																											

<!-- Autocomplete location search input --> 
<div class="form-group">
    <label>Location:</label>
    <input type="text" class="form-control" id="search_input" placeholder="Type address..." />
    <input type="hidden" id="loc_lat" />
    <input type="hidden" id="loc_long" />
</div>

<!-- Display latitude and longitude -->
<div class="latlong-view">
    <p><b>Latitude:</b> <span id="latitude_view"></span></p>
    <p><b>Longitude:</b> <span id="longitude_view"></span></p>
</div>
						
					</form>
					<!-- /.row (nested) -->
				</div>
				<!-- /.panel-body -->
			</div>
			<!-- /.panel -->
		</div>
		<!-- /.col-lg-12 -->
	</div>
	<!-- /.row -->
</div>
<!-- /#page-wrapper -->
		

		
  <script>

var searchInput = 'search_input';

$(document).ready(function () {
    var autocomplete;
    autocomplete = new google.maps.places.Autocomplete((document.getElementById(searchInput)), {
        types: ['geocode'],
    });
        
    google.maps.event.addListener(autocomplete, 'place_changed', function () {
        var near_place = autocomplete.getPlace();
        document.getElementById('loc_lat').value = near_place.geometry.location.lat();
        document.getElementById('loc_long').value = near_place.geometry.location.lng();
                
        document.getElementById('latitude_view').innerHTML = near_place.geometry.location.lat();
        document.getElementById('longitude_view').innerHTML = near_place.geometry.location.lng();
        
        // Obtén la dirección seleccionada y realice la geocodificación
        var selectedAddress = near_place.formatted_address;
        geocodeAddress(selectedAddress);
    });
});

$(document).on('change', '#'+searchInput, function () {
    document.getElementById('latitude_input').value = '';
    document.getElementById('longitude_input').value = '';
        
    document.getElementById('latitude_view').innerHTML = '';
    document.getElementById('longitude_view').innerHTML = '';
});

// Crea un nuevo objeto Geocoder
var geocoder = new google.maps.Geocoder();

// Función para geocodificar una dirección
function geocodeAddress(address) {
    geocoder.geocode({ 'address': address }, function(results, status) {
        if (status === 'OK') {
            // Se encontró una coincidencia de geocodificación
            if (results[0]) {
                // Accede a los componentes de la dirección
                var calle = "";
                var codigoPostal = "";
                var ciudad = "";
                var estado = "";
                var pais = "";

                for (var i = 0; i < results[0].address_components.length; i++) {
                    var component = results[0].address_components[i];
                    var types = component.types;

                    // Verifica los tipos de componentes y almacena los valores en las variables correspondientes
                    if (types.includes('street_number')) {
                        calle += component.long_name + " ";
                    } else if (types.includes('route')) {
                        calle += component.long_name;
                    } else if (types.includes('postal_code')) {
                        codigoPostal = component.long_name;
                    } else if (types.includes('locality')) {
                        ciudad = component.long_name;
                    } else if (types.includes('administrative_area_level_1')) {
                        estado = component.long_name;
                    } else if (types.includes('country')) {
                        pais = component.long_name;
                    }
                }

                // Ahora tienes los componentes de la dirección en variables separadas
                console.log("Calle: " + calle);
                console.log("Código Postal: " + codigoPostal);
                console.log("Ciudad: " + ciudad);
                console.log("Estado: " + estado);
                console.log("País: " + pais);
            }
        } else {
            // No se encontraron resultados de geocodificación
            console.error('No se pudo geocodificar la dirección debido a: ' + status);
        }
    });
}

  </script>
