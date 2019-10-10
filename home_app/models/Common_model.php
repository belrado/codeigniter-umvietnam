<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Common_model extends CI_model{
	public function __construct(){
		parent::__construct();
		$this->load->database();
	}
	// 탈퇴회원인지 아닌지 확인
	public function get_member_unregister($user_id=''){
		if(empty($user_id)) return false;
		$this->db->select('user_name, user_level, mail_approve, unregister');
		$this->db->where('user_id', $user_id);
		$query = $this->db->get($this->db->dbprefix('user'));
		return $query->row();
	}
}
?>
