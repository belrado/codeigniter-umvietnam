<div class="section-full">
	<div class="section_wrapper">
		<?=$mypage_nav?>
		<h4 class="blind">
			&ldquo;<?=fnc_set_htmls_strip($user_info[0]->user_name)?>&rdquo; <?=stripslashes($lang_bbs['user_information'])?>
		</h4>
		<ul class="tabledl-list2 block-section mypage-box">
		<li>
			<div class="title">
				<strong class="name">
					<?=stripslashes($lang_menu['name'])?>
				</strong>
			</div>
			<p class="content only">
				<?=fnc_set_htmls_strip($user_info[0]->user_name)?>
			</p>
		</li>
		<li>
			<div class="title">
				<strong class="name">
					<?=stripslashes($lang_menu['email'])?>
				</strong>
			</div>
			<p class="content only">
				<?=fnc_set_htmls_strip($user_info[0]->user_email)?>
			</p>
		</li>
		<li>
			<div class="title">
				<strong class="name">
					Membership
				</strong>
			</div>
			<div class="content only">
				<?=form_open(site_url().$umv_lang.'/mypage/unregister_sns_exec', 'class="cancel-membership-sec"')?>
					<input type="hidden" name="user_sns_type" value="<?=$user_info[0]->user_sns_type?>" />
					<input type="hidden" name="unregister" value="unregister" />
					<p class="blind">
						UMVietnam, <?=stripslashes($lang_menu['cancel_membership'])?>
					</p>
					<input type="submit" value="<?=stripslashes($lang_menu['cancel_membership'])?>" class="cancel-membership-btn" />
				</form>
				<p class="cancel-membership-text">
					<?php /*
						삭제 버튼 클릭시 삭제된 유저 보관 테이블로 전송
						관리자에 삭제회원 관리 버튼을 만들어서 클릭 시 14일 경과 됬는지 확인해서 user테이블에서 삭제
						로그인시 아이디(메일)이 있다면 해지날짜와 해당일을 비교해 14일이 지났는지 확인
						지났다면 덮어쓰면서 가입 & 삭제된 유저 보관테이블에서 삭제
						안지났다면 거부
					*/ ?>
					<?=stripslashes($lang_member['delete_msg'])?>
				</p>
			</div>
		</li>
		</ul>
		<?php /*

		<?php if($my_presentation) : ?>
		<h4 class="sec-title">설명회 예약</h4>
		<p class="marginB10">※ 설명회 하루전, 당일엔 홈페이지에서 예약취소가 불가능 합니다. 고객센터 : 02)540-2510</p>
		<ul class="my-presentation-list">
		<?php foreach($my_presentation as $val) :
			$p_date = explode(' ',$val->p_day);
			$nowDate = strtotime(date('Y-m-d h:i:s', time()));
			$p_status = ($nowDate < strtotime($p_date[0].'+'.'-1'.' days'))?true:false;
		?>
			<li>
			<?php if($p_status) : ?>
				<?=form_open(site_url().'mypage')?>
				<input type="hidden" value="<?=$val->u_id?>" name="u_id" />
			<?php endif ?>
				<strong class="p-tit"><?=$val->p_name?></strong>
				<p class="p-content">
					[<?=fnc_set_htmls_strip($val->p_location)?>]
					<?=fnc_set_htmls_strip($val->p_address)?>
					<?=fnc_set_htmls_strip($val->p_place)?></p>
					<?=$val->u_register?>
				<p class="p-date">
					<?=fnc_replace_getday($p_date[0])?> <?=fnc_replace_gettime($p_date[1])?>
				</p>
			<?php if($p_status) : ?>
				<input type="submit" value="예약취소" class="p-cancel" />
				</form>
			<?php endif ?>
			</li>
		<?php endforeach ?>
		</ul>
		<?php endif ?>

		*/ ?>
	</div>
</div>
<script>
$('.cancel-membership-sec').submit(function(){
	if(!confirm('<?=stripslashes($lang_member['delete_msg'])?>\n<?=stripslashes($lang_member['delete_sure'])?>')){
		return false;
	}
});
</script>
