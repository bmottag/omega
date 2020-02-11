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
		

		
		

		
	    
	}