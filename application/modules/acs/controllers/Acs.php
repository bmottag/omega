<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Acs extends CI_Controller
{

	public function __construct()
	{
		parent::__construct();
		$this->load->model("acs_model");
		$this->load->helper('form');
	}

	/**
	 * View info ACS
	 * @since 21/2/2017
	 * @author BMOTTAG
	 */
	public function view_acs($idACS)
	{
		$arrParam = array('idACS' => $idACS);
		$data['acs_info'] = $this->acs_model->get_acs($arrParam);
		$data['acsPersonal'] = $this->acs_model->get_acs_personal($arrParam);
		$data['acsMaterials'] = $this->acs_model->get_acs_materials($arrParam);
		$data['acsReceipt'] = $this->acs_model->get_acs_receipt($arrParam);
		$data['acsEquipment'] = $this->acs_model->get_acs_equipment($arrParam);
		$data['acsOcasional'] = $this->acs_model->get_acs_ocasional($arrParam);

		$data["view"] = 'acs_view';
		$this->load->view("layout", $data);
	}

	/**
	 * Save Info ACS Personal
	 * @since 17/01/2025
	 * @author BMOTTAG
	 */
	public function save_info_acs_personal()
	{
		$records = $this->input->post('records');
		$successCount = 0;
		$errorCount = 0;

		foreach ($records as $record) {
			$dataToSave = [
				'view_pdf'   => isset($record['check_pdf']) ? 1 : 2,
				'hours'      => $record['hours'],
				'rate'       => $record['rate'],
				'value'      => $record['rate'] * $record['hours']
			];

			if ($this->acs_model->saveInfoACS($record['hddId'], $dataToSave, $this->input->post('formType'))) {
				$successCount++;
			} else {
				$errorCount++;
			}
		}

		if ($errorCount === 0) {
			$this->session->set_flashdata('retornoExito', "$successCount records saved successfully!");
		} else {
			$this->session->set_flashdata('retornoError', "$errorCount records failed to save.");
		}
		redirect(base_url('acs/view_acs/' . $this->input->post('hddIdACS')), 'refresh');
	}

	/**
	 * Save Info ACS Material
	 * @since 17/01/2025
	 * @author BMOTTAG
	 */
	public function save_info_acs_materials()
	{
		$records = $this->input->post('records');
		$successCount = 0;
		$errorCount = 0;

		foreach ($records as $record) {
			$dataToSave = [
				'view_pdf'   => isset($record['check_pdf']) ? 1 : 2,
				'quantity'   => $record['quantity'],
				'rate'      => $record['rate'],
				'markup'      => $record['markup'],
				'value'      => $record['rate'] * $record['quantity'] * ($record['markup']  + 100) / 100
			];

			if ($this->acs_model->saveInfoACS($record['hddId'], $dataToSave, $this->input->post('formType'))) {
				$successCount++;
			} else {
				$errorCount++;
			}
		}

		if ($errorCount === 0) {
			$this->session->set_flashdata('retornoExito', "$successCount records saved successfully!");
		} else {
			$this->session->set_flashdata('retornoError', "$errorCount records failed to save.");
		}
		redirect(base_url('acs/view_acs/' . $this->input->post('hddIdACS')), 'refresh');
	}

	/**
	 * Save Info ACS Receipt
	 * @since 18/01/2025
	 * @author BMOTTAG
	 */
	public function save_info_acs_receipt()
	{
		$records = $this->input->post('records');
		$successCount = 0;
		$errorCount = 0;

		foreach ($records as $record) {
			$price = $record['price'] / 1.05; //quitar el 5% de GST
			$value = $price + ($price * $record['markup']/ 100); //valor con el markup

			$dataToSave = [
				'view_pdf'   => isset($record['check_pdf']) ? 1 : 2,
				'price'      => $record['price'],
				'markup'      => $record['markup'],
				'value'      => $value
			];

			if ($this->acs_model->saveInfoACS($record['hddId'], $dataToSave, $this->input->post('formType'))) {
				$successCount++;
			} else {
				$errorCount++;
			}
		}

		if ($errorCount === 0) {
			$this->session->set_flashdata('retornoExito', "$successCount records saved successfully!");
		} else {
			$this->session->set_flashdata('retornoError', "$errorCount records failed to save.");
		}
		redirect(base_url('acs/view_acs/' . $this->input->post('hddIdACS')), 'refresh');
	}

	/**
	 * Save Info ACS Receipt
	 * @since 18/01/2025
	 * @author BMOTTAG
	 */
	public function save_info_acs_equipment()
	{
		$records = $this->input->post('records');
		$successCount = 0;
		$errorCount = 0;

		foreach ($records as $record) {
			$dataToSave = [
				'view_pdf'   => isset($record['check_pdf']) ? 1 : 2,
				'fk_id_company'      => 1,
				'quantity'   => $record['quantity'],
				'rate'     	 => $record['rate'],
				'value'      => $record['hours'] * $record['quantity'] * $record['rate']
			];

			if ($this->acs_model->saveInfoACS($record['hddId'], $dataToSave, $this->input->post('formType'))) {
				$successCount++;
			} else {
				$errorCount++;
			}
		}

		if ($errorCount === 0) {
			$this->session->set_flashdata('retornoExito', "$successCount records saved successfully!");
		} else {
			$this->session->set_flashdata('retornoError', "$errorCount records failed to save.");
		}
		redirect(base_url('acs/view_acs/' . $this->input->post('hddIdACS')), 'refresh');
	}

	/**
	 * Save Info ACS Ocasional
	 * @since 18/01/2025
	 * @author BMOTTAG
	 */
	public function save_info_acs_ocasional()
	{
		$records = $this->input->post('records');
		$successCount = 0;
		$errorCount = 0;

		foreach ($records as $record) {
			$dataToSave = [
				'view_pdf'   => isset($record['check_pdf']) ? 1 : 2,
				'quantity'   => $record['quantity'],
				'hours'   => $record['hours'],
				'rate'      => $record['rate'],
				'markup'      => $record['markup'],
				'value'      => $record['quantity'] * $record['hours'] * $record['rate'] * ($record['markup'] + 100) / 100
			];

			if ($this->acs_model->saveInfoACS($record['hddId'], $dataToSave, $this->input->post('formType'))) {
				$successCount++;
			} else {
				$errorCount++;
			}
		}

		if ($errorCount === 0) {
			$this->session->set_flashdata('retornoExito', "$successCount records saved successfully!");
		} else {
			$this->session->set_flashdata('retornoError', "$errorCount records failed to save.");
		}
		redirect(base_url('acs/view_acs/' . $this->input->post('hddIdACS')), 'refresh');
	}

	/**
	 * Delete workorder record
	 * @param varchar $tabla: nombre de la tabla de la cual se va a borrar
	 * @param int $idValue: id que se va a borrar
	 * @param int $idACS: llave  primaria de ACS
	 */
	public function deleteACSRecord($tabla, $idValue, $idACS, $vista)
	{
		if (empty($tabla) || empty($idValue) || empty($idACS)) {
			show_error('ERROR!!! - You are in the wrong place.');
		}
		$arrParam = array(
			"table" => "acs_" . $tabla,
			"primaryKey" => "id_acs_"  . $tabla,
			"id" => $idValue
		);
		$this->load->model("general_model");
		if ($this->general_model->deleteRecord($arrParam)) 
		{
			$this->session->set_flashdata('retornoExito', 'You have deleted one record from <strong>' . strtoupper($tabla) . '</strong> table.');
		} else {
			$this->session->set_flashdata('retornoError', '<strong>Error!!!</strong> Ask for help');
		}
		redirect(base_url('acs/' . $vista . '/' . $idACS), 'refresh');
	}

	/**
	 * Cargo modal- formulario de captura personal - ACS
	 * @since 18/01/2025
	 */
	public function cargarModalPersonalACS()
	{
		header("Content-Type: text/plain; charset=utf-8"); //Para evitar problemas de acentos

		$data["idACS"] = $this->input->post("idACS");

		//workers list
		$this->load->model("general_model");
		$arrParam = array("state" => 1);
		$data['workersList'] = $this->general_model->get_user($arrParam); //workers list


		//employee type list
		$arrParam = array(
			"table" => "param_employee_type",
			"order" => "employee_type",
			"id" => "x"
		);
		$data['employeeTypeList'] = $this->general_model->get_basic_search($arrParam); //employee type list

		$this->load->view("modal_personal_acs", $data);
	}

	/**
	 * Cargo modal- formulario de captura Material - ACS
	 * @since 13/1/2017
	 */
	public function cargarModalMaterialsACS()
	{
		header("Content-Type: text/plain; charset=utf-8"); //Para evitar problemas de acentos

		$idACS = $this->input->post("idACS");
		//como se coloca un ID diferente para que no entre en conflicto con los otros modales, toca sacar el ID
		$porciones = explode("-", $idACS);
		$data["idACS"] = $porciones[1];

		//workers list
		$this->load->model("general_model");
		$arrParam = array(
			"table" => "param_material_type",
			"order" => "material",
			"id" => "x"
		);
		$data['materialList'] = $this->general_model->get_basic_search($arrParam); //worker´s list

		$this->load->view("modal_material_acs", $data);
	}

	/**
	 * Cargo modal- formulario de captura Equipment - ACS
	 * @since 25/1/2017
	 */
	public function cargarModalEquipmentACS()
	{
		header("Content-Type: text/plain; charset=utf-8"); //Para evitar problemas de acentos

		$idACS = $this->input->post("idACS");
		//como se coloca un ID diferente para que no entre en conflicto con los otros modales, toca sacar el ID
		$porciones = explode("-", $idACS);
		$data["idACS"] = $porciones[1];

		$this->load->model("general_model");
		//buscar la lista de tipo de equipmentType
		$arrParam = array(
			"table" => "param_vehicle_type_2",
			"order" => "type_2",
			"column" => "show_workorder",
			"id" => 1
		);
		$data['equipmentType'] = $this->general_model->get_basic_search($arrParam); //equipmentType list

		//workers list
		$arrParam = array("state" => 1);
		$data['workersList'] = $this->general_model->get_user($arrParam); //workers list


		$this->load->view("modal_equipment_acs", $data);
	}

	/**
	 * Cargo modal- formulario de captura Ocasional - ACS
	 * @since 20/2/2017
	 */
	public function cargarModalOcasionalACS()
	{
		header("Content-Type: text/plain; charset=utf-8"); //Para evitar problemas de acentos

		$idACS = $this->input->post("idACS");
		//como se coloca un ID diferente para que no entre en conflicto con los otros modales, toca sacar el ID
		$porciones = explode("-", $idACS);

		if (count($porciones) > 1) {
			$data["idACS"] = $porciones[1];

			//workers list
			$this->load->model("general_model");
			$arrParam = array(
				"table" => "param_company",
				"order" => "company_name",
				"column" => "company_type",
				"id" => 2
			);
			$data['companyList'] = $this->general_model->get_basic_search($arrParam); //company list

			$this->load->view("modal_ocasional_acs", $data);
		}
	}

	/**
	 * Cargo modal- formulario de captura Invoice - ACS
	 * @since 18/01/2025
	 */
	public function cargarModalReceiptsACS()
	{
		header("Content-Type: text/plain; charset=utf-8"); //Para evitar problemas de acentos

		$idACS = $this->input->post("idACS");
		//como se coloca un ID diferente para que no entre en conflicto con los otros modales, toca sacar el ID
		$porciones = explode("-", $idACS);
		$data["idACS"] = $porciones[1];

		$this->load->view("modal_receipt_acs", $data);
	}

	/**
	 * Save formularios
	 * @param varchar $modalToUse: indica que funcion del modelo se debe usar
	 * @since 13/1/2017
	 * @author BMOTTAG
	 */
	public function save($modalToUse)
	{
		header('Content-Type: application/json');
		$data = array();

		$data["idRecord"] = $this->input->post('hddIdACS');

		if ($this->acs_model->$modalToUse()) {
			$data["result"] = true;
			$this->session->set_flashdata('retornoExito', "You have added a new record!!");
		} else {
			$data["result"] = "error";
			$this->session->set_flashdata('retornoError', '<strong>Error!!!</strong> Ask for help');
		}
		echo json_encode($data);
	}

	/**
	 * Generate ACS Report in PDF
	 * @param int $idACS
	 * @since 29/01/2025
	 * @author BMOTTAG
	 */
	public function reportPDF($idACS)
	{
		$this->load->library('Pdf');

		// create new PDF document
		$pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);

		$arrParam = array("idACS" => $idACS);
		$data['info'] = $this->acs_model->get_acs($arrParam);

		$fecha = date('F j, Y', strtotime($data['info'][0]['date']));

		// set document information
		$pdf->SetCreator(PDF_CREATOR);
		$pdf->SetAuthor('VCI');
		$pdf->SetTitle('Accounting Control Sheet (ACS)');
		$pdf->SetSubject('TCPDF Tutorial');

		// set default header data
		$pdf->SetHeaderData(PDF_HEADER_LOGO, PDF_HEADER_LOGO_WIDTH, 'Force Account Summary', 'W.O. #: ' . $data['info'][0]['fk_id_workorder']. "\nDate: " . $fecha, array(0, 64, 255), array(0, 64, 128));

		// set header and footer fonts
		$pdf->setHeaderFont(array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));
		$pdf->setFooterFont(array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));

		// set default monospaced font
		$pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);

		$pdf->setPrintFooter(false); //no imprime el pie ni la linea 

		// set margins
		$pdf->SetMargins(PDF_MARGIN_LEFT, PDF_MARGIN_TOP, PDF_MARGIN_RIGHT);
		$pdf->SetHeaderMargin(PDF_MARGIN_HEADER);
		$pdf->SetFooterMargin(PDF_MARGIN_FOOTER);

		// set auto page breaks
		$pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);

		// set image scale factor
		$pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);

		// set some language-dependent strings (optional)
		if (@file_exists(dirname(__FILE__) . '/lang/eng.php')) {
			require_once(dirname(__FILE__) . '/lang/eng.php');
			$pdf->setLanguageArray($l);
		}

		// ---------------------------------------------------------

		// set font
		$pdf->SetFont('dejavusans', '', 8);

		// writeHTML($html, $ln=true, $fill=false, $reseth=false, $cell=false, $align='')
		// writeHTMLCell($w, $h, $x, $y, $html='', $border=0, $ln=0, $fill=0, $reseth=true, $align='', $autopadding=true)

		$arrParam['view_pdf'] = True;
		$data['acsPersonal'] = $this->acs_model->get_acs_personal($arrParam);
		$data['acsMaterials'] = $this->acs_model->get_acs_materials($arrParam);
		$data['acsReceipt'] = $this->acs_model->get_acs_receipt($arrParam);
		$data['acsEquipment'] = $this->acs_model->get_acs_equipment($arrParam);
		$data['acsOcasional'] = $this->acs_model->get_acs_ocasional($arrParam);
		// - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
		// Print a table

		// add a page
		//$pdf->AddPage('L', 'A4');
		$pdf->AddPage();

		$html = $this->load->view("reporte_acs", $data, true);

		// output the HTML content
		$pdf->writeHTML($html, true, false, true, false, '');

		// Print some HTML Cells

		// reset pointer to the last page
		$pdf->lastPage();


		//Close and output PDF document
		$pdf->Output('acs_' . $idACS . '.pdf', 'I');

		//============================================================+
		// END OF FILE
		//============================================================+

	}

}