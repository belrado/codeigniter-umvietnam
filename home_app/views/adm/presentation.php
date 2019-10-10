<div class="page-title-sec">
	<h2 class="page-title"><?=$title?></h2>
</div>
<div class="admin-page-sec">
	<div class="presentation-list-tit">
		<h3><?=$p_day_txt?> - <?=$title?> 목록</h3>
	</div>
	<div class="presentation-search-sec">
		<form action="<?=site_url()?>homeAdm/presentation/view/all/<?=$page?>/" method="get">
			<select name="stype">
				<option value="u_name" <?php if($stype=='u_name') echo 'selected="selected"';?>>이름</option>
				<option value="u_phone" <?php if($stype=='u_phone') echo 'selected="selected"';?>>연락처</option>
				<option value="u_email" <?php if($stype=='u_email') echo 'selected="selected"';?>>이메일</option>
			</select>
			<input type="text" value="<?=$svalue?>" name="svalue" />
			<input type="submit" value="검색" />
		</form>
	</div>	
	<div class="presentation-search-sec">
	<?php if(isset($list_result) && $list_result) : ?>
		<div class="modify-btn-sec">
			<a href="<?=site_url()?>homeAdm/presentation_day" class="admin-btn-atag">설명회/간담회 일정</a>
			<?php if($day !== 'all') : ?>
			<a href="<?=site_url()?>homeAdm/presentation" class="admin-btn-atag">전체예약자</a>
			<?php endif ?>
		<?php if($pmode == 'modify') : ?>
			<a href="<?=site_url()?>homeAdm/presentation/view/<?=$day?>/<?=$page?>/?stype=<?=$stype?>&amp;svalue=<?=$svalue?>" class="admin-btn-atag"><?=$p_day_txt?> 예약자 목록</a>
		<?php else : ?>
			<a href="<?=site_url()?>homeAdm/presentation/modify/<?=$day?>/<?=$page?>/?stype=<?=$stype?>&amp;svalue=<?=$svalue?>" class="admin-btn-atag"><?=$p_day_txt?> 예약자 간편 수정</a>
		<?php endif ?>
		</div>
	<?php endif ?>
	<?php if(isset($list_result) && $list_result) : ?> 
		<?=form_open('homeAdm/presentation_excel', 'class="BD-check-form exceldown-form"')?>
		<input type="hidden" name="p_reserve" value="presentation" />
		<?php if($day == 'all') : ?>
			<label class="blind" for="p_begin">시작일</label><input type="text" name="p_begin" class="datepicker" id="p_begin" /> ~ 
			<label class="blind" for="p_end">시작일</label><input type="text" name="p_end" class="datepicker" id="p_end" />
			<input type="submit" value="Excel파일 다운" />
		<?php else : ?>
			<input type="hidden" name="p_begin" value="<?=explode(" ", $list_result[0]->p_day)[0]?>" />
			<input type="hidden" name="p_end" value="<?=explode(" ", $list_result[0]->p_day)[0]?>" />
			<input type="submit" value="<?=$p_day_txt?> Excel파일 다운" />
		<?php endif ?>
		</form>
	<?php endif ?>
	</div>
	<?php if($pmode == 'modify') : ?>
	<p class="w​arning-msg">* 간편 모드로 수정 시 각 설명회/간담회 일정의 예약자 중복검사가 중지됩니다.</p>
	<?php endif ?>
	<?=form_open('homeAdm/presentation_user_update', 'class="BD-check-form"')?>
	<?php if($pmode == 'modify') : ?>
	<input type="hidden" name="mode" value="modify" />
	<?php else : ?>
	<input type="hidden" name="mode" value="delete" />	
	<?php endif ?>
	<input type="hidden" name="pmode" value="modify" />
	<input type="hidden" name="p_reserve" value="presentation" />
	<input type="hidden" name="day"	value="<?=$day?>" />
	<input type="hidden" name="page" value="<?=$page?>" />
		<table class="admin-table">
		<colgroup>
			<col style="width:4%" />
			<col style="width:12%" />
			<col style="width:14%" />
			<col style="width:16%" />
			<col style="width:24%" />
			<col style="width:16%" />
			<col style="width:6%" />
			<col style="width:8%" />
		</colgroup>
		<thead>
			<tr>
				<th>선택</th>
				<th scope="col">이름</th>
				<th scope="col">연락처</th>
				<th scope="col">학생 거주국가</th>
				<th scope="col">설명회/간담회일정</th>
				<th scope="col">등록일</th>
				<th scope="col">참석여부</th>
				<th scope="col">상세</th>
				<?php if($pmode == 'modify') : ?>

				<?php endif ?>

				<?php if($pmode == 'view') : ?>

				<?php endif ?>
			</tr>
		</thead>
		<tbody>
		<?php if(isset($list_result) && $list_result) : ?>
			<?php $ulen = 0; foreach($list_result as $val) : ?>
			<?php
			$paritycheck='';
			for($t=0; $t<count($list_day_arr); $t++){
				if($list_day_arr[$t] == $val->p_day){
					$paritycheck=($t%2==0)?'even':'odd';
				}	
			}
			?>				
			<?php if($pmode == 'modify') : ?>
			<tr class="<?=$paritycheck?>">
				<td><input type="checkbox" value="<?=$val->u_id?>" name="u_chk[]" class="u_chk <?=($ulen==0)?'checkboxRequried':''?>" /><br /><?=$list_num?></td>
				<td>
					<?php if(is_numeric($day) && $list_num > ($val->p_entry)) : ?>
					<!-- // 정해진 참석 인원보다 많아진다면 예비 참석자로 표시 // -->
					[예비 참석자]<br />
					<?php endif ?>
					<input type="text" value="<?=fnc_set_htmls_strip($val->u_name)?>" name="u_name_<?=$val->u_id?>" class="checkInput full-input" />
					<input type="text" value="<?=fnc_set_htmls_strip($val->u_name_en)?>" name="u_name_en_<?=$val->u_id?>" class="full-input" placeholder="영문이름" />
				</td>
				<td><input type="text" value="<?=fnc_set_htmls_strip($val->u_phone)?>" name="u_phone_<?=$val->u_id?>" class="checkInput phoneNumCheck full-input" placeholder="010-0000-0000" /></td>
				<td><input type="text" value="<?=fnc_set_htmls_strip($val->u_state)?>" name="u_email_<?=$val->u_id?>" class="full-input" placeholder="거주국가" /></td>
				<td>
					<?php if($p_list) : ?>
					<div style="margin:0 0 10px 0">
					<select name="p_id_<?=$val->u_id?>">
					<?php foreach($p_list as $pval) : ?>
					<option value="<?=$pval->p_id?>" <?=($pval->p_id == $val->p_id)?'selected="selected"':''?>>
						<?=($pval->p_use=='no')?'[종료]':''?> <?=fnc_replace_getday(explode(" ", $pval->p_day)[0])?> <?=fnc_replace_gettime(explode(" ", $pval->p_day)[1])?> [<?=fnc_set_htmls_strip($pval->p_location)?> - <?=fnc_set_htmls_strip($pval->p_place)?>]
					</option>
					<?php endforeach ?>
					</select>
					</div>
					<?php endif ?>
					<?php $p_day = explode(" ", fnc_set_htmls_strip($val->p_day)); ?>
					<p><?=($val->p_use == 'no')?'[종료]':''?>[<?=fnc_set_htmls_strip($val->p_location)?>] <?=fnc_replace_getday($p_day[0])?> <?=fnc_replace_gettime($p_day[1])?></p>
					<p><?=fnc_set_htmls_strip($val->p_place)?></p>
				</td>
				<td><?=fnc_set_htmls_strip($val->u_register)?></td>
				<td>
					<select name="u_attend_<?=$val->u_id?>">
						<option value="no" <?php if($val->u_attend == 'no')echo 'selected="selected"';?>>no</option>
						<option value="yes" <?php if($val->u_attend == 'yes')echo 'selected="selected"';?>>yes</option>
					</select>
				</td>
				<td>
					<a href="<?=site_url()?>homeAdm/presentation_view/<?=$val->p_id?>/<?=$val->u_id?>">상세내용보기</a>
					<?php if(!empty($val->u_description)) : ?>
					<br />[상담기록]
					<?php endif ?>
				</td>
			</tr>
			<?php else : ?>				
			<tr class="<?=$paritycheck?>">
				<td><input type="checkbox" value="<?=$val->u_id?>" name="u_chk[]" class="u_chk <?=($ulen==0)?'checkboxRequried':''?>" /><br /><?=$list_num?></td>
				<td>					
					<?php if(is_numeric($day) && $list_num > ($val->p_entry)) : ?>
					<!-- // 정해진 참석 인원보다 많아진다면 예비 참석자로 표시 // -->
					[예비 참석자]<br />
					<?php endif ?>
					<?=fnc_set_htmls_strip($val->u_name)?><br />
					<?=fnc_set_htmls_strip($val->u_name_en)?>
				</td>
				<td><?=fnc_set_htmls_strip($val->u_phone)?></td>
				<td><?=fnc_set_htmls_strip($val->u_state)?></td>
				<td>
					<?php $p_day = explode(" ", fnc_set_htmls_strip($val->p_day)); ?>
					<p>[<?=fnc_set_htmls_strip($val->p_location)?>] <?=fnc_replace_getday($p_day[0])?> <?=fnc_replace_gettime($p_day[1])?></p>
					<p><?=fnc_set_htmls_strip($val->p_place)?></p>
					<p style="color:#999"><?=($val->p_day < date('Y-m-d H:i:s', time()))?'[종료]':''?><?=($val->p_use == 'no')?'[사용안함]':''?></p>
				</td>
				<td><?=fnc_set_htmls_strip($val->u_register)?></td>
				<td><?=fnc_set_htmls_strip($val->u_attend)?></td>
				<td>
					<a href="<?=site_url()?>homeAdm/presentation_view/<?=$val->p_id?>/<?=$val->u_id?>/?pmode=<?=$pmode?>&amp;day=<?=$day?>&amp;page=<?=$page?>">상세내용보기</a>
					<?php if(!empty($val->u_description)) : ?>
					<br />[상담기록]
					<?php endif ?>
				</td>
			</tr>	
			<?php endif ?>
			<?php $ulen++; $list_num--; endforeach ?>
		<?php else : ?>
			<tr>
				<td colspan="8"><?=$title?>가 없습니다.</td>
			</tr>
		<?php endif ?>
		</tbody>
		</table>
		<div style="padding:10px 0 0 0">
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
		<a href="<?=site_url()?>homeAdm/presentation_day" class="admin-btn-atag">설명회/간담회 일정</a>
		<a href="<?=site_url()?>homeAdm/presentation" class="admin-btn-atag">전체예약자</a>
		</div>
	</form>
