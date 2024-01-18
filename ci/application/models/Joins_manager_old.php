<?php

class joins_manager extends CI_Model {

    function __construct() {
// Call the Model constructor
        parent::__construct();
    }
    
    public function adminUserListing($notType) {
        $query = $this->db->query("SELECT * FROM `users` Where type NOT IN ($notType)");
        if ($query->num_rows() > 0) {
            return $query->result_array();
        } else {
            return 0;
        }
    }

    public function select_by_encode_id() {
        $query = $this->db->query("SELECT * FROM `sites_user` Where id = ");
        if ($query->num_rows() > 0) {
            return $query->result_array();
        } else {
            return 0;
        }
    }


    public function getAdminUsers() {
        $query = $this->db->query("SELECT * FROM `users` WHERE is_admin = 0");
        if ($query->num_rows() > 0) {
            return $query->result_array();
        } else {
            return 0;
        }
    }

    public function userPermisionByMethod($userId,$permisionId) {
        $query = $this->db->query("SELECT * FROM `rights` WHERE `User_Id` = $userId AND `Permission_id` = $permisionId");
        if ($query->num_rows() > 0) {
            return 1;
        } else {
            return 0;
        }
    }
    
    public function chcekUserNameById($id,$username) {
        $query = $this->db->query("SELECT * FROM `users` WHERE `id` != ".$id." AND username ='". $username."'");
        if ($query->num_rows() > 0) {
            return $query->result_array();
        } else {
            return 0;
        }
    }

    public function chcekEmailById($id,$email) {
        $query = $this->db->query("SELECT * FROM `users` WHERE `id` != ".$id." AND email ='". $email."'");
        if ($query->num_rows() > 0) {
            return $query->result_array();
        } else {
            return 0;
        }
    }

    public function getBlog() {
        $query = $this->db->query("SELECT b.*,c.username as createdName, p.username as updatedName,bc.* FROM `blog` b left join users c on b.`Created_By` = c.id left join users p on b.`Updated_By` = p.id left join blog_category bc on b.`cat_id`=bc.id ORDER by b.`ID` desc");
        if ($query->num_rows() > 0) {
            return $query->result_array();
        } else {
            return 0;
        }
    }

    public function getComments() {
        $query = $this->db->query("SELECT c.*, b.Title FROM blog_comments c left join blog b on c.`blogId`= b.id");
        if ($query->num_rows() > 0) {
            return $query->result_array();
        } else {
            return 0;
        }
    }

    public function getCommentView($id) {
        $query = $this->db->query("SELECT c.*, b.Title FROM blog_comments c left join blog b on c.`blogId`= b.id where c.`id` = '".$id."'");
        if ($query->num_rows() > 0) {
            return $query->result_array();
        } else {
            return 0;
        }
    }
    
    public function getApprovedComments($slug) {
        $query = $this->db->query("SELECT c.*, b.* FROM blog_comments c left join blog b on c.`blogId`= b.id where c.`is_approved` = 1 && b.`slug` = '".$slug."' ");
        if ($query->num_rows() > 0) {
            return $query->result_array();
        } else {
            return 0;
        }
    }

    public function getUserOrder($userId) {
        $query = $this->db->query("SELECT po.id AS pkgOrderId,po.`package_id`,po.`order_amount`,po.`final_amount`,po.`discount_code`,po.`discount_per`,po.`discount_price`,po.`status` AS orderStatus,po.`order_date`,po.`is_payment`,po.`payment_date`,p.status AS pkgStatus,p.text1 AS pkgName, p.text2,p.price,p.discounted_price As pkgDiscount,p.off_per FROM `pkg_order` po INNER JOIN packages p ON p.id = po.`package_id` WHERE po.`user_id` = $userId ORDER by po.`order_date` desc");
        if ($query->num_rows() > 0) {
            return $query->result_array();
        } else {
            return 0;
        }
    } 
    public function getUserOrderLimit($userId) {
        $query = $this->db->query("SELECT po.id AS pkgOrderId,po.`package_id`,po.`order_amount`,po.`final_amount`,po.`discount_code`,po.`discount_per`,po.`discount_price`,po.`status` AS orderStatus,po.`order_date`,po.`is_payment`,po.`payment_date`,p.status AS pkgStatus,p.text1 AS pkgName, p.text2,p.price,p.discounted_price As pkgDiscount,p.off_per FROM `pkg_order` po INNER JOIN packages p ON p.id = po.`package_id` WHERE po.`user_id` = $userId ORDER by po.`order_date` desc LIMIT 0,4");
        if ($query->num_rows() > 0) {
            return $query->result_array();
        } else {
            return 0;
        }
    } 
    public function getUserPendingOrder($userId) {
        $query = $this->db->query("SELECT po.id AS pkgOrderId,po.`package_id`,po.`order_amount`,po.`final_amount`,po.`discount_code`,po.`discount_per`,po.`discount_price`,po.`status` AS orderStatus,po.`order_date`,po.`is_payment`,po.`payment_date`,p.status AS pkgStatus,p.text1 AS pkgName, p.text2,p.price,p.discounted_price As pkgDiscount,p.off_per FROM `pkg_order` po INNER JOIN packages p ON p.id = po.`package_id` WHERE po.`user_id` = $userId && po.`is_payment` = 0");
        if ($query->num_rows() > 0) {
            return $query->result_array();
        } else {
            return 0;
        }
    } 

