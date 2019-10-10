/***
* auther Bernardo
* email u5ink@naver.com
* homepage http://belrado.cafe24.com/
***/
;(function($){
$.SlidesKYS = function(){
	this.wrap 			= '#sliderYsWrap';
	this.elem 			= '#sliderYs';
	this.stepBtnWrap 	= null;
	this.stepBtn 		= false;
	this.stepBtnCustom 	= false;
	this.stepBtnStyle   = false;
	this.stepBtnId 		= null;
	this.nextBtn 		= null;
	this.prevBtn 		= null;
	this.stopBtn 		= null;
	this.speed 			= 900;
	this.opacity		= true;
	this.time			= null;
	this.timeSpeed		= 6000;
	this.uiEasing 		= false;
	this.easing 		= "swing";
	this.nonMovPosNum	= 4; // 터치시 되돌아가는 크기
	this.select 		= 0; // stepBtn 설정
	this.customWidth 	= null;
	this.menuName 		= null;
	this.imgloadingbar 	= false;
	this.loadingbarId 	= null;
	this.cssevent		= false;
}
$.SlidesKYS.prototype={
	elemlengthSetting:function(){
		var elem = $(this.elem);
		if(elem.children().length == 2){
			var firstClone = elem.children(':first').clone(true);
			var lastClone = elem.children(':last').clone(true);
			elem.prepend(lastClone);
			elem.append(firstClone);
		}
	},
	setting:function(){
		var elem = $(this.elem);
		var _this = this;
		var stopCheck = false;
		_this.sliderEndCheck = false;
		_this.len = elem.children().length;
		_this.rlMoveCheck = false;
		_this.setEasing='swing';
		_this.moveCheck = false;
		_this.ieVer = _this.getIEVer();

		(_this.opacity) ? this.opacityValue = 0 : this.opacityValue = 1;
		if(_this.uiEasing) _this.setEasing = _this.easing;
		if(_this.stepBtn) _this.stepBtnSetting();
		elem.children().not(elem.children(':eq(1)')).css({'opacity':this.opacityValue,'z-index':'1'});
		elem.children(':eq(1)').css({'opacity':1,'z-index':'2'});
		elem.css({'width':(_this.len+1)*100+'%','left':'-100%'});
		elem.children().css({'width':(100/(_this.len+1)).toFixed(5)+'%'});

		_this.getDeviceWidth();
		if(this.cssevent){
			elem.children().addClass('css_event');
			_this.spinevent_remove(elem);
		}

		$(window).resize(function(){
			_this.getDeviceWidth();
		});
		$(_this.wrap).on({
			mouseenter:function(){
				_this.stop();
			},
			mouseleave:function(){
				if(!stopCheck) _this.start();
			}
		});
		if(_this.nextBtn != null){
			$(_this.nextBtn).on({
				click:function(){
					_this.next();
					_this.rlMoveCheck = false;
				}
			});
		}
		if(_this.prevBtn != null){
			$(_this.prevBtn).on({
				click:function(){
					_this.prev();
					_this.rlMoveCheck = true;
				}
			});
		}
		if(_this.stopBtn != null){
			$(_this.stopBtn).on({
				click:function(){
					var check = $.trim($(this).val());
					if(check =='stop'){
						$(this).val('play').removeClass('stop').addClass('play');
						_this.stop();
						stopCheck=true;
					}else{
						$(this).val('stop').removeClass('play').addClass('stop');
						_this.stop();
						stopCheck=false;
					}
				}
			});
		}
		_this.loadingbarSetting();
		elem.on({
			touchstart:function(e){
				_this.stop();
				var touch = e.originalEvent.touches[0] || e.originalEvent.changedTouches[0];
				_this._startX = e.pageX || e.originalEvent.touches[0].pageX;
				_this._startY = e.originalEvent.touches[0].pageY;
				//var tPosX = parseInt(touch.screenX);
				this.sliderEndCheck = true;
			},
			touchmove:function(e){
				var touch = e.originalEvent.touches[0] || e.originalEvent.changedTouches[0];
				_this._left = (e.pageX || e.originalEvent.touches[0].pageX) - _this._startX;
				_this._top = (e.originalEvent.touches[0].pageY) - _this._startY;
				_this.tmPosX= parseInt(touch.screenX);
				_this.tmPosY = parseInt(touch.screenY);
				var w = _this._left < 0 ? _this._left * -1 : _this._left;
				var h = _this._top < 0 ? _this._top * -1 : _this._top;
				this.moveCheck=true;

				if(!_this.sliderEndCheck){
					if (w < h ) {
						_this.stop();
					} else {
						//_this.stop();
						e.preventDefault();
						//_this.mov = _this.tmPosX-_this._startX;
						var move = _this.tmPosX-_this._startX;
						$(this).css({'left':(move-_this.deviceW)+'px'});
						$(this).children().css({'opacity':1});
						$(this).children(':eq(1)').css({'z-index':'0'});
						$(this).children(':eq(1)').prev().find('.left-img, .right-img').css({'opacity':this.opacityValue});
						$(this).children(':eq(1)').next().find('.left-img, .right-img').css({'opacity':this.opacityValue});
						//_this.slidingCheck=false;
					}
				}
			},
			touchend:function(e){
				this.sliderEndCheck = false;
				_this.start();
				if(!_this.sliderEndCheck){
					if(this.moveCheck){
						e.preventDefault();
						var tsum = _this.tmPosX-_this._startX;
						if(tsum > 0){
							if(tsum < _this.nonMovPos){
								if(!_this.slidingCheck){
									_this.slidingCheck=true;
									$(this).stop().animate({'left':-_this.deviceW},50,function(){
										touchSetting($(this));
										_this.slidingCheck=false;
									});
								}
							}else{
								_this.prev(250);
								_this.rlMoveCheck=true;
							}
						}else{
							if(tsum > -_this.nonMovPos){
								if(!_this.slidingCheck){
									_this.slidingCheck=true;
									$(this).stop().animate({'left':-_this.deviceW},50,function(){
										touchSetting($(this));
										_this.slidingCheck=false;
									});
								}
							}else{
								_this.next(250);
								_this.rlMoveCheck=false;
							}
						}
						_this.loadingbarSetting();
					}
				}
				this.moveCheck=false;
			}
		});
		function touchSetting(elem){
			elem.children(':eq(1)').css({'z-index':'2'});
			elem.find('.left-img, .right-img').css({'opacity':'1'});
			elem.children().not(elem.children(':eq(1)')).css({'opacity':this.opacityValue,'z-index':'1'});
		}
	},
	spinevent:function(elem){
		if(this.cssevent){
			//elem.find('li').addClass('event_active');
			elem.children().removeClass('active_event');
			elem.find('.event-img').removeClass('spinevent');
			//if(this.supportsCssTransitions)
			elem.find('.event-img').css({'opacity':'0'});
		}
	},
	spinevent_remove:function(_this){
		if(this.cssevent){
			_this.children(':eq(1)').addClass('active_event');
			if(_this.children(':eq(1)').hasClass('event-list')){
				_this.children(':eq(1)').find('.event-img').addClass('spinevent');
			}
		}
	},
	next:function(speed){
		var speed = speed || this.speed;
		if(!this.sliderEndCheck){
			this.sliderEndCheck = true;
			this.setStepBtnSelect(true);
			var elem = $(this.elem), _this = this;
			_this.setOpacity(elem,1,2,speed);
			// css event
			_this.spinevent(elem);
			elem.stop(true,true).animate({'left':'-200%'},speed,this.setEasing,function(){
				$(this).children(':first').clone(true).appendTo(elem);
				$(this).children(':first').remove();
				$(this).css({'left':'-100%'});
				$(this).children().not($(this).children(':eq(1)')).css({'opacity':_this.opacityValue,'z-index':'1'});
				// css event
				_this.spinevent_remove($(this));
				$(this).find('.left-img, .right-img').css({'opacity':'1'});
				_this.sliderEndCheck = false;
				_this.setStepBtnActive();
			});
		}
	},
	prev:function(speed){
		var speed = speed || this.speed;
		if(!this.sliderEndCheck){
			this.sliderEndCheck = true;
			this.setStepBtnSelect(false);
			var elem = $(this.elem), _this = this;
			_this.setOpacity(elem,1,0,speed);
			// css event
			_this.spinevent(elem);
			elem.stop(true,true).animate({'left':'0'},speed,this.setEasing,function(){
				elem.children(':last').clone(true).prependTo(elem);
				elem.css({'left':'-100%'});
				$(this).children(':last').remove();
				$(this).children().not($(this).children(':eq(1)')).css({'opacity':_this.opacityValue,'z-index':'1'});
				// css event
				_this.spinevent_remove($(this));
				$(this).find('.left-img, .right-img').css({'opacity':'1'});
				_this.sliderEndCheck = false;
				_this.setStepBtnActive();
			});
		}
	},
	stepBtnNext:function(index,viewIds,speed){
		var _this=this;
		var speed = (speed || _this.speed);
		var elem = $(this.elem);
		if(!_this.sliderEndCheck){
			var last = viewIds.length;
			if(index != last){
				var viewIndex = $('#'+viewIds[index]).index();
			}else{
				var viewIndex = $('#'+viewIds[last]).index();
			}
			this.select = index-1;
			if(this.select < 0 ) this.select = this.len-1;
			if(this.select >= this.len) this.select = 0;
			if(viewIndex != $(_this.elem+">li:eq(1)").index()){
				// css event
				_this.spinevent(elem);
				_this.sliderEndCheck=true;
				if($('#'+viewIds[index]).index() == 0){
					$(_this.elem+">li:first").clone(true).appendTo($(_this.elem));
					$(_this.elem+">li:first").remove();
					$(_this.elem).css({'left':'0'});
					$(_this.elem+">li:lt("+(_this.len-1)+")").clone(true).appendTo($(_this.elem));
					$('#'+viewIds[index]).prevAll().not($(_this.elem+">li:first")).remove();
				}else{
					$(_this.elem+">li:lt("+viewIndex+")").clone(true).appendTo($(_this.elem));
					$('#'+viewIds[index]).prevAll().not($(_this.elem+">li:eq(1)")).remove();
					$(_this.elem).css({'left':'0'});
				}
				_this.setOpacity(elem,0,1,speed);
				elem.stop(true,true).animate({'left':'-100%'},speed,_this.setEasing,function(){
					$(_this.elem+">li:first").remove();
					$(_this.elem+">li:last").clone(true).prependTo($(_this.elem));
					$(_this.elem+">li:last").remove();
					// css event
				_this.spinevent_remove($(this));
					_this.sliderEndCheck=false;
				});
				_this.loadingbarSetting();
			}
		}
	},
	start:function(){
		var _this = this;
		if(this.time === null){
			this.time = setInterval(function(){
				(!_this.rlMoveCheck) ? _this.next() : _this.prev();
				_this.loadingbarSetting();
			},this.timeSpeed);
		}
	},
	stop:function(){
		clearInterval(this.time);
		this.time = null;
	},
	loadingbarMove:function(){
		$(this.loadingbarId).stop(true,true).animate({'width':'100%'}, this.timeSpeed-100);
	},
	loadingbarStop:function(){
		$(this.loadingbarId).stop();
		$(this.loadingbarId).css({'width':'0%'});
	},
	loadingbarSetting:function(){
		var _this = this;
		if(_this.imgloadingbar){
			if(_this.loadingbarId !== null){
				_this.loadingbarStop();
				_this.loadingbarMove();
			}
		}
	},
	getDeviceWidth:function(){
		if(this.customWidth === null){
			this.deviceW = this.getWinW();
		}else{
			this.deviceW = $(this.customWidth).innerWidth();
		}
		this.nonMovPos = this.deviceW / this.nonMovPosNum;
	},
	getWinW:function(){
		if(this.ieVer >=7 && this.ieVer <9){
			var wW = $(window).width();
		}else{
			var wW = window.innerWidth;
		}
		return wW;
	},
	getIEVer:function(){
		var rv = -1; // Return value assumes failure.
		if (navigator.appName == 'Microsoft Internet Explorer') {
			var ua = navigator.userAgent;
			var re = new RegExp("MSIE ([0-9]{1,}[\.0-9]{0,})");
			if (re.exec(ua) != null)
				rv = parseFloat(RegExp.$1);
			}
		return rv;
	},
	stepBtnSetting:function(){
		var _this = this;
		var idName = _this.elem;
		idName = idName.substring(1,idName.length);

		var testBtnClass = '';
		if(_this.kim == "testbtn"){
			testBtnClass = "class='testbtn'";
		}

		if(!this.stepBtnCustom){
			var btnwrap = (this.stepBtnWrap != null) ? this.stepBtnWrap : _this.wrap;
			var defaultStyle = (this.stepBtnStyle) ? 'psu_slidestepBtnWrap' : '';
			$(btnwrap).append("<ol id='"+idName+"stepBtnWrap2' "+testBtnClass+" class='"+defaultStyle+"'></ol>");
			for(var i=1; i<=this.len; i++){
				var menuNames = (_this.menuName !== null ) ? _this.menuName[(i-1)] : i;
				$(this.elem).children(':eq('+i+')').attr('id',idName+'viewImg'+i);
				if(i == this.len) $(this.elem).children(':first').attr('id',idName+'viewImg'+i);
				$(this.wrap).find('#'+idName+'stepBtnWrap2').append("<li><a href='#"+idName+"viewImg"+i+"'><span>"+menuNames+"</span></a></li>");
			}
			$(this.wrap).find('#'+idName+'stepBtnWrap2').css({'position':'absolute','z-index':'10'});
			$(this.wrap).find('#'+idName+'stepBtnWrap2>li').css({'float':'left'});
			$(this.wrap).find('#'+idName+'stepBtnWrap2>li:first>a').addClass('active');
			$(this.wrap).find('#'+idName+'stepBtnWrap2>li:last').addClass('last');
		}else{
			if(this.stepBtnId != null) {
				for(var i=1; i<= this.len; i++){
					$(this.elem).children(':eq('+i+')').attr('id',idName+'viewImg'+i);
					if(i == this.len) $(this.elem).children(':first').attr('id',idName+'viewImg'+i);
					$(this.wrap).find(this.stepBtnId+'>li:eq('+(i-1)+') a').attr('href','#'+idName+'viewImg'+i);
				}
			}
		}
		var viewIds = getIds($(_this.elem +">li"));
		var stepBtnIds = (this.stepBtnId != null) ? this.stepBtnId : '#'+idName+'stepBtnWrap2';
		$(this.wrap).find(stepBtnIds+'>li').on({
			click:function(e){
				e.preventDefault();
				if($(this).index() >= _this.len) return false;
				var _index = $(this).index()+1;
				if(_index >= _this.len) _index = 0;
				_this.stepBtnNext(_index,viewIds);
				_this.setStepBtnActive();
			}
		});
		function getIds(elem){
			var arg = [];
			var len = elem.length;
			for(var i=0; i<len; i++){
				arg[i] = elem.eq(i).attr('id');
			}
			return arg;
		}
	},
	setStepBtnSelect:function(check){
		if(check){
			this.select++;
			if(this.select >= this.len) this.select=0;
		}else{
			this.select--;
			if(this.select < 0) this.select=this.len-1;
		}
	},
	setStepBtnActive:function(){
		var idName = this.elem;
		var stepBtnIds = (this.stepBtnId != null) ? this.stepBtnId : idName+'stepBtnWrap2';
		idName = idName.substring(1,idName.length);
		$(this.wrap).find(stepBtnIds+'>li>a').removeClass('active');
		$(this.wrap).find(stepBtnIds+'>li:eq('+this.select+')>a').addClass('active');
		this.stepBtnCustomFnc();
	},
	stepBtnCustomFnc:function(){
	},
	setOpacity:function(elem,_index1,_index2,speed){
		elem.children(':eq('+_index1+')').css({'z-index':'1'}).animate({'opacity':this.opacityValue},speed);
		elem.children(':eq('+_index2+')').css({'z-index':'2'}).animate({'opacity':'1'},speed);
	},
	init:function(){
		this.elemlengthSetting();
		this.setting();
		this.start();
	}
}
})(jQuery);
