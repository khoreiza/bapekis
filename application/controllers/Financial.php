<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Financial extends CI_Controller {

    public function index(){

        $data['title'] = "Mandiri Bapekis Financial Info Page";

        $component['banner'] = $this->load->view('financial/component/banner','',TRUE);

        $data['content'] = $this->load->view('financial/index',$component,TRUE);

        $data['menu'] = $this->load->view('template/menu','',TRUE);
        $data['header'] = $this->load->view('template/header','',TRUE);
        $data['footer'] = $this->load->view('template/footer','',TRUE);

        $this->load->view('front',$data);
    }
}