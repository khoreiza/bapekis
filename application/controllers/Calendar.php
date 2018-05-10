<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');


class Calendar extends CI_Controller {
    
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
    
    public function index()
    {
        $user = $this->session->userdata('userbapekis');
        $this->muser->insert_user_access_log("Access Calendar of Event");

        /******* LATEST EVENT *******/
        $data['latest_events'] = $this->mcalendar->get_latest_event(6,$user['group'],$user['position'],'last');
        $data['latest_event'] = $this->load->view('calendar/component/index/_latest_event', $data,TRUE);
        /******* LATEST EVENT *******/
        
        $data['title'] = "Calendar of Event - Bapekis";

        $data['header'] = $this->load->view('admin/shared/first/header','',TRUE);   
        $data['footer'] = $this->load->view('admin/shared/first/footer','',TRUE);
        $data['content'] = $this->load->view('calendar/index',$data,TRUE);

        $this->load->view('admin/shared/front',$data);
    }

    public function get_event()
    {
    	$date = $this->input->post('date');
        $month_year = $this->input->post('month_year');


        if($month_year){
            $month = explode("-", $month_year)[1];
            $year = explode("-", $month_year)[0];
        }
        
        if($date){
            $date = DateTime::createFromFormat('Y-m-j', $this->input->post('date'))->format('Y-m-d');
            $month = explode("-", $this->input->post('date'))[1];
            $year = explode("-", $this->input->post('date'))[0];
        }

		$user = $this->session->userdata('userbapekis');
		$user_dir_id = "";
        //$user_dir = $this->mfiles_upload->get_db("id",'asc','cbdirectorate',array('directorate' => $user['directorate']),'','');
        
        //if($user_dir){
        	//$user_dir_id = $user_dir[0]->id;

        	if(!$date){
                if(!isset($month)) $month = date("m");
                $this->db->where('(month(start) = '.$month.' OR (month(end) = '.$month.') )');

                if(!isset($year)) $year = date("Y");
                $this->db->where('(Year(start) = '.$year.' OR (Year(end) = '.$year.') )');

                $data['date_title'] = date('F Y', mktime(0, 0, 0, $month, 1,$year));
            }else{
                $this->db->where("(Date(start) = '$date' OR Date(end) = '$date' OR (Date(end) > '$date' AND Date(start) < '$date') )");
                $data['date_title'] = date('j F Y', strtotime($date));
            }
              	
        	
        	$arr_where = "";//array("directorate_id" => $user_dir_id);

            //$this->db->where('(use_booking is NULL OR use_booking = 0)');

			$files_upload_table_sharing = "(SELECT `files_upload`.full_url,ownership_id from files_upload where modul = 'photo' and sub_modul = 'calendar') as files_upload";
        	$join_sharing[0] = array('table' => $files_upload_table_sharing, 'in' => "files_upload.ownership_id = calendar.id", 'how' => 'left');
       		$join_sharing[1] = array('table' => 'user', 'in' => "user.id = calendar.created_by");
        	$data['events'] = $this->mfiles_upload->get_db_join('start','asc','calendar',$arr_where,'calendar.*, user.full_name, user.profile_picture, user.nik, files_upload.full_url',"",'calendar.id',$join_sharing);

        	//$data['events'] = $this->mfiles_upload->get_db_join("start",'asc','calendar',$arr_where,"","","",'');	
        	
        //}
    	
    	$data['month'] = $month; $data['year'] = $year;

    	$data['status'] = 1;
        $data['html'] = $this->load->view('calendar/component/index/_events', $data,TRUE);
        $this->output->set_content_type('application/json')
                         ->set_output(json_encode($data));
    }

