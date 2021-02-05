<script type="text/javascript" src="<?php echo base_url("assets/js/validate/claims/claims.js"); ?>"></script>

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

							foreach ($WOList as $lista):
                            	//buscar informacion por submodulo para sacar el subtotal
								$workorderPersonal = $this->workorders_model->get_workorder_personal($lista['id_workorder']);//workorder personal list
								$workorderMaterials = $this->workorders_model->get_workorder_materials($lista['id_workorder']);//workorder material list
								$workorderEquipment = $this->workorders_model->get_workorder_equipment($lista['id_workorder']);//workorder equipment list
								$workorderOcasional = $this->workorders_model->get_workorder_ocasional($lista['id_workorder']);//workorder ocasional list
								$workorderHoldBack = $this->workorders_model->get_workorder_hold_back($lista['id_workorder']);//workorder ocasional

								$totalPersonal = 0;
								$totalMaterial = 0;
								$totalEquipment = 0;
								$totalOcasional = 0;
								$totalHoldBack = 0;
								$total = 0;
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

								$total = $totalPersonal + $totalMaterial + $totalEquipment + $totalOcasional + $totalHoldBack;

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
								echo "<a href='" . base_url('workorders/add_workorder/' . $lista['id_workorder']) . "'>" . $lista['id_workorder'] . "</a>";
								echo '<p class="' . $clase . '"><i class="fa ' . $icono . ' fa-fw"></i>' . $valor . '</p>';
								echo "<a href='" . base_url('workorders/add_workorder/' . $lista['id_workorder']) . "' class='btn btn-warning btn-xs' title='Review' target='_blanck'>Review W.O.</a>";
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
								echo "<p class='text-danger'><strong>Subtotal: </strong>$ " . number_format($total, 2) . "</p>";
								echo '</td>';
								echo "<td class='text-center'>";
								?>
								<button type="button" id="<?php echo $lista['id_workorder'] . '-' . $claimsInfo[0]['id_claim']; ?>" class='btn btn-danger btn-xs' title="Delete">
										<i class="fa fa-trash-o"></i>
								</button>
								<?php
								echo '</td>';
								echo "</tr>";
							endforeach;
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