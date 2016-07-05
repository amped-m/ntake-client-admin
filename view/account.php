<div class="container">
	<ul class="nav nav-tabs">
		<li class="active"><a data-toggle="tab" href="#tab-general">General Information</a></li>
		<li><a data-toggle="tab" href="#tab-password">Password</a></li>
	</ul>
	
	<div class="tab-conent">
		<div id="tab-general" class="tab-pane fade in active">
			<form method="post" accept-charset="utf-8" autocomplete="off">
				<p class="account-msg"></p>
				<div class="form-section">
					<label>Company Name</label>
					<input type="text" value="<?php echo $info['business_name']; ?>" name="business_name" required />
				</div>
				
				<div class="form-section">
					<label>Phone Number</label>
					<input id="phone-area" type="text" value="<?php echo $info['phone_area_code']; ?>" minlength="3" maxlength="3" name="phone_area_code" required />
					<input type="text" value="<?php echo $info['phone_number_1']; ?>" minlength="3" maxlength="3" name="phone_number_1" required />
					<input type="text" value="<?php echo $info['phone_number_2']; ?>" minlength="4" maxlength="4" name="phone_number_2" required />
					<p class="form-err" id="err-phone"></p>
				</div>
				
				<div class="form-section">
					<label>Fax Number</label>
					<p>Optional</p>
					<input id="fax-area" type="text" value="<?php echo $info['fax_area_code']; ?>" minlength="3" maxlength="3" name="fax_area_code" placeholder="optional" />
					<input type="text" value="<?php echo $info['fax_number_1']; ?>" minlength="3" maxlength="3" name="fax_number_1" />
					<input type="text" value="<?php echo $info['fax_number_2']; ?>" minlength="4" maxlength="4" name="fax_number_2" />
					<p class="form-err" id="err-fax"></p>
				</div>
				
				<div class="form-section">
					<label>Address</label>
					<input type="text" value="<?php echo $info['address_1']; ?>" name="address_1" required />
					<input type="text" value="<?php echo $info['address_2']; ?>" placeholder="optional" name="address_2" /><br />
					<input type="text" value="<?php echo $info['city']?>" name="city" required />
					<input id="state" type="text" value="<?php echo $info['state']?>" minlength="2" maxlength="2" name="state" required />
					<input id="zipcode" type="text" value="<?php echo $info['zipcode']?>" name="zipcode" minlength="5" maxlength="5" required />
					<p class="form-err" id="err-state"></p>
					<p class="form-err" id="err-zipcode"></p>
				</div>
				
				<div class="form-section">
					<label>Mail ATTN</label>
					<input type="text" value="<?php echo $info['mail_attn']; ?>" name="mail_attn" required />
				</div>
				
				<div class="form-section">
					<input id="submit-general" class="btn btn-primary" type="submit" value="Save" name="submit_general" />
				</div>
			</form>
		</div>
		
		<div id="tab-password" class="tab-pane fade">
			<form id="form-password" method="post" accept-charset="utf-8" autocomplete="off">
				<p class="account-msg"></p>
				<div class="form-section">
					<label>Username</label>
					<input id="username" type="text" value="<?php echo $info['username']; ?>" disabled />
				</div>
				
				<div class="form-section">
					<p>If you do not want to change the password, please leave it blank.</p>
					<label>Password</label>
					<input id="password" type="password" name="password" /><br />
					
					<label>Confirm Password</label>
					<input id="password-confirm" type="password" name="password_confirm" />
				</div>
				
				<p class="form-err" id="err-password"></p>
				
				<div class="form-section">
					<input id="submit-password" class="btn btn-primary" type="submit" value="Save" name="submit_password" />
				</div>
			</form>
		</div>
	</div>
</div>

<script src="assets/js/state.json"></script>