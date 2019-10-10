<?php
$colspan_num = ($bbs_adm) ? 5 : 4;
$sch_pattern = '/'.$keyword.'/i';
?>
<?php if(isset($depthTabNav)){ echo $depthTabNav;} ?>
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
			<table class="<?=$bbs_css_type?> js_click_table">
			<colgroup>
			<?php if($bbs_adm) : ?>
				<col style="width:7%" class="bbs-adm-select" />
				<col style="width:8%" class="bbs_number" />
				<col style="width:55" />
				<col style="width:15%" class="bbs_reg_name" />
				<col style="width:15%" class="bbs_reg_date" />
			<?php else : ?>
				<col style="width:8%" class="bbs_number" />
				<col style="width:62%" />
				<col style="width:15%" class="bbs_reg_name" />
				<col style="width:15%" class="bbs_reg_date" />
			<?php endif ?>
			</colgroup>
			<thead>
				<tr>
					<?php if($bbs_adm) : ?>
					<th scope="col"><?=$lang_bbs['select']?></th>
					<?php endif ?>
					<th scope="col" class="first-line bbs_number"><?=$lang_bbs['num']?></th>
					<th scope="col" class="bbs_subject"><?=$lang_bbs['subject']?></th>
					<th scope="col" class="bbs_reg_name"><?=$lang_bbs['writer']?></th>
					<th scope="col" class="last-line bbs_reg_date"><?=$lang_bbs['date']?></th>
				</tr>
			</thead>
			<tbody>
				<?php if($bbs_result) : ?>
				<?php foreach($bbs_result as $val) : ?>
				<tr>
					<?php if($bbs_adm) : ?>
					<td class="first-line js_none_click bbs-adm-select"><input type="checkbox" name="bbs_id[]" value="<?=$val->bbs_id?>" /></td>
					<?php endif ?>
					<td class="<?php if(!$bbs_adm) : ?>first-line<?php endif ?> bbs_number"><?=$list_num?></td>
					<td class="bbs_subject">
						<a href="<?=site_url()?><?=$umv_lang?>/board/view/<?=$bbs_table?>/<?=$val->bbs_id?>/?select=<?=$sch_select?>&amp;keyword=<?=$keyword?>&amp;paged=<?=$paged?>" data-sublink="<?=fnc_set_htmls_strip($val->bbs_link)?>" <?=(!empty($val->bbs_link))?'data-sublink-target="_blank"':''?> <?php if($bbs_adm) echo 'class="admin-link"'?>>
							<div class="subject">
								<?php if(strtotime($val->bbs_register.'+'.'2'.' days') > strtotime(date('Y-m-d h:i:s', time()))) : ?>
								<img src="/assets/img/ico_new.gif" alt="새글" class="new-bbs" />
								<?php endif ?>
								<?php if(!empty($val->bbs_cate)) : ?>
								[<?=fnc_set_htmls_strip($val->bbs_cate)?>]
								<?php endif ?>
								<?php
								$matches = '';
								preg_match($sch_pattern, fnc_set_htmls_strip($val->bbs_subject, true), $matches);
								?>
								<?php if(empty($matches)) : ?>
									<?=fnc_set_htmls_strip($val->bbs_subject)?>
								<?php else : ?>
									<?=str_ireplace ($keyword, '<span class="search-point">'.$matches[0].'</span>', fnc_set_htmls_strip($val->bbs_subject, true))?>
								<?php endif ?>
							</div>
							<div class="author"><?=$lang_bbs['writer']?> : <?=fnc_set_htmls_strip($val->user_name)?></div>
							<div class="register"><?=$lang_bbs['date']?> : <?=set_view_register_time($val->bbs_register)?></div>
						</a>
					</td>
					<td class="bbs_reg_name"><?=fnc_set_htmls_strip($val->user_name)?></td>
					<td class="last-line bbs_reg_date"><?=set_view_register_time($val->bbs_register, 2, 8)?></td>
				</tr>
				<?php if($list_num >0) $list_num--; endforeach ?>
				<?php else : ?>
				<tr><td colspan="<?=$colspan_num?>" class="full-line"><?=$lang_message['no_registered_posts']?></td></tr>
				<?php endif ?>
			</tbody>
			</table>
			<div class="clear-fix paging-sec">
				<?=$paging_show?>
			</div>
			<!-- 선택삭제 -->
			<?php if($bbs_adm && $bbs_result) : ?>
				<input type="submit" value="<?=$lang_bbs['delete']?>" class="bbs-adm-select-del" title="<?=$lang_bbs['delete']?>" />
			</form>
			<?php endif ?>
			<!-- // 선택삭제 -->
		</div>
	</div>
</div>
