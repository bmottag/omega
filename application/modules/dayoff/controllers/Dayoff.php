<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Dayoff extends CI_Controller {
	
    public function __construct() {
        parent::__construct();
        $this->load->model("dayoff_model");
		$this->load->model("general_model");
    }

	/**
	 * List Day Off
     * @since 7/12/2016
     * @author BMOTTAG
	 */
	public function index()
	{
			$arrParam["idEmployee"] = TRUE;
			$data['dayoffList'] = $this->dayoff_model->get_day_off($arrParam);
			$data["view"] = 'dayoff_list';
			$this->load->view("layout", $data);
	}
	
    /**
     * Cargo modal- formulario dayoff
     * @since 07/12/2016
     */
    public function cargarModal() 
	{
			header("Content-Type: text/plain; charset=utf-8"); //Para evitar problemas de acentos
			$this->load->view("modal_dayoff");
    }
	
	/**
	 * Save dayoff
     * @since 04/12/2016
     * @author BMOTTAG
	 */
	public function save_dayoff()
	{			
			header('Content-Type: application/json');
			$data = array();

			//verify ---- 24 hours in advaced for Family/medical appointment and 72 hours for regular
			$type =  $this->input->post('type');//1: Family/medical appointment; 2: Regular
			
			date_default_timezone_set('America/Phoenix');
			$today = date("Y-m-d H:i:s"); 
			$date =  $this->input->post('date'); 

			//START hours calculation
			$minutes = (strtotime($today)-strtotime($date))/60;
			$minutes = abs($minutes);  
			$minutes = round($minutes);

			$hours = $minutes/60;
			
			$flag = TRUE;
			
			if($type == 1 && 24 > $hours ){
				$flag = FALSE;
				$msj = "Error!!. You need more than 24 hours to request the dayoff.";
			}
			if($type == 2 && 72 > $hours ){
				$flag = FALSE;
				$msj = "Error!!. You need more than 72 hours to request the dayoff.";
			}

			if (!$flag) {
				$data["result"] = "error";
				$data["mensaje"] = $msj;
			} else {			
					if ($idDayoff = $this->dayoff_model->add_dayoff()) 
					{
						//envio memsaje de texto al administrador
						$this->load->library('encrypt');
						require 'vendor/Twilio/autoload.php';

						//enviar correo al administrador
						$arrParam["idDayoff"] = $idDayoff;
						$dayoffInfo = $this->dayoff_model->get_day_off($arrParam);
						
						switch ($dayoffInfo[0]['id_type_dayoff']) {
							case 1:
								$tipo = 'Family/medical appointment';
								break;
							case 2:
								$tipo = 'Regular';
								break;
						}
						//mensaje del correo
						$emailMsn = "<p>There is a new request for a Day Off:</p>";
						$emailMsn .= "<strong>Employee: </strong>" . $dayoffInfo[0]["name"];
						$emailMsn .= "<br><strong>Type: </strong>" . $tipo;
						$emailMsn .= "<br><strong>Date of dayoff: </strong>" . $dayoffInfo[0]["date_dayoff"];
						$emailMsn .= "<br><strong>Observation: </strong>" . $dayoffInfo[0]["observation"];
						$emailMsn .= "<p>Please go to the system to Approved or Denied the Day Off.</p>";
						
						//mensaje de texto
						$mensajeSMS = "APP-VCI";
						$mensajeSMS .= "\nThere is a new request for a Day Off:";
						$mensajeSMS .= "\nEmployee: " . $dayoffInfo[0]["name"];
						$mensajeSMS .= "\nType: " . $tipo;
						$mensajeSMS .= "\nDate of dayoff: " . $dayoffInfo[0]["date_dayoff"];
						$mensajeSMS .= "\nObservation: " . $dayoffInfo[0]["observation"];

						//busco datos del parametricos
						$arrParam = array(
							"table" => "parametric",
							"order" => "id_parametric",
							"id" => "x"
						);
						$subjet = "Day Off";
						$this->load->model("general_model");
						$parametric = $this->general_model->get_basic_search($arrParam);						
						$user = $parametric[2]["value"];
						$to = $parametric[0]["value"];
						
						//datos para el mensaje de texto
						$dato1 = $this->encrypt->decode($parametric[3]["value"]);
						$dato2 = $this->encrypt->decode($parametric[4]["value"]);
						
						$client = new Twilio\Rest\Client($dato1, $dato2);
						$toPhone = '+1' . $parametric[6]['value'];
					
						// Use the client to do fun stuff like send text messages!
						$client->messages->create(
						// the number you'd like to send the message to
							$toPhone,
							array(
								// A Twilio phone number you purchased at twilio.com/console
								'from' => '587 600 8948',
								'body' => $mensajeSMS
							)
						);

						$mensaje = "<html>
						<head>
						  <title> $subjet </title>
						</head>
						<body>
							<p>Dear	$user:<br/>
							</p>

							<p>$emailMsn</p>

							<p>Cordially,</p>
							<p><strong>V-CONTRACTING INC</strong></p>
						</body>
						</html>";

						$cabeceras  = 'MIME-Version: 1.0' . "\r\n";
						$cabeceras .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
						$cabeceras .= 'To: ' . $user . '<' . $to . '>' . "\r\n";
						$cabeceras .= 'From: VCI APP <info@v-contracting.ca>' . "\r\n";

						//enviar correo
						mail($to, $subjet, $mensaje, $cabeceras);
						//FIN ENVIO DE CORREO
						
						$data["result"] = true;
						$data["mensaje"] = "Thank you. The ADMIN will review your request.";
						
						$this->session->set_flashdata('retornoExito', 'Thank you. The ADMIN will review your request.');
					} else {
						$data["result"] = "error";
						$data["mensaje"] = "Error. Reload the page.";
						
						$this->session->set_flashdata('retornoError', '<strong>Error!!!</strong> Ask for help');
					}
			}

			echo json_encode($data);
    }
	
	/**
	 * List Day Off, for ADMIN
     * @since 8/12/2016
     * @author BMOTTAG
	 */
	public function newDayoffList()
	{
			$data["state"] = 1;//new
			$data['dayoffList'] = $this->dayoff_model->get_day_off($data);
			
			$data["tittle"] = "New Request";
			$data["icon"] = "fa-hand-o-right";
			$data["view"] = 'admin_dayoff_list';
			$this->load->view("layout", $data);
	}
	
    /**
     * Cargo modal - formulario aprobar dayoff
     * @since 8/12/2016
     */
    public function cargarModalApproved() 
	{
			header("Content-Type: text/plain; charset=utf-8"); //Para evitar problemas de acentos
			$data["idDayoff"] = $this->input->post("idDayoff");
			$this->load->view("modal_approved", $data);
    }
	
	/**
	 * Save approved
     * @since 8/12/2016
     * @author BMOTTAG
	 */
	public function save_approved()
	{			
			header('Content-Type: application/json');
			$data = array();
			$idSafety = $this->input->post('hddIdParam');
			$state = $this->input->post('state');
			$observation = $this->input->post('observation');
		
			if($state == 3 && $observation ==''){
				$data["result"] = "error";
				$data["mensaje"] = "You must write an observation.";
			}else{
				if ($this->dayoff_model->update_dayoff()) {
					$data["result"] = true;
					$data["mensaje"] = "Solicitud guardada correctamente.";
					$data["idSafety"] = $idSafety;
					
					$this->session->set_flashdata('retornoExito', 'You have change the day off´s state!!');
				} else {
					$data["result"] = "error";
					$data["mensaje"] = "Error al guardar. Intente nuevamente o actualice la p\u00e1gina.";
					$data["idSafety"] = "";
					
					$this->session->set_flashdata('retornoError', '<strong>Error!!!</strong> Ask for help');
				}
			}

			echo json_encode($data);
    }
	
	/**
	 * List Day Off, for ADMIN
     * @since 8/12/2016
     * @author BMOTTAG
	 */
	public function approvedDayoffList()
	{
			$data["state"] = 2;//approved
			$data['dayoffList'] = $this->dayoff_model->get_day_off($data);
			
			$data["tittle"] = "Approved Request";
			$data["icon"] = "fa-hand-o-up";
			$data["view"] = 'admin_dayoff_list';
			$this->load->view("layout", $data);
	}
	
	/**
	 * List Day Off, for ADMIN
     * @since 8/12/2016
     * @author BMOTTAG
	 */
	public function deniedDayoffList()
	{
			$data["state"] = 3;//denied
			$data['dayoffList'] = $this->dayoff_model->get_day_off($data);
			
			$data["tittle"] = "Denied Request";
			$data["icon"] = "fa-hand-o-down";
			$data["view"] = 'admin_dayoff_list';
			$this->load->view("layout", $data);
	}
	
	
	
	
	
	
	
	
	
	
	
	
	
    /**
     * Envia correos al administrador
     * @author BMOTTAG
     * @since  7/12/2016
     */
    public function mailToAdmin($idDayoff) {
        $this->load->library("email");

        //$data['dayoff'] = $this->dayoff_model->get_dayoff_byID($idDayoff);

        //$data['usuario'] = $this->consultas_generales->get_user_by_id($idUser);
        //$email = $data['usuario']['mail_usuario'];
        $data['msj'] = "Mr. Admin";
		$data['msj'].= "<p>Prueba de envio de correo <strong>datos que se deben enviar</p>";
        $data['msj'].= " para la Dependencia/Territorial <strong>mas datos</strong>.";

        $this->email->from("aplicaciones@vci.co", "VCI - APP");
        $this->email->to('bmottag@gmail.com'); //to($email);
        $html = $this->load->view("email", $data, true);
        $this->email->subject("Dayoff");

        $this->email->message($html);
        $this->email->send();

        return true;
    }
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
}