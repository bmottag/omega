<script>
$(function(){
	$(".btn-violeta").click(function () {
		var oID = $(this).attr("id");
        $.ajax ({
            type: 'POST',
			url: base_url + 'ordentrabajo/cargarModalOrdenTrabajo',
			data: {'idCompuesto': oID, 'tipoMantenimiento': 2},
            cache: false,
            success: function (data) {
                $('#tablaDatos').html(data);
            }
        });
	});
});
</script>

<div class="panel panel-info">
    <div class="panel-heading">
        <i class="fa fa-wrench"></i> <strong>PREVENTIVE MAINTENANCE</strong>
        <div class="pull-right">
            <div class="btn-group">
                <button type="button" class="btn btn-info btn-xs" data-toggle="modal" data-target="#modalMantenimiento" id="x">
                        <span class="glyphicon glyphicon-plus" aria-hidden="true"></span> Add Preventive Maintenance
                </button>
            </div>
        </div>
    </div>
    <div class="panel-body">

<?php
$retornoExito = $this->session->flashdata('retornoExito');
if ($retornoExito) {
?>
<div class="alert alert-success ">
<span class="glyphicon glyphicon-ok" aria-hidden="true"></span>
<?php echo $retornoExito ?>		
</div>
<?php
}
$retornoError = $this->session->flashdata('retornoError');
if ($retornoError) {
?>
<div class="alert alert-danger ">
<span class="glyphicon glyphicon-exclamation-sign" aria-hidden="true"></span>
<?php echo $retornoError ?>
</div>
<?php
}
?> 
        <?php 										
            if(!$infoPreventiveMaintenance){ 
                echo '<div class="col-lg-12">
                        <p class="text-danger"><span class="glyphicon glyphicon-alert" aria-hidden="true"></span> There are no records in the system.</p>
                    </div>';
            } else {
        ?>
        <table width="100%" class="table table-striped table-bordered table-hover" id="dataPreventiveMaintenance">
            <thead>
                <tr>
                    <th class="text-center"><small>Maintenance Type</small></th>
                    <th class="text-center"><small>Description</small></th>
                    <th class="text-center"><small>Next Hours/Kilometers maintenance </small></th>
                    <th class="text-center"><small>Next date maintenance  </small></th>
                    <th class="text-center"><small>Service Order</small></th>
                </tr>
            </thead>
            <tbody>							
            <?php
                foreach ($infoPreventiveMaintenance as $lista):
                    $nextHpursMaintenance = $lista['next_hours_maintenance'] == 0?"":number_format($lista['next_hours_maintenance']);
                    $nextDateMaintenance = $lista['next_date_maintenance'] == "0000-00-00"?"":date('F j, Y', strtotime($lista['next_date_maintenance']));
                    echo "<tr>";
                    echo "<td><small>" . $lista['maintenance_type'] . "</small></td>";
                    echo "<td><small>" . $lista['maintenance_description'] . "</small></td>";
                    echo "<td class='text-right'><small>" . $nextHpursMaintenance. "</small></td>";
                    echo "<td class='text-right'><small>" . $nextDateMaintenance . "</small></td>";
                    echo "<td class='text-center'>";
                    ?>
                    <button type="button" class="btn btn-violeta btn-xs" data-toggle="modal" data-target="#modal" id="sdfasdf" >
                        Crear O.T. <span class="glyphicon glyphicon-briefcase" aria-hidden="true">
                    </button>
                    <?php

                    echo "</td>";
                    echo "</tr>";
                endforeach;
            ?>
            </tbody>
        </table>
    <?php } ?>
    </div>
</div>

<div class="modal fade text-center" id="modal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">    
	<div class="modal-dialog" role="document">
		<div class="modal-content" id="tablaDatos">
		</div>
	</div>
</div>

<!--INICIO Modal para adicionar MANTENIMIENTO -->
<div class="modal fade text-center" id="modalMantenimiento" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">    
	<div class="modal-dialog" role="document">
		<div class="modal-content" id="tablaDatos">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
				<h4 class="modal-title" id="exampleModalLabel">Adicionar Mantenimiento Preventivo</h4>
			</div>

			<div class="modal-body">
				<form name="formMantenimiento" id="formMantenimiento" role="form" method="post" action="<?php echo base_url("mantenimiento/guardar_un_mantenimiento_preventivo") ?>" >
					<input type="hidden" id="hddIdEquipo" name="hddIdEquipo" value="<?php echo $info[0]['id_equipo']; ?>"/>
					
					<div class="form-group text-left">
						<label class="control-label" for="mantenimiento">Mantenimiento Preventivo</label>
						<select name="mantenimiento" id="mantenimiento" class="form-control" required >
							<option value=''>Select...</option>
							<?php for ($i = 0; $i < count($infoPreventivo); $i++) { ?>
								<option value="<?php echo $infoPreventivo[$i]["id_preventivo_plantilla"]; ?>" ><?php echo $infoPreventivo[$i]["descripcion"] . '. ---> Cada: ' . number_format($infoPreventivo[$i]["frecuencia"]); ?></option>	
							<?php } ?>
						</select>
					</div>
										
					<div class="form-group">
						<div id="div_load" style="display:none">		
							<div class="progress progress-striped active">
								<div class="progress-bar" role="progressbar" aria-valuenow="45" aria-valuemin="0" aria-valuemax="100" style="width: 45%">
									<span class="sr-only">45% completado</span>
								</div>
							</div>
						</div>
						<div id="div_error" style="display:none">			
							<div class="alert alert-danger"><span class="glyphicon glyphicon-remove" id="span_msj">&nbsp;</span></div>
						</div>	
					</div>

					<div class="form-group">
						<div class="row" align="center">
							<div style="width:50%;" align="center">
								<button type="submit" id="btnSubmitMantenimiento" name="btnSubmitMantenimiento" class="btn btn-primary" >
									Guardar <span class="glyphicon glyphicon-floppy-disk" aria-hidden="true">
								</button> 
							</div>
						</div>
					</div>
						
				</form>
			</div>

		</div>
	</div>
</div>                       
<!--FIN Modal para adicionar MANTENIMIENTO -->

<script>
$(document).ready(function() {
    $('#dataPreventiveMaintenance').DataTable({
        responsive: true,
		"ordering": false,
		paging: false,
		"searching": false,
		"info": false
    });
});
</script>