<div class="page-title-sec">
	<h2 class="page-title"><?=$title?></h2>
</div>
<div class="admin-page-sec">
	<nav>
		<ul class="member-select">
			<li><a href="<?=site_url()?>homeAdm/members/all" <?php if($sub_title == 'all') echo "class='active'"; ?>>전체목록</a></li>
			<li><a href="<?=site_url()?>homeAdm/members/mp_master" <?php if($sub_title == 'mp_master') echo "class='active'"; ?>>홈페이지 관리자</a></li>
			<li><a href="<?=site_url()?>homeAdm/members/mp_user" <?php if($sub_title == 'mp_user') echo "class='active'"; ?>>일반회원</a></li>
			<li><a href="<?=site_url()?>homeAdm/members/membership" <?php if($sub_title == 'membership') echo "class='active'"; ?>>멤버십</a></li>
		</ul>
	</nav>
	<section>
		<h3 class="sub-title"><?=$sub_title?></h3>
		<?=form_open(site_url().'homeAdm/members/delete/')?>
		<ul class="member-list">
		<?php if(!$members_list) : ?>
			<li>등록된 관리자 또는 회원이 없습니다.</li>
		<?php else : ?>
			<?php foreach($members_list as $val) : ?>
			<li>
			<?php if($check_adm_lv==10): ?>
				<div><label><input type="checkbox" name="delete_no[]" value="<?=$val->user_no?>" /> 선택</label></div>
				<a href="<?=site_url()?>homeAdm/members/view/<?=$val->user_no?>">
			<?php endif ?>
				<div class="user-sec">
					<h4 class="user-name">
						<?php if($val->unregister == 'yes') : ?>
						<strong>[탈퇴신청 회원]</strong>
						<?php endif ?>
						<?php if($val->mail_approve == 'no') : ?>
						<strong>[메일인증 안함]</strong>
						<?php endif ?>
						<?=$val->user_name?> [lv.<?=$val->user_level?> <?=explode("_", $val->user_type)[1]?>]</h4>
					<p class="user-info"><strong>ID</strong> : <?=$val->user_id?><span class="line">|</span></p>
					<p class="user-info"><strong>E-mail</strong> : <?=$val->user_email?><span class="line">|</span></p>
					<p class="user-info"><strong>Nick</strong> : <?=$val->user_nick?><span class="line">|</span></p>
					<p class="user-info"><strong>Phone</strong> : <?=$val->user_phone?></p>
				</div>
			<?php if($this->super_check): ?>
				</a>
			<?php endif ?>
			</li>
			<?php endforeach ?>
		<?php endif ?>
		</ul>
		<?php if($members_list && $check_adm_lv == 10) : ?>
		<div class="admin-btn-sec2">
			<input type="submit" value="선택 멤버 삭제" class="admin-btn">
		</div>
		<?php endif ?>
		</form>
	</section>
</div>
