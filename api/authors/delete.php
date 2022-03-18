<?php 

    //Headers
    header('Access-Control-Allow-Origin: *');
    header('Content-Type: application/json');
    header('Access-Control-Allow-Methods: DELETE');
    header('Access-Control-Allow-Headers: Access-Control-Allow-Headers,Content-Type,
        Access-Control-Allow-Methods,Authorization,X-Requested-With ');


    include_once '../../config/Database.php';
    include_once '../../models/Author.php';

    //Instantiate DB & connect
    $database = new Database();
    $db = $database->connect();

    //Instantiate category object
    $author_object = new Category($db);

    //Get the raw posted data
    $data = json_decode(file_get_contents("php://input"));
    
    //Set ID to update
    $author_object->id = $data->id;
    echo var_dump($author_object->id);
    //validate the input
    if(empty($author_object->id)) {
        echo json_encode(
            array('message' => 'Missing Required Parameters')
        );
            return;
    }
    //Delete the post
    if($author_object->delete()) {
        $auth_item = array(
            'id' => $author_object->id
        );
        echo json_encode($auth_item);
    } /*else {
        echo json_encode (
            array('message' => 'Missing Required Parameters')
        );
    }*/