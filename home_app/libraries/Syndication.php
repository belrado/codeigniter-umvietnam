<?php
defined('BASEPATH') OR exit('No direct script access allowed');
/* 
 * 라이브러리로 제작해서 관리자와 일반페이지에서 사용한다.
 * 관리자 -> 신디게이션에 필요한 사이트 정보 저장 수정 삭제를 함
 * 관리자 -> 신디게이션 업로드, 업데이트시 핑보냄
 * 관리자 -> 신디게이션 데이터 삭제시 핑보냄
 * 관리자 -> 데이터 저장 수정은 해당 페이지 html 파일 가져와서 그대로 db에 저장
 * 
 * 일반파에지 -> 관리자에서 저장한 신디게이션 데이터를 가져와서 xml 페이지에 한꺼번에 노출
 * 일반페이지 -> 데이터노출 html방식은 htmlspecialchars 사용 , text방식은 strip_tags사용
 * 
 */
class Syndication{
	private $CI;
	private $code = null;
	private $syndi_key = null;
	
	public function __construct(){
		$this->CI = & get_instance();
		$this->CI->load->model('syndication_model');
		$this->syndi_key = 'AAAANoRofonKqGXPLRkwo1UoSFMU1LBSNm3NYXwUuVQ/xn5mxpZc0rdbX9pqxwRIg7nXfOw5M9+/ilo0Ka4RclVUwNQ=';
		$this->code = array(
			'000'	=> '전송이 성공하였습니다.',
			'024'	=> '인증 실패하였습니다.',
			'028'	=> 'OAuth Header가 없습니다.',
			'029'	=> '요청한 Authorization값을 확인할 수 없습니다.',
			'030'	=> 'https 프로토콜로 요청해주세요.',
			'051'	=> '존재하지 않는 API 입니다.',
			'061'	=> '잘못된 형식의 호출 URL입니다.',
			'063'	=> '잘못된 형식의 인코딩 문자입니다.',
			'071'	=> '지원하지 않는 리턴 포맷입니다.',
			'120'	=> '전송된 내용이 없습니다. (ping_url 필요)',
			'121'	=> '유효하지 않은 parameter가 전달되었습니다.',
			'122'	=> '등록되지 않은 사이트 입니다.',
			'123'	=> '1일 전송 횟수를 초과하였습니다.',
			'130'	=> '서버 내부의 오류입니다. 재시도 해주세요.',
			'999'	=> '카테고리 넘버 오류'
		);
	}
	/*
	 * 카테고리별로 묶어서 보냄..
	 * id 링크주소
	 * title 페이지 타이틀
	 * author 자동생성
	 * updated / published Timestamp형식
	 * link	rel=via 부모창 이건 걍 홈페이지 주소로 
	 * content / summary = html/text 방식
	 * category 분류
	 */
	public function code($code){
		foreach($this->code as $key=>$val){
			if($code == $key){
				return $val;
			}
		}
	}
	public function sendPing($cate=1, $url='http://psuedu.org/syndi/xml/'){
		if(!is_numeric($cate)) return $this->code('999');
		$ping_auth_header = "Authorization: Bearer ".$this->syndi_key; /* Bearer 타입의 인증키 정보 */
		$ping_url = urlencode($url.$cate); /* 신디케이션 문서를 담고 있는 핑 URL */
		$ping_client_opt = array(
		CURLOPT_URL => "https://apis.naver.com/crawl/nsyndi/v2", /* 네이버 신디케이션 서버 호출주소 */
		CURLOPT_POST => true, /* POST 방식 */
		CURLOPT_POSTFIELDS => "ping_url=" . $ping_url, /* 파라미터로 핑 URL 전달 */
		CURLOPT_RETURNTRANSFER => true,
		CURLOPT_CONNECTTIMEOUT => 10,
		CURLOPT_TIMEOUT => 10,
		CURLOPT_HTTPHEADER =>
		array("Host: apis.naver.com", "Pragma: no-cache", "Accept: */*", $ping_auth_header) /* 헤더에 인증키 정보 추가 */
		);
		$ping = curl_init();
		curl_setopt_array($ping, $ping_client_opt);
		$response = curl_exec($ping);
		$status_code = curl_getinfo($ping, CURLINFO_HTTP_CODE);
		$results = simplexml_load_string($response);
		curl_close($ping);
		return $this->code($results->error_code);
	}
	public function post($post){
		/* 신디케이션 db에 컨텐츠 저장
		 * 게시판에서 글쓸때 신디케이션 사용인지 아닌지 비교해서 작동 
		 * 게시글 쓴뒤 라이브러리 적용
		 */
		$data = array(
			's_type'			=> $post['s_type'],
			's_bbs_table'		=> $post['s_bbs_table'],
			's_bbs_name'		=> $post['s_bbs_name'],
			's_bbs_id'			=> $post['s_bbs_id'],
			's_bbs_subject'		=> $post['s_bbs_subject'],
			's_bbs_content'		=> $post['s_bbs_content'],
			's_bbs_register'	=> date('Y-m-d H:i:s', time())
		);
		$this->CI->syndication_model->bbs_post($data);
		/* 저장시키고 핑전송 */
		//return '';
		return $this->sendPing($post['s_bbs_id'], site_url().'syndi/bbsxml/'.$post['s_bbs_table'].'/single/'.$post['s_bbs_id']);
	}
	public function put($post){
		/* 신디케이션 db에 컨텐츠 저장
		 * 게시판에서 글쓸때 신디케이션 사용인지 아닌지 비교해서 작동 
		 * 게시글 쓴뒤 라이브러리 적용, 수정이기 때문에 이전에 저장시킨 내용중 핑전송이 안된게 있다면 핑전송 완료로 바꿈 
		 */
		 $data = array(
			's_type'			=> $post['s_type'],
			's_bbs_table'		=> $post['s_bbs_table'],
			's_bbs_name'		=> $post['s_bbs_name'],
			's_bbs_id'			=> $post['s_bbs_id'],
			's_bbs_subject'		=> $post['s_bbs_subject'],
			's_bbs_content'		=> $post['s_bbs_content']
		);
		$this->CI->syndication_model->bbs_put($data);
		/* 저장시키고 핑전송 */
		//return '';
		return $this->sendPing($post['s_bbs_id'], site_url().'syndi/bbsxml/'.$post['s_bbs_table'].'/single/'.$post['s_bbs_id']);
	}
	public function delete($bbs_table='', $bbs_ids=array()){
		$bbs_table = trim(strtolower($bbs_table));
		if(empty($bbs_table) || count($bbs_ids)<=0) return false;
		/* 게시물 삭제가 아닌 delete된 게시판 정보 저장 */
		$this->CI->syndication_model->bbs_delete($bbs_table, $bbs_ids);
		/* 삭제 저장 후 삭제핑전송 */
		$messageArr = array();
		foreach($bbs_ids as $val){
			$messageArr[] = $this->sendPing($val, site_url().'syndi/bbsxml/'.$bbs_table.'/single/'.$val);
		}
		return $messageArr;
	}
	public function get($cate=0, $entry=0, $xml=false, $rss=false){
		$feed  = $this->CI->syndication_model->get($entry, $cate, $xml, $rss);
		$entry = $this->CI->syndication_model->get($cate, $entry, $xml, $rss);
		$data = array(
			'feed' => $feed,
			'entry' => $entry
		);
		return $data;
	}
	public function get_all($xml=false, $rss=false){
		$items = $this->CI->syndication_model->get_all($xml, $rss);
		return $items;
	}
	public function board_get($bbs_table='', $page=1){
		$this->CI->load->model('board_model');
		$bbs_table = trim(strtolower($bbs_table));
		$total = $this->CI->board_model->get_board_list_totalnum($bbs_table);
		if(!$total) return false;
		$maxPing = 10;
		$loopNum = ceil($total/$maxPing);
		$feed = $this->CI->board_model->get_board($bbs_table);
		$data = array(
			'feed' 	=> array(
				'bbs_table'		=> $bbs_table,
				'syn_id' 		=> 'board/list/'.$bbs_table,
				'syn_title'		=> $feed[0]->bbs_name
			),
			'entry'	=> array()
		);
		$paged 	= ($page-1>=0)?($page-1):0;
		$offset = $paged*$maxPing;
		$limit	= ($paged==$loopNum-1)?(($total>$maxPing)?($total-($paged*$maxPing)):$total):($maxPing*($paged+1));
		$result = $this->CI->board_model->get_write_board_list($bbs_table, $offset, $limit);
		$data['entry']= $result;
		return $data;
	}
	public function board_ping($bbs_table='', $type='single', $bbs_id=''){
		if(empty($bbs_table) || !is_numeric($bbs_id)) return false;
		$this->CI->load->model('board_model');
		$bbs_table = trim(strtolower($bbs_table));
		$feed = $this->CI->board_model->get_board($bbs_table);
		if(!$feed) show_404();
		if($type=='list'){
			$bbs_id = 1;
			$total = $this->CI->board_model->get_board_list_totalnum($bbs_table);
			if(!$total) return false;
			$maxPing = 10;
			$loopNum = ceil($total/$maxPing);
			$paged 	= ($bbs_id-1>=0)?($bbs_id-1):0;
			$offset = $paged*$maxPing;
			$limit	= ($paged==$loopNum-1)?(($total>$maxPing)?($total-($paged*$maxPing)):$total):($maxPing*($paged+1));
			$result = $this->CI->syndication_model->bbs_get($bbs_table, 0, $offset, $limit);
		}else{
			$result = $this->CI->syndication_model->bbs_get($bbs_table, $bbs_id);
		}
		$data = array(
			'feed' 	=> array(
				'bbs_table'		=> $bbs_table,
				'syn_id' 		=> 'board/list/'.$bbs_table,
				'syn_title'		=> $feed[0]->bbs_name
			),
			'entry'	=> array()
		);
		foreach($result as $val){
			$data['entry'][] = (object)array(
				'bbs_type'		=> $val->s_type,
				'bbs_table' 	=> $val->s_bbs_table,
				'bbs_id'		=> $val->s_bbs_id,
				'bbs_subject'	=> $val->s_bbs_subject,
				'bbs_content'	=> $val->s_bbs_content,
				'bbs_register'	=> $val->s_bbs_register
			);
		}
		return $data;
	}
}
?>