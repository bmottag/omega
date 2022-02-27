<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

	class Payroll_model extends CI_Model {

	    function __construct(){        
	        parent::__construct();      
	    }
		
		/**
		 * Add PAYROLL
		 * @since 9/11/2016
		 */
		public function savePayroll() 
		{
				$idUser = $this->session->userdata("id");
				$idOperation =  $this->input->post('hddTask');
				$idJob =  $this->input->post('jobName');
				$task =  $this->security->xss_clean($this->input->post('taskDescription'));
				$task =  addslashes($task);
				$latitude =  $this->input->post('latitud');
				$longitude =  $this->input->post('longitud');
				
				$address =  $this->security->xss_clean($this->input->post('address'));
				$address =  addslashes($address);
								
				$fecha = date("Y-m-d G:i:s");
				
				$sql = "INSERT INTO task";
				$sql.= " (fk_id_user, fk_id_operation, fk_id_job, task_description, start, latitude_start, longitude_start, address_start)";
				$sql.= " VALUES ($idUser, $idOperation, $idJob, '$task', '$fecha', $latitude, $longitude, '$address')";
			
				$query = $this->db->query($sql);

				if ($query) {
					return true;
				} else {
					return false;
				}
		}
		
		/**
		 * Update PAYROLL - signature
		 * @since 11/11/2016
		 */
		public function updateSignature() 
		{
				$idTask =  $this->input->post('idTask');
				$signature =  $this->input->post('output');

				$sql = "UPDATE task";
				$sql.= " SET signature='$signature'";
				$sql.= " WHERE id_task=$idTask";

				$query = $this->db->query($sql);

				if ($query) {
					return true;
				} else {
					return false;
				}
		}

		/**
		 * Update PAYROLL - workin time and workin hours
		 * param $adminUpdate: si no envian es porque viene el usuario registrando el cierre, de lo contrariro es porque el administrador esta actualizando
		 * @since 17/11/2016
		 * @review 2/02/2022
		 */
		public function updateWorkingTimePayroll($fechaStart, $fechaCierre, $adminUpdate = 'x') 
		{
				$dteStart = new DateTime($fechaStart);
				$dteEnd   = new DateTime($fechaCierre);
				
				$dteDiff  = $dteStart->diff($dteEnd);
				$workingTime = $dteDiff->format("%R%a days %H:%I:%S");//days hours:minutes:seconds
			
				//START hours calculation
				$minutes = (strtotime($fechaStart)-strtotime($fechaCierre))/60;
				$minutes = abs($minutes);  
				$minutes = round($minutes);
		
				$hours = $minutes/60;
				$hours = round($hours,2);
				
				$justHours = intval($hours);
				$decimals=$hours-$justHours; 

				//Ajuste de los decimales para redondearlos a .25 / .5 / .75
				if($decimals<0.12){
					$transformation = 0;
				}elseif($decimals>=0.12 && $decimals<0.37){
					$transformation = 0.25;
				}elseif($decimals>=0.37 && $decimals<0.62){
					$transformation = 0.5;
				}elseif($decimals>=0.62 && $decimals<0.87){
					$transformation = 0.75;
				}elseif($decimals>=0.87){
					$transformation = 1;
				}
				$workingHours = $justHours + $transformation;
				$overtimeHours = 0;
				if($workingHours>8){
					$regularHours = 8;
					$overtimeHours = $workingHours - 8;
				}else{
					$regularHours = $workingHours;
				}
				//FINISH hours calculation
				
				$idTask =  $this->input->post('hddIdentificador');
				if($adminUpdate == 'x')
				{
					$idJob =  $this->input->post('jobName');
					$observation =  $this->security->xss_clean($this->input->post('observation'));
					$observation =  addslashes($observation);
					$latitude =  $this->input->post('latitud');
					$longitude =  $this->input->post('longitud');
					
					$address =  $this->security->xss_clean($this->input->post('address'));
					$address =  addslashes($address);
									
					$sql = "UPDATE task";
					$sql.= " SET observation='$observation', finish =  '$fechaCierre', fk_id_job_finish='$idJob', latitude_finish = $latitude, longitude_finish = $longitude, address_finish = '$address', working_time='$workingTime', working_hours =  $workingHours, regular_hours =  $regularHours, overtime_hours =  $overtimeHours";
					$sql.= " WHERE id_task=$idTask";
				}else{
					$sql = "UPDATE task";
					$sql.= " SET working_time='$workingTime', working_hours =  $workingHours, regular_hours =  $regularHours, overtime_hours =  $overtimeHours";
					$sql.= " WHERE id_task=$idTask";		
				}



				$query = $this->db->query($sql);

				if ($query) {
					return true;
				} else {
					return false;
				}
		}		

		/**
		 * Insert PAYROLL
		 * @since 2/02/2022
		 */
		public function insertWorkingTimePayroll($fechaStart, $fechaCierre) 
		{
				$dteStart = new DateTime($fechaStart);
				$dteEnd   = new DateTime($fechaCierre);
				
				$dteDiff  = $dteStart->diff($dteEnd);
				$workingTime = $dteDiff->format("%R%a days %H:%I:%S");//days hours:minutes:seconds
			
				//START hours calculation
				$minutes = (strtotime($fechaStart)-strtotime($fechaCierre))/60;
				$minutes = abs($minutes);  
				$minutes = round($minutes);
		
				$hours = $minutes/60;
				$hours = round($hours,2);
				
				$justHours = intval($hours);
				$decimals=$hours-$justHours; 

				//Ajuste de los decimales para redondearlos a .25 / .5 / .75
				if($decimals<0.12){
					$transformation = 0;
				}elseif($decimals>=0.12 && $decimals<0.37){
					$transformation = 0.25;
				}elseif($decimals>=0.37 && $decimals<0.62){
					$transformation = 0.5;
				}elseif($decimals>=0.62 && $decimals<0.87){
					$transformation = 0.75;
				}elseif($decimals>=0.87){
					$transformation = 1;
				}
				$workingHours = $justHours + $transformation;
				$overtimeHours = 0;
				if($workingHours>8){
					$regularHours = 8;
					$overtimeHours = $workingHours - 8;
				}else{
					$regularHours = $workingHours;
				}
				//FINISH hours calculation
				
				$idUser = $this->session->userdata("id");
				$idTask =  $this->input->post('hddIdentificador');
				$idJob =  $this->input->post('jobName');
				$observation =  $this->security->xss_clean($this->input->post('observation'));
				$observation =  addslashes($observation);
				$latitude =  $this->input->post('latitud');
				$longitude =  $this->input->post('longitud');
				
				$address =  $this->security->xss_clean($this->input->post('address'));
				$address =  addslashes($address);

				$sql = "INSERT INTO task";
				$sql.= " (fk_id_user, fk_id_operation, fk_id_job, task_description, start, latitude_start, longitude_start, address_start,
							observation, finish, fk_id_job_finish, latitude_finish, longitude_finish, address_finish, working_time, working_hours, 
							regular_hours, overtime_hours)";
				$sql.= " VALUES ($idUser, 1, $idJob, '', '$fechaStart', $latitude, $longitude, '$address', '$observation', '$fechaCierre', '$idJob', 
								$latitude, $longitude, '$address', '$workingTime', $workingHours, $regularHours, $overtimeHours)";
								
				$query = $this->db->query($sql);
				$idtask = $this->db->insert_id();

				if ($query) {
					return $idtask;
				} else {
					return false;
				}
		}
		
		/**
		 * Consulta BASICA A UNA TABLA
		 * @since 17/11/2016
		 */
		public function get_taskbyid($id) {
			$this->db->where("id_task", $id);
			$query = $this->db->get("task");

			if ($query->num_rows() >= 1) {
				return $query->row_array();
			} else
				return false;
		}		
		
		/**
		 * Update payroll hour
		 * @since 2/2/2018
		 */
		public function savePayrollHour() 
		{
				$idTask = $this->input->post('hddIdentificador');
				$inicio = $this->input->post('hddInicio');
				$fin = $this->input->post('hddFin');

				$firstObservation =  $this->security->xss_clean($this->input->post('hddObservation'));
				$firstObservation =  addslashes($firstObservation);
				
				$observation =  $this->security->xss_clean($this->input->post('observation'));
				$observation =  addslashes($observation);
				
				$moreInfo = "<strong>Changue hour by SUPER ADMIN.</strong> <br>Before -> Start: " . $inicio . " <br>Before -> Finish: " . $fin;
				$observation = $firstObservation . "<br>********************<br>" . $moreInfo . "<br>" . $observation . "<br>Date: " . date("Y-m-d G:i:s") . "<br>********************";

				$fechaStart = $this->input->post('start_date');
				$horaStart = $this->input->post('start_hour');
				$minStart = $this->input->post('start_min');
				$fechaFinish = $this->input->post('start_date');
				$horaFinish = $this->input->post('finish_hour');
				$minFinish = $this->input->post('finish_min');
				
				$fechaStart = $fechaStart . " " . $horaStart . ":" . $minStart . ":00";
				$fechaFinish = $fechaFinish . " " . $horaFinish . ":" . $minFinish . ":00"; 

				$sql = "UPDATE task";
				$sql.= " SET observation='$observation', finish =  '$fechaFinish', start='$fechaStart'";
				$sql.= " WHERE id_task=$idTask";

				$query = $this->db->query($sql);

				if ($query) {
					return true;
				} else {
					return false;
				}

				//revisar si es para adicionar o editar
				if ($idJobJsoWorker == '') {			
					$data['date_oriented'] = date('Y-m-d');
					$query = $this->db->insert('job_jso_workers', $data);
				} else {
					$this->db->where('id_job_jso_worker', $idJobJsoWorker);
					$query = $this->db->update('job_jso_workers', $data);
				}

				if ($query) {
					return true;
				} else {
					return false;
				}
		}

		/**
		 * Add PERIOD
		 * @since 9/02/2022
		 */
		public function savePeriod($arrData)
		{				
				$period = $arrData["periodoIniNew"] . " - " . $arrData["periodoFinNew"];
				
				$data = array(
					'date_start' => $arrData["periodoIniNew"],
					'date_finish' => $arrData["periodoFinNew"],
					'period' => $period
				);	
				
				$query = $this->db->insert('payroll_period', $data);
				$idPeriod = $this->db->insert_id();

				if ($query) {
					return $idPeriod;
				} else {
					return false;
				}
		}

		/**
		 * Add Weak PERIOD
		 * @since 9/02/2022
		 */
		public function saveWeakPeriod($arrData)
		{				
				$weak1 = $arrData["semana1IniNew"] . " - " . $arrData["semana1FinNew"];
				$weak2 = $arrData["semana2IniNew"] . " - " . $arrData["semana2FinNew"];
				
				$data = array(
					'fk_id_period' => $arrData["idPeriod"],
					'date_weak_start' => $arrData["semana1IniNew"],
					'date_weak_finish' => $arrData["semana1FinNew"],
					'period_weak' => $weak1,
					'weak_number' => 1
				);	
				$query = $this->db->insert('payroll_period_weaks', $data);
				
				$data = array(
					'fk_id_period' => $arrData["idPeriod"],
					'date_weak_start' => $arrData["semana2IniNew"],
					'date_weak_finish' => $arrData["semana2FinNew"],
					'period_weak' => $weak2,
					'weak_number' => 2
				);	
				$query = $this->db->insert('payroll_period_weaks', $data);

				if ($query) {
					return true;
				} else {
					return false;
				}
		}

		/**
		 * Save paystub
		 * @since 21/2/2022
		 */
		public function savePaystub() 
		{			
				$idUser = $this->session->userdata("id");
				$idPaytsub = $this->input->post('hddIdPaytsub');
				$costRegularSalary = $this->input->post('hddCostRegularSalary');
				$costOvertime = $this->input->post('hddCostOvertime');
				$costVacation = $this->input->post('hddCostVacation');
				$totalIncome = $costRegularSalary + $costOvertime;
				$gross_salary = $totalIncome + $costVacation ;
				$er_cpp = $ee_cpp = $this->input->post('ee_cpp');
				$ee_ei = $this->input->post('ee_ei');
				$er_ei = $ee_ei*1.4;
				$tax = $this->input->post('tax');
				$gwl_deductions = $this->input->post('gwl_deductions');
				$ee_total_taxes = $ee_cpp + $ee_ei + $tax;
				$remittance = $ee_cpp + $er_cpp + $ee_ei + $er_ei + $tax;
				$net_pay = $gross_salary - $ee_total_taxes - $gwl_deductions;
				
				$data = array(
					'employee_rate_paystub' => $this->input->post('hddEmployeeRate'),
					'employee_type_paystub' => $this->input->post('hddEmployeeType'),
					'total_worked_hours' => $this->input->post('hddTotalWorkedHours'),
					'total_regular_hours' => $this->input->post('hddRegularHours'),
					'total_overtime_hours' => $this->input->post('hddIdOvertimeHours'),
					'cost_regular_salary' => $costRegularSalary,
					'cost_over_time' => $costOvertime,
					'total_income' => $totalIncome,
					'cost_vacation_regular_salary' => $costVacation,
					'gross_salary' => $gross_salary,
					'ee_cpp' => $ee_cpp,
					'er_cpp' => $er_cpp,
					'ee_ei' => $ee_ei,
					'er_ei' => $er_ei,
					'tax' => $tax,
					'ee_total_taxes' => $ee_total_taxes,
					'gwl_deductions' => $gwl_deductions,
					'remittance' => $remittance,
					'net_pay' => $net_pay
				);

				//revisar si es para adicionar o editar
				if ($idPaytsub == ''){
					$data['paystub_date_issue'] = date('Y-m-d');
					$data['paystub_fk_id_user'] = $idUser;
					$data['fk_id_period'] = $this->input->post('hddIdPeriod');
					$data['fk_id_employee'] = $this->input->post('hddIdUser');
					$query = $this->db->insert('payroll_paystub', $data);
				} else {
					$this->db->where('id_paystub', $idPaytsub);
					$query = $this->db->update('payroll_paystub', $data);
				}		

				if ($query) {
					return true;
				} else {
					return false;
				}
		}

	    
	}