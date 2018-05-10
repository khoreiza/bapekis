<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of admins
 *
 * @edited by izzan
 */
class Mupdates extends CI_Model {
    //put your code here
    function __construct() {
        parent::__construct();
        $this->load->database();
        $this->load->model(array('mfiles_upload'));
    }

    //INSERT or CREATE FUNCTION
    function insert($program){
        $updates = $this->check_this_updates($program);
        if($updates){
            $update_data['position_allowed'] = $program['position_allowed'];
            $update_data['user_allowed'] = $program['user_allowed'];
            return $this->update($update_data,$updates->id);
        }else{
            if($this->db->insert('updates', $program)){
                return $this->db->insert_id();
            }
            else{
                return false;
            }
        }
    }

    function insert_sticky($program){
        if($this->db->insert('updates_sticky', $program)){
        	return $this->db->insert_id();
        }else{
        	return false;
        }
    }

    /*UPDATE FUNCTION*/
    function update_sticky($program,$id){
        $this->db->where('id',$id);
        return $this->db->update('updates_sticky', $program);
    }

    function update($program,$id){
        $this->db->where('id',$id);
        return $this->db->update('updates', $program);
    }

    /*GET FUNCTION*/
    function check_this_updates($data){
        $arr = array('modul' => $data['modul'], 'sub_modul' => $data['sub_modul']);
        if(isset($data['subsub_modul']) && $data['subsub_modul']){
            $arr['subsub_modul'] = $data['subsub_modul'];
        }
        if(isset($data['ownership_date']) && $data['ownership_date']){
            $arr['ownership_date'] = $data['ownership_date'];
        }
        if(isset($data['ownership_id']) && $data['ownership_id']){
            $arr['ownership_id'] = $data['ownership_id'];
        }
        if($this->mfiles_upload->get_db("id","desc","updates",$arr,"","")){
            //$this->mfiles_upload->delete_db_where($arr,"updates");
            return $this->mfiles_upload->get_db("id","desc","updates",$arr,"","")[0];
        }else{return false;}
    }

    function get_updates($offset = 0, $limit = 10, $submodul = null){
        $user = $this->session->userdata('userdb');
        $ua = $user['group'];
        $pa = $user['position'];

        if (!is_user_role($user,"SYSTEM ADMINISTRATOR")) {
            $this->db->where("(user_id = ".$user['id']." OR ((position_allowed LIKE '%$pa%' OR position_allowed LIKE '%all%' OR position_allowed LIKE '') AND (user_allowed LIKE '%$ua%' OR user_allowed LIKE '%all%' OR user_allowed LIKE '')))");
        }

        if ($submodul != null) {
            if (is_array($submodul)) {
                $this->db->where_in('sub_modul', $submodul);
            } else {
                $this->db->where('sub_modul', $submodul);
            }
        } elseif (!$user['is_employee'] && !is_user_role($user, "SYSTEM ADMINISTRATOR")) {
            $arr_sub = array("Market Outlook","Goverment Bonds Price");
            $this->db->where_in('sub_modul',$arr_sub);
        }

        $this->db->select('*, updates.id as updates_id');
        $this->db->join('user', 'user.id = updates.user_id');
        $this->db->order_by('updates.date','desc');
        $this->db->limit($limit, $offset);
        $query = $this->db->get('updates');

        return $query->result();
    }

     function get_detil_sticky($id){
        $user = $this->session->userdata('userdb');
        $this->db->select('updates_sticky.*,user.full_name, user.nik, user.profile_picture');
        if($id)
        {
            $this->db->where('updates_sticky.id',$id);
        }
        $this->db->join('user', 'user.id = updates_sticky.user_id');
        $this->db->order_by('date','desc');
        $this->db->from('updates_sticky');
        $query = $this->db->get();
        $mysharing = $query->result();
        $finalarr = array(); $i=0;
        foreach($mysharing as $row)
        {
            $finalarr[$i]['sticky'] = $row;
            $finalarr[$i]['attachment'] = $this->mfiles_upload->get_files_upload_by_ownership_id('sticky updates','attach',$row->id);
            $finalarr[$i]['img'] = $this->mfiles_upload->get_files_upload_by_ownership_id_order('sticky updates','img',$row->id, "title", "asc");
            $i++;
        }
        if($id){
            return $finalarr[0];
        }
        else{
            return $finalarr;
        }
	}

    function get_last_sticky($count) {
       $user = $this->session->userdata('userdb');
       $this->db->select('updates_sticky.*,user.full_name, user.nik, user.profile_picture');

       $this->db->join('user', 'user.id = updates_sticky.user_id');
       $this->db->order_by('date','desc');
       $this->db->from('updates_sticky');
       $this->db->limit($count);
       $query = $this->db->get();
       $mysharing = $query->result();
       $finalarr = array(); $i=0;
       foreach($mysharing as $row) {
           $finalarr[$i]['sticky'] = $row;
           $finalarr[$i]['attachment'] = $this->mfiles_upload->get_files_upload_by_ownership_id('sticky updates','attach',$row->id);
           $finalarr[$i]['img'] = $this->mfiles_upload->get_files_upload_by_ownership_id_order('sticky updates','img',$row->id, "title", "asc");
           $i++;
       }
       return $finalarr;
    }

    /*DELETE*/
    function delete_with_ownership_id($sub_modul,$id){
        $this->db->where('ownership_id',$id);
        $this->db->where('sub_modul',$sub_modul);
        $this->db->delete('updates');
        if($this->db->affected_rows()>0){
            return true;
        }
        else{
            return true;
        }
    }

    function delete_with_ownership_id_where($arr_where,$id){
        $this->db->where('ownership_id',$id);
        $this->db->where($arr_where);
        $this->db->delete('updates');
        if($this->db->affected_rows()>0){
            return true;
        }
        else{
            return true;
        }
    }

    function delete_sticky($id){
    	$this->db->where('id',$id);
    	$this->db->delete('updates_sticky');
    	if($this->db->affected_rows()>0){
    		return true;
    	}
    	else{
    		return true;
    	}
    }
}
