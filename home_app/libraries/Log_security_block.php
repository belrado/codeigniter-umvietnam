<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Log_security_block{
	private $CI;
	// ip로 차단 file
	private $block_ip_file;
	// id로 차단 file
	private $block_id_file;
	// 부정 로그인을 막기위해 아이피는 일괄차단 아이디는 해당 아이디만 차단 (로그인시 아이디는 맞는데 비밀번호가 틀리다면 하루 또는 정해진 시간동안 누적 카운터 수가 정해진 수 보다 넘어가면 해당 아이디 차단)
	public function __construct(){
		$this->CI = &get_instance();
		$this->CI->load->helper('cookie');
		
		$this->block_id_file = 'login_block_id.txt';
		$this->block_ip_file = 'login_block_ip.txt';
	}
	// 차단된아이디 배열 반환
	public function get_block_id_file(){
		return $this->get_block_file($this->block_id_file);
	}
	// 차단된 아이피 배열 반환
	public function get_block_ip_file(){
		return $this->get_block_file($this->block_ip_file);
	}
	// 현재 접속한 아이디가 차단된 아이디인지 반환
	public function check_block_id($user_id){
		$block_id = $this->get_block_file($this->block_id_file);
		return in_array($user_id, $block_id);
	}
	// 현재 접속한 아이디 차단추가
	public function add_block_id($user_id, $block_time=7200, $limit_count=5){
		if(get_cookie('check_id') !== $user_id || !get_cookie('check_cnt_id')){
			set_cookie('check_cnt_id', 1, $block_time);
			set_cookie('check_id', $user_id, $block_time);
		}else{
			$block_count = (int)get_cookie('check_cnt_id');
			$block_count++;
			if($block_count > $limit_count){
				$this->delete_blockid_cookie($user_id);
				$this->set_block_file($this->block_id_file, $user_id);
			}else{
				set_cookie('check_cnt_id', $block_count, $block_time);
			}
		}		
	}
	// 현재 접속한 ip가 차단된 ip인지 반환
	public function check_block_ip(){
		$user_ip = $this->CI->input->ip_address();
		$block_ip = $this->get_block_file($this->block_ip_file);
		return in_array($user_ip, $block_ip);
	}
	// 현재 접속한 ip 차단추가
	public function add_block_ip($block_time=10, $limit_count=10){
		if(!get_cookie('check_cnt_ip')){
			set_cookie('check_cnt_ip', 1, $block_time);
		}else{
			$block_count = (int)get_cookie('check_cnt_ip');
			$block_count++;
			if($block_count > $limit_count){
				$this->set_block_file($this->block_ip_file, $this->CI->input->ip_address());
			}else{
				set_cookie('check_cnt_ip', $block_count, $block_time);
			}
		}		
	}
	// 관리자에서 선택된 차단자를 삭제
	public function delete_block_user_file($type, $block_user){
		$block_txt	= ($type == 'block_ip')?$this->block_ip_file:$this->block_id_file;
		$fh 		= fopen(HOME_ROOT_PATH."data/".$block_txt, "w");
		fwrite($fh, $block_user);
		fclose($fh);
	}
	// 블락 아이디 쿠키 삭제
	public function delete_blockid_cookie($user_id){
		delete_cookie($user_id);
	}
	// 게시판글쓰기용
	public function get_check_write($block_time=60){
		if(!get_cookie('check_write_ip')){
			set_cookie('check_write_ip', 1, $block_time);
			return true;
		}else{
			return false;
		}		
	}
	// 부정로그인 차단 파일 가져오기
	private function get_block_file($block_txt){
		$fh = fopen(HOME_ROOT_PATH."data/".$block_txt, "r");
		$block_s = '';
		$block_a = '';
		while (!feof($fh)) {
			$line_of_text = fgets($fh);
			$block_s .= $line_of_text;
		}		
		$block_a = (!empty($block_s))?explode(",", $block_s):array();
		fclose($fh);
		return $block_a;
	}
	// 부정로그인 차단 파일에 추가
	private function set_block_file($block_txt, $block_user){
		$fh = fopen(HOME_ROOT_PATH."data/".$block_txt, 'a');
		$block_file = $this->get_block_file($block_txt);
		$block_len = count($block_file);
		if(!in_array($block_user, $block_file)){
			if($block_len > 0){
				fwrite($fh, ','.$block_user);
			}else{
				fwrite($fh, $block_user);
			}
		}
		fclose($fh);
	}
}
?>