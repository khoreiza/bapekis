<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Front extends CI_Controller {

    public function index(){

        $data['title'] = "Mandiri Bapekis Front Page";
        
        $datakemenag = file_get_contents('https://bimasislam.kemenag.go.id/widget/jadwalshalat/42d38931fbd98d4764cc39ab8694a0f1f42d2e7d');

        preg_match_all("'<div class=\"pukul\"> (.*?)</div>'si",$datakemenag, $jadwal);

        $prayer_schedule['jadwalsholat'] = $jadwal[1];

        $component['banner'] = $this->load->view('front/component/slider','',TRUE);
        $component['prayer_schedule'] = $this->load->view('front/component/prayer_schedule',$prayer_schedule,TRUE);
        $component['news'] = $this->load->view('front/component/news','',TRUE);
        $component['event_latest'] = $this->load->view('front/component/event_latest','',TRUE);
        $component['event_upcoming'] = $this->load->view('front/component/event_upcoming','',TRUE);

        $data['content'] = $this->load->view('front/index',$component,TRUE);

        $data['menu'] = $this->load->view('template/menu','',TRUE);
        $data['header'] = $this->load->view('template/header','',TRUE);
        $data['footer'] = $this->load->view('template/footer','',TRUE);

        $this->load->view('front',$data);
    }
}