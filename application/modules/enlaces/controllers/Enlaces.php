<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Enlaces extends CI_Controller {
	
    public function __construct() {
        parent::__construct();
        $this->load->model("enlaces_model");
		$this->load->helper('form');
    }
	
	/**
	 * Listado Menu
     * @since 30/3/2020
     * @author BMOTTAG
	 */
	public function menu()
	{
			$this->load->model("general_model");
			$arrParam = array();
			$data['info'] = $this->general_model->get_menu($arrParam);

			$data["view"] = 'menu';
			$this->load->view("layout", $data);
	}
	
    /**
     * Cargo modal - formulario menu
     * @since 30/3/2020
     */
    public function cargarModalMenu() 
	{
			header("Content-Type: text/plain; charset=utf-8"); //Para evitar problemas de acentos
			
			$data['information'] = FALSE;
			$data["idMenu"] = $this->input->post("idMenu");	
			
			if ($data["idMenu"] != 'x') {
				$this->load->model("general_model");
				$arrParam = array("idMenu" => $data["idMenu"]);
				$data['information'] = $this->general_model->get_menu($arrParam);
			}
			
			$this->load->view("menu_modal", $data);
    }
	
	/**
	 * Update Menu
     * @since 30/3/2020
     * @author BMOTTAG
	 */
	public function save_menu()
	{			
			header('Content-Type: application/json');
			$data = array();
			
			$idEnlace = $this->input->post('hddId');
			
			$msj = "You have add a new Menu link!!";
			if ($idEnlace != '') {
				$msj = "You have update a Menu link!!";
			}

			if ($this->enlaces_model->saveMenu()) {
				$data["result"] = true;
				$this->session->set_flashdata('retornoExito', $msj);
			} else {
				$data["result"] = "error";
				$this->session->set_flashdata('retornoError', '<strong>Error!!!</strong> Ask for help');
			}
//echo $this->db->last_query(); exit;
			echo json_encode($data);
    }
	
	/**
	 * Listado de enlaces
     * @since 2/4/2018
     * @author BMOTTAG
	 */
	public function index()
	{
			$this->load->model("general_model");
			$arrParam = array("tipoEnlace" => 1);
			$data['info'] = $this->general_model->get_enlaces($arrParam);
			
			$data["view"] = 'enlaces';
			$this->load->view("layout", $data);
	}
	
    /**
     * Cargo modal - formulario enlace
     * @since 2/4/2018
     */
    public function cargarModalEnlace() 
	{
			header("Content-Type: text/plain; charset=utf-8"); //Para evitar problemas de acentos
			
			$data['information'] = FALSE;
			$data["idEnlace"] = $this->input->post("idEnlace");	
			
			if ($data["idEnlace"] != 'x') {
				$this->load->model("general_model");
				$arrParam = array("idEnlace" => $data["idEnlace"]);
				$data['information'] = $this->general_model->get_enlaces($arrParam);
			}
			
			$this->load->view("enlaces_modal", $data);
    }
	
	/**
	 * Update Enlace
     * @since 2/4/2018
     * @author BMOTTAG
	 */
	public function save_enlace()
	{			
			header('Content-Type: application/json');
			$data = array();
			
			$idEnlace = $this->input->post('hddId');
			
			$msj = "You have add a new Link!!";
			if ($idEnlace != '') {
				$msj = "You have update a Link!!";
			}

			if ($this->enlaces_model->saveEnlace()) {
				$data["result"] = true;
				$this->session->set_flashdata('retornoExito', $msj);
			} else {
				$data["result"] = "error";
				$this->session->set_flashdata('retornoError', '<strong>Error!!!</strong> Ask for help');
			}

			echo json_encode($data);
    }
	
	/**
	 * Listado de enlaces para los manuales
     * @since 27/4/2018
     * @author BMOTTAG
	 */
	public function manuales()
	{
			$this->load->model("general_model");
			
			$arrParam = array("tipoEnlace" => 2);
			$data['info'] = $this->general_model->get_enlaces($arrParam);
			
			$data["view"] = 'enlaces_manuales';
			$this->load->view("layout", $data);
	}
	
	/**
	 * Form Upload Locates 
     * @since 27/4/2018
     * @author BMOTTAG
	 */
	public function manuales_form($idEnlace = 'x', $error = '')
	{			
			$data['information'] = FALSE;

			if ($idEnlace != 'x' && $idEnlace != '') {
				$this->load->model("general_model");
				$arrParam = array("idEnlace" => $idEnlace);
				$data['information'] = $this->general_model->get_enlaces($arrParam);
			}
			
			$data['error'] = $error; //se usa para mostrar los errores al cargar la imagen 			

			$data["view"] = "form_manuales";
			$this->load->view("layout", $data);
	}
	
	/**
	 * FUNCIÓN PARA SUBIR el archivo
	 */
    function do_upload_manual() 
	{
        $config['upload_path'] = './files/';
        $config['overwrite'] = false;
        $config['allowed_types'] = 'pdf';
        $config['max_size'] = '3000';
        $config['max_width'] = '2024';
        $config['max_height'] = '2008';
        $idEnlace = $this->input->post("hddId");

        $this->load->library('upload', $config);
        //SI EL ARCHIVO FALLA AL SUBIR MOSTRAMOS EL ERROR EN LA VISTA 
        if (!$this->upload->do_upload()) {
            $error = $this->upload->display_errors();
            $this->manuales_form($idEnlace,$error);
        } else {
            $file_info = $this->upload->data();//subimos ARCHIVO
			
			$data = array('upload_data' => $this->upload->data());
			$archivo = $file_info['file_name'];
			$path = base_url() . "files/" . $archivo;
			
			//insertar datos
			if($this->enlaces_model->saveManual($path))
			{
				$this->session->set_flashdata('retornoExito', 'You have upload the information.');
			}else{
				$this->session->set_flashdata('retornoError', '<strong>Error!!!</strong> Ask for help');
			}
						
			redirect('enlaces/manuales');
        }
    }
	
    /**
     * Delete Job locate
     */
    public function deleteManual($idJobLocate, $idJob) 
	{
			if (empty($idJobLocate) || empty($idJob) ) {
				show_error('ERROR!!! - You are in the wrong place.');
			}
		
			$arrParam = array(
				"table" => "job_locates",
				"primaryKey" => "id_job_locates",
				"id" => $idJobLocate
			);
			
			$this->load->model("general_model");
			if ($this->general_model->deleteRecord($arrParam)) {
				$this->session->set_flashdata('retornoExito', 'You have delete the image.');
			} else {
				$this->session->set_flashdata('retornoError', '<strong>Error!!!</strong> Ask for help');
			}
			redirect(base_url('jobs/locates/' . $idJob), 'refresh');
    }

	
	


	
}