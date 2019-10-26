<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Main extends MY_Controller 
{
	public function __construct() 
	{
		parent::__construct();
	}
	public function index()
	{
		$this->load->helper('form');
		$this->load->model('board_model');
		$this->load->helper('cookie');
		$data = $this->set_home_base(__CLASS__, __FUNCTION__);
		$data['is_main']         		= true;
		// 설명회
		$p_result_use = $this->register_model->get_presentation_day('', '', '', '', false, '', 'yes', 'ASC', 'over', '', 'presentation');
		if ($p_result_use) {
			for($i=0; $i<count($p_result_use); $i++){
				$p_result_use[$i]->user_list = $this->register_model->get_presentaation_onlyuser($p_result_use[$i]->p_id);
			}
		}
		// 메인 팝업창
		/*
        $data['main_begine_eventpop']	= (!$data['is_mobile'] && $data['home_popup'] && !get_cookie('eventpop'))?true:false;
		if ($data['main_begine_eventpop']){
			$data['include_html']		= array($this->load->view('include/event_popup', $data, true));
		}
		*/
		$this->lang->load('main', $this->homelanguage->lang_seting($this->umv_lang));
		$data['lang_mainjs']			= $this->lang->line("mainjs");
		$data['lang_main_contents']		= $this->lang->line("contents");
		$data['lang_presentation']		= $this->lang->line("presentation");
		$data['presentation']			= $p_result_use;
		$data['news_new_list']   		= $this->board_model->get_board_newlist('news', 6);
		//$custom_js1						= "<script src='".site_url()."node_modules/slick-carousel/slick/slick.min.js'></script>";
		$custom_js1						= "<script src='".HOME_JS_PATH."/slick.js'></script>";
		$custom_js2 			 		= "<script src='".HOME_JS_PATH."/main.js".set_last_modified_mtime(HOME_JS_PATH.'/main.js')."'></script>";
		$data['javascript_arr']  		= array($custom_js1, $custom_js2);
		$data['css_arr']				= array(
			'<link rel="stylesheet" href="'.site_url().'node_modules/slick-carousel/slick/slick.css" />',
			'<link rel="stylesheet" href="'.site_url().'assets/css/main.css'.set_last_modified_mtime('/assets/css/main.css').'" />'
		);
		// 메인 슬라이더 인크루드
		$data['main_js']		 		= $this->load->view('include/mainJS_slickjs', $data, true);
		// rss 뉴스로 일단 노출
		$data['home_rss'] 				= site_url().'rss/mainrss';//site_url().'feed/news/rss';
		$this->load->view('include/header', $data);
		$this->load->view('main', $data);
		$this->load->view('include/footer', $data);
	}
	// 24시간 또는 오늘하루만 쿠키 설정
	public function setTodayCookie()
	{
		if ($this->input->post() && preg_match("/".$_SERVER['HTTP_HOST']."/", $this->agent->referrer())) {
			$this->load->helper('cookie');
			$this->load->library('form_validation');
			$this->form_validation->set_rules('cookie_name', '', 'required');
			$this->form_validation->set_rules('day_type', '', 'required');
			if ($this->form_validation->run() == false) {
				show_404();
			} else {
				$cookie_name = $this->security->xss_clean(clean_xss_tags($this->input->post('cookie_name')));
				if ($this->input->post('day_type')==='full') {
					$time_limit = 86400;
				} else {

					$time = date('H', time());
					$time_limit = 24 - $time;
					$time_limit = 60 * 60 * $time_limit;
				}
				set_cookie($cookie_name, date('Y-m-d H:i:s',time()), $time_limit);
				echo "{ \"home_token\": ";
				echo json_encode($this->security->get_csrf_hash())."\n";
				echo "}";
			}
		} else {
			show_404();
		}
	}
	// 사이트맵
	public function sitemap()
	{
		$data = $this->set_home_base(__CLASS__, __FUNCTION__, 'subheader-infopage');
		$data['page_1depth_name'] 	= 'Site Map';
		$this->load->view('include/header' ,$data);
		$this->load->view('sitemap', $data);
		$this->load->view('include/footer', $data);
	}
	// 브로셔 외부 다운로드시 리다이렉션 페이지
	public function brochure()
	{
		$data = $this->set_home_base(__CLASS__, __FUNCTION__, 'subheader-infopage');
		$data['page_1depth_name'] 	= '브로슈어 다운로드';
		$this->load->view('include/header' ,$data);
		$this->load->view('brochure', $data);
		$this->load->view('include/footer', $data);
	}
	// 지도 iframe
	public function map()
	{
		$data = $this->set_home_base(__CLASS__, __FUNCTION__, 'subheader-infopage');
		$this->load->view('include/googlemap', $data);
	}
	public function privacy_policy()
	{
		$data = $this->set_home_base(__CLASS__, __FUNCTION__, 'subheader-infopage');
		$data['page_1depth_name'] 	= 'Privacy Policy';
		$data['agreement']			= $this->register_model->get_home_agreement($this->umv_lang);
		$this->load->view('include/header' ,$data);
		$this->load->view('privacy_policy', $data);
		$this->load->view('include/footer', $data);
	}
	public function comingsoon() 
	{
		$this->load->view('comingsoon');
	}
	public function umvtestpage()
	{
		show_404();
		exit;
		$this->load->helper('form');
		$this->load->model('board_model');
		$this->load->helper('cookie');
		$data = $this->set_home_base(__CLASS__, __FUNCTION__);
		$data['is_main']         		= true;
		// 메인 팝업창
        $data['main_begine_eventpop']	= (!$data['is_mobile'] && ($data['home_popup'] || (isset($data['early_display']) && $data['early_display']['season']>0)) && !get_cookie('eventpop'))?true:false;
		if ($data['main_begine_eventpop']) {
			$data['include_html']		= array($this->load->view('include/event_popup', $data, true));
		}
		$this->lang->load('main', $this->homelanguage->lang_seting($this->umv_lang));
		$data['lang_mainjs']			= $this->lang->line("mainjs");
		$data['lang_main_contents']		= $this->lang->line("contents");
		$data['lang_presentation']		= $this->lang->line("presentation");
		$data['presentation']			= $this->register_model->get_presentation_day('', '', '', '', false, '', 'yes', 'ASC', 'over');
		$data['news_new_list']   		= $this->board_model->get_board_newlist('news', 6);
		//$custom_js1						= "<script src='".site_url()."node_modules/slick-carousel/slick/slick.min.js'></script>";
		$custom_js1						= "<script src='".HOME_JS_PATH."/slick.js'></script>";
		$custom_js2 			 		= "<script src='".HOME_JS_PATH."/main_test.js".set_last_modified_mtime(HOME_JS_PATH.'/main_test.js')."'></script>";
		$data['javascript_arr']  		= array($custom_js1, $custom_js2);
		$data['css_arr']				= array('<link rel="stylesheet" href="'.site_url().'node_modules/slick-carousel/slick/slick.css" />');
		// 메인 슬라이더 인크루드
		$data['main_js']		 		= $this->load->view('include/mainJS_slickjs', $data, true);
		// rss 뉴스로 일단 노출
		printr_show_developer($data['mp_nav']);
				exit;
		$data['home_rss'] 				= site_url().'rss/mainrss';//site_url().'feed/news/rss';
		$this->load->view('include/header' ,$data);
		$this->load->view('umvtestpage', $data);
		$this->load->view('include/footer', $data);
	}
}
