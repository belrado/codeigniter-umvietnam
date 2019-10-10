<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Myqna_model extends CI_Model{
	private $tableNm = null;
	public function __construct(){
		parent::__construct();
		$this->load->database();
		$this->load->library('ckeditor');
		$this->load->library('fileupload_new');
	}

    public function get_qna_list_num($userid){
        $this->db->select('u.user_id');
		$this->db->from($this->db->dbprefix('user as u'));
		$this->db->join($this->db->dbprefix('mem_myqna as q'), 'u.user_id = q.user_id', 'inner');
		$this->db->where('u.user_id', $userid);
		$query = $this->db->get();
		return $query->num_rows();
    }
    public function get_qna_list($userid='', $page_limit=0, $page_list=0){
		if(!$this->session->userdata('user_id') || ($this->encryption->decrypt($this->session->userdata('user_id')) !== $userid)) return false;
		$this->db->where('user_id', $userid);
		$this->db->where('mq_use', 'yes');
		$this->db->order_by('mq_register', 'DESC');
		if($page_limit>0 || $page_list>0)
			$this->db->limit($page_list, $page_limit);
		$query = $this->db->get($this->db->dbprefix('mem_myqna'));
		return $query->result();
	}
	public function insert($post, $files='', $upload_file_exgt='gif|jpg|png|pdf', $upload_file_size=1024){
		$return_data['error_msg'] = false;
		if(!$this->session->userdata('user_id')){
			$return_data['error_msg'] ='access_error_msg';
			return $return_data;
		}
		$this->load->helper('htmlpurifier');
		$copyImgFile 	= isset($post['copyImgFileNames'])?trim($this->security->xss_clean(strip_tags($post['copyImgFileNames']))):'';
		$mq_content		= trim($post['mq_content']);
		$imgFiles 		= '';
		$ckeditor_dir 	= CKEDITOR_PATH.'/mypageqna/';
		// cheitor 이미지파일이 에디터창에서 삭제되지 않고 넘어왔는지 검사
		if(!empty($copyImgFile)){
			$this->ckeditor->set_default_dir($ckeditor_dir);
			$imgFiles = $this->ckeditor->check_upload_imgfiles($copyImgFile, $mq_content, "/\/assets\/img\/ckeditor\/mypageqna\/\w+\.\w{3,4}/");
		}
		// table 태그에 fixed div 감싸기
		$mq_content = $this->set_html_fixed_table($mq_content);
		$data = array(
			'user_id'			=>$this->encryption->decrypt($this->session->userdata('user_id')),
			'mq_subject'		=> mysqli_real_escape_string($this->db->conn_id, $post['mq_subject']),
			'mq_content'		=> clean_xss_tags(html_purify($mq_content, 'comment')),
			'mq_content_imgs'	=> trim(strip_tags($imgFiles)),
			'mq_register'		=> date('Y-m-d H:i:s', time()),
			'mq_ip'				=> $_SERVER['REMOTE_ADDR']
		);
		$this->db->trans_begin();
		$this->db->insert($this->db->dbprefix('mem_myqna'), $data);
		if(is_array($files)){
			$last_id = $this->db->insert_id();
			$config = array(
				'upload_path' 	=> './assets/file/mypageqna/'.$last_id,
				'allowed_types' => $upload_file_exgt,
				'max_size' 		=> $upload_file_size,
				'encrypt_name' 	=> TRUE
			);
			$upload_file = $this->fileupload_new->upload($files, $config, 'bbs_file', '', true);
			if($upload_file['is_error'] === 'error'){
				if(isset($upload_file['uploadfile'])){
					foreach($upload_file['uploadfile'] as $val){
						if(!empty($val['full_path'])){
							@unlink($val['full_path']);
						}
					}
				}
				$this->db->trans_rollback();
				$return_data['error_msg'] = 'try_again_files_msg';
				return $return_data;
			}else{
				$files_data = array();
				$len = 0;
				foreach($upload_file['uploadfile'] as $val){
					if(empty($val['file_name'])) continue;
					$files_data[$len] = array(
						'mq_no'			=> $last_id,
						'f_path'		=> $val['file_path'],
						'f_full_path'	=> $val['full_path'],
						'f_name'		=> $val['file_name'],
						'f_orig_name'	=> $val['orig_name'],
						'f_type'		=> $val['file_ext'],
						'f_size'		=> $val['file_size'],
						'register'		=> date('Y-m-d H:i:s', time())
					);
					$len++;
				}
				$this->db->insert_batch($this->db->dbprefix('mem_myqna_files'), $files_data);
			}
		}
		if($this->db->trans_status() === FALSE){
			$this->db->trans_rollback();
			if(isset($upload_file['uploadfile'])){
				foreach($upload_file['uploadfile'] as $val){
					if(!empty($val['full_path'])){
						@unlink($val['full_path']);
					}
				}
			}
			$return_data['error_msg'] = 'try_again_msg';
			return $return_data;
		}else{
			$this->db->trans_commit();
			return $return_data;
		}
	}
	// 테이블에 강제로 fixed씌우기
	private function set_html_fixed_table($str){
		return $str;
		//$str = preg_replace('/\<\s*table/', '<div class="bbs-fixed-table"><table', $str);
		//$str = preg_replace('/\<\/\s*table\>/', '</table></div>', $str);
		//return $str;
	}
}
?>
