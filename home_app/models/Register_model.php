<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Register_model extends CI_model{
	public function __construct(){
		parent::__construct();
		$this->load->database();
	}
	// 개인정보취급방침등록
	public function set_home_agreement($post){
		$sql = $this->db->where("opt_name","agreement_".$post['agree_lang'])->get($this->db->dbprefix('options'));
		if($sql->num_rows() > 0){
			$data = array('opt_value'=>addslashes($post['agreement']));
			$this->db->where('opt_name', 'agreement_'.$post['agree_lang']);
			return $this->db->update($this->db->dbprefix('options'), $data);
		}else{
			$data = array('opt_name'=>'agreement_'.$post['agree_lang'],'opt_value'=>addslashes($post['agreement']));
			return $this->db->insert($this->db->dbprefix('options'), $data);
		}
	}
	// 개인정보취급방침가져오기
	public function get_home_agreement($lang='ko'){
		$this->db->where('opt_name', 'agreement_'.$lang);
		$query = $this->db->get($this->db->dbprefix('options'));
		return $query->row();
	}
	// 팝업창 등록

	public function home_popup_update($post){
		$popup_mode = strip_tags(trim(addslashes($post['popup_mode'])));
		$value 		= array();
		$len 		= count($post['popevent_index']);
		$ii 		= 0;
		function set_popup_img(&$value, $img_data=array(), $i=0, $ii=0, $post=array(), $state='ko'){
			if($img_data){
				if(isset($post['pop_full_path_'.$state.'_'.$i])){
					@unlink($post['pop_full_path_'.$state.'_'.$i]);
				}
				$pattern 					 = preg_replace('/\//','\/',FCPATH);
				$pop_file_path 				 = preg_replace('/^'.$pattern.'/i','',$img_data['bbs_images'][0]['full_path']);
				$value[$ii]['pop_orig_name_'.$state] = trim(addslashes($img_data['bbs_images'][0]['orig_name']));
				$value[$ii]['pop_file_name_'.$state] = trim(addslashes($img_data['bbs_images'][0]['file_name']));
				$value[$ii]['pop_file_path_'.$state] = '/'.trim(addslashes($pop_file_path));
				$value[$ii]['pop_full_path_'.$state] = trim(addslashes($img_data['bbs_images'][0]['full_path']));
			}
		}
		for($i=0; $i<$len; $i++){
			if(isset($post['popevent_del_'.$i])){
				if($post['popevent_del_'.$i] == 'del'){
					@unlink($post['pop_full_path_ko_'.$i]);
					@unlink($post['pop_full_path_en_'.$i]);
					@unlink($post['pop_full_path_vn_'.$i]);
					continue;
				}
			}
			$value[$ii] = array(
				'pop_subject_ko' 	=> trim(addslashes($post['pop_subject_ko_'.$i])),
				'pop_subject_en' 	=> trim(addslashes($post['pop_subject_en_'.$i])),
				'pop_subject_vn' 	=> trim(addslashes($post['pop_subject_vn_'.$i])),
				'pop_class' 		=> trim(addslashes($post['pop_class_'.$i])),
				'pop_text_ko'		=> trim(addslashes($post['pop_text_ko_'.$i])),
				'pop_text_en'		=> trim(addslashes($post['pop_text_en_'.$i])),
				'pop_text_vn'		=> trim(addslashes($post['pop_text_vn_'.$i])),
				'pop_useday'		=> trim(addslashes($post['pop_useday_'.$i])),
				'pop_viewtype'		=> (isset($post['pop_viewtype_'.$i]))?trim(addslashes($post['pop_viewtype_'.$i])):'',
				'pop_alt_ko'		=> trim(addslashes($post['pop_alt_ko_'.$i])),
				'pop_alt_en'		=> trim(addslashes($post['pop_alt_en_'.$i])),
				'pop_alt_vn'		=> trim(addslashes($post['pop_alt_vn_'.$i])),
				'pop_link'			=> trim(addslashes($post['pop_link_'.$i])),
				'pop_target'		=> trim(addslashes($post['pop_target_'.$i])),
				'pop_orig_name_ko'	=> (isset($post['pop_orig_name_ko_'.$i]))?trim(addslashes($post['pop_orig_name_ko_'.$i])):'',
				'pop_file_name_ko'	=> (isset($post['pop_file_name_ko_'.$i]))?trim(addslashes($post['pop_file_name_ko_'.$i])):'',
				'pop_file_path_ko' 	=> (isset($post['pop_file_path_ko_'.$i]))?trim(addslashes($post['pop_file_path_ko_'.$i])):'',
				'pop_full_path_ko'	=> (isset($post['pop_full_path_ko_'.$i]))?trim(addslashes($post['pop_full_path_ko_'.$i])):'',
				'pop_orig_name_en'	=> (isset($post['pop_orig_name_en_'.$i]))?trim(addslashes($post['pop_orig_name_en_'.$i])):'',
				'pop_file_name_en'	=> (isset($post['pop_file_name_en_'.$i]))?trim(addslashes($post['pop_file_name_en_'.$i])):'',
				'pop_file_path_en' 	=> (isset($post['pop_file_path_en_'.$i]))?trim(addslashes($post['pop_file_path_en_'.$i])):'',
				'pop_full_path_en'	=> (isset($post['pop_full_path_en_'.$i]))?trim(addslashes($post['pop_full_path_en_'.$i])):'',
				'pop_orig_name_vn'	=> (isset($post['pop_orig_name_vn_'.$i]))?trim(addslashes($post['pop_orig_name_vn_'.$i])):'',
				'pop_file_name_vn'	=> (isset($post['pop_file_name_vn_'.$i]))?trim(addslashes($post['pop_file_name_vn_'.$i])):'',
				'pop_file_path_vn' 	=> (isset($post['pop_file_path_vn_'.$i]))?trim(addslashes($post['pop_file_path_vn_'.$i])):'',
				'pop_full_path_vn'	=> (isset($post['pop_full_path_vn_'.$i]))?trim(addslashes($post['pop_full_path_vn_'.$i])):'',
				'pop_register'	=> date('Y-m-d H:i:s', time())
			);
			if($_FILES['pop_img_ko_'.$i]['name'][0]){
				set_popup_img($value, $img_data = $this->set_home_popup_file(array(
					'pop_img_ko_'.$i=>$_FILES['pop_img_ko_'.$i]
				), 'pop_img_ko_'.$i), $i, $ii, $post, 'ko');
			}
			if($_FILES['pop_img_en_'.$i]['name'][0]){
				set_popup_img($value, $img_data = $this->set_home_popup_file(array(
					'pop_img_en_'.$i=>$_FILES['pop_img_en_'.$i]
				), 'pop_img_en_'.$i), $i, $ii, $post, 'en');
			}
			if($_FILES['pop_img_vn_'.$i]['name'][0]){
				set_popup_img($value, $img_data = $this->set_home_popup_file(array(
					'pop_img_vn_'.$i=>$_FILES['pop_img_vn_'.$i]
				), 'pop_img_vn_'.$i), $i, $ii, $post, 'vn');
			}
			$ii++;
		}
		$data = array('opt_name'=>'popup_event','opt_value'=>serialize($value));
		if($this->check_homeoption_name('popup_event')){
			$this->db->where('opt_name', 'popup_event');
			return $this->db->update($this->db->dbprefix('options'), $data);
		}else{
			return $this->db->insert($this->db->dbprefix('options'), $data);
		}
	}
	// 팝업창 이미지 등록
	private function set_home_popup_file($files, $file_tagname){
		$this->load->library('fileupload');
		$value = array();
		$config = array(
			'upload_path' 	=> './assets/file/popup',
			'allowed_types' => 'gif|jpg|png',
			'max_size' 		=> 2045,
			'encrypt_name' 	=> TRUE
		);
		$upload_file = $this->fileupload->img_upload($files, $config, $file_tagname);
		if($upload_file['is_error'] === 'none'){
			return $upload_file;
		}else{
			return false;
		}
	}
	// 옵션테이블에에 해당이름이(유니크) 있는지 확인
	public function check_homeoption_name($unique_optname=''){
		if(empty($unique_optname)){
			return false;
		}
		$this->db->where('opt_name', $unique_optname);
		$query = $this->db->get($this->db->dbprefix('options'));
		if($query->num_rows()> 0){
			return true;
		}else{
			return false;
		}
	}
	// 팝업창 가져오기
	public function get_home_popup($popup){
		$this->db->select("opt_value");
		$this->db->where('opt_name', $popup);
		$query = $this->db->get($this->db->dbprefix('options'));
		$result = $query->row();
		if($result){
			return unserialize($result->opt_value);
		}else{
			return false;
		}
	}
	// 수강신청 등록
	public function add_psuregister($post){
		$special_lecture = '';
		if(isset($post['special_lecture']) && count($post['special_lecture'])>0){
			$special_lecture = implode(", ", $post['special_lecture']);
		}
		//$register_charset = check_user_charset($post['register_grade']).','.check_user_charset($post['register_parent']).','.check_user_charset($post['parents_type']);
		$data = array(
			'register_name' 		=> trim(fnc_set_htmls_strip($post['register_name'])),
			'register_school' 		=> trim(fnc_set_htmls_strip(fnc_changeString_to_utf8($post['register_school']))),
			'register_grade' 		=> trim(fnc_set_htmls_strip(fnc_changeString_to_utf8($post['register_grade']))),
			'register_parent' 		=> trim(fnc_set_htmls_strip($post['register_parent'])),
			'parents_type' 			=> trim(fnc_set_htmls_strip($post['parents_type'])),
			'register_phone_parent' => ($post['register_phone_parent'] == '010-0000-0000')?'':trim(fnc_set_htmls_strip($post['register_phone_parent'])),
			//'register_phone' 		=> ($post['register_phone'] == '010-0000-0000')?'':trim(fnc_set_htmls_strip($post['register_phone'])),
			'register_email_parent' => ($post['register_email_parent'] == 'email@domain.com')?'':trim(fnc_set_htmls_strip($post['register_email_parent'])),
			//'register_email' 		=> ($post['register_email'] == 'email@domain.com')?'':$post['register_email'],
			'class_select' 			=> trim(fnc_set_htmls_strip($post['class_select'])),
			'special_lecture' 		=> $special_lecture,
			'register_local' 		=> trim(fnc_set_htmls_strip($post['register_local'])),
			'register_sat' 			=> ($post['register_sat'] == 'Score')?'':trim(fnc_set_htmls_strip($post['register_sat'])),
			'register_toefl' 		=> ($post['register_toefl'] == 'Score')?'':trim(fnc_set_htmls_strip($post['register_toefl'])),
			'register_act' 			=> ($post['register_act'] == 'Score')?'':trim(fnc_set_htmls_strip($post['register_act'])),
			'register_ap' 			=> ($post['register_ap'] == 'Score')?'':trim(fnc_set_htmls_strip($post['register_ap'])),
			'register_content' 		=> trim(stripslashes($post['register_content'])),
			'register_ip'			=> $this->input->ip_address(),
			'register_agent'		=> $_SERVER['HTTP_USER_AGENT'],
			//'register_charset'		=> $register_charset,
			'register_time' 		=> date('Y-m-d H:i:s', time())
		);
		if($this->db->insert($this->db->dbprefix('register'), $data)){
			return $data;
		}else{
			return false;
		}
	}
	// 1:1 문의등록
	public function add_psuquestion($post){
		$data = array(
			'question_type' 		=> fnc_set_htmls_strip(implode(', ', $post['question_type'])),
			'question_name' 		=> trim(fnc_set_htmls_strip($post['question_name'])),
			'question_parent' 		=> trim(fnc_set_htmls_strip($post['question_parent'])),
			'question_phone' 		=> trim(fnc_set_htmls_strip($post['question_phone'])),
			'question_phone_user' 	=> trim(fnc_set_htmls_strip($post['question_phone_user'])),
			'question_email' 		=> trim(fnc_set_htmls_strip($post['question_email'])),
			'question_email_user' 	=> trim(fnc_set_htmls_strip($post['question_email_user'])),
			'question_content' 		=> trim(stripslashes($post['question_content'])),
			'question_ip'			=> $this->input->ip_address(),
			'question_register' 	=> date('Y-m-d H:i:s', time())
		);
		if($this->db->insert($this->db->dbprefix('question'), $data)){
			return $data;
		}else{
			return false;
		}
	}
	// 수강신청, 1:1문의 등 전체목록수 가져오기
	public function home_register_totalnum($table=''){
		if(empty($table)) return false;
		if($table === 'alldayuser'){
			$this->db->where('ad_use', 'yes');
		}
		return $this->db->count_all($this->db->dbprefix($this->security->xss_clean($table)));
	}
	// 수강신청, 1:1문의 등 목록 가져오기
	public function get_home_register_list($table='', $page_limit='', $page_list='', $register_time=''){
		if(empty($table)) return false;
		if($table === 'alldayuser'){
			$this->db->where('ad_use', 'yes');
			$this->db->order_by('ad_gender','ASC');
			$this->db->order_by('ad_name','ASC');
		}
		if(!empty($register_time)){
			$this->db->order_by($register_time,'DESC');
		}
		$query = $this->db->get($this->db->dbprefix($this->security->xss_clean($table)), $page_list, $page_limit);
		return $query->result();
	}
	// 수강신청, 1:1문의 등 한병분 데이터 가져오기
	public function get_home_register(){

	}
	// 올데이 인원수 설정
	public function set_alldayuser_maximum($post){
		$allday_data= array(
			'max_girl' 	=> mysqli_real_escape_string($this->db->conn_id, $post['max_girl']),
			'max_boy'	=>  mysqli_real_escape_string($this->db->conn_id, $post['max_boy'])
		);
		$data = array('opt_name'=>'allday_maximum','opt_value'=>serialize($allday_data));
		if($this->check_homeoption_name('allday_maximum')){
			$this->db->where('opt_name', 'allday_maximum');
			return $this->db->update($this->db->dbprefix('options'), $data);
		}else{
			return $this->db->insert($this->db->dbprefix('options'), $data);
		}
	}
	// 올데이 인원 삭제
	public function update_alldayuser($post){
		if($post['allday_type'] === 'delete'){

			for($i=0, $len= count($post['del_ad_id']); $i<$len; $i++){
				if(!is_numeric($post['del_ad_id'][$i])){
					return false;
				}
				$this->db->or_where_in('ad_id', $post['del_ad_id'][$i]);
			}
			return $this->db->delete($this->db->dbprefix('alldayuser'));
		}
	}
	// 올데이 인원수 반환
	public function get_alldayuser_maximum(){
		$this->db->select('opt_value');
		$this->db->where('opt_name', 'allday_maximum');
		$query = $this->db->get($this->db->dbprefix('options'));
		return $query->row();
	}
	// 올데이수강자 등록
	public function add_alldayuser($post){
		$data = array();
		$ad_length = count($post['allday_name']);

		for($i=0; $i<$ad_length; $i++){
			$data[$i] = array(
				'ad_gender'		=> trim(fnc_set_htmls_strip($post['ad_gender'][$i])),
				'ad_name' 		=> trim(fnc_set_htmls_strip($post['allday_name'][$i])),
				'ad_phone' 		=> trim(fnc_set_htmls_strip($post['allday_phone'][$i])),
				'ad_register' 	=> date('Y-m-d H:i:s', time())
			);
		}
		if($this->db->insert_batch($this->db->dbprefix('alldayuser'), $data)){
			return $data;
		}else{
			return false;
		}
	}
	// 올데이등록자반환
	public function get_alldayuser($gender='girl'){
		if($gender !== 'all'){
			$this->db->where('ad_gender', $gender);
		}
		$query = $this->db->get($this->db->dbprefix('alldayuser'));
		$result = $query->result();
		if($result){
			return $result;
		}else{
			return false;
		}
	}
	/* psu 설명회 */
	// 엑셀파일 다운로드
	public function get_presentation_excelfile($post){
		$p_begin = $post['p_begin'];
		$p_end = $post['p_end'];
		$this->db->select('*');
		$this->db->from($this->db->dbprefix('presentation as p'));
		$this->db->join($this->db->dbprefix('presentation_user as u'), 'p.p_id = u.p_id', 'inner');
		if(!empty($p_end) && empty($p_begin)){
			$this->db->where('p.p_day <=', $p_end.' 23:59:59');
		}else if(empty($p_end) && !empty($p_begin)){
			$this->db->where('p.p_day >=', $p_begin);
		}else if(!empty($p_end) && !empty($p_begin)){
			$this->db->where('p.p_day BETWEEN "'.$p_begin.'" and "'.$p_end.' 23:59:59"');
		}
		$this->db->order_by('p.p_day','ASC');
		$this->db->order_by('u.u_register', 'ASC');
		$query = $this->db->get();
		return $query->result();
	}
	public function get_individual_excelfile($post){
		$p_begin 	= $post['p_begin'];
		$p_end 		= $post['p_end'];
		$this->db->where('p_id', 0);
		if(!empty($p_end) && empty($p_begin)){
			$this->db->where('u_register <=', $p_end.' 23:59:59');
		}else if(empty($p_end) && !empty($p_begin)){
			$this->db->where('u_register >=', $p_begin);
		}else if(!empty($p_end) && !empty($p_begin)){
			$this->db->where('u_register BETWEEN "'.$p_begin.'" and "'.$p_end.' 23:59:59"');
		}
		$this->db->order_by('u_register', 'ASC');
		$query = $this->db->get($this->db->dbprefix('presentation_user'));
		return $query->result();
	}
	// 설명회 예약자가 해당 설명회에 있는지 중복체크
	public function check_presentation_dayuser($u_id=null, $p_day='', $u_mail='', $u_phone=''){
		if(empty($p_day) || empty($u_mail) || empty($u_phone)){
			return false;
		}
		// 메일과 전번 둘중하나라도 있다면 중복이다
		if(is_numeric($u_id)){
			$this->db->select('u.u_id');
		}
		$this->db->from($this->db->dbprefix('presentation as p'));
		$this->db->join($this->db->dbprefix('presentation_user as u'), 'p.p_id = u.p_id', 'inner');
		$where = "u.u_id != '".$u_id."' and u.p_id = '".$p_day."' and (u.u_email = '".$u_mail."' or u.u_phone='".$u_phone."')";
		$this->db->where($where);
		$query = $this->db->get();
		return $query->result();
	}
	// 관리자 - 설명회 예약자 등록 수정
	public function presentation_user_register($post){
		$data = array();
		if($post['mode'] == 'insert'){
			$u_field = '';
			if(isset($post['u_field'])){
				for($i=0; $i<count($post['u_field']); $i++){
					$ext = ($i==0) ? '' : ' | ';
					$u_field .= $ext.strip_tags(addslashes($post['u_field'][$i]));
				}
			}
			$u_email 		= '';
			if(isset($post['u_email1'])){
				$u_email1		= strip_tags($post['u_email1']);
				$u_email2		= strip_tags($post['u_email2']);
				$u_email3		= strip_tags($post['u_email3']);
				if($u_email2 == 'write'){
					$u_email	= $u_email1.'@'.$u_email3;
				}else{
					$u_email	= $u_email1.'@'.$u_email2;
				}
			}else{
				$u_email		= (isset($post['u_email']))?strip_tags($post['u_email']):'';
			}
			$p_id = (isset($post['p_id']))? addslashes($post['p_id']):0;
			$data = array(
				'p_id'			=> $p_id,
				'u_name'		=> strip_tags(addslashes($post['u_name'])),
				'u_name_en'		=> (isset($post['u_name_en']))?strip_tags(addslashes($post['u_name_en'])):'',
				'u_phone'		=> strip_tags(addslashes($post['u_phone'])),
			    'u_state'		=> (isset($post['u_state']))?strip_tags(addslashes($post['u_state'])):'',
				'u_email'		=> $u_email,
				'u_aca'			=> (isset($post['u_aca']))?strip_tags(addslashes($post['u_aca'])):'',
				'u_relation'	=> (isset($post['u_relation']))?strip_tags(addslashes($post['u_relation'])):'',
				'u_field'		=> $u_field,
				'u_attendance'	=> (isset($post['u_attendance']))?strip_tags(addslashes($post['u_attendance'])):'',
				'u_search'		=> (isset($post['u_search']))?strip_tags(addslashes($post['u_search'])):'',
				'u_register'	=> date("Y-m-d H:i:s", time()),
				'u_attend'		=> (isset($post['u_attend']))?strip_tags(addslashes($post['u_attend'])):'no',
				'u_description'	=> (isset($post['u_description']))?addslashes($post['u_description']):''
			);
			$result = $this->db->insert($this->db->dbprefix('presentation_user'), $data);
			if($result){
				if($this->session->userdata('user_id') && ($this->session->userdata('user_level')<7 && $this->session->userdata('user_level') >=2)){
					$this->set_member_relationData($this->db->dbprefix('mem_presentation'), array(
						'u_id' => $this->db->insert_id(),
						'user_id' => $this->encryption->decrypt($this->session->userdata('user_id'))
					));
				}
				return true;
			}else{
				return false;
			}
		}else if($post['mode'] == 'modify'){
			for($i=0; $i<count($post['u_chk']); $i++){
				$u_id 	  = $post['u_chk'][$i];
				$data[$i] = array(
					$this->db->protect_identifiers('u_id')	=> $u_id,
					'p_id'									=> (isset($post['p_id_'.$u_id]))?addslashes($post['p_id_'.$u_id]):0,
					'u_name'								=> strip_tags(addslashes($post['u_name_'.$u_id])),
					'u_name_en'								=> (isset($post['u_name_en_'.$u_id]))?strip_tags(addslashes($post['u_name_en_'.$u_id])):'',
					'u_phone'								=> strip_tags(addslashes($post['u_phone_'.$u_id])),
					'u_state'								=> (isset($post['u_state_'.$u_id]))?strip_tags(addslashes($post['u_state_'.$u_id])):'',
					'u_email'								=> (isset($post['u_email_'.$u_id]))?strip_tags(addslashes($post['u_email_'.$u_id])):'',
					'u_attendance'							=> strip_tags(addslashes($post['u_attendance_'.$u_id])),
					'u_attend'								=> strip_tags(addslashes($post['u_attend_'.$u_id]))
				);
			}
			$this->db->update_batch($this->db->dbprefix('presentation_user'), $data, $this->db->protect_identifiers('u_id'));
			return true;
		}else if($post['mode'] == 'modify_single'){
			$u_field = '';
			if(isset($post['u_field'])){
				for($i=0; $i<count($post['u_field']); $i++){
					$ext = ($i==0) ? '' : ' | ';
					$u_field .= $ext.strip_tags(addslashes($post['u_field'][$i]));
				}
			}
			$data = array(
				'p_id'			=> (isset($post['p_id']))?addslashes($post['p_id']):0,
				'u_name'		=> strip_tags(addslashes($post['u_name'])),
				'u_name_en'		=> (isset($post['u_name_en']))?strip_tags(addslashes($post['u_name_en'])):'',
				'u_phone'		=> strip_tags(addslashes($post['u_phone'])),
				'u_state'		=> (isset($post['u_state']))?strip_tags(addslashes($post['u_state'])):'',
				'u_email'		=> (isset($post['u_email']))?strip_tags(addslashes($post['u_email'])):'',
				'u_attend'		=> strip_tags(addslashes($post['u_attend'])),
				'u_description'	=> addslashes($post['u_description'])
			);
			$this->db->where('u_id', $post['u_id']);
			return $this->db->update($this->db->dbprefix('presentation_user'), $data);
		}else if($post['mode'] == 'delete'){
			for($i=0; $i<count($post['u_chk']); $i++){
				$this->db->or_where_in('u_id', $post['u_chk'][$i]);
			}
			return $this->db->delete($this->db->dbprefix('presentation_user'));
		}else{
			return false;
		}
	}
	// 관리자 - 설명회 일정 등록 수정
	public function presentation_register($post){
		$data = array();
		if($post['mode'] == 'insert'){
			for($i=0; $i< count($post['p_name']); $i++){
				$data[$i] = array(
				    'p_type'        => (isset($post['p_type'][$i]))?addslashes($post['p_type'][$i]):'presentation',
					'p_name' 		=> addslashes($post['p_name'][$i]),
					'p_day'			=> date("Y-m-d H:i:s", strtotime($post['p_day'][$i].$post['p_time'][$i])),
					'p_location'	=> addslashes($post['p_location'][$i]),
					'p_address'		=> addslashes($post['p_address'][$i]),
					'p_place'		=> addslashes($post['p_place'][$i]),
					'p_entry'		=> addslashes($post['p_entry'][$i]),
					'p_posx'		=> addslashes($post['p_posx'][$i]),
					'p_posy'		=> addslashes($post['p_posy'][$i]),
					'p_use'			=> addslashes($post['p_use'][$i]),
					'p_register'	=> date("Y-m-d H:i:s", time())
				);
			}
			return $this->db->insert_batch($this->db->dbprefix('presentation'), $data);
		}else if($post['mode'] == 'modify'){
			for($i=0; $i<count($post['p_chk']); $i++){
				$p_id 	  = $post['p_chk'][$i];
				$data[$i] = array(
					$this->db->protect_identifiers('p_id')	=> $p_id,
				    'p_type'                                => (isset($post['p_type_'.$p_id]))?addslashes($post['p_type_'.$p_id]):'presentation',
					'p_name' 								=> addslashes($post['p_name_'.$p_id]),
					'p_day'									=> date("Y-m-d H:i:s", strtotime($post['p_day_'.$p_id])),
					'p_location'							=> addslashes($post['p_location_'.$p_id]),
					'p_address'								=> addslashes($post['p_address_'.$p_id]),
					'p_place'								=> addslashes($post['p_place_'.$p_id]),
					'p_entry'								=> addslashes($post['p_entry_'.$p_id]),
					'p_posx'								=> addslashes($post['p_posx_'.$p_id]),
					'p_posy'								=> addslashes($post['p_posy_'.$p_id]),
					'p_use'									=> addslashes($post['p_use_'.$p_id])
				);
			}
			$this->db->update_batch($this->db->dbprefix('presentation'), $data, $this->db->protect_identifiers('p_id'));
			return true;

		}else if($post['mode'] == 'delete'){
			for($i=0; $i<count($post['p_chk']); $i++){
				$this->db->or_where_in('p_id', $post['p_chk'][$i]);
			}
			return $this->db->delete($this->db->dbprefix('presentation'));
		}else{
			return false;
		}
	}
	// 설명회 일정 전체 갯수 반환
	public function get_presentation_day_total($begin='', $end=''){
		if(!empty($end) && empty($begin)){
			$this->db->where('p_day <=', $end.' 23:59:59');
		}else if(empty($end) && !empty($begin)){
			$this->db->where('p_day >=', $begin);
		}else if(!empty($begin) && !empty($end)){
			$this->db->where('p_day BETWEEN "'.$begin.'" and "'.$end.' 23:59:59"');
		}

		return $this->db->count_all_results($this->db->dbprefix('presentation'));
	}
	// 설명회 일정 아이디로 1개 가녀오기
	public function get_presentation_single($p_id, $select='all'){
		if($select !== 'all'){
			$this->db->select($select);
		}
		$this->db->where('p_id', $p_id);
		$query = $this->db->get($this->db->dbprefix('presentation'));
		return $query->row();
	}
	// 설명회 일정 가저오기
	public function get_presentation_day($page_limit, $page_list, $begin, $end, $user_total=false, $select='', $use='all', $day_sort = 'DESC', $nowTime='', $year_select='', $p_type='all'){
		if(!empty($select)){
			$this->db->select($select);
		}
		if(empty($nowTime)){
			if(!empty($end) && empty($begin)){
				$this->db->where('p_day <=', $end.' 23:59:59');
			}else if(empty($end) && !empty($begin)){
				$this->db->where('p_day >=', $begin);
			}else if(!empty($begin) && !empty($end)){
				$this->db->where('p_day BETWEEN "'.$begin.'" and "'.$end.' 23:59:59"');
			}
		}else if($nowTime == 'over'){
			$this->db->where('p_day >', date(('Y-m-d H:i:s'), time()));
		}else if($nowTime == 'under'){
			$this->db->where('p_day <=', date(('Y-m-d H:i:s'), time()));
		}
		if($use !== 'all'){
			$this->db->where('p_use', $use);
		}
		if(!empty($year_select) && is_numeric($year_select)){
			$this->db->where('YEAR(p_day)', $year_select);
		}
		if($p_type === 'presentation'){
		    $this->db->where('p_type', 'presentation');
		}else if($p_type === 'conference'){
		    $this->db->where('p_type', 'conference');
		}
		switch($p_type){
		    case 'presentation' :
		        $this->db->where('p_type', 'presentation');
		    break;
		    case 'conference' :
		        $this->db->where('p_type', 'conference');
		    break;
		}
		$this->db->order_by('p_day', $day_sort);
		if(empty($page_limit) && empty($page_list)){
			$query = $this->db->get($this->db->dbprefix('presentation'));
		}else{
			$query = $this->db->get($this->db->dbprefix('presentation'), $page_list, $page_limit);
		}
		$result = $query->result();
		// 일정마다 몇명의 등록자가 있는지 반환
		if($user_total){
			for($i=0; $i<count($result); $i++){
				$result[$i]->p_user_total = $this->get_presentation_user_total($result[$i]->p_id);
			}
		}
		if($result){
			return $result;
		}else{
			return false;
		}
	}
	// 설명회 예약자 총몇명인지 가져오기
	public function get_presentation_user_total($p_id='all', $stype='', $svalue=''){
		$this->db->select('u.u_id');
		if(!empty($stype)){
			if(!empty($svalue)){
				$this->db->like($stype, $svalue);
			}
		}
		if($p_id !== 'all' && is_numeric($p_id)){
			$this->db->where('u.p_id', $p_id);
		}else{
			$this->db->where('u.p_id !=', 0);
		}
		$this->db->from($this->db->dbprefix('presentation as p'));
		$this->db->join($this->db->dbprefix('presentation_user as u'), 'p.p_id = u.p_id', 'inner');
		$query = $this->db->get();
		return $query->num_rows();
	}
	// 설명회 예약자 가져오기
	public function get_presentation_user($page_limit, $page_list, $p_id='all', $u_id = null, $stype='', $svalue=''){
		$this->db->select('*');
		$this->db->from($this->db->dbprefix('presentation as p'));
		$this->db->join($this->db->dbprefix('presentation_user as u'), 'p.p_id = u.p_id', 'inner');
		if($p_id !== 'all' && is_numeric($p_id)){
			$this->db->where('p.p_id', $p_id);
		}
		if(is_numeric($p_id) && is_numeric($u_id)){
			$this->db->where('u.u_id', $u_id);
		}
		if(!empty($stype)){
			if(!empty($svalue)){
				$this->db->like($stype, $svalue);
			}
		}
		$this->db->limit($page_list, $page_limit);
		$this->db->order_by('p_day', 'DESC');
		$this->db->order_by('u_register', 'DESC');
		$query = $this->db->get();
		return $query->result();
	}
	// 개별상담 예약자 총 몇명인지 가져오기
	public function get_individual_user_total(){
		if(!empty($stype)){
			if(!empty($svalue)){
				$this->db->like($stype, $svalue);
			}
		}
		$this->db->where('p_id', 0);
		return $this->db->count_all_results($this->db->dbprefix('presentation_user'));
	}
	// 개별상담 예약자 가져오기
	public function get_individual_user($page_limit, $page_list, $u_id = null, $stype='', $svalue=''){
		if(!empty($stype)){
			if(!empty($svalue)){
				$this->db->like($stype, $svalue);
			}
		}
		if(is_numeric($u_id)){
			$this->db->where('u_id', $u_id);
		}
		$this->db->where('p_id',0);
		$this->db->limit($page_list, $page_limit);
		$this->db->order_by('u_register', 'DESC');
		$query = $this->db->get($this->db->dbprefix('presentation_user'));
		return $query->result();
	}
	// 현재 날짜 또는 지정된 날짜의 설명회 예약자 가져오기
	public function get_presentation_today_user($today=''){
		$today = (empty($today))?date('Y-m-d' ,time()):$today;
		$this->db->select('*');
		$this->db->from($this->db->dbprefix('presentation as p'));
		$this->db->join($this->db->dbprefix('presentation_user as u'), 'p.p_id = u.p_id', 'inner');
		$this->db->where('u_register BETWEEN "'.$today.'" and "'.$today.' 23:59:59"');
		$this->db->order_by('p_day', 'DESC');
		$this->db->order_by('u_register', 'DESC');
		$query = $this->db->get();
		return $query->result();
	}
	// 설명회 예약자 - 설명회일정과 조인없이 해당 일정 예약자만 가져오기
	public function get_presentaation_onlyuser($p_id){
		$this->db->where('p_id', $p_id);
		$this->db->order_by('u_register', 'ASC');
		$query = $this->db->get($this->db->dbprefix('presentation_user'));
		return $query->result();
	}
	/* 설명회 끝 */
	/* ap ib 등록현황 */
	public function get_apib(){
		$this->db->where('opt_name', 'subject_apib');
		$query = $this->db->get($this->db->dbprefix('options'));
		return $query->row();
	}
	public function set_apib($post){
		$subject = array();
		$subject_len = count($post['title']);
		for($i=0; $i<$subject_len; $i++){
			if(isset($post['chk']) && in_array($i, $post['chk'])){
				continue;
			}
			$subject[] = array(
				'index' 		=> addslashes(trim($post['index'][$i])),
				'title' 		=> addslashes(trim($post['title'][$i])),
				'sub_title'		=> addslashes(trim($post['sub_title'][$i])),
				'register1'		=> ($post['register1'][$i])?addslashes(trim($post['register1'][$i])):'0',
				'register1_max'	=> ($post['register1_max'][$i])?addslashes(trim($post['register1_max'][$i])):'0',
				'register2'		=> ($post['register2'][$i])?addslashes(trim($post['register2'][$i])):'0',
				'register2_max'	=> ($post['register2_max'][$i])?addslashes(trim($post['register2_max'][$i])):'0'
			);
		}
		$data = array('opt_name'=>'subject_apib','opt_value'=>serialize($subject));
		if($this->check_homeoption_name('subject_apib')){
			$this->db->where('opt_name', 'subject_apib');
			return $this->db->update($this->db->dbprefix('options'), $data);
		}else{
			return $this->db->insert($this->db->dbprefix('options'), $data);
		}
	}
	/* 특강 조기등록자 */
	public function get_early_season(){
		$this->db->where('opt_name', 'early_season');
		$query = $this->db->get($this->db->dbprefix('options'));
		return $query->row();
	}
	public function set_early_season($post){
		$season_data = array();
		$season_len	 = count($post['season_index']);
		for($i=0; $i<$season_len; $i++){
			$season_data[$i] = array(
				'season'	 => addslashes(trim($post['season_'.$i])),
				'max_user'	 => addslashes(trim($post['max_user_'.$i])),
				'sale'	 	 => addslashes(trim($post['sale_'.$i])),
				'promotion'	 => addslashes(trim($post['promotion_'.$i])),
				'season_use' => addslashes(trim($post['season_use_'.$i])),
				'file_path' => (isset($post['file_path_'.$i]))?trim(addslashes($post['file_path_'.$i])):'',
				'full_path'	=> (isset($post['full_path_'.$i]))?trim(addslashes($post['full_path_'.$i])):'',
			);
			if($_FILES['pop_img_'.$i]['name'][0]){
				$img_data = $this->set_home_popup_file(array(
					'pop_img_'.$i=>$_FILES['pop_img_'.$i]
				), 'pop_img_'.$i);
				if($img_data){
					if(isset($post['full_path_'.$i])){
						@unlink($post['full_path_'.$i]);
					}
					$pattern 					 = preg_replace('/\//','\/',FCPATH);
					$file_path 				 = preg_replace('/^'.$pattern.'/i','',$img_data['bbs_images'][0]['full_path']);
					$season_data[$i]['file_path'] = '/'.trim(addslashes($file_path));
					$season_data[$i]['full_path'] = trim(addslashes($img_data['bbs_images'][0]['full_path']));
				}
			}
		}
		$data = array('opt_name'=>'early_season','opt_value'=>serialize($season_data));
		if($this->check_homeoption_name('early_season')){
			$this->db->where('opt_name', 'early_season');
			return $this->db->update($this->db->dbprefix('options'), $data);
		}else{
			return $this->db->insert($this->db->dbprefix('options'), $data);
		}
	}
	public function get_early_user($season=1){
		/* 조건은 나중에 걸자 */
		$this->db->where('r_season', $season);
		$query = $this->db->get($this->db->dbprefix('early_register_user'));
		return $query->result();
	}
	public function get_early_user_num($season=1){
		$this->db->where('r_season', $season);
		$query = $this->db->get($this->db->dbprefix('early_register_user'));
		return $query->num_rows();
	}
	public function set_early_user($post){
		$data = array();
		if($post['mode'] === 'insert'){
			$len  = count($post['r_name']);
			for($i=0; $i<$len; $i++){
				$data[$i] = array(
					'r_type'		=> mysqli_real_escape_string($this->db->conn_id, trim($post['r_type'])),
					'r_year'		=> mysqli_real_escape_string($this->db->conn_id, trim($post['r_year'])),
					'r_season'		=> mysqli_real_escape_string($this->db->conn_id, trim($post['r_season'])),
					'r_name'		=> mysqli_real_escape_string($this->db->conn_id, trim($post['r_name'][$i])),
					'r_school'		=> mysqli_real_escape_string($this->db->conn_id, trim($post['r_school'][$i])),
					'r_phone'		=> mysqli_real_escape_string($this->db->conn_id, trim($post['r_phone'][$i])),
					'r_register'	=> date('Y-m-d H:i:s', time())
				);
			}
			return $this->db->insert_batch($this->db->dbprefix('early_register_user'), $data);
		}else if(strtolower($post['mode']) === 'modify'){
			$chk_len = count($post['chk']);
			for($j=0; $j<$chk_len; $j++){
				$idx = $post['chk'][$j];
				$data[$j] = array(
					'r_id'			=> mysqli_real_escape_string($this->db->conn_id, trim($post['r_id'][$idx])),
					'r_type'		=> mysqli_real_escape_string($this->db->conn_id, trim($post['r_type'])),
					'r_year'		=> mysqli_real_escape_string($this->db->conn_id, trim($post['r_year'])),
					'r_season'		=> mysqli_real_escape_string($this->db->conn_id, trim($post['r_season'])),
					'r_name'		=> mysqli_real_escape_string($this->db->conn_id, trim($post['r_name'][$idx])),
					'r_school'		=> mysqli_real_escape_string($this->db->conn_id, trim($post['r_school'][$idx])),
					'r_phone'		=> mysqli_real_escape_string($this->db->conn_id, trim($post['r_phone'][$idx])),
					'r_register'	=> date('Y-m-d H:i:s', time())
				);
			}
			return $this->db->update_batch($this->db->dbprefix('early_register_user'), $data, 'r_id');
		}else if(strtolower($post['mode']) === 'delete'){
			$chk_len = count($post['chk']);
			if($chk_len<1) return false;
			for($j=0; $j<$chk_len; $j++){
				$idx = $post['chk'][$j];
				$this->db->or_where_in('r_id', trim($post['r_id'][$idx]));
			}
			return $this->db->delete($this->db->dbprefix('early_register_user'));
		}else{
			return false;
		}
	}
	/* usb 인강 */
	public function set_usb_menus($post){
		$usb_data= array();
		$depth1_len = count($post['depth1']);
		for($i=0; $i<$depth1_len; $i++){
			$depth2_len = count($post['depth1_'.($i+1).'_sub']);
			$usb_sub_data = array();
			for($j=0; $j<$depth2_len; $j++){
				$usb_sub_data[$j] = array(
					'depth2' => addslashes($post['depth1_'.($i+1).'_sub'][$j]),
					'index'	 => 0
				);
			}
			$usb_data[$i] = array(
				'depth1' => addslashes($post['depth1'][$i]),
				'depth2' => $usb_sub_data,
				'index'	 => 0
			);
			unset($usb_sub_data);
		}
		$data = array('opt_name'=>'usb_lecture','opt_value'=>serialize($usb_data));
		if($this->check_homeoption_name('usb_lecture')){
			$this->db->where('opt_name', 'usb_lecture');
			return $this->db->update($this->db->dbprefix('options'), $data);
		}else{
			return $this->db->insert($this->db->dbprefix('options'), $data);
		}
	}
	public function get_usb_menus(){
		$this->db->where('opt_name', 'usb_lecture');
		$query = $this->db->get($this->db->dbprefix('options'));
		$result = $query->row();
		return $result;
	}
	public function set_usb_options($post){
		$data = array(
			'usb_opt_cate1' 			=> $post['usb_opt_cate1'],
			'usb_opt_cate2'				=> $post['usb_opt_cate2'],
			'usb_opt_teacher_name'		=> $post['usb_opt_teacher_name'],
			'usb_opt_teacher_ability'	=> $post['usb_opt_teacher_ability'],
			'usb_opt_info'				=> $post['usb_opt_info'],
			'usb_opt_list'				=> $post['usb_opt_list'],
			'usb_opt_register'			=> date('Y-m-d H:i:s', time())
		);
		return $this->db->insert($this->db->dbprefix('usb_option'), $data);
	}
	public function get_usb_options(){
		$query = $this->db->get($this->db->dbprefix('usb_option'));
		return $query->result();
	}
	public function get_ajax_usb_options($post){
		if(!is_numeric($post['item_id'])){
			return false;
		}else{
			$this->db->where('usb_opt_id', addslashes($post['item_id']));
			$query = $this->db->get($this->db->dbprefix('usb_option'));
			return $query->result();
		}
	}
	public function set_gangmom($agent, $ip, $referer){
		$data = array(
			'agent'		=> addslashes($agent),
			'ip'		=> addslashes($ip),
			'referer'	=> addslashes($referer),
			'register' 	=> date('Y-m-d h:i:s', time())
		);
		$this->db->insert($this->db->dbprefix('gangmom'), $data);
	}
// 회원테이블과 신천서들의 관계형 데이터베이스 흠.. 뭐 이건 나중에 다시 작업하도록하자 (트랜젝션 처리도 해야함 )
	public function set_member_relationData($table='', $data=array()){
		if(!empty($table) && count($data)>0){
			$this->db->insert($table, $data);
		}
	}
	// 마이페이지 내가 예약한 설명회
	public function get_my_presentation($id=''){
		if(empty($id)) return false;
		$this->db->select('*');
		$this->db->from($this->db->dbprefix('mem_presentation as m'));
		$this->db->join($this->db->dbprefix('presentation_user as u'), 'm.u_id = u.u_id', 'inner');
		$this->db->join($this->db->dbprefix('presentation as p'), 'p.p_id = u.p_id', 'inner');
		$this->db->where('m.user_id', $this->security->xss_clean($id));
		$this->db->order_by('u.u_register','DESC');
		$this->db->order_by('p.p_day','ASC');
		$query = $this->db->get();
		return $query->result();
	}
	// 마이페이지 내가 예약한 설명회 삭제
	public function delete_my_presentation($id='', $post){
		if($this->encryption->decrypt($this->session->userdata('user_id')) !== $id
		|| !is_numeric($post['u_id'])) return false;
		$this->db->select('p.p_day');
		$this->db->from($this->db->dbprefix('presentation_user as u'));
		$this->db->join($this->db->dbprefix('presentation as p'), 'u.p_id = p.p_id', 'inner');
		$this->db->where('u.u_id', $post['u_id']);
		$result = $this->db->get()->result();
		$nowDate = strtotime(date('Y-m-d h:i:s', time()));
		$p_status = ($nowDate < strtotime(explode(' ', $result[0]->p_day)[0].'+'.'-1'.' days'))?true:false;
		if($p_status){
			$this->db->where('u_id', $post['u_id']);
			return $this->db->delete($this->db->dbprefix('presentation_user'));
		}else{
			return false;
		}
	}
	// sms 남은 문자건수 저장
		// 개인정보취급방침등록
	public function set_sms_number($post){
		$sql = $this->db->where("opt_name","smsnumber")->get($this->db->dbprefix('options'));
		if($sql->num_rows() > 0){
			$data = array('opt_value'=>addslashes($post['smsnumber']));
			$this->db->where('opt_name', 'smsnumber');
			return $this->db->update($this->db->dbprefix('options'), $data);
		}else{
			$data = array('opt_name'=>'smsnumber','opt_value'=>addslashes($post['smsnumber']));
			return $this->db->insert($this->db->dbprefix('options'), $data);
		}
	}
}
?>
