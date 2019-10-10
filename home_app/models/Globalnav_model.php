<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Globalnav_model extends CI_Model{
	public function __construct(){
		parent::__construct();
		$this->load->database();
	}
	public function nav_insert($post){
		if((isset($post['nav_parent']) && !is_numeric($post['nav_parent'])) || (isset($post['nav_index']) && !is_numeric($post['nav_index']))){
			return false;
		}
		if(isset($post['nav_parent']) && $post['nav_parent'] !== 0){
			$this->db->where('nav_id', $post['nav_parent']);
			$sql = $this->db->get($this->db->dbprefix('menu'));
			if($sql->num_rows() < 1){
				return false;
			}
		}
		$nav_dapth = (isset($post['nav_depth'])) ? trim(addslashes($post['nav_depth'])) : '1depth';
		$data = array(
			'nav_name_ko' 				=> mysqli_real_escape_string($this->db->conn_id, trim($post['nav_name_ko'])),
			'nav_name_en' 				=> mysqli_real_escape_string($this->db->conn_id, trim($post['nav_name_en'])),
			'nav_name_vn' 				=> mysqli_real_escape_string($this->db->conn_id, trim($post['nav_name_vn'])),
			'nav_access' 				=> mysqli_real_escape_string($this->db->conn_id, strip_tags(trim($post['nav_access']))),
			'nav_depth' 				=> mysqli_real_escape_string($this->db->conn_id, $nav_dapth),
			'nav_parent' 				=> (isset($post['nav_parent'])) ? trim($post['nav_parent']) : 0,
			'nav_sub_parent' 			=> (isset($post['nav_sub_parent'])) ? trim($post['nav_sub_parent']) : 0,
			'nav_link' 					=> mysqli_real_escape_string($this->db->conn_id, trim($post['nav_link'])),
			'nav_class' 				=> mysqli_real_escape_string($this->db->conn_id, trim($post['nav_class'])),
			'nav_index' 				=> (isset($post['nav_index'])) ? trim($post['nav_index']) : 1,
			'nav_meta_title_ko'			=> mysqli_real_escape_string($this->db->conn_id, trim($post['nav_meta_title_ko'])),
			'nav_meta_title_en'			=> mysqli_real_escape_string($this->db->conn_id, trim($post['nav_meta_title_en'])),
			'nav_meta_title_vn'			=> mysqli_real_escape_string($this->db->conn_id, trim($post['nav_meta_title_vn'])),
			'nav_meta_keyword_ko'		=> mysqli_real_escape_string($this->db->conn_id, trim($post['nav_meta_keyword_ko'])),
			'nav_meta_keyword_en'		=> mysqli_real_escape_string($this->db->conn_id, trim($post['nav_meta_keyword_en'])),
			'nav_meta_keyword_vn'		=> mysqli_real_escape_string($this->db->conn_id, trim($post['nav_meta_keyword_vn'])),
			'nav_meta_description_ko'	=> mysqli_real_escape_string($this->db->conn_id, trim($post['nav_meta_description_ko'])),
			'nav_meta_description_en'	=> mysqli_real_escape_string($this->db->conn_id, trim($post['nav_meta_description_en'])),
			'nav_meta_description_vn'	=> mysqli_real_escape_string($this->db->conn_id, trim($post['nav_meta_description_vn']))
		);
		if($this->db->insert($this->db->dbprefix('menu'), $data)){
			$last_id = $this->db->insert_id();
			/* 신디케이션 db 설정 시작 */
			/*
			if($data['nav_depth'] != '1depth' && $data['nav_parent'] != 0){
				$parent_info = $this->nav_get_list($data['nav_parent']);
				$syndi_data = array(
					'nav_id'			=> $last_id,
					'nav_parent'		=> $data['nav_parent'],
					'syn_id'			=> $data['nav_link'],
					'syn_title_ko'		=> fnc_set_htmls_strip($parent_info[0]->nav_name_ko).' '.$data['nav_name_ko'],
					'syn_title_en'		=> fnc_set_htmls_strip($parent_info[0]->nav_name_en).' '.$data['nav_name_en'],
					'syn_title_vn'		=> fnc_set_htmls_strip($parent_info[0]->nav_name_vn).' '.$data['nav_name_vn'],
					'syn_parent_link' 	=> fnc_set_htmls_strip($parent_info[0]->nav_link),
					'syn_register'		=> date('Y-m-d H:i:s', time())
				);
			}else{
				$syndi_data = array(
					'nav_id'			=> $last_id,
					'nav_parent'		=> 0,
					'syn_id'			=> $data['nav_link'],
					'syn_title_ko'		=> $data['nav_name_ko'],
					'syn_title_en'		=> $data['nav_name_en'],
					'syn_title_vn'		=> $data['nav_name_vn'],
					'syn_parent_link'	=> site_url(),
					'syn_register'		=> date('Y-m-d H:i:s', time())
				);
			}
			$this->db->insert($this->db->dbprefix('syndication'), $syndi_data);
			*/
			/* 신디케이션 설정 끝 */
			$this->db->cache_delete_all();
			$return_result = false;
			switch($nav_dapth){
				case '2depth' :
					$return_result = $this->nav_get_list($last_id, '2depth');
					break;
				case '3depth' :
					$return_result = $this->nav_get_list($last_id, '3depth');
					break;
				default :
					$return_result = $this->nav_get_list($last_id);
					break;
			}
			return $return_result;
			//return isset($post['nav_parent']) ? $this->nav_get_list($this->db->insert_id(), '2depth') : $this->nav_get_list($this->db->insert_id());
		}else{
			return false;
		}
	}
	public function nav_modify($post){
		$data = array();
		$data2 = array();
		for($i=0; $i<count($post['nav_id']); $i++){
			$data[$i] = array(
				$this->db->protect_identifiers('nav_id') => $post['nav_id'][$i],
				'nav_name_ko'				=> mysqli_real_escape_string($this->db->conn_id, trim($post['nav_name_ko'][$i])),
				'nav_name_en'				=> mysqli_real_escape_string($this->db->conn_id, trim($post['nav_name_en'][$i])),
				'nav_name_vn'				=> mysqli_real_escape_string($this->db->conn_id, trim($post['nav_name_vn'][$i])),
				'nav_access'				=> mysqli_real_escape_string($this->db->conn_id, trim($post['nav_access'][$i])),
				'nav_link'					=> mysqli_real_escape_string($this->db->conn_id, trim($post['nav_link'][$i])),
				'nav_class'					=> mysqli_real_escape_string($this->db->conn_id, trim($post['nav_class'][$i])),
				'nav_index'					=> mysqli_real_escape_string($this->db->conn_id, $post['nav_index'][$i]),
				'nav_meta_title_ko'			=> mysqli_real_escape_string($this->db->conn_id, trim($post['nav_meta_title_ko'][$i])),
				'nav_meta_title_en'			=> mysqli_real_escape_string($this->db->conn_id, trim($post['nav_meta_title_en'][$i])),
				'nav_meta_title_vn'			=> mysqli_real_escape_string($this->db->conn_id, trim($post['nav_meta_title_vn'][$i])),
				'nav_meta_keyword_ko'		=> mysqli_real_escape_string($this->db->conn_id, trim($post['nav_meta_keyword_ko'][$i])),
				'nav_meta_keyword_en'		=> mysqli_real_escape_string($this->db->conn_id, trim($post['nav_meta_keyword_en'][$i])),
				'nav_meta_keyword_vn'		=> mysqli_real_escape_string($this->db->conn_id, trim($post['nav_meta_keyword_vn'][$i])),
				'nav_meta_description_ko'	=> mysqli_real_escape_string($this->db->conn_id, trim($post['nav_meta_description_ko'][$i])),
				'nav_meta_description_en'	=> mysqli_real_escape_string($this->db->conn_id, trim($post['nav_meta_description_en'][$i])),
				'nav_meta_description_vn'	=> mysqli_real_escape_string($this->db->conn_id, trim($post['nav_meta_description_vn'][$i]))
			);
		}
		for($i=0; $i<count($post['navsub_id']); $i++){
			$data2[$i] = array(
				$this->db->protect_identifiers('nav_id') => $post['navsub_id'][$i],
				'nav_name_ko'				=> mysqli_real_escape_string($this->db->conn_id, trim($post['navsub_name_ko'][$i])),
				'nav_name_en'				=> mysqli_real_escape_string($this->db->conn_id, trim($post['navsub_name_en'][$i])),
				'nav_name_vn'				=> mysqli_real_escape_string($this->db->conn_id, trim($post['navsub_name_vn'][$i])),
				'nav_access'				=> mysqli_real_escape_string($this->db->conn_id, trim($post['navsub_access'][$i])),
				'nav_link'					=> mysqli_real_escape_string($this->db->conn_id, trim($post['navsub_link'][$i])),
				'nav_class'					=> mysqli_real_escape_string($this->db->conn_id, trim($post['navsub_class'][$i])),
				'nav_index'					=> mysqli_real_escape_string($this->db->conn_id, trim($post['navsub_index'][$i])),
				'nav_meta_title_ko'			=> mysqli_real_escape_string($this->db->conn_id, trim($post['navsub_meta_title_ko'][$i])),
				'nav_meta_title_en'			=> mysqli_real_escape_string($this->db->conn_id, trim($post['navsub_meta_title_en'][$i])),
				'nav_meta_title_vn'			=> mysqli_real_escape_string($this->db->conn_id, trim($post['navsub_meta_title_vn'][$i])),
				'nav_meta_keyword_ko'		=> mysqli_real_escape_string($this->db->conn_id, trim($post['navsub_meta_keyword_ko'][$i])),
				'nav_meta_keyword_en'		=> mysqli_real_escape_string($this->db->conn_id, trim($post['navsub_meta_keyword_en'][$i])),
				'nav_meta_keyword_vn'		=> mysqli_real_escape_string($this->db->conn_id, trim($post['navsub_meta_keyword_vn'][$i])),
				'nav_meta_description_ko'	=> mysqli_real_escape_string($this->db->conn_id, trim($post['navsub_meta_description_ko'][$i])),
				'nav_meta_description_en'	=> mysqli_real_escape_string($this->db->conn_id, trim($post['navsub_meta_description_en'][$i])),
				'nav_meta_description_vn'	=> mysqli_real_escape_string($this->db->conn_id, trim($post['navsub_meta_description_vn'][$i]))
			);

			if(!empty($post['navsub_new'][$i])){
				if($post['navsub_new'][$i] == 'show'){
					$data2[$i]['nav_new'] = date('Y-m-d H:i:s', time());
				}else if($post['navsub_new'][$i] == 'hide'){
					$data2[$i]['nav_new'] = '0000-00-00 00:00:00';
				}
			}
		}
		$data_merge = array_merge($data, $data2);
		if($this->db->update_batch($this->db->dbprefix('menu'), $data_merge, $this->db->protect_identifiers('nav_id'))){
			$this->db->cache_delete_all();
			return true;
		}else{
			return false;
		}
	}
	public function nav_delete($post){
		if(!is_numeric($post['nav_id'])){
			return false;
		}else{
			$this->db->where('nav_id', $post['nav_id']);
			$this->db->or_where('nav_parent', $post['nav_id']);
			$this->db->or_where('nav_sub_parent', $post['nav_id']);
			if($this->db->delete($this->db->dbprefix('menu'))){
				$this->db->cache_delete_all();
				return true;
			}else{
				return false;
			}
		}
	}
	public function nav_get_list($getid='all', $depth='1depth'){
		if($depth != 'all') $this->db->where('nav_depth', $depth);
		if($getid != 'all') $this->db->where('nav_id', $getid);
		$this->db->order_by('nav_index', 'ASC');
		if($getid == 'all'){
			$this->db->cache_on();
		}
		$sql 	= $this->db->get($this->db->dbprefix('menu'));
		$result = $sql->result();
		if($getid == 'all'){
			$this->db->cache_off();
		}
		return $result;
	}
	// 3depth --- 자동정렬
	public function nav_get_list_autoset(){
		$this->db->order_by('nav_parent','asc');
		$this->db->order_by('nav_index','asc');
		$this->db->cache_on();
		$query 	= $this->db->get($this->db->dbprefix('menu'));
		$result	= $query->result();
		$this->db->cache_off();
		return $result;
	}
	// end 3depth --- 자동정렬
	public function nav_get_sublist($parent_id, $depth='2depth'){
		$this->db->where('nav_depth', $depth);
		if($parent_id != 'all')
			$this->db->where('nav_parent', $parent_id);
		$this->db->order_by('nav_index', 'ASC');
		$sql = $this->db->get($this->db->dbprefix('menu'));
		return $sql->result();
	}
}
?>
