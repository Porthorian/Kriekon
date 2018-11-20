<?php

/**
 * @author Brian L. Peter Jr. AKA Peter
 * @method object   Thread     This class is used to manage all of the threads
 *                             within the forum.
 * @TODO: Properly comment out the functions!
 */
class Thread extends Model
{

	private $thread_id,
			$subCategory_id,
			$user_id,
			$thread_author,
			$thread_subject,
			$thread_content,
			$thread_likes,
			$thread_dislikes,
			$thread_date,
			$thread_modTime,
			$thread_modName,
			$thread_replies = [];

	// Getters
	public function getThreadId() { return $this->thread_id; }
	public function getThreadSubCategoryId() { return $this->subCategory_id; }
	public function getThreadUserId() { return $this->user_id; }
	public function getThreadAuthor() { return $this->thread_author; }
	public function getThreadSubject() { return $this->thread_subject; }
	public function getThreadContent() { return $this->thread_content; }
	public function getThreadLikes() { return $this->thread_likes; }
	public function getThreadDislikes() { return $this->thread_dislikes; }
	public function getThreadReplies() { return $this->thread_replies; }
	public function getThreadDate() { return $this->thread_date; }
	public function getThreadModTime() { return $this->thread_modTime; }
	public function getThreadModName() { return $this->thread_modName; }

	public function getThreadArray()
	{

		$newDateFormat = new DateTime($this->getThreadDate());
        $date = $newDateFormat->format('Y-m-d');

        $user = new User();
       	$user->fetchUserInfo($this->getThreadUserId());

		$threadArray = array(
			'thread_id'=>$this->getThreadId(),
			'thread_author'=>$user,
			'thread_subject'=>$this->getThreadSubject(),
			'thread_content'=>$this->getThreadContent(),
			'thread_likes'=>$this->getThreadLikes(),
			'thread_dislikes'=>$this->getThreadDislikes(),
			'thread_date'=>$date,
			'thread_modTime'=>$this->getThreadModTime(),
			'thread_modName'=>$this->getThreadModName()
			);

		return $threadArray;
		
	}

	// Setters
	public function setThreadId($temp_id) { $this->thread_id = $temp_id; }
	public function setThreadSubCategoryId($temp_id) { $this->subCategory_id = $temp_id; }
	public function setThreadUserId($temp_id) { $this->user_id = $temp_id; }
	public function setThreadAuthor($temp_name) { $this->thread_author = $temp_name; }
	public function setThreadSubject($temp_subject) { $this->thread_subject = $temp_subject; }
	public function setThreadContent($temp_content) { $this->thread_content = $temp_content; }
	public function setThreadLikes($temp_amount) { $this->thread_likes = $temp_amount; }
	public function setThreadDislikes($temp_amount) { $this->thread_dislikes = $temp_amount; }
	public function setThreadDate($temp_date) { $this->thread_date = $temp_date; }
	public function setThreadModTime($temp_time) { $this->thread_modTime = $temp_time; }
	public function setThreadModName($temp_name) { $this->thread_modName = $temp_name; }

	// Likes/Dislikes
	public function increaseLikes($amount, $user_id, $thread_id) 
	{
		$db = Database::getDBI();

		$sql = 'SELECT * FROM forum_like_dislike WHERE user_id = ? AND thread_id = ?';
		$db->query($sql, array($user_id, $thread_id));
		$result = $db->single('arr');

		if($result == false){
			$this->thread_likes += $amount; 
			$db->insert('forum_like_dislike', ['liked'=>1,'user_id'=>$user_id, 'thread_id'=>$thread_id]);
		} else {
			if($result['liked'] == 0)
			{
				$this->thread_likes += $amount; 
				$db->update('forum_like_dislike', ['like_dislike_id'=>$result['like_dislike_id']], ['liked'=>1]);
			} elseif ($result['liked'] == 1 && $result['disliked'] == 0){
				$this->thread_likes -= $amount;
				$db->delete('forum_like_dislike', ['like_dislike_id'=>$result['like_dislike_id']]);
			} elseif ($result['liked'] == 1 && $result['disliked'] == 1){
				$this->thread_likes -= $amount;
				$db->update('forum_like_dislike', ['like_dislike_id'=>$result['like_dislike_id']], ['liked'=>0]);
			}
		}
	}

