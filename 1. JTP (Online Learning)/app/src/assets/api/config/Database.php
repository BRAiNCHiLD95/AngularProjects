<?php
    class Database {
        private $host = "172.17.0.2:3306";
        private $db_name = "database";
        private $username = "admin";
        private $pwd = "";
        private $conn;

        public function connect() {
            $this->conn = null;
            try {
                $this->conn = new PDO('mysql:host=' . $this->host . ';dbname=' . $this->db_name, $this->username, $this->pwd);
                $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            } catch (PDOException $error) {
                echo 'Database Connection Error : ' . $error->getMessage();
            }
        return $this->conn;
        }
    }
?>