<a name="anclaUp"></a>

        <div id="page-wrapper">
            <div class="row"><br>
				<div class="col-md-12">
					<div class="panel panel-primary">
						<div class="panel-heading">
							<h4 class="list-group-item-heading">
								DASHBOARD
							</h4>
						</div>
					</div>
				</div>
				<!-- /.col-lg-12 -->
            </div>
						
<?php
	if($infoMaintenance){ 
?>	
            <!-- /.row -->
			<div class="row">
				<div class="col-lg-12">
						
					<a class="btn btn-block btn-social btn-pinterest" href="<?php echo base_url('dashboard/maintenance'); ?>">
						<i class="fa fa-wrench"></i> You have some preventive maintenance
					</a>
					<br>
				</div>	
			</div>
<?php
	}
?>	
		
            <div class="row">
				<!-- INICIO MENSAJE DEL SISTEMA si aprobaron un dayoff en los ultimos 7 dias -->
				<?php if($dayoff){ ?>
                <div class="col-lg-12">
					<?php 	
						switch ($dayoff['state']) {
							case 2:
								$noteDayoff = ' is <strong>Approved.</strong>';
								$classDayoff = "alert-success";
								break;
							case 3:
								$noteDayoff = ' is <strong>Denied.</strong>';
								$classDayoff = "alert-danger";
								break;
						}
					?>				
					<div class="alert <?php  echo $classDayoff; ?> alert-dismissable">
						<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
						<strong>DAY OFF: </strong>
						<?php 
							echo "The day off that you request for the ";
							echo "<strong>" . $dayoff['date_dayoff'] . "</strong>";
							echo $noteDayoff;
							echo "You can check your request in the Day Off link."
						?>
					</div>
                </div>
				<?php } ?>
				<!-- FIN MENSAJE DEL SISTEMA-->
			</div>
				
<?php
$retornoExito = $this->session->flashdata('retornoExito');
if ($retornoExito) {
    ?>
	<div class="row">
		<div class="col-lg-12">	
			<div class="alert alert-success ">
				<span class="glyphicon glyphicon-ok" aria-hidden="true"></span>
				<strong><?php echo $this->session->userdata("firstname"); ?></strong> <?php echo $retornoExito ?>		
			</div>
		</div>
	</div>
    <?php
}

$retornoError = $this->session->flashdata('retornoError');
if ($retornoError) {
    ?>
	<div class="row">
		<div class="col-lg-12">	
			<div class="alert alert-danger ">
				<span class="glyphicon glyphicon-exclamation-sign" aria-hidden="true"></span>
				<?php echo $retornoError ?>
			</div>
		</div>
	</div>
    <?php
}
?> 
			
			
            <!-- /.row -->
            <div class="row">
                <div class="col-lg-3 col-md-6">
                    <div class="panel panel-primary">
                        <div class="panel-heading">
                            <div class="row">
                                <div class="col-xs-3">
                                    <i class="fa fa-book fa-5x"></i>
                                </div>
                                <div class="col-xs-9 text-right">
                                    <div class="huge"><?php echo $noTareas; ?></div>
                                    <div>Time Stamp</div>
                                </div>
                            </div>
                        </div>
						
                        <a href="#anclaPayroll">
                            <div class="panel-footer">
                                <span class="pull-left">Last Payroll Records</span>
                                <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
                                <div class="clearfix"></div>
                            </div>
                        </a>
                    </div>
                </div>
				
<?php if($infoSafety){  ?>
                <div class="col-lg-3 col-md-6">
                    <div class="panel panel-amarello">
                        <div class="panel-heading">
                            <div class="row">
                                <div class="col-xs-3">
                                    <i class="fa fa-life-saver fa-5x"></i>
                                </div>
                                <div class="col-xs-9 text-right">
                                    <div class="huge"><?php echo $noSafety; ?></div>
                                    <div>FLHA</div>
                                </div>
                            </div>
                        </div>

                        <a href="#anclaSafety">
                            <div class="panel-footer">
                                <span class="pull-left"> Last FLHA Records </span>
                                <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
                                <div class="clearfix"></div>
                            </div>
                        </a>
                    </div>
                </div>
<?php } ?>

