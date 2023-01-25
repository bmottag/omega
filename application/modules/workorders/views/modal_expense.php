<script type="text/javascript" src="<?php echo base_url("assets/js/validate/workorder/expense.js"); ?>"></script>
<div class="modal-header">
	<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
	<h4 class="modal-title" id="exampleModalLabel">WO Expense
	<br><small>
				Add Work Order Expense
	</small>
	</h4>
</div>

<div class="modal-body">
	<form  name="formExpense" id="formExpense" role="form" method="post" >
		<input type="hidden" id="hddidWorkorder" name="hddidWorkorder" value="<?php echo $idWorkorder; ?>"/>
		<input type="hidden" id="hddidJob" name="hddidJob" value="<?php echo $idJob; ?>"/>
						
		<div class="row">
			<div class="col-sm-12">
				<div class="form-group text-left">
					<label class="control-label" for="item">Item: *</label>
					<select name="item" id="item" class="form-control" required>
						<option value=''>Select...</option>
						<?php for ($i = 0; $i < count($jobDetails); $i++) { ?>
							<option value="<?php echo $jobDetails[$i]["id_job_detail"]; ?>"><?php echo $jobDetails[$i]["chapter_name"] . " - " . $jobDetails[$i]["chapter_number"] . "." . $jobDetails[$i]["item"] . " - " . $jobDetails[$i]["description"]; ?></option>	
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
					<button type="button" id="btnSubmitExpense" name="btnSubmitExpense" class="btn btn-primary" >
						Save <span class="glyphicon glyphicon-floppy-disk" aria-hidden="true">
					</button> 
				</div>
			</div>
		</div>
		
	</form>
</div>