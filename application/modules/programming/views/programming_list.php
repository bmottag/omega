<script type="text/javascript" src="<?php echo base_url("assets/js/validate/programming/programming.js"); ?>"></script>

<div id="page-wrapper">
	<br>

	<!-- /.row -->
	<div class="row">
		<div class="col-lg-12">
			<div class="panel panel-warning">
				<div class="panel-heading">
				
		<?php
			if($idProgramming != 'x'){
		?>
					<a class="btn btn-warning btn-xs" href=" <?php echo base_url('programming'); ?> "><span class="glyphicon glyphicon glyphicon-chevron-left" aria-hidden="true"></span> Go back </a> 
		<?php
			}
		?>
					<i class="fa fa-list"></i> <strong>PLANNING LIST </strong>
				</div>
				<div class="panel-body">

<?php
	//DESHABILITAR PROGRAMACION, si es SAFETY
	$deshabilitar = '';
	$userRol = $this->session->rol;

	if($userRol == 4)
	{
		$deshabilitar = 'disabled';
	}
?>
			<?php if(!$deshabilitar){ ?>
					<a class='btn btn-outline btn-warning btn-block' href='<?php echo base_url('programming/add_programming'); ?>'>
							<span class="glyphicon glyphicon-edit" aria-hidden="true"> </span>  New Planning
					</a>
					<br>
			<?php } ?>
					
<?php
$retornoExito = $this->session->flashdata('retornoExito');
if ($retornoExito) {
    ?>
	<div class="alert alert-success alert-dismissible fade in" role="alert">
		<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span>
		</button>
		<strong>Ok!</strong> <?php echo $retornoExito ?>	
	</div>
    <?php
}

$retornoError = $this->session->flashdata('retornoError');
if ($retornoError) {
    ?>
	<div class="alert alert-danger alert-dismissible fade in" role="alert">
		<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span>
		</button>
		<strong>Error!</strong> <?php echo $retornoError ?>
	</div>	
    <?php
}
?> 
	
				<?php
					if($information){ 
				?>
					<table width="100%" class="table table-striped table-bordered table-hover" id="dataTables">
						<thead>
							<tr>
								<th class='text-center'>ID</th>
								<th class='text-center'>Date</th>
								<th class='text-center'>Job Code/Name</th>
								<th class='text-center'>Observation</th>
								<th class='text-center'>Links</th>
								<th class='text-center'>Done by</th>
							</tr>
						</thead>
						<tbody>							
						<?php
							foreach ($information as $lista):
								$flag = '';
								$flagText = '';
								if($lista["flag_date"] == 2){
									$flag = "info";
									$flagText = "text-primary";
								}
								echo "<tr class='".$flag." " . $flagText. "'>";
								echo "<td class='text-center'>";
								echo ($lista["parent_id"] != null && $lista["parent_id"] != '') ? $lista["parent_id"] : $lista["id_programming"];
								echo "</td>";
								echo "<td class='text-center'>" . $lista['date_programming'] . "</td>";
								echo "<td class='text-center'>" . $lista['job_description'] . "</td>";
								echo "<td>" . $lista['observation'] . "</td>";
								echo "<td class='text-center'><small>";
								
								
//consultar si la fecha de la programacion es mayor a la fecha actual
$fechaProgramacion = $lista['date_programming'];

$datetime1 = date_create($fechaProgramacion);
$datetime2 = date_create(date("Y-m-d"));


		if($datetime1 < $datetime2) {
				echo '<p class="text-danger"><strong>OVERDUE</strong></p>';
		}else{
			
			if($lista['state'] == 2)
			{
				echo '<p class="text-success"><strong>COMPLETE</strong></p>';
			}elseif($lista['state'] == 1){
				echo '<p class="text-danger"><strong>INCOMPLETE</strong></p>';
			}


			$idParent = $lista["parent_id"];

?>

		<?php 
			if(!$deshabilitar){ 
		?>

		<?php 
			if($lista["parent_id"] == null || $lista["parent_id"] == ''){
		?>
			<a href='<?php echo base_url("programming/add_programming/" . $lista['id_programming']); ?>' class='btn btn-info btn-xs' title="Edit"><i class='fa fa-pencil'></i></a>

		<?php 
			}
		?>
<?php if($informationWorker){ ?>
			<button type="button" class="btn btn-warning btn-xs" data-toggle="modal" data-target="#modalWorker" id="x">
					<i class="fa fa-user"></i>
			</button>
<?php }elseif($lista['state'] == 1 && $idProgramming != 'x'){ ?>
			<a href='<?php echo base_url("programming/add_programming_workers/" . $lista['id_programming']); ?>' class='btn btn-warning btn-xs' title="Workers"><i class='fa fa-users'></i></a>
<?php } ?>
		

			<button type="button" id="<?php echo $lista['id_programming']; ?>" class='btn btn-danger btn-xs' title="Delete">
					<i class="fa fa-trash-o"></i>
			</button>
			
<?php
		}
		}
?>

			<a href='<?php echo base_url("programming/index/$lista[id_programming]"); ?>' class='btn btn-success btn-xs' title="View"><i class='fa fa-eye'></i></a>


<?php								
								
								echo "</small></td>";
								echo "<td class='text-center'><p class='text-success'>" . $lista['name'] . "</p>";
								
//enviar mensaje; 
//revisar que la fecha sea mayor a la fecha y hora actual
//revisar que exista al menos un trabajador
//se actualiza el estado de la programacion
//se envia mensaje
if(($datetime1 >= $datetime2) && $informationWorker && !$deshabilitar)
{
	
?>
	<a href='<?php echo base_url("programming/send/" . $lista['id_programming']); ?>' class='btn btn-info btn-xs' title="Send SMS"><i class='glyphicon glyphicon-send'></i></a>
<?php
}
								echo "</td>";

								echo "</tr>";
							endforeach;
						?>
						</tbody>
					</table>
				<?php } ?>