    public function get_month_calendar()
    {
        $month = $this->input->get('month');
        $year = $this->input->get('year');

        $user = $this->session->userdata('userbapekis');
        $user_dir_id = "";
        //$user_dir = $this->mfiles_upload->get_db("id",'asc','cbdirectorate',array('directorate' => $user['directorate']),'','');
        
        //if($user_dir){
            //$user_dir_id = $user_dir[0]->id;


            if(!$month) $month = date("m");
            $this->db->where('(month(start) = '.$month.' OR (month(end) = '.$month.') )');

            if(!$year) $year = date("Y");
            $this->db->where('(Year(start) = '.$year.' OR (Year(end) = '.$year.') )');

            $arr_where = "";//array("directorate_id" => $user_dir_id);

            //$this->db->where('(use_booking is NULL OR use_booking = 0)');

            $files_upload_table_sharing = "(SELECT `files_upload`.full_url,ownership_id from files_upload where modul = 'photo' and sub_modul = 'calendar') as files_upload";
            $join_sharing[0] = array('table' => $files_upload_table_sharing, 'in' => "files_upload.ownership_id = calendar.id", 'how' => 'left');
            $join_sharing[1] = array('table' => 'user', 'in' => "user.id = calendar.created_by");
            
            $events = $this->mfiles_upload->get_db_join('start','asc','calendar',$arr_where,'calendar.*, user.full_name, user.profile_picture, user.nik, files_upload.full_url',"",'calendar.id',$join_sharing);

            $prev_date = ""; $arr_event_date = array();
            if(isset($events) && $events){
                foreach($events as $event){
                    $start_day = date("j",strtotime($event->start));
                    
                    if($event->end) $end_day = date("j",strtotime($event->end));
                    else $end_day = "";

                    if(!$end_day || (date("Y-m-d",strtotime($event->start)) == date("Y-m-d",strtotime($event->end)))){
                        if(!in_array($start_day, $arr_event_date)) $arr_event_date[count($arr_event_date)+1] = $start_day;
                    }else{
                        if(date("m",strtotime($event->start)) == date("m",strtotime($event->end))){
                            for($z=$start_day;$z<=$end_day;$z++){
                                if(!in_array($z, $arr_event_date)) $arr_event_date[count($arr_event_date)+1] = $z;
                            }
                        }else{
                            $end_of_month = $number = cal_days_in_month(CAL_GREGORIAN, $month, $year);
                            for($z=$start_day;$z<=$end_of_month;$z++){
                                if(!in_array($z, $arr_event_date)) $arr_event_date[count($arr_event_date)+1] = $z;
                            }
                        }
                    }
                }
            }

            $data['arr_event_date'] = $arr_event_date;
            $data['month'] = $month; $data['year'] = $year;

            $data['status'] = 1;
            $data['html'] = $this->load->view('calendar/component/index/_calendar', $data,TRUE);
        /*}else{
            $data['status'] = 0;
        }*/    
        $this->output->set_content_type('application/json')
                             ->set_output(json_encode($data));

    }

