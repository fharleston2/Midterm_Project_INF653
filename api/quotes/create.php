<?php
session_start();
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

//Instantiate quote object
$quote = new Quotes($db);

//Get raw posted data
$data = $_SESSION['input'];

$isQuote = isset($data->quote);
$isauthor_id = isset($data->author_id);
$isCategory_id = isset($data->category_id);

if($isQuote || $isauthor_id || $isCategory_id === false){
    if($isauthor_id === false){
        echo json_encode(
            array('message' => 'author_id Not Found')
        );
    }
    if($isCategory_id === false){
        echo json_encode(
            array('message' => 'category_id Not Found')
        );
    }
    echo json_encode(
        array('message' => 'Missing Required Parameters')
    );
    die();
}

$quote->quote = $data->quote;
$quote->author_id = $data->author_id;
$quote->category_id = $data->category_id;



//Create the quote
if($quote->create()){
    echo json_encode(
        array('message' => 'Post Created')
    );
} else {
    echo json_encode(
        array('message' => 'Post not Created')
    );
}