<script type="text/javascript" src="<?php echo base_url("assets/js/validate/admin/employee_v3.js"); ?>"></script>
<div class="modal-header">
	<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
	<h4 class="modal-title" id="exampleModalLabel">Employee Form
	<br><small>Add/Edit Employee</small>
	</h4>
</div>

<div class="modal-body">
	<form name="form" id="form" role="form" method="post" >
		<input type="hidden" id="hddId" name="hddId" value="<?php echo $information?$information[0]["id_user"]:""; ?>"/>
		
		<div class="row">
			<div class="col-sm-6">
				<div class="form-group text-left">
					<label class="control-label" for="firstName">First name</label>
					<input type="text" id="firstName" name="firstName" class="form-control" value="<?php echo $information?$information[0]["first_name"]:""; ?>" placeholder="First Name" required >
				</div>
			</div>
			
			<div class="col-sm-6">
				<div class="form-group text-left">
					<label class="control-label" for="lastName">Last name</label>
					<input type="text" id="lastName" name="lastName" class="form-control" value="<?php echo $information?$information[0]["last_name"]:""; ?>" placeholder="Last Name" required >
				</div>
			</div>
		</div>
		
		<div class="row">
			<div class="col-sm-6">
				<div class="form-group text-left">
					<label class="control-label" for="user">User name</label>
					<input type="text" id="user" name="user" class="form-control" value="<?php echo $information?$information[0]["log_user"]:""; ?>" placeholder="User Name" required >
				</div>
			</div>
			
			<div class="col-sm-6">
				<div class="form-group text-left">
					<label class="control-label" for="email">Email</label>
					<input type="text" class="form-control" id="email" name="email" value="<?php echo $information?$information[0]["email"]:""; ?>" placeholder="Email" />
				</div>
			</div>
		</div>

<script>
	$( function() {
		$( "#birth" ).datepicker({
			changeMonth: true,
			changeYear: true,
			dateFormat: 'yy-mm-dd',
			yearRange: "-60:-15", // last 60 years
		});
	});
</script>		
		<div class="row">
			<div class="col-sm-6">
				<div class="form-group text-left">
					<label class="control-label" for="birth">Date of birth</label>
					<input type="text" class="form-control" id="birth" name="birth" value="<?php echo $information?$information[0]["birthdate"]:""; ?>" placeholder="Date of birth" required />
				</div>
			</div>
			
			<div class="col-sm-6">
				<div class="form-group text-left">
					<label class="control-label" for="tipoSangre">RH</label>
					<select name="tipoSangre" id="tipoSangre" class="form-control" required>
						<option value="">Select...</option>
						<option value=1 <?php if($information[0]["rh"] == 1) { echo "selected"; }  ?>>O-</option>
						<option value=2 <?php if($information[0]["rh"] == 2) { echo "selected"; }  ?>>O+</option>
						<option value=3 <?php if($information[0]["rh"] == 3) { echo "selected"; }  ?>>A-</option>
						<option value=4 <?php if($information[0]["rh"] == 4) { echo "selected"; }  ?>>A+</option>
						<option value=5 <?php if($information[0]["rh"] == 5) { echo "selected"; }  ?>>B-</option>
						<option value=6 <?php if($information[0]["rh"] == 6) { echo "selected"; }  ?>>B+</option>
						<option value=7 <?php if($information[0]["rh"] == 7) { echo "selected"; }  ?>>AB-</option>
						<option value=8 <?php if($information[0]["rh"] == 8) { echo "selected"; }  ?>>AB+</option>
					</select>
				</div>
			</div>
		</div>

		<div class="row">
			<div class="col-sm-6">
				<div class="form-group text-left">
					<label class="control-label" for="insuranceNumber">Social insurance Number</label>
					<input type="text" id="insuranceNumber" name="insuranceNumber" class="form-control" value="<?php echo $information?$information[0]["social_insurance"]:""; ?>" placeholder="Social Insurance Number" required >
				</div>
			</div>
			
			<div class="col-sm-6">
				<div class="form-group text-left">
					<label class="control-label" for="healthNumber">Health number</label>
					<input type="text" id="healthNumber" name="healthNumber" class="form-control" value="<?php echo $information?$information[0]["health_number"]:""; ?>" placeholder="Health Number" required >
				</div>
			</div>
		</div>
				
		<div class="row">
			<div class="col-sm-6">
				<div class="form-group text-left">
					<label class="control-label" for="movilNumber">Movil number</label>
					<input type="text" id="movilNumber" name="movilNumber" class="form-control" value="<?php echo $information?$information[0]["movil"]:""; ?>" placeholder="Movil Number" required >
				</div>
			</div>
				
			<div class="col-sm-6">
				<div class="form-group text-left">
					<label class="control-label" for="address">Address</label>
					<input type="text" id="address" name="address" class="form-control" value="<?php echo $information?$information[0]["address"]:""; ?>" placeholder="Address" >
				</div>
			</div>
		</div>
				
		<div class="row">
			<div class="col-sm-6">
				<div class="form-group text-left">
					<label class="control-label" for="perfil">User role</label>					
					<select name="perfil" id="perfil" class="form-control" required>
						<option value="">Select...</option>
						<?php for ($i = 0; $i < count($roles); $i++) { ?>
							<option value="<?php echo $roles[$i]["id_rol"]; ?>" <?php if($information && $information[0]["perfil"] == $roles[$i]["id_rol"]) { echo "selected"; }  ?>><?php echo $roles[$i]["rol_name"]; ?></option>	
						<?php } ?>
					</select>
				</div>
			</div>
			
	<?php if($information){ ?>
			<div class="col-sm-6">
				<div class="form-group text-left">
					<label class="control-label" for="state">State</label>
					<select name="state" id="state" class="form-control" required>
						<option value=''>Select...</option>
						<option value=1 <?php if($information[0]["state"] == 1) { echo "selected"; }  ?>>Active</option>
						<option value=2 <?php if($information[0]["state"] == 2) { echo "selected"; }  ?>>Inactive</option>
					</select>
				</div>
			</div>
	<?php } ?>
		
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

		<div class="form-group">
			<div class="row" align="center">
				<div style="width:50%;" align="center">
					<button type="button" id="btnSubmit" name="btnSubmit" class="btn btn-primary" >
						Save <span class="glyphicon glyphicon-floppy-disk" aria-hidden="true">
					</button> 
				</div>
			</div>
		</div>
			
	</form>
</div>