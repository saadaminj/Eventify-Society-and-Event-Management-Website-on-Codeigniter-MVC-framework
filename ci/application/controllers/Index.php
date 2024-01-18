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
		$this->load->model('saad/count_model');
		$data['users'][0]=$this->count_model->getUserCount();
		$data['users'][1]=$this->count_model->getSocietyCount();
		$data['users'][2]=$this->count_model->getEventCount();
		
		if(strcmp($this->session->userdata('userLogged'),"yes")==0)
		{
			$this->load->view('frontend/dashboardheader');
		}
		else
		$this->load->view('frontend/header');
		$this->load->view('frontend/index',$data);
		$this->load->view('frontend/footer');
	}
	public function socities()
	{
		if(strcmp($this->session->userdata('userLogged'),"yes")==0)
		{
			$this->load->view('frontend/dashboardheader');
		}
		else
		$this->load->view('frontend/header');
		$this->load->view('frontend/socities');
		$this->load->view('frontend/footer');
	}
	public function signup()
	{
		if(strcmp($this->session->userdata('userLogged'),"yes")==0)
		{
			redirect(index);
		}	
		if(isset($_POST['signup']))
		{

			$this->form_validation->set_rules('fname','Firstname','required');
			$this->form_validation->set_rules('lname','Lastname','required');
			$this->form_validation->set_rules('BATCH','BATCH','required');
			$this->form_validation->set_rules('SECTION','SECTION','required');
			$this->form_validation->set_rules('email','Email','required|is_unique[users.email]|regex_match[/.*@nu.edu.pk/]');
			$this->form_validation->set_rules('username','username','required|is_unique[users.username]');
			$this->form_validation->set_rules('role','Role','required');
			
			$this->form_validation->set_rules('password','Password','required|min_length[5]');
			$this->form_validation->set_rules('confirm_password','confirm_password','required|min_length[5]|matches[password]');
			
			$nu_id=explode('@',$_POST['email']);

			if ($this->form_validation->run() == TRUE) 
			{

				$data = array(
					'email' => $_POST['email'],
					'username' =>$_POST['username'],
					'firstname' =>$_POST['fname'],
					'lastname' =>$_POST['lname'],
					'password' => md5($_POST['password']),

					'role' => $_POST['role'],
					'token' => md5(strtotime(date('y-m-d h:i:s'))),
					'BATCH'=>$_POST['BATCH'],
					'SECTION'=>$_POST['SECTION'],
					'nu_id'=> $nu_id[0]

					 );
			  

			$this->db->insert('users',$data);
			$user_id = $this->db->insert_id();
			$config['protocol']='smtp';
			$config['smtp_host']='smtp.gmail.com';
			$config['smtp_port']='587';
			$config['smtp_timeout']='120';
			$config['smtp_user']='eventifyemailverificator@gmail.com';
			$config['smtp_pass']='eventifyemailverificator123';
			$config['charset']='utf-g';
			$config['mailtype']='html';
			$config['validation']=TRUE;

			$link = base_url().'email-verification/'.$data['token'].'/'.md5($user_id);
			$message = '<html>';
			$message .= '<body>';
			$message .= "<p> Please click <a href='".$link."'> here</a> to confirm your account</p>";
			$message .= '</body>';
			$message .= '</html>';

						
			ini_set("SMTP","smtp.gmail.com ");

			// Please specify an SMTP Number 25 and 8889 are valid SMTP Ports.
			ini_set("smtp_port","587");

			// Please specify the return address to use
			ini_set('sendmail_from', 'eventifyemailverificator@gmail.com');

					
			$this->load->library('email',$config);
			$this->email->set_newline("\r\n");
			$this->email->from('eventifyemailverificator@gmail.com');
			$this->email->to($data['email']);
			$this->email->subject('Eventify Account Verification');
			$this->email->message($message);
			$chk=$this->email->send();

			
			//print_r("error");
			//die;

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
		if(strcmp($this->session->userdata('userLogged'),"yes")!=0)
		{
			redirect(index);
		}

		
		
		$id=$this->session->userdata('user_id');
		$final_data = $this->main_manager->select_by_id($id, 'users');	
		if($final_data[0]['role']==1)
		{
			redirect(index);
		}
		if($final_data[0]['role']!=2 && $final_data[0]['role']!=3)
		{
			if($final_data[0]['role']!=1)
				redirect(home);
			else
				redirect(dashboard);
		}
		
		

		if(isset($_POST['AddEvent']))
		{
			$this->form_validation->set_rules('title','Title','required');
			$this->form_validation->set_rules('society','Society','required');
			$this->form_validation->set_rules('date','Date','required');
			$this->form_validation->set_rules('totalseats','TotalSeats','required');
			$this->form_validation->set_rules('description','Description','required');
			$this->form_validation->set_rules('no_par','Number of Participants');

			if ($this->form_validation->run() == TRUE) 
			{
				$config['upload_path']          = './assets/uploads/';
                $config['allowed_types']        = 'gif|jpg|png';
                $config['max_size']             = 300000;
                $config['max_width']            = 40240;
                $config['max_height']           = 47680;

                $this->load->library('upload', $config);

				if(!$this->upload->do_upload("userfile"))
				{

				}

				$pic=array('upload_data' => $this->upload->data());
				$pic2=$pic['upload_data'];
				$pic3=$pic2['file_name'];

				$data = array(
					'title' => $_POST['title'],
					'Society' =>$_POST['society'],
					'event_date' =>$_POST['date'],
					'total_seats' =>$_POST['totalseats'],
					'description' => $_POST['description'],
					'no_par' => $_POST['no_par'],
					'picture' => $pic3,
					'user_id' => $id = $this->session->userdata('user_id')
					);
			  

			 $this->db->insert('events',$data);
			 $user_id = $this->db->insert_id();
			 $this->session->set_flashdata("success","Your account has been created");
			 
				redirect('addeventconfirm',"refresh");
			
	     	}
	   }
	    $this->load->view('frontend/dashboardheader');
		$this->load->view('frontend/dashboardaddevent');
		$this->load->view('frontend/footer');
		  
	}     

	public function addeventconfirm()
	{
		
		$final_data = $this->main_manager->select_by_id($id, 'users');
		if($final_data[0]['role']==1)
		{
			redirect(index);
		}
		if(strcmp($this->session->userdata('userLogged'),"yes")!=0)
		{
			redirect(index);
		}
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
		if(strcmp($this->session->userdata('userLogged'),"yes")!=0)
		{
			redirect(index);
		}
		$id = $this->session->userdata('user_id');
		$final_data = $this->main_manager->select_by_id($id, 'users');
		$newdata = array('pagedata' => $final_data[0]['role']);

		//echo '<pre>'; print_r($this->session->all_userdata());//exit;
		$this->load->view('frontend/dashboardheader');
		$this->load->view('frontend/dashboard',$newdata);
		$this->load->view('frontend/footer');
		
	}
	
	public function dashboardprofile()
	{
		if(strcmp($this->session->userdata('userLogged'),"yes")!=0)
		{
			redirect(index);
		}
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
		
		if(strcmp($this->session->userdata('userLogged'),"yes")!=0)
		{
			redirect(index);
		}
		$final_data = $this->main_manager->select_by_id($id, 'users');
		if($final_data[0]['role']==1)
		{
			redirect(index);
		}

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
		if(strcmp($this->session->userdata('userLogged'),"yes")!=0)
		{
			redirect(index);
		}
		if($final_data[0]['role']==1)
		{
			redirect(index);
		}
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
		if(strcmp($this->session->userdata('userLogged'),"yes")!=0)
		{
			redirect(index);
		}
	    $this->load->view('frontend/dashboardheader');
		$this->load->view('frontend/errorevent');

		$this->load->view('frontend/footer');

	}
	public function success()
	{
		if(strcmp($this->session->userdata('userLogged'),"yes")!=0)
		{
			redirect(index);
		}
	    $this->load->view('frontend/dashboardheader');
		$this->load->view('frontend/success');

		$this->load->view('frontend/footer');

	}

	public function dashboardupdatepassword()
	{
		if(strcmp($this->session->userdata('userLogged'),"yes")!=0)
		{
			redirect(index);
		}
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
		    $id = 41;
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
		if(strcmp($this->session->userdata('userLogged'),"yes")!=0)
		{
			redirect(index);
		}
		$final_data = $this->main_manager->select_by_id($id, 'events');
		$newdata = array('pagedata' => $final_data );
	
		$this->load->view('frontend/dashboardheader2');
		$this->load->view('frontend/detailedevent',$newdata);
		$this->load->view('frontend/footer');
	}

	public function dashboardevent()
	{
		if(strcmp($this->session->userdata('userLogged'),"yes")!=0)
		{
			redirect(index);
		}
		$id = $this->session->userdata('user_id');
		$final_data = $this->main_manager->select_by_id($id, 'users');
		

			$checkToken = $this->main_manager->select_all_but_id('events',$final_data[0]['nu_id']);
			if($checkToken==0)
			{
				$final_data['error'] = 'There are no events for you to register';	
	    		$this->load->view('frontend/dashboardheader');
				$this->load->view('frontend/error',$final_data);
				$this->load->view('frontend/footer');
			}
			// print_r($checkToken);
	        $newdata = array('pagedata' =>$checkToken  );
	        
			
		if($final_data[0]['role']==1)
		{
			
		$this->load->view('frontend/dashboardheader');
		$this->load->view('frontend/dashboardeventsstudent',$newdata);
		$this->load->view('frontend/footer');				
		}

		else if($final_data[0]['role']==2 || $final_data[0]['role']==3 || $final_data[0]['role']==4)
		{
		$this->load->view('frontend/dashboardheader');
		$this->load->view('frontend/dashboardevents',$newdata);
		$this->load->view('frontend/footer');	
		}
		else
		redirect(index);
		
	}
	public function dashboardregisteredevent()
	{
		if(strcmp($this->session->userdata('userLogged'),"yes")!=0)
		{
			redirect(index);
		}
		    
			$id = $this->session->userdata('user_id');
			$id2 = $this->main_manager->select_other_by_id('nu_id',$id,'users');
			$id2=$id2[0];

			$checkToken = $this->main_manager->select_event_by_participants($id2['nu_id']);
			if($checkToken==0)
			{
				$final_data['error'] = 'You have not registered in any event';	
	    		$this->load->view('frontend/dashboardheader');
				$this->load->view('frontend/error',$final_data);
				$this->load->view('frontend/footer');
			}
			// print_r($checkToken);
	        $newdata = array('pagedata' =>$checkToken  );
			$final_data = $this->main_manager->select_by_id($id, 'users');
		
			
		if($final_data[0]['role']==1)
		{
			
		$this->load->view('frontend/dashboardheader');
		$this->load->view('frontend/dashboardregisteredevent',$newdata);
		$this->load->view('frontend/footer');				
		}
		else
		redirect(index);
		
	}
	public function registered()
	{
		if(strcmp($this->session->userdata('userLogged'),"yes")!=0)
		{
			redirect(index);
		}
		$this->load->view('frontend/dashboardheader');
		$this->load->view('frontend/registered');
		$this->load->view('frontend/footer');
	}
	public function register_choice($id)
	{
		if(strcmp($this->session->userdata('userLogged'),"yes")!=0)
		{
			redirect(index);
		}
		if($this->session->userdata('user_id'))
		{
			if(isset($_POST['proceed']) )
			{
				$this->form_validation->set_rules('register_as','Register Choice','required');
				if($this->form_validation->run())
				{
					if($this->input->post('register_as') == 'Individual')
					{
						$final_data = $this->main_manager->select_by_id($id, 'events');
						$data=array('eid'=>$final_data[0]['id'],'id'=>$this->session->userdata('user_id'));
						$this->load->model('saad/register_individual');
						$c=$this->register_individual->setData($data);
						if($c == false)
						{
							$this->load->view('frontend/dashboardheader');
							$this->load->view('frontend/errorregister2');
							$this->load->view('frontend/footer');
						}
						$this->load->view('frontend/dashboardheader');
						$this->load->view('frontend/successregister');
						$this->load->view('frontend/footer');
					}
					else
					{
						$this->register_group($id);
					}	
				}
			}	
			
			$this->load->view('frontend/dashboardheader');
			$this->load->view('frontend/register_choice');
			$this->load->view('frontend/footer');
		}
		else redirect(signup);
	}
	public function register_individual()
	{
		if(strcmp($this->session->userdata('userLogged'),"yes")!=0)
		{
			redirect(index);
		}
			if(isset($_POST['register']))
			{
				$this->form_validation->set_rules('fname','Firstname','required|max_length[20]');
				$this->form_validation->set_rules('lname','Lastname','required|max_length[20]');
				$this->form_validation->set_rules('email','Email','required|max_length[49]|valid_email');
				$this->form_validation->set_rules('phone_number','Phone Number');
				if($this->form_validation->run())
				{
					echo "FORM VALDATED";

					$data = array(
						'email' => $_POST['email'],
						'phone_number' =>$_POST['phone_number'],
						'fname' =>$_POST['fname'],
						'lname' =>$_POST['lname']
						 );
			  
					//$this->db->insert('participant',$data);

					$this->load->database();
					$this->load->model('saad/register_individual');
					$c=$this->register_individual->setData($data);

					if($c==True)
					{
						$this->session->set_flashdata("success","Your message has been sent");
						$this->register_group->setData2($final_data[0]['total_seats']-1,$final_data[0]['id']);
						redirect('registered',"refresh");
					}
					else
					{
						$this->load->view('frontend/dashboardheader');
							$this->load->view('frontend/errorregister2');
							$this->load->view('frontend/footer');
					}
					// base_url().'email-verification/'.$data['token'].'/'.md5($user_id)
					
				}
			}	
			$this->load->view('frontend/header');
			$this->load->view('frontend/register_individual');
			$this->load->view('frontend/footer');
	}
	public function register_group($id)
	{
		if(strcmp($this->session->userdata('userLogged'),"yes")!=0)
		{
			redirect(index);
		}
			$final_data = $this->main_manager->select_by_id($id, 'events');
			if(isset($_POST['register22']))
			{
				//$this->dashboardaddevent();
				$this->form_validation->set_rules('gname','Group Name','required');
				$this->form_validation->set_rules('par_id','Participants ID','required');
				
				if($this->form_validation->run())
				{
					$data = array(
						'id'=>$this->session->userdata('user_id'),
						'par_id' =>$_POST['par_id'],
						'gname' => $_POST['gname'],
						'eid'=> $id
						 );
			  
					//$this->db->insert('group',$data);
					$this->load->database();
					$this->load->model('saad/register_group');
					$c=$this->register_group->setData($data);
					if($c == false)
						{
							$this->load->view('frontend/dashboardheader');
							$this->load->view('frontend/errorregister2');
							$this->load->view('frontend/footer');
						}
						$this->register_group->setData2($final_data[0]['total_seats']-1,$final_data[0]['id']);
						$this->load->view('frontend/dashboardheader');
						$this->load->view('frontend/successregister');
						$this->load->view('frontend/footer');
				}
			}	
			$final_data = $this->main_manager->select_by_id($id, 'events');
			$data['users'][0]=$final_data[0]['no_par'];
			$data['users'][1]=$final_data[0]['id'];
			$this->load->view('frontend/dashboardheader');
			$this->load->view('frontend/register_group',$data);
			$this->load->view('frontend/footer');
	}

	public function contacted()
	{
		if(strcmp($this->session->userdata('userLogged'),"yes")==0)
		{
			$this->load->view('frontend/dashboardheader');
		}
		else
		$this->load->view('frontend/header');
		$this->load->view('frontend/contacted');
		$this->load->view('frontend/footer');
		
	}
	public function contact_us()
	{
		if(isset($_POST['send']))
		{
			$this->form_validation->set_rules('fname','Firstname','required|max_length[20]');
			$this->form_validation->set_rules('lname','Lastname','required|max_length[20]');
			$this->form_validation->set_rules('email','Email','required|max_length[49]|valid_email');
			$this->form_validation->set_rules('subject','Subject','required|max_length[499]');
			$this->form_validation->set_rules('message','Message','required|max_length[1999]|min_length[15]');
			if ($this->form_validation->run() == TRUE) 
			{

				$data = array(
					'email' => $_POST['email'],
					'subject' =>$_POST['subject'],
					'fname' =>$_POST['fname'],
					'lname' =>$_POST['lname'],
					'message' => $_POST['message']

					 );
			  

			$this->db->insert('contact_form',$data);

			
									
			ini_set("SMTP","smtp.gmail.com ");

			// Please specify an SMTP Number 25 and 8889 are valid SMTP Ports.
			ini_set("smtp_port","587");

			// Please specify the return address to use
			ini_set('sendmail_from', 'eventifyemailverificator@gmail.com');

			$config['protocol']='smtp';
			$config['smtp_host']='smtp.gmail.com';
			$config['smtp_port']='587';
			$config['smtp_timeout']='120';
			$config['smtp_user']='eventifyemailverificator@gmail.com';
			$config['smtp_pass']='eventifyemailverificator123';
			$config['charset']='utf-g';
			$config['mailtype']='html';
			$config['validation']=TRUE;


			$this->load->library('email',$config);
			$this->email->from('eventifyemailverificator@gmail.com');
			$this->email->to('k173850@nu.edu.com');
			$this->email->subject($data['subject']);
			$this->email->message($data['message']);
			$this->email->send();



			// base_url().'email-verification/'.$data['token'].'/'.md5($user_id)
			$this->session->set_flashdata("success","Your message has been sent");
			redirect('contacted',"refresh");
			}	
		
		}
		if(strcmp($this->session->userdata('userLogged'),"yes")==0)
		{
			$this->load->view('frontend/dashboardheader');
		}
		else
		$this->load->view('frontend/header');
		$this->load->view('frontend/contact');
		$this->load->view('frontend/footer');
	}
	public function registerevent($id)
	{
		if(strcmp($this->session->userdata('userLogged'),"yes")!=0)
		{
			redirect(index);
		}
		$final_data = $this->main_manager->select_by_id($id, 'events');
		if($final_data[0]['total_seats']!=0)
		{
			if($final_data[0]['no_par']==1)
			{
				$data=array('eid'=>$final_data[0]['id'],'id'=>$this->session->userdata('user_id'));
				$this->load->model('saad/register_individual');
				$c=$this->register_individual->setData($data);
						if($c == false)
						{
							$this->load->view('frontend/dashboardheader');
							$this->load->view('frontend/errorregister2');
							$this->load->view('frontend/footer');
						}
						$this->register_individual->setData2($final_data[0]['total_seats']-1,$final_data[0]['id']);
				$this->load->view('frontend/dashboardheader');
				$this->load->view('frontend/successregister');
				$this->load->view('frontend/footer');
			}
			else if($final_data[0]['no_par']>1)
			{
				$this->register_choice($id);
			}
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
		if(strcmp($this->session->userdata('userLogged'),"yes")==0)
		{
			redirect(index);
		}
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
		if(strcmp($this->session->userdata('userLogged'),"yes")==0)
		{
			redirect(index);
		}
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
		if(strcmp($this->session->userdata('userLogged'),"yes")==0)
		{
			$this->load->view('frontend/dashboardheader');
		}
		else
		$this->load->view('frontend/header');
		$this->load->view('frontend/ACM');
		$this->load->view('frontend/footer');
	}
	public function DECS()
	{
		if(strcmp($this->session->userdata('userLogged'),"yes")==0)
		{
			$this->load->view('frontend/dashboardheader');
		}
		else
		$this->load->view('frontend/header');
		$this->load->view('frontend/DECS');
		$this->load->view('frontend/footer');
	}
	public function TNC()
	{
		if(strcmp($this->session->userdata('userLogged'),"yes")==0)
		{
			$this->load->view('frontend/dashboardheader');
		}
		else
		$this->load->view('frontend/header');
		$this->load->view('frontend/TNC');
		$this->load->view('frontend/footer');
	}
	public function WEBMASTERS()
	{
		if(strcmp($this->session->userdata('userLogged'),"yes")==0)
		{
			$this->load->view('frontend/dashboardheader');
		}
		else
		$this->load->view('frontend/header');
		$this->load->view('frontend/WEBMASTERS');
		$this->load->view('frontend/footer');
	}
	public function CBS()
	{
		if(strcmp($this->session->userdata('userLogged'),"yes")==0)
		{
			$this->load->view('frontend/dashboardheader');
		}
		else
		$this->load->view('frontend/header');
		$this->load->view('frontend/CBS');
		$this->load->view('frontend/footer');
	}
	public function TLC()
	{
		if(strcmp($this->session->userdata('userLogged'),"yes")==0)
		{
			$this->load->view('frontend/dashboardheader');
		}
		else
		$this->load->view('frontend/header');
		$this->load->view('frontend/TLC');
		$this->load->view('frontend/footer');
	}
	public function FMS()
	{
		if(strcmp($this->session->userdata('userLogged'),"yes")==0)
		{
			$this->load->view('frontend/dashboardheader');
		}
		else
		$this->load->view('frontend/header');
		$this->load->view('frontend/FMS');
		$this->load->view('frontend/footer');
	}
	public function SPORTICS()
	{
		if(strcmp($this->session->userdata('userLogged'),"yes")==0)
		{
			$this->load->view('frontend/dashboardheader');
		}
		else
		$this->load->view('frontend/header');
		$this->load->view('frontend/SPORTICS');
		$this->load->view('frontend/footer');
	}

	public function emailVerification($token, $user_id){
		if(strcmp($this->session->userdata('userLogged'),"yes")==0)
		{
			redirect(index);
		}
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