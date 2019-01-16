<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Programming extends CI_Controller {
	
    public function __construct() {
        parent::__construct();
        $this->load->model("programming_model");
		$this->load->helper('form');
    }
	
	/**
	 * Listado de programaciones
     * @since 15/1/2019
     * @author BMOTTAG
	 */
	public function index($idProgramming = 'x')
	{			
		$this->load->model("general_model");
		$data['information'] = FALSE;
		$data['informationWorker'] = FALSE;
		$data['idProgramming'] = $idProgramming;
						
		$arrParam = array("estado" => "ACTIVAS");
		$data['information'] = $this->general_model->get_programming($arrParam);//info solicitudes

		//si envio el id, entonces busco la informacion 
		if ($idProgramming != 'x') {
			$arrParam = array("idProgramming" => $idProgramming);
			$data['information'] = $this->general_model->get_programming($arrParam);//info programacion
			
			//lista de trabajadores para esta programacion
			$data['informationWorker'] = $this->general_model->get_programming_workers($arrParam);//info trabajadores

			$data['informationVehicles'] = $this->programming_model->get_vehicles_inspection();
		}

		$data["view"] = 'programming_list';
		$this->load->view("layout", $data);
	}
	
	/**
	 * Form programming
     * @since 15/1/2019
     * @author BMOTTAG
	 */
	public function add_programming($idProgramming = 'x')
	{			
		$this->load->model("general_model");
		$data['information'] = FALSE;
		
		//job´s list - (active´s items)
		$arrParam = array(
			"table" => "param_jobs",
			"order" => "job_description",
			"column" => "state",
			"id" => 1
		);
		$data['jobs'] = $this->general_model->get_basic_search($arrParam);
		
		//si envio el id, entonces busco la informacion 
		if ($idProgramming != 'x') {
			$arrParam = array("idProgramming" => $idProgramming);
			$data['information'] = $this->general_model->get_programming($arrParam);//info programacion
		}

		$data["view"] = 'form_programming';
		$this->load->view("layout", $data);
	}
	
	/**
	 * Guardar programacion
     * @since 15/1/2019
	 */
	public function save_programming()
	{			
			header('Content-Type: application/json');
			
			$idProgramming = $this->input->post('hddId');
			$idJob = $this->input->post('jobName');
			$date = $this->input->post('date');

			$msj = "You have add a new programming!!";
			$result_project = false;
			if ($idProgramming != '') {
				$msj = "You have update a programming!!";
			}else{
				//verificar si ya existe el proyecto para esa fecha
				$arrParam = array(
					"idJob" => $idJob,
					"date" => $date
				);
				$result_project = $this->programming_model->verifyProject($arrParam);
			}
			
			if ($result_project) {
				$data["result"] = "error";

				$data["mensaje"] = " Error. This project is already scheduled for that date.";
				$this->session->set_flashdata('retornoError', '<strong>Error!!!</strong> This project is already scheduled for that date.');
			} else {
			
				if ($data["idProgramming"] = $this->programming_model->saveProgramming()) 
				{					
					$data["result"] = true;
					$this->session->set_flashdata('retornoExito', $msj);
					
				} else {
					$data["result"] = "error";
					$this->session->set_flashdata('retornoError', '<strong>Error!!!</strong> Contactarse con el Administrador.');
				}
			
			}

			echo json_encode($data);
    }
		
	/**
	 * Form Add Workers
     * @since 16/1/2019
     * @author BMOTTAG
	 */
	public function add_programming_workers($idProgramming)
	{
			if (empty($idProgramming)) {
				show_error('ERROR!!! - You are in the wrong place.');
			}
			
			$this->load->model("general_model");
			
			$arrParam = array("idProgramming" => $idProgramming);
			$data['infoProgramming'] = $this->general_model->get_programming($arrParam);//info programacion
			
			//workers list
			$arrParam = array();
			$data['workersList'] = $this->general_model->get_user_list($arrParam);//workers list
			
			$data["idProgramming"] = $idProgramming;
			$data["view"] = 'form_add_workers';
			$this->load->view("layout", $data);
	}
	
	/**
	 * Save worker
     * @since 16/1/2019
     * @author BMOTTAG
	 */
	public function save_programming_workers()
	{			
			header('Content-Type: application/json');
			$data = array();
			$data["idProgramming"] = $this->input->post('hddId');

			if ($this->programming_model->addProgrammingWorker()) 
			{
				$data["result"] = true;
				$data["mensaje"] = "Solicitud guardada correctamente.";
				
				$this->session->set_flashdata('retornoExito', 'You have add the Workers, if they are going to use a machine remember to assign it to the worker.');
			} else {
				$data["result"] = "error";
				$data["mensaje"] = "Error al guardar. Intente nuevamente o actualice la p\u00e1gina.";
				
				$this->session->set_flashdata('retornoError', '<strong>Error!!!</strong> Ask for help');
			}

			echo json_encode($data);
    }
	
	/**
	 * Delete programming
     * @since 8/7/2018
	 */
	public function delete_programming()
	{			
			header('Content-Type: application/json');
			$data = array();
			
			$idProgramming = $this->input->post('identificador');
			
			if ($this->programming_model->deleteProgramming()) 
			{				
				$data["result"] = true;
				$this->session->set_flashdata('retornoExito', 'You have delete the record.');
			} else {
				$data["result"] = "error";
				$data["mensaje"] = "Error!!! Contactarse con el Administrador.";
				$this->session->set_flashdata('retornoError', '<strong>Error!!!</strong> Ask for help');
			}				

			echo json_encode($data);
    }
	
	/**
	 * Update datos trabajdores
     * @since 16/1/2019
     * @author BMOTTAG
	 */
	public function update_worker()
	{					
			$idProgramming = $this->input->post('hddIdProgramming');

			if ($this->programming_model->saveWorker()) {
				$data["result"] = true;
				$this->session->set_flashdata('retornoExito', "You have update the record!!");
			} else {
				$data["result"] = "error";
				$this->session->set_flashdata('retornoError', '<strong>Error!!!</strong> Ask for help');
			}

			redirect(base_url('programming/index/' . $idProgramming), 'refresh');
    }
		
	public function calendar()
	{
		$this->load->model("general_model");
				
		$arrParam = array("estado" => "ACTIVAS");
		$data['information'] = $this->general_model->get_programming($arrParam);//info solicitudes
		
		$data["view"] = 'calendar';
		$this->load->view("layout", $data);
	}
	


	
}