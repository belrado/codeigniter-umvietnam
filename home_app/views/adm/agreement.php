<div class="page-title-sec">
	<h2 class="page-title"><?=$title?></h2>
</div>
<div class="admin-page-sec">
	<?=form_open(site_url().'homeAdm/agreement', 'class="BD-check-form"')?>
	<input type="hidden" name="agree_lang" value="<?=$agree_lang?>" />
	<textarea name="agreement" id="agreement">
		<?=($agreement)?htmlspecialchars(stripslashes($agreement->opt_value)):''?>
	</textarea>
	<div class="admin-btn-sec3">
		<input type="submit" value="개인정보취급방침등록" class="admin-btn" />
	</div>
	<a href="" target=
	</form>
</div>
<script src="/assets/lib/ckeditor3/ckeditor.js"></script>
<script>
//<![CDATA[
$(document).ready(function(){
	CKEDITOR.config.allowedContent = true;
	CKEDITOR.replace('agreement',{
		removeButtons:'Maximize',
        height: 700,
        width: '100%'
	});
});
//]]>
</script>
