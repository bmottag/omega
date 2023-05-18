<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

	class Serviceorder_model extends CI_Model {

		
		/**
		 * Fire watch list
		 * @since 27/1/2023
		 */
		public function get_service_order($arrDatos) 
		{
				$this->db->select('S.*, CONCAT(U.first_name, " " , U.last_name) mechanic');
				$this->db->join('user U', 'U.id_user = S.fk_id_user', 'INNER');
				if (array_key_exists("idServiceOrder", $arrDatos)) {
					$this->db->where('id_service_order', $arrDatos["idServiceOrder"]);
				}
								
				$this->db->order_by('id_service_order', 'desc');
				$query = $this->db->get('service_order S');

				if ($query->num_rows() > 0) {
					return $query->result_array();
				} else {
					return false;
				}
		}

		/**
		 * Add/Edit SERVICE ORDER
		 * @since 18/5/2023
		 */
		public function saveServiceOrder() 
		{		
				$idServiceOrder = $this->input->post('hddIdServiceOrder');

				$data = array(
					'fk_id_user' => $this->session->userdata("id"),
					'fk_id_type_2' => $this->input->post('type'),
					'fk_id_equipment' => $this->input->post('truck'),
					'current_hours' => $this->input->post('hour'),
					'damages' => $this->input->post('damages'),
					'shop_labour' => $this->input->post('shop_labour'),
					'field_labour' => $this->input->post('field_labour'),
					'engine_oil' => $this->input->post('engine_oil'),
					'transmission_oil' => $this->input->post('transmission_oil'),
					'hydraulic_oil' => $this->input->post('hydraulic_oil'),
					'fuel' => $this->input->post('fuel'),
					'filters' => $this->input->post('filters'),
					'parts' => $this->input->post('parts'),
					'blade' => $this->input->post('blade'),
					'ripper' => $this->input->post('ripper'),
					'other' => $this->input->post('other'),
					'comments' => $this->input->post('comments'),
				);
				
				//revisar si es para adicionar o editar
				if ($idServiceOrder == '') {
					$data["services_status"] = 1;
					$data["created_at"] = date("Y-m-d G:i:s");
					$query = $this->db->insert('service_order', $data);				
				} else {
					$data["updated_at"] = date("Y-m-d G:i:s");
					$this->db->where('id_service_order', $idServiceOrder);
					$query = $this->db->update('service_order', $data);
				}
				if ($query) {
					return true;
				} else {
					return false;
				}
		}

	}