<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Safety extends CI_Controller {
	
    public function __construct() {
        parent::__construct();
        $this->load->model("safety_model");
		$this->load->helper('form');
    }

	/**
	 * Form Add Safety
     * @since 1/12/2016
     * @author BMOTTAG
	 */
	public function add_safety($idJob, $idSafety = 'x')
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
			
			//hazards list
			$data['hazards'] = $this->general_model->get_job_hazards($idJob);
			
			//worker´s list
			$arrParam = array(
				"table" => "user",
				"order" => "first_name, last_name",
				"id" => "x"
			);
			$data['workersList'] = $this->general_model->get_basic_search($arrParam);
					
			//si envio el idSafety, entonces busco la informacion 
			if ($idSafety != 'x') {
				$data['information'] = $this->safety_model->get_safety_by_id($idSafety);//info safety
			}			

			$data["view"] = 'form_add_safety';
			$this->load->view("layout", $data);
	}
	
	/**
	 * Form Upload Hazar and Workers
     * @since 4/12/2016
     * @author BMOTTAG
	 */
	public function upload_info_safety($id = 'x')
	{
			$this->load->model("general_model");
			$data['information'] = FALSE;
			$data['safetyClose'] = FALSE;
			$view = 'form_upload_info_safety';
			//job´s list - (active´s items)
			$arrParam = array(
				"table" => "param_jobs",
				"order" => "job_description",
				"column" => "state",
				"id" => 1
			);
			$data['jobs'] = $this->general_model->get_basic_search($arrParam);
						
			$arrParam = array(
				"table" => "param_company",
				"order" => "company_name",
				"column" => "company_type",
				"id" => 2
			);
			$data['companyList'] = $this->general_model->get_basic_search($arrParam);//company list
					
			//si envio el id, entonces busco la informacion 
			if ($id != 'x') {
				
				$arrParam = array(
					"table" => "param_hazard",
					"order" => "id_hazard",
					"id" => "x"
				);
				$data['hazardList'] = $this->general_model->get_basic_search($arrParam);//hazards´s list, para adicionar mas hazards
				
				//workers list
				$this->load->model("general_model");
				$data['workersList'] = $this->general_model->get_user_list();//workers list
				
				//safety_hazard list
				$data['safetyHazard'] = $this->safety_model->get_safety_hazard($id);
				//safety_workes list
				$data['safetyWorkers'] = $this->safety_model->get_safety_workers($id);
				//safety subcontractors workers list
				$data['safetySubcontractorsWorkers'] = $this->safety_model->get_safety_subcontractors_workers($id);

				$data['information'] = $this->safety_model->get_safety_by_id($id);//info safety
				
				//consultar si esta cerrado, sino entonces verificar si es un dia diferente para cerrarlo		
				if($data['information'][0]['state'] == 2){
					$data['safetyClose'] = TRUE;
					$view = 'view_safety';
				}else{
					date_default_timezone_set('America/Phoenix');
					$today = date("Y-m-d"); //fecha actual
				
					$safetyDate = strtotime ( $data['information'][0]['date'] ) ;
					$safetyDate = date ( 'Y-m-d' , $safetyDate ); //fecha del safety
					
				/* SE DEBE CAMBIAR AHORA SE CIERRA CADA 7 DIAS	
					if($today != $safetyDate){//si es diferente entonces cerrar el formulario de safety
						$arrParam = array(
							"table" => "safety",
							"primaryKey" => "id_safety",
							"id" => $id,
							"column" => "state",
							"value" => 2
						);
						$this->load->model("general_model");
						$this->general_model->updateRecord($arrParam);//actualizo el estado del formulario a cerrado(2)
						
						$data['safetyClose'] = TRUE;
						$view = 'view_safety';
					}
					
				*/
					
				}
			}			

			$data["view"] = $view;
			$this->load->view("layout", $data);
	}
	
	/**
	 * Update safety state
     * @since 4/2/2017
     * @author BMOTTAG
	 */
	public function update_safety_state()
	{			
			header('Content-Type: application/json');
			$data = array();
			
			$data["idSafety"] = $this->input->post('hddIdentificador');

			$arrParam = array(
				"table" => "safety",
				"primaryKey" => "id_safety",
				"id" => $data["idSafety"],
				"column" => "state",
				"value" => 2
			);
			$this->load->model("general_model");
			
			//actualizo el estado del formulario a cerrado(2)
			if ($this->general_model->updateRecord($arrParam)) {
				$data["result"] = true;
				$data["mensaje"] = "You have close the Safety Report.";
				$this->session->set_flashdata('retornoExito', 'You have close the Safety Report');
			} else {
				$data["result"] = "error";
				$data["mensaje"] = "Error!!! Ask for help.";
				$this->session->set_flashdata('retornoError', '<strong>Error!!!</strong> Ask for help');
			}

			echo json_encode($data);
    }
	
	/**
	 * Save safety
     * @since 03/12/2016
     * @author BMOTTAG
	 */
	public function save_safety()
	{			
			header('Content-Type: application/json');
			$data = array();
			
			//hazards list
			$this->load->model("general_model");
			$idJob = $this->input->post('hddIdJob');
			$hazards = $this->general_model->get_job_hazards($idJob);

			if ($idSafety = $this->safety_model->add_safety($hazards)) {
				$data["result"] = true;
				$data["mensaje"] = "Solicitud guardada correctamente.";
				$data["idSafety"] = $idSafety;
				$this->session->set_flashdata('retornoExito', 'You have save your FLHA record, do not forget to add Workers and signatures.');
			} else {
				$data["result"] = "error";
				$data["mensaje"] = "Error al guardar. Intente nuevamente o actualice la p\u00e1gina.";
				$data["idSafety"] = "";
				$this->session->set_flashdata('retornoError', '<strong>Error!!!</strong> Ask for help');
			}

			echo json_encode($data);
    }
	
	/**
	 * Form Add Workers
     * @since 10/12/2016
     * @author BMOTTAG
	 */
	public function add_workers($id)
	{
			if (empty($id)) {
				show_error('ERROR!!! - You are in the wrong place.');
			}
			
			//workers list
			$this->load->model("general_model");
			$data['workersList'] = $this->general_model->get_user_list();//workers list
			
			$view = 'form_add_workers';
			$data["idSafety"] = $id;
			$data["view"] = $view;
			$this->load->view("layout", $data);
	}
	
	/**
	 * Save worker
     * @since 06/12/2016
     * @author BMOTTAG
	 */
	public function save_safety_workers()
	{			
			header('Content-Type: application/json');
			$data = array();
			$idSafety = $this->input->post('hddId');

			if ($this->safety_model->add_safety_worker($idSafety)) {
				$data["result"] = true;
				$data["mensaje"] = "Solicitud guardada correctamente.";
				$data["idSafety"] = $idSafety;
				
				$this->session->set_flashdata('retornoExito', 'You have add the Workers, remember to get the signature of each one.');
			} else {
				$data["result"] = "error";
				$data["mensaje"] = "Error al guardar. Intente nuevamente o actualice la p\u00e1gina.";
				$data["idSafety"] = "";
				
				$this->session->set_flashdata('retornoError', '<strong>Error!!!</strong> Ask for help');
			}

			echo json_encode($data);
    }
	
	/**
	 * Form Add Hazards
     * @since 10/12/2016
     * @author BMOTTAG
	 */
	public function add_hazards($id)
	{
			if (empty($id)) {
				show_error('ERROR!!! - You are in the wrong place.');
			}
			
			$data['activityList'] = $this->safety_model->get_activity_list();//activity list
			
			

			$data["idSafety"] = $id;
			$data["view"] = 'form_add_hazards';
			$this->load->view("layout", $data);
	}
	
	/**
	 * Save hazards
     * @since 06/12/2016
	 * @review 10/12/2016
     * @author BMOTTAG
	 */
	public function save_safety_hazards()
	{			
			header('Content-Type: application/json');
			$data = array();
			$idSafety = $this->input->post('hddId');

			if ($this->safety_model->add_safety_hazard($idSafety)) {
				$data["result"] = true;
				$data["idSafety"] = $idSafety;
				
				$this->session->set_flashdata('retornoExito', 'You have add Hazards, remember to select the priority of each one.');
			} else {
				$data["result"] = "error";
				$data["idSafety"] = "";
				
				$this->session->set_flashdata('retornoError', '<strong>Error!!!</strong> Ask for help');
			}

			echo json_encode($data);
    }	
	
    /**
     * Cargo modal- formulario de captura hazard
     * @since 10/12/2016
     */
    public function cargarModalPrioridad() 
	{
			header("Content-Type: text/plain; charset=utf-8"); //Para evitar problemas de acentos

			$data["idHazard"] = $this->input->post("idHazard");
		
			$data['hazardInfo'] = $this->safety_model->get_safety_hazard_byIdHazard($data["idHazard"]);//info del safety hazard
			
			$data["idSafety"] = $data['hazardInfo']['fk_id_safety'];//para pasarlo al formulario
			//priority list
			$this->load->model("general_model");
			$arrParam = array(
				"table" => "param_hazard_priority",
				"order" => "id_priority",
				"id" => "x"
			);
			$data['priority'] = $this->general_model->get_basic_search($arrParam);

			$this->load->view("modal_safety_priority", $data);
    }
	
	/**
	 * Save hazard
     * @since 10/12/2016
     * @author BMOTTAG
	 */
	public function save_hazard_priority()
	{			
			header('Content-Type: application/json');
			$data = array();
			$idSafety = $this->input->post('hddIdSafety');
			
			$arrParam = array(
				"table" => "safety_hazards",
				"primaryKey" => "id_safety_hazard",
				"id" => $this->input->post('hddIdHazard'),
				"column" => "fk_id_priority",
				"value" => $this->input->post('priority')
			);
			$this->load->model("general_model");
			if ($this->general_model->updateRecord($arrParam)) {//UPDATE HAZARD PRIORITY
				$data["result"] = true;
				$data["idSafety"] = $idSafety;
				
				$this->session->set_flashdata('retornoExito', 'You have update hazard´s priority!!');
			} else {
				$data["result"] = "error";
				$data["idSafety"] = "";
				
				$this->session->set_flashdata('retornoError', '<strong>Error!!!</strong> Ask for help');
			}

			echo json_encode($data);
    }
	
    /**
     * Delete safety worker
     */
    public function deleteSafetyWorker($idSafetyWorker, $idSafety) 
	{
			if (empty($idSafetyWorker) || empty($idSafety) ) {
				show_error('ERROR!!! - You are in the wrong place.');
			}
		
			$arrParam = array(
				"table" => "safety_workers",
				"primaryKey" => "id_safety_worker",
				"id" => $idSafetyWorker
			);

			if ($this->safety_model->deleteRecord($arrParam)) {
				$this->session->set_flashdata('retornoExito', 'You have delete one worker.');
			} else {
				$this->session->set_flashdata('retornoError', '<strong>Error!!!</strong> Ask for help');
			}
			redirect(base_url('safety/upload_info_safety/' . $idSafety), 'refresh');
    }
	
    /**
     * Delete safety subcontractor
     */
    public function deleteSafetySubcontractor($idSafetySubcontractor, $idSafety) 
	{
			if (empty($idSafetySubcontractor) || empty($idSafety) ) {
				show_error('ERROR!!! - You are in the wrong place.');
			}
		
			$arrParam = array(
				"table" => "safety_workers_subcontractor",
				"primaryKey" => "id_safety_subcontractor",
				"id" => $idSafetySubcontractor
			);

			if ($this->safety_model->deleteRecord($arrParam)) {
				$this->session->set_flashdata('retornoExito', 'You have delete one worker.');
			} else {
				$this->session->set_flashdata('retornoError', '<strong>Error!!!</strong> Ask for help');
			}
			redirect(base_url('safety/upload_info_safety/' . $idSafety), 'refresh');
    }
	
	/**
	 * Signature
     * @since 10/12/2016
     * @author BMOTTAG
	 */
	public function add_signature($typo, $idSafety, $idWorker)
	{
			if (empty($typo) || empty($idSafety) || empty($idWorker) ) {
				show_error('ERROR!!! - You are in the wrong place.');
			}
		
			if($_POST){
				
				//update signature with the name of de file
				if($typo == "advisor"){
					$name = "images/signature/safety/" . $typo . "_" . $idSafety . ".png";
					
					$arrParam = array(
						"table" => "safety",
						"primaryKey" => "id_safety",
						"id" => $idSafety,
						"column" => "signature",
						"value" => $name
					);
					//enlace para regresar al formulario
					$data['linkBack'] = "safety/upload_info_safety/" . $idSafety;
				}elseif($typo == "worker"){
					$name = "images/signature/safety/" . $typo . "_" . $idWorker . ".png";
					
					$arrParam = array(
						"table" => "safety_workers",
						"primaryKey" => "id_safety_worker",
						"id" => $idWorker,
						"column" => "signature",
						"value" => $name
					);
					//enlace para regresar al formulario con ancla a la lista de trabajadores
					$data['linkBack'] = "safety/upload_info_safety/" . $idSafety . "#anclaWorker";
				}elseif($typo == "subcontractor"){
					$name = "images/signature/safety/" . $typo . "_" . $idWorker . ".png";
					
					$arrParam = array(
						"table" => "safety_workers_subcontractor",
						"primaryKey" => "id_safety_subcontractor",
						"id" => $idWorker,
						"column" => "signature",
						"value" => $name
					);
					//enlace para regresar al formulario con ancla a la lista de trabajadores
					$data['linkBack'] = "safety/upload_info_safety/" . $idSafety . "#anclaSubcontractor";					
				}
				
				$data_uri = $this->input->post("image");
				$encoded_image = explode(",", $data_uri)[1];
				$decoded_image = base64_decode($encoded_image);
				file_put_contents($name, $decoded_image);
				
				$this->load->model("general_model");
				$data['titulo'] = "<i class='fa fa-life-saver fa-fw'></i>SIGNATURE";
				if ($this->general_model->updateRecord($arrParam)) {
					//$this->session->set_flashdata('retornoExito', 'You just save your signature!!!');
					
					$data['clase'] = "alert-success";
					$data['msj'] = "Good job, you have save your signature.";	
				} else {
					//$this->session->set_flashdata('retornoError', '<strong>Error!!!</strong> Ask for help');
					
					$data['clase'] = "alert-danger";
					$data['msj'] = "Ask for help.";
				}
				
				$data["view"] = 'template/answer';
				$this->load->view("layout", $data);

				//redirect("/safety/add_safety/" . $idSafety,'refresh');
			}else{			
				$this->load->view('template/make_signature');
			}
	}
	
    /**
     * Safe one hazard
     */
    public function safet_One_Hazard() 
	{
			$idSafety = $this->input->post('hddId');

			if ($this->safety_model->saveOneHazard()) {
				$this->session->set_flashdata('retornoExito', 'You have Add one Hazard.');
			} else {
				$this->session->set_flashdata('retornoError', '<strong>Error!!!</strong> Ask for help');
			}
			redirect(base_url('safety/upload_info_safety/' . $idSafety), 'refresh');
    }
	
    /**
     * Safe one worker
     */
    public function safet_One_Worker() 
	{
			$idSafety = $this->input->post('hddId');

			if ($this->safety_model->saveOneWorker()) {
				$this->session->set_flashdata('retornoExito', 'You have Add one Worker.');
			} else {
				$this->session->set_flashdata('retornoError', '<strong>Error!!!</strong> Ask for help');
			}
			redirect(base_url('safety/upload_info_safety/' . $idSafety), 'refresh');
    }
	
    /**
     * Safe subcontractor worker
     */
    public function safet_subcontractor_Worker() 
	{
			$idSafety = $this->input->post('hddId');

			if ($this->safety_model->saveSubcontractorWorker()) {
				$this->session->set_flashdata('retornoExito', 'You have Add one Worker.');
			} else {
				$this->session->set_flashdata('retornoError', '<strong>Error!!!</strong> Ask for help');
			}
			redirect(base_url('safety/upload_info_safety/' . $idSafety), 'refresh');
    }	
	
}