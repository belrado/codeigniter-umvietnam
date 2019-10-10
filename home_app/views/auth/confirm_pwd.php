<div class="section-full">
	<div class="section_wrapper">
		<div class="confirm-sec default-frm">
			<h1 class="title"><?=$title?></h1>
			<?php echo form_open($frmlink, 'class="BD-check-form"'); ?>
			<fieldset>
				<div class="block">
					<label for="password" class="label">비밀번호</label>
					<div class="input-sec"><input type="password" name="password" id="password" required="required" /></div>
					<?php echo form_error('password'); ?>
				</div>
				<div class="block">
					<label for="passconf" class="label">비밀번호확인</label>
					<div class="input-sec"><input type="password" name="passconf" id="passconf" required="required" /></div>
				</div>
				<div class="block">
					<label for="captcha" class="label">캡차코드</label>
					<div class="input-sec"><?=$captcha?></div>
					<div class="input-sec">
						<input type="text" name="captcha" id="captcha" required="required" />
					</div>
				</div>
				<div class="sumbit-sec">
					<input type="submit" value="확인" />
					<a href="<?=site_url()?>">메인으로 돌아가기</a>
				</div>
			</fieldset>
			</form>
		</div>
	</div>
</div>