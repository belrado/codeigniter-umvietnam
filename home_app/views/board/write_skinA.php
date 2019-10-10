<?php if($bbs_adm) :  ?>

<?php endif ?>
<?php $faq = (isset($faq_result)) ? $faq_result : null; ?>
<div class="section-full">
	<div class="section_wrapper">
		<h3 class="content-tit-leftwon"><?=$title?> <?php if(isset($bbs_result)) : ?><?=$lang_bbs['modify']?><?php else : ?><?=$lang_bbs['write']?><?php endif ?></h3>
		<form action="<?=site_url()?>board/update" method="post" class="BD-check-form" enctype="multipart/form-data">
			<input type="hidden" id="<?=$this->security->get_csrf_token_name()?>" name="<?=$this->security->get_csrf_token_name()?>" value="<?=$this->security->get_csrf_hash()?>" />
			<input type="hidden" name="bbs_table" value="<?=$bbs_table?>" />
			<input type="hidden" name="bbs_mode" value="<?=$bbs_mode?>" />
			<input type="hidden" name="sch_select" value="<?=isset($sch_select)?$sch_select:''?>" />
			<input type="hidden" name="sch_keyword" value="<?=isset($sch_keyword)?$sch_keyword:''?>" />
			<input type="hidden" name="paged" value="<?=isset($paged)?$paged:1?>" />
			<?php if($bbs_adm) :?>
			<input type="hidden" name="admin_write_mode" value="admin_write_mode" />
			<?php endif ?>
			<?php if($bbs_mode == 'modify') : ?>
			<input type="hidden" name="bbs_id" value="<?=$bbs_result[0]->bbs_id?>" />
			<input type="hidden" name="bbs_extra1" value="<?=$bbs_result[0]->bbs_extra1?>" />
			<?php endif ?>
			<input type="hidden" name="ckeditor_img_path" id="ckeditor_img_path" value="" />
			<input type="hidden" name="copyImgFileNames" id="copyImgFileNames" value="<?php if($bbs_mode == "modify" && isset($bbs_result)) echo htmlspecialchars(stripslashes($bbs_result[0]->bbs_content_imgs)); ?>" />
			<dl class="BD-write-skinB block-content">
			<?php if($user_name && (int) $bbs_adm_lv <= $user_lv) :?>
				<dt>Option</dt>
				<dd><input type="checkbox" name="bbs_notice" id="bbs_notice" /><label for="bbs_notice">공지</label></dd>
				<dt><label for="bbs_index">Index</label></dt>
				<dd>
					<select name="bbs_index">
					<?php for($i=0; $i<=10; $i++) : ?>
						<option value="<?=($i*-1)?>" <?php if(isset($bbs_result)) if($bbs_result[0]->bbs_index == ($i*-1)) echo 'selected="selected"'; ?>><?=$i?></option>
					<?php endfor ?>
					</select>
				</dd>
				<dt><label for="bbs_use">Use</label></dt>
				<dd>
					<select name="bbs_use" id="bbs_use">
						<option value="yes" <?php if(isset($bbs_result) && $bbs_result[0]->bbs_use == 'yes') echo 'selected="selected"';?>>YES</option>
						<option value="no" <?php if(isset($bbs_result) && $bbs_result[0]->bbs_use == 'no') echo 'selected="selected"';?>>NO</option>
					</select>
				</dd>
			<?php endif ?>
			<?php if(!empty($bbs_cate_list)): ?>
				<dt><label for="bbs_cate">Category</label></dt>
				<dd>
					<select name="bbs_cate" id="bbs_cate">
				<?php
					$bbs_cate_list = explode("|", $bbs_cate_list);
					foreach($bbs_cate_list as $val) :
				?>
					<option value="<?=trim(htmlspecialchars(stripslashes($val)))?>" <?php if(isset($bbs_result)){ if(trim($bbs_result[0]->bbs_cate) == trim($val)) echo "selected='selected'"; }?>><?=trim(htmlspecialchars(stripslashes($val)))?></option>
				<?php endforeach ?>
					</select>
				</dd>
			<?php elseif(empty($bbs_cate_list) && !empty($bbs_result[0]->bbs_cate)) : ?>
				<dt><label for="bbs_cate">Category</label></dt>
				<dd><input type="text" name="bbs_cate" id="bbs_cate" class="checkInput" value="<?php if(isset($bbs_result)) echo htmlspecialchars(stripslashes($bbs_result[0]->bbs_cate)); ?>" /></dd>
			<?php endif ?>
			<?php if(!$bbs_adm && ($user_lv>=2 && $user_lv<=6) && ($bbs_type == 'list' || $bbs_type=="qna" || $bbs_type=="list_img")) : ?>
				<dt>
					<strong>
						<?=stripslashes($lang_bbs['lock_post'])?>
					</strong>
				</dt>
				<dd>
					<label>
						<input type="checkbox" name="bbs_secret" value="yes" <?=(isset($bbs_result) && $bbs_result[0]->bbs_secret === 'yes')?'checked="checked"':''?> />
						(<?=stripslashes($lang_bbs['only_adm_author_check'])?>)
					</label>
				</dd>
			<?php endif ?>
				<dt>
					<!-- // 제목 //-->
					<label for="bbs_subject">
						<?=stripslashes($lang_bbs['subject'])?>
					</label>
				</dt>
				<dd>
					<input type="text" name="bbs_subject" id="bbs_subject" class="checkInput"
					value="<?=($this->session->flashdata('bbs_subject'))?$this->session->flashdata('bbs_subject'):((isset($bbs_result))?fnc_set_htmls_strip($bbs_result[0]->bbs_subject, true):'')?>" />
				</dd>
			<?php if($bbs_write_lv <= 1 && !$user_name) : ?>
				<dt><label for="nonmember">이름</label></dt>
				<dd><input type="text" name="nonmember" id="nonmember"</dd>
			<?php endif ?>
			<!-- // 일단 비밀번호는 삭제
				<dt><label for="bbs_pwd">비밀번호</label></dt>
				<dd><input type="password" name="bbs_pwd" id="bbs_pwd" autocomplete="off" /></dd>
				<dt><label for="bbs_image">리스트이미지</label></dt>
				<dd><input type="file" name="bbs_image" id="bbs_image" /></dd>
			// -->
			<?php if($bbs_adm && ($bbs_type !== 'list' && $bbs_type  !== 'toggle')) : ?>
				<dt>
					<!-- // 리스트 이미지 //-->
					<label for="bbs_image">
						<?=stripslashes($lang_bbs['list_img'])?>
					</label>
				</dt>
				<dd>
					<input type="file" name="bbs_image[]" id="bbs_image" />
					<?php if(isset($bbs_result) && $bbs_result[0]->bbs_image && isset($bbs_list_file)) : ?>
					<div><input type="checkbox" value="<?=$bbs_list_file[0]->bf_id?>" name="bbs_image_del" /><?=$bbs_list_file[0]->bf_orig_name?> 삭제</div>
					<div><img src="/<?=str_replace(FCPATH, '', $bbs_list_file[0]->bf_full_path)?>" alt="" style="width:100px" /></div>
					<?php endif ?>
				</dd>
			<?php endif ?>
			<?php if($user_name && (int) $bbs_adm_lv <= $user_lv && $bbs_type  !== 'toggle') :?>
				<dt>
					<!-- // 링크 페이지 //-->
					<label for="bbs_link">
						<?=stripslashes($lang_bbs['link_page'])?>
					</label>
				</dt>
				<dd><input type="text" name="bbs_link" id="bbs_link" value="<?php if(isset($bbs_result)) echo htmlspecialchars(stripslashes($bbs_result[0]->bbs_link)); ?>" /></dd>
			<?php endif ?>
			<!-- // 유투브게시판이면 extra1을 iframCode 삽입 , 다른 게시판들은 content 영역 // -->
			<?php if($bbs_type === 'youtube') : ?>
				<dt><label for="bbs_extra1">Iframe Code</label></dt>
				<dd>
					<input type="hidden" name="bbs_content" value="메디프렙 동영상" />
					<p>iframe 태그 안의 src 값만 입력</p>
					<input type="text" name="bbs_extra1" id="bbs_extra1" value="<?php if(isset($bbs_result)) echo stripslashes($bbs_result[0]->bbs_extra1); ?>" />
				</dd>
			<?php else : ?>
				<dt>
					<!-- // 내용 //-->
					<label for="bbs_content">
						<?=stripslashes($lang_bbs['contents'])?>
					</label>
				</dt>
				<dd>
					<p>
						* <?=stripslashes($lang_bbs['up_to_5_attachments'])?>
					</p>
					<p class="marginB10">
						* <?=stripslashes($lang_bbs['image_only_1mb_size'])?>
					</p>
					<textarea name="bbs_content" id="bbs_content"><?=($this->session->flashdata('bbs_content'))?$this->session->flashdata('bbs_content'):((isset($bbs_result))?stripslashes(str_replace('\r\n', PHP_EOL, $bbs_result[0]->bbs_content)):'')?></textarea>
				</dd>
			<?php endif ?>
			<?php if($bbs_type !== 'gallery' && $bbs_type !== 'youtube') : ?>
				<dt>
					<!-- // 파일첨부 //-->
					<label for="bbs_file">
						<?=stripslashes($lang_bbs['attach'])?>
					</label>
				</dt>
				<dd>
					<p class="marginB10">
						* <?=stripslashes($lang_bbs['file_attached_2mb'])?><br />(PDF, jpg, gif, png, word, docx, excel, xlsx)
					</p>
					<input type="file" name="bbs_file[]" id="bbs_file" />
					<?php if(isset($bbs_files) && isset($bbs_files[0])) : ?>
					<div><input type="checkbox" id="bbs_file_check1" name="bbs_files_del[]" value="<?=$bbs_files[0]->bf_id?>" /><label for="bbs_file_check1"><?=$bbs_files[0]->bf_orig_name?>(<?=$bbs_files[0]->bf_size?>KB) 파일 삭제</label></div>
					<?php endif ?>
				</dd>
				<?php /*
				<dt><label for="bbs_file2">파일첨부2</label></dt>
				<dd>
					<input type="file" name="bbs_file[]" id="bbs_file2" />
					<?php if(isset($bbs_files) && isset($bbs_files[1])) : ?>
					<div><input type="checkbox" id="bbs_file_check2" name="bbs_files_del[]" value="<?=$bbs_files[1]->bf_id?>" /><label for="bbs_file_check2"><?=$bbs_files[1]->bf_orig_name?>(<?=$bbs_files[1]->bf_size?>KB) 파일 삭제</label></label></div>
					<?php endif ?>
				</dd>
				*/ ?>
			<?php endif ?>
			</dl>
			<div class="submit-sec">
				<input type="submit" value="<?=stripslashes($lang_bbs['registration'])?>" class="form-btn-default">
				<?php if($bbs_mode === 'modify') : ?>
					<a href="<?=site_url()?><?=$umv_lang?>/board/view/<?=$bbs_table?>/<?=$bbs_result[0]->bbs_id?>/?select=<?=$sch_select?>&amp;keyword=<?=$sch_keyword?>&amp;paged=<?=$paged?>" class="form-btn-default"><?=stripslashes($lang_bbs['cancel'])?></a>
				<?php else : ?>
					<a href="<?=site_url()?><?=$umv_lang?>/board/list/<?=$bbs_table?>/" class="form-btn-default"><?=stripslashes($lang_bbs['cancel'])?></a>
				<?php endif ?>
			</div>
		</form>
	</div>
