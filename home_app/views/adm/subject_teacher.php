<div class="page-title-sec">
	<h2 class="page-title"><?=$title?></h2>
</div>
<div class="admin-page-sec">
	<h3>과목 &amp; 강사 등록</h3>
	<?=form_open(site_url().'homeAdm/subject/teacher')?>
	<input type="button" value="add" id="add_list" />
		<ul id="insert_subject_form">
			<li>
				<select name="s_d2_id[]">
				<?php foreach($subject_data  as $val) : ?>
					<option value="<?=$val->s_d2_id?>">&nbsp;&nbsp;<?=fnc_set_htmls_strip($val->s_d1_name)?> <?=($val->s_d2_name)?' - '.fnc_set_htmls_strip($val->s_d2_name):''?>&nbsp;&nbsp;</option>
				<?php endforeach ?>
				</select>
				<select name="t_id[]">
				<?php foreach($teacher_data  as $val) : ?>
					<option value="<?=$val->t_id?>">&nbsp;&nbsp;<?=fnc_set_htmls_strip($val->t_name)?>&nbsp;&nbsp;</option>
				<?php endforeach?>
				</select>
                <input type="text" value="0" name="sl_index[]" />
			</li>
		</ul>
		<div>
			<input type="submit" value="insert" />
		</div>
	</form>
</div>

<div class="admin-page-sec">
	<h3>과목 &amp; 강사 목록</h3>
	<table class="admin-table">
		<?php
		$prev_data = '';
		$prev_data2 = '';
		$prev_data3 = '';
		foreach($subject_list as $key=>$val) : ?>
		<tr>
			<?php if($prev_data !== $val->s_d1_name) :
				$same_num=0;
				for($i=$key; $i<count($subject_list); $i++){
					if($val->s_d1_name === $subject_list[$i]->s_d1_name){
						$same_num++;
					}else{
						break;
					}
				}
			?>
			<td rowspan="<?=$same_num?>" style="vertical-align:middle"><?=fnc_set_htmls_strip($val->s_d1_name)?></td>
			<?php endif ?>
			<?php if($prev_data2 !== $val->s_d2_name) :
				$same_num2=0;
				for($i=$key; $i<count($subject_list); $i++){
					if($val->s_d2_name === $subject_list[$i]->s_d2_name){
						$same_num2++;
					}else{
						break;
					}
				}
			?>
			<td rowspan="<?=$same_num2?>" style="vertical-align:middle"><?=fnc_set_htmls_strip($val->s_d2_name)?></td>
			<td rowspan="<?=$same_num2?>" style="vertical-align:middle">
				<?php
					$tname_arr = array();
					foreach($subject_list as $sub){
						if($sub->s_d1_name == $val->s_d1_name && $sub->s_d2_name == $val->s_d2_name){
							$tname_arr[] = fnc_set_htmls_strip($sub->t_name);
						}
					}
				?>
				<?=implode(', ', $tname_arr)?>
			</td>
			<?php endif ?>
		</tr>
		<?php
		$prev_data = $val->s_d1_name;
		$prev_data2 = $val->s_d2_name;
		endforeach ?>
	</table>
</div>

<script>
var set_html_layout = function(){
	var html = '<li>';
	html 	+= '';
	html 	+= '';
	html 	+= '';
	html 	+= '';
	html 	+= '';
	html 	+= '';
	html 	+= '</li>';
}
	$('#add_list').on({
		click:function(){
			//var html = set_html_layout();
			html = $('#insert_subject_form>li:first').clone(true);
            var selected_subject=$('#insert_subject_form>li:last').find('select[name="s_d2_id[]"] option:selected').val();
            html.find('select[name="s_d2_id[]"] option[value="'+selected_subject+'"]').attr('selected', true);
			$('#insert_subject_form').append(html);
		}
	});
</script>
