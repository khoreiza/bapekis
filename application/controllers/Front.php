<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Front extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model(array('mmysharing'));
    }

    public function index(){

        $data['title'] = "Mandiri Bapekis Front Page";
        
        $datakemenag = file_get_contents('https://bimasislam.kemenag.go.id/widget/jadwalshalat/42d38931fbd98d4764cc39ab8694a0f1f42d2e7d');

        preg_match_all("'<div class=\"pukul\"> (.*?)</div>'si",$datakemenag, $jadwal);

        $prayer_schedule['jadwalsholat'] = $jadwal[1];

        $page = file_get_contents('https://jadwalsholat.pkpu.or.id');
        preg_match_all("'<tr class=\"table_light\" align=\"center\">(.*?)</tr>|<tr class=\"table_dark\" align=\"center\">(.*?)</tr>|<tr class=\"table_highlight\" align=\"center\">(.*?)</tr>'", $page, $agent_name);
        
        echo "<table style='border: 1px solid black;'>";
        foreach ($agent_name[0] as $key => $value) {
            //preg_match_all("'<td>(.*?)</td>'", $value, $tes);
            echo $value;
        }
        echo "</table>";
        die();


        /******* GET BAPEKIS SHARING *******/
        $latest_sharing['sharings'] = $this->mmysharing->get_detil("all",5,0,"");


        /******* GET BAPEKIS EVENT *******/
        $upcoming_event['events'] = $this->mfiles_upload->get_db('start','desc','calendar','','',"");



        $component['banner'] = $this->load->view('front/component/slider','',TRUE);
        $component['prayer_schedule'] = $this->load->view('front/component/prayer_schedule',$prayer_schedule,TRUE);
        $component['news'] = $this->load->view('front/component/news','',TRUE);
        $component['latest_sharing'] = $this->load->view('front/component/latest_sharing',$latest_sharing,TRUE);
        $component['event_upcoming'] = $this->load->view('front/component/upcoming_event',$upcoming_event,TRUE);

        $data['content'] = $this->load->view('front/index',$component,TRUE);

        $data['menu'] = $this->load->view('template/menu','',TRUE);
        $data['header'] = $this->load->view('template/header','',TRUE);
        $data['footer'] = $this->load->view('template/footer','',TRUE);

        $this->load->view('front',$data);
    }
}