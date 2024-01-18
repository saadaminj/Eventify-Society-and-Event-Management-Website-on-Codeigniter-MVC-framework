<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Portfolio extends CI_Controller {

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
            $checkPermission = $this->joins_manager->userPermisionByMethod($adminId,32);
            if($checkPermission == 1 || $adminId == 1){
                $final_data['final_data'] = $this->joins_manager->getPortfolio();

                $this->load->view('admin/header');
                $this->load->view('admin/sidebar',$data);
                $this->load->view('admin/view_portfolio',$final_data);
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
            $checkPermission = $this->joins_manager->userPermisionByMethod($adminId,33);
            if($checkPermission == 1 || $adminId == 1){
                $final_data = array();
                $this->pageAction = 'Add';
                if ($this->input->post('doAct') == strtolower($this->pageAction)) {
                    $this->form_validation->set_rules('alt_text', 'Image alt text');
                    $this->form_validation->set_rules('image_title', 'Image Title');
                    $this->form_validation->set_rules('service_page', 'service_page');
                    $this->form_validation->set_rules('status', 'status', 'required');
                    $this->form_validation->set_rules('category', 'category', 'required');
                    if ($this->form_validation->run() == FALSE) {
                        $final_data['error'] = " ";
                    } else {
                        
                        if (!empty($_FILES["userfile"]["tmp_name"])) {
                            $config['upload_path'] = './assets/files/portfolio/';
                            $config['allowed_types'] = 'gif|jpg|png|jepg|GIF|JPEG|JPG|PNG';
                            $config['max_size'] = '';
                            $config['max_width'] = '';
                            $config['max_height'] = '';
                            $this->upload->initialize($config);
                            if (!$this->upload->do_upload()) {
                                $error = array('error' => $this->upload->display_errors());
                                d($error);
                                die();
                            } else {
                                $file_name = $this->upload->data();
                                $image = $file_name["file_name"];
                            }
                        }


                        $data = array(
                            'alt_text'          => $this->input->post('alt_text'),
                            'image_title'       => $this->input->post('image_title'),
                            'status'            => $this->input->post('status'),
                            'cat_id'            => $this->input->post('category'),
                            'page_id'            => $this->input->post('service_page'),
                            'image'             => $image,
                            'created_date'      => date('Y-m-d h:i:s'),
                        );



                        $this->main_manager->insert($data, "portfolio");

                        $this->session->set_flashdata('msg', 'The data has been added successfully');
                        redirect(SITE_ADMIN_URL . $this->router->fetch_class() . "/index");
                    }##end else validation
                }##end if the form is submitted

                
                $final_data['portfolio_category'] = $this->main_manager->select_all('portfolio_category');
                $final_data['page_name'] = $this->main_manager->select_all('pkg_page_name');
                $this->load->view('admin/header');
                $this->load->view('admin/sidebar',$data);
                $this->load->view('admin/add_portfolio',$final_data);
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
            $checkPermission = $this->joins_manager->userPermisionByMethod($adminId,34);
            if($checkPermission == 1 || $adminId == 1){
                $final_data = array();
                $this->form_validation->set_rules('alt_text', 'Image alt text');
                $this->form_validation->set_rules('image_title', 'Image Title');
                $this->form_validation->set_rules('service_page', 'service_page');
                $this->form_validation->set_rules('status', 'status', 'required');
                $this->form_validation->set_rules('category', 'category', 'required');
                $this->pageAction = 'Update';

                if ($this->input->post('doAct') == strtolower($this->pageAction)) {

                    if (!empty($_FILES["userfile"]["tmp_name"])) {
                        $config['upload_path'] = './assets/files/portfolio/';
                        $config['allowed_types'] = 'gif|jpg|png|jepg|GIF|JPEG|JPG|PNG';
                        $config['max_size'] = '';
                        $config['max_width'] = '';
                        $config['max_height'] = '';
                        $this->upload->initialize($config);
                        if (!$this->upload->do_upload()) {
                            $error = array('error' => $this->upload->display_errors());
                            d($error);
                            die();
                        } else {
                            $file_name = $this->upload->data();
                            $image = $file_name["file_name"];
                        }
                    }else{
                        $image = $this->input->post('img');
                    }

                    $data = array(
                        'id'                => $id,
                        'status'            => $this->input->post('status'),
                        'alt_text'          => $this->input->post('alt_text'),
                        'image_title'       => $this->input->post('image_title'),
                        'image'             => $image,
                        'cat_id'            => $this->input->post('category'),
                        'page_id'            => $this->input->post('service_page'),
                        'created_date'      => date('Y-m-d h:i:s'),
                    );

                 
                    ## for update admin_users table
                    $this->main_manager->update($id, $data, "portfolio");
                    $this->session->set_flashdata('msg', 'The data has been updated successfully');
                    redirect(SITE_ADMIN_URL . "portfolio/index/");
                    // }##end else validation
                }##end if the form is submitted
                $final_data["final_data"] = $this->main_manager->select_by_id($id, "portfolio");
                $final_data['portfolio_category'] = $this->main_manager->select_all('portfolio_category');
                $final_data['page_name'] = $this->main_manager->select_all('pkg_page_name');
                $this->load->view('admin/header');
                $this->load->view('admin/sidebar',$data);
                $this->load->view('admin/edit_portfolio',$final_data);
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
            $checkPermission = $this->joins_manager->userPermisionByMethod($adminId,35);
            if($checkPermission == 1 || $adminId == 1)
                {                    
                $this->main_manager->delete($id, "portfolio");
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

            if ($this->main_manager->update($id, $data, "portfolio") == false) {
                $error['error'] = 'Cannot save. Please try again.';
            } else {

                $this->session->set_flashdata('msg', 'The data has been updated successfully');
                redirect(SITE_ADMIN_URL . "portfolio/index", 'refresh');
                die();
            }
        }
    }

    }

?>