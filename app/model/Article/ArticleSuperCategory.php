<?php

class ArticleSuperCategory extends Model
{

	private	$article_superCat_id,
			$article_system_id,
			$article_superCat_name,
			$supercategory_articles = [],
			$featured_article = [];

	//--------------Getters ------------
	public function getArticleSystemID() { return $this->article_system_id; }
	public function getArticleSuperCategoryID() { return $this->article_superCat_id; }
	public function getArticleSuperCategoryName() { return $this->article_superCat_name; }
	public function getSuperCatArticles() { return $this->supercategory_articles; }
	public function getFeaturedArticle() { return $this->featured_article; }
	//------------End of Getters--------
	//----------Setters-------------
	public function setArticleSystemID($temp_id) { $this->article_system_id = $temp_id; }
	public function setArticleSuperCategoryID($temp_id) { $this->article_superCat_id = $temp_id; } //Takes the Parameter and stores it into the superCat_id
	public function setArticleSuperCategoryName($temp_name) { $this->article_superCat_name = $temp_name; } //Takes the Parameter and stores into the superCat_Name
	public function setFeaturedArticle($temp_id) { $this->featured_article = $temp_id; }
	//--------------End of Setters---------

	
	
	public function addSuperCatArticles($article_id)
	{
		$this->supercategory_articles[] = $article_id;
	}
	
	public function removeSuperCatArticles($article_id)
	{
		try
		{
			$position = array_search($article_id, $this->getSuperCatArticles());
			
			if($position !== false)
				unset($this->supercategory_articles[$position]);
		}
		catch(Exception $e) { echo $e->getMessage(); }
	}
	
	public function fetchArticleSuperCatInfo($id = null)
	{
		try
		{
			$db = Database::getDBI();
			$sql = 'SELECT * FROM article_supercategory WHERE article_superCat_id = ?';
			
			if($id != null)
			{
				$db->query($sql, array($id));
			}
			else
			{
				$db->query($sql, array($this->article_system_id));
			}
			
			$results = $db->single();
			
			$this->setArticleSystemID($results->article_system_id);
			$this->setArticleSuperCategoryID($results->article_superCat_id);
			$this->setArticleSuperCategoryName($results->article_superCat_name);
			
		}
		catch (Exception $e){ echo $e->getMessage(); } //Catch's and Returns Error Messsage.
	}
	
	public function fetchSuperCatArticles($limit = null)
	{
		try
		{
			$db = Database::getDBI();
			
			if($limit != null)
			{
				$sql = 'SELECT article.article_id 
						FROM articles article
						JOIN article_supercategory article_super
							ON article_super.article_superCat_id = article.article_superCat_id
						WHERE article_super.article_superCat_id = ?
						ORDER BY article.article_date DESC
						LIMIT '.$limit;
			}
			else
			{
				$sql = 'SELECT article.article_id 
						FROM articles article
						JOIN article_supercategory article_super
							ON article_super.article_superCat_id = article.article_superCat_id
						WHERE article_super.article_superCat_id = ?
						ORDER BY article.article_date DESC';
			}
			
			$db->query($sql, array($this->getArticleSuperCategoryID()));
			$results = $db->results('arr');
			
			foreach($results as $article_id)
				$this->addSuperCatArticles($article_id['article_id']);
		}
		catch(Exception $e) { echo $e->getMessage(); }
	}
	
	public function addFeaturedArticle($article_id) 
	{
		$this->featured_article[] = $article_id;
	}

	public function removeFeaturedArticle($article_id) 
	{
		try
		{
			$positon = array_search($article_id, $this->getFeaturedArticle());
			
			if($position !== false)
				unset($this->featured_article[$position]);
		}
		catch (Exception $e){echo $e->getMessage();} //CATCH ME IF YOU CAN! Returns Error Message
	}
	
	public function fetchFeaturedArticle()
	{
		try
		{
			$db = Database::getDBI();
			
			$sql = 'SELECT article.article_id
					FROM articles article
					JOIN article_supercategory
						ON article_supercategory.article_superCat_id = article.article_superCat_id
					WHERE article.featured = 1 AND article_supercategory.article_superCat_id = ?
					ORDER BY article.article_date DESC
					LIMIT 1';
			
			$db->query($sql, array($this->getArticleSuperCategoryID()));
			
			$result = $db->results('arr');
			
			foreach($result as $article_id)
				$this->addFeaturedArticle($article_id['article_id']);
		}
		catch (Exception $e) { echo $e->getMessage(); }
	}

	public function create() 
	{
		try
		{
			$db = Database::getDBI();
			
			$db->insert('article_supercategory', ['article_superCat_name'=>$this->getArticleSuperCategoryName(), 
												  'article_system_id'=>$this->getArticleSystemID()]);
		}
		catch (Exception $e) { echo $e->getMessage(); }
	}

	public function update() 
	{
		try
		{
			$db = Database::getDBI();
			
			$db->update('article_supercategory', 
						['article_superCat_id'=>$this->getArticleSuperCategoryID()], 
						['article_superCat_name'=>$this->getArticleSuperCategoryName()], 
						['article_system_id'=>$this->getArticleSystemID()]
					   );
		}
		catch (Exception $e) { echo $e->getMessage();}
	}

	public function delete() 
	{
		try
		{
			$db = Database::getDBI();
			
			$db->delete('article_supercategory', ['article_superCat_id'=>$this->getArticleSuperCategoryID]);
		}
		catch (Exception $e) { echo $e->getMessage(); }
	}

	public function count() 
	{	
		try
		{
			$db = Database::getDBI();
			
			$sql = 'SELECT COUNT(article_superCat_id) AS total FROM article_supercategory WHERE article_system_id = ?';
			
			$results = $db->single('arr');
			
			return $results['total'];
		}
		catch (Exception $e) { echo $e->getMessage();}
	}
}
