<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');


class Management extends CI_Controller {
    
    public function __construct() {
        parent::__construct();
        $this->load->model(array('muser','mfiles_upload','mmysharing','muser_activity'));
		$session = $this->session->userdata('userbapekis');
        
        if(!$session){
            $url = current_url();
            $this->session->set_userdata('last_page_open',$url);
            redirect('account/login');
        }
        //elseif(!$session['is_employee'] && !is_user_role($session,"PERFORMANCE VIEWER") && $session['position']!="Director"){redirect('');}
    }
    /**
     * Method for page (public)
     */
     
    public function index()
    {
        $session = $this->session->userdata('userbapekis');
        $data['title'] = "Management - Bapekis";
        //$this->muser->insert_user_access_log("Access Internal Sharing");

        /****** GET MANAGEMENT MEMBER *******/
        $this->db->where('priority in (1,2,3)');
        $data['members'] = $this->mfiles_upload->get_db("directorate","asc","user",'','','');
        /************* END of GET MANAGEMENT MEMBER *************/
        

        $data['header'] = $this->load->view('admin/shared/first/header','',TRUE);   
        $data['footer'] = $this->load->view('admin/shared/first/footer','',TRUE);
        $data['content'] = $this->load->view('management/index',$data,TRUE);

        $this->load->view('admin/shared/front',$data);
        
    }
}
