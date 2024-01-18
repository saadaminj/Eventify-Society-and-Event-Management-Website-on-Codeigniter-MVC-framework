<?php
class APP_MODELS extends CI_model
{
 	public function get_data()
 	{
 		$arrayName = array("name" => "Azhan",
 							"university" => "FASST",
 							"CGPA" => 3.70 );
 	//return $arrayName;
 	$this->load->database(); //it is a super object;
 	$q=$this->db->query("select * from test");//DB is subobject here q is an object
 	echo "<pre>";
 	print_r($q->result_array()); //returns in an array fashin
 	return $q->result_array();
 	echo "<pre>";
 	print_r($q->result()); //returns as a array of object to print this in view use $value->id &&  $value->Firstname;

 	
 	}
}

?>