    public function show()
    {
        $id = $this->uri->segment(3);
        $user = $this->session->userdata('userbapekis');
        //$unit = $this->muser->get_user_unit();

        /****** GET EVENT FROM ID ******/
        $arr_where = array("calendar.id" => $id);

        $files_upload_table_sharing = "(SELECT `files_upload`.full_url,ownership_id from files_upload where modul = 'photo' and sub_modul = 'calendar') as files_upload";
        $join_sharing[0] = array('table' => $files_upload_table_sharing, 'in' => "files_upload.ownership_id = calendar.id", 'how' => 'left');
        $join_sharing[1] = array('table' => 'user', 'in' => "user.id = calendar.created_by");
        $event = $this->mfiles_upload->get_db_join('start','asc','calendar',$arr_where,'calendar.*, user.full_name, user.profile_picture, user.nik, files_upload.full_url',"",'calendar.id',$join_sharing);
        /****** END OF GET EVENT FROM ID ******/

        if($event && $id){
            $data['event'] = $event[0];
            $this->muser->insert_user_access_log("Access Calendar of Event, ".$data['event']->title);

            
            /******* Files Upload Section ********/
        
            // Set the parameter
            $files_upload['modul'] = "calendar";
            $files_upload['submodul'] = "event";
            $files_upload['ownership_id'] = $data['event']->id;
            $files_upload['count_file'] = 5;

            // Get the Files
            $arr_where_files = array("ownership_id" => $files_upload['ownership_id']);
            $files_upload['publications'] = $this->mfiles_upload->get_publication_files_where($files_upload['modul'],$files_upload['submodul'],$files_upload['count_file'], $arr_where_files);

            // List of View
            $data['list_files_view'] = $this->load->view('files_upload/theme/broventh/_list_files', $files_upload,TRUE);
            $data['files_upload'] = $this->load->view('files_upload/theme/broventh/_files_upload_box', $data,TRUE);
            /******* End of Files Upload Section ********/


            /******** EVENT DOCUMENTATION *********/
            $data['documentations'] = $this->mfiles_upload->get_files_upload_by_ownership_id_order('event', 'documentation', $id, "id", "asc");
            $data['list_of_documentation'] = $this->load->view('calendar/component/show/_list_of_documentation',$data,TRUE);
            /******** END of EVENT DOCUMENTATION *********/


            /******** EVENT NEWS *********/
            $arr_where_news = array("news.ownership_id" => $id, 'news.modul' => 'calendar news');

            $files_upload_table_news = "(SELECT `files_upload`.full_url,ownership_id from files_upload where modul = 'photo' and sub_modul = 'calendar news') as files_upload";
            $join_news[0] = array('table' => $files_upload_table_news, 'in' => "files_upload.ownership_id = news.id", 'how' => 'left');
            $join_news[1] = array('table' => 'user', 'in' => "user.id = news.user_id");
            $data['news'] = $this->mfiles_upload->get_db_join('id','desc','news',$arr_where_news,'news.*, user.full_name, user.profile_picture, user.nik, files_upload.full_url',"",'',$join_news);

            /******** END OF EVENT NEWS *********/
            


            $data['title'] = $data['event']->title." - Bapekis";

            $data['header'] = $this->load->view('admin/shared/first/header','',TRUE);   
            $data['footer'] = $this->load->view('admin/shared/first/footer','',TRUE);
            $data['content'] = $this->load->view('calendar/show',$data,TRUE);

            $this->load->view('admin/shared/front',$data);


        }else{
            redirect('calendar');
        } 
    }


    
    public function show_calendar_form(){
        $id = $this->input->get('id');
		$user = $this->session->userdata('userbapekis');

        $data['modul'] = $this->input->get('modul');
        $data['ownership_id'] = $this->input->get('ownership_id');

		/*$join[0] = array('table' => 'cbdirectorate','in' => 'cbdirectorate.id = cbgroup.cbdirectorate_id');
    	$data['arr_group'] = $this->mfiles_upload->get_db_join("group_name asc, sort",'asc','cbgroup',array('directorate' => $user['directorate']),"cbgroup.*","","",$join);

    	$data['arr_position'] = $this->mfiles_upload->get_db_group_by("priority",'asc','user',array('directorate' => $user['directorate']),"","","position");
        */

		$data['calendar'] = "";
		if($id){
			$data['calendar'] = $this->mcalendar->get_calendar_by_id($id);
		}

		
		$data['popup_content'] = $this->load->view('calendar/component/index/_form_event', $data,TRUE);
        $data['popup_title'] = "Form Calendar of Event"; 
        $data['popup_width'] = "880px";

        $data['status'] = 1;
        $data['html'] = $this->load->view('admin/shared/component/_popup_page', $data,TRUE);
        $this->output->set_content_type('application/json')
                         ->set_output(json_encode($data));
    }
    
	
	
