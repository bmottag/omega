<script type="text/javascript" src="<?php echo base_url("assets/js/validate/workorder/personal.js"); ?>"></script>
<div class="modal-header">
	<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
	<h4 class="modal-title" id="exampleModalLabel">PERSONAL
	<br><small>
				Add the eployees for the Work Order
	</small>
	</h4>
</div>

<div class="modal-body">
	<form  name="formPersonal" id="formPersonal" role="form" method="post" >
		<input type="hidden" id="hddidWorkorder" name="hddidWorkorder" value="<?php echo $idWorkorder; ?>"/>
		
		<div class="form-group text-left">
				<label for="employee">Employee : *</label>
				<select name="employee" id="employee" class="form-control" >
					<option value=''>Select...</option>
					<?php for ($i = 0; $i < count($workersList); $i++) { ?>
						<option value="<?php echo $workersList[$i]["id_user"]; ?>" ><?php echo $workersList[$i]["first_name"] . ' ' . $workersList[$i]["last_name"]; ?></option>	
					<?php } ?>
				</select>
		</div>

		<div class="form-group text-left">
				<label for="type">Employee Type : *</label>
				<select name="type" id="type" class="form-control" >
					<option value=''>Select...</option>
					<?php for ($i = 0; $i < count($employeeTypeList); $i++) { ?>
						<option value="<?php echo $employeeTypeList[$i]["id_employee_type"]; ?>" ><?php echo $employeeTypeList[$i]["employee_type"]; ?></option>	
					<?php } ?>
				</select>
		</div>
		
		<div class="form-group text-left">
			<label for="hour">Hours : *</label>
			<input type="text" id="hour" name="hour" class="form-control" placeholder="Hours" required >
		</div>
		
		<div class="form-group text-left">
			<label for="description">Task Description : *</label>
			<textarea id="description" name="description" class="form-control" rows="3"></textarea>
		</div>
		
		<div class="form-group">
			<button type="button" id="btnSubmitPersonal" name="btnSubmitPersonal" class="btn btn-primary" >Save</button> 
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