<div class="main-important-program-wrap">
    <div class="section_wrapper">
        <h2 class="blind">UMVietnam 주요 프로그램</h2>
        <ul class="main-important-program">
        <?php $prlen = 1; foreach($lang_main_contents['programs'] as $pval) : ?>
            <li class="program-list program-list<?=$prlen?>">
                <a href="<?=site_url()?><?=$umv_lang?><?=stripslashes($pval['link'])?>">
                    <div class="program-title">
                        <div class="inner-box">
                            <div class="title-sec">
                                <h3 class="title">
                                    <?=stripslashes($pval['title'])?>
                                </h3>
                                <p class="title-text">
                                    <?=stripslashes($pval['sub-tit'])?>
                                </p>
                            </div>
                        </div>
                    </div>
                    <div class="program-text">
                        <strong class="text-tit"><?=stripslashes($pval['title'])?></strong>
                        <strong class="text-view font-poppins">Program <span class="font-poppins">View</span></strong>
                        <p class="text">
                            <?=stripslashes($pval['text'])?>
                        </p>
                    </div>
                    <div class="list-bg"></div>
                </a>
            </li>
        <?php $prlen++; endforeach ?>
        </ul>
    </div>
</div>
<div class="main-presentation-section">
    <section class="main-prevlist-wrap main-presentation-wrap <?=(!$presentation)?'none-presentation-wrap':''?>">
        <div class="section_wrapper <?=(!$presentation)?'none-presentation-section':''?>">
            <div class="prevlist-info-sec">
                <div class="prevlist-info">
                    <h2 class="prevlist-info-title">
                        <span class="boldcolor">DESCRIPTION</span>
                        <span class="presentation"><?=stripslashes($lang_main_contents['presentation']['title'])?></span>
                    </h2>
                    <p class="prevlist-info-text <?=($presentation)?'next-presentation-num':''?>">
                        <?=stripslashes($lang_main_contents['presentation']['text'])?>
                    </p>
                    <?php if($presentation) : ?>
                    <p class="presentation-num">
                        <?=count($presentation)?> <?=stripslashes($lang_presentation['briefing_sessions'])?>
                    </p>
                    <?php endif ?>
                    <a href="<?=site_url()?><?=$umv_lang?>/community/Info_sessions/" class="rect-link-box effect-animation-line" title="<?=stripslashes($lang_menu['reservation'])?>">
                        <div class="inner-box effect-inner-box">
                            <?=stripslashes($lang_menu['reservation'])?>
                            <div class="ico-box ico-box-r"></div>
                            <div class="ico-box ico-box-ov"></div>
                        </div>
                    </a>
                </div>
            </div>
            <div class="prevlist-content-sec">
                <div class="main-presentation-sec">
                    <div class="main-presentation <?=(!$presentation)?'none-presentation':''?>">
                    <?php if($presentation) : ?>
                        <?php for($p = 0; $p < count($presentation); $p++) :
                            $p_day = explode(" ", $presentation[$p]->p_day);
                        ?>
                        <div>
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
                                        <?=$lang_bbs['total']?> <?=$presentation[$p]->p_entry?> /
                                        <?php if($presentation[$p]->p_entry - count($presentation[$p]->user_list) > 0) : ?>
                                        <?=$lang_presentation['empty']?> <?=$presentation[$p]->p_entry - count($presentation[$p]->user_list)?>
                                        <?php else : ?>
                                        <?=$presentation[$p]->p_entry?> <?=stripslashes($lang_presentation['no_remaining_seat'])?> (<?=stripslashes($lang_presentation['self_application'])?>)
                                        <br />Office: +84.28.3724.4555 (ext. 6363) <br />Mobile: +84.34.970.5862
                                        <?php endif ?>
                                    </p>
                                </div>
                            </div>
                        </div>
                        <?php endfor ?>
                    <?php else : ?>
                        <div class="presentation-box">
                            <div class="inner-box">
                                <div class="none-title-sec">
                                    <div class="none-title-box">
                                        <h3 class="none-title">
                                            <?=$lang_message['no_scheduled_presentation']?>
                                        </h3>
                                        <p class="none-text">
                                            <?=$lang_message['more_info_call_us']?>
                                        </p>
                                    </div>
                                </div>
                                <div class="phone-num-sec">
                                    <a href="tel:+842837244555" class="phone-num-box phone-vietnam" title="Office : +84.28.3724.4555">
                                        <p class="phone-num">
                                            <strong>Office</strong>
                                            <span>+84.28.3724.4555</span>
                                        </p>
                                    </a>
                                    <a href="tel:+84349705862" class="phone-num-box phone-vietnam" title="Mobile : +84.34.970.5862">
                                        <p class="phone-num">
                                            <strong>Mobile</strong>
                                            <span>+84.34.970.5862</span>
                                        </p>
                                    </a>
                                </div>
                            </div>
                        </div>
                    <?php endif ?>
                    </div>
                </div>
                <div class="slick-controller"></div>
            </div>
        </div>
    </section>
