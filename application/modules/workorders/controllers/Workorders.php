<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Workorders extends CI_Controller {
	
    public function __construct() {
        parent::__construct();
        $this->load->model("workorders_model");
    }
	
	/**
	 * Form Workorders
     * @since 12/1/2017
     * @author BMOTTAG
	 */
	public function index()
	{
			$this->load->model("general_model");
		
			$arrParam = array();
			$userRol = $this->session->userdata("rol");
			if(!$userRol){ //If it is a normal user, just show the records of the user session
				$arrParam["idEmployee"] = $this->session->userdata("id");
			}
			$data['workOrderInfo'] = $this->workorders_model->get_workordes_by_idUser($arrParam);

			$data["view"] ='workorder';
			$this->load->view("layout", $data);
	}

	/**
	 * Form Add workorder
     * @since 12/1/2017
     * @author BMOTTAG
	 */
	public function add_workorder($id = 'x')
	{
			$data['information'] = FALSE;
			$data['workorderPersonal'] = FALSE;
			$data['workorderMaterials'] = FALSE;
			$data['deshabilitar'] = '';
			
			$this->load->model("general_model");
			//job´s list - (active´s items)
			$arrParam = array(
				"table" => "param_jobs",
				"order" => "job_description",
				"column" => "state",
				"id" => 1
			);
			$data['jobs'] = $this->general_model->get_basic_search($arrParam);
			
			//company list
			$this->load->model("general_model");
			$arrParam = array(
				"table" => "param_company",
				"order" => "company_name",
				"column" => "company_type",
				"id" => 2
			);
			$data['companyList'] = $this->general_model->get_basic_search($arrParam);//company list
			
			//si envio el id, entonces busco la informacion 
			if ($id != 'x') 
			{
				$data['workorderPersonal'] = $this->workorders_model->get_workorder_personal($id);//workorder personal list
				$data['workorderMaterials'] = $this->workorders_model->get_workorder_materials($id);//workorder material list
				$data['workorderEquipment'] = $this->workorders_model->get_workorder_equipment($id);//workorder equipment list
				$data['workorderOcasional'] = $this->workorders_model->get_workorder_ocasional($id);//workorder ocasional list

				$arrParam = array(
					"idWorkorder" => $id
				);
				$data['information'] = $this->workorders_model->get_workordes_by_idUser($arrParam);//info workorder
			
				//si esta cerrada deshabilito los botones
				if($data['information'][0]['state'] == 2){
					$data['deshabilitar'] = 'disabled';
				}
				
				if (!$data['information']) { 
					show_error('ERROR!!! - You are in the wrong place.');	
				}
			}			

			$data["view"] = 'form_workorder';
			$this->load->view("layout", $data);
	}
	
	/**
	 * Save workorder
     * @since 13/1/2017
     * @author BMOTTAG
	 */
	public function save_workorder()
	{			
			header('Content-Type: application/json');
			$data = array();
			
			$idWorkorder = $this->input->post('hddIdentificador');
			
			$msj = "You have add a new Work Order, continue uploading the information.";
			if ($idWorkorder != '') {
				$msj = "You have update the Work Order, continue uploading the information.";
			}

			if ($idWorkorder = $this->workorders_model->add_workorder()) {
				$data["result"] = true;
				$data["mensaje"] = $msj;
				$data["idWorkorder"] = $idWorkorder;
				$this->session->set_flashdata('retornoExito', $msj);
			} else {
				$data["result"] = "error";
				$data["mensaje"] = "Error!!! Ask for help.";
				$data["idWorkorder"] = "";
				$this->session->set_flashdata('retornoError', '<strong>Error!!!</strong> Ask for help');
			}

			echo json_encode($data);
    }
	
	/**
	 * Update workorder
     * @since 25/1/2017
     * @author BMOTTAG
	 */
	public function update_workorder()
	{			
			header('Content-Type: application/json');
			$data = array();
			
			$data["idWorkorder"] = $this->input->post('hddIdentificador');

			$arrParam = array(
				"table" => "workorder",
				"primaryKey" => "id_workorder",
				"id" => $data["idWorkorder"],
				"column" => "state",
				"value" => 2
			);
			$this->load->model("general_model");
			
			//actualizo el estado del formulario a cerrado(2)
			if ($this->general_model->updateRecord($arrParam)) {
				$data["result"] = true;
				$data["mensaje"] = "You have close the Work Order.";
				$this->session->set_flashdata('retornoExito', 'You have close the Work Order');
			} else {
				$data["result"] = "error";
				$data["mensaje"] = "Error!!! Ask for help.";
				$this->session->set_flashdata('retornoError', '<strong>Error!!!</strong> Ask for help');
			}

			echo json_encode($data);
    }
	
    /**
     * Cargo modal- formulario de captura personal
     * @since 13/1/2017
     */
    public function cargarModalPersonal() 
	{
			header("Content-Type: text/plain; charset=utf-8"); //Para evitar problemas de acentos

			$data["idWorkorder"] = $this->input->post("idWorkorder");
		
			//workers list
			$this->load->model("general_model");
			$data['workersList'] = $this->general_model->get_user_list();//workers list
			
			//employee type list
			$arrParam = array(
				"table" => "param_employee_type",
				"order" => "employee_type",
				"id" => "x"
			);
			$data['employeeTypeList'] = $this->general_model->get_basic_search($arrParam);//employee type list

			$this->load->view("modal_personal", $data);
    }
	
	/**
	 * Save formularios
	 * @param varchar $modalToUse: indica que funcion del modelo se debe usar
     * @since 13/1/2017
     * @author BMOTTAG
	 */
	public function save($modalToUse)
	{			
			header('Content-Type: application/json');
			$data = array();
			
			$data["idRecord"] = $this->input->post('hddidWorkorder');

			if ($this->workorders_model->$modalToUse()) {
				$data["result"] = true;
				$this->session->set_flashdata('retornoExito', "You have add a new record!!");
			} else {
				$data["result"] = "error";
				$this->session->set_flashdata('retornoError', '<strong>Error!!!</strong> Ask for help');
			}
			
			//si es SUPER ADMIN entonces lo redirecciono al formulario para asignar rate
			$userRol = $this->session->rol;
			$data["controlador"] = "add_workorder";
			if($userRol==99){
				$data["controlador"] = "view_workorder";
			}

			echo json_encode($data);
    }
	
    /**
     * Delete workorder record
	 * @param varchar $tabla: nombre de la tabla de la cual se va a borrar
	 * @param int $idValue: id que se va a borrar
	 * @param int $idWorkorder: llave  primaria de workorder
     */
    public function deleteRecord($tabla, $idValue, $idWorkorder, $vista) 
	{
			if (empty($tabla) || empty($idValue) || empty($idWorkorder) ) {
				show_error('ERROR!!! - You are in the wrong place.');
			}
		
			$arrParam = array(
				"table" => "workorder_" . $tabla,
				"primaryKey" => "id_workorder_"  . $tabla,
				"id" => $idValue
			);
			$this->load->model("general_model");
			if ($this->general_model->deleteRecord($arrParam)) {
				$this->session->set_flashdata('retornoExito', 'You have delete one record from <strong>'.$tabla.'</strong> table.');
			} else {
				$this->session->set_flashdata('retornoError', '<strong>Error!!!</strong> Ask for help');
			}
			redirect(base_url('workorders/' . $vista . '/' . $idWorkorder), 'refresh');
    }
	
    /**
     * Cargo modal- formulario de captura Material
     * @since 13/1/2017
     */
    public function cargarModalMaterials() 
	{
			header("Content-Type: text/plain; charset=utf-8"); //Para evitar problemas de acentos

			$idWorkorder = $this->input->post("idWorkorder");
			//como se coloca un ID diferente para que no entre en conflicto con los otros modales, toca sacar el ID
			$porciones = explode("-", $idWorkorder);
			$data["idWorkorder"] = $porciones[1];
		
			//workers list
			$this->load->model("general_model");
			$arrParam = array(
				"table" => "param_material_type",
				"order" => "material",
				"id" => "x"
			);
			$data['materialList'] = $this->general_model->get_basic_search($arrParam);//worker´s list

			$this->load->view("modal_material", $data);
    }
	
    /**
     * Cargo modal- formulario de captura Equipment
     * @since 25/1/2017
     */
    public function cargarModalEquipment() 
	{
			header("Content-Type: text/plain; charset=utf-8"); //Para evitar problemas de acentos

			$idWorkorder = $this->input->post("idWorkorder");
			//como se coloca un ID diferente para que no entre en conflicto con los otros modales, toca sacar el ID
			$porciones = explode("-", $idWorkorder);
			$data["idWorkorder"] = $porciones[1];
		
			$this->load->model("general_model");	
			//buscar la lista de tipo de equipmentType
			$arrParam = array(
				"table" => "param_vehicle_type_2",
				"order" => "type_2",
				"column" => "show_workorder",
				"id" => 1
			);
			$data['equipmentType'] = $this->general_model->get_basic_search($arrParam);//equipmentType list

			$this->load->view("modal_equipment", $data);
    }	
	
	/**
	 * Trucks list by company and type
     * @since 25/1/2017
     * @author BMOTTAG
	 */
    public function truckList() {
        header("Content-Type: text/plain; charset=utf-8"); //Para evitar problemas de acentos
        $company = 1; //la empresa es VCI que el id es 1
		$type = $this->input->post('type');
		
		//si es igual a 8 es miscellaneous entonces la informacion la debe sacar de la tabla param_miscellaneous
		if($type == 8)
		{
			//miscellaneous list
			$this->load->model("general_model");
			$arrParam = array(
				"table" => "param_miscellaneous",
				"order" => "miscellaneous",
				"id" => "x"
			);
			$lista = $this->general_model->get_basic_search($arrParam);//miscellaneous list

			echo "<option value=''>Select...</option>";
			if ($lista) {
				foreach ($lista as $fila) {
					echo "<option value='" . $fila["id_miscellaneous"] . "' >" . $fila["miscellaneous"] . "</option>";
				}
			}			
		}elseif($type == 9){
			$lista = $this->workorders_model->get_trucks_by_id1();

			echo "<option value=''>Select...</option>";
			if ($lista) {
				foreach ($lista as $fila) {
					echo "<option value='" . $fila["id_truck"] . "' >" . $fila["unit_number"] . "</option>";
				}
			}
		}else{
			$lista = $this->workorders_model->get_trucks_by_id2($company, $type);

			echo "<option value=''>Select...</option>";
			if ($lista) {
				foreach ($lista as $fila) {
					echo "<option value='" . $fila["id_truck"] . "' >" . $fila["unit_number"] . "</option>";
				}
			}
		}
    }
	
	/**
	 * Company list
     * @since 4/2/2017
     * @author BMOTTAG
	 */
    public function companyList() {
        header("Content-Type: text/plain; charset=utf-8"); //Para evitar problemas de acentos
        $CompanyType = $this->input->post('CompanyType');
		
		//company list
		$this->load->model("general_model");
		$arrParam = array(
			"table" => "param_company",
			"order" => "company_name",
			"column" => "company_type",
			"id" => $CompanyType 
		);
		$lista = $this->general_model->get_basic_search($arrParam);//company list

        echo "<option value=''>Select...</option>";
        if ($lista) {
            foreach ($lista as $fila) {
                echo "<option value='" . $fila["id_company"] . "' >" . $fila["company_name"] . "</option>";
            }
        }
    }
	
    /**
     * Cargo modal- formulario de captura Ocasional
     * @since 20/2/2017
     */
    public function cargarModalOcasional() 
	{
			header("Content-Type: text/plain; charset=utf-8"); //Para evitar problemas de acentos

			$idWorkorder = $this->input->post("idWorkorder");
			//como se coloca un ID diferente para que no entre en conflicto con los otros modales, toca sacar el ID
			$porciones = explode("-", $idWorkorder);
			$data["idWorkorder"] = $porciones[1];
		
			//workers list
			$this->load->model("general_model");
			$arrParam = array(
				"table" => "param_company",
				"order" => "company_name",
				"column" => "company_type",
				"id" => 2
			);
			$data['companyList'] = $this->general_model->get_basic_search($arrParam);//company list

			$this->load->view("modal_ocasional", $data);
    }
	
    /**
     * Cargo modal- formulario de captura HOLD BACK
     * @since 12/11/2018
     */
    public function cargarModalHoldBack() 
	{
			header("Content-Type: text/plain; charset=utf-8"); //Para evitar problemas de acentos

			$idWorkorder = $this->input->post("idWorkorder");
			//como se coloca un ID diferente para que no entre en conflicto con los otros modales, toca sacar el ID
			$porciones = explode("-", $idWorkorder);
			$data["idWorkorder"] = $porciones[1];
		
			$this->load->view("modal_hold_back", $data);
    }
	
	/**
	 * Search by JOB CODE
     * @since 21/02/2017
     * @author BMOTTAG
	 */
    public function search($goBack = 'x') 
	{
			$userRol = $this->session->rol;
			//solo es para usuarios SUPER ADMIN
			if ($userRol!=99 && $userRol!=2) {
				show_error('ERROR!!! - You are in the wrong place.');
			}

			//job list
			$this->load->model("general_model");
			$arrParam = array(
				"table" => "param_jobs",
				"order" => "job_description",
				"column" => "state",
				"id" => 1
			);
			$data['jobList'] = $this->general_model->get_basic_search($arrParam);//job list
			
			$data["view"] = "asign_rate_form_search";
			
			//viene desde el boton go back
			if($goBack == 'y')
			{
				$workOrderGoBackInfo = $this->workorders_model->get_workorder_go_back();
				
				//le sumo un dia al dia final para que ingrese ese dia en la consulta
				$to = date('Y-m-d',strtotime ( '+1 day ' , strtotime ( formatear_fecha($workOrderGoBackInfo['post_to']) ) ) );
				$from = formatear_fecha($workOrderGoBackInfo['post_from']);
				
				$arrParam = array(
					"jobId" => $workOrderGoBackInfo['post_id_job'],
					"idWorkOrder" => $workOrderGoBackInfo['post_id_work_order'],
					"from" => $from,
					"to" => $to
				);

				$data['workOrderInfo'] = $this->workorders_model->get_workorder_by_idJob($arrParam);
	
				$data["view"] = "asign_rate_list";
			}
			//Si envian los datos del filtro entonces lo direcciono a la lista respectiva con los datos de la consulta
			elseif($this->input->post('jobName') || $this->input->post('workOrderNumber') || $this->input->post('from'))
			{								
				$data['jobName'] =  $this->input->post('jobName');
				$data['workOrderNumber'] =  $this->input->post('workOrderNumber');
				$data['from'] =  $this->input->post('from');
				$data['to'] =  $this->input->post('to');
			
				//guardo la informacion en la base de datos para el boton de regresar
				$this->workorders_model->saveInfoGoBack();
				
				//le sumo un dia al dia final para que ingrese ese dia en la consulta
				$to = date('Y-m-d',strtotime ( '+1 day ' , strtotime ( formatear_fecha($data['to']) ) ) );
				$from = formatear_fecha($data['from']);
				
				$arrParam = array(
					"jobId" => $this->input->post('jobName'),
					"idWorkOrder" => $this->input->post('workOrderNumber'),
					"from" => $from,
					"to" => $to
				);

				$data['workOrderInfo'] = $this->workorders_model->get_workorder_by_idJob($arrParam);
	
				$data["view"] = "asign_rate_list";
			}
			
			$this->load->view("layout", $data);
    }
	
	/**
	 * View info WOrk order to asign rate
     * @since 21/2/2017
     * @author BMOTTAG
	 */
	public function view_workorder($id)
	{
			$this->load->model("general_model");
			
			$data['workorderPersonal'] = $this->workorders_model->get_workorder_personal($id);//workorder personal list
			$data['workorderMaterials'] = $this->workorders_model->get_workorder_materials($id);//workorder material list
			$data['workorderEquipment'] = $this->workorders_model->get_workorder_equipment($id);//workorder equipment list
			$data['workorderOcasional'] = $this->workorders_model->get_workorder_ocasional($id);//workorder ocasional list
			$data['workorderHoldBack'] = $this->workorders_model->get_workorder_hold_back($id);//workorder ocasional list
			
			$arrParam['idWorkOrder'] =  $id;
			$data['information'] = $this->workorders_model->get_workorder_by_idJob($arrParam);//info workorder

			$data["view"] = 'asign_rate_form';
			$this->load->view("layout", $data);
	}	
	
	/**
	 * Save rate
     * @since 27/2/2017
     * @author BMOTTAG
	 */
	public function save_rate()
	{					
			$idWorkorder = $this->input->post('hddIdWorkOrder');

			if ($this->workorders_model->saveRate()) {
				$data["result"] = true;
				$this->session->set_flashdata('retornoExito', "You have save the Rate!!");
			} else {
				$data["result"] = "error";
				$this->session->set_flashdata('retornoError', '<strong>Error!!!</strong> Ask for help');
			}

			redirect(base_url('workorders/view_workorder/' . $idWorkorder), 'refresh');
    }
	
	/**
	 * Save hour
	 * para editar las horas que se han guardado
     * @since 17/4/2017
     * @author BMOTTAG
	 */
	public function save_hour()
	{					
			$idWorkorder = $this->input->post('hddIdWorkOrder');

			if ($this->workorders_model->saveRate()) {
				$data["result"] = true;
				$this->session->set_flashdata('retornoExito', "You have save the Rate!!");
			} else {
				$data["result"] = "error";
				$this->session->set_flashdata('retornoError', '<strong>Error!!!</strong> Ask for help');
			}

			redirect(base_url('workorders/add_workorder/' . $idWorkorder), 'refresh');
    }
	
	/**
	 * Evio de correo a la empresa
     * @since 2/7/2017
     * @author BMOTTAG
	 */
	public function email($id)
	{	
			$arrParam['idWorkOrder'] =  $id;
			$infoWorkorder = $this->workorders_model->get_workorder_by_idJob($arrParam);//info workorder
			
			$infoWorkorderEquipment = $this->workorders_model->get_workorder_equipment($id);//workorder equipment list
			
			foreach ($infoWorkorderEquipment as $lista) {
				$nota = "";
				if($lista["fk_id_company"] != "" && $lista["fk_id_company"] != 0) {
					
					$subjet = "Workorder Information";
					$user = $lista["contact"];
					$to = $lista["email"];
				
					//mensaje del correo
					$msj = "<p>The following is the workorder information:</p>";
					$msj .= "<strong>Company: </strong> V-CONTRACTING";
					$msj .= "<br><strong>Job Code/Name: </strong>" . $infoWorkorder[0]["job_description"];
					$msj .= "<br><strong>Date: </strong>" . $infoWorkorder[0]["date"];
					$msj .= "<br><strong>Done by: </strong>" . $infoWorkorder[0]["name"];
					$msj .= "<br><strong>Observation: </strong>" . $infoWorkorder[0]["observation"];
							
					if($lista['fk_id_type_2'] == 8){
						$equipment = $lista['miscellaneous'];
					}else{
						$equipment = $lista['unit_number'] . " - " . $lista['v_description'];
					}
					
					$msj .= "<br><strong>Equipment: </strong>" . $equipment;
					$msj .= "<br><strong>Hours: </strong>" . $lista['hours'];
					
					if($lista['foreman_name']){
						$msj .= "<br><strong>Foreman name: </strong>" . $lista['foreman_name'];
					}
					
					
					if($lista['signature']){
						$msj .= "<p><img src='http://v-contracting.ca/app/" . $lista['signature'] . "' width='304' height='236' /></p>";
					}

					$mensaje = "<html>
					<head>
					  <title> $subjet </title>
					</head>
					<body>
						<p>Dear	$user:</p>
						<p>$msj</p>
						<p>Cordially,</p>
						<p><strong>V-CONTRACTING INC</strong></p>
					</body>
					</html>";		
				
					$cabeceras  = 'MIME-Version: 1.0' . "\r\n";
					$cabeceras .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
					$cabeceras .= 'To: ' . $user . '<' . $to . '>' . "\r\n";
					$cabeceras .= 'From: VCI APP <info@v-contracting.ca>' . "\r\n";

					//enviar correo al cliente
					mail($to, $subjet, $mensaje, $cabeceras);

					//enviar correo a VCI
					mail('info@v-contracting.ca', $subjet, $mensaje, $cabeceras);
					
					if($lista['foreman_name'] && $lista['foreman_email']){
						
						$cabeceras  = 'MIME-Version: 1.0' . "\r\n";
						$cabeceras .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
						$cabeceras .= 'To: ' . $lista['foreman_name'] . '<' . $lista['foreman_email'] . '>' . "\r\n";
						$cabeceras .= 'From: VCI APP <info@v-contracting.ca>' . "\r\n";
						
						//enviar correo al FOREMAN
						mail($lista['foreman_email'], $subjet, $mensaje, $cabeceras);
					}
					
					$nota = 'You have send an email to <strong>' . $lista["company_name"] . '</strong> with the information.';
					
				}

			}
			
			$this->session->set_flashdata('retornoExito', $nota);
			redirect("/workorders/add_workorder/" . $id,'refresh');
	}	
	
	
	/**
	 * Signature
     * @since 24/11/2017
     * @author BMOTTAG
	 */
	public function add_signature($idWorkOrder)
	{
			if (empty($idWorkOrder)) {
				show_error('ERROR!!! - You are in the wrong place.');
			}
		
			if($_POST){
				
				//update signature with the name of de file
				$name = "images/signature/workorder/workorder_" . $idWorkOrder . ".png";
				
				$arrParam = array(
					"table" => "workorder",
					"primaryKey" => "id_workorder",
					"id" => $idWorkOrder,
					"column" => "signature_wo",
					"value" => $name
				);
				//enlace para regresar al formulario
				$data['linkBack'] = "workorders/add_workorder/" . $idWorkOrder;

				
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
	 * Save workorder and send email
     * @since 29/3/2018
     * @author BMOTTAG
	 */
	public function save_workorder_and_send_email()
	{			
			header('Content-Type: application/json');
			$data = array();

			if ($idWorkorder = $this->workorders_model->add_workorder()) {
				$data["result"] = true;
				$data["mensaje"] = "You have update the Work Order and send an email to the contractor, continue uploading the information.";
				$data["idWorkorder"] = $idWorkorder;
				$this->email_v2($idWorkorder);
				$this->session->set_flashdata('retornoExito', 'You have update the Work Order and send an email to the contractor, continue uploading the information.');
			} else {
				$data["result"] = "error";
				$data["mensaje"] = "Error!!! Ask for help.";
				$data["idWorkorder"] = "";
				$this->session->set_flashdata('retornoError', '<strong>Error!!!</strong> Ask for help');
			}

			echo json_encode($data);
    }	
	
	/**
	 * Evio de correo a la empresa
     * @since 2/7/2017
     * @author BMOTTAG
	 */
	public function email_v2($id)
	{	
			$arrParam['idWorkOrder'] =  $id;
			$infoWorkorder = $this->workorders_model->get_workorder_by_idJob($arrParam);//info workorder
			
			$subjet = "Workorder Information";
			$user = $infoWorkorder[0]["contact"];
			$to = $infoWorkorder[0]["email"];
		
			//mensaje del correo
			$msj = "<p>The following is the workorder information:</p>";
			$msj .= "<strong>Workorder number: </strong>" . $id;
			$msj .= "<br><strong>Company: </strong> V-CONTRACTING";
			$msj .= "<br><strong>Job Code/Name: </strong>" . $infoWorkorder[0]["job_description"];
			$msj .= "<br><strong>Date: </strong>" . $infoWorkorder[0]["date"];
			$msj .= "<br><strong>Done by: </strong>" . $infoWorkorder[0]["name"];
			
			if($infoWorkorder[0]["foreman_name_wo"]){
				$msj .= "<br><strong>Foreman name: </strong>" . $infoWorkorder[0]["foreman_name_wo"];
			}

			if($infoWorkorder[0]["observation"]){
				$msj .= "<br><strong>Observation: </strong>" . $infoWorkorder[0]["observation"];
			}
			
			$infoWorkorderEquipment = $this->workorders_model->get_workorder_equipment($id);//workorder equipment list
			
			if($infoWorkorderEquipment){
			
				foreach ($infoWorkorderEquipment as $lista) {

						if($lista['fk_id_type_2'] == 8){
							$equipment = $lista['miscellaneous'];
						}else{
							$equipment = $lista['unit_number'] . " - " . $lista['v_description'];
						}
						$msj .= "<p>";
						$msj .= "<strong>Equipment: </strong>" . $equipment;
						$msj .= "<br><strong>Hours: </strong>" . $lista['hours'];
						$msj .= "<br><strong>Description: </strong>" . $lista['description'];
						$msj .= "<br>*************************************</p>";
				}
			
			}
			
			if($infoWorkorder[0]['signature_wo']){
				$msj .= "<p><img src='http://v-contracting.ca/app/" . $infoWorkorder[0]['signature_wo'] . "' width='304' height='236' />";
				$msj .= "<br><strong>Foreman signature</strong></p>";
			}

			$mensaje = "<html>
			<head>
			  <title> $subjet </title>
			</head>
			<body>
				<p>Dear	$user:</p>
				<p>$msj</p>
				<p>Cordially,</p>
				<p><strong>V-CONTRACTING INC</strong></p>
			</body>
			</html>";		

			$cabeceras  = 'MIME-Version: 1.0' . "\r\n";
			$cabeceras .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
			$cabeceras .= 'To: ' . $user . '<' . $to . '>' . "\r\n";
			$cabeceras .= 'From: VCI APP <hugo@v-contracting.com>' . "\r\n";

			//enviar correo al cliente
			mail($to, $subjet, $mensaje, $cabeceras);

			//enviar correo a VCI
			mail('info@v-contracting.ca', $subjet, $mensaje, $cabeceras);
			
			if($lista['foreman_name'] && $lista['foreman_email']){
				
				$cabeceras  = 'MIME-Version: 1.0' . "\r\n";
				$cabeceras .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
				$cabeceras .= 'To: ' . $lista['foreman_name'] . '<' . $lista['foreman_email'] . '>' . "\r\n";
				$cabeceras .= 'From: VCI APP <info@v-contracting.ca>' . "\r\n";
				
				//enviar correo al FOREMAN
				mail($lista['foreman_email'], $subjet, $mensaje, $cabeceras);
			}
			
			return TRUE;
	}	
	
	/**
	 * Generate WORK ORDER Report in PDF
	 * @param int $idWorkOrder
     * @since 4/11/2018
     * @author BMOTTAG
	 */
	public function generaWorkOrderPDF($idWorkOrder)
	{
			$this->load->library('Pdf');
			
			// create new PDF document
			$pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
			
			$arrParam = array("idWorkOrder" => $idWorkOrder);
			$data['info'] = $this->workorders_model->get_workorder_by_idJob($arrParam);
			
			$fecha = date('F j, Y', strtotime($data['info'][0]['date']));

			// set document information
			$pdf->SetCreator(PDF_CREATOR);
			$pdf->SetAuthor('VCI');
			$pdf->SetTitle('WORK ORDER');
			$pdf->SetSubject('TCPDF Tutorial');

			// set default header data
			$pdf->SetHeaderData(PDF_HEADER_LOGO, PDF_HEADER_LOGO_WIDTH, 'WORK ORDER', 'W.O. #: ' . $idWorkOrder . "\nW.O. date: " . $fecha, array(0,64,255), array(0,64,128));			

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
			
			$data['workorderPersonal'] = $this->workorders_model->get_workorder_personal($idWorkOrder);//workorder personal list
			$data['workorderMaterials'] = $this->workorders_model->get_workorder_materials($idWorkOrder);//workorder material list
			$data['workorderEquipment'] = $this->workorders_model->get_workorder_equipment($idWorkOrder);//workorder equipment list
			$data['workorderOcasional'] = $this->workorders_model->get_workorder_ocasional($idWorkOrder);//workorder ocasional list
			$data['workorderHoldBack'] = $this->workorders_model->get_workorder_hold_back($idWorkOrder);//workorder ocasional list

			// - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
			// Print a table
				
			// add a page
			$pdf->AddPage('L', 'A4');

			$html = $this->load->view("reporte_work_order", $data, true);
			
			// output the HTML content
			$pdf->writeHTML($html, true, false, true, false, '');
			
			// Print some HTML Cells

			// reset pointer to the last page
			$pdf->lastPage();


			//Close and output PDF document
			$pdf->Output('work_order_' . $idWorkOrder . '.pdf', 'I');

			//============================================================+
			// END OF FILE
			//============================================================+
		
	}	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
}