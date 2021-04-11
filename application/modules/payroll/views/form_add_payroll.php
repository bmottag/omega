<script type="text/javascript" src="<?php echo base_url("assets/js/validate/payroll/payrollStart_V3.js"); ?>"></script>

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
					<form  name="form" id="form" class="form-horizontal" method="post" action="<?php echo base_url("payroll/savePayroll"); ?>" >
																											
						<!-- Task : Time Stamp  -->
						<input type="hidden" id="hddTask" name="hddTask" value="1"/>
						
						<div class="form-group">
							<label class="col-sm-4 control-label" for="address">Address</label>
							<div class="col-sm-4">
								<input id="viewaddress" name="viewaddress" class="form-control" type="text" disabled >
								<input id="latitud" name="latitud" type="hidden">					
								<input id="longitud" name="longitud" type="hidden">	
								<input id="address" name="address" type="hidden">									
							</div>
							<div class="col-sm-1">
								<a class="btn btn-success btn-circle" href=" <?php echo base_url().'payroll/add_payroll/'; ?> "><i class="fa fa-refresh "></i> </a> 
							</div>
						</div>										
						
						<div class="form-group">	
							<div class="row" align="center">
								<div style="width:80%;" align="center">
									<div id="map" style="width: 100%; height: 150px"></div>	
								</div>
							</div>	
						</div>									
												
						<div class="form-group">
							<label class="col-sm-4 control-label" for="jobName">Job Code/Name</label>
							<div class="col-sm-5">
								<select name="jobName" id="jobName" class="form-control" >
									<option value=''>Select...</option>
									<?php for ($i = 0; $i < count($jobs); $i++) { ?>
										<option value="<?php echo $jobs[$i]["id_job"]; ?>" ><?php echo $jobs[$i]["job_description"]; ?></option>	
									<?php } ?>
								</select>
							</div>
						</div>
						
						<div class="form-group">
							<label class="col-sm-6 control-label" for="certify">
									I certify to be clean for the last 8 hours of any substance such: 
recreational cannabis, alcohol, drugs or any over the counter medicine that may or will affect 
the fitness of my work performance.
							</label>
							<div class="col-sm-3">
								<select name="certify" id="certify" class="form-control" required>
									<option value="">Select...</option>
									<option value=1 >Yes</option>
									<option value=2 >No</option>
								</select>
							</div>
						</div>

	<div class="row">
		<div class="col-lg-12">	
            <div class="panel panel-default">
                
                <div class="panel-body">
                	<div class="row">
                		<div class="col-lg-12">	
                			<p class="text-danger"><strong>COVID-19 screening questions</strong></p>
                		</div>
                	</div>
                	<small>
	                    <p class="text-danger">Please help us prevent spread. Read the following information carefully.</p>

	                    <p class="text-danger">
						VCI is currently taking measures to ensure our staff and others' safety by limiting exposure risk. Please help us prevent the spread of COVID-19; read carefully and answer the questions below.
						</p>

				    	<strong class="text-danger">1. Are you experiencing any of these symptoms?</strong>
					    <ul>
					    	<li class="text-danger">New or worsening cough.</li>
					        <li class="text-danger">Shortness of breath or difficulty breathing.</li>
					        <li class="text-danger">Temperature equal to or over 38&deg;C.</li>
					        <li class="text-danger">Feeling feverish.</li>
					        <li class="text-danger">Chills.</li>
					        <li class="text-danger">Fatigue or weakness.</li>
					        <li class="text-danger">Muscle or body aches.</li>
					        <li class="text-danger">Headache.</li>
					        <li class="text-danger">New loss of smell or taste.</li>
					        <li class="text-danger">Gastrointestinal symptoms (abdominal pain, diarrhea, vomiting).</li>
					        <li class="text-danger">Feeling very unwell.</li>
						</ul>
			
				    	<strong class="text-danger">2. Has anyone in your household experienced any of these symptoms in the past 14 days? </strong>
				    	<br>
						<strong class="text-danger">3. In the past 14 days, have you been identified as a close contact of someone with suspected or confirmed COVID-19?</strong>
						<br>
						<strong class="text-danger">4. Have you travelled outside Canada in the past 14 days or been in contact with anyone who has travelled outside Canada in the past 14 days?</strong> 
						<br><br>
						<p class="text-danger">* Please act accordingly to the previous screening questions.</p>
					</small>
					<div class="form-group">
						<label class="col-sm-6 control-label text-danger" for="covid">
							  If the answer to any of the questions from 1-4 is "Yes."  Please do not enter any VCI site or our main office. Immediately contact your manager and the local public health authority at 1-833-415-9179.
						</label>
						<div class="col-sm-3">
							<select name="covid" id="covid" class="form-control" required>
								<option value="">Select...</option>
								<option value=1 >Yes</option>
								<option value=2 >No</option>
							</select>
						</div>
					</div>
					
                </div>
                <!-- /.panel-body -->
            </div>
            <!-- /.panel -->
        </div>
	</div>
												
						<div class="form-group">
							<label class="col-sm-4 control-label" for="taskDescription">Task/Report Description</label>
							<div class="col-sm-5">
							<textarea id="taskDescription" name="taskDescription" class="form-control" rows="3"></textarea>
							</div>
						</div>
												
						<div class="row" align="center">
							<div style="width:50%;" align="center">
								 <button type="submit" class="btn btn-primary" id='btnSubmit' name='btnSubmit'>Submit </button>
							</div>
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
    // The following example creates complex markers to indicate beaches near
	// Sydney, NSW, Australia. Note that the anchor is set to (0,32) to correspond
	// to the base of the flagpole.

	var options = {
	  enableHighAccuracy: true,
	  timeout: 5000,
	  maximumAge: 0
	};

	function success(pos) {
	  var crd = pos.coords;

	  console.log('Your current position is:');
	  console.log('Latitude : ' + crd.latitude);
	  console.log('Longitude: ' + crd.longitude);
	  console.log('More or less ' + crd.accuracy + ' meters.');
	  $("#latitud").val(crd.latitude);
	  $("#longitud").val(crd.longitude);
	  var pos = {
				  lat: crd.latitude,
				  lng: crd.longitude
				};
	  map.setCenter(pos);
	  map.setZoom(14);
	  
	showLatLong(crd.latitude, crd.longitude);
	  
	  ultimaPosicionUsuario = new google.maps.LatLng(crd.latitude, crd.longitude);
      marcadorUsuario = new google.maps.Marker({
        position: ultimaPosicionUsuario,
        map: map
      });
	};

	function error(err) {
	  console.warn('ERROR(' + err.code + '): ' + err.message);
	};

	function handleLocationError(browserHasGeolocation, infoWindow, pos) {
		infoWindow.setPosition(pos);
		infoWindow.setContent(browserHasGeolocation ?
							  'Error: Error en el servicio de localizacion.' :
							  'Error: Navegador no soporta geolocalizacion.');
	  }
	

