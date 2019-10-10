<div class="section-full">
	<div class="section_wrapper">
		<?=$mypage_nav?>
		<h4 class="mypage-title mypage-qna-title">
			<span class="tit-name">&ldquo;<?=fnc_set_htmls_strip($user_info[0]->user_name)?>&rdquo;</span> 님의 문의사항
		</h4>
		<?php if(!$view_result[0]->mr_no && $view_result[0]->mq_reply === 'no' && $view_result[0]->mq_read === 'no') : ?>
		<?=form_open(site_url().'mypage/myqna/delete/'.$view_result[0]->mq_no)?>
			<input type="hidden" name="mode" value="delete" />
			<input type="hidden" name="mq_no" value="<?=$view_result[0]->mq_no?>" />
		<?php endif ?>
		<div class="my-qna-view">
			<div class="myqna-header">
				<h4 class="myqna-subject"><?=fnc_set_htmls_strip($view_result[0]->mq_subject)?></h4>
				<span class="myqna-date"><?=substr($view_result[0]->mq_register, 0, 16)?></span>
			</div>
			<div class="myqna-content">
				<?=nl2br(fnc_set_htmls_strip(str_replace('\r\n', PHP_EOL, $view_result[0]->mq_content)))?>
			</div>
		</div>
		<?php if(!$view_result[0]->mr_no && $view_result[0]->mq_reply === 'no' && $view_result[0]->mq_read === 'no') : ?>	
		<div class="home-form-submit-sec">
			<input type="submit" value="삭제하기" class="submit-btn" id="register-submit">
			<a href="<?=site_url()?>mypage/myqna/modify/<?=$view_result[0]->mq_no?>" class="btn-boder-rect">수정하기</a>	
			<a href="<?=site_url()?>mypage/myqna/list" class="btn-boder-rect">나의 문의목록</a>
		</div>
		</form>
		<?php endif ?>
		<?php if($view_result[0]->mq_reply === 'yes' && $view_result[0]->mr_no) : ?>
		<div class="my-qna-view my-qna-reply">
			<div class="myqna-header">
				<strong class="myqna-subject">
					<img src="/assets/img/mypage/ico_reply_staff.png" alt="답변자 PSU에듀센터" />
				</strong>
				<span class="myqna-date"><?=substr($view_result[0]->mr_register, 0, 16)?></span>
			</div>
			<div class="myqna-content">
				<h4 class="blind"><?=fnc_set_htmls_strip($view_result[0]->mq_subject)?> 에 대한 답변</h4>
				<?=nl2br(fnc_set_htmls_strip(str_replace('\r\n', PHP_EOL, $view_result[0]->mr_content)))?>
			</div>
		</div>
		<div class="home-form-submit-sec">
			<a href="<?=site_url()?>mypage/myqna/write" class="btn-boder-rect">글작성</a>	
			<a href="<?=site_url()?>mypage/myqna/list" class="btn-boder-rect">나의 문의목록</a>
		</div>
		<?php elseif($view_result[0]->mq_read === 'yes') : ?>
		<div class="my-qna-view my-qna-read">
			<p class="myqna-notice">&ldquo; 현재  문의에 대한 답변이 진행중입니다. &rdquo;</p>
		</div>
		<div class="home-form-submit-sec">
			<a href="<?=site_url()?>mypage/myqna/write" class="btn-boder-rect">글작성</a>	
			<a href="<?=site_url()?>mypage/myqna/list" class="btn-boder-rect">나의 문의목록</a>
		</div>
		<?php endif ?>
	</div>
</div>