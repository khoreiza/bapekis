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
class Mmysharing extends CI_Model {
    //put your code here
    function __construct() {
        parent::__construct();
        $this->load->database();
        $this->load->model(array('mfiles_upload'));
    }
    
    //INSERT or CREATE FUNCTION
    function insert($program){
        if($this->db->insert('mysharing', $program)){
        	return $this->db->insert_id();
        }else{
        	return false;
        }
    }
    
    /*UPDATE FUNCTION*/
    function update($program,$id){
        $this->db->where('id',$id);
        return $this->db->update('mysharing', $program);
    }
    
    function get_detil($param,$limit,$offset,$category){
        $user = $this->session->userdata('userbapekis');
        $reader = $user['position'];
        $uid = $user['id'];

        $ua = 'xxx';
        $ua_data = "";//$this->mfiles_upload->get_db('id','desc','cbgroup',array('group_name' => $user['group']),'','');
        if($ua_data){$ua = $ua_data[0]->id;}
        //echo $uid;
        
        /*if(!is_user_role($user,"SYSTEM ADMINISTRATOR")){
            $this->db->where("(mysharing.created_by = ".$user['id']." OR ((position_allowed LIKE '%$reader%' OR position_allowed LIKE '%all%' OR position_allowed = '') AND (group_allowed LIKE '%$ua%' OR group_allowed LIKE '%all%' OR group_allowed = '') AND (mysharing.user_allowed = '')) OR  mysharing.user_allowed LIKE '%;$uid;%')");
        }*/
        
        if($param == "category"){
            $this->db->where('category.category',$category);
        }

        $this->db->select('mysharing.*, mysharing.id as mysharing_id, user.full_name, user.nik, user.profile_picture, files_upload.full_url, category.category, category.description as category_description');
        $this->db->order_by('mysharing.created_at','desc');
        $this->db->order_by('mysharing_id','desc');
        $this->db->join('user', 'mysharing.created_by = user.id');
        $this->db->join('category', 'mysharing.category_id = category.id','left');

        $files_upload_table_sharing = "(SELECT `files_upload`.full_url,ownership_id from files_upload where modul = 'my sharing' and sub_modul = 'banner') as files_upload";
        $this->db->join($files_upload_table_sharing,'files_upload.ownership_id = mysharing.id','left');


        $this->db->from('mysharing');

        if($limit) $this->db->limit($limit, $offset);
        
        $mysharing = $this->db->get()->result();
        /*$finalarr = array(); $i=0;
        foreach($mysharing as $row)
        {
            $finalarr[$i]['mysharing'] = $row;
            //$finalarr[$i]['attachment'] = $this->mfiles_upload->get_files_upload_by_ownership_id('my sharing','my sharing',$row->mysharing_id);
            /*if($param == "all"){
                $finalarr[$i]['img'] = $this->mfiles_upload->get_files_upload_by_ownership_id_order('my sharing','img',$row->mysharing_id, "title", "asc");
            }

            $i++;
        }*/
        return $mysharing;
	}

