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
	public function entrance($idVehicle)
	{
			if (empty($idVehicle)) {
				show_error('ERROR!!! - You are in the wrong place.');
			}
			
			$this->load->model("general_model");			
						
			//busco datos del vehiculo
			$arrParam['idVehicle'] = $idVehicle;
			$data['vehicleInfo'] = $this->general_model->get_vehicle_by($arrParam);
									
			//listado de registros para ese vehiculo
			$arrParam = array("idVehicle" => $idVehicle);				
			$data['infoRecords'] = $this->maintenance_model->get_maintenance($arrParam);
			
			$data["view"] = 'maintenance_list';
			$this->load->view("layout", $data);
	}
	
	/**
	 * Maintenance form
     * @since 22/3/2020
     * @author BMOTTAG
	 */
	public function maintenance_form($idVehicle, $idMaintenance = 'x')
	{
			if (empty($idVehicle)) {
				show_error('ERROR!!! - You are in the wrong place.');
			}
			
			$data['information'] = FALSE;

			$this->load->model("general_model");			
			//worker´s list
			$data['workersList'] = $this->general_model->get_user_list();//workers list
						
			//busco datos del vehiculo
			$arrParam['idVehicle'] = $idVehicle;
			$data['vehicleInfo'] = $this->general_model->get_vehicle_by($arrParam);
			
			//busco tipos de mantenimiento
			$arrParam = array(
				"table" => "maintenance_type",
				"order" => "maintenance_type",
				"id" => "x"
			);
			$data['infoTypeMaintenance'] = $this->general_model->get_basic_search($arrParam);
			
			//busco info tabla de stock
			$data['infoStock'] = $this->general_model->get_stock();
						
			//si envio el id, entonces busco la informacion 
			if ($idMaintenance != 'x') 
			{
				$arrParam = array("idMaintenance" => $idMaintenance);				
				$data['information'] = $this->maintenance_model->get_maintenance($arrParam);
			}			

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
			$hddIdMaintenance = $this->input->post('hddIdMaintenance');

			//para el mismo tipo de mantenimiento
			//actualizo los estados a 2 (inactivo) si es un mantenimiento nuevo
			if($hddIdMaintenance == '')
			{
				$this->maintenance_model->update_maintenance_state();
			}

			if ($idMaintenance = $this->maintenance_model->add_maintenance()) 
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
	
	/**
	 * Maintenance Check
	 */
	public function maintenance_check()
	{				
		$fecha = date('Y-m-d');
		$filtroFecha = strtotime ( '+7 day' , strtotime ( $fecha ) ) ;

		//listado de registros mantenimientos activos
		$arrParam = array("maintenanceState" => 1);
		$infoMaintenance = $this->maintenance_model->get_maintenance($arrParam);	

		$this->maintenance_model->delete_maintenance_check();//elimino los registros de maintenance_check
		//revisar cuales estan proximo a vencerse por kilometros o fechas
		foreach ($infoMaintenance as $lista):
			$diferencia = $lista["next_hours_maintenance"] - $lista["hours"];
			
			if($lista["fk_id_maintenance_type"] == 8 || $lista["fk_id_maintenance_type"] == 9){
				$diferencia = $lista["hours_2"] - $lista["next_hours_maintenance"];
			}elseif($lista["fk_id_maintenance_type"] == 10){
				$diferencia = $lista["hours_3"] - $lista["next_hours_maintenance"];
			}
				
			$nextDateMaintenance = strtotime($lista["next_date_maintenance"]);
			
			if(($lista["next_hours_maintenance"] != 0 && $diferencia <= 100) || ($lista["next_date_maintenance"] != "" && $nextDateMaintenance <= $filtroFecha)){
				$this->maintenance_model->add_maintenance_check($lista["id_maintenance"]);
			}
		endforeach;
		
		redirect("/dashboard/maintenance","location",301);
	}
	
	
	
}