<script type="text/javascript" src="<?php echo base_url("assets/js/validate/jobs/excavation_access.js"); ?>"></script>

<script>
function valid_field() 
{
	if(document.getElementById('ladder').checked || document.getElementById('ramp').checked || document.getElementById('other').checked ){
		document.getElementById('hddField').value = 1;
	}else{
		document.getElementById('hddField').value = "";
	}
}
</script>

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
						<li class='active'><a href="<?php echo base_url('jobs/upload_access_egress/' . $information[0]['id_job_excavation']); ?>">Access & Egress </a>
						</li>
						<li><a href="<?php echo base_url('jobs/upload_affected_zone/' . $information[0]['id_job_excavation']); ?>">Affected Zone, Traffic & Utilities </a>
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
							<label class="col-sm-5 control-label" for="project_location">Choose the method of access / egress below that will be implemented:  *
								<br><small class="text-danger">(may choose more than one) </small></label>
							<div class="col-sm-5">
<input type="checkbox" id="ladder" name="ladder" value=1 <?php if($information && $information[0]["access_ladder"]){echo "checked";} ?> onclick="valid_field()"> Portable ladder(s) placed within 7 m of lateral travel<br>
<input type="checkbox" id="ramp" name="ramp" value=1 <?php if($information && $information[0]["access_ramp"]){echo "checked";} ?> onclick="valid_field()"> Ramp(s) placed within 15 m of lateral travel<br>
<input type="checkbox" id="other" name="other" value=1 <?php if($information && $information[0]["access_other"]){echo "checked";} ?> onclick="valid_field()"> Other means of access / egress: <br>

<?php 
$valorCampo = "";
if($information)
{
	if($information[0]["access_ladder"] || $information[0]["access_ramp"] || $information[0]["access_other"])
	{
		$valorCampo = 1;
	}
}
?>
<input type="hidden" id="hddField" name="hddField" value="<?php echo $valorCampo; ?>"/>
							
							</div>
						</div>
												
						<div class="form-group">
							<label class="col-sm-4 control-label" for="access_explain">Explain in detail: </label>
							<div class="col-sm-5">
								<textarea id="access_explain" name="access_explain" class="form-control" placeholder="Explain in detail" rows="3"><?php echo $information?$information[0]["access_explain"]:""; ?></textarea>
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