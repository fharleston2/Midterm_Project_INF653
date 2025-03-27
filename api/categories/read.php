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

//Instantiate category object
$category = new Categories($db);

//category query
$result = $category->read();

//row count
$num = $result->rowCount();

//any categories
if($num > 0){
    $category_arr = array();
    //$category_arr['data'] = array();

    while($row = $result->fetch(PDO::FETCH_ASSOC)) {
        extract($row);
        $category_item = array(
            'id' => $id,
            'category' =>$category);
        array_push($category_arr, $category_item);
    }

    //turn to JSON $ output
    echo json_encode($category_arr);
    return json_encode($category_arr);
} else {
    echo json_encode(
        array('message' => 'No categories found')
    );
}