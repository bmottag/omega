<script type="text/javascript" src="<?php echo base_url("assets/js/validate/jobs/fire_watch.js"); ?>"></script>
<div class="modal-header">
	<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
	<h4 class="modal-title" id="exampleModalLabel">Fire Watch Form
	<br><small>Add/Edit Fire Watch</small>
	</h4>
</div>

<div class="modal-body">
	<form name="form" id="form" role="form" method="post" >
		<input type="hidden" id="hddIdJob" name="hddIdJob" value="<?php echo $idJob; ?>"/>
		<input type="hidden" id="hddIdFireWatch" name="hddIdFireWatch" value="<?php echo $information?$information[0]["id_job_fire_watch"]:""; ?>"/>
		
		<div class="row">
			<div class="col-sm-12">
				<div class="form-group text-left">
					<label class="control-label" for="address">Facility/Building Address: *</label>
					<input type="text" id="address" name="address" class="form-control" value="<?php echo $information?$information[0]["building_address"]:""; ?>" placeholder="Facility/Building Address" required >
				</div>
			</div>
		</div>

		<div class="row">
			<div class="col-sm-6">		
				<div class="form-group text-left">
					<label class="control-label" for="conductedby">Fire Watch Conducted by: *</label>
					<select name="conductedby" id="conductedby" class="form-control" >
						<option value=''>Select...</option>
						<?php for ($i = 0; $i < count($workersList); $i++) { ?>
							<option value="<?php echo $workersList[$i]["id_user"]; ?>" <?php if($information && $information[0]["fk_id_conducted_by"] == $workersList[$i]["id_user"]) { echo "selected"; }  ?>><?php echo $workersList[$i]["first_name"] . ' ' . $workersList[$i]["last_name"]; ?></option>	
						<?php } ?>
					</select>
				</div>
			</div>
		</div>

<?php
	$date = "";
	$time = "";
	if($information) { 
		$CompleteDate = $information[0]['date'];
		$date = substr($CompleteDate, 0, 10); 
		$time = substr($CompleteDate, 11, 2);
	}
?>
		<div class="row">
			<div class="col-sm-6">		
				<div class="form-group text-left">
					<script>
						$( function() {
							$( "#date" ).datepicker({
								minDate: '1',
								dateFormat: 'yy-mm-dd'
							});
						});
					</script>
					<label class="control-label" for="date">Date: *</label>
					<input type="text" class="form-control" id="date" name="date" value="<?php echo $date; ?>" placeholder="Date" required />
				</div>
			</div>
			
			<div class="col-sm-6">
				<div class="form-group text-left">
					<label for="type" class="control-label">Time: *</label>
					<select name="time" id="time" class="form-control" required>
						<option value='' >Select...</option>
						<?php
							for ($i = 0; $i < 24; $i++) {
								$i = $i<10?"0".$i:$i;
						?>
								<option value='<?php echo $i; ?>' <?php if($time == $i) { echo "selected"; }  ?> ><?php echo $i; ?></option>
						<?php } ?>									
					</select>
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