<script type="text/javascript" src="<?php echo base_url("assets/js/validate/chat/chat.js"); ?>"></script>

<script>
$(function(){ 
	$(".btn-service-order-parts").click(function () {
			var oID = $(this).attr("id");
			var idServiceOrder = $('#hddIdServiceOrder').val();
			var idEquipment = $('#hddIdEquipment').val();
            $.ajax ({
                type: 'POST',
				url: base_url + 'serviceorder/cargarModalParts',
				data: {"idPart": oID, idServiceOrder, idEquipment },
                cache: false,
                success: function (data) {
                    $('#tablaDatosServiceOrder').html(data);
                }
            });
	});	
});
</script>


<div class="panel panel-primary">
	<div class="panel-body">
		<div class="alert alert-default">
			<h3><i class="fa fa-briefcase"></i> <b>S.O. #: </b> <?php echo $information[0]['id_service_order']; ?>
				<input type="hidden" id="hddIdServiceOrder" name="hddIdServiceOrder" value="<?php echo $information[0]['id_service_order']; ?>" />
				<input type="hidden" id="hddIdEquipment" name="hddIdEquipment" value="<?php echo $vehicleInfo[0]['id_vehicle']; ?>" />
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


	</div>
</div>

<div class="row">

	<div class="col-lg-6">	
		<div class="chat-panel panel panel-primary">
			<div class="panel-heading">
				<i class="fa fa-comments fa-fw"></i> Chat
			</div>

			<div class="panel-body">
				<ul class="chat">
					<?php 
						if($chatInfo)
						{
							foreach ($chatInfo as $data):		
					?>
								<li class="right clearfix">
									<span class="chat-img pull-right">
										<small class="pull-right text-muted">
											<i class="fa fa-clock-o fa-fw"></i> <?php echo $data['created_at']; ?>
										</small>
									</span>
									<div class="chat-body clearfix">
										<div class="header">
											<span class="glyphicon glyphicon-user" aria-hidden="true"></span>
											<strong class="primary-font"><?php echo $data['user_from']; ?></strong>
										</div>
										<p>
											<?php echo $data['message']; ?>
										</p>
									</div>
								</li>
					<?php
							endforeach;
						}
					?>
				</ul>
			</div>
			<form name="formChat" id="formChat" method="post">
				<div class="panel-footer">
					<div class="input-group">					
							<input type="hidden" id="hddId" name="hddId" value="<?php echo $information?$information[0]["id_service_order"]:""; ?>"/>
							<input type="hidden" id="hddModule" name="hddModule" value="<?php echo ID_MODULE_SERVICE_ORDER; ?>"/>
							<input type="hidden" id="hddIdEquipment" name="hddIdEquipment" value="<?php echo $vehicleInfo[0]['id_vehicle']; ?>"/>
							<input type="hidden" id="hddView" name="hddView" value="tab_service_order_detail"/>
							<input id="message" name="message" type="text" class="form-control input-sm" placeholder="Type your message here..." />
							<span class="input-group-btn">
								<button type="button" id="btnChat" name="btnChat"  class="btn btn-primmary btn-sm" id="btn-chat">
									Send
								</button>
							</span>
					</div>
				</div>
			</form>
		</div>
	</div>

	<div class="col-lg-6">	
		<div class="chat-panel panel panel-primary">
			<div class="panel-heading">
				<i class="fa fa-comments fa-fw"></i> Parts
			</div>

			<div class="panel-body">

			</div>
			<div class="panel-footer">
				<div class="input-group">					
					<span class="input-group-btn">
						<button type="button" class="btn btn-primary btn-sm btn-service-order-parts" data-toggle="modal" data-target="#modalServiceOrder" id="x">
								<span class="glyphicon glyphicon-plus" aria-hidden="true"></span> Add Parts
						</button>
					</span>
				</div>
			</div>
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