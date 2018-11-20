<?php

/**
 * @author Brian L. Peter Jr. AKA Peter
 * @method object   Reply     This class is used to manage all of the reply
 *                            within the forum.
 * @TODO: Properly comment out the functions!
 */
class Reply extends Model
{

	private $reply_id,
			$thread_id,
			$user_id,
			$reply_author,
			$reply_content,
			$reply_likes,
			$reply_dislikes,
			$reply_date,
			$reply_modName;
			
	private $reply_modTime = '1970-01-01 00:00:00';

	public function getReplyId() { return $this->reply_id; }
	public function getReplyThreadId() { return $this->thread_id; }
	public function getReplyUserId() { return $this->user_id; }
	public function getReplyAuthor() { return $this->reply_author; }
	public function getReplyContent() { return $this->reply_content; }
	public function getReplyLikes() { return $this->reply_likes; }
	public function getReplyDislikes() { return $this->reply_dislikes; }
	public function getReplyDate() { return $this->reply_date; }
	public function getReplyModTime() { return $this->reply_modTime; }
	public function getReplyModName() { return $this->reply_modName; }

	public function getReplyArray()
	{

		$newDateFormat = new DateTime($this->getReplyDate());
        $date = $newDateFormat->format('Y-m-d');

        $user = new User();
        $user->fetchUserInfo($this->getReplyAuthor());

        $replyArray[] = array(
            'reply_id'=>$this->getReplyId(), 
            'reply_content'=>$this->getReplyContent(), 
            'reply_author'=>$user,
            'reply_date'=>$date,
            'reply_likes'=>$this->getReplyLikes(),
            'reply_dislikes'=>$this->getReplyDislikes(),
            'reply_modTime'=>$this->getReplyModTime(),
            'reply_modName'=>$this->getReplyModName()
            );

		return $replyArray;
	}

	public function setReplyId($temp_id) { $this->reply_id = $temp_id; }
	public function setReplyThreadId($temp_id) { $this->thread_id = $temp_id; }
	public function setReplyUserId($temp_id) { $this->user_id = $temp_id; }
	public function setReplyAuthor($temp_author) { $this->reply_author = $temp_author; }
	public function setReplyContent($temp_content) { $this->reply_content = $temp_content; }
	public function setReplyLikes($temp_amount) { $this->reply_likes = $temp_amount; }
	public function setReplyDislikes($temp_amount) { $this->reply_dislikes = $temp_amount; }
	public function setReplyDate($temp_date) { $this->reply_date = $temp_date; }
	public function setReplyModTime($temp_time) { $this->reply_modTime = $temp_time; }
	public function setReplyModName($temp_name) { $this->reply_modName = $temp_name; }

	public function increaseLikes($amount, $user_id, $reply_id) 
	{
		$db = Database::getDBI();

		$sql = 'SELECT * FROM forum_like_dislike WHERE user_id = ? AND reply_id = ?';
		$db->query($sql, array($user_id, $reply_id));
		$result = $db->single('arr');

		if($result == false){
			$this->reply_likes += $amount; 
			$db->insert('forum_like_dislike', ['liked'=>1,'user_id'=>$user_id, 'reply_id'=>$reply_id]);
		} else {
			if($result['liked'] == 0)
			{
				$this->reply_likes += $amount; 
				$db->update('forum_like_dislike', ['like_dislike_id'=>$result['like_dislike_id']], ['liked'=>1]);
			} elseif ($result['liked'] == 1 && $result['disliked'] == 0){
				$this->reply_likes -= $amount;
				$db->delete('forum_like_dislike', ['like_dislike_id'=>$result['like_dislike_id']]);
			} elseif ($result['liked'] == 1 && $result['disliked'] == 1){
				$this->reply_likes -= $amount;
				$db->update('forum_like_dislike', ['like_dislike_id'=>$result['like_dislike_id']], ['liked'=>0]);
			}
		}
	}

