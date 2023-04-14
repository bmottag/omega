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
		$data['workersList'] = FALSE;
		$data['dayoffList'] = FALSE;
						
		//si envio el id, entonces busco la informacion 
		if ($idProgramming != 'x') {
			$arrParam = array("idProgramming" => $idProgramming);
			$data['information'] = $this->general_model->get_programming($arrParam);//info programacion
			
			//lista de trabajadores para esta programacion
			$data['informationWorker'] = $this->general_model->get_programming_workers($arrParam);//info trabajadores

			$data['informationVehicles'] = $this->programming_model->get_vehicles_inspection();
			
			$data['horas'] = $this->general_model->get_horas();//LISTA DE HORAS
			
			//workers list
			$arrParam = array("state" => 1);
			$data['workersList'] = $this->general_model->get_user($arrParam);//workers list

			$data["forPlanning"] = true;//approved
			$data['dayoffList'] = $this->general_model->get_day_off($data);

			//si hay trabajadores reviso si ya se ha hecho la inspeccion de las maquinas
			if($data['workersList']){
				$data['memo'] = $this->verificacion($idProgramming, $data['information'][0]['date_programming']);
				$data['memo_flha'] = $this->verificacion_flha($idProgramming, $data['information'][0]['date_programming']);
				$data['memo_tool_box'] = $this->verificacion_tool_box($idProgramming, $data['information'][0]['date_programming']);
			}
			
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

			$msj = "You have added a new Planning. Do not forget to asign the workers.";
			$result_project = false;
			if ($idProgramming != '') {
				$msj = "You have updated a Planning!!";
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
			$arrParam = array("state" => 1);
			$data['workersList'] = $this->general_model->get_user($arrParam);//workers list

			
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
				
				$this->session->set_flashdata('retornoExito', 'You have added Workers to the Planning, if they are going to use a machine remember to assign it to the worker.');
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
			$this->load->model("general_model");
			$idProgramming = $this->input->post('hddIdProgramming');
			$idProgrammingWorker = $this->input->post('hddId');

			$arrParam = array("idProgramming" => $idProgramming);
			$infoProgramming = $this->general_model->get_programming($arrParam);//info programacion
			$fechaProgramming = $infoProgramming[0]['date_programming'];
			$idMachine = $this->input->post('machine');

			//si envia maquina entonces buscar si existe programacion para este mismo dia para esa maquina
			$inspecciones = false;
			if($idMachine != ''){
				$arrParam = array(
					'idProgrammingWorker' => $idProgrammingWorker,
					'fechaProgramming' => $fechaProgramming,
					'maquina' => $idMachine
				);
				$inspecciones = $this->general_model->get_programming_machine_vs_date_programming($arrParam);
			}

			if($inspecciones){
					$data["result"] = "error";
					$this->session->set_flashdata('retornoError', 'This Equiment has already been used');
			}else{
				if ($this->programming_model->saveWorker()) {
					$data["result"] = true;
					$this->session->set_flashdata('retornoExito', "You have update the record!!");
				} else {
					$data["result"] = "error";
					$this->session->set_flashdata('retornoError', '<strong>Error!!!</strong> Ask for help');
				}
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
	public function send($idProgramming, $flashPlanning = false)
	{			
		$this->load->model("general_model");
		$this->load->library('encrypt');
		require 'vendor/Twilio/autoload.php';

		//busco datos parametricos twilio
		$arrParam = array(
			"table" => "parametric",
			"order" => "id_parametric",
			"id" => "x"
		);
		$this->load->model("general_model");
		$parametric = $this->general_model->get_basic_search($arrParam);						
		$dato1 = $this->encrypt->decode($parametric[3]["value"]);
		$dato2 = $this->encrypt->decode($parametric[4]["value"]);
		$twilioPhone = $parametric[5]["value"];
		
        $client = new Twilio\Rest\Client($dato1, $dato2);
		
		$data['informationWorker'] = FALSE;
		$data['idProgramming'] = $idProgramming;
												
		$arrParam = array("idProgramming" => $idProgramming);
		$data['information'] = $this->general_model->get_programming($arrParam);//info programacion
		
		//lista de trabajadores para esta programacion
		$copiaInfoWorker = $data['informationWorker'] = $this->general_model->get_programming_workers($arrParam);//info trabajadores

		$mensaje = "";
		
		$mensaje .= date('F j, Y', strtotime($data['information'][0]['date_programming']));
		$mensaje .= "\n" . $data['information'][0]['job_description'];
		$mensaje .= "\n" . $data['information'][0]['observation'];
		$mensaje .= "\n";

		if($data['informationWorker']){
			foreach ($data['informationWorker'] as $data):
				$mensaje .= "\n";
				switch ( $data['site'] )
				{
					case 1:
						$mensaje .= "At the yard - ";
						break;
					case 2:
						$mensaje .= "At the site - ";
						break;
					case 3:
						$mensaje .= "At Terminal - ";
						break;
					default:
						$mensaje .= "At the yard - ";
						break;
				}
				$mensaje .= $data['hora']; 

				$mensaje .= "\n" . $data['name']; 
				$mensaje .= $data['description']?"\n" . $data['description']:"";
				$mensaje .= $data['unit_description']?"\n" . $data['unit_description']:"";
				
				if($data['safety']==1){
					$mensaje .= "\nDo FLHA";
				}elseif($data['safety']==2){
					$mensaje .= "\nDo Tool Box";
				}
				
				$mensaje .= "\n";
			endforeach;
			
			foreach ($copiaInfoWorker as $data):
				$to = '+1' . $data['movil'];
			
				$client->messages->create(
					$to,
					array(
						'from' => $twilioPhone,
						'body' => $mensaje
					)
				);
			endforeach;
		}
		
		if($flashPlanning){
			return true;
		}else{
			$data['linkBack'] = "programming/index/" . $idProgramming;
			$data['titulo'] = "<i class='fa fa-list'></i>PROGRAMMING LIST";
			
			$data['clase'] = "alert-info";
			$data['msj'] = "Message is sent to the workers.";
	
			$data["view"] = 'template/answer';
			$this->load->view("layout", $data);
		}
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
	 * Actualizo estado de los mensajes.
	 * $nuevoEstoadoSMS = 0 no enviado; 1 enviado al empleado; 2 enviado al administrador
	 * $tipoSMS = columna de la base de datos: sms_inspection; sms_safety
     * @since 17/1/2019
	 */
    function update_sms_worker($idProgrammingWorker, $columnaTipoSMS, $nuevoEstoadoSMS) 
	{
			//programming info
			$this->load->model("general_model");
					
			//guardo estado de la programacion			
			$arrParam = array(
				"table" => "programming_worker",
				"primaryKey" => "id_programming_worker",
				"id" => $idProgrammingWorker,
				"column" => $columnaTipoSMS,
				"value" => $nuevoEstoadoSMS
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
	 * El CRON se corre cada hora pero se le sumo 3 horas mas para que nosea inmediatamente empiece
     * @since 17/1/2019
	 */
    function verificacion($idProgramming = 'x', $fecha = 'x') 
	{
			$this->load->model("general_model");
			$bandera = false;
			
			if ($fecha != 'x') {
				$fechaBusqueda = $fecha;
				$arrParam = array("idProgramming" => $idProgramming, "fecha" => $fechaBusqueda);
			}else{
				$fechaBusqueda = date("Y-m-d");
				$bandera = true;
				$arrParam = array("fecha" => $fechaBusqueda);
			}
			
			$information = $this->general_model->get_programming($arrParam);//info programacion
	
			$i = 0;
			$nombres = "";
	
			if($information){

//inicio configuracion			
if($bandera){
				$this->load->library('encrypt');
				require 'vendor/Twilio/autoload.php';

				//busco datos parametricos twilio
				$arrParam = array(
					"table" => "parametric",
					"order" => "id_parametric",
					"id" => "x"
				);
				$parametric = $this->general_model->get_basic_search($arrParam);						
				$dato1 = $this->encrypt->decode($parametric[3]["value"]);
				$dato2 = $this->encrypt->decode($parametric[4]["value"]);
				$phone = $parametric[5]["value"];
				$phoneAdmin = $parametric[6]["value"];
				
				$client = new Twilio\Rest\Client($dato1, $dato2);
}
//fin configuracion
				
				
				//para cada programacion buscar los trabajadores que tienen maquinas asignadas
				foreach($information as $lista):
					//lista de trabajadores para esta programacion que tiene maquinas asignadas
					$arrParam = array("idProgramming" => $lista['id_programming'], "machine" => TRUE);
					$informationWorker = $this->general_model->get_programming_workers($arrParam);//info trabajadores
					
					if($informationWorker){
						//busco para la fecha y para esa maquina si hay inspecciones
						//si no hay inspecciones envio mensaje de alerta
						foreach($informationWorker as $dato):
							$arrParam = array("fecha" => $fechaBusqueda, "maquina" => $dato['fk_id_machine']);
							$inspecciones = $this->general_model->get_programming_inspecciones($arrParam);//inspecciones de maquinas asignadas en una programacion
							
							if(!$inspecciones){
								$i++;
								$nombres .= "<br>" . $dato['name'] . " - " . $dato['unit_description'];
//ENVIO MENSAJE DE TEXTO
								if($bandera && $dato['sms_inspection'] != 2){									

								
									//buscar si ya empezo la hora laboral del trabajador
									$fechaProgramacion = $fechaBusqueda . " " . $dato['formato_24'];
									
									$datetime1 = date_create($fechaProgramacion);
									
									
									//$datetime2 = date_create(date('Y-m-d G:i'));//fecha actual
									

			$ajuste = strtotime ( '-2 hour' , strtotime ( date("Y-m-d G:i") ) ) ;//le resto 2 horas a la hora actual
			$datetime2 = date_create(date("Y-m-d G:i", $ajuste));

									//si ya empezo a trabajar y no se le ha enviado mensaje, entonces le envio sms
									if($datetime1 < $datetime2) {

										//si no le ha enviado sms entonces lo envio
										if($dato['sms_inspection'] == 0) 
										{											
												//actualizo la bandera sms_inspection a 1
												$updateState = $this->update_sms_worker($dato['id_programming_worker'], "sms_inspection", 1);
																						
												$to = '+1' . $dato['movil'];
												
												$mensaje = "INSPECTION APP-VCI";
												$mensaje .= "\nDo not forget to do the Inspection:";
												$mensaje .= "\n" . $dato['unit_description'];
											
												// Use the client to do fun stuff like send text messages!
												$message = $client->messages->create(
												// the number you'd like to send the message to
													$to,
													array(
														// A Twilio phone number you purchased at twilio.com/console
														'from' => $phone,
														'body' => $mensaje
													)
												);
												
										}
										//si ya se le evio al trabajador entonces se envio al ADMIN
										if($dato['sms_inspection'] == 1) 
										{
												//actualizo la bandera sms_inspection a 2
												$updateState = $this->update_sms_worker($dato['id_programming_worker'], "sms_inspection", 2);
										
												$to = '+1' . $phoneAdmin;
												
												$mensaje = "INSPECTION APP-VCI";
												$mensaje .= "\nThe user has not done the Inspection:";
												$mensaje .= "\n" . $dato['name'] . " - " . $dato['unit_description'];
												
												// Use the client to do fun stuff like send text messages!
												$message = $client->messages->create(
												// the number you'd like to send the message to
													$to,
													array(
														// A Twilio phone number you purchased at twilio.com/console
														'from' => $phone,
														'body' => $mensaje
													)
												);										
										
											
										}
										
										
									}
																	

								}
//FIN MENSAJE DE TEXTO
								
							}
							
	//echo $this->db->last_query(); exit;
							
						endforeach;
					}
//pr($informationWorker);
					
				endforeach;
			}
			
			if($i != 0){
				$memo =  "INSPECTIONS missing:";
				$memo .= $nombres;
			}else{
				$memo = "There is no INSPECTIONS missing.";
			}
						
			return $memo;

    }
		
	public function calendar()
	{
		$this->load->model("general_model");
				
		$arrParam = array("estado" => "ACTIVAS");
		$data['information'] = $this->general_model->get_programming($arrParam);//info solicitudes
		
		$data["view"] = 'calendar';
		$this->load->view("layout", $data);
	}
	
    /**
     * Safe one worker
     */
    public function safet_One_Worker_programming() 
	{
			$idProgramming = $this->input->post('hddId');

			if ($this->programming_model->saveOneWorkerProgramming()) {
				$this->session->set_flashdata('retornoExito', 'You have added one Worker.');
			} else {
				$this->session->set_flashdata('retornoError', '<strong>Error!!!</strong> Ask for help');
			}
			redirect(base_url('programming/index/' . $idProgramming), 'refresh');
    }
	
	/**
	 * CRON
	 * Verificar para la fecha actual si existen FLHA asignadas y si se hizo el FLHA (1) 
	 * El CRON se corre a las 10:30 AM de todos los dias
     * @since 17/1/2019
	 */
    function verificacion_flha($idProgramming = 'x', $fecha = 'x') 
	{
			$this->load->model("general_model");
			$bandera = false;
			
			if ($fecha != 'x') {
				$fechaBusqueda = $fecha;
				$arrParam = array("idProgramming" => $idProgramming, "fecha" => $fechaBusqueda);
			}else{
				$fechaBusqueda = date("Y-m-d");
				$bandera = true;
				$arrParam = array("fecha" => $fechaBusqueda);
			}
			$information = $this->general_model->get_programming($arrParam);//info programacion
	
			$i = 0;
			$nombres = "";
	
			if($information){
				
//inicio configuracion			
if($bandera){
				$this->load->library('encrypt');
				require 'vendor/Twilio/autoload.php';

				//busco datos parametricos twilio
				$arrParam = array(
					"table" => "parametric",
					"order" => "id_parametric",
					"id" => "x"
				);
				$parametric = $this->general_model->get_basic_search($arrParam);						
				$dato1 = $this->encrypt->decode($parametric[3]["value"]);
				$dato2 = $this->encrypt->decode($parametric[4]["value"]);
				$phone = $parametric[5]["value"];
				$phoneAdmin = $parametric[6]["value"];
				
				$client = new Twilio\Rest\Client($dato1, $dato2);
}
//fin configuracion
				
				//para cada programacion buscar los trabajadores que tienen FLHA
				foreach($information as $lista):
					//lista de trabajadores para esta programacion que tiene FLHA 
					$arrParam = array("idProgramming" => $lista['id_programming'], "safety" => 1);
					$informationWorker = $this->general_model->get_programming_workers($arrParam);//info trabajadores con FLHA
					
					if($informationWorker){
						//busco para la fecha, para ese JOB CODE si hay FLHA
						//si no hay FLHA envio mensaje de alerta
						foreach($informationWorker as $dato):
							$arrParam = array("fecha" => $fechaBusqueda, 
											"idJob" => $lista['fk_id_job'],
											"limit" => 30);
							$inspecciones = $this->general_model->get_safety($arrParam);

							if(!$inspecciones){
								$i++;
								$nombres .= "<br>" . $dato['name'] . " - Missing FLHA";
//ENVIO MENSAJE DE TEXTO
								if($bandera && $dato['sms_safety'] != 2){
									
									//buscar si ya empezo la hora laboral del trabajador
									$fechaProgramacion = $fechaBusqueda . " " . $dato['formato_24'];
									
									$datetime1 = date_create($fechaProgramacion);
									//$datetime2 = date_create(date('Y-m-d G:i'));//fecha actual
									

			$ajuste = strtotime ( '-2 hour' , strtotime ( date("Y-m-d G:i") ) ) ;//le resto 2 horas a la hora actual
			$datetime2 = date_create(date("Y-m-d G:i", $ajuste));
									
									//si ya empezo a trabajar y no se le ha enviado mensaje, entonces le envio sms
									if($datetime1 < $datetime2) {
										
										//si no le ha enviado sms entonces lo envio
										if($dato['sms_safety'] == 0) 
										{
												//actualizo la bandera sms_safety a 1
												$updateState = $this->update_sms_worker($dato['id_programming_worker'], "sms_safety", 1);
									
												$to = '+1' . $dato['movil'];
												
												$mensaje = "FLHA APP-VCI";
												$mensaje .= "\nDo not forget to do the FLHA:";
												$mensaje .= "\n" . $lista['job_description'];
											
												// Use the client to do fun stuff like send text messages!
												$message = $client->messages->create(
												// the number you'd like to send the message to
													$to,
													array(
														// A Twilio phone number you purchased at twilio.com/console
														'from' => $phone,
														'body' => $mensaje
													)
												);
										}
										//si ya se le evio al trabajador entonces se envio al ADMIN
										elseif($dato['sms_safety'] == 1) 
										{
												//actualizo la bandera sms_inspection a 2
												$updateState = $this->update_sms_worker($dato['id_programming_worker'], "sms_safety", 2);
										
												$to = '+1' . $phoneAdmin;
												
												$mensaje = "FLHA APP-VCI";
												$mensaje .= "\nThe user has not done the FLHA:";
												$mensaje .= "\n" . $dato['name'];
												
												// Use the client to do fun stuff like send text messages!
												$message = $client->messages->create(
												// the number you'd like to send the message to
													$to,
													array(
														// A Twilio phone number you purchased at twilio.com/console
														'from' => $phone,
														'body' => $mensaje
													)
												);
										}
										
									}
								}
//FIN MENSAJE DE TEXTO
								
							}
							
	//echo $this->db->last_query(); exit;
							
						endforeach;
					}
//pr($informationWorker);
					
				endforeach;
			}
			
			if($i != 0){
				$memo =  "Missing FLHA:";
				$memo .= $nombres;
			}else{
				$memo = "There is no FLHA missing";
			}
			
			return $memo;

    }
	
	/**
	 * CRON
	 * Verificar para la fecha actual si existen TOOL BOX asignadas y si se hizo el TOOL BOX (2) 
	 * El CRON se corre a las 10:15 AM de todos los dias
     * @since 20/1/2019
	 */
    function verificacion_tool_box($idProgramming = 'x', $fecha = 'x') 
	{
			$this->load->model("general_model");
			$bandera = false;
			
			if ($fecha != 'x') {
				$fechaBusqueda = $fecha;
				$arrParam = array("idProgramming" => $idProgramming, "fecha" => $fechaBusqueda);
			}else{
				$fechaBusqueda = date("Y-m-d");
				$bandera = true;
				$arrParam = array("fecha" => $fechaBusqueda);
			}
			
			$information = $this->general_model->get_programming($arrParam);//info programacion
	
			$i = 0;
			$nombres = "";
	
			if($information){
				
//inicio configuracion			
if($bandera){
				$this->load->library('encrypt');
				require 'vendor/Twilio/autoload.php';

				//busco datos parametricos twilio
				$arrParam = array(
					"table" => "parametric",
					"order" => "id_parametric",
					"id" => "x"
				);
				$parametric = $this->general_model->get_basic_search($arrParam);						
				$dato1 = $this->encrypt->decode($parametric[3]["value"]);
				$dato2 = $this->encrypt->decode($parametric[4]["value"]);
				$phone = $parametric[5]["value"];
				$phoneAdmin = $parametric[6]["value"];
				
				$client = new Twilio\Rest\Client($dato1, $dato2);
}
//fin configuracion
				
				//para cada programacion buscar los trabajadores que tienen TOOL BOX
				foreach($information as $lista):
					//lista de trabajadores para esta programacion que tiene TOOL BOX
					$arrParam = array("idProgramming" => $lista['id_programming'], "safety" => 2);
					$informationWorker = $this->general_model->get_programming_workers($arrParam);//info trabajadores con TOOL BOX
					
					if($informationWorker){
						//busco para la fecha, para ese JOB CODE si hay TOOL BOX
						//si no hay TOOL BOX envio mensaje de alerta
						foreach($informationWorker as $dato):
							$arrParam = array("fecha" => $fechaBusqueda, 
											"idJob" => $lista['fk_id_job']);
							$inspecciones = $this->general_model->get_tool_box($arrParam);

							if(!$inspecciones){
								$i++;
								$nombres .= "<br>" . $dato['name'] . " - Missing TOOL BOX";
//ENVIO MENSAJE DE TEXTO
								if($bandera && $dato['sms_safety'] != 2){
									
									//buscar si ya empezo la hora laboral del trabajador
									$fechaProgramacion = $fechaBusqueda . " " . $dato['formato_24'];
									
									$datetime1 = date_create($fechaProgramacion);
									//$datetime2 = date_create(date('Y-m-d G:i'));//fecha actual
									

			$ajuste = strtotime ( '-2 hour' , strtotime ( date("Y-m-d G:i") ) ) ;//le resto 2 horas a la hora actual
			$datetime2 = date_create(date("Y-m-d G:i", $ajuste));
									
									//si ya empezo a trabajar y no se le ha enviado mensaje, entonces le envio sms
									if($datetime1 < $datetime2) {
										
										//si no le ha enviado sms entonces lo envio
										if($dato['sms_safety'] == 0) 
										{
												//actualizo la bandera sms_safety a 1
												$updateState = $this->update_sms_worker($dato['id_programming_worker'], "sms_safety", 1);

												$to = '+1' . $dato['movil'];
												
												$mensaje = "TOOL BOX APP-VCI";
												$mensaje .= "\nDo not forget to do the TOOL BOX:";
												$mensaje .= "\n" . $lista['job_description'];
											
												// Use the client to do fun stuff like send text messages!
												$message = $client->messages->create(
												// the number you'd like to send the message to
													$to,
													array(
														// A Twilio phone number you purchased at twilio.com/console
														'from' => $phone,
														'body' => $mensaje
													)
												);
										}
										//si ya se le evio al trabajador entonces se envio al ADMIN
										elseif($dato['sms_safety'] == 1) 
										{
												//actualizo la bandera sms_inspection a 2
												$updateState = $this->update_sms_worker($dato['id_programming_worker'], "sms_safety", 2);
										
												$to = '+1' . $phoneAdmin;
												
												$mensaje = "TOOL BOX APP-VCI";
												$mensaje .= "\nThe user has not done the TOOL BOX:";
												$mensaje .= "\n" . $dato['name'];
												
												// Use the client to do fun stuff like send text messages!
												$message = $client->messages->create(
												// the number you'd like to send the message to
													$to,
													array(
														// A Twilio phone number you purchased at twilio.com/console
														'from' => $phone,
														'body' => $mensaje
													)
												);
										}
									}
								}
//FIN MENSAJE DE TEXTO
								
							}
							
	//echo $this->db->last_query(); exit;
							
						endforeach;
					}
//pr($informationWorker);
					
				endforeach;
			}
			
			if($i != 0){
				$memo =  "Missing TOOL BOX:";
				$memo .= $nombres;
			}else{
				$memo = "There is no TOOL BOX missing";
			}
			
			return $memo;

    }

	/**
	 * Form Flash Planning
     * @since 28/12/2022
     * @author BMOTTAG
	 */
	public function flash_planning()
	{			
		$this->load->model("general_model");
		$data['information'] = FALSE;
		$data['informationVehicles'] = $this->programming_model->get_vehicles_inspection();

		//jobs list - (active items)
		$arrParam = array(
			"table" => "param_jobs",
			"order" => "job_description",
			"column" => "state",
			"id" => 1
		);
		$data['jobs'] = $this->general_model->get_basic_search($arrParam);

		//workers list
		$arrParam = array("state" => 1);
		$data['workersList'] = $this->general_model->get_user($arrParam);//workers list

		$data["view"] = 'form_planning_flash';
		$this->load->view("layout", $data);
	}

	/**
	 * Save Flash Planning
     * @since 28/12/2022
	 */
	public function save_flash_planning()
	{			
			header('Content-Type: application/json');
			
			$this->load->model("general_model");
			$idProgramming = $this->input->post('hddId');

			$msj = "You have added a new Planning.";
			if ($idProgramming != '') {
				$msj = "You have updated a Planning!!";
			}

			$horas = $this->general_model->get_horas();//LISTA DE HORAS
			$horaActual = date("G:i");

			$idHora = "";
			foreach ($horas as $hora):
				$hora1 =strtotime( $hora["formato_24"]);
				$hora2 = strtotime($horaActual);
				
				if( $hora1 > $hora2 ) {
					$idHora = $hora["id_hora"];
					break;
				}  
			endforeach;
			
			if ($data["idProgramming"] = $this->programming_model->saveProgramming()) 
			{	
				//Save worker
				if($this->programming_model->saveWorkerFashPlanning($data["idProgramming"], $idHora)){
					//envio mensaje de texto
					$this->send($data["idProgramming"], true);
					$msj.= " Message is sent to the worker.";
				}
				$data["result"] = true;
				$this->session->set_flashdata('retornoExito', $msj);
				
			} else {
				$data["result"] = "error";
				$this->session->set_flashdata('retornoError', '<strong>Error!!!</strong> Contactarse con el Administrador.');
			}

			echo json_encode($data);
    }


	
}