<script type="text/javascript" src="<?php echo base_url("assets/js/validate/jobs/tool_box.js"); ?>"></script>

<?php
/**
 * If it is an ADMIN user, show date 
 * @author BMOTTAG
 * @since  11/5/2017
 */
$userRol = $this->session->rol;
if($userRol==99){
?>
<link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
<?php } ?>

<script>
$(function(){ 
	
	$(".btn-success").click(function () {	
			var oID = $(this).attr("id");
            $.ajax ({
                type: 'POST',
				url: base_url + 'jobs/cargarModalNewHazard',
                data: {'idToolBox': oID},
                cache: false,
                success: function (data) {
                    $('#tablaDatosNewHazard').html(data);
                }
            });
	});	

});
</script>

<div id="page-wrapper">
	<br>

	
	<!-- /.row -->
	<div class="row">
		<div class="col-lg-12">
			<div class="panel panel-warning">
				<div class="panel-heading">
					<a class="btn btn-warning btn-xs" href=" <?php echo base_url().'jobs/tool_box/' . $jobInfo[0]['id_job']; ?> "><span class="glyphicon glyphicon glyphicon-chevron-left" aria-hidden="true"></span> Go back </a> 
					<i class="fa fa-cube"></i> <strong>Incident, Hazard, and Scope of Work Review Meeting Form</strong>
				</div>
				<div class="panel-body">
				
					<div class="alert alert-warning">
						<span class="fa fa-briefcase" aria-hidden="true"></span>
						<strong>Job Code/Name: </strong><?php echo $jobInfo[0]['job_description']; ?>
						<br><span class='fa fa-clock-o' aria-hidden='true'></span> <strong>Date: </strong>
						<?php 
						if($information){
								echo $information[0]["date_tool_box"]; 
								
								echo "<br><span class='fa fa-cloud-download' aria-hidden='true'></span> <strong>Download IHSR: </strong>";
						?>
<a href='<?php echo base_url('jobs/generaTemplatePDF/' . $information[0]["id_tool_box"] ); ?>' target="_blank">PDF <img src='<?php echo base_url_images('pdf.png'); ?>' ></a>	
						<?php 
						}else{
								echo date("Y-m-d");
						}
						?>
					</div>

