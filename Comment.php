<?php
require_once 'Database/Database.php';

class Comment{

    private $id;
    private $content;
    private $author;
    private $author_id;
    private $date;
    private $votes;

    /**
     * Comment constructor.
     * @param $id
     * @param $content
     * @param $author
     * @param $author_id
     * @param $date
     * @param $votes
     */
    public function __construct($id, $content, $author, $author_id, $date, $votes)
    {
        $this->id = $id;
        $this->content = $content;
        $this->author = $author;
        $this->author_id = $author_id;
        $this->date = $date;
        $this->votes = $votes;
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

    /**
     * @return mixed
     */
    public function getContent()
    {
        return $this->content;
    }

    /**
     * @param mixed $content
     */
    public function setContent($content)
    {
        $this->content = $content;
    }

    /**
     * @return mixed
     */
    public function getAuthor()
    {
        return $this->author;
    }

    /**
     * @param mixed $author
     */
    public function setAuthor($author)
    {
        $this->author = $author;
    }

    /**
     * @return mixed
     */
    public function getAuthorId()
    {
        return $this->author_id;
    }

    /**
     * @param mixed $author_id
     */
    public function setAuthorId($author_id)
    {
        $this->author_id = $author_id;
    }

    /**
     * @return mixed
     */
    public function getDate()
    {
        return $this->date;
    }

    /**
     * @param mixed $date
     */
    public function setDate($date)
    {
        $this->date = $date;
    }

    /**
     * @return mixed
     */
    public function getVotes()
    {
        return $this->votes;
    }

    /**
     * @param mixed $votes
     */
    public function setVotes($votes)
    {
        $this->votes = $votes;
    }

    public static function removeComment($author, $comment){
        $sql = 'delete from comments where comment_id = ' . $comment . ' and author_id = ' . $author;
        if (Database::executeData($sql)){
            return 1;
        }
        return 0;
    }

    public static function isMyComment($author, $comment){
        $sql = 'select * from comments where comment_id = ' . $comment . ' and author_id = ' . $author;
        if (sizeof(Database::getData($sql)) > 0)
            return true;
        else
            return false;

    }

    public static function createComment($author, $post_id, $content){
        $date = date('Y-m-d H:i:s');
        $sql = 'INSERT INTO comments (author_id, post_id, content, date_) 
        values (' . $author . ', ' . $post_id . ', "' . $content. '", "' . $date . '")';
        if (Database::executeData($sql)){
            return 1;
        }
        return 0;
    }

    public static function getCommentCount($post_id){
        $sql = 'SELECT COUNT(1) FROM comments WHERE post_id = ' . $post_id;
        return Database::getData($sql)[0]['COUNT(1)'];
    }

    public static function getAllComments($post_id){
        $sql = 'select * from comments c inner join users u on c.author_id = u.user_id where c.post_id = ' . $post_id;
        return Database::getData($sql);
    }

}
