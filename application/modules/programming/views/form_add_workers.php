<script type="text/javascript" src="<?php echo base_url("assets/js/validate/programming/programming_workers.js"); ?>"></script>

<script>

function seleccionar_todo(){
   for (i=0;i<document.form.elements.length;i++)
      if(document.form.elements[i].type == "checkbox")
         document.form.elements[i].checked=1
} 


function deseleccionar_todo(){
   for (i=0;i<document.form.elements.length;i++)
      if(document.form.elements[i].type == "checkbox")
         document.form.elements[i].checked=0
} 

</script>

<div id="page-wrapper">
	<br>
	
	<!-- /.row -->
	<div class="row">
		<div class="col-lg-12">
			<div class="panel panel-default">
				<div class="panel-heading">
					<i class="fa fa-book"></i> PROGRAMMING - ADD WORKERS
				</div>
				<div class="panel-body">

<a href="javascript:seleccionar_todo()">Check all</a> |
<a href="javascript:deseleccionar_todo()">Uncheck all</a> 
<br><br>

					<form  name="form" id="form" class="form-horizontal" method="post" >
						<input type="hidden" id="hddId" name="hddId" value="<?php echo $idProgramming; ?>"/>
								
					<table width="100%" class="table table-striped table-bordered table-hover" id="dataTables">
						<thead>
							<tr class="info">
								<th class='text-center'>Check</th>
								<th class='text-center'>Worker</th>
							</tr>
						</thead>	
						
						<tbody>	
                            <?php
                            $ci = &get_instance();
                            $ci->load->model("general_model");
                            foreach ($workersList as $lista):
							
								$arrParam = array(
									"idProgramming" => $idProgramming,
									"idUser" => $lista['id_user']
								);
								$found = $ci->general_model->get_programming_workers($arrParam);
								
                                echo "<tr>";
                                echo "<td class='text-center'>";
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
						</tbody>	
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