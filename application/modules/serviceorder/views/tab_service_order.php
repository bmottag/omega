<div class="panel panel-info">
	<div class="panel-heading"> 
		<i class="fa fa-briefcase"></i> <strong>Service Order</strong>
	</div>
	<div class="panel-body small">

<?php
$retornoExito = $this->session->flashdata('retornoExito');
if ($retornoExito) {
    ?>
    <div class="row">
		<div class="col-lg-12">	
			<div class="alert alert-success ">
				<span class="glyphicon glyphicon-ok" aria-hidden="true"></span>
				<?php echo $retornoExito ?>		
			</div>
		</div>
	</div>
    <?php
}

$retornoError = $this->session->flashdata('retornoError');
if ($retornoError) {
    ?>
    <div class="row">
		<div class="col-lg-12">	
			<div class="alert alert-danger ">
				<span class="glyphicon glyphicon-exclamation-sign" aria-hidden="true"></span>
				<?php echo $retornoError ?>
			</div>
		</div>
	</div>
    <?php
}
?>
        <?php 										
            if(!$information){ 
                echo '<div class="col-lg-12">
                        <p class="text-danger"><span class="glyphicon glyphicon-alert" aria-hidden="true"></span> There are no records in the system.</p>
                    </div>';
            } else {
        ?>
		<table width="100%" class="table table-striped table-bordered table-hover" id="dataTables">
			<thead>
				<tr>
					<th>S.O. #</th>
					<th>Assigned To</th>
					<th>Request Date</th>
					<th>Description</th>
					<th>Comments</th>
					<th>Status</th>
					<th>Actions</th>
				</tr>
			</thead>
			<tbody>							
			<?php
				foreach ($information as $lista):
						echo "<tr>";
						echo "<td class='text-center'>" . $lista['id_service_order'] . "</td>";
						echo "<td>" . $lista['assigned_to'] . "</td>";
						echo "<td>" . date('F j, Y - G:i:s', strtotime($lista['created_at'])) . "</td>";
						echo "<td>" . $lista['maintenance_description'] . "</td>";
						echo "<td>" . $lista['comments'] . "</td>";
						echo "<td class='text-center'>";
						echo '<p class="text-' . $lista['status_style'] . '"><i class="fa ' . $lista['status_icon'] . ' fa-fw"></i><b>' . $lista['status_name'] . '</b></p>';
						echo "</td>";
						echo "<td class='text-center'>";	
						if($lista['service_status'] != 'closed'){
			?>					
						<a class="btn btn-primary btn-xs" onclick="loadEquipmentDetail( <?php echo $vehicleInfo[0]['id_vehicle']; ?>, 'tab_service_order_detail', <?php echo $lista['id_service_order']; ?>)" >
							<i class="fa fa-eye"></i> View
						</a>
			<?php
						}
						echo "</td>";
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