	public function increaseDislikes($amount, $user_id, $reply_id) 
	{ 
		$db = Database::getDBI();

		$sql = 'SELECT * FROM forum_like_dislike WHERE user_id = ? AND reply_id = ?';
		$db->query($sql, array($user_id, $reply_id));
		$result = $db->single('arr');

		if($result == false){
			$this->reply_dislikes += $amount; 
			$db->insert('forum_like_dislike', ['disliked'=>1,'user_id'=>$user_id, 'reply_id'=>$reply_id]);
		} else {
			if($result['disliked'] == 0)
			{
				$this->reply_dislikes += $amount; 
				$db->update('forum_like_dislike', ['like_dislike_id'=>$result['like_dislike_id']], ['disliked'=>1]);
			} elseif ($result['disliked'] == 1 && $result['liked'] == 0){
				$this->reply_dislikes -= $amount;
				$db->delete('forum_like_dislike', ['like_dislike_id'=>$result['like_dislike_id']]);
			} elseif ($result['disliked'] == 1 && $result['liked'] == 1){
				$this->reply_dislikes -= $amount;
				$db->update('forum_like_dislike', ['like_dislike_id'=>$result['like_dislike_id']], ['disliked'=>0]);
			}
		}
	}

	public function checkLikes($user_id, $reply_id)
	{
		$db = Database::getDBI();

		$sql = 'SELECT like_dislike_id, liked FROM forum_like_dislike WHERE user_id = ? AND reply_id = ?';
		$db->query($sql, array($user_id, $reply_id));
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

	public function checkDislikes($user_id, $reply_id)
	{
		$db = Database::getDBI();

		$sql = 'SELECT like_dislike_id, disliked FROM forum_like_dislike WHERE user_id = ? AND reply_id = ?';
		$db->query($sql, array($user_id, $reply_id));
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

	public function fetchReplyInfo($id = null)
	{

		try {

			// Get database instance or create new db object.
			$db = Database::getDBI();

			$sql = 'SELECT * FROM forum_replies WHERE reply_id = ?';
			if($id != null)
			{
				$db->query($sql, array($id));
			} else {
				$db->query($sql, array($this->getReplyId()));
			}
			
			$results = $db->single();

			// Set the object up.
			if($results != false){
				$this->setReplyId($results->reply_id);
				$this->setReplyThreadId($results->thread_id);
				$this->setReplyUserId($results->user_id);
				$this->setReplyAuthor($results->reply_author);
				$this->setReplyContent($results->reply_content);
				$this->setReplyLikes($results->reply_likes);
				$this->setReplyDislikes($results->reply_dislikes);
				$this->setReplyDate($results->reply_date);
				$this->setReplyModTime($results->reply_modTime);
				$this->setReplyModName($results->reply_modName);

			}
		} catch (Exception $e) {
			echo $e->getMessage();
		}

	}

	public function count()
	{
		try {
			
			// Get database instance or create new db object.
			$db = Database::getDBI();

			// Count how many super categories belong to the forum.
			$sql = 'SELECT COUNT(reply_id) AS total FROM forum_replies WHERE thread_id = ?';
			$db->query($sql,['thread_id'=>$this->getReplyThreadId()]);

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

			$this->setReplyDate(date('Y-m-d H:i:s', time()));

			// Insert the new reply in the database.
			$db->insert('forum_replies',[
				'thread_id'=>$this->getReplyThreadId(),
				'user_id'=>$this->getReplyUserId(),
				'reply_author'=>$this->getReplyAuthor(),
				'reply_dislikes'=>$this->getReplyDislikes(),
				'reply_likes'=>$this->getReplyLikes(),
				'reply_content'=>$this->getReplyContent(),
				'reply_date'=>$this->getReplyDate(),
				'reply_modName'=>$this->getReplyModName()
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

			$this->setReplyModTime(date('Y-m-d H:i:s', time()));

			// Update sub category name!
			$db->update('forum_replies', ['reply_id'=>$this->getReplyId()],[
				'thread_id'=>$this->getReplyThreadId(),
				'user_id'=>$this->getReplyUserId(),
				'reply_author'=>$this->getReplyAuthor(),
				'reply_dislikes'=>$this->getReplyDislikes(),
				'reply_likes'=>$this->getReplyLikes(),
				'reply_content'=>$this->getReplyContent(),
				'reply_date'=>$this->getReplyDate(),
				'reply_modTime'=>$this->getReplyModTime(),
				'reply_modName'=>$this->getReplyModName()
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

			// Delete the reply from db
			$db->delete('forum_replies', ['reply_id'=>$this->getReplyId()]);

		} catch (Exception $e) {
			echo $e->getMessage();
		}

	}

}

?>