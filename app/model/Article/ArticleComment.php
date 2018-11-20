<?php

class ArticleComment {

	private	$comment_id,
			$comment_date,
			$comment_modName,
			$comment_modTime,
			$comment_author,
			$comment_content,
			$article_id,
			$user_id;
	
	private $articleComment_mod_date = '1970-01-01 00:00:00';
	
	//---------------GETTERS---------------
	public function getArticleCommentID() { return $this->comment_id; }
	public function getArticleCommentDate() { return $this->comment_date; }
	public function getArticleCommentModTime() { return $this->comment_modTime; }
	public function getArticleCommentModName() { return $this->comment_modName; } 
	public function getArticleCommentAuthor() { return $this->comment_author; }
	public function getArticleCommentContent() { return $this->comment_content;	}
	public function getUserID() { return $this->user_id; }
	public function getArticleID() {return $this->article_id; }
	
	public function getComments()
	{
		$newDateFormat = new DateTime($this->getArticleCommentDate());
		$date = $newDateFormat->format('Y-m-d');
		
		//$user = new User();
		//$user->fetchUserInfo($this->getArticleCommentAuthor());
		
		$commentArray[] = array
			(
				'comment_id'=>$this->getArticleCommentID(),
				'article_id'=>$this->getArticleID(),
				'user_id'=>$this->getUserID(),
				'comment_author'=>$this->getArticleCommentAuthor(),
				'comment_date'=>$this->getArticleCommentDate(),
				'comment_content'=>$this->getArticleCommentContent()
			);
		return $commentArray;
	}
	//--------------SETTERS-------------------
	public function setArticleCommentID($temp_id) { $this->comment_id = $temp_id; }
	public function setArticleCommentDate($temp_date) { $this->comment_date = $temp_date; }
	public function setArticleCommentAuthor($temp_author) { $this->comment_author = $temp_author; }
	public function setArticleCommentContent($temp_content) { $this->comment_content = $temp_content; }
	public function setUserID($temp_id) { $this->user_id = $temp_id; }
	public function setArticleID($temp_id) { $this->article_id = $temp_id; }
	public function setArticleCommentModTime($temp_time) { $this->comment_modTime = $temp_time; }
	public function setArticleCommentModName($temp_name) { $this->comment_modName = $temp_name; }
	
	public function fetchCommentInfo($id = null)
	{
		try
		{
			$db = Database::getDBI(); //Creates a DB instance.
			
			$sql = 'SELECT * FROM article_comments WHERE comment_id = ?'; //Selects table in database and where it has the same comment_id
			
			if($id != null)
				$db->query($sql, array($id));
			else
				$db->query($sql, array($this->getArticleCommentID()));
			
			$results = $db->single();
			
			if($results != false)
			{
				$this->setArticleCommentID($results->comment_id);
				$this->setArticleID($results->article_id);
				$this->setUserID($results->user_id);
				$this->setArticleCommentAuthor($results->comment_author);
				$this->setArticleCommentDate($results->comment_date);
				$this->setArticleCommentContent($results->comment_content);
				$this->setArticleCommentModTime($results->comment_modTime);
				$this->setArticleCommentModName($results->comment_modName);
			}
		}
		catch (Exception $e) { echo $e->getMessage(); }
	}

	public function create() 
	{
		try
		{
			$db = Database::getDBI();//Creates a DB Instance
			
			$this->setArticleCommentDate(date('Y-m-d H:i:s', time()));
			
			$db->insert('article_comments', 
						['article_id'=>$this->getArticleID(),
						'user_id'=>$this->getUserID(),
						'comment_author'=>$this->getArticleCommentAuthor(),
						'comment_date'=>$this->getArticleCommentDate(),
						'comment_content'=>$this->getArticleCommentContent()]);
		}
		catch (Exception $e) { echo $e->getMessage(); }
	}

	public function update() 
	{
		try
		{
			$db = Database::getDBI();
			
			$this->setArticleCommentModTime(date('Y-m-d H:i:s', time()));
			
			$db->update('article_comments', ['comment_id'=>$this->getArticleCommentID()],[
				'article_id'=>$this->getArticleID(),
				'user_id'=>$this->getUserID(),
				'comment_author'=>$this->getArticleCommentAuthor(),
				'comment_date'=>$this->getArticleCommentDate(),
				'comment_content'=>$this->getArticleCommentContent(),
				'comment_modTime'=>$this->getArticleCommentModTime(),
				'comment_modName'=>$this->getArticleCommentModName()]);
		}
		catch (Exception $e) { echo $e->getMessage(); }
	}

	public function delete() 
	{
		try
		{
			$db = Database::getDBI();
			
			$db->delete('article_comments', ['comment_id'=>$this->getArticleCommentID()]);
		}
		catch (Exception $e) { echo $e->getMessage(); }
	}

	public function count() 
	{
		try
		{
			$db = Database::getDBI();
			
			$sql = 'SELECT COUNT(comment_id) AS total FROM article_comments WHERE article_id = ?';
			
			$db->query($sql, ['article_id'=>$this->getArticleID()]);
			
			$results = $db->single('arr');
			
			return $results['total'];
		}
		catch (Exception $e) { echo $e->getMessage(); }
	}
}
