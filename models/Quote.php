<?php
    class Quotes {
        private $conn;
        private $table = 'public.quotes';

        public $id;
        public $quote;
        public $author_id;
        public $category_id;

        public function __construct($db) {
            $this->conn = $db;
        }

        //get all quotes
        public function read() {
            //query
            if(isset($_GET['author_id']) AND isset($_GET['category_id'])){
                $query = 'SELECT public.quotes.id, quote, author, category 
                FROM ' . $this->table . '
                LEFT JOIN public.authors ON ' . $this->table . '.author_id = public.authors.id 
                LEFT JOIN public.categories ON ' . $this->table . '.category_id = public.categories.id 
                WHERE public.quotes.author_id = :author 
                AND public.quotes.category_id  = :category';
                
                }else {
            $query = 'SELECT public.quotes.id, quote, author, category 
            FROM ' . $this->table . '
            LEFT JOIN public.authors ON ' . $this->table . '.author_id = public.authors.id 
            LEFT JOIN public.categories ON ' . $this->table . '.category_id = public.categories.id 
            ORDER BY id';}
        

        //prepare statement
        $stmt = $this->conn->prepare($query);
        //$stmt->debugDumpParams();
        if(isset($_GET['author_id']) && isset($_GET['category_id'])){
            $stmt->bindParam(':author', $this->author_id, PDO::PARAM_STR);
            $stmt->bindParam(':category', $this->category_id, PDO::PARAM_STR);
        }
        //$stmt->debugDumpParams();
        //execute statement
        $stmt->execute();
        return $stmt;
        }

        //get single quote
        public function read_single() {
            
            if(isset($_GET['id'])){
            $query = 'SELECT public.quotes.id, quote, author, category 
            FROM ' . $this->table . '
            LEFT JOIN public.authors ON ' . $this->table . '.author_id = public.authors.id 
            LEFT JOIN public.categories ON ' . $this->table . '.category_id = public.categories.id 
            WHERE public.quotes.id = ?';
            
            }else if(isset($_GET['author_id'])){
                $query = 'SELECT public.quotes.id, quote, author, category 
                FROM ' . $this->table . '
                LEFT JOIN public.authors ON ' . $this->table . '.author_id = public.authors.id 
                LEFT JOIN public.categories ON ' . $this->table . '.category_id = public.categories.id 
                WHERE public.quotes.author_id = ?'; 
                
            }else if(isset($_GET['category_id'])){
                $query = 'SELECT public.quotes.id, quote, author, category 
                FROM ' . $this->table . '
                LEFT JOIN public.authors ON ' . $this->table . '.author_id = public.authors.id 
                LEFT JOIN public.categories ON ' . $this->table . '.category_id = public.categories.id 
                WHERE public.quotes.category_id = ?'; 
                
            }

        //prepare statement
        $stmt = $this->conn->prepare($query);
        //$stmt->debugDumpParams();
        //Bind an id
        
            $stmt->bindParam(1, $this->id);
        
        //execute statement
        $stmt->execute();

        //fetch array
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        $this->id = $row['id'];
        $this->quote = $row['quote'];
        $this->author = $row['author'];
        $this->category = $row['category'];
        
        }

        //create quote
        public function create(){
            //create query
            $query = 'INSERT INTO ' . $this->table . ' 
           (quote, author_id, category_id) 
            VALUES(:quote, :author_id, :category_id)';

            //prepare statement
            $stmt = $this->conn->prepare($query);

            //clean data
            $this->quote = htmlspecialchars(strip_tags($this->quote));
            $this->author_id = htmlspecialchars(strip_tags($this->author_id));
            $this->category_id = htmlspecialchars(strip_tags($this->category_id));

            //bind the data
            
            $stmt->bindParam(':quote', $this->quote);
            $stmt->bindParam(':author_id', $this->author_id);
            $stmt->bindParam(':category_id', $this->category_id);

            //$stmt->debugDumpParams();
            //execute query
            if($stmt->execute()){
                return true;
            }
            

            //print error if something goes wrong
            printf("Error: %s.\n", $stmt->error);
            return false;

        }

        //update quote
        public function update(){
            //create query
            $query = 'UPDATE ' . $this->table . 
            ' SET quote = :quote
             WHERE id = :id';

            //prepare statement
            $stmt = $this->conn->prepare($query);

            //clean data
            $this->quote = htmlspecialchars(strip_tags($this->quote));
            $this->id = htmlspecialchars(strip_tags($this->id));

        
            //bind the data
            $stmt->bindParam(':quote', $this->quote);
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
        //Delete Quote
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