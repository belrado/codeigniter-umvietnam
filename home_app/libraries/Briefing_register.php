<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Briefing_register extends MY_Controller{
	private $CI;
	
	public function __construct(){
		$this->CI = & get_instance();
	}
	
	public function register($post){
		$this->CI->load->library('form_validation');
		
		$this->CI->form_validation->set_rules('briefing_name', 'briefing_name', 'required');
		$this->CI->form_validation->set_rules('briefing_phone', 'briefing_phone', 'required');
		$this->CI->form_validation->set_rules('briefing_email', 'briefing_email', 'required|valid_email');
		$this->CI->form_validation->set_rules('briefing_day', 'briefing_day', 'required');

		if($this->CI->form_validation->run() == FALSE){
			$this->CI->session->set_flashdata('message', '필수 입력사항 누락 및 오류');
			redirect(site_url());
		}else{
			$this->CI->load->model('register_model');
			$result = $this->CI->register_model->briefing_register($post);
			if($result){
				$this->send_mail($post);
			}else{
				$this->CI->session->set_flashdata('message', '입학설명회 예약에 실패했습니다. 다시 시도해 주세요.');
				redirect(site_url());
			}
		}
	}
	
	protected function send_mail($post){
		$this->CI->load->library('email');
		
		$info_mail 			= self::HOME_INFO_MAIL;
		// 필수항목
		$briefing_info 		= explode("_",trim(strip_tags(addslashes($post['briefing_day']))));
		$briefing_type		= ($briefing_info[0] == "mediprep") ? '약대·의대 설명회' : '유망전공전형 설명회';
		$briefing_name 		= strip_tags(addslashes($post['briefing_name']));
		$briefing_phone		= strip_tags(addslashes($post['briefing_phone']));
		$briefing_email		= strip_tags(addslashes($post['briefing_email']));
		//$briefing_program	= strip_tags(addslashes($post['briefing_program']));
		$briefing_place 	= $briefing_info[1];
		$briefing_time 		= $briefing_info[2];
		// 선택항목
		$briefing_aca		= (isset($post['briefing_aca'])) ? strip_tags($post['briefing_aca']) : '';
		$briefing_field_arr = $post['briefing_field'];
		$briefing_field     = '';
		for($i=0; $i<count($briefing_field_arr); $i++){
			$ext = ($i==0) ? '' : ', ';
			$briefing_field .= $ext.strip_tags(addslashes($briefing_field_arr[$i]));
		}
		$briefing_relation  = (isset($post['briefing_relation'])) ? strip_tags($post['briefing_relation']) : '';
		$briefing_num 		= (isset($post['briefing_num'])) ? strip_tags($post['briefing_num']) : '';
		$briefing_search	= (isset($post['briefing_search'])) ? strip_tags($post['briefing_search']) : '';
		
		$this->CI->email->initialize(array('charset'=>'utf-8', 'wordwrap'=>true, 'mailtype'=>'html'));
		$this->CI->email->from($briefing_email, $briefing_name);
		$this->CI->email->to($info_mail);
		$this->CI->email->subject('['.HOME_INFO_NAME.']'.$briefing_name.'님의 '.$briefing_type.' 예약');
		
		$html_content = "<h1>".$briefing_name."님의 ". HOME_INFO_NAME." 설명회 예약</h1>
			<dl style='width:100%; border:1px solid #ccc'>
			<dt style='margin:0; padding:10px 2%; border-bottom:1px solid #ccc; background:#f9f9f9; font-weight:bold'>이름</dt>
			<dd style='margin:0; padding:10px 3%; border-bottom:1px solid #ccc'>".$briefing_name."</dd>
			<dt style='margin:0; padding:10px 2%; border-bottom:1px solid #ccc; background:#f9f9f9; font-weight:bold'>학생 학력</dt>
			<dd style='margin:0; padding:10px 3%; border-bottom:1px solid #ccc'>".$briefing_aca."</dd>
			<dt style='margin:0; padding:10px 2%; border-bottom:1px solid #ccc; background:#f9f9f9; font-weight:bold'>관계</dt>
			<dd style='margin:0; padding:10px 3%; border-bottom:1px solid #ccc'>".$briefing_relation."</dd>
			<dt style='margin:0; padding:10px 2%; border-bottom:1px solid #ccc; background:#f9f9f9; font-weight:bold'>연락처</dt>
			<dd style='margin:0; padding:10px 3%; border-bottom:1px solid #ccc'>".$briefing_phone."</dd>
			<dt style='margin:0; padding:10px 2%; border-bottom:1px solid #ccc; background:#f9f9f9; font-weight:bold'>이메일</dt>
			<dd style='margin:0; padding:10px 3%; border-bottom:1px solid #ccc'>".$briefing_email."</dd>
			<dt style='margin:0; padding:10px 2%; border-bottom:1px solid #ccc; background:#f9f9f9; font-weight:bold'>관심분야</dt>
			<dd style='margin:0; padding:10px 3%; border-bottom:1px solid #ccc'>".$briefing_field."</dd>
			<dt style='margin:0; padding:10px 2%; border-bottom:1px solid #ccc; background:#f9f9f9; font-weight:bold'>예약한 설명회</dt>
			<dd style='margin:0; padding:10px 3%; border-bottom:1px solid #ccc'>[".$briefing_type."] ".$briefing_time." ".$briefing_place."</dd>
			<dt style='margin:0; padding:10px 2%; border-bottom:1px solid #ccc; background:#f9f9f9; font-weight:bold'>참석인원</dt>
			<dd style='margin:0; padding:10px 3%; border-bottom:1px solid #ccc'>".$briefing_num."</dd>
			<dt style='margin:0; padding:10px 2%; border-bottom:1px solid #ccc; background:#f9f9f9; font-weight:bold'>정보취득경로</dt>
			<dd style='margin:0; padding:10px 3%'>".$briefing_search."</dd>
			</dl>";
		
		$this->CI->email->message($html_content);
		if($this->CI->email->send()){
    		$this->CI->session->set_flashdata('message', $briefing_name.'님의 입학설명회 예약이 완료되었습니다.\n예약하신 설명회 일자는 [ '.$briefing_time.'\n'.$briefing_place.' ] 입니다.');
			redirect(site_url());
		}else{
			$this->CI->session->set_flashdata('message', '입학설명회 예약에 실패했습니다. 다시 시도해 주세요.');
			redirect(site_url());
		}
	}
}
?>
	