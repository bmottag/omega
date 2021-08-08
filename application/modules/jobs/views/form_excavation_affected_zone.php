<script type="text/javascript" src="<?php echo base_url("assets/js/validate/jobs/excavation_affected_zone.js"); ?>"></script>

<div id="page-wrapper">
	<br>
	
	<!-- /.row -->
	<div class="row">
		<div class="col-lg-12">
			<div class="panel panel-danger">
				<div class="panel-heading">
					<i class="fa fa-life-saver"></i> <strong>EXCAVATION AND TRENCHING PLAN</strong>
				</div>
				<div class="panel-body">
					<div class="alert alert-danger">
						<strong>Job Code/Name: </strong><?php echo $information?$information[0]["job_description"]:""; ?>
					</div>
				<?php 
					if($information){
				?>
					<ul class="nav nav-tabs">
						<li><a href="<?php echo base_url('jobs/add_excavation/' . $information[0]['fk_id_job'] . '/' . $information[0]['id_job_excavation']); ?>">Main Form</a>
						</li>
						<li><a href="<?php echo base_url('jobs/upload_excavation_personnel/' . $information[0]['id_job_excavation']); ?>">Personnel</a>
						</li>
						<li><a href="<?php echo base_url('jobs/upload_protection_methods/' . $information[0]['id_job_excavation']); ?>">Protection Methods & Systems</a>
						</li>
						<li><a href="<?php echo base_url('jobs/upload_access_egress/' . $information[0]['id_job_excavation']); ?>">Access & Egress </a>
						</li>
						<li class='active'><a href="<?php echo base_url('jobs/upload_affected_zone/' . $information[0]['id_job_excavation']); ?>">Affected Zone, Traffic & Utilities </a>
						</li>
					</ul>
					<br>
				<?php
					}
				?>

<?php
$retornoExito = $this->session->flashdata('retornoExito');
if ($retornoExito) {
    ?>
    <div class="row">
		<div class="col-lg-12">	
			<div class="alert alert-success ">
				<span class="glyphicon glyphicon-ok" aria-hidden="true"></span>
				<?php echo $retornoExito ?>		
			</div>
		</div>
	</div>
    <?php
}

