<?php
defined('BASEPATH') OR exit('No direct script access allowed');
/*
error_code 000 일반에러
error_code 0001   => '등록된 게시물이 없습니다.',
error_code 0002   => '삭제 실패. 잠시 후 다시 시도해 주세요.',
error_code 0003   => '등록된 글 또는 게시판이 없습니다.',
error_code 0004	  => '이미 스크랩한 게시물입니다.'
error_code 0005	  => '이미 추천 버튼을 눌렀습니다.'
error_code 100 qna
error_code 1001 답글이 달려있거나 작성 진행중이기에 수정 또는 삭제 할수 없다.
*/
class Board_model extends CI_model{
	public function __construct(){
		parent::__construct();
		$this->load->database();
		$this->load->library('ckeditor');
	}
	// 게시판 테이블 생성
	private function create_board_table($table_name){
		$create_table = $this->db->dbprefix('write_'.$table_name);
		$create_table_fa = $this->db->dbprefix('write_'.$table_name.'_fa');
		$sql = sprintf("SHOW TABLES LIKE '%s'", $create_table);
		$query = $this->db->query($sql);
		if($query->num_rows() > 0){
			return false;
		}else{
			$sql = "CREATE TABLE `{$create_table}` (
				`bbs_id` int(12) unsigned auto_increment,
				`bbs_notice` varchar(3) not null default 'no',
				`bbs_secret` varchar(3) not null default 'no',
				`bbs_num` int(12) not null default '0',
				`bbs_index` tinyint(4) not null default '0',
				`bbs_is_reply` tinyint(1) unsigned not null default '0',
				`bbs_reply` varchar(10) not null,
				`bbs_parent` int(12) not null default '0',
				`bbs_is_comment` tinyint(4) not null default '0',
				`bbs_comment` int(12) not null default '0',
				`bbs_comment_num` int(12) not null default '0',
				`bbs_comment_parent` int(12) not null default '0',
				`bbs_cate` varchar(30) not null,
				`bbs_link` varchar(255) not null,
				`bbs_subject` varchar(255) not null,
				`bbs_content` text not null,
				`bbs_content_imgs` text not null,
				`bbs_thumbnail` varchar(255) not null,
				`bbs_image` varchar(255) not null,
				`bbs_good` int(12) not null default '0',
				`bbs_nogood` int(12) not null default '0',
				`bbs_hit` int(12) unsigned not null default '0',
				`bbs_file` tinyint(4) not null default '0',
				`bbs_extra1` varchar(255) not null,
				`bbs_extra2` varchar(255) not null,
				`bbs_extra3` varchar(255) not null,
				`user_id` varchar(50) not null,
				`user_name` varchar(30) not null,
				`bbs_pwd` varchar(255) not null,
				`user_ip` varchar(255) not null,
				`bbs_register` datetime not null default '0000-00-00 00:00:00',
				`bbs_last` datetime not null default '0000-00-00 00:00:00',
				`bbs_blind` varchar(3) not null default 'no',
				`bbs_use` varchar(3) not null default 'yes',
				PRIMARY KEY(`bbs_id`),
				INDEX (`bbs_notice`, `bbs_is_reply`, `bbs_reply`, `bbs_parent`, `bbs_is_comment`, `bbs_comment_parent`, `user_id`, `bbs_cate`, `bbs_use`),
				CONSTRAINT `{$create_table}_user_fk` FOREIGN KEY (`user_id`) REFERENCES `psu_user`(`user_id`) ON DELETE CASCADE ON UPDATE CASCADE
			) ENGINE=InnoDB DEFAULT CHARSET=utf8;";

			$favorite_sql = "CREATE TABLE `{$create_table_fa}` (
				`fa_id` int(12) unsigned auto_increment,
				`bbs_id` int(12) unsigned not null,
				`user_id` varchar(50) not null,
				`fa_type` varchar(4) not null,
				`fa_register` datetime not null default '0000-00-00 00:00:00',
				PRIMARY KEY(`fa_id`),
				INDEX (`bbs_id`, `user_id`, `fa_type`),
				CONSTRAINT `{$create_table}_favorite_fk` FOREIGN KEY (`bbs_id`) REFERENCES `{$create_table}`(`bbs_id`) ON DELETE CASCADE ON UPDATE CASCADE
			) ENGINE=InnoDB DEFAULT CHARSET=utf8;";

