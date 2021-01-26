<?php
defined('BASEPATH') OR exit('No direct script access allowed'); 

class Read extends CI_Controller{
	
	public function __construct(){
 
		parent::__construct();
		$this->load->helper('url');
		$this->load->library('pagination');
		$this->load->model('Read_Model');
	}
	
	public function index(){
		redirect('Read/getToDoData');
	}
	
	// Tüm kayıtları listele
	public function getToDoData($rowno=0)
	{
		// Search text 
		$search_text = "";
		$Submited_Date = "";
		
		if($this->input->post('submit') != NULL ){
			$search_text = $this->input->post('search');
			$Submited_Date = $this->input->post('SubmitedDate');
			$this->session->set_userdata(array("search"=>$search_text));
			$this->session->set_userdata(array("SubmitedDate"=>$Submited_Date));
		}
		
		if($this->input->post('Reset') != NULL ){
			$this->session->unset_userdata('search_text'); 
			$this->session->unset_userdata('Submited_Date');
			$search_text = "";
			$Submited_Date = "";
		}
			
		$rowperpage = 5;
		if($rowno != 0){
		  $rowno = ($rowno-1) * $rowperpage;
		}
	 
		$allcount = $this->Read_Model->getrecordCount($search_text);

		$results = $this->Read_Model->getData($rowno,$rowperpage,$search_text,$Submited_Date);
	 
		// Sayfalama işlemleri
		$config['base_url'] = base_url().'read/getToDoData';
		$config['use_page_numbers'] = TRUE;
		$config['total_rows'] = $allcount;
		$config['per_page'] = $rowperpage;
		
		$config['full_tag_open'] = '<ul class="pagination">';
        $config['full_tag_close'] = '</ul>';
        $config['num_tag_open'] = '<li class="page-item">';
        $config['num_tag_close'] = '</li>';
        $config['cur_tag_open'] = '<li class="page-item active"><a class="page-link" href="#">';
        $config['cur_tag_close'] = '</a></li>';
        $config['next_tag_open'] = '<li class="page-item">';
        $config['next_tagl_close'] = '</a></li>';
        $config['prev_tag_open'] = '<li class="page-item">';
        $config['prev_tagl_close'] = '</li>';
        $config['first_tag_open'] = '<li class="page-item disabled">';
        $config['first_tagl_close'] = '</li>';
        $config['last_tag_open'] = '<li class="page-item">';
        $config['last_tagl_close'] = '</a></li>';
        $config['attributes'] = array('class' => 'page-link');

		$this->pagination->initialize($config);
	 
		$data['pagination'] = $this->pagination->create_links();
		$data['result'] = $results;
		$data['row'] = $rowno;
		$data['search'] = $search_text;
		$data['SubmitedDate'] = $Submited_Date;

		$this->load->view('read',$data);
	}
	
	public function getDetail($id)
	{
		$reslt=$this->Read_Model->getDetail($id);
		$this->load->view('update',['row'=>$reslt]);
	}
	
	// Kayıt ekleme	
	public function insertToDo()
	{
		$this->form_validation->set_rules('toDo','To do','required');
		$this->form_validation->set_rules('SubmitedDate','Submited Date','required');

		if($this->form_validation->run()){
			$toDo = $this->input->post('toDo');
			$SubmitedDate = $this->input->post('SubmitedDate');
			$this->Read_Model->insertToDo($toDo,$SubmitedDate);
			$this->load->view('insert');
		} else {
			$this->load->view('insert');
		}
	}

	// Kayıt güncelleme
	public function updateToDo()
	{
		$this->form_validation->set_rules('toDo','To do','required');	
		$this->form_validation->set_rules('SubmitedDate','Submited Date','required');
		
		if($this->form_validation->run()){
			$toDo=$this->input->post('toDo');
			$toDoid=$this->input->post('toDoid');
			$SubmitedDate = $this->input->post('SubmitedDate');
			$this->Read_Model->updateToDo($toDo,$SubmitedDate,$toDoid);
		} else {
			$this->session->set_flashdata('error', 'Somthing went worng. Try again with valid details while Updating !!');
			redirect('read');
		}
	}
	
	//Kayıt silme
	public function deleteToDo($toDoid)
	{
		$this->Read_Model->deleteToDo($toDoid);
		$this->load->view('read');
	}

}
