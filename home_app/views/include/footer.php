	</div>
	<!-- // #contents end // -->
	<!-- // include file // -->
	<?php if(isset($include_html)){
		$include_html_len = count($include_html);
		if($include_html_len>0){
			foreach($include_html as $html){
				echo $html.PHP_EOL;
			}
		}
	} ?>
	<?php if(!isset($is_main) || !$is_main) : ?>

	<?php elseif($is_main && function_exists('get_cookie') && !get_cookie('eventpop')) : ?>
		<?php if($home_popup) : /* 팝업창 */ $popval_len = count($home_popup); ?>
		<div id="home_popup" class="home-popup <?=($popval_len>1)?'':'single-popup'?>" data-eventkey="<?=$this->security->get_csrf_hash()?>">
			<h2 class="blind">UMV EVENT</h2>
			<div class="popup">
			<?php for($i=0; $i<$popval_len; $i++) : ?>
				<h3 class="blind"><?=fnc_set_striptag_strip($home_popup[$i]['pop_subject_'.$umv_lang])?></h3>
				<?=(empty($home_popup[$i]['pop_link']))?'<div class="inner-box '.(($i==0)?'active-box':'').'">':'<a href="'.fnc_set_striptag_strip($home_popup[$i]['pop_link'], true).'" target="'.fnc_set_striptag_strip($home_popup[$i]['pop_target'], true).'" class="inner-box '.(($i==0)?'active-box':'').'">'?>
				<?php if($home_popup[$i]['pop_viewtype'] === 'onlytext') : ?>
					<div class="text">
						<?=str_striptag_fnc($home_popup[$i]['pop_alt_'.$umv_lang], "<br>")?>
					</div>
				<?php else : ?>
					<div class="popup-img">
					<?php if(!empty($home_popup[$i]['pop_file_path_'.$umv_lang])) : ?>
						<img src="<?=fnc_set_striptag_strip($home_popup[$i]['pop_file_path_'.$umv_lang], true)?>" alt="<?=fnc_set_striptag_strip($home_popup[$i]['pop_alt_'.$umv_lang], true)?>" />
					<?php elseif(!empty($home_popup[$i]['pop_file_path_ko'])) : ?>
						<img src="<?=fnc_set_striptag_strip($home_popup[$i]['pop_file_path_ko'], true)?>" alt="<?=fnc_set_striptag_strip($home_popup[$i]['pop_alt_'.$umv_lang], true)?>" />
					<?php elseif(!empty($home_popup[$i]['pop_file_path_en'])) : ?>
						<img src="<?=fnc_set_striptag_strip($home_popup[$i]['pop_file_path_en'], true)?>" alt="<?=fnc_set_striptag_strip($home_popup[$i]['pop_alt_'.$umv_lang], true)?>" />
					<?php elseif(!empty($home_popup[$i]['pop_file_path_vn'])) : ?>
						<img src="<?=fnc_set_striptag_strip($home_popup[$i]['pop_file_path_vn'], true)?>" alt="<?=fnc_set_striptag_strip($home_popup[$i]['pop_alt_'.$umv_lang], true)?>" />
					<?php else : ?>
						<?=str_striptag_fnc($home_popup[$i]['pop_alt_'.$umv_lang], "<br>")?>
					<?php endif ?>
					</div>
				<?php endif ?>
				<?=(empty($home_popup[$i]['pop_link']))?'</div>':'</a>'?>
			<?php endfor ?>
			</div>
			<div class="controller">
				<?php if($popval_len>1) : ?>
				<ul class="popup-nav">
				<?php for($i=0; $i<$popval_len; $i++) : ?>
					<li style="width:<?=100/$popval_len?>%" class="<?=($i==0)?'active':''?>">
						<div class="popup-title">
							<?=fnc_set_striptag_strip($home_popup[$i]['pop_subject_'.$umv_lang])?>
						</div>
					</li>
				<?php endfor ?>
				</ul>
				<?php endif ?>
				<label class="today">
					<input type="checkbox" name="today_hide" class="today-hide" />
					<?=stripslashes($lang_menu['do_not_show_today'])?>
				</label>
				<input type="button" value="<?=stripslashes($lang_menu['close_event_pop'])?>" class="popup-close" />
			</div>
		</div>
		<script>
		(function(){
			var homepop = $('#home_popup');
			var controller = homepop.find('.popup-nav>li');
			homepop.draggable({
				start:function(){
					$(this).addClass('topindex');
				},
				stop:function(){
					$(this).removeClass('topindex');
				}
			});
			controller.on({
				click:function(e){
					if(!$(this).hasClass('active')){
						var _index = $(this).index();
						var popbox = homepop.find('.inner-box');
						$(this).addClass('active');
						controller.not($(this)).removeClass('active');
						popbox.eq(_index).addClass('active-box')
						popbox.not(popbox.eq(_index)).removeClass('active-box');
					}
				}
			});
			homepop.find('.popup-close').on({
				click:function(){
					homepop.hide();
					if(homepop.find('input[name="today_hide"]').is(':checked')){
						try{
							var action = "/setTodayCookie";
							var token  = homepop.data('eventkey');
							$.ajax({
								type:'post',
								url:action,
								data:{
									'cookie_name':'eventpop',
									'day_type':'today',
									'csrf_token_home':token
								},
								dataType:"JSON",
								success:function(data){
									console.log(data);
									if(data.home_token){
										var return_token = data.home_token;
										$('input[name="csrf_token_home"]').val(return_token);
									}
								},
								error:function(xhr, status, error){
									console.log(xhr, status, error)
								}
							});
						}catch(e){}
					}
				}
			});
		})();
		</script>
		<?php endif ?>
	<?php endif ?>
	<footer id="footer" class="footer-sec">
		<div class="section_wrapper">
			<h2 class="footer-logo">
				<img src="/assets/img/umv_logo_white.png" alt="UMV" />
			</h2>
			<div class="family-site">
				<a href="<?=site_url()?><?=$umv_lang?>/privacy_policy" class="family-tit" id="footer_privacy_policy">
					<?=$lang_menu['privacy_policy']?>
				</a>
			</div>
			<?php /*
			<div class="family-site">
				<input type="button" class="family-tit" id="family-tit-click" value="FAMILY SITE" />
				<div class="family-list-sec">
					<ul class="family-list">
						<li class="last">
							<a href="http://psuedu.org/" target="_blank" title="<?=$lang_menu['new_window']?>" class="animate-nav-ov">
								<span class="animate-nav-txt">PSU에듀센터</span>
							</a>
						</li>
						<li class="last">
							<a href="http://mediprep.co.kr/" target="_blank" title="<?=$lang_menu['new_window']?>" class="animate-nav-ov">
								<span class="animate-nav-txt">MEDIPREP</span>
							</a>
						</li>
					</ul>
				</div>
			</div>
			*/ ?>
			<div class="footer-info">
				<p class="marginB5">
					VNU-HCM, University of Economics and Law
				</p>
				<address class="marginB5">
					#A303 (University of Minnesota Vietnam Office), <br />669 Highway 1. Quarter Linh Xuan Ward 3-Thu Duc, Ho Chi Minh City, Vietnam
				</address>
				<p class="marginB15">Office: +84.28.3724.4555 (ext. 6363) | <br class="only-mobile-show" />Mobile: +84.34.970.5862 <br />Email: admission@umvietnam.com</p>
				<p class="">Copyright &copy; 2019 - <strong>UMVietnam.</strong> Co., LTD. ALL RIGHT RESERVED</p>
			</div>
		</div>
	</footer>
	<?php if(!$is_mobile) : ?>
	<a href="#top" id="home-top" title="<?=$lang_menu['top']?>" class="font-poppins">TOP</a>
	<?php endif ?>
