<div id="page-wrapper">
	<br>

	<!-- /.row -->
	<div class="row">
		<div class="col-lg-12">
			<div class="panel panel-success">
				<div class="panel-heading">
					<a class="btn btn-success btn-xs" href=" <?php echo base_url().'dashboard'; ?> "><span class="glyphicon glyphicon glyphicon-chevron-left" aria-hidden="true"></span> Go back </a> 
					<i class="fa fa-search"></i> <strong>LAST PICKUPS & TRUCKS INSPECTION REORDS</strong>
				</div>
				<div class="panel-body">
							
				<?php
					if($infoDaily){
				?>
					<table width="100%" class="table table-striped table-bordered table-hover" id="dataTables">
						<thead>
							<tr>
								<th class='text-center'>Date & Time</th>
								<th class='text-center'>Download</th>
								<th class='text-center'>Driver Name</th>
								<th class='text-center'>Vehicle Make</th>
								<th class='text-center'>Vehicle Model</th>
								<th class='text-center'>Unit Number</th>
								<th class='text-center'>Description</th>
								<th class='text-center'>Comments</th>
							</tr>
						</thead>
						<tbody>							
						<?php
							foreach ($infoDaily as $lista):
								echo "<tr>";
								echo "<td class='text-center'>" . $lista['date_issue'] . "</td>";
								echo "<td class='text-center'>";
						?>
<a href='<?php echo base_url('report/generaInsectionDailyPDF/x/x/x/x/x/' . $lista['id_inspection_daily'] ); ?>' target="_blank"> <img src='<?php echo base_url_images('pdf.png'); ?>' ></a>
						<?php
								echo "</td>";
								echo "<td>" . $lista['name'] . "</td>";
								echo "<td class='text-center'>" . $lista['make'] . "</td>";
								echo "<td class='text-center'>" . $lista['model'] . "</td>";
								echo "<td class='text-center'>" . $lista['unit_number'] . "</td>";
								echo "<td >" . $lista['description'] . "</td>";
								echo "<td>" . $lista['comments'] . "</td>";
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