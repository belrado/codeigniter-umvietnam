<?php
//echo chr(ord('A')+25);
?>
<div class="page-title-sec marketing-tit">
	<h2 class="page-title"><?=$title?></h2>
</div>
<div class="admin-page-sec">
	<h3 class="sub-title">게시판 등록/수정</h3>
	<?php
	$frm_action = '/homeAdm/bbs_update/'.$mode.'/'.$bbs_table;
	$hidden = array('bbs_mode'=>$mode);
	echo form_open($frm_action, 'class="BD-check-form"', $hidden)?>
	<dl class="BD-write-skinA">
		<dt><label for="bbs_table">TABLE</label></dt>
		<dd>
			<?php if($mode == 'insert') : ?><p>영문자, 숫자, _ 만 가능 (공백없이 3~20자 이내)</p><?php endif ?>
			<input type="text" name="bbs_table" value="<?=$bbs_table?>" class="checkInput tableNameCheck" id="bbs_table" <?php if($mode == 'modify') : ?>readonly="readonly"<?php endif ?> /></dd>
		<dt><label for="bbs_name_ko">게시판 제목(ko)</label></dt>
		<dd><input type="text" value="<?=$bbs_name_ko?>" name="bbs_name_ko" class="checkInput" id="bbs_name_ko" /></dd>
		<dt><label for="bbs_name_en">게시판 제목(en)</label></dt>
		<dd><input type="text" value="<?=$bbs_name_en?>" name="bbs_name_en" class="checkInput" id="bbs_name_en" /></dd>
		<dt><label for="bbs_name_vn">게시판 제목(vn)</label></dt>
		<dd><input type="text" value="<?=$bbs_name_vn?>" name="bbs_name_vn" class="checkInput" id="bbs_name_vn" /></dd>
		<dt><label for="bbs_type">게시판 타입</label></dt>
		<dd>
			<select name="bbs_type" id="bbs_type">
				<option value="list" <?php if($bbs_type == 'list') echo 'selected="selected"'; ?>>리스트(기본방식)</option>
				<option value="list_img" <?php if($bbs_type == 'list_img') echo 'selected="selected"'; ?>>리스트 이미지</option>
				<option value="toggle" <?php if($bbs_type == 'toggle') echo 'selected="selected"'; ?>>토글</option>
				<option value="qna" <?php if($bbs_type == 'qna') echo 'selected="selected"'; ?>>QNA</option>
				<option value="youtube" <?php if($bbs_type == 'youtube') echo 'selected="selected"'; ?>>유투브</option>
			</select>
		</dd>
		<dt><label for="bbs_css_type">게시판스타일</label></dt>
		<dd>
			<select name="bbs_css_type">
				<option value="bbs_typeA" <?php if(isset($bbs_css_type) && $bbs_css_type == 'bbs_typeA') echo 'selected="selected"'; ?>>bbs_typeA</option>
				<option value="bbs_typeB" <?php if(isset($bbs_css_type) && $bbs_css_type == 'bbs_typeB') echo 'selected="selected"'; ?>>bbs_typeB</option>
				<option value="bbs_user_type" <?php if(isset($bbs_css_type) && $bbs_css_type == 'bbs_user_type') echo 'selected="selected"'; ?>>bbs_user_type</option>
			</select>
		</dd>
		<dt><label for="bbs_sort_type">게시판정렬방식</label></dt>
		<dd>
			<select name="bbs_sort_type" id="bbs_sort_type">
				<option value="sort_asc" <?php if(isset($bbs_sort_type) && $bbs_sort_type == 'sort_asc') echo 'selected="selected"'; ?>>최신등록순</option>
				<option value="sort_day" <?php if(isset($bbs_sort_type) && $bbs_sort_type == 'sort_day') echo 'selected="selected"'; ?>>등록날짜순</option>
			</select>
		</dd>
		<?php if(isset($nav_1depth) && !empty($nav_1depth)) : ?>
		<dt><label for="bbs_1depth">상위메뉴</label></dt>
		<dd>
			<select name="bbs_1depth" id="bbs_1depth">
				<option value="0">없음</option>
				<?php foreach($nav_1depth as $val) : ?>
				<option value="<?=$val->nav_id?>"
					<?php if($bbs_1depth == $val->nav_id) echo "selected='selected'"; ?>><?=$val->nav_name_ko?>
				</option>
				<?php endforeach ?>
			</select>
		</dd>
		<?php endif ?>
		<dt><label for="bbs_cate_list">게시판 분류</label></dt>
		<dd>
			<p>분류와 분류 사이는 | 로 구분하세요. (예: 질문|답변) 첫자로 #|은 입력하지 마세요. (예: #질문|#답변, |질문|답변 [X])</p>
			<input type="text" value="<?=$bbs_cate_list?>" name="bbs_cate_list" class="" id="bbs_cate_list" />
		</dd>
		<dt><label for="bbs_adm_lv">관리 권한</label></dt>
		<dd>
		<select name="bbs_adm_lv" id="bbs_adm_lv">
		<?php for($i=7; $i<10; $i++) : ?>
			<option <?php if(isset($bbs_adm_lv) && $bbs_adm_lv == $i) echo "selected='selected'"; ?> value="<?=$i?>">
				Lv:<?=$i?>
				<?php
					if($i==1){
						echo '[비회원]';
					}else if($i>1 && $i<7){
						echo '[회원 등급:'.($i-1).']';
					}else if($i>=7 && $i<10){
						echo '[관리자 등급:'.($i-6).']';
					}else if($i>=10){
						echo '[최고 관리자]';
					}
				?>
			</option>
		<?php endfor ?>
		</select>
		</dd>
		<dt><label for="bbs_list_lv">목록보기 권한</label></dt>
		<dd>
		<select name="bbs_list_lv" id="bbs_list_lv">
		<?php for($j=1; $j<=10; $j++) : ?>
			<option <?php if($bbs_list_lv == $j) echo "selected='selected'"; ?> value="<?=$j?>">
				Lv:<?=$j?>
				<?php
					if($j==1){
						echo '[비회원]';
					}else if($j>1 && $j<7){
						echo '[회원 등급:'.($j-1).']';
					}else if($j>=7 && $j<10){
						echo '[관리자 등급:'.($j-6).']';
					}else if($j>=10){
						echo '[최고 관리자]';
					}
				?>
			</option>
		<?php endfor ?>
		</select>
		</dd>
		<dt><label for="bbs_read_lv">읽기 권한</label></dt>
		<dd>
			<select name="bbs_read_lv" id="bbs_read_lv">
			<?php for($k=1; $k<=10; $k++) : ?>
				<option <?=($bbs_read_lv==$k)?'selected="selected"':''?> value="<?=$k?>">
				Lv:<?=$k?>
				<?php
					if($k==1){
						echo '[비회원]';
					}else if($k>1 && $k<7){
						echo '[회원 등급:'.($k-1).']';
					}else if($k>=7 && $k<10){
						echo '[관리자 등급:'.($k-6).']';
					}else if($k>=10){
						echo '[최고 관리자]';
					}
				?>
				</option>
			<?php endfor ?>
			</select>
		</dd>
		<dt><label for="bbs_write_lv">쓰기 권한</label></dt>
		<dd>
			<select name="bbs_write_lv" id="bbs_write_lv">
			<?php for($h=2; $h<=10; $h++) : ?>
				<option <?=($bbs_write_lv == $h)?'selected="selected"':''?> value="<?=$h?>">
					Lv:<?=$h?>
				</option>
			<?php endfor ?>
			</select>
		</dd>
		<dt><label for="bbs_comment_lv">댓글 권한</label></dt>
		<dd>
			<select name="bbs_comment_lv">
				<?php for($i=0; $i<=6; $i++) : if($i==1) continue; ?>
				<option value="<?=$i?>" <?=($bbs_comment_lv==$i)?'selected="selected"':''?>><?=$i?><?=($i==0)?' [댓글사용안함]':' [회원전용]'?></option>
				<?php endfor ?>
			</select>
		</dd>
		<dt><label for="bbs_list_num">목록수</label></dt>
		<dd><input type="text" value="<?=$bbs_list_num?>" name="bbs_list_num" class="checkInput numCheck" id="bbs_list_num" /></dd>
		<dt><label for="bbs_feed">게시판 Rss</label></dt>
		<dd>
			<select name="bbs_feed" id="bbs_feed">
				<option value="yes" <?php if($bbs_feed == 'yes') echo "selected='selected'"?>>사용</option>
				<option value="no" <?php if($bbs_feed == 'no') echo "selected='selected'"?>>미사용</option>
			</select>
		</dd>
		<dt><label for="bbs_page_tophtml">상단html</label></dt>
		<dd>
			<textarea id="bbs_page_tophtml" name="bbs_page_tophtml"><?=$bbs_page_tophtml?></textarea>
		</dd>
	</dl>
	<div class="admin-btn-sec">
		<input type="submit" value="<?php if($mode == 'insert') : ?>게시판 생성<?php else : ?>게시판 수정<?php endif ?>" class="admin-btn" />
		<a href="/homeAdm/bbs/" class="admin-btn-atag">게시판 목록</a>
	</div>
	</form>
</div>
