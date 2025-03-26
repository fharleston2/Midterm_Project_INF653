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

//Instantiate author object
$quote = new Quotes($db);

//Get raw posted data
$data = $_SESSION['input'];

$isQuote = isset($data->quote);
$isid = isset($data->id);

//Set id to update
$quote->id = $data->id;
$quote->quote = $data->quote;

//printf(json_encode($author));
//Update author
if($quote->update()){
    echo json_encode(
        array('message' => 'Post Updated')
    );
} else {
    echo json_encode(
        array('message' => 'Post not Updated')
    );
}