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


		<div class="alert alert-default">
			<h3><i class="fa fa-briefcase"></i> <b>S.O. #: </b> <?php echo $information[0]['id_service_order']; ?>
				<small>
					<br><b>Assigned By: </b><?php echo $information[0]['assigned_by']; ?>
					<br><b>Assigned To: </b><?php echo $information[0]['assigned_to']; ?>
					<br><b>Request Date: </b><?php echo date('F j, Y - G:i:s', strtotime($information[0]['created_at'])); ?>
					<br><b>Description: </b><?php echo $information[0]['maintenance_description']; ?>
					<br><b><?php echo $information[0]['maintenace_type']=='corrective'?'Corrective Maintenance':'Preventive Maintenance'; ?></b>
					<br><b>Priority: </b>
					<a class="btn btn-<?php echo $information[0]['priority_style']; ?> btn-xs">
						<i class="fa <?php echo $information[0]['priority_icon']; ?>"></i> <?php echo $information[0]['priority_name']; ?>
					</a>
					<br><b>Status: </b>
					<a class="btn btn-<?php echo $information[0]['status_style']; ?> btn-xs">
						<i class="fa <?php echo $information[0]['status_icon']; ?>"></i> <?php echo $information[0]['status_name']; ?>
					</a>
				</small>
			</h3>
		</div>


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