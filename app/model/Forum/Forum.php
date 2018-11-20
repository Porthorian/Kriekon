<?php

class Forum extends Model
{
	private $forum_id,
		$forum_name,
		$categories = [],
		$threads = [];
	
	public function getForumID() { return $this->forum_id; }
	public function getForumName() { return $this->forum_name; }
	public function getForumCategories() { return $this->categories; }
	public function getForumThreads() { return $this->threads; }
	
	public function setForumID($temp_id) { $this->forum_id = $temp_id; }
	public function setForumName($temp_string) { $this->forum_name = $temp_string; }
	
	public function addCategory($category_id)
	{
		$this->categories[] = $category_id;
	}
	
	public function removeCategory($category_id)
	{

		try {
			// Find where the id is located in the array or if it exists.
			$position = array_search($category_id, $this->getForumCategories());

			// Do not unset the category if $position equals false and is a boolean.
			if($position !== false)
			{
				unset($this->categories[$position]);
			}
		} catch (Exception $e) {
			echo $e->getMessage();
		}

	}
	
	public function addThread($thread_id)
	{
		$this->threads[] = $thread_id;
	}
	
	
	public function removeThread($thread_id)
	{
		$position = array_search($thread_id, $this->getForumThreads());
		
		if($positon !== false)
			unset($this->threads[$position]);
	}
	public function fetchForumInfo($forum = null)
	{

		try {

			// Get database instance or create new db object.
			$db = Database::getDBI();
			
			if($forum == null) // If an ID was not passed in as an argument.
			{
				$sql = 'SELECT * FROM forum WHERE forum_id = ?';
				$db->query($sql, array($this->getForumID()));
			} 
			elseif (is_int($forum)) // If an ID was passed in as an argument.
			{
				$sql = 'SELECT * FROM forum WHERE forum_id = ?';
				$db->query($sql, array($forum));
			} 
			elseif (is_string($forum)) // If a string was passed in as an argument.
			{
				$sql = 'SELECT * FROM forum WHERE forum_name = ?';
				$db->query($sql, array($forum));
			}

			// Grab the forum from the database.
			$results = $db->single();

			// Set the attributes.
			$this->setForumID($results->forum_id);
			$this->setForumName($results->forum_name);

		} catch (Exception $e) {
			echo $e->getMessage();
		}

	}
	
	/**
	 * fetchCategories will fetch the categories from the database and add the categories
	 * to the forum's categories array.
	 * 
	 * @uses 	Forum::forum_id to fetch the category ID's from the database.
	 * @uses   	addCategory() to add the fetched IDs to the forum's categories array.
	 */
	public function fetchForumCategories()
	{

		try {
			// Get database instance or create new db object.
			$db = Database::getDBI();

			// Grab all of the supercategories that belong to the forum.
			$sql = 'SELECT category_id FROM forum_category WHERE forum_id = ?';
			$db->query($sql, array($this->getForumID()));
			$results = $db->results('arr');
			
			// For each of the super categories grabbed, add the ID to the array.
			foreach ($results as $category)
			{
				$this->addCategory($category['category_id']);
			}
		} catch (Exception $e) {
			echo $e->getMessage();
		}

	}
	
	public function fetchForumThreads($forum_id = null)
	{
		try {
			$db = Database::getDBI();
			
			$sql = 'SELECT forum_thread.thread_id FROM forum_thread JOIN forum_category ON forum_thread.category_id = forum_category.category_id JOIN forum ON forum.forum_id = forum_category.forum_id WHERE forum.forum_id = ? ORDER BY forum_thread.thread_date DESC LIMIT 50';
			
			if($forum_id != null)
				$db->query($sql, array($forum_id));
			else
				$db->query($sql, array($this->getForumID()));
			
			$results = $db->results('arr');
			
			foreach($results as $threads)
				$this->addThread($threads['thread_id']);
		} catch (Exception $e) { echo $e->getMessage(); }
	}
	
	/**
	 * create() will simply take the forums name and insert it into the database.
	 *  
	 *  @uses  	Forum::forum_name to insert it into the database to create a new record.
	 */
	public function create()
	{

		try {
			// Get database instance or create new db object.
			$db = Database::getDBI();

			// Insert the new forum in the database.
			$db->insert('forum',['forum_name'=>$this->getForumName()]);

		} catch (Exception $e) {
			echo $e->getMessage();
		}

	}
	
	/**
	 * update() will update the forum information where the forum_id equals forum_id in the database.
	 * 
	 * @uses 	Forum::forum_id to find the correct record to update in the database.
	 * @uses 	Forum::forum_name to update the field in the database.
	 */
	public function update()
	{

		try {

			// Get database instance or create new db object.
			$db = Database::getDBI();
			// Update forum name!
			$db->update('forum', ['forum_id'=>$this->getForumId()],['forum_name'=>$this->getForumName()]);

		} catch (Exception $e) {
			echo $e->getMessage();
		}

	}

	/**
	 * delete() will remove a the forum record from the database.
	 * 
	 * @uses Forum::forum_id to find the correct record to delete from the database.
	 */
	public function delete()
	{

		try {

			// Get database instance or create new db object.
			$db = Database::getDBI();
			// Delete the forum where forum_id = $this->forum_id
			$db->delete('forum', ['forum_id'=>$this->getForumId()]);

		} catch (Exception $e) {
			echo $e->getMessage();
		}

	}

}