    public function getBlogPage() {
        $query = $this->db->query("SELECT b.*,c.username as createdName, p.username as updatedName,bc.* FROM `blog` b left join users c on b.`Created_By` = c.id left join users p on b.`Updated_By` = p.id left join blog_category bc on b.`cat_id`=bc.id where b.`status` = 1  ORDER by b.`ID` desc");
        if ($query->num_rows() > 0) {
            return $query->result_array();
        } else {
            return 0;
        }
    }

    public function getLatestBlog() {
        $query = $this->db->query("SELECT b.*,c.username as createdName, p.username as updatedName,bc.category_name FROM `blog` b left join users c on b.`Created_By` = c.id left join users p on b.`Updated_By` = p.id left join blog_category bc on b.`cat_id`=bc.id where b.`status` = 1 && b.`date`<= CURRENT_TIMESTAMP ORDER by b.`date` desc limit 0,5");
        if ($query->num_rows() > 0) {
            return $query->result_array();
        } else {
            return 0;
        }
    }
    
    public function getBlogDetail($cateName,$slug) {
        
        $query = $this->db->query("SELECT b.*,bc.* FROM `blog` b left join blog_category bc on b.`cat_ID`= bc.ID where b.`status` = 1 && b.`date`<= CURRENT_TIMESTAMP && bc.`category_name` = '".$cateName."' && b.`slug` = '".$slug."'");
        if ($query->num_rows() > 0) {
            return $query->result_array();
        } else {
            return 0;
        }
    }

    public function getBlogPreview($slug) {
        
        $query = $this->db->query("SELECT b.*,bc.* FROM `blog` b left join blog_category bc on b.`cat_ID`= bc.ID where b.`slug` = '".$slug."'");
        if ($query->num_rows() > 0) {
            return $query->result_array();
        } else {
            return 0;
        }
    }

    public function getBlogByCategory($catname) {
        
        $query = $this->db->query("SELECT b.*,bc.* FROM `blog` b left join blog_category bc on b.`cat_ID`= bc.ID where b.`status` = 1 && bc.category_name = '".$catname."'  ORDER by b.`date` desc");
        if ($query->num_rows() > 0) {
            return $query->result_array();
        } else {
            return 0;
        }
    }

    public function getAllTags() {

        $query = $this->db->query("SELECT tags FROM `blog` where status = 1 && date <= CURRENT_TIMESTAMP");
        if ($query->num_rows() > 0) {
            return $query->result_array();
        } else {
            return 0;
        }
    }

    public function getHomePageBlog() {
        $query = $this->db->query("SELECT b.*,bc.category_name FROM `blog` b left join blog_category bc on b.`cat_ID`= bc.ID WHERE status = 1 && b.`date`<= CURRENT_TIMESTAMP ORDER by b.`date` DESC limit 0,4");
        if ($query->num_rows() > 0) {
            return $query->result_array();
        } else {
            return 0;
        }
    }
    
    public function chcekBlogTitleById($id,$Title) {
        $query = $this->db->query("SELECT * FROM `blog` WHERE `id` != ".$id." AND Title ='". $Title."'");
        if ($query->num_rows() > 0) {
            return $query->result_array();
        } else {
            return 0;
        }
    }

    public function getCWS($slug) {

        $query = $this->db->query("SELECT * FROM `cws_about` where slug = '".$slug."'");
        if ($query->num_rows() > 0) {
            return $query->result_array();
        } else {
            return 0;
        }
    }

    public function getServiceDetail($slug) {

        $query = $this->db->query("SELECT s.*,sc.* FROM `services` s left join services_category sc on s.`cat_id`= sc.id where s.slug = '".$slug."'");
        if ($query->num_rows() > 0) {
            return $query->result_array();
        } else {
            return 0;
        }
    }


