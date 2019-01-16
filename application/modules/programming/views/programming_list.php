<script type="text/javascript" src="<?php echo base_url("assets/js/validate/programming/programming.js"); ?>"></script>

<div id="page-wrapper">
	<br>

	<!-- /.row -->
	<div class="row">
		<div class="col-lg-12">
			<div class="panel panel-warning">
				<div class="panel-heading">
					<a class="btn btn-warning btn-xs" href=" <?php echo base_url().'dashboard'; ?> "><span class="glyphicon glyphicon glyphicon-chevron-left" aria-hidden="true"></span> Go back </a> 
					<i class="fa fa-truck"></i> <strong>PROGRAMMING LIST </strong>
				</div>
				<div class="panel-body">
							
					<a class='btn btn-outline btn-warning btn-block' href='<?php echo base_url('programming/add_programming'); ?>'>
							<span class="glyphicon glyphicon-edit" aria-hidden="true"> </span>  New Programming
					</a>
					
					<br>
					
<?php
$retornoExito = $this->session->flashdata('retornoExito');
if ($retornoExito) {
    ?>
	<div class="alert alert-success alert-dismissible fade in" role="alert">
		<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span>
		</button>
		<strong>Ok!</strong> <?php echo $retornoExito ?>	
	</div>
    <?php
}

$retornoError = $this->session->flashdata('retornoError');
if ($retornoError) {
    ?>
	<div class="alert alert-danger alert-dismissible fade in" role="alert">
		<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span>
		</button>
		<strong>Error!</strong> <?php echo $retornoError ?>
	</div>	
    <?php
}
?> 
	
				<?php
					if($information){ 
				?>
					<table width="100%" class="table table-striped table-bordered table-hover" id="dataTables">
						<thead>
							<tr>
								<th class='text-center'>Date</th>
								<th class='text-center'>Hour</th>
								<th class='text-center'>Job Code/Name</th>
								<th class='text-center'>Observation</th>
								<th class='text-center'>Links</th>
								<th class='text-center'>Done by</th>
							</tr>
						</thead>
						<tbody>							
						<?php
							foreach ($information as $lista):
								echo "<tr>";
								echo "<td class='text-center'>" . $lista['date_programming'] . "</td>";
								echo "<td class='text-center'>" . $lista['hour_programming'] . "</td>";
								echo "<td class='text-center'>" . $lista['job_description'] . "</td>";
								echo "<td>" . $lista['observation'] . "</td>";
								echo "<td class='text-center'><small>";
								
								
//consultar si la fecha de la programacion es mayor a la fecha actual
$fechaProgramacion = $lista['date_programming'];

$datetime1 = date_create($fechaProgramacion);
$datetime2 = date_create(date('Y-m-d'));

		if($datetime1 < $datetime2) {
				echo '<p class="text-danger"><strong>OVERDUE</strong></p>';
		}else{
			
			if($lista['state'] == 2)
			{
				echo '<p class="text-success"><strong>DONE</strong></p>';
			}elseif($lista['state'] == 1){
				echo '<p class="text-danger"><strong>INCOMPLETE</strong></p>';
			}
?>

			<a href='<?php echo base_url("programming/add_programming/" . $lista['id_programming']); ?>' class='btn btn-info btn-xs' title="Edit"><i class='fa fa-pencil'></i></a>
			
			<a href='<?php echo base_url("programming/add_programming_workers/" . $lista['id_programming']); ?>' class='btn btn-warning btn-xs' title="Workers"><i class='fa fa-users'></i></a>
					
			<button type="button" id="<?php echo $lista['id_programming']; ?>" class='btn btn-danger btn-xs' title="Delete">
					<i class="fa fa-trash-o"></i>
			</button>
			
<?php
		}
?>

			<a href='<?php echo base_url("programming/index/$lista[id_programming]"); ?>' class='btn btn-success btn-xs' title="View"><i class='fa fa-eye'></i></a>


<?php								
								
								echo "</small></td>";
								echo "<td>" . $lista['name'] . "</td>";

								echo "</tr>";
							endforeach;
						?>
						</tbody>
					</table>
				<?php } ?>
				
				
				
<!-- INICIO HISTORICO -->
		<?php
			if($informationWorker){
		?>
					<div class="table-responsive">					
						<table id="dataTablesWorker" class="table table-striped jambo_table bulk_action" cellspacing="0" width="100%">

							<thead>
								<tr class="headings">
									<th class="column-title" colspan="9">-- WORKERS --</th>
								</tr>
								
								<tr class="headings">
									<th class="column-title" style="width: 20%"><small>Name</small></th>
									<th class="column-title text-center"><small>Movil</small></th>
									<th class="column-title text-center"><small>Machine</small></th>
								</tr>
							</thead>

							<tbody>
										
							<?php
								$ci = &get_instance();
								$ci->load->model("general_model");
								
								foreach ($informationWorker as $data):
									echo "<tr>";
									echo "<td ><small>$data[name]</small></td>";
									echo "<td class='text-center'><small>$data[movil]</small></td>";
									echo "<td class='text-center'><small>";


									
									echo "</small></td>";
									echo "</tr>";
								endforeach;
							?>

							</tbody>
						</table>
					</div>
		<?php
			}
		?>
<!-- FIN HISTORICO -->
				
				
				
				
				
				
				
				
				
				
				
				
				
				
				

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