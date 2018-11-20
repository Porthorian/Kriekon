<?php

class Article extends Model
{

	private
		$article_id,
		$user_id,
		$article_superCat_id,
		$article_superCat_name,
		$tag_id,
		$tag_name,
		$article_title,
		$article_modTime,
		$article_modName,
		$article_date,
		$article_author,
		$article_content,
		$article_summary,
		$article_comments = [],
		$article_tags = [],
		$article_image, //This allows us to store the file path to the image on the server. So it can find the image on it. Do we wanna store multiple images? if so we might have to make this an array....
		$article_upvotes,
		$article_downvotes,
		$article_score,
		$upvote_downvote_time,
		$article_frequency,
		$article_trending_system_id,
		$article_trending,
		$article_trendingPriority;
	
	//-------------------Getters-----------------------
	public function getArticleID() { return $this->article_id; }
	public function getUserID() { return $this->user_id; }
	public function getArticleSuperCategoryID() { return $this->article_superCat_id; }
	public function getArticleSuperCategoryName() { return $this->article_superCat_name; }
	public function getArticleTagID() { return $this->tag_id; }
	public function getArticleTagName() { return $this->tag_name; }
	public function getArticleTitle() { return $this->article_title; }
	public function getArticleDate() { return $this->article_date; }
	public function getArticleModTime() { return $this->article_modTime; }
	public function getArticleModName() { return $this->article_modName; }
	public function getArticleAuthor() { return $this->article_author; }
	public function getArticleContent() { return $this->article_content; }
	public function getArticleSummary() { return $this->article_summary; }
	public function getArticleComments() { return $this->article_comments; }
	public function getArticleTags() { return $this->article_tags; }
	public function getArticleImage() { return $this->article_image; }
	public function getArticleTrendingSystemID() { return $this->article_trending_system_id; }
	public function getArticleUpvotes() { return $this->article_upvotes; }
	public function getArticleDownvotes() { return $this->article_downvotes; }
	public function getArticleScore() { return $this->article_score; }
	public function getArticlefrequency() { return $this->article_frequency; }
	public function getUpvoteDownvoteTime() { return $this->upvote_downvote_time; }
	
	public function getArticleArray()
	{
		$newDateFormat = new DateTime($this->getArticleDate());
		$date = $newDateFormat->format('Y-m-d');
		
		$user = new User();
		$user = $user->fetchUserInfo($this->getUserID());
		
		$articleArray = array('article_id'=>$this->getArticleID(),
							 'user'=>$user->getUserArray(),
							 'article_title'=>$this->getArticleTitle(),
							 'article_content'=>$this->getArticleContent(),
							 'article_date'=>Functions::getDateArray($this->getArticleDate()),
							 'article_modTime'=>$this->getArticleModTime(),
							 'article_modName'=>$this->getArticleModName());
		
		return $articleArray;
	}
	//----------------Setters--------------
	public function setArticleID($temp_id) { $this->article_id = $temp_id; }
	public function setUserID($temp_id) { $this->user_id = $temp_id; }
	public function setArticleSuperCategoryID($temp_id) { $this->article_superCat_id = $temp_id; }
	public function setArticleSuperCategoryName($temp_name) { $this->article_superCat_name = $temp_name; }
	public function setArticleTagID($temp_id) { $this->tag_id = $temp_id; }
	public function setArticleTagName($temp_name) { $this->tag_name = $temp_name; }
	public function setArticleTitle($temp_title) { $this->article_title = $temp_title; }
	public function setArticleDate($temp_date) { $this->article_date = $temp_date; }
	public function setArticleModTime($temp_date) { $this->article_modTime = $temp_date; }
	public function setArticleModName($temp_name) { $this->article_modName = $temp_name; }
	public function setArticleAuthor($temp_author) { $this->article_author = $temp_author; }
	public function setArticleContent($temp_content) { $this->article_content = $temp_content; }
	public function setArticleSummary($temp_content) { $this->article_summary = $temp_content; }
	public function setArticleComments($temp_comments) { $this->article_comments = $temp_comments; }
	public function setArticleTags($temp_id) { $this->article_tags = $temp_id; }
	public function setArticleImage($temp_image) { $this->article_image = $temp_image; }
	public function setArticleUpvotes($temp_upvotes) { $this->article_upvotes = $temp_upvotes; }
	public function setArticleDownvotes($temp_downvotes) { $this->article_downvotes = $temp_downvotes; }
	
