(function($){
	/* 
	 * PSU스타강사 검색효과 script
	 * $js_teacher_arr 엑셀파일을 php로 읽어들인 뒤 js변수에 담은 php변수
	 * aTeacher 강사정보를 담고있는 배열변수  = $js_teacher_arr
	 * aTeacher 배열의 구조
	 * {
			name:'윤필',
			name_another:'',
			image:'/img/teacher/teacher_Yoon_Pil2.jpg',
			alt:'xxxx',
			experience:[
				'University of Rochester 물리학 박사',
				'University of Rochester 물리학부 강의',
				'미국 뉴욕 주립대학교 물리학부 강의'
			],
			youtube:{use:false, link:''}
		}
	 * 
	 */
	function clear_space(str){
		return str.replace(/(\s*)/g, "");
	}
	function check_search_teachername(name, elem){
		if(clear_space(name).length < 2){
			alert('검색어를 공백 제외 2글자 이상 적어주세요');
			elem.focus();
			return false;
		}
		return true;
	}	
	getIds('teacher-search-frm').onsubmit = function(){
		return false;
	}
	// 배열값으로 강사목록생성 함수
	function set_starTeacher(){
		var setdata = new Date();
		for(var i=0; i<aTeacher.length; i++){
			var html 		= '';
			var yutubeCheck = aTeacher[i].youtube.use;
			var node 		= document.createElement("LI");
			node.className  = "item-box";
			// 검색을하기위해 data값에 강사이름과 추가적으로 검색되야할 텍스트를 넣어준다...
			node.setAttribute('data-teachername', clear_space(aTeacher[i].name)+clear_space(aTeacher[i].name_another));
			html = (yutubeCheck) ? '<div class="inner-box youtubeWrap" data-video-type="youtube" data-video-title="PSU에듀센터 스타강사 '+aTeacher[i].name+'선생님의  youtube 강좌" data-video-link="'+clear_space(aTeacher[i].youtube.link)+'">' : '<div class="inner-box">';
			html += '<div class="txt-box">';
			html += '<h5 class="tit">'+aTeacher[i].name+' 선생님</h5>';
			html += '<ul>';
			for(var j=0; j<aTeacher[i].experience.length; j++){
				html += '<li>- '+aTeacher[i].experience[j]+'</li>';
			}
			html += '</ul>';
			if(yutubeCheck) html += '<div class="youtube-go"  data-video-type="youtube" data-video-title="PSU에듀센터 스타강사 '+aTeacher[i].name+'선생님의  youtube 강좌" data-video-link="'+clear_space(aTeacher[i].youtube.link)+'"><a href="'+clear_space(aTeacher[i].youtube.link)+'" target="_blank" title="새창"><img src="/assets/img/btn_youtube.png" alt="동영상보기" /></a></div>'
			html += '</div>'; 
			html += '<div class="img-box">';
			if(aTeacher[i].best === 'best'){
				html += '<div class="best-label"><img src="/assets/img/teacher/best_teacher_label.png" alt="psu에듀센터 선정 베스트 스타강사" /></div>';
			}
			html += '<img src="/assets'+aTeacher[i].image+'?imguploadtime='+setdata.getTime()+'" alt="'+aTeacher[i].alt+'" /></div>'; 
			html += '</div>';                     
			node.innerHTML = html;                         
			// 노드생성                          
			getIds("search_teacher_list").appendChild(node);
		}	
	}
	// 검색눌렀을때 발생할 이벤트 함수
	function seach_teacher(name){
		var check_teacher = false;
		$('#search_teacher_list>li').each(function(){
			// 검색시 나타나는 띠를 제거
			$(this).find('.teacher-search-active').remove();
			// 검색한 글자와 li태그에 있는 데이타값을 비교
			if(clear_space($(this).data('teachername')).toLowerCase().indexOf(clear_space(name).toLowerCase()) > -1){
				// 값이 있다면...
				// 검색시 나타나는 띠 추가
				$(this).find('.img-box').append('<div class="teacher-search-active"></div>');
				var elem = $(this).clone(true);
				// 해당노드복사한값을 리스트 맨앞에 추가시키고 블럭효과 js플러그인도 같이 추가 
				$('#search_teacher_list').prepend(elem).masonry( 'prepended', elem );
				// 해당노드원본을 삭제하고 블럭효과 js플러그인도 같이 삭제후 재정렬 
				$('#search_teacher_list').masonry( 'remove', $(this) ).masonry($('#search_teacher_list'));
				$(this).remove();
				check_teacher = true;
			}
		});
		if(!check_teacher) alert('해당 선생님이 없습니다.');
	}	
	// 강사리스트생성 시작
	set_starTeacher();
	$(window).load(function(){
		// 블럭효과 jQuery 플러그인 적용
		$('#search_teacher_list').masonry({
			columnWidth:'.item-box',
			itemSelector:'.item-box',
			percentPosition: true,
			transitionDuration: '.5s'
		});
	});
	$(document).ready(function(){
		// 검색버튼 클릭
		$('#find_teacher').click(function(){
			var name = $('#input_teacher_name').val();
			if(check_search_teachername(name, $('#input_teacher_name'))){
				seach_teacher(name);
			}
		});
		// 인풋창 기본 텍스트 설정
		$('#input_teacher_name').on({
	    	focus:function(){
	    		if($(this).val() == '선생님 이름을 입력해 주세요'){
	    			$(this).val('');
	    		}
	    	},
	    	blur:function(){
	    		if($.trim($(this).val()) == ""){
	    			$(this).val('선생님 이름을 입력해 주세요');
	    		}
	    	}
	    });
	    // 선생님 카드 오버, 클릭, 유투브 이벤트
		if(is_mobile_jscheck){
			$('.teacher-list>li').on('click', teacher_mobile_click_event);
		}else{
			$('.teacher-list>li').on('mouseenter', teacher_pc_over_event);
			$('.teacher-list>li').on('mouseleave', teacher_pc_out_event);
		}
		function teacher_pc_over_event(){
			$(this).find('.txt-box').stop().animate({'left':'0'},650,'easeInOutExpo');
		}
		function teacher_pc_out_event(){
			$(this).find('.txt-box').stop().animate({'left':'110%'},650,'easeInOutExpo');
		}
		function teacher_mobile_click_event(){
			if($(this).hasClass('open-txt')){
				$(this).removeClass('open-txt');
				$(this).find('.txt-box').css({'left':'110%'});//.stop(true,true).animate({'left':'100%'},250,'easeInExpo');
			}else{
				$(this).addClass('open-txt');
				$(this).find('.txt-box').css({'left':'0'});//.stop(true,true).animate({'left':'0'},250,'easeInExpo');
			}
		}
		// HomeVideoPlayer -> BD_common.js 파일에
		$('#search_teacher_list').HomeVideoPlayer({
			video_elem:'.youtubeWrap',
			is_mobile:is_mobile,
			mobile_custom:true
		});
	});
})(jQuery);