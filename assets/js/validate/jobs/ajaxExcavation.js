/**
 * Excavations filds
 * @author bmottag
 * @since  8/8/2021
 */

$(document).ready(function () {
	
    $('#tested_daily').change(function () {
        $('#tested_daily option:selected').each(function () {
            var tested_daily = $('#tested_daily').val();

            if ((tested_daily > 0 || tested_daily != '') ) {
				$("#div_tested_daily_explanation").css("display", "none");
                $('#tested_daily_explanation').val("");
				if(tested_daily==1){
					$("#div_tested_daily_explanation").css("display", "inline");
				}
            }
        });
    });

    $('#ventilation').change(function () {
        $('#ventilation option:selected').each(function () {
            var ventilation = $('#ventilation').val();

            if ((ventilation > 0 || ventilation != '') ) {
                $("#div_ventilation_explanation").css("display", "none");
                $('#ventilation_explanation').val("");
                if(ventilation==1){
                    $("#div_ventilation_explanation").css("display", "inline");
                }
            }
        });
    });
    

    
});