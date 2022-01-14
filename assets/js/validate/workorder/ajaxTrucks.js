/**
 * Trucks´list by company
 * @author bmottag
 * @since  25/1/2017
 */

$(document).ready(function () {
	
	
    $('#type').change(function () {
        $('#type option:selected').each(function () {

			var type = $('#type').val();

			if (type > 0 || type != '') {
				
				if (type != 8) {
					$.ajax ({
						type: 'POST',
						url: base_url + 'workorders/truckList',
						data: {'type': type},
						cache: false,
						success: function (data)
						{
							$('#truck').html(data);
						}
					});
					$("#div_other").css("display", "none");
					$("#div_truck").css("display", "inline");
					$('#otherEquipment').val("");
					$('#truck').val("");
				}else{
					$("#div_other").css("display", "inline");
					$("#div_truck").css("display", "none");
					$('#otherEquipment').val("");
					$('#truck').val(5);
				}
				
			} else {
				var data = '';
				$('#truck').html(data);
			}

        });
    });
    
});