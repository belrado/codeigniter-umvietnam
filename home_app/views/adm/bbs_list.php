<div class="page-title-sec marketing-tit">
	<h2 class="page-title"><?=$title?></h2>
</div>
<div class="admin-page-sec">
	<h3 class="sub-title">게시판 등록/수정</h3>
	<div class="admin-btn-sec">
		<a href="/homeAdm/bbs_update/insert" class="admin-btn-atag">게시판 추가</a>
	</div>
	<?php
	$frm_action = '/homeAdm/bbs_delete/';
	echo form_open($frm_action);
	?>
		<table class="admin-table">
			<colgroup>
				<col style="width:5%" />
				<col style="width:19%" />
				<col style="width:19%" />
				<col style="width:19%" />
				<col style="width:19%" />
				<col style="width:19%" />
			</colgroup>
			<thead>
				<tr>
					<th scope="col"><?php if($bbs_result) : ?><input type="checkbox" id="chk" onclick="check_all(this)" /><?php else : ?>/<?php endif ?></th>
					<th scope="col">TABLE</th>
					<th scope="col">게시판 제목</th>
					<th scope="col">게시판 분류</th>
					<th scope="col">게시판타입</th>
					<th scope="col">게시판관리</th>
				</tr>
			</thead>
			<tbody>
			<?php if($bbs_result) : ?>
			<?php foreach($bbs_result as $val) : ?>
				<tr>
					<td><input type="checkbox" value="<?=$val->bbs_table?>" name="chk[]" /></td>
					<td><?=$val->bbs_table?></td>
					<td><?=$val->bbs_name_ko?> (<?=$val->bbs_css_type?>)</td>
					<td><?=$val->bbs_cate_list?></td>
					<td><?=$val->bbs_type?></td>
					<td>
						<a href="/homeAdm/bbs_update/modify/<?=$val->bbs_table?>" class="table-btn">수정</a>
						<a href="<?=site_url()?>board/list/<?=$val->bbs_table?>" target="_blank" class="table-btn">게시판바로가기</a>
					</td>
				</tr>
			<?php endforeach ?>
			<?php else : ?>
				<tr><td colspan="6">등록된 게시판이 없습니다.</td></tr>
			<?php endif ?>
			</tbody>
		</table>
		<div class="admin-btn-sec2">
		<?php if($bbs_result) : ?>
			<input type="submit" value="선택삭제" class="admin-btn" />
		<?php endif ?>
			<a href="/homeAdm/bbs_update/insert" class="admin-btn-atag">게시판 추가</a>
		</div>
	</form>
</div>
