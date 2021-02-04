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
								<th class="text-center">Date of Issue</th>
								<th class="text-center">Date W.O.</th>
								<th class="text-center">Task Description</th>
                            </tr>
                            <?php
                            foreach ($WOList as $lista):							
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
								echo '<td class="text-center">' . $lista["id_workorder"] . "</td>";
								echo '<td>' . $lista['name'] . '</td>';
								echo '<td class="text-center">' . $lista['date_issue'] . '</td>';
								echo '<td class="text-center">' . $lista['date'] . '</td>';
								echo '<td>' . $lista['observation'] . '</td>';
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