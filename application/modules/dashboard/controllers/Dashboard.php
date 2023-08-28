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
	 * BASIC dashboard
	 */
	public function index()
	{	
			$userRol = $this->session->userdata("rol");
			
			$data['infoMaintenance'] = FALSE;
			$data['noJobs'] = FALSE;
			$data['noHauling'] = TRUE;
			$data['noDailyInspection'] = TRUE;
			$data['noHeavyInspection'] = TRUE;
			
			//informacion de un dayoff si lo aprobaron y lo negaron
			$data['dayoff'] = $this->dashboard_model->dayOffInfo();

			//info next planning
			$arrParam = array(
				"idUser" => $this->session->userdata("id"),
				"nextPlanning" => true
			);
			$data['infoPlanning'] = $this->general_model->get_planning_for_employee($arrParam);//info planning

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
	 * MECHANIC DASHBOARD
	 */
	public function mechanic()
	{				
			$data['noJobs'] = FALSE;
			$data['noHauling'] = TRUE;
			$data['noDailyInspection'] = TRUE;
			$data['noHeavyInspection'] = TRUE;
			
			$data['infoMaintenance'] = $this->general_model->get_maintenance_check();
			//informacion de un dayoff si lo aprobaron y lo negaron
			$data['dayoff'] = $this->dashboard_model->dayOffInfo();

			//info next planning
			$arrParam = array(
				"idUser" => $this->session->userdata("id"),
				"nextPlanning" => true
			);
			$data['infoPlanning'] = $this->general_model->get_planning_for_employee($arrParam);//info planning

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
			$userRol = $this->session->userdata("rol");

			$data['noJobs'] = TRUE;	
			$data['noHauling'] = TRUE;
			$data['noDailyInspection'] = TRUE;
			$data['noHeavyInspection'] = TRUE;
			$data['infoMaintenance'] = FALSE;
			
			//informacion de un dayoff si lo aprobaron y lo negaron
			$data['dayoff'] = $this->dashboard_model->dayOffInfo();

			//info next planning
			$arrParam = array(
				"idUser" => $this->session->userdata("id"),
				"nextPlanning" => true
			);
			$data['infoPlanning'] = $this->general_model->get_planning_for_employee($arrParam);//info planning
										
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
			$data['infoMaintenance'] = FALSE;
			$data['noJobs'] = FALSE;
			$data['noHauling'] = TRUE;
			$data['noDailyInspection'] = FALSE;
			$data['noHeavyInspection'] = FALSE;
			
			$data['infoGenerator'] = FALSE;
			$data['infoHydrovac'] = FALSE;
			$data['infoSweeper'] = FALSE;
			$data['infoWaterTruck'] = FALSE;
						
			//informacion de un dayoff si lo aprobaron y lo negaron
			$data['dayoff'] = $this->dashboard_model->dayOffInfo();

			//info next planning
			$arrParam = array(
				"idUser" => $this->session->userdata("id"),
				"nextPlanning" => true
			);
			$data['infoPlanning'] = $this->general_model->get_planning_for_employee($arrParam);//info planning
	
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
			$data['noJobs'] = TRUE;
			$data['noHauling'] = FALSE;
			$data['noDailyInspection'] = TRUE;
			$data['noHeavyInspection'] = TRUE;
			
			//informacion de un dayoff si lo aprobaron y lo negaron
			$data['dayoff'] = $this->dashboard_model->dayOffInfo();

			//info next planning
			$arrParam = array(
				"idUser" => $this->session->userdata("id"),
				"nextPlanning" => true
			);
			$data['infoPlanning'] = $this->general_model->get_planning_for_employee($arrParam);//info planning
	
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
			$data['noJobs'] = FALSE;
			$data['noHauling'] = TRUE;
			$data['noDailyInspection'] = FALSE;
			$data['noHeavyInspection'] = FALSE;

			$data['dayoff'] = FALSE;
			$data['infoMaintenance'] = FALSE;
			$data['infoWaterTruck'] = FALSE;
			$data['infoHydrovac'] = FALSE;
			$data['infoSweeper'] = FALSE;
			$data['infoGenerator'] = FALSE;

			//info next planning
			$arrParam = array(
				"idUser" => $this->session->userdata("id"),
				"nextPlanning" => true
			);
			$data['infoPlanning'] = $this->general_model->get_planning_for_employee($arrParam);//info planning
						
			$arrParam["limit"] = 30;//Limite de registros para la consulta
			$data['info'] = $this->general_model->get_task($arrParam);//search the last 5 records 
			
			$data['infoSafety'] = $this->general_model->get_safety($arrParam);//info de safety
			
			$data["view"] = "dashboard";
			$this->load->view("layout", $data);
	}
	
	/**
	 * Management DASHBOARD
	 */
	public function management()
	{	
			$data['noJobs'] = TRUE;	
			$data['noHauling'] = TRUE;
			$data['noDailyInspection'] = TRUE;
			$data['noHeavyInspection'] = TRUE;

			$data['dayoff'] = FALSE;
			$data['infoMaintenance'] = FALSE;

			//info next planning
			$arrParam = array(
				"idUser" => $this->session->userdata("id"),
				"nextPlanning" => true
			);
			$data['infoPlanning'] = $this->general_model->get_planning_for_employee($arrParam);//info planning
						
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
			$data['noJobs'] = TRUE;	
			$data['noHauling'] = TRUE;
			$data['noDailyInspection'] = TRUE;
			$data['noHeavyInspection'] = TRUE;
			
			//informacion de un dayoff si lo aprobaron y lo negaron
			$data['dayoff'] = $this->dashboard_model->dayOffInfo();

			//info next planning
			$arrParam = array(
				"idUser" => $this->session->userdata("id"),
				"nextPlanning" => true
			);
			$data['infoPlanning'] = $this->general_model->get_planning_for_employee($arrParam);//info planning
				
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
	 * Calendario
     * @since 18/12/2020
     * @author BMOTTAG
	 */
	public function calendar()
	{
			$data["view"] = 'calendar';
			$this->load->view("layout_calendar", $data);
	}

	/**
	 * Consulta desde el calendario
     * @since 21/12/2020
     * @author BMOTTAG
	 */
    public function consulta() 
    {
	        header("Content-Type: text/plain; charset=utf-8"); //Para evitar problemas de acentos

			$start = $this->input->post('start');
			$end = $this->input->post('end');
			$start = substr($start,0,10);
			$end = substr($end,0,10);

			$arrParam = array(
				"from" => $start,
				"to" => $end
			);
			
			//informacion Work Order
			$workOrderInfo = $this->general_model->get_workorder_info($arrParam);

			//informacion Planning
			$planningInfo = $this->general_model->get_programming_info($arrParam);

			//Informacion de Payroll
			$payrollInfo = $this->general_model->get_task($arrParam);

			//Informacion de Hauling
			$haulingInfo = $this->general_model->get_hauling($arrParam);

			echo  '[';

			if($workOrderInfo)
			{
				$longitud = count($workOrderInfo);
				$i=1;
				foreach ($workOrderInfo as $data):
					echo  '{
						      "title": "W.O. #: ' . $data['id_workorder'] . ' - Job Code/Name: ' . $data['job_description'] . '",
						      "start": "' . $data['date'] . '",
						      "end": "' . $data['date'] . '",
						      "color": "green",
						      "url": "' . base_url("dashboard/info_by_day/" . $data['date']) . '"
						    }';

					if($i<$longitud){
							echo ',';
					}
					$i++;
				endforeach;
			}

			if($workOrderInfo && $planningInfo){
				echo ',';
			}

			if($planningInfo)
			{
				$longitud = count($planningInfo);
				$i=1;
				foreach ($planningInfo as $data):
					echo  '{
						      "title": "Planning. #: ' . $data['id_programming'] . ' - Job Code/Name: ' . $data['job_description'] . '",
						      "start": "' . $data['date_programming'] . '",
						      "end": "' . $data['date_programming'] . '",
						      "color": "yellow",
						      "url": "' . base_url("dashboard/info_by_day/" . $data['date_programming']) . '"
						    }';

					if($i<$longitud){
							echo ',';
					}
					$i++;
				endforeach;
			}

			if(($workOrderInfo || $planningInfo) && $haulingInfo){
				echo ',';
			}

			if($haulingInfo)
			{
				$longitud = count($haulingInfo);
				$i=1;
				foreach ($haulingInfo as $data):

        			$material = preg_replace('([^A-Za-z0-9 ])', ' ', $data['material']);
					echo  '{
						      "title": "Hauling. #: ' . $data['id_hauling'] . ' - Report done by: ' . $data['name'] . ' - Hauling done by: ' . $data['company_name'] . '  - From Site: ' . $data['site_from'] . ' - To Site: ' . $data['site_to'] . ' - Truck - Unit Number: ' . $data['unit_number'] . ' - Material Type: ' . $material . '",
						      "start": "' . $data['date_issue'] . ' ' . $data['time_in'] . '",
						      "end": "' . $data['date_issue'] . ' ' . $data['time_out'] . '",
						      "color": "red",
						      "url": "' . base_url("dashboard/info_by_day/" . $data['date_issue']) . '"
						    }';

					if($i<$longitud){
							echo ',';
					}
					$i++;
				endforeach;
			}

			if(($workOrderInfo || $planningInfo || $haulingInfo) && $payrollInfo){
				echo ',';
			}
			
			if($payrollInfo)
			{
				$longitud = count($payrollInfo);
				$i=1;
				foreach ($payrollInfo as $data):
					$startPayroll = substr($data['start'],0,10);
					$payrollInfo = "Payroll: " . $data['first_name'] . ' ' . $data['last_name'];
					$payrollInfo .=	" Job Code/Name: " . $data['job_start'];
					$payrollInfo .= " - Working Hours: " . $data['working_hours'];

					if($data['task_description']){
						$taskDescription = trim(preg_replace('/\s+/', ' ', $data['task_description']));
						$payrollInfo .= " - Task description: " . $taskDescription;
					}
					echo  '{
						      "title": "' . $payrollInfo . '",
						      "start": "' . $data['start'] . '",
						      "end": "' . $data['finish'] . '",
						      "color": "blue",
						      "url": "' . base_url("dashboard/info_by_day/" . $startPayroll) . '"
						    }';

					if($i<$longitud){
							echo ',';
					}
					$i++;
				endforeach;
			}

			echo  ']';

    }

	/**
	 * Consulta desde el calendario
     * @since 22/12/2020
     * @author BMOTTAG
	 */
	public function info_by_day($infoDate)
	{	
			$data['fecha'] = $infoDate;
			$arrParam = array(
				"fecha" => $infoDate
			);

			//informacion Planning
			$data['planningInfo'] = $this->general_model->get_programming_info($arrParam);

			//Informacion de Payroll
			$data['payrollInfo'] = $this->general_model->get_task($arrParam);
			
			//informacion Work Order
			$data['workOrderInfo'] = $this->general_model->get_workorder_info($arrParam);

			//Informacion de Hauling
			$data['haulingInfo'] = $this->general_model->get_hauling($arrParam);
		
			//Informacion de FLHA
			$data['safetyInfo'] = $this->general_model->get_safety($arrParam);//info de safety

			//Informacion de TOOL BOX
			$data['toolBoxInfo'] = $this->general_model->get_tool_box($arrParam);//info de safety

			$data["view"] = "info_by_day";
			$this->load->view("layout_calendar", $data);
	}

	/**
	 * General info
     * @since 26/12/2020
     * @author BMOTTAG
	 */
	public function settings()
	{		
			//busco datos parametricos
			$arrParam = array(
				"table" => "parametric",
				"order" => "id_parametric",
				"id" => "x"
			);
			$data['parametric'] = $this->general_model->get_basic_search($arrParam);	

			$data["view"] ='settings';
			$this->load->view("layout", $data);
	}

	/**
	 * Check In list
     * @since 5/6/2022
     * @author BMOTTAG
	 */
	public function checkin()
	{		
			$data['dashboardURL'] = $this->session->userdata("dashboardURL");

			$data['requestDate'] = date('Y-m-d');
			if($_POST){
				$data['requestDate'] = $this->input->post('date');
			}
			$arrParam = array("today" => $data['requestDate']);
			$data['checkinList'] = $this->general_model->get_checkin($arrParam);

			$data["view"] ='checkin_list';
			$this->load->view("layout", $data);
	}

	/**
	 * System changes
     * @since 21/12/2022
     * @author BMOTTAG
	 */
	public function versions()
	{		
			$data["view"] ='versions';
			$this->load->view("layout", $data);
	}

	/**
	 * Update planning confirmation
	 * @since 15/1/2022
	 */
	public function confirmPlanning()
	{
			header('Content-Type: application/json');

			$data["dashboardURL"] = $this->session->userdata("dashboardURL");
			$arrParam = array(
				"table" => "programming_worker",
				"primaryKey" => "id_programming_worker",
				"id" => $this->input->post('identificador'),
				"column" => "confirmation",
				"value" => 1
			);
			if ($this->general_model->updateRecord($arrParam)) {
				$data["result"] = true;
				$this->session->set_flashdata('retornoExito', 'You have updated the information');
			} else {
				$data["result"] = "error";
				$data["mensaje"] = "Error!!! Ask for help.";
				$this->session->set_flashdata('retornoError', '<strong>Error!!!</strong> Ask for help');
			}			

			echo json_encode($data);
	}
	
	
}