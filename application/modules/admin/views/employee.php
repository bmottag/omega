<link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>

<script>
$(function(){ 
	$(".btn-success").click(function () {	
			var oID = $(this).attr("id");
            $.ajax ({
                type: 'POST',
				url: base_url + '/admin/cargarModalEmployee',
                data: {'idEmployee': oID},
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
	<div class="row">
		<div class="col-md-12">
			<div class="panel panel-primary">
				<div class="panel-heading">
					<h4 class="list-group-item-heading">
					<i class="fa fa-gear fa-fw"></i> SETTINGS - EMPLOYEE
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
					<i class="fa fa-users"></i> EMPLOYEE LIST
				</div>
				<div class="panel-body">
				
					<ul class="nav nav-pills">
						<li <?php if($state == 1){ echo "class='active'";} ?>><a href="<?php echo base_url("admin/employee/1"); ?>">List of active employees</a>
						</li>
						<li <?php if($state == 2){ echo "class='active'";} ?>><a href="<?php echo base_url("admin/employee/2"); ?>">List of inactive employees</a>
						</li>
					</ul>
					<br>	

<?php
	//DESHABILITAR EDICION
	$deshabilitar = '';
	$userRol = $this->session->rol;
	
	if($userRol != 99){
		$deshabilitar = 'disabled';
	}
?>
				<?php if(!$deshabilitar){ ?>
					<button type="button" class="btn btn-success btn-block" data-toggle="modal" data-target="#modal" id="x">
							<span class="glyphicon glyphicon-plus" aria-hidden="true"></span> Add an Employee
					</button><br>
				<?php } ?>
					
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
					<table width="100%" class="table table-striped table-bordered table-hover" id="dataTables">
						<thead>
							<tr>
								<th class="text-center">ID</th>
								<th class="text-center">Firstname</th>
								<th class="text-center">Lastname</th>
								<th class="text-center">User</th>
								<th class="text-center">Movil</th>
								<th class="text-center">Rol</th>
								<th class="text-center">State</th>
								
								<?php if(!$deshabilitar){ ?>
								<th class="text-center">Password</th>
								<?php } ?>
								
								<th class="text-center">Email</th>
								<th class="text-center">Date of birth</th>
								<th class="text-center">Social insurance Number</th>
								<th class="text-center">Health number</th>
								<th class="text-center">Address</th>
							</tr>
						</thead>
						<tbody>							
						<?php
							foreach ($info as $lista):
									echo "<tr>";
									echo "<td>" . $lista['id_user'] . "</td>";
									echo "<td>" . $lista['first_name'];
				
									if(!$deshabilitar){ 					
						?>
									<br>
									<button type="button" class="btn btn-success btn-xs" data-toggle="modal" data-target="#modal" id="<?php echo $lista['id_user']; ?>" >
										Edit <span class="glyphicon glyphicon-edit" aria-hidden="true">
									</button>
						<?php
									}
									
									echo "</td>";
									echo "<td>" . $lista['last_name'] . "</td>";
									echo "<td class='text-center'>" . $lista['log_user'] . "</td>";
$movil = $lista["movil"];
// Separa en grupos de tres 
$count = strlen($movil); 
	
$num_tlf1 = substr($movil, 0, 3); 
$num_tlf2 = substr($movil, 3, 3); 
$num_tlf3 = substr($movil, 6, 2); 
$num_tlf4 = substr($movil, -2); 

if($count == 10){
	$resultado = "$num_tlf1 $num_tlf2 $num_tlf3 $num_tlf4";  
}else{
	
	$resultado = chunk_split($movil,3," "); 
}
								
									echo "<td class='text-center'>" . $resultado . "</td>";
									echo "<td class='text-center'>";
									echo '<p class="' . $lista['estilos'] . '"><strong>' . $lista['rol_name'] . '</strong></p>';
									echo "</td>";
									
									echo "<td class='text-center'>";
									switch ($lista['state']) {
										case 0:
												$valor = 'New User';
												$clase = "text-primary";
												break;
										case 1:
											$valor = 'Active';
											$clase = "text-success";
											break;
										case 2:
											$valor = 'Inactive';
											$clase = "text-danger";
											break;
									}
									echo '<p class="' . $clase . '"><strong>' . $valor . '</strong></p>';
									echo "</td>";
									
									
									if(!$deshabilitar)
									{ 

									echo "<td class='text-center'>";
							?>
									<!-- 
										Se quita la opcion de resetear la contraseña a 123456
									<a href="<?php echo base_url("admin/resetPassword/" . $lista['id_user']); ?>" class="btn btn-default btn-xs">Reset <span class="glyphicon glyphicon-lock" aria-hidden="true"></a> 
									-->
									<a href="<?php echo base_url("admin/change_password/" . $lista['id_user']); ?>" class="btn btn-default btn-xs">Change password <span class="glyphicon glyphicon-lock" aria-hidden="true"></a>
									
							<?php
									echo "</td>";
									}
									
									echo "<td>" . $lista['email'] . "</td>";
									echo "<td>" . $lista['birthdate'] . "</td>";									
									echo "<td>" . chunk_split($lista['social_insurance'],3," ") . "</td>";
									echo "<td>" . chunk_split($lista['health_number'],3," ") . "</td>";
									echo "<td>" . $lista['address'] . "</td>";
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
		
				
<!--INICIO Modal para adicionar HAZARDS -->
<div class="modal fade text-center" id="modal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">    
	<div class="modal-dialog" role="document">
		<div class="modal-content" id="tablaDatos">

		</div>
	</div>
</div>                       
<!--FIN Modal para adicionar HAZARDS -->

<!-- Tables -->
<script>
$(document).ready(function() {
	$('#dataTables').DataTable({
		responsive: true,
		"order": [[ 1, "asc" ]],
		"pageLength": 50
	});
});
</script>