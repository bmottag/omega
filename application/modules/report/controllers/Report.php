<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Report extends CI_Controller {
	
    public function __construct() {
        parent::__construct();
		$this->load->model("report_model");
		$this->load->library('PHPExcel.php');
    }
	
	/**
	 * Search
     * @since 24/11/2016
     * @author BMOTTAG
	 */
    public function payrollSearch() 
	{
			$this->load->view("layout", $data);
    }
	
	/**
	 * Search by daterange safety reports
     * @since 6/01/2017
     * @author BMOTTAG
	 */
    public function searchByDateRange($modulo) 
	{
			if (empty($modulo) ) {
				show_error('ERROR!!! - You are in the wrong place.');
			}
			
			$data['workersList'] = FALSE;//lista para filtrar e el payroll report de ADMIN
			$data['companyList'] = FALSE;//lista para filtrar en el hauling report
			$data['materialList'] = FALSE;//lista para filtrar en el hauling report
			$data['jobList'] = FALSE;//lista para filtrar en work order report
			$data['vehicleList'] = FALSE;//lista para filtrar en inspection report
			$data['trailerList'] = FALSE;//lista para filtrar en inspection report
			$data['truckList'] = FALSE;//lista para filtrar en Hauling

			switch ($modulo) {
				case 'payroll':
					$data["titulo"] = "<i class='fa fa-book fa-fw'></i> PAYROLL REPORT";
					break;
				case 'payrollByAdmin':
					$data["titulo"] = "<i class='fa fa-book fa-fw'></i> PAYROLL REPORT";
					//workers list
					$this->load->model("general_model");
					$arrParam = array(
						"table" => "user",
						"order" => "first_name, last_name",
						"id" => "x"
					);
					$data['workersList'] = $this->general_model->get_basic_search($arrParam);//worker´s list
					break;
				case 'safety':
					//job list
					$this->load->model("general_model");
					$arrParam = array(
						"table" => "param_jobs",
						"order" => "job_description",
						"column" => "state",
						"id" => 1
					);
					$data['jobList'] = $this->general_model->get_basic_search($arrParam);//job list
					$data["titulo"] = "<i class='fa fa-life-saver fa-fw'></i> FLHA REPORT";
					break;
				case 'hauling':
					$data["titulo"] = "<i class='fa fa-truck fa-fw'></i> HAULING REPORT";
					$this->load->model("general_model");
					
					//trucklist
					$data['truckList'] = $this->report_model->get_trucks();
					
					//workers list
					$arrParam = array(
						"table" => "user",
						"order" => "first_name, last_name",
						"id" => "x"
					);
					$data['workersList'] = $this->general_model->get_basic_search($arrParam);//worker´s list
					
					//job list
					$arrParam = array(
						"table" => "param_jobs",
						"order" => "job_description",
						"column" => "state",
						"id" => 1
					);
					$data['jobList'] = $this->general_model->get_basic_search($arrParam);//job list
					
					//company list
					$arrParam = array(
						"table" => "param_company",
						"order" => "company_name",
						"id" => "x"
					);
					$data['companyList'] = $this->general_model->get_basic_search($arrParam);//company list

					//material list
					$arrParam = array(
						"table" => "param_material_type",
						"order" => "material",
						"id" => "x"
					);
					$data['materialList'] = $this->general_model->get_basic_search($arrParam);//material list
					break;
				case 'dailyInspection':
					//workers list
					$this->load->model("general_model");
					$arrParam = array(
						"table" => "user",
						"order" => "first_name, last_name",
						"id" => "x"
					);
					$data['workersList'] = $this->general_model->get_basic_search($arrParam);//worker´s list
					
					$arrParam["tipo"] = "daily";
					$data['vehicleList'] = $this->report_model->get_vehicle_by_type($arrParam);//vehicle's list
					$arrParam["tipo"] = "trailer";
					$data['trailerList'] = $this->report_model->get_vehicle_by_type($arrParam);//vehicle's list
					
					$data["titulo"] = "<i class='fa fa-search fa-fw'></i> PICKUPS & TRUCKS INSPECTION REPORT";
					break;
				case 'heavyInspection':
					//workers list
					$this->load->model("general_model");
					$arrParam = array(
						"table" => "user",
						"order" => "first_name, last_name",
						"id" => "x"
					);
					$data['workersList'] = $this->general_model->get_basic_search($arrParam);//worker´s list
					
					$arrParam["tipo"] = "heavy";
					$data['vehicleList'] = $this->report_model->get_vehicle_by_type($arrParam);//vehicle's list
					$data["titulo"] = "<i class='fa fa-search fa-fw'></i> CONTRUCTION EQUIPMENT INSPECTION REPORT";
					break;
				case 'specialInspection':
					//workers list
					$this->load->model("general_model");
					$arrParam = array(
						"table" => "user",
						"order" => "first_name, last_name",
						"id" => "x"
					);
					$data['workersList'] = $this->general_model->get_basic_search($arrParam);//worker´s list
					
					$arrParam["tipo"] = "special";
					$data['vehicleList'] = $this->report_model->get_vehicle_by_type($arrParam);//vehicle's list
					$data["titulo"] = "<i class='fa fa-search fa-fw'></i> SPECIAL EQUIPMENT INSPECTION REPORT";
					break;
				case 'workorder':
					//job list
					$this->load->model("general_model");
					$arrParam = array(
						"table" => "param_jobs",
						"order" => "job_description",
						"column" => "state",
						"id" => 1
					);
					$data['jobList'] = $this->general_model->get_basic_search($arrParam);//job list
					$data["titulo"] = "<i class='fa fa-money fa-fw'></i> WORK ORDER REPORT";
					break;
			}
			
			$data["view"] = "form_search";
			
			//Si envian los datos del filtro entonces lo direcciono a la lista respectiva con los datos de la consulta
			if($this->input->post('from')){
				$from =  $this->input->post('from');
				$to =  $this->input->post('to');
				$data['employee'] =  $this->input->post('employee');
				$data['employee'] = $data['employee']==''?'x':$data['employee'];
				$data['from'] = formatear_fecha($from);
				$data['to'] = formatear_fecha($to);
				
				//le sumo un dia al dia final para que ingrese ese dia en la consulta
				$data['to'] = date('Y-m-d',strtotime ( '+1 day ' , strtotime ( $data['to'] ) ) );

				$arrParam = array(
					"from" => $data['from'],
					"to" => $data['to'],
					"employee" => $data['employee']
				);

				switch ($modulo) {
					case 'payroll':
						$data['info'] = $this->report_model->get_payroll($arrParam);
						$data["view"] = "list_payroll";
						$data["modulo"] = $modulo;
						break;
					case 'payrollByAdmin':
						$data['info'] = $this->report_model->get_payroll($arrParam);
						$data["view"] = "list_payroll";
						$data["modulo"] = $modulo;
						break;
					case 'safety':
						$arrParam['jobId'] =  $this->input->post('jobName');
						$arrParam['jobId'] = $arrParam['jobId']==''?'x': $arrParam['jobId'];
						$data['jobId'] = $arrParam['jobId'];
					
						$data['info'] = $this->report_model->get_safety($arrParam);
						$data["view"] = "list_safety";
						break;
					case 'hauling':
						$arrParam['jobId'] =  $this->input->post('jobName');
						$arrParam['jobId'] = $arrParam['jobId']==''?'x': $arrParam['jobId'];
						$data['jobId'] = $arrParam['jobId'];
					
						$arrParam['company'] =  $this->input->post('company');
						$arrParam['company'] = $arrParam['company']==''?'x': $arrParam['company'];
						$data['company'] = $arrParam['company'];
						
						$arrParam['material'] =  $this->input->post('material');
						$arrParam['material'] = $arrParam['material']==''?'x': $arrParam['material'];
						$data['material'] = $arrParam['material'];
						
						$arrParam['vehicleId'] =  $this->input->post('truck');
						$arrParam['vehicleId'] = $arrParam['vehicleId']==''?'x': $arrParam['vehicleId'];
						$data['vehicleId'] = $arrParam['vehicleId'];

						$data['info'] = $this->report_model->get_hauling($arrParam);
						$data["view"] = "list_hauling";						
						break;
					case 'dailyInspection':
						$arrParam['vehicleId'] =  $this->input->post('vehicleId');
						$arrParam['vehicleId'] = $arrParam['vehicleId']==''?'x': $arrParam['vehicleId'];
						$data['vehicleId'] = $arrParam['vehicleId'];
						
						$arrParam['trailerId'] =  $this->input->post('trailerId');
						$arrParam['trailerId'] = $arrParam['trailerId']==''?'x': $arrParam['trailerId'];
						$data['trailerId'] = $arrParam['trailerId'];
					
						$data['info'] = $this->report_model->get_daily_inspection($arrParam);
											
						$data["view"] = "list_daily_inspection";
						break;
					case 'heavyInspection':
						$arrParam['vehicleId'] =  $this->input->post('vehicleId');
						$arrParam['vehicleId'] = $arrParam['vehicleId']==''?'x': $arrParam['vehicleId'];
						$data['vehicleId'] = $arrParam['vehicleId'];
						
						$data['info'] = $this->report_model->get_heavy_inspection($arrParam);
						$data["view"] = "list_heavy_inspection";
						break;
					case 'specialInspection':
						$arrParam['vehicleId'] =  $this->input->post('vehicleId');
						$arrParam['vehicleId'] = $arrParam['vehicleId']==''?'x': $arrParam['vehicleId'];
						$data['vehicleId'] = $arrParam['vehicleId'];
						
						$data['infoWaterTruck'] = $this->report_model->get_water_truck_inspection($arrParam);//info de water truck
						$data['infoHydrovac'] = $this->report_model->get_hydrovac_inspection($arrParam);//info de hydrovac
						$data['infoSweeper'] = $this->report_model->get_sweeper_inspection($arrParam);//info de sweeper
						$data['infoGenerator'] = $this->report_model->get_generator_inspection($arrParam);//info de generador
						
						$data["view"] = "list_special_inspection";
						break;
					case 'workorder':
						$arrParam['jobId'] =  $this->input->post('jobName');
						$arrParam['jobId'] = $arrParam['jobId']==''?'x': $arrParam['jobId'];
						$data['jobId'] = $arrParam['jobId'];
					
						$data['info'] = $this->report_model->get_workorder($arrParam);
						$data["view"] = "list_workorder";
						break;
				}
				
			}
			
			$this->load->view("layout", $data);
    }
	
	/**
	 * timeshift using reportico----se dejo de usar, se hicieron las vistas y las salidas en PDF con codeigniter
     * @since 17/11/2016
     * @author BMOTTAG
	 */
    public function timeshift() 
	{
			$this->load->view("report_timeshift");
    }
		
	/**
	 * Generate Safety Report in PDF
	 * @param date $from
	 * @param date $to
     * @since 7/01/2017
	 * @review 28/01/2017
     * @author BMOTTAG
	 */
	public function generaSafetyPDF($jobId, $from, $to, $idSafety='x')
	{
			$this->load->library('Pdf');
			
			// create new PDF document
			$pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);

			// set document information
			$pdf->SetCreator(PDF_CREATOR);
			$pdf->SetAuthor('VCI');
			$pdf->SetTitle('Safety Report');
			$pdf->SetSubject('TCPDF Tutorial');

			// set default header data
			$pdf->SetHeaderData(PDF_HEADER_LOGO, PDF_HEADER_LOGO_WIDTH, '', PDF_HEADER_STRING, array(0,64,255), array(0,64,128));

			// set header and footer fonts
			$pdf->setHeaderFont(Array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));
			$pdf->setFooterFont(Array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));

			$pdf->setPrintFooter(false); //no imprime el pie ni la linea 
			
			// set default monospaced font
			$pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);

			// set margins
			$pdf->SetMargins(PDF_MARGIN_LEFT, PDF_MARGIN_TOP, PDF_MARGIN_RIGHT);
			$pdf->SetHeaderMargin(PDF_MARGIN_HEADER);
			$pdf->SetFooterMargin(PDF_MARGIN_FOOTER);

			// set auto page breaks
			$pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);

			// set image scale factor
			$pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);

			// set some language-dependent strings (optional)
			if (@file_exists(dirname(__FILE__).'/lang/eng.php')) {
				require_once(dirname(__FILE__).'/lang/eng.php');
				$pdf->setLanguageArray($l);
			}

			// ---------------------------------------------------------

			// set font
			$pdf->SetFont('dejavusans', '', 8);


			// writeHTML($html, $ln=true, $fill=false, $reseth=false, $cell=false, $align='')
			// writeHTMLCell($w, $h, $x, $y, $html='', $border=0, $ln=0, $fill=0, $reseth=true, $align='', $autopadding=true)

			$data['from'] = $from;
			$data['to'] = $to;
				
			$jobId = $jobId=='x'?'':$jobId;
			$arrParam = array(
				"from" => $from,
				"to" => $to,
				"jobId" => $jobId,
				"idSafety" => $idSafety
			);
			
			$info = $this->report_model->get_safety($arrParam);			

			// - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
			// Print a table
			foreach ($info as $lista):
				
				$hazards = $this->report_model->get_safety_hazard($lista['id_safety']);
				$workers = $this->report_model->get_safety_workers($lista['id_safety']);
				$subcontractors = $this->report_model->get_safety_subcontractors($lista['id_safety']);

				// add a page
				$pdf->AddPage();
				
				$ppe="No";
				if($lista['ppe']==1){
					$ppe = "Yes";
				}

				// create some HTML content
				$html = '<br><h1 align="center" style="color:#337ab7;">FIELD LEVEL HAZARD ASSESSMENT<br><br></h1>
							<style>
							table {
								font-family: arial, sans-serif;
								border-collapse: collapse;
								width: 100%;
							}

							td, th {
								border: 1px solid #dddddd;
								text-align: left;
								padding: 8px;
							}
							</style>
							<table cellspacing="0" cellpadding="5">
								<tr>
									<th bgcolor="#337ab7" style="color:white;"><strong>Work To Be Done: </strong></th>
									<th >' . $lista['work']. '</th>
									<th bgcolor="#337ab7" style="color:white;"><strong>Date: </strong></th>
									<th >' . $lista['date']. '</th>
								</tr>
								<tr>
									<th bgcolor="#337ab7" style="color:white;"><strong>PPE Inspected: </strong></th>
									<th >' . $ppe. '</th>
									<th bgcolor="#337ab7" style="color:white;"><strong>Job Code/Name: </strong></th>
									<th >' . $lista['job_description']. '</th>
								</tr>
								<tr>
									<th bgcolor="#337ab7" style="color:white;"><strong>Specify PPE: </strong></th>
									<th colspan="3" >' . $lista['specify_ppe']. '</th>
								</tr>
								<tr>
									<th bgcolor="#337ab7" style="color:white;"><strong>Muster Point: </strong></th>
									<th colspan="3" >' . $lista['muster_point']. '</th>
								</tr>
							</table>';
						
				$html .= '<table border="1" cellspacing="0" cellpadding="5">
						<tr>
							<th colspan="4"><strong><i>Identify and prioritize hazards below, then identify plans to eliminate/control the hazards</i></strong></th>
						</tr>
						<tr bgcolor="#337ab7" style="color:white;">
							<th width="5%" align="center"><strong>#</strong></th>
							<th width="40%" align="center"><strong>Hazard</strong></th>
							<th width="15%" align="center"><strong>Priority</strong></th>
							<th width="40%" align="center"><strong>Control/Eliminate</strong></th>
						</tr>';
					if(!$hazards){
							$html.= '<tr>';					
							$html.= '<th colspan="4" align="center"> ---- No data was found for Hazard -----</th>';
							$html.= '</tr>';					
					}else{
						$i = 0;
						foreach ($hazards as $data):
							$i++;
							$html.= '<tr>';					
							$html.= '<th align="center">' . $i . '</th>';
							$html.= '<th >' . $data['hazard_description'] . '</th>';					
							$priority = $data['priority_description']==""?"-":$data['priority_description'];
							$html.= '<th align="center">' . $priority . '</th>';
							$html.= '<th >' . $data['solution']  . '</th>';
							$html.= '</tr>';
						endforeach;
					}
				$html.= "</table><br><br><br><br>";
				
				if(!$workers){			
						$html.= 'No data was found for workers';
				}else{				
				
						$html.= '<table border="1" cellspacing="0" cellpadding="5">';
								
						//pintar las firmas de a 4 por fila
						$total = count($workers);//contar numero de trabajadores
						$totalFilas  = 1;
						if($total>=4)
						{//si es mayor 4 entonces calcular cuantas filas deben ser
							$div = $total / 4;
							$totalFilas = ceil($div); //redondeo hace arriba
						}

						$n = 1;
						for($i=0;$i<$totalFilas;$i++){
							$html.= '<tr>
										<th align="center" width="20%"><strong><p>Initials</p></strong></th>';	
							
									$finish = $n * 4;
									$star = $finish - 4;
									if($finish > $total){
										$finish = $total;
									}
									$n++;			
																							
									for ($j = $star; $j < $finish; $j++) {
				
										$html.= '<th align="center" width="20%">';
										
										if($workers[$j]['signature']){
											//$url = base_url($workers[$j]['signature']);
											$html.= '<img src="'.$workers[$j]['signature'].'" border="0" width="70" height="70" />';
										}
										$html.= '</th>';
									}

							$html.= '</tr>';
							
							$html.= '<tr bgcolor="#337ab7" style="color:white;">
										<th align="center"><strong>Company</strong></th>';
										for ($j = $star; $j < $finish; $j++) {	
											$html.= '<th align="center"><strong>VCI</strong></th>';
										}
							$html.= '</tr>';
							
							$html.= '<tr bgcolor="#337ab7" style="color:white;">
										<th align="center"><strong>Worker Name</strong></th>';		
										for ($j = $star; $j < $finish; $j++) {	
											$html.= '<th align="center"><strong>' . $workers[$j]['name'] . '</strong></th>';
										}
							$html.= '</tr>';
						}
						
						$html.= '</table>';
				}
					
				$html.= '<br><br>';
				
				if($subcontractors){			
		
						$html.= '<table border="1" cellspacing="0" cellpadding="5">';
								
						//pintar las firmas de a 4 por fila
						$total = count($subcontractors);//contar numero de trabajadores
						$totalFilas  = 1;
						if($total>=4)
						{//si es mayor 4 entonces calcular cuantas filas deben ser
							$div = $total / 4;
							$totalFilas = ceil($div); //redondeo hace arriba
						}

						$n = 1;
						for($i=0;$i<$totalFilas;$i++){
							$html.= '<tr>
										<th align="center" width="20%"><strong><p>Initials</p></strong></th>';	
							
									$finish = $n * 4;
									$star = $finish - 4;
									if($finish > $total){
										$finish = $total;
									}
									$n++;			
																							
									for ($j = $star; $j < $finish; $j++) {
				
										$html.= '<th align="center" width="20%">';
										
										if($subcontractors[$j]['signature']){
											//$url = base_url($subcontractors[$j]['signature']);
											$html.= '<img src="'.$subcontractors[$j]['signature'].'" border="0" width="70" height="70" />';
										}
										$html.= '</th>';
									}

							$html.= '</tr>';
							
							$html.= '<tr bgcolor="#337ab7" style="color:white;">
										<th align="center"><strong>Company</strong></th>';
										for ($j = $star; $j < $finish; $j++) {	
											$html.= '<th align="center"><strong>' . $subcontractors[$j]['company_name'] . '</strong></th>';
										}
							$html.= '</tr>';
							
							$html.= '<tr bgcolor="#337ab7" style="color:white;">
										<th align="center"><strong>Worker Name</strong></th>';		
										for ($j = $star; $j < $finish; $j++) {	
											$html.= '<th align="center"><strong>' . $subcontractors[$j]['worker_name'] . '</strong></th>';
										}
							$html.= '</tr>';
						}
						
						$html.= '</table>';
				}
					
				$html.= '<br><br>';				
				$signature = "";

				if($lista['signature']){
					//$urlAdvisor = base_url($lista['signature']);
					$signature = '<img src="'.$lista['signature'].'" border="0" width="70" height="70" />';
				}

				$html.= '<table border="1" cellspacing="0" cellpadding="5" width="40%">
						<tr>
							<th align="center" ><strong><p>Meeting conducted by</p></strong></th>
							<th align="center">' . $signature . '</th>
						</tr>
						<tr bgcolor="#337ab7" style="color:white;">
							<th align="center" ><strong>Name</strong></th>
							<th align="center"><strong>' . $lista['name']. '</strong></th>
						</tr>
						</table>';			

				// output the HTML content
				$pdf->writeHTML($html, true, false, true, false, '');

			endforeach;

			// reset pointer to the last page
			$pdf->lastPage();

			// ---------------------------------------------------------

			//Close and output PDF document
			$pdf->Output('flha.pdf', 'I');

			//============================================================+
			// END OF FILE
			//============================================================+
		
	}

	
	/**
	 * Generate Hauling Report in PDF
	 * @param int $idCompany
	 * @param date $from
	 * @param date $to
	 * @param date $idHauling
     * @since 8/01/2017
	 * @review 28/1/2017
	 * @review 1/2/2018
     * @author BMOTTAG
	 */
	public function generaHaulingPDF($idCompany, $idMaterial, $from, $to, $idHauling='x')
	{
			$this->load->library('Pdf');
			
			// create new PDF document
			$pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);

			// set document information
			$pdf->SetCreator(PDF_CREATOR);
			$pdf->SetAuthor('VCI');
			$pdf->SetTitle('App Report');
			$pdf->SetSubject('TCPDF Tutorial');

			// set default header data
			$pdf->SetHeaderData(PDF_HEADER_LOGO, PDF_HEADER_LOGO_WIDTH, '', PDF_HEADER_STRING, array(0,64,255), array(0,64,128));

			// set header and footer fonts
			$pdf->setHeaderFont(Array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));
			$pdf->setFooterFont(Array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));
			
			$pdf->setPrintFooter(false); //no imprime el pie ni la linea 

			// set default monospaced font
			$pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);

			// set margins
			$pdf->SetMargins(PDF_MARGIN_LEFT, PDF_MARGIN_TOP, PDF_MARGIN_RIGHT);
			$pdf->SetHeaderMargin(PDF_MARGIN_HEADER);
			$pdf->SetFooterMargin(PDF_MARGIN_FOOTER);

			// set auto page breaks
			$pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);

			// set image scale factor
			$pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);

			// set some language-dependent strings (optional)
			if (@file_exists(dirname(__FILE__).'/lang/eng.php')) {
				require_once(dirname(__FILE__).'/lang/eng.php');
				$pdf->setLanguageArray($l);
			}

			// ---------------------------------------------------------

			// set font
			$pdf->SetFont('dejavusans', '', 8);


			// writeHTML($html, $ln=true, $fill=false, $reseth=false, $cell=false, $align='')
			// writeHTMLCell($w, $h, $x, $y, $html='', $border=0, $ln=0, $fill=0, $reseth=true, $align='', $autopadding=true)
			
			$arrParam = array(
				"company" => $idCompany,
				"material" => $idMaterial,
				"from" => $from,
				"to" => $to,
				"idHauling" => $idHauling
			);
			$info = $this->report_model->get_hauling($arrParam);

			// - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
			// Print a table
			foreach ($info as $lista):
				
				// add a page
				$pdf->AddPage();
				
				$titlePlate = "Plate Number";
				$unitNumber = $lista['plate'];
				//si la empresa es VCI entonces debe venir con un vehiculo de la base de datos, sino se le coloco el numero
				if($lista["fk_id_company"]==1){
					$titlePlate = "Plate Number";
					$unitNumber = $lista['unit_number'];
				}
				
				
				// create some HTML content
				$html = '<br><h1 align="center" style="color:#337ab7;">HAULING REPORT<br><br></h1>
							<style>
							table {
								font-family: arial, sans-serif;
								border-collapse: collapse;
								width: 100%;
							}

							td, th {
								border: 1px solid #dddddd;
								text-align: left;
								padding: 8px;
							}
							</style>
						<table border="0" cellspacing="0" cellpadding="5">
							<tr>
								<th bgcolor="#337ab7" style="color:white;"><strong>Number: </strong></th>
								<th>' . $lista['id_hauling']. '</th>
								<th bgcolor="#337ab7" style="color:white;"><strong>Employee: </strong></th>
								<th>' . $lista['name']. '</th>
							</tr>
							<tr>
								<th bgcolor="#337ab7" style="color:white;"><strong>Hauling done by: </strong></th>
								<th>' . $lista['company_name']. '</th>
								<th bgcolor="#337ab7" style="color:white;"><strong>Date: </strong></th>
								<th>' . $lista['date_issue']. '</th>
							</tr>
							<tr>
								<th bgcolor="#337ab7" style="color:white;"><strong>Truck - ' . $titlePlate . ': </strong></th>
								<th>' . $unitNumber . '</th>
								<th bgcolor="#337ab7" style="color:white;"><strong>Truck Type: </strong></th>
								<th>' . $lista['truck_type']. '</th>
							</tr>
							<tr>
								<th bgcolor="#337ab7" style="color:white;"><strong>Material Type: </strong></th>
								<th>' . $lista['material']. '</th>
								<th bgcolor="#337ab7" style="color:white;"><strong>Payment: </strong></th>
								<th>' . $lista['payment']. '</th>
							</tr>
							<tr>
								<th bgcolor="#337ab7" style="color:white;"><strong>From Site: </strong></th>
								<th>' . $lista['site_from']. '</th>
								<th bgcolor="#337ab7" style="color:white;"><strong>To Site: </strong></th>
								<th>' . $lista['site_to']. '</th>
							</tr>
							<tr>
								<th bgcolor="#337ab7" style="color:white;"><strong>Time In: </strong></th>
								<th>' . $lista['time_in']. '</th>
								<th bgcolor="#337ab7" style="color:white;"><strong>Time Out: </strong></th>
								<th>' . $lista['time_out']. '</th>
							</tr>
							<tr>
								<th bgcolor="#337ab7" style="color:white;"><strong>Comments: </strong></th>
								<th colspan="3">' . $lista['comments']. '</th>
							</tr>
							

						</table>
						</p>';
			
				$signatureVCI = "";
				$signatureContractor = "";
				if($lista['vci_signature']){
					//$urlVCI = base_url($lista['vci_signature']);
					$signatureVCI = '<img src="'.$lista['vci_signature'].'" border="0" width="100" height="100" />';
				}
				
				if($lista['contractor_signature']){
					//$urlContractor = base_url($lista['contractor_signature']);
					$signatureContractor = '<img src="'.$lista['contractor_signature'].'" border="0" width="100" height="100" />';
				}
		
				$html.= '<table border="0" cellspacing="0" cellpadding="5">
						<tr bgcolor="#337ab7" style="color:white;">
							<th align="center" colspan="3"><strong>Signatures</strong></th>
						</tr>
						<tr>
							<th width="35%" align="center">' . $signatureVCI . '</th>
							<th width="30%"></th>
							<th width="35%" align="center">' . $signatureContractor . '</th>
						</tr>
						
						<tr bgcolor="#337ab7" style="color:white;">
							<th align="center"><strong>VCI Supervisor<br>' . $lista['name']. '</strong></th>
							<th ></th>
							<th align="center"><strong>Contractor</strong></th>
						</tr>
						</table>';
			
	
				// output the HTML content
				$pdf->writeHTML($html, true, false, true, false, '');

				// Print some HTML Cells
			endforeach;

			// reset pointer to the last page
			$pdf->lastPage();


			//Close and output PDF document
			$pdf->Output('hauling.pdf', 'I');

			//============================================================+
			// END OF FILE
			//============================================================+
		
	}
	
	/**
	 * Generate Inspection Daily Report in PDF
	 * @param int $idEmployee
	 * @param date $from
	 * @param date $to
	 * @param date $idInspection
     * @since 8/01/2017
	 * @since 31/01/2018
	 * @review 28/01/2017
     * @author BMOTTAG
	 */
	public function generaInsectionDailyPDF($idEmployee, $idVehicle, $idTrailer, $from, $to, $idInspection='x')
	{
			$this->load->library('Pdf');
			
			// create new PDF document
			$pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);

			// set document information
			$pdf->SetCreator(PDF_CREATOR);
			$pdf->SetAuthor('VCI');
			$pdf->SetTitle('Inspection Report');
			$pdf->SetSubject('TCPDF Tutorial');

			// set default header data
			$pdf->SetHeaderData(PDF_HEADER_LOGO, PDF_HEADER_LOGO_WIDTH, '', PDF_HEADER_STRING, array(0,64,255), array(0,64,128));

			// set header and footer fonts
			$pdf->setHeaderFont(Array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));
			$pdf->setFooterFont(Array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));

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
			if (@file_exists(dirname(__FILE__).'/lang/eng.php')) {
				require_once(dirname(__FILE__).'/lang/eng.php');
				$pdf->setLanguageArray($l);
			}

			// ---------------------------------------------------------

			// set font
			$pdf->SetFont('dejavusans', '', 7);

			// writeHTML($html, $ln=true, $fill=false, $reseth=false, $cell=false, $align='')
			// writeHTMLCell($w, $h, $x, $y, $html='', $border=0, $ln=0, $fill=0, $reseth=true, $align='', $autopadding=true)

			$arrParam = array(
				"employee" => $idEmployee,
				"vehicleId" => $idVehicle,
				"trailerId" => $idTrailer,
				"from" => $from,
				"to" => $to,
				"idInspection" => $idInspection
			);
			$info = $this->report_model->get_daily_inspection($arrParam);
			
			// - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
			// Print a table
			foreach ($info as $lista):
				
				// add a page
				$pdf->AddPage();

				switch ($lista['type_level_1']) {
					case 1:
						$type1 = 'Fleet';
						break;
					case 2:
						$type1 = 'Rental';
						break;
					case 99:
						$type1 = 'Other';
						break;
				}
				

				//bandera para saber el tipo de inpeccion si es TRUCK o PICKUP
				$inspectionType = $lista["inspection_type"];
				$truck = FALSE; //cargo bandera para utilizarla en los campos que son para TRUCK -> inpection type 3
				$title = "PICKUP";
				if($inspectionType == 3){
					$truck = TRUE;
					$title = "TRUCK";
				}
				//FIN BANDERA

				// create some HTML content
				$html = '<h1 align="center" style="color:#337ab7;">' . $title . ' INSPECTION REPORT</h1>
							<style>
							table {
								font-family: arial, sans-serif;
								border-collapse: collapse;
								width: 100%;
							}

							td, th {
								border: 1px solid #dddddd;
								text-align: left;
								padding: 8px;
							}
							</style>
						<table border="1" cellspacing="0" cellpadding="5">
							<tr bgcolor="#337ab7" style="color:white;">
								<th><strong>Type: </strong><br>' . $type1 . ' - ' . $lista['type_2'] . '</th>
								<th><strong>Make: </strong><br>' . $lista['make'] . '</th>
								<th><strong>Model: </strong><br>' . $lista['model'] . '</th>
								<th><strong>Unit Number: </strong><br>' . $lista['unit_number'] . '</th>
								<th><strong>Date & Time: </strong><br>' . $lista['date_issue'] . '</th>
							</tr>
						</table>
						<br><br>';
						
				$html.= '<table border="1" cellspacing="0" cellpadding="5">
							<tr bgcolor="#337ab7" style="color:white;">
								<th align="center" width="30%"><strong>Items to Check</strong></th>
								<th align="center" width="10%"><strong>Pass</strong></th>
								<th align="center" width="10%"><strong>Fail</strong></th>
								<th align="center" width="30%"><strong>Items to Check</strong></th>
								<th align="center" width="10%"><strong>Pass</strong></th>
								<th align="center" width="10%"><strong>Fail</strong></th>
							</tr>';

						$html.='<tr bgcolor="#337ab7" style="color:white;">
								<th align="center" colspan="3"><strong>ENGINE</strong></th>
								<th align="center" colspan="3"><strong>LIGHTS</strong></th>
								</tr>';

						$html.='<tr>
								<th align="center"><strong>Belts/Hoses</strong></th>';
							if($lista["belt"] == 1){
								$html.= '<th align="center"><strong>Y</strong></th>
										 <th align="center"><strong></strong></th>';
							}elseif($lista["belt"] == 0){
								$html.='<th align="center"><strong></strong></th>
										 <th align="center"><strong>X</strong></th>';					
							}else{
								$html.='<th align="center"><strong>N/A</strong></th>
										 <th align="center"><strong>N/A</strong></th>';													
							}
							
						$html.='<th align="center"><strong>Head Lamps</strong></th>';
							if($lista["head_lamps"] == 1){
								$html.= '<th align="center"><strong>Y</strong></th>
										 <th align="center"><strong></strong></th>';
							}elseif($lista["head_lamps"] == 0){
								$html.='<th align="center"><strong></strong></th>
										 <th align="center"><strong>X</strong></th>';					
							}else{
								$html.='<th align="center"><strong>N/A</strong></th>
										 <th align="center"><strong>N/A</strong></th>';													
							}
					
						$html.='</tr>';
					
						$html.='<tr>
								<th align="center"><strong>Power Steering Fluid</strong></th>';
							if($lista["power_steering"] == 1){
								$html.= '<th align="center"><strong>Y</strong></th>
										 <th align="center"><strong></strong></th>';
							}elseif($lista["power_steering"] == 0){
								$html.='<th align="center"><strong></strong></th>
										 <th align="center"><strong>X</strong></th>';					
							}else{
								$html.='<th align="center"><strong>N/A</strong></th>
										 <th align="center"><strong>N/A</strong></th>';													
							}
					
						$html.='<th align="center"><strong>Hazard Lights</strong></th>';
							if($lista["hazard_lights"] == 1){
								$html.= '<th align="center"><strong>Y</strong></th>
										 <th align="center"><strong></strong></th>';
							}elseif($lista["hazard_lights"] == 0){
								$html.='<th align="center"><strong></strong></th>
										 <th align="center"><strong>X</strong></th>';					
							}else{
								$html.='<th align="center"><strong>N/A</strong></th>
										 <th align="center"><strong>N/A</strong></th>';													
							}
						$html.='</tr>';
						
						$html.='<tr>
								<th align="center"><strong>Oil Level</strong></th>';
							if($lista["oil_level"] == 1){
								$html.= '<th align="center"><strong>Y</strong></th>
										 <th align="center"><strong></strong></th>';
							}elseif($lista["oil_level"] == 0){
								$html.='<th align="center"><strong></strong></th>
										 <th align="center"><strong>X</strong></th>';					
							}else{
								$html.='<th align="center"><strong>N/A</strong></th>
										 <th align="center"><strong>N/A</strong></th>';													
							}
							
						$html.='<th align="center"><strong>Tail Lights</strong></th>';
							if($lista["bake_lights"] == 1){
								$html.= '<th align="center"><strong>Y</strong></th>
										 <th align="center"><strong></strong></th>';
							}elseif($lista["bake_lights"] == 0){
								$html.='<th align="center"><strong></strong></th>
										 <th align="center"><strong>X</strong></th>';					
							}else{
								$html.='<th align="center"><strong>N/A</strong></th>
										 <th align="center"><strong>N/A</strong></th>';													
							}
					
						$html.='</tr>';
						
						$html.='<tr>
								<th align="center"><strong>Coolant Level</strong></th>';
							if($lista["coolant_level"] == 1){
								$html.= '<th align="center"><strong>Y</strong></th>
										 <th align="center"><strong></strong></th>';
							}elseif($lista["coolant_level"] == 0){
								$html.='<th align="center"><strong></strong></th>
										 <th align="center"><strong>X</strong></th>';					
							}else{
								$html.='<th align="center"><strong>N/A</strong></th>
										 <th align="center"><strong>N/A</strong></th>';													
							}
							
						$html.='<th align="center"><strong>Work Lights</strong></th>';
							if($lista["work_lights"] == 1){
								$html.= '<th align="center"><strong>Y</strong></th>
										 <th align="center"><strong></strong></th>';
							}elseif($lista["work_lights"] == 0){
								$html.='<th align="center"><strong></strong></th>
										 <th align="center"><strong>X</strong></th>';					
							}else{
								$html.='<th align="center"><strong>N/A</strong></th>
										 <th align="center"><strong>N/A</strong></th>';													
							}
					
						$html.='</tr>';
						
						$html.='<tr>
								<th align="center"><strong>Coolant/Oil Leaks</strong></th>';
							if($lista["water_leaks"] == 1){
								$html.= '<th align="center"><strong>Y</strong></th>
										 <th align="center"><strong></strong></th>';
							}elseif($lista["water_leaks"] == 0){
								$html.='<th align="center"><strong></strong></th>
										 <th align="center"><strong>X</strong></th>';					
							}else{
								$html.='<th align="center"><strong>N/A</strong></th>
										 <th align="center"><strong>N/A</strong></th>';													
							}
							
						$html.='<th align="center"><strong>Turn signals lights</strong></th>';
							if($lista["turn_signals"] == 1){
								$html.= '<th align="center"><strong>Y</strong></th>
										 <th align="center"><strong></strong></th>';
							}elseif($lista["turn_signals"] == 0){
								$html.='<th align="center"><strong></strong></th>
										 <th align="center"><strong>X</strong></th>';					
							}else{
								$html.='<th align="center"><strong>N/A</strong></th>
										 <th align="center"><strong>N/A</strong></th>';													
							}
							
						$html.='</tr>';

