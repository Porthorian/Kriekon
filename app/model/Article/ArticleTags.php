<?php

class ArticleTags 
{
	private $article_id,
		$tag_id,
		$tag_name,
		$tag_articles = [];
	
	public function getArticleID() { return $this->article_id; }
	public function getTagID() { return $this->tag_id; }
	public function getTagName() { return $this->tag_name; }
	public function getTagArticles() { return $this->tag_articles; }
	
	
	public function setArticleID($temp_id) { $this->article_id = $temp_id; }
	public function setTagID($temp_id) { $this->tag_id = $temp_id; }
	public function setTagName($temp_name) { $this->tag_name = $temp_name; }
	
	
	public function fetchTagInfo($id = null)
	{
		try
		{
			$db = Database::getDBI();
		
			if($id == null)
			{
				$sql = 'SELECT * FROM article_tags WHERE tag_id = ?';
				$db->query($sql, array($this->getTagID()));
			}
			elseif(is_string($id))
			{
				$sql = 'SELECT * FROM article_tags WHERE tag_name = ?';
				$db->query($sql, array($id));
			}
			elseif(is_int($id))
			{
				$sql = 'SELECT * FROM article_tags WHERE tag_id = ?';
				$db->query($sql, array($id));
			}
				
			
			$results = $db->single();

			if($results != false)
			{
				$this->setTagID($results->tag_id);
				$this->setTagName($results->tag_name);
			}
		}
		catch (Exception $e) { echo $e->getMessage(); }
	}
	public function tagNameExists($tag_name)
	{
		try
		{
			$db = Database::getDBI();
			
			$sql = 'SELECT tag_id FROM article_tags WHERE tag_name = ?';
			$db->query($sql, array($tag_name));
			
			$result = $db->single();
			
			if($result != false)
			{
				$this->setTagID($result->tag_id); //Sets the tag_id of the existing tag_name
				return true;
			}
			elseif($result == null) //If result returns null it then returns false. Aka no tag_name exists.
				return false;
		}
		catch (Exception $e) { echo $e->getMessage(); }
	}
	public function selectTagID($tag_name)
	{
		try
		{
			$db = Database::getDBI();
			
			$sql = 'SELECT tag_id FROM article_tags WHERE tag_name = ?';
			$db->query($sql, array($tag_name));
			
			$result = $db->single();

			if($result != false)
			{
				$this->setTagID($result->tag_id);
			}
		}
		catch (Exception $e) { echo $e->getMessage(); }
	}
	
	public function addTagArticles($article_id)
	{
		$this->tag_articles[] = $article_id;
	}
	
	public function removeTagArticles($article_id)
	{
		$position - array_search($name, $this->getTagArticles());
		
		if($position !== false)
			unset($this->tag_articles[$position]);
	}
	
	public function fetchTagArticles()
	{
		try
		{
			$db = Database::getDBI();
			
			$sql = 'SELECT articles.article_id FROM articles 
				JOIN article_tag_link
					ON article_tag_link.article_id = articles.article_id
				JOIN article_tags
					ON article_tags.tag_id = article_tag_link.tag_id
				WHERE article_tag_link.tag_id = ?
				ORDER BY articles.article_date DESC';
				
			$db->query($sql, array($this->getTagID()));
			
			$results = $db->results('arr');
			
			foreach($results as $article)
				$this->addTagArticles($article['article_id']);
			
		}
		catch (Exception $e) { echo $e->getMessage(); }
	}
	
	public function getLastInsertTagID()
	{
		$db = Database::getDBI();
		
		$sql = 'SELECT tag_id FROM article_tags ORDER BY tag_id DESC LIMIT 1';
		
		$db->query($sql);
		
		$result = $db->single('arr');
		
		return $result['tag_id'];
	}
	public function createArticleTag()
	{
		try
		{
			$db = Database::getDBI();
			
			$db->insert('article_tags',[
				'tag_name'=>$this->getTagName(),
				]);
		}
		catch (Exception $e) { echo $e->getMessage(); }
	}
	
	public function createArticleTagLink()
	{
		try
		{
			$db = Database::getDBI();
			
			$db->insert('article_tag_link',[
				'tag_id'=>$this->getTagID(),
				'article_id'=>$this->getArticleID()
				]);
		}
		catch (Exception $e) { echo $e->getMessage(); }
	}
}