<div class="section-full section-line">
	<div class="section_wrapper">
		<?=$mypage_nav?>
		<h4 class="mypage-title mypage-scrap-title">
			<span class="tit-name">&ldquo;<?=fnc_set_htmls_strip($user_info[0]->user_name)?>&rdquo;</span> 님의 회원정보 수정
		</h4>
		<?=form_open(site_url().'mypage/modify_exec', 'class="BD-check-form"')?>
		<input type="hidden" name="type" value="info_modify" />
			<ul class="mypage-box tabledl-list block-content">
			<li>
				<div class="inner-box">
					<strong class="title">회원 아이디</strong>
					<?php if($this->session->userdata('user_sns_type') === 'home') : ?>
					<p class="content only"><?=fnc_set_htmls_strip($user_info[0]->user_id)?></p>
					<?php else : ?>
					<p class="content only"><?=$this->session->userdata('user_sns_type')?> 회원가입</p>	
					<?php endif ?>
				</div>
			</li>
			<li>
				<div class="inner-box">
					<strong class="title">회원 이름</strong>
					<p class="content only"><?=fnc_set_htmls_strip($user_info[0]->user_name)?></p>
				</div>
			</li>
			<?php if($this->session->userdata('user_sns_type') !== 'home') : ?>
			<li>
				<div class="inner-box">
					<label for="user_email" class="title">* 이메일</label>
					<p class="content input-sec only">
						<input type="text" value="<?=fnc_set_htmls_strip($user_info[0]->user_email)?>" name="user_email" id="user_email" class="checkInput mailCheck hanCheck" />
					</p>
				</div>
			</li>	
			<?php endif ?>
			<li>
				<div class="inner-box">
					<label for="user_phone" class="title">* 전화번호</label>
					<p class="content input-sec only">
						<input type="text" value="<?=fnc_set_htmls_strip($user_info[0]->user_phone)?>" name="user_phone" id="user_phone" class="checkInput phoneNumCheck" placeholder="010-0000-0000" />
					</p>
				</div>
			</li>
			<li>
				<div class="inner-box">
					<label for="user_birth" class="title">* 학생 학력</label>
					<div class="content input-sec only">
						<div class="user-grade-sec">
							<div class="user-state">
								<label><input type="radio" value="korea" name="user_state" <?=($user_info[0]->user_state==='korea')?'checked="checked"':''?> /> 국내</label>
								<label><input type="radio" value="global" name="user_state" <?=($user_info[0]->user_state==='global')?'checked="checked"':''?> /> 해외</label>
							</div>
							<select name="user_grade" id="user_grade" class="checkInput" data-label-name="학생 학력">
								<option value="7~8 학년" <?=(fnc_none_spacae($user_info[0]->user_grade)==='7~8학년')?'selected="selected"':''?>>국내 7~8 학년</option>
								<option value="현재 9학년" <?=(fnc_none_spacae($user_info[0]->user_grade)==='현재9학년')?'selected="selected"':''?>>국내 현재 9학년</option>
								<option value="현재 10학년" <?=(fnc_none_spacae($user_info[0]->user_grade)==='현재10학년')?'selected="selected"':''?>>국내 현재 10학년</option>
								<option value="현재 11학년" <?=(fnc_none_spacae($user_info[0]->user_grade)==='현재11학년')?'selected="selected"':''?>>국내 현재 11학년</option>
								<option value="현재 12학년" <?=(fnc_none_spacae($user_info[0]->user_grade)==='현재12학년')?'selected="selected"':''?>>국내 현재 12학년</option>
								<option value="기타" <?=(fnc_none_spacae($user_info[0]->user_grade)==='기타')?'selected="selected"':''?>>기타</option>
							</select>
						</div>
					</div>
				</div>
			</li>
			</ul>
			<div class="submit-sec">
				<input type="submit" value="회원정보 변경" class="form-btn-default">
			</div>
		</form>	
	</div>
</div>
<?php if($this->session->userdata('user_sns_type') === 'home') : ?>
<div class="section-full">
	<div class="section_wrapper">
		<h3 class="sec-title">비밀번호 변경<span class="bgline"></span></h3>
		<?=form_open(site_url().'mypage/modify_exec', 'class="BD-check-form"')?>
		<p class="required-txt">*비밀번호는 8~18 영문 숫자 특수문자 <strong>!@#$%^&+=_</strong> 조합으로 작성해 주세요.</p>
		<input type="hidden" name="type" value="pwd_modify" />
			<ul class="tabledl-list block-content">
			<li>
				<div class="inner-box">
					<label for="password" class="title">* 바꾸실 비밀번호</label>
					<p class="content input-sec only">
						<input type="password" name="password" id="password" class="pwdLength checkInput" />
					</p>
				</div>
			</li>
			<li>
				<div class="inner-box">
					<label for="passconf" class="title">* 바꾸실 비밀번호 확인</label>
					<p class="content input-sec only">
						<input type="password" name="passconf" id="passconf" class="checkInput passconf" />
					</p>
				</div>
			</li>
			</ul>
			<div class="submit-sec">
				<input type="submit" value="비밀번호 변경" class="form-btn-default">
			</div>
		</form>
	</div>
</div>
<?php else : ?>
<div class="section-full">
	<div class="section_wrapper">
		<h3 class="sec-title">회원탈퇴<span class="bgline"></span></h3>
		<div class="home-login-sec block-section">
			<?=form_open(site_url().'mypage/unregister_sns_exec', 'id="sns_unregister_frm"')?>
			<input type="hidden" name="user_sns_type" value="<?=$user_info[0]->user_sns_type?>" />
				<p class="marginB20 color_c92828">
				회원탈퇴 버튼을 누르시면 회원 탈퇴가 정상적으로 진행됩니다.<br />
				탈퇴한 회원정보는 복구할 수 없으며, 탈퇴한 아이디로는 재가입이 불가능하오니<br />
				신중히 선택해 주시기 바랍니다.</p>
				<div class="submit-sec">
					<input type="submit" value="회원탈퇴" class="form-btn-default">
				</div>
			</form>
		</div>
	</div>
</div>	
<?php endif ?>
<script>
// 최종학력 선택
var obj_u_aca_option = {
	opt_replace:function(elem, regexp, change){
		elem.each(function(index){
			if(index > 0){
				var aca_value = $(this).text().replace(regexp, change);
				$(this).text(aca_value);
			}else{
				var aca_value = $(this).text().replace(regexp, change);
			}
			$(this).text(aca_value);
		});
	},
	set_aca_opt:function(){
		if($('.user-state input[type="radio"]:checked').val() === 'korea'){
			this.opt_replace($('#user_grade option'), /^해외 /gi, '국내 ');
		}else{
			this.opt_replace($('#user_grade option'), /^국내 /gi, '해외 ');
		}
	},
	init:function(){
		this.set_aca_opt();
		var _this = this;
		$('.user-state input[type="radio"]').on({
			change:function(){
				_this.set_aca_opt();
			}
		});
	}
};
obj_u_aca_option.init();
getIds('sns_unregister_frm').onsubmit = function(){
	if(!confirm('탈퇴한 회원정보는 복구할 수 없으며,\n탈퇴한 아이디로는 재가입이 불가능합니다.\n정말 PSU회원 탈퇴를 하시겠습니까?')){
		return false
	}
};
</script>