<?php 

    //Headers
    header('Access-Control-Allow-Origin: *');
    header('Content-Type: application/json');
    header('Access-Control-Allow-Methods: POST');
    header('Access-Control-Allow-Headers: Access-Control-Allow-Headers,Content-Type,
        Access-Control-Allow-Methods,Authorization,X-Requested-With ');


    include_once '../../config/Database.php';
    include_once '../../models/Quote.php';

    //check if authorId and categoryId exist
    include_once '../../models/Author.php';
    include_once '../../models/Category.php';

    //Instantiate DB & connect
    $database = new Database();
    $db = $database->connect();

    //Instantiate blog post object
    $quote_object = new Quote($db);
    $quote_author = new Author($db);
    $quote_category = new Category($db);

    //Get the raw posted data
    $data = json_decode(file_get_contents("php://input"));

    //assign the data to quote
    $quote_object->quote = $data->quote;
    $quote_object->authorId = $data->authorId;
    $quote_object->categoryId = $data->categoryId;

    $quote_author->id = $data->authorId;

    $quote_category->id = $data->categoryId;

    //validate the input
    if(empty($quote_object->quote) || empty($quote_object->authorId) || empty($quote_object->categoryId)) {
        echo json_encode(
            array('message' => 'Missing Required Parameters')
        );
            return;
    }

    if($quote_author->read_single()) {
        echo json_encode(
            array('message' => 'authorId Found')
        );
    }
    else {
        echo json_encode(
            array('message' => 'authorId Not Found')
        );
    }

    if($quote_category->read_single()) {
        echo json_encode(
            array('message' => 'categoryId Found')
        );
    }
    else {
        echo json_encode(
            array('message' => 'categoryId Not Found')
        );
    }

   
    //Create the post
    if($quote_object->create()) {
        $quote_item = array(
            'id' => $quote_object->id,
            'quote' => $quote_object->quote,
            'authorId' => $quote_object->authorId,
            'categoryId' => $quote_object->categoryId
        );
        echo json_encode($quote_item);
    } 