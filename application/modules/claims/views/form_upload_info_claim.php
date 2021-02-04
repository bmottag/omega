<script type="text/javascript" src="<?php echo base_url("assets/js/validate/safety/safety.js"); ?>"></script>

<div id="page-wrapper">
	<br>
	
	<!-- /.row -->
	<div class="row">
		<div class="col-lg-12">
			<div class="panel panel-danger">
				<div class="panel-heading">
					<i class="fa fa-bomb"></i> <strong>CLAIMS</strong>
				</div>
				<div class="panel-body">

<?php
$retornoExito = $this->session->flashdata('retornoExito');
if ($retornoExito) {
    ?>
	<div class="col-lg-12">	
		<div class="alert alert-success ">
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

					<div class="row">
						<div class="col-lg-6">								
							<div class="alert alert-danger">
								<strong>Claim No.: </strong><?php echo $claimsInfo?$claimsInfo[0]["id_claim"]:""; ?>
								<br><strong>Job Code/Name: </strong><?php echo $claimsInfo?$claimsInfo[0]["job_description"]:""; ?>
								<br><strong>Date Issue: </strong><?php echo $claimsInfo?$claimsInfo[0]["date_issue_claim"]:""; ?>
								<br><strong>Obsservation: </strong><?php echo $claimsInfo?$claimsInfo[0]["observation_claim"]:""; ?>
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
	</div>
	<!-- /.row -->
	
	<!--INICIO WO -->
	<div class="row">
		<div class="col-lg-12">				
			<div class="panel panel-primary">
				<div class="panel-heading">
					<i class="fa fa-money"></i> <strong>ASSIGNED WORK ORDERS</strong>
				</div>
				<div class="panel-body">
				
					<a href="<?php echo base_url("claims/add_wo/" . $claimsInfo[0]["fk_id_job_claim"] . "/" . $claimsInfo[0]["id_claim"]); ?>" class="btn btn-primary btn-block"><span class="glyphicon glyphicon-plus" aria-hidden="true"></span> Add Work Orders</a>
					<br>

				<?php 
					if($WOList){
				?>
					<table class="table table-bordered table-striped table-hover table-condensed">
						<tr class="dafault">
							<th class="text-center">W.O. #</th>
							<th class="text-center">Supervisor</th>
							<th class="text-center">Date of Issue</th>
							<th class="text-center">Date W.O.</th>
							<th class="text-center">Task Description</th>
						</tr>
						<?php
							foreach ($WOList as $lista):
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
								echo "<a href='" . base_url('workorders/add_workorder/' . $lista['id_workorder']) . "'>" . $lista['id_workorder'];
								echo '<p class="' . $clase . '"><i class="fa ' . $icono . ' fa-fw"></i>' . $valor . '</p>';
								echo "<strong>Last Message:</strong><br>" . $lista['last_message'];
								echo "</a></td>";
								echo "<td>" . $lista['name'] . "</td>";
								echo "<td class='text-center'>" . $lista['date_issue'] . "</td>";
								echo "<td class='text-center'>" . $lista['date'] . "</td>";
								echo "<td>" . $lista['observation'] . "</td>";
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