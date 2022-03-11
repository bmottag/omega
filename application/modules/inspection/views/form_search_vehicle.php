<script type="text/javascript" src="<?php echo base_url("assets/js/validate/inspection/ajaxSearchVehicle_v1.js"); ?>"></script>

<div id="page-wrapper">
	<br>

	<div class="row">
		<div class="col-lg-6">
			<div class="panel panel-purpura">
				<div class="panel-heading">
					<i class="fa fa-wrench"></i> <strong>Form to search vehicle by VIN Number</strong>
				</div>
				<div class="panel-body">
									
					<p class='text-default'>Enter at least 5 consecutive characters of the<strong> VIN NUMBER</strong></p>
									
					<div class="form-group">
						<div class="col-sm-10">
							<label for="vinNumber">VIN NUMBER </label>
							<input type="text" id="vinNumber" name="vinNumber" class="form-control" placeholder="VIN NUMBER">
						</div>						
					
						<div class="col-sm-2">
							<br>
							 <button type="submit" class="btn btn-purpura">
							 	<span class="glyphicon glyphicon-search" aria-hidden="true"></span> Search 
							 </button>
						</div>

					</div>
						
				</div>
			</div>
		</div>
	</div>
	
	<div class="row" id="div_vehicle" style="display:none">
	
	</div>	
</div>
<!-- /#page-wrapper -->