$retornoError = $this->session->flashdata('retornoError');
if ($retornoError) {
    ?>
    <div class="row">
		<div class="col-lg-12">	
			<div class="alert alert-danger ">
				<span class="glyphicon glyphicon-exclamation-sign" aria-hidden="true"></span>
				<?php echo $retornoError ?>
			</div>
		</div>
	</div>
    <?php
}
?>

					<form  name="form" id="form" class="form-horizontal" method="post" >
						<input type="hidden" id="hddIdentificador" name="hddIdentificador" value="<?php echo $information?$information[0]["id_job_excavation"]:""; ?>"/>
														
						<div class="form-group">
							<label class="col-sm-4 control-label" for="located">Have utilities been located by a utility locate company? *
								<br><small class="text-danger">If no, STOP. Utility locates must be performed before digging is initiated.</small>
							</label>
							<div class="col-sm-5">									
								<select name="located" id="located" class="form-control" required>
									<option value="">Select...</option>
									<option value=1 <?php if($information[0]["located"] == 1) { echo "selected"; }  ?>>Yes</option>
									<option value=2 <?php if($information[0]["located"] == 2) { echo "selected"; }  ?>>No</option>
								</select>
							</div>
						</div>

						<div class="form-group">
							<label class="col-sm-4 control-label" for="permit_required">Is an excavation permit required in this area or on this project? *
								<br><small class="text-danger">If yes, please attach a copy of the permit to this plan.</small>
							</label>
							<div class="col-sm-5">									
								<select name="permit_required" id="permit_required" class="form-control" required>
									<option value="">Select...</option>
									<option value=1 <?php if($information[0]["permit_required"] == 1) { echo "selected"; }  ?>>Yes</option>
									<option value=2 <?php if($information[0]["permit_required"] == 2) { echo "selected"; }  ?>>No</option>
								</select>
							</div>
						</div>

						<div class="form-group">
							<label class="col-sm-4 control-label" for="utility_lines">Will utility lines (overhead or underground electrical / water / steam / sewer / storm / etc.) be present? *
							</label>
							<div class="col-sm-5">									
								<select name="utility_lines" id="utility_lines" class="form-control" required>
									<option value="">Select...</option>
									<option value=1 <?php if($information[0]["utility_lines"] == 1) { echo "selected"; }  ?>>Yes</option>
									<option value=2 <?php if($information[0]["utility_lines"] == 2) { echo "selected"; }  ?>>No</option>
								</select>
							</div>
						</div>
												
						<div class="form-group">
							<label class="col-sm-4 control-label" for="utility_lines_explain">If yes, explain: </label>
							<div class="col-sm-5">
								<textarea id="utility_lines_explain" name="utility_lines_explain" class="form-control" placeholder="If yes, explain" rows="3"><?php echo $information?$information[0]["utility_lines_explain"]:""; ?></textarea>
							</div>
						</div>

						<div class="form-group">
							<label class="col-sm-4 control-label" for="encumbrances">Will any surface encumbrances be located within the affected zone of the trench? *
							</label>
							<div class="col-sm-5">									
								<select name="encumbrances" id="encumbrances" class="form-control" required>
									<option value="">Select...</option>
									<option value=1 <?php if($information[0]["encumbrances"] == 1) { echo "selected"; }  ?>>Yes</option>
									<option value=2 <?php if($information[0]["encumbrances"] == 2) { echo "selected"; }  ?>>No</option>
								</select>
							</div>
						</div>

						<div class="form-group">
							<label class="col-sm-4 control-label" for="method_support">If yes, explain method of support / protection: </label>
							<div class="col-sm-5">
								<textarea id="method_support" name="method_support" class="form-control" placeholder="If yes, explain method of support / protection" rows="3"><?php echo $information?$information[0]["method_support"]:""; ?></textarea>
							</div>
						</div>

						<div class="form-group">
							<label class="col-sm-4 control-label" for="utility_shutdown">Will utility shutdown / shut off / or lock out tag out be required? *
								<br><small class="text-danger">If yes, reference the separate Hazardous Energy Control Plan </small>
							</label>
							<div class="col-sm-5">									
								<select name="utility_shutdown" id="utility_shutdown" class="form-control" required>
									<option value="">Select...</option>
									<option value=1 <?php if($information[0]["utility_shutdown"] == 1) { echo "selected"; }  ?>>Yes</option>
									<option value=2 <?php if($information[0]["utility_shutdown"] == 2) { echo "selected"; }  ?>>No</option>
								</select>
							</div>
						</div>

						<div class="form-group">
							<label class="col-sm-4 control-label" for="spoil_piles">Will spoil piles remain a minimum 60 cm from the excavation / trench edge? *
							</label>
							<div class="col-sm-5">									
								<select name="spoil_piles" id="spoil_piles" class="form-control" required>
									<option value="">Select...</option>
									<option value=1 <?php if($information[0]["spoil_piles"] == 1) { echo "selected"; }  ?>>Yes</option>
									<option value=2 <?php if($information[0]["spoil_piles"] == 2) { echo "selected"; }  ?>>No</option>
								</select>
							</div>
						</div>

						<div class="form-group">
							<label class="col-sm-4 control-label" for="spoils_transported">If no, will spoils be transported off site? 
							</label>
							<div class="col-sm-5">									
								<select name="spoils_transported" id="spoils_transported" class="form-control" >
									<option value="">Select...</option>
									<option value=1 <?php if($information[0]["spoils_transported"] == 1) { echo "selected"; }  ?>>Yes</option>
									<option value=2 <?php if($information[0]["spoils_transported"] == 2) { echo "selected"; }  ?>>No</option>
								</select>
							</div>
						</div>

						<div class="form-group">
							<label class="col-sm-4 control-label" for="environmental_controls">If yes, are environmental controls in place to reduce runoff?
							</label>
							<div class="col-sm-5">									
								<select name="environmental_controls" id="environmental_controls" class="form-control" >
									<option value="">Select...</option>
									<option value=1 <?php if($information[0]["environmental_controls"] == 1) { echo "selected"; }  ?>>Yes</option>
									<option value=2 <?php if($information[0]["environmental_controls"] == 2) { echo "selected"; }  ?>>No</option>
								</select>
							</div>
						</div>

						<div class="form-group">
							<label class="col-sm-4 control-label" for="open_overnight">Will the excavation / trench be left open overnight? *
							</label>
							<div class="col-sm-5">									
								<select name="open_overnight" id="open_overnight" class="form-control" required>
									<option value="">Select...</option>
									<option value=1 <?php if($information[0]["open_overnight"] == 1) { echo "selected"; }  ?>>Yes</option>
									<option value=2 <?php if($information[0]["open_overnight"] == 2) { echo "selected"; }  ?>>No</option>
								</select>
							</div>
						</div>


						<div class="form-group">
							<label class="col-sm-4 control-label" for="methods_secure">If yes, describe methods to secure the excavation area from the public or bystanders: </label>
							<div class="col-sm-5">
								<textarea id="methods_secure" name="methods_secure" class="form-control" placeholder="If yes, describe methods to secure the excavation area from the public or bystanders" rows="3"><?php echo $information?$information[0]["methods_secure"]:""; ?></textarea>
							</div>
						</div>

						<div class="form-group">
							<label class="col-sm-4 control-label" for="vehicle_traffic">Will worker(s) accessing or working from the trench be exposed to vehicle traffic? *
								<br><small class="text-danger">If yes, please reference separate Traffic Control Plan. </small>
							</label>
							<div class="col-sm-5">									
								<select name="vehicle_traffic" id="vehicle_traffic" class="form-control" required>
									<option value="">Select...</option>
									<option value=1 <?php if($information[0]["vehicle_traffic"] == 1) { echo "selected"; }  ?>>Yes</option>
									<option value=2 <?php if($information[0]["vehicle_traffic"] == 2) { echo "selected"; }  ?>>No</option>
								</select>
							</div>
						</div>


					




						<div class="form-group">
							<div class="row" align="center">
								<div style="width:100%;" align="center">
									<button type="button" id="btnSubmit" name="btnSubmit" class='btn btn-danger'>
											Save <span class="glyphicon glyphicon-floppy-disk" aria-hidden="true">
									</button>						
								</div>
							</div>
						</div>
						
					</form>
					
					<!-- /.row (nested) -->
				</div>
				<!-- /.panel-body -->
			</div>
			<!-- /.panel -->
		</div>
		<!-- /.col-lg-12 -->
	</div>
	<!-- /.row -->
</div>
<!-- /#page-wrapper -->