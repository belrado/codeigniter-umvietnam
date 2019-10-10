<div class="page-title-sec marketing-tit">
	<h2 class="page-title"><?=$title?></h2>
</div>
<div class="admin-page-sec">
	<?=form_open_multipart('', 'class="admin-popup-wrap BD-check-form"')?>
    <input type="hidden" name="mode" value="modify" />
    <input type="hidden" name="u_id" value="<?=$univ->u_id?>" />
        <dl class="BD-write-skinA">
			<dt>
				<label for="u_use">* 사용유무</label>
			</dt>
			<dd>
				<select name="u_use" id="u_use">
					<option value="yes" <?=($univ->u_use==='yes')?'selected="selected"':''?>>사용</option>
					<option value="no" <?=($univ->u_use==='no')?'selected="selected"':''?>>사용안함</option>
				</select>
			</dd>
            <dt>
				<label for="u_name_vn">* 대학교 이름 (VN)</label>
			</dt>
            <dd>
				<input type="text" name="u_name_vn" id="u_name_vn" value="<?=fnc_set_htmls_strip($univ->u_name_vn)?>" class="checkInput">
			</dd>
			<dt>
				<label for="u_program_name_vn">* 프로그램 이름 (VN)</label>
			</dt>
            <dd>
				<input type="text" name="u_program_name_vn" id="u_program_name_vn" value="<?=fnc_set_htmls_strip($univ->u_program_name_vn)?>" class="checkInput">
			</dd>
            <dt>
				<label for="u_name_en">* 대학교 이름 (EN)</label>
			</dt>
            <dd>
				<input type="text" name="u_name_en" id="u_name_en" value="<?=fnc_set_htmls_strip($univ->u_name_en)?>" class="checkInput">
			</dd>
            <dt>
				<label for="u_program_name_en">* 프로그램 이름 (EN)</label>
			</dt>
            <dd>
				<input type="text" name="u_program_name_en" id="u_program_name_en" value="<?=fnc_set_htmls_strip($univ->u_program_name_en)?>" class="checkInput">
			</dd>
			<dt>
				<div class="label">* 구글맵 좌표</div>
			</dt>
			<dd>
				<label for="u_lat">lat</label> :
				<input type="text" name="u_lat" id="u_lat" value="<?=fnc_set_htmls_strip($univ->u_lat)?>" class="checkInput size_small" />&nbsp;&nbsp;
				<label for="u_lng">lng</label> :
				<input type="text" name="u_lng" id="u_lng" value="<?=fnc_set_htmls_strip($univ->u_lng)?>" class="checkInput size_small" />
			</dd>
			<dt>
				<label for="u_address">* 대학교 주소</label>
			</dt>
			<dd>
				<input type="text" name="u_address" id="u_address" value="<?=fnc_set_htmls_strip($univ->u_address)?>" class="checkInput">
			</dd>
			<dt>
				<span class="label">대학교 로고</span>
			</dt>
			<dd>
				<div class="marginB5">
				<?php if(empty($univ->u_logo)) : ?>
					등록된 파일이 없습니다.
				<?php else : ?>
					<input type="hidden" name="u_logo_ori" value="<?=$univ->u_logo_path?>" />
					<img src="/assets/img/univ/<?=$univ->u_logo?>" alt="" style="width:80px" />
				<?php endif ?>
				</div>
				<label>
					로고파일 : <input type="file" name="u_logo" />
				</label>
			</dd>
			<dt>
				<span class="label">대학교 사진</span>
			</dt>
			<dd>
				<div class="marginB5">
				<?php if(empty($univ->u_photo)) : ?>
					등록된 파일이 없습니다.
				<?php else : ?>
					<input type="hidden" name="u_photo_ori" value="<?=$univ->u_photo_path?>" />
					<img src="/assets/img/univ/<?=$univ->u_photo?>" alt="" style="width:140px" />
				<?php endif ?>
				</div>
				<label>
					학교이미지 : <input type="file" name="u_image" />
				</label>
			</dd>
			<dt>
				<label for="u_homepage">홈페이지</label>
			</dt>
			<dd>
				<input type="text" name="u_homepage" value="<?=fnc_set_htmls_strip($univ->u_homepage)?>" id="u_homepage">
			</dd>
			<dt>
				<label for="u_index">노출 순서</label>
			</dt>
			<dd>
				<input type="text" name="u_index" id="u_index" value="<?=fnc_set_htmls_strip($univ->u_index*-1)?>" class="size_small" />&nbsp;&nbsp;숫자가 높을수록 먼저 나옴
			</dd>
            <dt>
                <label for="u_contents_vn">대학교 정보 (VN)</label>
            </dt>
            <dd>
                <textarea name="u_contents_vn" id="u_contents_vn"><?=fnc_set_htmls_strip(str_replace('\r\n', PHP_EOL, $univ->u_contents_vn))?></textarea>
            </dd>
            <dt>
                <label for="u_contents_en">대학교 정보 (EN)</label>
            </dt>
            <dd>
                <textarea name="u_contents_en" id="u_contents_en"><?=fnc_set_htmls_strip(str_replace('\r\n', PHP_EOL, $univ->u_contents_en))?></textarea>
            </dd>
		</dl>
		<div>
			<input type="submit" value="저장" />
		</div>
    </form>
</div>
<script src="/assets/lib/ckeditor4/ckeditor.js"></script>
<script>
//<![CDATA[
$(document).ready(function(){
    CKEDITOR.config.allowedContent = true;
    CKEDITOR.config.extraAllowedContent = 'iframe style;*[id,rel](*)';
    CKEDITOR.config.extraPlugins = 'colorbutton,font,justify';
	CKEDITOR.replace('u_contents_vn',{
		//extraPlugins : 'image2',
		removeButtons:'Maximize,Image',
        height: 700,
        width: '100%'
	});

    CKEDITOR.replace('u_contents_en',{
		//extraPlugins : 'image2',
		removeButtons:'Maximize,Image',
        height: 700,
        width: '100%'
	});
});
//]]>
</script>
