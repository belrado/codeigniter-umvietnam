<?php if(!isset($umv_lang)) $umv_lang='en'; ?>
<!doctype html>
<html lang="<?=($umv_lang=='vn')?'vi':$umv_lang?>">
<?php /*
<html lang="<?=$state_lang?>">
*/ ?>
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width,initial-scale=1.0,minimum-scale=0,maximum-scale=1">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<!-- meta -->
<meta name="title" content="<?=$meta_title?>">
<meta name="description" content="<?=$meta_description?>">
<meta name="keyword" content="<?=$meta_keyword?>">
<meta name="robots" content="index,follow">
<!-- facebook -->
<meta property="fb:app_id" content="815624092155867" />
<meta property="og:url" content="<?=current_url()?>">
<meta property="og:type" content="website">
<meta property="og:site_name" content="<?=$meta_title?>">
<meta property="og:title" content="<?=$meta_title?>">
<meta property="og:description" content="<?=$meta_description?>">
<meta property="og:image" content="<?=site_url()?>assets/img/facebook_app_logo.gif">
<meta property="og:image:width" content="512" />
<meta property="og:image:height" content="512" />
<title><?=$title?></title>
<link rel="shortcut icon" href="<?=site_url()?>favicon.png" type="image/gif" />
<!-- rss -->
<?php if(isset($home_rss)) : ?>
<link rel="alternate" type="application/rss+xml" title="RSS" href="<?=$home_rss?>">
<?php endif ?>
<link href='https://fonts.googleapis.com/css?family=Poppins' rel='stylesheet' type='text/css' />
<?php if($umv_lang!=='vn') : ?>
<link rel="stylesheet" href="<?=site_url()?>assets/css/font.css<?=set_last_modified_mtime('/assets/css/font.css')?>" />
<?php endif ?>
<link rel="stylesheet" href="<?=site_url()?>assets/css/default.css<?=set_last_modified_mtime('/assets/css/default.css')?>" />
<link rel="stylesheet" href="<?=site_url()?>assets/css/layoutA.css<?=set_last_modified_mtime('/assets/css/layoutA.css')?>" />
<link rel="stylesheet" href="<?=site_url()?>assets/css/home.css<?=set_last_modified_mtime('/assets/css/home.css')?>" />
<?php
if(isset($css_arr)){
	$custom_css_len = count($css_arr);
	if($custom_css_len >0){
		foreach($css_arr as $val){
			echo $val.PHP_EOL;
		}
	}
}
?>
<?php if($is_mobile) : ?>
<link rel="stylesheet" href="<?=site_url()?>assets/css/mobile.css<?=set_last_modified_mtime('/assets/css/mobile.css')?>" />
<?php endif ?>
<!--[if IE 9]>
<link rel="stylesheet" style="text/css" href="<?=site_url()?>assets/css/ie9.css" />
<![endif]-->
<!--[if IE 8]>
<link rel="stylesheet" style="text/css" href="<?=site_url()?>assets/css/ie8.css" />
<![endif]-->
<!--[if IE 7]>
<link rel="stylesheet" style="text/css" href="<?=site_url()?>assets/css/ie7.css" />
<![endif]-->
<link rel="canonical" href="<?=site_url()?>">
<noscript>
<link rel="stylesheet" href="<?=site_url()?>assets/css/noscript.css" />
</noscript>
<script src="<?=site_url()?>assets/js/jquery-1.9.1.min.js<?=set_last_modified_mtime('/assets/js/jquery-1.9.1.min.js')?>"></script>
<script src="<?=site_url()?>assets/js/jquery-ui.min.js<?=set_last_modified_mtime('/assets/js/jquery.easing.min.js')?>"></script>
<script>
var is_mobile = "<?=$is_mobile?>";
</script>
<script src="<?=site_url()?>assets/js/BD_common.min.js<?=set_last_modified_mtime('/assets/js/BD_common.min.js')?>"></script>
<!--[if (lte IE 8) & (gt IE 6)]>
<script src="<?=site_url()?>assets/js/html5.js"></script>
<script src="<?=site_url()?>assets/js/respond.min.js"></script>
<![endif]-->
<!-- Google Tag Manager -->
<script>(function(w,d,s,l,i){w[l]=w[l]||[];w[l].push({'gtm.start':
new Date().getTime(),event:'gtm.js'});var f=d.getElementsByTagName(s)[0],
j=d.createElement(s),dl=l!='dataLayer'?'&l='+l:'';j.async=true;j.src=
'https://www.googletagmanager.com/gtm.js?id='+i+dl;f.parentNode.insertBefore(j,f);
})(window,document,'script','dataLayer','GTM-K6FGS5V');</script>
<!-- End Google Tag Manager -->
</head>
<?php
	$page_1depth_name = (isset($page_1depth_name)) ? $page_1depth_name : '';
	$page_2depth_name = (isset($page_2depth_name)) ? $page_2depth_name : '';
	$page_3depth_name = (isset($page_3depth_name)) ? $page_3depth_name : '';
