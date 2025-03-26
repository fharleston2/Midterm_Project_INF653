<?php
include_once '../../config/Database.php';
include_once '../../models/Author.php';
//header('Access-Control-Allow-Origin: *');
//header('Content-Type: application/json');
//header('Access-Control-Allow-Methods: GET, POST, PUT, DELETE');
//header('Access-Control-Allow-Headers: Origin, Accept, Content-Type, X-Requested-With');
   



//Instantiate DB & connect
$database = new Database();
$db = $database->connect();

//Instantiate author object
$author = new Authors($db);

//Author query
$result = $author->read();

//row count
$num = $result->rowCount();

//any authors
if($num > 0){
    $author_arr = array();
    $author_arr['data'] = array();

    while($row = $result->fetch(PDO::FETCH_ASSOC)) {
        extract($row);
        $author_item = array(
            'id' => $id,
            'author' =>$author);
        array_push($author_arr['data'], $author_item);
    }

    //turn to JSON $ output
    echo json_encode($author_arr);
} else {
    echo json_encode(
        array('message' => 'No authors found')
    );
}
