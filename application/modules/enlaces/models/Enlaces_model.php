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
		
		/**
		 * Add/Edit MENU
		 * @since 30/3/2020
		 */
		public function saveMenu() 
		{
				$idMenu = $this->input->post('hddId');
				
				$data = array(
					'menu_name' => $this->input->post('menu_name'),
					'menu_url' => $this->input->post('menu_url'),
					'menu_icon' => $this->input->post('menu_icon'),
					'menu_order' => $this->input->post('order'),
					'menu_type' => $this->input->post('menu_type')
				);
				
				//revisar si es para adicionar o editar
				if ($idMenu == '') {
					$query = $this->db->insert('param_menu', $data);			
				} else {
					$this->db->where('id_menu', $idMenu);
					$query = $this->db->update('param_menu', $data);
				}
				if ($query) {
					return true;
				} else {
					return false;
				}
		}
	
		
		
		
		
		
		
		
	    
	}