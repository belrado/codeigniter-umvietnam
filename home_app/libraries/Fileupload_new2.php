<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Fileupload_new2{
	private $CI;
	public function __construct(){
		$this->CI =& get_instance();
	}
	public function upload(
	$files,
	$config=array(
	'upload_path' 	=> './assets/file/',
	'allowed_types' => 'gif|jpg|png',
	'max_size' 		=> 2045,
	'encrypt_name' 	=> TRUE ),
	$files_nametag='bbs_image', $custom_name=''){
		if(!is_dir($config['upload_path'])){
			@mkdir($config['upload_path'], 0777, true);
		}
		$this->CI->load->library('upload', $config);
		$result = array();
		if(isset($files[$files_nametag])){
			if(is_array($files[$files_nametag]['name'])){

			}else{

			}

			foreach($files[$files_nametag]['name'] as $key=>$image){
				if($files[$files_nametag]['name'][$key]){
					$_FILES['uploadfile[]']['name']= $files[$files_nametag]['name'][$key];
		            $_FILES['uploadfile[]']['type']= $files[$files_nametag]['type'][$key];
		            $_FILES['uploadfile[]']['tmp_name']= $files[$files_nametag]['tmp_name'][$key];
		            $_FILES['uploadfile[]']['error']= $files[$files_nametag]['error'][$key];
		            $_FILES['uploadfile[]']['size']= $files[$files_nametag]['size'][$key];
					if(!empty($custom_name)){
						$config['file_name'] = $custom_name.'_'.date('YmdHis', time()).'_'.$key;
					}
		            $this->CI->upload->initialize($config);
					if($this->CI->upload->do_upload('uploadfile[]')) {
		              $result['uploadfile'][] =  $this->CI->upload->data();
		            }else{
		            	if($key > 0 ){
							for($j=0; $j < ($key); $j++){
								@unlink($result['uploadfile'][$key-1]['full_path']);
							}
						}
		            	return $this->upload_files_errormsg($result, 'Error', $this->CI->upload->display_errors());
		            }
				}else{
					for($j=0; $j < ($key); $j++){
						@unlink($result['uploadfile'][$key-1]['full_path']);
					}
					unset($result);
					$result['is_error'] = 'error';
					$result['error_msg'] = '파일이 없습니다.';
					return $result;
				}
			}
			$result['is_error'] = 'none';
		}else{
			$result['is_error'] = 'error';
			$result['error_msg'] = '파일[name]이 없습니다.';
		}
	    return $result;
	}
	private function upload_files(){

	}
	private function upload_files_errormsg(&$result, $label_name, $error){
		$result['is_error'] = 'error';
		$result['error_msg'] = preg_replace('/\r\n|\r|\n/','',trim(strip_tags($label_name.' : '.$error)));
		return $result;
	}
}
?>
