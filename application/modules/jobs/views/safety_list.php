<div id="page-wrapper">
	<br>

	<!-- /.row -->
	<div class="row">
		<div class="col-lg-12">
			<div class="panel panel-default">
				<div class="panel-heading">
					<a class="btn btn-default btn-xs" href=" <?php echo base_url().'jobs'; ?> "><span class="glyphicon glyphicon glyphicon-chevron-left" aria-hidden="true"></span> Go back </a> 
					<i class="fa fa-life-saver"></i> <strong>FLHA - FIELD LEVEL HAZARD ASSESSMENT</strong>
				</div>
				<div class="panel-body">
				
					<div class="alert alert-info">
						<strong>Job Code/Name: </strong><?php echo $jobInfo[0]['job_description']; ?>
					</div>					
				
<?php 
//verificar si el JOB CODE tiene asignados hazards
$boton = "";
$url = base_url('safety/add_safety/' . $jobInfo[0]['id_job']);
if(!$hazards){
	$boton = "disabled";
	$url = "#";
?>
	<div class="alert alert-danger ">
		<span class="glyphicon glyphicon-exclamation-sign" aria-hidden="true"></span>
		This work does not have hazards.
	</div>
<?php	
}
?>
				
					<a class='btn btn-outline btn-info btn-block' href='<?php echo $url; ?>' <?php echo $boton; ?> >
							<span class="glyphicon glyphicon-edit" aria-hidden="true"> </span>  Add FLHA
					</a>
					
					<br>
				<?php
					if($information){
				?>
					<table width="100%" class="table table-striped table-bordered table-hover" id="dataTables">
						<thead>
							<tr>
								<th>#</th>
								<th>Meeting conducted by</th>
								<th>Date & Time</th>
								<th>Work To Be Done</th>
								<th>Job Code/Name</th>
								<th>Edit</th>
							</tr>
						</thead>
						<tbody>							
						<?php
							foreach ($information as $lista):
								echo "<tr>";
								echo "<td class='text-center'>" . $lista['id_safety'] . "</td>";
								echo "<td>" . $lista['name'] . "</td>";
								echo "<td class='text-center'>" . $lista['date'] . "</td>";
								echo "<td>" . $lista['work'] . "</td>";
								echo "<td >" . $lista['job_description'] . "</td>";
								
								echo "<td class='text-center'>";									
						?>
								<a class='btn btn-success btn-xs' href='<?php echo base_url('safety/upload_info_safety/' . $lista['id_safety'] ) ?>'>
										Edit <span class="glyphicon glyphicon-edit" aria-hidden="true">
								</a>
<br>
<a href='<?php echo base_url('report/generaSafetyPDF/x/x/x/' . $lista['id_safety'] ); ?>' target="_blank"> <img src='<?php echo base_url_images('pdf.png'); ?>' ></a>
								
						<?php
								echo "</td>";
								
								echo "</tr>";
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
			 "ordering": false,
			 paging: false,
			"searching": false,
			"info": false
        });
    });
    </script>