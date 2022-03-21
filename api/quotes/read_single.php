<?php 

    //Headers
    header('Access-Control-Allow-Origin: *');
    header('Content-Type: application/json');

    include_once '../../config/Database.php';
    include_once '../../models/Quote.php';

    //Instantiate DB & connect
    $database = new Database();
    $db = $database->connect();

    //Instantiate blog post object
    $quote = new Quote($db);

    //Get ID from URL if set
    $quote->id = isset($_GET['id']) ? $_GET['id'] : die();
    

    //Call read_single method from POST.php
    if($quote->read_single()) {
        //json data, create array
        $quote_arr = array(
            'id'=> $quote->id,
            'quote' => $quote->quote,
            'author' => $quote->author,
            'category' => $quote->category
        );
        //convert to JSON data
        print_r(json_encode($quote_arr));
    } else {
    echo json_encode(
        array('message' => 'No Quotes Found')
    );
    }

    

    
    /*//check if any posts
    if( $num > 0) {
        //initialize post array
        $quotes_arr = array();
        $quotes_arr['data'] = array();

        while($row = $result->fetch(PDO::FETCH_ASSOC)) {
            extract($row);

            $quote_item = array(
                'id' => $id,
                'quote' => html_entity_decode($quote),
                'author' => $author,
                'authorId' => $authorId,
                'category' => $category,
                'categoryId' => $categoryId
            );

            //Push to "data"
            array_push($quotes_arr['data'],$quote_item);
        }
        //turn it to JSON & output
        echo json_encode($quotes_arr);
    } else {
        //no posts
        echo json_encode(
            array('message' => 'No Quotes Found')
        );
    }*/