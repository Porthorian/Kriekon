<?php
	$url = Config::get('site/selfurl');
	//if($_SERVER['HTTPS'] == "on")
		$https = Config::get('site/https') . Config::get('site/httpurl');
	//else
		//$https = Config::get('site/http') . Config::get('site/httpurl'); //this is actually http not https
	
	$plugins = $https . Config::get('site/plugins');
	$css = $https . Config::get('site/resources/css');
  	$images = $https . Config::get('site/resources/images');
  	$js = $https . Config::get('site/resources/js');
?>

<!-- meta -->
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
<title>Social Network for Gamers - Kriekon</title>
<meta name="description" content="Where Gaming meets a Social Network, with Gaming News, Real World News, and a tid bit of blogging :P social network for gamers" />

<!-- Favi Icon -->
<link rel="apple-touch-icon" sizes="180x180" href="<?= $images . '/favi_icons/apple-touch-icon.png'; ?>">
<link rel="icon" type="image/png" sizes="32x32" href="<?= $images . '/favi_icons/favicon-32x32.png'; ?>">
<link rel="icon" type="image/png" sizes="16x16" href="<?= $images . '/favi_icons/favicon-16x16.png'; ?>">
<link rel="manifest" href="<?= $images . '/favi_icons/manifest.json'; ?>">
<link rel="mask-icon" href="<?= $images . '/favi_icons/safari-pinned-tab.svg'; ?>" color="#384042">
<link rel="shortcut icon" href="<?= $images . '/favi_icons/favicon.ico'; ?>">
<meta name="msapplication-config" content="<?= $images . '/favi_icons/browserconfig.xml'; ?>">
<meta name="theme-color" content="#000000">

<!-- vendor css -->
<link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Roboto:300,400,500,700">
<link rel="stylesheet" href="<?= $plugins . '/font-awesome/css/font-awesome.min.css'; ?>">
<link rel="stylesheet" href="<?= $plugins . '/bootstrap/css/bootstrap.min.css'; ?>">
<link rel="stylesheet" href="<?= $plugins . '/animate/animate.min.css'; ?>">

<!-- theme css -->
<link rel="stylesheet" href="<?= $css . '/theme.min.css'; ?>">
<link rel="stylesheet" href="<?= $css . '/custom.css'; ?>">

<!-- Google Analytics Code -->
<!-- Global Site Tag (gtag.js) - Google Analytics -->
<script async src="https://www.googletagmanager.com/gtag/js?id=UA-107677938-1"></script>
<script>
  window.dataLayer = window.dataLayer || [];
  function gtag(){dataLayer.push(arguments);}
  gtag('js', new Date());

  gtag('config', 'UA-107677938-1');
</script>
<!-- End Google Anayltics Code -->

<!-- Google Adsense Code -->
<!--
<script async src="//pagead2.googlesyndication.com/pagead/js/adsbygoogle.js"></script>
<script>
  (adsbygoogle = window.adsbygoogle || []).push({
	google_ad_client: "ca-pub-9692718914237282",
	enable_page_level_ads: true
  });
</script>-->