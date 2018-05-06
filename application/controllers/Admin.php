<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');


class Admin extends CI_Controller {

    public function __construct() {
        parent::__construct();

        $session = $this->session->userdata('userbapekis');
        if(!$session){
            $url = current_url();
            $this->session->set_userdata('last_page_open',$url);
            redirect('user/login');
        }

        if(!is_user_role($session,"SYSTEM ADMINISTRATOR")){
            redirect('');
        }

        $this->load->model(array('muser'));
    }

    public function index()
    {
        $this->muser->insert_user_access_log("Access CBIC Data Quality Page");
        
        $data['title'] = "Admin Page - Bapekis";

        $data['header'] = $this->load->view('admin/shared/first/header','',TRUE);   
        $data['footer'] = $this->load->view('admin/shared/first/footer','',TRUE);
        $data['content'] = $this->load->view('admin/index',$data,TRUE);

        $this->load->view('admin/shared/front',$data);
        
    }






    /********************** USER MENU **********************/
    public function user()
    {
        $this->muser->insert_user_access_log("Access CBIC Data Quality Page, User Management Page");
        
        $data['users'] = $this->mfiles_upload->get_db('full_name','asc','user','','','');

        $data['title'] = "User Management Page - CBIC";

        $data['header'] = $this->load->view('shared/header/header-submenu','',TRUE);   
        $data['footer'] = $this->load->view('shared/footer','',TRUE);
        $data['content'] = $this->load->view('data/user',$data,TRUE);

        $this->load->view('front',$data);
        
    }

    public function user_detail()
    {
        $id = $this->input->get('id');

        $data['profile'] = $this->muser->get_user_by_id($id);

        $data['status'] = 1;
        $data['html'] = $this->load->view('data/component/user/_detail',$data,TRUE);
        $this->output->set_content_type('application/json')
                     ->set_output(json_encode($data));
        
    }

    public function user_form()
    {
        $id = $this->input->get('id');

        $data['pages'] = $this->mfiles_upload->get_db("name","asc","page","","","");

        if($id){
            $data['profile'] = $this->muser->get_user_by_id($id);
        }

        $data['status'] = 1;
        $data['html'] = $this->load->view('data/component/user/_form',$data,TRUE);
        $this->output->set_content_type('application/json')
                     ->set_output(json_encode($data));
        
    }

