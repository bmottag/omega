<div id="page-wrapper">
	<br>
	
	<!-- /.row -->
	<div class="row">
		<div class="col-lg-8">
			<div class="panel panel-primary">
				<div class="panel-heading">
					<a class="btn btn-info btn-xs" href="<?php echo base_url().'admin/vehicle/'.$vehicleInfo[0]["type_level_1"] . '/' . $vehicleInfo[0]['inspection_type']; ?> "><span class="glyphicon glyphicon glyphicon-chevron-left" aria-hidden="true"></span> Go back </a> 
					<i class="fa fa-wrench"></i> <strong>VEHICLE INSPECTIONS</strong>
				</div>
				<div class="panel-body">

				<?php
					$tipo = $vehicleInfo[0]['type_level_2'];
					if($info){
				?>				
					<table width="100%" class="table table-striped table-bordered table-hover" id="dataTables">
						<thead>
							<tr>
								<th class="text-center">Date of Issue</th>
								<th class="text-center">Employee</th>
								<th class="text-center">Hours/Kilometers</th>
								<th class="text-center">State</th>
							</tr>
						</thead>
						<tbody>							
						<?php
							foreach ($info as $lista):
									echo "<tr>";
									echo "<td class='text-center'>" . $lista['date_issue'] . "</td>";
									echo "<td class='text-center'>" . $lista['name'] . "</td>";
									
									echo "<td class='text-right'>";

									//si es sweeper
									if($tipo == 15){
										echo "Truck engine current hours: " . number_format($lista["current_hours"]);
										echo "<br>Sweeper engine current hours: " . number_format($lista["current_hours_2"]);
									//si es hydrovac
									}elseif($tipo == 16){
										echo "Engine current hours: " . number_format($lista["current_hours"]);
										echo "<br>Hydraulic pump current hours: " . number_format($lista["current_hours_2"]);
										echo "<br>Blower current hours: " . number_format($lista["current_hours_3"]);
									}else{
										echo number_format($lista["current_hours"]);
									}
									
									echo "</td>";
														
									echo "<td class='text-center'>";
									switch ($lista['state']) {
										case 0:
											echo "First Record";
											break;
										case 1:
											echo "Inspection";
											break;
										case 2:
											echo "Oil Change";
											break;
									}
									
									echo "</td>";
									
									
									echo "</tr>";
							endforeach;
						?>
						</tbody>
					</table>
				<?php } ?>
				
				</div>
			</div>
		</div>
	
		<div class="col-lg-4">
			<div class="panel panel-info">
				<div class="panel-heading">
					<i class="fa fa-automobile"></i> <strong>VEHICLE INFORMATION</strong>
				</div>
				<div class="panel-body">
				
					<?php if($vehicleInfo[0]["photo"]){ ?>
						<div class="form-group">
							<div class="row" align="center">
								<img src="<?php echo base_url($vehicleInfo[0]["photo"]); ?>" class="img-rounded" alt="Vehicle Photo" />
							</div>
						</div>
					<?php } ?>
				
					<strong>Make: </strong><?php echo $vehicleInfo[0]['make']; ?><br>
					<strong>Model: </strong><?php echo $vehicleInfo[0]['model']; ?><br>
					<strong>Description: </strong><?php echo $vehicleInfo[0]['description']; ?><br>
					<strong>Unit Number: </strong><?php echo $vehicleInfo[0]['unit_number']; ?><br>
					<strong>Type: </strong><br>
					<?php
						switch ($vehicleInfo[0]['type_level_1']) {
							case 1:
								$type = 'Fleet';
								break;
							case 2:
								$type = 'Rental';
								break;
							case 99:
								$type = 'Other';
								break;
						}
						echo $type . " - " . $vehicleInfo[0]['type_2'];
					?><br>
					
					<?php
					$tipo = $vehicleInfo[0]['type_level_2'];
					//si es sweeper
					if($tipo == 15){
						echo "<strong>Truck engine current hours:</strong><br>" . number_format($vehicleInfo[0]["hours"]);
						echo "<br><strong>Sweeper engine current hours:</strong><br>" . number_format($vehicleInfo[0]["hours_2"]);
					//si es hydrovac
					}elseif($tipo == 16){
						echo "<strong>Engine current hours:</strong><br>" . number_format($vehicleInfo[0]["hours"]);
						echo "<br><strong>Hydraulic pump current hours:</strong><br>" . number_format($vehicleInfo[0]["hours_2"]);
						echo "<br><strong>Blower current hours:</strong><br>" . number_format($vehicleInfo[0]["hours_3"]);
					}else{
						echo "<strong>Current Hours/Kilometers: </strong><br>" . number_format($vehicleInfo[0]["hours"]);
					}
					?>
					
					
				</div>
			</div>
		</div>
					
	</div>
	
</div>
<!-- /#page-wrapper -->