    public function getAdminJob() {
        $query = $this->db->query("SELECT j.*,c.username as createdName, p.username as updatedName FROM `job` j left join users c on j.`Created_By` = c.id left join users p on j.`Updated_By` = p.id ORDER by j.`ID` desc");
        if ($query->num_rows() > 0) {
            return $query->result_array();
        } else {
            return 0;
        }
    }

    public function getOrderListing() {
        $query = $this->db->query("SELECT ol.*, s.page_name as serviceName  FROM `order_queries` ol left join services s on ol.`service` = s.id ORDER by ol.`id` desc");
        if ($query->num_rows() > 0) {
            return $query->result_array();
        } else {
            return 0;
        }
    }

    public function getPaymentsReceipt($id) {
        $query = $this->db->query("SELECT p.*, u.*,o.*,pk.* FROM `payments` p left join sites_user u on p.`user_id` = u.id left join pkg_order o on p.`order_id` = o.id left join packages pk on o.`package_id` = pk.id WHERE o.`is_payment` = 1 && p.`payment_id` = ".$id."");
        if ($query->num_rows() > 0) {
            return $query->result_array();
        } else {
            return 0;
        }
    }

    public function getReceivedPayments() {
        $query = $this->db->query("SELECT p.*, u.*,o.* FROM `payments` p left join sites_user u on p.`user_id` = u.id left join pkg_order o on p.`order_id` = o.id WHERE o.`is_payment` = 1 ORDER by p.`date` desc");
        if ($query->num_rows() > 0) {
            return $query->result_array();
        } else {
            return 0;
        }
    }
    public function getOrderReceipt($id) {
        $query = $this->db->query("SELECT o.*,u.*,pk.* FROM `pkg_order` o left join sites_user u on o.`user_id` = u.id  left join packages pk on o.`package_id` = pk.id WHERE o.`is_payment` = 0 && o.`id` = ".$id."");
        if ($query->num_rows() > 0) {
            return $query->result_array();
        } else {
            return 0;
        }
    }

    public function getWaitingPayments() {
        $query = $this->db->query("SELECT u.*,pk.*,o.* FROM `pkg_order` o left join sites_user u on o.`user_id` = u.id left join packages pk on o.`package_id` = pk.id WHERE o.`is_payment` = 0 ORDER by o.`payment_date` desc");
        if ($query->num_rows() > 0) {
            return $query->result_array();
        } else {
            return 0;
        }
    }
   

    public function chcekJobTitleById($id,$Title) {
        $query = $this->db->query("SELECT * FROM `job` WHERE `id` != ".$id." AND Title ='". $Title."'");
        if ($query->num_rows() > 0) {
            return $query->result_array();
        } else {
            return 0;
        }
    }

    public function getAppliedUsers($id) {
       $query = $this->db->query("SELECT * FROM job_apply WHERE Job_Id = ".$id." ORDER by ID desc");
        if ($query->num_rows() > 0) {
            return $query->result_array();
        } else {
            return 0;
        }
    }

    public function getLogo() {
        $query = $this->db->query("SELECT l.*,p.username as updatedName FROM `logo` l left join  users p on l.`Updated_By` = p.id");
        if ($query->num_rows() > 0) {
            return $query->result_array();
        } else {
            return 0;
        }
    }

    public function getSocialMedia() {
        $query = $this->db->query("SELECT sm.*,p.username as updatedName FROM `social_media` sm left join  users p on sm.`Updated_By` = p.id");
        if ($query->num_rows() > 0) {
            return $query->result_array();
        } else {
            return 0;
        }
    }

    public function getTestimonial() {
        $query = $this->db->query("SELECT cl.*,c.username as createdName, p.username as updatedName FROM `testimonial` cl left join users c on cl.`Created_By` = c.id left join users p on cl.`Updated_By` = p.id ORDER by cl.`ID` desc");
        if ($query->num_rows() > 0) {
            return $query->result_array();
        } else {
            return 0;
        }
    }

    public function getBanner() {
        $query = $this->db->query("SELECT b.*,c.username as createdName, p.username as updatedName FROM `banner` b left join users c on b.`created_by` = c.id left join users p on b.`updated_by` = p.id");
        if ($query->num_rows() > 0) {
            return $query->result_array();
        } else {
            return 0;
        }
    }

    public function getIndexAbout() {
        $query = $this->db->query("SELECT i.*,c.username as createdName, p.username as updatedName FROM `index_about` i left join users c on i.`created_by` = c.id left join users p on i.`updated_by` = p.id");
        if ($query->num_rows() > 0) {
            return $query->result_array();
        } else {
            return 0;
        }
    }

    public function getDevelopmentProcess() {
        $query = $this->db->query("SELECT d.*,c.username as createdName, p.username as updatedName FROM `development_process` d left join users c on d.`created_by` = c.id left join users p on d.`updated_by` = p.id");
        if ($query->num_rows() > 0) {
            return $query->result_array();
        } else {
            return 0;
        }
    }

