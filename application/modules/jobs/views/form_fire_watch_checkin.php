<script type="text/javascript" src="<?php echo base_url("assets/js/validate/jobs/fireWatchCheckin.js"); ?>"></script>

<script>
$(function(){ 
	$(".btn-danger").click(function () {	
			var oID = $(this).attr("id");
            $.ajax ({
                type: 'POST',
				url: base_url + 'jobs/cargarModalFireWatchCheckout',
                data: {'idCheckin': oID},
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

<?php if(!$idCheckin){ ?>
	<div class="row">
		<div class="col-lg-12">
			<div class="panel panel-primary">
				<div class="panel-heading">
					<a class="btn btn-primary btn-xs" href=" <?php echo base_url().'jobs/fire_watch/' . $information[0]["fk_id_job"]; ?> "><span class="glyphicon glyphicon glyphicon-chevron-left" aria-hidden="true"></span> Go back </a> 
					<i class="fa fa-tasks"></i><strong> FIRE WATCH LOG SHEET </strong>
				</div>
				<div class="panel-body">
				<form  name="form" id="form" method="post" >
					<input type="hidden" id="idFireWatch" name="idFireWatch" value="<?php echo $information[0]["id_job_fire_watch"]; ?>" >

					<div class="row">
						<div class="col-lg-12">
							<h3><strong>Facility/Building Address: </strong><?php echo $information[0]["building_address"]; ?></h3>
						</div>
						<div class="col-lg-6">
<?php
$mobile = $information[0]["super_number"];
// Separa en grupos de tres 
$count = strlen($mobile); 
	
$num_tlf1 = substr($mobile, 0, 3); 
$num_tlf2 = substr($mobile, 3, 3); 
$num_tlf3 = substr($mobile, 6, 2); 
$num_tlf4 = substr($mobile, -2); 

if($count == 10){
	$resultado = "$num_tlf1 $num_tlf2 $num_tlf3 $num_tlf4";  
}else{
	
	$resultado = chunk_split($mobile,3," "); 
}

?>

							<strong>Conducted by: </strong><?php echo $information[0]["conductedby"]; ?><br>
							<strong>Supervisor’s Name: </strong><?php echo $information[0]["supervisor"]; ?><br>   
							<strong>Supervisor’s Contact Number: </strong><?php echo $resultado; ?> <br>
							<strong>Fire Watch Commenced: </strong><?php echo $information[0]["date_commenced"]; ?><br>
							<strong>Job Code/Name: </strong><?php echo $information[0]["job_description"]; ?><br>
							<strong>Areas/Zones Requiring Fire Watch Patrols: </strong><br>
							<?php echo $information[0]["areas"]; ?>
						</div>
						<div class="col-lg-6">
							<strong>System(s) Out of Service: </strong><?php echo $information[0]["date_out"]; ?><br>
							<strong>System(s) Restored Online: </strong><?php echo $information[0]['date_restored'] == "0000-00-00 00:00:00"?"":$information[0]['date_restored']; ?><br>
							<strong>Systems Shutdown: </strong><br>
							<?php 
								echo $information[0]['fire_alarm']?"":"Fire Alarm System<br>";
								echo $information[0]['fire_sprinkler']?"":"Fire Sprinkler System<br>";
								echo $information[0]['standpipe']?"":"Standpipe System<br>";
								echo $information[0]['fire_pump']?"":"Fire Pump System<br>";
								echo $information[0]['fire_suppression']?"":"Special Fire Suppression System<br>";
								echo $information[0]['other']?"":$information[0]['other'];
							?>
						</div>
					</div>
	
					<br>
					<div class="row">
						<div class="col-lg-12">
							<div class="alert alert-info ">
								<span class="glyphicon glyphicon-exclamation-sign" aria-hidden="true"></span>
									Fire Watch Log Sheet form
									<br>

									<div class="form-group">
										<div class="row" align="center">
											<div style="width:60%;" align="center">
												<div class="form-group text-left">
													<label class="control-label" for="notes">Notes/Observations: </label>
													<textarea id="notes" name="notes" placeholder="Notes/Observations" class="form-control" rows="3"></textarea>
												</div>
											</div>
										</div>
									</div>

									<div class="form-group">
										<div class="row" align="center">
											<div style="width:50%;" align="center">
												<button type="button" id="btnSubmit" name="btnSubmit" class="btn btn-primary" >
													<span class="glyphicon glyphicon-plus" aria-hidden="true"></span> Add Log
												</button> 
											</div>
										</div>
									</div>
							</div>
						</div>
					</div>

					<div class="form-group">
						<div class="row" align="center">
							<div style="width:80%;" align="center">
								<div id="div_load" style="display:none">		
									<div class="progress progress-striped active">
										<div class="progress-bar" role="progressbar" aria-valuenow="45" aria-valuemin="0" aria-valuemax="100" style="width: 45%">
											<span class="sr-only">45% completado</span>
										</div>
									</div>
								</div>
								<div id="div_error" style="display:none">			
									<div class="alert alert-danger"><span class="glyphicon glyphicon-remove" id="span_msj">&nbsp;</span></div>
								</div>
							</div>
						</div>
					</div>	

				</form>	
				</div>
			</div>
		</div>
	</div>
<?php } ?>

	<div class="row">
		<div class="col-lg-12">				
			<div class="panel panel-primary">
				<div class="panel-heading">
					<a class="btn btn-primary btn-xs" href=" <?php echo base_url().'jobs/fire_watch/' . $information[0]["fk_id_job"]; ?> "><span class="glyphicon glyphicon glyphicon-chevron-left" aria-hidden="true"></span> Go back </a> 
					<i class="fa fa-tasks"></i><strong> FIRE WATCH LOG SHEET </strong>
				</div>
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
					if($checkinList){
				?>		
					<table width="100%" class="table table-hover" id="dataTables">
						<thead>
							<tr>
								<th class="text-center">Patrol #</th>
								<th class="text-center">Date</th>
								<th >Worker</th>
								<th class="text-center">Phone Number</th>
								<th class="text-center">Start Time</th>
								<th class="text-center">End Time</th>
								<th >Notes/Observations</th>
							</tr>
						</thead>
						<tbody>							
						<?php
							$i=1;
							foreach ($checkinList as $lista):
								$checkOut = $lista['checkout_time'];
								$flag = false;
								if($lista['checkout_time']=="0000-00-00 00:00:00"){
									$checkOut = "<p class='text-danger'><i class='fa fa-refresh fa-fw'></i><b>Still working</b><p>";
									$flag = true;
								}
								
								echo "<tr>";
								echo "<td class='text-center'>" . $i. "</td>";
								echo "<td class='text-center'>" . ucfirst(strftime("%b %d, %G",strtotime($lista['checkin_date']))) . "</td>";
								echo "<td>" . $lista['first_name'] . " " . $lista['last_name'] . "</td>";
								echo "<td class='text-center'>" . $lista['movil'] . "</td>";
								echo "<td class='text-center'>" . $lista['checkin_time'] . "</td>";
								echo "<td class='text-center'>" . $checkOut;
								if($flag){
								?>
										<br>
										<button type="button" class="btn btn-danger btn-xs" data-toggle="modal" data-target="#modal" id="<?php echo $lista['id_checkin']; ?>" >
											End Time <span class="glyphicon glyphicon-edit" aria-hidden="true">
										</button>
								<?php
								}
								echo "</td>";
								echo "<td >" . $lista['notes'] . "</td>";
								echo "</tr>";
								$i++;
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
	<div class="modal-dialog" role="document">
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
		"searching": false
	});
});
</script>