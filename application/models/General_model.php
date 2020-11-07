<?php
if (!defined('BASEPATH'))
    exit('No direct script access allowed');

/**
 * Clase para consultas generales a una tabla
 */
class General_model extends CI_Model {

    /**
     * Consulta BASICA A UNA TABLA
     * @param $TABLA: nombre de la tabla
     * @param $ORDEN: orden por el que se quiere organizar los datos
     * @param $COLUMNA: nombre de la columna en la tabla para realizar un filtro (NO ES OBLIGATORIO)
     * @param $VALOR: valor de la columna para realizar un filtro (NO ES OBLIGATORIO)
     * @since 8/11/2016
     */
    public function get_basic_search($arrData) {
        if ($arrData["id"] != 'x')
            $this->db->where($arrData["column"], $arrData["id"]);
        $this->db->order_by($arrData["order"], "ASC");
        $query = $this->db->get($arrData["table"]);

        if ($query->num_rows() >= 1) {
            return $query->result_array();
        } else
            return false;
    }
	
    /**
     * Task´s list
     * Modules: Dashboard - Payroll
     * @since 10/11/2016
     */
    public function get_task($arrData) 
	{
        $this->db->select('T.*, id_user, first_name, last_name, log_user, J.job_description job_start, H.job_description job_finish, O.task');
        $this->db->join('user U', 'U.id_user = T.fk_id_user', 'INNER');
		$this->db->join('param_jobs J', 'J.id_job = T.fk_id_job', 'INNER');
		$this->db->join('param_jobs H', 'H.id_job = T.fk_id_job_finish', 'LEFT');
		$this->db->join('param_operation O', 'O.id_operation = T.fk_id_operation', 'INNER');
		
        if (array_key_exists("idEmployee", $arrData)) {
            $this->db->where('U.id_user', $arrData["idEmployee"]);
        }
		
		$this->db->order_by('id_task', 'desc');
		$query = $this->db->get('task T', $arrData["limit"]);

        if ($query->num_rows() > 0) {
            return $query->result_array();
        } else {
            return false;
        }
    }
	
	/**
	 * Contar registros de un usuario para el año actual
	 * si es administrador cuenta todo
	 * @author BMOTTAG
	 * @since  14/11/2016
	 */
	public function countTask($arrDatos)
	{
		$userRol = $this->session->userdata("rol");
		$idUser = $this->session->userdata("id");
		$idOperation = $arrDatos["task"];

		$year = date('Y');
		$firstDay = date('Y-m-d', mktime(0,0,0, 1, 1, $year));

		$sql = "SELECT count(id_task) CONTEO";
		$sql.= " FROM task";

		if (array_key_exists("task", $arrDatos)) {
			$sql.= " WHERE fk_id_operation = $idOperation";
		}
		
		if($userRol == 7){ //If it is a normal user, just show the records of the user session
			$sql.= " AND fk_id_user = $idUser";
		}
		$sql.= " AND start >= '$firstDay'";

        $query = $this->db->query($sql);
        $row = $query->row();
        return $row->CONTEO;
	}
	
    /**
     * Safety´s list
     * Modules: Dashboard
     * @since 6/12/2016
	 * @review 9/3/2017
     */
    public function get_safety($arrData) 
	{
		$this->db->select("S.*, CONCAT(first_name, ' ', last_name) name, J.job_description");
        $this->db->join('user U', 'U.id_user = S.fk_id_user', 'INNER');
		$this->db->join('param_jobs J', 'J.id_job = S.fk_id_job', 'INNER');
		
		if (array_key_exists("idJob", $arrData)) {
			$this->db->where('S.fk_id_job', $arrData["idJob"]);
		}
		if (array_key_exists("fecha", $arrData)) {
			$fecha = $arrData["fecha"] . '%';
			$this->db->where('S.date LIKE', $fecha);
		}		
				
		$this->db->order_by('id_safety', 'desc');
		$query = $this->db->get('safety S', $arrData["limit"]);

        if ($query->num_rows() > 0) {
            return $query->result_array();
        } else {
            return false;
        }
    }
	
