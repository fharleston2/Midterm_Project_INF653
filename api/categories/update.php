<?php
session_start();
header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');
$method = $_SERVER['REQUEST_METHOD'];

include_once '../../config/Database.php';
include_once '../../models/Category.php';

if ($method === 'OPTIONS') {
    header('Access-Control-Allow-Methods: GET, POST, PUT, DELETE');
    header('Access-Control-Allow-Headers: Origin, Accept, Content-Type, X-Requested-With');
    exit();
}

//Instantiate DB & connect
$database = new Database();
$db = $database->connect();

//Instantiate category object
$category = new Categories($db);

//Get raw posted data
$data = $_SESSION['input'];

$isid = isset($data->id);
$iscategory = isset($data->category);

if($iscategory || $isid === false){
    echo json_encode(
        array('message' => 'Missing Required Parameters')
    );
    die();
}

//Set id to update
$category->id = $data->id;
$category->category = $data->category;

//printf(json_encode($author));
//Update category
if($category->update()){
    echo json_encode(
        array('message' => 'Post Updated')
    );
} else {
    echo json_encode(
        array('message' => 'Post not Updated')
    );
}