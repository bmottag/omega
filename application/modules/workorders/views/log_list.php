<script type="text/javascript" src="<?php echo base_url("assets/js/validate/workorder/update_state.js"); ?>"></script>
<div id="page-wrapper">
	<br>

	<div class="row">

		<form name="formState" id="formState" class="form-horizontal" method="post">

			<?php
			/**
			 * Estado work order
			 * Solo se puede editar por los siguientes ROLES
			 * SUPER ADMIN, MANAGEMENT, ACCOUNTING
			 */
			$userRol = $this->session->userdata("rol");
			$deshabilitar = 'disabled';
			if ($userRol == ID_ROL_SUPER_ADMIN || $userRol == 2 || $userRol == 3) {
				$deshabilitar = '';
			}
			?>

			<?php if (!$deshabilitar) { ?>
				<a href="javascript:seleccionar_todo()">Check all</a> |
				<a href="javascript:deseleccionar_todo()">Uncheck all</a>
			<?php } ?>

			<div class="col-lg-12">
				<div class="panel panel-primary">
					<div class="panel-heading">
						<a class="btn btn-info btn-xs" href=" <?php echo base_url('workorders/log'); ?> "><span class="glyphicon glyphicon glyphicon-chevron-left" aria-hidden="true"></span> Back to Search W.O.</a>
						<i class="fa fa-money"></i> <strong>WORK ORDERS</strong>
					</div>
					<div class="panel-body">

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
						if (!$workOrderInfo) {
							echo "<a href='#' class='btn btn-danger btn-block'>No data was found matching your criteria</a>";
						} else {
						?>
							<table width="100%" class="table table-striped table-bordered table-hover" id="dataTables">
								<thead>
									<tr>
										<th class='text-center'>W.O. #</th>
										<th class='text-center'>Job Name</th>
										<th class='text-center'>Responsible</th>
										<th class='text-center'>Date</th>
										<th class='text-center'>Action</th>
										<th class='text-center'>Table</th>
										<th class='text-center'>Description</th>
									</tr>
								</thead>
								<tbody>
									<?php
									foreach ($workOrderInfo as $lista) :
										$old = (json_decode($lista['comment'])->old != '') ? json_encode(json_decode($lista['comment'])->old[0]) : 'null';
										$new = (json_decode($lista['comment'])->new != '') ? json_decode($lista['comment'])->new : 'null';

										echo "<tr>";
										echo "<td class='text-center'>";
										echo "<a href='" . base_url('workorders/add_workorder/' . $lista['type_id']) . "'>" . $lista['type_id'] . "</a>";
										echo "</td>";
										echo "<td>" . $lista['job_description'] . "</td>";
										echo "<td>" . $lista['name'] . "</td>";
										echo "<td>" . $lista['created_on'] . "</td>";
										echo "<td class='text-center'>" . $lista['token'] . "</td>";
										echo "<td class='text-center'>" . $lista['type'] . "</td>";
										echo "<td class='text-center'> Old: " . $old . "<br> New: " . $new . "</td>";
										echo '</tr>';
									endforeach;
									?>
								</tbody>
							</table>

						<?php } ?>

					</div>
					<!-- /.panel-body -->
				</div>
				<!-- /.panel -->
			</div>
			<!-- /.col-lg-12 -->
		</form>

	</div>
	<!-- /.row -->
</div>
<!-- /#page-wrapper -->

<!-- Tables -->
<script>
	$(document).ready(function() {
		$('#dataTables').DataTable({
			responsive: true,
			"ordering": false,
			paging: false,
			"info": false,
			"searching": false
		});
	});
</script>