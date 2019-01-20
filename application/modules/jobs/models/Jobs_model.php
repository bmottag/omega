<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

	class Jobs_model extends CI_Model {

			
		/**
		 * Add tool box
		 * @since 24/10/2017
		 */
		public function add_tool_box() 
		{
			$idUser = $this->session->userdata("id");
			$idToolBox = $this->input->post('hddIdentificador');
		
			$data = array(
				'new_safety' => $this->input->post('newSafety'),
				'activities' => $this->input->post('activities'),
				'suggestions' => $this->input->post('suggestions'),
				'corrective_actions' => $this->input->post('correctiveActions')
			);
			
			//solo usuarios SUPER_ADMIN pueden ingresar la fecha de la inspeccion
			$userRol = $this->session->rol;
			$dateIssue = $this->input->post('date');
			
			//revisar si es para adicionar o editar
			if ($idToolBox == '') {
				$data['fk_id_user'] = $idUser;
				$data['fk_id_job'] = $this->input->post('hddIdJob');			
				
				//solo usuarios SUPER_ADMIN pueden ingresar la fecha de la inspeccion
				$data['date_tool_box'] = date("Y-m-d");
				if($userRol==99 && $dateIssue!=""){
					$data['date_tool_box'] = $dateIssue;
				}

				$query = $this->db->insert('tool_box', $data);	
				$idToolBox = $this->db->insert_id();				
			} else {
				if($userRol==99 && $dateIssue!=""){
					$data['date_tool_box'] = $dateIssue;
				}
				
				$this->db->where('id_tool_box', $idToolBox);
				$query = $this->db->update('tool_box', $data);
			}
			
			if ($query) {
				return $idToolBox;
			} else {
				return false;
			}
		}
		
		/**
		 * Add ERP
		 * @since 20/11/2017
		 */
		public function add_erp() 
		{
			$idUser = $this->session->userdata("id");
			$idERP = $this->input->post('hddIdentificador');
		
			$data = array(
				'address' => $this->input->post('address'),
				'responsible_user' => $this->input->post('responsible'),
				'coordinator_user' => $this->input->post('coordinator'),
				'fire_department' => $this->input->post('fire_department'),
				'paramedics' => $this->input->post('paramedics'),
				'ambulance' => $this->input->post('ambulance'),
				'police' => $this->input->post('police'),
				'federal_protective' => $this->input->post('federal_protective'),
				'security' => $this->input->post('security'),
				'manager' => $this->input->post('manager'),
				'electric' => $this->input->post('electric'),
				'water' => $this->input->post('water'),
				'gas' => $this->input->post('gas'),
				'emergency_user_1' => $this->input->post('contact1'),
				'emergency_user_2' => $this->input->post('contact2'),
				'voice' => $this->input->post('voice'),
				'radio' => $this->input->post('radio'),
				'phone' => $this->input->post('phone'),
				'other' => $this->input->post('other'),
				'specify' => $this->input->post('specify'),
				'location' => $this->input->post('location'),
				'directions' => $this->input->post('directions')

			);
			
			//revisar si es para adicionar o editar
			if ($idERP == '') {
				$data['fk_id_user'] = $idUser;
				$data['fk_id_job'] = $this->input->post('hddIdJob');
				$data['date_erp'] = date("Y-m-d G:i:s");
				$query = $this->db->insert('erp', $data);	
			} else {
				$this->db->where('id_erp', $idERP);
				$query = $this->db->update('erp', $data);
			}
			
			if ($query) {
				return true;
			} else {
				return false;
			}
		}
		
		/**
		 * Add new hazard
		 * @since 25/10/2017
		 */
		public function saveNewHazard() 
		{			
				$data = array(
					'fk_id_tool_box' => $this->input->post('hddidToolBox'),
					'hazard' => $this->input->post('hazard'),
					'hazard_type' => $this->input->post('hazardType'),
					'actions' => $this->input->post('actions')
				);

				$query = $this->db->insert('tool_box_new_hazard', $data);			

				if ($query) {
					return true;
				} else {
					return false;
				}
		}
	
		/**
		 * Get tool box new hazards info
		 * @since 25/10/2017
		 */
		public function get_new_hazards($idToolBox) 
		{		
				$this->db->select();
				$this->db->where('W.fk_id_tool_box', $idToolBox); 
				$this->db->order_by('W.hazard', 'asc');
				$query = $this->db->get('tool_box_new_hazard W');

				if ($query->num_rows() > 0) {
					return $query->result_array();
				} else {
					return false;
				}
		}
		
		/**
		 * Update NEW HAZARD
		 * @since 25/10/2017
		 */
		public function updateNewHazard() 
		{			
				$idNewHazard= $this->input->post('hddIdNewHazard');
				
				$data = array(
					'hazard' => $this->input->post('hazard'),
					'hazard_type' => $this->input->post('hazardType'),
					'actions' => $this->input->post('actions')
				);
				
				$this->db->where('id_new_hazard', $idNewHazard);
				$query = $this->db->update('tool_box_new_hazard', $data);			

				if ($query) {
					return true;
				} else {
					return false;
				}
		}
		
		/**
		 * @author BMOTTAG
		 * @since 2/11/2017
		 * Consulta de empleados para un tool box especifico
		 */
		public function get_toolbox_byIdworker_byIdToolBox($idToolBox, $idWorker) {
			$this->db->where('fk_id_tool_box', $idToolBox);
			$this->db->where('fk_id_user', $idWorker);
			$query = $this->db->get('tool_box_workers');
			if ($query->num_rows() == 1) {
				return TRUE;
			}else{
				return FALSE;
			}
		}
		
		/**
		 * Add TOOL BOX WORKER
		 * @since 2/11/2017
		 */
		public function add_tool_box_worker($idToolBox) 
		{
			//add the new workers
			$query = 1;
			if ($workers = $this->input->post('workers')) {
				$tot = count($workers);
				for ($i = 0; $i < $tot; $i++) {
					$data = array(
						'fk_id_tool_box' => $idToolBox,
						'fk_id_user' => $workers[$i]
					);
					$query = $this->db->insert('tool_box_workers', $data);
				}
			}
			if ($query) {
				return true;
			} else{
				return false;
			}
		}
		
		
		/**
		 * Get tool box workers info
		 * @since 2/11/2017
		 */
		public function get_tool_box_workers($idToolBox) 
		{		
				$this->db->select("W.id_tool_box_worker, W.fk_id_tool_box, W.signature, CONCAT(first_name, ' ', last_name) name");
				$this->db->join('user U', 'U.id_user = W.fk_id_user', 'INNER');
				$this->db->where('W.fk_id_tool_box', $idToolBox); 
				$this->db->order_by('U.first_name, U.last_name', 'asc');
				$query = $this->db->get('tool_box_workers W');

				if ($query->num_rows() > 0) {
					return $query->result_array();
				} else {
					return false;
				}
		}
		
		/**
		 * Delete Record
		 * @since 5/12/2016
		 */
		public function deleteRecord($arrDatos) 
		{
				$query = $this->db->delete($arrDatos ["table"], array($arrDatos ["primaryKey"] => $arrDatos ["id"]));
				if ($query) {
					return true;
				} else {
					return false;
				}
		}
		
		/**
		 * ERP
		 * @since 20/11/2017
		 */
		public function get_erp($arrDatos) 
		{
				$this->db->select('E.*, U.movil phone_res, X.movil phone_co, CONCAT(U.first_name, " " , U.last_name) responsible, CONCAT(X.first_name, " " , X.last_name) coordinator, J.id_job, J.job_description,
Y.movil phone_emer_1, CONCAT(Y.first_name, " " , Y.last_name) emer_1, Z.movil phone_emer_2, CONCAT(Z.first_name, " " , Z.last_name) emer_2');
				$this->db->join('param_jobs J', 'J.id_job = E.fk_id_job', 'INNER');
				$this->db->join('user U', 'U.id_user = E.responsible_user', 'INNER');
				$this->db->join('user X', 'X.id_user = E.coordinator_user', 'INNER');
				$this->db->join('user Y', 'Y.id_user = E.emergency_user_1', 'INNER');
				$this->db->join('user Z', 'Z.id_user = E.emergency_user_2', 'INNER');
				if (array_key_exists("idJob", $arrDatos)) {
					$this->db->where('fk_id_job', $arrDatos["idJob"]);
				}
				if (array_key_exists("idERP", $arrDatos)) {
					$this->db->where('id_erp', $arrDatos["idERP"]);
				}				
				
				$query = $this->db->get('erp E');

				if ($query->num_rows() > 0) {
					return $query->result_array();
				} else {
					return false;
				}
				
		}
		
		/**
		 * Add ERP TRAINING WORKER
		 * @since 23/11/2017
		 */
		public function add_training_worker($idJob) 
		{
			//add the new workers
			$query = 1;
			if ($workers = $this->input->post('workers')) {
				$tot = count($workers);
				for ($i = 0; $i < $tot; $i++) {
					$data = array(
						'fk_id_job' => $idJob,
						'fk_id_user' => $workers[$i]
					);
					$query = $this->db->insert('erp_training_workers', $data);
				}
			}
			if ($query) {
				return true;
			} else{
				return false;
			}
		}
		
		/**
		 * Get ERP training workers info
		 * @since 23/11/2017
		 */
		public function get_erp_training_workers($idJob) 
		{		
				$this->db->select("W.id_erp_training_worker, CONCAT(first_name, ' ', last_name) name, U.*");
				$this->db->join('user U', 'U.id_user = W.fk_id_user', 'INNER');
				$this->db->where('W.fk_id_job', $idJob); 
				$this->db->order_by('U.first_name, U.last_name', 'asc');
				$query = $this->db->get('erp_training_workers W');

				if ($query->num_rows() > 0) {
					return $query->result_array();
				} else {
					return false;
				}
		}
		
		/**
		 * @author BMOTTAG
		 * @since 23/11/2017
		 * Consulta de empleados para un job especifico
		 */
		public function get_erp_training_byIdworker_byIdJob($idJob, $idWorker) {
			$this->db->where('fk_id_job', $idJob);
			$this->db->where('fk_id_user', $idWorker);
			$query = $this->db->get('erp_training_workers');
			if ($query->num_rows() == 1) {
				return TRUE;
			}else{
				return FALSE;
			}
		}
		
		/**
		 * Save one worker
		 * @since 23/11/2017
		 */
		public function saveOneWorker() 
		{							
				$data = array(
					'fk_id_job' => $this->input->post('hddId'),
					'fk_id_user' => $this->input->post('worker')
				);			

				$query = $this->db->insert('erp_training_workers', $data);

				if ($query) {
					return true;
				} else {
					return false;
				}
		}
		
		/**
		 * Get activity list
		 * @since 23/2/2017
		 */
		public function get_activity_list() 
		{		
				$this->db->select('distinct(id_hazard_activity), hazard_activity');
				$this->db->join('param_hazard_activity A', 'A.id_hazard_activity = H.fk_id_hazard_activity', 'INNER');
				$this->db->order_by('A.hazard_activity, H.hazard_description', 'asc');
				$query = $this->db->get('param_hazard H');

				if ($query->num_rows() > 0) {
					return $query->result_array();
				} else {
					return false;
				}
		}
				
		/**
		 * Get hazard list
		 * @since 27/11/2017
		 */
		public function get_hazard_list($idActivity) 
		{		
				$this->db->select();
				$this->db->join('param_hazard_activity A', 'A.id_hazard_activity = H.fk_id_hazard_activity', 'INNER');
				$this->db->where('A.id_hazard_activity', $idActivity);
				$this->db->order_by('A.hazard_activity, H.hazard_description', 'asc');
				$query = $this->db->get('param_hazard H');

				if ($query->num_rows() > 0) {
					return $query->result_array();
				} else {
					return false;
				}
		}
		
		/**
		 * @author BMOTTAG
		 * @since 27/11/2017
		 * Consulta si existe un hazard especifico para un job especifico
		 */
		public function get_job_hazards_by($idJob, $idHazard) {
			$this->db->where('fk_id_job', $idJob);
			$this->db->where('fk_id_hazard', $idHazard);
			$query = $this->db->get('job_hazards');
			if ($query->num_rows() == 1) {
				return TRUE;
			}else{
				return FALSE;
			}

		}
		
		/**
		 * Add JOB HAZARDS
		 * @since 27/11/2016
		 */
		public function add_safety_hazard($idJob) 
		{
			//delete hazards 
			$this->db->delete('job_hazards', array('fk_id_job' => $idJob));

			//add the new hazards
			$query = 1;
			if ($hazards = $this->input->post('hazards')) {
				$tot = count($hazards);
				for ($i = 0; $i < $tot; $i++) {
					$data = array(
						'fk_id_job' => $idJob,
						'fk_id_hazard' => $hazards[$i]
					);
					$query = $this->db->insert('job_hazards', $data);
				}
			}
			if ($query) {
				return true;
			} else{
				return false;
			}
		}
		
		/**
		 * Add JOB HAZARDS LOG
		 * @since 27/11/2016
		 */
		public function add_hazard_log() 
		{
			$idUser = $this->session->userdata("id");

			$data = array(
				'date_log' => date("Y-m-d G:i:s"),
				'fk_id_job' => $this->input->post('hddId'),
				'fk_id_user' => $idUser,
				'observation' => $this->input->post('observation')
				
			);
			$query = $this->db->insert('job_hazards_log', $data);

			if ($query) {
				return true;
			} else{
				return false;
			}
		}
		
		/**
		 * Get job locates info
		 * @since 29/11/2017
		 */
		public function get_job_locates($idJob) 
		{		
				$this->db->select();
				$this->db->where('L.fk_id_job', $idJob); 
				$this->db->order_by('L.id_job_locates', 'asc');
				$query = $this->db->get('job_locates L');

				if ($query->num_rows() > 0) {
					return $query->result_array();
				} else {
					return false;
				}
		}
		
		/**
		 * Add locates
		 * @since 29/11/2017
		 */
		public function add_locates($path) 
		{							
				$idUser = $this->session->userdata("id");
		
				$data = array(
					'fk_id_job' => $this->input->post('hddIdJob'),
					'fk_id_user' => $idUser,
					'locates_description' => $this->input->post('description'),
					'locates_photo' => $path,
					'locates_date' => date("Y-m-d G:i:s")
				);			

				$query = $this->db->insert('job_locates', $data);

				if ($query) {
					return true;
				} else {
					return false;
				}
		}
		
		/**
		 * Add JSO
		 * @since 4/1/2018
		 */
		public function add_jso() 
		{
			$idUser = $this->session->userdata("id");
			$idJSO = $this->input->post('hddIdentificador');
		
			$data = array(
				'fk_id_user_manager' => $this->input->post('manager'),
				'fk_id_user_supervisor' => $this->input->post('supervisor'),
				'potential_hazards' => $this->input->post('potential_hazards'),
				'health_safety' => $this->input->post('health_safety'),
				'rights_responsibilities' => $this->input->post('rights_responsibilities'),
				'company_safety_rules' => $this->input->post('company_safety_rules'),
				'hazard_awareness' => $this->input->post('hazard_awareness'),
				'reporting_procedures' => $this->input->post('reporting_procedures'),
				'personal_equipment' => $this->input->post('personal_equipment'),
				'drug_alcohol' => $this->input->post('drug_alcohol'),
				'violence_workplace' => $this->input->post('violence_workplace'),
				'whmis' => $this->input->post('whmis'),
				'equipment_operation' => $this->input->post('equipment_operation'),
				'workplace_inspections' => $this->input->post('workplace_inspections'),
				'accident_forms' => $this->input->post('accident_forms'),
				'first_aid' => $this->input->post('first_aid'),
				'erp' => $this->input->post('erp'),
				'flha' => $this->input->post('flha'),
				'near_miss' => $this->input->post('near_miss'),
				'erp_subcontractor' => $this->input->post('erp_subcontractor'),
				'accident_incident' => $this->input->post('accident_incident'),
				'preventive_maintenance' => $this->input->post('preventive_maintenance'),
				'msds' => $this->input->post('msds'),
				'notification_hazards' => $this->input->post('notification_hazards'),
				'first_aid_subcontractor' => $this->input->post('first_aid_subcontractor'),
				'smoking_drug' => $this->input->post('smoking_drug'),
				'flha_subcontractor' => $this->input->post('flha_subcontractor'),
				'environmental_management' => $this->input->post('environmental_management'),
				'working_alone' => $this->input->post('working_alone'),
				'muster_point' => $this->input->post('muster_point'),
				'fire_extinguishers' => $this->input->post('fire_extinguishers'),
				'personal_equipment_subcontractor' => $this->input->post('personal_equipment_subcontractor'),
				'equipment_inspections' => $this->input->post('equipment_inspections'),
				'housekeeping' => $this->input->post('housekeeping'),
				'hazard_identification' => $this->input->post('hazard_identification'),
				'site_safe_work' => $this->input->post('site_safe_work'),
				'site_safe_job' => $this->input->post('site_safe_job'),
				'reporting' => $this->input->post('reporting'),
				'attendance' => $this->input->post('attendance'),
				'site_rules' => $this->input->post('site_rules'),
				'confined_space' => $this->input->post('confined_space'),
				'fall_protection' => $this->input->post('fall_protection'),
				'tdg' => $this->input->post('tdg'),
				'first_aid_site' => $this->input->post('first_aid_site'),
				'whmis_site' => $this->input->post('whmis_site'),
				'traffic_control' => $this->input->post('traffic_control'),
				'backhoe' => $this->input->post('backhoe'),
				'excavator' => $this->input->post('excavator'),
				'forklift' => $this->input->post('forklift'),
				'cranes' => $this->input->post('cranes'),
				'trailer_towing' => $this->input->post('trailer_towing'),
				'power_tools' => $this->input->post('power_tools'),
				'dump_truck' => $this->input->post('dump_truck'),
				'hoists' => $this->input->post('hoists'),
				'loader' => $this->input->post('loader'),
				'light_vehicles' => $this->input->post('light_vehicles'),
				'conveyors' => $this->input->post('conveyors'),
				'compressor' => $this->input->post('compressor'),
				'environmental_reporting' => $this->input->post('environmental_reporting'),
				'low_boys' => $this->input->post('low_boys'),
				'scaffolds' => $this->input->post('scaffolds'),
				'light_towers' => $this->input->post('light_towers'),
				'generators' => $this->input->post('generators'),
				'hydrovacs' => $this->input->post('hydrovacs'),
				'hydroseeds' => $this->input->post('hydroseeds'),
				'ground_disturbance' => $this->input->post('ground_disturbance'),
				'load_securement' => $this->input->post('load_securement'),
				'traffic_accommodation' => $this->input->post('traffic_accommodation'),
				'safety_advisor' => $this->input->post('safety_advisor'),
				'wib' => $this->input->post('wib'),
				'safe_trenching' => $this->input->post('safe_trenching'),
				'street_sweeper' => $this->input->post('street_sweeper'),
				'skid_steer' => $this->input->post('skid_steer'),
				'dozers' => $this->input->post('dozers')
			);
			
			//revisar si es para adicionar o editar
			if ($idJSO == '') {
				$data['fk_id_user'] = $idUser;
				$data['fk_id_job'] = $this->input->post('hddIdJob');
				$data['date_issue_jso'] = date("Y-m-d G:i:s");
				$query = $this->db->insert('job_jso', $data);	
			} else {
				$this->db->where('id_job_jso', $idJSO);
				$query = $this->db->update('job_jso', $data);
			}
			
			if ($query) {
				return true;
			} else {
				return false;
			}
		}

		/**
		 * JSO
		 * @since 4/1/2018
		 */
		public function get_jso($arrDatos) 
		{
				$this->db->select('S.*, CONCAT(U.first_name, " " , U.last_name) supervisor, CONCAT(X.first_name, " " , X.last_name) manager, J.id_job, J.job_description');
				$this->db->join('param_jobs J', 'J.id_job = S.fk_id_job', 'INNER');
				$this->db->join('user U', 'U.id_user = S.fk_id_user_supervisor', 'INNER');
				$this->db->join('user X', 'X.id_user = S.fk_id_user_manager', 'INNER');

				if (array_key_exists("idJob", $arrDatos)) {
					$this->db->where('fk_id_job', $arrDatos["idJob"]);
				}
				if (array_key_exists("idJobJso", $arrDatos)) {
					$this->db->where('id_job_jso', $arrDatos["idJobJso"]);
				}				
				
				$query = $this->db->get('job_jso S');

				if ($query->num_rows() > 0) {
					return $query->result_array();
				} else {
					return false;
				}
				
		}
		
		/**
		 * JSO
		 * @since 5/1/2018
		 */
		public function get_jso_workers($arrDatos) 
		{
				$this->db->select();

				if (array_key_exists("idJobJso", $arrDatos)) {
					$this->db->where('fk_id_job_jso', $arrDatos["idJobJso"]);
				}
				if (array_key_exists("idJobJsoWorker", $arrDatos)) {
					$this->db->where('id_job_jso_worker', $arrDatos["idJobJsoWorker"]);
				}
				$query = $this->db->get('job_jso_workers');

				if ($query->num_rows() > 0) {
					return $query->result_array();
				} else {
					return false;
				}
				
		}
		
		/**
		 * Add jso worker
		 * @since 5/1/2018
		 */
		public function saveJSOWorker() 
		{
				$idJobJsoWorker = $this->input->post('hddidJobJsoWorker');
			
				$data = array(
					'fk_id_job_jso' => $this->input->post('hddidJobJso'),
					'name' => $this->input->post('name'),
					'rh' => $this->input->post('rh_factor'),
					'position' => $this->input->post('position'),
					'birth_date' => $this->input->post('birth'),
					'emergency_contact' => $this->input->post('emergency_contact'),
					'driver_license_required' => $this->input->post('license'),
					'license_number' => $this->input->post('license_number'),
					'city' => $this->input->post('city'),
					'works_for' => $this->input->post('worksfor'),
					'works_phone_number' => $this->input->post('phone_number')
				);

				//revisar si es para adicionar o editar
				if ($idJobJsoWorker == '') {			
					$data['date_oriented'] = date('Y-m-d');
					$query = $this->db->insert('job_jso_workers', $data);
				} else {
					$this->db->where('id_job_jso_worker', $idJobJsoWorker);
					$query = $this->db->update('job_jso_workers', $data);
				}

				if ($query) {
					return true;
				} else {
					return false;
				}
		}
		
		/**
		 * Save one worker TOOL BOX
		 * @since 8/5/2018
		 */
		public function toolBoxSaveOneWorker() 
		{							
				$data = array(
					'fk_id_tool_box' => $this->input->post('hddIdToolBox'),
					'fk_id_user' => $this->input->post('worker')
				);			

				$query = $this->db->insert('tool_box_workers', $data);

				if ($query) {
					return true;
				} else {
					return false;
				}
		}
		
		/**
		 * Lista hazards logs
		 * @since 21/8/2018
		 */
		public function get_hazards_logs($arrDatos) 
		{
				$this->db->select('A.*, J.*, CONCAT(U.first_name, " " , U.last_name) name');
				$this->db->join('param_jobs J', 'J.id_job = A.fk_id_job', 'INNER');
				$this->db->join('user U', 'U.id_user = A.fk_id_user', 'INNER');
				
				if (array_key_exists("idJob", $arrDatos)) {
					$this->db->where('fk_id_job', $arrDatos["idJob"]);
				}
				
				if (array_key_exists("idJobHazardLog", $arrDatos)) {
					$this->db->where('id_job_hazard_log', $arrDatos["idJobHazardLog"]);
				}
				
				$this->db->order_by('date_log', 'desc');
				$query = $this->db->get('job_hazards_log A');

				if ($query->num_rows() > 0) {
					return $query->result_array();
				} else {
					return false;
				}
		}
		
	/**
	 * Get job hazard info
	 * @since 27/11/2017
	 */
	public function get_job_hazards_v2($idJob) 
	{		
			$this->db->select();
			$this->db->join('param_hazard PH', 'PH.id_hazard = H.fk_id_hazard', 'INNER');
			$this->db->join('param_hazard_activity PA', 'PA.id_hazard_activity = PH.fk_id_hazard_activity', 'INNER');
			$this->db->join('param_hazard_priority PP', 'PP.id_priority = PH.fk_id_priority', 'INNER');
			$this->db->where('H.fk_id_job', $idJob); 
			$this->db->order_by('PA.hazard_activity, PH.hazard_description', 'asc');
			$query = $this->db->get('job_hazards H');

			if ($query->num_rows() > 0) {
				return $query->result_array();
			} else {
				return false;
			}
	}

		
	    
	}