<div class="section-full">
	<div class="section_wrapper">
	<?php if(!$p_result_use) : ?>
		<div class="none-presentation-wrap">
			<div class="page-presentation">
				<div class="none-title-sec">
					<div class="none-title-box">
						<h4 class="none-title">
							<?=$lang_message['no_scheduled_presentation']?>
						</h4>
						<p class="none-text">
							<?=$lang_message['more_info_call_us']?>
						</p>
					</div>
				</div>
				<div class="phone-num-sec">
					<a href="tel:+842837244555" class="phone-num-box phone-vietnam" title="Office : +84.28.3724.4555">
						<p class="phone-num">
							<strong>Office</strong>
							<span>+84.28.3724.4555</span>
						</p>
					</a>
					<a href="tel:+84349705862" class="phone-num-box phone-vietnam" title="Mobile : +84.34.970.5862">
						<p class="phone-num">
							<strong>Mobile</strong>
							<span>+84.34.970.5862</span>
						</p>
					</a>
				</div>
			</div>
		</div>
    <?php else : ?>
		<div class="pos-relative block-section">
			<form action="<?=site_url()?><?=$umv_lang?>/community/info_sessions_update" method="post" class="BD-check-form">
				<input type="hidden" name="<?=$this->security->get_csrf_token_name()?>" value="<?=$this->security->get_csrf_hash()?>" id="<?=$this->security->get_csrf_token_name()?>" />
				<input type="hidden" name="mode" value="insert" />
				<input type="hidden" name="p_reserve" value="presentation" />
				<div class="required-sec">
					<h4 class="content-tit-leftline">
						<?=ucwords($lang_bbs['user_information'])?>
					</h4>
					<p class="required-txt">* <?=$lang_bbs['required']?></p>
				</div>
				<?php if($this->session->userdata('user_id') && !empty($user_info)) : ?>
				<!-- // 회원이라면 회원정보 불러올수 잇게 작업 // -->
				<?php endif ?>
				<div class="home-form support-register-form block-section">
					<div class="form-row">
						<label class="label" for="u_name">
							<span class="blind">
                            	<?=stripslashes($lang_bbs['required'])?>
							</span>
							* <?=stripslashes($lang_presentation['name'])?>
                        </label>
						<div class="input-sec email-sec">
							<div class="email-box email-box2 width175">
								<input type="text" name="u_name" value="<?=$this->session->flashdata('u_name')?>" id="u_name" class="checkInput input-shadow"
								placeholder="<?=stripslashes($lang_presentation['gname'])?>"
								data-label-name="<?=stripslashes($lang_presentation['gname'])?>" />
							</div>
                            <div class="email-box email-box1 width175">
								<input type="text" name="u_name_en" value="<?=$this->session->flashdata('u_name_en')?>" id="u_name_en" class="checkInput input-shadow"
								placeholder="<?=stripslashes($lang_presentation['fname'])?>"
								data-label-name="<?=stripslashes($lang_presentation['fname'])?>" />
							</div>
						</div>
						<?=form_error('u_name', '<div class="input-error">* ', '</div>')?>
                        <?=form_error('u_name_en', '<div class="input-error">* ', '</div>')?>
					</div>
					<div class="form-row">
						<label class="label" for="u_phone">
							<span class="blind">
								<?=stripslashes($lang_bbs['required'])?>
							</span>
							* <?=stripslashes($lang_presentation['phone'])?>
						</label>
						<div class="input-sec">
							<div class="input-box size300">
								<input type="text" name="u_phone" value="<?=$this->session->flashdata('u_phone')?>" maxlength="25" id="u_phone" class="checkInput phoneNumCheck"
								placeholder="010-0000-0000"
								data-label-name="<?=stripslashes($lang_presentation['phone'])?>" />
							</div>
						</div>
						<?=form_error('u_phone', '<div class="input-error">* ', '</div>')?>
					</div>
                    <div class="form-row">
						<label class="label" for="u_city">
							<span class="blind">
								<?=stripslashes($lang_bbs['required'])?>
							</span>
							* <?=stripslashes($lang_presentation['city'])?></label>
						<div class="input-sec">
							<div class="input-box size700">
								<input type="text" name="u_city" value="<?=$this->session->flashdata('u_city')?>" id="u_city" class="checkInput"
								data-label-name="<?=stripslashes($lang_presentation['city'])?>"
								placeholder="<?=stripslashes($lang_presentation['city'])?>" />
							</div>
						</div>
						<?=form_error('u_city', '<div class="input-error">* ', '</div>')?>
					</div>
					<div class="form-row">
						<label class="label" for="u_state">
							<span class="blind">
								<?=stripslashes($lang_bbs['required'])?>
							</span>
							* <?=stripslashes($lang_presentation['country'])?></label>
						<div class="input-sec">
							<div class="input-box size700">
								<input type="text" name="u_state" value="<?=$this->session->flashdata('u_state')?>" id="u_state" class="checkInput"
								data-label-name="<?=stripslashes($lang_presentation['country'])?>"
								placeholder="<?=stripslashes($lang_presentation['country'])?>" />
							</div>
						</div>
						<?=form_error('u_state', '<div class="input-error">* ', '</div>')?>
					</div>
                    <div class="form-row">
						<label class="label" for="u_email">
							<span class="blind">
								<?=stripslashes($lang_bbs['required'])?>
							</span>
							* <?=stripslashes($lang_presentation['email'])?>
						</label>
						<div class="input-sec">
							<div class="input-box size400">
								<input type="text" name="u_email" value="<?=$this->session->flashdata('u_email')?>" id="u_email" class="checkInput"
								data-label-name="<?=stripslashes($lang_presentation['email'])?>"
								placeholder="<?=stripslashes($lang_presentation['email_example'])?>" />
							</div>
						</div>
						<?=form_error('u_email', '<div class="input-error">* ', '</div>')?>
					</div>
					<div class="form-row">
						<label class="label" for="u_aca">
							<span class="blind">
								<?=stripslashes($lang_bbs['required'])?>
							</span>
							* <?=stripslashes($lang_presentation['school'])?>
						</label>
						<div class="input-sec">
							<div class="select-box select-box-big">
								<select name="u_aca" id="u_aca" class="checkInput"  data-label-name="<?=$lang_presentation['school']?>">
									<option value="" <?php if($this->session->flashdata('u_aca')=='학력 선택 안함') echo 'selected="selected"'?>><?=$lang_bbs['select']?></option>
                                    <?php foreach($lang_presentation['school_select'] as $sval) : ?>
                                    <option value="<?=stripslashes($sval)?>" <?php if($this->session->flashdata('u_aca')==(stripslashes($sval)))echo 'selected="selected"'?>><?=stripslashes($sval)?></option>
                                    <?php endforeach ?>
								</select>
								<div class="select-box-ico"></div>
							</div>
						</div>
						<?=form_error('u_aca', '<div class="input-error">* ', '</div>')?>
					</div>
                    <div class="form-row last">
						<label class="label" for="sname"><span class="blind"><?=$lang_bbs['required']?></span>* <?=$lang_presentation['sname']?></label>
						<div class="input-sec">
							<div class="input-box size700">
								<input type="text" name="sname" value="<?=$this->session->flashdata('sname')?>" id="sname" class="checkInput" data-label-name="<?=$lang_presentation['sname']?>" placeholder="<?=$lang_presentation['sname']?>" />
							</div>
						</div>
						<?=form_error('sname', '<div class="input-error">* ', '</div>')?>
					</div>
				</div>
				<div class="required-sec">
					<h4 class="content-tit-leftline">
						<?=ucwords($lang_presentation['select_presentation_txt'])?>
					</h4>
					<p class="required-txt">* <?=$lang_bbs['required']?></p>
				</div>
				<div class="home-form support-register-form last block-section">
					<div class="form-row">
						<label class="label" for="p_id">
							<span class="blind"><?=$lang_bbs['required']?></span>* <?=$lang_presentation['date']?>
						</label>
						<div class="input-sec">
							<div class="select-box select-box-big">
								<select name="p_id" id="p_id" class="checkInput" data-label-name="<?=$lang_presentation['date']?>">
									<option value=""><?=$lang_bbs['select']?></option>
									<?php
									$pindex = 0;
									$selected_pday_index = 0;
									foreach($p_result_use as $val) :
										$p_day = explode(" ", $val->p_day);
										$selected_html = '';
										if($this->session->flashdata('p_id')){
											if($this->session->flashdata('p_id')==$val->p_id){
												$selected_html = 'selected="selected"';
												$selected_pday_index = $pindex;
											}
										}else if(!$this->session->flashdata('p_id') && $main_pchk_day == $val->p_id){
											$selected_html = 'selected="selected"';
											$selected_pday_index = $pindex;
										}
									?>
									<option <?=$selected_html?> value="<?=$val->p_id?>"
										data-btype="<?=fnc_set_htmls_strip($val->p_name)?>"
										data-bday="<?=fnc_replace_getday($p_day[0])?>(<?=fnc_get_dayname($p_day[0])?>) <?=fnc_replace_gettime($p_day[1])?>"
										data-bplace1="<?=fnc_set_htmls_strip($val->p_address)?>"
										data-bplace2="<?=fnc_set_htmls_strip($val->p_place)?>"
										data-bposx="<?=fnc_set_htmls_strip($val->p_posx)?>"
										data-bposy="<?=fnc_set_htmls_strip($val->p_posy)?>">
										[<?=fnc_set_htmls_strip($val->p_location)?>] <?=fnc_replace_getday($p_day[0])?>(<?=fnc_get_dayname($p_day[0])?>) <?=fnc_replace_gettime($p_day[1])?>
									</option>
									<?php $pindex++; endforeach ?>
								</select>
								<div class="select-box-ico"></div>
							</div>
						</div>
					</div>
					<div class="form-row last">
						<div class="label">
							<?=stripslashes($lang_presentation['location'])?>
						</div>
						<div class="input-sec">
							<div class="jsgooglemap">
								<div class="psu-google-map marginB10">
									<div id="google_map" class="google_map_iframe"></div>
								</div>
								<ul class="presentation-view-info">
									<li class="title" id="info-title">
										<?=stripslashes($lang_presentation['plz_select_presentation'])?>
									</li>
									<li class="place" id="info-place">

									</li>
									<li class="day" id="info-day">
										<strong><?=$lang_menu['customer']?></strong>
										<p><?=stripslashes($lang_presentation['call'])?></p>
									</li>
								</ul>
							</div>
							<noscript>
								<ul class="main-presentation-list">
								<?php foreach($p_result_use as $val) : ?>
									<li class="list">
										<strong><?=fnc_replace_getday(explode(' ', $val->p_day)[0])?>(<?=fnc_get_dayname($p_day[0])?>) <?=fnc_replace_gettime(explode(' ', $val->p_day)[1])?></strong>
										<p>
										[<?=fnc_set_htmls_strip($val->p_location)?>]
										<?=fnc_set_htmls_strip($val->p_address)?> -
										<?=fnc_set_htmls_strip($val->p_place)?>
										</p>
									</li>
								<?php endforeach ?>
								</ul>
							</noscript>
						</div>
					</div>
				</div>
				<h4 class="content-tit-leftwon">
					<?=stripslashes($lang_presentation['privacy_policy'])?>
				</h4>
				<div>
					<div class="privacy-policy-txt">
						<div class="agreement-sec">
							<div class="agreement-box">
						<?php if($umv_lang == 'ko') : ?>
							<p class="marginB5">작성해 주신 고객님의 개인정보는 상담 및 정보 안내 외는 사용되지 않습니다.</p>
							<ul>
							<li>1. 수집 이용 목적 : 상담 및 정보 안내, 설명회 예약/방문상담 예약 확인</li>
							<li>2. 수집 항목 : 이름, 연락처, E-mail</li>
							<li>3. 보유 및 이용기간 : 개인정보제공 활용 동의 철회시 까지</li>
							</ul>
						<?php else : ?>
							<?=(str_replace('\r\n', PHP_EOL, stripslashes($agreement->opt_value)))?>
						<?php endif ?>
					</div>
				</div>
					</div>
					<p class="privacy-policy-sec">
						<input type="checkbox" id="privacy-policy" value="agree" class="checkboxCheck" />
						<label class="label" for="privacy-policy"><?=$lang_presentation['agree_privacy_policy']?></label>
					</p>
				</div>
				<div class="home-form-submit-sec">
					<input type="submit" value="<?=$lang_menu['reservation']?>" class="submit-btn">
				</div>
			</form>
		</div>
		<h4 class="content-tit-leftline" id="presentation_r">
			<?=stripslashes($lang_presentation['reservatetion_info'])?>
		</h4>
		<div class="presentation-sec">
			<div class="content-tit-leftwon sub-tit">
				<h5 style="font-weight:400"><?=stripslashes($lang_presentation['app_status_reservatetion'])?></h5>
				<p class="sub-text">(*<?=stripslashes($lang_presentation['reservatetion_del'])?>)</p>
			</div>
			<p class="presentation-call marginB20">
				<?=stripslashes($lang_presentation['call'])?>
			</p>
			<div class="presentation-resec">
			<?php $plen=0; foreach($p_result_use  as $val) : ?>
				<div class="presentation-box">
					<?php $lastclass=($plen == (count($p_result_use)-1))?'presentation-relast':''; ?>
					<div class='title-sec'>
						<strong class="title">
							<?=fnc_replace_getday(explode(" ", $val->p_day)[0])?>(<?=fnc_get_dayname(explode(" ", $val->p_day)[0])?>) <?=fnc_replace_gettime(explode(" ", $val->p_day)[1])?>
							 <span>[<?=$val->p_location?>]<?=$val->p_place?></span>
						</strong>
						<div class="remaining-seat">
							<div class="seat seat1 <?=($val->p_entry - count($val->user_list) > 0)?'':'no_remaining_seat'?>">
								<span class="bgbox total"><?=$lang_bbs['total']?></span>
								<span class="num"><?=$val->p_entry?></span>
								<span class="team"><?=strtolower($lang_presentation['team'])?></span>
							</div>
							<div class="seat seat2 <?=($val->p_entry - count($val->user_list) > 0)?'':'no_remaining_seat'?>">
							<?php if($val->p_entry - count($val->user_list) > 0) : ?>
								<span class="bgbox empty"><?=$lang_presentation['empty']?></span>
								<span class="num"><?=$val->p_entry - count($val->user_list)?></span>
								<span class="team"><?=strtolower($lang_presentation['team'])?></span>
							<?php else : ?>
								<span class="bgbox empty"><?=$lang_presentation['no_remaining_seat']?></span>
								<span class="team">(<?=$lang_presentation['self_application']?>)</span>
							<?php endif ?>
							</div>
						</div>
					</div>
					<ul class="presentation-relist <?=$lastclass?>">
					<?php if($val->user_list) : ?>
						<?php for($j = 0; $j < count($val->user_list); $j++) : ?>
						<?php if($j < $val->p_entry) : ?>
							<li class="<?=($j==($val->p_entry-1))?'user-last':''?>">
								<?=ucfirst(fnc_set_htmls_strip($val->user_list[$j]->u_name_en))?>
								<?=fnc_set_htmls_strip(fnc_name_change($val->user_list[$j]->u_name))?>
								<?=fnc_set_htmls_strip(fnc_phone_change($val->user_list[$j]->u_phone))?>
							</li>
						<?php else : ?>
							<li class='reserve-list'>
								<strong class='sub-title'>
									<?=$lang_presentation['waiting_list']?>
								</strong>
								<ul class="wating-list">
								<?php for($k = $val->p_entry; $k < count($val->user_list); $k++) : ?>
									<li>
										<?=ucfirst(fnc_set_htmls_strip($val->user_list[$k]->u_name_en))?>
										<?=fnc_set_htmls_strip(fnc_name_change($val->user_list[$k]->u_name))?>
										<?=fnc_set_htmls_strip(fnc_phone_change($val->user_list[$k]->u_phone))?>
									</li>
								<?php endfor ?>
								</ul>
							</li>
						<?php break; endif ?>
						<?php endfor ?>
					<?php else : ?>
						<li><?=$lang_presentation['no_reservatetion']?></li>
					<?php endif ?>
					</ul>
				</div>
			<?php $plen++; endforeach ?>
			</div>
		</div>
    <?php endif /* if($p_result_use)  */?>
	</div>
