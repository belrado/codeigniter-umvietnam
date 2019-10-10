<?php
if (! defined('BASEPATH')) exit('No direct script access allowed');
/* 금지단어 */
function get_banned_word(){
	return '자지,씨부럴,개자지,개보지,개보대,종간나새끼,씨붕알,붕알,fuck,fuck you,panis,sex,asshole,좆,개새,씨발,씹,창녀,앰창,엄창,개년,개걸레,쎅스,섹스,후장,사까시,오랄,정액,보짓,아가리,대가리,갈빡,귀두,부랄 ,똥꼬 ,찐따,썅,쌍년,시발아,시발년,시발놈,꼬추,빠가,애미,애비,씨바,클리토리스,18아,18놈,18새끼,18뇬,18것,18넘,개년,개놈,개뇬,개새,개색끼,개세끼,개세이,개쉐이,개쉑,개쉽,개시키,개자식,눈깔,병쉰,병신,뻐큐,뻑큐,뽁큐,삐리넷,새꺄,쉬발,쉬밸,쉬팔,쉽알,아가리,조까,조빠네,존나,존니,쥐랄,지롤';
}
function get_banned_name(){
	return 'administrator, webmaster, 웹마스터, 웹마스타, 개인정보, 주인장, 메디프렙, 매니저, 메니저, manager, root, 루트, 관리자, psuedu, 피에슈, admin, adm, mediprep, 웹마스터, 운영자, 자지, 보지, psu에듀, 에듀센터, (주)UMV, UMVietnam, UMV';
}
/**
 * 메타테그설정
 */
if(!function_exists('set_meta_data')){
	function set_meta_data($title="Mediprep | 미국의사 양성전문기관", $meta_title="Mediprep", $meta_keyword="미국의사, 미국의대, 의대편입, USMLE, PEET, MEET, DEET, PEET시험", $meta_description="미국의사 양성전문기관"){
		$data = array(
			'title' 			=> $title,
			'meta_title' 		=> $meta_title,
			'meta_keyword' 		=> $meta_keyword,
			'meta_description' 	=> $meta_description
		);
		return $data;
	}
}
/**
 * 시간
 */
if(!function_exists('set_view_register_time')){
	function set_view_register_time($date, $start=0, $end=10, $div='.'){
	 	$register = explode("-", substr($date,$start,$end));
		return $register[0].$div.$register[1].$div.$register[2];
	}
}
/**
 * Alert 띄우기
 */
if(! function_exists('alert')){
    function alert($msg = '', $url = '')
    {
        if (empty($msg)) {
            $msg = '잘못된 접근입니다';
        }
        echo '<meta http-equiv="content-type" content="text/html; charset=' . config_item('charset') . '">';
        echo '<script type="text/javascript">alert("' . $msg . '");';
        if (empty($url)) {
            echo 'history.back();';
        }
        if ($url) {
            echo 'document.location.href="' . $url . '"';
        }
        echo '</script>';
        echo '<noscript>';
        echo '<meta http-equiv="refresh" content="0;url='.$url.'" />';
        echo '</noscript>';
        exit;
    }
}
/**
 * 메타태그를 이용한 URL 이동 header("location:URL") 을 대체
 */
if(! function_exists('goto_url')){
	function goto_url($url){
	    $url = str_replace("&amp;", "&", $url);
	    //echo "<script> location.replace('$url'); </script>";

	    if (!headers_sent())
	        header('Location: '.$url);
	    else {
	        echo '<script>';
	        echo 'location.replace("'.$url.'");';
	        echo '</script>';
	        echo '<noscript>';
	        echo '<meta http-equiv="refresh" content="0;url='.$url.'" />';
	        echo '</noscript>';
	    }
	    exit;
	}
}
/**
 * 마지막슬래시제거
 */
function delete_last_slashtag($txt){
	$r = '';
	$t = explode("/",$txt);
	for($i=1; $i<count($t)-1; $i++){
		$r.= "/".$t[$i];
	}
	return $r;
}
/**
 * 토큰생성
 */
