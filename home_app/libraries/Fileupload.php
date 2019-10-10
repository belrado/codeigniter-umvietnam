<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Fileupload{
	private $CI;
	private $file_dir;
	
	public function __construct(){
		$this->CI =& get_instance();
		$this->file_dir = FCPATH.'data/';
	}
	
	public function img_upload(
		$files, $config=array(
		'upload_path' 	=> './assets/file/',
		'allowed_types' => 'gif|jpg|png',
		'max_size' 		=> 2045,
		'encrypt_name' 	=> TRUE ), $files_nametag='bbs_image'){

		$this->CI->load->library('upload', $config);
		
		if(!is_dir($config['upload_path'])){
			@mkdir($config['upload_path'], 0777, true);
		}
			
		$this->CI->load->library('upload', $config);
		$result = array();
		$userType_allowed = $config['allowed_types'];

		if(isset($files[$files_nametag])){
			foreach($files[$files_nametag]['name'] as $key=>$image){
				if($files[$files_nametag]['name'][$key]){
					$_FILES['bbs_image[]']['name']= $files[$files_nametag]['name'][$key];
		            $_FILES['bbs_image[]']['type']= $files[$files_nametag]['type'][$key];
		            $_FILES['bbs_image[]']['tmp_name']= $files[$files_nametag]['tmp_name'][$key];
		            $_FILES['bbs_image[]']['error']= $files[$files_nametag]['error'][$key];
		            $_FILES['bbs_image[]']['size']= $files[$files_nametag]['size'][$key];
					
					//$config['allowed_types'] ='gif|jpg|png';
		            $this->CI->upload->initialize($config);
		
		            if ($this->CI->upload->do_upload('bbs_image[]')) {
		              $result['bbs_images'][] =  $this->CI->upload->data();
		            } else {
		            	if($key > 0 ){
							for($j=0; $j < ($key); $j++){
								@unlink($result['bbs_image'][$key-1]['full_path']);
							}
						}
		            	return $this->upload_files_errormsg($result, '리스트이미지', $this->CI->upload->display_errors());
		            }
				}
				
			}
		}
		$result['is_error'] = 'none';
	    return $result;
	}
	private function upload_files_errormsg(&$result, $label_name, $error){
		$result['is_error'] = 'error';
		$result['error_msg'] = preg_replace('/\r\n|\r|\n/','',trim(strip_tags($label_name.' : '.$error)));
		return $result;
	}
}

?>
	