<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Test extends MY_Controller {
	public function __construct() {
		parent::__construct();
	}
    public function _remap($method, $params = array()){
        if (method_exists($this, $method)){
        	return call_user_func_array(array($this, $method), $params);
        }else{
			$data = $this->set_home_base(strtolower(__CLASS__), strtolower($method), 'subheader-satpage');
			$this->load->view('include/header' ,$data);
			$this->_page(strtolower(__CLASS__).'/'.strtolower($method), $data);
			$this->load->view('include/footer', $data);
        }
	}
	public function test(){
		$custom_js1						= "<script src='".HOME_JS_PATH."/slick.js'></script>";
		$custom_js2 			 		= "<script src='".HOME_JS_PATH."/main.js".set_last_modified_mtime(HOME_JS_PATH.'/main_test.js')."'></script>";
		$data['javascript_arr']  		= array($custom_js1, $custom_js2);
		$data['css_arr']				= array('<link rel="stylesheet" href="'.site_url().'node_modules/slick-carousel/slick/slick.css" />');
		$data['main_js']		 		= $this->load->view('include/mainJS_slickjs', $data, true);
		// rss 뉴스로 일단 노출
		$data['home_rss'] 				= site_url().'rss/mainrss';//site_url().'feed/news/rss';
		$this->load->view('test', $data);
	}
	protected function _getNav(){
		$this->load->model('globalnav_model');
		$autonav = $this->globalnav_model->nav_get_list_autoset();
		$nav1len=0;
		$nav2len=0;
		$nav3len=0;
		$nav  = array();
		$nav1 = array();
		$nav2 = array();
		$nav3 = array();
		for($i = 0; $i < count($autonav); $i++){
			if($autonav[$i]->nav_depth === '1depth'){
				$nav1[$nav1len] = $autonav[$i];
				$nav1len++;
			}
			if($autonav[$i]->nav_depth === '2depth'){
				$nav2[$nav2len] = $autonav[$i];
				$nav2len++;
			}
			if($autonav[$i]->nav_depth === '3depth'){
				$nav3[$nav3len] = $autonav[$i];
				$nav3len++;
			}
		}
		$nav2len=0;
		$nav3len=0;
		for($i=0; $i < count($nav1); $i++){
			$nav[$i] = $nav1[$i];
			for($j=0; $j < count($nav2); $j++){
				if($nav1[$i]->nav_id == $nav2[$j]->nav_parent){
					$nav[$i]->nav_depth2[$nav2len] = $nav2[$j];
					for($c=0; $c < count($nav3); $c++){
						if($nav2[$j]->nav_id == $nav3[$c]->nav_sub_parent && $nav3[$c]->nav_sub_parent > 0){
							$nav[$i]->nav_depth2[$nav2len]->nav_depth3[$nav3len] = $nav3[$c];
							$nav3len++;
						}
					}
					$nav3len = 0;
					$nav2len++;
				}
			}
			$nav2len = 0;
		}
		return $nav;
	}
}
?>
