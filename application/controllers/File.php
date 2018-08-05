<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class File extends CI_Controller {

	/**
	 * Index Page for this controller.
	 *
	 * Maps to the following URL
	 * 		http://example.com/index.php/welcome
	 *	- or -  
	 * 		http://example.com/index.php/welcome/index
	 *	- or -
	 * Since this controller is set as the default controller in 
	 * config/routes.php, it's displayed at http://example.com/
	 *
	 * So any other public methods not prefixed with an underscore will
	 * map to /index.php/welcome/<method_name>
	 * @see http://codeigniter.com/user_guide/general/urls.html
	 */
	public function __construct() {
        parent::__construct();
        $this->load->model(array('mfile','mfiles_upload','mnews','mupdates','muser_activity'));

    }

    public function see_all_file(){
        $data['modul'] = $this->input->post('modul');
        $data['submodul'] = $this->input->post('submodul');
        $data['ownership_id'] = $this->input->post('ownership_id');
        $arr_where = array();
        if($data['modul']){$arr_where['modul'] = $data['modul'];}
        if($data['submodul']){$arr_where['sub_modul'] = $data['submodul'];}
        if($data['ownership_id']){$arr_where['ownership_id'] = $data['ownership_id'];}
        
        /*ALL Files*/
        $arr_order = array('created_at');
        $arr_how = array('desc');
        $data['files'] = $this->mfiles_upload->get_db($arr_order,$arr_how,'files_upload',$arr_where,'','');

        $json['html'] = $this->load->view('files_upload/_all_files',$data,TRUE);
        $json['status'] = 1;
        $this->output->set_content_type('application/json')
                         ->set_output(json_encode($json));
    }

    public function delete_file(){
        $id = $this->input->get('id');
        
        if($id){
            $file = $this->mfiles_upload->get_detil_files_by_id($id);
            $arr_where = array("sub_modul" => get_code_sub_modul($file->modul), "subsub_modul" => $file->sub_modul);
            $this->mupdates->delete_with_ownership_id_where($arr_where,$id);
            $this->mfiles_upload->delete_with_files($id);
            
        }
         
        $result = array('status' => true, 'error' => false, 'file_id' => $id);
        $this->output
        ->set_content_type('application/json')
        ->set_output(json_encode($result));
    }
    
    public function delete_file_only(){
        $id = $this->input->get('id');
        
        if($id){
            $file = $this->mfiles_upload->get_detil_files_by_id($id);
            unlink($file->full_url);
            $program['full_url']=null;
            $program['ext']=null;
            $program['file_name']=null;
            $program['title']=null;
            $this->mfiles_upload->update_files_upload($program,$id);
        }
         
        $result = array('status' => true, 'error' => false, 'file_id' => $id);
        $this->output
        ->set_content_type('application/json')
        ->set_output(json_encode($result));
    }

    public function delete_file_only_with_db(){
        $id = $this->input->get('id');
        
        if($id){
            $file = $this->mfiles_upload->get_detil_files_by_id($id);
            unlink($file->full_url);
            $this->mfiles_upload->delete_files_upload($id);
        }
         
        $result = array('status' => true, 'error' => false, 'file_id' => $id);
        $this->output
        ->set_content_type('application/json')
        ->set_output(json_encode($result));
    }
    
    public function delete_photo_market(){
        $id = $this->input->get('id');
        
        if($id){
            $name=$this->mnews->get_detil_news_by_id($id);
            unlink("assets/uploads/market/photos/".$name->photo);
            $program['photo']='';
            $this->mnews->update_news($program,$id);
        }
         
        $result = array('status' => true, 'error' => false, 'file_id' => $id);
        $this->output
        ->set_content_type('application/json')
        ->set_output(json_encode($result));
    }

    public function list_download(){
        echo "<!DOCTYPE html><html xmlns='http://www.w3.org/1999/xhtml' lang='en'><body>";
        echo "<head><title>List File</title></head><body>";

        $file_uploads = $this->mfile->get_file_upload();
        foreach($file_uploads as $file_upload){
            $key =  $this->create_key();
            $paths = explode(",",$file_upload->path_file);
            $filename = end($paths);

            $temp_download_link=[];
            $temp_download_link['file_id'] = $file_upload->id;
            $temp_download_link['key'] = $key;
            $temp_download_link['expired_date'] = strtotime('tomorrow');;
            $temp_download_link['is_downloaded'] = 0;

            $this->mfile->insert_temp_download_link($temp_download_link);

            echo "<a href=".base_url().'file/download?key='.$key.">".$filename."</a>";
            echo "<br/>";
        }
    }

    public function download_file(){
        $id = $this->uri->segment(3);
        $file = $this->mfiles_upload->get_detil_files_by_id($id);
        $this->muser->insert_user_access_log("Download File ".$file->modul." ".$file->sub_modul." '".$file->title."'");
        redirect ($file->full_url);
    }
    
    public function download(){
        $root_directory="assets";
        $key = $this->input->get('key');
        if(!empty($key)){
            //check the DB for the key
            $result = $this->mfile->get_temp_download_link_with_key($key);
            if(!empty($result)){
                //check that the download time hasnt expired
                if($result->expired_date>=time()){
                    if($result->is_downloaded==0){
                        $absolute_path = $root_directory."/".$result->path_file;
                        if(file_exists($absolute_path)){
                            
                            //get the file content
                            $str_file = file_get_contents($absolute_path);

                            $paths = explode(",",$result->path_file);
                            $filename = end($paths);

                            //set the headers to force a download
                            header("Content-type: application/force-download");
                            header("Content-Disposition: attachment; filename=\"".str_replace(" ", "_", $filename)."\"");
                            
                            //echo the file to the user
                            echo $str_file;
                            
                            $temp_download_link['is_downloaded']=true;
                            $this->mfile->update_temp_download_link_with_key($key, $temp_download_link);
                            
                            exit;
                            
                        }else{
                            echo "We couldn't find the file to download.";
                        }
                    }else{
                        //this file has already been downloaded and multiple downloads are not allowed
                        echo "This file has already been downloaded.";
                    }
                }else{
                    //this download has passed its expiry date
                    echo "This download has expired.";
                }
            }else{
                //the download key given didnt match anything in the DB
                echo "No file was found to download.";
            }
        }else{
            //No download key wa provided to this script
            echo "No download key was provided. Please return to the previous page and try again.";
        }
    }

    private function create_key(){
        //create a random key
        $str_key = md5(md5(microtime()));
        
        //check to make sure this key isnt already in use
        $res_check = $this->mfile->get_temp_download_link_with_key($str_key);
        if(!empty($res_check)){
            //key already in use
            return create_key();
        }else{
            //key is OK
            return $str_key;
        }
    }

    private function insert_temp_download_link(){

    }

    public function show_news_detail(){
        $id = $this->input->get('id'); $data['id'] = $id;
        $data['news'] = $this->mnews->get_detil_news_by_id($id);

        $title = $data['news']->title;

        if($data['news']){
            //$this->muser->insert_user_access_log("Access ".get_long_text($data['news']->modul,100)." News - $title - $id");

            $data['attachments'] = $this->mfiles_upload->get_files_upload_by_ownership_id($data['news']->modul, '', $id);
            $data['galleries'] = $this->mfiles_upload->get_files_upload_by_ownership_id("gallery", $data['news']->modul, $id);
            $data['photo'] = $this->mfiles_upload->get_files_upload_by_ownership_id("photo", $data['news']->modul, $id);

            /*** Comment Section ***/
            $data['kind'] = "id"; $data['ownership'] = "news";
            $join[0] = array('table' => 'user', 'in' => "user.id = comment.user_id");
            $arr_where = array('ownership_type' => 'news', 'ownership_id' => $id); 
            $data['comments'] = $this->mfiles_upload->get_db_join('comment.id','desc','comment',$arr_where,'*, comment.id as comment_id','','',$join);
            $data['comment_list'] = $this->load->view('comment/_list',$data,TRUE);
            $data['comment_view'] = $this->load->view('comment/_form',$data,TRUE);
            /*** End Comment Section ***/

            $page = "Access ".get_long_text($data['news']->modul,100)." News - $title - $id";
            $data['views'] = $this->muser_activity->get_page_access("all",date("Y-m-d"),'full_name','user_activity.id','desc','',$page, '','');

            $data['popup_content'] = $this->load->view('files_upload/component/_news_detail', $data,TRUE);
            $data['popup_title'] = get_long_text($data['news']->modul,50);
            $data['popup_title'] .= ($data['news']->sub_modul) ? " - ".get_long_text($data['news']->sub_modul,50) : ""; 
            $data['popup_width'] = "1200px";

            $json['html'] = $this->load->view('admin/shared/component/_popup_page',$data,TRUE);     
            $json['status'] = 1;
            
        }else{
            $json['status'] = 0;
        }
        $this->output->set_content_type('application/json')
                     ->set_output(json_encode($json));
    }
    
    public function show_input_form(){
        $id = $this->input->get('id');
        $data['page'] = $this->input->get('page');
        $data['submodul'] = $this->input->get('submodul');
        $data['ownership_id'] = $this->input->get('ownership_id');

        if($data['page']=='compliance'){
            $text='Compliance';
        }
        else if($data['page']=='market'){
            $text = $data['submodul'];
            $data['categories'] = $this->mfiles_upload->get_db('category','asc','category',array('menu' => 'market','submodul' => $data['submodul']),'','');
        }
        else if($data['page']=='hr'){
            $text='Human Resource';
        }
        else if($data['page']=='account plan'){
            $text='Account Plan';
        }
        else if($data['page']=='anchor update'){
            $text = "Anchor Update";
        }
        else if($data['page']=='legal news'){
            $text = "Legal";
        }
        else if($data['page']=='ssf news'){
            $text = "SSF";
        }
        else if($data['page'] == 'calendar news'){
            $text = "Event";   
        }
        else if($data['page'] == 'df news'){
            $text = "Distribution Financing";   
        }
        else if($data['page']=='pipeline news'){
            $text = "Pipeline";
        }
        else if($data['page']=='credit pipeline news'){
            $text = "Credit Pipeline";
        }
        else if($data['page']=='fund pipeline news'){
            $text = "Dana Pipeline";
        }
        else if($data['page']=='rkk news'){
            $text = "RKK";
        }
        else if($data['page']=='competition'){
            $text = $data['submodul'];
        }
        else{
            $pages = explode(" --- ", $data['page']);
            if($pages[0] == "anchor update"){
                $data['page'] = "anchor update"; $text = "Anchor Update";
                $data['custgroup_name'] = $pages[1];
                $data['submodul'] = $data['custgroup_name'];
            } 
        }
        if($id){
            $data['news'] = $this->mnews->get_detil_news_by_id($id);
            $data['attach']=$this->mfiles_upload->get_files_upload_by_ownership_id($data['page'],'',$id);
            $data['galleries']=$this->mfiles_upload->get_files_upload_by_ownership_id('gallery',$data['page'],$id);
            
            if($data['page']=='anchor update') $data['custgroup_name'] = $data['news']->sub_modul;

            $photo = $this->mfiles_upload->get_files_upload_by_ownership_id('photo',$data['page'],$id);
            if($photo) $data['photo']=$photo[0];

        }

        
        $data['popup_content'] = $this->load->view('files_upload/component/form/_form_input', $data,TRUE);
        $data['popup_title'] = "Form $text News";
        
        
        $data['popup_width'] = "830px";

        $json['html'] = $this->load->view('admin/shared/component/_popup_page',$data,TRUE);
        $json['status'] = 1;
        $this->output->set_content_type('application/json')
                         ->set_output(json_encode($json));
    }
    
    public function show_form_files(){
        $data['modul'] = $this->input->get('file_modul');
        $data['submodul'] = $this->input->get('file_submodul');
        $data['ownership_id'] = $this->input->get('ownership_id');
        $id = $this->input->get('id');
       
        if($id){
			$data['publication'] = $this->mfiles_upload->get_files_upload_by_id($id);
            if($data['publication']->ownership_id) $data['ownership_id'] = $data['publication']->ownership_id;
		}
        
        $data['popup_content'] = $this->load->view('files_upload/component/form/_form_input_files', $data,TRUE);
        $data['popup_title'] = "Upload File - ".get_long_text($data['modul'],100); 
        $data['popup_subtitle'] = $data['submodul']; 
        $data['popup_width'] = "800px";

        $json['html'] = $this->load->view('admin/shared/component/_popup_page',$data,TRUE);
        $json['status'] = 1;
        $this->output->set_content_type('application/json')
                         ->set_output(json_encode($json));
    }
    
    public function submit_file(){
        $id = $this->uri->segment(3);
      	$user = $this->session->userdata('userbapekis');
		$page = $this->input->post('modul');
		$sub = $this->input->post('submodul');
		$program['description'] = $this->input->post('description');
        $program['ownership_id'] = $this->input->post('ownership_id');
        
        if($this->input->post('created')){$created = DateTime::createFromFormat('m/d/Y', $this->input->post('created'));
		$program['created'] = $created->format('Y-m-d')." ".date("H:i:s");}else{$program['created'] =  date("Y-m-d H:i:s");}
		
        $program['user_allowed'] = "";
		foreach($this->input->post('user_allowed') as $ua){
			$program['user_allowed'] = $program['user_allowed'].$ua.";";
		}
        $program['segment_allowed'] = "";
        $segment_allowed = $this->input->post('segment_allowed');
        if($segment_allowed){
            foreach($segment_allowed as $sa){
                $program['segment_allowed'] .= $sa.";";
            }
        }
        if($this->input->post('title')){
            $program['title'] = $this->input->post('title');
        }
        
        /*Upload attach */ 
        if($page=='compliance'){
            $upload_path = "assets/uploads/compliance/publications/".$sub."/";
        }
        elseif($page=='market'){
            $upload_path = "assets/uploads/market/publications/".$sub."/";
        }
        elseif($page =='hr'){
            $upload_path = "assets/uploads/hr/".$sub."/";
        }
        elseif($page =='account plan'){
            $anchor_name = explode(" - ", $sub);
            if(isset($anchor_name[1])){
                $anchor_name = $anchor_name[1];
                $this->db->like("custgroup_name",$anchor_name);
                $anchor = $this->mfiles_upload->get_db('custgroup_name','asc','custgroup','','','');
                if($anchor) $anchor_id = $anchor[0]->id;
                $upload_path = "assets/uploads/account_plan/".$anchor_id."/".$sub."/";
            }
            else{
                $upload_path = "assets/uploads/account_plan/summary/".$sub."/";
            }
            
        }
        else{
            $upload_path = "assets/uploads/".$page."/publications/";
        }


		if (!is_dir($upload_path)) {
			mkdir($upload_path, 0777, true);
		}
		$config = array(
			'upload_path' => $upload_path,
			'allowed_types' => "*",
			'overwrite' => TRUE,
			'max_size' => "2048000000",
		);
		$this->load->library('upload', $config);
		if($id){
            $this->mfiles_upload->update_files_upload($program,$id);
        }
        else{
            if($this->upload->do_multi_upload("attachment"))
            {
                $attachments = $this->upload->get_multi_upload_data("attachment");
                foreach($attachments as $atch){
                    $file_id = $this->mfiles_upload->insert_files_upload_with_full_url_with_param($upload_path,$page,$sub, $atch, $program['ownership_id'],$program);
                    
                    
                }
            }
            else{
                $result = array('status' => 0, 'error' => $this->upload->display_errors());
            }   
        }

        /***** REFRESH LIST ******/
        $files_upload['modul'] = $page;
        $files_upload['submodul'] = $sub;
        $files_upload['ownership_id'] = $program['ownership_id'];
        $files_upload['count_file'] = 3;

        $arr_where_files = array("ownership_id" => $program['ownership_id']);
        $files_upload['publications'] = $this->mfiles_upload->get_publication_files_where($files_upload['modul'],$files_upload['submodul'],$files_upload['count_file'], $arr_where_files);

        //$files_upload['publications'] = $this->mfiles_upload->get_publication_files($files_upload['modul'],$files_upload['submodul'],$files_upload['count_file']);
        $submodul_div = "submodul_div_".str_replace(" ", "_", $sub);
        $sub_modul_files = $this->load->view('files_upload/component/list_files/_submodul_files', $files_upload,TRUE);

        $result = array('status' => 1,'result_div' => $submodul_div, 'html' => $sub_modul_files);
        
        $this->output
          ->set_content_type('application/json')
          ->set_output(json_encode($result));
    }
    
    public function submit(){
      	$id = $this->uri->segment(3);
      	$user = $this->session->userdata('userbapekis');
		$page = $this->input->post('page');
        
        $arr = array('title','description','category_id','sub_modul','ownership_id');
        $program = $this->mfiles_upload->get_form_element($arr);

        $program['modul'] = $page;

        /*$program['title'] = $this->input->post('title');
        $program['category_id'] = $this->input->post('category_id');
		
		$program['sub_modul'] = $this->input->post('sub_modul');
		$program['description'] = $this->input->post('description');*/
        
		if($this->input->post('created')){
            $created = DateTime::createFromFormat('j M Y', $this->input->post('created'));
            $program['created'] = $created->format('Y-m-d');}
        else{
            $program['created'] =  date("Y-m-d");
        }
		
		//$program['user_allowed'] = implode(";", $this->input->post('user_allowed'));
		//$data_file_upload['user_allowed'] = $program['user_allowed'];

        if($this->input->post('segment_allowed')){
            $program['segment_allowed'] = implode(";", $this->input->post('segment_allowed'));
            $data_file_upload['segment_allowed'] = $program['segment_allowed'];
        } 
        
        if($id){
        	$file_id = $id;
            //$program['updated'] =  date("Y-m-d H:i:s");
			$this->mnews->update_news($program,$id);
        }
        else{
        	$program['user_id'] = $user['id'];
            $file_id = $this->mnews->insert_news($program);
            
        }
        
        /*Upload attach */ 
        if($page=='compliance')
        {
            $upload_path = "compliance/publications/".$file_id."/";
        }
        elseif($page=='market'){
            $upload_path = "market/publications/".$file_id."/";
        }
        elseif($page=='product_knowledge'){
            $upload_path = "product_knowledge/news/".$file_id."/";
        }
        elseif($page == 'hr'){
            $upload_path = "hr/".$file_id."/";
        }
        elseif($page == 'account plan'){
            $upload_path = "account_plan/publications/".$file_id."/";
        }
        elseif($page == 'anchor update'){
            $upload_path = "anchor_update/publications/".$file_id."/";
        }
        elseif($page == 'legal news'){
            $upload_path = "legal/publications/".$file_id."/";
        }
        elseif($page == 'ssf news'){
            $upload_path = "ssf/publications/".$file_id."/";
        }
        elseif ($page == 'calendar news'){
            $upload_path = "calendar/".$program['ownership_id']."/publications/".$file_id."/";
        }
        elseif ($page == 'df news'){
            $upload_path = "df/publications/".$file_id."/";
        }
        elseif($page == 'pipeline news'){
            $upload_path = "pipeline/publications/".$file_id."/";
        }
        elseif($page == 'credit pipeline news'){
            $upload_path = "credit_pipeline/publications/".$file_id."/";
        }
        elseif($page == 'fund pipeline news'){
            $upload_path = "fund_pipeline/publications/".$file_id."/";
        }
        elseif($page == 'rkk news'){
            $upload_path = "rkk/publications/".$file_id."/";
        }
        elseif($page=='competition'){
            $upload_path = "competition/publications/".$file_id."/";
        }
        /****************************** File Upload ******************************/
        
        /*** Attachment ***/
        if(isset($_FILES['attachment']) && !($_FILES['attachment']['error'] == UPLOAD_ERR_NO_FILE)){
            /*Upload */ 
            $file = $this->mfiles_upload->upload_files("attachment",$upload_path,$page,$program['sub_modul'],$file_id,true,false);
        }
        //$this->mfiles_upload->update_db_where($data_file_upload,array('ownership_id' => $file_id, 'modul' => $page, 'sub_modul' => $program['sub_modul']),'files_upload');

        /*** Photo Gallery ***/
        if($page!='competition'){
            $this->upload->reset_multi_upload_data();
        }
        if(isset($_FILES['photo']) && !($_FILES['photo']['error'] == UPLOAD_ERR_NO_FILE)){
            /*Upload */ 
            $file = $this->mfiles_upload->upload_files("photo",$upload_path,'gallery',$page,$file_id,true,true);
        }
        //$this->mfiles_upload->update_db_where($data_file_upload,array('ownership_id' => $file_id, 'modul' => 'gallery', 'sub_modul' => $page),'files_upload');

        /*** Photo Banner ***/
        if($page!='competition'){
            $this->upload->reset_multi_upload_data();
        }
        if(isset($_FILES['img']) && !($_FILES['img']['error'] == UPLOAD_ERR_NO_FILE)){
            /*Upload */ 
            $file = $this->mfiles_upload->upload_file("img",$upload_path,'photo',$page,$file_id,true,true);
        }
        //$this->mfiles_upload->update_db_where($data_file_upload,array('ownership_id' => $file_id, 'modul' => 'photo', 'sub_modul' => $page),'files_upload');

        /*Redirect*/
        if($page=='compliance'){
            redirect($page);
        }
        else if($page=='market'){
           redirect('market/page/'.$program['sub_modul']); 
        }
        else if($page=='product_knowledge'){
           redirect('product_knowledge'); 
        }
        else if($page=='hr'){
           redirect('hr'); 
        }
        else if($page=='account plan'){
           redirect('account_planning'); 
        }
        else if($page=='anchor update'){
            $id_anchor = $this->mfiles_upload->get_db('custgroup_name','asc','custgroup',array('custgroup_name' => $program['sub_modul']),'','')[0];
            redirect('account_planning/anchor/'.$id_anchor->id);
        }
        else if($page=='legal news'){
           redirect('legal'); 
        }
        else if($page=='ssf news'){
           redirect('ssf'); 
        }
        else if($page=='df news'){
           redirect('df'); 
        }
        else if($page=='calendar news'){
           redirect('calendar/show/'.$program['ownership_id']); 
        }
        else if($page=='pipeline news'){
           redirect('pipeline'); 
        }
        else if($page=='credit pipeline news'){
           redirect('credit_pipeline'); 
        }
        else if($page=='fund pipeline news'){
           redirect('fund_pipeline'); 
        }
        else if($page=='rkk news'){
           redirect('rkk'); 
        }
        else if($page=='competition'){
           redirect('competition/'.$program['sub_modul']); 
        }
        
    }
    
    public function delete_news(){
    	$id = $this->input->get('id');
    	$type = $this->input->get('type');
    	if($id){
            $this->mnews->delete_news($id,$type);
            $json['status'] = true;
        }
        else
        {
             $json['status'] = false;
        }
        $this->output->set_content_type('application/json')
                         ->set_output(json_encode($json));
    }

    public function vote_news(){
        $id = $this->input->get('id');
        $type = $this->input->get('type');
        if($id){
            $this->mnews->vote_news($id,$type);
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

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */