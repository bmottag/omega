<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Prices extends CI_Controller {
	
    public function __construct() {
        parent::__construct();
		$this->load->model("prices_model");
    }
	
	/**
	 * Lista de precios para tipos de empleados
     * @since 5/11/2020
     * @author BMOTTAG
	 */
	public function employeeTypeUnitPrice($idJob)
	{
			$this->load->model("general_model");
			$data['information'] = FALSE;

			//job info
			$arrParam = array(
				"table" => "param_jobs",
				"order" => "job_description",
				"column" => "id_job",
				"id" => $idJob
			);
			$data['jobInfo'] = $this->general_model->get_basic_search($arrParam);

			//job_employee_type_unit_price list
			$data['employeeTypeUnitPrice'] = $this->general_model->get_job_employee_type_unit_price($idJob);				

			$data["view"] = "employeeTypeUnitPrice_list";
			$this->load->view("layout", $data);
	}
	
	/**
	 * Load employee types
     * @since 5/11/2020
     * @author BMOTTAG
	 */
	public function load_employee_type()
	{			
			header('Content-Type: application/json');
			$data = array();
			
			$data["idJob"] = $this->input->post('identificador');
			
			$this->load->model("general_model");
			$arrParam = array(
				"table" => "param_employee_type",
				"order" => "employee_type",
				"id" => "x"
			);
			$employeeTypeUnitPrice = $this->general_model->get_basic_search($arrParam);			

//falta cargar historial de estos cambios

			if ($this->prices_model->add_employee_type($employeeTypeUnitPrice)) 
			{				
				$data["result"] = true;
				$this->session->set_flashdata('retornoExito', 'You have load the data.');
			} else {
				$data["result"] = "error";
				$data["mensaje"] = "Error!!! Contactarse con el Administrador.";
				$this->session->set_flashdata('retornoError', '<strong>Error!!!</strong> Ask for help');
			}				

			echo json_encode($data);
    }

	
	
}