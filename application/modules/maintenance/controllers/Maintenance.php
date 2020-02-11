<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Maintenance extends CI_Controller {
	
    public function __construct() {
        parent::__construct();
        $this->load->model("maintenance_model");
		$this->load->helper('form');
    }
	
	/**
	 * Entrance
     * @since 11/2/2020
     * @author BMOTTAG
	 */
	public function entrance($idVehicle, $idMaintenance = 'x')
	{
			if (empty($idVehicle)) {
				show_error('ERROR!!! - You are in the wrong place.');
			}
			
			$data['information'] = FALSE;

			$this->load->model("general_model");			
			//worker´s list
			$data['workersList'] = $this->general_model->get_user_list();//workers list
			
			//busco datos del vehiculo
			$arrParam = array(
				"table" => "param_vehicle",
				"order" => "id_vehicle",
				"column" => "id_vehicle",
				"id" => $idVehicle
			);
			$data['vehicleInfo'] = $this->general_model->get_basic_search($arrParam);
			
			//busco tipos de mantenimiento
			$arrParam = array(
				"table" => "maintenance_type",
				"order" => "maintenance_type",
				"id" => "x"
			);
			$data['infoTypeMaintenance'] = $this->general_model->get_basic_search($arrParam);

			$data["view"] = 'form_maintenance';
			$this->load->view("layout", $data);
	}
	
	/**
	 * save maintenance
     * @since 11/2/2020
     * @author BMOTTAG
	 */
	public function save_maintenance()
	{			
			header('Content-Type: application/json');
			$data = array();
			
			$data["idRecord"] = $this->input->post('hddIdVehicle');

			if ($idEnvironmental = $this->maintenance_model->add_maintenance()) 
			{
				$data["result"] = true;
				$data["mensaje"] = "You have save the Maintenance.";
				$this->session->set_flashdata('retornoExito', 'You have save the Maintenance!!');
			} else {
				$data["result"] = "error";
				$data["mensaje"] = "Error!!! Ask for help.";
				$this->session->set_flashdata('retornoError', '<strong>Error!!!</strong> Ask for help');
			}

			echo json_encode($data);
    }
	
	
	
}