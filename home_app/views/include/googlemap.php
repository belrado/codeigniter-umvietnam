<!DOCTYPE html>
<html lang="ko">
<head>
<meta charset="utf-8" />
<title>UMV 오시는 길</title>
<style>
	body, html{height:100%}
	*{padding:0; margin:0}
	h1{font-size:1em; margin:0 0 6px 0}
	.gm-style-iw div{overflow:visible !important}
</style>
</head>
<body>
<div id="google_map" style="width:100%; height:100%"></div>
<!-- //
<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyCUufaVoPk_B_nzsytL2sMbPewV_pV8n1w&callback=initMap"></script>
<script src='https://maps.googleapis.com/maps/api/js?key=AIzaSyCUufaVoPk_B_nzsytL2sMbPewV_pV8n1w&amp;region=KR'></script>
// -->
<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyDizQPN-zEgzXEjxV5ZjbuYGC7pYGFyTic&callback=initMap"></script>
<script>
google.maps.event.addDomListener(window, 'load', initialize);
	function initialize(){
		var psutitle = "메디프렙 본원";
		var psutext = "서울시 강남구 테헤란로 443<br />애플트리타워 4층";
	    if(document.getElementById('google_map')) {
		    var mapOptions = { //구글 맵 옵션 설정
		        zoom : 16, //기본 확대율 16
		        center : new google.maps.LatLng(37.506469, 127.055603), // 지도 중앙 위치
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
		        position : {lat: 37.506919, lng: 127.055603}, //마커 위치
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



function initialize1(){
	var psutitle = "메디프렙";
	var customMapPosX = "37.504469"; //"37.504469";
	var customMapPosY = "127.063427"; //"127.063427";
	var psutext = "서울 강남구 테헤란로 443";
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
</script>
</body>
</html>
