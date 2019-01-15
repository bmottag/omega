<script type="text/javascript" src="<?php echo base_url("assets/js/validate/dayoff/dayoffModal.js"); ?>"></script>
<div class="modal-header">
	<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
	<h4 class="modal-title" id="exampleModalLabel">DAY OFF
	<br><small>As a reminder you need 72 hours for a regular dayoff or 24 hours in advanced for a Family/medical.</small>
	</h4>
</div>

<div class="modal-body">
	<form  name="form" id="form" role="form" method="post" >
		<div class="form-group text-left">
				<label for="type" class="control-label">Type : *</label>
				<select name="type" id="type" class="form-control" required>
					<option value="">Select...</option>
					<option value=1 >Family/medical appointment</option>
					<option value=2 >Regular</option>
				</select>
		</div> 
		
		<div class="form-group text-left">
				<label for="observation">Observation : *</label>
				<textarea id="observation" name="observation" class="form-control" rows="3"></textarea>
		</div> 
<script>
	$( function() {
		$( "#date" ).datepicker({
			minDate: '1',
			dateFormat: 'yy-mm-dd'
		});
	});
</script>
		<div class="form-group text-left">
				<label for="date">Date : *</label>
				<input type="text" class="form-control" id="date" name="date" value="" placeholder="Date" required />
		</div>			
		
		<div class="form-group">
			<button type="button" id="btnSubmit" name="btnSubmit" class="btn btn-primary" >Save</button> 
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