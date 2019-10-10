<div class="section-full">
	<div class="section_wrapper">
		<?=$mypage_nav?>
		<div class="home-default-box mypage-box">
		<?php if($scrap_list) : ?>
			<div class="scrap-sec">
				<?=form_open(site_url().$umv_lang.'/mypage/scrap')?>
				<input type="hidden" name="paged" value="<?=$page?>" />
					<ul class="scrap-list <?=($paging_show)?'marginB20':''?>">
					<?php foreach($scrap_list as $val) : ?>
					<li>
						<?php if(isset($val->bbs_id)) : ?>
						<div class="check-sec"><input type="checkbox" name="s_chk[]" value="<?=$val->s_id?>" /></div>
						<a href="<?=site_url()?><?=$umv_lang?>/board/view/<?=$val->b_table?>/<?=$val->bbs_id?>" class="scrap-box" target="_blank">
							<div class="scrap-subject"><span class="bbs_name">[<?=fnc_set_htmls_strip($val->{'bbs_name_'.$umv_lang})?>]</span> <?=fnc_set_htmls_strip($val->bbs_subject)?></div>
							<span class="scrap-date"><?=set_view_register_time(explode(' ',$val->s_register)[0])?></span>
						</a>
						<?php else : ?>
						<div class="check-sec"><input type="checkbox" name="s_chk[]" value="<?=$val->s_id?>" /></div>
						<div class="scrap-box">
							<div class="scrap-subject">
								<?=stripslashes($lang_message['post_deleted'])?>
							</div>
							<span class="scrap-date"><?=set_view_register_time(explode(' ',$val->s_register)[0])?></span>
						</div>
						<?php endif ?>
					</li>
					<?php endforeach ?>
					</ul>
					<?=$paging_show?>
					<div class="scrap-delete <?=($paging_show)?'':'none-absolute'?>">
						<input type="submit" value="선택삭제" />
					</div>
				</form>
			</div>
		<?php else : ?>
			<p class="none-list"><?=stripslashes($lang_message['clipped_no'])?></p>
		<?php endif ?>
		</div>
	</div>
</div>
