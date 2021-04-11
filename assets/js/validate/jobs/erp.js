$( document ).ready( function () {
	
jQuery.validator.addMethod("fieldSpecify", function(value, element, param) {
	var condiciones = $(param).is(":checked");
	if(condiciones && value == ""){
		return false;
	}else{
		return true;
	}
}, "This field is required.");
			
	$( "#form" ).validate( {
		rules: {
			address:				{ required: true, minlength: 3, maxlength:100 },
			responsible:			{ required: true},
			coordinator:			{ required: true},
			fire_department:		{ required: true, minlength: 3, maxlength:30 },
			paramedics:				{ required: true, minlength: 3, maxlength:30 },
			ambulance:				{ required: true, minlength: 3, maxlength:30 },
			police:					{ required: true, minlength: 3, maxlength:30 },
			federal_protective:		{ required: true, minlength: 3, maxlength:30 },
			electric:				{ required: true, minlength: 3, maxlength:30 },
			water:					{ required: true, minlength: 3, maxlength:30 },
			gas:					{ minlength: 3, maxlength:30 },
			contact1:				{ required: true},
			contact2:				{ required: true},
			hddField:				{ required: true },
			specify:				{ maxlength: 100, fieldSpecify: "#other" },
			location:				{ required: true, minlength: 3, maxlength:100 },
			location2:				{ minlength: 3, maxlength:100 },
			location3:				{ minlength: 3, maxlength:100 }
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
				$("#div_guardado").css("display", "none");
				$("#div_error").css("display", "none");
				$("#div_msj").css("display", "none");
				$("#div_cargando").css("display", "inline");

			
				$.ajax({
					type: "POST",	
					url: base_url + "jobs/save_erp",	
					data: $("#form").serialize(),
					dataType: "json",
					contentType: "application/x-www-form-urlencoded;charset=UTF-8",
					cache: false,
					
					success: function(data){
                                            
						if( data.result == "error" )
						{
							//alert(data.mensaje);
							$("#div_cargando").css("display", "none");
							$('#btnSubmit').removeAttr('disabled');							
							
							$("#span_msj").html(data.mensaje);
							$("#div_msj").css("display", "inline");
							return false;
						
						} 

						
										
						if( data.result )//true
						{	                                                        
							$("#div_cargando").css("display", "none");
							$("#div_guardado").css("display", "inline");
							$('#btnSubmit').removeAttr('disabled');

							var url = base_url + "jobs/erp/" + data.idRecord;
							$(location).attr("href", url);
						}
						else
						{
							alert('Error. Reload the web page.');
							$("#div_cargando").css("display", "none");
							$("#div_error").css("display", "inline");
							$('#btnSubmit').removeAttr('disabled');
						}	
					},
					error: function(result) {
						alert('Error. Reload the web page.');
						$("#div_cargando").css("display", "none");
						$("#div_error").css("display", "inline");
						$('#btnSubmit').removeAttr('disabled');
					}
					
		
				});	
		
		}else{
			alert("There are missing fields.");
		}		
	});

});