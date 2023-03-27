<?php
	// create some HTML content
	$html = '<h3 align="right" style="color:#337ab7;">Project code: ' . $info[0]['job_description'] . '</h3><br>';
	
	$html .= '<br><h2 align="center" style="color:#337ab7;">Fire Watch Record</h2><br>';

	$html .= '<table border="0" cellspacing="0" cellpadding="5">
				<tbody>
					<tr>
						<td style="width: 35%;">&nbsp;<strong>Facility/Building Address:</strong></td>
						<td style="width: 65%;">&nbsp;' . $info[0]['building_address']  . '</td>
					</tr>
				</tbody>
			</table>';

	$html.= '<p"><em><strong>Systems Shutdown</strong></em></p>';
	$html .= '<table border="0" cellspacing="0" cellpadding="5">';
	$html.='<tr>
			<th>';
			if($info[0]['fire_alarm'] == 1){
				$html .= '<img src="http://v-contracting.ca/app/images/check_mark.png" height="12" width="12"/>';
			}else{
				$html .= '<img src="http://v-contracting.ca/app/images/check_mark_whyte.png" height="12" width="12"/>';
			}
	$html.= ' Fire Alarm System';
	$html .= '</th>';
	
	$html.='<th>';
		if($info[0]['fire_sprinkler'] == 1){
			$html .= '<img src="http://v-contracting.ca/app/images/check_mark.png" height="12" width="12"/>';
		}else{
			$html .= '<img src="http://v-contracting.ca/app/images/check_mark_whyte.png" height="12" width="12"/>';
		}
	$html.= ' Fire Sprinkler System';
	$html .= '</th>';

	$html.='<th>';
		if($info[0]['standpipe'] == 1){
			$html .= '<img src="http://v-contracting.ca/app/images/check_mark.png" height="12" width="12"/>';
		}else{
			$html .= '<img src="http://v-contracting.ca/app/images/check_mark_whyte.png" height="12" width="12"/>';
		}
	$html.= ' Standpipe System';
	$html .= '</th>';

	$html.= '</tr>';

	$html.='<tr>
			<th>';
			if($info[0]['fire_pump'] == 1){
				$html .= '<img src="http://v-contracting.ca/app/images/check_mark.png" height="12" width="12"/>';
			}else{
				$html .= '<img src="http://v-contracting.ca/app/images/check_mark_whyte.png" height="12" width="12"/>';
			}
	$html.= ' Fire Pump System';
	$html .= '</th>';
	
	$html.='<th>';
			if($info[0]['fire_sprinkler'] == 1){
				$html .= '<img src="http://v-contracting.ca/app/images/check_mark.png" height="12" width="12"/>';
			}else{
				$html .= '<img src="http://v-contracting.ca/app/images/check_mark_whyte.png" height="12" width="12"/>';
			}
	$html.= ' Fire Sprinkler System';
	$html .= '</th>';

	$html.='<th></th>';

	$html.= '</tr>';

	$html.='<tr>
			<th>';
	$html.= ' Other: ' . $info[0]['other'];
	$html .= '</th>';
	
	$html.='<th></th>';
	$html.='<th></th>';

	$html.= '</tr>';

	$html.= '<tr><th colspan="3">Areas/Zones Requiring Fire Watch Patrols</th></tr>';
	$html.= '<tr><th colspan="3">';
	$html.= $info[0]['areas'];
	$html.= '</th></tr>';
	$html.='</table><br>';

	$CompleteDateOut = $info[0]['date_out'];
	$date = substr($CompleteDateOut, 0, 10); 
	$time = substr($CompleteDateOut, 11, 2) . ':00';

	$date2 = "";
	$time2 = "";
	if($info[0]['date_restored'] != "0000-00-00 00:00:00") { 
		$CompleteDateRestored = $info[0]['date_restored'];
		$date2 = substr($CompleteDateRestored, 0, 10); 
		$time2 = substr($CompleteDateRestored, 11, 2). ':00';
	}

	$html .= '<table border="0" cellspacing="0" cellpadding="5">
				<tbody>
					<tr>
						<td colspan="2">&nbsp;<strong>System(s) Out of Service</strong></td>
					</tr>
					<tr>
						<td style="width: 35%;">&nbsp;<strong>Date: </strong>' . $date   . '</td>
						<td style="width: 35%;">&nbsp;<strong>Time: </strong>' . $time . '</td>
					</tr>

					<tr>
						<td colspan="2">&nbsp;<strong>Systems(s) Restored Online</strong></td>
					</tr>
					<tr>
						<td style="width: 35%;">&nbsp;<strong>Date: </strong>' . $date2   . '</td>
						<td style="width: 35%;">&nbsp;<strong>Time: </strong>' . $time2 . '</td>
					</tr>
				</tbody>
			</table>';


	$html.= '<p"><em><strong>Persons Conducting Fire Watch Service</strong></em></p>';
	$html .= '<style>
				#persons {
					font-family: Arial, Helvetica, sans-serif;
					border-collapse: collapse;
					width: 100%;
				}
				
				#persons td, #persons th {
					border: 1px solid #ddd;
					text-align: left;
					padding: 8px;
				}
				</style>
				<table id="persons" cellspacing="0" cellpadding="5">
				<tr>
					<th><strong>Name </strong></th>
					<th><strong>Company </strong></th>
					<th><strong>Contact Number </strong></th>
				</tr>';

	if($checkinList){
		foreach ($checkinList as $lista):
			$html .=  "<tr>";
			$html .=  "<td>" . $lista['first_name'] . " " . $lista['last_name'] . "</td>";
			$html .=  "<td class='text-center'>VCI</td>";
			$html .=  "<td class='text-center'>" . $lista['movil'] . "</td>";
			$html .=  "</tr>";
		endforeach;
	}


	$html.='</table><br>';

	$mobile = $info[0]["super_number"];
	// Separa en grupos de tres 
	$count = strlen($mobile); 
		
	$num_tlf1 = substr($mobile, 0, 3); 
	$num_tlf2 = substr($mobile, 3, 3); 
	$num_tlf3 = substr($mobile, 6, 2); 
	$num_tlf4 = substr($mobile, -2); 
	
	if($count == 10){
		$resultado = "$num_tlf1 $num_tlf2 $num_tlf3 $num_tlf4";  
	}else{
		
		$resultado = chunk_split($mobile,3," "); 
	}

	$html.= '<p"><em><strong>Supervisor’s Name:</strong></em> '. $info[0]["supervisor"] .'</p>';
	$html.= '<p"><em><strong>Supervisor’s Company:</strong></em> VCI</p>';
	$html.= '<p"><em><strong>Supervisor’s Contact Number:</strong></em> '. $resultado .'</p>';

echo $html;
						
?>