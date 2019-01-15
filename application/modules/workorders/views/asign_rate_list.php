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
								<th>Work Order #</th>
								<th>Job Code/Name</th>
								<th>Supervisor</th>
								<th>Date of Issue</th>
								<th>Date work order</th>
								<th>Observation</th>
								<th>Links</th>
							</tr>
						</thead>
						<tbody>							
						<?php
							foreach ($workOrderInfo as $lista):
									echo "<tr>";
									echo "<td class='text-center'>" . $lista['id_workorder'] . "</td>";
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
									
									<a class='btn btn-warning btn-xs' href='<?php echo base_url('workorders/view_workorder/' . $lista['id_workorder']) ?>'>
											Asign Rate <span class="glyphicon glyphicon-usd" aria-hidden="true">
									</a>


									<a class='btn btn-purpura btn-xs' target="_blank" href='<?php echo base_url('workorders/generaWorkOrderPDF/' . $lista['id_workorder']) ?>'>
											Download invoice <span class="glyphicon glyphicon-cloud-download" aria-hidden="true">
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