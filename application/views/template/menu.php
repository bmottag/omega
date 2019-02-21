        <!-- Navigation -->
        <nav class="navbar navbar-default navbar-static-top" role="navigation" style="margin-bottom: 0">
            <div class="navbar-header">
                <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
				<a class="navbar-brand" href="<?php echo base_url("dashboard"); ?>"><img src="<?php echo base_url("images/logo.png"); ?>" class="img-rounded" width="87" height="32" /></a>
            </div>
            <!-- /.navbar-header -->

		


            <ul class="nav navbar-top-links navbar-right">
                <!-- /.dropdown -->	
<?php
/**
 * Special MENU for ADMIN
 * @author BMOTTAG
 * @since  18/11/2016
 */
		$userRol = $this->session->rol;
		if($userRol == 99 || $userRol == 1){ //If it is an ADMIN user, show an special menu
?>				

                <li class="dropdown">
                    <a class="dropdown-toggle" data-toggle="dropdown" href="#">
                        <i class="fa fa-calendar"></i> Day Off <i class="fa fa-caret-down"></i>
                    </a>
                    <ul class="dropdown-menu dropdown-messages">
<?php if($userRol==99){ ?>					
                        <li>
							<a href="<?php echo base_url("dayoff/newDayoffList"); ?>"><i class="fa fa-hand-o-right fa-fw"></i> New Day Off</a>
                        </li>
<?php } ?>						
                        <li>
							<a href="<?php echo base_url("dayoff/approvedDayoffList"); ?>"><i class="fa fa-hand-o-up fa-fw"></i> Approved Day Off</a>
                        </li>
<?php if($userRol==99){ ?>
                        <li>
							<a href="<?php echo base_url("dayoff/deniedDayoffList"); ?>"><i class="fa fa-hand-o-down fa-fw"></i> Denied Day Off</a>
                        </li>
<?php } ?>
                    </ul>
                    <!-- /.dropdown-messages -->
                </li>


                <li class="dropdown">
                    <a class="dropdown-toggle" data-toggle="dropdown" href="#">
                        <i class="fa fa-list-alt"></i> Reports <i class="fa fa-caret-down"></i>
                    </a>
                    <ul class="dropdown-menu dropdown-messages">
                        <li>
							<a href="https://v-contracting.ca/app/public/reportico/run.php?project=Payroll&execute_mode=MENU" target="_blank"><i class="fa fa-book fa-fw"></i> Payroll Report</a>
                        </li>
						
                        <li>
							<a href="https://v-contracting.ca/app/public/reportico/run.php?project=Payroll&execute_mode=MENU" target="_blank"><i class="fa fa-ambulance fa-fw"></i> Incidences Report</a>
                        </li>
						
						<li class="divider"></li>
						
						
                        <li>
							<a href="<?php echo base_url("report/searchByDateRange/safety"); ?>"><i class="fa fa-life-saver fa-fw"></i> FLHA Report</a>
                        </li>
                        <li>
							<a href="<?php echo base_url("report/searchByDateRange/hauling"); ?>"><i class="fa fa-truck fa-fw"></i> Hauling Report</a>
                        </li>
                        <li>
							<a href="<?php echo base_url("report/searchByDateRange/dailyInspection"); ?>"><i class="fa fa-search fa-fw"></i> Pickups & Trucks Inspection Report</a>
                        </li>
                        <li>
							<a href="<?php echo base_url("report/searchByDateRange/heavyInspection"); ?>"><i class="fa fa-search fa-fw"></i> Construction Equipment Inspection Report</a>
                        </li>
                        <li>
							<a href="<?php echo base_url("report/searchByDateRange/specialInspection"); ?>"><i class="fa fa-search fa-fw"></i> Special Equipment Inspection Report</a>
                        </li>
                        <li>
							<a href="<?php echo base_url("report/searchByDateRange/workorder"); ?>"><i class="fa fa-money fa-fw"></i> Work Order Report</a>
                        </li>
						
                    </ul>
                </li>

                <li class="dropdown">
                    <a class="dropdown-toggle" data-toggle="dropdown" href="#">
                        <i class="fa fa-gear fa-fw"></i>Settings <i class="fa fa-caret-down"></i>
                    </a>
                    <ul class="dropdown-menu dropdown-messages">
					<?php if($userRol==99){ ?>
                        <li>
							<a href="<?php echo base_url("admin/employee"); ?>"><i class="fa fa-users fa-fw"></i> Employee</a>
                        </li>
						
                        <li>
							<a href="<?php echo base_url("admin/job"); ?>"><i class="fa fa-briefcase fa-fw"></i> Job Code/Name</a>
                        </li>
				
						<li class="divider"></li>
					<?php } ?>
					
					<?php if($userRol == 99 || $userRol == 1){ //If it is an ADMIN user, show an special menu ?>
					
                        <li>
							<a href="<?php echo base_url("programming"); ?>"><i class="fa fa-briefcase fa-fw"></i> Planning</a>
                        </li>
												
						<li class="divider"></li>
					
					<?php } ?>
						
                        <li>
							<a href="<?php echo base_url("admin/hazard"); ?>"><i class="fa fa-medkit fa-fw"></i> Hazard</a>
                        </li>
						
						<li>
							<a href="<?php echo base_url("admin/hazardActivity"); ?>"><i class="fa fa-suitcase fa-fw"></i> Hazard Activity</a>
                        </li>
						
						<li class="divider"></li>

                        <li>
							<a href="<?php echo base_url("admin/company"); ?>"><i class="fa fa-building fa-fw"></i> Company</a>
                        </li>
						
						<li class="divider"></li>
						
                        <li>
							<a href="<?php echo base_url("admin/vehicle/1"); ?>"><i class="fa fa-automobile fa-fw"></i> Vehicle - VCI</a>
                        </li>
						
                        <li>
							<a href="<?php echo base_url("admin/vehicle/2"); ?>"><i class="fa fa-automobile fa-fw"></i> Rentals</a>
                        </li>
						
						<li class="divider"></li>
						
                        <li>
							<a href="<?php echo base_url("admin/material"); ?>"><i class="fa fa-tint fa-fw"></i> Material Type</a>
                        </li>
						
                        <li>
							<a href="<?php echo base_url("admin/employeeType"); ?>"><i class="fa fa-flag-o fa-fw"></i> Employee Type</a>
                        </li>
						
						
					<?php if($userRol==99){ ?>
						<li class="divider"></li>
					
                        <li>
							<a href="<?php echo base_url("template/templates"); ?>"><i class="fa fa-users fa-fw"></i> Templates</a>
                        </li>
						
						<li class="divider"></li>
					
                        <li>
							<a href="<?php echo base_url("enlaces"); ?>"><i class="fa fa-hand-o-up fa-fw"></i> Links to videos</a>
                        </li>
						
                        <li>
							<a href="<?php echo base_url("enlaces/manuales"); ?>"><i class="fa fa-hand-o-up fa-fw"></i> Links to manuals</a>
                        </li>
						
					<?php } ?>

                    </ul>
                </li>
<?php
		}
