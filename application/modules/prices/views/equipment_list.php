<div id="page-wrapper">
	<br>
	<div class="row">
		<div class="col-md-12">
			<div class="panel panel-primary">
				<div class="panel-heading">
					<h4 class="list-group-item-heading">
					<i class="fa fa-flag-o fa-fw"></i> SETTINGS - EQUIPMENT UNIT PRICES BY HOUR
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
					<i class="fa fa-flag-o"></i> EQUIPMENT UNIT PRICES BY HOUR
				</div>
				<div class="panel-body">

<?php
$retornoExito = $this->session->flashdata('retornoExito');
if ($retornoExito) {
    ?>
	<div class="col-lg-12">	
		<div class="alert alert-success ">
			<span class="glyphicon glyphicon-ok" aria-hidden="true"></span>
			<?php echo $retornoExito ?>		
		</div>
	</div>
    <?php
}

$retornoError = $this->session->flashdata('retornoError');
if ($retornoError) {
    ?>
	<div class="col-lg-12">	
		<div class="alert alert-danger ">
			<span class="glyphicon glyphicon-exclamation-sign" aria-hidden="true"></span>
			<?php echo $retornoError ?>
		</div>
	</div>
    <?php
}
?> 
				<?php
					if($info){
				?>		

<form  name="employee_type_prices" id="employee_type_prices" method="post" action="<?php echo base_url("prices/update_equipment_price"); ?>">
				
					<table width="100%" class="table table-striped table-bordered table-hover" id="dataTables">
						<thead>
							<tr>
								<th class="text-center">Equipment Type</th>
								<th class="text-center">Equipment</th>
								<th class="text-center">Unit Price
								<button type="submit" class="btn btn-primary btn-xs" id="btnSubmit2" name="btnSubmit2" >
									Update <span class="glyphicon glyphicon-edit" aria-hidden="true">
								</button>
								</th>
							</tr>
						</thead>
						<tbody>							
						<?php
							foreach ($info as $lista):
									echo "<tr>";
									echo "<td>" . $lista['type_2'] . "</td>";
									$equipment = $lista['unit_number'] . " - " . $lista['make'] . " - " . $lista['model'];
									echo "<td>" . $equipment . "</td>";
									
									$unitPrice = $lista['equipment_unit_price'];
									$unitPrice = $unitPrice?$unitPrice:0;
									echo "<td class='text-right'>";
						?>
						<input type="hidden" id="price" name="form[id][]" value="<?php echo $lista['id_vehicle']; ?>"/>
						<input type="text" id="price" name="form[price][]" class="form-control" placeholder="Unit Price" value="<?php echo $unitPrice; ?>" >
						<?php
									echo "</td>";
									
							endforeach;
						?>
						</tbody>
					</table>
</form>
					
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
		"pageLength": 100
	});
});
</script>