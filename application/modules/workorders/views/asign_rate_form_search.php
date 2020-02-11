<link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
<script type="text/javascript" src="<?php echo base_url("assets/js/validate/workorder/search_v2.js"); ?>"></script>

<div id="page-wrapper">

	<br>	
	<!-- /.row -->
	<div class="row">
		<div class="col-lg-8">
			<div class="panel panel-primary">
				<div class="panel-heading">
					<i class="fa fa-money"></i> <strong>WORK ORDERS</strong>
				</div>
				<div class="panel-body">
					<div class="alert alert-info">
						<strong>Note:</strong> 
						Select at least one of the following fields
					</div>
					<form  name="form" id="form" role="form" method="post" class="form-horizontal" >

						<div class="form-group">
							<div class="col-sm-5 col-sm-offset-1">
								<label for="from">Job Code/Name </label>
								<select name="jobName" id="jobName" class="form-control" >
									<option value=''>Select...</option>
									<?php for ($i = 0; $i < count($jobList); $i++) { ?>
										<option value="<?php echo $jobList[$i]["id_job"]; ?>" ><?php echo $jobList[$i]["job_description"]; ?></option>	
									<?php } ?>
								</select>
							</div>
							
							<div class="col-sm-5">
								<label for="from">Work order number </label>
								<input type="text" id="workOrderNumber" name="workOrderNumber" class="form-control" placeholder="W.O. #" >
							</div>
						</div>
						
						<div class="form-group">
							<div class="col-sm-5 col-sm-offset-1">
								<label for="from">Work order number range </label>
								<input type="text" id="workOrderNumberFrom" name="workOrderNumberFrom" class="form-control" placeholder="W.O. # From" >
							</div>
							
							<div class="col-sm-5">
								<label for="from">To </label>
								<input type="text" id="workOrderNumberTo" name="workOrderNumberTo" class="form-control" placeholder="W.O. # To" >
							</div>
						</div>
						
<script>
$( function() {
var dateFormat = "mm/dd/yy",
from = $( "#from" )
.datepicker({
changeMonth: true,
numberOfMonths: 2
})
.on( "change", function() {
to.datepicker( "option", "minDate", getDate( this ) );
}),
to = $( "#to" ).datepicker({
changeMonth: true,
numberOfMonths: 2
})
.on( "change", function() {
from.datepicker( "option", "maxDate", getDate( this ) );
});

function getDate( element ) {
var date;
try {
date = $.datepicker.parseDate( dateFormat, element.value );
} catch( error ) {
date = null;
}

return date;
}
});
</script>
						<div class="form-group">
							<div class="col-sm-5 col-sm-offset-1">
								<label for="from">From Date</label>
								<input type="text" id="from" name="from" class="form-control" placeholder="From" >
							</div>
							<div class="col-sm-5">
								<label for="to">To Date</label>
								<input type="text" id="to" name="to" class="form-control" placeholder="To" >
							</div>
						</div>

