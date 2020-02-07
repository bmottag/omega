<script type="text/javascript" src="<?php echo base_url("assets/js/validate/workorder/workorder_v4.js"); ?>"></script>

<link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>


<script>
$(function(){ 
	
	$(".btn-warning").click(function () {	
			var oID = $(this).attr("id");
            $.ajax ({
                type: 'POST',
				url: base_url + '/workorders/cargarModalPersonal',
                data: {'idWorkorder': oID},
                cache: false,
                success: function (data) {
                    $('#tablaDatos').html(data);
                }
            });
	});	
	
	$(".btn-success").click(function () {	
			var oID = $(this).attr("id");
            $.ajax ({
                type: 'POST',
				url: base_url + '/workorders/cargarModalMaterials',
                data: {'idWorkorder': oID},
                cache: false,
                success: function (data) {
                    $('#tablaDatosMaterial').html(data);
                }
            });
	});	
	
	$(".btn-info").click(function () {	
			var oID = $(this).attr("id");
            $.ajax ({
                type: 'POST',
				url: base_url + '/workorders/cargarModalEquipment',
                data: {'idWorkorder': oID},
                cache: false,
                success: function (data) {
                    $('#tablaDatosEquipment').html(data);
                }
            });
	});	
	
	$(".btn-primary").click(function () {	
			var oID = $(this).attr("id");
			//verificar que se este enviando el 
			if(oID != 'btnSubmit'){
				$.ajax ({
					type: 'POST',
					url: base_url + '/workorders/cargarModalOcasional',
					data: {'idWorkorder': oID},
					cache: false,
					success: function (data) {
						$('#tablaDatosOcasional').html(data);
					}
				});
			}
	});	

});
</script>

<div id="page-wrapper">
	<br>
	
	<!-- /.row -->
	<div class="row">
		<div class="col-lg-12">
			<div class="panel panel-primary">
				<div class="panel-heading">
				
					<?php
					$userRol = $this->session->rol;
					if($userRol == 99){ //If it is a SUPER ADMIN user, show GO BACK MENU
					?>
					<a class="btn btn-default btn-xs" href=" <?php echo base_url().'workorders/search/y'; ?> "><span class="glyphicon glyphicon glyphicon-chevron-left" aria-hidden="true"></span> Go back </a> 
					<?php } ?>
				
					<i class="fa fa-money"></i> <strong>WORK ORDERS</strong>
				</div>
				<div class="panel-body">

					<?php
					if($userRol == 99 && $information){ //If it is a SUPER ADMIN user, show GO BACK MENU
					?>				
					<ul class="nav nav-pills">
						<li class='active'><a href="<?php echo base_url('workorders/add_workorder/' . $information[0]["id_workorder"]) ?>">Edit</a>
						</li>
						<li><a href="<?php echo base_url('workorders/view_workorder/' . $information[0]["id_workorder"]) ?>">Asign rate</a>
						</li>
						<li><a href="<?php echo base_url('workorders/generaWorkOrderPDF/' . $information[0]["id_workorder"]) ?>" target="_blank">Download invoice</a>
						</li>
					</ul>
					<br>
					<?php } ?>

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
	if($information)
	{ 
			switch ($information[0]['state']) {
					case 0:
							$valor = 'On field';
							$clase = "alert-danger";
							break;
					case 1:
							$valor = 'In Progress';
							$clase = "alert-warning";
							break;
					case 2:
							$valor = 'Revised';
							$clase = "alert-info";
							break;
					case 3:
							$valor = 'Send to the client';
							$clase = "alert-success";
							break;
					case 4:
							$valor = 'Closed';
							$clase = "alert-danger";
							break;
			}
?>
		<div class="col-lg-12">	
			<div class="alert <?php echo $clase; ?>">
				<span class="glyphicon glyphicon-exclamation-sign" aria-hidden="true"></span>
				Actual state: <strong><?php echo $valor; ?></strong>
			</div>
		</div>
						
<?php } ?>


							<form  name="form" id="form" class="form-horizontal" method="post"  >
								<input type="hidden" id="hddIdentificador" name="hddIdentificador" value="<?php echo $information?$information[0]["id_workorder"]:""; ?>"/>										
																																		
								<div class="form-group">