</div>
<div class="main-bbs-section">
    <div class="section_wrapper">
    <article class="main-prevlist-wrap main-newslist-wrap">
            <header class="prevlist-info-sec">
                <div class="prevlist-info">
                    <h2 class="prevlist-info-title">
                        <?=stripslashes($lang_main_contents['news_notice']['title'])?>
                    </h2>
                    <p class="prevlist-info-text">
                        <?=stripslashes($lang_main_contents['news_notice']['text'])?>
                    </p>
                    <a href="<?=site_url()?><?=$umv_lang?>/board/list/news" class="rect-link-box multiple-rect effect-animation-line">
                        <div class="inner-box effect-inner-box">
                            <?=$lang_bbs['view_all_list']?>
                            <div class="ico-multiple-rect">
                                <div class="rect"></div>
                                <div class="rect"></div>
                                <div class="rect"></div>
                                <div class="rect"></div>
                                <div class="rect"></div>
                                <div class="rect"></div>
                            </div>
                        </div>
                    </a>
                </div>
            </header>
            <div class="prevlist-content-sec">
                <div class="main-bbs-list">
                <?php if($news_new_list) : ?>
                    <?php foreach($news_new_list as $val) : ?>
                    <div class="list">
                        <?php if(!empty($val->bbs_link)) : ?>
                        <a href="<?=$val->bbs_link?>" target="_blank" class="news-box">
                        <?php else : ?>
                        <a href="<?=site_url()?><?=$umv_lang?>/board/view/news/<?=$val->bbs_id?>" class="news-box">
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
                                    <?=fnc_utf8_strcut(fnc_set_htmls_strip($val->bbs_subject), 80)?>
                                </strong>
                                <p class="content <?=(empty($val->bbs_thumbnail))?'none-img':''?>"><?=fnc_utf8_strcut(preg_replace('/\r\n|\r|\n/is', '', strip_tags($val->bbs_content)), 110)?></p>
                                <span class="date"><?=set_view_register_time($val->bbs_register)?></span>
                            </div>
                        </a>
                    </div>
                    <?php endforeach ?>
                <?php else : ?>
                    <?php for($i=0; $i<3; $i++) : ?>
                    <div class="none-elem list">
                        <div class="link-box">
                            <div class="inner-box">
                                <div class="thumbnail">
                                </div>
                                <strong class="subject">
                                    <?=$lang_message['no_registered_posts']?>
                                </strong>
                            </div>
                        </div>
                    </div>
                    <?php endfor ?>
                <?php endif ?>
                </div>
                <div class="slick-controller"></div>
            </div>
            <footer class="blind">
                http://umvietnam.com
            </footer>
        </article>
    </div>
</div>
<div>
    <div class="main-google-map">
        <iframe src="https://www.google.com/maps/embed/v1/place?key=AIzaSyDizQPN-zEgzXEjxV5ZjbuYGC7pYGFyTic&q=University+of+Economics+and+Law+-+VNU-HCM"></iframe>
    </div>
</div>
