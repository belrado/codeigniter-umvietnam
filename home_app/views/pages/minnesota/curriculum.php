<div class="section-contents">
    <div class="section_wrapper">
        <section>
            <div class="title-bottom-line-box">
                <h4 class="content-tit-leftline">
                    <?=stripslashes($lang_contents['section1']['title'])?>
                </h4>
            </div>
            <p class="contents-text block-content2">
                <?=stripslashes($lang_contents['section1']['text'])?>
            </p>
            <div class="half-img-layout block-content2">
                <div class="img-layer left-img">
                    <img src="/assets/img/minnesota/curriculum_img1.jpg" alt="" />
                </div>
                <div class="img-layer right-img">
                    <img src="/assets/img/minnesota/curriculum_img2.jpg" alt="" />
                </div>
            </div>
            <ul class="minnesota-curriculum-list block-section2">
            <?php foreach($lang_contents['section1']['content'] as $val) : ?>
                <li class="curriculum-list">
                    <h5 class="content-tit-leftwon sub-tit">
                        <?=stripslashes($val['title'])?>
                    </h5>
                    <p class="curriculum-text">
                        <?=stripslashes($val['text'])?>
                    </p>
                </li>
            <?php endforeach ?>
            </ul>
        </section>
        <section>
            <div class="title-bottom-line-box">
                <h4 class="content-tit-leftline">
                    <?=stripslashes($lang_contents['section2']['title'])?>
                </h4>
            </div>
            <p class="contents-text block-content2">
                <?=stripslashes($lang_contents['section2']['text'])?>
            </p>
            <div class="half-img-layout block-content2">
                <div class="img-layer left-img">
                    <img src="/assets/img/minnesota/curriculum_img3.jpg" alt="" />
                </div>
                <div class="img-layer right-img">
                    <img src="/assets/img/minnesota/curriculum_img4.jpg" alt="" />
                </div>
            </div>
            <ul class="minnesota-curriculum-list">
            <?php foreach($lang_contents['section2']['content'] as $val) : ?>
                <li class="curriculum-list">
                    <h5 class="content-tit-leftwon sub-tit">
                        <?=stripslashes($val['title'])?>
                    </h5>
                    <p class="curriculum-text">
                        <?=stripslashes($val['text'])?>
                    </p>
                </li>
            <?php endforeach ?>
            </ul>
        </section>
    </div>
</div>
