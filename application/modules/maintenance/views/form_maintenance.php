<script type="text/javascript" src="<?php echo base_url("assets/js/validate/maintenance/maintenance.js"); ?>"></script>

<div id="page-wrapper">
	<br>
	
	<!-- /.row -->
	<div class="row">
		<div class="col-lg-8">
			<div class="panel panel-purpura">
				<div class="panel-heading">
					<a class="btn btn-purpura btn-xs" href="<?php echo base_url().'admin/vehicle/'.$vehicleInfo[0]["type_level_1"]; ?> "><span class="glyphicon glyphicon glyphicon-chevron-left" aria-hidden="true"></span> Go back </a> 
					<i class="fa fa-wrench"></i> <strong>FORM MAINTENANCE</strong>
				</div>
				<div class="panel-body">
				
<form  name="form" id="form" class="form-horizontal" method="post"  >
	<input type="hidden" id="hddIdVehicle" name="hddIdVehicle" value="<?php echo $vehicleInfo[0]['id_vehicle']; ?>"/>
	<input type="hidden" id="hddIdMaintenance" name="hddIdMaintenance" value="<?php echo $information?$information[0]["id_maintenance"]:""; ?>"/>

						<div class="form-group">
							<div class="col-sm-5 col-sm-offset-1">
								<label for="from">Maintenance type </label>
								<select name="id_maintenance_type" id="id_maintenance_type" class="form-control" >
									<option value=''>Select...</option>
									<?php for ($i = 0; $i < count($infoTypeMaintenance); $i++) { ?>
										<option value="<?php echo $infoTypeMaintenance[$i]["id_maintenance_type"]; ?>" <?php if($information[0]["fk_id_maintenance_type"] == $infoTypeMaintenance[$i]["id_maintenance_type"]) { echo "selected"; }  ?>><?php echo $infoTypeMaintenance[$i]["maintenance_type"]; ?></option>
									<?php } ?>
								</select>
							</div>

							<div class="col-sm-5">
								<label for="from">Amount </label>
								<input type="text" id="amount" name="amount" class="form-control" value="<?php echo $information?$information[0]["amount"]:""; ?>" placeholder="Amount" >
							</div>							
						</div>
												
						<div class="form-group">
							<div class="col-sm-10 col-sm-offset-1">
								<label for="from">Description </label>
								<input type="text" id="description" name="description" class="form-control" value="<?php echo $information?$information[0]["maintenance_description"]:""; ?>" placeholder="Description">
							</div>
						</div>
						
						<div class="form-group">
							<div class="col-sm-5 col-sm-offset-1">
								<label for="from">Done by </label>
								<input type="text" id="done_by" name="done_by" class="form-control" value="<?php echo $information?$information[0]["done_by"]:""; ?>" placeholder="Done by">
							</div>
							
							<div class="col-sm-5">
								<label for="from">Revised by </label>
								<select name="revised_by" id="revised_by" class="form-control">
									<option value=''>Select...</option>
									<?php for ($i = 0; $i < count($workersList); $i++) { ?>
										<option value="<?php echo $workersList[$i]["id_user"]; ?>" <?php if($information[0]["fk_revised_by_user"] == $workersList[$i]["id_user"]) { echo "selected"; }  ?>><?php echo $workersList[$i]["first_name"] . ' ' . $workersList[$i]["last_name"]; ?></option>	
									<?php } ?>
								</select>
							</div>
						</div>

						<div class="form-group">
							<div class="row" align="center">
								<div style="width:100%;" align="center">							
									<button type="button" id="btnSubmit" name="btnSubmit" class='btn btn-purpura'>
										Save <span class="glyphicon glyphicon-floppy-disk" aria-hidden="true">
									</button>
								</div>
							</div>
						</div>
								
						<div class="form-group">
							<div class="row" align="center">
								<div style="width:80%;" align="center">
									<div id="div_load" style="display:none">		
										<div class="progress progress-striped active">
											<div class="progress-bar" role="progressbar" aria-valuenow="45" aria-valuemin="0" aria-valuemax="100" style="width: 45%">
												<span class="sr-only">45% completado</span>
											</div>
										</div>
									</div>
									<div id="div_error" style="display:none">			
										<div class="alert alert-danger"><span class="glyphicon glyphicon-remove" id="span_msj">&nbsp;</span></div>
									</div>
								</div>
							</div>
						</div>								

					</form>

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
					<strong>Current Hours/Kilometers: </strong><?php echo $vehicleInfo[0]['hours']; ?>
				</div>
			</div>
		</div>
				
<?php if($information){ ?>
		<div class="col-lg-4">
			<div class="panel panel-danger">
				<div class="panel-heading">
					<a class="btn btn-danger btn-xs" href="<?php echo base_url().'maintenance/entrance/' . $vehicleInfo[0]["id_vehicle"] . '/' . $information[0]["id_maintenance"]; ?> "><span class="glyphicon glyphicon-edit" aria-hidden="true"></span> Edit </a> 
					<i class="fa fa-flag"></i> <strong>LAST RECORD</strong>
				</div>
				<div class="panel-body">
					<strong>Date: </strong><?php echo $information[0]['date_maintenance']; ?><br>
					<strong>Amount: </strong><?php echo $information[0]['amount']; ?><br>
					<strong>Maintenance type: </strong><?php echo $information[0]['maintenance_type']; ?><br>
					<strong>Description: </strong><?php echo $information[0]['maintenance_description']; ?><br>
					<strong>Done by: </strong><?php echo $information[0]['done_by']; ?><br>
					<strong>Revised by: </strong><?php echo $information[0]['name']; ?>
				</div>
			</div>
		</div>
<?php } ?>		
		
	</div>								
	
<?php
$retornoExito = $this->session->flashdata('retornoExito');
if ($retornoExito) {
    ?>
	<div class="col-lg-12">	
		<div class="alert alert-success">
			<span class="glyphicon glyphicon-ok" aria-hidden="true"></span>
			<?php echo $retornoExito ?>		
		</div>
	</div>
    <?php
}

$retornoError = $this->session->flashdata('retornoError');
if ($retornoError) {
    ?>
	<div class="col-lg-12">	
		<div class="alert alert-danger ">
			<span class="glyphicon glyphicon-exclamation-sign" aria-hidden="true"></span>
			<?php echo $retornoError ?>
		</div>
	</div>
    <?php
}
?> 



</div>
<!-- /#page-wrapper -->