	public function checkLikes($user_id, $thread_id)
	{
		$db = Database::getDBI();

		$sql = 'SELECT like_dislike_id, liked FROM forum_like_dislike WHERE user_id = ? AND thread_id = ?';
		$db->query($sql, array($user_id, $thread_id));
		$result = $db->single('arr');
		if($result){
			if($result['liked']==1){
				return 'true';
			} else {
				return 'false';
			}
		} else {
			return 'false';
		}
		
	}

	public function checkDislikes($user_id, $thread_id)
	{
		$db = Database::getDBI();

		$sql = 'SELECT like_dislike_id, disliked FROM forum_like_dislike WHERE user_id = ? AND thread_id = ?';
		$db->query($sql, array($user_id, $thread_id));
		$result = $db->single('arr');
		if($result){
			if($result['disliked']==1){
				return 'true';
			} else {
				return 'false';
			}
		} else {
			return 'false';
		}
	}

	public function increaseDislikes($amount, $user_id, $thread_id)
	{ 

		$db = Database::getDBI();

		$sql = 'SELECT * FROM forum_like_dislike WHERE user_id = ? AND thread_id = ?';
		$db->query($sql, array($user_id, $thread_id));
		$result = $db->single('arr');

		if($result == false){
			$this->thread_dislikes += $amount; 
			$db->insert('forum_like_dislike', ['disliked'=>1,'user_id'=>$user_id, 'thread_id'=>$thread_id]);
		} else {
			if($result['disliked'] == 0)
			{
				$this->thread_dislikes += $amount; 
				$db->update('forum_like_dislike', ['like_dislike_id'=>$result['like_dislike_id']], ['disliked'=>1]);
			} elseif ($result['disliked'] == 1 && $result['liked'] == 0){
				$this->thread_dislikes -= $amount;
				$db->delete('forum_like_dislike', ['like_dislike_id'=>$result['like_dislike_id']]);
			} elseif ($result['disliked'] == 1 && $result['liked'] == 1){
				$this->thread_dislikes -= $amount;
				$db->update('forum_like_dislike', ['like_dislike_id'=>$result['like_dislike_id']], ['disliked'=>0]);
			}
		}
	}

	public function fetchThreadInfo($id = null)
	{

		try {

			// Get database instance or create new db object.
			$db = Database::getDBI();

			$sql = 'SELECT * FROM forum_thread WHERE thread_id = ?';
			if($id != null)
			{
				$db->query($sql, array($id));
			} else {
				$db->query($sql, array($this->getThreadId()));
			}
			
			$results = $db->single();

			// Set the object up.
			if($results != false){
				$this->setThreadId($results->thread_id);
				$this->setThreadSubCategoryId($results->subCategory_id);
				$this->setThreadUserId($results->user_id);
				$this->setThreadAuthor($results->thread_author);
				$this->setThreadSubject($results->thread_subject);
				$this->setThreadContent($results->thread_content);
				$this->setThreadLikes($results->thread_likes);
				$this->setThreadDislikes($results->thread_dislikes);
				$this->setThreadModTime($results->thread_modTime);
				$this->setThreadModName($results->thread_modName);
				$this->setThreadDate($results->thread_date);
			}
		} catch (Exception $e) {
			echo $e->getMessage();
		}

	}

	public function fetchMostRecentReply()
	{

		try {

			// Get database instance or create new db object.
			$db = Database::getDBI();

			// Grab the most recently created reply for the thread.
			$sql = 'SELECT reply_id FROM forum_replies WHERE thread_id = ? ORDER BY reply_date DESC LIMIT 1';
			$db->query($sql, array($this->getThreadId()));
			$results = $db->single('arr');

			return $results['reply_id'];
			
		} catch (Exception $e) {
			echo $e->getMessage();
		}

	}

