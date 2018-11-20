<!DOCTYPE html>
<html lang="en">
<!-- Head -->
<head>
	<?php require_once (Config::get('site/baseurl') . Config::get('site/assets') . '/head.php'); ?>
	<!-- plugins css -->
  	<link rel="stylesheet" href="<?= $plugins . '/summernote/summernote-bs4.css'; ?>">
</head>
	
<body class="fixed-header">
  <!-- header -->
  <?php require_once(Config::Get('site/baseurl') . Config::get('site/assets') . '/header.php'); ?>
  <!-- /header -->
	
	<!-- main -->
  <section class="breadcrumbs">
    <div class="container">
      <ol class="breadcrumb">
        <li><a href="<?= $https . '/forum'; ?>"><?= $data['forum_name']; ?></a></li>
        <li><a href="<?= $https . '/forum/c/' . $data['thread']['category_id'] . '/' . $data['thread']['category_url_title']; ?>"><?= ucfirst($data['thread']['category_name']); ?></a></li>
		<li class="active"><?= ucfirst($data['thread']['thread_subject']); ?></li>
      </ol>
    </div>
  </section>
	
<section class="p-t-40">
    <div class="container">
      <div class="row">
        <div class="col-lg-9 mx-auto">
          <div class="forum-headline forum-panel">
            <h5 class="float-left"><?= ucfirst($data['thread']['thread_subject']); ?> <span><?= ucfirst($data['thread']['thread_description']); ?></span></h5>
            <div class="dropdown float-right">
              <a class="btn btn-secondary" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Settings <i class="fa fa-cog"></i></a>
              <div class="dropdown-menu dropdown-menu-right">
                <a class="dropdown-item" href="forum-create.html">Edit Post</a>
                <a class="dropdown-item" href="#">Mute Post</a>
                <a class="dropdown-item" href="forum-create.html">New Post</a>
                <a class="dropdown-item" href="#">Close Thread</a>
              </div>
            </div>
          </div>
          <div class="forum-post">
            <div class="forum-header">
              <div><a href="<?= $https . '/user/p/' . $data['thread']['thread_author']['user_username']; ?>"><img src="<?= $images . '/user/user-3.jpg'; ?>"></a></div>
              <div>
                <h2 class="forum-title"><a href="<?= $https . '/user/p/' . $data['thread']['thread_author']['user_username']; ?>"><?= ucfirst($data['thread']['thread_author']['user_username']); ?></a></h2>
                <div class="forum-meta">
                  <span><?= $data['thread']['thread_author']['thread_reply_count']; ?> Posts</span>
                  <span><?= $data['thread']['thread_author']['user_tags'][0]; ?></span>
                </div>
              </div>
              <div>
                #1
                <span><?= $data['thread']['thread_date']['month'] . ' ' . $data['thread']['thread_date']['day'] . ', ' . $data['thread']['thread_date']['year']; ?></span>
              </div>
            </div>
            <div class="forum-body">
              <p><?= $data['thread']['thread_content']; ?></p>
