<link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>

<script>
$(function(){ 
			
	$(".btn-info").click(function () {	
			var oID = $(this).attr("id");
            $.ajax ({
                type: 'POST',
				url: base_url + 'payroll/cargarModalHours',
                data: {'idTask': oID},
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

				<?php
					if(!$info){
				?>
	<div class="row">
		<div class="col-lg-12">
			<div class="panel panel-violeta">
				<div class="panel-heading">
					<a class="btn btn-violeta btn-xs" href=" <?php echo base_url().'payroll/payrollSearchForm'; ?> "><span class="glyphicon glyphicon glyphicon-chevron-left" aria-hidden="true"></span> Go back </a> 
					<i class="fa fa-clock-o fa-fw"></i> <b>PAYROLL REPORT - Period: </b> <?php echo $infoPeriod[0]["period"]; ?>
				</div>

				<div class="panel-body">
					<div class="alert alert-danger">
						No data was found matching your criteria. 
					</div>
				</div>
			</div>
		</div>
	</div>
				<?php
					}else{

						foreach ($info as $lista):
							$arrParam = array(
								"idUser" => $lista['fk_id_user'],
								"idPeriod" => $infoPeriod[0]["id_period"],
								"weakNumber" => 1
							);
							$infoPayrollUser1 = $this->general_model->get_task_by_period($arrParam);

							$arrParam = array(
								"idUser" => $lista['fk_id_user'],
								"idPeriod" => $infoPeriod[0]["id_period"],
								"weakNumber" => 2
							);
							$infoPayrollUser2 = $this->general_model->get_task_by_period($arrParam);
				?>
	<div class="row">
		<div class="col-lg-12">
			<div class="panel panel-violeta">
				<div class="panel-heading">
					<a class="btn btn-violeta btn-xs" href=" <?php echo base_url().'payroll/payrollSearchForm'; ?> "><span class="glyphicon glyphicon glyphicon-chevron-left" aria-hidden="true"></span> Go back </a> 
					<i class="fa fa-clock-o fa-fw"></i> <b>PAYROLL REPORT - Period: </b> <?php echo $infoPeriod[0]["period"]; ?>
				</div>

				<div class="panel-body">
							<div class="alert alert-default">
								<h2><i class="fa fa-user"></i> <b>Employee: </b> 
								<?php 
									if($infoPayrollUser1){
										echo $infoPayrollUser1[0]["name"];
									}else{
										echo $infoPayrollUser2[0]["name"]; 
									}
								?></h2>
							</div>
							<table width="100%" class="table table-hover" id="dataTables">
								<thead>
									<tr>
										<th class='text-center'>Date & Time - Start</th>
										<th class='text-center'>Date & Time - Finish</th>
										<th class='text-right'>Worked Hours</th>
										<th class='text-right'>Regular Hours</th>
										<th class='text-right'>Daily Overtime Hours</th>
									</tr>
								</thead>
								<tbody>							
								<?php
									$totalHours1 = 0;
									$totalHours2 = 0;
									$actualRegularHours1 = 0;
									$actualOvertimeHours1 = 0;
									$actualRegularHours2 = 0;
									$actualOvertimeHours2 = 0;
									if($infoPayrollUser1)
									{
										echo "<tr><td class='text-left' colspan='6'>";
										echo "<p class='text-danger'><b>First Weak: " . $infoPayrollUser1[0]["period_weak"] . "</b></p>";
										echo "</td></tr>";
										$totalRegular = 0;
										$totalOvertime = 0;
										$totalRegularWeek = 0;
										$weeklyOvertime = 0;
										foreach ($infoPayrollUser1 as $lista):
											echo "<tr>";							
											echo "<td class='text-center'>" . $lista['start'] . "</td>";
											echo "<td class='text-center'>" . $lista['finish'] . "</td>";
											echo "<td class='text-right'>" . $lista['working_hours'] . "</td>";
											echo "<td class='text-right'>" . $lista['regular_hours'] . "</td>";
											echo "<td class='text-right'>" . $lista['overtime_hours'] . "</td>";
											$totalHours1 = $lista['working_hours'] + $totalHours1;
											$totalRegular = $lista['regular_hours'] + $totalRegular;
											$totalOvertime = $lista['overtime_hours'] + $totalOvertime;
											echo "</tr>";
										endforeach;
											echo "<tr><td></td><td></td>";
											echo "<td class='text-right'><strong>Total weekly hours:<br>" . $totalHours1 . "</strong></td>";
											echo "<td class='text-right'><strong>Total daily  regular hours per week:<br>" . $totalRegular . "</strong></td>";
											echo "<td class='text-right'><strong>Total daily overtime per week:<br>" . $totalOvertime . "</strong></td>";
											echo "</tr>";

											if($totalHours1 > 44){
												$totalRegularWeek = 44;
												$weeklyOvertime = $totalHours1 - $totalRegularWeek;
											}else{
												$totalRegularWeek = $totalHours1;
											}

											echo "<tr><td></td><td></td><td></td>";
											echo "<td class='text-right'><strong>Total regular hours for the week:<br>" . $totalRegularWeek . "</strong></td>";
											echo "<td class='text-right'><strong>Weekly Overtime Hours:<br>" . $weeklyOvertime . "</strong></td>";
											echo "</tr>";

											if($weeklyOvertime > $totalOvertime){
												$actualRegularHours1 = $totalRegularWeek;
												$actualOvertimeHours1 = $weeklyOvertime;
											}else{
												$actualRegularHours1 = $totalRegular;
												$actualOvertimeHours1 = $totalOvertime;
											}
											echo "<tr><td></td><td></td><td></td>";
											echo "<td class='text-right'>";
											echo "<p class='text-primary'><b>Actual regular hours:<br> " . $actualRegularHours1 . "</b></p>";
											echo "</td>";
											echo "<td class='text-right'>";
											echo "<p class='text-primary'><b>Actual Overtime Hours:<br> " . $actualOvertimeHours1 . "</b></p>";
											echo "</td>";
											echo "</tr>";
											echo "<tr><td colspan='5'><br></td></tr>";
									}
									if($infoPayrollUser2)
									{
										echo "<tr><td class='text-left' colspan='6'>";
										echo "<p class='text-danger'><b>Second Weak: " . $infoPayrollUser2[0]["period_weak"] . "</b></p>";
										echo "</td></tr>";
										$totalRegular = 0;
										$totalOvertime = 0;
										$totalRegularWeek = 0;
										$weeklyOvertime = 0;
										foreach ($infoPayrollUser2 as $lista):
											echo "<tr>";							
											echo "<td class='text-center'>" . $lista['start'] . "</td>";
											echo "<td class='text-center'>" . $lista['finish'] . "</td>";
											echo "<td class='text-right'>" . $lista['working_hours'] . "</td>";
											echo "<td class='text-right'>" . $lista['regular_hours'] . "</td>";
											echo "<td class='text-right'>" . $lista['overtime_hours'] . "</td>";
											$totalHours2 = $lista['working_hours'] + $totalHours2;
											$totalRegular = $lista['regular_hours'] + $totalRegular;
											$totalOvertime = $lista['overtime_hours'] + $totalOvertime;
											echo "</tr>";
										endforeach;
											echo "<tr><td></td><td></td>";
											echo "<td class='text-right'><strong>Total weekly hours:<br>" . $totalHours2 . "</strong></td>";
											echo "<td class='text-right'><strong>Total daily  regular hours per week:<br>" . $totalRegular . "</strong></td>";
											echo "<td class='text-right'><strong>Total daily overtime per week:<br>" . $totalOvertime . "</strong></td>";
											echo "</tr>";

											if($totalHours2 > 44){
												$totalRegularWeek = 44;
												$weeklyOvertime = $totalHours2 - $totalRegularWeek;
											}else{
												$totalRegularWeek = $totalHours2;
											}

											echo "<tr><td></td><td></td><td></td>";
											echo "<td class='text-right'><strong>Total regular hours for the week:<br>" . $totalRegularWeek . "</strong></td>";
											echo "<td class='text-right'><strong>Weekly Overtime Hours:<br>" . $weeklyOvertime . "</strong></td>";
											echo "</tr>";

											if($weeklyOvertime > $totalOvertime){
												$actualRegularHours2 = $totalRegularWeek;
												$actualOvertimeHours2 = $weeklyOvertime;
											}else{
												$actualRegularHours2 = $totalRegular;
												$actualOvertimeHours2 = $totalOvertime;
											}
											echo "<tr><td></td><td></td><td></td>";
											echo "<td class='text-right'>";
											echo "<p class='text-primary'><b>Actual regular hours:<br> " . $actualRegularHours2 . "</b></p>";
											echo "</td>";
											echo "<td class='text-right'>";
											echo "<p class='text-primary'><b>Actual Overtime Hours:<br> " . $actualOvertimeHours2 . "</b></p>";
											echo "</td>";
											echo "</tr>";
											echo "<tr><td colspan='5'><br></td></tr>";
									}
											$totalWorked = $totalHours1 + $totalHours2;
											$totalRegularHours = $actualRegularHours1 + $actualRegularHours2;
											$totalOvertimeHours = $actualOvertimeHours1 + $actualOvertimeHours2;

											echo "<tr class='danger text-danger'><td></td>";
											echo "<td class='text-right'><strong>CUT-OFF:</strong></td>";
											echo "<td class='text-right'><strong>Total worked hours:<br>" . $totalWorked . "</strong></td>";
											echo "<td class='text-right'><strong>Total regular hours:<br>" . $totalRegularHours . "</strong></td>";
											echo "<td class='text-right'><strong>Total overtime hours:<br>" . $totalOvertimeHours . "</strong></td>";
											echo "</tr>";
								?>
								</tbody>
							</table>
				</div>
			</div>
		</div>
	</div>

				<?php
						endforeach;
				 	}	
				?>
</div>


<!--INICIO Modal cambio de hora-->
<div class="modal fade text-center" id="modal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">    
	<div class="modal-dialog" role="document">
		<div class="modal-content" id="tablaDatos">

		</div>
	</div>
</div>                       
<!--FIN Modal-->

<!-- Tables -->
<script>
$(document).ready(function() {
	$('#dataTables').DataTable({
		responsive: true,
		"ordering": false,
		"pageLength": 50
	});
});
</script>