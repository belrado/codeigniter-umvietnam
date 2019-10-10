<div class="section-contents section-line">
    <div class="section_wrapper">
    <?php if($univ) : ?>
        <article class="univ-sec univ-default-css">
            <header class="block-section2">
                <div class="content-tit-center">
                    <h1><?=fnc_set_htmls_strip($univ->{'u_program_name_'.$umv_lang2})?></h1>
                    <strong class="sub-text">- <?=fnc_set_htmls_strip($univ->{'u_name_'.$umv_lang2})?> -</strong>
                </div>
                <div class="univ-info-sec">
                    <div class="univ-photo">
                        <img src="/assets/img/univ/<?=$univ->u_photo?>" alt="" />
                    </div>
                    <div class="info-layout">
                        <div class="univ-map">
                            <div id="google_map" style="width:100%; height:100%"></div>
                        </div>
                        <div class="univ-info">
                            <div class="logo-box">
                                <img src="/assets/img/univ/<?=$univ->u_logo?>" alt="" />
                            </div>
                            <div class="info-box">
                                <p class="marginB5">
                                    <strong>Address: </strong><?=fnc_set_htmls_strip($univ->u_address)?>
                                </p>
                                <p>
                                    <strong>Homepage: </strong><a href="<?=fnc_set_htmls_strip($univ->u_homepage, true)?>?>" target="_blank"><?=fnc_set_htmls_strip($univ->u_homepage)?></a>
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </header>
            <div class="univ-contents">
                <?=(stripslashes(str_replace('\r\n', PHP_EOL, $univ->{'u_contents_'.$umv_lang2})))?>
            </div>
            <footer>

            </footer>
        </article>
    <?php else : ?>
        <?=stripslashes($lang_message['no_post_msg'])?>
    <?php endif ?>
    </div>
</div>
<div class="section-contents">
    <div class="section_wrapper">
        <?php if($univ_list) : ?>
        <ul class="koruniv-list">
            <?php foreach($univ_list as $uval) : ?>
            <li class="<?=($univ && $uval->u_id ===  $univ->u_id)?'active':''?>">
                <a href="<?=site_url()?><?=$umv_lang?>/korean/univ/<?=$uval->u_id?>">
                    <div class="inner-box">
                        <div class="univ-photo">
                            <img src="/assets/img/univ/<?=$uval->u_photo?>" alt="" />
                            <div class="univ-logo"><img src="/assets/img/univ/<?=$uval->u_logo?>" alt="" /></div>
                        </div>
                        <strong class="univ-name"><?=stripslashes($uval->{'u_name_'.$umv_lang2})?></strong>
                        <p class="program-name"><?=stripslashes($uval->{'u_program_name_'.$umv_lang2})?></p>
                    </div>
                </a>
            </li>
            <?php endforeach ?>
        </ul>
        <?php endif ?>
    </div>
</div>
<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyDizQPN-zEgzXEjxV5ZjbuYGC7pYGFyTic&amp;region=KR"></script>
<script>
google.maps.event.addDomListener(window, 'load', initialize);
function initialize(){
	var psutitle = "<?=stripslashes($univ->{'u_name_'.$umv_lang2})?>";
	var psutext = "<?=stripslashes($univ->{'u_program_name_'.$umv_lang2})?>";
    if(document.getElementById('google_map')) {
	    var mapOptions = { //구글 맵 옵션 설정
	        zoom : 16, //기본 확대율 16
	        center : new google.maps.LatLng(<?=stripslashes($univ->u_lat)?>, <?=stripslashes($univ->u_lng)?>), // 지도 중앙 위치
	        scrollwheel : true, //마우스 휠로 확대 축소 사용 여부
	        mapTypeControl : false //맵 타입 컨트롤 사용 여부
	    };
	    var map = new google.maps.Map(document.getElementById('google_map'), mapOptions); //구글 맵을 사용할 타겟
	    var contentString = "<article class='psuuhak-map'><h1>"+psutitle+"</h1><p style='padding:0; margin:0'>"+psutext+"</p></article>";
			var infowindow = new google.maps.InfoWindow({
			content: contentString
		});
	    var image = {
	    	url:"/assets/img/map_ico.png",
	    	size: new google.maps.Size(30, 48),
	    	scaledSize: new google.maps.Size(30, 48)
	    }
	    var marker = new google.maps.Marker({ //마커 설정
	        map : map,
	        position : {lat: <?=stripslashes($univ->u_lat)?>, lng: <?=stripslashes($univ->u_lng)?>}, //마커 위치
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
$('document').ready(function(){
    $('.koruniv-list').PsuChildAllHeight({
        elem:'.koruniv-list',
        elem_clild:'.inner-box',
        elem_child_sec:'a'
    });
});
</script>
