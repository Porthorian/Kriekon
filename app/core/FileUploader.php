<?php

class FileUploader // Starting to theorize how we are going to store and upload images in our MVC Framework. Have not been able to find any other instances of someone doing this.
{
	private 
		$post_id,
		$user_id,
		$image_name,
		$avatar_path;
	
	public function getPostID() { return $this->post_id; }
	public function getUserID() { return $this->user_id; }
	public function getImageName() { return $this->image_name; }
	//public function getImageSize() { return $this->image_size; }
	public function getAvatarPath() { return $this->avatar_path; }
	
	public function setPostID($temp_id) { $this->Post_id = $temp_id; }
	public function setUserID($temp_id) { $this->user_id = $temp_id; }
	public function setImageName($temp_image) { $this->image_name = $temp_image; }
	//public function setImageSize($temp_size) { $this->image_size = $temp_size; }
	public function setAvatarPath($temp_image) { $this->avatar_path = $temp_image; }
	
	/**
	 * Default directory persmissions (destination dir)
	 */
	protected $default_permissions = 0750;
	/**
	 * File post array
	 *
	 * @var array
	 */
	protected $files_post = array();
	/**
	 * Destination directory
	 *
	 * @var string
	 */
	protected $destination;
	/**
	 * Fileinfo
	 *
	 * @var object
	 */
	protected $finfo;
	/**
	 * Data about file
	 *
	 * @var array
	 */
	public $file = array();
	/**
	 * Max. file size
	 *
	 * @var int
	 */
	protected $max_file_size;
	/**
	 * Allowed mime types
	 *
	 * @var array
	 */
	protected $mimes = array();
	/**
	 * External callback object
	 *
	 * @var obejct
	 */
	protected $external_callback_object;
	/**
	 * External callback methods
	 *
	 * @var array
	 */
	protected $external_callback_methods = array();
	/**
	 * Temp path
	 *
	 * @var string
	 */
	protected $tmp_name;
	/**
	 * Validation errors
	 *
	 * @var array
	 */
	protected $validation_errors = array();
	/**
	 * Filename (new)
	 *
	 * @var string
	 */
	protected $filename;
	/**
	 * Internal callbacks (filesize check, mime, etc)
	 *
	 * @var array
	 */
	private $callbacks = array();
	/**
	 * Root dir
	 *
	 * @var string
	 */
	protected $root;
	
	public function fetchAvatar($id = null)
	{
		try
		{
			$db = Database::getDBI();

			$sql = 'SELECT file_name FROM avatars WHERE user_id = ? ORDER BY avatar_id DESC LIMIT 1';

			if($id != null)
				$db->query($sql, array($id));
			else
				$db->query($sql, array($this->getUserID()));
			
			$result = $db->single();
			
			if($result != false)
			{
				$this->setUserID($id);
				$this->setImageName($result->file_name);
			}
		}
		catch (Exception $e) { echo $e->getMessage(); }
	}
	
	public function createAvatar()
	{
		try
		{
			$db = database::getDBI(); //Creates DB Instances.
			
			$db->insert('avatars',[
				'user_id'=>$this->getUserID(),
				'file_name'=>$this->getImageName()
				]);
		} 
		catch (Exception $e) { echo $e->getMessage(); } //Grabs error message if any.
	}
	
