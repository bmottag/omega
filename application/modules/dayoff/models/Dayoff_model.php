<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

	class Dayoff_model extends CI_Model {
		
		/**
		 * Get dayoff info
		 * @since 7/12/2016
		 * @review 6/2/2017
		 */
		public function get_day_off($arrData) 
		{		
				$idUser = $this->session->userdata("id");
				$year = date('Y');
				$firstDay = date('Y-m-d', mktime(0,0,0, 1, 1, $year));//primer dia del año actual
				 
				$beforeYesterday = date('Y-m-d',mktime(0, 0, 0, date("m")  , date("d")-2, date("Y")));
				
				$this->db->select("D.*, CONCAT(first_name, ' ', last_name) name");
				$this->db->join('user U', 'U.id_user = D.fk_id_user', 'INNER');
				if (array_key_exists("idEmployee", $arrData)) {
					$this->db->where('U.id_user', $idUser );//filtro por empleado
				}
				if (array_key_exists("state", $arrData)) {
					$this->db->where('D.state', $arrData["state"] );//filtro por estado
					
					if($arrData["state"]>1){
							$this->db->where('D.date_dayoff >=', $beforeYesterday);//filtro para los aprobados que la fecha de solicitud del permiso ya paso
					}
					
				}
				if (array_key_exists("idDayoff", $arrData)) {
					$this->db->where('D.id_dayoff', $arrData["idDayoff"] );//filtro por idDayoff
				}
				$this->db->where('D.date_issue >=', $firstDay);//filtro para el año actual
				$this->db->order_by('D.id_dayoff', 'desc');
				$query = $this->db->get('dayoff D');

				if ($query->num_rows() > 0) {
					return $query->result_array();
				} else {
					return false;
				}
		}
		
		/**
		 * Add SAFETY HAZARD
		 * @since 7/12/2016
		 */
		public function add_dayoff() 
		{
				$idUser = $this->session->userdata("id");
				$type =  $this->input->post('type');
				$observation =  $this->security->xss_clean($this->input->post('observation'));
				$observation =  addslashes($observation);

				$date =  $this->input->post('date');
				$state =  1;//new
				$fecha = date("Y-m-d G:i:s");

				$sql = "INSERT INTO dayoff";
				$sql.= " (fk_id_user, id_type_dayoff, date_issue, date_dayoff, observation, state)";
				$sql.= " VALUES ($idUser, $type, '$fecha', '$date', '$observation', $state)";
		
				$query = $this->db->query($sql);
				
				$idDayoff = $this->db->insert_id();
				
				if ($query) {
					return $idDayoff;
				} else {
					return false;
				}
		}
		
	    /**
	     * Update dayoff´s state
	     * @author BMOTTAG
	     * @since  8/12/2016
	     */
	    public function update_dayoff()
		{
				$idDayoff = $this->input->post('hddIdParam');
				$idUser = $this->session->userdata("id");
				$state = $this->input->post("state");
				$observation = $this->input->post('observation');
				$fecha = date("Y-m-d G:i:s");
								
				//actualizo fecha del registo
				$idSafety = $this->db->insert_id();
				$sql = "UPDATE dayoff";
				$sql.= " SET fk_id_boss = $idUser, state = $state, admin_observation = '$observation', date_update = '$fecha'";
				$sql.= " WHERE id_dayoff = $idDayoff";
				$query = $this->db->query($sql);

				if ($query) {
					return true;
				} else {
					return false;
				}
	    }

		

		
		
		
		
		
	    
	}