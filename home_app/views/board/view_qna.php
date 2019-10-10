<div class="section-full">
	<div class="section_wrapper">
		<div class="bbs-view-utility-sec">
			<ul class="bbs-view-utility">
			<?php if($user_lv && (int) $bbs_write_lv >= 2 && $user_lv >= (int) $bbs_write_lv) : ?>
			<li>
                <a href="<?=site_url()?><?=$umv_lang?>/board/write/<?=$bbs_table?>" class="bbs-write-btn bbs-update-btns" title="새글작성">
                    <?=stripslashes($lang_bbs['write'])?><span class="bbs-ico"></span>
                </a>
            </li>
			<?php endif ?>
			<?php if($my_write_check) : ?>
			<li>
				<a href="<?=site_url()?><?=$umv_lang?>/board/modify/<?=$bbs_table?>/<?=$bbs_result[0]->bbs_id?>/?select=<?=$sch_select?>&amp;keyword=<?=$sch_keyword?>&amp;paged=<?=$paged?>" class="bbs-modify-btn bbs-update-btns" title="글수정">
					<?=stripslashes($lang_bbs['modify'])?><span class="bbs-ico"></span>
				</a>
			</li>
			<?php endif ?>
			<?php if($my_write_check) : ?>
			<li>
				<?=form_open(site_url().'board/delete')?>
				<input type="hidden" name="bbs_table" value="<?=$bbs_table?>" />
				<input type="hidden" name="bbs_id[]" value="<?=$bbs_result[0]->bbs_id?>" />
				<p class="blind"><?=$bbs_result[0]->bbs_subject?> <?=stripslashes($lang_bbs['delete'])?></p>
				<input type="submit" value="삭제" class="bbs-del-btn bbs-update-btns" title="삭제" />
				</form>
			</li>
			<?php endif ?>
			<li>
				<a href="<?=site_url()?><?=$umv_lang?>/board/list/<?=strtolower($bbs_table)?>/<?=$cate_link?>/<?=$paged?>/?select=<?=$sch_select?>&amp;keyword=<?=$sch_keyword?>" class="bbs-list-btn">
					<?=stripslashes($lang_bbs['view_all_list'])?>
				</a>
			</li>
			</ul>
		</div>
		<div class="<?=$bbs_css_type?>-view <?=$bbs_type?>-view <?=($bbs_comment_lv > 0 && $comment)?'block-content':''?>">
			<div class="bbs-subject-sec">
				<h4 class="bbs-subject"><?=fnc_set_htmls_strip($bbs_result[0]->bbs_subject)?></h4>
				<div class="bbs-username">
					<strong class="blind"><?=stripslashes($lang_bbs['writer'])?></strong>
					<div class="layout-table">
						<div class="layout-table-cell">
							<?=fnc_set_htmls_strip($bbs_result[0]->user_name)?>
						</div>
					</div>
				</div>
				<div class="bbs-register">
					<strong class="blind"><?=stripslashes($lang_bbs['date'])?></strong>
					<div class="layout-table">
						<div class="layout-table-cell">
							<?=set_view_register_time($bbs_result[0]->bbs_register, 2, 8)?>
						</div>
					</div>
				</div>
			</div>
			<div class="bbs-content">
				<div class="content-sec">
					<?php if($bbs_adm && $bbs_type === 'gallery') : ?>
					<!-- // 이미지 파일 다운받기 급하게 만든거라 나중에 삭제하거나 수정해야함 . // -->
						<!-- // 리스트 이미지 방식 // -->
						<?php
							if(!empty($bbs_result[0]->bbs_image)){
								$bbs_image_t = str_replace('/assets/file/gallery/', '', $bbs_result[0]->bbs_image);
								$bbs_image_t = explode('/', $bbs_image_t);
								$bbs_image_f = 'list_'.$bbs_image_t[0].'_'.$bbs_image_t[1];
								$bbs_image_f = explode('.', $bbs_image_f);
								echo '<ul>';
								echo '<li><a href="'.site_url().$umv_lang.'/board/filedown/'.$bbs_image_f[0].'/img/'.$bbs_image_f[1].'">image down</a></li>';
								echo '</ul>';
							}
						?>
						<!-- // ck에디터 // -->
						<?php
							if(!empty($bbs_result[0]->bbs_content_imgs)){
								$bbs_content_imgs = explode(',', $bbs_result[0]->bbs_content_imgs);
								echo '<ul>';
								for($i=0; $i<count($bbs_content_imgs); $i++){
									$imgpath = explode('.', $bbs_content_imgs[$i]);
									echo '<li><a href="'.site_url().$umv_lang.'/board/filedown/ck_'.$imgpath[0].'/img/'.$imgpath[1].'">image down</a></li>';
								}
								echo '</ul>';
							}
						?>
					<!-- // end 이미지 파일 다운받기 급하게 만든거라 나중에 삭제하거나 수정해야함 . // -->
					<?php endif ?>
					<?php if($bbs_type === "youtube") : ?>
						<!-- // 유투브방식이면 삽입된 유투브 iframe 링크 출력 bbs_extra1 db테이블에 저장 // -->
						<div class="home-youtube-wrap block-content-txt">
							<iframe src="<?=stripslashes($bbs_result[0]->bbs_extra1)?>" allowfullscreen></iframe>
						</div>
					<?php endif ?>

					<?php /* 리스트 사진 본문에 뿌리기 이거 사용안할듯 if($bbs_type !== "blog" && $bbs_type !== "youtube" && $bbs_result_listf) : ?>
					<div class="text-alignC psupage-last-block"><img src="<?=site_url().str_replace(FCPATH, "", strip_tags(stripslashes($bbs_result_listf[0]->bf_path))).strip_tags(stripslashes($bbs_result_listf[0]->bf_name))?>" alt="" /></div>
					<?php endif */ ?>
					<div id="user-contents-box">
						<?=clean_xss_tags(stripslashes(str_replace('\r\n', PHP_EOL, $bbs_result[0]->bbs_content)))?>
					</div>
					<?php if($bbs_type==='blog' && !empty($bbs_result[0]->bbs_link)) : ?>
					<div class="bbs-blog-linkbox"><a href="<?=$bbs_result[0]->bbs_link?>" target="_blank"><img src="/assets/img/blog_link_img.png" alt="PSU블로그에서 보기" /></a></div>
					<?php endif ?>
					<?php if($bbs_type==='blog') : ?>
					<div class="nextprevbtn">
					<?php endif ?>
						<?php if($prev_bbs_id > 0) : ?>
						<a href="<?=site_url()?><?=$umv_lang?>/board/view/<?=$bbs_table?>/<?=$prev_bbs_id?><?=($is_cate_all)?'/?cate_type=all':''?>" class="bbs_view_btn bbs_view_prevbtn"><span class="blind">Prev</span></a>
						<?php endif ?>
						<?php if($next_bbs_id > 0) : ?>
						<a href="<?=site_url()?><?=$umv_lang?>/board/view/<?=$bbs_table?>/<?=$next_bbs_id?><?=($is_cate_all)?'/?cate_type=all':''?>" class="bbs_view_btn bbs_view_nextbtn"><span class="blind">Next</span></a>
						<?php endif ?>
					<?php if($bbs_type==='blog') : ?>
					</div>
					<?php endif ?>
				</div>
				<?php if($bbs_result_file) : ?>
				<ul class="bbs-file-list">
					<?php for($i=0; $i<count($bbs_result_file); $i++) : ?>
					<li>
						<a href="<?=site_url()?>board/filedown/<?=$bbs_result_file[$i]->bf_name?>/<?=$bbs_result_file[$i]->bf_id?>"><?=$bbs_result_file[$i]->bf_orig_name?> (<?=$bbs_result_file[$i]->bf_size?>KB) <img src="/assets/img/ico_file_down.png" alt="file down" /></a>
					</li>
					<?php endfor ?>
				</ul>
				<?php endif ?>
			</div>
			<ul class="bbs-snsbtn-sec">
				<li class="list facebook">
					<div class="section_wrapper">
						<div class="fb-like" data-href="<?=current_url()?>"
							data-width="340"
							data-layout="button_count"
							data-action="like"
							data-size="large"
							data-show-faces="true"
							data-share="true">
						</div>
					</div>
				</li>
				<li class="list">
					<form action="<?=site_url()?><?=$umv_lang?>/board/add_bbs_good" method="post" id="add_bbs_good">
						<input type="hidden" name='<?=$this->security->get_csrf_token_name()?>' value='<?=$this->security->get_csrf_hash()?>' class='csrf_token_home' />
						<input type="hidden" value="<?=$bbs_table?>" name="b_table" />
						<input type="hidden" value="<?=$bbs_result[0]->bbs_id?>" name="b_id" />
						<input type="hidden" value="is_ajax" name="ajax" />
						<input type="submit" value="<?=($bbs_result[0]->bbs_good>0)?$bbs_result[0]->bbs_good.' ':''?>Good" class="bbs-scrap-btn" />
					</form>
				</li>
				<?php if($user_lv >= 2) : ?>
				<li class="list scrap">
					<!-- // 스크랩버튼 //-->
					<div class="bbs-scrap-sec">
						<form action="<?=site_url()?><?=$umv_lang?>/board/add_bbs_scrap" method="post">
							<input type="hidden" name='<?=$this->security->get_csrf_token_name()?>' value='<?=$this->security->get_csrf_hash()?>' class='csrf_token_home' />
							<input type="hidden" value="<?=$bbs_table?>" name="b_table" />
							<input type="hidden" value="<?=$bbs_result[0]->bbs_id?>" name="b_id" />
							<p class="blind"><?=$bbs_result[0]->bbs_subject?> - <?=stripslashes($lang_bbs['script'])?></p>
							<input type="submit" value="<?=stripslashes($lang_bbs['script'])?>" class="bbs-scrap-btn" />
						</form>
					</div>
				</li>
				<?php endif ?>
			</ul>
		</div>
		<!-- // comment PATH: /view/board/comment.php // -->
		<?=$comment?>
		<!-- // end comment // -->
		<div class="bbs-view-btn-sec">
			<a href="<?=site_url()?><?=$umv_lang?>/board/list/<?=strtolower($bbs_table)?>" class="view-list-btn" title="<?=stripslashes($lang_bbs['view_all_list'])?>">
				<?=stripslashes($lang_bbs['view_all_list'])?>
			</a>
		</div>
	</div>
