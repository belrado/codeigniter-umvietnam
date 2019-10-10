<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Community extends MY_Controller {
	public function __construct() {
		parent::__construct();
		$this->load->helper('form');
		$this->load->library('form_validation');
		$this->load->library('captcha');
	}
	public function _remap($method, $params = array()){
		if (method_exists($this, $method)){
			return call_user_func_array(array($this, $method), $params);
		}else{
			$data = $this->set_home_base(strtolower(__CLASS__), strtolower($method), 'subheader-'.strtolower(__CLASS__));
			$this->load->view('include/header' ,$data);
			$this->_page(strtolower(__CLASS__).'/'.strtolower($method), $data);
			$this->load->view('include/footer', $data);
		}
	}
	public function index(){
		redirect(site_url().$this->homelanguage->get_lang().'/board/list/news');
	}
	public function info_sessions(){
		$this->load->model('register_model');
		if($this->input->post('more_end_presentation')){
			// 종료된 설명회 가져오기 ajax
			$endyear = $this->input->post('more_end_presentation');
			$p_result_end = $this->register_model->get_presentation_day('', '', '', '', false, '', 'all', 'DESC', 'under', $endyear);
			$arr = array();
			if($p_result_end){
				for($i=0; $i< count($p_result_end); $i++){
					$arr[$i] = array(
						'p_info'		=>fnc_replace_getday(explode(" ",  $p_result_end[$i]->p_day)[0])." 설명회 - [".fnc_set_htmls_strip($p_result_end[$i]->p_location)."]".fnc_set_htmls_strip($p_result_end[$i]->p_place)
					);
					$user_result = $this->register_model->get_presentaation_onlyuser($p_result_end[$i]->p_id);
					if($user_result){
						for($j=0; $j<count($user_result); $j++){
							$arr[$i]['user_list'][$j] = array(
								'u_info'	=> fnc_name_change(fnc_set_htmls_strip($user_result[$j]->u_name))." ".fnc_set_htmls_strip(fnc_phone_change($user_result[$j]->u_phone))
							);
						}
					}
				}
			}
			$result_arr = json_encode($arr);
			echo "{ \"presentation_end_list\": ";
			echo $result_arr.",\n";
			echo "\"bbs_token\": ";
			echo json_encode($this->security->get_csrf_hash())."\n";
			echo "}";
			exit;
		}else{
			// 설명회 예약
			$nowyear = date('Y', time());
			$endyear = ($this->input->get('endyear'))?$this->security->xss_clean($this->input->get('endyear')):$nowyear;
			$data = $this->set_home_base(__CLASS__, __FUNCTION__, 'subheader-'.strtolower(__CLASS__));
			$data['home_rss']			= site_url().'syndi/mainrss/'.$data['rss_catenum'];
			$data['main_pchk_day']		= ($this->input->get('pchk'))?$this->input->get('pchk'):'';
			$data['user_info'] 			= '';
			$data['endyear']			= $endyear;
			$data['lang_presentation']	= $this->lang->line("presentation");
			$data['agreement']			= $this->register_model->get_home_agreement($this->umv_lang);
			$data['active'] =__FUNCTION__;
			if($this->session->userdata('user_id')){
				$this->load->model('member_model');
				$data['user_info'] = $this->member_model->get_member_select($this->encryption->decrypt($this->session->userdata('user_id')), 'user_email, user_name, user_phone, user_grade');
			}
			$p_result_use = $this->register_model->get_presentation_day('', '', '', '', false, '', 'yes', 'ASC', 'over', '', 'presentation');
			$p_result_end = $this->register_model->get_presentation_day('', '', '', '', false, '', 'all', 'DESC', 'under', $endyear, 'presentation');
			// 메인 설명회에서 넘어온 값이 현재 설명회 일정과 맞는지 체크
			$main_pchk_check = false;
			if($p_result_use){
				for($i=0; $i<count($p_result_use); $i++){
					if(is_numeric($data['main_pchk_day'])){
						if($data['main_pchk_day'] === $p_result_use[$i]->p_id){
							$main_pchk_check = true;
						}
					}
					$p_result_use[$i]->user_list = $this->register_model->get_presentaation_onlyuser($p_result_use[$i]->p_id);
				}
			}
			if(is_numeric($data['main_pchk_day']) && !$main_pchk_check){
				redirect(site_url().'support/presentation');
			}
			if($p_result_end){
				for($i=0; $i<count($p_result_end); $i++){
					$p_result_end[$i]->user_list = $this->register_model->get_presentaation_onlyuser($p_result_end[$i]->p_id);
				}
			}
			/* 가라대이터 입력
			$dummy = new stdClass;
			$dummy->u_name='이상윤1';
			$dummy->u_phone='010-4443-8874';
			$dummy2 = new stdClass;
			$dummy2->u_name='이상윤2';
			$dummy2->u_phone='010-4443-8874';
			$dummy3 = new stdClass;
			array_push($p_result_use[0]->user_list, $dummy, $dummy2);
			*/
			$data['p_result_use'] = $p_result_use;
			$data['p_result_end'] = $p_result_end;
			$data['page_title']	  = '설명회 예약';
			// js 삽입
			$custom_js1 			 		= "<script src='".HOME_JS_PATH."/BD_form_validation.js'></script>";
			$data['javascript_arr']  		= array($custom_js1);
			$this->load->view('include/header', $data);
			$this->_page('community/info_sessions', $data);
			$this->load->view('include/footer');
		}
	}
	public function info_sessions_update(){
		if(isset($_SERVER['HTTP_REFERER']) && preg_match ("/".$_SERVER['HTTP_HOST']."/", $_SERVER['HTTP_REFERER']) && $this->input->post()){
			$this->load->model('register_model');
			$check = array(); //$this->register_model->check_presentation_dayuser(null, $this->input->post('p_id'), $this->input->post('u_email'), $this->input->post('u_phone'));
			if(count($check) > 0){
				$this->session->set_flashdata('message', '선택하신 설명회 일정에 같은 이메일  또는 전화번호로 등록이 되어있습니다. 확인 후 다시 시도해 주세요.\n문의전화  : 02-564-2510');
				$this->session->set_flashdata('u_name',$this->input->post('u_name'));
				$this->session->set_flashdata('u_phone',$this->input->post('u_phone'));
				//$this->session->set_flashdata('u_email',$this->input->post('u_email'));
				$this->session->set_flashdata('u_aca',$this->input->post('u_aca'));
				//$this->session->set_flashdata('u_relation',$this->input->post('u_relation'));
				//$this->session->set_flashdata('u_attendance',$this->input->post('u_attendance'));
				//$this->session->set_flashdata('u_search',$this->input->post('u_search'));
				$this->session->set_flashdata('p_id',$this->input->post('p_id'));
				redirect(site_url().$this->umv_lang.'/community/info_sessions');
			}else{
				$this->load->library('presentation_register');
				$this->presentation_register->set_redirect_url(site_url().$this->umv_lang.'/community/info_sessions/');
				$this->presentation_register->register($this->input->post(NULL, TRUE));
			}
		}else{
			show_404();
		}
	}
}
?>
