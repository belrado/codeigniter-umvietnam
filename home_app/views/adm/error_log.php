<h2 class="page-tit"><?=$title?></h2>
<div class="admin-page-sec">
	<table class="tableA">
	<colgroup>
		<col style="width:10%" />
		<col style="width:40%" />
		<col style="width:15%" />
		<col style="width:25%" />
		<col style="width:10%" />
	</colgroup>
	<thead>
		<tr>
			<th scope="col">log type</th>
			<th scope="col">log agent</th>
			<th scope="col">log ip</th>
			<th scope="col">log value</th>
			<th scope="col">register</th>
		</tr>
	</thead>
	<tbody>
	<?php if($log_results) : ?>
		<?php foreach($log_results as $val) : ?>
		<tr>
			<td><?=$val['log_type']?></td>
			<td><?=$val['log_agent']?></td>
			<td><?=$val['log_ip']?></td>
			<td>
			<?php if(!empty($val['log_value'])) : ?>
				접속시도 아이디: <?=$val['log_value']['userid']?>
			<?php endif?>
			</td>
			<td><?=$val['log_register']?></td>
		</tr>
		<?php endforeach ?>
	<?php else : ?>
	<?php endif ?>
	</tbody>
	</table>
	<?=$paging_show?>
</div>