if($truck){						
						$html.='<tr>
								<th colspan="3" rowspan="2"></th>';

						$html.='<th align="center"><strong>Beacon Light:</strong></th>';
							if($lista["beacon_light"] == 1){
								$html.= '<th align="center"><strong>Y</strong></th>
										 <th align="center"><strong></strong></th>';
							}elseif($lista["beacon_light"] == 0){
								$html.='<th align="center"><strong></strong></th>
										 <th align="center"><strong>X</strong></th>';					
							}else{
								$html.='<th align="center"><strong>N/A</strong></th>
										 <th align="center"><strong>N/A</strong></th>';													
							}
							
						$html.='</tr>';
}
					
if($truck){
						$html.='<tr>';
	
						$html.='<th align="center"><strong>Clearance Lights</strong></th>';
							if($lista["clearance_lights"] == 1){
								$html.= '<th align="center"><strong>Y</strong></th>
										 <th align="center"><strong></strong></th>';
							}elseif($lista["clearance_lights"] == 0){
								$html.='<th align="center"><strong></strong></th>
										 <th align="center"><strong>X</strong></th>';					
							}else{
								$html.='<th align="center"><strong>N/A</strong></th>
										 <th align="center"><strong>N/A</strong></th>';													
							}
							
						$html.='</tr>';
}					
						
						$html.='<tr bgcolor="#337ab7" style="color:white;">
								<th align="center" colspan="3"><strong>SERVICE</strong></th>
								<th align="center" colspan="3"><strong>EXTERIOR</strong></th>
								</tr>';

						$html.='<tr>
								<th align="center"><strong>Brake pedal</strong></th>';
							if($lista["brake_pedal"] == 1){
								$html.= '<th align="center"><strong>Y</strong></th>
										 <th align="center"><strong></strong></th>';
							}elseif($lista["brake_pedal"] == 0){
								$html.='<th align="center"><strong></strong></th>
										 <th align="center"><strong>X</strong></th>';					
							}else{
								$html.='<th align="center"><strong>N/A</strong></th>
										 <th align="center"><strong>N/A</strong></th>';													
							}
							
						$html.='<th align="center"><strong>Tires/Lug Nuts/Pressure</strong></th>';
							if($lista["nuts"] == 1){
								$html.= '<th align="center"><strong>Y</strong></th>
										 <th align="center"><strong></strong></th>';
							}elseif($lista["nuts"] == 0){
								$html.='<th align="center"><strong></strong></th>
										 <th align="center"><strong>X</strong></th>';					
							}else{
								$html.='<th align="center"><strong>N/A</strong></th>
										 <th align="center"><strong>N/A</strong></th>';													
							}
					
						$html.='</tr>';
					
						$html.='<tr>
								<th align="center"><strong>Emergency brake</strong></th>';
							if($lista["emergency_brake"] == 1){
								$html.= '<th align="center"><strong>Y</strong></th>
										 <th align="center"><strong></strong></th>';
							}elseif($lista["emergency_brake"] == 0){
								$html.='<th align="center"><strong></strong></th>
										 <th align="center"><strong>X</strong></th>';					
							}else{
								$html.='<th align="center"><strong>N/A</strong></th>
										 <th align="center"><strong>N/A</strong></th>';													
							}
					
						$html.='<th align="center"><strong>Glass (All) & Mirror</strong></th>';
							if($lista["glass"] == 1){
								$html.= '<th align="center"><strong>Y</strong></th>
										 <th align="center"><strong></strong></th>';
							}elseif($lista["glass"] == 0){
								$html.='<th align="center"><strong></strong></th>
										 <th align="center"><strong>X</strong></th>';					
							}else{
								$html.='<th align="center"><strong>N/A</strong></th>
										 <th align="center"><strong>N/A</strong></th>';													
							}
						$html.='</tr>';
						
						$html.='<tr>
								<th align="center"><strong>Gauges: Volt/Fuel/Temp/Oil</strong></th>';
							if($lista["gauges"] == 1){
								$html.= '<th align="center"><strong>Y</strong></th>
										 <th align="center"><strong></strong></th>';
							}elseif($lista["gauges"] == 0){
								$html.='<th align="center"><strong></strong></th>
										 <th align="center"><strong>X</strong></th>';					
							}else{
								$html.='<th align="center"><strong>N/A</strong></th>
										 <th align="center"><strong>N/A</strong></th>';													
							}
							
						$html.='<th align="center"><strong>Clean exterior</strong></th>';
							if($lista["clean_exterior"] == 1){
								$html.= '<th align="center"><strong>Y</strong></th>
										 <th align="center"><strong></strong></th>';
							}elseif($lista["clean_exterior"] == 0){
								$html.='<th align="center"><strong></strong></th>
										 <th align="center"><strong>X</strong></th>';					
							}else{
								$html.='<th align="center"><strong>N/A</strong></th>
										 <th align="center"><strong>N/A</strong></th>';													
							}
					
						$html.='</tr>';
						
						$html.='<tr>
								<th align="center"><strong>Electrical & Air Horn</strong></th>';
							if($lista["horn"] == 1){
								$html.= '<th align="center"><strong>Y</strong></th>
										 <th align="center"><strong></strong></th>';
							}elseif($lista["horn"] == 0){
								$html.='<th align="center"><strong></strong></th>
										 <th align="center"><strong>X</strong></th>';					
							}else{
								$html.='<th align="center"><strong>N/A</strong></th>
										 <th align="center"><strong>N/A</strong></th>';													
							}

						$html.='<th align="center"><strong>Wipers/Washers</strong></th>';
							if($lista["wipers"] == 1){
								$html.= '<th align="center"><strong>Y</strong></th>
										 <th align="center"><strong></strong></th>';
							}elseif($lista["wipers"] == 0){
								$html.='<th align="center"><strong></strong></th>
										 <th align="center"><strong>X</strong></th>';					
							}else{
								$html.='<th align="center"><strong>N/A</strong></th>
										 <th align="center"><strong>N/A</strong></th>';													
							}
							
						$html.='</tr>';
						
						$html.='<tr>
								<th align="center"><strong>Seatbelts </strong></th>';
							if($lista["seatbelts"] == 1){
								$html.= '<th align="center"><strong>Y</strong></th>
										 <th align="center"><strong></strong></th>';
							}elseif($lista["seatbelts"] == 0){
								$html.='<th align="center"><strong></strong></th>
										 <th align="center"><strong>X</strong></th>';					
							}else{
								$html.='<th align="center"><strong>N/A</strong></th>
										 <th align="center"><strong>N/A</strong></th>';													
							}
							
						$html.='<th align="center"><strong>Backup Beeper </strong></th>';
							if($lista["backup_beeper"] == 1){
								$html.= '<th align="center"><strong>Y</strong></th>
										 <th align="center"><strong></strong></th>';
							}elseif($lista["backup_beeper"] == 0){
								$html.='<th align="center"><strong></strong></th>
										 <th align="center"><strong>X</strong></th>';					
							}else{
								$html.='<th align="center"><strong>N/A</strong></th>
										 <th align="center"><strong>N/A</strong></th>';													
							}
					
						$html.='</tr>';
						
						$html.='<tr>
								<th align="center"><strong>Driver & Passenger seat</strong></th>';
							if($lista["driver_seat"] == 1){
								$html.= '<th align="center"><strong>Y</strong></th>
										 <th align="center"><strong></strong></th>';
							}elseif($lista["driver_seat"] == 0){
								$html.='<th align="center"><strong></strong></th>
										 <th align="center"><strong>X</strong></th>';					
							}else{
								$html.='<th align="center"><strong>N/A</strong></th>
										 <th align="center"><strong>N/A</strong></th>';													
							}
							
						$html.='<th align="center"><strong>Driver and Passenger door</strong></th>';
							if($lista["passenger_door"] == 1){
								$html.= '<th align="center"><strong>Y</strong></th>
										 <th align="center"><strong></strong></th>';
							}elseif($lista["passenger_door"] == 0){
								$html.='<th align="center"><strong></strong></th>
										 <th align="center"><strong>X</strong></th>';					
							}else{
								$html.='<th align="center"><strong>N/A</strong></th>
										 <th align="center"><strong>N/A</strong></th>';													
							}
												
						$html.='</tr>';
						
						$html.='<tr>
								<th align="center"><strong>Insurance information</strong></th>';
							if($lista["insurance"] == 1){
								$html.= '<th align="center"><strong>Y</strong></th>
										 <th align="center"><strong></strong></th>';
							}elseif($lista["insurance"] == 0){
								$html.='<th align="center"><strong></strong></th>
										 <th align="center"><strong>X</strong></th>';					
							}else{
								$html.='<th align="center"><strong>N/A</strong></th>
										 <th align="center"><strong>N/A</strong></th>';													
							}

						$html.='<th align="center"><strong>Decals</strong></th>';
							if($lista["proper_decals"] == 1){
								$html.= '<th align="center"><strong>Y</strong></th>
										 <th align="center"><strong></strong></th>';
							}elseif($lista["proper_decals"] == 0){
								$html.='<th align="center"><strong></strong></th>
										 <th align="center"><strong>X</strong></th>';					
							}else{
								$html.='<th align="center"><strong>N/A</strong></th>
										 <th align="center"><strong>N/A</strong></th>';													
							}

						$html.='</tr>';
						
						$html.='<tr>
								<th align="center"><strong>Registration</strong></th>';
							if($lista["registration"] == 1){
								$html.= '<th align="center"><strong>Y</strong></th>
										 <th align="center"><strong></strong></th>';
							}elseif($lista["registration"] == 0){
								$html.='<th align="center"><strong></strong></th>
										 <th align="center"><strong>X</strong></th>';					
							}else{
								$html.='<th align="center"><strong>N/A</strong></th>
										 <th align="center"><strong>N/A</strong></th>';													
							}
