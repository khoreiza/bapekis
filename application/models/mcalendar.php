<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of admins
 *
 * @author Maulnick
 */
class Mcalendar extends CI_Model {
    //put your code here
    function __construct() {
        parent::__construct();
        $this->load->database();

        $this->load->model(array('mfiles_upload','mupdates','muser','mnews'));
    }
    
    //INSERT or CREATE FUNCTION
    
    
    function insert_calendar($program){
        if($this->db->insert('calendar', $program)){
        	return $this->db->insert_id();
        }else{
        	return false;
        }
    }
    
    //GET FUNCTION
    
    function get_all_calendar_month($month, $year,$ua,$reader){
    	$sumdate = date("t", mktime(0,0,0, $month, 1, $year));
    	$arrcalendar = array();
    	for($i=1;$i<=$sumdate;$i++){
    		$datetoget = $year."-".$month."-".$i;
    		//$arrcalendar[$i] = $this->get_calendar_by_date($datetoget);
    		$arrcalendar[$i] = $this->get_calendar_by_date_ua_reader($datetoget,$ua,$reader);
    	}
    	return $arrcalendar;
    }

    function get_latest_event($limit,$ua,$reader,$type){
        //$user_unit  =  $this->muser->get_user_unit();


        $this->db->select('*');

        //if(isset($user_unit['dir']) && $user_unit['dir']) $this->db->where('directorate_id',$user_unit['dir']->id);
        
        //$this->db->where('use_booking',0);

        /**** GROUP ALLOWED ****/
        //$user_allowed = "1";//"(user_allowed LIKE '%$ua%' OR user_allowed LIKE '%all%' OR user_allowed LIKE '' OR user_allowed is NULL)";
        //$group_allowed = "1";
        

        /*if($user_unit['group']){
            $group_allowed = "(group_allowed LIKE '%;".$user_unit['group']->id.";%' OR group_allowed LIKE '%all%' OR group_allowed = '' OR group_allowed is NULL)";    
        }*/
        

        //$this->db->where("(".$user_allowed." OR ".$group_allowed.")");
        /**** END ****/

        //$this->db->where("(position_allowed LIKE '%$reader%' OR position_allowed LIKE '%all%' OR position_allowed = '' OR position_allowed is NULL)");
        
        if($type == "last"){
            $this->db->where('start <',date('Y-m-d'));
        }elseif($type == "upcoming"){
            $this->db->where('start >',date('Y-m-d'));
        }
        $this->db->order_by('start','desc');
        $this->db->limit($limit);
        $result = $this->db->get('calendar')->result();
        $arr = array();
        foreach($result as $row){
            $arr[$row->id]["cal"] = $row;
            $arr[$row->id]['file'] = $this->mfiles_upload->get_files_upload_by_ownership_id_order('event', 'documentation', $row->id, "id", "asc");
        }
        return $arr;
    }
    
    function get_calendar_by_date($date){
    	$this->db->select('*');
    	$this->db->where('DATE(start)',$date);
    	$this->db->order_by('start','desc');
    	$result = $this->db->get('calendar');
    	return $result->result();
    }
    
    function get_calendar_by_date_ua_reader($date,$ua,$reader){
    	$this->db->select('*');
    	$this->db->where('DATE(start)',$date);
        $this->db->where('use_booking <> ',1);
        //$this->db->where("(user_allowed LIKE '%$ua%' OR user_allowed LIKE '%all%')");
        //$this->db->where("(reader LIKE '%$reader%' OR reader LIKE '%all%')");
    	$this->db->order_by('start','desc');
    	$result = $this->db->get('calendar');
    	return $result->result();
    }
    
    function get_calendar_by_id($id){
    	$this->db->select('calendar.*');
    	//$this->db->join('user', 'agenda.maker_id = user.id');
    	$this->db->where('calendar.id',$id);
    	$res = $this->db->get('calendar'); 
    	$result = $res->row(0);
    	return $result;
    }

    function get_by_id_with_atc($id){
        $arr['calendar'] = $this->get_calendar_by_id($id);
        $arr['attachment'] = $this->mfiles_upload->get_files_upload_by_ownership_id("calendar", 'event', $id);
        $arr['img'] = $this->mfiles_upload->get_files_upload_by_ownership_id_order('event', 'documentation', $id, "id", "asc");
        return $arr;
    }
    
    //UPDATE FUNCTION
    function update_calendar($program,$id){
        $this->db->where('id',$id);
        return $this->db->update('calendar', $program);
    }
    
    
    //DELETE FUNCTION
    function delete_calendar($id){
    	$this->db->where('id',$id);
    	$this->db->delete('calendar');
    	if($this->db->affected_rows()>0){
    		
            /**** DELETE CALENDAR NEWS ****/
            $news = $this->mfiles_upload->get_db('id','desc','news',array("news.ownership_id" => $id, 'news.modul' => 'calendar news'),'','');
            foreach($news as $row){
                $this->mnews->delete_news($row->id,'calendar news');
                if(is_dir("assets/uploads/calendar/".$id."/publications/".$row->id)) rmdir("assets/uploads/calendar/".$id."/publications/".$row->id);
            }



            //$this->mupdates->delete_with_ownership_id("Calendar of Event",$id);
            $this->mfiles_upload->delete_with_files_ownership($id,'calendar', 'event');
            $this->mfiles_upload->delete_with_files_ownership($id,'photo', 'calendar');
            $this->mfiles_upload->delete_with_files_ownership($id,'event', 'documentation');
            if(is_dir("assets/uploads/calendar/documentation/".$id."/thumb")) rmdir("assets/uploads/calendar/documentation/".$id."/thumb");
            if(is_dir("assets/uploads/calendar/documentation/".$id)) rmdir("assets/uploads/calendar/documentation/".$id);
            if(is_dir("assets/uploads/calendar/".$id."/attachment/thumb")) rmdir("assets/uploads/calendar/".$id."/attachment/thumb");
            if(is_dir("assets/uploads/calendar/".$id."/attachment")) rmdir("assets/uploads/calendar/".$id."/attachment");
            if(is_dir("assets/uploads/calendar/".$id."/publications")) rmdir("assets/uploads/calendar/".$id."/publications");
            if(is_dir("assets/uploads/calendar/".$id)) rmdir("assets/uploads/calendar/".$id);
            return true;
    	}
    	else{
    		return true;
    	}
    }
    
    // OTHER FUNCTION
}
