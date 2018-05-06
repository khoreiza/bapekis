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
class Muser extends CI_Model {
    //put your code here
    function __construct() {
        parent::__construct();
        $this->load->database();
        //$this->load->model(array('mfiles_upload'));
    }

    //INSERT or CREATE FUNCTION
    function verify($username, $password){
        $this->db->where('status','active');
        $this->db->where('username',$username);
        $this->db->where('password',$password);
        $result = $this->db->get('user')->result();
        
        if($result){
            return true;
        }else{
            return false;
        }
    }

    function insert_shortcut($user){
        return $this->db->insert('user_shortcut', $user);
    }

    function insert_user($user){
        return $this->db->insert('user', $user);
    }

	function insert_phonebook($user){
        return $this->db->insert('relationmanager', $user);
    }

    function insert_user_login_log($user_id){
        return $this->insert_user_access_log("login");
    }

    function insert_user_logout_log($user_id){
        return $this->insert_user_access_log("logout");
    }

    function insert_user_access_log($activity){
        $user = $this->session->userdata('userbapekis');
        $user_activity['user_id'] = $user['id'];
        $user_activity['activity'] = $activity;
        //$user_activity['datetime'] = date("Y-m-d H:i:s");
        $user_activity['date'] = date("Y-m-d");
        $user_activity['time'] = date("H:i:s");
        return $this->db->insert('user_activity', $user_activity);
    }


    function register($user){
    	return $this->db->insert('user', $user);
    }

    //GET FUNCTION
    function get_today_birthday(){
        $month = date('m');
        $day = date('d');
        $this->db->where("MONTH(dob) = $month AND DAY(dob) = $day AND is_employee = 1");
        $this->db->where("is_employee = 1");
        $this->db->where("status",'active');
        return $this->get_all_user();
    }

    function get_upcoming_birthday(){
        $year = date('Y');
        $date = date('Y-m-d', time() + 3600*24*1);
        $maxdate = date('Y-m-d', time() + 3600*24*4); /* 3 for 3 days */

        $this->db->select("*, DATE_FORMAT(dob,'$year-%m-%d') AS birthday", false);
        $this->db->where("DATE_FORMAT(dob,'$year-%m-%d') BETWEEN '$date' AND '$maxdate' AND is_employee = 1");
        $this->db->where("is_employee = 1");
        $this->db->where("status",'active');
        $this->db->order_by('birthday', 'asc');
        $query = $this->db->get('user');

        return $query->result();
    }

    function get_user_unit(){
        $user = $this->session->userdata('userbapekis');
        
        $dir = $this->mfiles_upload->get_db("id",'asc','cbdirectorate',array('directorate' => strtoupper($user['directorate'])),'','');
        ($dir) ? $arr_res['dir'] = $dir[0] : $arr_res['dir'] = "";

        $group = $this->mfiles_upload->get_db("id",'asc','cbgroup',array('group_name' => strtoupper($user['group'])),'','');
        ($group) ? $arr_res['group'] =  $group[0] : $arr_res['group'] = "";
        
        return $arr_res;
    }

    function get_my_profile(){
        $user = $this->session->userdata('userbapekis');
        return $this->get_user_by_nik($user['nik']);
    }

    function get_all_user(){
    	$this->db->order_by('full_name', 'asc');
    	$query = $this->db->get('user');
        return $query->result();
    }

	function get_user_employee(){
    	$this->db->where('is_employee',1);
		$this->db->order_by('full_name', 'asc');
    	$query = $this->db->get('user');
        return $query->result();
    }

    function get_all_user_log(){
    	$this->db->join('user', 'user.id = user_log.user_id');
    	$this->db->order_by('login_time', 'desc');
    	$query = $this->db->get('user_log');
        return $query->result();
    }

    function get_user_login(){
        $user = $this->session->userdata('user');
    	$this->db->where('id',$user['user_id']);
        $result = $this->db->get('user');
        if($result->num_rows==1){
            return $result->row(0);
        }else{
        	$this->session->unset_userdata('user');
            return false;
        }
    }

