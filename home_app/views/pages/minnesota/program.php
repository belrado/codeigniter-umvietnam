<div class="section-contents">
    <div class="section_wrapper">
        <div class="imgbg-textbottom-box minnesota-program-top-textbox block-section2">
            <div class="text-layer">
                <div class="title-box">
                    <span class="title-sub">PROGRAM</span>
                    <strong class="title">
                        <?=stripslashes($page_1depth_name)?>
                    </strong>
                    <div class="brochure-box">
                        <a href="<?=site_url()?>assets/file/down/minnesota_program_en_190614"
                            class="downbtn font-poppins home-pdf-view-jsdown">Program <br />Brochure EN</a>
                        <a href="<?=site_url()?>assets/file/down/minnesota_program_vn_190614"
                                class="downbtn font-poppins home-pdf-view-jsdown">Program <br />Brochure VN</a>
                    </div>
                </div>
                <div class="text-box">
                    <p class="text">
                        <?=stripslashes($lang_contents['section1']['program_text'])?>
                    </p>
                </div>
            </div>
        </div>
        <div class="minnesota-uel-uofm-program block-section2">
            <div class="uel-uofm-box uel-box">
                <div class="inner-box">
                    <strong class="title">
                        <?=stripslashes($lang_contents['section1']['enter']['uel1year']['title'])?>
                    </strong>
                    <ul class="contents">
                    <?php foreach($lang_contents['section1']['enter']['uel1year']['content'] as $u1len=>$u1val) : ?>
                        <li>
                            <span class="num font-poppins">0<?=($u1len+1)?></span>
                            <div class="box">
                                <?=stripslashes($u1val)?>
                            </div>
                        </li>
                    <?php endforeach ?>
                    </ul>
                </div>
            </div>
            <div class="uel-uofm-box next-box">
                <div class="inner-box">
                    <div class="next-text">
                        <?=stripslashes($lang_contents['section1']['enter']['step'])?>
                    </div>
                </div>
            </div>
            <div class="uel-uofm-box uofm-box">
                <div class="inner-box">
                    <strong class="title">
                        <?=stripslashes($lang_contents['section1']['enter']['uofm3year']['title'])?>
                    </strong>
                    <ul class="contents">
                    <?php foreach($lang_contents['section1']['enter']['uofm3year']['content'] as $u3len=>$u3val) : ?>
                        <li>
                            <span class="num font-poppins">0<?=($u3len+1)?></span>
                            <p class="box">
                                <?=stripslashes($u3val)?>
                            </p>
                        </li>
                    <?php endforeach ?>
                    </ul>
                </div>
            </div>
        </div>
        <section class="block-section2">
            <h4 class="content-tit-leftline">
                <?=stripslashes($lang_contents['section1']['schedule']['title'])?>
            </h4>
            <div class="minnesota-program-schedule-sec">
                <div class="minnesota-program-schedule">
                    <?php $sch_len = 1; foreach($lang_contents['section1']['schedule']['data'] as $pval) : ?>
                    <div class="schedule-box schedule-box<?=$sch_len?>">
                        <?php if(!empty($pval['month'])) : ?>
                        <strong class="month">
                            <?=stripslashes($pval['month'])?>
                        </strong>
                        <?php endif ?>
                        <div class="subject-box">
                            <?php foreach($pval['subject'] as $slen=>$sval) : ?>
                            <div class="subject-layout subject-layout<?=($slen+1)?>">
                                <span class="subject"><?=stripslashes($sval)?></span>
                                <div class="line"></div>
                            </div>
                            <?php endforeach ?>
                        </div>
                        <div class="contents-box">
                            <div style="display:table; width:100%; height:100%">
                                <div class="inner-box">
                                    <ul>
                                        <?php foreach($pval['contents'] as $clen=>$cval) : ?>
                                        <li>
                                            <?php if(count($pval['contents']) > 1) : ?>
                                            <span class="num font-poppins"><?=($clen+1)?>.</span>
                                            <p class="text">
                                                <?=stripslashes($cval)?>
                                            </p>
                                            <?php else : ?>
                                            <p>
                                                <?=stripslashes($cval)?>
                                            </p>
                                            <?php endif ?>
                                        </li>
                                        <?php endforeach ?>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                    <?php $sch_len++; endforeach ?>
                </div>
            </div>
        </section>
        <ul class="minnesota-program-info">
        <?php foreach($lang_contents['section1']['advantage'] as $alen=>$aval) : ?>
            <li class="info-list info-list<?=($alen+1)?>">
                <div class="inner-box">
                    <div class="contents-layout">
                        <div class="contents">
                            <span class="num font-poppins">
                                0<?=($alen+1)?>
                            </span>
                            <strong class="title">
                                <?=stripslashes($aval['title'])?>
                            </strong>
                            <p class="text">
                                <?=stripslashes($aval['text'])?>
                            </p>
                        </div>
                    </div>
                    <div class="bg-box"></div>
                </div>
            </li>
        <?php endforeach ?>
        </ul>
    </div>
