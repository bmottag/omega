/**
 * Vehicle information by vin number
 * @author bmottag
 * @since  14/4/2020
 */

$(document).ready(function () {
	   
    $('#vinNumber').blur(function () {
		var vinNumber = $('#vinNumber').val();
		if (vinNumber > 0 || vinNumber != '') {
			$("#div_vehicle").css("display", "inline");
			
			$.ajax ({
				type: 'POST',
				url: base_url + 'inspection/vehicleInfo',
				data: {'vinNumber': vinNumber},
				cache: false,
				success: function (data)
				{
					$('#div_vehicle').html(data);
				}
			});
		} else {				
			var data = '';
			$("#div_vehicle").css("display", "none");
			$('#div_vehicle').html(data);
		}
    });    
});

/*
* Function to check mendatory questions in patient encounter exam.
*/
function loadEquipmentList(inspection_type) {
	$("#div_equiment_list").css("display", "inline");
	$.ajax ({
		type: 'POST',
		url: base_url + 'serviceorder/equipmentList',
		data: {'inspection_type': inspection_type},
		cache: false,
		success: function (data)
		{
			$('#div_equiment_list').html(data);
		}
	});
}