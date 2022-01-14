/**
 * Trucks´list by company
 * @author bmottag
 * @since  12/12/2016
 */

$(document).ready(function () {
	
    $('#CompanyType').change(function () {
        $('#CompanyType option:selected').each(function () {
            var CompanyType = $('#CompanyType').val();
            if ((CompanyType > 0 || CompanyType != '') ) {
				
				$("#div_plate").css("display", "none");
				$("#div_truck").css("display", "inline");
				if(CompanyType==2){
					$("#div_plate").css("display", "inline");
					$("#div_truck").css("display", "none");
				}
				
                $.ajax ({
                    type: 'POST',
                    url: base_url + 'hauling/companyList',
                    data: {'CompanyType': CompanyType},
                    cache: false,
                    success: function (data)
                    {
                        $('#company').html(data);
                    }
                });
            } else {
                var data = '';
                $('#company').html(data);
            }
        });
    });
    
    $('#company').change(function () {
        $('#company option:selected').each(function () {
            var company = $('#company').val();
            if (company > 0 || company != '-') {
                $.ajax ({
                    type: 'POST',
                    url: base_url + 'hauling/truckList',
                    data: {'identificador': company},
                    cache: false,
                    success: function (data)
                    {
                        $('#truck').html(data);
                    }
                });
            } else {
                var data = '';
                $('#truck').html(data);
            }
        });
    });
    
});