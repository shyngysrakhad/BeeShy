<?php
require_once 'Database/Database.php';

class Tag
{
    private $id;
    private $name;

    public static function getTagName($id){
        $sql = 'select name from tags where tag_id = ' . $id;
        return Database::getData($sql)[0]['name'];
    }

    public static function getPostsCountByTags($id){
        $sql = "SELECT COUNT(post_id) AS total FROM posts_tags where tag_id = " . $id;
        return Database::getData($sql)[0]['total'];
    }

    public static function getAllTags(){
        $sql = 'select * from tags';
        return Database::getData($sql);
    }

    public static function setTags($post_id, $tags){
        $sql = '';
        for ($i = 0; $i < sizeof($tags); ++$i){
            $sql .= 'insert into posts_tags(post_id, tag_id) values('. $post_id .', ' . $tags[$i] . ');';
        }
        if (Database::connection()->multi_query($sql) === true){
            return 'hi';
        }else{
            return Database::connection()->error;
        }
    }

    public static function getTags($post_id){
        $sql = 'select t.tag_id as id, t.name from posts_tags pt inner join tags t on pt.tag_id = t.tag_id where pt.post_id = ' . $post_id;
        return Database::getData($sql);
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
    public function getName()
    {
        return $this->name;
    }

    /**
     * @param mixed $name
     */
    public function setName($name)
    {
        $this->name = $name;
    }


}