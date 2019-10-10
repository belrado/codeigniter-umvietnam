<div class="page-title-sec">
	<h2 class="page-title"><?=$title?></h2>
</div>
<div class="admin-page-sec admin-popup-wrap">
	<?=form_open_multipart(site_url().'homeAdm/popup_update', 'class="BD-check-form"')?>
		<input type="hidden" value="<?=$popup_mode?>" name="popup_mode" />
		<div class="admin-btn-sec2">
			<input type="button" value="이벤트 추가" class="admin-btn" id="add_popevent" />
		</div>
		<ul id="popevent_list" class="popevent_list">
		<?php if($popup_event) : $pop_len = 0; ?>
			<?php foreach($popup_event as $val) : ?>
			<li class="popevent-box">
				<fieldset>
				<input type="hidden" name="popevent_index[]" value="<?=$pop_len?>" />
				<p class="marginB10"><label><input type="checkbox" name="popevent_del_<?=$pop_len?>" value="del" />: 선택삭제</label></p>
				<dl class="BD-write-skinA">
				<dt><label for="pop_subject_ko_<?=$pop_len?>">*팝업제목(ko)</label></dt>
				<dd><input type="text" value="<?=fnc_set_htmls_strip($val['pop_subject_ko'])?>" name="pop_subject_ko_<?=$pop_len?>" id="pop_subject_ko_<?=$pop_len?>" class="checkInput" /></dd>
				<dt><label for="pop_subject_en_<?=$pop_len?>">*팝업제목(en)</label></dt>
				<dd><input type="text" value="<?=fnc_set_htmls_strip($val['pop_subject_en'])?>" name="pop_subject_en_<?=$pop_len?>" id="pop_subject_en_<?=$pop_len?>" class="checkInput" /></dd>
				<dt><label for="pop_subject_vn_<?=$pop_len?>">*팝업제목(vn)</label></dt>
				<dd><input type="text" value="<?=fnc_set_htmls_strip($val['pop_subject_vn'])?>" name="pop_subject_vn_<?=$pop_len?>" id="pop_subject_vn_<?=$pop_len?>" class="checkInput" /></dd>
				<dt><label for="pop_class_<?=$pop_len?>">팝업창 Class</label></dt>
				<dd><input type="text" value="<?=fnc_set_htmls_strip($val['pop_class'])?>" id="pop_class_<?=$pop_len?>" name="pop_class_<?=$pop_len?>" /></dd>
				<dt><label for="pop_text_ko_<?=$pop_len?>">팝업설명(ko)</label></dt>
				<dd><input type="text" value="<?=fnc_set_htmls_strip($val['pop_text_ko'])?>" name="pop_text_ko_<?=$pop_len?>" id="pop_text_ko_<?=$pop_len?>" class="" /></dd>
				<dt><label for="pop_text_en_<?=$pop_len?>">팝업설명(en)</label></dt>
				<dd><input type="text" value="<?=fnc_set_htmls_strip($val['pop_text_en'])?>" name="pop_text_en_<?=$pop_len?>" id="pop_text_en_<?=$pop_len?>" class="" /></dd>
				<dt><label for="pop_text_vn_<?=$pop_len?>">팝업설명(vn)</label></dt>
				<dd><input type="text" value="<?=fnc_set_htmls_strip($val['pop_text_vn'])?>" name="pop_text_vn_<?=$pop_len?>" id="pop_text_vn_<?=$pop_len?>" class="" /></dd>
				<dt><label for="pop_useday_<?=$pop_len?>">노출기간</label></dt>
				<dd><input type="text" value="<?=fnc_set_htmls_strip($val['pop_useday'])?>" name="pop_useday_<?=$pop_len?>" id="pop_useday_<?=$pop_len?>" class="" /></dd>
				<dt><label for="pop_viewtype_<?=$pop_len?>">텍스트만보이기</label></dt>
				<dd><input type="checkbox" name="pop_viewtype_<?=$pop_len?>" id="pop_viewtype_<?=$pop_len?>" <?=($val['pop_viewtype']=='onlytext')?'checked="checked"':''?>  value="onlytext" /><?=$val['pop_viewtype']?></dd>
				<dt><label for="pop_img_ko_<?=$pop_len?>">팝업이미지(ko)</label></dt>
				<dd>
					<input type="hidden" value="<?=fnc_set_htmls_strip($val['pop_orig_name_ko'])?>" name="pop_orig_name_ko_<?=$pop_len?>" />
					<input type="hidden" value="<?=fnc_set_htmls_strip($val['pop_file_name_ko'])?>" name="pop_file_name_ko_<?=$pop_len?>" />
					<input type="hidden" value="<?=fnc_set_htmls_strip($val['pop_file_path_ko'])?>" name="pop_file_path_ko_<?=$pop_len?>" />
					<input type="hidden" value="<?=fnc_set_htmls_strip($val['pop_full_path_ko'])?>" name="pop_full_path_ko_<?=$pop_len?>" />
					<p>등록된 이미지 : <?=$val['pop_orig_name_ko']?></p>
					<div><img src="<?=fnc_set_htmls_strip($val['pop_file_path_ko'])?>" alt="<?=fnc_set_htmls_strip($val['pop_subject_ko'])?>" width="200" /></div>
					<input type="file" name="pop_img_ko_<?=$pop_len?>[]" id="pop_img_ko_<?=$pop_len?>" class="" />
				</dd>
				<dt><label for="pop_alt_ko_<?=$pop_len?>">대체텍스트(ko)</label></dt>
				<dd><textarea name="pop_alt_ko_<?=$pop_len?>" id="pop_alt_ko_<?=$pop_len?>"><?=fnc_set_htmls_strip($val['pop_alt_ko'])?></textarea></dd>
				<dt><label for="pop_img_en_<?=$pop_len?>">팝업이미지(en)</label></dt>
				<dd>
					<input type="hidden" value="<?=fnc_set_htmls_strip($val['pop_orig_name_en'])?>" name="pop_orig_name_en_<?=$pop_len?>" />
					<input type="hidden" value="<?=fnc_set_htmls_strip($val['pop_file_name_en'])?>" name="pop_file_name_en_<?=$pop_len?>" />
					<input type="hidden" value="<?=fnc_set_htmls_strip($val['pop_file_path_en'])?>" name="pop_file_path_en_<?=$pop_len?>" />
					<input type="hidden" value="<?=fnc_set_htmls_strip($val['pop_full_path_en'])?>" name="pop_full_path_en_<?=$pop_len?>" />
					<p>등록된 이미지 : <?=$val['pop_orig_name_en']?></p>
					<div><img src="<?=fnc_set_htmls_strip($val['pop_file_path_en'])?>" alt="<?=fnc_set_htmls_strip($val['pop_subject_en'])?>" width="200" /></div>
					<input type="file" name="pop_img_en_<?=$pop_len?>[]" id="pop_img_en_<?=$pop_len?>" class="" />
				</dd>
				<dt><label for="pop_alt_en_<?=$pop_len?>">대체텍스트(en)</label></dt>
				<dd><textarea name="pop_alt_en_<?=$pop_len?>" id="pop_alt_en_<?=$pop_len?>"><?=fnc_set_htmls_strip($val['pop_alt_en'])?></textarea></dd>
				<dt><label for="pop_img_vn_<?=$pop_len?>">팝업이미지(vn)</label></dt>
				<dd>
					<input type="hidden" value="<?=fnc_set_htmls_strip($val['pop_orig_name_vn'])?>" name="pop_orig_name_vn_<?=$pop_len?>" />
					<input type="hidden" value="<?=fnc_set_htmls_strip($val['pop_file_name_vn'])?>" name="pop_file_name_vn_<?=$pop_len?>" />
					<input type="hidden" value="<?=fnc_set_htmls_strip($val['pop_file_path_vn'])?>" name="pop_file_path_vn_<?=$pop_len?>" />
					<input type="hidden" value="<?=fnc_set_htmls_strip($val['pop_full_path_vn'])?>" name="pop_full_path_vn_<?=$pop_len?>" />
					<p>등록된 이미지 : <?=$val['pop_orig_name_vn']?></p>
					<div><img src="<?=fnc_set_htmls_strip($val['pop_file_path_vn'])?>" alt="<?=fnc_set_htmls_strip($val['pop_subject_vn'])?>" width="200" /></div>
					<input type="file" name="pop_img_vn_<?=$pop_len?>[]" id="pop_img_vn_<?=$pop_len?>" class="" />
				</dd>
				<dt><label for="pop_alt_vn_<?=$pop_len?>">대체텍스트(en)</label></dt>
				<dd><textarea name="pop_alt_vn_<?=$pop_len?>" id="pop_alt_vn_<?=$pop_len?>"><?=fnc_set_htmls_strip($val['pop_alt_vn'])?></textarea></dd>
				<dt><label for="pop_link_<?=$pop_len?>">링크</label></dt>
				<dd><input type="text" value="<?=fnc_set_htmls_strip($val['pop_link'])?>" name="pop_link_<?=$pop_len?>" id="pop_link_<?=$pop_len?>" class="" /></dd>
				<dt><label for="pop_target_<?=$pop_len?>">링크  타켓</label></dt>
				<dd>
					<select name="pop_target_<?=$pop_len?>" id="pop_target_<?=$pop_len?>">
						<option value="_self" <?php if(fnc_set_htmls_strip($val['pop_target']) == '_self') echo 'selected="selected"';?>>현재창</option>
						<option value="_blank" <?php if(fnc_set_htmls_strip($val['pop_target']) == '_blank') echo 'selected="selected"';?>>새창</option>
					</select></dd>
				</dl>
				</fieldset>
				<div class="updown-box">
					<input type="button" class="popevent-up" value="up" />
					<input type="button" class="popevent-down" value="down" />
				</div>
			</li>
			<?php $pop_len++; endforeach ?>
		<?php else : ?>
			<li class="popevent-box">
				<fieldset>
				<input type="hidden" name="popevent_index[]" value="0" />
				<dl class="BD-write-skinA">
				<dt><label for="pop_subject_ko_0">* 팝업제목(ko)</label></dt>
				<dd><input type="text" name="pop_subject_ko_0" id="pop_subject_ko_0" class="checkInput" /></dd>
				<dt><label for="pop_subject_en_0">* 팝업제목(en)</label></dt>
				<dd><input type="text" name="pop_subject_en_0" id="pop_subject_en_0" class="checkInput" /></dd>
				<dt><label for="pop_subject_vn_0">* 팝업제목(vn)</label></dt>
				<dd><input type="text" name="pop_subject_vn_0" id="pop_subject_vn_0" class="checkInput" /></dd>
				<dt><label for="pop_text_ko_0">팝업설명(ko)</label></dt>
				<dd><input type="text" name="pop_text_ko_0" id="pop_text_ko_0" class="" /></dd>
				<dt><label for="pop_text_en_0">팝업설명(en)</label></dt>
				<dd><input type="text" name="pop_text_en_0" id="pop_text_en_0" class="" /></dd>
				<dt><label for="pop_text_vn_0">팝업설명(vn)</label></dt>
				<dd><input type="text" name="pop_text_vn_0" id="pop_text_vn_0" class="" /></dd>
				<dt><label for="pop_class_0">팝업창클래스</label></dt>
				<dd><input type="text" name="pop_class_0" id="pop_class_0" class="" /></dd>
				<dt><label for="pop_useday_0">노출기간</label></dt>
				<dd><input type="text" name="pop_useday_0" id="pop_useday_0" class="" /></dd>
				<dt><label for="pop_viewtype_0">텍스트만보이기</label></dt>
				<dd><input type="checkbox" name="pop_viewtype_0" id="pop_viewtype_0" value="onlytext" class="pop_viewtype" /></dd>
				<dt><label for="pop_img_ko_0">* 팝업이미지(ko)</label></dt>
				<dd><input type="file" name="pop_img_ko_0[]" id="pop_img_ko_0" class="checkInput" /></dd>
				<dt><label for="pop_img_en_0">* 팝업이미지(en)</label></dt>
				<dd><input type="file" name="pop_img_en_0[]" id="pop_img_en_0" class="checkInput" /></dd>
				<dt><label for="pop_img_vn_0">* 팝업이미지(vn)</label></dt>
				<dd><input type="file" name="pop_img_vn_0[]" id="pop_img_vn_0" class="checkInput" /></dd>
				<dt><label for="pop_alt_ko_0">대체텍스트(ko)</label></dt>
				<dd><textarea name="pop_alt_ko_0" id="pop_alt_ko_0"></textarea></dd>
				<dt><label for="pop_alt_en_0">대체텍스트(en)</label></dt>
				<dd><textarea name="pop_alt_en_0" id="pop_alt_en_0"></textarea></dd>
				<dt><label for="pop_alt_vn_0">대체텍스트(vn)</label></dt>
				<dd><textarea name="pop_alt_vn_0" id="pop_alt_vn_0"></textarea></dd>
				<dt><label for="pop_link_0">링크</label></dt>
				<dd><input type="text" name="pop_link_0" id="pop_link_0" class="" /></dd>
				<dt><label for="pop_target_0">링크  타켓</label></dt>
				<dd>
					<select name="pop_target_0" id="pop_target_0">
						<option value="_self">현재창</option>
						<option value="_blank">새창</option>
					</select>
				</dd>
				</dl>
				</fieldset>
			</li>
		<?php endif ?>
		</ul>
		<div class="admin-btn-sec2">
			<input type="submit" value="팝업등록 및 수정" class="admin-btn" />
		</div>
	</form>
