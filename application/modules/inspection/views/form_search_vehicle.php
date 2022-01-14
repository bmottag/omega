<script type="text/javascript" src="<?php echo base_url("assets/js/validate/inspection/ajaxSearchVehicle.js"); ?>"></script>

<div id="page-wrapper">
	<br>
	
	<!-- /.row -->
	<div class="row">
		<div class="col-lg-6">
			<div class="panel panel-purpura">
				<div class="panel-heading">
					<i class="fa fa-wrench"></i> <strong>Form to search vehicle by VIN Number</strong>
				</div>
				<div class="panel-body">
									
					<p class='text-default'>Enter at least 5 consecutive characters of the<strong> VIN NUMBER</strong></p>
									
					<div class="form-group">
						<div class="col-sm-10 col-sm-offset-1">
							<label for="vinNumber">VIN NUMBER </label>
							<input type="text" id="vinNumber" name="vinNumber" class="form-control" placeholder="VIN NUMBER">
						</div>						
					</div>
						
				</div>
			</div>
		</div>
	
		<div class="col-lg-6" id="div_vehicle" style="display:none">
			<div class="panel panel-info">
				<div class="panel-heading">
					<i class="fa fa-automobile"></i> <strong>VEHICLE INFORMATION</strong>
				</div>
				<div class="panel-body" id="div_vehicle_info">
				

				</div>
			</div>
		</div>
					
	</div>	
</div>
<!-- /#page-wrapper -->