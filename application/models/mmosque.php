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
class Mmosque extends CI_Model {
    //put your code here
    function __construct() {
        parent::__construct();

        $this->load->database();
        $this->load->model(array('mfiles_upload'));
    }
    
    function get_mosque_data($arr){
        
        $user = $this->session->userdata('userdb');
        if($group_req) $group = strtoupper($group_req);
        else $group = strtoupper($user['group']);


        $result = array();
        $join[0]['table'] = "files_upload";
        $join[0]['in'] = "ownership_id = meeting_room.id AND modul = 'meeting' AND sub_modul = 'room_photo'";
        $join[0]['how'] = "left";
        $arr_where = array('pic_group' => $group, 'is_use' => '1');

        if($group_req && ($group != $user['group']) && !(is_user_role($user,"SYSTEM ADMINISTRATOR"))){
            $arr_where['is_exclusive'] = 0;
        }

        if($room_id){$arr_where['meeting_room.id'] = $room_id;}
        

        $rooms = $this->mfiles_upload->get_db_join('name','asc','meeting_room',$arr_where,'*, meeting_room.id as room_id','','',$join); $i=0;
        $result['rooms'] = $this->get_room_agendas($rooms,$result,$arr_time);

        
        return $result;
    }

    function get_room_agendas($arr_rooms,$result,$arr_time){
        foreach($arr_rooms as $row){
            $arr_where_data = "(DATE(start) = '".$arr_time['start_date']."' OR DATE(end) = '".$arr_time['start_date']."' OR (DATE(start) < '".$arr_time['start_date']."' AND DATE(end) > '".$arr_time['start_date']."'))";


            $result[$row->room_id]['room'] = $row;
            
            $join_agenda[0]['table'] = "user";
            $join_agenda[0]['in'] = "calendar.created_by = user.id";
            $join_request[0]['table'] = "user";
            $join_request[0]['in'] = "meeting_room_request.created_by = user.id";
            
            $this->db->where($arr_where_data);
            $result[$row->room_id]['agenda'] = $this->mfiles_upload->get_db_join('start','asc','calendar',array('meeting_room_id' => $row->ownership_id),'*, calendar.id as agenda_id, calendar.created_by as calendar_created','','',$join_agenda);


            $result[$row->room_id]['request'] = $this->mfiles_upload->get_db_join('start','asc','meeting_room_request',array('DATE(start)' => $arr_time['start_date'], 'meeting_room_id' => $row->ownership_id, 'meeting_room_request.status' => 'Pending'),'*, meeting_room_request.id as request_id, meeting_room_request.created_by as calendar_created','','',$join_request);
        }

        return $result;
    }

    function get_request_for_me(){
        $user = $this->session->userdata('userdb');

        $join[0]['table'] = "meeting_room";
        $join[0]['in'] = "meeting_room_id = meeting_room.id";
        $join[1]['table'] = "user";
        $join[1]['in'] = "meeting_room_request.created_by = user.id";
        $requests = $this->mfiles_upload->get_db_join('meeting_room_request.created_at','asc','meeting_room_request',array("meeting_room_request.status" => "Pending", "need_request LIKE " => "%;".$user['id'].";%" ),'meeting_room_request.*, meeting_room.name as room_name, user.nik as nik, user.profile_picture as profile_picture, user.full_name','','',$join);
        return $requests;
    }

    function get_my_request(){
        $user = $this->session->userdata('userdb');

        $join[0]['table'] = "meeting_room";
        $join[0]['in'] = "meeting_room_id = meeting_room.id";
        $join[1]['table'] = "user";
        $join[1]['in'] = "meeting_room_request.approved_by = user.id";
        $requests = $this->mfiles_upload->get_db_join('meeting_room_request.created_at','asc','meeting_room_request',array("meeting_room_request.created_by " => $user['id']),'meeting_room_request.*, meeting_room.name as room_name, user.nik as nik, user.profile_picture as profile_picture, user.full_name','','',$join);
        return $requests;
    }

    function get_my_meeting_as_invitee(){
        $user = $this->session->userdata('userdb');
        $join[0]['table'] = "meeting_room";
        $join[0]['in'] = "meeting_room.id = calendar.meeting_room_id";
        $join[1]['table'] = "meeting_attendance";
        $join[1]['in'] = "meeting_attendance.meeting_id = calendar.id";
        $join[2]['table'] = "user";
        $join[2]['in'] = "meeting_attendance.user = user.id";

        $requests = $this->mfiles_upload->get_db_join('calendar.created_at','asc','calendar',array("meeting_attendance.user " => $user['id'], "calendar.start >=" => date('Y-m-d 00:00:00')),'calendar.*, calendar.id as calendar_id, meeting_room.name as room_name, user.nik as nik, user.profile_picture as profile_picture, user.full_name','','',$join);
        return $requests;
    }

    function get_my_meeting_as_invitor(){
        $user = $this->session->userdata('userdb');
        $join[0]['table'] = "meeting_room";
        $join[0]['in'] = "meeting_room.id = calendar.meeting_room_id";
        $join[1]['table'] = "user";
        $join[1]['in'] = "calendar.created_by = user.id";

        $requests = $this->mfiles_upload->get_db_join('calendar.created_at','asc','calendar',array("calendar.created_by " => $user['id'], "calendar.start >=" => date('Y-m-d 00:00:00')),'calendar.*, calendar.id as calendar_id, meeting_room.name as room_name, user.nik as nik, user.profile_picture as profile_picture, user.full_name','','',$join);
        return $requests;
    }
}