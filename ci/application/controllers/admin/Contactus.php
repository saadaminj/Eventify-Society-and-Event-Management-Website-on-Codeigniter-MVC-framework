<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Contactus extends CI_Controller {

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

    public function index($id = NULL) {
        if ($this->session->userdata('adminLogged') != 'yes') {
            redirect(SITE_ADMIN_URL);
        } else {
            $adminId = $this->session->userdata('admin_id');
            $users['users']    = $this->main_manager->select_by_id($adminId,"users");
            $checkPermission = $this->joins_manager->userPermisionByMethod($adminId,43);
            if($checkPermission == 1 || $adminId == 1){
                $final_data = array();
                $this->pageAction = 'Update';
                if ($this->input->post('doAct') == strtolower($this->pageAction)) {
                    $this->form_validation->set_rules('address', 'Address', 'required');
                    $this->form_validation->set_rules('phone', 'Phone', 'required');
                    $this->form_validation->set_rules('timing', 'Timing', 'required');
                    $this->form_validation->set_rules('email', 'Email', 'required');
                    $this->form_validation->set_rules('email1', 'Email', 'required');
                    if ($this->form_validation->run() == FALSE) {
                        $final_data['error'] = " ";
                    } else {
                        $data = array(
                            'address' => $this->input->post('address'),
                            'phone' => $this->input->post('phone'),
                            'timing' => $this->input->post('timing'),
                            'email' => $this->input->post('email'),
                            'email1' => $this->input->post('email1'),
                        );


                        ## for update admin_users table
                        $this->main_manager->update(1, $data, "contactus");
                        $this->session->set_flashdata('msg', 'The data has been updated successfully');
                        redirect(SITE_ADMIN_URL . "contactus/index");
                    }##end else validation
                }##end if the form is submitted

                $final_data['final_data'] = $this->main_manager->select_by_id(1,"contactus");

                $this->load->view('admin/header');
                $this->load->view('admin/sidebar',$users);
                $this->load->view('admin/edit_contactus',$final_data);
                $this->load->view('admin/footer');
            }else{
                $this->load->view('admin/notallowed');
            }

        }
    }

    public function listing() {
        if ($this->session->userdata('adminLogged') != 'yes') {
            redirect(SITE_ADMIN_URL);
        } else {
            $adminId = $this->session->userdata('admin_id');
            $users['users']    = $this->main_manager->select_by_id($adminId,"users");
            $checkPermission = $this->joins_manager->userPermisionByMethod($adminId,42);
            if($checkPermission == 1 || $adminId == 1){
                $final_data['final_data'] = $this->joins_manager->getQueries();

                $this->load->view('admin/header');
                $this->load->view('admin/sidebar',$users);
                $this->load->view('admin/view_contactus_queries',$final_data);
                $this->load->view('admin/footer');
            }else{
                $this->load->view('admin/notallowed');
            }

        }
    }

}

?>