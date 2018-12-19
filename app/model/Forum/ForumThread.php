<?php

class ForumThread extends Model
{
	private $thread_id,
			$category_id,
			$user_id,
			$thread_author,
			$thread_subject,
			$thread_description,
			$thread_content,
			$thread_upvotes,
			$thread_downvotes,
			$thread_date,
			$thread_modTime,
			$thread_replies = [];

	public function getThreadID() { return $this->thread_id; }
	public function getThreadCategoryID() { return $this->category_id; }
	public function getThreadUserID() { return $this->user_id; }
	public function getThreadAuthor() { return $this->thread_author; }
	public function getThreadSubject() { return $this->thread_subject; }
	public function getThreadDescription() { return $this->thread_description; }
	public function getThreadContent() { return $this->thread_content; }
	public function getThreadUpvotes() { return $this->thread_upvotes; }
	public function getThreadDownvotes() { return $this->thread_downvotes; }
	public function getThreadDate() { return $this->thread_date; }
	public function getThreadModTime() { return $this->thread_modTime; }
	public function getThreadReplies() { return $this->thread_replies; }

	public function getThreadArray()
	{

        $user = new User();
       	$user->fetchUserInfo($this->getThreadUserID());
		
		$category = Controller::model('Forum/ForumCategory');
		$category->fetchCategoryInfo($this->getThreadCategoryID());
		
		$trending = Controller::model('TrendingSystem');
		
		$vote_count = $trending->getScore($this->getThreadID());
		
		$threadArray = array(
			'thread_id'=>$this->getThreadID(),
			'user_id'=>$this->getThreadUserID(),
			'category_id'=>$this->getThreadCategoryID(),
			'category_name'=>$category->getCategoryName(),
			'thread_author'=>$user->getUserArray(),
			'thread_subject'=>$this->getThreadSubject(),
			'thread_description'=>$this->getThreadDescription(),
			'thread_content'=>$this->getThreadContent(),
			'thread_date'=>Functions::getDateArray($this->getThreadDate()),
			'thread_upvotes'=>$this->getThreadUpvotes(),
			'thread_downvotes'=>$this->getThreadDownvotes(),
			'vote_count'=>$vote_count,
			'reply_count'=>$this->countReplies(),
			'thread_modTime'=>$this->getThreadModTime(),
			'thread_url_title'=>Functions::adjustStringSEO($this->getThreadSubject()),
			'category_url_title'=>Functions::adjustStringSEO($category->getCategoryName()),
			'adjusted_time'=>Functions::getTimeAdjustment($this->getThreadDate())
			);

		return $threadArray;
		
	}

	// Setters
	public function setThreadID($temp_id) { $this->thread_id = $temp_id; }
	public function setThreadCategoryID($temp_id) { $this->category_id = $temp_id; }
	public function setThreadUserID($temp_id) { $this->user_id = $temp_id; }
	public function setThreadAuthor($temp_name) { $this->thread_author = $temp_name; }
	public function setThreadSubject($temp_subject) { $this->thread_subject = $temp_subject; }
	public function setThreadDescription($temp_description) { $this->thread_description = $temp_description; }
	public function setThreadContent($temp_content) { $this->thread_content = $temp_content; }
	public function setThreadUpvotes($temp_amount) { $this->thread_upvotes = $temp_amount; }
	public function setThreadDownvotes($temp_amount) { $this->thread_downvotes = $temp_amount; }
	public function setThreadDate($temp_date) { $this->thread_date = $temp_date; }
	public function setThreadModTime($temp_time) { $this->thread_modTime = $temp_time; }
	
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
				$db->query($sql, array($this->getThreadID()));
			}
			
			$results = $db->single();

			// Set the object up.
			if($results != false){
				$this->setThreadID($results->thread_id);
				$this->setThreadCategoryID($results->category_id);
				$this->setThreadUserID($results->user_id);
				$this->setThreadAuthor($results->thread_author);
				$this->setThreadSubject($results->thread_subject);
				$this->setThreadDescription($results->thread_description);
				$this->setThreadContent($results->thread_content);
				$this->setThreadDate($results->thread_date);
				$this->setThreadModTime($results->thread_modTime);
				
				$trending = Controller::model('TrendingSystem');
				
				$this->setThreadUpvotes($trending->getUpvotes($this->getThreadID()));
				$this->setThreadDownvotes($trending->getDownvotes($this->getThreadID()));
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
		$position = array_search($id, $this->getThreadReplies());
		
		if($position !== false)
			unset($this->thread_replies[$position]);
	}
	public function fetchThreadReplies($limit = null)
	{
		try {
			$db = Database::getDBI();
			
			if($limit != null)
				$sql = 'SELECT reply_id FROM forum_replies WHERE thread_id = ? AND reply_parent_id = 0 ORDER BY reply_date DESC LIMIT '. $limit;
			else
				$sql = 'SELECT reply_id FROM forum_replies WHERE thread_id = ? AND reply_parent_id = 0 ORDER BY reply_date DESC LIMIT 10';
			$db->query($sql, array($this->getThreadID()));
			$results = $db->results('arr');
			
			foreach($results as $reply_id)
				$this->addReply($reply_id['reply_id']);
			
		} catch (Exception $e) { echo $e->getMessage(); }
	}
	
	//Counts Replies in Each Thread
	public function countReplies()
	{
		$db = Database::getDBI();
		
		$sql = 'SELECT COUNT(reply_id) AS total FROM forum_replies WHERE thread_id = ?';
		$db->query($sql, array($this->getThreadID()));
		
		$result = $db->single('arr');
		
		if($result != false)
			return $result['total'];
	}
	
	public function create()
	{
		try 
		{
			$db = Database::getDBI();
			
			$this->setThreadDate(date('Y-m-d H:i:s', time()));
			$db->insert('forum_thread', [
				'category_id'=>$this->getThreadCategoryID(),
				'user_id'=>$this->getThreadUserID(),
				'thread_author'=>$this->getThreadAuthor(),
				'thread_date'=>$this->getThreadDate(),
				'thread_subject'=>$this->getThreadSubject(),
				'thread_description'=>$this->getThreadDescription(),
				'thread_content'=>$this->getThreadContent()
			]);
		}
		catch (Exception $e) { echo $e->getMessage(); }
	}
	
	public function update()
	{

		try {
	
			// Get database instance or create new db object.
			$db = Database::getDBI();

			$this->setThreadModTime(date('Y-m-d H:i:s', time()));

			$db->update('forum_thread', ['thread_id'=>$this->getThreadID()],[
				'category_id'=>$this->getThreadCategoryID(),
				'thread_subject'=>$this->getThreadSubject(),
				'thread_description'=>$this->getThreadDescription(),
				'thread_content'=>$this->getThreadContent(),
				'thread_modTime'=>$this->getThreadModTime()
				]);

		} catch (Exception $e) {
			echo $e->getMessage();
		}

	}
	
	public function delete()
	{
		try 
		{
			$db = Database::getDBI();
			
			if($this->countReplies() > 0)
				$db->delete('forum_replies', ['thread_id'=>$this->getThreadID()]);
			
			if($this->getThreadUpvotes() > 0 || $this->getThreadDownvotes() > 0)
				$db->delete('forum_upvote_downvote', ['thread_id'=>$this->getThreadID()]);
			
			$db->delete('forum_thread', ['thread_id'=>$this->getThreadID()]);
		} 
		catch (Exception $e) {
			echo $e->getMessage();
		}
	}
			
}