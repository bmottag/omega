<script type="text/javascript" src="<?php echo base_url("assets/js/validate/workorder/materials.js"); ?>"></script>
<div class="modal-header">
	<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
	<h4 class="modal-title" id="exampleModalLabel">MATERIALS AND SUPPLIES
	<br><small>
				Add materials for the Work Order
	</small>
	</h4>
</div>

<div class="modal-body">
	<form  name="formMaterial" id="formMaterial" role="form" method="post" >
		<input type="hidden" id="hddidWorkorder" name="hddidWorkorder" value="<?php echo $idWorkorder; ?>"/>
		
		<div class="row">
			<div class="col-sm-12">
				<div class="form-group text-left">
					<label class="control-label" for="material">Material : *</label>
					<select name="material" id="material" class="form-control" >
						<option value=''>Select...</option>
						<?php for ($i = 0; $i < count($materialList); $i++) { ?>
							<option value="<?php echo $materialList[$i]["id_material"]; ?>" ><?php echo $materialList[$i]["material"]; ?></option>	
						<?php } ?>
					</select>
				</div>
			</div>
		</div>
		
		<div class="row">
			<div class="col-sm-12">
				<div class="form-group text-left">
					<label class="control-label" for="hour">Quantity : *</label>
					<input type="text" id="quantity" name="quantity" class="form-control" placeholder="Quantity" required >
				</div>
			</div>
		</div>
		
		<div class="row">
			<div class="col-sm-12">
				<div class="form-group text-left">
					<label class="control-label" for="unit">Unit : *</label>
					<input type="text" id="unit" name="unit" class="form-control" placeholder="Unit" required >
				</div>
			</div>
		</div>
		
		<div class="row">
			<div class="col-sm-12">
				<div class="form-group text-left">
					<label class="control-label" for="description">Description : </label>
					<textarea id="description" name="description" class="form-control" rows="3"></textarea>
				</div>
			</div>
		</div>
		
		<div class="form-group">
			<div class="row" align="center">
				<div style="width:50%;" align="center">
					<button type="button" id="btnSubmitMaterial" name="btnSubmitMaterial" class="btn btn-primary" >
						Save <span class="glyphicon glyphicon-floppy-disk" aria-hidden="true">
					</button> 
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