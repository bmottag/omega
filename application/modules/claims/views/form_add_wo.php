<script type="text/javascript" src="<?php echo base_url("assets/js/validate/claims/add_wo.js"); ?>"></script>

<div id="page-wrapper">
	<br>
	
	<!-- /.row -->
	<div class="row">
		<div class="col-lg-12">
			<div class="panel panel-primary">
				<div class="panel-heading">
					<a class="btn btn-primary btn-xs" href=" <?php echo base_url().'claims/upload_wo/' . $idClaim; ?> "><span class="glyphicon glyphicon glyphicon-chevron-left" aria-hidden="true"></span> Go back </a>
					<i class="fa fa-money"></i> 
					<strong>WORK ORDER <br>
					Job Code/Name:</strong> <?php echo $jobInfo[0]['job_description']; ?>
				</div>
				<div class="panel-body">
					<?php
					    if(!$WOList){ 
					?>
					        <div class="col-lg-12">
					            <small>
					                <p class="text-danger"><span class="glyphicon glyphicon-alert" aria-hidden="true"></span> There are no records in the database without claims for this Job Code/Name.</p>
					            </small>
					        </div>
					<?php
					    }else{
					?> 

					<div class="alert alert-danger">
						<strong>Select </strong> all work orders to be assigned.
					</div>
					<form  name="form" id="form" class="form-horizontal" method="post" >
						<input type="hidden" id="hddId" name="hddId" value="<?php echo $idClaim; ?>"/>
								
                        <table class="table table-striped table-hover table-condensed table-bordered">
                            <tr class="info">
								<th class="text-center">Check</th>
								<th class="text-center">W.O. #</th>
								<th class="text-center">Supervisor</th>
								<th class="text-center">Date W.O.</th>
								<th class="text-center">More information</th>
								<th class="text-center">Subtotal</th>
                            </tr>
                            <?php
							//se va a consultar registros de la WO
							$ci = &get_instance();
							$ci->load->model("workorders/workorders_model");

                            foreach ($WOList as $lista):
                            	//buscar informacion por submodulo para sacar el subtotal
								$arrParam = array('idWorkOrder' =>$lista['id_workorder']);
								$workorderPersonal = $this->workorders_model->get_workorder_personal($arrParam);//workorder personal list
								$workorderMaterials = $this->workorders_model->get_workorder_materials($arrParam);//workorder material list
								$workorderReceipt = $this->workorders_model->get_workorder_receipt($arrParam);//workorder ocasional list
								$workorderEquipment = $this->workorders_model->get_workorder_equipment($arrParam);//workorder equipment list
								$workorderOcasional = $this->workorders_model->get_workorder_ocasional($arrParam);//workorder ocasional list

								$totalPersonal = 0;
								$totalMaterial = 0;
								$totalReceipt = 0;
								$totalEquipment = 0;
								$totalOcasional = 0;
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
								// INICIO RECEIPT
								if($workorderReceipt)
								{ 
									foreach ($workorderReceipt as $data):
											$totalReceipt = $data['value'] + $totalReceipt;
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

								$total = $totalPersonal + $totalMaterial + $totalReceipt + $totalOcasional + $totalEquipment;

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
                                echo '<tr>';
                                echo '<td class="text-center">';
                                $data = array(
                                    'name' => 'wo[]',
                                    'id' => 'wo',
                                    'value' => $lista['id_workorder'],
                                    'style' => 'margin:10px'
                                );
                                echo form_checkbox($data);
                                echo '</td>';
								echo "<td class='text-center'>";
								echo "<a href='" . base_url('workorders/add_workorder/' . $lista['id_workorder']) . "' target='_blanck'>" . $lista['id_workorder'] . "</a>";
								echo '<p class="' . $clase . '"><i class="fa ' . $icono . ' fa-fw"></i>' . $valor . '</p>';
								echo "<a href='" . base_url('workorders/generaWorkOrderPDF/' . $lista['id_workorder']) . "' target='_blanck'><img src='" . base_url_images('pdf.png') . "' ></a>";
								echo '</td>';
								echo '<td>' . $lista['name'] . '</td>';
								echo '<td class="text-center">' . $lista['date'] . '</td>';
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
								if($totalReceipt>0){
									echo "<strong>Receipt: </strong>$ " . number_format($totalReceipt, 2) . "</br>";
								}
								if($totalEquipment>0){
									echo "<strong>Equipment: </strong>$ " . number_format($totalEquipment, 2) . "</br>";
								}
								if($totalOcasional>0){
									echo "<strong>Ocasional: </strong>$ " . number_format($totalOcasional, 2) . "</br>";
								}
								echo "</p>";
								echo "<p class='text-danger'><strong>Subtotal: </strong>$ " . number_format($total, 2) . "</p>";
								echo '</td>';
                                echo "</tr>";
                            endforeach
                            ?>
                        </table>	

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

						<div class="form-group">
							<div class="row" align="center">
								<div style="width:50%;" align="center">
									<button type="button" id="btnSubmit" name="btnSubmit" class="btn btn-primary" >
										Save <span class="glyphicon glyphicon-floppy-disk" aria-hidden="true">
									</button> 
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