<?php
defined('BASEPATH') OR exit('No direct script access allowed');
include_once(dirname(__FILE__).'/Auth.php');
class Mypage extends MY_Controller{
	private $user_id	= null;
	private $user_name 	= null;
	private $user_lv	= null;
	private $user_info	= null;
	protected $my_board = array();

	public function __construct(){
		parent::__construct();
		if(!$this->session->userdata('user_id')){
			goto_url(site_url());
		}
		$this->load->library('form_validation');
		$this->load->library('log_security_block');
		$this->load->library('captcha');
		$this->load->helper('form');
		$this->load->model('member_model');
		$this->load->model('board_model');

		//$this->load->model('register_model');
		$this->user_id 		= $this->encryption->decrypt($this->session->userdata('user_id'));
		$this->user_name 	= $this->session->userdata('user_name');
		$this->user_lv 		= $this->session->userdata('user_level');
		$this->user_info 	= $this->member_model->get_member($this->user_id, 'user_id');
		if(!$this->user_info || $this->log_security_block->check_block_ip() || $this->log_security_block->check_block_id($this->user_id)){
			$this->myLogout();
		}
		if($this->user_info[0]->user_sns_type === 'facebook'){
			$this->load->library('facebookapi');
			$check_token = $this->facebookapi->check_token($this->session->userdata('user_sns_token'));
			if(!$check_token || $check_token->id !== $this->user_info[0]->user_sns_id || $this->session->userdata('user_sns_token') !== $this->user_info[0]->user_sns_token){
				$this->myLogout();
			}
		}
		$this->lang->load('log', $this->homelanguage->lang_seting($this->umv_lang));
		$this->my_board = array('qna');
		$this->lang_member = $this->lang->line("member");
	}
	// 관리자인지 확인 관리자 정보수정은 관리자에서
	private function check_master(){
		if($this->session->userdata('user_id')  && $this->session->userdata('user_level') >= 7 ){
			goto_url(site_url().homeAdm);
		}
	}
	// 마이페이지 회원정보
	public function index(){
		// 관리자인지 확인 관리자 정보수정은 관리자에서
		$this->check_master();
		// 설명회예약 삭제할 아이디가 있는지
		$this->form_validation->set_rules('u_id', '', 'required|numeric');
		if($this->form_validation->run() == false){
			$data = $this->set_home_base(__CLASS__, __FUNCTION__, 'subheader-mypage');
			$data['page_1depth_name'] 		= stripslashes(ucfirst($data['lang_menu']['mypage']));
			$data['page_2depth_name'] 		= stripslashes($data['lang_bbs']['user_information']);
			$data['user_info']				= $this->user_info;
			$data['css_arr']				= array("<link rel='stylesheet' style='text/css' href='".HOME_CSS_PATH."/mypage.css' />");
			$data['lang_member']			= $this->lang_member;
			// 설명회예약
			//$data['my_presentation']		= $this->register_model->get_my_presentation($this->user_id);
			// 마이페이지 네비
			$data['mypage_nav']				= $this->load->view('pages/mypage/mypage_tabnav', $data, true);
			$this->load->view('include/header', $data);
			$this->_page('mypage/mypage', $data);
			$this->load->view('include/footer');
		}else{
			$result = $this->register_model->delete_my_presentation(
				$this->user_id, $this->input->post(null, true)
			);
			if($result){
				$this->session->set_flashdata('message', '설명회 예약 취소 완료');
			}else{
				$this->session->set_flashdata('message', '설명회 예약 취소 오류. 잠시 후 다시 시도해 주세요');
			}
			redirect(site_url().$this->umv_lang.'/mypage/');
		}
	}
	// 마이페이지 HTML
	protected function _modify_view(){
		$data = $this->set_home_base(__CLASS__, __FUNCTION__, 'subheader-mypage');
		$data['page_1depth_name'] 		= '마이페이지';
		$data['page_2depth_name'] 		= '회원정보 변경';
		$data['lang_member'] 			= $this->lang->line("member");
		$data['user_info']				= $this->user_info;
		$data['css_arr']				= array("<link rel='stylesheet' style='text/css' href='".HOME_CSS_PATH."/mypage.css' />");
		// 마이페이지 네비
		$data['mypage_nav']				= $this->load->view('pages/mypage/mypage_tabnav', $data, true);
		// js 삽입
		$custom_js1 			 		= "<script src='".HOME_JS_PATH."/BD_form_validation.js'></script>";
		$data['javascript_arr']  		= array($custom_js1);
		$this->load->view('include/header', $data);
		$this->_page('mypage/modify', $data);
		$this->load->view('include/footer');
	}
	// 마이페이지 회원정보 변경
	public function modify(){
		// 관리자인지 확인 관리자 정보수정은 관리자에서
		$this->check_master();
		if(preg_match ("/".$_SERVER['HTTP_HOST']."/", $this->agent->referrer()) && $this->session->userdata('user_id') && $this->session->userdata('user_sns_type')==='home'){
			$this->form_validation->set_rules('password', '비밀번호', 'required|min_length[6]|max_length[18]');
			$this->form_validation->set_rules('passconf', '비밀번호확인', 'required|min_length[6]|max_length[18]|matches[password]');
			if($this->form_validation->run() == FALSE){
				$this->_confirm_view(site_url().'mypage/modify');
			}else{
				// 캡차코드확인 위해서 한번더 폼검증
				$this->form_validation->set_rules('captcha', 'Captcha', array(
					'required',
					array($this->captcha, 'check_validate_captcha')
				));
				if($this->form_validation->run() == FALSE){
					$this->session->set_flashdata('message', '캡차코드를 정확히 입력해 주세요.');
					redirect(site_url().$this->umv_lang.'/mypage/modify');
				}else{
					$this->load->model('login_model');
					$userid 	= $this->encryption->decrypt($this->session->userdata('user_id'));
					$password 	= $this->input->post('password');
					$result 	= $this->login_model->check_login($userid, $password);

					if($result){
						$this->_modify_view();
					}else{
						$this->session->set_flashdata('message', '비밀번호 입력 오류.');
						redirect(site_url().$this->umv_lang.'/mypage/modify');
					}
				}
			}
		}else{
			redirect(site_url().$this->umv_lang);
		}
	}
	// 마이페이지 회원정보 변경 sns회원전용
	public function modify_sns(){
		// 관리자인지 확인 관리자 정보수정은 관리자에서
		$this->check_master();
		if(/*$this->input->post('sns_type') && */$this->session->userdata('user_sns_type') && $this->session->userdata('user_sns_type')!=='home'){
			$data = $this->_set_meta_data(array('title' => $this->user_name.'님의 회원정보 변경 | '.HOME_INFO_NAME));
				$this->_modify_view();
		}else{
			redirect(site_url().$this->umv_lang);
		}
	}
	// 마이페이지 회원정보 변경과 비번변경 처리함수
	public function modify_exec(){
		// 관리자인지 확인 관리자 정보수정은 관리자에서
		$this->check_master();
		if($this->member_model->check_userid()<1){
			$this->myLogout();
		}
		$type = $this->input->post('type');
		if($type == 'info_modify'){
			$this->form_validation->set_rules('user_phone', '핸드폰번호', 'required');
			$this->form_validation->set_rules('user_state', '학생 학교 국가', 'required');
			$this->form_validation->set_rules('user_grade', '학생 학년', 'required');
			if($this->session->userdata('user_sns_type') !== 'home'){
				$this->form_validation->set_rules('user_email', '이메일', 'required|valid_email');
			}
		}else if($type == 'pwd_modify'){
			$this->form_validation->set_rules('password', '비밀번호', 'required|min_length[6]|max_length[18]');
			$this->form_validation->set_rules('passconf', '비밀번호확인', 'required|min_length[6]|max_length[18]|matches[password]');
		}
		if($this->form_validation->run() == FALSE){
			$this->session->set_flashdata('message', '정확한 정보를 입력해 주세요.');
			redirect(site_url().$this->umv_lang.'/mypage/modify');
		}else{
			if($type == 'info_modify'){
				if($this->member_model->set_member_user($this->input->post(NULL, FALSE), $this->user_id)){
					$this->session->set_flashdata('message', '회원정보 수정 완료');
				}else{
					$this->session->set_flashdata('message', '내부 네트워크 오류로 인한 비밀번호 수정 실패\n잠시 후 다시 시도해주세요.\n\n고객센터 02)564-2510');
				}
			}else if($type == 'pwd_modify'){
				if($this->member_model->set_member_password($this->input->post(NULL, FALSE), $this->user_id)){
					$this->session->set_flashdata('message', '비밀번호수정 완료');
				}else{
					$this->session->set_flashdata('message', '내부 네트워크 오류로 인한 비밀번호 수정 실패\n잠시 후 다시 시도해주세요.\n\n고객센터 02)564-2510');
				}
			}
			redirect(site_url().$this->umv_lang.'/mypage');
		}
	}
	// 마이페이지 내가 작성한글
	public function board($bbs_table='qna', $page=1){
		if(in_array($bbs_table, $this->my_board)){
			if(!is_numeric($page) || $page < 1) $page = 1;
			$this->load->library('paging');
			$total = $this->board_model->get_user_board_list_totalnum($bbs_table, $this->user_id);
			$this->paging->paging_setting($total, $page, 12, 4);
			$page_limit = $this->paging->get_page_limit();
			$page_list  = $this->paging->get_page_list();
			$results	= $this->board_model->get_user_write_board_list($bbs_table, $this->user_id, $page_limit, $page_list);
			$data = $this->set_home_base(__CLASS__, __FUNCTION__, 'subheader-mypage');
			$data['page_1depth_name'] 	= stripslashes(ucfirst($data['lang_menu']['mypage']));
			$data['page_2depth_name'] 	= stripslashes($data['lang_bbs']['my_posts']);
			$data['bbs_table']			= $bbs_table;
			$data['table_info']			= $this->board_model->get_board($bbs_table);
			$data['results']			= $results;
			$data['user_info'] 			= $this->user_info;
			$data['css_arr']			= array("<link rel='stylesheet' style='text/css' href='".HOME_CSS_PATH."/mypage.css' />");
			$data['paging_show']		= $this->paging->get_paging(site_url().$this->umv_lang.'/mypage/board/'.$bbs_table.'/', '', 'paging-nav-typeA');
			$data['page']				= $page;
			$data['lang_member']		= $this->lang_member;
			$data['mypage_nav']			= $this->load->view('pages/mypage/mypage_tabnav', $data, true);
			$this->load->view('include/header', $data);
			$this->_page('mypage/board', $data);
			$this->load->view('include/footer');
		}else{
			$this->set_default_lang('message');
			$this->session->set_flashdata('message', stripslashes($this->lang_message['not_found_page']));
			redirect(site_url().$this->umv_lang.'/mypage/board/qna/1');
		}
	}
	// 마이페이지 스크랩
	public function scrap($page=1){
		$this->form_validation->set_rules('s_chk[]', '스크랩선택', 'required');

		if($this->form_validation->run() == FALSE){
			$this->load->library('paging');
			$total = $this->board_model->get_user_total_scrap();
			$this->paging->paging_setting($total, $page, 8, 5);
			$page_limit = $this->paging->get_page_limit();
			$page_list  = $this->paging->get_page_list();

			$scrap = $this->board_model->get_scrap($page_limit, $page_list);
			$scrap_results = array();

			foreach($scrap as $val){
				$scrap_results[] = $this->board_model->get_scrap_bbs_join_single($val->s_id, $val->b_table, $val->b_id);
			}
			$data = $this->set_home_base(__CLASS__, __FUNCTION__, 'subheader-mypage');
			$data['lang_member']		= $this->lang_member;
			$data['page_1depth_name'] 	= stripslashes(ucfirst($data['lang_menu']['mypage']));
			$data['page_2depth_name'] 	= stripslashes($data['lang_menu']['scrap']);
			$data['scrap_list']			= $scrap_results;
			$data['user_info'] 			= $this->user_info;
			$data['css_arr']			= array("<link rel='stylesheet' style='text/css' href='".HOME_CSS_PATH."/mypage.css' />");
			$data['paging_show']		= $this->paging->get_paging(site_url().$this->umv_lang.'/mypage/scrap/', '', 'paging-nav-typeA');
			$data['page']				= $page;
			$data['mypage_nav']			= $this->load->view('pages/mypage/mypage_tabnav', $data, true);
			$this->load->view('include/header', $data);
			$this->_page('mypage/scrap', $data);
			$this->load->view('include/footer');

		}else{
			if(!$this->board_model->delete_scrap($this->input->post(NULL, TRUE))){
				$this->session->set_flashdata('message', '스크랩 삭제오류.. 잠시 후 다시 시도해 주세요.');
			}
			redirect(site_url().$this->umv_lang.'/mypage/scrap/'.$this->input->post('paged'));
		}
	}
	// umv 회원 1:1문의 2 = 일반회원 3 = 수강생
	public function myqna($mode='list', $page_id=1){
		$this->check_master();
		if($this->user_lv < 3){
			$this->set_default_lang('message');
			$this->session->set_flashdata('message', $this->lang_message['not_found_page']);
			redirect(site_url().$this->umv_lang.'/mypage');
		}
		$this->load->library('fileupload_new');
		$this->load->model('myqna_model');
		$data							= $this->set_home_base(__CLASS__, __FUNCTION__, 'subheader-mypage');
		$data['css_arr']				= array("<link rel='stylesheet' style='text/css' href='".HOME_CSS_PATH."/mypage.css' />");
		$data['page_1depth_name'] 		= stripslashes(ucfirst($data['lang_menu']['mypage']));
		$data['page_2depth_name'] 		= stripslashes($this->lang_member['qna']);
		$data['lang_member']			= $this->lang_member;
		$data['user_info']				= $this->user_info;
		if($mode == 'view'){

		}else if($mode == 'write'){

		}else if($mode == 'modify'){

		}else{
			// list
			$this->load->library('paging');
			$total		= $this->myqna_model->get_qna_list_num($this->user_id);
			$this->paging->paging_setting($total, $page_id, 12, 5);
			$page_limit = $this->paging->get_page_limit();
			$page_list  = $this->paging->get_page_list();
			$qna_result = $this->myqna_model->get_qna_list($this->user_id, $page_limit, $page_list);
			$data['qna_result']			= $qna_result;
			$data['list_num'] 			= $total - $page_limit;
			$data['paging_show']   		= $this->paging->get_paging("/mypage/myqna/list/", '', 'paging-nav-typeA');
		}
		$data['mypage_nav']				= $this->load->view('pages/mypage/mypage_tabnav', $data, true);
		$this->load->view('include/header', $data);
		$this->_page('mypage/myqna_'.$mode, $data);
		$this->load->view('include/footer');
	}
	public function myqna_update(){
		$this->set_default_lang('message');
		$mode = $this->input->post('mode');
		$this->form_validation->set_rules('mode', 'mode', 'required');
		if($mode == 'write'){
			$this->form_validation->set_rules('mq_subject', 'subject1', 'required');
			$this->form_validation->set_rules('mq_content', 'contents', 'required|callback_bannedword_check');
		}else if($mode == 'modify'){

		}else{
			$this->session->set_flashdata('message', stripslashes($this->lang_message['access_error_msg']));
			redirect(site_url().$this->umv_lang.'/mypage');
		}
		$upload_files = fnc_upload_files($_FILES);
		$upload_file_check = true;
		$upload_file_exgt = 'zip|gif|jpg|png|pdf|xls|csv|xlsx|doc|docx|dot|dotx|word|xl';
		$upload_file_size = 1024*10;
		if($upload_files){
			if(!fnc_upload_files_ext_check($_FILES, $upload_file_exgt)){
				$upload_file_check=false;
				$this->session->set_flashdata('message', stripslashes($this->lang_message['file_cannot_upload']).'\n'.stripslashes($this->lang_message['list_of_upload_files']).'\n( '.$upload_file_exgt.' )');
			}
			if(!fnc_upload_files_size_check($_FILES, $upload_file_size)){
				$upload_file_check=false;
				$this->session->set_flashdata('message', stripslashes($this->lang_message['file_size_exceeded']).'\n'.stripslashes($this->lang_message['file_attached_size']).' '.($upload_file_size/1024).'mb');
			}
		}
		if($this->form_validation->run() == FALSE || !$upload_file_check){
			if(!$this->session->flashdata('message')){
				$this->session->set_flashdata('message', stripslashes($this->lang_message['input_error_msg']).' / '.stripslashes($this->lang_message['required_error_msg']));
			}
			$this->session->set_flashdata('mq_subject', $this->input->post('mq_subject'));
			$this->session->set_flashdata('mq_content', $this->input->post('mq_content'));
			$this->session->set_flashdata('ckeditor_img_path', $this->input->post('ckeditor_img_path'));
			$this->session->set_flashdata('copyImgFileNames', $this->input->post('copyImgFileNames'));
			redirect(site_url().$this->umv_lang.'/mypage/myqna/'.(($mode)?$mode:'list').'/'.$this->input->post('page_id'));
		}else{
			$this->load->model('myqna_model');
			$result = $this->myqna_model->insert($this->input->post(null, true), (($upload_files)?$_FILES:''), $upload_file_exgt, $upload_file_size);
			if($result['error_msg']){
				$this->session->set_flashdata('message', stripslashes($result['error_msg']));
			}else{

			}
		}
	}
	public function bannedword_check($str){
		$this->set_default_lang('message');
		$banned_word = explode(',', fnc_none_spacae(get_banned_word()));
		for($i=0; $i<count($banned_word); $i++){
			if(preg_match("/".$banned_word[$i]."/i", fnc_none_spacae($str))){
				$this->session->set_flashdata('message', stripslashes($this->lang_message['fobidden_word_msg']).' ('.$banned_word[$i].')');
				return false;
			}
		}
		return true;
	}