if($truck){
						$html.='<th align="center" colspan="3" rowspan="2"><strong></strong></th>';
}
						$html.='</tr>';
						
						$html.='<tr>
								<th align="center"><strong>Clean interior</strong></th>';
							if($lista["clean_interior"] == 1){
								$html.= '<th align="center"><strong>Y</strong></th>
										 <th align="center"><strong></strong></th>';
							}elseif($lista["clean_interior"] == 0){
								$html.='<th align="center"><strong></strong></th>
										 <th align="center"><strong>X</strong></th>';					
							}else{
								$html.='<th align="center"><strong>N/A</strong></th>
										 <th align="center"><strong>N/A</strong></th>';													
							}
					
						$html.='</tr>';
						
						$html.='<tr bgcolor="#337ab7" style="color:white;">
								<th align="center" colspan="3"><strong>SAFETY</strong></th>';

$grease = "";
if($truck){
	$grease = "GREASING";
}
						$html.='<th align="center" colspan="3">' . $grease . '<strong></strong></th>
								</tr>';

						$html.='<tr>
								<th align="center"><strong>Fire extinguisher</strong></th>';
							if($lista["fire_extinguisher"] == 1){
								$html.= '<th align="center"><strong>Y</strong></th>
										 <th align="center"><strong></strong></th>';
							}elseif($lista["fire_extinguisher"] == 0){
								$html.='<th align="center"><strong></strong></th>
										 <th align="center"><strong>X</strong></th>';					
							}else{
								$html.='<th align="center"><strong>N/A</strong></th>
										 <th align="center"><strong>N/A</strong></th>';													
							}
