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
				'amount' => $this->input->post('amount'),
				'fk_id_maintenance_type' => $this->input->post('id_maintenance_type'),
				'maintenance_description' => $this->input->post('description'),
				'done_by' => $this->input->post('done_by'),
				'fk_revised_by_user' => $this->input->post('revised_by'),
				'next_hours_maintenance' => $this->input->post('next_hours_maintenance'),
				'next_date_maintenance' => $this->input->post('next_date_maintenance')
			);
			
			//revisar si es para adicionar o editar
			if ($idMaintenace == '') 
			{
				$data['date_maintenance'] = date("Y-m-d");
				$data['fk_id_vehicle'] = $this->input->post('hddIdVehicle');
				$query = $this->db->insert('maintenance', $data);
			} else {
				$this->db->where('id_maintenance', $idMaintenace);
				$query = $this->db->update('maintenance', $data);
			}
			
			if ($query) {
				return true;
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
				if (array_key_exists("idVehicle", $arrDatos)) {
					$this->db->where('M.fk_id_vehicle', $arrDatos["idVehicle"]);
				}
				$this->db->order_by('M.id_maintenance', 'desc');
				$query = $this->db->get('maintenance M',30);

				if ($query->num_rows() > 0) {
					return $query->result_array();
				} else {
					return false;
				}
		}
		
		

		
		

		
	    
	}