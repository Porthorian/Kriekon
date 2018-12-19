<?php

/**
*
*/
class User extends Model
{

	private $user_id,
			$user_first,
			$user_last,
			$user_email,
			$user_DOB,
			$user_username,
			$user_password,
			$user_loginTime,
			$user_regTime,
			$user_timezone,
			$user_ip_address,
			$user_avatar,
			$user_steamid,
			//$user_personaname,
			//$user_profileurl,
			//$user_avatarurl,
			//$user_timecreated,
			//$user_loccountrycode,
			$user_tags = [],
			$user_permissions = [];

	public function getUserID() { return $this->user_id; }
	public function getUserFirst() { return $this->user_first; }
	public function getUserLast() { return $this->user_last; }
	public function getUserEmail() { return $this->user_email; }
	public function getUserDOB() { return $this->user_DOB; }
	public function getUserUsername() { return $this->user_username; }
	public function getUserPassword() { return $this->user_password; }
	public function getUserRegTime() { return $this->user_regTime; }
	public function getUserModTime() { return $this->user_modTime; }
	public function getUserLoginTime() { return $this->user_loginTime; }
	public function getUserIP() { return $this->user_ip_address; }
	public function getUserAvatar() { return $this->user_avatar; }
	public function getTags() { return $this->user_tags; }
	public function getPermissions() { return $this->user_permissions; }
	public function getUserTimezone() { return $this->user_timezone; }
	// public function getUserSteamId() { return $this->user_steamid; }
	// public function getUserPersonaName() { return $this->user_personaname; }
	// public function getUserProfileURL() { return $this->user_profileurl = $url; }
	// public function getUserAvatarURL() { return $this->user_avatarurl = $url; }
	// public function getUserTimeCreated() { return $this->user_timecreated = $datetime; }
	// public function getUserCountryCode() { return $this->user_loccountrycode = $countrycode; }
	
	public function getUserArray() //For the time being. This will obviously be changed as we finish more features. But for right now wanna get a wireframe up for the profile page.
	{
		$user_array = array('user_id'=>$this->getUserID(),
						  'user_first'=>$this->getUserFirst(),
						  'user_last'=>$this->getUserLast(),
						  'user_email'=>$this->getUserEmail(),
						  'user_username'=>$this->getUserUsername(),
						  'user_password'=>$this->getUserPassword(),
						  'user_tags'=>$this->getTags(),
						  'user_permissions'=>$this->getPermissions(),
						  'thread_reply_count'=>$this->getPostCount($this->getUserID()));
			return $user_array;
	}

	public function setUserID($id) { $this->user_id = $id; }
	public function setUserFirst($name) { $this->user_first = $name; }
	public function setUserLast($name) { $this->user_last = $name; }
	public function setUserEmail($email) { $this->user_email = $email; }
	public function setUserDOB($dob) { $this->user_DOB = $dob; }
	public function setUserUsername($username) { $this->user_username = $username; }
	public function setUserPassword($password) { $this->user_password = $password; }
	public function setUserRegTime($reg_time) { $this->user_regTime = $reg_time; }
	public function setUserLoginTime($log_time) { $this->user_loginTime = $log_time; }
	public function setUserIP($ip) { $this->user_ip_address = $ip; }
	public function setUserAvatar($avatar) { $this->user_avatar = $avatar; }
	/*public function setUserSteamId($id) { $this->user_steamid = $id; }
	public function setUserPersonaName($name) { $this->user_personaname = $name; }
	public function setUserProfileURL($url) { $this->user_profileurl = $url; }
	public function setUserAvatarURL($url) { $this->user_avatarurl = $url; }
	public function setUserTimeCreated($datetime) { $this->user_timecreated = $datetime; }
	public function setUserCountryCode($countrycode) { $this->user_loccountrycode = $countrycode; }*/
	public function setUserTimezone($timezone) { $this->user_timezone = $timezone; }
	public function encodePassword($pass) { return hash("sha512", crypt($pass, Config::get('security/salt'))); }

	public function setUpUser($obj)
	{
		$this->setUserID($obj->user_id);
		$this->setUserFirst($obj->user_first);
		$this->setUserLast($obj->user_last);
		$this->setUserEmail($obj->user_email);
		$this->setUserDOB($obj->user_DOB);
		$this->setUserUsername($obj->user_username);
		$this->setUserPassword($obj->user_password);
		$this->setUserRegTime($obj->user_regTime);
		$this->setUserTimezone($obj->user_timezone);
		$this->setUserIP($obj->user_ip_address);
		$this->setUserAvatar($obj->user_avatar);
		$this->fetchUserPermissions();
		$this->fetchUserTags();
		// $this->setUserSteamId($obj->user_steamid);
		// $this->setUserPersonaName($obj->user_personaname);
		// $this->setUserProfileURL($obj->user_personaname);
		// $this->setUserAvatarURL($obj->user_avatarurl);
		// $this->setUserTimeCreated($obj->user_timecreated);
		// $this->setUserCountryCode($obj->user_loccountrycode);


	}

