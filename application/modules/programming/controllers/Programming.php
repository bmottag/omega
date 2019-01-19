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
						
		//si envio el id, entonces busco la informacion 
		if ($idProgramming != 'x') {
			$arrParam = array("idProgramming" => $idProgramming);
			$data['information'] = $this->general_model->get_programming($arrParam);//info programacion
			
			//lista de trabajadores para esta programacion
			$data['informationWorker'] = $this->general_model->get_programming_workers($arrParam);//info trabajadores

			$data['informationVehicles'] = $this->programming_model->get_vehicles_inspection();
			
			$data['horas'] = $this->general_model->get_horas();//LISTA DE HORAS
			
		}else{
			$arrParam = array("estado" => "ACTIVAS");
			$data['information'] = $this->general_model->get_programming($arrParam);//info solicitudes
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

			$msj = "You have add a new programming. Do not forget to asign the workers.";
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
				
				//actualizo el estado de la programacion -> dependiento si se completaron o no la cantidad de trabajadores
				$updateState = $this->update_state($data["idProgramming"]);
				
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
	
    /**
     * Delete worker
     */
    public function deleteWorker($idProgramming, $idWorker) 
	{
			if (empty($idProgramming) || empty($idWorker) ) {
				show_error('ERROR!!! - You are in the wrong place.');
			}
		
			$arrParam = array(
				"table" => "programming_worker",
				"primaryKey" => "id_programming_worker",
				"id" => $idWorker
			);
			
			$this->load->model("general_model");
			if ($this->general_model->deleteRecord($arrParam)) {
				
				//actualizo el estado de la programacion -> dependiento si se completaron o no la cantidad de trabajadores
				$updateState = $this->update_state($idProgramming);
				
				$this->session->set_flashdata('retornoExito', 'You have delete one worker.');
			} else {
				$this->session->set_flashdata('retornoError', '<strong>Error!!!</strong> Ask for help');
			}
			redirect(base_url('programming/index/' . $idProgramming), 'refresh');
    }
	
	/**
	 * Envio de mensaje
     * @since 16/1/2019
     * @author BMOTTAG
	 */
	public function send($idProgramming)
	{			
		$this->load->model("general_model");
		$this->load->library('encrypt');
		require 'vendor/Twilio/autoload.php';

		//busco datos del parametricos twilio
		$arrParam = array(
			"table" => "parametric",
			"order" => "id_parametric",
			"id" => "x"
		);
		$this->load->model("general_model");
		$parametric = $this->general_model->get_basic_search($arrParam);						
		$dato1 = $this->encrypt->decode($parametric[3]["value"]);
		$dato2 = $this->encrypt->decode($parametric[4]["value"]);
		
		
        $client = new Twilio\Rest\Client($dato1, $dato2);
		
        $to = '+14034089921';
		//$to = '+14033990160';//fabian		
		
		$data['informationWorker'] = FALSE;
		$data['idProgramming'] = $idProgramming;
												
		$arrParam = array("idProgramming" => $idProgramming);
		$data['information'] = $this->general_model->get_programming($arrParam);//info programacion
		
		//lista de trabajadores para esta programacion
		$data['informationWorker'] = $this->general_model->get_programming_workers($arrParam);//info trabajadores

		$mensaje = "";
		
		$mensaje .= date('F j, Y', strtotime($data['information'][0]['date_programming']));
		$mensaje .= "\n" . $data['information'][0]['job_description'];
		$mensaje .= "\n" . $data['information'][0]['observation'];
		$mensaje .= "\n";

		if($data['informationWorker']){
			foreach ($data['informationWorker'] as $data):
				$mensaje .= "\n";
				$mensaje .= $data['site']==1?"At the yard - ":"At the site - ";
				$mensaje .= $data['hora']; 

				$mensaje .= "\n" . $data['name']; 
				$mensaje .= $data['description']?"<br>" . $data['description']:"";
				$mensaje .= $data['unit_description']?"<br>" . $data['unit_description']:"";
				
				if($data['safety']==1){
					$mensaje .= "\n Do FLHA";
				}elseif($data['safety']==2){
					$mensaje .= "\n Do Tool Box";
				}
				
				$mensaje .= "\n";
			endforeach;
		}
		
		
        // Use the client to do fun stuff like send text messages!
        $client->messages->create(
        // the number you'd like to send the message to
            $to,
            array(
                // A Twilio phone number you purchased at twilio.com/console
                'from' => '587 600 8948',
                'body' => $mensaje
            )
        );


		$data['linkBack'] = "programming/index/" . $idProgramming;
		$data['titulo'] = "<i class='fa fa-list'></i>PROGRAMMING LIST";
		
		$data['clase'] = "alert-info";
		$data['msj'] = "Se envió el mensaje";

		$data["view"] = 'template/answer';
		$this->load->view("layout", $data);


	}
	
	/**
	 * Actualizo estado de la programacion 2 si esta completa 1 si esta incompleta
     * @since 17/1/2019
	 */
    function update_state($idProgramming) 
	{
			//programming info
			$this->load->model("general_model");
			
			//cuento la cantidad de trabajadores guardados en la base de datos
			$countWorkers = $this->programming_model->countWorkers($idProgramming);
		
			$state = 1; //incompleta
			if($countWorkers >= 1){
				$state = 2; //completa
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
	
	/**
	 * CRON
	 * Verificar para la fecha actual si existen maquinas asignadas y si se les hizo inspeccion
	 * El CRON se corre a las 10 AM y las 3 pm de todos los dias
     * @since 17/1/2019
	 */
    function verificacion() 
	{
			$this->load->model("general_model");
			
			$fechaActual = date("Y-m-d");
			$arrParam = array("fecha" => $fechaActual);
			$information = $this->general_model->get_programming($arrParam);//info programacion
	
			$i = 0;
			$nombres = "";
	
			if($information){
				//para cada programacion buscar los trabajadores que tienen maquinas asignadas
				foreach($information as $lista):
					//lista de trabajadores para esta programacion que tiene maquinas asignadas
					$arrParam = array("idProgramming" => $lista['id_programming'], "machine" => TRUE);
					$informationWorker = $this->general_model->get_programming_workers($arrParam);//info trabajadores
					
					if($informationWorker){
						//busco para la fecha y para esa maquina si hay inspecciones
						//si no hay inspecciones envio mensaje de alerta
						foreach($informationWorker as $dato):
							$arrParam = array("fecha" => $fechaActual, "maquina" => $dato['fk_id_machine']);
							$inspecciones = $this->general_model->get_programming_inspecciones($arrParam);//inspecciones de maquinas asignadas en una programacion
							
							if(!$inspecciones){
								$i++;
								$nombres .= "<br>" . $dato['name'];
								//echo "<br>Nombre: " . $dato['name'];
								//echo "<br>Movil: " . $dato['movil'];

							}
							
	//echo $this->db->last_query(); exit;
							
						endforeach;
					}
//pr($informationWorker);
	
					
				endforeach;
			}
			
			if($i != 0){
				echo "Para el día de hoy hay $i inpecciones faltantes:";
				echo $nombres;
			}else{
				echo "Se hicieron todas las inspecciones adignadas en la programación.";
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