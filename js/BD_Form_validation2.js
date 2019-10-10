var BD_FormValidation = function(frm_elem){
	this.checkInputExampleTxtArr = ['', 'Score', 'Name', 'Phone', 'E-mail', 'Message', 'School', 'TOEFL', '작성예) 김민지' ,'통화가능한 연락처', 'OO고등학교' ,'010-0000-0000' ,'email@domain.com', '최대 400자 이내로 작성해 주세요.', 'YYYY-DD-MM', '주소', '상세주소'];
	this.b_submitCheck = true;
	if($(frm_elem).length>0)
		this.submitcheck(frm_elem);
};
BD_FormValidation.prototype = {
	falseReturn:function(elem,txt){
		var str = txt || "정확한 정보를 입력해 주세요.";
		if(str != 'none'){
			alert(str);
		}
		elem.focus();
		this.b_submitCheck = false;
	},
	submitcheck:function(frm_elem){
		var _this = this;
		var frmWrap = $(frm_elem);
		frmWrap.find('input, textarea, select').each(function(){
			var valCheck 	= $.trim($(this).val());
			var frm_this     = $(this);
			if(frm_this.hasClass('checkInput')){
				if($.inArray(valCheck, _this.checkInputExampleTxtArr)>=0){
					var labelName = frm_this.data('labelName');
					var errMsg = ($.trim(labelName) !== '') ? labelName+' 항목을 입력(선택)해 주세요.' : '필수 입력항목 누락';
					_this.falseReturn(frm_this,errMsg);
					return false;
				}
			}
			if(frm_this.hasClass('check_same_id')){
				var sameCheckId = $.trim($('#mem_id').val());
				if(sameCheckId != ""){
					if(sameCheckId.indexOf(valCheck) > -1){
						_this.falseReturn(frm_this,'비밀번호와 아이디는 다르게 설정해 주세요.');
						return false;
					}
				}
			}
			if(frm_this.hasClass('notSubmit')){
				_this.falseReturn(frm_this, '정확한 정보를 입력해 주세요.');
				return false;
			}
			if(frm_this.hasClass('specialCheck')){
				if(valCheck != ""){
					if(!_this.specialValidation(valCheck)){
						_this.falseReturn($(this), '특수문자는 입력하실 수 없습니다.');
						return false;
					}
				}
			}
			if(frm_this.hasClass('userIdCheck')){
				if(!_this.userIdValidation(valCheck)){
					_this.falseReturn(frm_this, '아이디는 영문, 숫자 , 특수문자 (!@^_) 조합 8~16글자로 으로 만들어주세요.');
					return false;
				}
			}
			if(frm_this.hasClass('tableNameCheck')){
				if(!_this.checkTableName(valCheck)){
					_this.falseReturn(frm_this,'공백없이 3~20자 이내의 영문자, 숫자, _ 만 가능합니다.');
					return false;
				}
			}
			if(frm_this.hasClass('numCheck')){
				if(valCheck != ""){
					if(!_this.numValidation(valCheck)){
						_this.falseReturn(frm_this, '숫자만 입력 가능합니다.');
						return false;
					}
				}
			}	
			if(frm_this.hasClass('phoneNumCheck')){
				if(valCheck != ""){
					if(!_this.phoneNumValidation(valCheck)){
						_this.falseReturn(frm_this,'숫자와 - 만 입력 가능합니다. ex) 02-540-2510 or 025402510');
						return false;
					}
				}
			}
			if(frm_this.hasClass('hanCheck')){
				if(!_this.hanValidation(valCheck)){
					_this.falseReturn(frm_this,'한글은 입력할 수 없습니다.');
					return false;
				}
			}
			if(frm_this.hasClass('mailCheck')){
				var mail1 = frm_this.val();
				var mail2 =(frm_this.next().next().hasClass('mailCheck2')) ? frm_this.next().next('.mailCheck2').val() : frm_this.find('.mailCheck2').val();
				if(mail2 === undefined || mail2 === null) mail2 = "";
				if(mail1 !== "" && mail2 !== ""){
					var mail = mail1+'@'+mail2;
				}else{
					var mail = mail1;
				}
				if(!_this.mailValidation($.trim(mail).replace( /(\s*)/g, ""))){
					_this.falseReturn(frm_this,'잘못된 이메일 형식입니다.');
					return false;
				}
			}
			if(frm_this.hasClass('mailCheck2')){
				var mail  = '';
				var mail1 = frm_this.val();
				var mail2 = $('#'+frm_this.data('mailSelect')).val();
				var mail3 = $('#'+frm_this.data('mailWrite')).val();
				if(mail2 ==='write'){
					mail = mail1+'@'+mail3;
				}else{
					mail = mail1+'@'+mail2;
				}
				if(!_this.mailValidation($.trim(mail).replace( /(\s*)/g, ""))){
					_this.falseReturn(frm_this,'잘못된 이메일 형식입니다.');
					return false;
				}
			}
			if(frm_this.hasClass('pwdLength')){
				if(!_this.checkPassword(valCheck)){
					_this.b_submitCheck = false;
					frm_this.focus();
					return false;
				}
			}
			if(frm_this.hasClass('passconf')){
				var pwd1 = frmWrap.find('#password').val();
				var pwd2 = frm_this.val();
				if(pwd1 !== pwd2){
					_this.falseReturn(frm_this,'비밀번호가 일치하지 않습니다.');
					return false;
				}
			}
			if(frm_this.hasClass('checkDay')){
				var checkday1 = $('.checkDay').val()||'';
				var checkday2 = $('.checkDay2').val()||'';
				checkday1 = checkday1.replace(/-|\s/g, '');
				checkday2 = checkday2.replace(/-|\s/g, '');
				if(checkday1==='' || checkday2===''){
					_this.falseReturn(frm_this,'시작일또는 종료일을 입력해 주세요.');
					return false;
				}
				if(checkday1>checkday2){
					_this.falseReturn(frm_this,'시작일이 종료일보다 높습니다.');
					return false;
				}
			}
			if(frm_this.hasClass('checkFile')){
				var file = $.trim(frm_this.val());
				if(file != ""){
					if(!_this.file_Check(file)){
						_this.falseReturn(frm_this,'none');
						return false;
					}
				}
			}
			if(frm_this.hasClass('checkLength')){
				if(frm_this.val().replace(/\s/g, "").length > frm_this.data("maxlength")){
					_this.falseReturn(frm_this, '최대 400자 이내로 작성해 주세요.');
					return false;
				}
			}
			if(frm_this.hasClass('twoCheck')){
				var _ext = frm_this.data("twoType");
				var _thisId = frm_this.attr('id');
				var _data   = frm_this.data("inputName");
				var check1 = frm_this.val().replace(/(^\s*)|(\s*$)/, "");
				var check2 = $('#'+_thisId+_ext).val().replace(/(^\s*)|(\s*$)/, "");
				if((check1 == "" && check2 =="") || (check1 ==_data && check2 == _data)){
					_this.falseReturn($(this), '학부모 또는 학생의 전화번호/이메일주소를 입력하셔야 수강신청이 가능합니다.');
					return false;
				}
			}
			if(frm_this.hasClass('checkboxCheck')){
				if(!frm_this.prop('checked')){
					_this.falseReturn(frm_this,'해당 약관에 동의하셔야 진행이 가능합니다.');
					return false;
				}
			}
			if(frm_this.hasClass('checkboxRequried')){
				var checkboxRequried = frmWrap.find('input[name="'+frm_this.attr('name')+'"]');
				var checkboxLen = checkboxRequried.length;
				var checkLen = 0;
				for(var i=0; i<checkboxLen; i++){
					if(checkboxRequried[i].checked) checkLen++;
				}
				if(checkLen < 1){
					var labelName = frm_this.data('labelName');
					var errMsg = ($.trim(labelName) != '') ? labelName+' 항목 중 최소 1개 이상을 선택해 주세요.' : '필수 선택사항 중 1개이상 선택 해주세요.';
					_this.falseReturn(frm_this, errMsg);
					return false;
				}
			}
		});
	},
	// db테이블명 검사 4~20글자로 숫자와 영문자 _ 만가능
	checkTableName:function(name){
		var regTable = /^[A-Za-z_0-9]{3,20}/g;
		if(!regTable.test(name)){
			return false;
		}else{
			return true;
		}
	},
	// 비밀번호 형식 검사
	checkPassword:function(password,id){
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
	},
	// 이메일 형식 검사
	mailValidation:function(email){
		var email = email;
		var regex=/^([\w-]+(?:\.[\w-]+)*)@((?:[\w-]+\.)*\w[\w-]{0,66})\.([a-z]{2,6}(?:\.[a-z]{2})?)$/;
		if(regex.test(email) === false){
			return false;
		}else{
			return true;
		}
	},
	// 한글이 섞여 있는지 검사
	hanValidation:function(input_s) {
		//var pattern= /[ㄱ-ㅎ|ㅏ-ㅣ|가-힝]/;
		var pattern = /[\u3131-\u314e|\u314f-\u3163|\uac00-\ud7a3]/g;
		return (pattern.test(input_s)) ? true : false;
	},
	// 숫자인지 소수점포함 검사
	numValidation:function(num){
		var regPhone = /^\d+\.?\d*$/;
		if(!regPhone.test(num)){
			return false;
		}else{
			return true;
		}
	},
	// 아이디 검사
	userIdValidation:function(id){
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

	},
	//  전화번호 검사
	phoneNumValidation:function(num){
	    var chars = "-0123456789";
	    for (var inx = 0; inx < num.length; inx++) {
	       if (chars.indexOf(num.charAt(inx)) == -1)
	           return false;
	    }
	    return true;
	},
	// 특수문자 포함되어있는지 검사
	specialValidation:function(str){
		var reg = /[~!@\#$%<>^&*\()?.;:\-=+_\’]/gi;
		if (reg.test(str)){
			return false;
		}else{
			return true;
		}
	},
	//파일 확장자 필터링
	file_Check:function(file){
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
};
