<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Presentation_register extends MY_Controller{
	private $CI;
	private $redirect_url;
	public function __construct(){
		$this->CI = & get_instance();
		$this->redirect_url = site_url();
		$this->CI->load->model('register_model');
		$this->plang_message= $this->CI->lang->line("message");
	}
	private function set_sess_flashdata($post){
		if(isset($post['u_name'])) $this->CI->session->set_flashdata('u_name', $post['u_name']);
		if(isset($post['u_name_en'])) $this->CI->session->set_flashdata('u_name_en', $post['u_name_en']);
		if(isset($post['u_phone'])) $this->CI->session->set_flashdata('u_phone', $post['u_phone']);
		if(isset($post['u_city'])) $this->CI->session->set_flashdata('u_city', $post['u_city']);
		if(isset($post['u_state'])) $this->CI->session->set_flashdata('u_state', $post['u_state']);
		if(isset($post['u_email'])) $this->CI->session->set_flashdata('u_email', $post['u_email']);
		if(isset($post['u_aca'])) $this->CI->session->set_flashdata('u_aca', $post['u_aca']);
		if(isset($post['sname'])) $this->CI->session->set_flashdata('sname', $post['sname']);
		if(isset($post['p_id'])) $this->CI->session->set_flashdata('p_id',$post['p_id']);
	}
	public function set_redirect_url($link=''){
		if(!empty($link)){
			$this->redirect_url = $link;
		}
	}
	public function check_awaiter_set($p_id=null){
		if(!is_numeric($p_id)) return false;
		$awaiter = $this->CI->register_model->get_presentation_single($p_id, 'p_day, p_awaiter, p_entry');
		$user_list = $this->CI->register_model->get_presentation_user_total($p_id);
		if($awaiter->p_entry - $user_list <= 0 && $awaiter->p_awaiter == 'no'){
			$this->CI->session->set_flashdata('message', $awaiter->p_day.'\n해당 설명회 일정은 남은 잔여석이 없어서 예약을 하실 수 없습니다.\n다른 일정을 선택해 주세요. 고객센터 02-564-2510');
			return false;
		}else{
			return true;
		}
	}
	public function register($post){
		$this->CI->load->helper('cookie');
		$this->CI->load->library('form_validation');

		$this->CI->form_validation->set_rules('u_name', '이름', 'required');
		$this->CI->form_validation->set_rules('u_name_en', '영문 이름', 'required');
		$this->CI->form_validation->set_rules('u_city', 'u_city', 'required');
		$this->CI->form_validation->set_rules('u_state', 'u_state', 'required');
		$this->CI->form_validation->set_rules('u_phone', 'u_phone', 'required');
		$this->CI->form_validation->set_rules('u_email', 'email', 'required|valid_email');
		$this->CI->form_validation->set_rules('u_aca', 'u_aca', 'required');
		$this->CI->form_validation->set_rules('sname', 'sname', 'required');
		$this->CI->form_validation->set_rules('p_id', 'Info-sessions date', 'required|numeric');

		if($this->CI->form_validation->run() == FALSE){
			$this->CI->session->set_flashdata('message', fnc_replace_str_foralert(stripslashes($this->plang_message['required_error_msg'])));
			$this->set_sess_flashdata($post);
			redirect($this->redirect_url);
		}else{
			if(!get_cookie('break_write_p')){
				if(!get_cookie('check_cnt_p')){
					set_cookie('check_cnt_p', 1, 60);
				}else{
					$cnt = (int)get_cookie('check_cnt_p');
					$cnt++;
					if($cnt > 4){
						set_cookie('break_write_p', date('Y-m-d H:i:s',time()), 14400);
					}else{
						set_cookie('check_cnt_p', $cnt, 60);
					}
				}
				//$this->CI->load->model('register_model');
				$result = $this->CI->register_model->presentation_user_register($post);
				if($result){
					$this->send_mail($post);
				}else{
					$this->CI->session->set_flashdata('message', '예약 등록을 실패했습니다. 다시 시도해 주세요.');
					$this->set_sess_flashdata($post);
					redirect($this->redirect_url);
				}
			}else{
				$this->CI->load->model('logrecord_model');
				$this->CI->logrecord_model->set_logrecord('write_p');
				$start_date = date("Y-m-d H:i:s", strtotime(get_cookie('break_write_p')."+4 hours"));
				$this->CI->session->set_flashdata('message', '비정상적인 작성으로 인해 관리자에 의해 차단되었습니다. '.$start_date.'시 이후 부터 다시 사용 가능합니다.');
				redirect(site_url());
			}
			/*
			$result = $this->CI->register_model->presentation_user_register($post);
			if($result){
				$this->send_mail($post);
			}else{
				$this->CI->session->set_flashdata('message', fnc_replace_str_foralert(stripslashes($this->plang_message['try_again_msg'])));
				$this->set_sess_flashdata($post);
				redirect($this->redirect_url);
			}
			*/
		}
	}
	protected function send_mail($post){
		$this->CI->load->library('email');
		$info_mail 		= self::HOME_INFO_MAIL;
		//$info_mail2 	= self::HOME_INFO_MAIL2;

		//$info_mail = 'u5ink@naver.com';
		$p_info 		= $this->CI->register_model->get_presentation_single($post['p_id']);
		$p_name			= fnc_set_htmls_strip($p_info->p_name);
		$p_day 			= ($p_info->p_day)?fnc_replace_getday(explode(" ", $p_info->p_day)[0]):'';
		$p_time 		= ($p_info->p_day)?fnc_replace_gettime(explode(" ", $p_info->p_day)[1]):'';
		$p_location		= fnc_set_htmls_strip($p_info->p_location);
		$p_place		= fnc_set_htmls_strip($p_info->p_place);
		// 유저 정보
		$u_name 		= strip_tags($post['u_name']);
		$u_name_en 		= strip_tags($post['u_name_en']);
		$u_phone		= strip_tags($post['u_phone']);
		$u_city			= strip_tags($post['u_city']);
		$u_state		= strip_tags($post['u_state']);
		$u_email		= strip_tags($post['u_email']);
		$u_aca			= strip_tags($post['u_aca']);
		$sname     		= strip_tags($post['sname']);
		//$ptypetxt = ($post['p_reserve'] === 'presentation')?' 설명회 예약':' 방문상담 예약';
		$ptypetxt = ' 설명회 예약';
		$this->CI->email->initialize(array('charset'=>'utf-8', 'wordwrap'=>true, 'mailtype'=>'html'));
		$this->CI->email->from($u_email, $u_name);
		$this->CI->email->to(array(
			$info_mail
			//$info_mail2
		));
		$this->CI->email->subject('['.HOME_INFO_NAME.']'.$u_name.'님의  '.$p_day.' '.$p_time.$ptypetxt);
		$html_content = "<h1>".$u_name."님의 ". HOME_INFO_NAME.$ptypetxt."</h1>";
		$html_content .= "<dl style='width:100%; border:1px solid #ccc'>";
		$html_content .= "<dt style='margin:0; padding:10px 2%; border-bottom:1px solid #ccc; background:#f9f9f9; font-weight:bold'>".$ptypetxt."</dt>
			<dd style='margin:0; padding:10px 3%; border-bottom:1px solid #ccc'>[".$p_location."] ".$p_day." ".$p_time." - ".$p_place."</dd>
			<dt style='margin:0; padding:10px 2%; border-bottom:1px solid #ccc; background:#f9f9f9; font-weight:bold'>이름</dt>
			<dd style='margin:0; padding:10px 3%; border-bottom:1px solid #ccc'>".$u_name." ".$u_name_en."</dd>
			<dt style='margin:0; padding:10px 2%; border-bottom:1px solid #ccc; background:#f9f9f9; font-weight:bold'>연락처</dt>
			<dd style='margin:0; padding:10px 3%; border-bottom:1px solid #ccc'>".$u_phone."</dd>
			<dt style='margin:0; padding:10px 2%; border-bottom:1px solid #ccc; background:#f9f9f9; font-weight:bold'>이메일</dt>
			<dd style='margin:0; padding:10px 3%; border-bottom:1px solid #ccc'>".$u_email."</dd>
			<dt style='margin:0; padding:10px 2%; border-bottom:1px solid #ccc; background:#f9f9f9; font-weight:bold'>학생 거주지</dt>
			<dd style='margin:0; padding:10px 3%; border-bottom:1px solid #ccc'>".$u_city."</dd>
			<dt style='margin:0; padding:10px 2%; border-bottom:1px solid #ccc; background:#f9f9f9; font-weight:bold'>학생 거주국가</dt>
			<dd style='margin:0; padding:10px 3%; border-bottom:1px solid #ccc'>".$u_state."</dd>
			<dt style='margin:0; padding:10px 2%; border-bottom:1px solid #ccc; background:#f9f9f9; font-weight:bold'>학생 학력</dt>
			<dd style='margin:0; padding:10px 3%; border-bottom:1px solid #ccc'>".$u_aca."</dd>
			<dt style='margin:0; padding:10px 2%; border-bottom:1px solid #ccc; background:#f9f9f9; font-weight:bold'>학교이름</dt>
			<dd style='margin:0; padding:10px 3%; border-bottom:1px solid #ccc'>".$sname."</dd>";
		$html_content .= "</dl>";
		$this->CI->email->message($html_content);
		if($this->CI->email->send()){
		    $this->CI->session->set_flashdata('message', $p_day.' '.$p_time.' '.'['.$p_location.'] '.$p_place.'\n'.fnc_replace_str_foralert(stripslashes($this->plang_message['applied_msg'])));
			if($this->CI->session->userdata('user_id') && ($this->CI->session->userdata('user_level') >=2 && $this->CI->session->userdata('user_level')<7)){
				redirect(site_url().'mypage');
			}else{
				redirect($this->redirect_url);
			}
		}else{
			$this->CI->session->set_flashdata('message', fnc_replace_str_foralert(stripslashes($this->plang_message['try_again_msg'])));
			redirect($this->redirect_url);
		}
	}
}
?>
