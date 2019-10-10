<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Redirect_post{
	private $CI;
	public function __construct(){
		$this->CI = & get_instance();
	}
	public function send_post($url='', array $data, $csrf=true){
		if(empty($url) || !is_array($data)) return false;
		ob_start();
		$html 		= '
				<!DOCTYPE html>
				<html lang="ko">
				<head>
					<meta charset="utf-8" />
					<noscript>
						<meta http-equiv="refresh" content="2; url= />
					</noscript>
				</head>
				<body>
					<form name="redirectform" method="post" action="'.$url.'">';
		if($csrf){
			$html 	.= '<input type="hidden" name="'.$this->CI->security->get_csrf_token_name().'" value="'.$this->CI->security->get_csrf_hash().'" />';
		}
		foreach($data as $key=>$val){
			$html 	.= '<input type="hidden" name="'.$key.'" value="'.$val.'" />';
		}
		$html 		.= '
					</form>
					<noscript>해당 브라우져는 javascript를 지원하지 않거나 사용이 해제되어 있습니다.<br />javascript가 작동하는 환경에서 실행해 주세요.</noscript>
					<script type="text/javascript" >
					(function(){
						document.forms["redirectform"].submit();
					})();	
					</script>	
				</body>
				</html>
		';
		ob_end_clean();
		return $html;
	}
}
?>
