$( document ).ready( function () {

	$( "#formReceipt" ).validate( {
		rules: {
			place: 				{ required: true, minlength:4, maxlength:100 },
			price:	 			{ number: true, minlength:2, maxlength:5 },
			description: 		{ required: true }
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
	
	$("#btnSubmitReceipt").click(function(){		
	
		if ($("#formReceipt").valid() == true){
		
				//Activa icono guardando
				$('#btnSubmitReceipt').attr('disabled','-1');
				$("#div_error").css("display", "none");
				$("#div_load").css("display", "inline");
			
				$.ajax({
					type: "POST",	
					url: base_url + "workorders/save/saveReceipt",	
					data: $("#formReceipt").serialize(),
					dataType: "json",
					contentType: "application/x-www-form-urlencoded;charset=UTF-8",
					cache: false,
					
					success: function(data){
                                            
						if( data.result == "error" )
						{
							$("#div_load").css("display", "none");
							$('#btnSubmitReceipt').removeAttr('disabled');							
							return false;
						} 

						if( data.result )//true
						{	                                                        
							$("#div_load").css("display", "none");
							$('#btnSubmitReceipt').removeAttr('disabled');

							var url = base_url + "workorders/" + data.controlador + "/" + data.idRecord;
							$(location).attr("href", url);
						}
						else
						{
							alert('Error. Reload the web page.');
							$("#div_load").css("display", "none");
							$("#div_error").css("display", "inline");
							$('#btnSubmitReceipt').removeAttr('disabled');
						}	
					},
					error: function(result) {
						alert('Error. Reload the web page.');
						$("#div_load").css("display", "none");
						$("#div_error").css("display", "inline");
						$('#btnSubmitReceipt').removeAttr('disabled');
					}
					
		
				});	
		
		}//if			
	});
});