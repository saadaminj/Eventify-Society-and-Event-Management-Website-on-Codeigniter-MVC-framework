<?php 
class Register_group extends CI_Model
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
        $id=$aa[0]->nu_id;
        
        $c=$this->db->query("SELECT count(*) as count2 from participant where par_id='$id' and eid=$data[eid] ");
        $c2=$c->result();
        if($c2[0]->count2)
        {
            return false;
        }
        $c=$this->db->query("SELECT count(*) as count2 from par_group where leader_id='$id' and eid=$data[eid]  ");
        $c2=$c->result();
        if($c2[0]->count2)
        {
            return false;
        }


        $this->db->query("INSERT into par_group(leader_id,eid,group_name) values('$id',$data[eid],'$data[gname]')");
        $gid=$this->db->query("SELECT group_id from par_group where leader_id='$id' and group_name='$data[gname]' ");
        $gid2=$gid->result();
        $str=$gid2[0]->group_id;
        
        $arr=explode(",",$data['par_id']);

        foreach($arr as $a):

            $c=$this->db->query("SELECT count(*) as count2 from group_members where member_id='$a' and group_id!=$str and group_id in (select group_id from par_group where eid=$data[eid])  ");
            $c2=$c->result();
            if($c2[0]->count2)
            {
                $this->db->query("DELETE FROM par_group where leader_id='$id' and eid=$data[eid] and group_name=$data[gname] ");
                return false;
            }


            $this->db->query("INSERT into group_members(group_id,member_id) values($str,'$a')");
        endforeach;
        return True;
    }
    public function setData2($seats,$eid)
    {
        $this->db->query("UPDATE events SET total_seats=$seats WHERE id=$eid ");
    }
}