<?php if($noJobs){  ?>
                <div class="col-lg-3 col-md-6">
                    <div class="panel panel-amarello">
                        <div class="panel-heading">
                            <div class="row">
                                <div class="col-xs-3">
                                    <i class="fa fa-briefcase fa-5x"></i>
                                </div>
                                <div class="col-xs-9 text-right">
                                    <div class="huge"><?php echo $noJobs; ?></div>
                                    <div>JOBS</div>
                                </div>
                            </div>
                        </div>

                        <a href="<?php echo base_url('jobs'); ?>">
                            <div class="panel-footer">
                                <span class="pull-left"> Jobs Info </span>
                                <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
                                <div class="clearfix"></div>
                            </div>
                        </a>
                    </div>
                </div>
<?php } ?>

<?php if($noHauling){  ?>
                <div class="col-lg-3 col-md-6">
                    <div class="panel panel-yellow">
                        <div class="panel-heading">
                            <div class="row">
                                <div class="col-xs-3">
                                    <i class="fa fa-truck fa-5x"></i>
                                </div>
                                <div class="col-xs-9 text-right">
                                    <div class="huge"><?php echo $noHauling; ?></div>
                                    <div>.</div>
                                </div>
                            </div>
                        </div>

                        <a href="<?php echo base_url('dashboard/hauling'); ?>">
                            <div class="panel-footer">
                                <span class="pull-left">Last Hauling Records </span>
                                <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
                                <div class="clearfix"></div>
                            </div>
                        </a>
                    </div>
                </div>
<?php }  ?>

			</div>
			
			<div class="row">

<?php if($noDailyInspection){  ?>
                <div class="col-lg-3 col-md-6">
                    <div class="panel panel-green">
                        <div class="panel-heading">
                            <div class="row">
                                <div class="col-xs-3">
                                    <i class="fa fa-search fa-5x"></i>
                                </div>
                                <div class="col-xs-9 text-right">
                                    <div class="huge"><?php echo $noDailyInspection; ?></div>
                                    <div>Pickups & Trucks Inspections</div>
                                </div>
                            </div>
                        </div>
						<a href="<?php echo base_url('dashboard/pickups_inspection'); ?>">
                            <div class="panel-footer">
                                <span class="pull-left">Last Inspections</span>
                                <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
                                <div class="clearfix"></div>
                            </div>
                        </a>
                    </div>
                </div>
<?php } ?>

<?php if($noHeavyInspection){  ?>
                <div class="col-lg-3 col-md-6">
                    <div class="panel panel-red">
                        <div class="panel-heading">
                            <div class="row">
                                <div class="col-xs-3">
                                    <i class="fa fa-search fa-5x"></i>
                                </div>
                                <div class="col-xs-9 text-right">
                                    <div class="huge"><?php echo $noHeavyInspection; ?></div>
                                    <div>Construction Equipment Inspections</div>
                                </div>
                            </div>
                        </div>
                        <a href="<?php echo base_url('dashboard/construction_equipment_inspection'); ?>">
                            <div class="panel-footer">
                                <span class="pull-left"> Last Inspections </span>
                                <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
                                <div class="clearfix"></div>
                            </div>
                        </a>
                    </div>
                </div>
<?php } ?>

