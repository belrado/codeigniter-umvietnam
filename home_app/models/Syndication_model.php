<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Syndication_model extends CI_Model{
	public function __construct(){
		parent::__construct();
		$this->load->database();
	}
	public function get($parent_id=0, $nav_id=0, $xml=false, $rss=false){
		if(!is_numeric($parent_id) || !is_numeric($nav_id)){
			return false;
		}
		if($nav_id == 0 && $parent_id > 0){
			$this->db->where('nav_parent', $parent_id);
		}else{
			$this->db->where('nav_id', $nav_id);
		}
		if($xml) $this->db->where('syn_use', 'yes');
		if($rss) $this->db->where('rss_use', 'yes');
		$query = $this->db->get($this->db->dbprefix('syndication'));
		return $query->result();
	}
	public function get_all($xml=false, $rss=false){
		$this->db->where('nav_parent > ', 0);
		if($xml) $this->db->where('syn_use', 'yes');
		if($rss) $this->db->where('rss_use', 'yes');
		$query = $this->db->get($this->db->dbprefix('syndication'));
		return $query->result();
	}
	public function post($post){
		if($post['nav_depth'] != '1depth' && $post['nav_parent'] != 0){
			$parent_info = $this->nav_get_list($post['nav_parent']);
			$syndi_data = array(
				'nav_id'			=> $post['nav_id'],
				'nav_parent'		=> $post['nav_parent'],
				'syn_id'			=> $post['nav_link'],
				'syn_title'			=> fnc_set_htmls_strip($parent_info[0]->nav_name).' '.$post['nav_name'],
				'syn_parent_link' 	=> fnc_set_htmls_strip($parent_info[0]->nav_link),
				'syn_register'		=> date('Y-m-d H:i:s', time())
			);
		}else{
			$syndi_data = array(
				'nav_id'			=> $post['nav_id'],
				'nav_parent'		=> 0,
				'syn_id'			=> $post['nav_link'],
				'syn_title'			=> $post['nav_name'],
				'syn_parent_link'	=> site_url(),
				'syn_register'		=> date('Y-m-d H:i:s', time())
			);
		}
		return $this->db->insert($this->db->dbprefix('syndication'), $syndi_data);
	}
	public function put($post){
		if(!is_numeric($post['syn_num'])) return false;
		$data = array(
			'syn_id'		=> mysqli_real_escape_string($this->db->conn_id, trim($post['syn_id'])),
			'syn_title'		=> mysqli_real_escape_string($this->db->conn_id, trim($post['syn_title'])),
			'syn_content'	=> mysqli_real_escape_string($this->db->conn_id, trim($post['syn_content'])),
			'syn_use'		=> mysqli_real_escape_string($this->db->conn_id, trim($post['syn_use'])),
			'rss_use'		=> mysqli_real_escape_string($this->db->conn_id, trim($post['rss_use'])),
			'syn_register'		=> date('Y-m-d H:i:s', time())
		);
		$this->db->where('syn_num', $post['syn_num']);
		return $this->db->update($this->db->dbprefix('syndication'), $data);
	}
	public function nav_get_list($getid='all', $depth='1depth'){
		if($depth != 'all') $this->db->where('nav_depth', $depth);
		if($getid != 'all') $this->db->where('nav_id', $getid);
		$this->db->order_by('nav_index', 'ASC');
		$sql 	= $this->db->get($this->db->dbprefix('menu'));
		$result = $sql->result();
		return $result;
	}
	
	public function bbs_post($post){
		if(!is_numeric($post['s_bbs_id'])) return false;
		$data = array(
			's_type'			=> mysqli_real_escape_string($this->db->conn_id, trim($post['s_type'])),
			's_bbs_table'		=> mysqli_real_escape_string($this->db->conn_id, trim($post['s_bbs_table'])),
			's_bbs_name'		=> mysqli_real_escape_string($this->db->conn_id, trim($post['s_bbs_name'])),
			's_bbs_id'			=> mysqli_real_escape_string($this->db->conn_id, trim($post['s_bbs_id'])),
			's_bbs_subject'		=> mysqli_real_escape_string($this->db->conn_id, trim($post['s_bbs_subject'])),
			's_bbs_content'		=> mysqli_real_escape_string($this->db->conn_id, trim($post['s_bbs_content'])),
			's_bbs_register'	=> mysqli_real_escape_string($this->db->conn_id, trim($post['s_bbs_register']))
		);
		return $this->db->insert($this->db->dbprefix('syndication_ping'), $data);
	}
	public function bbs_put($post){
		if(!is_numeric($post['s_bbs_id'])) return false;
		$this->db->trans_start();
		$this->db->where('s_bbs_table', $post['s_bbs_table']);
		$this->db->where('s_bbs_id', $post['s_bbs_id']);
		$this->db->update($this->db->dbprefix('syndication_ping'), array(
			's_ping' => 'yes'
		));
		$this->bbs_post($post);
		$this->db->trans_complete();
		if($this->db->trans_status() === FALSE){
			$this->db->trans_rollback();
			return false;
		}else{
			$this->db->trans_commit();
			return true;
		}
	}
	public function bbs_delete($bbs_table, $bbs_ids){
		if(count($bbs_ids) <=0) return false;
		$update_data = array();
		$insert_data = array();
		$this->db->trans_start();
		$this->db->where('s_bbs_table', $bbs_table);
		for($i=0; $i<count($bbs_ids); $i++){
			if(!is_numeric($bbs_ids[$i])) return false;
			if($i==0){
				$this->db->where('s_bbs_id', $bbs_ids[$i]);
			}else{
				$this->db->or_where('s_bbs_id', $bbs_ids[$i]);
			}
			//$this->db->or_where_in('s_bbs_table', $bbs_table, 's_bbs_id', $bbs_ids[$i]);
			$insert_data[$i] = array(
				's_type'			=> 'delete',
				's_bbs_table'		=> mysqli_real_escape_string($this->db->conn_id, $bbs_table),
				's_bbs_name'		=> '',
				's_bbs_id'			=> mysqli_real_escape_string($this->db->conn_id, $bbs_ids[$i]),
				's_bbs_subject'		=> '',
				's_bbs_content'		=> '',
				's_bbs_register'	=> date('Y-m-d H:i:s', time())
			);
		}
		$this->db->update($this->db->dbprefix('syndication_ping'), array(
			's_ping' => 'yes'
		));
		$this->db->insert_batch($this->db->dbprefix('syndication_ping'), $insert_data);
		$this->db->trans_complete();
		if($this->db->trans_status() === FALSE){
			$this->db->trans_rollback();
			return false;
		}else{
			$this->db->trans_commit();
			return true;
		}
	}
	public function bbs_get($bbs_table='', $bbs_id=0, $offset=0, $limit=0){
		if(empty($bbs_table) || !is_numeric($bbs_id)) return false;
		$this->db->where('s_bbs_table', $bbs_table);
		if($bbs_id>0){
			$this->db->where('s_bbs_id', $bbs_id);
		}
		$this->db->where('s_ping', 'no');
		if($bbs_id==0 && $offset==0 && $limit==0){
			$query = $this->db->get($this->db->dbprefix('syndication_ping'));
		}else{
			$query = $this->db->get($this->db->dbprefix('syndication_ping'), $limit, $offset);
		}
		
		return $query->result();
	}
}
?>