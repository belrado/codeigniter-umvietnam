<?php if(isset($depthTabNav)){ echo $depthTabNav;} ?>
<div class="section-full">
	<div class="section_wrapper">
		<?php if(!empty($bbs_page_tophtml)) : ?>
			<?=$bbs_page_tophtml?>
		<?php else : ?>
			
		<?php endif ?>
		
		<?php if($bbs_adm) : ?>

		<?php else : ?>
			
		<?php endif ?>
		
		<!-- 카테고리, 검색 -->
		<?=$cate_seach_sec?>
		<!-- // 카테고리, 검색 -->
		<div class="bbs-wrapper">
			<?php if($bbs_adm && $bbs_result) : ?>
			<form method="post" action="<?=site_url()?>board/delete">
				<input type="hidden" name="bbs_table" value="<?=$bbs_table?>" />		
			<?php endif ?>
				<input type="hidden" name="<?=$this->security->get_csrf_token_name()?>" value="<?=$this->security->get_csrf_hash()?>" id="<?=$this->security->get_csrf_token_name()?>" />
				<ul class="bbs_blog_list <?=($bbs_css_type==='bbs_typeB')?'bbs_blog_list2':'bbs_blog_list1'?> load_opacity" id="bbs_card_list">
				<?php if($bbs_result) : ?>
					<?php foreach($bbs_result as $val) : ?>
					<li class="item-box <?=($val->bbs_cate==='메디프렙')?'mediprep':(($val->bbs_cate ==='PSU에듀센터')?'psuedu':'blogdefault')?>">
						<?php if($bbs_adm) : ?>
						<input type="checkbox" name="bbs_id[]" value="<?=$val->bbs_id?>" class="admin-select-checkbox" />
						<a href="<?=site_url()?>board/modify/<?=$bbs_table?>/<?=$val->bbs_id?>" class="bbs-admin-modify-btn"><img src="http://mediprep.co.kr/assets/img/bbs/btn_gallery_modify_bt.png" /></a>
						<?php endif ?>
						<a href="<?=(empty($val->bbs_link))?site_url().'board/view/'.$bbs_table.'/'.$val->bbs_id:$val->bbs_link?>" target="<?=(empty($val->bbs_link))?'_self':'_blank'?>">
							<?php if(strtotime($val->bbs_register.'+'.'2'.' days') > strtotime(date('Y-m-d h:i:s', time()))) : ?>
							<img src="/assets/img/bbs/new_icon.png" alt="새글" class="new-bbs" />
							<?php endif ?>
							<?php if($bbs_css_type === 'bbs_typeB') : ?>
								<div class="blog-box2">
									<div class="blog-img">
									<?php if(!empty($val->bbs_image)) : ?>
										<img src="<?=fnc_set_htmls_strip($val->bbs_image)?>" alt="PSU에듀센터 블로그 최신글" />
									<?php else : ?>
										<img src="/assets/img/bbs/blog_default_psu.jpg" alt="PSU에듀센터 블로그 최신글" />
									<?php endif ?>
										<div class="imgbg-ico"></div>
										<div class="imgbg"></div>
									</div>
									<div class="blog-txt">
										<p class="subject"><?=fnc_set_htmls_strip($val->bbs_subject)?></p>
										<div class="footer">
											<?php if($val->user_id === '27802576@naver.com') : ?>
											<div class="blog-logo none1"><img src="/assets/img/bbs/<?=($val->bbs_cate=='메디프렙')?'medi':'psu'?>_logo.png" alt="<?=fnc_set_htmls_strip($val->bbs_cate)?>" /></div>
											<?php elseif($val->user_id === '40289486@naver.com') : ?>
											<div class="blog-logo">
												<img src="/assets/img/bbs/special_logo.png" alt="PSU특례&수시 - <?=fnc_set_htmls_strip($val->bbs_cate)?>" />
											</div>
											<?php else : ?>
											<div class="blog-logo none">Blog : <?=fnc_set_htmls_strip($val->bbs_cate)?></div>
											<?php endif ?>
											<span class="read-more">Read more</span>
										</div>
									</div>
								</div>
							<?php else : ?>
								<div class="blog-box">	
									<div class="blog-header">
										<div class="blog-subject">
											<img src="/assets/img/bbs/naver_logo.png" alt="네이버 blog" class="blog" />
											<p class="subject-txt"><?=fnc_set_htmls_strip($val->bbs_subject)?></p>
											<div class="subject-bg"></div>
										</div>
										<span class="blog-readmore">자세히보기</span>
									</div>
									<div class="blog-footer">
										<?php if($val->user_id === '27802576@naver.com') : ?>
										<div class="blog-logo none1"><img src="/assets/img/bbs/<?=($val->bbs_cate=='메디프렙')?'medi':'psu'?>_logo.png" alt="<?=$val->bbs_cate?>" /></div>
										<?php elseif($val->user_id === '40289486@naver.com') : ?>
										<div class="blog-logo">
											<img src="/assets/img/bbs/special_logo.png" alt="PSU특례&수시 - <?=$val->bbs_cate?>" />
										</div>
										<?php else : ?>
										<div class="blog-logo none">Blog : <?=$val->bbs_cate?></div>
										<?php endif ?>
										<div class="blog-register"><?=set_view_register_time($val->bbs_register)?></div>
									</div>
								</div>	
							<?php endif ?>
						</a>
					</li>	
					<?php endforeach ?>
				<?php else : ?>
					<li class="none-bbslist-sec">
						<div class="inner-box">
							<div class="list-img"><img src="/assets/img/bbs/bbs_default_img.png" alt="PSU에듀센터" /></div>
							<p class="none-bbslist">등록된 게시물이 없습니다.</p>
						</div>
					</li>
				<?php endif ?>
				</ul>
			<?php if($bbs_adm && $bbs_result) : ?>
				<input type="submit" value="선택삭제" class="bbs-adm-select-del" title="선택글 삭제" />
			</form>	
			<?php endif ?>
			<?php if($bbs_total_num > $bbs_list_num) :?>
			<div class="ajax-more-sec">
				<input type="button" class="ajax-more-btn" id="ajax-more-btn" value="더보기" />
			</div>
			<?php endif ?>
		</div>
	</div>
