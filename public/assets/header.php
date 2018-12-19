
<header id="header">
    <div class="container">
      <div class="navbar-backdrop">
        <div class="navbar">
          <div class="navbar-left">
            <a class="navbar-toggle"><i class="fa fa-bars"></i></a>
            <a href="<?= $https; ?>" class="logo"><img style="height:28px; width:110px;" src="<?= $images . '/logo.png'; ?>" alt="Kriekon - Gaming Community"></a>
			<?php
				  if(isset($_SESSION['user'])):
					$user = $this->model('User');
					$user = unserialize($_SESSION[Config::get('session/user_session')]);
			
					if(!empty($user->getTags())):
				  	if(in_array("Admin", $user->getTags())):
					?>
            <nav class="nav">
              <ul>
				<li class="has-dropdown mega-menu mega-games">
                  <a href="<?= $https . '/news'; ?>">News</a>
                  <ul>
                    <li>
                      <div class="container">
                        <div class="row">
                          <div class="col">
                            <div class="img">
                              <a href="game-post.html"><img src="<?= $images . '/menu/menu-1.jpg'; ?>" alt="Last of Us: Part 2"></a>
                              <span class="badge badge-ps4">PS4</span>
                            </div>
                            <h4><a href="game-post.html">Grand Theft Auto V</a></h4>
                            <span>Jun 29, 2019</span>
                          </div>
                          <div class="col">
                            <div class="img">
                              <a href="game-post.html"><img src="<?= $images . '/menu/menu-2.jpg'; ?>" alt="Injustice 2"></a>
                              <span class="badge badge-steam">Steam</span>
                            </div>
                            <h4><a href="game-post.html">Injustice 2</a></h4>
                            <span>June 10, 2017</span>
                          </div>
                          <div class="col">
                            <div class="img">
                              <a href="game-post.html"><img src="<?= $images . '/menu/menu-3.jpg'; ?>" alt="Bioshock: Infinite"></a>
                              <span class="badge badge-xbox-one">Xbox One</span>
                            </div>
                            <h4><a href="game-post.html">Bioshock: Infinite</a></h4>
                            <span>May 16, 2017</span>
                          </div>
                          <div class="col">
                            <div class="img">
                              <a href="game-post.html"><img src="<?= $images . '/menu/menu-4.jpg'; ?>" alt="Batman: Arkham Knight"></a>
                              <span class="badge badge-ps4">PS4</span>
                            </div>
                            <h4><a href="game-post.html">Batman: Arkham Knight</a></h4>
                            <span>May 10, 2017</span>
                          </div>
                          <div class="col">
                            <div class="img">
                              <a href="game-post.html"><img src="<?= $images . '/menu/menu-5.jpg'; ?>" alt="Bioshock: Infinite"></a>
                              <span class="badge badge-pc">PC</span>
                            </div>
                            <h4><a href="game-post.html">Hitman Absolution</a></h4>
                            <span>May 10, 2017</span>
                          </div>
                        </div>
                      </div>
                    </li>
                  </ul>
                </li>
                <li class="has-dropdown mega-menu mega-games">
                  <a href="<?= $https . '/games'; ?>">Games</a>
                  <ul>
                    <li>
                      <div class="container">
                        <div class="row">
                          <div class="col">
                            <div class="img">
                              <a href="game-post.html"><img src="<?= $images . '/menu/menu-1.jpg'; ?>" alt="Last of Us: Part 2"></a>
                              <span class="badge badge-ps4">PS4</span>
                            </div>
                            <h4><a href="game-post.html">Grand Theft Auto V</a></h4>
                            <span>Jun 29, 2019</span>
                          </div>
                          <div class="col">
                            <div class="img">
                              <a href="game-post.html"><img src="<?= $images . '/menu/menu-2.jpg'; ?>" alt="Injustice 2"></a>
                              <span class="badge badge-steam">Steam</span>
                            </div>
                            <h4><a href="game-post.html">Injustice 2</a></h4>
                            <span>June 10, 2017</span>
                          </div>
                          <div class="col">
                            <div class="img">
                              <a href="game-post.html"><img src="<?= $images . '/menu/menu-3.jpg'; ?>" alt="Bioshock: Infinite"></a>
                              <span class="badge badge-xbox-one">Xbox One</span>
                            </div>
                            <h4><a href="game-post.html">Bioshock: Infinite</a></h4>
                            <span>May 16, 2017</span>
                          </div>
                          <div class="col">
                            <div class="img">
                              <a href="game-post.html"><img src="<?= $images . '/menu/menu-4.jpg'; ?>" alt="Batman: Arkham Knight"></a>
                              <span class="badge badge-ps4">PS4</span>
                            </div>
                            <h4><a href="game-post.html">Batman: Arkham Knight</a></h4>
                            <span>May 10, 2017</span>
                          </div>
                          <div class="col">
                            <div class="img">
                              <a href="game-post.html"><img src="<?= $images . '/menu/menu-5.jpg'; ?>" alt="Bioshock: Infinite"></a>
                              <span class="badge badge-pc">PC</span>
                            </div>
                            <h4><a href="game-post.html">Hitman Absolution</a></h4>
                            <span>May 10, 2017</span>
                          </div>
                        </div>
                      </div>
                    </li>
                  </ul>
                </li>
                <li><a href="<?= $https . '/article'; ?>">Blogs</a></li>
				<li><a href="<?= $https . '/forum'; ?>">Forum</a></li>
                <li><a href="<?= $https . '/video'; ?>">Videos</a></li>
				<li><a href="<?= $https . '/stream'; ?>">Streamers</a></li>
              </ul>
            </nav>
			  <?php
				  endif;
				  endif;
				  endif; ?>
          </div>
			<?php if(isset($_SESSION['user'])): ?>
			<div class="nav navbar-right">
            <ul>
              <li class="dropdown dropdown-profile">
                <a href="#" data-toggle="dropdown"><img src="<?= $images . '/user/avatar-sm.jpg'; ?>" alt=""> <span><?= ucfirst($data[0]['user_view']['user_username']); ?></span></a>
                <div class="dropdown-menu dropdown-menu-right">
                  <a class="dropdown-item active" href="<?= $https . '/user/p/' . strtolower($data[0]['user_view']['user_username']); ?>"><i class="fa fa-user"></i> Profile</a>
                  <a class="dropdown-item" href="#"><i class="fa fa-envelope-open"></i> Inbox</a>
                  <a class="dropdown-item" href="#"><i class="fa fa-heart"></i> Games</a>
                  <a class="dropdown-item" href="#"><i class="fa fa-cog"></i> Settings</a>
                  <div class="dropdown-divider"></div>
                  <a class="dropdown-item" href="<?= $https . '/user/logout'; ?>"><i class="fa fa-sign-out"></i> Logout</a>
                </div>
              </li>
              <li class="dropdown dropdown-notification">
                <a href="register.html" data-toggle="dropdown">
                <i class="fa fa-bell"></i>
                <span class="badge badge-danger">2</span>
              </a>
                <div class="dropdown-menu dropdown-menu-right">
                  <h5 class="dropdown-header"><i class="fa fa-bell"></i> Notifications</h5>
                  <div class="dropdown-block">
                    <a class="dropdown-item" href="#">
                    <span class="badge badge-info"><i class="fa fa-envelope-open"></i></span> new email
                    <span class="date">just now</span>
                  </a>
                    <a class="dropdown-item" href="#">
                    <span class="badge badge-danger"><i class="fa fa-thumbs-up"></i></span> liked your post
                    <span class="date">5 mins</span>
                  </a>
                    <a class="dropdown-item" href="#">
                    <span class="badge badge-primary"><i class="fa fa-user-plus"></i></span> friend request
                    <span class="date">2 hours</span>
                  </a>
                    <a class="dropdown-item" href="#">
                    <span class="badge badge-info"><i class="fa fa-envelope"></i></span> new email
                    <span class="date">3 days</span>
                  </a>
                    <a class="dropdown-item" href="#">
                    <span class="badge badge-info"><i class="fa fa-video-camera"></i></span> sent a video
                    <span class="date">5 days</span>
                  </a>
                    <a class="dropdown-item" href="#">
                    <span class="badge badge-danger"><i class="fa fa-thumbs-up"></i></span> liked your post
                    <span class="date">8 days</span>
                  </a>
                  </div>
                </div>
              </li>
              <li><a data-toggle="search"><i class="fa fa-search"></i></a></li>
            </ul>

          </div>
			<?php else: ?>
          <div class="nav navbar-right">
            <ul>
              <li class="hidden-xs-down"><a href="<?= $https . '/user/login'; ?>">Login</a></li>
              <li class="hidden-xs-down"><a href="<?= $https . '/user/register'; ?>">Register</a></li>
              <li><a data-toggle="search"><i class="fa fa-search"></i></a></li>
            </ul>
          </div>
			<?php endif; ?>
        </div>
      </div>
      <div class="navbar-search">
        <div class="container">
          <form method="post">
            <input type="text" class="form-control" placeholder="Search...">
            <i class="fa fa-times close"></i>
          </form>
        </div>
      </div>
    </div>
  </header>