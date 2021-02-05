<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

	class Claims_model extends CI_Model {

			
		/**
		 * Claims list
		 * @since 3/2/2021
		 */
		public function get_claims($arrDatos) 
		{							
				$this->db->select('C.*, J.id_job, job_description, CONCAT(U.first_name, " ", U.last_name) name');
				$this->db->join('param_jobs J', 'J.id_job = C.fk_id_job_claim', 'INNER');
				$this->db->join('user U', 'U.id_user = C.fk_id_user_claim', 'INNER');
				if (array_key_exists("idClaim", $arrDatos)) {
					$this->db->where('id_claim', $arrDatos["idClaim"]);
				}								
				$this->db->order_by('id_claim', 'desc');
				$query = $this->db->get('claim C', 50);

				if ($query->num_rows() > 0) {
					return $query->result_array();
				} else {
					return false;
				}
		}

		/**
		 * Guardar claim
		 * @since 3/2/2021
		 */
		public function guardarClaim() 
		{
				$idClaim = $this->input->post('hddId');
				$idUser = $this->session->userdata("id");
				
				$data = array(
					'fk_id_user_claim' => $idUser,
					'fk_id_job_claim' => $this->input->post('id_job'),
					'observation_claim' => $this->input->post('observation')
				);	

				//revisar si es para adicionar o editar
				if ($idClaim == '') 
				{	
					$data['current_state_claim'] = 1;
					$data['date_issue_claim'] = date("Y-m-d G:i:s");
					$query = $this->db->insert('claim', $data);
					$idClaim = $this->db->insert_id();
				} else {
					$this->db->where('id_claim', $idClaim);
					$query = $this->db->update('claim', $data);
				}
				if ($query) {
					return $idClaim;
				} else {
					return false;
				}
		}

		/**
		 * Save Claim WO 
		 * @since 3/2/2021
		 */
		public function saveClaimWO() 
		{
			$idClaim = $this->input->post('hddId');

			//update idClaim
			$query = 1;
			if ($wo = $this->input->post('wo')) {
				$tot = count($wo);
				for ($i = 0; $i < $tot; $i++) 
				{
					//actualizo la tabla de WO
					$data = array(
						'fk_id_claim' => $idClaim
					);			
					$this->db->where('id_workorder', $wo[$i]);
					$query = $this->db->update('workorder', $data);
				}
			}
			if ($query) {
				return true;
			} else{
				return false;
			}
		}

		/**
		 * Add Claim state
		 * @since 5/2/2021
		 */
		public function add_claim_state($arrData) 
		{
			$idUser = $this->session->userdata("id");
			
			$data = array(
				'fk_id_claim' => $arrData["idClaim"],
				'fk_id_user_claim' => $idUser,
				'date_issue_claim_state' => date("Y-m-d G:i:s"),
				'message_claim' => $arrData["message"],
				'state_claim' => $arrData["state"]
			);
			
			$query = $this->db->insert('claim_state', $data);

			if ($query) {
				return true;
			} else {
				return false;
			}
		}

		/**
		 * Claims list History
		 * @since 5/2/2021
		 */
		public function get_claims_history($arrDatos) 
		{							
				$this->db->select('C.*, U.first_name');
				$this->db->join('user U', 'U.id_user = C.fk_id_user_claim', 'INNER');
				if (array_key_exists("idClaim", $arrDatos)) {
					$this->db->where('C.fk_id_claim', $arrDatos["idClaim"]);
				}								
				$this->db->order_by('id_claim_state', 'desc');
				$query = $this->db->get('claim_state C');

				if ($query->num_rows() > 0) {
					return $query->result_array();
				} else {
					return false;
				}
		}

		/**
		 * Update Claim current state and last message
		 * @since 5/2/2021
		 */
		public function update_claim($arrData)
		{			
			$data = array(
				'current_state_claim' => $arrData["state"],
				'last_message_claim' => $arrData["message"]
			);			
			$this->db->where('id_claim', $arrData["idClaim"]);
			$query = $this->db->update('claim', $data);

			if ($query) {
				return true;
			} else {
				return false;
			}
		}

	
	    
	}