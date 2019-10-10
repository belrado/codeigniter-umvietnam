<ul class="page-tabbtn-sec block-content">
<?php if($this->session->userdata('user_level') < 7) : ?>
	<li class="tabbtn">
		<a href="<?=site_url()?><?=$umv_lang?>/mypage/" <?php if($active_method == 'index') echo 'class="active"';?>>
			<?=stripslashes($lang_bbs['user_information'])?>
		</a>
	</li>
<?php endif ?>
	<li class="tabbtn">
		<a href="<?=site_url()?><?=$umv_lang?>/mypage/scrap" <?php if($active_method == 'scrap') echo 'class="active"';?>>
			<?=stripslashes($lang_menu['scrap'])?>
		</a>
	</li>
 	<li class="tabbtn">
		<a href="<?=site_url()?><?=$umv_lang?>/mypage/board/qna/1" <?php if($active_method == 'board') echo 'class="active"';?>>
			<?=stripslashes($lang_bbs['my_posts'])?>
		</a>
	</li>
<?php if($this->session->userdata('user_level') >= 3) : ?>
	<li class="tabbtn">
		<a href="<?=site_url()?><?=$umv_lang?>/mypage/myqna" <?php if($active_method == 'myqna') echo 'class="active"';?>>
			<?=stripslashes($lang_member['qna'])?>
		</a>
	</li>
<?php endif ?>
<?php if($this->session->userdata('user_level') < 7) : ?>
	<?php if($user_info[0]->user_sns_type === 'home') : ?>
	<li class="tabbtn">
		<a href="<?=site_url()?><?=$umv_lang?>/mypage/unregister" <?php if($active_method == 'unregister') echo 'class="active"';?>>회원탈퇴</a>
	</li>
	<?php endif ?>
<?php endif ?>
</ul>
