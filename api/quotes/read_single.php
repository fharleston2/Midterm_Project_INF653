<?php
header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');
$method = $_SERVER['REQUEST_METHOD'];

include_once '../../config/Database.php';
include_once '../../models/Quote.php';

if ($method === 'OPTIONS') {
    header('Access-Control-Allow-Methods: GET, POST, PUT, DELETE');
    header('Access-Control-Allow-Headers: Origin, Accept, Content-Type, X-Requested-With');
    exit();
}

//Instantiate DB & connect
$database = new Database();
$db = $database->connect();

//Instantiate author object
$quote = new Quotes($db);

//Get ID


if(isset($_GET['author_id']) AND isset($_GET['category_id'])){
    $quote->author_id = $_GET['author_id'];
    $quote->category_id = $_GET['category_id'];

}else if(isset($_GET['category_id'])){
    $quote->id = isset($_GET['category_id']) ? $_GET['category_id'] : die();

}else if(isset($_GET['author_id'])){
    $quote->id = isset($_GET['author_id']) ? $_GET['author_id'] : die();

}else if(isset($_GET['id'])){
$quote->id = isset($_GET['id']) ? $_GET['id'] : die();
}
// get author
$quote->read_single();

// Create array for data
$quote_arr = array(
    'id' => $quote->id,
    'quote' => $quote->quote,
    'author' => $quote->author,
    'category' => $quote->category
    

);

//make json
print_r(json_encode($quote_arr));