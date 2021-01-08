<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

	class Workorders_model extends CI_Model {

			
		/**
		 * Workorders´s list
		 * las 10 records
		 * @since 12/1/2017
		 */
		public function get_workordes_by_idUser($arrDatos) 
		{
				//$year = date('Y');
				//$firstDay = date('Y-m-d', mktime(0,0,0, 1, 1, $year));//para filtrar solo los registros del año actual
							
				$this->db->select('W.*, J.id_job, job_description, CONCAT(U.first_name, " ", U.last_name) name');
				$this->db->join('param_jobs J', 'J.id_job = W.fk_id_job', 'INNER');
				$this->db->join('user U', 'U.id_user = W.fk_id_user', 'INNER');

				if (array_key_exists("idWorkorder", $arrDatos)) {
					$this->db->where('id_workorder', $arrDatos["idWorkorder"]);
				}
				if (array_key_exists("idEmployee", $arrDatos)) {
					$this->db->where('fk_id_user', $arrDatos["idEmployee"]);
				}
				
				//$this->db->where('W.date >=', $firstDay);
				
				$this->db->order_by('id_workorder', 'desc');
				$query = $this->db->get('workorder W', 50);

				if ($query->num_rows() > 0) {
					return $query->result_array();
				} else {
					return false;
				}
		}
		
		/**
		 * Add workorder
		 * @since 13/1/2017
		 */
		public function add_workorder() 
		{
			$idUser = $this->session->userdata("id");
			$idWorkorder = $this->input->post('hddIdentificador');
			
			$data = array(
				'fk_id_job' => $this->input->post('jobName'),
				'date' => $this->input->post('date'),
				'fk_id_company' => $this->input->post('company'),
				'foreman_name_wo' => $this->input->post('foreman'),
				'foreman_movil_number_wo' => $this->input->post('movilNumber'),
				'foreman_email_wo' => $this->input->post('email'),
				'observation' => $this->input->post('observation')
			);
			
			//revisar si es para adicionar o editar
			if ($idWorkorder == '') {
				$data['fk_id_user'] = $idUser;
				$data['date_issue'] = date("Y-m-d G:i:s");
				$data['state'] = 0;
				$data['last_message'] = 'New work order.';
				$query = $this->db->insert('workorder', $data);
				$idWorkorder = $this->db->insert_id();
			} else {
				$this->db->where('id_workorder', $idWorkorder);
				$query = $this->db->update('workorder', $data);
			}
			if ($query) {
				return $idWorkorder;
			} else {
				return false;
			}
		}
		
		/**
		 * Get workorder personal info
		 * @since 13/1/2017
		 */
		public function get_workorder_personal($idWorkorder) 
		{		
				$this->db->select("W.*, CONCAT(first_name, ' ', last_name) name, T.employee_type");
				$this->db->join('user U', 'U.id_user = W.fk_id_user', 'INNER');
				$this->db->join('param_employee_type T', 'T.id_employee_type = W.fk_id_employee_type', 'INNER');
				$this->db->where('W.fk_id_workorder', $idWorkorder); 
				$this->db->order_by('U.first_name, U.last_name', 'asc');
				$query = $this->db->get('workorder_personal W');

				if ($query->num_rows() > 0) {
					return $query->result_array();
				} else {
					return false;
				}
		}
		
		/**
		 * Add personal
		 * @since 13/1/2017
		 */
		public function savePersonal() 
		{			
				$data = array(
					'fk_id_workorder' => $this->input->post('hddidWorkorder'),
					'fk_id_user' => $this->input->post('employee'),
					'fk_id_employee_type' => $this->input->post('type'),
					'hours' => $this->input->post('hour'),
					'description' => $this->input->post('description')
				);

				$query = $this->db->insert('workorder_personal', $data);			

				if ($query) {
					return true;
				} else {
					return false;
				}
		}
		
		/**
		 * Get workorder materials info
		 * @since 13/1/2017
		 */
		public function get_workorder_materials($idWorkorder) 
		{		
				$this->db->select();
				$this->db->join('param_material_type M', 'M.id_material = W.fk_id_material', 'INNER');
				$this->db->where('W.fk_id_workorder', $idWorkorder); 
				$this->db->order_by('M.material', 'asc');
				$query = $this->db->get('workorder_materials W');

				if ($query->num_rows() > 0) {
					return $query->result_array();
				} else {
					return false;
				}
		}
		
		/**
		 * Add Material
		 * @since 13/1/2017
		 */
		public function saveMaterial() 
		{			
				$data = array(
					'fk_id_workorder' => $this->input->post('hddidWorkorder'),
					'fk_id_material' => $this->input->post('material'),
					'quantity' => $this->input->post('quantity'),
					'unit' => $this->input->post('unit'),
					'description' => $this->input->post('description')
				);

				$query = $this->db->insert('workorder_materials', $data);			

				if ($query) {
					return true;
				} else {
					return false;
				}
		}
		
		/**
		 * Add Ocasional
		 * @since 20/2/2017
		 */
		public function saveOcasional() 
		{			
				$data = array(
					'fk_id_workorder' => $this->input->post('hddidWorkorder'),
					'fk_id_company' => $this->input->post('company'),
					'equipment' => $this->input->post('equipment'),
					'quantity' => $this->input->post('quantity'),
					'unit' => $this->input->post('unit'),
					'hours' => $this->input->post('hour'),
					'contact' => $this->input->post('contact'),
					'description' => $this->input->post('description')
				);

				$query = $this->db->insert('workorder_ocasional', $data);			

				if ($query) {
					return true;
				} else {
					return false;
				}
		}
		
		/**
		 * Add HOLD BACK
		 * @since 12/11/2018
		 */
		public function saveHoldBack() 
		{			
				$data = array(
					'fk_id_workorder' => $this->input->post('hddidWorkorder'),
					'value' => $this->input->post('value'),
					'description' => $this->input->post('description')
				);

				$query = $this->db->insert('workorder_hold_back', $data);			

				if ($query) {
					return true;
				} else {
					return false;
				}
		}

		/**
		 * Trucks list by company and type2
		 * @since 25/1/2017
		 */
		public function get_trucks_by_id2($idCompany, $type)
		{
				$trucks = array();
				$sql = "SELECT id_vehicle, CONCAT(unit_number,' -----> ', description) as unit_description
					FROM param_vehicle 
					WHERE fk_id_company = $idCompany AND type_level_2 = $type AND state = 1
					ORDER BY unit_number";
				
				$query = $this->db->query($sql);
				if ($query->num_rows() > 0) {
					$i = 0;
					foreach ($query->result() as $row) {
						$trucks[$i]["id_truck"] = $row->id_vehicle;
						$trucks[$i]["unit_number"] = $row->unit_description;
						$i++;
					}
				}
				$this->db->close();
				return $trucks;
		}

		/**
		 * Trucks list by type1 = rentals
		 * que esten activas
		 * @since 8/3/2017
		 */
		public function get_trucks_by_id1()
		{
				$trucks = array();
				$sql = "SELECT id_vehicle, CONCAT(unit_number,' -----> ', description) as unit_description
					FROM param_vehicle 
					WHERE type_level_1 = 2 AND state = 1
					ORDER BY unit_number";
				
				$query = $this->db->query($sql);
				if ($query->num_rows() > 0) {
					$i = 0;
					foreach ($query->result() as $row) {
						$trucks[$i]["id_truck"] = $row->id_vehicle;
						$trucks[$i]["unit_number"] = $row->unit_description;
						$i++;
					}
				}
				$this->db->close();
				return $trucks;
		}		

		/**
		 * Add Equipment
		 * @since 25/1/2017
		 */
		public function saveEquipment() 
		{			
				$type = $this->input->post('type');
				$truck = $this->input->post('truck');
				
				if($type == 8){
					$truck = 5;
				}
				//si es diferente a Pickup entonces colocar que Stanby = NO
				if($type != 3){
					$standby = 2;
				}else{
					$standby = $this->input->post('standby');
				}
				$data = array(
					'fk_id_workorder' => $this->input->post('hddidWorkorder'),
					'fk_id_type_2' => $this->input->post('type'),
					'fk_id_vehicle' => $truck,
					'other' => $this->input->post('otherEquipment'),
					'operatedby' => $this->input->post('operatedby'),
					'hours' => $this->input->post('hour'),
					'quantity' => $this->input->post('quantity'),
					'standby' => $standby,
					'description' => $this->input->post('description')
				);

				$query = $this->db->insert('workorder_equipment', $data);			

				if ($query) {
					return true;
				} else {
					return false;
				}
		}
		
		/**
		 * Get workorder equipment info
		 * @since 25/1/2017
		 */
		public function get_workorder_equipment($idWorkorder) 
		{		
				$this->db->select("W.*, V.make, V.model, V.unit_number, V.description v_description, M.miscellaneous, T.type_2, C.*, CONCAT(U.first_name,' ', U.last_name) as operatedby");
				$this->db->join('param_vehicle V', 'V.id_vehicle = W.fk_id_vehicle', 'LEFT');
				$this->db->join('param_miscellaneous M', 'M.id_miscellaneous = W.fk_id_vehicle', 'LEFT');
				$this->db->join('user U', 'U.id_user = W.operatedby', 'LEFT');
				$this->db->join('param_vehicle_type_2 T', 'T.id_type_2 = W.fk_id_type_2', 'INNER');
				$this->db->join('param_company C', 'C.id_company = W.fk_id_company', 'LEFT');
				$this->db->where('W.fk_id_workorder', $idWorkorder); 
				$query = $this->db->get('workorder_equipment W');

				if ($query->num_rows() > 0) {
					return $query->result_array();
				} else {
					return false;
				}
		}

		/**
		 * Get workorder ocasional info
		 * @since 20/2/2017
		 */
		public function get_workorder_ocasional($idWorkorder) 
		{		
				$this->db->select('O.*, C.company_name');
				$this->db->join('param_company C', 'C.id_company = O.fk_id_company', 'INNER');
				$this->db->where('O.fk_id_workorder', $idWorkorder); 
				$this->db->order_by('C.company_name', 'asc');
				$query = $this->db->get('workorder_ocasional O');

				if ($query->num_rows() > 0) {
					return $query->result_array();
				} else {
					return false;
				}
		}
		
		/**
		 * Get workorder HOLD BACK info
		 * @since 12/11/2018
		 */
		public function get_workorder_hold_back($idWorkorder) 
		{		
				$this->db->select();
				$this->db->where('H.fk_id_workorder', $idWorkorder); 
				$this->db->order_by('H.id_workorder_hold_back', 'asc');
				$query = $this->db->get('workorder_hold_back H');

				if ($query->num_rows() > 0) {
					return $query->result_array();
				} else {
					return false;
				}
		}
		
		/**
		 * Work Order
		 * @since 21/02/2017
		 */
		public function get_workorder_by_idJob($arrData) 
		{						
				//$year = date('Y');
				//$firstDay = date('Y-m-d', mktime(0,0,0, 1, 1, $year));
				
				$this->db->select("W.*, CONCAT(first_name, ' ', last_name) name, J.job_description, J.markup, C.*");
				$this->db->join('user U', 'U.id_user = W.fk_id_user', 'INNER');
				$this->db->join('param_jobs J', 'J.id_job = W.fk_id_job', 'INNER');
				$this->db->join('param_company C', 'C.id_company = W.fk_id_company', 'LEFT');
				
				if (array_key_exists("jobId", $arrData) && $arrData["jobId"] != '' && $arrData["jobId"] != 0) {
					$this->db->where('W.fk_id_job', $arrData["jobId"]);
				}
				if (array_key_exists("idWorkOrder", $arrData) && $arrData["idWorkOrder"] != '' && $arrData["idWorkOrder"] != 0) {
					$this->db->where('W.id_workorder', $arrData["idWorkOrder"]);
				}
				if (array_key_exists("idWorkOrderFrom", $arrData) && $arrData["idWorkOrderFrom"] != '' && $arrData["idWorkOrderFrom"] != 0) {
					$this->db->where('W.id_workorder >=', $arrData["idWorkOrderFrom"]);
				}
				if (array_key_exists("idWorkOrderTo", $arrData) && $arrData["idWorkOrderTo"] != '' && $arrData["idWorkOrderTo"] != 0) {
					$this->db->where('W.id_workorder <=', $arrData["idWorkOrderTo"]);
				}
				if (array_key_exists("from", $arrData) && $arrData["from"] != '') {
					$this->db->where('W.date >=', $arrData["from"]);
				}				
				if (array_key_exists("to", $arrData) && $arrData["to"] != '' && $arrData["from"] != '') {
					$this->db->where('W.date <=', $arrData["to"]);
				}
				if (array_key_exists("state", $arrData) && $arrData["state"] != '') {
					$this->db->where('W.state', $arrData["state"]);
				}
				
				//$this->db->where('W.date >=', $firstDay);
				
				$this->db->order_by('W.id_workorder', 'desc');
				$query = $this->db->get('workorder W');

				if ($query->num_rows() > 0) {
					return $query->result_array();
				} else {
					return false;
				}
		}
		
		/**
		 * Update Rate
		 * @since 27/2/2017
		 */
		public function saveRate() 
		{			
				$hddId = $this->input->post('hddId');
				$formType = $this->input->post('formType');
				$description = $this->input->post('description');
				$unit = $this->input->post('unit');
				$rate = $this->input->post('rate');
				$quantity = $this->input->post('quantity');
				$hours = $this->input->post('hours');
				
				$value = $rate * $quantity * $hours;
				
				$data = array(
					'description' => $description,
					'rate' => $rate,
					'value' => $value
				);
				
				switch ($formType) {
					case "personal":
						$data['hours'] = $hours;
						break;
					case "materials":
						$markup = $this->input->post('markup');
						$value = $value * ($markup+100)/100;

						$data['markup'] = $markup;
						$data['value'] = $value;
						$data['quantity'] = $quantity;
						$data['unit'] = $unit;
						break;
					case "equipment":
						$data['hours'] = $hours;
						$data['quantity'] = $quantity;
						break;
					case "ocasional":
						$markup = $this->input->post('markup');
						$value = $value * ($markup+100)/100;

						$data['markup'] = $markup;
						$data['value'] = $value;

						$data['hours'] = $hours;
						$data['quantity'] = $quantity;
						$data['unit'] = $unit;
						break;
					case "hold_back":
						break;
				}
				
				$this->db->where('id_workorder_'.$formType, $hddId);
				$query = $this->db->update('workorder_'.$formType, $data);			

				if ($query) {
					return true;
				} else {
					return false;
				}
		}
		
		/**
		 * Add info boton go back
		 * @since 11/11/2018
		 */
		public function saveInfoGoBack($arrData) 
		{
			$idUser = $this->session->userdata("id");
			
			//delete datos anteriores del usuario
			$this->db->delete('workorder_go_back', array('fk_id_user' => $idUser));
			
			$data = array(
				'fk_id_user' => $idUser,
				'post_from' => $arrData["from"],
				'post_to' => $arrData["to"]
			);

			if (array_key_exists("jobId", $arrData)) {
				$data['post_id_job'] = $arrData["jobId"];
			}
			if (array_key_exists("idWorkOrder", $arrData)) {
				$data['post_id_work_order'] = $arrData["idWorkOrder"];
			}
			if (array_key_exists("idWorkOrderFrom", $arrData)) {
				$data['post_id_wo_from'] = $arrData["idWorkOrderFrom"];
			}
			if (array_key_exists("idWorkOrderTo", $arrData)) {
				$data['post_id_wo_to'] = $arrData["idWorkOrderTo"];
			}
			if (array_key_exists("state", $arrData)) {
				$data['post_state'] = $arrData["state"];
			}
			
			$query = $this->db->insert('workorder_go_back', $data);

		}
		
		/**
		 * Work Order info go back
		 * @since 11/11/2018
		 */
		public function get_workorder_go_back() 
		{						
				$idUser = $this->session->userdata("id");
				
				$this->db->where('fk_id_user', $idUser);

				$query = $this->db->get('workorder_go_back');

				if ($query->num_rows() > 0) {
					return $query->row_array();
				} else {
					return false;
				}
		}
		
		/**
		 * Get workorder additional info
		 * @since 11/1/2020
		 */
		public function get_workorder_state($idWorkorder) 
		{		
				$this->db->select("W.*, U.first_name");
				$this->db->join('user U', 'U.id_user = W.fk_id_user', 'INNER');
				$this->db->where('W.fk_id_workorder', $idWorkorder); 
				$this->db->order_by('W.id_workorder_state', 'desc');
				$query = $this->db->get('workorder_state W');

				if ($query->num_rows() > 0) {
					return $query->result_array();
				} else {
					return false;
				}
		}
		
		/**
		 * Add workorder state
		 * @since 11/1/2020
		 */
		public function add_workorder_state($arrData) 
		{
			$idUser = $this->session->userdata("id");
			
			$data = array(
				'fk_id_workorder' => $arrData["idWorkorder"],
				'fk_id_user' => $idUser,
				'date_issue' => date("Y-m-d G:i:s"),
				'observation' => $arrData["observation"],
				'state' => $arrData["state"]
			);
			
			$query = $this->db->insert('workorder_state', $data);

			if ($query) {
				return true;
			} else {
				return false;
			}
		}
		
		/**
		 * Contar registros de workorder
		 * Int idJob
		 * Int Year
		 * Int Estado
		 * @author BMOTTAG
		 * @since  7/2/2020
		 */
		public function countWorkorders($arrDatos)
		{			
				$sql = "SELECT count(id_workorder) CONTEO";
				$sql.= " FROM workorder W";
				$sql.= " WHERE 1=1";

				//filtrar por JOB ID
				if (array_key_exists("idJob", $arrDatos)) {
					$sql.= " AND fk_id_job = " . $arrDatos["idJob"];
				}elseif (array_key_exists("year", $arrDatos)) {
					$year = $arrDatos["year"];
					$firstDay = date('Y-m-d', mktime(0,0,0, 1, 1, $year));//primer dia del año
					//$lastDay = date('Y-m-d',(mktime(0,0,0,13,1,$year)-1));//ultimo dia del año
					$lastDay = date('Y-m-d', mktime(0,0,0, 1, 1, $year+1));//primer dia del siguiente año para que incluya todo el dia anterior en la consulta

					$sql.= " AND date >= '$firstDay'";
					$sql.= " AND date <= '$lastDay'";
				}else{ //si no envia año entonces selecciono el año actual
					$year = date('Y');
					$firstDay = date('Y-m-d', mktime(0,0,0, 1, 1, $year));//primer dia del año
					$sql.= " AND date >= '$firstDay'";
				}
				
				if (array_key_exists("from", $arrDatos) && $arrDatos["from"] != '') {
					$sql.= " AND date >= '" . $arrDatos["from"] ."'";
				}				
				if (array_key_exists("to", $arrDatos) && $arrDatos["to"] != '' && $arrDatos["from"] != '') {
					$sql.= " AND date <= '" . $arrDatos["to"] . "'";
				}
				
				//filtrar por estado
				if (array_key_exists("state", $arrDatos)){
					$sql.= " AND state =" . $arrDatos["state"];
				}
				
				$query = $this->db->query($sql);
				$row = $query->row();
				return $row->CONTEO;
		}

		/**
		 * Sumatoria de horas de personal
		 * Int idJob
		 * @author BMOTTAG
		 * @since  10/2/2020
		 */
		public function countHoursPersonal($arrDatos)
		{					
				$sql = "SELECT ROUND(SUM(hours),2) TOTAL";
				$sql.= " FROM workorder_personal P";
				$sql.= " INNER JOIN workorder W on W.id_workorder = P.fk_id_workorder";
				$sql.= " WHERE W.fk_id_job =" . $arrDatos["idJob"];
								
				$query = $this->db->query($sql);
				$row = $query->row();
				return $row->TOTAL;
		}
		
		/**
		 * Sumatoria de valores para la WO
		 * Int idJob
		 * Var table
		 * @author BMOTTAG
		 * @since  10/2/2020
		 */
		public function countIncome($arrDatos)
		{					
				$sql = "SELECT ROUND(SUM(value),2) TOTAL";
				$sql.= " FROM " . $arrDatos["table"] . " P";
				$sql.= " INNER JOIN workorder W on W.id_workorder = P.fk_id_workorder";
				$sql.= " WHERE W.fk_id_job =" . $arrDatos["idJob"];
								
				if (array_key_exists("from", $arrDatos) && $arrDatos["from"] != '') {
					$sql.= " AND date >= '" . $arrDatos["from"] ."'";
				}				
				if (array_key_exists("to", $arrDatos) && $arrDatos["to"] != '' && $arrDatos["from"] != '') {
					$sql.= " AND date <= '" . $arrDatos["to"] . "'";
				}

				$query = $this->db->query($sql);
				$row = $query->row();
				return $row->TOTAL;
		}
		
		/**
		 * Informacion del foreman
		 * @since 4/6/2020
		 */
		public function info_foreman($idForeman) 
		{
			
			$data = array(
				'foreman_name' => $this->input->post('foreman'),
				'foreman_movil_number' => $this->input->post('movilNumber'),
				'foreman_email' => $this->input->post('email')
			);
			
			//revisar si es para adicionar o editar
			if ($idForeman == '') {
				$data['fk_id_param_company'] = $this->input->post('company');
				$query = $this->db->insert('param_company_foreman', $data);
			} else {
				$this->db->where('id_company_foreman', $idForeman);
				$query = $this->db->update('param_company_foreman', $data);
			}
			if ($query) {
				return true;
			} else {
				return false;
			}
		}
		
		/**
		 * Get Prices for workorder personal
		 * @since 13/1/2017
		 */
		public function get_workorder_personal_prices($idWorkorder, $idJob) 
		{		
				$this->db->select("W.*, T.job_employee_type_unit_price");
				$this->db->join('job_employee_type_price T', 'T.fk_id_employee_type = W.fk_id_employee_type', 'INNER');
				$this->db->where('W.fk_id_workorder', $idWorkorder); 
				$this->db->where('T.fk_id_job ', $idJob); 
				$query = $this->db->get('workorder_personal W');

				if ($query->num_rows() > 0) {
					return $query->result_array();
				} else {
					return false;
				}
		}
	
		/**
		 * Update WO personal rate and value
		 * @since 7/11/2020
		 */
		public function update_wo_personal_rate($workorderPersonalRate) 
		{
			$idWO = $this->input->post('identificador');
			
			//add the new employee types
			$query = 1;
			if ($workorderPersonalRate) {
				$tot = count($workorderPersonalRate);
				for ($i = 0; $i < $tot; $i++) 
				{					
					$rate = $workorderPersonalRate[$i]['job_employee_type_unit_price'];
					$hours = $workorderPersonalRate[$i]['hours'];
					$value = $rate * $hours;
					
					$data = array(
						'rate' => $rate,
						'value' => $value
					);
					$this->db->where('id_workorder_personal  ', $workorderPersonalRate[$i]['id_workorder_personal']);
					$query = $this->db->update('workorder_personal', $data);
				}
			}
			
			if ($query) {
				return true;
			} else{
				return false;
			}
		}	
		
		/**
		 * Get Prices for workorder equipment
		 * @since 10/11/2020
		 */
		public function get_workorder_equipment_prices($idWorkorder, $idJob)
		{		
				$this->db->select("W.*, T.job_equipment_unit_price, T.job_equipment_without_driver");
				$this->db->join('job_equipment_price T', 'T.fk_id_equipment = W.fk_id_vehicle', 'INNER');				
				$this->db->where('W.fk_id_workorder', $idWorkorder); 
				$this->db->where('T.fk_id_job ', $idJob); 
				$query = $this->db->get('workorder_equipment W');

				if ($query->num_rows() > 0) {
					return $query->result_array();
				} else {
					return false;
				}
		}
		
		/**
		 * Update WO equipment rate and value
		 * @since 10/11/2020
		 */
		public function update_wo_equipment_rate($workorderEquipmentRate) 
		{
			$idWO = $this->input->post('identificador');
			
			//add the new employee types
			$query = 1;
			if ($workorderEquipmentRate) {
				$tot = count($workorderEquipmentRate);
				for ($i = 0; $i < $tot; $i++) 
				{					
					//verificar si esta en STANBY para saber que rate coger
					$standby = $workorderEquipmentRate[$i]['standby'];
					if($standby == 1){
						$rate = $workorderEquipmentRate[$i]['job_equipment_without_driver'];
					}else{
						$rate = $workorderEquipmentRate[$i]['job_equipment_unit_price'];	
					}

					$hours = $workorderEquipmentRate[$i]['hours'];
					
					$quantity = $workorderEquipmentRate[$i]['quantity'];
					$quantity = $quantity==0?1:$quantity;
					
					$value = $rate * $quantity * $hours;
					
					$data = array(
						'rate' => $rate,
						'value' => $value
					);
					$this->db->where('id_workorder_equipment', $workorderEquipmentRate[$i]['id_workorder_equipment']);
					$query = $this->db->update('workorder_equipment', $data);
				}
			}
			
			if ($query) {
				return true;
			} else{
				return false;
			}
		}

		/**
		 * Get Prices for workorder material
		 * @since 16/12/2020
		 */
		public function get_workorder_material_prices($idWorkorder)
		{		
				$this->db->select("W.*, T.material_price");
				$this->db->join('param_material_type T', 'T.id_material = W.fk_id_material', 'INNER');				
				$this->db->where('W.fk_id_workorder', $idWorkorder); 
				$query = $this->db->get('workorder_materials W');

				if ($query->num_rows() > 0) {
					return $query->result_array();
				} else {
					return false;
				}
		}

		/**
		 * Update WO material rate and value
		 * @since 18/12/2020
		 */
		public function update_wo_material_rate($workorderMaterialRate) 
		{
			$idWO = $this->input->post('identificador');
			
			//calcular valor y actualizar campos
			$query = 1;
			if ($workorderMaterialRate) {
				$tot = count($workorderMaterialRate);
				for ($i = 0; $i < $tot; $i++) 
				{					
					$rate = $workorderMaterialRate[$i]['material_price'];
					$quantity = $workorderMaterialRate[$i]['quantity'];
					$value = $rate * $quantity;
					
					$data = array(
						'rate' => $rate,
						'value' => $value
					);
					$this->db->where('id_workorder_materials  ', $workorderMaterialRate[$i]['id_workorder_materials']);
					$query = $this->db->update('workorder_materials', $data);
				}
			}
			
			if ($query) {
				return true;
			} else{
				return false;
			}
		}	
		
		/**
		 * Update state and last message
		 * @since 23/12/2020
		 */
		public function update_workorder($arrData)
		{			
			$data = array(
				'state' => $arrData["state"],
				'last_message' => $arrData["lastMessage"]
			);			
			$this->db->where('id_workorder', $arrData["idWorkorder"]);
			$query = $this->db->update('workorder', $data);

			if ($query) {
				return true;
			} else {
				return false;
			}
		}

		/**
		 * Get workorder invoice info
		 * @since 4/1/2021
		 */
		public function get_workorder_invoice($idWorkorder) 
		{		
				$this->db->select();
				$this->db->where('O.fk_id_workorder', $idWorkorder); 
				$this->db->order_by('O.place', 'asc');
				$query = $this->db->get('workorder_invoice O');

				if ($query->num_rows() > 0) {
					return $query->result_array();
				} else {
					return false;
				}
		}

		/**
		 * Add Invoice
		 * @since 4/1/2021
		 */
		public function saveInvoice() 
		{
				$idWOInvoice = $this->input->post('hddId');

				$data = array(
					'place' => $this->input->post('place'),
					'price' => $this->input->post('price'),
					'description' => $this->input->post('description')
				);
				
				//revisar si es para adicionar o editar
				if ($idWOInvoice == '') {
					$data['fk_id_workorder'] = $this->input->post('hddidWorkorder');
					$data['markup'] = 0;
					$query = $this->db->insert('workorder_invoice', $data);
				} else {
					$price = $this->input->post('price');
					$markup = $this->input->post('markup');
					
					$price = $price/1.05;//quitar el 5% de GST
					$value = $price + ($price*$markup/100);//valor con el markup

					$valueGST = $value*1.05;

					$data['markup'] = $markup;
					$data['value'] = $valueGST;
					$this->db->where('id_workorder_invoice', $idWOInvoice);
					$query = $this->db->update('workorder_invoice', $data);
				}
				if ($query) {
					return true;
				} else {
					return false;
				}
		}

		/**
		 * Update WO INVOICE markup and value
		 * @since 4/1/2021
		 */
		public function update_wo_invoice_markup($workorderInvoice, $markup) 
		{			
			//calcular valor y actualizar campos
			$query = 1;
			if ($workorderInvoice) {
				$tot = count($workorderInvoice);
				for ($i = 0; $i < $tot; $i++) 
				{
					$price = $workorderInvoice[$i]['price'];

					$price = $price/1.05;//quitar el 5% de GST
					$value = $price + ($price*$markup/100);//valor con el markup

					$valueGST = $value*1.05;
					
					$data = array(
						'markup' => $markup,
						'value' => $valueGST
					);
					$this->db->where('id_workorder_invoice  ', $workorderInvoice[$i]['id_workorder_invoice']);
					$query = $this->db->update('workorder_invoice', $data);
				}
			}
			
			if ($query) {
				return true;
			} else{
				return false;
			}
		}

		/**
		 * Update WO MATERIAL markup and value
		 * @since 5/1/2021
		 */
		public function update_wo_material_markup($workorderMaterials, $markup) 
		{			
			//calcular valor y actualizar campos
			$query = 1;
			if ($workorderMaterials) {
				$tot = count($workorderMaterials);
				for ($i = 0; $i < $tot; $i++) 
				{
					$rate = $workorderMaterials[$i]['rate'];
					$quantity = $workorderMaterials[$i]['quantity'];

					$value = $rate * $quantity;

					$value = $value * ($markup+100)/100;
					
					$data = array(
						'markup' => $markup,
						'value' => $value
					);
					$this->db->where('id_workorder_materials', $workorderMaterials[$i]['id_workorder_materials']);
					$query = $this->db->update('workorder_materials', $data);
				}
			}
			
			if ($query) {
				return true;
			} else{
				return false;
			}
		}

		/**
		 * Update WO OCASIONAL markup and value
		 * @since 5/1/2021
		 */
		public function update_wo_ocasional_markup($workorderOcasional, $markup) 
		{			
			//calcular valor y actualizar campos
			$query = 1;
			if ($workorderOcasional) {
				$tot = count($workorderOcasional);
				for ($i = 0; $i < $tot; $i++) 
				{
					$quantity = $workorderOcasional[$i]['quantity'];
					$hours = $workorderOcasional[$i]['hours'];
					$rate = $workorderOcasional[$i]['rate'];
					
					$value = $rate * $quantity * $hours;

					$value = $value * ($markup+100)/100;
					
					$data = array(
						'markup' => $markup,
						'value' => $value
					);
					$this->db->where('id_workorder_ocasional', $workorderOcasional[$i]['id_workorder_ocasional']);
					$query = $this->db->update('workorder_ocasional', $data);
				}
			}
			
			if ($query) {
				return true;
			} else{
				return false;
			}
		}	
		

		
		
	    
	}