<link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>

<script>
$(function(){ 
	$(".btn-service-order").click(function () {
			var oID = $(this).attr("id");
            $.ajax ({
                type: 'POST',
				url: base_url + 'serviceorder/cargarModalServiceOrder',
				data: {"idServiceOrder": oID },
                cache: false,
                success: function (data) {
                    $('#tablaDatos').html(data);
                }
            });
	});	
});
</script>


<div class="panel panel-primary">
	<div class="panel-heading"> 
		<i class="fa fa-filter"></i> <strong>SERVICE ORDER</strong>
	</div>
	<div class="panel-body">
	
		<br>
		<button type="button" class="btn btn-primary btn-block btn-service-order" data-toggle="modal" data-target="#modal" id="x">
				<span class="glyphicon glyphicon-plus" aria-hidden="true"></span> New Service Order
		</button><br>
		
		<br>
	<?php
		if($information){
	?>
		<table width="100%" class="table table-striped table-bordered table-hover" id="dataTables">
			<thead>
				<tr>
					<th>Mechanic</th>
					<th>Date Issue</th>
					<th>Equipment</th>
					<th>Current Hours</th>
					<th>Comments</th>
					<th>Status</th>
					<th>Actions</th>
				</tr>
			</thead>
			<tbody>							
			<?php
				foreach ($information as $lista):
						echo "<tr>";
						echo "<td>" . $lista['mechanic'] . "</td>";
						echo "<td>" . $fecha = date('F j, Y - G:i:s', strtotime($lista['created_at'])) . "</td>";
						echo "<td>" . $lista['unit_description'] . "</td>";
						echo "<td>" . $lista['current_hours'] . " hours</td>";
						echo "<td>" . $lista['comments'] . "</td>";
						echo "<td class='text-center'>";
						echo '<p class="text-' . $lista['status_style'] . '"><i class="fa ' . $lista['status_icon'] . ' fa-fw"></i>' . $lista['status_name'] . '</strong></p>';
						echo "</td>";
						echo "<td class='text-center'>";	
						if($lista['service_status'] != 'closed'){
			?>					
						<button type="button" class="btn btn-primary btn-xs btn-service-order" data-toggle="modal" data-target="#modal" id="<?php echo $lista['id_service_order']; ?>" title="Edit" >
							Edit  <span class="glyphicon glyphicon-edit" aria-hidden="true"> </span>
						</button>
			<?php
						}
						echo "</td>";
						echo "</tr>";
				endforeach;
			?>
			</tbody>
		</table>
		<?php 
			}
		?>
	</div>
</div>

<!--INICIO Modal -->
<div class="modal fade text-center" id="modalSetup" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">    
	<div class="modal-dialog" role="document">
		<div class="modal-content" id="tablaSetup">

		</div>
	</div>
</div>                       
<!--FIN Modal -->

<!--INICIO Modal -->
<div class="modal fade text-center" id="modal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">    
	<div class="modal-dialog" role="document">
		<div class="modal-content" id="tablaDatos">

		</div>
	</div>
</div>                       
<!--FIN Modal -->

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