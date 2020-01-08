<script type="text/javascript" src="<?php echo base_url("assets/js/validate/workorder/ajaxTrucks.js"); ?>"></script>
<script type="text/javascript" src="<?php echo base_url("assets/js/validate/workorder/equipment.js"); ?>"></script>
<div class="modal-header">
	<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
	<h4 class="modal-title" id="exampleModalLabel">EQUIPMENT
	<br><small>
				Add the Equipment for the Work Order
	</small>
	</h4>
</div>

<div class="modal-body">
	<form  name="formEquipment" id="formEquipment" role="form" method="post" >
		<input type="hidden" id="hddidWorkorder" name="hddidWorkorder" value="<?php echo $idWorkorder; ?>"/>
				
		<div class="row">
			<div class="col-sm-12">
				<div class="form-group text-left">
					<label class="control-label" for="type">Type : *</label>
					<select name="type" id="type" class="form-control" required>
						<option value=''>Select...</option>
						<?php for ($i = 0; $i < count($equipmentType); $i++) { ?>
							<option value="<?php echo $equipmentType[$i]["id_type_2"]; ?>"><?php echo $equipmentType[$i]["type_2"]; ?></option>	
						<?php } ?>
					</select>
				</div>
			</div>
		</div>
					
		<div class="row">
			<div class="col-sm-12">
				<div class="form-group text-left">
					<div id="div_truck">
						<label for="truck">Equipment : *</label>
						<select name="truck" id="truck" class="form-control" >

						</select>
					</div>
				</div>
			</div>
		</div>

				<div class="form-group text-left">
					<div id="div_other" style="display:none">
						<label for="otherEquipment">Tools : *</label>
						<input type="text" id="otherEquipment" name="otherEquipment" class="form-control" placeholder="Tools" required >
					</div>
				</div>
				
		<div class="form-group text-left">
				<label for="operatedby">Operated by : *</label>
				<select name="operatedby" id="operatedby" class="form-control" >
					<option value=''>Select...</option>
					<?php for ($i = 0; $i < count($workersList); $i++) { ?>
						<option value="<?php echo $workersList[$i]["id_user"]; ?>" ><?php echo $workersList[$i]["first_name"] . ' ' . $workersList[$i]["last_name"]; ?></option>	
					<?php } ?>
				</select>
		</div>

		
		<div class="row">
			<div class="col-sm-6">
				<div class="form-group text-left">
					<label for="hour">Hours : *</label>
					<input type="text" id="hour" name="hour" class="form-control" placeholder="Hours" required >
				</div>
			</div>
			
			<div class="col-sm-6">
				<div class="form-group text-left">
					<label for="quantity">Quantity : </label>
					<input type="text" id="quantity" name="quantity" class="form-control" placeholder="Quantity" >
				</div>
			</div>
		</div>
		
		
		<div class="row">
			<div class="col-sm-12">
				<div class="form-group text-left">
					<label for="description">Description : *</label>
					<textarea id="description" name="description" class="form-control" rows="3"></textarea>
				</div>
			</div>
		</div>
		
		<div class="form-group">
			<button type="button" id="btnSubmitEquipment" name="btnSubmitEquipment" class="btn btn-primary" >Save</button> 
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