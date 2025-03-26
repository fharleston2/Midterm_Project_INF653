<?php
    class Categories {
        private $conn;
        private $table = 'public.categories';

        public $id;
        public $category;

        public function __construct($db) {
            $this->conn = $db;
        }

        //Get categories
        public function read(){
            //query
            $query = 'SELECT id, category 
            FROM ' . $this->table . '
            ORDER BY category DESC';

            //prepare statment
            $stmt = $this->conn->prepare($query);

            //$stmt->debugDumpParams();
            //execute statement
            $stmt->execute();
            return $stmt;
        }

        //Get single category
        public function read_single() {
            //create query
            $query = 'SELECT id, category 
            FROM ' . $this->table . '
            WHERE id = ?';

            //prepare statement
            $stmt = $this->conn->prepare($query);

            //bind id
            $stmt->bindParam(1, $this->id);

            //execute statement
            $stmt->execute();

            //fetch data as array
            $row = $stmt->fetch(PDO::FETCH_ASSOC);
            if($row['id'] === null){
                echo json_encode(
                    array('message' => 'category id Not Found')
                );
                die();
            }
            $this->id = $row['id'];
            $this->category = $row['category'];
        }

        //create category
        public function create() {
            //create query
            $query = 'INSERT INTO ' . $this->table . 
            '(category) 
            VALUES (:category)';

            //prepare statment
            $stmt = $this->conn->prepare($query);
            //$stmt->debugDumpParams();
            //clean data
            $this->category = htmlspecialchars(strip_tags($this->category));

            //bind data
            $stmt->bindParam(':category', $this->category);

            
            //execute query
            if($stmt->execute()){
                return true;
            }

            //print error if something goes wrong
            printf("Error: %s.\n", $stmt->error);
            return false;
        }

        //update category
        public function update() {
            //create query
            $query = 'UPDATE ' . $this->table . 
            ' SET category = :category
             WHERE id = :id';

             //prepare statement
             $stmt = $this->conn->prepare($query);

             //clean data
             $this->category = htmlspecialchars(strip_tags($this->category));
            $this->id = htmlspecialchars(strip_tags($this->id));

            //bind parameters
            $stmt->bindParam(':category', $this->category);
            $stmt->bindParam(':id', $this->id);

            //execute statement
            if($stmt->execute()){
                return true;
            }

            //print error if something goes wrong
            printf("Error: %s.\n", $stmt->error);
            return false;
        }

        //delete category
        public function delete() {
            //create query
            $query = 'DELETE FROM ' . $this->table . 
            ' WHERE id = :id';

            //prepare statement
            $stmt = $this->conn->prepare($query);

            //clean data
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