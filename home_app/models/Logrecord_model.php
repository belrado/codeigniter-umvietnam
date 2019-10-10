<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Logrecord_model extends CI_model{
	public function __construct(){
		parent::__construct();
		$this->load->database();
	}
	public function get_total_row(){
		return $this->db->count_all($this->db->dbprefix('log_record'));
	}
	public function set_logrecord($type='down', $post=array()){
		$data = array(
			'log_type'		=> $type,
			'log_ip'		=> $_SERVER['REMOTE_ADDR'],
			'log_agent'		=> $_SERVER['HTTP_USER_AGENT'],
			'log_referer'	=> $_SERVER['HTTP_REFERER'],
			'log_cookie' 	=> $_SERVER['HTTP_COOKIE'],
			'log_value'		=> mysqli_real_escape_string($this->db->conn_id, serialize($post)),
			'log_register'	=> date('Y-m-d H:i:s', time())
		);
		return $this->db->insert($this->db->dbprefix('log_record'), $data);
	}
	public function get_logrecord($page_limit=1, $page_list=1){
		$this->db->order_by('log_id', 'desc');
		$query = $this->db->get($this->db->dbprefix('log_record'), $page_list, $page_limit);
		$result = $query->result();
		if($result){
			$data=array();
			foreach($result as $val){
				$data[] = array(
					'log_type'	=> htmlspecialchars(stripslashes($val->log_type)),
					'log_agent' => htmlspecialchars(stripslashes($val->log_agent)),
					'log_ip'	=> htmlspecialchars(stripslashes($val->log_ip)),
					'log_value' => (!empty($val->log_value))?unserialize(stripslashes($val->log_value)):'',
					'log_register' => $val->log_register
				);
			}
			return $data;
		}else{
			return $result;
		}
		return $query->result();
	}
}
?>