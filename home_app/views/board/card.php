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
				<ul class="bbs_card_list load_opacity" id="bbs_card_list">
				<?php if($bbs_result) : ?>
					<?php foreach($bbs_result as $val) : ?>
					<li class="item-box">
						<?php if($bbs_adm) : ?>
						<input type="checkbox" name="bbs_id[]" value="<?=$val->bbs_id?>" class="admin-select-checkbox" />
						<?php endif ?>
						<a href="<?=(empty($val->bbs_link))?site_url().'board/view/'.$bbs_table.'/'.$val->bbs_id:$val->bbs_link?>" target="<?=(empty($val->bbs_link))?'_self':'_blank'?>">
							<div class="inner-box">
								<div class="list-img">
								<?php if(!empty($val->bbs_thumbnail)) : ?>
									<img src="<?=$val->bbs_thumbnail?>" alt="PSU에듀센터" />
								<?php else : ?>
									<img src="/assets/img/bbs/bbs_default_img.png" alt="PSU에듀센터" />
								<?php endif ?>
								</div>
								<p class="list-subject">
									<?php if(!empty($val->bbs_cate)) : ?>[<?=stripslashes($val->bbs_cate)?>]<br /><?php endif?>
									<?=stripslashes($val->bbs_subject)?>
								</p>
								<p class="list-register"><?=set_view_register_time($val->bbs_register)?></p>
							</div>
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

<script src="/assets/js/jquery.imagesloaded.min.js"></script>
<script src="/assets/js/masonry.pkgd.min.js"></script>
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
<?php if($bbs_result) : ?>
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
							elem += '<li class="item-box">';
							if(adminCheck){
								elem += '<input type="checkbox" name="bbs_id[]" value="'+this.bbs_id+'" class="admin-select-checkbox" />';
							}
							elem += '<a href="<?=site_url()?>board/view/<?=$bbs_table?>/'+this.bbs_id+'"><div class="inner-box">';
							elem += '<div class="list-img">';
							elem += ($.trim(this.bbs_thumbnail)!=='') ? '<img src="'+this.bbs_thumbnail+'" alt="메디프렙" />' : '<img src="/assets/img/bbs/bbs_default_img.gif" alt="메디프렙" />';
							elem += '</div>';
							elem += '<p class="list-subject">'+this.bbs_subject+'</p>';
							elem += '<p class="list-register">'+this.bbs_register+'</p>';
							elem += '</div></a></li>';
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
