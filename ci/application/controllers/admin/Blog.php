<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Blog extends CI_Controller {

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
            $checkPermission = $this->joins_manager->userPermisionByMethod($adminId,29);
            if($checkPermission == 1 || $adminId == 5  || $adminId == 13){
                $final_data['final_data'] = $this->joins_manager->getBlog();
                $this->load->view('admin/header');
                $this->load->view('admin/sidebar',$data);
                $this->load->view('admin/view_blog',$final_data);
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
            $checkPermission = $this->joins_manager->userPermisionByMethod($adminId,30);
            if($checkPermission == 1 || $adminId == 1){
                $final_data = array();
                $this->pageAction = 'Add';
                if ($this->input->post('doAct') == strtolower($this->pageAction)) {

                    $this->form_validation->set_rules('Title', 'Title', 'required');
                    $this->form_validation->set_rules('Author', 'Author', 'required');
                    $this->form_validation->set_rules('date', 'date', 'required');
                    $this->form_validation->set_rules('tags', 'tags');
                    $this->form_validation->set_rules('slug', 'slug', 'required');
                    $this->form_validation->set_rules('alt_text', 'Image alt text', 'required');
                    $this->form_validation->set_rules('image_title', 'Image Title', 'required');
                    $this->form_validation->set_rules('Description', 'Description', 'required');
                    $this->form_validation->set_rules('page-title', 'page-title', 'required');
                    $this->form_validation->set_rules('page-key', 'page-key');
                    $this->form_validation->set_rules('page-description', 'page-description');
                    $this->form_validation->set_rules('shortDescription', 'shortDescription', 'required');
                    $this->form_validation->set_rules('Status', 'Status', 'required');
                     $this->form_validation->set_rules('category', 'category', 'required');
                    if ($this->form_validation->run() == FALSE) {
                        $final_data['error'] = validation_errors();
                    } else {
                        
                        $newSlug        = $this->main_manager->convert_text($this->input->post('slug'));
                        $slug1          = str_replace(" ","-",$newSlug);
                        $slug           = strtolower($slug1);
                        $newtags        = $this->main_manager->convert_text($this->input->post('tags'));
                        $blog_title     = $this->input->post('Title');
                        $blogTitleCheck = $this->main_manager->select_by_other_id('Title',$blog_title,'blog');
                        if($blogTitleCheck != 0){

                            $this->session->set_flashdata('errorMsg', 'This blog already exsits');
                        }else{

                        if (!empty($_FILES["userfile"]["tmp_name"])) {
                            $config['upload_path'] = './assets/files/blog/';
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
                            $imageName = 'defaultBlogImg.png';
                        }

                        $data = array(
                            'Title'             => $this->input->post('Title'),
                            'slug'              => $slug, 
                            'Author'            => $this->input->post('Author'),
                            'date'              => $this->input->post('date'),
                            'alt_text'          => $this->input->post('alt_text'),
                            'image_title'       => $this->input->post('image_title'),
                            'tags'              => $newtags,
                            'shortDescription'  => $this->input->post('shortDescription'),
                            'page-title'        => $this->input->post('page-title'),
                            'page-key'          => $this->input->post('page-key'),
                            'page-description'  => $this->input->post('page-description'),
                            'Description'       => $this->input->post('Description'),
                            'Image'             => $imageName,
                            'Status'            => $this->input->post('Status'),
                            'cat_id'            => $this->input->post('category'),
                            'Created_date'      => date('Y-m-d h:i:s'),
                            'Created_By'        => $this->session->userdata('admin_id')
                        );

                        ## for insert into admin_users table
                        $this->main_manager->insert($data, "blog");
                        $this->session->set_flashdata('msg', 'The data has been added successfully');
                        redirect(SITE_ADMIN_URL . $this->router->fetch_class() . "/index");
                    }

                    }##end if the form is submitted
                }
                $final_data['final_data'] = $this->main_manager->select_all('blog_category');

                $this->load->view('admin/header');
                $this->load->view('admin/sidebar',$data);
                $this->load->view('admin/add_blog',$final_data);
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
            $checkPermission = $this->joins_manager->userPermisionByMethod($adminId,31);
            if($checkPermission == 1 || $adminId == 1){
                $final_data = array();
                $this->pageAction = 'Update';

                if ($this->input->post('doAct') == strtolower($this->pageAction)) {
                    $this->form_validation->set_rules('Title', 'Title', 'required');
                    $this->form_validation->set_rules('Author', 'Author', 'required');
                    $this->form_validation->set_rules('Description', 'Description', 'required');
                    $this->form_validation->set_rules('alt_text', 'Image alt text', 'required');
                    $this->form_validation->set_rules('image_title', 'Image Title', 'required');
                    $this->form_validation->set_rules('slug', 'slug', 'required');
                    $this->form_validation->set_rules('tags', 'tags');
                    $this->form_validation->set_rules('date', 'date', 'required');
                    $this->form_validation->set_rules('page-title', 'page-title', 'required');
                    $this->form_validation->set_rules('page-key', 'page-key');
                    $this->form_validation->set_rules('page-description', 'page-description');
                    $this->form_validation->set_rules('shortDescription', 'shortDescription', 'required');
                    $this->form_validation->set_rules('Status', 'Status', 'required');
                    $this->form_validation->set_rules('category', 'category', 'required');

                    if ($this->form_validation->run() == FALSE) {
                        $final_data['error'] = " ";
                    } else {

                        $newSlug        = $this->main_manager->convert_text($this->input->post('slug'));
                        $slug1          = str_replace(" ","-",$newSlug);
                        $slug           = strtolower($slug1);
                        $newtags        = $this->main_manager->convert_text($this->input->post('tags'));
                        $blog_title     = $this->input->post('Title');
                        $checkBlogName  = $this->joins_manager->chcekBlogTitleById($id, $blog_title);

                        if($checkBlogName != 0){
                            $this->session->set_flashdata('errorMsg', 'This Blog already exsits');
                        }else{

                        

                         if (!empty($_FILES["userfile"]["tmp_name"])) {
                            $config['upload_path'] = './assets/files/blog/';
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
                            'ID'                => $id,
                            'Title'             => $this->input->post('Title'),
                            'slug'              => $slug,
                            'Description'       => $this->input->post('Description'),
                            'shortDescription'  => $this->input->post('shortDescription'),
                            'Author'            => $this->input->post('Author'),
                            'date'              => $this->input->post('date'),
                            'alt_text'          => $this->input->post('alt_text'),
                            'image_title'       => $this->input->post('image_title'),
                            'tags'              => $newtags,
                            'page-title'        => $this->input->post('page-title'),
                            'page-key'          => $this->input->post('page-key'),
                            'page-description'  => $this->input->post('page-description'),
                            'Status'            => $this->input->post('Status'),
                            'cat_id'            => $this->input->post('category'),
                            'Updated_date'      => date('Y-m-d h:i:s'),
                            'Image'             => $image,
                            'Updated_By'        => $this->session->userdata('admin_id'),
                            'Updated_date'      => date_create('now', timezone_open('Asia/Karachi'))->format('Y-m-d H:i:s'),
                        );

                        ## for update admin_users table
                        $this->main_manager->update($id, $data, "blog");
                        $this->session->set_flashdata('msg', 'The data has been updated successfully');
                        redirect(SITE_ADMIN_URL . "blog/index");
                    }##end else validation
                  }
                }##end if the form is submitted

                $final_data["final_data"] = $this->main_manager->select_by_id($id, "blog");
                $final_data['blog_category'] = $this->main_manager->select_all('blog_category');
                $this->load->view('admin/header');
                $this->load->view('admin/sidebar',$data);
                $this->load->view('admin/edit_blog',$final_data);
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

            $this->main_manager->delete($id, "blog");
            redirect(SITE_ADMIN_URL . $this->router->fetch_class() . "/index", 'refresh');
            die();
        }
    }

    
    public function acitve_inactive($id = NULL, $is_active = NULL) {
        if ($this->session->userdata('adminLogged') != 'yes') {
            redirect(SITE_ADMIN_URL);
        } else {
            $data = array(
                'id' => $id,
                'Status' => $is_active,
                'Updated_By' => $this->session->userdata('admin_id'),
                'Updated_date' => date('Y-m-d h:i:s')
            );

            if ($this->main_manager->update($id, $data, "blog") == false) {
                $error['error'] = 'Cannot save. Please try again.';
            } else {

                $this->session->set_flashdata('msg', 'The data has been updated successfully');
                redirect(SITE_ADMIN_URL . "blog/index", 'refresh');
                die();
            }
        }
    }

    public function comments() {
        if ($this->session->userdata('adminLogged') != 'yes') {
            redirect(SITE_ADMIN_URL);
        } else {
            $adminId = $this->session->userdata('admin_id');
            $data['users']    = $this->main_manager->select_by_id($adminId,"users");
            $checkPermission = $this->joins_manager->userPermisionByMethod($adminId,29);
            if($checkPermission == 1 || $adminId == 1){
                $final_data['final_data'] = $this->joins_manager->getComments();
                $this->load->view('admin/header');
                $this->load->view('admin/sidebar',$data);
                $this->load->view('admin/view_comments',$final_data);
                $this->load->view('admin/footer');
            }else{
                $this->load->view('admin/notallowed');
            }
        }
    }

    public function viewComment($id) {
        if ($this->session->userdata('adminLogged') != 'yes') {
            redirect(SITE_ADMIN_URL);
        } else {
            $adminId = $this->session->userdata('admin_id');
            $data['users']    = $this->main_manager->select_by_id($adminId,"users");
            $checkPermission = $this->joins_manager->userPermisionByMethod($adminId,29);
            if($checkPermission == 1 || $adminId == 1){
                $final_data['final_data'] = $this->joins_manager->getCommentView($id);
                $this->load->view('admin/header');
                $this->load->view('admin/sidebar',$data);
                $this->load->view('admin/approved_comment',$final_data);
                $this->load->view('admin/footer');
            }else{
                $this->load->view('admin/notallowed');
            }
        }
    }

    public function Approved($id = NULL, $is_approved = NULL) {
        if ($this->session->userdata('adminLogged') != 'yes') {
            redirect(SITE_ADMIN_URL);
        } else {
            $data = array(
                'id' => $id,
                'is_approved' => $is_approved,
                'approved_by' => $this->session->userdata('admin_id'),
            );

            if ($this->main_manager->update($id, $data, "blog_comments") == false) {
                $error['error'] = 'Cannot save. Please try again.';
            } else {

                $this->session->set_flashdata('msg', 'The data has been updated successfully');
                redirect(SITE_ADMIN_URL . "blog/comments", 'refresh');
                die();
            }
        }
    }

}

?>