<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Welcome extends CI_Controller {
	
	public function __construct(){
		parent::__construct();
		$this->load->library('form_validation');
        $this->load->model('Model_Member');
	}
	
	public function index()
	{
		$this->load->view('home');
	}
	public function create(){
		$validator=array('success'=>false,'messages'=>array());

		

		$config=array(
            array(
			  'field'=>'fname',
			  'label'=>'First Name',
			  'rules' => 'trim|required'
			),
			array(
				'field' => 'age',
				'label' => 'Age',
				'rules' => 'trim|required|integer'	            
				),
			array(
				'field' => 'contact',
				'label' => 'Contact',
				'rules' => 'trim|required|integer'	            
				)
		);

		$this->form_validation->set_rules($config);
		$this->form_validation->set_error_delimiters('<p class="text-danger">','</p>');

		if($this->form_validation->run()=== true){
			$createMember=$this->Model_Member->create();
			if($createMember ===true){
				$validator['success']=true;
				$validator['messages']="successfily Added";
			}
			else{
				$validator['success']=false;
				$validator['messages']="Error while updating the infromation";
			}

		}
		else{
			$validator['success']=false;
			foreach($_POST as $key => $value){
				$validator['messages'][$key]=form_error($key);
			}
		}
		echo json_encode($validator);
	}
	public function fetchMemberData(){

		$result=array('data'=>array());
		$data= $this->Model_Member->fetchMemberData();
		
		foreach ($data as $key => $value) {
			$name = $value['fname'] . ' ' . $value['lname'];

			// button
			

			$result['data'][$key] = array(
				$value['id'],
				$name,
				$value['age'],
				$value['contact'],
				$value['address'],
				
				
			);
		} // /foreach

		echo json_encode($result);
	

	}
	public function update(){
		$validator=array('success'=>false,'messages'=>array());
		$config=array(
            array(
			  'field'=>'fname',
			  'label'=>'First Name',
			  'rules' => 'trim|required'
			),
			array(
				'field' => 'age',
				'label' => 'Age',
				'rules' => 'trim|required|integer'	            
				),
			array(
				'field' => 'contact',
				'label' => 'Contact',
				'rules' => 'trim|required|integer'	            
				)
		);
		$this->form_validation->set_rules($config);
		$this->form_validation->set_error_delimiters('<p class="text-danger">','</p>');
		if($this->form_validation->run()=== true){
			$data=array(

			);
			 $id=$this->input->post('id');
			$editMember=$this->Model_Member->edit($id);
			if($editMember==true){
			$validator['success'] = true;
		    $validator['messages'] = "Successfully updated";
			echo json_encode($validator);
			}
		}
		else{
			$validator['success']=false;
			foreach($_POST as $key => $value){
				$validator['messages'][$key]=form_error($key);
			}
			

			echo json_encode($validator);
			
		}
	}
	public function delete(){
		$validator=array('success'=>false,'messages'=>array());
		$id=$this->uri->segment(3);
		$result=$this->Model_Member->remove($id);
		if($result===true){
			$validator['success']= true;
			$validator['messages']="Record deleted successfully";
			echo json_encode($validator);
		}
	}
	
}