<?php	if($infoGenerator || $infoHydrovac || $infoSweeper){  ?>	
                <div class="col-lg-3 col-md-6">
                    <div class="panel panel-purpura">
                        <div class="panel-heading">
                            <div class="row">
                                <div class="col-xs-3">
                                    <i class="fa fa-search fa-5x"></i>
                                </div>
                                <div class="col-xs-9 text-right">
                                    <div class="huge"><?php echo $noSpecialInspection; ?></div>
                                    <div>Special Equipment Inspections</div>
                                </div>
                            </div>
                        </div>
                        <a href="#anclaWatertruck">
                            <div class="panel-footer">
                                <span class="pull-left"> Water Truck </span>
                                <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
                                <div class="clearfix"></div>
                            </div>
                        </a>
						
                        <a href="#anclaHydrovac">
                            <div class="panel-footer">
                                <span class="pull-left"> Hydro-Vac </span>
                                <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
                                <div class="clearfix"></div>
                            </div>
                        </a>
						
                        <a href="#anclaSweeper">
                            <div class="panel-footer">
                                <span class="pull-left"> Sweeper </span>
                                <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
                                <div class="clearfix"></div>
                            </div>
                        </a>
						
                        <a href="#anclaGenerator">
                            <div class="panel-footer">
                                <span class="pull-left"> Generators </span>
                                <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
                                <div class="clearfix"></div>
                            </div>
                        </a>
                    </div>
                </div>
<?php	}  ?>
				

            </div>
            <!-- /.row -->
            <div class="row">

<a name="anclaPayroll" ></a>			
				<div class="col-lg-12">
                    <div class="panel panel-primary">
                        <div class="panel-heading">
                            <i class="fa fa-book fa-fw"></i> Last Payroll Records
                        </div>
                        <!-- /.panel-heading -->
                        <div class="panel-body">


<a class="btn btn-default btn-circle" href="#anclaUp"><i class="fa fa-arrow-up"></i> </a>


<?php
	if(!$info){ 
		echo "<a href='#' class='btn btn-danger btn-block'>No data was found matching your criteria</a>";
	}else{
?>						
					
					<table width="100%" class="table table-striped table-bordered table-hover" id="dataTables">
						<thead>
							<tr>
								<th>Employee</th>
								<th>Start</th>
								<th>Finish</th>
								<th>Working Hours</th>
								<th>Job Start</th>
								<th>Address Start</th>
								<th>Job Finish</th>
								<th>Address Finish</th>
								<th>Task description</th>
								<th>Observation</th>
							</tr>
						</thead>
						<tbody>							
						<?php
							foreach ($info as $lista):
								echo "<tr>";
								echo "<td class='text-center'>" . $lista['first_name'] . " " . $lista['last_name'] . "</td>";
								echo "<td class='text-center'>" . $lista['start'] . "</td>";
								echo "<td class='text-center'>" . $lista['finish'] . "</td>";
								echo "<td class='text-right'>" . $lista['working_hours'] . "</td>";
								echo "<td class='text-center'>" . $lista['job_start'] . "</td>";
								echo "<td class='text-right'>" . $lista['address_start'] . "</td>";
								echo "<td class='text-center'>" . $lista['job_finish'] . "</td>";
								echo "<td class='text-right'>" . $lista['address_finish'] . "</td>";
								echo "<td class='text-right'>" . $lista['task_description'] . "</td>";
								echo "<td class='text-right'>" . $lista['observation'] . "</td>";
								echo "</tr>";
							endforeach;
						?>
						</tbody>
					</table>
					
					<!-- /.table-responsive -->
					<a href="<?php echo base_url("report/searchByDateRange/payroll"); ?>" class="btn btn-default btn-block">View more own records</a>
<?php	} ?>					
				</div>
				<!-- /.panel-body -->
			</div>

		</div>
	
</div>		






	<div class="row">
		<div class="col-lg-6">

