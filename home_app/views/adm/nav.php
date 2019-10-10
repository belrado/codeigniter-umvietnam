<div class="page-title-sec">
	<h2 class="page-title"><?=$title?></h2>
</div>
<div class="admin-page-sec" id="addnavwrap">
	<div class="marginB30 form-sec">
		<div class="menu-insert-box">
			<h3 class="sub-title">1뎁스 추가</h3>
			<div class="insert-content">
				<div class="inner-box">
					<form action="<?=site_url()?>homeAdm/nav/update" method="post" id="navFrm" name="navFrm" class="navFrm mainnavFrm">
					<fieldset>
						<input type="hidden" id="<?=$this->security->get_csrf_token_name()?>" name="<?=$this->security->get_csrf_token_name()?>" value="<?= $this->security->get_csrf_hash() ?>" class="<?=$this->security->get_csrf_token_name()?>" />
						<input type="hidden" name="nav_type" value="ajax" />
						<input type="hidden" name="nav_mode" value="insert" />
						<div class="form-row">
							<label for="nav_name_ko" class="form-label">메뉴명(ko)</label>
							<div class="form-content">
								<input type="text" name="nav_name_ko" id="nav_name_ko" class="checkInput size-middle" title="메뉴명을 입력해 주세요." required="required" />
							</div>
						</div>
						<div class="form-row">
							<label for="nav_name_en" class="form-label">메뉴명(en)</label>
							<div class="form-content">
								<input type="text" name="nav_name_en" id="nav_name_en" class="checkInput size-middle" title="메뉴명을 입력해 주세요." required="required" />
							</div>
						</div>
						<div class="form-row">
							<label for="nav_name_vn" class="form-label">메뉴명(vn)</label>
							<div class="form-content">
								<input type="text" name="nav_name_vn" id="nav_name_vn" class="checkInput size-middle" title="메뉴명을 입력해 주세요." required="required" />
							</div>
						</div>
						<div class="form-row">
							<label for="nav_access" class="form-label">접근자</label>
							<div class="form-content">
								<input type="text" name="nav_access" id="nav_access" class="checkInput size-middle" required="required" />
							</div>
						</div>
						<div class="form-row">
							<label for="nav_link" class="form-label">URL</label>
							<div class="form-content">
								<input type="text" name="nav_link" id="nav_link" class="checkInput size-middle" title="link를 입력해 주세요." required="required" />
							</div>
						</div>
						<div class="form-row">
							<label for="nav_class" class="form-label">CSS</label>
							<div class="form-content">
								<input type="text" name="nav_class" id="nav_class" class="size-middle" />
							</div>
						</div>
						<div class="form-row">
							<label for="nav_meta_title_ko" class="form-label">페이지타이틀(ko)</label>
							<div class="form-content">
								<input type="text" name="nav_meta_title_ko" id="nav_meta_title_ko" />
							</div>
						</div>
						<div class="form-row">
							<label for="nav_meta_title_en" class="form-label">페이지타이틀(en)</label>
							<div class="form-content">
								<input type="text" name="nav_meta_title_en" id="nav_meta_title_en" />
							</div>
						</div>
						<div class="form-row">
							<label for="nav_meta_title_vn" class="form-label">페이지타이틀(vn)</label>
							<div class="form-content">
								<input type="text" name="nav_meta_title_vn" id="nav_meta_title_vn" />
							</div>
						</div>
						<div class="form-row">
							<label for="nav_meta_keyword_ko" class="form-label">페이지키워드(ko)</label>
							<div class="form-content">
								<input type="text" name="nav_meta_keyword_ko" id="nav_meta_keyword_ko" />
							</div>
						</div>
						<div class="form-row">
							<label for="nav_meta_keyword_en" class="form-label">페이지키워드(en)</label>
							<div class="form-content">
								<input type="text" name="nav_meta_keyword_en" id="nav_meta_keyword_en" />
							</div>
						</div>
						<div class="form-row">
							<label for="nav_meta_keyword_vn" class="form-label">페이지키워드(vn)</label>
							<div class="form-content">
								<input type="text" name="nav_meta_keyword_vn" id="nav_meta_keyword_vn" />
							</div>
						</div>
						<div class="form-row">
							<label for="nav_meta_description_ko" class="form-label">페이지설명(ko)</label>
							<div class="form-content">
								<textarea name="nav_meta_description_ko" id="nav_meta_description_ko" style="height:60px"></textarea>
							</div>
						</div>
						<div class="form-row">
							<label for="nav_meta_description_en" class="form-label">페이지설명(en)</label>
							<div class="form-content">
								<textarea name="nav_meta_description_en" id="nav_meta_description_en" style="height:60px"></textarea>
							</div>
						</div>
						<div class="form-row">
							<label for="nav_meta_description_vn" class="form-label">페이지설명(vn)</label>
							<div class="form-content">
								<textarea name="nav_meta_description_vn" id="nav_meta_description_vn" style="height:60px"></textarea>
							</div>
						</div>
						<div><input type="submit" value="메뉴추가" /></div>
					</fieldset>
					</form>
				</div>
			</div>
			<input type="button" value="open" class="menu-insert-box-open" data-menubox-status="close" />
		</div>
		<div id="subnav-insert-sec1" <?php if(! $mp_nav){ echo "class='display-none'"; }?>>
			<div class="menu-insert-box">
				<h3 class="sub-title">2뎁스 추가</h3>
				<div class="insert-content">
					<div class="inner-box">
						<form action="<?=site_url()?>homeAdm/nav/update" method="post" id="subnavFrm" name="subnavFrm" class="navFrm subnavFrm">
						<fieldset>
							<input type="hidden" id="<?=$this->security->get_csrf_token_name()?>_sub" name="<?=$this->security->get_csrf_token_name()?>" value="<?= $this->security->get_csrf_hash() ?>" class="<?=$this->security->get_csrf_token_name()?>" />
							<input type="hidden" name="nav_type" value="ajax" />
							<input type="hidden" name="nav_mode" value="insert" />
							<input type="hidden" name="nav_depth" value="2depth">
							<div class="form-row">
								<label for="select_parent" class="form-label">1depth</label>
								<div class="form-content">
									<select name="nav_parent" id="select_parent">
									<?php foreach($mp_nav as $val) : ?>
										<option value="<?=$val->nav_id?>" id="opt_nav_parent_<?=$val->nav_id?>"><?=$val->nav_name_ko?></option>
									<?php endforeach ?>
									</select>
								</div>
							</div>
							<div class="form-row">
								<label for="navsub_name_ko" class="form-label">메뉴명(ko)</label>
								<div class="form-content">
									<input type="text" name="nav_name_ko" id="navsub_name_ko" class="checkInput size-middle" title="sub 메뉴명을 입력해 주세요." required="required" />
								</div>
							</div>
							<div class="form-row">
								<label for="navsub_name_en" class="form-label">메뉴명(en)</label>
								<div class="form-content">
									<input type="text" name="nav_name_en" id="navsub_name_en" class="checkInput size-middle" title="sub 메뉴명을 입력해 주세요." required="required" />
								</div>
							</div>
							<div class="form-row">
								<label for="navsub_name_vn" class="form-label">메뉴명(vn)</label>
								<div class="form-content">
									<input type="text" name="nav_name_vn" id="navsub_name_vn" class="checkInput size-middle" title="sub 메뉴명을 입력해 주세요." required="required" />
								</div>
							</div>
							<div class="form-row">
								<label for="navsub_access" class="form-label">접근자</label>
								<div class="form-content">
									<input type="text" name="nav_access" id="navsub_access" class="checkInput size-middle" title="sub 접근자를 입력해 주세요." required="required" />
								</div>
							</div>
							<div class="form-row">
								<label for="navsub_link" class="form-label">URL</label>
								<div class="form-content">
									<input type="text" name="nav_link" id="navsub_link" class="checkInput size-middle" title="sub link를 입력해 주세요." required="required"/>
								</div>
							</div>
							<div class="form-row">
								<label for="navsub_class" class="form-label">CSS class</label>
								<div class="form-content">
									<input type="text" name="nav_class" id="navsub_class" class="size-middle" />
								</div>
							</div>
							<div class="form-row">
								<label for="navsub_meta_title_ko" class="form-label">페이지타이틀(ko)</label>
								<div class="form-content">
									<input type="text" name="nav_meta_title_ko" id="navsub_meta_title_ko" />
								</div>
							</div>
							<div class="form-row">
								<label for="navsub_meta_title_en" class="form-label">페이지타이틀(en)</label>
								<div class="form-content">
									<input type="text" name="nav_meta_title_en" id="navsub_meta_title_en" />
								</div>
							</div>
							<div class="form-row">
								<label for="navsub_meta_title_vn" class="form-label">페이지타이틀(vn)</label>
								<div class="form-content">
									<input type="text" name="nav_meta_title_vn" id="navsub_meta_title_vn" />
								</div>
							</div>
							<div class="form-row">
								<label for="navsub_meta_keyword_ko" class="form-label">페이지키워드(ko)</label>
								<div class="form-content">
									<input type="text" name="nav_meta_keyword_ko" id="navsub_meta_keyword_ko" />
								</div>
							</div>
							<div class="form-row">
								<label for="navsub_meta_keyword_en" class="form-label">페이지키워드(en)</label>
								<div class="form-content">
									<input type="text" name="nav_meta_keyword_en" id="navsub_meta_keyword_en" />
								</div>
							</div>
							<div class="form-row">
								<label for="navsub_meta_keyword_vn" class="form-label">페이지키워드(vn)</label>
								<div class="form-content">
									<input type="text" name="nav_meta_keyword_vn" id="navsub_meta_keyword_vn" />
								</div>
							</div>
							<div class="form-row">
								<label for="navsub_meta_description_ko" class="form-label">페이지설명문구(ko)</label>
								<div class="form-content">
									<textarea name="nav_meta_description_ko" id="navsub_meta_description_ko" style="height:60px"></textarea>
								</div>
							</div>
							<div class="form-row">
								<label for="navsub_meta_description_en" class="form-label">페이지설명문구(en)</label>
								<div class="form-content">
									<textarea name="nav_meta_description_en" id="navsub_meta_description_en" style="height:60px"></textarea>
								</div>
							</div>
							<div class="form-row">
								<label for="navsub_meta_description_vn" class="form-label">페이지설명문구(vn)</label>
								<div class="form-content">
									<textarea name="nav_meta_description_vn" id="navsub_meta_description_vn" style="height:60px"></textarea>
								</div>
							</div>
							<div><input type="submit" value="메뉴추가" /></div>
						</fieldset>
						</form>
					</div>
				</div>
				<input type="button" value="open" class="menu-insert-box-open" data-menubox-status="close" />
			</div>
		</div>
		<div id="subnav-insert-sec2" <?php if(!$mp_nav){ echo "class='display-none'"; }?>>
			<div class="menu-insert-box">
				<h3 class="sub-title">3뎁스 추가</h3>
				<div class="insert-content">
					<div class="inner-box">
						<form action="<?=site_url()?>homeAdm/nav/update" method="post" id="subnavFrm" name="subnavFrm" class="navFrm subnavFrm">
						<fieldset>
							<input type="hidden" id="<?=$this->security->get_csrf_token_name()?>_sub" name="<?=$this->security->get_csrf_token_name()?>" value="<?= $this->security->get_csrf_hash() ?>" class="<?=$this->security->get_csrf_token_name()?>" />
							<input type="hidden" name="nav_type" value="ajax" />
							<input type="hidden" name="nav_mode" value="insert" />
							<input type="hidden" name="nav_depth" value="3depth">
							<div class="form-row">
								<label for="select_parent2" class="form-label">1depth/2depth</label>
								<div class="form-content">
									<select name="nav_parent" id="select_parent2" class="select_parent">
									<?php foreach($mp_nav as $val) : ?>
										<option value="<?=$val->nav_id?>" id="opt_nav_parent_<?=$val->nav_id?>"><?=$val->nav_name_ko?></option>
									<?php endforeach ?>
									</select>
									<select name="nav_sub_parent" id="select_sub_parent">
									<?php if(!isset($mp_nav[0]->nav_depth2)) : ?>
										<option value="0">하위메뉴없음</option>
									<?php endif ?>
									<?php foreach($mp_nav[0]->nav_depth2 as $val) : ?>
										<option value="<?=$val->nav_id?>" id="opt_nav_sub_parent_<?=$val->nav_id?>"><?=$val->nav_name_ko?></option>
									<?php endforeach ?>
									</select>
								</div>
							</div>
							<div class="form-row">
								<label for="navsub_name2_ko" class="form-label">메뉴명(ko)</label>
								<div class="form-content">
									<input type="text" name="nav_name_ko" id="navsub_name2_ko" class="checkInput size-middle" title="sub 메뉴명을 입력해 주세요." required="required" />
								</div>
							</div>
							<div class="form-row">
								<label for="navsub_name2_en" class="form-label">메뉴명(en)</label>
								<div class="form-content">
									<input type="text" name="nav_name_en" id="navsub_name2_en" class="checkInput size-middle" title="sub 메뉴명을 입력해 주세요." required="required" />
								</div>
							</div>
							<div class="form-row">
								<label for="navsub_name2_vn" class="form-label">메뉴명(vn)</label>
								<div class="form-content">
									<input type="text" name="nav_name_vn" id="navsub_name2_vn" class="checkInput size-middle" title="sub 메뉴명을 입력해 주세요." required="required" />
								</div>
							</div>
							<div class="form-row">
								<label for="navsub_access2" class="form-label">접근자</label>
								<div class="form-content">
									<input type="text" name="nav_access" id="navsub_access2" class="checkInput size-middle" title="sub 접근자 입력해 주세요." required="required" />
								</div>
							</div>
							<div class="form-row">
								<label for="navsub_link2" class="form-label">URL</label>
								<div class="form-content">
									<input type="text" name="nav_link" id="navsub_link2" class="checkInput size-middle" title="sub link를 입력해 주세요." required="required"/>
								</div>
							</div>
							<div class="form-row">
								<label for="navsub_class2" class="form-label">CSS class</label>
								<div class="form-content">
									<input type="text" name="nav_class" class="size-middle" id="navsub_meta_title2_ko" />
								</div>
							</div>
							<div class="form-row">
								<label for="navsub_meta_title2_ko" class="form-label">페이지타이틀(ko)</label>
								<div class="form-content">
									<input type="text" name="nav_meta_title_ko" id="navsub_meta_title2_ko" />
								</div>
							</div>
							<div class="form-row">
								<label for="navsub_meta_title2_en" class="form-label">페이지타이틀(en)</label>
								<div class="form-content">
									<input type="text" name="nav_meta_title_en" id="navsub_meta_title2_en" />
								</div>
							</div>
							<div class="form-row">
								<label for="navsub_meta_title2_vn" class="form-label">페이지타이틀(vn)</label>
								<div class="form-content">
									<input type="text" name="nav_meta_title_vn" id="navsub_meta_title2_vn" />
								</div>
							</div>
							<div class="form-row">
								<label for="navsub_meta_keyword2_ko" class="form-label">페이지키워드(ko)</label>
								<div class="form-content">
									<input type="text" name="nav_meta_keyword_ko" id="navsub_meta_keyword2_ko" />
								</div>
							</div>
							<div class="form-row">
								<label for="navsub_meta_keyword2_en" class="form-label">페이지키워드(en)</label>
								<div class="form-content">
									<input type="text" name="nav_meta_keyword_en" id="navsub_meta_keyword2_en" />
								</div>
							</div>
							<div class="form-row">
								<label for="navsub_meta_keyword2_vn" class="form-label">페이지키워드(vn)</label>
								<div class="form-content">
									<input type="text" name="nav_meta_keyword_vn" id="navsub_meta_keyword2_vn" />
								</div>
							</div>
							<div class="form-row">
								<label for="navsub_meta_description2_ko" class="form-label">페이지설명문구(ko)</label>
								<div class="form-content">
									<textarea name="nav_meta_description_ko" id="navsub_meta_description2_ko" style="height:60px"></textarea>
								</div>
							</div>
							<div class="form-row">
								<label for="navsub_meta_description2_en" class="form-label">페이지설명문구(en)</label>
								<div class="form-content">
									<textarea name="nav_meta_description_en" id="navsub_meta_description2_en" style="height:60px"></textarea>
								</div>
							</div>
							<div class="form-row">
								<label for="navsub_meta_description2_vn" class="form-label">페이지설명문구(vn)</label>
								<div class="form-content">
									<textarea name="nav_meta_description_vn" id="navsub_meta_description2_vn" style="height:60px"></textarea>
								</div>
							</div>
							<div><input type="submit" value="메뉴추가" /></div>
						</fieldset>
						</form>
					</div>
				</div>
				<input type="button" value="open" class="menu-insert-box-open" data-menubox-status="close" />
			</div>
		</div>
	</div>
	<form action="<?=site_url()?>homeAdm/nav/update" method="post" class="BD-check-form">
	<fieldset>
	<input type="hidden" id="<?=$this->security->get_csrf_token_name()?>_list" name="<?=$this->security->get_csrf_token_name()?>" value="<?= $this->security->get_csrf_hash() ?>" class="<?=$this->security->get_csrf_token_name()?>" />
	<input type="hidden" name="nav_type" value="default" />
	<input type="hidden" name="nav_mode" value="update" />
		<ul id="nav_list">
		<?php if(!$mp_nav) : ?>
			<li class="none-nav">등록된 메뉴가 없습니다.</li>
		<?php else : ?>
			<?php for($i=0; $i<count($mp_nav); $i++) : ?>
			<li id="menu-list-<?=$mp_nav[$i]->nav_id?>">
				<input type="hidden" name="nav_id[]" value="<?=$mp_nav[$i]->nav_id?>" class="checkInput numCheck" />
				<input type="hidden" name="nav_index[]" value="<?=$mp_nav[$i]->nav_index?>" class="nav-index" />
				<!-- // 1뎁스 // -->
				<div class="subject-box">
					<div class="menu-box"><?=fnc_set_htmls_strip($mp_nav[$i]->nav_name_ko)?></div>
					<div class="input-box close-box">
						<div>
							<label for="nav_name_<?=$mp_nav[$i]->nav_id?>">메뉴명(ko)</label>
							<input type="text" value="<?=fnc_set_htmls_strip($mp_nav[$i]->nav_name_ko)?>" name="nav_name_ko[]" id="nav_name_ko_<?=$mp_nav[$i]->nav_id?>" class="checkInput" title="메뉴명을 입력해 주세요." required="required" />
						</div>
						<div>
							<label for="nav_name_<?=$mp_nav[$i]->nav_id?>">메뉴명(en)</label>
							<input type="text" value="<?=fnc_set_htmls_strip($mp_nav[$i]->nav_name_en)?>" name="nav_name_en[]" id="nav_name_en_<?=$mp_nav[$i]->nav_id?>" class="checkInput" title="메뉴명을 입력해 주세요." required="required" />
						</div>
						<div>
							<label for="nav_name_<?=$mp_nav[$i]->nav_id?>">메뉴명(vn)</label>
							<input type="text" value="<?=fnc_set_htmls_strip($mp_nav[$i]->nav_name_vn)?>" name="nav_name_vn[]" id="nav_name_vn_<?=$mp_nav[$i]->nav_id?>" class="checkInput" title="메뉴명을 입력해 주세요." required="required" />
						</div>
						<div>
							<label for="nav_access_<?=$mp_nav[$i]->nav_id?>">접근자</label>
							<input type="text" value="<?=fnc_set_htmls_strip($mp_nav[$i]->nav_access, true)?>" name="nav_access[]" id="nav_access_<?=$mp_nav[$i]->nav_id?>" class="checkInput" title="접근자를 입력해 주세요." required="required" />
						</div>
						<div>
							<label for="nav_link_<?=$mp_nav[$i]->nav_id?>">URL</label>
							<input type="text" value="<?=fnc_set_htmls_strip($mp_nav[$i]->nav_link, true)?>" name="nav_link[]" id="nav_link_<?=$mp_nav[$i]->nav_id?>" class="checkInput" title="link를 입력해 주세요." required="required" />
						</div>
						<div>
							<label for="nav_class_<?=$mp_nav[$i]->nav_id?>">CSS class</label>
							<input type="text" value="<?=fnc_set_htmls_strip($mp_nav[$i]->nav_class, true)?>" name="nav_class[]" id="nav_class_<?=$mp_nav[$i]->nav_id?>" />
						</div>
						<div>
							<label for="nav_meta_title_ko_<?=$mp_nav[$i]->nav_id?>">페이지타이틀(ko)</label>
							<input type="text" value="<?=fnc_set_htmls_strip($mp_nav[$i]->nav_meta_title_ko)?>" name="nav_meta_title_ko[]" id="nav_meta_title_ko_<?=$mp_nav[$i]->nav_id?>" />
						</div>
						<div>
							<label for="nav_meta_title_en_<?=$mp_nav[$i]->nav_id?>">페이지타이틀(en)</label>
							<input type="text" value="<?=fnc_set_htmls_strip($mp_nav[$i]->nav_meta_title_en)?>" name="nav_meta_title_en[]" id="nav_meta_title_en_<?=$mp_nav[$i]->nav_id?>" />
						</div>
						<div>
							<label for="nav_meta_title_vn_<?=$mp_nav[$i]->nav_id?>">페이지타이틀(vn)</label>
							<input type="text" value="<?=fnc_set_htmls_strip($mp_nav[$i]->nav_meta_title_vn)?>" name="nav_meta_title_vn[]" id="nav_meta_title_vn_<?=$mp_nav[$i]->nav_id?>" />
						</div>
						<div>
							<label for="nav_meta_keyword_ko_<?=$mp_nav[$i]->nav_id?>">페이지키워드(ko)</label>
							<input type="text" value="<?=fnc_set_htmls_strip($mp_nav[$i]->nav_meta_keyword_ko)?>" name="nav_meta_keyword_ko[]" id="nav_meta_keyword_ko_<?=$mp_nav[$i]->nav_id?>" />
						</div>
						<div>
							<label for="nav_meta_keyword_en_<?=$mp_nav[$i]->nav_id?>">페이지키워드(en)</label>
							<input type="text" value="<?=fnc_set_htmls_strip($mp_nav[$i]->nav_meta_keyword_en)?>" name="nav_meta_keyword_en[]" id="nav_meta_keyword_en_<?=$mp_nav[$i]->nav_id?>" />
						</div>
						<div>
							<label for="nav_meta_keyword_vn_<?=$mp_nav[$i]->nav_id?>">페이지키워드(vn)</label>
							<input type="text" value="<?=fnc_set_htmls_strip($mp_nav[$i]->nav_meta_keyword_vn)?>" name="nav_meta_keyword_vn[]" id="nav_meta_keyword_vn_<?=$mp_nav[$i]->nav_id?>" />
						</div>
						<div>
							<label for="nav_meta_description_ko_<?=$mp_nav[$i]->nav_id?>" style="vertical-align:top">페이지설명문구</label>
							<textarea name="nav_meta_description_ko[]" id="nav_meta_description_ko_<?=$mp_nav[$i]->nav_id?>"><?=fnc_set_htmls_strip(str_replace('\r\n', PHP_EOL, $mp_nav[$i]->nav_meta_description_ko))?></textarea>
						</div>
						<div>
							<label for="nav_meta_description_en_<?=$mp_nav[$i]->nav_id?>" style="vertical-align:top">페이지설명문구</label>
							<textarea name="nav_meta_description_en[]" id="nav_meta_description_en_<?=$mp_nav[$i]->nav_id?>"><?=fnc_set_htmls_strip(str_replace('\r\n', PHP_EOL, $mp_nav[$i]->nav_meta_description_en))?></textarea>
						</div>
						<div>
							<label for="nav_meta_description_vn_<?=$mp_nav[$i]->nav_id?>" style="vertical-align:top">페이지설명문구</label>
							<textarea name="nav_meta_description_vn[]" id="nav_meta_description_vn_<?=$mp_nav[$i]->nav_id?>"><?=fnc_set_htmls_strip(str_replace('\r\n', PHP_EOL, $mp_nav[$i]->nav_meta_description_vn))?></textarea>
						</div>
					</div>
					<input type="button" value="del" id="navdel-<?=$mp_nav[$i]->nav_id?>" class="nav-delete-btn" />
				</div>
				<!-- // 2뎁스 // -->
				<ul class="subnav" id="parentid_<?=$mp_nav[$i]->nav_id?>">
				<?php if(isset($mp_nav[$i]->nav_depth2)) : ?>
					<?php for($j=0; $j<count($mp_nav[$i]->nav_depth2); $j++) : ?>
					<?php $depth2 = $mp_nav[$i]->nav_depth2[$j]; ?>
					<li>
						<input type="hidden" name="navsub_id[]" value="<?=$depth2->nav_id?>" />
						<input type="hidden" name="navsub_index[]" value="<?=$depth2->nav_index?>" class="nav-index" />
						<div>
							<div class="menu-box">
								<?=fnc_set_htmls_strip($depth2->nav_name_ko)?>
								<?php if(strtotime($depth2->nav_new.'+'.'7'.' days') > strtotime(date('Y-m-d h:i:s', time()))) : ?>
									<div><?php echo date('Y-m-d h:i:s',strtotime($depth2->nav_new.'+'.'7'.' days')).' 까지 New표시 '; ?></div>
								<?php endif ?>
							</div>
							<div class="input-box close-box">
								<div>
								<?php if(strtotime($depth2->nav_new.'+'.'7'.' days') > strtotime(date('Y-m-d h:i:s', time()))) : ?>
										<div><?php echo date('Y-m-d h:i:s',strtotime($depth2->nav_new.'+'.'7'.' days')).' 까지 New표시 '; ?></div>
								<?php endif ?>
									<select name="navsub_new[]" id="navsub_new_<?=$depth2->nav_id?>">
										<option value="">선택</option>
										<option value="show">표시/연장</option>
										<option value="hide">사용안함</option>
									</select>
								</div>
								<div>
									<label for="navsub_name_ko_<?=$depth2->nav_id?>">메뉴명(ko)</label>
									<input type="text" value="<?=fnc_set_htmls_strip($depth2->nav_name_ko)?>" name="navsub_name_ko[]" id="navsub_name_ko_<?=$depth2->nav_id?>" class="checkInput" title="메뉴명을 입력해 주세요." required="required" />
								</div>
								<div>
									<label for="navsub_name_en_<?=$depth2->nav_id?>">메뉴명(en)</label>
									<input type="text" value="<?=fnc_set_htmls_strip($depth2->nav_name_en)?>" name="navsub_name_en[]" id="navsub_name_en_<?=$depth2->nav_id?>" class="checkInput" title="메뉴명을 입력해 주세요." required="required" />
								</div>
								<div>
									<label for="navsub_name_vn_<?=$depth2->nav_id?>">메뉴명(vn)</label>
									<input type="text" value="<?=fnc_set_htmls_strip($depth2->nav_name_vn)?>" name="navsub_name_vn[]" id="navsub_name_vn_<?=$depth2->nav_id?>" class="checkInput" title="메뉴명을 입력해 주세요." required="required" />
								</div>
								<div>
									<label for="navsub_access_<?=$depth2->nav_id?>">접근자</label>
									<input type="text" value="<?=fnc_set_htmls_strip($depth2->nav_access, true)?>" name="navsub_access[]" id="navsub_access_<?=$depth2->nav_id?>" class="checkInput" title="접근자를 입력해 주세요." required="required" />
								</div>
								<div>
									<label for="navsub_link_<?=$depth2->nav_id?>">URL</label>
									<input type="text" value="<?=fnc_set_htmls_strip($depth2->nav_link, true)?>" name="navsub_link[]" id="navsub_link_<?=$depth2->nav_id?>" class="checkInput" title="link를 입력해 주세요." required="required" />
								</div>
								<div>
									<label for="navsub_class_<?=$depth2->nav_id?>">CSS class</label>
									<input type="text" value="<?=fnc_set_htmls_strip($depth2->nav_class, true)?>" name="navsub_class[]" id="navsub_class_<?=$depth2->nav_id?>" />
								</div>
								<div>
									<label for="navsub_meta_title_ko_<?=$depth2->nav_id?>">페이지타이틀(ko)</label>
									<input type="text" value="<?=fnc_set_htmls_strip($depth2->nav_meta_title_ko)?>" name="navsub_meta_title_ko[]" id="navsub_meta_title_ko_<?=$depth2->nav_id?>" />
								</div>
								<div>
									<label for="navsub_meta_title_en_<?=$depth2->nav_id?>">페이지타이틀(en)</label>
									<input type="text" value="<?=fnc_set_htmls_strip($depth2->nav_meta_title_en)?>" name="navsub_meta_title_en[]" id="navsub_meta_title_ko_<?=$depth2->nav_id?>" />
								</div>
								<div>
									<label for="navsub_meta_title_vn_<?=$depth2->nav_id?>">페이지타이틀(vn)</label>
									<input type="text" value="<?=fnc_set_htmls_strip($depth2->nav_meta_title_vn)?>" name="navsub_meta_title_vn[]" id="navsub_meta_title_vn_<?=$depth2->nav_id?>" />
								</div>
								<div>
									<label for="navsub_meta_keyword_ko_<?=$depth2->nav_id?>">페이지키워드(ko)</label>
									<input type="text" value="<?=fnc_set_htmls_strip($depth2->nav_meta_keyword_ko)?>" name="navsub_meta_keyword_ko[]" id="navsub_meta_keyword_ko_<?=$depth2->nav_id?>" />
								</div>
								<div>
									<label for="navsub_meta_keyword_en_<?=$depth2->nav_id?>">페이지키워드(en)</label>
									<input type="text" value="<?=fnc_set_htmls_strip($depth2->nav_meta_keyword_en)?>" name="navsub_meta_keyword_en[]" id="navsub_meta_keyword_en_<?=$depth2->nav_id?>" />
								</div>
								<div>
									<label for="navsub_meta_keyword_vn_<?=$depth2->nav_id?>">페이지키워드(vn)</label>
									<input type="text" value="<?=fnc_set_htmls_strip($depth2->nav_meta_keyword_vn)?>" name="navsub_meta_keyword_vn[]" id="navsub_meta_keyword_vn_<?=$depth2->nav_id?>" />
								</div>
								<div>
									<label for="navsub_meta_description_ko_<?=$depth2->nav_id?>" style="vertical-align:top">페이지설명문구(ko)</label>
									<textarea name="navsub_meta_description_ko[]" id="navsub_meta_description_ko_<?=$depth2->nav_id?>"><?=fnc_set_htmls_strip(str_replace('\r\n', PHP_EOL, $depth2->nav_meta_description_ko))?></textarea>
								</div>
								<div>
									<label for="navsub_meta_description_en_<?=$depth2->nav_id?>" style="vertical-align:top">페이지설명문구(en)</label>
									<textarea name="navsub_meta_description_en[]" id="navsub_meta_description_en_<?=$depth2->nav_id?>"><?=fnc_set_htmls_strip(str_replace('\r\n', PHP_EOL, $depth2->nav_meta_description_en))?></textarea>
								</div>
								<div>
									<label for="navsub_meta_description_vn_<?=$depth2->nav_id?>" style="vertical-align:top">페이지설명문구(vn)</label>
									<textarea name="navsub_meta_description_vn[]" id="navsub_meta_description_vn_<?=$depth2->nav_id?>"><?=fnc_set_htmls_strip(str_replace('\r\n', PHP_EOL, $depth2->nav_meta_description_vn))?></textarea>
								</div>
							</div>
							<input type="button" value="del" id="navdel-<?=$depth2->nav_id?>" class="nav-delete-btn" />
						</div>
						<input type="button" value="위" class="index_up_btn" /><input type="button" value="아래" class="index_down_btn" />
						<ul class="subnav" id="parentid_<?=$depth2->nav_id?>">
						<?php if(isset($depth2->nav_depth3)) : ?>
						<!-- // 3뎁스 // -->
							<?php for($c=0; $c<count($depth2->nav_depth3); $c++) : ?>
							<?php $depth3 = $depth2->nav_depth3[$c]; ?>
							<li>
								<input type="hidden" name="navsub_id[]" value="<?=$depth3->nav_id?>" />
								<input type="hidden" name="navsub_index[]" value="<?=$depth3->nav_index?>" class="nav-index" />
								<div>
									<div class="menu-box">
										<?=fnc_set_htmls_strip($depth3->nav_name_ko)?>
										<?php if(strtotime($depth3->nav_new.'+'.'7'.' days') > strtotime(date('Y-m-d h:i:s', time()))) : ?>
											<div><?php echo date('Y-m-d h:i:s',strtotime($depth3->nav_new.'+'.'7'.' days')).' 까지 New표시 '; ?></div>
										<?php endif ?>
									</div>
									<div class="input-box close-box">
										<div>
										<?php if(strtotime($depth3->nav_new.'+'.'7'.' days') > strtotime(date('Y-m-d h:i:s', time()))) : ?>
												<div><?php echo date('Y-m-d h:i:s',strtotime($depth3->nav_new.'+'.'7'.' days')).' 까지 New표시 '; ?></div>
										<?php endif ?>
											<select name="navsub_new[]" id="navsub_new_<?=$depth2->nav_id?>">
												<option value="">선택</option>
												<option value="show">표시/연장</option>
												<option value="hide">사용안함</option>
											</select>
										</div>
										<div>
											<label for="navsub_name_ko_<?=$depth3->nav_id?>">메뉴명(ko)</label>
											<input type="text" value="<?=fnc_set_htmls_strip($depth3->nav_name_ko)?>" name="navsub_name_ko[]" id="navsub_name_ko_<?=$depth3->nav_id?>" class="checkInput" title="메뉴명을 입력해 주세요." required="required" />
										</div>
										<div>
											<label for="navsub_name_en_<?=$depth3->nav_id?>">메뉴명(en)</label>
											<input type="text" value="<?=fnc_set_htmls_strip($depth3->nav_name_en)?>" name="navsub_name_en[]" id="navsub_name_en_<?=$depth3->nav_id?>" class="checkInput" title="메뉴명을 입력해 주세요." required="required" />
										</div>
										<div>
											<label for="navsub_name_vn_<?=$depth3->nav_id?>">메뉴명(vn)</label>
											<input type="text" value="<?=fnc_set_htmls_strip($depth3->nav_name_vn)?>" name="navsub_name_vn[]" id="navsub_name_vn_<?=$depth3->nav_id?>" class="checkInput" title="메뉴명을 입력해 주세요." required="required" />
										</div>
										<div>
											<label for="navsub_access_<?=$depth3->nav_id?>">접근자</label>
											<input type="text" value="<?=fnc_set_htmls_strip($depth3->nav_access, true)?>" name="navsub_access[]" id="navsub_access_<?=$depth3->nav_id?>" class="checkInput" title="접근자를 입력해 주세요." required="required" />
										</div>
										<div>
											<label for="navsub_link_<?=$depth3->nav_id?>">URL</label>
											<input type="text" value="<?=fnc_set_htmls_strip($depth3->nav_link, true)?>" name="navsub_link[]" id="navsub_link_<?=$depth3->nav_id?>" class="checkInput" title="link를 입력해 주세요." required="required" />
										</div>
										<div>
											<label for="navsub_class_<?=$depth3->nav_id?>">CSS class</label>
											<input type="text" value="<?=fnc_set_htmls_strip($depth3->nav_class, true)?>" name="navsub_class[]" id="navsub_class_<?=$depth3->nav_id?>" />
										</div>
										<div>
											<label for="navsub_meta_title_ko_<?=$depth3->nav_id?>">페이지타이틀(ko)</label>
											<input type="text" value="<?=fnc_set_htmls_strip($depth3->nav_meta_title_ko)?>" name="navsub_meta_title_ko[]" id="navsub_meta_title_ko_<?=$depth3->nav_id?>" />
										</div>
										<div>
											<label for="navsub_meta_title_en_<?=$depth3->nav_id?>">페이지타이틀(en)</label>
											<input type="text" value="<?=fnc_set_htmls_strip($depth3->nav_meta_title_en)?>" name="navsub_meta_title_en[]" id="navsub_meta_title_en_<?=$depth3->nav_id?>" />
										</div>
										<div>
											<label for="navsub_meta_title_vn_<?=$depth3->nav_id?>">페이지타이틀(vn)</label>
											<input type="text" value="<?=fnc_set_htmls_strip($depth3->nav_meta_title_vn)?>" name="navsub_meta_title_vn[]" id="navsub_meta_title_vn_<?=$depth3->nav_id?>" />
										</div>
										<div>
											<label for="navsub_meta_keyword_ko_<?=$depth3->nav_id?>">페이지키워드(ko)</label>
											<input type="text" value="<?=fnc_set_htmls_strip($depth3->nav_meta_keyword_ko)?>" name="navsub_meta_keyword_ko[]" id="navsub_meta_keyword_ko_<?=$depth3->nav_id?>" />
										</div>
										<div>
											<label for="navsub_meta_keyword_en_<?=$depth3->nav_id?>">페이지키워드(en)</label>
											<input type="text" value="<?=fnc_set_htmls_strip($depth3->nav_meta_keyword_en)?>" name="navsub_meta_keyword_en[]" id="navsub_meta_keyword_en_<?=$depth3->nav_id?>" />
										</div>
										<div>
											<label for="navsub_meta_keyword_vn_<?=$depth3->nav_id?>">페이지키워드(vn)</label>
											<input type="text" value="<?=fnc_set_htmls_strip($depth3->nav_meta_keyword_vn)?>" name="navsub_meta_keyword_vn[]" id="navsub_meta_keyword_vn_<?=$depth3->nav_id?>" />
										</div>
										<div>
											<label for="navsub_meta_description_ko_<?=$depth3->nav_id?>" style="vertical-align:top">페이지설명문구(ko)</label>
											<textarea name="navsub_meta_description_ko[]" id="navsub_meta_description_ko_<?=$depth3->nav_id?>"><?=fnc_set_htmls_strip(str_replace('\r\n', PHP_EOL, $depth3->nav_meta_description_ko))?></textarea>
										</div>
										<div>
											<label for="navsub_meta_description_en_<?=$depth3->nav_id?>" style="vertical-align:top">페이지설명문구(en)</label>
											<textarea name="navsub_meta_description_en[]" id="navsub_meta_description_en_<?=$depth3->nav_id?>"><?=fnc_set_htmls_strip(str_replace('\r\n', PHP_EOL, $depth3->nav_meta_description_en))?></textarea>
										</div>
										<div>
											<label for="navsub_meta_description_vn_<?=$depth3->nav_id?>" style="vertical-align:top">페이지설명문구(vn)</label>
											<textarea name="navsub_meta_description_vn[]" id="navsub_meta_description_vn_<?=$depth3->nav_id?>"><?=fnc_set_htmls_strip(str_replace('\r\n', PHP_EOL, $depth3->nav_meta_description_vn))?></textarea>
										</div>
									</div>
									<input type="button" value="del" id="navdel-<?=$depth3->nav_id?>" class="nav-delete-btn" />
								</div>
								<input type="button" value="위" class="index_up_btn" /><input type="button" value="아래" class="index_down_btn" />
							</li>
							<?php endfor ?>
						<?php else : ?>
							<li class="none-nav blind">등록된 메뉴가없습니다.</li>
						<?php endif ?>
						</ul>
					</li>
					<?php endfor ?>
				<?php else : ?>
					<li class="none-nav">등록된 메뉴가없습니다.</li>
				<?php endif ?>
				</ul>
				<input type="button" value="위" class="index_up_btn" /><input type="button" value="아래" class="index_down_btn" />
			</li>
			<?php endfor ?>
		<?php endif ?>
		</ul>
		<div>
			<input type="submit" value="수정하기" />
		</div>
	</fieldset>
	</form>
