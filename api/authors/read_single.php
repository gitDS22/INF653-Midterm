<?php 

    //Headers
    header('Access-Control-Allow-Origin: *');
    header('Content-Type: application/json');

    include_once '../../config/Database.php';
    include_once '../../models/Author.php';

    //Instantiate DB & connect
    $database = new Database();
    $db = $database->connect();

    //Instantiate blog post object
    $author = new Author($db);

    //Get ID from URL
    $author->id = isset($_GET['id']) ? $_GET['id'] : die();

    if($author->read_single()) {
        $auth_arr = array(
            'id'=> $author->id,
        'author' => $author->author
    );
    print_r(json_encode($auth_arr));
    }
    else {
        echo json_encode(
            array('message' => 'authorId Not Found')
        );
    }

    /*//Call read_single method from POST.php
    $author->read_single();

    //json data, create array
    $auth_arr = array(
        'id'=> $author->id,
    'author' => $author->author,
    
);

    //convert to JSON data
    print_r(json_encode($auth_arr));*/