/**
 * INICIO --- Capturar direccion
 * http://www.elclubdelprogramador.com/2012/04/22/html5-obteniendo-direcciones-a-partir-de-latitud-y-longitud-geolocalizacion/
 */
function showLatLong(lat, longi) {
var geocoder = new google.maps.Geocoder();
var yourLocation = new google.maps.LatLng(lat, longi);
geocoder.geocode({ 'latLng': yourLocation },processGeocoder);

}
function processGeocoder(results, status){

if (status == google.maps.GeocoderStatus.OK) {
if (results[0]) {
document.forms[0].address.value=results[0].formatted_address;
document.forms[0].viewaddress.value=results[0].formatted_address;
} else {
error('Google no retorno resultado alguno.');
}
} else {
error("Geocoding fallo debido a : " + status);
}
}
/**
 * FIN
 */	
	
	function initMap() {
		var pais = new google.maps.LatLng(51.0209884,-114.1591999);
		var mapOptions = {
			center: pais,
			zoom: 11,
			mapTypeId: google.maps.MapTypeId.ROADMAP
		};
		
		map = new google.maps.Map(document.getElementById('map'), mapOptions);
		
		
		
		//Inicializa el objeto geocoder
		geocoder = new google.maps.Geocoder();
				
		navigator.geolocation.getCurrentPosition(success, error, options);
		
		/*var infoWindow = new google.maps.InfoWindow({map: map});
		// Try HTML5 geolocation.
        if (navigator.geolocation) {
			  navigator.geolocation.getCurrentPosition(function(position) {
				var pos = {
				  lat: position.coords.latitude,
				  lng: position.coords.longitude
				};

				infoWindow.setPosition(pos);
				infoWindow.setContent('Su ubicacion.');
				map.setCenter(pos);
			  }, function() {
				handleLocationError(true, infoWindow, map.getCenter());
			  });
			} else {
			  // Browser doesn't support Geolocation
			  handleLocationError(false, infoWindow, map.getCenter());
			}
*/
	}	

  </script>

			
	<!--<script async defer
		src="https://maps.googleapis.com/maps/api/js?key=AIzaSyDt__a_n1IUtBPqj9ntMD5cNG8gYlcovWM&libraries=places&callback=initMap">
		http://maps.googleapis.com/maps/api/js?key=AIzaSyDt__a_n1IUtBPqj9ntMD5cNG8gYlcovWM&libraries=places&callback=initMap"
	</script>-->
	<script async defer		
		src="https://maps.googleapis.com/maps/api/js?key=AIzaSyDt__a_n1IUtBPqj9ntMD5cNG8gYlcovWM&libraries=places&callback=initMap">
	</script>