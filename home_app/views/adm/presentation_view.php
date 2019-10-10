<div class="page-title-sec">
	<h2 class="page-title"><?=$title?></h2>
</div>
<div class="admin-page-sec">
	<h3 class="presentation-list-tit"><?=$p_day?> 설명회 예약</h3>
	<?=form_open('homeAdm/presentation_user_update', 'class="BD-check-form"')?>
	<input type="hidden" name="p_reserve" value="presentation" />
	<input type="hidden" name="mode" value="modify_single" />
	<input type="hidden" name="pmode" value="<?=$pmode?>" />
	<input type="hidden" name="day"	value="<?=$page_day?>" />
	<input type="hidden" name="page" value="<?=$page?>" />
	<input type="hidden" name="orig_p_id" value="<?=$result[0]->p_id?>" />	
	<input type="hidden" name="u_id" value="<?=$u_id?>" />
	<dl class="BD-write-skinA">
	<dt><label for="p_id">*참가설명회</label></dt>
	<dd>
	<?php if(isset($p_list) && $p_list) : ?>	
		<select name="p_id" id="p_id">
		<?php if($result[0]->p_day < date('Y-m-d H:i:s', time())) :?>
			<option value="<?=$result[0]->p_id?>">[<?=$p_day?> 설명회종료]</option>
		<?php endif ?>
		<?php foreach($p_list as $val) : ?>
			<option value="<?=$val->p_id?>" <?php if($result[0]->p_id == $val->p_id) echo 'selected="selected"';?>>
				<?php if($val->p_use == 'no') echo '[종료]'; ?> <?=fnc_replace_getday(explode(" ", $val->p_day)[0])?> <?=fnc_replace_gettime(explode(" ", $val->p_day)[1])?> [<?=fnc_set_htmls_strip($val->p_location)?> - <?=fnc_set_htmls_strip($val->p_place)?>]
			</option>
		<?php endforeach ?>	
		</select>
	<?php else : ?>
		<span id="p_id">등록된 설명회가 없습니다.</span>
	<?php endif ?>
	</dd>
	<dt><label for="u_name">*이름</label></dt>
	<dd><input type="text" name="u_name" value="<?=fnc_set_htmls_strip($result[0]->u_name)?>" id="u_name" class="checkInput" /></dd>
	<dt><label for="u_name_en">이름(영문)</label></dt>
	<dd><input type="text" name="u_name_en" value="<?=fnc_set_htmls_strip($result[0]->u_name_en)?>" id="u_name_en" /></dd>
	<dt><label for="u_phone">*휴대폰번호</label></dt>
	<dd><input type="text" name="u_phone" value="<?=fnc_set_htmls_strip($result[0]->u_phone)?>" id="u_phone" class="checkInput phoneNumCheck" placeholder="010-0000-0000" /></dd>
	<dt><label for="u_state">학생 거주국가</label></dt>
	<dd><input type="text" name="u_state" id="u_state" value="<?=fnc_set_htmls_strip($result[0]->u_state)?>" class="" placeholder="학생거주국가" /></dd>
	<dt>학생학력</dt>
	<dd><?=fnc_none_spacae($result[0]->u_aca)?></dd>
	<dt>관심분야</dt>
	<dd><?=(empty($result[0]->u_field))?'선택안함':fnc_none_spacae($result[0]->u_field)?></dd>
	<dt><label for="u_attend">참석여부</label></dt>
	<dd>
		<select  name="u_attend" id="u_attend">
			<option value="no" <?php if($result[0]->u_attend == 'no')echo 'selected="selected";'?>>no</option>
			<option value="yes" <?php if($result[0]->u_attend == 'yes')echo 'selected="selected";'?>>yes</option>
		</select>
	</dd>
	<dt><label for="u_description">상담기록</label></dt>
	<dd>
		<div style="width:80%; padding:5px; border:1px solid #ccc; background:#fff">
			<textarea name="u_description" id="u_description" style="width:100%; height:300px; border:0 none; resize:none; vertical-align:top; padding:0; margin:0"><?=fnc_set_htmls_strip(str_replace('\r\n', PHP_EOL, $result[0]->u_description))?></textarea>
		</div>
	</dd>
	</dl>
	<div class="admin-btn-sec2">
		<input type="submit" value="수정하기" class="admin-btn" />
		<a href="<?=site_url()?>homeAdm/presentation_day/" class="admin-btn-atag">설명회 일정보기</a>
		<a href="<?=site_url()?>homeAdm/presentation" class="admin-btn-atag">예약자 전체 목록</a>
		<a href="<?=site_url()?>homeAdm/presentation/view/<?=$result[0]->p_id?>/<?=$page?>" class="admin-btn-atag"><?=$p_day?> 예약자 목록</a>	
	</div>
	</form>
</div>