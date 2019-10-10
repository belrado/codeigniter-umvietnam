<div class="section-contents">
    <div class="section_wrapper">
        <div class="shortterm-brochure-sec block-section">
            <div class="brochure-layer">
                <div class="brochure-box">
                    <strong class="title"><?=stripslashes($page_1depth_name)?></strong>
                    <div class="marginB5">
                        <a href="<?=site_url()?>assets/file/down/shortterm_english_program2019_eng.pdf"
                            class="downbtn font-poppins home-pdf-view-jsdown">Program Brochure EN</a>
                    </div>
                    <div>
                        <a href="<?=site_url()?>assets/file/down/shortterm_english_program2019_kor.pdf"
                            class="downbtn font-poppins home-pdf-view-jsdown">Program Brochure KO</a>
                    </div>
                </div>
            </div>
        </div>
        <?php foreach($lang_contents['section1'] as $len=>$s1val) : ?>
        <p class="shortterm-program-text <?=count($lang_contents['section1']) == ($len+1)?'':'block-content'?>">
            <?=stripslashes($s1val)?>
        </p>
        <?php endforeach ?>
    </div>
</div>
<div class="section-contents shortterm-advantages-sec">
    <div class="section_wrapper">
        <section>
            <h4 class="content-tit-center">
                <?=stripslashes($lang_contents['section2']['title'])?>
            </h4>
            <ul class="shortterm-advantage">
            <?php foreach($lang_contents['section2']['advantages'] as $s2val) : ?>
                <li class="advantage-list">
                    <h5 class="title">
                        <span><?=stripslashes($s2val['title'])?></span>
                    </h5>
                    <div class="contents">
                        <div class="inner-box">
                            <div class="table-cell-box">
                                <ul class="dot-ul-list">
                                <?php foreach($s2val['text'] as $s2subval) : ?>
                                    <li>
                                        <?=stripslashes($s2subval)?>
                                    </li>
                                <?php endforeach ?>
                                </ul>
                            </div>
                        </div>
                    </div>
                </li>
            <?php endforeach ?>
            </ul>
            <div class="shortterm-advantage-img">
                <div class="advantage-img advantage-img1">
                    <img src='https://psuedu.cache.iwinv.net/Image/umv/shortterm/advantage_img1.jpg' alt="Vietnam Photo1" />
                </div>
                <div class="advantage-img advantage-img2">
                    <img src='https://psuedu.cache.iwinv.net/Image/umv/shortterm/advantage_img2.jpg' alt="Vietnam Photo2" />
                </div>
                <div class="advantage-img advantage-img3">
                    <img src='https://psuedu.cache.iwinv.net/Image/umv/shortterm/advantage_img3.jpg' alt="Vietnam Photo3" />
                </div>
            </div>
        </section>
    </div>
</div>
<div class="section-contents">
    <div class="section_wrapper">
        <section>
            <h4 class="content-tit-center">
                <?=stripslashes($lang_contents['section3']['title'])?>
            </h4>
            <div class="shortterm-contents-sec">
                <div class="shortterm-contents">
                <?php foreach($lang_contents['section3']['contents'] as $s3len=>$s3val) : ?>
                    <?php if($s3len%2===0) : ?>
                    <div class="contents-list-sec contents-list-sec<?=($s3len+1)?>">
                    <?php endif ?>
                        <div class="contents-list contents-list<?=($s3len+1)?>">
                            <div class="hexagon hexagon-with-border info">
                                <div class="hexagon-shape">
                                    <div class="hexagon-shape-inner">
                                        <div class="hexagon-shape-inner-2"></div>
                                    </div>
                                </div>
                                <div class="hexagon-shape content-panel">
                                    <div class="hexagon-shape-inner">
                                        <div class="hexagon-shape-inner-2"></div>
                                    </div>
                                </div>
                                <div class="hexagon-content">
                                    <h5 class="text">
                                        <?=stripslashes($s3val['title'])?>
                                    </h5>
                                </div>
                            </div>
                            <div class="contenats-info">
                            <?php if(isset($s3val['info'])) : ?>
                                <strong class="info-tit"><?=stripslashes($s3val['info']['title'])?></strong>
                                <ul class="dot-ul-list">
                                <?php foreach($s3val['info']['program'] as $ipval) : ?>
                                    <li><?=stripslashes($ipval)?></li>
                                <?php endforeach ?>
                                </ul>
                            <?php elseif(isset($s3val['list'])) : ?>
                                <ul class="info-description">
                                <?php foreach($s3val['list'] as $iplen=>$ipval) : ?>
                                    <li>
                                        <span class="num"><?=$iplen?></span>
                                        <?=stripslashes($ipval)?>
                                    </li>
                                <?php endforeach ?>
                                </ul>
                            <?php endif?>
                            </div>
                        </div>
                    <?php if(($s3len+1)%2==0) : ?>
                    </div>
                    <?php endif ?>
                <?php endforeach ?>
                </div>
            </div>
        </section>
    </div>
</div>
<script>
$('.shortterm-advantage').PsuChildAllHeight({
    elem:'.shortterm-advantage',
    elem_clild:'.dot-ul-list',
    elem_child_sec:'.contents',
    elem_multiple:true
});
</script>
