<?php

class user_manager extends CI_Model {

    function __construct()
    {
        // Call the Model constructor
        parent::__construct();
    }

    public function check_login($text_login, $password, $column)
    {
		$this->db->select(" *, count(*) as count")
                 ->where($column, $text_login)
                 ->where("password", $password)
                 ->from("users");
        $query = $this->db->get();         
        if ($query->num_rows() > 0){
            return $query->result_array();
        }else{
        	return 0;
        }
    }
    
    public function check_forget($email)
    {
		
        $this->db->where("email", $email);
        $this->db->from("users");
        $count = $this->db->count_all_results();

        return $count;
    }
    
    public function checkUserLastOrder($userId) {
        $query = $this->db->query("select * from pkg_order where `user_id` = $userId order by id desc limit 1");
        if ($query->num_rows() > 0) {
            return $query->result_array();
        } else {
            return 0;
        }
    }

    public function checkUserOrder($Id) {
        $query = $this->db->query("select p.*, o.* from pkg_order o left join packages p on o.`package_id` = p.id where `package_id` = $Id && `is_payment` = 1");
        if ($query->num_rows() > 0) {
            return $query->result_array();
        } else {
            return 0;
        }
    }
}

?>