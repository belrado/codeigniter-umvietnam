<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Member_model extends CI_Model{
	private $tableNm = null;
	public function __construct(){
		parent::__construct();
		$this->load->database();
		$this->tableNm = $this->db->dbprefix('user');
	}
	// 회원 테이블에 회원이 아이디가 있는지 확인
	// 직원테이블에 회원 아이디가 있는지 확인
	public function check_staff($userid){
		$this->db->where('user_id', $userid);
		$query = $this->db->get($this->db->dbprefix('company_members'));
		if($query->num_rows()>0){
			return true;
		}else{
			return false;
		}
	}
	public function get_member_list($userType='all'){
		if($userType == 'all'){
			$noneType = HOME_PREFIX."superMaster";
			$this->db->where('user_type !=', $noneType);
			$this->db->order_by('user_level', 'DESC');
			$this->db->order_by('user_name', 'ASC');
			$query = $this->db->get($this->tableNm);
		}else if($userType == HOME_PREFIX.'master' || $userType == HOME_PREFIX.'user' || $userType == 'membership'){
			if($userType == HOME_PREFIX.'user'){
				$this->db->where('user_level', '2');
			}else if($userType == 'membership'){
				$userType = HOME_PREFIX.'user';
				$this->db->where('user_level>=', '3');
			}
			$this->db->where('user_type', $userType);
			$query = $this->db->get($this->tableNm);
		}else{
			return false;
		}
		return $query->result();
	}
	// 회원정보가저오기
	public function get_member($userno, $where='user_no'){
		$this->db->select('user_no, user_id, user_email, user_name, user_name_en, user_birth, user_state, user_grade, user_nick, user_phone, user_type, user_level, staff_type, staff_lv, mail_approve, mail_key, user_activity, user_register, user_sns_type, user_sns_id, user_sns_token');
		$query = $this->db->get_where($this->tableNm, array($where=>$userno));
		$len = $query->num_rows();
		if($len>0){
			return $query->result();
		}else{
			return false;
		}
	}
	// 선택한 회원정보로 회원 한명의 정보 가져오기
	public function get_member_select($user_id='', $select=''){
		if(empty($user_id)) return false;
		if(!empty($select)){
			$this->db->select($select);
		}
		$this->db->where('user_id', $user_id);
		$query = $this->db->get($this->db->dbprefix('user'));
		return $query->row();
	}
	// 정보수정 - 관리자전용
	public function set_member($post){
		$userid    = $this->security->xss_clean($post['userid']);
		$useremail = $this->security->xss_clean($post['useremail']);
		$user_data = array(
			'user_id' 		=> $userid,
			'user_email'	=> strip_tags($useremail),
			'user_name'		=> $this->security->xss_clean(strip_tags(addslashes($post['username']))),
			'user_name_en'	=> $this->security->xss_clean(strip_tags(addslashes($post['username_en']))),
			'user_nick'		=> $this->security->xss_clean(strip_tags(addslashes($post['usernick']))),
			'user_phone'	=> $this->security->xss_clean(strip_tags(addslashes($post['userphone'])))
		);
		if(isset($post['usertype'])){
			$user_data['user_type'] = $this->security->xss_clean(strip_tags(addslashes($post['usertype'])));
		}
		if(isset($post['userlv'])){
			$user_data['user_level'] = (int) $this->security->xss_clean(strip_tags(addslashes($post['userlv'])));
		}
		if(isset($post['staff_type'])){
			$user_data['staff_type'] = $this->security->xss_clean(strip_tags(addslashes($post['staff_type'])));
		}
		if(isset($post['staff_lv'])){
			$user_data['staff_lv'] = (int) $this->security->xss_clean(strip_tags(addslashes($post['staff_lv'])));
		}
		if(isset($post['mail_approve'])){
			$user_data['mail_approve'] = $this->security->xss_clean(strip_tags(addslashes($post['mail_approve'])));
		}

		$this->db->trans_begin();
		$this->db->where('user_id', $userid);
		$this->db->update($this->db->dbprefix('user'), $user_data);
		$sresult = true;
		// 직원 이라면 staff_type == psu_staff 직원 테이블에 추가되어있는지 확인
		if(isset($post['staff_type'])){
			if($post['staff_type'] === 'mp_staff'){
				// 직원이니까 직원테이블에 해당유저 정보가 있는지 확인 있다면 끝 없다면 추가
				if(!$this->check_staff($userid)){
					$sresult = $this->add_staff($userid);
				}
			}else{
				//$cuser = $this->get_member($post['userno']);
				// 직원이 아닌데 그전에 직원이었다 아니라고 바꿀 수 있으니 기존 정보 확인 후 직원테이블에서 삭제 -> 이건 뭐 냅두자.. 직원테이블엔 생성시 추가시키고 가져올땐 staff_type 정보에따라
			}
		}
		if($this->db->trans_status() === FALSE || !$sresult){
        	$this->db->trans_rollback();
			return false;
		}else{
        	$this->db->trans_commit();
			return true;
		}
	}
	// 정보수정 - 회원이 직접
	public function set_member_user($post, $userid){
		$user_id   = $userid;
		$user_data = array(
			'user_name_en'	=> $this->security->xss_clean(strip_tags($post['user_name_en'])),
			'user_phone'	=> $this->security->xss_clean(strip_tags($post['user_phone'])),
			'user_state'	=> $this->security->xss_clean(strip_tags($post['user_state'])),
			'user_grade'	=> $this->security->xss_clean(strip_tags($post['user_grade'])),
		);
		if($this->session->userdata('user_sns_type')!== 'home'){
			$user_data['user_email'] = $this->security->xss_clean(strip_tags($post['user_email']));
			//array_unshift($user_data, '', )
		}
		$this->db->where('user_id', $user_id);
		return $this->db->update($this->db->dbprefix('user'), $user_data);
	}
	// 바꿀내용을 자유롭게 데이터로 보내서 정보수정
	public function set_member_customer($user_id='', $data){
		if(empty($user_id) || !isset($data)) return false;
		$this->db->where('user_id', $user_id);
		return $this->db->update($this->db->dbprefix('user'), $data);
	}
	// 비밀번호 업데이트
	public function set_member_password($post, $userid=''){
		$user_id    = (empty($userid))?$this->security->xss_clean($post['userid']):$userid;
		if(empty($user_id)) return false;
		$user_data = array(
			'user_pwd' => password_hash($post['password'], PASSWORD_DEFAULT),
		);
		$this->db->where('user_id', $user_id);
		return $this->db->update($this->db->dbprefix('user'), $user_data);
	}
	// 직원정보 테이블에 직원추가
	public function add_staff($userid){
		if(empty($userid)) return false;
		$data = array(
			'user_id' => $this->security->xss_clean($userid),
			'last_register' => date('Y-m-d H:i:s', time())
		);
		return $this->db->insert($this->db->dbprefix('company_members'), $data);
	}
	// 멤버추가
	public function add_member($post){
		$tableNm = $this->db->dbprefix('user');
		$sql = sprintf("select user_no from `{$tableNm}` where user_email = '%s'", $post['useremail']);
		$query = $this->db->query($sql);
		$email_len = $query->num_rows();
		if($email_len > 0){
			return 'error_same';
		}else{
			$user_pwd 		= password_hash($post['password'], PASSWORD_DEFAULT);
			$user_activity 	= date('Y-m-d H:i:s', time());
			$user_register 	= $user_activity;
			if($post['usertype'] === 'mp_user'){
				$post['userlv'] = ($post['userlv']> 6)?2:$post['userlv'];
			}
			$data 			= array(
								'user_id' 		=>$post['userid'],
								'user_email'	=>$this->security->xss_clean(strip_tags($post['useremail'])),
								'user_pwd'		=>$user_pwd,
								'user_name'		=>$this->security->xss_clean(strip_tags($post['username'])),
								'user_name_en'	=>$this->security->xss_clean(strip_tags($post['username_en'])),
								'user_nick'		=>$this->security->xss_clean(strip_tags($post['usernick'])),
								'user_phone'	=>$this->security->xss_clean(strip_tags($post['userphone'])),
								'user_type'		=>$this->security->xss_clean(strip_tags($post['usertype'])),
								'user_level'	=>$post['userlv'],
								'staff_type'	=> (isset($post['staff_type']))?$this->security->xss_clean(strip_tags($post['staff_type'])):'none',
								'staff_lv'		=> (isset($post['staff_lv']))?$this->security->xss_clean(strip_tags($post['staff_lv'])):0,
								'user_activity'	=>$user_activity,
								'user_register'	=>$user_register,
								'mail_approve'  =>'yes');
			$this->db->trans_begin();
			$sresult = true;
			$sql 			= $this->db->insert_string($tableNm, $data);
			$this->db->query($sql);
			if(isset($post['staff_type'])){
				if($post['staff_type'] === 'mp_staff'){
					// 직원이니까 직원테이블에 해당유저 정보가 있는지 확인 있다면 끝 없다면 추가
					if(!$this->check_staff($post['userid'])){
						$sresult = $this->add_staff($post['userid']);
					}
				}else{
					//$cuser = $this->get_member($post['userno']);
					// 직원이 아닌데 그전에 직원이었다 아니라고 바꿀 수 있으니 기존 정보 확인 후 직원테이블에서 삭제 -> 이건 뭐 냅두자.. 직원테이블엔 생성시 추가시키고 가져올땐 staff_type 정보에따라
				}
			}
			if($this->db->trans_status() === FALSE || !$sresult){
	        	$this->db->trans_rollback();
				return 'error_sql';
			}else{
	        	$this->db->trans_commit();
				return 'success';
			}
		}
	}
	// 멤버 인증메일 업데이트
	public function set_mail_verification($user_no){
		$data = array(
			'mail_approve' => 'yes'
		);
		$this->db->where('user_no', $user_no);
		return $this->db->update($this->db->dbprefix('user'), $data);
	}
	// 멤버삭제
	public function delete_member($user_id=''){
		if(empty($user_id)){
			return false;
		}else{
			if(is_array($user_id)){
				$this->db->or_where_in('user_no', $user_id['delete_no']);
			}else{
				$this->db->where('user_id', $user_id);
			}
			return $this->db->delete($this->db->dbprefix('user'));
		}
	}
	// 멤버회원탈퇴처리 삭제가 아님
	public function member_unregister($post){
		$user_pwd 	= $post['password'];
		$user_id 	= $this->encryption->decrypt($this->session->userdata('user_id'));
		$user_info 	= $this->get_member_select($user_id, 'user_pwd');
		$return_msg = array('error'=>true);
		if($user_info){
			if(password_verify($user_pwd, $user_info->user_pwd)){
				$data = array(
					'user_activity'	=> date('Y-m-d H:i:s', time()),
					'unregister' 	=> 'yes'
				);
				if($this->set_member_customer($user_id, $data)){
					$return_msg['error'] = false;
					$return_msg['msg']   = '회원 탈퇴 완료.\nUMVietnam 이용해 주셔서 감사합니다.';
				}else{
					$return_msg['msg']   = '비밀번호를 정확히 입력해 주세요.';
				}
			}else{
				$return_msg['msg']   = '비밀번호를 정확히 입력해 주세요.';
			}
		}else{
			$return_msg['msg']   = '접근방식 오류.';
		}
		return $return_msg;
	}
	// 멤버회원탈퇴처리 삭제가 아님 sns 나중엔 access token으로 삭제 바꾸자..
	public function sns_member_unregister($user_id){
		$data = array(
			'user_id'		=> 'un_'.substr(date('Ymd', time()), 2).'_'.$user_id,
			'user_activity'	=> date('Y-m-d H:i:s', time()),
			'unregister' 	=> 'yes'
		);
		if($this->set_member_customer($this->security->xss_clean($user_id), $data)){
			return true;
		}else{
			return false;
		}
	}
	// 해당회원이 참석한 설명회 가져오기
	 public function get_user_attend_presentation($user=''){
	 	if(empty($user)){
	 		return false;
	 	}
		$this->db->select('p.p_day, p.p_place, p.p_location');
		$this->db->from($this->db->dbprefix('presentation_user as u'));
		$this->db->join($this->db->dbprefix('presentation as p'), 'p.p_id = u.p_id', 'left');
		$this->db->where('u.u_email', $user);
		$this->db->order_by('p.p_day','ASC');
		$query = $this->db->get();
		return $query->result();
	 }
	 // 회원이 맞는지 확인
	 public function check_userid(){
	 	$userid = $this->encryption->decrypt($this->session->userdata('user_id'));
		$this->db->where('user_id', $userid);
		$query = $this->db->get($this->db->dbprefix('user'));
		return $query->num_rows();
	 }
}
?>
