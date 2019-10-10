	</div> <!-- // contents // -->
	<footer id="footer" class="blind">
		<div class="footer-sec">Copyright &copy; 2014. MediPrep. ALL RIGHT RESERVED.</div>
	</footer>
</div> <!-- // wrapper // -->
<script src="<?=HOME_JS_PATH?>/BD_form_validation.js"></script>
<?php
if(isset($javascript_arr)){
	$custom_js_len = count($javascript_arr);
	if($custom_js_len >0){
		foreach($javascript_arr as $js){
			echo $js.PHP_EOL;
		}
	}
}
?>
<?php if(isset($fullSize) && $fullSize) : ?>
<script>
	$('#view_header').on({
		click:function(){
			if(!$(this).hasClass('active')){
				$(this).addClass('active');
				$('#wrapper').removeClass('fullsize');
			}else{
				$(this).removeClass('active');
				$('#wrapper').addClass('fullsize');
			}	
		}
	})
</script>
<?php endif ?>
<?php if($this->session->get_flash_keys('message')) : ?>
<script>
	var show_message = "<?=$this->session->flashdata('message')?>";
	if(show_message !== '')
		alert(show_message);
</script>
<?php endif ?>
<?php if(isset($alert_message)) : ?>
<script>
	var show_message2 = "<?=str_replace("\n", ", ", strip_tags($alert_message))?>";
	alert(show_message2);
</script>	
<?php endif ?>
</body>
</html>