</div>
<script>
//<![CDATA[
(function($){
	"use strict";
	$(window).on('resize load', function(){
		$('.pos-middle').AbsoluteMiddle();
	});
	$('.bbs-content .content-sec').find('table').each(function(){
		if(!$(this).parent().hasClass('bbs-fixed-table')){
			$(this).wrap("<div class='bbs-fixed-table'></div>");
		}
	});
	var bbs_good_fnc = function(action, send_data, callback){
		$.ajax({
			type:"POST",
			url:action,
			data:send_data,
			dataType:"JSON",
			success:function(data){
				if(data.error_msg){
					alert(data.error_msg);
				}else{
					$('#add_bbs_good').find('input[type="submit"]').val('<?=($bbs_result[0]->bbs_good+1)?> Good');
				}
				callback();
				$('.csrf_token_home').val(data.bbs_token);
			},
			error:function(xhr, status, error){
				alert(status+'<?=stripslashes($lang_message['try_again_msg'])?>');
			}
		});
	}
	$('#add_bbs_good').submit(function(){
<?php if($this->session->userdata('user_id')) : ?>
		var _this 		= $(this);
		var action		= _this.attr('action');
		var send_data 	= _this.serialize();
		if(!_this.hasClass('already_good')){
			bbs_good_fnc(action, send_data, function(){
				_this.addClass('already_good');
			});
		}else{
			alert("<?=stripslashes($this->lang_message['bbs_error_code_0005'])?>");
		}
<?php else : ?>
		alert("<?=stripslashes($this->lang_message['requires_login_msg'])?>");
<?php endif ?>
		return false;
	})
})(jQuery);
//]]>
</script>
