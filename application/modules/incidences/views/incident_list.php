<div id="page-wrapper">
	<br>
	
	<!-- /.row -->
	<div class="row">
		<div class="col-lg-12">
			<div class="panel panel-info">
				<div class="panel-heading">
					<i class="fa fa-ambulance"></i> <strong>INCIDENCES</strong> - INCIDENT/ACCIDENT REPORT
				</div>
				<div class="panel-body">
					<a class='btn btn-outline btn-info btn-block' href='<?php echo base_url('incidences/add_incident/') ?>'>
							<span class="glyphicon glyphicon-edit" aria-hidden="true"> </span>  Add an Incident/Accident Report
					</a>
					
					<br>
				<?php
					if($incidentInfo){
				?>
					<table width="100%" class="table table-striped table-bordered table-hover" id="dataTables">
						<thead>
							<tr>
								<th>#</th>
								<th>Reported by</th>
								<th>Incident type</th>
								<th>Incident date</th>
								<th>What happened?</th>
								<th>Edit</th>
								<th>Download</th>
							</tr>
						</thead>
						<tbody>							
						<?php
							foreach ($incidentInfo as $lista):
									echo "<tr>";
									echo "<td class='text-center'>" . $lista['id_incident'] . "</td>";
									echo "<td>" . $lista['name'] . "</td>";
									echo "<td>" . $lista['incident_type'] . "</td>";
									echo "<td class='text-center'>" . $lista['date_incident'] . "</td>";
									echo "<td>" . $lista['what_happened'] . "</td>";
									
									echo "<td class='text-center'>";									
									
									if($lista['state_incidence']==1){
						?>
									<a class='btn btn-success btn-xs' href='<?php echo base_url('incidences/add_incident/' . $lista['id_incident']) ?>'>
											Edit <span class="glyphicon glyphicon-edit" aria-hidden="true">
									</a>								
						<?php
									}else{
						?>
									<button type="button" class="btn btn-danger btn-xs" >
										Close 
									</button>
						<?php			
									}
									echo "</td>";
									echo "<td class='text-center'>";
						?>
<a href='<?php echo base_url('incidences/generaPDF/' . $lista['id_incident'] . '/' . 2 ); ?>' target="_blank">PDF <img src='<?php echo base_url_images('pdf.png'); ?>' ></a>	
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
    </script>