if(! function_exists('get_token')){
	function get_token(){
		$token = md5(uniqid(rand(), true))."::".get_microtime_float();
		$_SESSION['mp_token'] = $token;
		return $_SESSION['mp_token'];
	}
}
/**
 * 토큰확인
 */
if(! function_exists('check_token')){
	function check_token($val){
		if($_SESSION['mp_token'] !== $val){
			return false;
		}else{
			return true;
		}
	}
}
/**
 * 난수생성 : 로그인시 사용해서 db와 세션에 저장. 중요한 페이지 접속시만 비교해서 다르면 세션파괴
 */
if(! function_exists('get_rand_number')){
	function get_rand_number(){
		$logRand = '';
		$key = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789^/';
		for($i=0;$i<64;$i++) {
		 $logRand .= $key[rand(0,63)];
		}
		return $logRand;
	}
}
/**
 * 마이크로타임
 */
if(! function_exists('get_microtime_float')){
	function get_microtime_float(){
	    list($usec, $sec) = explode(" ", microtime());
	    return ((float)$usec + (float)$sec);
	}
}
/**
 * 세션체크
 */
if(! function_exists('check_superMaster_sess')){
	function check_superMaster_sess($sess_type){
 		if($sess_type !== HOME_PREFIX.'superMaster'){
			goto_url(site_url());
		}
 	}
}
if(! function_exists('check_master_sess')){
	function check_master_sess($sess_type){
		if($sess_type !== HOME_PREFIX.'master'){
			goto_url(site_url());
		}
	}
}
if(! function_exists('check_admin_sess')){
	function check_admin_sess($sess_type, $sess_lv, $sess_id){
		if(!$sess_id || $sess_lv < 7 || ($sess_type !== HOME_PREFIX.'master' && $sess_type !== HOME_PREFIX.'superMaster')){
			redirect(site_url());
			exit;
		}
	}
}
/*
 * 섭페이지 클릭시 active클래스 활성화
 */
if(! function_exists('set_nav_activeClass')){
	function set_nav_activeClass($active, $pagename){
		return (isset($active) && $active == $pagename) ? 'active' : '';
	}
}
/*
 * 관리자 아이피 체크
 */