<script>
	$( function() {
		$( "#date" ).datepicker({
			changeMonth: true,
			dateFormat: 'yy-mm-dd'
		});
	});
</script>
									<label class="col-sm-4 control-label" for="hddTask">Date Work Order :</label>
									<div class="col-sm-5">
										<input type="text" class="form-control" id="date" name="date" value="<?php echo $information?$information[0]["date"]:""; ?>" placeholder="Date" required <?php echo $deshabilitar; ?> />
									</div>
								</div>
								
								<div class="form-group">
									<label class="col-sm-4 control-label" for="taskDescription">Job Code/Name :</label>
									<div class="col-sm-5">
										<select name="jobName" id="jobName" class="form-control" <?php echo $deshabilitar; ?>>
											<option value=''>Select...</option>
											<?php for ($i = 0; $i < count($jobs); $i++) { ?>
												<option value="<?php echo $jobs[$i]["id_job"]; ?>" <?php if($information[0]["fk_id_job"] == $jobs[$i]["id_job"]) { echo "selected"; }  ?>><?php echo $jobs[$i]["job_description"]; ?></option>	
											<?php } ?>
										</select>								
									</div>
								</div>
<?php if($information){ ?>

								<div class="form-group text-danger">
									<label class="col-sm-4 control-label" for="company">Specify the client if you know it :</label>
									<div class="col-sm-5">
										<select name="company" id="company" class="form-control" <?php echo $deshabilitar; ?>>
											<option value=''>Select...</option>
											<?php for ($i = 0; $i < count($companyList); $i++) { ?>
												<option value="<?php echo $companyList[$i]["id_company"]; ?>" <?php if($information[0]["fk_id_company"] == $companyList[$i]["id_company"]) { echo "selected"; }  ?>><?php echo $companyList[$i]["company_name"]; ?></option>	
											<?php } ?>
										</select>							
									</div>
								</div>
								
								<div class="form-group text-danger">
									<label class="col-sm-4 control-label" for="foreman">Foreman name : </label>
									<div class="col-sm-5">
										<input type="text" id="foreman" name="foreman" class="form-control" placeholder="Foreman name" value="<?php echo $information?$information[0]["foreman_name_wo"]:""; ?>" <?php echo $deshabilitar; ?>>
									</div>
								</div>

								<div class="form-group text-danger">
									<label class="col-sm-4 control-label" for="email">Foreman email : </label>
									<div class="col-sm-5">
										<input type="text" id="email" name="email" class="form-control" placeholder="Foreman email" value="<?php echo $information?$information[0]["foreman_email_wo"]:""; ?>" <?php echo $deshabilitar; ?>>
									</div>
								</div>

								<div class="form-group">
									<label class="col-sm-4 control-label" for="taskDescription">Task description :</label>
									<div class="col-sm-5">
									<textarea id="observation" name="observation" class="form-control" rows="3" <?php echo $deshabilitar; ?> placeholder="Task description"><?php echo $information?$information[0]["observation"]:""; ?></textarea>
									</div>
								</div>
																
<?php } ?>
								
								<?php if(!$deshabilitar){ ?>
								<div class="form-group">
									<div class="row" align="center">
										<div style="width:100%;" align="center">

											<button type="button" id="btnSubmit" name="btnSubmit" class="btn btn-primary" >
												Save <span class="glyphicon glyphicon-floppy-disk" aria-hidden="true">
											</button> 

<?php if($information){ ?>

<?php if($information[0]["fk_id_company"] != "" && $information[0]["fk_id_company"] != 0 && $workorderEquipment) { ?>

											<button type="button" id="btnEmail" name="btnEmail" class="btn btn-danger" >
												Save & Send Email <span class="glyphicon glyphicon-send" aria-hidden="true">
											</button>
											
<?php } ?>
											
<?php if($information[0]['signature_wo']){ ?>

<button type="button" class="btn btn-default" data-toggle="modal" data-target="#<?php echo $information[0]['id_workorder'] . "wModal"; ?>" id="<?php echo $information[0]['id_workorder']; ?>">
	<span class="glyphicon glyphicon-eye-open" aria-hidden="true"></span> View Signature
</button>

<div id="<?php echo $information[0]['id_workorder'] . "wModal"; ?>" class="modal fade" role="dialog">  
	<div class="modal-dialog">
		<div class="modal-content">      
			<div class="modal-header">        
				<button type="button" class="close" data-dismiss="modal">×</button>        
				<h4 class="modal-title">Foreman signature</h4>      </div>      
			<div class="modal-body text-center"><img src="<?php echo base_url($information[0]['signature_wo']); ?>" class="img-rounded" alt="Foreman signature" width="304" height="236" />   </div>      
			<div class="modal-footer">    
				<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>     
			</div>  
		</div>  
	</div>
</div>

<?php } ?>
				
<!-- enlace para firma -->				
<a href="<?php echo base_url("workorders/add_signature/" . $information[0]['id_workorder']); ?>" class="btn btn-default"> 
	<span class="glyphicon glyphicon-edit" aria-hidden="true"></span> Signature
</a>
											
<?php } ?>
											
										</div>
									</div>
								</div>
								<?php } ?>
								
						<div class="col-lg-12">	
							<div class="alert alert-danger ">
								<span class="glyphicon glyphicon-exclamation-sign" aria-hidden="true"></span>
								In order to save/send an email of the WO, the user needs to specefy whom the client is and what equipment was used.<br>
								<span class="glyphicon glyphicon-exclamation-sign" aria-hidden="true"></span>
								An email copy of this WO will be sent to the client, the foreman's email (when provided) and also to <strong>hugo@v-contracting.com</strong>.
							</div>
						</div>
								
							</form>
								

					<!-- /.row (nested) -->
				</div>
				<!-- /.panel-body -->
			</div>
			<!-- /.panel -->
		</div>
		<!-- /.col-lg-12 -->
	</div>
	<!-- /.row -->
	

	
