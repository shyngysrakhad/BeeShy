<?php
require_once 'Database/Database.php';
require_once 'Comment.php';
require_once 'Tag.php';

class Post{
    private $id;
    private $title;
    private $content;
    private $date;
    private $author;
    private $comments;
    private $votes;
    private $tags;
    private $author_id;
    public function __construct($id)
    {
        $this->id = $id;
        $sql = 'SELECT * FROM posts p INNER JOIN users u on p.author_id = u.user_id where p.post_id = ' . $id;
        $response = Database::getData($sql)[0];
        $this->title = $response['title'];
        $this->content = $response['content'];
        $this->date = $response['date_'];
        $this->author = $response['firstName'] . ' ' . $response['lastName'];
        $this->comments = Comment::getCommentCount($id);
        $this->votes = $response['votes'];
        $this->tags = Tag::getTags($id);
        $this->author_id = $response['user_id'];
    }

    public static function updatePost($post_id, $author, $title, $content){
        $sql = 'update posts set title = "' . $title . '", content = "' . $content . '" where post_id = ' . $post_id . ' and author_id = ' . $author;
        if (Database::executeData($sql)){
            return 1;
        }
        return 0;
    }

    public static function deletePost($post_id, $author){
        $sql = 'delete from posts where post_id = ' . $post_id . ' and author_id = ' . $author;
        if (Database::executeData($sql)){
            return 1;
        }
        return 0;
    }

    public static function isMyPost($author, $post_id){
        $sql = 'select * from posts where post_id = ' . $post_id . ' and author_id = ' . $author;
        if (sizeof(Database::getData($sql)) > 0)
            return true;
        else
            return false;
    }
    public static function createPost($author_id, $title, $content, $tags){
        $date = date('Y-m-d H:i:s');
        $sql = 'INSERT INTO posts (author_id, title, content, date_) values('. $author_id .', "' . $title .'", "'. $content .'", "'. $date .'")';
        $conn = Database::connection();
        if ($conn->query($sql)){
            $sql2 = '';
            $id = $conn->insert_id;
            $tags_array = explode(',', $tags);
            if (strpos($tags, ',') !== false){
                for ($i = 0; $i < sizeof($tags_array); ++$i){
                    $sql2 .=  'insert into posts_tags(post_id, tag_id) values(' . $id . ', ' . $tags_array[$i] . ');';
                }
                if (Database::connection()->multi_query($sql2)){
                    return $id;
                }
            }else{
                $sql2 = 'insert into posts_tags(post_id, tag_id) values(' . $id . ', ' . $tags . ');';
                if (Database::executeData($sql2)){
                    return $id;
                }
            }
        }
        return null;
    }

    public static function getAllPostCount(){
        $sql = "SELECT COUNT(post_id) AS total FROM posts";
        return Database::getData($sql)[0]['total'];
    }
    public static function getAllPostCountByTag($tag){
        $sql = 'select COUNT(pt.post_id) AS total from posts_tags pt inner join posts p on pt.post_id = p.post_id where pt.tag_id = ' . $tag;
        return Database::getData($sql)[0]['total'];
    }

    public static function getAllPostCountByUser($user_id){
        $sql = 'select COUNT(author_id) AS total from posts where author_id = ' . $user_id;
        return Database::getData($sql)[0]['total'];
    }

    public static function getAllPostsOfUser($user_id, $start, $count){
        $sql = "SELECT * FROM posts p INNER JOIN users u ON p.author_id = u.user_id where author_id = " . $user_id . " ORDER BY date_ DESC LIMIT " . $start . ", " . $count;
        $posts = Database::getData($sql);
        for ($i = 0; $i < sizeof($posts); ++$i){
            $posts[$i]['comments'] = Comment::getCommentCount($posts[$i]['post_id']);
        }
        return $posts;
    }

    public static function getAllPostsByTag($tag, $start, $count){
        $sql = 'select * from posts_tags pt inner join posts p on pt.post_id = p.post_id inner join users u on p.author_id = u.user_id 
            where pt.tag_id = ' . $tag . ' order by p.date_ desc limit ' . $start . ', ' . $count;
        $posts = Database::getData($sql);
        for ($i = 0; $i < sizeof($posts); ++$i){
            $posts[$i]['comments'] = Comment::getCommentCount($posts[$i]['post_id']);
        }
        return $posts;
    }

    public static function getAllPosts($start, $count){
        $sql = "SELECT * FROM posts p INNER JOIN users u ON p.author_id = u.user_id ORDER BY date_ DESC LIMIT " . $start . ", " . $count;
        $posts = Database::getData($sql);
        for ($i = 0; $i < sizeof($posts); ++$i){
            $posts[$i]['comments'] = Comment::getCommentCount($posts[$i]['post_id']);
        }
        return $posts;
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



    public function getTags()
    {
        return $this->tags;
    }

    public function setTags($tags)
    {
        $this->tags = $tags;
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
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * @param mixed $title
     */
    public function setTitle($title)
    {
        $this->title = $title;
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


}
