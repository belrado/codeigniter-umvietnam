<div class="section-contents umv-intro-contents">
    <div class="section_wrapper">
        <section>
            <h4 class="content-tit-underline font-poppins section1-title">
                <?=stripslashes($lang_contents['section1']['title'])?>
            </h4>
            <?php foreach($lang_contents['section1']['text'] as $s1_val) : ?>
            <p class="about-text block-content">
                <?=stripslashes($s1_val)?>
            </p>
            <?php endforeach ?>
            <div class="minnesota-map-sec block-section">
                <div class="minnesota-map">
                    <img src="/assets/img/umv/minnesota_map.png" alt="<?=stripslashes($lang_contents['section1']['imgtext'])?>" />
                </div>
                <ul class="campus-map-list">
                <?php $cam_len=1; foreach($lang_contents['section1']['campus'] as $cam_val) : ?>
                    <li class="map-list map-list<?=$cam_len?>">
                        <div class="inner-box">
                            <strong class="campus-name font-poppins">
                                <?=stripslashes($cam_val['title_en'])?>
                            </strong>
                            <p class="campus-text">
                                <?=stripslashes($cam_val['properties'])?>
                            </p>
                        </div>
                    </li>
                <?php endforeach?>
                </ul>
                <div class="map-bg">
                    <aside><img src="/assets/img/umv/umv_minnesota_map_img.png" alt="" /></aside>
                </div>
            </div>
            <ul class="campus-sec">
            <?php $cam_len=1; foreach($lang_contents['section1']['campus'] as $cam_val) : ?>
                <li class="campus-list campus-list<?=$cam_len?> <?=(count($lang_contents['section1']['campus'])==$cam_len)?'campus-list-last':''?>">
                    <section>
                        <div class="campus-title">
                            <h5 class="name">
                                <?=stripslashes($cam_val['title'])?>
                            </h5>
                            <span class="sub-name">
                                <?=stripslashes($cam_val['sub_title'])?>
                            </span>
                        </div>
                        <p class="campus-title-text block-content2">
                            <?=stripslashes($cam_val['text'])?>
                        </p>
                        <div class="campus-box">
                            <div class="campus-img-box">
                                <img src="/assets/img/umv/campus_img0<?=$cam_len?>.jpg" alt="<?=stripslashes($cam_val['title'])?> Photo" />
                            </div>
                            <div class="campus-info-box">
                                <div class="inner-box">
                                    <section>
                                        <h6 class="info-tit">
                                            <?=stripslashes($cam_val['info_title'])?>
                                        </h6>
                                        <table class="umv-table top-border">
                                            <colgroup>
                                                <col style="width:20%" />
                                                <col style="width:80%" />
                                            </colgroup>
                                        <?php foreach($cam_val['info'] as $info_val) : ?>
                                            <tr class="left-txt">
                                                <th scope="row">
                                                    <?=stripslashes($info_val['title'])?>
                                                </th>
                                                <td>
                                                    <?=stripslashes($info_val['text'])?>
                                                </td>
                                            </tr>
                                        <?php endforeach ?>
                                        </table>
                                        <?php foreach($cam_val['ranking'] as $rank_val) : ?>
                                        <div class="ranking-box">
                                            <strong class="rank-tit">
                                                <?=stripslashes($rank_val['title'])?>
                                            </strong>
                                            <ul class="rank-list">
                                            <?php foreach($rank_val['list'] as $list_val) : ?>
                                                <li>
                                                    <?=stripslashes($list_val)?>
                                                </li>
                                            <?php endforeach ?>
                                            </ul>
                                        </div>
                                        <?php endforeach ?>
                                    </section>
                                </div>
                            </div>
                        </div>
                    </section>
                </li>
            <?php $cam_len++; endforeach ?>
            </ul>
        </section>
    </div>
