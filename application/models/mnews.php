<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of admins
 *
 * @author Roonie
 */
class Mnews extends CI_Model {
    //put your code here
    function __construct() {
        parent::__construct();
        $this->load->database();
        $this->load->model(array('mfiles_upload'));
    }
    
    //INSERT or CREATE FUNCTION
    function insert_news($program){
        if($this->db->insert('news', $program)){
        	return $this->db->insert_id();
        }else{
        	return false;
        }
    }
    
    function insert($program){
        if($this->db->insert('risk_prof', $program)){
        	return $this->db->insert_id();
        }else{
        	return false;
        }
    }
    
    function insert_crs($program){
        if($this->db->insert('crs', $program)){
        	return $this->db->insert_id();
        }else{
        	return false;
        }
    }
    
    function insert_audit($program){
        if($this->db->insert('audit_find', $program)){
        	return $this->db->insert_id();
        }else{
        	return false;
        }
    }
    
    //UPDATE FUNCTION
    function update_news($program,$id){
        $this->db->where('id',$id);
        return $this->db->update('news', $program);
    }
    
    function update_crs($program,$id){
        $this->db->where('id',$id);
        return $this->db->update('crs', $program);
    }
    
    function update_audit($program,$id){
        $this->db->where('id',$id);
        return $this->db->update('audit_find', $program);
    }

    function update_file_type($modul, $ownership_id, $sub_modul){
        $program['sub_modul'] = $sub_modul;
        $this->db->where('ownership_id',$ownership_id);
        $this->db->where('modul',$modul);
        return $this->db->update('files_upload', $program);
    }
    
    //GET FUNCTION
    function get_all_audit(){
		$user = $this->session->userdata('userdb');
        $this->db->select('*');
        if(!is_user_role($user,"SYSTEM ADMINISTRATOR") && !is_user_role($user,"POLICY ADMINISTRATOR")){
            $this->db->where('group',$user['group']);
        }
        $this->db->order_by('date','desc');
        $this->db->order_by('id','desc');
        $query = $this->db->get('audit_find');
		return $query->result();
	}

    function get_audit($array_of_where){
        $user = $this->session->userdata('userdb');
        $this->db->select('*');
        if(!is_user_role($user,"SYSTEM ADMINISTRATOR") && !is_user_role($user,"POLICY ADMINISTRATOR")){
            $this->db->where('group',$user['group']);
        }
        if(!empty($array_of_where)){
            $this->db->where($array_of_where);
        }
        $this->db->order_by('date','desc');
        $this->db->order_by('id','desc');
        $query = $this->db->get('audit_find');
        return $query->result();
    }
    
    function get_all_crs_detil(){
        $user = $this->session->userdata('userdb');
        $this->db->select('*');
        if(!is_user_role($user,"SYSTEM ADMINISTRATOR") && !is_user_role($user,"POLICY ADMINISTRATOR")){
            $this->db->where("(user_id = ".$user['id']." OR ((position_allowed LIKE '%".$user['position']."%' OR position_allowed LIKE '%all%') AND (user_allowed LIKE '%".$user['group']."%' OR user_allowed LIKE '%all%')))");
        }
        $this->db->from('crs');
        $this->db->order_by('id','desc');
        $query = $this->db->get();
        $dsfiles = $query->result();
        $finalarr = array(); $i=0;
        foreach($dsfiles as $row)
        {
            $finalarr[$i]['crs'] = $row;
            $finalarr[$i]['attachment'] = $this->mfiles_upload->get_files_upload_by_ownership_id('compliance','crs',$row->id);
            $i++;
        }
        return $finalarr;
    }
    
    function get_crs_by_id($id){
		$this->db->where('id',$id);
        $query = $this->db->get('crs');
		return $query->result()[0];
	}
    
    function get_audit_by_id($id){
		$this->db->where('id',$id);
        $query = $this->db->get('audit_find');
		return $query->result()[0];
	}

