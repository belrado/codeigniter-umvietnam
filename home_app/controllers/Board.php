<?php
if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/*
 * 게시판
 */
class Board extends MY_Controller{
	public function __construct(){
		parent::__construct();
		$this->load->helper('form');
		$this->load->library('form_validation');
		$this->load->library('captcha');
		$this->load->model('board_model');
		$this->user_type = $this->encryption->decrypt($this->session->userdata('user_type'));
		$this->lang->load('default', $this->homelanguage->lang_seting($this->umv_lang));
		$this->lang_bbs = $this->lang->line("bbs");
		$this->lang_message = $this->lang->line("message");
	}
	protected function check_board($bbs_table){
		$bbs_table = strtolower($bbs_table);
		$result = $this->board_model->get_board($bbs_table);
		if(empty(trim($bbs_table)) || ! $result){
			return false;
		}else{
			return $result;
		}
	}
	protected function check_board_admin($user_lv, $user_type, $bbs_adm_lv){
		if(($user_type ==HOME_PREFIX.'master' && $user_lv >= $bbs_adm_lv) || ($user_type==HOME_PREFIX.'superMaster' && $user_lv >=10)){
			return true;
		}else{
			return false;
		}
	}
	public function index(){
		$this->bbs_list();
	}
	// 접근권한 검사 리스트보기, 게시물보기, 쓰기수정
	private function check_access_level($access_level=0, $user_level=0){
		if((int) $access_level > 1 && $user_level < (int) $access_level){
			// 회원만 접근가능하며 접근가능한 레벨보다 회원의 레벨이 작다면
			if(!$this->session->userdata('user_id')){
				// 회원이 아니라면
				$this->session->set_flashdata('message', stripslashes($this->lang_message['requires_login_msg']));
				redirect(site_url().$this->umv_lang.'/auth/?returnURL='.rawurlencode(uri_string()));
			}else{
				// 회원이라면
				$this->session->set_flashdata('message', stripslashes($this->lang_message['access_error_msg']));
				redirect(site_url().$this->umv_lang);
			}
		}
	}
	// 게시판 리스트
	public function bbs_list($bbs_table = '', $cate = 'all', $page='1'){
		$cate 			= urldecode($cate);
		$bbs_table 		= strtolower($bbs_table);
		// 검색
		$sch_select 	= ($this->input->get('select')) ? trim(get_search_string($this->input->get('select'))) : '';
		$keyword 		= ($this->input->get('keyword')) ? get_search_string(clean_xss_tags(trim($this->input->get('keyword')))) : '';
		$result = $this->check_board($bbs_table);
		if($result){
			$user_level = ($this->session->userdata('user_level'))?$this->session->userdata('user_level'):0;
			// 접근권한 검사
			$this->check_access_level($result[0]->bbs_list_lv, $user_level);
			// 페이징
			$this->load->library('paging');
			$total			= $this->board_model->get_board_list_totalnum($bbs_table, $cate, $sch_select, $keyword);
			// 블로그형식 또는 ajax더보기할때 뒤로가기버튼이나 목록보기 버튼 처리
			$pageLimitNum = $result[0]->bbs_list_num;
			if($result[0]->bbs_type==='blog'){
				if(isset($_SERVER['HTTP_REFERER']) && preg_match ("/".$_SERVER['HTTP_HOST']."/", $_SERVER['HTTP_REFERER'])){
					$pageLimitNum = $result[0]->bbs_list_num * $page;
					if($pageLimitNum > ($total+$result[0]->bbs_list_num)/*(ceil($total * 0.1) *10)*/){
						$page = 1;
						$pageLimitNum = $result[0]->bbs_list_num * $page;
					}
				}else{
					$page = 1;
					$pageLimitNum = $result[0]->bbs_list_num;
				}
				$this->paging->paging_setting($total, 1, $pageLimitNum, 5);
			}else{
				$this->paging->paging_setting($total, $page, $pageLimitNum, 5);
			}
			$page_limit 	= $this->paging->get_page_limit();
			$page_list  	= $this->paging->get_page_list();
			// 게시판설정에서 1뎁스 메뉴가 있다면 해당 메뉴의 이름을 가져와서 셋팅한다. 아이디로 지정한 이유는 메뉴 이름이 바뀔수가 있기 때문에..
			$data 						= $this->check_bbs_1depth2($result);
			foreach($result[0] as $key=>$val){
				$data[$key] = $val;
			}
			$data['active'] 			= $data['bbs_name_'.$this->umv_lang]; //__FUNCTION__;
			$data['bbs_write_lv']		= $result[0]->bbs_write_lv;
			$data['user_lv'] 			= $user_level;
			$data['bbs_adm'] 			= $this->check_board_admin($data['user_lv'], $this->user_type, $data['bbs_adm_lv']);// 퀵메뉴 인크루드
			$data['category'] 			= $cate;
			$data['list_num']			= $total - $page_limit;
			$data['bbs_total_num']  	= $total;
			if($result[0]->bbs_type=="list" || $result[0]->bbs_type == 'qna' || $result[0]->bbs_type == 'list_img'){
				$db_select = "bbs_id, bbs_secret, bbs_num, bbs_index, bbs_parent, bbs_comment, bbs_cate, bbs_link, bbs_subject, bbs_content, bbs_thumbnail, bbs_hit, bbs_good, bbs_file, bbs_extra1, u.user_id, u.user_name, u.user_email, u.user_level, u.user_nick,  bbs_pwd, bbs_register";
			}else{
				$db_select = "";
			}
			$data['bbs_comment_use']	= ($result[0]->bbs_comment_lv>=2)?true:false;
			$data['bbs_result'] 		= $this->board_model->get_write_board_list($bbs_table, $page_limit, $page_list, $cate, $sch_select, $keyword, fnc_set_htmls_strip($result[0]->bbs_sort_type), $db_select);
			$data['paged']				= $page;
			// 게시판 타입이 토글형식일때 파일이 있는지
			$data['bbs_result_file'] 	= ($result[0]->bbs_type === "toggle") ? $this->board_model->get_bbs_files($this->db->dbprefix('write_'.$bbs_table), 0, 'files') : false;
			//$data['list_result'] 		= $this->review_model->get_review_list($page_limit, $page_list);
			//$data['paging_show']   		= $this->paging->get_paging(site_url()."board/list/".$bbs_table."/".$cate."/", '', 'paging-nav-typeA');
			$data['paging_show']   		= $this->paging->get_paging(site_url()."board/list/".$bbs_table."/".$cate."/", '?select='.$sch_select.'&amp;keyword='.$keyword, 'paging-nav-typeA');
			// 검색어
			$data['sch_select']			= $sch_select;
			$data['keyword']			= $keyword;
			// 카테고리와 검색어 인클루드
			ob_start();

			$data['cate_seach_sec']		= $this->load->view('board/search_html', $data, true);
            ob_end_clean();
			// 갤러리 형식이면 자바스크립트로 만든 뷰어를 불러온다
			if($data['bbs_type'] == 'gallery'){
				$include_html_arr1		= $this->load->view('board/gallery_jsviewer', $data, true);
				$data['include_html'] 	= array($include_html_arr1);
			}
			// rss 시용
			if($result[0]->bbs_feed == 'yes'){
				$data['home_rss'] = site_url().'feed/'.$result[0]->bbs_table.'/rss';
			}
			$this->load->view('include/header', $data);
			$this->_page($data['bbs_type'], $data, 'board');
			$this->load->view('include/footer');
		}else{
			$this->session->set_flashdata('message', stripslashes($this->lang_message['no_bbs_msg']));
			redirect(site_url().$this->umv_lang);
		}
	}
	// ajax 게시판 리스트 더보기
	public function bbs_list_ajax(){
		$bbs_table 	= $this->security->xss_clean($this->input->post('bbs_table'));
		if(!$this->board_model->check_board_name('bbs_table', $bbs_table) && is_numeric($this->input->post('limit')) && is_numeric($this->input->post('offset'))){
			$result = $this->board_model->get_more_list($this->input->post(NULL, TRUE));
			$result_arr = array();
			$err_msg = 'none';
			if(!isset($result['err_msg'])){
				foreach($result['list'] as $val){
					$bbs_link_last = explode('/', $val->bbs_link);
					$arr = array(
						'bbs_id'		=> (int)trim($val->bbs_id),
						'bbs_num'		=> $val->bbs_num,
						'bbs_cate'		=> trim(fnc_set_htmls_strip($val->bbs_cate)),
						'bbs_link'		=> trim(fnc_set_htmls_strip($val->bbs_link)),
						'bbs_link_last'	=> array_pop($bbs_link_last),
						'bbs_subject'	=> trim(str_striptag_fnc($val->bbs_subject)),
						'bbs_subject2'	=> trim(str_striptag_fnc($val->bbs_subject, '<br />,<br>')),
						'bbs_thumbnail' => trim(fnc_set_htmls_strip($val->bbs_thumbnail)),
						'bbs_image'		=> trim(fnc_set_htmls_strip($val->bbs_image)),
						'bbs_extra1'	=> trim(fnc_set_htmls_strip($val->bbs_extra1)),
						'bbs_extra2'	=> trim(fnc_set_htmls_strip($val->bbs_extra2)),
						'bbs_extra3'	=> trim(fnc_set_htmls_strip($val->bbs_extra3)),
						'user_id'		=> trim(fnc_set_htmls_strip($val->user_id)),
						'user_name'		=> trim(fnc_set_htmls_strip($val->user_name)),
						'bbs_good'		=> fnc_set_htmls_strip($val->bbs_good),
						'bbs_hit'		=> fnc_set_htmls_strip($val->bbs_hit),
						'bbs_register'	=> set_view_register_time($val->bbs_register),
						'bbs_register2'	=> set_view_register_time($val->bbs_register, 0, 10, '-'),
						'bbs_new'		=> ''
					);
					if(strtotime($val->bbs_register.'+'.'7'.' days') > strtotime(date('Y-m-d h:i:s', time()))){
						$arr['bbs_new'] = 'new';
					}
					$result_arr[] = $arr;
				}
				$result_arr = json_encode($result_arr);
				echo "{ \"bbs_list\": ";
				echo $result_arr.",\n";
				echo "\"bbs_list_last\": ";
				echo json_encode($result['list_last']).", \n";
				echo "\"bbs_token\": ";
				echo json_encode($this->security->get_csrf_hash())."\n";
				echo "}";
			}else{
				$err_msg = $result['err_msg'];
				$result_arr = json_encode($result_arr);
				echo "{ \"err_msg\": ";
				echo json_encode($err_msg).", \n";
				echo "\"bbs_token\": ";
				echo json_encode($this->security->get_csrf_hash())."\n";
				echo "}";
			}
		}else{
			die('<script>alert("ajax error."); document.location.href="'.site_url().'";</script>');
		}
	}
	// 게시글 보기
	public function bbs_view($bbs_table = '', $bbs_id){
		if(empty($bbs_table)){
			show_404();
		}
		if(empty($bbs_table) || !is_numeric($bbs_id)){
			$this->session->set_flashdata('message', stripslashes($this->lang_message['no_post_msg']));
			redirect(site_url().$this->umv_lang."/board/list/".$bbs_table);
		}
		// 검색어 와 페이지 목록보기 누를때를 대비해서
		$sch_select 	= ($this->input->get('select')) ? trim(get_search_string($this->input->get('select'))) : '';
		$keyword 		= ($this->input->get('keyword')) ? get_search_string(clean_xss_tags(trim($this->input->get('keyword')))) : '';
		$paged			= ($this->input->get('paged')) ? get_search_string(clean_xss_tags(trim($this->input->get('paged')))) : 1;
		// 테이블명
		$bbs_table = $this->security->xss_clean(strtolower($bbs_table));
		$result = $this->check_board($bbs_table);
		if($result){
			$user_level = ($this->session->userdata('user_level'))?$this->session->userdata('user_level'):0;
			// 접근권한 검사
			$this->check_access_level($result[0]->bbs_read_lv, $user_level);
			// 게시물 가져오기 댓글제외
			$bbs_result = $this->board_model->get_write_board_user($bbs_table, $bbs_id, false, true);
			if(!$bbs_result){
				$this->session->set_flashdata('message', stripslashes($this->lang_message['no_post_msg']));
				redirect(site_url().$this->umv_lang."/board/list/".$bbs_table);
			}
			/* 게시글 아이디 session에 저장 더보기 리스트의 경우 되돌아갔을때 해당 게시물로 가기위해 */
			$this->session->set_flashdata('bbs_viewid', $bbs_result[0]->bbs_id);
			// 이전글 다음글
			$prev_bbs_id = 0;
			$next_bbs_id = 0;
			if($result[0]->bbs_type == 'gallery' || $result[0]->bbs_type == 'blog'){
				$bbs_cate = ($result[0]->bbs_type=='blog')?'all':$bbs_result[0]->bbs_cate;
				$cate_type = clean_xss_tags($this->input->get('cate_type'));
				if(!empty($cate_type) && $cate_type === 'all'){
					$bbs_cate = 'all';
				}
				$next_prev_result = $this->board_model->get_board_prevlist($bbs_table, $bbs_result[0]->bbs_num, 1, $bbs_cate);
				$next_next_result = $this->board_model->get_board_nextlist($bbs_table, $bbs_result[0]->bbs_num, 1, $bbs_cate);
				$prev_bbs_id = (count($next_prev_result) > 0) ? $next_prev_result[0]->bbs_id:'';
				$next_bbs_id = (count($next_next_result) > 0) ? $next_next_result[0]->bbs_id:'';
			}
			if($bbs_result[0]->bbs_secret === 'yes'){
				/* 비밀글이라면 회원체크한다. 이건 회원전용임 */
				if(in_array($this->encryption->decrypt($this->session->userdata('user_type')), $this->_get_home_master_type())){
					// 관리자
					if($this->_check_security_master(
						$this->encryption->decrypt($this->session->userdata('user_type')),
						$this->encryption->decrypt($this->session->userdata('user_id')), 'boolean') &&
						$this->session->userdata('user_level') >= $result[0]->bbs_adm_lv){
					}else{
						// 관리권한없음
						$this->session->set_flashdata('message', stripslashes($this->lang_message['access_error_msg']));
						redirect(site_url().$this->umv_lang.'/board/list/'.$bbs_table.'/'.$paged);
					}
				}else{
					// 일반유저
					if( $bbs_result[0]->bbs_secret === 'yes' && ($this->session->userdata('user_id') && $bbs_result[0]->user_id === $this->encryption->decrypt($this->session->userdata('user_id')))){
							// 해당유저가 정말 맞는지 다시 한번 확인을 하자
					}else{
						$this->session->set_flashdata('message', stripslashes($this->lang_bbs['this_article_only_author']));
						redirect(site_url().$this->umv_lang.'/board/list/'.$bbs_table);
					}
				}
			}
			$data 	= $this->check_bbs_1depth2($result, array(
				'title'				=> fnc_set_htmls_strip($bbs_result[0]->bbs_subject, true)." - ".fnc_set_htmls_strip($result[0]->{'bbs_name_'.$this->umv_lang}, true)." | ".HOME_INFO_NAME,
				'meta_title' 		=> fnc_set_htmls_strip($bbs_result[0]->bbs_subject, true)." - ".fnc_set_htmls_strip($result[0]->{'bbs_name_'.$this->umv_lang}, true)." | ".HOME_INFO_NAME,
				'meta_description' 	=> fnc_utf8_strcut(fnc_set_striptag_strip2($bbs_result[0]->bbs_content, true), 250)
			));
			// 게시판설정에서 1뎁스 메뉴가 있다면 해당 메뉴의 이름을 가져와서 셋팅한다. 아이디로 지정한 이유는 메뉴 이름이 바뀔수가 있기 때문에..
			//$data = $this->check_bbs_1depth($result, $data);
			// 게시글 내용 db필드 이름으로 출력
			foreach($result[0] as $key=>$val){
				$data[$key] = $val;
			}
			$data['bbs_result'] 		= $bbs_result;
			$data['bbs_result_listf']	= ($bbs_result[0]->bbs_file > 0) ? $this->board_model->get_bbs_files($this->db->dbprefix('write_'.$bbs_table), $bbs_id, 'list') : false;
			$data['bbs_result_file']	= ($bbs_result[0]->bbs_file > 0) ? $this->board_model->get_bbs_files($this->db->dbprefix('write_'.$bbs_table), $bbs_id, 'files') : false;
			$data['active'] 			= $data['bbs_name_'.$this->umv_lang]; //__FUNCTION__;
			// 회원이면 회원아이디 비회원이면 nonmember
			//$data['user_id']			= ($this->session->userdata('user_id'))?$this->encryption->decrypt($this->session->userdata('user_id')):$this->encryption->encrypt('nonmember');
			$data['user_id']			= ($this->session->userdata('user_id'))?$this->session->userdata('user_id'):$this->encryption->encrypt('nonmember');
			$data['user_lv'] 			= $user_level;
			$data['bbs_write_lv']		= $result[0]->bbs_write_lv;
			$data['bbs_adm']			= $this->check_board_admin($data['user_lv'], $this->user_type, $data['bbs_adm_lv']);
			$data['my_write_check']  	= (is_numeric($user_level) && ($this->encryption->decrypt($this->session->userdata('user_id')) === $bbs_result[0]->user_id) || $user_level >= $result[0]->bbs_adm_lv) ? true : false;
			$data['is_cate_all'] 		= (isset($cate_type) && $cate_type == 'all') ? true : false;
			// 이전글 다음글
			$data['prev_bbs_id']		= $prev_bbs_id;
			$data['next_bbs_id']		= $next_bbs_id;
			// sns 공유 링크
			$data['sns_news_text']   	= urlencode(str_replace('\"', '"', fnc_set_htmls_strip($bbs_result[0]->bbs_subject)));
			$data['sns_news_sendurl'] 	= urlencode('http://'.$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI']);
			// 카테고리
			$data['cate_link'] 			= (!empty($data['bbs_cate_list']) && $data['bbs_cate_use'] == 'yes') ? strtolower($bbs_result[0]->bbs_cate) : '';
			// 목록보기 눌렀을때 넘어온 목록에서 검색어와 페이지가있다면
			$data['sch_select']			= $sch_select;
			$data['sch_keyword']		= $keyword;
			$data['paged']				= $paged;
			// 댓글기능 사용중이라면
			$data['comment']			= '';
			if($result[0]->bbs_comment_lv > 0){
				$comment_limit				= $result[0]->bbs_list_num; // 가져올개수
				$comment_start				= 0;  // 시작위치
				$data['c_readonly'] 		= '';
				$data['c_comment_txt']		= '';
				$data['nonmember_comment']  = false;
				if($data['bbs_comment_lv'] > 1 && $user_level < $data['bbs_comment_lv']){
					$data['c_readonly'] = 'readonly="readonly"';
					if(!$this->session->userdata('user_id')){
						$data['c_comment_txt']	= stripslashes($this->lang_message['requires_login_msg']);
					}else{
						$data['c_comment_txt']	= stripslashes($this->lang_message['permission_comments_msg']);
					}
				}else if($data['bbs_comment_lv'] == 1 && $user_level <1){
					$data['nonmember_comment'] 	= true;
					//$data['captcha'] 			= $this->captcha->set_captcha_file(array('img_width'=>180, 'img_height'=>40, 'font_size'=>18));
				}
				$data['comment_total']  = $this->board_model->get_comment_total($bbs_table, $bbs_id);
				$data['comment_limit']	= $comment_limit;
				$data['comment_list'] 	= $this->board_model->get_comment_list_join($bbs_table, $bbs_id, $comment_limit, $comment_start);
				$data['comment']		= $this->load->view('board/comment', $data, true);

				// 스크립트
				$custom_js1 			= "<script src='".HOME_JS_PATH."/BD_form_validation.js'></script>";
				$custom_js2 			= "<script src='".HOME_JS_PATH."/BD_bbs_comment.js'></script>";
				$data['javascript_arr'] = array($custom_js1, $custom_js2);
			}
			// 조회수 업데이트
			if($this->set_hit_update($bbs_table, $bbs_result[0]->bbs_id)){
				$bbs_result[0]->bbs_hit = $bbs_result[0]->bbs_hit+1;
			}
			// rss 시용
			if($result[0]->bbs_feed == 'yes'){
				$data['home_rss'] = site_url().'feed/'.$result[0]->bbs_table.'/rss';
			}
			$this->load->view('include/header', $data);
			$this->_page('view', $data, 'board');
			$this->load->view('include/footer');
		}else{
			$this->session->set_flashdata('message', stripslashes($this->lang_message['no_post_msg']));
			redirect(site_url().$this->umv_lang);
		}
	}
	// ajax 게시판 보기 - 갤러리
	public function bbs_view_ajax(){
		$bbs_table 	= $this->security->xss_clean($this->input->post('bbs_table'));
		$bbs_id 	= $this->security->xss_clean($this->input->post('bbs_id'));
		$bbs_cate 	= $this->security->xss_clean($this->input->post('bbs_cate'));
		$bbs_num	= $this->security->xss_clean($this->input->post('bbs_num'));
		if(!is_numeric($bbs_id) || empty($bbs_table) || empty($bbs_cate) || !is_numeric($bbs_num)){
			$this->return_ajax_errmsg(stripslashes($this->lang_message['input_error_msg']));
			exit;
		}
		$result_arr =$next_arr=$prev_arr = array();
		$result 	= $this->board_model->get_write_board($bbs_table, $bbs_id);
		$prev		= $this->board_model->get_board_prevlist($bbs_table, $bbs_num, 3, $bbs_cate, 'bbs_id, bbs_num, bbs_cate, bbs_subject, bbs_thumbnail');
		$next		= $this->board_model->get_board_nextlist($bbs_table, $bbs_num, 3, $bbs_cate, 'bbs_id, bbs_num, bbs_cate, bbs_subject, bbs_thumbnail');
		if(!$result){
			$this->return_ajax_errmsg(stripslashes($this->lang_message['try_again_msg']));
			exit;
		}
		foreach($result as $val){
			$arr = array(
				'bbs_id'			=> $val->bbs_id,
				'bbs_num'			=> $val->bbs_num,
				'bbs_cate'			=> trim(fnc_set_htmls_strip($val->bbs_cate)),
				'bbs_subject'		=> trim(fnc_set_htmls_strip($val->bbs_subject)),
				'bbs_content'		=> trim(stripslashes(str_nl2br_save_html($val->bbs_content))),
				'bbs_content_imgs'	=> trim(fnc_set_htmls_strip($val->bbs_content_imgs)),
				'bbs_thumbnail'		=> trim(fnc_set_htmls_strip($val->bbs_thumbnail)),
				'bbs_image'			=> trim(fnc_set_htmls_strip($val->bbs_image))
			);
			$result_arr[] = $arr;
		}
		foreach($prev as $val){
			$arr = array(
				'bbs_id'			=> $val->bbs_id,
				'bbs_num'			=> $val->bbs_num,
				'bbs_cate'			=> trim(fnc_set_htmls_strip($val->bbs_cate)),
				'bbs_subject'		=> trim(fnc_set_htmls_strip($val->bbs_subject)),
				'bbs_thumbnail'		=> trim(fnc_set_htmls_strip($val->bbs_thumbnail))
			);
			$prev_arr[] = $arr;
		}
		foreach($next as $val){
			$arr = array(
				'bbs_id'			=> $val->bbs_id,
				'bbs_num'			=> $val->bbs_num,
				'bbs_cate'			=> trim(fnc_set_htmls_strip($val->bbs_cate)),
				'bbs_subject'		=> trim(fnc_set_htmls_strip($val->bbs_subject)),
				'bbs_thumbnail'		=> trim(fnc_set_htmls_strip($val->bbs_thumbnail))
			);
			$next_arr[] = $arr;
		}
		$result_arr = json_encode($result_arr);
		$next_arr 	= json_encode($next_arr);
		$prev_arr	= json_encode($prev_arr);
		echo "{ \"bbs_view\": ";
		echo $result_arr.",\n";
		echo "\"bbs_prev\": ";
		echo $prev_arr.",\n";
		echo "\"bbs_next\": ";
		echo $next_arr.",\n";
		echo "\"bbs_token\": ";
		echo json_encode($this->security->get_csrf_hash())."\n";
		echo "}";
		exit;
	}
	/* 게시글 작성 */
	public function bbs_write($bbs_table = ''){
		$bbs_table = $this->security->xss_clean(strtolower($bbs_table));
		$result = $this->check_board($bbs_table);
		if($result){
			$user_level = $this->session->userdata('user_level');
			// 접근권한 검사
			$this->check_access_level($result[0]->bbs_write_lv, $user_level);
			$data 	= $this->check_bbs_1depth2($result, array(
				'title'				=> fnc_set_htmls_strip($result[0]->{'bbs_name_'.$this->umv_lang}, true)." ".$this->lang_bbs['write']." | ".HOME_INFO_NAME
			));
			foreach($result[0] as $key=>$val){
				$data[$key] = $val;
			}
			$data['active'] 		= $data['bbs_name_'.$this->umv_lang]; //__FUNCTION__;
			$data['user_name']  	= $this->session->userdata('user_name');
			$data['user_lv'] 		= $user_level;
			$data['bbs_adm'] 		= $this->check_board_admin($data['user_lv'], $this->user_type, $data['bbs_adm_lv']);
			$data['bbs_mode'] 		= 'insert';
			$custom_js1 			= "<script src='".HOME_JS_PATH."/BD_form_validation.js'></script>";
			$data['javascript_arr'] = array($custom_js1);
			$this->load->view('include/header', $data);
			$this->_page('write', $data, 'board');
			$this->load->view('include/footer');
		}else{
			$this->session->set_flashdata('message', stripslashes($this->lang_message['no_bbs_msg']));
			redirect(site_url().$this->umv_lang);
		}
	}
	/* 게시글 수정 보기 */
	public function bbs_modify($bbs_table = '', $bbs_id){
		// $result = 게시판이 존재하는지 존재한다면 게시판의 권한을 가져온다
		// $bbs_result = 게시글의 정보를 가져온다
		$bbs_table = $this->security->xss_clean(strtolower($bbs_table));
		$result = $this->check_board($bbs_table);
		if($result && is_numeric($bbs_id)){
			// 검색어 와 페이지 목록보기 누를때를 대비해서
			$sch_select 	= ($this->input->get('select')) ? trim(get_search_string($this->input->get('select'))) : '';
			$sch_keyword 	= ($this->input->get('keyword')) ? get_search_string(clean_xss_tags(trim($this->input->get('keyword')))) : '';
			$paged			= ($this->input->get('paged')) ? get_search_string(clean_xss_tags(trim($this->input->get('paged')))) : 1;

			$user_level = $this->session->userdata('user_level');
			// 회원제이기에 회원타입이 있어야하며(세션) 게시판의 레벨이 1이 넘어야하고 유저 레벨이 글쓰기 수정 레벨보다 낮다면 접근권한이 없다.
			$this->check_access_level($result[0]->bbs_write_lv, $user_level);
			// 게시글의 정보를 가지고 온다
			$bbs_result = $this->board_model->get_write_board($bbs_table, $bbs_id);
			if(!$bbs_result){
				$this->session->set_flashdata('message', stripslashes($this->lang_message['no_post_modify_msg']));
				redirect(site_url().$this->umv_lang);
			}
			/* qna 게시판 답글이 달려있거나 진행중인 글은 수정할수 없음
			if($bbs_table == 'qna' && $bbs_result[0]->bbs_extra1 !=''){
				$this->session->set_flashdata('message', stripslashes($this->lang_message['bbs_error_code_1001']));
				redirect(site_url().$this->umv_lang.'/board/view/'.$bbs_table.'/'.$bbs_result[0]->bbs_id.'/?select='.$sch_select.'&keyword='.$sch_keyword.'&paged='.$paged);
			}
			*/
			// 게시판 관리자 등급이 아니라면 게시글을 쓴본인이 맞는지 세션 아이디를 검사한다.
			if($this->session->userdata('user_level') < $result[0]->bbs_adm_lv && $bbs_result[0]->user_id != $this->encryption->decrypt($this->session->userdata('user_id'))){
				$this->session->set_flashdata('message', stripslashes($this->lang_message['access_error_msg']));
				redirect(site_url().$this->umv_lang);
			}
			// 게시글안에 파일이 있는지 검사해서 있다면 파일을 불러온다
			if($bbs_result[0]->bbs_file > 0){
				$bbs_list_file 	= $this->board_model->get_bbs_files($this->db->dbprefix('write_'.$bbs_table), $bbs_id, 'list');
				$bbs_files 		= $this->board_model->get_bbs_files($this->db->dbprefix('write_'.$bbs_table), $bbs_id, 'files');
			}
			// 파일이 있다면 파일 내용을 게시판 반환 배열안에 같이 넣는다.

			$data 	= $this->check_bbs_1depth2($result, array(
				'title'				=> fnc_set_htmls_strip($result[0]->{'bbs_name_'.$this->umv_lang}, true)." 수정 | ".HOME_INFO_NAME
			));
			foreach($result[0] as $key=>$val){
				$data[$key] = $val;
			}
			$data['active'] 	= $data['bbs_name_'.$this->umv_lang]; //__FUNCTION__;
			$data['user_name']  = $this->session->userdata('user_name');
			$data['user_lv'] 	= $user_level;
			$data['bbs_write_lv']= $result[0]->bbs_write_lv;
			$data['bbs_adm'] 	= $this->check_board_admin($data['user_lv'], $this->user_type, $data['bbs_adm_lv']);
			$data['bbs_mode'] 	= 'modify';
			$data['bbs_result'] = $bbs_result;
			$data['sch_select'] = $sch_select;
			$data['sch_keyword']= $sch_keyword;
			$data['paged']		= $paged;
			if(isset($bbs_list_file) && $bbs_list_file) {
				$data['bbs_list_file'] = $bbs_list_file;
			}
			if(isset($bbs_files) && $bbs_files){
				$data['bbs_files'] = $bbs_files;
			}
			$this->load->view('include/header', $data);
			$this->_page('write', $data, 'board');
			$this->load->view('include/footer');
		}else{
			$this->session->set_flashdata('message', stripslashes($this->lang_message['no_post_modify_msg']));
			redirect(site_url().$this->umv_lang);
		}
	}
	/* 게시글 엽데이트 : 작성, 수정  폼전송*/
	public function bbs_update(){
		$bbs_table = $this->security->xss_clean(strtolower($this->input->post('bbs_table')));
		$bbs_mode = $this->security->xss_clean($this->input->post('bbs_mode'));
		$bbs_id = ($this->input->post('bbs_id')) ? $this->security->xss_clean($this->input->post('bbs_id')) : '';
		// 유저타입 검사는 회원제 게시판
		if($this->user_type && $table_result = $this->check_board($bbs_table)){
			$this->form_validation->set_rules('bbs_table', 'Board', 'required');
			$this->form_validation->set_rules('bbs_subject', 'Subject', 'required');
			$this->form_validation->set_rules('bbs_content', 'Contents', 'required|callback_bannedword_check');

			if($this->form_validation->run() == FALSE){
				if(!$this->session->flashdata('message')){
					$this->session->set_flashdata('message', preg_replace('/\r\n|\r|\n/','',trim(strip_tags(validation_errors()))));
				}
				if($bbs_mode == "insert"){
					redirect(site_url().$this->umv_lang.'/board/write/'.$bbs_table);
				}else{
					redirect(site_url().$this->umv_lang.'/board/modify/'.$bbs_table.'/'.$bbs_id);
				}

			}else{
				$config = array(
					'upload_path' 	=> './assets/file/'.trim(strtolower($bbs_table)).'/'.date('Y'),
					'allowed_types' => 'gif|jpg|png|pdf|xls|csv|xlsx|doc|docx|dot|dotx|word|xl|hwp',
					'max_size' 		=> 2048,
					'encrypt_name' 	=> TRUE
				);
				$upload_file = $this->upload_files($bbs_table, $_FILES, $config);
				if($upload_file['is_error'] == 'error'){
					$error_msg = '';
					foreach($upload_file as $val){
						$error_msg .= $val;
					}
					$this->session->set_flashdata('message', $error_msg);
					$this->session->set_flashdata('bbs_subject', $this->input->post('bbs_subject'));
					$this->session->set_flashdata('bbs_content',  $this->input->post('bbs_content'));
					if($bbs_mode == "insert"){
						redirect(site_url().$this->umv_lang.'/board/write/'.$bbs_table);
					}else{
						redirect(site_url().$this->umv_lang.'/board/modify/'.$bbs_table.'/'.$bbs_id);
					}
				}else{
					if($bbs_mode == "insert"){
						$result = $this->board_model->board_write($this->input->post(NULL, FALSE), $upload_file);
						$redirect_link = site_url().$this->umv_lang.'/board/list/'.$bbs_table;
					}else if($bbs_mode == "modify"){
						$sch_select  = $this->security->xss_clean($select = $this->input->post('sch_select'));
						$sch_keyword = $this->security->xss_clean($select = $this->input->post('sch_keyword'));
						$paged 		 = $this->security->xss_clean($select = $this->input->post('paged'));
						$result = $this->board_model->board_write_update($this->input->post(NULL, FALSE), $upload_file);
						$redirect_link = site_url().$this->umv_lang.'/board/view/'.$bbs_table.'/'.$bbs_id.'/?select='.$sch_select.'&keyword='.$sch_keyword.'&paged='.$paged;
					}else{
						$result = false;
					}
					if($result	&& !isset($result['error_code'])){
						if($table_result[0]->bbs_syndication == 'yes'){
						/* 네이버 신디케이션 적용 post put */
							$this->load->library('syndication');
							$syndi_msg='';
							$syndi_data = array(
								's_bbs_table'		=> $table_result[0]->bbs_table,
								's_bbs_name'		=> $table_result[0]->bbs_name,
								's_bbs_subject'		=> $this->input->post('bbs_subject'),
								's_bbs_content'		=> $this->input->post('bbs_content'),
								's_bbs_register'	=> date('Y-m-d H:i:s', time())
							);
							if($bbs_mode == "insert" && is_numeric($result)){
								$syndi_data['s_type']	= 'insert';
								$syndi_data['s_bbs_id']	= $result;
								$syndi_msg=$this->syndication->post($syndi_data);
							}else if($bbs_mode == "modify"){
								$syndi_data['s_type']	= 'modify';
								$syndi_data['s_bbs_id']	= $this->input->post('bbs_id');
								$syndi_msg=$this->syndication->put($syndi_data);
							}

						/* 네이버 신디케이션 적용 end */
						}
						if($table_result[0]->bbs_syndication == 'yes' && $this->session->userdata('user_level') >=7){
							$this->session->set_flashdata('message', stripslashes($this->lang_message['complete_registration']).'\n'.$syndi_msg);
						}else{
							$this->session->set_flashdata('message', stripslashes($this->lang_message['complete_registration']));
						}
						redirect($redirect_link);
					}else{
						if(isset($result['error_code'])){
							$this->session->set_flashdata('message', stripslashes($this->lang_message['bbs_error_code_'.$result['error_code']]));
						}else{
							$this->session->set_flashdata('message', stripslashes($this->lang_message['try_again_msg']));
						}
						if($bbs_mode == "insert"){
							redirect(site_url().$this->umv_lang.'/board/write/'.$bbs_table);
						}else{
							redirect(site_url().$this->umv_lang.'/board/modify/'.$bbs_table.'/'.$bbs_id);
						}
					}
				}
			}
		}else{
			$this->session->set_flashdata('message', stripslashes($this->lang_message['no_bbs_msg']));
			redirect(site_url().$this->umv_lang);
		}
	}
	/* 댓글 등록 */
	public function bbs_comment(){
		$is_ajax = ($this->input->post('comment_type') && $this->input->post('comment_type') == 'add_ajax')?true:false;

		$this->form_validation->set_rules('user_id', 'User ID', 'required');
		if($this->session->userdata('user_level') < 7){
			$this->form_validation->set_rules('user_name', 'User Name', 'required|callback_bannedname_check');
		}
		$this->form_validation->set_rules('bbs_table', 'Board', 'required|alpha_dash');
		$this->form_validation->set_rules('bbs_id', '게시물', 'required|numeric');
		$this->form_validation->set_rules('bbs_num', '게시물순서', 'required|numeric');
		$this->form_validation->set_rules('bbs_content', '댓글', 'required|callback_bannedword_check');

		$re_link = site_url().$this->umv_lang.'/board/view/'.$this->input->post('bbs_table').'/'.$this->input->post('bbs_id');
		// 1분짜리 세션을 생성 아이피비교해서 같은 아이피면 1분당 1개씩만 글작성하게 한다.
		$this->load->library('log_security_block');
		if(!$this->log_security_block->get_check_write(10)){
			 $this->comment_error_return_type($is_ajax, stripslashes($this->lang_message['posted_short_time_msg']), $re_link);
		}
		if($this->form_validation->run() == FALSE){
			$this->comment_error_return_type($is_ajax, stripslashes($this->lang_message['required_error_msg']), $re_link);
		}else{
			$bbs_info = $this->board_model->get_board($this->input->post('bbs_table'));
			$user_level = ($this->session->userdata('user_level'))?$this->session->userdata('user_level'):0;
			if($bbs_info[0]->bbs_comment_lv > 1 &&  $user_level < $bbs_info[0]->bbs_comment_lv){
				if(!$this->session->userdata('user_id')){
					$this->comment_error_return_type($is_ajax, stripslashes($this->lang_message['requires_login_msg']), site_url().'auth/');
				}else{
					$this->comment_error_return_type($is_ajax, stripslashes($this->lang_message['permission_comments_msg']), $re_link);
				}
			}
			if($user_level < 1 && $bbs_info[0]->bbs_comment_lv==1){
				// 비회원 댓글달기
				if($this->encryption->decrypt($this->input->post('user_id')) !== 'nonmember'){
					$this->comment_error_return_type($is_ajax, stripslashes($this->lang_message['access_abnormal_msg']), site_url());
				}
				if(empty($this->input->post('bbs_pwd'))){
					$this->comment_error_return_type($is_ajax, stripslashes($this->lang_message['required_error_msg']), $re_link);
				}
				/*
				$this->form_validation->set_rules('captcha', 'Captcha', array(
					'required',
					array($this->captcha, 'check_validate_captcha')
				));
				if($this->form_validation->run() == FALSE){
					$this->comment_error_return_type($is_ajax, '캡차코드를 정확히 입력해 주세요.', $re_link);
				}
				*/
			}
			$result = $this->board_model->add_comment($this->input->post(NULL, TRUE));
			if($result['error']){
				// 실패
				$this->comment_error_return_type($is_ajax, $result['msg'], $re_link);
			}else{
				// 성공
				if($is_ajax){
					// ajax 성공시 댓글의 댓글은 하위 댓글이 몇개있는지에대한 카운트가 새롭게 바뀌어야한다.
					$results = $this->board_model->get_write_board($this->input->post('bbs_table'), $this->input->post('bbs_comment_parent'), 'bbs_comment');
					echo "{ \"bbs_comment\": ";
					echo json_encode($results[0]->bbs_comment).", \n";
					echo "\"umv_lang\": ";
					echo json_encode($this->umv_lang).", \n";
					echo "\"bbs_token\": ";
					echo json_encode($this->security->get_csrf_hash())."\n";
					echo "}";
					exit;
				}else{
					redirect($re_link);
				}
			}
		}
	}
	// 댓글 등록시 ajax와 일반등록을 혼합해서 쓴다.
	private function comment_error_return_type($is_ajax = false, $errmsg = '', $re_link=''){
		if($is_ajax){
			$this->return_ajax_errmsg($errmsg);
			exit;
		}else{
			$relink =(empty($re_link))?site_url().$this->umv_lang:$re_link;
			//if(!$this->session->flashdata())
			$this->session->set_flashdata('message', $errmsg);
			redirect($relink);
		}
	}
	// 댓글 더보기
	public function comment_more2(){
		echo '????';
		exit;
	}
	public function comment_more(){
		if(preg_match("/".$_SERVER['HTTP_HOST']."/", $this->agent->referrer())){
			$this->form_validation->set_rules('bbs_table','게시판','required|alpha_dash');
			$this->form_validation->set_rules('bbs_parent','게시글','required|numeric');
			$this->form_validation->set_rules('bbs_is_comment','댓글뎁스','required|numeric');
			if($this->input->post('is_comment')>1){
				$this->form_validation->set_rules('bbs_comment_parent','댓글','required|numeric');
			}
			$this->form_validation->set_rules('comment_start','댓글시작','required|numeric');
			$this->form_validation->set_rules('comment_limit','댓글갯수','required|numeric');

			if($this->form_validation->run() == FALSE){
				$this->return_ajax_errmsg(stripslashes($this->lang_message['input_error_msg']));
				exit;
			}else{
				$bbs_table			= $this->security->xss_clean($this->input->post('bbs_table'));
				$bbs_is_comment		= ($this->input->post('bbs_table'))?$this->security->xss_clean($this->input->post('bbs_is_comment')):1;
				$bbs_parent			= $this->security->xss_clean($this->input->post('bbs_parent'));
				$bbs_comment_parent	= ($this->input->post('bbs_comment_parent'))?$this->security->xss_clean($this->input->post('bbs_comment_parent')):0;
				$comment_start 		= ($this->input->post('comment_start'))?$this->security->xss_clean($this->input->post('comment_start')):0;
				$comment_limit 		= ($this->input->post('comment_limit'))?$this->security->xss_clean($this->input->post('comment_limit')):15;
				// ajax 더보기 누를때 새로쓴글이있고 기존사람은 단순히 더보기만 눌렀을때 밀림 현상 방지하기위해 마지막 아이디에 대한 limit 를 불러온다
				$list_last_id		= $this->input->post('list_last_id');
				$list_last_id		= (is_numeric($list_last_id))? $list_last_id:'';
				// 불러올 데이터가 전체갯수보다 크다면
				$comment_total = $this->board_model->get_comment_total($bbs_table, $bbs_parent, $bbs_is_comment, $bbs_comment_parent);
				if($comment_total <= $comment_start){
					if($this->input->post('more_type')){
						$this->return_ajax_errmsg('none');
					}else{
						$this->return_ajax_errmsg('none');
						//$this->return_ajax_errmsg('더 이상 불러올 데이터가 없습니다.');
					}
					exit;
				}
				$result = $this->board_model->get_comment_list_join($bbs_table, $bbs_parent, $comment_limit, $comment_start, $bbs_is_comment, $bbs_comment_parent, $list_last_id);
				if($result){
					$result_arr = array();
					foreach($result as $val){
						// 삭제버튼
						$user_del_check		= '';
						$admin_del_check 	= false;
						if($this->session->userdata('user_id')){
							if($this->session->userdata('user_level') >= 7){
								$admin_del_check = true;
							}
							if($val->user_id == $this->encryption->decrypt($this->session->userdata('user_id'))){
								$user_del_check = 'my_comment';
							}
						}else if($val->user_id === 'nonmember'){
							$user_del_check = 'nonmember_comment';
						}
						$write_user = ($val->user_id === 'nonmember')?'nonmember_write':'member_write';
						$arr = array(
							'bbs_table'				=> $bbs_table,
							'comment_total'			=> $comment_total,
							'parent_id'				=> ($bbs_is_comment > 1)?$bbs_comment_parent:$bbs_parent,
							'user_no'				=> stripslashes($val->user_no),
							'user_nick'				=> stripslashes($val->user_nick),
							'user_email'			=> preg_replace('/@.+$/', '', stripslashes($val->user_email)),
							'user_level'			=> $val->user_level,
							'unregister'			=> $val->unregister,
							'bbs_id'				=> $val->bbs_id,
							'bbs_parent'			=> $val->bbs_parent,
							'bbs_is_comment'		=> $val->bbs_is_comment,
							'bbs_comment'			=> $val->bbs_comment,
							'bbs_comment_num'		=> $val->bbs_comment_num,
							'bbs_comment_parent'	=> $val->bbs_comment_parent,
							'bbs_content'			=> fnc_set_htmls_strip($val->bbs_content),
							'bbs_good'				=> $val->bbs_good,
							'bbs_nogood'			=> $val->bbs_nogood,
							'write_user'			=> $write_user,
							'user_name'				=> ($val->user_level>=7)?fnc_set_htmls_strip($val->user_name):fnc_name_change2(fnc_set_htmls_strip($val->user_name), 6),
							'bbs_pwd'				=> $val->bbs_pwd,
							'user_ip'				=> $val->user_ip,
							'bbs_register'			=> set_view_register_time($val->bbs_register, 0, 16),
							'user_del_check'		=> $user_del_check,
							'admin_del_check'		=> $admin_del_check
						);
						$result_arr[] = $arr;
					}
					$result_arr = json_encode($result_arr);
					echo "{ \"more_list\": ";
					echo $result_arr.",\n";
					echo "\"bbs_token\": ";
					echo json_encode($this->security->get_csrf_hash())."\n";
					echo "}";
					exit;
				}else{
					$this->return_ajax_errmsg(stripslashes($this->lang_message['try_again_msg']));
					exit;
				}
			}
		}else{
			show_404();
		}
	}
	// 댓글 삭제 - 회원만 가능한 ajax 댓글 삭제, 비회원은 비밀번호 확인 후 form방식으로 삭제
	public function comment_memberr_del(){
		if(preg_match("/".$_SERVER['HTTP_HOST']."/", $this->agent->referrer())){
			$this->form_validation->set_rules('c_mode', '댓글삭제타입', 'required|alpha_dash');
			$this->form_validation->set_rules('bbs_table', '게시판아이디', 'required|alpha_dash');
			$this->form_validation->set_rules('bbs_is_comment', '댓글', 'required|numeric');
			$this->form_validation->set_rules('bbs_id', '댓글아이디', 'required|numeric');
			$this->form_validation->set_rules('bbs_parent', '댓글이달린게시글', 'required|numeric');
			$this->form_validation->set_rules('bbs_comment_parent', '댓글이달린 댓글', 'required|numeric');
			$mode = $this->input->post('c_mode');
			if($this->form_validation->run() == FALSE){
				if($mode == 'ajax'){
					$this->return_ajax_errmsg(stripslashes($this->lang_message['comments_delete_network_error_msg']));
					exit;
				}else{
					redirect(site_url().$this->umv_lang);
				}
			}else{

				if($mode == 'ajax'){
					// ajax 방식으로 삭제
					$bbs_table  		= $this->security->xss_clean($this->input->post('bbs_table'));
					$bbs_is_comment 	= ($this->input->post('bbs_is_comment'))?$this->security->xss_clean($this->input->post('bbs_is_comment')):1;
					$bbs_id  			= $this->security->xss_clean($this->input->post('bbs_id'));
					$bbs_parent  		= $this->security->xss_clean($this->input->post('bbs_parent'));
					$bbs_comment_parent = ($this->input->post('bbs_comment_parent'))?$this->security->xss_clean($this->input->post('bbs_comment_parent')):0;
					$c_del_type			= ($this->input->post('c_del_type'))?$this->security->xss_clean($this->input->post('c_del_type')):'';

					$comment_info = $this->board_model->get_write_board($bbs_table, $bbs_id, 'user_id');
					if(($this->session->userdata('user_id') && $this->session->userdata('user_level') >= 10) && $this->input->post('c_del_type') === 'super'){
						// 최고 관리자 권한으로 삭제 특별히 기재할게 있다면 사용

					}else if($comment_info[0]->user_id === $this->encryption->decrypt($this->session->userdata('user_id'))){
						// 자기가 쓴글이면 삭제 댓글의 댓글이 있는경우 삭제하지 못한다.
						if($this->board_model->get_comment_total($bbs_table, $bbs_parent, 2, $bbs_id)){
							$this->return_ajax_errmsg(stripslashes($this->lang_message['comments_cannot_delete_msg']));
							exit;
						}
					}else{
						$this->return_ajax_errmsg(stripslashes($this->lang_message['comments_delete_permission_msg']));
						exit;
					}
					// 삭제시작
					if($this->board_model->delete_comment($bbs_table, $bbs_id, $bbs_parent, $bbs_is_comment, $bbs_comment_parent)){
						$comment_cnt='';
						if($bbs_is_comment > 1 && $bbs_comment_parent >0){
							$comment_cnt_r = $this->board_model->get_write_board($bbs_table, $bbs_comment_parent, 'bbs_comment');
							$comment_cnt   = $comment_cnt_r[0]->bbs_comment;
						}

						echo "{ \"delete\": ";
						echo json_encode('success').", \n";
						echo "\"comment_cnt\": ";
						echo json_encode($comment_cnt).", \n";
						echo "\"bbs_token\": ";
						echo json_encode($this->security->get_csrf_hash())."\n";
						echo "}";

					}else{
						$this->return_ajax_errmsg(stripslashes($this->lang_message['comments_delete_network_error_msg']));
						exit;
					}
				}else{
					// 비회원의 경우 패스워드 확인 후 form 전송 방식으로 삭제
					// 현재 비회원 댓글기능은 필요없다고 하여 작업 중지..
					redirect(site_url().$this->umv_lang);
				}
			}
		}else{
			show_404();
		}
	}
	/* 게시글 삭제 */
	public function board_write_delete(){
		$redirect_url = site_url().$this->umv_lang."/board/list/".$this->security->xss_clean($this->input->post('bbs_table'));
		if(count($this->input->post('bbs_id')) < 1){
			$this->session->set_flashdata('message', stripslashes($this->lang_message['selected_error_msg']));
			redirect($redirect_url);
		}
		if(!$this->session->userdata('user_id') || !$this->board_model->update_usercheck($this->input->post(NULL, TRUE))){
			$this->session->set_flashdata('message', stripslashes($this->lang_message['access_error_msg']));
			redirect($redirect_url);
		}
		$result = $this->board_model->board_write_delete($this->input->post(NULL, TRUE));
		if(!$result['error']){
			/* syndication delete */
			$table_result = $this->check_board($this->input->post('bbs_table'));
			if($table_result[0]->bbs_syndication == 'yes'){
				$this->load->library('syndication');
				$syndi_msg=$this->syndication->delete($this->input->post('bbs_table'), $this->input->post('bbs_id'));
			}
			if($table_result[0]->bbs_syndication == 'yes' && $this->session->userdata('user_level') >=7){
				$this->session->set_flashdata('message', stripslashes($this->lang_message['removed_msg']).'\n'.implode(",", $syndi_msg));
			}else{
				$this->session->set_flashdata('message', stripslashes($this->lang_message['removed_msg']));
			}
			redirect($redirect_url);
		}else{
			$this->session->set_flashdata('message', $this->lang_message['bbs_error_code_'.$result['error_code']]);
			redirect($redirect_url);
		}
	}
	protected function upload_files(
		$bbs_table='default', $files, $config=array(
			'upload_path' 	=> './assets/file/',
			'allowed_types' => 'gif|jpg|png',
			'max_size' 		=> 2048,
			'encrypt_name' 	=> TRUE )){

		$bbs_table = strtolower($bbs_table);
		if(!is_dir($config['upload_path'])){
			@mkdir($config['upload_path'], 0777, true);
		}

		$this->load->library('upload', $config);
		$result = array();
		$userType_allowed = $config['allowed_types'];

		if(isset($files['bbs_image'])){
			foreach($files['bbs_image']['name'] as $key=>$image){
				if($files['bbs_image']['name'][$key]){
					$_FILES['bbs_image[]']['name']= $files['bbs_image']['name'][$key];
		            $_FILES['bbs_image[]']['type']= $files['bbs_image']['type'][$key];
		            $_FILES['bbs_image[]']['tmp_name']= $files['bbs_image']['tmp_name'][$key];
		            $_FILES['bbs_image[]']['error']= $files['bbs_image']['error'][$key];
		            $_FILES['bbs_image[]']['size']= $files['bbs_image']['size'][$key];

					$config['allowed_types'] ='gif|jpg|png';
		            $this->upload->initialize($config);

		            if ($this->upload->do_upload('bbs_image[]')) {
		              $result['bbs_images'][] =  $this->upload->data();
		            } else {
		            	if($key > 0 ){
							for($j=0; $j < ($key); $j++){
								@unlink($result['bbs_image'][$key-1]['full_path']);
							}
						}
		            	return $this->upload_files_errormsg($result, '리스트이미지', $this->upload->display_errors());
		            }
				}
			}
		}
		if(isset($files['bbs_file'])){
			$file_num = 0;
			foreach ($files['bbs_file']['name'] as $key => $val) {
				if($files['bbs_file']['name'][$key]){
		            $_FILES['bbs_file[]']['name']= $files['bbs_file']['name'][$key];
		            $_FILES['bbs_file[]']['type']= $files['bbs_file']['type'][$key];
		            $_FILES['bbs_file[]']['tmp_name']= $files['bbs_file']['tmp_name'][$key];
		            $_FILES['bbs_file[]']['error']= $files['bbs_file']['error'][$key];
		            $_FILES['bbs_file[]']['size']= $files['bbs_file']['size'][$key];
					$config['allowed_types'] = $userType_allowed;
		            $this->upload->initialize($config);
		            if($this->upload->do_upload('bbs_file[]')){
		            	$insert_arr = array();
						$insert_arr = $this->upload->data();
						$insert_arr['index'] = $file_num; /* 파일순서 알기 위해서 */
		            	$result['bbs_file'][] =  $insert_arr;
		            }else{
						if(isset($result['bbs_images'])){
							for($i=0; $i < count($result['bbs_images']); $i++){
								@unlink($result['bbs_images'][$i]['full_path']);
							}
						}

						if($key > 0 ){
							for($j=0; $j < ($key); $j++){
								@unlink($result['bbs_file'][$key-1]['full_path']);
							}
						}
		            	return $this->upload_files_errormsg($result, stripslashes($this->lang_bbs['attach']).($key+1), $this->upload->display_errors());
		            }
		        }
				$file_num++;
	        }
	    }
		$result['is_error'] = 'none';
	    return $result;
	}
	private function upload_files_errormsg(&$result, $label_name, $error){
		$result['is_error'] = 'error';
		$result['error_msg'] = preg_replace('/\r\n|\r|\n/','',trim(strip_tags($label_name.' : '.$error)));
		return $result;
	}
	// 파일 다운로드
	public function filedown($filename='', $filepath=false, $file_mime_type=''){
		if(empty($filename)){
			show_404();
		}else{
 			$this->load->helper('cookie');
 			if(!get_cookie('break_down')){
				if(!get_cookie('check_cnt')){
					set_cookie('check_cnt', 1, 5);
				}else{
					$cnt = (int)get_cookie('check_cnt');
					$cnt++;
					if($cnt > 5){
						set_cookie('break_down', date('Y-m-d H:i:s',time()), 14400);
					}else{
						set_cookie('check_cnt', $cnt, 10);
					}
				}
				$filename = $this->security->sanitize_filename(basename($filename));
				$mime_type = array('pdf', 'jpeg', 'jpg', 'gif', 'hwp', 'png', 'excel', 'xls', 'xlsx', 'docx', 'word');
				if(!empty($file_mime_type)){
					$file_mime_type = $this->security->xss_clean(preg_replace('/\./', '', $file_mime_type));
					if(!in_array($file_mime_type, $mime_type)){
						show_404();
					}else{
						$filename = $this->security->sanitize_filename(basename($filename.'.'.$file_mime_type));
					}
				}
				$this->load->library('filedown');
				if($filepath && is_numeric($filepath)){
					$row = $this->board_model->get_bbs_file($filepath, 'bf_path, bf_size');
					$this->filedown->set_filedir($row->bf_path);
				}else if($filepath === 'img'){
					// 이미지 다운 급하게 만듬 이부분 수정하거나 삭제해야함 2017/7/11
					$filenames = explode('_', $filename);
					if($filenames[0] === 'list'){
						$this->filedown->set_filedir(FCPATH.'assets/file/gallery/'.$filenames[1].'/');
						$filename = $filenames[2];
					}else if($filenames[0] === 'ck'){
						$this->filedown->set_filedir(FCPATH.'assets/img/ckeditor/gallery/');
						$filename = $filenames[1];
					}

				}else{
					$this->filedown->set_filedir(FCPATH.'assets/file/down/');
				}
				$this->filedown->downfile($filename, $mime_type);
			}else{
				$this->load->model('logrecord_model');
				$this->logrecord_model->set_logrecord('down');
				$start_date = date("Y-m-d H:i:s", strtotime(get_cookie('break_down')."+4 hours"));
				$this->session->set_flashdata('message', '비정상적인 파일 다운으로 인해 관리자에 의해 차단되었습니다. '.$start_date.'시 이후 부터 다시 다운로드 가능합니다.');
				redirect(site_url().$this->umv_lang);
			}
		}
	}
	public function upload_imgfile_ckeditor($bbs_table='default'){
		$bbs_table = strtolower($bbs_table);
		$config['upload_path'] = './assets/img/ckeditor/'.$bbs_table;
		$config['allowed_types'] = 'gif|jpg|png';
		$config['max_size'] = '1024';
		//$config['max_width']  = '1024';
		//$config['max_height']  = '1024';
		$config['encrypt_name'] = TRUE;
		$this->load->library('upload', $config);
		if(!is_dir($config['upload_path'])){
			@mkdir($config['upload_path'], 0777, true);
		}
		if(! $this->upload->do_upload('upload')){
			$error = $this->upload->display_errors('','');
			echo "<script>alert('".$error."'); </script>";
			$this->callback_ckeditor_upload_csrf();
			echo $error;
			return false;
		}else{
			$CHEditorFuncNum = $this->input->get('CKEditorFuncNum');
			$data = $this->upload->data(); //array('upload_data'=>$this->upload->Data());
			$filename = $data['file_name'];
			$url = '/assets/img/ckeditor/'.$bbs_table.'/'.$filename;
			// 에디터에서 업로드시킨 파일들을 저장시킨다 .. 이유는 폼전송시 실제로 넘어온 이미지와 미리보기시 이미지를 비교해 삭제된 이미지는 서버에서 삭제하기 위해서
			echo "<script type='text/javascript'>
					window.parent.CKEDITOR.tools.callFunction('".$CHEditorFuncNum."', '".$url."', '".stripslashes($this->lang_message['complete_registration'])."');
					var imgfilename = window.parent.getIds('copyImgFileNames').value;
					var imgfile = (imgfilename !== '') ? ',".$filename."' : '".$filename."';
					imgfilename += imgfile;
					window.parent.getIds('copyImgFileNames').value = imgfilename;
				</script>";
			$this->callback_ckeditor_upload_csrf();
			return true;
		}
	}
	/* 게시물 좋아요 버튼 */
	public function add_bbs_good(){
		if(check_from_home()){
			$this->form_validation->set_rules('b_table', 'board', 'required|alpha_dash');
			$this->form_validation->set_rules('b_id', 'id', 'required|numeric');
			if($this->form_validation->run() == FALSE){
				if($this->input->post('ajax') && $this->input->post('ajax') == 'is_ajax'){
					echo "{ ";
					echo "\"error_msg\": ";
					echo json_encode(stripslashes($this->lang_message['ajax_error_msg'])).", \n";
					echo "\"bbs_token\": ";
					echo json_encode($this->security->get_csrf_hash())."\n";
					echo "}";
				}else{
					redirect(site_url().$this->umv_lang);
				}
			}else{
				$result = $this->board_model->add_good($this->input->post(NULL, TRUE));
				if($this->input->post('ajax') && $this->input->post('ajax') == 'is_ajax'){
					echo "{ ";
					if($result){
						if(isset($result['error_code'])){
							echo "\"error_msg\": ";
							echo json_encode(stripslashes($this->lang_message['bbs_error_code_'.$result['error_code']])).", \n";
						}
					}else{
						echo "\"error_msg\": ";
						echo json_encode(stripslashes($this->lang_message['ajax_error_msg'])).", \n";
					}
					echo "\"bbs_token\": ";
					echo json_encode($this->security->get_csrf_hash())."\n";
					echo "}";
				}else{
					if($result){
						if(isset($result['error_code'])){
							$this->session->set_flashdata('message', stripslashes($this->lang_message['bbs_error_code_'.$result['error_code']]));
						}
					}else{
						$this->session->set_flashdata('message', stripslashes($this->lang_message['clipped_error_msg']));
					}
					redirect(site_url().$this->umv_lang.'/board/view/'.$this->input->post('b_table').'/'.$this->input->post('b_id'));
				}
			}
		}else{
			show_404();
		}
	}
	/* 게시물 스크랩기능 */
	// 스크랩추가
	public function add_bbs_scrap(){
		$this->form_validation->set_rules('b_table', 'board', 'required|alpha_dash');
		$this->form_validation->set_rules('b_id', 'id', 'required|numeric');
		if($this->form_validation->run() == FALSE){
			redirect(site_url().$this->umv_lang);
		}else{
			if($this->session->userdata('user_id')){
				$result = $this->board_model->add_scrap($this->input->post(NULL, TRUE));
				if($result){
					if(isset($result['error_code'])){
						$this->session->set_flashdata('message', stripslashes($this->lang_message['bbs_error_code_'.$result['error_code']]));
						//$this->session->set_flashdata('message', $result['msg']);
					}else{
						$this->session->set_flashdata('message', stripslashes($this->lang_message['clipped_msg']));
					}
				}else{
					$this->session->set_flashdata('message', stripslashes($this->lang_message['clipped_error_msg']));
				}
			}else{
				$this->session->set_flashdata('message', stripslashes($this->lang_message['requires_login_msg']));
			}
			redirect(site_url().$this->umv_lang.'/board/view/'.$this->input->post('b_table').'/'.$this->input->post('b_id'));
		}
	}
	/* end 스크랩기능 */
	// 금지단어가 있는지 form validation
	public function bannedword_check($str){
		$banned_word = explode(',', fnc_none_spacae(get_banned_word()));
		for($i=0; $i<count($banned_word); $i++){
			if(preg_match("/".$banned_word[$i]."/i", fnc_none_spacae($str))){
				$this->session->set_flashdata('message', stripslashes($this->lang_message['fobidden_word_msg']).' ('.$banned_word[$i].')');
				return false;
			}
		}
		return true;
	}
	// 금지단어 또는 금지이름이 있는지 form_validation
	public function bannedname_check($str){
		$new_banned_word = fnc_none_spacae(get_banned_word()).fnc_none_spacae(','.get_banned_name());
		$banned_word = explode(',', $new_banned_word);
		for($i=0; $i<count($banned_word); $i++){
			if(preg_match("/".$banned_word[$i]."/i", fnc_none_spacae($str))){
				$this->session->set_flashdata('message', stripslashes($this->lang_message['forbidden_name_msg']).' ('.$banned_word[$i].')');
				return false;
			}
		}
		return true;
	}
	/* 회원 네이버 블로그로 퍼가기 */
	public function get_naver_cate(){
		$this->load->library('naverapi');
		$response = $this->naverapi->get_blog_category($this->session->userdata('user_sns_token'));
		if(!$response){
			$access_token = $this->naverapi->refresh_token($this->encryption->decrypt($this->session->userdata('user_id')));
			if($access_token){
				$this->session->set_userdata('user_sns_token', $access_token);
			}
			$response = $this->naverapi->get_blog_category($this->session->userdata('user_sns_token'));
		}
		if($response){
			$data = array();
			foreach($response->message->result as $val){
				$data[] = array(
					'cateNo'	=> $val->categoryNo,
					'category'	=> $val->name
				);
			}
			echo "{ \"category\": ";
			echo json_encode($data).", \n";
			echo "\"bbs_token\": ";
			echo json_encode($this->security->get_csrf_hash())."\n";
			echo "}";
		}else{
			echo "{ \"bbs_token\": ";
			echo json_encode($this->security->get_csrf_hash())."\n";
			echo "}";
		}
	}
	/*캡차 아작스로 생성*/
	public function get_captcha_code($id){
		if(is_numeric($id)){
			$captcha = $this->captcha->set_captcha_file(array('img_width'=>180, 'img_height'=>40, 'font_size'=>18, 'img_id'=>'Imageid'.$id));
			echo '{"captcha_code":"';
			echo json_encode($captcha).'"}';
		}
	}
	private function callback_ckeditor_upload_csrf(){
		echo "<script>window.parent.getIds('".$this->security->get_csrf_token_name()."').value='".$this->security->get_csrf_hash()."';</script>";
	}
	// 게시판설정에서 해당게시판의 1뎁스 메뉴가 설정되어있다면 해당 메뉴의 아이디값으로 이름을 가져와서 넘긴다. 없다면 게시판 이름을 1뎁스 메뉴로 넘긴다.
	private function check_bbs_1depth($result, $data){
		if($result[0]->bbs_1depth > 0){
			$this->load->model('globalnav_model');
			$bbs_1depth_result = $this->globalnav_model->nav_get_list($result[0]->bbs_1depth);
			$bbs_1depth_name = $bbs_1depth_result[0]->{'nav_name_'.$this->umv_lang};
		}
		if(isset($bbs_1depth_name)){
			$data['page_1depth_name'] = $bbs_1depth_name;
			$data['page_2depth_name'] = $result[0]->{'bbs_name_'.$this->umv_lang};
		}else{
			$data['page_1depth_name'] = $result[0]->{'bbs_name_'.$this->umv_lang};
		}
		return $data;
	}
	// 새로바뀜
	private function check_bbs_1depth2($result, $set_meta=array()){
		$this->load->model('globalnav_model');
		$bbs_1depth_result = $this->globalnav_model->nav_get_list($result[0]->bbs_1depth);
		if($bbs_1depth_result){
			$bbs_1depth_name = fnc_set_htmls_strip($bbs_1depth_result[0]->{'nav_name_'.$this->umv_lang}, true);
			$nav_access = fnc_set_htmls_strip($bbs_1depth_result[0]->nav_access, true);
			$nav_table	= fnc_set_htmls_strip($result[0]->bbs_table, true);
			$data = $this->set_home_base($nav_access, $nav_table, 'subheader-'.$nav_access, $set_meta);
		}else{
			$data = $this->set_home_base(__CLASS__, __FUNCTION__, 'subheader-actpage', $set_meta);
		}
		if(!isset($bbs_1depth_name)){
			$data['page_1depth_name'] = $result[0]->{'bbs_name_'.$this->umv_lang};
		}
		return $data;
	}
	// ajax 사용시 에러값 반환하면서 토큰 새로 갱신 csrf땜시
	private function return_ajax_errmsg($errmsg){
		echo "{ \"err_msg\": ";
		echo json_encode($errmsg).", \n";
		echo "\"bbs_token\": ";
		echo json_encode($this->security->get_csrf_hash())."\n";
		echo "}";
	}
	// 조회수 업데이트
	private function set_hit_update($bbs_table='', $bbs_id=''){
		if(empty($bbs_table) || !is_numeric($bbs_id)) return false;
		$this->load->helper('cookie');
		$cookie_val = (get_cookie('bbs_table['.$bbs_table.']'))?unserialize(get_cookie('bbs_table['.$bbs_table.']')):array();
		if(!in_array($bbs_id, $cookie_val)){
			array_push($cookie_val, $bbs_id);
			set_cookie('bbs_table['.$bbs_table.']', serialize($cookie_val), 86400*7);
			$this->board_model->set_hit_update($bbs_table, $bbs_id);
		}
	}
}
?>
