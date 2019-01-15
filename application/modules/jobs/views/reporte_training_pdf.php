<?php
	// create some HTML content
	$html = '<p><h1 align="center" style="color:#337ab7;">TRAINING</h1></p>
	<p></p>';

	// create some HTML content
	$html .= '
		The following personnel have been trained to ensure a safe and orderly
emergency evacuation of other employees:<p></p>

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
					<th bgcolor="#337ab7" style="color:white;" width="35%"><strong>Name </strong></th>
					<th bgcolor="#337ab7" style="color:white;" width="25%"><strong>Title </strong></th>
					<th bgcolor="#337ab7" style="color:white;" width="25%"><strong>Responsability </strong></th>
					<th bgcolor="#337ab7" style="color:white;" width="15%"><strong>Date </strong></th>
				</tr>';
				
			if($trainingWorkers){
				foreach ($trainingWorkers as $data):
					$html .= "<tr>";					
					$html .= "<th >" . $data['name'] . "</th>";
					$html .= "<th >" . $data['movil'] . "</th>";
					$html .= "</tr>";
				endforeach;
			}

	$html .= '</table>';	

echo $html;

?>