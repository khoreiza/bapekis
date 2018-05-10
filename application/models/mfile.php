<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of admins
 *
 * @author Roonie
 */
class Mfile extends CI_Model {
    //put your code here
    function __construct() {
        parent::__construct();
        $this->load->database();
    }

    public function get_file_upload(){
        $query=$this->db->get('file_upload');
        return $query->result();
    }
    
    public function get_temp_download_link_with_key($key){
    	$this->db->where('key',$key);
    	$this->db->join('file_upload', 'temp_download_link.file_id = file_upload.id');
        $query = $this->db->get('temp_download_link');
    	return $query->row(0);
    }

    public function insert_temp_download_link($temp_download_link){
    	return $this->db->insert('temp_download_link', $temp_download_link);
    }

    public function update_temp_download_link_with_key($key, $temp_download_link){
    	$this->db->where('key', $key);
        return $this->db->update('temp_download_link', $temp_download_link);
    }

}