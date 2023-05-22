<script type="text/javascript" src="<?php echo base_url("assets/js/validate/serviceorder/ajaxSearchEquipment.js"); ?>"></script>

<div id="page-wrapper">
	<div class="row"><br>
		<div class="col-md-12">
			<div class="panel panel-primary">
				<div class="panel-heading">
					<h4 class="list-group-item-heading">
						EQUIPMENT CONTROL PANEL
					</h4>
				</div>
			</div>
		</div>
	</div>

	<div class="row">
		<div class="col-lg-4 col-md-6 col-sm-6">
            <div class="panel panel-primary">
                <div class="panel-heading">
                    <i class="fa fa-bell fa-fw"></i> Equipments
                </div>
                <div class="panel-body">
                    <div class="list-group">
					<?php
						foreach ($infoEquipment as $data):
					?>
							<a class="list-group-item" onclick="loadEquipmentList( <?php echo $data['inspection_type']; ?>  , '<?php echo $data['header_inspection_type']; ?>')">
								<i class="fa fa-filter fa-fw"></i> <?php echo $data["header_inspection_type"]; ?>
								<span class="pull-right text-muted small"><em> <?php echo $data["number"]; ?></em>
								</span>
							</a>
						<?php
							endforeach;
						?>
                    </div>
                </div>
            </div>
        </div>

		<div class="col-lg-8 col-md-6 col-sm-6">
			<div class="row">
				<div class="col-lg-6 col-md-12 col-sm-12">
					<div class="panel panel-purpura">
						<div class="panel-heading">
							<i class="fa fa-wrench"></i> <strong>Search Equipment by VIN Number</strong>
						</div>
						<div class="panel-body">									
							<div class="form-group">
								<div class="col-md-8 col-sm-9 col-xs-10">
									<input type="text" id="vinNumber" name="vinNumber" class="form-control" placeholder="VIN Number" minlength="5">
								</div>						
							
								<div class="col-md-3 col-sm-2 col-xs-2">
									<button type="submit" class="btn btn-purpura" id="btnVINNumber">
										<span class="glyphicon glyphicon-search" aria-hidden="true"></span> 
									</button>
								</div>

							</div>
								
						</div>
					</div>
				</div>

				<div class="col-lg-6 col-md-12 col-sm-12">
					<div class="panel panel-purpura">
						<div class="panel-heading">
							<i class="fa fa-wrench"></i> <strong>Search Service Order</strong>
						</div>
						<div class="panel-body">									
							<div class="form-group">
								<div class="col-md-8 col-sm-9 col-xs-10">
									<input type="text" id="soNumber" name="soNumber" class="form-control" placeholder="SO Number">
								</div>						
							
								<div class="col-md-3 col-sm-2 col-xs-2">
									<button type="submit" class="btn btn-purpura">
										<span class="glyphicon glyphicon-search" aria-hidden="true"></span> 
									</button>
								</div>

							</div>
								
						</div>
					</div>
				</div>
			</div>

			<div id="div_info_list" style="display:none"></div>
		</div>
	</div>
	<div class="row">
		<div class="col-md-12" id="div_detail" style="display:none"></div>
	</div>

</div>