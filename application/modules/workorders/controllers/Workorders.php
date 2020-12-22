<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Workorders extends CI_Controller {
	
    public function __construct() {
        parent::__construct();
        $this->load->model("workorders_model");
		$this->load->library('PHPExcel.php');
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
			//If it is a BASIC ROLE OR SAFETY&MAINTENACE ROLE, just show the records of the user session
			if($userRol == 7 || $userRol == 4){ 
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
			//job list - (active items)
			$arrParam = array(
				"table" => "param_jobs",
				"order" => "job_description",
				"column" => "state",
				"id" => 1
			);
			$data['jobs'] = $this->general_model->get_basic_search($arrParam);
			
			//company list
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
				$data['workorderState'] = $this->workorders_model->get_workorder_state($id);//workorder additional information

				$arrParam = array(
					"idWorkorder" => $id
				);
				$data['information'] = $this->workorders_model->get_workordes_by_idUser($arrParam);//info workorder
			
				//DESHABILITAR WORK ORDER
				$userRol = $this->session->rol;
				$workorderState = $data['information'][0]['state'];
				//si es diferente al rol de SUPER ADMIN
				if($userRol != 99)
				{
					//si esta cerrada deshabilito los botones
					if($workorderState == 4){
						$data['deshabilitar'] = 'disabled';
					//If it is DIFERRENT THAN ON FILD and ROLE is SUPERVISOR OR BASIC OR Safety&Maintenance
					}elseif($workorderState != 0 && ($userRol == 4 || $userRol == 6 || $userRol == 7)){ 
						$data['deshabilitar'] = 'disabled';
					}elseif($workorderState == 1 && ($userRol == 2 || $userRol == 3)){ //MANAGEMENT AND ACCOUNTING USER
						$data['deshabilitar'] = 'disabled';
					}
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
			
			$idWorkorderInicial = $this->input->post('hddIdentificador');
			
			$msj = "You have add a new Work Order, continue uploading the information.";
			if ($idWorkorderInicial != '') {
				$msj = "You have update the Work Order, continue uploading the information.";
			}

			if ($idWorkorder = $this->workorders_model->add_workorder()) 
			{
				$nameForeman = $this->input->post('foreman');
				
				if($nameForeman != '')
				{
					//INICIO 
					//codigo para revisar si se actuliza o se adiciona informacion del foreman
					$this->load->model("general_model");
					$idCompany = $this->input->post('company');
					
					//reviso si hay formean para esa empresa
					$arrParam = array(
						"table" => "param_company_foreman",
						"order" => "id_company_foreman ",
						"column" => "fk_id_param_company",
						"id" => $idCompany
					);
					$infoForeman = $this->general_model->get_basic_search($arrParam);
					
					if($infoForeman){//actualizo informacion del foreman
						$idForeman = $infoForeman[0]["id_company_foreman"];
					}else{//adiciono informacion del foreman
						$idForeman = '';
					}
					
					//guardo datos de foreman
					$this->workorders_model->info_foreman($idForeman);
					//FIN
				}
				
				//guardo el primer estado de la workorder
				if(!$idWorkorderInicial){
					$arrParam = array(
						"idWorkorder" => $idWorkorder,
						"observation" => "New work order.",
						"state" => 0
					);					
					$this->workorders_model->add_workorder_state($arrParam);
				}
				
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
			$arrParam = array("state" => 1);
			$data['workersList'] = $this->general_model->get_user($arrParam);//workers list

			
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
			
			//workers list
			$arrParam = array("state" => 1);
			$data['workersList'] = $this->general_model->get_user($arrParam);//workers list


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

			if(count($porciones) > 1){
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
			//job list
			$this->load->model("general_model");
			$arrParam = array(
				"table" => "param_jobs",
				"order" => "job_description",
				"column" => "state",
				"id" => 1
			);
			$data['jobList'] = $this->general_model->get_basic_search($arrParam);//job list

			$arrParam = array("state" => 0);
			$data['noOnfield'] = $this->workorders_model->countWorkorders($arrParam);//cuenta registros de Workorders
			$arrParam = array("state" => 1);
			$data['noProgress'] = $this->workorders_model->countWorkorders($arrParam);//cuenta registros de Workorders
			$arrParam = array("state" => 2);
			$data['noRevised'] = $this->workorders_model->countWorkorders($arrParam);//cuenta registros de Workorders
			$arrParam = array("state" => 3);
			$data['noSend'] = $this->workorders_model->countWorkorders($arrParam);//cuenta registros de Workorders
			$arrParam = array("state" => 4);
			$data['noClosed'] = $this->workorders_model->countWorkorders($arrParam);//cuenta registros de Workorders
			
			$data["view"] = "asign_rate_form_search";
			
			//viene desde el boton go back
			if($goBack == 'y')
			{
				$workOrderGoBackInfo = $this->workorders_model->get_workorder_go_back();
				
				//le sumo un dia al dia final para que ingrese ese dia en la consulta
				$to = date('Y-m-d',strtotime ( '+1 day ' , strtotime ( formatear_fecha($workOrderGoBackInfo['post_to']) ) ) );
				//$from = formatear_fecha($workOrderGoBackInfo['post_from']);
				
				$arrParam = array(
					"jobId" => $workOrderGoBackInfo['post_id_job'],
					"idWorkOrder" => $workOrderGoBackInfo['post_id_work_order'],
					"idWorkOrderFrom" => $workOrderGoBackInfo['post_id_wo_from'],
					"idWorkOrderTo" => $workOrderGoBackInfo['post_id_wo_to'],
					"from" => $workOrderGoBackInfo['post_from'],//$from,
					"to" => $to,
					"state" => $workOrderGoBackInfo['post_state']
				);

				$data['workOrderInfo'] = $this->workorders_model->get_workorder_by_idJob($arrParam);

				$data["view"] = "asign_rate_list";
			}
			//Si envian los datos del filtro entonces lo direcciono a la lista respectiva con los datos de la consulta
			elseif($this->input->post('jobName') || $this->input->post('workOrderNumber') || $this->input->post('workOrderNumberFrom') || $this->input->post('from'))
			{								
				$data['jobName'] =  $this->input->post('jobName');
				$data['workOrderNumber'] =  $this->input->post('workOrderNumber');
				$data['workOrderNumberFrom'] =  $this->input->post('workOrderNumberFrom');
				$data['workOrderNumberTo'] =  $this->input->post('workOrderNumberTo');
				$data['from'] =  $this->input->post('from');
				$data['to'] =  $this->input->post('to');
			
				//le sumo un dia al dia final para que ingrese ese dia en la consulta
				if($data['to']){
					$to = date('Y-m-d',strtotime ( '+1 day ' , strtotime ( formatear_fecha($data['to']) ) ) );
				}else{
					$to = "";
				}
				if($data['from']){
					$from = formatear_fecha($data['from']);
				}else{
					$from = "";
				}
				
				$arrParam = array(
					"jobId" => $this->input->post('jobName'),
					"idWorkOrder" => $this->input->post('workOrderNumber'),
					"idWorkOrderFrom" => $this->input->post('workOrderNumberFrom'),
					"idWorkOrderTo" => $this->input->post('workOrderNumberTo'),
					"from" => $from,
					"to" => $to
				);
				
				//guardo la informacion en la base de datos para el boton de regresar
				$this->workorders_model->saveInfoGoBack($arrParam);
	
				//informacion Work Order
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
			
			//si esta cerrada deshabilito los botones
			$data['deshabilitar'] = '';
			if($data['information'][0]['state'] == 4){
				$data['deshabilitar'] = 'disabled';
			}

			$data["view"] = 'asign_rate_form_v2';
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
				$data['linkBack'] = "workorders/foreman_view/" . $idWorkOrder;

				
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
	 * Save workorder state
     * @since 11/1/2020
     * @author BMOTTAG
	 */
	public function save_workorder_state()
	{			
			header('Content-Type: application/json');
			$data = array();
			
			$data["idWorkorder"] = $this->input->post('hddIdWorkOrder');
			
			$msj = "You have add additional information to the Work Order.";
			
			$arrParam = array(
				"idWorkorder" => $this->input->post('hddIdWorkOrder'),
				"observation" => $this->input->post('information'),
				"state" => $this->input->post('state')
			);

			if ($this->workorders_model->add_workorder_state($arrParam)) 
			{
				//actualizo el estado del formulario
				$arrParam = array(
					"table" => "workorder",
					"primaryKey" => "id_workorder",
					"id" => $this->input->post('hddIdWorkOrder'),
					"column" => "state",
					"value" => $this->input->post('state')
				);
				$this->load->model("general_model");
				
				$this->general_model->updateRecord($arrParam);
				
				
				$data["result"] = true;
				$data["mensaje"] = $msj;
				$this->session->set_flashdata('retornoExito', $msj);
			} else {
				$data["result"] = "error";
				$data["mensaje"] = "Error!!! Ask for help.";
				$this->session->set_flashdata('retornoError', '<strong>Error!!!</strong> Ask for help');
			}

			echo json_encode($data);
    }
	
	/**
	 * Lista de Workorders filtrado por estado
     * @since 22/2/2020
     * @author BMOTTAG
	 */
	public function wo_by_state($state, $year="x")
	{						
			$from = date('Y-m-d', mktime(0,0,0, 1, 1, $year));//primer dia del año
			//$to = date('Y-m-d',(mktime(0,0,0,13,1,$year)-1));//ultimo dia del año
			$to = date('Y-m-d', mktime(0,0,0, 1, 1, $year+1));//primer dia del siguiente año para que incluya todo el dia anterior en la consulta
			
			$data['jobName'] =  $this->input->post('jobName');
			$data['workOrderNumber'] =  $this->input->post('workOrderNumber');
			$data['workOrderNumberFrom'] =  $this->input->post('workOrderNumberFrom');
			$data['workOrderNumberTo'] =  $this->input->post('workOrderNumberTo');
			$data['from'] =  $this->input->post('from');
			$data['to'] =  $this->input->post('to');
					
			$arrParam = array(
				"from" => $from,
				"to" => $to,
				"state" => $state
			);
			
			//guardo la informacion en la base de datos para el boton de regresar
			$this->workorders_model->saveInfoGoBack($arrParam);

			//informacion Work Order
			$data['workOrderInfo'] = $this->workorders_model->get_workorder_by_idJob($arrParam);

			$data["view"] = "asign_rate_list";
			$this->load->view("layout", $data);	
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
			//$pdf->AddPage('L', 'A4');
			$pdf->AddPage();

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
	
	/**
	 * Generate Payroll Report in XLS
	 * @param int $jobId
     * @since 10/02/2020
     * @author BMOTTAG
	 */
	public function generaWorkOrderXLS($jobId, $from = '' , $to = '')
	{				
			$arrParam = array(
				"jobId" => $jobId,
				"from" => $from,
				"to" => $to
			);

			$info = $this->workorders_model->get_workorder_by_idJob($arrParam);

			// Create new PHPExcel object	
			$objPHPExcel = new PHPExcel();

			// Set document properties
			$objPHPExcel->getProperties()->setCreator("VCI APP")
										 ->setLastModifiedBy("VCI APP")
										 ->setTitle("Report")
										 ->setSubject("Report")
										 ->setDescription("VCI Report.")
										 ->setKeywords("office 2007 openxml php")
										 ->setCategory("Report");
										 
			// Create a first sheet
			$objPHPExcel->setActiveSheetIndex(0);
			$objPHPExcel->getActiveSheet()->setCellValue('A1', 'WORK ORDER REPORT');
						
			$objPHPExcel->getActiveSheet()->setCellValue('A3', 'Work Order #')
										->setCellValue('B3', 'Supervisor')
										->setCellValue('C3', 'Date of Issue')
										->setCellValue('D3', 'Date Work Order')
										->setCellValue('E3', 'Job Code/Name')
										->setCellValue('F3', 'Task Description')
										->setCellValue('G3', 'Description')
										->setCellValue('H3', 'Employee Name')
										->setCellValue('I3', 'Employee Type')
										->setCellValue('J3', 'Material')
										->setCellValue('K3', 'Equipment')
										->setCellValue('L3', 'Hours')
										->setCellValue('M3', 'Quantity')
										->setCellValue('N3', 'Unit')
										->setCellValue('O3', 'Unit price')
										->setCellValue('P3', 'Operated by')
										->setCellValue('Q3', 'Line Total');
										
										
			$j=4;
			$total = 0; 
			foreach ($info as $data):
					
				$idWorkOrder = $data['id_workorder'];
				$workorderPersonal = $this->workorders_model->get_workorder_personal($idWorkOrder);//workorder personal list
				$workorderMaterials = $this->workorders_model->get_workorder_materials($idWorkOrder);//workorder material list
				$workorderEquipment = $this->workorders_model->get_workorder_equipment($idWorkOrder);//workorder equipment list
				$workorderOcasional = $this->workorders_model->get_workorder_ocasional($idWorkOrder);//workorder ocasional list

				$observation = $data['observation']?$data['observation']:'';
				if($workorderPersonal){
					foreach ($workorderPersonal as $infoP):
						$objPHPExcel->getActiveSheet()->setCellValue('A'.$j, $data['id_workorder'])
													  ->setCellValue('B'.$j, $data['name'])
													  ->setCellValue('C'.$j, $data['date_issue'])
													  ->setCellValue('D'.$j, $data['date'])
													  ->setCellValue('E'.$j, $data['job_description'])
													  ->setCellValue('F'.$j, $observation)
													  ->setCellValue('G'.$j, $infoP['description'])
													  ->setCellValue('H'.$j, $infoP['name'])
													  ->setCellValue('I'.$j, $infoP['employee_type'])
													  ->setCellValue('L'.$j, $infoP['hours'])
													  ->setCellValue('N'.$j, 'Hours')
													  ->setCellValue('O'.$j, $infoP['rate'])
													  ->setCellValue('Q'.$j, $infoP['value']);
						$j++;
					endforeach;
				}

				if($workorderMaterials){
					foreach ($workorderMaterials as $infoM):
						$objPHPExcel->getActiveSheet()->setCellValue('A'.$j, $data['id_workorder'])
													  ->setCellValue('B'.$j, $data['name'])
													  ->setCellValue('C'.$j, $data['date_issue'])
													  ->setCellValue('D'.$j, $data['date'])
													  ->setCellValue('E'.$j, $data['job_description'])
													  ->setCellValue('F'.$j, $observation)
													  ->setCellValue('G'.$j, $infoM['description'])
													  ->setCellValue('J'.$j, $infoM['material'])
													  ->setCellValue('M'.$j, $infoM['quantity'])
													  ->setCellValue('N'.$j, $infoM['unit'])
													  ->setCellValue('O'.$j, $infoM['rate'])
													  ->setCellValue('Q'.$j, $infoM['value']);
						$j++;
					endforeach;
				}
		
				if($workorderEquipment){
					foreach ($workorderEquipment as $infoE):
									
						//si es tipo miscellaneous -> 8, entonces la description es diferente
						if($infoE['fk_id_type_2'] == 8){
							$equipment = $infoE['miscellaneous'] . " - " . $infoE['other'];
						}else{
							$equipment = $infoE['type_2'] . " - " . $infoE['unit_number'] . " - " . $infoE['v_description'];
						}
						
						$quantity = $infoE['quantity']==0?1:$infoE['quantity'];//cantidad si es cero es porque es 1
			
						$objPHPExcel->getActiveSheet()->setCellValue('A'.$j, $data['id_workorder'])
													  ->setCellValue('B'.$j, $data['name'])
													  ->setCellValue('C'.$j, $data['date_issue'])
													  ->setCellValue('D'.$j, $data['date'])
													  ->setCellValue('E'.$j, $data['job_description'])
													  ->setCellValue('F'.$j, $observation)
													  ->setCellValue('G'.$j, $infoE['description'])
													  ->setCellValue('K'.$j, $equipment)
													  ->setCellValue('L'.$j, $infoE['hours'])
													  ->setCellValue('M'.$j, $quantity)
													  ->setCellValue('N'.$j, 'Hours')
													  ->setCellValue('O'.$j, $infoE['rate'])
													  ->setCellValue('P'.$j, $infoE['operatedby'])
													  ->setCellValue('Q'.$j, $infoE['value']);
						$j++;
					endforeach;
				}
			
				if($workorderOcasional){
					foreach ($workorderOcasional as $infoO):
						$equipment = $infoO['company_name'] . '-' . $infoO['equipment'];
						$hours = $infoO['hours']==0?1:$infoO['hours'];
						
						$objPHPExcel->getActiveSheet()->setCellValue('A'.$j, $data['id_workorder'])
													  ->setCellValue('B'.$j, $data['name'])
													  ->setCellValue('C'.$j, $data['date_issue'])
													  ->setCellValue('D'.$j, $data['date'])
													  ->setCellValue('E'.$j, $data['job_description'])
													  ->setCellValue('F'.$j, $observation)
													  ->setCellValue('G'.$j, $infoO['description'])
													  ->setCellValue('K'.$j, $equipment)
													  ->setCellValue('L'.$j, $hours)
													  ->setCellValue('M'.$j, $infoO['quantity'])
													  ->setCellValue('N'.$j, $infoO['unit'])
													  ->setCellValue('O'.$j, $infoO['rate'])
													  ->setCellValue('Q'.$j, $infoO['value']);
						$j++;
					endforeach;
				}
				
			endforeach;

			// Set column widths							  
			$objPHPExcel->getActiveSheet()->getColumnDimension('A')->setWidth(15);
			$objPHPExcel->getActiveSheet()->getColumnDimension('B')->setWidth(22);
			$objPHPExcel->getActiveSheet()->getColumnDimension('C')->setWidth(22);
			$objPHPExcel->getActiveSheet()->getColumnDimension('D')->setWidth(20);
			$objPHPExcel->getActiveSheet()->getColumnDimension('E')->setWidth(50);
			$objPHPExcel->getActiveSheet()->getColumnDimension('F')->setWidth(60);
			$objPHPExcel->getActiveSheet()->getColumnDimension('G')->setWidth(60);
			$objPHPExcel->getActiveSheet()->getColumnDimension('H')->setWidth(20);
			$objPHPExcel->getActiveSheet()->getColumnDimension('I')->setWidth(20);
			$objPHPExcel->getActiveSheet()->getColumnDimension('J')->setWidth(15);
			$objPHPExcel->getActiveSheet()->getColumnDimension('K')->setWidth(50);
			$objPHPExcel->getActiveSheet()->getColumnDimension('L')->setWidth(15);
			$objPHPExcel->getActiveSheet()->getColumnDimension('M')->setWidth(15);
			$objPHPExcel->getActiveSheet()->getColumnDimension('N')->setWidth(15);
			$objPHPExcel->getActiveSheet()->getColumnDimension('O')->setWidth(15);
			$objPHPExcel->getActiveSheet()->getColumnDimension('P')->setWidth(15);
			$objPHPExcel->getActiveSheet()->getColumnDimension('Q')->setWidth(15);

			// Add conditional formatting
			$objConditional1 = new PHPExcel_Style_Conditional();
			$objConditional1->setConditionType(PHPExcel_Style_Conditional::CONDITION_CELLIS)
							->setOperatorType(PHPExcel_Style_Conditional::OPERATOR_BETWEEN)
							->addCondition('200')
							->addCondition('400');
			$objConditional1->getStyle()->getFont()->getColor()->setARGB(PHPExcel_Style_Color::COLOR_YELLOW);
			$objConditional1->getStyle()->getFont()->setBold(true);
			$objConditional1->getStyle()->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_CURRENCY_EUR_SIMPLE);

			$objConditional2 = new PHPExcel_Style_Conditional();
			$objConditional2->setConditionType(PHPExcel_Style_Conditional::CONDITION_CELLIS)
							->setOperatorType(PHPExcel_Style_Conditional::OPERATOR_LESSTHAN)
							->addCondition('0');
			$objConditional2->getStyle()->getFont()->getColor()->setARGB(PHPExcel_Style_Color::COLOR_RED);
			$objConditional2->getStyle()->getFont()->setItalic(true);
			$objConditional2->getStyle()->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_CURRENCY_EUR_SIMPLE);

			$objConditional3 = new PHPExcel_Style_Conditional();
			$objConditional3->setConditionType(PHPExcel_Style_Conditional::CONDITION_CELLIS)
							->setOperatorType(PHPExcel_Style_Conditional::OPERATOR_GREATERTHANOREQUAL)
							->addCondition('0');
			$objConditional3->getStyle()->getFont()->getColor()->setARGB(PHPExcel_Style_Color::COLOR_GREEN);
			$objConditional3->getStyle()->getFont()->setItalic(true);
			$objConditional3->getStyle()->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_CURRENCY_EUR_SIMPLE);

			$conditionalStyles = $objPHPExcel->getActiveSheet()->getStyle('B2')->getConditionalStyles();
			array_push($conditionalStyles, $objConditional1);
			array_push($conditionalStyles, $objConditional2);
			array_push($conditionalStyles, $objConditional3);
			$objPHPExcel->getActiveSheet()->getStyle('B2')->setConditionalStyles($conditionalStyles);

			//	duplicate the conditional styles across a range of cells
			$objPHPExcel->getActiveSheet()->duplicateConditionalStyle(
							$objPHPExcel->getActiveSheet()->getStyle('B2')->getConditionalStyles(),
							'B3:B7'
						  );

			// Set fonts			  
			$objPHPExcel->getActiveSheet()->getStyle('A1')->getFont()->setBold(true);
			$objPHPExcel->getActiveSheet()->getStyle('A2')->getFont()->setBold(true);
			$objPHPExcel->getActiveSheet()->getStyle('A3:Q3')->getFont()->setBold(true);

			// Set header and footer. When no different headers for odd/even are used, odd header is assumed.
			$objPHPExcel->getActiveSheet()->getHeaderFooter()->setOddHeader('&L&BPersonal cash register&RPrinted on &D');
			$objPHPExcel->getActiveSheet()->getHeaderFooter()->setOddFooter('&L&B' . $objPHPExcel->getProperties()->getTitle() . '&RPage &P of &N');

			// Set page orientation and size
			$objPHPExcel->getActiveSheet()->getPageSetup()->setOrientation(PHPExcel_Worksheet_PageSetup::ORIENTATION_PORTRAIT);
			$objPHPExcel->getActiveSheet()->getPageSetup()->setPaperSize(PHPExcel_Worksheet_PageSetup::PAPERSIZE_A4);

			// Rename worksheet
			$objPHPExcel->getActiveSheet()->setTitle('Work Order');

			// Set active sheet index to the first sheet, so Excel opens this as the first sheet
			$objPHPExcel->setActiveSheetIndex(0);

			// redireccionamos la salida al navegador del cliente (Excel2007)
			header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
			header('Content-Disposition: attachment;filename="workorder_' . $jobId . '.xlsx"');
			header('Cache-Control: max-age=0');

			$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
			$objWriter->save('php://output');
			  
    }
	
	/**
	 * Search by JOB CODE
     * @since 16/03/2020
     * @author BMOTTAG
	 */
    public function search_income()
	{
			//job list
			$this->load->model("general_model");
			$arrParam = array(
				"table" => "param_jobs",
				"order" => "job_description",
				"column" => "state",
				"id" => 1
			);
			$data['jobList'] = $this->general_model->get_basic_search($arrParam);//job list

			$arrParam = array("state" => 0);
			$data['noOnfield'] = $this->workorders_model->countWorkorders($arrParam);//cuenta registros de Workorders
			$arrParam = array("state" => 1);
			$data['noProgress'] = $this->workorders_model->countWorkorders($arrParam);//cuenta registros de Workorders
			$arrParam = array("state" => 2);
			$data['noRevised'] = $this->workorders_model->countWorkorders($arrParam);//cuenta registros de Workorders
			$arrParam = array("state" => 3);
			$data['noSend'] = $this->workorders_model->countWorkorders($arrParam);//cuenta registros de Workorders
			$arrParam = array("state" => 4);
			$data['noClosed'] = $this->workorders_model->countWorkorders($arrParam);//cuenta registros de Workorders
			
			//Si envian los datos del filtro entonces lo direcciono a la lista respectiva con los datos de la consulta
			if($this->input->post('jobName') && $this->input->post('from') && $this->input->post('to'))
			{								
				$data['idJob'] =  $this->input->post('jobName');
				$data['from'] =  $this->input->post('from');
				$data['to'] =  $this->input->post('to');
			
				//le sumo un dia al dia final para que ingrese ese dia en la consulta
				if($data['to']){
					$to = date('Y-m-d',strtotime ( '+1 day ' , strtotime ( formatear_fecha($data['to']) ) ) );
				}else{
					$to = "";
				}
				if($data['from']){
					$from = formatear_fecha($data['from']);
				}else{
					$from = "";
				}
				
				$data['fromFormat'] =  $from;
				$data['toFormat'] =  $to;
				
				//informacion Work Order
				$arrParam = array(
					"idJob" => $data['idJob'],
					"from" => $from,
					"to" => $to
				);
				$data['noWO'] = $this->workorders_model->countWorkorders($arrParam);//cuenta registros de Workorders

				$data['hoursPersonal'] = $this->workorders_model->countHoursPersonal($arrParam);//cuenta horas de personal

				$arrParam['table'] = "workorder_personal";
				$data['incomePersonal'] = $this->workorders_model->countIncome($arrParam);//cuenta horas de personal

				$arrParam['table'] = "workorder_materials";
				$data['incomeMaterial'] = $this->workorders_model->countIncome($arrParam);//cuenta horas de personal

				$arrParam['table'] = "workorder_equipment";
				$data['incomeEquipment'] = $this->workorders_model->countIncome($arrParam);//cuenta horas de personal

				$arrParam['table'] = "workorder_ocasional";
				$data['incomeSubcontractor'] = $this->workorders_model->countIncome($arrParam);//cuenta horas de personal

				$data['total'] = $data['incomePersonal'] + $data['incomeMaterial'] + $data['incomeEquipment'] + $data['incomeSubcontractor'];
				
				//job list
				$arrParam = array(
					"table" => "param_jobs",
					"order" => "job_description",
					"column" => "id_job",
					"id" => $data['idJob']
				);
				$data['jobListSearch'] = $this->general_model->get_basic_search($arrParam);//job list
	
			}
			$data["view"] = "form_search_income";
			
			$this->load->view("layout", $data);
    }
	
	/**
	 * Foreman workorder view to sign
     * @since 4/6/2020
     * @author BMOTTAG
	 */
	public function foreman_view($id)
	{
			$this->load->model("general_model");
						
			$data['workorderPersonal'] = $this->workorders_model->get_workorder_personal($id);//workorder personal list
			$data['workorderMaterials'] = $this->workorders_model->get_workorder_materials($id);//workorder material list
			$data['workorderEquipment'] = $this->workorders_model->get_workorder_equipment($id);//workorder equipment list
			$data['workorderOcasional'] = $this->workorders_model->get_workorder_ocasional($id);//workorder ocasional list
			$data['workorderHoldBack'] = $this->workorders_model->get_workorder_hold_back($id);//workorder ocasional list
			
			$arrParam['idWorkOrder'] =  $id;
			$data['information'] = $this->workorders_model->get_workorder_by_idJob($arrParam);//info workorder
			
			$data["view"] = 'foreman_view';
			$this->load->view("layout", $data);
	}	
	
	/**
	 * Foreman info
     * @since 25/2/2020
     * @author BMOTTAG
	 */
    public function foremanInfo()
	{			
			header('Content-Type: application/json');
			$data = array();
			
			$idCompany = $this->input->post('idCompany');
					
			//busco info tabla de param_company_foreman
			$this->load->model("general_model");

			//reviso si hay formean para esa empresa
			$arrParam = array(
				"table" => "param_company_foreman",
				"order" => "id_company_foreman ",
				"column" => "fk_id_param_company",
				"id" => $idCompany
			);
			$infoForeman = $this->general_model->get_basic_search($arrParam);

			$data["result"] = true;
			$data["foreman_name"] = "";
			$data["foreman_movil"] = "";
			$data["foreman_email"] = "";
			if($infoForeman){
				$data["foreman_name"] = $infoForeman[0]["foreman_name"];
				$data["foreman_movil"] = $infoForeman[0]["foreman_movil_number"];
				$data["foreman_email"] = $infoForeman[0]["foreman_email"];
			}
			
			echo json_encode($data);
    }
	
	/**
	 * Envio de mensaje
     * @since 4/6/2020
     * @author BMOTTAG
	 */
	public function sendSMSForeman($idWorkOrder)
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
						
		$arrParam['idWorkOrder'] =  $idWorkOrder;
		$data['information'] = $this->workorders_model->get_workorder_by_idJob($arrParam);//info workorder
		
		$mensaje = "";
		
		$mensaje .= date('F j, Y', strtotime($data['information'][0]['date']));
		$mensaje .= "\n" . $data['information'][0]['job_description'];
		$mensaje .= "\n" . $data['information'][0]['observation'];
		$mensaje .= "\n";
		$mensaje .= "Click the following link to review W.O. " . $idWorkOrder;
		$mensaje .= "\n";
		$mensaje .= "\n";
		$mensaje .= base_url("workorders/foreman_view/" . $idWorkOrder);

		$to = '+1' . $data['information'][0]['foreman_movil_number_wo'];
	
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

		$data['linkBack'] = "workorders/add_workorder/" . $idWorkOrder;
		$data['titulo'] = "<i class='fa fa-list'></i>WORK ORDER";
		
		$data['clase'] = "alert-info";
		$data['msj'] = "We have send the SMS to the foreman to sign the Work Order No." . $idWorkOrder;

		$data["view"] = 'template/answer';
		$this->load->view("layout", $data);


	}
	
	/**
	 * Load prices WO
     * @since 7/11/2020
     * @author BMOTTAG
	 */
	public function load_prices_wo()
	{			
			header('Content-Type: application/json');
			$data = array();

			$data["idWO"] = $idWO = $this->input->post('identificador');
			
			$arrParam['idWorkOrder'] =  $idWO;
			$data['information'] = $this->workorders_model->get_workorder_by_idJob($arrParam);//info workorder
			$idJob = $data['information'][0]['fk_id_job'];
				
			$workorderPersonalRate = $this->workorders_model->get_workorder_personal_prices($idWO, $idJob);//workorder personal list
			$workorderEquipmentRate = $this->workorders_model->get_workorder_equipment_prices($idWO, $idJob);//workorder equipment list
			$workorderMaterialRate = $this->workorders_model->get_workorder_material_prices($idWO);//workorder material list

			if($workorderPersonalRate)
			{
				if ($this->workorders_model->update_wo_personal_rate($workorderPersonalRate)) 
				{				
					$data["result"] = true;
					$this->session->set_flashdata('retornoExito', 'You have load the data.');
				} else {
					$data["result"] = "error";
					$data["mensaje"] = "Error!!! Contactarse con el Administrador.";
					$this->session->set_flashdata('retornoError', '<strong>Error!!!</strong> Ask for help');
				}
			}else{
				$data["result"] = true;
			}
			
			if($workorderEquipmentRate)
			{
				if ($this->workorders_model->update_wo_equipment_rate($workorderEquipmentRate)) 
				{				
					$data["result"] = true;
					$this->session->set_flashdata('retornoExito', 'You have load the data.');
				} else {
					$data["result"] = "error";
					$data["mensaje"] = "Error!!! Contactarse con el Administrador.";
					$this->session->set_flashdata('retornoError', '<strong>Error!!!</strong> Ask for help');
				}
			}else{
				$data["result"] = true;
			}

			if($workorderMaterialRate)
			{
				if ($this->workorders_model->update_wo_material_rate($workorderMaterialRate)) 
				{				
					$data["result"] = true;
					$this->session->set_flashdata('retornoExito', 'You have load the data.');
				} else {
					$data["result"] = "error";
					$data["mensaje"] = "Error!!! Contactarse con el Administrador.";
					$this->session->set_flashdata('retornoError', '<strong>Error!!!</strong> Ask for help');
				}
			}else{
				$data["result"] = true;
			}

			echo json_encode($data);
    }
	
	
	
}