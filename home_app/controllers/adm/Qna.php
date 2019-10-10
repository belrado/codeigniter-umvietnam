<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Qna extends MY_Controller{
	private $de_user_type = null;
	private $security_lv1 = 8;
	private $security_lv2 = 9;
	public $super_check = false;
	public function __construct(){
		parent::__construct();
		$this->de_user_type = $this->encryption->decrypt($this->session->userdata('user_type'));
		// 관리자인지 확인
		$this->_check_security_master($this->de_user_type, $this->encryption->decrypt($this->session->userdata('user_id')));
		if($this->de_user_type === HOME_PREFIX."superMaster"){
			$this->super_check = true;
		}
		$this->load->helper('form');
		$this->load->library('form_validation');
		$this->load->model('board_model');

	}
	public function index(){
		redirect(site_url().'homeAdm/qna/list', 'location', 302);
	}
	public function bbs_update(){

	}
	public function list($page=1){
		$cate 			= 'all';
		$bbs_table 		= 'qna';
		// 검색
		$sch_select 	= ($this->input->get('select')) ? trim(get_search_string($this->input->get('select'))) : '';
		$keyword 		= ($this->input->get('keyword')) ? get_search_string(clean_xss_tags(trim($this->input->get('keyword')))) : '';
		$result 		= $this->board_model->get_board('qna');
		$pageLimitNum = $result[0]->bbs_list_num;
		$this->load->library('paging');
		$total			= $this->board_model->get_board_list_totalnum($bbs_table, $cate, $sch_select, $keyword);
		$this->paging->paging_setting($total, $page, $pageLimitNum, 5);
		$page_limit 	= $this->paging->get_page_limit();
		$page_list  	= $this->paging->get_page_list();
		// 게시판설정에서 1뎁스 메뉴가 있다면 해당 메뉴의 이름을 가져와서 셋팅한다. 아이디로 지정한 이유는 메뉴 이름이 바뀔수가 있기 때문에..
		$data = $this->_set_meta_data(array('title'=>'QNA'));
		$data['active'] 			= 'qna';
		$data['list_num']			= $total - $page_limit;
		$data['bbs_total_num']  	= $total;
		$db_select = "bbs_id, bbs_secret, bbs_num, bbs_index, bbs_parent, bbs_comment, bbs_cate, bbs_link, bbs_subject, bbs_thumbnail, bbs_hit, bbs_file, bbs_extra1, u.user_id, u.user_name, u.user_email, bbs_pwd, bbs_register";
		$data['bbs_result'] 		= $this->board_model->get_write_board_list($bbs_table, $page_limit, $page_list, $cate, $sch_select, $keyword, fnc_set_htmls_strip($result[0]->bbs_sort_type), $db_select);
		$data['paged']				= $page;
		// 게시판 타입이 토글형식일때 파일이 있는지
		$data['bbs_result_file'] 	= ($result[0]->bbs_type === "toggle") ? $this->board_model->get_bbs_files($this->db->dbprefix('write_'.$bbs_table), 0, 'files') : false;
		//$data['list_result'] 		= $this->review_model->get_review_list($page_limit, $page_list);
		//$data['paging_show']   		= $this->paging->get_paging(site_url()."board/list/".$bbs_table."/".$cate."/", '', 'paging-nav-typeA');
		$data['paging_show']   		= $this->paging->get_paging(site_url()."homeAdm/qna/", '?select='.$sch_select.'&amp;keyword='.$keyword, 'paging-nav-typeA');
		// 검색어
		$data['sch_select']			= $sch_select;
		$data['keyword']			= $keyword;
		// 카테고리와 검색어 인클루드
		ob_start();
		$data['cate_seach_sec']		= $this->load->view('board/search_html', $data, true);
		ob_end_clean();
		$this->getPageLayout('qna_list', $data);
	}
	public function view($bbs_id=''){
		$result = $this->board_model->get_write_board_user('qna', $bbs_id);
		if(!is_numeric($bbs_id) || !$result){
			$this->session->set_flashdata('message', '게시글이 없습니다.');
			redirect(site_url().'homeAdm/qna');
		}else{
			if($result[0]->bbs_extra1 != 'read' || $result[0]->bbs_extra1 != 'done'){
				if(!$this->board_model->put_extra1_column('qna', $result[0]->bbs_id, 'read')){
					return false;
				}
			}
			$data = $this->_set_meta_data(array('title'=>fnc_set_htmls_strip($result[0]->bbs_subject, true)));
			$data['active'] = 'qna';
			$data['bbs_result']	= $result[0];
			$data['reply']	= $this->board_model->get_reply_single('qna', $result[0]->bbs_id);
			$data['bbs_mode']	= ($data['reply'])?'modify':'insert';
			$data['bbs_result_file']	= ($result[0]->bbs_file > 0) ? $this->board_model->get_bbs_files($this->db->dbprefix('write_qna'), $bbs_id, 'files') : false;
			$this->getPageLayout('qna_view', $data);
		}
	}
	// ckeditor 이미지파일업로드
	public function upload_imgfile_ckeditor(){
		$config['upload_path'] = './assets/img/ckeditor/qna';
		$config['allowed_types'] = 'gif|jpg|png';
		$config['max_size'] = '1024';
		$config['encrypt_name'] = TRUE;
		$this->load->library('upload', $config);
		if(!is_dir($config['upload_path'])){
			@mkdir($config['upload_path'], 0777, true);
		}
		if(! $this->upload->do_upload('upload')){
			$error = $this->upload->display_errors('','');
			echo "<script>alert('".$error."'); </script>";
			$this->callback_ckeditor_upload_csrf();
			echo $error;
			return false;
		}else{
			$CHEditorFuncNum = $this->input->get('CKEditorFuncNum');
			$data = $this->upload->data(); //array('upload_data'=>$this->upload->Data());
			$filename = $data['file_name'];

			$url = '/assets/img/ckeditor/qna/'.$filename;
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
	private function getPageLayout($page, $data, $another_path=false){
		$data['check_adm_lv'] = $this->session->userdata('user_level');
		$this->load->view('adm/header', $data);
		if($another_path){
			$this->load->view($page, $data);
		}else{
			$this->load->view('adm/'.$page, $data);
		}
		$this->load->view('adm/footer', $data);
	}
}
?>
