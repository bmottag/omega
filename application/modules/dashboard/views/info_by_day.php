<style>
.panel-heading {
    overflow: hidden;
    position: relative;
    z-index: 102; /* Asegura que esté por encima de la tabla */
    background: white; /* Para evitar transparencia */
}

    .table-container {
        max-height: 700px; /* Ajusta la altura según necesites */
        overflow-y: auto;
        border: 1px solid #ddd;
        position: relative;
        background: white;
        padding-top: 0px;
    }

    /* Fijar el encabezado de la tabla */
    .table-container thead {
        position: sticky;
        top: 0;
        background: white;
        z-index: 101;
    }

    /* Opcional: Agregar sombra para mayor visibilidad del encabezado */
    .table-container thead th {
        box-shadow: 0 2px 2px rgba(0, 0, 0, 0.1);
    }
</style>


<div id="page-wrapper">
    <br>
    <div class="row">
        <div class="col-lg-12">
            <div class="panel panel-danger">
                <div class="panel-heading">
                    <a class="btn btn-danger btn-xs" href=" <?php echo base_url('dashboard/calendar'); ?> "><span class="glyphicon glyphicon glyphicon-chevron-left" aria-hidden="true"></span> Back to the Calendar</a>
                    <a class="btn btn-danger btn-xs" href=" <?php echo base_url("dashboard/info_by_day/all/" . $fecha) ; ?> "><span class="glyphicon glyphicon glyphicon-chevron-right" aria-hidden="true"></span> View all the Information for the selectd day</a> <br>
                    <i class="fa fa-bell fa-fw"></i> <strong>SUMMARY</strong> - <?php echo date('F j, Y', strtotime($fecha)); ?>
                </div>
            </div>
        </div>
    </div>

    <?php
        $ci = &get_instance();
        $ci->load->model("general_model");
        if (isset($planningInfo) && $planningInfo) {
    ?>
    <div class="row">
        <div class="col-lg-12">
            <div class="panel panel-warning">
                <div class="panel-heading">
                    <i class="fa fa-list fa-fw"></i> <strong>PLANNING RECORDS</strong> - <?php echo date('l, F j, Y', strtotime($fecha)); ?>
                </div>
                <div class="panel-body">

                    <table width="100%" class="table table-striped table-bordered table-hover" id="dataPlanning">
                        <thead>
                            <tr>
                                <th width='20%'>Job Code/Name</th>
                                <th width='60%'>Observation</th>
                                <th width='20%'>Message</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            foreach ($planningInfo as $lista) :
                                echo "<tr>";
                                echo "<td>" . $lista['job_description'] . "</td>";
                                echo "<td>" . $lista['observation'] . "</td>";
                                echo "<td>";

                                //Buscar lista de trabajadores para esta programacion
                                $arrParam = array("idProgramming" => $lista['id_programming']);
                                $informationWorker = $this->general_model->get_programming_workers($arrParam); //info trabajadores

                                $mensaje = "";
                                if ($informationWorker) {
                                    foreach ($informationWorker as $data) :

                                        if ($data['fk_id_machine'] != NULL && $data['fk_id_machine'] != 0) {
                                            $parsed_data = json_decode($data['fk_id_machine'], true);

                                            if ($parsed_data !== null && is_array($parsed_data)) {
                                                $id_values = implode(',', $parsed_data);
                                            } else {
                                                $id_values = $data['fk_id_machine'];
                                            }
                                            $arrParam = array("idValues" => $id_values);
                                            $informationEquipments = $this->general_model->get_vehicle_info_for_planning($arrParam);
                                        }

                                        switch ($data['site']) {
                                            case 1:
                                                $mensaje .= "At the yard - ";
                                                break;
                                            case 2:
                                                $mensaje .= "At the site - ";
                                                break;
                                            case 3:
                                                $mensaje .= "At Terminal - ";
                                                break;
                                            case 4:
                                                $mensaje .= "On-line training - ";
                                                break;
                                            case 5:
                                                $mensaje .= "At training facility - ";
                                                break;
                                            case 6:
                                                $mensaje .= "At client's office - ";
                                                break;
                                            default:
                                                $mensaje .= "At the yard - ";
                                                break;
                                        }
                                        $mensaje .= $data['hora'];

                                        $mensaje .= "<br>" . $data['name'];
                                        $mensaje .= $data['description'] ? "<br>" . $data['description'] : "";
                                        $mensaje .= ($data['fk_id_machine'] != NULL && $data['fk_id_machine'] != 0) ? "<br>" . $informationEquipments["unit_description"] : "";

                                        if ($data['safety'] == 1) {
                                            $mensaje .= "<br>Do FLHA";
                                        } elseif ($data['safety'] == 2) {
                                            $mensaje .= "<br>Do IHSR";
                                        }
                                        $mensaje .= $data['confirmation'] == 1 ? "<p class='text-success'><b>Confirmed?</b> Yes</p>" : "<p class='text-danger'><b>Confirmed?</b> No</p>";
                                    endforeach;
                                }

                                echo $mensaje;

                                echo "</td>";
                                echo "</tr>";
                            endforeach;
                            ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    <?php   } ?>

    <?php
        if (isset($workOrderInfo) && $workOrderInfo) {
    ?>
    <div class="row">
        <div class="col-lg-12">
            <div class="panel panel-success">
                <div class="panel-heading">
                    <i class="fa fa-money fa-fw"></i> <strong>WORK ORDER RECORDS</strong> - <?php echo date('l, F j, Y', strtotime($fecha)); ?>
                </div>

                <div class="panel-body">
                    <table width="100%" class="table table-striped table-bordered table-hover" id="dataPlanning">
                        <thead>
                            <tr>
                                <th width='10%' class='text-center'>Work Order #</th>
                                <th width='20%'>Job Code/Name</th>
                                <th width='15%'>Supervisor</th>
                                <th width='30%'>Task Description</th>
                                <th width='25%'>Last Message</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            foreach ($workOrderInfo as $lista) :
                                switch ($lista['state']) {
                                    case 0:
                                        $valor = 'On Field';
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
                                        $valor = 'Send to the Client';
                                        $clase = "text-success";
                                        $icono = "fa-envelope-o";
                                        break;
                                    case 4:
                                        $valor = 'Closed';
                                        $clase = "text-danger";
                                        $icono = "fa-power-off";
                                        break;
                                    case 5:
                                        $valor = 'Accounting';
                                        $clase = "text-warning";
                                        $icono = "fa-list-alt";
                                        break;
                                }

                                echo "<tr>";
                                echo "<td class='text-center'>";
                                echo "<a href='" . base_url('workorders/add_workorder/' . $lista['id_workorder']) . "' target='_blanck'>" . $lista['id_workorder'] . "</a>";
                                echo '<p class="' . $clase . '"><i class="fa ' . $icono . ' fa-fw"></i>' . $valor . '</p>';
                                echo "<a href='" . base_url('workorders/generaWorkOrderPDF/' . $lista['id_workorder']) . "' target='_blanck'><img src='" . base_url_images('pdf.png') . "' ></a>";
                                echo '</td>';
                                echo "<td >" . $lista['job_description'] . "</td>";
                                echo '<td>' . $lista['name'] . '</td>';
                                echo "<td>" . $lista['observation'] . "</td>";
                                echo "<td>" . $lista['last_message'] . "</td>";
                                echo "</tr>";
                            endforeach;
                            ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    <?php   } ?>

    <?php
        if (isset($payrollInfo) && $payrollInfo) {
    ?>
    <div class="row">
        <div class="col-lg-12">
            <div class="panel panel-primary">
                <div class="panel-heading">
                    <i class="fa fa-book fa-fw"></i> <strong>PAYROLL RECORDS</strong> - <?php echo date('l, F j, Y', strtotime($fecha)); ?>
                </div>
                <div class="panel-body table-container">
                    <table width="100%" class="table table-striped table-bordered table-hover small" id="dataTables">
                        <thead>
                            <tr>
                                <th width='8%'>Employee</th>
                                <th width='8%' class="text-center">Hours Worked at Project Start</th>
                                <th width='8%' class="text-center">Hours Worked at Project Finish</th>
                                <th width='8%' class="text-center">Payroll Working Hours </th>

                                <?php 
                                    if (isset($workOrderCheck) && $workOrderCheck) {
                                        foreach ($workOrderCheck as $wo) : 
                                ?>
                                        <th width='7%' class='text-center'><?php echo $wo['job_description'] . "<br><a target='_blanck' href='" . base_url('workorders/add_workorder/' . $wo['id_workorder']) . "'>W.O. # " . $wo['id_workorder'] . "</a>"; ?></th>
                                <?php 
                                        endforeach; 
                                    }
                                ?>
                                <th width='8%' class='text-center'>Total W.O. Hours</td>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            foreach ($payrollInfo as $lista) :
                                $hoursStart = ($lista['finish'] == "0000-00-00 00:00:00" || $lista['hours_start_project'] == 0) ? "" : $lista['hours_start_project'] . " hours";
                                $hoursFinish = ($lista['finish'] == "0000-00-00 00:00:00" || $lista['hours_end_project'] == 0) ? "" : $lista['hours_end_project'] . " hours";

                                $hidden_start = 'hidden';//($lista['finish'] == "0000-00-00 00:00:00" || ($lista['wo_start_project'] != null || $lista['fk_id_job'] == $lista['fk_id_job_finish'])) ? 'hidden' : ' ';
                                $hidden_finished = 'hidden';//($lista['finish'] == "0000-00-00 00:00:00" || ($lista['wo_end_project'] != null || $lista['fk_id_job'] == $lista['fk_id_job_finish'])) ? 'hidden' : ' ';
                                $hidden_total = 'hidden';//(empty($lista['wo_start_project']) && empty($lista['wo_end_project']) && $lista['fk_id_job'] == $lista['fk_id_job_finish']) ? '' : 'hidden';

                                $hidden_edit = 'hidden';//($lista['finish'] == "0000-00-00 00:00:00" || $lista['fk_id_job'] == $lista['fk_id_job_finish']) ? 'hidden' : ' ';

                                $workingHours = $lista['finish'] == "0000-00-00 00:00:00"?"": calculate_time_difference_in_hours($lista['start'], $lista['finish']);

                                $hours_start = ($lista['wo_start_project'] != null || $lista['fk_id_job'] == $lista['fk_id_job_finish']) 
                                    ? "<p>" . $hoursStart . "</p>" 
                                    : "<p class='text-danger'><b>" . $hoursStart . "</b></p>";

                                $hours_finished = ($lista['wo_end_project'] != null || $lista['fk_id_job'] == $lista['fk_id_job_finish']) 
                                    ? "<p>" . $hoursFinish . "</p>" 
                                    : "<p class='text-danger'><b>" . $hoursFinish . "</b></p>";


                                $text_start = ($lista['finish'] != "0000-00-00 00:00:00" && $lista['fk_id_job'] != $lista['fk_id_job_finish']) 
                                    ? "<p class='text-danger'><b>Job Code/Name: " . $lista['job_start'] . "</b></p>" 
                                    : "";

                                $text_finished = ($lista['finish'] != "0000-00-00 00:00:00" && $lista['fk_id_job'] != $lista['fk_id_job_finish']) 
                                    ? "<p class='text-danger'><b>Job Code/Name: " . $lista['job_finish'] . "</b></p>"
                                    : "";
                                
                                $textSameJob = $lista['fk_id_job'] == $lista['fk_id_job_finish'] 
                                    ? "<br><br><p><b>Job Code/Name: " . $lista['job_start'] . "</b></p>"
                                    :' ';

                                echo "<tr>";
                                echo "<td>" . $lista['first_name'] . " " . $lista['last_name'] . "</td>";
                                echo "<td class='text-center'>" . $hours_start . $text_start;
                                echo "<button type='button' class='btn btn-danger btn-sm " . $hidden_start . "' data-toggle='modal' id='btnAssign_" . $lista["id_task"] . "' time='start'>Assign to a W.O.</button>";
                                echo $lista["wo_start_project"] ? "<a target='_blanck' href='" . base_url('workorders/add_workorder/' . $lista['wo_start_project']) . "'>(W.O. # " . $lista['wo_start_project'] . ")</a>" : "";
                                echo "</td>";

                                echo "<td class='text-center'>" . $hours_finished . $text_finished;
                                echo "<button type='button' class='btn btn-danger btn-sm " . $hidden_finished . "' data-toggle='modal' id='btnAssign_" . $lista["id_task"] . "' time='end'>Assign to a W.O.</button>";
                                echo $lista["wo_end_project"] ? "<a target='_blanck' href='" . base_url('workorders/add_workorder/' . $lista['wo_end_project']) . "'>(W.O. # " . $lista['wo_end_project'] . ")</a>" : "";
                                echo "</td>";

                                echo "<td class='text-center'>" . convert_hours_minutes($workingHours) . $textSameJob . "</td>";

                                // Ahora recorremos todas las órdenes de trabajo y verificamos si el usuario tiene horas en esa WO
                                if (isset($workOrderCheck) && $workOrderCheck) {
                                    $sumWorkorders = 0;
                                    foreach ($workOrderCheck as $wo) {
                                        // Verificamos si el empleado tiene horas en esta W.O.
                                        $arrParamCheck = array("idWorkorder" => $wo['id_workorder'], "idUser" => $lista['fk_id_user']);
                                        $hoursPersonalWorked = $this->general_model->countHoursPersonal($arrParamCheck);
                                        $hoursEquipmentWorked = $this->general_model->countHoursEquipmentPersonal($arrParamCheck);

                                        $hoursWorked = $hoursPersonalWorked + $hoursEquipmentWorked;

                                        echo "<td class='text-center'>";
                                        echo convert_hours_minutes($hoursWorked) ;
                                        echo "</td>";
                                        $sumWorkorders += $hoursWorked;
                                    }
                                }
                                echo "<th class='text-center'>";
                                
                                echo "<p>" . convert_hours_minutes($sumWorkorders) . "</p>";
                                
                                echo "<button type='button' class='btn btn-info btn-xs job_hours_modal " . $hidden_edit . "' data-toggle='modal' data-target='#modal' id='" . $lista['id_task'] . "'>Edit <span class='glyphicon glyphicon-edit' aria-hidden='true'></button>";
                                if($sumWorkorders != $workingHours){
                                    echo "<button type='button' class='btn btn-danger btn-xs " . $hidden_total . "' data-toggle='modal' id='btnAssign_" . $lista["id_task"] . " ' time='total'>Assign to a W.O.</button><br><br>";
                                }
                                

                                /**
                                 * Opcion de editar horas para  SUPER ADMIN
                                 */
                                $userRol = $this->session->rol;
                                if ($userRol == ID_ROL_SUPER_ADMIN || $userRol == ID_ROL_ACCOUNTING) {
                                    //si no se ahn pagado entonces se pueden editar
                                    if ($lista['period_status'] == 1) {
                            ?>
                                        <button type="button" class="btn btn-info btn-xs general_hours_modal" data-toggle="modal" data-target="#modalHoursGeneral" id="<?php echo $lista['id_task']; ?>">
                                            Edit Hours <span class="glyphicon glyphicon-edit" aria-hidden="true">
                                        </button>
                                    <?php
                                    } else {
                                    ?>
                                        <div class="alert alert-danger">
                                            <span class="glyphicon glyphicon-exclamation-sign" aria-hidden="true"></span> These hours have already been paid, they cannot be edited.
                                        </div>
                            <?php
                                    }
                                }

                                if ($sumWorkorders != $lista['working_hours']) {
                                    if ($sumWorkorders < $lista['working_hours']) {
                                        echo "<br><br><p class='text-danger'><b>Payroll hours exceeds Work Order hours.</b></p>";
                                    } elseif ($sumWorkorders > $lista['working_hours']) {
                                        echo "<br><br><p class='text-warning'><b>Work Order hours exceeds Payroll hours.</b></p>";
                                    }
                                }
                                
                                
                                echo "</td>";
                                echo "</tr>";
                            endforeach;
                            ?>
                        </tbody>
                    </table>
                </div>
            </div>

            <?php
            if (isset($payrollDanger) && $payrollDanger) {
                $countRows = 0;
                foreach ($payrollDanger as $lista) {
                    $sumHours = $lista['hours_start_project'] + $lista['hours_end_project'];
                    if (($lista['wo_end_project'] == null || $lista['wo_start_project'] == null) || ($lista['working_hours'] != $sumHours && $sumHours > 0)) {
                        $countRows++;
                    }
                }
                
                if ($countRows > 0) {
            ?>
            <!--
            <div class="panel panel-danger">
                <div class="panel-heading">
                    <i class="fa fa-book fa-fw"></i> <strong>PAYROLL ALERT</strong> - The following list contains items that are not associated with any Work Orders or need to check the sum of hours.
                </div>
                <div class="panel-body">
                    <table width="100%" class="table table-striped table-bordered table-hover small" id="dataTables">
                        <thead>
                            <tr>
                                <th width='6%'>Employee</th>
                                <th width='8%' class="text-center">Working Hours</th>
                                <th width='18%'>Job Code/Name - Start</th>
                                <th width='8%' class="text-center">Hours Worked at Project Start</th>
                                <th width='18%'>Job Code/Name - Finish</th>
                                <th width='8%' class="text-center">Hours Worked at Project Finish</th>
                                <th width='34%' > </th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            foreach ($payrollDanger as $lista) :
                                $sumHours = $lista['hours_start_project'] + $lista['hours_end_project'];
                                if (($lista['wo_end_project'] == null || $lista['wo_start_project'] == null) || ($lista['working_hours'] != $sumHours && $sumHours > 0)) {
                                    $hoursStart = ($lista['finish'] == "0000-00-00 00:00:00" || $lista['hours_start_project'] == 0)?"":$lista['hours_start_project'] . " (Hours)";
                                    $hoursFinish = ($lista['finish'] == "0000-00-00 00:00:00" || $lista['hours_end_project'] == 0)?"":$lista['hours_end_project'] . " (Hours)";
    
                                    $hidden_start = ($lista['wo_start_project'] != null || $lista['fk_id_job'] == $lista['fk_id_job_finish']) ? 'hidden' : ' ';
                                    $hidden_finished = ($lista['wo_end_project'] != null || $lista['fk_id_job'] == $lista['fk_id_job_finish']) ? 'hidden' : ' ';
                                    $hidden_total = (empty($lista['wo_start_project']) && empty($lista['wo_end_project']) && $lista['fk_id_job'] == $lista['fk_id_job_finish']) ? '' : 'hidden';
                                    $hidden_edit = ($lista['fk_id_job'] == $lista['fk_id_job_finish']) ? 'hidden' : ' ';

                                    $text_total = (empty($lista['wo_start_project']) && empty($lista['wo_end_project']) && $lista['fk_id_job'] == $lista['fk_id_job_finish']) ? "<p class='text-danger'><b>" . substr($lista['working_hours_new'], 0, -3) . " (HH:MM)</br>" . $lista['working_hours'] . " (Hours)</b></p>": substr($lista['working_hours_new'], 0, -3) . " (HH:MM)</br>" . $lista['working_hours'] . " (Hours)";
                                    $text_start = ($lista['wo_start_project'] != null || $lista['fk_id_job'] == $lista['fk_id_job_finish']) ? "<p>" . $hoursStart . "</p>" : "<p class='text-danger'><b>" . $hoursStart . "</b></p>";
                                    $text_finished = ($lista['wo_end_project'] != null || $lista['fk_id_job'] == $lista['fk_id_job_finish']) ? "<p>" . $hoursFinish . "</p>": "<p class='text-danger'><b>" . $hoursFinish . "</b></p>";

                                    echo "<tr>";
                                    echo "<td>" . $lista['first_name'] . " " . $lista['last_name'] . "</td>";
                                    echo "<td class='text-center'>";
                                    echo $text_total;
                                    echo "</td>";
                                    echo "<td>" . $lista['job_start'] . "</td>";
                                    echo "<td class='text-center'>" . $text_start;
                                    echo "<button type='button' class='btn btn-danger btn-sm " . $hidden_start . "'  data-toggle='modal' id='btnAssign_" . $lista["id_task"] . " ' time='start'>Assign to a W.O.</button>";
                                    echo $lista["wo_start_project"]?"<a target='_blanck' href='" . base_url('workorders/add_workorder/' . $lista['wo_start_project']) . "'>(W.O. # " . $lista['wo_start_project'] . ")</a>":"";
                                    echo  "</td>";
                                    echo "<td>" . $lista['job_finish'] . "</td>";
                                    echo "<td class='text-center'>" . $text_finished;
                                    echo "<button type='button' class='btn btn-danger btn-sm " . $hidden_finished . "' data-toggle='modal' id='btnAssign_" . $lista["id_task"] . " ' time='end'>Assign to a W.O.</button>";
                                    echo $lista["wo_end_project"]?"<a target='_blanck' href='" . base_url('workorders/add_workorder/' . $lista['wo_end_project']) . "'>(W.O. # " . $lista['wo_end_project'] . ")</a>":"";
                                    echo  "</td>";
                                    echo "<td>";
                                    echo "<button type='button' class='btn btn-info btn-xs " . $hidden_edit . "' data-toggle='modal' data-target='#modal' id='" . $lista['id_task'] . "'>Edit <span class='glyphicon glyphicon-edit' aria-hidden='true'></button>";
                                    echo "<button type='button' class='btn btn-danger btn-sm " . $hidden_total . "' data-toggle='modal' id='btnAssign_" . $lista["id_task"] . " ' time='total'>Assign to a W.O.</button>";
                                    if ($lista['working_hours'] != $sumHours) {
                                        echo "<br><br><p class='text-danger'><b>These hours were changed from the Work Order, but the sum is not equal to the Working Hours.</b></p>";
                                    }
                                    if ($lista['wo_start_project'] == null) {
                                        echo "<br><br><p class='text-danger'><b>Hours worked at project start have not been assigned to a Work Order.</b></p>";
                                    }
                                    if ($lista['wo_end_project'] == null) {
                                        echo "<br><br><p class='text-danger'><b>Hours worked at project finish have not been assigned to a Work Order.</b></p>";
                                    }
                                    echo "</td>";
                                    echo "</tr>";                                    
                                }
                            endforeach;
                            ?>
                        </tbody>
                    </table>
                </div>
            </div>
                        -->
            <?php   }   } ?>
        </div>
    </div>
    <?php   } ?>

    <?php
        if (isset($haulingInfo) && $haulingInfo) {
    ?>
    <div class="row">
        <div class="col-lg-12">
            <div class="panel panel-warning">
                <div class="panel-heading">
                    <i class="fa fa-truck fa-fw"></i> <strong>HAULING RECORDS</strong> - <?php echo date('l, F j, Y', strtotime($fecha)); ?>
                </div>

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
                            foreach ($haulingInfo as $lista) :
                                echo "<tr>";
                                echo "<td class='text-center'>" . $lista['id_hauling'] . "</td>";
                                echo "<td>" . $lista['name'] . "</td>";
                                echo "<td class='text-center'>";
                            ?>
                                <a href='<?php echo base_url('report/generaHaulingPDF/x/x/x/x/' . $lista['id_hauling']); ?>' target="_blank"> <img src='<?php echo base_url_images('pdf.png'); ?>'></a>
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
                </div>
            </div>
        </div>
    </div>
    <?php   } ?>

    <?php
        if (isset($safetyInfo) && $safetyInfo) {
    ?>
    <div class="row">
        <div class="col-lg-12">
            <div class="panel panel-info">
                <div class="panel-heading">
                    <i class="fa fa-life-saver fa-fw"></i> <strong>FLHA RECORDS</strong> - <?php echo date('l, F j, Y', strtotime($fecha)); ?>
                </div>
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
                            foreach ($safetyInfo as $lista) :
                                echo "<tr>";
                                echo "<td>" . $lista['job_description'] . "</td>";
                                echo "<td>" . $lista['name'] . "</td>";
                                echo "<td>" . $lista['work'] . "</td>";
                                echo "<td class='text-center'>";
                            ?>
                                <a href='<?php echo base_url('report/generaSafetyPDF/x/x/x/' . $lista['id_safety']); ?>' target="_blank"> <img src='<?php echo base_url_images('pdf.png'); ?>'></a>
                            <?php
                                echo "</td>";
                                echo "</tr>";
                            endforeach;
                            ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    <?php   } ?>

    <?php
        if (isset($toolBoxInfo) && $toolBoxInfo) {
    ?>
    <div class="row">
        <div class="col-lg-12">
            <div class="panel panel-warning">
                <div class="panel-heading">
                    <i class="fa fa-cube fa-fw"></i> <strong>IHSR RECORDS</strong> - <?php echo date('l, F j, Y', strtotime($fecha)); ?>
                </div>

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
                            foreach ($toolBoxInfo as $lista) :
                                echo "<tr>";
                                echo "<td>" . $lista['job_description'] . "</td>";
                                echo "<td>" . $lista['name'] . "</td>";
                                echo "<td>" . $lista['activities'] . "</td>";
                                echo "<td>" . $lista['suggestions'] . "</td>";
                                echo "<td class='text-center'>";
                            ?>
                                <a href='<?php echo base_url('jobs/generaTemplatePDF/' . $lista['id_tool_box']); ?>' target="_blank"><img src='<?php echo base_url_images('pdf.png'); ?>'></a>
                            <?php
                                echo "</td>";
                                echo "</tr>";
                            endforeach;
                            ?>
                        </tbody>
                    </table>

                </div>
            </div>
        </div>
    </div>
    <?php   } ?>

