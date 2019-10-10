<div class="bbs-jsviewer-wrap" id="bbs-jsviewer-wrap">
	<div class="bbs-jsviewer">
		<div class="jsv-content use-jscontent" id="jsv-content">
			<div id="scroller-wrapper">
				<div id="scroller">

				</div>
			</div>
		</div>
		<div class="jsv-preview-list-sec" id="jsv-preview-list-sec">
			<div class="preview-bg"></div>
		</div>
	</div>
	<input type="button" value="이전사진" class="jsviewer-btn jsviewer-prevbtn" data-bbsnum="" data-bbsid="" />
	<input type="button" value="다음사진" class="jsviewer-btn jsviewer-nextbtn" data-bbsnum="" data-bbsid="" />
	<input type="button" value="닫기" class="jsviewer-closebtn" id="jsviewer-closebtn" />
	<div class="bbs-jsviewer-bg"></div>
</div>
<script src='<?=HOME_JS_PATH?>/iscroll.js'></script>
<script>
(function(){
var bbs_adm = "<?=$bbs_adm?>";
var myscroll;
function loaded () {
	myscroll = new IScroll('#scroller-wrapper', {
		zoom: true,
		scrollX: true,
		scrollY: true,
		mouseWheel: true
	});
}
var jsvObj = {
	viewerWrap:$('#bbs-jsviewer-wrap'),
	viewer:$('#jsv-content'),
	scrollerPlugin:('#scroller'),
	viewerlist:$('#jsv-preview-list-sec'),
	focuslist:'#bbs_gallery_list',
	tokenElem:$('#<?=$this->security->get_csrf_token_name()?>')
}
var delete_elem = function(){
	jsvObj.viewer.css({'-webkit-transition-duration':'0s','transition-duration':'0s', 'opacity':'0', 'transform':'translate3d(0, 0, 0)'});
	jsvObj.viewerWrap.find('.loading').remove();
	jsvObj.viewerWrap.find('.jsviewer-btn').removeClass('jsviewer-show');
	jsvObj.viewer.find('.jsv-header').remove();
	jsvObj.viewer.find('.vcontent-sec').remove();
	//jsvObj.viewer.find('#scroller').css('height','auto');
}
var fnc_resize_event = function(){
	if(jsvObj.viewer.find('.vcontent-sec').innerHeight() !== null && jsvObj.viewer.find('.vcontent-sec').innerHeight() <= jsvObj.viewer.innerHeight()){
		//jsvObj.viewer.find('#scroller').css('height','100%');
	}else{
		//jsvObj.viewer.find('#scroller').css('height','auto');
	}
}
$(window).on('resize', fnc_resize_event);
var jsviewer_ajax = function(_this, bbsid, bbsnum){
	var ajaxCheck   = false;
	var bbs_id 		= (bbsid)?bbsid:_this.data('bbsid');
	var bbs_num 	= (bbsnum)?bbsnum:_this.data('bbsnum');
	var action 		= "<?=site_url()?>board/bbs_view_ajax/";
	var token 		= jsvObj.tokenElem.val();
	var sendData 	= {
		'bbs_id':bbs_id,
		'bbs_table':'<?=$bbs_table?>',
		'bbs_cate':'<?=$category?>',
		'bbs_num':bbs_num,
		'<?=$this->security->get_csrf_token_name()?>':token
	}
	var loading_obj = '<img src="/assets/img/ico_rolling.gif" alt="데이터 로딩 중입니다. 잠시만 기다려 주세요." class="loading" />';
	$('#wrapper').css({'height':'100%'});
	jsvObj.viewerWrap.show();
	$.ajax({
		type:'post',
		url:action,
		data:sendData,
		dataType:"JSON",
		beforeSend:function(){
			delete_elem();
			jsvObj.viewerWrap.append(loading_obj);
		},
		success:function(data){
			if(data.err_msg){
				alert(data.err_msg);
			}else{
				var viewelem='';
				var previewlist = '';
				var prevlist 	= '';
				var prevlistarr = [];
				var _thisview   = '';
				var nextlist 	= '';
				$.each(data.bbs_view, function(){

					var header 	= '<article><header class="jsv-header"><h1>'+this.bbs_subject+'</h1>';
<?php if ($bbs_adm) : ?>
					if(bbs_adm){
						// 게시판 형식으로 보기
						header += '<a href="<?=site_url()?>board/view/<?=$bbs_table?>/'+this.bbs_id+'/?cate_type=<?=$category?>" class="jsviewer-view-btn">보기</a>';
						// 수정하기
						header += '<a href="<?=site_url()?>board/modify/<?=$bbs_table?>/'+this.bbs_id+'/?cate_type=<?=$category?>" class="jsviewer-modify-btn">수정</a>';
					}
<?php endif ?>
					header += '</header>';
					var content = '<div class="inner-content">';
					/* content += (this.bbs_image !== '') ? '<div style="margin:0 0 30px 0"><img src="'+this.bbs_image+'" alt="thumbnail-img '+this.bbs_subject+'" /></div>' : ''; */
					content += '<div style="color:#fff">'+this.bbs_content+'</div></div>';
					var footer  = '<footer class="blind">http://psuedu.org</footer></article>';
					jsvObj.viewer.find('#scroller').append('<div class="vcontent-sec"><div class="vcontent">'+header+content+footer+'</div></div>');
					_thisview += '<li><div class="active"><img src="'+this.bbs_thumbnail+'" alt="'+this.bbs_subject+'" /></div></li>';
				});
				$.each(data.bbs_prev, function(i){
					if(i==0){
						jsvObj.viewerWrap.find('.jsviewer-prevbtn').addClass('jsviewer-show').data('bbsid', this.bbs_id).data('bbsnum', this.bbs_num);
					}
					prevlistarr[i] = '<li><a href="<?=site_url()?>board/view/<?=$bbs_table?>/'+this.bbs_id+'/?cate_type=<?=$category?>" class="jsviewer-show" data-bbsid="'+this.bbs_id+'" data-bbsnum="'+this.bbs_num+'"><img src="'+this.bbs_thumbnail+'" alt="'+this.bbs_subject+'" /></a></li>';
				});
				for(i = prevlistarr.length-1; i>=0; i--){
					prevlist += prevlistarr[i];
				}
				$.each(data.bbs_next, function(i){
					if(i==0){
						jsvObj.viewerWrap.find('.jsviewer-nextbtn').addClass('jsviewer-show').data('bbsid', this.bbs_id).data('bbsnum', this.bbs_num);
					}
					nextlist += '<li><a href="<?=site_url()?>board/view/<?=$bbs_table?>/'+this.bbs_id+'/?cate_type=<?=$category?>" class="jsviewer-show" data-bbsid="'+this.bbs_id+'" data-bbsnum="'+this.bbs_num+'">';
					nextlist += '<img src="'+this.bbs_thumbnail+'" alt="" /></a></li>';
				});
				if(data.bbs_prev.length>0 || data.bbs_next.length>0){
					previewlist += '<ul class="jsv-preview-list" id="jsv-preview-list">';
					previewlist += prevlist;
					previewlist += _thisview;
					previewlist += nextlist;
					previewlist += '</ul>';
				}
				$('#jsv-preview-list').remove();
				jsvObj.viewerlist.append(previewlist);
				try{
					jsvObj.viewerWrap.imagesLoaded().always(function(){
						delete myscroll;
						myscroll = null;
						loaded();
						jsvObj.viewerWrap.find('.loading').stop(true, true).fadeOut(200, function(){
							$(this).remove();
						});
						jsvObj.viewer.css({'-webkit-transition-duration':'.5s','transition-duration':'.5s', 'opacity':'1'});
						if(jsvObj.viewer.find('#scroller').innerHeight() < jsvObj.viewer.innerHeight()){
							//jsvObj.viewer.find('#scroller').css('height','100%');
						}
					})
				}catch(err){

					jsvObj.viewerWrap.find('.loading').stop(true, true).fadeOut(200, function(){
						$(this).remove();
						$('#jsv-content').css('position', 'static');
					});
				}
				ajaxCheck=true;
			}
			jsvObj.tokenElem.val(data.bbs_token);
		},
		complete:function(){
			if(!ajaxCheck){
				delete_elem();
				jsvObj.viewerWrap.hide();
			}
		},
		error:function(xhr, status, error){
			delete_elem();
			alert(status+' '+error+'ajax 통신에러 발생. 잠시 후 다시 시도해 주세요.');
		}
	});
}
$('#bbs_gallery_list').on('click', 'a', function(e){
	e.preventDefault ? e.preventDefault() : (e.returnValue = false);
	/*
	if($(this).hasClass('admin-gallery-box')){
		if(confirm('게시판보기로 보시겠습니까?')){
			document.location.href=$(this).attr('href');
			return false;
		}
	}*/
	jsvObj.focuslist = $(this).attr('id');
	jsviewer_ajax($(this));
});
jsvObj.viewerWrap.on('click', '.jsviewer-show', function(e){
	e.preventDefault ? e.preventDefault() : (e.returnValue = false);
	jsviewer_ajax($(this));
});
$('.bbs-jsviewer-bg, #jsviewer-closebtn').on({
	click:function(){
		$('#wrapper').css({'height':'auto'});
		jsvObj.viewerWrap.hide();
		delete_elem();
		getIds(jsvObj.focuslist).focus();
	}
});
jsvObj.viewer.on({
	touchstart:function(e){
		//this.touchLength = e.originalEvent.touches.length || e.originalEvent.changedTouches.length;
		this.scaleCheck = Math.ceil($('#scroller').css('transform').replace(/^matrix(3d)?\((.*)\)$/,'$2').split(/, /)[0]);
		var touch = e.originalEvent.touches[0] || e.originalEvent.changedTouches[0];
		this._startX = e.pageX || e.originalEvent.touches[0].pageX;
		this._startY = e.originalEvent.touches[0].pageY;
		$(this).css({'-webkit-transition-duration':'0s','transition-duration':'0s'});
	},
	touchmove:function(e){
		if(this.scaleCheck <= 1){
			var touch = e.originalEvent.touches[0] || e.originalEvent.changedTouches[0];
			this._left = (e.pageX || e.originalEvent.touches[0].pageX) - this._startX;
			this._top = (e.originalEvent.touches[0].pageY) - this._startY;
			this.tmPosX= parseInt(touch.screenX);
			this.tmPosY = parseInt(touch.screenY);
			var w = this._left < 0 ? this._left * -1 : this._left;
			var h = this._top < 0 ? this._top * -1 : this._top;
			this.moveH = false;
			if(w > h ){
				e.preventDefault();
				var move = this.tmPosX-this._startX;
				$(this).css({'transform':'translate3d('+move+'px, 0, 0)'});
				this.moveH = true;
			}
		}
	},
	touchend:function(e){
		if(this.scaleCheck <= 1){
			e.preventDefault();
			$(this).css({'-webkit-transition-duration':'.2s','transition-duration':'.2s'});
			var tsum = this.tmPosX-this._startX;
			if(tsum > 0 && this.moveH){
				var posnone = $(window).innerWidth()/ 3;
				if(tsum < posnone){
					$(this).css({'transform':'translate3d(0, 0, 0)'});
				}else{
					if(jsvObj.viewerWrap.find('.jsviewer-prevbtn').hasClass('jsviewer-show')){
						var previd = jsvObj.viewerWrap.find('.jsviewer-prevbtn').data('bbsid');
						var prevnum = jsvObj.viewerWrap.find('.jsviewer-prevbtn').data('bbsnum');
						jsviewer_ajax($(this), previd, prevnum);
					}else{
						$(this).css({'transform':'translate3d(0, 0, 0)'});
					}
				}
			}else if (tsum <0 && this.moveH){
				var posnone = $(window).innerWidth()/ 3 *-1;
				if(tsum > posnone){
					$(this).css({'transform':'translate3d(0, 0, 0)'});
				}else{
					if(jsvObj.viewerWrap.find('.jsviewer-nextbtn').hasClass('jsviewer-show')){
						var previd = jsvObj.viewerWrap.find('.jsviewer-nextbtn').data('bbsid');
						var prevnum = jsvObj.viewerWrap.find('.jsviewer-nextbtn').data('bbsnum');
						jsviewer_ajax($(this), previd, prevnum);
					}else{
						$(this).css({'transform':'translate3d(0, 0, 0)'});
					}
				}
			}else{
				$(this).css({'transform':'translate3d(0, 0, 0)'});
			}
		}
	}
});
})(jQuery)
</script>
