<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Homelanguage extends MY_Controller{
    protected $CI;
    protected $use_lang = array(
        'en',
        'ko',
        'vn'
    );
    public static $my_lang=null;
    public function __construct(){
        $this->CI =& get_instance();
        $this->home_meta = array(
            'slogan'    => array(
                'ko'    => '미네소타 대학교, 베트남',
                'en'    => 'University of Minnesota Vietnam',
                'vn'    => 'Đại học Minnesota Việt Nam'
            ),
            'keyword'   => array(
                'ko'    => '미네소타대학교, 미국유학, 미국대학, 비자, 캐나다 유학, 한국유학, 단기연수, 어학연수, 영어연수, 베트남어연수, 한국어교육, 베트남 취업, 취업직무교육, 대학생 연수',
                'en'    => 'University of Minnesota, No VISA rejection, Study aboard, US University, Canada University, Korean University. Short term program, English, Vietnamese, Korean, Liberal Arts, ESL, Job Training, Language Course',
                'vn'    => 'Đại học Minnesota, Không bị từ chối VISA, Du học, Đại học Mỹ, Đại học Canada, Đại học Hàn Quốc. Chương trình ngắn hạn, tiếng Anh, tiếng Việt, tiếng Hàn, Khóa học đại cương, ESL, đào tạo nghể nghiệp, khóa học ngôn ngữ'
            ),
            'description' => array(
                'ko'    => '미네소타대학교 진학, 2006부터 500명 이상 진학, 서류와 면접으로 선발, 미네소타대 교양수업, ESL수업, 자동 입학, 단기 어학연수, 영어, 베트남어, 한국어, 취업직무교육',
                'en'    => 'University of Minnesota Liberal Arts & ESL Course in Vietnam, Over 500 students admitted since 2006, NO SAT, Short term Program, Korean, English, Vietnamese, Job Training in Vitenam',
                'vn'    => 'Khóa học đại cương và ESL của Đại học Minnesota tại Việt Nam. Hơn 500 học sinh đã nhập học kể từ năm 2006, Không trải qua kỳ thi SAT, chương trình ngắn hạn, tiếng Hàn, tiếng Anh, tiếng Việt, đào tạo nghề nghiệp tại Việt Nam'
            )
        );
    }
    public function lang_seting($lang='en'){
        switch($lang){
            case 'ko' :
            case 'kr' :
                $lang = 'korean';
                break;
            case 'vn' :
            case 'vi' :
                $lang = 'vietnamese';
                break;
            default :
                $lang = 'english';
        }
        return $lang;
    }
    public function lang_switch($returnURI='', $lang='ko'){
        $this->CI->session->set_userdata('home_lang', $this->lang_seting($lang));
        return $returnURI;
    }
    public function check_lang_cut(){
        $lang = (isset($_SERVER['HTTP_ACCEPT_LANGUAGE']))?substr($_SERVER['HTTP_ACCEPT_LANGUAGE'], 0, 2):$this->use_lang[0];
        if($lang == 'vi') $lang = 'vn';
        return $lang;
    }
    public function lang_switch_link($uri='', $lang='en'){
        $exploded = explode('/', $uri);
        $check_lang = $exploded[0];
        if(preg_match('/^[a-zA-Z]{2}$/', $check_lang) && in_array($check_lang, $this->use_lang)){
            return preg_replace('/^[a-zA-Z]{2}/', $lang, $uri);
        }
        return $lang.'/'.$uri;
    }
    public function has_language($uri){
        $check_uri  = preg_replace('/(http(s)?:\/\/)([a-z0-9\w]+\.*)+[a-z0-9]{2,4}(\/)?/i', '', $uri);
        $exploded   = explode('/', $check_uri);
        $check_lang = $exploded[0];
        if(!empty($check_lang) && preg_match('/^[a-zA-Z]{2}$/', $check_lang) && in_array($check_lang, $this->use_lang)){
            self::$my_lang = $check_lang;
            return $check_lang;
		}else{
            $lang = $this->check_lang_cut();
            if(in_array($lang, $this->use_lang)){
                self::$my_lang = $lang;
                return $lang;
            }else{
                self::$my_lang = $this->use_lang;
                return $this->use_lang[0];
            }
        }
    }
    public function get_lang(){
        return self::$my_lang;
    }
    public function get_home_meta(){
        return $this->home_meta;
    }
    /*
    function return_domain($exploded, $check_lang, $lang, $uri_string){
        if(in_array($exploded[0], $check_lang)){
            return 'http://umvietnam.com/'.preg_replace('/^\w{2}/', $lang, $uri_string);
        }else{
            if(count($exploded)>0){
                return 'http://umvietnam.com/'.$lang.'/'.$uri_string;
            }else{
                return 'http://umvietnam.com/'.$lang.'/';
            }
        }
    }
    */
    private function set_return_lang_domain($exploded, $check_lang, $lang, $uri_string){
        if(in_array($exploded[0], $check_lang)){
            return 'http://umvietnam.com/'.preg_replace('/^\w{2}/', $lang, $uri_string);
        }else{
            if(count($exploded)>0){
                return 'http://umvietnam.com/'.$lang.'/'.$uri_string;
            }else{
                return 'http://umvietnam.com/'.$lang.'/';
            }
        }
    }
    public function set_lang_home_uri($uri='', $lang='en'){
    	if(preg_match('/^http:\/\/(www.)?umvietnam.com/i', $uri)){
    		// 홈페이지 링크로 시작된다면 뒤에 언어붙임
    		$uri_string = preg_replace('/^http:\/\/(www.)?umvietnam.com\//', '', $uri);
    		$exploded = explode('/', $uri_string);
            return $this->set_return_lang_domain($exploded, $this->use_lang, $lang, $uri_string);
    	}else{
    		// 다른홈페이지 주소인지 아닌지 확인
    		if(preg_match('/^http:\/\/(www.)?/i', $uri)){
                return $uri;
    		}else{
                $uri = preg_replace('/^\//', '', $uri);
                $exploded = explode('/', $uri);
                return $this->set_return_lang_domain($exploded, $this->use_lang, $lang, $uri);
            }
    	}
    }
}
?>