</div>
<div class="section-contents section-bgf3 umv-intro-contents">
    <div class="section_wrapper">
        <section>
            <h4 class="content-tit-underline center">
                <?=stripslashes($lang_contents['section2']['title'])?>
            </h4>
            <p class="ranking-text">
                <?=stripslashes($lang_contents['section2']['text'])?>
            </p>
            <div class="ranking-list-wrap">
                <div class="ranking-list-sec ranking-list-sec1">
                    <div class="ranking-list-box">
                        <div class="inner-box">
                            <section>
                                <h5 class="ranking-list-title">
                                    <span class="name">ARWU # 37</span>
                                    <span class="year">in 2018</span>
                                </h5>
                                <div>
                                    <p class="ranking-list-subject">
                                        <span class="rank">World<br>Ranking</span>
                                        <span class="institution">Institution</span>
                                        <span class="blind">으로 구성된 리스트</span>
                                    </p>
                                    <ul class="ranking-list">
                                    <?php for($i=0; $i<count($rank1['list']); $i++) : ?>
                                        <li class="<?=($rank1['point']==$i)?'point':''?>">
                                            <div class="rank" title="World Ranking">
                                                <span><?=($i+1)?></span>
                                            </div>
                                            <p class="institution" title="Institution">
                                                <?=stripslashes($rank1['list'][$i])?>
                                            </p>
                                        </li>
                                    <?php endfor ?>
                                    </ul>
                                    <div class="empty-box">
                                        <p class="blind">9위~36위 생략</p>
                                        <div class="skip"></div>
                                    </div>
                                    <ul class="ranking-list rank2">
                                    <?php for($i=0; $i<count($rank2['list']); $i++) : ?>
                                        <li class="<?=($rank2['point']==$i)?'point':''?>">
                                            <div class="rank" title="World Ranking">
                                                <span><?=($i+37)?></span>
                                            </div>
                                            <p class="institution" title="Institution">
                                                <?=stripslashes($rank2['list'][$i])?>
                                            </p>
                                        </li>
                                    <?php endfor ?>
                                    </ul>
                                </div>
                            </section>
                        </div>
                    </div>
                    <a href="http://shanghairanking.com/" target="_blank" class="ranking-link">
                        <span class="blind"><?=stripslashes($lang_bbs['source'])?></span>
                        <span class="uri">shanghairanking.com</span>
                        <span class="link-ico"></span>
                    </a>
                </div>
                <div class="ranking-list-sec ranking-list-sec2">
                    <div class="ranking-list-box">
                        <div class="inner-box">
                            <section>
                                <h5 class="ranking-list-title">
                                    <span class="name">US News & World Report #35 Business School</span>
                                    <span class="year">in 2018</span>
                                </h5>
                                <div>
                                    <p class="ranking-list-subject">
                                        <span class="rank">Ranking</span>
                                        <span class="institution">Institution</span>
                                        <span class="blind">으로 구성된 리스트</span>
                                    </p>
                                    <ul class="ranking-list">
                                    <?php for($i=0; $i<count($rank3['list']); $i++) : ?>
                                        <li class="<?=($rank3['point']==$i)?'point':''?>">
                                            <div class="rank" title="World Ranking">
                                                <span><?=($i+1)?></span>
                                            </div>
                                            <p class="institution" title="Institution">
                                                <?=stripslashes($rank3['list'][$i])?>
                                            </p>
                                        </li>
                                    <?php endfor ?>
                                    </ul>
                                    <div class="empty-box">
                                        <p class="blind">6위~34위 생략</p>
                                        <div class="skip"></div>
                                    </div>
                                    <ul class="ranking-list">
                                    <?php for($i=0; $i<count($rank4['list']); $i++) : ?>
                                        <li class="<?=($rank4['point']==$i)?'point':''?>">
                                            <div class="rank" title="World Ranking">
                                                <span><?=($i+35)?></span>
                                            </div>
                                            <p class="institution" title="Institution">
                                                <?=stripslashes($rank4['list'][$i])?>
                                            </p>
                                        </li>
                                    <?php endfor ?>
                                    </ul>
                                </div>
                            </section>
                        </div>
                    </div>
                    <a href="https://www.usnews.com/" target="_blank" class="ranking-link">
                        <span class="blind"><?=stripslashes($lang_bbs['source'])?></span>
                        <span class="uri">usnews.com</span>
                        <span class="link-ico"></span>
                    </a>
                </div>
                <div class="ranking-list-sec ranking-list-sec3">
                    <div class="ranking-list-box">
                        <div class="inner-box">
                        <section>
                            <h5 class="ranking-list-title">
                                <span class="name">US News & World Report #2 Pharmacy</span>
                                <span class="year">in 2018</span>
                            </h5>
                            <div>
                                <p class="ranking-list-subject">
                                    <span class="rank">Ranking</span>
                                    <span class="institution">Institution</span>
                                    <span class="blind">으로 구성된 리스트</span>
                                </p>
                                <ul class="ranking-list">
                                <?php for($i=0; $i<count($rank5['list']); $i++) : ?>
                                    <li class="<?=($rank5['point']==$i)?'point':''?>">
                                        <div class="rank" title="World Ranking">
                                            <span><?=($i+1)?></span>
                                        </div>
                                        <p class="institution" title="Institution">
                                            <?=stripslashes($rank5['list'][$i])?>
                                        </p>
                                    </li>
                                <?php endfor ?>
                                </ul>
                            </div>
                        </section>
                        <div class="empty-box"></div>
                        <section>
                            <h5 class="ranking-list-title">
                                <span class="name">US News & World Report #4 Chemical Engineering</span>
                                <span class="year">in 2018</span>
                            </h5>
                            <div>
                                <p class="ranking-list-subject">
                                    <span class="rank">Ranking</span>
                                    <span class="institution">Institution</span>
                                    <span class="blind">으로 구성된 리스트</span>
                                </p>
                                <ul class="ranking-list">
                                <?php for($i=0; $i<count($rank6['list']); $i++) : ?>
                                    <li class="<?=($rank6['point']==$i)?'point':''?>">
                                        <div class="rank" title="World Ranking">
                                            <span><?=($i+1)?></span>
                                        </div>
                                        <p class="institution" title="Institution">
                                            <?=stripslashes($rank6['list'][$i])?>
                                        </p>
                                    </li>
                                <?php endfor ?>
                                </ul>
                            </div>
                        </section>
                    </div>
                    </div>
                    <a href="https://www.usnews.com/" target="_blank" class="ranking-link">
                        <span class="blind"><?=stripslashes($lang_bbs['source'])?></span>
                        <span class="uri">usnews.com</span>
                        <span class="link-ico"></span>
                    </a>
                </div>
            </div>
        </section>
    </div>