	public function fetchMostRecentThreads($limit)
	{

		try {

			// Get database instance or create new db object.
			$db = Database::getDBI();
			if($limit != null) {
				// Grab the most recent replies posted in the database, limit results to $limit.
				$sql = 'SELECT * FROM forum_thread ORDER BY thread_date DESC LIMIT '.$limit;
			} else {
				// Grab the most recent replies posted in the database, limit results to 5.
				$sql = 'SELECT * FROM forum_thread ORDER BY thread_date DESC LIMIT 5';
			}
			
			$db->query($sql);
			$results = $db->results('arr');

			return $results;
			
		} catch (Exception $e) {
			echo $e->getMessage();
		}

	}

	public function fetchReplies($id, $page_number, $per_page)
	{

		try {
			
			// Get database instance or create new db object.
			$db = Database::getDBI();

			if(empty($page_number)) 
			{
				$page_number = 0;
			}

			$sql = 'SELECT COUNT(reply_id) AS total FROM forum_replies WHERE thread_id = ?';
			$db->query($sql, ['thread_id'=>$id]);
			$results = $db->single();
			if($results->total > 0)
			{
				$sql = 'SELECT reply_id FROM forum_replies WHERE thread_id = ? ORDER BY reply_date LIMIT '.($page_number - 1) * $per_page .', '. $per_page;
				$db->query($sql, ['thread_id'=>$id]);
				$results = $db->results('arr');

				foreach ($results as $reply)
				{
					$this->addReply($reply['reply_id']);
				}
			}
			
		} catch (Exception $e) {
			echo $e->getMessage();
		}
		
	}

	public function addReply($id)
	{
		$this->thread_replies[] = $id;
	}

	public function removeReply($id)
	{
		// Find where the $id is located in the array or if it exists.
		$position = array_search($id, $this->getThreadReplies());

		// Do not unset the thread if $position equals false and is a boolean.
		if($position !== false)
		{
			unset($this->thread_replies[$position]);
		}
	}

	public function count()
	{

		try {
			
			// Get database instance or create new db object.
			$db = Database::getDBI();

			// Count how many super categories belong to the forum.
			$sql = 'SELECT COUNT(thread_id) AS total FROM forum_thread WHERE subCategory_id = ?';
			$db->query($sql,['subCategory_id'=>$this->getThreadSubCategoryId()]);

			$result = $db->single('arr');
			
			return $result['total'];

		} catch (Exception $e) {
			echo $e->getMessage();
		}

	}

	public function create()
	{

		try {
			
			// Get database instance or create new db object.
			$db = Database::getDBI();

			$this->setThreadDate(date('Y-m-d H:i:s', time()));
			
			//Insert the new category in the database.
			$db->insert('forum_thread',[
				'subCategory_id'=>$this->getThreadSubCategoryId(),
				'user_id'=>$this->getThreadUserId(),
				'thread_author'=>$this->getThreadAuthor(),
				'thread_subject'=>$this->getThreadSubject(),
				'thread_content'=>$this->getThreadContent(),
				'thread_likes'=>$this->getThreadLikes(),
				'thread_dislikes'=>$this->getThreadDislikes(),
				'thread_date'=>$this->getThreadDate(),
				'thread_modName'=>$this->getThreadModName()
				]);

		} catch (Exception $e) {
			echo $e->getMessage();
		}

	}

	public function update()
	{

		try {
	
			// Get database instance or create new db object.
			$db = Database::getDBI();

			$this->setThreadModTime(date('Y-m-d H:i:s', time()));

			// Update sub category name!
			$db->update('forum_thread', ['thread_id'=>$this->getThreadId()],[
				'subCategory_id'=>$this->getThreadSubCategoryId(),
				'user_id'=>$this->getThreadUserId(),
				'thread_author'=>$this->getThreadAuthor(),
				'thread_subject'=>$this->getThreadSubject(),
				'thread_content'=>$this->getThreadContent(),
				'thread_likes'=>$this->getThreadLikes(),
				'thread_dislikes'=>$this->getThreadDislikes(),
				'thread_date'=>$this->getThreadDate(),
				'thread_modTime'=>$this->getThreadModTime(),
				'thread_modName'=>$this->getThreadModName()
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

			// Delete the sub category from db
			$db->delete('forum_thread', ['thread_id'=>$this->getThreadId()]);

		} catch (Exception $e) {
			echo $e->getMessage();
		}

	}

}

?>