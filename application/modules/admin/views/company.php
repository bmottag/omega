<script>
	$(function() {
		$(".btn-outline").click(function() {
			var oID = $(this).attr("id");
			$.ajax({
				type: 'POST',
				url: base_url + '/admin/cargarModalCompany',
				data: {
					'idCompany': oID
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
					<i class="fa fa-suitcase"></i> SETTINGS - COMPANY LIST
				</div>
				<div class="panel-body">
					<button type="button" class="btn btn-outline btn-primary btn-block" data-toggle="modal" data-target="#modal" id="x">
						<span class="glyphicon glyphicon-plus" aria-hidden="true"></span> Add a Company
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
									<th class="text-center">Company</th>
									<th class="text-center">Contact</th>
									<th class="text-center">Movil</th>
									<th class="text-center">Email</th>
									<th class="text-center">Does hauling?</th>
									<th class="text-center">Edit</th>
								</tr>
							</thead>
							<tbody>
								<?php
								foreach ($info as $lista):
									echo "<tr>";
									echo "<td>" . $lista['company_name'] . "</td>";
									echo "<td>" . $lista['contact'] . "</td>";
									$movil = $lista["movil_number"];
									// Separa en grupos de tres 
									$count = strlen($movil);

									$num_tlf1 = substr($movil, 0, 3);
									$num_tlf2 = substr($movil, 3, 3);
									$num_tlf3 = substr($movil, 6, 2);
									$num_tlf4 = substr($movil, -2);

									if ($count == 10) {
										$resultado = "$num_tlf1 $num_tlf2 $num_tlf3 $num_tlf4";
									} else {

										$resultado = chunk_split($movil, 3, " ");
									}

									echo "<td class='text-center'>" . $resultado . "</td>";
									echo "<td>" . $lista['email'] . "</td>";
									if ($lista['does_hauling'] == 2) {
										$does_hauling = "No";
									} else {
										$does_hauling = "Yes";
									}
									echo "<td class='text-center'>" . $does_hauling . "</td>";
									echo "<td class='text-center'>";
								?>
									<button type="button" class="btn btn-outline btn-primary btn-xs" data-toggle="modal" data-target="#modal" id="<?php echo $lista['id_company']; ?>">
										Edit <span class="glyphicon glyphicon-edit" aria-hidden="true">
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