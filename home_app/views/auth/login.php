<div class="section-full">
	<div class="section_wrapper">
		<div class="signin-form">
			<?=form_open(site_url().$umv_lang.'/auth/login/?returnURL='.$returnURL, 'class="home-signin BD-check-form" id="leveltest-signin"')?>
			<input type="hidden" name="mp_token" value="<?=$mp_token?>" />
			<p class="input-box">
				<label for="userid"><span class="blind"><?=$lang_bbs['required']?></span><?=$lang_menu['user_id']?></label>
				<input type="text" name="userid" id="userid" required="required" />
			</p>
			<p class="input-box">
				<label for="password"><span class="blind"><?=$lang_bbs['required']?></span><?=$lang_menu['passwd']?></label>
				<input type="password" name="password" id="password" required="required" autocomplete="new-password" />
			</p>
			<div class="submit-btn-sec"><input type="submit" value="<?=$lang_menu['login']?>" class="submit-btn" /></div>
			</form>
			<div class="sns-login-sec">
				<div>
					<a href="<?=site_url()?><?=$umv_lang?>/auth/joinus" class="login-umvietnam">JoinUs</a>
				</div>
				<div>
					<a
					href='https://www.facebook.com/v3.3/dialog/oauth?client_id=<?=$facebook?>&redirect_uri=<?=$redirect?>&state={<?=$token?>,<?=$umv_lang?>,<?=$returnURL?>}&scope=email&auth_type=rerequest&scope=email' 
					class="login-facebook">Facebook</a>
				</div>
			</div>
		</div>

	</div>
</div>
<script>
(function(){
	var check_input_value = {
		init:function(){
			if(arguments.length>0){
				for(var i in arguments){
					if(arguments[i].hasOwnProperty('currentTarget')){
						check_input_value.label_active($(this));
					}else{
						check_input_value.label_active(arguments[i])
					}
				}
			}
		},
		label_active:function(elem){
			if(!elem) return false;
			if($.trim(elem.val())  === ''){
				elem.prev('label').removeClass('in_focus');
			}else{
				elem.prev('label').addClass('in_focus');
			}
		}
	};
	check_input_value.init($('input[type="text"]'), $('input[type="password"]'));
	$('input[type="text"], input[type="password"]').on({
		focusin:function(){
			$(this).prev('label').addClass('in_focus');
		},
		focusout:check_input_value.init
	});
})();
</script>
