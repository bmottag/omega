<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Claims extends CI_Controller {
	
    public function __construct() {
        parent::__construct();
        $this->load->model("claims_model");
        $this->load->helper('form');
    }
	
	/**
	 * Form Workorders
     * @since 3/2/2021
     * @author BMOTTAG
	 */
	public function index()
	{		
			$arrParam = array();
			$data['claimsInfo'] = $this->claims_model->get_claims($arrParam);

			//job list - (active items)
			$this->load->model("general_model");
			$arrParam = array(
				"state" => 1,
				"withLIC" => true
			);
			$data['jobs'] = $this->general_model->get_job($arrParam);

			if(!$_POST)
			{
				$data['tituloListado'] = 'LIST OF LAST 50 RECORDS';
				//busco los ultimos 50 REGISTROS
				$arrParam = array('limit' => 50);
			}elseif($this->input->post('id_job_search') || $this->input->post('state') || $this->input->post('claimNumber'))
			{
				$data['tituloListado'] = 'LIST OF CLAIMS THAT MATCHES YOUR SEARCH';
										
				$arrParam = array(
					"idJob" => $this->input->post('id_job_search'),
					"state" => $this->input->post('state'),
					"claimNumber" => $this->input->post('claimNumber')
				);		
			}
			$data['claimsInfo'] = $this->claims_model->get_claims($arrParam);

			$data["view"] ='claims';
			$this->load->view("layout_calendar", $data);
	}

    /**
     * Cargo modal - formulario CLAIMS
     * @since 3/2/2021
     */
    public function cargarModalClaim() 
	{
			header("Content-Type: text/plain; charset=utf-8"); //Para evitar problemas de acentos
			
			$data['information'] = FALSE;
			$idClaim = $this->input->post("idClaim");
			
			//job list - (active items)
			$this->load->model("general_model");
			$arrParam = array(
				"state" => 1,
				"withLIC" => true
			);
			$data['jobs'] = $this->general_model->get_job($arrParam);
							
			$this->load->view("claims_modal", $data);
    }

	/**
	 * Guardar claim
	 * @since 3/2/2021
     * @author BMOTTAG
	 */
	public function guardar_claims()
	{			
			header('Content-Type: application/json');
			$data = array();
			
			$idClaimInicial = $this->input->post('hddId');
			$msj = $idClaimInicial ? "You have updated the Claim, continue uploading the information." : "You have added a Claim, continue uploading the information.";

			$resultSearch = false;
			if ($idClaimInicial == '') {
				$arrParam = array(
					"idJob" => $this->input->post('id_job'),
					"claimNumberSearch" => $this->input->post('claimNumber')
				);
				$resultSearch = $this->claims_model->get_claims($arrParam);
			}
	
			if ($resultSearch) {
				$data["result"] = "error";
				$data["mensaje"] = " Error. Duplicate entry: This claim number already exists for the selected job.";
				$this->session->set_flashdata('retornoError', '<strong>Error!!!</strong> Duplicate entry: This claim number already exists for the selected job.');
			} else {
				if ($idClaim = $this->claims_model->guardarClaim()) 
				{
					//guardo el primer estado del claim
					if(!$idClaimInicial){
						$arrParam = array(
							"idClaim" => $idClaim,
							"message" => "New Claim.",
							"state" => 1
						);					
						$this->claims_model->add_claim_state($arrParam);
					}

					$data["idRecord"] = $idClaim;
					$data["result"] = true;		
					$this->session->set_flashdata('retornoExito', '<strong>Right!</strong> ' . $msj);
				} else {
					$data["result"] = "error";
					$this->session->set_flashdata('retornoError', '<strong>Error!!!</strong> Ask for help');
				}
			}
			
			echo json_encode($data);
    }

	/**
	 * Form Upload APU to claim
     * @since 12/05/2025
     * @author BMOTTAG
	 */
	public function upload_apu($idClaim = 'x')
	{
			//Claim info
			$arrParam = array('idClaim' => $idClaim);
			$data['claimsInfo'] = $this->claims_model->get_claims($arrParam);

			//Claim State history
			$data['claimsHistory'] = $this->claims_model->get_claims_history($arrParam);
											
			$this->load->model("general_model");
			//$data['WOList'] = $this->general_model->get_workorder_info($arrParam);	
			$arrParam = array("idJob" => $data['claimsInfo'][0]['fk_id_job']);
			$data['chapterList'] = $this->general_model->get_chapter_list($arrParam);
			
			$data["view"] = 'form_upload_info_claim';
			$this->load->view("layout_calendar", $data);
	}

	/**
	 * Update Claim info
     * @since 12/05/2025
     * @author BMOTTAG
	 */
	public function update_claim()
	{
		header('Content-Type: application/json');

		$idClaim = $this->input->post('hddIdClaim');
		$records = $this->input->post('records');
		$successCount = 0;
		$errorCount = 0;

		// Elimina los registros anteriores con ese idClaim
		$this->db->where('fk_id_claim', $idClaim);
		$this->db->delete('claim_apus');

		foreach ($records as $record) {

			if($record['quantity'] || $record['cost']){
				$dataToSave = [
					'fk_id_claim'   => $idClaim,
					'fk_id_job_detail' => $record['id_job_detail'],
					'quantity'   => $record['quantity'],
					'cost'      => $record['quantity'] ? $record['unit_price'] * $record['quantity'] : $record['cost']
				];
	
				if ($this->claims_model->saveInfoAPU($dataToSave)) {
					$successCount++;
				} else {
					$errorCount++;
				}
			}

		}
		echo json_encode([
			"status" => $errorCount === 0 ? "success" : "error",
			"message" => $errorCount === 0 ? "$successCount records saved successfully!" : "$errorCount records failed to save."
		]);
	}

	/**
	 * Form Add WO to Claim
	 * Muestre lista de WO por trabajo y los que estan asignados al CLAIM
     * @since 3/2/2021
     * @author BMOTTAG
	 */
	public function add_wo($idJob, $idClaim)
	{
			if (empty($idJob) || empty($idClaim)) {
				show_error('ERROR!!! - You are in the wrong place.');
			}
			
			 //list de WO para un JOB que no estan asignadas
			$this->load->model("general_model");
			$arrParam = array(
				'jobId' => $idJob,
				'idClaim' => 0
			);
			$data['WOList'] = $this->general_model->get_workorder_info($arrParam);	

			$arrParam = array(
				"table" => "param_jobs",
				"order" => "job_description",
				"column" => "id_job",
				"id" => $idJob
			);
			$data['jobInfo'] = $this->general_model->get_basic_search($arrParam);

			$data["idJob"] = $idJob;
			$data["idClaim"] = $idClaim;
			$data["view"] = 'form_add_wo';
			$this->load->view("layout_calendar", $data);
	}

	/**
	 * Asignar WO al claim
     * @since 3/2/2021
     * @author BMOTTAG
	 */
	public function save_claim_wo()
	{	
			header('Content-Type: application/json');
			$data = array();
			$data['idRecord'] = $this->input->post('hddId');
			$wo = $this->input->post('wo');
			if($wo){
				if ($this->claims_model->saveClaimWO()) {
					$data["result"] = true;
					$this->session->set_flashdata('retornoExito', "Work orders assigned to the claim!!");
				} else {
					$data["result"] = "error";
					$this->session->set_flashdata('retornoError', '<strong>Error!!!</strong> Ask for help');
				}
			}else{
					$data["result"] = "error";
					$data["mensaje"] = " You have to select a W.O.";
					$this->session->set_flashdata('retornoError', 'You have to select a W.O.');
			}
			echo json_encode($data);
	}

	/**
	 * Delete WO de Claims
     * @since 4/2/2021
	 */
	public function delete_wo_from_claim()
	{			
			header('Content-Type: application/json');
			$data = array();
			$this->load->model("general_model");

			$idCompuesto = $this->input->post("identificador");
			$porciones = explode('-', $idCompuesto);

			$idWO = $porciones[0];
			$data['idRecord'] = $porciones[1];
			
			$arrParam = array(
				"table" => "workorder",
				"primaryKey" => "id_workorder",
				"id" => $idWO,
				"column" => "fk_id_claim",
				"value" => 0
			);
			if ($this->general_model->updateRecord($arrParam)) 
			{				
				$data["result"] = true;
				$this->session->set_flashdata('retornoExito', 'You have delete the W.O. from the claim.');
			} else {
				$data["result"] = "error";
				$data["mensaje"] = "Error!!! Contactarse con el Administrador.";
				$this->session->set_flashdata('retornoError', '<strong>Error!!!</strong> Ask for help');
			}				

			echo json_encode($data);
    }

	/**
     * Cargo modal - formulario Estado Claim
     * @since 5/02/2021
     * @author BMOTTAG
     */
    public function cargarModalClaimState() 
	{
			header("Content-Type: text/plain; charset=utf-8");
			$data['idClaim'] = $this->input->post("idClaim");

			$this->load->view("claim_state_modal", $data);
    }

	/**
	 * Guardar orden de trabajo estado
	 * @since 29/1/2021
     * @author BMOTTAG
	 */
	public function save_claim_state()
	{			
			header('Content-Type: application/json');
			$data = array();
			
			$idClaim = $data['idRecord'] = $this->input->post("hddIdClaim");
				
			$msj = "You have updated the information!";

			$claimState = $this->input->post("state");

			$arrParam = array(
				"idClaim" => $idClaim,
				"message" => $this->input->post("message"),
				"state" => $claimState
			);		
			if ($this->claims_model->add_claim_state($arrParam)) 
			{
				//actualizar estado actual en CLAIM
				$this->claims_model->update_claim($arrParam);

				$WOList = FALSE;
				//busco listado de WO del claim, si es 2. Send to Client o 6. Final Payment
				if($claimState == 2 || $claimState == 6)
				{
					if($claimState == 2){
						$stateMSJ = 'Send to Client';
					}else{
						$stateMSJ = 'Closed';
					}
					$msj .= ' And Word Order state changed to <strong>' . $stateMSJ . '</strong>.';
					$this->load->model("general_model");
					$arrParam = array('idClaim' => $idClaim);
					$WOList = $this->general_model->get_workorder_info($arrParam);	
					//si el estado es igual a 2. Send to Client o 6. Final Payment, entonces actualizo todos los estados de las WO automaticamente
					if($WOList){
						$this->claims_model->updateWOStateFromClaimChange($WOList);
					}
				} 

				$data["result"] = true;		
				$this->session->set_flashdata('retornoExito', '<strong>	Right!</strong> ' . $msj);
			} else {
				$data["result"] = "error";
				$this->session->set_flashdata('retornoError', '<strong>Error!</strong> Ask for help');
			}
		
			echo json_encode($data);
    }

	/**
	 * Next claim number
	 * @since 13/05/2025
	 * @author BMOTTAG
	 */
	public function nextClaimNumber()
	{
		$idJob = $this->input->post('job');
		$this->load->model("general_model");
	
		$arrParam = array('idJob' => $idJob, 'limit' => 1);
		$claim = $this->claims_model->get_claims($arrParam);
	
		$nextClaimNumber = $claim ? ($claim[0]['claim_number'] + 1) : 1;
		$lastObservation = $claim ? ($claim[0]['observation_claim']) : false;
	
		echo json_encode(['next' => $nextClaimNumber, 'lastObservation' => $lastObservation]);
	}

	/**
	 * Claim history
     * @since 20/05/2025
     * @author BMOTTAG
	 */
	public function claim_history($idClaim = 'x')
	{
			//Claim info
			$arrParam = array('idClaim' => $idClaim);
			$data['claimsInfo'] = $this->claims_model->get_claims($arrParam);

			//Claim State history
			$data['claimsHistory'] = $this->claims_model->get_claims_history($arrParam);
											
			$this->load->model("general_model");
			//$data['WOList'] = $this->general_model->get_workorder_info($arrParam);	
			$arrParam = array("idJob" => $data['claimsInfo'][0]['fk_id_job']);
			$data['chapterList'] = $this->general_model->get_chapter_list($arrParam);

			$arrParam = array('idJob' => $data['claimsInfo'][0]['fk_id_job'], 'order' => 'asc');
			$data['allClaims'] = $this->claims_model->get_claims($arrParam);

			$data["view"] = 'claim_history';
			$this->load->view("layout_calendar", $data);
	}

	
	
}