	public function fetchUserInfo($id_or_name = null)
	{
		$db = Database::getDBI();

		if($id_or_name == null)
		{
			$sql = 'SELECT * FROM users WHERE user_id = ?';
			$db->query($sql, array($this->getUserID()));
		}
		elseif (is_string($id_or_name))
		{
			$sql = 'SELECT * FROM users WHERE user_username = ?';
			$db->query($sql, array($id_or_name));
		}
		elseif (is_int($id_or_name))
		{
			$sql = 'SELECT * FROM users WHERE user_id = ?';
			$db->query($sql, array($id_or_name));
		}

		$user_result = $db->single();
		
		if ($user_result) {
			$this->setUpUser($user_result);
			return true;
		} else {
			//Add Javascript prompt.
			throw new Exception('There is an error with the SQL pulling the users info');
		}
	}
	public function checkUsername($name = null)
	{
		$db = Database::getDBI();
		
		if($name != null)
		{
			$sql = 'SELECT user_username FROM users WHERE user_username = ?';
			$db->query($sql, array($name));
		}
		else
		{
			$sql = 'SELECT user_username FROM users WHERE user_username = ?';
			$db->query($sql, array($this->getUserUsername()));
		}
		$result = $db->single();
		
		if($result != false)
		{
			if(empty($result->user_username))
			{
				return false;
			}
			else
			{
				$this->setUserUsername($result->user_username);
				return true;
			}
		}
	}
	public function checkEmail($name = null)
	{
		$db = Database::getDBI();
		
		if($name != null)
		{
			$sql = 'SELECT user_email FROM users WHERE user_email = ?';
			$db->query($sql, array($name));
		}
		else
		{
			$sql = 'SELECT user_email FROM users WHERE user_email = ?';
			$db->query($sql, array($this->getUserEmail()));
		}
		$result = $db->single();
		
		if($result != false)
		{
			if(empty($result->user_email))
			{
				return false;
			}
			else
			{
				$this->setUserUsername($result->user_email);
				return true;
			}
		}
	}
	public function register($dob, $email, $username, $password)
	{
		$db = Database::getDBI();
		try {
			$sql = 'SELECT user_username FROM users WHERE user_username = ?';
			$db->query($sql,[$username]);
			$result = $db->single();
			if($result) {
				return 'Username is already taken.'; //returns false if username exists
			} else {
				$regdate = date('Y-m-d H:i:s', time());
				$password = $this->encodePassword($password);
				//$ip_address = Functions::get_ip_address();
				$ip_address = null;
				$dob = strtotime($dob);
				
				$this->setUserEmail($email);
				$this->setUserDOB($dob);
				$this->setUserUsername($username);
				$this->setUserPassword($password);
				$this->setUserIP($ip_address);
				$this->setUserRegTime($regdate);
				//$this->setUserTimezone($timezone);
				try {
					$db->insert('users', [
					'user_DOB'=>date('Y-m-d', $dob),
					'user_email'=>$email,
					'user_username'=>$username,
					'user_password'=>$password,
					'user_regTime'=>$regdate,
					'user_ip_address'=>$ip_address
					//'user_timezone'=>$timezone,
										 ]);
					
					//Once Email Server and Verification is added, this will be changed, as we want Verified accounts to be considered "Register Users" aka Members
					$db->insert('tag_user', [
						'tag_id'=>7,
						'user_id'=>$db->lastId()
					]);
				} catch (Exception $e) {
					echo "Error registering" . $e->getMessage();
				}
			}
		} catch(Exception $e) {
			echo $e->getMessage();
		}
	}
	
	public function login($email, $password)
	{
		try {
			$db = Database::getDBI();
			$password = $this->encodePassword($password);
			$db->select('users',['user_email'=>$email, 'user_password'=>$password]);
			$user = $db->single();
			
			if($user) {
				$this->setUpUser($user);
				$this->setUserLoginTime(date('Y-m-d H:i:s', time()));
				$this->update();
				return 1;
			} else {
				echo 'Not Logged In ';
				return 0;
			}
		} catch (Exception $e) {
				echo $e->getMessage();
		}
	}