</div>
<div class="section-contents why-minnesota-sec">
    <div class="section_wrapper">
        <h4 class="content-tit-underline center minnesota-section-title">
            <?=stripslashes($lang_contents['section2']['title'])?>
        </h4>
        <p class="why-minnesota-text block-section">
            <?=stripslashes($lang_contents['section2']['text'])?>
        </p>
        <ul class="why-minnesota-list">
            <li class="why-list why-list1">
                <div class="why-minnesota-box block-content2">
                    <div class="contents">
                        <div class="inner-box">
                            <h5 class="content-tit-underline">
                                <span class="num font-poppins">01</span>
                                <?=stripslashes($lang_contents['section2']['program_point'][0]['title'])?>
                            </h5>
                            <?php foreach($lang_contents['section2']['program_point'][0]['text'] as $tval) : ?>
                            <p class="marginB20">
                                <?=stripslashes($tval)?>
                            </p>
                            <?php endforeach ?>
                        </div>
                    </div>
                    <div class="attachment"></div>
                </div>
                <strong class="umv-point block-section"><?=stripslashes($lang_contents['section2']['program_point'][0]['point'])?></strong>
                <ol class="umv-point-list">
                <?php foreach($lang_contents['section2']['program_point'][0]['point_list'] as $pllen=>$plval) : ?>
                    <li class="point-list point-list<?=($pllen+1)?>">
                        <div class="point-box">
                            <div class="text"><?=stripslashes($plval)?></div>
                            <div class="ico"></div>
                        </div>
                    </li>
                <?php endforeach ?>
                </ol>
            </li>
            <li class="why-list why-list2">
                <div class="why-minnesota-box full-why-minnesota-box">
                    <div class="contents">
                        <div class="inner-box">
                            <h5 class="content-tit-underline">
                                <span class="num font-poppins">02</span>
                                <?=stripslashes($lang_contents['section2']['program_point'][1]['title'])?>
                            </h5>
                            <?php foreach($lang_contents['section2']['program_point'][1]['text'] as $tval) : ?>
                            <p class="marginB20">
                                <?=stripslashes($tval)?>
                            </p>
                            <?php endforeach ?>
                        </div>
                    </div>
                    <div class="attachment">
                        <div class="inner-box">
                            <div class="table-layout">
                                <?=stripslashes($lang_contents['section2']['program_point'][1]['table'])?>
                            </div>
                        </div>
                    </div>
                </div>
            </li>
            <li class="why-list why-list3">
                <div class="why-minnesota-box">
                    <div class="contents">
                        <div class="inner-box">
                            <h5 class="content-tit-underline">
                                <span class="num font-poppins">03</span>
                                <?=stripslashes($lang_contents['section2']['program_point'][2]['title'])?>
                            </h5>
                            <?php foreach($lang_contents['section2']['program_point'][2]['text'] as $tval) : ?>
                            <p class="marginB20">
                                <?=stripslashes($tval)?>
                            </p>
                            <?php endforeach ?>
                        </div>
                    </div>
                    <div class="attachment">
                        <div class="table-img ir-img-box">
                            <img src="/assets/img/minnesota/table2.jpg" alt="<?=stripslashes($lang_contents['section2']['program_point'][2]['table_title'])?>" style="max-width:595px"  />
                            <div class="text-box">
                                <?=stripslashes($lang_contents['section2']['program_point'][2]['table'])?>
                            </div>
                        </div>
                    </div>
                </div>
            </li>
            <li class="why-list why-list4">
                <h5 class="content-tit-underline">
                    <span class="num font-poppins">04</span>
                    <?=stripslashes($lang_contents['section2']['program_point'][3]['title'])?>
                </h5>
                <?php foreach($lang_contents['section2']['program_point'][3]['text'] as $tval) : ?>
                <p class="block-content2">
                    <?=stripslashes($tval)?>
                </p>
                <?php endforeach ?>
                <div class="half-img-layout marginB20">
                    <div class="img-layer left-img">
                        <div style="border:1px solid #ddd">
                            <img src="/assets/img/minnesota/job_img1.jpg" alt="">
                        </div>
                    </div>
                    <div class="img-layer right-img">
                        <div style="border:1px solid #ddd">
                            <img src="/assets/img/minnesota/job_img2.jpg" alt="">
                        </div>
                    </div>
                </div>
                <ul class="minnesota-company-list">
                <?php foreach($lang_contents['section2']['program_point'][3]['company'] as $camlen=>$camval) : ?>
                    <li class="company-list<?=($camlen+1)?>">
                        <strong class="company-logo">
                            <img src="/assets/img/minnesota/company_img<?=($camlen+1)?>.jpg" alt="<?=$camval['title']?>" />
                        </strong>
                        <ul class="company-member">
                        <?php foreach($camval['data'] as $member) : ?>
                            <li>
                                <p>
                                    <?=stripslashes($member)?>
                                </p>
                            </li>
                        <?php endforeach ?>
                        </ul>
                    </li>
                <?php endforeach ?>
                </ul>
            </li>
        </ul>
    </div>
</div>
<script>
$('document').ready(function(){
    $('.minnesota-uel-uofm-program').PsuChildAllHeight({
        elem:'.minnesota-uel-uofm-program',
        elem_clild:'.inner-box',
        elem_child_sec:'.uel-uofm-box'
    });
    $('.minnesota-program-info').PsuChildAllHeight({
        elem:'.minnesota-program-info',
        elem_clild:'.inner-box',
        elem_child_sec:'>li'
    });
    $('.minnesota-program-schedule').PsuChildAllHeight({
        elem:'.minnesota-program-schedule',
        elem_clild:'.inner-box',
        elem_child_sec:'.contents-box'
    });
});
</script>
