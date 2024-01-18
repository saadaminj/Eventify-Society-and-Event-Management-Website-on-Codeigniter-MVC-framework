<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class services extends CI_Controller {

    public $viewPage = '_users'; //lowercase term for the page name, i.e : mypage, editMypage, addMypage
    public $table = "users";
    private $sectionID = 3;

    public function __construct() {
        parent::__construct();
        // Your own constructor code
        $this->load->model(array("admin_manager", "main_manager", "joins_manager"));
        $this->load->helper(array('form', 'url','common'));
        $this->load->library(array('form_validation', 'pagination','upload'));
        $this->output->set_header("Cache-Control: no-store, no-cache, must-revalidate, no-transform, max-age=0, post-check=0, pre-check=0");
        $this->output->set_header("Pragma: no-cache");
    }

    public function index($id) {
        if ($this->session->userdata('adminLogged') != 'yes') {
            redirect(SITE_ADMIN_URL);
        } else {

            $adminId = $this->session->userdata('admin_id');
            $data['users']    = $this->main_manager->select_by_id($adminId,"users");
            $checkPermission = $this->joins_manager->userPermisionByMethod($adminId,26);
            if($checkPermission == 1 || $adminId == 1){
                $final_data['final_data'] = $this->joins_manager->getServicesByCategory($id);
                $this->load->view('admin/header');
                $this->load->view('admin/sidebar',$data);
                $this->load->view('admin/view_service',$final_data);
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
        
            $checkPermission = $this->joins_manager->userPermisionByMethod($adminId,27);
            if($checkPermission == 1 || $adminId == 1){
                $final_data = array();
                $this->pageAction = 'Add';
                if ($this->input->post('doAct') == strtolower($this->pageAction)) {

                    $this->form_validation->set_rules('page_name', 'page_name', 'required');
                    $this->form_validation->set_rules('slider_name', 'slider_name', 'required');
                    $this->form_validation->set_rules('title', 'title', 'required');
                    $this->form_validation->set_rules('description', 'description', 'required');
                    $this->form_validation->set_rules('package_title', 'package_title', 'required');
                    $this->form_validation->set_rules('package_desc', 'package_desc', 'required');
                    $this->form_validation->set_rules('portfolio_title', 'portfolio_title', 'required');
                    $this->form_validation->set_rules('portfolio_desc', 'portfolio_desc', 'required');
                    $this->form_validation->set_rules('alt_text', 'Image alt text', 'required');
                    $this->form_validation->set_rules('image_title', 'Image Title', 'required');
                    $this->form_validation->set_rules('status', 'Status', 'required');
                    $this->form_validation->set_rules('category', 'category', 'required');
                    $this->form_validation->set_rules('page-title', 'page-title');
                    $this->form_validation->set_rules('page-key', 'page-key');
                    $this->form_validation->set_rules('page-description', 'page-description');
                    if ($this->form_validation->run() == FALSE) {
                        $final_data['error'] = validation_errors();
                    }else{

                        $slug1      = str_replace(" ","-",$this->input->post('page_name'));
                        $slug       = strtolower($slug1);

                        if (!empty($_FILES["userfile"]["tmp_name"])) {
                            $config['upload_path'] = './assets/files/services/';
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
                            $imageName = 'services.png';
                        }

                        $data = array(
                            'page_name'         => $this->input->post('page_name'),
                            'slug'              => $slug, 
                            'slider_id'         => $this->input->post('slider_name'),
                            'title'             => $this->input->post('title'),
                            'description'       => $this->input->post('description'),
                            'package_title'     => $this->input->post('package_title'),
                            'package_desc'      => $this->input->post('package_desc'),
                            'portfolio_title'   => $this->input->post('portfolio_title'),
                            'portfolio_desc'    => $this->input->post('portfolio_desc'),
                            'image'             => $imageName,
                            'alt_text'          => $this->input->post('alt_text'),
                            'image_title'       => $this->input->post('image_title'),
                            'status'            => $this->input->post('status'),
                            'cat_id'            => $this->input->post('category'),
                            'page-title'        => $this->input->post('page-title'),
                            'page-key'          => $this->input->post('page-key'),
                            'page-description'  => $this->input->post('page-description'),
                            'created_date'      => date('Y-m-d h:i:s'),
                            'created_by'        => $this->session->userdata('admin_id')
                        );


                        ## for insert into admin_users table
                        $this->main_manager->insert($data, "services");


                        $this->session->set_flashdata('msg', 'The data has been added successfully');
                        redirect(SITE_ADMIN_URL . $this->router->fetch_class() . "/index");
                    }

                    }##end if the form is submitted

                $final_data['final_data'] = $this->main_manager->select_all('services_category');
                $final_data["banner"] = $this->main_manager->select_all("banner");
                $this->load->view('admin/header');
                $this->load->view('admin/sidebar',$data);
                $this->load->view('admin/add_services',$final_data);
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
            $checkPermission = $this->joins_manager->userPermisionByMethod($adminId,28);
            if($checkPermission == 1 || $adminId == 1){
                $final_data = array();
                $this->pageAction = 'Update';

                if ($this->input->post('doAct') == strtolower($this->pageAction)) {
                    $this->form_validation->set_rules('page_name', 'page_name', 'required');
                    $this->form_validation->set_rules('slider_name', 'slider_name', 'required');
                    $this->form_validation->set_rules('title', 'title', 'required');
                    $this->form_validation->set_rules('description', 'Description', 'required');
                    $this->form_validation->set_rules('package_title', 'package_title', 'required');
                    $this->form_validation->set_rules('package_desc', 'package_desc', 'required');
                    $this->form_validation->set_rules('portfolio_title', 'portfolio_title', 'required');
                    $this->form_validation->set_rules('portfolio_desc', 'portfolio_desc', 'required');
                    $this->form_validation->set_rules('alt_text', 'Image alt text', 'required');
                    $this->form_validation->set_rules('image_title', 'Image Title', 'required');
                    $this->form_validation->set_rules('status', 'status', 'required');                   
                    $this->form_validation->set_rules('category', 'category', 'required');
                    $this->form_validation->set_rules('package1', 'package1');
                    $this->form_validation->set_rules('package2', 'package2');
                    $this->form_validation->set_rules('package3', 'package3');
                    $this->form_validation->set_rules('page-title', 'page-title');
                    $this->form_validation->set_rules('page-key', 'page-key');
                    $this->form_validation->set_rules('page-description', 'page-description');

                    if ($this->form_validation->run() == FALSE) {
                        $final_data['error'] = " ";
                    } else {

                        $slug1       = str_replace(" ","-",$this->input->post('page_name'));
                        $slug        = strtolower($slug1);

                         if (!empty($_FILES["userfile"]["tmp_name"])) {
                            $config['upload_path'] = './assets/files/services/';
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
                            'id'                => $id,
                            'slug'              => $slug,
                            'page_name'         => $this->input->post('page_name'),
                            'slider_id'         => $this->input->post('slider_name'),
                            'title'             => $this->input->post('title'),
                            'status'            => $this->input->post('status'),
                            'description'       => $this->input->post('description'),
                            'package_title'     => $this->input->post('package_title'),
                            'package_desc'      => $this->input->post('package_desc'),
                            'portfolio_title'   => $this->input->post('portfolio_title'),
                            'portfolio_desc'    => $this->input->post('portfolio_desc'),
                            'updated_date'      => date('Y-m-d h:i:s'),
                            'cat_id'            => $this->input->post('category'),
                            'pkg_id1'           => $this->input->post('package1'),
                            'pkg_id2'           => $this->input->post('package2'),
                            'pkg_id3'           => $this->input->post('package3'),
                            'image'             => $image,
                            'alt_text'          => $this->input->post('alt_text'),
                            'page-title'        => $this->input->post('page-title'),
                            'page-key'          => $this->input->post('page-key'),
                            'page-description'  => $this->input->post('page-description'),
                            'image_title'       => $this->input->post('image_title'),
                            'updated_by'        => $this->session->userdata('admin_id'),
                        );

                        ## for update admin_users table
                        $this->main_manager->update($id, $data, "services");
                        $this->session->set_flashdata('msg', 'The data has been updated successfully');
                     
                        redirect(SITE_ADMIN_URL . "services/index/".$data['cat_id']);
                    }#end else validation
                }##end if the form is submitted

                $final_data["final_data"] = $this->main_manager->select_by_id($id, "services");
                $final_data['service_category'] = $this->main_manager->select_all('services_category');
                $final_data["service"] = $this->joins_manager->getServicesByCategoryName($final_data["final_data"][0]['slug']);
                $final_data["banner"] = $this->main_manager->select_all("banner");
                $this->load->view('admin/header');
                $this->load->view('admin/sidebar',$data);
                $this->load->view('admin/edit_service',$final_data);
                $this->load->view('admin/footer');
            }else{
                $this->load->view('admin/notallowed');
            }


        }
    }

    public function acitve_inactive($id = NULL, $is_active = NULL) {
        if ($this->session->userdata('adminLogged') != 'yes') {
            redirect(SITE_ADMIN_URL);
        } else {
            $data = array(
                'id' => $id,
                'status' => $is_active,
                'updated_by' => $this->session->userdata('admin_id'),
                'updated_date' => date('Y-m-d h:i:s')
            );
            $final_data = $this->main_manager->select_by_id($id, "services");
            
            if ($this->main_manager->update($id, $data, "services") == false) {
                $error['error'] = 'Cannot save. Please try again.';
            } else {

                $this->session->set_flashdata('msg', 'The data has been updated successfully');
                redirect(SITE_ADMIN_URL . "services/index/".$final_data[0]['cat_id'], 'refresh');
                die();
            }
        }
    }

    public function get_pkg1(){
        $page_id = $this->input->post('value');
        $packages = $this->joins_manager->getPackagesByPage($page_id);
        if($packages == 0){
            echo 0;
        }else{
            ?>
            <select class="form-control show-tick" name="package1">
                <?php for($c=0;$c<count($packages);$c++){ ?>
                    <option value="<?php echo $packages[$c]['id'];?>"><?php echo $packages[$c]['text1']; echo $packages[$c]['text2']; ?></option>
                <?php } ?>
            </select>
                        
            <?php }
    }
    public function get_pkg2(){
        $page_id = $this->input->post('value');
        $packages = $this->joins_manager->getPackagesByPage($page_id);
        if($packages == 0){
            echo 0;
        }else{
            ?>
            <select class="form-control show-tick" name="package2">
                <?php for($c=0;$c<count($packages);$c++){ ?>
                    <option value="<?php echo $packages[$c]['id'];?>"> <?php echo $packages[$c]['text1']; echo $packages[$c]['text2']; ?></option>
                <?php } ?>
            </select>
                        
            <?php }
    }
    public function get_pkg3(){
        $page_id = $this->input->post('value');
        $packages = $this->joins_manager->getPackagesByPage($page_id);
        if($packages == 0){
            echo 0;
        }else{
            ?>
            <select class="form-control show-tick" name="package3">
                <?php for($c=0;$c<count($packages);$c++){ ?>
                    <option value="<?php echo $packages[$c]['id'];?>"> <?php echo $packages[$c]['text1']; echo $packages[$c]['text2']; ?></option>
                <?php } ?>
            </select>
                        
            <?php }
    }

    public function check_category(){
        $category = $this->input->post('category');
        $services = $this->main_manager->select_by_other_id('cat_id',$category,'pkg_page_name');
        if($services == 0){
            echo 0;
        }else{
             echo "<button class='submitbtn mx-1 bActive' id='index' onclick='getPkg();' value='1'>Digital LITE</button>";
            for($i=1; $i<count($services); $i++) { 
                 echo "<button class='submitbtn mx-1' id='".$services[$i]['page_name']."' onclick='getPkg();' value='".$services[$i]['id']."'>".str_replace('-',' ',$services[$i]['page_name']);"</button>";
            }
          
        }
    }

    public function get_pkg(){
        $page_id     = $this->input->post('value');

        $page_name   = $this->main_manager->select_by_id($page_id,'pkg_page_name');
        $service    = $this->joins_manager->getServiceDetail($page_name[0]['page_name']);
        
        if(!empty($service)){

        if($service[0]['cat_id'] == 8 && $service[0]['slug'] != 'mobile-app-development'){
            $package1       = $this->main_manager->select_by_id($service[0]['pkg_id1'],'packages');
            $package2       = $this->main_manager->select_by_id($service[0]['pkg_id2'],'packages');
            $package3       = $this->main_manager->select_by_id($service[0]['pkg_id3'],'packages');
            

            if(isset($package1) && $package1!= 0){
            
                $pkgId  = $package1[0]['id']; 
                $des_data1     = $this->main_manager->select_by_other_id('pkg_id', $pkgId,'pkg_des');
        
                 } 

            if(isset($package2) && $package2 != 0){
            
                $pkgId  = $package2[0]['id']; 
                $des_data2      = $this->main_manager->select_by_other_id('pkg_id', $pkgId,'pkg_des');
        
                 } 

            if(isset($package3) && $package3 != 0){
            
                $pkgId  = $package3[0]['id']; 
                $des_data3      = $this->main_manager->select_by_other_id('pkg_id', $pkgId,'pkg_des');
            } 

            if($package1 == 0){
                echo 0;
            }else{ ?>
                <div class="col-lg-10 col-md-12">
                    <div class="row">
                        <div class="col-lg-4 col-md-12">
                            <div class="priceBox lBluebg Down">
                                <div class="heading">
                                    <p class="name"><?php echo $package1[0]['text1'];?><br><span><?php echo $package1[0]['text2'];?></span></p>
                                </div>
                                <div class="Content">
                                    <div class="Price">
                                        <p class="current"><?php echo ($package1[0]['discounted_price'] == 0)? $package1[0]['price'] : $package1[0]['discounted_price'];?></p>
                                         <?php if($package1[0]['discounted_price'] != 0){ ?>
                                        <p class="Disc"><span>$<?php echo $package1[0]['price'];?></span>  <?php echo $package1[0]['off_per'];?> Off!</p>
                                        <?php }else{ }?>
                                    </div>
                                    <div class="conSec">
                                        <div class="packScroll">
                                            <?php if(isset($des_data1) && $des_data1 != 0){?>
                                            <ul>
                                             <?php for($j=0;$j<count($des_data1);$j++){?>
                                                <li><?php echo $des_data1[$j]['des']; ?></li>
                                                <?php } ?>
                                            </ul>
                                            <?php }?>
                                        </div>                                        
                                    </div>
                                   <?php if(!empty($package1[0]['special_feature'])){ ?>
                                        <div class="feature">
                                            <p>view soecial features <i class="fa fa-info-circle" aria-hidden="true"></i></p>
                                            <div class="featurehover">
                                                <p><?php echo $package1[0]['special_feature'];?></p>
                                            </div>
                                        </div>
                                    <?php }else{}?>
                                    <div class="chat">
                                        <a href="javascript:void(Tawk_API.toggle())"><i class="fa fa-comment"></i> live Chat </a>
                                    </div>
                                    <div class="orderNow">
                                        <a href="<?php echo SITE_URL.'order-preview/'.$package1[0]['id']?>"><i class="fa fa-share"></i> ORDER NOW</a>
                                    </div>                                   
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-4 col-md-12">
                            <div class="priceBox pinkbg">
                                <div class="heading">
                                    <p class="name"><?php echo $package2[0]['text1'];?><br><span><?php echo $package2[0]['text2'];?></span></p>
                                </div>
                                <div class="Content">
                                    <div class="Price">
                                       <p class="current"><?php echo ($package2[0]['discounted_price'] == 0)? $package2[0]['price'] : $package2[0]['discounted_price'];?></p>
                                         <?php if($package2[0]['discounted_price'] != 0){ ?>
                                        <p class="Disc"><span>$<?php echo $package2[0]['price'];?></span>  <?php echo $package2[0]['off_per'];?> Off!</p>
                                        <?php }else{ }?>
                                    </div>
                                    <div class="conSec">
                                        <div class="packScroll">
                                            <?php if(isset($des_data2) && $des_data2 != 0){?>
                                               
                                               <ul>
                                                 <?php for($j=0;$j<count($des_data2);$j++){?>
                                                    <li><?php echo $des_data2[$j]['des']; ?></li>
                                                    <?php } ?>
                                                </ul>
                                               
                                            <?php }?>
                                        </div>
                                    </div>
                                    <?php if(!empty($package2[0]['special_feature'])){ ?>
                                        <div class="feature">
                                            <p>view soecial features <i class="fa fa-info-circle" aria-hidden="true"></i></p>
                                            <div class="featurehover">
                                                <p><?php echo $package2[0]['special_feature'];?></p>
                                            </div>
                                        </div>
                                    <?php }else{}?>
                                    <div class="chat">
                                        <a href="javascript:void(Tawk_API.toggle())"><i class="fa fa-comment"></i> live Chat </a>
                                    </div>
                                    <div class="orderNow">
                                        <a href="<?php echo SITE_URL.'order-preview/'.$package2[0]['id']?>"><i class="fa fa-share"></i> ORDER NOW</a>
                                    </div> 
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-4 col-md-12">
                            <div class="priceBox greenbg Down">
                                <div class="heading">
                                    <p class="name"><?php echo $package3[0]['text1'];?><br><span><?php echo $package3[0]['text2'];?></span></p>
                                </div>
                                <div class="Content">
                                    <div class="Price">
                                       <p class="current"><?php echo ($package3[0]['discounted_price'] == 0)? $package3[0]['price'] : $package3[0]['discounted_price'];?></p>
                                         <?php if($package3[0]['discounted_price'] != 0){ ?>
                                        <p class="Disc"><span>$<?php echo $package3[0]['price'];?></span>  <?php echo $package3[0]['off_per'];?> Off!</p>
                                        <?php }else{ }?>
                                    </div>
                                    <div class="conSec">
                                        <div class="packScroll">
                                            <?php if(isset($des_data3) && $des_data3 != 0){?>
                                            <ul>
                                             <?php for($j=0;$j<count($des_data3);$j++){?>
                                                <li><?php echo $des_data3[$j]['des']; ?></li>
                                                <?php } ?>
                                            </ul>
                                            <?php }?>
                                        </div>
                                    </div>
                                   <?php if(!empty($package3[0]['special_feature'])){ ?>
                                        <div class="feature">
                                            <p>view soecial features <i class="fa fa-info-circle" aria-hidden="true"></i></p>
                                            <div class="featurehover">
                                                <p><?php echo $package3[0]['special_feature'];?></p>
                                            </div>
                                        </div>
                                    <?php }else{}?>
                                    <div class="chat">
                                        <a href="javascript:void(Tawk_API.toggle())"><i class="fa fa-comment"></i> live Chat </a>
                                    </div>
                                    <div class="orderNow">
                                        <a href="<?php echo SITE_URL.'order-preview/'.$package3[0]['id']?>"><i class="fa fa-share"></i> ORDER NOW</a>
                                    </div> 
                                </div>
                            </div>
                        </div>                        
                    </div>
                </div>                    
                <?php }
        }else{
            $packages   = $this->joins_manager->getPackagesByPageName($service[0]['slug']);
            if(isset($packages) && $packages != 0){
            
                $pkgId  = $packages[0]['id']; 
                $des_data1      = $this->main_manager->select_by_other_id('pkg_id', $pkgId,'pkg_des');
            } 
            if(isset($packages) && $packages != 0){
                $pkgId  = $packages[1]['id']; 
                $des_data2      = $this->main_manager->select_by_other_id('pkg_id', $pkgId,'pkg_des');
            } 
            if(isset($packages) && $packages != 0){
    
                $pkgId  = $packages[2]['id']; 
                $des_data3     = $this->main_manager->select_by_other_id('pkg_id', $pkgId,'pkg_des');
            } ?>
                <div class="col-lg-10 col-md-12">
                    <div class="row">
                        <div class="col-lg-4 col-md-12">
                            <div class="priceBox lBluebg Down">
                                <div class="heading">
                                    <p class="name"><?php echo $packages[0]['text1'];?><br><span><?php echo $packages[0]['text2'];?></span></p>
                                </div>
                                <div class="Content">
                                    <div class="Price">
                                        <p class="current"><?php echo ($packages[0]['discounted_price'] == 0)? $packages[0]['price'] : $packages[0]['discounted_price'];?></p>
                                         <?php if($packages[0]['discounted_price'] != 0){ ?>
                                        <p class="Disc"><span>$<?php echo $packages[0]['price'];?></span>  <?php echo $packages[0]['off_per'];?> Off!</p>
                                        <?php }else{ }?>
                                    </div>
                                    <div class="conSec">
                                        <div class="packScroll">
                                            <?php if(isset($des_data1) && $des_data1 != 0){?>
                                            <ul>
                                             <?php for($j=0;$j<count($des_data1);$j++){?>
                                                <li><?php echo $des_data1[$j]['des']; ?></li>
                                                <?php } ?>
                                            </ul>
                                            <?php }?>
                                        </div>                                        
                                    </div>
                                   <?php if(!empty($packages[0]['special_feature'])){ ?>
                                        <div class="feature">
                                            <p>view soecial features <i class="fa fa-info-circle" aria-hidden="true"></i></p>
                                            <div class="featurehover">
                                                <p><?php echo $packages[0]['special_feature'];?></p>
                                            </div>
                                        </div>
                                    <?php }else{}?>
                                    <div class="chat">
                                        <a href="javascript:void(Tawk_API.toggle())"><i class="fa fa-comment"></i> live Chat </a>
                                    </div>
                                    <div class="orderNow">
                                        <a href="<?php echo SITE_URL.'order-preview/'.$packages[0]['id']?>"><i class="fa fa-share"></i> ORDER NOW</a>
                                    </div>                                   
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-4 col-md-12">
                            <div class="priceBox pinkbg">
                                <div class="heading">
                                    <p class="name"><?php echo $packages[1]['text1'];?><br><span><?php echo $packages[1]['text2'];?></span></p>
                                </div>
                                <div class="Content">
                                    <div class="Price">
                                        <p class="current"><?php echo ($packages[1]['discounted_price'] == 0)? $packages[1]['price'] : $packages[1]['discounted_price'];?></p>
                                         <?php if($packages[1]['discounted_price'] != 0){ ?>
                                        <p class="Disc"><span>$<?php echo $packages[1]['price'];?></span>  <?php echo $packages[1]['off_per'];?> Off!</p>
                                        <?php }else{ }?>
                                    </div>
                                    <div class="conSec">
                                        <div class="packScroll">
                                            <?php if(isset($des_data2) && $des_data2 != 0){?>
                                               
                                               <ul>
                                                 <?php for($j=0;$j<count($des_data2);$j++){?>
                                                    <li><?php echo $des_data2[$j]['des']; ?></li>
                                                    <?php } ?>
                                                </ul>
                                               
                                            <?php }?>
                                        </div>
                                    </div>
                                    <?php if(!empty($packages[1]['special_feature'])){ ?>
                                        <div class="feature">
                                            <p>view soecial features <i class="fa fa-info-circle" aria-hidden="true"></i></p>
                                            <div class="featurehover">
                                                <p><?php echo $packages[1]['special_feature'];?></p>
                                            </div>
                                        </div>
                                    <?php }else{}?>
                                    <div class="chat">
                                        <a href="javascript:void(Tawk_API.toggle())"><i class="fa fa-comment"></i> live Chat </a>
                                    </div>
                                    <div class="orderNow">
                                        <a href="<?php echo SITE_URL.'order-preview/'.$packages[1]['id']?>"><i class="fa fa-share"></i> ORDER NOW</a>
                                    </div> 
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-4 col-md-12">
                            <div class="priceBox greenbg Down">
                                <div class="heading">
                                    <p class="name"><?php echo $packages[2]['text1'];?><br><span><?php echo $packages[2]['text2'];?></span></p>
                                </div>
                                <div class="Content">
                                    <div class="Price">
                                        <p class="current"><?php echo ($packages[2]['discounted_price'] == 0)? $packages[2]['price'] : $packages[2]['discounted_price'];?></p>
                                         <?php if($packages[2]['discounted_price'] != 0){ ?>
                                        <p class="Disc"><span>$<?php echo $packages[2]['price'];?></span>  <?php echo $packages[2]['off_per'];?> Off!</p>
                                        <?php }else{ }?>
                                    </div>
                                    <div class="conSec">
                                        <div class="packScroll">
                                            <?php if(isset($des_data3) && $des_data3 != 0){?>
                                            <ul>
                                             <?php for($j=0;$j<count($des_data3);$j++){?>
                                                <li><?php echo $des_data3[$j]['des']; ?></li>
                                                <?php } ?>
                                            </ul>
                                            <?php }?>
                                        </div>
                                    </div>
                                   <?php if(!empty($packages[2]['special_feature'])){ ?>
                                        <div class="feature">
                                            <p>view soecial features <i class="fa fa-info-circle" aria-hidden="true"></i></p>
                                            <div class="featurehover">
                                                <p><?php echo $packages[2]['special_feature'];?></p>
                                            </div>
                                        </div>
                                    <?php }else{}?>
                                    <div class="chat">
                                        <a href="javascript:void(Tawk_API.toggle())"><i class="fa fa-comment"></i> live Chat </a>
                                    </div>
                                    <div class="orderNow">
                                        <a href="<?php echo SITE_URL.'order-preview/'.$packages[2]['id']?>"><i class="fa fa-share"></i> ORDER NOW</a>
                                    </div> 
                                </div>
                            </div>
                        </div>                        
                    </div>
                </div>  
        <?php }
        }else{
            $packages   = $this->joins_manager->getPackagesByPage($page_id);
          
            if(isset($packages) && $packages != 0){
            
                $pkgId  = $packages[0]['id']; 
                $des_data1      = $this->main_manager->select_by_other_id('pkg_id', $pkgId,'pkg_des');
            } 
            if(isset($packages) && $packages != 0){
                $pkgId  = $packages[1]['id']; 
                $des_data2      = $this->main_manager->select_by_other_id('pkg_id', $pkgId,'pkg_des');
            } 
            if(isset($packages) && $packages != 0){
    
                $pkgId  = $packages[2]['id']; 
                $des_data3     = $this->main_manager->select_by_other_id('pkg_id', $pkgId,'pkg_des');
            } ?>
                <div class="col-lg-10 col-md-12">
                    <div class="row">
                        <div class="col-lg-4 col-md-12">
                            <div class="priceBox lBluebg Down">
                                <div class="heading">
                                    <p class="name"><?php echo $packages[0]['text1'];?><br><span><?php echo $packages[0]['text2'];?></span></p>
                                </div>
                                <div class="Content">
                                    <div class="Price">
                                        <p class="current"><?php echo ($packages[0]['discounted_price'] == 0)? $packages[0]['price'] : $packages[0]['discounted_price'];?></p>
                                         <?php if($packages[0]['discounted_price'] != 0){ ?>
                                        <p class="Disc"><span>$<?php echo $packages[0]['price'];?></span>  <?php echo $packages[0]['off_per'];?> Off!</p>
                                        <?php }else{ }?>
                                    </div>
                                    <div class="conSec">
                                        <div class="packScroll">
                                            <?php if(isset($des_data1) && $des_data1 != 0){?>
                                            <ul>
                                             <?php for($j=0;$j<count($des_data1);$j++){?>
                                                <li><?php echo $des_data1[$j]['des']; ?></li>
                                                <?php } ?>
                                            </ul>
                                            <?php }?>
                                        </div>                                        
                                    </div>
                                   <?php if(!empty($packages[0]['special_feature'])){ ?>
                                        <div class="feature">
                                            <p>view soecial features <i class="fa fa-info-circle" aria-hidden="true"></i></p>
                                            <div class="featurehover">
                                                <p><?php echo $packages[0]['special_feature'];?></p>
                                            </div>
                                        </div>
                                    <?php }else{}?>
                                    <div class="chat">
                                        <a href="javascript:void(Tawk_API.toggle())"><i class="fa fa-comment"></i> live Chat </a>
                                    </div>
                                    <div class="orderNow">
                                        <a href="<?php echo SITE_URL.'order-preview/'.$packages[0]['id']?>"><i class="fa fa-share"></i> ORDER NOW</a>
                                    </div>                                   
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-4 col-md-12">
                            <div class="priceBox pinkbg">
                                <div class="heading">
                                    <p class="name"><?php echo $packages[1]['text1'];?><br><span><?php echo $packages[1]['text2'];?></span></p>
                                </div>
                                <div class="Content">
                                    <div class="Price">
                                        <p class="current"><?php echo ($packages[1]['discounted_price'] == 0)? $packages[1]['price'] : $packages[1]['discounted_price'];?></p>
                                         <?php if($packages[1]['discounted_price'] != 0){ ?>
                                        <p class="Disc"><span>$<?php echo $packages[1]['price'];?></span>  <?php echo $packages[1]['off_per'];?> Off!</p>
                                        <?php }else{ }?>
                                    </div>
                                    <div class="conSec">
                                        <div class="packScroll">
                                            <?php if(isset($des_data2) && $des_data2 != 0){?>
                                               
                                               <ul>
                                                 <?php for($j=0;$j<count($des_data2);$j++){?>
                                                    <li><?php echo $des_data2[$j]['des']; ?></li>
                                                    <?php } ?>
                                                </ul>
                                               
                                            <?php }?>
                                        </div>
                                    </div>
                                    <?php if(!empty($packages[1]['special_feature'])){ ?>
                                        <div class="feature">
                                            <p>view soecial features <i class="fa fa-info-circle" aria-hidden="true"></i></p>
                                            <div class="featurehover">
                                                <p><?php echo $packages[1]['special_feature'];?></p>
                                            </div>
                                        </div>
                                    <?php }else{}?>
                                    <div class="chat">
                                        <a href="javascript:void(Tawk_API.toggle())"><i class="fa fa-comment"></i> live Chat </a>
                                    </div>
                                    <div class="orderNow">
                                        <a href="<?php echo SITE_URL.'order-preview/'.$packages[1]['id']?>"><i class="fa fa-share"></i> ORDER NOW</a>
                                    </div> 
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-4 col-md-12">
                            <div class="priceBox greenbg Down">
                                <div class="heading">
                                    <p class="name"><?php echo $packages[2]['text1'];?><br><span><?php echo $packages[2]['text2'];?></span></p>
                                </div>
                                <div class="Content">
                                    <div class="Price">
                                        <p class="current"><?php echo ($packages[2]['discounted_price'] == 0)? $packages[2]['price'] : $packages[2]['discounted_price'];?></p>
                                         <?php if($packages[2]['discounted_price'] != 0){ ?>
                                        <p class="Disc"><span>$<?php echo $packages[2]['price'];?></span>  <?php echo $packages[2]['off_per'];?> Off!</p>
                                        <?php }else{ }?>
                                    </div>
                                    <div class="conSec">
                                        <div class="packScroll">
                                            <?php if(isset($des_data3) && $des_data3 != 0){?>
                                            <ul>
                                             <?php for($j=0;$j<count($des_data3);$j++){?>
                                                <li><?php echo $des_data3[$j]['des']; ?></li>
                                                <?php } ?>
                                            </ul>
                                            <?php }?>
                                        </div>
                                    </div>
                                   <?php if(!empty($packages[2]['special_feature'])){ ?>
                                        <div class="feature">
                                            <p>view soecial features <i class="fa fa-info-circle" aria-hidden="true"></i></p>
                                            <div class="featurehover">
                                                <p><?php echo $packages[2]['special_feature'];?></p>
                                            </div>
                                        </div>
                                    <?php }else{}?>
                                    <div class="chat">
                                        <a href="javascript:void(Tawk_API.toggle())"><i class="fa fa-comment"></i> live Chat </a>
                                    </div>
                                    <div class="orderNow">
                                        <a href="<?php echo SITE_URL.'order-preview/'.$packages[2]['id']?>"><i class="fa fa-share"></i> ORDER NOW</a>
                                    </div> 
                                </div>
                            </div>
                        </div>                        
                    </div>
                </div>  
        <?php }
    }
}

?>