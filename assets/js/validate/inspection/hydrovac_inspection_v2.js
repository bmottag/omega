$( document ).ready( function () {
	$("#hours").bloquearTexto().maxlength(10);
	$("#hours2").bloquearTexto().maxlength(10);
	$("#hours3").bloquearTexto().maxlength(10);

	$( "#form" ).validate( {
		rules: {
			hours: 				{ number: true, minlength: 2, maxlength: 10 },
			hours2: 			{ number: true, minlength: 2, maxlength: 10 },
			hours3: 			{ number: true, minlength: 2, maxlength: 10 },
			belt:				{ required: true },
			powerSteering:		{ required: true },
			oil:				{ required: true },
			coolantLevel:		{ required: true },
			coolantLeaks:		{ required: true },
			headLamps:			{ required: true },
			hazardLights:		{ required: true },
			clearanceLights:	{ required: true },
			tailLights:			{ required: true },
			workLights:			{ required: true },
			turnSignals:		{ required: true },
			beaconLights:		{ required: true },
			tires:				{ required: true },
			windows:			{ required: true },
			cleanExterior:		{ required: true },
			wipers:				{ required: true },
			backupBeeper:		{ required: true },
			door:				{ required: true },
			decals:				{ required: true },
			SteringWheels:		{ required: true },
			drives:				{ required: true },
			frontDrive:			{ required: true },
			middleDrive:		{ required: true },
			backDrive:			{ required: true },
			transfer:			{ required: true },
			tailGate:			{ required: true },
			boom:				{ required: true },
			lockBar:			{ required: true },
			brake:				{ required: true },
			emergencyBrake:		{ required: true },
			gauges:				{ required: true },
			horn:				{ required: true },
			seatbelt:			{ required: true },
			seat:				{ required: true },
			insurance:			{ required: true },
			registration:		{ required: true },
			cleanInterior:		{ required: true },
			fire:				{ required: true },
			aid:				{ required: true },
			emergencyKit:		{ required: true },
			spillKit:			{ required: true },
			cartige:			{ required: true },
			pump:				{ required: true },
			washHose:			{ required: true },
			pressureHose:		{ required: true },
			pumpOil:			{ required: true },
			hydraulicOil:		{ required: true },
			gearCase:			{ required: true },
			hydraulic:			{ required: true },
			control:			{ required: true },
			panel:				{ required: true },
			foam:				{ required: true },
			heater:				{ required: true },
			steering_wheel:		{ required: true },
			suspension_system:	{ required: true },
			air_brake:			{ required: true },
			fuel_system:		{ required: true },
			def:		        { required: true }
		},
		errorElement: "em",
		errorPlacement: function ( error, element ) {
			// Add the `help-block` class to the error element
			error.addClass( "help-block" );
			error.insertAfter( element );

		},
		highlight: function ( element, errorClass, validClass ) {
			$( element ).parents( ".col-sm-5" ).addClass( "has-error" ).removeClass( "has-success" );
		},
		unhighlight: function (element, errorClass, validClass) {
			$( element ).parents( ".col-sm-5" ).addClass( "has-success" ).removeClass( "has-error" );
		},
		submitHandler: function (form) {
			return true;
		}
	});

	$("#btnSubmit").click(function(){

		if ($("#form").valid() == true){
				//Activa icono guardando
				$('#btnSubmit').attr('disabled','-1');
				$("#div_load").css("display", "inline");
				$("#div_error").css("display", "none");

				$.ajax({
					type: "POST",
					url: base_url + "inspection/save_hydrovac_inspection",
					data: $("#form").serialize(),
					dataType: "json",
					contentType: "application/x-www-form-urlencoded;charset=UTF-8",
					cache: false,

					success: function(data){

						if( data.result == "error" )
						{
							alert(data.mensaje);
							$("#div_load").css("display", "none");
							$('#btnSubmit').removeAttr('disabled');
							$("#span_msj").html(data.mensaje);
							$("#div_error").css("display", "inline");
							return false;
						}
						if( data.result )//true
						{
							$("#div_load").css("display", "none");
							$('#btnSubmit').removeAttr('disabled');

							var url = base_url + "inspection/add_hydrovac_inspection/" + data.idHydrovacInspection;
							$(location).attr("href", url);
						}
						else
						{
							alert('Error. Reload the web page.');
							$("#div_load").css("display", "none");
							$("#div_error").css("display", "inline");
							$('#btnSubmit').removeAttr('disabled');
						}
					},
					error: function(result) {
						alert('Error. Reload the web page.');
						$("#div_load").css("display", "none");
						$("#div_error").css("display", "inline");
						$('#btnSubmit').removeAttr('disabled');
					}
				});
		}
		else
		{
			alert('There are missing fields that have not been filled.');
		}
	});
});