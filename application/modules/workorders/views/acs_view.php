<div id="page-wrapper">
	<br>
	<div class="row">

		<div class="col-lg-6">
			<div class="panel panel-dark">
				<div class="panel-heading">
					<i class="fa fa-edit"></i> <strong>Accounting Control Sheet (ACS) - GENERAL INFORMATION</strong>
				</div>
				<div class="panel-body">
					<strong>ACS #: </strong><?php echo $acs_info[0]["id_acs"]; ?><br>
					<strong>ACS Date: </strong><?php echo $acs_info[0]["date"]; ?><br>
					<strong>Job Code/Name: </strong><br><?php echo $acs_info[0]["job_description"]; ?><br>
					<strong>Foreman: </strong><?php echo $acs_info[0]["foreman_name_wo"]; ?><br>
					<strong>Work Done: </strong><br><?php echo $acs_info[0]["observation"]; ?>
				</div>
			</div>
		</div>	
		
		<div class="col-lg-6">

		</div>
			
	</div>

<!--INICIO PERSONAL -->
<?php 
	if($acsPersonal){
?>
	<div class="row">
		<div class="col-lg-12">				
			<div class="panel panel-dark">
				<div class="panel-heading">
					<strong>PERSONAL</strong>
				</div>
				<div class="panel-body">
				
					<table class="table table-bordered table-striped table-hover table-condensed">
						<tr class="dark">
							<td><p class="text-center"><strong>Employee Name</strong></p></td>
							<td><p class="text-center"><strong>Employee Type</strong></p></td>
							<td><p class="text-center"><strong>Work Done</strong></p></td>
							<td><p class="text-center"><strong>Hours</strong></p></td>
						</tr>
						<?php
							foreach ($acsPersonal as $data):
								echo "<tr>";
								echo "<td ><small>" . $data['name'] . "</small></td>";
								echo "<td ><small>" . $data['employee_type'] . "</small></td>";
								echo "<td ><small>" . $data['description'] . "</small></td>";
								echo "<td class='text-center'><small>" . $data['hours'] . "</small></td>";
								echo "</tr>";
							endforeach;
						?>
					</table>
			
				</div>
			</div>
		</div>
	</div>
<?php } ?>
<!--FIN PERSONAL -->

<!--INICIO MATERIALS -->
<?php 
	if($acsMaterials){
?>
	<div class="row">
		<div class="col-lg-12">				
			<div class="panel panel-dark">
				<div class="panel-heading">
					<b>MATERIALS</b>
				</div>
				<div class="panel-body">

					<table class="table table-bordered table-striped table-hover table-condensed">
						<tr class="dark">
							<td><p class="text-center"><strong>Info. Material</strong></p></td>
							<td><p class="text-center"><strong>Description</strong></p></td>
							<td><p class="text-center"><strong>Quantity</strong></p></td>
							<td><p class="text-center"><strong>Unit</strong></p></td>
						</tr>
						<?php
							foreach ($acsMaterials as $data):
								echo "<tr>";
								echo "<td ><small><strong>Material</strong><br>" . $data['material'] . "</small></td>";
								echo "<td ><small>" . $data['description'] . "</small></td>";
								echo "<td class='text-center'><small>" . $data['quantity'] . "</small></td>";
								echo "<td><small>" . $data['unit'] . "</small></td>";
								echo "</tr>";
							endforeach;
						?>
					</table>

				</div>
			</div>
		</div>
	</div>
<?php } ?>
<!--FIN MATERIALS -->

<!--INICIO EQUIPMENT -->
<?php 
	if($acsEquipment){
?>
	<!-- /.row -->
	<div class="row">
		<div class="col-lg-12">				
			<div class="panel panel-dark">
				<div class="panel-heading">
					<b>EQUIPMENT</b>
				</div>
				<div class="panel-body">
					<table class="table table-bordered table-striped table-hover table-condensed">
						<tr class="dark">
							<td><p class="text-center"><strong>Info. Equipment</strong></p></td>
							<td><p class="text-center"><strong>Description</strong></p></td>
							<td><p class="text-center"><strong>Hours</strong></p></td>
							<td><p class="text-center"><strong>Quantity</strong></p></td>
						</tr>
						<?php
							foreach ($acsEquipment as $data):
								echo "<tr>";
								echo "<td ><small><strong>Type</strong><br>" . $data['type_2'] . "</small>";
								//si es tipo miscellaneous -> 8, entonces la description es diferente
								if($data['fk_id_type_2'] == 8){
									$equipment = $data['miscellaneous'] . " - " . $data['other'];
								}else{
									$equipment = $data['unit_number'] . " - " . $data['make'] . " - " . $data['model'];
								}
								
								echo "<br><small><strong>Equipment</strong><br>" . $equipment . "</small>";
								echo "<br><small><strong>Operated by</strong><br>" . $data['operatedby'] . "</small>";
								echo "</td>";
								echo "<td ><small>" . $data['description'] . "</small></td>";
								echo "<td class='text-center'><small>" . $data['hours'] . "</small></td>";
								echo "<td class='text-center'><small>" . $data['quantity'] . "</small></td>";
								echo "</tr>";
							endforeach;
						?>
					</table>
				</div>
			</div>
		</div>
	</div>
<?php } ?>
<!--FIN EQUIPMENT -->

<!--INICIO OCASIONAL SUBCONTRACTOR -->
<?php 
	if($acsOcasional){
?>
	<div class="row">
		<div class="col-lg-12">				
			<div class="panel panel-dark">
				<div class="panel-heading">
					<b>OCASIONAL SUBCONTRACTOR</b>
				</div>
				<div class="panel-body">

					<table class="table table-bordered table-striped table-hover table-condensed">
						<tr class="dark">
							<td><p class="text-center"><strong>Info. Subcontractor</strong></p></td>
							<td><p class="text-center"><strong>Description</strong></p></td>
							<td><p class="text-center"><strong>Quantity</strong></p></td>
							<td><p class="text-center"><strong>Unit</strong></p></td>
							<td><p class="text-center"><strong>Hours</strong></p></td>
						</tr>
						<?php
							foreach ($acsOcasional as $data):
								echo "<tr>";					
								echo "<td ><small><strong>Company</strong><br>" . $data['company_name'] . "</small>";
								echo "<br><small><strong>Equipment</strong><br>" . $data['equipment'] . "</small>";
								echo "<br><small><strong>Contact</strong><br>" . $data['contact'] . "</small></td>";
								echo "<td ><small>" . $data['description'] . "</small></td>";
								echo "<td class='text-center'><small>" . $data['quantity'] . "</small></td>";
								echo "<td ><small>" . $data['unit'] . "</small></td>";
								echo "<td class='text-center'><small>" . $data['hours'] . "</small></td>";
								echo "</tr>";								
							endforeach;
						?>
					</table>

				</div>
			</div>
		</div>
	</div>
<?php } ?>
<!--FIN OCASIONAL SUBCONTRACTOR -->
</div>