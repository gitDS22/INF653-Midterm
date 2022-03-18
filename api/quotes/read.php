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

    //Get authorID-categoryId from URL if set
    if((isset($_GET['authorId'])) && (isset($_GET['categoryId']))) {
        
        $quote->authorId = isset($_GET['authorId']) ? $_GET['authorId'] : die();
        $quote->categoryId = isset($_GET['categoryId']) ? $_GET['categoryId'] : die();
    }
    else if(isset($_GET['authorId'])) {
        $quote->authorId = isset($_GET['authorId']) ? $_GET['authorId'] : die();
    }
    
    else if(isset($_GET['categoryId'])) {
        $quote->categoryId = isset($_GET['categoryId']) ? $_GET['categoryId'] : die();
    }
    


    // BLog post query
    $result = $quote->read();

    //get row count
    $num = $result->rowCount();

    //check if any posts
    if( $num > 0) {
        //initialize post array
        $quotes_arr = array();
        //$quotes_arr['data'] = array();

        while($row = $result->fetch(PDO::FETCH_ASSOC)) {
            extract($row);

            $quote_item = array(
                'id' => $id,
                //'quote' => html_entity_decode($quote),
                'quote' => $quote,
                'author' => $author,
                'category' => $category
            );

            //Push to "data"
            //array_push($quotes_arr['data'],$quote_item);
            array_push($quotes_arr,$quote_item);
        }
        //turn it to JSON & output
        echo json_encode($quotes_arr);
    } else {
        //no posts
        echo json_encode(
            array('message' => 'No Quotes Found')
        );
    }
