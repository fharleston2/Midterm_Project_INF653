<?php
    class Database {
        private $host;
        private $db_name;
        private $username;
        private $password;
        private $port;
        private $conn;

        public function __construct() {
            $this->host = getenv('HOST');
            $this->db_name = getenv('DBNAME');
            $this->username = getenv('USERNAME');
            $this->password = getenv('PASSWORD');
            //$this->port = getenv('PORT');
        }

        //connection
        //removed ';port = ' . $this->port . after "$this->HOST
        public function connect() {
            $this->conn = null;

            try {
                $this->conn = new PDO('pgsql:host=' . $this->host . ';dbname= ' . $this->db_name,
                $this->username, $this->password);
                $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            }catch(PDOException $e) {
                echo 'Connection Error: ' . $e->getMessage();

            }
            return $this->conn;
        }
    }