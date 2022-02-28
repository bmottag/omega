<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Payroll extends CI_Controller {
	
    public function __construct() {
        parent::__construct();
        $this->load->model("payroll_model");
    }

	/**
	 * Form Add Payroll
     * @since 09/11/2016
     * @author BMOTTAG
	 */
	public function add_payroll($id = 'x')
	{
			$this->load->model("general_model");
			//job´s list - (active´s items)
			$arrParam = array(
				"table" => "param_jobs",
				"order" => "job_description",
				"column" => "state",
				"id" => 1
			);
			$data['jobs'] = $this->general_model->get_basic_search($arrParam);
			
			
			//search for the last user´s record
			$arrParam = array(
				"idEmployee" => $this->session->userdata("id"),
				"limit" => 1
			);			
			$data['record'] = $this->general_model->get_task($arrParam);

			$view = 'form_add_payroll';
			
			//if the last record doesn´t have finish time
			if($data['record'] && $data['record'][0]['finish'] == '0000-00-00 00:00:00'){
				$data['start'] = $data['record'][0]['start'];
				$view = 'form_end_payroll';
			}
			
			$data["view"] = $view;
			$this->load->view("layout", $data);
	}
	
	/**
	 * Save payroll
     * @since 09/11/2016
     * @author BMOTTAG
	 */
	public function savePayroll()
	{			
			$hour = date("G:i");
			
			if ($this->payroll_model->savePayroll()) {
                $this->session->set_flashdata('retornoExito', 'have a nice shift, you started at ' . $hour . '.');
            } else {
                $this->session->set_flashdata('retornoError', '<strong>Error!!!</strong> Ask for help');
            }
			
			$dashboard = $this->session->userdata("dashboardURL");
			redirect($dashboard,'refresh');
	}
	
	/**
	 * Update finish time payroll
     * @since 11/11/2016
     * @review 2/02/2022
     * @author BMOTTAG
	 */
	public function updatePayroll()
	{	
			$idTask =  $this->input->post('hddIdentificador');
			$start =  $this->input->post('hddStart');
			$fechaStart = strtotime($start);
			$fechaStart = date("Y-m-d", $fechaStart);
			$fechaActual = date("Y-m-d");

			$hour = date("G:i");
			//verifico si el fecha es igual para el inicio y el final
			if($fechaStart == $fechaActual){
				//update working time and working hours
				$finish = date("Y-m-d G:i:s");
				if ($this->payroll_model->updateWorkingTimePayroll($start, $finish))
				{
					/**
					 * Guardar el id del periodo en la tabla task
				     * busco el periodo, sino existe lo creo
					 */
					$periodo = $this->save_period($idTask);
					$this->session->set_flashdata('retornoExito', 'have a good night, you finished at ' . $hour . '.');
				}else{
					$this->session->set_flashdata('retornoError', '<strong>Error!!!</strong> bad at math.');
				}
			}else{
				$i = 0;
				while($fechaStart != $fechaActual):
					$i++;
					if($i == 1){
						//debo actualizar el registro inicial
						$finish = $fechaStart . " 23:59:59";
						$this->payroll_model->updateWorkingTimePayroll($start, $finish);

						/**
						 * Guardar el id del periodo en la tabla task
					     * busco el periodo, sino existe lo creo
						 */
						$this->save_period($idTask);
					}
					
					$fechaStart = new DateTime($fechaStart);
					$fechaStart->modify('+1 day');
					$fechaStart = $fechaStart->format("Y-m-d");
					$start = $fechaStart . " 00:00:00";

					//revisar si ya es el ultimo dia
					if($fechaStart == $fechaActual){
						$finish = date("Y-m-d G:i:s");
					}else{
						$finish = $fechaStart . " 23:59:59";
					}
					//hago un insert nuevo
					$idTask = $this->payroll_model->insertWorkingTimePayroll($start, $finish);
					/**
					 * Guardar el id del periodo en la tabla task
				     * busco el periodo, sino existe lo creo
					 */
					$this->save_period($idTask);
				endwhile;
			}

			$dashboard = $this->session->userdata("dashboardURL");
			redirect($dashboard,'refresh');
	}
	
	/**
	 * Signature
     * @since 10/12/2016
     * @author BMOTTAG
	 */
	public function add_signature($idTask)
	{
			if (empty($idTask)) {
				show_error('ERROR!!! - You are in the wrong place.');
			}		
		
			if($_POST)
			{
				//update signature with the name of de file
				date_default_timezone_set('America/Phoenix');
				$today = date("Y-m-d"); 
				$name = "images/signature/payroll/" . $idTask . "_" . $today . ".png";
				
				$arrParam = array(
					"table" => "task",
					"primaryKey" => "id_task",
					"id" => $idTask,
					"column" => "signature",
					"value" => $name
				);
				
				$data_uri = $this->input->post("image");
				$encoded_image = explode(",", $data_uri)[1];
				$decoded_image = base64_decode($encoded_image);
				file_put_contents($name, $decoded_image);
				
				$this->load->model("general_model");
				$data['linkBack'] = "payroll/add_payroll/";
				$data['titulo'] = "<i class='fa fa-pencil fa-fw'></i>SIGNATURE";
				if ($this->general_model->updateRecord($arrParam)) {
					$this->session->set_flashdata('retornoExito', 'You just save your signature!!!');
					
					$data['clase'] = "alert-success";
					$data['msj'] = "Good job, you have save your signature.";			
				} else {
					$this->session->set_flashdata('retornoError', '<strong>Error!!!</strong> Ask for help');
					
					$data['clase'] = "alert-danger";
					$data['msj'] = "Ask for help.";
				}
		
				$data["view"] = 'template/answer';
				$this->load->view("layout", $data);
				
				//redirect("/payroll/add_payroll/",'refresh');
				
			}else{		
				$this->load->view('template/make_signature');
			}
	}
	
	/**
	 * Location
     * @since 22/11/2016
     * @author BMOTTAG
	 */
	public function view_location()
	{
			$this->load->view('location');
	}
	
    /**
     * Cargo modal- formulario para editar las horas de los empleados
     * @since 2/2/2018
     */
    public function cargarModalHours() 
	{
			header("Content-Type: text/plain; charset=utf-8"); //Para evitar problemas de acentos
			
			$data['information'] = FALSE;

			//busco inicio y fin para calcular horas de trabajo y guardar en la base de datos
			//START search info for the task
			$idTask =  $this->input->post('idTask');
			$data['information'] = $this->payroll_model->get_taskbyid($idTask);
			//END of search				
						
			$this->load->view("modal_hours_worker", $data);
    }
	
	/**
	 * Save payroll hours 
	 * Se usa cuando el adminstrador esta actualizadno las horas del empleado
     * @since 2/2/2018
     * @author BMOTTAG
	 */
	public function savePayrollHour()
	{			
			header('Content-Type: application/json');
			$data = array();
						
			$idTask = $this->input->post('hddIdentificador');
			$fechaAnterior = $this->input->post('hddfechaInicio');
			$fechaStart = $this->input->post('start_date');
			$data["idRecord"] = $idTask;

			if ($this->payroll_model->savePayrollHour()) {
				$data["result"] = true;
				$this->session->set_flashdata('retornoExito', 'You have update the payroll hour');
				
				//busco inicio y fin para calcular horas de trabajo y guardar en la base de datos
				//START search info for the task
				$idTask =  $this->input->post('hddIdentificador');
				$infoTask = $this->payroll_model->get_taskbyid($idTask);
				$start = $infoTask["start"];
				$finish = $infoTask["finish"];
				//END of search	

				//update working time and working hours
				if($this->payroll_model->updateWorkingTimePayroll($start, $finish, 1))
				{
					//verificar si cambio la fecha se debe actualizar el id del periodo
					if($fechaAnterior != $fechaStart){
						/**
						 * Guardar el id del periodo en la tabla task
					     * busco el periodo, sino existe lo creo
						 */
						$this->save_period($idTask);
					}

					$this->session->set_flashdata('retornoExito', 'You have update the payroll hour');
				}else{
					$this->session->set_flashdata('retornoError', '<strong>Error!!!</strong> bad at math.');
				}
				
				
			} else {
				$data["result"] = "error";
				$this->session->set_flashdata('retornoError', '<strong>Error!!!</strong> Ask for help');
			}
			
			echo json_encode($data);
    }

	/**
	 * Busco a que periodo pertenece y se guarda el id periodo en la tabla de task
     * @since 9/2/2022
     * @author BMOTTAG
	 */
    function save_period($idTask) 
	{
			$this->load->model("general_model");
			$idWeakPeriod = FALSE;

			//mientras no tenga ID PERIDO entonces lo busco y si no existe creo 2 mas
			while (!$idWeakPeriod) {
				$idWeakPeriod = $this->search_period($idTask);//busco el ID del periodo en los ultimos 10
								
				//no esta dentro de ninguno de los ultimos 10 periodos entonces se genero 2 peridos mas
				if(!$idWeakPeriod){
					$this->generate_period();
				}
			} 
		
			//guardo el id en la tabla task			
			$arrParam = array(
				"table" => "task",
				"primaryKey" => "id_task",
				"id" => $idTask,
				"column" => "fk_id_weak_period",
				"value" => $idWeakPeriod
			);
			if ($this->general_model->updateRecord($arrParam)) {
				return TRUE;
			}else{
				return FALSE;
			}
    }

	/**
	 * Busco a que periodo pertenece
     * @since 9/2/2022
	 */
    function search_period($idTask) 
	{
			//info for the payroll
			$this->load->model("general_model");
			$arrParam = array("idTask" => $idTask);			
			$infoPayroll = $this->general_model->get_task($arrParam);//informacion del payroll
			
			$start = strtotime($infoPayroll[0]['start']);
			$fechaStart = date( 'Y-m-j' , $start );
			
			$arrParam = array("limit" => 10);
			$infoPeriod = $this->general_model->get_weak_period($arrParam);//lista de periodos los ultimos 10

			//valido si la fecha esta dentro de alguno de los 10 ultimos periodos
			$fechaStart = date_create($fechaStart);
			
			$idWeakPeriod = FALSE;
			foreach ($infoPeriod as $data):
				$periodoIni = date_create($data['date_weak_start']);
				$periodoFin = date_create($data['date_weak_finish']);
				
				if($fechaStart >= $periodoIni && $fechaStart <= $periodoFin) {
					//esta dentro del periodo entonces saco el id del periodo
					$idWeakPeriod = $data['id_period_weak'];
					break;
				}
			endforeach;
		
			return $idWeakPeriod;
    }

	/**
	 * Genera 2 secuencias de periodos
     * @since 9/2/2022
     * @author BMOTTAG
	 */
	public function generate_period()
	{			
			$this->load->model("general_model");
			
			//genero 2 periodos nuevos
			for ($i = 0; $i < 2; $i++) 
			{
				$arrParam = array("limit" => 1);
				$infoPeriod = $this->general_model->get_period($arrParam);//info ultimo periodo
			
				//fecha inicial del siguiente periodo se le suma un dia a la fecha final del ultimo periodo
				//fecha final del siguiente periodo se le suma 14 dias a la fecha final del ultimo periodo
				$periodoIniNew = date('Y-m-d', strtotime ( '+1 day ' , strtotime ( $infoPeriod[0]['date_finish'] ) ) );//le sumo un dia 
				$periodoFinNew = date('Y-m-d',strtotime ( '+14 day ' , strtotime ( $infoPeriod[0]['date_finish'] ) ) );//le sumo 14 dias
				//sacar el año de la vigencia
				$yearPeriodo = date("Y", strtotime($periodoIniNew));

				
				//guardo el nuevo periodo
				$arrParam = array(
					"periodoIniNew" => $periodoIniNew,
					"periodoFinNew" => $periodoFinNew,
					"yearPeriodo" => $yearPeriodo
				);

				if($idPeriod = $this->payroll_model->savePeriod($arrParam))
				{
					//guardo las dos semanas del periodo
					$semana1IniNew = date('Y-m-d', strtotime ( '+1 day ' , strtotime ( $infoPeriod[0]['date_finish'] ) ) );//le sumo un dia 
					$semana1FinNew = date('Y-m-d',strtotime ( '+7 day ' , strtotime ( $infoPeriod[0]['date_finish'] ) ) );//le sumo 7 dias
					$semana2IniNew = date('Y-m-d', strtotime ( '+1 day ' , strtotime ( $semana1FinNew ) ) );//le sumo un dia 
					$semana2FinNew = date('Y-m-d',strtotime ( '+7 day ' , strtotime ( $semana1FinNew) ) );//le sumo 7 dias
					//guardo la primer semana
					$arrParam = array(
						"idPeriod" => $idPeriod,
						"semana1IniNew" => $semana1IniNew,
						"semana1FinNew" => $semana1FinNew,
						"semana2IniNew" => $semana2IniNew,
						"semana2FinNew" => $semana2FinNew,
					);
					$this->payroll_model->saveWeakPeriod($arrParam);
				}
			}
			return TRUE;
	}

	/**
	 * Payroll form search
     * @since 10/02/2022
     * @author BMOTTAG
	 */
    public function payrollSearchForm($idPeriod = 'x', $idEmployee = '' ) 
	{
			$this->load->model("general_model");

			//workers list
			$arrParam = array("state" => 1);
			$data['workersList'] = $this->general_model->get_user($arrParam);//workers list
					
			$arrParam = array("limit" => 10);
			$data['infoPeriod'] = $this->general_model->get_period($arrParam);//lista de periodos los ultimos 10	

			$data["view"] = "form_search";
			
			//Si envian los datos del filtro entonces lo direcciono a la lista respectiva con los datos de la consulta
			if($idPeriod != 'x' || $_POST){
				if($idPeriod != 'x'){
					$data['idPeriod'] =  $idPeriod;
					$data['idEmployee'] =  $idEmployee;
				}				

				if($this->input->post('period')){
					$data['idPeriod'] =  $this->input->post('period');
					$data['idEmployee'] =  $this->input->post('employee');
				}

				$arrParam = array("idPeriod" => $data['idPeriod']);
				$data['infoPeriod'] = $this->general_model->get_period($arrParam);//info del periodo

				$data['infoWeakPeriod'] = $this->general_model->get_weak_period($arrParam);//lista de periodos los ultimos 10

				$arrParam = array(
					"idPeriod" => $data['idPeriod'],
					"idEmployee" => $data['idEmployee']
				);
				$data['info'] = $this->general_model->get_users_by_period($arrParam);
				$data["view"] = "list_payroll";
			}
			
			$this->load->view("layout_calendar", $data);
    }

	/**
	 * Save paystub
     * @since 21/2/2022
     * @author BMOTTAG
	 */
	public function save_paystub()
	{	
			$idPeriod =  $this->input->post('period');
			$idEmployee =  $this->input->post('employee');	

			if ($this->payroll_model->savePaystub())
			{
				//update TABLE task set period_status to 2 (PAID)
				$this->payroll_model->updateTaskStatus();

				//update TABLE payroll_total_yearly
				//buscar el total de valores por año y usuario
				$arrParam = array(
					"idUser" => $this->input->post('hddIdUser'),
					"year" => $this->input->post('hddYear')
				);
				$this->load->model("general_model");
				$infoTotalYear = $this->general_model->get_total_yearly($arrParam);
				$this->payroll_model->updatePayrollTotalYearly($infoTotalYear);

				$data["result"] = true;
				$this->session->set_flashdata('retornoExito', "You have save the Rate!!");
			} else {
				$data["result"] = "error";
				$this->session->set_flashdata('retornoError', '<strong>Error!!!</strong> Ask for help');
			}

			redirect(base_url('payroll/payrollSearchForm/' . $idPeriod . '/' . $idEmployee), 'refresh');
    }

	/**
	 * Payroll form search, to review paystubs
     * @since 28/02/2022
     * @author BMOTTAG
	 */
    public function reviewPaystubs() 
	{
			$this->load->model("general_model");

			//workers list
			$arrParam = array("state" => 1);
			$data['workersList'] = $this->general_model->get_user($arrParam);//workers list
					
			//Si envian los datos del filtro entonces lo direcciono a la lista respectiva con los datos de la consulta
			if($_POST)
			{
				$data['year'] =  $this->input->post('year');
				$data['idEmployee'] =  $this->input->post('employee');

				$arrParam = array(
					"year" => $data['year'],
					"idEmployee" => $data['idEmployee']
				);
				$data['info'] = $this->general_model->get_paystub_by_period($arrParam);
			}
			$data["view"] = "form_search_paystubs";
			$this->load->view("layout_calendar", $data);
    }    
	
}