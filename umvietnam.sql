-- phpMyAdmin SQL Dump
-- version 4.4.15.10
-- https://www.phpmyadmin.net
--
-- Host: localhost
-- 생성 시간: 19-07-08 08:15
-- 서버 버전: 10.3.16-MariaDB
-- PHP 버전: 7.2.20

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- 데이터베이스: `umvietnam`
--

-- --------------------------------------------------------

--
-- 테이블 구조 `psu_board_files`
--

CREATE TABLE IF NOT EXISTS `psu_board_files` (
  `bf_id` int(12) unsigned NOT NULL,
  `bf_table` varchar(30) NOT NULL,
  `bf_bbs_id` int(12) unsigned NOT NULL,
  `bf_type` varchar(5) NOT NULL DEFAULT 'files',
  `bf_name` varchar(255) NOT NULL,
  `bf_alt` text NOT NULL,
  `bf_path` varchar(255) NOT NULL,
  `bf_full_path` varchar(255) NOT NULL,
  `bf_orig_name` varchar(255) NOT NULL,
  `bf_ext` varchar(10) NOT NULL,
  `bf_size` varchar(10) NOT NULL,
  `bf_is_img` varchar(1) NOT NULL,
  `bf_img_width` varchar(10) NOT NULL,
  `bf_img_height` varchar(10) NOT NULL,
  `bf_register` datetime NOT NULL DEFAULT '0000-00-00 00:00:00'
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- 테이블 구조 `psu_board_group`
--

CREATE TABLE IF NOT EXISTS `psu_board_group` (
  `bbs_table` varchar(30) NOT NULL,
  `bbs_name_ko` varchar(255) NOT NULL,
  `bbs_name_en` varchar(255) NOT NULL,
  `bbs_name_vn` varchar(255) NOT NULL,
  `bbs_type` varchar(10) NOT NULL DEFAULT 'list',
  `bbs_css_type` varchar(13) NOT NULL,
  `bbs_sort_type` varchar(10) NOT NULL DEFAULT 'sort_asc',
  `bbs_1depth` int(12) unsigned NOT NULL DEFAULT 0,
  `bbs_page_tophtml` text NOT NULL,
  `bbs_cate_list` text NOT NULL,
  `bbs_cate_use` varchar(3) NOT NULL DEFAULT 'yes',
  `bbs_adm_lv` tinyint(4) unsigned NOT NULL DEFAULT 7,
  `bbs_list_lv` tinyint(4) unsigned NOT NULL DEFAULT 1,
  `bbs_read_lv` tinyint(4) unsigned NOT NULL DEFAULT 1,
  `bbs_write_lv` tinyint(4) unsigned NOT NULL DEFAULT 1,
  `bbs_reply_lv` tinyint(4) unsigned NOT NULL DEFAULT 1,
  `bbs_comment_lv` tinyint(4) unsigned NOT NULL DEFAULT 1,
  `bbs_upload_lv` tinyint(4) unsigned NOT NULL DEFAULT 1,
  `bbs_download_lv` tinyint(4) unsigned NOT NULL DEFAULT 1,
  `bbs_list_num` tinyint(4) unsigned NOT NULL DEFAULT 15,
  `bbs_feed` varchar(3) NOT NULL DEFAULT 'yes',
  `bbs_syndication` varchar(3) NOT NULL DEFAULT 'no',
  `bbs_register` datetime NOT NULL DEFAULT '0000-00-00 00:00:00'
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- 테이블의 덤프 데이터 `psu_board_group`
--

INSERT INTO `psu_board_group` (`bbs_table`, `bbs_name_ko`, `bbs_name_en`, `bbs_name_vn`, `bbs_type`, `bbs_css_type`, `bbs_sort_type`, `bbs_1depth`, `bbs_page_tophtml`, `bbs_cate_list`, `bbs_cate_use`, `bbs_adm_lv`, `bbs_list_lv`, `bbs_read_lv`, `bbs_write_lv`, `bbs_reply_lv`, `bbs_comment_lv`, `bbs_upload_lv`, `bbs_download_lv`, `bbs_list_num`, `bbs_feed`, `bbs_syndication`, `bbs_register`) VALUES
('news', 'news', 'news', 'news', 'list_img', 'bbs_typeB', 'sort_asc', 6, '', 'news|notice', 'yes', 7, 1, 1, 7, 1, 0, 1, 1, 15, 'yes', 'no', '2019-05-21 17:02:07'),
('faq', 'FAQ', 'FAQ', 'FAQ', 'toggle', 'bbs_typeA', 'sort_asc', 6, '', '', 'yes', 0, 1, 1, 7, 1, 0, 1, 1, 15, 'yes', 'no', '2019-06-10 16:38:12'),
('qna', 'QNA', 'QNA', 'QNA', 'list_img', 'bbs_typeA', 'sort_asc', 6, '', '', 'yes', 7, 1, 1, 2, 1, 2, 1, 1, 10, 'yes', 'no', '2019-07-01 09:17:33'),
('umvbbst', 'test', 'test', 'test', 'list_img', 'bbs_typeB', 'sort_asc', 0, '', '', 'yes', 7, 1, 1, 2, 1, 2, 1, 1, 15, 'yes', 'no', '2019-07-02 09:37:23');

-- --------------------------------------------------------

--
-- 테이블 구조 `psu_board_scrap`
--

CREATE TABLE IF NOT EXISTS `psu_board_scrap` (
  `s_id` int(12) unsigned NOT NULL,
  `u_id` varchar(50) NOT NULL,
  `b_table` varchar(40) NOT NULL,
  `b_id` int(12) unsigned NOT NULL,
  `s_register` datetime NOT NULL DEFAULT '0000-00-00 00:00:00'
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- 테이블 구조 `psu_homepage`
--

CREATE TABLE IF NOT EXISTS `psu_homepage` (
  `h_id` int(12) unsigned NOT NULL,
  `h_name` varchar(30) NOT NULL,
  `h_url` varchar(255) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8;

--
-- 테이블의 덤프 데이터 `psu_homepage`
--

INSERT INTO `psu_homepage` (`h_id`, `h_name`, `h_url`) VALUES
(1, 'psuedu', 'http://psuedu.org'),
(2, 'mediprep', 'http://mediprep.co.kr'),
(3, 'psuuhak', 'http://psuuhak.com');

-- --------------------------------------------------------

--
-- 테이블 구조 `psu_log_record`
--

CREATE TABLE IF NOT EXISTS `psu_log_record` (
  `log_id` int(12) unsigned NOT NULL,
  `log_type` varchar(10) NOT NULL,
  `log_write_id` varchar(255) NOT NULL,
  `log_ip` varchar(20) NOT NULL,
  `log_agent` varchar(255) NOT NULL,
  `log_referer` varchar(255) NOT NULL,
  `log_cookie` text NOT NULL,
  `log_value` text NOT NULL,
  `log_register` datetime NOT NULL DEFAULT '0000-00-00 00:00:00'
) ENGINE=MyISAM AUTO_INCREMENT=46 DEFAULT CHARSET=utf8;

--
-- 테이블 구조 `psu_mem_myqna`
--

CREATE TABLE IF NOT EXISTS `psu_mem_myqna` (
  `mq_no` int(12) NOT NULL,
  `user_id` varchar(50) NOT NULL COMMENT '회원아이디',
  `mq_subject` varchar(255) NOT NULL,
  `mq_content` text NOT NULL,
  `mq_content_imgs` text NOT NULL,
  `mq_use` varchar(3) NOT NULL DEFAULT 'yes' COMMENT '답변있을때 삭제',
  `mq_reply` varchar(3) NOT NULL DEFAULT 'no' COMMENT '답변달렸는지',
  `mq_read` varchar(3) NOT NULL DEFAULT 'no' COMMENT '답변있을때읽었는지',
  `mq_file1` varchar(255) NOT NULL,
  `mq_file2` varchar(255) NOT NULL,
  `mq_register` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `mq_ip` varchar(30) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- 테이블 구조 `psu_mem_myqna_reply`
--

CREATE TABLE IF NOT EXISTS `psu_mem_myqna_reply` (
  `mr_no` int(12) NOT NULL,
  `mq_no` int(12) NOT NULL,
  `user_id` varchar(50) NOT NULL COMMENT '관리자',
  `mr_content` text NOT NULL,
  `mr_read` varchar(3) NOT NULL DEFAULT 'no',
  `mr_register` datetime NOT NULL DEFAULT '0000-00-00 00:00:00'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- 테이블 구조 `psu_mem_presentation`
--

CREATE TABLE IF NOT EXISTS `psu_mem_presentation` (
  `p_no` int(12) NOT NULL,
  `u_id` int(12) unsigned NOT NULL COMMENT '설명회등록자id',
  `user_id` varchar(50) NOT NULL COMMENT '회원id',
  `p_register` datetime NOT NULL DEFAULT '0000-00-00 00:00:00' COMMENT '등록일'
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;

--
-- 테이블의 덤프 데이터 `psu_mem_presentation`
--

INSERT INTO `psu_mem_presentation` (`p_no`, `u_id`, `user_id`, `p_register`) VALUES
(1, 1, '102135911025196@facebook.com', '0000-00-00 00:00:00');

-- --------------------------------------------------------

--
-- 테이블 구조 `psu_menu`
--

CREATE TABLE IF NOT EXISTS `psu_menu` (
  `nav_id` int(12) unsigned NOT NULL,
  `nav_name_ko` varchar(50) NOT NULL,
  `nav_access` varchar(50) NOT NULL,
  `nav_depth` varchar(8) NOT NULL DEFAULT '1depth',
  `nav_parent` int(10) unsigned NOT NULL DEFAULT 0,
  `nav_sub_parent` int(12) NOT NULL DEFAULT 0,
  `nav_link` varchar(255) NOT NULL,
  `nav_target` varchar(7) NOT NULL DEFAULT 'self',
  `nav_class` varchar(100) NOT NULL,
  `nav_index` tinyint(4) unsigned NOT NULL DEFAULT 1,
  `nav_new` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `nav_meta_title_ko` varchar(100) NOT NULL,
  `nav_meta_keyword_ko` varchar(255) NOT NULL,
  `nav_meta_description_ko` tinytext NOT NULL,
  `nav_name_en` varchar(50) NOT NULL,
  `nav_meta_title_en` varchar(100) NOT NULL,
  `nav_meta_keyword_en` varchar(255) NOT NULL,
  `nav_meta_description_en` tinytext NOT NULL,
  `nav_name_vn` varchar(50) NOT NULL,
  `nav_meta_title_vn` varchar(100) NOT NULL,
  `nav_meta_keyword_vn` varchar(255) NOT NULL,
  `nav_meta_description_vn` tinytext NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=73 DEFAULT CHARSET=utf8 ROW_FORMAT=COMPACT;

--
-- 테이블의 덤프 데이터 `psu_menu`
--

INSERT INTO `psu_menu` (`nav_id`, `nav_name_ko`, `nav_access`, `nav_depth`, `nav_parent`, `nav_sub_parent`, `nav_link`, `nav_target`, `nav_class`, `nav_index`, `nav_new`, `nav_meta_title_ko`, `nav_meta_keyword_ko`, `nav_meta_description_ko`, `nav_name_en`, `nav_meta_title_en`, `nav_meta_keyword_en`, `nav_meta_description_en`, `nav_name_vn`, `nav_meta_title_vn`, `nav_meta_keyword_vn`, `nav_meta_description_vn`) VALUES
(1, 'UMVietnam', 'umv', '1depth', 0, 0, 'umv', 'self', '', 1, '0000-00-00 00:00:00', '', '', '', 'UMVietnam', '', '', '', 'Đại học Minnesota <br>Việt Nam', '', '', ''),
(4, '단기연수 과정', 'shortterm', '1depth', 0, 0, 'shortterm', 'self', '', 4, '0000-00-00 00:00:00', '', '', '', 'Short-Term Program', '', '', '', 'Khóa tiếng Anh <br>ngắn hạn', '', '', ''),
(6, '커뮤니티', 'community', '1depth', 0, 0, 'community', 'self', '', 5, '0000-00-00 00:00:00', '', '', '', 'Community', '', '', '', 'Cộng đồng', '', '', ''),
(9, '오시는 길', 'map', '2depth', 1, 0, 'umv/map', 'self', '', 4, '0000-00-00 00:00:00', '오시는 길', '', '', 'Location and Maps', 'Location and Maps', '', '', 'Địa điểm và Bản đồ', 'Địa điểm và Bản đồ', '', ''),
(20, '영어 & 문화탐방', 'english_culture', '2depth', 4, 0, 'shortterm/english/culture', 'self', '', 2, '0000-00-00 00:00:00', '', '', '', 'English & Culture', '', '', '', 'Tiếng Anh và Văn hóa', '', '', ''),
(21, '영어 & 인터십', 'english_internship', '2depth', 4, 0, 'shortterm/english/internship', 'self', '', 3, '0000-00-00 00:00:00', '', '', '', 'English & Internship', '', '', '', 'Tiếng Anh và Thực tập', '', '', ''),
(33, '뉴스 & 공지사항', 'news', '2depth', 6, 0, 'board/list/news', 'self', '', 1, '0000-00-00 00:00:00', '', '', '', 'News & Notice', '', '', '', 'Thông báo và Tin tức', '', '', ''),
(36, '자주하는 질문', 'faq', '2depth', 6, 0, 'board/list/faq', 'self', '', 2, '0000-00-00 00:00:00', '', '', '', 'FAQ', '', '', '', 'Những câu hỏi thường gặp', '', '', ''),
(38, 'UMVietnam 소개', 'about', '2depth', 1, 0, 'umv/about/', 'self', '', 3, '0000-00-00 00:00:00', 'UMVietnam 소개', '', '', 'About UMVietnam', 'About UMVietnam', '', '', 'Đại học Minnesota Việt Nam', 'Đại học Minnesota Việt Nam', '', ''),
(39, '프로그램', 'program', '2depth', 4, 0, 'shortterm/program', 'self', '', 1, '0000-00-00 00:00:00', '', '', '', 'Program', '', '', '', 'Chương trình', '', '', ''),
(41, '미네소타 대학교 인사말', 'minnesota', '2depth', 1, 0, 'umv/minnesota', 'self', '', 1, '0000-00-00 00:00:00', '미네소타 대학교 인사말', '', '', 'University of Minnesota', 'University of Minnesota', '', '', 'Đại học Minnesota', 'Đại học Minnesota', '', ''),
(42, '미네소타 대학교 소개', 'minnesota_intro', '2depth', 1, 0, 'umv/minnesota_intro', 'self', '', 2, '0000-00-00 00:00:00', '미네소타 대학교 소개', '', '', 'Intro to U of M', 'Intro to U of M', '', '', 'Giới thiệu Đại học Minnesota', 'Giới thiệu Đại học Minnesota', '', ''),
(43, '설명회 예약', 'Info_sessions', '2depth', 6, 0, 'community/info_sessions', 'self', '', 4, '0000-00-00 00:00:00', '', '', '', 'Information Sessions', '', '', '', 'Buổi thông tin', '', '', ''),
(44, '미네소타대학 과정', 'minnesota', '1depth', 0, 0, 'minnesota', 'self', '', 2, '0000-00-00 00:00:00', '', '', '', 'Minnesota Program', '', '', '', 'Chương trình <br>Minnesota', '', '', ''),
(45, '한국대학 과정', 'korean', '1depth', 0, 0, 'korean', 'self', '', 3, '0000-00-00 00:00:00', '', '', '', 'Korean Program', '', '', '', 'Chương trình <br>tiếng Hàn', '', '', ''),
(46, '프로그램', 'program', '2depth', 44, 0, 'minnesota/program', 'self', '', 1, '0000-00-00 00:00:00', '미네소타대학 과정', '', '', 'Program', 'Minnesota Program', '', '', 'Chương trình', 'Chương trình Minnesota', '', ''),
(47, '지원전공', 'major', '2depth', 44, 0, 'minnesota/major', 'self', '', 1, '0000-00-00 00:00:00', 'Minnesota  지원전공', '', '', 'Majors', 'Minnesota Majors', '', '', 'Các chuyên ngành', 'Các chuyên ngành Minnesota', '', ''),
(48, '교육과정', 'curriculum', '2depth', 44, 0, 'minnesota/curriculum', 'self', '', 1, '0000-00-00 00:00:00', 'Minnesota 교육과정', '', '', 'Curriculum', 'Minnesota Curriculum', '', '', 'Chương trình giảng dạy', 'Chương trình giảng dạy Minnesota', '', ''),
(49, '전형안내', 'admissions', '2depth', 44, 0, 'minnesota/admissions', 'self', '', 1, '0000-00-00 00:00:00', 'Minnesota 전형안내', '', '', 'Admissions', 'Minnesota Admissions', '', '', 'Tuyển sinh', 'Tuyển sinh Minnesota', '', ''),
(50, '합격자발표', 'accepted', '2depth', 44, 0, 'minnesota/accepted', 'self', '', 1, '0000-00-00 00:00:00', 'Minnesota 합격자발표', '', '', 'Accepted Student', 'Minnesota Accepted Student', '', '', 'Sinh viên trúng tuyển', 'Sinh viên trúng tuyển Minnesota', '', ''),
(51, '프로그램', 'program', '2depth', 45, 0, 'korean/program', 'self', '', 1, '0000-00-00 00:00:00', '', '', '', 'Program', '', '', '', 'Chương trình', '', '', ''),
(52, '협력대학교', 'university', '2depth', 45, 0, 'korean/university', 'self', '', 1, '0000-00-00 00:00:00', '', '', '', 'Affiliated Universities', '', '', '', 'Các trường đại học liên kết', '', '', ''),
(53, '한국어과정', 'topik', '2depth', 45, 0, 'korean/topik', 'self', '', 1, '0000-00-00 00:00:00', '', '', '', 'TOPIK', '', '', '', 'Kỳ thi năng lực tiếng Hàn', '', '', ''),
(66, 'QNA', 'qna', '2depth', 6, 0, 'board/list/qna', 'self', '', 3, '0000-00-00 00:00:00', '', '', '', 'QNA', '', '', '', 'QNA', '', '', '');

-- --------------------------------------------------------

--
-- 테이블 구조 `psu_options`
--

CREATE TABLE IF NOT EXISTS `psu_options` (
  `opt_id` int(12) unsigned NOT NULL,
  `opt_name` varchar(60) NOT NULL,
  `opt_value` text NOT NULL
) ENGINE=MyISAM AUTO_INCREMENT=15 DEFAULT CHARSET=utf8;

--
-- 테이블의 덤프 데이터 `psu_options`
--

INSERT INTO `psu_options` (`opt_id`, `opt_name`, `opt_value`) VALUES
(1, 'agreement_ko', '<p>UMVietnam (&#39;https://umvietnam.com&#39;)은(는) 개인정보보호법에 따라 이용자의 개인정보 보호 및 권익을 보호하고 개인정보와 관련한 이용자의 고충을 원활하게 처리할 수 있도록 다음과 같은 처리방침을 두고 있습니다.</p>\r\n\r\n<p><br>\r\nUMVietnam 은(는) 회사는 개인정보처리방침을 개정하는 경우 웹사이트 공지사항(또는 개별공지)을 통하여 공지할 것입니다.</p>\r\n\r\n<p><br>\r\n○ 본 방침은부터 2016년 10월 1일부터 시행됩니다.</p>\r\n\r\n<p><br>\r\n1. 개인정보의 처리 목적 UMVietnam (&#39;https://umvietnam.com&#39;)은(는) 개인정보를 다음의 목적을 위해 처리합니다. 처리한 개인정보는 다음의 목적이외의 용도로는 사용되지 않으며 이용 목적이 변경될 시에는 사전동의를 구할 예정입니다.<br>\r\n가. 홈페이지 회원가입 및 관리<br>\r\n회원 가입의사 확인, 회원제 서비스 제공에 따른 본인 식별·인증, 각종 고지·통지 등을 목적으로 개인정보를 처리합니다.<br>\r\n나. 마케팅 및 광고에의 활용<br>\r\n신규 서비스(제품) 개발 및 맞춤 서비스 제공, 이벤트 및 광고성 정보 제공 및 참여기회 제공 등을 목적으로 개인정보를 처리합니다.<br>\r\n2. 개인정보 파일 현황<br>\r\n개인정보는 별도의 DB에 옮겨져 내부 방침 및 기타 관련 법령에 따라 일정기간 저장된 후 혹은 즉시 파기됩니다. <br>\r\n3. 개인정보처리 위탁<br>\r\n① UMVietnam 은(는) 개인정보 위탁처리를 하지 않습니다.<br>\r\n4. 정보주체의 권리,의무 및 그 행사방법 이용자는 개인정보주체로서 다음과 같은 권리를 행사할 수 있습니다.<br>\r\n① 정보주체는 UMVietnam (‘https://umvietnam.com’) 에 대해 언제든지 다음 각 호의 개인정보 보호 관련 권리를 행사할 수 있습니다.<br>\r\n1. 개인정보 열람요구<br>\r\n2. 오류 등이 있을 경우 정정 요구<br>\r\n3. 삭제요구<br>\r\n4. 처리정지 요구<br>\r\n② 제1항에 따른 권리 행사는 UMVietnam (‘https://umvietnam.com’이하 ‘PSU에듀센터) 에 대해 개인정보 보호법 시행규칙 별지 제8호 서식에 따라 서면, 전자우편, 모사전송(FAX) 등을 통하여 하실 수 있으며 &lt;기관/회사명>(‘사이트URL’이하 ‘사이트명) 은(는) 이에 대해 지체 없이 조치하겠습니다.<br>\r\n③ 정보주체가 개인정보의 오류 등에 대한 정정 또는 삭제를 요구한 경우에는 &lt;기관/회사명>(‘사이트URL’이하 ‘사이트명) 은(는) 정정 또는 삭제를 완료할 때까지 당해 개인정보를 이용하거나 제공하지 않습니다.<br>\r\n④ 제1항에 따른 권리 행사는 정보주체의 법정대리인이나 위임을 받은 자 등 대리인을 통하여 하실 수 있습니다. 이 경우 개인정보 보호법 시행규칙 별지 제11호 서식에 따른 위임장을 제출하셔야 합니다.<br>\r\n5. 처리하는 개인정보의 항목 작성 <br>\r\n① UMVietnam (&#39;https://umvietnam.com&#39;이하)은(는) 다음의 개인정보 항목을 처리하고 있습니다.<br>\r\n1&lt;홈페이지 회원가입 및 관리><br>\r\n- 필수항목 : 이메일, 휴대전화번호, 비밀번호, 로그인ID, 이름, 접속 로그, 쿠키, 접속 IP 정보<br>\r\n6. 개인정보의 파기 UMVietnam 은(는) 원칙적으로 개인정보 처리목적이 달성된 경우에는 지체없이 해당 개인정보를 파기합니다. 파기의 절차, 기한 및 방법은 다음과 같습니다.<br>\r\n-파기절차이용자가 입력한 정보는 목적 달성 후 별도의 DB에 옮겨져(종이의 경우 별도의 서류) 내부 방침 및 기타 관련 법령에 따라 일정기간 저장된 후 혹은 즉시 파기됩니다. 이 때, DB로 옮겨진 개인정보는 법률에 의한 경우가 아니고서는 다른 목적으로 이용되지 않습니다.-파기기한이용자의 개인정보는 개인정보의 보유기간이 경과된 경우에는 보유기간의 종료일로부터 5일 이내에, 개인정보의 처리 목적 달성, 해당 서비스의 폐지, 사업의 종료 등 그 개인정보가 불필요하게 되었을 때에는 개인정보의 처리가 불필요한 것으로 인정되는 날로부터 5일 이내에 그 개인정보를 파기합니다.<br>\r\n7. 개인정보의 안전성 확보 조치 UMVietnam 은(는) 개인정보보호법 제29조에 따라 다음과 같이 안전성 확보에 필요한 기술적/관리적 및 물리적 조치를 하고 있습니다.<br>\r\n1. 정기적인 자체 감사 실시<br>\r\n개인정보 취급 관련 안정성 확보를 위해 정기적(분기 1회)으로 자체 감사를 실시하고 있습니다.<br>\r\n2. 내부관리계획의 수립 및 시행<br>\r\n개인정보의 안전한 처리를 위하여 내부관리계획을 수립하고 시행하고 있습니다.<br>\r\n3. 해킹 등에 대비한 기술적 대책<br>\r\nUMVietnam 은 해킹이나 컴퓨터 바이러스 등에 의한 개인정보 유출 및 훼손을 막기 위하여 보안프로그램을 설치하고 주기적인 갱신·점검을 하며 외부로부터 접근이 통제된 구역에 시스템을 설치하고 기술적/물리적으로 감시 및 차단하고 있습니다.<br>\r\n4. 개인정보에 대한 접근 제한<br>\r\n개인정보를 처리하는 데이터베이스시스템에 대한 접근권한의 부여,변경,말소를 통하여 개인정보에 대한 접근통제를 위하여 필요한 조치를 하고 있으며 침입차단시스템을 이용하여 외부로부터의 무단 접근을 통제하고 있습니다.<br>\r\n8. 개인정보 보호책임자 작성<br>\r\n① UMVietnam (‘https://umvietnam.com’) 은(는) 개인정보 처리에 관한 업무를 총괄해서 책임지고, 개인정보 처리와 관련한 정보주체의 불만처리 및 피해구제 등을 위하여 아래와 같이 개인정보 보호책임자를 지정하고 있습니다.</p>\r\n\r\n<p><br>\r\n▶ 개인정보 보호책임자 <br>\r\n성명 :이상윤<br>\r\n직급 :원장<br>\r\n연락처 :02-540-2510, admission@umvietnam.com<br>\r\n② 정보주체께서는 UMVietnam (‘https://umvietnam.com’) 의 서비스(또는 사업)을 이용하시면서 발생한 모든 개인정보 보호 관련 문의, 불만처리, 피해구제 등에 관한 사항을 개인정보 보호책임자 및 담당부서로 문의하실 수 있습니다. <br>\r\nUMVietnam (‘https://umvietnam.com’) 은(는) 정보주체의 문의에 대해 지체 없이 답변 및 처리해드릴 것입니다.<br>\r\n9. 개인정보 처리방침 변경<br>\r\n①이 개인정보처리방침은 시행일로부터 적용되며, 법령 및 방침에 따른 변경내용의 추가, 삭제 및 정정이 있는 경우에는 변경사항의 시행 7일 전부터 공지사항을 통하여 고지할 것입니다.</p>\r\n'),
(4, 'popup_event', 'a:1:{i:0;a:27:{s:14:"pop_subject_ko";s:48:"미네소타대학교 1+3 입학전형 설명회";s:14:"pop_subject_en";s:46:"University of Minnesota 1+3 admission workshop";s:14:"pop_subject_vn";s:54:"Hội thảo tuyển sinh 1 + 3 Đại học Minnesota";s:9:"pop_class";s:0:"";s:11:"pop_text_ko";s:0:"";s:11:"pop_text_en";s:0:"";s:11:"pop_text_vn";s:0:"";s:10:"pop_useday";s:0:"";s:12:"pop_viewtype";s:0:"";s:10:"pop_alt_ko";s:134:"7월 7일 설명회 일정 오전 9시, 장소: TOONG COWORKING SPACE (Tòa nhà Itaxa, 126 Nguyễn Thị Minh Khai, Quận 3, TPHCM)";s:10:"pop_alt_en";s:121:"Time: July 7, 2019 9 am, Location: TOONG COWORKING SPACE (Tòa nhà Itaxa, 126 Nguyễn Thị Minh Khai, Quận 3, TPHCM)";s:10:"pop_alt_vn";s:114:"9:00 ngày 07/07/2019 tại TOONG COWORKING SPACE (Tòa nhà Itaxa, 126 Nguyễn Thị Minh Khai, Quận 3, TPHCM)";s:8:"pop_link";s:48:"https://umvietnam.com/ko/community/info_sessions";s:10:"pop_target";s:5:"_self";s:16:"pop_orig_name_ko";s:20:"pop-4-2(400x450).jpg";s:16:"pop_file_name_ko";s:36:"6745d5f4a4e294311ca9de07057e1636.jpg";s:16:"pop_file_path_ko";s:55:"/assets/file/popup/6745d5f4a4e294311ca9de07057e1636.jpg";s:16:"pop_full_path_ko";s:97:"/home/psu_umv/www/myApp_codeigniter/public/assets/file/popup/6745d5f4a4e294311ca9de07057e1636.jpg";s:16:"pop_orig_name_en";s:20:"pop-4-2(400x450).jpg";s:16:"pop_file_name_en";s:36:"d225db2ff259151ade1a6b3654f95b67.jpg";s:16:"pop_file_path_en";s:55:"/assets/file/popup/d225db2ff259151ade1a6b3654f95b67.jpg";s:16:"pop_full_path_en";s:97:"/home/psu_umv/www/myApp_codeigniter/public/assets/file/popup/d225db2ff259151ade1a6b3654f95b67.jpg";s:16:"pop_orig_name_vn";s:20:"pop-4-2(400x450).jpg";s:16:"pop_file_name_vn";s:36:"59c11651cebd841f80194970613216ba.jpg";s:16:"pop_file_path_vn";s:55:"/assets/file/popup/59c11651cebd841f80194970613216ba.jpg";s:16:"pop_full_path_vn";s:97:"/home/psu_umv/www/myApp_codeigniter/public/assets/file/popup/59c11651cebd841f80194970613216ba.jpg";s:12:"pop_register";s:19:"2019-07-01 07:00:36";}}'),
(14, 'agreement_vn', '<p><strong>Chính Sách Bảo Mật</strong></p>\r\n\r\n<p><br>\r\nThông tin cá nhân của khách hàng (\\"Thông tin cá nhân\\") cung cấp bởi khách hàng sẽ được quản lý bởi Đại học Minnesota Việt Nam (\\"Công ty\\").</p>\r\n\r\n<p>Công ty sẽ tuân thủ luật và các tiêu chuẩn liên quan đến sự bảo vệ thông tin cá nhân, và thực hiện những biện pháp cần thiết để bảo vệ thông tin cá nhân của khách hàng.<br>\r\nMục đích của việc sử dụng thông tin của khách hàng.</p>\r\n\r\n<p>Việc sử dụng thông tin của khách hàng sẽ được giới hạn trong những trường hợp sau đây.</p>\r\n\r\n<p> </p>\r\n\r\n<p>Thông tin cá nhân sẽ được sử dụng:<br>\r\nLiên quan đến dịch vụ</p>\r\n\r\n<p>(a) để xác nhận danh tính của cá nhân</p>\r\n\r\n<p>(b) cho mục đích thanh toán</p>\r\n\r\n<p>(c) để thông báo những thay đổi về mức phí và điều kiện dịch vụ</p>\r\n\r\n<p>(d) cho những mục đích khác liên quan đến việc cung cấp dịch vụ.</p>\r\n\r\n<p> </p>\r\n\r\n<p>Liên quan đến các dịch vụ khác được cung cấp bởi công ty</p>\r\n\r\n<p>(a) để tiến hành quảng bá cho các dịch vụ của công ty</p>\r\n\r\n<p>(b) để tiến hành khảo sát khách hàng</p>\r\n\r\n<p>(c) để gửi tài liệu quảng cáo hoặc quà tặng bằng điện thoại, dịch vụ email và bưu chính </p>\r\n\r\n<p><br>\r\nNhằm mục đích cải thiện dịch vụ của công ty và phát triển những dịch vụ mới <br>\r\nĐể giải đáp thắc mắc và tư vấn cho khách hàng<br>\r\nNhằm bất kỳ những mục đích khác được đồng ý bởi khách hàng mà chưa được nêu ở trên.</p>\r\n\r\n<p>Ngoài những mục đích sử dụng thông tin cá nhân nêu trên, công ty sẽ nêu rõ những mục đích sử dụng khác thông qua việc cung cấp dịch vụ và tiến hành khảo sát khách hàng.</p>\r\n\r\n<p><br>\r\nĐể quản lý thông tin cá nhân một cách phù hợp, công ty sẽ bảo vệ thông tin cá nhân mà khách hàng cung cấp thông qua những nỗ lực không ngừng nghỉ để:<br>\r\na. Duy trì các quy định nội bộ và kiểm soát nội bộ để bảo vệ thông tin cá nhân<br>\r\nb. Đào tạo nhân viên<br>\r\nc. Thực hiện các biện pháp thích hợp chống lại việc truy cập bất hợp pháp, sự mất mát, phá hủy, làm sai lệch và tiết lộ thông tin cá nhân</p>\r\n\r\n<p>Việc ủy thác thông tin  cá nhân</p>\r\n\r\n<p><br>\r\nThông tin cá nhân có thể được ủy thác cho nhà cung cấp hoặc đối tác kinh doanh trong phạm vi cần thiết để thực hiện các mục đích nêu trên. Trong những trường hợp này, công ty sẽ chọn nhà cung cấp phù hợp đã sử dụng các biện pháp cần thiết để bảo vệ thông tin cá nhân. Và công ty sẽ thực hiện những hành động phù hợp và cần thiết bao gồm nhưng không giới hạn trong việc ký kết hợp đồng với nhà cung cấp để bảo vệ thông tin cá nhân của khách hàng.<br>\r\nBất kể việc mâu thuẫn với nội dung nêu trên, công ty có thể cung cấp thông tin cá nhân cho cơ quan Chính phủ (ví dụ Tòa án và Cảnh sát) nếu được yêu cầu theo pháp luật. </p>\r\n'),
(11, 'early_season', 'a:5:{i:0;a:7:{s:6:"season";s:1:"1";s:8:"max_user";s:2:"30";s:4:"sale";s:2:"30";s:9:"promotion";s:37:"SAT/TOEFL/ACT/AP/IB/SAT/특례/수시";s:10:"season_use";s:2:"no";s:9:"file_path";s:55:"/assets/file/popup/35c4ea40953a6677f5f5afd19c71b93d.jpg";s:9:"full_path";s:69:"/psueduorg/www/assets/file/popup/35c4ea40953a6677f5f5afd19c71b93d.jpg";}i:1;a:7:{s:6:"season";s:1:"2";s:8:"max_user";s:2:"25";s:4:"sale";s:2:"25";s:9:"promotion";s:37:"SAT/TOEFL/ACT/AP/IB/SAT/특례/수시";s:10:"season_use";s:3:"yes";s:9:"file_path";s:0:"";s:9:"full_path";s:0:"";}i:2;a:7:{s:6:"season";s:1:"3";s:8:"max_user";s:2:"30";s:4:"sale";s:2:"20";s:9:"promotion";s:65:"컬리지 컨설팅 선착순 15명 여름특강 무제한 수강";s:10:"season_use";s:2:"no";s:9:"file_path";s:55:"/assets/file/popup/90a46ed70e5ee12bc795cb06911aeff5.jpg";s:9:"full_path";s:88:"/home/hosting_users/psueduorg/www/assets/file/popup/90a46ed70e5ee12bc795cb06911aeff5.jpg";}i:3;a:7:{s:6:"season";s:1:"4";s:8:"max_user";s:2:"50";s:4:"sale";s:2:"15";s:9:"promotion";s:65:"컬리지 컨설팅 선착순 15명 여름특강 무제한 수강";s:10:"season_use";s:2:"no";s:9:"file_path";s:55:"/assets/file/popup/7d93527c01012c573be01010ba73fed2.jpg";s:9:"full_path";s:69:"/psueduorg/www/assets/file/popup/7d93527c01012c573be01010ba73fed2.jpg";}i:4;a:7:{s:6:"season";s:1:"5";s:8:"max_user";s:2:"30";s:4:"sale";s:2:"10";s:9:"promotion";s:65:"컬리지 컨설팅 선착순 10명 여름특강 무제한 수강";s:10:"season_use";s:2:"no";s:9:"file_path";s:55:"/assets/file/popup/fa326c0bf531f3f4046e7b664292090b.jpg";s:9:"full_path";s:69:"/psueduorg/www/assets/file/popup/fa326c0bf531f3f4046e7b664292090b.jpg";}}'),
(9, 'subject_apib', 'a:9:{i:0;a:7:{s:5:"index";s:1:"0";s:5:"title";s:7:"Pre-cal";s:9:"sub_title";s:0:"";s:9:"register1";s:1:"9";s:13:"register1_max";s:2:"15";s:9:"register2";s:1:"0";s:13:"register2_max";s:2:"15";}i:1;a:7:{s:5:"index";s:1:"1";s:5:"title";s:11:"AP Calculus";s:9:"sub_title";s:2:"BC";s:9:"register1";s:1:"0";s:13:"register1_max";s:2:"12";s:9:"register2";s:1:"3";s:13:"register2_max";s:2:"12";}i:2;a:7:{s:5:"index";s:1:"2";s:5:"title";s:6:"Math 2";s:9:"sub_title";s:12:"시험대비";s:9:"register1";s:1:"5";s:13:"register1_max";s:2:"12";s:9:"register2";s:1:"1";s:13:"register2_max";s:2:"12";}i:3;a:7:{s:5:"index";s:1:"3";s:5:"title";s:9:"Chemistry";s:9:"sub_title";s:7:"Regular";s:9:"register1";s:1:"0";s:13:"register1_max";s:2:"12";s:9:"register2";s:1:"6";s:13:"register2_max";s:2:"12";}i:4;a:7:{s:5:"index";s:1:"4";s:5:"title";s:9:"Chemistry";s:9:"sub_title";s:2:"AP";s:9:"register1";s:1:"3";s:13:"register1_max";s:2:"12";s:9:"register2";s:1:"0";s:13:"register2_max";s:2:"12";}i:5;a:7:{s:5:"index";s:1:"5";s:5:"title";s:7:"Biology";s:9:"sub_title";s:2:"AP";s:9:"register1";s:1:"0";s:13:"register1_max";s:2:"12";s:9:"register2";s:1:"1";s:13:"register2_max";s:2:"12";}i:6;a:7:{s:5:"index";s:1:"6";s:5:"title";s:7:"Physics";s:9:"sub_title";s:7:"Regular";s:9:"register1";s:1:"0";s:13:"register1_max";s:2:"12";s:9:"register2";s:1:"4";s:13:"register2_max";s:2:"12";}i:7;a:7:{s:5:"index";s:1:"7";s:5:"title";s:16:"Grammar & Essay*";s:9:"sub_title";s:0:"";s:9:"register1";s:1:"2";s:13:"register1_max";s:2:"12";s:9:"register2";s:1:"0";s:13:"register2_max";s:2:"12";}i:8;a:7:{s:5:"index";s:1:"8";s:5:"title";s:6:"TOEFL*";s:9:"sub_title";s:0:"";s:9:"register1";s:1:"7";s:13:"register1_max";s:2:"12";s:9:"register2";s:1:"5";s:13:"register2_max";s:2:"12";}}'),
(10, '', 'a:2:{i:0;a:7:{s:5:"index";s:1:"0";s:5:"title";s:9:"Algebra 2";s:9:"sub_title";s:5:"bitch";s:9:"register1";s:1:"0";s:13:"register1_max";s:2:"10";s:9:"register2";s:1:"0";s:13:"register2_max";s:2:"15";}i:1;a:7:{s:5:"index";s:1:"0";s:5:"title";s:3:"ㅇ";s:9:"sub_title";s:0:"";s:9:"register1";s:1:"0";s:13:"register1_max";s:1:"0";s:9:"register2";s:1:"0";s:13:"register2_max";s:1:"0";}}'),
(6, 'items_agreement', '<p><strong>■ 유의 사항</strong></p>\\r\\n\\r\\n<p>1.   본 상품은 저작권법 제4조 제1항 제7호의 영상저작물로서 보호를 받을 수 있으며, 저작권은 해당 영상을 촬영, 제작한 자에게 있습니다. 구매한 영상이라고 할지라도 이는 영상물 파일(유체물)에 불과하며 저작권을 양도받은 것이 아닙니다. 따라서 그 이용은 개인적인 감상에 한하며 그 이외의 목적 (공공장소에서 상영, 영리목적 등..) 으로는 사용을 금합니다.</p>\\r\\n\\r\\n<p>2.   본 상품은 윈도우 10 / 8 / 7 / Vista / XP / 2003 / 2000 등 PC에서 작동이 가능합니다. (주의, 애플 MAC, iOS, Android 는 지원되지 않습니다.) 운영체제 미지원을 사유로 반품이나 환불이 불가하니 주의하시기 바랍니다.<br>\\r\\n3.   구매한 USB 인강의 동영상 강좌는 영리, 상업적 목적으로 학원, 교육기관 등에서 다수를 상대로 제공할 경우, 법적 처벌 대상이 될 수 있습니다. 다만, 비영리적인 목적으로, 상식적으로 허용된 범위 내에서 친구, 형제자매 간에 학습을 위한 공유는 가능합니다.<br>\\r\\n4.   영리, 상업적 목적의 단체 수강은 별도의 그룹 라이선스를 구매하셔야 합니다. 그룹 라이선스 구매는 info@psuedu.org 로 문의 바랍니다.</p>\\r\\n\\r\\n<p> </p>\\r\\n\\r\\n<p><strong>■ USB인강의 환불규정은 “전자상거래 등에서의 소비자 보호에 관한 법률’를 준수합니다. </strong><br>\\r\\n1.   본 상품은 소프트웨어 상품으로서 ‘전자사거래 등에서의 소비자 보호에 관한 법률 17조, 2항, 4조’에 의거하여 상품 자체가 불량인 경우를 제외하고, 개봉 후 환불이 불가합니다. <br>\\r\\n2.   개봉 전에 반품을 할 경우에는 사전에 PSU에듀센터에 반품 사유를 명확히 알려주신 후 배송된 상품을 개봉하지 않고 배송 완료 후 7일 이내에 그대로 보내주시면 환불 처리가 가능합니다. 다만 왕복 배송료와 스틱 제작료 5만원을 제외한 금액이 환불됩니다.</p>\\r\\n\\r\\n<p><strong> </strong></p>\\r\\n'),
(7, 'items_privacypolicy', '<p><strong>■ 개인정보의 수집 및 이용 목적</strong></p>\\r\\n\\r\\n<p>(주)PSU에듀센터는 다음와 같은 목적을 위해 개인정보를 수집합니다. 이외의 용도로 사용될 경우 사전동의를 구할 예정입니다.<br>\\r\\n1. 민원사무처리<br>\\r\\n민원인의 신원 확인, 민원사항 확인, 사실조사를 위한 연락,통지, 처리결과 통보 등을 목적으로 개인정보를 처리합니다.<br>\\r\\n2. 재화 또는 서비스 제공<br>\\r\\n서비스, 콘텐츠, 맞춤서비스 제공 등을 목적으로 개인정보를 처리합니다.<br>\\r\\n3. 마케팅 및 광고에의 활용<br>\\r\\n신규 서비스(제품) 개발 및 맞춤 서비스 제공, 이벤트 및 광고성 정보 제공 및 참여기회 제공 등을 목적으로 개인정보를 처리합니다.<br>\\r\\n4. 기타<br>\\r\\n학원수강 등록, 학원수업 관련 상담 등을 목적으로 개인정보를 처리합니다.</p>\\r\\n\\r\\n<p> </p>\\r\\n\\r\\n<p><strong>■ 개인정보 수집 항목 및 보유기간 </strong></p>\\r\\n\\r\\n<p>(주)PSU에듀센터는 다음 항목의 개인정보를 수집, 처리하고 있습니다.<br>\\r\\n1. 제화 또는 서비스 제공<br>\\r\\n-필수항목: 이름, 학교, 자택주소, 휴대전화번호, 이메일, 법정대리인 휴대전화번호<br>\\r\\n-선택항목: 거주지역, 공인성적<br>\\r\\n2. 마케팅 및 광고에의 활용<br>\\r\\n-필수항목: 이름, 학교, 자택주소, 휴대전화번호, 이메일, 법정대리인 휴대전화번호<br>\\r\\n-선택항목: 거주지역, 공인성적<br>\\r\\n3. 서비스 이용 과정 중 자동으로 수집하는 개인정보 항목<br>\\r\\n-서비스 이용기록, 접속 로그, 쿠키, 접속 IP 정보<br>\\r\\n4. 수집방법 : 홈페이지, 전화/팩스<br>\\r\\n5. 보유근거 : 분쟁 처리에 관한 기록<br>\\r\\n6. 보유기간 : 10년</p>\\r\\n\\r\\n<p> </p>\\r\\n\\r\\n<p><strong>■ 개인정보처리 위탁</strong></p>\\r\\n\\r\\n<p>1. 회사는 이용자의 동의를 받고 개인정보를 외부 업체에 위탁할 예정입니다. <br>\\r\\n1) 배송 관련<br>\\r\\n- 위탁대상 : 미정<br>\\r\\n- 위탁내용 : 물품주문, 배송, 교환, AS<br>\\r\\n2) 위탁업무의 내용이나 수탁자가 변경될 경우에는 본 개인정보 처리방침을 통하여 공개하겠습니다.</p>\\r\\n\\r\\n<p> </p>\\r\\n\\r\\n<p><strong>■ 정보주체의 권리, 의무 및 그 행사방법</strong></p>\\r\\n\\r\\n<p>이용자는 개인정보 주체로서 다음과 같은 권리를 행사할 수 있습니다.<br>\\r\\n1. 정보주체는 (주)PSU에듀센터에 대해 언제든지 다음과 같은 정보개인보호 관련 권리를 행사할 수 있습니다. <br>\\r\\n1) 개인정보 열람요구<br>\\r\\n2) 오류 등이 있을 경우 정정 요구<br>\\r\\n3) 삭제 요구<br>\\r\\n4) 처리정지 요구<br>\\r\\n2. 제1항에 따른 권리 행사는 (주)PSU에듀센터에 대해 개인정보 보호법 시행규칙 별지 제8호 서식에 따라 서면, 전자우편, 모사전송(FAX) 등을 통하여 하실 수 있으며  (주)PSU에듀센터는 이에 대해 바로 조치하겠습니다.<br>\\r\\n3. 정보주체가 개인정보의 오류 등에 대한 정정 또는 삭제를 요구한 경우 (주)PSU에듀센터는 정정 또는 삭제를 완료할 때까지 당해 개인정보를 이용하거나 제공하지 않습니다.<br>\\r\\n4. 제1항에 따른 권리 행사는 정보주체의 법정대리인이나 위임을 받은 자 등 대리인을 통하여 하실 수 있습니다. 이 경우 개인정보 보호법 시행규칙 별지 제11호 서식에 따른 위임장을 제출하셔야 합니다.</p>\\r\\n\\r\\n<p> </p>\\r\\n\\r\\n<p><strong>■ 개인정보의 파기</strong></p>\\r\\n\\r\\n<p>(주)PSU에듀센터는 원칙적으로 개인정보 처리목적이 달성된 경우 지체없이 해당 개인정보를 파기합니다. 파기의 절차, 기한 및 방법은 다음과 같습니다.<br>\\r\\n1. 파기절차이용자가 입력한 정보는 목적 달성 후 별도의 DB에 옮겨져(종이의 경우 별도의 서류) 내부 방침 및 기타 관련 법령에 따라 일정기간 저장된 후 혹은 즉시 파기됩니다. 이 때, DB로 옮겨진 개인정보는 법률에 의한 경우가 아니고서는 다른 목적으로 이용되지 않습니다.<br>\\r\\n2. 파기기한이용자의 개인정보는 개인정보의 보유기간이 경과된 경우에 보유기간의 종료일로부터 5일 이내에, 개인정보의 처리 목적 달성, 해당 서비스의 폐지, 사업의 종료 등 그 개인정보가 불필요하게 되었을 때에는 개인정보의 처리가 불필요한 것으로 인정되는 날로부터 5일 이내에 그 개인정보를 파기합니다. <br>\\r\\n3. 파기방법종이에 출력된 개인정보는 분쇄기로 분쇄하거나 소각을 통하여 파기합니다.</p>\\r\\n\\r\\n<p> </p>\\r\\n\\r\\n<p><strong>■ 개인정보의 안전성 확보 조치</strong></p>\\r\\n\\r\\n<p>(주)PSU에듀센터는 개인정보보호법 제29조에 따라 다음과 같이 안전성 확보에 필요한 기술/관리 및 물리적 조치를 취하고 있습니다.<br>\\r\\n1. 개인정보 취급 직원의 최소화 및 교육 개인정보를 취급하는 직원을 지정하고 담당자에 한정시켜 최소화 하여 개인정보를 관리하는 대책을 시행하고 있습니다.<br>\\r\\n2. 개인정보에 대한 접근 제한 개인정보를 처리하는 데이터베이스시스템에 대한 접근 권한의 부여, 변경, 말소를 통하여 개인정보에 대한 접근통제를 위하여 필요한 조치를 하고 있으며 침입차단시스템을 이용하여 외부로부터의 무단 접근을 통제하고 있습니다.<br>\\r\\n3. 비인가자에 대한 출입을 통제하고, 개인정보를 보관하고 있는 물리적 보관 장소를 별도로 두고 있습니다.</p>\\r\\n\\r\\n<p> </p>\\r\\n\\r\\n<p><strong>■ 개인정보 보호책임자 작성</strong></p>\\r\\n\\r\\n<p>(주)PSU에듀센터는 개인정보 처리에 관한 업무를 총괄해 책임지고, 개인정보 처리와 관련한 정보주체의 불만처리 및 피해구제 등을 위하여 아래와 같이 개인정보 보호책임자를 지정하고 있습니다.<br>\\r\\n1. 개인정보 보호책임자<br>\\r\\n-성명 : 전구희<br>\\r\\n-직급 : 부원장<br>\\r\\n-연락처 : 02-540-2510<br>\\r\\n2. 개인정보 보호 담당자<br>\\r\\n-담당자 : 김수복<br>\\r\\n-연락처 : 02-540-2510<br>\\r\\n3. 정보 주체께서는 (주)PSU에듀센터의 서비스(또는 사업)를 이용하시면서 발생한 모든 개인정보 보호 관련 문의, 불만처리, 피해구제 등에 관한 사항을 개인정보 보호책임자 및 담당부서로 문의하실 수 있습니다. PSU에듀센터는 정보 주체의 문의에 대해 바로 답변 및 처리해드릴 것입니다.</p>\\r\\n\\r\\n<p> </p>\\r\\n\\r\\n<p><strong>■ 개인정보 처리방침 변경</strong></p>\\r\\n\\r\\n<p>이 개인정보처리방침은 시행일로부터 적용되며, 법령 및 방침에 따른 변경내용의 추가, 삭제 및 정정이 있는 경우에는 변경사항의 시행 7일 전부터 공지사항을 통하여 고지할 것입니다.</p>\\r\\n'),
(5, 'usb_lecture', 'a:5:{i:0;a:3:{s:6:"depth1";s:3:"SAT";s:6:"depth2";a:3:{i:0;a:2:{s:6:"depth2";s:17:"Reading & Writing";s:5:"index";i:0;}i:1;a:2:{s:6:"depth2";s:4:"Math";s:5:"index";i:0;}i:2;a:2:{s:6:"depth2";s:5:"Essay";s:5:"index";i:0;}}s:5:"index";i:0;}i:1;a:3:{s:6:"depth1";s:3:"ACT";s:6:"depth2";a:4:{i:0;a:2:{s:6:"depth2";s:7:"Reading";s:5:"index";i:0;}i:1;a:2:{s:6:"depth2";s:7:"English";s:5:"index";i:0;}i:2;a:2:{s:6:"depth2";s:4:"Math";s:5:"index";i:0;}i:3;a:2:{s:6:"depth2";s:7:"Science";s:5:"index";i:0;}}s:5:"index";i:0;}i:2;a:3:{s:6:"depth1";s:5:"TOEFL";s:6:"depth2";a:4:{i:0;a:2:{s:6:"depth2";s:7:"Reading";s:5:"index";i:0;}i:1;a:2:{s:6:"depth2";s:7:"Writing";s:5:"index";i:0;}i:2;a:2:{s:6:"depth2";s:9:"Listening";s:5:"index";i:0;}i:3;a:2:{s:6:"depth2";s:8:"Speaking";s:5:"index";i:0;}}s:5:"index";i:0;}i:3;a:3:{s:6:"depth1";s:2:"AP";s:6:"depth2";a:8:{i:0;a:2:{s:6:"depth2";s:7:"Biology";s:5:"index";i:0;}i:1;a:2:{s:6:"depth2";s:9:"Chemistry";s:5:"index";i:0;}i:2;a:2:{s:6:"depth2";s:13:"Physics I·II";s:5:"index";i:0;}i:3;a:2:{s:6:"depth2";s:13:"World History";s:5:"index";i:0;}i:4;a:2:{s:6:"depth2";s:10:"Micro Econ";s:5:"index";i:0;}i:5;a:2:{s:6:"depth2";s:10:"Macro Econ";s:5:"index";i:0;}i:6;a:2:{s:6:"depth2";s:10:"Psychology";s:5:"index";i:0;}i:7;a:2:{s:6:"depth2";s:8:"Calculus";s:5:"index";i:0;}}s:5:"index";i:0;}i:4;a:3:{s:6:"depth1";s:6:"SAT II";s:6:"depth2";a:4:{i:0;a:2:{s:6:"depth2";s:7:"Math II";s:5:"index";i:0;}i:1;a:2:{s:6:"depth2";s:7:"Biology";s:5:"index";i:0;}i:2;a:2:{s:6:"depth2";s:9:"Chemistry";s:5:"index";i:0;}i:3;a:2:{s:6:"depth2";s:13:"World History";s:5:"index";i:0;}}s:5:"index";i:0;}}'),
(8, 'allday_maximum', 'a:2:{s:8:"max_girl";s:2:"30";s:7:"max_boy";s:2:"20";}'),
(12, 'smsnumber', '4971'),
(13, 'agreement_en', '<p><strong>Privacy Policy</strong></p>\r\n\r\n<p><br>\r\nThe personal information of the customer (\\"Personal Information\\")</p>\r\n\r\n<p>provided by the customer will be handled in the following manner by University of Minnesota Vietnam Co., LTD (“Company”).</p>\r\n\r\n<p> </p>\r\n\r\n<p>The Company will comply with laws and standards concerning the protection of Personal Information, and take all necessary measures to protect the Personal Information of the customer.</p>\r\n\r\n<p>The purposes of using the Personal Information<br>\r\nThe use of the Personal Information provided by the customer will be limited to the following circumstances.</p>\r\n\r\n<p> </p>\r\n\r\n<p>Personal Information will be used:</p>\r\n\r\n<p>With respect to the service,</p>\r\n\r\n<p>a) for confirmation of the individual&#39;s identity,</p>\r\n\r\n<p>b) for billing purposes,</p>\r\n\r\n<p>c) for notification purposes in connection with changes of charges and service conditions, installation dates, service suspension, and contract termination, and</p>\r\n\r\n<p>d) for any other purpose necessary for the provisioning of the services;</p>\r\n\r\n<p><br>\r\nWith respect to the service and any other services provided by the Company,</p>\r\n\r\n<p>a) to conduct sales promotion of the Company&#39;s services,</p>\r\n\r\n<p>b) to conduct customer surveys and</p>\r\n\r\n<p>c) to send promotional materials or gifts etc by means including the use of the telephone, email and postal service;</p>\r\n\r\n<p><br>\r\nFor purposes of improving Company&#39;s services and for developing new services;<br>\r\nTo answer any questions or provide consultation as may be requested by the customer;<br>\r\nFor any other matters agreed by the customer, not listed above.<br>\r\nIn addition to the use of the Personal Information listed above, the Company may from time to time specify other use purposes through provisioning of services and customer surveys.<br>\r\n </p>\r\n\r\n<p>To manage the Personal Information properly, Company will protect the Personal Information provided by the customer through continuous improvement efforts to:<br>\r\na. maintain internal regulations and internal control to protect the Personal Information,<br>\r\nb. provide employee education, and<br>\r\nc. take appropriate measures against illegal access, loss, destruction, falsification, and disclosure of Personal Information.</p>\r\n\r\n<p> </p>\r\n\r\n<p>Entrustment of Personal Information<br>\r\nThe Personal Information may be entrusted to Company&#39;s vendors or business partners to the extent reasonably necessary for the fulfillment of purposes listed above. In such case, Company will select appropriate vendor who have implemented necessary measures to protect the Personal Information, and the Company will take all appropriate and necessary actions including but not limited to entering into contractual agreement with such vendor to protect the Personal Information of the customer.<br>\r\nNotwithstanding anything to the contrary stated above, the Company may provide Personal Information of the customers to Governmental authority (e.g. Courts and Police) if required or requested properly pursuant to law.</p>\r\n');

-- --------------------------------------------------------

--
-- 테이블 구조 `psu_order`
--

CREATE TABLE IF NOT EXISTS `psu_order` (
  `order_id` int(12) unsigned NOT NULL,
  `item_id` int(12) unsigned NOT NULL,
  `user_id` varchar(255) NOT NULL DEFAULT 'nonmember',
  `order_price` int(12) unsigned NOT NULL DEFAULT 0,
  `order_code` varchar(255) NOT NULL,
  `order_pwd` varchar(255) NOT NULL,
  `order_tracking` varchar(100) NOT NULL,
  `order_tracking_num` varchar(255) NOT NULL,
  `order_register` datetime NOT NULL DEFAULT '0000-00-00 00:00:00'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 ROW_FORMAT=COMPACT;

-- --------------------------------------------------------

--
-- 테이블 구조 `psu_order_user`
--

CREATE TABLE IF NOT EXISTS `psu_order_user` (
  `order_user_id` int(12) unsigned NOT NULL,
  `order_id` int(12) unsigned NOT NULL,
  `order_user_name` varchar(50) NOT NULL,
  `order_user_phone` varchar(50) NOT NULL,
  `order_user_email` varchar(100) NOT NULL,
  `order_user_country` varchar(255) NOT NULL,
  `order_user_city` varchar(255) NOT NULL,
  `order_user_state` varchar(255) NOT NULL,
  `order_user_zip` varchar(100) NOT NULL,
  `order_user_addr` varchar(255) NOT NULL,
  `order_user_re_name` varchar(50) NOT NULL,
  `order_user_re_phone` varchar(50) NOT NULL,
  `order_user_re_email` varchar(100) NOT NULL,
  `order_user_re_country` varchar(255) NOT NULL,
  `order_user_re_city` varchar(255) NOT NULL,
  `order_user_re_state` varchar(255) NOT NULL,
  `order_user_re_zip` varchar(100) NOT NULL,
  `order_user_re_addr` varchar(255) NOT NULL,
  `order_user_register` datetime NOT NULL DEFAULT '0000-00-00 00:00:00'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 ROW_FORMAT=COMPACT;

-- --------------------------------------------------------

--
-- 테이블 구조 `psu_presentation`
--

CREATE TABLE IF NOT EXISTS `psu_presentation` (
  `p_id` int(12) unsigned NOT NULL,
  `p_type` varchar(20) NOT NULL DEFAULT 'presentation',
  `p_name` varchar(255) NOT NULL,
  `p_day` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `p_location` varchar(255) NOT NULL,
  `p_address` varchar(255) NOT NULL,
  `p_place` varchar(255) NOT NULL,
  `p_entry` tinyint(4) unsigned NOT NULL,
  `p_posx` varchar(30) NOT NULL,
  `p_posy` varchar(30) NOT NULL,
  `p_use` varchar(3) NOT NULL DEFAULT 'yes',
  `p_register` datetime NOT NULL DEFAULT '0000-00-00 00:00:00'
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8 ROW_FORMAT=COMPACT;

--
-- 테이블의 덤프 데이터 `psu_presentation`
--

INSERT INTO `psu_presentation` (`p_id`, `p_type`, `p_name`, `p_day`, `p_location`, `p_address`, `p_place`, `p_entry`, `p_posx`, `p_posy`, `p_use`, `p_register`) VALUES
(2, 'presentation', 'HỘI THẢO DU HỌC MỸ - ĐẠI HỌC MINNESOTA ', '2019-06-30 14:30:00', 'HCM', 'Tòa nhà Itaxa, 126 Nguyễn Thị Minh Khai, Quận 3, TPHCM', 'TOONG COWORKING SPACE ', 50, '10.782805', '106.692819', 'yes', '2019-06-24 11:34:46'),
(3, 'presentation', 'HỘI THẢO DU HỌC MỸ - ĐẠI HỌC MINNESOTA ', '2019-07-07 09:00:00', 'HCM', 'Tòa nhà Itaxa, 126 Nguyễn Thị Minh Khai, Quận 3, TPHCM ', 'TOONG COWORKING SPACE ', 50, '10.782805', '106.692819', 'yes', '2019-06-24 11:38:45');

-- --------------------------------------------------------

--
-- 테이블 구조 `psu_presentation_user`
--

CREATE TABLE IF NOT EXISTS `psu_presentation_user` (
  `u_id` int(12) unsigned NOT NULL,
  `p_id` int(12) unsigned NOT NULL,
  `u_name` varchar(30) NOT NULL,
  `u_name_en` varchar(30) NOT NULL,
  `u_phone` varchar(30) NOT NULL,
  `u_state` varchar(255) NOT NULL,
  `u_city` varchar(255) NOT NULL,
  `u_email` varchar(50) NOT NULL,
  `u_aca` varchar(50) NOT NULL COMMENT '학생학력',
  `u_school` varchar(255) NOT NULL,
  `u_relation` varchar(50) NOT NULL COMMENT '신청자와의관계',
  `u_field` text NOT NULL COMMENT '관심분야',
  `u_attendance` tinyint(4) NOT NULL COMMENT '참석인원',
  `u_search` varchar(50) NOT NULL COMMENT '정보취득경로',
  `u_register` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `u_attend` varchar(3) NOT NULL DEFAULT 'no' COMMENT '참석여부',
  `u_description` text NOT NULL COMMENT '추가설명'
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8 ROW_FORMAT=COMPACT;

-- --------------------------------------------------------

--
-- 테이블 구조 `psu_question`
--

CREATE TABLE IF NOT EXISTS `psu_question` (
  `question_id` int(12) unsigned NOT NULL,
  `question_type` varchar(40) NOT NULL,
  `question_name` varchar(40) NOT NULL,
  `question_parent` varchar(40) NOT NULL,
  `question_phone` varchar(50) NOT NULL,
  `question_phone_user` varchar(20) NOT NULL,
  `question_email` varchar(100) NOT NULL,
  `question_email_user` varchar(20) NOT NULL,
  `question_content` text NOT NULL,
  `question_ip` varchar(20) NOT NULL,
  `question_register` datetime NOT NULL DEFAULT '0000-00-00 00:00:00'
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- 테이블 구조 `psu_register`
--

CREATE TABLE IF NOT EXISTS `psu_register` (
  `register_id` int(12) unsigned NOT NULL,
  `register_name` varchar(40) NOT NULL,
  `register_school` varchar(100) NOT NULL,
  `register_grade` varchar(40) NOT NULL,
  `register_parent` varchar(40) NOT NULL,
  `parents_type` varchar(40) NOT NULL,
  `register_phone` varchar(30) NOT NULL,
  `register_phone_parent` varchar(30) NOT NULL,
  `register_email` varchar(100) NOT NULL,
  `register_email_parent` varchar(100) NOT NULL,
  `class_select` varchar(40) NOT NULL,
  `special_lecture` text NOT NULL,
  `register_local` varchar(40) NOT NULL,
  `register_sat` varchar(40) NOT NULL,
  `register_toefl` varchar(40) NOT NULL,
  `register_act` varchar(40) NOT NULL,
  `register_ap` varchar(40) NOT NULL,
  `register_content` text NOT NULL,
  `register_ip` varchar(20) NOT NULL,
  `register_agent` text NOT NULL,
  `register_charset` varchar(10) NOT NULL,
  `register_time` datetime NOT NULL DEFAULT '0000-00-00 00:00:00'
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- 테이블 구조 `psu_syndication`
--

CREATE TABLE IF NOT EXISTS `psu_syndication` (
  `syn_num` int(12) unsigned NOT NULL,
  `nav_id` int(12) unsigned NOT NULL,
  `nav_parent` int(12) NOT NULL,
  `syn_id` varchar(255) NOT NULL,
  `syn_title_ko` varchar(255) NOT NULL,
  `syn_title_en` varchar(255) NOT NULL,
  `syn_title_vi` varchar(255) NOT NULL,
  `syn_parent_link` varchar(255) NOT NULL,
  `syn_content_ko` longtext NOT NULL,
  `syn_content_en` longtext NOT NULL,
  `syn_content_vi` longtext NOT NULL,
  `syn_cate` varchar(100) NOT NULL,
  `syn_use` varchar(3) NOT NULL DEFAULT 'yes',
  `rss_use` varchar(3) NOT NULL DEFAULT 'yes',
  `syn_register` datetime NOT NULL DEFAULT '0000-00-00 00:00:00'
) ENGINE=InnoDB AUTO_INCREMENT=63 DEFAULT CHARSET=utf8 ROW_FORMAT=COMPACT;

--
-- 테이블의 덤프 데이터 `psu_syndication`
--

-- --------------------------------------------------------

--
-- 테이블 구조 `psu_syndication_ping`
--

CREATE TABLE IF NOT EXISTS `psu_syndication_ping` (
  `s_id` int(12) NOT NULL,
  `s_type` varchar(6) NOT NULL,
  `s_bbs_table` varchar(100) NOT NULL,
  `s_bbs_name` varchar(100) NOT NULL,
  `s_bbs_id` int(12) unsigned NOT NULL,
  `s_bbs_subject` varchar(255) NOT NULL,
  `s_bbs_content` longtext NOT NULL,
  `s_bbs_register` datetime NOT NULL,
  `s_ping` varchar(3) NOT NULL DEFAULT 'no'
) ENGINE=InnoDB AUTO_INCREMENT=25 DEFAULT CHARSET=utf8;

--
-- 테이블의 덤프 데이터 `psu_syndication_ping`
--

-- --------------------------------------------------------

--
-- 테이블 구조 `psu_test`
--

CREATE TABLE IF NOT EXISTS `psu_test` (
  `id` int(12) NOT NULL,
  `name` varchar(22) COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci ROW_FORMAT=COMPACT;

--
-- 테이블의 덤프 데이터 `psu_test`
--

INSERT INTO `psu_test` (`id`, `name`) VALUES
(1, 'good');

-- --------------------------------------------------------

--
-- 테이블 구조 `psu_user`
--

CREATE TABLE IF NOT EXISTS `psu_user` (
  `user_no` int(12) unsigned NOT NULL,
  `user_id` varchar(50) NOT NULL,
  `user_email` varchar(60) NOT NULL,
  `user_pwd` varchar(255) NOT NULL,
  `user_name` varchar(30) NOT NULL,
  `user_name_en` varchar(30) NOT NULL,
  `user_nick` varchar(30) NOT NULL,
  `user_phone` varchar(20) NOT NULL,
  `user_sms` varchar(3) NOT NULL DEFAULT 'no',
  `user_birth` varchar(100) NOT NULL,
  `user_state` varchar(255) NOT NULL,
  `user_grade` varchar(255) NOT NULL,
  `user_type` varchar(14) NOT NULL DEFAULT 'mp_user',
  `user_level` tinyint(4) unsigned NOT NULL DEFAULT 1,
  `staff_type` varchar(20) NOT NULL DEFAULT 'none',
  `staff_lv` tinyint(2) NOT NULL DEFAULT 0,
  `user_login_ip` varchar(20) NOT NULL COMMENT '로그인시 아이피',
  `user_activity` datetime NOT NULL DEFAULT '0000-00-00 00:00:00' COMMENT '로그인한 날짜',
  `user_register` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `mail_key` varchar(255) NOT NULL,
  `mail_approve` varchar(3) NOT NULL DEFAULT 'no' COMMENT '메일인증여부',
  `user_token` varchar(255) NOT NULL,
  `user_sns_type` varchar(10) NOT NULL DEFAULT 'home',
  `user_sns_id` varchar(255) NOT NULL,
  `user_sns_token` varchar(255) NOT NULL,
  `user_sns_refresh_token` varchar(255) NOT NULL,
  `unregister` varchar(3) NOT NULL DEFAULT 'no' COMMENT '회원탈퇴신청'
) ENGINE=InnoDB AUTO_INCREMENT=23 DEFAULT CHARSET=utf8 ROW_FORMAT=COMPACT;

--
-- 테이블의 덤프 데이터 `psu_user`
--

-- --------------------------------------------------------

--
-- 테이블 구조 `psu_user_unregister`
--

CREATE TABLE IF NOT EXISTS `psu_user_unregister` (
  `user_no` int(12) unsigned NOT NULL,
  `user_id` varchar(50) NOT NULL,
  `user_email` varchar(60) NOT NULL,
  `user_pwd` varchar(255) NOT NULL,
  `user_name` varchar(30) NOT NULL,
  `user_name_en` varchar(30) NOT NULL,
  `user_nick` varchar(30) NOT NULL,
  `user_phone` varchar(20) NOT NULL,
  `user_sms` varchar(3) NOT NULL DEFAULT 'no',
  `user_birth` varchar(100) NOT NULL,
  `user_state` varchar(255) NOT NULL,
  `user_grade` varchar(255) NOT NULL,
  `user_type` varchar(14) NOT NULL DEFAULT 'mp_user',
  `user_level` tinyint(4) unsigned NOT NULL DEFAULT 1,
  `staff_type` varchar(20) NOT NULL DEFAULT 'none',
  `staff_lv` tinyint(2) NOT NULL DEFAULT 0,
  `user_login_ip` varchar(20) NOT NULL COMMENT '로그인시 아이피',
  `user_activity` datetime NOT NULL DEFAULT '0000-00-00 00:00:00' COMMENT '로그인한 날짜',
  `user_register` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `mail_key` varchar(255) NOT NULL,
  `mail_approve` varchar(3) NOT NULL DEFAULT 'no' COMMENT '메일인증여부',
  `user_token` varchar(255) NOT NULL,
  `user_sns_type` varchar(10) NOT NULL DEFAULT 'home',
  `user_sns_id` varchar(255) NOT NULL,
  `user_sns_token` varchar(255) NOT NULL,
  `user_sns_refresh_token` varchar(255) NOT NULL,
  `unregister` varchar(3) NOT NULL DEFAULT 'no' COMMENT '회원탈퇴신청'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- 테이블 구조 `psu_write_faq`
--

CREATE TABLE IF NOT EXISTS `psu_write_faq` (
  `bbs_id` int(12) unsigned NOT NULL,
  `bbs_notice` varchar(3) NOT NULL DEFAULT 'no',
  `bbs_secret` varchar(3) NOT NULL DEFAULT 'no',
  `bbs_num` int(12) NOT NULL DEFAULT 0,
  `bbs_index` tinyint(4) NOT NULL DEFAULT 0,
  `bbs_is_reply` tinyint(1) unsigned NOT NULL DEFAULT 0,
  `bbs_reply` varchar(10) NOT NULL,
  `bbs_parent` int(12) NOT NULL DEFAULT 0,
  `bbs_is_comment` tinyint(4) NOT NULL DEFAULT 0,
  `bbs_comment` int(12) NOT NULL DEFAULT 0,
  `bbs_comment_num` int(12) NOT NULL DEFAULT 0,
  `bbs_comment_parent` int(12) NOT NULL DEFAULT 0,
  `bbs_cate` varchar(30) NOT NULL,
  `bbs_link` varchar(255) NOT NULL,
  `bbs_subject` varchar(255) NOT NULL,
  `bbs_content` text NOT NULL,
  `bbs_content_imgs` text NOT NULL,
  `bbs_thumbnail` varchar(255) NOT NULL,
  `bbs_image` varchar(255) NOT NULL,
  `bbs_good` int(12) NOT NULL DEFAULT 0,
  `bbs_nogood` int(12) NOT NULL DEFAULT 0,
  `bbs_hit` int(12) unsigned NOT NULL DEFAULT 0,
  `bbs_file` tinyint(4) NOT NULL DEFAULT 0,
  `bbs_extra1` varchar(255) NOT NULL,
  `bbs_extra2` varchar(255) NOT NULL,
  `bbs_extra3` varchar(255) NOT NULL,
  `user_id` varchar(50) NOT NULL,
  `user_name` varchar(30) NOT NULL,
  `bbs_pwd` varchar(255) NOT NULL,
  `user_ip` varchar(255) NOT NULL,
  `bbs_register` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `bbs_last` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `bbs_blind` varchar(3) NOT NULL DEFAULT 'no',
  `bbs_use` varchar(3) NOT NULL DEFAULT 'yes'
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8;

--
-- 테이블의 덤프 데이터 `psu_write_faq`
--

INSERT INTO `psu_write_faq` (`bbs_id`, `bbs_notice`, `bbs_secret`, `bbs_num`, `bbs_index`, `bbs_is_reply`, `bbs_reply`, `bbs_parent`, `bbs_is_comment`, `bbs_comment`, `bbs_comment_num`, `bbs_comment_parent`, `bbs_cate`, `bbs_link`, `bbs_subject`, `bbs_content`, `bbs_content_imgs`, `bbs_thumbnail`, `bbs_image`, `bbs_good`, `bbs_nogood`, `bbs_hit`, `bbs_file`, `bbs_extra1`, `bbs_extra2`, `bbs_extra3`, `user_id`, `user_name`, `bbs_pwd`, `user_ip`, `bbs_register`, `bbs_last`, `bbs_blind`, `bbs_use`) VALUES
(1, 'no', 'no', -1, 0, 0, '', 0, 0, 0, 0, 0, '', '', 'How does the UEL class run?', '<p>During the year in Vietnam, the class consists of a liberal arts class and a UofM ESL class. The liberal arts class consists of subjects needed for the first year at the University of Minnesota. Students will have 24 to 30 credits per year. The U of M ESL class provides the Academic English required to complete well in the U.S. and provides more than 20 hours of classes per week.</p>', '', '', '', 0, 0, 7, 0, '', '', '', 'super_adm@dasanacademy.org', 'UMVietnam', '', '112.223.248.83', '2019-06-10 16:38:46', '0000-00-00 00:00:00', 'no', 'yes'),
(2, 'no', 'no', -2, 0, 0, '', 0, 0, 0, 0, 0, '', '', 'Does this program guarantee students 100% of the entrance into the second year of University of Minnesota after the program in a year?', '<p>100% is not guaranteed. you must have B or higher in all subjects (education &amp; ESL) for one year in the program.</p>\n\n<p>If you do not meet these conditions, you must go to the University of Minnesota and take the ESL course.</p>', '', '', '', 0, 0, 4, 0, '', '', '', 'super_adm@dasanacademy.org', 'UMVietnam', '', '112.223.248.83', '2019-06-10 16:39:08', '0000-00-00 00:00:00', 'no', 'yes'),
(3, 'no', 'no', -3, 0, 0, '', 0, 0, 0, 0, 0, '', '', 'Admission procedure', '<p>The Admission procedure is divided into three categories: document screening, entrance examination, and interview.<br />\nThe Document screening examines not only general documents such as students'' grades and academic backgrounds, but also documents required to enter the University of Minnesota.</p>\n\n<p>The entrance exam is conducted in IELTS format. Interviews are group interviews, and are conducted in English and Vietnamese respectively.</p>\n\n<p>Interviews evaluate personality, thinking skills, and academic will.</p>', '', '', '', 0, 0, 2, 0, '', '', '', 'super_adm@dasanacademy.org', 'UMVietnam', '', '112.223.248.83', '2019-06-10 16:39:38', '0000-00-00 00:00:00', 'no', 'yes'),
(4, 'no', 'no', -4, 0, 0, '', 0, 0, 0, 0, 0, '', '', 'Vietnamese, How to Pass a VISA?', '<p>If you''re a student who''s studying in the U.S., you''re definitely worried about passing a visa. Statistically, more than 50 percent of the students who applied for a US visa are drinking a high grade of failures. Our University of Minnesota program has taken all of our students to the U.S., Korean, European, Singapore, and Hong Kong universities over the past 13 years. Based on that know-how, we offer the right visa preparation program for Vietnamese students. From the student selection stage to the visa application moment, we''re in it together.</p>\n\n<p> </p>\n\n<p>A thorough review of the documents, a student status at the University of Minnesota during this program, a visa interview class, a recommendation from the University of Minnesota. These make huge difference with other programs!!</p>', '', '', '', 0, 0, 5, 0, '', '', '', 'super_adm@dasanacademy.org', 'UMVietnam', '', '112.223.248.83', '2019-06-10 16:40:01', '0000-00-00 00:00:00', 'no', 'yes');

-- --------------------------------------------------------

--
-- 테이블 구조 `psu_write_faq_fa`
--

CREATE TABLE IF NOT EXISTS `psu_write_faq_fa` (
  `fa_id` int(12) unsigned NOT NULL,
  `bbs_id` int(12) unsigned NOT NULL,
  `user_id` varchar(50) NOT NULL,
  `fa_type` varchar(4) NOT NULL,
  `fa_register` datetime NOT NULL DEFAULT '0000-00-00 00:00:00'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- 테이블 구조 `psu_write_news`
--

CREATE TABLE IF NOT EXISTS `psu_write_news` (
  `bbs_id` int(12) unsigned NOT NULL,
  `bbs_notice` varchar(3) NOT NULL DEFAULT 'no',
  `bbs_secret` varchar(3) NOT NULL DEFAULT 'no',
  `bbs_num` int(12) NOT NULL DEFAULT 0,
  `bbs_index` tinyint(4) NOT NULL DEFAULT 0,
  `bbs_is_reply` tinyint(1) unsigned NOT NULL DEFAULT 0,
  `bbs_reply` varchar(10) NOT NULL,
  `bbs_parent` int(12) NOT NULL DEFAULT 0,
  `bbs_is_comment` tinyint(4) NOT NULL DEFAULT 0,
  `bbs_comment` int(12) NOT NULL DEFAULT 0,
  `bbs_comment_num` int(12) NOT NULL DEFAULT 0,
  `bbs_comment_parent` int(12) NOT NULL DEFAULT 0,
  `bbs_cate` varchar(30) NOT NULL,
  `bbs_link` varchar(255) NOT NULL,
  `bbs_subject` varchar(255) NOT NULL,
  `bbs_content` text NOT NULL,
  `bbs_content_imgs` text NOT NULL,
  `bbs_thumbnail` varchar(255) NOT NULL,
  `bbs_image` varchar(255) NOT NULL,
  `bbs_good` int(12) NOT NULL DEFAULT 0,
  `bbs_nogood` int(12) NOT NULL DEFAULT 0,
  `bbs_hit` int(12) unsigned NOT NULL DEFAULT 0,
  `bbs_file` tinyint(4) NOT NULL DEFAULT 0,
  `bbs_extra1` varchar(255) NOT NULL,
  `bbs_extra2` varchar(255) NOT NULL,
  `bbs_extra3` varchar(255) NOT NULL,
  `user_id` varchar(50) NOT NULL,
  `user_name` varchar(30) NOT NULL,
  `bbs_pwd` varchar(255) NOT NULL,
  `user_ip` varchar(255) NOT NULL,
  `bbs_register` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `bbs_last` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `bbs_use` varchar(3) NOT NULL DEFAULT 'yes'
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8;

--
-- 테이블의 덤프 데이터 `psu_write_news`
--

INSERT INTO `psu_write_news` (`bbs_id`, `bbs_notice`, `bbs_secret`, `bbs_num`, `bbs_index`, `bbs_is_reply`, `bbs_reply`, `bbs_parent`, `bbs_is_comment`, `bbs_comment`, `bbs_comment_num`, `bbs_comment_parent`, `bbs_cate`, `bbs_link`, `bbs_subject`, `bbs_content`, `bbs_content_imgs`, `bbs_thumbnail`, `bbs_image`, `bbs_good`, `bbs_nogood`, `bbs_hit`, `bbs_file`, `bbs_extra1`, `bbs_extra2`, `bbs_extra3`, `user_id`, `user_name`, `bbs_pwd`, `user_ip`, `bbs_register`, `bbs_last`, `bbs_use`) VALUES
(2, 'no', 'no', -2, 0, 0, '', 0, 0, 0, 0, 0, 'notice', '', 'University of Minnesota 1+3 admission workshop', '<p><img alt="" height="407" src="/assets/img/ckeditor/news/12d38b38b7bc437c0ea98a7ca418c940.jpg" width="635" /></p>\n\n<p> </p>\n\n<p>University of Minnesota one of the world’s prestige university has made a MOU with top 1% universities in Korea and established Minnesota university’s ESL course and Liberal arts center in Korea which sent many students to University of Minnesota. And that program has now came to Vietnam also.</p>\n\n<p> </p>\n\n<p>In 2019, University of Minnesota has established U of M ESL and Liberal arts course in VNU-HCM-UEL (Vietnam National University - Ho Chi Minh City - University of Economics and Law) by making MOU contract. The students who enroll in this program, will receive U of M student ID and gets credit on Liberal arts as University of Minnesota student with UEL’s excellent faculty and professors. And also, will achieve IELTS and ESL English course at same time. After passing the program, the student will enter the U of M as sophomore.<br />\n </p>\n\n<p>If you are a student who wants to study abroad in USA<br />\nChallenge the fastest, safest, cheapest way to study abroad.<br />\nUniversity of Minnesota 1+3 admission program!</p>\n\n<p> </p>\n\n<p>[Introduction of first U of M 1+3 admission program workshop]</p>\n\n<ul><li>Date : 23rd June 2019 Sunday from 9am to 12pm</li>\n	<li>Place : Dreamplex<br />\n	62 Trần Quang Khải, Tân Định, Quận 1, TPHCM</li>\n	<li>Target : High school 3rd grade students and parents</li>\n	<li>Contact us: Office: 028.3724.4555 (ext. 6363) | Mobile: 034.970.5862</li>\n</ul>\n\n<p> </p>\n\n<p>[Introduction of second U of M 1+3 admission program workshop]</p>\n\n<ul><li>Date : 30th June 2019 Sunday from 2:30pm to 5:30pm</li>\n	<li>Place: TOONG COWORKING SPACE<br />\n	Tòa nhà Itaxa, 126 Nguyễn Thị Minh Khai, Quận 3, TPHCM</li>\n	<li>Target : High school 3rd grade students and parents</li>\n	<li>Contact us: Office: 028.3724.4555 (ext. 6363) | Mobile: 034.970.5862</li>\n</ul>\n\n<p> </p>\n\n<p>[Introduction of third U of M 1+3 admission program workshop] </p>\n\n<ul><li>Date : 7th July 2019 Sunday from 9am to 12pm</li>\n	<li>Place: TOONG COWORKING SPACE<br />\n	Tòa nhà Itaxa, 126 Nguyễn Thị Minh Khai, Quận 3, TPHCM</li>\n	<li>Target : High school 3rd grade students and parents</li>\n	<li>Contact us: Office: 028.3724.4555 (ext. 6363) | Mobile: 034.970.5862</li>\n</ul>', '12d38b38b7bc437c0ea98a7ca418c940.jpg', '/assets/img/ckeditor/news/12d38b38b7bc437c0ea98a7ca418c940_thumb.jpg', '', 1, 0, 45, 0, '', '', '', 'super_adm@dasanacademy.org', 'UMVietnam', '', '112.223.248.83', '2019-06-27 17:13:33', '2019-06-27 17:55:45', 'yes'),
(3, 'no', 'no', -3, 0, 0, '', 0, 0, 0, 0, 0, 'notice', '', '미네소타대학교 1+3 입학전형 설명회', '<p><img alt="" height="407" src="/assets/img/ckeditor/news/a1142f8efd23901d5571d316289a47ad.jpg" width="635" /></p>\n\n<p> </p>\n\n<p>세계적인 명문 대학인 University of Minnesota는 2006년부터 한국의 상위 1% 대학과 협약을 맺고 한국 내에 미네소타대학의 ESL 과 liberal Arts 교육센터를 설립하여 많은 학생들을 미네소타대학으로 진학시킨 미네소타대학교 프로그램을 베트남에 구축하였습니다. </p>\n\n<p> </p>\n\n<p>2019년 미네소타대학교는 VNU-HCM-UEL (Vietnam National University - Ho Chi Minh City - University of Economics and Law) 대학과 협력하여 대학 내에 미네소타 대학 ESL &amp; Liberal Arts Center를 설립하였습니다. 본과정에 입학한 학생들은 University of Minnesota의 student ID를 발급받고 미네소타 대학생으로서 UEL의 우수한 교수진을 통해 교양과목 학점을 이수합니다. 또한, 동시에 미국 유학의 필수적 요소인 IELTS와 ESL 영어교육을 동시에 수료합니다. 본 과정을 성실하게 이수한 학생은, University of Minnesota 2학년으로 진학하게 됩니다.</p>\n\n<p> </p>\n\n<p>미국유학을 가고 싶은 베트남 학생이라면 <br />\n가장 빠르고, 가장 안전하고, 가장 저렴한 미국유학의 길 <br />\n미네소타대 1+3 입학전형에 도전하세요!</p>\n\n<p> </p>\n\n<p>[미네소타대학교 1+3입학전형 1차 설명회 일정 안내] </p>\n\n<ul><li>일시: 6월 23일(일) 오후 9시~12시</li>\n	<li>장소: DREAMPLEX <br />\n	62 Trần Quang Khải, Tân Định, Quận 1, TPHCM</li>\n	<li>대상: 고3 학생 및 학부모</li>\n	<li>문의전화: Office: 028.3724.4555 (ext. 6363) | Mobile: 034.970.5862</li>\n</ul>\n\n<p> </p>\n\n<p>[미네소타대학교 1+3입학전형 2차 설명회 일정 안내]</p>\n\n<ul><li>일시: 6월 30일(일) 오후 2시 30분~ 5시 30분까지</li>\n	<li>장소: TOONG COWORKING SPACE<br />\n	Tòa nhà Itaxa, 126 Nguyễn Thị Minh Khai, Quận 3, TPHCM</li>\n	<li>대상: 고3 학생 및 학부모</li>\n	<li>문의전화: Office: 028.3724.4555 (ext. 6363) | Mobile: 034.970.5862</li>\n</ul>\n\n<p> </p>\n\n<p>[미네소타대학교 1+3입학전형 3차 설명회 일정 안내]</p>\n\n<ul><li>일시: 7월 7일(일) 오전 9시~ 오후 12시까지 </li>\n	<li>장소: TOONG COWORKING SPACE<br />\n	Tòa nhà Itaxa, 126 Nguyễn Thị Minh Khai, Quận 3, TPHCM</li>\n	<li>대상: 고3 학생 및 학부모</li>\n	<li>문의전화: Office: 028.3724.4555 (ext. 6363) | Mobile: 034.970.5862</li>\n</ul>', 'a1142f8efd23901d5571d316289a47ad.jpg', '/assets/img/ckeditor/news/a1142f8efd23901d5571d316289a47ad_thumb.jpg', '', 0, 0, 47, 0, '', '', '', 'super_adm@dasanacademy.org', 'UMVietnam', '', '112.223.248.83', '2019-06-27 18:03:05', '2019-06-28 08:40:12', 'yes'),
(4, 'no', 'no', -4, 0, 0, '', 0, 0, 0, 0, 0, 'notice', '', 'Hội thảo tuyển sinh 1 + 3 Đại học Minnesota', '<p style="text-align:justify;"><img alt="" height="407" src="/assets/img/ckeditor/news/787535b745fc5f9872f7b4a96a539eea.jpg" width="635" /></p>\r\n\r\n<p> </p>\r\n\r\n<p> </p>\r\n\r\n<p>Hội thảo tuyển sinh 1 + 3 Đại học Minnesota<br />\r\nĐại học Minnesota – một trong những trường đại học danh tiếng nhất trên thế giới, đã ký biên bản hợp tác với các trường Đại học thuộc top 1% các trường tốt nhất Hàn Quốc để thành lập Khóa ESL và Trung tâm Giáo dục Đại cương tại Hàn Quốc và giúp rất nhiều sinh viên du học tại Đại học Minnesota. Và bây giờ chương trình này đã có mặt ở Việt Nam.</p>\r\n\r\n<p> </p>\r\n\r\n<p>Vào năm 2019, Đại học Minnesota ký biên bản hợp tác với Trường Đại học Kinh tế-Luật, Đại học Quốc gia TPHCM để thành lập Khóa Giáo dục Đại cương và ESL tại Việt Nam. Sinh viên tham gia chương trình này sẽ nhận được Thẻ sinh viên Đại học Minnesota và lấy tín chỉ các môn học đại cương với tư cách là sinh viên Đại học Minnesota dưới sự giảng dạy của những giảng viên xuất sắc tại Trường Đại học Kinh tế-Luật. Ngoài ra, sinh viên cũng sẽ học các khóa tiếng Anh IELTS và ESL. Sau khi hoàn thành chương trình, sinh viên sẽ nhập học tại Đại học Minnesota vào năm thứ hai.</p>\r\n\r\n<p> </p>\r\n\r\n<p>Nếu bạn muốn du học Mỹ<br />\r\nĐây là cách nhanh nhất, an toàn nhất và ít tốn kém nhất để đi du học.<br />\r\nChương trình 1 + 3 Đại học Minnesota!</p>\r\n\r\n<p> </p>\r\n\r\n<p><strong>[Giới thiệu Hội thảo Chương trình du học 1+3 Đại học Minnesota đầu tiên]</strong></p>\r\n\r\n<ul><li>Thời gian: Sáng Chủ nhật ngày 23/06/2019 từ 9:00 đến 12:00</li>\r\n	<li>Địa điểm: Dreamplex 62 Trần Quang Khải, Tân Định, Quận 1, TPHCM</li>\r\n	<li>Đối tượng: Phụ huynh và học sinh trung học phổ thông năm cuối</li>\r\n	<li>Liên hệ: SĐT văn phòng: 028.3724.4555 (máy lẻ 6363) | Di động: 034.970.5862</li>\r\n</ul>\r\n\r\n<p> </p>\r\n\r\n<p><strong> [Giới thiệu Hội thảo Chương trình du học 1+3 Đại học Minnesota thứ hai]</strong></p>\r\n\r\n<ul><li>Thời gian: Chiều Chủ nhật ngày 30/06/2019 từ 2:30 đến 5:30</li>\r\n	<li>Địa điểm: TOONG COWORKING SPACE<br />\r\n	Tòa nhà Itaxa, 126 Nguyễn Thị Minh Khai, Quận 3, TPHCM</li>\r\n	<li>Đối tượng: Phụ huynh và học sinh trung học phổ thông năm cuối</li>\r\n	<li>Liên hệ: SĐT văn phòng: 028.3724.4555 (máy lẻ 6363) | Di động: 034.970.5862</li>\r\n</ul>\r\n\r\n<p> </p>\r\n\r\n<p><strong> [Giới thiệu Hội thảo Chương trình du học 1+3 Đại học Minnesota thứ ba]</strong></p>\r\n\r\n<ul><li>Thời gian: Sáng Chủ nhật ngày 07/07/2019 từ 9:00 đến 12:00</li>\r\n	<li>Địa điểm: TOONG COWORKING SPACE<br />\r\n	Tòa nhà Itaxa, 126 Nguyễn Thị Minh Khai, Quận 3, TPHCM</li>\r\n	<li>Đối tượng: Phụ huynh và học sinh trung học phổ thông năm cuối</li>\r\n	<li>Liên hệ: SĐT văn phòng: 028.3724.4555 (máy lẻ 6363) | Di động: 034.970.5862</li>\r\n</ul>', '787535b745fc5f9872f7b4a96a539eea.jpg', '/assets/img/ckeditor/news/787535b745fc5f9872f7b4a96a539eea_thumb.jpg', '', 2, 0, 72, 0, '', '', '', 'super_adm@dasanacademy.org', 'UMVietnam', '', '112.223.248.83', '2019-06-27 18:57:30', '2019-06-27 14:05:20', 'yes'),
(5, 'no', 'no', -5, 0, 0, '', 0, 0, 0, 0, 0, 'news', '', 'UMVietnam', '<p>UMVietnam</p>', '', '', '', 0, 0, 0, 0, '', '', '', 'super_adm@dasanacademy.org', 'UMVietnam', '', '112.223.248.83', '2019-07-04 09:43:56', '0000-00-00 00:00:00', 'no');

-- --------------------------------------------------------

--
-- 테이블 구조 `psu_write_news_fa`
--

CREATE TABLE IF NOT EXISTS `psu_write_news_fa` (
  `fa_id` int(12) unsigned NOT NULL,
  `bbs_id` int(12) unsigned NOT NULL,
  `user_id` varchar(50) NOT NULL,
  `fa_type` varchar(4) NOT NULL,
  `fa_register` datetime NOT NULL DEFAULT '0000-00-00 00:00:00'
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8;

--
-- 테이블의 덤프 데이터 `psu_write_news_fa`
--

INSERT INTO `psu_write_news_fa` (`fa_id`, `bbs_id`, `user_id`, `fa_type`, `fa_register`) VALUES
(3, 4, 'super_adm@dasanacademy.org', '', '2019-06-28 08:39:15'),
(4, 4, '1585626188237776@facebook.com', '', '2019-06-28 12:06:11'),
(5, 2, 'super_adm@dasanacademy.org', '', '2019-07-04 09:50:10');

-- --------------------------------------------------------

--
-- 테이블 구조 `psu_write_qna`
--

CREATE TABLE IF NOT EXISTS `psu_write_qna` (
  `bbs_id` int(12) unsigned NOT NULL,
  `bbs_notice` varchar(3) NOT NULL DEFAULT 'no',
  `bbs_secret` varchar(3) NOT NULL DEFAULT 'no',
  `bbs_num` int(12) NOT NULL DEFAULT 0,
  `bbs_index` tinyint(4) NOT NULL DEFAULT 0,
  `bbs_is_reply` tinyint(1) unsigned NOT NULL DEFAULT 0,
  `bbs_reply` varchar(10) NOT NULL,
  `bbs_parent` int(12) NOT NULL DEFAULT 0,
  `bbs_is_comment` tinyint(4) NOT NULL DEFAULT 0,
  `bbs_comment` int(12) NOT NULL DEFAULT 0,
  `bbs_comment_num` int(12) NOT NULL DEFAULT 0,
  `bbs_comment_parent` int(12) NOT NULL DEFAULT 0,
  `bbs_cate` varchar(30) NOT NULL,
  `bbs_link` varchar(255) NOT NULL,
  `bbs_subject` varchar(255) NOT NULL,
  `bbs_content` text NOT NULL,
  `bbs_content_imgs` text NOT NULL,
  `bbs_thumbnail` varchar(255) NOT NULL,
  `bbs_image` varchar(255) NOT NULL,
  `bbs_good` int(12) NOT NULL DEFAULT 0,
  `bbs_nogood` int(12) NOT NULL DEFAULT 0,
  `bbs_hit` int(12) unsigned NOT NULL DEFAULT 0,
  `bbs_file` tinyint(4) NOT NULL DEFAULT 0,
  `bbs_extra1` varchar(255) NOT NULL,
  `bbs_extra2` varchar(255) NOT NULL,
  `bbs_extra3` varchar(255) NOT NULL,
  `user_id` varchar(50) NOT NULL,
  `user_name` varchar(30) NOT NULL,
  `bbs_pwd` varchar(255) NOT NULL,
  `user_ip` varchar(255) NOT NULL,
  `bbs_register` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `bbs_last` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `bbs_blind` varchar(3) NOT NULL DEFAULT 'no',
  `bbs_use` varchar(3) NOT NULL DEFAULT 'yes'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- 테이블 구조 `psu_write_qna_fa`
--

CREATE TABLE IF NOT EXISTS `psu_write_qna_fa` (
  `fa_id` int(12) unsigned NOT NULL,
  `bbs_id` int(12) unsigned NOT NULL,
  `user_id` varchar(50) NOT NULL,
  `fa_type` varchar(4) NOT NULL,
  `fa_register` datetime NOT NULL DEFAULT '0000-00-00 00:00:00'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- 테이블 구조 `psu_write_umvbbst`
--

CREATE TABLE IF NOT EXISTS `psu_write_umvbbst` (
  `bbs_id` int(12) unsigned NOT NULL,
  `bbs_notice` varchar(3) NOT NULL DEFAULT 'no',
  `bbs_secret` varchar(3) NOT NULL DEFAULT 'no',
  `bbs_num` int(12) NOT NULL DEFAULT 0,
  `bbs_index` tinyint(4) NOT NULL DEFAULT 0,
  `bbs_is_reply` tinyint(1) unsigned NOT NULL DEFAULT 0,
  `bbs_reply` varchar(10) NOT NULL,
  `bbs_parent` int(12) NOT NULL DEFAULT 0,
  `bbs_is_comment` tinyint(4) NOT NULL DEFAULT 0,
  `bbs_comment` int(12) NOT NULL DEFAULT 0,
  `bbs_comment_num` int(12) NOT NULL DEFAULT 0,
  `bbs_comment_parent` int(12) NOT NULL DEFAULT 0,
  `bbs_cate` varchar(30) NOT NULL,
  `bbs_link` varchar(255) NOT NULL,
  `bbs_subject` varchar(255) NOT NULL,
  `bbs_content` text NOT NULL,
  `bbs_content_imgs` text NOT NULL,
  `bbs_thumbnail` varchar(255) NOT NULL,
  `bbs_image` varchar(255) NOT NULL,
  `bbs_good` int(12) NOT NULL DEFAULT 0,
  `bbs_nogood` int(12) NOT NULL DEFAULT 0,
  `bbs_hit` int(12) unsigned NOT NULL DEFAULT 0,
  `bbs_file` tinyint(4) NOT NULL DEFAULT 0,
  `bbs_extra1` varchar(255) NOT NULL,
  `bbs_extra2` varchar(255) NOT NULL,
  `bbs_extra3` varchar(255) NOT NULL,
  `user_id` varchar(50) NOT NULL,
  `user_name` varchar(30) NOT NULL,
  `bbs_pwd` varchar(255) NOT NULL,
  `user_ip` varchar(255) NOT NULL,
  `bbs_register` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `bbs_last` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `bbs_blind` varchar(3) NOT NULL DEFAULT 'no',
  `bbs_use` varchar(3) NOT NULL DEFAULT 'yes'
) ENGINE=InnoDB AUTO_INCREMENT=17 DEFAULT CHARSET=utf8;

--
-- 테이블의 덤프 데이터 `psu_write_umvbbst`
--

-- --------------------------------------------------------

--
-- 테이블 구조 `psu_write_umvbbst_fa`
--

CREATE TABLE IF NOT EXISTS `psu_write_umvbbst_fa` (
  `fa_id` int(12) unsigned NOT NULL,
  `bbs_id` int(12) unsigned NOT NULL,
  `user_id` varchar(50) NOT NULL,
  `fa_type` varchar(4) NOT NULL,
  `fa_register` datetime NOT NULL DEFAULT '0000-00-00 00:00:00'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- 덤프된 테이블의 인덱스
--

--
-- 테이블의 인덱스 `psu_board_files`
--
ALTER TABLE `psu_board_files`
  ADD PRIMARY KEY (`bf_id`),
  ADD KEY `bf_table` (`bf_table`,`bf_bbs_id`),
  ADD KEY `bf_type` (`bf_type`);

--
-- 테이블의 인덱스 `psu_board_group`
--
ALTER TABLE `psu_board_group`
  ADD PRIMARY KEY (`bbs_table`);

--
-- 테이블의 인덱스 `psu_board_scrap`
--
ALTER TABLE `psu_board_scrap`
  ADD PRIMARY KEY (`s_id`),
  ADD KEY `u_id` (`u_id`,`b_table`);

--
-- 테이블의 인덱스 `psu_homepage`
--
ALTER TABLE `psu_homepage`
  ADD PRIMARY KEY (`h_id`),
  ADD UNIQUE KEY `h_name` (`h_name`);

--
-- 테이블의 인덱스 `psu_log_record`
--
ALTER TABLE `psu_log_record`
  ADD PRIMARY KEY (`log_id`);

--
-- 테이블의 인덱스 `psu_mem_myqna`
--
ALTER TABLE `psu_mem_myqna`
  ADD PRIMARY KEY (`mq_no`),
  ADD KEY `user_id` (`user_id`);

--
-- 테이블의 인덱스 `psu_mem_myqna_reply`
--
ALTER TABLE `psu_mem_myqna_reply`
  ADD PRIMARY KEY (`mr_no`),
  ADD KEY `mq_no` (`mq_no`),
  ADD KEY `user_id` (`user_id`);

--
-- 테이블의 인덱스 `psu_mem_presentation`
--
ALTER TABLE `psu_mem_presentation`
  ADD PRIMARY KEY (`p_no`),
  ADD KEY `u_id` (`u_id`),
  ADD KEY `user_id` (`user_id`);

--
-- 테이블의 인덱스 `psu_menu`
--
ALTER TABLE `psu_menu`
  ADD PRIMARY KEY (`nav_id`),
  ADD KEY `nav_parent` (`nav_parent`),
  ADD KEY `nav_depth` (`nav_depth`),
  ADD KEY `nav_access` (`nav_access`);

--
-- 테이블의 인덱스 `psu_options`
--
ALTER TABLE `psu_options`
  ADD PRIMARY KEY (`opt_id`),
  ADD UNIQUE KEY `opt_name` (`opt_name`);

--
-- 테이블의 인덱스 `psu_order`
--
ALTER TABLE `psu_order`
  ADD PRIMARY KEY (`order_id`),
  ADD KEY `item_id` (`item_id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `order_code` (`order_code`);

--
-- 테이블의 인덱스 `psu_order_user`
--
ALTER TABLE `psu_order_user`
  ADD PRIMARY KEY (`order_user_id`),
  ADD KEY `order_id` (`order_id`),
  ADD KEY `order_user_name` (`order_user_name`);

--
-- 테이블의 인덱스 `psu_presentation`
--
ALTER TABLE `psu_presentation`
  ADD PRIMARY KEY (`p_id`),
  ADD KEY `p_day` (`p_day`,`p_location`,`p_use`),
  ADD KEY `p_type` (`p_type`);

--
-- 테이블의 인덱스 `psu_presentation_user`
--
ALTER TABLE `psu_presentation_user`
  ADD PRIMARY KEY (`u_id`),
  ADD KEY `p_id` (`p_id`,`u_name`,`u_phone`,`u_email`,`u_attend`);

--
-- 테이블의 인덱스 `psu_question`
--
ALTER TABLE `psu_question`
  ADD PRIMARY KEY (`question_id`);

--
-- 테이블의 인덱스 `psu_register`
--
ALTER TABLE `psu_register`
  ADD PRIMARY KEY (`register_id`);

--
-- 테이블의 인덱스 `psu_syndication`
--
ALTER TABLE `psu_syndication`
  ADD PRIMARY KEY (`syn_num`),
  ADD UNIQUE KEY `nav_id` (`nav_id`),
  ADD KEY `nav_parent` (`nav_parent`),
  ADD KEY `rss_use` (`rss_use`);

--
-- 테이블의 인덱스 `psu_syndication_ping`
--
ALTER TABLE `psu_syndication_ping`
  ADD PRIMARY KEY (`s_id`),
  ADD KEY `s_type` (`s_type`),
  ADD KEY `s_bbs_id` (`s_bbs_id`);

--
-- 테이블의 인덱스 `psu_test`
--
ALTER TABLE `psu_test`
  ADD PRIMARY KEY (`id`);

--
-- 테이블의 인덱스 `psu_user`
--
ALTER TABLE `psu_user`
  ADD PRIMARY KEY (`user_no`),
  ADD UNIQUE KEY `user_id` (`user_id`),
  ADD KEY `user_type` (`user_type`),
  ADD KEY `unregister` (`unregister`),
  ADD KEY `staff_type` (`staff_type`),
  ADD KEY `user_sns_id` (`user_sns_id`),
  ADD KEY `user_email` (`user_email`) USING BTREE,
  ADD KEY `user_sns_type` (`user_sns_type`),
  ADD KEY `user_sms` (`user_sms`);

--
-- 테이블의 인덱스 `psu_user_unregister`
--
ALTER TABLE `psu_user_unregister`
  ADD PRIMARY KEY (`user_no`),
  ADD UNIQUE KEY `user_id` (`user_id`),
  ADD KEY `user_type` (`user_type`),
  ADD KEY `unregister` (`unregister`),
  ADD KEY `staff_type` (`staff_type`),
  ADD KEY `user_sns_id` (`user_sns_id`),
  ADD KEY `user_email` (`user_email`) USING BTREE,
  ADD KEY `user_sns_type` (`user_sns_type`),
  ADD KEY `user_sms` (`user_sms`);

--
-- 테이블의 인덱스 `psu_write_faq`
--
ALTER TABLE `psu_write_faq`
  ADD PRIMARY KEY (`bbs_id`),
  ADD KEY `bbs_notice` (`bbs_notice`,`bbs_is_reply`,`bbs_reply`,`bbs_parent`,`bbs_is_comment`,`bbs_comment_parent`,`user_id`,`bbs_cate`,`bbs_use`),
  ADD KEY `psu_write_faq_user_fk` (`user_id`);

--
-- 테이블의 인덱스 `psu_write_faq_fa`
--
ALTER TABLE `psu_write_faq_fa`
  ADD PRIMARY KEY (`fa_id`),
  ADD KEY `bbs_id` (`bbs_id`,`user_id`,`fa_type`);

--
-- 테이블의 인덱스 `psu_write_news`
--
ALTER TABLE `psu_write_news`
  ADD PRIMARY KEY (`bbs_id`),
  ADD KEY `bbs_reply` (`bbs_reply`,`bbs_parent`,`bbs_is_comment`,`bbs_comment_parent`,`user_id`,`bbs_cate`,`bbs_use`),
  ADD KEY `bbs_user_fk` (`user_id`),
  ADD KEY `bbs_notice` (`bbs_notice`),
  ADD KEY `bbs_is_reply` (`bbs_is_reply`);

--
-- 테이블의 인덱스 `psu_write_news_fa`
--
ALTER TABLE `psu_write_news_fa`
  ADD PRIMARY KEY (`fa_id`),
  ADD KEY `bbs_id` (`bbs_id`,`user_id`,`fa_type`);

--
-- 테이블의 인덱스 `psu_write_qna`
--
ALTER TABLE `psu_write_qna`
  ADD PRIMARY KEY (`bbs_id`),
  ADD KEY `bbs_notice` (`bbs_notice`,`bbs_is_reply`,`bbs_reply`,`bbs_parent`,`bbs_is_comment`,`bbs_comment_parent`,`user_id`,`bbs_cate`,`bbs_use`),
  ADD KEY `psu_write_qna_user_fk` (`user_id`);

--
-- 테이블의 인덱스 `psu_write_qna_fa`
--
ALTER TABLE `psu_write_qna_fa`
  ADD PRIMARY KEY (`fa_id`),
  ADD KEY `bbs_id` (`bbs_id`,`user_id`,`fa_type`);

--
-- 테이블의 인덱스 `psu_write_umvbbst`
--
ALTER TABLE `psu_write_umvbbst`
  ADD PRIMARY KEY (`bbs_id`),
  ADD KEY `bbs_notice` (`bbs_notice`,`bbs_is_reply`,`bbs_reply`,`bbs_parent`,`bbs_is_comment`,`bbs_comment_parent`,`user_id`,`bbs_cate`,`bbs_use`),
  ADD KEY `psu_write_umvbbst_user_fk` (`user_id`);

--
-- 테이블의 인덱스 `psu_write_umvbbst_fa`
--
ALTER TABLE `psu_write_umvbbst_fa`
  ADD PRIMARY KEY (`fa_id`),
  ADD KEY `bbs_id` (`bbs_id`,`user_id`,`fa_type`);

--
-- 덤프된 테이블의 AUTO_INCREMENT
--

--
-- 테이블의 AUTO_INCREMENT `psu_board_files`
--
ALTER TABLE `psu_board_files`
  MODIFY `bf_id` int(12) unsigned NOT NULL AUTO_INCREMENT;
--
-- 테이블의 AUTO_INCREMENT `psu_board_scrap`
--
ALTER TABLE `psu_board_scrap`
  MODIFY `s_id` int(12) unsigned NOT NULL AUTO_INCREMENT;
--
-- 테이블의 AUTO_INCREMENT `psu_homepage`
--
ALTER TABLE `psu_homepage`
  MODIFY `h_id` int(12) unsigned NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=4;
--
-- 테이블의 AUTO_INCREMENT `psu_log_record`
--
ALTER TABLE `psu_log_record`
  MODIFY `log_id` int(12) unsigned NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=46;
--
-- 테이블의 AUTO_INCREMENT `psu_mem_myqna`
--
ALTER TABLE `psu_mem_myqna`
  MODIFY `mq_no` int(12) NOT NULL AUTO_INCREMENT;
--
-- 테이블의 AUTO_INCREMENT `psu_mem_myqna_reply`
--
ALTER TABLE `psu_mem_myqna_reply`
  MODIFY `mr_no` int(12) NOT NULL AUTO_INCREMENT;
--
-- 테이블의 AUTO_INCREMENT `psu_mem_presentation`
--
ALTER TABLE `psu_mem_presentation`
  MODIFY `p_no` int(12) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=2;
--
-- 테이블의 AUTO_INCREMENT `psu_menu`
--
ALTER TABLE `psu_menu`
  MODIFY `nav_id` int(12) unsigned NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=73;
--
-- 테이블의 AUTO_INCREMENT `psu_options`
--
ALTER TABLE `psu_options`
  MODIFY `opt_id` int(12) unsigned NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=15;
--
-- 테이블의 AUTO_INCREMENT `psu_order`
--
ALTER TABLE `psu_order`
  MODIFY `order_id` int(12) unsigned NOT NULL AUTO_INCREMENT;
--
-- 테이블의 AUTO_INCREMENT `psu_order_user`
--
ALTER TABLE `psu_order_user`
  MODIFY `order_user_id` int(12) unsigned NOT NULL AUTO_INCREMENT;
--
-- 테이블의 AUTO_INCREMENT `psu_presentation`
--
ALTER TABLE `psu_presentation`
  MODIFY `p_id` int(12) unsigned NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=4;
--
-- 테이블의 AUTO_INCREMENT `psu_presentation_user`
--
ALTER TABLE `psu_presentation_user`
  MODIFY `u_id` int(12) unsigned NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=3;
--
-- 테이블의 AUTO_INCREMENT `psu_question`
--
ALTER TABLE `psu_question`
  MODIFY `question_id` int(12) unsigned NOT NULL AUTO_INCREMENT;
--
-- 테이블의 AUTO_INCREMENT `psu_register`
--
ALTER TABLE `psu_register`
  MODIFY `register_id` int(12) unsigned NOT NULL AUTO_INCREMENT;
--
-- 테이블의 AUTO_INCREMENT `psu_syndication`
--
ALTER TABLE `psu_syndication`
  MODIFY `syn_num` int(12) unsigned NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=63;
--
-- 테이블의 AUTO_INCREMENT `psu_syndication_ping`
--
ALTER TABLE `psu_syndication_ping`
  MODIFY `s_id` int(12) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=25;
--
-- 테이블의 AUTO_INCREMENT `psu_test`
--
ALTER TABLE `psu_test`
  MODIFY `id` int(12) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=2;
--
-- 테이블의 AUTO_INCREMENT `psu_user`
--
ALTER TABLE `psu_user`
  MODIFY `user_no` int(12) unsigned NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=23;
--
-- 테이블의 AUTO_INCREMENT `psu_user_unregister`
--
ALTER TABLE `psu_user_unregister`
  MODIFY `user_no` int(12) unsigned NOT NULL AUTO_INCREMENT;
--
-- 테이블의 AUTO_INCREMENT `psu_write_faq`
--
ALTER TABLE `psu_write_faq`
  MODIFY `bbs_id` int(12) unsigned NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=5;
--
-- 테이블의 AUTO_INCREMENT `psu_write_faq_fa`
--
ALTER TABLE `psu_write_faq_fa`
  MODIFY `fa_id` int(12) unsigned NOT NULL AUTO_INCREMENT;
--
-- 테이블의 AUTO_INCREMENT `psu_write_news`
--
ALTER TABLE `psu_write_news`
  MODIFY `bbs_id` int(12) unsigned NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=6;
--
-- 테이블의 AUTO_INCREMENT `psu_write_news_fa`
--
ALTER TABLE `psu_write_news_fa`
  MODIFY `fa_id` int(12) unsigned NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=6;
--
-- 테이블의 AUTO_INCREMENT `psu_write_qna`
--
ALTER TABLE `psu_write_qna`
  MODIFY `bbs_id` int(12) unsigned NOT NULL AUTO_INCREMENT;
--
-- 테이블의 AUTO_INCREMENT `psu_write_qna_fa`
--
ALTER TABLE `psu_write_qna_fa`
  MODIFY `fa_id` int(12) unsigned NOT NULL AUTO_INCREMENT;
--
-- 테이블의 AUTO_INCREMENT `psu_write_umvbbst`
--
ALTER TABLE `psu_write_umvbbst`
  MODIFY `bbs_id` int(12) unsigned NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=17;
--
-- 테이블의 AUTO_INCREMENT `psu_write_umvbbst_fa`
--
ALTER TABLE `psu_write_umvbbst_fa`
  MODIFY `fa_id` int(12) unsigned NOT NULL AUTO_INCREMENT;
--
-- 덤프된 테이블의 제약사항
--

--
-- 테이블의 제약사항 `psu_mem_myqna`
--
ALTER TABLE `psu_mem_myqna`
  ADD CONSTRAINT `psu_mem_myqna_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `psu_user` (`user_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- 테이블의 제약사항 `psu_mem_myqna_reply`
--
ALTER TABLE `psu_mem_myqna_reply`
  ADD CONSTRAINT `psu_mem_myqna_reply_ibfk_1` FOREIGN KEY (`mq_no`) REFERENCES `psu_mem_myqna` (`mq_no`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `psu_mem_myqna_reply_ibfk_2` FOREIGN KEY (`user_id`) REFERENCES `psu_user` (`user_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- 테이블의 제약사항 `psu_mem_presentation`
--
ALTER TABLE `psu_mem_presentation`
  ADD CONSTRAINT `psu_mem_presentation_ibfk_1` FOREIGN KEY (`u_id`) REFERENCES `psu_presentation_user` (`u_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `psu_mem_presentation_ibfk_2` FOREIGN KEY (`user_id`) REFERENCES `psu_user` (`user_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- 테이블의 제약사항 `psu_order_user`
--
ALTER TABLE `psu_order_user`
  ADD CONSTRAINT `psu_order_user_ibfk_1` FOREIGN KEY (`order_id`) REFERENCES `psu_order` (`order_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `psu_order_user_ibfk_2` FOREIGN KEY (`order_id`) REFERENCES `psu_order` (`order_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- 테이블의 제약사항 `psu_syndication`
--
ALTER TABLE `psu_syndication`
  ADD CONSTRAINT `psu_syndication_ibfk_1` FOREIGN KEY (`nav_id`) REFERENCES `psu_menu` (`nav_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- 테이블의 제약사항 `psu_write_faq`
--
ALTER TABLE `psu_write_faq`
  ADD CONSTRAINT `psu_write_faq_user_fk` FOREIGN KEY (`user_id`) REFERENCES `psu_user` (`user_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- 테이블의 제약사항 `psu_write_faq_fa`
--
ALTER TABLE `psu_write_faq_fa`
  ADD CONSTRAINT `psu_write_faq_favorite_fk` FOREIGN KEY (`bbs_id`) REFERENCES `psu_write_faq` (`bbs_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- 테이블의 제약사항 `psu_write_news`
--
ALTER TABLE `psu_write_news`
  ADD CONSTRAINT `bbs_user_fk` FOREIGN KEY (`user_id`) REFERENCES `psu_user` (`user_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- 테이블의 제약사항 `psu_write_news_fa`
--
ALTER TABLE `psu_write_news_fa`
  ADD CONSTRAINT `bbs_favorite_fk` FOREIGN KEY (`bbs_id`) REFERENCES `psu_write_news` (`bbs_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- 테이블의 제약사항 `psu_write_qna`
--
ALTER TABLE `psu_write_qna`
  ADD CONSTRAINT `psu_write_qna_user_fk` FOREIGN KEY (`user_id`) REFERENCES `psu_user` (`user_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- 테이블의 제약사항 `psu_write_qna_fa`
--
ALTER TABLE `psu_write_qna_fa`
  ADD CONSTRAINT `psu_write_qna_favorite_fk` FOREIGN KEY (`bbs_id`) REFERENCES `psu_write_qna` (`bbs_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- 테이블의 제약사항 `psu_write_umvbbst`
--
ALTER TABLE `psu_write_umvbbst`
  ADD CONSTRAINT `psu_write_umvbbst_user_fk` FOREIGN KEY (`user_id`) REFERENCES `psu_user` (`user_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- 테이블의 제약사항 `psu_write_umvbbst_fa`
--
ALTER TABLE `psu_write_umvbbst_fa`
  ADD CONSTRAINT `psu_write_umvbbst_favorite_fk` FOREIGN KEY (`bbs_id`) REFERENCES `psu_write_umvbbst` (`bbs_id`) ON DELETE CASCADE ON UPDATE CASCADE;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
