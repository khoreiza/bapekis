<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');


class Detail extends CI_Controller {
    
    public function __construct() {
        parent::__construct();
        $this->load->model(array('muser','mfiles_upload','mmysharing','muser_activity'));
		
    }
    /**
     * Method for page (public)
     */
     
    public function sharing_show(){
        $id = $this->input->get('id');
        
        //GET SHARING
        $arr_where_sharing = array('mysharing.id' => $id);
        $files_upload_table_news = "(SELECT `files_upload`.full_url,ownership_id from files_upload where modul = 'my sharing' and sub_modul = 'banner') as files_upload";
        $join_sharing[0] = array('table' => $files_upload_table_news, 'in' => "files_upload.ownership_id = mysharing.id", 'how' => 'left');
        $join_sharing[1] = array('table' => 'category', 'in' => "mysharing.category_id = category.id",'how' => 'left');
        $data['sharing'] = $this->mfiles_upload->get_db_join('id','desc','mysharing',$arr_where_sharing,'mysharing.*, mysharing.id as mysharing_id, files_upload.full_url, category.category',"",'',$join_sharing)[0];

        
        $data['popup_content'] = $this->load->view('detail/component/sharing/_show', $data,TRUE);
        $data['popup_title'] = "Form Calendar of Event";
        $data['popup_width'] = "880px";

        $data['status'] = 1;
        $data['html'] = $this->load->view('detail/popup_detail', $data,TRUE);
        $this->output->set_content_type('application/json')
                         ->set_output(json_encode($data));
    
    }



    public function event_show(){
        $id = $this->input->get('id');
        
        //GET EVENT
        
        $arr_where = array('calendar.id' => $id);
        $join_ev[0] = array('table' => 'files_upload','in' => "files_upload.ownership_id = calendar.id AND files_upload.modul = 'calendar' AND files_upload.sub_modul = 'banner'", 'how' => 'left');
        $join_ev[1] = array('table' => 'category','in' => "calendar.category_id = category.id", 'how' => 'left');
        $data['event'] = $this->mfiles_upload->get_db_join('rand()','','calendar',$arr_where,'calendar.*, files_upload.full_url, category.category',"",'calendar.id',$join_ev)[0];


        //GET ATTAACHMENT PHOTO GALLERY
        $data['attachments']=$this->mfiles_upload->get_files_upload_by_ownership_id('calendar','event',$id);
        $data['galleries']=$this->mfiles_upload->get_files_upload_by_ownership_id('calendar','gallery',$id);

        
        $data['popup_content'] = $this->load->view('detail/component/event/_show', $data,TRUE);
        $data['popup_title'] = "Form Calendar of Event";
        $data['popup_width'] = "1080px";

        $data['status'] = 1;
        $data['html'] = $this->load->view('detail/popup_detail', $data,TRUE);
        $this->output->set_content_type('application/json')
                         ->set_output(json_encode($data));
    
    }




    public function feedback_form(){
        $id = $this->input->get('id');
        
                
        $data['popup_content'] = $this->load->view('detail/component/feedback/_form', '',TRUE);
        $data['popup_title'] = "Form Calendar of Event";
        $data['popup_width'] = "880px";

        $data['status'] = 1;
        $data['html'] = $this->load->view('detail/popup_detail', $data,TRUE);
        $this->output->set_content_type('application/json')
                         ->set_output(json_encode($data));
    
    }
}
