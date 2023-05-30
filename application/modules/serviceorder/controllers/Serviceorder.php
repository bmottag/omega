<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Serviceorder extends CI_Controller {
	
    public function __construct() {
        parent::__construct();
        $this->load->model("serviceorder_model");
    }
	
	/**
	 * Service Order Control Panel
     * @since 19/5/2023
     * @author BMOTTAG
	 */
	public function index()
	{		
			$this->load->model("general_model");
			$data['infoEquipment'] = $this->general_model->countEquipmentByType();

			$data["view"] ='dashboard_so';
			$this->load->view("layout", $data);
	}

    /**
     * Cargo modal - service order
     * @since 18/5/2023
     */
    public function cargarModalServiceOrder() 
	{
			header("Content-Type: text/plain; charset=utf-8"); //Para evitar problemas de acentos
			
			$data['information'] = FALSE;
			$data["idServiceOrder"] = $this->input->post("idServiceOrder");

			//worker list
			$arrParam = array("state" => 1);
			$this->load->model("general_model");
			$data['workersList'] = $this->general_model->get_user($arrParam);//worker list

			$arrParam = array(
				"table" => "param_status",
				"order" => "status_order",
				"column" => "status_key",
				"id" => "priority"
			);
			$data['priorityList'] = $this->general_model->get_basic_search($arrParam);

			if ($data["idServiceOrder"] != 'x') {
				//status list
				$arrParam = array(
					"table" => "param_status",
					"order" => "status_order",
					"column" => "status_key",
					"id" => "serviceorder"
				);
				$data['statusList'] = $this->general_model->get_basic_search($arrParam);

				//Service Order info
				$arrParam = array(
					"idServiceOrder" => $data["idServiceOrder"]
				);				
				$data['information'] = $this->serviceorder_model->get_service_order($arrParam);

				$data['maintenanceType'] = $data['information'][0]["maintenace_type"];
				$idMaintenance = $data['information'][0]["fk_id_maintenace"];
			}else{
				$data['maintenanceType']  = $this->input->post("maintenanceType");
				$idMaintenance = $this->input->post("idMaintenance");
			}

			$arrParam = array("idMaintenance" => $idMaintenance);	
			if ($data['maintenanceType'] == "corrective") {			
				$infoMaintenance = $this->serviceorder_model->get_corrective_maintenance($arrParam);
				$data['maintenanceDescription'] = $infoMaintenance[0]["description_failure"]; 
				$data['maintenanceTypeDescription'] = "Corrective Maintenance"; 
			}else{
				$infoMaintenance = $this->serviceorder_model->get_preventive_maintenance($arrParam);
				$data['maintenanceDescription'] = $infoMaintenance[0]["maintenance_description"]; 
				$data['maintenanceTypeDescription'] = "Preventive Maintenance"; 
			}
			
			$this->load->view("service_order_modal", $data);
    }

    /**
     * Cargo modal - Preventive Maintenace
     * @since 23/5/2023
     */
    public function cargarModalPreventiveMaintenance() 
	{
			header("Content-Type: text/plain; charset=utf-8"); //Para evitar problemas de acentos
			
			$data['information'] = FALSE;
			$data["idMaintenance"] = $this->input->post("idMaintenance");
			//busco tipos de mantenimiento
			$arrParam = array(
				"table" => "maintenance_type",
				"order" => "maintenance_type",
				"id" => "x"
			);
			$this->load->model("general_model");
			$data['infoTypeMaintenance'] = $this->general_model->get_basic_search($arrParam);
			
			if ($data["idMaintenance"] != 'x') {
				$arrParam = array(
					"idMaintenance" => $data["idMaintenance"]
				);				
				$data['information'] = $this->serviceorder_model->get_preventive_maintenance($arrParam);
			}
			
			$this->load->view("preventive_maintenance_modal", $data);
    }

	/**
	 * Save Service Order
     * @since 18/5/2023
     * @author BMOTTAG
	 */
	public function save_service_order()
	{			
			header('Content-Type: application/json');
			$data = array();
			
			$idServiceOrder = $this->input->post('hddIdServiceOrder');
			$data["idEquipment"] = $this->input->post('hddIdEquipment');
			$maintenace_type = $this->input->post('hddMaintenanceType');
			$status = $this->input->post('status');
			$this->load->model("general_model");
			
			$msj = "You have added a new Service Order!!";
			if ($idServiceOrder != '') {
				$msj = "You have updated the Service Order!!";
			}

			if ($this->serviceorder_model->saveServiceOrder()) {
				if ($idServiceOrder == '' && $maintenace_type == "corrective") {
					//change corrective maintenance status to in_progress
					$arrParam = array(
						"table" => "corrective_maintenance",
						"primaryKey" => "id_corrective_maintenance",
						"id" => $this->input->post('hddIdMaintenance'),
						"column" => "maintenance_status",
						"value" => "in_progress"
					);
					$this->general_model->updateRecord($arrParam);
				}elseif ($idServiceOrder != '' && $maintenace_type == "corrective" && $status == "closed_so" ) {
					//change corrective maintenance status to closed
					$arrParam = array(
						"table" => "corrective_maintenance",
						"primaryKey" => "id_corrective_maintenance",
						"id" => $this->input->post('hddIdMaintenance'),
						"column" => "maintenance_status",
						"value" => "closed"
					);
					$this->general_model->updateRecord($arrParam);
				}
				$data["result"] = true;
				$this->session->set_flashdata('retornoExito', $msj);
			} else {
				$data["result"] = "error";			
				$this->session->set_flashdata('retornoError', '<strong>Error!!!</strong> Ask for help');
			}

			echo json_encode($data);	
    }

	/**
	 * Equipment List
     * @since 20/5/2022
     * @author BMOTTAG
	 */
    public function equipmentList() 
	{
        header("Content-Type: text/plain; charset=utf-8"); //Para evitar problemas de acentos

		//busco info de vehiculo
		$this->load->model("general_model");
		$data['subTitle'] = $this->input->post('headerInspectionType'); 
		$arrParam = array(
			"vehicleType" => $this->input->post('inspectionType'),
			"vinNumber" => $this->input->post('vinNumber'),
			"vehicleState" => 1
		);
		$data["vehicleInfo"] = $this->general_model->get_vehicle_by($arrParam);//busco datos del vehiculo
		
		if($data["vehicleInfo"] )
		{
			echo $this->load->view("equipment_list", $data);
		}else{				
			echo "<p class='text-danger'>There are no records.</p>";
		}
	}

	/**
	 * Equipment Detail
     * @since 21/5/2022
     * @author BMOTTAG
	 */
    public function equipmentDetail() 
	{
        header("Content-Type: text/plain; charset=utf-8"); //Para evitar problemas de acentos

		//busco info de vehiculo
		$this->load->model("general_model");
		$arrParam = array(
			"idVehicle" => $this->input->post('equipmentId')
		);
		$data["vehicleInfo"] = $this->general_model->get_vehicle_by($arrParam);//busco datos del vehiculo

		$data["tabview"] = $this->input->post('tabview');

		if($data["tabview"] == "tab_service_order"){
			$data['information'] = $this->serviceorder_model->get_service_order($arrParam);
		}elseif($data["tabview"] == "tab_corrective_maintenance"){
			$data['infoCorrectiveMaintenance'] = $this->serviceorder_model->get_corrective_maintenance($arrParam);
		}elseif($data["tabview"] == "tab_preventive_maintenance"){
			$data['infoPreventiveMaintenance'] = $this->serviceorder_model->get_preventive_maintenance($arrParam);
		}elseif($data["tabview"] == "tab_inspections"){
			$data['infoInspections'] = $this->general_model->get_vehicle_oil_change($data['vehicleInfo']);//vehicle oil change history
		}elseif($data["tabview"] == "tab_service_order_detail"){
			$arrParam["idServiceOrder"] = $this->input->post('serviceOrderId');
			$data['information'] = $this->serviceorder_model->get_service_order($arrParam);
			$arrParam = array(
				"idModule" => $this->input->post('serviceOrderId'),
				"module" => ID_MODULE_SERVICE_ORDER
			);
			$data['chatInfo'] = $this->general_model->get_chat_info($arrParam);
		}

		if($data["vehicleInfo"] )
		{
			echo $this->load->view("equipment_detail", $data);
		}else{				
			echo "<p class='text-danger'>There are no records.</p>";
		}
	}

	/**
	 * Save Preventive Maintenance
     * @since 22/5/2023
     * @author BMOTTAG
	 */
	public function save_preventive_maintenance()
	{			
			header('Content-Type: application/json');
			$data = array();

			$idMaintenance = $this->input->post('hddIdMaintenance');
			$data["idEquipment"] = $this->input->post('hddIdEquipment');
			
			$msj = "You have added a new Preventive Maintenance!!";
			if ($idMaintenance != '') {
				$msj = "You have updated the Preventive Maintenance!!";
			}

			if ($idMaintenance = $this->serviceorder_model->savePreventiveMaintenance()) {
				$data["result"] = true;
				$this->session->set_flashdata('retornoExito', $msj);
			} else {
				$data["result"] = "error";			
				$this->session->set_flashdata('retornoError', '<strong>Error!!!</strong> Ask for help');
			}
			echo json_encode($data);	
    }

    /**
     * Cargo modal - Corrective Maintenace
     * @since 26/5/2023
     */
    public function cargarModalCorrectiveMaintenance() 
	{
			header("Content-Type: text/plain; charset=utf-8"); //Para evitar problemas de acentos
			
			$data['information'] = FALSE;
			$data["idMaintenance"] = $this->input->post("idMaintenance");
			
			if ($data["idMaintenance"] != 'x') {
				$arrParam = array(
					"idMaintenance" => $data["idMaintenance"]
				);				
				$data['information'] = $this->serviceorder_model->get_corrective_maintenance($arrParam);
			}
			
			$this->load->view("corrective_maintenance_modal", $data);
    }

	/**
	 * Save Corrective Maintenance
     * @since 26/5/2023
     * @author BMOTTAG
	 */
	public function save_corrective_maintenance()
	{			
			header('Content-Type: application/json');
			$data = array();

			$idMaintenance = $this->input->post('hddIdMaintenance');
			$data["idEquipment"] = $this->input->post('hddIdEquipment');
			
			$msj = "You have added a new Corrective Maintenance!!";
			if ($idMaintenance != '') {
				$msj = "You have updated the Corrective Maintenance!!";
			}

			if ($idMaintenance = $this->serviceorder_model->saveCorrectiveMaintenance()) {
				$data["result"] = true;
				$this->session->set_flashdata('retornoExito', $msj);
			} else {
				$data["result"] = "error";			
				$this->session->set_flashdata('retornoError', '<strong>Error!!!</strong> Ask for help');
			}
			echo json_encode($data);	
    }

	/**
	 * Save chat
     * @since 29/5/2023
     * @author BMOTTAG
	 */
	public function save_chat()
	{	
			header('Content-Type: application/json');
			$data["idEquipment"] = $this->input->post('hddIdEquipment');
			$data["view"] = $this->input->post('hddView');
			$data["idModule"] = $this->input->post('hddId');
			
			if ($this->serviceorder_model->saveChat()) {
				$data["result"] = true;
				$this->session->set_flashdata('retornoExito', "You have added a message");
			} else {
				$data["result"] = "error";
				$this->session->set_flashdata('retornoError', '<strong>Error!!!</strong> Ask for help');
			}
			echo json_encode($data);

	}


}