</div>
<?php if($p_result_use) : /* 종료된 설명회 일정안나오게 했는데 이거 나오게 할거면 위치 수정해야함 */ ?>
<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyDizQPN-zEgzXEjxV5ZjbuYGC7pYGFyTic&amp;region=KR"></script>
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
var presentation_email_select = function(){
	var email_select = getIds('email_select');
	var email_write  = getIds('email_write_box');
	var cnt = 1; // 돔로드시 1번 실행하니까 2번부터가 실제적으로 셀렉트 박스 이벤트임
	var event_email_change = function(){
		var email_val = email_select.value;
		if(email_val === 'write'){
			email_write.style.display='block';
			if(cnt > 1) getIds('email_write').focus();
		}else{
			email_write.style.display='none';
		}
		cnt++;
	}
	event_email_change();
	getIds('email_select').onchange = event_email_change;
}
//presentation_email_select();
<?php if($this->session->userdata('user_id') && !empty($user_info)) : ?>
// 회원정보 입력

<?php endif ?>
var start_map_index = parseInt("<?=$selected_pday_index?>");
var infowindow;
var marker = [];
var map;
var pt_info ={
	obj:$('#p_id'),
	title:$('#info-title'),
	day:$('#info-day'),
	place:$('#info-place')
}
var presentation =[];
var p_len = pt_info.obj.children().length;
for(var i=0; i<p_len-1; i++){
	presentation[i] = {
		"b_type"	: $('>option:eq('+(i+1)+')', pt_info.obj).data('btype'),
		"b_day"		: $('>option:eq('+(i+1)+')', pt_info.obj).data('bday'),
		"b_place"	: $('>option:eq('+(i+1)+')', pt_info.obj).data('bplace1'),
		"b_place2"	: $('>option:eq('+(i+1)+')', pt_info.obj).data('bplace2'),
		"b_posx"	: $('>option:eq('+(i+1)+')', pt_info.obj).data('bposx'),
		"b_posy"	: $('>option:eq('+(i+1)+')', pt_info.obj).data('bposy')
	};
}
var myCenter = new google.maps.LatLng(presentation[start_map_index].b_posx, presentation[start_map_index].b_posy);
var set_presentation_info = function(_this, select_elem){
	var type 		= select_elem.data('btype');
	var day 		= select_elem.data('bday');
	var place1  	= select_elem.data('bplace1');
	var place2 		= select_elem.data('bplace2');
	var posx  		= select_elem.data('bposx');
	var posy  		= select_elem.data('bposy');
	moveToDarwin(posx, posy);
	pt_info.title.text(type);
	pt_info.day.text(day);
	pt_info.place.text(place1+' - '+place2);
	infowindow.setContent(place1+'<br />'+place2);
	infowindow.open(map, marker[_this.find(':selected').index()-1]);
}
pt_info.obj.on({
	change:function(){
		if($.trim($(this).val()) !== ''){
			var select_elem = $(this).find(':selected');
			set_presentation_info($(this), select_elem);
	    }else{
			pt_info.title.text('<?=$lang_presentation["plz_select_presentation"]?>');
			pt_info.place.text('');
			pt_info.day.html('<strong><?=$lang_menu['customer']?></strong><p><?=($lang_presentation['call'])?></p>');
		}
	}
});
function initialize() {
	var mapProp = {
		zoom: 14
	   	,center: myCenter
	   	,scrollwheel : true
		,mapTypeControl : false
		,streetViewControl: false
    };
    map=new google.maps.Map(document.getElementById("google_map"),mapProp);
    infowindow =  new google.maps.InfoWindow({
        content: presentation[start_map_index].b_place+'<br />'+presentation[start_map_index].b_place2
    });
	var image = {
    	url:"/assets/img/map_ico.png",
    	size: new google.maps.Size(30, 48),
    	scaledSize: new google.maps.Size(30, 48)
    }
    for(var i = 0, length = presentation.length; i < length; i++){
        var data=presentation[i];
        var latLng = new google.maps.LatLng(data.b_posx, data.b_posy);
        marker[i] = new google.maps.Marker({
            position: latLng,
            map: map,
            icon : image,
            title: data.b_type+' <?=$lang_presentation['title']?>'
        });
        bindInfoWindow(marker[i], map, infowindow, data, i);
    }
    // 겟방식으로 선택값이 넘어 왔다면
    var mainchk = parseInt("<?=$main_pchk_day?>");
    if(mainchk > 0){
		var select_elem = pt_info.obj.find(':selected');
		set_presentation_info(pt_info.obj, select_elem);
    }
    //set_presentation_info
    // 시작시 첳번째 배열에 들어간 정보를 가운데로 춮력
    infowindow.open(map, marker[start_map_index]);
    google.maps.event.addDomListener(window, "resize", function() { //리사이즈에 따른 마커 위치
        var center = map.getCenter();
        google.maps.event.trigger(map, "resize");
        map.setCenter(center);
    });
}
function bindInfoWindow(marker, map, infowindow, data, index) {
    marker.addListener('click', function(){
        infowindow.setContent(data.b_place+'<br />'+data.b_place2);
        infowindow.open(map, this);
        // 설명회 정보 출력
        pt_info.title.text(data.b_type+' <?=$lang_presentation['title']?>');
        pt_info.day.text(data.b_day);
        pt_info.place.text(data.b_place+' - '+data.b_place2);
        // 설명회 예약일 셀렉트박스 선택
        //pt_info.obj.find('option:eq('+index+')').attr('selected','selected');
		var _this_selected_val = pt_info.obj.find('option:eq('+(index+1)+')').val();
		pt_info.obj.val(_this_selected_val)
    });
}
function moveToDarwin(posx, posy) {
  var darwin = new google.maps.LatLng(posx, posy);
  map.setCenter(darwin);
}
google.maps.event.addDomListener(window, 'load', initialize);
// 종료된 설명회일정보기
var show_end_presentation_list = function(sendData){
	$.ajax({
		url:'/support/presentation',
		type:'POST',
		data:sendData,
		dataType:"JSON",
		success:function(data){
			var end_list_html = '';
			if(data.presentation_end_list.length>0){
				$.each(data.presentation_end_list, function(index){
					end_list_html += '<strong class="title">'+this.p_info+'</strong>';
					if(index === (data.presentation_end_list.length-1)){
						end_list_html += '<ul class="presentation-relist presentation-relast">';
					}else{
						end_list_html += '<ul class="presentation-relist">';
					}
					if(this.user_list){
						for(var j = 0; j <this.user_list.length; j++){
							end_list_html += '<li>'+this.user_list[j].u_info+'</li>';
						}
					}else{
						end_list_html += '<li>해당 설명회 참가자가 없습니다.</li>	';
					}
					end_list_html += '</ul>';
				});
			}else{
				end_list_html = '<p class="padding-elem10">'+sendData.more_end_presentation+' 종료된 설명회가 없습니다.</p>';
			}
			$('#end-presentation-list-sec').children().remove();
			$('#end-presentation-list-sec').append(end_list_html);
			$('#csrf_token_home').val(data.bbs_token);
		},
		error:function(xhr, status, error){
			alert('<?=$lang_message['ajax_error_msg']?>');
		}
	});
}
$('#presentation_end_year a').on({
	click:function(e){
		e.preventDefault ? e.preventDefault() : (e.returnValue = false);
		var _this = $(this);
		var sendData = {
			more_end_presentation:$(this).data('pyear'),
			'<?=$this->security->get_csrf_token_name()?>':$('#csrf_token_home').val()
		}
		if(!_this.hasClass('active')){
			$('#presentation_end_year').find('a').removeClass('active');
			_this.addClass('active');
			show_end_presentation_list(sendData);
		}
	}
});

$('.BD-check-form input[type="text"]').on({
	focusout:function(){
		console.log('good')
		set_focusout_input_backgroundcolor($(this), false);
	}
});
</script>
<?php endif ?>
