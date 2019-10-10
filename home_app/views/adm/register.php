<div class="page-title-sec">
	<h2 class="page-title"><?=$title?></h2>
</div>
<div class="admin-page-sec">
	<?php $mode_type = (isset($mode_type)) ? $mode_type : 'register'; ?>
	<div>
		<?php
		$frm_action = 'homeAdm/register';
		if($mode_type == 'modify') $frm_action = 'homeAdm/modify';
		echo form_open($frm_action, 'class="BD-check-form"'); ?>
		<fieldset>
			<input type="hidden" name="mode_type" value="<?=$mode_type?>" />
			<?php if($mode_type == 'modify') : ?>
			<input type="hidden" name="userno" value="<?=$user_no?>" />
			<?php endif ?>
			<dl class="BD-write-skinA">
				<dt><label for="userid">UserId</label></dt>
				<dd>
					<input type="text" name="userid" value="<?=$user_id?>" <?php if($mode_type !="register") echo 'readonly="readonly"'?> required="required" id="userid" class="checkInput" />
					<?=($mode_type=='register')?'<strong class="subtxt">※ 이메일 ※</strong>':''?>
					<?php echo form_error('userid'); ?>
				</dd>
				<dt><label for="useremail">UserEmail</label></dt>
				<dd>
					<input type="text" name="useremail" value="<?=$user_email?>" required="required" id="useremail" class="checkInput mailCheck" />
					<?php echo form_error('useremail'); ?>
				</dd>
				<?php if($mode_type == 'register') : ?>
				<dt><label for="password">Password</label></dt>
				<dd>
					<input type="password" name="password" value="" required="required" id="password" class="checkInput pwdLength" />
					<strong class="subtxt">※ 6~18자리 영문과 숫자 특수 문자 (<span style="color:#d10000">!@#$%^&amp;+=_</span>) 조합 ※</strong>
					<?php echo form_error('password'); ?>
				</dd>
				<dt><label for="passconf">Passconf</label></dt>
				<dd><input type="password" name="passconf" value="" required="required" id="passconf" class="checkInput passconf" /><?php echo form_error('passconf'); ?></dd>
				<?php endif ?>
				<dt><label for="username">UserName</label></dt>
				<dd><input type="text" name="username" value="<?=$user_name?>" required="required" id="username" class="checkInput" /><?php echo form_error('username'); ?></dd>
				<?php /*
				<dt><label for="username_en">UserNameEN</label></dt>
				<dd><input type="text" name="username_en" value="<?=$user_name_en?>" required="required" id="username_en" class="checkInput" /><?php echo form_error('username_en'); ?></dd>
				<dt><label for="usernick">UserNick</label></dt>
				<dd><input type="text" name="usernick" value="<?=$user_nick?>" required="required" id="usernick" class="checkInput" /><?php echo form_error('usernick'); ?></dd>
				<dt><label for="userphone">UserPhone</label></dt>
				<dd><input type="text" name="userphone" value="<?=$user_phone?>" required="required" id="userphone" class="checkInput phoneNumCheck" /><?php echo form_error('userphone'); ?></dd>
				*/ ?>
				<?php if($mode_type == 'register' || $check_adm_lv >=10 && $user_type != 'mp_superMaster'): ?>
				<dt><label for="usertype">UserType</label></dt>
				<dd>
					<select name="usertype" id="usertype">
						<option value="mp_master" <?php if(isset($user_type))if($user_type =='mp_master')echo 'selected="selected"'?>>Master</option>
						<option value="mp_user" <?php if(isset($user_type))if($user_type =='mp_user')echo 'selected="selected"'?>>User</option>
					</select>
					<?php echo form_error('usertype'); ?>
				</dd>
				<dt><label for="userlv">UserLevel</label></dt>
				<?php if($mode_type=='register') : ?>
				<dd>
					<select name="userlv" id="userlv">
						<option value="7">7</option>
						<option value="8">8</option>
						<option value="9">9</option>
					</select>
					<?php echo form_error('userlv'); ?>
				</dd>
				<?php else : ?>
				<dd>
					<select name="userlv" id="userlv">
					<?php if($user_type == 'mp_master') : ?>
						<option value="7" <?php if($user_level == 7) echo 'selected="selected"'?>>7</option>
						<option value="8" <?php if($user_level == 8) echo 'selected="selected"'?>>8</option>
						<option value="9" <?php if($user_level == 9) echo 'selected="selected"'?>>9</option>
					<?php else : ?>
						<option value="2" <?php if($user_level == 2) echo 'selected="selected"'?>>2</option>
						<option value="3" <?php if($user_level == 3) echo 'selected="selected"'?>>3</option>
						<option value="4" <?php if($user_level == 4) echo 'selected="selected"'?>>4</option>
						<option value="5" <?php if($user_level == 5) echo 'selected="selected"'?>>5</option>
						<option value="6" <?php if($user_level == 6) echo 'selected="selected"'?>>6</option>
					<?php endif ?>
					</select>
				</dd>
				<?php endif ?>
				<?php endif ?>
				<dt><label for="staff_type">StaffType</label></dt>
				<dd>
					<select name="staff_type" id="staff_type">
						<option value="none" <?=(isset($staff_type)&& $staff_type ==='none')?'selected="selected"':''?>>none</option>
						<option value="mp_staff" <?=(isset($staff_type)&& $staff_type ==='mp_staff')?'selected="selected"':''?>>Staff</option>
					</select>
				</dd>
				<dt><label for="staff_lv">StaffLevel</label></dt>
				<dd>
					<select name="staff_lv" id="staff_lv">
					<?php for($i=0; $i<=10; $i++) : ?>
						<option value="<?=$i?>" <?=(isset($staff_lv)&& $staff_lv ==$i)?'selected="selected"':''?>><?=$i?></option>
					<?php endfor ?>
					</select>
				</dd>
				<?php if($mode_type ==='modify') :?>
				<?php if($mail_approve !== 'yes') : ?>
				<dt><label for="mail_approve">메일인증</label></dt>
				<dd>
					<select name="mail_approve" id="mail_approve">
						<option value="no">no</option>
						<option value="yes">yes</option>
					</select>
				</dd>
				<?php endif ?>
				<?php endif ?>
			</dl>
			<div class="admin-btn-sec2">
				<input type="submit" value="<?=($mode_type=='modify')?'정보수정':'멤버등록'?>" class="admin-btn" />
			</div>
		</fieldset>
		</form>
	</div>
	<?php if($mode_type == 'modify') : ?>
	<div>
		<h3>비밀번호 수정</h3>
		<?=form_open(site_url().'homeAdm/change_password', 'class="BD-check-form"')?>
		<input type="hidden" value="<?=$user_id?>" name="userid" />
		<input type="hidden" name="userno" value="<?=$user_no?>" />
			<dl class="BD-write-skinA">
				<dt><label for="password">Password</label></dt>
				<dd>
					<input type="password" name="password" value="" required="required" id="password" class="checkInput pwdLength" /><?php echo form_error('password'); ?>
					<strong class="subtxt">※ 6~18자리 영문과 숫자 특수 문자 (<span style="color:#d10000">(!@#$%^&amp;+=_</span>) 조합 ※</strong>
				</dd>
				<dt><label for="passconf">Passconf</label></dt>
				<dd><input type="password" name="passconf" value="" required="required" id="passconf" class="checkInput passconf" /><?php echo form_error('passconf'); ?></dd>
			</dl>
			<div class="admin-btn-sec2">
				<input type="submit" value="비밀번호 수정" class="admin-btn" />
			</div>
		</form>
	</div>
	<?php endif ?>
</div>
<?php if($mode_type == 'register' || $check_adm_lv >=10): ?>
<script>
(function($){
	var userType = getIds('usertype');
	var lvselect = getIds('userlv');
	var setCreateNode = function(i){
		var node = document.createElement('OPTION');
		var textnode = document.createTextNode(i);
		node.setAttribute('value',parseInt(i));
		node.appendChild(textnode);
		lvselect.appendChild(node);
	}
	var setOptions = function(usertype){
		if(usertype == 'mp_master'){
			for(var i=7; i<10; i++){
				setCreateNode(i);
			}
		}else{
			for(var i=2; i<7; i++){
				setCreateNode(i);
			}
		}
	}
	//setOptions(userType.value);
	userType.onchange = function(){
		while(lvselect.hasChildNodes()){
		     lvselect.removeChild( lvselect.firstChild );
		}
		setOptions(this.value);
	}
})(jQuery);
</script>
<?php endif ?>
