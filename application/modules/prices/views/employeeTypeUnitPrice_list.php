<script type="text/javascript" src="<?php echo base_url("assets/js/validate/prices/employeeTypeUnitPrice.js"); ?>"></script>

<div id="page-wrapper">
	<br>
	
	<!-- /.row -->
	<div class="row">
		<div class="col-lg-12">
			<div class="panel panel-danger">
				<div class="panel-heading">
					<a class="btn btn-danger btn-xs" href=" <?php echo base_url().'admin/job/1'; ?> "><span class="glyphicon glyphicon glyphicon-chevron-left" aria-hidden="true"></span> Go back </a> 
					<i class="fa fa-flag"></i> <strong>JOB - EMPLOYEE TYPE UNIT PRICE</strong>
				</div>
				<div class="panel-body">
	
					<!-- /.row -->	
					<div class="row">
						<div class="col-lg-12">	
							<div class="alert alert-danger">
								<strong>Job Code/Name: </strong><?php echo $jobInfo[0]['job_description']; ?>

								<br><br>
								<span class="glyphicon glyphicon-alert" aria-hidden="true"></span>
								Load the employee type price for this <strong>Job Code</strong> from the following button.
								<button type="button" id="<?php echo $jobInfo[0]['id_job']; ?>" class='btn btn-danger btn-xs' title="Delete">
										Load Data <i class="fa fa-upload"></i>
								</button>
							</div>
						</div>				
					</div>
					<!-- /.row -->
				
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
					<!--INICIO HAZARDS -->								
					<?php 
						if($employeeTypeUnitPrice){
					?>
					
					<div class="row">
						<div class="col-lg-12">
							<div class="alert alert-success">
								<span class="glyphicon glyphicon-pushpin" aria-hidden="true"></span>
								<strong>Attention: </strong>
								The following table is the unit price list by employee type for this <strong>Job Code/Name</strong>.
							</div>
						</div>
						
					</div>
					
<form  name="employee_type_prices" id="employee_type_prices" method="post" action="<?php echo base_url("prices/update_employee_type_price"); ?>">

					<input type="hidden" id="hddIdJob" name="hddIdJob" value="<?php echo $jobInfo[0]['id_job']; ?>"/>
					
					<table width="100%" class="table table-striped table-bordered table-hover" id="dataTables">
						<thead>
							<tr>
								<th class="text-center">Employee Type</th>
								<th class="text-center">Unit Price
								<button type="submit" class="btn btn-primary btn-xs" id="btnSubmit2" name="btnSubmit2" >
									Update <span class="glyphicon glyphicon-edit" aria-hidden="true">
								</button>
								</th>
							</tr>
						</thead>
						<tbody>							
						<?php
							foreach ($employeeTypeUnitPrice as $lista):
									echo "<tr>";
									echo "<td>" . $lista['employee_type'] . "</td>";
									
									$unitPrice = $lista['job_employee_type_unit_price'];
									$unitPrice = $unitPrice?$unitPrice:0;
									echo "<td class='text-right'>";
						?>
						<input type="hidden" id="price" name="form[id][]" value="<?php echo $lista['id_employee_type_price']; ?>"/>
						<input type="text" id="price" name="form[price][]" class="form-control" placeholder="Unit Price" value="<?php echo $unitPrice; ?>" >
						<?php
									echo "</td>";
									echo "</tr>";

							endforeach;
						?>
						</tbody>
					</table>
					
</form>
					<?php } ?>
					<!--FIN HAZARDS -->
					
					<!-- /.row (nested) -->
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