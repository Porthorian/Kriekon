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
	<section class="bg-image player p-y-70" style="background-image: url('https://img.youtube.com/vi/1GWRDuL04-Q/maxresdefault.jpg');" data-property="{videoURL:'1GWRDuL04-Q',containment:'self', stopMovieOnBlur:false, mute:true, showControls: false, realfullscreen: true, showYTLogo: false, quality: 'highres',autoPlay:true,loop:true,opacity:1}">
		<div class="overlay"></div>
		<div class="coming-soon p-y-80">
		  <div>
			<h2>Coming Soon!</h2>
			<div class="countdown">
			  <div id="clock"></div>
			</div>
			<p>Our website is under construction, We'll be here soon, with our new site. Subscribe to be notified.</p>
			<div class="m-t-30">
			  <a href="<?= $https . '/user/registration'; ?>" class="btn btn-primary btn-shadow btn-rounded btn-effect btn-lg">Subscribe</a>
			  <a href="#" class="btn btn-outline-default btn-rounded btn-lg m-l-10">Contact Us</a>
			</div>
		  </div>
		</div>
	</section>
  	<section class="bg-secondary">
		<div class="container">
			<div class="col-sm-12 col-md-10 col-lg-8 mx-auto">
				<h3 style="text-align: center; letter-spacing: 0.3em; font-weight: 400;">WHAT IS KRIEKON?</h3>
				<h2 style="text-align: center; border-bottom: 2px solid #2d2d2d; padding-bottom: 15px;"><strong>WHERE GAMING MEETS SOCIAL</strong></h2>
				<p style="text-align: center; color: #434842; padding-top: 10px;">Kriekon is a New Social Network for Gamers. Kriekon is a 1 Stop Shop for Gamers, where the community can take advantage of the platform we have built. We as Gamers enjoy information, entertainment, and socialization.</p>
				<p style="text-align: center; color: #434842;">By Joining Kriekon you will be able to embark hopefully :P on a journey that will lead you too new friends, a plethora of knowledge, join communites, and most of all have fun playing Games! Whether that would be Killing Monsters, 360 No-Scope in a FPS, Miticulating your next move in a Stratgey Game, or playing the ever growing list of simulation games. There is limitless possibilites that can be achieved.</p>
				<p style="text-align: center; color: #434842;">We as Gamers, pride ourselves on being connected to our friends, colleagues, our favorite streamer, the meme of the day, the next game coming out, gameplay tips and tricks, connect with developers, the list can go on and on. We hope you join us on our journey to connect the Gaming Industry and bring us all a little closer together :P</p>
			</div>
		</div>
  	</section>
  	<section class="p-y-80">
		<div class="container">
			<div class="row">
				<div class="col-sm-12 col-md-10 col-lg-8 mx-auto">
					<h3 style="text-align: center; letter-spacing: 0.3em; font-weight: 400;">WHAT YOU WILL FIND ON KRIEKON</h3>
					<h2 style="text-align: center; border-bottom: 2px solid #2d2d2d; padding-bottom: 15px;"><strong>KRIEKON FEATURES</strong></h2>
				</div>
			</div>
			<div class="row" style="padding-top: 15px;">
				<div class="col-md-4">
					<div class="widget widget-game">
            			<div class="widget-block" style="background-image: url('<?= $images . '/coming_soon/Under_construction.jpg'; ?>')">
              			<div class="overlay"></div>
              			<div class="widget-item">
                			<h4>Article/Blog and Forum System</h4>
                			<span class="meta">TBD</span>

							<h5>Status</h5>
							<a href="#"><span class="badge badge-ps4">Under Construction</span></a>
							
							<p>Allow Users to post Blog's and use inhouse forum engine.</p>
							<div class="progress">
								<div class="progress-bar progress-bar-success" role="progressbar" aria-valuenow="60" aria-valuemin="0" aria-valuemax="100" style="width: 60%;"></div>
							</div>
              			</div>
            			</div>
          			</div>
					<div class="widget widget-game">
            			<div class="widget-block" style="background-image: url('https://img.youtube.com/vi/U75Qkzc2tqA/maxresdefault.jpg')">
              			<div class="overlay"></div>
              			<div class="widget-item">
                			<h4>News System</h4>
                			<span class="meta">TBD</span>

							<h5>Status</h5>
							<a href="#"><span class="badge badge-xbox-one">Planned</span></a>

							<p>Use of RSS feeds that display content to our users based on their likes when joining the site.</p>
							<div class="progress">
								<div class="progress-bar progress-bar-success" role="progressbar" aria-valuenow="5" aria-valuemin="0" aria-valuemax="100" style="width: 0%;"></div>
							</div>
              			</div>
            			</div>
          			</div>
					<div class="widget widget-game">
            			<div class="widget-block" style="background-image: url('https://img.youtube.com/vi/mW4LMCtoIkg/maxresdefault.jpg')">
              			<div class="overlay"></div>
              			<div class="widget-item">
                			<h4>Video System</h4>
                			<span class="meta">TBD</span>

							<h5>Status</h5>
							<a href="#"><span class="badge badge-xbox-one">Planned</span></a>

							<p>Creation of File Systems that house's Users Videos over a CDN.</p>
							<div class="progress">
								<div class="progress-bar progress-bar-success" role="progressbar" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100" style="width: 0%;"></div>
							</div>
              			</div>
            			</div>
          			</div>
				</div>
				<div class="col-md-4">
					<div class="widget widget-game">
            			<div class="widget-block" style="background-image: url('<?= $images . '/coming_soon/Under_construction.jpg'; ?>')">
              			<div class="overlay"></div>
              			<div class="widget-item">
                			<h4>User System</h4>
                			<span class="meta">TBD</span>

							<h5>Status</h5>
							<a href="#"><span class="badge badge-ps4">Under Construction</span></a>

							<p>Backbone of the User System, Friend's List, and Messenger.</p>
							<div class="progress">
								<div class="progress-bar progress-bar-success" role="progressbar" aria-valuenow="40" aria-valuemin="0" aria-valuemax="100" style="width: 40%;"></div>
							</div>
              			</div>
            			</div>
          			</div>
					<div class="widget widget-game">
            			<div class="widget-block" style="background-image: url('https://img.youtube.com/vi/K5tRSwd-Sc0/maxresdefault.jpg')">
              			<div class="overlay"></div>
              			<div class="widget-item">
                			<h4>Games System</h4>
                			<span class="meta">TBD</span>

							<h5>Status</h5>
							<a href="#"><span class="badge badge-xbox-one">Planned</span></a>

							<p>Creation for Developers and Kriekon to create Game Hubs for Games. Essentially you click on the Hub you get all the content related too that Game in the Hub.</p>
							<div class="progress">
								<div class="progress-bar progress-bar-success" role="progressbar" aria-valuenow="5" aria-valuemin="0" aria-valuemax="100" style="width: 0%;"></div>
							</div>
              			</div>
            			</div>
          			</div>
					<div class="widget widget-game">
            			<div class="widget-block" style="background-image: url('https://img.youtube.com/vi/BhTkoDVgF6s/maxresdefault.jpg')">
              			<div class="overlay"></div>
              			<div class="widget-item">
                			<h4>Photo System</h4>
                			<span class="meta">TBD</span>

							<h5>Status</h5>
							<a href="#"><span class="badge badge-xbox-one">Planned</span></a>

							<p>Creation of File Systems that house's Users Images over a CDN.</p>
							<div class="progress">
								<div class="progress-bar progress-bar-success" role="progressbar" aria-valuenow="5" aria-valuemin="0" aria-valuemax="100" style="width: 5%;"></div>
							</div>
              			</div>
            			</div>
          			</div>
				</div>
				<div class="col-md-4">
					<div class="widget widget-game">
            			<div class="widget-block" style="background-image: url('https://img.youtube.com/vi/xUGRjNzGz3o/maxresdefault.jpg')">
              			<div class="overlay"></div>
              			<div class="widget-item">
                			<h4>User Interaction System</h4>
                			<span class="meta">TBD</span>

							<h5>Status</h5>
							<a href="#"><span class="badge badge-xbox-one">Planned</span></a>

							<p>Based on the level of interaction with other users in the community. Levels, points, Tokens, and Reputation are awarded too the User via Content Creation.</p>
							<div class="progress">
								<div class="progress-bar progress-bar-success" role="progressbar" aria-valuenow="40" aria-valuemin="0" aria-valuemax="100" style="width: 0%;"></div>
							</div>
              			</div>
            			</div>
          			</div>
					<div class="widget widget-game">
            			<div class="widget-block" style="background-image: url('https://img.youtube.com/vi/D3pYbbA1kfk/maxresdefault.jpg')">
              			<div class="overlay"></div>
              			<div class="widget-item">
                			<h4>Community/Group System</h4>
                			<span class="meta">TBD</span>

							<h5>Status</h5>
							<a href="#"><span class="badge badge-xbox-one">Planned</span></a>
							
							<p>Backbone of Communities System that will allow Users to create their own Communities inside the Kriekon Domain.</p>
							<div class="progress">
								<div class="progress-bar progress-bar-success" role="progressbar" aria-valuenow="10" aria-valuemin="0" aria-valuemax="100" style="width: 10%;"></div>
							</div>
              			</div>
            			</div>
          			</div>
					<div class="widget widget-game">
            			<div class="widget-block" style="background-image: url('https://img.youtube.com/vi/kUKrStkG-hE/maxresdefault.jpg')">
              			<div class="overlay"></div>
              			<div class="widget-item">
                			<h4>Stream System</h4>
                			<span class="meta">TBD</span>

							<h5>Status</h5>
							<a href="#"><span class="badge badge-xbox-one">Planned</span></a>

							<p>Creation of File Systems that house's Users Streams over a CDN. As well as Integration with the Twitch API</p>
							<div class="progress">
								<div class="progress-bar progress-bar-success" role="progressbar" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100" style="width: 0%;"></div>
							</div>
              			</div>
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
  <script src="<?= $plugins . '/countdown/jquery.countdown.min.js'; ?>"></script>
  
  <!-- plugins ytplayer js -->
  <script src="<?= $plugins . '/ytplayer/jquery.mb.YTPlayer.min.js'; ?>"></script>

  <!-- theme js -->
  <script src="<?= $js . '/theme.min.js'; ?>"></script>
  
	<!-- Initialization js -->
	<script src="<?= $js . '/init/coming_soon.js'; ?>"></script>
</body>
</html>