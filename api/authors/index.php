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
    
    if(isset($_GET['id'])){

        $fid = $_GET['id'];
        
        require 'read_single.php';
        header('Location: read_single.php?id='.$fid);

    }else {
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

