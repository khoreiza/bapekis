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

        
        /****** GET HADIST DATA *******/
        
        $arr_where_hadist = array("category" => "Hadist");

        $join_hadist[0] = array('table' => 'category', 'in' => "mysharing.category_id = category.id",'how' => 'left');
        $data['hadists'] = $this->mfiles_upload->get_db_join('id','desc','mysharing',$arr_where_hadist,'mysharing.*, mysharing.id as mysharing_id,category.category',"",'',$join_hadist);

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



        $data['content'] = $this->load->view('ramadhan/index',$data,TRUE);

        $data['menu'] = $this->load->view('template/menu','',TRUE);
        $data['header'] = $this->load->view('template/header','',TRUE);
        $data['footer'] = $this->load->view('template/footer','',TRUE);

        $this->load->view('front',$data);
    }

    public function get_mosque_data(){

        $mosque_id = $this->input->get('mosque_id');

        /******** GET MOSQUE DATA *********/
        
        $join_mq[0] = array('table' => 'files_upload','in' => "ownership_id = mosque.id AND modul = 'mosque' AND sub_modul = 'mosque_photo'", 'how' => 'left');
        $arr_where = array('mosque.id' => $mosque_id);
        $data['mosque'] = $this->mfiles_upload->get_db_join('name','asc','mosque',$arr_where,'mosque.*, mosque.id as mosque_id, files_upload.full_url','','',$join_mq)[0];
        
        /******** END GET MOSQUE DATA *********/



        /****** GET TODAY EVENT ******/
        $arr_where_ev = array("calendar.ownership_id" => $mosque_id, "calendar.modul" => 'mosque');

        $this->db->where('DATE(start)','2019-05-06');
        
        $join_ev[0] = array('table' => 'files_upload','in' => "files_upload.ownership_id = calendar.id AND files_upload.modul = 'photo' AND files_upload.sub_modul = 'calendar'", 'how' => 'left');
        $join_ev[1] = array('table' => 'category','in' => "calendar.category_id = category.id", 'how' => 'left');
        $data['events'] = $this->mfiles_upload->get_db_join('start','asc','calendar',$arr_where_ev,'calendar.*, files_upload.full_url, category.category',"",'calendar.id',$join_ev);

        /****** END GET TODAY EVENT ******/
        

        

        /****** GET TODAY TAKJIL ******/
        $arr_where_sharing = array("mysharing.mosque_id" => $mosque_id,'category_id' => 1);

        $files_upload_table_news = "(SELECT `files_upload`.full_url,ownership_id from files_upload where modul = 'my sharing' and sub_modul = 'banner') as files_upload";
        $join_sharing[0] = array('table' => $files_upload_table_news, 'in' => "files_upload.ownership_id = mysharing.id", 'how' => 'left');
        $join_sharing[1] = array('table' => 'category', 'in' => "mysharing.category_id = category.id",'how' => 'left');
        $data['takjils'] = $this->mfiles_upload->get_db_join('id','desc','mysharing',$arr_where_sharing,'mysharing.*, mysharing.id as mysharing_id, files_upload.full_url, category.category',"",'',$join_sharing);
        /****** END GET TODAY TAKJIL ******/




        


        /****** GET EVENT ******/
        $arr_where_event = array("calendar.ownership_id" => $mosque_id, "calendar.modul" => 'mosque');

        //Latest Event
        $this->db->where('start <',date('Y-m-d'));
        $latest_events = $this->mfiles_upload->get_db_join('start','desc','calendar',$arr_where_event,'',"",'','');
        foreach($latest_events as $k=>$lat){
            $data['latest_events'][$k]['event'] = $lat;
            $data['latest_events'][$k]['photos'] = $this->mfiles_upload->get_files_upload_by_ownership_id_order('calendar','gallery',$lat->id, "created_at", "desc");
        }

        //Upcoming Event
        $this->db->where('start >',date('Y-m-d'));
        $data['upcoming_events'] = $this->mfiles_upload->get_db_join('start','asc','calendar',$arr_where_event,'',"",'','');
        $data['event_view'] = $this->load->view('mosque/component/show/content/_event',$data,TRUE);
        /****** END OF GET EVENT ******/



        /****** GET FINANCIAL ******/
        //Summary Performance
        $select_financial = "*, sum(case when (type = 'Outcome') then `amount` else 0 end) sum_outcome, sum(case when (type = 'Income') then `amount` else 0 end) sum_income";
        $summary = $this->mfiles_upload->get_db_join('type','asc','financial_cashflow',array('mosque_id' => $mosque_id),$select_financial,"",'','');
        if($summary) $data['summary'] = $summary[0];

        //List Performance
        $data['cashflows'] = $this->mfiles_upload->get_db_join('date','desc','financial_cashflow',array('mosque_id' => $mosque_id),'',"",'','');
        
        //Growth Performance
        $select_growth = "*, sum(case when (type = 'Outcome') then `amount`*-1 else `amount` end) sum_amount, sum(case when (type = 'Income') then `amount` else 0 end) sum_income, sum(case when (type = 'Outcome') then `amount` else 0 end) sum_outcome";
        $data['growth'] = $this->mfiles_upload->get_db_join('date','asc','financial_cashflow',array('mosque_id' => $mosque_id),$select_growth,"",'month(date)','');

        $data['financial_view'] = $this->load->view('mosque/component/show/content/_financial',$data,TRUE);
        /****** END OF GET FINANCIAL ******/



        /****** GET SHARING ******/
        $arr_where_sharing = array("mysharing.mosque_id" => $mosque_id);

        $files_upload_table_news = "(SELECT `files_upload`.full_url,ownership_id from files_upload where modul = 'my sharing' and sub_modul = 'banner') as files_upload";
        $join_sharing[0] = array('table' => $files_upload_table_news, 'in' => "files_upload.ownership_id = mysharing.id", 'how' => 'left');
        $join_sharing[1] = array('table' => 'user', 'in' => "user.id = mysharing.created_by");
        $join_sharing[2] = array('table' => 'category', 'in' => "mysharing.category_id = category.id",'how' => 'left');
        $data['sharings'] = $this->mfiles_upload->get_db_join('id','desc','mysharing',$arr_where_sharing,'mysharing.*, mysharing.id as mysharing_id, user.full_name, user.profile_picture, user.nik, files_upload.full_url, category.category',"",'',$join_sharing);
        $data['sharing_view'] = $this->load->view('mosque/component/show/content/_sharing_news',$data,TRUE);
        /****** END OF GET SHARING ******/



        /******* Files Upload Section ********/
        
        // Set the parameter
        $files_upload['modul'] = "mosque";
        $files_upload['submodul'] = "mosque_files";
        $files_upload['ownership_id'] = $mosque_id;
        $files_upload['count_file'] = 5;

        // Get the Files
        $arr_where_files = array("ownership_id" => $files_upload['ownership_id']);
        $files_upload['publications'] = $this->mfiles_upload->get_publication_files_where($files_upload['modul'],$files_upload['submodul'],$files_upload['count_file'], $arr_where_files);

        // List of View
        $data['list_files_view'] = $this->load->view('files_upload/theme/broventh/_list_files', $files_upload,TRUE);
        $data['files_upload'] = $this->load->view('files_upload/theme/broventh/_files_upload_box', $data,TRUE);

        $data['files_view'] = $this->load->view('mosque/component/show/content/_files',$data,TRUE);
        /******* End of Files Upload Section ********/


        $json['status'] = 1;
        $json['mosque_content'] = $this->load->view('ramadhan/component/index/_mosque',$data,TRUE);

        $this->output->set_content_type('application/json')
                     ->set_output(json_encode($json));
    }
}