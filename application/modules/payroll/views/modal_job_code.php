<script type="text/javascript" src="<?php echo base_url("assets/js/validate/payroll/info_by_day.js"); ?>"></script>

<div class="modal-header">
	<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
	<h4 class="modal-title" id="exampleModalLabel">EDIT PAYROLL RECORDS HOURS</h4>
	<p>Total Works Hours: <?php echo date("H:i", strtotime($information["working_hours_new"])); ?></p>
</div>

<div class="modal-body">
	<form name="formWorker" id="formWorker" role="form" method="post">
		<input type="hidden" id="hddIdentificador" name="hddIdentificador" value="<?php echo $information["id_task"]; ?>" />
		<input type="hidden" id="workHours" name="workHours" value="<?php echo $information["working_hours_new"]; ?>" />

		<?php
		$inicio = $information['start'];
		$fechaInicio = substr($inicio, 0, 10);
		$horaInicio = $hours_start['horas'];
		$minutosInicio = $hours_start['minutos'];

		$fin = $information['finish'];
		$fechaFin = substr($fin, 0, 10);
		$horaFin = $hours_end['horas'];
		$minutosFin = $hours_end['minutos'];

		?>
		<div class="row">
			<div class="col-sm-4">
				<div class="form-group text-left">
					<label class="control-label" for="jobName">Job Code/Name - Start</label>
					<select name="jobName" id="jobName" class="form-control js-example-basic-single">
						<option value=''>Select...</option>
						<?php for ($i = 0; $i < count($jobs); $i++) { ?>
							<option value="<?php echo $jobs[$i]["id_job"]; ?>" <?php if ($information && $information["fk_id_job"] == $jobs[$i]["id_job"]) {
																					echo "selected";
																				}  ?>><?php echo $jobs[$i]["job_description"]; ?></option>
						<?php } ?>
					</select>
				</div>
			</div>

			<div class="col-sm-4">
				<div class="form-group text-left">
					<label for="type" class="control-label">Start hour: *</label>
					<select name="start_hour" id="start_hour" class="form-control" required>
						<option value=''>Select...</option>
						<?php
						for ($i = 0; $i < 24; $i++) {

							$i = $i < 10 ? "0" . $i : $i;
						?>
							<option value='<?php echo $i; ?>' <?php
																if ($information && $i == $horaInicio) {
																	echo 'selected="selected"';
																}
																?>><?php echo $i; ?></option>
						<?php } ?>
					</select>
				</div>
			</div>

			<div class="col-sm-4">
				<div class="form-group text-left">
					<label for="type" class="control-label">Start minutes: *</label>
					<select name="start_min" id="start_min" class="form-control" required>
						<?php
						for ($xxx = 0; $xxx < 60; $xxx++) {

							$xxx = $xxx < 10 ? "0" . $xxx : $xxx;
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
		</div>

		<div class="row">
			<div class="col-sm-4">
				<div class="form-group text-left">
					<label class="control-label" for="jobNameFinish">Job Code/Name - End</label>
					<select name="jobNameFinish" id="jobNameFinish" class="form-control js-example-basic-single">
						<option value=''>Select...</option>
						<?php for ($i = 0; $i < count($jobs); $i++) { ?>
							<option value="<?php echo $jobs[$i]["id_job"]; ?>" <?php if ($information && $information["fk_id_job_finish"] == $jobs[$i]["id_job"]) {
																					echo "selected";
																				}  ?>><?php echo $jobs[$i]["job_description"]; ?></option>
						<?php } ?>
					</select>
				</div>
			</div>

			<div class="col-sm-4">
				<div class="form-group text-left">
					<label for="type" class="control-label">Finish hour: *</label>
					<select name="finish_hour" id="finish_hour" class="form-control" required>
						<option value=''>Select...</option>
						<?php
						for ($i = 0; $i < 24; $i++) {

							$i = $i < 10 ? "0" . $i : $i;
						?>
							<option value='<?php echo $i; ?>' <?php
																if ($information && $i == $horaFin) {
																	echo 'selected="selected"';
																}
																?>><?php echo $i; ?></option>
						<?php } ?>
					</select>
				</div>
			</div>

			<div class="col-sm-4">
				<div class="form-group text-left">
					<label for="type" class="control-label">Finish minutes: *</label>
					<select name="finish_min" id="finish_min" class="form-control" required>
						<?php
						for ($xxx = 0; $xxx < 60; $xxx++) {

							$xxx = $xxx < 10 ? "0" . $xxx : $xxx;
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
		<div class="form-group">
			<button type="button" id="btnSubmit" name="btnSubmit" class="btn btn-primary">
				Save <span class="glyphicon glyphicon-floppy-disk" aria-hidden="true">
			</button>
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