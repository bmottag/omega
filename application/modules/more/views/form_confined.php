<script type="text/javascript" src="<?php echo base_url("assets/js/validate/more/confined.js"); ?>"></script>

<?php
/**
 * If it is an ADMIN user, show date 
 * @author BMOTTAG
 * @since  11/5/2017
 */
$userRol = $this->session->rol;
if($userRol==99){
?>
<link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
<?php } ?>

<div id="page-wrapper">
	<br>

	
	<!-- /.row -->
	<div class="row">
		<div class="col-lg-12">
			<div class="panel panel-warning">
				<div class="panel-heading">
					<a class="btn btn-warning btn-xs" href=" <?php echo base_url().'more/confined/' . $jobInfo[0]['id_job']; ?> "><span class="glyphicon glyphicon glyphicon-chevron-left" aria-hidden="true"></span> Go back </a> 
					<i class="fa fa-cube"></i> <strong>CONFINED SPACE ENTRY PERMIT FORM</strong>
				</div>
				<div class="panel-body">
				
					<div class="alert alert-warning">
						<strong>Job Code/Name: </strong><?php echo $jobInfo[0]['job_description']; ?>
						<br><strong>Date: </strong>
						<?php 
						if($information){
								echo $information[0]["date_confined"]; 
								
								echo "<br><strong>Dowloand Confined Entry Permit Form: </strong>";
						?>
<a href='<?php echo base_url('more/generaTemplatePDF/' . $information[0]["id_job_confined"] ); ?>' target="_blank">PDF <img src='<?php echo base_url_images('pdf.png'); ?>' ></a>	
						<?php 
						}else{
								echo date("Y-m-d");
						}
						?>
					</div>
				
				</div>
			</div>
		</div>
	</div>								
	
