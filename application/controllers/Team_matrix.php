<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');


class Team_matrix extends CI_Controller {
    
    public function __construct() {
        parent::__construct();

        $session = $this->session->userdata('userbapekis');
        if(!$session){redirect('user/login');}

        $this->load->model(array('muser','mfiles_upload','mmysharing'));
		$this->load->helper('text');
    }
    /**
     * Method for page (public)
     */




    public function show_form(){
        $id = $this->input->get('id');
        $data['ownership_id'] = $this->input->get('ownership_id');
        $data['category'] = $this->input->get('category');
        $data['modul'] = $this->input->get('modul');
        $data['sub_modul'] = $this->input->get('sub_modul');
        //$data['custgroup_id'] = $this->input->get('custgroup_id');
        //$data['custgroup_name'] = $this->input->get('custgroup_name');

        if($id){
            
        }

        $data['users'] = $this->mfiles_upload->get_db('full_name','asc','user','','','');
        $data['popup_content'] = $this->load->view('team_matrix/broventh/_form_team', $data,TRUE);
        $data['popup_title'] = "Team Matrix Form"; 
        $data['popup_width'] = "600px";

        $data['status'] = 1;
        $data['html'] = $this->load->view('admin/shared/component/_popup_page', $data,TRUE);
        
        $this->output->set_content_type('application/json')
                     ->set_output(json_encode($data));
    }



    public function store_team(){
        $user = $this->session->userdata('userbapekis');
        $id = $this->uri->segment(3);

        $arr = array('ownership_category','ownership_modul','ownership_sub_modul','ownership_id','user_id');
        $data = $this->mfiles_upload->get_form_element($arr);

        $data['updated_at'] = date('Y-m-d H:i:s');
        $data['updated_by'] = $user['id'];

        if(!$id){
            $data['created_at'] = $data['updated_at'];
            $data['created_by'] = $data['updated_by'];

            $team_id = $this->mfiles_upload->insert_db($data,'team_matrix');
            //$this->muser->insert_user_access_log("Access DF Page, Add New Distributor ".$data['name']);

            
        }else{
            $this->mfiles_upload->update_db($data,$id,'team_matrix');
            $team_id = $id;
            //$this->muser->insert_user_access_log("Access DF Page, Edit Principal Data for ".$data['name']);
        }


        //GET THE TEAM BACK
        if($team_id){
            /******* Pengurus Masjid *********/
            
            // Get the Team
            $join_team[0] = array('table' => 'user','in' => "team_matrix.user_id = user.id");
            
            $team['category'] = $data['ownership_category'];
            $team['modul'] = $data['ownership_modul'];
            $team['sub_modul'] = $data['ownership_sub_modul'];

            $arr_where_team = array('ownership_category' => $team['category'], 'ownership_modul' => $team['modul'], 'ownership_sub_modul' => $team['sub_modul']);

            $team_matrixs = $this->mfiles_upload->get_db_join('priority','asc','team_matrix',$arr_where_team,'*,team_matrix.id as team_id','','',$join_team);
            if($team_matrixs) $team['teams'] = $team_matrixs;

            // List of View
            $team['section_title'] = "Pengurus Masjid ";
            $json['list_teams_view'] = $this->load->view('team_matrix/broventh/_list_teams', $team,TRUE);
            
            /******* End of Pengurus Masjid *********/
        }

        $json['team_id'] = $team_id;
        $json['status'] = 1;
        $this->output->set_content_type('application/json')
                         ->set_output(json_encode($json));
    }


    public function delete_team_matrix(){
        $id = $this->input->get('id');
        if($id){
            /*$comment = $this->mfiles_upload->get_db('id','desc','comment',array("id" => $id),'','')[0];
            
            $comment_owner = "";
            if($comment->ownership_type == "mysharing"){
                $sharing = $this->mfiles_upload->get_db('id','desc',$comment->ownership_type,array("id" => $comment->ownership_id),'','')[0];
                $comment_owner = " on My Sharing, ".$sharing->title;

            }
            elseif($comment->ownership_type == "rkk"){
                $comment_owner = " on RKK ".date("j M y", strtotime($comment->ownership_date));
            }
            
            $this->muser->insert_user_access_log("Delete Comment - ".strip_tags($comment->comment)." - ".$comment_owner);
            */
            if($this->mfiles_upload->delete_db_where(array("id" => $id),'team_matrix')){
                $json['status']=1;
                $this->output->set_content_type('application/json')
                    ->set_output(json_encode($json));
            }
        }
    }














