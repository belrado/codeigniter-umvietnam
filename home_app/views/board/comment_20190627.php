<?php
/*
 * 비회원 댓글달기 기능을 사용안하기로 해서 작업중단.. 해당기능 활성화 하려면 추가로 개발 들어가야함
 *
 * bbs_is_comment 	  : 댓글의 뎁스, 0 게시글, 1 댓글, 2 댓글의댓글 ....
 * bbs_parent		  : 댓글이 어떤 게시글의 댓글인지, 0 (게시글) or 게시글 아이디값(bbs_id) 을 가진다
 * bbs_comment		  : 해당글의 댓글이 몇개가 있는지 게시글은 1뎁스댓글이 몇개인지 , 댓글은 댓글의댓글이 몇개인지
 * bbs_comment_parent : 댓글의 댓글일 경우 상위 댓글의 아이디값(bbs_id), 0 (게시글 또는 1뎁스댓글)
 *
 */
?>
<div class="">
	<div class="comment-sec" id="comment-sec" data-comment-limit="<?=$comment_limit?>">
		<div id="comment-input-box">
			<?php if(($bbs_comment_lv > 0 && $user_lv > 1) || $bbs_comment_lv == 1) : ?>
			<form action='<?=site_url()?>board/bbs_comment/' method='post' class='BD-check-form comment-register'>
				<input type="hidden" name='<?=$this->security->get_csrf_token_name()?>' value='<?=$this->security->get_csrf_hash()?>' class='csrf_token_home' />
				<!-- // 어느 게시글의 댓글인지 알기위해 게시글의  테이블과 아이디를 삽입한다. -->
				<input type="hidden" name="bbs_table" value="<?=$bbs_table?>" />
				<input type="hidden" name="bbs_id" value="<?=$bbs_result[0]->bbs_id?>" />
				<input type="hidden" name="bbs_num" value="<?=$bbs_result[0]->bbs_num?>" />
				<!-- // 댓글다는 살마의 아이디  비회원이면 nonmember로 저장 // -->
				<input type="hidden" name="user_id" value="<?=$user_id?>" />
				<?php if(!$nonmember_comment && $user_lv >= 2) : ?>
				<input type="hidden" name="user_name" value="<?=$this->session->userdata('user_name')?>" class="checkInput" />
				<?php else : ?>
				<div class="nonmember-sec">
					<div class="input-box">
						<label>이름</label>
						<input type="text" name="user_name" class="checkInput nonmember_namec" required="required" />
					</div>
					<div class="input-box">
						<label>비밀번호</label>
						<input type="password" name="bbs_pwd" class="checkInput" required="required" autocomplete="new-password" />
					</div>
				</div>
				<?php endif ?>
				<div class="comment-textarea">
					<textarea name="bbs_content" class="cbbs_content checkInput check-comment-auth" <?=$c_readonly?> onkeyup="check_content_byte(this, 400, 'limit-txtlength');"><?=$c_comment_txt?></textarea>
					<strong class="blind">글자 수 제한</strong>
					<span class="limit-txtlength">0/400</span>
				</div>
				<div class="comment-submit">
					<!-- // 댓글입력 // -->
					<?php if($user_lv >= $bbs_comment_lv || $bbs_comment_lv == 1) : ?>
					<input type="submit" value="<?=stripslashes($lang_bbs['insert_cmt'])?>" class="submit-btn" />
					<?php else : ?>
					<div class="submit-btn">
						<span><?=stripslashes($lang_bbs['insert_cmt'])?></span>
					</div>
					<?php endif ?>
				</div>
			</form>
			<?php else : ?>
				<input type="hidden" name='<?=$this->security->get_csrf_token_name()?>' value='<?=$this->security->get_csrf_hash()?>' class='csrf_token_home' />
			<?php endif ?>
		</div>
		<?php if($comment_list) : ?>
		<ul class="comment-list" id="comment-list-1depth">
			<?php foreach($comment_list as $val) : ?>
			<?php if($val->bbs_parent == $bbs_result[0]->bbs_id) : ?>
			<li>
				<div class="comment-box marginB10">
					<article>
						<header>
							<div class="cb-header">
								<?=fnc_set_htmls_strip($val->user_name)?>
								<?php if(fnc_set_htmls_strip($val->user_id) === 'nonmember' || $val->unregister == 'yes') : ?>
									<sup class="nuser">[비회원]</sup>
								<?php else : ?>
									<?php if($val->user_level > 1 && $val->user_level < 7) : ?>
									<sup class="user">[<?=fnc_name_change(preg_replace('/@.+$/', '', fnc_set_htmls_strip($val->user_email)), 3, '*')?>]</sup>
									<?php elseif($val->user_level >= 7) : ?>
									<sup class="suser">[<?=fnc_set_htmls_strip($val->user_nick)?>]</sup>
									<?php endif ?>
								<?php endif ?>
							</div>
						</header>
						<div class="cb-content"><?=nl2br(fnc_set_htmls_strip($val->bbs_content))?></div>
						<footer>
							<div class="cb-footer"><?=set_view_register_time($val->bbs_register, 0, 16)?></div>
						</footer>
					</article>
					<div class="btn-del-sec">
					<?php if($val->user_id === $this->encryption->decrypt($user_id)) : ?>
						<?php if($val->user_id === 'nonmember') : ?>
						<a href="javascript:;">비회원삭제</a>
						<?php else : ?>
						<a href="javascript:;" class="btn-comment-del"
							data-bbs-table="<?=$bbs_table?>"
							data-bbs-id="<?=$val->bbs_id?>"
							data-bbs-iscomment="<?=$val->bbs_is_comment?>"
							data-bbs-parent="<?=$val->bbs_parent?>"
							data-bbs-commentparent="<?=$val->bbs_comment_parent?>"><?=stripslashes($lang_bbs['delete'])?></a>
						<?php endif ?>
					<?php endif ?>
					<?php if($user_lv >= 9) : ?>
						<?php if($val->user_id === $this->encryption->decrypt($user_id)) :?>|<?php endif ?>
						<a href="javascript:;" class="btn-comment-del"
							data-bbs-table="<?=$bbs_table?>"
							data-bbs-id="<?=$val->bbs_id?>"
							data-bbs-iscomment="<?=$val->bbs_is_comment?>"
							data-bbs-parent="<?=$val->bbs_parent?>"
							data-bbs-commentparent="<?=$val->bbs_comment_parent?>"
							data-comment-deltype="super"><?=stripslashes($lang_bbs['delete_as_adm'])?></a>
					<?php endif ?>
					</div>
				</div>
				<div class="comment-box2">
					<a href="javascript:;" class="comment-reply-view"
						data-bbs-table="<?=$bbs_table?>"
						data-bbs-id="<?=$val->bbs_id?>"
						data-bbs-iscomment="2"
						data-bbs-parent="<?=$val->bbs_parent?>"
						data-bbs-commentparent="<?=$val->bbs_id?>"><?=stripslashes($lang_bbs['cmt_under_cmt'])?> <?=$val->bbs_comment?></a>
					<div class="comment-reply-list">
						<div class="comment-reply-refresh-sec">
							<a href="<?=site_url().uri_string()?>" class="comment-reply-refresh ico-refresh"
								data-bbs-table="<?=$bbs_table?>"
								data-bbs-id="<?=$bbs_result[0]->bbs_id?>"
								data-bbs-parent="<?=$bbs_result[0]->bbs_id?>"
								data-bbs-commentparent="<?=$val->bbs_id?>"><?=stripslashes($lang_bbs['refresh'])?></a>
						</div>
						<ul class="comment-list">
						</ul>
					</div>
				</div>
			</li>
			<?php endif ?>
			<?php endforeach ?>
		</ul>
		<?php if($comment_total > $comment_limit) : ?>
		<div class="comment-more-sec">
			<a href="javascript:;" class="comment-more-1depth"
				data-bbs-table="<?=$bbs_table?>"
				data-bbs-id="<?=$bbs_result[0]->bbs_id?>"
				data-bbs-iscomment="1"
				data-bbs-parent="<?=$bbs_result[0]->bbs_id?>"
				data-bbs-commentparent="0"><?=stripslashes($lang_menu['read_more'])?></a>
		</div>
		<?php endif ?>
		<?php endif ?>
	</div>
