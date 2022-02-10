<script type="text/javascript" src="<?php echo base_url("assets/js/validate/report.js"); ?>"></script>

<div id="page-wrapper">

	<br>
    <div class="row">
        <div class="col-lg-12">
            <div class="panel panel-primary">
                <div class="panel-heading">
                    <i class="fa fa-bar-chart-o fa-fw"></i>  PAYROLL FORM SEARCH
                </div>
                <div class="panel-body">
					<div class="alert alert-info">
						<strong>Note:</strong> 
						Select the period to search your records.
					</div>

					<form  name="form" id="form" role="form" method="post" class="form-horizontal" >

						<div class="form-group">
							<div class="col-sm-3 col-sm-offset-2">
								<label for="from">Employee <small>(This field is NOT required.)</small></label>
								<select name="employee" id="employee" class="form-control" >
									<option value=''>Select...</option>
									<?php for ($i = 0; $i < count($workersList); $i++) { ?>
										<option value="<?php echo $workersList[$i]["id_user"]; ?>"><?php echo $workersList[$i]["first_name"] . ' ' . $workersList[$i]["last_name"]; ?></option>	
									<?php } ?>
								</select>
							</div>

							<div class="col-sm-3 col-sm-offset-1">
								<label for="from">Period: *</label>
								<select name="period" id="period" class="form-control" >
									<option value=''>Select...</option>
									<?php for ($i = 0; $i < count($infoPeriod); $i++) { ?>
										<option value="<?php echo $infoPeriod[$i]["id_period"]; ?>"><?php echo $infoPeriod[$i]["period"]; ?></option>	
									<?php } ?>
								</select>
							</div>
						</div>

						<br>
						<div class="form-group">
							<div class="row" align="center">
								<div style="width80%;" align="center">
									 <button type="submit" class="btn btn-primary" id='btnSubmit' name='btnSubmit'>
									 	<span class="glyphicon glyphicon-search" aria-hidden="true"></span> Search 
									 </button>
								</div>
							</div>
						</div>
								
                    </form>

				</div>
			</div>
		</div>
	</div>
</div>