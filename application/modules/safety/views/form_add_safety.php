<script type="text/javascript" src="<?php echo base_url("assets/js/validate/safety/safety.js"); ?>"></script>

<div id="page-wrapper">
	<br>
	
	<!-- /.row -->
	<div class="row">
		<div class="col-lg-12">
			<div class="panel panel-default">
				<div class="panel-heading">
					<a class="btn btn-default btn-xs" href=" <?php echo base_url().'jobs/safety/' . $jobInfo[0]["id_job"]; ?> "><span class="glyphicon glyphicon glyphicon-chevron-left" aria-hidden="true"></span> Go back </a> 
					<i class="fa fa-life-saver"></i> <strong>FLHA - FIELD LEVEL HAZARD ASSESSMENT</strong>
				</div>
				<div class="panel-body">
				
					<div class="alert alert-info">
						<strong>Job Code/Name: </strong><?php echo $jobInfo[0]['job_description']; ?>
					</div>

<?php
$retornoExito = $this->session->flashdata('retornoExito');
if ($retornoExito) {
    ?>
	<div class="col-lg-12">	
		<div class="alert alert-success ">
			<span class="glyphicon glyphicon-ok" aria-hidden="true"></span>
			<?php echo $retornoExito ?>		
		</div>
	</div>
    <?php
}

$retornoError = $this->session->flashdata('retornoError');
if ($retornoError) {
    ?>
	<div class="col-lg-12">	
		<div class="alert alert-danger ">
			<span class="glyphicon glyphicon-exclamation-sign" aria-hidden="true"></span>
			<?php echo $retornoError ?>
		</div>
	</div>
    <?php
}
?>

<?php 
//verificar si el JOB CODE tiene asignados hazards
if(!$hazards){
?>
	<div class="alert alert-danger ">
		<span class="glyphicon glyphicon-exclamation-sign" aria-hidden="true"></span>
		This work does not have hazards.
	</div>
<?php	
}else{
?>

					<form  name="form" id="form" class="form-horizontal" method="post" action="<?php echo base_url("payroll/savePayroll"); ?>" >
						<input type="hidden" id="hddIdJob" name="hddIdJob" value="<?php echo $jobInfo[0]["id_job"]; ?>"/>
						<input type="hidden" id="hddIdentificador" name="hddIdentificador" value="<?php echo $information?$information[0]["id_safety"]:""; ?>"/>
						<!-- 2: id_task FILED LEVEL HAZARD Assessment -->
						<input type="hidden" id="hddTask" name="hddTask" value="2"/>


														
						<div class="form-group">
							<label class="col-sm-4 control-label" for="work">Work to be done</label>
							<div class="col-sm-5">
							<textarea id="work" name="work" class="form-control" placeholder="Work To Be Done" rows="3"><?php echo $information?$information[0]["work"]:""; ?></textarea>
							</div>
						</div>
														
						<div class="form-group">
							<label class="col-sm-4 control-label" for="musterPoint">Muster point</label>
							<div class="col-sm-5">
							<textarea id="musterPoint" name="musterPoint" placeholder="Muster Point" class="form-control" rows="3"><?php echo $information?$information[0]["muster_point"]:""; ?></textarea>
							</div>
						</div>
						

						<div class="form-group">
							<label class="col-sm-4 control-label" for="ppe">PPE</label>
							<div class="col-sm-5">
							   <div class="checkbox">
									<label>
										<input type="checkbox" id="ppe" name="ppe" <?php if($information[0]["ppe"] == 1) { echo "checked"; }  ?> />
									</label>
								</div>
							</div>
						</div>
						
						<div class="form-group">
							<label class="col-sm-4 control-label" for="management">Specify PPE</label>
							<div class="col-sm-5">
								<textarea id="specify" name="specify" class="form-control" placeholder="Specify PPE" rows="3"><?php echo $information?$information[0]["specify_ppe"]:""; ?></textarea>
							</div>
						</div>
					
						<div class="form-group">
							<div class="row" align="center">
								<div style="width:100%;" align="center">
									<button type="button" id="btnSubmit" name="btnSubmit" class='btn btn-primary'>
											Save <span class="glyphicon glyphicon-floppy-disk" aria-hidden="true">
									</button>						
								</div>
							</div>
						</div>
						
					</form>
					
<?php
}
?>

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