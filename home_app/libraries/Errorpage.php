<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Errorpage extends MY_Controller{
	private $CI;
	public function __construct(){
		$this->CI = & get_instance();
	}
	public function set_errorpage($httpcode=404){
		header('HTTP/1.0 404 Not Found');
		$data 					 		= $this->CI->_set_meta_data(array('title' =>'404 Page Not Found | '.HOME_INFO_NAME));
		$data['mp_nav'] 		 		= $this->CI->_getNav();
		$data['page_1depth_name'] 		= '404 Page Not Found';
		//$data['page_2depth_name'] 		= '';
		$data['active'] 		 		= __FUNCTION__;
		$data['is_mobile'] 		 		= $this->CI->_check_mobile();
		// 퀵메뉴 인크루드
		$data['quick_nav'] 		 		= $this->CI->load->view('include/quick_nav', $data, true);
		
		$this->CI->load->view('include/header' ,$data);
		$this->CI->_page('error_404', $data);
		$this->CI->load->view('include/footer', $data);
	}
}
?>