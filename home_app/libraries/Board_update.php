<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Board_update{
	private $CI;
	private $user_id 	= null;
	private $user_type	= null;
	public function __construct(){
		$this->CI = &get_instance();
		$this->CI->load->model('board_model');
		$this->CI->load->model('myqna_model');
		$this->CI->load->library('fileupload_new');
		$this->CI->load->library('form_validation');
		$this->user_id		= $this->CI->encryption->decrypt($this->CI->session->userdata('user_id'));
		$this->user_type 	= $this->CI->encryption->decrypt($this->CI->session->userdata('user_type'));
	}
	public function get_user_id(){
		return $this->user_id;
	}
	public function get_user_type(){
		return $this->user_type;
	}
	public function insert($file='', $post='', $bbs_table='', $config='', $filename, $emptyfile=true){
		$upload_file = $this->CI->fileupload_new->upload($file, $config, $filename, '', $emptyfile);
		if($upload_file['is_error'] === 'error'){
			foreach($upload_file['uploadfile'] as $val){
				if(!empty($val['full_path'])){
					@unlink($val['full_path']);
				}
			}
		}
		return $upload_file;
		print_r($upload_file);

	}


	protected function check_board($bbs_table){
		$bbs_table = strtolower($bbs_table);
		$result = $this->CI->board_model->get_board($bbs_table);
		if(empty(trim($bbs_table)) || ! $result){
			return false;
		}else{
			return $result;
		}
	}
	protected function bannedword_check($str){
		return true;
		$banned_word = explode(',', fnc_none_spacae(get_banned_word()));
		for($i=0; $i<count($banned_word); $i++){
			if(preg_match("/".$banned_word[$i]."/i", fnc_none_spacae($str))){
				$this->session->set_flashdata('message', stripslashes($this->CI->lang_message['fobidden_word_msg']).' ('.$banned_word[$i].')');
				return false;
			}
		}
		return true;
	}
    /* 게시글 엽데이트 : 작성, 수정  폼전송*/
	public function post($bbs_table=''){
		if($this->user_type && $table_result = $this->check_board($bbs_table)){

		}else{

		}
	}
	public function put($bbs_table='', $bbs_id=''){

	}
    public function update($bbs_table='', $bbs_mode='', $bbs_id=''){
		$return_data = array();
        if(empty($bbs_table)){

		}
        // 유저타입 검사는 회원제 게시판
        if($this->user_type && $table_result = $this->check_board($bbs_table)){
            $this->form_validation->set_rules('bbs_table', 'Board', 'required');
            $this->form_validation->set_rules('bbs_subject', 'Subject', 'required');
            $this->form_validation->set_rules('bbs_content', 'Contents', 'required|callback_bannedword_check');

            if($this->form_validation->run() == FALSE){
                if(!$this->session->flashdata('message')){
                    $this->session->set_flashdata('message', preg_replace('/\r\n|\r|\n/','',trim(strip_tags(validation_errors()))));
                }
                if($bbs_mode == "insert"){
                    redirect(site_url().$this->umv_lang.'/board/write/'.$bbs_table);
                }else{
                    redirect(site_url().$this->umv_lang.'/board/modify/'.$bbs_table.'/'.$bbs_id);
                }
            }else{
                $config = array(
                    'upload_path' 	=> './assets/file/'.trim(strtolower($bbs_table)).'/'.date('Y'),
                    'allowed_types' => 'gif|jpg|png|zip|pdf|xls|csv|xlsx|doc|docx|dot|dotx|word|xl|hwp',
                    'max_size' 		=> 2048,
                    'encrypt_name' 	=> TRUE
                );
                $upload_file = $this->upload_files($bbs_table, $_FILES, $config);
                if($upload_file['is_error'] == 'error'){
                    $error_msg = '';
                    foreach($upload_file as $val){
                        $error_msg .= $val;
                    }
                    $this->session->set_flashdata('message', $error_msg);
                    if($bbs_mode == "insert"){
                        redirect(site_url().$this->umv_lang.'/board/write/'.$bbs_table);
                    }else{
                        redirect(site_url().$this->umv_lang.'/board/modify/'.$bbs_table.'/'.$bbs_id);
                    }
                }else{
                    if($bbs_mode == "insert"){
                        $result = $this->board_model->board_write($this->input->post(NULL, FALSE), $upload_file);
                        $redirect_link = site_url().$this->umv_lang.'/board/list/'.$bbs_table;
                    }else if($bbs_mode == "modify"){
                        $sch_select  = $this->security->xss_clean($select = $this->input->post('sch_select'));
                        $sch_keyword = $this->security->xss_clean($select = $this->input->post('sch_keyword'));
                        $paged 		 = $this->security->xss_clean($select = $this->input->post('paged'));
                        $result = $this->board_model->board_write_update($this->input->post(NULL, FALSE), $upload_file);
                        $redirect_link = site_url().$this->umv_lang.'/board/view/'.$bbs_table.'/'.$bbs_id.'/?select='.$sch_select.'&keyword='.$sch_keyword.'&paged='.$paged;
                    }else{
                        $result = false;
                    }
                    if($result	&& !isset($result['error_code'])){
                        if($table_result[0]->bbs_syndication == 'yes' && $this->session->userdata('user_level') >=7){
                            $this->session->set_flashdata('message', stripslashes($this->lang_message['complete_registration']).'\n'.$syndi_msg);
                        }else{
                            $this->session->set_flashdata('message', stripslashes($this->lang_message['complete_registration']));
                        }
                        redirect($redirect_link);
                    }else{
                        if(isset($result['error_code'])){
                            $this->session->set_flashdata('message', stripslashes($this->lang_message['bbs_error_code_'.$result['error_code']]));
                        }else{
                            $this->session->set_flashdata('message', stripslashes($this->lang_message['try_again_msg']));
                        }
                        if($bbs_mode == "insert"){
                            redirect(site_url().$this->umv_lang.'/board/write/'.$bbs_table);
                        }else{
                            redirect(site_url().$this->umv_lang.'/board/modify/'.$bbs_table.'/'.$bbs_id);
                        }
                    }
                }

            }
        }else{
            $this->session->set_flashdata('message', stripslashes($this->lang_message['no_bbs_msg']));
            redirect(site_url().$this->umv_lang);
        }
    }
}
?>
