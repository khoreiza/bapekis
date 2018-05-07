<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');


class Sharing extends CI_Controller {
    
    public function __construct() {
        parent::__construct();
        $this->load->model(array('muser','mfiles_upload','mmysharing','muser_activity'));
		$session = $this->session->userdata('userbapekis');
        
        if(!$session){
            $url = current_url();
            $this->session->set_userdata('last_page_open',$url);
            redirect('user/login');
        }
        //elseif(!$session['is_employee'] && !is_user_role($session,"PERFORMANCE VIEWER") && $session['position']!="Director"){redirect('');}
    }
    /**
     * Method for page (public)
     */
     
    public function index()
    {
        $session = $this->session->userdata('userbapekis');
        $data['title'] = "Internal Sharing - CBIC";
        $this->muser->insert_user_access_log("Access Internal Sharing");

        $data['num_sharings'] = 20;//count($this->mfiles_upload->get_db("id","desc","mysharing",array('description !=' => "null"),"",""));
        
        $data['sharings'] = $this->mmysharing->get_detil("all",5,0,"");
        $data['first_time'] = true;
        $data['list_of_sharing'] = $this->load->view('sharing/component/index/_sharings',$data,TRUE);


        /************* GET CATEGORIES SECTION WITH PICTURE *************
        $join[0] = array('table' => 'category','in' => 'mysharing.category_id = category.id', 'how' => 'left');
        
        $files_upload_table_sharing = "(SELECT `files_upload`.full_url,ownership_id from files_upload where modul = 'my sharing' and sub_modul = 'banner') as files_upload";
        $join[1] = array('table' => $files_upload_table_sharing,'in' => 'mysharing.id = files_upload.ownership_id', 'how' => 'left');

        $table_max_id = "(SELECT max(mysharing.id) as max_id FROM `mysharing` GROUP BY category_id) as s";
        $join[2] = array('table' => $table_max_id, 'in' => 's.max_id = mysharing.id');

        $select = "mysharing.*, category.category, files_upload.full_url";
        $data['categories'] = $this->mfiles_upload->get_db_join('mysharing.id','desc','mysharing','',$select,'','',$join);*/



        /****** CATEGORY *******/
        $select_cat = 'category, count(category_id) as count, category_id';
        //$arr_where_cat = array('modul' => 'market', 'sub_modul' => $data['page']);
        $join[0] = array("table" => "category", "in" => "mysharing.category_id = category.id", "how" => "left");
        $data['categories'] = $this->mfiles_upload->get_db_join("category","asc","mysharing",'',$select_cat,"",'category_id',$join);
        /************* END of GET CATEGORIES SECTION *************/
        

        $data['header'] = $this->load->view('admin/shared/first/header','',TRUE);   
        $data['footer'] = $this->load->view('admin/shared/first/footer','',TRUE);
        $data['content'] = $this->load->view('sharing/index',$data,TRUE);

        $this->load->view('admin/shared/front',$data);
        
    }

    public function reload_category_sharings(){
        $offset = $this->input->get('offset');

        $data['category'] = $this->input->get('category');

        $data['sharings'] = $this->mmysharing->get_detil("category",12,$offset,$data['category']);
        if($data['sharings']){
            $data['list_sharings'] = $this->load->view('sharing/component/index/_sharings',$data,TRUE);
            $json['html'] = $this->load->view('sharing/component/index/_category',$data,TRUE);
            $json['status'] = 1;
        }else{
            $json['status'] = 0;
        }
        $this->output->set_content_type('application/json')
                         ->set_output(json_encode($json));

    }

    public function reload_next_sharings(){
        $offset = $this->input->get('offset');
        $type = $this->input->get('type');

        $limit = 14;

        if($type == "first_time"){
            //$limit = 5;
            $data['first_time'] = true;
            $offset = 0;
        }

        $data['sharings'] = $this->mmysharing->get_detil("all",$limit,$offset,$type);
        if($data['sharings']){
            $json['html'] = $this->load->view('sharing/component/index/_sharings',$data,TRUE);
            $json['status'] = 1;
        }else{
            $json['status'] = 0;
        }
        $this->output->set_content_type('application/json')
                         ->set_output(json_encode($json));

    }

