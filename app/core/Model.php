<?php

/**
*
*/
class Model
{
    public static function makeHash() {
      return bin2hex(random_bytes(64));
    }

    public function getLastInsert()
    {
        $db = Database::getDBI();
        return $db->lastId();
    }

}
