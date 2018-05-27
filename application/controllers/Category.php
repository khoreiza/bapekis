<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');


class Category extends CI_Controller {
    
    public function __construct() {
        parent::__construct();
        $this->load->model(array('muser','mfiles_upload'));
        $session = $this->session->userdata('userbapekis');
        if(!$session){
            $url = current_url();
            $this->session->set_userdata('last_page_open',$url);
            redirect('user/login');
        }
    }
    /**
     * Method for page (public)
     */


    public function index()
    {
        //$this->muser->insert_user_access_log("Access CBIC Data Quality Page, Category Management Page");
        
        $join[0] = array('table' => 'user', 'in' => "user.id = category.created_by");
        $data['categories'] = $this->mfiles_upload->get_db_join('id','desc','category','','category.*, user.full_name','','',$join);

        $data['title'] = "Category Management Page - CBIC";

        /*$data['header'] = $this->load->view('shared/header/header-submenu','',TRUE);   
        $data['footer'] = $this->load->view('shared/footer','',TRUE);
        $data['content'] = $this->load->view('data/category',$data,TRUE);

        $this->load->view('front',$data);*/


        $data['title'] = "Category Management Page - CBIC";

        $data['header'] = $this->load->view('admin/shared/first/header','',TRUE);   
        $data['footer'] = $this->load->view('admin/shared/first/footer','',TRUE);
        $data['content'] = $this->load->view('category/index',$data,TRUE);

        $this->load->view('admin/shared/front',$data);
        
    }



    public function show_form(){
        $id = $this->input->get('id');
        $data['menu'] = $this->input->get('menu');
        $data['submodul'] = $this->input->get('submodul');

        if($id){
            $data['category'] = $this->mfiles_upload->get_db("category","asc","category",array('id' => $id),"","")[0];
        }

        $data['icons'] = $this->mfiles_upload->get_db("icon_name","asc","icon","","","");

        $data['popup_content'] = $this->load->view('category/_form',$data,TRUE);
        $data['popup_title'] = "Form Category"; 
        $data['popup_width'] = "600px";

        $json['html'] = $this->load->view('admin/shared/component/_popup_page', $data,TRUE);
        $json['status'] = 1;
        $this->output->set_content_type('application/json')
                         ->set_output(json_encode($json));
    }


    public function store(){
        $id = $this->uri->segment(3);
        $user = $this->session->userdata('userbapekis');

        $arr = array('category','description','menu','submodul','icon');
        $data = $this->mfiles_upload->get_form_element($arr);

        $data['updated_at'] = date('Y-m-d H:i:s');
        $data['updated_by'] = $user['id'];

        if(!$id){
            $data['created_at'] = date('Y-m-d H:i:s');
            $data['created_by'] = $this->session->userdata('userbapekis')['id'];
            
            $request_id = $this->mfiles_upload->insert_db($data,'category');
            $this->muser->insert_user_access_log("Add New category ".$data['category']);
        }
        else{
            $this->mfiles_upload->update_db($data,$id,'category');
            $request_id = $id;
            $this->muser->insert_user_access_log("Edit Category Data for ".$data['category']);
        }

        if($data['menu'] == "market") redirect($data['menu']."/page/".$data['submodul']);
        elseif($data['menu'] == "photo_album") redirect('photo');
        elseif($data['menu'] == "risk_documentation") redirect('risk/documentation');
        elseif($data['menu'] == "mysharing") redirect('sharing');
        else redirect($data['menu']);
    }



    public function delete_category(){
        $id = $this->input->get('id');
        $menu = $this->input->get('menu');

        $this->mfiles_upload->delete_id_db('category',$id);


        /**** UPDATE PROSES ke UNCATEGORIZED ****/
        $array_db = array('photo_album' => "photo", 'market' => 'news', 'mysharing' => 'mysharing');
        $data['category_id'] = "";
        $arr_where = array('category_id' => $id);
        $this->mfiles_upload->update_db_where($data,$arr_where,$array_db[$menu]);
        
        $json['status'] = 1;
        $this->output->set_content_type('application/json')
                     ->set_output(json_encode($json));
    }


}
