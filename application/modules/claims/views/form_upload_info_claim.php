<script type="text/javascript" src="<?php echo base_url("assets/js/validate/claims/claims.js"); ?>"></script>
<script>
$(function(){
	$(".btn-success").click(function () {
		var oID = $(this).attr("id");
        $.ajax ({
            type: 'POST',
			url: base_url + 'claims/cargarModalClaimState',
			data: {'idClaim': oID},
            cache: false,
            success: function (data) {
                $('#tablaDatos').html(data);
            }
        });
	});
});
</script>

<div id="page-wrapper">
	<br>
	
	<!-- /.row -->
	<div class="row">
		<div class="col-lg-3">
			<div class="panel panel-info">
				<div class="panel-heading">
					<a class="btn btn-info btn-xs" href="<?php echo base_url().'claims'; ?> "><span class="glyphicon glyphicon glyphicon-chevron-left" aria-hidden="true"></span> Go back </a>
					<i class="fa fa-bomb"></i> <strong>CLAIMS</strong>
				</div>
				<div class="panel-body">

					<div class="row">
						<div class="col-lg-12">								
							<div class="alert alert-info">
								<strong>Claim #: </strong><?php echo $claimsInfo?$claimsInfo[0]["id_claim"]:""; ?>
								<br><strong>Job Code/Name: </strong><br><?php echo $claimsInfo?$claimsInfo[0]["job_description"]:""; ?>
								<br><strong>Date Issue: </strong><br><?php echo $claimsInfo?$claimsInfo[0]["date_issue_claim"]:""; ?>
								<br><strong>Obsservation: </strong><br><?php echo $claimsInfo?$claimsInfo[0]["observation_claim"]:""; ?>
							</div>
						</div>
					</div>

					<!-- /.row (nested) -->
				</div>
				<!-- /.panel-body -->
			</div>
			<!-- /.panel -->

			<!-- /.panel .chat-panel -->
			<div class="chat-panel panel panel-success">
				<div class="panel-heading">
					<button type="button" class="btn btn-success btn-xs" data-toggle="modal" data-target="#modal" id="<?php echo $claimsInfo[0]['id_claim']; ?>" >
							<span class="glyphicon glyphicon-plus" aria-hidden="true"></span> Add Info
					</button>
					<i class="fa fa-comments fa-fw"></i> State history
				</div>
				<!-- /.panel-heading -->
				<div class="panel-body">
					<ul class="chat">
<?php 
	if($claimsHistory)
	{
		foreach ($claimsHistory as $data):		

			switch ($data['state_claim']) {
					case 1:
							$valor = 'New Claim';
							$clase = "text-info";
							$icono = "fa-flag";
							break;
					case 2:
							$valor = 'Send to the client';
							$clase = "text-primary";
							$icono = "fa-share";
							break;
					case 3:
							$valor = 'Hold Back';
							$clase = "text-warning";
							$icono = "fa-bullhorn";
							break;
					case 4:
							$valor = 'Short Payment';
							$clase = "text-danger";
							$icono = "fa-thumbs-o-down";
							break;
					case 5:
							$valor = 'Paid';
							$clase = "text-success";
							$icono = "fa-bomb";
							break;
			}
?>
			<li class="right clearfix">
				<span class="chat-img pull-right">
					<small class="pull-right text-muted">
						<i class="fa fa-clock-o fa-fw"></i> <?php echo $data['date_issue_claim_state']; ?>
					</small>
				</span>
				<div class="chat-body clearfix">
					<div class="header">
						<span class="glyphicon glyphicon-user" aria-hidden="true"></span>
						<strong class="primary-font"><?php echo $data['first_name']; ?></strong>
					</div>
					<p>
						<?php echo $data['message_claim']; ?>
					</p>
					<?php echo '<p class="' . $clase . '"><strong><i class="fa ' . $icono . ' fa-fw"></i>' . $valor . '</strong></p>'; ?>
				</div>
			</li>
<?php
		endforeach;
	}