</div>
<!-- // 유투브형식 게시판이면 ckeditor 사용안한다 // -->
<?php if($bbs_type !== 'youtube') : ?>
<script src="/assets/lib/ckeditor4/ckeditor.js"></script>
<script>
//<![CDATA[
$(document).ready(function(){
<?php if($bbs_write_lv >= 7 || $bbs_adm) :?>
	CKEDITOR.config.allowedContent = true;
	CKEDITOR.config.extraAllowedContent = 'iframe style;*[id,rel](*)';
	CKEDITOR.config.extraPlugins = 'colorbutton,font,justify';
<?php endif ?>
	CKEDITOR.replace('bbs_content',{
		extraPlugins : 'image2',
		removeButtons:'Maximize',
        height: 500,
        width: '100%',
		'filebrowserUploadUrl': '/board/uploadCK/<?=$bbs_table?>'
	});
	$('.BD-check-form').submit(function(e){
		/* 이미지는 5개까지만 업로드 */
		var bbs_content_val =  CKEDITOR.instances.bbs_content.getData();
		var strReg = new RegExp("<img[^>]*src=[\"']?([^>\"']+)[\"']?[^>]*>","gim");
		var content_imgup =  bbs_content_val.match(strReg);
		if(content_imgup !== null){
			if(content_imgup.length>5){
				alert("<?=stripslashes($lang_bbs['up_to_5_1mb_post'])?>");
				return false;
			}
		}
	});
});
//]]>
</script>
<?php endif ?>
