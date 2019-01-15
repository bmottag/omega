
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
							<a class="btn btn-success" href=" <?php echo base_url().'report/searchByDateRange/heavyInspection'; ?> "><span class="glyphicon glyphicon glyphicon-chevron-left" aria-hidden="true"></span> Go back </a> 
                            <i class="fa fa-search fa-fw"></i> CONTRUCTION EQUIPMENT INSPECTION REPORT
                        </div>
                        <!-- /.panel-heading -->
                        <div class="panel-body">
						<div class="alert alert-info">
							<strong>From Date: </strong><?php echo $from; ?> 
							<strong>To Date: </strong><?php echo $to; ?> 
<?php if($info){ ?>
							<br><strong>Dowloand to: </strong>
							
<a href='<?php echo base_url('report/generaInsectionHeavyPDF/' . $employee . '/' . $vehicleId . '/' . $from . '/' . $to ); ?>' target="_blank">PDF <img src='<?php echo base_url_images('pdf.png'); ?>' ></a>	
				 
<?php } ?>
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
                                        <th>Date of Issue</th>
										<th>Employee</th>
										<th>Type</th>
										<th>Make</th>
										<th>Model</th>
										<th>Unit Number</th>
										<th>Description</th>
										
										<th>Comments</th>
										
                                    </tr>
                                </thead>
                                <tbody>							
								<?php
									$total = 0;
									foreach ($info as $lista):
											switch ($lista['type_level_1']) {
												case 1:
													$type1 = 'Fleet';
													break;
												case 2:
													$type1 = 'Rental';
													break;
												case 99:
													$type1 = 'Other';
													break;
											}
																				
											echo "<tr>";
											echo "<td class='text-center'>" . $lista['date_issue'] . "</td>";
											echo "<td >" . $lista['name'] . "</td>";
											
											echo "<td class='text-center'>" . $type1 . ' - ' . $lista['type_2'] . "</td>";
											echo "<td class='text-center'>" . $lista['make'] . "</td>";
											echo "<td class='text-center'>" . $lista['model'] . "</td>";
											echo "<td class='text-center'>" . $lista['unit_number'] . "</td>";
											echo "<td class='text-center'>" . $lista['description'] . "</td>";

											echo "<td>" . $lista['comments'] . "</td>";
											
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

    <!-- Tables -->
    <script>
    $(document).ready(function() {
        $('#dataTables').DataTable({
            responsive: true
        });
    });
    </script>