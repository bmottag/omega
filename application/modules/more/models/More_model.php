<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

	class More_model extends CI_Model {

	
		/**
		 * environmental list
		 * @since 10/1/2018
		 */
		public function get_environmental($arrDatos) 
		{
				$this->db->select('E.*, CONCAT(R.first_name, " " , R.last_name) name, CONCAT(U.first_name, " " , U.last_name) inspector, CONCAT(X.first_name, " " , X.last_name) manager, J.id_job, J.job_description');
				$this->db->join('param_jobs J', 'J.id_job = E.fk_id_job', 'INNER');
				$this->db->join('user R', 'R.id_user = E.fk_id_user', 'INNER');
				$this->db->join('user U', 'U.id_user = E.fk_id_user_inspector', 'LEFT');
				$this->db->join('user X', 'X.id_user = E.fk_id_user_manager', 'LEFT');
				
				if (array_key_exists("idJob", $arrDatos)) {
					$this->db->where('E.fk_id_job', $arrDatos["idJob"]);
				}
				$query = $this->db->get('job_environmental E');

				if ($query->num_rows() > 0) {
					return $query->result_array();
				} else {
					return false;
				}
		}

		/**
		 * Add environmental
		 * @since 13/1/2018
		 */
		public function add_environmental() 
		{
			$idUser = $this->session->userdata("id");
			$idEnvironmental = $this->input->post('hddIdentificador');
		
			$data = array(
				'fk_id_user_inspector' => $this->input->post('inspector'),
				'fk_id_user_manager' => $this->input->post('manager'),
				'sites_watered' => $this->input->post('sites_watered'),
				'sites_watered_remarks' => $this->input->post('sites_watered_remarks'),
				'being_swept' => $this->input->post('being_swept'),
				'being_swept_remarks' => $this->input->post('being_swept_remarks'),
				'dusty_covered' => $this->input->post('dusty_covered'),
				'dusty_covered_remarks' => $this->input->post('dusty_covered_remarks'),
				'speed_control' => $this->input->post('speed_control'),
				'speed_control_remarks' => $this->input->post('speed_control_remarks'),
				'noise_permit' => $this->input->post('noise_permit'),
				'noise_permit_remarks' => $this->input->post('noise_permit_remarks'),
				'air_compressors' => $this->input->post('air_compressors'),
				'air_compressors_remarks' => $this->input->post('air_compressors_remarks'),
				'noise_mitigation' => $this->input->post('noise_mitigation'),
				'noise_mitigation_remarks' => $this->input->post('noise_mitigation_remarks'),
				'idle_plan' => $this->input->post('idle_plan'),
				'idle_plan_remarks' => $this->input->post('idle_plan_remarks'),
				'garbage_bin' => $this->input->post('garbage_bin'),
				'garbage_bin_remarks' => $this->input->post('garbage_bin_remarks'),
				'disposed_periodically' => $this->input->post('disposed_periodically'),
				'disposed_periodically_remarks' => $this->input->post('disposed_periodically_remarks'),
				'recycling_being' => $this->input->post('recycling_being'),
				'recycling_being_remarks' => $this->input->post('recycling_being_remarks'),
				'spill_containment' => $this->input->post('spill_containment'),
				'spill_containment_remarks' => $this->input->post('spill_containment_remarks'),
				'spillage_happen' => $this->input->post('spillage_happen'),
				'spillage_happen_remarks' => $this->input->post('spillage_happen_remarks'),
				'chemicals_stored' => $this->input->post('chemicals_stored'),
				'chemicals_stored_remarks' => $this->input->post('chemicals_stored_remarks'),
				'absorbing_chemical' => $this->input->post('absorbing_chemical'),
				'absorbing_chemical_remarks' => $this->input->post('absorbing_chemical_remarks'),
				'spill_kits' => $this->input->post('spill_kits'),
				'spill_kits_remarks' => $this->input->post('spill_kits_remarks'),
				'excessive_use' => $this->input->post('excessive_use'),
				'excessive_use_remarks' => $this->input->post('excessive_use_remarks'),
				'materials_stored' => $this->input->post('materials_stored'),
				'materials_stored_remarks' => $this->input->post('materials_stored_remarks'),
				'fire_extinguishers' => $this->input->post('fire_extinguishers'),
				'fire_extinguishers_remarks' => $this->input->post('fire_extinguishers_remarks'),
				'preventive_actions' => $this->input->post('preventive_actions'),
				'preventive_actions_remarks' => $this->input->post('preventive_actions_remarks')
			);
			
			//revisar si es para adicionar o editar
			if ($idEnvironmental == '') {
				$data['fk_id_user'] = $idUser;
				$data['fk_id_job'] = $this->input->post('hddIdJob');
				$data['date_environmental'] = date("Y-m-d");
				$query = $this->db->insert('job_environmental', $data);	
				$idEnvironmental = $this->db->insert_id();				
			} else {
				$this->db->where('id_job_environmental', $idEnvironmental);
				$query = $this->db->update('job_environmental', $data);
			}
			
			if ($query) {
				return $idEnvironmental;
			} else {
				return false;
			}
		}		
		
		/**
		 * PPE INSPECTION list
		 * para año vigente
		 * @since 15/1/2018
		 */
		public function get_ppe_inspection($arrDatos) 
		{
				$year = date('Y');
				$firstDay = date('Y-m-d', mktime(0,0,0, 1, 1, $year));//para filtrar solo los registros del año actual
				
				$this->db->select('T.*, CONCAT(U.first_name, " " , U.last_name) name');
				$this->db->join('user U', 'U.id_user = T.fk_id_user', 'INNER');

				if (array_key_exists("idPPEInspection", $arrDatos)) {
					$this->db->where('id_ppe_inspection', $arrDatos["idPPEInspection"]);
				}
				
				//$this->db->where('T.date_ppe_inspection >=', $firstDay);
				
				$this->db->order_by('id_ppe_inspection', 'desc');
				$query = $this->db->get('ppe_inspection T');

				if ($query->num_rows() > 0) {
					return $query->result_array();
				} else {
					return false;
				}
		}
		
		/**
		 * Add/Edit PPE INSPECTION
		 * @since 15/1/2018
		 */
		public function savePPEInspection() 
		{
				$idPPEInspection = $this->input->post('hddId');
				
				$data = array(
					'observation' => $this->input->post('observation')
				);
				
				//revisar si es para adicionar o editar
				if ($idPPEInspection == '') {
					$data['fk_id_user'] = $this->session->userdata("id");
					$data['date_ppe_inspection'] = date("Y-m-d");
					$query = $this->db->insert('ppe_inspection', $data);
					$idPPEInspection = $this->db->insert_id();				
				} else {
					$this->db->where('id_ppe_inspection', $idPPEInspection);
					$query = $this->db->update('ppe_inspection', $data);
				}
				if ($query) {
					return $idPPEInspection;
				} else {
					return false;
				}
		}
		
		/**
		 * Get PPE inspection workers info
		 * @since 20/1/2018
		 */
		public function get_ppe_inspection_workers($idPPEInspection) 
		{		
				$this->db->select("W.*, CONCAT(first_name, ' ', last_name) name");
				$this->db->join('user U', 'U.id_user = W.fk_id_user', 'INNER');
				$this->db->where('W.fk_id_ppe_inspection', $idPPEInspection); 
				$this->db->order_by('U.first_name, U.last_name', 'asc');
				$query = $this->db->get('ppe_inspection_workers W');

				if ($query->num_rows() > 0) {
					return $query->result_array();
				} else {
					return false;
				}
		}
		
		/**
		 * @author BMOTTAG
		 * @since 20/1/2018
		 * Consulta de empleados para un ppe inspection especifico
		 */
		public function get_ppe_inspection_byIdworker_byIdPPEIspection($idPPEInspection, $idWorker) {
			$this->db->where('fk_id_ppe_inspection', $idPPEInspection);
			$this->db->where('fk_id_user', $idWorker);
			$query = $this->db->get('ppe_inspection_workers');
			if ($query->num_rows() == 1) {
				return TRUE;
			}else{
				return FALSE;
			}
		}
		
		/**
		 * Add PPE INSPECTION WORKER
		 * @since 21/1/2018
		 */
		public function add_ppe_inspection_worker($idPPEInspection) 
		{
			//add the new workers
			$query = 1;
			if ($workers = $this->input->post('workers')) {
				$tot = count($workers);
				for ($i = 0; $i < $tot; $i++) {
					$data = array(
						'fk_id_ppe_inspection' => $idPPEInspection,
						'fk_id_user' => $workers[$i],
						'date_issue' => date("Y-m-d G:i:s") 
					);
					$query = $this->db->insert('ppe_inspection_workers', $data);
				}
			}
			if ($query) {
				return true;
			} else{
				return false;
			}
		}
		
		/**
		 * Update inspeccion trabajadores
		 * @since 29/1/2018
		 */
		public function update_ppe_inspection_worker() 
		{			
				$idPPEInspectionWorker = $this->input->post('hddIdPPEInspectionWorker');
				
				$data = array(
					'safety_boots' => $this->input->post('safety_boots'),
					'hart_hat' => $this->input->post('hart_hat'),
					'reflective_vest' => $this->input->post('reflective_vest'),
					'safety_glasses' => $this->input->post('safety_glasses'),
					'gloves' => $this->input->post('gloves')
				);
				
				$this->db->where('id_ppe_inspection_worker', $idPPEInspectionWorker);
				$query = $this->db->update('ppe_inspection_workers', $data);			

				if ($query) {
					return true;
				} else {
					return false;
				}
		}

		/**
		 * ADD one worker
		 * @since 29/1/2018
		 */
		public function addOneWorker() 
		{							
				$data = array(
					'fk_id_ppe_inspection' => $this->input->post('hddIdPPEInspection'),
					'fk_id_user' => $this->input->post('worker'),
					'date_issue' => date("Y-m-d G:i:s") 
				);			

				$query = $this->db->insert('ppe_inspection_workers', $data);

				if ($query) {
					return true;
				} else {
					return false;
				}
		}
		

		
	    
	}