<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Gallery extends CI_Controller {

    public function index(){

        $data['title'] = "Mandiri Bapekis Gallery Page";

        $component['banner'] = $this->load->view('gallery/component/banner','',TRUE);
        $component['gallery'] = $this->load->view('gallery/component/gallery','',TRUE);

        $data['content'] = $this->load->view('gallery/index',$component,TRUE);

        $data['menu'] = $this->load->view('template/menu','',TRUE);
        $data['header'] = $this->load->view('template/header','',TRUE);
        $data['footer'] = $this->load->view('template/footer','',TRUE);

        $this->load->view('front',$data);
    }
}