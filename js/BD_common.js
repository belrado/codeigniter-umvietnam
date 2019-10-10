function getIds(name){
	return document.getElementById(name);
}
function getTag(elem,name){
	return (elem || document).getElementsByTagName(name);
}
function getName(name){
	return document.getElementsByName(name);
}
function getPrev(elem){
	do{
		elem = elem.previousSibling;
	}while(elem.nodeType != 1);
	return elem;
}
function getNext(elem){
	do{
		elem = elem.nextSibling;
	}while(elem && elem.nodeType != 1);
	return elem;
}
function addLoadEvent(func){
	var oldonLoad = window.onload;
	if(typeof window.onload !="function"){
		window.onload=func;
	}else{
		window.onload=function(){
			oldonLoad();
			func();
		}
	}
}
function js_strip_tags(input, allowed) {
    allowed = (((allowed || "") + "").toLowerCase().match(/<[a-z][a-z0-9]*>/g) || []).join('');
	// making sure the allowed arg is a string containing only tags in lowercase (<a><b><c>)
    var tags = /<\/?([a-z][a-z0-9]*)\b[^>]*>/gi,
        commentsAndPhpTags = /<!--[\s\S]*?-->|<\?(?:php)?[\s\S]*?\?>/gi;
    return input.replace(commentsAndPhpTags, '').replace(tags, function ($0, $1){
		return allowed.indexOf('<' + $1.toLowerCase() + '>') > -1 ? $0 : '';
    });
}
function js_banned_word_check(value, banned_word){
	var t = banned_word;
	var banned_word_a = t.split(',');
	for(var i=0; i<banned_word_a.length; i++){
		var word = banned_word_a[i].replace(/(^\s*)|(\s*$)/g, "");
		var reg = new RegExp(word, 'gi');
		if(reg.test(allclear_string_null(value))){
			alert('댓글에 금지단어 "'+word+'" 이(가) 포함되어 있습니다.');
			return false;
		}
	}
	return true;
}
function allclear_string_null(str){
	return str.replace(/(\s*)/g, '');
}
// 이름에 금지단어가 들어가 있는지 검사
function js_banned_name_check(value, banned_name, banned_word){
	var t = banned_name+banned_word;
	var banned_word_a = t.split(',');
	for(var i=0; i<banned_word_a.length; i++){
		var word = banned_word_a[i].replace(/(^\s*)|(\s*$)/g, "");
		var reg = new RegExp(word, 'gi');
		if(reg.test(value)){
			alert('이름에 금지단어 "'+word+'" 이(가) 포함되어 있습니다.');
			return false;
		}
	}
	return true;
}
// 숫자 카운팅
function PSUHomeNumberCounter(id, speed, str_obj, count){
	this.id = document.getElementById(id);
	this.maxnum = parseInt(this.id.innerHTML);
	this.num = 0;
	this.init();
	this.speed = speed ? parseInt(speed) : 8;
	this.strObj = str_obj ? str_obj : {'text':'','position':'back'};
	this.count = (count)?count:1;
};
PSUHomeNumberCounter.prototype = {
	counting:function(){
		var _this = this;
		setTimeout(function(){
			_this.id.innerHTML = (_this.strObj.position=='back')?_this.num+_this.strObj.text:_this.strObj.text+_this.num;
			_this.num = _this.num+_this.count;
			if(_this.num <= _this.maxnum){
				_this.counting();
			}else{

			}
		},_this.speed);
	},
	init:function(){
		this.counting();
	}
};
// 움직이는 탭네비 라인
function MovingTabLineNav(){
	this.id = '#news_blog_review_nav';
	this.line = '#active-line';
};
MovingTabLineNav.prototype = {
	setPos:function(id, line){
		try{
		var leftPos = id.position().left;
		line.css({'left':leftPos+'px'});
		}catch(e){}
	},
	setEvent:function(){
		var _this = this;
		$('#news_blog_review_nav a').on({
			mouseenter:function(){
				_this.setPos($(this), $(_this.line));
			}
		});
	},
	resize:function(){
		var _this = this;
		$(window).on('load', function(){
			$(_this.line).delay(200).animate({'opacity':'1'}, 500);
		});
		$(window).on('resize load', function(){
			_this.setPos($(_this.id).find('a.active'), $(_this.line));
		})
	},
	init:function(){
		//try{
			this.resize();
			this.setEvent();
		//}catch(e){}
	}
}
// 큰높이값구하기
function childBigFind(elem,childElem,multiple){
	var elemH=[],n=0;
	var obj = (multiple)?elem:$(elem);
	obj.find(childElem).each(function(){
		elemH[n] = $(this).innerHeight();
		n++;
	});
	var firstH = elemH[0];
	for(var i=1; i<n; i++){
		if(firstH < elemH[i]) firstH = elemH[i];
	}
	return firstH;
}
// 글자수제한
function check_content_byte(in_texts, text_max, check_cnt_elem){
	var ls_str = in_texts.value;
	var li_str_len = ls_str.length;
	var li_max = text_max;
	var i = 0;
	var li_byte = 0;
	var li_len = 0;
	var ls_one_char = "";
	var ls_str2 = "";
	for(i=0; i< li_str_len; i++){
		ls_one_char = ls_str.charAt(i);
		if(escape(ls_one_char).length > 4){
			li_byte += 2;
		}else{
			li_byte++;
		}
		if(li_byte <= li_max){
			li_len = i + 1;
		}
	}
	if(li_byte > li_max){
		alert( li_max + "글자를 초과하여 입력할수 업습니다.");
		ls_str2 = ls_str.substr(0, li_len);
		in_texts.value = ls_str2;
		li_byte = li_max;
	}
	try{
		getNext(getNext(in_texts)).innerHTML = li_byte+'/'+text_max;
		//getIds(check_cnt_elem).innerHTML = li_byte+'/'+text_max;
	}catch(e){}
}
// transition 지원여부
function whichTransitionEvent(){
    var el = document.createElement('fakeelement');
    var transitions = {
      'transition':'transitionend',
      'OTransition':'oTransitionEnd',
      'MozTransition':'transitionend',
      'WebkitTransition':'webkitTransitionEnd',
	  'MsTransition':'msTransitionEnd'
    }
    for(var t in transitions){
        if( el.style[t] !== undefined ){
            return transitions[t];
        }
    }
}
// 간단폼체크
function simple_text_validation(frm, name){
	var x = document.forms[frm][name].value;
	if(x == null || x.replace(/^\s+|\s+$/gm,'') == ""){
		return false
	}else{
		return true
	}
}
//체크박스 전체 선택
function check_all(f,name){
	var elemName = name || "chk[]";
    var chk = document.getElementsByName(elemName);
    for (i=0; i<chk.length; i++)
        chk[i].checked = f.checked;
}
// 휠높이값에 따른 css 에니메이션 클래스 추가
function animate_class_add(winheight){
	var winheight = (winheight)?winheight:1;
	var animate_tpos_arr = [];
	var animate_tpos_setting = function(){
		var wh = Math.round($(window).innerHeight()/winheight);
		$('.animate-sec').each(function(i){
			animate_tpos_arr[i] = Math.round($(this).offset().top);
			animate_tpos_arr[i] = (animate_tpos_arr[i]-wh < 0)?0:animate_tpos_arr[i]-wh;
			//alert(animate_tpos_arr[i])
			if((animate_tpos_arr[i] === 0 || $(window).scrollTop() >= animate_tpos_arr[i]) && !$(this).hasClass('is_animate')){
				$(this).addClass('is_animate');
				if($(this).hasClass('begine_animate_class'))
					$(this).removeClass('begine_animate_class');
			}
		});
	}
	var animate_tops_exec = function(){
		$('.animate-sec').each(function(i){
			if(!$(this).hasClass('is_animate')){
				if($(window).scrollTop() >= animate_tpos_arr[i]){
					$(this).addClass('is_animate');
					if($(this).hasClass('begine_animate_class'))
						$(this).removeClass('begine_animate_class');
				}
			}
		});
	}
	$(window).resize(function(){
		animate_tpos_setting();
	});
	$(window).scroll(function(){
		animate_tops_exec();
	});
	$(window).load(function(){
		animate_tpos_setting();
	});
}
/* home Nav */
function HomeGlobalNav(){
	this.wrap 		= $('#header');
	this.nav 		= $('#home_nav');
	this.mobile_btn = $('.btn-mobile-nav');
	this.transPos 	= 90;
}
HomeGlobalNav.prototype = {
	setFixedHeaderClass:function(topPos){
		if(Math.abs(topPos) > this.transPos){
			this.wrap.addClass('down-header');
		}else{
			this.wrap.removeClass('down-header');
		}
	},
	scrollDownHeaderEvent:function(){
		var _this 	= this;
		var _window = $(window);
		var topPos 	= _window.scrollTop() || 0;
		_this.setFixedHeaderClass(topPos);
		_window.on('scroll', function(){
			topPos = _window.scrollTop();
			_this.setFixedHeaderClass(topPos);
		});
	},
	event:function(){
		var _this = this;
		var show_depth2 = function(obj, elem){
			if(_this.mobile_btn.css('display') == 'none'){
				var h = obj.find('.home-nav2').innerHeight();
				var _this_obj = obj.find(elem);
				_this_obj.css('height',h+'px');
			}
		}
		var hide_depth2 = function(obj, elem){
			if(_this.mobile_btn.css('display') == 'none'){
				obj.find(elem).css('height','0');
			}
		}
		var show_click_depth = function(obj, elem){
			var h = obj.find('.home-nav2').innerHeight();
			var _this_obj = obj.find(elem);
			_this_obj.css('height',h+'px');
			_this.nav.find(elem).not(obj.find(_this_obj)).css('height','0');
			_this.nav.find('>li').not(obj).removeClass('is_click');
		}
		var hide_click_depth = function(obj, elem){
			obj.find(elem).css('height','0');
		}
		$('>li', this.nav).on({
			focusin:function(e){
				show_depth2($(this), '.home-subnav');
			},
			focusout:function(e){
				hide_depth2($(this), '.home-subnav');
			},
			mouseenter:function(e){
				show_depth2($(this), '.home-subnav');
			},
			mouseleave:function(e){
				hide_depth2($(this), '.home-subnav');
			}
		});
		_this.nav.find('.depth1-txt').on({
			click:function(e){
				if(!$(this).hasClass('only-depth1')){
					e.preventDefault ? e.preventDefault() : (e.returnValue = false);
					if(_this.mobile_btn.css('display') == 'block'){
						var parent = $(this).closest('li');
						if(!parent.hasClass('is_click')){
							parent.addClass('is_click');
							show_click_depth(parent, '.mobile-subnav-layer');
						}else{
							parent.removeClass('is_click');
							hide_click_depth(parent, '.mobile-subnav-layer');
						}
					}
				}
			}
		});
		_this.mobile_btn.on({
			click:function(e){
				e.preventDefault ? e.preventDefault() : (e.returnValue = false);
				$('.header-wrap .nav-wrap').addClass('mobile-open');
			}
		});
		$('.btn-close-mobile-nav, .mobile-nav-bg').on({
			click:function(){
				$('.header-wrap .nav-wrap').removeClass('mobile-open');
			}
		});
	},
	init:function(){
		var _this = this;
		_this.event();
		try{
			_this.scrollDownHeaderEvent();
		}catch(e){
			$(window).load(function(){
				setTimeout(function(){
					try{
						_this.scrollDownHeaderEvent();
					}catch(e){
						_this.setFixedHeaderClass(500);
					}
				},10);
			});
		}
	}
};
(function($){
	"use strict";
	$(document).ready(function(){
		/* 홈페이지 주 메뉴 */
		var init_home_nav = new HomeGlobalNav();
		init_home_nav.init();
		//var init_home_nav = new HomeGlobalNavNPopup();
		//init_home_nav.init();
		/* js_click_table 클래스 가진 테이블 전체클릭 */
		$('.js_click_table td').on({
			click:function(e){
				if(!$(this).hasClass('js_none_click')){
					e.preventDefault ? e.preventDefault() : (e.returnValue = false);
					var link 	= $(this).parent('tr').find('a').attr('href');
					var sublink = $.trim($(this).parent('tr').find('a').data('sublink'));
					var sublink_target = $.trim($(this).parent('tr').find('a').data('sublinkTarget'));
					var golink = (sublink !== '')?sublink:link;
					if(sublink != '' && $(this).find('a').hasClass('admin-link')){
						if(confirm('게시판 형식으로 보시겠습니까?')){
							document.location.href=link;
						}else{
							if(sublink_target === '_blank'){
								window.open(golink,'_blank');
							}else{
								document.location.href=golink;
							}
						}
					}else{
						if(sublink_target === '_blank'){
							window.open(golink,'_blank');
						}else{
							document.location.href=golink;
						}
					}
				}
			}
		});
		/* footer 패밀리사이트 */
		$('#family-tit-click').on({
			click:function(){
				if($(this).hasClass('is_click')){
					$(this).removeClass('is_click');
					$(this).next().css('height', '0px');
				}else{
					$(this).addClass('is_click');
					var h = $(this).next().find('ul').innerHeight();
					$(this).next().css('height', h+'px');
				}
			}
		});
		/* 상단바로가기 */
		var HomeTopBtn = function(){
			var doc     = $(document);
			var win 	= $(window);
			var homeH 	= win.innerHeight()/2;
			var topBtn 	= $('#home-top');
			var footer  = $('#footer');
			var setting = function(){
				var winTopPos 	= win.scrollTop();
				var footerH 	= footer.innerHeight();
				var last 		= doc.height() - win.height()-footerH;
				if(winTopPos > homeH){
					if(!topBtn.hasClass('is_show')){
						topBtn.addClass('is_show');
						topBtn.stop(true,true).fadeIn();
					}
				}else{
					if(topBtn.hasClass('is_show')){
						topBtn.removeClass('is_show');
						topBtn.stop(true,true).fadeOut();
					}
				}
			}
			topBtn.on({
				click:function(event){
					event.preventDefault ? event.preventDefault() : (event.returnValue = false);
					$('body,html').stop(true,true).animate({scrollTop:'0px'},650, 'easeInCubic');
					$('#skipnavigation').focus();
				}
			})
			this.init = function(){
				setting();
			}
		}
		var homeTopBtn = new HomeTopBtn();
		$(window).on('resize load scroll', homeTopBtn.init);
		/* ico-list 아이콘 을 valign middle 정렬 */
		if($('.ico-list').length>0){
			var icolistelem = $('.ico-list>li .tit-txt');
			icolistelem.css('top','50%').AbsoluteMiddle();
			$(window).resize(function(){
				icolistelem.css('top','50%').AbsoluteMiddle();
			});
		}
		/* 토글 */
		if ($('.psu-toggle-btn').length > 0) {
            $('.psu-toggle-btn').on({
                click: function(e) {
                    e.preventDefault ? e.preventDefault() : (e.returnValue = false);
                    var _this = $(this);
                    var viewElem = $(this).next('.psu-toggle-view');
                    if (_this.hasClass('open')) {
                        _this.removeClass('open');
                        _this.attr('title', '열기');
                        viewElem.stop(true, true).animate({
                            'height': '0px'
                        }, 300, function() {
                            $(this).css({
                                'height': 'auto'
                            }).addClass('psu-toggle-view-close');
                        });
                    } else {
                        var veiwHeight = viewElem.find('.psu-toggle-inner').innerHeight();
                        _this.addClass('open');
                        _this.attr('title', '닫기');
                        viewElem.removeClass('psu-toggle-view-close').css({
                            'height': '0px'
                        });
                        viewElem.stop(true, true).animate({
                            'height': veiwHeight + 'px'
                        }, 300, function() {
                            $(this).css({
                                'height': 'auto'
                            });
                        });
                    }
                }
            });
        }
        /* 같은페이지 앵커 : 바로가기 */
       if($('.anchor-thispage').length > 0) {
	       $('.anchor-thispage').on({
	       		click:function(e){
	       			 e.preventDefault ? e.preventDefault() : (e.returnValue = false);
	       			 var link = $(this).attr('href');
	       			 var linkPos = $(link).offset().top;
	       			 var headerH = ($('#header').innerHeight()==0)?$('#header-wrap').innerHeight():$('#header').innerHeight();
	       			 $('body,html').stop(true,true).animate({scrollTop:(linkPos-(headerH+50))+'px'},650, 'easeInCubic');
	       		}
	       });
	   }
	   /* 페이지 네비 */
		$('#mobile_subnav_box').on({
	   		click:function(e){
	   			var _this = $(this);
	   			if($('.mobile-subnav-ico').css('display')==='block'){
	   				if(_this.hasClass('box-open')){
	   					_this.removeClass('box-open');
	   					_this.height(50);
	   				}else{
	   					var h = _this.find('.page-subnav').innerHeight();
	   					_this.addClass('box-open');
	   					_this.height(h);
	   				}
	   			}
	   		}
	   	});
	   	$('#mobile_subnav_box').find('.this_active a').on({
	   		click:function(e){
	   			e.preventDefault ? e.preventDefault() : (e.returnValue = false);
	   		}
	   	});
		// 다운로드 js
		$(document).on('click', '.home-pdf-view-jsdown', function(e){
			e.preventDefault ? e.preventDefault() : (e.returnValue = false);
			var url = $(this).attr('href');
			var file = ""+url.match(/[^\/]+.{3,4}$/ig);
			var files = file.split('.');
			document.location.href="/board/filedown/"+files[0]+"/file/"+files[1];
		});
	});
	// 팝업

	// 탭버튼
	$.fn.homeTabNavEvent = function(options){
		var defaults = {
			tab_obj_wrap:'#tabcontents-wrap',
			tab_view_class:false,
			tab_view_reverse_class:false,
		}
		return this.each(function(){
			var _this = $(this);
			var opt   = $.extend({}, defaults, options);
			_this.find('a').on({
				click:function(e){
					e.preventDefault ? e.preventDefault() : (e.returnValue = false);
					if(!$(this).hasClass('active')){
						var this_obj 	= $(this);
						var view_tabid 	= this_obj.attr('href');
						var view_tabobj = (opt.tab_obj_wrap==='none')?_this.next():$(opt.tab_obj_wrap);
						if(view_tabid !== 'event-none'){
							_this.find('a').removeClass('active');
							this_obj.addClass('active');
							if(opt.tab_view_class){
								view_tabobj.children().removeClass('active');
								view_tabobj.find(view_tabid).addClass('active').focus();
							}else{
								view_tabobj.children().hide();
								view_tabobj.find(view_tabid).show().focus();
							}
							if(opt.tab_view_reverse_class){
								view_tabobj.children().addClass('none-active');
								view_tabobj.find(view_tabid).removeClass('none-active').focus();
							}
						}
					}
				}
			})
		});
	};
	// 토글버튼
	$.fn.homeToggleEvent = function(options){
		var defaults = {
			toggle_bottom:false,
			view_elem:'.home-toggle-view',
			view_inner_elem:'.home-toggle-inner',
			close_btn:'.home-toggle-close',
			close_btn_use:false,
			link_type:'href'
		}
		var closeEvent = function(this_obj, viewElem){
			this_obj.removeClass('open');
			this_obj.attr('title', '열기');
			viewElem.stop(true,true).animate({'height':'0px'}, 300, function(){
				$(this).css({'height':'auto'}).addClass('home-toggle-view-close');
			});
		}
		return this.each(function(){
			var _this = $(this);
			var opt   = $.extend({}, defaults, options);
			_this.on({
				click:function(e){
					e.preventDefault ? e.preventDefault() : (e.returnValue = false);
					var this_obj 	= $(this);
					var viewElem 	= (!opt.toggle_bottom) ? this_obj.next(opt.view_elem) : this_obj.prev(opt.view_elem);
					if(this_obj.hasClass('open')){
						closeEvent(this_obj, viewElem);
					}else{
						var veiwHeight 	= viewElem.find(opt.view_inner_elem).innerHeight();
						this_obj.addClass('open');
						this_obj.attr('title', '닫기');
						viewElem.removeClass('home-toggle-view-close').css({'height':'0px'});
						viewElem.stop(true,true).animate({'height':veiwHeight+'px'},300,function(){
							$(this).css({'height':'auto'});
						});
					}
				}
			});
			if(opt.close_btn_use){
				$(opt.close_btn).on({
					click:function(){
						var viewElem = $(this).closest(opt.view_elem);
						var subject_obj = viewElem.prev();
						if(subject_obj.hasClass('open')){
							closeEvent(subject_obj, viewElem);
						}
					}
				});
			}
		});
	};
	// 상세내용보기
	$.fn.PsuCustomNextElemOpen=function(options){
		var defaults = {
			nextViewElem: '.next-view-contents'
		}
		return this.each(function(){
			var _this = $(this);
			var opt = $.extend({},defaults,options);

			_this.on({
				click:function(e){
					e.preventDefault ? e.preventDefault() : (e.returnValue = false);
					var showElem = $(this).attr('href');
					if($(this).hasClass('viewopen')){
						$(this).removeClass('viewopen');
						$(showElem).removeClass('viewcontents');
					}else{
						$(this).addClass('viewopen');
						$(showElem).addClass('viewcontents');
					}
				}
			});
		});
	};
	// 자식영역 높이 맞추기
	$.fn.PsuChildAllHeight = function(options){
		var setting = function(elem, opt){
			var bigChildHeight = (opt.elem_multiple)?childBigFind(elem, opt.elem_clild, true):childBigFind(opt.elem, opt.elem_clild);
			elem.find(opt.elem_child_sec).css({'height':bigChildHeight+'px'});
		}
		return this.each(function(){
			var defaults={
				elem:'.child-allheight',
				elem_clild: 'div',
				elem_child_sec:'li',
				elem_multiple:false
			};
			var elem = $(this);
			var opt = $.extend({},defaults,options);
			setting(elem, opt);
			$(window).load(function(){
				setting(elem, opt);
			});
			$(window).resize(function(){
				setting(elem, opt);
			});
		});
	};
	$.fn.clickLinkSwitchJs = function(){
		return this.each(function(){
			$(this).find('a').click(function(e){
				e.preventDefault();
				var link = $(this).attr('href');
				document.location.href=link;
			});

			//$(this).find('a')
		});
	}
	// absolute 띄워서 중간위치 맞추기
	$.fn.AbsoluteMiddle = function(options){
		return this.each(function(){
			var _this = $(this);
			var th = _this.innerHeight();
			_this.css({'margin-top':-(th/2)+'px'});
		});
	};
	/* 유트브 또는 비디오 플레이 */
	$.fn.HomeVideoPlayer = function(options){
		var videoviewer = {
			video:function(title, video_mp4, video_ogg){
				if(arguments.length < 3 ) throw new Error('비디오 영상의 타이틀 또는 비디오 영상 링크 오류');
				var layer 	= '<div class="home-movielayer-wrap" id="home-movielayer-wrap"><article>';
				layer 		+= '<div class="video-content"><header><h1 class="blind">'+title+'</h1></header>';
				layer 		+= '<video id="psuvideo" width="100%" controls autobuffer autoplay>';
				layer 		+= '<source src="'+video_mp4+'" type="video/mp4; codecs=avc1.4D401E, mp4a.40.2">';
				layer 		+= '<source src="'+video_ogg+'" type="video/ogg">';
				layer 		+= '<embed src="'+video_mp4+'" type="application/x-shockwave-flash" width="100%" allowscriptaccess="always" allowfullscreen="true" style="width:100%"></embed>';
				layer 		+= '</video>';
				layer 		+= '<img src="/assets/img/loading2.gif" alt="로딩중입니다." class="loading" /><input type="button" class="home-youtub-close home-youtub-close-btn" value="닫기" /></div>';
				layer 		+= '<div class="bgsec home-youtub-close"><footer><div class="blind">PSU에듀센터(http://psuedu.org/)</div></footer></div></article></div>';
				return layer;
			},
			youtube:function(title, youtube_link){
				if(arguments.length < 2 ) throw new Error('유투브 영상의 타이틀 또는 유투브 영상 링크 오류');
				var layer 	= '<div class="home-movielayer-wrap" id="home-movielayer-wrap"><article>';
				layer 		+= '<div class="video-content"><header><h1 class="blind">메디프렙소개영상</h1></header>';
				layer 		+= '<div class="home-youtube-wrap"><iframe src="'+youtube_link+'" allowfullscreen></iframe></div>';
				layer 		+= '<img src="/assets/img/loading2.gif" alt="로딩중입니다." class="loading" /><input type="button" class="home-youtub-close home-youtub-close-btn" value="닫기" /></div>';
				layer 		+= '<div class="bgsec home-youtub-close"><footer><div class="blind">PSU에듀센터(http://psuedu.org/)</div></footer></div></article></div>';
				return layer;
			}
		}
		var videoviewer_opt = {
			videoevent:function(e){
				e.preventDefault ? e.preventDefault() : (e.returnValue = false);
				videoviewer_opt.video_close(e);
				try{
					if(e.data.opt.is_mobile){
						if(!confirm("3G/LTE 등으로 접속시\n데이터 통화료가 발생할 수 있습니다.")) return false;
					}
					var video_type = $(this).data('videoType');
					var video_html = videoviewer[$(this).data('videoType')]($(this).data('videoTitle'), $(this).data('videoLink'), $(this).data('videoLink2'));
					$('#contents').after(video_html);
					if($('#home-movielayer-wrap').find('iframe').length>0){
						$('#home-movielayer-wrap').find('iframe').load(function(){
							videoviewer_opt.video_loading();
						});
					}else{
						if(getIds('psuvideo').addEventListener){
							getIds('psuvideo').addEventListener('loadeddata', function(){
								videoviewer_opt.video_loading();
							});
						}else{
							getIds('psuvideo').attachEvent('loadeddata', function(){
								videoviewer_opt.video_loading();
							});
						}
					}
				}catch(e){
					alert(e);
				}
			},
			video_loading:function(){
				var video_wrap = $('#home-movielayer-wrap');
				video_wrap.find('.home-youtube-wrap').addClass('is-show');
				video_wrap.find('.loading').hide();
			},
			video_close:function(e){
				e.preventDefault ? e.preventDefault() : (e.returnValue = false);
				if($('#home-movielayer-wrap').length>0){
					$('#home-movielayer-wrap').remove();
				}
			}
		}
		$('#wrapper').on('click', '.home-youtub-close', videoviewer_opt.video_close);
		return this.each(function(){
			var defaults = {
				video_elem : '.video-elem',
				is_mobile : false,
				mobile_custom : false
			}
			var wrap = $(this);
			var opt = $.extend({}, defaults, options);
			if(opt.is_mobile && opt.mobile_custom){
				wrap.find(opt.video_elem).find('.youtube-go').on('click', {opt:opt}, videoviewer_opt.videoevent);
			}else if(opt.is_mobile){
				wrap.find(opt.video_elem).on('click', {opt:opt}, videoviewer_opt.videoevent);
			}else{
				wrap.find(opt.video_elem).on('click', {opt:opt}, videoviewer_opt.videoevent);
			}
		});
	};
})(jQuery);