</div>
<script src="/assets/js/masonry.pkgd.min.js"></script>
<script src="/assets/js/jquery.imagesloaded.min.js"></script>
<script>
$(window).load(function(){
	try{
		$('#bbs_card_list .list-img').imagesLoaded().always(function(){
			try{
				$('#bbs_card_list').masonry({
					percentPosition: true,
					columnWidth:'.item-box',
					itemSelector:'.item-box',
					percentPosition: true,
					transitionDuration: '.4s'
				});	
			}catch(err){
				$('#bbs_card_list').addClass('default');
			}
			$('#bbs_card_list').removeClass('load_opacity');		
		});
	}catch(err){
		$('#bbs_card_list').addClass('default');
		$('#bbs_card_list').removeClass('load_opacity');
	}
});
</script>
<?php if($bbs_result) : ?>
<script>
$('#ajax-more-btn').on({
	click:function(){
		var adminCheck = "<?=$bbs_adm?>"; // 관리자라면 다중삭제가 가능하게 하기위해서
		var tokenElem = $('#<?=$this->security->get_csrf_token_name()?>');
		var token = tokenElem.val();
		var action = "/board/bbs_list_ajax/";
		var sendData = {
			'bbs_table':'<?=$bbs_table?>',
			'bbs_cate':'<?=urlencode($category)?>',
			'limit':parseInt(<?=$bbs_list_num?>),
			'offset':parseInt($('#bbs_card_list>li').length),
			'sch_select':'<?=$sch_select?>',
			'keyword':'<?=$keyword?>',
			'<?=$this->security->get_csrf_token_name()?>':token
		};
		$.ajax({
			url:action,
			data:sendData,
			type:'post',
			dataType:"JSON",
			success:function(data){
				if(data.err_msg){
					alert(data.err_msg);
				}else{
					var elem = '';
					$.each(data.bbs_list, function(){
						elem += '<li class="item-box '+((this.bbs_cate==='메디프렙')?'mediprep':((this.bbs_cate==='PSU에듀')?'psuedu':'blogdefault'))+'">';
						if(adminCheck){
							elem += '<input type="checkbox" name="bbs_id[]" value="'+this.bbs_id+'" class="admin-select-checkbox" />';
						}
						elem += '<a href="<?=site_url()?>board/view/<?=$bbs_table?>/'+this.bbs_id+'">';
					<?php if($bbs_css_type === 'bbs_typeB') : ?>
						elem += '<div class="blog-box2">';
							elem += '<div class="blog-img">';
							if(this.bbs_image !== ''){
								elem += '<img src="'+this.bbs_image+'" alt="PSU에듀센터 블로그 최신글" />';
							}else{
								elem += '<img src="/assets/img/bbs/blog_default_psu.jpg" alt="PSU에듀센터 블로그 최신글" />';
							}
								elem += '<div class="imgbg-ico"></div>';
								elem += '<div class="imgbg"></div>';
							elem += '</div>';
							elem += '<div class="blog-txt">';
								elem += '<p class="subject">'+this.bbs_subject+'</p>';
								elem += '<div class="footer">';
									if(this.user_name === '최정욱'){
										elem += '<div class="blog-logo none1"><img src="/assets/img/bbs/'+((this.bbs_cate=="PSU에듀센터")?"psu":"medi")+'_logo.png" alt="'+this.bbs_cate+'" /></div>';
									}else if(this.user_name ==='김혜원'){
										elem += '<div class="blog-logo"><img src="/assets/img/bbs/special_logo.png" alt="PSU특례&수시 - '+this.bbs_cate+'" /></div>';
									}else{
										elem += '<div class="blog-logo none">Blog : '+this.bbs_cate+'</div>';
									}
									elem += '<span class="read-more">Read more</span>';
								elem += '</div>';
							elem += '</div>';
						elem += '</div>';
					<?php else : ?>						
						elem += '<div class="blog-box">';
							elem += '<div class="blog-header">';
								elem += '<div class="blog-subject">';
									elem += '<img src="/assets/img/bbs/naver_logo.png" alt="네이버 blog" class="blog" />';
									elem += '<p class="subject-txt">'+this.bbs_subject+'</p><div class="subject-bg"></div></div>';
								elem += '<span class="blog-readmore">자세히보기</span></div>';
							elem += '<div class="blog-footer">';
								if(this.user_name === '최정욱'){
									elem += '<div class="blog-logo none1"><img src="/assets/img/bbs/'+((this.bbs_cate=="PSU에듀센터")?"psu":"medi")+'_logo.png" alt="'+this.bbs_cate+'" /></div>';
								}else if(this.user_name ==='김혜원'){
									elem += '<div class="blog-logo"><img src="/assets/img/bbs/special_logo.png" alt="PSU특례&수시 - '+this.bbs_cate+'" /></div>';
								}else{
									elem += '<div class="blog-logo none">Blog : '+this.bbs_cate+'</div>';
								}
								elem += '<div class="blog-register">'+this.bbs_register+'</div></div>';
						elem += '</div>';
					<?php endif ?>
						elem += '</a></li>';
					});
					var $items = $(elem);
					try{
						$('#bbs_card_list').append($items).masonry('appended', $items, true);
						$('#bbs_card_list').imagesLoaded(function(){
							$('#bbs_card_list').masonry("reloadItems").masonry("layout");	
						});
					}catch(err){
						$('#bbs_card_list').append($items);
					}
				}
				if($.trim(data.bbs_list_last)==='yes'){
					$('.ajax-more-sec').remove();
				}
				tokenElem.val(data.bbs_token);
			},
			error:function(xhr, status, error){
				alert(status+' '+error+'ajax 통신에러 발생. 잠시 후 다시 시도해 주세요.');
			}
		});
	}
});
</script>
<?php endif ?>