	//---------------------End of Setters & Getters-------------------

	
	public function fetchArticleInfo($id = null)
	{
		try
		{
			$db = Database::getDBI();
			
				$sql = 'SELECT articles.article_id, articles.article_superCat_id, article_supercategory.article_superCat_name, user_id,
				article_author, article_title, article_content, SUBSTRING(article_content, 1, 140) AS article_summary, article_date, article_modTime, article_modName 
				FROM articles
					JOIN article_supercategory
						ON article_supercategory.article_superCat_id = articles.article_superCat_id
					WHERE articles.article_id = ?';
				
				if($id != null)
					$db->query($sql, array($id));
				else
					$db->query($sql, array($this->getArticleID()));
			
			
			
			$results = $db->single();
			
			if($results != false) //Assigning Results to object variables.
			{
				$this->setArticleID($results->article_id);
				$this->setArticleSuperCategoryID($results->article_superCat_id);
				$this->setArticleSuperCategoryName($results->article_superCat_name);
				$this->setUserID($results->user_id);
				$this->setArticleAuthor($results->article_author);
				$this->setArticleTitle($results->article_title);
				$this->setArticleContent($results->article_content);
				$this->setArticleSummary($results->article_summary);
				$this->setArticleModTime($results->article_modTime);
				$this->setArticleModName($results->article_modName);
				$this->setArticleDate($results->article_date);
			}
		}
		catch (Exception $e) { echo $e->getMessage(); }
	}
	
	public function fetchArticleTag($id = null)
	{
		$db = Database::getDBI();
		
		$sql = 'SELECT article_tags.tag_id, article_tags.tag_name  
				FROM article_tags
					JOIN article_tag_link
						ON article_tag_link.tag_id = article_tags.tag_id
					WHERE article_tag_link.article_id = ?
					ORDER BY article_tags.tag_id ASC
					LIMIT 1';
		
		if($id != null)
			$db->query($sql, array($id));
		else
			$db->query($sql, array($this->getArticleID()));
		
		$results = $db->single();
		
		if($results != false)
		{
			$this->setArticleTagID($results->tag_id);
			$this->setArticleTagName($results->tag_name);
		}
	}
	
	public function addArticleTag($id) 
	{
		$this->article_tags[] = $id;
	}

	public function removeArticleTag($id) 
	{
		$position = array_search($id, $this->getArticleTags());
		
		if($position !== false)
			unset($this->article_tags[$position]);
	}
	
	public function fetchArticleTags($id)
	{
		try
		{
			$db = Database::getDBI();
		
			$sql = 'SELECT article_tags.tag_id
					FROM article_tags
						JOIN article_tag_link
							ON article_tag_link.tag_id = article_tags.tag_id
						WHERE article_tag_link.article_id = ?
						ORDER BY article_tags.tag_id ASC';

			$db->query($sql, array($id));

			$result = $db->results('arr');

			foreach($result as $tag_id)
				$this->addArticleTag($tag_id['tag_id']);
		}
		catch (Exception $e) { echo $e->getMessage(); }
	}
	
	
	public function addArticleComment($id) 
	{
		$this->article_comments[] = $id;
	}

	public function removeArticleComment($id) 
	{
		$position = array_search($id, $this->getArticleComments());
		
		if($position !== false)
			unset($this->article_comments[$position]);
	}
	
	public function fetchArticleComments($id, $page_number, $per_page)
	{
		try
		{
			$db = Database::getDBI();
			
			if(empty($page_number))
				$page_number = 0;
			
			$sql = 'SELECT COUNT(comment_id) AS total from article_comments WHERE article_id = ?';
			
			$db->query($sql,['article_id'=>$id]);
			$results = $db->single();
			
			if($results->total > 0)
			{
				$sql = 'SELECT comment_id FROM article_comments WHERE article_id = ? ORDER BY comment_date LIMIT '.($page_number - 1) * $per_page.', '.$per_page;
				
				$db->query($sql,['article_id'=>$id]);
				$results = $db->results('arr');
			}
			
			foreach ($results as $comment)
				$this->addArticleComment($comment['comment_id']);
		}
		catch (Exception $e) { echo $e->getMessage(); }
	}
	
	
	public function featureArticle() //Will allow the editor to select which articles they want to feature via admin panel.
	{
		$db = Database::getDBI();
	}
	
