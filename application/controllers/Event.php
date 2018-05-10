<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Event extends CI_Controller {

    public function index(){

        $data['title'] = "Mandiri Bapekis Event Page";

        $component['banner'] = $this->load->view('event/component/banner','',TRUE);
        $component['event'] = $this->load->view('event/component/event','',TRUE);

        $data['content'] = $this->load->view('event/index',$component,TRUE);

        $data['menu'] = $this->load->view('template/menu','',TRUE);
        $data['header'] = $this->load->view('template/header','',TRUE);
        $data['footer'] = $this->load->view('template/footer','',TRUE);

        $this->load->view('front',$data);
    }
}