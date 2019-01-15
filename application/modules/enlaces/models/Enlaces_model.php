<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

	class Enlaces_model extends CI_Model {

	    		
		/**
		 * Add/Edit ENLACE
		 * @since 2/4/2018
		 */
		public function saveEnlace() 
		{
				$idEnlace = $this->input->post('hddId');
				
				$data = array(
					'enlace_name' => $this->input->post('enlace_name'),
					'enlace' => $this->input->post('enlace'),
					'order' => $this->input->post('order'),
					'enlace_estado' => $this->input->post('enlace_estado'),
					'tipo_enlace' => 1
				);
				
				//revisar si es para adicionar o editar
				if ($idEnlace == '') {
					$data['date_issue'] = date("Y-m-d G:i:s");
					$query = $this->db->insert('enlaces', $data);			
				} else {
					$this->db->where('id_enlace', $idEnlace);
					$query = $this->db->update('enlaces', $data);
				}
				if ($query) {
					return true;
				} else {
					return false;
				}
		}
		
		/**
		 * Add/Edit MANUAL
		 * @since 27/4/2018
		 */
		public function saveManual($path) 
		{
				$idEnlace = $this->input->post('hddId');
				
				$data = array(
					'enlace_name' => $this->input->post('enlace_name'),
					'enlace' => $path,
					'order' => $this->input->post('order'),
					'enlace_estado' => $this->input->post('enlace_estado'),
					'tipo_enlace' => 2
				);
				
				//revisar si es para adicionar o editar
				if ($idEnlace == '') {
					$data['date_issue'] = date("Y-m-d G:i:s");
					$query = $this->db->insert('enlaces', $data);			
				} else {
					$this->db->where('id_enlace', $idEnlace);
					$query = $this->db->update('enlaces', $data);
				}
				if ($query) {
					return true;
				} else {
					return false;
				}
		}
	
		
		
		
		
		
		
		
	    
	}