    function get_crs_by_id_with_atc($id){
        $arr['crs'] = $this->get_crs_by_id($id);
        $arr['attachment'] = $this->mfiles_upload->get_files_upload_by_ownership_id('compliance','crs',$id);
        return $arr;
    }
    
    
    function get_news_with_param($offset, $length, $param){
        if(isset($param['modul'])){
            $this->db->where('modul',$param['modul']);
        }

        if(isset($param['submodul'])){
            $submodul = $param['submodul'];
            if(is_array($submodul)){
                $subs = implode(",", $submodul);
                $this->db->where('sub_modul in ('.$subs.')');
            }
            else{
                $this->db->where('sub_modul',$submodul);
            }
        }

        if(isset($param['category_id'])){
            $this->db->where('category_id',$param['category_id']);
        }


        if(isset($param['search'])){
            $this->db->where("(title LIKE '%".$param['search']."%' OR category LIKE '%".$param['search']."%' )");
        }


        if(!empty($length)){
          $this->db->limit($length,$offset);
        }

        $files_upload_table = "(SELECT `files_upload`.full_url,ownership_id from files_upload where modul = 'photo' and sub_modul = 'market') as files_upload";
        $join_market[0] = array('table' => $files_upload_table, 'in' => "files_upload.ownership_id = news.id", 'how' => 'left');
        $join_market[1] = array('table' => 'user', 'in' => "user.id = news.user_id");
        $join_market[2] = array('table' => 'category', 'in' => "category.id = news.category_id", 'how' => 'left');

        $select = 'news.id,news.title,news.sub_modul,news.user_id,news.user_allowed,news.created,news.sub_modul,news.description, files_upload.full_url, full_name, profile_picture, nik, category';

        $markets = $this->mfiles_upload->get_db_join('`news.created` desc,`news.id`','desc','news',array('news.modul'=>'market'),$select,'','',$join_market);

        return $markets;
    }


    function get_latest_news_modul_submodul($offset, $length, $modul, $submodul){
		$this->db->where('modul',$modul);
		if($submodul){
			if(is_array($submodul)){
                $subs = implode(",", $submodul);
                $this->db->where('sub_modul in ('.$subs.')');
            }
            else{
                $this->db->where('sub_modul',$submodul);
            }
		}
		$this->db->select('news.*, user.full_name,user.profile_picture,user.nik,user.panggilan');
        if(!empty($length)){
		  $this->db->limit($length,$offset);
		}
        $this->db->order_by('news.created', 'DESC');
		$this->db->order_by('news.id', 'DESC');
        $this->db->from('news');
        $this->db->join('user','news.user_id = user.id');
        $query = $this->db->get();
		return $query->result();
	}

    function get_news_by_id_with_atc($id){
            $news = $this->get_detil_news_by_id($id);
            $arr['news'] = $news;
            $arr['attachments'] = $this->mfiles_upload->get_files_upload_by_ownership_id("$news->modul", '', $id);
            $arr['photo'] = $this->mfiles_upload->get_files_upload_by_ownership_id("photo","$news->modul", $id);
        return $arr;
    }
	
	function get_latest_news_modul_submodul_with_atc($offset, $length, $modul, $submodul){
		$news = $this->get_latest_news_modul_submodul($offset, $length, $modul, $submodul);
		$arr = array(); $i=0;
		foreach($news as $row){
			$arr[$i]['news'] = $row;
			$arr[$i]['attachments'] = $this->mfiles_upload->get_files_upload_by_ownership_id($modul, '', $row->id);
			$arr[$i]['photo'] = $this->mfiles_upload->get_files_upload_by_ownership_id("photo", $modul, $row->id);
			$i++;
		}
		return $arr;
	}
	
	function get_news_modul_submodul_search($modul, $submodul, $search){
		$this->db->where('modul',$modul);
		if($submodul){
			$this->db->where('sub_modul',$submodul);
		}
		$this->db->select('news.*, user.full_name');
		
		//$this->db->like('title',$search);
		//$this->db->or_like('description',$search);
		$search_arr = explode(" ",$search);
		foreach($search_arr as $src){
			$this->db->like('title',$src);
			$this->db->or_like('description',$src);
		}
		
		$this->db->order_by('news.id', 'DESC');
        $this->db->from('news');
        $this->db->join('user','news.user_id = user.id');
        $query = $this->db->get();
		return $query->result();
	}
	
	function get_all_news_modul_submodul($modul, $submodul){
		$this->db->where('modul',$modul);
		if($submodul){
			$this->db->where('sub_modul',$submodul);
		}
		$this->db->select('news.*, user.full_name');
		$this->db->order_by('news.id', 'DESC');
        $this->db->from('news');
        $this->db->join('user','news.user_id = user.id');
        $query = $this->db->get();
		return $query->result();
	}
	
	function get_detil_news_by_id($id){
		$this->db->where('news.id',$id);
        $this->db->select('news.*, user.full_name, user.nik, user.profile_picture');
        $this->db->join('user','news.user_id = user.id');
        $query = $this->db->get('news');
        if(count($query->result())>0){
            return $query->result()[0]; 
        }else{
		    return null;
	    }
    }
	
