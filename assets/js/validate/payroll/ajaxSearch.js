/**
 * Employee list by contract type
 * @author bmottag
 * @since  11/9/2022
 */

$(document).ready(function () {
	
    $('#contractType').change(function () {
        $('#contractType option:selected').each(function () {
            var contractType = $('#contractType').val();
            if (contractType > 0 || contractType != '') {
                $.ajax ({
                    type: 'POST',
                    url: base_url + 'payroll/employeeList',
                    data: {'identificador': contractType},
                    cache: false,
                    success: function (data)
                    {
                        $("#div_employee").css("display", "inline");
                        $('#employee').html(data);
                    }
                });
            } else {
                var data = '';
                $('#employee').html(data);
                $("#div_employee").css("display", "none");
            }
        });
    });
    
});