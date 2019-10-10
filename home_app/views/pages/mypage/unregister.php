<div class="section-full">
	<div class="section_wrapper">
		<?=$mypage_nav?>
		<h3 class="sec-title">회원탈퇴<span class="bgline"></span></h3>
		<div class="home-login-sec block-section">
			<p class="marginB20 color_c92828">회원 탈퇴를 위한  입력페이지입니다.<br />
				패스워드를 입력하시면 회원 탈퇴가 정상적으로 진행됩니다.<br />
				탈퇴한 회원정보는 복구할 수 없으며, 탈퇴한 아이디로는 재가입이 불가능하오니<br />
				신중히 선택해주시기 바랍니다.</p>
			<?php echo form_open(site_url().'mypage/unregister_exec', 'id="unregister-frm"'); ?>
			<fieldset>
				<ul class="medi-frm-typeA block-content">
				<li>
					<div class="label-sec">
						<span class="label-txt">아이디</span>
					</div>
					<div class="box-sec"><?=$user_id?></div>
				</li>
				<li class="last">
					<label for="password" class="label-sec">
						<span class="blind">필수입력</span><span class="label-txt">비밀번호</span>
					</label>
					<div class="input-sec">
						<input type="password" name="password" id="password" required="required" />
					</div>
				</li>
				</ul>
				<div class="submit-sec marginB20">
					<input type="submit" value="회원탈퇴" class="form-btn-default">
				</div>
			</fieldset>
			</form>
		</div>
	</div>
</div>
<script>
	getIds('unregister-frm').onsubmit = function(){
		var lastcheck = confirm('정말 회원 탈퇴를 하시겠습니까?\n탈퇴한 회원정보는 복구할 수 없으므로 신중히 선택하여주세요.\n확인을 누르시면 탈퇴가 완료됩니다.');
		if(!lastcheck){return false}
		if(getIds('password').value == ''){
			alert('탈퇴를 하시려면 비밀번호를 입력해 주세요.')
			return false;
		}
	}
</script>