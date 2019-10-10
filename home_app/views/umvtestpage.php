<!-- //
1350px
1904 596 1308
// -->
<style>
.main_page .section-full{padding:75px 0}

.rect-link-box{position:relative; display:inline-block; width:214px; padding:17px 30px 17px 10px; border:1px solid #ccc; background:#fff; font-size:1.125em; font-family:nskr_m; text-align:right; text-decoration:none !important}
.rect-link-box.multiple-rect{}
.rect-link-box .ico-multiple-rect{position:absolute; left:38px; top:50%; width:18px; -ms-transform:translateY(-50%); -webkit-transform:translateY(-50%); -o-transform:translateY(-50%); transform:translateY(-50%)}
.rect-link-box .ico-multiple-rect .rect{float:left; width:5px; height:6px; background:#000; margin:0 1px 1px 0; transition:background-color .4s}
.rect-link-box .rect:nth-child(1){transition-delay:.6s}
.rect-link-box .rect:nth-child(2){transition-delay:.5s}
.rect-link-box .rect:nth-child(3){transition-delay:.4s}
.rect-link-box .rect:nth-child(4){transition-delay:.3s}
.rect-link-box .rect:nth-child(5){transition-delay:.2s}
.rect-link-box .rect:nth-child(6){transition-delay:.1s}
.rect-link-box:hover .rect{background:orange}
.rect-link-box:hover .rect:nth-child(1){transition-delay:.1s}
.rect-link-box:hover .rect:nth-child(2){transition-delay:.2s}
.rect-link-box:hover .rect:nth-child(3){transition-delay:.3s}
.rect-link-box:hover .rect:nth-child(4){transition-delay:.4s}
.rect-link-box:hover .rect:nth-child(5){transition-delay:.5s}
.rect-link-box:hover .rect:nth-child(6){transition-delay:.6s}

.main-prevlist-wrap{overflow:hidden}
.main-prevlist-wrap .prevlist-info-sec{float:left; width:31.3025%; overflow:hidden}
.main-prevlist-wrap .prevlist-info{width:90%; max-width:318px; float:right}
.main-prevlist-wrap .prevlist-info-title{margin:0 0 20px 0; padding:40px 0 0 0; font-size:2.625em; font-family:nskr_dr; letter-spacing:-1px}
.main-prevlist-wrap .prevlist-info-title .boldcolor{color:#7a0019; font-family:nskr_m}
.main-prevlist-wrap .prevlist-info-title .presentation{display:block; padding:20px 0 0 0; font-size:0.571em; font-family:nskr_m}
.main-prevlist-wrap .prevlist-info-text{margin:0 0 100px 0; word-break:keep-all}
.main-prevlist-wrap .prevlist-content-sec{position:relative; float:right; width:68.6974%; overflow:hidden}
.main-prevlist-wrap .main-bbs-list{position:relative; max-width:1128px; height:394px; margin:0 0 0 72px; z-index:2;  /* overflow:hidden */}
.main-prevlist-wrap .main-bbs-list .list{position:relative; float:left; width:33.333%; margin:0 0 0 -1px; overflow:hidden; z-index:2 /* border:1px solid #ccc; border-top:none; border-bottom:none; box-sizing:border-box; margin:0 0 0 -1px*/}
.main-prevlist-wrap .main-bbs-list .list a{position:relative; display:block; height:100%; height:392px; z-index:2; border:1px solid #ccc; text-decoration:none}
.main-prevlist-wrap .main-bbs-list .list .inner-box{padding:40px}
.main-prevlist-wrap .main-bbs-list .ico-new{width:32px; height:32px; position:absolute; left:35px; top:35px; background:#7b011a; color:#fff; text-align:center; font-size:0.750em; overflow:hidden; -ms-border-radius:50%; -webkit-border-radius:50%; -o-border-radius:50%; border-radius:50%}
.main-prevlist-wrap .main-bbs-list .ico-new .ico-cha{position:absolute; top:50%; left:0; width:100%; transform:translateY(-50%); text-align:center}
.main-prevlist-wrap .main-bbs-list .cate{position:absolute; right:30px; top:40px; width:50px; padding:5px 10px; border:1px solid #7a0019; background:#fff; text-align:center; font-size:12px; color:#7a0019}
.main-prevlist-wrap .main-bbs-list .subject{display:block; margin:0 0 12px 0; font-size:1.25em; line-height:1.3em; font-family:nskr_dr; overflow:hidden; text-overflow:ellipsis; white-space:nowrap; word-break:keep-all;}
.main-prevlist-wrap .main-bbs-list .subject.none-img{margin:0 0 45px 0; padding:75px 0 0 0; font-size:1.375em; white-space:normal}
.main-prevlist-wrap .main-bbs-list .thumbnail{height:190px; margin:0 0 20px 0; overflow:hidden; text-align:center}
.main-prevlist-wrap .main-bbs-list .thumbnail img{display:inline; vertical-align:top; width:auto; height:100%}
.main-prevlist-wrap .main-bbs-list .content{height:44px; margin:0 0 8px 0; overflow:hidden; color:#6f6f6f; display:-webkit-box; -webkit-line-clamp:2; -webkit-box-orient:vertical; box-orient:vertical; white-space:normal; word-wrap: break-word; text-overflow:ellipsis;}
.main-prevlist-wrap .main-bbs-list .content.none-img{height:66px; -webkit-line-clamp:3}
.main-prevlist-wrap .main-bbs-list .date{font-size:0.86em; color:#6f6f6f}
.main-prevlist-wrap .main-bbs-list .list a:after{position:absolute; left:0; top:-1px; width:100%; height:1px; background:#7a0019; opacity:0; -ms-transform:translateX(100%); -webkit-transform:translateX(100%); -o-transform:translateX(100%); transform:translateX(100%); -ms-transition:-ms-transform .6s, opacity .5s; -webkit-transition:-webkit-transform .6s, opacity .5s; -o-transition:-o-transform .6s, opacity .5s; transition:transform .6s, opacity .5s; content:''}
.main-prevlist-wrap .main-bbs-list .list a:before{position:absolute; left:0; bottom:-1px; width:100%; height:1px; background:#7a0019; opacity:0; -ms-transform:translateX(-100%); -webkit-transform:translateX(-100%); -o-transform:translateX(-100%); transform:translateX(-100%); -ms-transition:-ms-transform .6s, opacity .5s; -webkit-transition:-webkit-transform .6s, opacity .5s; -o-transition:-o-transform .6s, opacity .5s; transition:transform .6s, opacity .5s; content:''}
.main-prevlist-wrap .main-bbs-list .list .inner-box:after{position:absolute; left:-1px; top:0; width:1px; height:100%; background:#7a0019; opacity:0; -ms-transform:translateY(-100%); -webkit-transform:translateY(-100%); -o-transform:translateY(-100%); transform:translateY(-100%); -ms-transition:-ms-transform .6s, opacity .5s; -webkit-transition:-webkit-transform .6s, opacity .5s; -o-transition:-o-transform .6s, opacity .5s; transition:transform .6s, opacity .5s; content:''}
.main-prevlist-wrap .main-bbs-list .list .inner-box:before{position:absolute; right:-1px; top:0; width:1px; height:100%; background:#7a0019; opacity:0; -ms-transform:translateY(100%); -webkit-transform:translateY(100%); -o-transform:translateY(100%); transform:translateY(100%); -ms-transition:-ms-transform .6s, opacity .5s; -webkit-transition:-webkit-transform .6s, opacity .5s; -o-transition:-o-transform .6s, opacity .5s; transition:transform .6s, opacity .5s; content:''}
.main-prevlist-wrap .main-bbs-list .list:focus,
.main-prevlist-wrap .main-bbs-list .list:hover{z-index:10}
.main-prevlist-wrap .main-bbs-list .list a:focus:after,
.main-prevlist-wrap .main-bbs-list .list:hover a:after,
.main-prevlist-wrap .main-bbs-list .list a:focus:before,
.main-prevlist-wrap .main-bbs-list .list:hover a:before{opacity:1; -ms-transform:translateX(0); -webkit-transform:translateX(0); -o-transform:translateX(0); transform:translateX(0)}
.main-prevlist-wrap .main-bbs-list .list a:focus .inner-box:after,
.main-prevlist-wrap .main-bbs-list .list:hover .inner-box:after,
.main-prevlist-wrap .main-bbs-list .list a:focus .inner-box:before,
.main-prevlist-wrap .main-bbs-list .list:hover .inner-box:before{opacity:1; -ms-transform:translateY(0); -webkit-transform:translateY(0); -o-transform:translateY(0); transform:translateY(0)}
.main-prevlist-wrap .bbs-controller{position:absolute; left:0; top:0; width:72px; height:100%; background:#7a0019; z-index:1}
.main-prevlist-wrap .slick-prev{position:absolute; left:-50px; top:0}
.main-prevlist-wrap .slick-next{position:absolute; left:-50px; top:50px}

.main-presentation-wrap{background:#e9e9e9}
.main-presentation-wrap .prevlist-info-text{margin:0 0 25px 0; word-break:keep-all}
.main-presentation-wrap .main-presentation-sec{position:relative; margin:0 0 0 72px; background:url(/assets/img/main_presentation_bg.jpg) no-repeat 608px 0; z-index:2}
.main-presentation-wrap .main-presentation{position:relative; width:608px; height:408px; background:#fff}
.main-presentation-wrap .presentation-box{height:408px}
.main-presentation-wrap .presentation-box .inner-box{position:relative; top:50%; left:0; padding:50px; transform:translateY(-50%)}
.main-presentation-wrap .presentation-box .presentation-name{margin:0 0 20px 0; font-size:1.750em; word-break:keep-all}
.main-presentation-wrap .presentation-box .presentation-date,
.main-presentation-wrap .presentation-box .presentation-place{font-size:1.125em; color:#6f6f6f}
.main-presentation-wrap .presentation-box .presentation-place{margin:0 0 20px 0}
.main-presentation-wrap .presentation-box .presentation-empty{font-size:0.86em; color:#6f6f6f}
.main-presentation-wrap .bbs-controller{background:#ffb23e}
</style>
<div class="section-full main-presentation-section">
    <section class="main-prevlist-wrap main-presentation-wrap">
        <div class="prevlist-info-sec">
            <div class="prevlist-info">
                <h2 class="prevlist-info-title">
                    <span class="boldcolor">DESCRIPTION</span>
                    <span class="presentation"><?=stripslashes($lang_main_contents['section4']['presentation']['title'])?></span>
                </h2>
                <p class="prevlist-info-text">
                    <?=stripslashes($lang_main_contents['section4']['presentation']['text'])?>
                </p>
                <a href="<?=site_url()?><?=$umv_lang?>/um/Info_sessions/" class="rect-link-box multiple-rect">
                    <?=stripslashes($lang_menu['reservation'])?>
                </a>
            </div>
        </div>
        <div class="prevlist-content-sec">
            <div class="main-presentation-sec">
                <div class="main-presentation">
                <?php if($presentation) : ?>
                    <?php for($p = 0; $p < count($presentation); $p++) :
                        $p_day = explode(" ", $presentation[$p]->p_day);
                    ?>
                    <div class="presentation-box">
                        <div class="inner-box">
                            <h3 class="presentation-name"><?=fnc_set_htmls_strip($presentation[$p]->p_name)?></h3>
                            <p class="presentation-date">
                                [<?=fnc_set_htmls_strip($presentation[$p]->p_location)?>]
                                <?=fnc_replace_getday($p_day[0])?>(<?=fnc_get_dayname($p_day[0])?>)
                                <?=fnc_replace_gettime($p_day[1])?>
                            </p>
                            <p class="presentation-place">
                                <?=fnc_set_htmls_strip($presentation[$p]->p_address)?><br />
                                <?=fnc_set_htmls_strip($presentation[$p]->p_place)?>
                            </p>
                            <p class="presentation-empty">
                                총 30팀 / 남은자리 30팀
                            </p>
                        </div>
                    </div>
                    <?php endfor ?>
                <?php else : ?>
                    <div class="presentation-box">
                        <div class="inner-box">
                            <h3 class="presentation-name">
                                <?=$lang_message['no_scheduled_presentation']?>
                            </h3>
                            <p class="presentation-date">
                                <?=$lang_message['more_info_call_us']?>
                            </p>
                        </div>
                    </div>
                <?php endif ?>
                </div>
            </div>
            <div class="bbs-controller"></div>
        </div>
    </section>
</div>
<div class="section-full main-bbs-section">
    <article class="main-prevlist-wrap">
        <header class="prevlist-info-sec">
            <div class="prevlist-info">
                <h1 class="prevlist-info-title">
                    <span class="boldcolor">UMV</span> News
                </h1>
                <p class="prevlist-info-text">
                    최근 소식과 언론보도 뉴스를 <br />전해드립니다.
                </p>
                <a href="<?=site_url()?><?=$umv_lang?>/board/list/news" class="rect-link-box multiple-rect">
                    <?=$lang_bbs['view_all_list']?>
                    <div class="ico-multiple-rect">
                        <div class="rect"></div>
                        <div class="rect"></div>
                        <div class="rect"></div>
                        <div class="rect"></div>
                        <div class="rect"></div>
                        <div class="rect"></div>
                    </div>
                </a>
            </div>
        </header>
        <div class="prevlist-content-sec">
        <?php if($news_new_list) : ?>
            <div class="main-bbs-list">
                <?php foreach($news_new_list as $val) : ?>
                <div class="list">
                    <?php if(!empty($val->bbs_link)) : ?>
                    <a href="<?=$val->bbs_link?>" target="_blank">
                    <?php else : ?>
                    <a href="<?=site_url()?><?=$umv_lang?>/board/view/news/<?=$val->bbs_id?>">
                    <?php endif ?>
                        <div class="inner-box">
                            <?php if(strtotime($val->bbs_register.'+'.'7'.' days') > strtotime(date('Y-m-d h:i:s', time()))) : ?>
								<div class="ico-new">
                                    <span class="ico-cha">N</span>
                                    <span class="blind"> - <?=$lang_bbs['new_bbs']?></span>
                                </div>
							<?php endif ?>
                            <?php if(!empty($val->bbs_thumbnail)) : ?>
                                <div class="thumbnail">
                                    <img src="<?=$val->bbs_thumbnail?>" alt="" />
                                </div>
                            <?php endif ?>
                            <span class="cate"><?=fnc_set_htmls_strip($val->bbs_cate)?></span>
                            <strong class="subject <?=(empty($val->bbs_thumbnail))?'none-img':''?>">
                                <?=fnc_utf8_strcut(fnc_set_htmls_strip($val->bbs_subject), 100)?>
                            </strong>
                            <p class="content <?=(empty($val->bbs_thumbnail))?'none-img':''?>"><?=fnc_utf8_strcut(preg_replace('/\r\n|\r|\n/is', '', strip_tags($val->bbs_content)), 110)?></p>
                            <span class="date"><?=set_view_register_time($val->bbs_register)?></span>
                        </div>
                    </a>
                </div>
                <?php endforeach ?>
            </div>
            <div class="bbs-controller"></div>
        <?php else : ?>
            <div>
                <?=$lang_message['no_registered_posts']?>
            </div>
        <?php endif ?>
        </div>
        <footer class="blind">
            http://umvietnam.com
        </footer>
    </article>
</div>
<div>
    <div class="main-google-map">
        <iframe frameborder="0" src="https://www.google.com/maps/embed/v1/place?key=AIzaSyDizQPN-zEgzXEjxV5ZjbuYGC7pYGFyTic&q=University+of+Economics+and+Law+-+VNU-HCM"></iframe>
        <div class="script-err-map"><img src="/assets/img/image_map.gif" alt="" /></div>
    </div>
</div>
<script>
$(document).ready(function(){
    $('.main-presentation').slick({
        vertical:true,
        verticalSwiping:true,
        infinite: false,
        prevArrow:'<button type="button" class="slick-prev">prev</button>',
        nextArrow:'<button type="button" class="slick-next">next</button>'
    });
    $('.main-bbs-list').slick({
      dots: false,
      infinite: true,
      speed: 500,
      slidesToShow: 3,
      cssEase: 'linear',
      prevArrow:'<button type="button" class="slick-prev">prev</button>',
      nextArrow:'<button type="button" class="slick-next">next</button>',
      responsive:[
          {
              breakpoint: 1024,
              settings: {
                  fade:false,
                  slidesToShow: 2,
                  infinite: true
              }
          },
          {
              breakpoint: 600,
              settings: {
                  slidesToShow: 2,
                  infinite: true
              }
          }
      ]
    });
});
</script>
