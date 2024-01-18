<?php

class Index extends CI_Controller
{
	public function __construct() 
    { 
    	parent::__construct();
    	$this->load->model(array("admin_manager", "main_manager","joins_manager"));
        $this->load->library(array("form_validation", "email"));
        $this->load->helper('cookie');
        $this->output->set_header("Cache-Control: no-store, no-cache, must-revalidate, no-transform, max-age=0, post-check=0, pre-check=0");
        $this->output->set_header("Pragma: no-cache");
    } 
	
	public function index()
	{
		$this->load->view('frontend/header');
		$this->load->view('frontend/index');
		$this->load->view('frontend/footer');
	}
	public function socities()
	{
		$this->load->view('frontend/header');
		$this->load->view('frontend/socities');
		$this->load->view('frontend/footer');
	}
	public function contact_us()
	{
		$this->load->view('frontend/header');
		$this->load->view('frontend/contact');
		$this->load->view('frontend/footer');
	}
	public function signup()
	{
		if(isset($_POST['signup']))
		{
			$this->form_validation->set_rules('fname','Firstname','required');
			$this->form_validation->set_rules('lname','Lastname','required');
			$this->form_validation->set_rules('BATCH','BATCH','required');
			$this->form_validation->set_rules('SECTION','SECTION','required');
			$this->form_validation->set_rules('email','Email','required|is_unique[users.email]');
			$this->form_validation->set_rules('username','username','required|is_unique[users.username]');
			$this->form_validation->set_rules('role','Role','required');
			
			$this->form_validation->set_rules('password','Password','required|min_length[5]');
			$this->form_validation->set_rules('confirm_password','confirm_password','required|min_length[5]|matches[password]');
			if ($this->form_validation->run() == TRUE) 
			{
				echo "FORM VALDATED";

				$data = array(
					'email' => $_POST['email'],
					'username' =>$_POST['username'],
					'firstname' =>$_POST['fname'],
					'lastname' =>$_POST['lname'],
					'password' => md5($_POST['password']),
					'role' => $_POST['role'],
					'token' => md5(strtotime(date('y-m-d h:i:s'))),
					'BATCH'=>$_POST['BATCH'],
					'SECTION'=>$_POST['SECTION']

					 );
			  

			$this->db->insert('users',$data);
			$user_id = $this->db->insert_id();
			//email code here 
			$link = base_url().'email-verification/'.$data['token'].'/'.md5($user_id);
			$message = '<html>';
			$message .= '<body>';
			$message .= "<p> Please click <a href='".$link."'> here</a> to confirm your account</p>";
			$message .= '</body>';
			$message .= '</html>';



			print_r($message) ;
					
			$this->load->library('email');
			$this->email->from('azhanali777@gmail.com');
			$this->email->to($data['email']);
			$this->email->subject('Email Test');
			$this->email->message($message);
			$this->email->send();


			// base_url().'email-verification/'.$data['token'].'/'.md5($user_id)
			$this->session->set_flashdata("success","Your account has been created");
			redirect('congratulations',"refresh");
			}	
		
		}

		$this->load->view('frontend/header');
		$this->load->view('frontend/signup');
		$this->load->view('frontend/footer');
	}
	public function dashboardaddevent()
	{

		if(isset($_POST['AddEvent']))
		{
			$this->form_validation->set_rules('title','Title','required');
			$this->form_validation->set_rules('society','Society','required');
			$this->form_validation->set_rules('date','Date','required');
			$this->form_validation->set_rules('totalseats','TotalSeats','required');
			$this->form_validation->set_rules('description','Description','required');
			
			if ($this->form_validation->run() == TRUE) 
			{
				echo "FORM VALDATED";

				$data = array(
					'title' => $_POST['title'],
					'Society' =>$_POST['society'],
					'event_date' =>$_POST['date'],
					'total_seats' =>$_POST['totalseats'],
					'description' => $_POST['description'],
					'user_id' => $id = $this->session->userdata('user_id')
					);
			  

			 $this->db->insert('events',$data);
			 $user_id = $this->db->insert_id();
			 $this->session->set_flashdata("success","Your account has been created");
				redirect('addeventconfirm',"refresh");
			
	     	}
	   }
	 $this->load->view('frontend/header');
		$this->load->view('frontend/dashboardaddevent');
		$this->load->view('frontend/footer');
		  
	}     

