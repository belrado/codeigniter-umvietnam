<div class="page-title-sec marketing-tit">
	<h2 class="page-title"><?=$title?></h2>
</div>
<ul class="univ-list">
<?php if($univ_list) : ?>
	<?php foreach($univ_list as $val) : ?>
	<li>
		<a href="<?=site_url()?>homeAdm/univ/write/<?=$val->u_id?>">
			<strong><?=stripslashes($val->u_name_en)?></strong>
			- <span><?=stripslashes($val->u_program_name_en)?></span>
		</a>
	</li>
	<?php endforeach ?>
<?php else : ?>
	<li>
		등록된 대학교가 없습니다.
	</li>
<?php endif ?>
</ul>
