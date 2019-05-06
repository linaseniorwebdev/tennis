<div class="container d-flex flex-column justify-content-between vh-100">
	<div class="row justify-content-center mt-5">
		<div class="col-xl-5 col-lg-6 col-md-10">
			<div class="card">
				<div class="card-header bg-primary">
					<div class="app-brand">
						<a href="javascript:void(0)">
							<svg class="brand-icon" xmlns="http://www.w3.org/2000/svg" preserveAspectRatio="xMidYMid" width="30"
							     height="33" viewBox="0 0 30 33">
								<g fill="none" fill-rule="evenodd">
									<path class="logo-fill-blue" fill="#7DBCFF" d="M0 4v25l8 4V0zM22 4v25l8 4V0z"></path>
									<path class="logo-fill-white" fill="#FFF" d="M11 4v25l8 4V0z"></path>
								</g>
							</svg>
							<span class="brand-name">Tennis Prediction</span>
						</a>
					</div>
				</div>
				<div class="card-body p-5">
					<?php
					if (isset($error)) {
						echo '<h4 class="text-dark mb-3">Sign Up</h4>';
						echo '<p class="mb-3" style="color: red;">'. $error . '</p>';
					} else {
						echo '<h4 class="text-dark mb-5">Sign Up</h4>';
					}
					?>
					<form action="<?php echo base_url('member/signup') ?>" method="post">
						<div class="row">
							<div class="form-group col-md-12 mb-4">
								<input type="text" class="form-control input-lg" name="first" placeholder="First Name" required oninvalid="this.setCustomValidity('Please enter your first name')" oninput="setCustomValidity('')" <?php if (isset($first)) echo 'value="'. $first . '"' ?> />
							</div>
							<div class="form-group col-md-12 mb-4">
								<input type="text" class="form-control input-lg" name="last" placeholder="Last Name" required oninvalid="this.setCustomValidity('Please enter your last name')" oninput="setCustomValidity('')" <?php if (isset($last)) echo 'value="'. $last . '"' ?> />
							</div>
							<div class="form-group col-md-12 mb-4">
								<input type="email" class="form-control input-lg" name="email" placeholder="Email" required oninvalid="this.setCustomValidity('Please enter your email address')" oninput="setCustomValidity('')" <?php if (isset($email)) echo 'value="'. $email . '"' ?> />
							</div>
							<div class="form-group col-md-12 ">
								<input type="password" class="form-control input-lg" name="password" id="password" placeholder="Password" minlength="8" required oninvalid="this.setCustomValidity('Please enter at least eight digits for the password')" oninput="setCustomValidity('')" <?php if (isset($password)) echo 'value="'. $password . '"' ?> />
							</div>
							<div class="form-group col-md-12 ">
								<input type="password" class="form-control input-lg" id="cpassword" placeholder="Confirm Password" required <?php if (isset($password)) echo 'value="'. $password . '"' ?> />
							</div>
							<div class="col-md-12">
								<div class="d-inline-block mr-3">
									<label class="control control-checkbox">
										<input type="checkbox" name="agree" <?php if (isset($agree) && $agree === 'on') echo 'checked' ?> />
										<div class="control-indicator"></div>
										I Agree the terms and conditions
									</label>
								</div>
								<button type="submit" class="btn btn-lg btn-primary btn-block mb-4">Sign Up</button>
								<p>Already have an account?
									<a class="text-blue" href="<?php echo base_url('member/signin') ?>">Sign in</a>
								</p>
							</div>
						</div>
					</form>
				</div>
			</div>
		</div>
	</div>
	<div class="copyright pl-0">
		<p class="text-center">&copy; 2019 Copyright,
			<a class="text-primary" href="<?php echo REFERRER; ?>" target="_blank">SDev</a>.
		</p>
	</div>
</div>
<script>
	let password = document.getElementById("password"), confirm_password = document.getElementById("cpassword");

	function validatePassword(){
		if(password.value !== confirm_password.value) {
			confirm_password.setCustomValidity("Passwords Don't Match");
		} else {
			confirm_password.setCustomValidity('');
		}
	}

	password.onchange = validatePassword;
	confirm_password.onkeyup = validatePassword;
</script>