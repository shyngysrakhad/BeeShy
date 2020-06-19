<?php
//require_once 'Database/Database.php';
require_once 'User.php';

class Admin extends User
{

    public function __construct($id)
    {
        parent::__construct($id);
    }

    public static function getUser($user_id){
        $sql = 'select * from users where user_id = ' . $user_id;
        return Database::getData($sql)[0];
    }
}