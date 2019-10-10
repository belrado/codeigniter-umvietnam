<?php
class MY_Controller extends CI_Controller{
	// 디폴트 메일, 최고관리자 레벨, 관리자 레벨, 유저 레벨
	const HOME_INFO_MAIL 		= 'info@umvietnam.com';
	//const HOME_INFO_MAIL2 		= 'admission@umvietnam.com';
	const HOME_SUPERMASTER_LV 	= 10;
	const HOME_MASTER_LV 		= 7;
	const HOME_USER_LV			= 2;
	public $sms_staff_phone		= array();
	// 관리자타입
	private $home_master_type 	= null;
	private $home_meta_arr 		= array();
	// 언어셋관련
	protected $umv_lang 		= null;
	protected $umv_state_lang   = null;
	/* 페이스북 좋아요 사용하지 않을 페이지 */
	public $umv_class_facebook_none = array();
	public $umv_method_facebook_none = array();

	function __construct(){
		parent::__construct();
		/*
		언어코드비교해서 기본 언어셋을 설정하고 언어버튼을 누름에 따라 도메인뒤에 언어코드가 삽입된다.
		url에 언어코드가 없다면 기본 언어셋을 설정
		*/
		$this->umv_lang = $this->homelanguage->has_language(uri_string());
		$this->umv_state_lang = $this->homelanguage->check_lang_cut();
		$meta_arr = $this->homelanguage->get_home_meta();
		$this->home_master_type = array(HOME_PREFIX.'superMaster', HOME_PREFIX.'master');
		$this->sms_staff_phone 	= array('01032441757');
		$this->home_meta_arr 	= array(
			'title' 			=> HOME_INFO_NAME.' - '.$meta_arr['slogan'][$this->umv_lang],
			'meta_title' 		=> HOME_INFO_NAME.' - '.$meta_arr['slogan'][$this->umv_lang],
			'meta_keyword' 		=> $meta_arr['keyword'][$this->umv_lang],
			'meta_description' 	=> $meta_arr['description'][$this->umv_lang]
		);
		$this->umv_class_facebook_none = array('board', 'auth', 'mypage');
		$this->umv_method_facebook_none = array('news', 'faq', 'qna');
	}
	/* 관리자, 회원 등급 체크 */
	protected function _get_home_master_type(){
		return $this->home_master_type;
	}
	// 최고관리자인지 확인
	protected function _check_security_supermaster($sess_type){
 		if($sess_type !== HOME_PREFIX.'superMaster' || $this->session->userdata('user_level') < self::HOME_SUPERMASTER_LV){
 			$this->session->sess_destroy();
			goto_url(site_url());
		}
	}
	// 관리자인지확인
	protected function _check_security_master($sess_type, $sess_userid, $return_type="direct"){
		$this->load->model('member_model');
		$userinfo = $this->member_model->get_member($sess_userid, 'user_id');
 		if($userinfo[0]->user_level < self::HOME_MASTER_LV || !in_array($sess_type, $this->home_master_type) || $this->session->userdata('user_level') < self::HOME_MASTER_LV){
			if($return_type === 'direct'){
				$this->session->sess_destroy();
				goto_url(site_url());
			}else{
				return false;
			}
		}else{
			if($return_type !== 'direct'){
				return true;
			}
		}
	}
	// 레벨 지정 관리자만 허용
	protected function _check_security_master_lv($level){
		if($this->session->userdata('user_level') < $level){
			$this->session->set_flashdata('message', '해당 페이지에 대한 관리 권한이 없습니다.');
			goto_url(site_url().'homeAdm');
		}
	}
	// 메타테그 가져오기
	protected function _get_home_metatag(){
		return $this->home_meta_arr;
	}
	// 메타테그등록 과 세션이 있다면 db접속해서 회원인지 아닌지 비교
	protected function _set_meta_data($custom_meta=array()){
		if($this->session->userdata('user_id')){
			$this->load->model('common_model');
			$user_id = $this->encryption->decrypt($this->session->userdata('user_id'));
			$check_result = $this->common_model->get_member_unregister($user_id);
			if($check_result){
				if($this->session->userdata('user_level') != $check_result->user_level || $this->session->userdata('user_name') != $check_result->user_name || $check_result->mail_approve =='no' || $check_result->unregister == 'yes'){
					$this->session->sess_destroy();
					goto_url(site_url());
				}
			}else{
				$this->session->sess_destroy();
				goto_url(site_url());
			}
		}
		$default_meta = array(
			'title' 			=> $this->home_meta_arr['title'],
			'meta_title' 		=> $this->home_meta_arr['meta_title'],
			'meta_keyword' 		=> $this->home_meta_arr['meta_keyword'],
			'meta_description' 	=> $this->home_meta_arr['meta_description']
		);
		/* description : 고득점 노하우와 비법을 담아 SAT,SAT TEST, ACT ACT TEST,AP,GED,토플,텝스 등 미국대 입시시험 전문 강의를 제공, 분야별 아이비리그 출신, 대치동 탑클래스 강사진이 수업을 진행하며, 10년 경력의 college application팀에서 1:1 맞춤형 미국대 입시 컨설팅을 제공합니다. */
		foreach($custom_meta as $key=>$val){
			if(in_array($key, array_keys($default_meta))){
				$default_meta[$key] 	= $val;
			}
		}
		$default_meta['home_popup']		= $this->register_model->get_home_popup('popup_event');
		$default_meta['is_mobile'] 		= $this->agent->is_mobile();
		$default_meta['user_browser'] 	= $this->agent->browser();
		return $default_meta;
	}
	// 페이지 보여주기 게시판은 board, 일반페이지는 pages
	protected function _page($page, $data, $type = 'pages'){
		switch($type){
			case 'board' :
				$path = 'views/board/';
				break;
			case 'pages' :
			default :
				$path = 'views/pages/';
				break;
		}
		if(! file_exists(APPPATH.$path.$page.'.php')){
			show_404();
			//$this->load->view('nonepage', $data);
		}else{
			$this->load->view($type.'/'.$page, $data);
		}
	}
	// 관리자 페이지
	protected function _getPageLayout($page, $data, $another_path=false){
		$data['check_adm_lv'] = $this->session->userdata('user_level');
		$this->load->view('adm/header', $data);
		if($another_path){
			$this->load->view($page, $data);
		}else{
			$this->load->view('adm/'.$page, $data);
		}
		$this->load->view('adm/footer', $data);
	}
	// 모바일인지 일반 브라우져인지 확인
	protected function _check_mobile(){
		return $this->agent->is_mobile();
	}
	// 상단메뉴
	protected function _getNav(){
		$this->load->model('globalnav_model');
		$autonav = $this->globalnav_model->nav_get_list_autoset();
		$nav1len=0;
		$nav2len=0;
		$nav3len=0;
		$nav  = array();
		$nav1 = array();
		$nav2 = array();
		$nav3 = array();
		for($i = 0; $i < count($autonav); $i++){
			if($autonav[$i]->nav_depth === '1depth'){
				$nav1[$nav1len] = $autonav[$i];
				$nav1len++;
			}
			if($autonav[$i]->nav_depth === '2depth'){
				$nav2[$nav2len] = $autonav[$i];
				$nav2len++;
			}
			if($autonav[$i]->nav_depth === '3depth'){
				$nav3[$nav3len] = $autonav[$i];
				$nav3len++;
			}
		}
		$nav2len=0;
		$nav3len=0;
		for($i=0; $i < count($nav1); $i++){
			$nav[$i] = $nav1[$i];
			for($j=0; $j < count($nav2); $j++){
				if($nav1[$i]->nav_id == $nav2[$j]->nav_parent){
					$nav[$i]->nav_depth2[$nav2len] = $nav2[$j];
					for($c=0; $c < count($nav3); $c++){
						if($nav2[$j]->nav_id == $nav3[$c]->nav_sub_parent && $nav3[$c]->nav_sub_parent > 0){
							$nav[$i]->nav_depth2[$nav2len]->nav_depth3[$nav3len] = $nav3[$c];
							$nav3len++;
						}
					}
					$nav3len = 0;
					$nav2len++;
				}
			}
			$nav2len = 0;
		}
		return $nav;
	}
	protected function set_home_base($className='', $methodName='', $subheader_class='subheader-satpage', $custom_title=array()){
		$nav				= $this->_getNav();
		$set_meta			= array();
		$breadcrumbs 		= array();
		$className			= strtolower(fnc_none_spacae($className));
		$methodName			= strtolower(fnc_none_spacae($methodName));
		$page_1depth_name	= '';
		$page_2depth_name	= '';
		$page_3depth_name	= '';
		$rss_catenum		= 0;
		foreach($nav as $val){
			$breadcrumbs['depth1'][] = array(
				'nav_name' 		=> $val->{'nav_name_'.$this->umv_lang},
				'nav_access'	=> $val->nav_access,
				'nav_link'		=> $val->nav_link,
				'nav_target'	=> $val->nav_target
			);
			if($className === strtolower(fnc_none_spacae($val->nav_access))){
				$rss_catenum = $val->nav_id;
				$page_1depth_name = $val->{'nav_name_'.$this->umv_lang};
				$breadcrumbs['depth2'] = $val->nav_depth2;
				foreach($val->nav_depth2 as $val2){
					if(isset($val2->nav_depth3)){
						foreach($val2->nav_depth3 as $val3){
							if(strtolower($methodName) === strtolower(fnc_none_spacae($val2->nav_access)) || strtolower($methodName) === strtolower(fnc_none_spacae($val3->nav_access))){
								$breadcrumbs['depth3']	= $val2->nav_depth3;
								if(strtolower($methodName) === strtolower(fnc_none_spacae($val3->nav_access))){
									$page_2depth_name = $val2->{'nav_name_'.$this->umv_lang};
									$page_3depth_name = $val3->{'nav_name_'.$this->umv_lang};
									if(!empty($val3->{'nav_meta_title_'.$this->umv_lang})){
										$set_meta['title']				= fnc_set_htmls_strip($val3->{'nav_meta_title_'.$this->umv_lang}, true).' | UMVietnam';
										$set_meta['meta_title']			= fnc_set_htmls_strip($val3->{'nav_meta_title_'.$this->umv_lang}, true).' | UMVietnam';
									}
									if(!empty($val3->{'nav_meta_keyword_'.$this->umv_lang})){
										$set_meta['meta_keyword']		= fnc_set_htmls_strip($val3->{'nav_meta_keyword_'.$this->umv_lang}, true);
									}
									if(!empty($val3->{'nav_meta_description_'.$this->umv_lang})){
										$set_meta['meta_description'] = preg_replace('/\r\n|\r|\n/','',fnc_set_htmls_strip($val3->{'nav_meta_description_'.$this->umv_lang}, true));
									}
									$depth3_parent = strtolower(fnc_none_spacae($val2->nav_access));
								}
							}
						}
					}
					if($methodName === strtolower(fnc_none_spacae($val2->nav_access))){
						$page_2depth_name = $val2->{'nav_name_'.$this->umv_lang};
						if(!empty($val2->{'nav_meta_title_'.$this->umv_lang})){
							$set_meta['title']				= fnc_set_htmls_strip($val2->{'nav_meta_title_'.$this->umv_lang}, true).' | UMVietnam';
							$set_meta['meta_title']			= fnc_set_htmls_strip($val2->{'nav_meta_title_'.$this->umv_lang}, true).' | UMVietnam';
						}
						if(!empty($val2->{'nav_meta_keyword_'.$this->umv_lang})){
							$set_meta['meta_keyword']		= fnc_set_htmls_strip($val2->{'nav_meta_keyword_'.$this->umv_lang}, true);
						}
						if(!empty($val2->{'nav_meta_description_'.$this->umv_lang})){
							$set_meta['meta_description'] = preg_replace('/\r\n|\r|\n/','',fnc_set_htmls_strip($val2->{'nav_meta_description_'.$this->umv_lang}, true));
						}
					}
				}
				if(!isset($set_meta['meta_keyword'])){
					if(!empty($val->{'nav_meta_keyword_'.$this->umv_lang})){
						$set_meta['meta_keyword']			= fnc_set_htmls_strip($val->{'nav_meta_keyword_'.$this->umv_lang}, true);
					}
				}
				if(!isset($set_meta['meta_description'])){
					if(!empty($val->{'nav_meta_description_'.$this->umv_lang})){
						$set_meta['meta_description'] = preg_replace('/\r\n|\r|\n/','',fnc_set_htmls_strip($val->{'nav_meta_description_'.$this->umv_lang}, true));
					}
				}
			}
		}
		foreach($custom_title as $key=>$val){
			$set_meta[$key] 	= $val;
		}
		$data 						= $this->_set_meta_data($set_meta);
		$data['mp_nav'] 			= $nav;
		$data['breadcrumbs']		= $breadcrumbs;
		$data['page_1depth_name'] 	= $page_1depth_name;
		$data['page_1depth_prev']	= $this->get_1depth_prev($breadcrumbs['depth1'], $page_1depth_name);
		$data['page_1depth_next']	= $this->get_1depth_next($breadcrumbs['depth1'], $page_1depth_name);
		$data['page_2depth_name'] 	= $page_2depth_name;
		$data['page_3depth_name']	= $page_3depth_name;
		$data['page_3depth_parent']	= (isset($depth3_parent))?$depth3_parent:'';
		$data['active_class'] 		= $className;
		$data['active_method'] 		= $methodName;
		//$data['quick_nav'] 		 	= $this->load->view('include/quick_nav', $data, true);
		$data['subheader_class'] 	= $subheader_class;
		$data['rss_catenum']		= $rss_catenum;
		$data['state_lang']			= $this->umv_state_lang;
		$data['umv_lang']			= $this->umv_lang;
		$data['lang_info']			= $this->lang->line("info");
		$data['lang_menu']			= $this->lang->line("menu");
		$data['lang_bbs']			= $this->lang->line("bbs");
		$data['lang_message']		= $this->lang->line("message");
		return $data;
	}
	// 1뎁스 이전
	public function get_1depth_prev($depth1=array(), $menu=''){
		$index =  array_search($menu, array_column($depth1, 'nav_name'));
		return $depth1[(($index-1 < 0)?count($depth1)-1:$index-1)];
	}
	// 1뎁스 다음
	public function get_1depth_next($depth1=array(), $menu=''){
		$index =  array_search($menu, array_column($depth1, 'nav_name'));
		return $depth1[(($index+1 > count($depth1)-1)?0:$index+1)];
	}
	// 404 not found 페이지
	public function show_home404err(){
		header('HTTP/1.0 404 Not Found');
		$data 					 		= $this->_set_meta_data(array('title' =>'404 Page Not Found | '.HOME_INFO_NAME));
		$data['mp_nav'] 		 		= $this->_getNav();
		$data['page_1depth_name'] 		= '404 Page Not Found';
		$data['active'] 		 		= __FUNCTION__;
		$data['is_mobile'] 		 		= $this->_check_mobile();
		// 퀵메뉴 인크루드
		//$data['quick_nav'] 		 		= $this->load->view('include/quick_nav', $data, true);
		ob_start();
		$errhtml = $this->load->view('include/header' ,$data, true);
		$errhtml .= $this->load->view('error_404', $data, true);
		$errhtml .= $this->load->view('include/footer', $data, true);
		ob_end_clean();
		return $errhtml;
	}
	protected function set_home_redirect($url='', $msg=''){
		$url = (empty($url))?site_url():$url;
		if(!empty($msg)){
			$this->session->set_flashdata('message', $msg);
		}
		redirect($url);
		exit;
	}
	// 언어
	protected function set_default_lang($select=''){
		switch($select){
			case 'menu' :
				$this->lang_menu 		= $this->lang->line("menu");
				break;
			case 'bbs' :
				$this->lang_bbs			= $this->lang->line("bbs");
			break;
			case 'message' :
				$this->lang_message		= $this->lang->line("message");
				break;
			default :
				$this->lang_menu 		= $this->lang->line("menu");
				$this->lang_bbs			= $this->lang->line("bbs");
				$this->lang_message		= $this->lang->line("message");
				break;
		}
	}
}
?>
