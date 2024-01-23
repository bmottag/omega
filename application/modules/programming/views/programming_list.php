<script type="text/javascript" src="<?php echo base_url('assets/js/validate/programming/programming.js'); ?>"></script>

<link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>

<div id="page-wrapper">
	<br>

	<!-- /.row -->
	<div class="row">
		<div class="col-lg-12">
			<div class="panel panel-warning">
				<div class="panel-heading">

					<?php
					if ($idProgramming != 'x') {
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

					if ($userRol == 4) {
						$deshabilitar = 'disabled';
					}
					?>
					<?php if (!$deshabilitar) { ?>
						<a class='btn btn-outline btn-warning btn-block' href='<?php echo base_url('programming/add_programming'); ?>'>
							<span class="glyphicon glyphicon-edit" aria-hidden="true"> </span> New Planning
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
					if ($information) {
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
								foreach ($information as $lista) :
									$idParent = $lista["parent_id"];
									$flagDate = $lista["flag_date"];
									$flagText = '';
									if ($lista["flag_date"] == 2) {
										$flagText = "text-violeta";
									}
									echo "<tr class='" . $flagText . "'>";
									echo "<td class='text-center'>";
									echo ($flagDate == 2 && $idParent != null && $idParent != '') ? "<b>Child</b><br>" . $idParent : ($flagDate == 1 ? "" : "<b>Parent</b><br>" . $lista["id_programming"]);
									echo "</td>";
									echo "<td class='text-center'>" . $lista['date_programming'] . "</td>";
									echo "<td class='text-center'>" . $lista['job_description'] . "</td>";
									echo "<td>" . $lista['observation'] . "</td>";
									echo "<td class='text-center'><small>";


									//consultar si la fecha de la programacion es mayor a la fecha actual
									$fechaProgramacion = $lista['date_programming'];

									$datetime1 = date_create($fechaProgramacion);
									$datetime2 = date_create(date("Y-m-d"));


									if ($datetime1 < $datetime2) {
										echo '<p class="text-danger"><strong>OVERDUE</strong></p>';
									} else {

										if ($lista['state'] == 2) {
											echo '<p class="text-success"><strong>COMPLETE</strong></p>';
										} elseif ($lista['state'] == 1) {
											echo '<p class="text-danger"><strong>INCOMPLETE</strong></p>';
										}
								?>

										<?php
										if (!$deshabilitar) {
										?>

											<a href='<?php echo base_url("programming/add_programming/" . $lista['id_programming']); ?>' class='btn btn-info btn-xs' title="Edit"><i class='fa fa-pencil'></i></a>

											<?php if ($informationWorker) { ?>
												<button type="button" class="btn btn-warning btn-xs" data-toggle="modal" data-target="#modalWorker" id="x">
													<i class="fa fa-user"></i>
												</button>
											<?php } elseif ($lista['state'] == 1 && $idProgramming != 'x') { ?>
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
									if (($datetime1 >= $datetime2) && $informationWorker && !$deshabilitar) {

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
					if ($dayoffList) {
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
									foreach ($dayoffList as $lista) :
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
					if ($informationWorker) {
					?>

						<div class="table-responsive">
							<table id="dataTablesWorker" class="table table-striped jambo_table bulk_action" cellspacing="0" width="100%">

								<thead>
									<tr class="headings">
										<th class="column-title" colspan="4">-- WORKERS --</th>
										<th class="column-title">
											<?php
											if ($flagDate == 2 && ($idParent == null || $idParent == '')) {
											?>
												<form name="generateChildWorkers" id="generateChildWorkers" method="post" action="<?php echo base_url("programming/generate_child_workers"); ?>">
													<input type="hidden" id="hddIdProgramming" name="hddIdProgramming" value="<?php echo $idProgramming; ?>" />
													<input type="submit" id="btnSubmit" name="btnSubmit" value="Generate Child Workers" class="btn btn-violeta" />
												</form>
											<?php
											}
											?>
										</th>
										<?php
										if ($job_planning == 1) {
										?>
										<th class="column-title" colspan="3">
											<div class="col-lg-12">
												<div class="chat-panel panel panel-violeta">
													<div class="panel-heading">
														<i class="fa fa-copy fa-fw"></i> Clone this Planning for the asdfasdf Date
													</div>

													<div class="panel-footer">
														<form name="clonePlanning" id="clonePlanning" method="post">
															<input type="hidden" id="hddIdProgramming" name="hddIdProgramming" value="<?php echo $idProgramming; ?>" />
															<script>
																$(function() {
																	$("#date").datepicker({
																		changeMonth: true,
																		changeYear: true,
																		dateFormat: 'yy-mm-dd',
																		minDate: '0'
																	});
																});
															</script>

															<div class="input-group">
																<input type="text" class="form-control" id="date" name="date" value="" placeholder="Date" required />
																<span class="input-group-btn">
																	<button type="button" class="btn btn-violeta btn-sm btn-service-order-parts" id="btnSubmitClone" name="btnSubmitClone">
																		<span class="glyphicon glyphicon-plus" aria-hidden="true"></span> Clone Planning
																	</button>
																</span>
															</div>
														</form>
													</div>
												</div>
											</div>
											<div class="col-lg-12">
												<div id="div_error" style="display:none">
													<div class="alert alert-danger"> <strong>Error!!!</strong> Ask for help. </div>
												</div>

												<div id="div_guardado" style="display:none">
													<div class="alert alert-success"> <strong>Ok!</strong> You have cloned the Planning.</div>
												</div>
											</div>
										</th>
										<?php
										}
										?>
									</tr>

									<tr class="headings">
										<th class="column-title" style="width: 10%"><small>Name</small></th>
										<th class="column-title text-center" style="width: 12%"><small>Time In</small></th>
										<th class="column-title text-center" style="width: 13%"><small>Site</small></th>
										<th class="column-title text-center" style="width: 13%"><small>FLHA/TOOL BOX</small></th>
										<th class="column-title text-center" style="width: 21%"><small>Description</small></th>
										<th class="column-title text-center" style="width: 22%"><small>Equipment</small></th>
										<th class="column-title text-center" style="width: 9%"><small>Creat WO</small></th>
										<th class="column-title text-center" style="width: 9%"><small>Links</small></th>
									</tr>
								</thead>

								<tbody>

									<?php
									$mensaje = "";

									foreach ($informationWorker as $data) :
										$mensaje .= "<br>";
										switch ($data['site']) {
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
										$mensaje .= $data['description'] ? "<br>" . $data['description'] : "";
										$mensaje .= $data['unit_description'] ? "<br>" . $data['unit_description'] : "";

										if ($data['safety'] == 1) {
											$mensaje .= "<br>Do FLHA";
										} elseif ($data['safety'] == 2) {
											$mensaje .= "<br>Do Tool Box";
										} elseif ($data['safety'] == 3) {
											$mensaje .= "<br>Job site orientation";
										}

										$mensaje .= "<br>";


										echo "<tr>";
										echo "<td ><small>$data[name]</small></td>";

										$idRecord = $data['id_programming_worker'];
										$fkIdProgramming = $data['fk_id_programming'];
									?>

										<form name="worker_<?php echo $idRecord ?>" id="worker_<?php echo $idRecord ?>" method="post" action="<?php echo base_url("programming/update_worker"); ?>">

											<input type="hidden" id="hddId" name="hddId" value="<?php echo $idRecord; ?>" />
											<input type="hidden" id="hddIdProgramming" name="hddIdProgramming" value="<?php echo $fkIdProgramming; ?>" />

											<td>
												<select name="hora_inicio" class="form-control js-example-basic-single" required>
													<option value=''>Select...</option>
													<?php for ($i = 0; $i < count($horas); $i++) { ?>
														<option value="<?php echo $horas[$i]["id_hora"]; ?>" <?php
																												if ($horas[$i]["id_hora"] == $data["fk_id_hour"]) {
																													echo 'selected="selected"';
																												}
																												?>><?php echo $horas[$i]["hora"]; ?>
														</option>
													<?php } ?>
												</select>
											</td>

											<td>
												<select name="site" class="form-control js-example-basic-single" required>
													<option value="">Select...</option>
													<option value=1 <?php if ($data["site"] == 1) {
																		echo "selected";
																	}  ?>>At the yard</option>
													<option value=2 <?php if ($data["site"] == 2) {
																		echo "selected";
																	}  ?>>At the site</option>
													<option value=3 <?php if ($data["site"] == 3) {
																		echo "selected";
																	}  ?>>At Terminal</option>
												</select>
											</td>

											<td>
												<select name="safety" class="form-control js-example-basic-single">
													<option value="">Select...</option>
													<option value=1 <?php if ($data["safety"] == 1) {
																		echo "selected";
																	}  ?>>FLHA</option>
													<option value=2 <?php if ($data["safety"] == 2) {
																		echo "selected";
																	}  ?>>Tool Box</option>
													<option value=3 <?php if ($data["safety"] == 3) {
																		echo "selected";
																	}  ?>>Job Site Orientation</option>
												</select>
											</td>

											<td>
												<input type="text" id="description" name="description" class="form-control" placeholder="Description" value="<?php echo $data['description']; ?>">
											</td>

											<td>
												<select multiple="multiple" name="machine[]" class="form-control js-example-basic-multiple">
													<option value=''>Select...</option>
													<?php for ($i = 0; $i < count($informationVehicles); $i++) { ?>
														<option value="<?php echo $informationVehicles[$i]["id_truck"]; ?>" <?php if ($data["fk_id_machine"] != "" && ($data["fk_id_machine"] == $informationVehicles[$i]["id_truck"] || in_array($informationVehicles[$i]["id_truck"], json_decode($data["fk_id_machine"])))) {
																																echo "selected";
																															}  ?>><?php echo $informationVehicles[$i]["unit_number"]; ?></option>
													<?php } ?>
												</select>
											</td>

											<td>
												<select name="creat_wo" class="form-control js-example-basic-single">
													<option value="">Select...</option>
													<option value=1 <?php if ($data["creat_wo"] == 1) {
																		echo "selected";
																	}  ?>>Yes</option>
													<option value=2 <?php if ($data["creat_wo"] == 2) {
																		echo "selected";
																	}  ?>>No</option>
												</select>
											</td>
											<td class='text-center'>
												<?php
												if (($datetime1 >= $datetime2) && $informationWorker && !$deshabilitar) {
												?>
													<input type="submit" id="btnSubmit" name="btnSubmit" value="Save" class="btn btn-primary btn-xs" />
												<?php
												}
												?>
										</form>

										<br><br>
										<?php
										if (($datetime1 >= $datetime2) && $informationWorker && !$deshabilitar) {
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

				<!--INICIO MATERIALS -->
				<div class="panel-body">
					<?php if (!$deshabilitar) { ?>
						<div class="col-lg-12">

							<button type="button" class="btn btn-success btn-block  btn-materials" data-toggle="modal" data-target="#modalMaterials" id="<?php echo 'material-' . $information[0]["id_programming"]; //se coloca un ID diferente para que no entre en conflicto con los otros modales 
																																							?>">
								<span class="glyphicon glyphicon-plus" aria-hidden="true"></span> Add Materials VCI
							</button><br>
						</div>
					<?php } ?>

					<?php
					if ($programmingMaterials) {
					?>
						<table class="table table-bordered table-striped table-hover table-condensed">
							<tr class="success">
								<th class="text-center">Info. Material</th>
								<th class="text-center">Description</th>
								<th class="text-center">Quantity</th>
								<th class="text-center">Unit</th>
								<th class="text-center">Links</th>
							</tr>
							<?php
							foreach ($programmingMaterials as $data) :
								echo "<tr>";
								echo "<td ><small><strong>Material</strong><br>" . $data['material'] . "</small></td>";

								$idRecord = $data['id_programming_material'];
							?>
								<form name="material_<?php echo $idRecord ?>" id="material_<?php echo $idRecord ?>" method="post" action="<?php echo base_url("programming/updated_material"); ?>">
									<input type="hidden" id="hddId" name="hddId" value="<?php echo $idRecord; ?>" />
									<input type="hidden" id="hddidProgramming" name="hddidProgramming" value="<?php echo $data['fk_id_programming']; ?>" />
									<td>
										<textarea id="description" name="description" class="form-control" rows="3" required <?php echo $deshabilitar; ?>><?php echo $data['description']; ?></textarea>
									</td>

									<td>
										<input type="text" id="quantity" name="quantity" class="form-control" placeholder="Quantity" value="<?php echo $data['quantity']; ?>" required <?php echo $deshabilitar; ?>>
									</td>

									<td>
										<input type="text" id="unit" name="unit" class="form-control" placeholder="Unit" value="<?php echo $data['unit']; ?>" required <?php echo $deshabilitar; ?>>
									</td>

									<td class='text-center'>
										<button type="submit" id="btnSubmit" name="btnSubmit" class="btn btn-primary btn-xs" title="Save" <?php echo $deshabilitar; ?>>
											Save <span class="glyphicon glyphicon-floppy-disk" aria-hidden="true">
										</button>
								</form>

								<br><br>
								<?php if (!$deshabilitar) { ?>
									<a class='btn btn-danger btn-xs' href='<?php echo base_url('programming/deleteMaterial/' . $data['id_programming_material'] . '/' . $data['fk_id_programming']) ?>' id="btn-delete">
										Delete <i class="fa fa-trash-o"></i>
									</a>
								<?php } else {
									echo "---";
								} ?>

								</td>

								</tr>
							<?php
							endforeach;
							?>
						</table>
					<?php } ?>
				</div>
				<!--FIN MATERIALS -->
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
<?php if ($workersList) { ?>
	<div class="modal fade text-center" id="modalWorker" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
		<div class="modal-dialog" role="document">
			<div class="modal-content" id="tablaDatos">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
					<h4 class="modal-title" id="exampleModalLabel">ADD WORKER</h4>
				</div>

				<div class="modal-body">
					<form name="formWorkerProgramming" id="formWorkerProgramming" role="form" method="post" action="<?php echo base_url("programming/safet_One_Worker_programming") ?>">
						<input type="hidden" id="hddId" name="hddId" value="<?php echo $idProgramming; ?>" />

						<div class="form-group text-left">
							<label class="control-label" for="worker">Worker</label>
							<select name="worker" id="worker" class="form-control" required>
								<option value=''>Select...</option>
								<?php for ($i = 0; $i < count($workersList); $i++) { ?>
									<option value="<?php echo $workersList[$i]["id_user"]; ?>"><?php echo $workersList[$i]["first_name"] . ' ' . $workersList[$i]["last_name"]; ?></option>
								<?php } ?>
							</select>
						</div>

						<div class="form-group">
							<div class="row" align="center">
								<div style="width:50%;" align="center">
									<input type="submit" id="btnSubmitWorker" name="btnSubmitWorker" value="Save" class="btn btn-primary" />
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

<!--INICIO Modal para MATERIAL -->
<div class="modal fade text-center" id="modalMaterials" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
	<div class="modal-dialog" role="document">
		<div class="modal-content" id="tableDataMaterial">

		</div>
	</div>
</div>
<!--FIN Modal para MATERIAL -->

<!-- Tables -->
<script>
	$(document).ready(function() {
		$('#dataTables').DataTable({
			responsive: true,
			"ordering": false,
			"pageLength": 100,
			"info": false
		});

		$('.js-example-basic-multiple').select2();
	});

	$(".btn-materials").click(function() {
		var oID = $(this).attr("id");
		$.ajax({
			type: 'POST',
			url: base_url + 'programming/loadModalMaterials',
			data: {
				'idProgramming': oID
			},
			cache: false,
			success: function(data) {
				$('#tableDataMaterial').html(data);
			}
		});
	});
</script>