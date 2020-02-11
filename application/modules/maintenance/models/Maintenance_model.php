<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

	class Maintenance_model extends CI_Model {

	
		/**
		 * Add maintenance
		 * @since 11/2/2020
		 */
		public function add_maintenance() 
		{
			$idVehicle = $this->input->post('hddIdVehicle');
			$idMaintenace = $this->input->post('hddIdMaintenance');
		
			$data = array(
				'date_maintenance' => $this->input->post('date'),
				'amount' => $this->input->post('amount'),
				'fk_id_maintenance_type' => $this->input->post('id_maintenance_type'),
				'maintenance_description' => $this->input->post('description'),
				'done_by' => $this->input->post('done_by'),
				'fk_revised_by_user' => $this->input->post('revised_by')
			);
			
			//revisar si es para adicionar o editar
			if ($idMaintenace == '') {
				$data['fk_id_vehicle'] = $this->input->post('hddIdVehicle');
				$query = $this->db->insert('maintenance', $data);
				$idMaintenace = $this->db->insert_id();
			} else {
				$this->db->where('id_maintenance', $idMaintenace);
				$query = $this->db->update('maintenance', $data);
			}
			
			if ($query) {
				return $idMaintenace;
			} else {
				return false;
			}
		}
		
		/**
		 * Maintenance list
		 * @since 11/2/2020
		 */
		public function get_maintenance($arrDatos) 
		{
				$this->db->select('M.*, T.*, CONCAT(U.first_name, " " , U.last_name) name');
				$this->db->join('maintenance_type T', 'T.id_maintenance_type = M.fk_id_maintenance_type', 'INNER');
				$this->db->join('user U', 'U.id_user = M.fk_revised_by_user', 'INNER');
				
				if (array_key_exists("idMaintenance", $arrDatos)) {
					$this->db->where('M.id_maintenance', $arrDatos["idMaintenance"]);
				}
				$query = $this->db->get('maintenance M');

				if ($query->num_rows() > 0) {
					return $query->result_array();
				} else {
					return false;
				}
		}
		
		

		
		

		
	    
	}