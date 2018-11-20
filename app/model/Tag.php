<?php

/**
 * 
 */
class Tag extends Model {


    //Properties
    private $tag_id,
            $tag_name,
            $tag_permissions = [];

    public function getTagId() { return $this->tag_id; }
    public function getTagName() { return $this->tag_name; }
    public function getTagPermissions() { return $this->tag_permissions; }

    public function setTagId($id) { $this->tag_id = $id; }
    public function setTagName($name) { $this->tag_name = $name; }

    public function fetchTagInfo($id = null)
    {
        try {
            // Get database instance or create new db object.
            $db = Database::getDBI();

            $sql = 'SELECT * FROM tags WHERE tag_id = ?';
            if($id != null)
            {
                $db->query($sql, array($id));
            } else {
                $db->query($sql, array($this->getTagId()));
            }
            
            $results = $db->single();

            if($results != false)
            {
                // Set the object up.
                $this->setTagId($results->tag_id);
                $this->setTagName($results->tag_name);
            }
            
        } catch (Exception $e) {
            echo $e->getMessage();
        }
    }

    public function fetchPermissions($id = null)
    {
        try {

            // Get database instance or create new db object.
            $db = Database::getDBI();

            $sql = 'SELECT permissions.permission_name, permissions.permission_id FROM permissions JOIN tag_permissions ON permissions.permission_id = tag_permissions.permission_id WHERE tag_id = ?';

            // Grab all of the permissions that belong to the tag.
            if($id != null)
            {
                $db->query($sql, array($id));
            } else {
                $db->query($sql, array($this->getTagId()));
            }
            $results = $db->results('arr');

            foreach ($results as $permission)
            {
                $new_array = ['id'=>$permission['permission_id'],'name'=>$permission['permission_name']];
                $this->addPermission($new_array);
            }
            
        } catch (Exception $e) {
            echo $e->getMessage();
        }
        
    }

    public function addPermission($id)
    {
        $this->tag_permissions[] = $id;
    }

    public function removePermission($id)
    {
        try {
            // Find where the id is located in the array or if it exists.
            $position = array_search($id, $this->getTagPermissions());

            // Do not unset the permission if $position equals false and is a boolean.
            if($position !== false)
            {
                unset($this->tag_permissions[$position]);
            }
        } catch (Exception $e) {
            echo $e->getMessage();
        }
    }

    public function create()
    {
        try {
            
            // Get database instance or create new db object.
            $db = Database::getDBI();

            // Insert the new tag in the database.
            $db->insert('tags',['tag_name'=>$this->getTagName()]);

        } catch (Exception $e) {
            echo $e->getMessage();
        }
    }

    public function update()
    {
        try {

            // Get database instance or create new db object.
            $db = Database::getDBI();
            // Update tag name!
            $db->update('tags', ['tag_id'=>$this->getTagId()],['tag_name'=>$this->getTagName()]);

        } catch (Exception $e) {
            echo $e->getMessage();
        }
    }

    public function delete()
    {
        try {

            // Get database instance or create new db object.
            $db = Database::getDBI();
            // Delete the tag from the db.
            $db->delete('tags', ['tag_id'=>$this->getTagId()]);

        } catch (Exception $e) {
            echo $e->getMessage();
        }
    }

    public function countUserTags($id)
    {
        try {
            
            // Get database instance or create new db object.
            $db = Database::getDBI();

            // Count how many tags the user has.
            $sql = 'SELECT COUNT(tag_id) AS total FROM tag_user WHERE user_id = ?';
            $db->query($sql,['user_id'=>$id]);

            $result = $db->single('arr');

            return $result['total'];

        } catch (Exception $e) {
            echo $e->getMessage();
        }
    } 

}

?>