    function get_user_id_by_username($username){
        $this->db->where('username',$username);
        $result = $this->db->get('user');
        if($result){
            return $result->row(0);
        }else{
            return false;
        }
    }

    function get_user_by_id($id){
        $this->db->select('user.id as user_id, user.*'/*, cbdept.*, cbgroup.*'*/);
        $this->db->where('user.id',$id);
        //$this->db->join('cbdept', 'cbdept.id = user.cbdept_id');
        //$this->db->join('cbgroup', 'cbgroup.id = cbdept.cbgroup_id');
        $result = $this->db->get('user');
        if($result->num_rows==1){
            return $result->row(0);
        }else{
            return false;
        }
    }

	function get_user_by_nik($nik){
        $this->db->where('user.nik',$nik);
        $result = $this->db->get('user');
        if($result->num_rows==1){
            return $result->row(0);
        }else{
            return false;
        }
    }

    function get_user_buc(){
        $user = $this->session->userdata('userbapekis');
        if(isset(explode("Sector ", $user['dept'])[1])){
            $user_sector = explode("Sector ", $user['dept'])[1];

            $arr_where = array('business_unit' => 1);
            $user_buc = $this->mfiles_upload->search_db_content("cbdept", array("dept_name","other_name"), $user_sector, $arr_where, '','id','asc');
            if($user_buc){return $user_buc[0]->buc;}
        }elseif ($user['dept'] == "Overseas Business Development Department") {
            $user_sector = "Overseas Business Development Department";

            $arr_where = array('business_unit' => 1);
            $user_buc = $this->mfiles_upload->search_db_content("cbdept", array("dept_name","other_name"), $user_sector, $arr_where, '','id','asc');
            if($user_buc){return $user_buc[0]->buc;}
        }
        else{return false;}
    }

  	function get_user_buc_analytics($dept){
        if(isset(explode("Sector ", $dept)[1])){
            $user_sector = explode("Sector ", $dept)[1];

            $arr_where = array('business_unit' => 1);
            $user_buc = $this->mfiles_upload->search_db_content("cbdept", array("dept_name","other_name"), $user_sector, $arr_where, '','id','asc');
            if($user_buc){return $user_buc[0]->buc;}
        }elseif ($dept == "Overseas Business Development Department") {
            $user_sector = "Overseas Business Development Department";

            $arr_where = array('business_unit' => 1);
            $user_buc = $this->mfiles_upload->search_db_content("cbdept", array("dept_name","other_name"), $user_sector, $arr_where, '','id','asc');
            if($user_buc){return $user_buc[0]->buc;}
        }
        else{return false;}
    }

    function get_user_buc_general(){
        $user = $this->session->userdata('userbapekis');
        if(isset(explode("Sector ", $user['dept'])[1])){
            $user_sector = explode("Sector ", $user['dept'])[1];

            $arr_where = array('is_used' => 1);
            $user_buc = $this->mfiles_upload->search_db_content("cbdept", array("dept_name","other_name"), $user_sector, $arr_where, '','id','desc');
            if($user_buc){return $user_buc[0]->buc;}
        }else{
            $user_sector = $user['dept'];

            $arr_where = array('is_used' => 1);
            $user_buc = $this->mfiles_upload->search_db_content("cbdept", array("dept_name","other_name"), $user_sector, $arr_where, '','id','desc');
            if($user_buc){return $user_buc[0]->buc;}
        }
    }

    function get_user_by_jabatan($jabatan,$arr_where){
        $this->db->select("user.*,user.id as user_id");
        $this->db->like('jabatan', $jabatan);
        $this->db->where($arr_where);
        $result = $this->db->get('user');
        if($result->num_rows==1){
            return $result->row(0);
        }else{
            return false;
        }
    }