    /**
     * Hauling list
     * Modules: Dashboard 
     * @since 13/1/2017
     */
    public function get_hauling($arrData) 
	{		
		$this->db->select("H.*, CONCAT(first_name, ' ', last_name) name, C.company_name, V.unit_number, T.truck_type, J.job_description site_from, Z.job_description site_to, M.material, P.payment");
		$this->db->join('user U', 'U.id_user = H.fk_id_user', 'INNER');
		$this->db->join('param_company C', 'C.id_company = H.fk_id_company', 'INNER');
		$this->db->join('param_vehicle V', 'V.id_vehicle = H.fk_id_truck', 'LEFT');
		$this->db->join('param_truck_type T', 'T.id_truck_type = H.fk_id_truck_type', 'INNER');
		$this->db->join('param_jobs J', 'J.id_job = H.fk_id_site_from', 'INNER');
		$this->db->join('param_jobs Z', 'Z.id_job = H.fk_id_site_to', 'INNER');
		$this->db->join('param_material_type M', 'M.id_material = H.fk_id_material', 'INNER');
		$this->db->join('param_payment P', 'P.id_payment = H.fk_id_payment', 'INNER');
		
		if (array_key_exists("idEmployee", $arrData)) {
			$this->db->where('U.id_user', $arrData["idEmployee"]);
		}
		
		$this->db->order_by('H.id_hauling', 'desc');
		$query = $this->db->get('hauling H', $arrData["limit"]);

		if ($query->num_rows() > 0) {
			return $query->result_array();
		} else {
			return false;
		}			
    }
	
    /**
     * Daily inspection list
     * Modules: Dashboard 
     * @since 14/1/2017
     */
    public function get_daily_inspection($arrData) 
	{
		$this->db->select("I.*, CONCAT(first_name, ' ', last_name) name, V.*");
		$this->db->join('user U', 'U.id_user = I.fk_id_user', 'INNER');
		$this->db->join('param_vehicle V', 'V.id_vehicle = I.fk_id_vehicle', 'INNER');
		
		if (array_key_exists("idEmployee", $arrData)) {
			$this->db->where('U.id_user', $arrData["idEmployee"]);
		}		
		
		$this->db->order_by('I.date_issue', 'desc');
		$query = $this->db->get('inspection_daily I', $arrData["limit"]);

		if ($query->num_rows() > 0) {
			return $query->result_array();
		} else {
			return false;
		}		
    }
	
    /**
     * Heavy inspection list
     * Modules: Dashboard 
     * @since 14/1/2017
     */
    public function get_heavy_inspection($arrData) 
	{
		$this->db->select("I.*, CONCAT(first_name, ' ', last_name) name, V.*");
		$this->db->join('user U', 'U.id_user = I.fk_id_user', 'INNER');
		$this->db->join('param_vehicle V', 'V.id_vehicle = I.fk_id_vehicle', 'INNER');
		
		if (array_key_exists("idEmployee", $arrData)) {
			$this->db->where('U.id_user', $arrData["idEmployee"]);
		}
		
		$this->db->order_by('I.date_issue', 'desc');
		$query = $this->db->get('inspection_heavy I', $arrData["limit"]);

		if ($query->num_rows() > 0) {
			return $query->result_array();
		} else {
			return false;
		}
    }
	
    /**
     * Special inspection list
     * Modules: Dashboard 
     * @since 8/5/2017
     */
    public function get_special_inspection_generator($arrData) 
	{
		$this->db->select("I.*, CONCAT(first_name, ' ', last_name) name, V.*");
		$this->db->join('user U', 'U.id_user = I.fk_id_user', 'INNER');
		$this->db->join('param_vehicle V', 'V.id_vehicle = I.fk_id_vehicle', 'INNER');
		
		if (array_key_exists("idEmployee", $arrData)) {
			$this->db->where('U.id_user', $arrData["idEmployee"]);
		}
		
		$this->db->order_by('I.date_issue', 'desc');
		$query = $this->db->get('inspection_generator I', $arrData["limit"]);

		if ($query->num_rows() > 0) {
			return $query->result_array();
		} else {
			return false;
		}
    }
	
    /**
     * Special inspection list
     * Modules: Dashboard 
     * @since 8/5/2017
     */
    public function get_special_inspection_hydrovac($arrData) 
	{
		$this->db->select("I.*, CONCAT(first_name, ' ', last_name) name, V.*");
		$this->db->join('user U', 'U.id_user = I.fk_id_user', 'INNER');
		$this->db->join('param_vehicle V', 'V.id_vehicle = I.fk_id_vehicle', 'INNER');
		
		if (array_key_exists("idEmployee", $arrData)) {
			$this->db->where('U.id_user', $arrData["idEmployee"]);
		}
		
		$this->db->order_by('I.date_issue', 'desc');
		$query = $this->db->get('inspection_hydrovac I', $arrData["limit"]);

		if ($query->num_rows() > 0) {
			return $query->result_array();
		} else {
			return false;
		}
    }
	
