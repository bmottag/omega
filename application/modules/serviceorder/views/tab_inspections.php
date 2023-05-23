<div class="panel panel-info">
    <div class="panel-heading">
        <i class="fa fa-tasks"></i> <strong>Inspections</strong>
    </div>
    <div class="panel-body small">

<?php
$retornoExito = $this->session->flashdata('retornoExito');
if ($retornoExito) {
    ?>
    <div class="row">
		<div class="col-lg-12">	
			<div class="alert alert-success ">
				<span class="glyphicon glyphicon-ok" aria-hidden="true"></span>
				<?php echo $retornoExito ?>		
			</div>
		</div>
	</div>
    <?php
}

$retornoError = $this->session->flashdata('retornoError');
if ($retornoError) {
    ?>
    <div class="row">
		<div class="col-lg-12">	
			<div class="alert alert-danger ">
				<span class="glyphicon glyphicon-exclamation-sign" aria-hidden="true"></span>
				<?php echo $retornoError ?>
			</div>
		</div>
	</div>
    <?php
}
?>
        <?php
            $tipo = $vehicleInfo[0]['type_level_2'];							
            if(!$infoInspections){ 
                echo '<div class="col-lg-12">
                        <p class="text-danger"><span class="glyphicon glyphicon-alert" aria-hidden="true"></span> There are no records in the system.</p>
                    </div>';
            } else {
        ?>
        <table width="100%" class="table table-striped table-bordered table-hover" id="dataInspections">
            <thead>
                <tr>
                    <th class="text-center">Date of Issue</th>
                    <th class="text-center">Operator</th>
                    <th class="text-center">Hours/Kilometers</th>
                    <th class="text-center">Status</th>
                    <th class="text-center">Inspection Comment</th>
                </tr>
            </thead>
            <tbody>							
            <?php
                $tableInspection = $vehicleInfo[0]['table_inspection'];
                $i = 1;
                foreach ($infoInspections as $lista):
                
                        $class = "";
                        if($lista['comments'] != ''){
                            $class = "danger";
                        }
                        
                        echo "<tr class='" . $class . "'>";
                
                        echo "<td class='text-center'><p class='text-" . $class . "'>" . date('F j, Y - G:i:s', strtotime($lista['date_issue'])) . "<br>";
                        if($lista['fk_id_inspection'] != 0){
                            switch ($tableInspection) {
                                case 'inspection_daily':
                                    $reportLink = base_url('report/generaInsectionDailyPDF/x/x/x/x/x/' . $lista['fk_id_inspection']);
                                    break;
                                case 'inspection_heavy':
                                    $reportLink = base_url('report/generaInsectionHeavyPDF/x/x/x/x/' . $lista['fk_id_inspection']); 
                                    break;
                                case 'inspection_generator':
                                    $reportLink = base_url('report/generaInsectionSpecialPDF/x/x/x/x/generator/' . $lista['fk_id_inspection']);
                                    break;
                                case 'inspection_sweeper':
                                    $reportLink = base_url('report/generaInsectionSpecialPDF/x/x/x/x/sweeper/' . $lista['fk_id_inspection']);
                                    break;
                                case 'inspection_hydrovac':
                                    $reportLink = base_url('report/generaInsectionSpecialPDF/x/x/x/x/hydrovac/' . $lista['fk_id_inspection']);
                                    break;
                                case 'inspection_watertruck':
                                    $reportLink = base_url('report/generaInsectionSpecialPDF/x/x/x/x/watertruck/' . $lista['fk_id_inspection']);
                                    break;
                            }
                        ?>
                            <a href='<?php echo $reportLink; ?>' target="_blank"> <img src='<?php echo base_url_images('pdf.png'); ?>' ></a>
                        <?php
                        }
                        echo "</p></td>";
                        echo "<td class='text-center'><p class='text-" . $class . "'>" . $lista['name'] . "</p></td>";
                        
                        echo "<td class='text-right'><p class='text-" . $class . "'>";

                        //si es sweeper
                        if($tipo == 15){
                            echo "Truck engine current hours: " . number_format($lista["current_hours"]);
                            echo "<br>Sweeper engine current hours: " . number_format($lista["current_hours_2"]);
                        //si es hydrovac
                        }elseif($tipo == 16){
                            echo "Engine current hours: " . number_format($lista["current_hours"]);
                            echo "<br>Hydraulic pump current hours: " . number_format($lista["current_hours_2"]);
                            echo "<br>Blower current hours: " . number_format($lista["current_hours_3"]);
                        }else{
                            echo number_format($lista["current_hours"]);
                        }
                        
                        echo "</p></td>";
                                            
                        echo "<td class='text-center'><p class='text-" . $class . "'>";
                        switch ($lista['state']) {
                            case 0:
                                echo "First Record";
                                break;
                            case 1:
                                echo "Inspection";
                                //boton para editar la inspeccion
                                $linkInspection = $vehicleInfo[0]['link_inspection'] . "/". $lista['fk_id_inspection'];
                                if($i==1){
                                    echo "<br><a class='btn btn-success btn-xs' href='" . base_url($linkInspection) . "'>
                                    Edit <span class='glyphicon glyphicon-edit' aria-hidden='true'>
                                    </a>";
                                }
                                break;
                            case 2:
                                echo "Oil Change";
                                break;
                        }
                        
                        echo "</p></td>";
                        echo "<td ><p class='text-" . $class . "'>" . $lista['comments'] . "</p></td>";
                        
                        echo "</tr>";
                        $i++;
                endforeach;
            ?>
            </tbody>
        </table>
    <?php } ?>
    </div>
</div>

<script>
$(document).ready(function() {
    $('#dataInspections').DataTable({
        responsive: true,
		"ordering": false,
		paging: false,
		"searching": false,
		"info": false
    });
});
</script>