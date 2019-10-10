<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Filedown{
	
	private $CI;
	private $file_dir;
	
	public function __construct(){
		$this->CI =& get_instance();
		$this->file_dir = FCPATH.'data/';
	}
	
	public function set_filedir($custom_dir){
		$this->file_dir = $custom_dir;
	}
	
	public function downfile($filename='', $mime_type = array('xls')){
		// 네이버 정책상 a태그로 넘어와서 파일받을때 외부링크라고 짤라버리면 불이익받음 버튼형식으로만 받고 a태그이면 링크는 보여지는걸로 스크립트로 다운
		if(parse_url($this->CI->agent->referrer(), PHP_URL_HOST) != parse_url($this->CI->config->item('base_url'), PHP_URL_HOST)){
			//show_404();
			$this->CI->session->set_flashdata('message', '외부 링크로는 파일을 다운받을 수 없습니다. 다시 시도해주세요.');
			//redirect(site_url());
			redirect(site_url().'brochure');
		}else{
			$filename = $this->CI->security->xss_clean(strip_tags(basename($filename)));
			if( $filename[0] == '.' || $filename[0] == '/' ){
				show_404();
			}
			$file = explode('.', $filename);
			if(count($file) <= 1 || !in_array($file[1], $mime_type)){
				show_404();
			}
			$this->CI->load->helper('download');
			$data = file_get_contents($this->file_dir.$filename);
			force_download($filename, $data, true);
		}
	}
}
?>




