<div id="page-wrapper">
	<br>
	<div class="row">
		<div class="col-md-12">
			<div class="panel panel-primary">
				<div class="panel-heading">
					<h4 class="list-group-item-heading">
					<i class="fa fa-user fa-fw"></i> USER PROFILE
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
					<i class="fa fa-user"></i> USER PROFILE
				</div>
				<div class="panel-body">
				
					<div class="alert alert-info">
						Upload your photo
					</div>				
					
					<table width="100%" class="table table-striped table-bordered table-hover" id="dataTables">
						<thead>
							<tr>
								<th>Photo</th>
								<th>Name</th>
								<th>Date of birth</th>
								<th>Movil number</th>
								<th>Email</th>
							</tr>
						</thead>
						<tbody>							
						<?php
								echo "<tr>";
								echo "<td class='text-center'>";
								
								if($UserInfo[0]["photo"])
								{ 
						?>
<img src="<?php echo base_url($UserInfo[0]["photo"]); ?>" class="img-rounded" alt="Employee Photo" width="50" height="50" />
						<?php 
								} 

								echo "</td>";
								echo "<td>" . $this->session->userdata("name") . "</td>";
								echo "<td class='text-center'>" . $UserInfo[0]["birthdate"] . "</td>";
								
$movil = $UserInfo[0]["movil"];
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
								echo "<td class='text-right'>" . $UserInfo[0]["email"] . "</td>";
								echo "</tr>";
						?>
						</tbody>
					</table>

					<form  name="form" id="form" class="form-horizontal" method="post" enctype="multipart/form-data" action="<?php echo base_url("employee/do_upload"); ?>">
					
						<div class="form-group">
							<label class="col-sm-4 control-label" for="hddTask">Photo</label>
							<div class="col-sm-5">
								 <input type="file" name="userfile" />
							</div>
						</div>
						
						<div class="form-group">
							<div class="row" align="center">
								<div style="width:50%;" align="center">
									<input type="submit" id="btnSubmit" name="btnSubmit" value="Submit" class="btn btn-primary"/>
								</div>
							</div>
						</div>
						
                    <?php if($error){ ?>
                    <div class="alert alert-danger">
                        <?php 
                            echo "<strong>Error :</strong>";
                            pr($error); 
                        ?><!--$ERROR MUESTRA LOS ERRORES QUE PUEDAN HABER AL SUBIR LA IMAGEN-->
                    </div>
                    <?php } ?>
                    <div class="alert alert-danger">
                            <strong>Note :</strong><br>
                            Allowed format: gif - jpg - png<br>
                            Maximum size: 3000 KB<br>
                            Maximum width: 2024 pixels<br>
                            Maximum height: 2008 pixels<br>

                    </div>
						
					</form>
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