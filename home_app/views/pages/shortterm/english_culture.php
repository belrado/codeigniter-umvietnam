<div class="section-contents">
    <div class="section_wrapper">
        <section>
            <h4 class="content-tit-leftline">
                <?=stripslashes($lang_contents['section1']['title'])?>
            </h4>
            <div class="imgbg-textbottom-box marginB20">
                <div class="text-layer">
                    <strong class="title-box">
                        <span class="title-sub">Short-Term Program</span>
                        <span class="title">
                            <?=explode('__', stripslashes($page_2depth_name))[0]?>
                        </span>
                    </strong>
                    <div class="text-box">
                        <p class="text">
                            <?=stripslashes($lang_contents['section1']['text'])?>
                        </p>
                    </div>
                </div>
            </div>
            <ul class="shortterm-about-layer block-section2">
            <?php $s1len=1; foreach($lang_contents['section1']['content'] as $s1val) : ?>
                <li class="about about<?=$s1len?>">
                    <div class="inner-box">
                        <h5 class="title">
                            <span class="num font-poppins">0<?=$s1len?></span>
                            <?=stripslashes($s1val['title'])?>
                        </h5>
                        <ul class="ico-dot-ul about-list">
                        <?php foreach($s1val['content'] as $s1subval) : ?>
                            <li>
                                <?=stripslashes($s1subval)?>
                            </li>
                        <?php endforeach ?>
                        </ul>
                    </div>
                </li>
            <?php $s1len++; endforeach ?>
            </ul>
        </section>
        <section>
            <div class="title-bottom-line-box">
                <h4 class="content-tit-leftline">
                    <?=stripslashes($lang_contents['section2']['title'])?>
                </h4>
            </div>
            <p class="shortterm-courses-text block-content">
                <?=stripslashes($lang_contents['section2']['text'])?>
            </p>
            <ul class="shortterm-program-list">
            <?php $s2len=1; foreach($lang_contents['section2']['courses'] as $s2val) : ?>
                <li>
                    <h5 class="title">
                        <span class="num font-poppins">0<?=$s2len?></span>
                        <?=stripslashes($s2val['title'])?>
                    </h5>
                    <p class="text-box">
                        <?=stripslashes($s2val['text'])?>
                    </p>
                </li>
            <?php $s2len++; endforeach ?>
            </ul>
            <ul class="shortterm-culture-list">
            <?php $s2len=1; foreach($lang_contents['section2']['culture'] as $s2val) : ?>
                <li class="culture-list culture-list<?=$s2len?>">
                    <div class="inner-box">
                        <h5 class="title">
                            <?=stripslashes($s2val['title'])?>
                        </h5>
                        <ul class="dot-ul-list center contents">
                        <?php foreach($s2val['list'] as $s2subval) : ?>
                            <li>
                                <p class="inner-box">
                                    <?=stripslashes($s2subval)?>
                                </p>
                            </li>
                        <?php endforeach ?>
                        </ul>
                    </div>
                </li>
            <?php $s2len++; endforeach ?>
            </ul>
            <div class="shortterm-culture-img block-section2">
                <div class="culture-img culture-img1">
                    <img src="/assets/img/shortterm/culture_img01.jpg" alt="Vietnam culture photo1" />
                </div>
                <div class="culture-img culture-img2">
                    <img src="/assets/img/shortterm/culture_img02.jpg" alt="Vietnam culture photo2" />
                </div>
            </div>
        </section>
        <section>
            <h4 class="content-tit-leftline">
                <?=stripslashes($lang_contents['section3']['title'])?>
            </h4>
            <?php
            $prev_data = array();
            $same_num = array();
            foreach($lang_contents['section3']['schedule'][0] as $key=>$dowval){
                $prev_data[$key] = '';
                $same_num[$key] = 0;
            }
            ?>
            <div class="fixed-table-wrap">
                <table class="umv-table umv-table2 shortterm-table fixed-table770">
                    <colgroup>
                        <col style="width:12%" />
                        <col style="width:13%" />
                        <col style="width:12%" />
                        <col style="width:12%" />
                        <col style="width:12%" />
                        <col style="width:12%" />
                        <col style="width:12%" />
                        <col style="width:15%" />
                    </colgroup>
                    <thead>
                        <tr class="noneboder">
                        <?php foreach($lang_contents['section3']['day_of_week'] as $dowval) : ?>
                            <th scope="col">
                                <?=stripslashes($dowval)?>
                            </th>
                        <?php endforeach ?>
                        </tr>
                    </thead>
                    <tbody>
                    <?php for($j=0; $j<count($lang_contents['section3']['schedule']); $j++) :?>
                        <tr>
                        <?php for($i=0; $i<count($lang_contents['section3']['schedule'][$j]); $i++) : ?>
                            <?php
                            if($prev_data[$i] !== $lang_contents['section3']['schedule'][$j][$i]) :
                                $same_num[$i] = 0;
                                for($h=$j; $h<count($lang_contents['section3']['schedule']); $h++){
                                    if(stripslashes($lang_contents['section3']['schedule'][$j][$i]) === stripslashes($lang_contents['section3']['schedule'][$h][$i])){
                						$same_num[$i]++;
                					}else{
                						break;
                					}
                				}
                            ?>
                            <td rowspan="<?=$same_num[$i]?>">
                                <?=stripslashes($lang_contents['section3']['schedule'][$j][$i])?>
                            </td>
                            <?php endif ?>
                        <?php
                        $prev_data[$i] = $lang_contents['section3']['schedule'][$j][$i];
                        endfor ?>
                        </tr>
                    <?php endfor ?>
                    </tbody>
                </table>
            </div>
        </section>
    </div>
</div>
<script>
$('.shortterm-about-layer').PsuChildAllHeight({
    elem:'.shortterm-about-layer',
    elem_clild:'.inner-box',
    elem_child_sec:'>li'
});
$('.shortterm-culture-list').PsuChildAllHeight({
    elem:'.shortterm-culture-list',
    elem_clild:'.inner-box',
    elem_child_sec:'>li'
});
</script>
