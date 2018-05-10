<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Error_handling extends CI_Controller {

    public function index(){
        
        $data['title'] = "Mandiri Bapekis Error 404 Page";

        $component['banner'] = $this->load->view('error/component/banner','',TRUE);
        $component['error404'] = $this->load->view('error/component/404','',TRUE);

        $data['content'] = $this->load->view('error/index',$component,TRUE);

        $data['menu'] = $this->load->view('template/menu','',TRUE);
        $data['header'] = $this->load->view('template/header','',TRUE);
        $data['footer'] = $this->load->view('template/footer','',TRUE);

        $this->load->view('front',$data);
    }
}