</div>
<?php if($day == 'all') : ?>
<link rel="stylesheet" href="//code.jquery.com/ui/1.11.4/themes/smoothness/jquery-ui.css">
<script src="/assets/js/jquery-ui.min.js"></script>
<script>
(function($){
	$(document).ready(function(){
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
		$('.exceldown-form').submit(function(){
			var register_begine = ($(this).find('#register_begine').val()) ? parseInt($(this).find('#register_begine').val().replace(/-/gi,"")) : 0;
			var register_end	= ($(this).find('#register_end').val()) ? parseInt($(this).find('#register_end').val().replace(/-/gi,"")) : 0;
			if(register_begine > register_end && register_end != 0){
				alert('엑셀파일 다운로드 시작일보다 종료일이 더 큽니다.');
				return false;
			}
			var submitBtn = $(this).find('input[type="submit"]');
			if(submitBtn.hasClass('is_downloading')){
				return false;	
			}
			submitBtn.addClass('is_downloading').val('다운로드 중 입니다...');
			setInterval(function(){
				location.href='/homeAdm/presentation/<?=$pmode?>/<?=$day?>/<?=$page?>';
			},1000);
		});
	});
})(jQuery);
</script>
<?php else : ?>
<script>
(function($){
	$(document).ready(function(){
		$('.exceldown-form').submit(function(){
			var submitBtn = $(this).find('input[type="submit"]');
			if(submitBtn.hasClass('is_downloading')){
				return false;	
			}
			submitBtn.addClass('is_downloading').val('다운로드 중 입니다...');
			setInterval(function(){
				location.href='/homeAdm/presentation/<?=$pmode?>/<?=$day?>/<?=$page?>';
			},1000);
		});
	});
})(jQuery);
</script>	
<?php endif ?>
<script>
(function($){
	$(document).ready(function(){
		$('.u_chk').click(function(){
			if($(this).is(':checked') == true){
				$(this).closest('tr').addClass('selecttr');
			}else{
				$(this).closest('tr').removeClass('selecttr');
			}
		});
		$('#presentation-register-view').on({
			click:function(){
				if(!$(this).hasClass('open')){
					$(this).addClass('open').val('등록창 닫기');
					$('#presentation-register-sec').addClass('open');
				}else{
					$(this).removeClass('open').val('등록창 열기');
					$('#presentation-register-sec').removeClass('open');
				}
			}
		});
	});
})(jQuery)
</script>