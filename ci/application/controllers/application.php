<?php
class Application extends CI_controller
{
	public function index()
	{
		$this->load->view("Default_Webpage");
	}
	public function get()
	{
		$this->load->model('ABC');
		$name1 = $this->ABC->get_value();
	//	print_r($name1) ;
		$data = array(
			'page_data' => $name1
		);
		$this->load->view('frontend', $data);
	
	

	}
}
?>