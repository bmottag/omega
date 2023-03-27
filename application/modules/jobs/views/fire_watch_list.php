<link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>

<script>
$(function(){ 
	$(".btn-outline").click(function () {
			var idJob = $('#hddIdJob').val();	
			var oID = $(this).attr("id");
            $.ajax ({
                type: 'POST',
				url: base_url + 'jobs/cargarModalFireWatch',
				data: {"idJob": idJob, 'idFireWatch': oID },
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
					<i class="fa fa-fire"></i> <strong>FIRE WATCH</strong>
				</div>
				<div class="panel-body">
				
					<div class="alert alert-info">
						<span class="fa fa-briefcase" aria-hidden="true"></span>
						<strong>Job Code/Name: </strong><?php echo $jobInfo[0]['job_description']; ?>
					</div>		

					<!-- campo para enviar el ID de SAFETY al MODAL -->
					<input type="hidden" id="hddIdJob" name="hddIdJob" value="<?php echo $jobInfo[0]['id_job']; ?>"/>
					<button type="button" class="btn btn-outline btn-primary btn-block" data-toggle="modal" data-target="#modal" id="x">
							<span class="glyphicon glyphicon-plus" aria-hidden="true"></span> Add a Fire Watch
					</button><br>
					
					<br>
				<?php
					if($information){
				?>
					<table width="100%" class="table table-striped table-bordered table-hover" id="dataTables">
						<thead>
							<tr>
								<th>#</th>
								<th>Reported by</th>
								<th>Conducted by</th>
								<th>Supervisor</th>
								<th>Facility/Building Address</th>
								<th>System(s) Out of Service</th>
								<th>Systems(s) Restored Online </th>
								<th>Actions</th>
							</tr>
						</thead>
						<tbody>							
						<?php
							foreach ($information as $lista):
									$dateRestored = $lista['date_restored'] == "0000-00-00 00:00:00"?"":$lista['date_restored'];
									echo "<tr>";
									echo "<td class='text-center'>" . $lista['id_job_fire_watch'] . "</td>";
									echo "<td>" . $lista['reportedby'] . "</td>";
									echo "<td>" . $lista['conductedby'] . "</td>";
									echo "<td>" . $lista['supervisor'] . "</td>";
									echo "<td>" . $lista['building_address'] . "</td>";
									echo "<td>" . $lista['date_out'] . "</td>";
									echo "<td>" . $dateRestored. "</td>";
									echo "<td class='text-center'>";									
						?>							
									<button type="button" class="btn btn-primary btn-outline btn-xs" data-toggle="modal" data-target="#modal" id="<?php echo $lista['id_job_fire_watch']; ?>" title="Edit" >
										<i class='fa fa-pencil'></i>
									</button>

									<a class='btn btn-primary btn-xs' href='<?php echo base_url('jobs/fire_watch_checkin/' . $lista['id_job_fire_watch'] ) ?>' title="Log Sheet">
										Log Sheet <span class="glyphicon glyphicon-edit" aria-hidden="true">
									</a>

									<a class='btn btn-primary btn-xs' href='<?php echo base_url('jobs/generaFIREWATCHPDF/' . $lista['id_job_fire_watch'] ) ?>' title="Download Fire Watch Record">
										<span class="fa fa-cloud-download" aria-hidden="true">
									</a>
									<a class='btn btn-primary btn-xs' href='<?php echo base_url('jobs/generaFIREWATCHPDF/' . $lista['id_job_fire_watch'] ) ?>' title="Download Fire Watch Log Sheet">
										<span class="fa fa-cloud-download" aria-hidden="true">
									</a>



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
		"searching": false,
		"info": false
	});
});
</script>