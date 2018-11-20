<!DOCTYPE html>
<html lang="en">
	<!-- Head -->
	<head>
		<?php require_once (Config::get('site/baseurl') . Config::get('site/assets') . '/head.php'); ?>
		<!-- plugins css -->
		  <link rel="stylesheet" href="<?= $plugins . '/summernote/summernote-bs4.css'; ?>">
		  <link rel="stylesheet" href="<?= $plugins . '/switchery/switchery.min.css'; ?>">
		  <link rel="stylesheet" href="<?= $plugins . '/select2/css/select2.min.css'; ?>">
		  <link rel="stylesheet" href="<?= $plugins . '/flatpickr/flatpickr.min.css'; ?>">
	</head>

<body class="fixed-header">
  <!-- header -->
  <?php require_once(Config::Get('site/baseurl') . Config::get('site/assets') . '/header.php'); ?>
  <!-- /header -->
	
	<!-- main -->
	<section class="breadcrumbs">
		<div class="container">
			<ol class="secondary-nav">
				<li><a href="<?= $https . '/forum/popular'; ?>">Popular</a><i class="fa fa-question-circle secondary-nav-icon"></i></li>
				<li><a href="<?= $https . '/forum'; ?>">Hot</a><i class="fa fa-question-circle secondary-nav-icon"></i></li>
			</ol>
		</div>
	</section>
	
	<section>
		<div class="container">
		  <div class="row">
			<div class="col-lg-8 mx-auto">

			  <!-- Nav tabs -->
			  <ul class="nav nav-tabs" role="tablist">
				<li class="nav-item"><a class="nav-link active" href="#forum" aria-controls="forum" role="tab" data-toggle="tab">Forum</a></li>
				<li class="nav-item"><a class="nav-link" href="#options" aria-controls="options" role="tab" data-toggle="tab">Options</a></li>
			  </ul>

			  <form action="<?= $https . '/forum/create_thread/?action=create'; ?>" class="tab-content p-t-20" method="POST">
				<div class="tab-pane active" id="forum" role="tabpanel">
				  <!-- form -->
				  <div class="form-group">
					<label for="title">Topic Title *</label>
					<input type="text" class="form-control" id="title" name="thread_subject" placeholder="Enter Title (max 50 characters)" required>
				  </div>
				  <div class="form-group">
					<label for="description">Short Description</label>
					<input type="text" class="form-control" id="description" name="thread_description" placeholder="Description">
				  </div>
				  <div class="form-group">
					<label for="category">Category *</label>
					<select id="category" name="thread_category" class="form-control js-example-basic">
						<?php $x = 0;
						$category = $data['categories'];
						foreach($category as $categories): ?>
							<option value="<?= $category[$x]['category_id']; ?>"><?= ucfirst($category[$x]['category_name']); ?></option>
						<?php 
						$x++;
						endforeach; ?>
				  </select>
				  </div>
				  <div class="form-group m-t-25">
					<textarea id="summernote" name="thread_content"></textarea>
				  </div>
				</div>

				<div class="tab-pane" id="options" role="tabpanel">
				  <div class="form-group row">
					<div class="col-6">
					  <label for="date">Publish Date:</label>
					  <input type="text" class="form-control flatpickr flatpickr-input active" id="date" placeholder="Pick a date">
					</div>
				  </div>
				  <div class="form-group">
					<label for="description">Attachment</label>
					<div class="row">
					  <div class="col-8">
						<label class="custom-file">
						<input type="file" id="file2" class="custom-file-input">
						<span class="custom-file-control"></span>
					  </label>
					  </div>
					</div>
				  </div>
				  <div class="form-group">
					<label for="">Enable Replies</label>
					<div><input type="checkbox" class="js-switch" checked></div>
				  </div>
				</div>
				<div class="m-t-30">
					<input type="hidden" value="<?php echo $_SESSION[Config::get('session/token_name')]; ?>" name="thread_token"/>
				  <button class="btn btn-primary btn-rounded btn-shadow float-right" type="submit">Submit</button>
				</div>
			  </form>
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
  <script src="<?= $plugins . '/switchery/switchery.min.js'; ?>"></script>
  <script src="<?= $plugins . '/select2/js/select2.min.js'; ?>"></script>
  <script src="<?= $plugins . '/flatpickr/flatpickr.min.js'; ?>"></script>
  
  <script src="<?= $js . '/init/create_thread.js'; ?>"></script>
  <!-- theme js -->
  <script src="<?= $js . '/theme.min.js'; ?>"></script>
</body>
</html>