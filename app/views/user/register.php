<!DOCTYPE html>
<html lang="en">
<head>
  <?php require_once(Config::get('site/baseurl') . Config::get('site/assets') . '/head.php'); ?>
</head>
<body class="fixed-header">
  <!-- header -->
  <?php require_once(Config::get('site/baseurl') . Config::get('site/assets') . '/header.php'); ?>
  <!-- /header -->

  <!-- main -->
  <section class="bg-image bg-image-sm" style="background-image: url('https://img.youtube.com/vi/BhTkoDVgF6s/maxresdefault.jpg');">
    <div class="overlay"></div>
    <div class="container">
      <div class="row">
        <div class="col-12 col-sm-8 col-md-4 mx-auto">
          <div class="card">
            <div class="card-header">
              <h4 class="card-title"><i class="fa fa-user-plus"></i> Register a new account</h4>
            </div>
            <div class="card-block">
              <form action="<?= $https . '/user/register'; ?>" method="POST" autocomplete="false" id="registration-form">
				<!--<div class="form-group input-icon-left m-b-10">
                  <i class="fa fa-child"></i>
                  <input type="text" name="register_firstname" data-sanitize="capitalize" data-validation="alphanumeric length" data-validation-length="2-32" data-validation-error-msg="(2-32 chars)" id="firstname" class="form-control form-control-secondary" placeholder="Firstname" autocomplete="false" required>
                </div> -->
				<div class="form-group input-icon-left m-b-10">
                  	<i class="fa fa-calendar"></i>
                  	<input type="date" name="register_dob" data-validation="age_validator" class="form-control form-control-secondary" placeholder="Birthdate" autocomplete="off" required>
                </div>
                <div class="form-group input-icon-left m-b-10">
                  <i class="fa fa-user"></i>
                  <input type="text" name="register_username" id="username" class="form-control form-control-secondary" placeholder="Username" autocomplete="off" data-validation="length alphanumeric server" data-validation-url="/ajax/check_username" data-validation-length="3-20" data-validation-error-msg="User name has to be an alphanumeric value (3-20 chars)" required>
                </div>
                <div class="form-group input-icon-left m-b-10">
                  <i class="fa fa-envelope"></i>
                  <input type="email" name="register_email" data-validation="email server" data-validation-url="/ajax/check_email" class="form-control form-control-secondary" placeholder="Email Address" autocomplete="off" required>
                </div>
				<div class="form-group input-icon-left m-b-10">
                  <i class="fa fa-globe"></i>
                  <input type="text" name="register_country" data-validation="country" class="form-control form-control-secondary" placeholder="Country" autocomplete="off" required>
                </div>
                <div class="divider"><span>Security</span></div>
                <div class="form-group input-icon-left m-b-10">
                  <i class="fa fa-lock"></i>
                  <input type="password" name="register_password_confirmation" data-validation="strength" data-validation-strength="2" minlength="8" maxlength="32" class="form-control form-control-secondary" placeholder="Password" required>
                </div>
                <div class="form-group input-icon-left m-b-10">
                  <i class="fa fa-unlock"></i>
                  <input type="password" name="register_password" data-validation="confirmation" minlength="8" maxlength="32" class="form-control form-control-secondary" placeholder="Repeat Password" data-validation-error-msg="Passwords do not match!" required>
                </div>
                <div class="divider"><span>I am not a robot</span></div>
                <div class="g-recaptcha-outer">
                  <script src='https://www.google.com/recaptcha/api.js'></script>
                  <div class="g-recaptcha" data-sitekey="6Lf4ikwUAAAAAKnAjbraiVah0wJ_ueAGgnjFLbYI"></div>
                </div>
                <div class="divider"><span>Terms of Service</span></div>
                <!--<label class="custom-control custom-checkbox custom-checkbox-primary custom-checked">
					<input type="checkbox" class="custom-control-input" checked="">
					<span class="custom-control-indicator"></span>
					<span class="custom-control-description">Subscribe to monthly newsletter</span>
              	</label>-->
                <label class="custom-control custom-checkbox custom-checkbox-primary">
					<input type="checkbox" class="custom-control-input" data-validation="checkbox_group" data-validation-qty="min1" required>
					<span class="custom-control-indicator"></span>
					<span class="custom-control-description">Accept <a href="#" data-toggle="modal" data-target="#terms">terms of service</a></span>
              	</label>
				<input type="hidden" name="register_token" value="<?php echo $_SESSION[Config::get('session/token_name')]; ?>">
                <button type="submit" class="btn btn-primary m-t-10 btn-block">Complete Registration</button>
              </form>
            </div>
          </div>
        </div>
      </div>
    </div>

    <!-- Modal -->
    <div class="modal fade" id="terms">
      <div class="modal-dialog modal-top" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title"><i class="fa fa-file-text-o"></i> Terms of Service</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
          </div>
          <div class="modal-body">
            <h6>1. For the Sake of Simplicity</h6>
            <p>As this site is still in development. The Terms of Service will be subject to change on the full release of the site. When a user creates an account(you) you are acknowledging that everything you see and enter into this Kriekon's website is and will be subject to change and or deleted. If you decide to create an account you will be subject to a newsletter unless you unsubscribe too it. Which there will be a link at the end of the email. This newsletter will describe the development and progress of the site until therefore the full release of the site. <strong>This site has no functionality at this time 3/13/2018 until the full release of the site which will occur on 8/12/2018</strong></p>
			<h6>2. Privacy</h6>
			<p>Your email and personal information will never be shared, won't be sold or solicitated too outside parties.</p>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-primary" data-dismiss="modal">Close</button>
          </div>
        </div>
      </div>
    </div>
  </section>
  <!-- /main -->

  <!-- footer -->
  <?php require_once(Config::get('site/baseurl') . Config::get('site/assets') . '/footer.php'); ?>
  <!-- /footer -->

	<!-- vendor js -->
	<script src="<?= $plugins . '/jquery/jquery-3.2.1.min.js'; ?>"></script>
	<script src="<?= $plugins . '/jQuery-validator/form-validator/jquery.form-validator.min.js'; ?>"></script>
	<script src="<?= $plugins . '/popper/popper.min.js'; ?>"></script>
	<script src="<?= $plugins . '/bootstrap/js/bootstrap.min.js'; ?>"></script>

	<!-- theme js -->
	<script src="<?= $js . '/theme.min.js'; ?>"></script>
	
	<!-- Initialization js -->
	<script src="<?= $js . '/init/register.js'; ?>"></script>
</body>
</html>