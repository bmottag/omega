<script type="text/javascript" src="<?php echo base_url("assets/js/validate/serviceorder/service_order.js"); ?>"></script>
<script type="text/javascript" src="<?php echo base_url("assets/js/validate/workorder/ajaxTrucks_v2.js"); ?>"></script>
<div class="modal-header">
	<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
	<h4 class="modal-title" id="exampleModalLabel">Service Order Form
	<br><small>Add/Edit Service Order</small>
	</h4>
</div>

<div class="modal-body">
	<form name="form" id="form" role="form" method="post" >
		<input type="hidden" id="hddIdServiceOrder" name="hddIdServiceOrder" value="<?php echo ($information && isset($information[0]["id_service_order"]))?$information[0]["id_service_order"]:""; ?>"/>
		
		<div class="row">
			<div class="col-sm-12">
				<div class="form-group text-left">
					<label class="control-label" for="type">Type: *</label>
					<select name="type" id="type" class="form-control" required>
						<option value=''>Select...</option>
						<?php for ($i = 0; $i < count($equipmentType); $i++) { ?>
							<option value="<?php echo $equipmentType[$i]["id_type_2"]; ?>" <?php if($information && $information[0]["fk_id_type_2"] == $equipmentType[$i]["id_type_2"]) { echo "selected"; }  ?>><?php echo $equipmentType[$i]["type_2"]; ?></option>	
						<?php } ?>
					</select>
				</div>
			</div>
		</div>
					
		<div class="row">
			<div class="col-sm-12">
				<div class="form-group text-left">
					<div id="div_truck">
						<label class="control-label" for="truck">Equipment: *</label>
						<select name="truck" id="truck" class="form-control" >
							<?php if ($information) { ?>
								<option value=''>Select...</option>
								<?php
								if($equipmentList) {
									foreach ($equipmentList as $data) {
								?>
									<option value="<?php echo $data["id_truck"]; ?>" <?php if($information && $information[0]["fk_id_equipment"] == $data["id_truck"]) { echo "selected"; }  ?> ><?php echo $data["unit_number"]; ?> </option>
								<?php
									}
								}
								?>
							<?php } ?>
						</select>
					</div>
				</div>
			</div>
		</div>

		<div class="row">
			<div class="col-sm-6">
				<div class="form-group text-left">
					<label class="control-label" for="hour">Current Hours: *</label>
					<input type="text" id="hour" name="hour" class="form-control" placeholder="Current Hours" value="<?php echo $information?$information[0]["current_hours"]:""; ?>" required >
				</div>
			</div>
			
			<div class="col-sm-6">
				<div class="form-group text-left">
					<label class="control-label" for="damages">Damages: *</label>
					<select name="damages" id="damages" class="form-control" required>
						<option value=''>Select...</option>
						<option value=1 <?php if($information && $information[0]["damages"] == 1 ) { echo "selected"; }  ?> >Yes</option>
						<option value=2 <?php if($information && $information[0]["damages"] == 2 ) { echo "selected"; }  ?> >No</option>
					</select>
				</div>
			</div>
		</div>

		<div class="row">
			<div class="col-sm-6">		
				<div class="form-group text-left">
					<label class="control-label" for="services">Services: *</label><br>
					<input type="checkbox" id="shop_labour" name="shop_labour" value=1 <?php if($information && $information[0]["shop_labour"]){echo "checked";} ?> > Shop Labour <br>
					<input type="checkbox" id="field_labour" name="field_labour" value=1 <?php if($information && $information[0]["field_labour"]){echo "checked";} ?> > Field Labour <br>
					<input type="checkbox" id="engine_oil" name="engine_oil" value=1 <?php if($information && $information[0]["engine_oil"]){echo "checked";} ?> > Engine Oil <br>
					<input type="checkbox" id="transmission_oil" name="transmission_oil" value=1 <?php if($information && $information[0]["transmission_oil"]){echo "checked";} ?> >  Transmission Oil<br>
					<input type="checkbox" id="hydraulic_oil" name="hydraulic_oil" value=1 <?php if($information && $information[0]["hydraulic_oil"]){echo "checked";} ?> > Hydraulic Oil<br>
					<input type="text" id="other" name="other" class="form-control" placeholder="Other, specify" value="<?php echo $information?$information[0]["other"]:""; ?>" >
				</div>
			</div>

			<div class="col-sm-6">		
				<div class="form-group text-left">
					<label class="control-label" for="documents"></label><br>
					<input type="checkbox" id="fuel" name="fuel" value=1 <?php if($information && $information[0]["fuel"]){echo "checked";} ?> > Fuel<br>
					<input type="checkbox" id="filters" name="filters" value=1 <?php if($information && $information[0]["filters"]){echo "checked";} ?> > Filters<br>
					<input type="checkbox" id="parts" name="parts" value=1 <?php if($information && $information[0]["parts"]){echo "checked";} ?> > Parts  <br>
					<input type="checkbox" id="blade" name="blade" value=1 <?php if($information && $information[0]["blade"]){echo "checked";} ?> > Blade  <br>
					<input type="checkbox" id="ripper" name="ripper" value=1 <?php if($information && $information[0]["ripper"]){echo "checked";} ?> > Ripper  <br>
				</div>
			</div>
		</div>

		<div class="row">
			<div class="col-sm-12">
				<div class="form-group text-left">
					<label class="control-label" for="type">Comments: *</label>
					<textarea id="comments" name="comments" placeholder="Notes/Observations" class="form-control" rows="3"><?php echo $information?$information[0]["comments"]:""; ?></textarea>
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