<link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>

<script>
$(function(){ 
	$(".btn-service-order").click(function () {
			var oID = $(this).attr("id");
            $.ajax ({
                type: 'POST',
				url: base_url + 'serviceorder/cargarModalServiceOrder',
				data: {"idServiceOrder": oID },
                cache: false,
                success: function (data) {
                    $('#tablaDatosServiceOrder').html(data);
                }
            });
	});	
});
</script>


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
						<button type="button" class="btn btn-primary btn-xs btn-service-order" data-toggle="modal" data-target="#modalServiceOrder" id="<?php echo $lista['id_service_order']; ?>" title="Edit" >
							Edit  <span class="glyphicon glyphicon-edit" aria-hidden="true"> </span>
						</button>
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