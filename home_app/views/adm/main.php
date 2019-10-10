<strong class="main-time-sec page-tit">
	<?=$adm_name?> [ <span id="view_time_sec"></span> ]
</strong>
<div class="admin-page-sec">
<script>
	console.log(document.cookie);
</script>	
	<h2 class="presentation-list-tit">차단 id</h2>
	<?=form_open(site_url().'homeAdm/admin_block_user/')?>
	<input type="hidden" name="type" value="block_id" />
	<ul class="block-list">
	<?php if(count($block_id_list)> 0) : ?>
		<?php for($k=0; $k<count($block_id_list); $k++) : ?>
		<li><label class="list-box"><input type="checkbox" name="blockchk[]" value="<?=$k?>" /><?=$block_id_list[$k]?></label></li>	
		<?php endfor ?>
	<?php else : ?>
		<li><span class="list-box">차단된 id가 없습니다.</span></li>	
	<?php endif ?>	
	</ul>
	<?php if(count($block_id_list)> 0) : ?>
	<div class="admin-btn-sec2">
		<input type="submit" value="선택 제외" class="admin-btn" />
	</div>
	<?php endif ?>
	</form>
	<?=form_open(site_url().'homeAdm/admin_block_user/')?>
	<input type="hidden" name="type" value="block_ip" />
	<h2 class="presentation-list-tit">차단 ip</h2>
	<ul class="block-list">
	<?php if(count($block_ip_list)> 0) : ?>
		<?php for($k=0; $k<count($block_ip_list); $k++) : ?>
		<li><label class="list-box"><input type="checkbox" name="blockchk[]" value="<?=$k?>" /><?=$block_ip_list[$k]?></label></li>
		<?php endfor ?>
	<?php else : ?>
		<li><span class="list-box">차단된 ip가 없습니다.</span></li>	
	<?php endif ?>	
	</ul>
	<?php if(count($block_ip_list)> 0) : ?>
	<div class="admin-btn-sec3">
		<input type="submit" value="선택 제외" class="admin-btn" />
	</div>
	<?php endif ?>
	</form>
</div>
<script>
var view_time_sec = getIds('view_time_sec');
var get_now_time = function(){
	var nowdate = new Date();
	return nowdate.getFullYear()+'-'+(nowdate.getMonth()+1)+'-'+nowdate.getDate()+' '+nowdate.getHours()+':'+nowdate.getMinutes()+':'+nowdate.getSeconds();
}
var set_now_time = function(){
	view_time_sec.innerHTML=get_now_time();
	setTimeout(function(){
		set_now_time();
	}, 1000);
}
set_now_time();
</script>