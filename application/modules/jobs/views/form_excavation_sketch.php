<script type="text/javascript" src="<?php echo base_url("assets/js/validate/jobs/excavation_access.js"); ?>"></script>

<script>
function valid_field() 
{
	if(document.getElementById('ladder').checked || document.getElementById('ramp').checked || document.getElementById('other').checked ){
		document.getElementById('hddField').value = 1;
	}else{
		document.getElementById('hddField').value = "";
	}
}
</script>

<div id="page-wrapper">
	<br>
	
	<!-- /.row -->
	<div class="row">
		<div class="col-lg-12">
			<div class="panel panel-danger">
				<div class="panel-heading">
					<a class="btn btn-danger btn-xs" href=" <?php echo base_url('jobs/excavation/' . $information[0]["id_job"]); ?> "><span class="glyphicon glyphicon glyphicon-chevron-left" aria-hidden="true"></span> Go back </a> 
					<i class="fa fa-pied-piper-alt"></i> <strong>EXCAVATION AND TRENCHING PLAN</strong>
				</div>
				<div class="panel-body">
					<div class="alert alert-danger">
						<span class="fa fa-briefcase" aria-hidden="true"></span>
						<strong>Job Code/Name: </strong><?php echo $information?$information[0]["job_description"]:""; ?>
					</div>
				<?php 
					if($information){
				?>
					<ul class="nav nav-tabs">
						<li><a href="<?php echo base_url('jobs/add_excavation/' . $information[0]['fk_id_job'] . '/' . $information[0]['id_job_excavation']); ?>">Main Form</a>
						</li>
						<li><a href="<?php echo base_url('jobs/upload_excavation_personnel/' . $information[0]['id_job_excavation']); ?>">Personnel</a></li>
						<li><a href="<?php echo base_url('jobs/upload_protection_methods/' . $information[0]['id_job_excavation']); ?>">Protection Methods & Systems</a></li>
						<li><a href="<?php echo base_url('jobs/upload_access_egress/' . $information[0]['id_job_excavation']); ?>">Access & Egress </a></li>
						<li><a href="<?php echo base_url('jobs/upload_affected_zone/' . $information[0]['id_job_excavation']); ?>">Affected Zone </a></li>
						<li><a href="<?php echo base_url('jobs/upload_de_watering/' . $information[0]['id_job_excavation']); ?>">De-Watering </a></li>
						<li class='active'><a href="<?php echo base_url('jobs/upload_sketch/' . $information[0]['id_job_excavation']); ?>">Excavation / Trench Sketch </a></li>
						<li><a href="<?php echo base_url('jobs/review_excavation/' . $information[0]['id_job_excavation']); ?>">Approvals / Review </a></li>						
					</ul>
					<br>
				<?php
					}
				?>

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

	<div class="row">
		<div class="col-lg-5">
			<div class="panel panel-primary">
				<div class="panel-body">
					<strong>Job Code/Name: </strong><?php echo $information[0]["job_description"]; ?><br>
					<strong>Date: </strong><?php echo $information[0]["date_excavation"]; ?><br>
					<strong>Project Location: </strong><?php echo $information[0]["project_location"]; ?><br>
					<strong>Anticipated Depth of excavation / trench: </strong><?php echo $information[0]["depth"]; ?> meters<br>
					<strong>Width: </strong><?php echo $information[0]["width"]; ?> meters<br>
					<strong>Length: </strong><?php echo $information[0]["length"]; ?> meters
				</div>
			</div>
		</div>

		<div class="col-lg-7">
	        <div class="panel panel-primary">
	            <div class="panel-heading">
	                <i class="fa fa-edit fa-fw"></i> Excavation / Trench Sketch
	            </div>

                <div class="panel-body">

					<div class="form-group">
						<p class="text-info">Please include a sketch or diagram of the excavation / trench. Be sure to include any surface encumbrances and perimeter protection.</p>						
					</div>
					<div class="form-group">
						<div class="row" align="center">
							<div style="width:80%;" align="center">
							<?php 								
								$class = "btn-primary";						
								if($information[0]["excavation_sketch"])
								{ 
									$class = "btn-default";
							?>
<img src="<?php echo base_url($information[0]["excavation_sketch"]); ?>" class="img-rounded" alt="Sketch or Diagram" width="400" height="336" />
							<?php
								}
							?>
						<br>
								<a class="btn <?php echo $class; ?>" href="<?php echo base_url("jobs/add_signature_excavation/sketch/" . $information[0]["id_job_excavation"] . "/x"); ?>"><span class="glyphicon glyphicon-edit" aria-hidden="true"></span> Sketch or Diagram </a>
							</div>
						</div>
					</div>
				</div>
			</div>


		</div>	
	</div>

				</div>
			</div>
		</div>
	</div>
</div>