<div class="row"></div><br>
						<div class="form-group">
							<div class="row" align="center">
								<div style="width80%;" align="center">
									
								 <button type="submit" class="btn btn-primary" id='btnSubmit' name='btnSubmit'><span class="glyphicon glyphicon-search" aria-hidden="true"></span> Go </button>
									
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
		
		<div class="col-lg-4">
			<div class="panel panel-danger">
				<div class="panel-heading">
					<i class="fa fa-bell fa-fw"></i> Notifications Panel - Word Orders <?php echo date("Y"); ?>
				</div>
				<!-- /.panel-heading -->
				<div class="panel-body">
					<div class="list-group">
						<a href="<?php echo base_url("workorders/wo_by_state/0/" . date("Y")); ?>" class="list-group-item">
							<p class="text-danger"><i class="fa fa-thumb-tack fa-fw"></i><strong> On field</strong>
								<span class="pull-right text-muted small"><em><?php echo $noOnfield; ?></em>
								</span>
							</p>
						</a>
						<a href="<?php echo base_url("workorders/wo_by_state/1/" . date("Y")); ?>" class="list-group-item">
							<p class="text-warning"><i class="fa fa-refresh fa-fw"></i><strong> In Progress</strong>
								<span class="pull-right text-muted small"><em><?php echo $noProgress; ?></em>
								</span>
							</p>
						</a>
						<a href="<?php echo base_url("workorders/wo_by_state/2/" . date("Y")); ?>" class="list-group-item">
							<p class="text-primary"><i class="fa fa-check fa-fw"></i><strong> Revised</strong>
								<span class="pull-right text-muted small"><em><?php echo $noRevised; ?></em>
								</span>
							</p>
						</a>
						<a href="<?php echo base_url("workorders/wo_by_state/3/" . date("Y")); ?>" class="list-group-item">
							<p class="text-success"><i class="fa fa-envelope-o  fa-fw"></i><strong> Send to the client</strong>
								<span class="pull-right text-muted small"><em><?php echo $noSend; ?></em>
								</span>
							</p>
						</a>
						<a href="<?php echo base_url("workorders/wo_by_state/4/" . date("Y")); ?>" class="list-group-item">
							<p class="text-danger"><i class="fa fa-power-off fa-fw"></i><strong> Closed</strong>
								<span class="pull-right text-muted small"><em><?php echo $noClosed; ?></em>
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

	</div>
	<!-- /.row -->
	
	<!-- /.row -->
	<div class="row">
		<div class="col-lg-12">
			<div class="panel panel-info">
				<div class="panel-heading">
					<i class="fa fa-briefcase"></i> JOBS INFO
				</div>
				<div class="panel-body">

				<?php
					if($jobList){
				?>				
					<table width="100%" class="table table-striped table-bordered table-hover" id="dataTables">
						<thead>
							<tr>
								<th class="text-center">Job Code/Name</th>
								<th class="text-center">Numbers of W.O.</th>
								<th class="text-center">Numbers of Personal Hours</th>
								<th class="text-center">Personal Income</th>
								<th class="text-center">Material Income</th>
								<th class="text-center">Equipment Income</th>
								<th class="text-center">Subcontractor Income</th>
								<th class="text-center">Total Income</th>
								<th class="text-center">Download</th>
							</tr>
						</thead>
						<tbody>							
						<?php						
                            $ci = &get_instance();
                            $ci->load->model("workorders_model");
							
							foreach ($jobList as $lista):
							
									$arrParam = array("idJob" => $lista['id_job']);
									$noWO = $ci->workorders_model->countWorkorders($arrParam);//cuenta registros de Workorders
									
									$hoursPersonal = $ci->workorders_model->countHoursPersonal($arrParam);//cuenta horas de personal
									
									$arrParam = array("idJob" => $lista['id_job'], "table" => "workorder_personal");
									$incomePersonal = $ci->workorders_model->countIncome($arrParam);//cuenta horas de personal
									
									$arrParam = array("idJob" => $lista['id_job'], "table" => "workorder_materials");
									$incomeMaterial = $ci->workorders_model->countIncome($arrParam);//cuenta horas de personal
									
									$arrParam = array("idJob" => $lista['id_job'], "table" => "workorder_equipment");
									$incomeEquipment = $ci->workorders_model->countIncome($arrParam);//cuenta horas de personal
									
									$arrParam = array("idJob" => $lista['id_job'], "table" => "workorder_ocasional");
									$incomeSubcontractor = $ci->workorders_model->countIncome($arrParam);//cuenta horas de personal
									
									$total = $incomePersonal + $incomeMaterial + $incomeEquipment + $incomeSubcontractor;

									setlocale(LC_MONETARY, 'en_US');
									
									echo "<tr>";
									echo "<td>" . $lista['job_description'] . "</td>";
									echo "<td class='text-center'>" . $noWO . "</td>";
									echo "<td class='text-center'>" . $hoursPersonal . "</td>";
									
									echo "<td class='text-right'>";
									echo money_format('%=(#1.2n', $incomePersonal);
									echo "</td>";
									
									echo "<td class='text-right'>";
									echo money_format('%=(#1.2n', $incomeMaterial);
									echo "</td>";
									
									echo "<td class='text-right'>";
									echo money_format('%=(#1.2n', $incomeEquipment);
									echo "</td>";
									
									echo "<td class='text-right'>";
									echo money_format('%=(#1.2n', $incomeSubcontractor);
									echo "</td>";
									
									echo "<td class='text-right'>";
									echo money_format('%=(#1.2n', $total);
									echo "</td>";
									
									echo "<td class='text-center'>";
						?>
						
<a href='<?php echo base_url('workorders/generaWorkOrderXLS/' . $lista['id_job'] ); ?>' target="_blank"> <img src='<?php echo base_url_images('xls.png'); ?>' ></a>	


						<?php
									echo "</td>";
							endforeach;
						?>
						</tbody>
					</table>
				<?php } ?>
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

<!-- Tables -->
<script>
$(document).ready(function() {
	$('#dataTables').DataTable({
		responsive: true,
		"ordering": true,
		paging: false,
		"info": false
	});
});
</script>