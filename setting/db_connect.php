<?php

class Db
{

    private $server = "localhost";

    private $username = "carpasgr_km";

    private $password = "^9}Vk&M.C~^t";
    private $dbname = "carpasgr_km_test";
    private $connect_db;

    function __construct()
    {

        $con = new mysqli($this->server, $this->username, $this->password, $this->dbname);
        if ($con->connect_error) {
            die("connection failed");
        }else{
            $con->set_charset("utf8");
            $this->connect_db = $con;
        }
        return $this->connect_db;
    }
    public function query($query){
        return $this->connect_db->query($query);
    }
}
$connectDb = new Db();
