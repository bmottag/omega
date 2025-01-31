<script>
	$(function() {
		$(".btn-outline").click(function() {
			var oID = $(this).attr("id");
			$.ajax({
				type: 'POST',
				url: base_url + '/admin/cargarModalNotification',
				data: {
					'idNotificationAccess': oID
				},
				cache: false,
				success: function(data) {
					$('#tablaDatos').html(data);
				}
			});
		});
	});
</script>

<div id="page-wrapper">
	<br>

	<div class="row">
		<div class="col-lg-12">
			<div class="panel panel-primary">
				<div class="panel-heading">
					<i class="glyphicon glyphicon-send"></i> SETTINGS - NOTIFICATIONS ACCESS LIST
				</div>
				<div class="panel-body">
					<button type="button" class="btn btn-outline btn-primary btn-block" data-toggle="modal" data-target="#modal" id="x">
						<span class="glyphicon glyphicon-plus" aria-hidden="true"></span> Add a Notification Access
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
						<table width="100%" class="table table-striped table-bordered table-hover" id="dataTables">
							<thead>
								<tr>
									<th class="text-center">Notification</th>
									<th class="text-center">Description</th>
									<th class="text-center">Send Email To</th>
									<th class="text-center">Send SMS To</th>
									<th class="text-center">Edit</th>
								</tr>
							</thead>
							<tbody>
								<?php
								foreach ($info as $lista):
									echo "<tr>";
									echo "<td>" . $lista['notification'] . "</td>";
									echo "<td><small>" . $lista['description'] . "</small></td>";
									echo "<td>" . $lista['name_email'] . "</br><b>" . $lista['email']  . "</b></td>";
									echo "<td>" . $lista['name_sms'] . "</br><b>" . chunk_split($lista['movil'], 3, " ") . "</b></td>";
									echo "<td class='text-center'>";
								?>
									<button type="button" class="btn btn-outline btn-primary btn-xs" data-toggle="modal" data-target="#modal" id="<?php echo $lista['id_notification_access']; ?>">
										<span class="glyphicon glyphicon-edit" aria-hidden="true"></span>
									</button>
								<?php
									echo "</td>";
								endforeach;
								?>
							</tbody>
						</table>
					<?php } ?>
				</div>
			</div>
		</div>
	</div>
</div>


<!--INICIO Modal para adicionar HAZARDS -->
<div class="modal fade text-center" id="modal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
	<div class="modal-dialog" role="document">
		<div class="modal-content" id="tablaDatos">

		</div>
	</div>
</div>
<!--FIN Modal para adicionar HAZARDS -->

<!-- Tables -->
<script>
	$(document).ready(function() {
		$('#dataTables').DataTable({
			responsive: true,
			"pageLength": 100
		});
	});
</script>