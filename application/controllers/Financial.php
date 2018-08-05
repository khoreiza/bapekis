<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Financial extends CI_Controller {

    public function __construct() {
        parent::__construct();
		$session = $this->session->userdata('userbapekis');
        
        if(!$session){
            $url = current_url();
            $this->session->set_userdata('last_page_open',$url);
            redirect('account/login');
        }
        elseif(!$session['is_employee'] && !is_user_role($session,"PERFORMANCE VIEWER") && $session['position']!="Director"){redirect('');}

		$this->load->helper(array('form', 'url', 'file'));
		$this->load->model(array('mcalendar','mfiles_upload','muser','mupdates'));   
    }
    /**
     * Method for page (public)
     */

    public function index(){

        $data['title'] = "Mandiri Bapekis Financial Info Page";

        $component['banner'] = $this->load->view('financial/component/banner','',TRUE);

        $data['content'] = $this->load->view('financial/index',$component,TRUE);

        $data['menu'] = $this->load->view('template/menu','',TRUE);
        $data['header'] = $this->load->view('template/header','',TRUE);
        $data['footer'] = $this->load->view('template/footer','',TRUE);

        $this->load->view('front',$data);
    }



    /*********** FINANCIAL MOSQUE MENU *************/
    public function show_financial_form(){
        $id = $this->input->get('id');
        $data['mosque_id'] = $this->input->get('mosque_id');

        if($id){
            $data['cashflow'] = $this->mfiles_upload->get_db('id','asc','financial_cashflow',array('id' => $id),'*','1')[0];
        }

        
        $data['popup_content'] = $this->load->view('financial/component/index/_financial_form', $data,TRUE);
        $data['popup_title'] = "Form Financial"; 
        $data['popup_width'] = "680px";

        $json['status'] = 1;
        $json['html'] = $this->load->view('admin/shared/component/_popup_page', $data,TRUE);
        
        $this->output->set_content_type('application/json')
                     ->set_output(json_encode($json));
    }


    public function store(){
        $id = $this->uri->segment(3);
        $user = $this->session->userdata('userbapekis');
        $arr = array('mosque_id','type','amount','purpose','description');
        
        $cashflow = $this->mfiles_upload->get_form_element($arr);
        $cashflow['date'] = DateTime::createFromFormat('j M y', $this->input->post('date'))->format('Y-m-d');


        $arr_number = array('amount');
        $cashflow = $this->mfiles_upload->get_form_element_format($arr_number,'number',$cashflow);


        $cashflow['updated_by'] = $user['id'];
        $cashflow['updated_at'] = date("Y-m-d H:i");

        if(!$id){
            $cashflow['created_at'] = date('Y-m-d H:i:s');
            $cashflow['created_by'] = $user['id'];

            $cashflow_id = $this->mfiles_upload->insert_db($cashflow,'financial_cashflow');
        }
        else{
            $this->mfiles_upload->update_db($cashflow,$id,'financial_cashflow');
            $cashflow_id = $id;
        }

        

        $upload_path = "financial/mosque_".$cashflow['mosque_id']."/".$cashflow_id."/";
        /*** Attachment ***/
        if(isset($_FILES['attachment']) && !($_FILES['attachment']['error'] == UPLOAD_ERR_NO_FILE)){
            /*Upload */ 
            $file = $this->mfiles_upload->upload_files("attachment",$upload_path,'financial','attachment',$cashflow_id,true,false);
        }
        
        redirect('mosque/show/'.$cashflow['mosque_id']);
    }

}