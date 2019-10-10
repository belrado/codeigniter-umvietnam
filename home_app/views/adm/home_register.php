<div class="page-title-sec">
	<h2 class="page-title"><?=$title?></h2>
</div>
<div class="admin-page-sec">
	<ul class="home_register_list">
	<?php if($list_result) : ?>
		<?php foreach($list_result as $val) : ?>
		<li class="home_register_elem">
			<article class="inner-box">
				<header class="elem_header">
					<?=fnc_set_htmls_strip($val->register_name)?>
					<?=fnc_set_htmls_strip($val->register_school)?>
					<?=fnc_set_htmls_strip($val->register_grade)?>
					님의 수강신청
				</header>
				<div class="elem_contents">
					<table class="admin-table">
						<colgroup>
							<col style="width:15%" />
							<col style="width:35%" />
							<col style="width:15%" />
							<col style="width:35%" />
						</colgroup>
						<tr>
							<th scope="col" colspan="4" class="full-title">기본정보</th>
						</tr>
						<tr>
							<th scope="row">학생 이름</th>
							<td class="align-left"><?=fnc_set_htmls_strip($val->register_name)?></td>
							<th scope="row">학교명 &amp; 학력</th>
							<td class="align-left"><?=fnc_set_htmls_strip($val->register_school)?> - <?=fnc_set_htmls_strip($val->register_grade)?></td>
						</tr>
						<tr>
							<th scope="row">학생 전화</th>
							<td class="align-left"><?=fnc_set_htmls_strip($val->register_phone)?></td>
							<th scope="row">학생 이메일</th>
							<td class="align-left"><?=fnc_set_htmls_strip($val->register_email)?></td>
						</tr>
						<tr>
							<th scope="row">학부모 이름</th>
							<td class="align-left"><?=fnc_set_htmls_strip($val->register_parent)?></td>
							<th scope="row">학생과의 관계</th>
							<td class="align-left"><?=fnc_set_htmls_strip($val->parents_type)?></td>
						</tr>
						<tr>
							<th scope="row">학부모 전화</th>
							<td class="align-left"><?=fnc_set_htmls_strip($val->register_phone_parent)?></td>
							<th scope="row">학부모 이메일</th>
							<td class="align-left"><?=fnc_set_htmls_strip($val->register_email_parent)?></td>
						</tr>
						<tr>
							<th scope="col" colspan="4" class="full-title">수강정보</th>
						</tr>
						<tr>
							<th scope="row">프로그램</th>
							<td class="align-left"><?=fnc_set_htmls_strip($val->class_select)?></td>
							<th scope="row">수강과목</th>
							<td class="align-left"><?=fnc_set_htmls_strip($val->special_lecture)?></td>
						</tr>
						<tr>
							<th scope="col" colspan="4" class="full-title">추가정보</th>
						</tr>
						<tr>
							<th scope="row">거주지역</th>
							<td class="align-left"><?=fnc_set_htmls_strip($val->register_local)?></td>
							<th scope="row">공인성적</th>
							<td class="align-left">
								<ul class="score-list">
									<li>SAT: <?=fnc_set_htmls_strip($val->register_sat)?></li>
									<li>TOEFL: <?=fnc_set_htmls_strip($val->register_toefl)?></li>
									<li>ACT: <?=fnc_set_htmls_strip($val->register_act)?></li>
									<li>AP/SATⅡ: <?=fnc_set_htmls_strip($val->register_ap)?></li>
								</ul>									
							</td>
						</tr>
						<tr>
							<th scope="row">문의내용</th>
							<td colspan="3" class="align-left">
								<?=nl2br(fnc_set_htmls_strip($val->register_content))?>
							</td>
						</tr>
					</table>
				</div>
				<footer class="elem_footer">
					<?=fnc_replace_getday(explode(' ', fnc_set_htmls_strip($val->register_time))[0])?>
				</footer>
			</article>
		</li>	
		<?php endforeach ?>
	<?php else : ?>
		<li>등록된 수강신청이 없습니다.</li>
	<?php endif ?>
	</ul>
	<div>
		<?=$paging_show?>
	</div>
</div>
<script>
	$('.home_register_list>li').on({
		click:function(){
			if($(this).hasClass('active')){
				$(this).removeClass('active');
			}else{
				$(this).addClass('active');
			}
		}
	});
</script>