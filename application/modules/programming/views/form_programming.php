<script type="text/javascript" src="<?php echo base_url("assets/js/validate/programming/programming.js"); ?>"></script>

<link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>

<div id="page-wrapper">
	<br>
	
	<!-- /.row -->
	<div class="row">
		<div class="col-lg-12">
			<div class="panel panel-default">
				<div class="panel-heading">
					<i class="fa fa-book"></i> PROGRAMMING
				</div>
				<div class="panel-body">

					<form  name="form" id="form" class="form-horizontal" method="post" >
						<input type="hidden" id="hddId" name="hddId" value="<?php echo $information?$information[0]["id_programming"]:""; ?>"/>
																					
						<div class="alert alert-info">
							<strong>Info:</strong> Form to add or update a programming.
						</div>
												
<script>
	$( function() {
		$( "#date" ).datepicker({
			changeMonth: true,
			changeYear: true,
			dateFormat: 'yy-mm-dd',
			minDate: '0'
		});
	});
</script>
						<div class="form-group">									
							<label class="col-sm-4 control-label" for="date">Date</label>
							<div class="col-sm-5">
								<input type="text" class="form-control" id="date" name="date" value="<?php echo $information?$information[0]["date_programming"]:""; ?>" placeholder="Date" />
							</div>
						</div>			
												
						<div class="form-group">
							<label class="col-sm-4 control-label" for="jobName">Job Code/Name</label>
							<div class="col-sm-5">
								<select name="jobName" id="jobName" class="form-control" >
									<option value=''>Select...</option>
									<?php for ($i = 0; $i < count($jobs); $i++) { ?>
										<option value="<?php echo $jobs[$i]["id_job"]; ?>" <?php if($information[0]["fk_id_job"] == $jobs[$i]["id_job"]) { echo "selected"; }  ?>><?php echo $jobs[$i]["job_description"]; ?></option>	
									<?php } ?>
								</select>
							</div>
						</div>
						
						<div class="form-group">
							<label class="col-sm-4 control-label" for="fromSite">Time In</label>
							<div class="col-sm-2">
							<?php 
								if($information){
									$timeIn = explode(":",$information[0]["hour_programming"]);
									$hourIn = $timeIn[0];
									$minIn = $timeIn[1];
								}
							?>
								<select name="hourIn" id="hourIn" class="form-control" required>
									<option value='' >Select...</option>
									<?php
									for ($i = 0; $i < 24; $i++) {
										?>
										<option value='<?php echo $i; ?>' <?php
										if ($information && $i == $hourIn) {
											echo 'selected="selected"';
										}
										?>><?php echo $i; ?></option>
											<?php } ?>									
								</select>
							</div>
							<div class="col-sm-2">
								<select name="minIn" id="minIn" class="form-control" required>
									<option value="00" <?php if($information && $minIn == "00") { echo "selected"; }  ?>>00</option>
									<option value="15" <?php if($information && $minIn == "15") { echo "selected"; }  ?>>15</option>
									<option value="30" <?php if($information && $minIn == "30") { echo "selected"; }  ?>>30</option>
									<option value="45" <?php if($information && $minIn == "45") { echo "selected"; }  ?>>45</option>
								</select>
							</div>
						</div>
												
						<div class="form-group">
							<label class="col-sm-4 control-label" for="observation">Observation</label>
							<div class="col-sm-5">
							<textarea id="observation" name="observation" class="form-control" rows="3"><?php echo $information?$information[0]["observation"]:""; ?></textarea>
							</div>
						</div>
								
						<div class="form-group">
							<div class="row" align="center">
								<div style="width:100%;" align="center">
<button type="button" id="btnSubmit" name="btnSubmit" class='btn btn-primary'>
		Submit <span class="glyphicon glyphicon-floppy-disk" aria-hidden="true">
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