    /**
     * Special inspection list
     * Modules: Dashboard 
     * @since 8/5/2017
     */
    public function get_special_inspection_sweeper($arrData) 
	{
		$this->db->select("I.*, CONCAT(first_name, ' ', last_name) name, V.*");
		$this->db->join('user U', 'U.id_user = I.fk_id_user', 'INNER');
		$this->db->join('param_vehicle V', 'V.id_vehicle = I.fk_id_vehicle', 'INNER');
		
		if (array_key_exists("idEmployee", $arrData)) {
			$this->db->where('U.id_user', $arrData["idEmployee"]);
		}
		
		$this->db->order_by('I.date_issue', 'desc');
		$query = $this->db->get('inspection_sweeper I', $arrData["limit"]);

		if ($query->num_rows() > 0) {
			return $query->result_array();
		} else {
			return false;
		}
    }
	
    /**
     * Special inspection list
     * Modules: Dashboard 
     * @since 27/6/2017
     */
    public function get_special_inspection_water_truck($arrData) 
	{
		$this->db->select("I.*, CONCAT(first_name, ' ', last_name) name, V.*");
		$this->db->join('user U', 'U.id_user = I.fk_id_user', 'INNER');
		$this->db->join('param_vehicle V', 'V.id_vehicle = I.fk_id_vehicle', 'INNER');
		
		if (array_key_exists("idEmployee", $arrData)) {
			$this->db->where('U.id_user', $arrData["idEmployee"]);
		}
		
		$this->db->order_by('I.date_issue', 'desc');
		$query = $this->db->get('inspection_watertruck I', $arrData["limit"]);

		if ($query->num_rows() > 0) {
			return $query->result_array();
		} else {
			return false;
		}
    }
	
	/**
	 * Update field in a table
	 * @since 11/12/2016
	 */
	public function updateRecord($arrDatos) {
		$data = array(
			$arrDatos ["column"] => $arrDatos ["value"]
		);
		$this->db->where($arrDatos ["primaryKey"], $arrDatos ["id"]);
		$query = $this->db->update($arrDatos ["table"], $data);
		if ($query) {
			return true;
		} else {
			return false;
		}
	}
	
	/**
	 * Delete Record
	 * @since 5/12/2016
	 */
	public function deleteRecord($arrDatos) 
	{
		$query = $this->db->delete($arrDatos ["table"], array($arrDatos ["primaryKey"] => $arrDatos ["id"]));
		if ($query) {
			return true;
		} else {
			return false;
		}
	}
	
	/**
	 * Get vehicle list -> Se usa en el Login y en Inspection
	 * Param varchar $encryption -> dato que viene del QR code
	 * Param varchar $idVehicle -> identificador del vehiculo
	 * @since 3/3/2016
	 */
	public function get_vehicle_by($arrData) 
	{		
			$this->db->select();
			$this->db->join('param_vehicle_type_2 T', 'T.id_type_2 = V.type_level_2', 'INNER');
			if (array_key_exists("encryption", $arrData)) {
				$this->db->where('V.encryption', $arrData["encryption"]);
			}
			if (array_key_exists("idVehicle", $arrData)) {
				$this->db->where('V.id_vehicle', $arrData["idVehicle"]);
			}
			if (array_key_exists("vehicleState", $arrData)) {
				$this->db->where('V.state', $arrData["vehicleState"]);
			}
			if (array_key_exists("vinNumber", $arrData)) {
				$this->db->like('V.unit_number', $arrData["vinNumber"]); 
			}			
			
			$query = $this->db->get('param_vehicle V');

			if ($query->num_rows() > 0) {
				return $query->result_array();
			} else {
				return false;
			}
	}
		
	/**
	 * Get job hazard info
	 * @since 27/11/2017
	 */
	public function get_job_hazards($idJob) 
	{		
			$this->db->select();
			$this->db->join('param_hazard PH', 'PH.id_hazard = H.fk_id_hazard', 'INNER');
			$this->db->join('param_hazard_activity PA', 'PA.id_hazard_activity = PH.fk_id_hazard_activity', 'INNER');
			$this->db->join('param_hazard_priority PP', 'PP.id_priority = PH.fk_id_priority', 'INNER');
			$this->db->where('H.fk_id_job', $idJob); 
			$this->db->order_by('PA.hazard_activity, PH.hazard_description', 'asc');
			$query = $this->db->get('job_hazards H');

			if ($query->num_rows() > 0) {
				return $query->result_array();
			} else {
				return false;
			}
	}
	
