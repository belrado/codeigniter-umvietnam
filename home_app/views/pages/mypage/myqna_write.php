<div class="section-full">
	<div class="section_wrapper">
		<?=$mypage_nav?>
		<?=form_open_multipart(site_url().$umv_lang.'/mypage/myqna_update', 'class="BD-check-form"')?>
			<input type="hidden" name="mode" value="write" />
			<input type="hidden" name="ckeditor_img_path" id="ckeditor_img_path" />
			<input type="hidden" name="copyImgFileNames" value="<?=($this->session->flashdata('copyImgFileNames')?$this->session->flashdata('copyImgFileNames'):'')?>" id="copyImgFileNames" />
			<p class="marginB10">* <?=stripslashes($lang_bbs['required'])?></p>
			<div class="home-form support-question-form">
				<div class="form-row">
					<label class="label" for="mq_subject">*<span class="blind"><?=stripslashes($lang_bbs['required'])?></span> <?=stripslashes($lang_bbs['subject'])?></label>
					<div class="input-sec">
						<div class="input-box" style="width:100%">
							<input type="text" name="mq_subject" class="checkInput" required="required" id="mq_subject" data-input-name="제목"
							value="<?=($this->session->flashdata('mq_subject')?trans_text($this->session->flashdata('mq_subject')):'')?>" />
						</div>
					</div>
				</div>
				<div class="form-row">
					<label class="label" for="mq_content">*<span class="blind"><?=stripslashes($lang_bbs['required'])?></span> <?=stripslashes($lang_bbs['contents'])?></label>
					<div class="input-sec">
						<p>
							* <?=stripslashes($lang_bbs['up_to_5_attachments'])?>
						</p>
						<p class="marginB10">
							* <?=stripslashes($lang_bbs['image_only_1mb_size'])?>
						</p>
						<div class="textarea-box">
							<textarea name="mq_content"
								required="required"
								class="checkInput input-shadow checkLength" id="mq_content"><?=($this->session->flashdata('mq_content')?$this->session->flashdata('mq_content'):'')?></textarea>
						</div>
					</div>
				</div>
				<div class="form-row last">
					<div class="label"><?=stripslashes($lang_bbs['attach'])?></div>
					<div class="input-sec">
						<p class="marginB10">
							* <?=stripslashes($lang_bbs['file_attached_size'])?> 10mb<br />(PDF, jpg, gif, png, word, docx, excel, xlsx, zip)
						</p>
						<div class="file-box">
							<input type="file" name="bbs_file[]" id="bbs_file" />
						</div>
						<div class="file-box">
							<input type="file" name="bbs_file[]" id="bbs_file" />
						</div>
					</div>
				</div>
			</div>
			<div class="home-form-submit-sec">
				<input type="submit" value="<?=stripslashes($lang_bbs['registration'])?>" class="submit-btn" id="register-submit">
				<a href="<?=site_url()?><?=$umv_lang?>/mypage/myqna/list" class="btn-boder-rect"><?=stripslashes($lang_bbs['my_qna_list'])?></a>
			</div>
		</form>
	</div>
</div>
<script src="/assets/lib/ckeditor4/ckeditor.js"></script>
<script>
$(document).ready(function(){
	CKEDITOR.replace('mq_content',{
		extraPlugins : 'image2',
		removeButtons:'Maximize,Source',
        height: 400,
        width: '100%',
		'filebrowserUploadUrl': '/board/uploadCK/mypageqna'
	});
	$('.BD-check-form').submit(function(e){
		/* 이미지는 5개까지만 업로드 */
		var bbs_content_val =  CKEDITOR.instances.mq_content.getData();
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
</script>
