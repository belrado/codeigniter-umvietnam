<?php if(!empty($bbs_cate_list) && $bbs_cate_use == 'yes') : ?>
<ul class="page-tabbtn-sec bbs-catelist">
	<li class="tabbtn"><a href="<?=site_url()?><?=$umv_lang?>/board/list/<?=$bbs_table?>/all/" class="<?=($category == 'all') ? 'active' : ''?>">ALL</a></li>
	<?php
	$bbs_cate = explode("|", $bbs_cate_list);
	for($i=0; $i<count($bbs_cate); $i++): ?>
	<li class="tabbtn">
		<a href="<?=site_url()?><?=$umv_lang?>/board/list/<?=$bbs_table?>/<?=trim(strtolower($bbs_cate[$i]))?>" class="<?=($category == strtolower(trim(fnc_set_htmls_strip($bbs_cate[$i])))) ? 'active' : ''?>"><?=trim(fnc_set_htmls_strip($bbs_cate[$i]))?></a>
	</li>
	<?php endfor ?>
</ul>
<?php endif ?>
<div class="bbs-utility-sec">
<!-- 글쓰기 -->
	<?php if($user_lv && (int) $bbs_write_lv >= 2 && $user_lv >= (int) $bbs_write_lv) : ?>
	<div class="bbs-writebtn-sec">
		<a href="<?=site_url()?><?=$umv_lang?>/board/write/<?=urlencode($bbs_table)?>" title="<?=$lang_bbs['write']?>"><?=$lang_bbs['write']?><span class="bbs-ico"></span></a>
	</div>
	<?php elseif ($bbs_write_lv>=2 && $bbs_write_lv <= 4 && !$this->session->userdata('user_id')) :?>
	<div class="bbs-writebtn-sec">
		<a href="<?=site_url()?><?=$umv_lang?>/auth/?returnURL=<?=$umv_lang?>/board/list/<?=$bbs_table?>" class="only-member-btn"><?=$lang_bbs['write']?></a>
	</div>
	<?php endif ?>
	<!-- // 글쓰기 -->
	<div class="search-sec">
		<form action="<?=site_url()?><?=$umv_lang?>/board/list/<?=$bbs_table?>/<?=$category?>/" method="get" class="home-form">
			<div class="select-box sch-select">
				<select name="select">
					<option value="subject" <?php if($sch_select == 'subject') echo 'selected="selected"'; ?>><?=$lang_bbs['subject']?></option>
					<option value="subject_content" <?php if($sch_select == 'subject_content') echo 'selected="selected"'; ?>><?=$lang_bbs['subject']?>+<?=$lang_bbs['contents']?></option>
					<option value="name" <?php if($sch_select == 'name') echo 'selected="selected"'; ?>><?=$lang_bbs['writer']?></option>
				</select>
				<div class="select-box-ico"></div>
			</div>
			<div class="input-box"><label for="bbs-search" class="blind"><?=$lang_bbs['search_keyword']?></label><input type="text" value="<?=$keyword?>" name="keyword" id="bbs-search" /></div>
			<input type="submit" value="<?=$lang_bbs['search']?>" class="sch-submit" />
		</form>
	</div>
</div>