    /**
     * Lista de enlaces
     * Modules: MENU
     * @since 27/4/2018
     */
    public function get_enlaces($arrData) 
	{		
		if (array_key_exists("idEnlace", $arrData)) {
			$this->db->where('id_enlace', $arrData["idEnlace"]);
		}
		if (array_key_exists("tipoEnlace", $arrData)) {
			$this->db->where('tipo_enlace', $arrData["tipoEnlace"]);
		}
		if (array_key_exists("estadoEnlace", $arrData)) {
			$this->db->where('enlace_estado', $arrData["estadoEnlace"]);
		}
		
		$this->db->order_by('order', 'asc');
		$query = $this->db->get('enlaces');

		if ($query->num_rows() > 0) {
			return $query->result_array();
		} else {
			return false;
		}
    }
	
		/**
		 * Lista de programacion
		 * @since 15/1/2018
		 */
		public function get_programming($arrData) 
		{
			$year = date('Y');
			$firstDay = date('Y-m-d', mktime(0,0,0, 1, 1, $year));
			
			$this->db->select("P.*, X.id_job, X.job_description, U.id_user, CONCAT(U.first_name, ' ', U.last_name) name");
			$this->db->join('user U', 'U.id_user = P.fk_id_user', 'INNER');
			$this->db->join('param_jobs X', 'X.id_job = P.fk_id_job', 'INNER');
			
			if (array_key_exists("idUser", $arrData)) {
				$this->db->where('P.fk_id_user', $arrData["idUser"]);
			}
			if (array_key_exists("idProgramming", $arrData)) {
				$this->db->where('P.id_programming', $arrData["idProgramming"]);
			}
			if (array_key_exists("fecha", $arrData)) {
				$this->db->where('P.date_programming', $arrData["fecha"]);
			}
			if (array_key_exists("estado", $arrData)) {
				if($arrData["estado"] == "ACTIVAS"){
					$this->db->where('P.state !=', 3);
				}else{
					$this->db->where('P.state', $arrData["estado"]);
				}
				
			}
			
			$this->db->where('P.date_issue >=', $firstDay); //se filtran por registros mayores al primer dia del año
							
			$this->db->order_by("P.date_programming DESC"); 
			$query = $this->db->get("programming P");

			if ($query->num_rows() >= 1) {
				return $query->result_array();
			} else
				return false;
		}
		
		/**
		 * Lista trabajadores para una programacion
		 * @since 15/1/2019
		 */
		public function get_programming_workers($arrData) 
		{
			$this->db->select("U.movil, CONCAT(first_name, ' ', last_name) name, P.*, CONCAT(V.unit_number,' -----> ', V.description) as unit_description, H.hora, H.formato_24");
			if (array_key_exists("idUser", $arrData)) {
				$this->db->where('P.fk_id_programming_user', $arrData["idUser"]);
			}
			if (array_key_exists("idProgramming", $arrData)) {
				$this->db->where('P.fk_id_programming', $arrData["idProgramming"]);
			}
			if (array_key_exists("machine", $arrData)) {
				$this->db->where('P.fk_id_machine is NOT NULL');
				$this->db->where('P.fk_id_machine != 0');
			}
			if (array_key_exists("safety", $arrData)) {
				$this->db->where('P.safety', $arrData["safety"]);
			}
			
			$this->db->join('user U', 'U.id_user = P.fk_id_programming_user', 'INNER');
			$this->db->join('param_vehicle V', 'V.id_vehicle = P.fk_id_machine', 'LEFT');
			$this->db->join('param_horas H', 'H.id_hora = P.fk_id_hour', 'LEFT');
							
			$this->db->order_by("U.first_name, U.last_name ASC"); 
			$query = $this->db->get("programming_worker P");

			if ($query->num_rows() >= 1) {
				return $query->result_array();
			} else
				return false;
		}
		
