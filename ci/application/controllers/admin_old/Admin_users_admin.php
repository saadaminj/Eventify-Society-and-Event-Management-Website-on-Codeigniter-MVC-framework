<?php

class Admin_users_admin extends CI_Controller {

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

    ## for fb login end

    public function index() {
        if ($this->session->userdata('adminLogged') != 'yes') {
            redirect(SITE_ADMIN_URL.'index_admin/index');
        } else {
            redirect(SITE_ADMIN_URL.'index_admin/index');
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
            if ($this->main_manager->update($id, $data, "users") == false) {
                $error['error'] = 'Cannot save. Please try again.';
            } else {
                $this->session->set_flashdata('msg', 'The data has been updated successfully');
                redirect(SITE_ADMIN_URL . "admin_users_admin/admin_users", 'refresh');
                die();
            }
        }
    }


    public function admin_users($id = NULL) {
        if ($this->session->userdata('adminLogged') != 'yes') {
            $this->load->view('admin/login');
        } else {
            $adminId                = $this->session->userdata('admin_id');
            $data['users'] = $this->main_manager->select_by_id($adminId,"users");
            $final_data['final_data'] = $this->joins_manager->getAdminUsers();
            $this->load->view('admin/header');
            $this->load->view('admin/sidebar',$data);
            $this->load->view('admin/view_admin_users',$final_data);
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
                $this->form_validation->set_rules('username', 'User Name', 'required|alpha_numeric');
                $this->form_validation->set_rules('email', 'Email', 'required');
                $this->form_validation->set_rules('password', 'Password', 'required');
                $this->form_validation->set_rules('first_name', 'First Name', 'required');
                $this->form_validation->set_rules('last_name', 'Last Name', 'required');
                $this->form_validation->set_rules('status', 'IS Active', 'required');
                if ($this->form_validation->run() == FALSE) {
                    $final_data['error'] = validation_errors();
                } else {
                    $user_name = $this->input->post('username');
                    $email     = $this->input->post('email');
                    $checkUserName  = $this->main_manager->select_by_other_id('username',$user_name,'users');
                    if($checkUserName != 0){
                        $this->session->set_flashdata('errorMsg', 'This user name already exsits');
                    }else{
                        $checkEmail = $this->main_manager->select_by_other_id('email',$email,'users');
                        if($checkEmail != 0){
                            $this->session->set_flashdata('errorMsg', 'This email already exsits');
                        }else{
                            $data = array(
                                'username'      => $user_name,
                                'email'         => $email,
                                'password'      => md5($this->input->post('password')),
                                'status'        => $this->input->post('status'),
                                'first_name'    => $this->input->post('first_name'),
                                'last_name'    => $this->input->post('last_name'),

                            );
                            ## for insert into admin_users table
                            $insertedId = $this->main_manager->insert_get_id($data, "users");
                            $this->session->set_flashdata('succMsg', 'The user has been added successfully');
                            redirect(SITE_ADMIN_URL . "admin_users_admin/admin_users");
                        }##end else validation
                    }##end if the form is submitted
                }
            }
            $this->load->view('admin/header');
            $this->load->view('admin/sidebar',$data);
            $this->load->view('admin/add_admin_users', $final_data);
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
            $final_data["final_data"] = $this->main_manager->select_by_id($id, "users");
            $this->pageAction = 'Update';
            if ($this->input->post('doAct') == strtolower($this->pageAction)) {
                $this->form_validation->set_rules('username', 'User Name', 'required|alpha_numeric');
                $this->form_validation->set_rules('email', 'Email', 'required');
                $this->form_validation->set_rules('first_name', 'First Name', 'required');
                $this->form_validation->set_rules('last_name', 'Last Name', 'required');
                $this->form_validation->set_rules('status', 'IS Active', 'required');
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
                                'id' => $id,
                                'username'      => $user_name,
                                'email'         => $email,
                                'password'      => $password,
                                'status'        => $this->input->post('status'),
                                'first_name'    => $this->input->post('first_name'),
                                'last_name'     => $this->input->post('last_name'),
                                'updated_at'  => date('Y-m-d h:i:s')
                            );
                            ## for update admin_users table
                            $this->main_manager->update($id, $data, "users");
                            $this->session->set_flashdata('msg', 'The data has been updated successfully');
                            redirect(SITE_ADMIN_URL . "admin_users_admin/admin_users");
                        }##end else validation
                    }##end if the form is submitted
                }
            }##end if the form is submitted
            $this->load->view('admin/header');
            $this->load->view('admin/sidebar',$data);
            $this->load->view('admin/edit_admin_users',$final_data);
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
            $data = array(
                'is_deleted' => 1
            );
            $this->main_manager->update($id, $data, "users");
            redirect(SITE_ADMIN_URL . $this->router->fetch_class() . "/admin_users", 'refresh');
            die();
        }
    }

    public function edit_premium($id = NULL) {
        if ($this->session->userdata('adminLogged') != 'yes') {
            $this->load->view('admin/header');
            $this->load->view('admin/login');
            $this->load->view('admin/footer');
        } else {
            $adminId = $this->session->userdata('admin_id');
            $data['users']    = $this->main_manager->select_by_id($adminId,"users");
            $final_data =array();
            $final_data["final_data"] = $this->main_manager->select_by_id($id, "users");
            $this->pageAction = 'Update';
            if ($this->input->post('doAct') == strtolower($this->pageAction)) {
                $last_exp_date = '';
                $last_subscription_date = '';
                $is_premium = 0;
                if(isset($_POST['last_exp_date'])){
                    $last_exp_date = $this->input->post('last_exp_date');
                    $last_subscription_date = date('Y-m-d h:i:s');
                    $is_premium = 1;
                }
                if(isset($_POST['expire'])){
                    $last_exp_date = date('Y-m-d h:i:s');
                    $is_premium = 0;
                }
                $data = array(
                    'last_exp_date' => $last_exp_date,
                    'last_subscription_date' => $last_subscription_date,
                    'is_premium'      => $is_premium
                );
                ## for update admin_users table
                $this->main_manager->update($id, $data, "users");
                $this->session->set_flashdata('msg', 'The data has been updated successfully');
                redirect(SITE_ADMIN_URL . "admin_users_admin/admin_users");
            }##end if the form is submitted
            $this->load->view('admin/header');
            $this->load->view('admin/sidebar',$data);
            $this->load->view('admin/edit_premium',$final_data);
            $this->load->view('admin/footer');
        }
    }
    

    public function block($id = NULL) {
        //userid
        if ($this->session->userdata('adminLogged') != 'yes') {
            $this->load->view('admin/header');
            $this->load->view('admin/login');
            $this->load->view('admin/footer');
        } else {

            //	$this->admin_manager->check_admin_auth($this->sectionID);
            ##delete from admin_users
            $data = array(
                'id' => $id,
                'is_blocked' => 1,
                    //			'type' => $this->input->post('type'),
            );
            ## for update admin_users table
            $this->main_manager->update($id, $data, "users");

            redirect(SITE_ADMIN_URL . $this->router->fetch_class() . "/index", 'refresh');
            die();
        }
    }

    public function unblock($id = NULL) {
        if ($this->session->userdata('adminLogged') != 'yes') {
            $this->load->view('admin/header');
            $this->load->view('admin/login');
            $this->load->view('admin/footer');
        } else {

            //	$this->admin_manager->check_admin_auth($this->sectionID);
            ##delete from admin_users
            $data = array(
                'id' => $id,
                'is_blocked' => 0,
                    //			'type' => $this->input->post('type'),
            );
            ## for update admin_users table
            $this->main_manager->update($id, $data, "users");

            redirect(SITE_ADMIN_URL . $this->router->fetch_class() . "/index", 'refresh');
            die();
        }
    }

    public function login() {
        
        $error = array();
        $this->form_validation->set_rules('user_name', 'User Name', 'trim|required');
        $this->form_validation->set_rules('password', 'Password', 'trim|required');

        if ($this->form_validation->run() == FALSE) {
            $error['error'] = validation_errors();
        } else {
            $user_name = $this->input->post("user_name");
            $password = md5($this->input->post("password"));
            $final_data = $this->admin_manager->check_admin_login($user_name, $password);
            if ($final_data == 0) {
                $error['error'] = "Invalid username or password";
            } else {
                ##insert into session
                $this->session->set_userdata('admin_id', $final_data[0]['id']);
                $this->session->set_userdata('adminLogged', "yes");
                redirect(SITE_ADMIN_URL . "index_admin/index", 'refresh');
                die();
            } //end else
        }
        //$this->load->view('admin/header');
        $this->load->view('admin/login', $error);
        //$this->load->view('admin/footer');
    }

