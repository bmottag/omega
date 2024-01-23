<div id="page-wrapper">
	<br>
	
	<!-- /.row -->
	<div class="row">
		<div class="col-lg-12">
			<div class="panel panel-warning">
				<div class="panel-heading">
					<a class="btn btn-warning btn-xs" href=" <?php echo base_url().'more/confined/' . $jobInfo[0]['id_job']; ?> "><span class="glyphicon glyphicon glyphicon-chevron-left" aria-hidden="true"></span> Go back </a> 
					<i class="fa fa-cube"></i> <strong>CONFINED SPACE ENTRY PERMIT FORM</strong>
				</div>
				<div class="panel-body">

				<?php 
				if($information){
				?>
					<ul class="nav nav-pills">
						<li ><a href="<?php echo base_url("more/add_confined/" . $jobInfo[0]["id_job"] . "/" . $information[0]['id_job_confined']); ?>">FORM</a>
						</li>
						<li class='active'><a href="<?php echo base_url("more/confined_workers/" . $jobInfo[0]["id_job"]. "/" . $information[0]['id_job_confined']); ?>">ENTRANT(S) </a>
						</li>
						<li ><a href="<?php echo base_url("more/re_testing/" . $jobInfo[0]["id_job"]. "/" . $information[0]['id_job_confined']); ?>">ENVIRONMENTAL CONDITIONS - RE-TESTING</a>
						</li>
						<li><a href="<?php echo base_url("more/post_entry/" . $jobInfo[0]["id_job"]. "/" . $information[0]['id_job_confined']); ?>">POST ENTRY INSPECTION</a>
						</li>
					</ul>
					<br>
				<?php 
				}
				?>
				
					<div class="alert alert-warning">
						<span class="fa fa-briefcase" aria-hidden="true"></span>
						<strong>Job Code/Name: </strong><?php echo $jobInfo[0]['job_description']; ?>
						<br><span class='fa fa-clock-o' aria-hidden='true'></span> <strong>Date: </strong>
						<?php 
						if($information){
								echo $information[0]["date_confined"]; 
								
								echo "<br><span class='fa fa-cloud-download' aria-hidden='true'></span> <strong>Download Confined Entry Permit Form: </strong>";
						?>
<a href='<?php echo base_url('more/generaConfinedPDF/' . $information[0]["id_job_confined"] ); ?>' target="_blank">PDF <img src='<?php echo base_url_images('pdf.png'); ?>' ></a>	
						<?php 
						}else{
								echo date("Y-m-d");
						}
						?>
					</div>
				
				</div>
			</div>
		</div>
	</div>								
	
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
<p class="text-danger text-left">Fields with * are required.</p>