    function get_user_list_by_jabatan($jabatan, $order_by = "id", $order_dir = "asc") {
        if (is_array($jabatan)) {
            $this->db->where_in('jabatan', $jabatan);
        }
        else {
            $this->db->where('jabatan', $jabatan);
        }

        $this->db->order_by($order_by, $order_dir);
        $query = $this->db->get('user');

        return $query->result();
    }

    function get_user_password($nik, $password){
        $value = false;
    	$this->db->where('nik',$nik);
        $this->db->where('password',$password);
        $result = $this->db->get('user');
        if($result->num_rows==1){
            $value=true;
        }
        return $value;
    }

    function get_user_name_header(){
    	$user = $this->session->userdata('user');
        if($user){
        	$user = $this->get_user_login();
        	if(!$user){redirect('home');}
        	$user_first_name = explode(' ',$user->name);
        	return $user_first_name[0];
        }else{
        	return null;
        }
    }

    function get_existing_email($email){
        // return true jika ada email di tabel user_temp atau user
        $this->db->where('username',$email);
        $result = $this->db->get('user');
        if($result->num_rows>0){
            return true;
        }else{
            return false;
        }
    }

    function get_all_roles(){
        $query = $this->db->get('role');
        return $query->result();
    }

    function get_all_cbgroup(){
        $query = $this->db->get('cbgroup');
        return $query->result();
    }

