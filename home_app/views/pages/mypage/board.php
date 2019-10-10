<div class="section-full">
	<div class="section_wrapper">
		<?=$mypage_nav?>
        <div class="home-default-box mypage-box">
		<?php if($results) : ?>
			<div class="scrap-sec">
                <ul class="scrap-list <?=($paging_show)?'marginB20':''?>">
                <?php foreach($results as $val) : ?>
                <li>
                    <?php if($val->bbs_is_comment >=0) : ?>
                    <a href="<?=site_url()?><?=$umv_lang?>/board/view/<?=$bbs_table?>/<?=($val->bbs_is_comment==0)?$val->bbs_id:$val->bbs_parent?>" class="scrap-box post-box" target="_blank">
                    <?php else : ?>
                    <div class="scrap-box post-box">
                    <?php endif ?>
                        <div class="scrap-subject">
                            <p class="bbs_name marginB5">
                                <strong><?=($val->bbs_is_comment==0)?'[Post]':'[Comments]'?></strong>
                                <?php if($val->bbs_is_comment < 0) : ?>
                                <span><?=stripslashes($lang_bbs['post_deleted'])?></span>
                                <?php endif ?>
                            </p>
                            <?php if($val->bbs_is_comment==0) : ?>
                                <p>
                                    <?=fnc_set_htmls_strip($val->bbs_subject)?>
                                </p>
                                <div>
                                    <span><?=stripslashes($lang_bbs['views'])?>: <?=$val->bbs_hit?></span>&nbsp;&nbsp;
                                    <span><?=stripslashes($lang_bbs['like'])?>: <?=$val->bbs_good?></span>&nbsp;&nbsp;
                                    <span><?=stripslashes($lang_bbs['comment'])?>: <?=$val->bbs_comment?></span>
                                </div>
                            <?php else : ?>
                                <?=fnc_utf8_strcut(fnc_set_htmls_strip($val->bbs_content), 100)?>
                            <?php endif ?>
                        </div>
                        <span class="scrap-date"><?=set_view_register_time(explode(' ',$val->bbs_register)[0])?></span>
                    <?php if($val->bbs_is_comment >=0) : ?>
                    </a>
                    <?php else : ?>
                    </div>
                    <?php endif ?>
                </li>
                <?php endforeach ?>
                </ul>
			</div>
			<div>
				<?=$paging_show?>
			</div>
		<?php else : ?>
			<p class="none-list"><?=stripslashes($lang_message['clipped_no'])?></p>
		<?php endif ?>
		</div>
    </div>
</div>