	public function addeventconfirm()
	{
		$this->load->view('frontend/dashboardheader');
		$this->load->view('frontend/addeventconfirm');
		$this->load->view('frontend/footer');
		
	}
	public function congratulations()
	{
		$this->load->view('frontend/header');
		$this->load->view('frontend/congratulations');
		$this->load->view('frontend/footer');
		
	}
	public function dashboard()
	{
		//echo '<pre>'; print_r($this->session->all_userdata());//exit;
		$this->load->view('frontend/dashboardheader');
		$this->load->view('frontend/dashboard');
		$this->load->view('frontend/footer');
		
	}
	
	public function dashboardprofile()
	{
		$id = $this->session->userdata('user_id');
		$checkToken = $this->main_manager->select_by_other_id('id', $id, 'users');

		 $newdata = array('pagedata' => $checkToken);   	
		$this->load->view('frontend/dashboardheader');
		$this->load->view('frontend/dashboardprofile',$newdata);
		$this->load->view('frontend/footer');
	
	}
	
	//$this->main_manager->update($id, $data, "users") == false
	public function dashboarddeleteevent($id)
	{
		$result = $this->main_manager->delete($id, 'events');
		if($result === true)
		{
		$this->load->view('frontend/dashboardheader');
		$this->load->view('frontend/dashboarddeleteevent');
		$this->load->view('frontend/footer');
	
		}
		else
		{
		$this->load->view('frontend/dashboardheader');
		$this->load->view('frontend/errorevent');
		$this->load->view('frontend/footer');
		}

	}
	public function dashboardupdateevent($id)
	{
		$final_data = $this->main_manager->select_by_id($id, 'events');
		$newdata = array('pagedata' => $final_data );

		if(isset($_POST['UpdateEvent']))
		{
			$this->form_validation->set_rules('title','Title','required');
			$this->form_validation->set_rules('society','Society','required');
			$this->form_validation->set_rules('date','Date','required');
			$this->form_validation->set_rules('totalseats','TotalSeats','required');
			$this->form_validation->set_rules('description','Description','required');
			
			if ($this->form_validation->run() == TRUE) 
			{
				echo "FORM VALDATED";

				$data = array(
					'title' => $_POST['title'],
					'Society' =>$_POST['society'],
					'event_date' =>$_POST['date'],
					'total_seats' =>$_POST['totalseats'],
					'description' => $_POST['description'],
					'user_id' => $this->session->userdata('user_id')
					);
				
			
			$result = $this->main_manager->update($id,$data,'events');	
		    		

			if($result == 1)
			{
					 redirect(base_url() . "success", 'refresh');
					}
			else
			{
				$final_data =  "Oops Something went wrong";
				$this->load->view('frontend/dashboardheader');
				$this->load->view('frontend/errorevent',$final_data);
				$this->load->view('frontend/footer');
			}
			 // $this->db->insert('events',$data);
			 // $user_id = $this->db->insert_id();
			 // $this->session->set_flashdata("success","Your account has been created");
				// redirect('congratulations',"refresh");
			
	     	}
	   }
		
		$this->load->view('frontend/dashboardheader');
		$this->load->view('frontend/dashboardupdateevent',$newdata);
		$this->load->view('frontend/footer');	
	}
	public function errorevent()
	{
	    $this->load->view('frontend/dashboardheader');
		$this->load->view('frontend/errorevent');

		$this->load->view('frontend/footer');

	}
	public function success()
	{
	    $this->load->view('frontend/dashboardheader');
		$this->load->view('frontend/success');

		$this->load->view('frontend/footer');

	}

