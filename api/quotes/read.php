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

//Instantiate quote object
$quote = new Quotes($db);

//quote query
$isAuthor = isset($_GET['author_id']);
//var_dump($isAuthor);
$isCategory = isset($_GET['category_id']);
//var_dump($isCategory);
$result = $quote->read();
//var_dump($result);
//row count
$num = $result->rowCount();

//any quotes
if($num > 0){
    $quote_arr = array();
    $quote_arr['data'] = array();

    while($row = $result->fetch(PDO::FETCH_ASSOC)) {
        extract($row);
        $quote_item = array(
            'id' => $id,
            'quote' => $quote,
            'author' => $author,
            'category' => $category);
        array_push($quote_arr['data'], $quote_item);
    }

    //turn to JSON $ output
    echo json_encode($quote_arr);
} else {
    echo json_encode(
        array('message' => 'No quotes found')
    );
}