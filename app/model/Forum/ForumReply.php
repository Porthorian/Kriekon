<?php

class ForumReply extends Model
{
	private $reply_id,
			$thread_id,
			$user_id,
			$reply_parent_id,
			$reply_author,
			$reply_date,
			$reply_content,
			$reply_upvotes,
			$reply_downvotes,
			$reply_children = [];
	
	public function getReplyID() { return $this->reply_id; }
	public function getReplyThreadID() { return $this->thread_id; }
	public function getReplyUserID() { return $this->user_id; }
	public function getReplyParentID() { return $this->reply_parent_id; }
	public function getReplyAuthor() { return $this->reply_author; }
	public function getReplyDate() { return $this->reply_date; }
	public function getReplyContent() { return $this->reply_content; }
	public function getReplyUpvotes() { return $this->reply_upvotes; }
	public function getReplyDownvotes() { return $this->reply_downvotes; }
	public function getReplyChildren() { return $this->reply_children; }
	
	public function addReplyChildren($reply_id) { $this->reply_children[] = $reply_id; }
	
	public function setReplyID($temp_id) { $this->reply_id = $temp_id; }
	public function setReplyThreadID($temp_id) { $this->thread_id = $temp_id; }
	public function setReplyUserID($temp_id) { $this->user_id = $temp_id; }
	public function setReplyParentID($temp_id) { $this->reply_parent_id = $temp_id; }
	public function setReplyAuthor($temp_string) { $this->reply_author = $temp_string; }
	public function setReplyDate($temp_date) { $this->reply_date = $temp_date; }
	public function setReplyContent($temp_string) { $this->reply_content = $temp_string; }
	public function setReplyUpvotes($temp_int) { $this->reply_upvotes = $temp_int; }
	public function setReplyDownvotes($temp_int) { $this->reply_downvotes = $temp_int; }
	
	
	//Create a Nested Comment Function. By Storing parent_id in the forum_replies table.
	public function fetchReplyInfo($id = null)
	{
		try
		{
			// Get database instance or create new db object.
			$db = Database::getDBI();

			$sql = 'SELECT * FROM forum_replies WHERE reply_id = ?';
			if($id != null)
			{
				$db->query($sql, array($id));
			} else {
				$db->query($sql, array($this->getReplyID()));
			}
			
			$results = $db->single();

			// Set the object up.
			if($results != false){
				$this->setReplyID($results->reply_id);
				$this->setReplyThreadID($results->thread_id);
				$this->setReplyUserID($results->user_id);
				$this->setReplyParentID($results->reply_parent_id);
				$this->setReplyAuthor($results->reply_author);
				$this->setReplyDate($results->reply_date);
				$this->setReplyContent($results->reply_content);
				$this->setReplyUpvotes($results->reply_upvotes);
				$this->setReplyDownvotes($results->reply_downvotes);
			}
		} catch (Exception $e) {
			echo $e->getMessage();
		}
	}
	
	public function fetchReplyChildren($reply_id)
	{
		$db = Database::getDBI();
		
		$sql = 'SELECT reply_id FROM forum_replies WHERE reply_parent_id = ?';
		
		$db->query($sql, array($reply_id));
		
		$results = $db->results('arr');

		if($results != false)
		{
			foreach ($results as $reply) {
				$this->addReplyChildren($reply['reply_id']);
			}
		}
	}
	public function create()
	{
		try 
		{
			$db = Database::getDBI();
			
			$this->setReplyDate(date('Y-m-d H:i:s', time()));
			
			$db->insert('forum_replies', [
				'thread_id'=>$this->getReplyThreadID(),
				'user_id'=>$this->getReplyUserID(),
				'reply_parent_id'=>$this->getReplyParentID(),
				'reply_author'=>$this->getReplyAuthor(),
				'reply_date'=>$this->getReplyDate(),
				'reply_content'=>$this->getReplyContent()
			]);
		}
		catch (Exception $e) { echo $e->getMessage(); }
	}
}