	public function dashboardupdatepassword()
	{
		if(isset($_POST['dashboard']))
		{
			
			$this->form_validation->set_rules('oldpassword','Old-Password','required');
			$this->form_validation->set_rules('newpassword','New-Password','required|min_length[5]');
			$this->form_validation->set_rules('reenternewpassword','Re-Enter-Password','required|min_length[5]|matches[newpassword]');
		
		if ($this->form_validation->run() == TRUE) 
			{
				echo "FORM VALDATED";

				$data = array(
								'oldpassword' => $_POST['oldpassword'],
								'newpassword' =>md5($_POST['newpassword']),
								'reenternewpassword' =>$_POST['reenternewpassword']
							 );
				$data1  = array('password' => $data['newpassword'] );
		   $id = $this->session->userdata('user_id');
		
		$checkToken = $this->main_manager->select_by_other_id('id', $id, 'users');
		if($checkToken[0]['password']==md5($data['oldpassword']))
		{
			$result = $this->main_manager->update($id,$data1,"users");
		}
	    else
	    {
	    	echo "NOT MATCHED";
	    }
		$newdata = array('pagedata' => $checkToken);   	

		    }
		  

		  } 	 


		$this->load->view('frontend/dashboardheader');
		$this->load->view('frontend/dashboardupdatepassword');
		$this->load->view('frontend/footer');
	}

	public function detailedevent($id)
	{
		$final_data = $this->main_manager->select_by_id($id, 'events');
		$newdata = array('pagedata' => $final_data );
	
		$this->load->view('frontend/dashboardheader2');
		$this->load->view('frontend/detailedevent',$newdata);
		$this->load->view('frontend/footer');
	}

	public function dashboardevent()
	{
			$final_data = $this->main_manager->select_all_status('events');
			

	        $newdata = array('pagedata' =>$final_data  );
	        $id = $this->session->userdata('user_id');
			$final_data = $this->main_manager->select_by_id($id, 'users');
		
			
		if($final_data[0]['role']==1)
		{
			
		$this->load->view('frontend/dashboardheader');
		$this->load->view('frontend/dashboardeventsstudent',$newdata);
		$this->load->view('frontend/footer');				
		}

		else
		{
		$this->load->view('frontend/dashboardheader');
		$this->load->view('frontend/dashboardevents',$newdata);
		$this->load->view('frontend/footer');	
		}
		
	}
	public function registerevent($id)
	{
		$final_data = $this->main_manager->select_by_id($id, 'events');
		if($final_data[0]['total_seats']!=0)
		{
			
		$this->load->view('frontend/dashboardheader');
		$this->load->view('frontend/successregister');
		$this->load->view('frontend/footer');
			
		}
		else
		{
		$this->load->view('frontend/dashboardheader');
		$this->load->view('frontend/errorregister');
		$this->load->view('frontend/footer');
		
		}
	}
	public function logineventify()
	{
		$error = array();
        $this->form_validation->set_rules('email', 'Email', 'trim|required');
        $this->form_validation->set_rules('password', 'Password', 'trim|required');

        if ($this->form_validation->run() == FALSE) {
            $error['error'] = validation_errors();
        } else {
            $email = $this->input->post("email");
            $password = md5($this->input->post("password"));
            $final_data = $this->admin_manager->check_login($email, $password);

            if ($final_data[0]['id'] == null) {
                $error['error'] = "Invalid email or password";
            } else {
            	
                ##insert into session
                $this->session->set_userdata('user_id', $final_data[0]['id']);
                $this->session->set_userdata('userLogged', "yes");
                redirect(base_url() . "dashboard", 'refresh');
                
            } //end else
        }
		$this->load->view('frontend/header');
		$this->load->view('frontend/logineventify', $error);
		$this->load->view('frontend/footer');
		//$this->load->library('form_validation');
		
	}

