<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Ramadhan extends CI_Controller {

	public function __construct() {
        parent::__construct();
        $this->load->model(array('muser','mfiles_upload','mmysharing','muser_activity'));
        date_default_timezone_set("Asia/Bangkok");
	
    }

    public function index(){

        $data['title'] = "Mandiri Bapekis General Info Page";

        $data['banner'] = $this->load->view('ramadhan/component/banner','',TRUE);

        
        /******* GET PRAYER SCHEDULE *******/
        $datakemenag = file_get_contents('https://bimasislam.kemenag.go.id/widget/jadwalshalat/42d38931fbd98d4764cc39ab8694a0f1f42d2e7d');
        preg_match_all("'<div class=\"pukul\"> (.*?)</div>'si",$datakemenag, $jadwal);
        $prayer_schedule['jadwalsholat'] = $jadwal[1];
        //$prayer_schedule = '';
        $data['prayer_schedule_view'] = $this->load->view('ramadhan/component/index/_prayer_schedule',$prayer_schedule,TRUE);
        /******* END GET PRAYER SCHEDULE *******/


        /****** GET HADIST DATA *******/
        
        $arr_where_hadist = "";//array("category" => "Hadist");

        $join_hadist[0] = array('table' => 'category', 'in' => "dalil.category_id = category.id",'how' => 'left');
        $data['hadists'] = $this->mfiles_upload->get_db_join('rand()','','dalil',$arr_where_hadist,'dalil.*,category.category',"2",'',$join_hadist);

        /************* END of GET HADIST DATA *************/



        /****** GET PERNIK RAMADHAN ******/
        $arr_where_sharing = array('category_id' => 10);

        $files_upload_table_news = "(SELECT `files_upload`.full_url,ownership_id from files_upload where modul = 'my sharing' and sub_modul = 'banner') as files_upload";
        $join_sharing[0] = array('table' => $files_upload_table_news, 'in' => "files_upload.ownership_id = mysharing.id", 'how' => 'left');
        $join_sharing[1] = array('table' => 'category', 'in' => "mysharing.category_id = category.id",'how' => 'left');
        $data['sharings'] = $this->mfiles_upload->get_db_join('id','desc','mysharing',$arr_where_sharing,'mysharing.*, mysharing.id as mysharing_id, files_upload.full_url, category.category',"",'',$join_sharing);
        /****** END GET PERNIK RAMADHAN ******/

        

        /************ GET FILTER MASJID ***********/
        $data['mosques'] = $this->mfiles_upload->get_db_join('id','asc','mosque','','','','','');
        /************ END of GET FILTER MASJID ***********/



        /******* GET BAPEKIS EVENT *******/
        $arr_where_ev = array('category.category' => array('Ramadhan Event'));
        //$this->db->where_in('category.category',array('Ramadhan Event'));
        $join_ev[0] = array('table' => 'files_upload','in' => "files_upload.ownership_id = calendar.id AND files_upload.modul = 'calendar' AND files_upload.sub_modul = 'banner'", 'how' => 'left');
        $join_ev[1] = array('table' => 'category','in' => "calendar.category_id = category.id", 'how' => 'left');
        $data['events'] = $this->mfiles_upload->get_db_join('start','asc','calendar',$arr_where_ev,'calendar.*, files_upload.full_url, category.category, calendar.id as calendar_id',"",'calendar.id',$join_ev);

        //GET RANDOM BIG EVENT
        $this->db->where_in('category.category',array('Ramadhan Event'));
        $this->db->where('calendar.id','66');
        $data['big_event'] = $this->mfiles_upload->get_db_join('rand()','','calendar',$arr_where_ev,'calendar.*, files_upload.full_url, category.category, calendar.id as calendar_id',"",'calendar.id',$join_ev)[0];

        $data['event_view'] = $this->load->view('ramadhan/component/index/_event',$data,TRUE);
        /******* END GET BAPEKIS EVENT *******/


        $data['content'] = $this->load->view('ramadhan/index',$data,TRUE);

        $data['menu'] = $this->load->view('template/menu','',TRUE);
        $data['header'] = $this->load->view('template/header','',TRUE);
        $data['footer'] = $this->load->view('template/footer','',TRUE);

        $this->load->view('front',$data);
    }

    public function get_mosque_data(){

        $mosque_id = $this->input->get('mosque_id');
        $today = date('Y-m-d');

        /******** GET MOSQUE DATA *********/
        
        $join_mq[0] = array('table' => 'files_upload','in' => "ownership_id = mosque.id AND modul = 'mosque' AND sub_modul = 'mosque_photo'", 'how' => 'left');
        $arr_where = array('mosque.id' => $mosque_id);
        $data['mosque'] = $this->mfiles_upload->get_db_join('name','asc','mosque',$arr_where,'mosque.*, mosque.id as mosque_id, files_upload.full_url','','',$join_mq)[0];

        
        /******** END GET MOSQUE DATA *********/



        /****** GET TODAY EVENT ******/
        $arr_where_ev = array("calendar.ownership_id" => $mosque_id, "calendar.modul" => 'mosque','DATE(start)' => $today);

        //$this->db->where('DATE(start)',date(''));
        
        $join_ev[0] = array('table' => 'files_upload','in' => "files_upload.ownership_id = calendar.id AND files_upload.modul = 'photo' AND files_upload.sub_modul = 'calendar'", 'how' => 'left');
        $join_ev[1] = array('table' => 'category','in' => "calendar.category_id = category.id", 'how' => 'left');
        $data['events'] = $this->mfiles_upload->get_db_join('start','asc','calendar',$arr_where_ev,'calendar.*, files_upload.full_url, category.category',"",'calendar.id',$join_ev);

        /****** END GET TODAY EVENT ******/
        

        

        /****** GET TODAY TAKJIL ******/
        $arr_where_sharing = array("mysharing.mosque_id" => $mosque_id,'category_id' => array('1','11'),'date' => $today);

        $files_upload_table_news = "(SELECT `files_upload`.full_url,ownership_id from files_upload where modul = 'my sharing' and sub_modul = 'banner') as files_upload";
        $join_sharing[0] = array('table' => $files_upload_table_news, 'in' => "files_upload.ownership_id = mysharing.id", 'how' => 'left');
        $join_sharing[1] = array('table' => 'category', 'in' => "mysharing.category_id = category.id",'how' => 'left');
        $data['takjils'] = $this->mfiles_upload->get_db_join('category.category','asc','mysharing',$arr_where_sharing,'mysharing.*, mysharing.id as mysharing_id, files_upload.full_url, category.category',"",'',$join_sharing);
        /****** END GET TODAY TAKJIL ******/


        $json['status'] = 1;
        $json['mosque_info'] = $this->load->view('ramadhan/component/index/_mosque_info',$data,TRUE);
        $json['mosque_content'] = $this->load->view('ramadhan/component/index/_mosque_content',$data,TRUE);

        $this->output->set_content_type('application/json')
                     ->set_output(json_encode($json));
    }







    public function lomba(){

        $data['title'] = "Lomba Ramadhan";

        $data['banner'] = $this->load->view('ramadhan/component/banner','',TRUE);

        
        /******* GET PRAYER SCHEDULE *******/
        $datakemenag = file_get_contents('https://bimasislam.kemenag.go.id/widget/jadwalshalat/42d38931fbd98d4764cc39ab8694a0f1f42d2e7d');
        preg_match_all("'<div class=\"pukul\"> (.*?)</div>'si",$datakemenag, $jadwal);
        $prayer_schedule['jadwalsholat'] = $jadwal[1];
        //$prayer_schedule = '';
        $data['prayer_schedule_view'] = $this->load->view('ramadhan/component/index/_prayer_schedule',$prayer_schedule,TRUE);
        /******* END GET PRAYER SCHEDULE *******/


        $data['content'] = $this->load->view('ramadhan/lomba',$data,TRUE);

        $data['menu'] = $this->load->view('template/menu','',TRUE);
        $data['header'] = $this->load->view('template/header','',TRUE);
        $data['footer'] = $this->load->view('template/footer','',TRUE);

        $this->load->view('front',$data);
    }








    public function love_takjil(){

        $takjil_id = $this->input->get('takjil_id');
        
        $data['takjil_id'] = $takjil_id;
        $data['created_at'] = date('Y-m-d H:i:s');

        $love_id = $this->mfiles_upload->insert_db($data,'takjil_love');

        $json['status'] = 1;
        
        $this->output->set_content_type('application/json')
                     ->set_output(json_encode($json));
    }
}