	/**
	 * Return upload object
	 *
	 * $destination		= 'path/to/your/file/destination/folder';
	 *
	 * @param string $destination
	 * @param string $root
	 * @return Upload
	 */
	public static function factory($destination, $root = false) {
		return new fileuploader($destination, $root);
	}
	/**
	 *  Define ROOT constant and set & create destination path
	 *
	 * @param string $destination
	 * @param string $root
	 */
	public function __construct($destination, $root = false) {
		if ($root) {
			$this->root = $root;
		} else {
			$this->root = $_SERVER['DOCUMENT_ROOT'] . DIRECTORY_SEPARATOR;
		}
		// set & create destination path
		if (!$this->set_destination($destination)) {
			throw new Exception('Upload: Can\'t create destination. '.$this->root . $this->destination);
		}
		//create finfo object
		$this->finfo = new finfo();
	}
	/**
	 * Set target filename
	 *
	 * @param string $filename
	 */
	public function set_filename($filename) {
		$this->filename = $filename;
	}
	/**
	 * Check & Save file
	 *
	 * Return data about current upload
	 *
	 * @return array
	 */
	public function upload($filename = '') {
		$this->set_filename($filename);
		
		if ($this->check()) {
			$this->save();
		}
		// return state data
		return $this->get_state();
	}
	/**
	 * Save file on server
	 *
	 * Return state data
	 *
	 * @return array
	 */
	public function save() {
		$this->save_file();
		return $this->get_state();
	}
	/**
	 * Validate file (execute callbacks)
	 *
	 * Returns TRUE if validation successful
	 *
	 * @return bool
	 */
	public function check() {
		//execute callbacks (check filesize, mime, also external callbacks
		$this->validate();
		//add error messages
		$this->file['errors'] = $this->get_errors();
		//change file validation status
		$this->file['status'] = empty($this->validation_errors);
		return $this->file['status'];
	}
	/**
	 * Get current state data
	 *
	 * @return array
	 */
	public function get_state() {
		return $this->file;
	}
	/**
	 * Save file on server
	 */
	protected function save_file() {
		//create & set new filename
		if(empty($this->filename)){
			$this->create_new_filename();
		}
		//set filename
		$this->setImageName($this->file['filename']	= $this->filename);
		//set full path
		$this->file['full_path'] = $this->root . $this->destination . $this->filename;
        $this->file['path'] = $this->destination . $this->filename;
		$status = move_uploaded_file($this->tmp_name, $this->file['full_path']);
		//checks whether upload successful
		if (!$status) {
			throw new Exception('Upload: Can\'t upload file.');
		}
		//done
		$this->file['status']	= true;
	}
	/**
	 * Set data about file
	 */
	protected function set_file_data() {
		$file_size = $this->get_file_size();
		$this->file = array(
			'status'				=> false,
			'destination'			=> $this->destination,
			'size_in_bytes'			=> $file_size,
			'size_in_mb'			=> $this->bytes_to_mb($file_size),
			'mime'					=> $this->get_file_mime(),
			'original_filename'		=> $this->file_post['name'],
			'tmp_name'				=> $this->file_post['tmp_name'],
			'post_data'				=> $this->file_post,
		);
	}
	/**
	 * Set validation error
	 *
	 * @param string $message
	 */
	public function set_error($message) {
		$this->validation_errors[] = $message;
	}
	/**
	 * Return validation errors
	 *
	 * @return array
	 */
	public function get_errors() {
		return $this->validation_errors;
	}
	/**
	 * Set external callback methods
	 *
	 * @param object $instance_of_callback_object
	 * @param array $callback_methods
	 */
	public function callbacks($instance_of_callback_object, $callback_methods) {
		if (empty($instance_of_callback_object)) {
			throw new Exception('Upload: $instance_of_callback_object can\'t be empty.');
		}
		if (!is_array($callback_methods)) {
			throw new Exception('Upload: $callback_methods data type need to be array.');
		}
		$this->external_callback_object	 = $instance_of_callback_object;
		$this->external_callback_methods = $callback_methods;
	}
	/**
	 * Execute callbacks
	 */
	protected function validate() {
		//get curent errors
		$errors = $this->get_errors();
		if (empty($errors)) {
			//set data about current file
			$this->set_file_data();
			//execute internal callbacks
			$this->execute_callbacks($this->callbacks, $this);
			//execute external callbacks
			$this->execute_callbacks($this->external_callback_methods, $this->external_callback_object);
		}
	}
	/**
	 * Execute callbacks
	 */
	protected function execute_callbacks($callbacks, $object) {
		foreach($callbacks as $method) {
			$object->$method($this);
		}
	}
	/**
	 * File mime type validation callback
	 *
	 * @param obejct $object
	 */
	protected function check_mime_type($object) {
		if (!empty($object->mimes)) {
			if (!in_array($object->file['mime'], $object->mimes)) {
				$object->set_error('Mime type not allowed.');
			}
		}
	}
	/**
	 * Set allowed mime types
	 *
	 * @param array $mimes
	 */
	public function set_allowed_mime_types($mimes) {
		$this->mimes		= $mimes;
		//if mime types is set -> set callback
		$this->callbacks[]	= 'check_mime_type';
	}
	/**
	 * File size validation callback
	 *
	 * @param object $object
	 */
	protected function check_file_size($object) {
		if (!empty($object->max_file_size)) {
			$file_size_in_mb = $this->bytes_to_mb($object->file['size_in_bytes']);
			if ($object->max_file_size <= $file_size_in_mb) {
				$object->set_error('File is too big.');
			}
		}
	}
	/**
	 * Set max. file size
	 *
	 * @param int $size
	 */
	public function set_max_file_size($size) {
		$this->max_file_size	= $size;
		//if max file size is set -> set callback
		$this->callbacks[]	= 'check_file_size';
	}
	/**
	 * Set File array to object
	 *
	 * @param array $file
	 */
	public function file($file) {
		$this->set_file_array($file);
	}
	/**
	 * Set file array
	 *
	 * @param array $file
	 */
	protected function set_file_array($file) {
		//checks whether file array is valid
		if (!$this->check_file_array($file)) {
			//file not selected or some bigger problems (broken files array)
			$this->set_error('Please select file.');
		}
		//set file data
		$this->file_post = $file;
		//set tmp path
		$this->tmp_name  = $file['tmp_name'];
	}
	/**
	 * Checks whether Files post array is valid
	 *
	 * @return bool
	 */
	protected function check_file_array($file) {
		return isset($file['error'])
			&& !empty($file['name'])
			&& !empty($file['type'])
			&& !empty($file['tmp_name'])
			&& !empty($file['size']);
	}
	/**
	 * Get file mime type
	 *
	 * @return string
	 */
	protected function get_file_mime() {
		return $this->finfo->file($this->tmp_name, FILEINFO_MIME_TYPE);
	}
	/**
	 * Get file size
	 *
	 * @return int
	 */
	protected function get_file_size() {
		return filesize($this->tmp_name);
	}
	/**
	 * Set destination path (return TRUE on success)
	 *
	 * @param string $destination
	 * @return bool
	 */
	protected function set_destination($destination) {
		$this->destination = $destination . DIRECTORY_SEPARATOR;
		return $this->destination_exist() ? TRUE : $this->create_destination();
	}
	/**
	 * Checks whether destination folder exists
	 *
	 * @return bool
	 */
	protected function destination_exist() {
		return is_writable($this->root . $this->destination);
	}
	/**
	 * Create path to destination
	 *
	 * @param string $dir
	 * @return bool
	 */
	protected function create_destination() {
		return mkdir($this->root . $this->destination, $this->default_permissions, true);
	}
	/**
	 * Set unique filename
	 *
	 * @return string
	 */
	protected function create_new_filename() {
		$filename = sha1(mt_rand(1, 9999) . $this->destination . uniqid()) . time();
		$this->set_filename($filename);
	}
	/**
	 * Convert bytes to mb.
	 *
	 * @param int $bytes
	 * @return int
	 */
	protected function bytes_to_mb($bytes) {
		return round(($bytes / 1048576), 2);
	}
	