?>				

                <li class="dropdown">
                    <a class="dropdown-toggle" data-toggle="dropdown" href="#">
                        <i class="fa fa-life-saver"></i> Manuals <i class="fa fa-caret-down"></i>
                    </a>
                    <ul class="dropdown-menu dropdown-messages">

<?php
		if($enlacesManuales){
			foreach ($enlacesManuales as $lista):

				echo "<li>";
				echo "<a href='" . $lista['enlace'] . "' target='_blank'><i class='fa fa-hand-o-up fa-fw'></i>" . $lista['enlace_name'] . "</a>";
				echo "</li>";
				
			endforeach;
		}

?>
						
						<li class="divider"></li>
						
<?php
		if($enlacesVideos){
			foreach ($enlacesVideos as $lista):

				echo "<li>";
				echo "<a href='" . $lista['enlace'] . "' target='_blank'><i class='fa fa-hand-o-up fa-fw'></i>" . $lista['enlace_name'] . "</a>";
				echo "</li>";
				
			endforeach;
		}

?>
						
                    </ul>
                    <!-- /.dropdown-messages -->
                </li>

				<li>
					<a href="<?php echo base_url("menu/salir"); ?>"><i class="fa fa-sign-out fa-fw"></i> Logout</a>
				</li>
				
                <!-- /.dropdown -->
            </ul>
            <!-- /.navbar-top-links -->



			
			
			


            <div class="navbar-default sidebar" role="navigation">
                <div class="sidebar-nav navbar-collapse">
                    <ul class="nav" id="side-menu">
                        <li>
                            <a href="#">
							
							<?php if($this->session->photo){ ?>
							<img src="<?php echo base_url($this->session->photo); ?>" class="img-rounded" width="26" height="26" />
							<?php }else{?>
							<i class="fa fa-child fa-fw"></i>
							<?php } ?>
							Hi <?php echo $this->session->firstname; ?>!!!<span class="fa arrow"></span></a>
                            <ul class="nav nav-second-level">