</div>
<div class="section-contents umv-intro-contents">
    <div class="section_wrapper">
        <div class="umv-about-vietnam">
            <h4 class="title">Nobel prize laureate</h4>
            <div class="slogan">
                <p>
                    <strong class="s-minnesota">
                        <?=stripslashes($lang_contents['section3']['title'])?>
                    </strong>
                    <span class="s-vietnam font-poppins">Nobel priz laureate</span>
                </p>
                <div class="nobel-img">
                    <img src="/assets/img/umv/nobel_img.jpg" alt="<?=stripslashes($lang_contents['section3']['nobel_img'])?>" />
                </div>
                <p class="nobel-text">
                    <?=stripslashes($lang_contents['section3']['text'])?>
                </p>
            </div>
        </div>
        <div class="umv-about-greetings">
            <table class="umv-table">
                <thead>
                    <tr>
                        <th scope="col">No</th>
                        <th scope="col">Laureate</th>
                        <th scope="col">Discipline</th>
                        <th scope="col">Year of Award</th>
                    </tr>
                </thead>
                <tbody>
                <?php $nlen=1; foreach($nobel as $nval) : ?>
                    <tr>
                        <td class="th-row"><?=$nlen?></td>
                        <td><?=stripslashes($nval['laureate'])?></td>
                        <td><?=stripslashes($nval['discipline'])?></td>
                        <td><?=stripslashes($nval['year'])?></td>
                    </tr>
                <?php $nlen++; endforeach ?>
                </tbody>
            </table>
        </div>
    </div>
</div>
<script>
$('.campus-map-list').PsuChildAllHeight({
    elem:'.campus-map-list',
    elem_clild:'.inner-box',
    elem_child_sec:'>li'
});
$('.ranking-list-wrap').PsuChildAllHeight({
    elem:'.ranking-list-wrap',
    elem_clild:'.inner-box',
    elem_child_sec:'.ranking-list-box'
});
</script>
