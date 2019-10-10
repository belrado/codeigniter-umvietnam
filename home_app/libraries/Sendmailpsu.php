<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Sendmailpsu{
	private $CI;
	public function __construct(){
		$this->CI = &get_instance();
		$this->CI->load->library('email');
	}
	/*
	 * home_send_mail(메일받을 주소, 보내는메일주소, 보내는사람, 제목, 메일데치터 array(타이틀=>내용))
	 */
	public function home_send_mail($to_mail='info@psuedu.org', $form_mail='', $from_name='', $subject='', $mailData=array()){
		if(count($mailData) < 1) return false;
		$value 		= '';
		$mailHtml 	= "<dl style='width:100%; border:1px solid #ccc'>";
		foreach($mailData as $key=>$val){
			$mailHtml .= "<dt style='margin:0; padding:10px 2%; border-bottom:1px solid #ccc; background:#f9f9f9; font-weight:bold'>".fnc_set_htmls_strip($key, true)."</dt>";
			if(is_array($val)){
				$value = implode(', ', $val);
			}else{
				$value = $val;
			}
			$mailHtml .= "<dd style='margin:0; padding:10px 3%; border-bottom:1px solid #ccc'>".nl2br($value)."</dd>";
		}
		$mailHtml .= '</dl>';
		$this->CI->email->initialize(array('charset'=>'utf-8', 'wordwrap'=>true, 'mailtype'=>'html'));
		$this->CI->email->from($form_mail, $from_name);
		$this->CI->email->to($to_mail);
		$this->CI->email->subject($subject);
		$this->CI->email->message($mailHtml);
		if($this->CI->email->send()){
			return true;
		}else{
			return false;
		}
	}
	public function home_send_mail2($to_mail='info@psuedu.org', $form_mail='', $from_name='', $subject='', $mailHtml=''){
		$this->CI->email->initialize(array('charset'=>'utf-8', 'wordwrap'=>true, 'mailtype'=>'html'));
		$this->CI->email->from($form_mail, $from_name);
		$this->CI->email->to($to_mail);
		$this->CI->email->subject($subject);
		$this->CI->email->message($mailHtml);
		if($this->CI->email->send()){
			return true;
		}else{
			return false;
		}
	}
}
?>