<?php
$retornoExito = $this->session->flashdata('retornoExito');
if ($retornoExito) {
    ?>
	<div class="col-lg-12">	
		<div class="alert alert-success">
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
<p class="text-danger text-left">Fields with * are required.</p>	


<form  name="form" id="form" class="form-horizontal" method="post"  >
	<input type="hidden" id="hddIdentificador" name="hddIdentificador" value="<?php echo $information?$information[0]["id_job_confined"]:""; ?>"/>
	<input type="hidden" id="hddIdJob" name="hddIdJob" value="<?php echo $jobInfo[0]["id_job"]; ?>"/>

															
	<div class="row">
		<div class="col-lg-12">				
			<div class="panel panel-warning">
				<div class="panel-heading">
					<div class="row">
						<div class="col-sm-6">
							<strong>Location: *</strong> 
						</div>
					
<?php
/**
 * If it is an ADMIN user, show date 
 * @author BMOTTAG
 * @since  11/5/2017
 */
if($userRol==99){
?>				
<script>
	$( function() {
		$( "#date" ).datepicker({
			changeMonth: true,
			changeYear: true,
			dateFormat: 'yy-mm-dd'
		});
	});
</script>
						<div class="col-sm-6">
															
								<label class="col-sm-4 control-label" for="date">Date of Issue:</label>
								<div class="col-sm-5">
									<input type="text" class="form-control" id="date" name="date" value="<?php echo $information?$information[0]["date_confined"]:""; ?>" placeholder="Date of Issue" />
								</div>
							
						</div>
<?php } ?>					
					</div>
				</div>
				<div class="panel-body">
					<div class="form-group">
						<div class="col-sm-12">
						<textarea id="location" name="location" class="form-control" rows="2"><?php echo $information?$information[0]["location"]:""; ?></textarea>
						</div>
					</div>				
				</div>
			</div>
		</div>
	</div>
	
	<div class="row">
		<div class="col-lg-12">				
			<div class="panel panel-warning">
				<div class="panel-heading">
					<strong>Purpose of entry: *</strong>
				</div>
				<div class="panel-body">
					<div class="form-group">
						<div class="col-sm-12">
						<textarea id="purpose" name="purpose" class="form-control" rows="2"><?php echo $information?$information[0]["purpose"]:""; ?></textarea>
						</div>
					</div>				
				</div>
			</div>
		</div>
	</div>
	
<?php 

if($information)
{
	$inicio = $information[0]['scheduled_start'];
	$fechaInicio = substr($inicio, 0, 10); 
	$horaInicio = substr($inicio, 11, 2);
	$minutosInicio = substr($inicio, 14, 2);

	$fin = $information[0]['scheduled_finish'];
	$fechaFin = substr($fin, 0, 10); 
	$horaFin = substr($fin, 11, 2);
	$minutosFin = substr($fin, 14, 2);
}else{
	$inicio = '';
	$fechaInicio = '';
	$horaInicio = '';
	$minutosInicio = '';

	$fin = '';
	$fechaFin = '';
	$horaFin = '';
	$minutosFin = '';
}

?>

	<div class="row">
		<div class="col-lg-12">				
			<div class="panel panel-warning">
				<div class="panel-heading">
					<strong>Scheduled: *</strong>
				</div>
				<div class="panel-body">
					<div class="form-group">
						<div class="col-sm-4">
<script>
	$( function() {
		$( "#start_date" ).datepicker({
			changeMonth: true,
			changeYear: true,
			dateFormat: 'yy-mm-dd'
		});
	});
</script>
							<label class="control-label" for="start_date">Start date: *</label>
							<input type="text" class="form-control" id="start_date" name="start_date" value="<?php echo $fechaInicio; ?>" placeholder="Start date" required />
						</div>
						<div class="col-sm-4">
							<label for="type" class="control-label">Start hour: *</label>
							<select name="start_hour" id="start_hour" class="form-control" required>
								<option value='' >Select...</option>
								<?php
								for ($i = 0; $i < 24; $i++) {
									
									$i = $i<10?"0".$i:$i;
									?>
									<option value='<?php echo $i; ?>' <?php
									if ($information && $i == $horaInicio) {
										echo 'selected="selected"';
									}
									?>><?php echo $i; ?></option>
								<?php } ?>									
							</select>						
						</div>
						<div class="col-sm-4">
							<label for="type" class="control-label">Start minutes: *</label>
							<select name="start_min" id="start_min" class="form-control" required>
								<?php
								for ($xxx = 0; $xxx < 60; $xxx++) {
									
									$xxx = $xxx<10?"0".$xxx:$xxx;
								?>
									<option value='<?php echo $xxx; ?>' <?php
									if ($information && $xxx == $minutosInicio) {
										echo 'selected="selected"';
									}
									?>><?php echo $xxx; ?></option>
								<?php } ?>
							</select>												
						</div>
					</div>		

					<div class="form-group">
						<div class="col-sm-4">
<script>
	$( function() {
		$( "#finish_date" ).datepicker({
			changeMonth: true,
			changeYear: true,
			dateFormat: 'yy-mm-dd'
		});
	});
</script>
							<label class="control-label" for="finish_date">Finish date: *</label>
							<input type="text" class="form-control" id="finish_date" name="finish_date" value="<?php echo $fechaFin; ?>" placeholder="Start date" required />						
						</div>
						
						<div class="col-sm-4">
							<label for="type" class="control-label">Finish hour: *</label>
							<select name="finish_hour" id="finish_hour" class="form-control" required>
								<option value='' >Select...</option>
								<?php
								for ($i = 0; $i < 24; $i++) {
									
									$i = $i<10?"0".$i:$i;
									?>
									<option value='<?php echo $i; ?>' <?php
									if ($information && $i == $horaFin) {
										echo 'selected="selected"';
									}
									?>><?php echo $i; ?></option>
								<?php } ?>									
							</select>						
						</div>
						
						<div class="col-sm-4">
							<label for="type" class="control-label">Finish minutes: *</label>
							<select name="finish_min" id="finish_min" class="form-control" required>
								<?php
								for ($xxx = 0; $xxx < 60; $xxx++) {
									
									$xxx = $xxx<10?"0".$xxx:$xxx;
								?>
									<option value='<?php echo $xxx; ?>' <?php
									if ($information && $xxx == $minutosFin) {
										echo 'selected="selected"';
									}
									?>><?php echo $xxx; ?></option>
								<?php } ?>
							</select>						
						</div>
					</div>
				</div>
			</div>
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

								

								
						<div class="form-group">
							<div class="row" align="center">
								<div style="width:80%;" align="center">
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
							</div>
						</div>								

	
</form>

</div>
<!-- /#page-wrapper -->

<!--INICIO Modal para adicionar WORKER -->
<div class="modal fade text-center" id="modalWorker" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">    
	<div class="modal-dialog" role="document">
		<div class="modal-content" id="tablaDatos">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
				<h4 class="modal-title" id="exampleModalLabel">ADD WORKER</h4>
			</div>

			<div class="modal-body">
				<form name="formHazard" id="formHazard" role="form" method="post" action="<?php echo base_url("jobs/tool_box_One_Worker") ?>" >
					<input type="hidden" id="hddIdJob" name="hddIdJob" value="<?php echo $jobInfo[0]["id_job"]; ?>"/>
					<input type="hidden" id="hddIdToolBox" name="hddIdToolBox" value="<?php echo $information[0]["id_tool_box"]; ?>"/>

					<div class="form-group text-left">
						<label class="control-label" for="worker">Worker</label>
						<select name="worker" id="worker" class="form-control" required>
							<option value=''>Select...</option>
							<?php for ($i = 0; $i < count($workersList); $i++) { ?>
								<option value="<?php echo $workersList[$i]["id_user"]; ?>" ><?php echo $workersList[$i]["first_name"] . ' ' . $workersList[$i]["last_name"]; ?></option>	
							<?php } ?>
						</select>
					</div>
					
					<div class="form-group">
						<div class="row" align="center">
							<div style="width:50%;" align="center">
								<input type="submit" id="btnSubmitWorker" name="btnSubmitWorker" value="Save" class="btn btn-primary"/>
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

		</div>
	</div>
</div>                       
<!--FIN Modal para adicionar WORKER -->