<!--              <div class="forum-thumbnail">
                <div class="video-play" data-src="https://www.youtube.com/embed/ST262ZbNcos?rel=0&amp;amp;autoplay=1&amp;amp;showinfo=0">
                  <div class="embed-responsive embed-responsive-16by9">
                    <img class="embed-responsive-item" src="https://img.youtube.com/vi/tklQ47Hpfxw/maxresdefault.jpg">
                    <div class="video-play-icon"><i class="fa fa-play"></i></div>
                  </div>
                </div>
              </div>-->
            </div>
            <div class="forum-footer">
              <div class="forum-panel">
                <!--<div class="forum-attachment">
                  <a href="#" target="_blank">suh.zip<i class="fa fa-download float-right m-t-5"></i></a>
                  <span>(14.4 MB) Downloaded 1839x times</span>
                </div>-->
                <div class="forum-users">
                  <h5>Active users in this thread:</h5>
                  <div>
                    <!--<a href="profile.html" data-toggle="tooltip" title="Venom"><img src="img/user/user-1.jpg" alt="Venom"></a>
                    <a href="profile.html" data-toggle="tooltip" title="Elizabeth"><img src="img/user/user-2.jpg" alt="Elizabeth"></a>
                    <a href="profile.html" data-toggle="tooltip" title="Clark"><img src="img/user/user-3.jpg" alt="Clark"></a>
                    <a href="profile.html" data-toggle="tooltip" title="Strange"><img src="img/user/user-4.jpg" alt="Strange"></a>
                    <a href="profile.html" data-toggle="tooltip" title="Trevor"><img src="img/user/user-5.jpg" alt="Trevor"></a>-->
                  </div>
                </div>
              </div>
              <div class="forum-actions">
                <div>
                  <i class="fa fa-clock-o"></i> <?= $data['thread']['adjusted_time']; ?>
                </div>
                <div class="hidden-xs-down">
				  <button class="forum-upvote-downvote-button" id="upvote_thread_btn-<?= $data['thread']['thread_id']; ?>" onClick="new ldButton('thread', '#upvote_thread_btn-<?= $data['thread']['thread_id']; ?>', 'upvote', '#thread_upvote_count', <?= $data['thread']['thread_id'] ?>, <?= $data[0]['user_view']['user_id']; ?>, '<?= '/ajax/upvote_downvote/' . $data['thread']['thread_id']; ?>')"><i class="fa fa-arrow-up"></i></button>
				  <span id="thread_upvote_count"><?= $data['thread']['thread_upvotes']; ?></span>
			      <button class="forum-upvote-downvote-button" id="downvote_thread_btn-<?= $data['thread']['thread_id']; ?>" onClick="new ldButton('thread', '#downvote_thread_btn-<?= $data['thread']['thread_id']; ?>', 'downvote', '#thread_downvote_count', <?= $data['thread']['thread_id'] ?>, <?= $data[0]['user_view']['user_id']; ?>, '<?= '/ajax/upvote_downvote/' . $data['thread']['thread_id']; ?>')"><i class="fa fa-arrow-down"></i></button>
				  <span id="thread_downvote_count"><?= $data['thread']['thread_downvotes']; ?></span>
                  <a href="#"><i class="fa fa-reply"></i> <?= $data['thread']['reply_count']; ?> replies</a>
                  <a href="#"><i class="fa fa-bar-chart"></i> 1921 views</a>
                </div>
              </div>
            </div>
          </div>
		  <h5 class="m-t-60 m-b-20">Reply to this topic</h5>
          <form action="<?= $https . '/forum/thread/' . $data['thread']['thread_id'] . '/' . $data['thread']['thread_url_title'] . '/?action=create_reply'; ?>" method="POST">
			<textarea class="summernote" name="reply_content"></textarea>
			<input type="hidden" value="<?php echo $_SESSION[Config::get('session/token_name')]; ?>" name="reply_token"/>
			<button class="btn btn-primary btn-shadow float-right" type="submit" name="save">Submit</button>
          </form>
          <div class="clearfix m-t-30 m-b-20">
            <h5 class="m-t-10 m-b-0 float-left"><i class="fa fa-comment-o m-r-5"></i> Replies (<?= $data['thread']['reply_count']; ?>)</h5>
            <div class="dropdown float-right" style="padding-right: 10px;">
              <button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenu1" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">Sorted by latest <span class="caret"></span></button>
              <div class="dropdown-menu dropdown-menu-right">
                <a class="dropdown-item active" href="#">Latest</a>
                <a class="dropdown-item" href="#">Best</a>
                <a class="dropdown-item" href="#">Oldest</a>
                <a class="dropdown-item" href="#">Random</a>
              </div>
            </div>
          </div>
          <ul>
			<?php $reply = $data['replies']; 
			  $x = 0;
			  foreach($reply as $replies): ?>
            <li class="forum-reply">
              <div class="forum-header">
                <div>
                  <a href="<?= $https . '/user/p/' . $reply[$x]['reply_author']['user_username']; ?>"><img src="<?= $images . '/user/user-2.jpg'; ?>" alt=""></a>
                </div>
                <div>
                  <div class="forum-title">
                    <h5><a href="<?= $https . '/user/p/' . $reply[$x]['reply_author']['user_username']; ?>"><?= ucfirst($reply[$x]['reply_author']['user_username']); ?></a></h5>
					<?php if(in_array("Admin", $reply[$x]['reply_author']['user_tags'])): ?>
						<span class="badge badge-outline-primary">Admin</span>
					<?php endif; ?>
                  </div>
                  <div class="forum-meta">
                    <span><?= $reply[$x]['reply_author']['thread_reply_count']; ?> Posts</span>
					<?php if(count($reply[$x]['reply_author']['user_tags']) >= 2): ?>
                    <span><?= $reply[$x]['reply_author']['user_tags'][1]; ?></span>
					<?php else: ?>
					<span><?= $reply[$x]['reply_author']['user_tags'][0]; ?></span>
					<?php endif; ?>
                    <span><a href="#"><i class="fa fa-mail-reply-all"></i> Reply</a></span>
                  </div>
                </div>
                <div>#<?= $x + 2; ?> <span><?= $reply[$x]['reply_date']['month'] . ' ' . $reply[$x]['reply_date']['day'] . ', ' . $reply[$x]['reply_date']['year']; ?></span><span><?= $reply[$x]['adjusted_time']; ?></span></div>
              </div>
              <div class="forum-body">
                <p><?= $reply[$x]['reply_content']; ?></p>
              </div>
            </li>
			  <?php
			  $x++;
			  endforeach; ?>
          </ul>

          <!--<nav aria-label="Page navigation">
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
          </nav>-->
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
  <script src="<?= $plugins . '/summernote/summernote-bs4.js'; ?>"></script>
  <script src="<?= $js . '/init/thread_view.js'; ?>"></script>

  <!-- theme js -->
  <script src="<?= $js . '/theme.min.js'; ?>"></script>
  <script src="<?= $js . '/upvote_downvote.js'; ?>"></script>
</body>
</html>