	protected function resize($imagePath,$opts=null) //https://github.com/whizzzkid/phpimageresize
	{
		$imagePath = urldecode($imagePath);

		// start configuration........
		$cacheFolder = 'cache/';							//path to your cache folder, must be writeable by web server
		$remoteFolder = $cacheFolder.'remote/';				//path to the folder you wish to download remote images into

		//setting script defaults
		$defaults['crop']				= false;
		$defaults['scale']				= false;
		$defaults['thumbnail']			= false;
		$defaults['maxOnly']			= false;
		$defaults['canvas-color']		= 'transparent';
		$defaults['output-filename']	= false;
		$defaults['cacheFolder']		= $cacheFolder;
		$defaults['remoteFolder']		= $remoteFolder;
		$defaults['quality'] 			= 80;
		$defaults['cache_http_minutes']	= 1;
		$defaults['compress']			= false;			//will convert to lossy jpeg for conversion...
		$defaults['compression']		= 40;				//[1-99]higher the value, better the compression, more the time, lower the quality (lossy)

		$opts = array_merge($defaults, $opts);
		$path_to_convert = 'convert';						//this could be something like /usr/bin/convert or /opt/local/share/bin/convert
		// configuration ends...

		//processing begins
		$cacheFolder = $opts['cacheFolder'];
		$remoteFolder = $opts['remoteFolder'];
		$purl = parse_url($imagePath);
		$finfo = pathinfo($imagePath);
		$ext = $finfo['extension'];
		// check for remote image..
		if(isset($purl['scheme']) && ($purl['scheme'] == 'http' || $purl['scheme'] == 'https')){
		// grab the image, and cache it so we have something to work with..
			list($filename) = explode('?',$finfo['basename']);
			$local_filepath = $remoteFolder.$filename;
			$download_image = true;
			if(file_exists($local_filepath)){
				if(filemtime($local_filepath) < strtotime('+'.$opts['cache_http_minutes'].' minutes')){
					$download_image = false;
				}
			}
			if($download_image){
				file_put_contents($local_filepath,file_get_contents($imagePath));
			}
			$imagePath = $local_filepath;
		}
		if(!file_exists($imagePath)){
			$imagePath = $_SERVER['DOCUMENT_ROOT'].$imagePath;
			if(!file_exists($imagePath)){
				return 'image not found';
			}
		}
		if(isset($opts['w'])){ $w = $opts['w']; };
		if(isset($opts['h'])){ $h = $opts['h']; };
		$filename = md5_file($imagePath);
		// If the user has requested an explicit output-filename, do not use the cache directory.
		if($opts['output-filename']){
			$newPath = $opts['output-filename'];
		}else{
			if(!empty($w) and !empty($h)){
				$newPath = $cacheFolder.$filename.'_w'.$w.'_h'.$h.($opts['crop'] == true ? "_cp" : "").($opts['scale'] == true ? "_sc" : "");
			}else if(!empty($w)){
				$newPath = $cacheFolder.$filename.'_w'.$w;	
			}else if(!empty($h)){
				$newPath = $cacheFolder.$filename.'_h'.$h;
			}else{
				return false;
			}
			if($opts['compress']){
				if($opts['compression'] == $defaults['compression']){
					$newPath .= '_comp.'.$ext;
				}else{
					$newPath .= '_comp_'.$opts['compression'].'.'.$ext;
				}
			}else{
				$newPath .= '.'.$ext;
			}
		}
		$create = true;
		if(file_exists($newPath)){
			$create = false;
			$origFileTime = date("YmdHis",filemtime($imagePath));
			$newFileTime = date("YmdHis",filemtime($newPath));
			if($newFileTime < $origFileTime){					# Not using $opts['expire-time'] ??
				$create = true;
			}
		}
		if($create){
			if(!empty($w) && !empty($h)){
				list($width,$height) = getimagesize($imagePath);
				$resize = $w;
				if($width > $height){
					$ww = $w;
					$hh = round(($height/$width) * $ww);
					$resize = $w;
					if($opts['crop']){
						$resize = "x".$h;				
					}
				}else{
					$hh = $h;
					$ww = round(($width/$height) * $hh);
					$resize = "x".$h;
					if($opts['crop']){
						$resize = $w;
					}
				}
				if($opts['scale']){
					$cmd = $path_to_convert." ".escapeshellarg($imagePath)." -resize ".escapeshellarg($resize)." -quality ". escapeshellarg($opts['quality'])." " .escapeshellarg($newPath);
				}else if($opts['canvas-color'] == 'transparent' && !$opts['crop'] && !$opts['scale']){
					$cmd = $path_to_convert." ".escapeshellarg($imagePath)." -resize ".escapeshellarg($resize)." -size ".escapeshellarg($ww ."x". $hh)." xc:". escapeshellarg($opts['canvas-color'])." +swap -gravity center -composite -quality ".escapeshellarg($opts['quality'])." ".escapeshellarg($newPath);
				}else{
					$cmd = $path_to_convert." ".escapeshellarg($imagePath)." -resize ".escapeshellarg($resize)." -size ".escapeshellarg($w ."x". $h)." xc:". escapeshellarg($opts['canvas-color'])." +swap -gravity center -composite -quality ".escapeshellarg($opts['quality'])." ".escapeshellarg($newPath);
				}
			}else{
				$cmd = $path_to_convert." " . escapeshellarg($imagePath).
				" -thumbnail ".(!empty($h) ? 'x':'').$w." ".($opts['maxOnly'] == true ? "\>" : "")." -quality ".escapeshellarg($opts['quality'])." ".escapeshellarg($newPath);
			}
			$c = exec($cmd, $output, $return_code);
			if($return_code != 0) {
				error_log("Tried to execute : $cmd, return code: $return_code, output: " . print_r($output, true));
				return false;
			}
			if($opts['compress']){
				$size = getimagesize($newPath);
				$mime = $size['mime'];
				if($mime == 'image/png' || $mime == 3){
					$picture = imagecreatefrompng($newPath);
				}else if($mime == 'image/jpeg' || $mime == 2){
					$picture = imagecreatefromjpeg($newPath);
				}else if($mime == 'image/gif' || $mime == 1){
					$picture = imagecreatefromgif($newPath);
				}else{			
					error_log("I do not support this format for now. Mime - $mime ", 0);
				}
				if(isset($picture)){
					$newP_arr = explode(".",$newPath);
					$newestPath = $newP_arr[0].".jpg";
					$qc = 100 - $opts['compression'];
					$status = imagejpeg($picture,"$newestPath",$qc);
					if($status){
						unlink($newPath);
						$newPath = $newestPath;
					}else{
						@unlink($newestPath);
						error_log("I failed to compress the image in jpeg format.", 0);
					}
					imagedestroy($picture);
				}else{
					error_log("Failed To extract picture data", 0);
				}
			}
		}
		// return cache file path
		return str_replace($_SERVER['DOCUMENT_ROOT'],'',$newPath);	
	}
}