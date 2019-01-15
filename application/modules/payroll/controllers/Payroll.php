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
			if($data['record'] && $data['record'][0]['finish'] == 0){
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

			redirect("/dashboard",'refresh');
	}
	
	/**
	 * Update finish time payroll
     * @since 11/11/2016
     * @author BMOTTAG
	 */
	public function updatePayroll()
	{				
			if ($this->payroll_model->updatePayroll()) {

				//busco inicio y fin para calcular horas de trabajo y guardar en la base de datos
				//START search info for the task
				$idTask =  $this->input->post('hddIdentificador');
				$infoTask = $this->payroll_model->get_taskbyid($idTask);
				//END of search				

				//update working time and working hours
				$hour = date("G:i");
				if ($this->payroll_model->updateWorkingTimePayroll($infoTask)) {
					$this->session->set_flashdata('retornoExito', 'have a good night, you finished at ' . $hour . '.');
				}else{
					$this->session->set_flashdata('retornoError', '<strong>Error!!!</strong> bad at math.');
				}
				
            } else {
                $this->session->set_flashdata('retornoError', '<strong>Error!!!</strong> Ask for help');
            }

			redirect("/dashboard",'refresh');
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
     * @since 2/2/2018
     * @author BMOTTAG
	 */
	public function savePayrollHour()
	{			
			header('Content-Type: application/json');
			$data = array();
						
			$idTask = $this->input->post('hddIdentificador');
			$data["result"] = $idTask;

			if ($this->payroll_model->savePayrollHour()) {
				$data["result"] = true;
				$this->session->set_flashdata('retornoExito', 'You have update the payroll hour');
				
				//busco inicio y fin para calcular horas de trabajo y guardar en la base de datos
				//START search info for the task
				$idTask =  $this->input->post('hddIdentificador');
				$infoTask = $this->payroll_model->get_taskbyid($idTask);
				//END of search	

				//update working time and working hours
				if ($this->payroll_model->updateWorkingTimePayroll($infoTask)) {
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

	
}
