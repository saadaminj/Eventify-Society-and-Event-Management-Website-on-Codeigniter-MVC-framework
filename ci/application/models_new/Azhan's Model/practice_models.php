<?php
class PRACTICE_MODELS extends CI_model
{
	public function get_data()
	{
		 // $data = array('NAME' =>'Azhan' ,
		 // 				'DEPT' =>'CS',
		 // 				'CGPA' =>'3.7' );
		 // return $data;
	
		$this->load->database();
		$q = $this->db->query('select * from articles');
		echo "<pre>";
		return($q->result_array());
		
	}
}
?>