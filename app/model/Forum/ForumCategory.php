<?php

/**
 * @author Brian L. Peter Jr. AKA Peter
 * @method object   Category    This class is used to manage all of the categories
 *                              within the forum.
 * @TODO: Properly comment out the functions!
 */
class ForumCategory extends Model
{

    private $category_id,
            $forum_id,
            $category_name,
            $category_description,
			$threads = [];

    // Getters
    public function getCategoryID() { return $this->category_id; }
    public function getCategoryForumID() { return $this->forum_id; }
    public function getCategoryName() { return $this->category_name; }
    public function getCategoryDescription() { return $this->category_description; }
	public function getCategoryThreads() { return $this->threads; }
	public function getCategoryUrlTitle() 
	{ 
		$url_title = Functions::adjustStringSEO($this->getCategoryName());
		
		return $url_title;
	}
	

    // Setters
    public function setCategoryID($temp_id) { $this->category_id = $temp_id; }
    public function setCategoryForumID($temp_id) { $this->forum_id = $temp_id; }
    public function setCategoryName($temp_name) { $this->category_name = $temp_name; }
    public function setCategoryDescription($temp_desc) { $this->category_description = $temp_desc; }

    public function fetchCategoryInfo($id = null)
    {
        try {
            // Get database instance or create new db object.
            $db = Database::getDBI();

            $sql = 'SELECT * FROM forum_category WHERE category_id = ?';
            if($id != null)
            {
                $db->query($sql, array($id));
            } else {
                $db->query($sql, array($this->getCategoryID()));
            }
            
            $results = $db->single();

            if($results != false)
            {
                // Set the object up.
                $this->setCategoryID($results->category_id);
                $this->setCategoryForumID($results->forum_id);
                $this->setCategoryName($results->category_name);
                $this->setCategoryDescription($results->category_description);
            }
            
        } catch (Exception $e) {
            echo $e->getMessage();
        }

    }
	
	public function addThread($id)
	{
		$this->threads[] = $id;
	}
	public function removeThread($id)
	{
		$position = array_search($id, $this->getCategoryThreads());
		
		if($position !== false)
			unset($this->threads[$position]);
	}
	public function fetchCategoryThreads($limit = null)
	{
		try {
			$db = Database::getDBI();
			
			if($limit != null)
				$sql = 'SELECT thread_id FROM forum_thread WHERE category_id = ? ORDER BY thread_date DESC LIMIT '. $limit;
			else
				$sql = 'SELECT thread_id FROM forum_thread WHERE category_id = ? ORDER BY thread_date DESC LIMIT 10';
			$db->query($sql, array($this->getCategoryID()));
			$results = $db->results('arr');
			
			foreach($results as $thread_id)
				$this->addThread($thread_id['thread_id']);
			
		} catch (Exception $e) { echo $e->getMessage(); }
	}

    public function count()
    {

        try {
            
            // Get database instance or create new db object.
            $db = Database::getDBI();

            // Count how many threads belong to the category.
            $sql = 'SELECT COUNT(thread_id) AS total FROM forum_thread WHERE category_id = ?';
            $db->query($sql,['category_id'=>$this->getCategoryID()]);

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

            // Insert the new category in the database.
            $db->insert('forum_category',[
                'cat_name'=>$this->getCategoryName(),
                'cat_description'=>$this->getCategoryDescription(),
                'forum_id'=>$this->getCategoryForumID()
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

            // Update category name!
            $db->update('forum_category', ['category_id'=>$this->getCategoryID()],[
                'cat_name'=>$this->getCategoryName(), 
                'forum_id'=>$this->getCategoryForumID(), 
                'cat_description'=>$this->getCategoryDescription()
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

            // Delete the category from db
            $db->delete('forum_category', ['category_id'=>$this->getCategoryID()]);

        } catch (Exception $e) {
            echo $e->getMessage();
        }
    }

}

?>