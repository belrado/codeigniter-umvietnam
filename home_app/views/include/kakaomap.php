<div>
    <?=$umv_lang?>
    <div id="map" style="width:100%; height:400px;"></div>
</div>
<script type="text/javascript" src="//dapi.kakao.com/v2/maps/sdk.js?appkey=8b11d00aa017dad28158ffbcfc592491"></script>
<script>
var container = document.getElementById('map'); //지도를 담을 영역의 DOM 레퍼런스
var options = { //지도를 생성할 때 필요한 기본 옵션
	center: new daum.maps.LatLng(37.506469, 127.055603), //지도의 중심좌표.
	level: 3 //지도의 레벨(확대, 축소 정도)
};
var map = new daum.maps.Map(container, options); //지도 생성 및 객체 리턴
</script>