<?php
$retornoExito = $this->session->flashdata('retornoExito');
if ($retornoExito) {
    ?>
    <div class="row">
		<div class="col-lg-12">	
			<div class="alert alert-success">
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
				
				</div>
			</div>
		</div>
	</div>								
	
<p class="text-danger text-left">Fields with * are required.</p>	
<!-- INICIO FIRMA -->
<?php if($information){ ?>
	<div class="row">
				<div class="col-lg-12">
                    <div class="panel panel-primary">
                        <div class="panel-heading">
                            <i class="fa fa-edit fa-fw"></i> Person conducting the meeting
                        </div>
                        <!-- /.panel-heading -->
                        <div class="panel-body">
						
							<div class="form-group">
								<div class="row" align="center">
									<div style="width:70%;" align="center">
										 
<?php 
	$class = "btn-primary";						
if($information[0]["signature"]){ 
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
					<h4 class="modal-title"><?php echo $information[0]["name"]; ?> Signature</h4>      </div>      
				<div class="modal-body text-center"><img src="<?php echo base_url($information[0]["signature"]); ?>" class="img-rounded" alt="Hauling Supervisor Signature" width="304" height="236" />   </div>      
				<div class="modal-footer">        
					<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>     
				</div>  
			</div>  
		</div>
	</div>

	<?php
	}
	?>

	<a class="btn <?php echo $class; ?>" href="<?php echo base_url("jobs/add_signature/supervisor/" . $jobInfo[0]["id_job"] . "/" . $information[0]["id_tool_box"] . "/x"); ?>"><span class="glyphicon glyphicon-edit" aria-hidden="true"></span> <?php echo $information[0]["name"]; ?> Signature </a>

									</div>
								</div>
							</div>
												
						</div>
						<!-- /.panel-body -->
					</div>
				</div>
	</div>
<?php } ?>	
<!-- FIN FIRMA -->



<!--INICIO NEW HAZARD -->
<?php if($information){ ?>
	<!-- /.row -->
	<div class="row">
		<div class="col-lg-12">				
			<div class="panel panel-success">
				<div class="panel-heading">
					New hazards NOT consider on the FLHA or JHA
				</div>
				<div class="panel-body">
					<div class="col-lg-12">													
						<button type="button" class="btn btn-success btn-lg btn-block" data-toggle="modal" data-target="#modalNewHazard" id="<?php echo 'hazard-' . $information[0]["id_tool_box"];//se coloca un ID diferente para que no entre en conflicto con los otros modales ?>">
								<span class="glyphicon glyphicon-plus" aria-hidden="true"></span> Add new hazard
						</button><br>
					</div>

<?php 
	if($newHazards){
?>
			<table class="table table-bordered table-striped table-hover table-condensed">
				<tr class="success">
					<td><p class="text-center"><strong>Hazard</strong></p></td>
					<td><p class="text-center"><strong>Type of hazard</strong></p></td>
					<td><p class="text-center"><strong>Recommended actions</strong></p></td>
					<td><p class="text-center"><strong>Save / Delete</strong></p></td>
				</tr>
				<?php
					foreach ($newHazards as $data):
						echo "<tr>";					
						
						$idNewHazard = $data['id_new_hazard'];
						$idToolBox = $data['fk_id_tool_box'];
						$idJob = $jobInfo[0]['id_job'];
				?>
						<form  name="formNewHazard_<?php echo $idNewHazard ?>" id="formNewHazard_<?php echo $idNewHazard ?>" method="post" action="<?php echo base_url("jobs/update_new_hazard"); ?>">
						
						<td>
							<input type="hidden" id="hddIdNewHazard" name="hddIdNewHazard" value="<?php echo $idNewHazard; ?>"/>
							<input type="hidden" id="hddIdToolBox" name="hddIdToolBox" value="<?php echo $idToolBox; ?>"/>
							<input type="hidden" id="hddIdJob" name="hddIdJob" value="<?php echo $idJob; ?>"/>
							<input type="text" id="hazard" name="hazard" class="form-control" placeholder="New hazard" value="<?php echo $data['hazard']; ?>" required >		
						</td>

						<td>
							<select name="hazardType" id="hazardType" class="form-control" required>
								<option value=''>Select...</option>
								<option value=1 <?php if($data["hazard_type"] == 1) { echo "selected"; }  ?>>Chemical</option>
								<option value=2 <?php if($data["hazard_type"] == 2) { echo "selected"; }  ?>>Physical</option>
								<option value=3 <?php if($data["hazard_type"] == 3) { echo "selected"; }  ?>>Biological</option>
							</select>
						</td>
				
						<td class='text-center'>
							<textarea id="actions" name="actions" class="form-control" rows="3"><?php echo $data['actions']; ?></textarea>
						</td>
						
						<td class='text-center'>

<div class="btn-group">							
			<button type="submit" id="btnSubmitUpdate" name="btnSubmitUpdate" class="btn btn-default btn-xs" >
				 Save <span class="glyphicon glyphicon-floppy-disk" aria-hidden="true">
			</button>
										
<button type="button" class="btn btn-danger btn-xs" id="<?php echo $idNewHazard . '-' . $idToolBox . '-' . $idJob; ?>" >
	Delete <span class="fa fa-times fa-fw" aria-hidden="true">
</button>
	
</div>
						</td>
						</form>

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
<?php } ?>	
<!--FIN NEW HAZARD -->


<!--INICIO WORKERS -->								
<?php if($information){ ?>
	<div class="row">
		<div class="col-lg-12">				
			<div class="panel panel-warning">
				<div class="panel-heading">
					<a name="anclaWorker" ></a><strong>VCI WORKERS</strong>
				</div>
				<div class="panel-body">
					<div class="col-lg-12">	
<?php if($toolBoxWorkers){ ?>
												
					<button type="button" class="btn btn-warning btn-lg btn-block" data-toggle="modal" data-target="#modalWorker" id="x">
							<span class="glyphicon glyphicon-plus" aria-hidden="true"></span> Add VCI Workers
					</button>
<?php }else { ?>
					<a href="<?php echo base_url("jobs/add_workers_tool_box/" . $jobInfo[0]["id_job"] . "/" . $information[0]["id_tool_box"]); ?>" class="btn btn-warning btn-lg btn-block"><span class="glyphicon glyphicon-plus" aria-hidden="true"></span> Add VCI Workers</a>
												
<?php } ?>
											
						<br>
					</div>
										
<?php 
	if($toolBoxWorkers){
?>
			<table class="table table-bordered table-striped table-hover table-condensed">
				<tr>
					<td><p class="text-center"><strong>Name</strong></p></td>
					<td><p class="text-center"><strong>Signature</strong></p></td>
					<td><p class="text-center"><strong>Delete</strong></p></td>
				</tr>
				<?php
					foreach ($toolBoxWorkers as $data):
						echo "<tr>";					
						echo "<td ><small>" . $data['name'] . "</small></td>";
						echo "<td class='text-center'><small><center>";
$class = "btn-primary";						
if($data['signature']){ 
	$class = "btn-default";
	
?>
<button type="button" class="btn btn-default" data-toggle="modal" data-target="#<?php echo $data['id_tool_box_worker'] . "wModal"; ?>" id="<?php echo $data['id_tool_box_worker']; ?>">
	<span class="glyphicon glyphicon-eye-open" aria-hidden="true"></span> View Signature
</button>

<div id="<?php echo $data['id_tool_box_worker'] . "wModal"; ?>" class="modal fade" role="dialog">  
	<div class="modal-dialog">
		<div class="modal-content">      
			<div class="modal-header">        
				<button type="button" class="close" data-dismiss="modal">×</button>        
				<h4 class="modal-title">Worker Signature</h4>      </div>      
			<div class="modal-body text-center"><img src="<?php echo base_url($data['signature']); ?>" class="img-rounded" alt="Management/Safety Advisor Signature" width="304" height="236" />   </div>      
			<div class="modal-footer">    
				<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>     
			</div>  
		</div>  
	</div>
</div>
<?php
}
				?>
					
					<a class='btn <?php echo $class; ?>' href='<?php echo base_url('jobs/add_signature/worker/' . $jobInfo[0]["id_job"] . '/' . $data['fk_id_tool_box'] . '/' . $data['id_tool_box_worker']) ?>' id="btn-delete">
							<span class="glyphicon glyphicon-edit" aria-hidden="true"> </span>  Signature
					</a>
					</center>
				<?php
						echo "</small></td>"; 
						echo "<td class='text-center'><small>";
				?>
					<center>
					<a class='btn btn-default' href='<?php echo base_url('jobs/deleteToolBoxWorker/' . $jobInfo[0]["id_job"] . '/' . $data['fk_id_tool_box'] . '/' . $data['id_tool_box_worker']) ?>' id="btn-delete">
							<span class="glyphicon glyphicon-remove" aria-hidden="true"> </span>  Delete
					</a>
					</center>
				<?php
						echo "</small></td>";                     
						echo "</tr>";
					endforeach;
				?>
			</table>
	<?php } ?>
			</div>
		</div>
	</div>
</div>
<?php } ?>
<!--FIN WORKERS -->

	<!--INICIO SUBCONTRACTOR WORKER-->
<?php if($information){ ?>
	<div class="row">
		<div class="col-lg-12">				
			<div class="panel panel-purpura">
				<div class="panel-heading">
					<a name="anclaSubcontractor" ></a><strong>SUBCONTRACTOR WORKERS</strong>
				</div>
				<div class="panel-body">	
										
					<div class="col-lg-12">													
						<button type="button" class="btn btn-purpura btn-lg btn-block" data-toggle="modal" data-target="#modalSubcontractorWorker" id="x">
								<span class="glyphicon glyphicon-plus" aria-hidden="true"></span> Add Subcontractor Worker
						</button>
						<br>
					</div>

										
<?php 
	if($toolBoxSubcontractorsWorkers){
?>
					<table class="table table-bordered table-striped table-hover table-condensed">
						<tr>
							<td><p class="text-center"><strong>Name</strong></p></td>
							<td><p class="text-center"><strong>Company</strong></p></td>
							<td><p class="text-center"><strong>Signature</strong></p></td>
							<td><p class="text-center"><strong>Delete</strong></p></td>
						</tr>
						<?php
							foreach ($toolBoxSubcontractorsWorkers as $data):
								echo "<tr>";					
								echo "<td ><small>" . $data['worker_name'] . "</small></td>";
								echo "<td ><small>" . $data['company_name'] . "</small></td>";
								echo "<td class='text-center'><small><center>";
$class = "btn-primary";						
if($data['signature']){ 
	$class = "btn-default";
	
?>
<button type="button" class="btn btn-default" data-toggle="modal" data-target="#<?php echo $data['id_tool_box_subcontractor'] . "wModal"; ?>" id="<?php echo $data['id_tool_box_subcontractor']; ?>">
	<span class="glyphicon glyphicon-eye-open" aria-hidden="true"></span> View Signature
</button>

<div id="<?php echo $data['id_tool_box_subcontractor'] . "wModal"; ?>" class="modal fade" role="dialog">  
	<div class="modal-dialog">
		<div class="modal-content">      
			<div class="modal-header">        
				<button type="button" class="close" data-dismiss="modal">×</button>        
				<h4 class="modal-title">Worker Signature</h4>      </div>      
			<div class="modal-body text-center"><img src="<?php echo base_url($data['signature']); ?>" class="img-rounded" alt="Management/Safety Advisor Signature" width="304" height="236" />   </div>      
			<div class="modal-footer">    
				<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>     
			</div>  
		</div>  
	</div>
</div>
<?php
}
				?>
					
					<a class='btn <?php echo $class; ?>' href='<?php echo base_url('jobs/add_signature/subcontractor/' . $jobInfo[0]["id_job"] . '/' . $data['fk_id_tool_box'] . '/' . $data['id_tool_box_subcontractor']) ?>' id="btn-delete">
							<span class="glyphicon glyphicon-edit" aria-hidden="true"> </span>  Signature
					</a>
					</center>
				<?php
						echo "</small></td>"; 
						echo "<td class='text-center'><small>";
						?>
							<center>
							<a class='btn btn-default' href='<?php echo base_url('jobs/deleteToolBoxSubcontractorWorker/' . $jobInfo[0]["id_job"] . '/' . $data['fk_id_tool_box'] . '/' . $data['id_tool_box_subcontractor']) ?>' id="btn-delete">
									<span class="glyphicon glyphicon-remove" aria-hidden="true"> </span>  Delete
							</a>
							</center>
						<?php
								echo "</small></td>";                     
								echo "</tr>";
							endforeach;
						?>
					</table>
<?php } ?>

				</div>
			</div>
		</div>
	</div>
<?php } ?>
	<!--FIN SUBCONTRACTOR WORKER-->



<form  name="form" id="form" class="form-horizontal" method="post"  >
	<input type="hidden" id="hddIdentificador" name="hddIdentificador" value="<?php echo $information?$information[0]["id_tool_box"]:""; ?>"/>
	<input type="hidden" id="hddIdJob" name="hddIdJob" value="<?php echo $jobInfo[0]["id_job"]; ?>"/>

															
	<div class="row">
		<div class="col-lg-12">				
			<div class="panel panel-warning">
				<div class="panel-heading">
					<div class="row">
						<div class="col-sm-6">
							<strong>Review Incidents, Accidents or any new safety matter: *</strong> 
						</div>
					
<?php
/**
 * If it is an ADMIN user, show date 
 * @author BMOTTAG
 * @since  11/5/2017
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
						<div class="col-sm-6">
															
								<label class="col-sm-4 control-label" for="date">Date of Issue:</label>
								<div class="col-sm-5">
									<input type="text" class="form-control" id="date" name="date" value="<?php echo $information?$information[0]["date_tool_box"]:""; ?>" placeholder="Date of Issue" />
								</div>
							
						</div>
<?php } ?>					
					</div>
				</div>
				<div class="panel-body">
					<div class="form-group">
						<div class="col-sm-12">
						<textarea id="newSafety" name="newSafety" class="form-control" rows="2"><?php echo $information?$information[0]["new_safety"]:""; ?></textarea>
						</div>
					</div>				
				</div>
			</div>
		</div>
	</div>
	
	<div class="row">
		<div class="col-lg-12">				
			<div class="panel panel-warning">
				<div class="panel-heading">
					<strong>Activities of the Day/Week: *</strong>
				</div>
				<div class="panel-body">
					<div class="form-group">
						<div class="col-sm-12">
						<textarea id="activities" name="activities" class="form-control" rows="2"><?php echo $information?$information[0]["activities"]:""; ?></textarea>
						</div>
					</div>				
				</div>
			</div>
		</div>
	</div>

	<div class="row">
		<div class="col-lg-12">				
			<div class="panel panel-warning">
				<div class="panel-heading">
					<strong>Corrective actions based on today meeting: *</strong>
				</div>
				<div class="panel-body">
					<div class="form-group">
						<div class="col-sm-12">
						<textarea id="correctiveActions" name="correctiveActions" class="form-control" rows="2"><?php echo $information?$information[0]["corrective_actions"]:""; ?></textarea>
						</div>
					</div>				
				</div>
			</div>
		</div>
	</div>	

		
	<div class="row">
		<div class="col-lg-12">				
			<div class="panel panel-warning">
				<div class="panel-heading">
					<strong>Employee Suggestions: *</strong>
				</div>
				<div class="panel-body">
					<div class="form-group">
						<div class="col-sm-12">
						<textarea id="suggestions" name="suggestions" class="form-control" rows="2"><?php echo $information?$information[0]["suggestions"]:""; ?></textarea>
						</div>
					</div>				
				</div>
			</div>
		</div>
	</div>
	

								
								

						<div class="form-group">
							<div class="row" align="center">
								<div style="width:100%;" align="center">							
<button type="button" id="btnSubmit" name="btnSubmit" class='btn btn-primary'>
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

<!--INICIO Modal para NEW HAZARD -->
<div class="modal fade text-center" id="modalNewHazard" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">    
	<div class="modal-dialog" role="document">
		<div class="modal-content" id="tablaDatosNewHazard">

		</div>
	</div>
</div>                       
<!--FIN Modal para NEW HAZARD -->

<!--INICIO Modal para adicionar WORKER -->
<div class="modal fade text-center" id="modalWorker" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">    
	<div class="modal-dialog" role="document">
		<div class="modal-content" id="tablaDatos">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
				<h4 class="modal-title" id="exampleModalLabel">ADD WORKER</h4>
			</div>

			<div class="modal-body">
				<form name="formHazard" id="formHazard" role="form" method="post" action="<?php echo base_url("jobs/tool_box_One_Worker") ?>" >
					<input type="hidden" id="hddIdJob" name="hddIdJob" value="<?php echo $jobInfo[0]["id_job"]; ?>"/>
					<input type="hidden" id="hddIdToolBox" name="hddIdToolBox" value="<?php echo $information?$information[0]["id_tool_box"]:""; ?>" />

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
<!--FIN Modal para adicionar WORKER -->

<!--INICIO Modal para adicionar subcontractor WORKER -->
<div class="modal fade text-center" id="modalSubcontractorWorker" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">    
	<div class="modal-dialog" role="document">
		<div class="modal-content" id="tablaDatos">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
				<h4 class="modal-title" id="exampleModalLabel">ADD SUBCONTRACTOR WORKER</h4>
			</div>

			<div class="modal-body">
				<form name="formSubcontractor" id="formSubcontractor" role="form" method="post" action="<?php echo base_url("jobs/tool_box_subcontractor_Worker") ?>" >					
					<input type="hidden" id="hddIdJob" name="hddIdJob" value="<?php echo $jobInfo[0]["id_job"]; ?>"/>
					<input type="hidden" id="hddIdToolBox" name="hddIdToolBox" value="<?php echo $information?$information[0]["id_tool_box"]:""; ?>" />
					
					
					<div class="form-group text-left">
						<label class="control-label" for="company">Company</label>
						<select name="company" id="company" class="form-control" required>
							<option value=''>Select...</option>
							<?php for ($i = 0; $i < count($companyList); $i++) { ?>
								<option value="<?php echo $companyList[$i]["id_company"]; ?>" ><?php echo $companyList[$i]["company_name"]; ?></option>	
							<?php } ?>
						</select>
					</div>
					
					<div class="form-group text-left">
						<label class="control-label" for="workerName">Worker Name</label>
						<input type="text" id="workerName" name="workerName" class="form-control" placeholder="Worker Name" required >
					</div>					
					<div class="form-group">
						<div class="row" align="center">
							<div style="width:50%;" align="center">
								<input type="submit" id="btnSubmitSubcontractor" name="btnSubmitSubcontractor" value="Save" class="btn btn-primary"/>
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
<!--FIN Modal para adicionar WORKER -->