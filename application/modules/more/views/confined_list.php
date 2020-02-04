<div id="page-wrapper">
	<br>

	<!-- /.row -->
	<div class="row">
		<div class="col-lg-12">
			<div class="panel panel-warning">
				<div class="panel-heading">
					<a class="btn btn-warning btn-xs" href=" <?php echo base_url().'jobs'; ?> "><span class="glyphicon glyphicon glyphicon-chevron-left" aria-hidden="true"></span> Go back </a> 
					<i class="fa fa-database"></i> <strong>CONFINED SPACE ENTRY PERMIT</strong>
				</div>
				<div class="panel-body">
				
					<div class="alert alert-warning">
						<strong>Job Code/Name: </strong><?php echo $jobInfo[0]['job_description']; ?>
					</div>					
				
					<a class='btn btn-outline btn-warning btn-block' href='<?php echo base_url('more/add_confined/' . $jobInfo[0]['id_job']) ?>'>
							<span class="glyphicon glyphicon-edit" aria-hidden="true"> </span>  Add a Confined Space Entry Permit
					</a>
					
					<br>
				<?php
					if($information){
				?>
					<table width="100%" class="table table-striped table-bordered table-hover" id="dataTables">
						<thead>
							<tr>
								<th>#</th>
								<th>Reported by</th>
								<th>Date</th>
								<th>Location</th>
								<th>Purpose of entry</th>
								<th>Edit</th>
							</tr>
						</thead>
						<tbody>							
						<?php
							foreach ($information as $lista):
									echo "<tr>";
									echo "<td class='text-center'>" . $lista['id_job_confined'] . "</td>";
									echo "<td>" . $lista['name'] . "</td>";
									echo "<td class='text-center'>" . $lista['date_confined'] . "</td>";
									echo "<td>" . $lista['location'] . "</td>";
									echo "<td>" . $lista['purpose'] . "</td>";
									
									echo "<td class='text-center'>";									
						?>
									<a class='btn btn-success btn-xs' href='<?php echo base_url('more/add_confined/' . $lista['fk_id_job'] . '/' . $lista['id_job_confined'] ) ?>'>
											Edit <span class="glyphicon glyphicon-edit" aria-hidden="true">
									</a>								
						<?php
									echo "</td>";
									echo "</tr>";
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