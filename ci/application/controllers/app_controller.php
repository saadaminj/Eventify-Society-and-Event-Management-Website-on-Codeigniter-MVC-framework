<?php

class APP_CONTROLLER extends CI_Controller
{
	function index()
	{
		echo "THIS IS THE INDEX FUNCTION";
	}
	function get_controller()
	{

		echo "Getting data from Models";
		$this->load->model('APP_MODELS');
		$data= $this->APP_MODELS->get_data();
		echo "CONTROLLER";
		print_r($data);
		$newdata = array('value' => $data );
		print_r($newdata);
		$this->load->helper('url');
		$this->load->view('app_frontend', $newdata);
	}
}
?>