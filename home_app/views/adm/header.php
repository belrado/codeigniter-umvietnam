<?php
/* 네비게이션메뉴활성화 */
$nav_active 	= (isset($active)) ? $active : '';
$subnav_active 	= (isset($sub_active)) ? $sub_active : '';
?>
<!DOCTYPE html>
<html lang="ko">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width,initial-scale=1.0,minimum-scale=0,maximum-scale=10,user-scalable=yes">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="title" content="UMV 관리자 페이지">
<title><?=$title?></title>
<link rel="shortcut icon" href="<?=site_url()?>favicon.png" type="image/gif" />
<link rel="stylesheet" href="<?=site_url()?>assets/css/font.css<?=set_last_modified_mtime('/assets/css/font.css')?>" />
<link rel="stylesheet" href="<?=HOME_CSS_PATH?>/default.css" />
<link rel="stylesheet" href="<?=HOME_CSS_PATH?>/admin.css" />
<script src="<?=HOME_JS_PATH?>/jquery-1.9.1.min.js"></script>
<script src="<?=HOME_JS_PATH?>/BD_common.js"></script>
<script src="<?=HOME_JS_PATH?>/BD_admin_common.js"></script>
</head>
<body>
<div id="wrapper" class="<?=(isset($fullSize) && $fullSize)?'fullsize':''?>">
	<header id="header">
		<div class="global-nav-bg"></div>
		<div class="global-nav-sec">
			<h1 class="logo-admin"><a href="/homeAdm/"><img src="/assets/img/umv_logo_won_white.png" alt="UMV" /></a></h1>
			<nav>
				<ul class="utility-nav">
					<li><a href="<?=site_url()?>" target="_blank">홈페이지</a></li>
					<li><a href="<?=site_url()?>homeAdm/confirm">정보수정</a></li>
					<li><a href="<?=site_url()?>auth/logout">로그아웃</a></li>
				</ul>
			</nav>
			<h2 class="blind">관리자 주요메뉴</h2>
			<nav>
				<ul class="global-nav">
					<?php if($check_adm_lv >= 10) : ?>
					<li class="<?=set_nav_activeClass($nav_active, 'nav')?>"><a href="/homeAdm/nav">메뉴관리</a></li>
					<li class="<?=set_nav_activeClass($nav_active, 'bbs')?>"><a href="/homeAdm/bbs">게시판관리</a></li>
					<?php endif ?>
					<?php if($check_adm_lv >= 9): ?>
					<li class="<?=set_nav_activeClass($nav_active, 'popup')?>"><a href="/homeAdm/popup">팝업창관리</a></li>
					<li class="<?=set_nav_activeClass($nav_active, 'univ')?>">
						<a href="/homeAdm/univ/list/1">한국대관리</a>
						<ul class="sub-nav">
							<li><a href="/homeAdm/univ/list/1" class="<?=set_nav_activeClass($subnav_active, 'univ_list')?>">- 대학교목록</a></li>
							<li><a href="/homeAdm/univ/write" class="<?=set_nav_activeClass($subnav_active, 'univ_write')?>">- 대학교등록</a></li>
						</ul>
					</li>
                    <?php endif ?>
					<li class="<?=set_nav_activeClass($nav_active, 'presentation')?>">
						<a href="/homeAdm/presentation_day">설명회</a>
						<ul class="sub-nav">
							<li><a href="/homeAdm/presentation_day" class="<?=set_nav_activeClass($subnav_active, 'presentation_list')?>">- 설명회 일정</a></li>
							<li><a href="/homeAdm/presentation" class="<?=set_nav_activeClass($subnav_active, 'presentation')?>">- 설명회 예약자</a></li>
						</ul>
					</li>
                    <li class="<?=set_nav_activeClass($nav_active, 'members')?>"><a href="/homeAdm/members">회원목록</a></li>
					<li class="<?=set_nav_activeClass($nav_active, 'register')?>"><a href="/homeAdm/register">회원등록</a></li>
					<?php if($check_adm_lv >= 10): ?>
					<li class="<?=set_nav_activeClass($nav_active, 'error_log')?>"><a href="/homeAdm/error_log">에러로그기록</a></li>
					<?php endif ?>
				</ul>
			</nav>
			<strong style="color:#fff">CI ver:<?=CI_VERSION?></strong>
		</div>
		<?php if(isset($fullSize) && $fullSize) : ?>
		<input type="button" value="메뉴보기" id="view_header" />
		<?php endif ?>
	</header>
	<div id="contents">
