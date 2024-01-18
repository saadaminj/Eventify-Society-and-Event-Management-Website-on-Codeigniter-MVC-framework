<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Users_admin extends CI_Controller {

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
          $id = $this->session->userdata('admin_id');
            
            $final_data["final_data"] = $this->main_manager->select_by_id($id, "users"); 


                $this->pageAction = 'Update';
                if ($this->input->post('doAct') == strtolower($this->pageAction)) {
                $this->form_validation->set_rules('username', 'User Name', 'required|alpha_numeric');
                $this->form_validation->set_rules('email', 'Email', 'required');
                if ($this->form_validation->run() == FALSE) {
                    $final_data['error'] = validation_errors();
                    print_r($final_data['error']);
                    die;
                        
                } else {

                    $user_name = $this->input->post('username');
                    $email     = $this->input->post('email');
                    $checkUserName  = $this->joins_manager->chcekUserNameById($id, $user_name);
                    if($checkUserName != 0){
                      $this->session->set_flashdata('errorMsg', 'This user name already exsits');
                    }else{
                    $checkEmail = $this->joins_manager->chcekEmailById($id, $email);
                    if($checkEmail != 0){
                       $this->session->set_flashdata('errorMsg', 'This email already exsits');
                    }else{ 
                    
                    $password = ($this->input->post('password') != NULL)? md5($this->input->post('password')): $final_data["final_data"][0]['password'];
                    

                    $data = array(
                        'id'            => $id,
                        'username'      => $user_name,
                        'email'         => $email,
                        'password'      => $password,
                          );

                    ## for update admin_users table
                    $this->main_manager->update($id, $data, "users");
                    

                    
                    $this->session->set_flashdata('msg', 'The data has been updated successfully');
                    redirect(SITE_ADMIN_URL . "users_admin/index");
                   
                    
                    $this->session->set_flashdata('succMsg', 'The data has been added successfully');
                    redirect(SITE_ADMIN_URL . "users_admin/index");
                }##end else validation
            }##end if the form is submitted
        }
        }##end if the form is submitted


            $this->load->view('admin/header');
            $this->load->view('admin/sidebar',$final_data);
            $this->load->view('admin/edit_profile',$final_data);
            $this->load->view('admin/footer');
        }
    }
}

?>