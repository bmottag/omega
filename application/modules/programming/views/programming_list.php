<div id="page-wrapper">
	<br>

	<!-- /.row -->
	<div class="row">
		<div class="col-lg-12">
			<div class="panel panel-warning">
				<div class="panel-heading">
					<a class="btn btn-warning btn-xs" href=" <?php echo base_url().'dashboard'; ?> "><span class="glyphicon glyphicon glyphicon-chevron-left" aria-hidden="true"></span> Go back </a> 
					<i class="fa fa-truck"></i> <strong>PROGRAMMING LIST </strong>
				</div>
				<div class="panel-body">
							
					<a class='btn btn-outline btn-warning btn-block' href='<?php echo base_url('programming/add_programming'); ?>'>
							<span class="glyphicon glyphicon-edit" aria-hidden="true"> </span>  New Programming
					</a>
					
					<br>
				<?php
					if($information){ 
				?>
					<table width="100%" class="table table-striped table-bordered table-hover" id="dataTables">
						<thead>
							<tr>
								<th class='text-center'>Date</th>
								<th class='text-center'>Job Code/Name</th>
								<th class='text-center'>Observation</th>
								<th class='text-center'>Links</th>
								<th class='text-center'>Done by</th>
							</tr>
						</thead>
						<tbody>							
						<?php
							foreach ($information as $lista):
								echo "<tr>";
								echo "<td class='text-center'>" . $lista['date_programming'] . "</td>";
								echo "<td class='text-center'>" . $lista['job_description'] . "</td>";
								echo "<td class='text-right'>" . $lista['observation'] . "</td>";
								echo "<td>";
								echo "</td>";
								echo "<td class='text-right'>" . $lista['name'] . "</td>";

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