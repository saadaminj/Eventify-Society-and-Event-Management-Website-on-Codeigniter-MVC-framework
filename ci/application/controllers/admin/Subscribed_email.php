<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Subscribed_email extends CI_Controller {

    public $viewPage = '_users'; //lowercase term for the page name, i.e : mypage, editMypage, addMypage
    public $table = "users";
    private $sectionID = 3;

    public function __construct() {
        parent::__construct();
        // Your own constructor code
        $this->load->model(array("admin_manager", "main_manager", "joins_manager"));
        $this->load->helper(array('form', 'url'));
        $this->load->library(array('form_validation', 'pagination','upload'));
        $this->output->set_header("Cache-Control: no-store, no-cache, must-revalidate, no-transform, max-age=0, post-check=0, pre-check=0");
        $this->output->set_header("Pragma: no-cache");
    }

    public function index() {
        if ($this->session->userdata('adminLogged') != 'yes') {
            redirect(SITE_ADMIN_URL);
        } else {
            $adminId = $this->session->userdata('admin_id');
            $data['users']    = $this->main_manager->select_by_id($adminId,"users");
            $checkPermission = $this->joins_manager->userPermisionByMethod($adminId,48);
            if($checkPermission == 1 || $adminId == 1){
                $final_data['final_data'] = $this->main_manager->select_all('subscribed_email');
                $this->load->view('admin/header');
                $this->load->view('admin/sidebar',$data);
                $this->load->view('admin/view_subsemail',$final_data);
                $this->load->view('admin/footer');
            }else{
                $this->load->view('admin/notallowed');
            }
        }
    }

    
}

?>