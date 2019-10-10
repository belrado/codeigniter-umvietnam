<div class="section-contents">
    <div class="section_wrapper">
        <section>
            <h4 class="content-tit-leftline">
                <?=stripslashes($lang_contents['section1']['title'])?>
            </h4>
            <table class="umv-table admissions-table block-section2">
            <colgroup>
                <col style="width:20%" />
                <col style="width:75%" />
            </colgroup>
            <?php foreach($lang_contents['section1']['data'] as $s1val) : ?>
                <tr>
                    <th scope="row">
                        <?=stripslashes($s1val['title'])?>
                    </th>
                    <td>
                    <?php foreach($s1val['content'] as $s1va2) : ?>
                        <p>
                            <?=stripslashes($s1va2)?>
                        </p>
                    <?php endforeach ?>
                    </td>
                </tr>
            <?php endforeach ?>
            </table>
        </section>
        <section>
            <h4 class="content-tit-leftline">
                <?=stripslashes($lang_contents['section2']['title'])?>
            </h4>
            <p class="minnesota-admissions-sec minnesota-admissions-subject">
                <span class="subject category-box">
                    <?=stripslashes($lang_contents['section2']['category'])?>
                </span>
                <span class="subject schedule-box">
                    <?=stripslashes($lang_contents['section2']['schedule'])?>
                </span>
                <span class="subject location-box">
                    <?=stripslashes($lang_contents['section2']['location'])?>
                </span>
                <span class="subject note-box">
                    <?=stripslashes($lang_contents['section2']['note'])?>
                </span>
            </p>
            <ul class="minnesota-admissions-container">
                <?php foreach($lang_contents['section2']['data'] as $s2val) : ?>
                <li>
                    <div class="minnesota-admissions-sec">
                        <h5 class="admissions-title">
                            <span class="inner-box">
                                <?=stripslashes($s2val['title'])?>
                            </span>
                        </h5>
                        <ul class="admissions-schedule">
                            <li class="schedule-box">
                                <div class="inner-box">
                                    <div class="subject">
                                        <span><?=stripslashes($lang_contents['section2']['schedule'])?></span>
                                    </div>
                                    <div class="contents">
                                        <?=stripslashes($s2val['schedule'])?>
                                    </div>
                                </div>
                            </li>
                            <li class="location-box">
                                <div class="inner-box">
                                    <div class="subject">
                                        <span><?=stripslashes($lang_contents['section2']['location'])?></span>
                                    </div>
                                    <div class="contents">
                                    <?php foreach($s2val['location'] as $lval) : ?>
                                        <?=isset($lval['notice'])?'<p class="notice">'.stripslashes($lval['notice']).'</p>':''?>
                                        <?php if(isset($lval['title'])) : ?>
                                        <strong class="title"><?=stripslashes($lval['title'])?></strong>
                                        <?php endif ?>
                                        <?php if(isset($lval['text'])) : ?>
                                            <?php foreach($lval['text'] as $tval) : ?>
                                            <p class="text"><?=stripslashes($tval)?></p>
                                            <?php endforeach ?>
                                        <?php endif ?>
                                        <?php if(isset($lval['list'])) : ?>
                                            <ul class="list">
                                            <?php foreach($lval['list'] as $listval) : ?>
                                                <li><?=stripslashes($listval)?></li>
                                            <?php endforeach ?>
                                            </ul>
                                        <?php endif ?>
                                    <?php endforeach ?>
                                    </div>
                                </div>
                            </li>
                            <li class="note-box">
                                <div class="inner-box">
                                    <div class="subject">
                                        <span><?=stripslashes($lang_contents['section2']['note'])?></span>
                                    </div>
                                    <div class="contents">
                                        <ul class="list">
                                        <?php foreach($s2val['note'] as $nval) : ?>
                                            <li><?=stripslashes($nval)?></li>
                                        <?php endforeach ?>
                                        </ul>
                                    </div>
                                </div>
                            </li>
                        </ul>
                    </div>
                </li>
                <?php endforeach ?>
            </ul>
        </section>
    </div>
</div>
