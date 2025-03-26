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

//Set id to delete
$category->id = $data->id;

//printf(json_encode($author));
//delete category
if($category->delete()){
    echo json_encode(
        array('message' => 'category id ' . $category->id . ' Deleted')
    );
} else {
    echo json_encode(
        array('message' => 'Post not UpdaDeleted')
    );
}