	public function myqna1($mode='list', $page=1){
		if($this->user_lv < 3){
			$this->set_default_lang('message');
			$this->session->set_flashdata('message', $this->lang_message['not_found_page']);
			redirect(site_url().$this->umv_lang.'/mypage');
		}
		$this->check_master();

		$this->load->library('fileupload_new');
		$this->load->model('myqna_model');

		$data = $this->set_home_base(__CLASS__, __FUNCTION__, 'subheader-mypage');
		$data['css_arr']				= array("<link rel='stylesheet' style='text/css' href='".HOME_CSS_PATH."/mypage.css' />");
		$data['page_1depth_name'] 		= stripslashes(ucfirst($data['lang_menu']['mypage']));
		$data['page_2depth_name'] 		= stripslashes($this->lang_member['qna']);
		$data['lang_member']			= $this->lang_member;
		if($mode === 'write'){
			$this->form_validation->set_rules('mode', '작성유형', 'required');
			$this->form_validation->set_rules('mq_subject', '제목', 'required');
			$this->form_validation->set_rules('mq_content', '내용', 'required');

		}else if($mode === 'modify'){

		}else if($mode === 'view'){

		}else{
			// list
			$this->load->library('paging');
			$total		= $this->myqna_model->get_qna_list_num($this->user_id);
			$this->paging->paging_setting($total, $page, 12, 5);
			$page_limit = $this->paging->get_page_limit();
			$page_list  = $this->paging->get_page_list();
			$qna_result = $this->myqna_model->get_qna_list($this->user_id, $page_limit, $page_list);
			$data['qna_result']			= $qna_result;
			$data['list_num'] 			= $total - $page_limit;
			$data['paging_show']   		= $this->paging->get_paging("/mypage/myqna/list/", '', 'paging-nav-typeA');
		}
		if($this->form_validation->run() == FALSE){
			$data['user_info']				= $this->user_info;
			// 마이페이지 네비
			$data['mypage_nav']				= $this->load->view('pages/mypage/mypage_tabnav', $data, true);
			$this->load->view('include/header', $data);
			$this->_page('mypage/myqna_'.$mode, $data);
			$this->load->view('include/footer');
		}else{
			$this->set_default_lang('message');
			if($mode === 'write'){
				$results = $this->board_update->insert(
					$_FILES,
					$this->input->post(null, true),
					'mypageqna',
					array(
						'upload_path' 	=> './assets/file/mypageqna/'.date('Y'),
						'allowed_types' => 'zip|gif|jpg|png|pdf|xls|csv|xlsx|doc|docx|dot|dotx|word|xl|hwp',
						'max_size' 		=> 10240,
						'encrypt_name' 	=> TRUE
					),
					'bbs_file'
				);

print_r($results);

				exit;
				if(isset($results['error_msg']) || !results || $results['error_msg']){
					$this->session->set_flashdata('message', str_striptag_fnc($this->lang_message[$results['error_msg']]));
				}else{
					$this->session->set_flashdata('message', str_striptag_fnc($this->lang_message['registered_msg']));
				}
				redirect(site_url().$this->umv_lang.'/mypage/myqna/list');
			}
		}
	}
	// 회원 1:1문의
	public function myqna2($mode='list', $page=1){
		$this->check_master();
		$data = $this->set_home_base(__CLASS__, __FUNCTION__, 'subheader-mypage');
		$data['css_arr']				= array("<link rel='stylesheet' style='text/css' href='".HOME_CSS_PATH."/mypage.css' />");
		$data['page_1depth_name'] 		= stripslashes(ucfirst($data['lang_menu']['mypage']));
		$data['lang_member']			= $this->lang_member;
		if($mode === 'write'){
			$this->form_validation->set_rules('mode', '작성유형', 'required');
			$this->form_validation->set_rules('mq_subject', '제목', 'required');
			$this->form_validation->set_rules('mq_content', '내용', 'required');
			$data['page_2depth_name'] 	= '문의 작성하기';
		}else if($mode === 'view'){
			// $page = mq_no
			$view_result = $this->myqna_model->view($this->user_id, $page);
			if(!$view_result) redirect(site_url().$this->umv_lang.'/mypage/myqna/list');
			if($view_result[0]->mq_reply==='yes' && $view_result[0]->mr_no){
				$this->myqna_model->set_user_read($view_result[0]->mq_no, $view_result[0]->mr_no);
			}
			$data['view_result']		= $view_result;
			$data['page_2depth_name'] 	= '나의 문의사항';
		}else if($mode === 'modify'){
			// $page = mq_no
			$this->form_validation->set_rules('mode', '작성유형', 'required');
			$this->form_validation->set_rules('mq_no', '문의글', 'required|numeric');
			$this->form_validation->set_rules('mq_subject', '제목', 'required');
			$this->form_validation->set_rules('mq_content', '내용', 'required');
			$my_result = $this->myqna_model->view($this->user_id, $page);
			if(!$my_result || $my_result[0]->mr_no || $my_result[0]->mq_read ==='yes' || $my_result[0]->mq_reply==='yes'){
				$this->session->set_flashdata('message', '접근 권한이 없는 글이거나. 답글이 진행중 또는 답글이 달린글의 경우 수정 하실 수 없습니다.');
				redirect(site_url().$this->umv_lang.'/mypage/myqna/list');
			}
			$data['my_result']		= $my_result;
			$data['page_2depth_name'] 	= '나의 문의사항 수정';
		}else if($mode === 'delete'){
			$this->form_validation->set_rules('mode', '작성유형', 'required');
			$this->form_validation->set_rules('mq_no', '문의글', 'required|numeric');
			$my_result = $this->myqna_model->view($this->user_id, $page);
			if(!$my_result || $my_result[0]->mr_no || $my_result[0]->mq_read ==='yes' || $my_result[0]->mq_reply==='yes'){
				$this->session->set_flashdata('message', '접근 권한이 없는 글이거나. 답글이 진행중 또는 답글이 달린글의 경우 삭제 하실 수 없습니다.');
				redirect(site_url().$this->umv_lang.'/mypage/myqna/list');
			}
		}else{
			$this->load->library('paging');
			$total		= $this->myqna_model->get_user_list_num($this->user_id);
			$this->paging->paging_setting($total, $page, 12, 5);
			$page_limit = $this->paging->get_page_limit();
			$page_list  = $this->paging->get_page_list();
			$qna_result = $this->myqna_model->get_user_list($this->user_id, $page_limit, $page_list);
			$data['qna_result']			= $qna_result;
			$data['list_num'] 			= $total - $page_limit;
			$data['paging_show']   		= $this->paging->get_paging("/mypage/myqna/list/", '', 'paging-nav-typeA');
			$data['page_2depth_name'] 	= '나의 문의목록';
		}
		if($this->form_validation->run() == FALSE){
			if($mode === 'delete'){
				redirect(site_url().$this->umv_lang.'/mypage/myqna/view/'.$page);
			}
			$data['user_info']				= $this->user_info;
			// 마이페이지 네비
			$data['mypage_nav']				= $this->load->view('pages/mypage/mypage_tabnav', $data, true);
			$this->load->view('include/header', $data);
			$this->_page('mypage/myqna_'.$mode, $data);
			$this->load->view('include/footer');
		}else{
			// 회원이 정말 맞는지 회원아이디가 있는지 db에서 재 확인
			if($this->member_model->check_userid()<1){
				$this->myLogout();
			}
			if($this->input->post('mode') === 'write'){
				$result = $this->myqna_model->write($this->input->post(null, true));
				$this->session->set_flashdata('message', '회원전용 1:1 문의 등록완료.\n빠른시간안에 전문 담당자가 궁금증을 해결해 드리겠습니다.');
				/*
				 * preg_replace('/-/si', '', $this->user_info[0]->user_phone);
				 * 이건 회원한테갈때 보내자
				 */
				$send_sms_msg = $this->user_info[0]->user_name.'님의 1:1문의가 등록되었습니다. ['.strip_tags($this->security->xss_clean($this->input->post('mq_subject'))).']';
				$send_sms_msg = fnc_utf8_strcut($send_sms_msg, 70, '..]');
				$this->load->library('sms_dotname');
				$sendPost = array(
					'sms_caller' 	=> '025402510',
					'sms_to'		=> $this->sms_staff_phone,
					'sms_msg'		=> $send_sms_msg,
					'sms_email'		=> array('kevin074@psuedu.org', 'u5ink@naver.com')
				);
				$this->sms_dotname->send_sms_email($sendPost);

				redirect(site_url().$this->umv_lang.'/mypage/myqna/list');
			}else if($this->input->post('mode') === 'modify'){
				// 이미 답변이 달려있거나 관리자가 해당글을 읽은 상태면 수정 불가능 위에서 (my_result) 이미 걸러짐
				if($this->myqna_model->update($this->user_id, $this->input->post(null, true))){
					$this->session->set_flashdata('message', '문의사항 수정완료');
				}else{
					$this->session->set_flashdata('message', '문의사항 수정오류 잠시 후 다시 시도해 주세요.');
				}
				redirect(site_url().$this->umv_lang.'/mypage/myqna/view/'.$this->input->post('mq_no'));
			}else if($this->input->post('mode') === 'delete'){
				// 이미 답변이 달려있거나 관리자가 해당글을 읽은 상태면 삭제 불가능 위에서 (my_result) 이미 걸러짐
				if($this->myqna_model->delete($this->user_id, $this->input->post(null, true))){
					$this->session->set_flashdata('message', '문의사항 삭제완료');
				}else{
					$this->session->set_flashdata('message', '문의사항 삭제오류 잠시 후 다시 시도해 주세요.');
				}
				redirect(site_url().$this->umv_lang.'/mypage/myqna/list');
			}
		}
	}
	// 마이페이지 회원탈퇴
	public function unregister(){
		// 관리자인지 확인 관리자 정보수정은 관리자에서
		$this->check_master();
		//echo $this->user_info[0]->user_sns_type !== 'home';
		if(preg_match ("/".$_SERVER['HTTP_HOST']."/", $_SERVER['HTTP_REFERER'])){
			if($this->user_info[0]->user_sns_type !== 'home'){
				redirect(site_url().$this->umv_lang);
			}
			$this->form_validation->set_rules('password', '비밀번호', 'required|min_length[6]|max_length[18]');
			$this->form_validation->set_rules('passconf', '비밀번호확인', 'required|min_length[6]|max_length[18]|matches[password]');

			if($this->form_validation->run() == FALSE){
				$this->_confirm_view(site_url().'mypage/unregister');
			}else{
				// 캡차코드확인 위해서 한번더 폼검증
				$this->form_validation->set_rules('captcha', 'Captcha', array(
					'required',
					array($this->captcha, 'check_validate_captcha')
				));
				if($this->form_validation->run() == FALSE){
					$this->session->set_flashdata('message', '캡차코드를 정확히 입력해 주세요.');
					redirect(site_url().$this->umv_lang.'/mypage/unregister');
				}else{
					$this->load->model('login_model');
					$userid 	= $this->encryption->decrypt($this->session->userdata('user_id'));
					$password 	= $this->input->post('password');
					$result 	= $this->login_model->check_login($userid, $password);

					if($result){
						$data = $this->set_home_base(__CLASS__, __FUNCTION__, 'subheader-actpage');
						$data['page_1depth_name'] 		= stripslashes(ucfirst($data['lang_menu']['mypage']));
						$data['page_2depth_name'] 		= '회원탈퇴__마이페이지 ';
						$data['user_id']				= $this->user_id;
						$data['user_info'] 				= $this->user_info;
						// 마이페이지 네비
						$data['mypage_nav']				= $this->load->view('pages/mypage/mypage_tabnav', $data, true);
						$this->load->view('include/header', $data);
						$this->_page('mypage/unregister', $data);
						$this->load->view('include/footer');

					}else{
						$this->session->set_flashdata('message', '비밀번호 입력 오류.');
						redirect(site_url().$this->umv_lang.'/mypage/unregister');
					}
				}
			}
		}else{
			redirect(site_url().$this->umv_lang);
		}
	}
	// 마이페이지 회원탈퇴 실행 함수 - 삭제가 아님 탈퇴 완료 페이지를 하나 만들자..
	public function unregister_exec(){
		// 관리자인지 확인 관리자 정보수정은 관리자에서
		$this->check_master();

		$this->form_validation->set_rules('password', '비밀번호', 'required');
		if($this->form_validation->run() == FALSE){
			$this->session->set_flashdata('message', '탈퇴를 하시려면 비밀번호를 입력해 주세요.');
			redirect(site_url().$this->umv_lang.'/mypage/unregister');
		}else{
			$result = $this->member_model->member_unregister($this->input->post(NULL, TRUE));
			$this->session->set_flashdata('message', $result['msg']);
			if($result['error']){
				redirect(site_url().$this->umv_lang.'/mypage/unregister');
			}else{
				$this->myLogout();
			}
		}
	}
	// 마이페이지 sns 회원탈퇴 실행 함수 - 삭제가 아님 카카오톡은 해당앱에서 회원정보 삭제함
	public function unregister_sns_exec(){
		// 관리자인지 확인 관리자 정보수정은 관리자에서
		$this->check_master();
		$this->form_validation->set_rules('user_sns_type', 'sns회원', 'required|alpha');
		if($this->form_validation->run() == FALSE){
			$this->session->set_flashdata('message', '잘못된 접근 방식입니다.');
			redirect(site_url().$this->umv_lang);
		}else{
			if($this->input->post('unregister') == 'delete'){
				$results = $this->member_model->delete_member($this->user_id);
			}else{
				$results = $this->member_model->sns_member_unregister($this->user_id);
			}
			if($results){
				if($this->user_info[0]->user_sns_type==='naver'){
					if($this->naverapi->delete_naver()){
						$this->myLogout();
						$this->session->set_flashdata('message', 'UMVietnam 탈퇴가 완료되었습니다.');
						redirect(site_url().$this->umv_lang);
					}else{
						$this->session->set_flashdata('message', '접속 인증 오류입니다. 잠시 후 다시 시도해주세요\n같은 에러가 계속 반복되면 고객센터로 문의 바랍니다. 02-540-2510');
						redirect(site_url().$this->umv_lang.'/mypage');
					}
				}else{
					if($this->user_info[0]->user_sns_type==='kakao'){
						$this->kakaoapi->kakao_unlink($this->user_info[0]->user_sns_token);
					}else if($this->user_info[0]->user_sns_type==='facebook'){
						$this->facebookapi->revoking_login($this->user_info[0]->user_sns_token);
					}
					$this->myLogout();
				}
			}else{
				$this->session->set_flashdata('message', '데이터 오류 회원탈퇴 실패\n 잠시 후 다시 시도해 주세요.');
				redirect(site_url().$this->umv_lang.'/mypage/unregister');
			}
		}
	}
	// function modify -> view 화면
	private function _confirm_view($frmlink){
		$data = $this->set_home_base(__CLASS__, __FUNCTION__, 'subheader-actpage');
		$data['page_1depth_name'] 		= stripslashes(ucfirst($data['lang_menu']['mypage']));
		$data['page_2depth_name'] 		= '개인정보확인__마이페이지 ';
		// 마이페이지 네비
		$data['mypage_nav']				= $this->load->view('pages/mypage/mypage_tabnav', $data, true);
		$data['frmlink']				= $frmlink;
		$data['captcha'] 				= $this->captcha->set_captcha_file(array('img_width'=>170));
		$data['javascript_arr'] 		= array("<script src='".HOME_JS_PATH."/BD_form_validation.js'></script>");

		$this->load->view('include/header', $data);
		$this->load->view('auth/confirm_pwd_user', $data);
		$this->load->view('include/footer');
	}
	protected function myLogout(){
		if($this->session->userdata('user_sns_type') === 'kakao'){
			$this->load->model('login_model');
			$token = $this->login_model->get_sns_token();
			$this->kakaoapi->logout($token);
		}
		$this->session->sess_destroy();
		redirect(site_url().$this->umv_lang);
	}
	protected function upload_files_ext_check($files='', $ext='jpg,gif,png,jpeg'){
		foreach($files['bbs_file']['name'] as $val){
			$arr = explode('.',$val);
			$stack = array_pop($arr);
			if(!in_array(strtolower($stack), $ext)){
				return false;
			}else{
				return true;
			}
		}
	}
	protected function upload_files_size_check($files='', $size='1024'){
		/*
컨트롤러에서 확인
모델들어가서는 라이브러리로 확인하고 트랙젝션 실행
파일은 해당 분류 폴더안 아이디로 저장
		*/
		// file size check
		foreach($files['bbs_file']['tmp_name'] as $val){
			//print_r( array_pop(explode('.',$val)));
			echo $val.'<br />';
			echo floor(filesize($val)/ 1024).'<br />';
		}
	}
}
?>
