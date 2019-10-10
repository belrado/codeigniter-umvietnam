<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Review_model extends CI_model{
	public function __construct(){
		parent::__construct();
		$this->load->database();
		$this->load->library('ckeditor');
	}
	// 게시글의 천제 개수를 반환
	public function get_total_num(){
		return $this->db->count_all($this->db->dbprefix('review'));
	}
	// 게시글 리스트 반환 
	public function get_review_list($page_limit, $page_list){
		$this->db->order_by('best', 'asc');
		$this->db->order_by('register', 'desc');
		$query = $this->db->get($this->db->dbprefix('review'), $page_list, $page_limit);
		$result = $query->result();
		if($result){
			return $result;
		}else{
			return false;
		}
	}
	// 게시글 반환
	public function get_review($review_id){
		if(!is_numeric($review_id)){
			return false;
		}
		$this->db->where('id', (int)$review_id);
		$query = $this->db->get($this->db->dbprefix('review'));
		$result = $query->row();
		if($result){
			return $result;
		}else{
			return false;
		}
	}
	// 게시글 수정
	public function review_update($post){		
		$mode = trim($this->security->xss_clean($post['review_mode']));
		$this->load->helper('htmlpurifier');
		
		$copyImgFile 	= trim(addslashes($this->security->xss_clean($post['copyImgFileNames'])));	
		$content 		= trim($post['r_content']);
		
		$imgFiles 		= '';
		if(!empty($copyImgFile)){
			$imgFiles = $this->ckeditor->check_upload_imgfiles($copyImgFile, $content);
		}
		$data = array(
			'subject'		=> trim(strip_tags(addslashes($this->security->xss_clean($post['subject'])))), 
			'name'			=> trim(strip_tags(addslashes($this->security->xss_clean($post['name'])))), 
			'school'		=> trim(strip_tags(addslashes($this->security->xss_clean($post['school'])))), 
			'content'		=> addslashes(html_purify($content, 'admin_html')),
			'imgfiles' 		=> $imgFiles,
			'best'			=> trim(strip_tags($this->security->xss_clean($post['best'])))
		);
		// 여기서 true, false 확인해서 넘기자.. false일땐 이미지 삭제
		if($mode == 'insert'){
			$data['register'] = date('Y-m-d H:i:s', time());
			return $this->db->insert($this->db->dbprefix('review'), $data);
		}else if($mode == 'modify'){
			$review_id = $this->security->xss_clean($post['review_id']);
			if(!is_numeric($review_id)){
				return false;
			}else{
				$this->db->where('id', $review_id);
				return $this->db->update($this->db->dbprefix('review'), $data);
			}
		}else{
			return false;
		}
	}
	// 게시글 삭제
	public function review_delete($post){
		$chkLen = count($post['chk']);
		$del_id = array();
		for($i=0; $i<$chkLen; $i++){
			if(!is_numeric($post['chk'][$i])){
				return false;
			}else{
				array_push($del_id, $post['chk'][$i]);
			}
		}
		for($i=0; $i<$chkLen; $i++){
			$this->db->where('id', $post['chk'][$i]);
			$this->db->select('imgfiles');
			$query = $this->db->get($this->db->dbprefix('review'));
			$imgfiles = $query->row();
			if(!empty($imgfiles->imgfiles)){
				$this->ckeditor->delete_imgfiles($imgfiles->imgfiles);
			}
		}
		$this->db->where_in('id', $del_id);
		return $this->db->delete($this->db->dbprefix('review'));	
	}
}
?>
	