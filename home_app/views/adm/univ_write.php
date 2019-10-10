<div class="page-title-sec marketing-tit">
	<h2 class="page-title"><?=$title?></h2>
</div>
<div class="admin-page-sec">
	<?=form_open_multipart('', 'class="admin-popup-wrap BD-check-form"')?>
	<input type="hidden" name="mode" value="insert" />
        <dl class="BD-write-skinA">
            <dt>
				<label for="u_name_vn">* 대학교 이름 (VN)</label>
			</dt>
            <dd>
				<input type="text" name="u_name_vn" id="u_name_vn" class="checkInput">
			</dd>
			<dt>
				<label for="u_program_name_vn">* 프로그램 이름 (VN)</label>
			</dt>
            <dd>
				<input type="text" name="u_program_name_vn" id="u_program_name_vn" class="checkInput">
			</dd>
            <dt>
				<label for="u_name_en">* 대학교 이름 (EN)</label>
			</dt>
            <dd>
				<input type="text" name="u_name_en" id="u_name_en" class="checkInput">
			</dd>
            <dt>
				<label for="u_program_name_en">* 프로그램 이름 (EN)</label>
			</dt>
            <dd>
				<input type="text" name="u_program_name_en" id="u_program_name_en" class="checkInput">
			</dd>
			<dt>
				<div class="label">* 구글맵 좌표</div>
			</dt>
			<dd>
				<label for="u_lat">lat</label> :
				<input type="text" name="u_lat" id="u_lat" class="size_small checkInput" />&nbsp;&nbsp;
				<label for="u_lng">lng</label> :
				<input type="text" name="u_lng" id="u_lng" class="size_small checkInput" />
			</dd>
			<dt>
				<label for="u_address">* 대학교 주소</label>
			</dt>
			<dd>
				<input type="text" name="u_address" id="u_address" class="checkInput">
			</dd>
			<dt>
				<span class="label">* 대학교 이미지</span>
			</dt>
			<dd>
				<label>
					로고파일 : <input type="file" name="u_logo" class="checkInput" requreid="requreid" />
				</label>
				<label>
					학교이미지 : <input type="file" name="u_image" class="checkInput" />
				</label>
			</dd>
			<dt>
				<label for="u_homepage">홈페이지</label>
			</dt>
			<dd>
				<input type="text" name="u_homepage" id="u_homepage">
			</dd>
			<dt>
				<label for="u_index">노출 순서</label>
			</dt>
			<dd>
				<input type="text" name="u_index" id="u_index" value="0" class="size_small" />&nbsp;&nbsp;숫자가 높을수록 먼저 나옴
			</dd>
            <dt>
                <label for="u_contents_vn">대학교 정보 (VN)</label>
            </dt>
            <dd>
                <textarea name="u_contents_vn" id="u_contents_vn"></textarea>
            </dd>
            <dt>
                <label for="u_contents_en">대학교 정보 (EN)</label>
            </dt>
            <dd>
                <textarea name="u_contents_en" id="u_contents_en"></textarea>
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
