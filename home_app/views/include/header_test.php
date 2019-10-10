<?php if(!isset($umv_lang)) $umv_lang='en'; ?>
<!doctype html>
<html lang="<?=$state_lang?>">
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
<meta property="og:type" content="website">
<meta property="og:site_name" content="<?=$meta_title?>">
<meta property="og:title" content="<?=$meta_title?>">
<meta property="og:description" content="<?=$meta_description?>">
<meta property="og:keyword" content="<?=$meta_keyword?>">
<meta property="og:url" content="<?=site_url()?>">
<meta property="og:image" content="<?=site_url()?>assets/img/SNSimg.jpg">
<!-- twitter -->
<meta name="twitter:card" content="<?=$meta_title?>" />
<meta name="twitter:url" content="<?=site_url()?>" />
<meta name="twitter:title" content="<?=$meta_title?>" />
<meta name="twitter:description" content="<?=$meta_description?>" />
<meta name="twitter:image" content="<?=site_url()?>assets/img/SNSimg.jpg" />
<title><?=$title?></title>
<link rel="shortcut icon" href="<?=site_url()?>favicon.png" type="image/gif" />
<!-- rss -->
<?php if(isset($home_rss)) : ?>
<link rel="alternate" type="application/rss+xml" title="RSS" href="<?=$home_rss?>">
<?php endif ?>
<link href='https://fonts.googleapis.com/css?family=Volkhov:400,700+Poppins' rel='stylesheet' type='text/css' />
<link rel="stylesheet" href="<?=site_url()?>assets/css/font.css<?=set_last_modified_mtime('/assets/css/font.css')?>" />
<link rel="stylesheet" href="<?=site_url()?>assets/css/default.css<?=set_last_modified_mtime('/assets/css/default.css')?>" />
<link rel="stylesheet" href="<?=site_url()?>assets/css/layoutA.css<?=set_last_modified_mtime('/assets/css/layoutA.css')?>" />
<link rel="stylesheet" href="<?=site_url()?>assets/css/home.css<?=set_last_modified_mtime('/assets/css/home.css')?>" />
<?php if($is_mobile) : ?>
<link rel="stylesheet" href="<?=site_url()?>assets/css/mobile.css<?=set_last_modified_mtime('/assets/css/mobile.css')?>" />
<?php endif ?>
<link rel="stylesheet" href="<?=site_url()?>node_modules/swiper/dist/css/swiper.min.css" />
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
<noscript>
<link rel="stylesheet" href="<?=site_url()?>assets/css/noscript.css" />
</noscript>
<script src="<?=site_url()?>assets/js/jquery-1.9.1.min.js<?=set_last_modified_mtime('/assets/js/jquery-1.9.1.min.js')?>"></script>
<script src="<?=site_url()?>assets/js/jquery.easing.min.js<?=set_last_modified_mtime('/assets/js/jquery.easing.min.js')?>"></script>
<script src="<?=site_url()?>assets/js/iscroll.js"></script>
<script>
var is_mobile = "<?=$is_mobile?>";
</script>
<script src="<?=site_url()?>assets/js/BD_common.js<?=set_last_modified_mtime('/assets/js/BD_common.js')?>"></script>
<!--[if (lte IE 8) & (gt IE 6)]>
<script src="<?=site_url()?>assets/js/html5.js"></script>
<script src="<?=site_url()?>assets/js/respond.min.js"></script>
<![endif]-->
</head>
<body class='<?=(isset($is_main) && $is_main) ? "main_page" : "sub_page"?> user-<?=preg_replace("/\s+/", "", trim($user_browser))?> lang-<?=$umv_lang?>-layout'>
<div id="wrapper">
	<div id="skipnavigation">
		<ul>
            <li><a href="#container"><?=$lang_menu['content_go']?></a></li>
            <li><a href="#global-nav"><?=$lang_menu['main_menu_go']?></a></li>
        </ul>
	</div>
	<header>
		<div id="header-wrap">
			<div class="header-sec section_wrapper">
				<div id="header" class="logo-sec">
					<h1>
                        <a href="<?=site_url()?><?=$umv_lang?>" class="logo"><img src="/assets/img/<?=($is_mobile)?'umv_logo_240.png':'umv_logo_120.png'?>" alt="UMV - U of Minnesota, Vietnam" /></a>
                    </h1>
					<ul class="utility-menu">
                        <li class="flag-wrap">
                            <div class="flag-sec">
                                <a href="<?=site_url()?>language/lang_switch/ko/?returnURL=<?=rawurlencode(uri_string())?>" class="flag <?=($umv_lang=='ko')?'active':''?>">
                                    <img src="/assets/img/flag_korea.png" alt="<?=$lang_menu['korean']?>" />
                                </a>
                                <a href="<?=site_url()?>language/lang_switch/en/?returnURL=<?=rawurlencode(uri_string())?>" class="flag <?=($umv_lang=='en')?'active':''?>">
                                    <img src="/assets/img/flag_usa.png" alt="<?=$lang_menu['english']?>" />
                                </a>
                                <?php /*
                                <a href="<?=site_url()?>language/lang_switch/vi/?returnURL=<?=rawurlencode(uri_string())?>" class="flag <?=($umv_lang=='vi')?'active':''?>">
                                    <img src="/assets/img/flag_vietnam.png" alt="<?=$lang_menu['vietnamese']?>" />
                                </a>
                                */ ?>
                            </div>
                        </li>
    					<?php if($this->session->userdata('user_id') && $this->session->userdata('user_level') >= 7) : ?>
    					<li><a href="<?=site_url()?>homeAdm/" class="umenus"><?=$lang_menu['admin']?></a></li>
    					<li><a href="<?=site_url()?><?=$umv_lang?>/mypage/scrap" class="umenus"><?=$lang_menu['scrap']?></a></li>
    					<?php elseif($this->session->userdata('user_id') && ($this->session->userdata('user_level') >= 2 && $this->session->userdata('user_id') && $this->session->userdata('user_level') < 7)) : ?>
    					<li><a href="<?=site_url()?><?=$umv_lang?>/mypage" class="umenus"><?=$lang_menu['mypage']?></a></li>
    					<?php endif ?>
    					<?php if($this->session->userdata('user_id')) : ?>
    					<li><a href="<?=site_url()?><?=$umv_lang?>/auth/logout/" class="umenus"><?=$lang_menu['logout']?></a></li>
    					<?php else : ?>
    					<li><a href="<?=site_url()?><?=$umv_lang?>/auth/?returnURL=<?=rawurlencode(uri_string())?>" class="umenus"><?=$lang_menu['login']?></a></li>
    					<?php endif ?>
    					<?php if(isset($main_begine_eventpop)) : ?>
    					<li <?=(!$main_begine_eventpop && ((isset($early_display['season']) && $early_display['season'] > 0)||$home_popup) && (isset($is_main) && $is_main))?'class="active show"':''?> id="header_event_menu">
    					<?php else : ?>
    					<li <?=($home_popup && (isset($is_main) && $is_main))?'class="active show"':''?> id="header_event_menu">
    					<?php endif ?>
    						<div class="umenus <?=($home_popup)?'umenus-wifi':''?>">
    							<?=$lang_menu['event']?>
    							<?php if($home_popup) :?>
    							<div class="event-wifi">
    								<div class="wifi wifi0"><div class="ico"></div></div>
    								<div class="wifi wifi1"><div class="ico"></div></div>
    								<div class="wifi wifi2"><div class="ico"></div></div>
    							</div>
    							<?php endif ?>
    						</div>
    						<div class="<?=($home_popup)?'open-popup-event':'close-popup-event'?>">
    							<div id="header_event_pop" class="header_event_pop">
    								<ul class="header_event_list">
    								<?php if($home_popup) : $popup_len = 0; $pop_randopen_len = rand(0, (count($home_popup)-1)); ?>
    									<?php foreach($home_popup as $val) : ?>
    									<li class="<?=((!isset($early_display['season']) || $early_display['season'] <= 0) && $popup_len===$pop_randopen_len)?'open-event-img':''/*($popup_len==0)?'open-event-img':''*/ ?><?=($val['pop_viewtype'] === 'onlytext' && empty($val['pop_alt_'.$umv_lang]))?' textevent':''?> <?=$val['pop_class']?>">
    										<?php if(!empty($val['pop_link'])) : ?>
    											<a href="<?=$this->homelanguage->set_lang_home_uri(strip_tags(stripslashes($val['pop_link'])), $umv_lang)?>" target="<?=strip_tags(stripslashes($val['pop_target']))?>" class="event-box-sec">
    										<?php else : ?>
    											<div class="event-box-sec">
    										<?php endif ?>
    										<?php if(!empty($val['pop_file_path_'.$umv_lang]) || ($val['pop_viewtype'] === 'onlytext' && !empty($val['pop_alt_'.$umv_lang]))) : ?>
    										<div class="<?=($val['pop_viewtype'] === 'onlytext' && empty($val['pop_alt_'.$umv_lang]))?'':'toggle-box'?>">
    											<div class="event-img">
                                                    <?php if($val['pop_viewtype'] === 'onlytext') :?>
                                                    <div class="inner-box">
                                                        <div class="inner-text-box">
                                                            <?=nl2br(fnc_set_htmls_strip(str_replace('\r\n', PHP_EOL, $val['pop_alt_'.$umv_lang])))?>
                                                        </div>
                                                    </div>
                                                    <?php else :?>
    												<div class="inner-box"><img src="<?=strip_tags(stripslashes($val['pop_file_path_'.$umv_lang]))?>" alt="<?=strip_tags(stripslashes(fnc_clear_marks($val['pop_subject_'.$umv_lang])))?>" /></div>
                                                    <?php endif ?>
                                                </div>
    										</div>
    										<?php endif ?>
    										<div class="event-subject-sec">
    											<strong class="event-subject"><?=strip_tags(stripslashes($val['pop_subject_'.$umv_lang]), '<span></span>')?></strong>
    											<p class="event-text"><?=strip_tags(stripslashes($val['pop_text_'.$umv_lang]))?></p>
    											<?php if($val['pop_viewtype'] === 'onlytext') : ?>
    												<?php if(!empty($val['pop_link'])) : ?>
    													<div class="ico-textlink"></div>
    												<?php endif ?>
    											<?php else : ?>
    												<strong class="read-more">Click</strong>
    												<div class="ico-toggle"></div>
    											<?php endif ?>
    										</div>
    										<?php if(!empty($val['pop_link'])) : ?></a><?php else : ?></div><?php endif ?>
    									</li>
    									<?php $popup_len++; endforeach ?>
    								<?php else : ?>
    									<li>
    										<div class="none-event-sec">
    											<p class="none-event-txt"><?=$lang_message['no_registered_events']?></p>
    										</div>
    									</li>
    								<?php endif ?>
    								</ul>
    								<div class="header_event_close_btn"><input type="button" value="<?=$lang_menu['close_event_pop']?>" class="close_btn" /></div>
    							</div>
    						</div>
    					</li>
					</ul>
					<div class="home-call-sec">
						<strong class="blind"><?=$lang_menu['customer']?></strong>
						<?php if(!$is_mobile) : ?>
						<p>+84-34-970-586</p>
						<?php else : ?>
						<a href="tel:+84-34-970-586">+84-34-970-586</a>
						<?php endif ?>
					</div>
				</div>
				<div id="mobile-navbtn-sec"><a href="<?=site_url()?><?=$umv_lang?>/sitemap"><?=$lang_menu['view_all_menu']?></a><span class="line1"></span><span class="line2"></span><span class="line3"></span></div>
				<div id="global-nav-sec">
					<nav>
						<h2 class="blind"><?=HOME_INFO_NAME?> <?=$lang_menu['main_menu']?></h2>
						<div id="iscroll-global-nav">
							<div class="global-nav-mobile-box">
								<?php
								$page_1depth_name = (isset($page_1depth_name)) ? $page_1depth_name : '';
								$page_2depth_name = (isset($page_2depth_name)) ? $page_2depth_name : '';
								$page_3depth_name = (isset($page_3depth_name)) ? $page_3depth_name : '';
								?>
								<ul class="global-nav" id="global-nav">
								<?php for($i=0; $i<count($mp_nav); $i++) : ?>
								<li class="<?php if(isset($page_1depth_name)) echo check_nav_active2($mp_nav[$i]->{'nav_name_'.$umv_lang}, $page_1depth_name); ?>
                                    <?=($i == (count($mp_nav)-1))?' last':''?>
                                    <?=(get_nav_newico_day_check($mp_nav[$i]))?'nav-new-ico':''?>">
									<a href="<?=site_url()?><?=$umv_lang?>/<?=$mp_nav[$i]->nav_link?>">
                                        <div class="menu-name"><?=fnc_set_htmls_strip($mp_nav[$i]->{'nav_name_'.$umv_lang})?><span class="active-line"></span></div>
                                    </a>
									<?php if(isset($mp_nav[$i]->nav_depth2)) : ?>
									<div class="sub-layer">
										<div class="sub-nav-sec">
											<ul class="sub-nav">
											<?php for($j=0; $j<count($mp_nav[$i]->nav_depth2); $j++) : ?>
											<li class="<?=(strtotime($mp_nav[$i]->nav_depth2[$j]->nav_new.'+'.'7'.' days') > strtotime(date('Y-m-d h:i:s', time())))?'nav-new-ico':''?>">
												<?php $depth2 = $mp_nav[$i]->nav_depth2[$j]; ?>
												<?php if(isset($mp_nav[$i]->nav_depth2[$j]->nav_depth3)) : ?>
													<!-- // 3뎁스 메뉴가 있다면 // -->
													<a href="<?=site_url()?><?=$umv_lang?>/<?=$depth2->nav_link?>"
													class="<?=check_nav_active3($depth2->nav_link, 2)?>" tabindex="-1">
														<span class="animate_bottom_line"><?=fnc_set_htmls_strip($depth2->{'nav_name_'.$umv_lang})?></span>
													</a>
												<?php else : ?>
													<!-- // 3뎁스 메뉴가 없다면 // -->
													<a href="<?=site_url()?><?=$umv_lang?>/<?=$depth2->nav_link?>"
													class="<?php if(check_nav_active2($mp_nav[$i]->{'nav_name_'.$umv_lang}, $page_1depth_name) && isset($page_2depth_name))echo check_nav_active2($depth2->{'nav_name_'.$umv_lang}, explode('__', $page_2depth_name)[0]); ?>" tabindex="-1">
                                                    	<span class="animate_bottom_line"><?=fnc_set_htmls_strip($depth2->{'nav_name_'.$umv_lang})?></span>
													</a>
												<?php endif ?>
												<?php if(isset($mp_nav[$i]->nav_depth2[$j]->nav_depth3)) : ?>
												<ul class="sub-nav2">
												<?php for($c=0; $c<count($mp_nav[$i]->nav_depth2[$j]->nav_depth3); $c++) : ?>
													<?php
													$depth3 = $mp_nav[$i]->nav_depth2[$j]->nav_depth3[$c];
													// 해당페이지 3뎁스 메뉴들만 구하기
													if(fnc_none_spacae($mp_nav[$i]->{'nav_name_'.$umv_lang}) == fnc_none_spacae($page_1depth_name) && fnc_none_spacae($mp_nav[$i]->nav_depth2[$j]->{'nav_name_'.$umv_lang}) == fnc_none_spacae($page_2depth_name)){
														$page_3depth_nav[] = array(
															'1depth' =>$mp_nav[$i]->{'nav_name_'.$umv_lang},
															'2depth' =>$mp_nav[$i]->nav_depth2[$j]->{'nav_name_'.$umv_lang},
															'name' => $depth3->{'nav_name_'.$umv_lang},
															'link' => $depth3->nav_link
														);
													}
													// 3뎁스메뉴 페이지면 해당 메뉴이름 구해옴
													if(check_nav_active2($depth3->nav_link, uri_string()) && isset($page_2depth_name) && $page_3depth_name === ''){
														$page_3depth_name = $depth3->{'nav_name_'.$umv_lang};
													}
													?>
												<li class="<?=(strtotime($depth3->nav_new.'+'.'7'.' days') > strtotime(date('Y-m-d h:i:s', time())))?'nav-new-ico':''?>">
													<a href="<?=site_url()?><?=$umv_lang?>/<?=$depth3->nav_link?>"
                                                        class="<?=(check_nav_active2($depth3->nav_link, uri_string()) && isset($page_2depth_name))?'active':'none'?>" tabindex="-1">
														- <span class="animate_bottom_line"><?=$depth3->{'nav_name_'.$umv_lang}?></span>
													</a>
												</li>
												<?php endfor ?>
												</ul>
												<?php endif ?>
											</li>
											<?php endfor ?>
											</ul>
										</div>
									</div>
									<?php endif ?>
								</li>
								<?php endfor ?>
								</ul>
							</div>
						</div>
						<div class="subnav-mobilebg" id="subnav-mobilebg"></div>
					</nav>
				</div>
			</div>
			<div class="header-bg"></div>
		</div>
	</header>
	<?php if(isset($is_main) && $is_main) : ?>
		<?php if(isset($main_js)) echo $main_js; ?>
	<?php endif ?>
	<?php if(!isset($is_main)) :?>
	<div class="top-fixed-padding">
		<div class="page-subheader animate-sec">
			<div class="page-title-box">
			<?php if(isset($page_1depth_name) && $page_1depth_name) : ?>
				<h2 class="page-title"><?=$page_1depth_name?></h2>
			<?php else : ?>
                <h2 class="page-title"><?=HOME_INFO_NAME?> Page</h2>
			<?php endif ?>
            <?php $page_2depth_name = (isset($page_2depth_name))?explode('__', fnc_set_htmls_strip($page_2depth_name)):array(HOME_INFO_NAME.' Page'); ?>
                <p>
                    Uniersity of Minnesota Liberal Arts &amp; ESL Course in Vietnam.
                </p>
			</div>
			<div class="page-subheader-bg <?=(isset($subheader_class)) ? $subheader_class : (($page_1depth_name == '취업현황정보') ? 'information-subheader' :'default-subheader')?>"></div>
		</div>

        <div>
