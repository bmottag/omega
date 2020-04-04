<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Dashboard extends CI_Controller {
	
    public function __construct() {
        parent::__construct();
		$this->load->model("dashboard_model");
		$this->load->model("general_model");
    }

	/**
	 * Index Page for this controller.
	 * Basic dashboard
	 */
	public function index()
	{	
			$this->load->model("general_model");
			$userRol = $this->session->userdata("rol");
			
			$data['infoMaintenance'] = FALSE;
			$data['noJobs'] = FALSE;
			
			//cuenta payroll para el usuario 
			$arrParam["task"] = 1;//buscar por timestap
			$data['noTareas'] = $this->general_model->countTask($arrParam);
			
			$data['noSafety'] = $this->dashboard_model->countSafety();//cuenta registros de safety
			$data['noHauling'] = $this->dashboard_model->countHauling();//cuenta registros de hauling
			$data['noDailyInspection'] = $this->dashboard_model->countDailyInspection();//cuenta registros de DailyInspection
			$data['noHeavyInspection'] = $this->dashboard_model->countHeavyInspection();//cuenta registros de HeavyInspection
			$data['noSpecialInspection'] = $this->dashboard_model->countSpecialInspection();//cuenta registros de SpecialInspection
			
			//informacion de un dayoff si lo aprobaron y lo negaron
			$data['dayoff'] = $this->dashboard_model->dayOffInfo();

			//Filtro datos por id del Usuario
			$arrParam["idEmployee"] = $this->session->userdata("id");

			$arrParam["limit"] = 30;//Limite de registros para la consulta
			$data['info'] = $this->general_model->get_task($arrParam);//search the last 5 records 
			
			$data['infoSafety'] = $this->general_model->get_safety($arrParam);//info de safety
			
			$arrParam["limit"] = 6;//Limite de registros para la consulta
			$data['infoWaterTruck'] = $this->general_model->get_special_inspection_water_truck($arrParam);//info de water truck
			$data['infoHydrovac'] = $this->general_model->get_special_inspection_hydrovac($arrParam);//info de hydrovac
			$data['infoSweeper'] = $this->general_model->get_special_inspection_sweeper($arrParam);//info de sweeper
			$data['infoGenerator'] = $this->general_model->get_special_inspection_generator($arrParam);//info de generador
		
			$data["view"] = "dashboard";
			$this->load->view("layout", $data);
	}
	
	/**
	 * hauling list
     * @since 31/1/2018
     * @author BMOTTAG
	 */
	public function hauling()
	{		
			$this->load->model("general_model");
			$userRol = $this->session->userdata("rol");
			$data['dashboardURL'] = $this->session->userdata("dashboardURL");

			if($userRol == 7){ //If it is a BASIC USER, just show the records of the user session
				$arrParam["idEmployee"] = $this->session->userdata("id");
			}
			$arrParam["limit"] = 30;//Limite de registros para la consulta

			$data['infoHauling'] = $this->general_model->get_hauling($arrParam);//info de hauling

			$data["view"] ='hauling_list';
			$this->load->view("layout", $data);
	}
	
	/**
	 * pickup inpection list
     * @since 31/1/2018
     * @author BMOTTAG
	 */
	public function pickups_inspection()
	{		
			$this->load->model("general_model");
			$userRol = $this->session->userdata("rol");
			$data['dashboardURL'] = $this->session->userdata("dashboardURL");

			if($userRol == 7){ //If it is a BASIC USER, just show the records of the user session
				$arrParam["idEmployee"] = $this->session->userdata("id");
			}
			$arrParam["limit"] = 30;//Limite de registros para la consulta

			$data['infoDaily'] = $this->general_model->get_daily_inspection($arrParam);//info pickups inspection

			$data["view"] ='pickups_inspection_list';
			$this->load->view("layout", $data);
	}
	
	/**
	 * construction equipment inpection list
     * @since 31/1/2018
     * @author BMOTTAG
	 */
	public function construction_equipment_inspection()
	{		
			$this->load->model("general_model");
			$userRol = $this->session->userdata("rol");
			$data['dashboardURL'] = $this->session->userdata("dashboardURL");

			if($userRol == 7){ //If it is a BASIC USER, just show the records of the user session
				$arrParam["idEmployee"] = $this->session->userdata("id");
			}
			$arrParam["limit"] = 30;//Limite de registros para la consulta

			$data['infoHeavy'] = $this->general_model->get_heavy_inspection($arrParam);//info de contruction

			$data["view"] ='construction_equipment_inspection_list';
			$this->load->view("layout", $data);
	}
	
	/**
	 * Maintenance list
     * @since 14/3/2020
     * @author BMOTTAG
	 */
	public function maintenance()
	{		
			$this->load->model("general_model");
			$data['dashboardURL'] = $this->session->userdata("dashboardURL");

			$data['infoMaintenance'] = $this->general_model->get_maintenance_check();

			$data["view"] ='maintenance_list';
			$this->load->view("layout", $data);
	}
	
	/**
	 * System general info
     * @since 28/3/2020
     * @author BMOTTAG
	 */
	public function info()
	{		
			$data["view"] ='general_info';
			$this->load->view("layout", $data);
	}

	/**
	 * SUPERVISOR DASHBOARD
	 */
	public function supervisor()
	{	
			$this->load->model("general_model");
			$userRol = $this->session->userdata("rol");
			
			$data['infoMaintenance'] = FALSE;
			
			//cuenta payroll para el usuario 
			$arrParam["task"] = 1;//buscar por timestap
			$data['noTareas'] = $this->general_model->countTask($arrParam);
			
			$data['noSafety'] = $this->dashboard_model->countSafety();//cuenta registros de safety
			$data['noJobs'] = $this->dashboard_model->countJobs();//cuenta registros de Jobs
			$data['noHauling'] = $this->dashboard_model->countHauling();//cuenta registros de hauling
			$data['noDailyInspection'] = $this->dashboard_model->countDailyInspection();//cuenta registros de DailyInspection
			$data['noHeavyInspection'] = $this->dashboard_model->countHeavyInspection();//cuenta registros de HeavyInspection
			$data['noSpecialInspection'] = $this->dashboard_model->countSpecialInspection();//cuenta registros de SpecialInspection
			
			//informacion de un dayoff si lo aprobaron y lo negaron
			$data['dayoff'] = $this->dashboard_model->dayOffInfo();
										
			$arrParam["limit"] = 30;//Limite de registros para la consulta
			$data['info'] = $this->general_model->get_task($arrParam);//search the last 5 records 
			
			$data['infoSafety'] = $this->general_model->get_safety($arrParam);//info de safety
			
			$arrParam["limit"] = 6;//Limite de registros para la consulta
			$data['infoWaterTruck'] = $this->general_model->get_special_inspection_water_truck($arrParam);//info de water truck
			$data['infoHydrovac'] = $this->general_model->get_special_inspection_hydrovac($arrParam);//info de hydrovac
			$data['infoSweeper'] = $this->general_model->get_special_inspection_sweeper($arrParam);//info de sweeper
			$data['infoGenerator'] = $this->general_model->get_special_inspection_generator($arrParam);//info de generador
		
			$data["view"] = "dashboard";
			$this->load->view("layout", $data);
	}
	
	/**
	 * WORK ORDER DASHBOARD
	 */
	public function work_order()
	{	
			$this->load->model("general_model");
			$userRol = $this->session->userdata("rol");
			
			$data['infoMaintenance'] = FALSE;
			$data['noJobs'] = FALSE;
			$data['noDailyInspection'] = FALSE;
			$data['noHeavyInspection'] = FALSE;
			$data['noSpecialInspection'] = FALSE;
			$data['infoGenerator'] = FALSE;
			$data['infoHydrovac'] = FALSE;
			$data['infoSweeper'] = FALSE;
			$data['infoWaterTruck'] = FALSE;
			
			//cuenta payroll para el usuario 
			$arrParam["task"] = 1;//buscar por timestap
			$data['noTareas'] = $this->general_model->countTask($arrParam);
			
			$data['noSafety'] = $this->dashboard_model->countSafety();//cuenta registros de safety
			$data['noHauling'] = $this->dashboard_model->countHauling();//cuenta registros de hauling
						
			//informacion de un dayoff si lo aprobaron y lo negaron
			$data['dayoff'] = $this->dashboard_model->dayOffInfo();
	
			$arrParam["limit"] = 30;//Limite de registros para la consulta
			$data['info'] = $this->general_model->get_task($arrParam);//search the last 5 records 
			
			$data['infoSafety'] = $this->general_model->get_safety($arrParam);//info de safety
					
			$data["view"] = "dashboard";
			$this->load->view("layout", $data);
	}
	
	/**
	 * SAFETY DASHBOARD
	 */
	public function safety()
	{	
			$this->load->model("general_model");
			$userRol = $this->session->userdata("rol");
			
			$data['noHauling'] = FALSE;
			
			//cuenta payroll para el usuario 
			$arrParam["task"] = 1;//buscar por timestap
			$data['noTareas'] = $this->general_model->countTask($arrParam);

			$data['noSafety'] = $this->dashboard_model->countSafety();//cuenta registros de safety
			$data['noJobs'] = $this->dashboard_model->countJobs();//cuenta registros de Jobs
			$data['noDailyInspection'] = $this->dashboard_model->countDailyInspection();//cuenta registros de DailyInspection
			$data['noHeavyInspection'] = $this->dashboard_model->countHeavyInspection();//cuenta registros de HeavyInspection
			$data['noSpecialInspection'] = $this->dashboard_model->countSpecialInspection();//cuenta registros de SpecialInspection
			
			//informacion de un dayoff si lo aprobaron y lo negaron
			$data['dayoff'] = $this->dashboard_model->dayOffInfo();
	
			$arrParam["idEmployee"] = $this->session->userdata("id");
			
			$data['infoMaintenance'] = $this->general_model->get_maintenance_check();
						
			$arrParam["limit"] = 30;//Limite de registros para la consulta
			$data['info'] = $this->general_model->get_task($arrParam);//search the last 5 records 
			
			$data['infoSafety'] = $this->general_model->get_safety($arrParam);//info de safety
			
			$arrParam["limit"] = 6;//Limite de registros para la consulta
			$data['infoWaterTruck'] = $this->general_model->get_special_inspection_water_truck($arrParam);//info de water truck
			$data['infoHydrovac'] = $this->general_model->get_special_inspection_hydrovac($arrParam);//info de hydrovac
			$data['infoSweeper'] = $this->general_model->get_special_inspection_sweeper($arrParam);//info de sweeper
			$data['infoGenerator'] = $this->general_model->get_special_inspection_generator($arrParam);//info de generador
		
			$data["view"] = "dashboard";
			$this->load->view("layout", $data);
	}
	
	/**
	 * Accounting DASHBOARD
	 */
	public function accounting()
	{	
			$this->load->model("general_model");

			$data['noJobs'] = FALSE;
			$data['noDailyInspection'] = FALSE;
			$data['noHeavyInspection'] = FALSE;
			$data['noSpecialInspection'] = FALSE;
			$data['dayoff'] = FALSE;
			$data['infoMaintenance'] = FALSE;
			$data['infoWaterTruck'] = FALSE;
			$data['infoHydrovac'] = FALSE;
			$data['infoSweeper'] = FALSE;
			$data['infoGenerator'] = FALSE;
			
			//cuenta payroll para el usuario 
			$arrParam["task"] = 1;//buscar por timestap
			$data['noTareas'] = $this->general_model->countTask($arrParam);
			
			$data['noSafety'] = $this->dashboard_model->countSafety();//cuenta registros de safety
			$data['noHauling'] = $this->dashboard_model->countHauling();//cuenta registros de hauling
			//$data['noDailyInspection'] = $this->dashboard_model->countDailyInspection();//cuenta registros de DailyInspection
			//$data['noHeavyInspection'] = $this->dashboard_model->countHeavyInspection();//cuenta registros de HeavyInspection
			//$data['noSpecialInspection'] = $this->dashboard_model->countSpecialInspection();//cuenta registros de SpecialInspection
			
			//informacion de un dayoff si lo aprobaron y lo negaron
			//$data['dayoff'] = $this->dashboard_model->dayOffInfo();
	
			//$data['infoMaintenance'] = $this->general_model->get_maintenance_check();
						
			$arrParam["limit"] = 30;//Limite de registros para la consulta
			$data['info'] = $this->general_model->get_task($arrParam);//search the last 5 records 
			
			$data['infoSafety'] = $this->general_model->get_safety($arrParam);//info de safety
			
			$arrParam["limit"] = 6;//Limite de registros para la consulta
			//$data['infoWaterTruck'] = $this->general_model->get_special_inspection_water_truck($arrParam);//info de water truck
			//$data['infoHydrovac'] = $this->general_model->get_special_inspection_hydrovac($arrParam);//info de hydrovac
			//$data['infoSweeper'] = $this->general_model->get_special_inspection_sweeper($arrParam);//info de sweeper
			//$data['infoGenerator'] = $this->general_model->get_special_inspection_generator($arrParam);//info de generador
		
			$data["view"] = "dashboard";
			$this->load->view("layout", $data);
	}
	
	/**
	 * Management DASHBOARD
	 */
	public function management()
	{	
			$this->load->model("general_model");
			
			$data['dayoff'] = FALSE;
			$data['infoMaintenance'] = FALSE;
			
			//cuenta payroll para el usuario 
			$arrParam["task"] = 1;//buscar por timestap
			$data['noTareas'] = $this->general_model->countTask($arrParam);
			
			$data['noSafety'] = $this->dashboard_model->countSafety();//cuenta registros de safety
			$data['noJobs'] = $this->dashboard_model->countJobs();//cuenta registros de Jobs
			$data['noHauling'] = $this->dashboard_model->countHauling();//cuenta registros de hauling
			$data['noDailyInspection'] = $this->dashboard_model->countDailyInspection();//cuenta registros de DailyInspection
			$data['noHeavyInspection'] = $this->dashboard_model->countHeavyInspection();//cuenta registros de HeavyInspection
			$data['noSpecialInspection'] = $this->dashboard_model->countSpecialInspection();//cuenta registros de SpecialInspection
			
			//informacion de un dayoff si lo aprobaron y lo negaron
			//$data['dayoff'] = $this->dashboard_model->dayOffInfo();
				
			//$data['infoMaintenance'] = $this->general_model->get_maintenance_check();
						
			$arrParam["limit"] = 30;//Limite de registros para la consulta
			$data['info'] = $this->general_model->get_task($arrParam);//search the last 5 records 
			
			$data['infoSafety'] = $this->general_model->get_safety($arrParam);//info de safety
			
			$arrParam["limit"] = 6;//Limite de registros para la consulta
			$data['infoWaterTruck'] = $this->general_model->get_special_inspection_water_truck($arrParam);//info de water truck
			$data['infoHydrovac'] = $this->general_model->get_special_inspection_hydrovac($arrParam);//info de hydrovac
			$data['infoSweeper'] = $this->general_model->get_special_inspection_sweeper($arrParam);//info de sweeper
			$data['infoGenerator'] = $this->general_model->get_special_inspection_generator($arrParam);//info de generador
		
			$data["view"] = "dashboard";
			$this->load->view("layout", $data);
	}
	
	/**
	 * SUPER ADMIN DASHBOARD
	 */
	public function admin()
	{	
			$this->load->model("general_model");
			
			//cuenta payroll para el usuario 
			$arrParam["task"] = 1;//buscar por timestap
			$data['noTareas'] = $this->general_model->countTask($arrParam);
			
			$data['noSafety'] = $this->dashboard_model->countSafety();//cuenta registros de safety
			$data['noJobs'] = $this->dashboard_model->countJobs();//cuenta registros de Jobs
			$data['noHauling'] = $this->dashboard_model->countHauling();//cuenta registros de hauling
			$data['noDailyInspection'] = $this->dashboard_model->countDailyInspection();//cuenta registros de DailyInspection
			$data['noHeavyInspection'] = $this->dashboard_model->countHeavyInspection();//cuenta registros de HeavyInspection
			$data['noSpecialInspection'] = $this->dashboard_model->countSpecialInspection();//cuenta registros de SpecialInspection
			
			//informacion de un dayoff si lo aprobaron y lo negaron
			$data['dayoff'] = $this->dashboard_model->dayOffInfo();
				
			$data['infoMaintenance'] = $this->general_model->get_maintenance_check();
						
			$arrParam["limit"] = 30;//Limite de registros para la consulta
			$data['info'] = $this->general_model->get_task($arrParam);//search the last 5 records 
			
			$data['infoSafety'] = $this->general_model->get_safety($arrParam);//info de safety
			
			$arrParam["limit"] = 6;//Limite de registros para la consulta
			$data['infoWaterTruck'] = $this->general_model->get_special_inspection_water_truck($arrParam);//info de water truck
			$data['infoHydrovac'] = $this->general_model->get_special_inspection_hydrovac($arrParam);//info de hydrovac
			$data['infoSweeper'] = $this->general_model->get_special_inspection_sweeper($arrParam);//info de sweeper
			$data['infoGenerator'] = $this->general_model->get_special_inspection_generator($arrParam);//info de generador
		
			$data["view"] = "dashboard";
			$this->load->view("layout", $data);
	}
	
	
}