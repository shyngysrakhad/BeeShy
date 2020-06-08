<?php
require_once 'config.php';

class Database
{
    var $host;
    var $user;
    var $pass;
    var $database;

    public $db;
    public static $connect;


    public function __construct($host, $user, $pass, $database)
    {
        $this->host=$host;
        $this->user=$user;
        $this->pass=$pass;
        $this->database=$database;

    }

    public function connect()
    {
        $this->db = new mysqli($this->host,$this->user,$this->pass,$this->database);
        if (mysqli_connect_error())
        {
            return null;
        }
        else
            return $this->db;

    }

    public static function connection(){
        self::$connect = new mysqli(DB_SERVER, DB_USER, DB_PASS, DB_DATABASE);
        if (mysqli_connect_error())
        {
            return null;
        }
        else
            return self::$connect;
    }

    public static function getData($query){
        $conn = self::connection();
        $result = $conn->query($query);
        $return = array();
        if ($result->num_rows > 0) {
            while($row = $result->fetch_assoc()) {
                array_push($return, $row);
            }
        }
        $conn->close();
        return $return;
    }

    public static function executeData($query){
        $conn = self::connection();
        if ($conn->query($query) === TRUE) {
            return true;
        } else {
            return false;
        }
    }

}