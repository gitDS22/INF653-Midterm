<?php 

    //Headers
    header('Access-Control-Allow-Origin: *');
    header('Content-Type: application/json');
    header('Access-Control-Allow-Methods: PUT');
    header('Access-Control-Allow-Headers: Access-Control-Allow-Headers,Content-Type,
        Access-Control-Allow-Methods,Authorization,X-Requested-With ');


    include_once '../../config/Database.php';
    include_once '../../models/Author.php';

    //Instantiate DB & connect
    $database = new Database();
    $db = $database->connect();

    //Instantiate blog post object
    $author_object = new Author($db);

    //Get the raw posted data
    $data = json_decode(file_get_contents("php://input"));

    //Set ID to update
    $author_object->id = $data->id;

    //assign the data to author
    $author_object->author = $data->author;

     //validate the input
     if(empty($author_object->author)) {
        echo json_encode(
            array('message' => 'Missing Required Parameters')
        );
            return;
    }
    //Update the post
    if($author_object->update()) {
        $author_object->read_single();
        /*$auth_item = array(
            'id' => $author_object->id,
            'author' => $author_object->author   
        );
        echo json_encode($auth_item);*/
    } 