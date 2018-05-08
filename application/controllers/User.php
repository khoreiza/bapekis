<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class User extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model(array('muser','mfiles_upload'));

    }

    public function login(){

        $data['title'] = "Mandiri Bapekis Login Page";

        //$component['banner'] = $this->load->view('user/component/login/banner','',TRUE);
        $component = "";

        $data['content'] = $this->load->view('user/login',$component,TRUE);

        $data['menu'] = $this->load->view('template/menu','',TRUE);
        $data['header'] = $this->load->view('template/header','',TRUE);
        $data['footer'] = $this->load->view('template/footer','',TRUE);

        $this->load->view('front',$data);
    }

    /**************************/
    /*                        */
    /*  Method for Action     */
    /*                        */
    /**************************/
    
    public function login_action(){
        $params['username'] = $this->input->post('username');
        $params['password'] = md5($this->input->post('password'));
        if($this->check_login($params['username'],$params['password'])){
            $user = $this->muser->get_user_id_by_username($params['username']);
            $data = array(
                'id' => $user->id,
                'username' => $user->username,
                'nik' => $user->nik,
                'full_name' => $user->full_name,
                'panggilan' => $user->panggilan,
                'is_logged_in' => true,
                'role' => $user->role,
                'position' => $user->position,
                'jabatan' => $user->jabatan,
                'group' => strtoupper($user->group),
                'dept' => $user->department,
                'directorate' => $user->directorate,
                'profile_picture' => $user->profile_picture,
                'is_employee' => $user->is_employee,
            );
            $this->session->set_userdata('userbapekis',$data);
            //$this->muser->insert_user_login_log($data['id']);
            
            $last_page = $this->session->userdata('last_page_open');
            if($last_page){
                $this->session->unset_userdata('last_page_open'); redirect($last_page);
            }
            else{
                if($user->redirect_page_id){
                    $page_redirect = $this->mfiles_upload->get_db('name','asc','page',array('id' => $user->redirect_page_id),'','');
                    if($page_redirect) redirect($page_redirect[0]->url);
                }
                else{
                   redirect('admin'); 
                }
            }
        }else{
            $params['type_login']="failed";
            $this->login($params);
        }
    }
    
    private function check_login($username, $password){
         echo "check";
         if(empty($username) || empty($password)){
            echo "kosong";
            return false;
         }else{
            echo "isi";
            if($this->muser->verify($username, $password)){echo "ada"; return true; }
            else{echo "gak ada"; return false;}
         }
    }







    /********************** USER MANAGEMENT MENU **********************/
    public function management()
    {
        $this->muser->insert_user_access_log("Access CBIC Data Quality Page, User Management Page");
        
        $data['users'] = $this->mfiles_upload->get_db('full_name','asc','user','','','');

        $data['title'] = "User Management Page - CBIC";

        $data['header'] = $this->load->view('admin/shared/first/header','',TRUE);   
        $data['footer'] = $this->load->view('admin/shared/first/footer','',TRUE);
        $data['content'] = $this->load->view('user/management',$data,TRUE);

        $this->load->view('admin/shared/front',$data);
        
    }

    public function user_detail()
    {
        $id = $this->input->get('id');

        $data['profile'] = $this->muser->get_user_by_id($id);

        $data['status'] = 1;
        $data['html'] = $this->load->view('user/component/management/_detail',$data,TRUE);
        $this->output->set_content_type('application/json')
                     ->set_output(json_encode($data));
        
    }

    public function user_form()
    {
        $id = $this->input->get('id');

        //$data['pages'] = $this->mfiles_upload->get_db("name","asc","page","","","");

        if($id){
            $data['profile'] = $this->muser->get_user_by_id($id);
        }

        $data['status'] = 1;
        $data['html'] = $this->load->view('user/component/management/_form',$data,TRUE);
        $this->output->set_content_type('application/json')
                     ->set_output(json_encode($data));
        
    }

    public function store_user()
    {
        $id = $this->uri->segment(3);
        $user = $this->session->userdata('userbapekis');
        $profile = $this->muser->get_user_by_id($id);
        
        $arr = array('full_name','panggilan','gender','agama','username','nik','jabatan','position','sumber','directorate','group','department','phone_number','ip_phone','extension','email','strata','universitas','jurusan','tahun_lulus','is_employee','is_rkk_committee','status','redirect_page_id','is_NDA');
        $data = $this->mfiles_upload->get_form_element($arr);


        if($this->input->post('dob')) $data['dob'] = DateTime::createFromFormat('d M Y', $this->input->post('dob'))->format('Y-m-d');
        if($this->input->post('tmt_kerja')) $data['tmt_kerja'] = DateTime::createFromFormat('d M Y', $this->input->post('tmt_kerja'))->format('Y-m-d');


        /**** Unit Information ****/
        $data['directorate'] = strtoupper($data['directorate']);
        $data['group'] = strtoupper($data['group']);
        $data['department'] = strtoupper($data['department']);
        /**** End of Unit Information ****/

        /**** Role Information ****/
        $data['role'] = "";
        foreach($this->input->post('role') as $role){
            $data['role'] = $data['role'].$role.";";
        }
        /**** End of Role Information ****/

        /**** Dir Priority Data ****/
        $directorate = $this->mfiles_upload->get_db('directorate','asc','cbdirectorate',array("directorate" => strtoupper($data['directorate'])),'','');
        if($directorate) $data['priority_dir'] = $directorate[0]->priority;
        /**** End of Dir Priority Data ****/

        /**** Position Priority Data ****/
        $data['priority'] = get_position_priority($data['position']);
        /**** End Position Priority Data ****/

        /**** Make Image ****/
        $upload_path = "assets/uploads/user_profile/";
        if (!is_dir($upload_path)) {
            mkdir($upload_path, 0777, true);
        }
        $image_crop = $this->input->post('pp_not_file');
        if($image_crop){
            $imageData = base64_decode(explode("data:image/png;base64,", $image_crop)[1]);
            //echo $imageData;

            $date_timestamp = new DateTime();

            $photo = imagecreatefromstring($imageData);
            $photo_url = $upload_path.$data['nik'].'_profile_picture'.$date_timestamp->getTimestamp().'.png';
            imagepng($photo,$photo_url,5);

            $data['profile_picture'] = $photo_url;

            if($profile->profile_picture){
                unlink($profile->profile_picture);
            }

            /************* Make Thumbnail ***************/
            $ex_profile = explode("/", $photo_url);         
            $image_name = end($ex_profile);
            $file_location = base_url().$photo_url;
            $target_folder = "user_profile/";

            $this->mfiles_upload->make_photo_thumb($image_name,$file_location,$target_folder,40,'_thumbnail.jpg');
            /************* END of Make Thumbnail ***************/
        }

        $data['updated_by'] = $user['id'];
        $data['updated_at'] = date("Y-m-d H:i:s");

        /**** SAVE USER DATA ****/
        if(!$id){
            $data['created_at'] = date('Y-m-d H:i:s');
            $data['created_by'] = $this->session->userdata('userbapekis')['id'];
            
            $data['password'] = md5($this->input->post('password'));
            $user_id = $this->mfiles_upload->insert_db($data,'user');
            $this->muser->insert_user_access_log("Access CBIC Data Quality Page, Add new user ".$data['full_name']);
        }
        else{
            $this->mfiles_upload->update_db($data,$id,'user');
            $user_id = $id;
            $this->muser->insert_user_access_log("Access CBIC Data Quality Page, Edit user data for ".$data['full_name']);
        }

        redirect('data/user');
    }
    /********************** END OF USER MENU **********************/
}