		/**
		 * Lista de inspeccions para maquinas asignadas en una programacion
		 * @since 15/1/2019
		 */
		public function get_programming_inspecciones($arrData) 
		{			
			$this->db->select();			
			$this->db->where('fk_id_machine', $arrData["maquina"]);
			$this->db->where('date_inspection', $arrData["fecha"]);
							
			$query = $this->db->get("inspection_total");

			if ($query->num_rows() >= 1) {
				return $query->result_array();
			} else
				return false;
		}
		
		/**
		 * Lista de horas
		 * @since 18/1/2019
		 */
		public function get_horas() 
		{
			$this->db->order_by("id_hora", "ASC");
			$query = $this->db->get("param_horas");

			if ($query->num_rows() >= 1) {
				return $query->result_array();
			} else
				return false;
		}		
		
		/**
		 * tool_box list
		 * para año vigente
		 * @since 24/10/2017
		 */
		public function get_tool_box($arrDatos) 
		{
				$year = date('Y');
				$firstDay = date('Y-m-d', mktime(0,0,0, 1, 1, $year));//para filtrar solo los registros del año actual
				
				$this->db->select('T.*, CONCAT(U.first_name, " " , U.last_name) name, J.id_job, J.job_description');
				$this->db->join('param_jobs J', 'J.id_job = T.fk_id_job', 'INNER');
				$this->db->join('user U', 'U.id_user = T.fk_id_user', 'INNER');
				if (array_key_exists("idJob", $arrDatos)) {
					$this->db->where('fk_id_job', $arrDatos["idJob"]);
				}
				if (array_key_exists("fecha", $arrDatos)) {
					$this->db->where('date_tool_box', $arrDatos["fecha"]);
				}
				if (array_key_exists("idToolBox", $arrDatos)) {
					$this->db->where('id_tool_box', $arrDatos["idToolBox"]);
				}
				
				//$this->db->where('T.date_tool_box >=', $firstDay);
				
				$this->db->order_by('id_tool_box', 'asc');
				$query = $this->db->get('tool_box T');

				if ($query->num_rows() > 0) {
					return $query->result_array();
				} else {
					return false;
				}
		}
		
		/**
		 * confined space entry permit list
		 * @since 13/1/2020
		 */
		public function get_confined_space($arrDatos) 
		{				
				$this->db->select('C.*, CONCAT(U.first_name, " " , U.last_name) name, J.id_job, J.job_description, CONCAT(X.first_name, " " , X.last_name) user_authorization, CONCAT(Z.first_name, " " , Z.last_name) user_cancellation');
				$this->db->join('param_jobs J', 'J.id_job = C.fk_id_job', 'INNER');
				$this->db->join('user U', 'U.id_user = C.fk_id_user', 'INNER');
				$this->db->join('user X', 'X.id_user = C.fk_id_user_authorization', 'INNER');
				$this->db->join('user Z', 'Z.id_user = C.fk_id_user_cancellation', 'INNER');

				if (array_key_exists("idJob", $arrDatos)) {
					$this->db->where('fk_id_job', $arrDatos["idJob"]);
				}

				if (array_key_exists("idConfined", $arrDatos)) {
					$this->db->where('id_job_confined', $arrDatos["idConfined"]);
				}
								
				$this->db->order_by('id_job_confined', 'asc');
				$query = $this->db->get('job_confined C');

				if ($query->num_rows() > 0) {
					return $query->result_array();
				} else {
					return false;
				}
		}
		
		/**
		 * re-testing
		 * @since 2/2/2020
		 */
		public function get_confined_re_testing($arrDatos) 
		{				
				$this->db->select();

				if (array_key_exists("idRetesting", $arrDatos)) {
					$this->db->where('id_job_confined_re_testing', $arrDatos["idRetesting"]);
				}

				if (array_key_exists("idConfined", $arrDatos)) {
					$this->db->where('fk_id_job_confined', $arrDatos["idConfined"]);
				}
								
				$this->db->order_by('id_job_confined_re_testing', 'asc');
				$query = $this->db->get('job_confined_re_testing');

				if ($query->num_rows() > 0) {
					return $query->result_array();
				} else {
					return false;
				}
		}
		
