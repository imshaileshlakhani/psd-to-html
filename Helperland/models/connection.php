<?php
    include("config.php");
    class Connection{
        public function connect(){
            $conn = new mysqli(Config::DB_SERVER, Config::DB_USER, Config::DB_PASS, Config::DB_NAME);
            if($conn->connect_error){
                echo "Connection unSuccessfully";
                die("Something went wrong");
            }
            return $conn;
        }
    }
?>