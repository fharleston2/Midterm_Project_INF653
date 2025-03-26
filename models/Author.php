<?php
    class Authors {
        private $conn;
        private $table = 'public.authors';

        public $id;
        public $author;

        public function __construct($db) {
            $this->conn = $db;
        }

        public function read() {
            //query
            $query = 'SELECT id, author 
            FROM ' . $this->table . '
            ORDER BY author DESC';
        

        //prepare statement
        $stmt = $this->conn->prepare($query);

        //execute statement
        $stmt->execute();
        return $stmt;
        }

        //get single author
        public function read_single() {
            $query = 'SELECT id, author 
            FROM ' . $this->table . '
            WHERE id = ?';
        

        //prepare statement
        $stmt = $this->conn->prepare($query);

        //Bind an id
        $stmt->bindParam(1, $this->id);
        //$stmt->debugDumpParams();
        //execute statement
        $stmt->execute();

        //fetch array
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        $this->id = $row['id'];
        $this->author = $row['author'];
        
        }

        public function create(){
            //create query
            $query = 'INSERT INTO ' . $this->table . 
            '(author) 
            VALUES (:author)';

            //prepare statement
            $stmt = $this->conn->prepare($query);

            //clean data
            $this->author = htmlspecialchars(strip_tags($this->author));

            //bind the data
            $stmt->bindParam(':author', $this->author);

            //execute query
            if($stmt->execute()){
                return true;
            }

            //print error if something goes wrong
            printf("Error: %s.\n", $stmt->error);
            return false;

        }

        public function update(){
            //create query
            $query = 'UPDATE ' . $this->table . 
            ' SET author = :author
             WHERE id = :id';

            //prepare statement
            $stmt = $this->conn->prepare($query);

            //clean data
            $this->author = htmlspecialchars(strip_tags($this->author));
            $this->id = htmlspecialchars(strip_tags($this->id));

        
            //bind the data
            $stmt->bindParam(':author', $this->author);
            $stmt->bindParam(':id', $this->id);
            
            //$stmt->debugDumpParams();
            //execute query
            if($stmt->execute()){
                return true;
            }

            //print error if something goes wrong
            printf("Error: %s.\n", $stmt->error);
            return false;

        }
        //Delete author
        public function delete() {
            //create query
            $query = 'DELETE FROM ' . $this->table . 
            ' WHERE id = :id';

            //prepare statement
            $stmt = $this->conn->prepare($query);

            //Clean data
            $this->id = htmlspecialchars(strip_tags($this->id));

            //bind variable
            $stmt->bindParam(':id', $this->id);

            //execute query
            if($stmt->execute()){
                return true;
            }

            //print error if something goes wrong
            printf("Error: %s.\n", $stmt->error);
            return false;

            

        }


            
    }

    