<!-- INICIO LISTA DE WORKER CON DAY OFF -->
				<?php
					if($dayoffList){
				?>
					<div class="table-responsive">	
						<table width="100%" class="table table-striped table-bordered table-hover" id="dataTables">
							<thead>
								<tr class="text-danger danger">
									<th colspan="2">Employees with day off coming up</th>
								</tr>
								<tr class="text-danger danger">
									<th>Employee</th>
									<th class="text-center">Date of day off</th>									
								</tr>
							</thead>
							<tbody>							
							<?php
								foreach ($dayoffList as $lista):
									echo "<tr>";
										echo "<td>" . $lista['name'] . "</td>";
										echo "<td class='text-center'>" . $lista['date_dayoff'] . "</td>";
									echo "</tr>";
								endforeach;
							?>
							</tbody>
						</table>
					</div>
				<?php } ?>
<!-- FIN LISTA DE WORKERS CON DAY OFF -->
				
				
<!-- INICIO HISTORICO -->
		<?php
			if($informationWorker){
		?>
					<div class="table-responsive">					
						<table id="dataTablesWorker" class="table table-striped jambo_table bulk_action" cellspacing="0" width="100%">

							<thead>
								<tr class="headings">
									<th class="column-title" colspan="9">-- WORKERS --</th>
								</tr>
								
								<tr class="headings">
									<th class="column-title" style="width: 10%"><small>Name</small></th>
									<th class="column-title text-center" style="width: 12%"><small>Time In</small></th>
									<th class="column-title text-center" style="width: 13%"><small>Site</small></th>
									<th class="column-title text-center" style="width: 13%"><small>FLHA/TOOL BOX</small></th>
									<th class="column-title text-center" style="width: 21%"><small>Description</small></th>
									<th class="column-title text-center" style="width: 22%"><small>Equipment</small></th>
									<th class="column-title text-center" style="width: 9%"><small>Links</small></th>
								</tr>
							</thead>

							<tbody>
										
							<?php								
								$mensaje = "";
							
								foreach ($informationWorker as $data):
									$mensaje .= "<br>";
									switch ( $data['site'] )
									{
										case 1:
											$mensaje .= "At the yard - ";
											break;
										case 2:
											$mensaje .= "At the site - ";
											break;
										case 3:
											$mensaje .= "At Terminal - ";
											break;
										default:
											$mensaje .= "At the yard - ";
											break;
									}
									$mensaje .= $data['hora']; 

									$mensaje .= "<br>" . $data['name']; 
									$mensaje .= $data['description']?"<br>" . $data['description']:"";
									$mensaje .= $data['unit_description']?"<br>" . $data['unit_description']:"";
									
									if($data['safety']==1){
										$mensaje .= "<br>Do FLHA";
									}elseif($data['safety']==2){
										$mensaje .= "<br>Do Tool Box";
									}
									
									$mensaje .= "<br>";
								
								
									echo "<tr>";
									echo "<td ><small>$data[name]</small></td>";
									
									$idRecord = $data['id_programming_worker'];
									$fkIdProgramming = $data['fk_id_programming'];
							?>		
									
						<form  name="worker_<?php echo $idRecord ?>" id="worker_<?php echo $idRecord ?>" method="post" action="<?php echo base_url("programming/update_worker"); ?>">

							<input type="hidden" id="hddId" name="hddId" value="<?php echo $idRecord; ?>"/>
							<input type="hidden" id="hddIdProgramming" name="hddIdProgramming" value="<?php echo $fkIdProgramming; ?>"/>
						
						<td>
							<select name="hora_inicio" id="hora_inicio" class="form-control" required>
								<option value=''>Select...</option>
								<?php for ($i = 0; $i < count($horas); $i++) { ?>
									<option value="<?php echo $horas[$i]["id_hora"]; ?>" 
									<?php 
									if($horas[$i]["id_hora"] == $data["fk_id_hour"]) 
									{ 
										echo 'selected="selected"'; 
									}
									?> ><?php echo $horas[$i]["hora"]; ?>
									</option>	
								<?php } ?>
							</select>
						</td>	
						
						<td>						
							<select name="site" id="site" class="form-control" required>
								<option value="">Select...</option>
								<option value=1 <?php if($data["site"] == 1) { echo "selected"; }  ?>>At the yard</option>
								<option value=2 <?php if($data["site"] == 2) { echo "selected"; }  ?>>At the site</option>
								<option value=3 <?php if($data["site"] == 3) { echo "selected"; }  ?>>At Terminal</option>
							</select>
						</td>
						
						<td>						
							<select name="safety" id="safety" class="form-control">
								<option value="">Select...</option>
								<option value=1 <?php if($data["safety"] == 1) { echo "selected"; }  ?>>FLHA</option>
								<option value=2 <?php if($data["safety"] == 2) { echo "selected"; }  ?>>Tool Box</option>
							</select>
						</td>
							
						<td>
							<input type="text" id="description" name="description" class="form-control" placeholder="Description" value="<?php echo $data['description']; ?>" >
						</td>
							
						<td>
							<select name="machine" id="machine" class="form-control" >
								<option value=''>Select...</option>
								<?php for ($i = 0; $i < count($informationVehicles); $i++) { ?>
									<option value="<?php echo $informationVehicles[$i]["id_truck"]; ?>" <?php if($data["fk_id_machine"] == $informationVehicles[$i]["id_truck"]) { echo "selected"; }  ?>><?php echo $informationVehicles[$i]["unit_number"]; ?></option>	
								<?php } ?>
							</select>
						</td>
																
						<td class='text-center'>
						
<?php
if(($datetime1 >= $datetime2) && $informationWorker && !$deshabilitar){
?>
							<input type="submit" id="btnSubmit" name="btnSubmit" value="Save" class="btn btn-primary btn-xs"/>
<?php
}
?>
						</form>
						
						<br><br>
<?php
if(($datetime1 >= $datetime2) && $informationWorker && !$deshabilitar){
?>
							<a class='btn btn-purpura btn-xs' href='<?php echo base_url('programming/deleteWorker/' . $idProgramming . '/' . $idRecord) ?>' id="btn-delete" title="Delete">
									<span class="fa fa-trash-o" aria-hidden="true"> </span>
							</a>
<?php
}
?>

						</td>
									
									
									
							<?php
									
									echo "<td class='text-center'><small>";


									
									echo "</small></td>";
									echo "</tr>";
								endforeach;
							?>

							</tbody>
						</table>
					</div>
					
					
					<div class="table-responsive">					
						<table id="dataTablesWorker" class="table table-striped jambo_table bulk_action" cellspacing="0" width="100%">

							<thead>
								<tr class="headings">
									<th class="column-title">-- MESSAGE --</th>
									<th class="column-title">-- INSPECTIONS --</th>
									<th class="column-title">-- FLHA / TOOL BOX --</th>
								</tr>
							</thead>

							<tbody>
								<tr>
									<td>
										<?php
											echo date('F j, Y', strtotime($information[0]['date_programming']));
											echo "<br>" . $information[0]['job_description'];
											echo "<br>" . $information[0]['observation'];
											echo "<br>";

											echo $mensaje;
										?>									
									</td>
									<td>
										<?php echo $memo; ?>
									</td>
									<td>
										<?php 
											echo $memo_flha;
											echo "<br><br>";
											echo $memo_tool_box;
										?>
									</td>
								</tr>
							</tbody>
						</table>
					</div>

					
					
		<?php
			}
		?>