if($truck){
						$html.='<th align="center"><strong>Steering Axle</strong></th>';
							if($lista["steering_axle"] == 1){
								$html.= '<th align="center"><strong>Y</strong></th>
										 <th align="center"><strong></strong></th>';
							}elseif($lista["steering_axle"] == 0){
								$html.='<th align="center"><strong></strong></th>
										 <th align="center"><strong>X</strong></th>';					
							}else{
								$html.='<th align="center"><strong>N/A</strong></th>
										 <th align="center"><strong>N/A</strong></th>';													
							}

}else{
						$html.='<th colspan="3" rowspan="4"></th>';
}					
						$html.='</tr>';
						
						$html.='<tr>
								<th align="center"><strong>First Aid</strong></th>';
							if($lista["first_aid"] == 1){
								$html.= '<th align="center"><strong>Y</strong></th>
										 <th align="center"><strong></strong></th>';
							}elseif($lista["first_aid"] == 0){
								$html.='<th align="center"><strong></strong></th>
										 <th align="center"><strong>X</strong></th>';					
							}else{
								$html.='<th align="center"><strong>N/A</strong></th>
										 <th align="center"><strong>N/A</strong></th>';													
							}
if($truck){
						$html.='<th align="center"><strong>Drives Axles</strong></th>';
							if($lista["drives_axle"] == 1){
								$html.= '<th align="center"><strong>Y</strong></th>
										 <th align="center"><strong></strong></th>';
							}elseif($lista["drives_axle"] == 0){
								$html.='<th align="center"><strong></strong></th>
										 <th align="center"><strong>X</strong></th>';					
							}else{
								$html.='<th align="center"><strong>N/A</strong></th>
										 <th align="center"><strong>N/A</strong></th>';													
							}	

}
						$html.='</tr>';
						
						$html.='<tr>
								<th align="center"><strong>Emergency Kit</strong></th>';
							if($lista["emergency_reflectors"] == 1){
								$html.= '<th align="center"><strong>Y</strong></th>
										 <th align="center"><strong></strong></th>';
							}elseif($lista["emergency_reflectors"] == 0){
								$html.='<th align="center"><strong></strong></th>
										 <th align="center"><strong>X</strong></th>';					
							}else{
								$html.='<th align="center"><strong>N/A</strong></th>
										 <th align="center"><strong>N/A</strong></th>';													
							}