	public function create() //Creates the article with the information the user provides the function.
	{
		try
		{
			$db = Database::getDBI(); //Creates DB Instances.
			
			$this->setArticleDate(date('Y-m-d H:i:s', time()));
			
			$db->insert('articles',[
				'user_id'=>$this->getUserID(),
				'article_superCat_id'=>$this->getArticleSuperCategoryID(),
				'article_title'=>$this->getArticleTitle(),
				'article_date'=>$this->getArticleDate(),
				'article_author'=>$this->getArticleAuthor(),
				'article_content'=>$this->getArticleContent()
				]);
		} 
		catch (Exception $e) { echo $e->getMessage(); } //Grabs error message if any.
	}
	
	public function update() //Updates the articles that are provided by the user.
	{
		try
		{
			$db = Database::getDBI(); //Creates DB Instances.
			
			$this->setArticleModTime(date('Y-m-d H:i:s', time())); //Puts the time into a timestamp that is accepted by SQL.
			
			$db->update('articles', ['article_id'=>$this->getArticleID()],
				 ['user_id'=>$this->getUserID(),
				 'tag_name'=>$this->getTagName(),
				 'article_title'=>$this->getArticleTitle(),
				 'article_modTime'=>$this->getArticleModDate(),
				 'article_modName'=>$this->getArticleModName(),
				 'article_content'=>$this->getArticleContent()]); //Update SQL statement that updates the row with user information.
		}
		catch (Exception $e) { echo $e->getMessage(); } //grabs error messasge if any.
	}
	
	public function delete() //Deletes the SQL row. aka deletes the article
	{
		try
		{
			$db = Database::getDBI();
			
			$db->delete('articles', ['article_id'=>$this->getArticleID()]);
		}
		catch (Exception $e) { echo $e->getMessage(); }
	}
	public function count() //Counts how many articles are in the db
	{
		try
		{
			$db = Database::getDBI();
			
			$sql = 'SELECT COUNT(article_id) AS total FROM articles WHERE article_superCat_id = ?';
			$db->query($sql, ['article_superCat_id'=>$this->getArticleSuperCategoryID()]);
			
			$results = $db->single('arr');
			
			return $results['total'];
		}
		catch (Exception $e){ echo $e->getMessage(); }			
	}
	
	private function _score($article_upvotes, $article_downvotes)
	{
		return $article_upvotes - $article_downvotes;
	}
	private function _hotness($article_upvotes, $article_downvotes, $upvote_downvote_time)
	{
		$newDateFormat = new DateTime($this->getUpvoteDownvoteTime());
		$time = $newDateFormat->format('Y-m-d H:i:s');
	}
	public function getScore($article_upvotes, $article_downvotes)
	{
		return ($article_upvotes + $article_downvotes) / max(abs($this->_score()));
	}

	public function increaseArticleUpvotes()//Trending system functions will go in here. and below 
	{
		$db = Database::getDBI();
		
		$sql = 'SELECT * FROM article_trending_system WHERE user_id = ? AND article_id = ?';
		$db->query($sql, array($user_id, $article_id));
		$results = $db->single('arr');
		
		if($results == false)
		{
			$this->article_upvotes += $amount;
			$db->insert('article_trending_system', ['upvote'=>1,'article_id'=>$article_id, 'user_id'=>$user_id]);
		}
		else
		{
			if($results['upvotes'] == 0)
			{
				$this->article_upvotes += $amount;
				$db->update('article_trending_system', ['article_trending_system_id'=>$results['article_trending_system_id']],['upvote'=>1]);
			} 
			elseif($results['upvote'] == 1 && $results['downvote'] == 0)
			{
				$this->article_upvotes -= $amount;
				$db->delete('article_trending_system', ['article_trending_system_id'=>$results['article_trending_system_id']]);
			}
			elseif ($results['upvote'] == 1 && $results['downvote'] == 1)
			{
				$this->article_upvotes -= $amount;
				$db->update('article_trending_system', ['article_trending_system_id'=>$results['article_trending_system_id']], ['upvote'=>0]);
			}
		}
	}

	public function decreaseArticleUpvotes() 
	{
		$db = Database::getDBI();
	}

	public function increaseArticleDownvotes() 
	{
		$db = Database::getDBI();
	}

	public function decreaseArticleDownvotes() 
	{
		$db = Database::getDBI();
	}
	public function frequency()
	{
		$db = Database::getDBI();
	}
		
}
