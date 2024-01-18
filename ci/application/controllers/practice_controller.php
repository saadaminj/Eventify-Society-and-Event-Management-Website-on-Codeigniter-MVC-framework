<?php
class PRACTICE_CONTROLLER extends  CI_CONTROLLER
{

	function index()
	{
		echo "DEFAULT FUNCTION CALLED";
	}
	function get()
	{
		echo "getcalled";
		$this->load->model("practice_models");
		$recieved=$this->practice_models->get_data();
		print_r($recieved);
		$recieveddata = array('value' =>$recieved  );
		$this->load->helper('url');
		$this->load->helper('html');
		$this->load->view("practice_frontend",$recieveddata);

	}
}
?>