?>
					</ul>
					
				</div>
				<!-- /.panel-body -->
			</div>
			<!-- /.panel .chat-panel -->

		</div>
		<!-- /.col-lg-12 -->
	
	<!--INICIO WO -->
		<div class="col-lg-9">				
			<div class="panel panel-primary">
				<div class="panel-heading">
					<i class="fa fa-money"></i> <strong>ASSIGNED WORK ORDERS TO THE CLAIM</strong>
				</div>
				<div class="panel-body">
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
					<a href="<?php echo base_url("claims/add_wo/" . $claimsInfo[0]["fk_id_job_claim"] . "/" . $claimsInfo[0]["id_claim"]); ?>" class="btn btn-primary btn-block"><span class="glyphicon glyphicon-plus" aria-hidden="true"></span> Add Work Orders to the Claim</a>
					<br>

				<?php 
					if($WOList){
				?>
					<table class="table table-bordered table-striped table-hover table-condensed">
						<tr class="dafault">
							<th class="text-center">W.O. #</th>
							<th class="text-center">Supervisor</th>
							<th class="text-center">Date W.O.</th>
							<th class="text-center">More information</th>
							<th class="text-center">Subtotal</th>
							<th class="text-center">Delete</th>
						</tr>
						<?php
							//se va a consultar registros de la WO
							$ci = &get_instance();
							$ci->load->model("workorders/workorders_model");

							$Total = 0;
							foreach ($WOList as $lista):
                            	//buscar informacion por submodulo para sacar el subtotal
								$arrParam = array('idWorkOrder' =>$lista['id_workorder']);
								$workorderPersonal = $this->workorders_model->get_workorder_personal($arrParam);//workorder personal list
								$workorderMaterials = $this->workorders_model->get_workorder_materials($arrParam);//workorder material list
								$workorderEquipment = $this->workorders_model->get_workorder_equipment($arrParam);//workorder equipment list
								$workorderOcasional = $this->workorders_model->get_workorder_ocasional($arrParam);//workorder ocasional list
								$workorderHoldBack = $this->workorders_model->get_workorder_hold_back($lista['id_workorder']);//workorder ocasional

								$totalPersonal = 0;
								$totalMaterial = 0;
								$totalEquipment = 0;
								$totalOcasional = 0;
								$totalHoldBack = 0;
								$Subtotal = 0;
								// INICIO PERSONAL
								if($workorderPersonal)
								{ 
									foreach ($workorderPersonal as $data):
											$totalPersonal = $data['value'] + $totalPersonal;
									endforeach;
								}
								// INICIO MATERIAL
								if($workorderMaterials)
								{ 
									foreach ($workorderMaterials as $data):
											$totalMaterial = $data['value'] + $totalMaterial;
									endforeach;
								}								
								// INICIO EQUIPMENT
								if($workorderEquipment)
								{ 
									foreach ($workorderEquipment as $data):
											$totalEquipment = $data['value'] + $totalEquipment;
									endforeach;
								}							
								// INICIO SUBCONTRATISTAS OCASIONALES
								if($workorderOcasional)
								{ 
									foreach ($workorderOcasional as $data):
											$totalOcasional = $data['value'] + $totalOcasional;
									endforeach;
								}									
								// INICIO HOLD BACK
								if($workorderHoldBack)
								{ 
									foreach ($workorderHoldBack as $data):
											$totalHoldBack = $data['value'] + $totalHoldBack;
									endforeach;
								}

								$Subtotal = $totalPersonal + $totalMaterial + $totalEquipment + $totalOcasional + $totalHoldBack;
								$Total = $Subtotal + $Total;

								//estado
								switch ($lista['state']) {
										case 0:
												$valor = 'On field';
												$clase = "text-danger";
												$icono = "fa-thumb-tack";
												break;
										case 1:
												$valor = 'In Progress';
												$clase = "text-warning";
												$icono = "fa-refresh";
												break;
										case 2:
												$valor = 'Revised';
												$clase = "text-primary";
												$icono = "fa-check";
												break;
										case 3:
												$valor = 'Send to the client';
												$clase = "text-success";
												$icono = "fa-envelope-o";
												break;
										case 4:
												$valor = 'Closed';
												$clase = "text-danger";
												$icono = "fa-power-off";
												break;
								}

								echo "<tr>";					
								echo "<td class='text-center'>";
								echo "<a href='" . base_url('workorders/add_workorder/' . $lista['id_workorder']) . "' target='_blanck'>" . $lista['id_workorder'] . "</a>";
								echo '<p class="' . $clase . '"><i class="fa ' . $icono . ' fa-fw"></i>' . $valor . '</p>';
								echo "<a href='" . base_url('workorders/generaWorkOrderPDF/' . $lista['id_workorder']) . "' target='_blanck'><img src='" . base_url_images('pdf.png') . "' ></a>";
								echo '</td>';
								echo '<td>' . $lista['name'] . '</td>';
								echo "<td class='text-center'>" . $lista['date'] . "</td>";
								echo '<td>';
								echo '<strong>Task Description:</strong><br>' . $lista['observation'];
								echo '<br><strong>Additional information last message:</strong><br>' . $lista['last_message'];
								echo '</td>';
								echo '<td class="text-right">';
								echo "<p class='text-info'>";
								if($totalPersonal>0){
									echo "<strong>Personal: </strong>$ " . number_format($totalPersonal, 2) . "</br>";
								}
								if($totalMaterial>0){
									echo "<strong>Material: </strong>$ " . number_format($totalMaterial, 2) . "</br>";
								}
								if($totalEquipment>0){
									echo "<strong>Equipment: </strong>$ " . number_format($totalEquipment, 2) . "</br>";
								}
								if($totalOcasional>0){
									echo "<strong>Ocasional: </strong>$ " . number_format($totalOcasional, 2) . "</br>";
								}
								if($totalHoldBack>0){
									echo "<strong>Hold Back: </strong>$ " . number_format($totalHoldBack, 2) . "</br>";
								}
								echo "</p>";
								echo "<p class='text-danger'><strong>Subtotal: </strong>$ " . number_format($Subtotal, 2) . "</p>";
								echo '</td>';
								echo "<td class='text-center'>";
								?>
								<button type="button" id="<?php echo $lista['id_workorder'] . '-' . $claimsInfo[0]['id_claim']; ?>" class='btn btn-danger btn-xs' title="Delete">
										<i class="fa fa-trash-o"></i>
								</button>
								<?php
								echo '</td>';
								echo '</tr>';
							endforeach;
								echo '<tr>';
								echo "<td class='text-right' colspan='5'>";
								echo "<p class='text-danger'><strong>Total: </strong>$ " . number_format($Total, 2) . "</p>";
								echo '</td>';
								echo '<td></td>';
								echo '</tr>';
						?>
					</table>
				<?php } ?>

				</div>
			</div>
		</div>
	</div>
	<!--INICIO HAZARDS -->
	
</div>
<!-- /#page-wrapper -->

<!--INICIO Modal para adicionar ESTADO -->
<div class="modal fade text-center" id="modal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">    
	<div class="modal-dialog" role="document">
		<div class="modal-content" id="tablaDatos">

		</div>
	</div>
</div>                       
<!--FIN Modal para adicionar ESTADO -->