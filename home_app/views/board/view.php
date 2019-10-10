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
					<?=stripslashes($lang_bbs['modify'])?>
				</a>
			</li>
			<?php endif ?>
			<?php if($my_write_check) : ?>
			<li>
				<?=form_open(site_url().'board/delete')?>
				<input type="hidden" name="bbs_table" value="<?=$bbs_table?>" />
				<input type="hidden" name="bbs_id[]" value="<?=$bbs_result[0]->bbs_id?>" />
				<p class="blind"><?=$bbs_result[0]->bbs_subject?> <?=stripslashes($lang_bbs['delete'])?></p>
				<input type="submit" value="<?=stripslashes($lang_bbs['delete'])?>" class="bbs-del-btn bbs-update-btns" title="<?=stripslashes($lang_bbs['delete'])?>" />
				</form>
			</li>
			<?php endif ?>
			<li class="top-view-list">
				<a href="<?=site_url()?><?=$umv_lang?>/board/list/<?=strtolower($bbs_table)?>/<?=$cate_link?>/<?=$paged?>/?select=<?=$sch_select?>&amp;keyword=<?=$sch_keyword?>" class="bbs-list-btn bbs-update-btns">
					<?=stripslashes($lang_bbs['view_all_list'])?>
				</a>
			</li>
			</ul>
		</div>
		<div class="bbs-default-view-wrap <?=$bbs_css_type?>-view <?=$bbs_type?>-view <?=($bbs_comment_lv > 0 && $comment)?'block-content':''?>">
			<div class="bbs-subject-sec">
				<h4 class="bbs-subject">
					<?php if($bbs_result[0]->bbs_secret === 'yes') : ?>
					<img src="/assets/img/ico_bbs_lock.png" alt="<?=stripslashes($lang_bbs['secret_post'])?>" class="ico-lock" />
					<?php endif ?>
					<?=str_striptag_fnc($bbs_result[0]->bbs_subject)?>
				</h4>
				<ul class="bbs-post-info">
					<li>
						<strong class="label label-name"><?=ucfirst(stripslashes($lang_bbs['writer']))?> </strong>
					<?php if($bbs_result[0]->user_level>=7) : ?>
						<span class="name"><?=fnc_set_htmls_strip($bbs_result[0]->user_name)?>
							[<?=fnc_set_htmls_strip($bbs_result[0]->user_nick)?>]</span>
					<?php else : ?>
						<span class="name"><?=preg_replace('/@.*$/', '', fnc_set_htmls_strip($bbs_result[0]->user_email))?>
							[<?=fnc_name_change2(fnc_set_htmls_strip($bbs_result[0]->user_name), 6)?>]</span>
					<?php endif ?>
					</li>
					<li>
						<strong class="label label-date"><?=ucfirst(stripslashes($lang_bbs['date']))?></strong>
						<span class="name"><?=substr($bbs_result[0]->bbs_register, 0, 16)?></span>
					</li>
					<li>
						<strong class="label label-views"><?=ucfirst(stripslashes($lang_bbs['views']))?></strong>
						<span class="name"><?=fnc_set_htmls_strip($bbs_result[0]->bbs_hit)?></span>
					</li>
					<li>
						<strong class="label label-like"><?=ucfirst(stripslashes($lang_bbs['like']))?></strong>
						<span class="name"><?=fnc_set_htmls_strip($bbs_result[0]->bbs_good)?></span>
					</li>
				</ul>
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
						<div class="home-youtube-wrap block-section">
							<iframe src="<?=stripslashes($bbs_result[0]->bbs_extra1)?>" allowfullscreen></iframe>
						</div>
					<?php endif ?>
					<?php /* 리스트 사진 본문에 뿌리기 이거 사용안할듯 if($bbs_type !== "blog" && $bbs_type !== "youtube" && $bbs_result_listf) : ?>
					<div class="text-alignC psupage-last-block"><img src="<?=site_url().str_replace(FCPATH, "", strip_tags(stripslashes($bbs_result_listf[0]->bf_path))).strip_tags(stripslashes($bbs_result_listf[0]->bf_name))?>" alt="" /></div>
					<?php endif */ ?>
					<div id="user-contents-box">
					<?php if($bbs_type === "youtube") : ?>
						<?=nl2br(str_striptag_fnc($bbs_result[0]->bbs_content))?>
					<?php else : ?>
						<?=clean_xss_tags(stripslashes(str_replace('\r\n', PHP_EOL, $bbs_result[0]->bbs_content)))?>
					<?php endif ?>
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
			</div>
			<div>
				<?php if($bbs_result_file) : ?>
				<div class="bbs-file-list-sec">
					<strong class="label"><?=stripslashes($lang_bbs['attached_file'])?></strong>
					<ul class="bbs-file-list">
						<?php for($i=0; $i<count($bbs_result_file); $i++) : ?>
						<li>
							<a href="<?=site_url()?>board/filedown/<?=$bbs_result_file[$i]->bf_name?>/<?=$bbs_result_file[$i]->bf_id?>"><?=$bbs_result_file[$i]->bf_orig_name?> (<?=$bbs_result_file[$i]->bf_size?>KB)</a>
						</li>
						<li>
							<a href="<?=site_url()?>board/filedown/<?=$bbs_result_file[$i]->bf_name?>/<?=$bbs_result_file[$i]->bf_id?>"><?=$bbs_result_file[$i]->bf_orig_name?> (<?=$bbs_result_file[$i]->bf_size?>KB)</a>
						</li>
						<li>
							<a href="<?=site_url()?>board/filedown/<?=$bbs_result_file[$i]->bf_name?>/<?=$bbs_result_file[$i]->bf_id?>"><?=$bbs_result_file[$i]->bf_orig_name?> (<?=$bbs_result_file[$i]->bf_size?>KB)</a>
						</li>
						<?php endfor ?>
					</ul>
				</div>
				<?php endif ?>
				<ul class="bbs-sns-list">
					<li class="sns-facebook">
						<div class="fb-like" data-href="<?=current_url()?>"
							data-layout="button_count"
							data-action="like"
							data-size="small"
							data-show-faces="true"
							data-share="true">
						</div>
					</li>
					<li class="sns-list sns-like">
						<form action="<?=site_url()?><?=$umv_lang?>/board/add_bbs_good" method="post" id="add_bbs_good">
							<input type="hidden" name='<?=$this->security->get_csrf_token_name()?>' value='<?=$this->security->get_csrf_hash()?>' class='csrf_token_home' />
							<input type="hidden" value="<?=$bbs_table?>" name="b_table" />
							<input type="hidden" value="<?=$bbs_result[0]->bbs_id?>" name="b_id" />
							<input type="hidden" value="is_ajax" name="ajax" />
							<span class="views-num"><?=$bbs_result[0]->bbs_good?></span>
							<input type="submit" value="<?=($bbs_result[0]->bbs_good>0)?$bbs_result[0]->bbs_good.' ':''?>Good" class="bbs-like-btn" />
						</form>
					</li>
					<li class="sns-list sns-scrap">
						<form action="<?=site_url()?><?=$umv_lang?>/board/add_bbs_scrap" method="post" id="add_bbs_scrap">
							<input type="hidden" name='<?=$this->security->get_csrf_token_name()?>' value='<?=$this->security->get_csrf_hash()?>' class='csrf_token_home' />
							<input type="hidden" value="<?=$bbs_table?>" name="b_table" />
							<input type="hidden" value="<?=$bbs_result[0]->bbs_id?>" name="b_id" />
							<p class="blind"><?=$bbs_result[0]->bbs_subject?> - <?=stripslashes($lang_bbs['script'])?></p>
							<span class="scrap-txt"><?=stripslashes($lang_bbs['script'])?></span>
							<input type="submit" value="<?=stripslashes($lang_bbs['script'])?>" class="bbs-scrap-btn" />
						</form>
					</li>
				</ul>
			</div>
		</div>
		<!-- // comment PATH: /view/board/comment.php // -->
		<?=$comment?>
		<!-- // end comment // -->
		<div class="bbs-view-btn-sec bbs-view-utility">
			<a href="<?=site_url()?><?=$umv_lang?>/board/list/<?=strtolower($bbs_table)?>" class="bbs-list-btn bbs-update-btns" title="<?=stripslashes($lang_bbs['view_all_list'])?>">
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
					console.log('??');
					$('#add_bbs_good').find('.views-num').text('<?=($bbs_result[0]->bbs_good+1)?>');
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
	});
<?php if(!$this->session->userdata('user_id')) : ?>
	$('#add_bbs_scrap').submit(function(){
		alert("<?=stripslashes($this->lang_message['requires_login_msg'])?>");
		return false;
	});
<?php endif ?>
})(jQuery);
//]]>
</script>
