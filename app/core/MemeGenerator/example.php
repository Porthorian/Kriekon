<?php
# ./tmp/ directory must have web server write access ( chmod 777 ./tmp )
$output_image_path1 = '../../../public/images';
$output_image_path2 = '../../../public/images';
$output_image_path3 = '../../../public/images';
if ( isset( $_POST['generate'] ) ) { 

	include 'MemeGenerator.php';
	
	$mg = new MemeGenerator();

	// OR YOU CAN LOAD WHOLE CONFIG FROM ONE ARRAY
	// possible keys: 
        // * meme_font / meme_output_dir / meme_font_to_image_ratio / meme_margins_to_image_ratio / meme_image_path / meme_top_text / 
        // * meme_bottom_text / meme_font
        // * meme_watermark_file / meme_watermark_margins / meme_watermark_opacity
	// $config['meme_image_path'] = './tmp/philosoraptor.jpg';
	// $config['meme_top_text'] = 'What if I\'m just a meme generating other memes?';
	// $config['meme_bottom_text'] = 'We need to go deeper.. (UTF test: £ zażółćg ęślą jaźń ‹›';
	// $config['meme_font'] = './fonts/DejaVuSansMono-Bold.ttf'; 
	// $config['meme_output_dir'] = './tmp/';
	// $mg->load_config( $config );

	if( ! file_exists($_FILES['myfile']['tmp_name']) || !is_uploaded_file($_FILES['myfile']['tmp_name'] ) ) {
		// Some existing testing file
		$example_image_path = '../../../public/images/newbg.png';
	} else {
		// Uploaded file
		$example_image_path = $_FILES['myfile']['tmp_name'];
	}
	
	// Output example image 1
	$mg->set_top_text( $_POST['top_text'] );
	$mg->set_bottom_text( $_POST['bottom_text'] );
	$mg->set_output_dir( './tmp/' ); // default to ./ if not set
	$mg->set_image( $example_image_path );
	$output_image_path1 = $mg->generate();

	// Output example image 2
	$mg->clear();
	$mg->set_top_text( $_POST['top_text'] );
	$mg->set_bottom_text( $_POST['bottom_text'] );
	$mg->set_output_dir( './tmp/' ); // default to ./ if not set
	$mg->set_image( $example_image_path );
	$mg->set_watermark( './tmp/php.gif' );
	$mg->set_watemark_opacity(80);
	$output_image_path2 = $mg->generate();

	// Output example image 3
	$mg->clear();
	$mg->set_top_text( $_POST['top_text'] );
	$mg->set_bottom_text( $_POST['bottom_text'] );
	$mg->set_output_dir( './tmp/' ); // default to ./ if not set
	$mg->set_image( $example_image_path );
	$mg->set_font('./fonts/UbuntuMono-B.ttf');
	$mg->set_font_ratio( 0.03 );
	$mg->set_margins_ratio( 0.03 );
	$output_image_path3 = $mg->generate();

}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<title>Meme Generator Class usage examples</title>
<meta name="author" content="Libera Solutions Ltd. | Neart Interactive Agency http://neart.eu/" />
<meta name="Expires" content="0" />
<meta http-equiv="Pragma" content="no-cache" />
<meta http-equiv="Cache-Control" content="no-cache" />
<meta name="description" content="Meme Generator Class Example" /> 
<meta http-equiv="Content-type" content="text/html; charset=utf-8" />
</head>
<body>
<h1>Meme Generator Class usage examples</h1>
<h2>Testing ground image:</h2>
<img src="/tmp/philosoraptor.jpg" alt="" width="200" />

<form method="post" action="" enctype="multipart/form-data">
<p>
Top text: 
<input type="text" name="top_text" value="What if I'm just a meme generating other memes?" style="width:400px;" />
</p>
<p>
Bottom text:
<input type="text" name="bottom_text" value="We need to go deeper.." style="width:400px;" />
</p>
<p>
... OR upload Your own (optional) image file:
<input type="file" name="myfile" />
</p>
<p>
<input type="submit" name="generate" style="font-size:2.5em;" value="Generate example meme! &raquo;" />
</p>
</form>

<?php 
if ( isset( $output_image_path1 ) && strlen( $output_image_path1 ) )  {
	echo '<h2>Output image:</h2>';
	echo '<img src="/tmp/' . $output_image_path1. '" alt="" />';
}
if ( isset( $output_image_path2 ) && strlen( $output_image_path2 ) )  {
	echo '<h2>Output - with watermark:</h2>';
	echo '<img src="/tmp/' . $output_image_path2. '" alt="" />';
}
if ( isset( $output_image_path3 ) && strlen( $output_image_path3 ) )  {
	echo '<h2>Output - font &amp; font/margin ratios changed:</h2>';
	echo '<img src="/tmp/' . $output_image_path3. '" alt="" />';
}
?>

<address>
&copy; Libera Solutions Ltd. 2013
</address>
</body>
</html>