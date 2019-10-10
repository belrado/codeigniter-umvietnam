<!-- // 퀵메뉴 // -->
<nav class="quick-wrap" id="quick-wrap">
	<div class="total-class-info">
		<a href="http://psuedu.org/class/" class="total-class">
			<strong>전체강좌 안내</strong>
			<span>바로가기</span>
		</a>
	</div>
	<ul class="quick-list2">
		<li>
			<div class="quick-box quick-menu1 quick-multiple">
				<ul class="quick-txt">
					<li><a href="http://mediprep.co.kr" target="_blank" title="새창" class="medi">약대·의대 컨설팅</a></li>
				</ul>
				<span class="quick-ico"></span>
			</div>
		</li>
		<li>
			<div class="quick-box quick-menu2 quick-multiple">
				<ul class="quick-txt">
					<?php /*
					<li><a href="<?=site_url()?>board/filedown/2017_summer_apsubject/file/pdf">단과 브로슈어 &nbsp;<span>▼</span></a></li>
					<li><a href="<?=site_url()?>board/filedown/2018_summer_brochure/file/pdf">여름특강 브로슈어 &nbsp;<span>▼</span></a></li>
					<li><a href="<?=site_url()?>board/filedown/2017_college_brochure/file/pdf">컨설팅 브로슈어 &nbsp;<span>▼</span></a></li>
					<li><a href="<?=site_url()?>board/filedown/2018special/file/pdf">특례&amp;수시 브로슈어 &nbsp;<span>▼</span></a></li>
					 */ ?>
					<li><a href="<?=site_url()?>assets/file/down/2017_college_brochure.pdf" class="home-pdf-view-jsdown" target="_blank">컨설팅 브로슈어 &nbsp;<span>▼</span></a></li>
					<li><a href="<?=site_url()?>assets/file/down/2018special.pdf" class="home-pdf-view-jsdown" target="_blank">특례&amp;수시 브로슈어 &nbsp;<span>▼</span></a></li>
				</ul>
				<span class="quick-ico"></span>
			</div>
		</li>
		<li class="mobile-fixed">
		<?php if($is_mobile) : ?>
			<a href="tel:02-540-2510" class="quick-box quick-menu3">
				<span class="quick-ico"></span>
				<span class="quick-txt">02)540-2510</span>
			</a>
		<?php else : ?>
			<div class="quick-box quick-menu3">
				<span class="quick-ico"></span>
				<span class="quick-txt">02)540-2510</span>
			</div>
		<?php endif ?>
		</li>
		<li>
			<div class="quick-box quick-kakaoplus quick-multiple">
				<ul class="quick-txt">
					<li>
						<a href="http://pf.kakao.com/_FQxkmxl/chat" class="psu_kakao_plus_chat" target="_blank">
							<span class="kakao-ico kakao-chat"></span>Kakao<span class="plus"></span> 친구 채팅
						</a>
					</li>
					<li>
						<a href="javascript:;" class="psu_kakao_plus_addf">
							<span class="kakao-ico kakao-add"></span>Kakao<span class="plus"></span> 친구 추가
						</a>
					</li>
					<li>
						<a href="https://pf.kakao.com/_FQxkmxl" target="_blank">
							<span class="kakao-ico kakao-link"></span>Kakao<span class="plus"></span> 친구 보기
						</a>
					</li>
				</ul>
				<span class="quick-ico"></span>
			</div>
		</li>
		<?php /*
		<li>
			<a href="<?=site_url()?>intro_institute/map" class="quick-box quick-menu4">
				<span class="quick-ico"></span>
				<span class="quick-txt">셔틀버스 노선</span>
			</a>
		</li>
		 *
		 */ ?>
	</ul>
</nav>
<!-- // 퀵메뉴 끝 // -->
