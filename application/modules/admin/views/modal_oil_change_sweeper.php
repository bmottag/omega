<script type="text/javascript" src="<?php echo base_url("assets/js/validate/admin/vehicle_oil_change_sweeper.js"); ?>"></script>

<div class="modal-header">
	<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
	<h4 class="modal-title" id="exampleModalLabel">Next Oil Change
	<br><small>Update the current Hours/Kilometers and the next oil change</small>
	</h4>
</div>

<div class="modal-body">
	<form name="form" id="form" role="form" method="post" >
		<input type="hidden" id="hddId" name="hddId" value="<?php echo $vehicleInfo[0]['id_vehicle']; ?>"/>
		
		<div class="row">
			<div class="col-sm-6">
				<div class="form-group text-left">
					<label class="control-label" for="hours">Truck engine current hours</label>
					<input type="text" id="hours" name="hours" class="form-control" placeholder="Hours/Kilometers" value="<?php echo $vehicleInfo[0]['hours']; ?>" required >
				</div>
			</div>
			
			<div class="col-sm-6">
				<div class="form-group text-left">
					<label class="control-label" for="oilChange">Next Oil change</label>
					<input type="text" id="oilChange" name="oilChange" class="form-control" placeholder="Hours/Kilometers" value="<?php echo $vehicleInfo[0]['oil_change']; ?>" required >
				</div>
			</div>
		</div>
		
		<div class="row">
			<div class="col-sm-6">
				<div class="form-group text-left">
					<label class="control-label" for="hours">Sweeper engine current hours</label>
					<input type="text" id="hours2" name="hours2" class="form-control" placeholder="Hours/Kilometers" value="<?php echo $vehicleInfo[0]['hours_2']; ?>" required >
				</div>
			</div>
			
			<div class="col-sm-6">
				<div class="form-group text-left">
					<label class="control-label" for="oilChange">Next Oil change</label>
					<input type="text" id="oilChange2" name="oilChange2" class="form-control" placeholder="Hours/Kilometers" value="<?php echo $vehicleInfo[0]['oil_change_2']; ?>" required >
				</div>
			</div>
		</div>
		
		<div class="form-group">
			<div class="row" align="center">
				<div style="width:50%;" align="center">
					<input type="button" id="btnSubmit" name="btnSubmit" value="Save" class="btn btn-primary"/>
				</div>
			</div>
		</div>
		
		<div class="form-group">
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
			
	</form>
</div>