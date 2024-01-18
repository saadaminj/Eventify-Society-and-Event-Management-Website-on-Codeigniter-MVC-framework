<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Index_admin extends CI_Controller {

    private $sectionID = 5;

    public function __construct() {
        parent::__construct();
        // Your own constructor code
        $this->load->model(array("admin_manager","main_manager","joins_manager"));
        $this->load->helper(array('form','url'));
        $this->load->library(array('form_validation',"upload","pagination"));
        // main_manager
        $this->output->set_header("Cache-Control: no-store, no-cache, must-revalidate, no-transform, max-age=0, post-check=0, pre-check=0");
        $this->output->set_header("Pragma: no-cache");
    }

    public function index() {
        if ($this->session->userdata('adminLogged') != 'yes') {
            $this->load->view('admin/login');
        } else {
            
            $final_data = array();
            $id = $this->session->userdata('admin_id');
            $role = 1;
             $final_data['students']             = $this->main_manager-> record_count_by_col('role',1, 'users');
			 $final_data['faculty']             = $this->main_manager-> record_count_by_col('role',3, 'users');
             $final_data['society_president']             = $this->main_manager-> record_count_by_col('role',2, 'users');
             $final_data['events'] = $this->main_manager-> select_all_events('events');
             $final_data['no_events']=$final_data['events'][0]['COUNT(*)'];
             
            // $final_data['customers']         = $this->main_manager->record_count("sites_user");
            // $final_data['awaitingPayments'] = $this->main_manager->record_count_by_col("is_payment",0,"pkg_order");
            // $final_data['ordersCount']       = $this->main_manager->record_count("payments");
            // $final_data['subscribedCount']   = $this->main_manager->record_count("subscribed_email");


   //          $final_data['users']             = 0;
			// $final_data['customers']         = 0;
   //          $final_data['awaitingPayments'] = 0;
   //          $final_data['ordersCount']       = 0;
   //          $final_data['subscribedCount']   = 0;



            $this->load->view('admin/header');
            $this->load->view('admin/sidebar',$final_data);
            $this->load->view('admin/dashboard',$final_data);
            $this->load->view('admin/footer');
        }
    }
}

?>