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
class Muser_activity extends CI_Model {
    //put your code here
    function __construct() {
        parent::__construct();
        $this->load->database();
    }
    
    //GET FUNCTION
    function get_user_access($from,$to,$group_by,$order="user_activity.id",$by="asc",$join_user=false,$arr_filter){
        $this->db->select('*, user_activity.*, user_activity.id as activity_id, count(user.full_name) as sum_count');
        $this->db->join('user', 'user.id = user_activity.user_id');
        if($join_user){
            $where_user = "";
            
            $this->db->join("(SELECT count(nik) as sum_user, `".$group_by."` FROM `user` WHERE status = 'active' group by `".$group_by."`) AS `b`", "user.".$group_by." = b.$group_by");
            //if($group_by == "group"){
            //$this->db->join("(SELECT sort, `".$group_by."` FROM `sort_".$group_by."`) AS `c`", "user.".$group_by." = c.$group_by");
            //}
        }
		$this->db->where('user.full_name <>','Tezza LR');

        if(($from != "all" && $to<$from) || !$from){
            $this->db->where("user_activity.date",$to);
            $where_date_act = "WHERE user_activity.date = '$to'";
        }
        else{
            if($from == "all"){
                $this->db->where("user_activity.date <= '$to'");
                $where_date_act = "WHERE user_activity.date <= '$to'";
            }else{
                $this->db->where("user_activity.date BETWEEN '$from' AND '$to'");
                $where_date_act = "WHERE user_activity.date BETWEEN '$from' AND '$to'";
            }
        }


        if($arr_filter){
            if(isset($arr_filter['group']) && $arr_filter['group']){
                $this->db->where_in('user.group',$arr_filter['group']);
                //$this->db->where('user.group',$arr_filter['group']);
            }
            if(isset($arr_filter['jabatan']) && $arr_filter['jabatan']){
                $this->db->where_in('jabatan',$arr_filter['jabatan']);
            }
            if(isset($arr_filter['activity']) && $arr_filter['activity']){
              $where_date_act .= " AND activity = '".$arr_filter['activity']."'";
            } 
        }

        $this->db->where('user.status','active');
        $this->db->where('user_activity.id IN (SELECT MIN(id) FROM user_activity '.$where_date_act.' GROUP BY user_id)');
        if($join_user){
            //$this->db->order_by('sort', 'asc');
            $this->db->order_by('user.'.$group_by, 'asc');
        }
        else{$this->db->order_by($order, $by);}
        if($group_by) $this->db->group_by('user.'.$group_by);
        $query = $this->db->get('user_activity');
        return $query->result();
    }

    function get_user_access_where($from,$to,$group_by,$order,$by,$join_user,$arr_where){
        if(isset($arr_where['jabatan']) && $arr_where['jabatan']){
            $this->db->where_in("jabatan",$arr_where['jabatan']);
            unset($arr_where['jabatan']);
        }

        if($arr_where){
            $this->db->where($arr_where);
        }
        return $this->get_user_access($from,$to,$group_by,$order,$by,$join_user,'');
    }

    function get_page_access($from,$to,$group_by,$order,$by,$join_user,$page, $user_id, $arr_filter){
        $stat_count = "";
        if($page) $stat_count = ", count(user.full_name) as sum_count";

        $this->db->select('*, user_activity.*, user_activity.id as activity_id'.$stat_count);
        $this->db->join('user', 'user.id = user_activity.user_id');
        if($join_user){
            $this->db->join("(SELECT count(nik) as sum_user, `".$group_by."` FROM `user` WHERE status = 'active' group by `".$group_by."`) AS `b`", "user.".$group_by." = b.$group_by");
            //if($group_by == "group"){
            $this->db->join("(SELECT sort, `".$group_by."` FROM `sort_".$group_by."`) AS `c`", "user.".$group_by." = c.$group_by");
            //}
        }
        if($page) $this->db->where('activity', $page);
        if($user_id) $this->db->where('user_id', $user_id);
        $this->db->where('user.full_name <>','Tezza LR');
        if(($from != "all" && $to<$from) || !$from){
            $this->db->where("user_activity.date",$to);
            $where_date_act = "WHERE user_activity.date = '$to'";
        }
        else{
            if($from == "all"){
                $this->db->where("user_activity.date <= '$to'");
                $where_date_act = "WHERE user_activity.date <= '$to'";
            }else{
                $this->db->where("user_activity.date BETWEEN '$from' AND '$to'");
                $where_date_act = "WHERE user_activity.date BETWEEN '$from' AND '$to'";
            }
        }

        if($arr_filter){
            if(isset($arr_filter['group']) && $arr_filter['group']){
                $this->db->where_in('user.group',$arr_filter['group']);
            }
            if(isset($arr_filter['jabatan']) && $arr_filter['jabatan']){
                $this->db->where_in('jabatan',$arr_filter['jabatan']);
            }
            if(isset($arr_filter['activity']) && $arr_filter['activity']){
              $where_date_act .= " AND activity = '".$arr_filter['activity']."'";
            } 
        }
        
        //$this->db->where('user_activity.id IN (SELECT MIN(id) FROM user_activity '.$where_date_act.' AND activity = "'.$page.'" GROUP BY user_id)');
        if($join_user){
            $this->db->order_by('sort', 'asc');
            $this->db->order_by('user.'.$group_by, 'asc');
        }
        else{$this->db->order_by($order, $by);}
        if($group_by) $this->db->group_by('user.'.$group_by);
        $query = $this->db->get('user_activity');
        return $query->result();
    }

