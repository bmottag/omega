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
			
			if ($data["idServiceOrder"] != 'x') {
				//status list
				$arrParam = array(
					"table" => "param_status",
					"order" => "status_name",
					"column" => "status_key",
					"id" => "serviceorder"
				);
				$this->load->model("general_model");	
				$data['statusList'] = $this->general_model->get_basic_search($arrParam);

				//Service Order info
				$arrParam = array(
					"idServiceOrder" => $data["idServiceOrder"]
				);				
				$data['information'] = $this->serviceorder_model->get_service_order($arrParam);
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
			
			$msj = "You have added a new Service Order!!";
			if ($idServiceOrder != '') {
				$msj = "You have updated the Service Order!!";
			}

			if ($idServiceOrder = $this->serviceorder_model->saveServiceOrder()) {
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
		}elseif($data["tabview"] == "tab_preventive_maintenance"){
			$data['infoPreventiveMaintenance'] = $this->serviceorder_model->get_preventive_maintenance($arrParam);
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

			$data["idEquipment"] = $this->input->post('hddIdEquipment');			
			$msj = "You have added a new Preventive Maintenance!!";

			if ($idServiceOrder = $this->serviceorder_model->savePreventiveMaintenance()) {
				$data["result"] = true;
				$this->session->set_flashdata('retornoExito', $msj);
			} else {
				$data["result"] = "error";			
				$this->session->set_flashdata('retornoError', '<strong>Error!!!</strong> Ask for help');
			}
			echo json_encode($data);	
    }


}