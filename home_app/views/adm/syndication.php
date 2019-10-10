<div class="page-title-sec marketing-tit">
	<h2 class="page-title"><?=$title?></h2>
</div>
<?php if($syndi_use) : ?>
<div class="admin-page-sec">
	<ul class="syndi-nav">
	<?php foreach($nav as $val) : ?>
		<?php if($val->nav_depth==='1depth' && $val->nav_parent==0) : ?>
		<li class="<?=($val->nav_id== $cate)?'active':''?>">
			<a href="/homeAdm/syndication/<?=$val->nav_id?>"><?=$val->nav_name?></a>
		</li>	
		<?php endif ?>
	<?php endforeach ?>
	</ul>
</div>
<?php if(count($sun_nav)>0) : ?>
<div class="admin-page-sec">
	<div class="syndi-xml-sec">
		<a href="<?=site_url()?>syndi/xml/<?=$cate?>" target="_blank"><?=$page_tit?> - Feed xml 보기</a>
		<div>
			<?=form_open('homeAdm/syndication_ping')?>
			<input type="hidden" name="cate" value="<?=(int)$cate?>" />
			<input type="submit" value="핑 전송" />
			</form>
		</div>
	</div>
	<ul class="syndi-list">	
	<?php foreach($syndi_data as $val) : ?>
	<li>
		<?=form_open('homeAdm/syndication_update', 'class="BD-check-form"')?>
		<input type="hidden" name="nav_parent" value="<?=$val->nav_parent?>" />
		<input type="hidden" name="syn_num" value="<?=$val->syn_num?>" />
		<table class="tableA">
		<colgroup>
			<col style="width:8%" />
			<col style="width:26%" />
			<col style="width:8%" />
			<col style="width:26%" />
			<col style="width:8%" />
			<col style="width:8%" />
			<col style="width:8%" />
			<col style="width:8%" />
		</colgroup>
			<tr>
				<th width="130">타이틀</th>
				<td>
					<div class="input-box"><input type="text" name="syn_title" value="<?=fnc_set_htmls_strip($val->syn_title, true)?>" class="checkInput" required="required" /></div>
				</td>
				<th width="130">링크</th>
				<td><div class="input-box"><input type="text" name="syn_id" value="<?=fnc_set_htmls_strip($val->syn_id, true)?>" class="checkInput" required="required" /></td>
				<th width="130">사용</th>
				<td>
					<select name="syn_use">
						<option value="yes" <?=($val->syn_use=='yes')?'selected="selected"':''?>>yes</option>
						<option value="no" <?=($val->syn_use=='no')?'selected="selected"':''?>>no</option>
					</select>
				</td>
				<th width="130">RSS사용</th>
				<td>
					<select name="rss_use">
						<option value="yes" <?=($val->rss_use=='yes')?'selected="selected"':''?>>yes</option>
						<option value="no" <?=($val->rss_use=='no')?'selected="selected"':''?>>no</option>
					</select>
				</td>
			</tr>
			<tr>
				<th valign="middle">컨텐츠 <br /><input type="button" value="웹컨텐츠 가져오기" /></th>
				<td colspan="7">
					<div class="textarea-box">
						<textarea name="syn_content" class="checkInput"><?=stripslashes(str_replace('\r\n', PHP_EOL, $val->syn_content))?></textarea>
					</div>
				</td>
			</tr>
		</table>
		<div class="syndi-submit"><input type="submit" value="수정" /></div>
		</form>
	</li>	
	<?php endforeach ?>
	</ul>
</div>
<?php endif ?>
<?php else : ?>
	
<?php endif ?>
<script>
	
</script>