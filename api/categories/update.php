<?php 

    //Headers
    header('Access-Control-Allow-Origin: *');
    header('Content-Type: application/json');
    header('Access-Control-Allow-Methods: PUT');
    header('Access-Control-Allow-Headers: Access-Control-Allow-Headers,Content-Type,
        Access-Control-Allow-Methods,Authorization,X-Requested-With ');


    include_once '../../config/Database.php';
    include_once '../../models/Category.php';

    //Instantiate DB & connect
    $database = new Database();
    $db = $database->connect();

    //Instantiate blog post object
    $category_object = new Category($db);

    //Get the raw posted data
    $data = json_decode(file_get_contents("php://input"));

    //Set ID to update
    $category_object->id = $data->id;

    //assign the data to post
    $category_object->category = $data->category;

    //validate the input
    if(empty($category_object->category)) {
        echo json_encode(
            array('message' => 'Missing Required Parameters')
        );
            return;
    }
    //Update the post
    if($category_object->update()) {
        $category_object->read_single();
        /*$cat_item = array(
            'id' => $category_object->id,
            'category' => $category_object->category
        );
        echo json_encode($cat_item);*/
    } 