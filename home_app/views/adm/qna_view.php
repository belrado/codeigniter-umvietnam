<div class="page-title-sec marketing-tit">
	<h2 class="page-title"><?=$title?></h2>
	<p class="page-text">
		<?=$bbs_result->user_name?> | <?=$bbs_result->user_email?> | <?=$bbs_result->bbs_register?>
	</p>
</div>
<div class="admin-page-sec">
	<?php if($bbs_result_file) : ?>
	<ul class="bbs-file-list">
		<?php for($i=0; $i<count($bbs_result_file); $i++) : ?>
		<li>
			<a href="<?=site_url()?>board/filedown/<?=$bbs_result_file[$i]->bf_name?>/<?=$bbs_result_file[$i]->bf_id?>"><?=$bbs_result_file[$i]->bf_orig_name?> (<?=$bbs_result_file[$i]->bf_size?>KB) <img src="/assets/img/ico_file_down.png" alt="file down" /></a>
		</li>
		<?php endfor ?>
	</ul>
	<?php endif ?>
	<div>
		<?=$this->security->xss_clean(clean_xss_tags(stripslashes(str_replace('\r\n', PHP_EOL, $bbs_result->bbs_content))))?>
	</div>
</div>
<div class="admin-page-sec">
	<?php if($reply) : ?>
답변있음
	<?php else : ?>
답변없음
	<?php endif ?>
	<form action="<?=site_url()?>board/update" method="post" class="BD-check-form" enctype="multipart/form-data">
		<input type="hidden" id="<?=$this->security->get_csrf_token_name()?>" name="<?=$this->security->get_csrf_token_name()?>" value="<?=$this->security->get_csrf_hash()?>" />
		<input type="hidden" name="bbs_table" value="qna" />
		<input type="hidden" name="bbs_mode" value="insert" />
		<input type="hidden" name="sch_select" value="<?=isset($sch_select)?$sch_select:''?>" />
		<input type="hidden" name="sch_keyword" value="<?=isset($sch_keyword)?$sch_keyword:''?>" />
		<input type="hidden" name="paged" value="<?=isset($paged)?$paged:1?>" />
		<input type="hidden" name="admin_write_mode" value="admin_write_mode" />
		<input type="hidden" name="bbs_parent" value="<?=$bbs_result->bbs_id?>" />
		<input type="hidden" name="bbs_is_reply" value="1" />
		<?php if($bbs_mode == 'modify') : ?>
		<input type="hidden" name="bbs_id" value="<?=$reply->bbs_id?>" />
		<input type="hidden" name="bbs_extra1" value="<?=$reply->bbs_extra1?>" />
		<?php endif ?>
		<input type="hidden" name="ckeditor_img_path" id="ckeditor_img_path" value="" />
		<input type="hidden" name="copyImgFileNames" id="copyImgFileNames" value="<?php if($bbs_mode == "modify" && ($reply)) echo htmlspecialchars(stripslashes($reply->bbs_content_imgs)); ?>" />
		<input type="hidden" name="bbs_secret" value="yes" />
		<input type="hidden" name="bbs_subject" value="Re: <?=$title?>" />
		<dl class="BD-write-skinA block-content">
			<dt><label for="bbs_content">답변제목</label></dt>
			<dd>

			</dd>
			<dt><label for="bbs_content">내용</label></dt>
			<dd><textarea name="bbs_content" id="bbs_content"><?=($reply)?fnc_set_htmls_strip(str_replace('\r\n', PHP_EOL, $reply->bbs_content)):''?></textarea></dd>
			<dt><label for="bbs_file">파일첨부1</label></dt>
			<dd>
				<input type="file" name="bbs_file[]" id="bbs_file" />
				<?php if(isset($bbs_files) && isset($bbs_files[0])) : ?>
				<div><input type="checkbox" id="bbs_file_check1" name="bbs_files_del[]" value="<?=$bbs_files[0]->bf_id?>" /><label for="bbs_file_check1"><?=$bbs_files[0]->bf_orig_name?>(<?=$bbs_files[0]->bf_size?>KB) 파일 삭제</label></div>
				<?php endif ?>
			</dd>
			<dt><label for="bbs_file2">파일첨부2</label></dt>
			<dd>
				<input type="file" name="bbs_file[]" id="bbs_file2" />
				<?php if(isset($bbs_files) && isset($bbs_files[1])) : ?>
				<div><input type="checkbox" id="bbs_file_check2" name="bbs_files_del[]" value="<?=$bbs_files[1]->bf_id?>" /><label for="bbs_file_check2"><?=$bbs_files[1]->bf_orig_name?>(<?=$bbs_files[1]->bf_size?>KB) 파일 삭제</label></label></div>
				<?php endif ?>
			</dd>
		</dl>
		<div class="submit-sec">
			<input type="submit" value="등록" class="form-btn-default">
		</div>
	</form>
</div>
<div class="admin-page-sec">
	<?=printr_show_developer($bbs_result)?>
</div>
<script src="/assets/lib/ckeditor4/ckeditor.js"></script>
<script>
//<![CDATA[
$(document).ready(function(){
	CKEDITOR.config.allowedContent = true;
	CKEDITOR.config.extraAllowedContent = 'iframe style;*[id,rel](*)';
	CKEDITOR.config.extraPlugins = 'colorbutton,font,justify';
	CKEDITOR.replace('bbs_content',{
		extraPlugins : 'image2',
		removeButtons:'Maximize',
        height: 500,
        width: '100%',
		'filebrowserUploadUrl': '/board/uploadCK/qna'
	});
	$('.BD-check-form').submit(function(e){
		/* 이미지는 5개까지만 업로드 */
		var bbs_content_val =  CKEDITOR.instances.bbs_content.getData();
		var strReg = new RegExp("<img[^>]*src=[\"']?([^>\"']+)[\"']?[^>]*>","gim");
		var content_imgup =  bbs_content_val.match(strReg);
		if(content_imgup !== null){
			if(content_imgup.length>5){
				alert('게시글에 이미지 첨부는 1MB 이하의 이미지로 최대 5개까지만 업로드 가능합니다.');
				return false;
			}
		}
	});
});
//]]>
</script>
