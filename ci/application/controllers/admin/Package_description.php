<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Package_description extends CI_Controller {

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

            // Portfolio Description

    public function index() {
        if ($this->session->userdata('adminLogged') != 'yes') {
            redirect(SITE_ADMIN_URL);
        } else {
            $adminId = $this->session->userdata('admin_id');
            $data['users']    = $this->main_manager->select_by_id($adminId,"users");
            $checkPermission = $this->joins_manager->userPermisionByMethod($adminId,18);
            if($checkPermission == 1 || $adminId == 1){

                $final_data['final_data'] = $this->joins_manager->getPkgDescription();

                $this->load->view('admin/header');
                $this->load->view('admin/sidebar',$data);
                $this->load->view('admin/view_pkg_description',$final_data);
                $this->load->view('admin/footer');
            }else{
                $this->load->view('admin/notallowed');
            }
        }
    }

    public function edit($id = NULL) {
        if ($this->session->userdata('adminLogged') != 'yes') {
            redirect(SITE_ADMIN_URL);
        } else {
            $adminId = $this->session->userdata('admin_id');
            $data['users']    = $this->main_manager->select_by_id($adminId,"users");
            $checkPermission = $this->joins_manager->userPermisionByMethod($adminId,19);
            if($checkPermission == 1 || $adminId == 1){
                $final_data = array();
                $this->pageAction = 'Update';
                if ($this->input->post('doAct') == strtolower($this->pageAction)) {
                    $this->form_validation->set_rules('description', 'Description', 'required');

                    if ($this->form_validation->run() == FALSE) {
                        $final_data['error'] = " ";
                    } else {
                        $data = array(
                            'id'            => $id,
                            'description'   => $this->input->post('description'),
                            'updated_by'    => $this->session->userdata('admin_id'),
                            'updated_date'  => date('Y-m-d h:i:s'),
                        );

                        ## for update admin_users table
                        $this->main_manager->update($id, $data, "Pkg_description");
                        $this->session->set_flashdata('msg', 'The data has been updated successfully');
                        redirect(SITE_ADMIN_URL . "Package_description/index/");
                    }##end else validation
                }##end if the form is submitted
                $final_data["final_data"] = $this->main_manager->select_by_id($id, "Pkg_description");
                $this->load->view('admin/header');
                $this->load->view('admin/sidebar',$data);
                $this->load->view('admin/edit_pkg_description',$final_data);
                $this->load->view('admin/footer');
            }else{
                $this->load->view('admin/notallowed');
            }
        }
    }

    
}

?>