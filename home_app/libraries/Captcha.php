<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Captcha{
	private $CI;
	
	public function __construct(){
		$this->CI = &get_instance();
		$this->CI->load->helper('captcha');
	}
	// 캡차파일 생성 및 그전에 있던 파일삭제
	public function set_captcha_file($custom_vals=array()){
		// 캡차 옵션 셋팅
		$default_vals = array(
			'img_path'      => FCPATH.'captcha/',
	        'img_url'       => site_url().'/captcha/',
	        'font_path'     => './captcha/fonts/3.ttf',
	        'img_width'     => 200,
	        'img_height'    => 60,
	        'word_length'	=> 6,
	        'font_size'     => 24,
	        'img_id'        => 'Imageid',
	        'pool'          => '0123456789'
		);
		foreach($custom_vals as $key=>$val){
			if(in_array($key, array_keys($default_vals))){
				$default_vals[$key] = $val;	
			}
		}
		// 기존에 있던 캡파 파일들(이미지) 전부 삭제 (누적방지)
		$dir = $default_vals['img_path'];
		$handle = opendir($dir);
		while($file = readdir($handle)){
			$fileInfo = pathinfo($file);
			if(isset($fileInfo['extension'])){
				$fileExt = $fileInfo['extension'];
				if($fileExt == 'jpg'){
					@unlink($dir.$file);
				}
			}
		}
		$cap = create_captcha($default_vals);
		$this->set_captcha_image_sesstion($cap, $dir);
		return $cap['image'];
	}
	// 캡차코드 form_validation
	public function check_validate_captcha(){
	    if(isset($this->CI->session->userdata['user_captchaword']) && $this->CI->input->post('captcha') != $this->CI->session->userdata['user_captchaword']){
			$this->CI->session->unset_userdata('user_captchaword');
			$this->CI->session->unset_userdata('user_captchafile');	    	
	        return false;
	    }else{
	    	$this->CI->session->unset_userdata('user_captchaword');
			$this->CI->session->unset_userdata('user_captchafile');
	        return true;
	    }		
	}	
	// 캡차파일 세션 만들기 & 자기가 만든 이미지 지우기
	private function set_captcha_image_sesstion($cap, $dir=''){
		$directory = (!empty($dir))?$dir:FCPATH.'captcha/';
		if(isset($this->CI->session->userdata['user_captchafile'])){
			if(file_exists($directory.$this->CI->session->userdata['user_captchafile'])){
				@unlink($directory.$this->CI->session->userdata['user_captchafile']);
			}
		}
		$this->CI->session->set_userdata(array('user_captchaword'=>$cap['word'], 'user_captchafile'=>$cap['filename']));
	}	
}

?>