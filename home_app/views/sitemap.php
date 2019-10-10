<div class="section-full">
	<div class="section_wrapper">
		<ul class="sitemap-list sitemap-depth1">
		<?php foreach($mp_nav as $val) : ?>
		<li>
			<a href="<?=site_url()?><?=$umv_lang?>/<?=$val->nav_link?>"><?=fnc_set_htmls_strip($val->{'nav_name_'.$umv_lang})?></a>
			<?php if(isset($val->nav_depth2)) : ?>
			<ul class="sitemap-list sitemap-depth2">
			<?php foreach($val->nav_depth2 as $val2) : ?>
				<li>
					<a href="<?=site_url()?><?=$umv_lang?>/<?=$val2->nav_link?>">
						- <span class="animate_bottom_line"><?=fnc_set_htmls_strip($val2->{'nav_name_'.$umv_lang})?></span>
					</a>
					<?php if(isset($val2->nav_depth3)) : ?>
						<ul class="sitemap-list sitemap-depth3">
						<?php foreach($val2->nav_depth3 as $val3) : ?>
							<li>
								<a href="<?=site_url()?><?=$umv_lang?>/<?=$val3->nav_link?>">
									- <span class="animate_bottom_line"><?=fnc_set_htmls_strip($val3->{'nav_name_'.$umv_lang})?></span>
								</a>
							</li>
						<?php endforeach ?>
						</ul>
					<?php endif ?>
				</li>
			<?php endforeach ?>
			</ul>
			<?php endif ?>
		</li>
		<?php endforeach ?>
		</ul>
	</div>
</div>
