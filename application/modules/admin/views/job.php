<script>
	$(function() {
		$(".btn-outline").click(function() {
			var oID = $(this).attr("id");
			$.ajax({
				type: 'POST',
				url: base_url + '/admin/cargarModalJob',
				data: {
					'idJob': oID
				},
				cache: false,
				success: function(data) {
					$('#tablaDatos').html(data);
				}
			});
		});
	});

	function seleccionar_todo() {
		for (i = 0; i < document.jobs_state.elements.length; i++)
			if (document.jobs_state.elements[i].type == "checkbox")
				document.jobs_state.elements[i].checked = 1
	}


	function deseleccionar_todo() {
		for (i = 0; i < document.jobs_state.elements.length; i++)
			if (document.jobs_state.elements[i].type == "checkbox")
				document.jobs_state.elements[i].checked = 0
	}
</script>

<script>
	$(document).ready(function() {
		$('#modal').on('shown.bs.modal', function() {
			if ($.fn.select2 && $('#company').hasClass("select2-hidden-accessible")) {
				$('#company').select2('destroy');
			}
			$('#company').select2({
				dropdownParent: $('#modal')
			});
		});
	});
</script>

<div id="page-wrapper">
	<br>

	<div class="row">
		<div class="col-lg-12">
			<div class="panel panel-primary">
				<div class="panel-heading" style="display: flex; justify-content: space-between; align-items: center;">
					<div>
						<i class="fa fa-briefcase"></i> SETTINGS - JOB CODE/NAME LIST
					</div>
					<div>
						<a href="<?php echo base_url("admin/job/log"); ?>" class="btn btn-outline btn-primary btn-block" style="background-color: #5067f0; color: #ffffff;">
							<i class="fa fa-briefcase"></i> LOGS
						</a>
					</div>
				</div>

				<div class="panel-body">

					<ul class="nav nav-pills">
						<li <?php if ($state == 1) {
								echo "class='active'";
							} ?>><a href="<?php echo base_url("admin/job/1"); ?>">List of active Job Code/Name</a>
						</li>
						<li <?php if ($state == 2) {
								echo "class='active'";
							} ?>><a href="<?php echo base_url("admin/job/2"); ?>">List of inactive Job Code/Name</a>
						</li>
					</ul>
					<br>

					<button type="button" class="btn btn-outline btn-primary btn-block" data-toggle="modal" data-target="#modal" id="x">
						<span class="glyphicon glyphicon-plus" aria-hidden="true"></span> Add a Job Code/Name
					</button><br>

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
					<?php
					if ($info) {
					?>

						<form name="jobs_state" id="jobs_state" method="post" action="<?php echo base_url("admin/jobs_state/$state"); ?>">


							<a href="javascript:seleccionar_todo()">Check all</a> |
							<a href="javascript:deseleccionar_todo()">Uncheck all</a>



							<table width="100%" class="table table-striped table-bordered table-hover small" id="dataTables">
								<thead>
									<tr>
										<th class="text-center" width="25%">Job Code/Name</th>
										<th class="text-center" width="20%">Company</th>
										<th class="text-center" width="5%">Markup (%)</th>
										<th class="text-center" width="5%">Profit (%)</th>
										<th class="text-center" width="30%">Notes</th>
										<th class="text-center" width="5%">Automatic Planning Message</th>
										<th class="text-center" width="5%">Status

											<button type="submit" class="btn btn-primary btn-xs" id="btnSubmit2" name="btnSubmit2">
												Update Status <span class="glyphicon glyphicon-edit" aria-hidden="true">
											</button>

										</th>
										<th class="text-center" width="5%">Links</th>
									</tr>
								</thead>
								<tbody>
									<?php
									foreach ($info as $lista):
										echo "<tr>";
										echo "<td>" . $lista['job_description'] . "</td>";
										echo "<td>" . $lista['company_name'] . "</td>";
										echo "<td class='text-center'>" . $lista['markup'] . " %</td>";
										echo "<td class='text-center'>" . $lista['profit'] . " %</td>";
										echo "<td >" . $lista['notes'] . "</td>";
										echo "<td class='text-center'>";
										switch ($lista['planning_message']) {
											case 1:
												$valor = 'Yes';
												$clase = "text-success";
												break;
											case 2:
												$valor = 'No';
												$clase = "text-danger";
												break;
										}
										echo '<p class="' . $clase . '"><strong>' . $valor . '</strong></p>';
										echo "</td>";
										echo "<td class='text-center'>";
										switch ($lista['state']) {
											case 1:
												$valor = 'Active';
												$clase = "text-success";
												$estado = TRUE;
												break;
											case 2:
												$valor = 'Inactive';
												$clase = "text-danger";
												$estado = FALSE;
												break;
										}
										echo '<p class="' . $clase . '"><strong>' . $valor . '</strong>';


										$data = array(
											'name' => 'job[]',
											'id' => 'job',
											'value' => $lista['id_job'],
											'checked' => $estado,
											'style' => 'margin:10px'
										);
										echo form_checkbox($data);

										echo '</p>';

										echo "</td>";
										echo "<td class='text-center'>";
									?>
										<button type="button" class="btn btn-outline btn-primary btn-xs" data-toggle="modal" data-target="#modal" id="<?php echo $lista['id_job']; ?>">
											Edit <span class="glyphicon glyphicon-edit" aria-hidden="true">
										</button>

										<div class="pull-right">
											<div class="btn-group">
												<button type="button" class="btn btn-default btn-xs dropdown-toggle" data-toggle="dropdown">
													Actions
													<span class="caret"></span>
												</button>

												<ul class="dropdown-menu pull-right" role="menu">
													<?php
													$userRol = 99; //$this->session->userdata("rol");
													if ($userRol == ID_ROL_SUPER_ADMIN || $userRol == ID_ROL_ENGINEER) {
													?>
														<li>
															<a href='<?php echo base_url('prices/employeeTypeUnitPrice/' . $lista['id_job']) ?>'>
																<i class="fa fa-flag fa-fw"></i> Employee Type
															</a>
														</li>
														<li>
															<a href='<?php echo base_url('prices/equipmentUnitPrice/' . $lista['id_job'] . '/1') ?>'>
																<i class="fa fa-flag fa-fw"></i> Equipment
															</a>
														</li>
													<?php } ?>
													<li>
														<a href='<?php echo base_url('admin/job_qr_code/' . $lista['id_job'] . '/1') ?>'>
															<i class="fa fa-qrcode fa-fw"></i> Timesheet QR CODE
														</a>
													</li>
												</ul>
											</div>
										</div>

									<?php
										echo "</td>";
									endforeach;
									?>
								</tbody>
							</table>

						</form>

					<?php } ?>
				</div>
			</div>
		</div>
	</div>
</div>


<!--INICIO Modal para adicionar -->
<div class="modal fade text-center" id="modal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
	<div class="modal-dialog" role="document">
		<div class="modal-content" id="tablaDatos">

		</div>
	</div>
</div>
<!--FIN Modal para adicionar -->

<!-- Tables -->
<script>
	$(document).ready(function() {
		$('#dataTables').DataTable({
			responsive: true,
			"ordering": false,
			paging: false,
			"searching": true
		});
	});
</script>