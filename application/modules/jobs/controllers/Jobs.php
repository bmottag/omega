<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Jobs extends CI_Controller {
	
    public function __construct() {
        parent::__construct();
        $this->load->model("jobs_model");
		$this->load->helper('form');
    }
	
	/**
	 * Seleccionar job para tool box
     * @since 24/10/2017
     * @author BMOTTAG
	 */
	public function index()
	{
			$this->load->model("general_model");
			//job´s list - (active´s items)
			$arrParam = array(
				"table" => "param_jobs",
				"order" => "job_description",
				"column" => "state",
				"id" => 1
			);
			$data['info'] = $this->general_model->get_basic_search($arrParam);
			
			$data["view"] = 'jobs_list';			
			$this->load->view("layout", $data);
	}
	
	/**
	 * tool_box list
     * @since 24/10/2017
     * @author BMOTTAG
	 */
	public function tool_box($idJob)
	{		
			$this->load->model("general_model");
			//job info
			$arrParam = array(
				"table" => "param_jobs",
				"order" => "job_description",
				"column" => "id_job",
				"id" => $idJob
			);
			$data['jobInfo'] = $this->general_model->get_basic_search($arrParam);
			
			//tool box info
			$arrParam = array(
				"idJob" => $idJob
			);				
			$data['information'] = $this->general_model->get_tool_box($arrParam);

			$data["view"] ='tool_box_list';
			$this->load->view("layout", $data);
	}

	/**
	 * Form Tool Box
     * @since 24/10/2017
     * @author BMOTTAG
	 */
	public function add_tool_box($idJob, $idToolBox = 'x')
	{
			$data['information'] = FALSE;
			$data['deshabilitar'] = '';
			
			$this->load->model("general_model");
			//job info
			$arrParam = array(
				"table" => "param_jobs",
				"order" => "job_description",
				"column" => "id_job",
				"id" => $idJob
			);
			$data['jobInfo'] = $this->general_model->get_basic_search($arrParam);
			
			$arrParam = array(
				"table" => "param_company",
				"order" => "company_name",
				"column" => "company_type",
				"id" => 2
			);
			$data['companyList'] = $this->general_model->get_basic_search($arrParam);//company list
			
			//si envio el id, entonces busco la informacion 
			if ($idToolBox != 'x') {
				
				$arrParam = array(
					"idToolBox" => $idToolBox
				);				
				$data['information'] = $this->general_model->get_tool_box($arrParam);
				
				$data['newHazards'] = $this->jobs_model->get_new_hazards($idToolBox);//new hazard list
				$data['toolBoxWorkers'] = $this->jobs_model->get_tool_box_workers($idToolBox);//workers list
				
				//tool box subcontractors workers list
				$data['toolBoxSubcontractorsWorkers'] = $this->jobs_model->get_tool_box_subcontractors_workers($idToolBox);
				
				//workers list
				$arrParam = array("state" => 1);
				$data['workersList'] = $this->general_model->get_user($arrParam);//workers list
				
				if (!$data['information']) { 
					show_error('ERROR!!! - You are in the wrong place.');	
				}
			}			

			$data["view"] = 'form_tool_box';
			$this->load->view("layout", $data);
	}
	
	/**
	 * Save tool box
     * @since 24/10/2017
     * @author BMOTTAG
	 */
	public function save_tool_box()
	{			
			header('Content-Type: application/json');
			$data = array();
			
			$data["idRecord"] = $this->input->post('hddIdJob');

			if ($idToolBox = $this->jobs_model->add_tool_box()) 
			{
				$data["result"] = true;
				$data["mensaje"] = "You have save the Tool Box, continue uploading the information.";
				$data["idToolBox"] = $idToolBox;
				$this->session->set_flashdata('retornoExito', 'You have save the Tool Box, continue uploading the information!!');
			} else {
				$data["result"] = "error";
				$data["mensaje"] = "Error!!! Ask for help.";
				$data["idToolBox"] = "";
				$this->session->set_flashdata('retornoError', '<strong>Error!!!</strong> Ask for help');
			}
			
			echo json_encode($data);
    }
	
	/**
	 * Signature
	 * param $typo: supervisor / worker
	 * param $idToolBox: llave principal del formulario
	 * param $idWorker: llave principal del trabajador
     * @since 24/5/2017
     * @author BMOTTAG
	 */
	public function add_signature($typo, $idJob, $idToolBox, $idWorker)
	{
			if (empty($typo) || empty($idToolBox) || empty($idWorker) ) {
				show_error('ERROR!!! - You are in the wrong place.');
			}
		
			if($_POST){
				
				//update signature with the name of the file
				if($typo == "supervisor"){
					$name = "images/signature/tool_box/" . $typo . "_" . $idToolBox . ".png";
					
					$arrParam = array(
						"table" => "tool_box",
						"primaryKey" => "id_tool_box",
						"id" => $idToolBox,
						"column" => "signature",
						"value" => $name
					);
					//enlace para regresar al formulario
					$data['linkBack'] = "jobs/add_tool_box/" . $idJob . "/" . $idToolBox;
				}elseif($typo == "worker"){
					$name = "images/signature/tool_box/" . $typo . "_" . $idWorker . ".png";
					
					$arrParam = array(
						"table" => "tool_box_workers",
						"primaryKey" => "id_tool_box_worker",
						"id" => $idWorker,
						"column" => "signature",
						"value" => $name
					);
					//enlace para regresar al formulario con ancla a la lista de trabajadores
					$data['linkBack'] = "jobs/add_tool_box/" . $idJob . "/" . $idToolBox . "#anclaWorker";
				}elseif($typo == "subcontractor"){
					$name = "images/signature/tool_box/" . $typo . "_" . $idWorker . ".png";
					
					$arrParam = array(
						"table" => "tool_box_workers_subcontractor",
						"primaryKey" => "id_tool_box_subcontractor",
						"id" => $idWorker,
						"column" => "signature",
						"value" => $name
					);
					//enlace para regresar al formulario con ancla a la lista de trabajadores		
					$data['linkBack'] = "jobs/add_tool_box/" . $idJob . "/" . $idToolBox . "#anclaSubcontractor";
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
     * Cargo modal- formulario de captura new hazard
     * @since 25/10/2017
     */
    public function cargarModalNewHazard() 
	{
			header("Content-Type: text/plain; charset=utf-8"); //Para evitar problemas de acentos

			$idToolBox = $this->input->post("idToolBox");
			//como se coloca un ID diferente para que no entre en conflicto con los otros modales, toca sacar el ID
			$porciones = explode("-", $idToolBox);
			$data["idToolBox"] = $porciones[1];

			$this->load->view("modal_new_hazard", $data);
    }
	
	/**
	 * Save new hazard
     * @since 25/10/2017
     * @author BMOTTAG
	 */
	public function save_modal_new_hazard()
	{			
			header('Content-Type: application/json');
			$data = array();
			
			$data["idToolBox"] = $this->input->post('hddidToolBox');
			
			//buscar ID del JOB
			$arrParam = array(
				"idToolBox" => $data["idToolBox"]
			);
			$this->load->model("general_model");
			$infoToolBox = $this->general_model->get_tool_box($arrParam);
			$data["idJob"] = $infoToolBox[0]["fk_id_job"];

			if ($this->jobs_model->saveNewHazard()) {
				$data["result"] = true;
				$this->session->set_flashdata('retornoExito', "You have add a new record!!");
			} else {
				$data["result"] = "error";
				$this->session->set_flashdata('retornoError', '<strong>Error!!!</strong> Ask for help');
			}

			echo json_encode($data);
    }
	
	/**
	 * Update new hazard
	 * para editar un registro de new hazard
     * @since 25/10/2017
     * @author BMOTTAG
	 */
	public function update_new_hazard()
	{					
			$idJob= $this->input->post('hddIdJob');
			$idToolBox= $this->input->post('hddIdToolBox');

			if ($this->jobs_model->updateNewHazard()) {
				$data["result"] = true;
				$this->session->set_flashdata('retornoExito', "You have update the record!!");
			} else {
				$data["result"] = "error";
				$this->session->set_flashdata('retornoError', '<strong>Error!!!</strong> Ask for help');
			}

			redirect(base_url('jobs/add_tool_box/' . $idJob . '/' . $idToolBox), 'refresh');
    }
	
    /**
     * Delete NEW HAZARD
     */
    public function deleteRecordNewHazard() 
	{
			header('Content-Type: application/json');
			
			$identificador = $this->input->post("identificador");
			//toca recuperar todos los ID
			$porciones = explode("-", $identificador);
			
			$idNewHazard = $porciones[0];
			$idToolBox = $porciones[1];
			$idJob = $porciones[2];
		
			$data["idRecord"] = $idJob . '/' . $idToolBox;

			//eliminaos registros
			$arrParam = array(
				"table" => "tool_box_new_hazard",
				"primaryKey" => "id_new_hazard",
				"id" => $idNewHazard
			);
			$this->load->model("general_model");
			if ($this->general_model->deleteRecord($arrParam)) {
				$data["result"] = true;
				$data["mensaje"] = "You have delete one record.";
				$this->session->set_flashdata('retornoExito', 'You have delete one record');
			} else {
				$data["result"] = "error";
				$data["mensaje"] = "Error!!! Ask for help.";
				$this->session->set_flashdata('retornoError', '<strong>Error!!!</strong> Ask for help');
			}
	
			echo json_encode($data);
    }
	
	/**
	 * Form Add Workers tool box
     * @since 2/11/2017
     * @author BMOTTAG
	 */
	public function add_workers_tool_box($idJob, $idToolBox)
	{
			if (empty($idJob) || empty($idToolBox)) {
				show_error('ERROR!!! - You are in the wrong place.');
			}
			
			//workers list
			$this->load->model("general_model");
			$arrParam = array("state" => 1);
			$data['workersList'] = $this->general_model->get_user($arrParam);//workers list
			
			$view = 'form_add_workers';
			$data["idToolBox"] = $idToolBox;
			$data["idJob"] = $idJob;
			
			$data["view"] = $view;
			$this->load->view("layout", $data);
	}
	
	/**
	 * Save worker
     * @since 2/11/2017
     * @author BMOTTAG
	 */
	public function save_tool_box_workers()
	{			
			header('Content-Type: application/json');
			$data = array();
			$idToolBox = $this->input->post('hddIdToolBox');
			$idJob = $this->input->post('hddIdJob');
			
			$data["idRecord"] = $idJob . "/" . $idToolBox;

			if ($this->jobs_model->add_tool_box_worker($idToolBox)) {
				$data["result"] = true;
				$data["mensaje"] = "Solicitud guardada correctamente.";
								
				$this->session->set_flashdata('retornoExito', 'You have add the Workers, remember to get the signature of each one.');
			} else {
				$data["result"] = "error";
				$data["mensaje"] = "Error al guardar. Intente nuevamente o actualice la p\u00e1gina.";
				
				$this->session->set_flashdata('retornoError', '<strong>Error!!!</strong> Ask for help');
			}

			echo json_encode($data);
    }	
	
    /**
     * Delete tool box worker
     */
    public function deleteToolBoxWorker($idJob, $idToolBox, $idToolBoxWorker) 
	{
			if (empty($idJob) || empty($idToolBox) || empty($idToolBoxWorker) ) {
				show_error('ERROR!!! - You are in the wrong place.');
			}
		
			$arrParam = array(
				"table" => "tool_box_workers",
				"primaryKey" => "id_tool_box_worker",
				"id" => $idToolBoxWorker
			);

			if ($this->jobs_model->deleteRecord($arrParam)) {
				$this->session->set_flashdata('retornoExito', 'You have delete one worker.');
			} else {
				$this->session->set_flashdata('retornoError', '<strong>Error!!!</strong> Ask for help');
			}
			redirect(base_url('jobs/add_tool_box/' . $idJob . '/' . $idToolBox), 'refresh');
    }
	
	/**
	 * Form ERP
     * @since 20/11/2017
     * @author BMOTTAG
	 */
	public function erp($idJob, $error = '')
	{
			$data['information'] = FALSE;
			$data['trainingWorkers'] = FALSE;
			$data['deshabilitar'] = '';
			$data['error'] = $error; //se usa para mostrar los errores al cargar la imagen 
			
			$this->load->model("general_model");
			//job info
			$arrParam = array(
				"table" => "param_jobs",
				"order" => "job_description",
				"column" => "id_job",
				"id" => $idJob
			);
			$data['jobInfo'] = $this->general_model->get_basic_search($arrParam);
			
			//worker´s list
			$arrParam = array("state" => 1);
			$data['workersList'] = $this->general_model->get_user($arrParam);//workers list
						
			//ERP info
			$arrParam = array(
				"idJob" => $idJob
			);				
			$data['information'] = $this->jobs_model->get_erp($arrParam);
			

			//erp training list
			$data['trainingWorkers'] = $this->jobs_model->get_erp_training_workers($idJob);	


			$data["view"] = 'form_erp';
			$this->load->view("layout", $data);
	}
	
	/**
	 * Save ERP
     * @since 20/11/2017
     * @author BMOTTAG
	 */
	public function save_erp()
	{			
			header('Content-Type: application/json');
			$data = array();
			
			$data["idRecord"] = $this->input->post('hddIdJob');

			if ($this->jobs_model->add_erp()) 
			{
				$data["result"] = true;
				$data["mensaje"] = "You have save the ERP.";
				$this->session->set_flashdata('retornoExito', 'You have save the ERP!!');
			} else {
				$data["result"] = "error";
				$data["mensaje"] = "Error!!! Ask for help.";
				$this->session->set_flashdata('retornoError', '<strong>Error!!!</strong> Ask for help');
			}

			echo json_encode($data);
    }
	
	/**
	 * Form Add Workers for ERP Trainning
     * @since 23/11/2017
     * @author BMOTTAG
	 */
	public function add_workers_training($id)
	{
			if (empty($id)) {
				show_error('ERROR!!! - You are in the wrong place.');
			}
			
			//workers list
			$this->load->model("general_model");
			$arrParam = array("state" => 1);
			$data['workersList'] = $this->general_model->get_user($arrParam);//workers list
			
			$view = 'form_add_workers_training';
			$data["idJob"] = $id;
			$data["view"] = $view;
			$this->load->view("layout", $data);
	}
	
	/**
	 * Save worker trainigno
     * @since 23/11/2017
     * @author BMOTTAG
	 */
	public function save_training_workers()
	{			
			header('Content-Type: application/json');
			$data = array();
			$idJob = $this->input->post('hddIdJob');
			
			$data["idRecord"] = $idJob;

			if ($this->jobs_model->add_training_worker($idJob)) {
				$data["result"] = true;
				$data["mensaje"] = "Solicitud guardada correctamente.";
								
				$this->session->set_flashdata('retornoExito', 'You have add the Workers, remember to get the signature of each one.');
			} else {
				$data["result"] = "error";
				$data["mensaje"] = "Error al guardar. Intente nuevamente o actualice la p\u00e1gina.";
				
				$this->session->set_flashdata('retornoError', '<strong>Error!!!</strong> Ask for help');
			}

			echo json_encode($data);
    }
	
    /**
     * Delete ERP TRAINING worker
     */
    public function deleteERPTRAINGINWorker($idJob, $idErpTrainingWorker) 
	{
			if (empty($idJob) || empty($idErpTrainingWorker) ) {
				show_error('ERROR!!! - You are in the wrong place.');
			}
		
			$arrParam = array(
				"table" => "erp_training_workers",
				"primaryKey" => "id_erp_training_worker",
				"id" => $idErpTrainingWorker
			);

			if ($this->jobs_model->deleteRecord($arrParam)) {
				$this->session->set_flashdata('retornoExito', 'You have delete one worker.');
			} else {
				$this->session->set_flashdata('retornoError', '<strong>Error!!!</strong> Ask for help');
			}
			redirect(base_url('jobs/erp_personnel/' . $idJob), 'refresh');
    }
	
    /**
     * Save one worker to the ERP TRAINING
     */
    public function save_one_erp_training_worker() 
	{
			$idJob = $this->input->post('hddId');

			if ($this->jobs_model->saveOneWorker()) {
				$this->session->set_flashdata('retornoExito', 'You have Add one Worker.');
			} else {
				$this->session->set_flashdata('retornoError', '<strong>Error!!!</strong> Ask for help');
			}
			redirect(base_url('jobs/erp_personnel/' . $idJob), 'refresh');
    }
	
	/**
	 * Generate Template Report in PDF
	 * @param int $idToolBox
     * @since 2/11/2017
     * @author BMOTTAG
	 */
	public function generaTemplatePDF($idToolBox)
	{
			$this->load->library('Pdf');
			
			// create new PDF document
			$pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);

			// set document information
			$pdf->SetCreator(PDF_CREATOR);
			$pdf->SetAuthor('VCI');
			$pdf->SetTitle('Tool Box report');
			$pdf->SetSubject('TCPDF Tutorial');

			// set default header data
			$pdf->SetHeaderData(PDF_HEADER_LOGO, PDF_HEADER_LOGO_WIDTH, '', PDF_HEADER_STRING, array(0,64,255), array(0,64,128));

			// set header and footer fonts
			$pdf->setHeaderFont(Array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));
			$pdf->setFooterFont(Array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));

			// set default monospaced font
			$pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);
			
			$pdf->setPrintFooter(false); //no imprime el pie ni la linea 

			// set margins
			$pdf->SetMargins(PDF_MARGIN_LEFT, PDF_MARGIN_TOP, PDF_MARGIN_RIGHT);
			$pdf->SetHeaderMargin(PDF_MARGIN_HEADER);
			$pdf->SetFooterMargin(PDF_MARGIN_FOOTER);

			// set auto page breaks
			$pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);

			// set image scale factor
			$pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);

			// set some language-dependent strings (optional)
			if (@file_exists(dirname(__FILE__).'/lang/eng.php')) {
				require_once(dirname(__FILE__).'/lang/eng.php');
				$pdf->setLanguageArray($l);
			}

			// ---------------------------------------------------------

			// set font
			$pdf->SetFont('dejavusans', '', 8);

			// writeHTML($html, $ln=true, $fill=false, $reseth=false, $cell=false, $align='')
			// writeHTMLCell($w, $h, $x, $y, $html='', $border=0, $ln=0, $fill=0, $reseth=true, $align='', $autopadding=true)
		
			$this->load->model("general_model");
			$arrParam = array("idToolBox" => $idToolBox);
			$data['info'] = $this->general_model->get_tool_box($arrParam);
			
			$data['newHazards'] = $this->jobs_model->get_new_hazards($idToolBox);//new hazard list
			$data['toolBoxWorkers'] = $this->jobs_model->get_tool_box_workers($idToolBox);//workers list
			$data['subcontractors'] = $this->jobs_model->get_tool_box_subcontractors_workers($idToolBox);//subcontractor list

			// - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
			// Print a table
				
			// add a page
			$pdf->AddPage();

			$html = $this->load->view("reporte_pdf", $data, true);
										
			// output the HTML content
			$pdf->writeHTML($html, true, false, true, false, '');
		

			// Print some HTML Cells

			// reset pointer to the last page
			$pdf->lastPage();

