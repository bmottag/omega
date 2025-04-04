<script type="text/javascript" src="<?php echo base_url("assets/js/validate/jobs/workers.js"); ?>"></script>

<div id="page-wrapper">
	<br>
	<div class="row">
		<div class="col-md-12">
			<div class="panel panel-primary">
				<div class="panel-heading">
					<h4 class="list-group-item-heading">
					<i class="fa fa-edit fa-fw"></i>	IHSR
					</h4>
				</div>
			</div>
		</div>
		<!-- /.col-lg-12 -->				
	</div>
	
	<!-- /.row -->
	<div class="row">
		<div class="col-lg-12">
			<div class="panel panel-default">
				<div class="panel-heading">
					<i class="fa fa-life-saver"></i> IHSR - ADD WORKERS
				</div>
				<div class="panel-body">

					<form  name="form" id="form" class="form-horizontal" method="post" >
						<input type="hidden" id="hddIdToolBox" name="hddIdToolBox" value="<?php echo $idToolBox; ?>"/>
						<input type="hidden" id="hddIdJob" name="hddIdJob" value="<?php echo $idJob; ?>"/>
								
															
                        <table class="table table-striped table-hover table-condensed table-bordered">
                            <tr class="info">
                                <td ><p class="text-center"><strong>Check</strong></p></td>
                                <td ><p class="text-center"><strong>Worker</strong></p></td>
                            </tr>
                            <?php
                            $ci = &get_instance();
                            $ci->load->model("jobs_model");
                            foreach ($workersList as $lista):
							
                                $found = $ci->jobs_model->get_toolbox_byIdworker_byIdToolBox($idToolBox, $lista['id_user']);
								
                                echo "<tr>";
                                echo "<td>";
                                $data = array(
                                    'name' => 'workers[]',
                                    'id' => 'workers',
                                    'value' => $lista['id_user'],
                                    'checked' => $found,
                                    'style' => 'margin:10px'
                                );
                                echo form_checkbox($data);
                                echo "</td>";
								echo "<td>" . $lista["first_name"] . ' ' . $lista["last_name"] . "</td>";
                                echo "</tr>";
                            endforeach
                            ?>
                        </table>					
						<div class="form-group">							
							<div class="row" align="center">
								<div style="width:50%;" align="center">
									 <input type="button" id="btnSubmit" name="btnSubmit" value="Save" class="btn btn-primary"/>
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