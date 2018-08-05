<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class General extends CI_Controller {

	public function __construct() {
        parent::__construct();
        $this->load->model(array('muser','mfiles_upload','mmysharing','muser_activity'));
	
    }

    public function index(){

        $data['title'] = "Mandiri Bapekis General Info Page";

        $component['banner'] = $this->load->view('general/component/banner','',TRUE);

        /****** GET MANAGEMENT MEMBER *******/
        $this->db->where('priority in (1,2,3)');
        $component['members'] = $this->mfiles_upload->get_db("directorate","asc","user",'','','');
        /************* END of GET MANAGEMENT MEMBER *************/

        $data['content'] = $this->load->view('general/index',$component,TRUE);

        $data['menu'] = $this->load->view('template/menu','',TRUE);
        $data['header'] = $this->load->view('template/header','',TRUE);
        $data['footer'] = $this->load->view('template/footer','',TRUE);

        $this->load->view('front',$data);
    }
}