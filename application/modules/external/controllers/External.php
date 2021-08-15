<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class External extends CI_Controller {
	
    public function __construct() {
        parent::__construct();
        $this->load->model("external_model");
		$this->load->helper('form');
    }
	
	/**
	 * Form task control
     * @since 7/4/2020
     * @author BMOTTAG
	 */
	public function add_task_control($idJob, $idTaskControl = 'x')
	{
			$data['information'] = FALSE;
			
			$this->load->model("general_model");
			//job info
			$arrParam = array(
				"table" => "param_jobs",
				"order" => "job_description",
				"column" => "id_job",
				"id" => $idJob
			);
			$data['jobInfo'] = $this->general_model->get_basic_search($arrParam);
			
			//company list
			$arrParam = array(
				"table" => "param_company",
				"order" => "company_name",
				"column" => "company_type",
				"id" => 2
			);
			$data['companyList'] = $this->general_model->get_basic_search($arrParam);//company list
			
			//si envio el id, entonces busco la informacion 
			if ($idTaskControl != 'x') {
				
				$arrParam = array("idTaskControl" => $idTaskControl);				
				$data['information'] = $this->external_model->get_task_control($arrParam);
				
				if (!$data['information']) { 
					show_error('ERROR!!! - You are in the wrong place.');	
				}
			}			

			$data["view"] = 'form_task_control';
			$this->load->view("layout", $data);
	}
	
	/**
	 * save _task_control
     * @since 7/4/2020
     * @author BMOTTAG
	 */
	public function save_task_control()
	{			
			header('Content-Type: application/json');
			$data = array();
			
			$data["idRecord"] = $this->input->post('hddIdJob');

			if ($idTaskControl = $this->external_model->add_task_control()) 
			{
				$data["result"] = true;
				$data["mensaje"] = "You have save the Task Assessment and Control, don't forget to sign..";
				$data["idTaskControl"] = $idTaskControl;
				$this->session->set_flashdata('retornoExito', "You have save the Task Assessment and Control, don't forget to sign.!!");
			} else {
				$data["result"] = "error";
				$data["mensaje"] = "Error!!! Ask for help.";
				$data["idTaskControl"] = "";
				$this->session->set_flashdata('retornoError', '<strong>Error!!!</strong> Ask for help');
			}
			
			echo json_encode($data);
    }
	
	/**
	 * Signature
	 * param $typo: supervisor / Superintendent
	 * param $idTaskControl: llave principal del formulario
	 * param $idJob: llave principal de trabajo
     * @since 8/4/2020
     * @author BMOTTAG
	 */
	public function add_signature_tac($typo, $idJob, $idTaskControl)
	{
			if (empty($typo) || empty($idJob) || empty($idTaskControl) ) {
				show_error('ERROR!!! - You are in the wrong place.');
			}
		
			if($_POST){
				
				//update signature with the name of the file
				$name = "images/signature/tac/" . $typo . "_" . $idTaskControl . ".png";
				
				$arrParam = array(
					"table" => "job_task_control",
					"primaryKey" => "id_job_task_control",
					"id" => $idTaskControl,
					"column" => $typo . "_signature",
					"value" => $name
				);
				//enlace para regresar al formulario
				$data['linkBack'] = "external/add_task_control/" . $idJob . "/" . $idTaskControl;
				
				$data_uri = $this->input->post("image");
				$encoded_image = explode(",", $data_uri)[1];
				$decoded_image = base64_decode($encoded_image);
				file_put_contents($name, $decoded_image);
				
				$this->load->model("general_model");
				$data['titulo'] = "<i class='fa fa-life-saver fa-fw'></i> SIGNATURE";
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
	 * Envio de mensaje
     * @since 26/11/2020
     * @author BMOTTAG
	 */
	public function sendSMSWorker($idJob, $idTaskControl)
	{			
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
		
        $client = new Twilio\Rest\Client($dato1, $dato2);

		//task control info
		$arrParam = array("idTaskControl" => $idTaskControl);				
		$data['information'] = $this->external_model->get_task_control($arrParam);
		
		//job info
		$arrParam = array(
			"table" => "param_jobs",
			"order" => "job_description",
			"column" => "id_job",
			"id" => $idJob
		);
		$jobInfo = $this->general_model->get_basic_search($arrParam);
		
		$mensaje = "";
		
		//$mensaje .= date('F j, Y', strtotime($data['JSOInfo'][0]['date_issue_jso']));
		$mensaje .= "\n" . $jobInfo[0]['job_description'];
		$mensaje .= "\n";
		$mensaje .= "Click the following link to fill the COVID FORM.";
		$mensaje .= "\n";
		$mensaje .= "\n";
		$mensaje .= base_url("external/add_task_control/" . $idJob . "/" . $idTaskControl);

		$to = '+1' . $data['information'][0]['contact_phone_number'];
	
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

		$data['linkBack'] = "more/task_control/" . $idJob;
		$data['titulo'] = "<i class='fa fa-list'></i> COVID-19";
		
		$data['clase'] = "alert-info";
		$data['msj'] = "We have send the SMS to the Worker to fill the COVID form.";

		$data["view"] = 'template/answer';
		$this->load->view("layout", $data);


	}
	
	/**
	 * Envio de mensaje para firmar FLHA
     * @since 14/4/2021
     * @author BMOTTAG
	 */
	public function sendSMSFLHAWorker($idSafety, $idSafetySubcontractor = 'x')
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
		
		
        $client = new Twilio\Rest\Client($dato1, $dato2);
		
		$data['informationWorker'] = FALSE;
		$data['idSafety'] = $idSafety;
														
		$arrParam = array(
			'idSafety' => $idSafety,
			'movilNumber' => true,
			'idSafetySubcontractor' => $idSafetySubcontractor
		);
		$data['infoSafety'] = $this->general_model->get_safety($arrParam);

		//lista de subcontratistas para este FLHA
		$data['informationWorker'] = $this->general_model->get_safety_subcontractors_workers($arrParam);//info safety workers

		$mensaje = "";
		$mensaje .= "VCI FLHA - " . date('F j, Y', strtotime($data['infoSafety'][0]['date']));
		$mensaje .= "\n" . $data['infoSafety'][0]['job_description'];
		$mensaje .= "\nFollow the link, read the FLHA and sign.";
		$mensaje .= "\n";
		$mensaje .= "\n";
		$mensaje .= base_url("safety/review_flha/" . $idSafety);

		if($data['informationWorker']){
			foreach ($data['informationWorker'] as $data):
				$to = '+1' . $data['worker_movil_number'];		
				$client->messages->create(
					$to,
					array(
						'from' => '587 600 8948',
						'body' => $mensaje
					)
				);
			endforeach;
		}
		$data['linkBack'] = "safety/review_flha/" . $idSafety;
		$data['titulo'] = "<i class='fa fa-list'></i>FLHA - SMS";
		
		$data['clase'] = "alert-info";
		$data['msj'] = "You have send the SMS to Subcontractors";

		$data["view"] = 'template/answer';
		$this->load->view("layout", $data);
	}

	/**
	 * Envio de mensaje para firmar - Excavation and Trenching Plan
     * @since 14/4/2021
     * @author BMOTTAG
	 */
	public function sendSMSExcavationWorker($idExcavation, $idSubcontractor = 'x')
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
		$phone = $parametric[5]["value"];
		
        $client = new Twilio\Rest\Client($dato1, $dato2);
		
		$data['informationWorker'] = FALSE;
		$data['idExcavation'] = $idExcavation;
														
		$arrParam = array(
			'idExcavation' => $idExcavation,
			'movilNumber' => true,
			'idSubcontractor' => $idSubcontractor
		);
		$data['information'] = $this->general_model->get_excavation($arrParam);

		//lista de subcontratistas para este FLHA
		$data['informationWorker'] = $this->general_model->get_excavation_subcontractors($arrParam);//info safety workers

		$mensaje = "";
		$mensaje .= "VCI Excavation and Trenching Plan - " . date('F j, Y', strtotime($data['information'][0]['date_excavation']));
		$mensaje .= "\n" . $data['information'][0]['job_description'];
		$mensaje .= "\nFollow the link, read the Excavation and Trenching Plan and sign.";
		$mensaje .= "\n";
		$mensaje .= "\n";
		$mensaje .= base_url("jobs/review_excavation/" . $idExcavation);

		if($data['informationWorker']){
			foreach ($data['informationWorker'] as $data):
				$to = '+1' . $data['worker_movil_number'];		
				$client->messages->create(
					$to,
					array(
						'from' => $phone,
						'body' => $mensaje
					)
				);
			endforeach;
		}
		$data['linkBack'] = "jobs/review_excavation/" . $idExcavation;
		$data['titulo'] = "<i class='fa fa-pied-piper-alt'></i>Excavation and Trenching Plan - SMS";
		
		$data['clase'] = "alert-info";
		$data['msj'] = "You have send the SMS to Subcontractors";

		$data["view"] = 'template/answer';
		$this->load->view("layout", $data);
	}

	
	
}