</div>
<!-- // #wrapper end // -->
<script>
	animate_class_add(1.3);
	$('#footer_privacy_policy').on({
		click:function(e){
			//e.preventDefault ? e.preventDefault() : (e.returnValue = false);
		}
	});
	$('.only-member-btn').on({
		click:function(e){
			//e.preventDefault ? e.preventDefault() : (e.returnValue = false);
			try{
				var uri = $(this).attr('href');
				if(!confirm('<?=$lang_message['requires_login_msg']?>\n<?=$lang_message['move_login_page']?>')){
					return false;
				}
			}catch(e){}
		}
	});
</script>
<?php
// 컨트롤러에서 지정한 자바스크립트 뿌려줌
if(isset($javascript_arr)){
	$custom_js_len = count($javascript_arr);
	if($custom_js_len >0){
		foreach($javascript_arr as $js){
			echo $js.PHP_EOL;
		}
	}
}
?>
<!-- // 메인이라면 // -->
<?php if(isset($is_main) && $is_main) : ?>

<?php else : ?>
	<div id="fb-root"></div>
	<script>(function(d, s, id) {
	  var js, fjs = d.getElementsByTagName(s)[0];
	  if (d.getElementById(id)) return;
	  js = d.createElement(s); js.id = id;
	  js.src = "https://connect.facebook.net/ko_KR/sdk.js#xfbml=1&version=v3.3&appId=815624092155867&autoLogAppEvents=1";
	  fjs.parentNode.insertBefore(js, fjs);
	}(document, 'script', 'facebook-jssdk'));</script>
