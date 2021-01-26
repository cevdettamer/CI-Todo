<?php 
defined('BASEPATH') OR exit('No direct script access allowed'); 
class Read_Model extends CI_Model{
	
	public function __construct() {
		parent::__construct(); 
	}
	
	public function getData($rowno,$rowperpage,$search="",$SubmitedDate="") 
	{	
		$this->db->select('*');
		$this->db->from('todo');
		
		if($search != ''){
			$this->db->like('toDo', $search);
		}
		
		if($SubmitedDate != ''){
			$this->db->like('SubmitedDate', $SubmitedDate);
		}
		
		$this->db->limit($rowperpage, $rowno); 
		$this->db->order_by('PostingDate', 'DESC');
		$query = $this->db->get();
		
		return $query->result_array();  
	}
	
	function getrecordCount($search = '') 
	{
		$this->db->select('count(*) as allcount');
		$this->db->from('todo');

		if($search != ''){
			$this->db->like('toDo', $search);
		}

		$query = $this->db->get();
		$result = $query->result_array();

		return $result[0]['allcount'];
	}

	function getDiaryDetail($id)
	{
		$ret=$this->db->select('id,toDo,SubmitedDate,PostingDate')->where('id',$id)->get('todo');
		return $ret->row();    
	}
	
	function insertToDo($toDo,$SubmitedDate)
	{
		$data=array(
			'toDo'=>$toDo,
			'SubmitedDate'=>$SubmitedDate
		);
		$sql_query=$this->db->insert('todo',$data);
		if($sql_query){
			$this->session->set_flashdata('success', 'To do inserted successful');
			redirect('read');
		}
		else{
			$this->session->set_flashdata('error', 'Somthing went worng. Error!!');
			redirect('read');
		}
	}
	
	function updateToDo($toDo,$SubmitedDate,$toDoid)
	{
		$data=array(
			'toDo'=>$toDo,
			'SubmitedDate'=>$SubmitedDate
		);

		$sql_query=$this->db->where('id', $toDoid)->update('todo', $data); 
		if($sql_query){
			$this->session->set_flashdata('success', 'To do updated successful');
			redirect('read');
		}
		else{
			$this->session->set_flashdata('error', 'Somthing went worng while Updating. Error!!');
			redirect('read');
		}

	}
	
	function deleteToDo($toDoid)
	{
		$sql_query=$this->db->where('id', $toDoid)->delete('todo'); 
		if($sql_query){
			$this->session->set_flashdata('success', 'To do deleted successfully');
			redirect('read');
		}
		else{
			$this->session->set_flashdata('error', 'Somthing went worng. Error!!');
			redirect('read');
		}

	}


}