<!--INICIO FORMULARIOS -->								
<?php 
if($information){ 
?>

<!--INICIO ADDITIONAL INFORMATION -->
	<!-- /.row -->
	<div class="row">
		<div class="col-lg-6">				
			<div class="panel panel-primary">
				<div class="panel-heading">
					ADDITIONAL INFORMATION <br>
					This field is only additional information for the office.
				</div>
				<div class="panel-body">
				
						<div class="col-lg-12">	
							<form name="formState" id="formState" class="form-horizontal" method="post">
								<input type="hidden" id="hddIdWorkOrder" name="hddIdWorkOrder" value="<?php echo $information?$information[0]["id_workorder"]:""; ?>"/>										
																				
								<div class="form-group">
									<label class="col-sm-4 control-label" for="state">State :</label>
									<div class="col-sm-8">
										<select name="state" id="state" class="form-control" required >
											<option value="">Select...</option>
											<option value=0 >On field</option>
											<option value=1 >In Progress</option>
											<option value=2 >Revised</option>
											<option value=3 >Send to the client</option>
											<option value=4 >Closed</option>
										</select>
									</div>
								</div>
								
								<div class="form-group">
									<label class="col-sm-4 control-label" for="information">Additional information :</label>
									<div class="col-sm-8">
									<textarea id="information" name="information" class="form-control" rows="3" placeholder="Additional information" required></textarea>
									</div>
								</div>
								
								<div class="form-group">
									<div class="row" align="center">
										<div style="width:100%;" align="center">

											<button type="button" id="btnState" name="btnState" class="btn btn-primary" >
												Save <span class="glyphicon glyphicon-floppy-disk" aria-hidden="true">
											</button> 
											
										</div>
									</div>
								</div>
																
							</form>
							
							<div class="alert alert-danger ">
								<span class="glyphicon glyphicon-exclamation-sign" aria-hidden="true"></span>
								Be sure you fild all the information.
							</div>
							
						</div>

				</div>
			</div>
		</div>
		
		<div class="col-lg-6">	
			<div class="chat-panel panel panel-primary">
				<div class="panel-heading">
					<i class="fa fa-comments fa-fw"></i> State history
				</div>
				<!-- /.panel-heading -->
				<div class="panel-body">
					<ul class="chat">
<?php 
	if($workorderState)
	{
		foreach ($workorderState as $data):		

			switch ($data['state']) {
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
?>
			<li class="right clearfix">
				<span class="chat-img pull-right">
					<small class="pull-right text-muted">
						<i class="fa fa-clock-o fa-fw"></i> <?php echo $data['date_issue']; ?>
					</small>
				</span>
				<div class="chat-body clearfix">
					<div class="header">
						<span class="glyphicon glyphicon-user" aria-hidden="true"></span>
						<strong class="primary-font"><?php echo $data['first_name']; ?></strong>
					</div>
					<p>
						<?php echo $data['observation']; ?>
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
		
		
	</div>
	<!-- /.row -->
<!--FIN ADDITIONAL INFORMATION -->

	
<!--INICIO PERSONAL -->
	<!-- /.row -->
	<div class="row">
		<div class="col-lg-12">				
			<div class="panel panel-warning">
				<div class="panel-heading">
					PERSONAL
				</div>
				<div class="panel-body">
				
				<?php if(!$deshabilitar){ ?>
					<div class="col-lg-12">	
												
					<button type="button" class="btn btn-warning btn-block" data-toggle="modal" data-target="#modal" id="<?php echo $information[0]["id_workorder"]; ?>">
							<span class="glyphicon glyphicon-plus" aria-hidden="true"></span> Add Personal
					</button><br>
					</div>
				<?php } ?>

<?php 
	if($workorderPersonal){
?>
			<table class="table table-bordered table-striped table-hover table-condensed">
				<tr class="warning">
					<td><p class="text-center"><strong>Employee Name</strong></p></td>
					<td><p class="text-center"><strong>Employee Type</strong></p></td>
					<td><p class="text-center"><strong>Task Description</strong></p></td>
					<td><p class="text-center"><strong>Hours</strong></p></td>
					<td><p class="text-center"><strong>Links</strong></p></td>
				</tr>
				<?php
					foreach ($workorderPersonal as $data):
						echo "<tr>";					
						echo "<td ><small>" . $data['name'] . "</small></td>";
						echo "<td ><small>" . $data['employee_type'] . "</small></td>";
						
						$idRecord = $data['id_workorder_personal'];
				?>				
						<form  name="personal_<?php echo $idRecord ?>" id="personal_<?php echo $idRecord ?>" method="post" action="<?php echo base_url("workorders/save_hour"); ?>">
						<input type="hidden" id="formType" name="formType" value="personal"/>
						<input type="hidden" id="hddId" name="hddId" value="<?php echo $idRecord; ?>"/>
						<input type="hidden" id="hddIdWorkOrder" name="hddIdWorkOrder" value="<?php echo $data['fk_id_workorder']; ?>"/>
						<input type="hidden" id="rate" name="rate" value="<?php echo $data['rate']; ?>"/>
						<input type="hidden" id="quantity" name="quantity" value=1 >
						
						<td>
						<textarea id="description" name="description" class="form-control" rows="3" required><?php echo $data['description']; ?></textarea>
						</td>
						
						<td>
						<input type="text" id="hours" name="hours" class="form-control" placeholder="Hours" value="<?php echo $data['hours']; ?>" required >
						</td>
						
						<td class='text-center'>
							<input type="submit" id="btnSubmit" name="btnSubmit" value="Save" class="btn btn-primary btn-xs" <?php echo $deshabilitar; ?>/>
						</form>
						
						<br><br>
							<?php if(!$deshabilitar){ ?>
							<a class='btn btn-danger btn-xs' href='<?php echo base_url('workorders/deleteRecord/personal/' . $data['id_workorder_personal'] . '/' . $data['fk_id_workorder'] . '/add_workorder') ?>' id="btn-delete">
									<span class="glyphicon glyphicon-remove" aria-hidden="true"> </span>  Delete
							</a>
							<?php }else{ echo "---";} ?>
							</td>
						</tr>
				<?php
					endforeach;
				?>
			</table>
	<?php } ?>
				</div>
			</div>
		</div>
	</div>
	<!-- /.row -->
<!--FIN PERSONAL -->


<!--INICIO MATERIALS -->
	<!-- /.row -->
	<div class="row">
		<div class="col-lg-12">				
			<div class="panel panel-success">
				<div class="panel-heading">
					MATERIALS
				</div>
				<div class="panel-body">
				<?php if(!$deshabilitar){ ?>
					<div class="col-lg-12">	
												
					<button type="button" class="btn btn-success btn-block" data-toggle="modal" data-target="#modalMaterials" id="<?php echo 'material-' . $information[0]["id_workorder"];//se coloca un ID diferente para que no entre en conflicto con los otros modales ?>">
							<span class="glyphicon glyphicon-plus" aria-hidden="true"></span> Add Materials
					</button><br>
					</div>
				<?php } ?>

<?php 
	if($workorderMaterials){
?>
			<table class="table table-bordered table-striped table-hover table-condensed">
				<tr class="success">
					<td><p class="text-center"><strong>Info. Material</strong></p></td>
					<td><p class="text-center"><strong>Description</strong></p></td>
					<td><p class="text-center"><strong>Quantity</strong></p></td>
					<td><p class="text-center"><strong>Unit</strong></p></td>
					<td><p class="text-center"><strong>Links</strong></p></td>
				</tr>
				<?php
					foreach ($workorderMaterials as $data):
						echo "<tr>";					
						echo "<td ><small><strong>Material</strong><br>" . $data['material'] . "</small></td>";
						
						$idRecord = $data['id_workorder_materials'];
				?>
						<form  name="material_<?php echo $idRecord ?>" id="material_<?php echo $idRecord ?>" method="post" action="<?php echo base_url("workorders/save_hour"); ?>">
							<input type="hidden" id="formType" name="formType" value="materials"/>
							<input type="hidden" id="hddId" name="hddId" value="<?php echo $idRecord; ?>"/>
							<input type="hidden" id="hddIdWorkOrder" name="hddIdWorkOrder" value="<?php echo $data['fk_id_workorder']; ?>"/>
							<input type="hidden" id="rate" name="rate" value="<?php echo $data['rate']; ?>"/>
							<input type="hidden" id="hours" name="hours" value=1 >						
							
						<td>
							<textarea id="description" name="description" class="form-control" rows="3" required><?php echo $data['description']; ?></textarea>
						</td>
							
						<td>
							<input type="text" id="quantity" name="quantity" class="form-control" placeholder="Quantity" value="<?php echo $data['quantity']; ?>" required >		
						</td>
						
						<td>
							<input type="text" id="unit" name="unit" class="form-control" placeholder="Unit" value="<?php echo $data['unit']; ?>" required >		
						</td>
										
						<td class='text-center'>
							<input type="submit" id="btnSubmit" name="btnSubmit" value="Save" class="btn btn-primary btn-xs" <?php echo $deshabilitar; ?>/>
							
						</form>
						
						<br><br>
							<?php if(!$deshabilitar){ ?>
							<a class='btn btn-danger btn-xs' href='<?php echo base_url('workorders/deleteRecord/materials/' . $data['id_workorder_materials'] . '/' . $data['fk_id_workorder'] . '/add_workorder') ?>' id="btn-delete">
									<span class="glyphicon glyphicon-remove" aria-hidden="true"> </span>  Delete
							</a>
							<?php }else{ echo "---";} ?>

						</td>
						
						</tr>
				<?php
					endforeach;
				?>
			</table>
	<?php } ?>
				</div>
			</div>
		</div>
	</div>
	<!-- /.row -->
<!--FIN MATERIALS -->


<!--INICIO EQUIPMENT -->
	<!-- /.row -->
	<div class="row">
		<div class="col-lg-12">				
			<div class="panel panel-info">
				<div class="panel-heading">
					EQUIPMENT
				</div>
				<div class="panel-body">
				<?php if(!$deshabilitar){ ?>
					<div class="col-lg-12">	
												
					<button type="button" class="btn btn-info btn-block" data-toggle="modal" data-target="#modalEquipment" id="<?php echo 'equipment-' . $information[0]["id_workorder"];//se coloca un ID diferente para que no entre en conflicto con los otros modales ?>">
							<span class="glyphicon glyphicon-plus" aria-hidden="true"></span> Add Equipment
					</button><br>
					</div>
				<?php } ?>

<?php 
	if($workorderEquipment){
?>
			<table class="table table-bordered table-striped table-hover table-condensed">
				<tr class="info">
					<td><p class="text-center"><strong>Info. Equipment</strong></p></td>
					<td><p class="text-center"><strong>Description</strong></p></td>
					<td><p class="text-center"><strong>Hours</strong></p></td>
					<td><p class="text-center"><strong>Quantity</strong></p></td>
					<td><p class="text-center"><strong>Links</strong></p></td>
				</tr>
				<?php
					foreach ($workorderEquipment as $data):
						echo "<tr>";
						echo "<td ><small><strong>Type</strong><br>" . $data['type_2'] . "</small>";
						//si es tipo miscellaneous -> 8, entonces la description es diferente
						if($data['fk_id_type_2'] == 8){
							$equipment = $data['miscellaneous'] . " - " . $data['other'];
						}else{
							$equipment = $data['unit_number'] . " - " . $data['v_description'];
						}
						
						echo "<br><small><strong>Equipment</strong><br>" . $equipment . "</small>";
						echo "<br><small><strong>Operated by</strong><br>" . $data['operatedby'] . "</small>";
						echo "</td>";
						
						$idRecord = $data['id_workorder_equipment'];
				?>
						<form  name="equipment_<?php echo $idRecord ?>" id="equipment_<?php echo $idRecord ?>" method="post" action="<?php echo base_url("workorders/save_hour"); ?>">
							<input type="hidden" id="formType" name="formType" value="equipment"/>
							<input type="hidden" id="hddId" name="hddId" value="<?php echo $idRecord; ?>"/>
							<input type="hidden" id="hddIdWorkOrder" name="hddIdWorkOrder" value="<?php echo $data['fk_id_workorder']; ?>"/>
							<input type="hidden" id="rate" name="rate" value="<?php echo $data['rate']; ?>"/>
							
						<td>
							<textarea id="description" name="description" class="form-control" rows="3" required><?php echo $data['description']; ?></textarea>
						</td>
							
						<td>
							<input type="text" id="hours" name="hours" class="form-control" placeholder="Hours" value="<?php echo $data['hours']; ?>" required >
						</td>
						<td>
							<input type="text" id="quantity" name="quantity" class="form-control" placeholder="Quantity" value="<?php echo $data['quantity']; ?>" required >
						</td>

						<td class='text-center'>
							<input type="submit" id="btnSubmit" name="btnSubmit" value="Save" class="btn btn-primary btn-xs" <?php echo $deshabilitar; ?>/>
							
						</form>			

						<br><br>
							<?php if(!$deshabilitar){ ?>
							<a class='btn btn-danger btn-xs' href='<?php echo base_url('workorders/deleteRecord/equipment/' . $data['id_workorder_equipment'] . '/' . $data['fk_id_workorder'] . '/add_workorder') ?>' id="btn-delete">
									<span class="glyphicon glyphicon-remove" aria-hidden="true"> </span>  Delete
							</a>
							<?php }else{ echo "---";} ?>
				
						</td>
						</tr>
				<?php
					endforeach;
				?>
			</table>
	<?php } ?>
				</div>
			</div>
		</div>
	</div>
	<!-- /.row -->
<!--FIN EQUIPMENT -->

	
<!--INICIO OCASIONAL SUBCONTRACTOR -->
	<!-- /.row -->
	<div class="row">
		<div class="col-lg-12">				
			<div class="panel panel-primary">
				<div class="panel-heading">
					OCASIONAL SUBCONTRACTOR
				</div>
				<div class="panel-body">
				<?php if(!$deshabilitar){ ?>
					<div class="col-lg-12">	
												
					<button type="button" class="btn btn-primary btn-block" data-toggle="modal" data-target="#modalOcasional" id="<?php echo 'ocasional-' . $information[0]["id_workorder"];//se coloca un ID diferente para que no entre en conflicto con los otros modales ?>">
							<span class="glyphicon glyphicon-plus" aria-hidden="true"></span> Add Ocasional Subcontractor
					</button><br>
					
					</div>
				<?php } ?>

<?php 
	if($workorderOcasional){
?>
			<table class="table table-bordered table-striped table-hover table-condensed">
				<tr class="primary">
					<td><p class="text-center"><strong>Info. Subcontractor</strong></p></td>
					<td><p class="text-center"><strong>Description</strong></p></td>
					<td><p class="text-center"><strong>Quantity</strong></p></td>
					<td><p class="text-center"><strong>Unit</strong></p></td>
					<td><p class="text-center"><strong>Hours</strong></p></td>
					<td><p class="text-center"><strong>Links</strong></p></td>
				</tr>
				<?php
					foreach ($workorderOcasional as $data):
						echo "<tr>";					
						echo "<td ><small><strong>Company</strong><br>" . $data['company_name'] . "</small>";
						echo "<br><small><strong>Equipment</strong><br>" . $data['equipment'] . "</small>";
						echo "<br><small><strong>Contact</strong><br>" . $data['contact'] . "</small></td>";
						
						$idRecord = $data['id_workorder_ocasional'];
				?>
						<form  name="ocasional_<?php echo $idRecord ?>" id="ocasional_<?php echo $idRecord ?>" method="post" action="<?php echo base_url("workorders/save_hour"); ?>">
							<input type="hidden" id="formType" name="formType" value="ocasional"/>
							<input type="hidden" id="hddId" name="hddId" value="<?php echo $idRecord; ?>"/>
							<input type="hidden" id="hddIdWorkOrder" name="hddIdWorkOrder" value="<?php echo $data['fk_id_workorder']; ?>"/>
							<input type="hidden" id="rate" name="rate" value="<?php echo $data['rate']; ?>"/>
						
						<td>
							<textarea id="description" name="description" class="form-control" rows="3" required><?php echo $data['description']; ?></textarea>
						</td>
						
						<td>
							<input type="text" id="quantity" name="quantity" class="form-control" placeholder="Quantity" value="<?php echo $data['quantity']; ?>" required >
						</td>

						<td>
							<input type="text" id="unit" name="unit" class="form-control" placeholder="Unit" value="<?php echo $data['unit']; ?>" required >
						</td>
				
						<td>
							<input type="text" id="hours" name="hours" class="form-control" placeholder="Hours" value="<?php echo $data['hours']; ?>" required >
						</td>

						<td class='text-center'>
							<input type="submit" id="btnSubmit" name="btnSubmit" value="Save" class="btn btn-primary btn-xs" <?php echo $deshabilitar; ?>/>
							
						</form>
						
						<br><br>
							<?php if(!$deshabilitar){ ?>
							<a class='btn btn-danger btn-xs' href='<?php echo base_url('workorders/deleteRecord/ocasional/' . $data['id_workorder_ocasional'] . '/' . $data['fk_id_workorder'] . '/add_workorder') ?>' id="btn-delete">
									<span class="glyphicon glyphicon-remove" aria-hidden="true"> </span>  Delete
							</a>
							<?php }else{ echo "---";} ?>
				
						</td>
						</tr>
				<?php
					endforeach;
				?>
			</table>
<?php } ?>
				</div>
			</div>
		</div>
	</div>
	<!-- /.row -->
<!--FIN OCASIONAL SUBCONTRACTOR -->





<?php } ?>
	
	
</div>
<!-- /#page-wrapper -->







<!--INICIO Modal para PERSONAL -->
<div class="modal fade text-center" id="modal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">    
	<div class="modal-dialog" role="document">
		<div class="modal-content" id="tablaDatos">

		</div>
	</div>
</div>                       
<!--FIN Modal para PERSONAL -->


<!--INICIO Modal para MATERIAL -->
<div class="modal fade text-center" id="modalMaterials" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">    
	<div class="modal-dialog" role="document">
		<div class="modal-content" id="tablaDatosMaterial">

		</div>
	</div>
</div>                       
<!--FIN Modal para MATERIAL -->

<!--INICIO Modal para EQUIPMENT -->
<div class="modal fade text-center" id="modalEquipment" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">    
	<div class="modal-dialog" role="document">
		<div class="modal-content" id="tablaDatosEquipment">

		</div>
	</div>
</div>                       
<!--FIN Modal para EQUIPMENT -->

<!--INICIO Modal para OCASIONAL-->
<div class="modal fade text-center" id="modalOcasional" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">    
	<div class="modal-dialog" role="document">
		<div class="modal-content" id="tablaDatosOcasional">

		</div>
	</div>
</div>                       
<!--FIN Modal para OCASIONAL -->