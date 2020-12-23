<div id="page-wrapper">

    <br>		
    <!-- /.row -->
    <div class="row">
			
        <div class="col-lg-3">
            <div class="panel panel-danger">
                <div class="panel-heading">
                    <i class="fa fa-bell fa-fw"></i> SUMMARY - <?php echo date('F j, Y', strtotime($fecha)); ?>
                </div>
                <!-- /.panel-heading -->

                <?php 
                    $noPlanning = 0;
                    $noPayroll = 0;
                    $noWorkOrder= 0;
                    if($planningInfo){
                            $noPlanning = count($planningInfo);
                    }
                    if($payrollInfo){
                            $noPayroll = count($payrollInfo);
                    }
                    if($workOrderInfo){
                            $noWorkOrder = count($workOrderInfo);
                    }
                ?>

                <div class="panel-body">
                    <div class="list-group">
                        <a href="#" class="list-group-item">
                            <p class="text-warning"><i class="fa fa-list fa-fw"></i><strong> Planning Records</strong>
                                <span class="pull-right text-muted small"><em><?php echo $noPlanning; ?></em>
                                </span>
                            </p>
                        </a>
                        <a href="#" class="list-group-item">
                            <p class="text-primary"><i class="fa fa-book fa-fw"></i><strong> Payroll Records</strong>
                                <span class="pull-right text-muted small"><em><?php echo $noPayroll; ?></em>
                                </span>
                            </p>
                        </a>
                        <a href="#" class="list-group-item">
                            <p class="text-success"><i class="fa fa-money fa-fw"></i><strong> Work Orders Records</strong>
                                <span class="pull-right text-muted small"><em><?php echo $noWorkOrder ; ?></em>
                                </span>
                            </p>
                        </a>
                    </div>
                    <!-- /.list-group -->

                </div>
                <!-- /.panel-body -->
            </div>
            <!-- /.panel -->

        </div>
        <!-- /.col-lg-4 -->

        <div class="col-lg-9">
<?php
    if($planningInfo){ 
?>  
            <div class="panel panel-warning">
                <div class="panel-heading">
                    <i class="fa fa-list fa-fw"></i> PLANNING RECORDS - <?php echo date('l, F j, Y', strtotime($fecha)); ?>
                </div>
                <!-- /.panel-heading -->
                <div class="panel-body">
					
					<table width="100%" class="table table-striped table-bordered table-hover" id="dataPlanning">
						<thead>
							<tr>
                                <th class='text-center'>Job Code/Name</th>
                                <th class='text-center'>Observation</th>
                                <th class='text-center'>Message</th>
							</tr>
						</thead>
						<tbody>							
						<?php
							foreach ($planningInfo as $lista):
								echo "<tr>";
                                echo "<td class='text-center'>" . $lista['job_description'] . "</td>";
                                echo "<td>" . $lista['observation'] . "</td>";
                                echo "<td>";

                                //Buscar lista de trabajadores para esta programacion
                                $ci = &get_instance();
                                $ci->load->model("general_model");
                                
                                $arrParam = array("idProgramming" => $lista['id_programming']);
                                $informationWorker = $this->general_model->get_programming_workers($arrParam);//info trabajadores

                                $mensaje = "";                            
                                foreach ($informationWorker as $data):
                                    $mensaje .= $data['site']==1?"At the yard - ":"At the site - ";
                                    $mensaje .= $data['hora']; 

                                    $mensaje .= "<br>" . $data['name']; 
                                    $mensaje .= $data['description']?"<br>" . $data['description']:"";
                                    $mensaje .= $data['unit_description']?"<br>" . $data['unit_description']:"";
                                    
                                    if($data['safety']==1){
                                        $mensaje .= "<br>Do FLHA";
                                    }elseif($data['safety']==2){
                                        $mensaje .= "<br>Do Tool Box";
                                    }
                                    
                                    $mensaje .= "<br><br>";
                                endforeach;

                                echo $mensaje;

                                echo "</td>";
								echo "</tr>";
							endforeach;
						?>
						</tbody>
					</table>					
					<!-- /.table-responsive -->
				</div>
				<!-- /.panel-body -->
			</div>
<?php   } ?>

<?php
    if($workOrderInfo){ 
?>  
            <div class="panel panel-success">
                <div class="panel-heading">
                    <i class="fa fa-money fa-fw"></i> WORK ORDER RECORDS - <?php echo date('l, F j, Y', strtotime($fecha)); ?>
                </div>
                <!-- /.panel-heading -->
                <div class="panel-body">
                    
                    <table width="100%" class="table table-striped table-bordered table-hover" id="dataPlanning">
                        <thead>
                            <tr>
                                <th class='text-center'>Work Order #</th>
                                <th class='text-center'>Job Code/Name</th>
                                <th class='text-center'>Observation</th>
                            </tr>
                        </thead>
                        <tbody>                         
                        <?php
                            foreach ($workOrderInfo as $lista):
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

                                echo "<tr>";
                                echo "<td class='text-center'>" . $lista['id_workorder'];
                                echo '<p class="' . $clase . '"><i class="fa ' . $icono . ' fa-fw"></i>' . $valor . '</p>';
                                echo "</td>";
                                echo "<td class='text-center'>" . $lista['job_description'] . "</td>";
                                echo "<td class='text-center'>" . $lista['observation'] . "</td>";
                                echo "</tr>";
                            endforeach;
                        ?>
                        </tbody>
                    </table>                    
                    <!-- /.table-responsive -->
                </div>
                <!-- /.panel-body -->
            </div>
<?php   } ?>

		</div>
    </div>		

    <!-- /.row -->
    <div class="row">
            
        <div class="col-lg-12">

<?php
    if($payrollInfo){ 
?>   
            <div class="panel panel-primary">
                <div class="panel-heading">
                    <i class="fa fa-book fa-fw"></i> PAYROLL RECORDS - <?php echo date('l, F j, Y', strtotime($fecha)); ?>
                </div>
                <!-- /.panel-heading -->
                <div class="panel-body">
                   
                    <table width="100%" class="table table-striped table-bordered table-hover" id="dataTables">
                        <thead>
                            <tr>
                                <th class="text-center">Employee</th>
                                <th class="text-center">Working Hours</th>
                                <th class="text-center">Job Code/Name - Start</th>
                                <th class="text-center">Job Code/Name - Finish</th>
                            </tr>
                        </thead>
                        <tbody>                         
                        <?php
                            foreach ($payrollInfo as $lista):
                                echo "<tr>";
                                echo "<td class='text-center'>" . $lista['first_name'] . " " . $lista['last_name'] . "</td>";
                                echo "<td class='text-right'>" . $lista['working_hours'] . "</td>";
                                echo "<td class='text-center'>" . $lista['job_start'] . "</td>";
                                echo "<td class='text-center'>" . $lista['job_finish'] . "</td>";
                                echo "</tr>";
                            endforeach;
                        ?>
                        </tbody>
                    </table>                    
                    <!-- /.table-responsive -->


                </div>
                <!-- /.panel-body -->
            </div>
<?php   } ?>            
        </div>
    </div>      

</div>
<!-- /#page-wrapper -->

<!-- Tables -->
<script>
$(document).ready(function() {
    $('#dataTables').DataTable({
        responsive: true,
		 "ordering": false,
		 paging: false,
		"searching": false,
		"pageLength": 25
    });
	
	
});
</script>