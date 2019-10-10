<div class="section-contents">
    <div class="section_wrapper">
        <div class="umv-about-vietnam">
            <strong class="title font-poppins">Greetings</strong>
            <p class="slogan">
                <span class="s-minnesota font-poppins">University of Minnesota,</span>
                <span class="s-vietnam font-poppins">Liberal Arts &amp; ESL Course <br />
                in Vietnam</span>
            </p>
            <dl class="vietnam-box">
                <dt>
                    <?=stripslashes($lang_contents['greetings']['title'])?>
                </dt>
                <?php foreach($lang_contents['greetings']['contents'] as $gval) : ?>
                <dd class="ico-line-list">
                    <?=stripslashes($gval)?>
                </dd>
                <?php endforeach ?>
            </dl>
        </div>
        <div class="umv-about-greetings">
            <strong class="title"><?=stripslashes($lang_contents['title'])?></strong>
            <?php foreach($lang_contents['text'] as $val) : ?>
            <p class="block-content">
                <?=stripslashes($val)?>
            </p>
            <?php endforeach ?>
            <p class="umv-ceo">
                <strong><?=stripslashes($lang_contents['ceo'])?></strong>
            </p>
            <ul class="umv-agreement-img">
                <li class="img01">
                    <img src="/assets/img/umv/umv_about_img01.jpg" alt="" />
                </li>
                <li class="img02">
                    <img src="/assets/img/umv/umv_about_img02.jpg" alt="" />
                </li>
            </ul>
        </div>
    </div>
</div>
