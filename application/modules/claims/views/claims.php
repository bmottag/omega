<script type="text/javascript" src="<?php echo base_url("assets/js/validate/claims/search.js"); ?>"></script>
<script>
$(function(){ 
	$(".btn-danger").click(function () {	
			var oID = $(this).attr("id");
            $.ajax ({
                type: 'POST',
				url: base_url + 'claims/cargarModalClaim',
                data: {'idClaim': oID},
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
	
	<!-- /.row -->
	<div class="row">
		<div class="col-lg-3">
			<div class="panel panel-primary">
				<div class="panel-heading">
					<?php $dashboardURL = $this->session->userdata("dashboardURL"); ?>
					<a class="btn btn-primary btn-xs" href="<?php echo base_url($dashboardURL); ?> "><span class="glyphicon glyphicon glyphicon-chevron-left" aria-hidden="true"></span> Dashboard </a> 
					<i class="fa fa-search"></i> SEARCH
				</div>
				<div class="panel-body">

					<form  name="formSearch" id="formSearch" role="form" method="post" class="form-horizontal" >

						<div class="form-group">
							<div class="col-lg-12">
								<p class="text-danger"><span class="glyphicon glyphicon-alert" aria-hidden="true"></span> 
									<strong>Select </strong> at least one option 
								</p>
							</div>
						</div>

						<div class="form-group">
							<div class="col-sm-12">
								<label for="id_job">Job Code/Name:</label>
								<select name="id_job" id="id_job" class="form-control">
									<option value=''>Select...</option>
									<?php for ($i = 0; $i < count($jobs); $i++) { ?>
										<option value="<?php echo $jobs[$i]["id_job"]; ?>" <?php if($_POST && $_POST["id_job"] == $jobs[$i]["id_job"]) { echo "selected"; }  ?>><?php echo $jobs[$i]["job_description"]; ?></option>	
									<?php } ?>
								</select>
							</div>
						</div>

						<div class="form-group">
							<div class="col-sm-12">
								<label for="state">State:</label>
								<select name="state" id="state" class="form-control">
									<option value=''>Seleccione...</option>
									<option value=1 <?php if($_POST && $_POST["state"] == 1) { echo "selected"; }  ?>>New Claim</option>
									<option value=2 <?php if($_POST && $_POST["state"] == 2) { echo "selected"; }  ?>>Send to Client</option>
									<option value=3 <?php if($_POST && $_POST["state"] == 3) { echo "selected"; }  ?>>Hold Back</option>
									<option value=4 <?php if($_POST && $_POST["state"] == 4) { echo "selected"; }  ?>>Short Payment</option>
									<option value=5 <?php if($_POST && $_POST["state"] == 5) { echo "selected"; }  ?>>Paid</option>
								</select>
							</div>
						</div>

						<div class="form-group">	
							<div class="col-sm-12">
								<input type="text" id="id_Claim" name="id_Claim" class="form-control" placeholder="Claim #" value="<?php echo $_POST?$this->input->post('id_Claim'):""; ?>">
							</div>
						</div>
						
						<div class="row"></div><br>
						<div class="form-group">
							<div class="row" align="center">
								<div style="width80%;" align="center">
									
								 <button type="submit" class="btn btn-primary" id='btnSearch' name='btnSearch'><span class="glyphicon glyphicon-search" aria-hidden="true"></span> Search </button>
									
								</div>
							</div>
						</div>
						
					</form>

				</div>
				<!-- /.panel-body -->
			</div>
			<!-- /.panel -->
		</div>
		<!-- /.col-lg-3 -->

		<div class="col-lg-9">
			<div class="panel panel-danger">
				<div class="panel-heading">
					<i class="fa fa-bomb"></i> <strong><?php echo $tituloListado; ?></strong>
				</div>
				<div class="panel-body">
					
					<button type="button" class="btn btn-danger btn-block" data-toggle="modal" data-target="#modal" id="x">
							<span class="glyphicon glyphicon-plus" aria-hidden="true"></span> Add a Claim
					</button>					
					<br>
				<?php 										
					if(!$claimsInfo){ 
						echo '<div class="col-lg-12">
								<p class="text-danger"><span class="glyphicon glyphicon-alert" aria-hidden="true"></span> There are no records in the system.</p>
							</div>';
					}else{
				?>
					<table width="100%" class="table table-striped table-bordered table-hover" id="dataTables">
						<thead>
							<tr>
								<th class='text-center'>Claim #</th>
								<th class='text-center'>Job Code/Name</th>
								<th class='text-center'>User</th>
								<th class='text-center'>Date of Issue</th>
								<th class='text-center'>More information</th>
							</tr>
						</thead>
						<tbody>							
						<?php
							foreach ($claimsInfo as $lista):
							
									switch ($lista['current_state_claim']) {
											case 1:
													$valor = 'New Claim';
													$clase = "text-info";
													$icono = "fa-flag";
													break;
											case 2:
													$valor = 'Send to the client';
													$clase = "text-primary";
													$icono = "fa-share";
													break;
											case 3:
													$valor = 'Hold Back';
													$clase = "text-warning";
													$icono = "fa-bullhorn";
													break;
											case 4:
													$valor = 'Short Payment';
													$clase = "text-danger";
													$icono = "fa-thumbs-o-down";
													break;
											case 5:
													$valor = 'Paid';
													$clase = "text-success";
													$icono = "fa-bomb";
													break;
									}
							
									echo "<tr>";
									echo "<td class='text-center'>";
									echo "<a href='" . base_url('claims/upload_wo/' . $lista['id_claim']) . "'>" . $lista['id_claim'] . "</a>";
									echo '<p class="' . $clase . '"><i class="fa ' . $icono . ' fa-fw"></i>' . $valor . '</p>';
									echo "<a href='" . base_url('claims/upload_wo/' . $lista['id_claim']) . "' class='btn btn-info btn-xs' title='View'>Review Claim</a>";
									echo "</td>";
									echo "<td>" . $lista['job_description'] . "</td>";
									echo "<td>" . $lista['name'] . "</td>";
									echo "<td class='text-center'>" . $lista['date_issue_claim'] . "</td>";
									echo '<td>';
									echo '<strong>Observation:</strong><br>' . $lista['observation_claim'];
									echo '<br><strong>Additional information last message:</strong><br>' . $lista['last_message_claim'];
									echo '</td>';
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

<!--INICIO Modal para adicionar CLAIMS -->
<div class="modal fade text-center" id="modal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">    
	<div class="modal-dialog" role="document">
		<div class="modal-content" id="tablaDatos">

		</div>
	</div>
</div>                       
<!--FIN Modal para adicionar CLAIMS -->

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