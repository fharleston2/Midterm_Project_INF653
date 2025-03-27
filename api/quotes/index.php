<?php 


header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');
$method = $_SERVER['REQUEST_METHOD'];

include_once '../../config/Database.php';
include_once '../../models/Author.php';



if ($method === 'OPTIONS') {
    header('Access-Control-Allow-Methods: GET, POST, PUT, DELETE');
    header('Access-Control-Allow-Headers: Origin, Accept, Content-Type, X-Requested-With');
    exit();
}




if ($method === "GET") {
    
    if(isset($_GET['author_id']) AND isset($_GET['category_id'])){
        $fauthor_id = $_GET['author_id'];
        $fcategory_id = $_GET['category_id'];
      //  $isAuthor = isset($_GET['author_id']);
   // var_dump($fauthor_id);
   // $isCategory = isset($_GET['category_id']);
    //var_dump($isCategory);
        require 'read.php';
        //header('Location: read.php?author_id=' .$fauthor_id.'&category_id=' .$fcategory_id);

    }else if(isset($_GET['category_id'])){
        $fcategory_id = $_GET['category_id'];

        require 'read_single.php';
        //header('Location: read_single.php?category_id=' .$fcategory_id);

    }else if(isset($_GET['author_id'])){
        $fauthor_id = $_GET['author_id'];

        require 'read_single.php';
        //header('Location: read_single.php?author_id=' .$fauthor_id);

    }else if(isset($_GET['id'])){
        $fid = $_GET['id'];

        require 'read_single.php';
        //header('Location: read_single.php?id='.$fid);

    }else 
        {
        
        require 'read.php';
        //header('Location: read.php');
    }
} else if($method === "POST"){
    session_start();
    $_SESSION['input'] = json_decode(file_get_contents("php://input"));
    
    require 'create.php';
    //header('Location: create.php');  

}else if($method === "PUT"){
    session_start();
    $_SESSION['input'] = json_decode(file_get_contents("php://input"));

    require 'update.php';
    //header('Location: update.php');

}else if($method === "DELETE"){
    session_start();
    $_SESSION['input'] = json_decode(file_get_contents("php://input"));

    require 'delete.php';
    //header('Location: delete.php');
}