if($truck){							
						$html.='<th align="center"><strong>Front drive shaft</strong></th>';
							if($lista["grease_front"] == 1){
								$html.= '<th align="center"><strong>Y</strong></th>
										 <th align="center"><strong></strong></th>';
							}elseif($lista["grease_front"] == 0){
								$html.='<th align="center"><strong></strong></th>
										 <th align="center"><strong>X</strong></th>';					
							}else{
								$html.='<th align="center"><strong>N/A</strong></th>
										 <th align="center"><strong>N/A</strong></th>';													
							}

}
						$html.='</tr>';
						
						$html.='<tr>
								<th align="center"><strong>Spill Kit</strong></th>';
							if($lista["spill_kit"] == 1){
								$html.= '<th align="center"><strong>Y</strong></th>
										 <th align="center"><strong></strong></th>';
							}elseif($lista["spill_kit"] == 0){
								$html.='<th align="center"><strong></strong></th>
										 <th align="center"><strong>X</strong></th>';					
							}else{
								$html.='<th align="center"><strong>N/A</strong></th>
										 <th align="center"><strong>N/A</strong></th>';													
							}
if($truck){
						$html.='<th align="center"><strong>Back drive shaft</strong></th>';
							if($lista["grease_end"] == 1){
								$html.= '<th align="center"><strong>Y</strong></th>
										 <th align="center"><strong></strong></th>';
							}elseif($lista["grease_end"] == 0){
								$html.='<th align="center"><strong></strong></th>
										 <th align="center"><strong>X</strong></th>';					
							}else{
								$html.='<th align="center"><strong>N/A</strong></th>
										 <th align="center"><strong>N/A</strong></th>';													
							}	
}
						$html.='</tr>';

if($truck){
						$html.='<tr>';
						$html.='<th colspan="3" rowspan="2"></th>';
						
						$html.='<th align="center"><strong>Grease 5th wheel</strong></th>';
							if($lista["grease"] == 1){
								$html.= '<th align="center"><strong>Y</strong></th>
										 <th align="center"><strong></strong></th>';
							}elseif($lista["grease"] == 0){
								$html.='<th align="center"><strong></strong></th>
										 <th align="center"><strong>X</strong></th>';					
							}else{
								$html.='<th align="center"><strong>N/A</strong></th>
										 <th align="center"><strong>N/A</strong></th>';													
							}


						$html.='</tr>';
						
						$html.='<tr>';
						
						$html.='<th align="center"><strong>Box hoist & hinge</strong></th>';
							if($lista["hoist"] == 1){
								$html.= '<th align="center"><strong>Y</strong></th>
										 <th align="center"><strong></strong></th>';
							}elseif($lista["hoist"] == 0){
								$html.='<th align="center"><strong></strong></th>
										 <th align="center"><strong>X</strong></th>';					
							}else{
								$html.='<th align="center"><strong>N/A</strong></th>
										 <th align="center"><strong>N/A</strong></th>';													
							}

						$html.='</tr>';
}
						
						$html.='<tr>';
						$html.= '<th colspan="6"><strong>Comments : </strong>' . $lista["comments"] . '</th>';
						$html.='</tr>';
						
						