		/**
		 * Maintenance Check list
		 * @since 13/3/2020
		 */
		public function get_maintenance_check() 
		{
			$this->db->select('M.*, T.*, V.*, CONCAT(U.first_name, " " , U.last_name) name');
			$this->db->join('maintenance M', 'M.id_maintenance = C.fk_id_maintenance', 'INNER');
			$this->db->join('maintenance_type T', 'T.id_maintenance_type = M.fk_id_maintenance_type', 'INNER');
			$this->db->join('param_vehicle V', 'V.id_vehicle = M.fk_id_vehicle', 'INNER');
			$this->db->join('user U', 'U.id_user = M.fk_revised_by_user', 'INNER');
						
			$this->db->order_by('M.id_maintenance', 'desc');
			$query = $this->db->get('maintenance_check C');

			if ($query->num_rows() > 0) {
				return $query->result_array();
			} else {
				return false;
			}
		}

		/**
		 * Stock list
		 * @since 22/3/2020
		 */
		public function get_stock($arrDatos) 
		{
			$this->db->select();
			$this->db->where('quantity >', 0);
			if (array_key_exists("idStock", $arrDatos)) {
				$this->db->where('id_stock', $arrDatos["idStock"]);
			}
			$this->db->order_by('stock_description');
			$query = $this->db->get('stock');

			if ($query->num_rows() > 0) {
				return $query->result_array();
			} else {
				return false;
			}
		}
		
		/**
		 * Lista de menu
		 * Modules: MENU
		 * @since 30/3/2020
		 */
		public function get_menu($arrData) 
		{		
			if (array_key_exists("idMenu", $arrData)) {
				$this->db->where('id_menu', $arrData["idMenu"]);
			}
			if (array_key_exists("menuType", $arrData)) {
				$this->db->where('menu_type', $arrData["menuType"]);
			}
			if (array_key_exists("menuState", $arrData)) {
				$this->db->where('menu_state', $arrData["menuState"]);
			}
			if (array_key_exists("columnOrder", $arrData)) {
				$this->db->order_by($arrData["columnOrder"], 'asc');
			}else{
				$this->db->order_by('menu_order', 'asc');
			}
			
			$query = $this->db->get('param_menu');

			if ($query->num_rows() > 0) {
				return $query->result_array();
			} else {
				return false;
			}
		}

		/**
		 * Lista de roles
		 * Modules: ROL
		 * @since 30/3/2020
		 */
		public function get_roles($arrData) 
		{		
			if (array_key_exists("filtro", $arrData)) {
				$this->db->where('id_rol !=', 99);
			}
			if (array_key_exists("idRol", $arrData)) {
				$this->db->where('id_rol', $arrData["idRol"]);
			}
			
			$this->db->order_by('rol_name', 'asc');
			$query = $this->db->get('param_rol');

			if ($query->num_rows() > 0) {
				return $query->result_array();
			} else {
				return false;
			}
		}
		
		/**
		 * User list
		 * @since 30/3/2020
		 */
		public function get_user($arrData) 
		{			
			$this->db->select();
			$this->db->join('param_rol R', 'R.id_rol = U.perfil', 'INNER');
			if (array_key_exists("state", $arrData)) {
				$this->db->where('U.state', $arrData["state"]);
			}
			
			//list without inactive users
			if (array_key_exists("filtroState", $arrData)) {
				$this->db->where('U.state !=', 2);
			}

			$this->db->order_by("first_name, last_name", "ASC");
			$query = $this->db->get("user U");

			if ($query->num_rows() >= 1) {
				return $query->result_array();
			} else
				return false;
		}
		
		/**
		 * Lista de enlaces
		 * Modules: MENU
		 * @since 31/3/2020
		 */
		public function get_links($arrData) 
		{		
			$this->db->select();
			$this->db->join('param_menu M', 'M.id_menu = L.fk_id_menu', 'INNER');
			
			if (array_key_exists("idMenu", $arrData)) {
				$this->db->where('fk_id_menu', $arrData["idMenu"]);
			}
			if (array_key_exists("idLink", $arrData)) {
				$this->db->where('id_link', $arrData["idLink"]);
			}
			if (array_key_exists("linkType", $arrData)) {
				$this->db->where('link_type', $arrData["linkType"]);
			}			
			if (array_key_exists("linkState", $arrData)) {
				$this->db->where('link_state', $arrData["linkState"]);
			}
			
			$this->db->order_by('M.menu_order, L.order', 'asc');
			$query = $this->db->get('param_menu_links L');

			if ($query->num_rows() > 0) {
				return $query->result_array();
			} else {
				return false;
			}
		}
		
