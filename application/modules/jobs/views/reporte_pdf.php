<?php
	// create some HTML content
	$html = '<br><h2 align="center" style="color:#337ab7;">TOOL BOX MEETING<br><br></h2>
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
					<th bgcolor="#337ab7" style="color:white;"><strong>Job Code/Name: </strong></th>
					<th colspan="3">' . strtoupper($info[0]['job_description']). '</th>
				</tr>
			
				<tr>
					<th bgcolor="#337ab7" style="color:white;"><strong>Done by: </strong></th>
					<th>' . $info[0]['name']. '</th>
					<th bgcolor="#337ab7" style="color:white;"><strong>Date & Time: </strong></th>
					<th>' . $info[0]['date_tool_box']. '</th>
				</tr>
			
				<tr>
					<th bgcolor="#337ab7" style="color:white;"><strong>Review Incidents, Accidents or any new safety matter: </strong></th>
					<th colspan="3">' . $info[0]['new_safety']. '</th>
				</tr>
				<tr>
					<th bgcolor="#337ab7" style="color:white;"><strong>Activities of the Day/Week: </strong></th>
					<th colspan="3">' . $info[0]['activities']. '</th>
				</tr>
				<tr>
					<th bgcolor="#337ab7" style="color:white;"><strong>Corrective Actions: </strong></th>
					<th colspan="3">' . $info[0]['corrective_actions']. '</th>
				</tr>
				<tr>
					<th bgcolor="#337ab7" style="color:white;"><strong>Employee Suggestions: </strong></th>
					<th colspan="3">' . $info[0]['suggestions']. '</th>
				</tr>


			</table>';

$html.= '<br><br>';
			
				if(!$toolBoxWorkers){			
						$html.= 'No data was found for workers';
				}else{				
				
						$html.= '<table border="1" cellspacing="0" cellpadding="5">';
								
						//pintar las firmas de a 4 por fila
						$total = count($toolBoxWorkers);//contar numero de trabajadores
						$totalFilas  = 1;
						if($total>=4)
						{//si es mayor 4 entonces calcular cuantas filas deben ser
							$div = $total / 4;
							$totalFilas = ceil($div); //redondeo hace arriba
						}

						$n = 1;
						for($i=0;$i<$totalFilas;$i++){
							$html.= '<tr>
										<th align="center" width="20%"><strong><p>Initials</p></strong></th>';	
							
									$finish = $n * 4;
									$star = $finish - 4;
									if($finish > $total){
										$finish = $total;
									}
									$n++;			
																							
									for ($j = $star; $j < $finish; $j++) {
				
										$html.= '<th align="center" width="20%">';
										
										if($toolBoxWorkers[$j]['signature']){
											$html.= '<img src="'.$toolBoxWorkers[$j]['signature'].'" border="0" width="70" height="70" />';
										}
										$html.= '</th>';
									}

							$html.= '</tr>';
							
							$html.= '<tr bgcolor="#337ab7" style="color:white;">
										<th align="center"><strong>Company</strong></th>';
										for ($j = $star; $j < $finish; $j++) {	
											$html.= '<th align="center"><strong>VCI</strong></th>';
										}
							$html.= '</tr>';
							
							$html.= '<tr bgcolor="#337ab7" style="color:white;">
										<th align="center"><strong>Worker Name</strong></th>';		
										for ($j = $star; $j < $finish; $j++) {	
											$html.= '<th align="center"><strong>' . $toolBoxWorkers[$j]['name'] . '</strong></th>';
										}
							$html.= '</tr>';
						}
						
						$html.= '</table>';
				}
				
				$html.= '<br><br>';
				
				if($subcontractors){			
		
						$html.= '<table border="1" cellspacing="0" cellpadding="5">';
								
						//pintar las firmas de a 4 por fila
						$total = count($subcontractors);//contar numero de trabajadores
						$totalFilas  = 1;
						if($total>=4)
						{//si es mayor 4 entonces calcular cuantas filas deben ser
							$div = $total / 4;
							$totalFilas = ceil($div); //redondeo hace arriba
						}

						$n = 1;
						for($i=0;$i<$totalFilas;$i++){
							$html.= '<tr>
										<th align="center" width="20%"><strong><p>Initials</p></strong></th>';	
							
									$finish = $n * 4;
									$star = $finish - 4;
									if($finish > $total){
										$finish = $total;
									}
									$n++;			
																							
									for ($j = $star; $j < $finish; $j++) {
				
										$html.= '<th align="center" width="20%">';
										
										if($subcontractors[$j]['signature']){
											//$url = base_url($subcontractors[$j]['signature']);
											$html.= '<img src="'.$subcontractors[$j]['signature'].'" border="0" width="70" height="70" />';
										}
										$html.= '</th>';
									}

							$html.= '</tr>';
							
							$html.= '<tr bgcolor="#337ab7" style="color:white;">
										<th align="center"><strong>Company</strong></th>';
										for ($j = $star; $j < $finish; $j++) {	
											$html.= '<th align="center"><strong>' . $subcontractors[$j]['company_name'] . '</strong></th>';
										}
							$html.= '</tr>';
							
							$html.= '<tr bgcolor="#337ab7" style="color:white;">
										<th align="center"><strong>Worker Name</strong></th>';		
										for ($j = $star; $j < $finish; $j++) {	
											$html.= '<th align="center"><strong>' . $subcontractors[$j]['worker_name'] . '</strong></th>';
										}
							$html.= '</tr>';
						}
						
						$html.= '</table>';
				}

				$html.= '<br><br>';
			

echo $html;
						
?>