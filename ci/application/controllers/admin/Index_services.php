<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Index_services extends CI_Controller {

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
            $checkPermission = $this->joins_manager->userPermisionByMethod($adminId,12);
            if($checkPermission == 1 || $adminId == 1){

                $final_data['final_data'] = $this->joins_manager->getIndexServices();

                $this->load->view('admin/header');
                $this->load->view('admin/sidebar',$data);
                $this->load->view('admin/view_index_services',$final_data);
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
            $checkPermission = $this->joins_manager->userPermisionByMethod($adminId,13);
            if($checkPermission == 1 || $adminId == 1){
                $final_data = array();
                $this->pageAction = 'Update';
                if ($this->input->post('doAct') == strtolower($this->pageAction)) {
                    $this->form_validation->set_rules('text1', 'Text 1', 'required');
                    $this->form_validation->set_rules('text2', 'Text 2', 'required');
                    $this->form_validation->set_rules('description', 'Description', 'required');
                    $this->form_validation->set_rules('status', 'Status', 'required');

                    if ($this->form_validation->run() == FALSE) {
                        $final_data['error'] = " ";
                    } else {
                        $data = array(
                            'id'            => $id,
                            'text1'         => $this->input->post('text1'),
                            'text2'         => $this->input->post('text2'),
                            'description'   => $this->input->post('description'),
                            'status'        => $this->input->post('status'),
                            'updated_by'    => $this->session->userdata('admin_id'),
                            'updated_date'  => date('Y-m-d h:i:s'),
                        );

                        ## for update admin_users table
                        $this->main_manager->update($id, $data, "index_services");
                        $this->session->set_flashdata('msg', 'The data has been updated successfully');
                        redirect(SITE_ADMIN_URL . "index_services/index/");
                    }##end else validation
                }##end if the form is submitted
                $final_data["final_data"] = $this->main_manager->select_by_id($id, "index_services");
                $this->load->view('admin/header');
                $this->load->view('admin/sidebar',$data);
                $this->load->view('admin/edit_index_services',$final_data);
                $this->load->view('admin/footer');
            }else{
                $this->load->view('admin/notallowed');
            }
        }
    }

    public function acitve_inactive($id = NULL, $is_active = NULL) {
        if ($this->session->userdata('adminLogged') != 'yes') {
            redirect(SITE_ADMIN_URL);
        } else {

            $data = array(
                'id' => $id,
                'status' => $is_active,
                'Updated_By' => $this->session->userdata('admin_id'),
                'Updated_date' => date('Y-m-d h:i:s')
            );

            if ($this->main_manager->update($id, $data, "index_services") == false) {
                $error['error'] = 'Cannot save. Please try again.';
            } else {

                $this->session->set_flashdata('msg', 'The data has been updated successfully');
                redirect(SITE_ADMIN_URL . "index_services/index", 'refresh');
                die();
            }
        }
    }
}

?>