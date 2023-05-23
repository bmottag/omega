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

	$(".btn-preventive-maintenance").click(function () {
			var oID = $(this).attr("id");
            var idEquipment = $('#hddIdEquipment').val();
            $.ajax ({
                type: 'POST',
				url: base_url + 'serviceorder/cargarModalPreventiveMaintenance',
				data: { "idMaintenance": oID, idEquipment },
                cache: false,
                success: function (data) {
                    $('#tablaDatosMaintenace').html(data);
                }
            });
	});	
});
</script>

<div class="panel panel-info">
    <div class="panel-heading">
        <i class="fa fa-wrench"></i> <strong>Preventive Maintenance</strong>
        <div class="pull-right">
            <div class="btn-group">
                <input type="hidden" id="hddIdEquipment" name="hddIdEquipment" value="<?php echo $vehicleInfo[0]['id_vehicle']; ?>"/>
                <button type="button" class="btn btn-primary btn-xs btn-preventive-maintenance" data-toggle="modal" data-target="#modalMaintenance" id="x">
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
					<button type="button" class="btn btn-violeta btn-xs btn-block btn-service-order" data-toggle="modal" data-target="#modalServiceOrder" id="<?php echo $lista['id_preventive_maintenance']; ?>">
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