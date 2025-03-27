<?php
//session_start();
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

//Set id to delete
$author->id = $data->id;

//printf(json_encode($author));
//delete author


if($author->id != null){
    $author->delete();
    echo json_encode($data->id);
    return json_encode($data->id);  
    
} else {
    echo json_encode(
        array('message' => 'Author id ' . $author->id . ' not found')
    );
}