if($lista["with_trailer"] == 1){
					$html.='<tr bgcolor="#337ab7" style="color:white;">
								<th colspan="6"><strong>TRAILER :  ' . $lista["trailer"] . '</strong></th>
							 </tr>';
						
						$html.='<tr>
								<th align="center"><strong>Lights</strong></th>';
							if($lista["trailer_lights"] == 1){
								$html.= '<th align="center"><strong>Y</strong></th>
										 <th align="center"><strong></strong></th>';
							}elseif($lista["trailer_lights"] == 2){
								$html.='<th align="center"><strong></strong></th>
										 <th align="center"><strong>X</strong></th>';					
							}else{
								$html.='<th align="center"><strong>N/A</strong></th>
										 <th align="center"><strong>N/A</strong></th>';													
							}
					
						$html.='<th align="center"><strong>Tires</strong></th>';
							if($lista["trailer_tires"] == 1){
								$html.= '<th align="center"><strong>Y</strong></th>
										 <th align="center"><strong></strong></th>';
							}elseif($lista["trailer_tires"] == 2){
								$html.='<th align="center"><strong></strong></th>
										 <th align="center"><strong>X</strong></th>';					
							}else{
								$html.='<th align="center"><strong>N/A</strong></th>
										 <th align="center"><strong>N/A</strong></th>';													
							}
						$html.='</tr>';
						
						$html.='<tr>
								<th align="center"><strong>Clean</strong></th>';
							if($lista["trailer_clean"] == 1){
								$html.= '<th align="center"><strong>Y</strong></th>
										 <th align="center"><strong></strong></th>';
							}elseif($lista["trailer_clean"] == 2){
								$html.='<th align="center"><strong></strong></th>
										 <th align="center"><strong>X</strong></th>';					
							}else{
								$html.='<th align="center"><strong>N/A</strong></th>
										 <th align="center"><strong>N/A</strong></th>';													
							}
					
						$html.='<th align="center"><strong>Slings</strong></th>';
						$html.= '<th colspan="2" align="center"><strong>' . $lista["trailer_slings"] . '</strong></th>';
						$html.='</tr>';
						
						$html.='<tr>';
						$html.='<th align="center"><strong>Chains</strong></th>';
						$html.= '<th colspan="2" align="center"><strong>' . $lista["trailer_chains"] . '</strong></th>';
					
						$html.='<th align="center"><strong>Ratchet</strong></th>';
						$html.= '<th colspan="2" align="center"><strong>' . $lista["trailer_ratchet"] . '</strong></th>';
						$html.='</tr>';
							
						$html.='<tr>';
						$html.= '<th colspan="6"><strong>Comments : </strong>' . $lista["trailer_comments"] . '</th>';
						$html.='</tr>';
}
							
						$html.='</table>';
				
				$signature = '';
				if($lista['signature']){
					//$urlSignature = base_url($lista['signature']);
					$signature = '<img src="'.$lista['signature'].'" border="0" width="70" height="70" />';
				}
				$html.= '<br><br>';
				$html.= '<table border="1" cellspacing="0" cellpadding="5" width="40%">
						<tr>
							<th align="center" ><strong><p>Driver</p></strong></th>
							<th align="center">' . $signature . '</th>
						</tr>
						<tr bgcolor="#337ab7" style="color:white;">
							<th align="center" ><strong>Name</strong></th>
							<th align="center"><strong>' . $lista['name']. '</strong></th>
						</tr>
						</table>';						
		
				// output the HTML content
				$pdf->writeHTML($html, true, false, true, false, '');
			
			endforeach;
			// Print some HTML Cells


			// reset pointer to the last page
			$pdf->lastPage();


			//Close and output PDF document
			$pdf->Output('daily_inspection.pdf', 'I');

			//============================================================+
			// END OF FILE
			//============================================================+
		
	}

	/**
	 * Generate Inspection Heavy Report in PDF
	 * @param int $idEmployee
	 * @param date $from
	 * @param date $to
	 * @param date $idInspection
     * @since 9/01/2017
	 * @review 29/01/2017
	 * @review 1/02/2018
     * @author BMOTTAG
	 */
	public function generaInsectionHeavyPDF($idEmployee, $idVehicle, $from, $to, $idInspection='x')
	{
			$this->load->library('Pdf');
			
			// create new PDF document
			$pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);

			// set document information
			$pdf->SetCreator(PDF_CREATOR);
			$pdf->SetAuthor('VCI');
			$pdf->SetTitle('Inspection Report');
			$pdf->SetSubject('TCPDF Tutorial');

			// set default header data
			$pdf->SetHeaderData(PDF_HEADER_LOGO, PDF_HEADER_LOGO_WIDTH, '', PDF_HEADER_STRING, array(0,64,255), array(0,64,128));

			// set header and footer fonts
			$pdf->setHeaderFont(Array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));
			$pdf->setFooterFont(Array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));

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
			if (@file_exists(dirname(__FILE__).'/lang/eng.php')) {
				require_once(dirname(__FILE__).'/lang/eng.php');
				$pdf->setLanguageArray($l);
			}

			// ---------------------------------------------------------

			// set font
			$pdf->SetFont('dejavusans', '', 8);

			// writeHTML($html, $ln=true, $fill=false, $reseth=false, $cell=false, $align='')
			// writeHTMLCell($w, $h, $x, $y, $html='', $border=0, $ln=0, $fill=0, $reseth=true, $align='', $autopadding=true)
			
			$arrParam = array(
				"employee" => $idEmployee,
				"vehicleId" => $idVehicle,
				"from" => $from,
				"to" => $to,
				"idInspection" => $idInspection
			);
			$data['info'] = $this->report_model->get_heavy_inspection($arrParam);
			
			// - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
			// Print a table
			$data['consecutivo'] = 0;
			$html = "";
			foreach ($data['info'] as $lista):
				
				// add a page
				$pdf->AddPage();

				$html = $this->load->view($lista['form'], $data, true);
											
				// output the HTML content
				$pdf->writeHTML($html, true, false, true, false, '');
		
				$data['consecutivo']++;
			endforeach;
			// Print some HTML Cells

			// reset pointer to the last page
			$pdf->lastPage();


			//Close and output PDF document
			$pdf->Output('heavy_inspection.pdf', 'I');

			//============================================================+
			// END OF FILE
			//============================================================+
		
	}	
	
	/**
	 * Generate Inspection Specail Report in PDF
	 * @param int $idEmployee
	 * @param int $idVehicle
	 * @param date $from
	 * @param date $to
	 * @param date $idInspection
     * @since 23/04/2017
	 * @review 1/02/2018
     * @author BMOTTAG
	 */
	public function generaInsectionSpecialPDF($idEmployee, $idVehicle, $from, $to, $type, $idInspection='x')
	{
			$this->load->library('Pdf');
			
			// create new PDF document
			$pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);

			// set document information
			$pdf->SetCreator(PDF_CREATOR);
			$pdf->SetAuthor('VCI');
			$pdf->SetTitle('Inspection Report');
			$pdf->SetSubject('TCPDF Tutorial');

			// set default header data
			$pdf->SetHeaderData(PDF_HEADER_LOGO, PDF_HEADER_LOGO_WIDTH, '', PDF_HEADER_STRING, array(0,64,255), array(0,64,128));

			// set header and footer fonts
			$pdf->setHeaderFont(Array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));
			$pdf->setFooterFont(Array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));

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
			if (@file_exists(dirname(__FILE__).'/lang/eng.php')) {
				require_once(dirname(__FILE__).'/lang/eng.php');
				$pdf->setLanguageArray($l);
			}

			// ---------------------------------------------------------

			// set font
			$pdf->SetFont('dejavusans', '', 8);

			// writeHTML($html, $ln=true, $fill=false, $reseth=false, $cell=false, $align='')
			// writeHTMLCell($w, $h, $x, $y, $html='', $border=0, $ln=0, $fill=0, $reseth=true, $align='', $autopadding=true)
			
			$arrParam = array(
				"employee" => $idEmployee,
				"vehicleId" => $idVehicle,
				"from" => $from,
				"to" => $to,
				"idInspection" => $idInspection
			);
						
			switch ($type) {
				case 'watertruck':
					$data['info'] = $this->report_model->get_water_truck_inspection($arrParam);
					break;
				case 'hydrovac':
					$data['info'] = $this->report_model->get_hydrovac_inspection($arrParam);
					break;
				case 'sweeper':
					$data['info'] = $this->report_model->get_sweeper_inspection($arrParam);
					break;
				case 'generator':
					$data['info'] = $this->report_model->get_generator_inspection($arrParam);
					break;
			}
			
			// - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
			// Print a table
			$data['consecutivo'] = 0;
			$html = "";
			foreach ($data['info'] as $lista):
				
				// add a page
				$pdf->AddPage();

				$html = $this->load->view($lista['form'], $data, true);
											
				// output the HTML content
				$pdf->writeHTML($html, true, false, true, false, '');
		
				$data['consecutivo']++;
			endforeach;
			// Print some HTML Cells

			// reset pointer to the last page
			$pdf->lastPage();


			//Close and output PDF document
			$pdf->Output('special_inspection.pdf', 'I');

			//============================================================+
			// END OF FILE
			//============================================================+
		
	}

	/**
	 * Generate Payroll Report in PDF
	 * @param int $idUser
	 * @param date $from
	 * @param date $to
     * @since 16/01/2017
     * @author BMOTTAG
	 */
	public function generaPayrollPDF($idUser, $from, $to)
	{
			$this->load->library('Pdf');
			
			// create new PDF document
			$pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);

			// set document information
			$pdf->SetCreator(PDF_CREATOR);
			$pdf->SetAuthor('VCI');
			$pdf->SetTitle('Report');
			$pdf->SetSubject('TCPDF Tutorial');

			// set default header data
			$pdf->SetHeaderData(PDF_HEADER_LOGO, PDF_HEADER_LOGO_WIDTH, '', PDF_HEADER_STRING, array(0,64,255), array(0,64,128));

			// set header and footer fonts
			$pdf->setHeaderFont(Array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));
			$pdf->setFooterFont(Array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));

			// set default monospaced font
			$pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);

			// set margins
			$pdf->SetMargins(PDF_MARGIN_LEFT, PDF_MARGIN_TOP, PDF_MARGIN_RIGHT);
			$pdf->SetHeaderMargin(PDF_MARGIN_HEADER);
			$pdf->SetFooterMargin(PDF_MARGIN_FOOTER);

			// set auto page breaks
			$pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);

			// set image scale factor
			$pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);

			// set some language-dependent strings (optional)
			if (@file_exists(dirname(__FILE__).'/lang/eng.php')) {
				require_once(dirname(__FILE__).'/lang/eng.php');
				$pdf->setLanguageArray($l);
			}

			// ---------------------------------------------------------

			// set font
			$pdf->SetFont('dejavusans', '', 7);

			// add a page
			$pdf->AddPage();

			// writeHTML($html, $ln=true, $fill=false, $reseth=false, $cell=false, $align='')
			// writeHTMLCell($w, $h, $x, $y, $html='', $border=0, $ln=0, $fill=0, $reseth=true, $align='', $autopadding=true)

			//$idUser = $idUser=='x'?'':$idUser;
			$arrParam = array(
				"from" => $from,
				"to" => $to,
				"employee" => $idUser
			);

			$info = $this->report_model->get_payroll($arrParam);

			// - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
			// Print a table

			// create some HTML content
			$html = '<h1 align="center" style="color:#337ab7;">PAYROLL REPORT</h1>
					<p style="color:#337ab7;"><strong><i>From Date: </i></strong>' . $from . '<br>
					<strong><i>To Date: </i></strong>' . $to . '</p>
						<style>
						table {
							font-family: arial, sans-serif;
							border-collapse: collapse;
							width: 100%;
						}

						td, th {
							border: 1px solid #dddddd;
							text-align: left;
							padding: 8px;
						}
						</style>
						
				<table border="0" cellspacing="1" cellpadding="3">
					<tr bgcolor="#337ab7" style="color:white;">
						<th rowspan="2" align="center" width="12%"><strong>Employee Name</strong></th>
						<th colspan="2" align="center" width="17%"><strong>Date & Time</strong></th>
						<th colspan="2" align="center" width="20%"><strong>Job</strong></th>
						<th rowspan="2" align="center" width="8%"><strong>Working Hours</strong></th>
						<th rowspan="2" align="center" width="7%"><strong>Total Hours</strong></th>
						<th rowspan="2" align="center" width="15%"><strong>Task description</strong></th>						
						<th rowspan="2" align="center" width="21%"><strong>Observation</strong></th>						
					</tr>
					<tr bgcolor="#337ab7" style="color:white;">
						<th align="center"><strong>In</strong></th>
						<th align="center"><strong>Out</strong></th>
						<th align="center"><strong>Start</strong></th>
						<th align="center"><strong>Finish</strong></th>						
					</tr>
					';

					$total = 0;
					foreach ($info as $data):
						$html.= '<tr>';					
						$html.= '<th >' . $data['name'] . '</th>';
						
						$html.= '<th align="center">' . $data['start'] . '</th>';
						$html.= '<th align="center">' . $data['finish'] . '</th>';
						$html.= '<th>' . $data['job_start'] . '</th>';
						$html.= '<th>' . $data['job_finish'] . '</th>';
						$html.= '<th align="center">' . $data['working_hours']  . '</th>';
						$total = $data['working_hours'] + $total;
						$html.= '<th align="center">' . $total . '</th>';
						$html.= '<th>' . $data['task_description'] . '</th>';
						$html.= '<th>' . $data['observation'] . '</th>';
						$html.= '</tr>';
					endforeach;

			$html.= "</table><br><br>";
					

			
	
			// output the HTML content
			$pdf->writeHTML($html, true, false, true, false, '');

			// Print some HTML Cells


			// reset pointer to the last page
			$pdf->lastPage();


			//Close and output PDF document
			$pdf->Output('payroll.pdf', 'I');

			//============================================================+
			// END OF FILE
			//============================================================+
		
	}
	
	/**
	 * Generate Work Order Report in PDF
	 * @param int $idWorkOrder
     * @since 26/01/2017
     * @author BMOTTAG
	 */
	public function generaWorkOrderPDF($idWorkOrder)
	{
			$this->load->library('Pdf');
			
			// create new PDF document
			$pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);

			// set document information
			$pdf->SetCreator(PDF_CREATOR);
			$pdf->SetAuthor('VCI');
			$pdf->SetTitle('Work Order Report');
			$pdf->SetSubject('TCPDF Tutorial');

			// set default header data
			$pdf->SetHeaderData(PDF_HEADER_LOGO, PDF_HEADER_LOGO_WIDTH, '', PDF_HEADER_STRING, array(0,64,255), array(0,64,128));

			// set header and footer fonts
			$pdf->setHeaderFont(Array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));
			$pdf->setFooterFont(Array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));

			// set default monospaced font
			$pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);

			// set margins
			$pdf->SetMargins(PDF_MARGIN_LEFT, PDF_MARGIN_TOP, PDF_MARGIN_RIGHT);
			$pdf->SetHeaderMargin(PDF_MARGIN_HEADER);
			$pdf->SetFooterMargin(PDF_MARGIN_FOOTER);

			// set auto page breaks
			$pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);

			// set image scale factor
			$pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);

			// set some language-dependent strings (optional)
			if (@file_exists(dirname(__FILE__).'/lang/eng.php')) {
				require_once(dirname(__FILE__).'/lang/eng.php');
				$pdf->setLanguageArray($l);
			}

			// ---------------------------------------------------------

			// set font
			$pdf->SetFont('dejavusans', '', 8);

			// add a page
			$pdf->AddPage();

			// writeHTML($html, $ln=true, $fill=false, $reseth=false, $cell=false, $align='')
			// writeHTMLCell($w, $h, $x, $y, $html='', $border=0, $ln=0, $fill=0, $reseth=true, $align='', $autopadding=true)

			$arrParam['idWorkOrder'] = $idWorkOrder;
			$workOrder = $this->report_model->get_workorder($arrParam);
			
			$workorderPersonal = $this->report_model->get_workorder_personal($idWorkOrder);//workorder personal list
			$workorderMaterials = $this->report_model->get_workorder_materials($idWorkOrder);//workorder material list
			$workorderEquipment = $this->report_model->get_workorder_equipment($idWorkOrder);//workorder equipment list

			// - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
			// Print a table

			// create some HTML content
			$html = '<h1 style="color:#337ab7;">WORK ORDER</h1><p></p><p>
						<style>
						table {
							font-family: arial, sans-serif;
							border-collapse: collapse;
							width: 100%;
						}

						td, th {
							border: 1px solid #dddddd;
							text-align: left;
							padding: 8px;
						}
						</style>
						<table cellspacing="0" cellpadding="5">
							<tr>
								<th bgcolor="#dddddd" ><strong>Work Order #: </strong></th>
								<th >' . $workOrder[0]['id_workorder']. '</th>
								<th bgcolor="#dddddd" ><strong>Date work order: </strong></th>
								<th >' . $workOrder[0]['date']. '</th>
							</tr>
							<tr>
								<th bgcolor="#dddddd" ><strong>Supervisor: </strong></th>
								<th >' . $workOrder[0]['name']. '</th>
								<th bgcolor="#dddddd" ><strong>Date of Issue: </strong></th>
								<th >' . $workOrder[0]['date_issue']. '</th>
							</tr>
							<tr>
								<th bgcolor="#dddddd" ><strong>Observation: </strong></th>
								<th colspan="3" >' . $workOrder[0]['observation']. '</th>
							</tr>
						</table>
					</p>';
					
			$html .= '<table border="1" cellspacing="0" cellpadding="5">
					<tr>
						<th colspan="5"><strong>PERSONAL</strong></th>
					</tr>
					<tr bgcolor="#dddddd">
						<th width="5%" align="center"><strong>#</strong></th>
						<th width="40%" align="center"><strong>Employee Name</strong></th>
						<th width="15%" align="center"><strong>Employee Type</strong></th>
						<th width="10%" align="center"><strong>Hours</strong></th>
						<th width="20%" align="center"><strong>Description</strong></th>
					</tr>';
				if(!$workorderPersonal){
						$html.= '<tr>';					
						$html.= '<th colspan="5" align="center"> ---- No data was found for Personal -----</th>';
						$html.= '</tr>';					
				}else{
					$i = 0;
					foreach ($workorderPersonal as $data):
						$i++;
						$html.= '<tr>';					
						$html.= '<th align="center">' . $i . '</th>';
						$html.= '<th>' . $data['name'] . '</th>';					
						$html.= '<th align="center">' . $data['type']  . '</th>';
						$html.= '<th align="center">' . $data['hours']  . '</th>';
						$html.= '<th >' . $data['description']  . '</th>';
						$html.= '</tr>';
					endforeach;
				}
			$html.= "</table><br><br>";
			
			$html .= '<table border="1" cellspacing="0" cellpadding="5">
					<tr>
						<th colspan="4"><strong>MATERIALS</strong></th>
					</tr>
					<tr bgcolor="#dddddd">
						<th width="5%" align="center"><strong>#</strong></th>
						<th width="25%" align="center"><strong>Material</strong></th>
						<th width="15%" align="center"><strong>Quantity</strong></th>
						<th width="35%" align="center"><strong>Description</strong></th>
					</tr>';
				if(!$workorderMaterials){
						$html.= '<tr>';					
						$html.= '<th colspan="5" align="center"> ---- No data was found for Personal -----</th>';
						$html.= '</tr>';					
				}else{
					$i = 0;
					foreach ($workorderMaterials as $data):
						$i++;
						$html.= '<tr>';					
						$html.= '<th align="center">' . $i . '</th>';
						$html.= '<th>' . $data['material'] . '</th>';					
						$html.= '<th>' . $data['quantity']  . '</th>';
						$html.= '<th >' . $data['description']  . '</th>';
						$html.= '</tr>';
					endforeach;
				}
			$html.= "</table><br><br>";
			

			
	

	

			

			// output the HTML content
			$pdf->writeHTML($html, true, false, true, false, '');



			// reset pointer to the last page
			$pdf->lastPage();

			// ---------------------------------------------------------

			//Close and output PDF document
			$pdf->Output('work_order.pdf', 'I');

			//============================================================+
			// END OF FILE
			//============================================================+
		
	}
	
	/**
	 * Generate Payroll Report in XLS
	 * @param int $idUser
	 * @param date $from
	 * @param date $to
     * @since 27/01/2017
     * @author BMOTTAG
	 */
	public function generaPayrollXLS($idUser, $from, $to)
	{
			$data['from'] = $from;
			$data['to'] = $to;
				
			//$idUser = $idUser=='x'?'':$idUser;
			$arrParam = array(
				"from" => $from,
				"to" => $to,
				"employee" => $idUser
			);

			$info = $this->report_model->get_payroll($arrParam);


			// Create new PHPExcel object	
			$objPHPExcel = new PHPExcel();

			// Set document properties
			$objPHPExcel->getProperties()->setCreator("VCI APP")
										 ->setLastModifiedBy("VCI APP")
										 ->setTitle("Report")
										 ->setSubject("Report")
										 ->setDescription("VCI Report.")
										 ->setKeywords("office 2007 openxml php")
										 ->setCategory("Report");
										 
			// Create a first sheet
			$dateRange = $from . '-' . $to;
			$objPHPExcel->setActiveSheetIndex(0);
			$objPHPExcel->getActiveSheet()->setCellValue('A1', 'PAYROLL REPORT');
			
			$objPHPExcel->getActiveSheet()->setCellValue('A2', 'Date Range:')
										->setCellValue('B2', $dateRange);
			
			$objPHPExcel->getActiveSheet()->setCellValue('A4', 'Employee Name')
										->setCellValue('B4', 'Time In')
										->setCellValue('C4', 'Time Out')
										->setCellValue('D4', 'Job Start')
										->setCellValue('E4', 'Job Finish')
										->setCellValue('F4', 'Task Description')
										->setCellValue('G4', 'Observation')
										->setCellValue('H4', 'Working Hours')
										->setCellValue('I4', 'Total Hours');
										
			$j=5;
			$total = 0;
			foreach ($info as $data):
					$total = $data['working_hours'] + $total;
					$objPHPExcel->getActiveSheet()->setCellValue('A'.$j, $data['name'])
												  ->setCellValue('B'.$j, $data['start'])
												  ->setCellValue('C'.$j, $data['finish'])
												  ->setCellValue('D'.$j, $data['job_start'])
												  ->setCellValue('E'.$j, $data['job_finish'])
												  ->setCellValue('F'.$j, $data['task_description'])
												  ->setCellValue('G'.$j, $data['observation'])
												  ->setCellValue('H'.$j, $data['working_hours'])
												  ->setCellValue('I'.$j, $total);
					$j++;
			endforeach;         

			// Set column widths							  
			$objPHPExcel->getActiveSheet()->getColumnDimension('A')->setWidth(23);
			$objPHPExcel->getActiveSheet()->getColumnDimension('B')->setWidth(20);
			$objPHPExcel->getActiveSheet()->getColumnDimension('C')->setWidth(20);
			$objPHPExcel->getActiveSheet()->getColumnDimension('D')->setWidth(30);
			$objPHPExcel->getActiveSheet()->getColumnDimension('E')->setWidth(30);
			$objPHPExcel->getActiveSheet()->getColumnDimension('F')->setWidth(30);
			$objPHPExcel->getActiveSheet()->getColumnDimension('G')->setWidth(30);
			$objPHPExcel->getActiveSheet()->getColumnDimension('H')->setWidth(15);
			$objPHPExcel->getActiveSheet()->getColumnDimension('I')->setWidth(15);

			// Add conditional formatting
			$objConditional1 = new PHPExcel_Style_Conditional();
			$objConditional1->setConditionType(PHPExcel_Style_Conditional::CONDITION_CELLIS)
							->setOperatorType(PHPExcel_Style_Conditional::OPERATOR_BETWEEN)
							->addCondition('200')
							->addCondition('400');
			$objConditional1->getStyle()->getFont()->getColor()->setARGB(PHPExcel_Style_Color::COLOR_YELLOW);
			$objConditional1->getStyle()->getFont()->setBold(true);
			$objConditional1->getStyle()->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_CURRENCY_EUR_SIMPLE);

			$objConditional2 = new PHPExcel_Style_Conditional();
			$objConditional2->setConditionType(PHPExcel_Style_Conditional::CONDITION_CELLIS)
							->setOperatorType(PHPExcel_Style_Conditional::OPERATOR_LESSTHAN)
							->addCondition('0');
			$objConditional2->getStyle()->getFont()->getColor()->setARGB(PHPExcel_Style_Color::COLOR_RED);
			$objConditional2->getStyle()->getFont()->setItalic(true);
			$objConditional2->getStyle()->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_CURRENCY_EUR_SIMPLE);

			$objConditional3 = new PHPExcel_Style_Conditional();
			$objConditional3->setConditionType(PHPExcel_Style_Conditional::CONDITION_CELLIS)
							->setOperatorType(PHPExcel_Style_Conditional::OPERATOR_GREATERTHANOREQUAL)
							->addCondition('0');
			$objConditional3->getStyle()->getFont()->getColor()->setARGB(PHPExcel_Style_Color::COLOR_GREEN);
			$objConditional3->getStyle()->getFont()->setItalic(true);
			$objConditional3->getStyle()->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_CURRENCY_EUR_SIMPLE);

			$conditionalStyles = $objPHPExcel->getActiveSheet()->getStyle('B2')->getConditionalStyles();
			array_push($conditionalStyles, $objConditional1);
			array_push($conditionalStyles, $objConditional2);
			array_push($conditionalStyles, $objConditional3);
			$objPHPExcel->getActiveSheet()->getStyle('B2')->setConditionalStyles($conditionalStyles);

			//	duplicate the conditional styles across a range of cells
			$objPHPExcel->getActiveSheet()->duplicateConditionalStyle(
							$objPHPExcel->getActiveSheet()->getStyle('B2')->getConditionalStyles(),
							'B3:B7'
						  );

			// Set fonts			  
			$objPHPExcel->getActiveSheet()->getStyle('A1')->getFont()->setBold(true);
			$objPHPExcel->getActiveSheet()->getStyle('A2')->getFont()->setBold(true);
			$objPHPExcel->getActiveSheet()->getStyle('A4:I4')->getFont()->setBold(true);

			// Set header and footer. When no different headers for odd/even are used, odd header is assumed.
			$objPHPExcel->getActiveSheet()->getHeaderFooter()->setOddHeader('&L&BPersonal cash register&RPrinted on &D');
			$objPHPExcel->getActiveSheet()->getHeaderFooter()->setOddFooter('&L&B' . $objPHPExcel->getProperties()->getTitle() . '&RPage &P of &N');

			// Set page orientation and size
			$objPHPExcel->getActiveSheet()->getPageSetup()->setOrientation(PHPExcel_Worksheet_PageSetup::ORIENTATION_PORTRAIT);
			$objPHPExcel->getActiveSheet()->getPageSetup()->setPaperSize(PHPExcel_Worksheet_PageSetup::PAPERSIZE_A4);

			// Rename worksheet
			$userName = $info[0]['name'];
			$objPHPExcel->getActiveSheet()->setTitle($userName);

			// Set active sheet index to the first sheet, so Excel opens this as the first sheet
			$objPHPExcel->setActiveSheetIndex(0);

			// redireccionamos la salida al navegador del cliente (Excel2007)
			header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
			header('Content-Disposition: attachment;filename="payroll.xlsx"');
			header('Cache-Control: max-age=0');
			 
			$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
			$objWriter->save('php://output');
			  
    }
	
	/**
	 * Generate Hauling Report in XLS
	 * @param int $idCompany
	 * @param int $idMaterial
	 * @param date $from
	 * @param date $to
     * @since 8/05/2017
     * @author BMOTTAG
	 */
	public function generaHaulingXLS($idCompany, $idMaterial, $from, $to)
	{
			$data['from'] = $from;
			$data['to'] = $to;
				
			$arrParam = array(
				"company" => $idCompany,
				"material" => $idMaterial,
				"from" => $from,
				"to" => $to
			);
			$info = $this->report_model->get_hauling($arrParam);

			// Create new PHPExcel object	
			$objPHPExcel = new PHPExcel();

			// Set document properties
			$objPHPExcel->getProperties()->setCreator("VCI APP")
										 ->setLastModifiedBy("VCI APP")
										 ->setTitle("Report")
										 ->setSubject("Report")
										 ->setDescription("VCI Report.")
										 ->setKeywords("office 2007 openxml php")
										 ->setCategory("Report");
										 
			// Create a first sheet
			$dateRange = $from . '-' . $to;
			$objPHPExcel->setActiveSheetIndex(0);
			$objPHPExcel->getActiveSheet()->setCellValue('A1', 'HAULING REPORT');
			
			$objPHPExcel->getActiveSheet()->setCellValue('A2', 'Date Range:')
										->setCellValue('B2', $dateRange);
			
			$objPHPExcel->getActiveSheet()->setCellValue('A4', 'Hauling done by')
										->setCellValue('B4', 'Employee')
										->setCellValue('C4', 'Truck - Unit Number')
										->setCellValue('D4', 'Truck Type')
										->setCellValue('E4', 'Plate')
										->setCellValue('F4', 'Material Type')
										->setCellValue('G4', 'From Site')
										->setCellValue('H4', 'To Site')
										->setCellValue('I4', 'Payment')
										->setCellValue('J4', 'Date of Issue')
										->setCellValue('K4', 'Time In')
										->setCellValue('L4', 'Time Out')
										->setCellValue('M4', 'Comments');
										
			$j=5;
			$total = 0;
			foreach ($info as $data):
					$objPHPExcel->getActiveSheet()->setCellValue('A'.$j, $data['company_name'])
												  ->setCellValue('B'.$j, $data['name'])
												  ->setCellValue('C'.$j, $data['unit_number'])
												  ->setCellValue('D'.$j, $data['truck_type'])
												  ->setCellValue('E'.$j, $data['plate'])
												  ->setCellValue('F'.$j, $data['material'])
												  ->setCellValue('G'.$j, $data['site_from'])
												  ->setCellValue('H'.$j, $data['site_to'])
												  ->setCellValue('I'.$j, $data['payment'])
												  ->setCellValue('J'.$j, $data['date_issue'])
												  ->setCellValue('K'.$j, $data['time_in'])
												  ->setCellValue('L'.$j, $data['time_out'])
												  ->setCellValue('M'.$j, $data['comments']);
					$j++;
			endforeach;         

			// Set column widths							  
			$objPHPExcel->getActiveSheet()->getColumnDimension('A')->setWidth(23);
			$objPHPExcel->getActiveSheet()->getColumnDimension('B')->setWidth(20);
			$objPHPExcel->getActiveSheet()->getColumnDimension('C')->setWidth(20);
			$objPHPExcel->getActiveSheet()->getColumnDimension('D')->setWidth(30);
			$objPHPExcel->getActiveSheet()->getColumnDimension('E')->setWidth(30);
			$objPHPExcel->getActiveSheet()->getColumnDimension('F')->setWidth(30);
			$objPHPExcel->getActiveSheet()->getColumnDimension('G')->setWidth(30);
			$objPHPExcel->getActiveSheet()->getColumnDimension('H')->setWidth(15);
			$objPHPExcel->getActiveSheet()->getColumnDimension('I')->setWidth(15);
			$objPHPExcel->getActiveSheet()->getColumnDimension('J')->setWidth(15);
			$objPHPExcel->getActiveSheet()->getColumnDimension('K')->setWidth(15);
			$objPHPExcel->getActiveSheet()->getColumnDimension('L')->setWidth(30);

			// Add conditional formatting
			$objConditional1 = new PHPExcel_Style_Conditional();
			$objConditional1->setConditionType(PHPExcel_Style_Conditional::CONDITION_CELLIS)
							->setOperatorType(PHPExcel_Style_Conditional::OPERATOR_BETWEEN)
							->addCondition('200')
							->addCondition('400');
			$objConditional1->getStyle()->getFont()->getColor()->setARGB(PHPExcel_Style_Color::COLOR_YELLOW);
			$objConditional1->getStyle()->getFont()->setBold(true);
			$objConditional1->getStyle()->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_CURRENCY_EUR_SIMPLE);

			$objConditional2 = new PHPExcel_Style_Conditional();
			$objConditional2->setConditionType(PHPExcel_Style_Conditional::CONDITION_CELLIS)
							->setOperatorType(PHPExcel_Style_Conditional::OPERATOR_LESSTHAN)
							->addCondition('0');
			$objConditional2->getStyle()->getFont()->getColor()->setARGB(PHPExcel_Style_Color::COLOR_RED);
			$objConditional2->getStyle()->getFont()->setItalic(true);
			$objConditional2->getStyle()->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_CURRENCY_EUR_SIMPLE);

			$objConditional3 = new PHPExcel_Style_Conditional();
			$objConditional3->setConditionType(PHPExcel_Style_Conditional::CONDITION_CELLIS)
							->setOperatorType(PHPExcel_Style_Conditional::OPERATOR_GREATERTHANOREQUAL)
							->addCondition('0');
			$objConditional3->getStyle()->getFont()->getColor()->setARGB(PHPExcel_Style_Color::COLOR_GREEN);
			$objConditional3->getStyle()->getFont()->setItalic(true);
			$objConditional3->getStyle()->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_CURRENCY_EUR_SIMPLE);

			$conditionalStyles = $objPHPExcel->getActiveSheet()->getStyle('B2')->getConditionalStyles();
			array_push($conditionalStyles, $objConditional1);
			array_push($conditionalStyles, $objConditional2);
			array_push($conditionalStyles, $objConditional3);
			$objPHPExcel->getActiveSheet()->getStyle('B2')->setConditionalStyles($conditionalStyles);

			//	duplicate the conditional styles across a range of cells
			$objPHPExcel->getActiveSheet()->duplicateConditionalStyle(
							$objPHPExcel->getActiveSheet()->getStyle('B2')->getConditionalStyles(),
							'B3:B7'
						  );

			// Set fonts			  
			$objPHPExcel->getActiveSheet()->getStyle('A1')->getFont()->setBold(true);
			$objPHPExcel->getActiveSheet()->getStyle('A2')->getFont()->setBold(true);
			$objPHPExcel->getActiveSheet()->getStyle('A4:L4')->getFont()->setBold(true);

			// Set header and footer. When no different headers for odd/even are used, odd header is assumed.
			$objPHPExcel->getActiveSheet()->getHeaderFooter()->setOddHeader('&L&BPersonal cash register&RPrinted on &D');
			$objPHPExcel->getActiveSheet()->getHeaderFooter()->setOddFooter('&L&B' . $objPHPExcel->getProperties()->getTitle() . '&RPage &P of &N');

			// Set page orientation and size
			$objPHPExcel->getActiveSheet()->getPageSetup()->setOrientation(PHPExcel_Worksheet_PageSetup::ORIENTATION_PORTRAIT);
			$objPHPExcel->getActiveSheet()->getPageSetup()->setPaperSize(PHPExcel_Worksheet_PageSetup::PAPERSIZE_A4);

			// Rename worksheet
			$objPHPExcel->getActiveSheet()->setTitle("Hauling");

			// Set active sheet index to the first sheet, so Excel opens this as the first sheet
			$objPHPExcel->setActiveSheetIndex(0);

			// redireccionamos la salida al navegador del cliente (Excel2007)
			header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
			header('Content-Disposition: attachment;filename="hauling.xlsx"');
			header('Cache-Control: max-age=0');
			 
			$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
			$objWriter->save('php://output');
			  
    }
	
	/**
	 * Generate Payroll Report in XLS
	 * @param int $jobId
	 * @param date $from
	 * @param date $to
     * @since 30/01/2017
     * @author BMOTTAG
	 */
	public function generaWorkOrderXLS($jobId, $from, $to)
	{
			$data['from'] = $from;
			$data['to'] = $to;
				
			$jobId = $jobId=='x'?'':$jobId;
			$arrParam = array(
				"from" => $from,
				"to" => $to,
				"jobId" => $jobId
			);

			$info = $this->report_model->get_workorder($arrParam);

			// Create new PHPExcel object	
			$objPHPExcel = new PHPExcel();

			// Set document properties
			$objPHPExcel->getProperties()->setCreator("VCI APP")
										 ->setLastModifiedBy("VCI APP")
										 ->setTitle("Report")
										 ->setSubject("Report")
										 ->setDescription("VCI Report.")
										 ->setKeywords("office 2007 openxml php")
										 ->setCategory("Report");
										 
			// Create a first sheet
			$dateRange = $from . '-' . $to;
			$objPHPExcel->setActiveSheetIndex(0);
			$objPHPExcel->getActiveSheet()->setCellValue('A1', 'WORK ORDER REPORT');
			
			$objPHPExcel->getActiveSheet()->setCellValue('A2', 'Date Range:')
										->setCellValue('B2', $dateRange);
			
			$objPHPExcel->getActiveSheet()->setCellValue('A4', 'Work Order #')
										->setCellValue('B4', 'Supervisor')
										->setCellValue('C4', 'Date of Issue')
										->setCellValue('D4', 'Date Work Order')
										->setCellValue('E4', 'Job Code/Name')
										->setCellValue('F4', 'Observation')
										->setCellValue('G4', 'Employee Name')
										->setCellValue('H4', 'Employee Type')
										->setCellValue('I4', 'Material')
										->setCellValue('J4', 'Equipment')
										->setCellValue('K4', 'Hours')
										->setCellValue('L4', 'Quantity')
										->setCellValue('M4', 'Unit')
										->setCellValue('N4', 'Rate')
										->setCellValue('O4', 'Value')
										->setCellValue('P4', 'Task Description');
										
			$j=5;
			$total = 0; 
			foreach ($info as $data):
					
				$idWorkOrder = $data['id_workorder'];
				$workorderPersonal = $this->report_model->get_workorder_personal($idWorkOrder);//workorder personal list
				$workorderMaterials = $this->report_model->get_workorder_materials($idWorkOrder);//workorder material list
				$workorderEquipment = $this->report_model->get_workorder_equipment($idWorkOrder);//workorder equipment list
				$workorderOcasional = $this->report_model->get_workorder_ocasional($idWorkOrder);//workorder ocasional list

				$observation = $data['observation']?$data['observation']:'';
				if($workorderPersonal){
					foreach ($workorderPersonal as $infoP):
						$objPHPExcel->getActiveSheet()->setCellValue('A'.$j, $data['id_workorder'])
													  ->setCellValue('B'.$j, $data['name'])
													  ->setCellValue('C'.$j, $data['date_issue'])
													  ->setCellValue('D'.$j, $data['date'])
													  ->setCellValue('E'.$j, $data['job_description'])
													  ->setCellValue('F'.$j, $observation)
													  ->setCellValue('G'.$j, $infoP['name'])
													  ->setCellValue('H'.$j, $infoP['type'])
													  ->setCellValue('K'.$j, $infoP['hours'])
													  ->setCellValue('M'.$j, 'Hours')
													  ->setCellValue('N'.$j, $infoP['rate'])
													  ->setCellValue('O'.$j, $infoP['value'])
													  ->setCellValue('P'.$j, $infoP['description']);
						$j++;
					endforeach;
				}

				if($workorderMaterials){
					foreach ($workorderMaterials as $infoM):
						$objPHPExcel->getActiveSheet()->setCellValue('A'.$j, $data['id_workorder'])
													  ->setCellValue('B'.$j, $data['name'])
													  ->setCellValue('C'.$j, $data['date_issue'])
													  ->setCellValue('D'.$j, $data['date'])
													  ->setCellValue('E'.$j, $data['job_description'])
													  ->setCellValue('F'.$j, $observation)
													  ->setCellValue('I'.$j, $infoM['material'])
													  ->setCellValue('L'.$j, $infoM['quantity'])
													  ->setCellValue('M'.$j, $infoM['unit'])
													  ->setCellValue('N'.$j, $infoM['rate'])
													  ->setCellValue('O'.$j, $infoM['value'])
													  ->setCellValue('P'.$j, $infoM['description']);
						$j++;
					endforeach;
				}
		
				if($workorderEquipment){
					foreach ($workorderEquipment as $infoE):
									
						//si es tipo miscellaneous -> 8, entonces la description es diferente
						if($infoE['fk_id_type_2'] == 8){
							$equipment = $infoE['miscellaneous'] . " - " . $infoE['other'];
						}else{
							$equipment = $infoE['type_2'] . " - " . $infoE['unit_number'] . " - " . $infoE['v_description'];
						}
						
						$quantity = $infoE['quantity']==0?1:$infoE['quantity'];//cantidad si es cero es porque es 1
			
						$objPHPExcel->getActiveSheet()->setCellValue('A'.$j, $data['id_workorder'])
													  ->setCellValue('B'.$j, $data['name'])
													  ->setCellValue('C'.$j, $data['date_issue'])
													  ->setCellValue('D'.$j, $data['date'])
													  ->setCellValue('E'.$j, $data['job_description'])
													  ->setCellValue('F'.$j, $observation)
													  ->setCellValue('J'.$j, $equipment)
													  ->setCellValue('K'.$j, $infoE['hours'])
													  ->setCellValue('L'.$j, $quantity)
													  ->setCellValue('M'.$j, 'Hours')
													  ->setCellValue('N'.$j, $infoE['rate'])
													  ->setCellValue('O'.$j, $infoE['value'])
													  ->setCellValue('P'.$j, $infoE['description']);
						$j++;
					endforeach;
				}
			
				if($workorderOcasional){
					foreach ($workorderOcasional as $infoO):
						$equipment = $infoO['company_name'] . '-' . $infoO['equipment'];
						$hours = $infoO['hours']==0?1:$infoO['hours'];
						
						$objPHPExcel->getActiveSheet()->setCellValue('A'.$j, $data['id_workorder'])
													  ->setCellValue('B'.$j, $data['name'])
													  ->setCellValue('C'.$j, $data['date_issue'])
													  ->setCellValue('D'.$j, $data['date'])
													  ->setCellValue('E'.$j, $data['job_description'])
													  ->setCellValue('F'.$j, $observation)
													  
													  ->setCellValue('J'.$j, $equipment)
													  ->setCellValue('K'.$j, $hours)
													  ->setCellValue('L'.$j, $infoO['quantity'])
													  ->setCellValue('M'.$j, $infoO['unit'])
													  ->setCellValue('N'.$j, $infoO['rate'])
													  ->setCellValue('O'.$j, $infoO['value'])
													  ->setCellValue('P'.$j, $infoO['description']);
						$j++;
					endforeach;
				}
				
			endforeach;

			// Set column widths							  
			$objPHPExcel->getActiveSheet()->getColumnDimension('A')->setWidth(15);
			$objPHPExcel->getActiveSheet()->getColumnDimension('B')->setWidth(22);
			$objPHPExcel->getActiveSheet()->getColumnDimension('C')->setWidth(22);
			$objPHPExcel->getActiveSheet()->getColumnDimension('D')->setWidth(20);
			$objPHPExcel->getActiveSheet()->getColumnDimension('E')->setWidth(25);
			$objPHPExcel->getActiveSheet()->getColumnDimension('F')->setWidth(35);
			$objPHPExcel->getActiveSheet()->getColumnDimension('G')->setWidth(20);
			$objPHPExcel->getActiveSheet()->getColumnDimension('H')->setWidth(20);
			$objPHPExcel->getActiveSheet()->getColumnDimension('I')->setWidth(15);
			$objPHPExcel->getActiveSheet()->getColumnDimension('J')->setWidth(40);
			$objPHPExcel->getActiveSheet()->getColumnDimension('K')->setWidth(15);
			$objPHPExcel->getActiveSheet()->getColumnDimension('L')->setWidth(15);
			$objPHPExcel->getActiveSheet()->getColumnDimension('M')->setWidth(15);
			$objPHPExcel->getActiveSheet()->getColumnDimension('N')->setWidth(15);
			$objPHPExcel->getActiveSheet()->getColumnDimension('O')->setWidth(15);
			$objPHPExcel->getActiveSheet()->getColumnDimension('P')->setWidth(40);

			// Add conditional formatting
			$objConditional1 = new PHPExcel_Style_Conditional();
			$objConditional1->setConditionType(PHPExcel_Style_Conditional::CONDITION_CELLIS)
							->setOperatorType(PHPExcel_Style_Conditional::OPERATOR_BETWEEN)
							->addCondition('200')
							->addCondition('400');
			$objConditional1->getStyle()->getFont()->getColor()->setARGB(PHPExcel_Style_Color::COLOR_YELLOW);
			$objConditional1->getStyle()->getFont()->setBold(true);
			$objConditional1->getStyle()->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_CURRENCY_EUR_SIMPLE);

			$objConditional2 = new PHPExcel_Style_Conditional();
			$objConditional2->setConditionType(PHPExcel_Style_Conditional::CONDITION_CELLIS)
							->setOperatorType(PHPExcel_Style_Conditional::OPERATOR_LESSTHAN)
							->addCondition('0');
			$objConditional2->getStyle()->getFont()->getColor()->setARGB(PHPExcel_Style_Color::COLOR_RED);
			$objConditional2->getStyle()->getFont()->setItalic(true);
			$objConditional2->getStyle()->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_CURRENCY_EUR_SIMPLE);

			$objConditional3 = new PHPExcel_Style_Conditional();
			$objConditional3->setConditionType(PHPExcel_Style_Conditional::CONDITION_CELLIS)
							->setOperatorType(PHPExcel_Style_Conditional::OPERATOR_GREATERTHANOREQUAL)
							->addCondition('0');
			$objConditional3->getStyle()->getFont()->getColor()->setARGB(PHPExcel_Style_Color::COLOR_GREEN);
			$objConditional3->getStyle()->getFont()->setItalic(true);
			$objConditional3->getStyle()->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_CURRENCY_EUR_SIMPLE);

			$conditionalStyles = $objPHPExcel->getActiveSheet()->getStyle('B2')->getConditionalStyles();
			array_push($conditionalStyles, $objConditional1);
			array_push($conditionalStyles, $objConditional2);
			array_push($conditionalStyles, $objConditional3);
			$objPHPExcel->getActiveSheet()->getStyle('B2')->setConditionalStyles($conditionalStyles);

			//	duplicate the conditional styles across a range of cells
			$objPHPExcel->getActiveSheet()->duplicateConditionalStyle(
							$objPHPExcel->getActiveSheet()->getStyle('B2')->getConditionalStyles(),
							'B3:B7'
						  );

			// Set fonts			  
			$objPHPExcel->getActiveSheet()->getStyle('A1')->getFont()->setBold(true);
			$objPHPExcel->getActiveSheet()->getStyle('A2')->getFont()->setBold(true);
			$objPHPExcel->getActiveSheet()->getStyle('A4:P4')->getFont()->setBold(true);

			// Set header and footer. When no different headers for odd/even are used, odd header is assumed.
			$objPHPExcel->getActiveSheet()->getHeaderFooter()->setOddHeader('&L&BPersonal cash register&RPrinted on &D');
			$objPHPExcel->getActiveSheet()->getHeaderFooter()->setOddFooter('&L&B' . $objPHPExcel->getProperties()->getTitle() . '&RPage &P of &N');

			// Set page orientation and size
			$objPHPExcel->getActiveSheet()->getPageSetup()->setOrientation(PHPExcel_Worksheet_PageSetup::ORIENTATION_PORTRAIT);
			$objPHPExcel->getActiveSheet()->getPageSetup()->setPaperSize(PHPExcel_Worksheet_PageSetup::PAPERSIZE_A4);

			// Rename worksheet
			$objPHPExcel->getActiveSheet()->setTitle('Work Order');

			// Set active sheet index to the first sheet, so Excel opens this as the first sheet
			$objPHPExcel->setActiveSheetIndex(0);

			// redireccionamos la salida al navegador del cliente (Excel2007)
			header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
			header('Content-Disposition: attachment;filename="workorder.xlsx"');
			header('Cache-Control: max-age=0');
			 
			$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
			$objWriter->save('php://output');
			  
    }
	
	/**
	 * Info payroll con boton para editar horas
     * @since 5/6/2018
     * @author BMOTTAG
	 */
    public function botonEditHour($idPayroll) 
	{
			if (empty($idPayroll) ) {
				show_error('ERROR!!! - You are in the wrong place.');
			}
			
			$data["titulo"] = "<i class='fa fa-book fa-fw'></i> PAYROLL REPORT";
			$data["modulo"] ="payrollByAdmin";
			
			$arrParam = array("idPayroll" => $idPayroll);
			$data['info'] = $this->report_model->get_payroll($arrParam);
			$data["view"] = "list_payroll_v2";
			
			$this->load->view("layout", $data);
    }
	

	
	
	
	
	
	
	

	
}