    public function store_user()
    {
        $id = $this->uri->segment(3);
        $user = $this->session->userdata('userdbcisam');
        $profile = $this->muser->get_user_by_id($id);
        
        $arr = array('full_name','panggilan','gender','agama','username','nik','jabatan','position','sumber','directorate','group','department','phone_number','ip_phone','extension','email','strata','universitas','jurusan','tahun_lulus','is_employee','is_rkk_committee','status','redirect_page_id','is_NDA');
        $data = $this->mfiles_upload->get_form_element($arr);


        if($this->input->post('dob')) $data['dob'] = DateTime::createFromFormat('d M Y', $this->input->post('dob'))->format('Y-m-d');
        if($this->input->post('tmt_kerja')) $data['tmt_kerja'] = DateTime::createFromFormat('d M Y', $this->input->post('tmt_kerja'))->format('Y-m-d');


        /**** Unit Information ****/
        $data['directorate'] = strtoupper($data['directorate']);
        $data['group'] = strtoupper($data['group']);
        $data['department'] = strtoupper($data['department']);
        /**** End of Unit Information ****/

        /**** Role Information ****/
        $data['role'] = "";
        foreach($this->input->post('role') as $role){
            $data['role'] = $data['role'].$role.";";
        }
        /**** End of Role Information ****/

        /**** Dir Priority Data ****/
        $directorate = $this->mfiles_upload->get_db('directorate','asc','cbdirectorate',array("directorate" => strtoupper($data['directorate'])),'','');
        if($directorate) $data['priority_dir'] = $directorate[0]->priority;
        /**** End of Dir Priority Data ****/

        /**** Position Priority Data ****/
        $data['priority'] = get_position_priority($data['position']);
        /**** End Position Priority Data ****/

        /**** Make Image ****/
        $upload_path = "assets/uploads/user_profile/";
        if (!is_dir($upload_path)) {
            mkdir($upload_path, 0777, true);
        }
        $image_crop = $this->input->post('pp_not_file');
        if($image_crop){
            $imageData = base64_decode(explode("data:image/png;base64,", $image_crop)[1]);
            //echo $imageData;

            $date_timestamp = new DateTime();

            $photo = imagecreatefromstring($imageData);
            $photo_url = $upload_path.$data['nik'].'_profile_picture'.$date_timestamp->getTimestamp().'.png';
            imagepng($photo,$photo_url,5);

            $data['profile_picture'] = $photo_url;

            if($profile->profile_picture){
                unlink($profile->profile_picture);
            }

            /************* Make Thumbnail ***************/
            $ex_profile = explode("/", $photo_url);         
            $image_name = end($ex_profile);
            $file_location = base_url().$photo_url;
            $target_folder = "user_profile/";

            $this->mfiles_upload->make_photo_thumb($image_name,$file_location,$target_folder,40,'_thumbnail.jpg');
            /************* END of Make Thumbnail ***************/
        }

        $data['updated_by'] = $user['id'];
        $data['updated_at'] = date("Y-m-d H:i:s");

        /**** SAVE USER DATA ****/
        if(!$id){
            $data['created_at'] = date('Y-m-d H:i:s');
            $data['created_by'] = $this->session->userdata('userdbcisam')['id'];
            
            $data['password'] = md5($this->input->post('password'));
            $user_id = $this->mfiles_upload->insert_db($data,'user');
            $this->muser->insert_user_access_log("Access CBIC Data Quality Page, Add new user ".$data['full_name']);
        }
        else{
            $this->mfiles_upload->update_db($data,$id,'user');
            $user_id = $id;
            $this->muser->insert_user_access_log("Access CBIC Data Quality Page, Edit user data for ".$data['full_name']);
        }

        redirect('data/user');
    }
    /********************** END OF USER MENU **********************/
















    /********************** PARSER MENU **********************/
    public function parser()
    {
        $this->muser->insert_user_access_log("Access CBIC Data Quality Page, Data Parser Page");
        
        $data['parsers'] = $this->mfiles_upload->get_db('title','asc','parser','','','');

        $data['title'] = "Data Parser Page - CBIC";

        $data['header'] = $this->load->view('shared/header/header-submenu','',TRUE);   
        $data['footer'] = $this->load->view('shared/footer','',TRUE);
        $data['content'] = $this->load->view('data/parser',$data,TRUE);

        $this->load->view('front',$data);
        
    }

    

    public function get_parser_latest_date(){

        $parsers = $this->mfiles_upload->get_db('title','asc','parser','','','');

        $arr_result = array(); $i=0;
        foreach ($parsers as $row) {
            $arr_result[$i]['id'] =$row->id;
            $arr_result[$i]['date'] = "";
            if($row->db){
                $arr_result[$i]['date'] = date("j M y",strtotime($this->mfiles_upload->get_latest_date($row->db)));
            }
            $i++;
        }

        $data['status'] = 1;
        $data['results'] = $arr_result;
        
        $this->output->set_content_type('application/json')
                     ->set_output(json_encode($data));
    }


    public function get_parser_detail(){
        $id = $this->input->get('id');

        $data['parser'] = $this->mfiles_upload->get_db("title","asc","parser",array('id' => $id),"","")[0];

        $arr_where = array('ownership_id' => $id, 'modul' => 'parser', 'sub_modul' => 'attachment');
        $data['attachments'] = $this->mfiles_upload->get_db("id","desc","files_upload",$arr_where,"","");

        $data['form_upload'] = $this->load->view('data/component/parser/detail/_form_upload', $data,TRUE);

        $data['status'] = 1;
        $data['html'] = $this->load->view('data/component/parser/_detail', $data,TRUE);
        
        $this->output->set_content_type('application/json')
                     ->set_output(json_encode($data));
    }


