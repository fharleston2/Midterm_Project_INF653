<?php
session_start();

//header('Access-Control-Allow-Origin: *');
//header('Content-Type: application/json');
$method = $_SERVER['REQUEST_METHOD'];

include_once '../../config/Database.php';
include_once '../../models/Author.php';

if ($method === 'OPTIONS') {
    header('Access-Control-Allow-Methods: GET, POST, PUT, DELETE');
    header('Access-Control-Allow-Headers: Origin, Accept, Content-Type, X-Requested-With');
    exit();
}




//Instantiate DB & connect
$database = new Database();
$db = $database->connect();

//Instantiate author object
$author = new Authors($db);

//Get raw posted data
$data = $_SESSION['input'];

$author->author = $data->author;

//Create the author
if($author->author === null){ 
    echo json_encode(
        array('message' => 'no author entered')
    );
    die();
}
if($author->create()){
    echo json_encode(
        array('message' => 'Post Created')
    );
} else {
    echo json_encode(
        array('message' => 'Post not Created')
    );
    
}