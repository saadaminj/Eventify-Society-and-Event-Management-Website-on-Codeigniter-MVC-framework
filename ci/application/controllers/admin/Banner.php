<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Banner extends CI_Controller {

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
            $checkPermission = $this->joins_manager->userPermisionByMethod($adminId,5);
            if($checkPermission == 1 || $adminId == 1){
                $final_data['final_data'] = $this->joins_manager->getBanner();
                $this->load->view('admin/header');
                $this->load->view('admin/sidebar',$data);
                $this->load->view('admin/view_banner',$final_data);
                $this->load->view('admin/footer');
            }else{
                $this->load->view('admin/notallowed');
            }

        }
    }

    public function add() {
        if ($this->session->userdata('adminLogged') != 'yes') {
            redirect(SITE_ADMIN_URL);

        } else {
            $adminId = $this->session->userdata('admin_id');
            $data['users']    = $this->main_manager->select_by_id($adminId,"users");
            $checkPermission = $this->joins_manager->userPermisionByMethod($adminId,6);
            if($checkPermission == 1 || $adminId == 1){
                $final_data = array();
                $this->pageAction = 'Add';
                if ($this->input->post('doAct') == strtolower($this->pageAction)) {

                    $this->form_validation->set_rules('name', 'Slider Name', 'required');
                    $this->form_validation->set_rules('description', 'description', 'required');
                    if ($this->form_validation->run() == FALSE) {
                        $final_data['error'] = validation_errors();
                    }else{

                        $data = array(
                            
                            'name'              => $this->input->post('name'),
                            'description'       => $this->input->post('description'),
                            'created_date'      => date('Y-m-d h:i:s'),
                            'created_by'        => $this->session->userdata('admin_id')
                        );


                        ## for insert into admin_users table
                        $this->main_manager->insert($data, "banner");


                        $this->session->set_flashdata('msg', 'The data has been added successfully');
                        redirect(SITE_ADMIN_URL . $this->router->fetch_class() . "/index");
                    }

                    }##end if the form is submitted
                $this->load->view('admin/header');
                $this->load->view('admin/sidebar',$data);
                $this->load->view('admin/add_banner',$final_data);
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
            $checkPermission = $this->joins_manager->userPermisionByMethod($adminId,7);
            if($checkPermission == 1 || $adminId == 1){
                $final_data = array();

                //  $this->admin_manager->check_admin_auth($this->sectionID);
                $this->pageAction = 'Update';

                if ($this->input->post('doAct') == strtolower($this->pageAction)) {
                    $this->form_validation->set_rules('name', 'name', 'required');
                    $this->form_validation->set_rules('description', 'description', 'required');

                    if ($this->form_validation->run() == FALSE) {
                        $final_data['error'] = " ";
                    } else {
                        $data = array(
                            'id'                => $id,
                            'name'              => $this->input->post('name'),
                            'description'       => $this->input->post('description'),
                            'updated_date'      => date('Y-m-d h:i:s'),
                            'updated_by'        => $this->session->userdata('admin_id'),
                        );

                        ## for update admin_users table
                        $this->main_manager->update($id, $data, "banner");
                        $this->session->set_flashdata('msg', 'The data has been updated successfully');
                        redirect(SITE_ADMIN_URL . "banner/index");
                    }##end else validation
                }##end if the form is submitted

                $final_data["final_data"] = $this->main_manager->select_by_id($id, "banner");
                $this->load->view('admin/header');
                $this->load->view('admin/sidebar',$data);
                $this->load->view('admin/edit_banner',$final_data);
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

//  $this->admin_manager->check_admin_auth($this->sectionID);
            $data = array(
                'id' => $id,
                'status' => $is_active,
                'updated_by' => $this->session->userdata('admin_id'),
                'updated_date' => date('Y-m-d h:i:s')
            );

            if ($this->main_manager->update($id, $data, "banner") == false) {
                $error['error'] = 'Cannot save. Please try again.';
            } else {

                $this->session->set_flashdata('msg', 'The data has been updated successfully');
                redirect(SITE_ADMIN_URL . "banner/index", 'refresh');
                die();
            }
        }
    }
}

?>