<!-- FIN HISTORICO -->
								
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

<!--INICIO Modal para adicionar WORKER -->
<?php if($workersList){ ?>
<div class="modal fade text-center" id="modalWorker" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">    
	<div class="modal-dialog" role="document">
		<div class="modal-content" id="tablaDatos">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
				<h4 class="modal-title" id="exampleModalLabel">ADD WORKER</h4>
			</div>

			<div class="modal-body">
				<form name="formWorkerProgramming" id="formWorkerProgramming" role="form" method="post" action="<?php echo base_url("programming/safet_One_Worker_programming") ?>" >
					<input type="hidden" id="hddId" name="hddId" value="<?php echo $idProgramming; ?>"/>
					<input type="hidden" id="hddIdParent" name="hddIdParent" value="<?php echo $idParent; ?>"/>
					
					<div class="form-group text-left">
						<label class="control-label" for="worker">Worker</label>
						<select name="worker" id="worker" class="form-control" required>
							<option value=''>Select...</option>
							<?php for ($i = 0; $i < count($workersList); $i++) { ?>
								<option value="<?php echo $workersList[$i]["id_user"]; ?>" ><?php echo $workersList[$i]["first_name"] . ' ' . $workersList[$i]["last_name"]; ?></option>	
							<?php } ?>
						</select>
					</div>
					
					<div class="form-group">
						<div class="row" align="center">
							<div style="width:50%;" align="center">
								<input type="submit" id="btnSubmitWorker" name="btnSubmitWorker" value="Save" class="btn btn-primary"/>
							</div>
						</div>
					</div>
					
					<div class="form-group">
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
						
				</form>
			</div>

		</div>
	</div>
</div>  
<?php } ?>                     
<!--FIN Modal para adicionar WORKER -->


<!-- Tables -->
<script>
$(document).ready(function() {
	$('#dataTables').DataTable({
		responsive: true,
		"ordering": false,
		"pageLength": 100,
		"info": false
	});
});
</script>