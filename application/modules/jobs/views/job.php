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
                <div class="panel-body">

                    <div class="alert alert-info">
						<span class="fa fa-briefcase" aria-hidden="true"></span>
						<strong>Job Code/Name: </strong><?php echo $jobInfo[0]['job_description']; ?>
					</div>	

                    <?php
                        if(!$jobDetails){
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
			
                    <table width="100%" class="table table-striped table-bordered table-hover" id="dataTables">
                        <thead>
                            <tr>
                                <th class="text-center">Chapter</th>
                                <th class="text-center">Item</th>
                                <th class="text-center">Description</th>
                                <th class="text-center">Unit</th>
                                <th class="text-center">Quantity</th>
                                <th class="text-center">Unit Price</th>
                                <th class="text-center">Extended Amount</th>
                                <th class="text-center">Percentage</th>
                                <th class="text-center">Edit</th>
                            </tr>
                        </thead>
                        <tbody>							
                        <?php
                            foreach ($jobDetails as $data):
                                echo "<tr>";
                                echo "<td >" . $data['chapter_name'] . "</td>";
                                echo "<td class='text-center'>" . $data['chapter_number'] . "." . $data['item'] . "</td>";
                                echo "<td >" . $data['description'] . "</td>";
                                echo "<td class='text-center'>" . $data['unit'] . "</td>";
                                echo "<td class='text-center'>" . $data['quantity'] . "</td>";
                                echo "<td class='text-right'>$ " . $data['unit_price'] . "</td>";
                                echo "<td class='text-right'>$ " . $data['extended_amount'] . "</td>";
                                echo "<td class='text-right'> " . $data['percentage'] . " %</td>";
                                echo "<td class='text-center'>";
                    ?>
                                <button type="button" class="btn btn-success btn-xs" data-toggle="modal" data-target="#modal" id="<?php echo $data['id_job_detail']; ?>" >
                                    Edit <span class="glyphicon glyphicon-edit" aria-hidden="true">
                                </button>
                    <?php
                                echo "</td>";
                                echo "</tr>";
                            endforeach;
                        ?>
                        </tbody>
                    </table>
                <?php } ?>
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
		"order": [[ 1, "asc" ]],
		"pageLength": 100
	});
});
</script>