<!-- INICIO TABLA DE SPECIAL INSPECTION --WATER TRUCK -->
<?php	if($infoWaterTruck){  ?>
<a name="anclaWatertruck"></a>
			<div class="panel panel-purpura">
				<div class="panel-heading">
					<i class="fa fa-search fa-fw"></i> Last Water Truck Inspection Records
				</div>
				<!-- /.panel-heading -->
				<div class="panel-body">	

<a class="btn btn-default btn-circle" href="#anclaUp"><i class="fa fa-arrow-up"></i> </a>
				
					<table width="100%" class="table table-striped table-bordered table-hover" id="dataWatertruck">
						<thead>
							<tr>
								<th>Date & Time</th>
								<th>Driver Name</th>
								<th>Vehicle Make</th>
								<th>Vehicle Model</th>
								<th>Unit Number</th>
								<th>Download</th>
								<th>Description</th>
								<th>Comments</th>
							</tr>
						</thead>
						<tbody>							
						<?php
						
						if($infoWaterTruck){
							foreach ($infoWaterTruck as $lista):
							
$class = "";

//si hay errores se coloca en amarillo
if(
 ['belt'] == 0
 || ['power_steering'] == 0
 || ['oil_level'] == 0
 || ['coolant_level'] == 0
 || ['coolant_leaks'] == 0
 || ['head_lamps'] == 0
 || ['hazard_lights'] == 0
 || ['clearance_lights'] == 0
 || ['tail_lights'] == 0
 || ['work_lights'] == 0
 || ['turn_signals'] == 0
 || ['beacon_lights'] == 0
 || ['tires'] == 0
 || ['mirrors'] == 0
 || ['clean_exterior'] == 0
 || ['wipers'] == 0
 || ['backup_beeper'] == 0
 || ['door'] == 0
 || ['decals'] == 0
 || ['sprinkelrs'] == 0
 || ['stering_axle'] == 0
 || ['drives_axles'] == 0
 || ['front_drive'] == 0
 || ['back_drive'] == 0
 || ['water_pump'] == 0
 || ['brake'] == 0
 || ['emergency_brake'] == 0
 || ['gauges'] == 0
 || ['horn'] == 0
 || ['seatbelt'] == 0
 || ['seat'] == 0
 || ['insurance'] == 0
 || ['registration'] == 0
 || ['clean_interior'] == 0
 || ['fire_extinguisher'] == 0
 || ['first_aid'] == 0
 || ['emergency_kit'] == 0
 || ['spill_kit'] == 0
 || ['heater'] == 0
 || ['steering_wheel'] == 0
 || ['suspension_system'] == 0
 || ['air_brake'] == 0
 || ['fuel_system'] == 0
){
	$class = "warning";
}

//si hay comentarios se coloca en rojo
if($lista['comments'] != ''){
	$class = "danger";
}
							
								echo "<tr class='" . $class . "'>";
								echo "<td class='text-center'><p class='text-" . $class . "'>" . $lista['date_issue'] . "</p></td>";
								echo "<td><p class='text-" . $class . "'>" . $lista['name'] . "</p></td>";
								echo "<td class='text-center'><p class='text-" . $class . "'>" . $lista['make'] . "</p></td>";
								echo "<td class='text-center'><p class='text-" . $class . "'>" . $lista['model'] . "</p></td>";
								echo "<td class='text-center'><p class='text-" . $class . "'>" . $lista['unit_number'] . "</p></td>";
								echo "<td class='text-center'>";
						?>
<a href='<?php echo base_url('report/generaInsectionSpecialPDF/x/x/x/x/watertruck/' . $lista['id_inspection_watertruck'] ); ?>' target="_blank"> <img src='<?php echo base_url_images('pdf.png'); ?>' ></a>
						<?php
								echo "</td>";
								echo "<td><p class='text-" . $class . "'>" . $lista['description'] . "</p></td>";
								echo "<td><p class='text-" . $class . "'>" . $lista['comments'] . "</p></td>";
								echo "</tr>";
							endforeach;
						}

						?>
						</tbody>
					</table>
				</div>
				<!-- /.panel-body -->
			</div>
<?php	} ?>
<!-- FIN TABLA DE SPECIAL INSPECTION -->

