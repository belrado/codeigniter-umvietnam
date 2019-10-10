;(function($){
	$.KYS_SlideNoTurnJS = function(){
		this.wrapper 		= '#noturnjs_elem_sec';
		this.elem 	 		= '#noturnjs_elem';
		this.prevBtn 		= '#noturnjs_prev_btn';
		this.nextBtn 		= '#noturnjs_next_btn';
		this.isStepBtn		= true;
		this.transSpeed 	= .85;
		this.transEasing 	= 'ease-in-out';
	};
	$.KYS_SlideNoTurnJS.prototype={
		html_stepBtn:function(){
			var html ='<ol class="noturnjs-step-btn">';
			for(var i=0; i<this.len; i++){
				html += '<li><span class="step '+((i==0)?'active':'')+'">'+(i+1)+'</span></li>';
			}
			html += '</ol>';
			return html;
		},
		css_action:function(wrapper){
			this.show_prev_btn();
			this.show_next_btn();
			wrapper.find(this.elem).css({'transform':'translateX('+this.translateX+'%)'});
			if(this.isStepBtn){
				wrapper.find('.noturnjs-step-btn .step').removeClass('active');
				wrapper.find('.noturnjs-step-btn .step:eq('+this.select+')').addClass('active');
			}
		},
		show_prev_btn:function(){
			if(this.select == 0){
				$(this.prevBtn).hide();
			}else{
				$(this.prevBtn).show();
			}
		},
		show_next_btn:function(){
			if(this.select == this.len-1){
				$(this.nextBtn).hide();
			}else{
				$(this.nextBtn).show();
			}
		},
		set_prev_opt:function(){
			if(this.translateX<0){
				if(this.select > 0){
					this.select--;
				}
				this.translateX += this.children_width;
			}
		},
		set_next_opt:function(){
			if(Math.abs(this.translateX) < (100 - this.children_width)){
				if(this.select < this.len-1){
					this.select++;
				}
				this.translateX -= this.children_width;
			}
		},
		set_event:function(){
			var _this = this;
			var wrapper = $(_this.wrapper);
			wrapper.find(_this.prevBtn).on({
				click:function(){
					_this.set_prev_opt();
					_this.css_action(wrapper);
				}
			});
			wrapper.find(_this.nextBtn).on({
				click:function(){
					_this.set_next_opt();
					_this.css_action(wrapper);
				}
			});
			wrapper.on({
				mouseenter:function(){
					_this.show_prev_btn();
					_this.show_next_btn();
				},
				touchstart:function(e){	
					var touch 		= e.originalEvent.touches[0] || e.originalEvent.changedTouches[0];
					_this.tmPosX	= null; // 터치 시작할때마다 x좌표변수 초기화 
					_this.transXpos = null;
					_this._startX 	= e.pageX || touch.pageX;
					_this._startY 	= e.pageY || touch.pageY;
					$(this).find(_this.elem).css({'transition':'none'});
					_this.transXpos = parseInt($(this).find(_this.elem).css('transform').split(',')[4]);
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
						$(this).find(_this.elem).css({'transform':'translateX('+(move+_this.transXpos)+'px)'});
					}						
				},
				touchend:function(e){
					var touch = e.originalEvent.touches[0] || e.originalEvent.changedTouches[0];
					var t_tmPosX= (_this.tmPosX)?_this.tmPosX:parseInt(touch.screenX);
					var tsum = parseInt(t_tmPosX)-parseInt(_this._startX);
					$(this).find(_this.elem).css({'transition':'transform '+_this.transSpeed+'s '+_this.transEasing});
					if(tsum > 0){
						var posnone = wrapper.innerWidth()/ 3;
						if(tsum > posnone){
							// prev
							_this.set_prev_opt();
						}
					}else{
						var posnone = wrapper.innerWidth()/ 3 *-1;
						if(tsum < posnone){
							// next
							_this.set_next_opt();
						}
					}
					_this.css_action(wrapper);
				}
			});
		},
		setting:function(){
			var wrapper = $(this.wrapper);
			this.translateX = 0;
			this.len = $(this.elem).children().length;
			this.select = 0;
			this.children_width = 100/this.len;
			
			wrapper.find(this.elem).css({'width': (100*this.len)+'%', 'transform':'translateX('+this.translateX+')', 'transition':'transform '+this.transSpeed+'s '+this.transEasing});
			wrapper.find(this.elem).children().css({'width': this.children_width+'%'});
			if(this.isStepBtn){
				var html = this.html_stepBtn();
				wrapper.append(html);	
			}
			this.set_event();
		},
		init:function(){
			this.setting();
		}
	}
})(jQuery);