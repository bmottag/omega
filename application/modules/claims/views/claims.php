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
		<div class="col-lg-12">
			<div class="panel panel-danger">
				<div class="panel-heading">
					<i class="fa fa-bomb"></i> <strong>CLAIMS</strong>
				</div>
				<div class="panel-body">
					
					<button type="button" class="btn btn-danger btn-block" data-toggle="modal" data-target="#modal" id="x">
							<span class="glyphicon glyphicon-plus" aria-hidden="true"></span> Add a Claim
					</button>
					
					<br>
				<?php
					if($claimsInfo){
				?>
					<table width="100%" class="table table-striped table-bordered table-hover" id="dataTables">
						<thead>
							<tr>
								<th class='text-center'>Claim #</th>
								<th class='text-center'>Job Code/Name</th>
								<th class='text-center'>User</th>
								<th class='text-center'>Date of Issue</th>
								<th class='text-center'>Observation</th>
							</tr>
						</thead>
						<tbody>							
						<?php
							foreach ($claimsInfo as $lista):
							
									switch ($lista['state_claim']) {
											case 1:
													$valor = 'New';
													$clase = "text-warning";
													$icono = "fa-refresh";
													break;
											case 2:
													$valor = 'Send to the client';
													$clase = "text-primary";
													$icono = "fa-check";
													break;
											case 3:
													$valor = 'Hold Back';
													$clase = "text-success";
													$icono = "fa-envelope-o";
													break;
											case 4:
													$valor = 'Paid';
													$clase = "text-success";
													$icono = "fa-envelope-o";
													break;
									}
							
									echo "<tr>";
									echo "<td class='text-center'>";
									echo "<a href='" . base_url('claims/upload_wo/' . $lista['id_claim']) . "'>" . $lista['id_claim'];
									echo '<p class="' . $clase . '"><i class="fa ' . $icono . ' fa-fw"></i>' . $valor . '</p>';
									echo "<strong>Last Message:</strong><br>" . $lista['last_message_claim'];
									echo "</a></td>";
									echo "<td>" . $lista['job_description'] . "</td>";
									echo "<td>" . $lista['name'] . "</td>";
									echo "<td class='text-center'>" . $lista['date_issue_claim'] . "</td>";
									echo "<td>" . $lista['observation_claim'] . "</td>";
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