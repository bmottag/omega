<script type="text/javascript" src="<?php echo base_url("assets/js/validate/incidences/incident_v2.js"); ?>"></script>

<link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>


<div id="page-wrapper">
	<br>

<form  name="form" id="form" class="form-horizontal" method="post"  >
	<input type="hidden" id="hddIdentificador" name="hddIdentificador" value="<?php echo $information?$information[0]["id_incident"]:""; ?>"/>
	<input type="hidden" id="incidencesType" name="incidencesType" value="incident"/>
	
	<!-- /.row -->
	<div class="row">
		<div class="col-lg-12">
			<div class="panel panel-info">
				<div class="panel-heading">
					<a class="btn btn-info btn-xs" href=" <?php echo base_url().'incidences/incident'; ?> "><span class="glyphicon glyphicon glyphicon-chevron-left" aria-hidden="true"></span> Go back </a> 
					<i class="fa fa-ambulance"></i> <strong>INCIDENCES</strong> - INCIDENT/ACCIDENT REPORT
				</div>
				<div class="panel-body">

<?php
$retornoExito = $this->session->flashdata('retornoExito');
if ($retornoExito) {
    ?>
	<div class="col-lg-12">	
		<div class="alert alert-success">
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

<!-- INICIO FIRMA -->

<?php if($information){ ?>

				<div class="col-lg-6">
                    <div class="panel panel-primary">
                        <div class="panel-heading">
                            <i class="fa fa-edit fa-fw"></i> <strong>Supervisor</strong> - <?php echo $information[0]['supervisor'];  ?>
                        </div>
                        <!-- /.panel-heading -->
                        <div class="panel-body">
						
							<div class="form-group">
								<div class="row" align="center">
									<div style="width:70%;" align="center">
										 
<?php 
								
	$class = "btn-primary";						
if($information[0]["supervisor_signature"]){ 
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
					<h4 class="modal-title">Supervisor Signature</h4>      </div>      
				<div class="modal-body text-center"><img src="<?php echo base_url($information[0]["supervisor_signature"]); ?>" class="img-rounded" alt="Hauling Supervisor Signature" width="304" height="236" />   </div>      
				<div class="modal-footer">        
					<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>     
				</div>  
			</div>  
		</div>
	</div>

	<?php
	}
	?>

	<a class="btn <?php echo $class; ?>" href="<?php echo base_url("incidences/add_signature/incident/supervisor/" . $information[0]["id_incident"]); ?>"><span class="glyphicon glyphicon-edit" aria-hidden="true"></span> Supervisor Signature </a>

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
                            <i class="fa fa-edit fa-fw"></i> <strong>Safety Coordinator</strong> - <?php echo $information[0]['coordinator'];  ?>
                        </div>
                        <!-- /.panel-heading -->
                        <div class="panel-body">

							<div class="form-group">
								<div class="row" align="center">
									<div style="width:70%;" align="center">								 
<?php 
								
$class = "btn-info";						
if($information[0]["coordinator_signature"]){ 
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
				<h4 class="modal-title">Safety Coordinator Signature</h4>      </div>      
<div class="modal-body text-center"><img src="<?php echo base_url($information[0]["coordinator_signature"]); ?>" class="img-rounded" alt="Safety Coordinator Signature" width="304" height="236" />   </div>      
			<div class="modal-footer">        
				<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>     
			</div>  
		</div>  
	</div>
</div>

<?php
}
?>

<a class="btn <?php echo $class; ?>" href="<?php echo base_url("incidences/add_signature/incident/coordinator/" . $information[0]["id_incident"]); ?>"><span class="glyphicon glyphicon-edit" aria-hidden="true"></span> Coordinator Signature </a>

							
									</div>
								</div>
							</div>

						</div>
						<!-- /.panel-body -->
					</div>
				</div>
<?php } ?>	



<!-- FIN FIRMA -->
<p class="text-danger text-left">Fields with * are required.</p>
								
						<div class="form-group">
							<label class="col-sm-4 control-label" for="incidentType">Incident/Accident  type: *</label>
							<div class="col-sm-5">
								<select name="incidentType" id="incidentType" class="form-control" <?php echo $deshabilitar; ?>>
									<option value=''>Select...</option>
									<?php for ($i = 0; $i < count($incidentType); $i++) { ?>
										<option value="<?php echo $incidentType[$i]["id_incident_type"]; ?>" <?php if($information && $information && $information[0]["fk_incident_type"] == $incidentType[$i]["id_incident_type"]) { echo "selected"; }  ?>><?php echo $incidentType[$i]["incident_type"]; ?></option>	
									<?php } ?>
								</select>
							</div>
						</div>
					<!--	
						<div class="form-group">
							<label class="col-sm-4 control-label" for="involved">Person(s) involved? *</label>
							<div class="col-sm-5">
							<textarea id="involved" name="involved" placeholder="Who was involved?"  class="form-control" rows="2"><?php echo $information?$information[0]["people_involved"]:""; ?></textarea>
							</div>
						</div>
					-->
						
						<div class="form-group">
							<label class="col-sm-4 control-label" for="happened">What happened? *</label>
							<div class="col-sm-5">
							<textarea id="happened" name="happened" placeholder="What happened?"  class="form-control" rows="2"><?php echo $information?$information[0]["what_happened"]:""; ?></textarea>
							</div>
						</div>
																	
						<div class="form-group">
<script>
	$( function() {
		$( "#date" ).datepicker({
			changeMonth: true,
			dateFormat: 'yy-mm-dd'
		});
	});
</script>
							<label class="col-sm-4 control-label" for="date">Date of Incident: *</label>
							<div class="col-sm-5">
								<input type="text" class="form-control" id="date" name="date" value="<?php echo $information?$information[0]["date_incident"]:""; ?>" placeholder="Date" required <?php echo $deshabilitar; ?> />
							</div>
						</div>
						
						<div class="form-group">
							<label class="col-sm-4 control-label" for="fromSite">Time: *</label>
							<div class="col-sm-2">
							<?php 
								if($information){
									$timeIn = explode(":",$information[0]["time"]);
									$hourIn = $timeIn[0];
									$minIn = $timeIn[1];
								}
							?>
								<select name="hour" id="hour" class="form-control" required>
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
								<select name="min" id="min" class="form-control" required>
									<option value="00" <?php if($information && $minIn == "00") { echo "selected"; }  ?>>00</option>
									<option value="15" <?php if($information && $minIn == "15") { echo "selected"; }  ?>>15</option>
									<option value="30" <?php if($information && $minIn == "30") { echo "selected"; }  ?>>30</option>
									<option value="45" <?php if($information && $minIn == "45") { echo "selected"; }  ?>>45</option>
								</select>
							</div>
						</div>
						
						<div class="form-group">
							<label class="col-sm-4 control-label" for="callManager">Did you call your Manager or Supervisor? *</label>
							<div class="col-sm-5">
								<label class="radio-inline">
									<input type="radio" name="callManager" id="callManager1" value=1 <?php if($information && $information[0]["call_manager"] == 1) { echo "checked"; }  ?>>Yes
								</label>
								<label class="radio-inline">
									<input type="radio" name="callManager" id="callManager2" value=2 <?php if($information && $information[0]["call_manager"] == 2) { echo "checked"; }  ?>>No
								</label>
							</div>
						</div>
						
				</div>
			</div>
		</div>
	</div>			

<?php if($information){ ?>
	<div class="row">
		<div class="col-lg-12">				
			<div class="panel panel-info">
				<div class="panel-heading">
					<strong>Person(s) involved *</strong> 
				</div>
				<div class="panel-body">
					<div class="table-responsive">
<!--INICIO TRABAJADORS -->
					<div class="col-lg-12">													
						<button type="button" class="btn btn-default btn-block" data-toggle="modal" data-target="#modalPerson" id="x">
								<span class="glyphicon glyphicon-plus" aria-hidden="true"></span> Add Person Involved
						</button>
						<br>
					</div>


				<?php 
					if($personsInvolved){
				?>
						<table class="table table-hover">
							<thead>
								<tr>
									<th>Name</th>
									<th class='text-center'>Movil number</th>
									<th class='text-center'>Signature</th>
									<th class='text-center'>Delete</th>
								</tr>
							</thead>
					<?php
						foreach ($personsInvolved as $data):
							echo "<tr>";					
							echo "<td >" . $data['person_name'] . "</td>";
							echo "<td class='text-center'>" . $data['person_movil_number'] . "</td>";
							echo "<td class='text-center'>";
							$class = "btn-primary";

							if($data['person_signature']){ 
								$class = "btn-default";
								
						?>
								<button type="button" class="btn btn-default btn-sm" data-toggle="modal" data-target="#<?php echo $data['id_incident_person'] . "SubcontractorModal"; ?>" id="<?php echo $data['id_incident_person']; ?>">
									<span class="glyphicon glyphicon-eye-open" aria-hidden="true"></span> View Signature
								</button>

								<div id="<?php echo $data['id_incident_person'] . "SubcontractorModal"; ?>" class="modal fade" role="dialog">  
									<div class="modal-dialog">
										<div class="modal-content">      
											<div class="modal-header">        
												<button type="button" class="close" data-dismiss="modal">×</button>        
												<h4 class="modal-title">Person Signature</h4>      </div>      
											<div class="modal-body text-center"><img src="<?php echo base_url($data['person_signature']); ?>" class="img-rounded" alt="Meeting conducted by Signature" width="304" height="236" />   </div>      
											<div class="modal-footer">    
												<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>     
											</div>  
										</div>  
									</div>
								</div>
						<?php
							}
						?>
							<a class='btn <?php echo $class; ?> btn-sm' href='<?php echo base_url('incidences/add_signature/personsInvolved/' . $data['id_incident_person'] . '/' . $data['fk_id_incident']) ?>' id="btn-delete">
									<span class="glyphicon glyphicon-edit" aria-hidden="true"> </span>  Signature
							</a>
						<?php
							echo "</td>"; 
							echo "<td class='text-center'>";
						?>
							<a class='btn btn-danger btn-sm' href='<?php echo base_url('incidences/deleteIncidentPersonInvolved/' . $data['id_incident_person'] . '/' . $data['fk_id_incident']) ?>' id="btn-delete">
									<span class="glyphicon glyphicon-trash" aria-hidden="true"> </span>
							</a>
						<?php
							echo "</td>";
							echo "</tr>";
						endforeach;
					?>
						</table>
				<?php } ?>
<!--FIN TRABAJADORS -->
					</div>			
				</div>
			</div>
		</div>
	</div>
<?php } ?>
								
								
	<div class="row">
		<div class="col-lg-12">				
			<div class="panel panel-info">
				<div class="panel-heading">
					<strong>What was the immediate cause? *</strong> (sequence of unsafe acts that led to incident. ex water on the floor, awkward positioning)
				</div>
				<div class="panel-body">
					<div class="form-group">
						<div class="col-sm-12">
						<textarea id="cause" name="cause" class="form-control" rows="4"><?php echo $information?$information[0]["immediate_cause"]:""; ?></textarea>
						</div>
					</div>				
				</div>
			</div>
		</div>
	</div>
	
	<div class="row">
		<div class="col-lg-12">				
			<div class="panel panel-info">
				<div class="panel-heading">
					<strong>What were the contributting factors? *</strong> (what caused the behavior or unsafe act, what controls were ignored)
				</div>
				<div class="panel-body">
					<div class="form-group">
						<div class="col-sm-12">
						<textarea id="uderlyingCauses" name="uderlyingCauses" class="form-control" rows="4"><?php echo $information?$information[0]["uderlying_causes"]:""; ?></textarea>
						</div>
					</div>				
				</div>
			</div>
		</div>
	</div>
		
	<div class="row">
		<div class="col-lg-12">				
			<div class="panel panel-info">
				<div class="panel-heading">
					<strong>What training, instruction, orientation, and cautions were given before the incident: *</strong>
				</div>
				<div class="panel-body">
					<div class="form-group">
						<div class="col-sm-12">
						<textarea id="instructionBefore" name="instructionBefore" class="form-control" rows="5"><?php echo $information?$information[0]["instruction_before"]:""; ?></textarea>
						</div>
					</div>				
				</div>
			</div>
		</div>
	</div>
	
	<div class="row">
		<div class="col-lg-12">				
			<div class="panel panel-info">
				<div class="panel-heading">
					<strong>Corrective Actions: </strong> What actions were taken to correct immediately? *
				</div>
				<div class="panel-body">
					<div class="form-group">
						<div class="col-sm-12">
						<textarea id="correctiveActions" name="correctiveActions" class="form-control" rows="5"><?php echo $information?$information[0]["corrective_actions"]:""; ?></textarea>
						</div>
					</div>				
				</div>
			</div>
		</div>
	</div>
	
	<div class="row">
		<div class="col-lg-12">				
			<div class="panel panel-info">
				<div class="panel-heading">
					<strong>Preventative Action: </strong> How can similar incidents be prevented in the future? *
				</div>
				<div class="panel-body">
					<div class="form-group">
						<div class="col-sm-12">
						<textarea id="preventativeAction" name="preventativeAction" class="form-control" rows="5"><?php echo $information?$information[0]["preventative_action"]:""; ?></textarea>
						</div>
					</div>				
				</div>
			</div>
		</div>
	</div>
								
	<div class="row">
		<div class="col-lg-12">				
			<div class="panel panel-info">
				<div class="panel-heading">
					<strong>IN CHARGE</strong>
				</div>
				<div class="panel-body">								
						<div class="form-group">
							<label class="col-sm-4 control-label" for="manager">Supervisor: *</label>
							<div class="col-sm-5">
								<select name="manager" id="manager" class="form-control" <?php echo $deshabilitar; ?>>
									<option value=''>Select...</option>
									<?php for ($i = 0; $i < count($workersList); $i++) { ?>
										<option value="<?php echo $workersList[$i]["id_user"]; ?>" <?php if($information && $information[0]["manager_user"] == $workersList[$i]["id_user"]) { echo "selected"; }  ?>><?php echo $workersList[$i]["first_name"] . ' ' . $workersList[$i]["last_name"]; ?></option>	
									<?php } ?>
								</select>								
							</div>
						</div>

						<div class="form-group">
							<label class="col-sm-4 control-label" for="coordinator">Safety Coordinator: *</label>
							<div class="col-sm-5">
								<select name="coordinator" id="coordinator" class="form-control" <?php echo $deshabilitar; ?>>
									<option value=''>Select...</option>
									<?php for ($i = 0; $i < count($workersList); $i++) { ?>
										<option value="<?php echo $workersList[$i]["id_user"]; ?>" <?php if($information && $information[0]["safety_user"] == $workersList[$i]["id_user"]) { echo "selected"; }  ?>><?php echo $workersList[$i]["first_name"] . ' ' . $workersList[$i]["last_name"]; ?></option>	
									<?php } ?>
								</select>								
							</div>
						</div>

				</div>
			</div>
		</div>
	</div>
	
	<div class="row">
		<div class="col-lg-12">				
			<div class="panel panel-info">
				<div class="panel-heading">
					<strong>COMMENTS</strong>
				</div>
				<div class="panel-body">													
					<div class="form-group">
						<div class="col-sm-12">
						<textarea id="comments" name="comments" placeholder="Comments"  class="form-control" rows="5"><?php echo $information?$information[0]["comments"]:""; ?></textarea>
						</div>
					</div>

				</div>
			</div>
		</div>
	</div>
				
								
								

						<div class="form-group">
							<div class="row" align="center">
								<div style="width:100%;" align="center">
									<button type="button" id="btnSubmit" name="btnSubmit" class="btn btn-primary" >
										Save <span class="glyphicon glyphicon-floppy-disk" aria-hidden="true">
									</button>
								</div>
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

</div>
<!-- /#page-wrapper -->

<!--INICIO Modal para adicionar Person -->
<div class="modal fade text-center" id="modalPerson" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">    
	<div class="modal-dialog" role="document">
		<div class="modal-content" id="tablaDatos">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
				<h4 class="modal-title" id="exampleModalLabel">ADD PERSON INVOLVED</h4>
			</div>

			<div class="modal-body">
				<form name="formPerson" id="formPerson" role="form" method="post" action="<?php echo base_url("incidences/save_person_involved") ?>" >
					<input type="hidden" id="hddId" name="hddId" value="<?php echo $information?$information[0]["id_incident"]:""; ?>"/>
					
					<div class="row">
						<div class="col-sm-6">
							<div class="form-group text-left">
								<label class="control-label" for="workerName">Person Name: *</label>
								<input type="text" id="workerName" name="workerName" class="form-control" placeholder="Person Name" required >
							</div>
						</div>

						<div class="col-sm-6">	
							<div class="form-group text-left">
								<label for="phone_number">Movil number:</label>
								<input type="number" id="phone_number" name="phone_number" class="form-control" placeholder="Worker movil number" maxlength="12">
							</div>
						</div>
					</div>

					<div class="form-group">
						<div class="row" align="center">
							<div style="width:50%;" align="center">
								<button type="submit" id="btnSubmit" name="btnSubmit" class="btn btn-primary" >
									Save <span class="glyphicon glyphicon-floppy-disk" aria-hidden="true">
								</button>
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
<!--FIN Modal para adicionar PERSON -->