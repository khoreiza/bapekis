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
class Mactivity_step extends CI_Model {
    //put your code here
    function __construct() {
        parent::__construct();
        $this->load->database();
        $this->load->model(array('mfiles_upload'));
    }

    function store_parent_sub_activity($parent_id, $source_type, $source_id){
    	$user = $this->session->userdata('userdb');

    	$activity_sub = $this->input->post('activity_sub');
        $user_pic_sub = $this->input->post('user_pic_sub');
        $deadline_sub = $this->input->post('deadline_sub');
        $status_sub = $this->input->post('status_sub');
        $progress_sub = $this->input->post('progress_sub');
        $sub_activity_id = $this->input->post('sub_activity_id');
        $progress_sub_id = $this->input->post('progress_sub_id');
        $sub_act_id = "";

        if($activity_sub){
            foreach($activity_sub as $key => $n){
                if($n){
                    $sub['activity'] = $n;
                    $sub['user_pic'] = $user_pic_sub[$key];
                    $sub['status'] = $status_sub[$key];
                    if($deadline_sub[$key]) $sub['deadline'] =  DateTime::createFromFormat('d M y', $deadline_sub[$key])->format('Y-m-d');

                    $sub['updated_date'] = date('Y-m-d H:i:s');
                    $sub['updated_by'] = $user['id'];
                    $sub['parent_id'] = $parent_id;
                    $sub['source_type'] = $source_type;
                    $sub['source_id'] = $source_id;
                    
                    if($sub_activity_id && $sub_activity_id[$key]){
                        $this->mfiles_upload->update_db($sub,$sub_activity_id[$key],'activity_steps');
                        $sub_act_id = $sub_activity_id[$key];
                    }
                    else{
                        $sub['created_date'] = date('Y-m-d H:i:s');
                        $sub['created_by'] = $user['id'];
                        $sub_act_id = $this->mfiles_upload->insert_db($sub,'activity_steps');
                    }
                    
                    if($progress_sub[$key]){
                        $prog_sub["progress"] = $progress_sub[$key];
                        $prog_sub["created_by"] = $user["id"];
                        $prog_sub["created_date"] = date("Y-m-d H:i:s");
                        $prog_sub["updated_by"] = $user["id"];
                        $prog_sub["updated_at"] = date("Y-m-d H:i:s");
                        $prog_sub["action_step_id"] = $sub_act_id;
                        if($progress_sub_id && $progress_sub_id[$key]){
                        	$progress_id = $this->mfiles_upload->update_db($prog_sub,$progress_sub_id[$key],'progress');
                        }else{
                        	$progress_id = $this->mfiles_upload->insert_db($prog_sub,'progress');	
                        }
                        
                    }
                }
            }
        }
        return $sub_act_id;
    }

    function get_parent_object($db,$parent_object_id){
    	$this->db->select($db.'.*');
    	$this->db->where('id',$parent_object_id);
    	$result = $this->db->get($db);
    	$result = $result->result();
    	if(count($result)>0){return $result[0];}
    	else{return null;}
    }

    function get_parents_activity($activity){
    	$arr_parents = array(); $i=0;
    	$cur_act = $activity;
    	while($cur_act->parent_id != 0){
    		$parent = $this->get_activity_by_id($cur_act->parent_id);
    		if($parent){
    			$arr_parents[$i] = $parent;
    			$i++;
    			$cur_act = $parent;
    		}
 			else break;
    	}
    	return $arr_parents;
    }

    function get_parent_activity_member($parent_id){
		
		$childs = $this->get_child_activity_by_parent_id($parent_id);

		if(is_array($parent_id)) $parent_id = $parent_id['parent_id'];
		if($childs){
			$arr_res = array();
			foreach($childs as $child){
				$arr_res[$child->act_id]['activity'] = $child;
				$grand_child = $this->get_child_activity_by_parent_id($child->act_id);
				if($grand_child){
					$arr_res[$child->act_id]['grand_child'] = count($grand_child);
					$arr_res[$child->act_id]['activities'] = $grand_child;
					$arr_res[$child->act_id]['status_summary'] = $this->get_child_status_summary($child->act_id);
					$arr_res[$child->act_id]['progress'] = false;
				} 
				else{
					$progress = $this->mfiles_upload->get_db('created_date','desc','progress',array('action_step_id' => $child->act_id),'','');
					if($progress) $arr_res[$child->act_id]['progress'] = $progress[0];
					else $arr_res[$child->act_id]['progress'] = false;
				}
			}
			return $arr_res;
		}
		else{
			return false;
		}
    }

