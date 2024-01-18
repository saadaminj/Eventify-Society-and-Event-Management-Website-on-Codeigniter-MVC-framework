<?php

class dasboard_manager extends CI_Model {

    function __construct() {
        parent::__construct();
    }

    ////////
    public function check_login($email, $password, $table) {

        $this->db->select("*, count(*) as total")
                ->from($table)
                ->where("email", $email)
                ->where("password", $password)
                ->where("status", 1);
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return $query->result_array();
        } else {
            return 0;
        }
    }
    
    
    public function check_by_email($email,$table) {

        $this->db->select("*");
        $this->db->from($table);
        $this->db->where("email", $email);
        $query = $this->db->get();
        $data = array();
        if ($query->num_rows() > 0) {
            foreach ($query->result_array() as $row) {
                $data = $row;
            }
        } else {
            $data = 0;
        }
        return $data;
    }

}

?>