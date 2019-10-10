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
			<input type="hidden" name="umv_lang" value="<?=$umv_lang?>" />
			<?php if($bbs_adm) :?>
			<input type="hidden" name="admin_write_mode" value="admin_write_mode" />
			<?php endif ?>
			<?php if($bbs_mode == 'modify') : ?>
			<input type="hidden" name="bbs_id" value="<?=$bbs_result[0]->bbs_id?>" />
			<input type="hidden" name="bbs_extra1" value="<?=$bbs_result[0]->bbs_extra1?>" />
			<?php endif ?>
			<input type="hidden" name="ckeditor_img_path" id="ckeditor_img_path" value="" />
			<input type="hidden" name="copyImgFileNames" id="copyImgFileNames" value="<?php if($bbs_mode == "modify" && isset($bbs_result)) echo htmlspecialchars(stripslashes($bbs_result[0]->bbs_content_imgs)); ?>" />

			<ul class="BD-write-skinB block-content">
			<?php if($user_name && (int) $bbs_adm_lv <= $user_lv) :?>
				<li>
					<div class="label">
						<strong class="text">Option</strong>
					</div>
					<div class="input-sec">
						<div class="check-box">
							<input type="checkbox" name="bbs_notice" id="bbs_notice" /><label for="bbs_notice">공지</label>
						</div>
					</div>
				</li>
				<li>
					<label class="label" for="bbs_index">
						<span>Index</span>
					</label>
					<div class="input-sec">
						<div class="select-box">
							<select name="bbs_index" id="bbs_index">
							<?php for($i=0; $i<=10; $i++) : ?>
								<option value="<?=($i*-1)?>" <?php if(isset($bbs_result)) if($bbs_result[0]->bbs_index == ($i*-1)) echo 'selected="selected"'; ?>><?=$i?></option>
							<?php endfor ?>
							</select>
							<div class="select-box-ico"></div>
						</div>
					</div>
				</li>
				<li>
					<label class="label" for="bbs_use">
						<span>Use</span>
					</label>
					<div class="input-sec">
						<div class="select-box">
							<select name="bbs_use" id="bbs_use">
								<option value="yes" <?php if(isset($bbs_result) && $bbs_result[0]->bbs_use == 'yes') echo 'selected="selected"';?>>YES</option>
								<option value="no" <?php if(isset($bbs_result) && $bbs_result[0]->bbs_use == 'no') echo 'selected="selected"';?>>NO</option>
							</select>
							<div class="select-box-ico"></div>
						</div>
					</div>
				</li>
			<?php endif ?>
			<?php if(!empty($bbs_cate_list)): ?>
				<li>
					<label class="label" for="bbs_cate">
						<span>Category</span>
					</label>
					<div class="input-sec">
						<div class="select-box">
							<select name="bbs_cate" id="bbs_cate">
						<?php
							$bbs_cate_list = explode("|", $bbs_cate_list);
							foreach($bbs_cate_list as $val) :
						?>
							<option value="<?=trim(htmlspecialchars(stripslashes($val)))?>" <?php if(isset($bbs_result)){ if(trim($bbs_result[0]->bbs_cate) == trim($val)) echo "selected='selected'"; }?>><?=trim(htmlspecialchars(stripslashes($val)))?></option>
						<?php endforeach ?>
							</select>
							<div class="select-box-ico"></div>
						</div>
					</div>
				</li>
			<?php elseif(empty($bbs_cate_list) && !empty($bbs_result[0]->bbs_cate)) : ?>
				<li>
					<label class="label" for="bbs_cate">
						<span>Category</span>
					</label>
					<div class="input-sec">
						<div class="input-box">
							<input type="text" name="bbs_cate" id="bbs_cate" class="checkInput" value="<?php if(isset($bbs_result)) echo htmlspecialchars(stripslashes($bbs_result[0]->bbs_cate)); ?>" />
						</div>
					</div>
				</li>
			<?php endif ?>
			<?php if(!$bbs_adm && ($user_lv>=2 && $user_lv<=6) && ($bbs_type == 'list' || $bbs_type=="list_img")) : ?>
				<li>
					<div class="label">
						<strong><?=stripslashes($lang_bbs['lock_post'])?></strong>
					</div>
					<div class="input-sec">
						<div class="check-box">
							<label>
								<input type="checkbox" name="bbs_secret" value="yes" <?=(isset($bbs_result) && $bbs_result[0]->bbs_secret === 'yes')?'checked="checked"':''?> />
								(<?=stripslashes($lang_bbs['only_adm_author_check'])?>)
							</label>
						</div>
					</div>
				</li>
			<?php endif ?>
				<li>
					<!-- // 제목 //-->
					<label class="label" for="bbs_subject">
						<span><?=stripslashes($lang_bbs['subject'])?></span>
					</label>
					<div class="input-sec">
						<div class="input-box">
							<input type="text" name="bbs_subject" id="bbs_subject" class="checkInput"
							value="<?=($this->session->flashdata('bbs_subject'))?$this->session->flashdata('bbs_subject'):((isset($bbs_result))?fnc_set_htmls_strip($bbs_result[0]->bbs_subject, true):'')?>" />
						</div>
					</div>
				</li>
			<?php if($bbs_adm && ($bbs_type !== 'list' && $bbs_type  !== 'toggle')) : ?>
				<li>
					<!-- // 리스트 이미지 //-->
					<label class="label" for="bbs_image">
						<span><?=stripslashes($lang_bbs['list_img'])?></span>
					</label>
					<div class="input-sec">
						<div class="file-box">
							<input type="file" name="bbs_image[]" id="bbs_image" />
						</div>
						<?php if(isset($bbs_result) && $bbs_result[0]->bbs_image && isset($bbs_list_file)) : ?>
						<div><input type="checkbox" value="<?=$bbs_list_file[0]->bf_id?>" name="bbs_image_del" /><?=$bbs_list_file[0]->bf_orig_name?> 삭제</div>
						<div><img src="/<?=str_replace(FCPATH, '', $bbs_list_file[0]->bf_full_path)?>" alt="" style="width:100px" /></div>
						<?php endif ?>
					</div>
				</li>
			<?php endif ?>
			<?php if($user_name && (int) $bbs_adm_lv <= $user_lv && $bbs_type  !== 'toggle') :?>
				<li>
					<!-- // 링크 페이지 //-->
					<label class="label" for="bbs_link">
						<span><?=stripslashes($lang_bbs['link_page'])?></span>
					</label>
					<div class="input-sec">
						<div class="input-box">
							<input type="text" name="bbs_link" id="bbs_link" value="<?php if(isset($bbs_result)) echo htmlspecialchars(stripslashes($bbs_result[0]->bbs_link)); ?>" <?=($bbs_type==="youtube")?'class="checkinput" required="required"':''?> />
						</div>
					</div>
				</li>
			<?php endif ?>
			<?php if($bbs_type === 'youtube') : ?>
				<li>
					<label class="label" for="bbs_extra1">
						<span>Iframe Code</span>
					</label>
					<div class="input-sec">
						<div class="input-box">
							<input type="text" name="bbs_extra1" id="bbs_extra1" value="<?php if(isset($bbs_result)) echo stripslashes($bbs_result[0]->bbs_extra1); ?>" class="checkinput" required="required" />
						</div>
						<p>iframe 태그 안의 src 값만 입력</p>
					</div>
				</li>
				<li>
					<!-- // 내용 //-->
					<label class="label" for="bbs_content">
						<span><?=stripslashes($lang_bbs['contents'])?></span>
					</label>
					<div class="input-sec">
						<div class="textarea-box none-editor">
							<textarea name="bbs_content"><?=($this->session->flashdata('bbs_content'))?$this->session->flashdata('bbs_content'):((isset($bbs_result))?str_striptag_fnc($bbs_result[0]->bbs_content):'')?></textarea>
						</div>
					</div>
				</li>
			<?php else : ?>
				<li>
					<!-- // 내용 //-->
					<label class="label" for="bbs_content">
						<span><?=stripslashes($lang_bbs['contents'])?></span>
					</label>
					<div class="input-sec">
						<p>
							* <?=stripslashes($lang_bbs['up_to_5_attachments'])?>
						</p>
						<p class="marginB10">
							* <?=stripslashes($lang_bbs['image_only_1mb_size'])?>
						</p>
						<div class="textarea-box">
							<textarea name="bbs_content" id="bbs_content"><?=($this->session->flashdata('bbs_content'))?$this->session->flashdata('bbs_content'):((isset($bbs_result))?stripslashes(str_replace('\r\n', PHP_EOL, $bbs_result[0]->bbs_content)):'')?></textarea>
						</div>
					</div>
				</li>
			<?php endif ?>
			<?php if($bbs_type !== 'gallery' && $bbs_type !== 'youtube') : ?>
				<li>
					<!-- // 파일첨부 //-->
					<label class="label" for="bbs_file">
						<span><?=stripslashes($lang_bbs['attach'])?></span>
					</label>
					<div class="input-sec">
						<p class="marginB10">
							* <?=stripslashes($lang_bbs['file_attached_2mb'])?><br />(PDF, jpg, gif, png, word, docx, excel, xlsx)
						</p>
						<div class="file-box">
							<input type="file" name="bbs_file[]" id="bbs_file" />
						</div>
						<?php if(isset($bbs_files) && isset($bbs_files[0])) : ?>
						<div><input type="checkbox" id="bbs_file_check1" name="bbs_files_del[]" value="<?=$bbs_files[0]->bf_id?>" /><label for="bbs_file_check1"><?=$bbs_files[0]->bf_orig_name?>(<?=$bbs_files[0]->bf_size?>KB) 파일 삭제</label></div>
						<?php endif ?>
					</div>
				</li>
			<?php endif ?>
			</ul>
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
	var get_contents_imgtag = function(data){
		var strReg = new RegExp("<img[^>]*src=[\"']?([^>\"']+)[\"']?[^>]*>","gim");
		return data.match(strReg);
	};
<?php if($bbs_write_lv >= 7 || $bbs_adm) :?>
	CKEDITOR.config.allowedContent = true;
	CKEDITOR.config.extraAllowedContent = 'iframe style;*[id,rel](*)';
	CKEDITOR.config.extraPlugins = 'colorbutton,font,justify';
<?php endif ?>
	CKEDITOR.replace('bbs_content',{
		extraPlugins : 'image2',
		removeButtons:'Maximize,Source',
        height: 400,
        width: '100%',
		'filebrowserUploadUrl': '/board/uploadCK/<?=$bbs_table?>'
	});
	$('.BD-check-form').submit(function(e){
		/* 이미지는 5개까지만 업로드 */
		//var bbs_content_val =  CKEDITOR.instances.bbs_content.getData();
		//var strReg = new RegExp("<img[^>]*src=[\"']?([^>\"']+)[\"']?[^>]*>","gim");
		//var content_imgup =  bbs_content_val.match(strReg);
		var content_imgup = get_contents_imgtag(CKEDITOR.instances.bbs_content.getData());
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
