<?php

Class login extends CI_controller
{
	public function index()
	{
		$this->load->helper('form');
		$this->load->view('public/admin_login.php');
	}
	public function admin_login()
	{

	}
}
?>