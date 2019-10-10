<div class="page-title-sec">
	<h2 class="page-title"><?=$title?></h2>
</div>
<div class="admin-page-sec">
	<h3>일정등록</h3>
	<?=form_open('homeAdm/presentation_update', 'class="BD-check-form"')?>
		<input type="hidden" name="mode" value="insert" />	
		<ul id="briefing-list" class="briefing-list">
		<li>
			<dl>
			<dt>설명회</dt>
			<dd>
				<label>타입
				<select name="p_type[]">
					<option value="presentation">설명회</option>
					<option value="conference">간담회</option>
				</select>
				</label>
				<label>타이틀 <input type="text" name="p_name[]" class="checkInput input-place" placeholder="필수입력" /></label>
				<label>참석가능팀 <input type="text" name="p_entry[]" class="numCheck input-num" maxlength="3" /></label>
				<select name="p_use[]">
					<option value="yes">사용</option>
					<option value="no">종료</option>
				</select>
			</dd>
			<dt>설명회 일정</dt>
			<dd>
				<label>날자 <input type="text" name="p_day[]" class="datepicker checkInput" placeholder="필수입력" /></label>
				<label>시간 <input type="text" name="p_time[]" class="timepicker checkInput" placeholder="필수입력" /></label>
			</dd>
			<dt>설명회 장소</dt>
			<dd>
				<label>주소 <input type="text" name="p_address[]" class="checkInput input-place" placeholder="필수입력" /></label>
				<label> 장소 <input type="text" name="p_place[]" class="checkInput input-place2" placeholder="필수입력" /></label>
				<label> 지역 <input type="text" name="p_location[]" class="input-place2" /></label>
			</dd>
			<dt>지도 좌표</dt>
			<dd>
				<label>x좌표 <input type="text" name="p_posx[]" class="checkInput" placeholder="필수입력" /></label>
				<label>y좌표 <input type="text" name="p_posy[]" class="checkInput" placeholder="필수입력" /></label>
			</dd>
			</dl>
		</li>	
		</ul>
		<div>
			<input type="button" value="추가" id="add_briefing_day" class="admin-btn" /> <input type="submit" value="저장" class="admin-btn" />
		</div>
	</form>
