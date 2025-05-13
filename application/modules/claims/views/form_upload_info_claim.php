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
								<strong>Claim Number: </strong><?php echo $claimsInfo?$claimsInfo[0]["claim_number"]:""; ?>
								<br><strong>Job Code/Name: </strong><br><?php echo $claimsInfo?$claimsInfo[0]["job_description"]:""; ?>
								<br><strong>Date Issue: </strong><br><?php echo $claimsInfo?$claimsInfo[0]["date_issue_claim"]:""; ?>
								<br><strong>Observation: </strong><br><?php echo $claimsInfo?$claimsInfo[0]["observation_claim"]:""; ?>
							</div>
						</div>
					</div>
				</div>
			</div>

			<div class="chat-panel panel panel-success">
				<div class="panel-heading">
					<button type="button" class="btn btn-success btn-xs" data-toggle="modal" data-target="#modal" id="<?php echo $claimsInfo[0]['id_claim']; ?>" >
							<span class="glyphicon glyphicon-plus" aria-hidden="true"></span> Add Info
					</button>
					<i class="fa fa-comments fa-fw"></i> Status history
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
			</div>
		</div>
	
	<!--INICIO APU -->
		<div class="col-lg-9">				
			<div class="panel panel-primary">
				<div class="panel-heading">
					<i class="fa fa-money"></i> <strong>ASSIGNED APU TO CLAIM</strong>
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
					<br>
					<form id="form_acs_personal" method="post" action="<?php echo base_url("claims/update_claim"); ?>">
						<input type="hidden" id="hddIdClaim" name="hddIdClaim" value="<?php echo $claimsInfo[0]['id_claim']; ?>" />
						<?php
						if($chapterList){
							$ci = &get_instance();
							$ci->load->model("general_model");

							foreach ($chapterList as $lista):
								$arrParam = array("idJob" => $claimsInfo[0]['fk_id_job'], "chapterNumber" => $lista['chapter_number'], "idClaim" => $claimsInfo[0]['id_claim'], "status" => 1);
								$jobDetails = $this->general_model->get_job_detail($arrParam);

								if($jobDetails){
						?>
								<div class="panel-body">
									<div class="panel-group" id="accordion">	
										<h2><?php echo $lista['chapter_name']; ?></h2>
										<?php
											foreach ($jobDetails as $data):
												$class = "default";
										?>
											<input type="hidden" name="records[<?php echo $data['id_job_detail']; ?>][id_job_detail]" value="<?php echo $data['id_job_detail']; ?>" />
											<input type="hidden" name="records[<?php echo $data['id_job_detail']; ?>][unit_price]" value="<?php echo $data['unit_price']; ?>" />
											<div class="panel panel-<?php echo $class ?>" >
												<div class="panel-heading">
													<h4 class="panel-title">
														<table width="100%" class="table table-striped table-bordered table-hover small" id="dataTables">
														<?php
															echo "<tr class='" . $class . "'>";
															echo "<td width='4%' class='text-center'><p class='text-" . $class . "'><b>Item</b><br>" . $data['chapter_number'] . "." . $data['item'] . "</p></td>";
															echo "<td width='40%'><p class='text-" . $class . "'><b>Description</b><br>" . $data['description'] . "</p></td>";
															echo "<td width='4%' class='text-center'><p class='text-" . $class . "'><b>Unit</b><br>" . $data['unit'] . "</p></td>";
															echo "<td width='4%' class='text-center'><p class='text-" . $class . "'><b>Qty</b><br>" . $data['quantity'] . "</p></td>";
															echo "<td width='8%' class='text-right'><p class='text-" . $class . "'><b>Unit Price</b><br>$ " . number_format($data['unit_price'],2) . "</p></td>";
															echo "<td width='10%' class='text-right'><p class='text-" . $class . "'><b>Extended Amount</b><br>$ " . number_format($data['extended_amount'],2) . "</p></td>";
														?>
											<td class="text-right">
												<b>Qty Claim</b>
												<input type="text" name="records[<?php echo $data['id_job_detail']; ?>][quantity]" class="form-control" value="<?php echo $data['quantity_claim']; ?>" placeholder="Quantity" >
											</td>

											<td class="text-right">
												<b>Cost Claim</b>
												<input type="text" name="records[<?php echo $data['id_job_detail']; ?>][cost]" class="form-control" value="<?php echo $data['cost']; ?>" placeholder="Cost" >
											</td>
														<?php
															echo "</tr>";
														?>
														</table>
													</h4>
												</div>
											</div>
										<?php
											endforeach;
										?>
									</div>
								</div>
						<?php 
								}
							endforeach;
							}
						?>
						<button type="submit" id="btnSubmitAPUInfo" name="btnSubmitAPUInfo" class="btn btn-primary">
							Save Information <span class="glyphicon glyphicon-floppy-disk" aria-hidden="true">
						</button>
					</form>

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