			$this->db->trans_begin();
			$this->db->query($sql);
			$this->db->query($favorite_sql);
			if ($this->db->trans_status() === FALSE){
				$this->db->trans_rollback();
				return false;
			}else{
				$this->db->trans_commit();
				return true;
			}
		}
	}
	// 게시판 이름이 있는지 확인
	public function check_board_name($table, $name){
		$this->db->select($table);
		$this->db->where($table, $name);
		$query = $this->db->get($this->db->dbprefix('board_group'));
		return ($query->num_rows() > 0) ? false : true;
	}
	// 게시판관리 게시판리스트 가져오기
	public function get_board_list(){
		$query = $this->db->get($this->db->dbprefix('board_group'));
		if($query->num_rows() > 0 ){
			return $query->result();
		}else{
			return false;
		}
	}
	// 게시판 더보기
	public function get_more_list($post){
		$bbs_table 	= trim($post['bbs_table']);
		$bbs_cate 	= trim(urldecode($post['bbs_cate']));
		$offset 	= (int)$post['offset'];
		$limit		= (int)$post['limit'];
		$sch_select = isset($post['sch_select'])?$post['sch_select']:'';
		$keyword	= isset($post['keyword'])?$post['keyword']:'';
		$total = $this->get_board_list_totalnum($bbs_table, $bbs_cate, $sch_select, $keyword);
		if($total > $offset){
			$this->db->select('bbs_id, bbs_num, bbs_cate, bbs_link, bbs_subject, bbs_thumbnail, bbs_image, user_id, user_name, bbs_register, bbs_extra1, bbs_extra2, bbs_extra3, bbs_good, bbs_hit');
			if($bbs_cate != 'all'){
				$this->db->where('bbs_cate', $bbs_cate);
			}
			if(!empty($sch_select) && !empty($keyword)){
				$this->setting_search_query($sch_select, $keyword);
			}
			$this->db->where('bbs_is_comment',0);
			$this->db->where('bbs_use', 'yes');
			$this->db->order_by('bbs_index', 'ASC');
			$this->db->order_by('bbs_num', 'ASC');
			$query = $this->db->get($this->db->dbprefix('write_').$bbs_table, $limit, $offset);
			$result['list'] = $query->result();
			if($result){
				$result['list_last'] = ($total <= $offset+$limit) ? 'yes' : 'no';
				return $result;
			}else{
				$result['err_msg']='SQL ERROR. 잠시 후 다시 시도해 주세요.';
				return $result;
			}
		}else{
			$result['err_msg']='더보기할 항목이 없습니다.';
			return $result;
		}
	}
	// 총 몇갠지 반환
	public function get_board_list_totalnum($bbs_table, $cate='all', $sch_select='', $keyword=''){
		$this->db->db_debug = FALSE;
		if(trim($cate) != 'all'){
				$this->db->where('bbs_cate', $this->security->xss_clean($cate));
			}
		if(!empty($sch_select) && !empty($keyword)){
			$this->setting_search_query($sch_select, $keyword);
		}
		$this->db->where('bbs_is_comment', 0);
		$this->db->where('bbs_use', 'yes');
		$this->db->select("count(bbs_id) as count");
		if($query = $this->db->get($this->db->dbprefix('write_'.$bbs_table))){
			return (int)$query->row()->count;
		}else{
			return false;
		}
	}
	// 유저아이디로 총 몇개인지 반환
	public function get_user_board_list_totalnum($bbs_table='', $user_id='', $bbs_is_comment='all'){
		if(empty($bbs_table) || empty($user_id)){
			return false;
		}
		$this->db->where('user_id', $this->security->xss_clean($user_id));
		if(is_numeric($bbs_is_comment) && $bbs_is_comment==0){
			$this->db->where('bbs_is_comment', $bbs_is_comment);
		}else if(is_numeric($bbs_is_comment) && $bbs_is_comment>0){
			$this->db->where('bbs_is_comment != ', 0);
		}
		$this->db->select("count(bbs_id) as count");
		if($query = $this->db->get($this->db->dbprefix('write_'.$this->security->xss_clean($bbs_table)))){
			return (int)$query->row()->count;
		}else{
			return false;
		}
	}
	// 게시판 리스트
	public function get_write_board_list($bbs_table='', $offset, $limit=15, $cate='all', $sch_select='', $keyword='', $sort='', $select=''){

		if(!$this->check_board_name('bbs_table', $bbs_table) && (!empty($bbs_table) || !is_numeric($limit) || !is_numeric($offset))){
			if(!empty($select)){
				$this->db->select($select);
			}
			$this->db->from($this->db->dbprefix('write_'.strtolower($bbs_table).' as t'));
			$this->db->join($this->db->dbprefix('user as u'), 't.user_id = u.user_id', 'left');

			$this->db->where('t.bbs_use', 'yes');
			if($cate != 'all'){
				$this->db->where('t.bbs_cate', $this->security->xss_clean($cate));
			}
			if(!empty($sch_select) && !empty($keyword)){
				$this->setting_search_query($sch_select, $keyword);
			}
			$this->db->where('t.bbs_is_comment', 0);
			if($sort == 'sort_day'){
				$this->db->order_by('t.bbs_index', 'ASC');
				$this->db->order_by('t.bbs_register', 'DESC');
			}else{
				$this->db->order_by('t.bbs_index', 'ASC');
				$this->db->order_by('t.bbs_num', 'ASC');
			}
			$this->db->limit($limit, $offset);
			// 리스트 불러올때 캐시 생성
			$this->db->cache_on();
			//$this->db->cache_delete_all()
			$query = $this->db->get();
			$this->db->cache_off();
			if($result = $query->result()){
				return $result;
			}else{
				return false;
			}
		}else{
			return false;
		}
	}
	public function get_user_write_board_list($bbs_table='', $user_id='', $offset=0, $limit=15, $bbs_is_comment='all'){
		if(!$this->check_board_name('bbs_table', $bbs_table) && (!empty($bbs_table) || !is_numeric($limit) || !is_numeric($offset))){
			$this->db->where('user_id', $this->security->xss_clean($user_id));
			if(is_numeric($bbs_is_comment) && $bbs_is_comment==0){
				$this->db->where('bbs_is_comment', $bbs_is_comment);
			}else if(is_numeric($bbs_is_comment) && $bbs_is_comment>0){
				$this->db->where('bbs_is_comment != ', 0);
			}
			$this->db->order_by('bbs_index', 'ASC');
			$this->db->order_by('bbs_register', 'DESC');
			$this->db->limit($limit, $offset);
			$query = $this->db->get($this->db->dbprefix('write_'.$this->security->xss_clean($bbs_table)));
			return $query->result();
		}else{
			return false;
		}
	}
	/*
	public function get_write_board_list($bbs_table='', $offset, $limit=15, $cate='all', $sch_select='', $keyword='', $sort='', $select=''){
		if(!$this->check_board_name('bbs_table', $bbs_table) && (!empty($bbs_table) || !is_numeric($limit) || !is_numeric($offset))){
			$this->db->where('bbs_use', 'yes');
			if(!empty($select)){
				$this->db->select($select);
			}
			if($cate != 'all'){
				$this->db->where('bbs_cate', $this->security->xss_clean($cate));
			}
			if(!empty($sch_select) && !empty($keyword)){
				$this->setting_search_query($sch_select, $keyword);
			}
			$this->db->where('bbs_is_comment', 0);
			if($sort == 'sort_day'){
				$this->db->order_by('bbs_index', 'ASC');
				$this->db->order_by('bbs_register', 'DESC');
			}else{
				$this->db->order_by('bbs_index', 'ASC');
				$this->db->order_by('bbs_num', 'ASC');
			}
			// 리스트 불러올때 캐시 생성
			$query = $this->db->get($this->db->dbprefix('write_'.strtolower($bbs_table)), $limit, $offset);
			if($result = $query->result()){
				return $result;
			}else{
				return false;
			}
		}else{
			return false;
		}
	}
	*/
	// 게시글 얻어오기
	public function get_write_board($bbs_table='', $bbs_id, $select = false, $cut_comment=false){
		if(!empty($bbs_table) && is_numeric($bbs_id)){
			if($select){
				$this->db->select($this->security->xss_clean($select));
			}
			$this->db->where('bbs_use', 'yes');
			$this->db->where('bbs_id', $bbs_id);
			if($cut_comment){
				$this->db->where('bbs_is_comment', 0);
			}
			$query = $this->db->get($this->db->dbprefix('write_'.strtolower($this->security->xss_clean($bbs_table))));
			if($result = $query->result()){
				return $result;
			}else{
				return false;
			}
		}else{
			return false;
		}
	}
	public function get_write_board_user($bbs_table='', $bbs_id, $select = false, $cut_comment=false){
		if(!empty($bbs_table) && is_numeric($bbs_id)){
			if($select){
				$this->db->select($this->security->xss_clean($select));
			}
			$this->db->from($this->db->dbprefix('write_'.strtolower($this->security->xss_clean($bbs_table)).' as t'));
			$this->db->join($this->db->dbprefix('user as u'), 't.user_id = u.user_id', 'inner');
			$this->db->where('t.bbs_use', 'yes');
			$this->db->where('t.bbs_id', $bbs_id);
			if($cut_comment){
				$this->db->where('t.bbs_is_comment', 0);
			}
			$query = $this->db->get();
			if($result = $query->result()){
				return $result;
			}else{
				return false;
			}
		}else{
			return false;
		}
	}
	// 파일 얻어오기
	public function get_bbs_files($bbs_table, $bbs_id=0, $type='all', $select='all'){
		if($this->check_board_name('bbs_table', $bbs_table)){
			if($select !== 'all'){
				$this->db->select($select);
			}
			if($bbs_id > 0){
				$this->db->where('bf_bbs_id', $bbs_id);
			}
			$this->db->where('bf_table', $bbs_table);
			if($type != 'all'){
				$this->db->where('bf_type', $type);

			}
			$query = $this->db->get($this->db->dbprefix('board_files'));
			if($result = $query->result()){
				return $result;
			}else{
				return false;
			}
		}else{
			return false;
		}
	}
	// 파일 한개의 정보 얻어오기
	public function get_bbs_file($bf_id, $select = 'all'){
		if($select !== 'all'){
			$this->db->select($select);
		}
		$this->db->where('bf_id', $bf_id);
		$query = $this->db->get($this->db->dbprefix('board_files'));
		if($result = $query->row()){
			return $result;
		}else{
			return false;
		}
	}
	// 게시판관리에서 해당 게시판이 있는지 확인 있다면 결과값을 없다면  false 반환
	public function get_board($bbs_table){
		$bbs_table = $this->security->xss_clean($bbs_table);
		$this->db->where('bbs_table', $bbs_table);
		$query = $this->db->get($this->db->dbprefix('board_group'));
		return $result = $query->result();
		/*
		exit;
		if($query->num_rows() > 0){
			if($result = $query->result()){
				return $result;
			}else{
				return false;
			}
		}else{
			return false;
		}*/
	}
	// 게시글이 있는지 확인
	public function check_in_bbs_write($bbs_table, $bbs_id){
		$this->db->where('bbs_id', $bbs_id);
		return $this->db->count_all_results($this->db->dbprefix('write_'.$bbs_table));
	}
	// 게시판의 최신글을 지정 개수만큼 반환
	public function get_board_newlist($bbs_table, $num){
		if(!$this->check_board_name('bbs_table', $bbs_table)){
			$this->db->select('bbs_id, bbs_cate, bbs_link, bbs_subject, bbs_content, bbs_thumbnail, bbs_image, user_id, bbs_register');
			$this->db->where('bbs_parent', 0);
			$this->db->where('bbs_use', 'yes');
			//$this->db->order_by('bbs_index', 'ASC');
			//$this->db->order_by('bbs_num', 'ASC');
			$this->db->order_by('bbs_register', 'DESC');
			$query = $this->db->get($this->db->dbprefix('write_'.$bbs_table), $num, 0);
			if($result = $query->result()){
				return $result;
			}else{
				return false;
			}
		}else{
			return false;
		}
	}
	// 게시판 에서 선택한 아이디에 해당하는 글을 반환
	public function get_board_selectlist($bbs_table='', $ids, $select='bbs_id, bbs_thumbnail, bbs_subject'){
		if(empty($bbs_table) || count($ids) < 1){
			return false;
		}
		$this->db->select($select);
		for($i=0; $i<count($ids); $i++){
			if(!is_numeric($ids[$i])) return false;
			$this->db->or_where('bbs_id', $ids[$i]);
		}
		$query = $this->db->get($this->db->dbprefix('write_'.$this->security->xss_clean($bbs_table)));
		return $query->result();
	}
	// 이전글 다음글의 게시글 아이디 얻기
	public function get_board_next_prev($bbs_table, $bbs_num, $bbs_cate='all'){
	 	$prev = (int)$bbs_num + 1;
		$next = (int)$bbs_num - 1;
		$this->db->select('bbs_id');
		//$this->db->where('bbs_cate', $bbs_cate);
		$this->db->or_where('bbs_num', $prev);
		$this->db->or_where('bbs_num', $next);
		$query = $this->db->get($this->db->dbprefix('write_'.$this->security->xss_clean(strip_tags(strtolower(trim($bbs_table))))));
		return $query->result();
	 }
	public function get_board_nextlist($bbs_table, $bbs_num, $limit=1, $bbs_cate='all', $select='bbs_id'){
		if(!isset($bbs_table) || !is_numeric($bbs_num)){
			return false;
		}
		$this->db->select($select);
		$this->db->where('bbs_is_comment', 0);
		if($bbs_cate !== 'all')
			$this->db->where('bbs_cate', $bbs_cate);
		$this->db->where('bbs_num < ', $bbs_num);
		$this->db->where('bbs_use', 'yes');
		//$this->db->order_by('bbs_index', 'DESC');
		$this->db->order_by('bbs_num', 'DESC');
		$query = $this->db->get($this->db->dbprefix('write_'.$this->security->xss_clean(strip_tags(strtolower(trim($bbs_table))))), $limit);
		return $query->result();

	}
	public function get_board_prevlist($bbs_table, $bbs_num, $limit=1, $bbs_cate='all', $select='bbs_id'){
		if(!isset($bbs_table) || !is_numeric($bbs_num)){
			return false;
		}

		$this->db->select($select);
		$this->db->where('bbs_is_comment', 0);
		if($bbs_cate !== 'all')
			$this->db->where('bbs_cate', $bbs_cate);
		$this->db->where('bbs_num > ', $bbs_num);
		$this->db->where('bbs_use', 'yes');
		//$this->db->order_by('bbs_index', 'ASC');
		$this->db->order_by('bbs_num', 'ASC');
		$query = $this->db->get($this->db->dbprefix('write_'.$this->security->xss_clean(strip_tags(strtolower(trim($bbs_table))))), $limit);
		return $query->result();
	}
	// 게시판 관리 업데이트 - 관리자
	public function board_update($post){
		$this->load->helper('htmlpurifier');
		$data = array(
				'bbs_table'			=> $this->security->xss_clean(strip_tags(strtolower(trim($post['bbs_table'])))),
				'bbs_name_ko'		=> $this->security->xss_clean(strip_tags(addslashes(trim($post['bbs_name_ko'])))),
				'bbs_name_en'		=> $this->security->xss_clean(strip_tags(addslashes(trim($post['bbs_name_en'])))),
				'bbs_name_vn'		=> $this->security->xss_clean(strip_tags(addslashes(trim($post['bbs_name_vn'])))),
				'bbs_type'  		=> $this->security->xss_clean(strip_tags($post['bbs_type'])),
				'bbs_css_type'		=> $this->security->xss_clean(strip_tags($post['bbs_css_type'])),
				'bbs_sort_type'		=> $this->security->xss_clean(strip_tags($post['bbs_sort_type'])),
				'bbs_1depth' 		=> $this->security->xss_clean(strip_tags($post['bbs_1depth'])),
				'bbs_page_tophtml'  => html_purify($post['bbs_page_tophtml'], 'admin_html'),
				'bbs_cate_list' 	=> $this->security->xss_clean(strip_tags(addslashes($post['bbs_cate_list']))),
				'bbs_adm_lv' 		=> $this->security->xss_clean(strip_tags($post['bbs_adm_lv'])),
				'bbs_list_lv' 		=> $this->security->xss_clean(strip_tags($post['bbs_list_lv'])),
				'bbs_read_lv' 		=> $this->security->xss_clean(strip_tags($post['bbs_read_lv'])),
				'bbs_write_lv' 		=> $this->security->xss_clean(strip_tags($post['bbs_write_lv'])),
				//'bbs_reply_lv' 		=> $this->security->xss_clean(strip_tags($post['bbs_reply_lv'])),
				'bbs_comment_lv' 	=> $this->security->xss_clean(strip_tags($post['bbs_comment_lv'])),
				'bbs_list_num'		=> $this->security->xss_clean(strip_tags($post['bbs_list_num'])),
				'bbs_feed'			=> $this->security->xss_clean(strip_tags($post['bbs_feed']))
			);
		if($post['bbs_mode'] == 'insert'){
			if($this->check_board_name('bbs_table', $post['bbs_table']) && $this->check_board_name('bbs_name_ko', $post['bbs_name_ko'])){
				$data['bbs_register'] = date('Y-m-d H:i:s', time());
				if($this->db->insert($this->db->dbprefix('board_group'), $data)){
					if($this->create_board_table($post['bbs_table'])){
						return true;
					}else{
						$this->db->where('bbs_table', $post['bbs_table']);
						$this->db->delete($this->db->dbprefix('board_group'));
						return false;
					}
				}else{
					return false;
				}
			}else{
				return false;
			}
		}else if($post['bbs_mode'] == 'modify'){
			$this->db->where('bbs_table', $post['bbs_table']);
			if($this->db->update($this->db->dbprefix('board_group'), $data)){
				return true;
			}else{
				return false;
			}
		}else{
			return false;
		}
	}
	// 게시판 테이블 삭제
	public function board_delete($post){
		$drop_table = array();
		$drop_table_sql = 'drop table';
		$len = 0;
		foreach($post['chk'] as $val){
			$this->db->or_where('bbs_table', $this->security->xss_clean($val));
			$drop_table[] = $this->db->dbprefix('write_'.$this->security->xss_clean($val));
			$drop_table[] = $this->db->dbprefix('write_'.$this->security->xss_clean($val).'_fa');
			$drop_table_sql .= ($len==0) ? ' `%s`, `%s`' : ', `%s`, `%s`';
			$len++;
		}
		if($this->db->delete($this->db->dbprefix('board_group'))){
			$this->db->query('SET foreign_key_checks = 0');
			$this->db->query(vsprintf($drop_table_sql, $drop_table));
			$this->db->query('SET foreign_key_checks = 1');
			for($i=0, $tlen = count($drop_table); $i<$tlen; $i++){
				$this->db->or_where_in('bf_table', $drop_table[$i]);
			}
			$this->db->delete($this->db->dbprefix('board_files'));
			return true;
		}else{
			return false;
		}
	}
	// 게시판 게시글 삭제전 삭제하려는 사람이 글쓴이 인가 게시판 관리자인가 확인
	public function update_usercheck($post, $bbs_table=null){
		$bbs_table = ($bbs_table===null)?$post['bbs_table']:$bbs_table;
		$user_id 	= $this->encryption->decrypt($this->session->userdata('user_id'));
		$bbs_info 	= $this->get_board($bbs_table);
		if($bbs_info && isset($user_id)){
			if($bbs_info[0]->bbs_adm_lv <= $this->session->userdata('user_level')){
				return true;
			}else{
				$write_user_id = $this->get_board_selectlist($bbs_table, $post['bbs_id'], 'user_id');
				if($user_id === $write_user_id[0]->user_id && count($post['bbs_id']) == 1){
					return true;
				}else{
					return false;
				}
				return false;
			}
		}else{
			return false;
		}
	}
	// 게시판 게시글 삭제
	public function board_write_delete($post){
		$bbs_id_arr 		= $post['bbs_id'];
		$bbs_table 			= $post['bbs_table'];
		$result 			= array();
		$len 				= 0;
		// 파일, 리스트이미지, 섬네일, 컨텐츠이미지가 있는지 확인해서 삭제하기 위한 변수
		$check_files_result = '';
		$bbs_is_files 		= array();
		if(count($bbs_id_arr)> 0 && !$this->check_board_name('bbs_table', $bbs_table)){
			foreach($bbs_id_arr as $bbs_id){
				if(!is_numeric($bbs_id)){
					$result['error'] 	= true;
					$result['error_code']	= '0001';
					return $result;
				}
				// 해당아이디에 파일, 리스트이미지, 섬네일, 컨텐츠이미지가 있는지 확인
				$check_files_result = $this->get_write_board($bbs_table, $bbs_id);
				$bbs_is_files[] = array(
					'bbs_table'			=> $this->db->dbprefix("write_".$bbs_table),
					'bbs_id' 			=> $bbs_id,
					'bbs_file' 			=> $check_files_result[0]->bbs_file,
					'bbs_image' 		=> $check_files_result[0]->bbs_image,
					'bbs_thumbnail' 	=> $check_files_result[0]->bbs_thumbnail,
					'bbs_content_imgs' 	=> $check_files_result[0]->bbs_content_imgs
				);
				$check_files_result = '';
			}
			foreach($bbs_id_arr as $bbs_id){
				if($len == 0){
					$this->db->where('bbs_id', $bbs_id);
				}else{
					$this->db->or_where('bbs_id', $bbs_id);
				}
				$len++;
			}
			// 삭제 캐시도 삭제
			// $this->db->cache_delete_all();
			$this->db->cache_delete('board', 'list');
			$this->db->cache_delete('ko', 'board');
			$this->db->cache_delete('vn', 'board');
			$this->db->cache_delete('en', 'board');
			if($this->db->delete($this->db->dbprefix('write_'.$bbs_table))){
				// 댓글처리 -1 댓글은 남김
				$update_comment = array();
				foreach($bbs_id_arr as $bbs_id){
					$update_comment[] = array(
						'bbs_parent' 	=> $bbs_id,
						'bbs_is_comment'	=> '-1'
					);
				}
				$this->db->update_batch($this->db->dbprefix('write_'.$bbs_table), $update_comment, 'bbs_parent');
				// 파일처리
				for($i=0; $i<count($bbs_is_files); $i++){
					if($bbs_is_files[$i]['bbs_file']>0){
						// 해당파일에대한 경로 구해와서 전부 삭제 시키고 나서 나머지 파일들 삭제 시킨다... 뭔지 모르겠지만 1개가 삭제 안된다 다음에 ...
						$files_result = $this->get_bbs_files($this->db->dbprefix('write_'.$bbs_table), $bbs_is_files[$i]['bbs_id'], $type='files', 'bf_full_path');
						for($j=0; $j<count($files_result); $j++){
							@unlink($files_result[$j]->bf_full_path);
						}
						$this->db->where('bf_bbs_id', $bbs_is_files[$i]['bbs_id']);
						$this->db->where('bf_table', $bbs_is_files[$i]['bbs_table']);
						$this->db->delete($this->db->dbprefix('board_files'));
					}
					if(!empty($bbs_is_files[$i]['bbs_image'])){
						$this->board_write_delete_files($bbs_is_files[$i]['bbs_image']);
					}
					if(!empty($bbs_is_files[$i]['bbs_thumbnail'])){
						//echo $bbs_is_files[$i]['bbs_thumbnail'];
						$this->board_write_delete_files($bbs_is_files[$i]['bbs_thumbnail']);
					}
					if(!empty($bbs_is_files[$i]['bbs_content_imgs'])){
						$content_imgs = explode(",",$bbs_is_files[$i]['bbs_content_imgs']);
						$this->board_write_delete_files($content_imgs, true, CKEDITOR_PATH.'/'.$bbs_table.'/');
					}
				}
				$result['error'] = false;
				return $result;
			}else{
				$result['error'] 	= true;
				$result['error_code']	= '0002';
				return $result;
			}
		}else{
			$result['error'] 	= true;
			$result['error_code']	= '0003';
			return $result;
		}
	}
	// 게시글 작성
	/*
	 * 리스트 이미지 파일을 업로드 시키면 썸네일이 생이고 리스트 이미지는 본문에 첫번재 이미지로 나온다.
	 */
	public function board_write($post, $bbs_files=''){
		$this->load->library('image_lib');
		$this->load->helper('htmlpurifier');
		$bbs_table 		= trim(strtolower($this->security->xss_clean(strip_tags($post['bbs_table']))));
		$copyImgFile 	= isset($post['copyImgFileNames'])?trim($this->security->xss_clean(strip_tags($post['copyImgFileNames']))):'';
		$bbs_content	= trim($post['bbs_content']);
		$imgFiles 		= '';
		$bbs_file 		= 0;
		$bbs_image      = '';
		$thumb_img 		= '';
		$ckeditor_dir 	= CKEDITOR_PATH.'/'.$bbs_table."/";
		// cheitor 이미지파일이 에디터창에서 삭제되지 않고 넘어왔는지 검사
		if(!empty($copyImgFile)){
			$this->ckeditor->set_default_dir($ckeditor_dir);
			//$imgFiles = $this->ckeditor->check_upload_imgfiles($copyImgFile, $bbs_content, "/\/assets\/img\/ckeditor\/\w+\/\w+\.\w{3,4}/");
			$imgFiles = $this->ckeditor->check_upload_imgfiles($copyImgFile, $bbs_content, "/\/assets\/img\/ckeditor\/".$bbs_table."\/\w+\.\w{3,4}/", 5);
		}
		// table 태그에 fixed div 감싸기
		$bbs_content = $this->set_html_fixed_table($bbs_content);
		// 1. 게시글 등록
		$bbs_num = $this->get_next_num($bbs_table);
		$data = array(
			'bbs_secret'		=> (isset($post['bbs_secret']))?$post['bbs_secret']:'no',
			'bbs_num' 			=> $bbs_num,
			'bbs_index'			=> (isset($post['bbs_index'])) ? (int)trim($this->security->xss_clean(strip_tags(addslashes($post['bbs_index'])))) : 0,
			'bbs_cate' 			=> (isset($post['bbs_cate'])) ? trim($this->security->xss_clean(strip_tags(addslashes($post['bbs_cate'])))) : '',
			'bbs_link' 			=> (isset($post['bbs_link'])) ? trim($this->security->xss_clean(strip_tags(addslashes($post['bbs_link'])))) : '',
			'bbs_subject' 		=> (isset($post['bbs_subject'])) ? trim($this->security->xss_clean(addslashes($post['bbs_subject']))) : '',
			'bbs_content' 		=> (isset($post['admin_write_mode']) && $post['admin_write_mode'] == 'admin_write_mode') ? clean_xss_tags(html_purify($bbs_content, 'admin_html')) : clean_xss_tags(html_purify($bbs_content, 'comment')),
			'bbs_content_imgs' 	=> trim(strip_tags($imgFiles)),
			'bbs_extra1'		=> (isset($post['bbs_extra1'])) ? trim($this->security->xss_clean(strip_tags(addslashes($post['bbs_extra1'])))) : '',
			'bbs_extra2'		=> (isset($post['bbs_extra2'])) ? trim($this->security->xss_clean(strip_tags(addslashes($post['bbs_extra2'])))) : '',
			'bbs_extra3'		=> (isset($post['bbs_extra3'])) ? trim($this->security->xss_clean(strip_tags(addslashes($post['bbs_extra3'])))) : '',
			'user_id'			=> $this->encryption->decrypt($this->session->userdata('user_id')),
			'user_name'			=> $this->security->xss_clean(strip_tags($this->session->userdata('user_name'))),
			'user_ip'			=> $_SERVER['REMOTE_ADDR'],
			'bbs_register'		=> date('Y-m-d H:i:s', time()),
			'bbs_use' 			=> (isset($post['bbs_use'])) ? trim($this->security->xss_clean(addslashes(strip_tags($post['bbs_use'])))) : 'yes'
		);
		// 작성했으니 캐시 삭제 리스트만 쓰니까 리스트만 지운다.
		//$this->db->cache_delete_all();
		$this->db->cache_delete('board', 'list');
		$this->db->cache_delete('ko', 'board');
		$this->db->cache_delete('vn', 'board');
		$this->db->cache_delete('en', 'board');
		if(!$this->db->insert($this->db->dbprefix('write_'.$bbs_table), $data)){
			return false;
		}
		$last_id = $this->db->insert_id();
		// 2. 파일등록
		// 카드형, 게시판형 리스트이미지
		if(isset($bbs_files['bbs_images'])){
			$list_img_data = array();
			for($i=0; $i< count($bbs_files['bbs_images']); $i++){

				$list_img_data[] = $this->set_files_db($post['bbs_table'], $bbs_files['bbs_images'][$i], $last_id, 'list');
				$this->create_thumb($bbs_files['bbs_images'][$i]['full_path']);
			}
			$this->db->insert_batch($this->db->dbprefix('board_files'), $list_img_data);
			$bbs_image = "/".str_replace(FCPATH, "", $bbs_files['bbs_images'][0]['file_path']).$bbs_files['bbs_images'][0]['file_name'];
			$thumb_img  = "/".str_replace(FCPATH, "", $bbs_files['bbs_images'][0]['file_path']).$bbs_files['bbs_images'][0]['raw_name'].'_thumb'.$bbs_files['bbs_images'][0]['file_ext'];
			$bbs_file = 1;
		}
		/*
		 * 리스트 이미지가 없고 본문에 이미지가 있다면 첫번째 이미지를 썸네일 파일로 만든다..
		 */
		if(empty($thumb_img) && !empty($imgFiles)){
			$imgfile_first = explode(",", $imgFiles);
			$this->create_thumb(delete_last_slashtag(FCPATH).$ckeditor_dir.$imgfile_first[0]);
			$ext = preg_replace('/^.*\.([^.]+)$/D', '.$1', $imgfile_first[0]);
			$thumb_img = $ckeditor_dir.str_replace($ext, "", $imgfile_first[0]).'_thumb'.$ext;
		}
		// 게시판 업로드 파일
		if(isset($bbs_files['bbs_file'])){
			$file_data = array();
			for($i=0; $i< count($bbs_files['bbs_file']); $i++){
				$file_data[] = $this->set_files_db($bbs_table, $bbs_files['bbs_file'][$i], $last_id);
			}
			$this->db->insert_batch($this->db->dbprefix('board_files'), $file_data);
			$bbs_file = 1;
		}
		// 게시글에 파일등록된 부분 업데이트
		if($bbs_file == 1 || !empty($thumb_img)){
			$data = array(
				'bbs_thumbnail'		=> $thumb_img,
				'bbs_image' 		=> $bbs_image,
				'bbs_file'			=> $bbs_file
			);
			$this->db->where('bbs_id', $last_id);
			$this->db->update($this->db->dbprefix('write_'.$bbs_table), $data);
		}
		return $last_id;
	}
	// 게시글 수정     파일부분을 protected 함수로 만들어서 게시글작성과 수정에서 공유한다..
	public function board_write_update($post, $bbs_files){
		$this->load->library('image_lib');
		$this->load->helper('htmlpurifier');
		/*
		 * bbs_files 이 있다면 원래 list 파일이 있는지 썸네일이 있는지 검사해서 없다면 등록 있다면 삭제하고 등록.
		 * $bbs_files -> bbs_images=list이미지 (1개), bbs_file=파일등록 (2개), is_error 구분되어있음
		 */
		$bbs_table 		= trim(strtolower($this->security->xss_clean(strip_tags($post['bbs_table']))));
		$copyImgFile 	= trim($this->security->xss_clean(strip_tags($post['copyImgFileNames'])));
		$bbs_content	= clean_xss_tags(trim($post['bbs_content']));
		$imgFiles 		= '';
		$bbs_file 		= 0;
		$bbs_image      = '';
		$thumb_img 		= '';
		$ckeditor_dir 	= CKEDITOR_PATH.'/'.$bbs_table."/";
		/* qna 게시판이라면 extra1 => 진행상황에 값이 있다면 return false */
		if($bbs_table == 'qna'){
			if(isset($post['bbs_extra1']) && $post['bbs_extra1'] !== ''){
				$return_data = array('error_code' => '1001');
				return $return_data;
			}
		}
		// cheitor 이미지파일이 에디터창에서 삭제되지 않고 넘어왔는지 검사
		if(!empty($copyImgFile)){
			$this->ckeditor->set_default_dir($ckeditor_dir);
			$imgFiles = $this->ckeditor->check_upload_imgfiles($copyImgFile, $bbs_content, "/\/assets\/img\/ckeditor\/".$bbs_table."\/\w+\.\w{3,4}/", 5);
		}
		// table 태그에 fixed div 감싸기
		//$bbs_content = $this->set_html_fixed_table($bbs_content);
		// 1. 게시글 등록
		//$bbs_num = $this->get_next_num($bbs_table);
		$data = array(
			'bbs_secret'		=> (isset($post['bbs_secret']))?$post['bbs_secret']:no,
			'bbs_index'			=> (isset($post['bbs_index'])) ? (int)trim($this->security->xss_clean(strip_tags(addslashes($post['bbs_index'])))) : 0,
			'bbs_cate' 			=> (isset($post['bbs_cate'])) ? trim($this->security->xss_clean(strip_tags($post['bbs_cate']))) : '',
			'bbs_link' 			=> (isset($post['bbs_link'])) ? trim($this->security->xss_clean(strip_tags($post['bbs_link']))):'',
			'bbs_subject' 		=> trim($this->security->xss_clean(addslashes($post['bbs_subject']))),
			'bbs_content' 		=> (isset($post['admin_write_mode']) && $post['admin_write_mode'] == 'admin_write_mode') ? html_purify($bbs_content, 'admin_html') : html_purify($bbs_content, 'comment'),
			'bbs_content_imgs' 	=> trim(strip_tags($imgFiles)),
			'bbs_extra1'		=> (isset($post['bbs_extra1'])) ? trim($this->security->xss_clean(strip_tags(addslashes($post['bbs_extra1'])))) : '',
			'bbs_extra2'		=> (isset($post['bbs_extra2'])) ? trim($this->security->xss_clean(strip_tags(addslashes($post['bbs_extra2'])))) : '',
			'bbs_extra3'		=> (isset($post['bbs_extra3'])) ? trim($this->security->xss_clean(strip_tags(addslashes($post['bbs_extra3'])))) : '',
			'user_ip'			=> $_SERVER['REMOTE_ADDR'],
			'bbs_last'			=> date('Y-m-d H:i:s', time()),
			'bbs_use' 			=> (isset($post['bbs_use'])) ? trim($this->security->xss_clean(addslashes(strip_tags($post['bbs_use'])))) : 'yes'
		);
		// 업데이트 하니까 캐시 삭제
		// $this->db->cache_delete_all();
		$this->db->cache_delete('board', 'list');
		$this->db->cache_delete('ko', 'board');
		$this->db->cache_delete('vn', 'board');
		$this->db->cache_delete('en', 'board');
		$this->db->where('bbs_id', $post['bbs_id']);
		//$this->db->where('ser_id');
		if(!$this->db->update($this->db->dbprefix('write_'.$bbs_table), $data)){
			return false;
		}
		$last_id = $post['bbs_id'];
		// 2. 파일등록
		// 카드형, 게시판형 리스트이미지
		if(isset($bbs_files['bbs_images'])){
			$list_img_data = array();

			for($i=0; $i< count($bbs_files['bbs_images']); $i++){
				$list_img_data[] = $this->set_files_db($post['bbs_table'], $bbs_files['bbs_images'][$i], $last_id, 'list');
				$this->create_thumb($bbs_files['bbs_images'][$i]['full_path']);
			}
		// psu_board_files 테이블에서  $post['bbs_id'] 값을 가진 list 파일이 있는지 검사
		// 있다면 update
		// 없다면 insert
			$old_list_file = $this->get_bbs_files($this->db->dbprefix('write_'.$bbs_table), $last_id, $type='list');
			if($old_list_file){
				$old_thumbnail = $this->get_write_board($bbs_table, $last_id, "bbs_thumbnail");
				// 원래있던 썸네일 삭제
				$this->board_write_delete_files($old_thumbnail[0]->bbs_thumbnail);
				@unlink($old_list_file[0]->bf_full_path);
				$list_img_data[0][$this->db->protect_identifiers('bf_id')] = $old_list_file[0]->bf_id;
				$this->db->update_batch($this->db->dbprefix('board_files'), $list_img_data, $this->db->protect_identifiers('bf_id'));

			}else{
				$this->db->insert_batch($this->db->dbprefix('board_files'), $list_img_data);
			}
			$bbs_image = "/".str_replace(FCPATH, "", $bbs_files['bbs_images'][0]['file_path']).$bbs_files['bbs_images'][0]['file_name'];
			$thumb_img  = "/".str_replace(FCPATH, "", $bbs_files['bbs_images'][0]['file_path']).$bbs_files['bbs_images'][0]['raw_name'].'_thumb'.$bbs_files['bbs_images'][0]['file_ext'];
			$bbs_file = 1;
		}else{
			if(isset($post['bbs_image_del']) && is_numeric($post['bbs_image_del'])){
				$del_list_img = $this->get_write_board($bbs_table, $last_id, "bbs_thumbnail, bbs_image");
				if($this->delete_board_file($post['bbs_image_del'])){
					$this->board_write_delete_files($del_list_img[0]->bbs_thumbnail);
					$this->board_write_delete_files($del_list_img[0]->bbs_image);
					$checktest = $this->get_bbs_files($this->db->dbprefix("write_".$bbs_table), $last_id, 'files');
					if($checktest){
						$bbs_file = 1;
					}else{
						$bbs_file = 0;
					}
					$list_img = array(
						'bbs_thumbnail'		=> '',
						'bbs_image' 		=> '',
						'bbs_file'			=> $bbs_file
					);
					$this->db->where('bbs_id', $post['bbs_id']);
					$this->db->update($this->db->dbprefix('write_'.$bbs_table), $list_img);
				}
			}
		}
		/*
		 * 리스트 이미지가 없고 본문에 이미지가 있다면 첫번째 이미지를 썸네일 파일로 만든다..
		 * 넘어온 1번째 변수와 비교를해서어어어어엉엉~~~
		 * 이건 지금은 안씀..
		 **/
		// echo "썸네일 ".$thumb_img."<br />";
		// echo "이미지파일 ".$imgFiles."<br />";
		// echo "원래파일 ".$copyImgFile."<br />";
		//exit;
		if((empty($thumb_img) && !empty($imgFiles)) && $imgFiles != $copyImgFile){
			$imgfile_first = explode(",", $imgFiles);
			$this->create_thumb(delete_last_slashtag(FCPATH).$ckeditor_dir.$imgfile_first[0]);
			$ext = preg_replace('/^.*\.([^.]+)$/D', '.$1', $imgfile_first[0]);
			$thumb_img = $ckeditor_dir.str_replace($ext, "", $imgfile_first[0]).'_thumb'.$ext;
		}

		// 게시판 업로드 파일
		if(isset($bbs_files['bbs_file'])){
			// 우선적으로 삭제버튼이 킄릭됬는지를 비교해서 있다면 삭제부터함
			$bbs_file_del_num = count($post['bbs_files_del']);
			if($bbs_file_del_num > 0){
				for($i=0; $i<$bbs_file_del_num; $i++){
					$bf_id = $post['bbs_files_del'][$i];
					$result =  $this->get_bbs_file($bf_id, 'bf_full_path');
					@unlink($result->bf_full_path);
					$this->delete_board_file($bf_id);
				}
			}
			$file_data = array();
			$file_update_data = array();
			// 업로드파일이 있다면 일단 디비에서 파일이 있는지 확인한다.
			// 파일이 없다면 처음 올리는거 파일이 있다면 몇개인지  파일첨부 가능 수가 몇개인지 비교해서  파일첨부 가능수보다 작으면 등록 이상이면 몇번째인지 확인해서 덮어씌움
			$old_bbs_files = $this->get_bbs_files($this->db->dbprefix('write_'.$bbs_table), $last_id, 'files');
			if($old_bbs_files){
				// 업로드된 파일이 있다면
				$file_num 	  = count($bbs_files['bbs_file']);
				$old_file_num = count($old_bbs_files);
				// 포믄을 파일갯수 만큼 돌림 파일의 index값과 원래 있던 파일의 수를 비교
				for($i=0; $i<$file_num; $i++){
					$index = $bbs_files['bbs_file'][$i]['index'];
					if(isset($old_bbs_files[$index])){
						// 기존파일이 있다. 기존파일 삭제 및 업데이트
						@unlink($old_bbs_files[$index]->bf_full_path);
						$file_update_data[] = $this->set_files_db($bbs_table, $bbs_files['bbs_file'][$i], $old_bbs_files[$index]->bf_bbs_id, 'files', $old_bbs_files[$index]->bf_id);
					}else{
						// 기존파일이 없다. 새로 등록
						$file_data[] = $this->set_files_db($bbs_table, $bbs_files['bbs_file'][$i], $last_id);
					}
				}
			}else{
				for($i=0; $i< count($bbs_files['bbs_file']); $i++){
					$file_data[] = $this->set_files_db($bbs_table, $bbs_files['bbs_file'][$i], $last_id);
				}
			}
			if(count($file_update_data) > 0){
				$this->db->update_batch($this->db->dbprefix('board_files'), $file_update_data, $this->db->protect_identifiers('bf_id'));
			}
			if(count($file_data) > 0){
				$this->db->insert_batch($this->db->dbprefix('board_files'), $file_data);
			}
			$bbs_file = 1;
		}else{
			// 파일이 없고 파일 삭제 버튼이 있다면
			$bbs_file_del_num = (isset($post['bbs_files_del']))?count($post['bbs_files_del']):0;
			if($bbs_file_del_num > 0){
				for($i=0; $i<$bbs_file_del_num; $i++){
					$bf_id = $post['bbs_files_del'][$i];
					$result =  $this->get_bbs_file($bf_id, 'bf_full_path');
					@unlink($result->bf_full_path);
					$this->delete_board_file($bf_id);
				}
			}
		}
		// 게시글에 파일등록된 부분 업데이트
		if($bbs_file == 1 && !empty($thumb_img)){
			$data = array(
				'bbs_thumbnail'		=> $thumb_img,
				'bbs_image' 		=> $bbs_image,
				'bbs_file'			=> $bbs_file
			);
		}else if($bbs_file == 1){
			$data = array(
				'bbs_file'			=> $bbs_file
			);
		}else if(!empty($thumb_img)){
			$data = array(
				'bbs_thumbnail'		=> $thumb_img
			);
			// 원래있던 썸네일 삭제!
			$old_thumbnail = $this->get_write_board($bbs_table, $post['bbs_id'], 'bbs_thumbnail');
			$this->board_write_delete_files($old_thumbnail[0]->bbs_thumbnail);
		}
		$this->db->where('bbs_id', $last_id);
		$this->db->update($this->db->dbprefix('write_'.$bbs_table), $data);
		return true;
	}
	// 파일테이블에서 파일 삭제
	public function delete_board_file($bf_id){
		if(!is_numeric($bf_id)){
			return false;
		}else{
			$this->db->where('bf_id', $bf_id);
			$result = $this->db->delete($this->db->dbprefix('board_files'));
			if($result){
				return true;
			}else{
				return false;
			}
		}
	}
	// 댓글등록 typeA
	public function add_comment($post){
		$bbs_table 			= trim(strtolower(strip_tags($post['bbs_table'])));
		$bbs_id 			= $post['bbs_id'];
		$bbs_num			= $post['bbs_num'];
		$result 			= array('error'=>true);
		$user_id			= '';
		$bbs_pwd			= '';
		if(!is_numeric($bbs_id) || !is_numeric($bbs_num) || empty($bbs_table)){
			$result['msg'] 	= '잘못된 접근 방식입니다.';
			return $result;
		}
		$bbs_is_comment  	= (isset($post['bbs_is_comment']))?$post['bbs_is_comment']:1;
		$bbs_comment_parent = (isset($post['bbs_comment_parent']))?$post['bbs_comment_parent']:0;
		$bbs_comment_num 	= $this->get_comment_next_num($bbs_table, $bbs_id, $bbs_is_comment, $bbs_comment_parent);

		if($this->check_in_bbs_write($bbs_table, $bbs_id) > 0){
			if($bbs_is_comment > 1 && $this->check_in_bbs_write($bbs_table, $bbs_id) == 0){
				//$result['msg'] = '삭제된 댓글입니다.';
				//return $result;
			}
			if(($this->session->userdata('user_id') && $this->encryption->decrypt($post['user_id']) == $this->encryption->decrypt($this->session->userdata('user_id'))) || (!$this->session->userdata('user_id') && $this->encryption->decrypt($post['user_id']) == 'nonmember')){
				$user_id = addslashes($this->encryption->decrypt($post['user_id']));
				if(!$this->session->userdata('user_id') && $this->encryption->decrypt($post['user_id']) == 'nonmember'){
					$bbs_pwd = password_hash($post['bbs_pwd'], PASSWORD_DEFAULT);
				}
			}else{
				$result['msg'] = '댓글 저장 실패 잠시 후 다시 시도해 주세요.';
				return $result;
			}
			$data = array(
				'bbs_num' 			=> $bbs_num,
				'bbs_parent'		=> $bbs_id,
				'bbs_is_comment'	=> $bbs_is_comment,
				'bbs_comment_num'	=> $bbs_comment_num,
				'bbs_comment_parent'=> $bbs_comment_parent,
				'bbs_content' 		=> addslashes($post['bbs_content']),
				'user_id'			=> $user_id,
				'user_name'			=> addslashes($post['user_name']),
				'bbs_pwd'			=> $bbs_pwd,
				'user_ip'			=> $_SERVER['REMOTE_ADDR'],
				'bbs_register'		=> date('Y-m-d H:i:s', time())
			);
			if($this->db->insert($this->db->dbprefix('write_'.$bbs_table), $data)){
				if($bbs_is_comment > 1){
					$this->db->set('bbs_comment', 'bbs_comment+1', FALSE);
					$this->db->where('bbs_id', $bbs_comment_parent);
					$this->db->update($this->db->dbprefix('write_'.$bbs_table));
				}
				$this->db->set('bbs_comment', 'bbs_comment+1', FALSE);
				$this->db->where('bbs_id', $bbs_id);
				$this->db->cache_delete('board', 'list');
				$this->db->cache_delete('ko', 'board');
				$this->db->cache_delete('vn', 'board');
				$this->db->cache_delete('en', 'board');
				$this->db->update($this->db->dbprefix('write_'.$bbs_table));
				$result['error'] = false;
				return $result;
			}else{
				$result['msg'] = '댓글 저장 실패 잠시 후 다시 시도해 주세요.';
				return $result;
			}
		}else{
			$result['msg'] = '삭제된 게시글입니다.';
			return $result;
		}
	}
	// 해당글의 댓글 전체갯수 가져오기
	public function get_comment_total($bbs_table='', $bbs_parent='', $bbs_is_comment=1, $comment_parent=0){
		if(!is_numeric($bbs_parent) || empty($bbs_table)){
			return false;
		}
		$bbs_table = $this->security->xss_clean($bbs_table);
		$this->db->where('bbs_parent', $bbs_parent);
		$this->db->where('bbs_is_comment', $bbs_is_comment);
		if($comment_parent > 0 && $bbs_is_comment > 1){
			$this->db->where('bbs_comment_parent', $comment_parent);
		}
		return $this->db->count_all_results($this->db->dbprefix('write_'.$this->security->xss_clean($bbs_table)));
	}
	// 해당글의 댓글 목록 가져오기
	public function get_comment_list($bbs_table='', $bbs_id=''){
		if(!is_numeric($bbs_id) || empty($bbs_table)){
			return false;
		}
		$bbs_table = $this->security->xss_clean($bbs_table);
		$this->db->where('bbs_parent', $bbs_id);
		$this->db->where('bbs_is_comment', 1);
		$this->db->order_by('bbs_comment_num', 'ASC');
		$query = $this->db->get($this->db->dbprefix('write_'.$this->security->xss_clean($bbs_table)));
		return $query->result();
	}
	// 해당글의 댓글 목록과 댓글단 회원 정보 조인해서 가져오기
	public function get_comment_list_join($bbs_table='', $bbs_parent='', $comment_limit=10, $comment_start=0, $bbs_is_comment=1, $bbs_comment_parent=0, $list_last_id=''){
		if(!is_numeric($bbs_parent) || empty($bbs_table)){
			return false;
		}
		$bbs_table = $this->security->xss_clean($bbs_table);
		//회원정보 쪼인
		$this->db->select('u.user_no, u.user_email, u.user_nick, u.user_type, u.user_level, u.unregister, b.bbs_id, b.bbs_parent, b.bbs_is_comment, b.bbs_comment, b.bbs_comment_num, b.bbs_comment_parent, b.bbs_content, b.bbs_good, b.bbs_nogood, b.user_id, b.user_name, b.bbs_pwd, b.user_ip, b.bbs_register');
		$this->db->from($this->db->dbprefix('write_'.$this->security->xss_clean($bbs_table).' as b'));
		$this->db->join($this->db->dbprefix('user as u'), 'b.user_id = u.user_id', 'left');
		$this->db->where('b.bbs_parent', $bbs_parent);
		$this->db->where('b.bbs_is_comment', $bbs_is_comment);
		if($bbs_is_comment > 1 && $bbs_comment_parent >0){
			$this->db->where('b.bbs_comment_parent', $bbs_comment_parent);
		}
		if(is_numeric($list_last_id)){
			$this->db->where('b.bbs_id <', $list_last_id) ;
		}
		$this->db->limit($comment_limit, $comment_start);
		$this->db->order_by('b.bbs_comment_num', 'ASC');
		$query = $this->db->get();
		return $query->result();
	}
	// 댓글 삭제.
	//delete_comment($bbs_table, $bbs_id, $bbs_parent, $bbs_is_comment, $bbs_comment_parent))
	public function delete_comment($bbs_table, $bbs_id, $bbs_parent, $bbs_is_comment, $bbs_comment_parent){
		if(!is_numeric($bbs_id) || !is_numeric($bbs_parent) || empty($bbs_table)){
			return false;
		}
		$bbs_table = $this->security->xss_clean($bbs_table);
		$child_comment = 0;
		if($bbs_is_comment>0 && $bbs_is_comment == 1){
			// 1뎁스 댓글 지우기전에 2뎁스 댓글이 몇개나 있는지 구해오자.
			$this->db->where('bbs_comment_parent', $bbs_id);
			$query = $this->db->get($this->db->dbprefix('write_'.$bbs_table));
			$child_comment = $query->num_rows();
		}
		$this->db->where('bbs_id', $bbs_id);
		if($this->db->delete($this->db->dbprefix('write_'.$bbs_table))){
			if($bbs_is_comment>0 && $bbs_is_comment == 1){
				$this->db->set('bbs_comment', 'bbs_comment-'.($child_comment+1), FALSE);
				$this->db->where('bbs_id', $bbs_parent);
				$this->db->update($this->db->dbprefix('write_'.$bbs_table));
				$this->db->where('bbs_comment_parent', $bbs_id);
				$this->db->cache_delete('board', 'list');
				$this->db->cache_delete('ko', 'board');
				$this->db->cache_delete('vn', 'board');
				$this->db->cache_delete('en', 'board');
				return $this->db->delete($this->db->dbprefix('write_'.$bbs_table));

			}else if($bbs_is_comment>1 && $bbs_comment_parent > 0){
				/*
				$this->db->set('bbs_comment', 'bbs_comment-1', FALSE);
				$this->db->where('bbs_id', $bbs_comment_parent);
				*/
				$this->db->set('bbs_comment', 'bbs_comment-1', FALSE);
				$this->db->where('bbs_id', $bbs_parent);
				$this->db->update($this->db->dbprefix('write_'.$bbs_table));
				$this->db->set('bbs_comment', 'bbs_comment-1', FALSE);
				$this->db->where('bbs_id', $bbs_comment_parent);
				$this->db->cache_delete('board', 'list');
				$this->db->cache_delete('ko', 'board');
				$this->db->cache_delete('vn', 'board');
				$this->db->cache_delete('en', 'board');
				return $this->db->update($this->db->dbprefix('write_'.$bbs_table));
			}
			/*
			if($this->db->update($this->db->dbprefix('write_'.$bbs_table))){
				$this->db->where('bbs_comment_parent', $bbs_id);
				return $this->db->delete($this->db->dbprefix('write_'.$bbs_table));
			}*/
		}else{
			return false;
		}
	}
	private function get_comment_next_num($bbs_table, $bbs_id, $bbs_is_comment=0, $bbs_comment_parent=0){
		$this->db->select("min(bbs_comment_num) as min_bbs_num");
		$this->db->where('bbs_parent', $bbs_id);
		$this->db->where('bbs_is_comment', $bbs_is_comment);
		$this->db->where('bbs_comment_parent', $bbs_comment_parent);
		$query = $this->db->get($this->db->dbprefix('write_'.$bbs_table));
		$row = $query->row();
		return (int)$row->min_bbs_num -1;
	}
	/* 답변관련 */
	/* 답변 지정해서 1개만 가져오기 qna */
	public function get_reply_single($table='', $parent_id='', $bbs_id=''){
		if(empty($table)) return false;
		if(is_numeric($parent_id) && empty($bbs_id)){
			// 부모 아래 딸려있는거 전부
			$this->db->where('bbs_parent', $parent_id);
			$this->db->where('bbs_is_reply', 1);
			$query = $this->db->get($this->db->dbprefix('write_'.$table));
			return $query->result();
		}else if((is_numeric($parent_id) && is_numeric($bbs_id)) || (empty($parent_id) && is_numeric($bbs_id))){
			// bbs_id 가 있다는건 단일객체 불러오는거임
			if(is_numeric($parent_id)) $this->db->where('bbs_parent', $parent_id);
			if(is_numeric($bbs_id)) $this->db->where('bbs_id', $bbs_id);
			$this->db->where('bbs_is_reply', 1);
			$query = $this->db->get($this->db->dbprefix('write_'.$table));
			return $query->row();
		}else{
			return false;
		}
	}
	// 좋아요
	public function check_good($bbs_table='', $bbs_id='', $user_id=''){
		$this->db->where('user_id', $user_id);
		$this->db->where('bbs_id', $bbs_id);
		$query = $this->db->get($this->db->dbprefix('write_'.$bbs_table.'_fa'));
		return $query->num_rows();
	}
	public function add_good($post){
		$bbs_table	= $this->security->xss_clean($post['b_table']);
		$bbs_id		= $this->security->xss_clean($post['b_id']);
		$user_id 	= $this->encryption->decrypt($this->session->userdata('user_id'));
		if(empty($user_id) || !$user_id){
			return false;
		}
		$result 	= $this->check_good($bbs_table, $bbs_id, $user_id);
		if($result > 0){
			$error['error_code'] = '0005';
			return $error;
		}else{
			$data = array(
				'bbs_id'	=> addslashes($bbs_id),
				'user_id'	=> addslashes($user_id),
				'fa_register' => date('Y-m-d H:i:s', time())
			);
			$this->db->trans_begin();
			$this->db->insert($this->db->dbprefix('write_'.$bbs_table.'_fa'), $data);
			$update_query = sprintf('update psu_write_%s set bbs_good = bbs_good+1 where bbs_id = %d', $bbs_table, $bbs_id);
			$this->db->cache_delete('board', 'list');
			$this->db->cache_delete('ko', 'board');
			$this->db->cache_delete('vn', 'board');
			$this->db->cache_delete('en', 'board');
			$this->db->query($update_query);
			if ($this->db->trans_status() === FALSE){
				$this->db->trans_rollback();
				return false;
			}else{
				$this->db->trans_commit();
				return true;
			}
		}
	}
	// 스크랩 등록
	public function add_scrap($post){
		$bbs_table	= $this->security->xss_clean($post['b_table']);
		$bbs_id		= $this->security->xss_clean($post['b_id']);
		$user_id 	= $this->encryption->decrypt($this->session->userdata('user_id'));
		if(empty($user_id) || !$user_id){
			return false;
		}
		$result 	= $this->check_scrap($bbs_table, $bbs_id, $user_id);
		if($result > 0){
			$error['error_code'] = '0004';
			return $error;
		}else{
			$data = array(
				'u_id'		 => addslashes($user_id),
				'b_table'	 => addslashes($bbs_table),
				'b_id'		 => $bbs_id,
				's_register' => date('Y-m-d H:i:s', time())
			);
			return $this->db->insert($this->db->dbprefix('board_scrap'), $data);
		}
	}
	// 등록되어있는 스크랩 가져오기
	public function get_scrap($page_limit, $page_list){
		$user_id = $this->encryption->decrypt($this->session->userdata('user_id'));
		if(empty($user_id) || !$user_id){
			return false;
		}
		$this->db->where('u_id', $user_id);
		$this->db->limit($page_list, $page_limit);
		$this->db->order_by('s_register', 'DESC');
		$query = $this->db->get($this->db->dbprefix('board_scrap'));
		return $query->result();
	}
	// 가져온 스크랩 포문돌면서 조인 --- 게시판자체가 삭제되었을때 파일들과 스크랩게시글 대처방안 마련해야함
	public function get_scrap_bbs_join_single($s_id, $bbs_table, $bbs_id){
		$user_id = $this->encryption->decrypt($this->session->userdata('user_id'));
		if(empty($user_id) || !$user_id){
			return false;
		}
		if($this->check_board_name('bbs_table', $bbs_table)){
			$this->db->where('s_id', $s_id);
			$this->db->where('u_id', $user_id);
			$query = $this->db->get($this->db->dbprefix('board_scrap'));
		}else{
			$this->db->select('s.s_id, s.s_register, s.b_table, g.bbs_name_ko, g.bbs_name_en, g.bbs_name_vn, b.bbs_subject, b.bbs_id');
			$this->db->from($this->db->dbprefix('board_scrap as s'));
			$this->db->join($this->db->dbprefix('board_group as g'), 's.b_table = g.bbs_table', 'inner');
			$this->db->join($this->db->dbprefix('write_'.$bbs_table.' as b'), 's.b_id = b.bbs_id', 'left');
			$this->db->where('s.s_id', $s_id);
			$this->db->where('s.u_id', $user_id);
			//$this->db->where('b.bbs_id', $bbs_id);
			$query = $this->db->get();
		}
		if($query){
			return $query->row();
		}else{
			return false;
		}

	}
	// 등록되어있는 스크랩에서 1차 가공한뒤(게시판 테이블명 중복제거해서 얻어내기) 해당 결과물로 게시판 조인
	public function get_scrap_bbs_join($bbs_table){
		$user_id = $this->encryption->decrypt($this->session->userdata('user_id'));
		if(empty($user_id) || !$user_id){
			return false;
		}
		$this->db->select('s.s_register, s.b_table, g.bbs_name_ko, g.bbs_name_en, g.bbs_name_vn, b.bbs_subject, b.bbs_id');
		$this->db->from($this->db->dbprefix('board_scrap as s'));
		$this->db->join($this->db->dbprefix('board_group as g'), 's.b_table = g.bbs_table', 'inner');
		$this->db->join($this->db->dbprefix('write_'.$bbs_table.' as b'), 's.b_id = b.bbs_id', 'inner');
		$this->db->where('s.b_table', $bbs_table);
		$this->db->where('s.u_id', $user_id);
		$query = $this->db->get();
		return $query->result();
	}
	// 스크랩의 총 합 가져오기
	public function get_user_total_scrap(){
		$user_id = $this->encryption->decrypt($this->session->userdata('user_id'));
		if(empty($user_id) || !$user_id){
			return false;
		}
		$this->db->where('u_id', $user_id);
		return $this->db->count_all_results($this->db->dbprefix('board_scrap'));
	}
	// 스크랩한 게시물인지 확인
	public function check_scrap($bbs_table, $bbs_id, $user_id){
		$this->db->where('b_table', $bbs_table);
		$this->db->where('u_id', $user_id);
		$this->db->where('b_id', $bbs_id);
		return $this->db->count_all_results($this->db->dbprefix('board_scrap'));
	}
	// 스크랩삭제
	public function delete_scrap($post){
		for($i=0; $i<count($post['s_chk']); $i++){
			if(!is_numeric($post['s_chk'][$i])) return false;
			$this->db->or_where_in('s_id', $post['s_chk'][$i]);
		}
		return $this->db->delete($this->db->dbprefix('board_scrap'));
	}
	// extra1 테이블에 값 fixed씌우기
	public function put_extra1_column($table='', $bbs_id='', $data=''){
		if(empty($table) || !is_numeric($bbs_id)){
			return false;
		}
		$this->db->where('bbs_id', $bbs_id);
		return $this->db->update($this->db->dbprefix('write_'.$table), array(
			'bbs_extra1'	=> $this->security->xss_clean($data)
		));
	}
	// 조회수 업데이트
	public function set_hit_update($bbs_table='', $bbs_id=''){
		if(empty($bbs_table) || !is_numeric($bbs_id)){
			return false;
		}
		$query = sprintf('update psu_write_%s set bbs_hit = bbs_hit+1 where bbs_id=%d', $bbs_table, $bbs_id);
		$this->db->cache_delete('board', 'list');
		$this->db->cache_delete('ko', 'board');
		$this->db->cache_delete('vn', 'board');
		$this->db->cache_delete('en', 'board');
		return $this->db->query($query);
	}
	// 섬네일생성함수
	private function create_thumb($image_file){
		$config['image_library'] = 'gd2';
		$config['source_image'] = $image_file; //$bbs_files['bbs_images'][$i]['full_path'];
		$config['create_thumb'] = TRUE;
		$config['maintain_ratio'] = TRUE;
		$config['width']         = 392;
		//$config['height']       = 244;
		$this->image_lib->initialize($config);
		$thumb_data = $this->image_lib->resize();
	}
	private function set_files_db($bbs_table, $val, $last_id, $type='files', $bf_id = ''){
		$arr = array(
			'bf_table' 		=>strip_tags($this->db->dbprefix('write_'.$bbs_table)),
			'bf_bbs_id' 	=>(int)$last_id,
			'bf_type' 		=>strip_tags($type),
			'bf_name'		=> strip_tags($val['file_name']),
			'bf_path'		=> strip_tags($val['file_path']),
			'bf_full_path' 	=> strip_tags($val['full_path']),
			'bf_orig_name'	=> strip_tags($val['orig_name']),
			'bf_ext'		=> strip_tags($val['file_ext']),
			'bf_size'		=> strip_tags($val['file_size']),
			'bf_is_img'		=> strip_tags($val['is_image']),
			'bf_img_width'	=> isset($val['image_width']) ? strip_tags($val['image_width']) : '',
			'bf_img_height'	=> isset($val['image_height']) ? strip_tags($val['image_height']) : '',
			'bf_register'	=> date('Y-m-d H:i:s', time())
		);
		if(!empty($bf_id) && is_numeric($bf_id)){
			$id_arr = array($this->db->protect_identifiers('bf_id')=>$bf_id);
			return array_merge($id_arr, $arr);
		}else{
			return $arr;
		}
	}
	private function get_next_num($bbs_table){
		$this->db->select("min(bbs_num) as min_bbs_num");
		$query = $this->db->get($this->db->dbprefix('write_'.$bbs_table));
		$row = $query->row();
		return (int)$row->min_bbs_num -1;
	}
	// 검색 sql
	private function setting_search_query($sch_select, $keyword){
		switch($sch_select){
			case 'subject' :
				$this->db->like('bbs_subject', $keyword);
				break;
			case 'subject_content' :
				$this->db->like('bbs_subject', $keyword);
				$this->db->or_like('bbs_content', $keyword);
				break;
			case 'name' :
				$this->db->where('user_name', $keyword);
				break;
			default :
		}
	}
	// 파일삭제
	private function board_write_delete_files($filepath, $array=false, $addpath=''){
		if($array){
			for($i=0; $i<count($filepath); $i++){
				@unlink(delete_last_slashtag(FCPATH).$addpath.$filepath[$i]);
			}
		}else{
			@unlink(delete_last_slashtag(FCPATH).$addpath.$filepath);
		}
	}
	// 테이블에 강제로 fixed씌우기
	private function set_html_fixed_table($str){
		return $str;
		//$str = preg_replace('/\<\s*table/', '<div class="bbs-fixed-table"><table', $str);
		//$str = preg_replace('/\<\/\s*table\>/', '</table></div>', $str);
		//return $str;
	}
}
?>