<?php endif ?>
<!-- // 경고창 // -->
<?php if($this->session->flashdata('message')) : ?>
<script>
	var show_message = "<?=$this->session->flashdata('message')?>";
	setTimeout(function(){
		alert(show_message);
	},300);
</script>
<?php endif ?>
<!-- // 구글 네이버 구조화 데이터 // -->
<script type="application/ld+json">
{
	"@context": "http://schema.org",
	"@type": "Organization",
	"url": "https://umvietnam.com",
	"name": "UMVietnam - University of Minnesota, Vietnam",
	"logo": "https://umvietnam.co/assets/img/umv_logo_won.png",
	"description": "<?=$meta_description?>",
	//"sameAs": [
	//	"https://www.facebook.com/gangnamSAT",
	//	"https://blog.naver.com/gracejks/"
	//],
	"contactPoint": {
		"@type": "ContactPoint",
		"telephone": "+84.28.3724.4555",
		"contactType": "Customer service"
	}
}
</script>
<!-- AceCounter Log Gathering Script V.7.5.AMZ2019080601 -->
<script language='javascript'>
 var _AceGID=(function(){var Inf=['gtp15.acecounter.com','8080','AH5A43502777054','AW','0','NaPm,Ncisy','ALL','0']; var _CI=(!_AceGID)?[]:_AceGID.val;var _N=0;var _T=new Image(0,0);if(_CI.join('.').indexOf(Inf[3])<0){ _T.src =( location.protocol=="https:"?"https://"+Inf[0]:"http://"+Inf[0]+":"+Inf[1]) +'/?cookie'; _CI.push(Inf);  _N=_CI.length; } return {o: _N,val:_CI}; })();
 var _AceCounter=(function(){var G=_AceGID;var _sc=document.createElement('script');var _sm=document.getElementsByTagName('script')[0];if(G.o!=0){var _A=G.val[G.o-1];var _G=(_A[0]).substr(0,_A[0].indexOf('.'));var _C=(_A[7]!='0')?(_A[2]):_A[3];var _U=(_A[5]).replace(/\,/g,'_');_sc.src=(location.protocol.indexOf('http')==0?location.protocol:'http:')+'//cr.acecounter.com/Web/AceCounter_'+_C+'.js?gc='+_A[2]+'&py='+_A[4]+'&gd='+_G+'&gp='+_A[1]+'&up='+_U+'&rd='+(new Date().getTime());_sm.parentNode.insertBefore(_sc,_sm);return _sc.src;}})();
</script>
<noscript><img src='http://gtp15.acecounter.com:8080/?uid=AH5A43502777054&je=n&' border='0' width='0' height='0' alt=''></noscript>
<!-- AceCounter Log Gathering Script End -->
</body>
</html>
