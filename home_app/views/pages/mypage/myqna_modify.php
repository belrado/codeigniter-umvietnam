<div class="section-full">
	<div class="section_wrapper">
		<?=$mypage_nav?>
		<?=form_open(site_url().'mypage/myqna/modify/'.$my_result[0]->mq_no, 'class="BD-check-form"')?>
			<input type="hidden" name="mode" value="modify" />
			<input type="hidden" name="mq_no" value="<?=$my_result[0]->mq_no?>" />
			<p class="marginB10">* 표시는 필수입력 사항입니다.</p>
			<div class="home-form support-question-form">
				<div class="form-row">
					<label class="label" for="mq_subject">제목 *<span class="blind">필수</span></label>
					<div class="input-sec">
						<div class="input-box" style="width:100%">
							<input type="text" name="mq_subject" value="<?=fnc_set_htmls_strip($my_result[0]->mq_subject)?>" class="checkInput is_focus" required="required" id="mq_subject" data-input-name="제목">
						</div>
					</div>
				</div>
				<div class="form-row last">
					<label class="label" for="mq_content">문의내용 *<span class="blind">필수</span></label>
					<div class="input-sec">
						<div class="textarea-box">
							<textarea name="mq_content" required="required" class="checkInput input-shadow checkLength" id="mq_content"><?=fnc_set_htmls_strip(str_replace('\r\n', PHP_EOL, $my_result[0]->mq_content))?></textarea>
						</div>
					</div>
				</div>
			</div>
			<div class="home-form-submit-sec">
				<input type="submit" value="작성완료" class="submit-btn" id="register-submit">
				<a href="<?=site_url()?>mypage/myqna/list" class="btn-boder-rect">나의 문의목록</a>
			</div>	
		</form>
	</div>
</div>
<script>
var set_focusout_input_backgroundcolor = function(_this, textarea){
	if(_this.val() != ''){
		if(textarea) _this.parent().addClass('is_focus');
		_this.addClass('is_focus');
	}else{
		if(textarea) _this.parent().removeClass('is_focus');
		_this.removeClass('is_focus');
	}
}
$('.BD-check-form input[type="text"]').on({
	focusout:function(){
		set_focusout_input_backgroundcolor($(this), false);
	}
});
$('#mq_content').on({
	focusin:function(){
		$(this).parent().addClass('is_focus');
	},
	focusout:function(){
		set_focusout_input_backgroundcolor($(this), true);
	}
});	
</script>