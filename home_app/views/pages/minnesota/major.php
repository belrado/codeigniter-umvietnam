<div class="section-contents">
    <div class="section_wrapper">
        <h4 class="content-tit-leftline">
            <?=stripslashes($lang_contents['title'])?>
        </h4>
        <div class="minnesota-major-text">
            <?php foreach($lang_contents['text'] as $val) : ?>
            <p class="text">
                <?=stripslashes($val)?>
            </p>
            <?php endforeach ?>
            <p class="campus">
                <?=stripslashes($lang_contents['campus_list'])?>
            </p>
        </div>
        <p class="minnesota-major-sec minnesota-major-subject">
            <span class="subject univ-box">
                <?=stripslashes($lang_contents['college'])?>
            </span>
            <span class="subject major-box">
                <?=stripslashes($lang_contents['major'])?>
            </span>
            <span class="subject campus-box">
                <?=stripslashes($lang_contents['campus'])?>
            </span>
            <span class="subject description-box">
                <?=stripslashes($lang_contents['description'])?>
            </span>
        </p>
        <?php foreach($lang_contents['major_data'] as $mdval) : ?>
        <div class="minnesota-major-univ-sec">
            <h5 class="minnesota-major-univ">
                <span><?=stripslashes($mdval['title'])?></span>
            </h5>
            <ul class="minnesota-major-sec minnesota-major-list">
                <?php foreach($mdval['data'] as $dataval) : ?>
                <li>
                    <div class="major-box">
                        <div class="inner-box">
                            <div class="subject">
                                <span><?=stripslashes($lang_contents['major'])?></span>
                            </div>
                            <div class="content">
                                <?=stripslashes($dataval['major'])?>
                            </div>
                        </div>
                    </div>
                    <div class="campus-box">
                        <div class="inner-box">
                            <div class="subject">
                                <span><?=stripslashes($lang_contents['campus'])?></span>
                            </div>
                            <div class="content">
                                <?=stripslashes($dataval['campus'])?>
                            </div>
                        </div>
                    </div>
                    <div class="description-box">
                        <div class="inner-box">
                            <div class="content">
                                <?=stripslashes($dataval['description'])?>
                            </div>
                        </div>
                    </div>
                </li>
                <?php endforeach ?>
            </ul>
        </div>
        <?php endforeach ?>
    </div>
</div>