function check_admin_ipaddress(){
	$admin_ip = array('112.223.248.83');
	return in_array($_SERVER['REMOTE_ADDR'], $admin_ip);
}
/* 모바일 전화번호 */
function get_psu_img_callNumber($mobile_check){
	if($mobile_check){
		echo $psuedu_call_number_img = "<a href='tel:02-540-2510' class='img-phone'><img src='/assets/img/footer_phone_new.gif' alt='교육상담문의 02-540-2510' /></a>";
	}else{
		echo $psuedu_call_number_img = "<span class='img-phone'><img src='/assets/img/footer_phone_new.gif' alt='교육상담문의 02-540-2510' /></span>";
	}
}
// 페이지 경로를 사이트이름과 마지막슬래쉬 제거하고 반환하는 함수
function get_linkdel_slash_site($url){
	return preg_replace('/[\/]$/', '', str_replace(site_url(), "", $url));
}
function check_nav_active($url, $depth=1){
	if($depth == 1){
		if(explode("/", get_linkdel_slash_site(current_url()))[0] === explode("/", get_linkdel_slash_site($url))[0]){
			return 'active';
		}else{
			return '';
		}
	}else if($depth == 2){
		if(get_linkdel_slash_site(current_url()) === get_linkdel_slash_site($url)){
			return 'active';
		}else{
			return '';
		}
	}
	return '';
}
function clear_uri_slashkey($str, $position='all'){
	$result = '';
	switch($position){
		case 'last' :
			$result = preg_replace('/\/$/', '', $str);
			break;
		default :
		$result = preg_replace('/\//', '', $str);
	}
	return $result;
}
function check_nav_active2($nav1, $nav2){
	if(clear_uri_slashkey(fnc_none_spacae($nav1), 'last') == preg_replace('/^(en|vi|ko)\/?/', '', clear_uri_slashkey(fnc_none_spacae($nav2), 'last'))){
		return 'active';
	}else{
		return false;
	}
}
function check_nav_active3($url, $depth=1){
	$url = explode('/', $url);
	$now_url = explode('/',preg_replace('/^(en|vi|ko)\/?/', '', uri_string()));
	//$now_url = explode('/',uri_string());
	$check1 = $url[0];
	$check2 = $now_url[0];
	switch($depth){
		case 2 :
			$check1 = (isset($url[1]))?$url[0].$url[1]:$url[0];
			$check2 = (isset($now_url[1]))?$now_url[0].$now_url[1]:$now_url[0];
			break;
		case 3 :
			$check1 = $url;
			$check2 = uri_string();
			break;
	}
	if($check1===$check2){
		return 'active';
	}else{
		return '';
	}
}
// utf8 문자열 자르기
function fnc_utf8_strcut( $str, $size, $suffix='...' ){
    $substr = substr( $str, 0, $size * 2 );
    $multi_size = preg_match_all( '/[\x80-\xff]/', $substr, $multi_chars );
    if ( $multi_size > 0 )
        $size = $size + intval( $multi_size / 3 ) - 1;
    if ( strlen( $str ) > $size ) {
        $str = substr( $str, 0, $size );
        $str = preg_replace( '/(([\x80-\xff]{3})*?)([\x80-\xff]{0,2})$/', '$1', $str );
        $str .= $suffix;
    }
    return $str;
}
function str_striptag_fnc($str, $trans=''){
	return strip_tags(stripslashes($str), $trans);
}
function fnc_set_htmls_strip($str, $cast=false){
	if($cast){
		$str = str_replace('"', '', $str);
		$str = str_replace("'", "", $str);
		$str = str_replace('&amp;', '&', $str);
		$str = str_replace('&lt;', '<', $str);
		$str = str_replace('&gt;', '>', $str);
		$str = str_replace('&nbsp;', ' ', $str);
	}
	$str = htmlspecialchars(stripslashes($str));
	return $str;
}
function fnc_set_htmls_strip2($str, $cast=false){
	$str = htmlspecialchars(stripslashes($str));
	if($cast){
		$str = str_replace('&ldquo;', '', $str);
		$str = str_replace('&lsquo;', '', $str);
		$str = str_replace('&rdquo;', '', $str);
		$str = str_replace('&rsquo;', '', $str);
		$str = str_replace("&quot;", '"', $str);
		$str = str_replace('&amp;', '&', $str);
		$str = str_replace('&lt;', '<', $str);
		$str = str_replace('&gt;', '>', $str);
		$str = str_replace('&nbsp;', ' ', $str);
	}
	return $str;
}
function fnc_set_striptag_strip($str, $cast=false){
	$str = strip_tags(stripslashes($str));
	if($cast){
		$str = str_replace('&ldquo;', '', $str);
		$str = str_replace('&lsquo;', '', $str);
		$str = str_replace('&rdquo;', '', $str);
		$str = str_replace('&rsquo;', '', $str);
		$str = str_replace("&quot;", '"', $str);
		$str = str_replace('&amp;', '&', $str);
		$str = str_replace('&lt;', '', $str);
		$str = str_replace('&gt;', '', $str);
		$str = str_replace('&nbsp;', ' ', $str);
	}
	return $str;
}
function fnc_set_striptag_strip2($str, $cast=false){
	$str = strip_tags(stripslashes($str));
	if($cast){
		$str = str_replace(array("\r\n","\r","\n"), '', $str);
		$str = str_replace('"', '', $str);
		$str = str_replace("'", "", $str);
		$str = str_replace('&ldquo;', '', $str);
		$str = str_replace('&lsquo;', '', $str);
		$str = str_replace('&rdquo;', '', $str);
		$str = str_replace('&rsquo;', '', $str);
		$str = str_replace("&quot;", '', $str);
		$str = str_replace('&amp;', '&', $str);
		$str = str_replace('&lt;', '', $str);
		$str = str_replace('&gt;', '', $str);
		$str = str_replace('&nbsp;', ' ', $str);
	}
	return $str;
}
// TEXT 형식으로 변환
function trans_text($str, $html=0, $restore=false)
{
    $source[] = "<";
    $target[] = "&lt;";
    $source[] = ">";
    $target[] = "&gt;";
    $source[] = "\"";
    $target[] = "&#034;";
    $source[] = "\'";
    $target[] = "&#039;";
    if($restore)
        $str = str_replace($target, $source, $str);
    // 3.31
    // TEXT 출력일 경우 &amp; &nbsp; 등의 코드를 정상으로 출력해 주기 위함
    if ($html == 0) {
        $str = html_symbol($str);
    }
    if ($html) {
        $source[] = "\n";
        $target[] = "<br/>";
    }
    return str_replace($source, $target, $str);
}
function html_symbol($str){
    return preg_replace("/\&([a-z0-9]{1,20}|\#[0-9]{0,3});/i", "&#038;\\1;", $str);
}
// 날자바꾸기
function fnc_replace_getday($str){
	$day = explode('-', $str);
	//return $day[0].'년 '.$day[1].'월 '.$day[2].'일';
	return $day[0].'.'.$day[1].'.'.$day[2];
}
// 시간바꾸기
function fnc_replace_gettime($str){
	$time = explode(':', $str);
	//return $time[0]."시 ".$time[1]."분";
	return $time[0].":".$time[1];
}
// 따옴표 없애기
function fnc_clear_marks($str){
	$str = str_replace("'","",$str);
	$str = str_replace('"','',$str);
	$str = str_replace("&ldquo;","",$str);
	$str = str_replace("&rdquo;","",$str);
	$str = str_replace("&lsquo;","",$str);
	$str = str_replace("&rsquo;","",$str);
	return $str;
}
// 따옴표 치환
function func_change_marks($str){
	$str = str_replace("'", "&lsquo;", $str);
	$str = str_replace('"', "&ldquo;", $str);
	return $str;
}
// 모든공백제거
function fnc_none_spacae($str){
	return preg_replace("/\s+/", "", trim($str));
}