</div>
<script>
(function($){
"use strict";
	/* 메뉴 등록 수정 삭제 */
	// 1뎁스메뉴 ajax 추가시 생성되는 마크업
	var options 	 = <?=json_encode($mp_nav, JSON_UNESCAPED_UNICODE)?>;
	var addmainnav_html = function(_this){
		try{
			var elem = '<li id="menu-list-'+_this.nav_id+'">';
				elem += '<input type="hidden" name="nav_id[]" value="'+_this.nav_id+'" class="checkInput numCheck" />';
				elem += '<input type="hidden" name="nav_index[]" value="'+_this.nav_index+'" class="nav-index" />';
				elem += '<div class="subject-box">';
					elem += '<div class="menu-box">'+_this.nav_name_ko+'</div>';
					elem += '<div class="input-box close-box">';
						elem += '<div><label for="nav_name_ko_'+_this.nav_id+'">메뉴명</label><input type="text" value="'+_this.nav_name_ko+'" name="nav_name_ko[]" id="nav_name_ko_'+_this.nav_id+'" class="checkInput" title="메뉴명을 입력해 주세요." required="required" /></div>';
						elem += '<div><label for="nav_name_en_'+_this.nav_id+'">메뉴명</label><input type="text" value="'+_this.nav_name_en+'" name="nav_name_en[]" id="nav_name_en_'+_this.nav_id+'" class="checkInput" title="메뉴명을 입력해 주세요." required="required" /></div>';
						elem += '<div><label for="nav_name_vn_'+_this.nav_id+'">메뉴명</label><input type="text" value="'+_this.nav_name_vn+'" name="nav_name_vn[]" id="nav_name_vn_'+_this.nav_id+'" class="checkInput" title="메뉴명을 입력해 주세요." required="required" /></div>';
						elem += '<div><label for="nav_access_'+_this.nav_id+'">접근자</label><input type="text" value="'+_this.nav_access+'" name="nav_access[]" id="nav_access_'+_this.nav_id+'" class="checkInput" title="접근자를 입력해 주세요." required="required" /></div>';
						elem += '<div><label for="nav_link_'+_this.nav_id+'">URL</label><input type="text" value="'+_this.nav_link+'" name="nav_link[]" id="nav_link_'+_this.nav_id+'" class="checkInput" title="link를 입력해 주세요." required="required" /></div>';
						elem += '<div><label for="nav_class_'+_this.nav_id+'">CSS class</label><input type="text" value="'+_this.nav_class+'" name="nav_class[]" id="nav_class_'+_this.nav_id+'" /></div>';
						elem += '<div><label for="nav_meta_title_ko_'+_this.nav_id+'">CSS class</label><input type="text" value="'+_this.nav_meta_title_ko+'" name="nav_meta_title_ko[]" id="nav_meta_title_ko_'+_this.nav_id+'" /></div>';
						elem += '<div><label for="nav_meta_title_en_'+_this.nav_id+'">CSS class</label><input type="text" value="'+_this.nav_meta_title_en+'" name="nav_meta_title_en[]" id="nav_meta_title_en_'+_this.nav_id+'" /></div>';
						elem += '<div><label for="nav_meta_title_vn_'+_this.nav_id+'">CSS class</label><input type="text" value="'+_this.nav_meta_title_vn+'" name="nav_meta_title_vn[]" id="nav_meta_title_vn_'+_this.nav_id+'" /></div>';
						elem += '<div><label for="nav_meta_keyword_ko_'+_this.nav_id+'">CSS class</label><input type="text" value="'+_this.nav_meta_keyword_ko+'" name="nav_meta_keyword_ko[]" id="nav_meta_keyword_ko_'+_this.nav_id+'" /></div>';
						elem += '<div><label for="nav_meta_keyword_en_'+_this.nav_id+'">CSS class</label><input type="text" value="'+_this.nav_meta_keyword_en+'" name="nav_meta_keyword_en[]" id="nav_meta_keyword_en_'+_this.nav_id+'" /></div>';
						elem += '<div><label for="nav_meta_keyword_vn_'+_this.nav_id+'">CSS class</label><input type="text" value="'+_this.nav_meta_keyword_vn+'" name="nav_meta_keyword_vn[]" id="nav_meta_keyword_vn_'+_this.nav_id+'" /></div>';
						elem += '<div><label for="nav_meta_description_ko_'+_this.nav_id+'">CSS class</label><textarea name="nav_meta_description_ko[]" id="nav_meta_description_ko_'+_this.nav_id+'">'+_this.nav_meta_description_ko+'</textarea></div>';
						elem += '<div><label for="nav_meta_description_en_'+_this.nav_id+'">CSS class</label><textarea name="nav_meta_description_en[]" id="nav_meta_description_en_'+_this.nav_id+'">'+_this.nav_meta_description_en+'</textarea></div>';
						elem += '<div><label for="nav_meta_description_vn_'+_this.nav_id+'">CSS class</label><textarea name="nav_meta_description_vn[]" id="nav_meta_description_vn_'+_this.nav_id+'">'+_this.nav_meta_description_vn+'</textarea></div>';
					elem += '</div>';
					elem += '<input type="button" value="del" id="navdel-'+_this.nav_id+'" class="nav-delete-btn" />';
				elem += '</div>';
				elem += '<ul class="subnav" id="parentid_'+_this.nav_id+'">';
				elem += '<li class="none-nav">등록된 메뉴가 없습니다.</li></ul>';
				elem += '<input type="button" value="위" class="index_up_btn" />';
				elem += '<input type="button" value="아래" class="index_down_btn" />';
				elem += '</li>';
			return elem;
		}catch(err){
			alert(err);
		}
	};
	// 2뎁스, 3뎁스메뉴 ajax 추가시 생성되는 마크업
	var addsubnav_html = function(_this){
		try{
			var elem = '<li>';
				elem += '<input type="hidden" name="navsub_id[]" value="'+_this.nav_id+'" class="checkInput numCheck" />';
				elem += '<input type="hidden" name="navsub_index[]" value="'+_this.nav_index+'" class="nav-index" />';
				elem += '<div><div class="menu-box">'+_this.nav_name_ko+'</div>'
				elem += '<div class="input-box close-box">';
					elem += '<div><label for="navsub_name_ko_'+_this.nav_id+'">메뉴명(ko)</label><input type="text" value="'+_this.nav_name_ko+'" name="navsub_name_ko[]" id="navsub_name_ko_'+_this.nav_id+'" class="checkInput" title="메뉴명을 입력해 주세요." required="required" /></div>';
					elem += '<div><label for="navsub_name_en_'+_this.nav_id+'">메뉴명(en)</label><input type="text" value="'+_this.nav_name_en+'" name="navsub_name_en[]" id="navsub_name_en_'+_this.nav_id+'" class="checkInput" title="메뉴명을 입력해 주세요." required="required" /></div>';
					elem += '<div><label for="navsub_name_vn_'+_this.nav_id+'">메뉴명(vn)</label><input type="text" value="'+_this.nav_name_vn+'" name="navsub_name_vn[]" id="navsub_name_vn_'+_this.nav_id+'" class="checkInput" title="메뉴명을 입력해 주세요." required="required" /></div>';
					elem += '<div><label for="navsub_access_'+_this.nav_id+'">접근자</label><input type="text" value="'+_this.nav_access+'" name="navsub_access[]" id="navsub_access_'+_this.nav_id+'" class="checkInput" title="접근자를 입력해 주세요." required="required" /></div>'
					elem += '<div><label for="navsub_link_'+_this.nav_id+'">URL</label><input type="text" value="'+_this.nav_link+'" name="navsub_link[]" id="navsub_link_'+_this.nav_id+'" class="checkInput" title="link를 입력해 주세요." required="required" /></div>';
					elem += '<div><label for="navsub_class_'+_this.nav_id+'">CSS class</label><input type="text" value="'+_this.nav_class+'" name="navsub_class[]" id="navsub_class_'+_this.nav_id+'" /></div>';
					elem += '<div><label for="navsub_meta_title_ko_'+_this.nav_id+'">페이지타이틀(ko)</label><input type="text" value="'+_this.nav_meta_title_ko+'" name="navsub_meta_title_ko[]" id="navsub_meta_title_ko_'+_this.nav_id+'" /></div>';
					elem += '<div><label for="navsub_meta_title_en_'+_this.nav_id+'">페이지타이틀(en)</label><input type="text" value="'+_this.nav_meta_title_en+'" name="navsub_meta_title_en[]" id="navsub_meta_title_en_'+_this.nav_id+'" /></div>';
					elem += '<div><label for="navsub_meta_title_vn_'+_this.nav_id+'">페이지타이틀(vn)</label><input type="text" value="'+_this.nav_meta_title_vn+'" name="navsub_meta_title_vn[]" id="navsub_meta_title_vn_'+_this.nav_id+'" /></div>';
					elem += '<div><label for="navsub_meta_keyword_ko_'+_this.nav_id+'">페이지키워드(ko)</label><input type="text" value="'+_this.nav_meta_keyword_ko+'" name="navsub_meta_keyword_ko[]" id="navsub_meta_keyword_ko_'+_this.nav_id+'" /></div>';
					elem += '<div><label for="navsub_meta_keyword_en_'+_this.nav_id+'">페이지키워드(en)</label><input type="text" value="'+_this.nav_meta_keyword_en+'" name="navsub_meta_keyword_en[]" id="navsub_meta_keyword_en_'+_this.nav_id+'" /></div>';
					elem += '<div><label for="navsub_meta_keyword_vn_'+_this.nav_id+'">페이지키워드(vn)</label><input type="text" value="'+_this.nav_meta_keyword_vn+'" name="navsub_meta_keyword_vn[]" id="navsub_meta_keyword_vn_'+_this.nav_id+'" /></div>';
					elem += '<div><label for="navsub_meta_description_ko_'+_this.nav_id+'">페이지설명문구(ko)</label><textarea name="navsub_meta_description_ko[]" id="navsub_meta_description_ko_'+_this.nav_id+'">'+_this.nav_meta_description_ko+'</textarea></div>';
					elem += '<div><label for="navsub_meta_description_en_'+_this.nav_id+'">페이지설명문구(en)</label><textarea name="navsub_meta_description_en[]" id="navsub_meta_description_en_'+_this.nav_id+'">'+_this.nav_meta_description_en+'</textarea></div>';
					elem += '<div><label for="navsub_meta_description_vn_'+_this.nav_id+'">페이지설명문구(vn)</label><textarea name="navsub_meta_description_vn[]" id="navsub_meta_description_vn_'+_this.nav_id+'">'+_this.nav_meta_description_vn+'</textarea></div>';
				elem += '</div>';
				elem += '<input type="button" value="del" id="navdel-'+_this.nav_id+'" class="nav-delete-btn" />';
				elem += '</div>';
				if(_this.nav_depth == '2depth'){
				elem += '<ul class="subnav" id="parentid_'+_this.nav_id+'">';
				elem += '<li class="none-nav blind">등록된 메뉴가 없습니다.</li></ul>';
				}
				elem += '<input type="button" value="위" class="index_up_btn" />';
				elem += '<input type="button" value="아래" class="index_down_btn" />';
				elem += '</li>';
			return elem;
		}catch(err){
			alert(err)
		}
	};
	// 메뉴 ajax
	var navupdate_callAjaxFnc = function(action, sendData, tokenId, navtype, subnavId){
		if(navtype != 'subnav' && navtype != 'mainnav') return false;
		$.ajax({
			url:action,
			data:sendData,
			type:'post',
			dataType:"JSON",
			success:function(data){
				var retoken = '';
				if(navtype === 'mainnav'){
					$('#nav_list').find('>li.none-nav').remove();
				}else{
					if(subnavId)
						$('#parentid_'+subnavId).find('>li.none-nav').remove();
				}
				$.each(data.nav_list, function(){
					if(navtype === 'mainnav'){
						var elem = addmainnav_html(this);
						$('#nav_list').append(elem);
						$('#subnav-insert-sec1, #subnav-insert-sec2').find('.select_parent').append('<option value="'+this.nav_id+'" id="opt_nav_parent_'+this.nav_id+'">'+this.nav_name_ko+'</option>');
					}else{
						var elem = addsubnav_html(this);
						if(subnavId){
							$('#parentid_'+subnavId).append(elem);
							//$('#subnav-insert-sec1, #subnav-insert-sec2').find('.select_parent').append('<option value="'+this.nav_id+'" id="opt_nav_parent_'+this.nav_id+'">'+this.nav_name+'</option>');
						}
					}
				});
				$.each(data.nav_token, function(){
					retoken = this.nav_token;
				});
				$('.'+tokenId).val(retoken);
				options = data.nav_all;
				if($('#subnav-insert-sec1, #subnav-insert-sec2').hasClass('display-none')){
					$('#subnav-insert-sec1, #subnav-insert-sec2').removeClass('display-none');
				}
			},
			error:function(xhr, status, error){
				alert(status+' '+error+'ajax 통신에러 발생ddd. 잠시 후 다시 시도해 주세요.');
			}
		});
	};
	// 메뉴 순서 변경
	var navupdown_moudle_fnc = function(type, _this){
		var navlistwrap = _this.closest('ul');
		var navlist 	= _this.closest('li');
		var listLen 	= navlistwrap.find('>li').length;

		if(listLen > 1){
			var _index = navlist.index();
			try{
				navlist.find('.nav-index').val();
				var removeIndex = (type == 'up') ? (_index-1 <= 0) ? 0 : _index-1 : (_index+1 >= (listLen-1)) ? listLen-1 : _index+1;
				var cloneElem = navlist.clone(true);
				if(type == 'up'){
					navlistwrap.find('>li:eq('+removeIndex+')').before(cloneElem);
				}else{
					navlistwrap.find('>li:eq('+removeIndex+')').after(cloneElem);
				}
				navlist.remove();
				for(var i=0; i < listLen; i++){
					navlistwrap.find('>li:eq('+i+')').find('>.nav-index').val(i+1);
				}
			}catch(err){
				alert(err+' javascript 사용여부를 확인해 주세요.');
			}
		}
	};
	// 메뉴추가 form
	$('#addnavwrap').on("submit", ".navFrm", function(){
		var frmcheck = true;
		var frmname  = $(this).attr('id');
		$(this).find('input[type="text"]').each(function(){
			var name = $(this).attr('name');
			if($(this).hasClass('checkInput') && $(this).val().replace(/^\s+|\s+$/gm,'') == ''){
				$(this).focus();
				frmcheck = false;
				return false;
			}
		});
		if(!frmcheck){
			return false;
		}
		var action = "/homeAdm/nav/update";
		var sendData = $(this).serialize();
		var tokenId = "<?=$this->security->get_csrf_token_name()?>";
		if($(this).hasClass('subnavFrm')){
			var parent_val = (this.nav_depth.value == '2depth') ? this.nav_parent.value : this.nav_sub_parent.value;
			navupdate_callAjaxFnc(action, sendData, tokenId, 'subnav', parent_val);
		}else if($(this).hasClass('mainnavFrm')){
			navupdate_callAjaxFnc(action, sendData, tokenId, 'mainnav');
		}else{
			return false;
		}
		return false;
	});
	// 삭제버튼
	$('#addnavwrap').on("click", ".nav-delete-btn", function(){
		var nav_name = $(this).prev().prev().text();
		var tokenId = "<?=$this->security->get_csrf_token_name()?>";
		var token 	= $('#'+tokenId).val();
		if(confirm('"'+nav_name+'" 메뉴를 삭제하시겠습니까?\n하위메뉴가 있는경우 하위메뉴도 모두 삭제됩니다.')){
			var del_id = parseInt($(this).attr('id').split('-')[1]);
			var action = "/homeAdm/nav/update";
			var sendData = {
				'nav_type' : 'ajax',
				'nav_mode' : 'delete',
				'<?=$this->security->get_csrf_token_name()?>' : token,
				'nav_id'   : del_id
			}
			$.ajax({
				url:action,
				data:sendData,
				type:'post',
				dataType:"JSON",
				success:function(data){
					var retoken = '';
					$.each(data.del_result, function(){
						if(this.result){
							if($('#navdel-'+del_id).closest('ul').find('>li').length == 1){
								$('#navdel-'+del_id).closest('ul').append('<li class="none-nav">등록된 메뉴가 없습니다.</li>');
							}
							$('.select_parent').find('#opt_nav_parent_'+del_id).remove();
							if($('.select_parent').children().length < 1){
								$('#subnav-insert-sec1, #subnav-insert-sec2').addClass('display-none');
							}
							$('#navdel-'+del_id).closest('li').remove();
						}else{
							alert('ajax 통신에러 발생. 잠시 후 다시 시도해 주세요.');
						}
						retoken = this.nav_token;
					});
					options = data.nav_all;
					$('.'+tokenId).val(retoken);
				},
				error:function(xhr, status, error){
					alert(status+' '+error+'ajax 통신에러 발생. 잠시 후 다시 시도해 주세요.');
				}
			});
		}else{
			return false;
		}
	});
	// 위치수정 위로
	$('#addnavwrap').on("click", ".index_up_btn", function(){
		navupdown_moudle_fnc('up', $(this));
	});
	// 위치수정 아래로
	$('#addnavwrap').on("click", ".index_down_btn", function(){
		navupdown_moudle_fnc('down', $(this));
	});
	// 수정인풋박스 열기 닫기
	$('#addnavwrap').on("click", ".menu-box", function(){
		if($(this).hasClass('input-open')){
			$(this).removeClass('input-open');
			$(this).next('.input-box').addClass('close-box');
		}else{
			$(this).addClass('input-open');
			$(this).next('.input-box').removeClass('close-box');
		}
	});
	// 2뎁스 셀렉트박스
	$('#addnavwrap').on('change', '#select_parent2', function(){
		var _index 		 = $(' option:selected', this).index();
		var options_html = '';
		var depth2		 = null;
		if(options[_index].nav_depth2){
			for(var i=0; i<options[_index].nav_depth2.length; i++){
				depth2 		 = options[_index].nav_depth2[i];
				options_html += '<option value="'+parseInt(depth2.nav_id)+'" id="opt_nav_sub_parent_'+depth2.nav_id+'">'+depth2.nav_name_ko+'</option>';
			}
		}else{
			options_html += '<option value="0">하위메뉴없음</option>';
		}
		$('#select_sub_parent').children().remove();
		$('#select_sub_parent').append(options_html);
	});
	/* 메뉴 등록 수정 삭제 */
	//menu-insert-box-open
	$(document).on('click', '.menu-insert-box-open', function(){
		var status 	= $(this).data('menuboxStatus');
		var insert	= $(this).closest('.menu-insert-box').find('.insert-content');
		if(status === 'close'){
			$(this).data('menuboxStatus', 'open').val('close');
			insert.css('height', (insert.find('.inner-box').innerHeight()+1)+'px');

		}else{
			$(this).data('menuboxStatus', 'close').val('open');
			insert.css('height','0');
		}
	});
})(jQuery);
</script>