?>
<body class='<?=(isset($is_main) && $is_main) ? "main_page" : "sub_page"?> user-<?=preg_replace("/\s+/", "", trim($user_browser))?> lang-<?=$umv_lang?>-layout'>
<!-- Google Tag Manager (noscript) -->
<noscript><div style="height:0px; overflow:hidden"><iframe src="https://www.googletagmanager.com/ns.html?id=GTM-K6FGS5V"
height="0" width="0" style="display:none;visibility:hidden"></iframe></div></noscript>
<!-- End Google Tag Manager (noscript) -->
<div id="wrapper">
	<div id="skipnavigation">
		<ul>
            <li><a href="#container"><?=$lang_menu['content_go']?></a></li>
            <li><a href="#global-nav"><?=$lang_menu['main_menu_go']?></a></li>
        </ul>
	</div>
	<header id="header">
		<div class="header-wrap">
			<div class="top-logo">
				<h1>
					<a href="<?=site_url()?><?=$umv_lang?>" class="umv-logo">
						<img src="/assets/img/umv_logo_white.png" alt="UMVietnam - University of Minnesota Vietnam" />
					</a>
				</h1>
				<a href="#" class="btn-mobile-nav">
					<span class="blind"><?=$lang_menu['view_all_menu']?></span>
					<span class="line"></span>
					<span class="line"></span>
					<span class="line"></span>
					<span class="line"></span>
				</a>
			</div>
			<div class="nav-wrap <?=($this->session->userdata('user_id'))?'login-nav-wrap':''?>">
				<div class="mobile-nav-sec">
					<div class="utility-nav-sec">
						<ul class="utility-nav">
						<?php if($this->session->userdata('user_id')) : ?>
							<li>
								<a href="<?=site_url()?><?=$umv_lang?>/auth/logout/" class="top-log top-logout">
									<?=$lang_menu['logout']?>
								</a>
							</li>
						<?php else : ?>
							<li>
								<a href="<?=site_url()?><?=$umv_lang?>/auth/?returnURL=<?=rawurlencode(uri_string())?>" class="top-log top-login">
									<?=$lang_menu['login']?>
								</a>
							</li>
						<?php endif ?>
							<li>
								<div class="flag-sec">
									<a href="<?=site_url()?>language/lang_switch/en/?returnURL=<?=rawurlencode(uri_string())?>"
										class="font-poppins flag flag-eng <?=($umv_lang=='en')?'active':''?>" title="<?=$lang_menu['english']?>">EN</a>
									<a href="<?=site_url()?>language/lang_switch/vn/?returnURL=<?=rawurlencode(uri_string())?>"
										class="font-poppins flag flag-vn <?=($umv_lang=='vn')?'active':''?>" title="<?=$lang_menu['vietnamese']?>">VN</a>
									<a href="<?=site_url()?>language/lang_switch/ko/?returnURL=<?=rawurlencode(uri_string())?>"
											class="font-poppins flag flag-kor <?=($umv_lang=='ko')?'active':''?>" title="<?=$lang_menu['korean']?>">KO</a>
								</div>
							</li>
						</ul>
					</div>
					<?php if($this->session->userdata('user_id')) : ?>
						<?php if($this->session->userdata('user_level') >= 7): ?>
						<a href="<?=site_url()?>homeAdm/" class="top-mypage font-poppins">Admin</a>
						<?php else  : ?>
						<a href="<?=site_url()?><?=$umv_lang?>/mypage/" class="top-mypage font-poppins">MYPAGE</a>
						<?php endif ?>
					<?php endif ?>
					<nav>
						<h2 class="blind"><?=HOME_INFO_NAME?> <?=$lang_menu['main_menu']?></h2>
						<ul class="home-nav" id="home_nav">
						<?php foreach($mp_nav as $nav) : ?>
							<li>
								<a href="<?=site_url()?><?=$umv_lang?>/<?=fnc_set_htmls_strip($nav->nav_link)?>"
									class="depth1-txt <?=(!isset($nav->nav_depth2))?'only-depth1':''?> <?=check_nav_active2($nav->{'nav_name_'.$umv_lang}, $page_1depth_name)?>">
									<span><?=str_striptag_fnc($nav->{'nav_name_'.$umv_lang}, '<br>')?></span>
								</a>
								<?php if(isset($nav->nav_depth2)) : ?>
								<div class="home-subnav">
									<div class="mobile-subnav-layer">
										<ul class="home-nav2">
											<?php foreach($nav->nav_depth2 as $nav2) : ?>
											<li>
												<a href="<?=site_url()?><?=$umv_lang?>/<?=fnc_set_htmls_strip($nav2->nav_link)?>"
													class="depth2-txt <?php if(check_nav_active2($nav->{'nav_name_'.$umv_lang}, $page_1depth_name) && isset($page_2depth_name))echo check_nav_active2($nav2->{'nav_name_'.$umv_lang}, explode('__', $page_2depth_name)[0]); ?>">
													<span><?=fnc_set_htmls_strip($nav2->{'nav_name_'.$umv_lang})?></span>
												</a>
												<?php if(isset($nav2->nav_depth3)) : ?>
												<ul class="home-nav3">
													<?php foreach($nav2->nav_depth3 as $nav3) : ?>
													<?php
														// 해당페이지 3뎁스 메뉴들만 구하기
														if(fnc_none_spacae($nav->{'nav_name_'.$umv_lang}) == fnc_none_spacae($page_1depth_name) && fnc_none_spacae($nav2->{'nav_name_'.$umv_lang}) == fnc_none_spacae($page_2depth_name)){
															$page_3depth_nav[] = array(
																'1depth' =>$nav->{'nav_name_'.$umv_lang},
																'2depth' =>$nav2->{'nav_name_'.$umv_lang},
																'name' => $nav3->{'nav_name_'.$umv_lang},
																'link' => $nav3->nav_link
															);
														}
														// 3뎁스메뉴 페이지면 해당 메뉴이름 구해옴
														if(check_nav_active2($nav3->nav_link, uri_string()) && isset($page_2depth_name) && $page_3depth_name === ''){
															$page_3depth_name = $nav3->{'nav_name_'.$umv_lang};
														}
													?>
													<li>
														<a href="<?=site_url()?><?=$umv_lang?>/<?=fnc_set_htmls_strip($nav3->nav_link)?>"
															class="<?=(check_nav_active2($nav3->nav_link, uri_string()) && isset($page_2depth_name))?'active':'none'?>">
															<span>- <?=fnc_set_htmls_strip($nav3->{'nav_name_'.$umv_lang})?></span>
														</a>
													</li>
													<?php endforeach?>
												</ul>
												<?php endif ?>
											</li>
											<?php endforeach?>
										</ul>
									</div>
								</div>
								<?php endif ?>
							</li>
						<?php endforeach?>
						</ul>
					</nav>
					<input type="button" value="close" class="btn-close-mobile-nav" />
				</div>
				<div class="mobile-nav-bg"></div>
			</div>
		</div>
	</header>
	<?php if(isset($is_main) && $is_main) : ?>
		<?php if(isset($main_js)) echo $main_js; ?>
	<?php endif ?>
	<?php if(!isset($is_main)) :?>
	<div class="page-subheader-wrap">
		<div class="page-subheader animate-sec">
			<div class="subheader-layout section_wrapper">
				<div class="page-title-box">
					<h2 class="page-title">
					<?php if(isset($page_1depth_name) && $page_1depth_name) : ?>
						<?=$page_1depth_name?>
					<?php else : ?>
			            <?=HOME_INFO_NAME?> Page
					<?php endif ?>
					</h2>
					<?php $page_2depth_name = (isset($page_2depth_name))?explode('__', strip_tags(stripslashes($page_2depth_name), '<span>')):array(HOME_INFO_NAME.' Page'); ?>
	                <p class="title-text font-poppins">
	                    Uniersity of Minnesota Liberal Arts <br class="only-mobile-show" />&amp; ESL Course in Vietnam.
	                </p>
				</div>
				<a href="<?=site_url()?><?=$umv_lang?>/<?=$page_1depth_prev['nav_link']?>" class="page_nav_1depth page_nav_1depth_prev">
					<?=$page_1depth_prev['nav_name']?>
				</a>
				<a href="<?=site_url()?><?=$umv_lang?>/<?=$page_1depth_next['nav_link']?>" class="page_nav_1depth page_nav_1depth_next">
					<?=$page_1depth_next['nav_name']?>
				</a>
			</div>
			<div class="page-subheader-bg <?=(isset($subheader_class)) ? $subheader_class : (($page_1depth_name == '취업현황정보') ? 'information-subheader' :'default-subheader')?>"></div>
		</div>
		<div class="page-subnav-sec">
		<?php foreach($mp_nav as $mbcnav) : ?>
			<?php if($active_class === strtolower(fnc_none_spacae($mbcnav->nav_access))) : ?>
				<?php if(isset($mbcnav->nav_depth2)) : ?>
					<div class="mobile-subnav-box" id="mobile_subnav_box">
						<ul class="page-subnav">
						<?php foreach($mbcnav->nav_depth2 as $mbcnav2) :
							if(preg_match('/^_/', $mbcnav2->nav_access)) continue;
						?>
							<li class="<?=($active_method === strtolower(fnc_none_spacae($mbcnav2->nav_access)))?'this_active':''?>">
								<a href="<?=site_url()?><?=$umv_lang?>/<?=fnc_set_htmls_strip($mbcnav2->nav_link, true)?>"
									class="<?=($active_method === strtolower(fnc_none_spacae($mbcnav2->nav_access)))?'this_active':''?> <?=($active_method === strtolower(fnc_none_spacae($mbcnav2->nav_access)) || $page_3depth_parent===strtolower(fnc_none_spacae($mbcnav2->nav_access)))?'active':''?>">
									<?=fnc_set_htmls_strip($mbcnav2->{'nav_name_'.$umv_lang})?>
								</a>
								<?php if(isset($mbcnav2->nav_depth3)) :?>
								<ul class="page-subnav2">
									<?php foreach($mbcnav2->nav_depth3 as $mbcnav3) : ?>
									<li class="<?=($active_method === strtolower(fnc_none_spacae($mbcnav3->nav_access)))?'this_active':''?>">
										<a href="<?=site_url()?><?=$umv_lang?>/<?=fnc_set_htmls_strip($mbcnav3->nav_link, true)?>"
											class="<?=($active_method === strtolower(fnc_none_spacae($mbcnav3->nav_access)))?'this_active active':''?>">- <?=fnc_set_htmls_strip($mbcnav3->{'nav_name_'.$umv_lang})?></a>
									</li>
									<?php endforeach ?>
								</ul>
								<?php endif ?>
							</li>
						<?php endforeach ?>
						</ul>
						<div class="mobile-subnav-ico"></div>
					</div>
				<?php endif ?>
			<?php endif ?>
		<?php endforeach ?>
		</div>
	</div>
		<?php if(!in_array($active_class, $this->umv_class_facebook_none) && !in_array($active_method, $this->umv_method_facebook_none)) : ?>
	<!-- // Facebook // -->
	<div class="section_wrapper">
		<div class="facebook-share-sec">
			<div class="fb-like" data-href="<?=site_url()?><?=$active_class?>/<?=$active_method?>/"
				data-width="340"
				data-layout="button_count"
				data-action="like"
				data-size="small"
				data-show-faces="true"
				data-share="true">
			</div>
		</div>
	</div>
		<?php endif ?>
	<?php endif ?>
	<?php if(isset($quick_nav)) echo $quick_nav; ?>
	<?php if(isset($include_front_html)){
		$include_fronthtml_len = count($include_front_html);
		if($include_fronthtml_len>0){
			foreach($include_front_html as $html){
				echo $html.PHP_EOL;
			}
		}
	} ?>
	<div id="contents">
    <?php if(!isset($is_main)) :?>
        <div class="section_wrapper">
			<div class="content-tit-sec">
				<?php if(!empty($page_2depth_name[0])) : ?>
				<h3 class="content-tit"><?=(!empty($page_3depth_name))?$page_3depth_name:((isset($page_2depth_name[1]))?$page_2depth_name[1]:$page_2depth_name[0])?></h3>
				<?php else : ?>
				<strong class="content-tit">
					<?=($page_1depth_name)?$page_1depth_name:'UMVietnam'?>
				</strong>
				<?php endif ?>
	            <ol class="breadcrumbs">
	                <li class="home">
						<img src="/assets/img/ico_breadcrumbs_home.gif" alt="home" />
					</li>
	                <li><?=$page_1depth_name?></li>
	                <?php if(!empty($page_2depth_name)) : ?>
	                <li><?=$page_2depth_name[0]?></li>
	                <?php endif ?>
	                <?php if(!empty($page_3depth_name)) : ?>
	                <li><?=$page_3depth_name?></li>
	                <?php endif ?>
	            </ol>
			</div>
        </div>
    <?php endif ?>
