<div class="section-full">
	<div class="section_wrapper">
		<?=form_open(site_url().$umv_lang."/auth/joinus", 'class="BD-check-form"'); ?>
			<input type="hidden" name="lang" value="<?=$umv_lang?>" />
			<input type="hidden" name="user_sns_type" value="<?=$sns_type?>" />
			<input type="hidden" name="user_sns_id" value="<?=$sns_id?>" />
			<input type="hidden" name="sns_name" value="<?=$sns_name?>" />
			<input type="hidden" name="sns_email" value="<?=$sns_email?>" />
			<input type="hidden" name="user_sns_token" value="<?=$sns_token?>" />
			<input type="hidden" name="user_id" value="<?=$sns_id?>@<?=$sns_type?>.com" />
			<h4 class="content-tit-leftline">
				<?=ucfirst($sns_type)?> account
			</h4>
			<p class="marginB10">* <?=stripslashes($lang_bbs['required'])?></p>
			<div class="home-form support-register-form  block-section">
				<div class="form-row">
					<label class="label" for="user_email"><span class="blind"><?=$lang_bbs['required']?></span>* <?=$lang_menu['email']?></label>
					<div class="input-sec">
						<div class="input-box">
							<input type="text" name="user_email" value="<?=$sns_email?>" id="user_email" class="mailCheck checkInput" placeholder="email@domain.com" data-label-name="<?=$lang_menu['email']?>" />
						</div>
						<p class="sms-info">
							<?=stripslashes($lang_log['email_send_verification'])?>
						</p>
					</div>
					<?=form_error('user_email', '<div class="input-error">* '.stripslashes($lang_message['email_error_msg2']), '</div>')?>
				</div>
				<div class="form-row">
					<label class="label" for="user_name"><span class="blind"><?=$lang_bbs['required']?></span>* <?=$lang_menu['name']?></label>
					<div class="input-sec">
						<div class="input-box readonly-box">
							<input type="text" name="user_name" value="<?=$sns_name?>" id="user_name" class="checkInput" readonly="readonly" data-label-name="<?=$lang_menu['name']?>" required="required" />
						</div>
					</div>
					<?=form_error('user_name', '<div class="input-error">* ', '</div>')?>
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
