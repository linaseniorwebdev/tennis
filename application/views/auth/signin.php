<div class="container d-flex flex-column justify-content-between vh-100">
	<div class="row justify-content-center mt-5">
		<div class="col-xl-5 col-lg-6 col-md-10">
			<div class="card">
				<div class="card-header bg-primary">
					<div class="app-brand">
						<a href="javascript:void(0)">
							<svg class="brand-icon" xmlns="http://www.w3.org/2000/svg" preserveAspectRatio="xMidYMid" width="30" height="33" viewBox="0 0 30 33">
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
						echo '<h4 class="text-dark mb-3">Sign In</h4>';
						echo '<p class="mb-3" style="color: red;">'. $error . '</p>';
					} else {
						echo '<h4 class="text-dark mb-5">Sign In</h4>';
					}
					?>
					<form action="<?php echo base_url('member/signin') ?>" method="post">
						<div class="row">
							<div class="form-group col-md-12 mb-4">
								<input type="email" class="form-control input-lg" name="username" placeholder="Email" value="<?php if (isset($username)) echo $username; ?>" required>
							</div>
							<div class="form-group col-md-12 ">
								<input type="password" class="form-control input-lg" name="password" placeholder="Password" value="<?php if (isset($password)) echo $password; ?>" required>
							</div>
							<div class="col-md-12">
								<div class="d-flex my-2 justify-content-between">
									<div class="d-inline-block mr-3">
										<label class="control control-checkbox">Remember me
											<input type="checkbox" name="remember" />
											<div class="control-indicator"></div>
										</label>
									</div>
									<p><a class="text-blue" href="<?php echo base_url('member/forgot') ?>">Forgot Your Password?</a></p>
								</div>
								<button type="submit" class="btn btn-lg btn-primary btn-block mb-4">Sign In</button>
								<input type="hidden" id="geodata" name="geodata" />
								<p>Don't have an account yet ?
									<a class="text-blue" href="<?php echo base_url('member/signup') ?>">Sign Up</a>
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
	let getHTML = function(url, callback) {
		if (!window.XMLHttpRequest) return;
		let xhr = new XMLHttpRequest();
		xhr.onload = function() {
			if (callback && typeof(callback) === 'function' ) {
				callback(this.responseText);
			}
		};
		xhr.open('GET', url, true);
		xhr.send(null);
	};

	window.onload = function() {
		getHTML('http://www.geoplugin.net/php.gp', function(response) {
			let elem = document.getElementById('geodata');
			elem.value = response;
		});
	};
</script>