	//DELETE FUNCTION
	function delete_news($id,$type){
        $name = $this->get_detil_news_by_id($id);
        $this->mnews->delete_news_and_atch($id);
        $this->mfiles_upload->delete_with_files_ownership_with_folder($id,$type,$name->sub_modul, true);
        $this->mfiles_upload->delete_with_files_ownership_with_folder($id,'photo',$type, true);
        $this->mfiles_upload->delete_with_files_ownership_with_folder($id,'gallery',$type, true);

        if($type=='market'){
            if($name->photo){unlink("assets/uploads/market/photos/".$name->photo);}
            $this->mupdates->delete_with_ownership_id("Market Outlook",$id);
        }
        else if($type=='compliance') $this->mupdates->delete_with_ownership_id("Legal & Compliance News",$id);
        else if($type=='product_knowledge') $this->mupdates->delete_with_ownership_id("Product Knowledge",$id);
        else if($type=='hr') $this->mupdates->delete_with_ownership_id("Human Resources",$id);
        else if($type=='calendar news'){
            if(is_dir("assets/uploads/calendar/".$name->ownership_id."/publications/".$id)) rmdir("assets/uploads/calendar/".$name->ownership_id."/publications/".$id);
        }

        return true;
    }

    function vote_news($id,$type){
        $user = $this->session->userdata('userdb');
        $data = array(
                'date' => date('Y-m-d'),
                'news_id' => $id,
                'user_id' => $user['id']
        );

        $this->db->insert('vote_news', $data);

        return true;
    }




    function delete_news_and_atch($id){
    	$this->db->where('id',$id);
    	$this->db->delete('news');
    	if($this->db->affected_rows()>0){
    		return true;
    	}
    	else{
    		return true;
    	}
    }
	
    function get_all_risk_by_limit($key=''){
		$this->db->select('*');
        $this->db->order_by('id','asc');
        $this->db->limit(3,0);
        if(!empty($key))
        {
            $this->db->where('group',$key);
        }
        $this->db->from('risk_prof');
        $query = $this->db->get();
		return $query->result();
	} 
    
    function get_all_risk($key){
		$this->db->select('*');
        $this->db->order_by('id','asc');
        if($key!=null)
        {
            $this->db->where('group',$key);
        }
        $this->db->from('risk_prof');
        $query = $this->db->get();
		return $query->result();
	}
	
	
	
    function get_latest_internal_news(){
		$this->db->where('policy_type',"internal");
		$this->db->limit(5,0);
		$this->db->order_by('id', 'DESC');
        $query = $this->db->get('policy');
		return $query;
	}
    
    function get_latest_external_news(){
		$this->db->where('policy_type',"external");
		$this->db->limit(5,0);
		$this->db->order_by('id', 'DESC');
        $query = $this->db->get('policy');
		return $query;
	}    

    function submit_news(){
		$config['upload_path']   = "assets/uploads/news/";
        $config['allowed_types'] = 'gif|jpg|png';
		
		//cek duplikasi nama
		$is_same=true;
		for($i=1;$is_same;$i++){
			$count=0;
			$this->db->where('attachment_name',"c_".$i."_".$_FILES['upload']['name']);
			$query=$this->db->get('policy');
			foreach($query->result() as $row)$count++;
			if($count==0){
				$config['file_name'] = "c_".$i."_".$_FILES['upload']['name'];
				$is_same=false;
			}
		}
		// $config['max_size']             = 100;
        // $config['max_width']            = 1024;
        // $config['max_height']           = 768;

        $this->load->library('upload');
		$this->upload->initialize($config);
		if ( ! $this->upload->do_upload("upload"))
        {
            // $notif = array("notif" => $this->upload->display_errors(), "type" => "error");
			$file_name=null;
			$file_type=null;
			$file_size=null;
        }
        else
        {
			$file_name=$this->upload->data()['file_name'];
			$file_type=$this->upload->data()['file_type'];
			$file_size=$this->upload->data()['file_size'];
        }
		$user = $this->session->userdata('userdb');
		$data = array(
				'date' => date('Y-m-d'),
				'title' => $this->input->post('title'),
				'policy_type' => $this->input->post('news_type'),
				'desc' => $this->input->post('desc'),
				'attachment_name' => $file_name,
				'attachment_type' => $file_type,
				'attachment_size' => $file_size,
				'user_id' => $user['id']
		);

		$this->db->insert('policy', $data);
        $notif = array("notif" => "News successfuly added!", "type" => "success");
		return $notif;
    }

    function submit_update_news($id){
		$data = array(
				'title' => $this->input->post('title'),
				'policy_type' => $this->input->post('news_type'),
				'desc' => $this->input->post('desc')
		);

		$this->db->where('id', $id);
		$this->db->update('policy', $data);
        $notif = array("notif" => "News successfuly updated!", "type" => "success");
		return $notif;
    }
    
    function delete_crs($id){
    	$this->db->where('id',$id);
    	$this->db->delete('crs');
    	if($this->db->affected_rows()>0){
    		return true;
    	}
    	else{
    		return true;
    	}
    }
    
    function delete_audit($id){
    	$this->db->where('id',$id);
    	$this->db->delete('audit_find');
    	if($this->db->affected_rows()>0){
    		return true;
    	}
    	else{
    		return true;
    	}
    }
    
    function delete_all_data_risk_prof(){
        $this->db->empty_table('risk_prof');
    }

}