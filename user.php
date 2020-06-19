<?php
require_once "Database/Database.php";

class User
{
    private $id;
    private $email;
    private $firstName;
    private $lastName;
    private $birthdate;
    private $ava;
    private $description;
    private $comments;
    private $posts;


    public function __construct($user_id)
    {
        $this->id = $user_id;
        $this->email = self::getUser($user_id)['email'];
        $this->firstName = self::getUser($user_id)['firstName'];
        $this->lastName = self::getUser($user_id)['lastName'];
        $this->birthdate = self::getUser($user_id)['birthdate'];
        $this->ava = self::getUser($user_id)['ava'];
        $this->description = self::getUser($user_id)['description'];
        $this->comments = self::getUser($user_id)['comments'];
        $this->posts = self::getUser($user_id)['posts'];
    }


    private static function getPostsCount($user_id){
        $sql = "SELECT COUNT(post_id) AS total FROM posts where author_id = " . $user_id;
        return Database::getData($sql)[0]['total'];
    }

    private static function getCommentsCount($user_id){
        $sql = "SELECT COUNT(comment_id) AS total FROM comments where author_id = " . $user_id;
        return Database::getData($sql)[0]['total'];
    }

    public static function getUser($user_id){
        $sql = 'select * from users where user_id = ' . $user_id;
        $result = Database::getData($sql)[0];
        $result['comments'] = self::getCommentsCount($user_id);
        $result['posts'] = self::getPostsCount($user_id);
        return $result;
    }

    public static function createUser(){
        $sql = 'INSERT INTO users(firstName, lastName, email, password, birthdate, ava, description) 
            values ("Shyngys", "Rakhad", "dev.chinga@gmail.com", "123", "14.10.2001", "no", "I am a student")';
        if (Database::executeData($sql)){
            return 1;
        }
        return 0;
    }

    /**
     * @return mixed
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * @param mixed $email
     */
    public function setEmail($email)
    {
        $this->email = $email;
    }

    /**
     * @return mixed
     */
    public function getFirstName()
    {
        return $this->firstName;
    }

    /**
     * @param mixed $firstName
     */
    public function setFirstName($firstName)
    {
        $this->firstName = $firstName;
    }

    /**
     * @return mixed
     */
    public function getLastName()
    {
        return $this->lastName;
    }

    /**
     * @param mixed $lastName
     */
    public function setLastName($lastName)
    {
        $this->lastName = $lastName;
    }

    /**
     * @return mixed
     */
    public function getBirthdate()
    {
        return $this->birthdate;
    }

    /**
     * @param mixed $birthdate
     */
    public function setBirthdate($birthdate)
    {
        $this->birthdate = $birthdate;
    }

    /**
     * @return mixed
     */
    public function getAva()
    {
        return $this->ava;
    }

    /**
     * @param mixed $ava
     */
    public function setAva($ava)
    {
        $this->ava = $ava;
    }

    /**
     * @return mixed
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * @param mixed $description
     */
    public function setDescription($description)
    {
        $this->description = $description;
    }

    /**
     * @return mixed
     */
    public function getComments()
    {
        return $this->comments;
    }

    /**
     * @param mixed $comments
     */
    public function setComments($comments)
    {
        $this->comments = $comments;
    }

    /**
     * @return mixed
     */
    public function getPosts()
    {
        return $this->posts;
    }

    /**
     * @param mixed $posts
     */
    public function setPosts($posts)
    {
        $this->posts = $posts;
    }

    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param mixed $id
     */
    public function setId($id)
    {
        $this->id = $id;
    }





}