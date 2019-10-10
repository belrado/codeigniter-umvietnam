(function($){
	try{
		var umv_lang = ((location.href).replace(/(https|http):\/\/umvietnam.com\//, '')).match(/^(en|vn|ko)/)[0] || 'en';
	}catch(e){
		var umv_lang = en;
	}
	var lang_menu = {
		'en':{
			'cmt_under_cmt':'Comments under comments',
			'delete':'Delete',
			'delete_as_adm':'Delete as administrator',
			'read_more':'Read more'
		},
		'vn':{
			'cmt_under_cmt':'Nhập bình luận dưới bình luận',
			'delete':'xóa',
			'delete_as_adm':'Xóa với tư cách quản trị viên',
			'read_more':'Đọc thêm'
		},
		'ko':{
			'cmt_under_cmt':'댓글의 댓글',
			'delete':'삭제',
			'delete_as_adm':'관리자 권한으로 삭제',
			'read_more':'더 보기'
		},
	};
/*
 * 댓글입력도 ajax로 바꾼다 -
 * 1뎁스 댓글 새로고침을 만든다
 * 댓글의 댓글 클릭시 처음만 ajax로 불러오고 그뒤로부턴 단순히 열기 닫기이며 새로고침 눌러야 새로운 데이터가 보인다.
 * 쿠키설정으로 1분당 1개씩만 글을 작성하게 만든다.
 */
// 보여질 갯수
var comment_limit_length = $('#comment-sec').data('commentLimit');
// 삭제 - 2뎁스 처리도 해야함 지금은 1만 되어있음 is_comment 1
function medi_comment_delete_ajax(send_data, _this){
	var action = '/'+umv_lang+'/board/comment_memberr_del/';
	$.ajax({
		type:"POST",
		url:action,
		data:send_data,
		dataType:"JSON",
		beforeSend:function(){

		},
		success:function(data){
			if(data.err_msg){
				if(data.err_msg !== 'none')
					alert(data.err_msg);
				$('.csrf_token_home').val(data.bbs_token);
			}else{
				if(data.delete == 'success'){
					if(send_data.bbs_is_comment>1){
						_this.closest('.comment-box2').find('.comment-reply-view').find('.comment-num').text(data.comment_cnt);
					}
					/*
					 * 삭제했다고 뒤에글 하나 더 불러오면 다른사람이 삭제했을시 중복데이터 불러옴
					 * 삭제 후 새롭게 다 불러들이는게 맞는 방식임
					 * ajax로 리스트를 새로 뿌릴것인지 리다이렉션 할건지 결정해야함
					 */
					/*
					if(parseInt(data.comment_cnt) == 0){
						_this.closest('.comment-box2').find('.comment-reply-refresh-sec').hide();
					}
					*/
					_this.closest('li').remove();
					$('.csrf_token_home').val(data.bbs_token);
				}
			}
		},
		error:function(xhr, status, error){
			alert('Server error. Please try again in a moment.');
			location.reload();
		}
	}).done(function(){

	});
}
// 더보기
function medi_comment_list_more_ajax(send_data, is_comment, _this){
	var is_comment = (is_comment)?is_comment:1;
	var action = '/'+umv_lang+'/board/comment_more/';
	var loading_elem = '<img src="/assets/img/loading_big.gif" alt="데이터 로딩중입니다." class="ico-loading" />';
	$.ajax({
		type:"POST",
		url:action,
		data:send_data,
		dataType:"JSON",
		beforeSend:function(){
			if(send_data.c_mode && send_data.c_mode == 'refresh'){
				_this.next('.loading_elem').remove();
				_this.after(loading_elem);
			}
		},
		success:function(data){
			var morelist_html 		= '';
			var morelist_btn_html 	= '';
			var comment_total 		= 0;
			if(data.err_msg){
				if(data.err_msg !== 'none')
					alert(data.err_msg);
			}else{
				$.each(data.more_list, function(){
					morelist_html += '<li data-comment-listid="'+this.bbs_id+'">';
					morelist_html += '<div class="comment-box">';
					// header
					morelist_html += '<div class="comment-header">';
					if(this.user_level >= 7){
						morelist_html += '<strong class="color_7a0019">'+this.user_name+'</strong>';
						morelist_html += '<sup class="suser">['+this.user_nick+']</sup>';
					}else{
						morelist_html += this.user_email;
						morelist_html += '<sup class="user">['+this.user_name+']</sup>';
					}
					morelist_html += '</div>';
					// content
					morelist_html += '<div class="comment-list-body">'+this.bbs_content;
						morelist_html += '<p class="date">'+this.bbs_register+'</p>';
					morelist_html += '</div>';
					// delete btn
					morelist_html += '<div class="btn-del-sec">';
					if(this.user_del_check === 'my_comment'){
						if(this.bbs_is_comment == 1){
							_this_parent_id = this.parent_id;
						}else{
							_this_parent_id = this.bbs_comment_parent;
						}
						morelist_html += '<a href="javascript:;" class="btn-comment-del" data-bbs-table="'+this.bbs_table+'" data-bbs-id="'+this.bbs_id+'" data-bbs-iscomment="'+this.bbs_is_comment+'" data-bbs-parent="'+this.bbs_parent+'" data-bbs-commentparent="'+this.bbs_comment_parent+'">'+lang_menu[umv_lang]['delete']+'</a>';
					}
					if(this.admin_del_check){
						morelist_html += '&nbsp;<a href="javascript:;" class="btn-comment-del" data-bbs-table="'+this.bbs_table+'" data-bbs-id="'+this.bbs_id+'" data-bbs-iscomment="'+this.bbs_is_comment+'" data-bbs-parent="'+this.bbs_parent+'" data-bbs-commentparent="'+this.bbs_comment_parent+'" data-comment-deltype="super">Del (adm)</a>'
					}
					morelist_html += '</div>';
					morelist_html += '</div>';
					if(is_comment == 1){
						morelist_html += '<div class="comment-box2 comment-list-body">';
						morelist_html += '<a href="javascript:;" class="comment-reply-view" data-bbs-table="'+this.bbs_table+'" data-bbs-id="'+this.bbs_id+'" data-bbs-iscomment="'+(parseInt(this.bbs_is_comment)+1)+'" data-bbs-parent="'+this.bbs_parent+'" data-bbs-commentparent="'+this.bbs_id+'">'+lang_menu[umv_lang]['cmt_under_cmt']+' '+this.bbs_comment+'</a>';
						morelist_html += '<div class="comment-reply-list"><ul class="comment-list"></ul></div>';
						morelist_html += '</div>';
					}
					morelist_html += '</li>';
					comment_total = parseInt(this.comment_total);
				});
				if(is_comment == 1){
					var comment_list_1depth = $('#comment-list-1depth');
					comment_list_1depth.append(morelist_html);
					var comment_list_len = comment_list_1depth.find('>li').length;
					if(comment_total <= comment_list_len){
						comment_list_1depth.next('.comment-more-sec').remove();
					}
				}else{
					var comment_reply_list = _this.closest('.comment-box2').find('.comment-list');
					// 새로고침이거나  ajax 글작성이면 우선적으로 리스트 삭제
					if((send_data.c_mode && send_data.c_mode == 'refresh') || (send_data.more_type && send_data.more_type == 'add_reply')){
						comment_reply_list.find('>li').remove();
						if(send_data.c_mode == 'refresh'){
							_this.next('.ico-loading').stop(true, true).delay(500).fadeOut(400, function(){
								$(this).remove();
							});
						}
					}
					// ajax 불러온 html 삽입
					comment_reply_list.append(morelist_html);
					var comment_list_len = comment_reply_list.find('>li').length;
					_this.closest('.comment-box2').find('.comment-reply-view').find('.comment-num').text(comment_total);
					// 1뎁스 더보기로 불러왓다면 새로고침 추가
					// 더보기 추가 삭제
					if(comment_total > comment_list_len){
						if(_this.closest('.comment-box2').find('.comment-more-sec').length < 1){
							morelist_btn_html 	= '<div class="comment-more-sec">';
							morelist_btn_html   += '<a href="javascript:;" class="comment-more-2depth" data-bbs-table="'+send_data.bbs_table+'" data-bbs-id="'+send_data.bbs_parent+'" data-bbs-iscomment="2" data-bbs-parent="'+send_data.bbs_parent+'" data-bbs-commentparent="'+send_data.bbs_comment_parent+'">'+lang_menu[umv_lang]['read_more']+'</a>';
							morelist_btn_html	+= '</div>';
							_this.closest('.comment-box2').find('.comment-reply-list').append(morelist_btn_html);
						}
					}else{
						if(_this.closest('.comment-box2').find('.comment-more-sec').length >0){
							_this.closest('.comment-box2').find('.comment-more-sec').remove();
						}
					}
					/*
					if(comment_total > 0 && comment_list_len>0){
						_this.closest('.comment-box2').find('.comment-reply-refresh-sec').show();
					}else{
						_this.closest('.comment-box2').find('.comment-reply-refresh-sec').hide();
					}
					*/
				}
			}
			// 2뎁스 댓글더보기 이며 오픈이면 1번만 실행임
			if(is_comment == 2 && send_data.more_type === 'reply_open' && _this){
				_this.addClass('in-comment-reply');
				//_this.closest('.comment-box2').find('.comment-list>li').remove();
			}
			$('.csrf_token_home').val(data.bbs_token);
		},
		error:function(xhr, status, error){
			alert('Server error. Please try again in a moment.');
			location.reload();
		}
	}).done(function(){
		if(send_data.c_mode == 'refresh' && _this.next('.ico-loading').length){
			_this.next('.ico-loading').stop(true, true).delay(500).fadeOut(400, function(){
				$(this).remove();
			});
		}
	});
}
// 댓글등록  ajax
function medi_comment_add_ajax(send_data, _this){
	var action = '/'+umv_lang+'/board/bbs_comment/';
	$.ajax({
		type:"POST",
		url:action,
		data:send_data,
		dataType:"JSON",
		beforeSend:function(){

		},
		success:function(data){
			if(data.err_msg){
				if(data.err_msg !== 'none')
					alert(data.err_msg);
				$('.csrf_token_home').val(data.bbs_token);
			}else{
				// 저장에 성공했다면 .. 2뎁스 메뉴라면  해당 댓글의댓글 새로 로드
				$('.csrf_token_home').val(data.bbs_token);
				_this.find('.comment-num').text(data.bbs_comment);
				_this.closest('.comment-box2').find('textarea').val('');
				_this.closest('.comment-box2').find('.limit-txtlength').text('0/300');
				var send_data2 	= {
					'bbs_table'				: send_data.bbs_table,
					'bbs_is_comment'		: 2,
					'bbs_parent'		 	: send_data.bbs_id,
					'bbs_comment_parent' 	: send_data.bbs_comment_parent,
					'comment_start'			: 0,
					'comment_limit'			: comment_limit_length,
					'more_type'				: 'add_reply',
					'csrf_token_home' 		: $('.csrf_token_home').val()
				};
				medi_comment_list_more_ajax(send_data2, 2, _this);
			}
		},
		error:function(xhr, status, error){
			alert('Server error. Please try again in a moment.');
			location.reload();
		}
	});
}
// 댓글의 댓글 등록 : 댓글입력하고난뒤 댓글의댓글창이 열려있어야하기에 ajax로 처리한다.
$('#comment-sec').on('submit', '.reply-comment-register', function(){
	var _this = $(this);
	var send_data = {
		'comment_type'		: 'add_ajax',
		'bbs_table' 		: _this.find('input[name="bbs_table"]').val(),
		'user_id'			: _this.find('input[name="user_id"]').val(),
		'user_name'			: _this.find('input[name="user_name"]').val(),
		'bbs_pwd'			: _this.find('input[name="bbs_pwd"]').val(),
		'bbs_id'			: _this.find('input[name="bbs_id"]').val(),
		'bbs_num'			: _this.find('input[name="bbs_num"]').val(),
		'bbs_is_comment'	: _this.find('input[name="bbs_is_comment"]').val(),
		'bbs_comment_parent': _this.find('input[name="bbs_comment_parent"]').val(),
		'bbs_content'		: _this.find('textarea[name="bbs_content"]').val(),
		'csrf_token_home'	: $('.csrf_token_home').val()
	};
	var reply_sec = _this.closest('.comment-reply-list').prev('a');
	medi_comment_add_ajax(send_data, reply_sec);
	return false;
});
// 댓글 삭제
$('#comment-sec').on('click', '.btn-comment-del', function(){
	var _this 		= $(this);
	var send_data = {
		'c_mode'			 : 'ajax',
		'bbs_table'			 : _this.data('bbsTable'),
		'bbs_is_comment'	 : _this.data('bbsIscomment'),
		'bbs_id'			 : _this.data('bbsId'),
		'bbs_parent'		 : _this.data('bbsParent'),
		'bbs_comment_parent' : _this.data('bbsCommentparent'),
		'c_del_type'		 : _this.data('commentDeltype'),
		'csrf_token_home'	 : $('.csrf_token_home').val()
	}
	if(send_data.c_del_type === 'super'){
		if(!confirm('관리자 권한으로 해당 댓글을 삭제하시겠습니까?\n하위 댓글이 있는경우 하위 댓글도 모두 삭제됩니다.')){
			return false;
		}
	}
	medi_comment_delete_ajax(send_data, _this);
});
// 1뎁스 댓글 더보기
$('.comment-more-1depth').on('click', function(){
	var _this 		= $(this);
	var list 		= $('#comment-list-1depth>li').length;
	var send_data 	= {
		'bbs_table'				: _this.data('bbsTable'),
		'bbs_id'			 	: _this.data('bbsId'),
		'bbs_is_comment'		: 1,
		'bbs_parent'		 	: _this.data('bbsParent'),
		'bbs_comment_parent' 	: _this.data('bbsCommentparent'),
		'comment_start'			: list,
		'comment_limit'			: comment_limit_length,
		'csrf_token_home' 		: $('.csrf_token_home').val()
	};
	//alert(send_data.comment_start+' '+send_data.comment_limit)
	medi_comment_list_more_ajax(send_data);
});
// 2뎁스 댓글 더보기
$('#comment-sec').on('click', '.comment-more-2depth', function(){
	var _this 		= $(this);
	var list 		= _this.closest('.comment-box2').find('.comment-list>li').length;
	var send_data 	= {
		'bbs_table'				: _this.data('bbsTable'),
		'bbs_id'			 	: _this.data('bbsId'),
		'bbs_is_comment'		: 2,
		'bbs_parent'		 	: _this.data('bbsParent'),
		'bbs_comment_parent' 	: _this.data('bbsCommentparent'),
		'comment_start'			: 0,
		'comment_limit'			: comment_limit_length,
		'list_last_id'			: parseInt($(this).closest('li').find('.comment-list>li:last').data('commentListid')),
		'csrf_token_home' 		: $('.csrf_token_home').val()
	};
	medi_comment_list_more_ajax(send_data, 2, $(this));
});
// 2뎁스 댓글 새로고침
$('#comment-sec').on('click', '.comment-reply-refresh', function(e){
	e.preventDefault ? e.preventDefault() : (e.returnValue = false);
	var _this 		= $(this);
	var send_data 	= {
		'c_mode'				: 'refresh',
		'bbs_table'				: _this.data('bbsTable'),
		'bbs_id'			 	: _this.data('bbsId'),
		'bbs_is_comment'		: 2,
		'bbs_parent'		 	: _this.data('bbsParent'),
		'bbs_comment_parent' 	: _this.data('bbsCommentparent'),
		'comment_start'			: 0,
		'comment_limit'			: comment_limit_length,
		'csrf_token_home' 		: $('.csrf_token_home').val()
	};
	medi_comment_list_more_ajax(send_data, 2, $(this));
});
// 댓글의댓글보기
$('#comment-sec').on('click', '.comment-reply-view', function(){
	var _this = $(this);
	var comment_reply_list 		= _this.next('.comment-reply-list');
	if(_this.hasClass('in-comment-reply')){
		// 댓글의댓글 목록이 불러와져있다면 숨김 보이기 기능을 실행한다.
		if(_this.hasClass('show-comment-reply')){
			// 댓글의댓글 목록 감추기
			_this.removeClass('show-comment-reply');
			comment_reply_list.hide();
		}else{
			// 댓글의댓글 목록 보이기
			_this.addClass('show-comment-reply');
			comment_reply_list.show();
		}
	}else{
		// 처음 클릭시 ajax로 해당 댓글의 댓글 목록을 불러온다.
		var comment_input_box_clone = $('#comment-input-box').children().clone(true);
		var parent_comment_id 		= $(this).data('bbsId');
		var parent_comment_id_input = '<input type="hidden" name="bbs_comment_parent" value="'+parent_comment_id+'" />';
		var bbs_is_comment 			= '<input type="hidden" name="bbs_is_comment" value="2" />';
		_this.addClass('show-comment-reply');
		comment_reply_list.show();
		try{
			// 댓글박스 셋팅
			if(comment_reply_list.find('form').length===0){
				comment_reply_list.prepend(comment_input_box_clone);
				comment_reply_list.find('form').addClass('reply-comment-register');
				comment_reply_list.find('form input:eq(0)').after(parent_comment_id_input);
				comment_reply_list.find('form input:eq(0)').after(bbs_is_comment);
				comment_reply_list.find('form textarea').val('');
			}
			// 댓글새로고침 셋팅
			if(comment_reply_list.find('.comment-reply-refresh-sec').length == 0){
				var refresh_link = $('.comment-reply-refresh:eq(0)').attr('href');
				comment_reply_refresh = '<div class="comment-reply-refresh-sec">';
				comment_reply_refresh += '<a href="'+refresh_link+'" class="comment-reply-refresh ico-refresh" ';
				comment_reply_refresh += 'data-bbs-table="'+_this.data('bbsTable')+'" data-bbs-id="'+_this.data('bbsParent')+'" data-bbs-parent="'+_this.data('bbsParent')+'" data-bbs-commentparent="'+_this.data('bbsId')+'">새로고침</a>';
				comment_reply_refresh += '</div>';
				comment_reply_list.find('form').after(comment_reply_refresh);
			}
			// 댓글이 있다면 불러온다.
			var send_data 	= {
				'bbs_table'				: _this.data('bbsTable'),
				'bbs_is_comment'		: _this.data('bbsIscomment'),
				'bbs_parent'		 	: _this.data('bbsParent'),
				'bbs_comment_parent' 	: _this.data('bbsCommentparent'),
				'comment_start'			: 0,
				'comment_limit'			: comment_limit_length,
				'more_type'				: 'reply_open',
				'csrf_token_home' 		: $('.csrf_token_home').val()
			};
			medi_comment_list_more_ajax(send_data, send_data.bbs_is_comment, _this);
		}catch(err){
			_this.next('.comment-reply-list').text('댓글의 댓글 기능 오류 잠시 후 다시 시도해 주세요.')
		}
	}
});
})(jQuery);
