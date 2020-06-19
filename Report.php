<?php

require_once 'Database/Database.php';
class Report
{
    private $id;
    private $author;
    private $content;
    private $post_id;
    private $date;

    public function __construct($id)
    {
        $this->id = $id;
        $sql = 'SELECT * FROM reports where report_id = ' . $id;
        $response = Database::getData($sql)[0];
        $this->content = $response['content'];
        $this->date = $response['date_'];
        $this->author = $response['author_id'];
        $this->post_id = $response['post_id'];
    }

    public static function getAllReportsCount(){
        $sql = "SELECT COUNT(report_id) AS total FROM reports";
        return Database::getData($sql)[0]['total'];
    }
    public static function getAllReports($start, $count){
        $sql = "SELECT * FROM reports ORDER BY date_ DESC LIMIT " . $start . ", " . $count;
        $reports = Database::getData($sql);
        return $reports;
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
    public function setId($id): void
    {
        $this->id = $id;
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
    public function setAuthor($author): void
    {
        $this->author = $author;
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
    public function setContent($content): void
    {
        $this->content = $content;
    }

    /**
     * @return mixed
     */
    public function getPostId()
    {
        return $this->post_id;
    }

    /**
     * @param mixed $post_id
     */
    public function setPostId($post_id): void
    {
        $this->post_id = $post_id;
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
    public function setDate($date): void
    {
        $this->date = $date;
    }



}