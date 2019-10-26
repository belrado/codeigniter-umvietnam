<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Univ extends MY_Controller
{
	private $de_user_type = null;
	public $super_check = false;

	public function __construct()
	{
		parent::__construct();
		$this->de_user_type = $this->encryption->decrypt($this->session->userdata('user_type'));
		// 관리자인지 확인
		$this->_check_security_master($this->de_user_type, $this->encryption->decrypt($this->session->userdata('user_id')));
		if ($this->de_user_type === HOME_PREFIX."superMaster") {
			$this->super_check = true;
		}
		$this->_check_security_master_lv(9);
		$this->load->helper('form');
		$this->load->library('form_validation');
		$this->load->model('univ_model');
	}
	public function index()
	{
		redirect(site_url().'homeAdm/qna/list', 'location', 302);
	}
	public function list($page=1)
	{
        $data = $this->_set_meta_data(array('title'=>'한국대 목록'));
		$data['active'] 		= 'univ';
        $data['sub_active']     = 'univ_list';
        $data['univ_list']      = $this->univ_model->get_list('', true);
		$this->_getPageLayout('univ_list', $data);
	}
	public function write($u_id='')
	{
		$univ_result = false;
		if (is_numeric($u_id)) {
			$univ_result = $this->univ_model->get_univ($u_id);
			$this->form_validation->set_rules('u_id', '', 'required|numeric');
		}
		// 로고와 이미지도 넣어야함
		$this->form_validation->set_rules('mode', '', 'required');
		$this->form_validation->set_rules('u_name_vn', '', 'required');
		$this->form_validation->set_rules('u_name_en', '', 'required');
		$this->form_validation->set_rules('u_program_name_vn', '', 'required');
		$this->form_validation->set_rules('u_program_name_en', '', 'required');
		$this->form_validation->set_rules('u_lat', '', 'required');
		$this->form_validation->set_rules('u_lng', '', 'required');
		//$this->form_validation->set_rules('u_logo', '', 'required');
		//$this->form_validation->set_rules('u_image', '', 'required');
		if ($this->form_validation->run() == false) {
			$data = $this->_set_meta_data(array('title'=>'한국대 등록'));
			$data['active'] 		= 'univ';
	        $data['sub_active']     = 'univ_write';
			if ($univ_result) $data['univ']	= $univ_result;
			$this->_getPageLayout((($univ_result)?'univ_modify':'univ_write'), $data);
		} else {
			$this->load->library('fileupload_new3');
			$config = array(
				'upload_path' => './assets/img/univ',
				'allowed_types'	=> 'gif|jpg|png',
				'max_size' 		=> 2045,
				'encrypt_name' 	=> true
			);
			$upload_result = $this->fileupload_new3->upload($_FILES, $config, 't_image', '', true);
			$mode = $this->input->post('mode');
			if ($mode=='modify') {
				// 수정
				if ($this->univ_model->modify_univ($this->input->post(NULL, TRUE), $upload_result)){
					$this->session->set_flashdata('message', '수정완료');
				}else{
					$this->session->set_flashdata('message', 'MYSQL SERVER ERROR TRY AGAIN');
				}
				redirect(site_url().'homeAdm/univ/write/'.$this->input->post('u_id'));
			} else {
				// 새로 등록
				if ($this->univ_model->insert_univ($this->input->post(NULL, TRUE), $upload_result)){
					$this->session->set_flashdata('message', '등록완료');
				}else{
					$this->session->set_flashdata('message', 'MYSQL SERVER ERROR TRY AGAIN');
				}
				redirect(site_url().'homeAdm/univ/list/1');
			}
		}
    }
	// ckeditor 이미지파일업로드
	public function upload_imgfile_ckeditor()
	{
		$config['upload_path'] = './assets/img/ckeditor/univ';
		$config['allowed_types'] = 'gif|jpg|png';
		$config['max_size'] = '1024';
		$config['encrypt_name'] = TRUE;
		$this->load->library('upload', $config);
		if (!is_dir($config['upload_path'])) {
			@mkdir($config['upload_path'], 0777, true);
		}
		if (! $this->upload->do_upload('upload')) {
			$error = $this->upload->display_errors('','');
			echo "<script>alert('".$error."'); </script>";
			$this->callback_ckeditor_upload_csrf();
			echo $error;
			return false;
		} else {
			$CHEditorFuncNum = $this->input->get('CKEditorFuncNum');
			$data = $this->upload->data(); //array('upload_data'=>$this->upload->Data());
			$filename = $data['file_name'];

			$url = '/assets/img/ckeditor/univ/'.$filename;
			// 에디터에서 업로드시킨 파일들을 저장시킨다 .. 이유는 폼전송시 실제로 넘어온 이미지와 미리보기시 이미지를 비교해 삭제된 이미지는 서버에서 삭제하기 위해서
			echo "<script type='text/javascript'>
					window.parent.CKEDITOR.tools.callFunction('".$CHEditorFuncNum."', '".$url."', '".stripslashes($this->lang_message['complete_registration'])."');
					var imgfilename = window.parent.getIds('copyImgFileNames').value;
					var imgfile = (imgfilename !== '') ? ',".$filename."' : '".$filename."';
					imgfilename += imgfile;
					window.parent.getIds('copyImgFileNames').value = imgfilename;
				</script>";
			$this->callback_ckeditor_upload_csrf();
			return true;
		}
	}
	// 관리자 페이지 셋팅
	private function getPageLayout($page, $data, $another_path=false)
	{
		$data['check_adm_lv'] = $this->session->userdata('user_level');
		$this->load->view('adm/header', $data);
		if ($another_path) {
			$this->load->view($page, $data);
		} else {
			$this->load->view('adm/'.$page, $data);
		}
		$this->load->view('adm/footer', $data);
	}
}
?>
