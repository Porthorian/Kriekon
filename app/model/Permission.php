<?php

/**
* 
*/
class Permission extends Model
{
    
    private $permission_id,
            $permission_name;

    public function getPermissionId() { return $this->permission_id; }
    public function getPermissionName() { return $this->permission_name; }

    public function setPermissionId($id) { $this->permission_id = $id; }
    public function setPermissionName($name) { $this->permission_name = $name; }

    public function fetchPermissionInfo($id = null)
    {
        try {
            // Get database instance or create new db object.
            $db = Database::getDBI();

            $sql = 'SELECT * FROM permissions WHERE permission_id = ?';
            if($id != null)
            {
                $db->query($sql, array($id));
            } else {
                $db->query($sql, array($this->getPermissionId()));
            }
            
            $results = $db->single();

            if($results != false)
            {
                // Set the object up.
                $this->setPermissionId($results->permission_id);
                $this->setPermissionName($results->permission_name);
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

            // Insert the new permission in the database.
            $db->insert('permissions',['permission_name'=>$this->getPermissionName()]);

        } catch (Exception $e) {
            echo $e->getMessage();
        }
    }

    public function update()
    {
        try {

            // Get database instance or create new db object.
            $db = Database::getDBI();
            // Update permission name!
            $db->update('permissions', ['permission_id'=>$this->getPermissionId()],['permission_name'=>$this->getPermissionName()]);

        } catch (Exception $e) {
            echo $e->getMessage();
        }
    }

    public function delete()
    {
        try {

            // Get database instance or create new db object.
            $db = Database::getDBI();
            // Delete the permission from the db.
            $db->delete('permissions', ['permission_id'=>$this->getPermissionId()]);

        } catch (Exception $e) {
            echo $e->getMessage();
        }
    }

    public function countTagPermissions($id)
    {
        try {
            
            // Get database instance or create new db object.
            $db = Database::getDBI();

            // Count how many tags the user has.
            $sql = 'SELECT COUNT(permission_id) AS total FROM tag_permissions WHERE tag_id = ?';
            $db->query($sql,['tag_id'=>$id]);

            $result = $db->single('arr');

            return $result['total'];

        } catch (Exception $e) {
            echo $e->getMessage();
        }
    }

}

?>