//end function

    public function forget_password() {

        $error_data = array();
        $this->pageAction = 'Add';
        if ($this->input->post('doAct') == strtolower($this->pageAction)) {
            $this->form_validation->set_rules('email', 'Email', 'trim|required|valid_email');
            if ($this->form_validation->run() == FALSE) {
                
            } else {
                $final_data = $this->main_manager->select_by_other_id("email", $this->input->post("email"), "admins_users");
                if (count($final_data) < 1) {
                    $error["error"] = "no record found with this email address";
                } else {
                    $time = time();
                    $data = array(
                        'id' => $final_data[0]["id"],
                        'email' => $final_data[0]["email"],
                        'user_name' => $final_data[0]["user_name"],
                        'password' => $time,
                    );
                    $this->main_manager->update($final_data[0]["id"], $data, "admins_users");

                    $message = "";
                    $message .= "please click on the following link to update password.<br />";
                    $message .= '<a href="' . SITE_ADMIN_URL . 'admins_admin/update_password/' . $time . '">Update Password</a>';

                    $this->email->from('admin@efote.net', 'Eforte');
                    $this->email->to($email);
                    $this->email->subject('Forgot Password');
                    $this->email->message($message);

                    $this->email->send();

                    redirect(SITE_ADMIN_URL, 'refresh');
                }
            }
            ####validation return values end######
        }

        $error['forget_password'] = "forget_password";
        $this->load->view('admin/header');
        $this->load->view('admin/login', $error);
        $this->load->view('admin/footer');
    }

    public function update_password($time = NULL) {

        $error = array();
        $this->pageAction = 'Add';
        if ($this->input->post('doAct') == strtolower($this->pageAction)) {
            $this->form_validation->set_rules('user_name', 'User Name', 'trim|required');
            $this->form_validation->set_rules('password', 'Password', 'trim|required');
            $this->form_validation->set_rules('password', 'Confirm Password', 'trim|required|matches[c_password]');
            if ($this->form_validation->run() == FALSE) {
                
            } else {
                $password = md5($this->input->post("password"));
                $check_data = $this->admin_manager->check_by_username($this->input->post("user_name"));
                if ($check_data["password"] != $this->input->post('time')) {
                    $error = "You dont request for changing password";
                } else {
                    $final_data = $this->main_manager->select_by_other_id("user_name", $this->input->post("user_name"), "admins_users");
                    $data = array(
                        'id' => $final_data[0]["id"],
                        'email' => $final_data[0]["email"],
                        'user_name' => $final_data[0]["user_name"],
                        'password' => $password,
                    );

                    $this->main_manager->update($final_data[0]["id"], $data, "admins_users");

                    $this->session->set_userdata('admin_id', $final_data[0]['id']);
                    $this->session->set_userdata('email', $final_data[0]['email']);
                    $this->session->set_userdata('user_name', $final_data[0]['username']);
                    $this->session->set_userdata('adminLogged', "yes");
                    redirect(SITE_ADMIN_URL, 'refresh');
                    die();
                } //end else
            }
            ####validation return values end######
        }
        $error['time'] = $time;

        $this->load->view('admin/header');
        $this->load->view('admin/update_password', $error);
        $this->load->view('admin/footer');
    }

    public function logout() {

        $this->session->unset_userdata('admin_id');
        $this->session->unset_userdata('adminLogged');
        $this->session->unset_userdata('username');
        $this->session->unset_userdata('is_active');

        redirect(SITE_ADMIN_URL ."index_admin/index", 'refresh');
    }

    public function settings() {
        if ($this->session->userdata('adminLogged') != 'yes') {
            $this->load->view('header');
            $this->load->view('login');
            $this->load->view('footer');
        } else {
            //	$this->admin_manager->check_admin_auth($this->sectionID);
            $this->pageAction = 'Update';
            $id = $this->session->userdata("admin_id");
            if ($this->input->post('doAct') == strtolower($this->pageAction)) {

                $this->form_validation->set_rules('first_name', 'First Name', 'required');
                $this->form_validation->set_rules('last_name', 'Last Name', 'required');
                $this->form_validation->set_rules('user_name', 'User Name', 'required');
                $this->form_validation->set_rules('password', 'Password', 'required');

                if ($this->form_validation->run() == FALSE) {
                    $final_data['error'] = " ";
                } else {
                    if ($this->input->post("new_password") != "") {
                        $password = md5($this->input->post("new_password"));
                    } else {
                        $password = $this->input->post("password");
                    }

                    $data = array(
                        'first_name' => $this->input->post('first_name'),
                        'last_name' => $this->input->post('last_name'),
                        'username' => $this->input->post('user_name'),
                        'password' => $password,
                    );
                    ## for update admin_users table
                    $this->main_manager->update($id, $data, "users");
                    $this->session->set_flashdata('msg', 'The data has been updated successfully');
                    redirect(SITE_ADMIN_URL . "admin_users_admin/index/");
                }##end else validation
            }##end if the form is submitted
            $final_data["final_data"] = $this->main_manager->select_by_id($id, "users");
            $this->load->view('admin/header');
            $this->load->view('admin/admin_user_settings', $final_data);
            $this->load->view('admin/footer');
        }
    }

    public function test_setting($id = 1) {
        if ($this->session->userdata('adminLogged') != 'yes') {
            $this->load->view('admin/header');
            $this->load->view('admin/login');
            $this->load->view('admin/footer');
        } else {
            $adminId = $this->session->userdata('admin_id');
            $data['users']    = $this->main_manager->select_by_id($adminId,"users");
            $final_data =array();
            $final_data["final_data"] = $this->main_manager->select_by_id($id, "settings");
            $this->pageAction = 'Update';
            if ($this->input->post('doAct') == strtolower($this->pageAction)) {
                $data = array(
                    'no_of_free_questions' => $this->input->post('no_of_free_questions'),
                    'no_of_paid_questions' => $this->input->post('no_of_paid_questions'),
                    'point_free'      => $this->input->post('point_free'),
                    'point_paid' => $this->input->post('point_paid'),
                    'duration_free' => $this->input->post('duration_free'),
                    'duration_paid'      => $this->input->post('duration_paid'),
                    'passing_percentage'      => $this->input->post('passing_percentage')
                );
                ## for update admin_users table
                $this->main_manager->update($id, $data, "settings");
                $this->session->set_flashdata('msg', 'The data has been updated successfully');
                redirect(SITE_ADMIN_URL . "admin_users_admin/test_setting");
            }##end if the form is submitted
            $this->load->view('admin/header');
            $this->load->view('admin/sidebar',$data);
            $this->load->view('admin/edit_setting',$final_data);
            $this->load->view('admin/footer');
        }
    }

    public function subscribe() {
        if ($this->session->userdata('adminLogged') != 'yes') {
            $this->load->view('admin/login');
        } else {
            $adminId = $this->session->userdata('admin_id');
            $data['users'] = $this->main_manager->select_by_id($adminId,"users");
            $final_data['final_data'] = $this->main_manager->select_all('subscribe_user');
            $this->load->view('admin/header');
            $this->load->view('admin/sidebar',$data);
            $this->load->view('admin/view_subscribe',$final_data);
            $this->load->view('admin/footer');
        }
    }

    public function contact() {
        if ($this->session->userdata('adminLogged') != 'yes') {
            $this->load->view('admin/login');
        } else {
            $adminId = $this->session->userdata('admin_id');
            $data['users'] = $this->main_manager->select_by_id($adminId,"users");
            $final_data['final_data'] = $this->main_manager->select_all('contacted_user');
            $this->load->view('admin/header');
            $this->load->view('admin/sidebar',$data);
            $this->load->view('admin/view_contact',$final_data);
            $this->load->view('admin/footer');
        }
    }
    
    public function payment_setting($id = 1) {
        if ($this->session->userdata('adminLogged') != 'yes') {
            $this->load->view('admin/header');
            $this->load->view('admin/login');
            $this->load->view('admin/footer');
        } else {
            $adminId = $this->session->userdata('admin_id');
            $data['users']    = $this->main_manager->select_by_id($adminId,"users");
            $final_data =array();
            $final_data["final_data"] = $this->main_manager->select_by_id($id, "payment_settings");
            $this->pageAction = 'Update';
            if ($this->input->post('doAct') == strtolower($this->pageAction)) {
                $data = array(
                    'amount' => $this->input->post('amount'),
                    'email' => $this->input->post('email'),
                    'type'      => $this->input->post('type')
                );
                ## for update admin_users table
                $this->main_manager->update($id, $data, "payment_settings");
                $this->session->set_flashdata('msg', 'The data has been updated successfully');
                redirect(SITE_ADMIN_URL . "admin_users_admin/payment_setting");
            }##end if the form is submitted
            $this->load->view('admin/header');
            $this->load->view('admin/sidebar',$data);
            $this->load->view('admin/edit_update',$final_data);
            $this->load->view('admin/footer');
        }
    }

}

?>
