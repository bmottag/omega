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
				$address =  $this->input->post('address');
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
		 * Update PAYROLL - finish and observation files
		 * @since 11/11/2016
		 */
		public function updatePayroll() 
		{
				$idTask =  $this->input->post('hddIdentificador');
				$idJob =  $this->input->post('jobName');
				$observation =  $this->security->xss_clean($this->input->post('observation'));
				$observation =  addslashes($observation);
				$latitude =  $this->input->post('latitud');
				$longitude =  $this->input->post('longitud');
				$address =  $this->input->post('address');
				$fecha = date("Y-m-d G:i:s");

				$sql = "UPDATE task";
				$sql.= " SET observation='$observation', finish =  '$fecha', fk_id_job_finish='$idJob', latitude_finish = $latitude, longitude_finish = $longitude, address_finish = '$address'";
				$sql.= " WHERE id_task=$idTask";

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
		 * @since 17/11/2016
		 */
		public function updateWorkingTimePayroll($info) 
		{
				$dteStart = new DateTime($info['start']);
				$dteEnd   = new DateTime($info['finish']);
				
				$dteDiff  = $dteStart->diff($dteEnd);
				$workingTime = $dteDiff->format("%R%a days %H:%I:%S");//days hours:minutes:seconds
			
				//START hours calculation
				$minutes = (strtotime($info['finish'])-strtotime($info['start']))/60;
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
				//FINISH hours calculation
				
				$idTask =  $this->input->post('hddIdentificador');

				$sql = "UPDATE task";
				$sql.= " SET working_time='$workingTime', working_hours =  $workingHours";
				$sql.= " WHERE id_task=$idTask";

				$query = $this->db->query($sql);

				if ($query) {
					return true;
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
				
				$observation =  $this->security->xss_clean($this->input->post('observation'));
				$observation =  addslashes($observation);
				
				$moreInfo = "<strong>Changue hour by SUPER ADMIN.</strong> <br>Before -> Start: " . $inicio . " <br>Before -> Finish: " . $fin;
				$observation = $this->input->post('hddObservation') . "<br>********************<br>" . $moreInfo . "<br>" . $observation . "<br>Date: " . date("Y-m-d G:i:s") . "<br>********************";

				$fechaStart = $this->input->post('start_date');
				$horaStart = $this->input->post('start_hour');
				$minStart = $this->input->post('start_min');
				$fechaFinish = $this->input->post('finish_date');
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

		
		
		
		
		
		
		
		

		
		
		
		
		
		
	    
	}