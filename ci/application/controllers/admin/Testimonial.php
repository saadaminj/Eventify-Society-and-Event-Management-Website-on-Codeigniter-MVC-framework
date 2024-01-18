<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Testimonial extends CI_Controller {

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
            $checkPermission = $this->joins_manager->userPermisionByMethod($adminId,20);
            if($checkPermission == 1 || $adminId == 1){
                $final_data['final_data'] = $this->joins_manager->getTestimonial();
                $this->load->view('admin/header');
                $this->load->view('admin/sidebar',$data);
                $this->load->view('admin/view_testimonial',$final_data);
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
            $checkPermission = $this->joins_manager->userPermisionByMethod($adminId,21);
            if($checkPermission == 1 || $adminId == 1){
                $final_data = array();
                $this->pageAction = 'Add';
                if ($this->input->post('doAct') == strtolower($this->pageAction)) {
                    $this->form_validation->set_rules('Name', 'Name', 'required');
                    $this->form_validation->set_rules('C_name', 'C_name', 'required');
                    $this->form_validation->set_rules('Link', 'Link');
                    $this->form_validation->set_rules('alt_text', 'alt Text', 'required');
                    $this->form_validation->set_rules('image_title', 'Image Title', 'required');
                    $this->form_validation->set_rules('Message', 'Message', 'required');
                    $this->form_validation->set_rules('Status', 'Status', 'required');
                    if ($this->form_validation->run() == FALSE) {
                        $final_data['error'] = " ";
                    } else {
                        if (!empty($_FILES["userfile"]["tmp_name"])) {
                            $config['upload_path'] = './assets/files/testimonial/';
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
                            }
                        }
                        $data = array(
                            'Name'          => $this->input->post('Name'),
                            'C_name'        => $this->input->post('C_name'),
                            'Link'          => $this->input->post('Link'),
                            'Message'       => $this->input->post('Message'),
                            'alt_text'      => $this->input->post('alt_text'),
                            'image_title'   => $this->input->post('image_title'),
                            'Image'         => $file_name["file_name"],
                            'Status'        => $this->input->post('Status'),
                            'Created_By'    => $this->session->userdata('admin_id')
                        );
                        ## for insert into admin_users table
                        $this->main_manager->insert($data, "testimonial");

                        $this->session->set_flashdata('msg', 'The data has been added successfully');
                        redirect(SITE_ADMIN_URL . $this->router->fetch_class() . "/index");
                    }##end else validation
                }##end if the form is submitted

                $this->load->view('admin/header');
                $this->load->view('admin/sidebar',$data);
                $this->load->view('admin/add_testimonial');
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
            $checkPermission = $this->joins_manager->userPermisionByMethod($adminId,22);
            if($checkPermission == 1 || $adminId == 1){
                $final_data = array();
                $this->pageAction = 'Update';

                if ($this->input->post('doAct') == strtolower($this->pageAction)) {
                    $this->form_validation->set_rules('Name', 'Name', 'required');
                    $this->form_validation->set_rules('C_name', 'C_name', 'required');
                    $this->form_validation->set_rules('Link', 'Link');
                    $this->form_validation->set_rules('alt_text', 'alt Text', 'required');
                    $this->form_validation->set_rules('image_title', 'Image Title', 'required');
                    $this->form_validation->set_rules('Message', 'Message', 'required');
                    $this->form_validation->set_rules('Status', 'Status', 'required');

                    if ($this->form_validation->run() == FALSE) {
                        $final_data['error'] = " ";
                    } else {
                        if (!empty($_FILES["userfile"]["tmp_name"])) {
                            $config['upload_path'] = './assets/files/testimonial/';
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
                            'ID'            => $id,
                            'Name'          => $this->input->post('Name'),
                            'C_name'        => $this->input->post('C_name'),
                            'Link'          => $this->input->post('Link'),
                            'alt_text'      => $this->input->post('alt_text'),
                            'image_title'   => $this->input->post('image_title'),
                            'Message'       => $this->input->post('Message'),
                            'Status'        => $this->input->post('Status'),
                            'Image'         => $image,
                            'Updated_By'    => $this->session->userdata('admin_id'),
                            'Updated_date'  => date('Y-m-d h:i:s'),
                        );

                        ## for update admin_users table
                        $this->main_manager->update($id, $data, "testimonial");
                        $this->session->set_flashdata('msg', 'The data has been updated successfully');
                        redirect(SITE_ADMIN_URL . "testimonial/index/");
                    }##end else validation
                }##end if the form is submitted
                $final_data["final_data"] = $this->main_manager->select_by_id($id, "testimonial");
                $this->load->view('admin/header');
                $this->load->view('admin/sidebar',$data);
                $this->load->view('admin/edit_testimonial',$final_data);
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

            $this->main_manager->delete($id, "testimonial");
            redirect(SITE_ADMIN_URL . $this->router->fetch_class() . "/index", 'refresh');
            die();
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
                'Updated_By' => $this->session->userdata('admin_id'),
                'Updated_date' => date('Y-m-d h:i:s')

            );

            if ($this->main_manager->update($id, $data, "testimonial") == false) {
                $error['error'] = 'Cannot save. Please try again.';
            } else {

                $this->session->set_flashdata('msg', 'The data has been updated successfully');
                redirect(SITE_ADMIN_URL . "testimonial/index", 'refresh');
                die();
            }
        }
    }
}

?>