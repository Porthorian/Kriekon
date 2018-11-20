<!DOCTYPE html>
<html lang="en">
<!-- Head -->
<head>
	<?php require_once (Config::get('site/baseurl') . Config::get('site/assets') . '/head.php'); ?>
</head>
	
<body class="fixed-header">
  <!-- header -->
  <?php require_once(Config::Get('site/baseurl') . Config::get('site/assets') . '/header.php'); ?>
  <!-- /header -->
	
	<!-- main -->
  <section class="breadcrumbs">
	<div class="container">
		<ol class="secondary-nav">
			<li class="active"><a href="<?= $https . '/forum/popular'; ?>">Popular</a><i class="fa fa-question-circle secondary-nav-icon"></i></li>
			<li><a href="<?= $https . '/forum/hot'; ?>">Hot</a><i class="fa fa-question-circle secondary-nav-icon"></i></li>
		</ol>
	</div>
  </section>
  <section class="p-t-40">
    <div class="container">
		<div class="forum-headline forum-panel">
			<h5 class="float-left"><?= ucwords($data['forum_name']); ?></h5>
			<a class="btn btn-primary btn-shadow float-right" href="<?= $https . '/forum/create_thread'; ?>" role="button">New topic <i class="fa fa-plus"></i></a>
		</div>
		<div class="row">
			<div class="col-md-2 forum-sidebar-left">
				<div class="widget">
					<h5 class="widget-title">Feeds</h5>
					<div class="forum-sidebar-content">
						<ul>
							<?php $category = $data['categories']; 
							$count = 0;
							foreach($category as $categories): ?>
							<li><a href="<?= $https . '/forum/c/' . $category[$count]['category_id'] . '/' . $category[$count]['category_url_title']; ?>"><i class="fa fa-comments" style="padding-right: 5px;"></i><?= ucfirst($category[$count]['category_name']); ?></a></li>
							<?php $count++;
							endforeach; ?>
						</ul>
					</div>
				</div>
			</div>
			<div class="col-md-10">
				<?php $thread = $data['threads'];
				$count = 0;
				foreach($thread as $threads): ?>
				<div>
					<div class="forum-content-thread">
						<div class="forum-upvote-downvote-area">
							<div class="forum-upvote-downvote-buttons">
								<button class="forum-upvote-downvote-button" id="upvote_thread_btn-<?= $thread[$count]['thread_id']; ?>" onClick="new ldButton('thread', '#upvote_thread_btn-<?= $thread[$count]['thread_id']; ?>', 'upvote', '#thread_count-<?= $thread[$count]['thread_id']; ?>', <?= $thread[$count]['thread_id'] ?>, <?= $data[0]['user_view']['user_id']; ?>, '<?= '/ajax/upvote_downvote/' . $thread[$count]['thread_id']; ?>')"><i class="fa fa-arrow-up"></i></button>
								<div class="forum-upvote-downvote-count" id="thread_count-<?= $thread[$count]['thread_id']; ?>"><?= $thread[$count]['vote_count']; ?></div>
								<button class="forum-upvote-downvote-button" id="downvote_thread_btn-<?= $thread[$count]['thread_id']; ?>"onClick="new ldButton('thread', '#downvote_thread_btn-<?= $thread[$count]['thread_id']; ?>', 'downvote', '#thread_count-<?= $thread[$count]['thread_id']; ?>', <?= $thread[$count]['thread_id'] ?>, <?= $data[0]['user_view']['user_id']; ?>, '<?= '/ajax/upvote_downvote/' . $thread[$count]['thread_id']; ?>')"><i class="fa fa-arrow-down"></i></button>
							</div>
						</div>
						<div class="forum-content-background" onClick="location.href='<?= $https . '/forum/thread/' . $thread[$count]['thread_id'] . '/' . $thread[$count]['thread_url_title']; ?>';">
							<div class="forum-content-display">
								<div class="forum-content-image-holder">
									<div class="forum-content-image-position">
										<a href="<?= $https . '/forum/thread/' . $thread[$count]['thread_id'] . '/' . $thread[$count]['thread_url_title']; ?>">
											<div class="forum-content-image">
												<i class="forum-content-image-placeholder forum-content-image-placeholder-2 fa fa-comments"></i>
											</div>
										</a>
									</div>
								</div>
								<div class="forum-content">
									<div>
										<span class="forum-content-title"><a href="<?= $https . '/forum/thread/' . $thread[$count]['thread_id'] . '/' . $thread[$count]['thread_url_title']; ?>"><h2><?= $thread[$count]['thread_subject']; ?></h2></a></span>
									</div>
									<div class="forum-content-subtitle">
										<a href="<?= $https . '/forum/c/' . $thread[$count]['category_id'] . '/' . $thread[$count]['category_url_title']; ?>" class="forum-content-subtitle">c/<?= $thread[$count]['category_url_title']; ?></a>
										<span class="forum-content-subtitle">•</span>
										<div class="forum-content-subtitle-postblock">
											<span>Posted By</span> 
											<a href="<?= $https . '/user/p/' . $thread[$count]['thread_author']['user_username']; ?>"><?= ucfirst($thread[$count]['thread_author']['user_username']); ?></a>
											<a href="<?= $https . '/forum/thread/' . $thread[$count]['thread_id'] . '/' . $thread[$count]['thread_url_title']; ?>"><?= $thread[$count]['adjusted_time']; ?></a>
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
				<?php $count++;
				endforeach; ?>
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
  <script src="<?= $js . '/upvote_downvote.js'; ?>"></script>
  <!-- theme js -->
  <script src="<?= $js . '/theme.min.js'; ?>"></script>
  <script src="<?= $js . '/upvote_downvote.js'; ?>"></script>
</body>
</html>
	