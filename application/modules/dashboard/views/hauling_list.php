<div id="page-wrapper">
	<br>

	<!-- /.row -->
	<div class="row">
		<div class="col-lg-12">
			<div class="panel panel-warning">
				<div class="panel-heading">
					<a class="btn btn-warning btn-xs" href=" <?php echo base_url().'dashboard'; ?> "><span class="glyphicon glyphicon glyphicon-chevron-left" aria-hidden="true"></span> Go back </a> 
					<i class="fa fa-truck"></i> <strong>LAST HAULING REORDS </strong>
				</div>
				<div class="panel-body">
							
					<a class='btn btn-outline btn-warning btn-block' href='<?php echo base_url('hauling/add_hauling'); ?>'>
							<span class="glyphicon glyphicon-edit" aria-hidden="true"> </span>  Add Hauling
					</a>
					
					<br>
				<?php
					if($infoHauling){
				?>
					<table width="100%" class="table table-striped table-bordered table-hover" id="dataTables">
						<thead>
							<tr>
								<th class='text-center'>#</th>
								<th class='text-center'>Report done by</th>
								<th class='text-center'>Date</th>
								<th class='text-center'>Download</th>
								<th class='text-center'>Hauling done by</th>
								<th class='text-center'>Truck - Unit Number</th>
								<th class='text-center'>Truck Type</th>
								<th class='text-center'>Material Type</th>
								<th class='text-center'>From Site</th>
								<th class='text-center'>To Site</th>
								<th class='text-center'>Payment</th>
								<th class='text-center'>Time In</th>
								<th class='text-center'>Time Out</th>
								<th class='text-center'>View details</th>
							</tr>
						</thead>
						<tbody>							
						<?php
							foreach ($infoHauling as $lista):
								echo "<tr>";
								echo "<td class='text-center'>" . $lista['id_hauling'] . "</td>";
								echo "<td>" . $lista['name'] . "</td>";
								echo "<td class='text-center'>" . $lista['date_issue'] . "</td>";
								echo "<td class='text-center'>";
						?>
<a href='<?php echo base_url('report/generaHaulingPDF/x/x/x/x/' . $lista['id_hauling'] ); ?>' target="_blank"> <img src='<?php echo base_url_images('pdf.png'); ?>' ></a>
						<?php
								echo "</td>";
								echo "<td>" . $lista['company_name'] . "</td>";
								echo "<td>" . $lista['unit_number'] . "</td>";
								echo "<td>" . $lista['truck_type'] . "</td>";
								echo "<td >" . $lista['material'] . "</td>";
								echo "<td >" . $lista['site_from'] . "</td>";
								echo "<td >" . $lista['site_to'] . "</td>";
								echo "<td >" . $lista['payment'] . "</td>";
								echo "<td class='text-center'>" . $lista['time_in'] . "</td>";
								echo "<td class='text-center'>" . $lista['time_out'] . "</td>";
								echo "<td class='text-center'>";
						?>
								<a href="<?php echo base_url('hauling/add_hauling/' . $lista['id_hauling']) ?>">View</a>
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