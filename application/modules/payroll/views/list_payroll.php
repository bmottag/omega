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
										<th class='text-center'>Working Hours</th>
										<th class='text-center'>Regular Hours</th>
										<th class='text-center'>Overtime Hours</th>
									</tr>
								</thead>
								<tbody>							
								<?php
									if($infoPayrollUser1)
									{
										echo "<tr><td class='text-center' colspan='6'>";
										echo "<p class='text-danger'><b>First Weak: " . $infoPayrollUser1[0]["period_weak"] . "</b></p>";
										echo "</td></tr>";
										$total = 0;
										$totalRegular = 0;
										$totalOvertime = 0;
										foreach ($infoPayrollUser1 as $lista):
											echo "<tr>";							
											echo "<td class='text-center'>" . $lista['start'] . "</td>";
											echo "<td class='text-center'>" . $lista['finish'] . "</td>";
											echo "<td class='text-right'>" . $lista['working_hours'] . "</td>";
											echo "<td class='text-right'>" . $lista['regular_hours'] . "</td>";
											echo "<td class='text-right'>" . $lista['overtime_hours'] . "</td>";
											$total = $lista['working_hours'] + $total;
											$totalRegular = $lista['regular_hours'] + $totalRegular;
											$totalOvertime = $lista['overtime_hours'] + $totalOvertime;
											echo "</tr>";
										endforeach;
											echo "<tr><td></td>";
											echo "<td class='text-right'><strong>Total per weak:</strong></td>";
											echo "<td class='text-right'><strong>" . $total . "</strong></td>";
											echo "<td class='text-right'><strong>" . $totalRegular . "</strong></td>";
											echo "<td class='text-right'><strong>" . $totalOvertime . "</strong></td>";
											echo "</tr>";
											echo "<tr><td colspan='5'><br></td></tr>";
									}
									if($infoPayrollUser2)
									{
										echo "<tr><td class='text-center' colspan='6'>";
										echo "<p class='text-danger'><b>Second Weak: " . $infoPayrollUser2[0]["period_weak"] . "</b></p>";
										echo "</td></tr>";
										$total = 0;
										$totalRegular = 0;
										$totalOvertime = 0;
										foreach ($infoPayrollUser2 as $lista):
											echo "<tr>";							
											echo "<td class='text-center'>" . $lista['start'] . "</td>";
											echo "<td class='text-center'>" . $lista['finish'] . "</td>";
											echo "<td class='text-right'>" . $lista['working_hours'] . "</td>";
											echo "<td class='text-right'>" . $lista['regular_hours'] . "</td>";
											echo "<td class='text-right'>" . $lista['overtime_hours'] . "</td>";
											$total = $lista['working_hours'] + $total;
											$totalRegular = $lista['regular_hours'] + $totalRegular;
											$totalOvertime = $lista['overtime_hours'] + $totalOvertime;
											echo "</tr>";
										endforeach;
											echo "<tr><td></td>";
											echo "<td class='text-right'><strong>Total per weak:</strong></td>";
											echo "<td class='text-right'><strong>" . $total . "</strong></td>";
											echo "<td class='text-right'><strong>" . $totalRegular . "</strong></td>";
											echo "<td class='text-right'><strong>" . $totalOvertime . "</strong></td>";
											echo "</tr>";
									}
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