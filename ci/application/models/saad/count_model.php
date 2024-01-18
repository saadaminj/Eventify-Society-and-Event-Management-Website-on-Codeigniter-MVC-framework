<?php 
class Count_model extends CI_Model
{
    public function index()
    {
        echo "in model";
    }
    public function getUserCount()
    {
        $this->load->database();
        $q=$this->db->query("SELECT count(*) as count1 from users");
        $aa=$q->result();
        //print_r($aa[0]->count1);
        return $aa[0]->count1;
    }
    public function getSocietyCount()
    {
        $this->load->database();
        $q=$this->db->query("SELECT count(*) as count1 from society");
        $aa=$q->result();
        //print_r($aa[0]->count1);
        return $aa[0]->count1;
    }
    
    public function getEventCount()
    {
        $this->load->database();
        $q=$this->db->query("SELECT count(*) as count1 from events");
        $aa=$q->result();
        //print_r($aa[0]->count1);
        return $aa[0]->count1;
    }
}