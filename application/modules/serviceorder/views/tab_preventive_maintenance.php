<script type="text/javascript" src="<?php echo base_url("assets/js/validate/serviceorder/preventive_maintenance.js"); ?>"></script>

<script>
$(function(){
	$(".btn-service-order").click(function () {
			var oID = $(this).attr("id");
            var idEquipment = $('#hddIdEquipment').val();
            $.ajax ({
                type: 'POST',
				url: base_url + 'serviceorder/cargarModalServiceOrder',
				data: { "idServiceOrder": "x", "idMaintenance": oID, "maintenanceType": "preventive", idEquipment },
                cache: false,
                success: function (data) {
                    $('#tablaDatosServiceOrder').html(data);
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
                <button type="button" class="btn btn-info btn-xs" data-toggle="modal" data-target="#modalMaintenance" id="x">
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
					<button type="button" class="btn btn-violeta btn-xs btn-block btn-service-order" data-toggle="modal" data-target="#modal" id="<?php echo $lista['id_preventive_maintenance']; ?>">
                        Creat S.O. <span class="glyphicon glyphicon-briefcase" aria-hidden="true">
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

<div class="modal fade text-center" id="modalServiceOrder" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">    
	<div class="modal-dialog" role="document">
		<div class="modal-content" id="tablaDatosServiceOrder">
		</div>
	</div>
</div>

<!--INICIO Modal para adicionar MANTENIMIENTO -->
<div class="modal fade text-center" id="modalMaintenance" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">    
	<div class="modal-dialog" role="document">
		<div class="modal-content" id="tablaDatosMaintenace">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
				<h4 class="modal-title" id="exampleModalLabel">Add Preventive Maintenance</h4>
			</div>

			<div class="modal-body">
				<form name="formMaintenance" id="formMaintenance" role="form" method="post" >
                    <input type="hidden" id="hddIdEquipment" name="hddIdEquipment" value="<?php echo $vehicleInfo[0]['id_vehicle']; ?>"/>
					
                    <div class="row">
                        <div class="col-sm-12">
                            <div class="form-group text-left">
                                <label class="control-label" for="maintenance_type"> Maintenance Type: * </label>
                                <select name="maintenance_type" id="maintenance_type" class="form-control" required >
                                    <option value=''>Select...</option>
                                    <?php for ($i = 0; $i < count($infoTypeMaintenance); $i++) { ?>
                                        <option value="<?php echo $infoTypeMaintenance[$i]["id_maintenance_type"]; ?>" ><?php echo $infoTypeMaintenance[$i]["maintenance_type"]; ?></option>	
                                    <?php } ?>
                                </select>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-sm-12">
                            <div class="form-group text-left">
                                <label class="control-label" for="type">Maintenance Description: *</label>
                                <textarea id="description" name="description" placeholder="Maintenance Description" class="form-control" rows="3" required></textarea>
                            </div>
                        </div>
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
                                <button type="button" id="btnSubmitMaintenance" name="btnSubmitMaintenance" class="btn btn-primary" >
                                    Save <span class="glyphicon glyphicon-floppy-disk" aria-hidden="true">
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