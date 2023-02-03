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
							<div class="alert alert-info ">
								<span class="glyphicon glyphicon-exclamation-sign" aria-hidden="true"></span>
									Fire Watch Log Sheet form
							</div>
						</div>
					</div>

					<div class="row">
						<div class="col-lg-12">
							<h3><strong>Facility/Building Address: </strong><?php echo $information[0]["building_address"]; ?></h3>
							<strong>Fire Watch Conducted by: </strong><?php echo $information[0]["conductedby"]; ?><br>
							<strong>Fire Watch Commenced: </strong><?php echo $information[0]["job_description"]; ?><br>
							<?php echo $information[0]["job_description"]; ?>
						</div>
					</div>
					<br>
					<div class="form-group">
						<div class="row" align="center">
							<div style="width:50%;" align="center">
								<button type="button" id="btnSubmit" name="btnSubmit" class="btn btn-primary" >
									Sign-In <span class="glyphicon glyphicon-floppy-disk" aria-hidden="true">
								</button> 
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
								<th class="text-center">Date</th>
								<th >Worker</th>
								<th class="text-center">Phone Number</th>
								<th class="text-center">Sign-In</th>
								<th class="text-center">Sign-Out</th>
							</tr>
						</thead>
						<tbody>							
						<?php
							foreach ($checkinList as $lista):
								$checkOut = $lista['checkout_time'];
								$flag = false;
								if($lista['checkout_time']=="0000-00-00 00:00:00"){
									$checkOut = "<p class='text-danger'><i class='fa fa-refresh fa-fw'></i><b>Still working</b><p>";
									$flag = true;
								}
								
								echo "<tr>";
								echo "<td class='text-center'>" . ucfirst(strftime("%b %d, %G",strtotime($lista['checkin_date'])));
								if($flag){
						?>
								<br>
								<button type="button" class="btn btn-danger btn-xs" data-toggle="modal" data-target="#modal" id="<?php echo $lista['id_checkin']; ?>" >
									Sign-Out <span class="glyphicon glyphicon-edit" aria-hidden="true">
								</button>
						<?php
								}
								echo "</td>";
								echo "<td>" . $lista['first_name'] . " " . $lista['last_name'] . "</td>";
								echo "<td class='text-center'>" . $lista['movil'] . "</td>";
								echo "<td class='text-center'>" . $lista['checkin_time'] . "</td>";
								echo "<td class='text-center'>" . $checkOut . "</td>";
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