ob_end_clean();
			//Close and output PDF document
			$pdf->Output('tool_box_' . $idToolBox . '.pdf', 'I');

			//============================================================+
			// END OF FILE
			//============================================================+
		
	}	
	
	/**
	 * Generate ERP Report in PDF
	 * @param int $idERP
     * @since 20/11/2017
     * @author BMOTTAG
	 */
	public function generaERPPDF($idERP)
	{
			$this->load->library('Pdf');
			
			// create new PDF document
			$pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);

			// set document information
			$pdf->SetCreator(PDF_CREATOR);
			$pdf->SetAuthor('VCI');
			$pdf->SetTitle('ERP report');
			$pdf->SetSubject('TCPDF Tutorial');

			// set default header data
			$pdf->SetHeaderData(PDF_HEADER_LOGO, PDF_HEADER_LOGO_WIDTH, '', PDF_HEADER_STRING, array(0,64,255), array(0,64,128));

			// set header and footer fonts
			$pdf->setHeaderFont(Array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));
			$pdf->setFooterFont(Array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));

			// set default monospaced font
			$pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);
			
			$pdf->setPrintFooter(false); //no imprime el pie ni la linea 

			// set margins
			$pdf->SetMargins(PDF_MARGIN_LEFT, PDF_MARGIN_TOP, PDF_MARGIN_RIGHT);
			$pdf->SetHeaderMargin(PDF_MARGIN_HEADER);
			$pdf->SetFooterMargin(PDF_MARGIN_FOOTER);

			// set auto page breaks
			$pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);

			// set image scale factor
			$pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);

			// set some language-dependent strings (optional)
			if (@file_exists(dirname(__FILE__).'/lang/eng.php')) {
				require_once(dirname(__FILE__).'/lang/eng.php');
				$pdf->setLanguageArray($l);
			}

			// ---------------------------------------------------------

			// set font
			$pdf->SetFont('dejavusans', '', 8);

			// writeHTML($html, $ln=true, $fill=false, $reseth=false, $cell=false, $align='')
			// writeHTMLCell($w, $h, $x, $y, $html='', $border=0, $ln=0, $fill=0, $reseth=true, $align='', $autopadding=true)
		
			$arrParam = array("idERP" => $idERP);
			$data['info'] = $this->jobs_model->get_erp($arrParam);
			
			$data['trainingWorkers'] = $this->jobs_model->get_erp_training_workers($data['info'][0]['fk_id_job']);

			// - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
			// Print a table
				
			// add a page
			$pdf->AddPage();

			// create some HTML content
	$html = '<p></p><p></p><p></p><p></p>
	<p><h1 align="center" style="color:#337ab7;">EMERGENCY RESPONSE PLAN</h1></p>
	<p></p><p></p><p></p><p></p><p></p>
	<p><h2 align="center" style="color:#337ab7;">Project code:<br>' . $data['info'][0]["job_description"] . '</h2></p>
	<p></p><p></p><p></p><p></p><p></p>
	<p><h2 align="center" style="color:#337ab7;">Facility Address:<br>' . $data['info'][0]["address"] . '</h2></p>
	<p></p><p></p><p></p><p></p><p></p>
	<p><h2 align="center" style="color:#337ab7;">DATE PREPARED:<br>' . $data['info'][0]["date_erp"] . '</h2></p>';
										
			// output the HTML content
			$pdf->writeHTML($html, true, false, true, false, '');
		

			// add a page
			$pdf->AddPage();

			// create some HTML content
	$html = '<p><h1 align="center" style="color:#337ab7;">EMERGENCY PERSONNEL NAMES AND PHONE NUMBERS</h1></p>
				<style>
				table {
					font-family: arial, sans-serif;
					border-collapse: collapse;
					width: 100%;
				}

				td, th {
					border: 1px solid #dddddd;
					text-align: left;
					padding: 8px;
				}
				</style>
			<table border="0" cellspacing="0" cellpadding="5">
	
				<tr>
					<th bgcolor="#337ab7" style="color:white;" width="30%"><strong>Site supervisor: </strong></th>
					<th width="30%">' . $data['info'][0]['responsible']. '</th>
					<th bgcolor="#337ab7" style="color:white;" width="20%"><strong>Phone: </strong></th>
					<th width="20%">' . $data['info'][0]['phone_res']. '</th>
				</tr>
				
				<tr>
					<th bgcolor="#337ab7" style="color:white;"><strong>Emergency coordinator: </strong></th>
					<th>' . $data['info'][0]['coordinator']. '</th>
					<th bgcolor="#337ab7" style="color:white;"><strong>Phone: </strong></th>
					<th>' . $data['info'][0]['phone_co']. '</th>
				</tr>
			
			</table>';
		
			// output the HTML content
			$pdf->writeHTML($html, true, false, true, false, '');	
			// set font
			$pdf->SetFont('dejavusans', '', 10);		
			// add a page
