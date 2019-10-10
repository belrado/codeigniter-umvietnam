
<div class="section-contents">
    <div class="section_wrapper">
        <h4 class="content-tit-underline">
            <?=stripslashes($lang_contents['section1']['title'])?>
        </h4>
        <div class="block-content">
            <?php foreach($lang_contents['section1']['text'] as $val) : ?>
            <p><?=stripslashes($val)?></p>
            <?php endforeach ?>
        </div>
        <?php if($univ_list) : ?>
        <ul class="koruniv-list block-section2">
            <?php foreach($univ_list as $uval) : ?>
            <li>
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
        <div class="minnesota-uel-uofm-program korean-vietanm-univ-program block-section2">
            <div class="uel-uofm-box uel-box">
                <div class="inner-box">
                    <strong class="title">
                        <?=stripslashes($lang_contents['section1']['enter']['vietnam']['title'])?>
                    </strong>
                    <ul class="contents">
                    <?php foreach($lang_contents['section1']['enter']['vietnam']['content'] as $u1len=>$u1val) : ?>
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
                        <?=stripslashes($lang_contents['section1']['enter']['korea']['title'])?>
                    </strong>
                    <ul class="contents">
                    <?php foreach($lang_contents['section1']['enter']['korea']['content'] as $u3len=>$u3val) : ?>
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
        <div class="title-bottom-line-box">
            <h5 class="content-tit-leftline">
                <?=stripslashes($lang_contents['section1']['benefit']['title'])?>
            </h5>
        </div>
        <ul class="minnesota-curriculum-list">
        <?php foreach($lang_contents['section1']['benefit']['list'] as $bnefit_list) : ?>
            <li class="curriculum-list">
                <h6 class="content-tit-leftwon sub-tit">
                    <?=stripslashes($bnefit_list['title'])?>
                </h6>
                <ul class="curriculum-text dot-ul-list">
                <?php foreach($bnefit_list['text'] as $list_val) : ?>
                    <li>
                        <?=stripslashes($list_val)?>
                    </li>
                <?php endforeach ?>
                </ul>
            </li>
        <?php endforeach ?>
        </ul>
    </div>
</div>
<div class="section-contents koruniv-program-section2">
    <div class="section_wrapper">
        <h4 class="koruniv-program-title">
            <?=stripslashes($lang_contents['section2']['title'])?>
        </h4>
        <ul class="koruniv-program-list why-minnesota-list ">
        <?php foreach($lang_contents['section2']['list'] as $len=>$list) : ?>
            <li class="why-minnesota-box">
                <div class="inner-box">
                    <h5 class="content-tit-underline">
                        <span class="num font-poppins"><?=preg_replace('/^\d{1}$/', '0'.($len+1), ($len+1))?></span>
                        <?=stripslashes($list['title'])?>
                    </h5>
                    <div class="program-layer">
                        <div class="program-img-box"><img src="/assets/img/korean/program_img0<?=($len+1)?>.jpg" alt=""></div>
                        <div class="program-text">
                            <?php foreach($list['text'] as $lval) : ?>
                            <p><?=stripslashes($lval)?></p>
                            <?php endforeach ?>
                        </div>
                    </div>

                </div>
            </li>
        <?php endforeach ?>
        </ul>
    </div>
</div>
<script>
$('document').ready(function(){
    $('.koruniv-list').PsuChildAllHeight({
        elem:'.koruniv-list',
        elem_clild:'.inner-box',
        elem_child_sec:'a'
    });
    $('.minnesota-uel-uofm-program').PsuChildAllHeight({
        elem:'.minnesota-uel-uofm-program',
        elem_clild:'.inner-box',
        elem_child_sec:'.uel-uofm-box'
    });
});
</script>