<!-- INICIO TABLA DE SPECIAL INSPECTION -- HYDRO-VAC -->
<?php	if($infoHydrovac ){  ?>
<a name="anclaHydrovac"></a>
			<div class="panel panel-purpura">
				<div class="panel-heading">
					<i class="fa fa-search fa-fw"></i> Last Hydro-Vac Inspection Records
				</div>
				<!-- /.panel-heading -->
				<div class="panel-body">	

<a class="btn btn-default btn-circle" href="#anclaUp"><i class="fa fa-arrow-up"></i> </a>
				
					<table width="100%" class="table table-striped table-bordered table-hover" id="dataHydrovac">
						<thead>
							<tr>
								<th>Date & Time</th>
								<th>Driver Name</th>
								<th>Vehicle Make</th>
								<th>Vehicle Model</th>
								<th>Unit Number</th>
								<th>Download</th>
								<th>Description</th>
								<th>Comments</th>
							</tr>
						</thead>
						<tbody>							
						<?php
						
						if($infoHydrovac){
							foreach ($infoHydrovac as $lista):
							
$class = "";

//si hay errores se coloca en amarillo
if(
 ['belt'] == 0
 || ['power_steering'] == 0
 || ['oil_level'] == 0
 || ['coolant_level'] == 0
 || ['coolant_leaks'] == 0
 || ['head_lamps'] == 0
 || ['hazard_lights'] == 0
 || ['clearance_lights'] == 0
 || ['tail_lights'] == 0
 || ['work_lights'] == 0
 || ['turn_signals'] == 0
 || ['beacon_lights'] == 0
 || ['tires'] == 0
 || ['windows'] == 0
 || ['clean_exterior'] == 0
 || ['wipers'] == 0
 || ['backup_beeper'] == 0
 || ['door'] == 0
 || ['decals'] == 0
 || ['stering_wheels'] == 0
 || ['drives'] == 0
 || ['front_drive'] == 0
 || ['middle_drive'] == 0
 || ['back_drive'] == 0
 || ['transfer'] == 0
 || ['tail_gate'] == 0
 || ['boom'] == 0
 || ['lock_bar'] == 0
 || ['brake'] == 0
 || ['emergency_brake'] == 0
 || ['gauges'] == 0
 || ['horn'] == 0
 || ['seatbelt'] == 0
 || ['seat'] == 0
 || ['insurance'] == 0
 || ['registration'] == 0
 || ['clean_interior'] == 0
 || ['fire_extinguisher'] == 0
 || ['first_aid'] == 0
 || ['emergency_kit'] == 0
 || ['spill_kit'] == 0
 || ['cartige'] == 0
 || ['pump'] == 0
 || ['wash_hose'] == 0
 || ['pressure_hose'] == 0
 || ['pump_oil'] == 0
 || ['hydraulic_oil'] == 0
 || ['gear_case'] == 0
 || ['hydraulic'] == 0
 || ['control'] == 0
 || ['panel'] == 0
 || ['foam'] == 0
 || ['heater'] == 0
 || ['steering_wheel'] == 0
 || ['suspension_system'] == 0
 || ['air_brake'] == 0
 || ['fuel_system'] == 0
){
	$class = "warning";
}

//si hay comentarios se coloca en rojo
if($lista['comments'] != ''){
	$class = "danger";
}
							
								echo "<tr class='" . $class . "'>";
								echo "<td class='text-center'><p class='text-" . $class . "'>" . $lista['date_issue'] . "</p></td>";
								echo "<td><p class='text-" . $class . "'>" . $lista['name'] . "</p></td>";
								echo "<td class='text-center'><p class='text-" . $class . "'>" . $lista['make'] . "</p></td>";
								echo "<td class='text-center'><p class='text-" . $class . "'>" . $lista['model'] . "</p></td>";
								echo "<td class='text-center'><p class='text-" . $class . "'>" . $lista['unit_number'] . "</p></td>";
								echo "<td class='text-center'>";
						?>
<a href='<?php echo base_url('report/generaInsectionSpecialPDF/x/x/x/x/hydrovac/' . $lista['id_inspection_hydrovac'] ); ?>' target="_blank"> <img src='<?php echo base_url_images('pdf.png'); ?>' ></a>
						<?php
								echo "</td>";
								echo "<td><p class='text-" . $class . "'>" . $lista['description'] . "</p></td>";
								echo "<td><p class='text-" . $class . "'>" . $lista['comments'] . "</p></td>";
								echo "</tr>";
							endforeach;
						}

						?>
						</tbody>
					</table>
				</div>
				<!-- /.panel-body -->
			</div>
<?php	} ?>
<!-- FIN TABLA DE SPECIAL INSPECTION -->
		</div>
		
		
		
		
		<div class="col-lg-6">
