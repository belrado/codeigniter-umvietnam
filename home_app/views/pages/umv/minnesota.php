<div class="section-full">
    <div class="section_wrapper">
        <div class="umv-chancellor-img block-content">
            <div class="text-box">
                <span class="greeting font-poppins">Greeting</span>
                <?php foreach($lang_contents['img_text'] as $val) : ?>
                <p class="font-poppins"><?=stripslashes($val)?></p>
                <?php endforeach ?>
            </div>
        </div>
        <div class="umv-chancellor-txt block-section">
            <?php foreach($lang_contents['text'] as $val) : ?>
            <p class="marginB20">
                <?=stripslashes($val)?>
            </p>
            <?php endforeach ?>
        </div>
        <strong class="umv-chancellor-sign">
            <span class="name">Mary Holz-Clause</span>
            <span>Chancellor</span>
        </strong>
    </div>
</div>
