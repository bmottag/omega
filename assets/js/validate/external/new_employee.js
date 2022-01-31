$( document ).ready( function () {

	$("#firstName").bloquearNumeros().maxlength(25);
	$("#lastName").bloquearNumeros().maxlength(25);		
	$("#insuranceNumber").bloquearTexto().maxlength(10);
	$("#healthNumber").bloquearTexto().maxlength(10);
	$("#movilNumber").bloquearTexto().maxlength(10);

	$( "#form" ).validate( {
		rules: {
			inputPassword: 		{ required: true, minlength: 6, maxlength:15 },
			inputConfirm: 		{ required: true, minlength: 6, maxlength:15, equalTo: "#inputPassword" },
			firstName: 			{ required: true, minlength: 3, maxlength:25 },
			lastName: 			{ required: true, minlength: 3, maxlength:25 },
			user: 				{ required: true, minlength: 4, maxlength:12 },
			email: 				{ required: true, email: true, maxlength:60 },
			confirmEmail: 		{ required: true, email: true, equalTo: "#email" },
			birth: 				{ required: true, date: true },
			insuranceNumber:	{ required: true, number: true, minlength: 6, maxlength: 10 },
			movilNumber: 		{ required: true },
			address: 			{ minlength: 4, maxlength:200}
		},
		messages: {
			inputPassword: {
				required: "Please provide a password",
			},
			inputConfirm: {
				required: "Please provide a password",
				equalTo: "Please enter the same password as above"
			}
		},
		errorElement: "em",
		errorPlacement: function ( error, element ) {
			// Add the `help-block` class to the error element
			error.addClass( "help-block" );
			error.insertAfter( element );

		},
		highlight: function ( element, errorClass, validClass ) {
			$( element ).parents( ".col-sm-2" ).addClass( "has-error" ).removeClass( "has-success" );
		},
		unhighlight: function (element, errorClass, validClass) {
			$( element ).parents( ".col-sm-2" ).addClass( "has-success" ).removeClass( "has-error" );
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
					url: base_url + "external/save_employee",	
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

							var url = base_url + "external/newEmployee/uiAqv828TZr";
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
		
		}//if			
	});

});