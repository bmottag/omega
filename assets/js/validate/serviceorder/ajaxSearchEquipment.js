/**
 * Vehicle information by vin number
 * @author bmottag
 * @since  14/4/2020
 */

$(document).ready(function () {
	   
    $('#btnVINNumber').click(function () {
		var vinNumber = $('#vinNumber').val();
		$("#div_info_list").css("display", "inline");
		if (vinNumber.length > 4) {
			$.ajax ({
				type: 'POST',
				url: base_url + 'serviceorder/equipmentList',
				data: {'vinNumber': vinNumber, 'inspectionType': false, 'headerInspectionType': 'Search by VIN Number'},
				cache: false,
				success: function (data)
				{
					$('#div_info_list').html(data);
				}
			});
		} else {				
			var data = "<p class='text-danger'>Enter at least 5 consecutive characters of the<strong> VIN NUMBER</strong></p>";
			$('#div_info_list').html(data);
		}
    });    
});

/*
* Function to load Equipment List
*/
function loadEquipmentList(inspectionType, headerInspectionType) {
	$("#div_info_list").css("display", "block");
	$.ajax ({
		type: 'POST',
		url: base_url + 'serviceorder/equipmentList',
		data: {'vinNumber': false, 'inspectionType': inspectionType, 'headerInspectionType': headerInspectionType},
		cache: false,
		success: function (data)
		{
			$('#div_info_list').html(data);
		}
	});
}

/*
* Function to load Equipment Detail
*/
function loadEquipmentDetail(equipmentId, tabview, serviceOrderId=false) {
	$("#div_detail").css("display", "block");
	$("#div_info_list").css("display", "none");
    $("#loader").addClass("loader");
	$.ajax ({
		type: 'POST',
		url: base_url + 'serviceorder/equipmentDetail',
		data: {equipmentId, tabview, serviceOrderId},
		cache: false,
		success: function (data)
		{
			$("#loader").removeClass("loader");
			$('#div_detail').html(data);
		}
	});
}