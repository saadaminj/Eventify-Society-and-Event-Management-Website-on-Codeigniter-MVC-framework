<?php

class Site_user extends CI_Controller {

    public $table = "admin_users";
    public $viewPage = "_admin_users";
    private $sectionID = 1;

    public function __construct() {
        parent::__construct();

        $this->load->model(array("admin_manager", "main_manager","joins_manager"));
        $this->load->library(array("form_validation", "email"));
        $this->load->helper('cookie');
        $this->output->set_header("Cache-Control: no-store, no-cache, must-revalidate, no-transform, max-age=0, post-check=0, pre-check=0");
        $this->output->set_header("Pragma: no-cache");
    }

    

    public function admin_users() {
        if ($this->session->userdata('adminLogged') != 'yes') {
            $this->load->view('admin/login');
        } else {
            
            $adminId                    = $this->session->userdata('admin_id');
            $data['users']              = $this->main_manager->select_by_id($adminId, "users");
            $checkPermission            = $this->joins_manager->userPermisionByMethod($adminId,57);

            if($checkPermission == 1 || $adminId == 1){
                 $final_data['final_data']   = $this->main_manager->select_all("sites_user");

                $this->load->view('admin/header');
                $this->load->view('admin/sidebar',$data);
                $this->load->view('admin/view_site_users',$final_data);
                $this->load->view('admin/footer');
            }else{
                $this->load->view('admin/notallowed');
            }


        }
    }


}

?>
