<?php
	// create some HTML content
	$html = '<h3 align="right" style="color:#337ab7;">Project code: ' . $info[0]['job_description'] . '</h3><br>';
	
	$html .= '<br><h2 align="center" style="color:#337ab7;">Fire Watch Log Sheet</h2><br>';

	$html .= '<table style="border-collapse: collapse; width: 100%; height: 45px;" border="0" cellspacing="0" cellpadding="5">
				<tbody>
					<tr>
						<td style="width: 35%;">&nbsp;<strong>Facility/Building Address:</strong></td>
						<td style="width: 65%;">&nbsp;' . $info[0]['building_address']  . '</td>
					</tr>
				</tbody>
			</table>';

	$html .= '<table style="border-collapse: collapse; width: 100%; height: 45px;" border="0" cellspacing="0" cellpadding="5">
				<tbody>
					<tr>
						<td style="width: 35%;">&nbsp;<strong>Fire Watch Conducted by:</strong></td>
						<td style="width: 65%;">&nbsp;' . $info[0]['conductedby']  . '</td>
					</tr>
				</tbody>
			</table>';

	$CompleteDateOut = $info[0]['date_commenced'];
	$date = substr($CompleteDateOut, 0, 10); 
	$time = substr($CompleteDateOut, 11, 2) . ':00';

	$html .= '<table style="border-collapse: collapse; width: 100%; height: 45px;" border="0" cellspacing="0" cellpadding="5">
				<tbody>
					<tr>
						<td colspan="2">&nbsp;<strong>Fire Watch Commenced:</strong></td>
					</tr>
					<tr>
						<td style="width: 35%;">&nbsp;<strong>Date: </strong>' . $date   . '</td>
						<td style="width: 35%;">&nbsp;<strong>Time: </strong>' . $time . '</td>
					</tr>
				</tbody>
			</table>';

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
					<th><strong>Start Time </strong></th>
					<th><strong>End Time </strong></th>
					<th><strong>Notes/Observations</strong></th>
				</tr>';

	if($checkinList){
		foreach ($checkinList as $lista):
			$checkOut = $lista['checkout_time']=="0000-00-00 00:00:00"?"":$lista['checkout_time'];
			$html .=  "<tr>";
			$html .=  "<td>" . $lista['first_name'] . " " . $lista['last_name'] . "</td>";
			$html .=  "<td class='text-center'>" . $lista['checkin_time'] . "</td>";
			$html .=  "<td class='text-center'>" . $checkOut . "</td>";
			$html .=  "<td >" . $lista['notes'] . "</td>";
			$html .=  "</tr>";
		endforeach;
	}
	$html.='</table>';


echo $html;
						
?>