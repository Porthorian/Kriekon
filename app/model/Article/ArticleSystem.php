<?php


class ArticleSystem extends Model 
{

	private	$article_system_id,
			$article_system_name,
			$articleSuperCategories = [],
			$recent_articles = [],
			$featured_articles = [];
//----------Getters-----------
	public function getArticleSystemID() { return $this->article_system_id; }
	public function getArticleSystemName() { return $this->article_system_name;}
	public function getArticleSuperCategories() { return $this->articleSuperCategories; }
	public function getRecentArticles() { return $this->recent_articles; }
	public function getFeaturedArticles() { return $this->featured_articles; }
	
//---------Setters-----------
	public function setArticleSystemID($temp_id) { $this->article_system_id = $temp_id; }
	public function setArticleSystemName($temp_name) { $this->article_system_name = $temp_name; }


	public function addArticleSuperCategory($superCategory_id) {
		$this->articleSuperCategories[] = $superCategory_id; 
	}

	public function removeArticleSuperCategory($superCategory_id) {
		try
		{
			$position = array_search($superCategory_id, $this->getArticleSuperCategories());
			
			if($position !== false)
				unset($this->articleSuperCategories[$position]);//Finds the position in the array and removes it.
		}
		catch (Exception $e) {echo $e->getMessage();}
	}
	
	public function fetchArticleSysInfo($article = null)
	{
		try
		{
			$db = Database::getDBI();//Creates DB Instance
			
			if($article == null)
			{
				$sql = 'SELECT * FROM article_system WHERE article_system_id = ?';
				$db->query($sql, array($this->getArticleSystemID()));
			} elseif (is_int($article))
			{
				$sql = 'SELECT * FROM article_system WHERE article_system_id = ?';
				$db->query($sql, array($article));
			} elseif (is_string($article))
			{
				$sql = 'SELECT * FROM article_system WHERE article_system_name = ?';
				$db->query($sql, array($article));
			}
			
			//Grabs the Article System Table From the database HA
			$results = $db->single();
			
			
			//Set the attributes.
			$this->setArticleSystemID($results->article_system_id);
			$this->setArticleSystemName($results->article_system_name);
			
		}
		catch (Exception $e){echo $e->getMessage();}
	}
	
	public function fetchArticleSuperCategories()
	{
		try
		{
			$db = Database::getDBI();
			
			$sql = 'SELECT article_superCat_id FROM article_superCategory WHERE article_system_id = ?';
			$db->query($sql, array($this->getArticleSystemID()));
			$results = $db->results('arr');
			
			foreach ($results as $article_SuperCat)
				$this->articleSuperCategories[] = $article_SuperCat['article_superCat_id'];
		}
		catch (Exception $e){ echo $e->getMessage(); }
	}
	public function addRecentArticle($article_id)
	{
		$this->recent_articles[] = $article_id;
	}
	
	public function removeRecentArticle($article_id)
	{
		try
		{
			$position = array_search($article_id, $this->getRecentArticles());
			
			if($position !== false)
				unset($this->recent_articles[$position]);
		}
		catch (Exception $e) { echo $e->getMessage(); }
	}
	
	public function fetchRecentArticles() //Fetches Recent Articles basaed on Date and Time.
	{
		try
		{
			$db = Database::getDBI();
			
			$sql = 'SELECT article.article_id 
				FROM article_system article_system
					JOIN article_supercategory article_supercategory
						ON article_supercategory.article_system_id = article_system.article_system_id
					JOIN articles article
						ON article.article_superCat_id = article_supercategory.article_superCat_id
					WHERE article_system.article_system_id = ?
					ORDER BY article.article_date DESC
					LIMIT 14';
			
			$db->query($sql, array($this->getArticleSystemID()));
			
			$results = $db->results('arr');
			
			foreach ($results as $article)
				$this->addRecentArticle($article['article_id']);
		}
		catch (Exception $e) { echo $e->getMessage(); }
	}
	
	public function addFeaturedArticles($article_id)
	{
		$this->featured_articles[] = $article_id;
	}
	
	public function removeFeaturedArticles($article_id)
	{
		try
		{
			$position = array_search($article_id, $this->getFeaturedArticles());
			
			if($position !== false)
				unset($this->featured_articles[$position]);
		}
		catch (Exception $e) { echo $e->getMessage(); }
	}
	
	public function fetchFeaturedArticles() //Fetches Recent Articles basaed on Date and Time.
	{
		try
		{
			$db = Database::getDBI();
			
			$sql = 'SELECT article.article_id 
				FROM article_system article_system
					JOIN article_supercategory article_supercategory
						ON article_supercategory.article_system_id = article_system.article_system_id
					JOIN articles article
						ON article.article_superCat_id = article_supercategory.article_superCat_id
					WHERE article_system.article_system_id = ? AND article.featured = 1
					ORDER BY article.article_date DESC
					LIMIT 6';
			
			$db->query($sql, array($this->getArticleSystemID()));
			
			$results = $db->results('arr');
			
			foreach ($results as $article)
				$this->addFeaturedArticles($article['article_id']);
		}
		catch (Exception $e) { echo $e->getMessage(); }
	}
	
	public function create()
	{
		try
		{
			$db = Database::getDBI();
			$db->insert('article_system', ['article_system_name'=>$this->getArticleSystemID()]); //Inserts a new row into the article_system table, and grabs the 
		}
		catch (Exception $e) { echo $e->getMessage(); }
		
	}
	
	public function update()
	{
		try
		{
			$db = Database::getDBI();
			
			$db->update('article_system',
					['article_system_id'=>$this->getArticleSystemID()], 
					['article_system_name'=>$this->getArticleSystemName()]); //Updates the article_system table where the row is = article_system_id
		} catch (Exception $e){ echo $e->getMessage(); }
	}
	
	/*public function delete() Function is not needed
	{
		try
		{
			$db = Database::getDBI(); //Create Database Instance
			
			$db->delete('article_system', ['article_system_id'=>$this->getArticleSystemID()]); //Deletes the Article System Row inside the Database that is attached to the ID
		} catch (Exception $e) { echo $e->getMessage();}
	}*/
	
}