    public function filter_search_content(){
        $search = $this->input->get('search');
        $type = $this->input->get('type');
        
        if($search) $data['sharings'] = $this->mmysharing->get_detil_search($search,$type);
        else{
            $data['first_time'] = true;
            $data['sharings'] = $this->mmysharing->get_detil("all",5,0,$type);
        }
        
        $json['status'] = 1;
        $json['html'] = $this->load->view('mysharing/component/index/_sharings',$data,TRUE);
        
        $this->output->set_content_type('application/json')
                     ->set_output(json_encode($json));
    }

    public function internal()
    {
        redirect('mysharing');
    }
    
    public function show_sharing_form(){
        $id = $this->input->get('id');
        $user = $this->session->userdata('userbapekis');
        if($id){
            $data['mysharing'] = $this->mmysharing->get_by_id_with_atc($id);
            $user_ex = explode(';',$data['mysharing']['mysharing']->user_allowed);
            if($user_ex){
                $this->db->where_in('id', $user_ex);
                $data['arr_user_res'] = $this->mfiles_upload->get_db("full_name",'asc','user','',"","");
            }

            $photo = $this->mfiles_upload->get_files_upload_by_ownership_id('my sharing','banner',$id);
            if($photo) $data['photo']=$photo[0];
            //Ambil data sharing dari db   
        }

        //$join[0] = array('table' => 'cbdirectorate','in' => 'cbdirectorate.id = cbgroup.cbdirectorate_id');
        //$data['arr_group'] = $this->mfiles_upload->get_db_join("group_name asc, sort",'asc','cbgroup',array('directorate' => $user['directorate']),"cbgroup.*","","",$join);
        //$data['arr_position'] = $this->mfiles_upload->get_db_group_by("priority",'asc','user',array('directorate' => $user['directorate']),"","","position");

        $data['categories'] = $this->mfiles_upload->get_db('category','asc','category',array('menu' => 'mysharing'),'','');

        $data['popup_content'] = $this->load->view('sharing/component/index/_sharing_form',$data,TRUE);
        $data['popup_title'] = "Form Internal Sharing"; 
        $data['popup_width'] = "800px";

        $data['status'] = 1;
        $data['html'] = $this->load->view('admin/shared/component/_popup_page', $data,TRUE);

        $this->output->set_content_type('application/json')
                         ->set_output(json_encode($data));
    }
    
    public function show_detail(){
        $session = $this->session->userdata('userbapekis');
        $id = $this->input->get('id'); $data['id'] = $id;
        $title=$this->mmysharing->get_by_id($id)->title;
        $data['sharings'] = $this->mmysharing->get_detil_by_id($id,"all",$session['jabatan'],$session['group']);
        $this->muser->insert_user_access_log("Access My Sharing '$title'");

        $page = "Access My Sharing '$title'";
        $data['views'] = $this->muser_activity->get_page_access("all",date("Y-m-d"),'full_name','user_activity.id','desc','',$page, '','');

        /*Comment Section*/

        $data['kind'] = "id"; $data['ownership'] = "mysharing";
        $join[0] = array('table' => 'user', 'in' => "user.id = comment.user_id");
        $arr_where = array('ownership_type' => 'mysharing', 'ownership_id' => $id); 
        $data['comments'] = $this->mfiles_upload->get_db_join('comment.id','desc','comment',$arr_where,'*, comment.id as comment_id','','',$join);
        $data['comment_list'] = $this->load->view('comment/_list',$data,TRUE);
        $data['comment_view'] = $this->load->view('comment/_form',$data,TRUE);

        $json['html'] = $this->load->view('sharing/component/_show_detail',$data,TRUE);
        $json['status'] = 1;
        $this->output->set_content_type('application/json')
                         ->set_output(json_encode($json));
    }

