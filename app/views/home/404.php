<!DOCTYPE html>
<html lang="en">
<head>
<?php require_once(Config::get('site/baseurl') . Config::get('site/assets') . '/head.php'); ?>
</head>
<body class="fixed-header">
  <!-- header -->
  <?php require_once(Config::get('site/baseurl') . Config::get('site/assets') . '/header.php'); ?>

  <!-- main -->
  <section class="bg-image bg-image-sm error-404" style="background-image: url('https://img.youtube.com/vi/y3Cpetu4ke4/maxresdefault.jpg');">
    <div class="overlay"></div>
    <div class="container">
      <div class="row">
        <div class="col-lg-8 mx-auto">
          <div class="heading">
            <h2>404</h2>
          </div>
          <p>Sorry, but the page you requested could not be found.</p>
          <form>
            <div class="col-lg-8 mx-auto">
              <div class="form-group input-icon-right">
                <input type="text" class="form-control" placeholder="Search Page...">
                <i class="fa fa-search"></i>
              </div>
            </div>
          </form>
          <div class="m-t-50">
            <a href="/" class="btn btn-primary btn-effect btn-shadow btn-rounded btn-lg">Back to home</a>
            <a href="contact.html" class="btn btn-outline-default btn-rounded btn-lg m-l-10">Contact Us</a>
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

  <!-- theme js -->
  <script src="<?= $js . '/theme.min.js'; ?>"></script>
</body>
</html>