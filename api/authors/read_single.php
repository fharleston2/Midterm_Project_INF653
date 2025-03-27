<?php
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

//Get ID
$author->id = isset($_GET['id']) ? $_GET['id'] : die();

// get author
$author->read_single();

// Create array for data
$author_arr = array(
    'id' => $author->id,
    'author' => $author->author
);

//make json
echo json_encode($author_arr);
return json_encode($author_arr);
