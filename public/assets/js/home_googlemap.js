(function($){
	// 구글맵
    google.maps.event.addDomListener(window, 'load', initialize);
	function initialize(){
		var psutitle = "메디프렙";
		var customMapPosX = "37.504469"; //"37.504469";
		var customMapPosY = "127.063427"; //"127.063427";
		var psutext = "대치동 967-3 KM빌딩 6층";
	    if($("#google_map").length) {
		    var mapOptions = { //구글 맵 옵션 설정
		        zoom : 16, //기본 확대율 16
		        center : new google.maps.LatLng(customMapPosX, customMapPosY), // 지도 중앙 위치
		        scrollwheel : true, //마우스 휠로 확대 축소 사용 여부
		        mapTypeControl : false //맵 타입 컨트롤 사용 여부
		    };
		    var map = new google.maps.Map(document.getElementById('google_map'), mapOptions); //구글 맵을 사용할 타겟
		    var contentString = "<article class='psuuhak-map'><h1>"+psutitle+"</h1><p style='padding:0; margin:0'>"+psutext+"</p></article>";
				var infowindow = new google.maps.InfoWindow({
    			content: contentString
			});
		    var image = {
		    	url:"/assets/img/ico_map_marker.png",
		    	size: new google.maps.Size(30, 48),
		    	scaledSize: new google.maps.Size(30, 48)
		    }
		    var marker = new google.maps.Marker({ //마커 설정
		        map : map,
		        position : map.getCenter(), //마커 위치
		        title:psutitle,
		        icon : image //마커 이미지
		    });
		    infowindow.open(map, marker);
		 	marker.addListener('click', function() {
    			infowindow.open(map, marker);
  			});
		    google.maps.event.addDomListener(window, "resize", function() { //리사이즈에 따른 마커 위치
		        var center = map.getCenter();
		        google.maps.event.trigger(map, "resize");
		        map.setCenter(center); 
		    });
	    }
	}	
})(jQuery);