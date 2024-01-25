<div id="page-wrapper">
	<br>
	<?php
	if (!$info) {
	?>
		<div class="row">
			<div class="col-lg-12">
				<div class="panel panel-warning">
					<div class="panel-heading">
						<a class="btn btn-warning btn-xs" href=" <?php echo base_url() . 'payroll/payrollSearchTimeSheet'; ?> "><span class="glyphicon glyphicon glyphicon-chevron-left" aria-hidden="true"></span> Go back </a>
						<i class="fa fa-clock-o fa-fw"></i> <b>PAYROLL REPORT - DAILY TIME SHEET </b>
						<br><b>Daterange: </b> <?php echo $from . '-' . $to; ?>
					</div>

					<div class="panel-body">
						<div class="alert alert-warning">
							No data was found matching your criteria.
						</div>
					</div>
				</div>
			</div>
		</div>
		<?php
	} else {

		foreach ($info as $lista) :
			$arrParam = array("idUser" => $lista['fk_id_user']);
			$infoUser = $this->general_model->get_user($arrParam);
			$employeeName = $infoUser[0]["first_name"] . ' ' . $infoUser[0]["last_name"];
			//buscar por usuario y por periodo las horas de cada semana
			$arrParam = array(
				"idUser" => $lista['fk_id_user'],
				"from" => $from,
				"to" => $to
			);
			$infoPayrollUser = $this->general_model->get_task_by_period($arrParam);
		?>
			<div class="row">
				<div class="col-lg-12">
					<div class="panel panel-warning">
						<div class="panel-heading">
							<div class="row">
								<div class="col-lg-12">
									<a class="btn btn-warning btn-xs" href=" <?php echo base_url() . 'payroll/payrollSearchTimeSheet'; ?> "><span class="glyphicon glyphicon glyphicon-chevron-left" aria-hidden="true"></span> Go back </a>
									<i class="fa fa-clock-o fa-fw"></i> <b>PAYROLL REPORT - DAILY TIME SHEET</b>
									<br><b>Daterange: </b> <?php echo $from . '-' . $to; ?>
								</div>
							</div>
						</div>

						<div class="panel-body">
							<div class="alert alert-default">
								<h2><i class="fa fa-user"></i> <b>Employee: </b> <?php echo $employeeName; ?></h2>
							</div>
							<table width="100%" class="table table-hover" id="dataTables">
								<thead>
									<tr>
										<th class='text-left'><small>Date & Time</small></th>
										<th class='text-left'><small>Job</small></th>
										<th class='text-left'><small>Address</small></th>
										<th class='text-left'><small>Task Description</small></th>
										<th class='text-left'><small>Observation</small></th>
										<th class='text-right'><small>Working Hours</small></th>
										<th class='text-right'><small>Regular Hours</small></th>
										<th class='text-right'><small>Overtime Hours</small></th>
									</tr>
								</thead>
								<tbody>
									<?php
									$totalHours = 0;
									if ($infoPayrollUser) {
										$totalRegular = 0;
										$totalOvertime = 0;
										$totalRegularWeek = 0;
										$weeklyOvertime = 0;
										foreach ($infoPayrollUser as $lista) :
											echo "<tr>";
											echo "<td><small><strong>Start:</strong><br>" . $lista['start'] . "<br><strong>Finish:</strong><br>" . $lista['finish'] . "</small><br>";
									?>
											<a href="<?php echo base_url("report/botonEditHour/" . $lista['id_task']); ?>" class="btn btn-info btn-xs">
												Edit Hours <span class="glyphicon glyphicon-edit" aria-hidden="true">
											</a>
									<?php
											echo "</td>";
											echo "<td><small><strong>Start:</strong><br>" . $lista['job_start'] . "<br><strong>Finish:</strong><br>" . $lista['job_finish'] . "</small></td>";
											echo "<td><small><strong>Start:</strong><br>" . $lista['address_start'] . "<br><strong>Finish:</strong><br>" . $lista['address_finish'] . "</small></td>";
											echo "<td class='text-left'><small>" . $lista['task_description'] . "</small></td>";
											echo "<td class='text-left'><small>" . $lista['observation'] . "</small></td>";
											echo "<td class='text-right'><small>" . substr($lista['working_hours_new'], 0, 5) . "</small></td>";
											echo "<td class='text-right'><small>" . $lista['regular_hours'] . "</small></td>";
											echo "<td class='text-right'><small>" . $lista['overtime_hours'] . "</small></td>";
											echo "</tr>";
											$totalHours = $lista['working_hours'] + $totalHours;
											$totalRegular = $lista['regular_hours'] + $totalRegular;
											$totalOvertime = $lista['overtime_hours'] + $totalOvertime;
										endforeach;
										echo "<tr>";
										echo "<td class='text-right' colspan='6'><small><strong>Total weekly hours:<br>" . $totalHours . "</strong></small></td>";
										echo "<td class='text-right'><small><strong>Total daily  regular hours per week:<br>" . $totalRegular . "</strong></small></td>";
										echo "<td class='text-right'><small><strong>Total daily overtime per week:<br>" . $totalOvertime . "</strong></small></td>";
										echo "</tr>";
									}
									?>
								</tbody>
							</table>
						</div>
					</div>
				</div>
			</div>
	<?php
		endforeach;
	}
	?>
</div>

<!-- Tables -->
<script>
	$(document).ready(function() {
		$('#dataTables').DataTable({
			responsive: true,
			"ordering": false,
			paging: false,
			"searching": false
		});
	});
</script>