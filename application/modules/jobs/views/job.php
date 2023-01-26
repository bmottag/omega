<script>
$(function(){ 
	$(".btn-success").click(function () {	
			var oID = $(this).attr("id");
            $.ajax ({
                type: 'POST',
				url: base_url + '/jobs/cargarModalJobDetail',
                data: {'idJobDetail': oID},
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
            <div class="panel panel-primary">
                <div class="panel-heading">
                    <a class="btn btn-primary btn-xs" href=" <?php echo base_url().'jobs'; ?> "><span class="glyphicon glyphicon glyphicon-chevron-left" aria-hidden="true"></span> Go back </a> 
                    <i class="fa fa-list fa-fw"></i> <b>JOB CODE DETAIL</b>
                </div>
                <div class="panel-body small">

                    <div class="alert alert-info">
						<span class="fa fa-briefcase" aria-hidden="true"></span>
						<strong>Job Code/Name: </strong><?php echo $jobInfo[0]['job_description']; ?>
					</div>	

                    <?php
                        if(!$chapterList){
                    ?>	
                        <div class="alert alert-success ">
                            <span class="glyphicon glyphicon-ok" aria-hidden="true"></span>
                            You have not upload any Job Detail Information.
                            <a class="btn btn-primary btn-xs" href="<?php echo base_url('jobs/upload_job_detail/' . $jobInfo[0]['id_job']) ?>"><i class="fa fa-upload fa-fw"></i> Upload Job Details</a>
                        </div>
                    <?php
                        }else{
                    ?>	
                    <div class="row">
                        <div class="col-lg-12">
                            <form  name="formPercentage" id="formPercentage" method="post" action="<?php echo base_url("jobs/update_job_detail"); ?>">
                                <div class="panel panel-default">
                                    <div class="panel-footer">
                                        <div class="row">
                                            <div class="col-lg-2">
                                                <div class="form-group">
                                                    <input type="hidden" id="hddIdJob" name="hddIdJob" value="<?php echo $jobInfo[0]["id_job"]; ?>"/>
                                                    <button type="submit" id="btnSearch" name="btnSearch" class="btn btn-primary btn-sm" >
                                                        Calculate percentages <span class="glyphicon glyphicon-search" aria-hidden="true"></span>
                                                    </button> 
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>

                    <?php
                        $ci = &get_instance();
                        $ci->load->model("general_model");

                        foreach ($chapterList as $lista):
                            $arrParam = array("idJob" => $jobInfo[0]['id_job'], "chapterNumber" => $lista['chapter_number']);
                            $jobDetails = $this->general_model->get_job_detail($arrParam);
					?>
			
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
                                    $totalExtendedAmount = 0;
                                    $totalPercentage = 0;
                                    $totalExpenses = 0;
                                    $totalBalance = 0;
                                    foreach ($jobDetails as $data):
                                        $arrParam = array("idJobDetail" => $data['id_job_detail']);
                                        $expenses = $ci->general_model->sumExpense($arrParam);//sumatoria de gastos
                                        $balance = $data['extended_amount'] - $expenses;
                                        $totalExtendedAmount += $data['extended_amount'];
                                        $totalPercentage += $data['percentage'];
                                        $totalExpenses += $expenses;
                                        echo "<tr>";
                                        echo "<td class='text-center'>" . $data['chapter_number'] . "." . $data['item'] . "</td>";
                                        echo "<td >" . $data['description'] . "</td>";
                                        echo "<td class='text-center'>" . $data['unit'] . "</td>";
                                        echo "<td class='text-center'>" . $data['quantity'] . "</td>";
                                        echo "<td class='text-right'>$ " . $data['unit_price'] . "</td>";
                                        echo "<td class='text-right'>$ " . number_format($data['extended_amount'],2) . "</td>";
                                        echo "<td class='text-right'> " . $data['percentage'] . " %</td>";
                                        echo "<td class='text-right'>$ " . number_format($expenses,2) . "</td>";
                                        echo "<td class='text-right'>$ " . number_format($balance,2) . "</td>";
                                        echo "<td class='text-center'>";
                                ?>
                                        <button type="button" class="btn btn-success btn-xs" data-toggle="modal" data-target="#modal" id="<?php echo $data['id_job_detail']; ?>" >
                                            <span class="glyphicon glyphicon-edit" aria-hidden="true">
                                        </button>
                                <?php
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
                    <?php 
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
</script>