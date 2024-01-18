<?php
class USER extends CI_controller
{

	function index()
	{
		echo "DEFAULT FUNCTION";
	}
	function get()
	{
		$this->load->helper('html');
	    $this->load->helper('url');
	    
	    $this->load->view('public/article_list');
	}
}

?> 