<!-- INICIO TABLA DE SPECIAL INSPECTION -- SWEEPER -->
<?php	if($infoSweeper){  ?>
<a name="anclaSweeper"></a>
			<div class="panel panel-purpura">
				<div class="panel-heading">
					<i class="fa fa-search fa-fw"></i> Last Sweeper Inspection Records
				</div>
				<!-- /.panel-heading -->
				<div class="panel-body">	

<a class="btn btn-default btn-circle" href="#anclaUp"><i class="fa fa-arrow-up"></i> </a>
				
					<table width="100%" class="table table-striped table-bordered table-hover" id="dataSweeper">
						<thead>
							<tr>
								<th>Date & Time</th>
								<th>Driver Name</th>
								<th>Vehicle Make</th>
								<th>Vehicle Model</th>
								<th>Unit Number</th>
								<th>Download</th>
								<th>Description</th>
								<th>Comments</th>
							</tr>
						</thead>
						<tbody>							
						<?php
						if($infoSweeper){
							foreach ($infoSweeper as $lista):
$class = "";

//si hay errores se coloca en amarillo
if(
['belt'] == 0
 || ['power_steering'] == 0
 || ['oil_level'] == 0
 || ['coolant_level'] == 0
 || ['coolant_leaks'] == 0
 || ['hydraulic'] == 0
 || ['belt_sweeper'] == 0
 || ['oil_level_sweeper'] == 0
 || ['coolant_level_sweeper'] == 0
 || ['coolant_leaks_sweeper'] == 0
 || ['head_lamps'] == 0
 || ['hazard_lights'] == 0
 || ['clearance_lights'] == 0
 || ['tail_lights'] == 0
 || ['work_lights'] == 0
 || ['turn_signals'] == 0
 || ['beacon_lights'] == 0
 || ['tires'] == 0
 || ['windows'] == 0
 || ['clean_exterior'] == 0
 || ['wipers'] == 0
 || ['backup_beeper'] == 0
 || ['door'] == 0
 || ['decals'] == 0
 || ['stering_wheels'] == 0
 || ['drives'] == 0
 || ['front_drive'] == 0
 || ['elevator'] == 0
 || ['rotor'] == 0
 || ['mixture_box'] == 0
 || ['lf_rotor'] == 0
 || ['elevator_sweeper'] == 0
 || ['mixture_container'] == 0
 || ['broom'] == 0
 || ['right_broom'] == 0
 || ['left_broom'] == 0
 || ['sprinkerls'] == 0
 || ['water_tank'] == 0
 || ['hose'] == 0
 || ['cam'] == 0
 || ['brake'] == 0
 || ['emergency_brake'] == 0
 || ['gauges'] == 0
 || ['horn'] == 0
 || ['seatbelt'] == 0
 || ['seat'] == 0
 || ['insurance'] == 0
 || ['registration'] == 0
 || ['clean_interior'] == 0
 || ['fire_extinguisher'] == 0
 || ['first_aid'] == 0
 || ['emergency_kit'] == 0
 || ['spill_kit'] == 0
){
	$class = "warning";
}

//si hay comentarios se coloca en rojo
if($lista['comments'] != ''){
	$class = "danger";
}
							
								echo "<tr class='" . $class . "'>";
								echo "<td class='text-center'><p class='text-" . $class . "'>" . $lista['date_issue'] . "</p></td>";
								echo "<td><p class='text-" . $class . "'>" . $lista['name'] . "</p></td>";
								echo "<td class='text-center'><p class='text-" . $class . "'>" . $lista['make'] . "</p></td>";
								echo "<td class='text-center'><p class='text-" . $class . "'>" . $lista['model'] . "</p></td>";
								echo "<td class='text-center'><p class='text-" . $class . "'>" . $lista['unit_number'] . "</p></td>";
								echo "<td class='text-center'>";
						?>
<a href='<?php echo base_url('report/generaInsectionSpecialPDF/x/x/x/x/sweeper/' . $lista['id_inspection_sweeper'] ); ?>' target="_blank"> <img src='<?php echo base_url_images('pdf.png'); ?>' ></a>
						<?php
								echo "</td>";
								echo "<td><p class='text-" . $class . "'>" . $lista['description'] . "</p></td>";
								echo "<td><p class='text-" . $class . "'>" . $lista['comments'] . "</p></td>";
								echo "</tr>";
							endforeach;
						}

						?>
						</tbody>
					</table>
				</div>
				<!-- /.panel-body -->
			</div>
<?php	} ?>
<!-- FIN TABLA DE SPECIAL INSPECTION -->

