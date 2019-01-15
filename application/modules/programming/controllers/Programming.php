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
		$data['idProgramming'] = $idProgramming;
						
		$arrParam = array("estado" => "ACTIVAS");
		$data['information'] = $this->general_model->get_programming($arrParam);//info solicitudes

		//si envio el id, entonces busco la informacion 
		if ($idProgramming != 'x') {
			$arrParam = array("idProgramming" => $idProgramming);
			$data['information'] = $this->general_model->get_programming($arrParam);//info programacion
			
			//lista de trabajadores para esta programacion
			$data['informationWorker'] = $this->general_model->get_programming_workers($arrParam);//info inspecciones
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
     * @since 2/7/2018
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
			
				if ($idProgramming = $this->programming_model->saveProgramming()) 
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
	 * lista de trabajadores disponibles
     * @since 1/7/2018
     * @author BMOTTAG
	 */
	public function workers()
	{		
		$this->load->model("general_model");
		$arrParam = array();
		$data['info'] = $this->general_model->get_programming_user_list($arrParam);

		$data["view"] = 'workers';
		$this->load->view("layout", $data);
	}
	
    /**
     * Cargo modal - formulario usuarios
     * @since 1/7/2018
     */
    public function cargarModalWorkers() 
	{
			header("Content-Type: text/plain; charset=utf-8"); //Para evitar problemas de acentos
			
			$data['information'] = FALSE;
			$idUser = $this->input->post("idUser");	
			
			if ($idUser != 'x') {
				$this->load->model("general_model");
				$arrParam = array("idUser" => $idUser);
				$data['information'] = $this->general_model->get_programming_user_list($arrParam);
			}
			
			$this->load->view("workers_modal", $data);
    }
	
	/**
	 * Update workers
     * @since 1/6/2018
     * @author BMOTTAG
	 */
	public function save_workers()
	{			
			header('Content-Type: application/json');
			$data = array();
			
			$idUser = $this->input->post('hddIdUser');
			
			$msj = "You have add a new user!!";
			if ($idUser != '') {
				$msj = "You have update an user!!";
			}

			if ($idUser = $this->programming_model->saveUser()) {
				$data["result"] = true;
				$this->session->set_flashdata('retornoExito', $msj);
			} else {
				$data["result"] = "error";
				$this->session->set_flashdata('retornoError', '<strong>Error!!!</strong> Ask for help');
			}

			echo json_encode($data);	
    }
	
	/**
	 * lista de skills
     * @since 1/7/2018
     * @author BMOTTAG
	 */
	public function skills()
	{		
		$this->load->model("general_model");
		$arrParam = array(
			"table" => "programming_skills",
			"order" => "id_programming_skill",
			"id" => "x"
		);
		$data['info'] = $this->general_model->get_basic_search($arrParam);
		
		$data["view"] = 'skills';
		$this->load->view("layout", $data);
	}
		
	/**
	 * Form Add Workers
     * @since 4/7/2018
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
			$data['workersList'] = $this->general_model->get_programming_user_list($arrParam);//workers list
			
			$view = 'form_add_workers';
			$data["idProgramming"] = $idProgramming;
			$data["view"] = $view;
			$this->load->view("layout", $data);
	}
	
	/**
	 * Save worker
     * @since 4/7/2018
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
				
				//actualizo el estado de la programacion -> dependiento si se completaron o no la cantidad de trabajadores
				$updateState = $this->update_state($data["idProgramming"]);
				
				$this->session->set_flashdata('retornoExito', 'You have add the Workers, remember to get the signature of each one.');
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
	 * Actualizo estado de la programacion 2 si esta completa 1 si esta incompleta
     * @since 10/7/2018
	 */
    function update_state($idProgramming) 
	{
			//programming info
			$this->load->model("general_model");
			
			//busco la cantidad en la programacion
			$arrParam = array("idProgramming" => $idProgramming);
			$data['information'] = $this->general_model->get_programming($arrParam);//info programacion
			
			$quantity = $data['information'][0]['quantity'];
						
			//cuento la cantidad de trabajadores guardados en la base de datos
			$countWorkers = $this->programming_model->countWorkers($idProgramming);
			
			$state = 2; //incompleta
			if($quantity > $countWorkers){
				$state = 1; //completa
			}

			//guardo estado de la programacion			
			$arrParam = array(
				"table" => "programming",
				"primaryKey" => "id_programming",
				"id" => $idProgramming,
				"column" => "state",
				"value" => $state
			);
			
			if ($this->general_model->updateRecord($arrParam)) {
				return TRUE;
			}else{
				return FALSE;
			}
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