    public function show_comment_popup(){
        $data['id'] = $this->input->get('ownership_id');
        $data['kind'] = $this->input->get('kind');
        $data['ownership'] = $this->input->get('ownership_type');
        $data['modul_comment'] = $this->input->get('modul');
        $data['sub_modul_comment'] = $this->input->get('sub_modul');
        

        /*$data['custgroup_id'] = $this->input->get('custgroup_id');
        $data['custgroup_name'] = $this->input->get('custgroup_name');

        $data['id'] = $data['custgroup_id'];
        $data['kind'] = "id";
        $data['ownership'] = "account_planning";
        $data['modul_comment'] = $data['segment'];
        $data['sub_modul_comment'] = $data['custgroup_name'];*/
        $arr_where_comment = "";
        if($data['id']) $arr_where_comment['ownership_id'] = $data['id'];
        if($data['ownership']) $arr_where_comment['ownership_type'] = $data['ownership'];
        if($data['modul_comment']) $arr_where_comment['ownership_modul'] = $data['modul_comment'];
        if($data['sub_modul_comment']) $arr_where_comment['ownership_sub_modul'] = $data['sub_modul_comment'];
        
        $join[0] = array('table' => 'user', 'in' => "user.id = comment.user_id");
        
        $data['comments'] = $this->mfiles_upload->get_db_join('comment.id','desc','comment',$arr_where_comment,'*, comment.id as comment_id','','',$join);
        $data['is_rich_text'] = true;
        $data['comment_list'] = $this->load->view('comment/_list',$data,TRUE);

        $data['popup_content'] = $this->load->view('comment/_form',$data,TRUE);
        $data['popup_title'] = "Discussion Box"; 
        $data['popup_width'] = "700px";

        $data['status'] = 1;
        $data['html'] = $this->load->view('shared/component/_popup_brobot', $data,TRUE);
        
        $this->output->set_content_type('application/json')
                     ->set_output(json_encode($data));
    }

    public function store(){
        $user = $this->session->userdata('userbapekis');
        $kind = $this->input->post('kind');
        $modul = $this->input->post('modul');
        $sub_modul = $this->input->post('sub_modul');
        $view_comment = $this->input->post('view_comment');

        $data['comment'] = $this->input->post('comment');
        $data['ownership_type'] = $this->input->post('ownership_type');
        $data['user_id'] = $user['id'];
        $data['created'] = date("Y-m-d H:i:s");
        $data['updated'] = date("Y-m-d H:i:s");

        if($kind == "date") $data['ownership_date'] = $this->input->post('ownership_id');
        elseif($kind == "modul") $data['ownership_modul'] = $this->input->post('ownership_id');
        else $data['ownership_id'] = $this->input->post('ownership_id');

        if($modul) $data['ownership_modul'] = $modul;
        if($sub_modul) $data['ownership_sub_modul'] = $sub_modul;
        
        $id = $this->mfiles_upload->insert_db($data, 'comment');

        if($data['ownership_type'] == "mysharing"){
            $title = $this->mmysharing->get_by_id($data['ownership_id'])->title;
            $this->muser->insert_user_access_log("Comment - ".strip_tags($data['comment'])." - on My Sharing, $title");
        }elseif($data['ownership_type'] == "rkk"){
            if($kind == "date") $this->muser->insert_user_access_log("Comment - ".strip_tags($data['comment'])." - on RKK ".$data['ownership_date']);
            
        }elseif($data['ownership_type'] == "raker"){
            $this->muser->insert_user_access_log("Ask - ".strip_tags($data['comment'])." - on Raker on ".$data['ownership_modul']." discussion");
        }


        if($id){
            $join[0] = array('table' => 'user', 'in' => "user.id = comment.user_id");
            $arr_where = array('ownership_type' => $data['ownership_type'], 'ownership_'.$kind => $this->input->post('ownership_id'));
            if($modul) $arr_where['ownership_modul'] = $modul;
            if($sub_modul) $arr_where['ownership_sub_modul'] = $sub_modul;
            $data['comments'] = $this->mfiles_upload->get_db_join('comment.id','desc','comment',$arr_where,'*, comment.id as comment_id','','',$join);
        }
        $folder_view = "";
        if($view_comment) $folder_view = "/theme/".$view_comment;
        

        $json['status'] = 1;
        $json['comment_list'] = $this->load->view('comment'.$folder_view.'/_list',$data,TRUE);
        
        $this->output->set_content_type('application/json')
                     ->set_output(json_encode($json));
    }

    
}
