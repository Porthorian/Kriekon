<?php
//Reddit Ranking System
//https://github.com/reddit/reddit/blob/master/r2/r2/lib/db/_sorts.pyx
//Converted to php from python

class TrendingSystem extends Model
{

    /*
     * Example:
     *
     * $trendingSystem = new TrendingSystem; 
     * OR
     * $trendingSystem = $this->model('TrendingSystem');
     * Then
     * 
     * For confident (popular) articles:
     * $trendingSystem->fetchConfidentArticles();
     * $confidentArticles = $trendingSystem->getConfidentArticles();
     * 
     * For hot (trending) articles:
     * $trendingSystem->fetchHotArticles();
     * $hotArticles = $trendingSystem->getHotArticles();
     *
     * Then run a foreach on the variables above and use them as objects since 
     * the article object is stored in the array.
     * 
     */


    private $hot_posts = [],
            $confident_posts = [];

    public function getHotPosts() { return $this->hot_posts; }
    public function getConfidentPosts() { return $this->confident_posts; }
	
	public function addHotPosts($id)
	{
		$this->hot_posts[] = $id;
	}
	public function addConfidentPosts($id)
	{
		$this->confident_posts[] = $id;
	}
	public function getUpvotes($thread_id)
	{
		try {
			$db = Database::getDBI();
			
			$sql = 'SELECT SUM(upvoted) AS upvotes FROM forum_upvote_downvote WHERE thread_id = ?';
			$db->query($sql, array($thread_id));
			$result = $db->single('arr');
			$upvotes = 0;
			if($result['upvotes'] == 0)
			{
				return $upvotes;
			}
			else
			{
				$upvotes = $result['upvotes'];
				return $upvotes;
			}
		} catch(Exception $e) { echo $e->getMessage(); }
	}
	
	public function getDownvotes($thread_id)
	{
		try {
			$db = Database::getDBI();
			
			$sql = 'SELECT SUM(downvoted) AS downvotes FROM forum_upvote_downvote WHERE thread_id = ?';
			$db->query($sql, array($thread_id));
			$result = $db->single('arr');
			$downvotes = 0;
			if($result['downvotes'] == 0)
			{
				return $downvotes;
			}
			else
			{
				$downvotes = $result['downvotes'];
				return $downvotes;
			}
		} catch(Exception $e) { echo $e->getMessage(); }
	}
	
	public function getScore($thread_id)
	{
		$upvotes = $this->getUpvotes($thread_id);
		$downvotes = $this->getDownvotes($thread_id);
		
		$score = $upvotes - $downvotes;
			
		return $score;
	}
	
