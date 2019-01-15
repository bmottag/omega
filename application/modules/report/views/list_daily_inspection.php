
        <div id="page-wrapper">

			<br>
			<div class="row">
				<div class="col-md-12">
					<div class="panel panel-primary">
						<div class="panel-heading">
							<h4 class="list-group-item-heading">
								<i class="fa fa-bar-chart-o fa-fw"></i> REPORT CENTER
							</h4>
						</div>
					</div>
				</div>
				<!-- /.col-lg-12 -->				
			</div>

            <!-- /.row -->
            <div class="row">
                <div class="col-lg-12">
                    <div class="panel panel-default">
                        <div class="panel-heading">
							<a class="btn btn-success" href=" <?php echo base_url().'report/searchByDateRange/dailyInspection'; ?> "><span class="glyphicon glyphicon glyphicon-chevron-left" aria-hidden="true"></span> Go back </a> 
                            <i class="fa fa-search fa-fw"></i> PICKUPS & TRUCKS INSPECTION REPORT
                        </div>
                        <!-- /.panel-heading -->
                        <div class="panel-body">
						<div class="alert alert-info">
							<strong>From Date: </strong><?php echo $from; ?> 
							<strong>To Date: </strong><?php echo $to; ?> 
<?php if($info){ ?>
							<br><strong>Dowloand to: </strong>
							
<a href='<?php echo base_url('report/generaInsectionDailyPDF/' . $employee . '/' . $vehicleId . '/' . $trailerId . '/' . $from . '/' . $to ); ?>' target="_blank">PDF <img src='<?php echo base_url_images('pdf.png'); ?>' ></a>	
				 
<?php } ?>
						</div>
						<?php
							if(!$info){
						?>
                            <div class="alert alert-danger">
                                No data was found matching your criteria. 
                            </div>
						<?php
							}else{
						?>
                            <table width="100%" class="table table-striped table-bordered table-hover" id="dataTables">
                                <thead>
                                    <tr>
                                        <th>Date of Issue</th>
										<th>Driver Name</th>
										<th>Type</th>
										<th>Make</th>
										<th>Model</th>
										<th>Unit Number</th>
										<th>Description</th>
										
										<th>Comments</th>
										
										<th>Belts/Hoses</th>
										<th>Power Steering Fluid</th>
										<th>Oil Level</th>
										<th>Coolant Level</th>
										<th>Coolant/Oil Leaks</th>
										
										
										<th>Head Lamps</th>
										<th>Hazard Lights</th>
										<th>Tail Lights</th>
										<th>Work Lights</th>
										<th>Turn Signals</th>
										<th>Beacon Light</th>
										<th>Clearance Lights</th>
										
										
										<th>Brake Pedal</th>
										<th>Emergency Brake</th>
										<th>Gauges: Volt/Fuel/Temp/Oil</th>
										<th>Electrical & Air Horn</th>
										<th>Seatbelts</th>
										<th>Driver & Passenger seat </th>
										<th>Insurance Information</th>
										<th>Registration</th>
										<th>Clean Interior</th>
										

										<th>Tires/Lug Nuts/Pressure</th>
										<th>Glass (All) & Mirror</th>
										<th>Clean Exterior</th>
										<th>Wipers/Washers</th>
										<th>Backup Beeper</th>
										<th>Driver and Passenger door </th>
										<th>Decals</th>


										<th>Fire Extinguisher</th>
										<th>First Aid</th>
										<th>Emergency kit</th>
										<th>Spill Kit</th>
										
										
										<th>Steering Axle</th>
										<th>Drives Axles</th>
										<th>Front drive shaft</th>
										<th>Back drive shaft</th>
										<th>Grease 5th Wheel</th>
										<th>Box hoist & hinge</th>
										
                                    </tr>
                                </thead>
                                <tbody>							
								<?php
									$total = 0;
									foreach ($info as $lista):
													
											switch ($lista['type_level_1']) {
												case 1:
													$type1 = 'Fleet';
													break;
												case 2:
													$type1 = 'Rental';
													break;
												case 99:
													$type1 = 'Other';
													break;
											}
											
											echo "<tr>";
											echo "<td class='text-center'>" . $lista['date_issue'] . "</td>";
											echo "<td >" . $lista['name'] . "</td>";
											
											echo "<td class='text-center'>" . $type1 . ' - ' . $lista['type_2'] . "</td>";
											echo "<td class='text-center'>" . $lista['make'] . "</td>";
											echo "<td class='text-center'>" . $lista['model'] . "</td>";
											echo "<td class='text-center'>" . $lista['unit_number'] . "</td>";
											echo "<td class='text-center'>" . $lista['description'] . "</td>";
											
											echo "<td>" . $lista['comments'] . "</td>";
											
											echo "<td class='text-center'>"; 
											switch ($lista['belt']) {
												case 0:
													echo "Fail";
													break;
												case 1:
													echo "Pass";
													break;
												case 99:
													echo "N/A";
													break;
											}
											echo "</td>";
											echo "<td >";
											switch ($lista['power_steering']) {
												case 0:
													echo "Fail";
													break;
												case 1:
													echo "Pass";
													break;
												case 99:
													echo "N/A";
													break;
											}
											echo "</td>";
											
											echo "<td class='text-center'>";
											switch ($lista['oil_level']) {
												case 0:
													echo "Fail";
													break;
												case 1:
													echo "Pass";
													break;
												case 99:
													echo "N/A";
													break;
											}
											echo "</td>";
											echo "<td class='text-center'>";
											switch ($lista['coolant_level']) {
												case 0:
													echo "Fail";
													break;
												case 1:
													echo "Pass";
													break;
												case 99:
													echo "N/A";
													break;
											}
											echo "</td>";
											echo "<td class='text-center'>";
											switch ($lista['water_leaks']) {
												case 0:
													echo "Fail";
													break;
												case 1:
													echo "Pass";
													break;
												case 99:
													echo "N/A";
													break;
											}
											echo "</td>";
											echo "<td class='text-center'>";
											switch ($lista['head_lamps']) {
												case 0:
													echo "Fail";
													break;
												case 1:
													echo "Pass";
													break;
												case 99:
													echo "N/A";
													break;
											}
											echo "</td>";
											
											echo "<td class='text-center'>"; 
											switch ($lista['hazard_lights']) {
												case 0:
													echo "Fail";
													break;
												case 1:
													echo "Pass";
													break;
												case 99:
													echo "N/A";
													break;
											}
											echo "</td>";
											echo "<td class='text-center'>";
											switch ($lista['bake_lights']) {
												case 0:
													echo "Fail";
													break;
												case 1:
													echo "Pass";
													break;
												case 99:
													echo "N/A";
													break;
											}
											echo "</td>";
											echo "<td class='text-center'>";
											switch ($lista['work_lights']) {
												case 0:
													echo "Fail";
													break;
												case 1:
													echo "Pass";
													break;
												case 99:
													echo "N/A";
													break;
											}
											echo "</td>";
											echo "<td class='text-center'>"; 
											switch ($lista['turn_signals']) {
												case 0:
													echo "Fail";
													break;
												case 1:
													echo "Pass";
													break;
												case 99:
													echo "N/A";
													break;
											}
											echo "</td>";
											echo "<td class='text-center'>"; 
											switch ($lista['beacon_light']) {
												case 0:
													echo "Fail";
													break;
												case 1:
													echo "Pass";
													break;
												case 99:
													echo "N/A";
													break;
											}
											echo "</td>";
											echo "<td class='text-center'>";
											switch ($lista['clearance_lights']) {
												case 0:
													echo "Fail";
													break;
												case 1:
													echo "Pass";
													break;
												case 99:
													echo "N/A";
													break;
											}
											echo "</td>";
											echo "<td class='text-center'>";
											switch ($lista['brake_pedal']) {
												case 0:
													echo "Fail";
													break;
												case 1:
													echo "Pass";
													break;
												case 99:
													echo "N/A";
													break;
											}
											echo "</td>";											
											echo "<td class='text-center'>";
											switch ($lista['emergency_brake']) {
												case 0:
													echo "Fail";
													break;
												case 1:
													echo "Pass";
													break;
												case 99:
													echo "N/A";
													break;
											}
											echo "</td>";											
											echo "<td class='text-center'>";
											switch ($lista['gauges']) {
												case 0:
													echo "Fail";
													break;
												case 1:
													echo "Pass";
													break;
												case 99:
													echo "N/A";
													break;
											}
											echo "</td>";											
											echo "<td class='text-center'>";
											switch ($lista['horn']) {
												case 0:
													echo "Fail";
													break;
												case 1:
													echo "Pass";
													break;
												case 99:
													echo "N/A";
													break;
											}
											echo "</td>";
											echo "<td class='text-center'>";
											switch ($lista['seatbelts']) {
												case 0:
													echo "Fail";
													break;
												case 1:
													echo "Pass";
													break;
												case 99:
													echo "N/A";
													break;
											}
											echo "</td>";
											echo "<td class='text-center'>";
											switch ($lista['driver_seat']) {
												case 0:
													echo "Fail";
													break;
												case 1:
													echo "Pass";
													break;
												case 99:
													echo "N/A";
													break;
											}
											echo "</td>";

											echo "<td class='text-center'>";
											switch ($lista['insurance']) {
												case 0:
													echo "Fail";
													break;
												case 1:
													echo "Pass";
													break;
												case 99:
													echo "N/A";
													break;
											}
											echo "</td>";

											echo "<td class='text-center'>";
											switch ($lista['registration']) {
												case 0:
													echo "Fail";
													break;
												case 1:
													echo "Pass";
													break;
												case 99:
													echo "N/A";
													break;
											}
											echo "</td>";
											echo "<td class='text-center'>";
											switch ($lista['clean_interior']) {
												case 0:
													echo "Fail";
													break;
												case 1:
													echo "Pass";
													break;
												case 99:
													echo "N/A";
													break;
											}
											echo "</td>";
											
											echo "<td class='text-center'>";
											switch ($lista['nuts']) {
												case 0:
													echo "Fail";
													break;
												case 1:
													echo "Pass";
													break;
												case 99:
													echo "N/A";
													break;
											}
											echo "</td>";
											
											echo "<td class='text-center'>";
											switch ($lista['glass']) {
												case 0:
													echo "Fail";
													break;
												case 1:
													echo "Pass";
													break;
												case 99:
													echo "N/A";
													break;
											}
											echo "</td>";											
											echo "<td class='text-center'>";
											switch ($lista['clean_exterior']) {
												case 0:
													echo "Fail";
													break;
												case 1:
													echo "Pass";
													break;
												case 99:
													echo "N/A";
													break;
											}
											echo "</td>";	

											echo "<td class='text-center'>";
											switch ($lista['wipers']) {
												case 0:
													echo "Fail";
													break;
												case 1:
													echo "Pass";
													break;
												case 99:
													echo "N/A";
													break;
											}
											echo "</td>";											
											echo "<td class='text-center'>";
											switch ($lista['backup_beeper']) {
												case 0:
													echo "Fail";
													break;
												case 1:
													echo "Pass";
													break;
												case 99:
													echo "N/A";
													break;
											}
											echo "</td>";	
											echo "<td class='text-center'>";
											switch ($lista['passenger_door']) {
												case 0:
													echo "Fail";
													break;
												case 1:
													echo "Pass";
													break;
												case 99:
													echo "N/A";
													break;
											}
											echo "</td>";
											echo "<td class='text-center'>";
											switch ($lista['proper_decals']) {
												case 0:
													echo "Fail";
													break;
												case 1:
													echo "Pass";
													break;
												case 99:
													echo "N/A";
													break;
											}
											echo "</td>";
											
											echo "<td class='text-center'>"; 
											switch ($lista['fire_extinguisher']) {
												case 0:
													echo "Fail";
													break;
												case 1:
													echo "Pass";
													break;
												case 99:
													echo "N/A";
													break;
											}
											echo "</td>";
											echo "<td class='text-center'>";
											switch ($lista['first_aid']) {
												case 0:
													echo "Fail";
													break;
												case 1:
													echo "Pass";
													break;
												case 99:
													echo "N/A";
													break;
											}
											echo "</td>";											
											echo "<td class='text-center'>";
											switch ($lista['emergency_reflectors']) {
												case 0:
													echo "Fail";
													break;
												case 1:
													echo "Pass";
													break;
												case 99:
													echo "N/A";
													break;
											}
											echo "</td>";
											echo "<td class='text-center'>";
											switch ($lista['spill_kit']) {
												case 0:
													echo "Fail";
													break;
												case 1:
													echo "Pass";
													break;
												case 99:
													echo "N/A";
													break;
											}
											echo "</td>";
											
											echo "<td class='text-center'>";
											switch ($lista['steering_axle']) {
												case 0:
													echo "Fail";
													break;
												case 1:
													echo "Pass";
													break;
												case 99:
													echo "N/A";
													break;
											}
											echo "</td>";											
											echo "<td class='text-center'>";
											switch ($lista['drives_axle']) {
												case 0:
													echo "Fail";
													break;
												case 1:
													echo "Pass";
													break;
												case 99:
													echo "N/A";
													break;
											}
											echo "</td>";											
											echo "<td class='text-center'>"; 
											switch ($lista['grease_front']) {
												case 0:
													echo "Fail";
													break;
												case 1:
													echo "Pass";
													break;
												case 99:
													echo "N/A";
													break;
											}
											echo "</td>";											
											echo "<td class='text-center'>";
											switch ($lista['grease_end']) {
												case 0:
													echo "Fail";
													break;
												case 1:
													echo "Pass";
													break;
												case 99:
													echo "N/A";
													break;
											}
											echo "</td>";											
											echo "<td class='text-center'>";
											switch ($lista['grease']) {
												case 0:
													echo "Fail";
													break;
												case 1:
													echo "Pass";
													break;
												case 99:
													echo "N/A";
													break;
											}
											echo "</td>";											
											echo "<td class='text-center'>";
											switch ($lista['hoist']) {
												case 0:
													echo "Fail";
													break;
												case 1:
													echo "Pass";
													break;
												case 99:
													echo "N/A";
													break;
											}
											echo "</td>";
											
											echo "</tr>";
									endforeach;
								?>
                                </tbody>
                            </table>
						<?php }	?>
                        </div>
                        <!-- /.panel-body -->
                    </div>
                    <!-- /.panel -->
                </div>
                <!-- /.col-lg-12 -->
            </div>
			

        </div>
        <!-- /#page-wrapper -->

    <!-- Tables -->
    <script>
    $(document).ready(function() {
        $('#dataTables').DataTable({
            responsive: true
        });
    });
    </script>