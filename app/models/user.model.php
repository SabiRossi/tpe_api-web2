<?php
class userModel
{
    private  $db;

    function __construct()
    {
        $this->db = new PDO('mysql:host=localhost;' . 'dbname=db_tpeqatar;charset=utf8', 'root', '');
    }

    function getUser($userdata)
    {
        $query = $this->db->prepare("SELECT * FROM users WHERE email = ?");
        $query->execute([$userdata]);
        return $query->fetch(PDO::FETCH_OBJ);
    }
}
