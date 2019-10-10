(function($){
	// 폼체크
	var checkInputExampleTxtArr = ['', 'Score', 'Name', 'Phone', 'E-mail', 'Message', 'School', 'TOEFL', '작성예) 김민지' ,'통화가능한 연락처', 'OO고등학교' ,'010-0000-0000' ,'email@domain.com', '최대 400자 이내로 작성해 주세요.', 'YYYY-DD-MM', '주소', '상세주소'];
	$(document).ready(function(){
		$('.BD-check-form').on("submit", psuFrmCheck);
		// 잊풋창 글자
		$('.BD-check-form').find('input[type=text], textarea').on({
	    	focus:function(){
	    		//this._thisname = $.inArray($(this).val(), checkInputExampleTxtArr);
	    		if($.inArray($(this).val(), checkInputExampleTxtArr)>=0){
	    			$(this).val('');
	    		}
	    	},
	    	blur:function(){
	    		if($.trim($(this).val()) == ""){
	    			$(this).val($(this).data('inputName'));
	    		}
	    	}
	    });
	});
	function psuFrmCheck(){
		var submitCheck = true;
		var frmWrap = $(this);
		var falseReturn = function(elem,txt){
			var str = txt || "정확한 정보를 입력해 주세요.";
			if(str != 'none'){
				alert(str);
			}
			elem.focus();
			submitCheck = false;
		}
		//return false;
		$(this).find('input, textarea, select').each(function(){
			var _this = $(this);
			//if(!_this.hasClass('checkNone')){
				var valCheck = $.trim(_this.val());
				if(_this.hasClass('checkInput')){
					if($.inArray(valCheck, checkInputExampleTxtArr)>=0){
						var labelName = $(this).data('labelName');
						var errMsg = ($.trim(labelName) !== '') ? labelName+' 항목을 입력(선택)해 주세요.' : '필수 입력항목 누락';
						falseReturn($(this),errMsg);
						return false;
					}
				}
				if(_this.hasClass('check_same_id')){
					var sameCheckId = $.trim($('#mem_id').val());
					if(sameCheckId != ""){
						if(sameCheckId.indexOf(valCheck) > -1){
							falseReturn($(this),'비밀번호와 아이디는 다르게 설정해 주세요.');
							return false;
						}
					}
				}
				if(_this.hasClass('notSubmit')){
					falseReturn($(this),'정확한 정보를 입력해 주세요.');
					return false;
				}
				if(_this.hasClass('specialCheck')){
					if(valCheck != ""){
						if(!specialValidation(valCheck)){
							falseReturn($(this),'특수문자는 입력하실 수 없습니다.');
							return false;
						}
					}
				}
				if(_this.hasClass('userIdCheck')){
					if(!userIdValidation(valCheck)){
						falseReturn($(this),'아이디는 영문, 숫자 , 특수문자 (!@^_) 조합 8~16글자로 으로 만들어주세요.');
						return false;
					}
				}
				if(_this.hasClass('tableNameCheck')){
					if(!checkTableName(valCheck)){
						falseReturn($(this),'공백없이 3~20자 이내의 영문자, 숫자, _ 만 가능합니다.');
						return false;
					}
				}
				if(_this.hasClass('numCheck')){
					if(valCheck != ""){
						if(!numValidation(valCheck)){
							falseReturn($(this),'숫자만 입력 가능합니다.');
							return false;
						}
					}
				}
				if(_this.hasClass('phoneNumCheck')){
					if(valCheck != ""){
						if(!phoneNumValidation(valCheck)){
							falseReturn($(this),'숫자와 - 만 입력 가능합니다. ex) 02-540-2510 or 025402510');
							return false;
						}
					}
				}
				if(_this.hasClass('hanCheck')){
					if(hanValidation(valCheck)){
						falseReturn($(this),'한글은 입력할 수 없습니다.');
						return false;
					}
				}
				if(_this.hasClass('mailCheck')){
					var mail1 = _this.val();
					var mail2 =(_this.next().next().hasClass('mailCheck2')) ? _this.next().next('.mailCheck2').val() : _this.find('.mailCheck2').val();
					if(mail2 === undefined || mail2 === null) mail2 = "";
					if(mail1 !== "" && mail2 !== ""){
						var mail = mail1+'@'+mail2;
					}else{
						var mail = mail1;
					}
					if(!mailValidation($.trim(mail).replace( /(\s*)/g, ""))){
						falseReturn($(this),'잘못된 이메일 형식입니다.');
						return false;
					}
				}
				if(_this.hasClass('mailCheck2')){
					var mail  = '';
					var mail1 = _this.val();
					var mail2 = $('#'+_this.data('mailSelect')).val();
					var mail3 = $('#'+_this.data('mailWrite')).val();
					if(mail2 ==='write'){
						mail = mail1+'@'+mail3;
					}else{
						mail = mail1+'@'+mail2;
					}
					if(!mailValidation($.trim(mail).replace( /(\s*)/g, ""))){
						falseReturn($(this),'잘못된 이메일 형식입니다.');
						return false;
					}
				}
				if(_this.hasClass('pwdLength')){
					if(!checkPassword(valCheck)){
						submitCheck = false;
						$(this).focus();
						return false;
					}
				}
				if(_this.hasClass('passconf')){
					var pwd1 = frmWrap.find('#password').val();
					var pwd2 = _this.val();
					if(pwd1 !== pwd2){
						falseReturn($(this),'비밀번호가 일치하지 않습니다.');
						return false;
					}
				}
				if(_this.hasClass('checkDay')){
					var checkday1 = $('.checkDay').val()||'';
					var checkday2 = $('.checkDay2').val()||'';
					checkday1 = checkday1.replace(/-|\s/g, '');
					checkday2 = checkday2.replace(/-|\s/g, '');
					if(checkday1==='' || checkday2===''){
						falseReturn($(this),'시작일또는 종료일을 입력해 주세요.');
						return false;
					}
					if(checkday1>checkday2){
						falseReturn($(this),'시작일이 종료일보다 높습니다.');
						return false;
					}
				}
				if(_this.hasClass('checkFile')){
					var file = $.trim(_this.val());
					if(file != ""){
						if(!file_Check(file)){
							falseReturn($(this),'none');
							return false;
						}
					}
				}
				if(_this.hasClass('checkLength')){
					if(_this.val().replace(/\s/g, "").length > _this.data("maxlength")){
						falseReturn($(this), '최대 400자 이내로 작성해 주세요.');
						return false;
					}
				}
				if(_this.hasClass('twoCheck')){
					var _ext = $(this).data("twoType");
					var _thisId = $(this).attr('id');
					var _data   = $(this).data("inputName");
					var check1 = $(this).val().replace(/(^\s*)|(\s*$)/, "");
					var check2 = $('#'+_thisId+_ext).val().replace(/(^\s*)|(\s*$)/, "");
					if((check1 == "" && check2 =="") || (check1 ==_data && check2 == _data)){
						falseReturn($(this), '학부모 또는 학생의 전화번호/이메일주소를 입력하셔야 수강신청이 가능합니다.');
						return false;
					}
				}
				if(_this.hasClass('checkboxCheck')){
					if(!_this.prop('checked')){
						falseReturn($(this),'해당 약관에 동의하셔야 진행이 가능합니다.');
						return false;
					}
				}
				if(_this.hasClass('checkboxRequried')){
					var checkboxRequried = frmWrap.find('input[name="'+_this.attr('name')+'"]');
					var checkboxLen = checkboxRequried.length;
					var checkLen = 0;
					for(var i=0; i<checkboxLen; i++){
						if(checkboxRequried[i].checked) checkLen++;
					}
					if(checkLen < 1){
						var labelName = $(this).data('labelName');
						var errMsg = ($.trim(labelName) != '') ? labelName+' 항목 중 최소 1개 이상을 선택해 주세요.' : '필수 선택사항 중 1개이상 선택 해주세요.';
						falseReturn($(this), errMsg);
						return false;
					}
				}
			//}
		});
		if(!submitCheck){
			return false;
		}
	}
	// db테이블명 검사 4~20글자로 숫자와 영문자 _ 만가능
	function checkTableName(name){
		var regTable = /^[A-Za-z_0-9]{3,20}/g;
		if(!regTable.test(name)){
			return false;
		}else{
			return true;
		}
	}
	// 비밀번호 형식 검사
	function checkPassword(password,id){
		if(!/^.*(?=^.{8,18}$)(?=.*\d)(?=.*[a-zA-Z])(?=.*[!@#$%^&+=_]).*$/.test(password)){
			alert('숫자와 영문자 특수기호 조합으로 8~18자리를 사용해야 합니다.');
			return false;
		}
		if(/(\w)\1\1\1/.test(password)){
			alert('같은 문자를 연달아 4번 이상 사용하실 수 없습니다.');
			return false;
		}
		if(id){
			if(password.search(id) > -1){
				alert("비밀번호에 아이디가 포함되었습니다.");
				return false;
			}
		}
		return true;
	}
	// 이메일 형식 검사
	function mailValidation(email){
		var email = email;
		var regex=/^([\w-]+(?:\.[\w-]+)*)@((?:[\w-]+\.)*\w[\w-]{0,66})\.([a-z]{2,6}(?:\.[a-z]{2})?)$/;
		if(regex.test(email) === false){
			return false;
		}else{
			return true;
		}
	}
	// 한글이 섞여 있는지 검사
	function hanValidation(input_s) {
		//var pattern= /[ㄱ-ㅎ|ㅏ-ㅣ|가-힝]/;
		var pattern = /[\u3131-\u314e|\u314f-\u3163|\uac00-\ud7a3]/g;
		return (pattern.test(input_s)) ? true : false;
	}
	// 숫자인지 소수점포함 검사
	function numValidation(num){
		var regPhone = /^\d+\.?\d*$/;
		if(!regPhone.test(num)){
			return false;
		}else{
			return true;
		}
	}
	// 아이디 검사
	function userIdValidation(id){
		var regId = /^(?=.*[a-zA-Z])(?=.*[!@^_])(?=.*[0-9]).{8,16}$/;
		//var regId = /^(?=.*[a-zA-Z])(?=.*[0-9]).{8,18}$/;
		//var regId = /^[A-za-z0-9]{6,18}/g;
		if(id.length >= 8 && id.length <= 16){
			if(!regId.test(id)){
				return false;
			}else{
				return true;
			}
		}else{
			return false;
		}

	}
	//  전화번호 검사
	function phoneNumValidation(num){
	    var chars = "-0123456789";
	    for (var inx = 0; inx < num.length; inx++) {
	       if (chars.indexOf(num.charAt(inx)) == -1)
	           return false;
	    }
	    return true;
	}
	// 특수문자 포함되어있는지 검사
	function specialValidation(str){
		var reg = /[~!@\#$%<>^&*\()?.;:\-=+_\’]/gi;
		if (reg.test(str)){
			return false;
		}else{
			return true;
		}
	}
	//파일 확장자 필터링
	function file_Check(file){
		var addArray = new Array(".jpg",".jpeg",".gif",".png",".pjpeg",".pdf",".doc",".docx",".ppt",".pptx",".xls",".xlsx",".zip");
		banFile = false;
		while (file.indexOf("\\") != -1)
		file = file.slice(file.indexOf("\\") + 1);
		ban = file.substring(file.lastIndexOf('.'),file.length).toLowerCase();
		for(var i = 0; i < addArray.length; i++){
			if (addArray[i] == ban){
				banFile = true;
				break;
			}
		}
		if (!banFile){
			alert(ban + " 파일은 첨부할 수 없는 파일입니다.\n(jpg, gif, png, pdf, doc, xls, ppt, zip) 파일만 업로드 가능합니다.");
			return false;
		}else{
			return true;
		}
	}

})(jQuery);
