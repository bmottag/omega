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

		
		

		
	    
	}