<script type="text/javascript" src="<?php echo base_url("assets/js/validate/hauling/ajaxTruck.js"); ?>"></script>
<script type="text/javascript" src="<?php echo base_url("assets/js/validate/hauling/hauling_v2.js"); ?>"></script>

<?php
/**
 * If it is an ADMIN user, show date 
 * @author BMOTTAG
 * @since  23/12/2017
 */
$userRol = $this->session->rol;
if($userRol==99){
?>
<link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
<?php } ?>

<div id="page-wrapper">
	<br>
	<div class="row">
		<div class="col-md-12">
			<div class="panel panel-primary">
				<div class="panel-heading">
					<h4 class="list-group-item-heading">
					<i class="fa fa-edit fa-fw"></i>	RECORD TASK(S)
					</h4>
				</div>
			</div>
		</div>
		<!-- /.col-lg-12 -->				
	</div>
	
	<!-- /.row -->
	<div class="row">
		<div class="col-lg-12">
			<div class="panel panel-default">
				<div class="panel-heading">
					<i class="fa fa-truck"></i> HAULING
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

<?php 
	if($HaulingClose){
?>
	<div class="col-lg-12">	
		<div class="alert alert-success ">
			<span class="glyphicon glyphicon-ok" aria-hidden="true"></span>
			This hauling form is close.
		</div>
	</div>
<?php		
	}else{
?>

					<form  name="form" id="form" class="form-horizontal" method="post" >
						<input type="hidden" id="hddId" name="hddId" value="<?php echo $information?$information["id_hauling"]:""; ?>"/>
						

						
<?php if($information){ ?>

				<div class="col-lg-6">
                    <div class="panel panel-primary">
                        <div class="panel-heading">
                            <i class="fa fa-edit fa-fw"></i> V-Contracting
                        </div>
                        <!-- /.panel-heading -->
                        <div class="panel-body">
						
							<div class="form-group">
								<div class="row" align="center">
									<div style="width:70%;" align="center">
										 
<?php 
								
	$class = "btn-primary";						
	if($information["vci_signature"]){ 
		$class = "btn-default";
	?>
	<button type="button" class="btn btn-default" data-toggle="modal" data-target="#myModal" >
		<span class="glyphicon glyphicon-eye-open" aria-hidden="true"></span> View Signature
	</button>

	<div id="myModal" class="modal fade" role="dialog">  
		<div class="modal-dialog">
			<div class="modal-content">      
				<div class="modal-header">        
					<button type="button" class="close" data-dismiss="modal">×</button>        
					<h4 class="modal-title">Hauling Supervisor Signature</h4>      </div>      
				<div class="modal-body text-center"><img src="<?php echo base_url($information["vci_signature"]); ?>" class="img-rounded" alt="Hauling Supervisor Signature" width="304" height="236" />   </div>      
				<div class="modal-footer">        
					<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>     
				</div>  
			</div>  
		</div>
	</div>

	<?php
	}
	?>

	<a class="btn <?php echo $class; ?>" href="<?php echo base_url("hauling/add_signature/vci/" . $information["id_hauling"]); ?>"><span class="glyphicon glyphicon-edit" aria-hidden="true"></span> VCI Signature </a>

									</div>
								</div>
							</div>
					
						</div>
						<!-- /.panel-body -->
					</div>
				</div>
				
				<div class="col-lg-6">
                    <div class="panel panel-info">
                        <div class="panel-heading">
                            <i class="fa fa-edit fa-fw"></i> Subcontractor
							<a href="<?php echo base_url("hauling/email/" . $information["id_hauling"]); ?>" class="btn btn-danger btn-xs"> <span class="glyphicon glyphicon-send" aria-hidden="true"></span> Send Email</a>
                        </div>
                        <!-- /.panel-heading -->
                        <div class="panel-body">

							<div class="form-group">
								<div class="row" align="center">
									<div style="width:70%;" align="center">								 
<?php 
								
$class = "btn-info";						
if($information["contractor_signature"]){ 
	$class = "btn-default";
?>
<button type="button" class="btn btn-default" data-toggle="modal" data-target="#myContractorModal" >
	<span class="glyphicon glyphicon-eye-open" aria-hidden="true"></span> View Signature
</button>

<div id="myContractorModal" class="modal fade" role="dialog">  
	<div class="modal-dialog">
		<div class="modal-content">      
			<div class="modal-header">        
				<button type="button" class="close" data-dismiss="modal">×</button>        
				<h4 class="modal-title">Hauling Contractor Signature</h4>      </div>      
			<div class="modal-body text-center"><img src="<?php echo base_url($information["contractor_signature"]); ?>" class="img-rounded" alt="Hauling Contractor Signature" width="304" height="236" />   </div>      
			<div class="modal-footer">        
				<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>     
			</div>  
		</div>  
	</div>
</div>

<?php
}
?>

<a class="btn <?php echo $class; ?>" href="<?php echo base_url("hauling/add_signature/contractor/" . $information["id_hauling"]); ?>"><span class="glyphicon glyphicon-edit" aria-hidden="true"></span> Contractor Signature </a>

							
									</div>
								</div>
							</div>

						</div>
						<!-- /.panel-body -->
					</div>
				</div>
<?php } ?>					


<?php
/**
 * If it is an ADMIN user, show date 
 * @author BMOTTAG
 * @since  23/12/2017
 */
if($userRol==99){
?>				
<script>
	$( function() {
		$( "#date" ).datepicker({
			changeMonth: true,
			changeYear: true,
			dateFormat: 'yy-mm-dd'
		});
	});
</script>
					<div class="form-group">									
						<label class="col-sm-4 control-label" for="date">Date of Issue</label>
						<div class="col-sm-5">
							<input type="text" class="form-control" id="date" name="date" value="<?php echo $information?$information["date_issue"]:""; ?>" placeholder="Date of Issue" />
						</div>
					</div>
<?php } ?>
	

						<div class="form-group">
							<label class="col-sm-4 control-label" for="company">VCI or Subcontractor</label>
							<div class="col-sm-5">
								<select name="CompanyType" id="CompanyType" class="form-control" required>
									<option value="">Select...</option>
									<option value=1 <?php if($information && $information["company_type"] == 1) { echo "selected"; }  ?>>VCI</option>
									<option value=2 <?php if($information && $information["company_type"] == 2) { echo "selected"; }  ?>>Subcontractor</option>
								</select>
							</div>
						</div>
						
						<div class="form-group">
							<label class="col-sm-4 control-label" for="company">Hauling done by</label>
							<div class="col-sm-5">
								<select name="company" id="company" class="form-control" >
									<option value=''>Select...</option>
									<?php for ($i = 0; $i < count($companyList); $i++) { ?>
										<option value="<?php echo $companyList[$i]["id_company"]; ?>" <?php if($information && $information["fk_id_company"] == $companyList[$i]["id_company"]) { echo "selected"; }  ?>><?php echo $companyList[$i]["company_name"]; ?></option>	
									<?php } ?>
								</select>
							</div>
						</div>

<?php 
	$mostrar = "none";
	$mostrarTruck = "inline";
	if($information && $information["company_type"]==2){
		$mostrar = "inline";
		$mostrarTruck = "none";
	}
?>
						<div class="form-group" id="div_truck" style="display:<?php echo $mostrarTruck; ?>">
							<label class="col-sm-4 control-label" for="truck">Truck</label>
							<div class="col-sm-5">
								<select name="truck" id="truck" class="form-control" required>
								
									<?php if($information){ ?>
									<option value=''>Select...</option>
									<?php for ($i = 0; $i < count($truckList); $i++) { ?>
										<option value="<?php echo $truckList[$i]["id_vehicle"]; ?>" <?php if($information && $information["fk_id_truck"] == $truckList[$i]["id_vehicle"]) { echo "selected"; }  ?>><?php echo $truckList[$i]["unit_number"]; ?></option>	
									<?php }} ?>

								</select>
							</div>
						</div>
						
						<div class="form-group">
							<label class="col-sm-4 control-label" for="truckType">Truck Type</label>
							<div class="col-sm-5">
								<select name="truckType" id="truckType" class="form-control" >
									<option value=''>Select...</option>
									<?php for ($i = 0; $i < count($truckTypeList); $i++) { ?>
										<option value="<?php echo $truckTypeList[$i]["id_truck_type"]; ?>" <?php if($information && $information["fk_id_truck_type"] == $truckTypeList[$i]["id_truck_type"]) { echo "selected"; }  ?>><?php echo $truckTypeList[$i]["truck_type"]; ?></option>	
									<?php } ?>
								</select>
							</div>
						</div>
						
						<div class="form-group" id="div_plate" style="display:<?php echo $mostrar; ?>">
							<label class="col-sm-4 control-label" for="plate">Plate Number </label>
							<div class="col-sm-5">
								<input type="text" id="plate" name="plate" class="form-control" value="<?php echo $information?$information["plate"]:""; ?>" placeholder="Plate number" required >
							</div>
						</div>
						
						<div class="form-group">
							<label class="col-sm-4 control-label" for="materialType">Material Type</label>
							<div class="col-sm-5">
								<select name="materialType" id="materialType" class="form-control" >
									<option value=''>Select...</option>
									<?php for ($i = 0; $i < count($materialTypeList); $i++) { ?>
										<option value="<?php echo $materialTypeList[$i]["id_material"]; ?>" <?php if($information && $information["fk_id_material"] == $materialTypeList[$i]["id_material"]) { echo "selected"; }  ?>><?php echo $materialTypeList[$i]["material"]; ?></option>	
									<?php } ?>
								</select>
							</div>
						</div>
						
						<div class="form-group">
							<label class="col-sm-4 control-label" for="fromSite">From Site</label>
							<div class="col-sm-5">
								<select name="fromSite" id="fromSite" class="form-control" >
									<option value=''>Select...</option>
									<?php for ($i = 0; $i < count($jobs); $i++) { ?>
										<option value="<?php echo $jobs[$i]["id_job"]; ?>" <?php if($information && $information["fk_id_site_from"] == $jobs[$i]["id_job"]) { echo "selected"; }  ?>><?php echo $jobs[$i]["job_description"]; ?></option>	
									<?php } ?>
								</select>
							</div>
						</div>

						<div class="form-group">
							<label class="col-sm-4 control-label" for="toSite">To Site</label>
							<div class="col-sm-5">
								<select name="toSite" id="toSite" class="form-control" >
									<option value=''>Select...</option>
									<?php for ($i = 0; $i < count($jobs); $i++) { ?>
										<option value="<?php echo $jobs[$i]["id_job"]; ?>" <?php if($information && $information["fk_id_site_to"] == $jobs[$i]["id_job"]) { echo "selected"; }  ?>><?php echo $jobs[$i]["job_description"]; ?></option>	
									<?php } ?>
								</select>
							</div>
						</div>
						
						<div class="form-group">
							<label class="col-sm-4 control-label" for="fromSite">Time In</label>
							<div class="col-sm-2">
							<?php 
								if($information){
									$timeIn = explode(":",$information["time_in"]);
									$hourIn = $timeIn[0];
									$minIn = $timeIn[1];
								}
							?>
								<select name="hourIn" id="hourIn" class="form-control" required>
									<option value='' >Select...</option>
									<?php
									for ($i = 0; $i < 24; $i++) {
										?>
										<option value='<?php echo $i; ?>' <?php
										if ($information && $i == $hourIn) {
											echo 'selected="selected"';
										}
										?>><?php echo $i; ?></option>
											<?php } ?>									
								</select>
							</div>
							<div class="col-sm-2">
								<select name="minIn" id="minIn" class="form-control" required>
									<option value="00" <?php if($information && $minIn == "00") { echo "selected"; }  ?>>00</option>
									<option value="15" <?php if($information && $minIn == "15") { echo "selected"; }  ?>>15</option>
									<option value="30" <?php if($information && $minIn == "30") { echo "selected"; }  ?>>30</option>
									<option value="45" <?php if($information && $minIn == "45") { echo "selected"; }  ?>>45</option>
								</select>
							</div>
						</div>
		
						<div class="form-group">
							<label class="col-sm-4 control-label" for="fromSite">Time Out</label>
							<div class="col-sm-2">
							<?php 
								if($information){
									$timeOut = explode(":",$information["time_out"]);
									$hourOut = $timeOut[0];
									$minOut = $timeOut[1];
								}
							?>
								<select name="hourOut" id="hourOut" class="form-control" required>
									<option value='' >Select...</option>
									<?php
									for ($i = 0; $i < 24; $i++) {
										?>
										<option value='<?php echo $i; ?>' <?php
										if ($information && $i == $hourOut) {
											echo 'selected="selected"';
										}
										?>><?php echo $i; ?></option>
											<?php } ?>									
								</select>
							</div>
							<div class="col-sm-2">
								<select name="minOut" id="minOut" class="form-control" required>
									<option value="00" <?php if($information && $minOut == "00") { echo "selected"; }  ?>>00</option>
									<option value="15" <?php if($information && $minOut == "15") { echo "selected"; }  ?>>15</option>
									<option value="30" <?php if($information && $minOut == "30") { echo "selected"; }  ?>>30</option>
									<option value="45" <?php if($information && $minOut == "45") { echo "selected"; }  ?>>45</option>
								</select>
							</div>
						</div>
		
						<div class="form-group">
							<label class="col-sm-4 control-label" for="payment">Payment</label>
							<div class="col-sm-5">
								<select name="payment" id="payment" class="form-control" >
									<option value=''>Select...</option>
									<?php for ($i = 0; $i < count($paymentList); $i++) { ?>
										<option value="<?php echo $paymentList[$i]["id_payment"]; ?>" <?php if($information && $information["fk_id_payment"] == $paymentList[$i]["id_payment"]) { echo "selected"; }  ?>><?php echo $paymentList[$i]["payment"]; ?></option>	
									<?php } ?>
								</select>
							</div>
						</div>
						
						<div class="form-group">
							<label class="col-sm-4 control-label" for="comments">Comments</label>
							<div class="col-sm-5">
							<textarea id="comments" name="comments" placeholder="Comments"  class="form-control" rows="3"><?php echo $information?$information["comments"]:""; ?></textarea>
							</div>
						</div>
						
						<div class="form-group">
							<div class="row" align="center">
								<div style="width:100%;" align="center">
																
									<button type="button" id="btnSubmit" name="btnSubmit" class="btn btn-primary" >
										Save <span class="glyphicon glyphicon-floppy-disk" aria-hidden="true">
									</button> 
												
									
									<button type="button" id="btnEmail" name="btnEmail" class="btn btn-danger" >
										Save & Send Email <span class="glyphicon glyphicon-send" aria-hidden="true">
									</button>

								</div>
							</div>
						</div>
						
						<div class="col-lg-12">	
							<div class="alert alert-danger ">
								<span class="glyphicon glyphicon-exclamation-sign" aria-hidden="true"></span>
								If you use the SAVE button you just save the Hauling Report.<br>
								<span class="glyphicon glyphicon-exclamation-sign" aria-hidden="true"></span>
								If you use the SAVE & SEND EMAIL button you save the Hauling Report and sent the email to the subcontractor and to <strong>info@v-contracting.ca</strong>.
							</div>
						</div>

												
						<div class="form-group">
							<div class="row" align="center">
								<div style="width:80%;" align="center">
									<div id="div_load" style="display:none">		
										<div class="progress progress-striped active">
											<div class="progress-bar" role="progressbar" aria-valuenow="45" aria-valuemin="0" aria-valuemax="100" style="width: 45%">
												<span class="sr-only">45% completado</span>
											</div>
										</div>
									</div>
									<div id="div_error" style="display:none">			
										<div class="alert alert-danger"><span class="glyphicon glyphicon-remove" id="span_msj">&nbsp;</span></div>
									</div>
								</div>
							</div>
						</div>
					</form>
<?php		
	}
?>
					<!-- /.row (nested) -->
				</div>
				<!-- /.panel-body -->
			</div>
			<!-- /.panel -->
		</div>
		<!-- /.col-lg-12 -->
	</div>
	<!-- /.row -->
</div>
<!-- /#page-wrapper -->