<?php
 class Model_Member extends CI_Model{

    public function create(){
        $data=array(
            'fname'=> $this->input->post('fname'),
            'lname'=> $this->input->post('lname'),
            'age' => $this->input->post('age'),
			'contact' => $this->input->post('contact'),
			'address' => $this->input->post('address')

        );
        $sql=$this->db->insert('members',$data);

        if($sql===true){
            return true;
        }
        else{
            return false;
        }
    }
    public function fetchMemberData($id = null){
        
		if($id) {
			$sql = "SELECT * FROM members WHERE id = ?";
			$query = $this->db->query($sql, array($id));
			return $query->row_array();
		}

        $sql = "SELECT * FROM members";
		$query = $this->db->query($sql);
		return $query->result_array();
    }
    public function edit($id){
        $data=array(
            'fname'=> $this->input->post('fname'),
            'lname'=> $this->input->post('lname'),
            'age' => $this->input->post('age'),
			'contact' => $this->input->post('contact'),
			'address' => $this->input->post('address')

        );
        $this->db->where('id',$id);
        $query=$this->db->update('members',$data);
        if($query === true) {
            return true; 
        } else {
            return false;
        }
        
    }
    public function remove($id){
        $this->db->where('id',$id);
        $query=$this->db->delete('members');
        if($query===true){
            return true;
        }
        else{
            return false;
        }


    }
 }
?>