	public function logout()
	{

		  if(isset($_SESSION[Config::get('session/user_session')])) {

			session_destroy();
			unset($_SESSION[Config::get('session/user_session')]);

			return true;
		  }
		  return false;

	}

	public function checkPermission($permission) {
		if(in_array($permission, $this->getPermissions())){
			return true;
		} else {
			return false;
		}
	}

	public function fetchUserPermissions()
	{
		$db = Database::getDBI();

		$sql = 'SELECT permissions.permission_name FROM permissions JOIN permission_user ON permission_user.permission_id = permissions.permission_id WHERE permission_user.user_id = ?';
		$db->query($sql, ['user_id'=>$this->getUserID()]);
		$results = $db->results('arr');

		foreach ($results as $permission) {
			if(empty($this->getPermissions())) {
				$this->user_permissions[] = $permission['permission_name'];
			} else {
				if(!in_array($permission['permission_name'], $this->getPermissions())) {
					$this->user_permissions[] = $permission['permission_name'];
				}
			}
		}
	}

	public function fetchUserTags()
	{
		$db = Database::getDBI();

		$sql = 'SELECT tags.tag_name FROM tags JOIN tag_user ON tag_user.tag_id = tags.tag_id WHERE tag_user.user_id = ? ORDER BY tags.tag_id ASC';
		$db->query($sql, ['user_id'=>$this->getUserID()]);
		$results = $db->results('arr');

		foreach ($results as $tag) {
			if(empty($this->getTags())) {
				$this->user_tags[] = $tag['tag_name'];
			} else {
				if(!in_array($tag['tag_name'], $this->getTags())) {
					$this->user_tags[] = $tag['tag_name'];
				}
			}
		}
	}

	public function addTag($id)
	{
		$position = array_search($id, $this->getTags());
		if($position === false) {
			$tag = new Tag();
			$tag->fetchTagInfo($id);
			$tag->fetchPermissions();

			$db = Database::getDBI();

			$sql = 'SELECT * FROM tag_user WHERE tag_id = ? AND user_id = ?';
			$db->query($sql, ['tag_id'=>$id,'user_id'=>$this->getUserID()]);
			$check = $db->single();

			if(!$check)
			{
				// Add the tag in the database.
				$db->insert('tag_user',['tag_id'=>$id, 'user_id'=>$this->getUserID()]);

				if(empty($this->getTags())) {
					$this->user_tags[] = $tag->getTagName();
				} elseif(!in_array($tag->getTagName(), $this->getTags())) {
					$this->user_tags[] = $tag->getTagName();
				}

				foreach ($tag->getTagPermissions() as $permission) {
					if(empty($this->getPermissions())) {
						$this->addPermission($permission['id'], $permission['name']);
					} else {
						if(!in_array($permission['name'], $this->getPermissions())) {
							$this->addPermission($permission['id'], $permission['name']);
						}
					}
				}
			}
		}
	}

	public function removeTag($id)
	{
		$db = Database::getDBI();
		$sql = 'SELECT tags.tag_name, tag_user_id FROM tags JOIN tag_user ON tags.tag_id = tag_user.tag_id WHERE user_id = ? AND tag_user.tag_id = ?';
		$db->query($sql, ['user_id'=>$this->getUserID(), 'tag_user.tag_id'=>$tag_id]);
		$result = $db->single();
		$position = array_search($result->tag_name, $this->getTags());

		if ($position === false) {

			echo 'The user does not have this tag.';

		} else {

			unset($this->user_tags[$position]);

			$db->delete('tag_user',['tag_user_id'=>$result->tag_user_id]);
		}

		$tag = new Tag();
		$tag->fetchTagInfo($tag_id);
		$tag->fetchPermissions();
		foreach ($tag->getTagPermissions() as $permission) {
			if(in_array($permission['name'], $this->getPermissions())){
				$this->removePermission($permission['id']);
			}
		}
	}

	public function addPermission($id, $name = '')
	{
		$position = array_search($id, $this->getPermissions());
		if($position === false) {
			$permission = new Permission();
			$permission->fetchPermissionInfo($id);

			$db = Database::getDBI();

			$sql = 'SELECT * FROM permission_user WHERE user_id = ? and permission_id = ?';
			$db->query($sql, ['user_id'=>$this->getUserID(), 'permission_id'=>$id]);
			$result = $db->single();

			if(!$result)
			{
				// Add the tag in the database.
				$db->insert('permission_user',['permission_id'=>$id, 'user_id'=>$this->getUserID()]);

				if($name != null)
				{
					if(empty($this->getPermissions())){
						$this->user_permissions[] = $name;
					} else {
						if(!in_array($name, $this->getPermissions())){
							$this->user_permissions[] = $name;
						}
					}
				} else {
					$sql = 'SELECT permission_name FROM permissions JOIN permission_user ON permissions.permission_id = permission_user.permission_id WHERE user_id = ?';
					$db->query($sql, ['user_id'=>$this->getUserID()]);
					$result = $db->single();

					if(empty($this->getPermissions())){
						$this->user_permissions[] = $name;
					} else {
						if(!in_array($name, $this->getPermissions())){
							$this->user_permissions[] = $name;
						}
					}
				}
			}
		}
	}

