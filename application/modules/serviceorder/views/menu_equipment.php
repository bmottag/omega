<!-- IMAGEN DEL EQUIPO -->
<?php 
if($vehicleInfo[0]["photo"]){
    ?>
    <div class="form-group">
        <div class="row" align="center">
            <img src="<?php echo base_url($vehicleInfo[0]["photo"]); ?>" class="img-rounded" width="150" height="150" alt="Equipment Image" />
        </div>
    </div>
<?php } ?>
<!-- FIN IMAGEN DEL EQUIPO -->
<div class="form-group">
    <div class="row">
        <div class="col-lg-6">
            <strong>Unit Number: </strong><br><?php echo $vehicleInfo[0]['unit_number']; ?><br>
            <strong>VIN Number: </strong><br><?php echo  $vehicleInfo[0]['vin_number']; ?><br>
            <strong>Equipment Hours/Kilometers: </strong><br><?php echo  number_format($vehicleInfo[0]['hours']); ?>
        </div>
        <div class="col-lg-6">
            <strong>Make: </strong><br><?php echo $vehicleInfo[0]['make']; ?><br>
            <strong>Model: </strong><br><?php echo  $vehicleInfo[0]['model']; ?><br>
            <strong>Description: </strong><br><?php echo  $vehicleInfo[0]['description']; ?>
        </div>
    </div>
</div>

<?php
    $classInactivo = "btn btn-outline btn-default btn-block";
    $classActivo = "btn btn-info btn-block";
?>

<div class="list-group">
    <a class="<?php echo ($tabview=='tab_service_order' || $tabview=='tab_service_order_detail')?$classActivo:$classInactivo; ?>" onclick="loadEquipmentDetail( <?php echo $vehicleInfo[0]['id_vehicle']; ?>, 'tab_service_order' )" >
        <i class="fa fa-briefcase"></i> Service Order
    </a>
    <a class="<?php echo $tabview=='tab_corrective_maintenance'?$classActivo:$classInactivo; ?>" onclick="loadEquipmentDetail( <?php echo $vehicleInfo[0]['id_vehicle']; ?>, 'tab_corrective_maintenance' )" >
        <i class="fa fa-wrench"></i> Corrective Maintenance
    </a>
    <a class="<?php echo $tabview=='tab_preventive_maintenance'?$classActivo:$classInactivo; ?>" onclick="loadEquipmentDetail( <?php echo $vehicleInfo[0]['id_vehicle']; ?>, 'tab_preventive_maintenance' )" >
        <i class="fa fa-wrench"></i> Preventive Maintenance
    </a>
    <a class="<?php echo $tabview=='tab_inspections'?$classActivo:$classInactivo; ?>" onclick="loadEquipmentDetail( <?php echo $vehicleInfo[0]['id_vehicle']; ?>, 'tab_inspections' )" >
        <i class="fa fa-tasks"></i> Inspections
    </a>
</div>