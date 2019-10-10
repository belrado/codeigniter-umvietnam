;(function($){
	$.KYS_SlideJS = function(){
		this.wrapper		= '#psu-main-slide-wrap'
		this.elem			= '#KysSlide';
		this.prevBtn		= '#mainJSprevBtn';
		this.nextBtn		= '#mainJSnextBtn';
		this.elemLen		= 0;
		this.select			= 0;
		this.timmer			= null;
		this.timeSpeed		= 8000;
		this.position 		= [];
		this.positionC 		= [];
		this.transition 	= 'transform .86s ease-in-out';
		this.duration		= '.86s';
		this.moving			= false;
		this.loading		= false;
		/* false : 셋팅시 처음 child영역만 relative 잡고 나머진 absolute로 js로 잡음 */
		this.absolute_css	= false;
		this.transition_css = false;
		this.fullSize		= false;
		this.stepBtn		= true;
		this.carousel		= true;
	};
	$.KYS_SlideJS.prototype = {
		checkTransitionEvent:function(){
		    var el = document.createElement('fakeelement');
		    var transitions = {
		      'transition':'transitionend',
		      'OTransition':'oTransitionEnd',
		      'MozTransition':'transitionend',
		      'WebkitTransition':'webkitTransitionEnd',
			  'MsTransition':'msTransitionEnd'
		    };
		    for(var t in transitions){
		        if( el.style[t] !== undefined ){
		            return transitions[t];
		        }
		    }
		},
		get_select_num:function(num){
			if(num >=0){
				if(num >= this.elemLen){
					num = 0;
				}
			}else{
				num = this.elemLen-1;
			}
			return num;
		},
		set_slideHeight:function(wrapper, mainProgram, checkMnavBtn){
			var wrapper = wrapper || this.slideWrap;
			var mainProgram = mainProgram || this.mainProgram;
			var checkMnavBtn = checkMnavBtn || this.checkMnavBtn;
			if(checkMnavBtn.css('display') === 'none'){
				var winH = $(window).height();
				var headerH = 93;
				var mainProgram = (mainProgram.length===1)?mainProgram.innerHeight():0;
				var fullHeight 	= winH - 93 - mainProgram;
				if(fullHeight > 500){
					wrapper.css({'height':fullHeight+'px'});
				}else{
					wrapper.css({'height':'500px'});
				}
			}
		},
		set_stepBtn:function(){
			var html 	= '<div class="section_wrapper"><div class="slide-step-btn-sec">';
			html		+= '<ol class="slide-step-btn">';
			for(var i=0; i<this.elemLen; i++){
				html		+= '<li><input type="button" value="'+(i+1)+'" class="stepbtn '+((i==0)?'active':'')+'" data-selectnum="'+i+'" /></li>';
			}
			html		+= '</ol>';
			html		+= '<input type="button" value="pause" class="slide-play-btn" />';
			html		+= '</div></div>';
			return html;
		},
		setting:function(elem, resize){
			var resize = resize || false;
			var _this = this;
			// 부모 영역 100%로 잡고 전체넓이계산
			this.elemW 		= elem.innerWidth();
			this.elemLen 	= elem.children().length;
			try{
				if(resize){
					if(this.fullSize){
						_this.set_slideHeight();
					}
					var moveW = _this.position[1] - parseInt(_this.elemW);
					for(var i=1; i< _this.elemLen; i++){
						_this.position[i] = (_this.position[i]<0)?_this.position[i]+moveW:_this.position[i]-moveW;
					}
					elem.css({
						'transition':'0s',
						'transition-duration':'0s',
						'transform':'translate(0, 0)'
					});
					//_this.set_moving(elem, false, 'window');
					_this.set_moving(elem, false);
					_this.moving = false;
				}else{
					if(_this.fullSize){
						_this.set_slideHeight();
					}
					//if(_this.stepBtn){
						//_this.slideWrap.append(_this.set_stepBtn());
					//}
					elem.css({'transition-duration':_this.duration});
					elem.children().eq(_this.select).addClass('is_animate');
					for(var i=0; i< _this.elemLen; i++){
						var w = parseInt(_this.elemW)*i;
						_this.position[i] = (i==_this.elemLen-1)?parseInt(_this.elemW)*-1:w;
						_this.positionC[i] = (i==_this.elemLen-1)?parseInt(_this.elemW)*-1:w;
						// 100% 영역이라면 %로 잡아보자
						if(_this.checkTransitionEvent()){
							// css3 transition 지원
							elem.children().eq(i).css({'transform':'translate('+_this.position[i]+'px, 0)'});
						}else{
							// css2 transition 미지원
							elem.children().eq(i).css({'left':_this.position[i]+'px'});
							if(elem.children().eq(i).index() == _this.select){
								elem.children().eq(i).find('.text-box').stop(true, true).animate({'opacity':'1'}, 700);
							}
						}
						if(!_this.absolute_css){
							if(i===0){
								elem.children().eq(i).css({'position':'relative','top':0,'left':'0', 'width':'100%'});
							}else{
								elem.children().eq(i).css({'position':'absolute','top':0,'left':'0', 'width':'100%'});
							}
						}
					}
				}
			}catch(e){console.log(e)}
		},
		setPosition:function(animate, move){
			var move 	= move || 'next';
			var _this 	= this;
			var elem 	= this.slideElem;
			if(move==='next'){
				_this.select++;
				if(_this.select >= _this.elemLen) _this.select =0;

			}else{
				_this.select--;
				if(_this.select < 0) _this.select = _this.elemLen-1;
			}
			_this.set_moving(elem, animate, move);
		},
		setZindex:function(elem){
			console.log(this.select);
			for(var i=0; i<this.elemLen; i++){
				if(i >= this.select)
					elem.children().eq(i).css('z-index',(this.elemLen-i+this.select));
				else
					elem.children().eq(i).css('z-index',(this.select-i));
			}
		},
		set_moving:function(elem, animate, move){
			var _this = this;
			var animate = animate || false;
			var move 	= move || 'next';
			try{
				for(var i=_this.select; i<_this.elemLen; i++){
					_this.positionC[i] = _this.position[i-this.select];
				}
				for(var i=0; i<_this.select; i++){
					_this.positionC[i] = _this.position[_this.elemLen-(_this.select-i)];
				}
				if(animate){
					if(!_this.transition_css){
						elem.css({'transition':_this.transition});
					}else{
						elem.css({'transition-duration':_this.duration});
					}
				}else{
					if(!_this.transition_css){
						elem.css({'transition-duration':'0s'});
					}
				}
				if(move != 'window')
					_this.moving_action(elem, animate, 0, move);

			}catch(e){console.log(e)}
		},
		moving_action:function(elem, animate, movePos, move){
			var animate = animate || false;
			var movePos = movePos || 0;
			var move 	= move || 'next';
			var _this	= this;
			var addAnimateClass = function(){
				elem.children().eq(_this.select).addClass('is_animate');
			};
			var childrenSet = function(){
				elem.children().each(function(idx){
					var nowPos =_this.positionC[idx];
					if(_this.checkTransitionEvent()){
						// css3 transition 지원
						$(this).css({'transform':'translate('+(nowPos)+'px, 0)'});
						//$(this).css({'transform':'translate('+(nowPos+movePos)+'px, 0)'});
						addAnimateClass();
					}else{
						// css2 transition 미지원
						elem.css({
							'transform':'translate(0, 0)'
						});
						$(this).css({'left':(nowPos)+'px'});
						addAnimateClass();
						if(animate){
							if($(this).index() == _this.select){
								$(this).find('.text-box').stop(true, true).animate({'opacity':'1'}, 700);
							}else{
								$(this).find('.text-box').css({'opacity':0});
							}
						}else{
							if($(this).index() == _this.select){
								$(this).find('.text-box').css({'opacity':1});
							}else{
								$(this).find('.text-box').css({'opacity':0});
							}
						}
					}
					if(_this.stepBtn){
						$('.slide-step-btn input[type="button"]').removeClass('active');
						$('.slide-step-btn input[type="button"]').eq(_this.select).addClass('active');
					}
				});
			}
			var parentMove = function(position){
				elem.css({'transform':'translate('+position+', 0)'});
			}

			_this.moving = true;

			if(animate){

				if(move == 'next'){
					movePos = '-100%';
				}else if(move == 'prev'){
					movePos = '100%';
				}else{
					movePos = 0;
				}
				if(_this.checkTransitionEvent()){
					elem.css({'transition':_this.transition});
					parentMove(movePos);
					setTimeout(function(){
						_this.moving = false;
						elem.css({
							'transition':'none',
							'transform':'translate(0, 0)'
						});
						childrenSet();
					}, parseInt(_this.duration.replace(/[s.]+/g, '')) * 10);
				}else{
					elem.stop(true, true).animate({'left':movePos}, 700, function(){
						_this.moving = false;
						childrenSet();
						elem.css('left', 0);
					});
				}
			}else{

				elem.css({
					'transition':'none',
					'transform':'translate(0, 0)'
				});
				if(move !== 'touch')
					childrenSet();
				else
					elem.css({'transform':'translate('+movePos+'px, 0)'});

				_this.moving = false;
			}
		},
		start:function(){
			var _this = this;
			if(this.timmer === null){
				this.timmer = setInterval(function(){
					_this.setPosition(true);
				}, _this.timeSpeed);
			}
		},
		stop:function(){
			clearInterval(this.timmer);
			this.timmer = null;
		},
		setEvent:function(){
			var _this 	= this;
			var wrapper = _this.slideWrap;
			var elem 	= _this.slideElem;
			var nextBtn	= $(_this.nextBtn);
			var prevBtn	= $(_this.prevBtn);
			_this.start();
			wrapper.on({
				mouseenter:function(){
					if(!_this.pauseCheck)
						_this.stop();
				},
				mouseleave:function(){
					if(!_this.pauseCheck)
						_this.start();
				}
			});
			nextBtn.on({
				click:function(){
					if(!_this.moving){
						elem.children().not(':eq('+_this.select+')').removeClass('is_animate');
						_this.setPosition(true, 'next');
					}
				}
			});
			prevBtn.on({
				click:function(){
					if(!_this.moving){
						elem.children().not(':eq('+_this.select+')').removeClass('is_animate');
						_this.setPosition(true, 'prev');
					}
				}
			});
			if(_this.stepBtn){
				$(_this.wrapper).on('click', '.slide-step-btn input[type="button"]', function(e){
					var index = $(this).data('selectnum');
					if(_this.select !== index && !_this.moving){
						var old_select = _this.select;
						//_this.slideElem.children().css({'z-index':'1', 'transition-duration':_this.duration});
						//_this.slideElem.children().eq(_this.select).css('z-index','3');
						_this.select = index;
						//_this.slideElem.children().eq(_this.select).css('z-index','3');
						_this.slideElem.children().not(':eq('+old_select+')').removeClass('is_animate');
						_this.set_moving(_this.slideElem);
					}
				});
				$(_this.wrapper).on('click', '.slide-play-btn', function(e){
					if($(this).val()==='pause'){
						_this.pauseCheck = true;
						$(this).val('play');
						$(this).addClass('pause');
						_this.stop();
					}else{
						_this.pauseCheck = false;
						$(this).val('pause');
						$(this).removeClass('pause');
						_this.start();
					}
				});
			}
			elem.on({
				touchstart:function(e){
					_this.stop();
					var touch 		= e.originalEvent.touches[0] || e.originalEvent.changedTouches[0];
					_this.tmPosX	= null; // 터치 시작할때마다 x좌표변수 초기화
					_this._startX 	= e.pageX || touch.pageX;
					_this._startY 	= e.pageY || touch.pageY;
					elem.css({'transition-duration':'0s'});
				},
				touchmove:function(e){
					var touch = e.originalEvent.touches[0] || e.originalEvent.changedTouches[0];
					_this._left = (e.pageX || touch.pageX) - _this._startX;
					_this._top = (touch.pageY) - _this._startY;
					_this.tmPosX= parseInt(touch.screenX);
					_this.tmPosY = parseInt(touch.screenY);
					var w = _this._left < 0 ? _this._left * -1 : _this._left;
					var h = _this._top < 0 ? _this._top * -1 : _this._top;
					var tsum = _this.tmPosX-_this._startX;
					if(w > h){
						e.preventDefault();
						var move = _this.tmPosX-_this._startX;
						_this.moving_action($(this), false, move, 'touch');
						if(move>0){
							elem.children().eq(_this.get_select_num(_this.select-1)).addClass('is_animate');
						}else{
							elem.children().eq(_this.get_select_num(_this.select+1)).addClass('is_animate');
						}
					}
				},
				touchend:function(e){
					var touch = e.originalEvent.touches[0] || e.originalEvent.changedTouches[0];
					var t_tmPosX= (_this.tmPosX)?_this.tmPosX:parseInt(touch.screenX);
					var tsum = parseInt(t_tmPosX)-parseInt(_this._startX);
					if(tsum > 0){
						var posnone = $(_this.elem).innerWidth()/ 3;
						if(tsum < posnone){
							elem.css({'transition':_this.transition});
							elem.children().not(':eq('+_this.select+')').removeClass('is_animate');
							_this.moving_action($(this), true, 0, 'touch');
						}else{
							// 이전
							_this.setPosition(true, 'prev');
							elem.children().not(':eq('+_this.select+')').removeClass('is_animate');
						}
					}else{
						var posnone = $(_this.elem).innerWidth()/ 3 *-1;
						if(tsum > posnone){
							elem.css({'transition':_this.transition});
							elem.children().not(':eq('+_this.select+')').removeClass('is_animate');
							_this.moving_action($(this), true, 0, 'touch');
						}else{
							// 다음
							_this.setPosition(true, 'next');
							elem.children().not(':eq('+_this.select+')').removeClass('is_animate');
						}
					}
					_this.start();
				}
			});
		},
		init:function(){
			var _this = this;
			this.slideWrap		= $(_this.wrapper);
			this.slideElem		= $(_this.elem);
			this.pauseCheck		= false;
			if(this.fullSize){
				this.mainProgram	= $('.main-program-list');
				this.checkMnavBtn	= $('#mobile-navbtn-sec');
			}
			// 로딩 이미지 만들어준다..
			_this.setting(_this.slideElem);
			$(window).load(function(){
				try{
					if(_this.loading){
						$('.loading').addClass('done');
					}
					_this.setting(_this.slideElem);
					if(_this.stepBtn){
						_this.slideWrap.append(_this.set_stepBtn());
					}
					_this.setEvent();
				}catch(e){}
			});
			$(window).resize(function(){
				_this.setting(_this.slideElem, true);
			});
		}
	};
})(jQuery);
