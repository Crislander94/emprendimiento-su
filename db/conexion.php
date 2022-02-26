<?php 
    class DBClass{
        public $connection;
        private $host = "localhost";
        private $username = "root";
        private $password = "";
        private $database = "pclink";
        public function getconnection(){
            $this->connection = null;
            try{
                $this->connection = new PDO("mysql:host=".$this->host.";dbname=".$this->database, $this->username, $this->password);
                $this->connection->exec("set names utf8");
            }catch(PDOException $e){
                return false;
            }
            return $this->connection;
        }
    }
?>