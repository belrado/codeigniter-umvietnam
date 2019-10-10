<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Korean extends MY_Controller {
	public function __construct() {
		parent::__construct();
		$this->load->model('univ_model');
	}
	public function _remap($method, $params = array()) {
        if (method_exists($this, $method)){
        	return call_user_func_array(array($this, $method), $params);
        }else{
			$data = $this->set_home_base(strtolower(__CLASS__), strtolower($method), 'subheader-'.strtolower(__CLASS__));
			$lang_use_page = array('program');
			if(in_array(strtolower($method), $lang_use_page)){
				$this->lang->load('korean/'.strtolower($method), $this->homelanguage->lang_seting($this->umv_lang));
				$data['lang_contents']		= $this->lang->line("contents");
				$umv_lang2 = ($this->umv_lang=='ko')?'vn':$this->umv_lang;
				$data['umv_lang2']	= $umv_lang2;
				$data['univ_list']	= $this->univ_model->get_list('u_id, u_name_'.$umv_lang2.', u_program_name_'.$umv_lang2.', u_logo, u_photo');
			}
			$this->load->view('include/header' ,$data);
			$this->_page(strtolower(__CLASS__).'/'.strtolower($method), $data);
			$this->load->view('include/footer', $data);
        }
	}
	public function index() {
        redirect(site_url().$this->homelanguage->get_lang().'/'.strtolower(__CLASS__).'/program');
    }
	public function univ($u_id='') {
		$univ = $this->univ_model->get_univ($u_id);
		switch($u_id){
			case '4' :
				$c_method = 'hannam';
				break;
			case '3' :
				$c_method = 'donga';
				break;
			case '5' :
				$c_method = 'hannam_kssp';
				break;
			case '1' :
				$c_method = 'dongyang';
				break;
			default :
				$c_method = 'univ';
		}
		$data = $this->set_home_base(strtolower(__CLASS__), $c_method, 'subheader-'.strtolower(__CLASS__));
		$umv_lang2 = ($this->umv_lang=='ko')?'vn':$this->umv_lang;
		if($univ){
			$data['umv_lang2']	= $umv_lang2;
			$data['page_2depth_name'] = $univ->{'u_name_'.$umv_lang2};
			$data['univ_list']	= $this->univ_model->get_list('u_id, u_name_'.$umv_lang2.', u_program_name_'.$umv_lang2.', u_logo, u_photo');
		}
		$data['univ']		= $univ;
		$this->load->view('include/header' ,$data);
		$this->_page(strtolower(__CLASS__).'/univ', $data);
		$this->load->view('include/footer', $data);
	}
}
?>
