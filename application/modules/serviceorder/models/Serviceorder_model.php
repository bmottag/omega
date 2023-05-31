<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

	class Serviceorder_model extends CI_Model {

		
		/**
		 * Service Order Info
		 * @since 18/5/2023
		 */
		public function get_service_order($arrDatos) 
		{
				$this->db->select('S.*, CONCAT(U.first_name, " " , U.last_name) assigned_by, CONCAT(Z.first_name, " " , Z.last_name) assigned_to, CONCAT(V.unit_number," -----> ", V.description) as unit_description, P.status_name, P.status_style, P.status_icon, W.status_name priority_name, W.status_style priority_style, W.status_icon priority_icon');
				$this->db->join('user U', 'U.id_user = S.fk_id_assign_by', 'INNER');
				$this->db->join('user Z', 'Z.id_user = S.fk_id_assign_to', 'INNER');
				$this->db->join('param_vehicle V', 'V.id_vehicle = S.fk_id_equipment', 'INNER');
				$this->db->join('param_status P', 'P.status_slug = S.service_status', 'INNER');
				$this->db->join('param_status W', 'W.status_slug = S.priority', 'INNER');
				$this->db->where('P.status_key', "serviceorder");
				if (array_key_exists("idServiceOrder", $arrDatos)) {
					$this->db->where('id_service_order', $arrDatos["idServiceOrder"]);
				}
				if (array_key_exists("idVehicle", $arrDatos)) {
					$this->db->where('fk_id_equipment', $arrDatos["idVehicle"]);
				}
								
				$this->db->order_by('id_service_order', 'desc');
				$query = $this->db->get('service_order S');

				if ($query->num_rows() > 0) {
					return $query->result_array();
				} else {
					return false;
				}
		}

		/**
		 * Add/Edit SERVICE ORDER
		 * @since 18/5/2023
		 */
		public function saveServiceOrder() 
		{		
				$idServiceOrder = $this->input->post('hddIdServiceOrder');

				$data = array(
					'fk_id_assign_to' => $this->input->post('assign_to'),					
					'current_hours' => $this->input->post('hour'),
					'damages' => $this->input->post('damages'),
					'shop_labour' => $this->input->post('shop_labour'),
					'field_labour' => $this->input->post('field_labour'),
					'engine_oil' => $this->input->post('engine_oil'),
					'transmission_oil' => $this->input->post('transmission_oil'),
					'hydraulic_oil' => $this->input->post('hydraulic_oil'),
					'fuel' => $this->input->post('fuel'),
					'filters' => $this->input->post('filters'),
					'parts' => $this->input->post('parts'),
					'blade' => $this->input->post('blade'),
					'ripper' => $this->input->post('ripper'),
					'other' => $this->input->post('other'),
					'comments' => $this->input->post('comments'),
				);
				
				//revisar si es para adicionar o editar
				if ($idServiceOrder == '') {
					$data["fk_id_assign_by"] = $this->session->userdata("id");
					$data["fk_id_equipment"] = $this->input->post('hddIdEquipment');
					$data["fk_id_maintenace"] = $this->input->post('hddIdMaintenance');
					$data["maintenace_type"] = $this->input->post('hddMaintenanceType');
					$data["maintenance_description"] = $this->input->post('hddMaintenanceDescription');
					$data["created_at"] = date("Y-m-d G:i:s");
					$data["service_status"] = "new";
					$data["priority"] = $this->input->post('priority');
					$query = $this->db->insert('service_order', $data);				
				} else {
					$data["service_status"] = $this->input->post('status');
					$data["updated_at"] = date("Y-m-d G:i:s");
					$this->db->where('id_service_order', $idServiceOrder);
					$query = $this->db->update('service_order', $data);
				}
				if ($query) {
					return true;
				} else {
					return false;
				}
		}

		/**
		 * Preventive Maintenance Info
		 * @since 22/5/2023
		 */
		public function get_preventive_maintenance($arrDatos) 
		{
				$this->db->select();
				$this->db->join('maintenance_type T', 'T.id_maintenance_type = P.fk_id_maintenance_type', 'INNER');
				if (array_key_exists("idVehicle", $arrDatos)) {
					$this->db->where('fk_id_equipment', $arrDatos["idVehicle"]);
				}
				if (array_key_exists("idMaintenance", $arrDatos)) {
					$this->db->where('id_preventive_maintenance', $arrDatos["idMaintenance"]);
				}	
				$this->db->order_by('id_preventive_maintenance', 'asc');
				$query = $this->db->get('preventive_maintenance P');

				if ($query->num_rows() > 0) {
					return $query->result_array();
				} else {
					return false;
				}
		}

		/**
		 * Add/Edit PREVENTIVE MAINTENACE
		 * @since 22/5/2023
		 */
		public function savePreventiveMaintenance() 
		{		
				$idMaintenance = $this->input->post('hddIdMaintenance');
				$nextHours = $this->input->post('next_hours_maintenance');
				$nextDate = $this->input->post('next_date_maintenance');
				if($this->input->post('verification')==1){
					$nextDate = "";
				}else{
					$nextHours = 0;
				}

				$data = array(
					'fk_id_equipment' => $this->input->post('hddIdEquipment'),
					'fk_id_maintenance_type' => $this->input->post('maintenance_type'),
					'maintenance_description' => $this->input->post('description'),
					'veification_by' => $this->input->post('verification'),
					'next_hours_maintenance' => $nextHours,
					'next_date_maintenance' => $nextDate,
					'maintenance_status' => $this->input->post('maintenance_status')
				);
				//revisar si es para adicionar o editar
				if ($idMaintenance == '') {
					$query = $this->db->insert('preventive_maintenance', $data);				
				} else {
					$this->db->where('id_preventive_maintenance', $idMaintenance);
					$query = $this->db->update('preventive_maintenance', $data);
				}
				if ($query) {
					return true;
				} else {
					return false;
				}
		}

		/**
		 * Corrective Maintenance Info
		 * @since 26/5/2023
		 */
		public function get_corrective_maintenance($arrDatos) 
		{
				$this->db->select('P.*, CONCAT(U.first_name, " " , U.last_name) request_by, S.status_name, S.status_style, S.status_icon');
				$this->db->join('user U', 'U.id_user = P.request_by', 'INNER');
				$this->db->join('param_status S', 'S.status_slug = P.maintenance_status', 'INNER');
				if (array_key_exists("idVehicle", $arrDatos)) {
					$this->db->where('fk_id_equipment', $arrDatos["idVehicle"]);
				}
				if (array_key_exists("idMaintenance", $arrDatos)) {
					$this->db->where('id_corrective_maintenance', $arrDatos["idMaintenance"]);
				}	
				$this->db->order_by('id_corrective_maintenance', 'asc');
				$query = $this->db->get('corrective_maintenance P');

				if ($query->num_rows() > 0) {
					return $query->result_array();
				} else {
					return false;
				}
		}

		/**
		 * Add/Edit CORRECTIVE MAINTENACE
		 * @since 22/5/2023
		 */
		public function saveCorrectiveMaintenance() 
		{		
				$idMaintenance = $this->input->post('hddIdMaintenance');
				$data = array(
					'fk_id_equipment' => $this->input->post('hddIdEquipment'),			
					'description_failure' => $this->input->post('description')
				);
				//revisar si es para adicionar o editar
				if ($idMaintenance == '') {
					$data["request_by"] = $this->session->userdata("id");
					$data["created_at"] = date("Y-m-d G:i:s");
					$data["maintenance_status"] = "pending";
					$query = $this->db->insert('corrective_maintenance', $data);				
				} else {
					$this->db->where('id_corrective_maintenance', $idMaintenance);
					$query = $this->db->update('corrective_maintenance', $data);
				}
				if ($query) {
					return true;
				} else {
					return false;
				}
		}

		/**
		 * Save Chat
		 * @since 29/5/2023
		 */
		public function saveChat() 
		{
			$data = array(
				'fk_id_module' => $this->input->post('hddId'),
				'module' => $this->input->post('hddModule'),
				'fk_id_user_from' => $this->session->userdata("id"),
				'created_at' => date("Y-m-d G:i:s"),
				'message' => addslashes($this->security->xss_clean($this->input->post('message')))
			);
			$query = $this->db->insert('chat', $data);
			if ($query) {
				return true;
			} else{
				return false;
			}
		}

		/**
		 * Add/Edit PARTS
		 * @since 18/5/2023
		 */
		public function saveParts() 
		{		
				$idParts = $this->input->post('hddIdPart');

				$data = array(
					'part_description' => $this->input->post('part_description'),					
					'quantity' => $this->input->post('quantity'),
					'value' => $this->input->post('value'),
					'supplier' => $this->input->post('supplier')
				);
				
				//revisar si es para adicionar o editar
				if ($idParts == '') {
					$data["fk_id_service_order"] = $this->session->userdata("id");
					$data["created_at"] = date("Y-m-d G:i:s");
					$data["part_status"] = "new_request";
					$query = $this->db->insert('service_order_parts', $data);				
				} else {
					$data["part_status"] = $this->input->post('status');
					$data["updated_at"] = date("Y-m-d G:i:s");
					$this->db->where('id_part', $idParts);
					$query = $this->db->update('service_order_parts', $data);
				}
				if ($query) {
					return true;
				} else {
					return false;
				}
		}

		/**
		 * Parts info
		 * @since 30/5/2023
		 */
		public function get_parts($arrDatos) 
		{
				//$this->db->join('user U', 'U.id_user = P.request_by', 'INNER');
				//$this->db->join('param_status S', 'S.status_slug = P.maintenance_status', 'INNER');
				if (array_key_exists("idServiceOrder", $arrDatos)) {
					$this->db->where('fk_id_service_order', $arrDatos["idServiceOrder"]);
				}
				if (array_key_exists("idPart", $arrDatos)) {
					$this->db->where('id_part', $arrDatos["idPart"]);
				}	
				$this->db->order_by('id_part', 'asc');
				$query = $this->db->get('service_order_parts P');

				if ($query->num_rows() > 0) {
					return $query->result_array();
				} else {
					return false;
				}
		}

	}