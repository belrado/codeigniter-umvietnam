<div class="section-full">
	<div class="section_wrapper">
		<?=$mypage_nav?>
		<h4 class="mypage-title mypage-qna-title">
			<span class="tit-name">&ldquo;<?=fnc_set_htmls_strip($user_info[0]->user_name)?>&rdquo;</span> 님의 문의목록
		</h4>
		<ul class="my-qna-list">
		<?php if($qna_result) :?>
			<?php foreach($qna_result as $val) : ?>
			<li>
				<a href="<?=site_url()?>mypage/myqna/view/<?=$val->mq_no?>"
					class="<?=($val->mq_reply === 'yes' && $val->mq_read === 'yes')?'reply-done':''?> <?=($val->mq_read==='yes')?'reply-list':''?>">
					<span class="num"><?=$list_num?>.</span>
					<p class="subject"><?=fnc_set_htmls_strip($val->mq_subject, true)?></p>
					<?php if($val->mq_reply === 'yes' && $val->mq_read === 'yes') : ?>
					<strong class="status"><img src="/assets/img/mypage/ico_myqna_reply.jpg" alt="답변완료" /></strong>
					<?php elseif($val->mq_read === 'yes') : ?>
					<strong class="status"><img src="/assets/img/mypage/ico_myqna_reply_ing.jpg" alt="답변 진행중" /></strong>
					<?php endif ?>
					<span class="date"><?=substr($val->mq_register,0, 16)?></span>
				</a>
			</li>
			<?php $list_num--; endforeach ?>
		<?php else : ?>
			<li class="none-list">등록된 문의사항이 없습니다.</li>
		<?php endif ?>
		</ul>
		<?php if($paging_show) : ?>
		<div class="paging-sec">
			<?=$paging_show?>
		</div>
		<?php endif ?>
		<div class="home-form-submit-sec">
			<a href="<?=site_url()?><?=$umv_lang?>/mypage/myqna/write" class="submit-btn product-submit-btn">글작성</a>
		</div>
	</div>
</div>
