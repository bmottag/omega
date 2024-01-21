<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Programming_model extends CI_Model
{


	/**
	 * Add/Edit PROGRAMMING
	 * @since 2/7/2018
	 */
	public function saveProgramming()
	{
		$idUser = $this->session->userdata("id");
		$idProgramming = $this->input->post('hddId');
		//$flagDate = $this->input->post('flag_date');
		$parentId = $this->input->post('hddIdParent');

		$flagDate = ($this->input->post('job_planning') == 1) ? $this->input->post('flag_date') : 1;

		$data = array(
			'fk_id_job' => $this->input->post('jobName'),
			'observation' => $this->input->post('observation'),
			'flag_date' => $flagDate
		);

		if ($flagDate == 2 && $parentId == "") {
			$data['date_programming'] = formatear_fecha($this->input->post('from'));
			$data['date_to'] = formatear_fecha($this->input->post('to'));
			$data['apply_for'] = $this->input->post('apply_for');
		} else {
			$data['date_programming'] = $this->input->post('date');
		}

		//revisar si es para adicionar o editar
		if ($idProgramming == '') {
			$data['fk_id_user'] = $idUser;
			$data['date_issue'] = date("Y-m-d G:i:s");
			$data['state'] = 1;

			$query = $this->db->insert('programming', $data);
			$idProgramming = $this->db->insert_id();
		} else {
			$this->db->where('id_programming', $idProgramming);
			$query = $this->db->update('programming', $data);
		}
		if ($query) {
			return $idProgramming;
		} else {
			return false;
		}
	}

	/**
	 * Add Period Programming
	 * @since 16/10/2023
	 */
	public function savePeriodProgramming($date, $idParent)
	{
		$data = array(
			'fk_id_user' => $this->session->userdata("id"),
			'date_issue' => date("Y-m-d G:i:s"),
			'fk_id_job' => $this->input->post('jobName'),
			'observation' => $this->input->post('observation'),
			'date_programming' => $date,
			'parent_id' => $idParent,
			'apply_for' => $this->input->post('apply_for'),
			'flag_date' => $this->input->post('flag_date'),
			'state' => 1
		);
		$query = $this->db->insert('programming', $data);
		$idProgramming = $this->db->insert_id();

		if ($query) {
			return $idProgramming;
		} else {
			return false;
		}
	}

	/**
	 * Add PROGRAMMING WORKER
	 * @since 16/1/2019
	 */
	public function addProgrammingWorker()
	{
		//add the new workers
		$query = 1;
		if ($workers = $this->input->post('workers')) {
			$tot = count($workers);
			for ($i = 0; $i < $tot; $i++) {
				$data = array(
					'fk_id_programming' => $this->input->post('hddId'),
					'fk_id_programming_user' => $workers[$i],
					'fk_id_hour' => 15, // Se coloca por defecto que ingresen a las 7 am
					'site' => 1 // Se coloca por defecto 1 -> At the yard
				);
				$query = $this->db->insert('programming_worker', $data);
			}
		}
		if ($query) {
			return true;
		} else {
			return false;
		}
	}


	/**
	 * Verify if the project already exist for that date
	 * @author BMOTTAG
	 * @since  15/1/2019
	 */
	public function verifyProject($arrData)
	{
		$this->db->where('fk_id_job', $arrData["idJob"]);
		$this->db->where('date_programming', $arrData["date"]);
		$this->db->where('state !=', 3);

		$query = $this->db->get("programming");

		if ($query->num_rows() >= 1) {
			return true;
		} else {
			return false;
		}
	}

	/**
	 * Cmabia el estado de la programacion
	 * @since 8/7/2018
	 */
	public function deleteProgramming()
	{
		$idProgramming = $this->input->post('identificador');

		$data = array('state' => 3); //estado eliminada

		$this->db->where('id_programming', $idProgramming);
		$query = $this->db->update('programming', $data);

		if ($query) {
			return true;
		} else {
			return false;
		}
	}

	/**
	 * Lista de vehiculos, para asginarlos a los trabajadores en la programacion
	 * @since 16/1/2019
	 */
	public function get_vehicles_inspection()
	{
		$trucks = array();
		$sql = "SELECT id_vehicle, CONCAT(unit_number,' -----> ', description) as unit_description 
						FROM param_vehicle V 
						INNER JOIN param_vehicle_type_2 T ON T.id_type_2 = V.type_level_2 
						WHERE fk_id_company = 1 AND T.link_inspection != 'NA' AND V.id_vehicle NOT IN(41,42,43,44,61,62) AND V.state = 1 AND V.so_blocked = 1
						ORDER BY unit_number";

		$query = $this->db->query($sql);
		if ($query->num_rows() > 0) {
			$i = 0;
			foreach ($query->result() as $row) {
				$trucks[$i]["id_truck"] = $row->id_vehicle;
				$trucks[$i]["unit_number"] = $row->unit_description;
				$i++;
			}
		}
		$this->db->close();
		return $trucks;
	}

	/**
	 * Update worker
	 * @since 16/1/2019
	 */
	public function saveWorker()
	{
		$hddId = $this->input->post('hddId');
		$maquina = '[' . implode(", ", $this->input->post('machine')) . ']';

		$data = array(
			'description' => $this->input->post('description'),
			'fk_id_machine' => $maquina,
			'fk_id_hour' => $this->input->post('hora_inicio'),
			'site' => $this->input->post('site'),
			'safety' => $this->input->post('safety'),
			'creat_wo' => $this->input->post('creat_wo')
		);

		$this->db->where('id_programming_worker', $hddId);
		$query = $this->db->update('programming_worker', $data);

		if ($query) {
			return true;
		} else {
			return false;
		}
	}

	/**
	 * Contar trabajadors para una programacion
	 * @since  17/1/2019
	 */
	public function countWorkers($idProgramming)
	{
		$sql = "SELECT count(id_programming_worker) CONTEO";
		$sql .= " FROM programming_worker P";
		$sql .= " WHERE fk_id_programming = " . $idProgramming;

		$query = $this->db->query($sql);
		$row = $query->row();
		return $row->CONTEO;
	}

	/**
	 * Save one worker
	 * @since 19/1/2019
	 */
	public function saveOneWorkerProgramming()
	{
		$idProgramming = $this->input->post('hddId');

		$data = array(
			'fk_id_programming' => $idProgramming,
			'fk_id_programming_user' => $this->input->post('worker'),
			'fk_id_hour' => 15, // Se coloca por defecto que ingresen a las 7 am
			'site' => 1 // Se coloca por defecto 1 -> At the yard
		);

		$query = $this->db->insert('programming_worker', $data);

		if ($query) {
			return true;
		} else {
			return false;
		}
	}

	/**
	 * Save worker for Flash Planning 
	 * @since 28/12/2022
	 */
	public function saveWorkerFashPlanning($idProgramming, $idHora)
	{
		$machine = '[' . implode(", ", $this->input->post('machine')) . ']';
		$data = array(
			'fk_id_programming' => $idProgramming,
			'fk_id_programming_user' => $this->input->post('worker'),
			'fk_id_machine' => $machine,
			'fk_id_hour' => $idHora,
			'site' => 2, // Se coloca por defecto 2 -> At the Site
			'safety' => 1 // Se coloca por defecto FLHA
		);
		$query = $this->db->insert('programming_worker', $data);

		if ($query) {
			return true;
		} else {
			return false;
		}
	}

	/**
	 * Save child workers for chields
	 * @since 21/10/2023
	 */
	public function saveChildWorkers($idProgramming, $informationWorker)
	{
		$query = 1;
		$tot = count($informationWorker);
		for ($i = 0; $i < $tot; $i++) {
			$data = array(
				'fk_id_programming' => $idProgramming,
				'fk_id_programming_user' => $informationWorker[$i]["fk_id_programming_user"],
				'fk_id_hour' => $informationWorker[$i]["fk_id_hour"],
				'site' => $informationWorker[$i]["site"],
				'description' => $informationWorker[$i]["description"],
				'fk_id_machine' => $informationWorker[$i]["fk_id_machine"],
				'safety' => $informationWorker[$i]["safety"]
			);
			$query = $this->db->insert('programming_worker', $data);
		}

		if ($query) {
			return true;
		} else {
			return false;
		}
	}

	/**
	 * Update worker status
	 * @since 22/10/2023
	 */
	public function updateSMSWorkerStatus($idProgrammingWorker, $smsStatus, $smsSID)
	{
		$data = array(
			'sms_sent' => 1,
			'sms_status' => $smsStatus,
			'sms_sid' => $smsSID
		);

		$this->db->where('id_programming_worker', $idProgrammingWorker);
		$query = $this->db->update('programming_worker', $data);

		if ($query) {
			return true;
		} else {
			return false;
		}
	}

	/**
	 * Add Clone
	 * @since 28/10/2023
	 */
	public function createClone($infoPlanning)
	{
		$data = array(
			'fk_id_user' => $this->session->userdata("id"),
			'date_issue' => date("Y-m-d G:i:s"),
			'fk_id_job' => $infoPlanning[0]["fk_id_job"],
			'observation' => $infoPlanning[0]["observation"],
			'date_programming' => $this->input->post('date'),
			'parent_id' => "",
			'apply_for' => "",
			'flag_date' => "",
			'state' => 1
		);
		$query = $this->db->insert('programming', $data);
		$idProgramming = $this->db->insert_id();

		if ($query) {
			return $idProgramming;
		} else {
			return false;
		}
	}

	/**
	 * Get programming materials info
	 * @since 20/1/2024
	 */
	public function get_programming_materials($arrData)
	{
		$this->db->select();
		$this->db->join('param_material_type M', 'M.id_material = P.fk_id_material', 'INNER');
		if (array_key_exists("idProgramming", $arrData)) {
			$this->db->where('P.fk_id_programming', $arrData["idProgramming"]);
		}
		$this->db->order_by('M.material', 'asc');
		$query = $this->db->get('programming_material P');

		if ($query->num_rows() > 0) {
			return $query->result_array();
		} else {
			return false;
		}
	}
	/**
	 * Add Material
	 * @since 20/1/2024
	 */
	public function saveMaterial()
	{
		$data = array(
			'fk_id_programming' => $this->input->post('hddidProgramming'),
			'fk_id_material' => $this->input->post('material'),
			'quantity' => $this->input->post('quantity'),
			'unit' => $this->input->post('unit'),
			'description' => $this->input->post('description')
		);

		$query = $this->db->insert('programming_material', $data);

		if ($query) {
			return true;
		} else {
			return false;
		}
	}

	/**
	 * Updated Material
	 * @since 20/1/2024
	 */
	public function updatedMaterial()
	{
		$hddId = $this->input->post('hddId');
		$data = array(
			'quantity' => $this->input->post('quantity'),
			'unit' => $this->input->post('unit'),
			'description' => $this->input->post('description')
		);

		$this->db->where('id_programming_material', $hddId);
		$query = $this->db->update('programming_material', $data);

		if ($query) {
			return true;
		} else {
			return false;
		}
	}
}