	public function removePermission($id)
	{
		$db = Database::getDBI();
		$sql = 'SELECT permission_name, permission_user_id FROM permissions JOIN permission_user ON permissions.permission_id = permission_user.permission_id WHERE user_id = ? AND permission_user.permission_id = ?';
		$db->query($sql, ['user_id'=>$this->getUserID(), 'permission_user.permission_id'=>$id]);
		$result = $db->single();
		$position = array_search($result->permission_name, $this->getPermissions());

		if ($position === false) {

			echo 'The user does not have this tag.';

		} else {

			unset($this->user_permissions[$position]);

			$db->delete('permission_user',['permission_user_id'=>$result->permission_user_id]);

		}
	}
	
	//Gets all Posts count for the user
	public function getPostCount($user_id)
	{
		try 
		{
			$db = Database::getDBI();
			
			$sql = 'SELECT (SELECT COUNT(user_id) FROM forum_thread WHERE user_id = ' . $user_id . ') + (SELECT COUNT(user_id) FROM forum_replies WHERE user_id = ' . $user_id . ') AS total_posts';
			$db->query($sql);
			$result = $db->single('arr');

			if($result != false)
			{
				return $result['total_posts'];
			}
			
		}
		catch (Exception $e) { echo $e->getMessage(); }
	}
	public function update()
	{
		try {

			// Get database instance or create new db object.
			$db = Database::getDBI();

			// Update the user!
			$db->update('users', ['user_id'=>$this->getUserID()],[
				'user_first'=>$this->getUserFirst(),
				'user_last'=>$this->getUserLast(),
				'user_email'=>$this->getUserEmail(),
				'user_DOB'=>$this->getUserDOB(),
				'user_username'=>$this->getUserUsername(),
				'user_password'=>$this->getUserPassword(),
				'user_regTime'=>$this->getUserRegTime(),
				'user_timezone'=>$this->getUserTimezone(),
				'user_loginTime'=>$this->getUserLoginTime(),
				'user_ip_address'=>$this->getUserIP(),
				'user_avatar'=>$this->getUserAvatar()
				]);

		} catch (Exception $e) {
			echo $e->getMessage();
		}
	}

	public function delete()
	{
		try {
			// Get database instance or create new db object.
			$db = Database::getDBI();

			// Delete the user from the db.
			$db->delete('users', ['user_id'=>$this->getUserId()]);


		} catch (Exception $e) {
			echo $e->getMessage();
		}


	}

	// public function matchSteam()
	// {

	// }

	// public function linkSteam()
	// {

	// }

	/*public function getUserThreads($userid, $page, $perpage) Deprecated Research Purposes only
	{
		if(empty($page)) { $page = 0; }
		// echo $userid . ' ' . $page . ' ' . $perpage;
		$db = Database::getDBI();
		$db->query("SELECT * FROM forum_thread WHERE user_id = '{$userid}' ORDER BY thread_date DESC");
		$nums = $db->count();
		if($nums > 0) {
			if($page > 0){
				$offset = $page+1 * $perpage;
			} else {
				$offset = $page * $perpage;
			}
			$sql = "SELECT * FROM forum_thread WHERE user_id = ? ORDER BY thread_date LIMIT $perpage OFFSET $offset";

			$db->query($sql, array($userid, $page, $perpage));

			$threads = $db->results('arr');
			$new_threads = array();

			foreach($threads as $key => $value) {
				$new_threads[] = $key=$value;
			}

			$new_threads['total'] = $nums;
			return $new_threads;
		} else {
			return false;
		}
	}

	public function hasThreads($userID)
	{
		$db = Database::getDBI();
		$sql = 'SELECT COUNT(thread_id) AS total FROM forum_thread WHERE user_id = ?';
		$db->query($sql,['user_id'=>$userID]);
		$result = $db->single('arr');
		if ($result['total'] > 0)
		{
			return true;
		} else {
			return false;
		}

	}*/
}


?>
