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
					
					echo "<p class='text-danger'>";
					//si es sweeper
					if($tipo == 15){
						echo "<strong>Truck engine current hours:</strong><br>";
						echo "Current: " . number_format($vehicleInfo[0]["hours"]);
						echo "<br>Next oil change: " . number_format($vehicleInfo[0]["oil_change"]);
						
						echo "<br><strong>Sweeper engine current hours:</strong><br>";
						echo "Current: " . number_format($vehicleInfo[0]["hours_2"]);
						echo "<br>Next oil change: " . number_format($vehicleInfo[0]["oil_change_2"]);
					//si es hydrovac
					}elseif($tipo == 16){
						echo "<strong>Engine hours:</strong><br>";
						echo "Current: " . number_format($vehicleInfo[0]["hours"]);
						echo "<br>Next oil change: " . number_format($vehicleInfo[0]["oil_change"]);

						echo "<br><strong>Hydraulic pump hours:</strong><br>";
						echo "Current: " . number_format($vehicleInfo[0]["hours_2"]);
						echo "<br>Next oil change: " . number_format($vehicleInfo[0]["oil_change_2"]);
						
						echo "<br><strong>Blower hours:</strong><br>";
						echo "Current: " . number_format($vehicleInfo[0]["hours_3"]);
						echo "<br>Next oil change: " . number_format($vehicleInfo[0]["oil_change_3"]);
					}else{
						echo "<strong>Current Hours/Kilometers: </strong><br>";
						echo "Current: " . number_format($vehicleInfo[0]["hours"]);
						echo "<br>Next oil change: " . number_format($vehicleInfo[0]["oil_change"]);
					}
					echo "</p>";
					
					?>

					
					
				</div>
			</div>
		</div>


<?php 

$heater_check = $vehicleInfo[0]['heater_check'];
$brakes_check = $vehicleInfo[0]['brakes_check'];
$lights_check = $vehicleInfo[0]['lights_check'];
$steering_wheel_check = $vehicleInfo[0]['steering_wheel_check'];
$suspension_system_check = $vehicleInfo[0]['suspension_system_check'];
$tires_check = $vehicleInfo[0]['tires_check'];
$wipers_check = $vehicleInfo[0]['wipers_check'];
$air_brake_check = $vehicleInfo[0]['air_brake_check'];
$driver_seat_check = $vehicleInfo[0]['driver_seat_check'];
$fuel_system_check = $vehicleInfo[0]['fuel_system_check'];

//preguntar especiales para HYDROVAC para que muestre mensaje si es inseguro sacar el camion
if ($heater_check == 0 || $brakes_check == 0 || $lights_check == 0 || $steering_wheel_check == 0 || $suspension_system_check == 0 || $tires_check == 0 || $wipers_check == 0 || $air_brake_check == 0 || $driver_seat_check == 0 || $fuel_system_check == 0) {

?>
					
		<div class="col-lg-4">
			<div class="panel panel-danger">
				<div class="panel-heading">
					<i class="fa fa-times"></i> <strong>LAST INSPECTIONS FAILS</strong>
				</div>
				<div class="panel-body">
					<?php 
						if ($heater_check == 0) {
							echo "<br><strong>Heater:</strong> Fail"; 
						}
						if ($brakes_check == 0) {
							echo "<br><strong>Brake pedal:</strong> Fail"; 
						}
						if ($lights_check == 0) {
							echo "<br><strong>Lamps and reflectors:</strong> Fail"; 
						}
						if ($steering_wheel_check == 0) {
							echo "<br><strong>Steering wheel:</strong> Fail"; 
						}
						if ($suspension_system_check == 0) {
							echo "<br><strong>Suspension system:</strong> Fail"; 
						}
						if ($tires_check == 0) {
							echo "<br><strong>Tires/Lug Nuts/Pressure:</strong> Fail"; 
						}
						if ($wipers_check == 0) {
							echo "<br><strong>Wipers/Washers:</strong> Fail"; 
						}
						if ($air_brake_check == 0) {
							echo "<br><strong>Air brake system:</strong> Fail"; 
						}
						if ($driver_seat_check == 0) {
							echo "<br><strong>Driver and Passenger door:</strong> Fail"; 
						}
						if ($fuel_system_check == 0) {
							echo "<br><strong>Fuel system:</strong> Fail"; 
						}
					?>
					
				</div>
			</div>
		</div>
<?php } ?>
		
					
	</div>
	
</div>
<!-- /#page-wrapper -->