if(!function_exists('str_nl2br_save_html')){
	function str_nl2br_save_html($string){

	    if(! preg_match("#</.*>#", $string)) // avoid looping if no tags in the string.
	        return nl2br($string);

	    $string = str_replace(array("\r\n", "\r", "\n"), "\n", $string);
	    $lines=explode("\n", $string);
	    $output='';
	    foreach($lines as $line)
	    {
	        $line = rtrim($line);
	        if(! preg_match("#</?[^/<>]*>$#", $line)) // See if the line finished with has an html opening or closing tag
	            $line .= '<br />';
	        $output .= $line . "\n";
	    }
	    return $output;
	}
}
// 검색어 특수문자 제거
function get_search_string($stx){
    $stx_pattern = array();
    $stx_pattern[] = '#\.*/+#';
    $stx_pattern[] = '#\\\*#';
    $stx_pattern[] = '#\.{2,}#';
    $stx_pattern[] = '#[/\'\"%=*\#\(\)\|\+\&\!\$~\{\}\[\]`;:\?\^\,]+#';
    $stx_replace = array();
    $stx_replace[] = '';
    $stx_replace[] = '';
    $stx_replace[] = '.';
    $stx_replace[] = '';
    $stx = preg_replace($stx_pattern, $stx_replace, $stx);
    return $stx;
}
// XSS 관련 태그 제거
function clean_xss_tags($str){
    $str = preg_replace('#</*(?:applet|b(?:ase|gsound|link)|embed|frame(?:set)?|i(?:frame|layer)|l(?:ayer|ink)|meta|object|s(?:cript|tyle)|title|xml)[^>]*+>#i', '', $str);
    return $str;
}
function clean_style_tags($str){
	$str = preg_replace('/style=(\"|\')?([^\"\']+)(\"|\')?/is', '', $str);
	$str = preg_replace('/xss=removed?/is', '', $str);
	return $str;
}
function fnc_major_program_joboutlook_html($data){
	$depth1 = explode("--", stripslashes($data));
	$html = '';
	foreach($depth1 as $val){
		$depth2 = explode("==", $val);
		$html .= "<li>";
		$html .= $depth2[0];
		if(count($depth2) > 1){
			$html .= "<ul>";
			for($i=1; $i<count($depth2); $i++){
				$html .= "<li>".$depth2[$i]."</li>";
			}
			$html .= "</ul>";
		}
		$html .= "</li>";
	}
	return $html;
}
// 폰번호 끝자리 4개 남기기
function fnc_phone_change($phone){
	$phone = str_replace("-", "", preg_replace("/\s+/", "", trim($phone)));
	$phonen ='';
	$len = mb_strlen($phone,'UTF-8');
	$last = mb_substr($phone,$len-4,4,'UTF-8');
	for($i = ($len-4); $i>0; $i--){
		$phonen .= "*";
	}
	return $phonen.$last;
}
// 이름 변환
function fnc_name_change2($name, $cut=3, $pos='front', $cha='*'){
	$str = preg_replace("/\s+/", "", $name);
	$len = mb_strlen($str,'UTF-8');
	$new_str = '';
	if($len <= $cut){
		if($len <=4){
			$cut = $len-1;
		}else{
			$cut = $len-2;
		}
	}
	$name = mb_substr($str, $cut, $len, 'UTF-8');
	for($i=0; $i<$cut; $i++){
		$new_str .= $cha;
	}
	return $new_str.$name;
}
function fnc_name_change($name, $cut=1, $cha='O'){
	$chName='';
	$sn = trim($name);
	$sn = preg_replace("/\s+/", "", $sn);
	$sn = explode('@', $sn);
	$mails = (isset($sn[1]))?$sn[1]:'';
	$len = mb_strlen($sn[0],'UTF-8');
	$first_name = mb_substr($sn[0],0,$cut,'UTF-8');
	if($cut >= $len){
		$cut = $len-2;
	}
	for($i=$cut; $i<$len; $i++){
		$chName .= $cha;
	}
	$sn[0] = $first_name." ".$chName;
	if($mails !== ''){
		return $sn[0].'@'.$mails;
	}else{
		return $sn[0].' '.$mails;
	}
}
/* 중복제거  objstring방식 */
function fnc_super_unique($array, $key){
   $temp_array = array();
   foreach ($array as &$v) {
       if (!isset($temp_array[$v->$key]))
       $temp_array[$v->$key] =& $v;
   }
   $array = array_values($temp_array);
   return $array;
}
/* 중복제거2 배열방식 */
function fnc_super_unique2($array, $key){
   $temp_array = array();
   foreach ($array as &$v) {
       if (!isset($temp_array[$v[$key]]))
       $temp_array[$v[$key]] =& $v;
   }
   $array = array_values($temp_array);
   return $array;
}
/* 요일 반환  */
function fnc_get_dayname($day, $lang='en'){
	switch($lang){
		case 'ko' :
		$day_arr = array("일","월","화","수","목","금","토");
		break;
		case 'vi' :
		$day_arr = array("Sun","Mon","Tue","Wed","Thu","Fri","Sat");
		break;
		default :
		$day_arr = array("Sun","Mon","Tue","Wed","Thu","Fri","Sat");
	}
	//$day_arr = array("일","월","화","수","목","금","토");
	return $day_arr[date('w', strtotime($day))];
}
/* 전번 하이픈 넣기 */
function fnc_set_phonenum($hp_no){
	return preg_replace("/(0(?:2|[0-9]{2}))([0-9]+)([0-9]{4}$)/", "\\1-\\2-\\3", $hp_no);
}
/* 전화번호 - 변환 */
function set_change_phonenumber_type($hp_no){
	return fnc_set_phonenum(str_replace("-", "", preg_replace("/\s+/", "", trim($hp_no))));
}
/* 회원 인증메일 기간 */
function get_confirmation_mail_time($register_time){
	return date("Y-m-d H:i:s", strtotime($register_time."+1 day"));
}
/* stdClass obj 배열 정렬 */
function fnc_sortStdClassArray($array, $key){
	$sort=array();
	$return=array();
	for($i=0; isset($array[$i]); $i++)
		$sort[$i]= $array[$i]->{$key};
	natcasesort($sort);
	foreach($sort as $k=>$v)
		$return[]=$array[$k];
	return $return;
}
/* 문자셋 확인 */
function check_user_charset($str){
	$encodeType = array('UTF-8', 'ASCII', 'JIS', 'EUC-KR', 'eucjp-win', 'sjis-win', 'EUC-JP', 'ISO 8859', 'GB', 'GBK', 'GB 2312', 'GB 18030', 'HKSCS', 'ISCII');
	return mb_detect_encoding($str, $encodeType);
}
/* 문자셋 utf8 변경 */
function fnc_changeString_to_utf8($str){
	if(mb_detect_encoding($str, 'UTF-8', true) === false) {
    	$str = utf8_encode($str);
    }
    return $str;
}
/* 경고창 br 변환 */
function fnc_replace_str_foralert($str){
	return strip_tags(preg_replace('/\<br \/\>|\<br\/\>|\<br\>|\<br \>/is', '\n', $str));
}
/* print_r 보기 */
function printr_show_developer($arr){
	echo '<xmp>';
	print_r($arr);
	echo '</xmp>';
}
/*  */
function check_from_home(){
	if(isset($_SERVER['HTTP_REFERER']) && preg_match ("/".$_SERVER['HTTP_HOST']."/", $_SERVER['HTTP_REFERER'])){
		return true;
	}else{
		return false;
	}
}
/* 파일 캐시관리 */
function set_last_modified_mtime($file=''){
	$filepath = $_SERVER['DOCUMENT_ROOT'].$file;
	if(is_file($filepath) && !empty($file)){
		return '?'.stat($filepath)['mtime'];
	}else{
		return false;
	}
}
function fnc_custom_sort_key($arr, $key){
	$tmp = 0;
	for($i=0; $i<count($arr); $i++){
		for($j=0; $j<count($arr); $j++){
			if((int)$arr[$i][$key] < (int)$arr[$j][$key]){
				$tmp = $arr[$i];
				$arr[$i] = $arr[$j];
				$arr[$j] = $tmp;
			}
		}
	}
	return $arr;
}
/* 파일 체크 */
function fnc_upload_files($files=array()){
	foreach($files as $val){
		foreach($val['name'] as $name){
			if(!empty($name)) return true;
		}
	}
	return false;
}
function fnc_upload_files_ext_check($files='', $ext='jpg|gif|png|jpeg'){
	$ext = explode('|', $ext);
	foreach($files['bbs_file']['name'] as $val){
		if(empty($val)) continue;
		$arr = explode('.',$val);
		$stack = array_pop($arr);
		if(!in_array(strtolower($stack), $ext)){
			return false;
		}
	}
	return true;
}
function fnc_upload_files_size_check($files='', $size=1024){
	foreach($files['bbs_file']['tmp_name'] as $val){
		if(empty($val)) continue;
		if((filesize($val)/ 1024) > $size){
			return false;
		}
	}
	return true;
}
/* 1뎁스 하위에 new 아이콘이 있는지 */
function get_nav_newico_day_check($nav_li){
	if(isset($nav_li->nav_depth2)){
		foreach($nav_li->nav_depth2 as $val){
			if(strtotime($val->nav_new.'+'.'7'.' days') > strtotime(date('Y-m-d h:i:s', time()))){
				return true;
			}
			if(isset($val->nav_depth3)){
				foreach($val->nav_depth3 as $val2){
					if(strtotime($val2->nav_new.'+'.'7'.' days') > strtotime(date('Y-m-d h:i:s', time()))){
						return true;
					}
				}
			}
		}
	}
	return false;
}
// 페이지 상단 커스텀 탭메뉴
function fnc_set_custom_pageTabNav($pagetop_tab_data='', $match=''){
	$html = '';
	if(!empty($pagetop_tab_data)){
		$html = '
		<div class="page-3depth-nav-sec" id="page-3depth-nav-sec">
			<nav class="section_wrapper">
			<ul class="page-3depth-nav">';
			foreach($pagetop_tab_data as $key=>$val){
				$keyname = explode('__', $key);
				if(fnc_none_spacae($keyname[0]) === fnc_none_spacae($match)){
				$html .= '<li class="active"><strong class="menus">'.$keyname[1].'</strong></li>';
				}else{
				$html .= '<li><a href="'.site_url().$val.'" class="menus">'.$keyname[1].'</a></li>';
				}
			}
		$html .= '</ul>
			<span class="ico-open"></span>
			</nav>
		</div>
		';
	}
	return $html;
}
?>
