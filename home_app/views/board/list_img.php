<?php
$colspan_num = ($bbs_adm) ? 5 : 4;
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
	            <ul class="<?=$bbs_css_type?> bbs-default-imglist">
	            <?php if($bbs_result) : ?>
	    			<?php foreach($bbs_result as $val) : ?>
	                <li>
						<a href="<?=site_url()?><?=$umv_lang?>/board/view/<?=$bbs_table?>/<?=$val->bbs_id?>/?select=<?=$sch_select?>&amp;keyword=<?=$keyword?>&amp;paged=<?=$paged?>"
							data-sublink="<?=fnc_set_htmls_strip($val->bbs_link)?>"
							<?=(!empty($val->bbs_link))?'data-sublink-target="_blank"':''?>
							class="<?=($bbs_adm)?'admin-link':''?>">
							<div class="list-count">
								<div class="inner-box">
									<?php if($bbs_adm) : ?>
									<div class="adm-del-checkbox">
										<input type="checkbox" name="bbs_id[]" value="<?=$val->bbs_id?>" />
									</div>
									<?php endif ?>
									<?=preg_replace('/^\d{1}$/', '0'.$list_num, $list_num)?>
								</div>
							</div>
							<div class="list-content-sec">
								<?php if($bbs_css_type === 'bbs_typeB') : ?>
								<div class="list-thumbnail <?=(empty($val->bbs_thumbnail))?'default-thumbnail':''?>">
									<div class="inner-box">
									<?php if(!empty($val->bbs_thumbnail)) : ?>
										<img src="<?=$val->bbs_thumbnail?>" alt="" />
									<?php else : ?>
										<img src="/assets/img/bbs/bbs_listimg_default1.jpg" alt="" />
		                               <?php endif ?>
									</div>
								</div>
								<?php endif ?>
								<div class="list-contents">
									<div class="subject-sec">
										<?php if(strtotime($val->bbs_register.'+'.'2'.' days') > strtotime(date('Y-m-d h:i:s', time())) || $val->bbs_secret == 'yes') : ?>
										<div class="notice">
										<?php if(strtotime($val->bbs_register.'+'.'2'.' days') > strtotime(date('Y-m-d h:i:s', time()))) : ?>
											<strong class="new font-poppins">NEW</strong>
										<?php endif ?>
										<?php if($val->bbs_secret == 'yes') : ?>
											<strong class="secret"><?=stripslashes($lang_bbs['secret_post'])?></strong>
										<?php endif ?>
										</div>
										<?php endif ?>
										<h4 class="subject">
										<?php if(!empty($val->bbs_cate)) : ?>
											[<?=fnc_set_htmls_strip($val->bbs_cate)?>]&nbsp;&nbsp;
										<?php endif ?>
										<?php
											$matches = '';
											preg_match($sch_pattern, fnc_set_htmls_strip($val->bbs_subject, true), $matches);
										?>
										<?php if(empty($matches[0])) : ?>
											<?=fnc_utf8_strcut(fnc_set_htmls_strip($val->bbs_subject), 90)?>
										<?php else : ?>
											<?=str_ireplace ($keyword, '<span class="search-point">'.$matches[0].'</span>', fnc_utf8_strcut(fnc_set_htmls_strip($val->bbs_subject, true), 90))?>
										<?php endif ?>
										<?php if($val->bbs_file) : ?>
											<img src="/assets/img/ico_bbs_list_isfile.png" alt="Attached file" />
										<?php endif ?>
										</h4>
										<p class="content">
											<?=trim(fnc_utf8_strcut(preg_replace('/\r\n|\r|\n/is', '', fnc_set_striptag_strip($val->bbs_content)), 300))?>
										</p>
									</div>
									<div class="info-sec">
										<div class="author">
											<strong class="user">
											<?php  if($val->user_level >= 7) : ?>
												<?=fnc_set_htmls_strip($val->user_name)?>
												<span>[<?=fnc_set_htmls_strip($val->user_nick)?>]</span>
											<?php else : ?>
												<?=preg_replace('/@.+$/', '', fnc_set_htmls_strip($val->user_email))?>
												<span>[<?=fnc_name_change2(fnc_set_htmls_strip($val->user_name), 6)?>]</span>
											<?php endif ?>
											</strong>
											<span class="date font-poppins">Date. <?=set_view_register_time($val->bbs_register, 0, 10, '-')?></span>
										</div>
										<div class="community">
										<?php if($bbs_comment_use) : ?>
											<span class="ico-box ico-comment font-poppins"><?=$val->bbs_comment?></span>
										<?php endif ?>
											<span class="ico-box ico-good font-poppins"><?=$val->bbs_good?></span>
											<span class="ico-box ico-view font-poppins"><?=$val->bbs_hit?></span>
										</div>
									</div>
								</div>
							</div>
						</a>
	                </li>
	                <?php if($list_num >0) $list_num--; endforeach ?>
	            <?php else : ?>
	                <li class="none-post">
						<?=stripslashes($lang_message['no_registered_posts'])?>
	                </li>
	            <?php endif ?>
	            </ul>
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
