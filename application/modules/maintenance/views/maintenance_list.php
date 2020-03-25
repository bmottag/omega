<div id="page-wrapper">
	<br>

<?php
$retornoExito = $this->session->flashdata('retornoExito');
if ($retornoExito) {
    ?>
	<div class="col-lg-12">	
		<div class="alert alert-success">
			<span class="glyphicon glyphicon-ok" aria-hidden="true"></span>
			<?php echo $retornoExito ?>		
		</div>
	</div>
    <?php
}

$retornoError = $this->session->flashdata('retornoError');
if ($retornoError) {
    ?>
	<div class="col-lg-12">	
		<div class="alert alert-danger ">
			<span class="glyphicon glyphicon-exclamation-sign" aria-hidden="true"></span>
			<?php echo $retornoError ?>
		</div>
	</div>
    <?php
}
?> 
	
	<!-- /.row -->
	<div class="row">
		<div class="col-lg-12">
			<div class="panel panel-success">
				<div class="panel-heading">
					<a class="btn btn-success btn-xs" href="<?php echo base_url().'admin/vehicle/'.$vehicleInfo[0]["type_level_1"] . '/' . $vehicleInfo[0]['inspection_type']; ?> "><span class="glyphicon glyphicon glyphicon-chevron-left" aria-hidden="true"></span> Go back </a> 
					<i class="fa fa-flag"></i> <strong>MAINTENANCE LIST</strong>
				</div>
				<div class="panel-body">
				
					<a class='btn btn-success btn-block' href='<?php echo base_url('maintenance/maintenance_form/' . $vehicleInfo[0]["id_vehicle"]) ?>'>
						<span class="glyphicon glyphicon-plus" aria-hidden="true"></span> Add Maintenance
					</a><br>
	
<?php if($infoRecords){ ?>	
					<table width="100%" class="table table-striped table-bordered table-hover" id="dataTables">
						<thead>
							<tr>
								<th class="text-center">Date</th>
								<th class="text-center">Maintenance type</th>
								<th class="text-center">Description</th>
								<th class="text-center">Done by</th>
								<th class="text-center">Revised by</th>
								<th class="text-center">Amount</th>
								<th class="text-center">Next Hours/Kilometers maintenance </th>
								<th class="text-center">Next date maintenance </th>
								<th class="text-center">Edit</th>
							</tr>
						</thead>
						<tbody>							
						<?php													
							foreach ($infoRecords as $lista):
									
								$nextHoursMaintenance = $lista['next_hours_maintenance']?$lista['next_hours_maintenance']:"";

								$class = "";
								if($lista['maintenance_state'] == 1){
									$class = "success";
								}
								
								echo "<tr class='" . $class . "' >";
								echo "<td>" . $lista['date_maintenance'] . "</td>";
								echo "<td>" . $lista['maintenance_type'] . "</td>";
								echo "<td>" . $lista['maintenance_description'] . "</td>";
								echo "<td>" . $lista['done_by'] . "</td>";
								echo "<td>" . $lista['name'] . "</td>";
								
								setlocale(LC_MONETARY, 'en_US');
								$amount = money_format('%=(#1.2n', $lista['amount']);
								
								echo "<td  class='text-right'>" . $amount . "</td>";
								echo "<td class='text-right'>" . number_format((float)$nextHoursMaintenance) . "</td>";
								echo "<td class='text-center'>" . $lista['next_date_maintenance'] . "</td>";
								
								echo "<td class='text-center'>";
									if($lista['maintenance_state'] == 1){
						?>
						
<a class="btn btn-danger btn-xs" href="<?php echo base_url().'maintenance/maintenance_form/' . $vehicleInfo[0]["id_vehicle"] . '/' . $lista["id_maintenance"]; ?> "><span class="glyphicon glyphicon-edit" aria-hidden="true"></span> Edit </a> 

						<?php
										echo "Active";
									}else{
										echo "Inactive";
									}
								echo "</td>";
								echo "</tr>";
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
<!-- /#page-wrapper -->

<!-- Tables -->
<script>
$(document).ready(function() {
	$('#dataTables').DataTable({
		responsive: true,
		"ordering": false,
		paging: false,
		"info": false
	});
});
</script>