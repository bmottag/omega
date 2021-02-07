$( document ).ready( function () {
	
	jQuery.validator.addMethod("unCampo", function(value, element, param) {
		var id_job = $('#id_job').val();
		var state = $('#state').val();
		var id_Claim = $('#id_Claim').val();
		if ( id_job == "" && state == "" && id_Claim == "" ) {
			return false;
		}else{
			return true;
		}
	}, "Debe indicar al menos un campo.");

	$( "#formSearch" ).validate( {
		rules: {
			id_job:	{ unCampo: true },
			state:	{ unCampo: true },
			id_Claim:	{ unCampo: true, maxlength: 20 }
		},
		errorElement: "em",
		errorPlacement: function ( error, element ) {
			// Add the `help-block` class to the error element
			error.addClass( "help-block" );
			error.insertAfter( element );

		},
		highlight: function ( element, errorClass, validClass ) {
			$( element ).parents( ".col-sm-12" ).addClass( "has-error" ).removeClass( "has-success" );
		},
		unhighlight: function (element, errorClass, validClass) {
			$( element ).parents( ".col-sm-12" ).addClass( "has-success" ).removeClass( "has-error" );
		},
		submitHandler: function (form) {
			return true;
		}
	});
	
	$("#btnSearch").click(function(){		
		if ($("#formSearch").valid() == true){
			var form = document.getElementById('form');
			form.submit();	
		}else
		{
			//alert('Error.');
		}
	});

});