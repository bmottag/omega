<script type="text/javascript" src="<?php echo base_url("assets/js/validate/claims/claims.js?v=2"); ?>"></script>
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
	<div class="row">
		<div class="col-lg-12">
			<div class="panel panel-primary">
				<div class="panel-heading">
					<a class="btn btn-primary btn-xs" href="<?php echo base_url().'claims'; ?> ">
						<span class="glyphicon glyphicon-chevron-left" aria-hidden="true"></span> Go back
					</a>
					<i class="fa fa-money"></i> <strong>CLAIM HISTORY</strong>
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

					<ul class="nav nav-pills">
                        <?php $ci = & get_instance(); ?>
						<li ><a href="<?php echo base_url("claims/upload_apu/" . $claimsInfo[0]['id_claim']); ?>">Current Claim Form</a>
						</li>
						<li class='active'><a href="<?php echo base_url("claims/claim_history/" . $claimsInfo[0]['id_claim']); ?>">Claim History</a>
						</li>
					</ul>
					<br>
					<div class="row">
						<div class="col-md-6">
							<div class="panel panel-info">
								<div class="panel-heading">
									<i class="fa fa-bomb"></i> <strong>CLAIM INFORMATION</strong>
								</div>
								<div class="panel-body">
									<div class="alert alert-info">
										<strong>Claim Number: </strong><?php echo $claimsInfo?$claimsInfo[0]["claim_number"]:""; ?>
										<br><strong>Job Code/Name: </strong><br><?php echo $claimsInfo?$claimsInfo[0]["job_description"]:""; ?>
										<br><strong>Date Issue: </strong><br><?php echo $claimsInfo?$claimsInfo[0]["date_issue_claim"]:""; ?>
										<br><strong>Observation: </strong><br><?php echo $claimsInfo?$claimsInfo[0]["observation_claim"]:""; ?>
									</div>
								</div>
							</div>
						</div>

						<div class="col-md-6">
							<div class="chat-panel panel panel-success">
								<div class="panel-heading">
									<button type="button" class="btn btn-success btn-xs" data-toggle="modal" data-target="#modal" id="<?php echo $claimsInfo[0]['id_claim']; ?>" >
										<span class="glyphicon glyphicon-plus" aria-hidden="true"></span> Add Info
									</button>
									<i class="fa fa-comments fa-fw"></i> Status History
								</div>
								<div class="panel-body">
									<ul class="chat">
										<?php 
											if($claimsHistory)
											{
												foreach ($claimsHistory as $data):		
													switch ($data['state_claim']) {
														case 1:
															$valor = 'New Claim';
															$clase = "text-violeta";
															$icono = "fa-flag";
															break;
														case 2:
															$valor = 'Send to client';
															$clase = "text-success";
															$icono = "fa-share";
															break;
														case 3:
															$valor = 'Partial Payment';
															$clase = "text-primary";
															$icono = "fa-star-half-empty";
															break;
														case 4:
															$valor = 'Hold Back';
															$clase = "text-warning";
															$icono = "fa-bullhorn";
															break;
														case 5:
															$valor = 'Short Payment';
															$clase = "text-warning";
															$icono = "fa-thumbs-o-down";
															break;
														case 6:
															$valor = 'Final Payment';
															$clase = "text-danger";
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
												<p><?php echo $data['message_claim']; ?></p>
												<p class="<?php echo $clase; ?>">
													<strong><i class="fa <?php echo $icono; ?> fa-fw"></i><?php echo $valor; ?></strong>
												</p>
											</div>
										</li>
										<?php
												endforeach;
											}
										?>
									</ul>
								</div>
							</div>
						</div>
					</div> 
					<hr>

						<?php
						if($chapterList){
							$ci = &get_instance();
							$ci->load->model("general_model");

							foreach ($chapterList as $lista):
								$arrParam = array("idJob" => $claimsInfo[0]['fk_id_job'], "chapterNumber" => $lista['chapter_number'], "idClaim" => $claimsInfo[0]['id_claim'], "status" => 1);
								$jobDetails = $this->general_model->get_job_detail_claims_info($arrParam);

								if($jobDetails){
						?>
								<div class="panel-body">
									<h2><?php echo $lista['chapter_name']; ?></h2>

									<table width="100%" class="table table-striped table-bordered table-hover small" id="dataTables">
										<thead>
											<tr>
												<th width='4%'>Item</th>
												<th width='30%' class="text-center">Description</th>
												<th width='4%' class="text-center">Unit</th>
												<th width='4%' class="text-center">Qty</th>
												<th width='8%' class="text-center">Unit Price</th>
												<th width='18%' class="text-center">Extended Amount</th>

												<?php 
													if (isset($allClaims) && $allClaims) {
														foreach ($allClaims as $claim) : 
												?>
														<th width='7%' class='text-center'><?php echo "Qty Claim " . $claim['claim_number']; ?></th>
														<th width='7%' class='text-center'><?php echo "Cost Claim " . $claim['claim_number']; ?></th>
												<?php 
														endforeach; 
													}
												?>
											</tr>
										</thead>
										<tbody>
											<?php
												foreach ($jobDetails as $data):
													echo "<tr>";
													echo "<td class='text-center'>" . $data['chapter_number'] . "." . $data['item'] . "</td>";
													echo "<td>" . $data['description'] . "</td>";
													echo "<td class='text-center'>" . $data['unit'] . "</td>";
													echo "<td class='text-center'>" . $data['quantity_claim'] . "</td>";
													echo "<td class='text-right'>$ " . number_format($data['unit_price'],2) . "</td>";
													echo "<td class='text-right'>$ " . number_format($data['extended_amount'],2) . "</td>";
													if (isset($allClaims) && $allClaims) {
														$sumWorkorders = 0;
														foreach ($allClaims as $claim) {
															// Verificamos si el empleado tiene horas en esta W.O.
															$arrParamCheck = array("idClaim" => $claim['id_claim'], "idJobDetail" => $data['id_job_detail']);
															$claimInfo = $this->general_model->get_job_detail_claims_info($arrParamCheck);

									
															echo "<td class='text-center'>" . $claimInfo[0]['quantity_claim'] . "</td>";
															echo "<td class='text-center'>" . $claimInfo[0]['cost'] . "</td>";
														}
													}
													echo "</tr>";
												endforeach;
											?>
										</tbody>
									</table>
								</div>
						<?php 
								}
							endforeach;
							}
						?>

				</div>
			</div>
		</div>
	</div>	
</div>

<!--INICIO Modal para adicionar ESTADO -->
<div class="modal fade text-center" id="modal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">    
	<div class="modal-dialog" role="document">
		<div class="modal-content" id="tablaDatos">

		</div>
	</div>
</div>                
<!--FIN Modal para adicionar ESTADO -->

<script>
$(document).ready(function() {
	$('#dataTables').DataTable({
		responsive: false,
		"ordering": false,
		paging: false,
		"searching": false,
		"info": false
	});
});
</script>