<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class LanguageLoader {
    protected $CI;
    public function __construct(){
        $this->CI =& get_instance();
        $this->CI->load->helper('language');
    }
    // 디폴트는 나라언어셋에 맞춰서 설정되고
    // 언어체인지는 언어버튼 클릭시 도메인뒤에 국가별 약자를 집어넣어 비교한다.
    public function init_session(){
        if($this->CI->session->userdata('home_lang')){
            $this->CI->lang->load('default', $this->CI->session->userdata('home_lang'));
        }else{
            $lang = substr($_SERVER['HTTP_ACCEPT_LANGUAGE'], 0, 2);
            if($lang=='vi') $lang='vn';
            $this->CI->lang->load('default', $this->CI->homelanguage->lang_seting($lang));
            $this->CI->session->set_userdata('home_lang', $this->CI->homelanguage->lang_seting($lang));
        }
    }
    public function init_link(){
        $lang = $this->CI->homelanguage->get_lang();
        $this->CI->lang->load('default', $this->CI->homelanguage->lang_seting($lang));
    }
}
?>
