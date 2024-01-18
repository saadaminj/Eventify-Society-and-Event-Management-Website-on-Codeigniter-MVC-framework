<?php

class admin_manager extends CI_Model {

    function __construct() {
        parent::__construct();
    }

    ////////
    public function check_admin_login($user_name, $password) {

        $this->db->select("*")
                ->from("users")
                ->where("username", $user_name)
                ->where("password", $password)
                ->where("role", 4)
                ->where("status", 1);
        $query = $this->db->get();

        if ($query->num_rows() > 0) {
            return $query->result_array();
        } else {
            return 0;
        }
    }
    
    public function check_login($email, $password) {

        $this->db->select("*, count(*) as total")
                ->from("users")
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

    public function get_user_permissions($id) {

        $this->db->select("*")
                ->from("admin_permissions")
                ->where("admin_user_id", $id);
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return $query->result_array();
        } else {
            return 0;
        }
    }

    
    public function check_by_username($user_name) {

        $this->db->select("*");
        $this->db->from("admin_users a");
        $this->db->where("a.user_name", $user_name);
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

    public function check_admin_auth($sec_id = '') {
        if ($this->session->userdata('adminLogged') == "yes") {
            if (isset($sec_id)) {
                $this->db->select("*")
                        ->from("admin_permissions")
                        ->where("admin_user_id", $this->session->userdata('admin_id'))
                        ->where("admin_section_id", $sec_id);
                $query = $this->db->get();
                if ($query->num_rows() > 0) {
                    return true;
                } else {
                    redirect(SITE_URL);
                }
            }
        } else {
            redirect(SITE_URL);
        }
    }

    public function permissions_delete_by_admin_user_id($admin_users_id, $table) {

        $this->db->where("admin_user_id", $admin_users_id);
        if ($this->db->delete($table)) {
            return true;
        } else {
            return false;
        }
    }

    public function delete_parents($parent_id, $table) {

        $this->db->where("id", $parent_id);
        $this->db->or_where("parent_id", $parent_id);
        if ($this->db->delete($table)) {
            return true;
        } else {
            return false;
        }
    }
       public function check_dasboard_login($email, $password, $table) {

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