</div>
<script>
	var popevent_list = $('#popevent_list');
	var popevent_html = function(idx){
		var idx = (idx)?idx:1;
		var html = '<li><fieldset><input type="hidden" name="popevent_index[]" value="'+idx+'" /><dl class="BD-write-skinA">';
		html	+= '<dt><label for="pop_subject_ko_'+idx+'">*팝업제목(ko)</label></dt>';
		html	+= '<dd><input type="text" name="pop_subject_ko_'+idx+'" id="pop_subject_ko_'+idx+'" class="checkInput" /></dd>';
		html	+= '<dt><label for="pop_subject_en_'+idx+'">*팝업제목(en)</label></dt>';
		html	+= '<dd><input type="text" name="pop_subject_en_'+idx+'" id="pop_subject_en_'+idx+'" class="checkInput" /></dd>';
		html	+= '<dt><label for="pop_subject_vn_'+idx+'">*팝업제목(vn)</label></dt>';
		html	+= '<dd><input type="text" name="pop_subject_vn_'+idx+'" id="pop_subject_vn_'+idx+'" class="checkInput" /></dd>';
		html	+= '<dt><label for="pop_class_'+idx+'">팝업창 Class</label></dt>';
		html	+= '<dd><input type="text" value="" id="pop_class" name="pop_class_'+idx+'" /></dd>';
		html	+= '<dt><label for="pop_text_ko_'+idx+'">팝업설명(ko)</label></dt>';
		html	+= '<dd><input type="text" name="pop_text_ko_'+idx+'" id="pop_text_ko_'+idx+'" class="" /></dd>';
		html	+= '<dt><label for="pop_text_en_'+idx+'">팝업설명(en)</label></dt>';
		html	+= '<dd><input type="text" name="pop_text_en_'+idx+'" id="pop_text_en_'+idx+'" class="" /></dd>';
		html	+= '<dt><label for="pop_text_vn_'+idx+'">팝업설명(vn)</label></dt>';
		html	+= '<dd><input type="text" name="pop_text_vn_'+idx+'" id="pop_text_vn_'+idx+'" class="" /></dd>';
		html	+= '<dt><label for="pop_useday_'+idx+'">노출기간</label></dt>';
		html	+= '<dd><input type="text" name="pop_useday_'+idx+'" id="pop_useday_'+idx+'" class="" /></dd>';
		html	+= '<dt><label for="pop_viewtype_'+idx+'">텍스트만보이기</label></dt>';
		html	+= '<dd><input type="checkbox" name="pop_viewtype_'+idx+'" id="pop_viewtype_'+idx+'" value="onlytext" class="pop_viewtype" /></dd>';
		html	+= '<dt><label for="pop_img_ko_'+idx+'">*팝업이미지(ko)</label></dt>';
		html	+= '<dd><input type="file" name="pop_img_ko_'+idx+'[]" id="pop_img_ko_'+idx+'" class="" /></dd>';
		html	+= '<dt><label for="pop_alt_ko_'+idx+'">대체텍스트(ko)</label></dt>';
		html	+= '<dd><textarea name="pop_alt_ko_'+idx+'" id="pop_alt_ko_'+idx+'"></textarea></dd>';
		html	+= '<dt><label for="pop_img_en_'+idx+'">*팝업이미지(en)</label></dt>';
		html	+= '<dd><input type="file" name="pop_img_en_'+idx+'[]" id="pop_img_en_'+idx+'" class="" /></dd>';
		html	+= '<dt><label for="pop_alt_en_'+idx+'">대체텍스트(en)</label></dt>';
		html	+= '<dd><textarea name="pop_alt_en_'+idx+'" id="pop_alt_en_'+idx+'"></textarea></dd>';
		html	+= '<dt><label for="pop_img_vn_'+idx+'">*팝업이미지(vn)</label></dt>';
		html	+= '<dd><input type="file" name="pop_img_vn_'+idx+'[]" id="pop_img_vn_'+idx+'" class="" /></dd>';
		html	+= '<dt><label for="pop_alt_vn_'+idx+'">대체텍스트(ko)</label></dt>';
		html	+= '<dd><textarea name="pop_alt_vn_'+idx+'" id="pop_alt_vn_'+idx+'"></textarea></dd>';
		html	+= '<dt><label for="pop_link_'+idx+'">링크</label></dt>';
		html	+= '<dd><input type="text" name="pop_link_'+idx+'" id="pop_link_'+idx+'" class="" /></dd>';
		html	+= '<dt><label for="pop_target_'+idx+'">링크  타켓</label></dt>';
		html	+= '<dd><select name="pop_target_'+idx+'" id="pop_target_'+idx+'"><option value="_self">현재창</option><option value="_blank">새창</option></select></dd>';
		html 	+= '</dl></fieldset><input type="button" value="삭제" class="del-popevent-list" /></ li>';
		return html;
	}
	$('#add_popevent').on({
		click:function(){
			var idx = popevent_list.find('li').length;
			popevent_list.append(popevent_html(idx));
		}
	});
	popevent_list.on('click', '.del-popevent-list', function(){
		var org_idx = $(this).index();
		$(this).closest('li').remove();
		popevent_list.find('li').each(function(){
			var _this = $(this);
			if(_this.find('.del-popevent-list').length>0){
				var idx = $(this).index();
				_this.find('label').each(function(){
					var old_name = $(this).attr('for');
					var new_name = old_name.replace(/_\d+$/, '_'+idx);
					$(this).attr('for', new_name);
					$(this).closest('li').find('#'+old_name).attr('id', new_name).attr('name', new_name);
				});
				var filename = _this.find('input[type="file"]').attr('name');
				_this.find('input[type="file"]').attr('name', filename+'[]');
			}
		});
	});
