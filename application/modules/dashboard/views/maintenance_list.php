<div id="page-wrapper">
	<br>

	<!-- /.row -->
	<div class="row">
		<div class="col-lg-12">
			<div class="panel panel-danger">
				<div class="panel-heading">
					<a class="btn btn-danger btn-xs" href=" <?php echo base_url($dashboardURL); ?> "><span class="glyphicon glyphicon glyphicon-chevron-left" aria-hidden="true"></span> Go back </a> 
					<i class="fa fa-wrench"></i> <strong>PREVENTIVE MAINTENANCE LIST </strong>
				</div>
				<div class="panel-body">
									
					<div class="alert alert-danger">
							<strong>Attention: </strong>
							The following unit(s) are 100 hours or less to its next due maintenance cycle
or a week before to the item's next renewal.
 
							

					</div>

					<br>
				<?php
					if($infoMaintenance){
				?>
					
							<table width="100%" class="table table-striped table-bordered table-hover" id="dataTables">
								<thead>
									<tr>
										<th class="text-center">Vehicle</th>
										<th class="text-center">Maintenance</th>
										<th class="text-center">Hours/Kilometers</th>
										<th class="text-center">Next Hours/Kilometers maintenance </th>
										<th class="text-center">Next date maintenance </th>
									</tr>
								</thead>
								<tbody>							
								<?php
									foreach ($infoMaintenance as $listaMaintenance):
										$nextHoursMaintenance = $listaMaintenance['next_hours_maintenance']?$listaMaintenance['next_hours_maintenance']:"";
										
										
										echo "<tr>";
										echo "<td class='text-center'>";
										echo "<p class='text-danger'><strong>" . $listaMaintenance["unit_number"] . "</strong></p>";
										
										if($listaMaintenance["photo"]){
											echo '<img src="' . base_url($listaMaintenance["photo"]) . '" class="img-rounded" width="42" height="42" />';
										}
										
										echo "<br>" . $listaMaintenance['description'] . "<br>";
										echo '<a href="' . base_url("maintenance/entrance/" . $listaMaintenance['id_vehicle']) . '" class="btn btn-danger btn-xs">Review</a>';
										
										echo "</td>";

										echo "<td>";
										echo "<strong>Type: </strong><br>". $listaMaintenance['maintenance_type'] . "<br>";
										echo "<strong>Description: </strong><br>" . $listaMaintenance['maintenance_description'] . "</td>";
										
										echo "<td class='text-right'>";
										$tipo = $listaMaintenance['type_level_2'];
										//si es sweeper
										if($tipo == 15){
											echo "<strong>Truck engine current hours: </strong>" . number_format($listaMaintenance["hours"]);
											echo "<br><strong>Sweeper engine current hours: </strong>" . number_format($listaMaintenance["hours_2"]);
										//si es hydrovac
										}elseif($tipo == 16){
											echo "<strong>Engine current hours: </strong><br>" . number_format($listaMaintenance["hours"]);
											echo "<br><strong>Hydraulic pump current hours: </strong><br>" . number_format($listaMaintenance["hours_2"]);
											echo "<br><strong>Blower current hours: </strong><br>" . number_format($listaMaintenance["hours_3"]);
										}else{
											echo "<strong>Engine current hours/Kilometers: </strong><br>" .number_format($listaMaintenance["hours"]);
										}								
										echo "</td>";
										
										echo "<td class='text-right'>" . number_format((float)$nextHoursMaintenance) . "</td>";
										echo "<td class='text-center'>" . $listaMaintenance['next_date_maintenance'] . "</td>";
										echo "</tr>";
									endforeach;
								?>
								</tbody>
							</table>
							<!-- /.table-responsive -->
					
				<?php }else{ ?>
				
					<div class="alert alert-danger">
						No maintenance record to expire
					</div>
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