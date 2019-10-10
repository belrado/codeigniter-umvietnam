<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Login_model extends CI_Model{
	public function __construct(){
		parent::__construct();
		$this->load->database();
		$this->load->library('Homelanguage');
		/* 언어셋 불러오기 */
		$this->umv_lang = $this->homelanguage->get_lang();
		$this->lang->load('log', $this->homelanguage->lang_seting($this->umv_lang));
		$this->log_lang = $this->lang->line("log");
	}
	// 로그인확인
	public function check_login($userid, $userpwd){
		$tableNm = $this->db->dbprefix('user');
		$userid = $this->security->xss_clean($userid);
		// 일단 필수조건만 가지고옴
		$this->db->select('user_id, user_pwd, mail_approve, user_register');
		$this->db->where('user_id', $userid);
		$this->db->where('user_sns_type', 'home');
		$this->db->where('unregister', 'no');
		$query = $this->db->get($tableNm);
		if($query->num_rows()>0){
			$row = $query->row();
			$this->load->library('log_security_block');
			// 차단된 아이디인지 검사
			if(!$this->log_security_block->check_block_id($userid)){
				if($row->user_id === $userid && password_verify($userpwd, $row->user_pwd)){
					if($row->mail_approve == 'yes'){
						// 접속 시간 업데이트
						$user_activity 	= date('Y-m-d H:i:s', time());
						$data 			= array(
							'user_login_ip'		=> $this->input->ip_address(),
							'user_activity'	=> $user_activity
						);
						$this->db->where('user_id', $userid);
						$this->db->where('user_sns_type', 'home');
						$this->db->update($tableNm, $data);
						// 회원인증완료시 전체 회원정보를 가져와서 넘긴다.
						$this->db->where('user_id', $row->user_id);
						$this->db->where('user_sns_type', 'home');
						$query = $this->db->get($tableNm);
						$row = $query->row();
						$row->error 	= false;
						$row->block_id 	= false;
					}else{
						$row->error 	= true;
						$row->block_id 	= false;
					}
					return $row;
				}else{
					// 아이디는 일치하지만 비번이 틀렸다면 카운트 늘려서 차단시킴 2시간동안 5번 넘으면 차단
					//if($row->user_level >= 7){
						$this->log_security_block->add_block_id($userid, 7200, 9);
					//}
					return false;
				}
			}else{
				// 차단된 아이디라면
				$row->block_id = true;
				return $row;
			}
		}else{
			return false;
		}
	}
	// 회원가입
	public function member_joinus($post){
		$join = array();
		if($this->check_logid($post['user_id'])){
			$join['error'] 		= true;
			$join['message'] 	= 'This e-mail address is already registered.';
			return $join;
		}else{
			// 메일 인증키 생성
			$mail_key = get_rand_number();
			$usermail = (isset($post['user_email']))?$post['user_email']:$post['user_id'];
			// 회원정보저장
			$data = array(
				'user_id'			=> addslashes(strip_tags($post['user_id'])),
				'user_email' 		=> $usermail,
				'user_pwd'			=> ($post['user_sns_type']==='home')?password_hash($post['user_pwd'], PASSWORD_DEFAULT):password_hash($post['user_sns_id'], PASSWORD_DEFAULT),
				'user_name'			=> addslashes(strip_tags($post['user_name'])),
				'user_name_en'		=> (isset($post['user_name_en']))?addslashes(strip_tags($post['user_name_en'])):'',
				'user_phone'		=> (isset($post['user_phone']))?addslashes(strip_tags($post['user_phone'])):'',
				'user_sms'			=> (isset($post['user_sms']))?addslashes(strip_tags($post['user_sms'])):'no',
				'user_birth'		=> (isset($post['user_birth']))?addslashes(strip_tags($post['user_birth'])):'',
				'user_state'		=> (isset($post['user_state']))?addslashes(strip_tags($post['user_state'])):'',
				'user_grade'		=> (isset($post['user_grade']))?addslashes(strip_tags($post['user_grade'])):'',
				'user_type'			=> 'mp_user',
				'user_level'		=> 2,
				'user_register'		=> date('Y-m-d H:i:s', time()),
				'mail_key'			=> $mail_key,
				//'mail_approve'		=> ($post['user_sns_type']==='home')?'no':'yes',
				'user_sns_type'		=> (!isset($post['user_sns_type']))?'home':addslashes($post['user_sns_type']),
				'user_sns_id'		=> (isset($post['user_sns_id']))?addslashes($post['user_sns_id']):'',
				'user_sns_token'	=> (isset($post['user_sns_token']))?addslashes($post['user_sns_token']):''
			);
			if($this->db->insert($this->db->dbprefix('user'), $data)){
				$user_no = $this->db->insert_id();
				//if($post['user_sns_type']==='home' || !isset($post['user_sns_type'])){
					$this->load->library('email');
					$this->email->initialize(array('charset'=>'utf-8', 'wordwrap'=>true, 'mailtype'=>'html'));
					$this->email->from('admission@umvietnam.com', HOME_INFO_NAME);
					$this->email->to($usermail);
					$this->email->subject('[ UMVietnam : '.$data['user_name'].'] '.stripslashes($this->log_lang['signup_verification_email']));
					$html_content .= '<p><strong>'.stripslashes($this->log_lang['signup_completed_umv']).'</strong></p>';
					$html_content .= '<p>'.stripslashes($this->log_lang['signup_verification_email_text']).'</p>';
					$html_content .= '<p style="margin:0 0 20px 0">'.$data['user_register'].' ~ '.date('Y-m-d H:i:s', strtotime("+1 days", strtotime($data['user_register']))).'</p>';
					$html_content .= '<div style="max-width:500px; text-align:left">';
					$html_content .= '<a href="'.site_url().'auth/verification/'.$user_no.'/?key='.$mail_key.'" style="display:block">';
					$html_content .= '<img src="https://umvietnam.com/assets/img/email_verification_img.jpg" style="border:0 none; vertical-align:top; width:100%; max-width:500px;"></a></div>';
					$this->email->message($html_content);
					if($this->email->send()){
						$join['error'] 		= false;
						$join['user_sns']	= false;
						$join['user_info']  = $this->get_member_pk($user_no);
						return $join;
					}else{
						$this->db->where('user_no', $user_no);
						$this->db->delete($this->db->dbprefix('user'));
						$join['error'] 		= true;
						$join['user_sns']	= false;
						$join['message'] 	= stripslashes($this->log_lang['signup_error_msg']).'\nOffice: +84.28.3724.4555 (ext. 6363) | Mobile: +84.34.970.5862 | Korea: +82.2.540.2510';
						return $join;
					}
				//}else{
					//$join['error'] 	= false;
					//$join['user_sns']	= true;
					//$join['user_info']  = $this->get_member_pk($user_no);
					//return $join;
				//}
			}else{
				$join['error'] 		= true;
				if($post['user_sns_type']==='home' || !isset($post['user_sns_type'])){
					$join['user_sns']	= false;
				}else{
					$join['user_sns']	= true;
				}
				$join['message'] 	= stripslashes($this->log_lang['signup_error_msg']).'\nOffice: +84.28.3724.4555 (ext. 6363) | Mobile: +84.34.970.5862 | Korea: +82.2.540.2510';
				return $join;
			}
		}
	}
	public function quick_join($data){
		return $this->db->insert($this->db->dbprefix('user'), $data);
	}
	// 해당아이디의 회원이 있는지 있다면 트루 없다면 폴스 반환
	public function check_logid($userid){
		$this->db->where('user_id', $userid);
		$query =  $this->db->get($this->db->dbprefix('user'));
		if($query->num_rows()>0){
			return true;
		}else{
			return false;
		}
	}
	public function check_sns_login($sns_type, $sns_id, $unregister_check=false){
		if($unregister_check){
			$this->db->where('unregister', 'no');
		}
		// $this->db->where('user_id', $sns_id.'@'.$sns_type.'.com');
		$this->db->where('user_sns_type', $sns_type);
		$this->db->where('user_sns_id', $this->security->xss_clean($sns_id));
		$query =  $this->db->get($this->db->dbprefix('user'));
		if($query->num_rows()>0){
			return true;
		}else{
			return false;
		}
	}
	// 고유번호로 회원 정보 가져오기
	public function get_member_pk($user_no){
		if(!is_numeric($user_no)) return false;
		$this->db->where('user_no', $user_no);
		$query = $this->db->get($this->db->dbprefix('user'));
		return $query->row();
	}
	// sns 토큰 업데이트
	public function set_sns_token($sns_token, $sns_type, $user_id){
		$data = array('user_sns_token'=>$sns_token);
		// $this->db->where('user_id', $sns_id.'@'.$sns_type.'.com');
		$this->db->where('user_sns_type', $sns_type);
		$this->db->where('user_sns_id', $user_id);
		return $this->db->update($this->db->dbprefix('user'), $data);
	}
	public function get_sns_token(){
		if(!$this->session->userdata('user_sns_type') || !$this->session->userdata('user_id')){
			return false;
		}
		$this->db->select('user_sns_token');
		$this->db->where('user_sns_type', $this->session->userdata('user_sns_type'));
		$this->db->where('user_id', $this->encryption->decrypt($this->session->userdata('user_id')));
		$query = $this->db->get($this->db->dbprefix('user'));
		return $query->row()->user_sns_token;
	}
	// sns 타입과 sns id로 회원정보 가져오기
	public function get_member_sns($sns_type, $sns_id, $unregister=''){
		// $this->db->where('user_id', $sns_id.'@'.$sns_type.'.com');
		if($unregister==='unregister'){
			$this->db->where('unregister', 'yes');
		}
		$this->db->where('user_sns_type', $sns_type);
		$this->db->where('user_sns_id', $this->security->xss_clean($sns_id));
		$query =  $this->db->get($this->db->dbprefix('user'));
		return $query->row();
	}
}
?>
