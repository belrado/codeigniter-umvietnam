<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/*
| -------------------------------------------------------------------------
| URI ROUTING
| -------------------------------------------------------------------------
| This file lets you re-map URI requests to specific controller functions.
|
| Typically there is a one-to-one relationship between a URL string
| and its corresponding controller class/method. The segments in a
| URL normally follow this pattern:
|
|	example.com/class/method/id/
|
| In some instances, however, you may want to remap this relationship
| so that a different class/function is called than the one
| corresponding to the URL.
|
| Please see the user guide for complete details:
|
|	https://codeigniter.com/user_guide/general/routing.html
|
| -------------------------------------------------------------------------
| RESERVED ROUTES
| -------------------------------------------------------------------------
|
| There are three reserved routes:
|
|	$route['default_controller'] = 'welcome';
|
| This route indicates which controller class should be loaded if the
| URI contains no data. In the above example, the "welcome" class
| would be loaded.
|
|	$route['404_override'] = 'errors/page_missing';
|
| This route will tell the Router which controller/method to use if those
| provided in the URL cannot be matched to a valid route.
|
|	$route['translate_uri_dashes'] = FALSE;
|
| This is not exactly a route, but allows you to automatically route
| controller and method names that contain dashes. '-' isn't a valid
| class or method name character, so it requires translation.
| When you set this option to TRUE, it will replace ALL dashes in the
| controller and method URI segments.
|
| Examples:	my-controller/index	-> my_controller/index
|		my-controller/my-method	-> my_controller/my_method
*/
$route['default_controller'] = 'main';
$route['404_override'] = 'error_home';
$route['translate_uri_dashes'] = FALSE;
$route['comingsoon'] = '/main/comingsoon';
/* 3뎁스 */
/* 교육과정 */
$route['((ko|en|vn)/)?academic/college_credit/courses'] = '/academic/courses';
//$route['((ko|en|vn)/)?academic/college_credit/courses/(:num)'] = 'academic/courses/$3';
$route['((ko|en|vn)/)?academic/language/english']   = '/academic/english';
$route['((ko|en|vn)/)?academic/language/korean']    = '/academic/korean';
$route['((ko|en|vn)/)?academic/language/interview'] = '/academic/interview';
/* 단기연수과정 */
$route['((ko|en|vn)/)?shortterm/english/culture']       = '/shortterm/english_culture';
$route['((ko|en|vn)/)?shortterm/english/internship']    = '/shortterm/english_internship';
$route['((ko|en|vn)/)?shortterm/english/sub']           = '/shortterm/sub';
/* 오늘하루 안보기 */
$route['setTodayCookie']                    = '/main/setTodayCookie';
$route['((ko|en|vn)/)?sitemap']             = '/main/sitemap';
$route['((ko|en|vn)/)?umvtestpage']         = '/main/umvtestpage';
$route['((ko|en|vn)/)?privacy_policy']      = '/main/privacy_policy';
/* 게시판 */
$route['((ko|en|vn)/)?board/uploadCK/(:any)'] 					    = '/board/upload_imgfile_ckeditor/$3';
$route['((ko|en|vn)/)?board/update'] 								= '/board/bbs_update';
$route['((ko|en|vn)/)?board/write'] 								= '/board/bbs_write';
$route['((ko|en|vn)/)?board/write/(:any)']						    = '/board/bbs_write/$3';
$route['((ko|en|vn)/)?board/modify/(:any)/(:num)'] 				    = '/board/bbs_modify/$3/$4';
$route['((ko|en|vn)/)?board/list'] 								    = '/board/bbs_list';
$route['((ko|en|vn)/)?board/list/(:any)/(:num)'] 					= '/board/bbs_list/$3/all/$4';
$route['((ko|en|vn)/)?board/list/(:any)'] 						    = '/board/bbs_list/$3';
$route['((ko|en|vn)/)?board/list/(:any)/(:any)'] 					= '/board/bbs_list/$3/$4';
$route['((ko|en|vn)/)?board/list/(:any)/(:any)/(:num)'] 			= '/board/bbs_list/$3/$4/$5';
$route['((ko|en|vn)/)?board/view/(:any)/(:num)'] 					= '/board/bbs_view/$3/$4';
$route['((ko|en|vn)/)?board/delete'] 								= '/board/board_write_delete';
/* 언어셋 */
$route['^ko/(.+)'] = "$1";
$route['^ko$'] = $route['default_controller'];
$route['^en/(.+)'] = "$1";
$route['^en$'] = $route['default_controller'];
$route['^vn/(.+)'] = "$1";
$route['^vn$'] = $route['default_controller'];
/* 홈페이지 관리자 */
$route['homeAdm'] 									= '/adm/homeAdm';
$route['homeAdm/admin_block_user']					= '/adm/homeAdm/admin_block_user';
$route['homeAdm/login'] 							= '/adm/homeAdm/login';
$route['homeAdm/review'] 							= '/adm/homeAdm/review';
$route['homeAdm/review/update'] 					= '/adm/homeAdm/review_update';
$route['homeAdm/review/(:any)'] 					= '/adm/homeAdm/review/$1';
$route['homeAdm/review/(:any)/(:num)'] 				= '/adm/homeAdm/review/$1/$2';
$route['homeAdm/home_register']						= '/adm/homeAdm/home_register';
$route['homeAdm/home_register/(:num)']				= '/adm/homeAdm/home_register/$1';
$route['homeAdm/home_question']						= '/adm/homeAdm/home_question';
$route['homeAdm/home_question/(:num)']				= '/adm/homeAdm/home_question/$1';
$route['homeAdm/bbs'] 								= '/adm/homeAdm/bbs';
$route['homeAdm/bbs_update/(:any)'] 				= '/adm/homeAdm/bbs_update/$1';
$route['homeAdm/bbs_update/(:any)/(:any)'] 			= '/adm/homeAdm/bbs_update/$1/$2';
$route['homeAdm/bbs_delete'] 						= '/adm/homeAdm/bbs_delete';
$route['homeAdm/members'] 							= '/adm/homeAdm/members';
$route['homeAdm/members/(:any)']					= '/adm/homeAdm/members/$1';
$route['homeAdm/members/view/(:any)'] 				= '/adm/homeAdm/members/view/$1';
$route['homeAdm/members/delete/(:any)'] 			= '/adm/homeAdm/members/delete/$1';
$route['homeAdm/register'] 							= '/adm/homeAdm/register';
$route['homeAdm/confirm'] 							= '/adm/homeAdm/confirm';
$route['homeAdm/modify'] 							= '/adm/homeAdm/modify';
$route['homeAdm/change_password']					= '/adm/homeAdm/change_password';
$route['homeAdm/nav'] 								= '/adm/homeAdm/nav';
$route['homeAdm/nav/update'] 						= '/adm/homeAdm/nav_update';
$route['homeAdm/popup'] 							= '/adm/homeAdm/popup';
$route['homeAdm/popup_update']						= '/adm/homeAdm/popup_update';
$route['homeAdm/uploadCK'] 							= '/adm/homeAdm/upload_imgfile_ckeditor';
$route['homeAdm/uploadCK/(:any)'] 					= '/adm/homeAdm/upload_imgfile_ckeditor/$1';
$route['homeAdm/agreement']							= '/adm/homeAdm/home_agreement';
$route['homeAdm/agreement/(:any)']					= '/adm/homeAdm/home_agreement/$1';
$route['homeAdm/presentation']						= '/adm/homeAdm/presentation';
$route['homeAdm/presentation_excel']				= '/adm/homeAdm/presentation_excel';
$route['homeAdm/presentation_day']					= '/adm/homeAdm/presentation_day';
$route['homeAdm/presentation_day/(:any)'] 			= '/adm/homeAdm/presentation_day/$1';
$route['homeAdm/presentation_day/(:any)/(:num)'] 	= '/adm/homeAdm/presentation_day/$1/$2';
$route['homeAdm/individual']						= '/adm/homeAdm/individual';
$route['homeAdm/individual/(:any)']					= '/adm/homeAdm/individual/$1';
$route['homeAdm/individual/(:any)/(:any)']			= '/adm/homeAdm/individual/$1/$2';
$route['homeAdm/individual/(:any)/(:any)/(:num)']	= '/adm/homeAdm/individual/$1/$2/$3';
$route['homeAdm/individual_view/(:num)/(:num)']		= '/adm/homeAdm/individual_view/$1/$2';
$route['homeAdm/presentation/(:any)']				= '/adm/homeAdm/presentation/$1';
$route['homeAdm/presentation/(:any)/(:any)']		= '/adm/homeAdm/presentation/$1/$2';
$route['homeAdm/presentation/(:any)/(:any)/(:num)']	= '/adm/homeAdm/presentation/$1/$2/$3';
$route['homeAdm/presentation_view/(:num)/(:num)']	= '/adm/homeAdm/presentation_view/$1/$2';
$route['homeAdm/presentation_update']				= '/adm/homeAdm/presentation_update';
$route['homeAdm/presentation_user_update']			= '/adm/homeAdm/presentation_user_update';
$route['homeAdm/error_log']							= '/adm/homeAdm/error_log';
$route['homeAdm/error_log/(:num)']					= '/adm/homeAdm/error_log/$1';
$route['homeAdm/qna']						        = '/adm/qna';
$route['homeAdm/qna/list']						    = '/adm/qna/list';
$route['homeAdm/qna/list/(:num)']					= '/adm/qna/list/$1';
$route['homeAdm/qna/view/(:num)']					= '/adm/qna/view/$1';
$route['homeAdm/univ']						        = '/adm/univ';
$route['homeAdm/univ/write']						= '/adm/univ/write';
$route['homeAdm/univ/write/(:num)']			        = '/adm/univ/write/$1';
$route['homeAdm/univ/list']						    = '/adm/univ/list';
$route['homeAdm/univ/list/(:num)']					= '/adm/univ/list/$1';
//$route['homeAdm/qna']						        = '/adm/qna';
/*교육과정*/