<!--INICIO WORKERS -->								
<?php if($information){ ?>
	<div class="row">
		<div class="col-lg-12">				
			<div class="panel panel-info">
				<div class="panel-heading">
					<a name="anclaWorker" ></a><strong>Worker(s) in charge of entry:</strong>
				</div>
				<div class="panel-body">
					<div class="col-lg-12">	
<?php if($confinedWorkers){ ?>
												
					<button type="button" class="btn btn-info btn-lg btn-block" data-toggle="modal" data-target="#modalWorker" id="x">
							<span class="glyphicon glyphicon-plus" aria-hidden="true"></span> Add VCI Workers
					</button>
<?php }else { ?>
					<a href="<?php echo base_url("more/add_workers_confined/" . $jobInfo[0]["id_job"] . "/" . $information[0]["id_job_confined"]); ?>" class="btn btn-info btn-lg btn-block"><span class="glyphicon glyphicon-plus" aria-hidden="true"></span> Add VCI Workers</a>
<?php } ?>
											
						<br>
					</div>
										
<?php 
	if($confinedWorkers){
?>
			<table class="table table-bordered table-striped table-hover table-condensed">
				<tr>
					<th class="column-title text-center"><small>Name</small></th>
					<th class="column-title text-center"><small>Signature In</small></th>
					<th class="column-title text-center"><small>Signature Out</small></th>
					<th class="column-title text-center"><small>Task</small></th>
					<th class="column-title text-center"><small>Safety Watch</small></th>
					<th class="column-title text-center"><small>Save / Delete</small></th>
				</tr>
				<?php
					foreach ($confinedWorkers as $data):
						echo "<tr>";					
						echo "<td ><small>" . $data['name'] . "</small></td>";
						echo "<td class='text-center'><small><center>";
$class = "btn-primary";						
if($data['signature']){ 
	$class = "btn-default";
	
?>
<button type="button" class="btn btn-default btn-xs" data-toggle="modal" data-target="#<?php echo $data['id_job_confined_worker'] . "wModal"; ?>" id="<?php echo $data['id_job_confined_worker']; ?>">
	<span class="glyphicon glyphicon-eye-open" aria-hidden="true"></span> View Signature
</button>

<div id="<?php echo $data['id_job_confined_worker'] . "wModal"; ?>" class="modal fade" role="dialog">  
	<div class="modal-dialog">
		<div class="modal-content">      
			<div class="modal-header">        
				<button type="button" class="close" data-dismiss="modal">×</button>        
				<h4 class="modal-title">Worker Signature In</h4>      </div>      
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
					
					<a class='btn <?php echo $class; ?> btn-xs' href='<?php echo base_url('more/add_signature_confined/worker/' . $jobInfo[0]["id_job"] . '/' . $data['fk_id_job_confined'] . '/' . $data['id_job_confined_worker']) ?>' id="btn-delete">
							<span class="glyphicon glyphicon-edit" aria-hidden="true"> </span>  Signature In
					</a>

<?php
if($data['signature'] && $data['date_time_in']){ 
	echo "<br>" . $data['date_time_in'];
}
?>
					
					</center>
					</small></td>
					
					<td class='text-center'><small><center>
					
<?php
$class = "btn-primary";						
if($data['signature_out']){ 
	$class = "btn-default";
	
?>
<button type="button" class="btn btn-default btn-xs" data-toggle="modal" data-target="#out_<?php echo $data['id_job_confined_worker'] . "wModal"; ?>" id="out_<?php echo $data['id_job_confined_worker']; ?>">
	<span class="glyphicon glyphicon-eye-open" aria-hidden="true"></span> View Signature
</button>

<div id="out_<?php echo $data['id_job_confined_worker'] . "wModal"; ?>" class="modal fade" role="dialog">  
	<div class="modal-dialog">
		<div class="modal-content">      
			<div class="modal-header">        
				<button type="button" class="close" data-dismiss="modal">×</button>        
				<h4 class="modal-title">Worker Signature Out</h4>      </div>      
			<div class="modal-body text-center"><img src="<?php echo base_url($data['signature_out']); ?>" class="img-rounded" alt="Management/Safety Advisor Signature" width="304" height="236" />   </div>      
			<div class="modal-footer">    
				<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>     
			</div>  
		</div>  
	</div>
</div>
<?php
}
				?>
					
					<a class='btn <?php echo $class; ?> btn-xs' href='<?php echo base_url('more/add_signature_confined/worker_out/' . $jobInfo[0]["id_job"] . '/' . $data['fk_id_job_confined'] . '/' . $data['id_job_confined_worker']) ?>' id="btn-delete">
							<span class="glyphicon glyphicon-edit" aria-hidden="true"> </span>  Signature Out
					</a>
					
<?php
if($data['signature_out'] && $data['date_time_out']){ 
	echo "<br>" . $data['date_time_out'];
}
?>

					</center>
					</small></td>

				<form  name="worker_<?php echo $data["id_job_confined_worker"]; ?>" id="worker_<?php echo $data["id_job_confined_worker"]; ?>" method="post" action="<?php echo base_url("more/update_confined_worker"); ?>">
					<input type="hidden" id="hddIdConfined" name="hddIdConfined" value="<?php echo $data['fk_id_job_confined']; ?>"/>
					<input type="hidden" id="hddIdJob" name="hddIdJob" value="<?php echo $jobInfo[0]["id_job"]; ?>"/>	
					<input type="hidden" id="hddId" name="hddId" value="<?php echo $data["id_job_confined_worker"]; ?>"/>	
					
					<td>
						<input type="text" id="task" name="task" class="form-control" placeholder="Task" value="<?php echo $data['task']; ?>" required>
					</td>
					
					<td>
						<select name="safety_watch" id="safety_watch" class="form-control" required>
							<option value=''>Select...</option>
							<?php for ($i = 0; $i < count($workersList); $i++) { ?>
								<option value="<?php echo $workersList[$i]["id_user"]; ?>" <?php if($data["fk_id_safety_watch_user"] == $workersList[$i]["id_user"]) { echo "selected"; }  ?>><?php echo $workersList[$i]["first_name"] . ' ' . $workersList[$i]["last_name"]; ?></option>	
							<?php } ?>
						</select>
					</td>
										
					<td class='text-center'><small>
					
						<input type="submit" id="btnSubmit" name="btnSubmit" value="Save" class="btn btn-primary btn-xs"/>

						<a class='btn btn-danger btn-xs' href='<?php echo base_url('more/deleteConfinedWorker/' . $jobInfo[0]["id_job"] . '/' . $data['fk_id_job_confined'] . '/' . $data['id_job_confined_worker']) ?>' id="btn-delete">
								<span class="glyphicon glyphicon-remove" aria-hidden="true"> </span>  Delete
						</a>
					
				</form>
				
					</small></td>
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
<!--FIN WORKERS -->


</div>
<!-- /#page-wrapper -->

<!--INICIO Modal para adicionar WORKER -->
<div class="modal fade text-center" id="modalWorker" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">    
	<div class="modal-dialog" role="document">
		<div class="modal-content" id="tablaDatos">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
				<h4 class="modal-title" id="exampleModalLabel">ADD WORKER</h4>
			</div>

			<div class="modal-body">
				<form name="formWorker" id="formWorker" role="form" method="post" action="<?php echo base_url("more/confined_One_Worker") ?>" >
					<input type="hidden" id="hddIdJob" name="hddIdJob" value="<?php echo $jobInfo[0]["id_job"]; ?>"/>
					<input type="hidden" id="hddIdConfined" name="hddIdConfined" value="<?php echo $information[0]["id_job_confined"]; ?>"/>

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