<div id="page-wrapper">
	<br>
	<div class="row">
		<div class="col-md-12">
			<div class="panel panel-primary">
				<div class="panel-heading">
					<h4 class="list-group-item-heading">
					<i class="fa fa-money fa-fw"></i>	WORK ORDERS
					</h4>
				</div>
			</div>
		</div>
		<!-- /.col-lg-12 -->				
	</div>
	
	<!-- /.row -->
	<div class="row">
		<div class="col-lg-12">
			<div class="panel panel-default">
				<div class="panel-heading">
					<i class="fa fa-money"></i> WORK ORDERS
				</div>
				<div class="panel-body">
					
					<a class='btn btn-success btn-block' href='<?php echo base_url('workorders/add_workorder/') ?>'>
							<span class="glyphicon glyphicon-edit" aria-hidden="true"> </span>  Add a Work Order
					</a>
					
					<br>
				<?php
					if($workOrderInfo){
				?>
					<table width="100%" class="table table-striped table-bordered table-hover" id="dataTables">
						<thead>
							<tr>
								<th>Work Order #</th>
								<th>Job Code/Name</th>
								<th>Supervisor</th>
								<th>Date of Issue</th>
								<th>Date work order</th>
								<th>Observation</th>
								<th>Edit</th>
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
									echo "<td class='text-center'>" . $lista['id_workorder'];
									echo '<p class="' . $clase . '"><i class="fa ' . $icono . ' fa-fw"></i>' . $valor . '</p>';
									echo "</td>";
									echo "<td>" . $lista['job_description'] . "</td>";
									echo "<td>" . $lista['name'] . "</td>";
									echo "<td class='text-center'>" . $lista['date_issue'] . "</td>";
									echo "<td class='text-center'>" . $lista['date'] . "</td>";
									echo "<td>" . $lista['observation'] . "</td>";
									echo "<td class='text-center'>";									
						?>
									<a class='btn btn-success btn-xs' href='<?php echo base_url('workorders/add_workorder/' . $lista['id_workorder']) ?>'>
											Edit <span class="glyphicon glyphicon-edit" aria-hidden="true">
									</a>								
						<?php
									echo "</td>";
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
			"searching": false,
			"info": false
        });
    });
    </script>