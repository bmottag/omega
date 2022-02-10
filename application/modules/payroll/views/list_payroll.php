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
	<div class="row">
		<div class="col-md-12">
			<div class="panel panel-primary">
				<div class="panel-heading">
					<h4 class="list-group-item-heading">
						<i class="fa fa-bar-chart-o fa-fw"></i> PAYROLL BY PERIOD
					</h4>
				</div>
			</div>
		</div>
		<!-- /.col-lg-12 -->				
	</div>

	<!-- /.row -->
	<div class="row">
		<div class="col-lg-12">
			<div class="panel panel-default">
				<div class="panel-heading">
					<a class="btn btn-success btn-xs" href=" <?php echo base_url().'payroll/payrollSearchForm'; ?> "><span class="glyphicon glyphicon glyphicon-chevron-left" aria-hidden="true"></span> Go back </a> 
					<i class="fa fa-clock-o fa-fw"></i> PAYROLL REPORT
				</div>
				<!-- /.panel-heading -->
				<div class="panel-body">
				<div class="alert alert-info">
					<strong>Period: </strong>
					<strong>To Date: </strong>
					

				</div>
				<?php
					if(!$info){
				?>
					<div class="alert alert-danger">
						No data was found matching your criteria. 
					</div>
				<?php
					}else{
				?>
					<table width="100%" class="table table-striped table-bordered table-hover" id="dataTables">
						<thead>
							<tr>
								<th class='text-center'>Employee Name</th>
								<th class='text-center'>Date & Time - Start</th>
								<th class='text-center'>Date & Time - Finish</th>
								<th class='text-center'>Working Hours</th>
								<th class='text-center'>Regular Hours</th>
								<th class='text-center'>Overtime Hours</th>
								<th class='text-center'>Total Hours</th>
							</tr>
						</thead>
						<tbody>							
						<?php
							$total = 0;
							foreach ($info as $lista):
								echo "<tr>";
								echo "<td class='text-left'>" . $lista['name'] . "</td>";								
								echo "<td class='text-center'>" . $lista['start'] . "</td>";
								echo "<td class='text-center'>" . $lista['finish'] . "</td>";
								echo "<td class='text-right'>" . $lista['working_hours'] . "</td>";
								echo "<td class='text-right'>" . $lista['regular_hours'] . "</td>";
								echo "<td class='text-right'>" . $lista['overtime_hours'] . "</td>";
								$total = $lista['working_hours'] + $total;
								echo "<td class='text-right'><strong>" . $total . "</strong></td>";
								echo "</tr>";
							endforeach;
						?>
						</tbody>
					</table>
				<?php }	?>
				</div>
				<!-- /.panel-body -->
			</div>
			<!-- /.panel -->
		</div>
		<!-- /.col-lg-12 -->
	</div>
	

</div>
<!-- /#page-wrapper -->

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