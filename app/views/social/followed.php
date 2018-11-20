<!DOCTYPE html>
<html lang="en">
<!-- Head -->
<head>
<?php require_once (Config::get('site/baseurl') . Config::get('site/assets') . '/head.php'); ?>
<!-- plugins css -->
  <link href="<?= $plugins . '/owl-carousel/css/owl.carousel.min.css'; ?>" rel="stylesheet">
</head>
	
<body class="fixed-header">
  <!-- header -->
  <?php require_once(Config::Get('site/baseurl') . Config::get('site/assets') . '/header.php'); ?>
  <!-- /header -->

  <!-- main -->
	<section class="breadcrumbs">
		<div class="container">
			<ol class="secondary-nav">
				<li><a href="<?= $https . '/social/top'; ?>">TOP</a><i class="fa fa-question-circle secondary-nav-icon"></i></li>
				<li class="active"><a href="#">FOLLOWED</a><i class="fa fa-question-circle secondary-nav-icon"></i></li>
				<li><a href="#">FEATURED</a><i class="fa fa-question-circle secondary-nav-icon"></i></li>
				<li><a href="#">COMMUNITIES</a><i class="fa fa-question-circle secondary-nav-icon"></i></li>
			</ol>
		</div>
	</section>
  <section class="p-t-35">
    <div class="container">
      <div class="row">
		<div class="col-lg-3 sidebar-left">
		  <div class="twPc-div">
				<a class="twPc-bg twPc-block"></a>

				<div>
					<a title="<?= $data[0]['user_view']['user_username']; ?>" href="<?= $https . '/user/p/' . strtolower($data[0]['user_view']['user_username']); ?>" class="twPc-avatarLink">
						<img alt="Vinnie Marone" src="https://pbs.twimg.com/profile_images/653321214316818432/r4cMHUbx_bigger.jpg" class="twPc-avatarImg">
					</a>

					<div class="twPc-divUser">
						<div class="twPc-divName">
							<?php if($data[0]['user_view']['user_first'] == null && $data[0]['user_view']['user_last'] == null): ?>
								<a href="<?= $https . '/user/p/' . strtolower($data[0]['user_view']['user_username']); ?>"><?= ucfirst($data[0]['user_view']['user_username']); ?></a>
							</div>
							<?php else: ?>
								<a href="<?= $https . '/user/p/' . strtolower($data[0]['user_view']['user_username']); ?>"><?= ucfirst($data[0]['user_view']['user_first']);?> <?= ucfirst($data[0]['user_view']['user_last']); ?></a>
							</div>
								<span>
									<a href="<?= $https . '/user/p/' . strtolower($data[0]['user_view']['user_username']); ?>">@<span><?= $data[0]['user_view']['user_username']; ?></span></a>
								</span>
							<?php endif; ?>
					</div>

					<div class="twPc-divStats">
						<ul class="twPc-Arrange">
							<li class="twPc-ArrangeSizeFit">
								<a href="https://twitter.com/vmarone35" title="9.840 Tweet">
									<span class="twPc-StatLabel twPc-block">Posts</span>
									<span class="twPc-StatValue">9.840</span>
								</a>
							</li>
							<li class="twPc-ArrangeSizeFit">
								<a href="https://twitter.com/vmarone35/following" title="885 Following">
									<span class="twPc-StatLabel twPc-block">Following</span>
									<span class="twPc-StatValue">885</span>
								</a>
							</li>
							<li class="twPc-ArrangeSizeFit">
								<a href="https://twitter.com/vmarone35/followers" title="1.810 Followers">
									<span class="twPc-StatLabel twPc-block">Followers</span>
									<span class="twPc-StatValue">1.810</span>
								</a>
							</li>
						</ul>
					</div>
				</div>
			</div>
		  <!-- widget tags -->
		  <div class="widget widget-tags">
			<h5 class="widget-title">Popular Tags</h5>
			<div class="post-tags">
			  <a href="#">#playstation 4</a>
			  <a href="#">#remastered</a>
			  <a href="#">#uncharted</a>
			  <a href="#">#game</a>
			  <a href="#">#blood and wine</a>
			  <a href="#">#games</a>
			</div>
		  </div>

		  <!-- Widget Forums -->
		  <div class="widget widget-forums">
			<h5 class="widget-title">Recent Forums</h5>
			<ul>
			  <li>
				<div class="forum-icon">
				  <i class="fa fa-comment-o"></i>
				</div>
				<div class="forum-title">
				  <h5><a href="forum-post.html">What is your favorite game?</a></h5>
				  <span>5 weeks ago</span>
				</div>
			  </li>
			  <li>
				<div class="forum-icon">
				  <i class="fa fa-comment-o"></i>
				</div>
				<div class="forum-title">
				  <h5><a href="forum-post.html">Battlefield 1 multiplayer</a></h5>
				  <span>1 month ago</span>
				</div>
			  </li>
			  <li>
				<div class="forum-icon">
				  <i class="fa fa-bug"></i>
				</div>
				<div class="forum-title">
				  <h5><a href="forum-post.html">Uncharted 4 Bug Reports</a></h5>
				  <span>July 20, 2017</span>
				</div>
			  </li>
			  <li>
				<div class="forum-icon">
				  <i class="fa fa-envelope-open-o"></i>
				</div>
				<div class="forum-title">
				  <h5><a href="forum-post.html">Days Gone is a promising game</a></h5>
				  <span>July 10, 2017</span>
				</div>
			  </li>
			  <li>
				<div class="forum-icon">
				  <i class="fa fa-comment-o"></i>
				</div>
				<div class="forum-title">
				  <h5><a href="forum-post.html">Q: Black Friday Playstation Sale</a></h5>
				  <span>July 09, 2017</span>
				</div>
			  </li>
			</ul>
		  </div>
        </div>
        <div class="col-lg-6">
          <div class="toolbar-custom">
            <a class="btn btn-default btn-icon m-r-10 float-left hidden-xs-down" href="#" data-toggle="tooltip" title="refresh" data-placement="bottom" role="button"><i class="fa fa-refresh"></i></a>
            <div class="dropdown float-left">
              <button class="btn btn-default" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">All Platform <i class="fa fa-caret-down"></i></button>
              <div class="dropdown-menu">
                <a class="dropdown-item active" href="#">All platform</a>
                <a class="dropdown-item" href="#">Playstation 4</a>
                <a class="dropdown-item" href="#">Xbox One</a>
                <a class="dropdown-item" href="#">Origin</a>
                <a class="dropdown-item" href="#">Steam</a>
              </div>
            </div>

            <a class="btn btn-default btn-icon m-l-10 float-right hidden-xs-down" href="#" data-toggle="tooltip" title="list" data-placement="bottom" role="button"><i class="fa fa-bars"></i></a>
            <div class="dropdown float-right">
              <button class="btn btn-default" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">Date Added <i class="fa fa-caret-down"></i></button>
              <div class="dropdown-menu dropdown-menu-right">
                <a class="dropdown-item active" href="#">Date Added</a>
                <a class="dropdown-item" href="#">Popular</a>
                <a class="dropdown-item" href="#">Newest</a>
                <a class="dropdown-item" href="#">Oldest</a>
              </div>
            </div>
          </div>
			<div class="post post-card post-profile">
				<div class="post-header">
				  <div>
					<a href="profile.html">
					<img src="<?= $images . '/user/avatar-sm.jpg'; ?>" alt="">
				  </a>
				  </div>
				  <div>
					<h2 class="post-title">
					  <a href="profile.html">Nathan Drake</a>
					</h2>
					<div class="post-meta">
					  <span><i class="fa fa-clock-o"></i> June 16, 2017</span>
					  <span><a href="#"><i class="fa fa-comment-o"></i> 98 comments</a></span>
					  <span><a href="#"><i class="fa fa-heart-o"></i> 523 likes</a></span>
					</div>
					<div class="dropdown float-right">
					  <a href="#" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><i class="fa fa-chevron-down"></i></a>
					  <div class="dropdown-menu dropdown-menu-right">
						<a class="dropdown-item" href="#">Moderate</a>
						<a class="dropdown-item" href="#">Embed</a>
						<a class="dropdown-item" href="#">Report</a>
						<a class="dropdown-item" href="#">Mark as spam</a>
					  </div>
					</div>
				  </div>
				</div>
				<p>Injustice 2 is getting a brand new character, and EA reveal the games that they’ll be talking about in their E3 Press Conference! Power up and build the ultimate version of your favorite DC legends in Injustice 2.</p>
				<div class="post-thumbnail">
				  <img src="<?= $images . '/profile/profile-1.jpg'; ?>" alt="">
				</div>
				<div class="post-footer">
				  <a href="#"><i class="fa fa-reply"></i> 34 shares</a>
				  <a href="#"><i class="fa fa-comment-o"></i> 98 comments</a>
				  <a href="#"><i class="fa fa-heart-o"></i> 523 likes</a>
				</div>
			</div>
          <!-- post -->
          <div class="post">
            <h2 class="post-title"><a href="blog-post.html">Uncharted The Lost Legacy First Gameplay Details Revealed</a></h2>
            <div class="post-meta">
              <span><i class="fa fa-clock-o"></i> June 16, 2017 by <a href="profile.html">Constantine</a></span>
              <span><a href="blog-post.html#comments"><i class="fa fa-comment-o"></i> 98 comments</a></span>
            </div>
            <div class="post-thumbnail">
              <img src="<?= $images . '/blog/blog-1.jpg'; ?>" alt="Uncharted The Lost Legacy First Gameplay Details Revealed">
              <span class="badge badge-ps4">PS4</span>
            </div>
            <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Maecenas elit ante, congue sodales orci ac, ultrices pretium lectus. Maecenas lorem enim, dignissim sed lacus non, feugiat iaculis lorem. Integer eu aliquet diam. Suspendisse fringilla
              porta justo, vel tempus risus. Ut et enim sit amet libero fermentum aliquam et ut sem.</p>
          </div>

          <!-- post -->
          <div class="post">
            <h2 class="post-title"><a href="blog-post-carousel.html">The Last of Us 2 Was Teased in September and Nobody Noticed</a></h2>
            <div class="post-meta">
              <span><i class="fa fa-clock-o"></i> May 30, 2017 by <a href="profile.html">YAKUZI</a></span>
              <span><a href="blog-post-carousel.html#comments"><i class="fa fa-comment-o"></i> 6 comments</a></span>
            </div>
            <div class="post-thumbnail">
              <div id="carousel" class="carousel slide" data-ride="carousel">
                <ol class="carousel-indicators">
                  <li data-target="#carousel" data-slide-to="0" class="active"></li>
                  <li data-target="#carousel" data-slide-to="1"></li>
                </ol>
                <div class="carousel-inner" role="listbox">
                  <div class="carousel-item active"><img src="<?= $images . '/blog/blog-2.jpg'; ?>"></div>
                  <div class="carousel-item"><img src="<?= $images . '/blog/blog-3.jpg'; ?>"></div>
                </div>
                <a class="carousel-control-prev" href="#carousel" role="button" data-slide="prev">
                <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                <span class="sr-only">Previous</span>
              </a>
                <a class="carousel-control-next" href="#carousel" role="button" data-slide="next">
                <span class="carousel-control-next-icon" aria-hidden="true"></span>
                <span class="sr-only">Next</span>
              </a>
              </div>
              <span class="badge badge-ps4">PS4</span>
            </div>
            <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Maecenas elit ante, congue sodales orci ac, ultrices pretium lectus. Maecenas lorem enim, dignissim sed lacus non, feugiat iaculis lorem. Integer eu aliquet diam. Suspendisse fringilla
              porta justo, vel tempus risus. Ut et enim sit amet libero fermentum aliquam et ut sem.</p>
          </div>

          <!-- post -->
          <div class="post">
            <h2 class="post-title"><a href="blog-post-video.html">Dead Island 2 Official E3 Announce Gameplay Trailer</a></h2>
            <div class="post-meta">
              <span><i class="fa fa-clock-o"></i> May 22, 2017 by <a href="profile.html">Lobo</a></span>
              <span><a href="blog-post-video.html#comments"><i class="fa fa-comment-o"></i> 33 comments</a></span>
            </div>
            <div class="post-thumbnail">
              <div class="video-play" data-src="https://www.youtube.com/embed/ST262ZbNcos?rel=0&amp;amp;autoplay=1&amp;amp;showinfo=0">
                <div class="embed-responsive embed-responsive-16by9">
                  <img class="embed-responsive-item" src="https://img.youtube.com/vi/tklQ47Hpfxw/maxresdefault.jpg">
                  <div class="video-play-icon"><i class="fa fa-play"></i></div>
                </div>
              </div>
              <span class="badge badge-steam">Steam</span>
            </div>
            <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Maecenas elit ante, congue sodales orci ac, ultrices pretium lectus. Maecenas lorem enim, dignissim sed lacus non, feugiat iaculis lorem. Integer eu aliquet diam. Suspendisse fringilla
              porta justo, vel tempus risus. Ut et enim sit amet libero fermentum aliquam et ut sem.</p>
          </div>

          <!-- post -->
          <div class="post">
            <h2 class="post-title"><a href="blog-post-disqus.html">The Witcher 3: Don't Miss This Hidden Contract in Blood and Wine</a></h2>
            <div class="post-meta">
              <span><i class="fa fa-clock-o"></i> June 16, 2017 by <a href="profile.html">Venom</a></span>
              <span><a href="blog-post-disqus.html#comments"><i class="fa fa-comment-o"></i> 9 comments</a></span>
            </div>
            <div class="post-thumbnail">
              <img src="<?= $images . '/blog/blog-4.jpg'; ?>" alt="The Witcher 3: Don't Miss This Hidden Contract in Blood and Wine">
              <span class="badge badge-xbox-one">Xbox One</span>
            </div>
            <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Maecenas elit ante, congue sodales orci ac, ultrices pretium lectus. Maecenas lorem enim, dignissim sed lacus non, feugiat iaculis lorem. Integer eu aliquet diam. Suspendisse fringilla
              porta justo, vel tempus risus. Ut et enim sit amet libero fermentum aliquam et ut sem.</p>
          </div>

          <div class="pagination-results">
            <span>Showing 10 to 20 of 48 results</span>
            <nav aria-label="Page navigation">
              <ul class="pagination">
                <li class="page-item disabled"><a class="page-link" href="#" aria-label="Previous"><span aria-hidden="true"><i class="fa fa-angle-left"></i></span></a></li>
                <li class="page-item active"><a class="page-link" href="#">1</a></li>
                <li class="page-item"><a class="page-link" href="#">2</a></li>
                <li class="page-item"><a class="page-link" href="#">3</a></li>
                <li class="page-item"><a class="page-link" href="#">4</a></li>
                <li class="page-item"><a class="page-link" href="#">5</a></li>
                <li class="separate"><span>...</span></li>
                <li class="page-item"><a class="page-link" href="#">25</a></li>
                <li class="page-item"><a class="page-link" href="#" aria-label="Next"><span aria-hidden="true"><i class="fa fa-angle-right"></i></span></a></li>
              </ul>
            </nav>
          </div>
          <!-- /.post -->
        </div>

        <!-- sidebar -->
        <div class="col-lg-3">
          <div class="sidebar">
            <!-- widget-games -->
            <div class="widget widget-games">
              <h5 class="widget-title">Upcoming Games</h5>
              <a href="#" style="background-image: url('https://i1.ytimg.com/vi/mW4LMCtoIkg/mqdefault.jpg')">
              <span class="overlay"></span>
              <div class="widget-block">
                <div class="count">1</div>
                <div class="description">
                  <h5 class="title">Horizon: Zero Dawn The Frozen Wilds</h5>
                  <span class="date">November 14, 2017</span>
                </div>
              </div>
            </a>
              <a href="#" style="background-image: url('https://i1.ytimg.com/vi/GaERL8Nrl9k/mqdefault.jpg')">
              <span class="overlay"></span>
              <div class="widget-block">
                <div class="count">2</div>
                <div class="description">
                  <h5 class="title">Tom Clancy's Ghost Recon: Wildlands</h5>
                  <span class="date">August 29, 2017</span>
                </div>
              </div>
            </a>
              <a href="#" style="background-image: url('https://i1.ytimg.com/vi/feqIj5PaqCQ/mqdefault.jpg')">
              <span class="overlay"></span>
              <div class="widget-block">
                <div class="count">3</div>
                <div class="description">
                  <h5 class="title">Call of Duty WW2</h5>
                  <span class="date">December 15, 2017</span>
                </div>
              </div>
            </a>
              <a href="#" style="background-image: url('https://i.ytimg.com/vi/N1NsF9c90f0/mqdefault.jpg')">
              <span class="overlay"></span>
              <div class="widget-block">
                <div class="count">4</div>
                <div class="description">
                  <h5 class="title">Final Fantasy VII</h5>
                  <span class="date">Q3 2018</span>
                </div>
              </div>
            </a>
              <a href="#" style="background-image: url('https://i1.ytimg.com/vi/xUGRjNzGz3o/mqdefault.jpg')">
              <span class="overlay"></span>
              <div class="widget-block">
                <div class="count">5</div>
                <div class="description">
                  <h5 class="title">Mass Effect Andromeda</h5>
                  <span class="date">Q1, 2018</span>
                </div>
              </div>
            </a>
            </div>

            <!-- widget post  -->
            <div class="widget widget-post">
              <h5 class="widget-title">Recommends</h5>
              <a href="blog-post.html"><img src="https://i1.ytimg.com/vi/4BLkEJu9szM/mqdefault.jpg" alt=""></a>
              <h4><a href="blog-post.html">Titanfall 2's Trophies Only Have 3 Multiplayer</a></h4>
              <span><i class="fa fa-clock-o"></i> June 12, 2017</span>
              <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Integer vel neque sed ante facilisis efficitur.</p>
            </div>

            <!-- widget facebook -->
            <!--<div class="widget">
              <h5 class="widget-title">Follow Us on Facebook</h5>
              <div id="fb-root"></div>
              <script async="" src="https://www.google-analytics.com/analytics.js"></script>
              <script id="facebook-jssdk" src="//connect.facebook.net/en_US/sdk.js#xfbml=1&amp;version=v2.8"></script>
              <script>
                (function(d, s, id) {
                  var js, fjs = d.getElementsByTagName(s)[0];
                  if (d.getElementById(id)) return;
                  js = d.createElement(s);
                  js.id = id;
                  js.src = "//connect.facebook.net/en_US/sdk.js#xfbml=1&version=v2.9";
                  fjs.parentNode.insertBefore(js, fjs);
                }(document, 'script', 'facebook-jssdk'));
              </script>
              <div class="fb-page" data-href="https://www.facebook.com/OfficialKriekon" data-small-header="false" data-adapt-container-width="true" data-hide-cover="false" data-show-facepile="true"></div>
            </div>-->

            <!-- widget post -->
            <div class="widget widget-post">
              <h5 class="widget-title">Popular on Kriekon</h5>
              <a href="blog-post.html"><img src="<?= $images . '/blog/blog-widget-popular-1.jpg'; ?>" alt=""></a>
              <h4><a href="blog-post.html">Red Dead Redemption Being Modded Into GTA5 Multiplayer</a></h4>
              <span><i class="fa fa-clock-o"></i> June 16, 2017</span>
              <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Integer vel neque sed anter.</p>
              <ul class="widget-list">
                <li>
                  <div class="widget-img"><a href="blog-post.html"><img src="<?= $images . '/blog/blog-widget-1.jpg'; ?>" alt=""></a></div>
                  <div>
                    <h4><a href="blog-post.html">Dead Island 2 and Escape Impressions</a></h4>
                    <span>June 16, 2017</span>
                  </div>
                </li>
                <li>
                  <div class="widget-img"><a href="blog-post.html"><img src="<?= $images . '/blog/blog-widget-2.jpg'; ?>" alt=""></a></div>
                  <div>
                    <h4><a href="blog-post.html">How to Finish Mafia 3 With All of Your Underbosses</a></h4>
                    <span>May 30, 2017</span>
                  </div>
                </li>
                <li>
                  <div class="widget-img"><a href="blog-post.html"><img src="<?= $images . '/blog/blog-widget-3.jpg'; ?>" alt=""></a></div>
                  <div>
                    <h4><a href="blog-post.html">Spider-Man Spin-Off, Venom, Gets Release Date</a></h4>
                    <span>June 10, 2017</span>
                  </div>
                </li>
                <li>
                  <div class="widget-img"><a href="blog-post.html"><img src="<?= $images . '/blog/blog-widget-4.jpg'; ?>" alt=""></a></div>
                  <div>
                    <h4><a href="blog-post.html">Is Ghost Recon: Wildlands Worth Your Time?</a></h4>
                    <span>June 16, 2017</span>
                  </div>
                </li>
              </ul>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>

  <section class="bg-secondary">
    <div class="container">
      <div class="video-play" data-src="https://www.youtube.com/embed/d1uvFsiz8X0?rel=0&amp;amp;autoplay=1&amp;amp;showinfo=0">
        <div class="embed-responsive embed-responsive-16by9">
          <img class="embed-responsive-item" src="https://img.youtube.com/vi/5fIAPcVdZO8/maxresdefault.jpg">
          <div class="video-caption">
            <h5>ARK: Survival Evolved Official Launch Trailer!</h5>
            <span class="length">5:32</span>
          </div>
          <div class="video-play-icon">
            <i class="fa fa-play"></i>
          </div>
        </div>
      </div>
    </div>
  </section>

  <section class="p-t-35 p-b-10">
    <div class="container">
      <h6 class="subtitle">Recommended Posts</h6>
      <div class="row">
        <div class="col-12 col-md-3">
          <div class="card card-widget">
            <div class="card-img">
              <a href="blog-post-carousel.html"><img src="<?= $images . '/blog/blog-related-1.jpg'; ?>" alt="Injustice 2 Story Mode Superman Ending"></a>
            </div>
            <div class="card-block">
              <h4 class="card-title"><a href="blog-post-carousel.html">Injustice 2 Story Mode Clark Ending Scene</a></h4>
              <div class="card-meta"><span><i class="fa fa-clock-o"></i> July 21, 2017</span></div>
              <p>Injustice 2's Story Mode features hours of cinematic cutscenes.</p>
            </div>
          </div>
        </div>
        <div class="col-12 col-md-3">
          <div class="card card-widget">
            <div class="card-img">
              <a href="blog-post-video.html"><img src="<?= $images . '/blog/blog-related-2.jpg'; ?>" alt="New Injustice 2 Video Explains The Gear System"></a>
            </div>
            <div class="card-block">
              <h4 class="card-title"><a href="blog-post-video.html">New Injustice 2 Video Explains The Gear System</a></h4>
              <div class="card-meta"><span><i class="fa fa-clock-o"></i> June 19, 2017</span></div>
              <p>Following the new trailer dedicated to The Flash.</p>
            </div>
          </div>
        </div>
        <div class="col-12 col-md-3">
          <div class="card card-widget">
            <div class="card-img">
              <a href="blog-post-disqus.html"><img src="<?= $images . '/blog/blog-related-3.jpg'; ?>" alt="An Extra Week Of Double Rewards In GTA V"></a>
            </div>
            <div class="card-block">
              <h4 class="card-title"><a href="blog-post-disqus.html">An Extra Week Of Double Rewards In GTA V</a></h4>
              <div class="card-meta"><span><i class="fa fa-clock-o"></i> June 18, 2017</span></div>
              <p>Grand Theft Auto V players are getting an extra week to earn.</p>
            </div>
          </div>
        </div>
        <div class="col">
          <div class="card card-widget">
            <div class="card-img">
              <a href="blog-post-hero.html"><img src="<?= $images . '/blog/blog-related-4.jpg'; ?>" alt="BioShock: The Collection PC System Requirements Revealed"></a>
            </div>
            <div class="card-block">
              <h4 class="card-title"><a href="blog-post-hero.html">BioShock: The Collection PC System Requirements Revealed</a></h4>
              <div class="card-meta"><span><i class="fa fa-clock-o"></i> June 09, 2017</span></div>
              <p>2K revealed the PC system requirements for BioShock.</p>
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
  <script src="<?= $plugins . '/owl-carousel/js/owl.carousel.min.js'; ?>"></script>
  <script src="<?= $js . '/init/home.js'; ?>"></script>

  <!-- theme js -->
  <script src="<?= $js . '/theme.min.js'; ?>"></script>
</body>
</html>