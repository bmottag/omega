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
						<i class="fa fa-bar-chart-o fa-fw"></i> REPORT CENTER
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
					<i class="fa fa-clock-o fa-fw"></i> PAYROLL INFO
				</div>
				<!-- /.panel-heading -->
				<div class="panel-body">
				
<?php
$retornoExito = $this->session->flashdata('retornoExito');
if ($retornoExito) {
    ?>
    <div class="row">
		<div class="col-lg-12">	
			<div class="alert alert-success ">
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
								<th class='text-center'>Date & Time</th>
								<th class='text-center'>Job</th>
								<th class='text-center'>Address</th>
								<th class='text-center'>Task Description</th>
								<th class='text-center'>Observation</th>
								<th class='text-center'>Working Hours</th>
								<th class='text-center'>Total Hours</th>
							</tr>
						</thead>
						<tbody>							
						<?php
							$total = 0;
							foreach ($info as $lista):
								echo "<tr>";
								echo "<td class='text-left'>" . $lista['name'] . "</td>";
								
								echo "<td><strong>Start:</strong><br>" . $lista['start'] . "<br><strong>Finish:</strong><br>" . $lista['finish'] . "<br>";
								
/**
 * Opcion de editar horas para  SUPER ADMIN
 */
	$userRol = $this->session->rol;
	if($userRol==99 || $userRol==3){
		//si no se ahn pagado entonces se pueden editar
		if($lista['period_status']==1){

						?>
								<button type="button" class="btn btn-info btn-xs" data-toggle="modal" data-target="#modal" id="<?php echo $lista['id_task']; ?>" >
									Edit Hours <span class="glyphicon glyphicon-edit" aria-hidden="true">
								</button>									
						<?php
		}else{
						?>
								<div class="alert alert-danger">
									<span class="glyphicon glyphicon-exclamation-sign" aria-hidden="true"></span> These hours have already been paid, they cannot be edited.
								</div>
						<?php			
		}
	}
								echo "</td>";
								
								echo "<td><strong>Start:</strong><br>" . $lista['job_start'] . "<br><strong>Finish:</strong><br>" . $lista['job_finish'] . "</td>";
								
								echo "<td><strong>Start:</strong><br>" . $lista['address_start'] . "<br><strong>Finish:</strong><br>" . $lista['address_finish'] . "</td>";
								
								echo "<td class='text-left'>" . $lista['task_description'] . "</td>";
								echo "<td class='text-left'>" . $lista['observation'] . "</td>";
								echo "<td class='text-right'>" . $lista['working_hours'] . "</td>";
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