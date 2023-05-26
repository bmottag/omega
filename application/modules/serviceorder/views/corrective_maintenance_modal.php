<script type="text/javascript" src="<?php echo base_url("assets/js/validate/serviceorder/corrective_maintenance.js"); ?>"></script>

<div class="modal-header">
	<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
	<h4 class="modal-title" id="exampleModalLabel">Corrective Maintenance
		<br><small>Add/Edit Corrective Maintenance</small>
	</h4>
</div>

<div class="modal-body">
	<form name="formPreventiveMaintenance" id="formPreventiveMaintenance" role="form" method="post" >
		<input type="hidden" id="hddIdEquipment" name="hddIdEquipment" value="<?php echo $this->input->post("idEquipment"); ?>"/>
		<input type="hidden" id="hddIdMaintenance" name="hddIdMaintenance" value="<?php echo $information?$information[0]["id_corrective_maintenance"]:""; ?>"/>

		<div class="row">
			<div class="col-sm-12">
				<div class="form-group text-left">
					<label class="control-label" for="maintenance_type"> Maintenance Type: * </label>
					<select name="maintenance_type" id="maintenance_type" class="form-control" required >
						<option value=''>Select...</option>
						<?php for ($i = 0; $i < count($infoTypeMaintenance); $i++) { ?>
							<option value="<?php echo $infoTypeMaintenance[$i]["id_maintenance_type"]; ?>" <?php if($information){ if($information[0]["fk_id_maintenance_type"] == $infoTypeMaintenance[$i]["id_maintenance_type"]) { echo "selected"; }}  ?>><?php echo $infoTypeMaintenance[$i]["maintenance_type"]; ?></option>		
						<?php } ?>
					</select>
				</div>
			</div>
		</div>

		<div class="row">
			<div class="col-sm-12">
				<div class="form-group text-left">
					<label class="control-label" for="type">Description of Failure or Damage: *</label>
					<textarea id="description" name="description" placeholder="Description of Failure or Damage" class="form-control" rows="3" required><?php echo $information?$information[0]["description_failure"]:""; ?></textarea>
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
					<button type="button" id="btnSubmitCorrectiveMaintenance" name="btnSubmitCorrectiveMaintenance" class="btn btn-primary" >
						Save <span class="glyphicon glyphicon-floppy-disk" aria-hidden="true">
					</button> 
				</div>
			</div>
		</div>
			
	</form>
</div>