    public function submit(){
      	$id = $this->uri->segment(3);
      	$user = $this->session->userdata('userbapekis');
        
        $arr = array('title','category_id','description');
        $data = $this->mfiles_upload->get_form_element($arr);

        $data['date'] = DateTime::createFromFormat('j M y', $this->input->post('date'))->format('Y-m-d');


        /********************************* SHARING PREVILLAGE ***********************************
        $data['user_allowed'] = "";
        if($this->input->post('user_allowed')){
            foreach($this->input->post('user_allowed') as $ua){
                if(!$data['user_allowed']) $data['user_allowed'] = ";";
                $data['user_allowed'] = $data['user_allowed'].$ua.";";
            }
        }

        $data['group_allowed'] = "";
        if($this->input->post('group_allowed')){
            foreach($this->input->post('group_allowed') as $ga){
                if(!$data['group_allowed']) $data['group_allowed'] = ";";
                $data['group_allowed'] = $data['group_allowed'].$ga.";";
            }
        }

        $data['position_allowed'] = "";
        if($this->input->post('position_allowed')){
            foreach($this->input->post('position_allowed') as $pa){
                if(!$data['position_allowed']) $data['position_allowed'] = ";";
                $data['position_allowed'] = $data['position_allowed'].$pa.";";
            }
        }
        /********************************* END OF SHARING PREVILLAGE ***********************************/

        $data['updated_by'] = $user['id'];
        $data['updated_at'] = date("Y-m-d H:i");

        if(!$id){
            $data['created_at'] = date('Y-m-d H:i:s');
            $data['created_by'] = $this->session->userdata('userbapekis')['id'];
            
            $sharing_id = $this->mfiles_upload->insert_db($data,'mysharing');
            $this->muser->insert_user_access_log("Access Internal Sharing, Add New Sharing ".$data['title']);

            /***************** INSERT UPDATES MySharing *****************/
            $updates['user_id'] = $user['id'];
            $updates['date'] = date("Y-m-d H:i:s");
            $updates['modul'] = "Internal Information";
            $updates['sub_modul'] = "Internal Sharing";
            $updates['ownership_id'] = $sharing_id;
            
            /*$updates['user_allowed'] = $data['user_allowed'];
            $updates['group_allowed'] = $data['group_allowed'];
            $updates['position_allowed'] = $data['position_allowed'];
            //$this->mupdates->insert($updates);
            /***************** END OF INSERT UPDATES *****************/
        }
        else{
            $this->mfiles_upload->update_db($data,$id,'mysharing');
            $sharing_id = $id;
            $this->muser->insert_user_access_log("Access Internal Sharing, Edit Sharing Data for ".$data['title']);
        }

        /********************************* FILES UPLOAD ***********************************/
        $upload_path = "mysharing/".$sharing_id."/";
        /*** Attachment ***/
        if(isset($_FILES['attachment']) && !($_FILES['attachment']['error'] == UPLOAD_ERR_NO_FILE)){
            /*Upload */ 
            $file = $this->mfiles_upload->upload_files("attachment",$upload_path,'my sharing','attachment',$sharing_id,true,false);
        }

        /*** Photo Gallery ***/
        //$this->upload->reset_multi_upload_data();
        if(isset($_FILES['photo']) && !($_FILES['photo']['error'] == UPLOAD_ERR_NO_FILE)){
            /*Upload */ 
            $file = $this->mfiles_upload->upload_files("photo",$upload_path,'my sharing','gallery',$sharing_id,true,true);
        }

        /*** Photo Banner ***/
        //$this->upload->reset_multi_upload_data();
        if(isset($_FILES['img']) && !($_FILES['img']['error'] == UPLOAD_ERR_NO_FILE)){
            $this->mfiles_upload->delete_with_files_ownership($sharing_id,'my sharing','banner');
            /*Upload */ 
            $file = $this->mfiles_upload->upload_file("img",$upload_path,'my sharing','banner',$sharing_id,true,true);
        }
        /********************************* END OF FILES UPLOAD ***********************************/


        $json['sharing_id'] = $sharing_id;
        $json['status'] = 1;
        $this->output->set_content_type('application/json')
                         ->set_output(json_encode($json));
        
     }
    
    public function delete_mysharing(){
    	$id = $this->input->get('id');
    	$type = $this->input->get('type');
        //$sub_modul = $this->input->get('submodul'); 
    	if($id){
            $this->mmysharing->delete_mysharing($id);
            
            $this->mfiles_upload->delete_with_files_ownership($id,'my sharing','my sharing');
            $this->mfiles_upload->delete_with_files_ownership($id,'my sharing','img');
            //$this->mupdates->delete_with_ownership_id("Internal Sharing",$id);
            
            $json['status'] = true;
        }
        else
        {
             $json['status'] = false;
        }
        $this->output->set_content_type('application/json')
                         ->set_output(json_encode($json));
    }
}
