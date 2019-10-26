<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Minnesota extends MY_Controller 
{
	public function __construct() 
	{
		parent::__construct();
	}
	public function _remap($method, $params = array())
	{
        if (method_exists($this, $method)) {
        	return call_user_func_array(array($this, $method), $params);
        } else {
			$data = $this->set_home_base(strtolower(__CLASS__), strtolower($method), 'subheader-'.strtolower(__CLASS__));
			$lang_use_page = array('program', 'curriculum', 'admissions', 'major');
			if (in_array(strtolower($method), $lang_use_page)) {
				$this->lang->load('minnesota/'.strtolower($method), $this->homelanguage->lang_seting($this->umv_lang));
				$data['lang_contents']		= $this->lang->line("contents");
			}
			$this->load->view('include/header' ,$data);
			$this->_page(strtolower(__CLASS__).'/'.strtolower($method), $data);
			$this->load->view('include/footer', $data);
        }
	}
	public function index()
	{
        redirect(site_url().$this->homelanguage->get_lang().'/'.strtolower(__CLASS__).'/program');
    }
	public function info_sessions()
	{
		redirect(site_url().$this->umv_lang.'/community/info_sessions', 'location', 302);
	}
}
?>
