<div class="section-full">
	<div class="section_wrapper">
		<h4 class="content-tit-leftline">
			UMVietnam account
		</h4>
		<?=form_open(site_url().$umv_lang."/auth/joinus", 'class="BD-check-form"'); ?>
			<input type="hidden" name="user_sns_type" value="home" />
			<input type="hidden" name="lang" value="<?=$umv_lang?>" />
			<p class="marginB10">
				* <?=stripslashes($lang_bbs['required'])?>
			</p>
			<div class="home-form support-register-form  block-section">
				<div class="form-row">
					<label class="label" for="user_id">
						<span class="blind"><?=stripslashes($lang_bbs['required'])?></span>
						* Email (ID)
					</label>
					<div class="input-sec">
						<div class="input-box">
							<input type="text" name="user_id" value="<?=set_value('user_id')?>" id="user_id" class="mailCheck checkInput" placeholder="email@domain.com" data-label-name="Email" required="required" />
						</div>
						<p class="sms-info">
							<?=stripslashes($lang_log['email_send_verification'])?>
						</p>
					</div>
					<?=form_error('user_id', '<div class="input-error">* '.stripslashes($lang_message['email_error_msg2']), '</div>')?>
				</div>
				<div class="form-row">
					<label class="label" for="password">
						<span class="blind"><?=stripslashes($lang_bbs['required'])?></span>
						* Password
					</label>
					<div class="input-sec">
						<div class="input-box">
							<input type="password" name="user_pwd" id="password" class="pwdLength checkInput" placeholder="<?=stripslashes($lang_log['password_sp_str'])?>" data-label-name="Password" autocomplete="new-password" required="required" />
						</div>
					</div>
					<?=form_error('password', '<div class="input-error">* ', '</div>')?>
				</div>
				<div class="form-row">
					<label class="label" for="user_pwdc"><span class="blind"><?=stripslashes($lang_bbs['required'])?></span>* Password confirm</label>
					<div class="input-sec">
						<div class="input-box">
							<input type="password" name="user_pwdc" id="user_pwdc" class="passconf checkInput" placeholder="Password confirm" data-label-name="Password confirm" autocomplete="new-password" required="required" />
						</div>
					</div>
					<?=form_error('user_pwdc', '<div class="input-error">* ', '</div>')?>
				</div>
				<div class="form-row">
					<label class="label" for="user_name"><span class="blind"><?=stripslashes($lang_bbs['required'])?></span>* Name</label>
					<div class="input-sec">
						<div class="input-box">
							<input type="text" name="user_name" value="<?=set_value('user_name')?>" id="user_name" class="checkInput" placeholder="Your Name" data-label-name="Name" required="required" />
						</div>
					</div>
					<?=form_error('user_name', '<div class="input-error">* ', '</div>')?>
				</div>
				<div class="form-row multiple-sec-row last">
					<label class="label" for="captcha"><span class="blind"><?=stripslashes($lang_bbs['required'])?></span>* Security Code</label>
					<div class="input-sec">
						<?=$captcha?>
					</div>
					<div class="input-sec last">
						<div class="input-box">
							<input type="text" name="captcha" id="captcha" class="checkInput" placeholder="<?=stripslashes($lang_log['security_image_text'])?>" required="required" />
						</div>
					</div>
					<?=form_error('captcha', '<div class="input-error">* 캡차코드를 정확히 입력해 주세요.<br />', '</div>')?>
				</div>
			</div>
			<div class="home-form">
				<div class="agreement-box">
					<?=(str_replace('\r\n', PHP_EOL, stripslashes($agreement->opt_value)))?>
				</div>
				<?=form_error('agreement', '<div class="input-error full-error">* ', '</div>')?>
				<p class="block-content agreement-sec">
					<label class="agreement">
						<input type="checkbox" name="agreement" value="agree" id="join_agree" class="checkboxCheck" />
						<?=stripslashes($lang_menu['agree_privacy_policy'])?>
					</label>
				</p>
			</div>
			<div class="home-form-submit-sec">
				<input type="submit" value="<?=stripslashes(ucfirst($lang_menu['register']))?>" class="submit-btn" id="register-submit" />
				<input type="reset" value="<?=stripslashes(ucfirst($lang_bbs['cancel']))?>" class="btn-boder-rect" />
			</div>
		</form>
	</div>
</div>
<script>
	$(document).ready(function(){
		$('.input-box input[type="text"]').each(function(){
			if($(this).val()){
				$(this).addClass('is_focus');
			}
		});
		$('.input-box input[type="text"]').on({
			blur:function(){
				if(!$(this).val()){
					$(this).removeClass('is_focus');
				}else{
					if(!$(this).hasClass('is_focus')){
						$(this).addClass('is_focus');
					}
				}
			}
		});
	});
</script>
