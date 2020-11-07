<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

	class Prices_model extends CI_Model {

	
		/**
		 * Add JOB EMPLOYEE TYPE PRICES
		 * @since 5/11/2020
		 */
		public function add_employee_type($employeeTypeList) 
		{
			$idJob = $this->input->post('identificador');
			
			//delete employee types 
			$this->db->delete('job_employee_type_price', array('fk_id_job' => $idJob));

			//add the new employee types
			$query = 1;
			if ($employeeTypeList) {
				$tot = count($employeeTypeList);
				for ($i = 0; $i < $tot; $i++) {
					$data = array(
						'fk_id_job' => $idJob,
						'fk_id_employee_type' => $employeeTypeList[$i]['id_employee_type'],
						'job_employee_type_unit_price' => $employeeTypeList[$i]['employee_type_unit_price']
					);
					$query = $this->db->insert('job_employee_type_price', $data);
				}
			}
			if ($query) {
				return true;
			} else{
				return false;
			}
		}	

		/**
		 * Update job employee type prices
		 * @since 6/11/2020
		 */
		public function updateEmployeeTypePrice() 
		{
			//update states
			$query = 1;
			
			$employeeType = $this->input->post('form');
			if ($employeeType) {
				$tot = count($employeeType['id']);
				
				for ($i = 0; $i < $tot; $i++) 
				{					
					$data = array(
						'job_employee_type_unit_price' => $employeeType['price'][$i]
					);
					$this->db->where('id_employee_type_price', $employeeType['id'][$i]);
					$query = $this->db->update('job_employee_type_price', $data);
				}
			}
			
			if ($query) {
				return true;
			} else{
				return false;
			}
		}	

		/**
		 * Update Equipment prices
		 * @since 6/11/2020
		 */
		public function updateEquipmentPrice() 
		{
			//update states
			$query = 1;
			
			$equipment = $this->input->post('form');
			if ($equipment) {
				$tot = count($equipment['id']);
				
				for ($i = 0; $i < $tot; $i++) 
				{					
					$data = array(
						'equipment_unit_price' => $equipment['price'][$i]
					);
					$this->db->where('id_vehicle ', $equipment['id'][$i]);
					$query = $this->db->update('param_vehicle', $data);
				}
			}
			
			if ($query) {
				return true;
			} else{
				return false;
			}
		}
		
		/**
		 * Add JOB EQUIPMENT PRICES
		 * @since 7/11/2020
		 */
		public function add_equipment($equipmentList) 
		{
			$idJob = $this->input->post('identificador');
			
			//delete employee types 
			$this->db->delete('job_equipment_price', array('fk_id_job' => $idJob));

			//add the new employee types
			$query = 1;
			if ($equipmentList) {
				$tot = count($equipmentList);
				for ($i = 0; $i < $tot; $i++) {
					$data = array(
						'fk_id_job' => $idJob,
						'fk_id_equipment' => $equipmentList[$i]['id_vehicle'],
						'job_equipment_unit_price' => $equipmentList[$i]['equipment_unit_price']
					);
					$query = $this->db->insert('job_equipment_price', $data);
				}
			}

			if ($query) {
				return true;
			} else{
				return false;
			}
		}	
		
		/**
		 * Update Job Equipment prices
		 * @since 7/11/2020
		 */
		public function updateJobEquipmentPrice() 
		{
			//update states
			$query = 1;
			
			$equipment = $this->input->post('form');
			if ($equipment) {
				$tot = count($equipment['id']);
				
				for ($i = 0; $i < $tot; $i++) 
				{					
					$data = array(
						'job_equipment_unit_price' => $equipment['price'][$i]
					);
					$this->db->where('id_equipment_price  ', $equipment['id'][$i]);
					$query = $this->db->update('job_equipment_price', $data);
				}
			}
			
			if ($query) {
				return true;
			} else{
				return false;
			}
		}
		

		
	    
	}