</div>
<script>
var banned_word = '<?=get_banned_word();?>';
var banned_name = '<?=get_banned_name();?>';
<?php if($bbs_comment_lv > 1 && $user_lv < $bbs_comment_lv) : ?>
	var error_msg = {};
	var check_comment_write_auth = function(e){
		if(e.data.link){
			if(confirm(e.data.msg)){
				document.location.href=e.data.link;
			}
		}else{
			alert(e.data.msg);
		}
	}
	<?php if($user_lv < 1 || !$user_lv) : ?>
		error_msg = {msg:'<?=stripslashes($lang_message['requires_login_msg'])?>\n<?=stripslashes($lang_message['move_login_page'])?>', link:'<?=site_url()?><?=$umv_lang?>/auth/'};
	<?php else : ?>
		error_msg = {msg:'<?=stripslashes($lang_message['permission_comments_msg'])?>', link:''};
	<?php endif ?>
	$('.comment-register').on('click', error_msg, check_comment_write_auth);
	$('.comment-register').on('submit', function(){
		return false;
	});
<?php else : ?>
$('.comment-register').submit(function(){
	// 입력금지 단어가 있는지 확인
	var cbbs_content = $(this).find('.cbbs_content');
	var cbbs_name	 = $(this).find('.nonmember_namec');
	if(!js_banned_word_check(cbbs_content.val(), banned_word)){
		cbbs_content.focus();
		return false;
	}
	try{
		if(!js_banned_word_check(cbbs_name.val(), banned_word) || !js_banned_word_check(cbbs_name.val(), banned_name)){
			cbbs_name.focus();
			return false;
		}
	}catch(e){}
});
<?php endif ?>
</script>
