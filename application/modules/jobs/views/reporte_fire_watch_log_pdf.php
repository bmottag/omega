<?php
	// create some HTML content
	$html = '<h3 align="right" style="color:#337ab7;">Project code: ' . $info[0]['job_description'] . '</h3><br>';
	
	$html .= '<br><h2 align="center" style="color:#337ab7;">Fire Watch Log Sheet<br><br></h2>
				<style>
				table {
					font-family: arial, sans-serif;
					border-collapse: collapse;
					width: 100%;
				}

				td, th {
					border: 1px solid #dddddd;
					text-align: left;
					padding: 8px;
				}
				</style>
			<table border="0" cellspacing="0" cellpadding="5">
				<tr>
					<th bgcolor="#337ab7" style="color:white;"><strong>Facility/Building Address: </strong></th>
					<th colspan="3">' . strtoupper($info[0]['building_address']) . '</th>
				</tr>

				<tr>
					<th bgcolor="#337ab7" style="color:white;"><strong>Fire Watch Conducted by: </strong></th>
					<th colspan="3">' . $info[0]['conductedby']. '</th>
				</tr>
			</table>';

	$CompleteDateOut = $info[0]['date_commenced'];
	$date = substr($CompleteDateOut, 0, 10); 
	$time = substr($CompleteDateOut, 11, 2) . ':00';

	$html .= '<table border="0" cellspacing="0" cellpadding="5">
				<tbody>
					<tr>
						<th bgcolor="#337ab7" style="color:white;"><strong>Fire Watch Commenced: </strong></th>
						<th><strong>Date: </strong>' . $date   . '</th>
						<th><strong>Time: </strong>' . $time . '</th>
					</tr>
				</tbody>
			</table>';

	$html.= '<br><br>';

	$html .= '<table cellspacing="0" cellpadding="5">
				<tr>
					<th bgcolor="#337ab7" style="color:white;"><strong>Name </strong></th>
					<th bgcolor="#337ab7" style="color:white;"><strong>Start Time </strong></th>
					<th bgcolor="#337ab7" style="color:white;"><strong>End Time </strong></th>
					<th bgcolor="#337ab7" style="color:white;"><strong>Notes/Observations</strong></th>
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