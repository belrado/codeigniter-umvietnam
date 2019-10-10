<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Shortterm extends MY_Controller {
	public function __construct() {
		parent::__construct();
	}
	public function _remap($method, $params = array()){
        if (method_exists($this, $method)){
        	return call_user_func_array(array($this, $method), $params);
        }else{
			$data = $this->set_home_base(strtolower(__CLASS__), strtolower($method), 'subheader-'.strtolower(__CLASS__));
			$lang_use_page = array('program', 'english_culture', 'english_internship');
			if(in_array(strtolower($method), $lang_use_page)){
				$this->lang->load('shortterm/'.strtolower($method), $this->homelanguage->lang_seting($this->umv_lang));
				$data['lang_contents']		= $this->lang->line("contents");
			}
			switch($method){
				case 'english_culture' :
				case 'english_internship' :
					$data['page_2depth_name'] = $data['page_2depth_name'].'__'.$data['page_2depth_name'].' <span>('.$data['lang_contents']['page_subtit'].')</span>';
				break;
			}
			if($method==='english_internship'){
				$data['css_arr']		= array(
					'<link rel="stylesheet" href="'.site_url().'node_modules/slick-carousel/slick/slick.css" />',
				);
				$data['javascript_arr']  		= array(
					"<script src='".HOME_JS_PATH."/slick.js'></script>",
					"<script src='".HOME_JS_PATH."/internship.js".set_last_modified_mtime(HOME_JS_PATH.'/internship.js')."'></script>"
				);
			}
			$this->load->view('include/header' ,$data);
			$this->_page(strtolower(__CLASS__).'/'.strtolower($method), $data);
			$this->load->view('include/footer', $data);
        }
	}
	public function index(){
        redirect(site_url().$this->homelanguage->get_lang().'/'.strtolower(__CLASS__).'/program');
    }
	public function english(){
		redirect(site_url().$this->homelanguage->get_lang().'/'.strtolower(__CLASS__).'/english/culture');
	}
}
?>