    public function parser_file_form(){
        $id = $this->input->get('id');
        $data['pages'] = $this->mfiles_upload->get_db('name','asc','page','','','');
        if($id){
            $data['id'] = $id;
            $data['parser'] = $this->mfiles_upload->get_db("title","asc","parser",array('id' => $id),"","")[0];

            $arr_where = array('ownership_id' => $id, 'modul' => 'parser', 'sub_modul' => 'attachment');
            $data['attachments'] = $this->mfiles_upload->get_db("id","desc","files_upload",$arr_where,"","");
        }

        $data['popup_content'] = $this->load->view('data/component/parser/_form', $data,TRUE);
        $data['popup_title'] = "Form Parser Information"; 
        $data['popup_width'] = "800px";

        $data['status'] = 1;
        $data['html'] = $this->load->view('shared/component/_popup_broventh', $data,TRUE);
        
        $this->output->set_content_type('application/json')
                     ->set_output(json_encode($data));
    }

    public function store_parser(){
        $id = $this->uri->segment(3);
        $user = $this->session->userdata('userdbcisam');
        
        $arr = array('title','period','description','page_id','db');
        $data = $this->mfiles_upload->get_form_element($arr);

        $data['updated_by'] = $user['id'];
        $data['updated_at'] = date("Y-m-d H:i");

        if(!$id){
            $data['created_at'] = date('Y-m-d H:i:s');
            $data['created_by'] = $this->session->userdata('userdbcisam')['id'];
            
            $parser_id = $this->mfiles_upload->insert_db($data,'parser');
            $this->muser->insert_user_access_log("Access CBIC Data Quality Page, Add new parser information ".$data['title']);
        }
        else{
            $this->mfiles_upload->update_db($data,$id,'parser');
            $parser_id = $id;
            $this->muser->insert_user_access_log("Access CBIC Data Quality Page, Edit parser data for ".$data['title']);
        }

        /********************************* FILES UPLOAD ***********************************/
        $upload_path = "parser/".$parser_id."/";
        /*** Attachment ***/
        if(isset($_FILES['attachment']) && !($_FILES['attachment']['error'] == UPLOAD_ERR_NO_FILE)){
            /*Upload */ 
            $file = $this->mfiles_upload->upload_files("attachment",$upload_path,'parser','attachment',$parser_id,true,false);
        }
        /********************************* END OF FILES UPLOAD ***********************************/


        $json['parser_id'] = $parser_id;
        $json['status'] = 1;
        $this->output->set_content_type('application/json')
                         ->set_output(json_encode($json));
        
     }

    /********************** END OF PARSER MENU **********************/















    /********************** CATEGORY MENU **********************/
    public function category()
    {
        $this->muser->insert_user_access_log("Access CBIC Data Quality Page, Category Management Page");
        
        $join[0] = array('table' => 'user', 'in' => "user.id = category.created_by");
        $data['categories'] = $this->mfiles_upload->get_db_join('id','desc','category','','category.*, user.full_name','','',$join);

        $data['title'] = "Category Management Page - CBIC";

        $data['header'] = $this->load->view('shared/header/header-submenu','',TRUE);   
        $data['footer'] = $this->load->view('shared/footer','',TRUE);
        $data['content'] = $this->load->view('data/category',$data,TRUE);

        $this->load->view('front',$data);
        
    }

    /********************** END OF CATEGORY MENU **********************/











    /********************** TUTORIAL MENU **********************/
    public function tutorial()
    {
        $this->muser->insert_user_access_log("Access CBIC Data Quality Page, Tutorial Management Page");
        
        $join[0] = array('table' => 'page', 'in' => "page.id = tutorial.page_id");
        $data['tutorials'] = $this->mfiles_upload->get_db_join('id','desc','tutorial','','tutorial.*, page.name','','',$join);

        $data['title'] = "Tutorial Management Page - CBIC";

        $data['header'] = $this->load->view('shared/header/header-submenu','',TRUE);   
        $data['footer'] = $this->load->view('shared/footer','',TRUE);
        $data['content'] = $this->load->view('data/tutorial',$data,TRUE);

        $this->load->view('front',$data);
        
    }


