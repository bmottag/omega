<script>
$(function(){ 

	$(".btn-default").click(function () {	
			var oID = $(this).attr("id");
			
			//Activa icono guardando
			if(window.confirm('Are you sure you want to load the general configuration data?'))
			{
					$(".btn-default").attr('disabled','-1');
					$.ajax ({
						type: 'POST',
						url: base_url + 'workorders/load_prices_wo',
						data: {'identificador': oID},
						cache: false,
						success: function(data){
												
							if( data.result == "error" )
							{
								alert(data.mensaje);
								$(".btn-default").removeAttr('disabled');							
								return false;
							} 
											
							if( data.result )//true
							{	                                                        
								$(".btn-default").removeAttr('disabled');

								var url = base_url + "workorders/view_workorder/" + data.idWO
								$(location).attr("href", url);
							}
							else
							{
								alert('Error. Reload the web page.');
								$(".btn-default").removeAttr('disabled');
							}	
						},
						error: function(result) {
							alert('Error. Reload the web page.');
							$(".btn-default").removeAttr('disabled');
						}

					});
			}
	});
	
	$(".btn-amarello").click(function () {	
			var oID = $(this).attr("id");
			
			//Activa icono guardando
			if(window.confirm('Are you sure you want to load the Markup?'))
			{
					$(".btn-amarello").attr('disabled','-1');
					$.ajax ({
						type: 'POST',
						url: base_url + 'workorders/load_markup_wo',
						data: {'identificador': oID},
						cache: false,
						success: function(data){
												
							if( data.result == "error" )
							{
								alert(data.mensaje);
								$(".btn-amarello").removeAttr('disabled');							
								return false;
							} 
											
							if( data.result )//true
							{	                                                        
								$(".btn-amarello").removeAttr('disabled');

								var url = base_url + "workorders/view_workorder/" + data.idWO
								$(location).attr("href", url);
							}
							else
							{
								alert('Error. Reload the web page.');
								$(".btn-amarello").removeAttr('disabled');
							}	
						},
						error: function(result) {
							alert('Error. Reload the web page.');
							$(".btn-amarello").removeAttr('disabled');
						}

					});
			}
	});

	$(".btn-dark").click(function () {	
			var oID = $(this).attr("id");
            $.ajax ({
                type: 'POST',
				url: base_url + 'workorders/cargarModalExpense',
                data: {'idWorkorder': oID},
                cache: false,
                success: function (data) {
                    $('#tablaDatosExpense').html(data);
                }
            });
	});	

	$(".btn-warning").click(function () {	
			var oID = $(this).attr("id");
            $.ajax ({
                type: 'POST',
				url: base_url + 'workorders/cargarModalPersonal',
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
				url: base_url + 'workorders/cargarModalMaterials',
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
				url: base_url + 'workorders/cargarModalEquipment',
                data: {'idWorkorder': oID},
                cache: false,
                success: function (data) {
                    $('#tablaDatosEquipment').html(data);
                }
            });
	});	
	
	$(".btn-primary").click(function () {	
			var oID = $(this).attr("id");
            $.ajax ({
                type: 'POST',
				url: base_url + 'workorders/cargarModalOcasional',
                data: {'idWorkorder': oID},
                cache: false,
                success: function (data) {
                    $('#tablaDatosOcasional').html(data);
                }
            });
	});	
	
	$(".btn-purpura").click(function () {	
			var oID = $(this).attr("id");
            $.ajax ({
                type: 'POST',
				url: base_url + 'workorders/cargarModalHoldBack',
                data: {'idWorkorder': oID},
                cache: false,
                success: function (data) {
                    $('#tablaDatosHoldBack').html(data);
                }
            });
	});

	$(".btn-violeta").click(function () {	
			var oID = $(this).attr("id");
            $.ajax ({
                type: 'POST',
				url: base_url + 'workorders/cargarModalReceipts',
                data: {'idWorkorder': oID},
                cache: false,
                success: function (data) {
                    $('#tablaDatosReceipt').html(data);
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
					<a class="btn btn-gris btn-xs" href=" <?php echo base_url().'workorders/search/y'; ?> "><span class="glyphicon glyphicon glyphicon-chevron-left" aria-hidden="true"></span> Go back </a> 
					<i class="fa fa-money"></i> <strong>WORK ORDERS</strong>
				</div>
				<div class="panel-body">
				
					<ul class="nav nav-pills">
						<li><a href="<?php echo base_url('workorders/add_workorder/' . $information[0]["id_workorder"]) ?>">Edit</a>
						</li>
						<li class='active'><a href="<?php echo base_url('workorders/view_workorder/' . $information[0]["id_workorder"]) ?>">Asign rate</a>
						</li>
						<li><a href="<?php echo base_url('workorders/generaWorkOrderPDF/' . $information[0]["id_workorder"]) ?>" target="_blank">Download invoice</a>
						</li>
					</ul>
					<br>

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
	<div class="row">
		<div class="col-lg-12">	
			<div class="alert <?php echo $clase; ?>">
				<span class="glyphicon glyphicon-exclamation-sign" aria-hidden="true"></span>
				This work order is <strong><?php echo $valor; ?></strong>
			</div>
		</div>
	</div>
						
<?php } ?>

					<div class="row">
						<div class="col-lg-12">								
							<div class="alert alert-info">
								<span class='fa fa-money' aria-hidden='true'></span>
								<strong>Work Order #: </strong><?php echo $information[0]["id_workorder"]; ?>
								<br><span class='fa fa-clock-o' aria-hidden='true'></span> <strong>Work Order Date: </strong><?php echo $information[0]["date"]; ?>
								<br><span class="fa fa-briefcase" aria-hidden="true"></span> <strong>Job Code/Name: </strong><?php echo $information[0]["job_description"]; ?>
								<?php if($information[0]["notes"]){ ?>
								<br><strong>Job Code/Name - Notes: </strong><?php echo $information[0]["notes"]; ?>
								<?php } ?>
								<br><strong>Markup: </strong><?php echo $information[0]["markup"] . '%'; ?>
								<br><strong>Supervisor: </strong><?php echo $information[0]["name"]; ?>
								<br><strong>Observation: </strong><?php echo $information[0]["observation"]; ?>
								
								<br><br>
								<span class="glyphicon glyphicon-alert" aria-hidden="true"></span>
								Update Rates from the following button. <small>(Update the rate field on PERSONAL, MATERIALS and EQUIPMENT) </small>
								<button type="button" id="<?php echo $information[0]["id_workorder"]; ?>" class='btn btn-default btn-xs' title="Update" <?php echo $deshabilitar; ?>>
										Update Rates <i class="fa fa-refresh"></i>
								</button>

								<?php if($information[0]["markup"] > 0){ ?>
								<br><br>
								<span class="glyphicon glyphicon-alert" aria-hidden="true"></span>
								Update Job Code/Name Markup button. <small>(Update the Markup field on MATERIALS, RECEIPT and OCASIONAL) </small>
								<button type="button" id="<?php echo $information[0]["id_workorder"]; ?>" class='btn btn-amarello btn-xs' title="Update" <?php echo $deshabilitar; ?>>
										Update Markup <i class="fa fa-refresh"></i>
								</button>
								<?php } ?>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>

<!--INICIO FORMULARIOS -->								
<?php if($information){ ?>

<!--INICIO WO EXPENSE -->
<?php 
	$userRol = $this->session->userdata("rol");
	if($userRol == 99){ 
?>
<div class="row">
		<div class="col-lg-12">				
			<div class="panel panel-dark">
				<div class="panel-heading">
					WO EXPENSE
				</div>
				<div class="panel-body">
				
				<?php if(!$deshabilitar){ ?>
					<div class="col-lg-12">	
						<div class="panel panel-default">
							<div class="panel-footer">
								<div class="row">
									<div class="col-lg-6">
										<label class="control-label"><b>Total Income for this W.O.:</b> $<?php echo number_format($totalWOIncome, 2); ?></label>
									</div>
								</div>
							</div>
						</div>
					
						<button type="button" class="btn btn-dark btn-block" data-toggle="modal" data-target="#modalExpense" id="<?php echo $information[0]["id_workorder"]; ?>">
								<span class="glyphicon glyphicon-plus" aria-hidden="true"></span> Add WO Expense
						</button><br>
					</div>
				<?php } ?>

<?php 
	if($workorderExpense){
?>
			<table class="table table-bordered table-striped table-hover table-condensed">
				<tr class="default">
					<th class="text-center">Chapter</th>
					<th class="text-center">Item</th>
					<th class="text-center">Description</th>
					<th class="text-center">Weight in the project (%)</th>
					<th class="text-center">Expense Value</th>
					<th class="text-center">Delete</th>
				</tr>
				<?php
					foreach ($workorderExpense as $data):
						echo "<tr>";					
						echo "<td ><small>" . $data['chapter_name'] . "</small></td>";
						echo "<td ><small>" . $data['chapter_number'] . "." . $data['item'] . "</small></td>";
						echo "<td ><small>" . $data['description'] . "</small></td>";
						echo "<td class='text-right'><small>" . $data['percentage'] . "%</small></td>";
						echo "<td class='text-right'><small>$" . number_format($data['expense_value'],2) . "</small></td>";
						
						$idRecord = $data['id_workorder_expense'];
				?>				
							<td class='text-center'>					
							<?php if(!$deshabilitar){ ?>
							<a class='btn btn-danger btn-xs' href='<?php echo base_url('workorders/deleteRecord/expense/' . $data['id_workorder_expense'] . '/' . $data['fk_id_workorder'] . '/view_workorder') ?>' id="btn-delete">
								<i class="fa fa-trash-o"></i> 
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
<?php 
	}
?>
<!--FIN WO EXPENSE -->
	
<!--INICIO PERSONAL -->
	<div class="row">
								<div class="col-lg-12">				
									<div class="panel panel-warning">
										<div class="panel-heading">
											PERSONAL
										</div>
										<div class="panel-body">
											<div class="col-lg-12">	
			
					<?php if(!$deshabilitar){ ?>
					<button type="button" class="btn btn-warning btn-block" data-toggle="modal" data-target="#modal" id="<?php echo $information[0]["id_workorder"]; ?>">
							<span class="glyphicon glyphicon-plus" aria-hidden="true"></span> Add Personal
					</button><br>
					<?php } ?>
											</div>
<?php 										
	if(!$workorderPersonal){ 
		echo '<div class="col-lg-12">
				<small>
				<p class="text-danger"><span class="glyphicon glyphicon-alert" aria-hidden="true"></span> No data was found.</p>
				</small>
			</div>';
	}else{
?>
			<table class="table table-bordered table-striped table-hover table-condensed">
				<tr class="warning">
					<th class="text-center">PDF</th>
					<th class="text-center">Employee Name</th>
					<th class="text-center">Employee Type</th>
					<th class="text-center">Hours</th>
					<th class="text-center">Work Done</th>
					<th class="text-center">Rate</th>
					<th class="text-center">Value</th>
					<th class="text-center">Save</th>
					<th class="text-center">Delete</th>
				</tr>
				<?php
					foreach ($workorderPersonal as $data):
						echo "<tr>";					
						$idRecord = $data['id_workorder_personal'];
				?>
						<form  name="personal_<?php echo $idRecord ?>" id="personal_<?php echo $idRecord ?>" method="post" action="<?php echo base_url("workorders/save_rate"); ?>">
						<input type="hidden" id="formType" name="formType" value="personal"/>
						<input type="hidden" id="hddId" name="hddId" value="<?php echo $idRecord; ?>"/>
						<input type="hidden" id="hddIdWorkOrder" name="hddIdWorkOrder" value="<?php echo $data['fk_id_workorder']; ?>"/>
						<input type="hidden" id="hours" name="hours" value="<?php echo $data['hours']; ?>"/>
						<input type="hidden" id="description" name="description" value="<?php echo $data['description']; ?>"/>
						<input type="hidden" id="quantity" name="quantity" value=1 >
				<?php
						echo "<td class='text-center'>";
						$checkPerso = '';
						if($data['view_pdf'] == 1 ){
							$checkPerso = 'checked';
						}
				?>
						<input type="checkbox" id="check_pdf" name="check_pdf" <?php echo $checkPerso; ?>>
				<?php
						echo "</td>";
						echo "<td>";
						echo '<small>' . $data['name'] . '</small></td>';
						echo "<td ><small>" . $data['employee_type'] . "</small></td>";
						echo "<td class='text-center'><small>" . $data['hours'] . "</small></td>";
						echo "<td ><small>" . $data['description'] . "</small></td>";
				?>
						<td>
						<input type="text" id="rate" name="rate" class="form-control" placeholder="Rate" value="<?php echo $data['rate']; ?>" required >
						</td>
						<td class='text-right'><small>$ <?php echo $data['value']; ?></small></td>
						<td class='text-center'>
							<button type="submit" id="btnSubmit" name="btnSubmit" class="btn btn-primary btn-xs" title="Update" <?php echo $deshabilitar; ?>>
								<span class="glyphicon glyphicon-floppy-disk" aria-hidden="true">
							</button> 
						</td>
						</form>
						
						<td class='text-center'>
							<?php if(!$deshabilitar){ ?>
							<a class='btn btn-danger btn-xs' href='<?php echo base_url('workorders/deleteRecord/personal/' . $data['id_workorder_personal'] . '/' . $data['fk_id_workorder'] . '/view_workorder') ?>' id="btn-delete">
									<i class="fa fa-trash-o"></i> 
							</a>
							<?php }else{ echo "---";} ?>
						</td>
						</tr>
				<?php
					endforeach;
				?>
			</table>
			<div class="col-lg-12">
				<small>
				<p class="text-danger"><span class="glyphicon glyphicon-alert" aria-hidden="true"></span> <strong>Value = </strong>
					Hours X Rate
				</p>
			</small>
			</div>
<?php } ?>
										</div>
									</div>
								</div>
	</div>			
<!--FIN PERSONAL -->
	
<!--INICIO MATERIALS -->
	<div class="row">
								<div class="col-lg-12">				
									<div class="panel panel-success">
										<div class="panel-heading">
											MATERIALS VCI
										</div>
										<div class="panel-body">
											<div class="col-lg-12">	
					
					<?php if(!$deshabilitar){ ?>					
					<button type="button" class="btn btn-success btn-block" data-toggle="modal" data-target="#modalMaterials" id="<?php echo 'material-' . $information[0]["id_workorder"];//se coloca un ID diferente para que no entre en conflicto con los otros modales ?>">
							<span class="glyphicon glyphicon-plus" aria-hidden="true"></span> Add Materials VCI
					</button><br>
					<?php } ?>
											</div>
<?php 										
	if(!$workorderMaterials){ 
		echo '<div class="col-lg-12">
				<small>
				<p class="text-danger"><span class="glyphicon glyphicon-alert" aria-hidden="true"></span> No data was found.</p>
				</small>
			</div>';
	}else{
?>
			<table class="table table-bordered table-striped table-hover table-condensed">
				<tr class="success">
					<th class="text-center">PDF</th>
					<th class="text-center">Info. Material</th>
					<th class="text-center">Quantity</th>
					<th class="text-center">Unit</th>
					<th class="text-center">Rate</th>
					<th class="text-center">Markup</th>
					<th class="text-center">Value</th>
					<th class="text-center">Save</th>
					<th class="text-center">Delete</th>
				</tr>
				<?php
					foreach ($workorderMaterials as $data):
						echo "<tr>";
						$idRecord = $data['id_workorder_materials'];
				?>
						<form  name="material_<?php echo $idRecord ?>" id="material_<?php echo $idRecord ?>" method="post" action="<?php echo base_url("workorders/save_rate"); ?>">
						<input type="hidden" id="formType" name="formType" value="materials"/>
						<input type="hidden" id="hddId" name="hddId" value="<?php echo $idRecord; ?>"/>
						<input type="hidden" id="hddIdWorkOrder" name="hddIdWorkOrder" value="<?php echo $data['fk_id_workorder']; ?>"/>
						<input type="hidden" id="quantity" name="quantity" value="<?php echo $data['quantity']; ?>"/>
						<input type="hidden" id="hours" name="hours" value=1 />
						<input type="hidden" id="description" name="description" value="<?php echo $data['description']; ?>"/>
						<input type="hidden" id="unit" name="unit" value="<?php echo $data['unit']; ?>"/>
				<?php
						echo "<td class='text-center'>";
						$checkMaterial = '';
						if($data['view_pdf'] == 1 ){
							$checkMaterial = 'checked';
						}
				?>
						<input type="checkbox" id="check_pdf" name="check_pdf" <?php echo $checkMaterial; ?>>
				<?php
						echo "</td>";
						echo "<td ><small><strong>Material</strong><br>" . $data['material'] . "</small>";
						echo "<br><small><strong>Description</strong><br>" . $data['description'] . "</small></td>";
						echo "<td class='text-right'><small>" . $data['quantity'] . "</small></td>";
						echo "<td ><small>" . $data['unit'] . "</small></td>";
				?>
						<td>
						<input type="text" id="rate" name="rate" class="form-control" placeholder="Rate" value="<?php echo $data['rate']; ?>" required >
						</td>

						<td>
						<input type="text" id="markup" name="markup" class="form-control" placeholder="Markup" value="<?php echo $data['markup']; ?>" required >
						</td>

						<td class='text-right'><small>$ <?php echo $data['value']; ?></small></td>
						<td class='text-center'>
					<button type="submit" id="btnSubmit" name="btnSubmit" class="btn btn-primary btn-xs" title="Update" <?php echo $deshabilitar; ?>>
						 <span class="glyphicon glyphicon-floppy-disk" aria-hidden="true">
					</button> 
						</td>
						</form>
						<td class='text-center'>
							<?php if(!$deshabilitar){ ?>
							<a class='btn btn-danger btn-xs' href='<?php echo base_url('workorders/deleteRecord/materials/' . $data['id_workorder_materials'] . '/' . $data['fk_id_workorder'] . '/view_workorder') ?>' id="btn-delete">
									<i class="fa fa-trash-o"></i> 
							</a>
							<?php }else{ echo "---";} ?>
						</td>
						</tr>
				<?php
					endforeach;
				?>
			</table>
			<div class="col-lg-12">
				<small>
				<p class="text-danger"><span class="glyphicon glyphicon-alert" aria-hidden="true"></span> <strong>Value = </strong>
					Quantity X Rate X (Markup + 100)/100
				</p>
			</small>
			</div>
<?php } ?>
										</div>
									</div>
								</div>
	</div>		
<!--FIN MATERIALS -->

<!--INICIO INVOICE -->
	<div class="row">
								<div class="col-lg-12">				
									<div class="panel panel-violeta">
										<div class="panel-heading">
											RECEIPT
										</div>
										<div class="panel-body">
											<div class="col-lg-12">	
					
					<?php if(!$deshabilitar){ ?>					
					<button type="button" class="btn btn-violeta btn-block" data-toggle="modal" data-target="#modalReceipt" id="<?php echo 'receipt-' . $information[0]["id_workorder"];//se coloca un ID diferente para que no entre en conflicto con los otros modales ?>">
							<span class="glyphicon glyphicon-plus" aria-hidden="true"></span> Add Receipt
					</button><br>
					<?php } ?>
											</div>
<?php 										
	if(!$workorderReceipt){ 
		echo '<div class="col-lg-12">
				<small>
				<p class="text-danger"><span class="glyphicon glyphicon-alert" aria-hidden="true"></span> No data was found.</p>
				</small>
			</div>';
	}else{
?>
			<table class="table table-bordered table-striped table-hover table-condensed">
				<tr class="danger">
					<th class="text-center">PDF</th>
					<th class="text-center">Place</th>
					<th class="text-center">Price with GST</th>
					<th class="text-center">Description</th>
					<th class="text-center">Markup</th>
					<th class="text-center">Value</th>
					<th class="text-center">Save</th>
					<th class="text-center">Delete</th>
				</tr>
				<?php
					foreach ($workorderReceipt as $data):
						echo "<tr>";
						$idRecord = $data['id_workorder_receipt'];
				?>
						<form  name="invoice_<?php echo $idRecord ?>" id="invoice_<?php echo $idRecord ?>" method="post" action="<?php echo base_url("workorders/update_receipt"); ?>">
						<input type="hidden" id="hddId" name="hddId" value="<?php echo $idRecord; ?>"/>
						<input type="hidden" id="hddIdWorkOrder" name="hddIdWorkOrder" value="<?php echo $data['fk_id_workorder']; ?>"/>
						<input type="hidden" id="place" name="place" value="<?php echo $data['place']; ?>"/>
						<input type="hidden" id="description" name="description" value="<?php echo $data['description']; ?>"/>
						<input type="hidden" id="view" name="view" value="view_workorder"/>
				<?php
						echo "<td class='text-center'>";
						$checkReceipt = '';
						if($data['view_pdf'] == 1 ){
							$checkReceipt = 'checked';
						}
				?>
						<input type="checkbox" id="check_pdf" name="check_pdf" <?php echo $checkReceipt; ?>>
				<?php
						echo "</td>";
						echo "<td><small>" . $data['place'] . "</small></td>";						
				?>
						<td>
						<input type="text" id="price" name="price" class="form-control" placeholder="Price" value="<?php echo $data['price']; ?>" required >
						</td>
				<?php
						echo "<td><small>" . $data['description'] . "</small></td>";
				?>						
						<td>
						<input type="text" id="markup" name="markup" class="form-control" placeholder="Markup" value="<?php echo $data['markup']; ?>" required >
		
						</td>
						<td class='text-right'><small>$ <?php echo $data['value']; ?></small></td>
						<td class='text-center'>
					<button type="submit" id="btnSubmit" name="btnSubmit" class="btn btn-primary btn-xs" title="Update" <?php echo $deshabilitar; ?>>
						 <span class="glyphicon glyphicon-floppy-disk" aria-hidden="true">
					</button> 
						</td>
						</form>
						<td class='text-center'>
							<?php if(!$deshabilitar){ ?>
							<a class='btn btn-danger btn-xs' href='<?php echo base_url('workorders/deleteRecord/receipt/' . $data['id_workorder_receipt'] . '/' . $data['fk_id_workorder'] . '/view_workorder') ?>' id="btn-delete">
									<i class="fa fa-trash-o"></i> 
							</a>
							<?php }else{ echo "---";} ?>
						</td>
						</tr>
				<?php
					endforeach;
				?>
			</table>

			<div class="col-lg-12">
				<small>
				<p class="text-danger"><span class="glyphicon glyphicon-alert" aria-hidden="true"></span> <strong>Value = </strong>
					Price/1.05 X (Markup + 100)/100) 
				</p>
			</small>
			</div>

<?php } ?>
										</div>
									</div>
								</div>
	</div>		
<!--FIN INVOICE -->

<!--INICIO EQUIPMENT -->
	<div class="row">
								<div class="col-lg-12">				
									<div class="panel panel-info">
										<div class="panel-heading">
											EQUIPMENT
										</div>
										<div class="panel-body">
											<div class="col-lg-12">	
												
					<?php if(!$deshabilitar){ ?>
					<button type="button" class="btn btn-info btn-block" data-toggle="modal" data-target="#modalEquipment" id="<?php echo 'equipment-' . $information[0]["id_workorder"];//se coloca un ID diferente para que no entre en conflicto con los otros modales ?>">
							<span class="glyphicon glyphicon-plus" aria-hidden="true"></span> Add Equipment
					</button><br>
					<?php } ?>
											</div>
<?php 										
	if(!$workorderEquipment){ 
		echo '<div class="col-lg-12">
				<small>
				<p class="text-danger"><span class="glyphicon glyphicon-alert" aria-hidden="true"></span> No data was found.</p>
				</small>
			</div>';
	}else{
?>
			<table class="table table-bordered table-striped table-hover table-condensed">
				<tr class="info">
					<th class="text-center">PDF</th>
					<th class="text-center">Info. Equipment</th>
					<th class="text-center">Hours</th>
					<th class="text-center">Quantity</th>
					<th class="text-center">Rate</th>
					<th class="text-center">Value</th>
					<th class="text-center">Save</th>
					<th class="text-center">Delete</th>
				</tr>
				<?php
					foreach ($workorderEquipment as $data):
						echo "<tr>";
						$idRecord = $data['id_workorder_equipment'];
						$quantity = $data['quantity']==0?1:$data['quantity'];
				?>
						<form  name="equipment_<?php echo $idRecord ?>" id="equipment_<?php echo $idRecord ?>" method="post" action="<?php echo base_url("workorders/save_rate"); ?>">
						<input type="hidden" id="formType" name="formType" value="equipment"/>
						<input type="hidden" id="hddId" name="hddId" value="<?php echo $idRecord; ?>"/>
						<input type="hidden" id="hddIdWorkOrder" name="hddIdWorkOrder" value="<?php echo $data['fk_id_workorder']; ?>"/>
						<input type="hidden" id="hours" name="hours" value="<?php echo $data['hours']; ?>"/>
						<input type="hidden" id="quantity" name="quantity" value="<?php echo $quantity; ?>" />
						<input type="hidden" id="description" name="description" value="<?php echo $data['description']; ?>"/>
				<?php
						echo "<td class='text-center'>";
						$checkReceipt = '';
						if($data['view_pdf'] == 1 ){
							$checkReceipt = 'checked';
						}
				?>
						<input type="checkbox" id="check_pdf" name="check_pdf" <?php echo $checkReceipt; ?>>
				<?php
						echo "</td>";

						echo "<td ><small><strong>Type</strong><br>" . $data['type_2'] . "</small>";
						//si es tipo miscellaneous -> 8, entonces la description es diferente
						if($data['fk_id_type_2'] == 8){
							$equipment = $data['miscellaneous'] . " - " . $data['other'];
						}else{
							//$equipment = $data['unit_number'] . " - " . $data['v_description'];
							$equipment = $data['unit_number'] . " - " . $data['make'] . " - " . $data['model'];
						}
						
						echo "<br><small><strong>Equipment</strong><br>" . $equipment . "</small>";
						if($data['standby'] == 1){
							echo "<br><small><strong>Standby?</strong> Yes</small>";
						}else{
							echo "<br><small><strong>Operated by</strong><br>" . $data['operatedby'] . "</small>";
						}
						echo "<br><small><strong>Description</strong><br>" . $data['description'] . "</small>";
						
						if($data['company_name']){
							echo "<br><small><strong>Client</strong><br>" . $data['company_name'] . "</small> ";
						}
						
						if($data['foreman_name']){
							echo "<br><small><strong>Foreman's name</strong><br>" . $data['foreman_name'] . "</small> ";
						}
						
						if($data['foreman_email']){
							echo "<br><small><strong>Foreman's email</strong><br>" . $data['foreman_email'] . "</small> ";
						}
						echo "</td>";
						
						echo "<td class='text-right'><small>" . $data['hours'] . "</small></td>";
						echo "<td class='text-right'><small>" . $quantity . "</small></td>";
				?>
						<td>
						<input type="text" id="rate" name="rate" class="form-control" placeholder="Rate" value="<?php echo $data['rate']; ?>" required >
						</td>
						<td class='text-right'><small>$ <?php echo $data['value']; ?></small></td>
						<td class='text-center'>

					<button type="submit" id="btnSubmit" name="btnSubmit" class="btn btn-primary btn-xs" title="Update" <?php echo $deshabilitar; ?>>
						 <span class="glyphicon glyphicon-floppy-disk" aria-hidden="true">
					</button> 
							
						</td>
						</form>									

						<td class='text-center'>
							<?php if(!$deshabilitar){ ?>
							<a class='btn btn-danger btn-xs' href='<?php echo base_url('workorders/deleteRecord/equipment/' . $data['id_workorder_equipment'] . '/' . $data['fk_id_workorder'] . '/view_workorder') ?>' id="btn-delete">
									<i class="fa fa-trash-o"></i> 
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

<!--FIN EQUIPMENT -->	
	
<!--INICIO OCASIONAL SUBCONTRACTOR -->
	<div class="row">
								<div class="col-lg-12">				
									<div class="panel panel-primary">
										<div class="panel-heading">
											OCASIONAL
										</div>
										<div class="panel-body">
											<div class="col-lg-12">	
								
					<?php if(!$deshabilitar){ ?>
					<button type="button" class="btn btn-primary btn-block" data-toggle="modal" data-target="#modalOcasional" id="<?php echo 'ocasional-' . $information[0]["id_workorder"];//se coloca un ID diferente para que no entre en conflicto con los otros modales ?>">
							<span class="glyphicon glyphicon-plus" aria-hidden="true"></span> Add Ocasional Subcontractor
					</button><br>
					<?php } ?>
											</div>
<?php 										
	if(!$workorderOcasional){ 
		echo '<div class="col-lg-12">
				<small>
				<p class="text-danger"><span class="glyphicon glyphicon-alert" aria-hidden="true"></span> No data was found.</p>
				</small>
			</div>';
	}else{
?>
			<table class="table table-bordered table-striped table-hover table-condensed">
				<tr class="primary">
					<th class="text-center">PDF</th>
					<th class="text-center">Info. Subcontractor</th>
					<th class="text-center">Quantity</th>
					<th class="text-center">Unit</th>
					<th class="text-center">Hours</th>
					<th class="text-center">Rate</th>
					<th class="text-center">Markup</th>
					<th class="text-center">Value</th>
					<th class="text-center">Save</th>
					<th class="text-center">Delete</th>
				</tr>
				<?php
					foreach ($workorderOcasional as $data):						
						echo "<tr>";
						$hours = $data['hours']==0?1:$data['hours'];
						$idRecord = $data['id_workorder_ocasional'];
				?>
						<form  name="ocasional_<?php echo $idRecord ?>" id="ocasional_<?php echo $idRecord ?>" method="post" action="<?php echo base_url("workorders/save_rate"); ?>">
						<input type="hidden" id="formType" name="formType" value="ocasional"/>
						<input type="hidden" id="hddId" name="hddId" value="<?php echo $idRecord; ?>"/>
						<input type="hidden" id="hddIdWorkOrder" name="hddIdWorkOrder" value="<?php echo $data['fk_id_workorder']; ?>"/>
						<input type="hidden" id="quantity" name="quantity" value="<?php echo $data['quantity']; ?>"/>
						<input type="hidden" id="hours" name="hours" value="<?php echo $hours; ?>"/>
						<input type="hidden" id="description" name="description" value="<?php echo $data['description']; ?>"/>
						<input type="hidden" id="unit" name="unit" value="<?php echo $data['unit']; ?>"/>
				<?php
						echo "<td class='text-center'>";
						$checkReceipt = '';
						if($data['view_pdf'] == 1 ){
							$checkReceipt = 'checked';
						}
				?>
						<input type="checkbox" id="check_pdf" name="check_pdf" <?php echo $checkReceipt; ?>>
				<?php
						echo "</td>";
						echo "<td ><small><strong>Company</strong><br>" . $data['company_name'] . "</small>";
						echo "<br><small><strong>Equipment</strong><br>" . $data['equipment'] . "</small>";
						echo "<br><small><strong>Contact</strong><br>" . $data['contact'] . "</small>";
						echo "<br><small><strong>Description</strong><br>" . $data['description'] . "</small></td>";
						echo "<td class='text-right'><small>" . $data['quantity'] . "</small></td>";
						echo "<td ><small>" . $data['unit'] . "</small></td>";
						echo "<td class='text-right'><small>" . $hours . "</small></td>";					
				?>
						<td>
						<input type="text" id="rate" name="rate" class="form-control" placeholder="Rate" value="<?php echo $data['rate']; ?>" required >
						</td>
						<td>
						<input type="text" id="markup" name="markup" class="form-control" placeholder="Markup" value="<?php echo $data['markup']; ?>" required >
						</td>
						<td class='text-right'><small>$ <?php echo $data['value']; ?></small></td>
						<td class='text-center'>

							<button type="submit" id="btnSubmit" name="btnSubmit" class="btn btn-primary btn-xs" title="Update" <?php echo $deshabilitar; ?>>
								 <span class="glyphicon glyphicon-floppy-disk" aria-hidden="true">
							</button> 

						</td>
						</form>	
						<td class='text-center'>
							<?php if(!$deshabilitar){ ?>
							<a class='btn btn-danger btn-xs' href='<?php echo base_url('workorders/deleteRecord/ocasional/' . $data['id_workorder_ocasional'] . '/' . $data['fk_id_workorder'] . '/view_workorder') ?>' id="btn-delete">
									<i class="fa fa-trash-o"></i> 
							</a>
							<?php }else{ echo "---";} ?>
						</td>
						</tr>
				<?php
					endforeach;
				?>
			</table>
			<div class="col-lg-12">
				<small>
				<p class="text-danger"><span class="glyphicon glyphicon-alert" aria-hidden="true"></span> <strong>Value = </strong>
					Quantity X Hours X Rate X (Markup + 100)/100
				</p>
			</small>
			</div>
<?php } ?>
										</div>
									</div>
								</div>
	</div>

	
<!--FIN OCASIONAL SUBCONTRACTOR -->


<!--INICIO HOLD BACK -->


	<div class="row">
								<div class="col-lg-12">				
									<div class="panel panel-purpura">
										<div class="panel-heading">
											HOLD BACK
										</div>
										<div class="panel-body">
											<div class="col-lg-12">	
								
					<?php if(!$deshabilitar){ ?>
					<button type="button" class="btn btn-purpura btn-block" data-toggle="modal" data-target="#modalHoldBack" id="holdBack-<?php echo $information[0]["id_workorder"]; ?>">
							<span class="glyphicon glyphicon-plus" aria-hidden="true"></span> Add Hold Back
					</button><br>
					<?php } ?>
											</div>
<?php 										
	if(!$workorderHoldBack){ 
		echo '<div class="col-lg-12">
				<small>
				<p class="text-danger"><span class="glyphicon glyphicon-alert" aria-hidden="true"></span> No data was found.</p>
				</small>
			</div>';
	}else{
?>
			<table class="table table-bordered table-striped table-hover table-condensed">
				<tr class="warning">
					<th class="text-center">Description</th>
					<th class="text-center">Value</th>
					<th class="text-center">Links</th>
				</tr>
				<?php
					foreach ($workorderHoldBack as $data):
						echo "<tr>";					
												
						$idRecord = $data['id_workorder_hold_back'];
				?>

						<form  name="hold_back_<?php echo $idRecord ?>" id="hold_back_<?php echo $idRecord ?>" method="post" action="<?php echo base_url("workorders/save_rate"); ?>">
						<input type="hidden" id="formType" name="formType" value="hold_back"/>
						<input type="hidden" id="hddId" name="hddId" value="<?php echo $idRecord; ?>"/>
						<input type="hidden" id="hddIdWorkOrder" name="hddIdWorkOrder" value="<?php echo $data['fk_id_workorder']; ?>"/>
						<input type="hidden" id="hours" name="hours" value=1 >
						<input type="hidden" id="quantity" name="quantity" value=1 >
						
						<td>
							<textarea id="description" name="description" class="form-control" rows="3" required><?php echo $data['description']; ?></textarea>
						</td>
						
						<td>
						<input type="text" id="rate" name="rate" class="form-control" placeholder="Value" value="<?php echo $data['value']; ?>" required >
						</td>

						<td class='text-center'>
							<input type="submit" id="btnSubmit" name="btnSubmit" value="Save" class="btn btn-primary" <?php echo $deshabilitar; ?>/>
						</form>

						<br><br>
							<?php if(!$deshabilitar){ ?>
							<a class='btn btn-danger' href='<?php echo base_url('workorders/deleteRecord/hold_back/' . $data['id_workorder_hold_back'] . '/' . $data['fk_id_workorder'] . '/view_workorder') ?>' id="btn-delete">
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

								
<!--FIN HOLD BACK -->
	
	
<?php } ?>	
		
</div>

<!--INICIO Modal para PERSONAL -->
<div class="modal fade text-center" id="modalExpense" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">    
	<div class="modal-dialog modal-lg" role="document">
		<div class="modal-content" id="tablaDatosExpense">

		</div>
	</div>
</div>                       
<!--FIN Modal para PERSONAL -->

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

<!--INICIO Modal para OCASIONAL-->
<div class="modal fade text-center" id="modalHoldBack" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">    
	<div class="modal-dialog" role="document">
		<div class="modal-content" id="tablaDatosHoldBack">

		</div>
	</div>
</div>                       
<!--FIN Modal para OCASIONAL -->

<!--INICIO Modal para RECEIPT-->
<div class="modal fade text-center" id="modalReceipt" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">    
	<div class="modal-dialog" role="document">
		<div class="modal-content" id="tablaDatosReceipt">

		</div>
	</div>
</div>                       
<!--FIN Modal para RECEIPT -->