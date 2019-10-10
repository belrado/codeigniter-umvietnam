<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Univ_model extends CI_Model {
    public function __construct () {
        parent::__construct();
        $this->load->database();
        $this->load->helper('htmlpurifier');
    }

    public function get_list($select='', $adm=false) {
        if(!empty($select)){
            $this->db->select($select);
        }
        if(!$adm) $this->db->where('u_use', 'yes');
        $this->db->order_by('u_index', 'ASC');
        $query = $this->db->get($this->db->dbprefix('univ'));
        return $query->result();
    }

    public function get_univ($u_id='') {
        if(!is_numeric($u_id)) return false;
        $this->db->where('u_id', $u_id);
        $query = $this->db->get($this->db->dbprefix('univ'));
        return $query->row();
    }

    public function insert_univ ($post, $file) {
        $data = array(
            'u_name_en'         => mysqli_real_escape_string($this->db->conn_id, trim($post['u_name_en'])),
            'u_name_vn'         => mysqli_real_escape_string($this->db->conn_id, trim($post['u_name_vn'])),
            'u_program_name_en' => mysqli_real_escape_string($this->db->conn_id, trim($post['u_program_name_en'])),
            'u_program_name_vn' => mysqli_real_escape_string($this->db->conn_id, trim($post['u_program_name_vn'])),
            'u_contents_en'     => html_purify($post['u_contents_en'], 'admin_html'),
            'u_contents_vn'     => html_purify($post['u_contents_vn'], 'admin_html'),
            'u_lat'             => mysqli_real_escape_string($this->db->conn_id, trim($post['u_lat'])),
            'u_lng'             => mysqli_real_escape_string($this->db->conn_id, trim($post['u_lng'])),
            'u_address'         => mysqli_real_escape_string($this->db->conn_id, trim($post['u_address'])),
            'u_homepage'        => mysqli_real_escape_string($this->db->conn_id, trim($post['u_homepage'])),
            'u_logo'			=> mysqli_real_escape_string($this->db->conn_id, trim($files['uploadfile'][0]['file_name'])),
			'u_logo_path'        => mysqli_real_escape_string($this->db->conn_id, trim($files['uploadfile'][0]['full_path'])),
			'u_photo' 		     => mysqli_real_escape_string($this->db->conn_id, trim($files['uploadfile'][1]['file_name'])),
			'u_photo_path' 	     => mysqli_real_escape_string($this->db->conn_id, trim($files['uploadfile'][1]['full_path'])),
            'u_register'        => date('Y-m-d H:i:s', time()),
            'u_index'           => mysqli_real_escape_string($this->db->conn_id, trim($post['u_index']*-1))
        );
        return $this->db->insert($this->db->dbprefix('univ'), $data);
    }

    public function modify_univ ($post, $files) {
        if(!is_numeric($post['u_id'])) return false;
        $data = array(
            'u_use'             => mysqli_real_escape_string($this->db->conn_id, trim($post['u_use'])),
            'u_name_en'         => mysqli_real_escape_string($this->db->conn_id, trim($post['u_name_en'])),
            'u_name_vn'         => mysqli_real_escape_string($this->db->conn_id, trim($post['u_name_vn'])),
            'u_program_name_en' => mysqli_real_escape_string($this->db->conn_id, trim($post['u_program_name_en'])),
            'u_program_name_vn' => mysqli_real_escape_string($this->db->conn_id, trim($post['u_program_name_vn'])),
            'u_contents_en'     => html_purify($post['u_contents_en'], 'admin_html'),
            'u_contents_vn'     => html_purify($post['u_contents_vn'], 'admin_html'),
            'u_lat'             => mysqli_real_escape_string($this->db->conn_id, trim($post['u_lat'])),
            'u_lng'             => mysqli_real_escape_string($this->db->conn_id, trim($post['u_lng'])),
            'u_address'         => mysqli_real_escape_string($this->db->conn_id, trim($post['u_address'])),
            'u_homepage'        => mysqli_real_escape_string($this->db->conn_id, trim($post['u_homepage'])),
            'u_index'           => mysqli_real_escape_string($this->db->conn_id, trim($post['u_index']*-1))
        );
        if(!empty($files['uploadfile'][0]['file_name'])){
            @unlink($post['u_logo_ori']);
            $data['u_logo']			= mysqli_real_escape_string($this->db->conn_id, trim($files['uploadfile'][0]['file_name']));
            $data['u_logo_path'] 	= mysqli_real_escape_string($this->db->conn_id, trim($files['uploadfile'][0]['full_path']));
        }
        if(!empty($files['uploadfile'][1]['file_name'])){
            @unlink($post['u_photo_ori']);
            $data['u_photo']			= mysqli_real_escape_string($this->db->conn_id, trim($files['uploadfile'][1]['file_name']));
            $data['u_photo_path'] 	= mysqli_real_escape_string($this->db->conn_id, trim($files['uploadfile'][1]['full_path']));
        }
        $this->db->where('u_id', $post['u_id']);
        return $this->db->update($this->db->dbprefix('univ'), $data);
    }
}
?>
