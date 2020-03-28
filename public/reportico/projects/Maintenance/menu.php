<?php
$menu_title = SW_PROJECT_TITLE;
$menu = array (
	array ( "language" => "en_gb", "report" => ".*\.xml", "title" => "<AUTO>" )
	);
?>
<?php
$menu_title = SW_PROJECT_TITLE;
$menu = array (
	array ( "report" => "<p>In the top menu you can find all the reports that you can view on the screen or download to PDF or CSV.</p><p><a style=\"text-decoration: underline !important\"  target=\"_self\" href=\"https://v-contracting.ca/app/dashboard\">Go back</a></p>", "title" => "TEXT" ),
	);

$admin_menu = $menu;


$dropdown_menu = array(
                    array ( 
                        "project" => "Payroll",
                        "title" => "Payroll",
                        "items" => array (
							array ( "reportfile" => "General.xml" )
                            )
                        ),
                    array ( 
                        "project" => "Incidences",
                        "title" => "Incidences",
                        "items" => array (
                            array ( "reportfile" => "near_miss.xml" ),
							array ( "reportfile" => "accident.xml" )
                            )
                        ),
                    array ( 
                        "project" => "Maintenance",
                        "title" => "Maintenance",
                        "items" => array (
                            array ( "reportfile" => "Maintenance program.xml" ),
							array ( "reportfile" => "Maintenance list.xml" )
                            )
                        ),
                );
?>