<script type="text/javascript" src="<?php echo base_url("assets/js/validate/payroll/payrollStart.js?v=2"); ?>"></script>

<script>
	$(document).ready(function() {
		$('.js-example-basic-single').select2();
	});
</script>

<div id="page-wrapper">

	<br>

	<div class="row">
		<div class="col-lg-12">
			<div class="panel panel-default">
				<div class="panel-heading">
					<i class="fa fa-book"></i> <strong>RECORD TASK(S) - PAYROLL</strong>
					<br><small>Time Stamp - Finish</small>
				</div>
				<div class="panel-body">

					<form name="form" id="form" class="form-horizontal" method="post" action="<?php echo base_url("payroll/updatePayroll"); ?>">
						<input type="hidden" id="hddIdentificador" name="hddIdentificador" value="<?php echo $record[0]["id_task"]; ?>" />
						<input type="hidden" id="hddStart" name="hddStart" value="<?php echo $start; ?>" />

						<div class="alert alert-info">
							<strong>Job Code/Name: </strong><?php echo $record[0]["job_start"] ?><br>
							<strong>Employee: </strong><?php echo $record[0]["first_name"] . " " . $record[0]["last_name"] ?><br>
							<strong>Date & Time In: </strong><?php echo $record[0]["start"] ?>
						</div>

						<div class="form-group">
							<label class="col-sm-4 control-label" for="address">Address: </label>
							<div class="col-sm-4">
								<input id="viewaddress" name="viewaddress" class="form-control" type="text" disabled>
								<input id="latitud" name="latitud" type="hidden">
								<input id="longitud" name="longitud" type="hidden">
								<input id="address" name="address" type="hidden">
							</div>
							<div class="col-sm-1">
								<a class="btn btn-success btn-circle" href=" <?php echo base_url() . 'payroll/add_payroll/'; ?> "><i class="fa fa-refresh "></i> </a>
							</div>
						</div>

						<div class="form-group">
							<div class="row" align="center">
								<div style="width:80%;" align="center">
									<div id="map" style="width: 100%; height: 150px"></div>
								</div>
							</div>
						</div>

						<input id="programming" name="programming" type="hidden" value="<?php echo $programming; ?>">
						<input id="job_programming" name="job_programming" type="hidden" value="<?php echo $job_programming; ?>">
						<input id="job_start" name="job_start" type="hidden" value="<?php echo $record[0]["fk_id_job"] ?>">
						<input id="job_start_name" name="job_start_name" type="hidden" value="<?php echo $record[0]["job_start"] ?>">
						<div class="form-group">
							<label class="col-sm-4 control-label" for="jobName">Job Code/Name:
								<?php if ($job_programming) { ?>
									<p class="help-block">Are you <b>logging OUT</b> under this Job Code/Name?</p>
								<?php } ?>
							</label>
							<div class="col-sm-5">
								<select name="jobName" id="jobName" class="form-control js-example-basic-single">
									<option value=''>Select...</option>
									<?php for ($i = 0; $i < count($jobs); $i++) { ?>
										<option value="<?php echo $jobs[$i]["id_job"]; ?>" <?php if ($record[0]["fk_id_job"] == $jobs[$i]["id_job"]) {
																								echo "selected";
																							}; ?>><?php echo $jobs[$i]["job_description"]; ?></option>
									<?php } ?>
								</select>
							</div>
						</div>

						<div class="form-group" id="div_timeFirstJob" style="display: none;">
							<label class="col-sm-4 control-label" for="timeFirstJob">How many hours did you work for <?php echo $record[0]["job_start"] ?>: </label>
							<div class="col-sm-5">
								<input id="timeFirstJob" name="hours_first_project" class="form-control" type="number" min="0" placeholder="Hours" />
							</div>
						</div>

						<div class="form-group">
							<label class="col-sm-4 control-label" for="taskDescription">Observation: </label>
							<div class="col-sm-5">
								<textarea id="observation" name="observation" class="form-control" rows="3"></textarea>
							</div>
						</div>

						<div class="row" align="center">
							<div style="width:70%;" align="center">

								<?php
								$class = "btn-primary";
								if ($record[0]["signature"]) {
									$class = "btn-default";
								?>
									<button type="button" class="btn btn-default" data-toggle="modal" data-target="#myModal">
										<span class="glyphicon glyphicon-eye-open" aria-hidden="true"></span> View Signature
									</button>

									<div id="myModal" class="modal fade" role="dialog">
										<div class="modal-dialog">
											<div class="modal-content">
												<div class="modal-header">
													<button type="button" class="close" data-dismiss="modal">×</button>
													<h4 class="modal-title">Employee Signature</h4>
												</div>
												<div class="modal-body text-center"><img src="<?php echo base_url($record[0]["signature"]); ?>" class="img-rounded" alt="Management/Safety Advisor Signature" width="304" height="236" /> </div>
												<div class="modal-footer">
													<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
												</div>
											</div>
										</div>
									</div>
								<?php } ?>


							</div>
						</div>

						<div class="form-group">
							<div class="col-sm-10 col-sm-offset-1">
								<div class="alert alert-danger">
									By submiting this form, I certify that the unit is fit to be used for the next day.
									Otherwise write an observation.
								</div>

								<div class="alert alert-danger">
									Al enviar este formulario, certifico que la unidad esta en condiciones de ser utilizada para el día siguiente.
									De otra manera escriba una observación.
								</div>
							</div>
						</div>

						<div class="row" align="center">
							<div style="width:50%;" align="center">
								<button type="submit" id="btnSubmit" name="btnSubmit" class="btn btn-primary">
									Submit <span class="glyphicon glyphicon-log-in" aria-hidden="true">
								</button>
							</div>
						</div>
					</form>
				</div>
			</div>
		</div>
	</div>
</div>

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
		geocoder.geocode({
			'latLng': yourLocation
		}, processGeocoder);

	}

	function processGeocoder(results, status) {

		if (status == google.maps.GeocoderStatus.OK) {
			if (results[0]) {
				document.forms[0].address.value = results[0].formatted_address;
				document.forms[0].viewaddress.value = results[0].formatted_address;
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
		var pais = new google.maps.LatLng(51.0209884, -114.1591999);
		var mapOptions = {
			center: pais,
			zoom: 11,
			mapTypeId: google.maps.MapTypeId.ROADMAP
		};

		map = new google.maps.Map(document.getElementById('map'), mapOptions);



		//Inicializa el objeto geocoder
		geocoder = new google.maps.Geocoder();

		navigator.geolocation.getCurrentPosition(success, error, options);

	}
</script>

<script async defer
	src="https://maps.googleapis.com/maps/api/js?key=AIzaSyDi5PwRbCh0Jsgqgtnrc6dsb7za4wyq3c8&libraries=places&callback=initMap">
</script>