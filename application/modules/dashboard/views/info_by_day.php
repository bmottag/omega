<div id="page-wrapper">

    <br>		
    <!-- /.row -->
    <div class="row">
			
        <div class="col-lg-3">
            <div class="panel panel-danger">
                <div class="panel-heading">
                <a class="btn btn-danger btn-xs" href=" <?php echo base_url('dashboard/calendar'); ?> "><span class="glyphicon glyphicon glyphicon-chevron-left" aria-hidden="true"></span> Back to the Calendar</a> <br>
                    <i class="fa fa-bell fa-fw"></i> <strong>SUMMARY</strong> - <?php echo date('F j, Y', strtotime($fecha)); ?>
                </div>
                <!-- /.panel-heading -->

                <?php 
                    $noPlanning = 0;
                    $noPayroll = 0;
                    $noWorkOrder= 0;
                    $noHauling= 0;
                    $noFLHA= 0;
                    $noToolBox= 0;
                    if($planningInfo){
                            $noPlanning = count($planningInfo);
                    }
                    if($payrollInfo){
                            $noPayroll = count($payrollInfo);
                    }
                    if($workOrderInfo){
                            $noWorkOrder = count($workOrderInfo);
                    }
                    if($haulingInfo){
                            $noHauling = count($haulingInfo);
                    }
                    if($safetyInfo){
                            $noFLHA = count($safetyInfo);
                    }
                    if($toolBoxInfo){
                            $noToolBox = count($toolBoxInfo);
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
                            <p class="text-success"><i class="fa fa-money fa-fw"></i><strong> Work Orders Records</strong>
                                <span class="pull-right text-muted small"><em><?php echo $noWorkOrder ; ?></em>
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
                            <p class="text-warning"><i class="fa fa-truck fa-fw"></i><strong> Hauling Records</strong>
                                <span class="pull-right text-muted small"><em><?php echo $noHauling ; ?></em>
                                </span>
                            </p>
                        </a>
                        <a href="#" class="list-group-item">
                            <p class="text-info"><i class="fa fa-life-saver fa-fw"></i><strong> FLHA Records</strong>
                                <span class="pull-right text-muted small"><em><?php echo $noFLHA ; ?></em>
                                </span>
                            </p>
                        </a>
                        <a href="#" class="list-group-item">
                            <p class="text-warning"><i class="fa fa-cube fa-fw"></i><strong> Tool Box Records</strong>
                                <span class="pull-right text-muted small"><em><?php echo $noToolBox ; ?></em>
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
                    <i class="fa fa-list fa-fw"></i> <strong>PLANNING RECORDS</strong> - <?php echo date('l, F j, Y', strtotime($fecha)); ?>
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
        </div>
    </div>

    <!-- /.row -->
    <div class="row">
        <div class="col-lg-12">
<?php
    if($workOrderInfo){ 
?>  
            <div class="panel panel-success">
                <div class="panel-heading">
                    <i class="fa fa-money fa-fw"></i> <strong>WORK ORDER RECORDS</strong> - <?php echo date('l, F j, Y', strtotime($fecha)); ?>
                </div>
                <!-- /.panel-heading -->
                <div class="panel-body">
                    
                    <table width="100%" class="table table-striped table-bordered table-hover" id="dataPlanning">
                        <thead>
                            <tr>
                                <th class='text-center'>Work Order #</th>
                                <th class='text-center'>Job Code/Name</th>
                                <th class="text-center">Supervisor</th>
                                <th class='text-center'>Task Description</th>
                                <th class='text-center'>Last Message</th>
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
                                echo "<td class='text-center'>";
                                echo "<a href='" . base_url('workorders/add_workorder/' . $lista['id_workorder']) . "' target='_blanck'>" . $lista['id_workorder'] . "</a>";
                                echo '<p class="' . $clase . '"><i class="fa ' . $icono . ' fa-fw"></i>' . $valor . '</p>';
                                echo "<a href='" . base_url('workorders/generaWorkOrderPDF/' . $lista['id_workorder']) . "' target='_blanck'><img src='" . base_url_images('pdf.png') . "' ></a>";
                                echo '</td>';
                                echo "<td class='text-center'>" . $lista['job_description'] . "</td>";
                                echo '<td>' . $lista['name'] . '</td>';
                                echo "<td class='text-center'>" . $lista['observation'] . "</td>";
                                echo "<td class='text-center'>" . $lista['last_message'] . "</td>";
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
                    <i class="fa fa-book fa-fw"></i> <strong>PAYROLL RECORDS</strong> - <?php echo date('l, F j, Y', strtotime($fecha)); ?>
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
                                <th>Task description</th>
                                <th>Observation</th>
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
                                echo "<td class='text-right'>" . $lista['task_description'] . "</td>";
                                echo "<td class='text-right'>" . $lista['observation'] . "</td>";
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
    if($haulingInfo){ 
?>   
            <div class="panel panel-warning">
                <div class="panel-heading">
                    <i class="fa fa-truck fa-fw"></i> <strong>HAULING RECORDS</strong> - <?php echo date('l, F j, Y', strtotime($fecha)); ?>
                </div>
                <!-- /.panel-heading -->
                <div class="panel-body">
                   
                    <table width="100%" class="table table-striped table-bordered table-hover" id="dataTables">
                        <thead>
                            <tr>
                                <th class='text-center'>#</th>
                                <th class='text-center'>Report done by</th>
                                <th class='text-center'>Download</th>
                                <th class='text-center'>Hauling done by</th>
                                <th class='text-center'>Truck - Unit Number</th>
                                <th class='text-center'>Truck Type</th>
                                <th class='text-center'>Material Type</th>
                                <th class='text-center'>From Site</th>
                                <th class='text-center'>To Site</th>
                                <th class='text-center'>Payment</th>
                                <th class='text-center'>Time In</th>
                                <th class='text-center'>Time Out</th>
                            </tr>
                        </thead>
                        <tbody>                         
                        <?php
                            foreach ($haulingInfo as $lista):
                                echo "<tr>";
                                echo "<td class='text-center'>" . $lista['id_hauling'] . "</td>";
                                echo "<td>" . $lista['name'] . "</td>";
                                echo "<td class='text-center'>";
                        ?>
<a href='<?php echo base_url('report/generaHaulingPDF/x/x/x/x/' . $lista['id_hauling'] ); ?>' target="_blank"> <img src='<?php echo base_url_images('pdf.png'); ?>' ></a>
                        <?php
                                echo "</td>";
                                echo "<td class='text-center'>" . $lista['company_name'] . "</td>";
                                echo "<td class='text-center'>" . $lista['unit_number'] . "</td>";
                                echo "<td>" . $lista['truck_type'] . "</td>";
                                echo "<td >" . $lista['material'] . "</td>";
                                echo "<td >" . $lista['site_from'] . "</td>";
                                echo "<td >" . $lista['site_to'] . "</td>";
                                echo "<td >" . $lista['payment'] . "</td>";
                                echo "<td class='text-center'>" . $lista['time_in'] . "</td>";
                                echo "<td class='text-center'>" . $lista['time_out'] . "</td>";
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
    if($safetyInfo){ 
?>   
            <div class="panel panel-info">
                <div class="panel-heading">
                    <i class="fa fa-life-saver fa-fw"></i> <strong>FLHA RECORDS</strong> - <?php echo date('l, F j, Y', strtotime($fecha)); ?>
                </div>
                <!-- /.panel-heading -->
                <div class="panel-body">
                   
                    <table width="100%" class="table table-striped table-bordered table-hover" id="dataTables">
                        <thead>
                            <tr>
                                <th class='text-center'>Job Code/Name</th>
                                <th class='text-center'>Meeting conducted by</th>
                                <th class='text-center'>Task(s) To Be Done</th>
                                <th class='text-center'>Download</th>
                            </tr>
                        </thead>
                        <tbody>                         
                        <?php
                            foreach ($safetyInfo as $lista):
                                echo "<tr>";
                                echo "<td>" . $lista['job_description'] . "</td>";
                                echo "<td>" . $lista['name'] . "</td>";
                                echo "<td>" . $lista['work'] . "</td>";
                                echo "<td class='text-center'>";
                        ?>
<a href='<?php echo base_url('report/generaSafetyPDF/x/x/x/' . $lista['id_safety'] ); ?>' target="_blank"> <img src='<?php echo base_url_images('pdf.png'); ?>' ></a>
                        <?php
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
    if($toolBoxInfo){ 
?>   
            <div class="panel panel-warning">
                <div class="panel-heading">
                    <i class="fa fa-cube fa-fw"></i> <strong>TOOL BOX RECORDS</strong> - <?php echo date('l, F j, Y', strtotime($fecha)); ?>
                </div>
                <!-- /.panel-heading -->
                <div class="panel-body">
                   
                    <table width="100%" class="table table-striped table-bordered table-hover" id="dataTables">
                        <thead>
                            <tr>
                                <th class='text-center'>Job Code/Name</th>
                                <th class='text-center'>Reported by</th>
                                <th class='text-center'>Activities of the Day</th>
                                <th class='text-center'>Employee Suggestions</th>
                                <th class='text-center'>Download</th>
                            </tr>
                        </thead>
                        <tbody>                         
                        <?php
                            foreach ($toolBoxInfo as $lista):
                                echo "<tr>";
                                echo "<td>" . $lista['job_description'] . "</td>";
                                echo "<td>" . $lista['name'] . "</td>";
                                echo "<td>" . $lista['activities'] . "</td>";
                                echo "<td>" . $lista['suggestions'] . "</td>";
                                echo "<td class='text-center'>";
                        ?>
<a href='<?php echo base_url('jobs/generaTemplatePDF/' . $lista['id_tool_box'] ); ?>' target="_blank"><img src='<?php echo base_url_images('pdf.png'); ?>' ></a>   
                        <?php
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