<?php

class Cms extends CI_Controller {

    public $table = "cms_pages";
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

    public function index() {
        if ($this->session->userdata('adminLogged') != 'yes') {
            $this->load->view('admin/login');
        } else {
            $adminId = $this->session->userdata('admin_id');
            $data['users'] = $this->main_manager->select_by_id($adminId,"users");
            $final_data['final_data'] = $this->main_manager->select_all('cms_pages');
            $this->load->view('admin/header');
            $this->load->view('admin/sidebar',$data);
            $this->load->view('admin/view_cms',$final_data);
            $this->load->view('admin/footer');
        }
    }

    public function detail($id = NULL) {
        if ($this->session->userdata('adminLogged') != 'yes') {
            $this->load->view('admin/header');
            $this->load->view('admin/login');
            $this->load->view('admin/footer');
        } else {
            $adminId = $this->session->userdata('admin_id');
            $data['users'] = $this->main_manager->select_by_id($adminId,"users");
            $final_data['final_data'] = $this->main_manager->select_by_id($id, "cms_pages");
            $this->load->view('admin/header');
            $this->load->view('admin/sidebar',$data);
            $this->load->view('admin/view_cms_detail', $final_data);
            $this->load->view('admin/footer');
        }
    }

    public function edit($id = NULL) {

        if ($this->session->userdata('adminLogged') != 'yes') {
            $this->load->view('admin/header');
            $this->load->view('admin/login');
            $this->load->view('admin/footer');
        } else {
            $adminId = $this->session->userdata('admin_id');
            $data['users']    = $this->main_manager->select_by_id($adminId,"users");
            $final_data =array();
            $final_data["final_data"] = $this->main_manager->select_by_id($id, "cms_pages");
            $this->pageAction = 'Update';
            if ($this->input->post('doAct') == 'update') {
                $this->form_validation->set_rules('text', 'Text', 'required');
                if ($this->form_validation->run() == FALSE) {
                    $final_data['error'] = validation_errors();
                } else {
                    $data = array(
                        'text'         => $this->input->post('text'),
                    );
                    $this->main_manager->update($id, $data, 'cms_pages');
                    $this->session->set_flashdata('msg', 'The data has been updated successfully');
                    redirect(SITE_ADMIN_URL . "cms/edit/".$id);
                }
            }##end if the form is submitted
            $this->load->view('admin/header');
            $this->load->view('admin/sidebar',$data);
            $this->load->view('admin/edit_cms',$final_data);
            $this->load->view('admin/footer');
        }
    }
}

?>