//			$pdf->AddPage();

			$html = $this->load->view("reporte_evacuation_pdf", $data, true);
										
			// output the HTML content
			$pdf->writeHTML($html, true, false, true, false, '');

			
			// add a page
			$pdf->AddPage();

			$html = $this->load->view("reporte_evacuation_procedures_pdf", $data, true);
										
			// output the HTML content
			$pdf->writeHTML($html, true, false, true, false, '');

			// add a page
			$pdf->AddPage();

			$html = $this->load->view("reporte_evacuation_procedures_fire_pdf", $data, true);
										
			// output the HTML content
			$pdf->writeHTML($html, true, false, true, false, '');

			
			// add a page
			$pdf->AddPage();

			$html = $this->load->view("reporte_evacuation_procedures_chemical_pdf", $data, true);
										
			// output the HTML content
			$pdf->writeHTML($html, true, false, true, false, '');


			// add a page
			$pdf->AddPage();

			$html = $this->load->view("reporte_evacuation_procedures_weather_pdf", $data, true);
										
			// output the HTML content
			$pdf->writeHTML($html, true, false, true, false, '');

			
			
			// add a page
			$pdf->AddPage();

			$html = $this->load->view("reporte_training_pdf", $data, true);
										
			// output the HTML content
			$pdf->writeHTML($html, true, false, true, false, '');
			
			// reset pointer to the last page
			$pdf->lastPage();


			//Close and output PDF document
			$pdf->Output('erp_' . $idERP . '.pdf', 'I');

			//============================================================+
			// END OF FILE
			//============================================================+
		
	}
	
	/**
	 * FUNCIÓN PARA SUBIR LA IMAGEN 
	 */
    function do_upload() 
	{
        $config['upload_path'] = './images/erp/';
        $config['overwrite'] = true;
        $config['allowed_types'] = 'gif|jpg|png|pdf|jpeg';
        $config['max_size'] = '3000';
        $config['max_width'] = '3200';
        $config['max_height'] = '2400';
        $idJob = $this->input->post("hddIdJobMap");
        $config['file_name'] = $idJob;

        $this->load->library('upload', $config);
        //SI LA IMAGEN FALLA AL SUBIR MOSTRAMOS EL ERROR EN LA VISTA 
        if (!$this->upload->do_upload()) {
            $error = $this->upload->display_errors();
            $this->erp_map($idJob,$error);
        } else {
            $file_info = $this->upload->data();//subimos la imagen
			
            //USAMOS LA FUNCIÓN create_thumbnail Y LE PASAMOS EL NOMBRE DE LA IMAGEN,
            //ASÍ YA TENEMOS LA IMAGEN REDIMENSIONADA
			$this->_create_thumbnail($file_info['file_name']);
			$data = array('upload_data' => $this->upload->data());
			$imagen = $file_info['file_name'];
			$path = "images/erp/" . $imagen;
			
			//actualizamos el campo photo
			$arrParam = array(
				"table" => "erp",
				"primaryKey" => "fk_id_job",
				"id" => $idJob,
				"column" => "evacuation_map",
				"value" => $path
			);

			$this->load->model("general_model");
			
			if($this->general_model->updateRecord($arrParam))
			{
				$data['clase'] = "alert-success";
				$data['msj'] = "Se subio la imagen con éxito.";
			}else{
				$data['clase'] = "alert-danger";
				$data['msj'] = "Error, contactarse con el administrador.";
			}
						
			redirect('jobs/erp_map/' . $idJob);
        }
    }
	
    //FUNCIÓN PARA CREAR LA MINIATURA A LA MEDIDA QUE LE DIGAMOS
    function _create_thumbnail($filename) 
	{
        $config['image_library'] = 'gd2';
        //CARPETA EN LA QUE ESTÁ LA IMAGEN A REDIMENSIONAR
        $config['source_image'] = 'images/erp/' . $filename;
        $config['create_thumb'] = TRUE;
        $config['maintain_ratio'] = TRUE;
        //CARPETA EN LA QUE GUARDAMOS LA MINIATURA
        $config['new_image'] = 'images/erp/thumbs/';
        $config['width'] = 150;
        $config['height'] = 150;
        $this->load->library('image_lib', $config);
        $this->image_lib->resize();
    }
	
	/**
	 * Form Upload Hazards 
     * @since 27/11/2017
     * @author BMOTTAG
	 */
	public function hazards($idJob)
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

			$data["view"] = "hazards_list";
			$this->load->view("layout", $data);
	}
	
	/**
	 * Form Add Hazards
     * @since 27/11/2017
     * @author BMOTTAG
	 */
	public function add_hazards($idJob)
	{
			if (empty($idJob)) {
				show_error('ERROR!!! - You are in the wrong place.');
			}
			
			$data['activityList'] = $this->jobs_model->get_activity_list();			
			
			$data["idJob"] = $idJob;
			$data["view"] = 'form_add_hazards';
			$this->load->view("layout", $data);
	}
	
	/**
	 * Save hazards
     * @since 27/11/2017
     * @author BMOTTAG
	 */
	public function save_safety_hazards()
	{			
			header('Content-Type: application/json');
			$data = array();
			$data["idJob"] = $this->input->post('hddId');

			if ($this->jobs_model->add_safety_hazard($data["idJob"])) {
				$data["result"] = true;
				
				$this->jobs_model->add_hazard_log();
				
				$this->session->set_flashdata('retornoExito', 'You have add Hazards.');
			} else {
				$data["result"] = "error";
				
				$this->session->set_flashdata('retornoError', '<strong>Error!!!</strong> Ask for help');
			}

			echo json_encode($data);
    }

	/**
	 * Hazards logs
     * @since 21/8/2018
     * @author BMOTTAG
	 */
	public function hazards_logs($idJob)
	{
			$arrParam = array("idJob" => $idJob);
			$data['info'] = $this->jobs_model->get_hazards_logs($arrParam);
			
			$data["view"] = 'hazards_logs';
			$this->load->view("layout", $data);
	}
	
    /**
     * Delete Job hazard
     */
    public function deleteJobHazard($idJobHazard, $idJob) 
	{
			if (empty($idJobHazard) || empty($idJob) ) {
				show_error('ERROR!!! - You are in the wrong place.');
			}
		
			$arrParam = array(
				"table" => "job_hazards",
				"primaryKey" => "id_job_hazard",
				"id" => $idJobHazard
			);
			
			$this->load->model("general_model");
			if ($this->general_model->deleteRecord($arrParam)) {
				$this->session->set_flashdata('retornoExito', 'You have delete one hazard.');
			} else {
				$this->session->set_flashdata('retornoError', '<strong>Error!!!</strong> Ask for help');
			}
			redirect(base_url('jobs/hazards/' . $idJob), 'refresh');
    }
	
	/**
	 * Form Upload Locates 
     * @since 29/11/2017
     * @author BMOTTAG
	 */
	public function locates($idJob, $error = '')
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

			//locates list
			$data['locates'] = $this->jobs_model->get_job_locates($idJob);
			$data['error'] = $error; //se usa para mostrar los errores al cargar la imagen 			

			$data["view"] = "locates_list";
			$this->load->view("layout", $data);
	}
	
	/**
	 * FUNCIÓN PARA SUBIR LA IMAGEN 
	 */
    function do_upload_locates() 
	{
        $config['upload_path'] = './images/locates/';
        $config['overwrite'] = false;
        $config['allowed_types'] = 'gif|jpg|png|pdf|jpeg';
        $config['max_size'] = '3000';
        $config['max_width'] = '3200';
        $config['max_height'] = '2400';
        $idJob = $this->input->post("hddIdJob");

        $this->load->library('upload', $config);
        //SI LA IMAGEN FALLA AL SUBIR MOSTRAMOS EL ERROR EN LA VISTA 
        if (!$this->upload->do_upload()) {
            $error = $this->upload->display_errors();
            $this->locates($idJob,$error);
        } else {
            $file_info = $this->upload->data();//subimos la imagen
			
			$data = array('upload_data' => $this->upload->data());
			$imagen = $file_info['file_name'];
			$path = "images/locates/" . $imagen;
			
			//insertar datos
			if($this->jobs_model->add_locates($path))
			{
				$this->session->set_flashdata('retornoExito', 'You have upload the image.');
			}else{
				$this->session->set_flashdata('retornoError', '<strong>Error!!!</strong> Ask for help');
			}
						
			redirect('jobs/locates/' . $idJob);
        }
    }
	
    /**
     * Delete Job locate
     */
    public function deleteJobLocate($idJobLocate, $idJob) 
	{
			if (empty($idJobLocate) || empty($idJob) ) {
				show_error('ERROR!!! - You are in the wrong place.');
			}
		
			$arrParam = array(
				"table" => "job_locates",
				"primaryKey" => "id_job_locates",
				"id" => $idJobLocate
			);
			
			$this->load->model("general_model");
			if ($this->general_model->deleteRecord($arrParam)) {
				$this->session->set_flashdata('retornoExito', 'You have delete the image.');
			} else {
				$this->session->set_flashdata('retornoError', '<strong>Error!!!</strong> Ask for help');
			}
			redirect(base_url('jobs/locates/' . $idJob), 'refresh');
    }
	
	/**
	 * SAFETY list
     * @since 2/1/2018
     * @author BMOTTAG
	 */
	public function safety($idJob)
	{		
			$this->load->model("general_model");
			//job info
			$arrParam = array(
				"table" => "param_jobs",
				"order" => "job_description",
				"column" => "id_job",
				"id" => $idJob
			);
			$data['jobInfo'] = $this->general_model->get_basic_search($arrParam);
			
			//info de safety
			$arrParam = array(
				"limit" => 30,
				"idJob" => $idJob
			);						
			$data['information'] = $this->general_model->get_safety($arrParam);//info de safety
			
			//hazards list
			$data['hazards'] = $this->general_model->get_job_hazards($idJob);

			$data["view"] ='safety_list';
			$this->load->view("layout", $data);
	}
	
	/**
	 * Form JSO
     * @since 3/1/2018
     * @author BMOTTAG
	 */
	public function jso($idJob)
	{
			$data['information'] = FALSE;
			$data['trainingWorkers'] = FALSE;
			$data['deshabilitar'] = '';
			
			$this->load->model("general_model");
			//job info
			$arrParam = array(
				"table" => "param_jobs",
				"order" => "job_description",
				"column" => "id_job",
				"id" => $idJob
			);
			$data['jobInfo'] = $this->general_model->get_basic_search($arrParam);
			
			//workers list
			$arrParam = array("state" => 1);
			$data['workersList'] = $this->general_model->get_user($arrParam);//workers list

			//JSO info
			$arrParam = array("idJob" => $idJob);
			$data['information'] = $this->jobs_model->get_jso($arrParam);
			
			$data['infoWorkers'] = "";
			if($data['information']){
				$arrParam = array("idJobJso" => $data['information'][0]['id_job_jso']);
				$data['infoWorkers'] = $this->jobs_model->get_jso_workers($arrParam);
			}

			$data["view"] = 'form_jso';
			$this->load->view("layout", $data);
	}
	
	/**
	 * Save JSO
     * @since 3/1/2018
     * @author BMOTTAG
	 */
	public function save_jso()
	{			
			header('Content-Type: application/json');
			$data = array();
			
			$data["idRecord"] = $this->input->post('hddIdJob');

			if ($this->jobs_model->add_jso()) 
			{
				$data["result"] = true;
				$data["mensaje"] = "You have save the JSO.";
				$this->session->set_flashdata('retornoExito', 'You have save the JSO!!');
			} else {
				$data["result"] = "error";
				$data["mensaje"] = "Error!!! Ask for help.";
				$this->session->set_flashdata('retornoError', '<strong>Error!!!</strong> Ask for help');
			}

			echo json_encode($data);
    }
	
	/**
	 * Signature
	 * param $typo: supervisor / worker
	 * param $idJSO: llave principal del formulario
	 * param $idWorker: llave principal del trabajador
     * @since 5/1/2018
     * @author BMOTTAG
	 */
	public function add_signature_jso($typo, $idJob, $idJSO, $idWorker = 'x')
	{
			if (empty($typo) || empty($idJSO)) {
				show_error('ERROR!!! - You are in the wrong place.');
			}
		
			if($_POST){
				
				//update signature with the name of the file
				if($typo == "supervisor"){
					$name = "images/signature/jso/" . $typo . "_" . $idJSO . ".png";
					
					$arrParam = array(
						"table" => "job_jso",
						"primaryKey" => "id_job_jso",
						"id" => $idJSO,
						"column" => "supervisor_signature",
						"value" => $name
					);
					//enlace para regresar al formulario
					$data['linkBack'] = "jobs/jso/" . $idJob;
				}elseif($typo == "manager"){
					$name = "images/signature/jso/" . $typo . "_" . $idJSO . ".png";
					
					$arrParam = array(
						"table" => "job_jso",
						"primaryKey" => "id_job_jso",
						"id" => $idJSO,
						"column" => "manager_signature",
						"value" => $name
					);
					//enlace para regresar al formulario
					$data['linkBack'] = "jobs/jso/" . $idJob;
				}elseif($typo == "worker"){
					$name = "images/signature/jso/" . $typo . "_" . $idWorker . ".png";
					
					$arrParam = array(
						"table" => "job_jso_workers",
						"primaryKey" => "id_job_jso_worker",
						"id" => $idWorker,
						"column" => "signature",
						"value" => $name
					);
					//enlace para regresar al formulario con ancla a la lista de trabajadores
					$data['linkBack'] = "jobs/jso/" . $idJob;
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
     * Cargo modal- formulario de captura workers para jso
     * @since 5/1/2018
     */
    public function cargarModalWorker() 
	{
			header("Content-Type: text/plain; charset=utf-8"); //Para evitar problemas de acentos
			
			$data['information'] = FALSE;
			$data["idJobJso"] = $this->input->post("idJobJso");
			$data["idJobJsoWorker"] = $this->input->post("idJobJsoWorker");
			
			if ($data["idJobJsoWorker"] != 'x') {
				$arrParam = array("idJobJsoWorker" => $data["idJobJsoWorker"]);
				$data['information'] = $this->jobs_model->get_jso_workers($arrParam);//info bloques
				
				$data["idJobJso"] = $data['information'][0]['fk_id_job_jso'];
			}
			
			$this->load->view("modal_jso_worker", $data);
    }
	
	/**
	 * Save formularios
     * @since 5/1/2018
     * @author BMOTTAG
	 */
	public function saveJSOWorker()
	{			
			header('Content-Type: application/json');
			$data = array();
						
			$idJobJso = $this->input->post('hddidJobJso');
			$idJobWorker = $this->input->post('hddidJobJsoWorker');
			
			//JSO info
			$arrParam = array("idJobJso" => $idJobJso);
			$infoJSO = $this->jobs_model->get_jso($arrParam);
			
			$data["idRecord"] = $infoJSO[0]['fk_id_job'];

			$msj = "You have add a new worker.";
			if ($idJobWorker != '') {
				$msj = "You have edit the worker.";
			}

			if ($this->jobs_model->saveJSOWorker()) {
				$data["result"] = true;
				$this->session->set_flashdata('retornoExito', $msj);
			} else {
				$data["result"] = "error";
				$this->session->set_flashdata('retornoError', '<strong>Error!!!</strong> Ask for help');
			}
			
			echo json_encode($data);
    }
	
	/**
	 * Generate JSO Report in PDF
	 * @param int $idJSO
     * @since 7/1/2018
     * @author BMOTTAG
	 */
	public function generaJSOPDF($idJSO)
	{
			$this->load->library('Pdf');
			
			// create new PDF document
			$pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);

			// set document information
			$pdf->SetCreator(PDF_CREATOR);
			$pdf->SetAuthor('VCI');
			$pdf->SetTitle('JSO report');
			$pdf->SetSubject('TCPDF Tutorial');

			// set default header data
			$pdf->SetHeaderData(PDF_HEADER_LOGO, PDF_HEADER_LOGO_WIDTH, '', PDF_HEADER_STRING, array(0,64,255), array(0,64,128));

			// set header and footer fonts
			$pdf->setHeaderFont(Array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));
			$pdf->setFooterFont(Array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));

			// set default monospaced font
			$pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);
			
			$pdf->setPrintFooter(false); //no imprime el pie ni la linea 

			// set margins
			$pdf->SetMargins(PDF_MARGIN_LEFT, PDF_MARGIN_TOP, PDF_MARGIN_RIGHT);
			$pdf->SetHeaderMargin(PDF_MARGIN_HEADER);
			$pdf->SetFooterMargin(PDF_MARGIN_FOOTER);

			// set auto page breaks
			$pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);

			// set image scale factor
			$pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);

			// set some language-dependent strings (optional)
			if (@file_exists(dirname(__FILE__).'/lang/eng.php')) {
				require_once(dirname(__FILE__).'/lang/eng.php');
				$pdf->setLanguageArray($l);
			}

			// ---------------------------------------------------------

			// set font
			$pdf->SetFont('dejavusans', '', 8);

			// writeHTML($html, $ln=true, $fill=false, $reseth=false, $cell=false, $align='')
			// writeHTMLCell($w, $h, $x, $y, $html='', $border=0, $ln=0, $fill=0, $reseth=true, $align='', $autopadding=true)
		
			$arrParam = array("idJobJso" => $idJSO);
						
			$data['info'] = $this->jobs_model->get_jso($arrParam);
			$data['workers'] = $this->jobs_model->get_jso_workers($arrParam);

			// - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
			// Print a table
				
			// add a page
			$pdf->AddPage();

			$html = $this->load->view("reporte_jso", $data, true);
			
			// output the HTML content
			$pdf->writeHTML($html, true, false, true, false, '');
			
			
			if($data['workers']){
				//$pdf->AddPage();
				$html = $this->load->view("reporte_jso_workers", $data, true);
				$pdf->writeHTML($html, true, false, true, false, '');
			}

			// Print some HTML Cells

			// reset pointer to the last page
			$pdf->lastPage();


			//Close and output PDF document
			$pdf->Output('jso_' . $idJSO . '.pdf', 'I');

			//============================================================+
			// END OF FILE
			//============================================================+
		
	}
	
	/**
	 * Form ERP - PERSONNEL
     * @since 4/5/2018
     * @author BMOTTAG
	 */
	public function erp_personnel($idJob, $error = '')
	{
			$data['information'] = FALSE;
			$data['trainingWorkers'] = FALSE;
			$data['deshabilitar'] = '';
			$data['error'] = $error; //se usa para mostrar los errores al cargar la imagen 
			
			$this->load->model("general_model");
			//job info
			$arrParam = array(
				"table" => "param_jobs",
				"order" => "job_description",
				"column" => "id_job",
				"id" => $idJob
			);
			$data['jobInfo'] = $this->general_model->get_basic_search($arrParam);
			
			//worker´s list
			$arrParam = array("state" => 1);
			$data['workersList'] = $this->general_model->get_user($arrParam);//workers list
						
			//ERP info
			$arrParam = array(
				"idJob" => $idJob
			);				
			$data['information'] = $this->jobs_model->get_erp($arrParam);
			

			//erp training list
			$data['trainingWorkers'] = $this->jobs_model->get_erp_training_workers($idJob);	


			$data["view"] = 'form_erp_personnel';
			$this->load->view("layout", $data);
	}
	
	/**
	 * Form ERP - MAP
     * @since 4/5/2018
     * @author BMOTTAG
	 */
	public function erp_map($idJob, $error = '')
	{
			$data['information'] = FALSE;
			$data['deshabilitar'] = '';
			$data['error'] = $error; //se usa para mostrar los errores al cargar la imagen 
			
			$this->load->model("general_model");
			//job info
			$arrParam = array(
				"table" => "param_jobs",
				"order" => "job_description",
				"column" => "id_job",
				"id" => $idJob
			);
			$data['jobInfo'] = $this->general_model->get_basic_search($arrParam);
						
			//ERP info
			$arrParam = array(
				"idJob" => $idJob
			);				
			$data['information'] = $this->jobs_model->get_erp($arrParam);
			
			$data["view"] = 'form_erp_map';
			$this->load->view("layout", $data);
	}
	
    /**
     * Safe one worker to the TOOL BOX
     */
    public function tool_box_One_Worker() 
	{
			$idJob = $this->input->post('hddIdJob');
			$idToolBox = $this->input->post('hddIdToolBox');

			if ($this->jobs_model->toolBoxSaveOneWorker()) {
				$this->session->set_flashdata('retornoExito', 'You have Add one Worker.');
			} else {
				$this->session->set_flashdata('retornoError', '<strong>Error!!!</strong> Ask for help');
			}
			redirect(base_url('jobs/add_tool_box/' . $idJob . "/" . $idToolBox ), 'refresh');
    }
	
	/**
	 * Generate JHA - JOB HAZARDS ANALYSIS Report in PDF
	 * @param int $idJobHazardLog
     * @since 6/9/2018
     * @author BMOTTAG
	 */
	public function generaJHAPDF($idJobHazardLog)
	{
			$this->load->library('Pdf');
			
			// create new PDF document
			$pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);

			// set document information
			$pdf->SetCreator(PDF_CREATOR);
			$pdf->SetAuthor('VCI');
			$pdf->SetTitle('JOB HAZARDS ANALYSIS report');
			$pdf->SetSubject('TCPDF Tutorial');

			// set default header data
			$pdf->SetHeaderData(PDF_HEADER_LOGO, PDF_HEADER_LOGO_WIDTH, '', PDF_HEADER_STRING, array(0,64,255), array(0,64,128));

			// set header and footer fonts
			$pdf->setHeaderFont(Array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));
			$pdf->setFooterFont(Array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));

			// set default monospaced font
			$pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);
			
			$pdf->setPrintFooter(false); //no imprime el pie ni la linea 

			// set margins
			$pdf->SetMargins(PDF_MARGIN_LEFT, PDF_MARGIN_TOP, PDF_MARGIN_RIGHT);
			$pdf->SetHeaderMargin(PDF_MARGIN_HEADER);
			$pdf->SetFooterMargin(PDF_MARGIN_FOOTER);

			// set auto page breaks
			$pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);

			// set image scale factor
			$pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);

			// set some language-dependent strings (optional)
			if (@file_exists(dirname(__FILE__).'/lang/eng.php')) {
				require_once(dirname(__FILE__).'/lang/eng.php');
				$pdf->setLanguageArray($l);
			}

			// ---------------------------------------------------------

			// set font
			$pdf->SetFont('dejavusans', '', 8);

			// writeHTML($html, $ln=true, $fill=false, $reseth=false, $cell=false, $align='')
			// writeHTMLCell($w, $h, $x, $y, $html='', $border=0, $ln=0, $fill=0, $reseth=true, $align='', $autopadding=true)
		
			$arrParam = array("idJobHazardLog" => $idJobHazardLog);
			$data['info'] = $this->jobs_model->get_hazards_logs($arrParam);
			
			//hazards list
			$data['hazards'] = $this->jobs_model->get_job_hazards_v2($data['info'][0]['id_job']);	

			// - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
			// Print a table
				
			// add a page
			$pdf->AddPage();

			$html = $this->load->view("reporte_jha_pdf", $data, true);
										
			// output the HTML content
			$pdf->writeHTML($html, true, false, true, false, '');
		

			// Print some HTML Cells

			// reset pointer to the last page
			$pdf->lastPage();


			//Close and output PDF document
			$pdf->Output('jha_' . $idJobHazardLog . '.pdf', 'I');

			//============================================================+
			// END OF FILE
			//============================================================+
		
	}
	
    /**
     * Tool box subcontractor worker
     */
    public function tool_box_subcontractor_Worker() 
	{
			$idJob= $this->input->post('hddIdJob');
			$idToolBox= $this->input->post('hddIdToolBox');

			if ($this->jobs_model->saveSubcontractorWorker()) {
				$this->session->set_flashdata('retornoExito', 'You have Add one Worker.');
			} else {
				$this->session->set_flashdata('retornoError', '<strong>Error!!!</strong> Ask for help');
			}
			redirect(base_url('jobs/add_tool_box/' . $idJob . '/' . $idToolBox), 'refresh');
    }	
	
    /**
     * Delete tool box subcontractor
     */
    public function deleteToolBoxSubcontractorWorker($idJob, $idToolBox, $idToolBoxSubcontractor) 
	{
			if (empty($idJob) || empty($idToolBox) || empty($idToolBoxSubcontractor) ) {
				show_error('ERROR!!! - You are in the wrong place.');
			}
		
			$arrParam = array(
				"table" => "tool_box_workers_subcontractor",
				"primaryKey" => "id_tool_box_subcontractor",
				"id" => $idToolBoxSubcontractor
			);

			if ($this->jobs_model->deleteRecord($arrParam)) {
				$this->session->set_flashdata('retornoExito', 'You have delete one worker.');
			} else {
				$this->session->set_flashdata('retornoError', '<strong>Error!!!</strong> Ask for help');
			}
			redirect(base_url('jobs/add_tool_box/' . $idJob . '/' . $idToolBox), 'refresh');
    }


	
	
	
}