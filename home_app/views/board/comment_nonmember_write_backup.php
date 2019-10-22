<div class="<?=$bbs_css_type?>-view">
	<div class="comment-sec" id="comment-sec">
		<form action='<?=site_url()?>board/bbs_comment/' method='post' class='BD-check-form comment-register' />
			<input type="hidden" name='<?=$this->security->get_csrf_token_name()?>' value='<?=$this->security->get_csrf_hash()?>' class='csrf_token_medi' />
			<!-- // 어느 게시글의 댓글인지 알기위해 게시글의  테이블과 아이디를 삽입한다. -->
			<input type="hidden" name="bbs_table" value="<?=$bbs_table?>" />
			<input type="hidden" name="bbs_id" value="<?=$bbs_result[0]->bbs_id?>" />
			<input type="hidden" name="bbs_num" value="<?=$bbs_result[0]->bbs_num?>" />
			<!-- // 댓글다는 살마의 아이디  비회원이면 nonmember로 저장 // -->
			<input type="hidden" name="user_id" value="<?=$user_id?>" />
			<?php if($user_lv >= 1) : ?>
			<input type="hidden" name="user_name" value="<?=$this->session->userdata('user_name')?>" class="" />
			<?php else : ?>
			<!-- // 댓글은 회원만 작성가능하게 해달라고 해서 작업하다 중단.. 나중에라도 필요하면 다시 작업한다 //-->
			<dl class="nonmember-info <?=(!empty($c_readonly))?'full-size':''?>">
				<dt class="title"><label for="cuser_name">이름</label></dt>
				<dd class="content">
					<input type="text" name="user_name" class="checkInput" id="cuser_name" required="required" <?=$c_readonly?> />
				</dd>
				<dt class="title"><label for="cbbs_pwd">비밀번호</label></dt>
				<dd class="content last">
					<input type="password" name="bbs_pwd" class="checkInput" id="cbbs_pwd" required="required" autocomplete="new-password" <?=$c_readonly?> />
				</dd>
			</dl>
			<?php endif ?>
			<div class="comment-textarea <?=(!empty($c_readonly))?'full-size':''?>">
				<label for="cbbs_content" class="blind">댓글</label>
				<textarea id="cbbs_content" name="bbs_content" class="cbbs_content checkInput check-comment-auth" <?=$c_readonly?> onkeyup="check_content_byte(this, 300, 'limit-txtlength');"><?=$c_comment_txt?></textarea>
				<strong class="blind">글자 수 제한</strong>
				<span class="limit-txtlength" id="limit-txtlength">0/300</span>
			</div>
			<?php if(empty($c_readonly)) : ?>
			<div class="comment-submit"><input type="submit" value="댓글입력" /></div>
			<?php endif ?>
		</form>
		<?php if($comment_list) : ?>
		<ul class="comment-list" id="comment-list-1depth">
			<?php foreach($comment_list as $val) : ?>
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
									<sup class="user">[회원]</sup>
									<?php elseif($val->user_level >= 7) : ?>
									<sup class="suser">[MEDIPREP]</sup>
									<?php endif ?>
								<?php endif ?>
							</div>
						</header>
						<div class="cb-content">
							<?=nl2br(fnc_set_htmls_strip($val->bbs_content))?>
						</div>
						<footer>
							<div class="cb-footer"><?=set_view_register_time($val->bbs_register, 0, 16)?></div>
						</footer>
					</article>
					<div class="btn-del-sec">
					<?php if($val->user_id === $this->encryption->decrypt($user_id)) :?>
						<?php if($val->user_id === 'nonmember') : ?>
						<a href="javascript:;">비회원삭제</a>
						<?php else : ?>
						<a href="javascript:;" class="btn-comment-del" data-bbs-table="<?=$bbs_table?>" data-parent-id="<?=$bbs_result[0]->bbs_id?>" data-comment-id="<?=$val->bbs_id?>">삭제</a>
						<?php endif ?>
					<?php endif ?>
					<?php if($user_lv >= 9) : ?>
						<?php if($val->user_id === $this->encryption->decrypt($user_id)) :?>|<?php endif ?>
						<a href="javascript:;" class="btn-comment-del" data-bbs-table="<?=$bbs_table?>" data-parent-id="<?=$bbs_result[0]->bbs_id?>" data-comment-id="<?=$val->bbs_id?>" data-comment-deltype="super">관리자 권한으로 삭제</a>
					<?php endif ?>
					</div>
				</div>
				<div class="comment-box2">
					<a href="javascript:;" class="comment-reply-view" data-bbs-table="<?=$bbs_table?>" data-parent-id="<?=$val->bbs_id?>">댓글의 댓글 <?=$val->bbs_comment?></a>
				</div>
			</li>
			<?php endforeach ?>
		</ul>
		<?php if($comment_total > $comment_limit) : ?>
		<div class="comment-more-sec">
			<a href="javascript:;" class="comment-more-1depth" data-bbs-table="<?=$bbs_table?>" data-parent-id="<?=$bbs_result[0]->bbs_id?>" data-comment-limit="<?=$comment_limit?>">더보기</a>
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
		error_msg = {msg:'로그인이 필요한 서비스입니다.\n로그인 페이지로 이동하시겠습니까?', link:'<?=site_url()?>auth/'};
	<?php else : ?>
		error_msg = {msg:'댓글 작성 권한이 없습니다.', link:''};
	<?php endif ?>
	$('.comment-register').on('click', error_msg, check_comment_write_auth);
	$('.comment-register').on('submit', function(){
		return false;
	});
<?php else : ?>
$('.comment-register').submit(function(){
	var cuser_name 	 = getIds('cuser_name');
	var cbbs_content = getIds('cbbs_content');
	if(cuser_name){
		var name_val = cuser_name.value;
		if(!js_banned_name_check(name_val, banned_name, banned_word)){
			cuser_name.focus();
			return false;
		}
	}
	var comment_val  = cbbs_content.value;
	if(!js_banned_word_check(comment_val, banned_word)){
		cbbs_content.focus();
		return false;
	}
});
<?php endif ?>
</script>
