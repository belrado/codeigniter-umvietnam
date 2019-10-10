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
				<ul class="bbs_youtube_list" id="bbs_youtube_list">
				<?php if($bbs_result) : ?>
					<?php foreach($bbs_result as $val) : ?>
					<li class="item-box">
						<?php if($bbs_adm) : ?>
						<input type="checkbox" name="bbs_id[]" value="<?=$val->bbs_id?>" class="admin-select-checkbox" />
						<?php endif ?>
						<div class="border-box">
							<a href="<?=$val->bbs_link?>" class="bbs-youtube-box"
								data-youyube-src="<?=stripslashes($val->bbs_extra1)?>"
								data-youyube-subject="<?=str_striptag_fnc($val->bbs_subject)?>"
								target="_blank" title="Video">
								<?php if(strtotime($val->bbs_register.'+'.'2'.' days') > strtotime(date('Y-m-d h:i:s', time()))) : ?>
								<div class="new-bbs"><img src="/assets/img/ico_new.gif" alt="새글" /></div>
								<?php endif ?>
								<div class="list-img">
								<?php if(!empty($val->bbs_image)) : ?>
									<img src="<?=$val->bbs_image?>" alt="<?=str_striptag_fnc($val->bbs_subject)?>" />
								<?php else : ?>
									<?php if(empty($val->bbs_link)) : ?>
										<img src="/assets/img/bbs/bbs_listimg_default3.jpg" alt="UMVietnam Video" />
									<?php else : $youtube_id = explode('/', $val->bbs_link);?>
										<img src="https://img.youtube.com/vi/<?=array_pop($youtube_id)?>/hqdefault.jpg" alt="UMVietnam Video" />
									<?php endif ?>
								<?php endif ?>
								</div>
							</a>
							<a href="<?=site_url()?>board/view/<?=$bbs_table?>/<?=$val->bbs_id?>" class="youtube-info-box" title="<?=stripslashes($lang_menu['read_more'])?>">
								<div class="subject-box">
									<?=str_striptag_fnc($val->bbs_subject, "<br />,<br>")?>
									<span class="read-more">[<?=$lang_menu['read_more2']?>]</span>
								</div>
								<div class="info-sec">
									<div class="author">
										<span class="date font-poppins">Date. <?=set_view_register_time($val->bbs_register, 0, 10, '-')?></span>
									</div>
									<div class="community">
										<span class="ico-box ico-good font-poppins"><?=$val->bbs_good?></span>
										<span class="ico-box ico-view font-poppins"><?=$val->bbs_hit?></span>
									</div>
								</div>
							</a>
						</div>
					</li>
					<?php endforeach ?>
				<?php else : ?>
					<li class="none-bbslist-sec">
						<div class="inner-box">
							<div class="list-img"><img src="/assets/img/bbs/bbs_listimg_default3.jpg" alt="UMVietnam Video" /></div>
							<p class="none-bbslist"><?=stripslashes($lang_message['no_registered_posts'])?></p>
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
<?php if($bbs_result) : ?>
<script src="/assets/js/jquery.marsonry.4.0.0.min.js"></script>
<script src="/assets/js/jquery.imagesloaded.min.js"></script>
<script>
// 동영상
var movieObj = {
	home:$('#contents'),
	wrap:$('#home-movielayer-wrap'),
	time:null
}
var set_homemovie_layer = function(subject, src){
	if(!src || src == 'undefined' || src == null) return false;
	var layer = '<div class="home-movielayer-wrap" id="home-movielayer-wrap"><div class="content vertical-middle-elem">';
	layer += '<article><header><h1 class="blind">'+subject+'</h1></header>';
	layer += '<div class="home-youtube-wrap"><iframe src="'+src+'?autoplay=1" allowfullscreen allow="autoplay"></iframe></div>';
	layer += '<img src="/assets/img/loading.gif" alt="loading.." class="loading" /><input type="button" class="home-youtub-close home-youtub-close-btn" value="<?=stripslashes($lang_menu['close'])?>" /></div><div class="bgsec home-youtub-close"></div>';
	layer += '<footer><p class="blind">UMVietnam https://umvietnam.com, +84.28.3724.4555 (ext. 6363) </p></footer></article></div>';
	return layer;
}
movieObj.home.on('click', '.bbs-youtube-box', function(e){
	e.preventDefault ? e.preventDefault() : (e.returnValue = false);
	var src = $(this).data('youyubeSrc');
	var subject = $(this).data('youyubeSubject');
	if(movieObj.wrap.length > 0){
		movieObj.wrap.remove();
	}
	try{
		var clone_elem = set_homemovie_layer(subject, src);
		if(!clone_elem){
			alert('동영상 주소가 없습니다. 잠시 후 다시 시도해 주세요.');
		}else{
			movieObj.home.after(clone_elem);
		}
	}catch(error){
		alert("<?=$lang_message['try_again_msg']?>")
	}
	movieObj.time = setTimeout(function(){
		$('#home-movielayer-wrap').find('.home-youtube-wrap').addClass('is-show');
		$('#home-movielayer-wrap').find('.loading').hide();
		movieObj.time = null;
	},500);
	$('.vertical-middle-elem').AbsoluteMiddle();
});
$('#wrapper').on('click', '.home-youtub-close', function(){
	if(movieObj.time !== null){
		clearTimeout(movieObj.time);
		movieObj.time = null;
	}
	$('#home-movielayer-wrap').remove();
});
$(window).on('resize load', function(){
	$('.vertical-middle-elem').AbsoluteMiddle();
});
// 더보기
var bbs_youtube_list = $('#bbs_youtube_list');
$(window).load(function(){
	// 블럭효과 jQuery 플러그인 적용
	try{
		bbs_youtube_list.masonry({
			percentPosition: true,
			columnWidth:'.item-box',
			itemSelector:'.item-box',
			percentPosition: true,
			transitionDuration: '.4s'
		});
	}catch(err){}
});
$('#ajax-more-btn').on({
	click:function(){
		var adminCheck = "<?=$bbs_adm?>";
		var tokenElem = $('#<?=$this->security->get_csrf_token_name()?>');
		var token = tokenElem.val();
		var action = "/board/bbs_list_ajax/";
		var sendData = {
			'bbs_table':'<?=$bbs_table?>',
			'bbs_cate':'<?=urlencode($category)?>',
			'limit':parseInt(<?=$bbs_list_num?>),
			'offset':parseInt($('>li', bbs_youtube_list).length),
			'<?=$this->security->get_csrf_token_name()?>':token
		};
		$.ajax({
			url:action,
			data:sendData,
			type:'post',
			dataType:"JSON",
			success:function(data){
				console.log(data);
				if(data.err_msg){
					alert(data.err_msg);
				}else{
					var elem = '';
					$.each(data.bbs_list, function(){
						elem += '<li class="item-box">';
						if(adminCheck){
							elem += '<input type="checkbox" name="bbs_id[]" value="'+this.bbs_id+'" class="admin-select-checkbox" />';
						}
						elem += '<div class="border-box">';
						elem += '<a href="'+this.bbs_link+'" class="bbs-youtube-box" data-youyube-src="'+this.bbs_extra1+'" data-youtube-subject="'+this.bbs_subject+'" target="_blank" title="Video">';
						if(this.bbs_new === 'new'){
							elem += '<div class="new-bbs"><img src="/assets/img/ico_new.gif" alt="New" /></div>';
						}
							elem += '<div class="list-img">';
							if($.trim(this.bbs_image)!==''){
								elem += '<img src="'+this.bbs_image+'" alt="'+this.bbs_subject+' Video" />';
							}else{
								if($.trim(this.bbs_link_last)==''){
								elem += '<img src="/assets/img/bbs/bbs_listimg_default3.jpg" alt="UMVietnam Video" />';
								}else{
								elem += '<img src="https://img.youtube.com/vi/'+this.bbs_link_last+'/hqdefault.jpg" alt="'+this.bbs_subject+' Video" />'
								}
							}
						elem += '</div></a>';
						elem += '<a href="<?=site_url()?>board/view/<?=$bbs_table?>/'+this.bbs_id+'" class="youtube-info-box" title="<?=stripslashes($lang_menu['read_more'])?>">';
							elem += '<div class="subject-box">'+this.bbs_subject2+'</div>';
							elem += '<div class="info-sec">';
								elem += '<div class="author"><span class="date font-poppins">Date. '+this.bbs_register2+'</span></div>'
								elem += '<div class="community">';
									elem += '<span class="ico-box ico-good font-poppins">'+this.bbs_good+'</span>';
									elem += '<span class="ico-box ico-view font-poppins">'+this.bbs_hit+'</span>';
						elem += '</div></div></a></div></li>';
					});
					var $items = $(elem);
					try{
						bbs_youtube_list.append($items).masonry('appended', $items, true);
						bbs_youtube_list.imagesLoaded(function(){
							bbs_youtube_list.masonry("reloadItems").masonry("layout");
						});
					}catch(err){
						bbs_youtube_list.append($items);
					}
				}
				if($.trim(data.bbs_list_last)==='yes'){
					$('.ajax-more-sec').remove();
				}
				tokenElem.val(data.bbs_token);
			},
			error:function(xhr, status, error){
				alert(status+' '+error+'ajax 통신에러 발생 잠시 후 다시 시도해 주세요.');
				location.reload();
			}
		});
	}
});
</script>
<?php endif ?>