<!-- INICIO TABLA DE SPECIAL INSPECTION -- GENERATORS -->
<?php	if($infoGenerator){  ?>
<a name="anclaGenerator"></a>
			<div class="panel panel-purpura">
				<div class="panel-heading">
					<i class="fa fa-search fa-fw"></i> Last Generators Inspection Records
				</div>
				<!-- /.panel-heading -->
				<div class="panel-body">	

<a class="btn btn-default btn-circle" href="#anclaUp"><i class="fa fa-arrow-up"></i> </a>
				
					<table width="100%" class="table table-striped table-bordered table-hover" id="dataGenerator">
						<thead>
							<tr>
								<th>Date & Time</th>
								<th>Driver Name</th>
								<th>Vehicle Make</th>
								<th>Vehicle Model</th>
								<th>Unit Number</th>
								<th>Download</th>
								<th>Description</th>
								<th>Comments</th>
							</tr>
						</thead>
						<tbody>							
						<?php					
						if($infoGenerator){
							foreach ($infoGenerator as $lista):
$class = "";

//si hay errores se coloca en amarillo
if(
['belt'] == 0
 || ['fuel_filter'] == 0
 || ['oil_level'] == 0
 || ['coolant_level'] == 0
 || ['coolant_leaks'] == 0
 || ['turn_signal'] == 0
 || ['hazard_lights'] == 0
 || ['tail_lights'] == 0
 || ['flood_lights'] == 0
 || ['boom'] == 0
 || ['gears'] == 0
 || ['gauges'] == 0
 || ['pulley'] == 0
 || ['electrical'] == 0
 || ['brackers'] == 0
 || ['tires'] == 0
 || ['clean_exterior'] == 0
 || ['decals'] == 0
){
	$class = "warning";
}

//si hay comentarios se coloca en rojo
if($lista['comments'] != ''){
	$class = "danger";
}
							
								echo "<tr class='" . $class . "'>";
								echo "<td class='text-center'><p class='text-" . $class . "'>" . $lista['date_issue'] . "</p></td>";
								echo "<td><p class='text-" . $class . "'>" . $lista['name'] . "</p></td>";
								echo "<td class='text-center'><p class='text-" . $class . "'>" . $lista['make'] . "</p></td>";
								echo "<td class='text-center'><p class='text-" . $class . "'>" . $lista['model'] . "</p></td>";
								echo "<td class='text-center'><p class='text-" . $class . "'>" . $lista['unit_number'] . "</p></td>";
								echo "<td class='text-center'>";
						?>
<a href='<?php echo base_url('report/generaInsectionSpecialPDF/x/x/x/x/generator/' . $lista['id_inspection_generator'] ); ?>' target="_blank"> <img src='<?php echo base_url_images('pdf.png'); ?>' ></a>
						<?php
								echo "</td>";
								echo "<td><p class='text-" . $class . "'>" . $lista['description'] . "</p></td>";
								echo "<td><p class='text-" . $class . "'>" . $lista['comments'] . "</p></td>";
								echo "</tr>";
							endforeach;
						}

						?>
						</tbody>
					</table>
				</div>
				<!-- /.panel-body -->
			</div>
<?php	} ?>
<!-- FIN TABLA DE SPECIAL INSPECTION -->
		</div>
		
	</div>




		

