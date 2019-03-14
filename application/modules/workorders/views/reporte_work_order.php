<?php
	// create some HTML content	
	
//datos generales
			$html = '<table border="0" cellspacing="0" cellpadding="5">';
			$html.= '<tr>
					<th width="60%">
					<b>P.O. Box </b> 67037 Northland Village NW <br>
					Calgary - Alberta - T2L2L2 <br>
					<b>Phone:</b> 587-892-9616 / <b>Fax:</b> 403-910-0752<br>
					<a href="http://www.v-contracting.ca/" dir="ltr">www.v-contracting.ca/</a>
					</th>';
					
			$html.= '<th width="40%">
					<b>Project name: </b>' . $info[0]['company_name'] . '<br>
					<b>VCI project number: </b>' . $info[0]['job_description'] . '
					</th></tr>';
					
			$html.= '</table>';

			$html.= '<br><br>
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
				</style>';
				
			

			
			$html.= '<table border="0" cellspacing="0" cellpadding="4">';

			$html.= '<tr>
						<th width="50%" bgcolor="#337ab7" style="color:white;"><strong>TASK DESCRIPTION </strong></th>
						<th width="50%" bgcolor="#337ab7" style="color:white;" colspan="2"><strong>CLIENT INFORMATION </strong></th>
					</tr>';
			
			$html.= '<tr>
						<th>' . $info[0]['observation'] . '</th>
						<th><strong>Company name: </strong>' . $info[0]['company_name'] . '<br>
						<strong>Representative: </strong>' . $info[0]['foreman_name_wo'] . '<br>
						<strong>Phone number: </strong>' . $info[0]['movil_number'] . '<br>
						<strong>E-Mail: </strong>' . $info[0]['foreman_email_wo'] . '</th>';
						
			$html.= '<th align="center">';
			if($info[0]['signature_wo']){
			$html.= '<img src="http://v-contracting.ca/app/images/signature/workorder/workorder_' . $info[0]['id_workorder'] . '.png" width="70" height="70" border="0" />';
			}
			$html.= '</th>';
						
			$html.= '</tr>';
									
			$html.= '</table><br><br>';
			
//datos especificos
			
			$html.= '<table border="0" cellspacing="0" cellpadding="4">';

			$html.= '<tr>
						<th align="center" width="5%" bgcolor="#337ab7" style="color:white;"><strong>ITEM </strong></th>
						<th align="center" width="60%" bgcolor="#337ab7" style="color:white;"><strong>DESCRIPTION </strong></th>
						<th align="center" width="9%" bgcolor="#337ab7" style="color:white;"><strong>UNIT </strong></th>
						<th align="center" width="5%" bgcolor="#337ab7" style="color:white;"><strong>QTY </strong></th>
						<th align="center" width="10%" bgcolor="#337ab7" style="color:white;"><strong>UNIT PRICE </strong></th>
						<th align="center" width="11%" bgcolor="#337ab7" style="color:white;"><strong>LINE TOTAL </strong></th>
					</tr>';
			
			$items = 0;
			$total = 0;
		
// INICIO PERSONAL
			if($workorderPersonal)
			{ 
				foreach ($workorderPersonal as $data):
						$items++;
						$total = $data['value'] + $total;
						
						$html.=		'<tr>
									<th align="center">' . $items . '</th>
									<th>' . $data['employee_type'] . ' - ' . $data['description'] . '</th>
									<th align="center">Hours</th>
									<th align="center">' . $data['hours'] . '</th>
									<th align="right">$ ' . $data['rate'] . '</th>
									<th align="right">$ ' . $data['value'] . '</th>';
						$html.= '</tr>';
				endforeach;
			}
			
// INICIO MATERIAL
			if($workorderMaterials)
			{ 
				foreach ($workorderMaterials as $data):
						$items++;
						$total = $data['value'] + $total;

						$html.=		'<tr>
									<th align="center">' . $items . '</th>
									<th>' . $data['description'] . ' - ' . $data['material'] . '</th>
									<th align="center">' . $data['unit'] . '</th>
									<th align="center">' . $data['quantity'] . '</th>
									<th align="right">$ ' . $data['rate'] . '</th>
									<th align="right">$ ' . $data['value'] . '</th>';
						$html.= '</tr>';
				endforeach;
			}
			
// INICIO EQUIPMENT
			if($workorderEquipment)
			{ 
				foreach ($workorderEquipment as $data):
						$items++;
						$total = $data['value'] + $total;

						$html.=		'<tr>
									<th align="center">' . $items . '</th>
									<th>';
									
						//si es tipo miscellaneous -> 8, entonces la description es diferente
						if($data['fk_id_type_2'] == 8){
							$equipment = $data['miscellaneous'] . " - " . $data['other'];
						}else{
							$equipment = $data['unit_number'] . " - " . $data['v_description'];
						}
						
						$html.= $equipment . ' - ' . $data['description'];
						
						$html.=		'</th>
									
									<th align="center">Hours</th>
									<th align="center">' . $data['hours'] . '</th>
									<th align="right">$ ' . $data['rate'] . '</th>
									<th align="right">$ ' . $data['value'] . '</th>';
						$html.= '</tr>';
				endforeach;
			}
			
// INICIO SUBCONTRATISTAS OCASIONALES
			if($workorderOcasional)
			{ 
				foreach ($workorderOcasional as $data):
						$items++;
						$total = $data['value'] + $total;

						$html.=		'<tr>
									<th align="center">' . $items . '</th>
									<th>' . $data['description'] . '</th>
									<th align="center">' . $data['unit'] . '</th>
									<th align="center">' . $data['hours'] . '</th>
									<th align="right">$ ' . $data['rate'] . '</th>
									<th align="right">$ ' . $data['value'] . '</th>';
						$html.= '</tr>';
				endforeach;
			}
			
// INICIO HOLD BACK
			if($workorderHoldBack)
			{ 
				foreach ($workorderHoldBack as $data):
						$items++;
						$total = $data['value'] + $total;

						$html.=		'<tr>
									<th align="center">' . $items . '</th>
									<th>' . $data['description'] . '</th>
									<th align="center">-</th>
									<th align="center">-</th>
									<th align="right">-</th>
									<th align="right">$ ' . $data['value'] . '</th>';
						$html.= '</tr>';
				endforeach;
			}
//TOTAL

						$html.=		'<tr>
									<th colspan="5" align="right" bgcolor="#337ab7" style="color:white;"><b>Subtotal :</b></th>
									<th align="right">$ ' . $total . '</th>';
						$html.= '</tr>';						


						
			$html.= '</table><br><br>';	
			
//tabla inferior			
			$html.= '<table border="0" cellpadding="2" cellspacing="2">
					<thead>
						<tr style="background-color:#BCB5B5">
							<td width="520"><b>Other comments or special instructions</b></td>
						</tr>
					</thead>
					<tr>
						<td width="520">
							1. All Work Orders will be attached to an Invoice otherwise can be deemed as an Invoice<br>
							2. Please refer to the W.O. # in all your correspondence<br>
							3. Please send correspondence regarding this work order to:<br>
							<b>Hugo Villamil</b><br>
							<a href="mailto:hugo@v-contracting.com">hugo@v-contracting.com</a><br>
							<b>Ph:</b>(587)-892-9616<br>
							<b>Signature VCI Rep:</b> <br>
							<img src="http://v-contracting.ca/app/images/employee/signature/hugo_boss.png" width="150" height="150" border="0" />
						</td>
					</tr>
			</table>';

				
echo $html;
						
?>