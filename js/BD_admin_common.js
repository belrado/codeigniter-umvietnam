(function($){
	"use strict"; 
	/* add event */
	var appendWrap = $('.append-clone-sec');
	
	$('#append-clone-btn').on("click", function(){
		var clone = appendWrap.children(':first').clone('true');
		appendWrap.append(clone);
		var clonelast = appendWrap.children(':last');
		clonelast.find('input[type="text"]').val("");
		clonelast.append("<input type='button' value='del' class='clone-delete-btn' />");
	});
	appendWrap.on("click", ".clone-delete-btn", function(){
		$(this).parent().remove();
	});
})(jQuery);
/*
window.onbeforeunload = function() {
// return '표시할 메시지를 반환';
}
*/