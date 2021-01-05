<div id="page-wrapper">
	<br>
	
	<!-- /.row -->
	<div class="row">
		<div class="col-lg-12">
			<div class="panel panel-primary">
				<div class="panel-heading">
					<i class="fa fa-money"></i> <strong>WORK ORDERS</strong>
				</div>
				<div class="panel-body">

				<?php
					if(!$workOrderInfo){ 
						echo "<a href='#' class='btn btn-danger btn-block'>No data was found matching your criteria</a>";
					}else{
				?>	
					<table width="100%" class="table table-striped table-bordered table-hover" id="dataTables">
						<thead>
							<tr>
								<th class='text-center'>W.O. #</th>
								<th class='text-center'>Job Code/Name</th>
								<th class='text-center'>Supervisor</th>
								<th class='text-center'>Date of Issue</th>
								<th class='text-center'>Date W.O.</th>
								<th class='text-center'>Task Description</th>
							</tr>
						</thead>
						<tbody>							
						<?php
							foreach ($workOrderInfo as $lista):
							
									switch ($lista['state']) {
											case 0:
													$valor = 'On field';
													$clase = "text-danger";
													$icono = "fa-thumb-tack";
													break;
											case 1:
													$valor = 'In Progress';
													$clase = "text-warning";
													$icono = "fa-refresh";
													break;
											case 2:
													$valor = 'Revised';
													$clase = "text-primary";
													$icono = "fa-check";
													break;
											case 3:
													$valor = 'Send to the client';
													$clase = "text-success";
													$icono = "fa-envelope-o";
													break;
											case 4:
													$valor = 'Closed';
													$clase = "text-danger";
													$icono = "fa-power-off";
													break;
									}
							
									echo "<tr>";

									echo "<td class='text-center'>";
									echo "<a href='" . base_url('workorders/add_workorder/' . $lista['id_workorder']) . "'>" . $lista['id_workorder'];
									echo '<p class="' . $clase . '"><i class="fa ' . $icono . ' fa-fw"></i>' . $valor . '</p>';
									echo "<strong>Last Message:</strong><br>" . $lista['last_message'];
									echo "</a></td>";

									echo "<td>" . $lista['job_description'] . "</td>";
									echo "<td>" . $lista['name'] . "</td>";
									echo "<td class='text-center'>" . $lista['date_issue'] . "</td>";
									echo "<td class='text-center'>" . $lista['date'] . "</td>";
									echo "<td>" . $lista['observation'] . "</td>";
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