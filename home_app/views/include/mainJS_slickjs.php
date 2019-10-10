<div class="mainJs-slickjs-wrap">
    <div class="mainJs-slickjs">
        <?php $mjslen = 0; foreach($lang_mainjs as $mjs_val) : ?>
        <div class="jselem jselem<?=$mjslen?>">
            <div class="inner-box">
                <div class="slide-content-layer">
                    <h3 class="blind"><?=$mjs_val['title']?> 소개</h3>
                    <div class="slide-slogan">
                        <p class="slogan">
                            <img src='https://psuedu.cache.iwinv.net/Image/umv/university_of_mennesota.png' alt="UNIVERSITY OF MINNESOTA" />
                        </p>
                        <p class="slogan-text font-poppins">
                            Liberal Arts &amp; ESL Course in Vietnam
                        </p>
                        <div class="slogan-line-sec">
                            <div class="slogan-line"></div>
                        </div>
                    </div>
                    <div class="text-box-layer">
                        <div class="text-box">
                            <div class="text text1">
                                <?=$mjs_val['sub_title']?>
                            </div>
                            <div class="text text2">
                                <?=$mjs_val['title']?>
                            </div>
                            <div class="text text3">
                                <?=$mjs_val['text']?>
                            </div>
                        </div>
                        <div class="slide-nav">
                            <span class="slide-num slide-idx"><?=($mjslen+1)?></span>
                            <span class="slide-num slide-total"><?=count($lang_mainjs)?></span>
                        </div>
                        <a href="<?=site_url()?><?=$umv_lang?>/<?=$mjs_val['link']?>" class="read-more" tabindex="-1"><?=$lang_menu['read_more2']?></a>
                    </div>
                </div>
            </div>
            <div class="inner-bg"></div>
        </div>
        <?php $mjslen++; endforeach?>
    </div>
    <div class="main-mainJs-scroll-sec">
        <div class="mouse-scroll"><img src="/assets/img/ico_mouse_scroll.png" alt="" /></div>
	</div>
</div>
