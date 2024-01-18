<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Privacy_policy extends CI_Controller
{

    public $viewPage = '_users'; //lowercase term for the page name, i.e : mypage, editMypage, addMypage
    public $table = "users";
    private $sectionID = 3;

    public function __construct()
    {
        parent::__construct();
        // Your own constructor code
        $this->load->model(array("admin_manager", "main_manager", "joins_manager"));
        $this->load->helper(array('form', 'url'));
        $this->load->library(array('form_validation', 'pagination', 'upload'));
        $this->output->set_header("Cache-Control: no-store, no-cache, must-revalidate, no-transform, max-age=0, post-check=0, pre-check=0");
        $this->output->set_header("Pragma: no-cache");
    }

    public function index()
    {
        if ($this->session->userdata('adminLogged') != 'yes') {
            redirect(SITE_ADMIN_URL);
        } else {
            $adminId = $this->session->userdata('admin_id');
            $data['users']    = $this->main_manager->select_by_id($adminId,"users");
            $checkPermission = $this->joins_manager->userPermisionByMethod($adminId, 54);
            if ($checkPermission == 1 || $adminId == 1) {
                $final_data['final_data'] = $this->main_manager->select_all('privacy_policy');
                $this->load->view('admin/header');
                $this->load->view('admin/sidebar',$data);
                $this->load->view('admin/view_privacy_policy', $final_data);
                $this->load->view('admin/footer');
            } else {
                $this->load->view('admin/notallowed');
            }

        }
    }

    public function edit($id = NULL)
    {
        if ($this->session->userdata('adminLogged') != 'yes') {
            redirect(SITE_ADMIN_URL);
        } else {
            $adminId = $this->session->userdata('admin_id');
            $data['users']    = $this->main_manager->select_by_id($adminId,"users");
            $checkPermission = $this->joins_manager->userPermisionByMethod($adminId, 55);
            if ($checkPermission == 1 || $adminId == 1) {
                $final_data = array();
                $this->pageAction = 'Update';
                if ($this->input->post('doAct') == strtolower($this->pageAction)) {
                    $this->form_validation->set_rules('title', 'title', 'required');
                    $this->form_validation->set_rules('alt_text', 'Image alt text', 'required');
                    $this->form_validation->set_rules('image_title', 'Image Title', 'required');
                    $this->form_validation->set_rules('description', 'description', 'required');
                    if ($this->form_validation->run() == FALSE) {
                        $final_data['error'] = " ";
                    } else {

                         if (!empty($_FILES["userfile"]["tmp_name"])) {
                            $config['upload_path'] = './assets/files/privacy_policy/';
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
                            'title'             => $this->input->post('title'),
                            'description'       => $this->input->post('description'),
                            'image'             => $image,
                            'alt_text'          => $this->input->post('alt_text'),
                            'image_title'       => $this->input->post('image_title'),
                            'updated_by'        => $this->session->userdata('admin_id'),
                            'updated_date'      => date('Y-m-d h:i:s'),
                        );

                        ## for update admin_users table
                        $this->main_manager->update(1, $data, "privacy_policy");
                        $this->session->set_flashdata('msg', 'The data has been updated successfully');
                        redirect(SITE_ADMIN_URL . "privacy_policy/index");
                    }##end else validation
                }##end if the form is submitted
                $final_data["final_data"] = $this->main_manager->select_by_id(1, "privacy_policy");
                $this->load->view('admin/header');
                $this->load->view('admin/sidebar',$data);
                $this->load->view('admin/edit_privacy_policy', $final_data);
                $this->load->view('admin/footer');
            } else {
                $this->load->view('admin/notallowed');
            }

        }
    }

}
?>