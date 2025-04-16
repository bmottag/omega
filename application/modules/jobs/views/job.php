<script type="text/javascript" src="<?php echo base_url("assets/js/validate/jobs/job_detail.js"); ?>"></script>

<script>
$(function(){ 
	$(".btn-success").click(function () {	
			var oID = $(this).attr("id");
            $.ajax ({
                type: 'POST',
				url: base_url + '/jobs/cargarModalJobDetail',
                data: {'idJob': '', 'idJobDetail': oID},
                cache: false,
                success: function (data) {
                    $('#tablaDatos').html(data);
                }
            });
	});
    
	$(".lic_add_modal").click(function () {	
			var oID = $(this).attr("id");
            $.ajax ({
                type: 'POST',
				url: base_url + 'jobs/cargarModalJobDetail',
				data: {'identification': oID, 'idJobDetail': 'x'},
                cache: false,
                success: function (data) {
                    $('#tablaDatos').html(data);
                }
            });
	});	
});
</script>

<div id="page-wrapper">
    <br>
    <div class="row">
        <div class="col-lg-12">
            <div class="panel panel-dark">
                <div class="panel-heading">
                    <a class="btn btn-dark btn-xs" href=" <?php echo base_url().'admin/job/1'; ?> "><span class="glyphicon glyphicon glyphicon-chevron-left" aria-hidden="true"></span> Go back </a> 
                    <i class="fa fa-gears fa-fw"></i> <b>Line Item Contract (LIC)</b>
                </div>
                <div class="panel-body small">

                    <div class="alert alert-info">
						<span class="fa fa-briefcase" aria-hidden="true"></span>
						<strong>Job Code/Name: </strong><?php echo $jobInfo[0]['job_description']; ?>
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

                    <?php
                        if($jobInfo[0]['flag_expenses'] != 1){
                    ?>	
                        <?php 
                            if (!empty($success)) {
                                echo '<div class="col-lg-12">';
                                echo '<div class="alert text-center alert-success"><label>' . $success . '</label></div>';
                                echo '</div>';
                            } 
                        ?>

                        <form  name="formCargue" id="formCargue" class="form-horizontal" method="post" enctype="multipart/form-data" action="<?php echo base_url("jobs/do_upload_job_info"); ?>">
                            <input type="hidden" id="hddIdJob" name="hddIdJob" value="<?php echo $jobInfo[0]["id_job"]; ?>"/>
                            <input type="hidden" id="hddFlagExpenses" name="hddFlagExpenses" value="<?php echo $jobInfo[0]["flag_expenses"]; ?>"/>
                            <input type="hidden" id="hddFlagUploadDetails" name="hddFlagUploadDetails" value="<?php echo $jobInfo[0]["flag_upload_details"]; ?>"/>
                                
                            <div class="col-lg-3">				
                                <div class="form-group">					
                                    <label class="col-sm-5 control-label" for="hddTask">Attach LIC File:</label>
                                    <div class="col-sm-5">
                                        <input type="file" name="userfile" />
                                    </div>
                                </div>
                            </div>
                        
                            <div class="col-lg-3">				
                                <div class="form-group">
                                    <div class="row" align="center">
                                        <div style="width:50%;" align="center">
                                            <button type="submit" id="btnSubir" name="btnSubir" class='btn btn-primary btn-sm'>
                                                Upload LIC <span class="glyphicon glyphicon-floppy-disk" aria-hidden="true">
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </form>

                        <?php if($error){ ?>
                            <div class="col-lg-12">
                                <div class="alert alert-danger">
                                <?php 
                                    echo "<strong>Error :</strong>";
                                    pr($error); 
                                ?><!--$ERROR MUESTRA LOS ERRORES QUE PUEDAN HABER AL SUBIR LA IMAGEN-->
                                </div>
                            </div>
                        <?php } ?>

                        <div class="col-lg-12">
                            <div class="alert alert-info">
                                    <strong>Note :</strong><br>
                                    Allowed format: CSV<br>
                                    Maximum size: 4096 KB
                            </div>
                        </div>
                    <?php
                        }else{
                    ?>	
                        <div class="row">
                            <div class="col-lg-12">
                                <div class="panel panel-default">
                                    <div class="panel-footer">
                                        <div class="row">
                                            <div class="col-lg-12">
                                                <div class="alert alert-danger ">
                                                    <span class="glyphicon glyphicon-exclamation-sign" aria-hidden="true"></span>
                                                    Currently, there are entries in the WO (Work Orders) detailing various expenses related to this Job Code. Unfortunately, there is an inability to upload additional information at this time.
                                                </div>

                                                <form  name="formDeleteInfo" id="formDeleteInfo" method="post" action="<?php echo base_url("jobs/delete_job_detail_info"); ?>">
                                                    <div class="panel panel-default">
                                                        <div class="panel-footer">
                                                            <div class="row">
                                                                <div class="col-lg-2">
                                                                    <div class="form-group">
                                                                        <input type="hidden" id="hddIdJob" name="hddIdJob" value="<?php echo $jobInfo[0]["id_job"]; ?>"/>
                                                                        <button type="button" id="btnSubmit" name="btnSubmit" class="btn btn-danger btn-sm" onclick="deleteInformation()">
                                                                            Reset all the Information <span class="glyphicon glyphicon-search" aria-hidden="true"></span>
                                                                        </button> 
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    <?php
                    }
                    if($chapterList){
                        $ci = &get_instance();
                        $ci->load->model("general_model");

                        foreach ($chapterList as $lista):
                            $arrParam = array("idJob" => $jobInfo[0]['id_job'], "chapterNumber" => $lista['chapter_number']);
                            $jobDetails = $this->general_model->get_job_detail($arrParam);

                            $totalExtendedAmount = 0;
                            $totalPercentage = 0;
                            $totalExpenses = 0;
                            $totalBalance = 0;

                            //if($jobInfo[0]['flag_expenses'] == 1){
					?>

                            <div class="panel-body">
                                <div class="panel-group" id="accordion">	
                                    <h2><?php echo $lista['chapter_name']; ?></h2>
                                    <button type="button" class="btn btn-dark btn-block lic_add_modal" data-toggle="modal" data-target="#modal" id="<?php echo $jobInfo[0]["id_job"] . "-" . $lista["chapter_number"] . "-" . $lista["chapter_name"]; ?>">
                                            <span class="glyphicon glyphicon-plus" aria-hidden="true"></span> Add APU's
                                    </button><br>
                                    <?php
                                        foreach ($jobDetails as $data):
                                            $balance = $data['extended_amount'] - $data['expenses'];
                                            $veintePorciento = $data['extended_amount'] * 0.2;
    
                                            $class = $balance <= $veintePorciento ? "danger" : "default";
    
                                            $totalExtendedAmount += $data['extended_amount'];
                                            $totalPercentage += $data['percentage'];
                                            $totalExpenses += $data['expenses'];
                                    ?>
                                        <div class="panel panel-<?php echo $class ?>" >
                                            <div class="panel-heading">
                                                <h4 class="panel-title">
                                                    <a data-toggle="collapse" data-parent="#accordion" href="#collapse<?php echo $data['chapter_number'] . $data['item']; ?>">

                                                    <table width="100%" class="table table-striped table-bordered table-hover small" id="dataTables">
                                                    <?php
                                                        echo "<tr class='" . $class . "'>";
                                                        echo "<td width='4%' class='text-center'><p class='text-" . $class . "'><b>Item</b><br>" . $data['chapter_number'] . "." . $data['item'] . "</p>";
                                                    ?>
                                                        <button type="button" class="btn btn-success btn-xs" data-toggle="modal" data-target="#modal" id="<?php echo $data['id_job_detail']; ?>" >
                                                            <span class="glyphicon glyphicon-edit" aria-hidden="true">
                                                        </button>

                                                        <button type="button" id="<?php echo $jobInfo[0]["id_job"] . '-' . $data['id_job_detail']; ?>" class='btn btn-danger btn-xs btn-delete-job-detail' title="Delete">
                                                            <i class="fa fa-trash-o"></i>
                                                        </button>
                                                    <?php
                                                        echo "</td>";
                                                        echo "<td width='42%'><p class='text-" . $class . "'><b>Description</b><br>" . $data['description'] . "</p></td>";
                                                        echo "<td width='4%' class='text-center'><p class='text-" . $class . "'><b>Unit</b><br>" . $data['unit'] . "</p></td>";
                                                        echo "<td width='8%' class='text-center'><p class='text-" . $class . "'><b>Quantity</b><br>" . $data['quantity'] . "</p></td>";
                                                        echo "<td width='8%' class='text-right'><p class='text-" . $class . "'><b>Unit Price</b><br>$ " . number_format($data['unit_price'],2) . "</p></td>";
                                                        echo "<td width='10%' class='text-right'><p class='text-" . $class . "'><b>Extended Amount</b><br>$ " . number_format($data['extended_amount'],2) . "</p></td>";
                                                        echo "<td width='5%' class='text-right'><p class='text-" . $class . "'><b>%</b><br>" . $data['percentage'] . " %</p></td>";
                                                        echo "<td width='10%' class='text-right'><p class='text-" . $class . "'><b>W.O. Expenses</b><br>$ " . number_format($data['expenses'],2) . "</p></td>";
                                                        echo "<td width='9%' class='text-right'><p class='text-" . $class . "'><b>Balance</b><br>$ " . number_format($balance,2) . "</p></td>";
                                                        echo "</tr>";
                                                    ?>
                                                    </table>
                                                    </a>
                                                </h4>
                                            </div>
                                            <div id="collapse<?php echo $data['chapter_number'] . $data['item']; ?>" class="panel-collapse collapse">
                                                <div class="panel-body">
                                                    <?php 
                                                        $arrParam = array("idJobDetail" => $data['id_job_detail']);
                                                        $expenses = $ci->jobs_model->countExpenses($arrParam);//sumatoria de gastos

                                                        if($expenses){
                                                    ?>
                                                        <table width="100%" class="table table-hover dataTable no-footer" id="dataTables">
                                                            <thead>
                                                                <tr>
                                                                    <th class="text-center" >W.O. #</th>
                                                                    <th class="text-center" >Date W.O.</th>
                                                                    <th class="text-left" >Work Done</th>
                                                                    <th class="text-right" >Expense Value</th>
                                                                </tr>
                                                            </thead>
                                                            <tbody>					
                                                            <?php
                                                                foreach ($expenses as $data):
                                                                    echo "<tr>";
                                                                    echo "<td class='text-center'>";
                                                                    echo "<a href='" . base_url('workorders/add_workorder/' . $data['id_workorder']) . "' target='_blank'>" . $data['id_workorder'] . "</a>";
                                                                    echo "</td>";
                                                                    echo "<td class='text-center'>" . $data['date'] . "</td>";
                                                                    echo "<td class='text-left'>" . $data['observation'] . "</td>";
                                                                    echo "<td class='text-right'>$ " . number_format($data['total_expenses'],2) . "</td>";
                                                                    echo "</tr>";
                                                                endforeach;
                                                            ?>
                                                            </tbody>
                                                        </table>
                                                    <?php } ?>
                                                </div>
                                            </div>
                                        </div>
                                    <?php
                                        endforeach;

                                        $totalBalance = $totalExtendedAmount - $totalExpenses;
                                        echo "<br>";
                                        echo '<table width="100%" class="table table-striped table-bordered table-hover" id="dataTables">';
                                            echo "<tr>";
                                            echo "<td width='46%' class='text-right'><h2>Subtotal</h2></td>";
                                            echo "<td width='30%' class='text-right'><b>Extended Amount<br>$ " . number_format($totalExtendedAmount,2) . "</b></td>";
                                            //echo "<td class='text-right'><b>Percentage<br>" . $totalPercentage  . "%</b></td>";
                                            echo "<td width='15%' class='text-right'><b>W.O. Expenses<br>$ " . number_format($totalExpenses,2) . "</b></td>";
                                            echo "<td width='9%' class='text-right'><b>Balance<br>$ " . number_format($totalBalance,2) . "</b></td>";
                                            echo "</tr>";

                                        echo "</table>";
                                    ?>
                                </div>
                            </div>

                    <?php //}else{ ?>
<!--
    Esta parte se elimina porque se deja un solo formato
                            <table width="100%" class="table table-striped table-bordered table-hover" id="dataTables">
                                <thead>
                                    <tr>
                                        <th colspan="10"><?php echo $lista['chapter_name']; ?></th>
                                    </tr>
                                    <tr>
                                        <th class="text-center" width="4%">Item</th>
                                        <th class="text-left" width="35%">Description</th>
                                        <th class="text-center" width="4%">Unit</th>
                                        <th class="text-center" width="10%">Quantity</th>
                                        <th class="text-center" width="7%">Unit Price</th>
                                        <th class="text-center" width="10%">Extended Amount</th>
                                        <th class="text-center" width="5%">Percentage</th>
                                        <th class="text-center" width="10%">W.O. Expenses</th>
                                        <th class="text-center" width="10%">Balance</th>
                                        <th class="text-center" width="5%">Edit</th>
                                    </tr>
                                </thead>					
                                <?php
                                    echo "<tbody>";

                                    foreach ($jobDetails as $data):
                                        //$arrParam = array("idJobDetail" => $data['id_job_detail']);
                                        //$expenses = $ci->general_model->sumExpense($arrParam);//sumatoria de gastos
                                        $balance = $data['extended_amount'] - $data['expenses'];
                                        $veintePorciento = $data['extended_amount'] * 0.2;

                                        $class = $balance <= $veintePorciento ? "danger" : "";

                                        $totalExtendedAmount += $data['extended_amount'];
                                        $totalPercentage += $data['percentage'];
                                        $totalExpenses += $data['expenses'];
                                        echo "<tr class='" . $class . "'>";
                                        echo "<td class='text-center'><p class='text-" . $class . "'>" . $data['chapter_number'] . "." . $data['item'] . "</p></td>";
                                        echo "<td ><p class='text-" . $class . "'>" . $data['description'] . "</p></td>";
                                        echo "<td class='text-center'><p class='text-" . $class . "'>" . $data['unit'] . "</p></td>";
                                        echo "<td class='text-center'><p class='text-" . $class . "'>" . $data['quantity'] . "</p></td>";
                                        echo "<td class='text-right'><p class='text-" . $class . "'>$ " . number_format($data['unit_price'],2) . "</p></td>";
                                        echo "<td class='text-right'><p class='text-" . $class . "'>$ " . number_format($data['extended_amount'],2) . "</p></td>";
                                        echo "<td class='text-right'><p class='text-" . $class . "'>" . $data['percentage'] . " %</p></td>";
                                        echo "<td class='text-right'><p class='text-" . $class . "'>$ " . number_format($data['expenses'],2) . "</p></td>";
                                        echo "<td class='text-right'><p class='text-" . $class . "'>$ " . number_format($balance,2) . "</p></td>";
                                        echo "<td class='text-center'>";

                                        if($jobInfo[0]['flag_expenses'] != 1){
                                ?>
                                        <button type="button" class="btn btn-success btn-xs" data-toggle="modal" data-target="#modal" id="<?php echo $data['id_job_detail']; ?>" >
                                            <span class="glyphicon glyphicon-edit" aria-hidden="true">
                                        </button>
                                <?php
                                        }
                                        echo "</td>";
                                        echo "</tr>";
                                    endforeach;
                                    echo "</tbody>";

                                    $totalBalance = $totalExtendedAmount - $totalExpenses;
                                    echo "<tfoot>";
                                        echo "<tr>";
                                        echo "<td colspan='5' class='text-right'><b>Subtotal</b></td>";
                                        echo "<td class='text-right'><b>$ " . number_format($totalExtendedAmount,2) . "</b></td>";
                                        echo "<td class='text-right'><b>" . $totalPercentage  . "%</b></td>";
                                        echo "<td class='text-right'><b>$ " . number_format($totalExpenses,2) . "</b></td>";
                                        echo "<td class='text-right'><b>$ " . number_format($totalBalance,2) . "</b></td>";
                                        echo "<td class='text-right'></td>";
                                        echo "</tr>";
                                    echo "</tfoot>";
                                ?>
                            </table>
-->
                    <?php 
                           // }
                        endforeach;
                        } 
                    ?>
                </div>
            </div>
        </div>
    </div>
</div>

<!--INICIO Modal -->
<div class="modal fade text-center" id="modal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">    
	<div class="modal-dialog  modal-lg" role="document">
		<div class="modal-content" id="tablaDatos">

		</div>
	</div>
</div>                       
<!--FIN Modal -->

<!-- Tables -->
<script>
$(document).ready(function() {
	$('#dataTables').DataTable({
		responsive: true,
		"ordering": false,
        paging: false,
        "searching": false,
        "info": false
	});
});


$(function() {
    $('#btnSubir').click(function(event) {
        event.preventDefault();
        $('#btnSubir').addClass('disabled');
        $('#animationload').fadeIn();
        $('#formCargue').submit();
    });
});


/*
* Function Delelete information
*/
function deleteInformation(attachmentId, status) {
    if (window.confirm('Are you sure you want to reset all the information?')) {
        document.getElementById('formDeleteInfo').submit();
    }
}
</script>