prev: <a href="<?=site_url()?><?=$umv_lang?>/<?=$page_1depth_prev['nav_link']?>"><?=$page_1depth_prev['nav_name']?></a><br />
next: <a href="<?=site_url()?><?=$umv_lang?>/<?=$page_1depth_next['nav_link']?>"><?=$page_1depth_next['nav_name']?></a>
        </div>

		<div class="psu-breadcrumbs">
			<div class="section_wrapper">
				<?php /* pc화면은 브래드크럼, 모바일은 2,3뎁스 보여주는 용도 */
				if(!$is_mobile) : ?>
				<ol id="breadcrumb" class="breadcrumb">
					<li class="breadcrumb-home"><a href="<?=site_url()?>"><?=$umv_lang?>/Home</a></li>
					<li class="<?=(isset($page_2depth_name) && !empty($page_2depth_name))?'breadcrumb-first':'breadcrumb-only'?> <?=(!isset($page_2depth_name) || empty($page_2depth_name))?'last':''?>">
						<strong class="now-page <?=(isset($breadcrumbs['depth1']))?'nextlist':''?>"><?=$page_1depth_name?></strong>
						<?php if(isset($breadcrumbs['depth1'])) : ?>
						<div class="breadcrumb-nav-box">
							<ul class="breadcrumb-nav">
							<?php foreach($breadcrumbs['depth1'] as $bval) : ?>
								<li>
									<a href="<?=site_url()?><?=$umv_lang?>/<?=fnc_set_htmls_strip($bval['nav_link'], true)?>"
										class="<?=($active_class===strtolower(fnc_none_spacae($bval['nav_access'])))?'active':''?>"><?=fnc_set_htmls_strip($bval['nav_name'], true)?></a>
								</li>
							<?php endforeach ?>
							</ul>
						</div>
						<?php endif ?>
					</li>
					<?php if(isset($page_2depth_name) && !empty($page_2depth_name)) : ?>
					<li class="<?=(empty($page_3depth_name))?'last':''?>">
						<strong class="now-page <?=(isset($breadcrumbs['depth2']))?'nextlist':''?>"><?=(isset($page_2depth_name[0]))?$page_2depth_name[0]:''?></strong>
						<?php if(isset($breadcrumbs['depth2'])) : ?>
						<div class="breadcrumb-nav-box">
							<ul class="breadcrumb-nav">
							<?php foreach($breadcrumbs['depth2'] as $bval) : ?>
								<li>
									<a href="<?=site_url()?><?=$umv_lang?>/<?=fnc_set_htmls_strip($bval->nav_link, true)?>"
										class="<?=($active_method===strtolower(fnc_none_spacae($bval->nav_access)) || $page_3depth_parent===strtolower(fnc_none_spacae($bval->nav_access)))?'active':''?>">
										<?=fnc_set_htmls_strip($bval->{'nav_name_'.$umv_lang})?></a>
								</li>
							<?php endforeach ?>
							</ul>
						</div>
						<?php endif ?>
					</li>
					<? endif ?>
					<?php if((isset($page_3depth_nav) && count($page_3depth_nav)>=1) || !empty($page_3depth_name)) : ?>
					<li class="last">
						<div>
							<?php if(!empty($page_3depth_name)) : ?>
							<strong class="now-page <?=(isset($breadcrumbs['depth3']))?'nextlist':''?>"><?=(isset($page_3depth_name))?$page_3depth_name:''?></strong>
							<?php else : ?>
							<strong class="now-page nextlist"><?=$lang_bbs['select']?></strong>
							<?php endif ?>
							<?php if(isset($breadcrumbs['depth3'])) : ?>
							<div class="breadcrumb-nav-box">
							<ul class="breadcrumb-nav">
							<?php foreach($breadcrumbs['depth3'] as $b3val) : ?>
								<li>
									<a href="<?=site_url()?><?=$umv_lang?>/<?=fnc_set_htmls_strip($b3val->nav_link, true)?>"
										class="<?=($active_method===strtolower(fnc_none_spacae($b3val->nav_access)))?'active':''?>">
                                        <?=fnc_set_htmls_strip($b3val->{'nav_name_'.$umv_lang})?>
                                    </a>
								</li>
							<?php endforeach ?>
							</ul>
							</div>
							<?php endif ?>
						</div>
					</li>
					<?php endif ?>
				</ol>
				<?php else : ?>
				<!-- // 모바일 // -->
					<?php foreach($mp_nav as $mbcnav) : ?>
						<?php if($active_class === strtolower(fnc_none_spacae($mbcnav->nav_access))) : ?>
							<?php if(isset($mbcnav->nav_depth2)) : ?>
				<div id="mobile-page-nav">
					<div id="bc_scroller">
						<ul class="mobile-page-nav">
						<?php foreach($mbcnav->nav_depth2 as $mbcnav2) : ?>
							<li>
								<a href="<?=site_url()?><?=$umv_lang?>/<?=fnc_set_htmls_strip($mbcnav2->nav_link, true)?>"
									class="<?=($active_method === strtolower(fnc_none_spacae($mbcnav2->nav_access)))?'this_active':''?> <?=($active_method === strtolower(fnc_none_spacae($mbcnav2->nav_access)) || $page_3depth_parent===strtolower(fnc_none_spacae($mbcnav2->nav_access)))?'active':''?>">
                                    <?=fnc_set_htmls_strip($mbcnav2->{'nav_name_'.$umv_lang})?>
                                </a>
								<?php if(isset($mbcnav2->nav_depth3)) :?>
								<ul class="mobile-page-subnav">
									<?php foreach($mbcnav2->nav_depth3 as $mbcnav3) : ?>
									<li>
										<a href="<?=site_url()?><?=$umv_lang?>/<?=fnc_set_htmls_strip($mbcnav3->nav_link, true)?>"
											class="<?=($active_method === strtolower(fnc_none_spacae($mbcnav3->nav_access)))?'this_active active':''?>">- <?=fnc_set_htmls_strip($mbcnav3->{'nav_name_'.$umv_lang})?></a>
									</li>
									<?php endforeach ?>
								</ul>
								<?php endif ?>
							</li>
						<?php endforeach ?>
						</ul>
					</div>
				</div>
							<?php endif ?>
						<?php endif ?>
					<?php endforeach ?>
				<!-- // 끝 모바일 // -->
				<?php endif ?>
			</div>
		</div>
	</div>
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
            <h3><?=$page_2depth_name[0]?></h3>
            <ol>
                <li>home</li>
                <li><?=$page_1depth_name?></li>
                <?php if(!empty($page_2depth_name)) : ?>
                <li><?=$page_2depth_name[0]?></li>
                <?php endif ?>
                <?php if(!empty($page_3depth_name)) : ?>
                <li><?=$page_3depth_name?></li>
                <?php endif ?>
            </ol>
        </div>
    <?php endif ?>
