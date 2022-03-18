<?php 

    //Headers
    header('Access-Control-Allow-Origin: *');
    header('Content-Type: application/json');

    include_once '../../config/Database.php';
    include_once '../../models/Author.php';

    //Instantiate DB & connect
    $database = new Database();
    $db = $database->connect();

    //Instantiate Author object
    $author = new Author($db);

    // Category read query
    $result = $author->read();

    //get row count
    $num = $result->rowCount();

    //check if any categories
    if( $num > 0) {
        //initialize category array
        $auth_arr = array();
        //$auth_arr['data'] = array();

        while($row = $result->fetch(PDO::FETCH_ASSOC)) {
            extract($row);

            $auth_item = array(
                'id' => $id,
                'author' => $author
                
            );

            //Push to "data"
            //array_push($auth_arr['data'],$auth_item);
            array_push($auth_arr,$auth_item);
        }
        //turn it to JSON & output
        echo json_encode($auth_arr);
    } else {
        //no categories
        echo json_encode(
            array('message' => 'No Authors Found')
        );
    }