		/**
		 * Lista de permisos
		 * Modules: MENU
		 * @since 31/3/2020
		 */
		public function get_role_access($arrData) 
		{		
			$this->db->select('P.id_permiso, P.fk_id_menu, P.fk_id_link, P.fk_id_rol, M.menu_name, M.menu_order, M.menu_type, L.link_name, L.link_url, L.order, L.link_icon, L.link_type, R.rol_name, R.estilos');
			$this->db->join('param_menu M', 'M.id_menu = P.fk_id_menu', 'INNER');
			$this->db->join('param_menu_links L', 'L.id_link = P.fk_id_link', 'LEFT');
			$this->db->join('param_rol R', 'R.id_rol = P.fk_id_rol', 'INNER');
			
			if (array_key_exists("idPermiso", $arrData)) {
				$this->db->where('id_permiso', $arrData["idPermiso"]);
			}
			if (array_key_exists("idMenu", $arrData)) {
				$this->db->where('P.fk_id_menu', $arrData["idMenu"]);
			}
			if (array_key_exists("idLink", $arrData)) {
				$this->db->where('P.fk_id_link', $arrData["idLink"]);
			}
			if (array_key_exists("idRole", $arrData)) {
				$this->db->where('P.fk_id_rol', $arrData["idRole"]);
			}
			if (array_key_exists("menuType", $arrData)) {
				$this->db->where('M.menu_type', $arrData["menuType"]);
			}
			if (array_key_exists("linkState", $arrData)) {
				$this->db->where('L.link_state', $arrData["linkState"]);
			}
			if (array_key_exists("menuURL", $arrData)) {
				$this->db->where('M.menu_url', $arrData["menuURL"]);
			}
			if (array_key_exists("linkURL", $arrData)) {
				$this->db->where('L.link_url', $arrData["linkURL"]);
			}
			
			$this->db->order_by('M.menu_order, L.order', 'asc');
			$query = $this->db->get('param_menu_permisos P');

			if ($query->num_rows() > 0) {
				return $query->result_array();
			} else {
				return false;
			}
		}
		
		/**
		 * menu list for a role
		 * Modules: MENU
		 * @since 2/4/2020
		 */
		public function get_role_menu($arrData) 
		{		
			$this->db->select();
			$this->db->join('param_menu M', 'M.id_menu = P.fk_id_menu', 'INNER');

			if (array_key_exists("idRole", $arrData)) {
				$this->db->where('P.fk_id_rol', $arrData["idRole"]);
			}
			if (array_key_exists("menuType", $arrData)) {
				$this->db->where('M.menu_type', $arrData["menuType"]);
			}
			if (array_key_exists("menuState", $arrData)) {
				$this->db->where('M.menu_state', $arrData["menuState"]);
			}
						
			$this->db->group_by("P.fk_id_menu"); 
			$this->db->order_by('M.menu_order', 'asc');
			$query = $this->db->get('param_menu_permisos P');

			if ($query->num_rows() > 0) {
				return $query->result_array();
			} else {
				return false;
			}
		}
		
		/**
		 * Get job hazard info
		 * @since 27/11/2017
		 */
		public function get_job_employee_type_unit_price($idJob) 
		{		
				$this->db->select();
				$this->db->join('param_employee_type PE', 'PE.id_employee_type = JE.fk_id_employee_type ', 'INNER');
				$this->db->where('JE.fk_id_job', $idJob); 
				$this->db->order_by('PE.employee_type', 'asc');
				$query = $this->db->get('job_employee_type_price JE');

				if ($query->num_rows() > 0) {
					return $query->result_array();
				} else {
					return false;
				}
		}
		
		/**
		 * Get equipment list
		 * Param int $companyType -> 1: VCI; 2: Subcontractor
		 * Param int $vehicleType -> 1: Pickup; 2: Construction Equipment; 3: Trucks; 4: Special Equipment; 99: Otros
		 * @since 6/11/2020
		 */
		public function get_equipment_info_by($arrData) 
		{		
				$this->db->select();
				$this->db->join('param_vehicle_type_2 T', 'T.id_type_2 = A.type_level_2', 'INNER');
				
				if (array_key_exists("idVehicle", $arrData)) {
					$this->db->where('A.id_vehicle', $arrData["idVehicle"]);
				}
				if (array_key_exists("vehicleState", $arrData)) {
					$this->db->where('A.state', $arrData["vehicleState"]);
				}

				$this->db->order_by('T.inspection_type, A.unit_number', 'asc');
				$query = $this->db->get('param_vehicle A');

				if ($query->num_rows() > 0) {
					return $query->result_array();
				} else {
					return false;
				}
		}


}