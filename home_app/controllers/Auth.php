<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Auth extends MY_Controller{
	public function __construct(){
		parent::__construct();
		$this->load->library('captcha');
		$this->load->helper('form');
		$this->load->model('member_model');
		$this->load->model('login_model');
		$this->load->library('log_security_block');
		$this->load->library('form_validation');
		$this->lang->load('log', $this->homelanguage->lang_seting($this->umv_lang));
		$this->lang_log = $this->lang->line("log");
	}
	// 디폴트페이지
	public function index(){
		if(!empty($this->session->userdata('user_type')) || $this->session->userdata('user_id')){
			goto_url(site_url());
		}
		$this->login();
	}
	public function login(){
		//$lang = ($this->input->post('umv_lang'))?$this->input->post('umv_lang'):$this->umv_lang;
		$this->form_validation->set_rules('userid', 'ID', 'required');
		$this->form_validation->set_rules('password', 'Password', 'required');
		$return_main_keyword = array('auth', 'homeAdm');
		$returnURL = ($this->input->get('returnURL'))?$this->input->get('returnURL'):'';
		for($i=0; $i<count($return_main_keyword); $i++){
			if(preg_match("/".$return_main_keyword[$i]."/", $this->input->get('returnURL'))){
				$returnURL = '';
			}
		}
		//preg_match ("/".$_SERVER['HTTP_HOST']."/", $_SERVER['HTTP_REFERER']);
		$data = $this->set_home_base(__CLASS__, __FUNCTION__, 'subheader-supportpage');
		$data['page_1depth_name'] 	= 'UMV '.ucwords($data['lang_menu']['login']);
		$data['page_2depth_name'] 	= 'UMV Membership';//$data['lang_bbs']['user'].' '.$data['lang_menu']['login'];
		$data['returnURL']			= $returnURL;
		$custom_js1 = "<script src='".HOME_JS_PATH."/BD_form_validation.js'></script>";
		$data['javascript_arr'] = array($custom_js1);
		if($this->form_validation->run() == FALSE){
			$data['mp_token'] = get_token();
			$data['facebook']	= "815624092155867";
			$data['redirect']	= urlencode(site_url().'auth/facebook/');
			$data['token'] 		= $this->security->get_csrf_hash();

			$this->load->view('include/header', $data);
			$this->load->view('auth/login', $data);
			$this->load->view('include/footer', $data);

		}else{
			$userid   = $this->security->xss_clean($this->input->post('userid'));
			if(!$this->log_security_block->check_block_ip() && !$this->log_security_block->check_block_id($userid)){
				if(!check_token($this->input->post('mp_token'))){
					$this->session->sess_destroy();
					redirect(site_url().$this->umv_lang);
				}
				$userpwd  = $this->input->post('password');
				$user_record = $this->check_login($userid, $userpwd);
				if($user_record){
					// 접근금지 아이디라면
					if(isset($user_record->block_id)){
						if($user_record->block_id){
							$this->session->set_flashdata('message', '부적절한 로그인 시도 또는\n지정된 횟수를 넘는 아이디와 비밀번호 오류로 인해 접속이 차단되었습니다.\n\n정상적인 사용을 위해선 고객센터로 문의해 주세요.\n02) 564-2510');
							redirect(site_url().$this->umv_lang);
						}
					}
					if($user_record->error){
						// 메일 인증이 완료되지 않은 회원이라면
						$nowtime = date("Y-m-d H:i:s", time());
						$lasttime = get_confirmation_mail_time($user_record->user_register);
						if($nowtime > $lasttime){
							$message = '회원가입 이메일 인증 기간이 지났습니다.\n회원가입 시 입력한 정보는 삭제되었으니,\n다시 회원가입 절차를  진행해 주시기 바랍니다.';
							$this->member_model->delete_member($user_record->user_id);
						}else{
							$message = stripslashes($this->lang_log['certification_24_hours2']).'\n['.$user_record->user_register.']\n~ ['.date('Y-m-d H:i:s', strtotime("+1 days", strtotime($user_record->user_register))).']';
						}
						$this->session->set_flashdata('message', $message);
						redirect(site_url().$this->umv_lang.'/auth/');
					}else{
						// 메일 인증이 완료된 회원이라면 로그인 시킨다.
						// 관리자라면 지정된 아이피만 로그인
						if($user_record->user_level >= 7){
							if(!check_admin_ipaddress()){
								//$this->session->sess_destroy();
								//redirect(site_url());
							}
						}
						// 기본 세션 부여
						$this->set_login_session($user_record);
						if($user_record->staff_type === 'mp_staff' || $user_record->staff_type ==="mp_superMaster"){
							// 직원이라면
							$this->session->set_userdata('staff_type', $this->encryption->encrypt($user_record->staff_type));
							$this->session->set_userdata('staff_lv', $user_record->staff_lv);
						}
						if($user_record->staff_type === 'mp_staff'){
							// 직원이라면 company
							redirect(site_url()."homeAdm");
						}else if($user_record->user_type ==="mp_superMaster" || $user_record->user_type ==="mp_master"){
							// 최고관리자 또는 홈페이지관리자라면
							redirect(site_url()."homeAdm");
						}else if($user_record->user_type==="mp_user"){
							redirect(site_url().$returnURL);
						}else{
							$this->session->sess_destroy();
							redirect(site_url().$this->umv_lang);
						}
					}
				}else{
					$this->load->model('logrecord_model');
					$this->logrecord_model->set_logrecord('login', $this->input->post(NULL, TRUE));
					// 차단 쿠키 실행 쿠기시간, 누적오류
					$this->log_security_block->add_block_ip(6, 3);
					$this->session->set_flashdata('message', '아이디 또는 비밀번호가 올바르지 않습니다.');
					redirect(site_url().$this->umv_lang.'/auth');
				}
			}else{
				$this->session->set_flashdata('message', '부적절한 로그인 시도 또는\n지정된 횟수를 넘는 아이디와 비밀번호 오류로 인해 접속이 차단되었습니다.\n\n정상적인 사용을 위해선 고객센터로 문의해 주세요.\n02) 564-2510');
				redirect(site_url().$this->umv_lang);
			}
		}
	}
	public function logout(){
		$this->session->sess_destroy();
		redirect(site_url().$this->umv_lang);
	}
	/* 회원가입 */
	public function joinus(){
		if($this->session->userdata('user_id')){
			redirect(site_url().$this->umv_lang);
		}
		if(!$this->input->post('user_id') && $this->session->userdata('join_type') && $this->session->userdata('join_type') === 'sns'){
			if(!$this->session->flashdata('sns_type')){
				$this->session->sess_destroy();
				redirect(site_url().$this->umv_lang.'/auth');
			}
		}
		$this->load->database();
		$this->form_validation->set_rules('user_id', 'Email(ID)', 'required|valid_email|is_unique[psu_user.user_email]');
		$this->form_validation->set_rules('user_name', 'Name', 'required');
		$this->form_validation->set_rules('user_sns_type', 'SNS', 'required');
		$this->form_validation->set_rules('agreement', 'Privacy Policy', 'required');
		if($this->input->post('user_sns_type') !== 'home' && $this->input->post('user_sns_id')){
			$sns_type 	= $this->input->post('user_sns_type');
			$sns_id 	= $this->input->post('user_sns_id');
			$sns_name	= $this->input->post('sns_name');
			$sns_email	= $this->input->post('sns_email');
			$sns_token	= $this->input->post('user_sns_token');
			$this->form_validation->set_rules('user_sns_token', 'sns Token', 'required');
			$this->form_validation->set_rules('user_sns_id', 'sns ID', 'required');
		}else{
			$this->form_validation->set_rules('user_pwd', 'Password', 'required|min_length[8]|max_length[18]');
			$this->form_validation->set_rules('user_pwdc', 'Password confirm', 'required|min_length[8]|max_length[18]|matches[user_pwd]');
			$this->form_validation->set_rules('captcha', 'Captcha', array(
				'required',
				array($this->captcha, 'check_validate_captcha')
			));
		}
		if($this->form_validation->run() == FALSE){
			$this->load->model('register_model');
			$data = $this->set_home_base(__CLASS__, __FUNCTION__, 'subheader-supportpage');
			$data['page_1depth_name'] 	= 'JOIN US';
			$data['page_2depth_name'] 	= $data['lang_bbs']['user_information'];
			$data['agreement']			= $this->register_model->get_home_agreement($this->umv_lang);
			$custom_js1 = "<script src='".HOME_JS_PATH."/BD_form_validation.js'></script>";
			$data['javascript_arr'] = array($custom_js1);
			$data['lang_log']			=  $this->lang_log;
			if((isset($sns_id) && isset($sns_token))||(($this->session->flashdata('sns_id') && $this->session->flashdata('sns_token')))){
				// sns (네이버, 카카오, 페이스북 등으로 ) 회원 가입
				$data['sns_type'] 	= ($this->session->flashdata('sns_type'))?$this->session->flashdata('sns_type'):((isset($sns_type))?$sns_type:'');
				$data['sns_id']		= ($this->session->flashdata('sns_id'))?$this->session->flashdata('sns_id'):((isset($sns_id))?$sns_id:'');
				$data['sns_name']	= ($this->session->flashdata('sns_name'))?$this->session->flashdata('sns_name'):((isset($sns_name))?$sns_name:'');
				$data['sns_email']	= ($this->session->flashdata('sns_email'))?$this->session->flashdata('sns_email'):((isset($sns_email))?$sns_email:'');
				$data['sns_token']	= ($this->session->flashdata('sns_token'))?$this->session->flashdata('sns_token'):((isset($sns_token))?$sns_token:'');
				$this->load->view('include/header', $data);
				$this->load->view('auth/sns_joinus', $data);
			}else{
				// 홈페이지로 회원 가입
				$data['captcha'] = $this->captcha->set_captcha_file(array('img_width'=>200));
				$this->load->view('include/header', $data);
				$this->load->view('auth/joinus', $data);
			}
			$this->load->view('include/footer', $data);

		}else{
			$result = $this->login_model->member_joinus($this->input->post(NULL, TRUE));
			if($result['error']){
				$this->session->set_flashdata('message', $result['message']);
				if($result['user_sns']){
					redirect(site_url().$this->umv_lang.'/auth/');
				}else{
					redirect(site_url().$this->umv_lang.'/auth/joinus');
				}
			}else{
				if($result['user_sns']){
					// sns 회원가입은 바로 세션부여하고 로그인 (메인페이지 /마이페이지 로)
					if($result['user_info']){
						// 카카오톡로그인이면 카카오앱에 사용자 정보 추가 저장
						if($result['user_info']->user_sns_type === 'kakao'){
							$this->load->library('kakaoapi');
							$user_data = array(
								'name'	=> $result['user_info']->user_name,
								'phone'	=> $result['user_info']->user_phone
							);
							$this->kakaoapi->kakao_update($result['user_info']->user_sns_token, $user_data);
						}
						// 기본 세션 부여 회원가입 페이지 만들어야함
						$this->set_login_session($result['user_info']);
						$this->session->set_userdata('user_sns_token', $result['user_info']->user_sns_token);
						//redirect(site_url());
						$this->session->set_flashdata('complete_signup', 'sns');
						$this->session->set_flashdata('complete_userid', $this->encryption->encrypt($result['user_info']->user_id));
						redirect(site_url().$this->umv_lang.'/auth/success');
					}else{
						$this->session->set_flashdata('message', '회원정보를 불러오는 데 실패했습니다. 다시 시도해 주세요.');
						redirect(site_url().$this->umv_lang.'/auth/');
					}
				}else{
					$new_user = $this->security->xss_clean($this->input->post('user_id'));
					$this->session->set_flashdata('complete_signup', 'home');
					$this->session->set_flashdata('complete_userid', $this->encryption->encrypt($new_user));
					redirect(site_url().$this->umv_lang.'/auth/success');
				}
			}
		}
	}
	public function success(){
		if(!$this->session->flashdata('complete_signup')|| !$this->session->flashdata('complete_userid')){
			redirect(site_url().$this->umv_lang);
		}
		$new_user = $this->encryption->decrypt($this->session->flashdata('complete_userid'));
		$this->load->model('member_model');
		$user_info = $this->member_model->get_member_select($new_user, 'user_email, user_name');
		if(!$user_info) redirect(site_url().$this->umv_lang);
		$data = $this->set_home_base(__CLASS__, __FUNCTION__, 'subheader-supportpage');
		$data['lang_log']			=  $this->lang_log;
		$data['page_1depth_name'] 	= 'JOIN US';
		$data['page_2depth_name']	= stripslashes($data['lang_log']['signup_completed']);
		$data['user_info']			= $user_info;
		$this->load->view('include/header', $data);
		$this->load->view('auth/'.$this->session->flashdata('complete_signup').'_complete', $data);
		$this->load->view('include/footer', $data);
	}
	/* 회원 메일 인증 */
	public function verification($user_no=''){
		$key = $this->security->xss_clean($this->input->get('key'));
		if(!is_numeric($user_no) || empty($key) || $this->session->userdata('user_id')){
			redirect(site_url().$this->umv_lang);
		}else{
			$result = $this->member_model->get_member($user_no);
			if($result){
				if($result[0]->mail_approve === 'no' && $key ===$result[0]->mail_key){
					// 인증기간 확인 인증기간이 넘었다면 에러처리하고 회원삭제 다시 가입 유도
					$nowtime  = date('Y-m-d H:i:s', time());
					$lasttime = get_confirmation_mail_time($result[0]->user_register);
					if($nowtime > $lasttime){
						$this->session->set_flashdata('message', stripslashes($this->lang_log['email_verification_day_over']));
						$this->member_model->delete_member($result[0]->user_id);
						redirect(site_url().$this->umv_lang.'/auth');
					}else{
						if($this->member_model->set_mail_verification($user_no)){
							$this->session->set_flashdata('message', stripslashes($this->lang_log['email_verification_done']));
							redirect(site_url().$this->umv_lang.'/auth');
						}else{
							$this->session->set_flashdata('message', stripslashes($this->lang_log['email_verification_error']));
							redirect(site_url().$this->umv_lang);
						}
					}
				}else{
					redirect(site_url().$this->umv_lang);
				}
			}else{
				redirect(site_url().$this->umv_lang);
			}
		}
	}
	/* 정보수정 일반회원 관리자는 관리자파일에*/
	public function modify($type=''){
		if(!$this->session->userdata('user_id') || !preg_match ("/".$_SERVER['HTTP_HOST']."/", $_SERVER['HTTP_REFERER'])){
			redirect(site_url());
		}else{
			$de_user_type = $this->encryption->decrypt($this->session->userdata('user_type'));
			$de_user_id   = $this->encryption->decrypt($this->session->userdata('user_id'));
			$userid   = $de_user_id;
			$userpwd  = $this->input->post('password');

			if(($type == 'adm' && $de_user_type === HOME_PREFIX.'superMaster') || ($type == 'adm' && $de_user_type === HOME_PREFIX.'master')){
				// 관리자라면
				check_admin_sess($de_user_type, $this->session->userdata('user_level'), $this->session->userdata('user_id'));
				if($de_user_type === HOME_PREFIX."superMaster"){
					$this->super_check = true;
				}
				if(isset($userpwd)){

				}else{
					$data = array(
						'title' => '관리자',
						'active'=>''
					);
					$this->load->view('adm/header', $data);
					$this->load->view('auth/confirm_password.php');
					$this->load->view('adm/footer');
				}

			}else if($type=='user' && $de_user_type === HOME_PREFIX.'user'){
				// 일반회원이라면
			}else{
				// 이도 저도 아닐시 세션파괴
				$this->session->sess_destroy();
				redirect(site_url());
			}
		}
	}
	public function confirm_pwd($type='user'){
		if(!$this->session->userdata('user_id') || !preg_match ("/".$_SERVER['HTTP_HOST']."/", $_SERVER['HTTP_REFERER'])){
			redirect(site_url().$this->umv_lang);
		}else{
			$data['title'] 	 = 'Password confirm';
			if($type ==='user'){
				$data['frmlink'] = '';
			}else if($type==='adm'){
				$data['frmlink'] = '/homeAdm/confirm';
			}else{
				redirect(site_url().$this->umv_lang);
			}
			//$cap = $this->set_captcha_image();
			//$data['captcha'] = $cap['image'];
			//$this->set_captcha_image_sesstion($cap);
			$data['captcha'] = $this->captcha->set_captcha_file();
			$this->load->view('auth/confirm_password.php', $data);
		}
	}
/*
 * 캡차파일 생성
 * 라이브러리 만들걸로 대체
	private function set_captcha_image($imgW='200', $imgH='34'){
		$this->load->helper('captcha');
		$vals = array(
	        'img_path'      => FCPATH.'captcha/',
	        'img_url'       => site_url().'/captcha/',
	        'font_path'     => './captcha/fonts/3.ttf',
	        'img_width'     => $imgW,
	        'img_height'    => $imgH,
	        'img_id'        => 'Imageid',
	        'pool'          => '0123456789abcdefghijklmnopqrstuvwxyz'
		);
		// 캡차 파일들 싸그리 삭제
		$directory = $vals['img_path'];
		$handle = opendir($directory); // 절대경로
		while ($file = readdir($handle)) {
		    $fileInfo = pathinfo($file);
			if(isset($fileInfo['extension'])){
				$fileExt = $fileInfo['extension'];
				if($fileExt == "jpg"){
					@unlink($directory.$file);
				}
			}
		}
		closedir($handle);
		return create_captcha($vals);
	}
	// 캡차파일 세션 만들기 & 자기가 만든 이미지 지우기
	private function set_captcha_image_sesstion($cap){
		$directory = FCPATH.'captcha/';
		if(isset($this->session->userdata['user_captchafile'])){
			if(file_exists($directory.$this->session->userdata['user_captchafile'])){
				@unlink($directory.$this->session->userdata['user_captchafile']);
			}
		}
		$this->session->set_userdata(array('user_captchaword'=>$cap['word'], 'user_captchafile'=>$cap['filename']));
	}
	// 캡차코드 맞는지 확인
	public function check_validate_captcha(){
	    if($this->input->post('captcha') != $this->session->userdata['user_captchaword']){
	        return false;
	    }else{
	        return true;
	    }
	}
 */
	// 아이디와 비번 맞는지 확인
	private function check_login($userid, $userpwd){
		$user_record = $this->login_model->check_login($userid, $userpwd);
		if($user_record){
			return $user_record;
		}else{
			return false;
		}
	}
	public function usernameen_check($str){
		//preg_match("/^([\sA-Za-z0-9+])*$/", $str)
		if(preg_match("/^([\sA-Za-z0-9+])*$/", $str)){
			return true;
		}else{
			$this->form_validation->set_message('usernameen_check', '아이디는 영문, 숫자 , 특수문자 (!@^_) 조합 8~16글자로 으로 만들어주세요.');
			return false;
		}
	}
		/*
	 * sns 회원가입 (네이버, 구글, 페이스북, 카카오톡)
	 *
	 * sns회원 가입시 아이디가 있는지 확인
	 * 아이디가 있다면 user_sns_id가 있는지도 확인
	 * 두개다 없다면 신규회원
	 *
	 * 로그인시 user_sns_id가 있는지 확인 있다면 에러 처리
	 * sns로 가입한 회원은 일반 로그인이 안되게 구현해야한다.
	 *
	 * */
	// 네아로 (네이버 제공 로그인) 로그인 .. 콜백받을곳
	public function facebook(){
		if($this->session->userdata('user_id')){
			redirect(site_url());
		}
		$sns_name = 'facebook';
		$this->load->library('facebookapi');
		$code = $this->input->get('code');
		$state = $this->input->get('state');
		$state_arr = explode(',', preg_replace('/\{|\}/', '', $state));
		$token 	= $state_arr[0];
		$lang 	= (isset($state_arr[1]))?$state_arr[1]:$this->umv_lang;
		$returnURL = (isset($state_arr[2]))?$state_arr[2]:$lang;

		if($token === $this->security->get_csrf_hash()){
			// 엑세스 토큰생성
			$facebook = $this->facebookapi->authorize($code, $token);
			if($facebook && isset($facebook->access_token)){
				// 엑세스토큰으로 회원 정보 가져옴
				$sns_user = $this->facebookapi->get_userinfo($facebook->access_token);
				if($sns_user){
					// Facebook id 가 회윈 db에 저장되어있는지 검사 (회원가입 되어있는지)
					if($this->login_model->check_sns_login($sns_name, $sns_user->id, true)){
						// 회원가입되어있고 탈퇴회원이 아니니 바로 세션 부여 하고 sns토큰 업데이트
						$sns_result = $this->login_model->get_member_sns($sns_name, $sns_user->id);
						if($sns_result->mail_approve == 'no'){
							// 메일 인증이 완료되지 않은 회원이라면
							$nowtime = date("Y-m-d H:i:s", time());
							$lasttime = get_confirmation_mail_time($sns_result->user_register);
							if($nowtime > $lasttime){
								$message = stripslashes($this->lang_log['email_verification_day_over']);
								$this->member_model->delete_member($sns_result->user_id);
								$this->facebookapi->revoking_login($facebook->access_token);
							}else{
								$message = stripslashes($this->lang_log['certification_24_hours2']).'\n'.$sns_result->user_register.'~'.date('Y-m-d H:i:s', strtotime("+1 days", strtotime($sns_result->user_register)));
							}
							$this->session->set_flashdata('message', $message);
							redirect(site_url().$lang.'/auth/');
						}
						if(!$this->login_model->set_sns_token($facebook->access_token, $sns_name, $sns_user->id)){
							$this->session->set_flashdata('message', 'SNS ERROR. Please try again in a few minutes.');
							redirect(site_url().$lang.'/auth/');
						}
						$this->set_login_session($sns_result);
						$this->session->set_userdata('user_sns_token', $facebook->access_token);
						redirect(site_url().$returnURL);
					}else{
						$member_check = $this->login_model->get_member_sns($sns_name, $sns_user->id, 'unregister');
						if($member_check){
							$re_time = strtotime("+30 days", strtotime($member_check->user_activity));
							if(strtotime(date("Y-m-d H:i:s", time())) <= $re_time){
								$this->facebookapi->revoking_login($facebook->access_token);
								$this->session->set_flashdata('message', stripslashes($this->lang_log['re_joinus_account_msg2']).'\n['.$member_check->user_activity.']\n~ ['.date("Y-m-d H:i:s", $re_time).']');
								redirect(site_url().$lang.'/auth');
							}else{
								preg_match('/^un_\d{6}_/', $member_check->user_id, $match_id);
								$match_id = isset($match_id[0])?$match_id[0]:'un_'.datae('Ymd', time()).'_';
								if(!$this->member_model->set_member_customer($member_check->user_id, array(
									'user_sns_id'	=> $match_id.$member_check->user_sns_id
								))){
									redirect(site_url().$lang.'/auth');
								}
							}
						}
						/*
							신규가입 & 재가입
							메일 있으면 다이렉트 가입 없다면 약관 및 입력 페이지로
						*/
						if(isset($sns_user->email)){
							$sns_user_data = array(
								'user_id'			=> $sns_user->id.'@facebook.com',
								'user_email'		=> $sns_user->email,
								'user_pwd'			=> password_hash($sns_user->id, PASSWORD_DEFAULT),
								'user_name'			=> $sns_user->name,
								'user_type'			=> 'mp_user',
								'user_level'		=> 2,
								'user_activity'		=> date('Y-m-d H:i:s', time()),
								'user_register'		=> date('Y-m-d H:i:s', time()),
								'mail_approve'		=> 'yes',
								'user_sns_type'		=> $sns_name,
								'user_sns_id'		=> $sns_user->id,
								'user_sns_token'	=> $facebook->access_token
							);
							$this->login_model->quick_join($sns_user_data);
							$sns_result = $this->login_model->get_member_sns($sns_name, $sns_user->id);
							$this->set_login_session($sns_result);
							$this->session->set_userdata('user_sns_token', $facebook->access_token);
							$this->session->set_flashdata('complete_signup', 'sns');
							$this->session->set_flashdata('complete_userid', $this->encryption->encrypt($sns_user_data['user_id']));
							redirect(site_url().$lang.'/auth/success/');
							//redirect(site_url().$lang);
						}else{
							$this->session->set_userdata('join_type', 	'sns');
							$this->session->set_flashdata('sns_type', 	$sns_name);
							$this->session->set_flashdata('sns_id', 	$sns_user->id);
							$this->session->set_flashdata('sns_name', 	$sns_user->name);
							$this->session->set_flashdata('sns_email', 	'');
							$this->session->set_flashdata('sns_token', 	$facebook->access_token);
							redirect(site_url().$lang.'/auth/joinus/');
						}
					}
				}else{
					// 페이스북 유저정보 가져오기 실패 경고알림과 함께 로그인 페이지로 리다이렉션
					redirect(site_url().$lang.'/auth');
				}
			}else{
				// 페이스북 엑세스 토큰 가져오기 실패 경고알림과 함께 로그인 페이지로 리다이렉션
				redirect(site_url().$lang.'/auth');
			}
		}else{
			show_404();
		}
	}
	// 로그인 시 세션 설정
	private function set_login_session($result){
		$en_user_id		= $this->encryption->encrypt($result->user_id);
		$en_user_email	= $this->encryption->encrypt($result->user_email);
		$en_user_type  	= $this->encryption->encrypt($result->user_type);
		$this->log_security_block->delete_blockid_cookie($en_user_id);
		$this->session->set_userdata('user_id', $en_user_id);
		$this->session->set_userdata('user_email', $en_user_email);
		$this->session->set_userdata('user_type', $en_user_type);
		$this->session->set_userdata('user_name', $result->user_name);
		$this->session->set_userdata('user_nick', $result->user_nick);
		$this->session->set_userdata('user_level', $result->user_level);
		$this->session->set_userdata('user_sns_type', $result->user_sns_type);
	}
}
?>
