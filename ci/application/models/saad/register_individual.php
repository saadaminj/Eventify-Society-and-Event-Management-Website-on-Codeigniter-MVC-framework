<?php 
class Register_individual extends CI_Model
{
    public function index()
    {
        echo "in model";
    }
    public function setData($data)
    {
        $this->load->database();

        $q = $this->db->query("SELECT nu_id FROM users where id=$data[id] ");
        $aa=$q->result();
        $str=$aa[0]->nu_id;
        
        $q2 = $this->db->query("SELECT count(*) as count1 FROM participant where par_id='$str' and eid=$data[eid] ");
        $aa2=$q2->result();
        $str2=$aa2[0]->count1;
        if($str2>0)
        {
            return false;
        }
        $q2 = $this->db->query("SELECT count(*) as count1 FROM par_group where leader_id='$str' and eid=$data[eid] ");
        $aa2=$q2->result();
        $str2=$aa2[0]->count1;
        if($str2>0)
        {
            return false;
        }
        $q2 = $this->db->query("SELECT count(*) as count1 FROM group_members where member_id='$str' and group_id in (select group_id from par_group where eid=$data[eid]) ");
        $aa2=$q2->result();
        $str2=$aa2[0]->count1;
        if($str2>0)
        {
            return false;
        }
        
        $this->db->query("INSERT into participant(par_id,eid) values('$str',$data[eid])");
        return true;
    }
    public function setData2($seats,$eid)
    {
        $this->db->query("UPDATE events SET total_seats=$seats WHERE id=$eid ");
    }
}