	//TO DO REWORK ALGORITHIMS. These Algorithims do not obtain what I want at all, now that I think about it.
    public function fetchConfidentArticles()
    {
        // Getting Confidence
        // Getting what is popular.
        $db = Database::getDBI();

        $sql = 'SELECT article_id, ((upvotes + 1.920 / (upvotes + downvotes) - 
                   1.96 * SQRT((upvotes * downvotes) / (upvotes + downvotes) + 0.9604) / 
                          (upvotes + downvotes)) / (1 + 3.8416 / (upvotes + downvotes))) 
            AS confidence 
            FROM articles 
            WHERE upvotes + downvotes > 0 
            ORDER BY confidence DESC';

        $db->query($sql);
        $results = $db->results('arr');

        foreach ($results as $article) {
            $this->addConfidentPosts($article['article_id']);
        }
    }

    public function fetchHotArticles()
    {
        // Getting Hotness
        // Getting what is trending.
        $db = Database::getDBI();

        $sql = 'SELECT article_id
            FROM articles
            ORDER BY
                LOG10( ABS( upvotes-downvotes) + 1 ) *
                SIGN( upvotes - downvotes ) + 
                ( UNIX_TIMESTAMP ( article_date ) / 300000 ) DESC
            LIMIT 100';

        $db->query($sql);
        $results = $db->results('arr');

        foreach ($results as $article) {
            $this->addHotPosts($article['article_id']);
        }
    }
	
	public function fetchConfidentThreads()
    {
        // Getting Confidence
        // Getting what is popular.
        $db = Database::getDBI();

        $sql = 'SELECT thread_id, ((getUpvotes(thread_id) + 1.920 / (getUpvotes(thread_id) + getDownvotes(thread_id)) - 
                   1.96 * SQRT((getUpvotes(thread_id) * getDownvotes(thread_id)) / (getUpvotes(thread_id) + getDownvotes(thread_id)) + 0.9604) / 
                          (getUpvotes(thread_id) + getDownvotes(thread_id))) / (1 + 3.8416 / (getUpvotes(thread_id) + getDownvotes(thread_id)))) 
            AS confidence 
            FROM forum_thread 
            WHERE getUpvotes(thread_id) + getDownvotes(thread_id) > 0 
            ORDER BY confidence DESC';

        $db->query($sql);
        $results = $db->results('arr');

        foreach ($results as $thread) {
            $this->addConfidentPosts($thread['thread_id']);
        }
    }

    public function fetchHotThreads($limit = null, $limit_offset = null)
    {
        // Getting Hotness
        // Getting what is trending.
        $db = Database::getDBI();

        if($limit == null && $limit_offset == null)
		{
			$sql = 'SELECT thread_id FROM forum_thread 
			ORDER BY 
				LOG10( ABS(getUpvotes(thread_id)  - getDownvotes(thread_id)) + 1 ) * SIGN( getUpvotes(thread_id) - getDownvotes(thread_id) ) + 
                ( UNIX_TIMESTAMP ( thread_date ) / 300000 ) DESC
            LIMIT 100';
		}
		else
		{
			$sql = 'SELECT thread_id FROM forum_thread 
			ORDER BY 
				LOG10( ABS(getUpvotes(thread_id)  - getDownvotes(thread_id)) + 1 ) * SIGN( getUpvotes(thread_id) - getDownvotes(thread_id) ) + 
                ( UNIX_TIMESTAMP ( thread_date ) / 300000 ) DESC
            LIMIT ' . $limit_offset . ', ' . $limit;
		}

        $db->query($sql);
        $results = $db->results('arr');

        foreach ($results as $thread) {
            $this->addHotPosts($thread['thread_id']);
        }
    }

	public function increaseUpvotes($user_id, $thread_id = null, $article_id = null) 
	{
		$db = Database::getDBI();
		
		if($thread_id != null)
		{
			$sql = 'SELECT * FROM forum_upvote_downvote WHERE user_id = ? AND thread_id = ?';
			$db->query($sql, array($user_id, $thread_id));
		}
		else
		{
			$sql = 'SELECT * FROM article_upvote_downvote WHERE user_id = ? AND article_id = ?';
			$db->query($sql, array($user_id, $article_id));
		}
		
		$result = $db->single('arr');
		if($result == false){
			if($thread_id != null)
				$db->insert('forum_upvote_downvote', ['upvoted'=>1,'user_id'=>$user_id, 'thread_id'=>$thread_id, 'upvote_downvote_time'=>date('Y-m-d H:i:s', time())]);
			else
				$db->insert('article_upvote_downvote', ['upvoted'=>1, 'user_id'=>$user_id, 'article_id'=>$article_id, 'upvote_downvote_time'=>date('Y-m-d H:i:s', time())]);
		} else {
			if($thread_id != null)
			{
				if($result['upvoted'] == 0)
				{
					$db->update('forum_upvote_downvote', ['upvote_downvote_id'=>$result['upvote_downvote_id']], ['upvoted'=>1, 'downvoted'=>0, 'upvote_downvote_time'=>date('Y-m-d H:i:s', time())]);
				} elseif ($result['upvoted'] == 1 && $result['downvoted'] == 0){
					$db->delete('forum_upvote_downvote', ['upvote_downvote_id'=>$result['upvote_downvote_id']]);
				}
			}
			else
			{
				if($result['upvoted'] == 0)
				{ 
					$db->update('article_upvote_downvote', ['upvote_downvote_id'=>$result['upvote_downvote_id']], ['upvoted'=>1]);
				} elseif ($result['upvoted'] == 1 && $result['downvoted'] == 0){
					$db->delete('article_upvote_downvote', ['upvote_downvote_id'=>$result['upvote_downvote_id']]);
				} elseif ($result['upvoted'] == 1 && $result['downvoted'] == 1){
					$db->update('article_upvote_downvote', ['upvote_downvote_id'=>$result['upvote_downvote_id']], ['upvoted'=>0]);
				}
			}
		}
	}

	public function checkUpvotes($user_id, $thread_id = null, $article_id = null)
	{
		$db = Database::getDBI();
		if($thread_id != null)
		{
			$sql = 'SELECT upvote_downvote_id, upvoted FROM forum_upvote_downvote WHERE user_id = ? AND thread_id = ?';
			$db->query($sql, array($user_id, $thread_id));
		}
		else
		{
			$sql = 'SELECT upvote_downvote_id, upvoted FROM article_upvote_downvote WHERE user_id = ? AND article_id = ?';
			$db->query($sql, array($user_id, $article_id));
		}
		
		$result = $db->single('arr');
		if($result){
			//User Upvoted already
			if($result['upvoted'] == 1){
				return 'true';
			}
			//User has not Upvoted
			else {
				return 'false';
			}
		} else {
			return 'false';
		}
		
	}

	public function increaseDownvotes($user_id, $thread_id = null, $article_id = null)
	{ 

		$db = Database::getDBI();
		
		if($thread_id != null)
		{
			$sql = 'SELECT * FROM forum_upvote_downvote WHERE user_id = ? AND thread_id = ?';
			$db->query($sql, array($user_id, $thread_id));
		}
		else
		{
			$sql = 'SELECT * FROM article_upvote_downvote WHERE user_id = ? AND article_id = ?';
			$db->query($sql, array($user_id, $article_id));
		}
		$result = $db->single('arr');

		if($result == false){
			if($thread_id != null)
				$db->insert('forum_upvote_downvote', ['downvoted'=>1, 'user_id'=>$user_id, 'thread_id'=>$thread_id, 'upvote_downvote_time'=>date('Y-m-d H:i:s', time())]);
			else
				$db->insert('article_upvote_downvote', ['downvoted'=>1, 'user_id'=>$user_id, 'article_id'=>$article_id]);
		} else 
		{
			if($thread_id != null)
			{
				if($result['downvoted'] == 0)
				{
					$db->update('forum_upvote_downvote', ['upvote_downvote_id'=>$result['upvote_downvote_id']], ['downvoted'=>1, 'upvoted'=>0, 'upvote_downvote_time'=>date('Y-m-d H:i:s', time())]);
				} elseif ($result['downvoted'] == 1 && $result['upvoted'] == 0){
					$db->delete('forum_upvote_downvote', ['upvote_downvote_id'=>$result['upvote_downvote_id']]);
				}
			}
			else
			{
				if($result['downvoted'] == 0)
				{
					$db->update('article_upvote_downvote', ['upvote_downvote_id'=>$result['upvote_downvote_id']], ['downvoted'=>1]);
				} elseif ($result['downvoted'] == 1 && $result['upvoted'] == 0){
					$db->delete('article_upvote_downvote', ['upvote_downvote_id'=>$result['upvote_downvote_id']]);
				} elseif ($result['downvoted'] == 1 && $result['upvoted'] == 1){
					$db->update('article_upvote_downvote', ['upvote_downvote_id'=>$result['upvote_downvote_id']], ['downvoted'=>0]);
				}
			}
		}
	}
	
	public function checkDownvotes($user_id, $thread_id = null, $article_id = null)
	{
		$db = Database::getDBI();
		
		if($thread_id != null)
		{
			$sql = 'SELECT upvote_downvote_id, downvoted FROM forum_upvote_downvote WHERE user_id = ? AND thread_id = ?';
			$db->query($sql, array($user_id, $thread_id));
		}
		else
		{
			$sql = 'SELECT upvote_downvote_id, downvoted FROM article_upvote_downvote WHERE user_id = ? AND article_id = ?';
			$db->query($sql, array($user_id, $article_id));
		}
		$result = $db->single('arr');
		if($result){
			if($result['downvoted'] == 1){
				return 'true';
			} else {
				return 'false';
			}
		} else {
			return 'false';
		}
	}
}
?>