<?php
$colspan_num = ($bbs_adm) ? 5 : 4;
$adm_modify_class = ($bbs_adm && $bbs_result) ? 'adm-modify-css' : '';
$user_modify_class = ($user_lv && (int) $bbs_write_lv >= 2 && $user_lv >= (int) $bbs_write_lv) ? 'user-modify-css' : '';
$sch_pattern = '/'.$keyword.'/i';
?>
<div class="section-full">
	<div class="section_wrapper">
		<?php if(!empty($bbs_page_tophtml)) : ?>
			<?=$bbs_page_tophtml?>
		<?php endif ?>
		<?php if($bbs_adm) : ?>

		<?php else : ?>

		<?php endif ?>
		<!-- 카테고리, 검색 -->
		<?=$cate_seach_sec?>
		<!-- // 카테고리, 검색 -->
		<div class="bbs-wrapper">
			<!-- 선택삭제 -->
			<?php if($bbs_adm && $bbs_result) : ?>
			<?=form_open(site_url().'board/delete')?>
			<input type="hidden" name="bbs_table" value="<?=$bbs_table?>" />
			<?php endif ?>
			<!-- // 선택삭제 -->
			<ul class="toggle_<?=$bbs_css_type?>" id="bbs_toggle_list">
			<?php if($bbs_result) : ?>
				<?php foreach($bbs_result as $val) : ?>
				<li>
					<a href="<?=site_url()?>board/view/<?=$bbs_table?>/<?=$val->bbs_id?>" class="question">
						<h3>
							<span class="question-ico"></span>
							<?php
							$matches = '';
							preg_match($sch_pattern, fnc_set_htmls_strip($val->bbs_subject, true), $matches);
							?>
							<span class="subject">
								<?=(!empty($val->bbs_cate))?'<span class="category">['.fnc_set_htmls_strip($val->bbs_cate, true).']</span>':''?>
								<?php if(empty($matches)) : ?>
								<?=fnc_set_htmls_strip($val->bbs_subject, true)?>
								<?php else : ?>
								<?=str_ireplace ($keyword, '<span class="search-point">'.$matches[0].'</span>', fnc_set_htmls_strip($val->bbs_subject, true))?>
								<?php endif ?>
							</span>
						</h3>
						<span class="view-answer">답변보기</span>
					</a>
					<div class="answer">
						<div class="inner-box">
							<strong class="answer-tit"><span class="blind"><?=fnc_set_htmls_strip($val->bbs_subject, true)?> 질문에 대한</span>답변</strong>
							<div class="answer-conent">
								<div>
									<?php
									if(!empty($sch_select) && $sch_select === 'subject_content'){
										$matches = '';
										preg_match($sch_pattern, str_nl2br_save_html(stripslashes($val->bbs_content)), $matches);
										echo str_ireplace($keyword, '<span class="search-point">'.$matches[0].'</span>', str_nl2br_save_html(stripslashes($val->bbs_content)));
									}else{
										echo stripslashes($val->bbs_content);
									}
									?>
								</div>
								<?php if($val->bbs_file && isset($bbs_result_file)) :?>
								<ul class="file-list">
								<?php foreach($bbs_result_file as $bbs_file) : ?>
									<?php if($bbs_file->bf_bbs_id == $val->bbs_id) : ?>
									<li><a href="<?=site_url()?>board/filedown/<?=$bbs_file->bf_name?>/<?=$bbs_file->bf_id?>"><?=fnc_set_htmls_strip($bbs_file->bf_orig_name)?> (<?=$bbs_file->bf_size?>KB) <img src="/assets/img/ico_file_down.png" alt="다운받기" /></a></li>
									<?php endif ?>
								<?php endforeach ?>
								</ul>
							<?php endif ?>
							</div>
						</div>
					</div>
					<?php if(is_numeric($user_lv) && ($this->encryption->decrypt($this->session->userdata('user_id')) === $val->user_id) || $user_lv >= $bbs_adm_lv) : ?>
					<div class="modify-btn-sec">
						<?php if($bbs_adm && $bbs_result) : ?>
						<div class="adm-select-sec"><input type="checkbox" name="bbs_id[]" value="<?=$val->bbs_id?>" class="adm-toggle-select" /></div>
						<a href="<?=site_url()?>board/modify/<?=$bbs_table?>/<?=$val->bbs_id?>" class="modify-btn <?=$adm_modify_class?>"><?=$lang_bbs['modify']?></a>
						<?php endif ?>
					</div>
					<?php endif ?>
				</li>
				<?php endforeach ?>
			<?php else : ?>
				<li>
					<div class="question">
						<span class="category"><?=$category?></span>
						<span class="subject"><?=$lang_message['no_registered_posts']?>.</span>
					</div>
				</li>
			<?php endif ?>
			</ul>
			<div class="clear-fix paging-sec">
				<?=$paging_show?>
			</div>
			<!-- 선택삭제 -->
			<?php if($bbs_adm && $bbs_result) : ?>
			<input type="submit" value="선택삭제" class="bbs-adm-select-del" />
			</form>
			<?php endif ?>
			<!-- // 선택삭제 -->
		</div>
	</div>
</div>
<script>
//<![CDATA[
(function($){
	"use strict";
	$(document).ready(function(){
		$('.question').homeToggleEvent({
			view_elem:'.answer',
			view_inner_elem:'.inner-box'
		});
	});
})(jQuery);
//]]>
</script>
