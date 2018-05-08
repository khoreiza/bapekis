<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class General extends CI_Controller {

    public function index(){

        $data['title'] = "Mandiri Bapekis General Info Page";

        $component['banner'] = $this->load->view('general/component/banner','',TRUE);

        $data['content'] = $this->load->view('general/index',$component,TRUE);

        $data['menu'] = $this->load->view('template/menu','',TRUE);
        $data['header'] = $this->load->view('template/header','',TRUE);
        $data['footer'] = $this->load->view('template/footer','',TRUE);

        $this->load->view('front',$data);
    }
}