<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Ramadhan extends CI_Controller {

	public function __construct() {
        parent::__construct();
        $this->load->model(array('muser','mfiles_upload','mmysharing','muser_activity'));
	
    }

    public function index(){

        $data['title'] = "Mandiri Bapekis General Info Page";

        $data['banner'] = $this->load->view('ramadhan/component/banner','',TRUE);

        
        /****** GET RAMADHAN DATA *******/
        
        //GET HADIST
        $arr_where_hadist = array("category" => "Hadist");

        $join_hadist[0] = array('table' => 'category', 'in' => "mysharing.category_id = category.id",'how' => 'left');
        $data['hadists'] = $this->mfiles_upload->get_db_join('id','desc','mysharing',$arr_where_hadist,'mysharing.*, mysharing.id as mysharing_id,category.category',"",'',$join_hadist);

        /************* END of GET RAMADHAN DATA *************/


        $data['content'] = $this->load->view('ramadhan/index',$data,TRUE);

        $data['menu'] = $this->load->view('template/menu','',TRUE);
        $data['header'] = $this->load->view('template/header','',TRUE);
        $data['footer'] = $this->load->view('template/footer','',TRUE);

        $this->load->view('front',$data);
    }

    public function general(){

        $data['title'] = "Mandiri Bapekis Front Page";
        

        /******* GET PRAYER SCHEDULE *******/
        $datakemenag = file_get_contents('https://bimasislam.kemenag.go.id/widget/jadwalshalat/42d38931fbd98d4764cc39ab8694a0f1f42d2e7d');
        preg_match_all("'<div class=\"pukul\"> (.*?)</div>'si",$datakemenag, $jadwal);
        $prayer_schedule['jadwalsholat'] = $jadwal[1];
        $component['prayer_schedule'] = $this->load->view('front/component/prayer_schedule',$prayer_schedule,TRUE);




        /******* GET BAPEKIS SHARING *******/
        $arr_category = array('Ragam Ramadhan','Bapekis Event', 'Belajar Hadist','Berbagi Ilmu');
        foreach($arr_category as $category){
            $latest_sharing['category_sharings'][$category] = $this->mmysharing->get_detil("category",5,0,$category);
        }
        $component['latest_sharing'] = $this->load->view('front/component/latest_sharing',$latest_sharing,TRUE);




        /******* GET BAPEKIS EVENT *******/
        $upcoming_event['events'] = $this->mfiles_upload->get_db('start','desc','calendar','','',"");


        $component['banner'] = $this->load->view('front/component/slider','',TRUE);
        
        $component['news'] = $this->load->view('front/component/news','',TRUE);
        
        $component['event_upcoming'] = $this->load->view('front/component/upcoming_event',$upcoming_event,TRUE);

        $data['content'] = $this->load->view('front/index',$component,TRUE);

        $data['menu'] = $this->load->view('template/menu','',TRUE);
        $data['header'] = $this->load->view('template/header','',TRUE);
        $data['footer'] = $this->load->view('template/footer','',TRUE);

        $this->load->view('front',$data);
    }
}