<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Ckeditor{
	protected $CI;
	protected $default_dir = '/assets/img/ckeditor/';

	public function __construct(){
		$this->CI =& get_instance();
		$this->CI->load->database();
	}

	public function set_default_dir($dir){
		$this->default_dir = $dir;
	}

	public function check_upload_imgfiles($copyImgFile, $content, $content_img_exp='', $maximglen=1){
		$imgFiles = '';
		if(empty($content_img_exp)) $content_img_exp = "/\/assets\/img\/ckeditor\/\w+\.\w{3,4}/";
		preg_match_all($content_img_exp, $content, $match);
		//preg_match_all("/\/assets\/img\/ckeditor\/news\/\w+\.\w{3,4}/", $content, $match);
		if(!empty($copyImgFile)){
			$copyImgFiles 	= explode(",", $copyImgFile);
			$imgFilesLen    = 0;
			for($i=0; $i<count($copyImgFiles); $i++){
				if(!in_array($this->default_dir.$copyImgFiles[$i], $match[0])){
					@unlink(FCPATH.$this->default_dir.$copyImgFiles[$i]);
				}
			}
			foreach($match[0] as $val){
				if($maximglen>0 && ($imgFilesLen >= $maximglen)){
					@unlink(FCPATH.$val);
					continue;
				}
				$imgFiles .= (($imgFilesLen == 0)?'':',').str_replace($this->default_dir, "", $val);
				$imgFilesLen ++;
			}
			return $imgFiles;
		}else{
			return '';
		}
	}

	public function delete_imgfiles($imgfiles){
		$imgfile = explode(",", $imgfiles);
		for($i=0; $i<count($imgfile); $i++){
			@unlink(FCPATH.$this->default_dir.$imgfile[$i]);
		}
		return;
	}
}
?>
