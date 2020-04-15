<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

	class Programming_model extends CI_Model {

				
		/**
		 * Add/Edit PROGRAMMING
		 * @since 2/7/2018
		 */
		public function saveProgramming() 
		{
				$idUser = $this->session->userdata("id");
				$idProgramming = $this->input->post('hddId');
				
				$data = array(
					'fk_id_job' => $this->input->post('jobName'),
					'date_programming' => $this->input->post('date'),
					'observation' => $this->input->post('observation')
				);
				
				//revisar si es para adicionar o editar
				if ($idProgramming == '') {
					$data['fk_id_user'] = $idUser;
					$data['date_issue'] = date("Y-m-d G:i:s");	
					$data['state'] = 1;
					
					$query = $this->db->insert('programming', $data);
					$idProgramming = $this->db->insert_id();
				} else {
					$this->db->where('id_programming', $idProgramming);
					$query = $this->db->update('programming', $data);
				}
				if ($query) {
					return $idProgramming;
				} else {
					return false;
				}
		}
		
		/**
		 * Add PROGRAMMING WORKER
		 * @since 16/1/2019
		 */
		public function addProgrammingWorker() 
		{						
			//add the new workers
			$query = 1;
			if ($workers = $this->input->post('workers')) {
				$tot = count($workers);
				for ($i = 0; $i < $tot; $i++) {
					$data = array(
						'fk_id_programming' => $this->input->post('hddId'),
						'fk_id_programming_user' => $workers[$i],
						'fk_id_hour' => 15, // Se coloca por defecto que ingresen a las 7 am
						'site' => 1 // Se coloca por defecto 1 -> At the yard
					);
					$query = $this->db->insert('programming_worker', $data);
				}
			}
			if ($query) {
				return true;
			} else{
				return false;
			}
		}
		
		
		/**
		 * Verify if the project already exist for that date
		 * @author BMOTTAG
		 * @since  15/1/2019
		 */
		public function verifyProject($arrData) 
		{
				$this->db->where('fk_id_job', $arrData["idJob"]);
				$this->db->where('date_programming', $arrData["date"]);				
				$this->db->where('state !=', 3);
				
				$query = $this->db->get("programming");

				if ($query->num_rows() >= 1) {
					return true;
				} else{ return false; }
		}
		
		/**
		 * Cmabia el estado de la programacion
		 * @since 8/7/2018
		 */
		public function deleteProgramming() 
		{
			$idProgramming = $this->input->post('identificador');
		
			$data = array('state' => 3); //estado eliminada
			
			$this->db->where('id_programming', $idProgramming);
			$query = $this->db->update('programming', $data);
						
			if ($query) {
				return true;
			} else {
				return false;
			}
		}
		
		/**
		 * Lista de vehiculos, para asginarlos a los trabajadores en la programacion
		 * @since 16/1/2019
		 */
		public function get_vehicles_inspection()
		{
				$trucks = array();
				$sql = "SELECT id_vehicle, CONCAT(unit_number,' -----> ', description) as unit_description 
						FROM param_vehicle V 
						INNER JOIN param_vehicle_type_2 T ON T.id_type_2 = V.type_level_2 
						WHERE fk_id_company = 1 AND T.link_inspection != 'NA' AND V.id_vehicle NOT IN(41,42,43,44,61,62) AND V.state = 1
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
		 * Update worker
		 * @since 16/1/2019
		 */
		public function saveWorker() 
		{			
				$hddId = $this->input->post('hddId');
								
				$data = array(
					'description' => $this->input->post('description'),
					'fk_id_machine' => $this->input->post('machine'),
					'fk_id_hour' => $this->input->post('hora_inicio'),
					'site' => $this->input->post('site'),
					'safety' => $this->input->post('safety')
				);
				
				$this->db->where('id_programming_worker', $hddId);
				$query = $this->db->update('programming_worker', $data);			

				if ($query) {
					return true;
				} else {
					return false;
				}
		}
		
		/**
		 * Contar trabajadors para una programacion
		 * @since  17/1/2019
		 */
		public function countWorkers($idProgramming)
		{
				$sql = "SELECT count(id_programming_worker) CONTEO";
				$sql.= " FROM programming_worker P";
				$sql.= " WHERE fk_id_programming = " . $idProgramming;
				
				$query = $this->db->query($sql);
				$row = $query->row();
				return $row->CONTEO;
		}
		
		/**
		 * Save one worker
		 * @since 19/1/2019
		 */
		public function saveOneWorkerProgramming() 
		{							
				$data = array(
					'fk_id_programming' => $this->input->post('hddId'),
					'fk_id_programming_user' => $this->input->post('worker'),
					'fk_id_hour' => 15, // Se coloca por defecto que ingresen a las 7 am
					'site' => 1 // Se coloca por defecto 1 -> At the yard
				);			

				$query = $this->db->insert('programming_worker', $data);

				if ($query) {
					return true;
				} else {
					return false;
				}
		}
					
		
	    
	}