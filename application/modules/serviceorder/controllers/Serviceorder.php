<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Serviceorder extends CI_Controller {
	
    public function __construct() {
        parent::__construct();
        $this->load->model("serviceorder_model");
    }
	
	/**
	 * Service Order Control Panel
     * @since 19/5/2023
     * @author BMOTTAG
	 */
	public function index($idServiceOrder = 'x')
	{		
			$data['infoSpecificSO'] = false;
			$data['infoEquipment'] = false;
			$data['infoSO'] = false;
			$data['information'] = false;
			if ($idServiceOrder != 'x') {
				//Service Order info. When comes form the twilio message
				$idServiceOrder = base64_decode($idServiceOrder);
				$arrParam = array("idServiceOrder" => $idServiceOrder);				
				$data['infoSpecificSO'] = $this->serviceorder_model->get_service_order($arrParam);
			}else{
				$this->load->model("general_model");
				$data['infoEquipment'] = $this->general_model->countEquipmentByType();
				$data['infoSO'] = $this->general_model->countSOByStatus();
				$arrParam = array(
					"limit" => 10
				);
				$data['information'] = $this->serviceorder_model->get_service_order($arrParam);
			}

			$data["view"] ='dashboard_so';
			$this->load->view("layout", $data);
	}

    /**
     * Cargo modal - service order
     * @since 18/5/2023
     */
    public function cargarModalServiceOrder() 
	{
			header("Content-Type: text/plain; charset=utf-8"); //Para evitar problemas de acentos
			
			$data['information'] = FALSE;
			$data["idServiceOrder"] = $this->input->post("idServiceOrder");

			//worker list
			$arrParam = array("state" => 1);
			$this->load->model("general_model");
			$data['workersList'] = $this->general_model->get_user($arrParam);//worker list

			$arrParam = array(
				"table" => "param_status",
				"order" => "status_order",
				"column" => "status_key",
				"id" => "priority"
			);
			$data['priorityList'] = $this->general_model->get_basic_search($arrParam);

			if ($data["idServiceOrder"] != 'x') {
				//status list
				$arrParam = array(
					"table" => "param_status",
					"order" => "status_order",
					"column" => "status_key",
					"id" => "serviceorder"
				);
				$data['statusList'] = $this->general_model->get_basic_search($arrParam);

				//Service Order info
				$arrParam = array(
					"idServiceOrder" => $data["idServiceOrder"]
				);				
				$data['information'] = $this->serviceorder_model->get_service_order($arrParam);

				$data['maintenanceType'] = $data['information'][0]["maintenace_type"];
				$idMaintenance = $data['information'][0]["fk_id_maintenace"];
			}else{
				$data['maintenanceType']  = $this->input->post("maintenanceType");
				$idMaintenance = $this->input->post("idMaintenance");
			}

			$arrParam = array("idMaintenance" => $idMaintenance);	
			if ($data['maintenanceType'] == "corrective") {			
				$infoMaintenance = $this->serviceorder_model->get_corrective_maintenance($arrParam);
				$data['maintenanceDescription'] = $infoMaintenance[0]["description_failure"]; 
				$data['maintenanceTypeDescription'] = "Corrective Maintenance";
				$data['nextMaintenance'] = "";
			}else{
				$infoMaintenance = $this->serviceorder_model->get_preventive_maintenance($arrParam);
				if($infoMaintenance){
					$data['maintenanceDescription'] = $infoMaintenance[0]["maintenance_description"]; 
					$data['maintenanceTypeDescription'] = "Preventive Maintenance";
					$data['nextMaintenance'] = $infoMaintenance[0]["verification_by"]==1?"<br><b>Next Hours/Kilometers Maintenance: </b>" . number_format($infoMaintenance[0]["next_hours_maintenance"]) :"<br><b>Next Date Maintenance: </b>" . $infoMaintenance[0]["next_date_maintenance"];
				}else{
					$data['maintenanceDescription'] = "";
					$data['maintenanceTypeDescription'] = "";
					$data['nextMaintenance'] = "";
				}
			}
			
			$this->load->view("service_order_modal", $data);
    }

    /**
     * Cargo modal - Preventive Maintenace
     * @since 23/5/2023
     */
    public function cargarModalPreventiveMaintenance() 
	{
			header("Content-Type: text/plain; charset=utf-8"); //Para evitar problemas de acentos
			
			$data['information'] = FALSE;
			$data["idMaintenance"] = $this->input->post("idMaintenance");
			//busco tipos de mantenimiento
			$arrParam = array(
				"table" => "maintenance_type",
				"order" => "maintenance_type",
				"id" => "x"
			);
			$this->load->model("general_model");
			$data['infoTypeMaintenance'] = $this->general_model->get_basic_search($arrParam);
			
			if ($data["idMaintenance"] != 'x') {
				$arrParam = array(
					"idMaintenance" => $data["idMaintenance"]
				);				
				$data['information'] = $this->serviceorder_model->get_preventive_maintenance($arrParam);
			}
			
			$this->load->view("preventive_maintenance_modal", $data);
    }

	/**
	 * Save Service Order
     * @since 18/5/2023
     * @author BMOTTAG
	 */
	public function save_service_order()
	{			
			header('Content-Type: application/json');
			$data = array();
			
			$idServiceOrder = $this->input->post('hddIdServiceOrder');
			$data["idEquipment"] = $this->input->post('hddIdEquipment');
			$maintenace_type = $this->input->post('hddMaintenanceType');
			$status = $this->input->post('status');
			$this->load->model("general_model");
			
			$msj = "You have added a new Service Order!!";
			if ($idServiceOrder != '') {
				$msj = "You have updated the Service Order!!";
			}

			if ($data["idServiceOrder"] = $this->serviceorder_model->saveServiceOrder()) 
			{
				if ($idServiceOrder == '' && $maintenace_type == "corrective") {
					//change corrective maintenance status to in_progress
					$arrParam = array(
						"table" => "corrective_maintenance",
						"primaryKey" => "id_corrective_maintenance",
						"id" => $this->input->post('hddIdMaintenance'),
						"column" => "maintenance_status",
						"value" => "in_progress"
					);
					$this->general_model->updateRecord($arrParam);
				}elseif ($idServiceOrder != '' && $maintenace_type == "corrective" && $status == "closed_so" ) {
					//change corrective maintenance status to closed
					$arrParam = array(
						"table" => "corrective_maintenance",
						"primaryKey" => "id_corrective_maintenance",
						"id" => $this->input->post('hddIdMaintenance'),
						"column" => "maintenance_status",
						"value" => "closed"
					);
					$this->general_model->updateRecord($arrParam);
				}

				if ($idServiceOrder == ''){
					//chat first message
					$arrParam = array(
						"fk_id_module" => $data["idServiceOrder"],
						"module" => ID_MODULE_SERVICE_ORDER,
						"message" => "New Service Order"
					);	
					$this->general_model->saveChat($arrParam);
					//send Twilio message
					//busco datos del vehiculo
					$arrParam = array("idVehicle" => $data["idEquipment"]);
					$vehicleInfo = $this->general_model->get_vehicle_by($arrParam);

					$arrParamUser = array("idUser" => $this->input->post('assign_to'));				
					$userInfo = $this->general_model->get_user($arrParamUser);

					$mensajeSMS = "APP VCI - New Service Order #" . $data["idServiceOrder"];
					$mensajeSMS .= "\nUnit #: " . $vehicleInfo[0]["unit_number"];
					$mensajeSMS .= "\nVIN #: " . $vehicleInfo[0]["vin_number"];
					$mensajeSMS .= "\nMaintenance: " . $this->input->post('hddMaintenanceDescription');

					$module = base64_encode("ID_MODULE_SERVICE_ORDER"); 
					$idModule = base64_encode($data["idServiceOrder"]); 
					$urlMovil = base_url("login/index/x/" . $module . "/" . $idModule);
					$mensajeSMS .= "\n\nSee: ".$urlMovil;

					$arrParam = array(
						"msjPhone" => $mensajeSMS,
						"userMovil" => $userInfo[0]['movil'] 
					);
					send_twilio_message($arrParam);
				}else{
					$hddIdCanBeUsed = $this->input->post('hddIdCanBeUsed');
					$can_be_used = $this->input->post('can_be_used');

					$arrParam = array(
						"table" => "param_vehicle",
						"primaryKey" => "id_vehicle",
						"id" => $data["idEquipment"],
						"column" => "so_blocked"
					);
					if($can_be_used == 2 && $status == "closed_so"){
						//update param_vehicle, field so_blocked
						$arrParam["value"] = 1;
						$this->general_model->updateRecord($arrParam);
					}elseif($can_be_used != $hddIdCanBeUsed){
						//update param_vehicle, field so_blocked
						$arrParam["value"] = $can_be_used;
						$this->general_model->updateRecord($arrParam);
					}

					//update preventive maintenance
					$verification = $this->input->post('hddVerificationBy');
					if ($maintenace_type == "preventive" && $status == "closed_so" && $verification == 1) {
						$arrParam = array(
							"table" => "preventive_maintenance",
							"primaryKey" => "id_preventive_maintenance",
							"id" => $this->input->post('hddIdMaintenance')
						);
						if($verification == 1){
							$arrParam["column"] = "next_hours_maintenance";
							$arrParam["value"] = $this->input->post('next_hours_maintenance');
							$this->general_model->updateRecord($arrParam);
						}else{
							$arrParam["column"] = "next_date_maintenance";
							$arrParam["value"] = $this->input->post('next_date_maintenance');
							$this->general_model->updateRecord($arrParam);
						}
					}
					//If we close the service orden then we update the current equipment hours
					if ($status == "closed_so") {
						$this->serviceorder_model->saveEquipmentCurrentHours();

						//busco datos del vehiculo
						$arrParam = array("idVehicle" => $data["idEquipment"]);
						$vehicleInfo = $this->general_model->get_vehicle_by($arrParam);

						//BEGIN send Twilio message
						$comments = $this->input->post('comments');
						$arrParamUser = array("idUser" => $this->input->post('hddIdAssignedBy'));				
						$userInfo = $this->general_model->get_user($arrParamUser);

						$mensajeSMS = "APP VCI - Service Order #" . $data["idServiceOrder"] . " closed.";
						$mensajeSMS .= "\nUnit #: " . $vehicleInfo[0]["unit_number"];
						$mensajeSMS .= "\nVIN #: " . $vehicleInfo[0]["vin_number"];
						$mensajeSMS .= "\nMaintenance: " . $this->input->post('hddMaintenanceDescription');
						$mensajeSMS .= "\nComments: " . $comments;

						$module = base64_encode("ID_MODULE_SERVICE_ORDER"); 
						$idModule = base64_encode($data["idServiceOrder"]); 
						$urlMovil = base_url("login/index/x/" . $module . "/" . $idModule);
						$mensajeSMS .= "\n\nSee: ".$urlMovil;

						$arrParamTwilio = array(
							"msjPhone" => $mensajeSMS,
							"userMovil" => $userInfo[0]['movil'] 
						);
						send_twilio_message($arrParamTwilio);
						//END send Twilio message
					}
				}

				$data["result"] = true;
				$this->session->set_flashdata('retornoExito', $msj);
			} else {
				$data["result"] = "error";			
				$this->session->set_flashdata('retornoError', '<strong>Error!!!</strong> Ask for help');
			}

			echo json_encode($data);	
    }

	/**
	 * Equipment List
     * @since 20/5/2022
     * @author BMOTTAG
	 */
    public function equipmentList() 
	{
        header("Content-Type: text/plain; charset=utf-8"); //Para evitar problemas de acentos

		//busco info de vehiculo
		$this->load->model("general_model");
		$data['subTitle'] = $this->input->post('headerInspectionType'); 
		$arrParam = array(
			"vehicleType" => $this->input->post('inspectionType'),
			"vinNumber" => $this->input->post('vinNumber'),
			"vehicleState" => 1
		);
		$data["vehicleInfo"] = $this->general_model->get_vehicle_by($arrParam);//busco datos del vehiculo
		
		if($data["vehicleInfo"] )
		{
			echo $this->load->view("equipment_list", $data);
		}else{				
			echo "<p class='text-danger'>There are no records.</p>";
		}
	}

	/**
	 * SO List
     * @since 14/6/2022
     * @author BMOTTAG
	 */
    public function serviceOrderList() 
	{
        header("Content-Type: text/plain; charset=utf-8"); //Para evitar problemas de acentos

		//busco info de vehiculo
		$this->load->model("general_model");
		$status = $this->input->post('status');
		if($status != 'x'){
			$arrParam = array("status" => $this->input->post('status'));
		}else{
			$arrParam = array("idServiceOrder" => $this->input->post('soNumber'));
		}
		$data['information'] = $this->serviceorder_model->get_service_order($arrParam);
		echo $this->load->view("service_order_list", $data);
	}

	/**
	 * Equipment Detail
     * @since 21/5/2022
     * @author BMOTTAG
	 */
    public function equipmentDetail() 
	{
        header("Content-Type: text/plain; charset=utf-8"); //Para evitar problemas de acentos

		//busco info de vehiculo
		$this->load->model("general_model");
		$arrParam = array(
			"idVehicle" => $this->input->post('equipmentId')
		);
		$data["vehicleInfo"] = $this->general_model->get_vehicle_by($arrParam);//busco datos del vehiculo

		$data["tabview"] = $this->input->post('tabview');

		if($data["tabview"] == "tab_service_order"){
			$data['information'] = $this->serviceorder_model->get_service_order($arrParam);
		}elseif($data["tabview"] == "tab_corrective_maintenance"){
			$data['infoCorrectiveMaintenance'] = $this->serviceorder_model->get_corrective_maintenance($arrParam);
		}elseif($data["tabview"] == "tab_preventive_maintenance"){
			$data['infoPreventiveMaintenance'] = $this->serviceorder_model->get_preventive_maintenance($arrParam);
		}elseif($data["tabview"] == "tab_inspections"){
			$data['infoInspections'] = $this->general_model->get_vehicle_oil_change($data['vehicleInfo']);//vehicle oil change history
		}elseif($data["tabview"] == "tab_service_order_detail"){
			$arrParam["idServiceOrder"] = $this->input->post('serviceOrderId');
			$data['information'] = $this->serviceorder_model->get_service_order($arrParam);
			$arrParam = array(
				"idModule" => $this->input->post('serviceOrderId'),
				"module" => ID_MODULE_SERVICE_ORDER
			);
			$data['chatInfo'] = $this->general_model->get_chat_info($arrParam);

			$arrParam = array("idServiceOrder" => $this->input->post('serviceOrderId'));
			$data['infoParts'] = $this->serviceorder_model->get_parts($arrParam);
		}

		if($data["vehicleInfo"] )
		{
			echo $this->load->view("equipment_detail", $data);
		}else{				
			echo "<p class='text-danger'>There are no records.</p>";
		}
	}

	/**
	 * Save Preventive Maintenance
     * @since 22/5/2023
     * @author BMOTTAG
	 */
	public function save_preventive_maintenance()
	{			
			header('Content-Type: application/json');
			$data = array();

			$idMaintenance = $this->input->post('hddIdMaintenance');
			$data["idEquipment"] = $this->input->post('hddIdEquipment');
			
			$msj = "You have added a new Preventive Maintenance!!";
			if ($idMaintenance != '') {
				$msj = "You have updated the Preventive Maintenance!!";
			}

			if ($idMaintenance = $this->serviceorder_model->savePreventiveMaintenance()) {
				$data["result"] = true;
				$this->session->set_flashdata('retornoExito', $msj);
			} else {
				$data["result"] = "error";			
				$this->session->set_flashdata('retornoError', '<strong>Error!!!</strong> Ask for help');
			}
			echo json_encode($data);	
    }

    /**
     * Cargo modal - Corrective Maintenace
     * @since 26/5/2023
     */
    public function cargarModalCorrectiveMaintenance() 
	{
			header("Content-Type: text/plain; charset=utf-8"); //Para evitar problemas de acentos
			
			$data['information'] = FALSE;
			$data["idMaintenance"] = $this->input->post("idMaintenance");
			
			if ($data["idMaintenance"] != 'x') {
				$arrParam = array(
					"idMaintenance" => $data["idMaintenance"]
				);				
				$data['information'] = $this->serviceorder_model->get_corrective_maintenance($arrParam);
			}
			
			$this->load->view("corrective_maintenance_modal", $data);
    }

	/**
	 * Save Corrective Maintenance
     * @since 26/5/2023
     * @author BMOTTAG
	 */
	public function save_corrective_maintenance()
	{			
			header('Content-Type: application/json');
			$data = array();

			$idMaintenance = $this->input->post('hddIdMaintenance');
			$data["idEquipment"] = $this->input->post('hddIdEquipment');
			
			$msj = "You have added a new Corrective Maintenance!!";
			if ($idMaintenance != '') {
				$msj = "You have updated the Corrective Maintenance!!";
			}

			if ($idMaintenance = $this->serviceorder_model->saveCorrectiveMaintenance()) {
				$data["result"] = true;
				$this->session->set_flashdata('retornoExito', $msj);
			} else {
				$data["result"] = "error";			
				$this->session->set_flashdata('retornoError', '<strong>Error!!!</strong> Ask for help');
			}
			echo json_encode($data);	
    }

	/**
	 * Save chat
     * @since 29/5/2023
     * @author BMOTTAG
	 */
	public function save_chat()
	{	
			header('Content-Type: application/json');
			$data["idEquipment"] = $this->input->post('hddIdEquipment');
			$idServiceOrder= $this->input->post('hddId');
			$idAssignedTo = $this->input->post('hddIdAssignedTo');
			$idAssignedBy = $this->input->post('hddIdAssignedBy');
			$data["view"] = $this->input->post('hddView');
			$data["idModule"] = $this->input->post('hddId');

			$arrParam = array(
				"fk_id_module" => $idServiceOrder,
				"module" => ID_MODULE_SERVICE_ORDER,
				"message" => addslashes($this->security->xss_clean($this->input->post('message')))
			);
			$this->load->model("general_model");		
			if ($this->general_model->saveChat($arrParam)) {
				//BEGIN send Twilio message
				$idUser = $this->session->userdata("id");

				$arrParam = array("idVehicle" => $data["idEquipment"]);
				$vehicleInfo = $this->general_model->get_vehicle_by($arrParam);//busco datos del vehiculo
				
				$idUserTo = $idUser == $idAssignedTo ? $idAssignedBy : $idAssignedTo;
				$arrParamUser = array("idUser" => $idUserTo);				
				$userInfo = $this->general_model->get_user($arrParamUser);

				$mensajeSMS = "APP VCI - Service Order #" . $idServiceOrder;
				$mensajeSMS .= "\nUnit #: " . $vehicleInfo[0]["unit_number"];
				$mensajeSMS .= "\nVIN #: " . $vehicleInfo[0]["vin_number"];
				$mensajeSMS .= "\nMaintenance: " . $this->input->post('hddMaintenanceDescription');
				$mensajeSMS .= "\nMessage: " . addslashes($this->security->xss_clean($this->input->post('message')));

				$module = base64_encode("ID_MODULE_SERVICE_ORDER"); 
				$idModule = base64_encode($idServiceOrder); 
				$urlMovil = base_url("login/index/x/" . $module . "/" . $idModule);
				$mensajeSMS .= "\n\nSee: ".$urlMovil;

				$arrParamTwilio = array(
					"msjPhone" => $mensajeSMS,
					"userMovil" => $userInfo[0]['movil'] 
				);
				send_twilio_message($arrParamTwilio);
				//END send Twilio message
				$data["result"] = true;
				$this->session->set_flashdata('retornoExito', "You have added a message");
			} else {
				$data["result"] = "error";
				$this->session->set_flashdata('retornoError', '<strong>Error!!!</strong> Ask for help');
			}
			echo json_encode($data);

	}

    /**
     * Cargo modal - service order Parts
     * @since 30/5/2023
     */
    public function cargarModalParts() 
	{
			header("Content-Type: text/plain; charset=utf-8"); //Para evitar problemas de acentos
			
			$data['information'] = FALSE;
			$data["idPart"] = $this->input->post("idPart");

			if ($data["idPart"] != 'x') {
				$arrParam = array("idPart" => $data["idPart"]);				
				$data['information'] = $this->serviceorder_model->get_parts($arrParam);
			}
			
			$this->load->view("parts_modal", $data);
    }

	/**
	 * Save Parts
     * @since 30/5/2023
     * @author BMOTTAG
	 */
	public function save_parts()
	{			
			header('Content-Type: application/json');
			$data = array();
			
			$idParts = $this->input->post('hddIdPart');
			$data["idServiceOrder"] = $this->input->post('hddIdServiceOrder');
			$data["idEquipment"] = $this->input->post('hddIdEquipment');
			
			$msj = "You have added a new Part!!";
			if ($idParts != '') {
				$msj = "You have updated the information!!";
			}

			if ($this->serviceorder_model->saveParts()) {
				$data["result"] = true;
				$this->session->set_flashdata('retornoExito', $msj);
			} else {
				$data["result"] = "error";			
				$this->session->set_flashdata('retornoError', '<strong>Error!!!</strong> Ask for help');
			}

			echo json_encode($data);	
    }


}