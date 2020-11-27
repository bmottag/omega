<div id="page-wrapper">
	<br>
	
	<!-- /.row -->
	<div class="row">

		<div class="col-lg-6">
			<div class="panel panel-info">
				<div class="panel-heading">
					<i class="fa fa-edit"></i> <strong>JSO - GENERAL INFORMATION</strong>
				</div>
				<div class="panel-body">
					<strong>Date JSO: </strong><?php echo $JSOInfo[0]['date_issue_jso']; ?><br>
					<strong>Job Code/Name: </strong><br><?php echo $JSOInfo[0]['job_description']; ?>
				</div>
			</div>
		</div>	
		
		<div class="col-lg-6">
			<div class="panel panel-primary">
				<div class="panel-heading">
					<i class="fa fa-edit fa-fw"></i> Worker Signature
				</div>
				<!-- /.panel-heading -->
				<div class="panel-body">
				
					<div class="form-group">
						<div class="row" align="center">
							<div style="width:80%;" align="center">
								<?php 								
								$class = "btn-primary";						
								if($information[0]['signature'])
								{ 
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
												<h4 class="modal-title">Worker Signature</h4>      </div>      
											<div class="modal-body text-center"><img src="<?php echo base_url($information[0]["signature"]); ?>" class="img-rounded" alt="Meeting conducted by Signature" width="304" height="236" />   </div>
											<div class="modal-footer">        
												<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>     
											</div>  
										</div>  
									</div>
								</div>
								<?php
								}
								?>
						
<a class="btn <?php echo $class; ?>" href="<?php echo base_url("jobs/add_signature_jso/externalWorker/" . $JSOInfo[0]['id_job'] . "/" . $JSOInfo[0]['id_job_jso'] . "/" . $information[0]['id_job_jso_worker']); ?>"><span class="glyphicon glyphicon-edit" aria-hidden="true"></span> Signature </a>

							</div>
						</div>
					</div>
			
				</div>
				<!-- /.panel-body -->
			</div>
		</div>
			
	</div>
	<!-- /.row -->
		
</div>
<!-- /#page-wrapper -->