</div>
<div class="admin-page-sec">
	<h3>설명회</h3>
	<div class="presentation-search-sec">
	<?php if(isset($list_result) && $list_result) : ?> 
		<div class="modify-btn-sec">
		<?php if($pmode == 'modify') : ?>
			<a href="<?=site_url()?>homeAdm/presentation_day/view/<?=$page?>?begin=<?=$begin?>&amp;end=<?=$end?>" class="admin-btn-atag">설명회 일정 보기</a>
		<?php else : ?>
			<a href="<?=site_url()?>homeAdm/presentation_day/modify/<?=$page?>?begin=<?=$begin?>&amp;end=<?=$end?>" class="admin-btn-atag">설명회 일정 수정</a>
		<?php endif ?>
		</div>
	<?php endif ?>	
		<form method="get" action="<?=site_url()?>homeAdm/presentation_day/<?=$pmode?>/<?=$page?>">
			<label class="blind" for="begin">시작일</label><input type="text" name="begin" value="<?=$begin?>" class="datepicker" id="begin" /> ~ 
			<label class="blind" for="end">시작일</label><input type="text" name="end" value="<?=$end?>" class="datepicker" id="end" />
			<input type="submit" value="검색" />
		</form>
	</div>
	<?=form_open('homeAdm/presentation_update', 'class="BD-check-form"')?>
	<?php if($pmode == 'modify') : ?>
	<input type="hidden" name="mode" value="modify" />
	<?php else : ?>
	<input type="hidden" name="mode" value="delete" />	
	<?php endif ?>
	<input type="hidden" name="fmode" value="modify" />
	<input type="hidden" name="page" value="<?=$page?>" />
	<input type="hidden" name="begin" value="<?=$begin?>" />
	<input type="hidden" name="end" value="<?=$end?>" />
		<table class="admin-table">
		<colgroup>
			<col style="width:3%" />
			<col style="width:23%" />
			<col style="width:6%" />
			<col style="width:13%" />
			<col style="width:34%" />
			<col style="width:6%" />
			<col style="width:6%" />
			<col style="width:9%" />
		</colgroup>
		<thead>
			<tr>
				<th>선택</th>
				<th scope="col">설명회/간담회</th>
				<th scope="col">지역</th>
				<th scope="col">일정</th>
				<th scope="col">장소</th>
				<th scope="col">참석가능팀</th>
				<th scope="col">사용유무</th>
				<?php if($pmode == 'modify') : ?>
				<th scope="col">좌표</th>
				<?php endif ?>
				<?php if($pmode == 'view') : ?>
				<th scope="col">관리</th>
				<?php endif ?>
			</tr>
		</thead>
		<tbody>
		<?php if(isset($list_result) && $list_result) : ?>
			<?php foreach($list_result as $val) : ?>
			<?php if($pmode == 'modify') : ?>
			<tr>
				<td>
					<input type="hidden" value="<?=fnc_set_htmls_strip($val->p_type)?>" name="p_type_<?=$val->p_id?>" />
					<input type="checkbox" value="<?=$val->p_id?>" name="p_chk[]" class="p_chk" />
				</td>
				<td><input type="text" value="<?=fnc_set_htmls_strip($val->p_name)?>" name="p_name_<?=$val->p_id?>" class="full-input" /></td>
				<td><input type="text" value="<?=fnc_set_htmls_strip($val->p_location)?>" name="p_location_<?=$val->p_id?>" class="full-input" /></td>
				<td><input type="text" value="<?=fnc_set_htmls_strip($val->p_day)?>" name="p_day_<?=$val->p_id?>" class="full-input" /></td>
				<td>
					<div style="margin:0 0 5px 0"><input type="text" value="<?=fnc_set_htmls_strip($val->p_address)?>" name="p_address_<?=$val->p_id?>" class="full-input" /></div>
					<input type="text" value="<?=fnc_set_htmls_strip($val->p_place)?>" name="p_place_<?=$val->p_id?>" class="full-input" />
				</td>
				<td><input type="text" value="<?=fnc_set_htmls_strip($val->p_entry)?>" name="p_entry_<?=$val->p_id?>" class="num-inputS" maxlength="3" /></td>
				<td>
					<select name="p_use_<?=$val->p_id?>">
						<option value="yes" <?php if($val->p_use == 'yes')echo 'selected="selected"';?>>사용</option>
						<option value="no" <?php if($val->p_use == 'no')echo 'selected="selected"';?>>종료</option>
					</select>
				</td>
				<td>
					<div style="margin:0 0 5px 0"><input type="text" value="<?=$val->p_posx?>" name="p_posx_<?=$val->p_id?>" class="full-input" /></div>
					<input type="text" value="<?=$val->p_posy?>" name="p_posy_<?=$val->p_id?>" class="full-input" />
				</td>
			</tr>
			<?php else : ?>
			<tr>
				<td><input type="checkbox" value="<?=$val->p_id?>" name="p_chk[]" class="p_chk" /></td>
				<td><?=fnc_set_htmls_strip($val->p_name)?></td>
				<td><?=fnc_set_htmls_strip($val->p_location)?></td>
				<td>
					<?php $p_day = explode(" ", fnc_set_htmls_strip($val->p_day)); ?>
					<?=fnc_replace_getday($p_day[0])?> <?=fnc_replace_gettime($p_day[1])?>
				</td>
				<td><?=fnc_set_htmls_strip($val->p_address)?> - <?=fnc_set_htmls_strip($val->p_place)?>
					<p style="color:#999"><?=($val->p_day < date('Y-m-d H:i:s', time()))?'[종료]':''?><?=($val->p_use == 'no')?'[사용안함]':''?></p>
				</td>
				<td><?=fnc_set_htmls_strip($val->p_entry)?></td>
				<td><?=fnc_set_htmls_strip($val->p_use)?></td>
				<td><a href="<?=site_url()?>homeAdm/presentation/view/<?=$val->p_id?>">등록자보기 (<?=$val->p_user_total?> 명)</a></td>
			</tr>	
			<?php endif ?>
			<?php endforeach ?>
		<?php else : ?>
			<tr>
				<td colspan="8"><?=$begin?>~<?=$end?> 등록된 설명회가 없습니다.</td>
			</tr>
		<?php endif ?>
		</tbody>
		</table>
		<div>
			<?=$paging_show?>
		</div>
		<div class="admin-btn-sec2">
		<?php if(isset($list_result) && $list_result) : ?>	
		<?php if($pmode == 'modify') : ?>
		<input type="submit" value="선택수정" class="admin-btn" />
		<?php else : ?>
		<input type="submit" value="선택삭제" class="admin-btn" />	
		<?php endif ?>
		<?php endif ?>
		<a href="<?=site_url()?>homeAdm/presentation_day" class="admin-btn-atag">전체일정보기</a>
		<a href="<?=site_url()?>homeAdm/presentation" class="admin-btn-atag">전체예약자보기</a>
		</div>
	</form>
