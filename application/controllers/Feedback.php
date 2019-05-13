<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');


class Feedback extends CI_Controller {
    
    public function __construct() {
        parent::__construct();
        $this->load->model(array('muser','mfiles_upload','mmysharing','muser_activity'));
    }
    /**
     * Method for page (public)
     */

    public function submit(){
      	$id = $this->uri->segment(3);
      	$user = $this->session->userdata('userbapekis');
        
        $arr = array('kind','name','unit','email','comment','created_at');
        $data = $this->mfiles_upload->get_form_element($arr);

        $data['date'] = DateTime::createFromFormat('j M Y', $this->input->post('date'))->format('Y-m-d');

        $data['created_at'] = date('Y-m-d H:i:s');

        
        $sharing_id = $this->mfiles_upload->insert_db($data,'feedback');


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