    public function getIndexServices() {
        $query = $this->db->query("SELECT i.*,c.username as createdName, p.username as updatedName FROM `index_services` i left join users c on i.`created_by` = c.id left join users p on i.`updated_by` = p.id");
        if ($query->num_rows() > 0) {
            return $query->result_array();
        } else {
            return 0;
        }
    }

    public function getPortfolioDescription() {
        $query = $this->db->query("SELECT cp.*,c.username as createdName, p.username as updatedName FROM `creative_portfolio` cp left join users c on cp.`created_by` = c.id left join users p on cp.`updated_by` = p.id");
        if ($query->num_rows() > 0) {
            return $query->result_array();
        } else {
            return 0;
        }
    }

    public function getPortfolioIcon() {
        $query = $this->db->query("SELECT pi.*,c.username as createdName, p.username as updatedName FROM `portfolio_icons` pi left join users c on pi.`created_by` = c.id left join users p on pi.`updated_by` = p.id");
        if ($query->num_rows() > 0) {
            return $query->result_array();
        } else {
            return 0;
        }
    }

    public function getPkgDescription() {
        $query = $this->db->query("SELECT cp.*,c.username as createdName, p.username as updatedName FROM `pkg_description` cp left join users c on cp.`created_by` = c.id left join users p on cp.`updated_by` = p.id");
        if ($query->num_rows() > 0) {
            return $query->result_array();
        } else {
            return 0;
        }
    }

    public function getAboutCWS() {
        $query = $this->db->query("SELECT ca.*,c.username as createdName, p.username as updatedName FROM `cws_about` ca left join users c on ca.`created_by` = c.id left join users p on ca.`updated_by` = p.id");
        if ($query->num_rows() > 0) {
            return $query->result_array();
        } else {
            return 0;
        }
    }

    public function getServices() {
        $query = $this->db->query("SELECT s.*,c.username as createdName, p.username as updatedName, sc.category_name FROM `services` s left join users c on s.`created_by` = c.id left join users p on s.`updated_by` = p.id left join services_category sc on s.`cat_id`=sc.id where s.`status` = 1 ORDER by s.`id` asc");
        if ($query->num_rows() > 0) {
            return $query->result_array();
        } else {
            return 0;
        }
    }

    public function select_questions() {
        $query = $this->db->query("SELECT q.text as question, o.text as options FROM `questions` q INNER JOIN options o ON q.id = o.question_id  ORDER by q.`id` desc");
        if ($query->num_rows() > 0) {
            return $query->result_array();
        } else {
            return 0;
        }
    }

    public function login($email,$password) {
        $query = $this->db->query("SELECT * FROM `users` WHERE `email` = '".$email."' AND `password` = '".$password."'");
        if ($query->num_rows() > 0) {
            return $query->result_array();
        } else {
            return 0;
        }
    }

    public function changePassword($id,$password) {
        $query = $this->db->query("SELECT * FROM `users` WHERE `id` = '".$id."' AND `password` = '".$password."'");
        if ($query->num_rows() > 0) {
            return $query->result_array();
        } else {
            return 0;
        }
    }

    public function free_questions() {
        $query = $this->db->query("SELECT * FROM `questions` WHERE `is_free` = 1");
        if ($query->num_rows() > 0) {
            return $query->result_array();
        } else {
            return 0;
        }
    }

    public function paid_questions() {
        $query = $this->db->query("SELECT * FROM `questions` WHERE `is_free` = 0");
        if ($query->num_rows() > 0) {
            return $query->result_array();
        } else {
            return 0;
        }
    }

    public function check_ans($test_id, $qId) {
        $query = $this->db->query("SELECT * FROM `user_ans` WHERE test_id = $test_id and q_id = $qId");
         if ($query->num_rows() > 0) {
             return $query->result_array();
         } else {
             return 0;
         }
     }

     public function test_history($user_id) {
        $query = $this->db->query("SELECT * FROM `test` where user_id = $user_id and type = 'paid' ORDER BY `test`.`id` DESC LIMIT 1");
         if ($query->num_rows() > 0) {
             return $query->result_array();
         } else {
             return 0;
         }
     }
     
     public function allAns($test_id) {
        $query = $this->db->query("SELECT a.*, q.option1, q.option2, q.option3, q.option4 FROM `user_ans` a inner join questions q on q.id = a.q_id WHERE test_id = $test_id");
         if ($query->num_rows() > 0) {
             return $query->result_array();
         } else {
             return 0;
         }
     }

    }    
?>
