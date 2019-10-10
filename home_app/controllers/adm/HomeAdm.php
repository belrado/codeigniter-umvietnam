<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class HomeAdm extends MY_Controller{
	private $de_user_type = null;
	private $security_lv1 = 8;
	private $security_lv2 = 9;
	private $naverSyndication = false;
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
		// 신디케이션 사용유무
		$this->naverSyndication = true;
	}
	public function index(){
		$this->load->model('board_model');
		$this->load->library('log_security_block');

		$bbs_result = $this->board_model->get_board_list();
		if($bbs_result){
			for($i=0; $i<count($bbs_result); $i++){
				$bbs_result[$i]->bbs_message_total = $this->board_model->get_board_list_totalnum($bbs_result[$i]->bbs_table);
			}
		}
		$data = array(
			'title' => 'UMV 관리자',
			'block_id_list' => $this->log_security_block->get_block_id_file(),
			'block_ip_list' => $this->log_security_block->get_block_ip_file(),
			'adm_name'		=> $this->session->userdata('user_name'),
			'home_bbs'		=> $bbs_result,
			'active'=>''
		);
		$this->_getPageLayout('main', $data);
	}
	// 차단유저, 차단 아이피
	public function admin_block_user(){
		$this->form_validation->set_rules('blockchk[]', '차단항목 선택', 'required');
		if($this->form_validation->run() == FALSE){
			$this->session->set_flashdata('message', '선택된 항목이 없습니다.');
			redirect(site_url()."homeAdm/");
		}else{
			$this->load->library('log_security_block');
			$check_len = 0;
			$re_data = '';
			$type = $this->input->post('type');
			$blockchk = $this->input->post('blockchk');
			$block_data = ($type=='block_ip')?$this->log_security_block->get_block_ip_file():$this->log_security_block->get_block_id_file();
			for($i=0; $i< count($block_data); $i++){

				if(!in_array($i, $blockchk)){
					if($check_len == 0){
						$re_data .= $block_data[$i];
					}else{
						$re_data .= ','.$block_data[$i];
					}
					$check_len++;
				}
			}
			$this->log_security_block->delete_block_user_file($type, $re_data);
			$this->session->set_flashdata('message', '선택된 항목의 차단을 해제하였습니다.');
			redirect(site_url()."homeAdm/");
		}
	}
	// 에러로그기록
	public function error_log($page=1){
		$this->_check_security_master_lv(9);
		$this->load->model('logrecord_model');
		$this->load->library('paging');
		$total		= $this->logrecord_model->get_total_row();
		$this->paging->paging_setting($total, $page, 12, 5);
		$page_limit = $this->paging->get_page_limit();
		$page_list  = $this->paging->get_page_list();
		$data = array(
			'title' 		=> HOME_INFO_NAME.' 에러로그기록',
			'active'		=> 'error_log',
			'list_num' 		=> $total - $page_limit,
			'log_results' 	=> $this->logrecord_model->get_logrecord($page_limit, $page_list),
			'paging_show'   => $this->paging->get_paging("/homeAdm/error_log/")
		);
		$this->_getPageLayout('error_log', $data);
	}
	// 홈페이지 글로벌메뉴
	public function nav(){
		$this->_check_security_master_lv(10);
		$result = $this->_getNav();
		$data = array(
			'title' 		=> 'UMV NAV',
			'active'		=> 'nav',
			'mp_nav' 		=> $result
		);
		$this->_getPageLayout('nav', $data);
	}
	// 글로벌메뉴 업데이트
	public function nav_update(){
		$this->_check_security_master_lv(10);
		$this->load->model('globalnav_model');
		$type = $this->input->post('nav_type');
		$mode = $this->input->post('nav_mode');
		if($type == 'ajax'){
			if($mode == 'insert'){
				$this->form_validation->set_rules('nav_link', 'link', 'required');
				$this->form_validation->set_rules('nav_name_ko', 'Korean name', 'required');
				$this->form_validation->set_rules('nav_name_en', 'English name', 'required');
				$this->form_validation->set_rules('nav_name_vn', 'Vietnamese name', 'required');
				if($this->form_validation->run() == FALSE){
					die('ajax error.');
				}else{
					$result = $this->globalnav_model->nav_insert($this->input->post(NULL, TRUE));
					if(!$result){
						die('ajax error.');
					}else{
						$result_arr = array();
						foreach($result as $val){
							$arr = array();
							foreach($val as $key=>$val2){
								$arr[$key] = preg_replace('/\r\n|\r|\n/',' ', fnc_set_htmls_strip($val2, true));
							}
							$result_arr[] = $arr;
						}
						$result_arr = json_encode($result_arr);
						echo "{ \"nav_list\": ";
						echo $result_arr.",\n";
						echo "\"nav_all\": ";
						echo json_encode($this->_getNav()).",\n";
						echo "\"nav_token\": ";
						echo json_encode(array(array('nav_token'=>$this->security->get_csrf_hash())))."\n";
						echo "}";
					}
				}
			}else if($mode == 'delete'){
				$result = $this->globalnav_model->nav_delete($this->input->post(NULL, TRUE));
				if($result && $this->naverSyndication){
					// 신디케이션 삭제
				}
				$result_arr = array();
				$arr = array(
					'result' =>$result,
					'nav_token'=>$this->security->get_csrf_hash()
				);
				$result_arr[]=$arr;
				$result_arr = json_encode($result_arr);
				echo "{ \"del_result\": ";
				echo $result_arr.", \n";
				echo "\"nav_all\": ";
				echo json_encode($this->_getNav())."\n";
				echo "}";
			}else{
				die('ajax error.');
			}
		}else{
			// javascript 안될때... 일단은 에러, 그리고 메뉴수정은 폼전송 방식으로
			if($mode == 'insert'){
				$this->form_validation->set_rules('nav_link', 'link', 'required');
				$this->form_validation->set_rules('nav_name_ko', 'Korean name', 'required');
				$this->form_validation->set_rules('nav_name_en', 'English name', 'required');
				$this->form_validation->set_rules('nav_name_vn', 'Vietnamese name', 'required');
				if($this->form_validation->run() == FALSE){
					$this->session->set_flashdata('message', '필수 입력사항 누락');
					redirect(site_url().'homeAdm/nav');
				}else{
					if( $this->globalnav_model->nav_insert($this->input->post(NULL, TRUE))){
						$this->session->set_flashdata('message', '등록완료');
					}else{
						$this->session->set_flashdata('message', 'SQL ERROR.');
					}
					redirect(site_url().'homeAdm/nav');
				}
			}else if($mode == 'update'){
				// 1뎁스메뉴
				$this->form_validation->set_rules('nav_id[]', '분류', 'required|numeric');
				$this->form_validation->set_rules('nav_index[]', '분류', 'required');
				$this->form_validation->set_rules('nav_name_ko[]', '분류', 'required');
				$this->form_validation->set_rules('nav_name_en[]', '분류', 'required');
				$this->form_validation->set_rules('nav_name_vn[]', '분류', 'required');
				$this->form_validation->set_rules('nav_access[]', '분류', 'required');
				$this->form_validation->set_rules('nav_link[]', '분류', 'required');
				// 2뎁스메뉴
				$this->form_validation->set_rules('navsub_id[]', '분류', 'required|numeric');
				$this->form_validation->set_rules('navsub_index[]', '분류', 'required');
				$this->form_validation->set_rules('navsub_name_ko[]', '분류', 'required');
				$this->form_validation->set_rules('navsub_name_en[]', '분류', 'required');
				$this->form_validation->set_rules('navsub_name_vn[]', '분류', 'required');
				$this->form_validation->set_rules('navsub_access[]', '분류', 'required');
				$this->form_validation->set_rules('navsub_link[]', '분류', 'required');
				if($this->form_validation->run() == FALSE){
					$this->session->set_flashdata('message', '입력사항 오류');
					redirect(site_url()."homeAdm/nav");
				}else{
					$result = $this->globalnav_model->nav_modify($this->input->post(NULL, TRUE));
					if($result){
						redirect(site_url()."homeAdm/nav");
					}else{
						$this->session->set_flashdata('message', 'SQL CONNECTION ERROR. TRY AGAIN');
						redirect(site_url()."homeAdm/nav");
					}
				}
			}else{
				redirect(site_url()."homeAdm/nav");
			}
		}
	}
	// 게시판 관리
	public function bbs(){
		$this->_check_security_master_lv(10);
		$this->load->model('board_model');
		$result_list = $this->board_model->get_board_list();
		$data = array(
				'title' 		=> HOME_INFO_NAME.' 게시판관리',
				'active'		=> 'bbs',
				'bbs_result' 	=> $result_list
			);
		$this->_getPageLayout('bbs_list', $data);
	}
	// 게시판 관리 삭제
	public function bbs_delete(){
		// 등급 관리권한 부여
		$this->_check_security_master_lv(10);
		$chk = $this->input->post('chk[]');
		if(count($chk)< 1){
			$this->session->set_flashdata('message', '선택된 항목이 없습니다.');
			redirect(site_url().'homeAdm/bbs');
		}else{
			$this->load->model('board_model');
			if($this->board_model->board_delete($this->input->post(NULL, TRUE))){
				$this->session->set_flashdata('message', '선택된 항목 삭제완료.');
			}else{
				$this->session->set_flashdata('message', 'SQL ERROR. 잠시 후 다시 시도해 주세요.');
			}
			redirect(site_url().'homeAdm/bbs');
		}
	}
	// 게시판 관리 업데이트
	public function bbs_update($bbs_mode='insert', $bbs_table = ''){
		// 관리자등급
		$this->_check_security_master_lv(10);
		$this->load->model('board_model');
		$this->load->model('globalnav_model');
		$data = array(
			'title' 			=> '게시판 '.$bbs_mode,
			'active'			=> 'bbs',
			'mode' 				=> $bbs_mode,
			'bbs_table' 		=> '',
			'bbs_name_ko'		=> '',
			'bbs_name_en'		=> '',
			'bbs_name_vn'		=> '',
			'bbs_type' 			=> '',
			'bbs_1depth'		=> '',
			'bbs_page_tophtml'  => '',
			'bbs_cate_list'		=> '',
			'bbs_list_lv'		=> '',
			'bbs_read_lv'		=> '',
			'bbs_write_lv'		=> '',
			//'bbs_reply_lv'		=> '',
			'bbs_comment_lv'	=> '0',
			'bbs_list_num' 		=> 15,
			'bbs_feed'			=> '',
			'bbs_syndication'	=> ''
		);
		$data['nav_1depth'] = $this->globalnav_model->nav_get_list('all', '1depth');
		if($bbs_mode == 'insert'){
			$this->load->database();
			$this->form_validation->set_rules('bbs_table', '게시판 아이디', 'required|min_length[3]|max_length[20]|alpha_dash|is_unique[psu_board_group.bbs_table]');
		}else if($bbs_mode == 'modify'){
			if(empty($bbs_table)){
				$this->session->set_flashdata('message', '선택된 게시판이 없습니다.');
				redirect(site_url().'homeAdm/bbs');
			}
			$this->form_validation->set_rules('bbs_table', '게시판 아이디', 'required|min_length[3]|max_length[20]|alpha_dash');
			$this->form_validation->set_rules('bbs_type', '게시판타입', 'required');
			$this->form_validation->set_rules('bbs_list_lv', '게시판목록등급', 'required|numeric');
			$this->form_validation->set_rules('bbs_read_lv', '개시판읽기등급', 'required|numeric');
			$this->form_validation->set_rules('bbs_write_lv', '게시판쓰기등급', 'required|numeric');
			//$this->form_validation->set_rules('bbs_reply_lv', '게시판답변등급', 'required|numeric');
			$this->form_validation->set_rules('bbs_comment_lv', '게시판댓글등급', 'required|numeric');
			$this->form_validation->set_rules('bbs_list_num', '목록수', 'required|numeric');
			$bbs_result = $this->board_model->get_board($bbs_table);
			if($bbs_result){
				if(count($bbs_result) > 0 && !empty($bbs_result)){
					foreach($bbs_result[0] as $key=>$val){
						$data[$key] = fnc_set_htmls_strip($val);
					}
				}
			}
		}
		$this->form_validation->set_rules('bbs_name_ko', '게시판 제목', 'required');
		$this->form_validation->set_rules('bbs_name_en', '게시판 제목', 'required');
		$this->form_validation->set_rules('bbs_name_vn', '게시판 제목', 'required');
		if($this->form_validation->run() == FALSE){
			if($this->input->post('bbs_table')){
				$data['alert_message'] = trim(strip_tags(validation_errors()));
			}

			$this->_getPageLayout('bbs_update', $data);
		}else{
			if($bbs_mode == 'insert'){
				$result = $this->board_model->board_update($this->input->post(NULL, FALSE));
			}else if($bbs_mode == 'modify'){
				$result = $this->board_model->board_update($this->input->post(NULL, FALSE));
			}else{
				$this->session->set_flashdata('message', '선택된 게시판이 없습니다.');
				redirect(site_url().'homeAdm/bbs');
			}
			if($result){
				$message = ($bbs_mode == 'insert') ? '게시판 생성완료' : '게시판 수정완료';
				$this->session->set_flashdata('message', $message);
			}else{
				$this->session->set_flashdata('message', 'SQL ERROR. 잠시 후 다시 시도해 주세요.');
			}
			redirect(site_url().'homeAdm/bbs');
		}
	}
	public function image_upload(){
		$this->_check_security_master_lv(8);
		if(isset($_SERVER['HTTP_REFERER']) && preg_match ("/".$_SERVER['HTTP_HOST']."/", $_SERVER['HTTP_REFERER'])){
			$this->load->model('teacher_model');
			$this->load->library('fileupload_new');
			$config = array(
				'upload_path' => './assets/img/teacher/ajax',
				'allowed_types'	=> 'gif|jpg|png',
				'max_size' 		=> 4045,
				'encrypt_name' 	=> false
				//'overwrite'		=> true
			);
			$upload_result = $this->fileupload_new->upload($_FILES, $config, 'uploadfile');
			if($upload_result['is_error']==='none'){
				if($this->teacher_model->set_ajax_teacher_photo($this->input->post(null, true), $upload_result['uploadfile'])){
					echo "{\"image_path\": ";
					echo json_encode($upload_result['uploadfile'][0]['full_path']).",\n";
					echo "\"image_name\": ";
					echo json_encode($upload_result['uploadfile'][0]['file_name']).",\n";
				}else{
					echo "{";
					echo "\"error_msg\": ";
					echo json_encode('SQL ERROR.')."\n";
					@unlink($upload_result['uploadfile'][0]['full_path']);
				}
			}else{
				echo "{";
				echo "\"error_msg\": ";
				echo json_encode($upload_result['error_msg'])."\n";
			}
			echo "\"token\": ";
			echo json_encode($this->security->get_csrf_hash())."\n";
			echo "}";
		}else{
			show_404();
		}
	}
	/* 신디케이트 설정 */
	public function get_syndication_webdata($link=''){
		$this->load->library('crawling');
		//$this->input->post('link');
		$link = 'http://psuedu.org/sat/summer';
		$results = $this->crawling->get_homecontents($link);

		//$rex="/\<div id=\"contents\"\>(.*)\<\/div\>/";
		//preg_match_all($rex, $results, $match);
		print_r( $results);
		//echo htmlspecialchars($results[0]['text']);

	}
	public function syndication($cate=0){
		if($this->naverSyndication){
			$this->load->library('syndication');
			$this->load->model('globalnav_model');
			$this->load->model('syndication_model');
			$nav_result = $this->globalnav_model->nav_get_list('all', 'all');
			$sub_nav = array();
			$pate_title = '';
			foreach($nav_result as $val){
				if($cate == $val->nav_id){
					$pate_title = $val->nav_name;
				}
				if($val->nav_parent !=0 && $val->nav_parent == $cate){
					$sub_nav[] = $val;
				}
			}
			$syndi_data 	= '';
			$syndi_parent	= '';
			if(count($sub_nav)> 0){
				$syndi_parent 	= $this->syndication_model->get(0, $cate);
				$syndi_data 	= $this->syndication_model->get($cate, 0);
			}
			$data 		= array(
				'title' 		=> '네이버 신디케이션설정',
				'active'		=> 'syndication',
				'syndi_use'		=> $this->naverSyndication,
				'nav'			=> $nav_result,
				'sun_nav'		=> $sub_nav,
				'syndi_parent'	=> $syndi_parent,
				'syndi_data'	=> $syndi_data,
				'cate'			=> $cate,
				'page_tit'		=> $pate_title
			);
		}else{
			$data = array(
				'title'			=> '네이버 신디케이션설정',
				'active'		=> 'syndication',
				'syndi_use'		=> $this->naverSyndication
			);
		}
		$this->_getPageLayout('syndication', $data);
	}
	public function syndication_update(){
		if($this->naverSyndication){
			$this->form_validation->set_rules('nav_parent', '' ,'required');
			$this->form_validation->set_rules('syn_num', '' ,'required');
			$this->form_validation->set_rules('syn_title', '' ,'required');
			$this->form_validation->set_rules('syn_link', '' ,'required');
			$this->form_validation->set_rules('syn_use', '' ,'required');
			$this->form_validation->set_rules('rss_use', '' ,'required');
			$this->form_validation->set_rules('syn_content', '' ,'required');
			if($this->form_validation->run()){
				$this->session->set_flashdata('message', '필수항목누락');
				if($this->input->post('nav_parent')){
					redirect(site_url().'homeAdm/syndication/'.$this->input->post('nav_parent'));
				}else{
					redirect(site_url().'homeAdm/syndication');
				}
			}else{
				$this->load->model('syndication_model');
				if($this->syndication_model->put($this->input->post(null, true))){
					$this->session->set_flashdata('message', $this->input->post('syn_title').' 수정완료');
				}else{
					$this->session->set_flashdata('message', 'SQL ERROR. 잠시 후 다시 시도해주세요.');
				}
				redirect(site_url().'homeAdm/syndication/'.$this->input->post('nav_parent'));
			}
		}else{
			redirect(site_url());
		}
	}
	public function syndication_ping(){
		if($this->naverSyndication){
			$this->form_validation->set_rules('cate', '' ,'required|numeric');
			if($this->form_validation->run()==false){
				$this->session->set_flashdata('message', '핑 전송 실패 (필수항목 누락)');
				redirect(site_url().'homeAdm/syndication/');
			}else{
				$this->load->library('syndication');
				$results = $this->syndication->sendPing($this->input->post('cate'));
				$this->session->set_flashdata('message', $results);
				redirect(site_url().'homeAdm/syndication/'.$this->input->post('cate'));
			}
		}else{
			redirect(site_url());
		}
	}
	// ckeditor 이미지파일업로드
	public function upload_imgfile_ckeditor($itemcode=''){
		$item_dir_path = $this->product_file_mkdir($itemcode);
		$config['upload_path'] = (!empty($item_dir_path))?$item_dir_path:'./assets/img/ckeditor/';
		$config['allowed_types'] = 'gif|jpg|png';
		// 허용되는 파일의 최대 사이즈
		$config['max_size'] = '1024';
		// 이미지인 경우 허용되는 최대 폭
		$config['max_width']  = '2024';
		// 이미지인 경우 허용되는 최대 높이
		$config['max_height']  = '2024';
		$config['encrypt_name'] = TRUE;
		$this->load->library('upload', $config);

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
			if(!empty($itemcode)){
				$url = '/assets/items/'.$itemcode.'/'.$filename;
			}else{
				$url = '/assets/img/ckeditor/'.$filename;
			}
			// 에디터에서 업로드시킨 파일들을 저장시킨다 .. 이유는 폼전송시 실제로 넘어온 이미지와 미리보기시 이미지를 비교해 삭제된 이미지는 서버에서 삭제하기 위해서
			echo "<script type='text/javascript'>
					window.parent.CKEDITOR.tools.callFunction('".$CHEditorFuncNum."', '".$url."', '이미지 등록완료');
					var imgfilename = window.parent.copyImgFileNames.value;
					var imgfile = (imgfilename !== '') ? ',".$filename."' : '".$filename."';
					imgfilename += imgfile;
					window.parent.copyImgFileNames.value = imgfilename;
				</script>";
			$this->callback_ckeditor_upload_csrf();
			return true;
		}
	}
	// 상품등록시 이미지파일 폴더생성
	private function product_file_mkdir($itemcode=''){
		if(!empty($itemcode)){
			$item_dir_path = FCPATH.'assets/items/';
			if(!is_dir($item_dir_path)){
				@mkdir($item_dir_path, 0777, true);
			}else{
				$item_dir_path = $item_dir_path.$itemcode.'/';
				if(!is_dir($item_dir_path)){
					@mkdir($item_dir_path, 0777, true);
				}
				$item_dir_path = './assets/items/'.$itemcode.'/';
				return $item_dir_path;
			}
		}else{
			return '';
		}
	}
	private function callback_ckeditor_upload_csrf(){
		echo "<script>window.parent.".$this->security->get_csrf_token_name().".value='".$this->security->get_csrf_hash()."';</script>";
	}
	/** 엑셀파일 다운 예제
	public function presentation_excel(){
		$this->load->library('phpexcel_home');
		$cell_name = array(
			'이름',
			'이름(영문)',
			'학생학력',
			'관계',
			'휴대폰번호',
			'이메일',
			'관심분야',
			'참석인원수',
			'정보취득경로',
			'설명회일시',
			'셜명회장소',
			'등록일'
		);
		$data 	= $this->register_model->get_presentation_excelfile($this->input->post(NULL, TRUE));
		$start 	= $this->input->post('p_begin');
		$end 	= $this->input->post('p_end');
		$filename = '설명회예약목록('.$start.'-'.$end.')';
		$data_row = array();
		foreach($data as $val){
			$data_row[] = array(
				stripslashes($val->u_name),
				stripslashes($val->u_name_en),
				stripslashes($val->u_aca),
				stripslashes($val->u_relation),
				stripslashes(set_change_phonenumber_type($val->u_phone)),
				stripslashes($val->u_email),
				stripslashes($val->u_field),
				stripslashes($val->u_attendance ),
				stripslashes($val->u_search),
				stripslashes($val->p_day),
				stripslashes('['.$val->p_location.'] '.$val->p_address.' / '.$val->p_place),
				stripslashes($val->u_register)
			);
		}
		$this->phpexcel_home->down_excelfile($filename, $cell_name, $data_row);
	}
	*/
	/* 설명회 */
	public function presentation($pmode ='view', $day='all', $page=1){
		$this->_check_security_master_lv(8);
		$this->load->library('paging');
		$day = ($day ==0)?'all':$day;

		$stype 	= ($this->input->get('stype'))?addslashes($this->input->get('stype')) : '';
		$svalue = ($this->input->get('svalue'))?get_search_string(clean_xss_tags(addslashes($this->input->get('svalue')))):'';

		$total			= $this->register_model->get_presentation_user_total($day, $stype, $svalue);

		$this->paging->paging_setting($total, $page, 30, 5);
		$page_limit 	= $this->paging->get_page_limit();
		$page_list  	= $this->paging->get_page_list();
		$list_result 	= $this->register_model->get_presentation_user($page_limit, $page_list, $day, null, $stype, $svalue);
		$p_result    	= '';
		$p_day 			= '';
		if($day == 'all'){
			$p_day_txt = '전체';
			$page_title = '설명회/간담회 예약자';
		}else{
			if(!$list_result){
				// inner join 결과가 없다면 설명회 일정만 따로 뿌려줘야해서
				$p_result 	= $this->register_model->get_presentation_single($day);
				if($p_result){
					$p_day_txt	= '['.fnc_set_htmls_strip($p_result->p_location).'] '.fnc_replace_getday(explode(" ", $p_result->p_day)[0]).' '.fnc_replace_gettime(explode(" ", $p_result->p_day)[1]);
				}
			}else{
			    $p_result 	= $this->register_model->get_presentation_single($day);
				$p_day_txt	= '['.fnc_set_htmls_strip($list_result[0]->p_location).'] '.fnc_replace_getday(explode(" ", $list_result[0]->p_day)[0]).' '.fnc_replace_gettime(explode(" ", $list_result[0]->p_day)[1]);
			}
			$page_title = '설명회 예약자';
		}
		// 같은 일정끼리 묶어
		$list_result_c = array();
		if(!is_numeric($day)){
			for($i=0; $i<count($list_result); $i++){
				if($i == 0){
					$list_result_c[$i] = $list_result[$i]->p_day;
				}
				for($j=0; $j < count($list_result_c); $j++){
					if($list_result_c[$j] !== $list_result[$i]->p_day){
						$check = true;
					}else{
						$check = false;
					}
				}
				if($check) array_push($list_result_c, $list_result[$i]->p_day);
			}
		}
		$data = array(
		    'title' 		=> $page_title,
			'active'		=> 'presentation',
			'sub_active'	=> 'presentation',
			'pmode'			=> $pmode,
			'page'			=> $page,
			'day'			=> $day,
			'p_day_txt'		=> (isset($p_day_txt)?$p_day_txt:''),
			'total'			=> $total,
			'list_num' 		=> $total - $page_limit,
			'p_list'		=> $this->register_model->get_presentation_day('', '', '', '', false, 'p_id, p_day, p_location, p_place, p_use', 'yes'),
			'list_result' 	=> $list_result,
			'p_result'		=> $p_result,
			'stype'			=> $stype,
			'svalue'		=> $svalue,
			'list_day_arr'	=> $list_result_c,
			'paging_show'   => $this->paging->get_paging('/homeAdm/presentation/'.$pmode.'/'.$day.'/', '?stype='.$stype.'&amp;svalue='.$svalue)
		);
		$this->_getPageLayout('presentation', $data);
	}
	public function presentation_view($p_id=null, $u_id=null){
		$this->_check_security_master_lv(8);

		if(!is_numeric($u_id) || !is_numeric($p_id)){
			redirect(site_url());
		}
		$result = $this->register_model->get_presentation_user(0, 1, $p_id, $u_id);
		if($result && count($result)>0){
			// $pmode = 예약자 보기에서 view or modify -> 수정모드인지 보기모드인지 비교하기위해
			$pmode 	= $this->input->get('pmode');
			// $day = all or p_id -> 예약자 전체보기할건지 해당 일정아이디로 조인해서 보여줄건지 비교
			$day 	= $this->input->get('day');
			// $page = 페이징 넘버
			$page 	= $this->input->get('page');
			$data = array(
				'title' 		=> $result[0]->u_name,
				'active'		=> 'presentation',
				'sub_active'	=> 'presentation',
				'pmode'			=> $pmode,
				'page'			=> $page,
				'page_day'		=> $day,
				'u_id'			=> $u_id,
				'p_list'		=> $this->register_model->get_presentation_day('', '', '', '', false, 'p_id, p_day, p_location, p_place, p_use', 'yes'),
				'p_day'			=> fnc_replace_getday(explode(" ", $result[0]->p_day)[0]),
				'p_time'		=> fnc_replace_gettime(explode(" ", $result[0]->p_day)[1]),
				'result' 		=> $result
			);
			$this->_getPageLayout('presentation_view', $data);
		}else{
			redirect(site_url());
		}
	}
	public function presentation_day($pmode ='view', $page = 1){
		$this->_check_security_master_lv(8);
		$this->load->library('paging');

		$begin		= ($this->input->get('begin'))?$this->input->get('begin'):'';
		$end		= ($this->input->get('end'))?$this->input->get('end'):'';
		$total		= $this->register_model->get_presentation_day_total($begin, $end);

		$this->paging->paging_setting($total, $page, 14, 5);
		$page_limit = $this->paging->get_page_limit();
		$page_list  = $this->paging->get_page_list();

		$data = array(
			'title' 		=> '설명회일정',
			'active'		=> 'presentation',
			'sub_active'	=> 'presentation_list',
			'begin'			=> $begin,
			'end'			=> $end,
			'pmode'			=> $pmode,
			'page'			=> $page,
			'total'			=> $total,
			'list_num' 		=> $total - $page_limit,
			'list_result' 	=> $this->register_model->get_presentation_day($page_limit, $page_list, $begin, $end, true),
			'paging_show'   => $this->paging->get_paging('/homeAdm/presentation_day/'.$pmode.'/', '?begin='.$begin.'&amp;end='.$end)
		);

		$this->_getPageLayout('presentation_day', $data);
	}
	// 설명회일정 수정
	public function presentation_update(){
		$this->_check_security_master_lv(9);
		if($this->input->post('mode') == 'insert'){
			$this->form_validation->set_rules('p_name[]', '설명회이름', 'required');
			$this->form_validation->set_rules('p_use[]', '설명회사용', 'required');
			$this->form_validation->set_rules('p_day[]', '설명회일정', 'required');
			$this->form_validation->set_rules('p_time[]', '설명회시간', 'required');
			$this->form_validation->set_rules('p_address[]', '설명회장주소', 'required');
			$this->form_validation->set_rules('p_place[]', '설명회장장소', 'required');
			$this->form_validation->set_rules('p_posx[]', '셜명회좌표', 'required');
			$this->form_validation->set_rules('p_posy[]', '셜명회좌표', 'required');
			$p_massge = '설명회 등록완료';
			$link = site_url().'homeAdm/presentation_day';
		}else if($this->input->post('mode') == 'modify'){
			$this->form_validation->set_rules('p_chk[]', '선택', 'required');
			foreach($this->input->post('p_chk') as $val){
				$this->form_validation->set_rules('p_name_'.$val, '설명회이름', 'required');
				$this->form_validation->set_rules('p_use_'.$val, '설명회사용', 'required');
				$this->form_validation->set_rules('p_day_'.$val, '설명회일정', 'required');
				$this->form_validation->set_rules('p_address_'.$val, '설명회장주소', 'required');
				$this->form_validation->set_rules('p_place_'.$val, '설명회장장소', 'required');
				$this->form_validation->set_rules('p_posx_'.$val, '셜명회좌표', 'required');
				$this->form_validation->set_rules('p_posy_'.$val, '셜명회좌표', 'required');
			}
			$p_massge = '선택 설명회 수정완료';
			$link = site_url().'homeAdm/presentation_day/modify/'.$this->input->post('page').'?begin='.$this->input->post('begin').'&end='.$this->input->post('end');

		}else if($this->input->post('mode') == 'delete'){
			$this->form_validation->set_rules('p_chk[]', '선택', 'required');
			$p_massge = '선택 설명회 삭제완료';
			$link = site_url().'homeAdm/presentation_day/view/'.$this->input->post('page').'?begin='.$this->input->post('begin').'&end='.$this->input->post('end');
		}else{
			redirect(site_url());
		}

		if($this->form_validation->run() == FALSE){
			$this->session->set_flashdata('message', '필수항목 누락');
			redirect($link);
		}else{
			if($this->register_model->presentation_register($this->input->post(NULL, TRUE))){
				$this->session->set_flashdata('message', $p_massge);
				redirect($link);
			}else{
				$this->session->set_flashdata('message', 'SQL ERROR. 잠시 후 다시 시도해 주세요.');
				redirect($link);
			}
		}
	}
	// 설명회 예약자 수정
	public function presentation_user_update(){
		$this->_check_security_master_lv(8);
		if($this->input->post('mode') == 'insert'){
			if($this->input->post('p_reserve') === 'presentation'){
				$this->form_validation->set_rules('p_id', '설명회일정', 'required|numeric');
			}
			$this->form_validation->set_rules('u_name', '이름', 'required');
			$this->form_validation->set_rules('u_phone', '전화번호', 'required');
			//$this->form_validation->set_rules('u_email', '이메일', 'required|valid_email');
			if($this->input->post('p_reserve') === 'presentation'){
				$p_massge = '설명회 예약자 등록완료';
				$link = site_url().'homeAdm/presentation';
			}else{
				$p_massge = '개별상담 예약자 등록완료';
				$link = site_url().'homeAdm/individual';
			}

			//$check = $this->register_model->check_presentation_dayuser(null, $this->input->post('p_id'), $this->input->post('u_email'), $this->input->post('u_phone'));
			//$check_link = site_url().'homeAdm/presentation/'.$this->input->post('pmode').'/'.$this->input->post('day').'/'.$this->input->post('page');
		}else if($this->input->post('mode') == 'modify'){
			$this->form_validation->set_rules('u_chk[]', '선택', 'required');
			foreach($this->input->post('u_chk') as $val){
				$this->form_validation->set_rules('u_name_'.$val, '이름', 'required');
				$this->form_validation->set_rules('u_phone_'.$val, '연락처', 'required');
				//$this->form_validation->set_rules('u_email_'.$val, '이메일', 'required|valid_email');
			}
			$p_massge = '선택 예약자 수정완료';
			if($this->input->post('p_reserve') === 'presentation'){
				$link = site_url().'homeAdm/presentation/modify/'.$this->input->post('day').'/'.$this->input->post('page');
			}else{
				$link = site_url().'homeAdm/individual/modify/'.$this->input->post('day').'/'.$this->input->post('page');
			}
		}else if($this->input->post('mode') == 'modify_single'){
			$this->form_validation->set_rules('u_id', '회원', 'required|numeric');
			if($this->input->post('p_reserve') == 'presentation'){
				$this->form_validation->set_rules('p_id', '설명회일정', 'required|numeric');
			}
			$this->form_validation->set_rules('u_name', '이름', 'required');
			$this->form_validation->set_rules('u_phone', '전화번호', 'required');
			//$this->form_validation->set_rules('u_email', '이메일', 'required|valid_email');
			$p_massge = '수정완료';
			if($this->input->post('p_reserve') === 'presentation'){
				$link = site_url().'homeAdm/presentation/'.$this->input->post('pmode').'/'.$this->input->post('day').'/'.$this->input->post('page');
			}else{
				$link = site_url().'homeAdm/individual/'.$this->input->post('pmode').'/'.$this->input->post('day').'/'.$this->input->post('page');
			}
			//$check = $this->register_model->check_presentation_dayuser($this->input->post('u_id'), $this->input->post('p_id'), $this->input->post('u_email'), $this->input->post('u_phone'));
			//$check_link = site_url().'homeAdm/presentation_view/'.$this->input->post('orig_p_id').'/'.$this->input->post('u_id').'/?pmode='.$this->input->post('pmode').'&day='.$this->input->post('day').'&page='.$this->input->post('page');
		}else if($this->input->post('mode') == 'delete'){

			$this->form_validation->set_rules('u_chk[]', '예약자', 'required|numeric');
			$p_massge = '선택 예약자 삭제완료';
			if($this->input->post('p_reserve') === 'presentation'){
				$link = site_url().'homeAdm/presentation/view/'.$this->input->post('day').'/'.$this->input->post('page');
			}else{
				$link = site_url().'homeAdm/individual/view/'.$this->input->post('day').'/'.$this->input->post('page');
			}
		}else{
			redirect(site_url());
		}

		if($this->form_validation->run() == FALSE){
			$this->session->set_flashdata('message', '필수항목 누락');
			redirect($link);
		}else{
			/*
			if($this->input->post('mode') == 'modify_single' || $this->input->post('mode') == 'insert'){
				// 설명회 일정 변경시 해당 일정에 이동하려는 유저의 핸드폰번호나 이메일이 있는지 중복체크
				if(count($check) > 0){
					$this->session->set_flashdata('message', '선택하신 설명회 일정에 해당 회원의 이메일 & 전화번호와 중복되는 데이터가 있습니다.');
					if($this->input->post('mode') == 'insert'){
						$this->session->set_flashdata('u_name',$this->input->post('u_name'));
						$this->session->set_flashdata('u_phone',$this->input->post('u_phone'));
						$this->session->set_flashdata('u_email',$this->input->post('u_email'));
						$this->session->set_flashdata('u_description',$this->input->post('u_description'));
					}
					redirect($check_link);
				}
			}*/
			if($this->register_model->presentation_user_register($this->input->post(NULL, TRUE))){
				$this->session->set_flashdata('message', $p_massge);
				redirect($link);
			}else{
				$this->session->set_flashdata('message', 'SQL ERROR. 잠시 후 다시 시도해 주세요.');
				redirect($link);
			}
		}
	}
	// 설명회 엑셀파일 다운
	public function presentation_excel(){
		$this->_check_security_master_lv(8);
		$this->load->library('phpexcel_home');
		/* 엑셀로 db파일 넣을때 이렇게해라
		//$this->load->database();
		//$sql = $this->phpexcel_home->set_excelfile_connection_db(FCPATH.'assets/file/down/presentation.xls');
		//$this->db->query($sql);
		*/
		if($this->input->post('p_reserve') === 'individual'){
			$cell_name = array(
				'이름',
				'이름(영문)',
				'학생학력',
				'휴대폰번호',
				'학생 거주국가',
				'관심분야',
				'등록일',
				'상담기록'
			);
			$data  	= $this->register_model->get_individual_excelfile($this->input->post(NULL, TRUE));
		}else{
			$cell_name = array(
				'설명회일시',
				'셜명회장소',
				'이름',
				'학생학력',
				'휴대폰번호',
				'학생 거주국가',
				'관심분야',
				'등록일',
				'참석여부',
				'상담기록'
			);
			$data 	= $this->register_model->get_presentation_excelfile($this->input->post(NULL, TRUE));
		}
		$start 	= $this->input->post('p_begin');
		$end 	= $this->input->post('p_end');
		$filename = ($this->input->post('p_reserve') === 'individual')?'개별상담 예약':'설명회 예약'.'('.$start.'-'.$end.')';
		$data_row = array();
		if($this->input->post('p_reserve') === 'individual'){
			foreach($data as $val){
				$data_row[] = array(
					stripslashes($val->u_name),
					stripslashes($val->u_name_en),
					stripslashes($val->u_aca),
					stripslashes(set_change_phonenumber_type($val->u_phone)),
					stripslashes($val->u_state),
					stripslashes($val->u_field),
					stripslashes($val->u_register),
					strip_tags(stripslashes($val->u_description))
				);
			}
		}else{
			foreach($data as $val){
				$data_row[] = array(
					stripslashes($val->p_day),
					stripslashes('['.$val->p_location.'] '.$val->p_address.' / '.$val->p_place),
					stripslashes($val->u_name).((!empty($val->u_name_en))?' ['.stripslashes($val->u_name_en).']':''),
					stripslashes($val->u_aca),
					stripslashes(set_change_phonenumber_type($val->u_phone)),
					stripslashes($val->u_state),
					stripslashes($val->u_field),
					stripslashes($val->u_register),
					stripslashes($val->u_attend),
					strip_tags(stripslashes($val->u_description))
				);
			}
		}

		$this->phpexcel_home->down_excelfile($filename, $cell_name, $data_row);
	}
	/* 설명회  end */
	// 팝업관리
	public function popup(){
		$this->_check_security_master_lv(9);
		$popup_event = $this->register_model->get_home_popup('popup_event');
		$data = $this->_set_meta_data(array('title'=>'팝업창관리'));
		$data['active'] 		= 'popup';
		$data['popup_event']	= $popup_event;
		$data['popup_mode']		= ($popup_event)?'modify':'insert';
		$this->_getPageLayout('popup', $data);
	}
	public function popup_update(){
		$this->_check_security_master_lv(9);
		for($i=0, $poplen = count($this->input->post('popevent_index')); $i<$poplen; $i++){
			$this->form_validation->set_rules('pop_subject_ko_'.$i, '팝업 제목', 'required');
			$this->form_validation->set_rules('pop_subject_en_'.$i, '팝업 제목', 'required');
			$this->form_validation->set_rules('pop_subject_vn_'.$i, '팝업 제목', 'required');
			//$this->form_validation->set_rules('pop_alt_'.$i, '팝업 이미지 대체 젝스트', 'required');
		}
		if($this->form_validation->run() == FALSE){
			$this->session->set_flashdata('message', '입력사항 오류');
			redirect(site_url()."homeAdm/popup");
		}else{
			if($this->register_model->home_popup_update($this->input->post(NULL, TRUE))){
				$this->session->set_flashdata('message', '파일 등록 및 수정 완료.');
			}else{
				$this->session->set_flashdata('message', '팝업창 등록 오류.\n잠시 후 다시 시도해 주세요.');
			}
			redirect(site_url()."homeAdm/popup");
		}
	}
	// 개인정보취급방침
	public function home_agreement($agree_lang='ko'){
		$this->_check_security_master_lv(10);
		$this->form_validation->set_rules('agreement', '개인정보취급방침', 'required');
		if($this->form_validation->run() == FALSE){
			$data = $this->_set_meta_data(array('title'=>'개인정보취급방침'));
			$data['agree_lang']		=  $agree_lang;
			$data['active'] 		= 'agreement';
			$data['agreement']		= $this->register_model->get_home_agreement($agree_lang);

			$this->_getPageLayout('agreement', $data);
		}else{

			if($this->register_model->set_home_agreement($this->input->post(NULL, TRUE))){
				$this->session->set_flashdata('message', '개인정보 취급방침 등록완료');
			}else{
				$this->session->set_flashdata('message', 'SQL ERROR 잠시 후 다시 시도해 주세요.');
			}
			redirect(site_url()."homeAdm/agreement");
		}
	}
	// 페이지 메타테그설정
	public function set_page_metatag($page_name=''){
		// 1.$page_name == '' and null 네비db를 가져와서 페이지들을 목록으로 보여주며 없다면 등록된 메뉴가 없다고 나온다.
		// 2.$page_name 있다면 진짜로 db에 있는 메뉴인지 아닌지 검사 맞다면 페이지설정 db에서 해당 페이지
	}
	// 회원목록 or 최고관리자가 회원 목록에서 수정
	public function members($userType='mp_user', $userno=0){
		$this->_check_security_master_lv(8);
		$this->load->model('member_model');
		if($userType === 'all' || $userType === "mp_master" || $userType === "mp_user" || $userType === 'membership'){
			$data = set_meta_data("UMV | 회원목록");
			$data['active'] 			= 'members';
			$data['sub_title'] 			= $userType;
			$data['members_list'] 		= $this->member_model->get_member_list($userType);
			$this->_getPageLayout('members', $data);
		}else if($userType ==='view'){
			// 최고관리자만 접근가능
			//$this->_check_security_supermaster($this->de_user_type);
			$this->_check_security_master_lv(9);
			if(!is_numeric($userno) || $userno == 0){
				show_404();
			}
			$result = $this->member_model->get_member($userno);
			if($result){
				$data 				= set_meta_data("UMV | 회원정보");
				$data['active'] 	= 'members';
				$data['mode_type'] 	= 'modify';
				foreach($result[0] as $key=>$val){
					$data[$key] = fnc_set_htmls_strip($val);
				}
				$this->_getPageLayout('register', $data);

			}else{
				$this->session->set_flashdata('message', '등록된 회원이 없습니다.');
				redirect(site_url()."homeAdm/members/");
			}
		}else if($userType === 'delete'){
			// 최고관리자만 접근가능
			//$this->_check_security_supermaster($this->de_user_type);
			$this->_check_security_master_lv(9);
			if(count($this->input->post('delete_no')) > 0){
				if($this->member_model->delete_member($this->input->post(NULL, TRUE))){
					$this->session->set_flashdata('message', '선택된 회원 삭제완료.');
				}else{
					$this->session->set_flashdata('message', 'SQL Error 잠시 후 다시 시도해 주세요.');
				}
			}else{
				$this->session->set_flashdata('message', '선택된 회원이 없습니다.');
			}
			redirect(site_url()."homeAdm/members/");
		}else{
			show_404();
		}
	}
	// 관리자 회원등록
	public function register(){
		// 최고 관리자만 일반관리자와 유저를 등록할 수 있다.
		//$this->_check_security_supermaster($this->de_user_type);
		$this->_check_security_master_lv(9);
		$this->load->database();
		$this->form_validation->set_rules('userid', '아이디', 'required|valid_email|is_unique[user.user_id]');
		$this->form_validation->set_rules('useremail', '이메일', 'required|valid_email|is_unique[user.user_email]');
		$this->form_validation->set_rules('password', '비밀번호', 'required|min_length[8]|max_length[16]');
		$this->form_validation->set_rules('passconf', '비밀번호확인', 'required|min_length[8]|max_length[16]|matches[password]');
		$this->form_validation->set_rules('username', '이름', 'required');
		//$this->form_validation->set_rules('username_en', '영문이름', 'required');
		//$this->form_validation->set_rules('usernick', '닉네임', 'required');
		//$this->form_validation->set_rules('userphone', '핸드폰번호', 'required');
		$this->form_validation->set_rules('usertype', '유저타입', 'alpha_dash');
		$this->form_validation->set_rules('userlv', '유저등급', 'numeric');

		if($this->form_validation->run() == FALSE){
			$data 					= set_meta_data("UMV | 회원등록");
			$data['user_id'] 		= set_value('userid');
			$data['user_email'] 	= set_value('useremail');
			$data['user_name'] 		= set_value('username');
			$data['user_name_en'] 	= set_value('username_en');
			$data['user_nick'] 		= set_value('usernick');
			$data['user_phone'] 	= set_value('userphone');
			$data['active'] 		= 'register';
			$data['mode_type'] 		= 'register';
			$this->_getPageLayout('register', $data);
		}else{
			$this->load->model('member_model');
			$result    = $this->member_model->add_member($this->input->post(NULL, FALSE));
			if($result == "success"){
				redirect(site_url()."homeAdm/members");
			}else if($result == "error_same"){
				alert('같은 내용의 이메일이 존재합니다.', site_url()."homeAdm/register");
				return;
			}else{
				alert('SQL ERROR.', site_url()."homeAdm/register");
				return;
			}
		}
	}
	// 이거 사용안함 아이디를 이메일로 바꿨다
	public function userid_check($str){
		if(preg_match("/^(?=.*[a-zA-Z])(?=.*[!@^_])(?=.*[0-9]).{8,16}$/", $str)){
			return true;
		}else{
			$this->form_validation->set_message('userid_check', '아이디는 영문, 숫자 , 특수문자 (!@^_) 조합 8~16글자로 으로 만들어주세요.');
			return false;
		}
	}
	// 멤버 정보수정
	public function modify(){
		if(!$this->session->userdata('user_id') || !preg_match ("/".$_SERVER['HTTP_HOST']."/", $_SERVER['HTTP_REFERER'])){
			redirect(site_url());
		}else{
			$this->form_validation->set_rules('userid', '아이디', 'required|valid_email');
			$this->form_validation->set_rules('useremail', '이메일', 'required|valid_email');
			$this->form_validation->set_rules('username', '이름', 'required');
			//$this->form_validation->set_rules('username_en', '영문이름', 'required');
			//$this->form_validation->set_rules('usernick', '닉네임', 'required');
			//$this->form_validation->set_rules('userphone', '핸드폰번호', 'required');

			if($this->form_validation->run() == FALSE){
				$this->session->set_flashdata('message', '입력 항목 오류.');
				if($this->de_user_type === HOME_PREFIX."superMaster"){
					redirect(site_url()."homeAdm/members/view/".$this->input->post('userno'));
				}else if($this->de_user_type === HOME_PREFIX."master"){
					redirect(site_url()."auth/confirm_pwd/adm");
				}else{
					$this->session->sess_destroy();
					redirect(site_url());
				}

			}else{
				$this->load->model('member_model');
				if($this->encryption->decrypt($this->session->userdata('user_type')) !== 'mp_superMaster'){
					if($this->input->post('userid') !== $this->encryption->decrypt($this->session->userdata('user_id'))){
						redirect('/auth/confirm_pwd/adm');
					}
				}
				if($this->member_model->set_member($this->input->post(NULL, FALSE))){
					$this->session->set_flashdata('message', '정보수정 완료');
					redirect(site_url().'homeAdm/members');
				}else{
					$this->session->set_flashdata('message', 'SQL ERROR 잠시 후 다시 시도해 주세요.');
					redirect(site_url()."auth/confirm_pwd/adm");
				}
			}
		}
	}
	// 비번 수정
	public function change_password(){
		$this->form_validation->set_rules('userid', '아이디', 'required|valid_email');
		$this->form_validation->set_rules('password', '비밀번호', 'required|min_length[6]|max_length[18]');
		$this->form_validation->set_rules('passconf', '비밀번호확인', 'required|min_length[6]|max_length[18]|matches[password]');
		if($this->form_validation->run() == FALSE){
			$this->session->set_flashdata('message', '입력 항목 오류.');
			redirect(site_url()."auth/confirm_pwd/adm");
		}else{
			$this->load->model('member_model');
			if($this->encryption->decrypt($this->session->userdata('user_type')) !== 'mp_superMaster'){
				if($this->input->post('userid') !== $this->encryption->decrypt($this->session->userdata('user_id'))){
					redirect('homeAdm/confirm');
				}
			}
			if($this->member_model->set_member_password($this->input->post(NULL, FALSE))){
				$this->session->set_flashdata('message', '비밀번호수정 완료');
				redirect(site_url().'homeAdm');
			}else{
				$this->session->set_flashdata('message', 'SQL ERROR 잠시 후 다시 시도해 주세요.');
				redirect(site_url()."homeAdm");
			}
		}
	}
	// 관리자에서 정보 수정 눌렀을때 뜨는 비번입력페이지와 관리자 개인의 정보수정
	public function confirm(){
		if(preg_match ("/".$_SERVER['HTTP_HOST']."/", $_SERVER['HTTP_REFERER'])){
			$this->load->library('captcha');
			$this->form_validation->set_rules('password', '비밀번호', 'required|min_length[6]|max_length[18]');
			$this->form_validation->set_rules('passconf', '비밀번호확인', 'required|min_length[6]|max_length[18]|matches[password]');

			if($this->form_validation->run() == FALSE){
				$this->_confirm_view();
			}else{
				// 캡차코드확인 위해서 한번더 폼검증
				$this->form_validation->set_rules('captcha', 'Captcha', array(
					'required',
					array($this->captcha, 'check_validate_captcha')
				));
				if($this->form_validation->run() == FALSE){
					$this->session->set_flashdata('message', '캡차코드를 정확히 입력해 주세요.');
					$this->_confirm_view();
				}else{
					$this->load->model('login_model');
					$userid 	= $this->encryption->decrypt($this->session->userdata('user_id'));
					$password 	= $this->input->post('password');
					$result 	= $this->login_model->check_login($userid, $password);

					if($result){
						$data = set_meta_data("UMV | 정보수정");
						$data['active'] 		= '';
						$data['mode_type'] 		= 'modify';
						foreach($result as $key=>$val){
							$data[$key] = fnc_set_htmls_strip($val);
						}
						$this->_getPageLayout('register', $data);
					}else{
						$this->session->set_flashdata('message', '비밀번호 입력 오류.');
						$this->_confirm_view();
					}
				}
			}
		}else{
			$this->session->sess_destroy();
			redirect(site_url());
		}
	}
	// function confirm -> view 화면
	private function _confirm_view(){
		$data = array(
			'title' 			=> HOME_INFO_NAME.' 개인정보확인',
			'frmlink'			=> site_url().'homeAdm/confirm',
			'captcha' 			=> $this->captcha->set_captcha_file(array('img_width'=>170)),
			'javascript_arr'	=> array("<script src='".HOME_JS_PATH."/BD_form_validation.js'></script>")
		);
		return $this->_getPageLayout('auth/confirm_pwd', $data, true);
	}
	// 영문이름 정규식 만들어야함
	public function validate_captcha(){
	    if($this->input->post('captcha') != $this->session->userdata['user_captchaword']){
	        return false;
	    }else{
	        return true;
	    }
	}
	// form validation update type check .. insert modify delete
	public function updateMode_check($str){
		if(preg_match('/^(modify|insert|delete)$/i', $str)){
			return true;
		}else{
			return false;
		}
	}
}
?>
