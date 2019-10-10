<div class="section-full">
	<div class="section_wrapper">
		<h3 class="sec-title">비밀번호입력<span class="bgline"></span></h3>
		<div class="home-login-sec">
			<?php echo form_open($frmlink, 'class="BD-check-form"'); ?>
			<fieldset>
				<ul class="medi-frm-typeA block-content">
				<li>
					<label for="password" class="label-sec">
						<span class="blind">필수입력</span><span class="label-txt">* 비밀번호</span>
					</label>
					<div class="input-sec">
						<input type="password" name="password" id="password" class="checkInput" required="required" />
					</div>
				</li>
				<li>
					<label for="passconf" class="label-sec">
						<span class="blind">필수입력</span><span class="label-txt">* 비밀번호 확인</span>
					</label>
					<div class="input-sec">
						<input type="password" name="passconf" id="passconf" class="checkInput passconf" required="required" />
					</div>
				</li>
				<li class="last">
					<label for="captcha" class="label-sec captcha-sec">
						<span class="blind">필수입력</span>
						<span class="label-txt">
							<?=$captcha?>
						</span>
					</label>
					<div class="input-sec">
						<input type="text" name="captcha" id="captcha" class="checkInput" required="required" />
					</div>
				</li>
				</ul>
				<div class="submit-sec marginB20">
					<input type="submit" value="확인" class="form-btn-default">
					<a href="<?=site_url()?>mypage/" class="form-btn-default">마이페이지</a>
				</div>
			</fieldset>
			</form>
		</div>
	</div>
</div>