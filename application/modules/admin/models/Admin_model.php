<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

	class Admin_model extends CI_Model {

	    
		/**
		 * Verify if the user already exist by the social insurance number
		 * @author BMOTTAG
		 * @since  8/11/2016
		 * @review 27/11/2016
		 */
		public function verifyUser($arrData) 
		{
				$this->db->where($arrData["column"], $arrData["value"]);
				$query = $this->db->get("user");

				if ($query->num_rows() >= 1) {
					return true;
				} else{ return false; }
		}
		
		/**
		 * Add/Edit USER
		 * @since 8/11/2016
		 */
		public function saveEmployee() 
		{
				$idUser = $this->input->post('hddId');
				
				$data = array(
					'first_name' => $this->input->post('firstName'),
					'last_name' => $this->input->post('lastName'),
					'log_user' => $this->input->post('user'),
					'social_insurance' => $this->input->post('insuranceNumber'),
					'health_number' => $this->input->post('healthNumber'),
					'birthdate' => $this->input->post('birth'),
					'rh' => $this->input->post('tipoSangre'),
					'movil' => $this->input->post('movilNumber'),
					'email' => $this->input->post('email'),
					'address' => $this->input->post('address'),
					'perfil' => $this->input->post('perfil')
				);	

				//revisar si es para adicionar o editar
				if ($idUser == '') {
					$data['state'] = 0;//si es para adicionar se coloca estado inicial como usuario nuevo
					$data['password'] = 'e10adc3949ba59abbe56e057f20f883e';//123456
					$query = $this->db->insert('user', $data);
				} else {
					$data['state'] = $this->input->post('state');
					$this->db->where('id_user', $idUser);
					$query = $this->db->update('user', $data);
				}
				if ($query) {
					return true;
				} else {
					return false;
				}
		}
		
		/**
		 * Add/Edit JOB
		 * @since 10/11/2016
		 */
		public function saveJob() 
		{				
				$idJob = $this->input->post('hddId');
				
				$data = array(
					'job_description' => $this->input->post('jobName'),
					'state' => $this->input->post('stateJob')
				);			

				//revisar si es para adicionar o editar
				if ($idJob == '') {
					$query = $this->db->insert('param_jobs', $data);
				} else {
					$this->db->where('id_job', $idJob);
					$query = $this->db->update('param_jobs', $data);
				}
				if ($query) {
					return true;
				} else {
					return false;
				}
		}

		/**
		 * Add/Edit HAZARD
		 * @since 11/12/2016
		 */
		public function saveHazard() 
		{
				$idHazard = $this->input->post('hddId');
				
				$data = array(
					'fk_id_hazard_activity' => $this->input->post('activity'),
					'hazard_description' => $this->input->post('hazardName'),
					'solution' => $this->input->post('solution'),
					'fk_id_priority' => $this->input->post('priority')
				);
				
				//revisar si es para adicionar o editar
				if ($idHazard == '') {
					$query = $this->db->insert('param_hazard', $data);
					$idHazard = $this->db->insert_id();				
				} else {
					$this->db->where('id_hazard', $idHazard);
					$query = $this->db->update('param_hazard', $data);
				}
				if ($query) {
					return $idHazard;
				} else {
					return false;
				}
		}

		/**
		 * Add/Edit COMPANY
		 * @since 13/12/2016
		 */
		public function saveCompany() 
		{
				$idCompany = $this->input->post('hddId');
				
				$data = array(
					'company_name' => $this->input->post('company'),
					'contact' => $this->input->post('contact'),
					'movil_number' => $this->input->post('movilNumber'),
					'email' => $this->input->post('email')
				);
				
				//revisar si es para adicionar o editar
				if ($idCompany == '') {
					$query = $this->db->insert('param_company', $data);
					$idCompany = $this->db->insert_id();				
				} else {
					$this->db->where('id_company', $idCompany);
					$query = $this->db->update('param_company', $data);
				}
				if ($query) {
					return $idCompany;
				} else {
					return false;
				}
		}
		
		/**
		 * Add/Edit MATERIAL
		 * @since 13/12/2016
		 */
		public function saveMaterial() 
		{
				$idMaterial = $this->input->post('hddId');
				
				$data = array(
					'material' => $this->input->post('material')
				);
				
				//revisar si es para adicionar o editar
				if ($idMaterial == '') {
					$query = $this->db->insert('param_material_type', $data);
					$idMaterial = $this->db->insert_id();				
				} else {
					$this->db->where('id_material', $idMaterial);
					$query = $this->db->update('param_material_type', $data);
				}
				if ($query) {
					return $idMaterial;
				} else {
					return false;
				}
		}

		/**
		 * Add/Edit vehicle
		 * @since 15/12/2016
		 * @review 27/12/2016
		 */
		public function saveVehicle($pass) 
		{
				$idVehicle = $this->input->post('hddId');
				
				$data = array(
					'fk_id_company' => $this->input->post('company'),
					'type_level_1' => $this->input->post('type1'),
					'type_level_2' => $this->input->post('type2'),
					'make' => $this->input->post('make'),
					'model' => $this->input->post('model'),
					'manufacturer_date' => $this->input->post('manufacturer'),
					'description' => $this->input->post('description'),
					'unit_number' => $this->input->post('unitNumber'),
					'state' => $this->input->post('state'),
					'hours' => $this->input->post('hours')
				);	

				//revisar si es para adicionar o editar
				if ($idVehicle == '') {							
					$query = $this->db->insert('param_vehicle', $data);
					$idVehicle = $this->db->insert_id();
					
					//actualizo la url del codigo QR
					$path = $idVehicle . $pass;
					$rutaQRcode = "images/vehicle/" . $idVehicle . "_qr_code.png";
			
					//actualizo campo con el path encriptado
					$sql = "UPDATE param_vehicle SET encryption = '$path',qr_code = '$rutaQRcode'  WHERE id_vehicle = $idVehicle";
					$query = $this->db->query($sql);
				} else {
					$this->db->where('id_vehicle', $idVehicle);
					$query = $this->db->update('param_vehicle', $data);
				}
				if ($query) {
					return $idVehicle;
				} else {
					return false;
				}
		}

		/**
		 * Get vehicle list
		 * Param int $companyType -> 1: VCI; 2: Subcontractor
		 * @since 15/12/2016
		 * @review 26/2/2017
		 */
		public function get_vehicle_list($companyType) 
		{		
				$this->db->select();
				$this->db->join('param_company C', 'C.id_company = A.fk_id_company', 'INNER');
				$this->db->join('param_vehicle_type_2 T', 'T.id_type_2 = A.type_level_2', 'INNER');
				$this->db->where('C.company_type', $companyType);

				$this->db->order_by('C.id_company, A.unit_number', 'asc');
				$query = $this->db->get('param_vehicle A');

				if ($query->num_rows() > 0) {
					return $query->result_array();
				} else {
					return false;
				}
		}
		
		/**
		 * Get vehicle list
		 * Param int $companyType -> 1: VCI; 2: Subcontractor
		 * Param int $vehicleType -> 1: Pickup; 2: Construction Equipment; 3: Trucks; 4: Special Equipment; 99: Otros
		 * @since 5/5/2017
		 */
		public function get_vehicle_info_by($arrData) 
		{		
				$this->db->select();
				$this->db->join('param_company C', 'C.id_company = A.fk_id_company', 'INNER');
				$this->db->join('param_vehicle_type_2 T', 'T.id_type_2 = A.type_level_2', 'INNER');
				
				if (array_key_exists("companyType", $arrData)) {
					$this->db->where('C.company_type', $arrData["companyType"]);

					//si es de VCI entonces filtrar por tipo de inspeccion de lo contrario no se hace el filtro
					if($arrData["companyType"]==1){
						if (array_key_exists("vehicleType", $arrData)) {
							$this->db->where('T.inspection_type', $arrData["vehicleType"]);
						}
					}
				}
				
				if (array_key_exists("idVehicle", $arrData)) {
					$this->db->where('A.id_vehicle', $arrData["idVehicle"]);
				}
				if (array_key_exists("vehicleState", $arrData)) {
					$this->db->where('A.state', $arrData["vehicleState"]);
				}

				$this->db->order_by('T.inspection_type, C.id_company, A.unit_number', 'asc');
				$query = $this->db->get('param_vehicle A');

				if ($query->num_rows() > 0) {
					return $query->result_array();
				} else {
					return false;
				}
		}

	    /**
	     * Reset user´s password
	     * @author BMOTTAG
	     * @since  11/1/2017
	     */
	    public function resetEmployeePassword($idUser)
		{
				$passwd = '123456';
				$passwd = md5($passwd);
				
				$data = array(
					'password' => $passwd,
					'state' => 0
				);

				$this->db->where('id_user', $idUser);
				$query = $this->db->update('user', $data);

				if ($query) {
					return true;
				} else {
					return false;
				}
	    }

		/**
		 * Get vehicle oil change history
		 * last 30 records
		 * @since 17/1/2017
		 */
		public function get_vehicle_oil_change($infoVehicle) 
		{		
				$table = $infoVehicle[0]['table_inspection'] . ' T';
				$idTable = 'T.' . $infoVehicle[0]['id_table_inspection'];
		
				$this->db->select("A.*, T.comments, CONCAT(first_name, ' ', last_name) name");
				$this->db->join('user U', 'U.id_user = A.fk_id_user', 'INNER');
				$this->db->join("$table", "$idTable = A.fk_id_inspection", "LEFT");
				$this->db->where('A.fk_id_vehicle', $infoVehicle[0]['id_vehicle']);
				$this->db->order_by('id_oil_change', 'desc');
				$query = $this->db->get('vehicle_oil_change A');

				if ($query->num_rows() > 0) {
					return $query->result_array();
				} else {
					return false;
				}
		}
		
		/**
		 * Add vehicle next oil change
		 * @since 17/1/2017
		 */
		public function saveVehicleNextOilChange($idVehicle, $state) 
		{
				$idUser = $this->session->userdata("id");
				
				$data = array(
					'fk_id_vehicle' => $idVehicle,
					'fk_id_user' => $idUser,
					'current_hours' => $this->input->post('hours'),
					'next_oil_change' => $this->input->post('oilChange'),
					'state' => $state,
					'current_hours_2' => $this->input->post('hours2'),
					'next_oil_change_2' => $this->input->post('oilChange2'),
					'current_hours_3' => $this->input->post('hours3'),
					'next_oil_change_3' => $this->input->post('oilChange3')
				);	
				
				$query = $this->db->insert('vehicle_oil_change', $data);
				$idVehicleNextOilChange = $this->db->insert_id();
				
				$fecha = date("Y-m-d G:i:s");

				//actualizo fecha del registo
				$sql = "UPDATE vehicle_oil_change SET date_issue = '$fecha' WHERE id_oil_change=$idVehicleNextOilChange";
				$query = $this->db->query($sql);

				if ($query) {
					
					$data = array(
						'hours' => $this->input->post('hours'),
						'oil_change' => $this->input->post('oilChange'),
						'hours_2' => $this->input->post('hours2'),
						'oil_change_2' => $this->input->post('oilChange2'),
						'hours_3' => $this->input->post('hours3'),
						'oil_change_3' => $this->input->post('oilChange3')
					);

					$this->db->where('id_vehicle', $idVehicle);
					$query = $this->db->update('param_vehicle', $data);
	
					if ($query) {
						return true;
					}else{
						//se debe borrar el registro en la tabla vehicle_oil_change
						return false;
					}
				} else {
					return false;
				}
		}
		
		/**
		 * Add/Edit EMPLOYEE TYPE
		 * @since 4/2/2017
		 */
		public function saveEmployeeType() 
		{
				$idEmployeeType = $this->input->post('hddId');
				
				$data = array(
					'employee_type' => $this->input->post('employeeType'),
					'employee_type_unit_price' => $this->input->post('unit_price')
				);
				
				//revisar si es para adicionar o editar
				if ($idEmployeeType == '') {
					$query = $this->db->insert('param_employee_type', $data);
					$idEmployeeType = $this->db->insert_id();				
				} else {
					$this->db->where('id_employee_type', $idEmployeeType);
					$query = $this->db->update('param_employee_type', $data);
				}
				if ($query) {
					return $idEmployeeType;
				} else {
					return false;
				}
		}
		
		/**
		 * Add/Edit HAZARD ACTIVITY
		 * @since 5/2/2017
		 */
		public function saveHazardActivity() 
		{
				$idHazardActivity = $this->input->post('hddId');
				
				$data = array(
					'hazard_activity' => $this->input->post('hazardActivity')
				);
				
				//revisar si es para adicionar o editar
				if ($idHazardActivity == '') {
					$query = $this->db->insert('param_hazard_activity', $data);
					$idHazardActivity = $this->db->insert_id();				
				} else {
					$this->db->where('id_hazard_activity', $idHazardActivity);
					$query = $this->db->update('param_hazard_activity', $data);
				}
				if ($query) {
					return $idHazardActivity;
				} else {
					return false;
				}
		}
		
		/**
		 * Get hazard list
		 * @since 5/2/2017
		 */
		public function get_hazard_list() 
		{		
				$this->db->select();
				$this->db->join('param_hazard_activity A', 'A.id_hazard_activity = H.fk_id_hazard_activity', 'INNER');
				$this->db->join('param_hazard_priority P', 'P.id_priority = H.fk_id_priority', 'INNER');
				$this->db->order_by('A.hazard_activity, H.hazard_description', 'asc');
				$query = $this->db->get('param_hazard H');

				if ($query->num_rows() > 0) {
					return $query->result_array();
				} else {
					return false;
				}
		}
		
	    /**
	     * Update user´s password
	     * @author BMOTTAG
	     * @since  8/11/2016
	     */
	    public function updatePassword()
		{
				$idUser = $this->input->post("hddId");
				$newPassword = $this->input->post("inputPassword");
				$passwd = str_replace(array("<",">","[","]","*","^","-","'","="),"",$newPassword); 
				$passwd = md5($passwd);
				
				$data = array(
					'password' => $passwd
				);

				$this->db->where('id_user', $idUser);
				$query = $this->db->update('user', $data);

				if ($query) {
					return true;
				} else {
					return false;
				}
	    }
		
		/**
		 * Update jobs state
		 * @since 12/1/2019
		 */
		public function updateJobsState($state) 
		{
			//if it comes from the active view, then inactive everything
			//else do nothing and continue with the activation
			if($state == 1){
				//update all states to inactive
				$data['state'] = 2;
				$query = $this->db->update('param_jobs', $data);
			}

			//update states
			$query = 1;
			if ($jobs = $this->input->post('job')) {
				$tot = count($jobs);
				for ($i = 0; $i < $tot; $i++) {
					$data['state'] = 1;
					$this->db->where('id_job', $jobs[$i]);
					$query = $this->db->update('param_jobs', $data);					
				}
			}
			if ($query) {
				return true;
			} else{
				return false;
			}
		}
		
		/**
		 * Add/Edit STOCK
		 * @since 17/3/2020
		 */
		public function saveStock() 
		{
				$idStock = $this->input->post('hddId');
				
				$data = array(
					'stock_description' => $this->input->post('stockDescription'),
					'stock_price' => $this->input->post('price'),
					'quantity' => $this->input->post('quantity')
				);
				
				//revisar si es para adicionar o editar
				if ($idStock == '') {
					$query = $this->db->insert('stock', $data);
					$idStock = $this->db->insert_id();				
				} else {
					$this->db->where('id_stock', $idStock);
					$query = $this->db->update('stock', $data);
				}
				if ($query) {
					return $idStock;
				} else {
					return false;
				}
		}
		
		
	    
	}