    function get_detil_search($search, $type){
        $user = $this->session->userdata('userbapekis');
        $reader = $user['position'];
        $uid = $user['id'];

        $ua = 'xxx';
        $ua = $this->mfiles_upload->get_db('id','desc','cbgroup',array('group_name' => $user['group']),'','');
        if($ua) $ua = $ua[0]->id;

        if($type == "vst") $this->db->where('type',$type);
  
        if(!is_user_role($user,"SYSTEM ADMINISTRATOR")){
            $this->db->where("(mysharing.created_by = ".$user['id']." OR ((position_allowed LIKE '%$reader%' OR position_allowed LIKE '%all%' OR position_allowed = '') AND (group_allowed LIKE '%$ua%' OR group_allowed LIKE '%all%' OR group_allowed = '') AND (mysharing.user_allowed = '')) OR ((mysharing.user_allowed LIKE '%;$uid;%') ) )");
        }

        $this->db->select('mysharing.*, mysharing.id as mysharing_id, user.full_name, user.nik, user.profile_picture, user.panggilan, files_upload.full_url, category.category');
        $this->db->order_by('mysharing.created_at','desc');
        $this->db->order_by('mysharing_id','desc');
        $this->db->join('user', 'mysharing.created_by = user.id');
        $this->db->join('category', 'mysharing.category_id = category.id','left');
        $this->db->join('files_upload','files_upload.ownership_id = mysharing.id AND modul = "my sharing" AND sub_modul = "banner"','left');

        //$search_arr = explode(" ",$search);
        //foreach($search_arr as $src){
        $this->db->where("(mysharing.title LIKE '%$search%' OR full_name LIKE '%$search%' OR mysharing.description LIKE '%$search%')");
        //$this->db->or_like('full_name',$search);
        //$this->db->or_like('description',$search);
          //  $this->db->or_like('full_name',$src);
        //}

        $this->db->from('mysharing');
        
        $mysharing = $this->db->get()->result();
        /*$finalarr = array(); $i=0;
        foreach($mysharing as $row)
        {
            $finalarr[$i]['mysharing'] = $row;
            $finalarr[$i]['attachment'] = $this->mfiles_upload->get_files_upload_by_ownership_id('my sharing','my sharing',$row->mysharing_id);
            $finalarr[$i]['img'] = $this->mfiles_upload->get_files_upload_by_ownership_id_order('my sharing','img',$row->mysharing_id, "title", "asc");

            $i++;
        }*/
        return $mysharing;
    }
    
    function get_detil_by_id($id,$param,$reader,$ua){
        $user = $this->session->userdata('userbapekis');

        $reader = $user['position'];
        $uid = $user['id'];

        
        $ua = "";//$this->mfiles_upload->get_db('id','desc','cbgroup',array('group_name' => $user['group']),'','');
        if($ua) $ua = $ua[0]->id;
        else $ua = 'xxx';

        
        if(!is_user_role($user,"SYSTEM ADMINISTRATOR")){
            $this->db->where("(mysharing.created_by = ".$user['id']." OR ((position_allowed LIKE '%$reader%' OR position_allowed LIKE '%all%'  OR position_allowed = '') AND (group_allowed LIKE '%$ua%' OR group_allowed LIKE '%all%' OR group_allowed = '')) OR ((mysharing.user_allowed LIKE '%;$uid;%') ) )");
        }

        $this->db->select('*, mysharing.id as mysharing_id, mysharing.updated_at as mysharing_show_date');
        $this->db->where('mysharing.id',$id);
        $this->db->order_by('mysharing.created_by','desc');
        $this->db->order_by('mysharing_id','desc');
        $this->db->join('user', 'mysharing.created_by = user.id');
        $this->db->from('mysharing');
        $query = $this->db->get();
        $mysharing = $query->result();
        $finalarr = array(); $i=0;
        foreach($mysharing as $row)
        {
            $finalarr[$i]['mysharing'] = $row;
            
            $finalarr[$i]['attachment'] = $this->mfiles_upload->get_files_upload_by_ownership_id('my sharing','attachment',$row->mysharing_id);
            $finalarr[$i]['img'] = $this->mfiles_upload->get_files_upload_by_ownership_id_order('my sharing','gallery',$row->mysharing_id, "title", "asc");
            
            $i++;
        }
        return $finalarr;
            //return $query->result();
	}
    
    function get_by_id($id){
		$this->db->where('id',$id);
        $query = $this->db->get('mysharing');
		return $query->result()[0];
	}

    function get_by_id_with_atc($id){
        $arr['mysharing'] = $this->get_by_id($id);
        $arr['attachment'] = $this->mfiles_upload->get_files_upload_by_ownership_id('my sharing','attachment',$id);
        $arr['img'] = $this->mfiles_upload->get_files_upload_by_ownership_id('my sharing','img',$id);
        return $arr;
    }
    
    function get_by_id_with_atc_tokosidia($id){
        $arr['mysharing'] = $this->get_by_id($id);
        $arr['attachment'] = $this->mfiles_upload->get_files_upload_by_ownership_id('tokosidia','attach',$id);
        $arr['img'] = $this->mfiles_upload->get_files_upload_by_ownership_id('tokosidia','img',$id);
        return $arr;
    }

    function delete_mysharing($id){
    	$this->db->where('id',$id);
    	$this->db->delete('mysharing');
    	if($this->db->affected_rows()>0){
    		return true;
    	}
    	else{
    		return true;
    	}
    }
    
}