</div>

<!--INICIO Modal para adicionar WORKER -->
<div class="modal fade text-center" id="modalWorker" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog" role="document">
        <div class="modal-content" id="tablaDatos">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="exampleModalLabel">Assign hours to a Work Order</h4>
            </div>
            <div class="modal-body">
                <h5 id="modalMessage"></h5> <!-- Mensaje que se mostrará -->
                <p id="time" hidden></p>
                <p id="taskId" hidden></p>
                <p id="workorderID" hidden></p>
            </div>
            <div class="modal-footer">
                <button type="button" id="btnModalAssign" class="btn btn-primary">Assign</button> <!-- Botón para asignar -->
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>
<!--FIN Modal para adicionar WORKER -->

<!--INICIO Modal cambio de hora-->
<div class="modal fade text-center" id="modal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog" role="document">
        <div class="modal-content" id="tablaHours">

        </div>
    </div>
</div>
<!--FIN Modal-->

<!--INICIO Modal cambio de hora-->
<div class="modal fade text-center" id="modalHoursGeneral" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
	<div class="modal-dialog" role="document">
		<div class="modal-content" id="tablaHoursGeneral">

		</div>
	</div>
</div>
<!--FIN Modal-->

<link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
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

    $('[id^=btnAssign_]').click(function() {
        var taskId = $(this).attr('id').split('_')[1];
        var time = $(this).attr('time');

        $.ajax({
            type: 'POST',
            url: base_url + 'dashboard/modalListWo',
            data: {
                'taskId': taskId,
                'time': time
            },
            success: function(response) {

                if (response) {
                    $('#modalMessage').text('Assign hours to the W.O. #: ' + response.id_workorder);
                    $('#time').text(time);
                    $('#taskId').text(taskId);
                    $('#workorderID').text(response.id_workorder);
                    $('#btnModalAssign').show();
                } else {
                    $('#modalMessage').text("There is no W.O. for the date the employee worked and the Job Code used.");
                    $('#btnModalAssign').hide();
                }
                $('#modalWorker').modal('show');
            },
            error: function() {
                alert('Error al cargar los datos.');
            }
        });
    });

    // Manejo del botón "Asignar"
    $('#btnModalAssign').click(function() {
        var messageText = $('#modalMessage').text();
        var woID = $('#workorderID').text();
        var timeText = $('#time').text();
        var taskId = $('#taskId').text();

        $.ajax({
            type: 'POST',
            url: base_url + 'dashboard/assignHoursWo',
            data: {
                'taskId': taskId,
                'woID': woID,
                'time': timeText
            },
            success: function(response) {
                $('#modalWorker').modal('hide');
                window.location.reload();
            },
            error: function(xhr, status, error) {
                console.error(error);
                alert('Error al asignar horas: ' + xhr.status + ' - ' + xhr.statusText);
            }
        });
    });

    $(".general_hours_modal").click(function() {
        var oID = $(this).attr("id");
        $.ajax({
            type: 'POST',
            url: base_url + 'payroll/cargarModalHours',
            data: {
                'idTask': oID
            },
            cache: false,
            success: function(data) {
                $('#tablaHoursGeneral').html(data);
            }
        });
    });

    $(".job_hours_modal").click(function() {
        var oID = $(this).attr("id");
        $.ajax({
            type: 'POST',
            url: base_url + 'payroll/cargarModalJobCode',
            data: {
                'idTask': oID
            },
            cache: false,
            success: function(data) {
                $('#tablaHours').html(data);
            }
        });
    });


</script>