    function get_child_activity_by_parent_id($parent_id){
    	$order_by = "deadline"; $how = "asc";
    	if(is_array($parent_id)){
    		$order_by = $parent_id['order_by'];
    		$how = $parent_id['how'];
    		$parent_id = $parent_id['parent_id'];
    	}

    	$join[0] = array('table' => 'user', 'in' => "user.id = activity_steps.user_pic");
		$childs = $this->mfiles_upload->get_db_join($order_by,$how,'activity_steps',array('parent_id' => $parent_id),'activity_steps.*, activity_steps.id as act_id, user.full_name, user.panggilan, user.nik, user.profile_picture','','',$join);
		return $childs;
    }

    function get_child_status_summary($parent_id){
    	$status = $this->mfiles_upload->get_db_group_by('status','desc','activity_steps',array('parent_id' => $parent_id),'status,COUNT(*) as count','','status');
    	return $status;
    	//SELECT status,COUNT(*) as count FROM activity_steps GROUP BY status ORDER BY count DESC
    }

    function upsert_parent_object($db,$array_value){
    	$result = array();
    	if(!empty($array_value['id'])){
    		// update
    		$this->db->where("id",$array_value['id']);unset($array_value['id']);
			$this->db->update($db,$array_value);
			$result['action'] = "update";
			$result['value'] = $this->db->affected_rows();
    	}else{
    		// insert
    		$result['action'] = "insert"; $this->db->insert($db, $array_value);
    		$result['value'] = $this->db->insert_id();
    	}
    	return $result;
    }

