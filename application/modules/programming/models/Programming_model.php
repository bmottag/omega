<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

	class Programming_model extends CI_Model {

				
		/**
		 * Add/Edit PROGRAMMING
		 * @since 2/7/2018
		 */
		public function saveProgramming() 
		{
				$hourIn = $this->input->post('hourIn');
				$hourIn = $hourIn<10?"0".$hourIn:$hourIn;
				$timeIn = $hourIn . ":" . $this->input->post('minIn');
			
			
				$idUser = $this->session->userdata("id");
				$idProgramming = $this->input->post('hddId');
				
				$data = array(
					'fk_id_job' => $this->input->post('jobName'),
					'date_programming' => $this->input->post('date'),
					'hour_programming' => $timeIn,
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
		 * @since 4/7/2018
		 */
		public function addProgrammingWorker() 
		{
			$idProgramming = $this->input->post('hddId');
			
			//delete workers
			$this->db->delete('programming_worker', array('fk_id_programming' => $idProgramming));
			
			//add the new workers
			$query = 1;
			if ($workers = $this->input->post('workers')) {
				$tot = count($workers);
				for ($i = 0; $i < $tot; $i++) {
					$data = array(
						'fk_id_programming' => $idProgramming,
						'fk_id_programming_user' => $workers[$i]
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
					
		
	    
	}