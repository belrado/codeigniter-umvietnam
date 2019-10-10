<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Fileupload_new3{
	private $CI;
	protected $empty_arr = array(
        'file_name'     => '',
        'file_type'     => '',
        'file_path'     => '',
        'full_path'     => '',
        'raw_name'      => '',
        'orig_name'     => '',
        'client_name'   => '',
        'file_ext'      => '',
        'file_size'     => '',
        'is_image'      => '',
        'image_width'   => '',
        'image_height'  => '',
        'image_type'    => '',
        'image_size_str'=> ''
    );
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
	$files_nametag='bbs_image', $custom_name='', $emptyFile=false){
		if(!is_dir($config['upload_path'])){
			@mkdir($config['upload_path'], 0777, true);
		}
		$this->CI->load->library('upload', $config);
		$result = array();
		if($files){
			$this->CI->upload->initialize($config);
			foreach($files as $val=>$key){
				$upload_result = false;
				if(is_array($files[$val]['name'])){
					foreach($files[$val]['name'] as $key=>$image){
						if($files[$val]['name'][$key]){
							$_FILES[$val.'[]']['name']= $files[$val]['name'][$key];
				            $_FILES[$val.'[]']['type']= $files[$val]['type'][$key];
				            $_FILES[$val.'[]']['tmp_name']= $files[$val]['tmp_name'][$key];
				            $_FILES[$val.'[]']['error']= $files[$val]['error'][$key];
				            $_FILES[$val.'[]']['size']= $files[$val]['size'][$key];
							if(!empty($custom_name)){
								$config['file_name'] = $custom_name.'_'.date('YmdHis', time()).'_'.$key;
							}
							if($this->CI->upload->do_upload($val.'[]')) {
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
							if($emptyFile){
						        $result['uploadfile'][] = $this->empty_arr;
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
					}
				}else{
					if($this->CI->upload->do_upload($val)) {
						$result['uploadfile'][] =  $this->CI->upload->data();
		            }else{
		            	if($emptyFile){
							$result['uploadfile'][] = $this->empty_arr;
						}else{
							if(isset($result['uploadfile'])){
								for($j=0; $j<count($result['uploadfile']); $j++){
			            			@unlink($result['uploadfile'][$j]['full_path']);
			            		}
							}
							return $this->upload_files_errormsg($result, 'Error', $this->CI->upload->display_errors());
						}
		            }
				}
			}
			$result['is_error'] = 'none';
		}else{
			$result['is_error'] = 'error';
			$result['error_msg'] = '파일이 없습니다.';
		}
		return $result;
	}
	private function upload_files_errormsg(&$result, $label_name, $error){
		$result['is_error'] = 'error';
		$result['error_msg'] = preg_replace('/\r\n|\r|\n/','',trim(strip_tags($label_name.' : '.$error)));
		return $result;
	}
}
?>
