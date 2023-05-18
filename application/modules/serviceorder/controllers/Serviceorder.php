<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Serviceorder extends CI_Controller {
	
    public function __construct() {
        parent::__construct();
        $this->load->model("serviceorder_model");
    }
	
	/**
	 * Service Order list
     * @since 18/5/2023
     * @author BMOTTAG
	 */
	public function index()
	{		
			//service order info
			$arrParam = array();
			$data['information'] = $this->serviceorder_model->get_service_order($arrParam);

			$data["view"] ='service_order_list';
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

			$this->load->model("general_model");	
			//buscar la lista de tipo de equipmentType
			$arrParam = array(
				"table" => "param_vehicle_type_2",
				"order" => "type_2",
				"column" => "show_serviceorder",
				"id" => 1
			);
			$data['equipmentType'] = $this->general_model->get_basic_search($arrParam);//equipmentType list
			
			if ($data["idServiceOrder"] != 'x') {
				//Service Order info
				$arrParam = array(
					"idServiceOrder" => $data["idServiceOrder"]
				);				
				$data['information'] = $this->serviceorder_model->get_service_order($arrParam);

				$company = 1;
				$type = $data['information'][0]['fk_id_type_2'];
				$this->load->model("general_model");
				$data['equipmentList'] = $this->general_model->get_trucks_by_id2($company, $type);
			}
			
			$this->load->view("service_order_modal", $data);
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

}