    function get_top_users($from,$to,$order,$by,$arr_filter){
        
        $this->db->where('user.full_name <>','Tezza LR');
        if(($from != "all" && $to<$from) || !$from){
            $where = " WHERE user_activity.date = '$to' ";
        }
        else{
            if($from == "all"){
                $where = "WHERE user_activity.date <= '$to' ";
            }else{
                $where = " WHERE user_activity.date BETWEEN '$from' AND '$to' ";
            }
        }

        if($arr_filter){
            if(isset($arr_filter['group']) && $arr_filter['group']){
                $this->db->where_in('user.group',$arr_filter['group']);
                //$this->db->where('group',$arr_filter['group']);
            }
            if(isset($arr_filter['jabatan']) && $arr_filter['jabatan']){
                $this->db->where_in('jabatan',$arr_filter['jabatan']);
            }
            if(isset($arr_filter['activity']) && $arr_filter['activity']){
              $where .= " AND activity = '".$arr_filter['activity']."'";
            } 
        }

        $this->db->join("(SELECT count(distinct (date)) as sum_count, user_id, user_activity.date FROM `user_activity` $where group by user_id) AS b", 'user.id = b.user_id');
        $this->db->order_by($order, $by);
        $this->db->order_by('full_name', 'asc');

        

        $query = $this->db->get('user');
        return $query->result();
    }

    function get_top_pages($from, $to, $order="sum_count", $by="desc",$arr_filter){
        $this->db->select('count(distinct (user_id)) as sum_count, activity');
        $this->db->where('user_activity.user_id <>','11');
        $this->db->where('activity <>', 'login');
        $this->db->where('activity <>', 'logout');

        $this->db->join("user", 'user.id = user_activity.user_id');

        if (($from != "all" && $to<$from) || !$from) {
            $this->db->where("user_activity.date",$to);
        } else {
            if ($from == "all") {
                $this->db->where("user_activity.date <= '$to'");
            } else {
                $this->db->where("user_activity.date BETWEEN '$from' AND '$to'");
            }
        }

        if($arr_filter){
            if(isset($arr_filter['group']) && $arr_filter['group']){
                $this->db->where_in('user.group',$arr_filter['group']);
            }
            if(isset($arr_filter['jabatan']) && $arr_filter['jabatan']){
                $this->db->where_in('jabatan',$arr_filter['jabatan']);
            }
            if(isset($arr_filter['activity']) && $arr_filter['activity']){
              $this->db->where('activity',$arr_filter['activity']);  
            } 
        }

        //$this->db->join("(SELECT counts(distinct (user_id)) as sum_count, user_id, activity FROM `user_activity` $where group by activity) AS b", 'user_activity.activity = b.activity');
        $this->db->order_by($order, $by);
        $this->db->group_by('activity');
        //$this->db->order_by('full_name', 'asc');
        $query = $this->db->get('user_activity');
        return $query->result();
    }

    function get_page_visit_count($from, $to, $activity) {
        $this->db->select('count(*) as sum_count');
        $this->db->where('user_activity.user_id <>','11');

        if (($from != "all" && $to<$from) || !$from) {
            $this->db->where("date",$to);
        } else {
            if ($from == "all") {
                $this->db->where("date <= '$to'");
            } else {
                $this->db->where("date BETWEEN '$from' AND '$to'");
            }
        }

        $this->db->where('activity', $activity);
        $query = $this->db->get('user_activity');

        if ($query->num_rows() == 1) {
            return $query->result()[0]->sum_count;
        } else {
            return 0;
        }
    }

    function get_user_page_group_activity_date($user_id){

        return $this->db->query("SELECT `activity`, count(activity) as sum FROM (SELECT * FROM `user_activity` WHERE user_id = $user_id GROUP BY `date`, `activity` order by `activity`) as table_act WHERE `user_id` = $user_id AND `activity` != 'login' AND `activity` != 'logout' GROUP BY `activity` ORDER BY `sum` desc LIMIT 5")->result();
    }

    function get_activity($date){
        $this->db->select('user.*, user_activity.*, user_activity.id as activity_id');
        $this->db->join('user', 'user.id = user_activity.user_id');
        $this->db->where('user.full_name <>','Tezza LR');
        $this->db->where("date", $date);
        
        $this->db->order_by('time', 'desc');
        $this->db->order_by('full_name', 'desc');
        $query = $this->db->get('user_activity');
        return $query->result();
    }
	
	function get_all_user_rekap($group){
		$this->db->distinct();
		$this->db->select('user.*, user_activity.*, user_activity.id as activity_id');
        $this->db->join('user', 'user.id = user_activity.user_id');
		$this->db->where('user.full_name <>','Tezza LR');
		$this->db->order_by('datetime', 'desc');
		$this->db->order_by('full_name', 'desc');
        $query = $this->db->get('user_activity');
        return $query->result();
	}

}
