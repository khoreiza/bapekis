<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Front extends CI_Controller {

    public function index(){

        $data['title'] = "Mandiri Bapekis Front Page";

        $component['banner'] = $this->load->view('front/component/slider','',TRUE);
        $component['news'] = $this->load->view('front/component/news','',TRUE);

        $data['content'] = $this->load->view('front/index',$component,TRUE);

        $data['menu'] = $this->load->view('template/menu','',TRUE);
        $data['header'] = $this->load->view('template/header','',TRUE);
        $data['footer'] = $this->load->view('template/footer','',TRUE);

        $this->load->view('front',$data);
    }
}