</div>
<!-- /#page-wrapper -->


<?php
	if($infoSafety){ 
?>

<a name="anclaSafety"></a>
        <div id="page-wrapper">

            <div class="row">
                <div class="col-lg-12">
                    <div class="panel panel-info">
						
                        <div class="panel-heading">
                            <i class="fa fa-life-saver fa-fw"></i> <strong>LAST FIELD LEVEL HAZARD ASSESSMENT RECORDS</strong>
                        </div>
						
                        <div class="panel-body">
						
<a class="btn btn-default btn-circle" href="#anclaUp"><i class="fa fa-arrow-up"></i> </a>
						
							<table width="100%" class="table table-striped table-bordered table-hover" id="dataSafety">
								<thead>
									<tr>
										<th>Meeting conducted by</th>
										<th>Date & Time</th>
										<th>Work To Be Done</th>
										<th>Job Code/Name</th>
										<th>View</th>
									</tr>
								</thead>
								<tbody>							
								<?php
									foreach ($infoSafety as $lista):
										echo "<tr>";
										echo "<td>" . $lista['name'] . "</td>";
										echo "<td class='text-center'>" . $lista['date'] . "</td>";
										echo "<td>" . $lista['work'] . "</td>";
										echo "<td >" . $lista['job_description'] . "</td>";
										echo "<td class='text-center'>";
								?>
<a class='btn btn-info btn-xs' href='<?php echo base_url('safety/upload_info_safety/' . $lista['id_safety']) ?>'>
	View <span class="fa fa-life-saver" aria-hidden="true">
</a>
								<?php
										echo "</td>";
										echo "</tr>";
									endforeach;
								?>
								</tbody>
							</table>
					
                        </div>
                    </div>
<?php							
	echo  date("Y-m-d G:i:s");
?>	
                </div>
            </div>
        </div>
<?php	} ?>

    <!-- Tables -->
    <script>
    $(document).ready(function() {
        $('#dataTables').DataTable({
            responsive: true,
			 "ordering": false,
			 paging: false,
			"searching": false,
			"pageLength": 25
        });
		
        $('#dataHauling').DataTable({
            responsive: true,
			 "ordering": false,
			 paging: false,
			"searching": false
        });	

        $('#dataDaily').DataTable({
            responsive: true,
			 "ordering": false,
			 paging: false,
			"searching": false
        });	
		
        $('#dataHeavy').DataTable({
            responsive: true,
			 "ordering": false,
			 paging: false,
			"searching": false
        });
		
        $('#dataWatertruck').DataTable({
            responsive: true,
			 "ordering": false,
			 paging: false,
			"searching": false
        });
		
        $('#dataHydrovac').DataTable({
            responsive: true,
			 "ordering": false,
			 paging: false,
			"searching": false
        });
		
        $('#dataSweeper').DataTable({
            responsive: true,
			 "ordering": false,
			 paging: false,
			"searching": false
        });
		
        $('#dataGenerator').DataTable({
            responsive: true,
			 "ordering": false,
			 paging: false,
			"searching": false
        });

        $('#dataSafety').DataTable({
            responsive: true,
			 "ordering": false,
			 paging: false,
			"searching": false
        });	
		
		
    });
    </script>