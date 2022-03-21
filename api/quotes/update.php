<?php 

    //Headers
    header('Access-Control-Allow-Origin: *');
    header('Content-Type: application/json');
    header('Access-Control-Allow-Methods: PUT');
    header('Access-Control-Allow-Headers: Access-Control-Allow-Headers,Content-Type,
        Access-Control-Allow-Methods,Authorization,X-Requested-With ');


    include_once '../../config/Database.php';
    include_once '../../models/Quote.php';

    //bring in other models to check if authorId and categoryId exist
    include_once '../../models/Author.php';
    include_once '../../models/Category.php';

    //Instantiate DB & connect
    $database = new Database();
    $db = $database->connect();

    //Instantiate all required objects
    $quote_object = new Quote($db);
    $quote_author = new Author($db);
    $quote_category = new Category($db);
    
    //Get the raw posted data
    $data = json_decode(file_get_contents("php://input"));

    //Set ID to update
    $quote_object->id = $data->id;

    //assign the data
    $quote_object->quote = $data->quote;
    $quote_object->authorId = $data->authorId;
    $quote_object->categoryId = $data->categoryId;

    //assign the data to check the authorId existence
    $quote_author->id = $data->authorId;
    //assign the data to check the categoryId existence
    $quote_category->id = $data->categoryId;

    //validate the input
    if(empty($quote_object->quote) || empty($quote_object->authorId) || empty($quote_object->categoryId)) {
        echo json_encode(
            array('message' => 'Missing Required Parameters')
        );
            return;
    }
    //if no quotes are found
    if(!($quote_object->read_single())) {
        echo json_encode(array('message' => 'No Quotes Found'));
        return;
    }
    //if the authorID does not exist
    if(!($quote_author->read_single())) {
        echo json_encode(array('message' => 'authorId Not Found'));
        return;
    }
    //if the categoryId does not exist
    if(!($quote_category->read_single())) {
        echo json_encode(array('message' => 'categoryId Not Found'));
        return;
    }

    //Update the quote
    if($quote_object->update()) {
       $quote_item = array(
            'id' => $quote_object->id,
            'quote' => $quote_object->quote,
            'authorId' => $quote_object->authorId,
            'categoryId' => $quote_object->categoryId
        );
        echo json_encode($quote_item);
    }