	public function logineventify1()
	{
		
		$this->form_validation->set_rules('email','Email','required|alpha');
		$this->form_validation->set_rules('password','Password','required');
		if( $this->form_validation->run() )
		{
			echo "SUCCESSFUL";
			die;
		}
		else
		{
			// echo validation_errors();
			// echo "ABC";
			// echo "FAILED";
		$this->load->view('frontend/header');
		$this->load->view('frontend/logineventify');
		$this->load->view('frontend/footer');
		}
	}
	
	public function ACM()
	{
		$this->load->view('frontend/header');
		$this->load->view('frontend/ACM');
		$this->load->view('frontend/footer');
	}
	public function DECS()
	{
		$this->load->view('frontend/header');
		$this->load->view('frontend/DECS');
		$this->load->view('frontend/footer');
	}
	public function TNC()
	{
		$this->load->view('frontend/header');
		$this->load->view('frontend/TNC');
		$this->load->view('frontend/footer');
	}
	public function WEBMASTERS()
	{
		$this->load->view('frontend/header');
		$this->load->view('frontend/WEBMASTERS');
		$this->load->view('frontend/footer');
	}
	public function CBS()
	{
		$this->load->view('frontend/header');
		$this->load->view('frontend/CBS');
		$this->load->view('frontend/footer');
	}
	public function TLC()
	{
		$this->load->view('frontend/header');
		$this->load->view('frontend/TLC');
		$this->load->view('frontend/footer');
	}
	public function FMS()
	{
		$this->load->view('frontend/header');
		$this->load->view('frontend/FMS');
		$this->load->view('frontend/footer');
	}
	public function SPORTICS()
	{
		$this->load->view('frontend/header');
		$this->load->view('frontend/SPORTICS');
		$this->load->view('frontend/footer');
	}

	public function emailVerification($token, $user_id){
	    $checkToken = $this->main_manager->select_by_other_id('token', $token, 'users');
	        		
	    if($checkToken !== 0){

	    	if($checkToken[0]['email_verify'] === 1){
	    		
	    		$final_data['error'] = 'Your account is already verified. Please login or contact to admin.';	
	    		$this->load->view('frontend/header',$final_data);
		    		$this->load->view('frontend/error',$final_data);
		    		$this->load->view('frontend/footer',$final_data);
	    	}else{
	    		if(md5($checkToken[0]['id']) === $user_id){
	    			
		    		if($checkToken[0]['role'] == 1 || $checkToken[0]['role'] == 2 || $checkToken[0]['role'] == 3 ){
		    			
		    			$status = 1;
		    		}

		    		$data = array(
		    			'status' => $status,
		    			'email_verify' => 1,
		    			'verifyed_at' => date('y-m-d h:i:s')
		    		);
		    		
		    		$this->main_manager->update($checkToken[0]['id'], $data, 'users');
		    		$final_data['success'] = 'Your email is verified.';
		    		$this->load->view('frontend/header',$final_data);
		    		$this->load->view('frontend/error',$final_data);
		    		$this->load->view('frontend/footer',$final_data);
		    	}else{
		    		$final_data['error'] = 'Oops something went wrong. Please contact admin for further process.';
		    		$this->load->view('frontend/header',$final_data);
		    		$this->load->view('frontend/error',$final_data);
		    		$this->load->view('frontend/footer',$final_data);
		    	}
	    	}
	    }else{
    				$final_data['error'] = 'Oops something went wrong. Please contact admin for further process.';
    				$this->load->view('frontend/header',$final_data);
		    		$this->load->view('frontend/error',$final_data);
		    		$this->load->view('frontend/footer',$final_data);
    	}
    


	}

	public function logout() {

        $this->session->unset_userdata('user_id');
        $this->session->unset_userdata('userLogged');

        redirect(base_url(), 'refresh');
    }
}
?>