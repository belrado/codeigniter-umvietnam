<!-- // 메인 스크립트  // -->
<section>
	<h2 class="blind"><?=HOME_INFO_NAME?> 중요 소식</h2>
	<div id="psu-main-event-wrap" class="top-fixed-padding">
		<div class="psu-main-slide-wrap" id="psu-main-slide-wrap">
			<ul id="KysSlide" class="main-slide-list">
				<?php $mainJsLen=1; foreach($lang_mainjs as $jsVal) : ?>
				<li class="main-slide-box main-slide-box<?=$mainJsLen?>">
					<div class="section_wrapper">
						<div class="slide-contents">
							<h3 class="slide-title">
								<span class="sub-title"><?=$jsVal['sub_title']?></span>
								<?=$jsVal['title']?>
							</h3>
							<p class="slide-txt">
								<?=$jsVal['text']?>
							</p>
						</div>
					</div>
					<div class="bgbox"></div>
				</li>
				<?php $mainJsLen++; endforeach ?>
				<?php /*
				<li class="main-slide-box main-slide-box1">
					<div class="section_wrapper">
						<div class="slide-contents">
							<h3 class="slide-title">
								<span class="sub-title"><?=$lang_mainjs['section1']['sub_title']?></span>
								<?=$lang_mainjs['section1']['title']?>
							</h3>
							<p class="slide-txt">
								<?=$lang_mainjs['section1']['text']?>
							</p>
						</div>
					</div>
					<div class="bgbox"></div>
				</li>
                <li class="main-slide-box main-slide-box2">
					<div class="section_wrapper">
						<div class="slide-contents">

						</div>
					</div>
					<div class="bgbox"></div>
				</li>
				<li class="main-slide-box main-slide-box3">
					<div class="section_wrapper">
						<div class="slide-contents">

						</div>
					</div>
					<div class="bgbox"></div>
				</li>
				*/ ?>
			</ul>
			<input type="button" value="이전" id="mainJSprevBtn" class="mainJSbtn mainJSprevBtn" />
			<input type="button" value="다음" id="mainJSnextBtn" class="mainJSbtn mainJSnextBtn" />
		</div>
	</div>
</section>
<!-- // 메인스크립트 끝 // -->
