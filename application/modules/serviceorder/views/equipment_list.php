			<div class="panel panel-primary">
				<div class="panel-heading"> 
					<i class="fa fa-filter"></i> <strong>SERVICE ORDER</strong>
				</div>
				<div class="panel-body">
				
				<?php
					if($vehicleInfo){
				?>
					<table width="100%" class="table table-striped table-bordered table-hover" id="dataTables">
						<thead>
							<tr>
								<th class="text-center">Photo</th>
								<th class="text-center">Make</th>
								<th class="text-center">Model</th>
								<th class="text-center">Description</th>
								<th class="text-center">Unit Number</th>
								<th class="text-center">VIN Number</th>
								<th class="text-center">Hours/Kilometers</th>
							</tr>
						</thead>
						<tbody>							
						<?php
							foreach ($vehicleInfo as $lista):
							
								echo "<tr>";
								echo "<td class='text-center'>";
									//si hay una foto la muestro
									if($lista["photo"]){
									?>
										<img src="<?php echo base_url($lista["photo"]); ?>" class="img-rounded" width="42" height="42" />
									<?php 
										} 
								echo "</td>";
								echo "<td>" . $lista['make'] . "</td>";
								echo "<td>" . $lista['model'] . "</td>";
								echo "<td>" . $lista['description'] . "</td>";
								echo "<td class='text-center'><p class='text-danger'><strong>" . $lista['unit_number'] . "</strong></p></td>";
								echo "<td class='text-center'><p class='text-danger'><strong>" . $lista['vin_number'] . "</strong></p></td>";									
								echo "<td class='text-right'><p><strong>" . number_format($lista["hours"]) . "</strong></p></td>";
								echo "</tr>";

							endforeach;
						?>
						</tbody>
					</table>
					<?php 
						}
					?>
				</div>

			</div>


<!--INICIO Modal -->
<div class="modal fade text-center" id="modalSetup" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">    
	<div class="modal-dialog" role="document">
		<div class="modal-content" id="tablaSetup">

		</div>
	</div>
</div>                       
<!--FIN Modal -->

<!--INICIO Modal -->
<div class="modal fade text-center" id="modal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">    
	<div class="modal-dialog" role="document">
		<div class="modal-content" id="tablaDatos">

		</div>
	</div>
</div>                       
<!--FIN Modal -->

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