var set_popevent_list_index = function(list){
	if(!list) return false;
	try{
		list.each(function(idx){
			var _idx = idx;
			$(this).find('input[name="popevent_index[]"]').val(idx);
			$(this).find('input, textarea').each(function(){
				var name = $(this).attr('name');
				if(name){
					var res = name.replace(/\d{1,2}|\d{1,2}[]$/g, _idx);
					$(this).attr('name', res);
				}
			});
		});
	}catch(e){return false}
};
	$('.popevent-up').on({
		click:function(){
			var elem = $(this).closest('.popevent-box');
			var len = elem.index();
			if(len>0){
				var clone_elem = elem.clone(true);
				popevent_list.find('.popevent-box:eq('+(len-1)+')').before(clone_elem);
				elem.remove();
				set_popevent_list_index(popevent_list.children());
			}else{
				alert('제일 첫번째 팝업창입니다.');
			}
		}
	});
	$('.popevent-down').on({
		click:function(){
			var elem = $(this).closest('.popevent-box');
			var len = elem.index();
			var maxlen = popevent_list.children().length;
			if(len>=maxlen-1){
				alert('제일 마지막 팝업창입니다.');
			}else{
				var clone_elem = elem.clone(true);
				popevent_list.find('.popevent-box:eq('+(len+1)+')').after(clone_elem);
				elem.remove();
				set_popevent_list_index(popevent_list.children());
			}
		}
	});
	$('.pop_viewtype').on({
		click:function(){
			var _this = $(this);
			var parent = _this.closest('dl');
			if(_this.prop('checked')){
				parent.find('input[type="file"]').removeClass('checkInput');
			}else{
				parent.find('input[type="file"]').addClass('checkInput');
			}
		}
	});
</script>
