$( document ).ready( function () {

	jQuery.validator.addMethod("validacion", function(value, element, param) {
		// Obtener los valores de los campos necesarios
		var start_hour = parseInt($('#start_hour').val(), 10);
		var start_min = parseInt($('#start_min').val(), 10);
		var finish_hour = parseInt($('#finish_hour').val(), 10);
		var finish_min = parseInt($('#finish_min').val(), 10);
		var working_hours_new = parseInt($('#workHours').val(), 10);

		// Convertir todo a minutos para facilitar la suma y comparación
		let start_minutes = start_hour * 60 + start_min;
		let finish_minutes = finish_hour * 60 + finish_min;
		let work_hours_minutes = working_hours_new * 60;

		// Calcular el tiempo trabajado en minutos
		let tiempo_trabajado = finish_minutes - start_minutes;

		// Asegurarse de que el tiempo trabajado sea positivo
		if (tiempo_trabajado < 0) {
			tiempo_trabajado += 24 * 60; // Asumiendo que el trabajo no excede las 24 horas
		}

		// Validar si el tiempo trabajado excede las horas de trabajo permitidas
		if (tiempo_trabajado > work_hours_minutes) {
			console.log('¡Alerta! El tiempo trabajado excede las horas permitidas.');
			return false; // La validación falla si se exceden las horas permitidas
		} else {
			console.log('Tiempo trabajado dentro del límite permitido.');
			return true; // La validación pasa si no se exceden las horas permitidas
		}
	}, "Time worked cannot exceed the hours allowed.");

	$( "#formWorker" ).validate( {
		rules: {
			jobName:	 			{ required: true },
			start_hour:	 			{ required: true, validacion: true },
			start_min:	 			{ required: true, validacion: true },
			jobNameFinish:	 		{ required: true },
			finish_hour:	 		{ required: true, validacion: true },
			finish_min:			    { required: true, validacion: true},
			finish_hour:	 		{ required: true, validacion: true },
		},
		errorElement: "em",
		errorPlacement: function ( error, element ) {
			// Add the `help-block` class to the error element
			error.addClass( "help-block" );
			error.insertAfter( element );

		},
		highlight: function ( element, errorClass, validClass ) {
			$( element ).parents( ".col-sm-6" ).addClass( "has-error" ).removeClass( "has-success" );
		},
		unhighlight: function (element, errorClass, validClass) {
			$( element ).parents( ".col-sm-6" ).addClass( "has-success" ).removeClass( "has-error" );
		},
		submitHandler: function (form) {
			return true;
		}
	});

	$("#btnSubmit").click(function () {
		if ($("#formWorker").valid() == true){

			//Activa icono guardando
			$('#btnSubmitWorker').attr('disabled','-1');
			$("#div_error").css("display", "none");
			$("#div_load").css("display", "inline");

			$.ajax({
				type: "POST",
				url: base_url + "payroll/updateTaskWithWO",
				data: $("#formWorker").serialize(),
				dataType: "json",
				contentType: "application/x-www-form-urlencoded;charset=UTF-8",
				cache: false,

				success: function (data) {
					if( data.result == "error" )
					{
						$("#div_load").css("display", "none");
						$('#btnSubmitWorker').removeAttr('disabled');
						return false;
					}

					if( data.result )//true
					{
						$("#div_load").css("display", "none");
						$('#btnSubmitWorker').removeAttr('disabled');

						window.location.reload();
					}
					else
					{
						alert('Error. Reload the web page.');
						$("#div_load").css("display", "none");
						$("#div_error").css("display", "inline");
						$('#btnSubmitWorker').removeAttr('disabled');
					}
				},
				error: function(result) {
					alert('Error. Reload the web page.');
					$("#div_load").css("display", "none");
					$("#div_error").css("display", "inline");
					$('#btnSubmitWorker').removeAttr('disabled');
				}
			});
		}
	});
});