    function get_parent_object_with_activity_step($db,$array_value){
    	$source_type = $array_value['source_type'];
    	$id = $array_value['parent_object_id'];
    	$source_sql = "";
		$id_sql = "";
		if(!empty($source_type)){
			$source_sql = " and hi.source_type='".$source_type."' ";
		}
		if(!empty($id)){
			$id_sql = ' and hi.source_id = '.$id.' ';
		}
		$q = $this->db->query('SELECT parent.*, hi.id,CONCAT(REPEAT("&nbsp;&nbsp;&nbsp;", level - 1), CAST(hi.activity AS CHAR)) AS activity, 
							   us.full_name, hi.user_pic,hi.status, parent_id,deadline, level
									FROM    (
											SELECT  hierarchy_connect_by_parent_eq_prior_id(id) AS id, @level AS level
											FROM    (
													SELECT  @start_with := 0,
															@id := @start_with,
															@level := 0
													) vars, activity_steps
											WHERE   @id IS NOT NULL
											) ho
									JOIN    activity_steps hi
									ON      hi.id = ho.id '.$id_sql.' '.$source_sql.'
									LEFT JOIN user us on hi.user_pic = us.id LEFT JOIN '.$db.' parent on hi.source_id = parent.id');
		return $q->result_array();					    
	}
	
	function insert_activity_steps($id,$steps,$progress){
		//check progress on parent
		if(!empty($steps["parent_id"]) and !empty($steps['activity'])){
			//check progress
			$this->db->select("count(*) as total")->from('progress')->where('action_step_id',$steps['parent_id']);
			$q = $this->db->get();
			$d = $q->result_array();
			
			$total = $d[0]['total'];
			if($total>0){
				return false;
				exit;
			}
		}
		$this->db->trans_start();
		if(!empty($steps['activity'])){
			$steps['source_id'] = $id;
			$this->db->insert('activity_steps', $steps);
			$act_id = $this->db->insert_id();
		}
		if(!empty($progress['progress'])){
			if(isset($act_id)){
				$progress['action_step_id'] = $act_id;
			}
			else{
				$progress['action_step_id'] = $steps['parent_id'];
			}
			if(isset($progress['action_step_id'])){
				$this->db->insert('progress',$progress);
			}
		}
		$this->db->trans_complete();
		return true;
	}

	function get_activities_by_source_type($id='',$source_type=''){	
		$source_sql = "";
		$id_sql = "";
		if(!empty($source_type)){
			$source_sql = " and hi.source_type='".$source_type."' ";
		}
		if(!empty($id)){
			$id_sql = ' and hi.source_id = '.$id.' ';
		}
		$q = $this->db->query('SELECT  hi.id,CONCAT(REPEAT("&nbsp;&nbsp;&nbsp;", level - 1), CAST(hi.activity AS CHAR)) AS activity, 
							   us.full_name,us.nik,us.profile_picture, hi.user_pic,hi.status, hi.*, progress.progress,progress.created_date as prog_date,  parent_id,deadline, level
									FROM    (
											SELECT  hierarchy_connect_by_parent_eq_prior_id(id) AS id, @level AS level
											FROM    (
													SELECT  @start_with := 0,
															@id := @start_with,
															@level := 0
													) vars, activity_steps
											WHERE   @id IS NOT NULL
											) ho
									JOIN    activity_steps hi
									ON      hi.id = ho.id '.$id_sql.' '.$source_sql.'
									LEFT JOIN user us on hi.user_pic = us.id
									LEFT JOIN progress ON progress.action_step_id = hi.id 
									AND progress.id = 
									(
									   SELECT MAX(progress.id) 
									   FROM progress
									   WHERE progress.action_step_id = hi.id
									)');
		return $q->result();					
	}
	
	function getActivityHierarchy($id='',$source_type=''){	
		$source_sql = "";
		$id_sql = "";
		if(!empty($source_type)){
			$source_sql = " and hi.source_type='".$source_type."' ";
		}
		if(!empty($id)){
			$id_sql = ' and hi.source_id = '.$id.' ';
		}
		$q = $this->db->query('SELECT  hi.id,CONCAT(REPEAT("&nbsp;&nbsp;&nbsp;", level - 1), CAST(hi.activity AS CHAR)) AS activity, 
							   us.full_name, hi.user_pic,hi.status, parent_id,deadline, level
									FROM    (
											SELECT  hierarchy_connect_by_parent_eq_prior_id(id) AS id, @level AS level
											FROM    (
													SELECT  @start_with := 0,
															@id := @start_with,
															@level := 0
													) vars, activity_steps
											WHERE   @id IS NOT NULL
											) ho
									JOIN    activity_steps hi
									ON      hi.id = ho.id '.$id_sql.' '.$source_sql.'
									LEFT JOIN user us on hi.user_pic = us.id');
		return $q->result_array();					
	}
	
	function getActivityProcess($id){
		$this->db->select("*")->from("progress")->where("action_step_id",$id);
		$q = $this->db->get();
		return $q->result_array();
	}
	
	function deleteActivitySteps($id){
		$this->db->trans_start();
		$this->db->where('id',$id);
		$this->db->delete('activity_steps');
		
		$this->db->where('parent_id',$id);
		$this->db->delete('activity_steps');
		
		$this->db->where('action_step_id',$id);
		$this->db->delete('progress');
		$this->db->trans_complete();

		$this->mfiles_upload->delete_db_where(array("ownership_type" => 'activity_steps', 'ownership_id' => $id),'comment');
	}

	function deleteActivityStepsOwnership($ownership_type,$ownership_id){
		$arr_where = array("source_id" => $ownership_id, "source_type" => $ownership_type);
		$as = $this->mfiles_upload->get_db("id","desc","activity_steps",$arr_where,"","");
		if($as){
			foreach($as as $each){
				$this->deleteActivitySteps($each->id);
			}
		}
		
	}
	
	function saveActivitySteps($data,$act_id){
		$user = $this->session->userdata('userdb');
		
		if($data['parent_id']){
			$this->db->where('action_step_id',$data['parent_id']);
			$this->db->delete('progress');
		}
			
		if(empty($act_id)){
			$data['created_by'] = $user['id'];
			$data['created_date'] = date("Y-m-d H:i:s");

			$this->db->insert("activity_steps",$data);
			return $this->db->insert_id();
		}
		else{
			$data['updated_by'] = $user['id'];
			$data['updated_date'] = date("Y-m-d H:i:s");

			$this->db->where("id",$act_id);
			$this->db->update("activity_steps",$data);
			return $act_id;
		}
	}
	
	function getActivityDetail($id){
		$this->db->select("a.*,b.full_name, b.nik, b.profile_picture")->from("activity_steps a")->where("a.id",$id);
		$this->db->join("user b","a.user_pic = b.id","left");
		$q = $this->db->get();
		return $q->result_array();
	}

	function get_activity_by_id($id){
		$this->db->select("a.*,b.full_name, b.nik, b.profile_picture")->from("activity_steps a")->where("a.id",$id);
		$this->db->join("user b","a.user_pic = b.id","left");
		$q = $this->db->get()->result();
		if($q) return $q[0];
		else return false;
	}
	
	function getProcessList($act_id){
		$this->db->select("*")->from("progress")->where("action_step_id",$act_id);
		$q = $this->db->get();
		return $q->result_array();
	}
	
	function getProcessDetail($id){
		$this->db->select("*")->from("progress")->where("id",$id);
		$q = $this->db->get();
		return $q->result_array();
	}
	
	function saveProgress($data,$pg_id){
		if(empty($pg_id)){
			$this->db->insert("progress",$data);
			return true;
		}
		else{
			$this->db->where("id",$pg_id);
			$this->db->update("progress",$data);
			return true;
		}
	}
	
	function deleteProgress($pg_id){
		if(isset($pg_id)){
			$this->db->where("id",$pg_id);
			$this->db->delete("progress");
			return true;
		}
		else{
			return false;
		}
	}
	function deleteActivityProgress($id){
		$this->db->where('id',$id);
		$this->db->delete('progress');
	}

	function check_delay_activities(){
		$today = date('y-m-d');
		$this->db->where('deadline < ',$today);
		$this->db->where('status <>',"Done");

		$data = array(
           'status' => 'Delay',
        );

        $this->db->update('activity_steps', $data);

	}

	function get_all_pic($parent_id, $source_type, $source_id){
		$this->db->select('distinct(user_pic) as user_id');
		$this->db->where_in('id',$parent_id);
		$this->db->or_where_in('parent_id',$parent_id);
		$this->db->order_by('user_pic','asc');
		$result_pic = $this->db->get('activity_steps');
		$res_pic = $result_pic->result();

		$result_src = array();
		if(strtolower($source_type)=='call report'){
			$this->db->select('distinct(user_id) as user_id');
			$this->db->where('id',$source_id);
			$result_src = $this->db->get('call_reports');
		}else if(strtolower($source_type)=='account_plan'){
			$this->db->select('distinct(created_by) as user_id');
			$this->db->where('id',$source_id);
			$result_src = $this->db->get('call_reports');
		}else if(strtolower($source_type)=='legal advis'){
			$this->db->select('distinct(created_by) as user_id');
			$this->db->where('id',$source_id);
			$result_src = $this->db->get('call_reports');
		}else if(strtolower($source_type)=='ssf project'){
			$this->db->select('distinct(created_by) as user_id');
			$this->db->where('id',$source_id);
			$result_src = $this->db->get('ssf_project');
		}else if(strtolower($source_type)=='credit_pipeline'){
			$this->db->select('distinct(created_by) as user_id');
			$this->db->where('id',$source_id);
			$result_src = $this->db->get('ssf_project');
		}else if(strtolower($source_type)=='courtesy call'){
			$this->db->select('distinct(created_by) as user_id');
			$this->db->where('id',$source_id);
			$result_src = $this->db->get('ssf_project');
		}else if(strtolower($source_type)=='others'){
			
		}
		$final_array = array();
		if($result_src){
			$res_src = $result_src->result();
			$final_array = array_merge($res_pic,$res_src);
			$final_array = array_unique($final_array);
		}else{
			$final_array = $res_pic;
		}
		return $final_array;
	}
}
