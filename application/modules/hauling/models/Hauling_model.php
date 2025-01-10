<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Hauling_model extends CI_Model
{


	/**
	 * Add/Edit hauling
	 * @since 16/12/2016
	 */
	public function saveHauling()
	{
		$idUser = $this->session->userdata("id");
		$idHauling = $this->input->post('hddId');

		$hourIn = $this->input->post('hourIn');
		$hourOut = $this->input->post('hourOut');

		$hourIn = $hourIn < 10 ? "0" . $hourIn : $hourIn;
		$hourOut = $hourOut < 10 ? "0" . $hourOut : $hourOut;

		$timeIn = $hourIn . ":" . $this->input->post('minIn');
		$timeOut = $hourOut . ":" . $this->input->post('minOut');

		$data = array(
			'fk_id_user' => $idUser,
			'fk_id_company' => $this->input->post('company'),
			'fk_id_truck' => $this->input->post('truck'),
			'fk_id_truck_type' => $this->input->post('truckType'),
			'fk_id_material' => $this->input->post('materialType'),
			'fk_id_site_from' => $this->input->post('fromSite'),
			'fk_id_site_to' => $this->input->post('toSite') ?? 0,
			'plate' => $this->input->post('plate'),
			'time_in' => $timeIn,
			'time_out' => $timeOut,
			'fk_id_payment' => $this->input->post('payment'),
			'comments' => $this->input->post('comments')
		);


		//solo usuarios SUPER_ADMIN pueden ingresar la fecha de la inspeccion
		$userRol = $this->session->rol;
		$dateIssue = $this->input->post('date');

		//revisar si es para adicionar o editar
		if ($idHauling == '') {
			$data['date_issue'] = date("Y-m-d");
			if ($userRol == 99 && $dateIssue != "") {
				$data['date_issue'] = $dateIssue;
			}

			$query = $this->db->insert('hauling', $data);
			$idHauling = $this->db->insert_id();
		} else {
			if ($userRol == 99 && $dateIssue != "") {
				$data['date_issue'] = $dateIssue;
			}

			$this->db->where('id_hauling', $idHauling);
			$query = $this->db->update('hauling', $data);
		}
		if ($query) {
			return $idHauling;
		} else {
			return false;
		}
	}

	/**
	 * Trucks´list by company
	 * @since 12/12/2016
	 */
	public function get_trucks_by_id($idCompany)
	{
		$trucks = array();
		$sql = "SELECT id_vehicle, CONCAT(unit_number,' -----> ', description) as unit_description 
					FROM param_vehicle 
					WHERE fk_id_company = $idCompany
					AND type_level_2 = 4
					AND state = 1
					ORDER BY unit_number";
		//pr($sql); exit;
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
	 * Obtiene datos de hauling
	 * @param int $idHaulig: ID hauling
	 * @author BMOTTAG
	 * @since  23/1/2017
	 */
	public function get_hauling_byId($idHaulig)
	{
		$this->db->select('H.*, C.company_name, C.contact, C.email, C.company_type, V.unit_number, T.truck_type, M.material, P.payment, J.job_description from, L.job_description to');
		$this->db->from('hauling H');
		$this->db->where('id_hauling', $idHaulig);
		$this->db->join('param_company C', 'C.id_company = H.fk_id_company', 'INNER');
		$this->db->join('param_vehicle V', 'V.id_vehicle = H.fk_id_truck', 'LEFT');
		$this->db->join('param_truck_type T', 'T.id_truck_type = H.fk_id_truck_type', 'INNER');
		$this->db->join('param_material_type M', 'M.id_material = H.fk_id_material', 'INNER');
		$this->db->join('param_jobs J', 'J.id_job = H.fk_id_site_from', 'INNER');
		$this->db->join('param_jobs L', 'L.id_job = H.fk_id_site_from', 'INNER');
		$this->db->join('param_payment P', 'P.id_payment = H.fk_id_payment', 'INNER');


		$query = $this->db->get();

		if ($query->num_rows() > 0) {
			return $query->row_array();
		} else {
			return false;
		}
	}
}
