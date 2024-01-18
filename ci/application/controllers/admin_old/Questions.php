<?php

class Questions extends CI_Controller {

    public $table = "admin_users";
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
            $final_data['final_data'] = $this->main_manager->select_all('questions');
            $this->load->view('admin/header');
            $this->load->view('admin/sidebar',$data);
            $this->load->view('admin/view_questions',$final_data);
            $this->load->view('admin/footer');
        }
    }

    public function detail($id = NULL) {
        if ($this->session->userdata('adminLogged') != 'yes') {
            $this->load->view('admin/header');
            $this->load->view('admin/login');
            $this->load->view('admin/footer');
        } else {

            $final_data['final_data'] = $this->main_manager->select_by_id($id, "users");

            $this->load->view('admin/header');
            $this->load->view('admin/view_admin_users_detail', $final_data);
        }
    }

    public function add() {
        if ($this->session->userdata('adminLogged') != 'yes') {
            $this->load->view('admin/header');
            $this->load->view('admin/login');
            $this->load->view('admin/footer');
        } else {
            $adminId = $this->session->userdata('admin_id');
            $data['users']    = $this->main_manager->select_by_id($adminId,"users");
            $final_data = array();
            $this->pageAction = 'Add';
            if ($this->input->post('doAct') == strtolower($this->pageAction)) {
                $this->form_validation->set_rules('question', 'Question', 'required');
                $this->form_validation->set_rules('option1', 'Option 1', 'required');
                $this->form_validation->set_rules('option2', 'Option 2', 'required');
                $this->form_validation->set_rules('option3', 'Option 3', 'required');
                $this->form_validation->set_rules('option4', 'Option 4', 'required');
                $this->form_validation->set_rules('explain', 'Explaination', 'required');
                $this->form_validation->set_rules('is_right', 'Right Answer', 'required');
                $this->form_validation->set_rules('is_free', 'Free Question', 'required');
                if ($this->form_validation->run() == FALSE) {
                    $final_data['error'] = validation_errors();
                    d($final_data['error']);
                    die;
                } else {
                    $checkQuestionCount = $this->main_manager->select_all('questions');
                    $getTotalQuestion = $this->main_manager->select_all('settings');
                    $allowQuestion = $getTotalQuestion[0]['no_of_paid_questions'];
                    if($checkQuestionCount == 0){
                        $checkQuestionCount = 0;
                    }else{
                        $checkQuestionCount = count($checkQuestionCount);
                    }
                    if($checkQuestionCount <= $allowQuestion){
                        $data = array(
                            'sort_no'      => 1,
                            'text'         => $this->input->post('question'),
                            'option1' => $this->input->post('option1'),
                            'option2' => $this->input->post('option2'),
                            'option3' => $this->input->post('option3'),
                            'option4' => $this->input->post('option4'),
                            'explain' => $this->input->post('explain'),
                            'is_right' => $this->input->post('is_right'),
                            'is_free' => $this->input->post('is_free')

                        );
                        $insertedId = $this->main_manager->insert_get_id($data, "questions");
                        $this->session->set_flashdata('succMsg', 'The question has been added successfully');
                        redirect(SITE_ADMIN_URL . "questions");   
                    }else{
                        $this->session->set_flashdata('errorMsg', 'Question quota is full please increase the size of paid question in setting tab.');
                        redirect(SITE_ADMIN_URL . "questions");
                    }
                }
            }
            $this->load->view('admin/header');
            $this->load->view('admin/sidebar',$data);
            $this->load->view('admin/add_questions', $final_data);
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
            $final_data["final_data"] = $this->main_manager->select_by_id($id, "questions");
            $this->pageAction = 'Update';
            if ($this->input->post('doAct') == 'update') {
                
                $this->form_validation->set_rules('question', 'Question', 'required');
                $this->form_validation->set_rules('option1', 'Option 1', 'required');
                $this->form_validation->set_rules('option2', 'Option 2', 'required');
                $this->form_validation->set_rules('option3', 'Option 3', 'required');
                $this->form_validation->set_rules('option4', 'Option 4', 'required');
                $this->form_validation->set_rules('explain', 'Explaination', 'required');
                $this->form_validation->set_rules('is_right', 'Right Answer', 'required');
                $this->form_validation->set_rules('is_free', 'Free Question', 'required');
                if ($this->form_validation->run() == FALSE) {
                    $final_data['error'] = validation_errors();
                } else {
                    $data = array(
                        'sort_no'      => 1,
                        'text'         => $this->input->post('question'),
                        'option1' => $this->input->post('option1'),
                        'option2' => $this->input->post('option2'),
                        'option3' => $this->input->post('option3'),
                        'option4' => $this->input->post('option4'),
                        'explain' => $this->input->post('explain'),
                        'is_right' => $this->input->post('is_right'),
                        'is_free' => $this->input->post('is_free')

                    );
                    $this->main_manager->update($id, $data, 'questions');
                    $this->session->set_flashdata('msg', 'The data has been updated successfully');
                    redirect(SITE_ADMIN_URL . "questions");
                }
            }##end if the form is submitted
            $this->load->view('admin/header');
            $this->load->view('admin/sidebar',$data);
            $this->load->view('admin/edit_question',$final_data);
            $this->load->view('admin/footer');
        }
    }

    public function delete($id = NULL) {
        if ($this->session->userdata('adminLogged') != 'yes') { 
            $this->load->view('admin/header');
            $this->load->view('admin/sidebar');
            $this->load->view('admin/login');
            $this->load->view('admin/footer');
        } else {
            $this->main_manager->delete($id, "questions");
            redirect(SITE_ADMIN_URL . "questions/", 'refresh');
            die();
        }
    }

    

}

?>