    public function tutorial_form(){
        $id = $this->input->get('id');
        $data['pages'] = $this->mfiles_upload->get_db('name','asc','page','','','');
        if($id){
            $data['id'] = $id;
            $data['tutorial'] = $this->mfiles_upload->get_db("title","asc","tutorial",array('id' => $id),"","")[0];

            $arr_where = array('ownership_id' => $id, 'modul' => 'tutorial', 'sub_modul' => 'attachment');
            $data['attachments'] = $this->mfiles_upload->get_db("id","desc","files_upload",$arr_where,"","");
        }

        $data['popup_content'] = $this->load->view('data/component/tutorial/_form', $data,TRUE);
        $data['popup_title'] = "Form Tutorial Information"; 
        $data['popup_width'] = "800px";

        $data['status'] = 1;
        $data['html'] = $this->load->view('shared/component/_popup_broventh', $data,TRUE);
        
        $this->output->set_content_type('application/json')
                     ->set_output(json_encode($data));
    }

    public function store_tutorial(){
        $id = $this->uri->segment(3);
        $user = $this->session->userdata('userdbcisam');
        
        $arr = array('title','content','description','page_id');
        $data = $this->mfiles_upload->get_form_element($arr);

        $data['updated_by'] = $user['id'];
        $data['updated_at'] = date("Y-m-d H:i");

        if(!$id){
            $data['created_at'] = date('Y-m-d H:i:s');
            $data['created_by'] = $this->session->userdata('userdbcisam')['id'];
            
            $tutorial_id = $this->mfiles_upload->insert_db($data,'tutorial');
            $this->muser->insert_user_access_log("Access CBIC Data Quality Page, Add new tutorial information ".$data['title']);
        }
        else{
            $this->mfiles_upload->update_db($data,$id,'tutorial');
            $tutorial_id = $id;
            $this->muser->insert_user_access_log("Access CBIC Data Quality Page, Edit tutorial data for ".$data['title']);
        }

        /********************************* FILES UPLOAD ***********************************/
        $upload_path = "tutorial/".$tutorial_id."/";
        /*** Attachment ***/
        if(isset($_FILES['attachment']) && !($_FILES['attachment']['error'] == UPLOAD_ERR_NO_FILE)){
            /*Upload */ 
            $file = $this->mfiles_upload->upload_files("attachment",$upload_path,'tutorial','attachment',$tutorial_id,true,false);
        }
        /********************************* END OF FILES UPLOAD ***********************************/


        $json['tutorial_id'] = $tutorial_id;
        $json['status'] = 1;
        $this->output->set_content_type('application/json')
                         ->set_output(json_encode($json));
        
     }


     public function show_page_related_tutorial(){
        $uri_string = $this->input->get('uri_string');

        $ex_uri = explode("/", $uri_string);

        $stat = ""; $now = "";
        foreach($ex_uri as $uri){
            $now = $now.$uri;
            $stat = "url like '".$now."%'";
            if($uri != end($ex_uri)){
                $now = $now."/";
                $stat = $stat." OR ";
            }
        }

        $join[0] = array('table' => 'page', 'in' => "page.id = tutorial.page_id");
        $this->db->where("( $stat )");
        $data['tutorials'] = $this->mfiles_upload->get_db_join('id','desc','tutorial','','tutorial.*, page.name','','',$join);

        $data['popup_content'] = $this->load->view('data/component/tutorial/_page_related', $data,TRUE);
        $data['popup_title'] = "Tutorial Page"; 
        $data['popup_width'] = "800px";

        $data['status'] = 1;
        $data['html'] = $this->load->view('shared/component/_popup_broventh', $data,TRUE);
        
        $this->output->set_content_type('application/json')
                     ->set_output(json_encode($data));
     }



     public function delete_tutorial(){
        $id = $this->input->get('id');

        $this->mfiles_upload->delete_id_db('tutorial',$id);
        $this->mfiles_upload->delete_with_files_ownership($id,'tutorial','attachment');
        
        $json['status'] = 1;
        $this->output->set_content_type('application/json')
                     ->set_output(json_encode($json));
    }



    /********************** END OF TUTORIAL MENU **********************/

}
