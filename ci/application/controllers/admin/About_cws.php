<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class About_cws extends CI_Controller {

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
            $checkPermission        = $this->joins_manager->userPermisionByMethod($adminId,23);
            if($checkPermission == 1 || $adminId == 1){
                $final_data['final_data'] = $this->joins_manager->getAboutCWS();
                $this->load->view('admin/header');
                $this->load->view('admin/sidebar',$data);
                $this->load->view('admin/view_about_CWS',$final_data);
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
            $checkPermission        = $this->joins_manager->userPermisionByMethod($adminId,24);
            $data['users']    = $this->main_manager->select_by_id($adminId,"users");
            if($checkPermission == 1 || $adminId == 1){
                $final_data = array();
                $this->pageAction = 'Add';
                if ($this->input->post('doAct') == strtolower($this->pageAction)) {

                    $this->form_validation->set_rules('page_name', 'page_name', 'required');
                    $this->form_validation->set_rules('slider_name', 'slider_name', 'required');
                    $this->form_validation->set_rules('title', 'title', 'required');
                    $this->form_validation->set_rules('description', 'description', 'required');
                    $this->form_validation->set_rules('alt_text', 'Image alt text', 'required');
                    $this->form_validation->set_rules('image_title', 'Image Title', 'required');
                    $this->form_validation->set_rules('footer_description', 'footer_description', 'required');
                    $this->form_validation->set_rules('status', 'Status', 'required');
                    $this->form_validation->set_rules('page-title', 'page-title');
                    $this->form_validation->set_rules('page-key', 'page-key');
                    $this->form_validation->set_rules('page-description', 'page-description');
                    if ($this->form_validation->run() == FALSE) {
                        $final_data['error'] = validation_errors();
                    }else{

                        $slug1              = str_replace(" ","-",$this->input->post('page_name'));
                        $slug               = strtolower($slug1);

                        if (!empty($_FILES["userfile"]["tmp_name"])) {
                            $config['upload_path'] = './assets/files/CWS_about/';
                            $config['allowed_types'] = 'gif|jpg|png|jepg|GIF|JPEG|JPG|PNG';
                            $config['max_size'] = '';
                            $config['max_width'] = '';
                            $config['max_height'] = '';
                            $this->upload->initialize($config);
                            if (!$this->upload->do_upload()) {
                                $error = array('error' => $this->upload->display_errors());
                                print_r($error);
                                die();
                            } else {
                                $file_name = $this->upload->data();
                                $imageName = $file_name["file_name"];
                            }
                        }else{
                            $imageName = 'CWS_about.png';
                        }

                        $data = array(
                            'page_name'             => $this->input->post('page_name'),
                            'slider_id'             => $this->input->post('slider_name'),
                            'slug'                  => $slug, 
                            'title'                 => $this->input->post('title'),
                            'description'           => $this->input->post('description'),
                            'footer_description'    => $this->input->post('footer_description'),
                            'image'                 => $imageName,
                            'alt_text'              => $this->input->post('alt_text'),
                            'image_title'           => $this->input->post('image_title'),
                            'status'                => $this->input->post('status'),
                            'page-title'            => $this->input->post('page-title'),
                            'page-key'              => $this->input->post('page-key'),
                            'page-description'      => $this->input->post('page-description'),
                            'created_date'          => date('Y-m-d h:i:s'),
                            'created_by'            => $this->session->userdata('admin_id')
                        );


                        ## for insert into admin_users table
                        $this->main_manager->insert($data, "cws_about");


                        $this->session->set_flashdata('msg', 'The data has been added successfully');
                        redirect(SITE_ADMIN_URL . $this->router->fetch_class() . "/index");
                    }

                    }##end if the form is submitted
                $final_data["banner"] = $this->main_manager->select_all("banner");
                $this->load->view('admin/header');
                $this->load->view('admin/sidebar',$data);
                $this->load->view('admin/add_about_cws',$final_data);
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
            $checkPermission = $this->joins_manager->userPermisionByMethod($adminId,25);
            $data['users']    = $this->main_manager->select_by_id($adminId,"users");
            if($checkPermission == 1 || $adminId == 1){
                $final_data = array();

                //  $this->admin_manager->check_admin_auth($this->sectionID);
                $this->pageAction = 'Update';

                if ($this->input->post('doAct') == strtolower($this->pageAction)) {
                    $this->form_validation->set_rules('page_name', 'page_name', 'required');
                    $this->form_validation->set_rules('slider_name', 'slider_name', 'required');
                    $this->form_validation->set_rules('title', 'title', 'required');
                    $this->form_validation->set_rules('status', 'status', 'required');
                    $this->form_validation->set_rules('alt_text', 'Image alt text', 'required');
                    $this->form_validation->set_rules('image_title', 'Image Title', 'required');
                    $this->form_validation->set_rules('description', 'Description', 'required');
                    $this->form_validation->set_rules('footer_description', 'footer_description', 'required');
                    $this->form_validation->set_rules('page-title', 'page-title');
                    $this->form_validation->set_rules('page-key', 'page-key');
                    $this->form_validation->set_rules('page-description', 'page-description');

                    if ($this->form_validation->run() == FALSE) {
                        $final_data['error'] = " ";
                    } else {

                        $slug1              = str_replace(" ","-",$this->input->post('page_name'));
                        $slug               = strtolower($slug1);

                         if (!empty($_FILES["userfile"]["tmp_name"])) {
                            $config['upload_path'] = './assets/files/CWS_about/';
                            $config['allowed_types'] = 'gif|jpg|png|jepg|GIF|JPEG|JPG|PNG';
                            $config['max_size'] = '';
                            $config['max_width'] = '';
                            $config['max_height'] = '';
                            $this->upload->initialize($config);
                            if (!$this->upload->do_upload()) {
                                $error = array('error' => $this->upload->display_errors());
                                print_r($error);
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
                            'slug'              => $slug,
                            'page_name'         => $this->input->post('page_name'),
                            'slider_id'         => $this->input->post('slider_name'),
                            'title'             => $this->input->post('title'),
                            'status'            => $this->input->post('status'),
                            'description'       => $this->input->post('description'),
                            'footer_description'=> $this->input->post('footer_description'),
                            'updated_date'      => date('Y-m-d h:i:s'),
                            'image'             => $image,
                            'alt_text'          => $this->input->post('alt_text'),
                            'page-title'        => $this->input->post('page-title'),
                            'page-key'          => $this->input->post('page-key'),
                            'page-description'  => $this->input->post('page-description'),
                            'image_title'       => $this->input->post('image_title'),
                            'updated_by'        => $this->session->userdata('admin_id'),
                        );

                        ## for update admin_users table
                        $this->main_manager->update($id, $data, "cws_about");
                        $this->session->set_flashdata('msg', 'The data has been updated successfully');
                        redirect(SITE_ADMIN_URL . "about_cws/index");
                    }##end else validation
                }##end if the form is submitted

                $final_data["final_data"] = $this->main_manager->select_by_id($id, "cws_about");
                $final_data["banner"] = $this->main_manager->select_all("banner");
                $this->load->view('admin/header');
                $this->load->view('admin/sidebar',$data);
                $this->load->view('admin/edit_about_CWS',$final_data);
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
                'updated_by' => $this->session->userdata('admin_id'),
                'updated_date' => date('Y-m-d h:i:s')
            );

            if ($this->main_manager->update($id, $data, "cws_about") == false) {
                $error['error'] = 'Cannot save. Please try again.';
            } else {

                $this->session->set_flashdata('msg', 'The data has been updated successfully');
                redirect(SITE_ADMIN_URL . "about_cws/index", 'refresh');
                die();
            }
        }
    }
}

?>