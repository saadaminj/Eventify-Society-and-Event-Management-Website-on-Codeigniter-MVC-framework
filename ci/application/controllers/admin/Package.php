<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Package extends CI_Controller {

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

    public function listing() {
        if ($this->session->userdata('adminLogged') != 'yes') {
            redirect(SITE_ADMIN_URL);
        } else {
            $adminId = $this->session->userdata('admin_id');
            $data['users']    = $this->main_manager->select_by_id($adminId,"users");
            $checkPermission = $this->joins_manager->userPermisionByMethod($adminId,49);
            if($checkPermission == 1 || $adminId == 1){
                $final_data['final_data'] = $this->joins_manager->getOrderListing();

                $this->load->view('admin/header');
                $this->load->view('admin/sidebar',$data);
                $this->load->view('admin/view_orders_queries',$final_data);
                $this->load->view('admin/footer');
            }else{
                $this->load->view('admin/notallowed');
            }

        }
    }

    public function index() {
        if ($this->session->userdata('adminLogged') != 'yes') {
            redirect(SITE_ADMIN_URL);
        } else {
            $adminId = $this->session->userdata('admin_id');
            $data['users']    = $this->main_manager->select_by_id($adminId,"users");
            $checkPermission = $this->joins_manager->userPermisionByMethod($adminId,36);
            if($checkPermission == 1 || $adminId == 1){
                $final_data['final_data'] = $this->joins_manager->getPackages();

                $this->load->view('admin/header');
                $this->load->view('admin/sidebar',$data);
                $this->load->view('admin/view_packages',$final_data);
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
            $checkPermission = $this->joins_manager->userPermisionByMethod($adminId,37);
            if($checkPermission == 1 || $adminId == 1){
                $final_data = array();
                $this->pageAction = 'Add';
                if ($this->input->post('doAct') == strtolower($this->pageAction)) {

                    $this->form_validation->set_rules('text1', 'text1');
                    $this->form_validation->set_rules('text2', 'text2');
                    $this->form_validation->set_rules('price', 'price');
                    $this->form_validation->set_rules('page_name', 'page_name', 'required');
                    $this->form_validation->set_rules('discounted_price', 'discounted_price');
                    $this->form_validation->set_rules('off_per', 'off_per'); 

                    if ($this->form_validation->run() == FALSE) {
                        $final_data['error'] = validation_errors();
                    }else{
                        $data = array(
                            'text1'             => $this->input->post('text1'),
                            'text2'             => $this->input->post('text2'),
                            'price'             => $this->input->post('price'),
                            'page_id'            => $this->input->post('page_name'),
                            'discounted_price'  => $this->input->post('discounted_price'),
                            'off_per'           => $this->input->post('off_per'),
                            'created_by'        => $this->session->userdata('admin_id'),
                            'created_date'      => date('Y-m-d h:i:s'),
                        );

                        ## for insert into admin_users table
                        $this->main_manager->insert($data, "packages");
                        $pkgId = $this->db->insert_id();

                        if(isset($_POST['description']) && $_POST['description'] != ''){
                            for($s=0;$s<count($_POST['description']);$s++){
                                if($_POST['description'][$s] != ''){
                                    $desData = array(
                                        'pkg_id' => $pkgId,
                                        'des'   => $_POST['description'][$s],
                                    );
                                    $this->main_manager->insert($desData, "pkg_des");
                                }
                            }
                        }

                        $this->session->set_flashdata('msg', 'The data has been added successfully');
                        redirect(SITE_ADMIN_URL . $this->router->fetch_class() . "/index");
                    }

                    }##end if the form is submitted
            $final_data['page_name'] = $this->main_manager->select_all('pkg_page_name');
                $this->load->view('admin/header');
                $this->load->view('admin/sidebar',$data);
                $this->load->view('admin/add_package',$final_data);
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
            $checkPermission = $this->joins_manager->userPermisionByMethod($adminId,38);
            if($checkPermission == 1 || $adminId == 1){
                $final_data = array();

                $this->pageAction = 'Update';

                if ($this->input->post('doAct') == strtolower($this->pageAction)) {
                    $this->form_validation->set_rules('text1', 'text1');
                    $this->form_validation->set_rules('text2', 'text2');
                    $this->form_validation->set_rules('price', 'price');
                    $this->form_validation->set_rules('page_name', 'page_name', 'required');
                    $this->form_validation->set_rules('discounted_price', 'discounted_price');
                    $this->form_validation->set_rules('off_per', 'off_per');
                    if ($this->form_validation->run() == FALSE) {
                        $final_data['error'] = " ";
                    } else {

                        $data = array(
                            'id'                => $id,
                            'text1'             => $this->input->post('text1'),
                            'text2'             => $this->input->post('text2'),
                            'price'             => $this->input->post('price'),
                            'page_id'            => $this->input->post('page_name'),
                            'discounted_price'  => $this->input->post('discounted_price'),
                            'off_per'           => $this->input->post('off_per'),
                            'updated_by'        => $this->session->userdata('admin_id'),
                            'updated_date'      => date('Y-m-d h:i:s'),
                        );

                        ## for update admin_users table
                        $this->main_manager->update($id, $data, "packages");

                        $this->main_manager->delete_by_other_id('pkg_id',$id,'pkg_des');

                        if(isset($_POST['description']) && $_POST['description'] != ''){
                            for($s=0;$s<count($_POST['description']);$s++){
                                if($_POST['description'][$s] != ''){
                                    $desData = array(
                                        'pkg_id' => $id,
                                        'des'    => $_POST['description'][$s],
                                    );
                                    $this->main_manager->insert($desData, "pkg_des");
                                }

                            }

                        $this->session->set_flashdata('msg', 'The data has been updated successfully');
                        redirect(SITE_ADMIN_URL . "package/index/");
                    }##end else validation
                }
                }##end if the form is submitted

                $final_data["final_data"] = $this->main_manager->select_by_id($id, "packages");
                $final_data['page_name'] = $this->main_manager->select_all('pkg_page_name');
                $final_data["des_data"]   = $this->main_manager->select_by_other_id('pkg_id',$id, "pkg_des");
                $this->load->view('admin/header');
                $this->load->view('admin/sidebar',$data);
                $this->load->view('admin/edit_packages',$final_data);
                $this->load->view('admin/footer');
            }else{
                $this->load->view('admin/notallowed');
            }

        }
    }

     public function delete($id = NULL) {
        if ($this->session->userdata('adminLogged') != 'yes') {
            redirect(SITE_ADMIN_URL);
        } else {
            $adminId = $this->session->userdata('admin_id');
            $checkPermission = $this->joins_manager->userPermisionByMethod($adminId,39);
            if($checkPermission == 1 || $adminId == 1)
                {                    
                $this->main_manager->delete($id, "packages");
                redirect(SITE_ADMIN_URL . $this->router->fetch_class() . "/index", 'refresh');
                die();
                }
            else{
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
               
            );

            if ($this->main_manager->update($id, $data, "packages") == false) {
                $error['error'] = 'Cannot save. Please try again.';
            } else {

                $this->session->set_flashdata('msg', 'The data has been updated successfully');
                redirect(SITE_ADMIN_URL . "packages/index", 'refresh');
                die();
            }
        }
    }

}

?>