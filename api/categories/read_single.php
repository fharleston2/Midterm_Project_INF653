<?php
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

//Instantiate author object
$category = new Categories($db);

//Get ID
$category->id = isset($_GET['id']) ? $_GET['id'] : die();

// get author
$category->read_single();

// Create array for data
$category_arr = array(
    'id' => $category->id,
    'author' => $category->category
);

//make json
if($category_arr['id'] != null) {
print_r(json_encode($category_arr));
}
else{
    echo json_encode(
        array('message' => 'category_id Not Found')
    );
}