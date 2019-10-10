<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Facebookapi{
    private $CI;
    private $client_id;
    private $client_secret;
    private $redirectURI;

    public function __construct(){
        $this->CI               = & get_instance();
        $this->client_id        = FACEBOOK_APP_ID;
        $this->client_secret    = FACEBOOK_APP_SECRET; 
        $this->redirectURI      = urlencode(site_url().'auth/facebook/');
    }
    // 로그인 인증 및 엑섹스토큰 받아옴
    public function authorize($code='', $state=''){
        //$state = $this->CI->security->get_csrf_hash();
		$url = "https://graph.facebook.com/v3.3/oauth/access_token?client_id=".$this->client_id."&redirect_uri=".$this->redirectURI."&client_secret=".$this->client_secret."&code=".$code;
		$is_post = false;
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL, $url);
		curl_setopt($ch, CURLOPT_POST, $is_post);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		$headers = array();
		$response = curl_exec($ch);
		$status_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
		curl_close($ch);
		$response = json_decode($response);
        if($status_code==200 && isset($response->access_token)){
			return $response;
		}else{
			return false;
		}
	}

    public function check_token($token=''){
        $url = "https://graph.facebook.com/me?fields=id&access_token=".$token;
		$is_post = false;
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL, $url);
		curl_setopt($ch, CURLOPT_POST, $is_post);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		$headers = array();
		$response = curl_exec($ch);
		$status_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
		curl_close($ch);
		$response = json_decode($response);
        if($status_code==200){
			return $response;
		}else{
			return false;
		}
    }
    public function get_userinfo($token){
        $url = "https://graph.facebook.com/v3.3/me/?fields=id,name,email&access_token=".$token;
        $is_post = false;
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_POST, $is_post);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $headers = array();
        $response = curl_exec($ch);
        $status_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        curl_close($ch);
        $response = json_decode($response);
        if($status_code==200){
			return $response;
		}else{
			return false;
		}
    }
    public function check_permissions($token=''){
        $url = "https://graph.facebook.com/v3.3/me/permissions/?access_token=".$token;
        $is_post = false;
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_POST, $is_post);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $headers = array();
        $response = curl_exec($ch);
        $status_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        curl_close($ch);
        $response = json_decode($response);
        if($status_code==200){
            return $response;
        }else{
            return false;
        }
    }
    public function re_request_uri(){
        return "https://www.facebook.com/v3.3/dialog/oauth/?client_id=".$this->client_id."&redirect_uri=".$this->redirectURI."&auth_type=rerequest&scope=email";
    }
    // 이건 로그아웃이 아닌 앱 탈퇴임 ㅎㅎ
    public function revoking_login($token){
        $url = "https://graph.facebook.com/v3.3/me/permissions/?access_token=".$token;
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "DELETE");
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $headers = array();
        $response = curl_exec($ch);
        $response = json_decode($response);
        $status_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        curl_close($ch);
        if($status_code==200){
            return true;
        }else{
            return false;
        }
    }
    public function logout($id, $token){
        $url = "https://graph.facebook.com/v3.3/me/permissions/?access_token=".$token;
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "DELETE");
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $headers = array();
        $response = curl_exec($ch);
        $response = json_decode($response);
        $status_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        curl_close($ch);
        echo $status_code;
        printr_show_developer($response);
        if($status_code==200){
            return true;
        }else{
            return false;
        }
    }
}
?>