    function get_all_activity($group){
        $this->db->select('user.*, user_activity.*, user_activity.id as activity_id');
        $this->db->join('user', 'user.id = user_activity.user_id');
		$this->db->where('user.full_name <>','Tezza LR');
		if($group){
            $this->db->where('user.group',$group);
        }
        $this->db->order_by('datetime', 'desc');
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

    function get_unique_group_with_head(){
        $this->db->distinct();
        $this->db->select('group');
        $this->db->where('is_employee',1);
        $this->db->not_like('group', 'Regional');
        $this->db->where('position <>', 'Director');
        $this->db->where('status', 'active');
        $this->db->order_by('group', 'asc');
        $query = $this->db->get('user');
        $groups = $query->result();

        $arr_group = array(); $i=0;
        foreach($groups as $row){
            $order = $i;
            if($row->group == "EXECUTIVE BUSINESS OFFICER - B"){$order = 8;}
            elseif($row->group == "EXECUTIVE RELATIONSHIP OFFICER"){$order = 9;}
            elseif($row->group == "CORPORATE BANKING SOLUTION"){$order = 7;}
            //elseif($row->group == "Dana Pensiun Lembaga Keuangan"){$order = 10;}
            elseif($row->group == "Decentralized Compliance & Opr. Risk" || $row->group == "DCOR"){$order = 11;}
            elseif($row->group == "DECISION SUPPORT"){$order = 12;}
            elseif($row->group == "HCBP Corporate Banking"){$order = 13;}

            $group_cb = $this->get_group_head($row->group);

            if($group_cb){
                $arr_group[$order]['group'] = $row->group;
                $arr_group[$order]['head'] = $group_cb;

                //echo $arr_group[$order]['group']." - ".$arr_group[$order]['head']->full_name." - ".$order."<br>";
                //echo $row->group." ".$i;
                $i++;
            }
        }
        return $arr_group;
    }

    function get_group_member($group){
        $arr_member = array();
        $arr_member['group'] = $group;
        $arr_member['head'] = $this->get_group_head($group);
        $arr_member['sekretaris'] = $this->get_by_group_jabatan($group,"Sekretaris");
        $arr_member['department'] = $this->get_group_dept($group,$arr_member['head']->department);

        return $arr_member;
    }

    function get_group_head($group){
        //if($group == "Dana Pensiun Lembaga Keuangan"){$this->db->like('jabatan','Direktur Utama');}
        if($group == "DECISION SUPPORT"){$this->db->like('jabatan','DS HEAD');}
        elseif($group == "HCBP Corporate Banking"){$this->db->like('jabatan','HCBP HEAD');}
        elseif($group == "Decentralized Compliance & Opr. Risk" || $group == "DCOR"){$this->db->like('jabatan','DCOR HEAD');}
        elseif($group == "EXECUTIVE BUSINESS OFFICER - B"){$this->db->like('jabatan','Executive Business Officer - B');}
        elseif($group == "EXECUTIVE RELATIONSHIP OFFICER"){$this->db->like('jabatan','Executive Relationship Officer');}
        //elseif($group == "CORPORATE BANKING SOLUTION"){$this->db->like('jabatan','Group Head');}
        else{$this->db->like('jabatan','Group Head');}

        $this->db->where('is_employee',1);
        $this->db->where('status','active');
        $this->db->where('group',$group);
        $query = $this->db->get('user');
        if($query->result()){
            if(count($query->result()) > 1) return $query->result();
            elseif(count($query->result()) == 1) return $query->result()[0];
        }else{return false;}
    }

    function get_group_dept($group,$head_dept){
        $this->db->distinct();
        $this->db->select('department');
        $this->db->where('is_employee',1);
        $this->db->where('group',$group);
        $arr_dept_non = array("Decentralized Compliance & Opr. Risk","DECISION SUPPORT","HCBP Corporate Banking");
        if(!in_array($head_dept, $arr_dept_non)){
            $this->db->not_like('department', $head_dept);
        }
        $this->db->order_by('department', 'asc');
        $query = $this->db->get('user');
        $depts = $query->result();

        $arr_dept = array(); $i=0;
        foreach($depts as $row){
            $arr_dept[$i]['dept'] = $row->department;
            $arr_dept[$i]['head'] = $this->get_dept_head($row->department);
            $arr_dept[$i]['member'] = $this->get_dept_member($row->department,$group);
            $i++;
        }
        return $arr_dept;
    }

    function get_dept_head($dept){
        $this->db->where("(jabatan LIKE '%Department Head' OR jabatan LIKE 'Direktur')");
        //$this->db->like('jabatan','Direktur');

        $this->db->where('is_employee',1);
        $this->db->where('status','active');
        $this->db->where('department',$dept);
        $query = $this->db->get('user');
        if($query->result()){return $query->result()[0];}
        else{return false;}
    }

    function get_dept_member($dept,$group){
        $this->db->not_like('jabatan','Department Head');
        $this->db->not_like('jabatan','DCOR HEAD');
        $this->db->not_like('jabatan','DS HEAD');
        $this->db->not_like('jabatan','HCBP HEAD');

        $this->db->where('is_employee',1);
        $this->db->where('status','active');
        $this->db->where('group',$group);
        $this->db->where('department',$dept);
        $this->db->order_by('jabatan', 'asc');
        $this->db->order_by('full_name', 'asc');
        $query = $this->db->get('user');
        return $query->result();
    }

    function get_by_group_jabatan($group,$jabatan){
        if($jabatan == "Others"){
            $this->db->not_like('jabatan','Group Head');
            //$this->db->not_like('jabatan','Pj. Group Head');
            $this->db->not_like('jabatan','Department Head');
            //$this->db->not_like('jabatan','Pj. Department Head');
            $this->db->not_like('jabatan','Relationship Manager');
            $this->db->not_like('jabatan','Credit Analyst');
        }
        elseif($jabatan == "Group Head"){
            $this->db->like('jabatan','Group Head');
            //$this->db->or_like('jabatan','Pj. Group Head');
        }
        elseif($jabatan == "Department Head"){
            $this->db->like('jabatan','Department Head');
            //$this->db->or_like('jabatan','Pj. Department Head');
        }
        else{
            $this->db->like('jabatan',$jabatan);
        }
        $this->db->where('is_employee',1);
        $this->db->where('status','active');
        if($group){
            $this->db->where('group',$group);
        }
        $this->db->not_like('department',"Decision Support");
        $this->db->not_like('department',"HCBP Corporate Banking");
        $query = $this->db->get('user');
        return $query->result();
    }

    function get_search($query){
        $this->db->where('is_employee',1);
        $this->db->where("(jabatan LIKE '%$query%' or `group` LIKE '%$query%' or department LIKE '%$query%' or full_name LIKE '%$query%' or nik LIKE '%$query%' or email LIKE '%$query%' or phone_number LIKE '%$query%' or ip_phone LIKE '%$query%' or extension LIKE '%$query%')");

        $this->db->order_by('full_name', 'asc');
        $query = $this->db->get('user');
        return $query->result();
    }

    function get_emp_sum($group){
        $arr_jab = array("Group Head","Department Head", "Relationship Manager", "Credit Analyst","Others");
        $arr_res = array(); $i=0;
        foreach($arr_jab as $jab){
            $arr_res[$i]['jab'] = $jab;
            $arr_res[$i]['emp'] = $this->get_by_group_jabatan($group,$jab);
            $i++;
        }
        return $arr_res;
    }

    function get_my_shortcut(){
        $user = $this->session->userdata('userbapekis');
        $id = $user['id'];
        $this->db->select('user_shortcut.id as idu, user_id, shortcut_id, name, url, icon, description');
        $this->db->join('page','user_shortcut.shortcut_id = page.id');
        $this->db->where('user_id',$id);
        $query = $this->db->get('user_shortcut');
        return $query->result();
    }

    // API
    function get_cbdept_by_cbgroup_id($group_id){
        $this->db->select('cbdept.id as dept_id, cbdept.*, cbgroup.*');
        $this->db->where('cbdept.cbgroup_id',$group_id);
        $this->db->join('cbgroup', 'cbgroup.id = cbdept.cbgroup_id');
        $query = $this->db->get('cbdept');
        return array(
            "results" => $query->result()
        );
    }

    function get_cbdept_by_cbgroup($group_name){
        $this->db->where('is_used',1);
        $this->db->where('group_name',$group_name);
        $this->db->join('cbgroup', 'cbgroup.id = cbdept.cbgroup_id');
        $query = $this->db->get('cbdept');
        return array(
            "results" => $query->result()
        );
    }

    function get_cbgroup_by_buc($buc){
        $this->db->select('cbdept.id as dept_id, cbdept.*, cbgroup.*');
        $this->db->where('cbdept.buc',$buc);
        $this->db->join('cbdept', 'cbgroup.id = cbdept.cbgroup_id');
        $query = $this->db->get('cbgroup');
        return $query->result()[0];
    }

    function get_user_employee_activity(){
		$this->db->where('is_employee',1);
		$this->db->order_by('group');
        $this->db->order_by('full_name');
		$query = $this->db->get('user');
        $res = $query->result();
        $arr = array(); $i=0;
        foreach ($res as $row) {
            $arr[$i]['user'] = $row;
            $arr[$i]['access'] = $this->get_user_access($row->id);
            $i++;
        }
        return $arr;
	}

	function get_user_already_access(){
        $this->db->distinct();
        $this->db->select('full_name, user.id as userid, user.*');
        $this->db->where('is_employee',1);
        $this->db->order_by('group');
        $this->db->order_by('full_name');
        $this->db->join('user','user.id = user_activity.user_id');
        $query = $this->db->get('user_activity');
        $res = $query->result();
        $arr = array(); $i=0;
        foreach ($res as $row) {
            $arr[$i]['user'] = $row;
            $arr[$i]['access'] = $this->get_user_access($row->userid);
            $i++;
        }
        return $arr;
    }

    function get_user_by_position($position,$cbgroup,$cbdept,$user_id,$is_employee,$order_by,$sort){
        $this->db->select('user.*');
        if(!empty($position)) {
            if(is_array($position)){
                $this->db->where_in('user.position',$position);
            }else{
                if($position == "officer") $this->db->where_in('user.position',array("officer","pelaksana"));
                else $this->db->where('user.position',$position);
            }
        }
        if(!empty($cbgroup)) $this->db->where('user.group',$cbgroup);
        if(!empty($cbdept)) $this->db->where('user.department',$cbdept);
        if(!empty($is_employee)) $this->db->where('user.is_employee',$is_employee);

        //echo $position;
        if(empty($position)){
            if(!empty($user_id)) { $this->db->where('user.id',$user_id); }
        }else{
            if(!empty($user_id)) { $this->db->or_where('user.id',$user_id); }
        }
        $this->db->order_by($order_by,$sort);
        $query = $this->db->get('user');
        return $query->result();
    }

    function get_user_access($user_id){
        $this->db->group_by('DAY(datetime),MONTH(datetime),YEAR(datetime)');
        $this->db->where('user_id',$user_id);
		$this->db->order_by('datetime','desc');
        $query = $this->db->get('user_activity');
        return $query->result();
    }

    //UPDATE FUNCTION
    function update_profil($profil,$id){
        $this->db->where('id',$id);
        return $this->db->update('user', $profil);
    }

    function update_user($user){
    	$usr = $this->session->userdata('userbapekis');
        $this->db->where('id', $usr['id']);
        return $this->db->update('user', $user);
    }

    function update_user_general($user,$id){
        $this->db->where('id', $id);
        return $this->db->update('user', $user);
    }

    function update_user_with_username($user,$username){
        $this->db->where('username', $username);
        return $this->db->update('user', $user);
    }

    function update_user_with_password($user,$id,$password){
        $this->db->where('id', $id);
        $this->db->where('password', $password);
        return $this->db->update('user', $user);
    }

    //DELETE FUNCTION
    function enable_user($id){
        $user['status'] = 'active';
        $this->db->where('id',$id);
        $query =  $this->db->update('user', $user);
        return array(
            "value" => $query
        );
    }

    function disable_user($id){
        $user['status'] = 'nonactive';
        $this->db->where('id',$id);
        $query =  $this->db->update('user', $user);
        return array(
            "value" => $query
        );
    }

    function delete_user($id){
        $this->db->where('id',$id);
        $query = $this->db->delete('user');
        return array(
            "value" => $query
        );
    }

    function reset_password($username){
        $user['password']= md5($username);
        $this->db->where('username',$username);
        $query = $this->db->update('user',$user);
        return array(
            "value" => $query
        );
    }

    function is_nik_exist($nik){
        $this->db->where('nik',$nik);
        $result = $this->db->get('user');
        if($result->num_rows>0){
            return true;
        }else{
            return false;
        }
    }

    function is_username_exist($username){
        $this->db->where('nik',$username);
        $result = $this->db->get('user');
        if($result->num_rows>0){
            return true;
        }else{
            return false;
        }
    }

	function shutdown_status(){
		$this->db->where('is_employee = 1');
        $this->db->where("position <> 'DIRECTOR'");
        $this->db->where("sumber <> 'TAD'");
        $this->db->where("group NOT LIKE  'DECISION SUPPORT%' AND `group` NOT LIKE  'HCBP Corporate Banking%' AND `group` NOT LIKE  'DCOR%'");
		$user['status'] = 'nonactive';
        return $this->db->update('user', $user);
	}

    function shutdown_status_gvi(){
        //$this->db->where('is_employee = 1');
        $this->db->where("directorate = 'GOVERNMENT & INSTITUTIONAL'");
        $this->db->where("group NOT LIKE  'DECISION SUPPORT%' AND `group` NOT LIKE  'HCBP Corporate Banking%'");
        $user['status'] = 'nonactive';
        return $this->db->update('user', $user);
    }

    function get_user_search($query,$arr_where){
        $this->db->select("*");
        $this->db->where("full_name LIKE '%$query%'");
        $this->db->where("status","active");
        $this->db->where("id <> ",11);
        $this->db->order_by('full_name','asc');
        $query = $this->db->get('user');
        
        $query = $query->result();
        return $query;
    }

    function get_user_activity_search($query,$arr_where){
        $this->db->select("distinct(activity)");
        $this->db->where("activity LIKE '%$query%'");
        $this->db->where("user_id <> ",11);


        $this->db->not_like("activity","Access Meeting Room, ","after");
        $this->db->not_like("activity","Access Commitment Monitoring, ","after");
        $this->db->not_like("activity","Access Calendar of Event, ","after");
        $this->db->not_like("activity","Access Account Plan News - , ","after");
        $this->db->not_like("activity","Comment, ","after");
        




        $this->db->order_by('activity','asc');
        $query = $this->db->get('user_activity');
        
        $query = $query->result();
        return $query;
    }


    function get_user_directorate($arr_where){
        $user = $this->session->userdata('userbapekis');
        if($arr_where){
            $this->db->where($arr_where);
        }
        $this->db->like("directorate",$user['directorate']);
        $this->db->where("status","active");
        $this->db->where("id <> ",11);
        $this->db->order_by('full_name','asc');
        $query = $this->db->get('user');
        
        return $query->result();
    }

    function get_user_all($arr_where){
        $user = $this->session->userdata('userbapekis');
        if($arr_where){
            $this->db->where($arr_where);
        }
        //$this->db->like("directorate",$user['directorate']);
        //$this->db->where("status","active");
        $this->db->where("id <> ",11);
        $this->db->order_by('full_name','asc');
        $query = $this->db->get('user');
        
        return $query->result();
    }


    /********************************/
    /********************************/
    /*******                  *******/
    /******* PARSING FUNCTION *******/
    /*******                  *******/
    /********************************/
    /********************************/

    // parser penilaian agunan
    public function parse_database_employee_parse($file_address,$date_for){
        ini_set('memory_limit','512M');
        
        $exel = $this->mfiles_upload->read_excel_with_sheet_name($file_address, "CB");
        $arrres = array(); $s=0;
        $header = array();
        $arr_row_res['valid_row'] = 0;
        $arr_row_res['invalid_row'] = 0;
        $user = $this->session->userdata('userbapekis');

        $this->muser->shutdown_status();

        for ($col = 0; $col < $exel['col']; ++$col) {
            $header[$col] = $exel['wrksheet']->getCellByColumnAndRow($col, 4)->getValue();
        }
        
        for ($row = 5; $row <= $exel['row']; ++$row) {
            $data = "";
            for ($col = 0; $col < $exel['col']; ++$col) {
                $arrres[$row][$col] = $exel['wrksheet']->getCellByColumnAndRow($col, $row)->getValue();
            }

            $data['nik'] = $arrres[$row][array_search("NIP", $header)];
            $data['status'] = "active";


            $arr_rm_jab = array("Senior Relationship Manager","Relationship Manager","Junior Relationship Manager", "Junior Relationship Manager (OJT)", "Relationship Manager (MYLead)", "SRM", "RM", "JRM");
            $arr_ca_jab = array("Senior Credit Analyst","Credit Analyst","Junior Credit Analyst", "Junior Credit Analyst (OJT)", "SCA", "CA", "JCA");

            $jabatan = $arrres[$row][array_search("Jabatan Pegawai", $header)];
            if($jabatan == "GH") $data['jabatan'] = "Group Head";
            elseif($jabatan == "Pj. GH") $data['jabatan'] = "Pj. Group Head";
            elseif($jabatan == "DH") $data['jabatan'] = "Department Head";
            elseif($jabatan == "Pj. DH") $data['jabatan'] = "Pj. Department Head";
            elseif($jabatan == "TL") $data['jabatan'] = "Team Leader";
            elseif($jabatan == "SH") $data['jabatan'] = "Section Head";
            elseif($jabatan == "LO") $data['jabatan'] = "Legal Officer";
            elseif(in_array($jabatan, $arr_rm_jab)) $data['jabatan'] = "Relationship Manager";
            elseif(in_array($jabatan, $arr_ca_jab)) $data['jabatan'] = "Credit Analyst";
            elseif($jabatan == "ERO") $data['jabatan'] = "Executive Relationship Officer";
            elseif($jabatan == "EBO - B") $data['jabatan'] = "Executive Business Officer - B";
            else $data['jabatan'] = $jabatan;

            $arr_gh = array('Group Head','Pj. Group Head','WSA Head','Executive Business Officer - B','Executive Relationship Officer');    
            $arr_dh = array('Department Head','Pj. Department Head', 'DCOR HEAD');

            if(in_array($data['jabatan'], $arr_gh)){$data['position'] = "Group Head";}
            elseif(in_array($data['jabatan'], $arr_dh)){$data['position'] = "Department Head";}
            elseif($data['jabatan']=="Pelaksana"){$data['position'] = "Pelaksana";}
            elseif($data['jabatan']=="Sekretaris"){$data['position'] = "Sekretaris";}
            else{$data['position'] = "Officer";}

            $data['position'] = strtoupper($data['position']);

            $data['job_title'] = $jabatan;

            $data['group'] = strtoupper(get_group($arrres[$row][array_search("Group", $header)]));
            $data['department'] = strtoupper($arrres[$row][array_search("Unit Kerja/ Department", $header)]);
            $data['directorate'] = "CORPORATE BANKING";

            $data['priority'] = get_position_priority($data['position']);
            $data['priority_dir'] = 1;

            //$data['tmt_kerja'] = date("Y-m-d",excelDateToDate($arrres[$row][array_search("TMT KERJA", $header)]));
            $data['dob'] = date("Y-m-d",excelDateToDate($arrres[$row][array_search("Tanggal Lahir", $header)]));
            
            $data['is_employee'] = 1;

            /*$data['sumber'] = (array_search("SUMBER", $header)) ? $arrres[$row][array_search("SUMBER", $header)] : "";      
            $data['gender'] = $arrres[$row][array_search("GENDER", $header)];
            $data['agama'] = $arrres[$row][array_search("AGAMA", $header)];
            $data['strata'] = $arrres[$row][array_search("STRATA", $header)];
            $data['jurusan'] = $arrres[$row][array_search("JURUSAN", $header)];
            $data['universitas'] = $arrres[$row][array_search("UNIVERSITAS", $header)];*/

            //$data['tahun_lulus'] = $arrres[$row][array_search("NAMA", $header)];

            $data['updated_by'] = $user['id'];
            $data['updated_at'] = date("Y-m-d H:i:s");

            if($data['nik']!=NULL) {
                $profile = $this->muser->get_user_by_nik($data['nik']);
                if($profile){
                    //print_r($data);
                    //echo "<br>";
                    $this->mfiles_upload->update_db($data,$profile->id,'user');
                }else{
                    $data['created_at'] = date('Y-m-d H:i:s');
                    $data['created_by'] = $this->session->userdata('userbapekis')['id'];

                    $data['username'] = $arrres[$row][array_search("NIP", $header)];
                    $data['password'] = md5($arrres[$row][array_search("NIP", $header)]);
                    $data['full_name'] = $arrres[$row][array_search("NAMA", $header)];

                    //$data['extension'] = $arrres[$row][array_search("EXT", $header)];
                    //$data['ip_phone'] = $arrres[$row][array_search("IP PHONE", $header)];
                    $data['phone_number'] = $arrres[$row][array_search("Nomor HP", $header)];
                    $data['email'] = $arrres[$row][array_search("Email", $header)];
                    
                    //print_r($data);
                    //echo "<br>";
                    $data['role'] = "GENERAL VIEWER";
                    $this->mfiles_upload->insert_db($data,'user');

                }
                //echo $data['full_name']."<br>";
            }
        }
        return $arr_row_res;

    }

}
