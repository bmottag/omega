<div id="page-wrapper">
	<br>

	<!-- /.row -->
	<div class="row">
		<div class="col-lg-12">
			<div class="panel panel-violeta">
				<div class="panel-heading">
					<a class="btn btn-violeta btn-xs" href=" <?php echo base_url().'jobs'; ?> "><span class="glyphicon glyphicon glyphicon-chevron-left" aria-hidden="true"></span> Go back </a> 
					<i class="fa fa-umbrella"></i> <strong>BITACORA</strong>
				</div>
				<div class="panel-body">
				
					<div class="alert alert-violeta">
						<span class="fa fa-briefcase" aria-hidden="true"></span>
						<strong>Job Code/Name: </strong><?php echo $jobInfo[0]['job_description']; ?>
					</div>					
									
					<br>
				<?php
					if($workOrderInfo){
				?>
					<table width="100%" class="table table-striped table-bordered table-hover" id="dataTables">
						<thead>
							<tr>
                                <th class='text-center'>W.O. #</th>
                                <th class='text-center'>Date W.O.</th>
                                <th class='text-center'>Task Description</th>
							</tr>
						</thead>
						<tbody>							
						<?php
                            foreach ($workOrderInfo as $lista):
                                echo "<tr>";
                                echo "<td class='text-center'>" . $lista['id_workorder'] . "</td>";
                                echo "<td class='text-center'>" . $lista['date'] . "</td>";
                                echo "<td>" . $lista['observation'] . "</td>";
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