</div>
<link rel="stylesheet" href="//code.jquery.com/ui/1.11.4/themes/smoothness/jquery-ui.css">
<link rel="stylesheet" href="//cdn.rawgit.com/fgelinas/timepicker/master/jquery.ui.timepicker.css">
<script src="/assets/js/jquery-ui.min.js"></script>
<script src='//cdn.rawgit.com/fgelinas/timepicker/master/jquery.ui.timepicker.js'></script>
<script>
(function($){
	$(document).ready(function(){
		var briefing_list = $('#briefing-list');
		var elem_clone = '<li><dl><dt>설명회</dt><dd>';
		elem_clone += ' <label>타입 <select name="p_type[]"><option value="presentation">설명회</option><option value="conference">간담회</option></select></label>';
		elem_clone += ' <label>타이틀 <input type="text" name="p_name[]" class="checkInput input-place" placeholder="필수입력" /></label>';
		elem_clone += ' <label>참석가능팀 <input type="text" name="p_entry[]" class="numCheck input-num" maxlength="3" /></label>';
		elem_clone += ' <select name="p_use[]"><option value="yes">사용</option><option value="no">종료</option></select></dd>';
		elem_clone += '<dt>설명회 일정</dt><dd><label>날자 <input type="text" name="p_day[]" class="datepicker checkInput" placeholder="필수입력" /></label>';
		elem_clone += '<label>시간 <input type="text" name="p_time[]" class="timepicker checkInput" placeholder="필수입력" /></label></dd>';
		elem_clone += '<dt>설명회 장소</dt><dd><label>주소 <input type="text" name="p_address[]" class="checkInput input-place" placeholder="필수입력" /></label>';
		elem_clone += '<label> 장소 <input type="text" name="p_place[]" class="checkInput input-place2" placeholder="필수입력" /></label>';
		elem_clone += '<label> 지역 <input type="text" name="p_location[]" class="input-place2" /></label></dd>';
		elem_clone += '<dt>지도 좌표</dt><dd><label>x좌표 <input type="text" name="p_posx[]" class="checkInput" placeholder="필수입력" /></label>';
		elem_clone += '<label>y좌표 <input type="text" name="p_posy[]" class="checkInput" placeholder="필수입력" /></label></dd></dl><input type="button" value="del" class="remove-briefing" /></li>';
				
		$(".datepicker").datepicker({
		    dateFormat: 'yy-mm-dd',
		    prevText: '이전 달',
		    nextText: '다음 달',
		    monthNames: ['1월','2월','3월','4월','5월','6월','7월','8월','9월','10월','11월','12월'],
		    monthNamesShort: ['1월','2월','3월','4월','5월','6월','7월','8월','9월','10월','11월','12월'],
		    dayNames: ['일','월','화','수','목','금','토'],
		    dayNamesShort: ['일','월','화','수','목','금','토'],
		    dayNamesMin: ['일','월','화','수','목','금','토'],
		    showMonthAfterYear: true,
		    changeMonth: true,
		    changeYear: true,
		    yearSuffix: '년'
		});
		$(".timepicker").timepicker();
		$("#add_briefing_day").on({
		  	click:function(){
				briefing_list.append(elem_clone);
				$(document).find(".datepicker").removeClass('hasDatepicker').datepicker({
					dateFormat: 'yy-mm-dd',
				    prevText: '이전 달',
				    nextText: '다음 달',
				    monthNames: ['1월','2월','3월','4월','5월','6월','7월','8월','9월','10월','11월','12월'],
				    monthNamesShort: ['1월','2월','3월','4월','5월','6월','7월','8월','9월','10월','11월','12월'],
				    dayNames: ['일','월','화','수','목','금','토'],
				    dayNamesShort: ['일','월','화','수','목','금','토'],
				    dayNamesMin: ['일','월','화','수','목','금','토'],
				    showMonthAfterYear: true,
				    changeMonth: true,
				    changeYear: true,
				    yearSuffix: '년'
				});
				$(document).find('.timepicker').removeClass('hasTimepicker').timepicker(); 					  		
		  	}
		});
		$(document).on('click', '.remove-briefing', function(){
			$(this).parent('li').remove();
		});
		$('.p_chk').click(function(){
			if($(this).is(':checked') == true){
				$(this).closest('tr').addClass('selecttr');
			}else{
				$(this).closest('tr').removeClass('selecttr');
			}
		});
	});
})(jQuery)
</script>