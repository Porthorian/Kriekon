<?php

/**
* 
*/
class Dashboard extends Model
{

	public function getAllUsers($page_number = null, $per_page = null)
	{
		$db = Database::getDBI();

		if($page_number = null && $per_page = null)
		{
			$sql = 'SELECT * FROM users ORDER BY user_username ASC';
		} else {
			$sql = 'SELECT * FROM users LIMIT '.($page_number - 1) * $per_page .', '.$per_page;
		}

		$db->query($sql);
		$results = $db->results('arr');
		$i = 0;
		foreach ($results as $user) {
			$results[$i]['tags'] = [];
			$sql = 'SELECT tags.tag_name FROM tags JOIN tag_user ON tag_user.tag_id = tags.tag_id WHERE tag_user.user_id = ?';
			$db->query($sql, ['user_id'=>$user['user_id']]);
			$tag_results = $db->results('arr');
			foreach ($tag_results as $tag) {
				array_push($results[$i]['tags'], $tag['tag_name']);
			}
			$i++;
		}

		return $results;
	}

	public function countUsers()
	{
		$db = Database::getDBI();

		$sql = 'SELECT COUNT(user_id) AS total FROM users';
		$db->query($sql);
		$results = $db->single();

		return $results->total;
	}

	public function getTopPosters($duration = null, $interval = null, $limit = null)
	{
		$db = Database::getDBI();

		if($duration == null)
		{
			$duration = 900;
		}

		if($interval == null)
		{
			$interval = 'YEAR';
		}

		if($limit == null)
		{
			$limit = 5;
		}

		$sql = 'SELECT DISTINCT users.user_username,
			    (SELECT COUNT(*) 
					FROM forum_thread 
			        WHERE users.user_id = forum_thread.user_id 
			        AND thread_date BETWEEN date_sub(now(),INTERVAL '.$duration.' '.$interval.') and now())
			    AS total FROM users ORDER BY total DESC LIMIT '.$limit.';';
		$db->query($sql);

		return $db->results('arr');
	}
	
	//Article Code
	
	public function getAllArticles($page_number = null, $per_page = null)
	{
		$db = Database::getDBI();
		
		if($page_number = null && $per_page = null)
		{
			$sql = 'SELECT article_id, article_title, article_date, article_supercategory.article_superCat_name, SUBSTRING(article_content, 1, 120) AS article_content, article_author, featured, upvotes, downvotes 
				FROM articles 
				JOIN article_supercategory
					ON articles.article_superCat_id = article_supercategory.article_superCat_id
				ORDER BY article_date DESC';
		} else {
			$sql = 'SELECT article_id, article_title, article_date, article_supercategory.article_superCat_name, SUBSTRING(article_content, 1, 120) AS article_content, article_author, featured, upvotes, downvotes 
				FROM articles 
				JOIN article_supercategory
					ON articles.article_superCat_id = article_supercategory.article_superCat_id
				ORDER BY article_date DESC
				LIMIT '.($page_number - 1) * $per_page .', '.$per_page;
		}
		
		$db->query($sql);
		$results = $db->results('arr');
		
		$i = 0;
		foreach ($results as $article) {
			$results[$i]['tags'] = [];
			$sql = 'SELECT article_tags.tag_name FROM article_tags 
				JOIN article_tag_link 
					ON article_tag_link.tag_id = article_tags.tag_id 
				WHERE article_tag_link.article_id = ?';
			$db->query($sql, ['article_id'=>$article['article_id']]);
			$tag_results = $db->results('arr');
			foreach ($tag_results as $tag) {
				array_push($results[$i]['tags'], $tag['tag_name']);
			}
			$i++;
		}
		
		return $results;
	}
	public function countArticles()
	{
		$db = Database::getDBI();

		$sql = 'SELECT COUNT(article_id) AS total FROM articles';
		$db->query($sql);
		$results = $db->single();

		return $results->total;
	}

}


?>