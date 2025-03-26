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

$isid = isset($data->id);
$isauthor = isset($data->author);

if($isauthor || $isid === false){
    echo json_encode(
        array('message' => 'Missing Required Parameters')
    );
    die();
}

//Set id to update
$author->id = $data->id;
$author->author = $data->author;

//printf(json_encode($author));
//Update author
if($author->update()){
    echo json_encode(
        array('message' => 'Post Updated')
    );
} else {
    echo json_encode(
        array('message' => 'Post not Updated')
    );
}