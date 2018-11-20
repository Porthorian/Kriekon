<!DOCTYPE html>
<html lang="en">
<!-- Head -->
<head>
<?php require_once (Config::get('site/baseurl') . Config::get('site/assets') . '/head.php'); ?>
<!-- plugins css -->
	<link href="<?= $plugins . '/owl-carousel/css/owl.carousel.min.css'; ?>" rel="stylesheet">
	<link href="<?= $plugins . '/ytplayer/jquery.mb.YTPlayer.min.css'; ?>" rel="stylesheet">
</head>
	
<body class="fixed-header">
  <!-- header -->
  <?php require_once(Config::Get('site/baseurl') . Config::get('site/assets') . '/header.php'); ?>
  <!-- /header -->
	
  <!-- main -->
  <section class="bg-primary promo promo-subscribe">
    <div class="container">
      <h3>Subscribe to my channel and get your own custom badge with emoticons and much more!</h3>
      <a class="btn btn-outline-default" href="" target="_blank" role="button">Subscribe <i class="fa fa-heart-o"></i></a>
    </div>
  </section>

  <section class="bg-image bg-image-sm section-streamer player p-y-65" style="background-image: url('https://img.youtube.com/vi/oqElIW1mjlQ/maxresdefault.jpg');" data-property="{videoURL:'1GWRDuL04-Q',containment:'self',mute:true,stopMovieOnBlur:false, showControls: false, realfullscreen: true, showYTLogo: false, quality: 'hd1080',autoPlay:true,loop:true,opacity:1}">
    <div class="overlay"></div>
    <div class="container">
      <div class="video-play video-live" style="background-image: url('https://img.youtube.com/vi/oqElIW1mjlQ/maxresdefault.jpg');background-size: 100%;" data-src="https://player.twitch.tv/?video=v122839988&autoplay=true">
        <div class="embed-responsive embed-responsive-16by9 player" data-property="{videoURL:'1GWRDuL04-Q',containment:'self',mute:true,showControls: false, stopMovieOnBlur:false,showYTLogo: false, quality: 'hd1080',autoPlay:true,loop:true,opacity:1}">
          <div class="video-caption">
            <h5><i class="fa fa-circle"></i> Live Now: EU LCS Summer 2017 - Week 2 Day 1: Misfits vs. Ninjas in Pyjamas</h5>
          </div>
          <div class="video-play-icon">
            <i class="fa fa-play"></i>
          </div>
        </div>
      </div>
      <div class="text-right m-t-20">
        <a href="videos.html" class="btn btn-outline-default btn-rounded btn-lg float-left m-r-30">Donate me <i class="fa fa-heart-o"></i></a>
        <a href="videos.html" class="btn btn-twitch btn-shadow btn-rounded btn-lg m-l-20">Watch on Twitch <i class="fa fa-twitch"></i></a>
      </div>
    </div>
  </section>

  <section class="bg-secondary p-t-15 p-b-5 p-x-15">
    <div class="owl-carousel owl-videos">
      <div class="card card-video">
        <div class="card-img">
          <a href="video-post.html">
          <img src="https://i1.ytimg.com/vi/GaERL8Nrl9k/mqdefault.jpg" alt="Tom Clancy's Ghost Recon: Wildlands">
        </a>
          <div class="card-meta">
            <span>4:32</span>
          </div>
        </div>
        <div class="card-block">
          <h4 class="card-title"><a href="video-post.html">Tom Clancy's Ghost Recon: Wildlands</a></h4>
          <div class="card-meta">
            <span><i class="fa fa-clock-o"></i> 2 hours ago</span>
            <span>423 views</span>
          </div>
        </div>
      </div>

      <div class="card card-video">
        <div class="card-img">
          <a href="video-post.html">
          <img src="https://i1.ytimg.com/vi/mW4LMCtoIkg/mqdefault.jpg" class="card-img-top" alt="Anthem Official Gameplay Reveal">
        </a>
          <div class="card-meta">
            <span>6:46</span>
          </div>
        </div>
        <div class="card-block">
          <h4 class="card-title"><a href="video-post.html">Anthem Official Gameplay Reveal</a></h4>
          <div class="card-meta">
            <span><i class="fa fa-clock-o"></i> 2 weeks ago</span>
            <span>447 views</span>
          </div>
        </div>
      </div>

      <div class="card card-video">
        <div class="card-img">
          <a href="video-post.html">
          <img src="https://i1.ytimg.com/vi/-PohBqV_i7s/mqdefault.jpg" class="card-img-top" alt="Shadow of War Gameplay Walkthrough">
        </a>
          <div class="card-meta">
            <span>9:58</span>
          </div>
        </div>
        <div class="card-block">
          <h4 class="card-title"><a href="video-post.html">Shadow of War Gameplay Walkthrough</a></h4>
          <div class="card-meta">
            <span><i class="fa fa-clock-o"></i> March 10, 2017</span>
            <span>914 views</span>
          </div>
        </div>
      </div>

      <div class="card card-video">
        <div class="card-img">
          <a href="video-post.html">
          <img src="https://i1.ytimg.com/vi/feqIj5PaqCQ/mqdefault.jpg" class="card-img-top" alt="Call of Duty WW2 Multiplayer Gameplay">
        </a>
          <div class="card-meta">
            <span>4:32</span>
          </div>
        </div>
        <div class="card-block">
          <h4 class="card-title"><a href="video-post.html">Call of Duty WW2 Multiplayer Gameplay</a></h4>
          <div class="card-meta">
            <span><i class="fa fa-clock-o"></i> 3 days ago</span>
            <span>423 views</span>
          </div>
        </div>
      </div>

      <div class="card card-video">
        <div class="card-img">
          <a href="video-post.html">
          <img src="https://i.ytimg.com/vi/N1NsF9c90f0/mqdefault.jpg" alt="Final Fantasy VII Remake">
        </a>
          <div class="card-meta">
            <span>3:05</span>
          </div>
        </div>
        <div class="card-block">
          <h4 class="card-title"><a href="video-post.html">Final Fantasy VII Remake</a></h4>
          <div class="card-meta">
            <span><i class="fa fa-clock-o"></i> 2 days ago</span>
            <span>589 views</span>
          </div>
        </div>
      </div>

      <div class="card card-video">
        <div class="card-img">
          <a href="video-post.html">
          <img src="https://i.ytimg.com/vi/lQXpDL3SNWQ/mqdefault.jpg" class="card-img-top" alt="Spider-Man Official 4K Trailer">
        </a>
          <div class="card-meta">
            <span>3:07</span>
          </div>
        </div>
        <div class="card-block">
          <h4 class="card-title"><a href="video-post.html">Spider-Man Official 4K Trailer</a></h4>
          <div class="card-meta">
            <span><i class="fa fa-clock-o"></i> 2 weeks ago</span>
            <span>1798 views</span>
          </div>
        </div>
      </div>

      <div class="card card-video">
        <div class="card-img">
          <a href="video-post.html">
          <img src="https://i1.ytimg.com/vi/9EzRBzdf--g/mqdefault.jpg" alt="METRO EXODUS Gameplay Trailer">
        </a>
          <div class="card-meta">
            <span>1:24</span>
          </div>
        </div>
        <div class="card-block">
          <h4 class="card-title"><a href="video-post.html">Wolfenstein II Gameplay Trailer</a></h4>
          <div class="card-meta">
            <span><i class="fa fa-clock-o"></i> July 16, 2017</span>
            <span>7330 views</span>
          </div>
        </div>
      </div>
    </div>
  </section>

  <section>
    <div class="container">
      <div class="heading">
        <i class="fa fa-twitch"></i>
        <h2>Recent Streams</h2>
        <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.</p>
      </div>
      <div class="row row-5">
        <div class="col-12 col-sm-6 col-md-3">
          <div class="card card-video">
            <div class="card-img">
              <a href="video-post.html">
              <img src="https://i.ytimg.com/vi/GaERL8Nrl9k/mqdefault.jpg" class="card-img-top" alt="Tom Clancy's Ghost Recon: Wildlands Gameplay">
            </a>
              <div class="card-meta">
                <span>3:05</span>
              </div>
            </div>
            <div class="card-block">
              <h4 class="card-title"><a href="video-post.html">Tom Clancy's Ghost Recon: Wildlands</a></h4>
              <div class="card-meta">
                <span><i class="fa fa-clock-o"></i> 2 days ago</span>
                <span>589 views</span>
              </div>
              <p>Defeating the corrupt tyrants entrenched there will require not only strength.</p>
            </div>
          </div>
        </div>
        <div class="col-12 col-sm-6 col-md-3">
          <div class="card card-video">
            <div class="card-img">
              <a href="video-post.html">
              <img src="https://i.ytimg.com/vi/N1NsF9c90f0/mqdefault.jpg" alt="Final Fantasy VII Remake">
            </a>
              <div class="card-meta">
                <span>3:05</span>
              </div>
            </div>
            <div class="card-block">
              <h4 class="card-title"><a href="video-post.html">Final Fantasy VII Remake</a></h4>
              <div class="card-meta">
                <span><i class="fa fa-clock-o"></i> 2 days ago</span>
                <span>589 views</span>
              </div>
              <p>Final Fantasy VII Remake was revealed at E3 2015 and we've gotten very little news.</p>
            </div>
          </div>
        </div>
        <div class="col-12 col-sm-6 col-md-3">
          <div class="card card-video">
            <div class="card-img">
              <a href="video-post.html">
              <img src="https://i1.ytimg.com/vi/mW4LMCtoIkg/mqdefault.jpg" class="card-img-top" alt="Anthem Official Gameplay Reveal">
            </a>
              <div class="card-meta">
                <span>3:07</span>
              </div>
            </div>
            <div class="card-block">
              <h4 class="card-title"><a href="video-post.html">Anthem Official Gameplay Reveal</a></h4>
              <div class="card-meta">
                <span><i class="fa fa-clock-o"></i> 2 weeks ago</span>
                <span>1798 views</span>
              </div>
              <p>In Anthem, a new shared-world action-RPG from EA's BioWare studio.</p>
            </div>
          </div>
        </div>
        <div class="col-12 col-sm-6 col-md-3">
          <div class="card card-video">
            <div class="card-img">
              <a href="video-post.html">
              <img src="https://i.ytimg.com/vi/PgLQ9kzmfT8/mqdefault.jpg" class="card-img-top" alt="Far Cry 5: Full Length Reveal Trailer">
            </a>
              <div class="card-meta">
                <span>15:56</span>
              </div>
            </div>
            <div class="card-block">
              <h4 class="card-title"><a href="video-post.html">Far Cry 5: Full Length Reveal Trailer</a></h4>
              <div class="card-meta">
                <span><i class="fa fa-clock-o"></i> May 26, 2017</span>
                <span>6521 views</span>
              </div>
              <p>Far Cry comes to America in the latest installment of the award-winning franchise..</p>
            </div>
          </div>
        </div>
        <div class="col-12 col-sm-6 col-md-3">
          <div class="card card-video">
            <div class="card-img">
              <a href="video-post.html">
              <img src="https://i.ytimg.com/vi/lQXpDL3SNWQ/mqdefault.jpg" class="card-img-top" alt="Spider-Man Official 4K Trailer">
            </a>
              <div class="card-meta">
                <span>6:46</span>
              </div>
            </div>
            <div class="card-block">
              <h4 class="card-title"><a href="video-post.html">Spider-Man Official 4K Trailer</a></h4>
              <div class="card-meta">
                <span><i class="fa fa-clock-o"></i> April 5, 2017</span>
                <span>447 views</span>
              </div>
              <p>Spider-Man for PS4 was a surprise hit last year, will we see it at...</p>
            </div>
          </div>
        </div>
        <div class="col-12 col-sm-6 col-md-3">
          <div class="card card-video">
            <div class="card-img">
              <a href="video-post.html">
              <img src="https://i1.ytimg.com/vi/QEuEOugOXcc/mqdefault.jpg" class="card-img-top" alt="METRO EXODUS Gameplay Trailer">
            </a>
              <div class="card-meta">
                <span>1:24</span>
              </div>
            </div>
            <div class="card-block">
              <h4 class="card-title"><a href="video-post.html">Metro Exodus: Gameplay Trailer 2017</a></h4>
              <div class="card-meta">
                <span><i class="fa fa-clock-o"></i> April 1, 2017</span>
                <span>7330 views</span>
              </div>
              <p>The latest installment in the post-apocalyptic first-person shooter from...</p>
            </div>
          </div>
        </div>
        <div class="col-12 col-sm-6 col-md-3">
          <div class="card card-video">
            <div class="card-img">
              <a href="video-post.html">
              <img src="https://i1.ytimg.com/vi/ckUrcdnWZ2g/mqdefault.jpg" class="card-img-top" alt="The Last Guardian Pet Cosplay Contest">
            </a>
              <div class="card-meta">
                <span>1:58</span>
              </div>
            </div>
            <div class="card-block">
              <h4 class="card-title"><a href="video-post.html">The Last Guardian Pet Cosplay Contest</a></h4>
              <div class="card-meta">
                <span><i class="fa fa-clock-o"></i> March 28, 2017</span>
                <span>812 views</span>
              </div>
              <p>Take a sneak peek at some new footage for The Last Guardian.</p>
            </div>
          </div>
        </div>
        <div class="col-12 col-sm-6 col-md-3">
          <div class="card card-video">
            <div class="card-img">
              <a href="video-post.html">
              <img src="https://i1.ytimg.com/vi/-PohBqV_i7s/mqdefault.jpg" class="card-img-top" alt="Watch Dogs 2 - Reveal Trailer">
            </a>
              <div class="card-meta">
                <span>4:04</span>
              </div>
            </div>
            <div class="card-block">
              <h4 class="card-title"><a href="video-post.html">Shadow of War Gameplay Walkthrough</a></h4>
              <div class="card-meta">
                <span><i class="fa fa-clock-o"></i> March 15, 2017</span>
                <span>546 views</span>
              </div>
              <p>Join us as we take a look at Shadow of War and discuss...</p>
            </div>
          </div>
        </div>
        <div class="col-12 col-sm-6 col-md-3">
          <div class="card card-video">
            <div class="card-img">
              <a href="video-post.html">
              <img src="https://i1.ytimg.com/vi/1Y_DVbmRNhc/mqdefault.jpg" class="card-img-top" alt="Ghost in the Shell (2017) - Official Trailer">
            </a>
              <div class="card-meta">
                <span>2:12</span>
              </div>
            </div>
            <div class="card-block">
              <h4 class="card-title"><a href="video-post.html">Ghost in the Shell (2017) - Official Trailer</a></h4>
              <div class="card-meta">
                <span>
                <i class="fa fa-clock-o"></i> March 13, 2017</span>
                <span>7879 views</span>
              </div>
              <p>The first teasers for the upcoming live-action adaptation of classic...</p>
            </div>
          </div>
        </div>
        <div class="col-12 col-sm-6 col-md-3">
          <div class="card card-video">
            <div class="card-img">
              <a href="video-post.html">
              <img src="https://i1.ytimg.com/vi/VHDmlMVWIwQ/mqdefault.jpg" class="card-img-top" alt="Battlefield 1: In the Name of the Tsar Trailer">
            </a>
              <div class="card-meta">
                <span>9:58</span>
              </div>
            </div>
            <div class="card-block">
              <h4 class="card-title"><a href="video-post.html">Battlefield 1: In the Name of the Tsar</a></h4>
              <div class="card-meta">
                <span><i class="fa fa-clock-o"></i> March 10, 2017</span>
                <span>914 views</span>
              </div>
              <p>Battlefield 1 heads to the Eastern front in its next huge expansion, which introduces...</p>
            </div>
          </div>
        </div>
        <div class="col-12 col-sm-6 col-md-3">
          <div class="card card-video">
            <div class="card-img">
              <a href="video-post.html">
              <img src="https://i1.ytimg.com/vi/lqUUstkJbrc/mqdefault.jpg" class="card-img-top" alt="Overwatch Animated Short Infiltration">
            </a>
              <div class="card-meta">
                <span>5:40</span>
              </div>
            </div>
            <div class="card-block">
              <h4 class="card-title"><a href="video-post.html">Overwatch Animated Short Infiltration</a></h4>
              <div class="card-meta">
                <span><i class="fa fa-clock-o"></i> March 3, 2017</span>
                <span>1254 views</span>
              </div>
              <p>What do you get when you spend $39.99 on Overwatch loot crates?</p>
            </div>
          </div>
        </div>
        <div class="col-12 col-sm-6 col-md-3">
          <div class="card card-video">
            <div class="card-img">
              <a href="video-post.html">
              <img src="https://i1.ytimg.com/vi/feqIj5PaqCQ/mqdefault.jpg" class="card-img-top" alt="Call of Duty WW2 Multiplayer Gameplay">
            </a>
              <div class="card-meta">
                <span>15:38</span>
              </div>
            </div>
            <div class="card-block">
              <h4 class="card-title"><a href="video-post.html">Call of Duty WW2 Multiplayer Gameplay</a></h4>
              <div class="card-meta">
                <span><i class="fa fa-clock-o"></i> March 1, 2017</span>
                <span>7236 views</span>
              </div>
              <p>We head into some intense battles in this new Call of Duty WW2 gameplay...</p>
            </div>
          </div>
        </div>
      </div>
      <div class="text-center"><a href="videos.html" class="btn btn-primary btn-shadow btn-rounded btn-effect btn-lg m-t-10">Show More</a></div>
    </div>
  </section>

  <section class="bg-image" style="background-image: url('https://img.youtube.com/vi/EmQxsBz27XY/maxresdefault.jpg');">
    <div class="overlay"></div>
    <div class="container">
      <div class="video-play" data-src="https://www.youtube.com/embed/zFUymXnQ5z8?rel=0&amp;amp;autoplay=1&amp;amp;showinfo=0">
        <div class="embed-responsive embed-responsive-16by9">
          <img class="embed-responsive-item" src="https://img.youtube.com/vi/EmQxsBz27XY/maxresdefault.jpg">
          <div class="video-caption">
            <h5>For Honor: Walkthrough Gameplay Warlords</h5>
          </div>
          <div class="video-play-icon">
            <i class="fa fa-play"></i>
          </div>
        </div>
      </div>
    </div>
  </section>

  <section class="bg-secondary p-y-40">
    <div class="container">
      <div class="owl-carousel owl-logos">
        <a href="#"><img src="<?= $images . '/sponsors/sponsor-1.png'; ?>" alt=""></a>
        <a href="#"><img src="<?= $images . '/sponsors/sponsor-2.png'; ?>" alt=""></a>
        <a href="#"><img src="<?= $images . '/sponsors/sponsor-3.png'; ?>" alt=""></a>
        <a href="#"><img src="<?= $images . '/sponsors/sponsor-4.png'; ?>" alt=""></a>
        <a href="#"><img src="<?= $images . '/sponsors/sponsor-5.png'; ?>" alt=""></a>
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
  <script src="<?= $plugins . '/owl-carousel/js/owl.carousel.min.js'; ?>"></script>
  <script src="<?= $js . '/init/stream_home.js'; ?>"></script>

  <!-- theme js -->
  <script src="<?= $js . '/theme.min.js'; ?>"></script>