	public function submit_calendar(){
      	$id = $this->uri->segment(3);
      	$user = $this->session->userdata('userbapekis');

        $arr = array('title','category','description','location','modul','ownership_id');
        $program = $this->mfiles_upload->get_form_element($arr);

        //$user_dir = $this->mfiles_upload->get_db("id",'asc','cbdirectorate',array('directorate' => $user['directorate']),'','');
        //$program['directorate_id'] = $user_dir[0]->id;
        
		/*$program['group_allowed'] = "";
		if($this->input->post('group_allowed')){
            foreach($this->input->post('group_allowed') as $ga){
                if(!$program['group_allowed']) $program['group_allowed'] = ";";

                $program['group_allowed'] = $program['group_allowed'].$ga.";";
            }
        }
        
        $program['position_allowed'] = "";
		if($this->input->post('position_allowed')){
            foreach($this->input->post('position_allowed') as $pa){
                if(!$program['position_allowed']) $program['position_allowed'] = ";";
                $program['position_allowed'] = $program['position_allowed'].$pa.";";
            }    
        }*/
        
        
        if($this->input->post('start')){$start = DateTime::createFromFormat('m/d/Y', $this->input->post('start'));
    		$program['start'] = $start->format('Y-m-d')." ".$this->input->post('start_time').":00";
    	}
    	
    	if($this->input->post('end')) $end = DateTime::createFromFormat('m/d/Y', $this->input->post('end'));
    	else $end = DateTime::createFromFormat('m/d/Y', $this->input->post('start'));
    	$program['end'] = $end->format('Y-m-d')." ".$this->input->post('end_time').":00";

    	$program['updated_by'] = $user['id'];
        $program['updated_at'] = date("Y-m-d H:i");


        /****** UPDATES PARAMETER ******
        $updates['directorate_id'] = $program['directorate_id'];
        $updates['group_allowed'] = $program['group_allowed'];
        $updates['position_allowed'] = $program['position_allowed'];
        */
        if($id){
        	$cal_id = $id;
			if(!$this->mcalendar->update_calendar($program,$id)){
				redirect('calendar');
            	//$update_id = $this->mfiles_upload->get_db("id","desc","updates",array('ownership_id' => $id, 'sub_modul' => "Calendar of Event"),"","")[0]->id;
            	//$this->mupdates->update($updates,$update_id);
			}
        }
        else{
        	$program['created_by'] = $user['id'];
        	$program['created_at'] = date("Y-m-d H:i");
        	$cal_id = $this->mcalendar->insert_calendar($program);
        	
            /*INSERT UPDATES*
            $updates['user_id'] = $user['id'];
            $updates['date'] = date("Y-m-d H:i:s");
            $updates['modul'] = "Internal Information";
            $updates['sub_modul'] = "Calendar of Event";
            $updates['ownership_id'] = $cal_id;
            $this->mupdates->insert($updates);
            /*END OF INSERT UPDATES*/
			
            if(!$cal_id){redirect('calendar/input_calendar/');}
        }
		
		/************ Upload Attachment *************/
		$path = "calendar/".$cal_id."/attachment/";
        
        //Attachment
        if(isset($_FILES['attachment']) && !($_FILES['attachment']['error'] == UPLOAD_ERR_NO_FILE)){
            /*Upload */
            $file = $this->mfiles_upload->upload_files("attachment",$path,'calendar','event',$cal_id,true,false);
        }

       /*** Photo Banner ***/
        $this->upload->reset_multi_upload_data();
        if(isset($_FILES['img']) && !($_FILES['img']['error'] == UPLOAD_ERR_NO_FILE)){
            /*Upload */ 
            $file = $this->mfiles_upload->upload_files("img",$path,'photo','calendar',$cal_id,true,true);
        }
        /************ End of Upload Attachment *************/

		redirect('calendar/show/'.$cal_id);
		
    }


    public function delete_event(){
        $id = $this->input->post('id');
        if($this->mcalendar->delete_calendar($id)){
        
        }
        $json['status'] = 1;
        $this->output->set_content_type('application/json')
                     ->set_output(json_encode($json));
    }
    
    public function change_month(){
    	$month = $this->input->post('month');
    	$year = $this->input->post('year');
    	redirect('calendar/view/'.$month."/".$year);
    }
    
