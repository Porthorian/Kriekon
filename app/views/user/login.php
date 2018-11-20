<!DOCTYPE html>
<html lang="en">
<head>
  <?php require_once(Config::get('site/baseurl') . Config::get('site/assets') . '/head.php'); ?>
  <!-- plugins css -->
  <link href="<?= $plugins . '/ytplayer/jquery.mb.YTPlayer.min.css'; ?>" rel="stylesheet">
</head>
<body class="fixed-header">
  <!-- header -->
  <?php require_once(Config::get('site/baseurl') . Config::get('site/assets') . '/header.php'); ?>
  <!-- /header -->

  <!-- main -->
  <section class="bg-image player p-y-70" style="background-image: url('https://img.youtube.com/vi/1GWRDuL04-Q/maxresdefault.jpg');" data-property="{videoURL:'1GWRDuL04-Q',containment:'self', stopMovieOnBlur:false, showControls: false, mute:true, realfullscreen: true, showYTLogo: false, quality: 'highres',autoPlay:true,loop:true,opacity:1}">
    <div class="overlay"></div>
    <div class="container">
      <div class="row">
        <div class="col-12 col-sm-8 col-md-4 mx-auto">
          <div class="card m-b-0">
            <div class="card-header">
              <h4 class="card-title"><i class="fa fa-sign-in"></i> Login to your account</h4>
            </div>
            <div class="card-block">
              <form action="<?= $https . '/user/login/?action=login'; ?>" method="POST">
                <div class="form-group input-icon-left m-b-10">
                  <i class="fa fa-user"></i>
                  <input type="email" name="login_email" class="form-control form-control-secondary" placeholder="Email">
                </div>
                <div class="form-group input-icon-left m-b-15">
                  <i class="fa fa-lock"></i>
                  <input type="password" name="login_password" class="form-control form-control-secondary" placeholder="Password">
                </div>
                <label class="custom-control custom-checkbox custom-checkbox-primary">
					<input type="checkbox" class="custom-control-input">
					<span class="custom-control-indicator"></span>
					<span class="custom-control-description">Remember me</span>
              	</label>
				<div class="divider"><span>I am not a robot</span></div>
                <div class="g-recaptcha-outer">
                  <script src='https://www.google.com/recaptcha/api.js'></script>
                  <div class="g-recaptcha" data-sitekey="6Lf4ikwUAAAAAKnAjbraiVah0wJ_ueAGgnjFLbYI"></div>
                </div>
				<input type="hidden" name="login_token" value="<?php echo $_SESSION[Config::get('session/token_name')]; ?>">
                <button type="submit" class="btn btn-primary btn-block m-t-10">Login <i class="fa fa-sign-in"></i></button>
                <div class="divider">
                  <span>Don't have an account?</span>
                </div>
                <a class="btn btn-secondary btn-block" href="<?= $https . '/user/registeration'; ?>" role="button">Register</a>
              </form>
            </div>
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
  <script src="<?= $plugins . '/popper/popper.min.js'; ?>"></script>
  <script src="<?= $plugins . '/bootstrap/js/bootstrap.min.js'; ?>"></script>

  <!-- plugins js -->
  <script src="<?= $plugins . '/ytplayer/jquery.mb.YTPlayer.min.js'; ?>"></script>
  <script>
    (function($) {
      "use strict";
      $(".player").mb_YTPlayer();
    })(jQuery);
  </script>

  <!-- theme js -->
  <script src="<?= $js . '/theme.min.js'; ?>"></script>
</body>
</html>