<!--
	Se elimina la opcion de cambiar contraseña, hay un error, no se esta enviando bien el usuario de session|
                                <li>
                                    <a href="<?php echo base_url("employee"); ?>">Change password</a>
                                </li>
-->

                                <li>
                                    <a href="<?php echo base_url("employee/photo"); ?>">User Photo</a>
                                </li>
								
                            </ul>
                            <!-- /.nav-second-level -->
                        </li>
                        <li>
                            <a href="<?php echo base_url("dashboard"); ?>"><i class="fa fa-dashboard fa-fw"></i> Dashboard</a>
                        </li>
                        <li>
                            <a href="#"><i class="fa fa-edit fa-fw"></i> Record Task(s)<span class="fa arrow"></span></a>
                            <ul class="nav nav-second-level">
                                <li>
                                    <a href="<?php echo base_url("payroll/add_payroll"); ?>"> Payroll</a>
                                </li>

                                <li>
                                    <a href="<?php echo base_url("hauling/add_hauling"); ?>"> Hauling</a>
                                </li>
								
                                <li>
                                    <a href="<?php echo base_url("more/ppe_inspection"); ?>"> PPE Inspection</a>
                                </li>
								
                            </ul>
                            <!-- /.nav-second-level -->
                        </li>

                        <li>
                            <a href="<?php echo base_url("jobs"); ?>"><i class="fa fa-briefcase fa-fw"></i> Jobs Info</a>
                        </li>

                        <li>
                            <a href="#"><i class="fa fa-ambulance fa-fw"></i> Incidences<span class="fa arrow"></span></a>
                            <ul class="nav nav-second-level">
                                <li>
                                    <a href="<?php echo base_url("incidences/near_miss"); ?>"> Near miss report</a>
                                </li>

                                <li>
                                    <a href="<?php echo base_url("incidences/incident"); ?>"> Incident/Accident report</a>
                                </li>
<!--
se elimino desde el 22/10/2017
                                <li>
                                    <a href="<?php echo base_url("incidences/accident"); ?>"> Accident report</a>
                                </li>
-->
                            </ul>
                            <!-- /.nav-second-level -->
                        </li>
						
						
                        <li>
                            <a href="<?php echo base_url("dayoff"); ?>"><i class="fa fa-calendar fa-fw"></i> Day Off</a>
                        </li>
						
<?php
		if($userRol == 99 || $userRol == 1 || $userRol == 2){ //If it is an ADMIN user, show an special menu
?>

					<?php if($userRol==99 || $userRol==2){ ?>
                        <li>
                            <a href="#"><i class="fa fa-money fa-fw"></i> Work Orders<span class="fa arrow"></span></a>
                            <ul class="nav nav-second-level">
                                <li>
                                    <a href="<?php echo base_url("workorders"); ?>"> Add/Edit</a>
                                </li>
                                <li>
                                    <a href="<?php echo base_url("workorders/search"); ?>"> Search</a>
                                </li>
                            </ul>
                            <!-- /.nav-second-level -->
                        </li>						
					
					
					<?php }else{ ?>
                        <li>
                            <a href="<?php echo base_url("workorders"); ?>"><i class="fa fa-money fa-fw"></i> Work Orders</a>
                        </li>
					<?php } ?>
						
						
                    </ul>
                </li>
						
						
						
						
						
						
<?php
		}else{ ?>
                        <li>
                            <a href="<?php echo base_url("workorders"); ?>"><i class="fa fa-money fa-fw"></i> Work Orders</a>
                        </li>
					<?php } ?>


                    </ul>
                </div>
                <!-- /.sidebar-collapse -->
            </div>
            <!-- /.navbar-static-side -->
        </nav>