    public function get_detail(){
       	$id = $this->input->get('id');
    	$calendar['calendar'] = $this->mcalendar->get_calendar_by_id($id);
		$calendar['attachments'] = $this->mfiles_upload->get_files_upload_by_ownership_id("calendar", 'event', $id);
    	$calendar['documentations'] = $this->mfiles_upload->get_files_upload_by_ownership_id_order('event', 'documentation', $id, "id", "asc");
		$calendar['list_of_documentation'] = $this->load->view('calendar/_list_of_documentation',$calendar,TRUE);
		
		$this->muser->insert_user_access_log("Access Calendar of Event, ".$calendar['calendar']->title);

		if($calendar){
			$json['status'] = 1;
            $json['message'] = $this->load->view('calendar/_detail_content',$calendar,TRUE);
            $json['title'] = $calendar['calendar']->title;
		}else{
			$json['status'] = 0;
		}
		$this->output->set_content_type('application/json')
                     ->set_output(json_encode($json));
	}
	
	public function input_event_documentation(){
		$id = $this->uri->segment(3);
		if(!$id){redirect('calendar/view');}
		$data['title'] = "Event Documentation - CBIC";
		$data['calendar'] = $this->mcalendar->get_calendar_by_id($id);
		$data['documentations'] = $this->mfiles_upload->get_files_upload_by_ownership_id_order('event', 'documentation', $id, "id", "asc");
		
		$data['list_of_documentation'] = $this->load->view('calendar/_list_of_documentation',$data,TRUE);
		
		$data['header'] = $this->load->view('shared/header','',TRUE);	
		$data['footer'] = $this->load->view('shared/footer','',TRUE);
		$data['content'] = $this->load->view('calendar/input_event_documentation',$data,TRUE);

		$this->load->view('front',$data);
	}
	
	public function submit_event_documentation(){
		$id = $this->uri->segment(3);
    	$upload_path = "assets/uploads/calendar/documentation/".$id."/";
		$config = upload_config_full_url($upload_path);
		$this->load->library('upload', $config);

        if($id){
			if ($this->upload->do_multi_upload("photos")){
				$attachments = $this->upload->get_multi_upload_data();
				foreach($attachments as $atch){
					$this->mfiles_upload->insert_files_upload_with_full_url($upload_path,"event", "documentation", $atch, $id);
					//make thumbnail
					$photoname = $atch['file_name'];
					$target_folder = $upload_path;
					$photolocation = $target_folder.$photoname;
					
					$this->make_photo_thumb($photoname,$photolocation,$target_folder,272,'_thumbnail.jpg');
				}
				$json['status'] = 1;
				$data['calendar'] = $this->mcalendar->get_calendar_by_id($id);
				$data['documentations'] = $this->mfiles_upload->get_files_upload_by_ownership_id_order('event', 'documentation', $id, "id", "asc");
	
				$json['result'] = $this->load->view('calendar/component/show/_list_of_documentation',$data,TRUE);
				$this->output->set_content_type('application/json')
				 ->set_output(json_encode($json));
			}
        }
	}
	
	private function make_photo_thumb($image_name, $image_location, $target_folder, $w_thumb, $ext_thumb_name){
        $thumbnail = $target_folder.'thumb/'.$image_name.$ext_thumb_name;  // Set the thumbnail name
        make_dir($target_folder.'thumb/');
        // Get new sizes
        $upload_image = $image_location;
        list($width, $height) = getimagesize($upload_image);
        $newwidth = $w_thumb;
        $newheight = $w_thumb*$height/$width;
        
        // Load the images
        $thumb = imagecreatetruecolor($newwidth, $newheight);
        
        $stype = explode(".", $image_name);
        $stype = $stype[count($stype)-1];
        switch($stype) {
            case 'gif':
                $source = imagecreatefromgif($upload_image);
                break;
            case 'jpg':
                $source = imagecreatefromjpeg($upload_image);
                break;
            case 'jpeg':
                $source = imagecreatefromjpeg($upload_image);
                break;
            case 'JPG':
                $source = imagecreatefromjpeg($upload_image);
                break;    
            case 'png':
                $source = imagecreatefrompng($upload_image);
                break;
        }
        // Resize the $thumb image.
        imagecopyresampled($thumb, $source, 0, 0, 0, 0, $newwidth, $newheight, $width, $height);
        
        // Save the new file to the location specified by $thumbnail
        imagejpeg($thumb, $thumbnail, 80);
    }
}
